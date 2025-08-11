<?php
add_filter( 'manage_listar_claim_posts_columns', 'listar_claim_post_columnns' );

function listar_claim_post_columnns( $columns ) {
	$columns[ 'status' ] = esc_html__( 'Status', 'listar' );
	return $columns;
}

add_action( 'manage_listar_claim_posts_custom_column', 'listar_claim_post_column', 10, 2 );

function listar_claim_post_column( $column, $post_id ) {

	// Image column
	if ( 'status' === $column ) {

		$claimed_listing_id = get_post_meta( $post_id, 'listar_meta_box_listing_id', true );
		$status = get_post_status( $post_id );
		$hash = listar_generate_wordpress_hash( $post_id );
		
		// Prepare base approval URL.
		$approval_url = listar_generate_claim_moderation_urls( $claimed_listing_id, $hash )[0];
		
		// Prepare base decline URL.
		$decline_url = listar_generate_claim_moderation_urls( $claimed_listing_id, $hash )[1];

		if ( 'publish' === $status ) :
			?>
			<span class="listar-approved-claim">
				<?php echo esc_html__( 'Approved', 'listar' ); ?>
			</span>
			<?php
		elseif ( 'pending' === $status ) :
			?>
			<a class="button listar-approve-claim" href="<?php echo esc_url( $approval_url ); ?>">
				<?php echo esc_html__( 'Approve', 'listar' ); ?>
			</a>
			<a class="button listar-decline-claim" href="<?php echo esc_url( $decline_url ); ?>">
				<?php echo esc_html__( 'Decline', 'listar' ); ?>
			</a>
			<?php
		else :
			?>
			<span class="listar-declined-claim">
				<?php echo esc_html__( 'Declined', 'listar' ); ?>
			</span><br>
			<a class="button listar-approve-claim" href="<?php echo esc_url( $approval_url ); ?>">
				<?php echo esc_html__( 'Approve', 'listar' ); ?>
			</a>
		<?php
		endif;
	}
}

add_action( 'transition_post_status', 'listar_transition_post_change', 10, 3 );


function listar_transition_post_change( $new_status, $old_status, $post ) {
	
	if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) ) :
		
		if ( 'shop_order' === $post->post_type ) :
			if ( 'wc-completed' === $new_status ) {
				
				$order_id   = $post->ID;
				$order      = wc_get_order( $order_id );
				$order_data = $order->get_data(); // The Order data
				$items      = $order->get_items();

				foreach ( $items as $item ) {

					$product = wc_get_product( $item['product_id'] );
					$is_claim_order = listar_get_woo_order_value( $item, 'meta_data', 'listar_is_claim' );

					if ( '1' === $is_claim_order && $product->is_type( array( 'job_package', 'job_package_subscription' ) ) ) {
						
						/* Capture needed values from order to generate the claim post */
						/* To gererate the claim, certain 'claim related' values need to be present on the order */

						$claimed_listing_id = listar_get_woo_order_value( $item, 'meta_data', 'listar_claimed_listing_id' );

						if ( ! empty( $claimed_listing_id ) ) {
							$new_author_id          = $order->get_user_id();
							$user_info              = get_userdata( $new_author_id );
							$author_billing_name    = isset( $order_data['billing']['first_name'] ) ? $order_data['billing']['first_name'] : '';
							$author_account_name    = $user_info->first_name;
							$new_author_name        = ! empty( $author_billing_name ) ? $author_billing_name : $author_account_name;
							$new_author_nickname    = $user_info->user_login;
							$author_billing_email   = isset( $order_data['billing']['email'] ) ? $order_data['billing']['email'] : '';
							$author_account_email   = $user_info->user_email;
							$new_author_email       = ! empty( $author_billing_email ) ? $author_billing_email : $author_account_email;
							$verification_details   = listar_get_woo_order_value( $item, 'meta_data', 'listar_claim_verification_details' );
							$author_account_website = $user_info->user_url;
							$new_package_id         = $item->get_product_id();
							$new_job_duration       = $product->get_duration();
							
							if ( ! $new_job_duration ) {
								$new_job_duration = absint( get_option( 'job_manager_submission_duration' ) );
							}
							
							/* Format: 2021-02-12 */
							$new_job_expires_string = $new_job_duration ? date( 'Y-m-d', strtotime( "+{$new_job_duration} days", current_time( 'timestamp' ) ) ) : '';
							$new_is_featured = $product->is_job_listing_featured();
							$new_user_package_id = wc_paid_listings_give_user_package( $new_author_id, $new_package_id, $order_id );
     
							$claim_data = array(
								'verification_details'   => $verification_details,
								'listing_id'             => $claimed_listing_id,

								/* New values */
								'new_author_name'        => $new_author_name,
								'new_author_nickname'    => $new_author_nickname,
								'new_author_id'          => $new_author_id,
								'new_author_email'       => $new_author_email,
								'new_author_phone'       => isset( $order_data['billing']['phone'] ) ? $order_data['billing']['phone'] : '',
								'new_author_website'     => $author_account_website,
								'new_package_id'         => $new_package_id,
								'new_user_package_id'    => $new_user_package_id,
								'new_order_id'           => $order_id,
								/* Depends on Woo product (the package itself) */
								'new_job_duration'       => $new_job_duration,
								'new_job_expires_string' => $new_job_expires_string,
								'new_is_featured'        => $new_is_featured,
								/* Claim status */
								'new_job_claim_status'   => 'claimed',
							);
					
							listar_create_claim_post( $claim_data );
							wc_paid_listings_increase_package_count( $new_author_id, $new_user_package_id );
						}
					}
					
					/* Automatically approve listings after order be completed */

					if ( 0 === 1 && 1 === (int) get_option( 'listar_auto_approve_paid_listings' ) ) {
						if ( $product->is_type( array( 'job_package', 'job_package_subscription' ) ) ) {
							$temp_1 = end( $item );
							$temp = (array) end( $temp_1 ) ;
							$data = end( $temp );

							if ( isset( $data['key'] ) && isset( $data['value'] ) && '_job_id' === $data['key'] ) {
								$id = $data['value'];

								wp_update_post( array(
									'ID' => $id,
									'post_status' => 'publish',
								) );
							}
						}
					}
				}
			}
		endif;
		
		if ( 'listar_claim' === $post->post_type ) :
			$claim_post_id = $post->ID;
			
			/* Capture listing ID of this claim post (via meta field), this value was generated via listar_create_claim_post() */
			$claimed_listing_id = get_post_meta( $claim_post_id, 'listar_meta_box_listing_id', true );
		
			if ( $claimed_listing_id ) {
		
				if ( 'publish' === $new_status ) {

					/* Capture claim/listing values of this claim post (via meta fields), these values were generated via listar_create_claim_post() */
					$woo_product_package_id = get_post_meta( $claim_post_id, 'listar_meta_box_new_package_id', true );
					$order_id = get_post_meta( $claim_post_id, 'listar_meta_box_new_order_id', true );
					$new_author_id = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_id', true );

					/**************************************************************/

					$user_package_id = wc_paid_listings_give_user_package( $new_author_id, $woo_product_package_id, $order_id );
					$package = wc_get_product( $woo_product_package_id );
					$is_featured = false;

					if ( $package instanceof WC_Product_Job_Package || $package instanceof WC_Product_Job_Package_Subscription ) {
						$is_featured = $package->is_job_listing_featured();
					}

					wc_paid_listings_approve_listing_with_package( $claimed_listing_id, $new_author_id, $user_package_id );

					wp_update_post( array(
						'ID' => $claimed_listing_id,
						'post_author' => $new_author_id,
						'post_status' => 'publish',
					) );

					// Give job the package attributes
					update_post_meta( $claimed_listing_id, '_job_duration', $package->get_duration() );
					update_post_meta( $claimed_listing_id, '_job_expires', calculate_job_expiry( $claimed_listing_id ) );
					update_post_meta( $claimed_listing_id, '_featured', $is_featured ? 1 : 0 );
					update_post_meta( $claimed_listing_id, '_package_id', $woo_product_package_id );
					update_post_meta( $claimed_listing_id, '_user_package_id', $user_package_id );
					update_post_meta( $claimed_listing_id, '_job_businessclaim', 'claimed' );

					if ( $package && $package instanceof WC_Product_Job_Package_Subscription && 'listing' === $package->get_package_subscription_type() ) {
						update_post_meta( $claimed_listing_id, '_job_expires', '' ); // Never expire automatically
					}
				} elseif ( 'draft' === $new_status || 'pending' === $new_status || 'trash' === $new_status ) {

					/* Capture claim/listing values of this claim post (via meta fields), these values were generated via listar_create_claim_post() */
					/* Old values */
					$old_package_id = get_post_meta( $claim_post_id, 'listar_meta_box_last_package_id', true );
					$old_order_id = get_post_meta( $claim_post_id, 'listar_meta_box_last_order_id', true );
					$last_user_package_id = get_post_meta( $claimed_listing_id, '_user_package_id', true );
					$last_author_id = get_post_meta( $claim_post_id, 'listar_meta_box_last_author_id', true );
	
					if ( empty( $old_package_id ) ) {
						$old_package_id = get_post_meta( $claimed_listing_id, '_package_id', true );
					}
	
					if ( empty( $old_order_id ) && ! empty( $last_user_package_id ) ) {
						$last_user_package = wc_paid_listings_get_user_package( $last_user_package_id );
						$old_order_id = isset( $last_user_package->order_id ) ? $last_user_package->order_id : '';
						
						if ( empty( $old_order_id ) ) {
							global $wpdb;
							$package = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wcpl_user_packages WHERE id = %d;", $last_user_package_id ) );
							$old_order_id = isset( $package->order_id ) ? $package->order_id : '';
						}
					}

					$old_job_duration = get_post_meta( $claim_post_id, 'listar_meta_box_last_job_duration', true );
					$old_job_expires_string = get_post_meta( $claim_post_id, 'listar_meta_box_last_job_expires', true );
					$old_is_featured = get_post_meta( $claim_post_id, 'listar_meta_box_last_featured', true );
					$old_job_claim_status = get_post_meta( $claim_post_id, 'listar_meta_box_last_job_businessclaim', true );

					if ( 'draft' === $new_status || 'trash' === $new_status ) {
						
						$current_claim_status = get_post_meta( $claimed_listing_id, '_job_businessclaim', true );
						
						if ( 'draft' === $new_status || ( 'trash' === $new_status && 'awaiting-moderation' === $current_claim_status ) ) :
							$old_user_package_id = wc_paid_listings_give_user_package( $last_author_id, $old_package_id, $old_order_id );
							$package = wc_get_product( $old_package_id );

							wc_paid_listings_approve_listing_with_package( $claimed_listing_id, $last_author_id, $old_user_package_id );

							wp_update_post( array(
								'ID' => $claimed_listing_id,
								'post_author' => $last_author_id,
								'post_status' => 'publish',
							) );

							// Give job the package attributes
							update_post_meta( $claimed_listing_id, '_job_duration', $old_job_duration );
							update_post_meta( $claimed_listing_id, '_job_expires', $old_job_expires_string );
							update_post_meta( $claimed_listing_id, '_featured', $old_is_featured );
							update_post_meta( $claimed_listing_id, '_package_id', $old_package_id );
							update_post_meta( $claimed_listing_id, '_user_package_id', $old_user_package_id );
							update_post_meta( $claimed_listing_id, '_job_businessclaim', $old_job_claim_status );

							if ( $package && $package instanceof WC_Product_Job_Package_Subscription && 'listing' === $package->get_package_subscription_type() ) {
								update_post_meta( $claimed_listing_id, '_job_expires', '' ); // Never expire automatically
							}
						endif;
					} else {
						update_post_meta( $claimed_listing_id, '_job_businessclaim', 'awaiting-moderation' );
					}
				}
				
				if ( 'draft' === $new_status || 'pending' === $new_status || 'publish' === $new_status || ( 'trash' === $new_status && 'awaiting-moderation' === $current_claim_status ) ) {
					listar_claimer_moderation_send_email( $claim_post_id, $claimed_listing_id, listar_get_claim_status_translated( $claim_post_id ) );
				}
			}
				
		endif;
	endif;
}

add_action( 'wp', 'listar_approve_post' );

/**
 * Create a claim post after a Woocommerce order receive the 'completed' status.
 *
 * @since 1.0
 * @param (array) $claim_data The claim data, captured from Woocommerce order.
 * @return (array)
 */
function listar_create_claim_post( $claim_data ) {

	$verification_details = $claim_data['verification_details'];
	$claimed_listing_id = $claim_data['listing_id'];
	$claimed_listing_permalink = get_permalink( $claimed_listing_id );

	/* New claim/listing values *******************************************/
	$new_author_name = $claim_data['new_author_name'];
	$new_author_nickname = $claim_data['new_author_nickname'];
	$new_author_id = $claim_data['new_author_id'];
	$new_author_email = $claim_data['new_author_email'];
	$new_author_phone = $claim_data['new_author_phone'];
	$new_author_website = $claim_data['new_author_website'];
	$new_package_id = $claim_data['new_package_id'];
	$new_order_id = $claim_data['new_order_id'];
	$new_job_duration = $claim_data['new_job_duration'];
	$new_job_expires_string = $claim_data['new_job_expires_string'];
	$new_is_featured = $claim_data['new_is_featured'];
	$new_job_claim_status = $claim_data['new_job_claim_status'];
	$new_user_package_id = $claim_data['new_user_package_id'];

	/* Old claim/listing values *******************************************/
	$last_author_id = get_post_field( 'post_author', $claimed_listing_id );
	$last_user_info = get_userdata( $last_author_id );
	$last_author_name = isset( $last_user_info->first_name ) && ! empty( $last_user_info->first_name ) ? $last_user_info->first_name : get_the_author_meta( 'user_nicename', $last_author_id );
	$last_author_nickname = $last_user_info->user_login;
	$last_author_email = $last_user_info->user_email;
	$last_author_website = $last_user_info->user_url;
	$last_package_id = get_post_meta( $claimed_listing_id, '_package_id', true );
	$last_user_package_id = get_post_meta( $claimed_listing_id, '_user_package_id', true );
	$last_order_id = '';
	
	if ( ! empty( $last_user_package_id ) ) {
		global $wpdb;
		$package = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wcpl_user_packages WHERE id = %d;", $last_user_package_id ) );
		$last_order_id = isset( $package->order_id ) ? $package->order_id : '';
	}
	
	$last_job_duration = get_post_meta( $claimed_listing_id, '_job_duration', true );
	
	if ( empty( $last_job_duration ) ) {
		$last_job_duration = absint( get_option( 'job_manager_submission_duration' ) );
	}
	
	$last_job_expires_string = get_post_meta( $claimed_listing_id, '_job_expires', true );
	
	if ( empty( $last_job_expires_string ) ) {
		$last_job_expires_string = calculate_job_expiry( $claimed_listing_id );
	}

	$last_is_featured = get_post_meta( $claimed_listing_id, '_featured', true );
	$last_job_claim_status = get_post_meta( $claimed_listing_id, '_job_businessclaim', true );
	
	if ( empty( $last_job_claim_status ) ) {
		$last_job_claim_status = 'not-claimed';
	}

	$new_post = array(
		'post_title' => get_the_title( $claimed_listing_id ),
		'post_status' => 'pending',
		'post_author' => $new_author_id,
		'post_type' => 'listar_claim',
	);

	$claim_post_id = wp_insert_post( $new_post );

	update_post_meta( $claim_post_id, 'listar_meta_box_verification_details', $verification_details );
	update_post_meta( $claim_post_id, 'listar_meta_box_listing_id', $claimed_listing_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_listing_permalink', $claimed_listing_permalink );
	update_post_meta( $claim_post_id, 'listar_meta_box_useful_claim_links', '' );

	// Save data from new author
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_name', $new_author_name );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_nickname', $new_author_nickname );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_email', $new_author_email );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_phone', $new_author_phone );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_website', $new_author_website );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_author_id', $new_author_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_order_id', $new_order_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_package_id', $new_package_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_user_package_id', $new_user_package_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_job_duration', $new_job_duration );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_job_expires', $new_job_expires_string );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_featured', $new_is_featured );
	update_post_meta( $claim_post_id, 'listar_meta_box_new_job_businessclaim', $new_job_claim_status );

	// Save data from old author
	update_post_meta( $claim_post_id, 'listar_meta_box_last_author_name', $last_author_name );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_author_nickname', $last_author_nickname );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_author_email', $last_author_email );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_author_website', $last_author_website );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_author_id', $last_author_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_order_id', $last_order_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_package_id', $last_package_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_user_package_id', $last_user_package_id );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_job_duration', $last_job_duration );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_job_expires', $last_job_expires_string );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_featured', $last_is_featured );
	update_post_meta( $claim_post_id, 'listar_meta_box_last_job_businessclaim', $last_job_claim_status );
							
	update_post_meta( $claimed_listing_id, '_job_businessclaim', 'awaiting-moderation' );
	
	listar_claim_admin_moderation_send_email( $claim_post_id, $claimed_listing_id, $new_order_id, $new_author_id, $last_author_id );// Send the email.
	listar_claimer_moderation_send_email( $claim_post_id, $claimed_listing_id, listar_get_claim_status_translated( $claim_post_id ) );
}


add_filter( 'wcpl_get_job_packages_args', 'listar_filter_listing_packages', 20, 2 );

if ( ! function_exists( 'listar_filter_listing_packages' ) ) :
	/**
	 * Reorder and filter Listing Packages.
	 *
	 * @since 1.0
	 * @param (array) $args Query Args.
	 * @return (array)
	 */
	function listar_filter_listing_packages( $args ) {
		$args['order'] = 'ASC';
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = '_regular_price';

		$args['meta_query'][] = array(
			array(
				'key'     => '_regular_price',
				'compare' => '=',
				'type'    => 'NUMERIC',
			),
			array(
				'relation' => 'OR',
				array(
					'key'     => '_use_for_claims',
					'value'   => '',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => '_use_for_claims',
					'value'   => 'yes',
					'compare' => '!=',
				),
			),
		);

		if ( listar_is_claiming_listing() ) :
			$args['meta_query'] = array(
				array(
					'key'     => '_regular_price',
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
				array(
					'key'     => '_use_for_claims',
					'value'   => 'yes',
					'compare' => '=',
				),
			);
		endif;
		
		return $args;
	}

endif;



/* Add "Use as claim package" If Job Package selected. */
add_filter( 'product_type_options', 'listar_add_job_package_use_for_claims_options' );

function listar_add_job_package_use_for_claims_options( $product_type_options ) {
	$product_type_options['use_for_claims'] = array(
		'id'            => '_use_for_claims',
		'wrapper_class' => 'show_if_job_package show_if_job_package_subscription',
		'label'         => __( 'Use as Claim Package', 'listar' ),
		'description'   => __( 'If checked, this package will only appear if a listing is being claimed.', 'listar' ),
		'default'       => 'no',
	);
	return $product_type_options;
}

add_action( 'woocommerce_process_product_meta_job_package', 'listar_save_claim_data', 20 );
add_action( 'woocommerce_process_product_meta_job_package_subscription', 'listar_save_claim_data', 20 );

function listar_save_claim_data( $post_id ) {

	/* Save Product Data Type Options. Product type options do not have "value" attr. */
	$for_claims = isset( $_POST['_use_for_claims'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_use_for_claims', $for_claims );

	/* if use for claim */
	if ( 'yes' == $for_claims ) {

		/* Set job listing limit to 1 */
		update_post_meta( $post_id, '_job_listing_limit', 1 );

		/* Set listing subs package to "listing" */
		update_post_meta( $post_id, '_package_subscription_type', 'listing' );
	}
}

add_filter( 'woocommerce_get_item_data', 'listar_cart_item_data_output', 999, 2 );

function listar_cart_item_data_output( $data, $cart_item ) {
	if ( isset( $cart_item['job_id'] ) && isset( $cart_item['claim_id'] ) ) {
		$name = '';

		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$name = $user->display_name;
		}
		
		$data[] = array(
			'name'  => __( 'Claim By', 'listar' ),
			'value' => $name,
		);
	}
	return $data;
}

add_action( 'wp', 'listar_handle_claim_package', 10 );

if ( ! function_exists( 'listar_handle_claim_package' ) ) :
	/**
	 * Add the claim package to cart.
	 *
	 * @since 1.4.1
	 */
	function listar_handle_claim_package() {
		$is_claiming_listing = listar_is_claiming_listing();

		if ( $is_claiming_listing && ! listar_is_claim_enabled() ) :
			wp_redirect( network_site_url() );
		elseif ( $is_claiming_listing && is_user_logged_in() ) :
			$claim_listing_id = get_query_var( 'claim_listing_id' );
			$claim_package_id = get_query_var( 'claim_package_id' );
			
			if ( ! empty( $claim_package_id ) ) :
				if ( listar_listing_is_claimable( $claim_listing_id ) ) :
					$claim_validation_text = '';
					$session_main_key = 'listar_user_search_options';

					if ( isset( $_SESSION[ $session_main_key ]['claim_validation_text'] ) ) {
						$claim_validation_text = $_SESSION[ $session_main_key ]['claim_validation_text'];
					}

					/* Add product to cart with all info needed. */
					WC()->cart->empty_cart();
					WC()->cart->remove_coupons();

					WC()->cart->add_to_cart(
						$claim_package_id,

						/* Qty */
						1, 

						/* Variation ID */
						'',

						/* Variation */
						array(), 

						/* Cart item data */
						array(
							'listar_is_claim'                   => '1',
							'job_id'                            => $claim_listing_id,
							'claim_id'                          => $claim_package_id,
							'listar_claimed_listing_id'         => $claim_listing_id,
							'listar_claim_verification_details' => wp_unslash( $claim_validation_text ),
						)
					);

					/* Redirect to checkout */
					wp_redirect( esc_url_raw( wc_get_checkout_url() ) );
					exit;
				else :
					wp_redirect( network_site_url() );
				endif;
			endif;
		endif;
	}
endif;

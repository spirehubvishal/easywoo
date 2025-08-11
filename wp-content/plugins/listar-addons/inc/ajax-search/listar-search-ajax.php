<?php
/**
 * Return listing card content with Ajax.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$ajax_data = filter_input( INPUT_POST, 'send_data' );
$return_data = array();
$obj = '';
$origin = '';
$listar_data_type = '';
$listar_listing_id = '';
$listar_search_has_input = false;

// Is the request coming from same domain?

if ( array_key_exists( 'HTTP_ORIGIN', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_ORIGIN'];
} elseif ( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

if ( ! empty( $origin ) && false !== strpos( $origin, '://' ) ) {
	$temp = explode( '://', $origin );
	$origin = $temp[1];

	if ( ! empty( $origin ) ) {
		$site_url = network_site_url();
		
		if ( false === strpos( $site_url, $origin ) ) {
			listar_close_section();
			die();
		}
	} else {
		listar_close_section();
		die();
	}
} else {
	listar_close_section();
	die();
}

if( ! empty( $ajax_data ) ) {
	$obj = json_decode( wp_unslash( $ajax_data ) );
} else {
	listar_close_section();
	die();
}

if ( empty( $obj ) ) :
	listar_close_section();
	die();
endif;

listar_register_sessions( false, true );

$session_main_key = 'listar_user_search_options';

$_SESSION[ $session_main_key ]['listar-ajax-search'] = '1';

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		if ( 'type' === $key ) {
			$listar_data_type = $data;
		} 
		
		if (
			's' === $key
			|| 'post_type' === $key // OK.
			|| 'search_type' === $key // OK.
			|| 'listing_sort' === $key // OK.
			|| 'explore_by' === $key // OK.
			|| 'selected_country' === $key // OK.
			|| 'saved_address' === $key // No usage currently.
			|| 'saved_postcode' === $key // No usage currently.
			|| 'listing_regions' === $key // OK.
			|| 'listing_categories' === $key // OK.
			|| 'listing_amenities' === $key // OK.
		) {
			$_SESSION[ $session_main_key ][ 'listar-ajax-search-' . $key ] = $data;
		}
		
		if ( 's' === $key && ! empty( $data ) ) {
			$listar_search_has_input = true;
		}
		
		/* Modify main session search values? */
		
		if ( $listar_search_has_input ) :

			if ( 'post_type' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_post_type'] = $data;
			}

			if ( 'search_type' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_search_type'] = $data;
			}

			if ( 'selected_country' === $key ) {
				$listar_fallback_country = '0';
				$get_explore_by_country = $data;
		
				if ( empty( $get_explore_by_country ) && '0' !== $get_explore_by_country ) {
					$get_explore_by_country = '';
				}

				if ( ! ( ! empty( $get_explore_by_country ) || '0' === $get_explore_by_country ) ) {
					$get_explore_by_country = $listar_fallback_country;
				}

				$_SESSION[ $session_main_key ]['explore_by_country'] = $get_explore_by_country ;

				$listar_current_explore_by_country_name = listar_current_explore_by_country_name( $_SESSION[ $session_main_key ]['explore_by_country'] );
				$_SESSION[ $session_main_key ]['explore_by_country_name'] = $listar_current_explore_by_country_name;
			}
		
			if ( 'listing_sort' === $key ) {
				$_SESSION[ $session_main_key ]['sort_order'] = $data;
			}

			if ( 'explore_by' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by'] = $data;
				
				if ( 'near_address' === $data  ) {
					$last_explore_by_address = isset( $_SESSION[ $session_main_key ]['explore_by_address'] ) ? $_SESSION[ $session_main_key ]['explore_by_address'] : '';
					$_SESSION[ $session_main_key ]['last_explore_by_address'] = $last_explore_by_address;
					
					$current_explore_by_address = listar_current_search_address_session( $_SESSION[ $session_main_key ][ 'listar-ajax-search-s' ] );
					$_SESSION[ $session_main_key ]['explore_by_address'] = $current_explore_by_address;
	
					$current_explore_by_address_coordinates = listar_current_search_address_coordinates_session( $_SESSION[ $session_main_key ][ 'listar-ajax-search-s' ] );
					$_SESSION[ $session_main_key ]['explore_by_address_geocoded_lat'] = $current_explore_by_address_coordinates[0];
					$_SESSION[ $session_main_key ]['explore_by_address_geocoded_lng'] = $current_explore_by_address_coordinates[1];
				}
				
				if ( 'near_postcode' === $data  ) {
					$last_explore_by_postcode = isset( $_SESSION[ $session_main_key ]['explore_by_postcode'] ) ? $_SESSION[ $session_main_key ]['explore_by_postcode'] : '';
					$_SESSION[ $session_main_key ]['last_explore_by_postcode'] = $last_explore_by_postcode;
					
					$current_explore_by_postcode = listar_current_search_postcode_session( $_SESSION[ $session_main_key ][ 'listar-ajax-search-s' ] );
					$_SESSION[ $session_main_key ]['explore_by_postcode'] = $current_explore_by_postcode;
	
					$current_explore_by_postcode_coordinates = listar_current_search_postcode_coordinates_session( $_SESSION[ $session_main_key ][ 'listar-ajax-search-s' ] );
					$_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lat'] = $current_explore_by_postcode_coordinates[0];
					$_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lng'] = $current_explore_by_postcode_coordinates[1];					
				}
			}

			if ( 'listing_regions' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_selected_regions'] = $data;
			}

			if ( 'listing_categories' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_selected_categories'] = $data;
			}

			if ( 'listing_amenities' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_selected_amenities'] = $data;
			}

			if ( 'listing_amenities' === $key ) {
				$_SESSION[ $session_main_key ]['explore_by_selected_amenities'] = $data;
			}
		endif;
		
	}
}

if ( $listar_search_has_input ) :
	
	$post_type = 'job_listing';

	if ( 'blog' === $_SESSION[ $session_main_key ]['explore_by_search_type'] ) {
		$post_type = 'post';
	}

	if ( 'shop_products' === $_SESSION[ $session_main_key ]['explore_by_search_type'] ) {
		$post_type = 'product';
	}
	
	$args = array(
		's'              => $_SESSION[ $session_main_key ][ 'listar-ajax-search-s' ],
		'post_status'    => 'publish',
		'post_type'      => $post_type,
		'ajax_query'     => '1',
		'posts_per_page' => 20,
	);
	
	if ( 'product' === $post_type ) {
		$args['tax_query'] = array( array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array( 'job_package', 'job_package_subscription' ),
			'operator' => 'NOT IN',
		) );
	}

	if ( 'job_listing' === $post_type ) {
		//echo $post_type;
		listar_doing_listing_ajax_search( true );
	}
	
	$exec_query = new WP_Query( $args );
	?>

	<?php
	if ( $exec_query->have_posts() && 'ajax-search' === $listar_data_type ) :
		?>
		<span class="hidden listar-has-ajax-posts"></span>
		<?php
		while ( $exec_query->have_posts() ) :
			$exec_query->the_post();
		
			$listar_reviews_average            = '';
			$has_reviews_average               = 'listar-search-has-no-review-average';
		
			$listar_current_post_id            = $post->ID;
			$listar_category_name              = '';
			$listar_category_color             = str_replace( '#', '', listar_theme_color() );
			$listar_blank_placeholder          = listar_blank_base64_placeholder_image();
			$listar_post_image                 = get_the_post_thumbnail_url( $listar_current_post_id, 'thumbnail' );

			$listar_fallback_card_image        = '';
			$listar_temp_bg_image              = '';
			$listar_bg_image                   = '';

			if ( 'job_listing' === $post_type ) :
				$listar_fallback_card_image        = listar_image_url( get_option( 'listar_listing_card_fallback_image' ), 'thumbnail' );
				$listar_temp_bg_image              = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
				$listar_bg_image                   = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;

				if ( taxonomy_exists( 'job_listing_category' ) ) :
					$featured_category = esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_category', true ) );
					$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
					$has_featured_category = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;

					$listar_category_id    = $has_featured_category ? $featured_category_term->term_id : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'id' );
					$listar_category_name  = $has_featured_category ? $featured_category_term->name : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'name' );
					$listar_category_color = listar_term_color( $listar_category_id, true );
				endif;
			endif;

			if ( 'post' === $post_type ) :
				$listar_fallback_card_image  = listar_image_url( get_option( 'listar_blog_card_fallback_image' ), 'thumbnail' );
				$listar_temp_bg_image        = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
				$listar_bg_image             = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;
				$postcat                     = get_the_category( $post->ID );
				$listar_category_name        = isset( $postcat[0]->name ) && ! empty( $postcat[0]->name ) ? $postcat[0]->name : '';
			endif;

			if ( 'product' === $post_type ) :
				$listar_fallback_card_image  = listar_image_url( get_option( 'listar_product_card_fallback_image' ), 'thumbnail' );
				$listar_temp_bg_image        = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
				$listar_bg_image             = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;
				$postcat                     = get_the_terms( $listar_current_post_id, 'product_cat' );
				$listar_category_name        = isset( $postcat[0]->name ) && ! empty( $postcat[0]->name ) ? $postcat[0]->name : '';
			endif;

			if ( empty( $listar_category_name ) ) {
				$listar_category_name = esc_html__( 'Uncategorized', 'listar' );	
			}
			
			if ( 'job_listing' === $post_type ) :
				$listar_reviews_average = listar_reviews_average( $listar_current_post_id );
				$has_reviews_average = ! empty( $listar_reviews_average ) ? 'listar-search-has-review-average' : 'listar-search-has-no-review-average';
			endif;
			
			?>
			<li class="menu-item menu-item-type-taxonomy menu-item-object-job_listing_category listar-strong <?php echo esc_attr( listar_sanitize_html_class( $has_reviews_average ) ); ?>">
				<a href="<?php the_permalink(); ?>">
					<div class="listar-cat-icon <?php echo esc_attr( listar_sanitize_html_class( 'fal fa-camera' ) ); ?>" style="background-color:#<?php echo esc_attr( $listar_category_color ); ?>;border-color:#<?php echo esc_attr( $listar_category_color ); ?>">
						<img class="listar-ajax-listing-img" alt="<?php the_title(); ?>" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" style="background-image:url(<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>);" />
					</div>
					<?php
					if ( 'job_listing' === $post_type ) :
						$listar_reviews_average = listar_reviews_average( $listar_current_post_id );
					
						if ( false !== $listar_reviews_average ) :
							?>
							<div class="listar-listing-rating">
								<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
							</div>
							<?php
						endif;
					endif;
					?>
					<div class="listar-menu-item-title-wrapper">
						<span>
							<?php the_title(); ?>
						</span>
						<?php
						if ( ! empty( $listar_category_name ) ) :
							?>
							<span class="listar-menu-item-description">
								<span>
									<?php echo esc_html( $listar_category_name ); ?>
								</span>
							</span>
							<?php
						endif;
						?>
					</div>
				</a>
			</li>
			<?php
		endwhile;

		wp_reset_postdata();

	endif;

	$_SESSION[ $session_main_key ]['listar-ajax-search'] = '0';
endif;

listar_close_section();

die();

<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Listar_Addons
 */




if ( ! function_exists( 'listar_is_vendor_authorized_expired_listing' ) ) :
	function listar_is_vendor_authorized_expired_listing( $post ) {
		$verified_packages = array();
		$listing_id = $post->ID;
		$user_id = isset( $post->post_author ) ? $post->post_author : '';
		$woo_product_id = get_post_meta( $listing_id, '_package_id', true );
		$job_package_id = get_post_meta( $listing_id, '_user_package_id', true );
		$listar_vendor_store_disable = get_option( 'listar_who_can_create_stores' );
		$total_allowed_listings = 0;

		if ( empty( $listar_vendor_store_disable ) ) {
			$listar_vendor_store_disable = 'listing-package-membership';
		}

		if ( empty( $user_id ) || empty( $woo_product_id ) || empty( $job_package_id ) || 'listing-package-membership' !== $listar_vendor_store_disable ) {
			return false;
		}		

		// Step 1 - Verify if user has product packages with listings available to be published currently and if the
		// Woocommerce Product behind these packages allows the creation of stores. If yes, check the amount of listings remaining on the package.

		$condition1 = listar_get_user_available_package_products( $user_id );
		$temp_count = -1;

		if ( ! empty( $condition1 ) && isset( $condition1[1] ) && true === $condition1[1] && ! empty( $condition1[0] ) ) {
			foreach ( $condition1[0] as $woo_product_id ) {
				$temp_count++;

				if ( ! empty( $woo_product_id ) && ! in_array( $woo_product_id, $verified_packages ) ) {
					$verified_packages[] = $woo_product_id;				
					$disabled_package_options = listar_addons_active() && ! empty( $woo_product_id ) ? listar_get_package_options_disabled( $woo_product_id ) : array();
					$job_package_id = $condition1[2][ $temp_count ];

					if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
						$package = wc_paid_listings_get_user_package( $job_package_id );
						$remain = $package->get_limit() ? absint( $package->get_limit() - $package->get_count() ) : 999999;
					
						if ( 999999 === $remain || $remain > 0 ) {
							return false;
						}
						
						$total_allowed_listings += $package->get_limit();
					endif;
				}
			}
		}
		
		//update_user_meta( 11, 'listar_meta_box_drafted_products', 3 );

		// Step 2 - Count all expired listings of the user and if the
		// Woocommerce Product behind these listings allows the creation of stores.

		$count_expired = 0;
		$condition2 = listar_get_user_woo_package_products_via_listings_published( $user_id, 'expired' );
		$expired_listing_ids = isset( $condition2[2] ) ? $condition2[2] : array();

		if ( ! empty( $condition2 ) && isset( $condition2[1] ) && true === $condition2[1] && ! empty( $condition2[0] ) && ! empty( $expired_listing_ids ) ) {
			foreach ( $condition2[0] as $woo_product_id ) {
				if ( ! empty( $woo_product_id ) && ! in_array( $woo_product_id, $verified_packages ) ) {
					$verified_packages[] = $woo_product_id;
					$disabled_package_options = listar_addons_active() && ! empty( $woo_product_id ) ? listar_get_package_options_disabled( $woo_product_id ) : array();
					
					if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
						$count_expired++;
					endif;
				}
			}
		}

		return $count_expired >= $total_allowed_listings;
	}
endif;

function listar_draft_products( $user_id = 0, $status = 'draft' ) {
	// Change the post status of all user Woocomerce products from 'publish' to 'draft' and save the IDs.

	global $wpdb;

	$woo_product_ids = array();
	$woo_product_drafted_ids = '';
	$woo_product_ids2 = array();
	
	if ( 'draft' === $status ) {
		$woo_product_ids = $wpdb->get_results( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish' AND post_author = '" . $user_id . "'" );

		foreach( $woo_product_ids as $item ) {
			$woo_product_ids2[] = $item->ID;
		}

		foreach( $woo_product_ids2 as $woo_product_id ) {
			$woo_product_drafted_ids .= $woo_product_id . ',';
		}

		if ( ! empty( $woo_product_drafted_ids ) ) {
			$woo_product_drafted_ids_old = get_the_author_meta( 'listar_meta_box_drafted_products', $user_id );
			$woo_product_drafted_ids = substr( $woo_product_drafted_ids, 0, -1 );

			if ( ! empty( $woo_product_drafted_ids_old ) ) {
				$woo_product_drafted_ids = $woo_product_drafted_ids . ',' . $woo_product_drafted_ids_old;
			}

			update_user_meta( $user_id, 'listar_meta_box_drafted_products', $woo_product_drafted_ids );
		}
		
	} else {
		$drafted_products = get_the_author_meta( 'listar_meta_box_drafted_products', $user_id );
		
		if ( ! empty( $drafted_products ) && is_string( $drafted_products ) ) {
			if ( false !== strpos( $drafted_products, ',' ) ) {
				$woo_product_ids2 = array_filter( explode( ',', $drafted_products ) );
			} else {
				$woo_product_ids2 = array( trim( $drafted_products ) );
			}
			
			update_user_meta( $user_id, 'listar_meta_box_drafted_products', '' );
		}
	}

	foreach( $woo_product_ids2 as $woo_product_id ) {
		$update_post = array(
			'post_type'   => 'product',
			'ID'          => $woo_product_id,
			'post_status' => $status,
		);

		wp_update_post( $update_post );
	}
}


add_action( 'transition_post_status', 'listar_transition_post_status', 10, 3 );

function listar_transition_post_status( $new_status, $old_status, $post ) {
	
	if ( $old_status == $new_status ) {
		return;
	}
	
	// false means that the user has listings active or remaining listings under a Woocomemrce listing packages (product) that allows stores.
	// true means that the user has achieved the maximum listing limit of all Woocommer listing packages (products) that allow stores and these listings has been all expired.
	
	if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) && listar_is_wcfm_active() && listar_is_wcfmmp_active() ) :
		
		if ( 'job_listing' === $post->post_type ) :
			
			$user_id = isset( $post->post_author ) ? $post->post_author : 'none';
			
			if ( 'expired' === $new_status ) :	
				if ( ! listar_is_vendor( $user_id ) ) :
					return;
				endif;
				
				if ( true === listar_is_vendor_authorized_expired_listing( $post ) ) :
					listar_draft_products( $user_id );
				endif;
			elseif ( 'publish' === $new_status ) :
				if ( listar_is_vendor_authorized( $user_id ) ) {	
					listar_draft_products( $user_id, 'publish' );
				}
			endif;
		endif;
		
		if ( 'shop_order' === $post->post_type ) :
			if ( 'wc-completed' === $new_status ) {
				$order_id   = $post->ID;
				$order      = wc_get_order( $order_id );
				$user_id    = $order->get_user_id();
				$items      = $order->get_items();

				foreach ( $items as $item ) {
					$product = wc_get_product( $item['product_id'] );
					
					if ( ! empty( $user_id ) && $product->is_type( array( 'job_package', 'job_package_subscription' ) ) ) {
						if ( listar_is_vendor_authorized( $user_id ) ) {	
							listar_draft_products( $user_id, 'publish' );
						}
					}
				}
			}
		endif;
	endif;
}

add_action( 'init', function () {
	//listar_is_vendor_authorized_expired_listing( get_post( 11183 ) );
	//update_user_meta( 11, 'listar_meta_box_drafted_products', listar_is_vendor_authorized_expired_listing( get_post( 11183 ) ) );
} );


//add_filter( 'get_terms', 'listar_set_term_multiselect_max_opts' );

function listar_set_term_multiselect_max_opts( $terms ){
	
	//echo 4444444;
	$terms = array_slice( $terms, 0, 100 ); 
	//printf('<pre>%s</pre>', var_export($terms,true));
	
	if ( ! is_admin() ) :
		
	endif;

	return $terms;
}

/* 
* Increase the limit of posts per page in json
*/
add_filter( 'rest_tag_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_category_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_product_cat_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_product_tag_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_job_listing_category_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_job_listing_region_query', 's976_rest_cats_per_page', 2, 10 );
add_filter( 'rest_job_listing_amenity_query', 's976_rest_cats_per_page', 2, 10 );
function s976_rest_cats_per_page( array $prepared_args, WP_REST_Request $request ){
    //$cats_per_page = $request->get_param('s976_per_page') ? $request->get_param('s976_per_page') : 10;
    $prepared_args['number'] = 99;
    return $prepared_args;
}

//add_filter( 'get_terms_args', 'listar_filter_get_terms_args', 99999 );

function listar_filter_get_terms_args( $args ) {
	if ( ! isset( $args['number'] ) || empty( $args['number'] ) ) {
		$args['number'] = 2000;
	}
}
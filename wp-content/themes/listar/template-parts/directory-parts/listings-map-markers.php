<?php
/**
 * Template part to create and output map markers as JSON
 * This JSON is used to populate the Leaflet map.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$map_enabled = listar_is_map_enabled();

if ( $map_enabled ) :
	global $post;

	$listar_listing_ids = array();
	$listar_markers     = '';
	$listar_category    = '';
	$listar_region      = '';
	$listar_icon        = '';
	$listar_is_single   = isset( $post->ID ) ? is_single( $post->ID ) : 0;


	/* If default WordPress loop **************************************************/

	$listar_current_listings = listar_static_current_listings();

	if ( ! empty( $listar_current_listings ) ) {
		$listar_listing_ids = $listar_current_listings;
	}

	/* If new listings were queried with Ajax *************************************/

	$listar_ajax_listings = listar_static_map_markers_ajax();

	if ( ! empty( $listar_ajax_listings ) ) {
		$listar_listing_ids = $listar_ajax_listings;
	}

	/* Get listing(s) data ********************************************************/

	$listar_count_listing_ids = is_array( $listar_listing_ids ) ? count( $listar_listing_ids ) : 0;

	for ( $listar_listings_i = 0; $listar_listings_i < $listar_count_listing_ids; $listar_listings_i++ ) {
		$listar_current_post_id = $listar_listing_ids[ $listar_listings_i ];
		$listar_listing_title   = listar_excerpt_limit( get_the_title( $listar_current_post_id ), 80, false, '', true );
		$listar_thumb           = listar_custom_esc_url( get_the_post_thumbnail_url( $listar_current_post_id, 'large' ) );
		$listar_logo            = listar_custom_esc_url( get_post_meta( $listar_current_post_id, '_company_logotype', true ) );
		$listar_address         = listar_get_listing_address( $listar_current_post_id );
		$listar_lat             = listar_get_listing_latitude( $listar_current_post_id );
		$listar_lng             = listar_get_listing_longitude( $listar_current_post_id );
		$listar_reviews         = wp_kses( listar_reviews_average( $listar_current_post_id ), 'listar-basic-html' );
		$listar_rating          = ! empty( $listar_reviews ) ? $listar_reviews : 0;
		$listar_listing_url     = esc_url( ! $listar_is_single ? get_permalink( $listar_current_post_id ) : '' );
		$listar_term_id         = 0;
		$claim_status           = listar_listing_claim_status( $listar_current_post_id );
		$show_claim             = 'claimed' === $claim_status;

		if ( taxonomy_exists( 'job_listing_category' ) ) {
			$featured_category      = esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_category', true ) );
			$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
			$has_featured_category  = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;

			$listar_category     = $has_featured_category ? $featured_category_term->name : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'name' );
			$listar_icon         = listar_icon_class( listar_term_icon_from_post( $listar_current_post_id, 'job_listing_category', $has_featured_category ) );
			$listar_term_id      = $has_featured_category ? $featured_category_term->term_id : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'id' );
		}

		if ( taxonomy_exists( 'job_listing_region' ) ) {
			$allow_multiple_regions = 1 === (int) get_option( 'listar_allow_multiple_regions_frontend' );
			$featured_region        = $allow_multiple_regions ? esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_region', true ) ) : '';
			$featured_region_term   = ! empty( $featured_region ) ? get_term_by( 'id', $featured_region, 'job_listing_region' ) : false;
			$has_featured_region    = isset( $featured_region_term->term_id ) && isset( $featured_region_term->name ) ? $featured_region_term : false;

			$listar_region        = $has_featured_region ? $featured_region_term->name : listar_first_term_data( $listar_current_post_id, 'job_listing_region', 'name' );
		}

		$listar_markers .= '{';

		if ( ! empty( $listar_listing_title ) ) {
			$listar_markers .= '"title": ' . wp_json_encode( $listar_listing_title ) . ',';
		}

		$listar_markers .= '"listingID": ' . wp_json_encode( $listar_current_post_id ) . ',';

		if ( ! empty( $listar_address ) ) {
			$listar_markers .= '"address": ' . wp_json_encode( $listar_address ) . ',';
		}

		if ( ! empty( $listar_lat ) ) {
			$temp_lat = $gallery_str = preg_replace( '/[^0-9\.-]/', '', $listar_lat );
			$listar_markers .= '"lat": ' . wp_json_encode( $temp_lat ) . ',';
		}

		if ( ! empty( $listar_lng ) ) {
			$temp_lng = $gallery_str = preg_replace( '/[^0-9\.-]/', '', $listar_lng );
			$listar_markers .= '"lng": ' . wp_json_encode( $temp_lng ) . ',';
		}

		if ( ! empty( $listar_thumb ) ) {
			$listar_markers .= '"img": ' . wp_json_encode( $listar_thumb ) . ',';
		}

		if ( ! empty( $listar_logo ) ) {
			$listar_markers .= '"logo": ' . wp_json_encode( $listar_logo ) . ',';
		}

		if ( ! empty( $listar_category ) ) {
			$listar_category_color = listar_term_color( $listar_term_id );
			$listar_markers .= '"category": ' . wp_json_encode( $listar_category ) . ',';
			$listar_markers .= '"categoryColor": ' . wp_json_encode( $listar_category_color ) . ',';
		}

		if ( ! empty( $listar_region ) ) {
			$listar_markers .= '"region": ' . wp_json_encode( $listar_region ) . ',';
		}

		if ( ! empty( $listar_icon[0] ) || ! empty( $listar_icon[1] ) ) {
			$listar_icon_class = 'listar-image-icon' === $listar_icon[0] ? '' : $listar_icon[0];
			$listar_markers .= '"icon": ' . wp_json_encode( $listar_icon_class . $listar_icon[1] ) . ',';
		}

		if ( ! empty( $listar_rating ) ) {
			$listar_markers .= '"rating": ' . wp_json_encode( $listar_rating ) . ',';
		}

		if ( listar_is_listing_trending( $listar_current_post_id ) ) {
			$listar_markers .= '"trending": "1",';
		}

		if ( $show_claim && listar_is_claim_enabled() ) :
			$listar_markers .= '"claimed": "1",';
		endif;

		if ( ! empty( $listar_listing_url ) ) {
			$listar_markers .= '"link": ' . wp_json_encode( $listar_listing_url );
		}

		$listar_markers .= '},';
	} // End for().

	if ( false !== strpos( $listar_markers, ',' ) ) {

		if ( ',' === substr( rtrim( $listar_markers ), -1 ) ) {
			$listar_markers = substr( $listar_markers, 0, -1 );
		}
	}

	if ( ! empty( $listar_markers ) ) {

		/* Save current map markers on static variable */
		listar_static_map_markers( $listar_markers );

		/* Output map markers */
		listar_output_map_markers();
	}

endif;
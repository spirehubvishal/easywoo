<?php
/**
 * Update operating hours and status for listings.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$ajax_data = filter_input( INPUT_POST, 'my_data' );
$return_data = array();
$skip_by_value = false;
$obj = '';
$origin = '';

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

foreach ( $obj as $item ) {
	foreach ( $item as $key => $listing_id ) {
		if ( 'single-listing-page' === $key ) {
			$skip_by_value = $listing_id;

			$data = listar_company_operation_hours_availability( $listing_id, true );
			$return_data[ $listing_id ]['id'] = $listing_id;
			$return_data[ $listing_id ]['status'] = ! empty( $data[0] ) ? $data[0] : '';
			$return_data[ $listing_id ]['statushtml'] = ! empty( $data[1] ) ? $data[1] : '';
			$return_data[ $listing_id ]['hourstablehtml'] = ! empty( $data[2] ) ? $data[2] : '';
			$return_data[ $listing_id ]['iconclass'] = ! empty( $data[3] ) ? $data[3] : '';
			continue;
		}

		if ( $listing_id === $skip_by_value ) {
			continue;
		} else {
			$data = listar_company_operation_hours_availability( $listing_id, false );
			$return_data[ $listing_id ]['id'] = $listing_id;
			$return_data[ $listing_id ]['status'] = ! empty( $data[0] ) ? $data[0] : '';
			$return_data[ $listing_id ]['statushtml'] = ! empty( $data[1] ) ? $data[1] : '';
			$return_data[ $listing_id ]['hourstablehtml'] = ! empty( $data[2] ) ? $data[2] : '';
			$return_data[ $listing_id ]['iconclass'] = ! empty( $data[3] ) ? $data[3] : '';
		}
	}
}

echo wp_json_encode( $return_data );

listar_close_section();
exit();

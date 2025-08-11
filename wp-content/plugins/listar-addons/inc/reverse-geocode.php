<?php
/**
 * Update operating hours and status for listings.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$ajax_data = filter_input( INPUT_POST, 'send_data' );
$return_data = array();
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

$geolocation_type = 'coordinates';
$latitude = '';
$longitude = '';

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		
		if ( 'type' === $key ) {
			$geolocation_type = $data;
		} 
		
		if ( 'latitude' === $key ) {
			$latitude = $data;
		} 
		
		if ( 'longitude' === $key ) {
			$longitude = $data;
		} 
		
		if ( 'coordinates' === $geolocation_type && ! empty( $latitude ) && ! empty( $longitude ) ) {

			$geo = listar_mapplus_geolocate( $latitude, $longitude, get_locale() );

			$return_data = array(
				'geolocated'                    => $geo['geolocated'],
				'geolocation_city'              => $geo['geolocation_city'],
				'geolocation_country_long'      => $geo['geolocation_country_long'],
				'geolocation_country_short'     => $geo['geolocation_country_short'],
				'geolocation_formatted_address' => $geo['geolocation_formatted_address'],
				'geolocation_lat'               => $geo['geolocation_lat'],
				'geolocation_long'              => $geo['geolocation_long'],
				'geolocation_postcode'          => $geo['geolocation_postcode'],
				'geolocation_state_long'        => $geo['geolocation_state_long'],
				'geolocation_state_short'       => $geo['geolocation_state_short'],
				'geolocation_street'            => $geo['geolocation_street'],
				'geolocation_street_number'     => $geo['geolocation_street_number'],
			);
		}
	}
}

echo wp_json_encode( $return_data );

listar_close_section();
exit();

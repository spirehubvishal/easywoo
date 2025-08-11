<?php
/**
 * Get geolocated data by cURL
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
else :
	$contents = listar_connect_curl( 'http://www.geoplugin.net/json.gp' );

	if ( ! empty( $contents ) ) {
		$return_data = $contents;
	}
endif;

echo wp_json_encode( $return_data );

listar_close_section();
exit();

<?php
/**
 * Get geolocated data for current user.
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

$geolocation_type = '';
$geolocation_latitude = '';
$geolocation_longitude = '';
$session_main_key = 'listar_user_search_options';

listar_register_sessions( false, true );

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		
		if ( 'type' === $key ) {
			$geolocation_type = $data;
			continue;
		} 
		
		if ( 'latitude' === $key ) {
			$geolocation_latitude = $data;
			continue;
		} 
		
		if ( 'longitude' === $key ) {
			$geolocation_longitude = $data;
			continue;
		} 
		
		if ( 'saveNearestMe' === $key ) {
			if ( 'save' === $data ) {
				if ( isset( $_SESSION[ $session_main_key ] ) ) {
					$_SESSION[ $session_main_key ]['explore_by']  = 'nearest_me';
					$_SESSION[ $session_main_key ]['sort_order'] = 'nearest_me';
				}
			}

			continue;
		} 
		
		if ( false !== strpos( $geolocation_type, 'address' ) ) {
			$geo = listar_get_geolocated_data_by_address( $data );

			if ( ! empty( $geo ) ) {	
				$return_data[ $key ]['order'] = $key;
				$return_data[ $key ]['lat'] = $geo['geolocation_lat'];
				$return_data[ $key ]['lng'] = $geo['geolocation_long'];
				$return_data[ $key ]['address'] = $geo['geolocation_street'];
				$return_data[ $key ]['number'] = $geo['geolocation_street_number'];
				$return_data[ $key ]['region'] = $geo['geolocation_city'] . ' ' . $geo['geolocation_state_long'];
				$return_data[ $key ]['country'] = $geo['geolocation_country_long'];
			
				if ( false !== strpos( $geolocation_type, 'address-save' ) ) {

					if ( isset( $_SESSION[ $session_main_key ] ) ) {

						/* Searches by nearest me =========================== */
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address']  = $return_data[ $key ]['address'];
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number']   = $return_data[ $key ]['number'];
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region']   = $return_data[ $key ]['region'];
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country']  = $return_data[ $key ]['country'];
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat']      = $geo['geolocation_lat'];
						$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng']      = $geo['geolocation_long'];
					}
				}
			}
		}
		
		if ( 'reset' === $geolocation_type ) {
			$session_main_key = 'listar_user_search_options';

			if ( isset( $_SESSION[ $session_main_key ] ) ) {

				/* Searches by nearest me =========================== */
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address']  = '';
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number']   = '';
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region']  = '';
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country']  = '';
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat']      = '';
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng']      = '';
				
				if ( 'nearest_me' === $_SESSION[ $session_main_key ]['explore_by'] || 'nearest_me' === $_SESSION[ $session_main_key ]['sort_order'] ) {
					$_SESSION[ $session_main_key ]['explore_by'] = listar_get_initial_explore_by_filter();
					$_SESSION[ $session_main_key ]['sort_order'] = listar_get_initial_sort_order();
				}
			}
		}
	}
}

echo wp_json_encode( $return_data );

listar_close_section();
exit();

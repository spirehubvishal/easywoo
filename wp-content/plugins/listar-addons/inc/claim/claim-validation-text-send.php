<?php
/**
 * Update operating hours and status for listings.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../../wp-load.php';
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

$claim_validation_text = '';

listar_register_sessions( false, true );

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		
		if ( 'text' === $key ) {
			
			/* @link (alternative) https://stackoverflow.com/a/15638250/7765298 */
			$claim_validation_text = rawurldecode( $data );
			continue;
		}
	}
}

$session_main_key = 'listar_user_search_options';

if ( isset( $_SESSION[ $session_main_key ] ) ) {
	$_SESSION[ $session_main_key ]['claim_validation_text'] = $claim_validation_text;
}

echo esc_html( 'listar-valid-ajax-process-completed' );

exit();

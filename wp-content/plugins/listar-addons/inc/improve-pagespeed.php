<?php
/**
 * Set the better Pagespeed settings for this WordPress theme.
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

if ( ! isset( $obj[0]->action ) || empty( $obj[0]->action ) ) :
	listar_close_section();
	die();
endif;

$action = $obj[0]->action;

/* Is the current user an administrator? */

if ( ! current_user_can( 'administrator' ) ) :
	listar_close_section();
	die();
endif;

/* Prepare to open and get file content */

listar_create_filesystem();

global $listar_filesystem;

$keep_cache = (int) get_option( 'listar_keep_cache_on_changes' );
$pagespeed_enabled = (int) get_option( 'listar_activate_pagespeed' );

if ( 0 === $keep_cache ) {
	listar_clean_cache( $action );
}

if ( 1 === $pagespeed_enabled ) {
	listar_async_javascript_pagespeed( $action );
	listar_autoptimize_pagespeed( $action );
	listar_wp_fastest_cache_pagespeed( $action );
}

listar_domain_has_favicon( $action );
listar_increase_pagespeed_resources( $action );

echo esc_html( 'Done' ); /* No need for translation here */

listar_close_section();
exit();

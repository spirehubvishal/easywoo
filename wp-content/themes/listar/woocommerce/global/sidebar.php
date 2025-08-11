<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$listar_sidebar = is_singular( 'product' ) ? 'shop-product' : 'shop';

if ( is_singular( 'product' ) ) {
	$input = get_option( 'listar_enable_woo_product_sidebar' );

	if ( 'archive' === $input ) {
		$input = get_option( 'listar_enable_woo_archive_sidebar' );
		$listar_sidebar = 'shop';
	}
}

if ( ! ( ! is_active_sidebar( $listar_sidebar ) || ! is_dynamic_sidebar( $listar_sidebar ) ) ) :
	dynamic_sidebar( $listar_sidebar );
endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

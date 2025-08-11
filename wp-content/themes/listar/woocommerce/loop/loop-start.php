<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $WCFMmp;

$input = get_option( 'listar_enable_woo_archive_sidebar' );
$listar_sidebar_position = '';

if ( empty( $input ) ) {
	$input = 'disabled';
} else {
	$listar_sidebar_position = 'listar-sidebar-position-' . $input;
}

$listar_is_marketplace_store_page = listar_is_wcfm_active() && wcfm_is_store_page();
$listar_has_sidebar = is_active_sidebar( 'shop' ) && is_dynamic_sidebar( 'shop' ) && 'disabled' !== $input ? true : false;
$listar_col_length  = $listar_has_sidebar ? 'listar-floated-content col-md-8 col-xs-12' : 'col-md-12';

if ( $listar_is_marketplace_store_page ) {
	$store_sidebar_active = $WCFMmp->wcfmmp_vendor->is_store_sidebar();
	$listar_has_sidebar = is_active_sidebar( 'sidebar-wcfmmp-store' ) && is_dynamic_sidebar( 'sidebar-wcfmmp-store' ) && $store_sidebar_active ? true : false;
	$listar_col_length  = 'col-md-12';
}
?>
<div class="row <?php echo esc_attr( listar_sanitize_html_class( $listar_sidebar_position ) ); ?>">
	<div class="<?php echo esc_attr( listar_sanitize_html_class( $listar_col_length ) ); ?>">
		<!-- Start Products Container  -->
		<div class="listar-main-block woo-products-container">
			<div class="row listar-grid listar-white-design listar-results-container">

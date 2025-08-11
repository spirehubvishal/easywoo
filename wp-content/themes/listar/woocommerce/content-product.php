<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $WCFMmp;

/* Ensure visibility. */
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$listar_product_id   = $product->get_id();
$listar_post_design  = ' listar-no-image';  /* CSS class to set white background as default */
$listar_description  = $product->get_description();
$listar_woo_currency = listar_currency();
$listar_price_before = get_post_meta( $listar_product_id, '_regular_price', true );
$listar_price_after  = get_post_meta( $listar_product_id, '_sale_price', true );
$listar_ribbon       = '';
$listar_cards_design = get_option( 'listar_woo_card_design' );
$admission           = $product->is_type( 'booking' ) && class_exists( 'WC_Bookings' ) ? $product->wc_booking_cost : '';
$thousand_separator = class_exists( 'Woocommerce' ) ? wc_get_price_thousand_separator() : ',';
$decimal_separator = class_exists( 'Woocommerce' ) ? wc_get_price_decimal_separator() : '.';
		
if ( 'default' === $listar_cards_design ) {
	$listar_cards_design = get_option( 'listar_listing_card_design' );
		
	if ( empty( $listar_cards_design ) ) {
		$listar_cards_design = 'rounded';
	}
		
	if ( 'rounded-image-block' === $listar_cards_design ) {
		$listar_cards_design = 'rounded-image-block-top';
	}
		
	if ( 'squared-image-block' === $listar_cards_design ) {
		$listar_cards_design = 'squared-image-block-top';
	}

	if ( 'rounded' === $listar_cards_design || 'squared' === $listar_cards_design ) {
		$listar_cards_design = 'default';
	}
}
		
if ( empty( $listar_cards_design ) ) {
	$listar_cards_design = 'rounded-image-block-top';
}

$listar_cards_design_class = false !== strpos( $listar_cards_design, '-image-block' ) ? 'listar-grid-design-image-block' : '';

if ( false !== strpos( $listar_cards_design, '-image-block' ) ) :
	if ( false !== strpos( $listar_cards_design, '-bottom' ) ) {
		$listar_cards_design_class .= ' listar-card-image-block-bottom listar-card-image-block-hidden-footer';
	}

	if ( false !== strpos( $listar_cards_design, '-short' ) ) {
		$listar_cards_design_class .= ' listar-card-image-block-short';
	}

	if ( false !== strpos( $listar_cards_design, 'squared' ) ) {
		$listar_cards_design_class .= ' listar-squared-details';
	}

	if ( false !== strpos( $listar_cards_design, 'rounded' ) ) {
		$listar_cards_design_class .= ' listar-rounded-details';
	}
endif;

if ( ! empty( $listar_price_before ) || ! empty( $listar_price_after ) || ! empty( $admission ) ) :

	$listar_ribbon = '<div class="listar-ribbon">';

	if ( ! empty( $admission ) ) {
		$listar_ribbon .= esc_html__( 'Offer By ', 'listar' ) . $listar_woo_currency . $admission;
	}
	elseif ( ! empty( $listar_price_after ) ) {		
		$listar_price_after = listar_price_custom_output( $listar_price_after, $thousand_separator, $decimal_separator );
		$listar_price_before = listar_price_custom_output( $listar_price_before, $thousand_separator, $decimal_separator );
		$listar_ribbon .= esc_html__( 'Discount ', 'listar' ) . '<span class="listar-ribbon-price-before">' . $listar_woo_currency . $listar_price_before . '</span>';
		$listar_ribbon .= ' ' . $listar_woo_currency . $listar_price_after;
	} else {
		$listar_ribbon .= esc_html__( 'Offer By ', 'listar' ) . $listar_woo_currency . $listar_price_before;
	}

	$listar_ribbon .= '</div>';

endif;

/* Don' show Job Listing packages on shop */
if ( 'job_package' === $product->post_type ) :
	return;
endif;

$input = get_option( 'listar_enable_woo_archive_sidebar' );

if ( empty( $input ) ) {
	$input = 'disabled';
}

$listar_is_marketplace_store_page = listar_is_wcfm_active() && wcfm_is_store_page();
$listar_has_sidebar = is_active_sidebar( 'shop' ) && is_dynamic_sidebar( 'shop' ) && 'disabled' !== $input ? true : false;
$listar_col_length  = $listar_has_sidebar ? 'col-xs-12 col-md-6 ' : 'col-xs-12 col-sm-6 col-md-4 ';

if ( $listar_is_marketplace_store_page ) {
	$store_sidebar_active = $WCFMmp->wcfmmp_vendor->is_store_sidebar();
	$listar_has_sidebar = is_active_sidebar( 'sidebar-wcfmmp-store' ) && is_dynamic_sidebar( 'sidebar-wcfmmp-store' ) && $store_sidebar_active ? true : false;
	$listar_col_length  = $listar_has_sidebar ? 'col-xs-12 col-md-6 ' : 'col-xs-12 col-sm-6 col-md-4 ';
}
?>
<!-- Start Product Item Col -->
<div <?php wc_product_class( $listar_col_length . $listar_cards_design_class . ' ' . 'listar-grid-design-2 listar-woo-product-card' ); ?>>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'listar-card-content' . $listar_post_design ); ?>>

		<?php if ( false !== strpos( $listar_cards_design, '-image-block' ) ) :
			?>
			<div class="listar-card-design-image-block"></div>
			<?php
		endif;
		?>
		
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>

	</article>

</div>
<!-- End Product Item Col -->

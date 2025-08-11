<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$listar_cards_design_class = 'listar-sorting-margin-bottom';

?>
<div class="row listar-woo-sorting <?php echo esc_attr( listar_sanitize_html_class( $listar_cards_design_class ) ); ?>">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<form class="woocommerce-ordering" method="get">
			<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'listar' ); ?>">
				<?php foreach ( $catalog_orderby_options as $listar_woo_id => $listar_woo_name ) : ?>
					<option value="<?php echo esc_attr( $listar_woo_id ); ?>" <?php selected( $orderby, $listar_woo_id ); ?>><?php echo esc_html( $listar_woo_name ); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
		</form>
	</div>
</div>

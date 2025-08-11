<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$listar_woo_total   = isset( $listar_woo_total ) ? $listar_woo_total : wc_get_loop_prop( 'total_pages' );
$listar_woo_current = isset( $listar_woo_current ) ? $listar_woo_current : wc_get_loop_prop( 'current_page' );
$listar_woo_base    = isset( $listar_woo_base ) ? $listar_woo_base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$listar_woo_format  = isset( $listar_woo_format ) ? $listar_woo_format : '';

echo 5555;

if ( $listar_woo_total <= 1 ) {
	return;
}
?>
<section class="listar-section listar-section-no-padding-bottom listar-load-more-section listar-pagination-section">
	<div class="row">
		<div class="col-sm-12">
			<nav class="navigation listar-woocommerce-navigation posts-navigation listar-navigation">
				<?php
				echo wp_kses(
					paginate_links(
						apply_filters(
							'woocommerce_pagination_args',
							array( // WPCS: XSS ok.
								'base'         => $listar_woo_base,
								'format'       => $listar_woo_format,
								'add_args'     => false,
								'current'      => max( 1, $listar_woo_current ),
								'total'        => $listar_woo_total,
								'prev_text'    => '<span class="icon-chevron-left"></span>',
								'next_text'    => '<span class="icon-chevron-right"></span>',
								'type'         => 'list',
								'end_size'     => 3,
								'mid_size'     => 3,
							)
						)
					),
					'listar-basic-html'
				);
				?>
			</nav>
		</div>
	</div>
</section>

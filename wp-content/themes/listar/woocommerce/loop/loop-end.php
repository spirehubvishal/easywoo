<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
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
 * @version 2.0.0
 */

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}
		?>
		</div></div>
		<!-- End Products Container  -->
	</div>
	
	<?php
	$input = get_option( 'listar_enable_woo_archive_sidebar' );
	
	if ( empty( $input ) ) {
		$input = 'disabled';
	}
	
	$listar_is_marketplace_store_page = listar_is_wcfm_active() && wcfm_is_store_page();
	$listar_has_sidebar = is_active_sidebar( 'shop' ) && is_dynamic_sidebar( 'shop' ) ? true : false;
	$listar_sidebar_position = '';
	
	if ( $listar_has_sidebar && 'disabled' !== $input && ! $listar_is_marketplace_store_page ) :
		?>
		<aside id="secondary" class="col-md-4 col-xs-12 listar-sidebar-right">
			<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			?>
		</aside>
		<?php
	endif;
	?>

</div>

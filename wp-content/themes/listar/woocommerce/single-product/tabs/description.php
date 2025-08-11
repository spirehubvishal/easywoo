<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$listar_woo_heading = apply_filters( 'woocommerce_product_description_heading', esc_html__( 'Description', 'listar' ) );

?>

<?php if ( $listar_woo_heading ) : ?>
	<h2><?php echo esc_html( $listar_woo_heading ); ?></h2>
<?php endif; ?>

<?php the_content();

listar_edit_post_link();
?>

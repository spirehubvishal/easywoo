<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listar
 */

if ( ! is_active_sidebar( 'listar-blog-sidebar' ) || ! is_dynamic_sidebar( 'listar-blog-sidebar' ) ) :
	return;
endif;
?>

<div class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'listar-blog-sidebar' ); ?>
</div><!-- #secondary -->

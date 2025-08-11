<?php
/**
 * The template for displaying search results archive
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

get_header( 'general' );
get_template_part( 'template-parts/blog-parts/blog', 'grid' );
listar_get_footer_extended();
get_footer();

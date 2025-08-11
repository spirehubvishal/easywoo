<?php
/**
 * The template for displaying search results archive to listings
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

get_header( 'general' );
get_template_part( 'template-parts/directory-parts/listings', 'grid' );
listar_get_footer_extended();
get_footer();

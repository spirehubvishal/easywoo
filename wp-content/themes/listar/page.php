<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

get_header( 'general' );
get_template_part( 'template-parts/content', 'page' );
listar_get_footer_extended();
get_footer();

<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the homepage when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $wp_query;

get_header( 'general' );

$listar_current_post_type = $wp_query->get( 'post_type' );

/*
 * Use custom 'listings-grid.php' template if querying listings
 * Otherwise, use default 'blog-grid.php'
 */
$listar_template = 'job_listing' === $listar_current_post_type ? 'directory-parts/listings' : 'blog-parts/blog';
get_template_part( 'template-parts/' . $listar_template, 'grid' );

listar_get_footer_extended();
get_footer();

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Listar
 */

get_header( 'general' );

get_template_part( 'template-parts/blog-parts/single-parts/content', 'article' );

listar_get_footer_extended();
get_footer();

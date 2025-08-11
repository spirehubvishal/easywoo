<?php
/**
 * Template Name: Medium Width Page
 *
 * The template for displaying pages with 760px of width.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

get_header( 'general' );
get_template_part( 'template-parts/content', 'page' );
listar_get_footer_extended();
get_footer();

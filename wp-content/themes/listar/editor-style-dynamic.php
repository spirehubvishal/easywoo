<?php
/**
 * Receive values sent via GET method to create dynamic styles to WordPress TinyMCE editor.
 *
 * The two Google Font families and the theme color of this file are dynamically/automatically updated when user changes:
 *
 * - Google Fonts ( Customize / Google Fonts )
 * - Theme Color ( Customize / Colors )
 *
 * This stylesheet respects the recommended method to include Google Fonts into WordPress.
 * See: listar_google_fonts_url() in functions.php.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @package Listar
 */

header( 'Content-Type: text/css' );

/* Get dynamic values from GET */

$listar_query_decoded  = urldecode( filter_input( INPUT_GET, 'dynamic_values', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']) );
$listar_dynamic_values = array_filter( explode( '|', $listar_query_decoded ) );

/*
 * After cleaned by array_filter(), the $listar_dynamic_values array must contain "5" not empty values:
 * [0] The theme color (RGB), ex.: 38,163,135
 * [1] Body (primary) Google Font name, ex.: Roboto
 * [2] Headings (secondary) Google Font name, ex.: Quicksand
 * [3] Make headings (secondary) Google Font bold, it contains a font weight: 700 or 500
 * [4] A random string (cache breaker), ex.: 7C412467&wp-mce-4711-20180425
 */

$listar_count_params = is_array( $listar_dynamic_values ) ? count( $listar_dynamic_values ) : 0;

if ( 5 !== $listar_count_params ) :
	die();
endif;

/* Theme Color ( Customize / Theme Color ) */
$listar_theme_color_rgb = $listar_dynamic_values[0];

/* Body (Primary) Google Font ( Customize / Google Fonts ) */
$listar_body_font_family = $listar_dynamic_values[1];

/* Headings (Secondary) Google Font ( Customize / Google Fonts ) */
$listar_headings_font_family = $listar_dynamic_values[2];

/* Make secondary (headings) Google Font bold? */
$listar_headings_font_bold = $listar_dynamic_values[3];
?>

/**************************** Styles with Theme Color *************************/

a,
a:hover,
a:focus,
body.webkit h1 strong, /* Based on wp-content.css ( 'body' is needed here ) */
body.webkit h1 b,
body.webkit h2 strong,
body.webkit h2 b,
body.webkit h3 strong,
body.webkit h3 b,
body.webkit h4 strong,
body.webkit h4 b,
body.webkit h5 strong,
body.webkit h5 b,
body.webkit h6 strong,
body.webkit h6 b {
	color: rgb(<?php echo filter_var( $listar_theme_color_rgb, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>);
}

<?php

/* Dont proceed if built in Google Fonts manager is inactive on Theme Options */
if ( 'inactive' === $listar_body_font_family ) :
	die();
endif;
?>

/************ Styles with Body (Primary) Google Font of the Theme *************/

body,
html .mceContentBody,
blockquote p cite {
	font-family: "<?php echo filter_var( $listar_body_font_family, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>", sans-serif;
	font-weight: normal;
}

/********** Styles with Headings (Secondary) Google Font of the Theme *********/

h1,h2,h3,h4,h5,h6,
blockquote p,
thead th,
tbody th,
dt,
strong {
	font-family: "<?php echo filter_var( $listar_headings_font_family, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>", sans-serif;
	font-weight: <?php echo filter_var( $listar_headings_font_bold, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>;
}

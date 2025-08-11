<?php
/**
 * Receive values sent via GET method to create dynamic styles to WordPress Gutenberg editor.
 *
 * The two Google Font families and the theme color of this file are dynamically/automatically updated when user changes:
 *
 * - Google Fonts ( Customize / Google Fonts )
 * - Theme Color ( Customize / Colors )
 *
 * This stylesheet respects the recommended method to include Google Fonts into WordPress.
 * See: listar_google_fonts_url() in functions.php.
 *
 * - Theme Color ( Customize / Colors )
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

/* Body (primary) Google Font ( Customize / Google Fonts ) */
$listar_body_font_family = $listar_dynamic_values[1];

/* Headings (secondary) Google Font ( Customize / Google Fonts ) */
$listar_headings_font_family = $listar_dynamic_values[2];

/* Make headings (secondary) Google Font bold, it contains a font weight: 700 or 500 */
$listar_headings_font_bold = $listar_dynamic_values[3];
?>

/**************************** Styles with Theme Color *************************/
.editor-styles-wrapper a,
.editor-styles-wrapper a:hover,
.editor-styles-wrapper a:focus,
.editor-styles-wrapper h1 strong,
.editor-styles-wrapper h1 b,
.editor-styles-wrapper h2 strong,
.editor-styles-wrapper h2 b,
.editor-styles-wrapper h3 strong,
.editor-styles-wrapper h3 b,
.editor-styles-wrapper h4 strong,
.editor-styles-wrapper h4 b,
.editor-styles-wrapper h5 strong,
.editor-styles-wrapper h5 b,
.editor-styles-wrapper h6 strong,
.editor-styles-wrapper h6 b {
	color: rgb(<?php echo filter_var( $listar_theme_color_rgb, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>);
}

.wp-block-button__link {
	background-color: rgb(<?php echo filter_var( $listar_theme_color_rgb, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>);
}

.listar-color-text-bg {
	background-color: rgb(<?php echo filter_var( $listar_theme_color_rgb, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>);
}

<?php

/* Dont proceed if built in Google Fonts manager is inactive on Theme Options */
if ( 'inactive' === $listar_body_font_family ) :
	die();
endif;
?>
/************ Styles with Body (Primary) Google Font of the Theme *************/

.editor-styles-wrapper {
	font-family: "<?php echo filter_var( $listar_body_font_family, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>", sans-serif !important; /* Important to overwrite inline CSS of WordPress */
	font-weight: normal;
}

/********** Styles with Headings (Secondary) Google Font of the Theme *********/

.editor-post-title__block .editor-post-title__input,
.wp-block-cover .editor-rich-text,
.editor-styles-wrapper h1,
.editor-styles-wrapper h2,
.editor-styles-wrapper h3,
.editor-styles-wrapper h4,
.editor-styles-wrapper h5,
.editor-styles-wrapper h6,
.wp-block-table thead th,
.wp-block-table tbody th,
.editor-styles-wrapper strong,
.has-medium-font-size,
.has-large-font-size,
.has-huge-font-size,
blockquote p,
.wp-block-quote p,
.has-drop-cap:not(:focus)::first-letter {
	font-family: "<?php echo filter_var( $listar_headings_font_family, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>", sans-serif, serif;
	font-weight: <?php echo filter_var( $listar_headings_font_bold, FILTER_CALLBACK, ['options' => 'listar_sanitize_string']); ?>;
}

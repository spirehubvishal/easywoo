<?php
/**
 * Plugin Name: Listar Add-ons
 * Description: This plugin provides some of the functionality for the Listar theme, by Web Design Trade.
 * Author: Web Design Trade
 * Author URI: https://themeforest.net/user/webdesigntrade
 * Text Domain: listar
 * Domain Path: /languages/
 * Version: 1.5.4.93
 *
 * @package Listar_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

if ( ! defined( 'LISTAR_ADDONS_VERSION' ) ) {
	define( 'LISTAR_ADDONS_VERSION', '1.5.4.93' );
}

if ( ! defined( 'LISTAR_ADDONS_ACTIVE' ) ) {
	define( 'LISTAR_ADDONS_ACTIVE', true );
}

if ( ! defined( 'LISTAR_ADDONS_PLUGIN_DIR' ) ) {
	define( 'LISTAR_ADDONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'LISTAR_ADDONS_PLUGIN_DIR_URL' ) ) {
	define( 'LISTAR_ADDONS_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

/*
 * Fix for Sessions - For iframed sites (specially the Themeforest preview iframe).
 */
	
if ( ! session_id() && PHP_SESSION_ACTIVE !== session_status()  ) {
	ini_set( 'session.cookie_samesite', 'None' );
	ini_set( 'session.cookie_httponly', 'false' );
	
	if ( is_ssl() ) {
		ini_set( 'session.cookie_secure', 'true' );
	} else {
		ini_set( 'session.cookie_secure', 'false' );
	}
}


if ( function_exists( 'session_set_cookie_params' ) && 0 === 1 ) {	
	$maxlifetime = time() + ( 60*60*24*30 ); // 30 days.
	$path = '/;SameSite=Lax';
	$host = listar_get_current_domain_url()[1];
	$samesite = '/;SameSite=Lax';
	$secure   = false; // If you only want to receive the cookie over HTTPS.
	$httponly = false; // Prevent JavaScript access to session cookie.

	if( PHP_VERSION_ID < 70300 ) {
		session_set_cookie_params( $maxlifetime, $samesite, $host, $secure, $httponly );
	} else {
		$samesite = 'Lax';

		session_set_cookie_params([
			'lifetime' => $maxlifetime,
			'path' => $path,
			'domain' => $host,
			'secure' => $secure,
			'httponly' => $httponly,
			'samesite' => $samesite
		]);
	}
}



if ( ! function_exists( 'listar_init_session' ) ) :
	/**
	 * Init PHP session.
	 *
	 * To avoid REST conflicts, sessions are being properly closed via WordPress hooks on listar-addons/inc/extras.php, by the end of the file
	 * The hooks callbacks and REST API were tested with WordPress Site Health tool.
	 *
	 * @since 1.0.0
	 */
	function listar_init_session() {
		if ( ! headers_sent() && ( ! session_id() || PHP_SESSION_NONE === session_status() ) ) {
			session_start();
		}
	}
endif;

/* General functions to 'Listar Add-ons' plugin */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'functions.php';

/* Functions in general for trending feature */
require_once LISTAR_ADDONS_PLUGIN_DIR . '/inc/trending/functions.php';

/* Listar Reviews - Built-in */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/reviews/class-listar-reviews-edit.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/reviews/class-listar-reviews-form.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/reviews/class-listar-review-output.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/reviews/class-listar-submit-review.php';

/* Bookmarks */

/* Login, registration and recover password forms */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/user-registration-forms.php';

/* Geolocated data form */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/geolocated-data-form.php';

/* Report form */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/report-form.php';

/* Social sharing buttons for blog posts and listings */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/social-share.php';

/* External links for listings */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/listing-external-links.php';

/* Menu/catalog(s) for listings */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/listing-catalog.php';

/* Private message form for listings */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/listing-private-message.php';

/* Post types */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/post-types.php';

/* Meta boxes */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/meta-boxes.php';

/* Taxonomies */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomies.php';

/* Taxonomy images */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-image/class-listar-category-image.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-image/class-listar-job-listing-category-image.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-image/class-listar-job-listing-region-image.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-image/class-listar-job-listing-amenity-image.php';

/* Taxonomy icons */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-icon/taxonomy-icon.php';

/* Taxonomy colors */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-color/taxonomy-color.php';

/* Taxonomy posts counter */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-posts-counter/taxonomy-posts-counter.php';

/* Location references for Regions */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-primary-reference-address.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-primary-reference-label.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-primary-reference-latitude.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-primary-reference-longitude.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-secondary-reference-address.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-secondary-reference-label.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-secondary-reference-latitude.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/taxonomy-location-references/taxonomy-location-secondary-reference-longitude.php';

/* Widgets */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/widgets.php';

/* Plugin integrations */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/integrations/wp-job-manager/wp-job-manager.php';
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/integrations/wp-job-manager/extras.php';

if ( listar_is_claim_enabled() ) :
	
	/* Claim form */
	require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/claim/claim-form.php';

	/* Claim */
	require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/claim/claim-custom-post-type.php';
	require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/claim/extras.php';
endif;

/* Custom functions that act independently of the theme templates */
require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/extras.php';

if ( ! function_exists( 'listar_customize_permalinks' ) ) :
	/**
	 * Set custom permalinks structure based on slugs.
	 *
	 * @since 1.0
	 */
	function listar_customize_permalinks() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );

		/* Refresh permalinks */
		flush_rewrite_rules();
	}
endif;

register_activation_hook( __FILE__, 'listar_customize_permalinks' );

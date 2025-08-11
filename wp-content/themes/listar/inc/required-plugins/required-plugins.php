<?php
/**
 * Register the required and recommended plugins for the theme
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @version    2.6.1 for parent theme Listar for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

add_action( 'tgmpa_register', 'listar_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * @since 1.0
 */
function listar_register_required_plugins() {

	$plugins = array(
		array(
			'name'     => 'WP Job Manager',
			'slug'     => 'wp-job-manager',
			'required' => true,
		),
		array(
			'name'     => 'Regions for WP Job Manager',
			'slug'     => 'wp-job-manager-locations',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/wp-job-manager-locations.zip' ),
			'required' => false,
			'version'  => '1.18.3',
		),
		array(
			'name'     => 'Envato Market',
			'slug'     => 'envato-market',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/envato-market.zip' ),
			'required' => false,
			'version'  => '2.0.10',
		),
                array(
                        'name'     => 'Listar Add-ons',
                        'slug'     => 'listar-addons',
                        'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/listar-addons.zip' ),
                        'required' => true,
                        'version'  => listar_get_theme_version(),
                ),
                array(
                        'name'     => 'Listar Customer Snippets',
                        'slug'     => 'listar-customer-snippets',
                        'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/listar-customer-snippets.zip' ),
                        'required' => false,
                        'version'  => '1.0.0',
                ),
		array(
			'name'     => 'WP Job Manager Paid Listings',
			'slug'     => 'wp-job-manager-wc-paid-listings',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/wp-job-manager-wc-paid-listings.zip' ),
			'required' => false,
			'version'  => '3.0.2',
		),
		array(
			'name'     => 'Woocommerce Subscriptions',
			'slug'     => 'woocommerce-subscriptions',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/woocommerce-subscriptions.zip' ),
			'required' => false,
			'version'  => '6.5.0',
		),
		array(
			'name'     => 'Woocommerce Bookings',
			'slug'     => 'woocommerce-bookings',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/woocommerce-bookings.zip' ),
			'required' => false,
			'version'  => '2.1.0',
		),
		array(
			'name'     => 'Custom Fields for Gutenberg',
			'slug'     => 'custom-fields-gutenberg',
			'required' => true,
		),
		array(
			'name'     => 'Woocommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'Safe SVG',
			'slug'     => 'safe-svg',
			'required' => false,
		),
		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name'     => 'Easy WP SMTP',
			'slug'     => 'easy-wp-smtp',
			'required' => false,
		),
		array(
			'name'     => 'Smash Balloon Social Photo Feed',
			'slug'     => 'instagram-feed',
			'required' => false,
		),
		array(
			'name'     => 'Loco Translate',
			'slug'     => 'loco-translate',
			'required' => false,
		),
		/*
		array(
			'name'     => 'Autoptimize',
			'slug'     => 'autoptimize',
			'required' => false,
		)*/
		array(
			'name'     => 'WP Fastest Cache',
			'slug'     => 'wp-fastest-cache',
			'required' => false,
		),
		array(
			'name'     => 'Async Javascript',
			'slug'     => 'async-javascript',
			'required' => false,
		),
		array(
			'name'     => 'Smush – Compress, Optimize and Lazy Load Images',
			'slug'     => 'wp-smushit',
			'required' => false,
		),
		array(
			'name'     => 'Listar Social Login',
			'slug'     => 'listar-social-login',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/listar-social-login.zip' ),
			'required' => false,
			'version'  => '1.2.1',
		),
		array(
			'name'     => 'WCFM – Frontend Manager',
			'slug'     => 'wc-frontend-manager',
			'required' => false,
		),
		array(
			'name'     => 'WCFM – Marketplace',
			'slug'     => 'wc-multivendor-marketplace',
			'required' => false,
		),		
		/*
		array(
			'name'     => 'WCFM – Marketplace',
			'slug'     => 'wc-multivendor-marketplace',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/wc-multivendor-marketplace.zip' ),
			'required' => false,
			'version'  => '3.6.3',
		),
		*/
		array(
			'name'     => 'WCFM – Frontend Manager Marketplace Ultimate',
			'slug'     => 'wc-frontend-manager-ultimate',
			'source'   => listar_get_theme_file_path( '/inc/required-plugins/plugins/wc-frontend-manager-ultimate.zip' ),
			'required' => false,
			'version'  => '6.7.5',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'listar', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true, // Show admin notices or not.
		'dismissable'  => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message'      => '', // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

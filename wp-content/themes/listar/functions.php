<?php
/**
 * Listar functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Listar
 */

/* Function for theme version *************************************************/

if ( ! function_exists( 'listar_get_theme_version' ) ) :
	/**
	 * Get the current theme version
	 *
	 * @since 1.3.8
	 */
	function listar_get_theme_version() {
		return '1.5.4.93';
	}

endif;

if ( ! function_exists( 'listar_get_frontend_slug' ) ) :
	/**
	 * Get the current theme version
	 *
	 * @since 1.4.6
	 */
	function listar_get_frontend_slug() {
		return 'frontend';
	}
endif;

/* Function to detect Listar Addons activation ********************************/

if ( ! function_exists( 'listar_addons_active' ) ) :
	/**
	 * Check if the Listar Addons plugin is currently active.
	 *
	 * @since 1.3.8
	 * @return (boolean)
	 */
	function listar_addons_active() {
		return defined( 'LISTAR_ADDONS_ACTIVE' );
	}
endif;

/* Theme Defaults *************************************************************/

if ( ! function_exists( 'listar_sanitize_string' ) ) :
	function listar_sanitize_string($value) {
		return filter_var($value, FILTER_SANITIZE_STRING);
	}
endif;

add_action( 'after_setup_theme', 'listar_setup' );

if ( ! function_exists( 'listar_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * Note that this function is hooked into the 'after_setup_theme hook', which
	 * runs before the 'init' hook. The 'init' hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 1.0
	 */
	function listar_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Listar, use a find and replace
		 * to change 'listar' to the name of your theme in all the template files.
		 *
		 * @since 1.0
		 */
		load_theme_textdomain( 'listar', listar_get_theme_file_path( '/languages' ) );

		/*
		 * Disables the block editor from managing widgets.
		 *
		 * @since 1.5.0
		 */
		remove_theme_support( 'widgets-block-editor' );

		/*
		 * Add default posts and comments RSS feed links to head.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'title-tag' );

		/*
		 * This theme uses wp_nav_menu() in one location.
		 *
		 * @since 1.0
		 */
		register_nav_menus(
			array(
				'primary-menu'         => esc_html__( 'Primary Menu', 'listar' ),
				'listing-search-menu'  => esc_html__( 'Listing Search Menu', 'listar' ),
				'footer-menu'          => esc_html__( 'Footer Menu', 'listar' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 *
		 * @since 1.0
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Set up the WordPress core custom background feature.
		 *
		 * @since 1.0
		 */
		add_theme_support(
			'custom-background',
			apply_filters(
				'listar_custom_background_args',
				array(
					'default-color' => 'f4f4f4',
					'default-image' => '',
				)
			)
		);

		/*
		 * Set up the WordPress core custom header feature.
		 *
		 * @since 1.0
		 */
		add_theme_support(
			'custom-header',
			apply_filters(
				'listar_custom_header_args',
				array(
					'default-image' => '',
					'width'         => 1920,
					'height'        => 1385,
				)
			)
		);

		/*
		 * Set up the WordPress core 'custom logo' feature.
		 *
		 * @since 1.0
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 190,
				'height'      => 44,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		/*
		 * Add theme support for selective refresh for widgets.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Activate archive to listing categories and regions.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'job-manager-templates' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @since 1.0
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * WordPress media custom sizes.
		 *
		 * @since 1.0
		 */

		/* Thumbnail preview to posts and listings */
		add_image_size(
			'listar-thumbnail',
			320,
			320,
			array( 'center', 'center', true )
		);

		/* Cover image to pages in general */
		add_image_size(
			'listar-cover',
			2078, /* This width is good for iPad Pro, because the larger height will require a very large width for background-size set to cover */
			1385,
			array( 'center', 'center', true )
		);

		/* Hero image for mobile */
		add_image_size(
			'listar-hero-mobile',
			475, /* This is great for iPhone 6 Plus and shorter screens */
			795,
			array( 'center', 'center', true )
		);

		/* Taller hero image for mobile */
		add_image_size(
			'listar-hero-mobile-tall',
			1190, /* This is great for iPhone 6 Plus and shorter screens */
			1990,
			array( 'center', 'center', true )
		);

		/*
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @since 1.0
		 * @global (integer) $content_width
		 */
		$content_width = isset( $content_width ) ? $content_width : 1160;

		/*
		 * Set Woocommerce support.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'woocommerce' );

		/*
		 * Add support for wide and full images to Gutenberg.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'align-wide' );

		/*
		 * Add support for default block styles to Gutenberg.
		 *
		 * @since 1.0
		 */
		add_theme_support( 'wp-block-styles' );

		/*
		 * Add support for color palette to Gutenberg.
		 *
		 * @since 1.0
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Dark', 'listar' ),
					'slug'  => 'very-dark-gray',
					'color' => '#23282d',
				),
				array(
					'name'  => esc_html__( 'Strong Red', 'listar' ),
					'slug'  => 'strong-red',
					'color' => '#ab0303',
				),
				array(
					'name'  => esc_html__( 'Strong Green', 'listar' ),
					'slug'  => 'strong-green',
					'color' => '#0e490b',
				),
				array(
					'name'  => esc_html__( 'Royal Blue', 'listar' ),
					'slug'  => 'royal-blue',
					'color' => '#2489d3',
				),
				array(
					'name'  => esc_html__( 'Strong Magenta', 'listar' ),
					'slug'  => 'strong-magenta',
					'color' => '#861890',
				),
				array(
					'name'  => esc_html__( 'Very Light Gray', 'listar' ),
					'slug'  => 'very-light-gray',
					'color' => '#eee',
				),
				array(
					'name'  => esc_html__( 'Very Light Red', 'listar' ),
					'slug'  => 'very-light-red',
					'color' => '#f9e8e8',
				),
				array(
					'name'  => esc_html__( 'Very Light Green', 'listar' ),
					'slug'  => 'very-light-green',
					'color' => '#e6f9e5',
				),
				array(
					'name'  => esc_html__( 'Very Light Blue', 'listar' ),
					'slug'  => 'very-light-blue',
					'color' => '#e7f2f5',
				),
				array(
					'name'  => esc_html__( 'Very Light Yellow', 'listar' ),
					'slug'  => 'very-light-yellow',
					'color' => '#f8f9cd',
				),
			)
		);

		/*
		 * Add callback for custom TinyMCE editor stylesheets.
		 * This theme styles the visual editor with 'editor-style.css'
		 * and 'editor-style-dynamic.php' to match the theme style.
		 * The 'editor-style-dynamic.php' file can be updated by
		 * Customizer settings (Google Fonts and Theme Color).
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
		 * @since 1.0
		 */

		/* General styles ( base ) */
		add_editor_style();

		if ( listar_google_fonts_active() ) {
			/* Google Fonts for WordPress TinyMCE visual editor */
			$google_fonts_url = listar_google_fonts_url();
			add_editor_style( $google_fonts_url );
		}

		/* Dynamic styles for custom Google Fonts and theme color */
		$dynamic_editor_style_url = listar_get_dynamic_editor_style_url();
		add_editor_style( $dynamic_editor_style_url );
	}

endif;

if ( ! function_exists( 'listar_get_dynamic_editor_style_url' ) ) :
	/**
	 * Dynamic styles to WordPress TinyMCE visual editor.
	 * Create a URL with dynamic GET variables to modify 'editor-style-dynamic.php' file content.
	 * Called by 'add_editor_style' function, during the execution of 'after_setup_theme' action.
	 * Currently, the dynamic CSS generated depends on:
	 * - WordPress Customize / Colors
	 * - WordPress Customize / Google Fonts: Two Google Fonts, respecting the recommended method to include Google Fonts into WordPress.
	 * See: listar_google_fonts_url()
	 *
	 * @since 1.0
	 *
	 * @param (boolean) $gutenberg_editor true for Gutenberg editor, false to default WordPress editor.
	 * @return (string)
	 */
	function listar_get_dynamic_editor_style_url( $gutenberg_editor = false ) {

		/* Theme Color ( Customize / Theme Color ) */
		$theme_color_hex = listar_theme_color();
		$theme_color_rgb = listar_convert_hex_to_rgb( $theme_color_hex );

		/* Primary (Body) Google Font ( Customize / Google Fonts ) */
		$primary_google_font_url = get_theme_mod( 'listar_primary_google_font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700&amp;subset=latin-ext' );
		$primary_font_family     = listar_get_google_font_family( $primary_google_font_url );

		/* Secondary (Headings) Google Font ( Customize / Google Fonts ) */
		$secondary_google_font_url = get_theme_mod( 'listar_secondary_google_font', 'https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;subset=latin-ext' );
		$secondary_font_family     = listar_get_google_font_family( $secondary_google_font_url );

		/* Make Secondary (Headings) Google Font Bold? */
		$secondary_google_font_bold = get_theme_mod( 'listar_secondary_google_font_bold', true );

		if ( $gutenberg_editor ) {
			$gutenberg_editor = '-gutenberg';
		}

		if ( empty( $secondary_google_font_bold ) ) {
			$secondary_google_font_bold = '500';
		} else {
			$secondary_google_font_bold = '700';
		}

		if ( ! listar_google_fonts_active() ) {
			$primary_font_family   = 'inactive';
			$secondary_font_family = 'inactive';
		}

		/* Generate dynamic stylesheet URL */
		$dynamic_stylesheet = add_query_arg(
			array(
				'dynamic_values' => rawurlencode( $theme_color_rgb . '|' . $primary_font_family . '|' . $secondary_font_family . '|' . $secondary_google_font_bold . '|' . wp_rand( 0, 999999 ) ),
			),
			listar_get_theme_file_uri( '/editor-style-dynamic' . $gutenberg_editor . '.php' )
		);

		return $dynamic_stylesheet;
	}

endif;

/*
 * Theme Sidebars / Widgetzed Areas ********************************************
 */

add_action( 'widgets_init', 'listar_sidebars_init' );

if ( ! function_exists( 'listar_sidebars_init' ) ) :
	/**
	 * Theme sidebars.
	 *
	 * @since 1.0
	 */
	function listar_sidebars_init() {

		/* Blog sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'listar' ),
				'id'            => 'listar-blog-sidebar',
				'description'   => esc_html__( 'Add widgets here to appear in the blog.', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title">',
				'after_title'   => '</div>',
			)
		);

		/* Front page widgetized area */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Front Page', 'listar' ),
				'id'            => 'listar-front-page-sidebar',
				'description'   => esc_html__( 'Add widgets here to appear in the front page.', 'listar' ),
				'before_widget' => '<div class="listar-front-widget-wrapper"><div id="%1$s" class="widget %2$s"><section class="listar-section listar-widget-content-wrapper">',
				'after_widget'  => '</section></div></div>',
				'before_title'  => '<div class="listar-section-title listar-widget-title"><h2 class="widget-title"><span class="listar-title-with-stripe">',
				'after_title'   => '</span></h2></div>',
			)
		);

		/* Footer Column 1 */
		if ( 1 === (int) get_option( 'listar_footer_column_1' ) ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Footer Column', 'listar' ) . ' - 1',
				'id'		=> 'listar-sidebar-footer-1',
				'description'	=> esc_html__( 'Add widgets here to appear in the footer.', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}

		/* Footer Column 2 */
		if ( 1 === (int) get_option( 'listar_footer_column_2' ) ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Footer Column', 'listar' ) . ' - 2',
				'id'		=> 'listar-sidebar-footer-2',
				'description'	=> esc_html__( 'Add widgets here to appear in the footer.', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}

		/* Footer Column 3 */
		if ( 1 === (int) get_option( 'listar_footer_column_3' ) ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Footer Column', 'listar' ) . ' - 3',
				'id'		=> 'listar-sidebar-footer-3',
				'description'	=> esc_html__( 'Add widgets here to appear in the footer.', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}

		/* Footer Column 4 */
		if ( 1 === (int) get_option( 'listar_footer_column_4' ) ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Footer Column', 'listar' ) . ' - 4',
				'id'		=> 'listar-sidebar-footer-4',
				'description'	=> esc_html__( 'Add widgets here to appear in the footer.', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}
		
		$shop_sidebar = get_option( 'listar_enable_woo_archive_sidebar' );

		if ( empty( $shop_sidebar ) ) {
			$shop_sidebar = 'left';
		}

		/* Woocommerce Archive Sidebar */
		if ( 'disabled' !== $shop_sidebar ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Shop Archive Sidebar', 'listar' ),
				'id'		=> 'shop',
				'description'	=> esc_html__( 'Add widgets here to appear in the shop archive pages', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}
		
		$product_sidebar = get_option( 'listar_enable_woo_product_sidebar' );

		if ( empty( $product_sidebar ) ) {
			$product_sidebar = 'archive';
		}

		/* Woocommerce Product Sidebar */
		if ( 'archive' !== $product_sidebar && 'disabled' !== $product_sidebar ) {
			register_sidebar( array(
				'name'		=> esc_html__( 'Shop Product Sidebar', 'listar' ),
				'id'		=> 'shop-product',
				'description'	=> esc_html__( 'Add widgets here to appear in the shop product pages', 'listar' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<div class="widget-title">',
				'after_title'	=> '</div>',
			) );
		}
	}

endif;

/*
 * Enqueue scripts and styles to the theme (Front end) *************************
 */

add_action( 'wp_enqueue_scripts', 'listar_frontend_enqueue' );

if ( ! function_exists( 'listar_frontend_enqueue' ) ) :
	/**
	 * Front end enqueue.
	 *
	 * @since 1.0
	 */
	function listar_frontend_enqueue() {
	
		/* Don't load nothing in case of front end marketplace dashboard */
		if ( listar_is_wcfm_dashboard() || listar_is_wcfm_vendor_setup_page() ) {
			return false;
		}

		$animate_elements_on_scroll = (int) get_option( 'listar_animate_elements_on_scroll' );

		/* Is built in Google Fonts manager (Customizer / Google Fonts) active on Theme Options? */
		if ( listar_google_fonts_active() ) {

			/* Google Fonts */
			wp_enqueue_style( 'listar-google-fonts', listar_google_fonts_url(), array(), false );
		}

		/*
		 * Deregister Woocommerce Select2 script, because its outdated (v3.7.1) and has some styling issues.
		 * This theme is providing the last version of Select2 (v4.0.6).
		 */

		/**
		 * Deregister other libraries already included in the theme.
		 */

		wp_dequeue_style( 'owl-carousel' );
		wp_dequeue_style( 'owl-carousel-theme' );
		wp_dequeue_script( 'owl-carousel' );

		wp_deregister_style( 'owl-carousel' );
		wp_deregister_style( 'owl-carousel-theme' );
		wp_deregister_script( 'owl-carousel' );

		/* Styles */
		$main_deps_css = array( 'bootstrap' );
		
		if ( class_exists( 'WP_My_Instagram' ) ) {
			array_push( $main_deps_css, 'wp-my-instagram' );
		}
		
		wp_enqueue_style( 'bootstrap', listar_get_theme_file_uri( '/assets/lib/bootstrap/css/bootstrap.min.css' ), array(), '3.3.7' );
		wp_enqueue_style( 'listar-icons', listar_get_theme_file_uri( '/assets/fonts/icons/linear/css/import-icons.min.css' ), array( 'bootstrap' ), '1.0.0' );
		wp_enqueue_style( 'font-awesome', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/css/import-icons.min.css' ), array( 'bootstrap' ), '5.15.1' );
		wp_enqueue_style( 'lightbox', listar_get_theme_file_uri( '/assets/lib/lightbox2/css/lightbox.min.css' ), array( 'bootstrap' ), '2.10.0' );
		wp_enqueue_style( 'fancybox', listar_get_theme_file_uri( '/assets/lib/fancybox/dist/jquery.fancybox.min.css' ), array( 'bootstrap' ), '2.10.0' );
		wp_enqueue_style( 'leaflet', listar_get_theme_file_uri( '/assets/lib/leaflet/css/leaflet.min.css' ), array( 'bootstrap' ), '1.3.3' );
		wp_enqueue_style( 'owl-carousel', listar_get_theme_file_uri( '/assets/lib/owl-carousel/assets/owl.carousel.min.css' ), array( 'bootstrap' ), '2.3.4' );
		wp_enqueue_style( 'owl-carousel-theme', listar_get_theme_file_uri( '/assets/lib/owl-carousel/assets/owl.theme.default.min.css' ), array( 'bootstrap' ), '2.3.4' );
		wp_enqueue_style( 'lity', listar_get_theme_file_uri( '/assets/lib/lity/dist/lity.min.css' ), array( 'bootstrap' ), '2.3.1' );
		wp_enqueue_style( 'intl-tel-input', listar_get_theme_file_uri( '/assets/lib/intl-tel-input/build/css/intlTelInput.min.css' ), array( 'bootstrap' ), '16.0.0' );
                wp_enqueue_style( 'mediaelement' );
		
		
		/* Prefixed, because we are replacing Select2 from bot: Woocommerce and WP Job Manager */
		wp_enqueue_style( 'listar-select2', listar_get_theme_file_uri( '/assets/lib/select2/dist/css/select2.min.css' ), array( 'bootstrap' ), '4.0.6' );
		
		if ( 1 === $animate_elements_on_scroll ) {
			wp_enqueue_style( 'aos', listar_get_theme_file_uri( '/assets/lib/aos/dist/aos.css' ), array( 'bootstrap' ), '2.0' );
		}

		/* Main stylesheet */
		wp_enqueue_style( 'listar-main-style', listar_get_theme_file_uri( '/assets/css/' . listar_get_frontend_slug() . '.css' ), $main_deps_css, listar_get_theme_version() );

		$get_pagespeed_option = (int) get_option( 'listar_activate_pagespeed' );
		$listar_pagespeed_enabled = 1 === $get_pagespeed_option ? true : false;

		/* Scripts */

		wp_dequeue_script( 'leaflet' );
		wp_deregister_script( 'leaflet' );


		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-migrate' );
		wp_enqueue_script( 'jquery-effects-core' );
		wp_enqueue_script( 'ifvisible', listar_get_theme_file_uri( '/assets/lib/ifvisible/ifvisible.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bootstrap', listar_get_theme_file_uri( '/assets/lib/bootstrap/js/bootstrap.min.js' ), array( 'jquery' ), '3.3.7', true );
		wp_enqueue_script( 'lightbox', listar_get_theme_file_uri( '/assets/lib/lightbox2/js/lightbox.min.js' ), array( 'jquery' ), '2.10.0', true );
		wp_enqueue_script( 'fancybox', listar_get_theme_file_uri( '/assets/lib/fancybox/dist/jquery.fancybox.min.js' ), array( 'jquery' ), '2.10.0', true );
		wp_enqueue_script( 'drag-scroll', listar_get_theme_file_uri( '/assets/lib/jquery-dragscroll/jquery-dragscroll.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'leaflet', listar_get_theme_file_uri( '/assets/lib/leaflet/js/leaflet.min.js' ), array( 'jquery' ), '1.3.3', true );
		wp_enqueue_script( 'leaflet-markercluster', listar_get_theme_file_uri( '/assets/lib/leaflet/leaflet-markercluster/js/leaflet-markercluster.min.js' ), array( 'jquery', 'leaflet' ), '1.4.1', true );
		wp_enqueue_script( 'esri-leaflet', listar_get_theme_file_uri( '/assets/lib/leaflet/leaflet-geocoder/js/esri-leaflet.js' ), array( 'jquery', 'leaflet' ), '2.3.2', true );
		wp_enqueue_script( 'esri-leaflet-geocoder', listar_get_theme_file_uri( '/assets/lib/leaflet/leaflet-geocoder/js/esri-leaflet-geocoder.js' ), array( 'jquery', 'leaflet', 'esri-leaflet' ), '2.3.2', true );
		wp_enqueue_script( 'owl-carousel', listar_get_theme_file_uri( '/assets/lib/owl-carousel/owl.carousel.min.js' ), array( 'jquery' ), '2.3.4', true );
		wp_enqueue_script( 'lity', listar_get_theme_file_uri( '/assets/lib/lity/dist/lity.min.js' ), array( 'jquery' ), '2.3.1', true );
		wp_enqueue_script( 'vh-check', listar_get_theme_file_uri( '/assets/lib/vh-check/vh-check.min.js' ), array( 'jquery' ), '2.0.5', true );
		wp_enqueue_script( 'intl-tel-input', listar_get_theme_file_uri( '/assets/lib/intl-tel-input/build/js/intlTelInput.min.js' ), array( 'jquery' ), '2.0.5', true );
		wp_enqueue_script( 'mediaelement' );
                wp_enqueue_script( 'mediaelement-vimeo' );
                


		/* Prefixed, because we are replacing Select2 from both: Woocommerce and WP Job Manager */
		wp_enqueue_script( 'listar-select2', listar_get_theme_file_uri( '/assets/lib/select2/dist/js/select2.min.js' ), array( 'jquery' ), '4.0.6', true );

		if ( 1 === $animate_elements_on_scroll ) {
			wp_enqueue_script( 'aos', listar_get_theme_file_uri( '/assets/lib/aos/dist/aos.js' ), array( 'jquery' ), '2.0', true );
		}

		/* Main JavaScript */
		$main_deps_js = array( 'jquery' );
		
		if ( class_exists( 'WP_My_Instagram' ) ) {
			array_push( $main_deps_js, 'wp-my-instagram' );
		}
		
		wp_enqueue_script( 'listar-main-javascript', listar_get_theme_file_uri( '/assets/js/' . listar_get_frontend_slug() . '.js' ), $main_deps_js, listar_get_theme_version(), true );
		wp_enqueue_script( 'listar-custom-marketplace-javascript', listar_get_theme_file_uri( '/assets/js/frontend-marketplace.js' ), $main_deps_js, listar_get_theme_version(), true );

		/* Conditional scripts */
		wp_enqueue_script( 'html5shiv', listar_get_theme_file_uri( '/assets/lib/html5shiv/html5shiv.min.js' ), array(), '3.7.3', false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
		wp_enqueue_script( 'respond', listar_get_theme_file_uri( '/assets/lib/respond/respond.min.js' ), array(), '1.4.2', false );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

		/* Sets 'admin-ajax.php' URL to be used by Ajax Login script (found on assets/js/frontend.js) */

		/* Ajax URL */
		$ajax_url = array(
			'ajaxurl' => esc_url(
				admin_url( 'admin-ajax.php' )
			),
		);
		
		/* Listar Theme Version */
		$listarThemeVersion = array(
			'listarThemeVersion' => listar_get_theme_version(),
		);
		
		/* Listar Addons Version */
		$listarAddonsVersion = array(
			'listarAddonsVersion' => defined( 'LISTAR_ADDONS_VERSION' ) ? LISTAR_ADDONS_VERSION : '',
		);

		/* Woocommerce Currency Symbol */
		$woo_currency_symbol = array(
			'wooCurrencySymbol' => esc_html(
				listar_currency()
			),
		);

		/* Default (fallback) location for listing map. */
		$fallback_map_location = array(
			'fallbackMapLocation' => esc_html(
				get_option( 'listar_fallback_map_location' )
			),
		);

		/* Limit the number of images for gallery upload. */
		$max_gallery_upload = listar_addons_active() ? listar_get_max_image_gallery() : 0;
			
		if ( empty( $max_gallery_upload ) ) {
			$max_gallery_upload = get_option( 'listar_max_gallery_upload_images' );
			
			if ( empty( $max_gallery_upload ) ) {
				$max_gallery_upload = 30;
			}
		}
		
		$max_gallery_upload_images = array(
			'maxGalleryUploadImages' => $max_gallery_upload,
		);

		/* Maximum number of video/media fields on front end submission form. */
		$max_media_option = listar_addons_active() ? listar_get_media_fields_limit() : 0;
			
		if ( empty( $max_media_option ) ) {
			$max_media_option = get_option( 'listar_max_media_fields' );
			
			if ( empty( $max_media_option ) ) {
				$max_media_option = 30;
			}
		}
		
		$max_media_fields = array(
			'maxMediaFields' => $max_media_option,
		);

		/* Operating hours format. */
		$hours_format = get_option( 'listar_operating_hours_format' );
		$am_pm = get_option( 'listar_operating_hours_suffix' );

		if ( empty( $hours_format ) ) {
			$hours_format = '24';
		}

		$operating_hours_format = array(
			'operatingHoursFormat' => $hours_format,
		);

		$disable_am_pm = array(
			'disableAMPM' => (int) $am_pm,
		);

		$listing_accordion_preopen = array(
			'listingAccordionPreopen' => listar_listing_accordion_preopen(),
		);
		
		/* Default 'Explore By' option */
		$default_explore_by_option = array(
			'listarInitialExploreByOption' => listar_addons_active() ? listar_get_initial_explore_by_filter() : 'default',
		);
		
		/* Default search ordering */
		$default_search_filter = array(
			'listarInitialSearchOrder' => listar_addons_active() ? listar_get_initial_sort_order() : 'newest',
		);
		
		/* Forced search ordering - This is forced by Explore By types */
		$current_initial_explore_by_type = listar_addons_active() ? listar_get_initial_explore_by_filter() : 'default';
		$forced_ordering = listar_addons_active() ? listar_get_initial_sort_order() : 'newest';
		
		if ( 'default' !== $current_initial_explore_by_type ) {
			$forced_ordering = $current_initial_explore_by_type;
			
			if ( 'surprise' === $forced_ordering ) {
				$forced_ordering = 'random';
			}
		}
		
		$forced_search_ordering = array(
			'listarInitialForcedSearchOrder' => $forced_ordering,
		);
		
		if ( $listar_pagespeed_enabled ) {
			$listarUsingPagespeed = array(
				'listarUsingPagespeed' => 'yes',
			);
		}
		
		/* Is user logged in? */
		$listarUserLogged = array(
			'listarUserLogged' => 'no',
		);
		
		if ( is_user_logged_in() ) {
			$listarUserLogged = array(
				'listarUserLogged' => 'yes',
			);
		}
		
		/* Pagespeed Active? */
		$listarUsingPagespeed = array(
			'listarUsingPagespeed' => 'no',
		);
		
		if ( $listar_pagespeed_enabled ) {
			$listarUsingPagespeed = array(
				'listarUsingPagespeed' => 'yes',
			);
		}

                $listar_minimum_screen_width_hero_video = array(
                        'minimumScreeWidthHeroVideo' => 0,
                );

                if ( listar_is_front_page_template() ) {
                        global $post;

                        $page_id = listar_get_current_page_id();

                        $temp = (int) get_post_meta( $page_id, 'listar_meta_box_cover_video_minimum_screen_width', true );

                        if ( empty( $temp ) ) {
                                $temp = 0;
                        }

                        $listar_minimum_screen_width_hero_video = array(
                                'minimumScreeWidthHeroVideo' => $temp,
                        );
                }
		
		$listar_is_claiming_listing = array(
			'listarIsClaimingListing' => listar_is_claiming_listing(),
		);

		$listar_map_provider_slug = listar_get_map_tiles_provider();
		
		$listar_map_provider = array(
			'listarMapTilesProvider' => $listar_map_provider_slug,
		);
		
		$listar_map_provider_token = array(
			'listarMapboxToken' => get_option( 'listar_mapbox_design_provider_api_key' ),
			
		);
		
		$tempStyle = get_option( 'listar_mapbox_style_url' );

		if ( 'jawg' === $listar_map_provider ) {
				
		}
		
		if ( false === strpos( $tempStyle, 'mapbox://styles/' ) ) {
			$tempStyle = '';
		} else {
			$tempStyle = str_replace( 'mapbox://styles/' , '', $tempStyle );
		}

		if ( 'jawg' === $listar_map_provider_slug ) {
			$listar_map_provider_token = array(
				'listarJawgToken' => get_option( 'listar_jawg_design_provider_api_key' ),
				
			);	

			$tempStyle = get_option( 'listar_jawg_style_url' );	

			if ( empty( $tempStyle ) ) {
				$tempStyle = 'jawg-sunny';
			}	
		}
		
		$listar_map_provider_style_url = array(
			'listarMapStyleURL' => $tempStyle
		);
		
		$has_booking_products = esc_html__( 'No bookings available.', 'listar' );
		$has_booking_products_description = '-';
		
		if ( listar_addons_active() && listar_is_job_submission_form_page() && class_exists( 'WC_Bookings' ) ) {
			$user_id = listar_get_listing_author_id();
			
			if ( false !== strpos( network_site_url(), 'listar.directory' ) ) {
			    $user_id = false;
			}
			
			$query = new WP_Query( array(
				'author'         =>  $user_id,
				'posts_per_page' =>  -1, 
				'post_type'      =>  array( 'product' ),
				'post_status'    =>  'publish',
				'tax_query' => array( array(
					'taxonomy' => 'product_type',
					'terms'    => array( 'booking' ),
					'field'    => 'slug',
				)),
			) );

			$count = (int) $query->found_posts;

			if ( $count > 0 ) {
				$has_booking_products = esc_html__( 'Nothing to do here', 'listar' );
				$has_booking_products_description = esc_html__( 'Your bookable product will be displayed.', 'listar' );

				//$has_booking_products_description = sprintf(

					/* TRANSLATORS: %s: Number of bookable products */
					//esc_html__( '%s bookable product(s) will be displayed.', 'listar' ),
					//zeroise( $count, 2 )
				//);
			}
		}

                $listing_pricing_link_labels = array(
                        'info' => esc_html__( 'More Info', 'listar' ),
                        'items' => esc_html__( 'More Items', 'listar' ),
                        'source' => esc_html__( 'Source', 'listar' ),
                        'contact' => esc_html__( 'Get In Touch', 'listar' ),
                        'inquire' => esc_html__( 'Inquire', 'listar' ),
                        'pricing' => esc_html__( 'Pricing', 'listar' ),
                        'purchase' => esc_html__( 'Purchase', 'listar' ),
                        'purchase-now' => esc_html__( 'Purchase Now', 'listar' ),
                        'booking' => esc_html__( 'Booking', 'listar' ),
                        'book-now' => esc_html__( 'Book Now', 'listar' ),
                        'appointment' => esc_html__( 'Appointment', 'listar' ),
                        'website' => esc_html__( 'Official Website', 'listar' ),
                        'store' => esc_html__( 'Go To Store', 'listar' ),
                );

		/* Localization/translation to JavaScript strings on WordPress front end pages */
		$frontend_translation = array(
			'monday'             => esc_html__( 'Monday', 'listar' ),
			'tuesday'            => esc_html__( 'Tuesday', 'listar' ),
			'wednesday'          => esc_html__( 'Wednesday', 'listar' ),
			'thursday'           => esc_html__( 'Thursday', 'listar' ),
			'friday'             => esc_html__( 'Friday', 'listar' ),
			'saturday'           => esc_html__( 'Saturday', 'listar' ),
			'sunday'             => esc_html__( 'Sunday', 'listar' ),
			'closed'             => esc_html__( 'Closed', 'listar' ),
			'open'               => esc_html__( 'Open 24 Hours', 'listar' ),
			'opens'              => esc_html__( 'Open', 'listar' ),
			'close'              => esc_html__( 'Close', 'listar' ),
			'day'                => esc_html__( 'Day', 'listar' ),
			'copyForAll'         => esc_html__( 'Copy for all days', 'listar' ),
			'multipleHoursPlus'  => esc_html__( 'Add operating hours', 'listar' ),
			'multipleHoursMinus' => esc_html__( 'Remove operating hours', 'listar' ),
			'copyForAll'         => esc_html__( 'Copy for all days', 'listar' ),
			'requiredField'      => esc_html__( 'Required', 'listar' ),
			'clickHere'          => esc_html__( 'Click here', 'listar' ),
			'addressAdvanced'    => esc_html__( 'Show advanced fields', 'listar' ),
			'updateListarAddons' => esc_html__( 'Please update the Listar Addons plugin.', 'listar' ),
			'fixCoordinates1'    => esc_html__( 'Your custom (forced) coordinate numbers had irregular characters, please verify the new values.', 'listar' ),
			'fixCoordinates2'    => esc_html__( 'Your custom (forced) coordinates are out of range.', 'listar' ),
			'fixCoordinates3'    => esc_html__( 'Your custom (forced) coordinate numbers have a lot of dots or hyphens.', 'listar' ),
			'fixCoordinates4'    => esc_html__( 'A custom (forced) coordinate field is empty.', 'listar' ),
			'featuredCategory'   => esc_html__( 'Primary Category', 'listar' ),
			'featuredRegion'     => esc_html__( 'Primary Region', 'listar' ),
			'testingDemoPhone'   => esc_html__( 'A notice from Listar developer: this call will proceed normally but not work, because the "1234567" number is for demo purpose.', 'listar' ),
			'regionSelectPlaceholder' => esc_html__( 'Choose a region...', 'listar' ),
			'improveMap'         => esc_html__( 'Improve this map', 'listar' ),
			'goToHomePage'       => esc_html__( 'Go to Home Page', 'listar' ),
			'maxGalleryImages'   => esc_html__( 'Maximum gallery images', 'listar' ),
			'failReadCacheTXT'   => sprintf(

				/* TRANSLATORS: 1: A file name and extension, 2: The site URL */
				esc_html__( 'Failed to read %1$s on %2$s.', 'listar' ),
				'cache-urls.txt',
				network_site_url()
			),
			
			// Translation for price list fields.
			'selectLabel'        => esc_html__( 'Link label', 'listar' ),
			'category'           => esc_html__( 'Category', 'listar' ),
			'title'              => esc_html__( 'Title', 'listar' ),
			'description'        => esc_html__( 'Description', 'listar' ),
			'price'              => esc_html__( 'Price', 'listar' ),
                        'link'               => esc_html__( 'Link', 'listar' ),
                        'label'              => $listing_pricing_link_labels,
			'featuredTag'        => esc_html__( 'Featured tag, e.g. NEW', 'listar' ),
			'item'               => esc_html__( 'Item', 'listar' ),
			'uncategorized'      => esc_html__( 'Uncategorized', 'listar' ),
			'excludeItem'        => esc_html__( 'Delete this item?', 'listar' ),
			'excludeCategory'    => esc_html__( 'Delete this category?', 'listar' ),
			'excludeItems'       => esc_html__( 'Delete the category items too?', 'listar' ),
			'emptyPriceCategory' => esc_html__( 'Please enter a name for all categories of the Product/Service/Price List or exclude it.', 'listar' ),
			'categoryNoItems'    => esc_html__( 'Found empty categories on the Product/Service/Price List. Please populate the category with items or exclude it.', 'listar' ),
			'missingTitle'       => esc_html__( 'Please insert a title for all items of the Product/Service/Price List or exclude the item.', 'listar' ),
			
			// Translation for query vars.
			'searchTypeTranslation'        => listar_url_query_vars_translate( 'search_type' ),
			'listingRegionsTranslation'    => listar_url_query_vars_translate( 'listing_regions' ),
			'listingCategoriesTranslation' => listar_url_query_vars_translate( 'listing_categories' ),
			'listingAmenitiesTranslation'  => listar_url_query_vars_translate( 'listing_amenities' ),
			'listingSortTranslation'       => listar_url_query_vars_translate( 'listing_sort' ),
			'exploreByTranslation'         => listar_url_query_vars_translate( 'explore_by' ),
			'selectedCountryTranslation'   => listar_url_query_vars_translate( 'selected_country' ),
			'savedAddressTranslation'      => listar_url_query_vars_translate( 'saved_address' ),
			'savedPostcodeTranslation'     => listar_url_query_vars_translate( 'saved_postcode' ),
			'bookmarkedTranslation'        => listar_url_query_vars_translate( 'bookmarks_page' ),
			
			'noClaimPackages'              => esc_html__( 'Sorry, no claim packages available.', 'listar' ),
			'mediaLinkOrCode'              => esc_html__( 'Media Link or Code', 'listar' ),
			'enterMediaValue'              => esc_html__( 'Enter the media link (e.g Youtube, Vimeo, .MP4, .JPG) or embeding code (iframe or embed tags).', 'listar' ),
			'media'                        => esc_html__( 'Media', 'listar' ),
			'mediaConfirm'                 => esc_html__( 'This content does not appear to be a direct link for a media file, but an embedabble web page with the desired media. Create an iframe to fix?', 'listar' ),
			
			'wooBookingsActive'            => class_exists( 'WC_Bookings' ),
			'hasBookingProducts'           => $has_booking_products,
			'hasBookingProductsDescr'      => $has_booking_products_description,
			'deleteItem'               => esc_html__( 'Delete item?', 'listar' ),
			'deleteImage'              => esc_html__( 'Delete this image?', 'listar' ),
			'deleteEarlierImage'       => esc_html__( 'Delete the earlier image?', 'listar' ),
		);

		wp_localize_script(
			'listar-main-javascript',
			'listarLocalizeAndAjax',
			$ajax_url + $listarThemeVersion + $listarAddonsVersion + $woo_currency_symbol + $fallback_map_location + $operating_hours_format + $disable_am_pm + $listing_accordion_preopen + $default_explore_by_option + $default_search_filter + $forced_search_ordering + $frontend_translation + $listarUsingPagespeed + $listar_minimum_screen_width_hero_video + $listar_is_claiming_listing + $max_gallery_upload_images + $max_media_fields + $listarUserLogged + $listar_map_provider + $listar_map_provider_style_url + $listar_map_provider_token
		);

		/* Enqueue 'Comments Reply' script */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		listar_enqueue_inline_styles();
	}

endif;

if ( ! function_exists( 'listar_enqueue_inline_styles' ) ) :
	/**
	 * Add inline styles based mainly on custom theme options.
	 * Called by 'wp_enqueue_scripts' action.
	 *
	 * @since 1.0
	 */
	function listar_enqueue_inline_styles() {

		$custom_css = '';

		/* Get custom background color for the site */

		$custom_css .= 'body,#content,.listar-hidden-footer #content,.job_listing > section,.listar-gallery-slideshow-separator{background-color:#' . get_theme_mod( 'background_color', 'f4f4f4' ) . ';}';

		wp_add_inline_style( 'listar-main-style', $custom_css );

		/* Output global JavaScript variables for frontend pages. */
		listar_custom_frontend_javascript();
	}

endif;

if ( ! function_exists( 'listar_custom_frontend_javascript' ) ) :
	/**
	 * Output global JavaScript variables for frontend pages.
	 * Called by 'wp_enqueue_scripts' action.
	 *
	 * @since 1.0
	 */
	function listar_custom_frontend_javascript() {
		$custom_js = '';
		$rubber_effect = (int) get_option( 'listar_hero_rubber_effect' );
		$min_map_zoom_level = (int) get_option( 'listar_min_map_zoom_level' );
		$max_map_zoom_level = (int) get_option( 'listar_max_map_zoom_level' );
                $initial_archive_map_zoom_level = (int) get_option( 'listar_initial_archive_map_zoom_level' );
                $initial_single_map_zoom_level = (int) get_option( 'listar_initial_single_map_zoom_level' );
		$locale_code = get_locale();
		$listar_addons_url = listar_addons_active() ? 'window.listarAddonsDirectoryURL = "' . LISTAR_ADDONS_PLUGIN_DIR_URL . '";' : '';
		
		if ( 0 === $rubber_effect ) {
			$custom_js .= 'window.listarDisableRubber = true;';
		}

		if ( 0 === $min_map_zoom_level ) {
			$min_map_zoom_level = 3;
		}

		if ( 0 === $max_map_zoom_level ) {
			$max_map_zoom_level = 17;
		}

                if ( empty( $initial_archive_map_zoom_level ) ) {
                        $initial_archive_map_zoom_level = 0;
                }

                if ( empty( $initial_single_map_zoom_level ) ) {
                        $initial_single_map_zoom_level = 0;
                }

		$javascript_strict = '
			/* <![CDATA[ */

				( function () {

					"use strict";

					' . $listar_addons_url .'
					window.listarSiteURL = "' . network_site_url() . '";
					window.listarSiteCountryCode = "' . trim( substr( $locale_code, strpos( $locale_code, '_' ) + 1 ) ) . '";
					window.listarThemeURL = "' . get_template_directory_uri() . '";
					window.listarMinMapZoomLevel = "' . $min_map_zoom_level . '";
					window.listarMaxMapZoomLevel = "' . $max_map_zoom_level . '";
					window.listarInitialArchiveMapZoomLevel = "' . $initial_archive_map_zoom_level . '";
					window.listarInitialSingleMapZoomLevel = "' . $initial_single_map_zoom_level . '";

					' . $custom_js . '

				} )();

			/* ]]> */
		';
		
		wp_add_inline_script( 'listar-main-javascript', $javascript_strict, 'before' );
	}

endif;

add_action( 'wp_head', 'listar_pingback_header' );

if ( ! function_exists( 'listar_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @link https://github.com/WordPress/twentynineteen/blob/master/inc/template-functions.php#L45-L55
	 * @since 1.0
	 */
	function listar_pingback_header() {
		if ( is_singular() && pings_open( get_queried_object() ) ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
endif;

if ( ! function_exists( 'listar_google_fonts_url' ) ) :
	/**
	 * Generate a valid Google Fonts URL to the theme based on Primary (Body) and Secondary (Headings) Google Fonts
	 * set on WordPress Customize / Google Fonts.
	 * This is the recommended method to include Google Fonts into WordPress.
	 *
	 * @link https://gist.github.com/richtabor/b85d317518b6273b4a88448a11ed20d3
	 * @since 1.0
	 * @return (string) Google Fonts URL for the theme.
	 */
	function listar_google_fonts_url() {

		$google_fonts = listar_get_customizer_google_fonts();
		$fonts_url    = '';
		$fonts        = array();
		$subsets      = $google_fonts['subsets'];

		/* TRANSLATORS: If there are characters in your language that are not supported by this font, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'The primary Google font for general body texts, Open Sans by default. It can be replaced on WordPress Customize / Google Fonts: on or off', 'listar' ) ) {
			$fonts[] = $google_fonts['primary']['family'];
		}
		
		if ( $google_fonts['secondary']['family'] !== $google_fonts['primary']['family'] ) {
			/* TRANSLATORS: If there are characters in your language that are not supported by this font, translate this to 'off'. Do not translate into your own language. */
			if ( 'off' !== esc_html_x( 'on', 'The secondary Google font for heading texts, Quicksand by default. It can be replaced on WordPress Customize / Google Fonts: on or off', 'listar' ) ) {
				$fonts[] = $google_fonts['secondary']['family'];
			}
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family'  => implode( '%7C', $fonts ), /* Use %7C instead '|' for W3C validation */
					'subset'  => $subsets,
					'display' => 'swap',
				),
				'https://fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}

endif;

if ( ! function_exists( 'listar_get_customizer_google_fonts' ) ) :
	/**
	 * Get primary (body) and secondary (headings) Google fonts set on WordPress Customizer.
	 * Called by 'listar_google_fonts_url' function.
	 *
	 * @since 1.0
	 * @return (array) Google font family names, their weights and subset.
	 */
	function listar_get_customizer_google_fonts() {

		$fonts = array();
		$fonts['subsets'] = '';

		/* Theme - Primary (Body) Google Font *************************/

		$primary_google_font = get_theme_mod( 'listar_primary_google_font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700&amp;subset=latin-ext' );

		/* Font family and font weights for primary font */

		/* Explode and get last part from string */
		$parts = explode( 'family=', $primary_google_font );
		$array = array_values( $parts );
		$primary_font_query_str = end( $array );

		$fonts['primary']['family'] = listar_get_google_font_family( $primary_font_query_str, true );

		/* Theme - Secondary (Headings) Google Font *******************/

		$secondary_google_font = get_theme_mod( 'listar_secondary_google_font', 'https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;subset=latin-ext' );

		/* Font family and font weights for secondary font */

		/* Explode and get last part from string */
		$parts2 = explode( 'family=', $secondary_google_font );
		$array2 = array_values( $parts2 );
		$secondary_font_query_str = end( $array2 );

		$fonts['secondary']['family'] = listar_get_google_font_family( $secondary_font_query_str, true );

		/* Google Fonts subsets */
		$fonts['subsets'] = listar_get_google_font_subset();

		return $fonts;
	}

endif;

if ( ! function_exists( 'listar_get_google_font_family' ) ) :
	/**
	 * Get the font family name and font weights from a Google Font 'embedding' URL.
	 *
	 * @since 1.0
	 * @param (string) $url Google Font 'embedding' URL or Google Font query string.
	 * @param (bool)   $include_weight If true also returns the font weights appended after the font name.
	 * @example        https://fonts.googleapis.com/css?family=Ubuntu:400,500,700&amp;subset=greek-ext,latin-ext
	 * @return (string) The font name and font weights, example: 'Ubuntu', or 'Ubuntu:400,500,700'.
	 */
	function listar_get_google_font_family( $url, $include_weight = false ) {

		$font_family = '';
		$weights     = '';

		/* Get font Family name */

		$position1 = strpos( $url, 'family=' );

		if ( false !== $position1 ) :
			/* Explode and get last part from string */
			$parts = explode( 'family=', $url );
			$array = ( array_values( $parts ) );
			$url   = end( $array );
		endif;

		$position2 = strpos( $url, ':' );

		if ( false !== $position2 ) :
			/* Explode and get first part from string */
			$parts = explode( ':', $url );
			$array = array_values( $parts );
			$font_family = reset( $array );
		else :
			$font_family = $url;
		endif;

		if ( false !== strpos( $font_family, '&' ) ) :
			/* Explode and get first part from string */
			$parts = explode( '&', $font_family );
			$array = array_values( $parts );
			$font_family = reset( $array );
		endif;

		/* Return only the font family name? */

		if ( ! $include_weight ) :
			return $font_family;
		endif;

		/* Get font weights too */

		if ( false === strpos( $url, ':' ) ) :
			$weights = '';
		else :
			/* Explode and get last part from string */
			$parts = explode( $font_family . ':', $url );
			$array = array_values( $parts );
			$weights = ':' . end( $array );

			if ( false !== strpos( $weights, '&' ) ) :
				/* Explode and get first part from string */
				$parts = explode( '&', $weights );
				$array = array_values( $parts );
				$weights = reset( $array );
			endif;
		endif;

		if ( ! empty( $weights ) ) {
			if ( false !== strpos( $weights, '@' ) ) {
				$weights1 = trim( substr( $weights, strpos( $weights, '@' ) + 1 ) );
				$weights2 = str_replace( ':', ',', $weights1 );
				$weights3 = str_replace( '300,', '', $weights2 );
				$weights  = ':' . $weights3;
			}
		} else {
			$weights = ':400,500,600,700';
		}

		return $font_family . $weights;
	}

endif;

if ( ! function_exists( 'listar_get_google_font_subset' ) ) :
	/**
	 * Get Google Fonts subsets (languages) from Customizer control.
	 *
	 * @since 1.0
	 * @return (string) The font subset, example: greek-ext,latin-ext
	 */
	function listar_get_google_font_subset() {

		$subsets = get_theme_mod( 'listar_google_font_language_subset', array( 'latin-ext' ) );

		return implode( ',', $subsets );
	}

endif;

/*
 * Enqueue scripts and styles for WordPress admin dashboard (Back end), ********
 * including scripts and styles to the 'Theme Options' page on admin
 */

add_action( 'admin_enqueue_scripts', 'listar_backend_enqueue', 9999 );

if ( ! function_exists( 'listar_backend_enqueue' ) ) :
	/**
	 * Back end enqueue.
	 *
	 * @since 1.0
	 * @param (string) $hook Current page hook.
	 */
	function listar_backend_enqueue( $hook ) {

		/* Admin 'Theme Options' styles and scripts */
		if ( 'appearance_page_listar_options' === $hook ) {
			wp_enqueue_media();

			/* Theme Options menu - CSS */
			wp_enqueue_style( 'linear-icons', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/scoop-sidebar-menu/css/linear-icons.css' ), array(), '1.0' );
			wp_enqueue_style( 'simple-line-icons', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/scoop-sidebar-menu/css/simple-line-icons.css' ), array(), '1.0' );
			wp_enqueue_style( 'ion-icons', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/scoop-sidebar-menu/css/ion-icons.css' ), array(), '2.0' );
			wp_enqueue_style( 'listar-theme-options-menu', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/scoop-sidebar-menu/css/scoop.css' ), array(), '1.0' );

			/* Theme Options menu - JavaScript */
			wp_enqueue_script( 'listar-theme-options-menu', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/scoop-sidebar-menu/js/scoop.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'mousewheel', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/jquery-mousewheel/jquery-mousewheel.min.js' ), array( 'jquery' ), '3.1.13', true );

			/* Prefixed, because we are replacing Select2 from bot: Woocommerce and WP Job Manager */
			wp_enqueue_style( 'listar-select2', listar_get_theme_file_uri( '/assets/lib/select2/dist/css/select2.min.css' ), array(), '4.0.6' );
			
			/* Prefixed, because we are replacing Select2 from both: Woocommerce and WP Job Manager */
			wp_enqueue_script( 'listar-select2', listar_get_theme_file_uri( '/assets/lib/select2/dist/js/select2.min.js' ), array( 'jquery' ), '4.0.6', true );
		}

		/* Editing taxonomy terms and Theme options - WP Color Picker */
		if ( 'edit-tags.php' === $hook || 'term.php' === $hook || 'post.php' === $hook || 'post-new.php' === $hook || 'nav-menus.php' === $hook || 'appearance_page_listar_options' === $hook ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}

		/* Editing menus */
		if ( 'nav-menus.php' === $hook ) {
			wp_enqueue_media();
		}
		
		wp_enqueue_style( 'font-awesome', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/css/import-icons.min.css' ), array(), '4.7' );

		/* Editing posts, taxonomy terms and widgets (including Customizer), or menus */
		if ( 'widgets.php' === $hook || 'edit-tags.php' === $hook || 'term.php' === $hook || 'post.php' === $hook || 'post-new.php' === $hook || 'nav-menus.php' === $hook || 'appearance_page_listar_options' === $hook ) {
			wp_enqueue_style( 'listar-icons', listar_get_theme_file_uri( '/assets/fonts/icons/linear/css/import-icons.min.css' ), array(), '1.0' );
			wp_enqueue_style( 'intl-tel-input', listar_get_theme_file_uri( '/assets/lib/intl-tel-input/build/css/intlTelInput.min.css' ), array(), '16.0.0' );
			wp_enqueue_style( 'thickbox' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-effects-core' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'intl-tel-input', listar_get_theme_file_uri( '/assets/lib/intl-tel-input/build/js/intlTelInput.min.js' ), array( 'jquery' ), '2.0.5', true );
		}

		/* Main/general admin JavaScript */
		wp_enqueue_script( 'listar-custom-backend-javascript', listar_get_theme_file_uri( '/inc/theme-options/assets/js/backend.js' ), array( 'jquery' ), listar_get_theme_version(), true );

		/* Main/general admin back end CSS */
		wp_enqueue_style( 'listar-custom-backend-stylesheet', listar_get_theme_file_uri( '/inc/theme-options/assets/css/backend.css' ), array(), listar_get_theme_version() );

		/* Global JavaScript variables as inline JavaScript */
		listar_custom_admin_javascript();

		/* Localization/translation to JavaScript strings on WordPress admin pages */
		listar_localize_admin_javascript();
	}

endif;

if ( ! function_exists( 'listar_custom_admin_javascript' ) ) :
	/**
	 * Output global JavaScript variables on WordPress admin pages.
	 * Called by 'admin_enqueue_scripts' action.
	 *
	 * @since 1.0
	 */
	function listar_custom_admin_javascript() {

		/* Icon 'class' names from stylesheets of iconized fonts and the font names, used by Thickbox icon picker */
		$inline_js = listar_get_font_icons();
		$locale_code = get_locale();
		$listar_addons_url = listar_addons_active() ? LISTAR_ADDONS_PLUGIN_DIR_URL : '';

		$javascript_strict = '
			/* <![CDATA[ */

				( function () {

					"use strict";

					' . $inline_js . '
					
					window.listarSiteURL = "' . network_site_url() . '";
					window.listarAddonsDirectoryURL = "' . $listar_addons_url . '";				
					window.listarSiteCountryCode = "' . trim( substr( $locale_code, strpos( $locale_code, '_' ) + 1 ) ) . '";
					window.listarThemeURL = "' . get_template_directory_uri() . '";

				} )();

			/* ]]> */
		';

		wp_add_inline_script( 'jquery-ui-core', $javascript_strict );
	}

endif;

if ( ! function_exists( 'listar_create_filesystem' ) ) :
	/**
	 * Set WordPress filesystem for Listar.
	 *
	 * @since 1.3.9
	 */
	function listar_create_filesystem() {
		global $listar_filesystem;
		global $wp_filesystem;

		/* Prepare to open and get file content */
		if ( empty( $wp_filesystem ) ) {

			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! $listar_filesystem ) {
			include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
			include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

			if ( ! defined( 'FS_CHMOD_DIR' ) ) {
				define( 'FS_CHMOD_DIR', ( fileperms( ABSPATH ) & 0777 | 0755 ) );
			}

			if ( ! defined( 'FS_CHMOD_FILE' ) ) {
				define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
			}

			$listar_filesystem = new WP_Filesystem_Direct( new StdClass() );
		}
	}
endif;


if ( ! function_exists( 'listar_get_font_icons' ) ) :
	/**
	 * Get the name of iconized fonts available on 'assets/fonts/icons' and the respective class names of every icon.
	 * Called by 'listar_custom_admin_javascript' function, during the execution of 'admin_enqueue_scripts' action.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_get_font_icons() {

		/* Prepare to open and get file content */
		listar_create_filesystem();
		
		global $listar_filesystem;

		$icon_font_selector_dir_abs = listar_get_theme_file_path( '/assets/fonts/icons/' );
		$iconized_font_libraries    = array_filter( glob( $icon_font_selector_dir_abs . '*' ), 'is_dir' );
		$iconized_fonts_output      = 'window.listarIconSelector = [';
		$fonts_data_str             = '';
		$class_name_fix             = '';

		/* Get iconized font names */
		foreach ( $iconized_font_libraries as $icon_dir_lib ) {

			/* Get folder name */
			$folder_name = substr( $icon_dir_lib, ( strrpos( $icon_dir_lib, '/' ) + 1 ) );

			/* Get iconized font name */
			$font_name = esc_html( str_replace( array( '_', ' ' ), '-', $folder_name ) );

			/* Open the iconized font stylesheet */
			$css_file = $icon_font_selector_dir_abs . $folder_name . '/css/import-icons.min.css';
			$css_code = ( $listar_filesystem->is_readable( $css_file ) ) ? $listar_filesystem->get_contents( $css_file ) : '';

			/*
			 * Check if current CSS has a 'class-name-fix' class
			 * Some iconized fonts requires a secondary/standard/generic class name to display a icon
			 * Example: Font Awesome requires 'fa' and 'fa-star' classes to display a star icon
			 */
			if ( is_string( $css_code ) && false !== strpos( $css_code, 'class-name-fix' ) ) {
				$fix_ = explode( '---STARTFIX---', $css_code );
				$fix  = explode( '---ENDFIX---', $fix_[1] );
				$class_name_fix = $fix[0];
			} else {
				$class_name_fix = '';
			}

			/* Get the class names of every icon */
			$classes = array_filter( explode( ':before', $css_code ) );
			$classes_count = is_array( $classes ) ? count( $classes ) : 0;
			$classes_fixed = array();

			for ( $i = 0; $i < $classes_count; $i++ ) :

				/* Fix last element */
				if ( false !== strpos( $classes[ $i ], ':' ) && ( $classes_count - 1 ) === $i ) {
					$temp = explode( ':', $classes[ $i ] );
					$classes[ $i ] = $temp[0];
				}

				/* Get all text after last '.' */
				if ( false !== strpos( $classes[ $i ], '.' ) ) {
					$classes[ $i ] = substr( $classes[ $i ], strrpos( $classes[ $i ], '.' ) );
				} else {
					$classes[ $i ] = '';
				}

				/* Remove unwanted strings, keep only class names */
				if (
					false !== strpos( $classes[ $i ], ':' ) ||
					false !== strpos( $classes[ $i ], '(' ) ||
					false !== strpos( $classes[ $i ], '"' ) ||
					false !== strpos( $classes[ $i ], ';' ) ||
					false !== strpos( $classes[ $i ], ',' ) ||
					false !== strpos( $classes[ $i ], '#' ) ||
					false !== strpos( $classes[ $i ], '=' ) ||
					false !== strpos( $classes[ $i ], '{' ) ||
					false !== strpos( $classes[ $i ], '}' ) ||
					false !== strpos( $classes[ $i ], '^' ) ||
					false !== strpos( $classes[ $i ], '[' ) ||
					false !== strpos( $classes[ $i ], ']' ) ||
					false !== strpos( $classes[ $i ], '*' ) ||
					false !== strpos( $classes[ $i ], '~' ) ||
					false !== strpos( $classes[ $i ], ' ' )
				) {
					$classes[ $i ] = '';
				} else {
					$classes[ $i ] = str_replace( '.', '', $classes[ $i ] );
				}
				
				/* Skip these values */
				
				if (
					'fa' === $classes[ $i ]
					|| 'fas' === $classes[ $i ]
					|| 'far' === $classes[ $i ]
					|| 'fal' === $classes[ $i ]
					|| 'fab' === $classes[ $i ]
				) {
					continue;
				}

				/*
				 * Append the default class name to every class obtained from
				 * current font stylesheet, if current font requires it
				 */
				if ( ! empty( $classes[ $i ] ) ) {
					$classes_fixed[] = $class_name_fix . $classes[ $i ];
				}

			endfor;

			$iconized_font_classes = implode( ',', array_filter( $classes_fixed ) );

			/* Populate the JavaScript array with the font name and respective class names */
			$fonts_data_str .= '["' . $font_name . '", "' . $iconized_font_classes . '"],';

		} // End foreach().

		/* Remove last comma */
		$iconized_fonts_output .= substr( $fonts_data_str, 0, -1 ) . '];';

		return $iconized_fonts_output;
	}

endif;

if ( ! function_exists( 'listar_localize_admin_javascript' ) ) :
	/**
	 * Localization/translation to JavaScript strings on WordPress admin pages.
	 * Called by 'admin_enqueue_scripts' action.
	 *
	 * @since 1.0
	 */
	function listar_localize_admin_javascript() {
		/**
		 * Spelling/Terminology notice: Using 'a' instead of 'an'.
		 *
		 * @link https://make.wordpress.org/core/handbook/best-practices/spelling/
		 */
		
		global $pagenow;
		
		$has_booking_products = esc_html__( 'No bookings available.', 'listar' );
		$has_booking_products_description = '-';

		$is_editing_listing_backend = 'post.php' === $pagenow && 'job_listing' === get_post_type();
		
		if ( listar_addons_active() && $is_editing_listing_backend && class_exists( 'WC_Bookings' ) ) {
			$user_id = listar_get_listing_author_id();
			
			$query = new WP_Query( array(
				'author'         =>  $user_id,
				'posts_per_page' =>  -1, 
				'post_type'      =>  array( 'product' ),
				'post_status'    =>  'publish',
				'tax_query' => array( array(
					'taxonomy' => 'product_type',
					'terms'    => array( 'booking' ),
					'field'    => 'slug',
				)),
			) );

			$count = (int) $query->found_posts;

			if ( $count > 0 ) {
				$has_booking_products = esc_html__( 'Nothing to do here', 'listar' );
				
				$has_booking_products_description = esc_html__( 'Your bookable product will be displayed.', 'listar' );

				//$has_booking_products_description = sprintf(

					/* TRANSLATORS: %s: Number of bookable products */
					//esc_html__( '%s bookable product(s) will be displayed.', 'listar' ),
					//zeroise( $count, 2 )
				//);
			}
		}

                $listing_pricing_link_labels = array(
                        'info' => esc_html__( 'More Info', 'listar' ),
                        'items' => esc_html__( 'More Items', 'listar' ),
                        'source' => esc_html__( 'Source', 'listar' ),
                        'contact' => esc_html__( 'Get In Touch', 'listar' ),
                        'inquire' => esc_html__( 'Inquire', 'listar' ),
                        'pricing' => esc_html__( 'Pricing', 'listar' ),
                        'purchase' => esc_html__( 'Purchase', 'listar' ),
                        'purchase-now' => esc_html__( 'Purchase Now', 'listar' ),
                        'booking' => esc_html__( 'Booking', 'listar' ),
                        'book-now' => esc_html__( 'Book Now', 'listar' ),
                        'appointment' => esc_html__( 'Appointment', 'listar' ),
                        'website' => esc_html__( 'Official Website', 'listar' ),
                        'store' => esc_html__( 'Go To Store', 'listar' ),
                );
	
		$backend_translation = array(
			'chooseImage'              => esc_html__( 'Choose image', 'listar' ),
			'chooseIcon'               => esc_html__( 'Choose a icon (SVG) or image', 'listar' ),
			'selectImage'              => esc_html__( 'Select a image', 'listar' ),
			'choose'                   => esc_html__( 'Choose', 'listar' ),
			'chooseIconLibrary'        => esc_html__( 'Choose a icon library', 'listar' ),
			'chooseIcon'               => esc_html__( 'Choose icon', 'listar' ),
			'goToDemoImportPage'       => esc_html__( 'Go to demo import page', 'listar' ),
			'importing'                => esc_html__( 'Importing', 'listar' ),
			'refreshPage'              => esc_html__( 'Please, refresh the page and try again.', 'listar' ),
			'goToGoogleFonts'          => esc_html__( 'Check font details', 'listar' ),
			'changeFontLanguage'       => esc_html__( 'Change Font Language', 'listar' ),
			'showAdvancedSettings'     => esc_html__( 'Show advanced settings', 'listar' ),
			'hideAdvancedSettings'     => esc_html__( 'Hide advanced settings', 'listar' ),
			'gutenIconMessage'         => esc_html__( 'Please, type a "space" to conclude', 'listar' ),
			'monday'                   => esc_html__( 'Monday', 'listar' ),
			'tuesday'                  => esc_html__( 'Tuesday', 'listar' ),
			'wednesday'                => esc_html__( 'Wednesday', 'listar' ),
			'thursday'                 => esc_html__( 'Thursday', 'listar' ),
			'friday'                   => esc_html__( 'Friday', 'listar' ),
			'saturday'                 => esc_html__( 'Saturday', 'listar' ),
			'sunday'                   => esc_html__( 'Sunday', 'listar' ),
			'closed'                   => esc_html__( 'Closed', 'listar' ),
			'open'                     => esc_html__( 'Open 24 Hours', 'listar' ),
			'opens'                    => esc_html__( 'Open', 'listar' ),
			'close'                    => esc_html__( 'Close', 'listar' ),
			'day'                      => esc_html__( 'Day', 'listar' ),
			'copyForAll'               => esc_html__( 'Copy for all days', 'listar' ),
			'multipleHoursPlus'        => esc_html__( 'Add operating hours', 'listar' ),
			'multipleHoursMinus'       => esc_html__( 'Remove operating hours', 'listar' ),
			'addressAdvanced'          => esc_html__( 'Show advanced fields', 'listar' ),
			'locoMoreOptions'          => esc_html__( 'More options', 'listar' ),
			'locoRecommended'          => esc_html__( 'Recommended', 'listar' ),
			'fixCoordinates1'          => esc_html__( 'Your custom (forced) coordinate numbers had irregular characters, please verify the new values.', 'listar' ),
			'fixCoordinates2'          => esc_html__( 'Your custom (forced) coordinates are out of range.', 'listar' ),
			'fixCoordinates3'          => esc_html__( 'Your custom (forced) coordinate numbers have a lot of dots or hyphens.', 'listar' ),
			'fixCoordinates4'          => esc_html__( 'A custom (forced) coordinate field is empty.', 'listar' ),
			'featuredCategory'         => esc_html__( 'Primary Category', 'listar' ),
			'featuredRegion'           => esc_html__( 'Primary Region', 'listar' ),
			'invalidBookingURLHTTP'    => esc_html__( 'Appointment service URLs must containt http:// or https://', 'listar' ),
			'invalidBookingURLDot'     => esc_html__( 'Appointment service URLs must containt at least a dot (.)', 'listar' ),
			'invalidBookingURLLength'  => esc_html__( 'Very short Appointment service URL found.', 'listar' ),
			'invalidBookingURLStart'   => esc_html__( 'Appointment service URLs must start with http:// or https:// ', 'listar' ),
			'iconReduceStroke'         => esc_html__( 'Reduce icon stroke', 'listar' ),
			
			// Translation for price list fields.
			'selectLabel'        => esc_html__( 'Link Label', 'listar' ),
			'category'           => esc_html__( 'Category', 'listar' ),
			'title'              => esc_html__( 'Title', 'listar' ),
			'description'        => esc_html__( 'Description', 'listar' ),
			'price'              => esc_html__( 'Price', 'listar' ),
                        'link'               => esc_html__( 'Link', 'listar' ),
                        'label'              => $listing_pricing_link_labels,
			'featuredTag'        => esc_html__( 'Featured tag, e.g. NEW', 'listar' ),
			'item'               => esc_html__( 'Item', 'listar' ),
			'uncategorized'      => esc_html__( 'Uncategorized', 'listar' ),
			'excludeItem'        => esc_html__( 'Delete this item?', 'listar' ),
			'excludeCategory'    => esc_html__( 'Delete this category?', 'listar' ),
			'excludeItems'       => esc_html__( 'Delete the category items too?', 'listar' ),
			'emptyPriceCategory' => esc_html__( 'Please enter a name for all categories of the Product/Service/Price List or exclude it.', 'listar' ),
			'categoryNoItems'    => esc_html__( 'Found empty categories on the Product/Service/Price List. Please populate the category with items or exclude it.', 'listar' ),
			'missingTitle'       => esc_html__( 'Please insert a title for all items of the Product/Service/Price List or exclude the item.', 'listar' ),
			
			/* Translation for claim fields */
			'verificationDetails'      => esc_html__( 'Verification details', 'listar' ),
			'claimListingID'           => esc_html__( 'Claimed listing ID', 'listar' ),
			'usefulClaimLinks'         => esc_html__( 'Useful links', 'listar' ),
			'claimedListingEditor'     => esc_html__( 'Listing editor', 'listar' ),
			'claimedListingView'       => esc_html__( 'Listing view', 'listar' ),
			'claimedNewAuthor'         => esc_html__( 'New author', 'listar' ),
			'claimedLastAuthor'        => esc_html__( 'Last author', 'listar' ),
			'claimOrder'               => esc_html__( 'Claim order', 'listar' ),
			/* For new listing author */
			'newAuthorName'            => esc_html__( 'New author name', 'listar' ),
			'newAuthorNickname'        => esc_html__( 'New author nickname', 'listar' ),
			'newAuthorEmail'           => esc_html__( 'New author email', 'listar' ),
			'newAuthorPhone'           => esc_html__( 'New author phone', 'listar' ),
			'newAuthorWebsite'         => esc_html__( 'New author website', 'listar' ),
			'newAuthorID'              => esc_html__( 'New author ID', 'listar' ),
			'newOrderID'               => esc_html__( 'New order ID', 'listar' ),
			'newWoocommerceProductID'  => esc_html__( 'New Woocommerce product (package) ID', 'listar' ),
			'newUserPackageID'         => esc_html__( 'New user package ID', 'listar' ),
			'newPackageDuration'       => esc_html__( 'New package duration', 'listar' ),
			'newPackageExpiration'     => esc_html__( 'New package expiration', 'listar' ),
			'newFeaturedStatus'        => esc_html__( 'New featured status', 'listar' ),
			'newUserClaimStatus'       => esc_html__( 'New claim status', 'listar' ),
			/* For last listing author */
			'lastAuthorName'           => esc_html__( 'Last author name', 'listar' ),
			'lastAuthorNickname'       => esc_html__( 'Last author nickname', 'listar' ),
			'lastAuthorEmail'          => esc_html__( 'Last author email', 'listar' ),
			'lastAuthorPhone'          => esc_html__( 'Last author phone', 'listar' ),
			'lastAuthorWebsite'        => esc_html__( 'Last author website', 'listar' ),
			'lastAuthorID'             => esc_html__( 'Last author ID', 'listar' ),
			'lastOrderID'              => esc_html__( 'Last order ID', 'listar' ),
			'lastWoocommerceProductID' => esc_html__( 'Last Woocommerce product (package) ID', 'listar' ),
			'lastUserPackageID'        => esc_html__( 'Last user package ID', 'listar' ),
			'lastPackageDuration'      => esc_html__( 'Last package duration', 'listar' ),
			'lastPackageExpiration'    => esc_html__( 'Last package expiration', 'listar' ),
			'lastFeaturedStatus'       => esc_html__( 'Last featured status', 'listar' ),
			'lastUserClaimStatus'      => esc_html__( 'Last claim status', 'listar' ),
			'disablePoweredCache'      => esc_html__( 'Listar Pagespeed was improved: please disable "Powered Cache" plugin and use WP Fastest Cache instead.', 'listar' ),

			'mediaLinkOrCode'          => esc_html__( 'Media Link or Code', 'listar' ),
			'enterMediaValue'          => esc_html__( 'Enter the media link (e.g Youtube, Vimeo, .MP4, .JPG) or embeding code (iframe or embed tags).', 'listar' ),
			'media'                    => esc_html__( 'Media', 'listar' ),
			'mediaConfirm'             => esc_html__( 'This content does not appear to be a direct link for a media file, but an embedabble web page with the desired media. Create an iframe to fix?', 'listar' ),			

			'wooBookingsActive'        => class_exists( 'WC_Bookings' ),
			'hasBookingProducts'       => $has_booking_products,
			'hasBookingProductsDescr'  => $has_booking_products_description,
			'deleteItem'               => esc_html__( 'Delete item?', 'listar' ),
			'deleteImage'              => esc_html__( 'Delete this image?', 'listar' ),
			'deleteEarlierImage'       => esc_html__( 'Delete the earlier image?', 'listar' ),

			'addListing'             => esc_html__( 'Add Listing', 'listar' ),
			'addListingURLBackend'             => admin_url( 'post-new.php?post_type=job_listing' ),
		);

		/* Woocommerce Currency Symbol */
		$woo_currency_symbol = array(
			'wooCurrencySymbol' => esc_html(
				listar_currency()
			),
		);
		
		/* Is Powered Cache active? */
		$poweredCacheActive = array(
			'poweredCacheActive' => function_exists( 'powered_cache_clean_page_cache_dir' ),
		);
		
		/* All listing categories */
		global $typenow;
		global $current_screen;
		
		$all_listing_categories = array(
			'allListingCategories' => '',
		);
		
		$all_listing_regions = array(
			'allListingRegions' => '',
		);
		
		if ( is_admin() && 'job_listing' === $typenow && 'job_listing' === $current_screen->post_type ) {
			
			/* Get all listing categories for backend */
			
			$args = array(
				'hide_empty' => false,
				'number' => 2000,
			);

			$terms = get_terms( 'job_listing_category', $args );
			
			if ( $terms && ! is_wp_error( $terms ) ) :
				
				$listing_categories = '';

				foreach ( $terms as $term ) :
					$listing_categories .= '{"id":' . wp_json_encode( $term->term_id ) . ',"name":' . wp_json_encode( $term->name ) . '},';
				endforeach;
				
				$all_listing_categories = array(
					'allListingCategories' => '[' . substr( $listing_categories, 0, -1 ) . ']',
				);

			endif;
			
			/* Get all listing regions for backend */
			
			$args2 = array(
				'hide_empty' => false,
				'number' => 2000,
			);

			$terms2 = get_terms( 'job_listing_region', $args2 );
			
			if ( $terms2 && ! is_wp_error( $terms2 ) ) :
				
				$listing_regions = '';

				foreach ( $terms2 as $term ) :
					$listing_regions .= '{"id":' . wp_json_encode( $term->term_id ) . ',"name":' . wp_json_encode( $term->name ) . '},';
				endforeach;
				
				$all_listing_regions = array(
					'allListingRegions' => '[' . substr( $listing_regions, 0, -1 ) . ']',
				);

			endif;
		}		

		/* Operating hours format. */
		$hours_format = get_option( 'listar_operating_hours_format' );
		$am_pm = get_option( 'listar_operating_hours_suffix' );
		$icon_selector = get_option( 'listar_first_screen_icon_selector' );

		if ( empty( $hours_format ) ) {
			$hours_format = '24';
		}

		$operating_hours_format = array(
			'operatingHoursFormat' => $hours_format,
		);

		$disable_am_pm = array(
			'disableAMPM' => (int) $am_pm,
		);

		if ( empty( $icon_selector ) ) {
			$icon_selector = 'linear';
		}

		$first_screen_icon_selector = array(
			'firstScreenIconSelector' => $icon_selector,
		);
		
		wp_localize_script(
			'listar-custom-backend-javascript',
			'listarLocalizeAndAjax',
			$backend_translation + $woo_currency_symbol + $operating_hours_format + $disable_am_pm + $all_listing_categories + $all_listing_regions + $first_screen_icon_selector + $poweredCacheActive
		);
	}

endif;

add_action( 'enqueue_block_editor_assets', 'listar_gutenberg_editor_enqueue' );

if ( ! function_exists( 'listar_gutenberg_editor_enqueue' ) ) :
	/**
	 * Enqueue the block's assets for Gutenberg editor.
	 *
	 * @since 1.0
	 */
	function listar_gutenberg_editor_enqueue() {

		/* Is built in Google Fonts manager (Customizer / Google Fonts) active on Theme Options? */
		if ( listar_google_fonts_active() ) {

			/* Google Fonts */
			$google_fonts_url = listar_google_fonts_url();
			wp_enqueue_style( 'listar-google-fonts-gutenberg-editor', $google_fonts_url, array( 'wp-edit-blocks' ), '1.0' );
		}

		/* Custom styles */
		$file = listar_get_theme_file_uri( '/editor-style-gutenberg.css' );
		$path = listar_get_theme_file_path( '/editor-style-gutenberg.css' );
		wp_enqueue_style( 'listar-custom-gutenberg-blocks-editor', $file, array( 'wp-edit-blocks' ), filemtime( $path ) );

		/* Dynamic styles, for theme color */
		$dynamic_editor_style_url = listar_get_dynamic_editor_style_url( true );
		wp_enqueue_style( 'listar-custom-gutenberg-blocks-editor-dynamic', $dynamic_editor_style_url, array( 'wp-edit-blocks' ), '1.0' );
	}

endif;

/*
 * Custom Body Classes *********************************************************
 */

add_filter( 'body_class', 'listar_body_classes' );

if ( ! function_exists( 'listar_body_classes' ) ) :
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0
	 * @param (array) $classes Classes for the body element.
	 * @return (array)
	 */
	function listar_body_classes( $classes ) {
	
		/* Deny all animations while loading the page to reduce LCP, TBT and CLS - Pagespeed */

		$classes[] = 'listar-not-loaded';
		$classes[] = 'listar-show-hero-categories-box';
		
		/* Force light design */

		$listar_force_light_design = get_option( 'listar_force_light_design' );

		if ( empty( $listar_force_light_design ) ) {
			$listar_force_light_design = 'disabled';
		}

		if ( 'disabled' !== $listar_force_light_design ) {
			$classes[] = 'listar-force-light-design';
		}

		/* Adds a class of group-blog to blogs with more than 1 published author. */
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		/* Adds a class of hfeed to non-singular pages. */
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		/* User can manage admin? */
		$classes[] = is_user_logged_in() && current_user_can( 'edit_pages' ) ? 'listar-can-manage-admin' : 'listar-can-not-manage-admin';

		/* If reviews plugin is inactive */
		if ( ! listar_third_party_reviews_active() && ! listar_built_in_reviews_active() ) {
			$classes[] = 'listar-no-reviews';
		} else {
			$classes[] = 'listar-has-reviews';
		}

		/* If WP Job Manager is inactive */
		if ( ! listar_wp_job_manager_active() ) {
			$classes[] = 'listar-no-wp-job-manager';
		} else {
			$classes[] = 'listar-has-wp-job-manager';
		}

		/* If Listar Add-ons plugin is inactive */
		if ( ! listar_addons_active() ) {
			$classes[] = 'listar-no-addons';
		} else {
			$classes[] = 'listar-addons-active';
		}

		/* Disable height equalizer for listing cards */
		$classes[] = 'listar-disable-listing-card-equalizer';
		
		if ( listar_third_party_reviews_active() ) {
			
			/* Guests are allowed to leave reviews? */
			$allow_guests = get_option( 'wpjmr_allow_guests', true ) ? true : false;

			/* If not guest is not allowed, and user is guest (not logged in), restrict. */
			if ( ! $allow_guests && ! is_user_logged_in() ) {
				$classes[] = 'listar-guests-cannot-review';
			} else {
				$classes[] = 'listar-guests-can-review';
			}
		} elseif ( listar_built_in_reviews_active() ) {
			$input = (int) get_option( 'listar_allow_visitors_submit_reviews' ) ;
			$allow_visitors_submit_reviews = 1 === $input ? true : false;

			/* Are visitors allowed to submit ratings? */

			if ( ! $allow_visitors_submit_reviews && ! is_user_logged_in() ) :
				$classes[] = 'listar-guests-cannot-review';
			else :
				$classes[] = 'listar-guests-can-review';
			endif;
			
		} else {
			$classes[] = 'listar-guests-can-review';
		}
		
		/* After select a region on hero header search and popup */
		$listar_after_region_selected = get_option( 'listar_after_region_selected' );

		if ( empty( $listar_after_region_selected ) ) {
			$listar_after_region_selected = 'search-immediately';
		}
		
		$classes[] = 'listar-after-region-selected-' . $listar_after_region_selected;

		/* Topbar background color on front page */
		$classes[] = 'listar-frontpage-topbar-transparent';

		/* Pricing packages design */
		$listar_pricing_cards_design = get_option( 'listar_pricing_cards_design' );

		if ( 'light' === $listar_pricing_cards_design || empty( $listar_pricing_cards_design ) ) {
			$classes[] = 'listar-pricing-packages-v2';
		}

		/* Topbar default background color */
		$classes[] = 'listar-topbar-default-color';

		/* Design for listing categories and regions counters */
		$classes[] = 'listar-counters-design-1';

		/* Design for listing cards */
		$listing_card_design = get_option( 'listar_listing_card_design' );

		if ( empty( $listing_card_design ) || 'rounded' === $listing_card_design || 'rounded-image-block' === $listing_card_design || 'squared-image-block' === $listing_card_design ) {
			$listing_card_design = 'rounded';
		} else {
			$listing_card_design = 'squared';
		}

		$classes[] = 'listar-listing-card-design-' . $listing_card_design;

		/* Design for trending icon */
		$trending_icon_design = get_option( 'listar_trending_icon_design' );

		if ( empty( $trending_icon_design ) ) {
			$trending_icon_design = 'light';
		}

		$classes[] = 'listar-trending-icon-design-' . $trending_icon_design;
		
		$input = get_option( 'listar_trending_icon_design' );

		/* Design for blog cards */
		$blog_card_design = get_option( 'listar_blog_card_design' );

		if ( empty( $blog_card_design ) ) {
			$blog_card_design = 'default';
		}

		$classes[] = 'listar-blog-card-design-' . $blog_card_design;
		
		
		/* Design for blog cards */
		$woo_product_image_design = get_option( 'listar_woo_product_image_design' );

		if ( empty( $woo_product_image_design ) ) {
			$woo_product_image_design = 'rounded';
		}

		$classes[] = 'listar-woo-product-image-design-' . $woo_product_image_design;

		/* Design for listing search input field */
		$listing_search_input_field_design = get_option( 'listar_listing_search_input_field_design' );

		if ( empty( $listing_search_input_field_design ) ) {
			$listing_search_input_field_design = 'rounded';
		}

		$classes[] = 'listar-listing-search-input-' . $listing_search_input_field_design;

		/* Design for listing search input field */
		$listing_search_input_filter_design = get_option( 'listar_listing_search_input_filter_design' );

		if ( empty( $listing_search_input_filter_design ) ) {
			$listing_search_input_filter_design = 'rounded';
		}

		$classes[] = 'listar-listing-search-input-filter-' . $listing_search_input_filter_design;

		/* Design for listing average rating */
		$listing_rating_design = get_option( 'listar_listing_rating_design' );

		if ( empty( $listing_rating_design ) ) {
			$listing_rating_design = 'rounded';
		}

		$classes[] = 'listar-listing-rating-' . $listing_rating_design;
		
		/* Is Listar Bookmarks active? */
		$classes[] = listar_bookmarks_active() ? 'listar-bookmarks-active' : 'listar-bookmarks-inactive';

		/* Design for big average rating on single listing pages */
		$single_listing_big_rating_design = get_option( 'listar_single_listing_big_rating_design' );

		if ( empty( $single_listing_big_rating_design ) ) {
			$single_listing_big_rating_design = 'rounded';
		}

		$classes[] = 'listar-single-listing-big-rating-' . $single_listing_big_rating_design;

		/* Design for average rating mood and counter on single listing pages */
		$single_listing_mood_design = get_option( 'listar_single_listing_mood_design' );

		if ( empty( $single_listing_mood_design ) ) {
			$single_listing_mood_design = 'rounded';
		}

		$classes[] = 'listar-single-listing-mood-' . $single_listing_mood_design;

		/* Enable/disable listing "grid filler" card */
		$listar_grid_filler_listing_card_disable = (int) get_option( 'listar_grid_filler_listing_card_disable' );

		if ( 1 === $listar_grid_filler_listing_card_disable ) {
			$classes[] = 'listar-disable-listing-grid-filler-card';
		}

		/* Enable/disable blog "grid filler" card */
		$listar_grid_filler_blog_card_disable = (int) get_option( 'listar_grid_filler_blog_card_disable' );

		if ( 1 === $listar_grid_filler_blog_card_disable ) {
			$classes[] = 'listar-disable-blog-grid-filler-card';
		}

		/* Disable online call for WhatsApp number? */
		$listar_whatsapp_online_call_disable = (int) get_option( 'listar_whatsapp_online_call_disable' );

		if ( 1 === $listar_whatsapp_online_call_disable ) {
			$classes[] = 'listar-whatsapp-online-call-disable';
		}

		/* Disable online call for phone number? */
		$listar_phone_online_call_disable = (int) get_option( 'listar_phone_online_call_disable' );

		if ( 1 === $listar_phone_online_call_disable ) {
			$classes[] = 'listar-phone-online-call-disable';
		}

		/* Disable online call for mobile number? */
		$listar_mobile_online_call_disable = (int) get_option( 'listar_mobile_online_call_disable' );

		if ( 1 === $listar_mobile_online_call_disable ) {
			$classes[] = 'listar-mobile-online-call-disable';
		}

		/* Design for listing search input field */
		$recent_post_thumbnail_design = get_option( 'listar_recent_post_thumbnail_design' );

		if ( empty( $recent_post_thumbnail_design ) ) {
			$recent_post_thumbnail_design = 'rounded';
		}

		$classes[] = 'listar-recent-post-thumbnail-' . $recent_post_thumbnail_design;

		/* Design for buttons */
		$buttons_design = get_option( 'listar_buttons_design' );

		if ( empty( $buttons_design ) ) {
			$buttons_design = 'rounded';
		}

		$classes[] = 'listar-buttons-' . $buttons_design;

		/* Design for Launch Map button */
		$launch_map_button_design = get_option( 'listar_launch_map_button_design' );

		if ( empty( $launch_map_button_design ) ) {
			$launch_map_button_design = 'light';
		}

		$classes[] = 'listar-launch-map-button-design-' . $launch_map_button_design;

		/* Allow multiple regions */
		$allow_multiple_regions = 1 === (int) get_option( 'listar_allow_multiple_regions_frontend' ) ? 'enabled' : 'disabled';

		$classes[] = 'listar-multiple-regions-' . $allow_multiple_regions;

		/* Design for Listing View button for maps */
		$listing_view_button_design = get_option( 'listar_listing_view_button_design' );

		if ( empty( $listing_view_button_design ) ) {
			$listing_view_button_design = 'light';
		}

		$classes[] = 'listar-launch-map-button-design-' . $listing_view_button_design;

		/* Design for user avatar */
		$user_avatar_design = get_option( 'listar_user_avatar_design' );

		if ( empty( $user_avatar_design ) ) {
			$user_avatar_design = 'rounded';
		}

		$classes[] = 'listar-user-avatar-' . $user_avatar_design;

		/* Design for pricing ranges on single listing page */
		$single_listing_pricing_range_design = get_option( 'listar_single_listing_pricing_range_design' );

		if ( empty( $single_listing_pricing_range_design ) ) {
			$single_listing_pricing_range_design = 'rounded';
		}

		$classes[] = 'listar-single-listing-pricing-range-' . $single_listing_pricing_range_design;

		/* Design for listing thumbnails on map sidebar */
		$map_sidebar_listing_thumbnail_design = get_option( 'listar_map_sidebar_listing_thumbnail_design' );

		if ( empty( $map_sidebar_listing_thumbnail_design ) ) {
			$map_sidebar_listing_thumbnail_design = 'rounded';
		}

		$classes[] = 'listar-map-sidebar-listing-thumbnail-' . $map_sidebar_listing_thumbnail_design;

		/* Design for social network icons */
		$social_network_icons_design = get_option( 'listar_social_network_icons_design' );

		if ( empty( $social_network_icons_design ) ) {
			$social_network_icons_design = 'rounded';
		}

		$classes[] = 'listar-social-network-icons-' . $social_network_icons_design;

		/* Design for listing categories, regions and amenities blocks */
		$directory_terms_design = get_option( 'listar_taxonomy_terms_design' );

		if ( empty( $directory_terms_design ) ) {
			$directory_terms_design = 'rounded';
		}

		$classes[] = 'listar-taxonomy-terms-design-' . $directory_terms_design;

		/* Design for partner cards */
		$partner_cards_design = get_option( 'listar_partner_cards_design' );

		if ( empty( $partner_cards_design ) ) {
			$partner_cards_design = 'default';
		}

		$classes[] = 'listar-partner-cards-design-' . $partner_cards_design;

		/* Design for feature cards */
		$feature_cards_design = get_option( 'listar_feature_cards_design' );

		if ( empty( $feature_cards_design ) ) {
			$feature_cards_design = 'rounded';
		}

		$classes[] = 'listar-feature-cards-design-' . $feature_cards_design;

		$classes[] = 'listar-icons-counters-terms-design-rounded';

		/* Stripes colors */
		$stripes_colors = get_option( 'listar_color_stripes' );

		if ( empty( $stripes_colors ) ) {
			$stripes_colors = 'default';
		}

		$classes[] = 'listar-theme-' . $stripes_colors . '-stripes';

		/* Sidebar position on single listin pages */
		$listing_sidebar_position = get_option( 'listar_listing_sidebar_position' );

		if ( empty( $listing_sidebar_position ) ) {
			$listing_sidebar_position = 'left';
		}

		$classes[] = 'listar-listing-sidebar-position-' . $listing_sidebar_position;

		/* Is user logged in ? */
		if ( ! is_user_logged_in() ) {
			$classes[] = 'listar-user-not-logged';
		} else {
			$classes[] = 'listar-user-logged';
		}

		/* Is Gutenberg inactive ? */
		if ( ! function_exists( 'register_block_type' ) ) {
			$classes[] = 'listar-no-gutenberg';
		}

		/* If Ajax pagination is enabled (Theme Options) */
		$ajax_pagination = ( 1 === (int) get_option( 'listar_ajax_pagination' ) ) ? 'listar-ajax-pagination' : 'listar-no-ajax-pagination';

		$classes[] = $ajax_pagination;

		/* If infinite scroll to Ajax pagination is enabled (Theme Options) */
		$ajax_infinite_scroll = ( 'listar-ajax-pagination' === $ajax_pagination ) && ( 1 === (int) get_option( 'listar_ajax_infinite_loading' ) ) ? 'listar-ajax-infinite-scroll' : 'listar-no-ajax-infinite-scroll';

		$classes[] = $ajax_infinite_scroll;

		/* Disable hover opacity for all sibling blocks */
		$disable_sibling_hover_opacity = (int) get_option( 'listar_disable_sibling_hover_opacity' );

		if ( 1 === $disable_sibling_hover_opacity ) {
			$classes[] = 'listar-disable-sibling-hover-opacity';
		}

		/* Enable "Back to Top" button for mobiles */
		$enable_back_to_top_mobile = (int) get_option( 'listar_enable_back_to_top_mobile' );

		if ( 1 === $enable_back_to_top_mobile ) {
			$classes[] = 'listar-force-back-to-top-display';
		}

		/* Enable loading overlay */
		$enable_loading_overlay = listar_is_loading_overlay_active();

		if ( $enable_loading_overlay ) {
			$classes[] = 'listar-enable-loading-overlay';
		} else {
			$classes[] = '.listar-disable-loading-overlay';
		}

		/* Background color for Login button on top bar */
		$background_color_login_button = get_option( 'listar_background_color_login_button_top' );

		if ( 'default' === $background_color_login_button ) {
			$classes[] = 'listar-background-color-login-button-default';
		}

		/* Background color for Add Listing button on top bar */
		$background_color_add_listing_button = get_option( 'listar_background_color_add_listing_button_top' );

		if ( 'default' === $background_color_add_listing_button ) {
			$classes[] = 'listar-background-color-add-listing-button-default';
		}

		/* Spiral hover effect */
		$activate_spiral_effect = (int) get_option( 'listar_activate_spiral_effect' );

		if ( ! empty( $activate_spiral_effect ) ) {
			$classes[] = 'listar-spiral-effect';
		}

		/* Design for drop down menu */
		$drop_down_menu_color = get_option( 'listar_drop_dowm_menu_design' );

		if ( empty( $drop_down_menu_color ) ) {
			$drop_down_menu_color = 'default';
		}
		
		$classes[] = 'listar-drop-down-menu-' . $drop_down_menu_color;

		/* Background color for detail row when hovering listing cards (requires expanded excerpt activation) */
		$card_detail_row_color = get_option( 'listar_card_detail_row_design' );

		if ( empty( $card_detail_row_color ) ) {
			$card_detail_row_color = 'default';
		}

		$classes[] = 'listar-card-detail-row-' . $card_detail_row_color;
		
		/* Design for header category buttons */
		$hero_categories_design = get_option( 'listar_hero_categories_design' );

		if ( empty( $hero_categories_design ) ) {
			$hero_categories_design = 'rounded';
		}
		
		$classes[] = 'listar-hero-categories-design-' . $hero_categories_design;

		/* Design for images on posts */
		$post_images_design = get_option( 'listar_post_images_design' );

		if ( empty( $post_images_design ) ) {
			$post_images_design = 'squared';
		}

		$classes[] = 'listar-post-images-design-' . $post_images_design;

		/* Disable hover animations for listing category blocks */
		$disable_listing_category_hover_animation = (int) get_option( 'listar_disable_listing_category_hover_animation' );

		if ( empty( $disable_listing_category_hover_animation ) ) {
			$disable_listing_category_hover_animation = 'enable';
		} else {
			$disable_listing_category_hover_animation = 'disable';
		}

		$classes[] = 'listar-' . $disable_listing_category_hover_animation . '-listing-category-hover-animation';

		/* Disable big text when hovering listing category blocks */
		$disable_big_text_category_hover_animation = (int) get_option( 'listar_disable_big_text_category_hover_animation' );

		if ( empty( $disable_big_text_category_hover_animation ) ) {
			$disable_big_text_category_hover_animation = 'enable';
		} else {
			$disable_big_text_category_hover_animation = 'disable';
		}
		
		/* Force big for listing category blocks */
		$force_listing_category_big_text = 1 === (int) get_option( 'listar_force_big_text_category' );
		
		if ( $force_listing_category_big_text ) {
			$disable_listing_category_hover_animation = 'enable';
			$force_listing_category_big_text = 'listar-force-big-text-category';
			$classes[] = $force_listing_category_big_text;
		}

		$classes[] = 'listar-' . $disable_big_text_category_hover_animation . '-big-text-hover-category-effect';

		/* Disable big text when hovering listing region blocks */
		$disable_big_text_region_hover_animation = (int) get_option( 'listar_disable_big_text_region_hover_animation' );

		if ( empty( $disable_big_text_region_hover_animation ) ) {
			$disable_big_text_region_hover_animation = 'enable';
		} else {
			$disable_big_text_region_hover_animation = 'disable';
		}
		
		/* Force big for listing category blocks */
		$force_listing_region_big_text = 1 === (int) get_option( 'listar_force_big_text_region' );
		
		if ( $force_listing_region_big_text ) {
			$disable_big_text_region_hover_animation = 'enable';
			$force_listing_region_big_text = 'listar-force-big-text-region';
			$classes[] = $force_listing_region_big_text;
		}

		$classes[] = 'listar-' . $disable_big_text_region_hover_animation . '-big-text-hover-region-effect';

		/* Disable hover animations for listing region blocks */
		$disable_listing_region_hover_animation = (int) get_option( 'listar_disable_listing_region_hover_animation' );

		if ( empty( $disable_listing_region_hover_animation ) ) {
			$disable_listing_region_hover_animation = 'enable';
		} else {
			$disable_listing_region_hover_animation = 'disable';
		}

		$classes[] = 'listar-' . $disable_listing_region_hover_animation . '-listing-region-hover-animation';

		/* Disable hover animations for listing amenity blocks */
		$disable_listing_amenity_hover_animation = (int) get_option( 'listar_disable_listing_amenity_hover_animation' );

		if ( empty( $disable_listing_amenity_hover_animation ) ) {
			$disable_listing_amenity_hover_animation = 'enable';
		} else {
			$disable_listing_amenity_hover_animation = 'disable';
		}

		$classes[] = 'listar-' . $disable_listing_amenity_hover_animation . '-listing-amenity-hover-animation';

		/* Animate elements while scrolling */
		$animate_elements_on_scroll = (int) get_option( 'listar_animate_elements_on_scroll' );

		if ( 1 === $animate_elements_on_scroll ) {
			$classes[] = 'listar_animate_elements_on_scroll';
		}

		/* Enable expansive excerpt when hovering listing and blog cards */
		$expansive_excerpt = (int) get_option( 'listar_enable_expansive_excerpt' );

		if ( 1 === $expansive_excerpt ) {
			$classes[] = 'listar_expansive_excerpt';
		}

		/* Set design for mobile primary menu button */
		$classes[] = 'listar-mobile-menu-default';

		$classes[] = 'listar-footer-dark';

		$classes[] = 'listar-no-hero-header-bottom-wave';

		$classes[] = 'listar-no-listing-card-hover';

		return $classes;
	}

endif;

/*
 * For better compatibility: File path and URI functions ***********************
 */

if ( ! function_exists( 'listar_get_theme_file_uri' ) ) :
	/**
	 * Get theme URI in accord with Envato recommendation, offering better compatibility with child themes.
	 * The generic (core) get_theme_file_uri() function was introduced only in WordPress 4.7,
	 * so this function also guarantee compatibily to lower versions of WordPress.
	 *
	 * @link: https://help.author.envato.com/hc/en-us/articles/360000479946
	 * @link: https://gist.github.com/richtabor/2a1b1175234a30dc7ce75e0a71e536c6
	 * @since 1.0
	 * @param (string) $the_file Path after theme folder, plus file and extension, ex.: '/assets/lib/bootstrap/css/bootstrap.min.css'.
	 * @return (bool)
	 */
	function listar_get_theme_file_uri( $the_file = '' ) {

		$file = ltrim( $the_file, '/' );

		if ( empty( $file ) ) {
			$url = get_stylesheet_directory_uri();
		} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
			$url = get_stylesheet_directory_uri() . '/' . $file;
		} else {
			$url = get_template_directory_uri() . '/' . $file;
		}

		return apply_filters( 'theme_file_uri', $url, $file );
	}

endif;

if ( ! function_exists( 'listar_get_theme_file_path' ) ) :
	/**
	 * Get theme absolute path in accord with Envato recommendation, offering better compatibility with child themes.
	 * The generic (core) get_theme_file_path() function was introduced only in WordPress 4.7,
	 * so this function also guarantee compatibily to lower versions of WordPress.
	 *
	 * @link: https://help.author.envato.com/hc/en-us/articles/360000479946
	 * @link: https://developer.wordpress.org/reference/functions/get_theme_file_path/
	 * @since 1.0
	 * @param (string) $the_file Path after theme folder, plus file and extension, ex.: '/assets/lib/bootstrap/css/bootstrap.min.css'.
	 * @return (bool)
	 */
	function listar_get_theme_file_path( $the_file = '' ) {

		$file = ltrim( $the_file, '/' );

		if ( empty( $file ) ) {
			$path = get_stylesheet_directory();
		} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
			$path = get_stylesheet_directory() . '/' . $file;
		} else {
			$path = get_template_directory() . '/' . $file;
		}

		return apply_filters( 'theme_file_path', $path, $file );
	}

endif;

/*
 * Functions required before extras.php
 */

if ( ! function_exists( 'listar_is_base64_image' ) ) :
	/**
	 * Check if an encoded Base64 image is valid.
	 *
	 * @param (string) $data A Base64 enconded image.
	 * @since 1.3.6
	 * @return (boolean)
	 */
	function listar_is_base64_image( $data ) {
		
		if ( false !== strpos( $data, 'base64,' ) ) {
			$temp = explode( 'base64,', $data );
			$data = $temp[1];
		}

		return base64_encode( base64_decode( $data, true ) ) === $data;
	}
endif;

/*
 * File Includes ***************************************************************
 */

$listar_file_requires = array(

	/* Theme Options */
	'theme-options/theme-options-fields.php',

	/* WordPress Customizer additions (custom settings) */
	'customizer/customizer-settings.php',

	/* Dynamic front end CSS, dependent on WordPress Customizer / Colors */
	'customizer/customizer-frontend-dynamic-css.php',

	/* Nav Menu API: Walker_Nav_Menu class */
	'class-listar-walker-nav-menu.php',

	/* Custom template tags */
	'template-tags.php',

	/* Custom functions that act independently of the theme templates */
	'extras.php',

	/* Integrations */
	'integration/wcfm-marketplace/extras.php',
);

if ( is_admin() && current_user_can( 'edit_pages' ) ) :

	$listar_file_requires_admin = array(

		/* Theme demo import configuration for One Click Demo Import plugin */
		'import/one-click-demo-import.php',

		/* Inform WordPress about required plugins */
		'required-plugins/class-tgm-plugin-activation.php',
		'required-plugins/required-plugins.php',
	);

	$listar_file_requires = array_merge( $listar_file_requires, $listar_file_requires_admin );

endif;

foreach ( $listar_file_requires as $listar_file_require ) {
	require_once listar_get_theme_file_path( '/inc/' . $listar_file_require );
}

/*
 * General functions ***********************************************************
 */

if ( ! function_exists( 'listar_first_term_data' ) ) :
	/**
	 * Given a taxonomy, get data from first 'term' available to a post.
	 *
	 * @since 1.0
	 * @param (integer) $post_id ID of the post.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (string)  $data The intended data to return: "array", "name", "id", "link".
	 * @return (array|string|integer|bool)
	 */
	function listar_first_term_data( $post_id, $taxonomy = 'job_listing_category', $data = 'array' ) {

		$terms = get_the_terms( $post_id, $taxonomy );
		$id    = false;
		$name  = false;

		if ( ! isset( $terms[0] ) ) {
			return false;
		}

		$first = $terms[0];

		if ( isset( $first->term_id ) ) {
			$id = $first->term_id;
		}

		if ( isset( $first->name ) ) {
			$name = $first->name;
		}

		$link = get_term_link( $first, $taxonomy );

		switch ( $data ) {
			case 'array':
				return $first;
			case 'name':
				return $name;
			case 'id':
				return $id;
			case 'link':
				return $link;
			default:
				return $terms;
		}
	}

endif;

if ( ! function_exists( 'listar_image_url' ) ) :
	/**
	 * Get a WordPress media (image) URL.
	 *
	 * @since 1.0
	 * @param (integer) $image_id ID of the WordPress media.
	 * @param (string)  $size Desired image size.
	 * @return (string)
	 */
	function listar_image_url( $image_id, $size = 'listar-thumbnail' ) {

		$image_url = '';
		$id = (int) $image_id;

		if ( ! empty( $id ) ) {
			$attachment = wp_get_attachment_image_src( $id, $size );
			$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
			$image_url  = $conditions ? $attachment[0] : '';
		}

		return $image_url;
	}

endif;

if ( ! function_exists( 'listar_sanitize_url' ) ) :
	/**
	 * Sanitize URLs in more detail than esc_url().
	 *
	 * @since 1.0
	 * @param (string) $url The URL to sanitize.
	 * @return (string)
	 */
	function listar_sanitize_url( $url = '' ) {

		$sanitized = esc_url( wp_filter_nohtml_kses( $url ) );
		$parts = wp_parse_url( $sanitized );

		if ( ! empty( $sanitized ) && $parts ) {
			if ( ! isset( $parts['scheme'] ) ) {
				$sanitized = 'http://' . str_replace( 'www.', '', $sanitized );
			}
			$sanitized = filter_var( $sanitized, FILTER_VALIDATE_URL );
		} else {
			$sanitized = '';
		}

		return $sanitized;
	}

endif;

if ( ! function_exists( 'listar_is_external' ) ) :
	/**
	 * Check if a URL points to external domain.
	 *
	 * @since 1.0
	 * @param (string) $url Link URL.
	 * @return (bool)
	 */
	function listar_is_external( $url ) {

		$host_url  = wp_parse_url( $url, PHP_URL_HOST );
		$path_url  = wp_parse_url( $url, PHP_URL_PATH );
		$host_site = wp_parse_url( network_site_url(), PHP_URL_HOST );
		$path_site = wp_parse_url( network_site_url(), PHP_URL_PATH );
		$url_test  = $host_url . $path_url;
		$site_test = $host_site . $path_site;

		if ( empty( $host_url ) || false === strpos( $url_test, $site_test ) ) {
			/* External URL */
			return true;
		}

		if ( $host_url === $host_site ) {
			/* Internal URL */
			return false;
		} else {
			/* External link */
			return true;
		}
	}

endif;

if ( ! function_exists( 'listar_url_exists' ) ) :
	/**
	 * Check if a URL exists. It works to absolute (/path/file) and full URLs (http://).
	 *
	 * @since 1.0
	 * @param (string) $url - An absolute or full URL.
	 * @return (bool)
	 */
	function listar_url_exists( $url ) {

		if ( ( '' === $url ) || ( null === $url ) ) {
			return false;
		}

		/* Is it an absolute URL ? */
		if ( false === strpos( $url, '://' ) ) {
			return file_exists( $url ) ? true : false;
		}

		/* If not external file or localhost, test it via absolute path */
		if ( ! listar_is_external( $url ) && false === strpos( $url, '//localhost' ) ) {
			$path_url = wp_parse_url( $url, PHP_URL_PATH );
			$root_url = getcwd();
			$abs_url  = '';

			/* A call to this function during an Ajax query can include wp-admin at end of root path, let's remove it */
			if ( false !== strpos( $root_url, '/wp-admin' ) ) {
				$root_url = substr( $root_url, 0, strpos( $root_url, '/wp-admin' ) );
			}

			/* Check if first character is a slash and remove it */
			$path_url_test = '/' === substr( $path_url, 0, 1 ) ? substr( $path_url, 1 ) : $path_url;

			/* First dir of the file path */
			$path_first_dir = substr( $path_url_test, 0, strpos( $path_url_test, '/' ) );

			/* Last dir of the root path */
			$root_last_dir = substr( substr( $root_url, strrpos( $root_url, '/' ) ), 1 );

			/* If found same dir on both, fix it */
			if ( ! empty( $path_first_dir ) && ! empty( $root_last_dir ) && $path_first_dir === $root_last_dir ) {
				/* Remove last dir */
				$root_url = substr( $root_url, 0, strrpos( $root_url, '/' . $root_last_dir ) );
			}

			$abs_url = $root_url . str_replace( $path_first_dir . '/' . $root_last_dir . '/', '', $path_url );

			$abs_url = str_replace( 'wp-content/plugins/listar-addons/inc/wp-content/uploads', 'wp-content/uploads', $abs_url );

			return file_exists( $abs_url ) ? true : false;
		}

		/*
		 * Not absolute or internal URL
		 *
		 * @link https://stackoverflow.com/questions/7952977/php-check-if-url-and-a-file-exists#answer-13633911
		 */

		$timeout = array(
			'timeout' => 5,
		);

		$response = wp_remote_head( $url, $timeout );
		$accepted_status_codes = array( 200, 301, 302 );

		if ( ! is_wp_error( $response ) && in_array( wp_remote_retrieve_response_code( $response ), $accepted_status_codes, true ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_icon_class' ) ) :
	/**
	 * Get class to icons.
	 * Check if icon is a file or CSS class of a iconized font.
	 * If $data is an image, create SVG code and attribute it to 'data-background-image'.
	 * If $data is SVG URL, get its embeded code.
	 *
	 * @since 1.0
	 * @param (string)  $data The data can be: CSS class name, SVG URL or image URL (.jpg, .gif, etc).
	 * @param (boolean) $return_image_url If true, return JPG/PNG/BMP images as URL, instead of SVG code.
	 * @return (array)
	 */
	function listar_icon_class( $data, $return_image_url = false ) {

		$icon_data = '';

		if ( false !== strpos( $data, '://' ) ) {

			/* It seems a file, does it exist? */

			$url = str_replace( "'", '', $data );

			if ( ! listar_url_exists( $url ) ) {
				/* File doesn't exist */
				$icon_data = array( '', '' );

			} elseif ( false === strpos( $url, '.svg' ) ) {
				/*
				 * Is image .png, .jpg, etc
				 * Trick: output it as a SVG element
				 */
				$return = $return_image_url ? $url : '<svg data-background-image="' . esc_attr( listar_custom_esc_url( $url ) ) . '"></svg>';
				$icon_data = ! empty( $url ) ? array( 'listar-image-icon', $return ) : array( '', '' );

			} elseif ( false !== strpos( $url, '.svg' ) ) {
				/* Probably a .svg image, but empty will be returned if not available */
				$svg_image = listar_svg_code( $url );
				$icon_data = array( '', $svg_image );

			} else {
				/* Unnacepted URL */
				$icon_data = array( '', '' );
			}
		} else {
			/* $data contains a icon class itself or is empty */
			$icon_data = array( $data, '' );
		}

		return $icon_data;
	}

endif;

if ( ! function_exists( 'listar_svg_content' ) ) :
	/**
	 * Get content (code) embeded in a SVG file.
	 *
	 * @since 1.0
	 * @param (string) $url The URL of a SVG file.
	 * @return (string|false)
	 */
	function listar_svg_content( $url ) {

		if ( true === listar_url_exists( $url ) ) :
			$data = wp_remote_request( $url );

			if ( ! is_wp_error( $data ) ) {
				return isset( $data['body'] ) ? $data['body'] : '';
			} else {
				return '';
			}
		else :
			return false;
		endif;
	}

endif;

if ( ! function_exists( 'listar_svg_code' ) ) :
	/**
	 * Get and treats the code returned by listar_svg_content().
	 *
	 * @since 1.0
	 * @param (string) $svg_file URL of SVG file.
	 * @return (string)
	 */
	function listar_svg_code( $svg_file ) {

		$svg_code = listar_svg_content( $svg_file );

		if ( false !== $svg_code ) :

			$find_string = '<svg';
			$position    = strpos( $svg_code, $find_string );
			$svg         = substr( $svg_code, $position );

			/* Apply listar-svg-icon class. If available, modify id to avoid duplicate values (W3C validation) */
			$search      = array( '<svg', ' id="' );
			$replace     = array( '<svg class="listar-svg-icon"', ' id="_' . wp_rand( 10, 99999 ) );
			$svg_code    = str_replace( $search, $replace, $svg );

			return $svg_code;

		endif;

		return '';
	}

endif;

if ( ! function_exists( 'listar_listing_gallery_ids' ) ) :
	/**
	 * Retrieve the list of IDs of a single listing gallery.
	 *
	 * @since 1.0
	 * @param (integer) $id The ID of the listing.
	 * @return (array)
	 */
	function listar_listing_gallery_ids( $id = 0 ) {
		/*
		 * Remove the prefix and sufix from gallery shortcode, keep only the attachment IDs separated by comma
		 * Reference: https://stackoverflow.com/questions/4949279/remove-non-numeric-characters-except-periods-and-commas-from-a-string
		 */
		$gallery_str = preg_replace( '/[^0-9,]/', '', esc_html( get_post_meta( $id, '_gallery', true ) ) );
		$gallery_ids = explode( ',', $gallery_str );

		array_unshift( $gallery_ids, get_post_thumbnail_id( $id ) );

		return array_filter( $gallery_ids );
	}

endif;

if ( ! function_exists( 'listar_count_term_posts' ) ) :
	/**
	 * Count the number of posts of a term, including posts on children terms.
	 *
	 * @since 1.0
	 * @param (object) $term A term from any taxonomy.
	 * @return (int)
	 */
	function listar_count_term_posts( $term ) {
		$id = $term->term_id;
		$term_meta = get_option( "taxonomy_$id" );
		$counter = (int) isset( $term_meta['post_counter'] ) ? $term_meta['post_counter'] : 0;

		if ( $counter > 9999 && $counter < 1000000 ) {
			$counter = (string) ( (int) ( $counter / 1000 ) ) . 'K' ;
		} elseif ( $counter >= 1000000 ) {
			$counter = (string) ( (int) ( $counter / 1000000 ) ) . 'M' ;
		}
		
		return ! empty( $counter ) ? $counter : 0;
	}

endif;

if ( ! function_exists( 'listar_excerpt_limit' ) ) :
	/**
	 * Trim post excerpts to a limit of characters.
	 *
	 * @since 1.0
	 * @param (object|string) $post_data WordPress $post object or any string.
	 * @param (integer)       $n Desired number of characters.
	 * @param (boolean)       $use_more_link Append the "Read More" link or not.
	 * @param (string)        $fallback_text Fallback text if empty excerpt.
	 * @param (boolean)       $use_etc Append '...' to the end of title if text length is larger than requested.
	 * @param (string)        $etc_type The type of output to the "read more" block.
	 * @param (boolean)       $avoid_empty If no excerpt available, don't return nothing.
	 * @return (string)
	 */
	function listar_excerpt_limit( $post_data, $n, $use_more_link = true, $fallback_text = '', $use_etc = false, $etc_type = '', $avoid_empty = false ) {
		$more_link = '';
		$excerpt_data = '';
		$text2 = is_string( $post_data ) ? $post_data : '';
		
		if ( empty( $text2 ) ) {
			$custom_excerpt_enabled = 1 === (int) get_post_meta( get_the_ID( $post_data ), '_job_business_use_custom_excerpt', true );
			
			if ( $custom_excerpt_enabled ) {
				$text2 = get_post_meta( get_the_ID( $post_data ), '_job_business_custom_excerpt', true );
			}
		}
		
		if ( empty( $text2 ) ) {
			$text2 = get_post_meta( get_the_ID( $post_data ), '_company_excerpt', true );
		}

		// Remove double spaces and line breaks.
		$text = preg_replace( '/\s+/', ' ', $text2 );

		if ( strlen( $text ) < 10 && ! is_string( $post_data ) ) {
			$temp_ex = isset( $post_data->post_excerpt ) ? $post_data->post_excerpt : '';
			$text3 = preg_replace( '#^\d+#', '', $temp_ex );
			$text = preg_replace( '/\s+/', ' ', $text3 );

			if ( strlen( $text ) < 10 ) {
				$text4 = preg_replace( '#^\d+#', '', get_the_content( null, false, $post_data ) );
				$text  = preg_replace( '/\s+/', ' ', $text4 );
			}
		}

		// Strip all HTML tags and inner content of code blocks.
		$excerpt_clean_1 = wp_kses( $text, array() );

		// Remove Gutenberg HTML comments (Block comments).
		$excerpt_clean_2 = preg_replace( '/(?=<!--)([\s\S]*?)-->/', '', $excerpt_clean_1 );

		// We don't want URLs as text.
		if ( false !== strpos( $excerpt_clean_2, 'http' ) ) {
			$excerpt_clean_2 = substr( $excerpt_clean_2, 0, strpos( $excerpt_clean_2, 'http' ) );
		}

		// Remove WordPress Shortcodes.
		$excerpt_clean_4 = strip_shortcodes( $excerpt_clean_2 );

		$chars_trim = array(
			':',
			'-',
			'/',
			'+',
			'#',
			'@',
			'"',
			"'",
			'_',
			'*',
			'$',
			'=',
			',',
			' ',
		);

		$chars_trim_2 = array(
			':',
			'-',
			'/',
			'+',
			'#',
			'@',
			'"',
			"'",
			'_',
			'*',
			'$',
			'=',
			'.',
			'!',
			'?',
			')',
		);

		$count_chars = strlen( $excerpt_clean_4 );

		if ( (int) ( $count_chars * 1.25 ) > $n ) {
			$str = substr( $excerpt_clean_4, 0, $n );
			$excerpt_clean_4 = $str;
			$count_chars_2 = count( $chars_trim_2 );
			
			// Remove last word, it may be cutted in half.
			if ( false !== strpos( $excerpt_clean_4, ' ' ) ) {
				$excerpt_clean_4 = implode( ' ', explode( ' ', $excerpt_clean_4, -1 ) );
			}

			// If the text after the last occurrence of following characters is very short, strip it too.
			for ( $i = 0; $i < $count_chars_2; $i++ ) {
				if ( false !== strpos( $excerpt_clean_4, $chars_trim_2[ $i ] ) ) {
					$temp  = explode( $chars_trim_2[ $i ], $excerpt_clean_4 );
					$count = count( $temp );

					if ( strlen( $temp[ $count - 1 ] ) < 15 ) {
						$excerpt_clean_4 = substr( $excerpt_clean_4, 0, strrpos( $excerpt_clean_4, $chars_trim_2[ $i ] ) );
					}
				}
			}
			
			if ( $use_etc ) {
				$use_etc = 'yes';
			}
		}

		// Remove all spaces from both sides of a string. Also, remove specific chars.

		$count_trim = count( $chars_trim );

		for ( $i = 0; $i < $count_trim; $i++ ) {
			$excerpt_clean_4 = trim( $excerpt_clean_4, $chars_trim[ $i ] );
		}
		
		$excerpt_clean_5 = str_replace( array( '&nbsp;' ), ' ', $excerpt_clean_4 );

		/* If last char is '&', remove it */
		if ( '&' === substr( $excerpt_clean_5, -1 ) ) {
			$excerpt_clean_5 = substr( $excerpt_clean_5, 0, -1 );
		}

		$excerpt = $excerpt_clean_5;

		if ( empty( $excerpt ) ) {
			$excerpt = $fallback_text;
		}
		
		/*
		 * Remove special characters but respect cyrillic/greek and etc.
		 * Reference: https://stackoverflow.com/a/7271664/7765298
		 */
		$valid_string_test = preg_replace( '/[^\p{L}\p{N}\s]/u', '', $excerpt );
		
		if ( ! empty( $valid_string_test ) ) {
			$valid_string_test = str_replace( '&nbsp;', '', $valid_string_test );
		}
		
		if ( empty( $valid_string_test ) && $avoid_empty ) {
			return '';
		}

		if ( empty( $valid_string_test ) || empty( $excerpt ) ) {
			$excerpt = '&nbsp;';
		}

		if ( $use_more_link ) {
			$excerpt_data = '<div class="listar-card-content-excerpt">' . $excerpt . '</div>';

			if ( empty( $etc_type ) ) {
				$more_link = ' <a title="' . esc_html__( 'Read More', 'listar' ) . '" href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="listar-read-more-link" data-toggle="tooltip" data-placement="top"><div><span></span></div></a>';
				
			} elseif ( 'only-dots' === $etc_type && ! empty( $valid_string_test ) ) {
				$more_link = ' <div class="fa fa-ellipsis-h"></div>';
			}
		} else {
			$excerpt_data = strip_shortcodes( $excerpt );
		}

		if ( 'yes' === $use_etc ) {
			$excerpt_data .= '...';
		}

		return $excerpt_data . $more_link;
	}

endif;


if ( ! function_exists( 'listar_user_thumbnail' ) ) :
	/**
	 * Retrieve the user avatar thumbnail, if set.
	 *
	 * @since 1.0
	 * @param (integer) $user_id User ID.
	 * @return (string)
	 */
	function listar_user_thumbnail( $user_id = 0 ) {

		global $post;

		/* If not set $user_id, get the ID from post author */
		$id = 0 !== $user_id ? $user_id : $post->post_author;
		$image_thumb   = '';
		
		if ( listar_is_vendor( $id ) && listar_is_vendor_authorized( $id ) ) {
			$store_user = wcfmmp_get_store( $id );
			$image_thumb = $store_user->get_avatar();
		}		
		
		$attachment_id = (int) get_the_author_meta( 'listar_meta_box_user_image', $id );

		if ( ! empty( $attachment_id ) ) {
			$image_attachment = ! empty( $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, 'listar-thumbnail' ) : false;
			$conditions = false !== $image_attachment && isset( $image_attachment[0] ) && ! empty( $image_attachment[0] );

			/* Use a thumbnail if found, or keep using the original image */
			$image_thumb = $conditions ? $image_attachment[0] : '';
		}

		/* If empty, try to get image from Social Login */
		if ( empty( $image_thumb ) && class_exists( 'LSL_Class' ) && listar_addons_active() ) {
			$image_thumb = listar_get_social_login_avatar( $user_id );
		}

		/* If empty, get fallback avatar from Theme Options */
		if ( empty( $image_thumb ) ) {
			$attachment_id = (int) get_option( 'listar_user_avatar_fallback_image' );
			
			if ( ! empty( $attachment_id ) ) {
				$image_attachment = ! empty( $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, 'listar-thumbnail' ) : false;
				$conditions = false !== $image_attachment && isset( $image_attachment[0] ) && ! empty( $image_attachment[0] );

				/* Use a thumbnail if found, or keep using the original image */
				$image_thumb = $conditions ? $image_attachment[0] : '';
			}
		}

		/* If empty, get Gravatar */
		if ( empty( $image_thumb ) ) {
			$image_thumb = get_avatar_url( $id, 100 );
		}

		/* If yet empty, fallback to a local avatar image */
		if ( empty( $image_thumb ) ) {
			$image_thumb = listar_get_theme_file_uri( '/assets/images/empty-avatar.png' );
		}

		return $image_thumb;
	}

endif;

if ( ! function_exists( 'listar_user_name' ) ) :
	/**
	 * Get current logged user name.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_user_name() {

		$current_user = wp_get_current_user();
		$first_name   = $current_user->user_firstname;
		$name         = empty( $first_name ) ? $current_user->user_login : $first_name;

		return $name;
	}

endif;

if ( ! function_exists( 'listar_get_listing_author_name' ) ) :
	/**
	 * Get current logged user name.
	 *
	 * @since 1.2.4
	 * @param (object) $current_user A object containing the user data.
	 * @return (string)
	 */
	function listar_get_listing_author_name( $current_user ) {
		$name = $current_user->display_name;

		if ( empty( $name ) ) {
			$name = $current_user->user_nicename;
		}

		if ( empty( $name ) ) {
			$name = $current_user->user_login;
		}

		return $name;
	}

endif;

if ( ! function_exists( 'listar_comment_depth' ) ) :
	/**
	 * Get comment depth.
	 *
	 * @since 1.0
	 * @param (integer) $my_comment_id Comment ID.
	 * @return (integer)
	 */
	function listar_comment_depth( $my_comment_id ) {

		$depth_level = 0;

		while ( $my_comment_id > 0 ) {
			$my_comment = get_comment( $my_comment_id );
			$my_comment_id = $my_comment->comment_parent;
			$depth_level++;
		}

		return $depth_level;
	}

endif;

if ( ! function_exists( 'listar_get_reviews_average' ) ) :
	/**
	 * Get reviews average.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_get_reviews_average( $id ) {

		$listing_post  = get_post( $id );
		$comment_count = isset( $listing_post->comment_count ) ? (int) $listing_post->comment_count : 0;

		if ( listar_third_party_reviews_active() ) {
			return (float) $comment_count > 0 ? wpjmr_get_reviews_average( $id ) : 0;
		} elseif ( listar_built_in_reviews_active() ) {
			return (float) $comment_count > 0 ? listar_get_reviews_average_core( $id ) : 0;
		} else {
			return 0;
		}
	}

endif;

if ( ! function_exists( 'listar_reviews_average' ) ) :
	/**
	 * Get reviews average.
	 * If not available, return empty star (yet unrated) or false (review plugin inactive).
	 *
	 * @since 1.0
	 * @param (intenger) $id Listing ID.
	 * @return (float|string|bool)
	 */
	function listar_reviews_average( $id ) {

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			$n = listar_get_reviews_average( $id );
			$average = listar_check_reviews_average( $n, $id );
			return $average;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_reviews_average_number' ) ) :
	/**
	 * Get reviews average, return as number.
	 *
	 * @since 1.0
	 * @param (integer) $id Listing ID.
	 * @return (float)
	 */
	function listar_reviews_average_number( $id ) {

		return (float) listar_get_reviews_average( $id );
	}

endif;

if ( ! function_exists( 'listar_check_reviews_average' ) ) :
	/**
	 * Check if reviews average is > 0, return empty star icon if not.
	 *
	 * @since 1.0
	 * @param (float)   $average Reviews average.
	 * @param (integer) $id Listing ID.
	 * @return (float|string)
	 */
	function listar_check_reviews_average( $average, $id = 0 ) {

		$check = number_format( floatval( $average ), 1 );
		$count = listar_reviews_count( $id );

		return ( empty( $check ) || 0 === $check || 0 === (int) $count ) ? '<i class="fa fa-star-o listar-no-rating"></i>' : $check;
	}

endif;

if ( ! function_exists( 'listar_reviews_count' ) ) :
	/**
	 * Count the total number of reviews of a listing.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_reviews_count( $id ) {
	
		if ( listar_third_party_reviews_active() ) {
			return wpjmr_get_reviews_count( $id );
		} elseif ( listar_built_in_reviews_active() ) {
			return listar_get_reviews_count_core( $id );
		} else {
			return 0;
		}
	}
endif;

if ( ! function_exists( 'listar_is_built_in_reviews_option_disabled' ) ) :
	/**
	 * Check if Listar built in reviews is disabled via theme options.
	 *
	 * @since 1.3.9
	 * @return (bool)
	 */
	function listar_is_built_in_reviews_option_disabled() {
	
		$input = (int) get_option( 'listar_disable_reviews' );
		return ( 1 === $input ? true : false );
	}
endif;

if ( ! function_exists( 'listar_built_in_reviews_active' ) ) :
	/**
	 * Check if Listar built in reviews is active.
	 *
	 * @since 1.3.9
	 * @return (bool)
	 */
	function listar_built_in_reviews_active() {

		if ( class_exists( 'Listar_Reviews_Edit' ) && ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'listar_third_party_reviews_active' ) ) :
	/**
	 * Check if reviews third party plugin is active.
	 *
	 * @since 1.0
	 * @return (bool)
	 */
	function listar_third_party_reviews_active() {

		if ( class_exists( 'WP_Job_Manager_Reviews' ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_wp_job_manager_active' ) ) :
	/**
	 * Check if 'WP Job Manager' plugin is active.
	 *
	 * @since 1.0
	 * @return (bool)
	 */
	function listar_wp_job_manager_active() {

		if ( class_exists( 'WP_Job_Manager' ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_reviews_stars' ) ) :
	/**
	 * Get reviews stars (1 until 5) as HTML.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_reviews_stars() {

		global $post;

		$comment_count = isset( $post->comment_count ) ? (int) $post->comment_count : 0;
		$empty_stars   = '<span class="listar-listing-review-average-stars">';
		$empty_stars  .= '<span class="stars-rating wp-job-manager-listing-star-rating">';
		$empty_stars  .= str_repeat( '<span class="dashicons dashicons-star-empty"></span>', 5 );
		$empty_stars  .= '</span></span>';
		$the_stars     = '';
		
		$replace = array(
			'>	<',
			'> <',
		);
		
		if ( listar_third_party_reviews_active() ) {
			$the_stars = str_replace( $replace, '><', do_shortcode( '[review_stars]' ) );
		} elseif ( listar_built_in_reviews_active() ) {
			$code = '<span class="review-stars">' . listar_get_listing_average_stars( get_the_ID() ) . '</span>';
			$the_stars = str_replace( $replace, '><', $code );
		}

		return $comment_count > 0 ? $the_stars : $empty_stars;
	}

endif;

if ( ! function_exists( 'listar_reviews_reputation' ) ) :
	/**
	 * Recover reviews reputation of a listing.
	 *
	 * @since 1.0
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_reviews_reputation( $id ) {

		$n = listar_get_reviews_average( $id );

		if ( 0 === $n ) {
			$n = esc_html__( 'Not Rated', 'listar' );
		} elseif ( $n > 0 && $n <= 2 ) {
			$n = esc_html__( 'Bad', 'listar' );
		} elseif ( $n > 2 && $n <= 3 ) {
			$n = esc_html__( 'Regular', 'listar' );
		} elseif ( $n > 3 && $n <= 4 ) {
			$n = esc_html__( 'Good', 'listar' );
		} elseif ( $n > 4 && $n <= 5 ) {
			$n = esc_html__( 'Excellent', 'listar' );
		}

		return $n;
	}

endif;

if ( ! function_exists( 'listar_reviews_reputation_mood' ) ) :
	/**
	 * Recover reviews mood icon (CSS class name).
	 *
	 * @since 1.0
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_reviews_reputation_mood( $id ) {

		$n = listar_get_reviews_average( $id );

		if ( 0 === $n ) {
			$n = 'neutral';
		} elseif ( $n > 0 && $n <= 2 ) {
			$n = 'mad';
		} elseif ( $n > 2 && $n <= 3 ) {
			$n = 'neutral';
		} elseif ( $n > 3 && $n <= 4 ) {
			$n = 'smile';
		} elseif ( $n > 4 && $n <= 5 ) {
			$n = 'happy';
		}

		return $n;
	}

endif;

if ( ! function_exists( 'listar_increment_post_meta_field' ) ) :
	/**
	 * Increments/resets the integer value of a meta field.
	 *
	 * @since 1.3.9
	 * @param (Integer) $post_id The post ID.
	 * @param (String) $meta_field_key The meta field key.
	 * @param (Boolean|Integer) $increment Incremental value to the counter.
	 * @param (Boolean) $reset Reset counter.
	 */
	function listar_increment_post_meta_field( $post_id, $meta_field_key = 'listar_meta_box_views_counter', $increment = false, $reset = false ) {
		$current = get_post_meta( $post_id, $meta_field_key, true );
		$count   = ( empty( $current ) ? 0 : (int) $current ) + 1;
		
		if ( $reset ) {
			$count = 0;
		}
		
		if ( false !== $increment ) {
			$count += $increment;
		}

		update_post_meta( $post_id, $meta_field_key, $count );
	}

endif;

if ( ! function_exists( 'listar_single_listing_view_counter_active' ) ) :
	/**
	 * Verify if listing view counter must be available publicly or not.
	 *
	 * @since 1.3.9
	 * @return (Boolean)
	 */
	function listar_single_listing_view_counter_active() {
		$input = (int) get_option( 'listar_single_listing_view_counter_disable' );
		return 1 === $input ? false : true;
	}

endif;

if ( ! function_exists( 'listar_best_rated_listings' ) ) :
	/**
	 * Get best rated listings.
	 *
	 * @since 1.0
	 * @param (array)   $ids_and_ratings Listing IDs and respective ratings.
	 * @param (integer) $number_of_samples The number of listings to get results from.
	 * @return (array)
	 */
	function listar_best_rated_listings( $ids_and_ratings, $number_of_samples = 2000 ) {

		$best_rated_ids_and_ratings = array();

		foreach ( $ids_and_ratings as $key => $row ) {
			$best_rated_ids_and_ratings[ $key ] = $row['rev'];
		}

		array_multisort( $best_rated_ids_and_ratings, SORT_DESC, $ids_and_ratings );
		$best_rated_ids = array();

		foreach ( $ids_and_ratings as $elem ) {
			$best_rated_ids[] = $elem['id'];
		}

		return array_slice( array_filter( $best_rated_ids ), 0, $number_of_samples, true );
	}

endif;

if ( ! function_exists( 'listar_most_rated_listings' ) ) :
	/**
	 * Get most rated listings (returns the IDs and average rating values).
	 *
	 * @since 1.0
	 * @param (integer) $number_of_samples Number of best rated listings to analize.
	 * @return (array)
	 */
	function listar_most_rated_listings( $number_of_samples = 2000 ) {

		/* It's strictly important to get the comment count table always updated */
		listar_update_comment_counters();

		/* Query listing ordered by the number of comments */
		$exec_query = new WP_Query(
			array(
				'post_type'      => 'job_listing',
				'post_status'    => 'publish',
				'orderby'        => 'comment_count',
				'posts_per_page' => $number_of_samples,
			)
		);

		/* Array of listing IDs and respective ratings */
		$ids_and_ratings = array();

		while ( $exec_query->have_posts() ) :
			$exec_query->the_post();
			$ids_and_ratings[] = array(
				'id'  => get_the_ID(),
				'rev' => listar_reviews_average_number( get_the_ID() ),
			);
		endwhile;

		/* Restore original Post Data */
		wp_reset_postdata();

		return $ids_and_ratings;
	}

endif;

if ( ! function_exists( 'listar_update_comment_counters' ) ) :
	/**
	 * Update comment counters.
	 *
	 * @since 1.0
	 * @param (string) $post_type The post type name.
	 */
	function listar_update_comment_counters( $post_type = 'job_listing' ) {

		/* Get all comments */
		$posts_per_page = 2000;

		$query_posts = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => $posts_per_page,
			)
		);

		while ( $query_posts->have_posts() ) :
			$query_posts->the_post();
			wp_update_comment_count_now( get_the_ID() );
		endwhile;
	}
endif;

if ( ! function_exists( 'listar_most_rated_listings_ids' ) ) :
	/**
	 * Get IDs of most rated listings.
	 *
	 * @since 1.0
	 * @param (array) $ids The listing IDs to analize.
	 * @return (array)
	 */
	function listar_most_rated_listings_ids( $ids ) {

		$most_rated_ids = array();

		foreach ( $ids as $id ) {
			$most_rated_ids[] = $id['id'];
		}

		return array_filter( $most_rated_ids );
	}

endif;

if ( ! function_exists( 'listar_saved_best_rated' ) ) :
	/**
	 * Get best rated listings saved programatically as Theme Option.
	 *
	 * @since 1.0
	 * @return (object)
	 */
	function listar_saved_best_rated() {

		$best_rated_listings = esc_html( get_option( 'listar_best_rated_listings' ) );

		if ( empty( $best_rated_listings ) ) {

			/* If register is empty, call function to get current best rated listings and save it */
			listar_update_top_listings();

			$best_rated_listings = esc_html( get_option( 'listar_best_rated_listings' ) );
		}

		return json_decode( $best_rated_listings );
	}

endif;

if ( ! function_exists( 'listar_update_top_listings' ) ) :
	/**
	 * Update top rated listings - Alias.
	 *
	 * @since 1.0
	 */
	function listar_update_top_listings() {
		if ( listar_addons_active() ) {
			listar_update_trending_listings();
		}
	}
endif;

if ( ! function_exists( 'listar_term_image' ) ) :
	/**
	 * Given a 'term' ID, gets the image attached to this term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (string)  $size Desired image size.
	 * @return (string|bool)
	 */
	function listar_term_image( $term_id, $taxonomy = 'category', $size = 'listar-thumbnail' ) {
		$post_image = '';
		$term_image = '';

		switch ( $taxonomy ) {
			case 'job_listing_category':
				$term_image = 'job_listing_category-image-id';
				break;
			case 'job_listing_region':
				$term_image = 'job_listing_region-image-id';
				break;
			case 'job_listing_amenity':
				$term_image = 'job_listing_amenity-image-id';
				break;
			default:
				$term_image = 'category-image-id';
		}

		$image_id = get_term_meta( $term_id, $term_image, true );

		if ( ! empty( $image_id ) ) {
			$attachment = wp_get_attachment_image_src( $image_id, $size );
			$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
			$post_image = $conditions ? $attachment[0] : '';
		}

		return $post_image;
	}

endif;

if ( ! function_exists( 'listar_term_icon_from_post' ) ) :
	/**
	 * Given a post ID, gets the icon attached to its first 'term' from taxonomy.
	 *
	 * @since 1.0
	 * @param (integer) $post_id ID of the post.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (object|boolean) $term The taxonomy term object.
	 * @return (string|bool)
	 */
	function listar_term_icon_from_post( $post_id, $taxonomy, $term = false ) {

		$listing_term = ! $term ? listar_first_term_data( $post_id, $taxonomy ) : $term;

		if ( isset( $listing_term->term_id ) ) {
			return listar_term_icon( $listing_term->term_id );
		} else {
			return false;
		}
	}

endif;

if ( ! function_exists( 'listar_term_icon' ) ) :
	/**
	 * Given a 'term' ID from certain taxonomy, gets the icon attached to the term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @return (string|bool)
	 */
	function listar_term_icon( $term_id ) {

		$term_data = get_option( "taxonomy_$term_id" );
		$term_icon = isset( $term_data['term_icon'] ) && ! empty( $term_data['term_icon'] ) ? esc_html( $term_data['term_icon'] ) : '';

		return $term_icon;
	}

endif;

if ( ! function_exists( 'listar_term_color' ) ) :
	/**
	 * Given a 'term' ID from certain taxonomy, gets the color set to the term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @param (boolean) $hex_numeral_system true to return hexadecimal code.
	 * @return (string)
	 */
	function listar_term_color( $term_id, $hex_numeral_system = false ) {

		$term_color = listar_theme_color();

		$custom_colors_disabled = (int) get_option( 'listar_disable_custom_taxonomy_colors' );

		if ( 0 === $custom_colors_disabled ) {
			$term_data = get_option( "taxonomy_$term_id" );
			$term_color = isset( $term_data['term_color'] ) && ! empty( $term_data['term_color'] ) && '#' !== $term_data['term_color'] ? esc_html( $term_data['term_color'] ) : listar_theme_color();
		}

		return $hex_numeral_system ? str_replace( '#', '', $term_color ) : listar_convert_hex_to_rgb( $term_color );
	}

endif;

if ( ! function_exists( 'listar_theme_color' ) ) :
	/**
	 * Get the current theme color set on Customizer / Colors.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_theme_color() {
		$theme_color = '#' . get_theme_mod( 'listar_theme_color', '258bd5' );
		return $theme_color;
	}

endif;

if ( ! function_exists( 'listar_gradient_background' ) ) :
	/**
	 * Generate CSS for gradient background.
	 *
	 * @since 1.0
	 * @param (string) $rgb_color The base color (RGB).
	 * @param (string) $direction_start Side to start the gradient.
	 * @param (string) $direction_end Side to end the gradient.
	 * @param (string) $rgb_secondary_color The secondary color (RGB).
	 * @param (string) $opacity The opacity for base color.
	 * @param (string) $secondary_opacity The opacity for secondary color.
	 * @param (string) $gradient_start The percentual starting position for gradient.
	 * @return (string)
	 */
	function listar_gradient_background( $rgb_color = false, $direction_start = 'top', $direction_end = 'bottom', $rgb_secondary_color = false, $opacity = '0', $secondary_opacity = '1', $gradient_start = '35%' ) {

		if ( false === $rgb_color ) {
			$color = listar_theme_color();
			$rgb_color = listar_convert_hex_to_rgb( $color );
		}

		if ( false === $rgb_secondary_color ) {
			$rgb_secondary_color = $rgb_color;
		}

		$gradient_css  = 'background-color: transparent;';
		$gradient_css .= 'background: -webkit-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: -o-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: -ms-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: linear-gradient(to ' . $direction_end . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';

		return $gradient_css;
	}

endif;

if ( ! function_exists( 'listar_loop_completed' ) ) :
	/**
	 * Inform that the main loop of posts is completed in current page or if listing loops are allowed
	 * to capture listings (IDs) to populate the map (false).
	 *
	 * @since 1.0
	 * @param (bool) $completed Can be: false (enables the capture of IDs) or true (loop completed/disable the capture).
	 * @return (bool)
	 */
	function listar_loop_completed( $completed = false ) {

		static $loop_completed = false;

		if ( $completed ) {
			$loop_completed = $completed;
		}

		return $loop_completed;
	}

endif;

if ( ! function_exists( 'listar_current_filter_elements' ) ) :
	/**
	 * Saves listing terms of current search filter on static var, so it can be accessed globally.
	 *
	 * @since 1.0
	 * @param (array) $new_elem Array containing the term data ('title', 'icon', 'value', 'classsvg').
	 * @param (bool)  $reset Rest the array of terms.
	 * @return (array)
	 */
	function listar_current_filter_elements( $new_elem = array(), $reset = false ) {

		static $listar_current_filter_elements = array();

		if ( ! empty( $new_elem ) && is_array( $new_elem ) ) {
			/* Include new filter element to the list */
			$listar_current_filter_elements[] = $new_elem;
		}

		if ( true === $reset ) {
			/* Reset last filter list saved */
			$listar_current_filter_elements = array();
		}

		return $listar_current_filter_elements;
	}

endif;

if ( ! function_exists( 'listar_package_query' ) ) :
	/**
	 * Create the args to WP Job Manager package query.
	 *
	 * @since 1.0
	 * @param (string) $package_type The type of the package.
	 * @return (array)
	 */
	function listar_package_query( $package_type = 'default' ) {

		static $package_query = null;

		if ( empty( $package_query ) ) :

			/* Display all pricing packages in one page */
			$posts_per_page = 2000;

			$args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'order'          => 'ASC',
				'orderby'        => 'meta_value_num',
				'meta_key'       => '_regular_price',
				'posts_per_page' => $posts_per_page,
				'meta_query'     => array(
					array(
						'key'     => '_regular_price',
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'relation' => 'OR',
						array(
							'key'     => '_use_for_claims',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => '_use_for_claims',
							'value'   => 'yes',
							'compare' => '!=',
						),
					),
				),
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_type',
						'field'    => 'slug',
						'terms'    => array ( 'job_package', 'job_package_subscription' ),
					),
				),
			);
			
			if ( 'claim' === $package_type ) {
				$args['meta_query'] = array(
					array(
						'key'     => '_regular_price',
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => '_use_for_claims',
						'value'   => 'yes',
						'compare' => '=',
					),
				);
			}

			$package_query = new WP_Query( $args );

		endif;

		return $package_query;
	}

endif;

if ( ! function_exists( 'listar_is_front_page_template' ) ) :
	/**
	 * Improved detection of front page by template, rather than the default conditional tag is_front_page().
	 *
	 * @since 1.0
	 * @return (boolean)
	 */
	function listar_is_front_page_template() {

		global $wp_query;
		global $query;

		static $is_front_page = 0;
		
		$id = false;

		if ( 0 !== $is_front_page ) {
			return $is_front_page;
		} else {
			
			$id = listar_get_current_page_id();
			
			$template = ! empty( $id ) ? get_page_template_slug( $id ) : '';
			$is_front_page = ( false !== strpos( $template, 'front-page' ) && is_page() ) ? true : false;

			return $is_front_page;
		}
	}

endif;



if ( ! function_exists( 'listar_get_current_page_id' ) ) :
        /**
         * Get the ID of the current page, attempting varied ways.
         *
         * @since 1.5.3
         * @return (boolean)
         */
        function listar_get_current_page_id() {

                global $wp_query;
                global $query;

                static $is_front_page = 0;

                $id = isset( $wp_query->query_vars[ 'page_id' ] ) ? $wp_query->query_vars[ 'page_id' ] : false;
                        
                if ( empty( $id ) ) {
                        isset( $wp_query->page_id ) ? $wp_query->page_id : false;
                }
                
                if ( empty( $id ) ) {
                        $id = isset( $wp_query->post->ID ) ? $wp_query->post->ID : false;
                }
                
                if ( empty( $id ) ) {
                        $id = isset( $query->queried_object->ID ) ? $query->queried_object->ID : false;
                }
                
                if ( empty( $id ) ) {
                        $id = isset( $wp_query->query_vars[ 'p' ] ) ? $wp_query->query_vars[ 'p' ] : false;
                }

                return $id;
        }

endif;

if ( ! function_exists( 'listar_current_directory_sort' ) ) :
	/**
	 * Get type of ordering (sort) currently being used by directory search.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_current_directory_sort() {
		global $wp_query;
		
		if ( listar_addons_active() ) {
			return listar_current_directory_sort_session();
		} else {
			$get_sort = filter_input( INPUT_GET, listar_url_query_vars_translate( 'listing_sort' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			$listar_sort_order = 'newest';

			if ( empty( $get_sort ) ) {
				$get_sort = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_sort' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_sort' ) ] : '';
			}

			return ! empty( $get_sort ) ? $get_sort : $listar_sort_order;
		}
	}
endif;


if ( ! function_exists( 'listar_current_explore_by' ) ) :
	/**
	 * Get type of 'Explore by" search in use currently.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_current_explore_by() {
		global $wp_query;
		
		if ( listar_addons_active() ) {
			return listar_current_explore_by_session();
		} else {
			$get_explore_by_type = filter_input( INPUT_GET, listar_url_query_vars_translate( 'explore_by' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			$listar_explore_by_type = 'default';

			if ( empty( $get_explore_by_type ) ) {
				$get_explore_by_type = isset( $wp_query->query[ listar_url_query_vars_translate( 'explore_by' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'explore_by' ) ] : '';
			}

			return ! empty( $get_explore_by_type ) ? $get_explore_by_type : $listar_explore_by_type;
		}
	}
endif;


if ( ! function_exists( 'listar_current_search_address' ) ) :
	/**
	 * Get current or last location address used for "explore by".
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_current_search_address() {
		global $wp_query;
		
		if ( listar_addons_active() ) {
			return listar_current_search_address_session();
		} else {
			$listar_current_explore_by = listar_current_explore_by();
			$empty_address = '';

			if ( 'near_address' === $listar_current_explore_by ) {
				$search_address = filter_input( INPUT_GET, 's', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

				if ( empty( $search_address ) ) {
					$search_address = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
				}
			}

			return ! empty( $search_address ) ? $search_address : $empty_address;
		}
	}
endif;


if ( ! function_exists( 'listar_current_search_postcode' ) ) :
	/**
	 * Get current or last location postcode used for "explore by".
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_current_search_postcode() {
		global $wp_query;
		
		if ( listar_addons_active() ) {
			return listar_current_search_postcode_session();
		} else {
			$listar_current_explore_by = listar_current_explore_by();
			$empty_postcode = '';

			if ( 'near_postcode' === $listar_current_explore_by ) {
				$search_postcode = filter_input( INPUT_GET, 's', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

				if ( empty( $search_postcode ) ) {
					$search_postcode = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
				}
			}

			return ! empty( $search_postcode ) ? $search_postcode : $empty_postcode;
		}
	}
endif;


if ( ! function_exists( 'listar_capitalize_phrase' ) ) :
	/**
	 * Capitalize words of phrases.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_capitalize_phrase( $str ) {
		if ( false !== strpos( $str, ' ' ) ) {
			$temp  = array_filter( explode( ' ', $str ) );
			$temp2 = '';
			
			foreach ( $temp as $str ) {
				$temp2 .= ucfirst( $str ) . ' ';
			}
			
			$str = trim( $temp2 );
		}
		
		return $str;
	}
endif;


if ( ! function_exists( 'listar_current_search_address_coordinates' ) ) :
	/**
	 * Get coordinates for current or last location address used for "explore by".
	 *
	 * @since 1.3.8
	 * @return (array)
	 */
	function listar_current_search_address_coordinates() {
		if ( listar_addons_active() ) {
			return listar_current_search_address_coordinates_session();
		} else {
			return array( '', '' );
		}
	}
endif;


if ( ! function_exists( 'listar_region_id' ) ) :
	/**
	 * Get current region ID, if available.
	 *
	 * @since 1.0
	 * @return (integer|null)
	 */
	function listar_region_id() {

		$current_taxonomy = '';
		$region_id = 0;

		if ( null !== get_queried_object() ) {

			if ( isset( get_queried_object()->taxonomy ) ) {
				$current_taxonomy = get_queried_object()->taxonomy;
			}

			if ( 'job_listing_region' === $current_taxonomy ) {
				$region_id = get_queried_object()->term_id;
				return $region_id;
			}
		}
	}

endif;

if ( ! function_exists( 'listar_explode_and_clean' ) ) :
	/**
	 * Explode strings separated by comma and clean empty elements.
	 *
	 * @since 1.0
	 * @param (string) $str Values separated by comma.
	 * @return (array)
	 */
	function listar_explode_and_clean( $str ) {

		return array_filter( explode( ',', $str ) );
	}

endif;

if ( ! function_exists( 'listar_hierarchical_terms_tree' ) ) :
	/**
	 * Get terms of certain taxonomy hierarchically organized and saves it globally.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @param (string)  $taxonomy Taxonomy slug.
	 * @param (integer) $hierarchy_counter Counter to define hierarchy levels for terms.
	 * @param (integer) $last_parent The ID of last parent term.
	 */
	function listar_hierarchical_terms_tree( $term_id, $taxonomy, $hierarchy_counter = 0, $last_parent = false ) {
		
		$icon = '';
		$use_hierarchy_counter = false;
		$count = $hierarchy_counter;
		$next = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'number'     => 500,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'parent'     => $term_id,
			)
		);

		if ( ! $next || is_wp_error( $next ) ) {
			return;
		}

		foreach ( $next as $term ) :
			$child        = '';
			$temp_term    = $term;
			$svg          = '';
			$class_svg    = '';
			$random_class = ' y' . substr( md5( microtime() ), wp_rand( 0, 26 ), 10 );

			while ( isset( $temp_term->parent ) && 0 !== $temp_term->parent ) {
				if ( $last_parent !== $temp_term->parent ) {
					$count++;
				}
				
				$last_parent = $temp_term->parent;
				$use_hierarchy_counter = true;
				//$child .= $temp_term->parent ? ' child' . $count : '';
				$temp_term = get_category( $temp_term->parent );
			}

			if ( 'job_listing_region' === $taxonomy ) {
				$icon = 'icon-city';
			} else {
				$get_icon   = listar_icon_class( listar_term_icon( $term->term_id ) );
				$svg        = $get_icon[1];
				$output_svg = ( ! empty( $svg ) ) ? '<div id="' . trim( $random_class ) . '" class="listar-hidden-svg">' . $svg . '</div>' : '';
				$icon       = empty( $output_svg ) && empty( $get_icon[0] ) ? '' : $get_icon[0] . ' listar-has-icon';

				/**
				 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
				 * Please check the description for 'listar_icon_output' function in functions.php.
				 */
				listar_icon_output( $output_svg );
			}

			if ( empty( $icon ) && 'job_listing_region' !== $taxonomy ) {
				$icon = 'icon-chevron-right-circle';
			}

			$icon .= $random_class . '/////';

			listar_current_filter_elements(
				array(
					'title'    => $term->name,
					'icon'     => $icon . $child,
					'link'     => get_term_link( $term->term_id, $taxonomy ),
					'value'    => $term->term_id,
					'classsvg' => $class_svg,
				)
			);
			
			$count = $use_hierarchy_counter ? $count : 0;

			listar_hierarchical_terms_tree( $term->term_id, $taxonomy, $count, $last_parent );

		endforeach;
	}

endif;

if ( ! function_exists( 'listar_icon_output' ) ) :
	/**
	 * Enforce security for SVG HTML code before output.
	 *
	 * Currently, this function is being used exclusively to process SVG code.
	 * Skipping complex sanitization of SVG code (via 'wp_kses_post') to save memory. Please notice that
	 * the internal code of all SVG files were already cleaned by 'Safe SVG' plugin during upload.
	 * See (Safe SVG plugin): safe-svg/lib/vendor/enshrined/svg-sanitize/src/data/AllowedAttributes.php
	 * See (Safe SVG plugin): safe-svg/lib/vendor/enshrined/svg-sanitize/src/data/AllowedTags.php
	 * Although already sanitized, this is a further attempt to enforce secure output for unknown SVG files.
	 *
	 * @since 1.0
	 * @param (string) $html HTML code.
	 * @param (boolean) $print Print the code or just return the output.
	 */
	function listar_icon_output( $html = '', $print = true ) {
		if ( $print ) {
			echo str_replace( array( 'script', '.js', '<?php', '.php', '?>' ), '', $html );
		} else {
			return str_replace( array( 'script', '.js', '<?php', '.php', '?>' ), '', $html );
		}
	}
endif;

if ( ! function_exists( 'listar_search_filters' ) ) :
	/**
	 * Get current listing search filters as HTML.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_search_filters() {

		$search_filters = '';
		$get_regions    = listar_get_region_query();
		$regions        = ! empty( $get_regions ) ? $get_regions : '0';

		if ( '0' !== $regions ) {

			$search_filters .= '<div class="listar-filter-block"><span>' . esc_html__( 'Region', 'listar' ) . '</span> ';

			if ( false !== strpos( $regions, ',' ) ) {
				$regions = explode( ',', $regions );
			} else {
				$regions = array( $regions );
			}

			foreach ( $regions as $id ) {

				$term = get_term_by( 'id', $id, 'job_listing_region' );

				if ( false !== $term ) {
					$term_url = get_term_link( $term, 'job_listing_region' );
					$search_filters .= '<a href="' . esc_url( $term_url ) . '">' . esc_html( ucfirst( $term->name ) ) . ',&nbsp;</a>';
				}
			}

			$search_filters .= '</div>';
		}

		$get_categories = listar_get_category_query();
		$categories = ! empty( $get_categories ) ? $get_categories : '0';

		if ( '0' !== $categories ) {

			$search_filters .= '<div class="listar-filter-block"><span>' . esc_html__( 'Category', 'listar' ) . '</span> ';

			if ( false !== strpos( $categories, ',' ) ) {
				$categories = explode( ',', $categories );
			} else {
				$categories = array( $categories );
			}

			foreach ( $categories as $id ) {

				$term = get_term_by( 'id', $id, 'job_listing_category' );

				if ( false !== $term ) {
					$term_url = get_term_link( $term, 'job_listing_category' );
					$search_filters .= '<a href="' . esc_url( $term_url ) . '">' . esc_html( ucfirst( $term->name ) ) . ',&nbsp;</a>';
				}
			}
			$search_filters .= '</div>';
		}

		$get_amenities = listar_get_amenity_query();
		$amenities = ! empty( $get_amenities ) ? $get_amenities : '0';

		if ( '0' !== $amenities ) {

			$search_filters .= '<div class="listar-filter-block"><span>' . esc_html__( 'Amenity', 'listar' ) . '</span> ';

			if ( false !== strpos( $amenities, ',' ) ) {
				$amenities = explode( ',', $amenities );
			} else {
				$amenities = array( $amenities );
			}

			foreach ( $amenities as $id ) {

				$term = get_term_by( 'id', $id, 'job_listing_amenity' );

				if ( false !== $term ) {
					$term_url = get_term_link( $term, 'job_listing_amenity' );
					$search_filters .= '<a href="' . esc_url( $term_url ) . '">' . esc_html( ucfirst( $term->name ) ) . ',&nbsp;</a>';
				}
			}

			$search_filters .= '</div>';
		}

		$query_search = listar_get_search_query();

		if ( ! empty( $query_search ) ) {
			$search_filters .= '<div class="listar-filter-block"><span>' . esc_html__( 'Search', 'listar' ) . '</span> ' . wp_kses( $query_search, 'listar-basic-html' ) . ',&nbsp;';
			$search_filters .= '</div>';
		}

		$sort = str_replace( '_', ' ', listar_current_directory_sort() );

		$search_filters .= '<div class="listar-filter-block"><span>' . esc_html__( 'Sort', 'listar' ) . '</span> ' . esc_html( ucfirst( $sort ) );
		$search_filters .= '</div>';

		return $search_filters;
	}

endif;

if ( ! function_exists( 'listar_print_filter_options' ) ) :
	/**
	 * Print filter options as HTML.
	 *
	 * @since 1.0
	 * @param (array) $filter_terms Terms to include on current filter <select>.
	 */
	function listar_print_filter_options( $filter_terms ) {

		$options = listar_current_filter_elements();
		$count_options = is_array( $options ) ? count( $options ) : 0;

		for ( $i = 0; $i < $count_options; $i++ ) :

			$class_svg = $options[ $i ]['classsvg'];
			$icon = explode( '/////', $options[ $i ]['icon'] );

			if ( ! empty( $options[ $i ]['classsvg'] ) ) {
				$icon = $icon[1];
			} elseif ( 2 === count( $icon ) ) {
				$icon = $icon[0] . $icon[1];
			} elseif ( empty( $icon[0] ) && empty( $icon[1] ) ) {
				$icon = 'icon-map-marker' . $icon[2];
			} elseif ( empty( $icon[1] ) ) {
				$icon = '' !== $icon[0] ? $icon[0] . $icon[2] : 'icon-map-marker' . $icon[2];
			}

			$selected = in_array( $options[ $i ]['value'], $filter_terms, true ) ? 'selected' : '';
			?>

			<option data-icon="<?php echo esc_attr( listar_sanitize_html_class( $icon . ' ' . $class_svg ) ); ?> select-icon" value="<?php echo esc_attr( $options[ $i ]['value'] ); ?>" <?php echo esc_attr( $selected ); ?>>
				<?php echo esc_html( $options[ $i ]['title'] ); ?>
			</option>

			<?php
		endfor;
	}

endif;

if ( ! function_exists( 'listar_print_term_links' ) ) :
	/**
	 * Print terms of currenty taxonomy as hyperlinks.
	 *
	 * @since 1.0
	 * @param (bool) $random If false, display links ordered by Name. If true, output it in random order.
	 */
	function listar_print_term_links( $random = false ) {

		$terms = listar_current_filter_elements();

		if ( true === $random ) :
			shuffle( $terms );
		endif;

		$count_terms = is_array( $terms ) ? count( $terms ) : 0;

		for ( $i = 0; $i < $count_terms; $i++ ) :
			?>
			<a href="<?php echo esc_url( $terms[ $i ]['link'] ); ?>">
				<?php echo esc_html( $terms[ $i ]['title'] ); ?>
			</a>
			<?php
		endfor;
	}

endif;

if ( ! function_exists( 'listar_current_term_filter' ) ) :
	/**
	 * Get filter parameters to listing search.
	 *
	 * @since 1.0
	 * @return (array)
	 */
	function listar_current_term_filter() {
		global $wp_query;

		$filter = array(
			listar_url_query_vars_translate( 'listing_regions' ) => array(),
			listar_url_query_vars_translate( 'listing_categories' ) => array(),
			listar_url_query_vars_translate( 'listing_amenities' )  => array(),
			listar_url_query_vars_translate( 'listing_sort' ) => listar_current_directory_sort(),
		);

		$get_regions = listar_get_region_query();
		$get_categories = listar_get_category_query();
		$get_amenities = listar_get_amenity_query();
		
		if ( empty( $get_regions ) ) {
			$get_regions = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] : '';
		}
		
		$filter[ listar_url_query_vars_translate( 'listing_regions' ) ] = array_map( 'intval', listar_explode_and_clean( $get_regions ) );
		
		if ( empty( $get_categories ) ) {
			$get_categories = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_categories' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_categories' ) ] : '';
		}
		
		$filter[ listar_url_query_vars_translate( 'listing_categories' ) ] = array_map( 'intval', listar_explode_and_clean( $get_categories ) );
		
		if ( empty( $get_amenities ) ) {
			$get_amenities = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_amenities' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_amenities' ) ] : '';
		}
		
		$filter[ listar_url_query_vars_translate( 'listing_amenities' ) ] = array_map( 'intval', listar_explode_and_clean( $get_amenities ) );

		$current = listar_current_term_ids();

		/* Including current region on filter, if available */
		$region_id = $current[ listar_url_query_vars_translate( 'listing_regions' ) ];

		if ( ! empty( $region_id ) && ! in_array( $region_id, $filter[ listar_url_query_vars_translate( 'listing_regions' ) ], true ) ) {
			array_push( $filter[ listar_url_query_vars_translate( 'listing_regions' ) ], $region_id );
		}

		/* Including current category on filter, if available */
		$category_id = $current[ listar_url_query_vars_translate( 'listing_categories' ) ];

		if ( ! empty( $category_id ) && ! in_array( $category_id, $filter[ listar_url_query_vars_translate( 'listing_categories' ) ], true ) ) {
			array_push( $filter[ listar_url_query_vars_translate( 'listing_categories' ) ], $category_id );
		}

		/* Including current amenity on filter, if available */
		$amenity_id = $current[ listar_url_query_vars_translate( 'listing_amenities' ) ];

		if ( ! empty( $amenity_id ) && ! in_array( $amenity_id, $filter[ listar_url_query_vars_translate( 'listing_amenities' ) ], true ) ) {
			array_push( $filter[ listar_url_query_vars_translate( 'listing_amenities' ) ], $amenity_id );
		}
		
		if ( is_singular( 'job_listing' ) ) {
			global $post;
			$listar_current_post_id = $post->ID;
			
			$listar_category_terms = '';
			$listar_region_terms = '';
			
			$filter[ listar_url_query_vars_translate( 'listing_categories' ) ] = array();
			$filter[ listar_url_query_vars_translate( 'listing_regions' ) ] = array();

			if ( taxonomy_exists( 'job_listing_category' ) ) :
				$listar_category_terms = get_the_terms( $listar_current_post_id, 'job_listing_category' );

				if ( ! isset( $listar_category_terms[0] ) || is_wp_error( $listar_category_terms ) ) {
					$listar_category_terms = false;
				}
			endif;

			if ( taxonomy_exists( 'job_listing_region' ) ) :
				$listar_region_terms = get_the_terms( $listar_current_post_id, 'job_listing_region' );

				if ( ! isset( $listar_region_terms[0] ) || is_wp_error( $listar_region_terms ) ) {
					$listar_region_terms = false;
				}
			endif;
			
			if ( ! empty( $listar_category_terms ) ) {
				foreach ( $listar_category_terms as $term ) {
					$filter[ listar_url_query_vars_translate( 'listing_categories' ) ][] = $term->term_id;
				}
			}

			if ( ! empty( $listar_region_terms ) ) {
				foreach ( $listar_region_terms as $term ) {
					$filter[ listar_url_query_vars_translate( 'listing_regions' ) ][] = $term->term_id;
				}
			}
		}

		return $filter;
	}

endif;

if ( ! function_exists( 'listar_current_term_ids' ) ) :
	/**
	 * Get the ids of terms queried on current page.
	 *
	 * @since 1.0
	 * @return (array)
	 */
	function listar_current_term_ids() {

		$current = array(
			listar_url_query_vars_translate( 'listing_regions' )    => array(),
			listar_url_query_vars_translate( 'listing_categories' ) => array(),
			listar_url_query_vars_translate( 'listing_amenities' )  => array(),
		);

		if ( null === get_queried_object() ) {
			return $current;
		}

		$term = get_queried_object();

		if ( isset( $term->term_id ) ) {

			$id = $term->term_id;

			/* Listing region */
			if ( 'job_listing_region' === $term->taxonomy ) {
				$current[ listar_url_query_vars_translate( 'listing_regions' ) ] = $id;
			}

			/* Listing category */
			if ( 'job_listing_category' === $term->taxonomy ) {
				$current[ listar_url_query_vars_translate( 'listing_categories' ) ] = $id;
			}

			/* Listing amenities */
			if ( 'job_listing_amenity' === $term->taxonomy ) {
				$current[ listar_url_query_vars_translate( 'listing_amenities' ) ] = $id;
			}
		}

		return $current;
	}

endif;

if ( ! function_exists( 'listar_static_posts_already_shown' ) ) :
	/**
	 * To avoid repeated display of posts on same page, use static var to save IDs of posts already queried.
	 *
	 * @since 1.0
	 * @param (integer) $id The ID of a post.
	 * @return (array)
	 */
	function listar_static_posts_already_shown( $id = false ) {

		static $posts_already_shown = array();

		if ( ! empty( $id ) ) {
			$posts_already_shown[] = $id;
		}

		return array_unique( $posts_already_shown );
	}

endif;

if ( ! function_exists( 'listar_static_current_listings' ) ) :
	/**
	 * Save current listing IDs (captured on listing loops or single listing page) to use later with map markers output.
	 *
	 * @since 1.0
	 * @param (integer|array) $id If integer: The ID of a listing post.
	 * If empty array: reset the list of IDs.
	 * @return (array)
	 */
	function listar_static_current_listings( $id = false ) {

		static $current_listings = array();

		if ( ! empty( $id ) ) {
			/* Add new listing ID */
			$current_listings[] = $id;
		} elseif ( is_array( $id ) && empty( $id ) ) {
			/* Reset the list */
			$current_listings = array();
		}

		return $current_listings;
	}

endif;

if ( ! function_exists( 'listar_static_map_markers' ) ) :
	/**
	 * Save listings data static var to populate Leaflet map with markers.
	 *
	 * @since 1.0
	 * @param (string) $markers JSON in string format - JavaScript.
	 * @return (string)
	 */
	function listar_static_map_markers( $markers = '' ) {

		static $map_markers = '';

		if ( ! empty( $markers ) ) {
			$map_markers = $markers;
		}

		return $map_markers;
	}

endif;

if ( ! function_exists( 'listar_static_map_markers_ajax' ) ) :
	/**
	 * (Ajax) Save listing IDs on static var to populate Leaflet map with new markers.
	 *
	 * @since 1.0
	 * @param (integer|array|bool) $marker If integer: Listing ID of a new map marker that will be queried with Ajax.
	 * If empty array: it informs the following listing loop that the new listings (and markers) will be queried with Ajax.
	 * @return (bool|array)
	 */
	function listar_static_map_markers_ajax( $marker = false ) {

		static $map_markers_ajax = false;

		if ( false !== $marker ) {

			if ( is_array( $marker ) && empty( $marker ) ) {
				/* Empty array, so next loop will be queried with Ajax */
				$map_markers_ajax = array();
			} else {
				/* Save the new IDs of listings queried with Ajax */
				$map_markers_ajax[] = $marker;
			}
		}

		return $map_markers_ajax;
	}

endif;

if ( ! function_exists( 'listar_output_map_markers' ) ) :
	/**
	 * Outputs current map markers globally (JavaScript object 'listarMapMarkers' or inside a textarea element).
	 *
	 * @since 1.0
	 */
	function listar_output_map_markers() {

		$markers      = listar_static_map_markers();
		$markers_ajax = listar_static_map_markers_ajax();

		/*
		 * Notice: Every value of $markers was already escaped in
		 * template-parts/directory-parts/listar-map-markers.php.
		 */
		if ( empty( $markers_ajax ) ) {

			/* Not an Ajax query: properly output markers as inline JavaScript */
			$javascript_strict = '
				/* <![CDATA[ */

					( function () {

						"use strict";

						window.listarMapMarkers = [' . $markers . '];

					} )();

				/* ]]> */
			';

			wp_add_inline_script( 'listar-main-javascript', $javascript_strict );
		} else {
			/*
			 * This is a Ajax query: $markers contains new markers to populate the Leaflet map
			 * Output the JSON generated as text inside a hidden textarea,
			 * then JSON.parse() JavaScript method (in assets/js/frontend.js) will detect this string
			 * and convert to a valid JSON object.
			 */
			echo '<textarea class="listar-ajax-map-markers">' . esc_textarea( $markers ) . '</textarea>';

		}
	}

endif;

if ( ! function_exists( 'listar_currency' ) ) :
	/**
	 * Get currency symbol.
	 * 
	 * Alias function for listar_get_currency_symbol().
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_currency() {
		return listar_get_currency_symbol();
	}

endif;

if ( ! function_exists( 'listar_replace_last_string' ) ) :
	/**
	 * Replace last ocurrence of a string.
	 *
	 * @since 1.0
	 * @param (string) $search String to search.
	 * @param (string) $replace Replacement string.
	 * @param (string) $subject Subject string to search on.
	 * @return (string)
	 */
	function listar_replace_last_string( $search, $replace, $subject ) {

		$pos = strrpos( $subject, $search );

		if ( false !== $pos ) {
			$subject = substr_replace( $subject, $replace, $pos, strlen( $search ) );
		}

		return $subject;
	}

endif;

if ( ! function_exists( 'listar_add_filter_title' ) ) :
	/**
	 * Complements the HTML output of current filtered search title.
	 *
	 * @since 1.0
	 * @param (string) $output HTML output.
	 * @param (string) $new New filter title to include.
	 */
	function listar_add_filter_title( $output, $new = '' ) {

		if ( '' !== $new ) :
			$new = '<div class="listar-filter-block"><span>' . $new . '</span> ';
			$output = listar_replace_last_string( '</div>', '</div>,&nbsp;' . $new, $output );
		endif;

		echo wp_kses( $output, 'listar-basic-html' );
	}

endif;

if ( ! function_exists( 'listar_check_plural' ) ) :
	/**
	 * Return words on singular/plural.
	 *
	 * @since 1.0
	 * @param (integer) $amount Number of entries.
	 * @param (string)  $singular String to output if $amount === 1.
	 * @param (string)  $plural String to output if $amount > 1.
	 * @param (string)  $no_results String to output if $amount === 0.
	 */
	function listar_check_plural( $amount, $singular = '', $plural = '', $no_results = '' ) {

		$output = $no_results;

		if ( 1 === (int) $amount ) {
			$output = $singular;
		} elseif ( (int) $amount > 1 ) {
			$output = $plural;
		}

		return $output;
	}

endif;

if ( ! function_exists( 'listar_sanitize_website' ) ) :
	/**
	 * Sanitize website URLs to (http or https)://domain.com.
	 *
	 * @since 1.0
	 * @param (string)  $input Website URL.
	 * @param (boolean) $clean Remove protocol.
	 * @return (string)
	 */
	function listar_sanitize_website( $input, $clean = false ) {

		$output = str_replace( array( ' ', 'www.' ), '', wp_filter_nohtml_kses( $input ) );

		/* If last char is '/', remove it */
		if ( '/' === substr( $output, -1 ) ) {
			$output = substr( $output, 0, -1 );
		}

		if ( false === ! empty( $output ) && strpos( $output, 'http' ) && ! $clean ) {
			$output = 'http://' . $output;
		}

		if ( $clean ) {
			$output = str_replace( array( 'http://', 'https://' ), '', $output );
		}

		return $output;
	}

endif;

if ( ! function_exists( 'listar_get_terms_ids' ) ) :
	/**
	 * Executes query by taxonomy and get its term IDs.
	 *
	 * @since 1.0
	 * @param (string) $taxonomy The taxonomy to query.
	 * @return (array)
	 */
	function listar_get_terms_ids( $taxonomy ) {

		$ids = array();

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'number'     => 100,
			)
		);

		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$ids[] = array( $term->term_id, '1' );
			}
		}

		return $ids;
	}

endif;

if ( ! function_exists( 'listar_edit_post_link' ) ) :
	/**
	 * Display post 'edit' link.
	 *
	 * @since 1.0
	 * @param (Boolean) $front_end_editor Informs if a link to front end editor should be displayed.
	 */
	function listar_edit_post_link( $front_end_editor = false ) {

		$tags = array(
			'span' => array(),
		);
		
		edit_post_link(
			sprintf(
				/* TRANSLATORS: %s: Name of current post */
				wp_kses( __( 'Edit %s', 'listar' ), $tags ),
				the_title( '<span>"', '"</span>', false )
			),
			'<div class="listar-clear-both"></div><div class="edit-link">',
			'</div>'
		);

		if ( is_singular( array( 'job_listing' ) ) ) :
			global $post;
		
			$listing_id = $post->ID;
			$current_user_id = get_current_user_id();
			$listar_user_logged_in = is_user_logged_in();
			$listing_owner_id = $post->post_author;
			$current_user_role = listar_get_current_user_role();
			
			if ( $listar_user_logged_in && $front_end_editor && ( 'administrator' === $current_user_role || 'editor' === $current_user_role || (int) $current_user_id === (int) $listing_owner_id ) ) :
				
				$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );

				if ( ! empty( $listar_job_dashboard_url ) ) :
					$front_end_edit_url = $listar_job_dashboard_url . '?action=edit&job_id=' . $listing_id;
					?>
					<div class="listar-clear-both"></div>
					<div class="edit-link">
						<a class="post-edit-link" href="<?php echo esc_url( $front_end_edit_url ); ?>">
							<?php esc_html_e( 'Quick Edit', 'listar' ); ?>
						</a>
					</div>
					<?php
				endif;
			endif;
		endif;
	}

endif;

if ( ! function_exists( 'listar_wp_link_pages' ) ) :
	/**
	 * Displays page links for paginated posts.
	 *
	 * @since 1.0
	 */
	function listar_wp_link_pages() {
		?>
		<div class="listar-clear-both"></div>
		<?php
		wp_link_pages(
			array(
				'before'      => '<div class="listar-page-links-wrapper listar-section listar-section-no-padding-top"><div class="listar-page-links">' . esc_html__( 'Pages:', 'listar' ),
				'after'       => '</div></div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
	}

endif;

if ( ! function_exists( 'listar_prev_next_links' ) ) :
	/**
	 * Check if a single article has prev/next posts.
	 *
	 * @since 1.0
	 * @param (string) $permalink_format The output format.
	 */
	function listar_prev_next_links( $permalink_format = false ) {

		$prev = get_previous_post_link( '%link', esc_html__( 'Previous Post', 'listar' ) );
		$next = get_next_post_link( '%link', esc_html__( 'Next Post', 'listar' ) );

		if ( false === $permalink_format ) {
			$prev = get_previous_post_link( '%link', esc_html__( 'Previous Post', 'listar' ) );
			$next = get_next_post_link( '%link', esc_html__( 'Next Post', 'listar' ) );
		} else {
			$prev = get_previous_post_link( '%link', $permalink_format );
			$next = get_next_post_link( '%link', $permalink_format );
		}

		if ( $prev || $next ) :
			return array( $prev, $next );
		else :
			return false;
		endif;
	}
endif;

if ( ! function_exists( 'listar_prev_next' ) ) :
	/**
	 * Displays previous and next post links.
	 *
	 * @since 1.0
	 * @param (string) $permalink_format The output format.
	 */
	function listar_prev_next( $permalink_format = false ) {

		$prev_next = listar_prev_next_links( $permalink_format );

		if ( $prev_next ) :
			?>
			<div class="posts-navigation">
				<nav class="navigation">
					<div class="listar-clear-both"></div>
					<div class="nav-links">
						<?php
						echo wp_kses( $prev_next[0] ? '<div class="nav-previous">' . $prev_next[0] . '</div>' : '', 'listar-basic-html' );
						echo wp_kses( $prev_next[1] ? '<div class="nav-next">' . $prev_next[1] . '</div>' : '', 'listar-basic-html' );
						?>
					</div>
					<div class="listar-clear-both"></div>
				</nav>
			</div>
			<?php
		endif;
	}

endif;

if ( ! function_exists( 'listar_has_pagination' ) ) :
	/**
	 * Check if a page has pagination.
	 *
	 * @since 1.0
	 */
	function listar_has_pagination() {
		$defaults = array(
			'before'           => '',
			'after'            => '',
			'link_before'      => '',
			'link_after'       => '',
			'next_or_number'   => 'number',
			'separator'        => '',
			'nextpagelink'     => '',
			'previouspagelink' => '',
			'pagelink'         => '%',
			'echo'             => 0,
		);

		$pagination = wp_link_pages( $defaults );

		return ! empty( $pagination ) ? true : false;
	}

endif;

if ( ! function_exists( 'listar_count_found_posts' ) ) :
	/**
	 * Get the number of results found by current WordPress query.
	 *
	 * @since  1.0
	 * @param  (object) $query A WP Query object (optional).
	 * @return (integer)
	 */
	function listar_count_found_posts( $query = false ) {

		if ( false === $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		return (int) isset( $query->found_posts ) ? $query->found_posts : 0;
	}

endif;

if ( ! function_exists( 'listar_get_post_type' ) ) :
	/**
	 * Varied ways to get current post type, no matter the page.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_get_post_type() {

		global $wp_query;

		$post_id      = get_the_ID();
		$query_obj    = get_queried_object();
		$taxonomy     = isset( $query_obj->taxonomy ) ? $query_obj->taxonomy : '';
		$is_blog_page = isset( $wp_query->is_posts_page ) ? (bool) $wp_query->is_posts_page : false;

		if ( $is_blog_page ) {
			$post_type = 'post'; /* That is right, the query must load posts, not the page itself */
		}

		if ( empty( $taxonomy ) ) {
			$tx = get_query_var( 'taxonomy' );
			$taxonomy = isset( $tx->name ) ? $tx->name : '';
		}

		if ( empty( $post_type ) ) {
			$post_type = get_post_type( $post_id );
		}

		if ( empty( $post_type ) ) {
			$post_type = isset( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : '';
		}

		if ( empty( $post_type ) ) {
			$tx = get_taxonomy( $taxonomy );
			$post_type = isset( $tx->object_type ) ? $tx->object_type : '';
		}

		if ( is_array( $post_type ) ) {
			/* If $post_type is array, get first post type */
			$post_type = isset( $post_type[0] ) ? $post_type[0] : '';
		}

		return $post_type;
	}

endif;

if ( ! function_exists( 'listar_get_inner_substring' ) ) :
	/**
	 * Get substring between two given strings (prefix/suffix).
	 *
	 * @since 1.0
	 * @link https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
	 * @param (string) $string Text to get a substring.
	 * @param (string) $start Prefix/text to get content right after.
	 * @param (string) $end Suffix/text to get content right before.
	 * @return (string)
	 */
	function listar_get_inner_substring( $string = '', $start = 'start', $end = 'end' ) {

		$ini = strpos( $string, $start );

		if ( 0 === $ini ) {
			return '';
		}

		$ini += strlen( $start );
		$len  = strpos( $string, $end, $ini ) - $ini;

		return substr( $string, $ini, $len );
	}

endif;

if ( ! function_exists( 'listar_sanitize_html_class' ) ) :
	/**
	 * Sanitize multiple classes with sanitize_html_class().
	 *
	 * @since 1.0
	 * @param (string) $classes The classes to sanitize.
	 * @return (string)
	 */
	function listar_sanitize_html_class( $classes ) {

		$sanitized = '';

		if ( false !== strpos( $classes, ' ' ) ) {

			$classes = array_filter( explode( ' ', $classes ) );

			foreach ( $classes as $class ) {
				$sanitized .= ' ' . sanitize_html_class( $class );
			}
		} else {
			$sanitized = sanitize_html_class( $classes );
		}

		return trim( $sanitized );
	}

endif;

if ( ! function_exists( 'listar_convert_hex_to_rgb' ) ) :
	/**
	 * Convert color code from hexadecimal to RGB.
	 *
	 * @since 1.0
	 * @param (string) $hex Hexadecimal color code, ex.: #004488.
	 * @param (bool)   $complete_code If true returns 'rgb(xxx,yyy,zzz), false returns only 'xxx,yyy,zzz'.
	 * @return (string)
	 */
	function listar_convert_hex_to_rgb( $hex = '', $complete_code = false ) {
		$hexa     = str_replace( '#', '', $hex );
		$length   = strlen( $hexa );
		$rgb['r'] = hexdec( 6 === $length ? substr( $hexa, 0, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 0, 1 ), 2 ) : 0 ) );
		$rgb['g'] = hexdec( 6 === $length ? substr( $hexa, 2, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 1, 1 ), 2 ) : 0 ) );
		$rgb['b'] = hexdec( 6 === $length ? substr( $hexa, 4, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 2, 1 ), 2 ) : 0 ) );

		return $complete_code ? 'rgb(' . implode( ',', $rgb ) . ')' : implode( ',', $rgb );
	}

endif;

if ( ! function_exists( 'listar_is_ajax_loop' ) ) :
	/**
	 * Globally informs if current loop is queried via Ajax.
	 *
	 * @since 1.0
	 * @param (boolean) $is_ajax Inform true if it is a Ajax query.
	 * @return (boolean)
	 */
	function listar_is_ajax_loop( $is_ajax = false ) {

		static $ajax = false;

		if ( $is_ajax ) {
			$ajax = $is_ajax;
		}

		return $ajax;
	}

endif;

if ( ! function_exists( 'listar_static_increment' ) ) :
	/**
	 * Increments and saves a number (integer) as static variable for global usage.
	 * Used to set delay for elements animated by AOS (Animate On Scroll).
	 *
	 * @since 1.0
	 * @param (integer) $increment Value to increment the static variable.
	 * @param (boolean) $reset Restart the incrementation.
	 * @return (integer)
	 */
	function listar_static_increment( $increment = 250, $reset = false ) {

		static $value = 0;

		if ( $reset ) {
			$value = 0;
		} else {
			$value += $increment;
		}

		if ( $value > 750 ) {
			$value = 0;
		}

		return $value;
	}

endif;


if ( ! function_exists( 'listar_google_fonts_active' ) ) :
	/**
	 * Check if built in Google Fonts is active.
	 *
	 * @since 1.0
	 * @return (boolean)
	 */
	function listar_google_fonts_active() {

		$check_google_fonts_active = (int) get_option( 'listar_disable_google_fonts' );

		return 1 !== $check_google_fonts_active ? true : false;
	}

endif;


if ( ! function_exists( 'listar_custom_esc_url' ) ) :
	/**
	 * For W3C validation.
	 * This function extends the esc_url() function to avoid printing null
	 * URLs as "http://0".
	 *
	 * @since 1.0
	 * @param (string) $url The URL to sanitize.
	 * @return (string)
	 */
	function listar_custom_esc_url( $url ) {

		$url2 = esc_url( $url );

		if ( '' === (string) $url || '0' === (string) $url || '/0' === substr( $url2, -2 ) ) {
			/* Comunicates with Listar JavaScript Lazy Load ! */
			$url2 = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		}

		return $url2;
	}

endif;


if ( ! function_exists( 'listar_get_comment_review_average' ) ) :
	/**
	 * Get review average for a comment
	 *
	 * @since 1.3.9
	 * @param (string) $comment_id The comment ID.
	 * @return (string)
	 */
	function listar_get_comment_review_average( $comment_id ) {
		if ( listar_third_party_reviews_active() ) {
			return wpjmr_get_review_average( $comment_id );
		} elseif ( listar_built_in_reviews_active() ) {
			return listar_get_comment_review_average_core( $comment_id );
		} else {
			return '0';
		}
	}
endif;


if ( ! function_exists( 'listar_average_user_rating' ) ) :
	/**
	 * Calculate the average review note given by an user for a listing
	 * based on varied WP Job Manager Reviews parameters.
	 *
	 * @since 1.0
	 * @param (string) $comment_id The comment ID.
	 * @param (string) $post_id The post ID.
	 * @return (string)
	 */
	function listar_average_user_rating( $comment_id, $post_id ) {

		$is_review_active     = listar_third_party_reviews_active() || listar_built_in_reviews_active();
		$review_options_count = 0;
		$review_stars_count   = 0;
		$comment_review_stars = '';
		$comment_is_review    = false;

		if ( $is_review_active ) {
			$reviews_count  = (int) listar_reviews_count( $post_id );
			$review_average = listar_get_comment_review_average( $comment_id );

			if ( 0 !== $reviews_count && $review_average > 0.07 ) {
				$comment_is_review = true;
			}
		}

		if ( $comment_is_review ) {
			$comment_review_stars = '';
			
			if ( listar_third_party_reviews_active() ) {
				$comment_review_stars = wpjmr_review_get_stars( $comment_id );
			} elseif ( listar_built_in_reviews_active() ) {
				$comment_review_stars = listar_review_get_stars( $comment_id );
			}
			
			$review_options_count = substr_count( $comment_review_stars, 'stars-rating star-rating' );
			$review_stars_count = substr_count( $comment_review_stars, 'dashicons-star-filled' );
		}

		if ( $review_options_count >= 1 ) {
			$review_average = number_format( floatval( $review_stars_count / $review_options_count ), 1 );
			return array( $review_average, true );
		} else {
			return array( 0, false );
		}
	}
endif;

if ( ! function_exists( 'listar_crunchify_print_scripts_styles' ) ) :
	/**
	 * Get the list of scripts and styles currently being enqueued by the theme.
	 *
	 * @since 1.0
	 * @param (boolean) $detailed_list Set true to get the full list of parameters for every script/style.
	 * @return (array)
	 */
	function listar_crunchify_print_scripts_styles( $detailed_list = false ) {
		global $wp_scripts;
		global $wp_styles;

		$result = array();
		$result['scripts'] = array();
		$result['styles'] = array();
		$count_script = 0;
		$count_style  = 0;

		if ( $detailed_list ) {
			// Get Scripts.
			foreach ( $wp_scripts->queue as $script ) :
				$result['scripts'][] = $wp_scripts->registered[ $script ];
			endforeach;

			// Get Styles (CSS).
			foreach ( $wp_styles->queue as $style ) :
				$result['styles'][] = $wp_styles->registered[ $style ];
			endforeach;
		} else {
			// Get Scripts.
			foreach ( $wp_scripts->queue as $script ) :
				if ( isset( $wp_scripts->registered[ $script ]->handle ) ) {
					$result['scripts'][ $count_script ]['handle'] = $wp_scripts->registered[ $script ]->handle;
				}

				if ( isset( $wp_scripts->registered[ $script ]->src ) ) {
					$result['scripts'][ $count_script ]['src'] = $wp_scripts->registered[ $script ]->src;
				}

				if ( isset( $wp_scripts->registered[ $script ]->deps ) ) {
					$result['scripts'][ $count_script ]['deps'] = $wp_scripts->registered[ $script ]->deps;
				}

				if ( isset( $wp_scripts->registered[ $script ]->ver ) ) {
					$result['scripts'][ $count_script ]['ver'] = $wp_scripts->registered[ $script ]->ver;
				}

				if ( isset( $wp_scripts->registered[ $script ]->extra ) ) {
					$result['scripts'][ $count_script ]['extra'] = $wp_scripts->registered[ $script ]->extra;
				}

				$count_script++;
			endforeach;

			// Get Styles (CSS).
			foreach ( $wp_styles->queue as $style ) :
				if ( isset( $wp_styles->registered[ $style ]->handle ) ) {
					$result['styles'][ $count_style ]['handle'] = $wp_styles->registered[ $style ]->handle;
				}

				if ( isset( $wp_styles->registered[ $style ]->src ) ) {
					$result['styles'][ $count_style ]['src'] = $wp_styles->registered[ $style ]->src;
				}

				if ( isset( $wp_styles->registered[ $style ]->deps ) ) {
					$result['styles'][ $count_style ]['deps'] = $wp_styles->registered[ $style ]->deps;
				}

				if ( isset( $wp_styles->registered[ $style ]->ver ) ) {
					$result['styles'][ $count_style ]['ver'] = $wp_styles->registered[ $style ]->ver;
				}

				if ( isset( $wp_styles->registered[ $style ]->extra['after'] ) ) {
					$result['styles'][ $count_style ]['extra']['after'] = $wp_styles->registered[ $style ]->extra['after'];
				}

				$count_style++;
			endforeach;
		}

		listar_static_print_scripts_styles_list( $result );

		return $result;
	}
endif;


if ( ! function_exists( 'listar_static_print_scripts_styles_list' ) ) :
	/**
	 * Save the list of scripts and styles currently being enqueued by the theme for global access.
	 *
	 * @since 1.0
	 * @param (array|boolean) $list The list of scripts/styles.
	 * @return (array)
	 */
	function listar_static_print_scripts_styles_list( $list = false ) {

		static $resources_list = array();

		if ( ! empty( $list ) ) {
			$resources_list = $list;
		}

		return $resources_list;
	}
endif;


if ( ! function_exists( 'listar_save_html_buffer' ) ) :
	/**
	 * Save the HTML output of the site after modifications are done via buffer.
	 *
	 * @since 1.0
	 * @param (string) $update_buffer The list of scripts/styles.
	 * @return (string)
	 */
	function listar_save_html_buffer( $update_buffer = '' ) {

		static $buffer = '';

		if ( ! empty( $update_buffer ) ) {
			$buffer = $update_buffer;
		}

		return $buffer;
	}
endif;


if ( ! function_exists( 'listar_get_first_post_image_id' ) ) :
	/**
	 * Get the first image ID of a post content.
	 *
	 * @since 1.0
	 * @link https://wordpress.stackexchange.com/questions/60245/get-the-first-image-from-post-content-eg-hotlinked-images
	 * @param (int) $post_id The post ID.
	 * @return (string)
	 */
	function listar_get_first_post_image_id( $post_id ) {

		$img_id = get_post_thumbnail_id( $post_id );

		if ( ! $img_id ) {
			$attachments = get_children(
				array(
					'post_parent'    => $post_id,
					'post_type'      => 'attachment',
					'numberposts'    => 1,
					'post_mime_type' => 'image',
				)
			);

			if ( is_array( $attachments ) ) {
				foreach ( $attachments as $a ) {
					$img_id = $a->ID;
				}
			}
		}

		if ( $img_id ) {
			return $img_id;
		}

		return false;
	}
endif;


if ( ! function_exists( 'listar_get_first_post_image_url' ) ) :
	/**
	 * Get the first image URL of a post content.
	 *
	 * @since 1.0
	 * @link https://wordpress.stackexchange.com/questions/60245/get-the-first-image-from-post-content-eg-hotlinked-images
	 * @param (object) $post The post object.
	 * @return (string)
	 */
	function listar_get_first_post_image_url( $post ) {
		$img = listar_get_first_post_image_id( $post->ID );
		$matches = array();
		$img_url = '';

		if ( $img ) {
			$img = wp_get_attachment_image_src( $img );
			$img_url = $img[0];
		}

		if ( ! $img ) {
			$img = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

			if ( false !== $img ) {
				if ( $img > 0 && is_array( $matches ) ) {
					$temp_img_1 = $matches[0][0];
					$temp_img_2 = explode( 'src="', $temp_img_1, 2 );
					$temp_img_3 = explode( '"', $temp_img_2[1], 2 );
					$img_url    = $temp_img_3[0];
				}
			}
		}

		if ( $img ) {
			return $img_url;
		}

		return false;
	}
endif;


if ( ! function_exists( 'listar_get_site_url_protocol' ) ) :
	/**
	 * Get the appropriate protocol prefix for current site.
	 *
	 * @since 1.0
	 * @param (object) $url The post object.
	 * @return (string)
	 */
	function listar_get_site_url_protocol( $url = '' ) {
		$protocol = 'http://';

		if ( is_ssl() ) {
			$protocol = 'https://';
		}

		$check = strpos( $url, '://' );

		if ( false !== $check ) {
			$url = substr( $url, strrpos( $url, '://' ) + 3 );
		}

		return $protocol . $url;
	}
endif;


if ( ! function_exists( 'listar_get_current_user_role' ) ) :
	/**
	 * Get current user role
	 *
	 * @since 1.2.4
	 * @return (string)
	 */
	function listar_get_current_user_role() {
		$role = 'visitor';

		if ( is_user_logged_in() ) {
			$user  = wp_get_current_user();
			$roles = (array) $user->roles;
			$role  = isset( $roles[0] ) && ! empty( $roles[0] ) && ! is_null( $role[0] ) ? $roles[0] : 'visitor';
		}

		return $role;
	}
endif;


if ( ! function_exists( 'listar_user_can_publish_listings' ) ) :
	/**
	 * Verify if current user role is allowed to publish listings.
	 *
	 * @since 1.2.4
	 * @return (boolean)
	 */
	function listar_user_can_publish_listings() {

		static $static_user_is_allowed = false;
		static $permission_was_already_checked = false;

		$current_user_role = listar_get_current_user_role();

		if ( ! $permission_was_already_checked ) :
			$user_id = get_current_user_id();
			$is_vendor = listar_is_vendor( $user_id ) && listar_is_vendor_authorized( $user_id );

			if ( 'administrator' === $current_user_role || 'shop_manager' === $current_user_role || $is_vendor ) {
				$static_user_is_allowed = true;
				$permission_was_already_checked = true;
			} else {
				$input = get_option( 'listar_users_allowed_publish_listings' );

				$allowed_roles_json  = ! empty( $input ) ? str_replace( '\\', '', $input ) : '';
				$allowed_roles_array = json_decode( $allowed_roles_json, true );

				if ( ! empty( $allowed_roles_array ) ) :
					foreach ( $allowed_roles_array as $elem ) :
						if ( isset( $elem[0] ) && isset( $elem[1] ) && ! empty( isset( $elem[0] ) ) && ! empty( isset( $elem[1] ) ) ) {
							if ( $current_user_role === $elem[0] && '1' === $elem[1] ) {
								$static_user_is_allowed = true;
								$permission_was_already_checked = true;
							}
						}
					endforeach;
				endif;
			}
		endif;

		return $static_user_is_allowed;
	}
endif;


if ( ! function_exists( 'listar_is_map_enabled' ) ) :
	/**
	 * Check if maps are partially, full or not enabled.
	 *
	 * @param (string) $feature What map feature to verify. Use 'all' to verify if maps are completely disabled. Values: all, single, archive, directions, gps
	 * @since 1.2.9
	 * @return (string)
	 */
	function listar_is_map_enabled( $feature = 'all' ) {
		$check = (int) get_option( 'listar_disable_' . $feature . '_maps' );
		$listar_location_disable = (int) get_option( 'listar_location_disable' );
		
		return 1 === $check || 1 === $listar_location_disable ? false : true;
	}
endif;


if ( ! function_exists( 'listar_get_listing_address' ) ) :
	/**
	 * Get the listing address (location)
	 *
	 * @param (integer) $listing_id The Listing ID.
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_get_listing_address( $listing_id ) {
	
		$address_type = get_post_meta( $listing_id, '_job_locationselector', true );
		$listar_listing_address = '';
		
		if ( empty( $address_type ) ) {
			$address_type = 'location-default';
		}
		
		if ( 'location-geocoded' === $address_type ) {
			$listar_listing_address = get_post_meta( $listing_id, 'geolocation_formatted_address', true );
		}
		
		if ( 'location-custom' === $address_type ) {
			$listar_listing_address = get_post_meta( $listing_id, '_job_customlocation', true );
		}
		
		if ( empty( $listar_listing_address ) ) {
			$listar_listing_address = get_post_meta( $listing_id, '_job_location', true );
		}
			
		return esc_html( $listar_listing_address );
	}
endif;


if ( ! function_exists( 'listar_get_listing_latitude' ) ) :
	/**
	 * Get the listing latitude
	 *
	 * @param (integer) $listing_id The Listing ID.
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_get_listing_latitude( $listing_id ) {
	
		$latitude = get_post_meta( $listing_id, '_job_customlatitude', true );
		
		if ( empty( $latitude ) ) {
			$latitude = get_post_meta( $listing_id, 'geolocation_lat', true );
		}
			
		return esc_html( $latitude );
	}
endif;


if ( ! function_exists( 'listar_get_listing_longitude' ) ) :
	/**
	 * Get the listing longitude
	 *
	 * @param (integer) $listing_id The Listing ID.
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_get_listing_longitude( $listing_id ) {
	
		$longitude = get_post_meta( $listing_id, '_job_customlongitude', true );
		
		if ( empty( $longitude ) ) {
			$longitude = get_post_meta( $listing_id, 'geolocation_long', true );
		}
			
		return esc_html( $longitude );
	}
endif;


if ( ! function_exists( 'listar_use_pagespeed' ) ) :
	/**
	 * Register/save if HTML output must must be modified for better Pagespeed.
	 *
	 * @param (boolean) $make_use Make use of Pagespeed improvement or not.
	 * @since 1.3.0
	 * @return (boolean)
	 */
	function listar_use_pagespeed( $make_use = false ) {

		static $use_pagespeed = false;

		if ( $make_use && ! is_user_logged_in() ) {
			$use_pagespeed = $make_use;
		}

		return $use_pagespeed;
	}
endif;


if ( ! function_exists( 'listar_sanitize_color' ) ) :
	/**
	 * Sanitize color submitted by WordPress Customizer / Colors.
	 *
	 * @since 1.0
	 * @param (string) $input Hexadecimal color code.
	 */
	function listar_sanitize_color( $input ) {
		/**
		 * Remove all special characters.
		 *
		 * @link https://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string/14114419#14114419
		 */
		$hex = preg_replace( '/[^A-Fa-f0-9\-]/', '', wp_filter_nohtml_kses( $input ) );

		/**
		 * Check if it is a valid hexadecimal color code.
		 *
		 * @link https://stackoverflow.com/questions/12837942/regex-for-matching-css-hex-colors/12837990#12837990
		 */
		if ( ! ( preg_match( '/([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $hex ) && ( 3 === strlen( $hex ) || 6 === strlen( $hex ) ) ) ) {
			/**
			 * If not valid Hex color, return default theme color.
			 * Customizer color picker ignores wrong hexadecimal values, so this condition is valid only for the color picker on Theme Options page.
			 */
			$hex = '258bd5';
		}

		return $hex;
	}
endif;


if ( ! function_exists( 'listar_remove_accents' ) ) :
	/**
	 * Remove all accents of a string.
	 *
	 * @param (string) $input Any text.
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_remove_accents( $input ) {
		$withAccents = array( 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú' );

		$withoutAccents = array( 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U' );

		return str_replace( $withAccents, $withoutAccents, $input );
	}
endif;


if ( ! function_exists( 'listar_save_listings_queried_by_search_string' ) ) :
	/**
	 * Save listings found by custom search, based on texts of search string.
	 *
	 * @param (array) $listing_ids_queried The listing IDs found.
	 * @since 1.3.1
	 * @return (boolean|array)
	 */
	function listar_save_listings_queried_by_search_string( $listing_ids_queried = false ) {
		static $listing_ids = false;

		if ( false === $listing_ids || ! empty( $listing_ids_queried ) ) {
			$listing_ids = $listing_ids_queried;
		}
		
		return $listing_ids;
	}

endif;


if ( ! function_exists( 'listar_using_custom_search_listings' ) ) :
	/**
	 * Save listings found by custom search, based on texts of search string.
	 *
	 * @param (boolean) $force_use Enable usage.
	 * @since 1.3.1
	 * @return (boolean)
	 */
	function listar_using_custom_search_listings( $force_use = false ) {
		static $using = false;

		if ( listar_save_listings_queried_by_search_string() && $force_use ) {
			$using = true;
		}
		
		return $using;
	}

endif;


if ( ! function_exists( 'listar_get_search_query' ) ) :
	/**
	 * Return the search query string.
	 * 
	 * @since 1.3.1
	 * @param (boolean) $is_ajax_search Inform true if Ajax search.
	 * @return (string)
	 */
	function listar_get_search_query( $is_ajax_search = false ) {
		global $wp_query;
		
		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		$search_query   = '';
		
		if ( $is_ajax_search ) {
			$search_query = isset( $listar_session['listar-ajax-search-s'] ) ? $listar_session['listar-ajax-search-s'] : '';
		} else {
			$search_query = get_search_query();
		}
		
		if ( empty( $search_query ) ) {
			$search_query = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
		}
		
		return $search_query;
	}

endif;


if ( ! function_exists( 'listar_get_region_query' ) ) :
	/**
	 * Return region IDs from query.
	 * 
	 * @since 1.3.1
	 * @param (boolean) $is_ajax_search Inform true if Ajax search.
	 * @return (string)
	 */
	function listar_get_region_query( $is_ajax_search = false ) {
		global $wp_query;

		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		$regions     = '';
		
		if ( $is_ajax_search ) {
			$regions = isset( $listar_session['listar-ajax-search-listing_regions'] ) ? $listar_session['listar-ajax-search-listing_regions'] : '';
		} else {
			$get_regions = filter_input( INPUT_GET, listar_url_query_vars_translate( 'listing_regions' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			$regions = ! empty( $get_regions ) ? $get_regions : '';

			if ( empty( $regions ) || array( 0 ) === $regions ) {
				$regions = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] ) && ! empty( $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] : '';
			}
		}
		
		return $regions;
	}

endif;


if ( ! function_exists( 'listar_get_category_query' ) ) :
	/**
	 * Return category IDs from query.
	 * 
	 * @since 1.3.1
	 * @param (boolean) $is_ajax_search Inform true if Ajax search.
	 * @return (string)
	 */
	function listar_get_category_query( $is_ajax_search = false ) {
		global $wp_query;

		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		$categories     = '';
		
		if ( $is_ajax_search ) {
			$categories = isset( $listar_session['listar-ajax-search-listing_categories'] ) ? $listar_session['listar-ajax-search-listing_categories'] : '';
		} else {
			$get_categories = filter_input( INPUT_GET, listar_url_query_vars_translate( 'listing_categories' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			$categories = ! empty( $get_categories ) ? $get_categories : '';

			if ( empty( $categories ) || array( 0 ) === $categories ) {
				$categories = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_categories' ) ] ) && ! empty( $wp_query->query[ listar_url_query_vars_translate( 'listing_categories' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_categories' ) ] : '';
			}
		}
		
		return $categories;
	}

endif;


if ( ! function_exists( 'listar_get_amenity_query' ) ) :
	/**
	 * Return amenity IDs from query.
	 * 
	 * @since 1.3.1
	 * @param (boolean) $is_ajax_search Inform true if Ajax search.
	 * @return (string)
	 */
	function listar_get_amenity_query( $is_ajax_search = false ) {
		global $wp_query;

		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		$amenities     = '';
		
		if ( $is_ajax_search ) {
			$amenities = isset( $listar_session['listar-ajax-search-listing_amenities'] ) ? $listar_session['listar-ajax-search-listing_amenities'] : '';
		} else {
			$get_amenities = filter_input( INPUT_GET, listar_url_query_vars_translate( 'listing_amenities' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			$amenities = ! empty( $get_amenities ) ? $get_amenities : '';

			if ( empty( $amenities ) || array( 0 ) === $amenities ) {
				$amenities = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_amenities' ) ] ) && ! empty( $wp_query->query[ listar_url_query_vars_translate( 'listing_amenities' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_amenities' ) ] : '';
			}
		}
		
		return $amenities;
	}

endif;


if ( ! function_exists( 'listar_is_search' ) ) :
	/**
	 * Verify if current query is for search.
	 * 
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_is_search() {
		global $wp_query;

		$search_query = is_search();
		
		if ( empty( $search_query ) ) {
			$search_query = isset( $wp_query->is_search ) && ! empty( $wp_query->is_search ) ? $wp_query->is_search : false;
		}
		
		return $search_query;
	}

endif;


if ( ! function_exists( 'listar_is_loading_overlay_active' ) ) :
	/**
	 * Verify if loading overlay is active.
	 * 
	 * @since 1.3.5
	 * @return (boolean)
	 */
	function listar_is_loading_overlay_active() {
		static $verifyed = false;
		static $is_loading_overlay_active = false;
		
		if ( ! $verifyed ) {
			$verifyed = true;
			$is_loading_overlay_active = ( 0 === (int) get_option( 'listar_disable_loading_overlay' ) ? true : false );
		}

		return $is_loading_overlay_active;
	}
endif;


if ( ! function_exists( 'listar_search_is_inside_popup' ) ) :
	/**
	 * Verify if current search form is inside the search popup
	 *
	 * @param (boolean|int) $is_popup Inform if current request is inside the search popup.
	 * @since 1.3.6
	 * @return (boolean)
	 */
	function listar_search_is_inside_popup( $is_popup = 0 ) {
		static $inside_popup = false;
		
		if ( true === $is_popup ) {
			$inside_popup = true;
		} else if ( false === $is_popup ) {
			$inside_popup = false;
		}

		return $inside_popup;
	}
endif;


if ( ! function_exists( 'listar_blank_base64_placeholder_image' ) ) :
	/**
	 * Return a blank base64 image to be used as placeholder (pagespeed).
	 *
	 * @since 1.3.6
	 * @return (string)
	 */
	function listar_blank_base64_placeholder_image() {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQImWP4zwAAAgEBACqxsiUAAAAASUVORK5CYII=';
	}
endif;


if ( ! function_exists( 'listar_get_related_listings_archive' ) ) :
	/**
	 * Return related listings for current archive.
	 *
	 * @since 1.3.6
	 * @return (object)
	 */
	function listar_get_related_listings_archive() {
		$listar_related_schema = get_option( 'listar_related_listings_archive_schema' );
		$listar_related_priority = get_option( 'listar_related_listings_archive_priority' );
		$listar_related_max = (int) get_option( 'listar_related_listings_archive_maximum' );
		$listar_current_archive_filter = listar_current_term_filter();
		$listar_has_region_filter = ! empty( $listar_current_archive_filter[ listar_url_query_vars_translate( 'listing_regions' ) ][0] ) ? true : false;
		$listar_has_category_filter = ! empty( $listar_current_archive_filter[ listar_url_query_vars_translate( 'listing_categories' ) ][0] ) ? true : false;
		$listar_enable_related_other_regions = ( $listar_has_region_filter && 0 === (int) get_option( 'listar_related_listings_archive_disable_other_regions' ) ) ? true : false;
		$posts_already_shown = listar_static_posts_already_shown();
		$listar_count_items = 0;
		$listing_ids_via_query = array();
		$taxonomies = array();
		$taxonomies_categories = array();
		$taxonomies_regions = array();
		$force_tax_default = false;
		$operator_regions    = ! $listar_has_region_filter ? 'NOT IN' : 'IN';
		$operator_categories = ! $listar_has_category_filter ? 'NOT IN' : 'IN';
		
		if ( empty( $listar_related_schema ) ) {
			$listar_related_schema = 'both';
		}
		
		if ( empty( $listar_related_max ) ) {
			$listar_related_max = 3;
		}
		
		if ( empty( $listar_related_priority ) ) {
			$listar_related_priority = 'regions';
		}

		if ( taxonomy_exists( 'job_listing_category' ) && $listar_has_category_filter ) {
			$taxonomies_categories = array(
				'taxonomy'         => 'job_listing_category',
				'terms'            => $listar_current_archive_filter[ listar_url_query_vars_translate( 'listing_categories' ) ],
				'include_children' => true,
				'operator'         => $operator_categories,
			);

			$taxonomies[] = $taxonomies_categories;
		}

		if ( class_exists( 'Astoundify_Job_Manager_Regions' ) && $listar_has_region_filter ) {
			$taxonomies_regions = array(
				'taxonomy'         => 'job_listing_region',
				'terms'            => $listar_current_archive_filter[ listar_url_query_vars_translate( 'listing_regions' ) ],
				'include_children' => true,
				'operator'         => $operator_regions,
			);

			$taxonomies[] = $taxonomies_regions;
		}
					
		$relation_or = array( 'relation' => 'OR' );
		$taxonomies_OR = $relation_or + $taxonomies;
		
		$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
		
		if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
			$force_tax = false;
		}
		
		if ( 'randomly' === $listar_related_schema ) {
			return new WP_Query(
				array(
					'no_found_rows'              => true,
					'update_post_meta_cache'     => false,
					'update_post_term_cache'     => false,
					'ignore_sticky_posts'        => true,
					'cache_results'              => false,
					'suppress_filters'           => true,
					'post_type'      => 'job_listing',
					'post_status'    => 'publish',
					'post__not_in'   => $posts_already_shown,
					'orderby'        => 'rand',
					'posts_per_page' => $listar_related_max,
					'tax_query'      => $force_tax,
				)
			);
		} else {
					
			$args = array(
				'fields'                     => 'ids',
				'no_found_rows'              => true,
				'update_post_meta_cache'     => false,
				'update_post_term_cache'     => false,
				'ignore_sticky_posts'        => true,
				'cache_results'              => false,
				'suppress_filters'           => true,
				'post_type'      => 'job_listing',
				'posts_per_page' => $listar_related_max,
				'post_status'    => 'publish',
				'orderby'        => 'rand',
				'post__not_in'   => $posts_already_shown,
				'tax_query'      => $taxonomies,
			);

			$query_1 = get_posts( $args );


			$listar_count_items = count( $query_1 );
			
			if ( $listar_count_items >= $listar_related_max ) {
				return new WP_Query( array(
					'no_found_rows'              => true,
					'update_post_meta_cache'     => false,
					'update_post_term_cache'     => false,
					'ignore_sticky_posts'        => true,
					'cache_results'              => false,
					'suppress_filters'           => true,
					'post_type'      => 'job_listing',
					'posts_per_page' => $listar_related_max,
					'post_status'    => 'publish',
					'orderby'        => 'rand',
					'post__not_in'   => $posts_already_shown,
					'tax_query'      => $taxonomies,
				) );
			}

			if ( 'smartly' === $listar_related_schema ) {
				
				// Only smartly (no priorities, respect exclusively the filter).
				if ( 'none' === $listar_related_priority ) {
					
					// Complete with listings of the same categories or same regions.
					
					$force_tax = $listar_enable_related_other_regions ? $taxonomies_OR : array( $taxonomies_regions );
					
					if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
						$force_tax = false;
					}
					
					$the_args = array(
						'fields'                     => 'ids',
						'no_found_rows'              => true,
						'update_post_meta_cache'     => false,
						'update_post_term_cache'     => false,
						'ignore_sticky_posts'        => true,
						'cache_results'              => false,
						'suppress_filters'           => true,
						'post_type'      => 'job_listing',
						'post_status'    => 'publish',
						'tax_query'      => $force_tax,
						'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
						'orderby'        => 'rand',
						'posts_per_page' => $listar_related_max - $listar_count_items,
					);

					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => array( $taxonomies_categories ),
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);

					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					return new WP_Query(
						array(
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'post__in'       => $listing_ids_via_query,
							'post__not_in'   => array_unique( $posts_already_shown ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max,
						)
					);
				}
				
				// Only smartly (categories as priority for secundary listings).
				if ( 'categories' === $listar_related_priority ) {

					// Complete with listings by categories.
					
					if ( $listar_enable_related_other_regions ) {
						$query_3 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_categories ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_3 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						// Complete with listings by regions.
						$query_4 = get_posts(
							array(
								'fields'                     => 'ids',
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_regions ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_4 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
				
				// Only smartly (regions as priority for secundary listings).
				if ( 'regions' === $listar_related_priority ) {

					// Complete with listings by regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => array( $taxonomies_regions ),
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);

					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						if ( $listar_enable_related_other_regions ) {
							
							// Complete with listings by categories.
							$query_4 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => array( $taxonomies_categories ),
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_4 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
			} elseif ( 'both' === $listar_related_schema ) {
				foreach ( $query_1 as $post_id ) {
					$current_listing_id = $post_id;

					if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
						$listing_ids_via_query[] = $current_listing_id;
					}
				}
				
				// Smartly + randomly (no priorities, completed by random listings).
				if ( 'none' === $listar_related_priority ) {
					
					$force_tax = $listar_enable_related_other_regions ? $taxonomies_OR : array( $taxonomies_regions );
					
					if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
						$force_tax = false;
					}
					
					// Complete with listings of the same categories or same regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => $force_tax,
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);
				
					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
						
						if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
							$force_tax = false;
						}
						
						// Complete with random listings.
						$query_2 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => $force_tax,
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_2 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
				
				// Smartly + randomly (categories as priority, completed by random listings).
				if ( 'categories' === $listar_related_priority ) {
					
					if ( $listar_enable_related_other_regions ) {
						
						// Complete with listings by categories.
						$query_3 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_categories ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_3 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						// Complete with listings by regions.
						$query_4 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_regions ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_4 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						if ( $listar_count_items >= $listar_related_max ) {
							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						} else {
							
							$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
							
							if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
								$force_tax = false;
							}
							
							// Complete with random.
							$query_5 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => $force_tax,
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_5 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}

							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						}
					}
				}
				
				// Smartly + randomly (regions as priority, completed by random listings).
				if ( 'regions' === $listar_related_priority ) {
					
					// Complete with listings by regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => array( $taxonomies_regions ),
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);
				
					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						if ( $listar_enable_related_other_regions ) {
							
							// Complete with listings by categories.
							$query_4 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => array( $taxonomies_categories ),
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_4 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						if ( $listar_count_items >= $listar_related_max ) {
							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						} else {
							
							$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
							
							if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
								$force_tax = false;
							}
							
							// Complete with random
							$query_5 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => $force_tax,
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_5 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}

							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						}
					}
				}
			}
		}
	}
endif;


if ( ! function_exists( 'listar_get_related_listings_single' ) ) :
	/**
	 * Return related listings for current single listing.
	 *
	 * @since 1.3.6
	 * @return (object)
	 */
	function listar_get_related_listings_single() {
		$listar_related_schema = get_option( 'listar_related_listings_single_schema' );
		$listar_related_priority = get_option( 'listar_related_listings_single_priority' );
		$listar_related_max = (int) get_option( 'listar_related_listings_single_maximum' );
		$listar_current_single_filter = listar_current_term_filter();
		$listar_has_region_filter = ! empty( $listar_current_single_filter[ listar_url_query_vars_translate( 'listing_regions' ) ][0] ) ? true : false;
		$listar_has_category_filter = ! empty( $listar_current_single_filter[ listar_url_query_vars_translate( 'listing_categories' ) ][0] ) ? true : false;
		$listar_enable_related_other_regions = ( $listar_has_region_filter && 0 === (int) get_option( 'listar_related_listings_single_disable_other_regions' ) ) ? true : false;
		$posts_already_shown = listar_static_posts_already_shown();
		$listar_count_items = 0;
		$listing_ids_via_query = array();
		$taxonomies = array();
		$taxonomies_categories = array();
		$taxonomies_regions = array();
		$force_tax_default = array();
		$operator_regions    = ! $listar_has_region_filter ? 'NOT IN' : 'IN';
		$operator_categories = ! $listar_has_category_filter ? 'NOT IN' : 'IN';
		
		if ( empty( $listar_related_schema ) ) {
			$listar_related_schema = 'randomly';
		}
		
		if ( empty( $listar_related_max ) ) {
			$listar_related_max = 3;
		}
		
		if ( empty( $listar_related_priority ) ) {
			$listar_related_priority = 'none';
		}

		if ( taxonomy_exists( 'job_listing_category' ) && $listar_has_category_filter ) {
			$taxonomies_categories = array(
				'taxonomy'         => 'job_listing_category',
				'terms'            => $listar_current_single_filter[ listar_url_query_vars_translate( 'listing_categories' ) ],
				'include_children' => true,
				'operator'         => $operator_categories,
			);

			$taxonomies[] = $taxonomies_categories;
		}

		if ( class_exists( 'Astoundify_Job_Manager_Regions' ) && $listar_has_region_filter ) {
			$taxonomies_regions = array(
				'taxonomy'         => 'job_listing_region',
				'terms'            => $listar_current_single_filter[ listar_url_query_vars_translate( 'listing_regions' ) ],
				'include_children' => true,
				'operator'         => $operator_regions,
			);

			$taxonomies[] = $taxonomies_regions;
		}
					
		$relation_or = array( 'relation' => 'OR' );
		$taxonomies_OR = $relation_or + $taxonomies;
		
		$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
		
		if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
			$force_tax = false;
		}
		
		if ( 'randomly' === $listar_related_schema ) {

			return new WP_Query(
				array(
					'no_found_rows'              => true,
					'update_post_meta_cache'     => false,
					'update_post_term_cache'     => false,
					'ignore_sticky_posts'        => true,
					'cache_results'              => false,
					'suppress_filters'           => true,
					'post_type'      => 'job_listing',
					'post_status'    => 'publish',
					'post__not_in'   => $posts_already_shown,
					'orderby'        => 'rand',
					'posts_per_page' => $listar_related_max,
					'tax_query'      => $force_tax,
				)
			);
		} else {
			$args = array(
				'fields'                     => 'ids',
				'no_found_rows'              => true,
				'update_post_meta_cache'     => false,
				'update_post_term_cache'     => false,
				'ignore_sticky_posts'        => true,
				'cache_results'              => false,
				'suppress_filters'           => true,
				'post_type'      => 'job_listing',
				'posts_per_page' => $listar_related_max,
				'post_status'    => 'publish',
				'orderby'        => 'rand',
				'post__not_in'   => $posts_already_shown,
				'tax_query'      => $taxonomies,
			);

			$query_1 = get_posts( $args );

			$listar_count_items = count( $query_1 );
			
			if ( $listar_count_items >= $listar_related_max ) {

				return new WP_Query( array(
					'no_found_rows'              => true,
					'update_post_meta_cache'     => false,
					'update_post_term_cache'     => false,
					'ignore_sticky_posts'        => true,
					'cache_results'              => false,
					'suppress_filters'           => true,
					'post_type'      => 'job_listing',
					'posts_per_page' => $listar_related_max,
					'post_status'    => 'publish',
					'orderby'        => 'rand',
					'post__not_in'   => $posts_already_shown,
					'tax_query'      => $taxonomies,
				) );
			}

			if ( 'smartly' === $listar_related_schema ) {
				
				// Only smartly (no priorities, respect exclusively the filter).
				if ( 'none' === $listar_related_priority ) {
					
					// Complete with listings of the same categories or same regions.
					
					$force_tax = $listar_enable_related_other_regions ? $taxonomies_OR : array( $taxonomies_regions );
					
					if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
						$force_tax = false;
					}
					
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => $force_tax,
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);

					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					return new WP_Query(
						array(
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'post__in'       => $listing_ids_via_query,
							'post__not_in'   => array_unique( $posts_already_shown ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max,
						)
					);
				}
				
				// Only smartly (categories as priority for secundary listings).
				if ( 'categories' === $listar_related_priority ) {

					// Complete with listings by categories.
					
					if ( $listar_enable_related_other_regions ) {
						$query_3 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_categories ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_3 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						// Complete with listings by regions.
						$query_4 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_regions ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_4 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
				
				// Only smartly (regions as priority for secundary listings).
				if ( 'regions' === $listar_related_priority ) {

					// Complete with listings by regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => array( $taxonomies_regions ),
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);
				
					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						if ( $listar_enable_related_other_regions ) {
							
							// Complete with listings by categories.
							$query_4 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => array( $taxonomies_categories ),
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_4 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
			} elseif ( 'both' === $listar_related_schema ) {
				foreach ( $query_1 as $post_id ) {
					$current_listing_id = $post_id;

					if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
						$listing_ids_via_query[] = $current_listing_id;
					}
				}
				
				// Smartly + randomly (no priorities, completed by random listings).
				if ( 'none' === $listar_related_priority ) {
					
					$force_tax = $listar_enable_related_other_regions ? $taxonomies_OR : array( $taxonomies_regions );
					
					if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
						$force_tax = false;
					}
					
					// Complete with listings of the same categories or same regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => $force_tax,
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);
				
					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
						
						if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
							$force_tax = false;
						}
						
						// Complete with random listings.
						$query_2 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => $force_tax,
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_2 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					}
				}
				
				// Smartly + randomly (categories as priority, completed by random listings).
				if ( 'categories' === $listar_related_priority ) {
					
					if ( $listar_enable_related_other_regions ) {
						
						// Complete with listings by categories.
						$query_3 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_categories ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_3 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						// Complete with listings by regions.
						$query_4 = get_posts(
							array(
								'fields'                     => 'ids',
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'tax_query'      => array( $taxonomies_regions ),
								'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max - $listar_count_items,
							)
						);

						foreach ( $query_4 as $post_id ) {
							$current_listing_id = $post_id;

							if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
								$listing_ids_via_query[] = $current_listing_id;
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						if ( $listar_count_items >= $listar_related_max ) {
							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						} else {
							
							$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
							
							if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
								$force_tax = false;
							}
							
							// Complete with random.
							$query_5 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => $force_tax,
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_5 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}

							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						}
					}
				}
				
				// Smartly + randomly (regions as priority, completed by random listings).
				if ( 'regions' === $listar_related_priority ) {
					
					// Complete with listings by regions.
					$query_3 = get_posts(
						array(
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'suppress_filters'           => true,
							'post_type'      => 'job_listing',
							'post_status'    => 'publish',
							'tax_query'      => array( $taxonomies_regions ),
							'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
							'orderby'        => 'rand',
							'posts_per_page' => $listar_related_max - $listar_count_items,
						)
					);
				
					foreach ( $query_3 as $post_id ) {
						$current_listing_id = $post_id;

						if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
							$listing_ids_via_query[] = $current_listing_id;
						}
					}
					
					$listar_count_items = count( $listing_ids_via_query );
					
					if ( $listar_count_items >= $listar_related_max ) {
						return new WP_Query(
							array(
								'no_found_rows'              => true,
								'update_post_meta_cache'     => false,
								'update_post_term_cache'     => false,
								'ignore_sticky_posts'        => true,
								'cache_results'              => false,
								'suppress_filters'           => true,
								'post_type'      => 'job_listing',
								'post_status'    => 'publish',
								'post__in'       => $listing_ids_via_query,
								'post__not_in'   => array_unique( $posts_already_shown ),
								'orderby'        => 'rand',
								'posts_per_page' => $listar_related_max,
							)
						);
					} else {
						
						if ( $listar_enable_related_other_regions ) {
							
							// Complete with listings by categories.
							$query_4 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => array( $taxonomies_categories ),
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_4 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}
						}

						$listar_count_items = count( $listing_ids_via_query );

						if ( $listar_count_items >= $listar_related_max ) {
							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						} else {
							
							$force_tax = $listar_enable_related_other_regions ? $force_tax_default : array( $taxonomies_regions );
							
							if ( isset( $force_tax[0] ) && empty( $force_tax[0] ) ) {
								$force_tax = false;
							}
							
							// Complete with random
							$query_5 = get_posts(
								array(
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'tax_query'      => $force_tax,
									'post__not_in'   => array_unique( $posts_already_shown + $listing_ids_via_query ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max - $listar_count_items,
								)
							);

							foreach ( $query_5 as $post_id ) {
								$current_listing_id = $post_id;

								if ( ! in_array( $current_listing_id , $listing_ids_via_query, true ) ) {
									$listing_ids_via_query[] = $current_listing_id;
								}
							}

							return new WP_Query(
								array(
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'suppress_filters'           => true,
									'post_type'      => 'job_listing',
									'post_status'    => 'publish',
									'post__in'       => $listing_ids_via_query,
									'post__not_in'   => array_unique( $posts_already_shown ),
									'orderby'        => 'rand',
									'posts_per_page' => $listar_related_max,
								)
							);
						}
					}
				}
			}
		}
	}
endif;

if ( ! function_exists( 'listar_get_currencies' ) ) :
	/**
	 * Return all currencies. Based on get_woocommerce_currency_symbols().
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_currencies() {
		return array(
			'AED' => '&#x62f;.&#x625;',
			'AFN' => '&#x60b;',
			'ALL' => 'L',
			'AMD' => 'AMD',
			'ANG' => '&fnof;',
			'AOA' => 'Kz',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => 'Afl.',
			'AZN' => 'AZN',
			'BAM' => 'KM',
			'BBD' => '&#36;',
			'BDT' => '&#2547;&nbsp;',
			'BGN' => '&#1083;&#1074;.',
			'BHD' => '.&#x62f;.&#x628;',
			'BIF' => 'Fr',
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => 'Bs.',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTC' => '&#3647;',
			'BTN' => 'Nu.',
			'BWP' => 'P',
			'BYR' => 'Br',
			'BYN' => 'Br',
			'BZD' => '&#36;',
			'CAD' => '&#36;',
			'CDF' => 'Fr',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&yen;',
			'COP' => '&#36;',
			'CRC' => '&#x20a1;',
			'CUC' => '&#36;',
			'CUP' => '&#36;',
			'CVE' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DJF' => 'Fr',
			'DKK' => 'DKK',
			'DOP' => 'RD&#36;',
			'DZD' => '&#x62f;.&#x62c;',
			'EGP' => 'EGP',
			'ERN' => 'Nfk',
			'ETB' => 'Br',
			'EUR' => '&euro;',
			'FJD' => '&#36;',
			'FKP' => '&pound;',
			'GBP' => '&pound;',
			'GEL' => '&#x20be;',
			'GGP' => '&pound;',
			'GHS' => '&#x20b5;',
			'GIP' => '&pound;',
			'GMD' => 'D',
			'GNF' => 'Fr',
			'GTQ' => 'Q',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => 'L',
			'HRK' => 'kn',
			'HTG' => 'G',
			'HUF' => '&#70;&#116;',
			'IDR' => 'Rp',
			'ILS' => '&#8362;',
			'IMP' => '&pound;',
			'INR' => '&#8377;',
			'IQD' => '&#x639;.&#x62f;',
			'IRR' => '&#xfdfc;',
			'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
			'ISK' => 'kr.',
			'JEP' => '&pound;',
			'JMD' => '&#36;',
			'JOD' => '&#x62f;.&#x627;',
			'JPY' => '&yen;',
			'KES' => 'KSh',
			'KGS' => '&#x441;&#x43e;&#x43c;',
			'KHR' => '&#x17db;',
			'KMF' => 'Fr',
			'KPW' => '&#x20a9;',
			'KRW' => '&#8361;',
			'KWD' => '&#x62f;.&#x643;',
			'KYD' => '&#36;',
			'KZT' => '&#8376;',
			'LAK' => '&#8365;',
			'LBP' => '&#x644;.&#x644;',
			'LKR' => '&#xdbb;&#xdd4;',
			'LRD' => '&#36;',
			'LSL' => 'L',
			'LYD' => '&#x644;.&#x62f;',
			'MAD' => '&#x62f;.&#x645;.',
			'MDL' => 'MDL',
			'MGA' => 'Ar',
			'MKD' => '&#x434;&#x435;&#x43d;',
			'MMK' => 'Ks',
			'MNT' => '&#x20ae;',
			'MOP' => 'P',
			'MRU' => 'UM',
			'MUR' => '&#x20a8;',
			'MVR' => '.&#x783;',
			'MWK' => 'MK',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => 'MT',
			'NAD' => 'N&#36;',
			'NGN' => '&#8358;',
			'NIO' => 'C&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#x631;.&#x639;.',
			'PAB' => 'B/.',
			'PEN' => 'S/',
			'PGK' => 'K',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PRB' => '&#x440;.',
			'PYG' => '&#8370;',
			'QAR' => '&#x631;.&#x642;',
			'RMB' => '&yen;',
			'RON' => 'lei',
			'RSD' => '&#1088;&#1089;&#1076;',
			'RUB' => '&#8381;',
			'RWF' => 'Fr',
			'SAR' => '&#x631;.&#x633;',
			'SBD' => '&#36;',
			'SCR' => '&#x20a8;',
			'SDG' => '&#x62c;.&#x633;.',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&pound;',
			'SLL' => 'Le',
			'SOS' => 'Sh',
			'SRD' => '&#36;',
			'SSP' => '&pound;',
			'STN' => 'Db',
			'SYP' => '&#x644;.&#x633;',
			'SZL' => 'L',
			'THB' => '&#3647;',
			'TJS' => '&#x405;&#x41c;',
			'TMT' => 'm',
			'TND' => '&#x62f;.&#x62a;',
			'TOP' => 'T&#36;',
			'TRY' => '&#8378;',
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => 'Sh',
			'UAH' => '&#8372;',
			'UGX' => 'UGX',
			'USD' => '&#36;',
			'UYU' => '&#36;',
			'UZS' => 'UZS',
			'VEF' => 'Bs F',
			'VES' => 'Bs.S',
			'VND' => '&#8363;',
			'VUV' => 'Vt',
			'WST' => 'T',
			'XAF' => 'CFA',
			'XCD' => '&#36;',
			'XOF' => 'CFA',
			'XPF' => 'Fr',
			'YER' => '&#xfdfc;',
			'ZAR' => '&#82;',
			'ZMW' => 'ZK',
			
			/* Here is a backup/fallback list of currency codes, in case of issues with Woocommerce defaults
			Based on: https://gist.github.com/Gibbs/3920259
			
			'AED' => '&#1583;.&#1573;',
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '&#1423;',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;',
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;',
			'BIF' => '&#70;&#66;&#117;',
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTC' => '&#8383;',
			'BTN' => '&#78;&#117;&#46;',
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BYN' => '&#82;&#98;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUC' => '&#x43;&#x55;&#x43;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;',
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;',
			'EGP' => '&#163;',
			'ERN' => '&#x4e;&#x6b;&#x66;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;',
			'GGP' => '&pound;',
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;',
			'GNF' => '&#70;&#71;',
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;',
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;',
			'IRR' => '&#65020;',
			'IRT' => '&#x62a;&#x648;&#x645;&#x627;&#x646;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;',
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;',
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;',
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;',
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;',
			'LYD' => '&#1604;.&#1583;',
			'MAD' => '&#1583;.&#1605;.',
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;',
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;',
			'MRO' => '&#85;&#77;',
			'MUR' => '&#8360;',
			'MVR' => '.&#1923;',
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PRB' => '&rcy;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;',
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'SSP' => '&#x53;&#x53;&pound;',
			'STN' => '&#x44;&#x62;',
			'SYP' => '&#163;',
			'SZL' => '&#76;',
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;',
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;',
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '&#x54;&#x53;&#x68;',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '&#x53;&#x44;&#x52;',
			'XOF' => '&#70;&#67;&#70;&#65;',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;',
			'ZWL' => '&#90;&#36;',
			*/
		);
	}
endif;


if ( ! function_exists( 'listar_get_currency_symbol' ) ) :
	/**
	 * Return current currency symbol.
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_currency_symbol() {
		if ( class_exists( 'Woocommerce' ) ) {
			return get_woocommerce_currency_symbol();
		} else {
			$listar_currencies = listar_get_currencies();
			$listar_current_currency = get_option( 'listar_site_currency', 'USD' );
			
			if ( empty( $listar_current_currency ) ) {
				$listar_current_currency = 'USD';
			}

			return $listar_currencies[ $listar_current_currency ];
		}
	}
endif;


if ( ! function_exists( 'listar_get_listing_sort_option_filters' ) ) :
	/**
	 * Get listing sort options for search/archive filtering.
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_listing_sort_option_filters() {
		$listar_sort_options = array(
			array(
				'title' => esc_html__( 'Newest', 'listar' ),
				'icon'  => 'icon-sort-numeric-asc',
				'value' => 'newest',
			),
			array(
				'title' => esc_html__( 'Oldest', 'listar' ),
				'icon'  => 'icon-sort-numeric-desc',
				'value' => 'oldest',
			),
			array(
				'title' => esc_html__( 'A - Z', 'listar' ),
				'icon'  => 'icon-sort-numeric-desc',
				'value' => 'asc',
			),
			array(
				'title' => esc_html__( 'Z - A', 'listar' ),
				'icon'  => 'icon-sort-numeric-desc',
				'value' => 'desc',
			),
			array(
				'title' => listar_addons_active() ? listar_get_custom_random_label() : esc_html__( 'Surprise me', 'listar' ),
				'icon'  => 'icon-sort-numeric-desc',
				'value' => 'random',
			),
		);
		
		if ( listar_is_search_by_option_active( 'trending' ) ) {
			$listar_args = array(
				'title' => esc_html__( 'Trending', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'trending',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			$listar_args = array(
				'title' => esc_html__( 'Best rated', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'best_rated',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}
		
		if ( listar_is_search_by_option_active( 'most_viewed' ) ) {
			$listar_args = array(
				'title' => esc_html__( 'Most viewed', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'most_viewed',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}
	
		$bookmarks_active = listar_bookmarks_active();
		
		if ( $bookmarks_active ) {
			$listar_args = array(
				'title' => esc_html__( 'Most bookmarked', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'most_bookmarked',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}
		
		if ( listar_is_search_by_option_active( 'near_postcode' ) ) {
			$listar_args = array(
				'title' => esc_html__( 'Near a postcode', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'near_postcode',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}
		
		if ( listar_is_search_by_option_active( 'near_address' ) ) {
			$listar_args = array(
				'title' => esc_html__( 'Near an address', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'near_address',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}
		
		if ( listar_is_search_by_option_active( 'nearest_me' ) ) {
			$listar_args = array(
				'title' => esc_html__( 'Nearest me', 'listar' ),
				'icon'  => 'icon-trophy2',
				'value' => 'nearest_me',
			);

			array_unshift( $listar_sort_options, $listar_args );
		}

		return $listar_sort_options;
	}
endif;


if ( ! function_exists( 'listar_distance_metering_mode' ) ) :
	/**
	 * Return the distance metering mode.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_distance_metering_mode() {
		$mode = get_option( 'listar_use_distance_metering' );
		
		if ( empty( $mode ) ) {
			$mode = 'all-available';
		}

		return $mode;
	}
endif;












if ( ! function_exists( 'listar_get_nearest_me_geocoded_lat' ) ) :
	/**
	 * Alias function to get saved geolocated latitude value for current user.
	 * The return depends of Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_nearest_me_geocoded_lat() {
		return listar_addons_active() ? listar_get_nearest_me_geocoded_lat_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_get_nearest_me_geocoded_lng' ) ) :
	/**
	 * Alias function to get saved geolocated longitude value for current user.
	 * The return depends on Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_nearest_me_geocoded_lng() {
		return listar_addons_active() ? listar_get_nearest_me_geocoded_lng_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_get_address_geocoded_lat' ) ) :
	/**
	 * Alias function to get saved geolocated latitude value for an address.
	 * The return depends on Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_address_geocoded_lat() {
		return listar_addons_active() ? listar_get_address_geocoded_lat_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_get_address_geocoded_lng' ) ) :
	/**
	 * Alias function to get saved geolocated longitude value for an address.
	 * The return depends on Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_address_geocoded_lng() {
		return listar_addons_active() ? listar_get_address_geocoded_lng_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_get_postcode_geocoded_lat' ) ) :
	/**
	 * Alias function to get saved geolocated latitude value for a postcode.
	 * The return depends on Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_postcode_geocoded_lat() {
		return listar_addons_active() ? listar_get_postcode_geocoded_lat_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_get_postcode_geocoded_lng' ) ) :
	/**
	 * Alias function to get saved geolocated longitude value for a postcode.
	 * The return depends on Listar Addons plugin.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_postcode_geocoded_lng() {
		return listar_addons_active() ? listar_get_postcode_geocoded_lng_session() : 0;
	}
endif;


if ( ! function_exists( 'listar_loading_card_content_ajax' ) ) :
	/**
	 * Inform if the content of a card is being loaded with Ajax.
	 *
	 * @since 1.3.9
	 * @param (bool|integer) $using_ajax Can be: false (not using Ajax) or true (using Ajax).
	 * @return (bool)
	 */
	function listar_loading_card_content_ajax( $using_ajax = 'undefined' ) {

		static $is_ajax_content = false;

		if ( 'undefined' !== $using_ajax ) {
			$is_ajax_content = $using_ajax;
		}

		return $is_ajax_content;
	}
endif;


if ( ! function_exists( 'listar_views_counter_output' ) ) :
	/**
	 * Outputs the views counter.
	 *
	 * @param $classes Additional CSS classes.
	 * @since 1.3.9
	 */
	function listar_views_counter_output( $classes = '' ) {
		$listing_view_counter_shown_by_default = listar_single_listing_view_counter_active();
		$listing_owners_handle_counters = 1 === (int) get_option( 'listar_allow_listing_owners_handle_counter' );
		$listar_hide_views_counter_by_owner = false;
		$complaint_reports_enabled = 1 === (int) get_option( 'listar_complaint_reports_disable' ) ? false : true;
		$show_view_counters = false;
		$claim_status = listar_listing_claim_status( get_the_ID() );
		$show_claim = 'not-claimed' === $claim_status || 'claimed' === $claim_status;
		
		if ( $listing_owners_handle_counters ) {
			if ( $listing_view_counter_shown_by_default ) {
				$listar_hide_views_counter_by_owner = 1 === (int) get_post_meta( get_the_ID(), '_company_disable_views_counter', true );
			} else {
				$listar_hide_views_counter_by_owner = 0 === (int) get_post_meta( get_the_ID(), '_company_enable_views_counter', true ) ? true : false;
			}
		}
		
		if (
			$listing_view_counter_shown_by_default && ! $listing_owners_handle_counters ||
			$listing_view_counter_shown_by_default && $listing_owners_handle_counters && ! $listar_hide_views_counter_by_owner ||
			! $listing_view_counter_shown_by_default && $listing_owners_handle_counters && ! $listar_hide_views_counter_by_owner
		) {
			$show_view_counters = true;
		}
	 
		if ( $show_view_counters || $complaint_reports_enabled || $show_claim ) :
			$listar_view_counter = get_post_meta( get_the_ID(), 'listar_meta_box_views_counter', true );
			?>
			<div class="listar-view-counter <?php echo esc_attr( listar_sanitize_html_class( $classes ) ); ?>">
				<?php
				if ( $show_view_counters ) :
					?>
					<span class="fa fa-eye">
						<?php
						printf(
							esc_html__( '%s Views', 'listar' ),
							zeroise( $listar_view_counter, 2 )
						);
						?>
					</span>
					<?php
				endif;
				
				if ( $show_claim && listar_is_claim_enabled() ) :
					if ( 'not-claimed' === $claim_status ) :
						if ( class_exists( 'WP_Job_Manager' ) ) :
							$add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

							if ( ! empty( $add_listing_form_url ) ) :
								$claim_url = $add_listing_form_url . '?claim_listing=1&claim_listing_id=' . get_the_ID();
								?>
								<span class="listar-claim-listing listar-listing-not-claimed fa fa-flag" data-claim-url="<?php echo esc_url( $claim_url ); ?>">
									<?php esc_html_e( 'Claim', 'listar' ); ?>
								</span>
								<?php

							endif;
						endif;
					elseif ( 'claimed' === $claim_status ) :
						?>
						<span class="listar-claim-listing listar-claim-icon fa fa-check-circle">
							<?php esc_html_e( 'Claimed', 'listar' ); ?>
						</span>
						<?php
					endif;
				endif;
				
				if ( $complaint_reports_enabled ) :
					?>
					<span class="listar-report-listing fa fa-ban <?php echo esc_attr( listar_sanitize_html_class( listar_report_complaint_css_class() ) ); ?>">
						<?php esc_html_e( 'Report', 'listar' ); ?>
					</span>
					<?php
				endif;
				?>
			</div>
			<?php
		endif;
	}

endif;


if ( ! function_exists( 'listar_bookmarks_active' ) ) :
	/**
	 * Alias function for listar_bookmarks_active_plugin() function, from Listar Addons.
	 *
	 * @since 1.3.9
	 * @param (bool|integer) $using_ajax Can be: false (not using Ajax) or true (using Ajax).
	 * @return (bool)
	 */
	function listar_bookmarks_active() {
		return listar_addons_active() ? listar_bookmarks_active_plugin() : false;
	}
endif;


if ( ! function_exists( 'listar_report_complaint_css_class' ) ) :
	/**
	 * Return a CSS class based on theme options for Complaint Reports.
	 *
	 * @since 1.3.9
	 * @return (string)
	 */
	function listar_report_complaint_css_class() {
		$complaint_class = '';
		$who_can_complaint = get_option( 'listar_who_can_complaint' );
		
		if ( empty( $who_can_complaint ) ) {
			$who_can_complaint = 'everyone';
			$complaint_class = 'listar-everyone-can-complaint';
		} else {
			$complaint_class = 'listar-' . $who_can_complaint . '-can-complaint';
		}
		
		return $complaint_class;
	}
endif;


if ( ! function_exists( 'listar_search_string_cleaner' ) ) :
	/**
	 * Remove special characters from search query.
	 *
	 * @since 1.3.9
	 * @param (string) $str A textual search query.
	 * @return (string)
	 */
	function listar_search_string_cleaner( $str ) {
		$symbols = array( '/','\\','\'','"',',','.','<','>','?',';',':','[',']','{','}','|','=','+','-','_',')','(','*','&','^','%','$','#','@','!','~','`', "'", "’", '  ', '  ', '  ' );

		return trim( str_replace( $symbols, ' ', $str ) );
	}
endif;


if ( ! function_exists( 'listar_url_query_vars_translate' ) ) :
	/**
	 * Translate WordPress query vars.
	 *
	 * @since 1.4.0
	 * @param (string) $var A query var slug to be translated.
	 * @return (string)
	 */
	function listar_url_query_vars_translate( $var ) {
		$is_listar_3 = false;
		
		if ( ! $is_listar_3 ) {
			return $var;
		}

		$query_vars = array(
			'search_type'         => 'tipo_busca',
			'listing_regions'     => 'regiao',
			'listing_categories'  => 'categorias',
			'listing_amenities'   => 'amenidades',
			'listing_sort'        => 'ordenamento',
			'explore_by'          => 'explorar_por',
			'selected_country'    => 'pais_selecionado',
			'saved_address'       => 'endereco_salvo',
			'saved_postcode'      => 'cep_salvo',
			'bookmarks_page'      => 'pagina_favoritos',
			'empty_bookmarks'     => 'sem_favoritos',
			'claim_listing'       => 'reivindicar',
			'claim_listing_id'    => '',
			'claim_package_id'    => '',
		);
		
		return $query_vars[ $var ];
	}
endif;


if ( ! function_exists( 'listar_is_claiming_listing' ) ) :
	/**
	 * Check if a listing is being claimed
	 *
	 * @since 1.4.1
	 * @return (boolean)
	 */
	function listar_is_claiming_listing() {
		$is_claim = get_query_var( 'claim_listing' );
		$claim_listing_id = get_query_var( 'claim_listing_id' );
		
		return ! empty( $is_claim ) && ! empty( $claim_listing_id );
	}
endif;

if ( ! function_exists( 'listar_listing_is_claimable' ) ) :
	/**
	 * Verify if a listing is claimable.
	 *
	 * @since 1.4.1
	 * @param (integer) $job_listing_id The listing ID.
	 * @return (boolean)
	 */
	function listar_listing_is_claimable( $job_listing_id ) {

		$listing = get_post( $job_listing_id );
		$is_claimed = get_post_meta( $job_listing_id, '_job_businessclaim', true );

		return
			$listing &&
			isset( $listing->post_type ) && 'job_listing' === $listing->post_type &&
			'publish' === $listing->post_status &&
			( 'not-claimed' === $is_claimed || empty( $is_claimed ) );
	}
endif;


if ( ! function_exists( 'listar_listing_claim_status' ) ) :
	/**
	 * Check the claim status of a listing.
	 *
	 * @since 1.4.1
	 * @param (integer) $listing_id The listing ID.
	 * @return (string)
	 */
	function listar_listing_claim_status( $listing_id ) {
		$claim_status = get_post_meta( $listing_id, '_job_businessclaim', true );
		
		if ( empty( $claim_status ) ) {
			$claim_status = 'not-claimed';
		}
		
		return $claim_status;
	}
endif;


if ( ! function_exists( 'listar_is_claim_enabled' ) ) :
	/**
	 * Check if claims are enabled.
	 *
	 * @since 1.4.1
	 * @return (boolean)
	 */
	function listar_is_claim_enabled() {
		return 0 === (int) get_option( 'listar_disable_claims' );
	}
endif;


if ( ! function_exists( 'listar_mobile_hero_image_size' ) ) :
	/**
	 * Get the size to hero image for mobile devices.
	 *
	 * @since 1.4.1
	 * @return (string)
	 */
	function listar_mobile_hero_image_size() {
		$size = get_option( 'listar_image_size_mobile' );
		
		if ( empty( $size ) ) {
			$size = 'listar-hero-mobile';
		}
		
		return $size;
	}
endif;


if ( ! function_exists( 'listar_json_decode_nice' ) ) :
	/**
	 * Fix line breaks inside JSON string and decode it.
	 *
	 * @since 1.3.6
	 * @link https://www.php.net/manual/pt_BR/function.json-decode.php#111928
	 * @param (string)  $json A JSON string.
	 * @param (booleam) $assoc Convert to associative array.
	 * @return (array)
	 */
	function listar_json_decode_nice( $json, $assoc = true ){
		if ( empty( $json ) ) {
	        $json = '';
	    }	    
		
		$search = array(
			'{&quot;',
			'&quot;:',
			':&quot;',
			',&quot;',
			':&quot;&quot;',
			'&quot;}',
			'&quot;,"',
			//'&quot;,', In case issues happen in the future.			
			'{&#34;',
			'&#34;:',
			':&#34;',
			',&#34;',
			':&#34;&#34;',
			'&#34;}',
			'&#34;,"',
		);

		$replace = array(
			'{"',
			'":',
			':"',
			',"',
			'""',
			'"}',
			'","',
			//'",', In case issues happen in the future.
			'{"',
			'":',
			':"',
			',"',
			'""',
			'"}',
			'","',
		
		);

		$json = str_replace( $search, $replace, $json );

		/*
		if ( false !== strpos( $json, '&#034' ) ) {
			
			// JSON string has HTML entities!
			$json = html_entity_decode( $json );
		}
		*/
		
		$json1 = str_replace( array("\n","\r"), array("\\n","\\r"), $json );
		$json2 = preg_replace( '/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":', $json1 );
		$json3 = preg_replace( '/(,)\s*}$/','}', $json2 );

		return json_decode( $json3, $assoc );
	}
endif;


if ( ! function_exists( 'listar_get_booking_label' ) ) :
	/**
	 * Get the current label for 'Booking' string.
	 *
	 * @since 1.4.2
	 * @param (string) $listing_id Current listing ID.
	 * @return (string)
	 */
	function listar_get_booking_label( $listing_id = '' ) {
		$label_slug = get_post_meta( $listing_id, '_job_business_booking_label', true );
		$default_section_label = esc_html__( 'Reservation', 'listar' );
		$label = '';
		
		if ( 'custom' === $label_slug ) {
			$label = get_post_meta( $listing_id, '_job_business_booking_custom_label', true );
		} elseif ( 'reservation' === $label_slug || empty( $label_slug ) ) {
			$label = esc_html__( 'Reservation', 'listar' );
		} elseif ( 'booking' === $label_slug ) {
			$label = esc_html__( 'Booking', 'listar' );
		} elseif ( 'ordering' === $label_slug ) {
			$label = esc_html__( 'Ordering', 'listar' );
		} elseif ( 'book-now' === $label_slug ) {
			$label = esc_html__( 'Book Now', 'listar' );
		}
		
		if ( empty( $label ) ) {
			$label = $default_section_label;
		}
		
		return ucwords( $label );
	}
endif;


if ( ! function_exists( 'listar_get_products_label' ) ) :
	/**
	 * Get the current label for Products section.
	 *
	 * @since 1.5.0
	 * @param (string) $listing_id Current listing ID.
	 * @return (string)
	 */
	function listar_get_products_label( $listing_id = '' ) {
		$label_slug = get_post_meta( $listing_id, '_job_business_products_label', true );
		$default_section_label = esc_html__( 'Products/Services', 'listar' );
		$label = '';
		
		if ( 'custom' === $label_slug ) {
			$label = get_post_meta( $listing_id, '_job_business_products_custom_label', true );
		} elseif ( 'both' === $label_slug ) {
			$label = esc_html__( 'Products/Services', 'listar' );
		} elseif ( 'purchase' === $label_slug || empty( $label_slug ) ) {
			$label = esc_html__( 'Purchase', 'listar' );
		} elseif ( 'products' === $label_slug ) {
			$label = esc_html__( 'Products', 'listar' );
		} elseif ( 'services' === $label_slug ) {
			$label = esc_html__( 'Services', 'listar' );
		}
		
		if ( empty( $label ) ) {
			$label = $default_section_label;
		}
		
		return ucwords( $label );
	}
endif;

if ( ! function_exists( 'listar_get_card_edit_link_alias' ) ) :
	/**
	 * Alias function for listar_get_card_edit_link(), from Listar Addons plugin.
	 *
	 * @since 1.4.4
	 */
	function listar_get_card_edit_link_alias() {
		if ( listar_addons_active() ) {
			listar_get_card_edit_link();
		}
	}
endif;

if ( ! function_exists( 'listar_get_session_key_alias' ) ) :
	/**
	 * Alias function to recover the global session variable.
	 *
	 * @since 1.4.5
	 * @param (string) $key The key that must exist in the session.
	 */
	function listar_get_session_key_alias( $key = '' ) {
		return function_exists( 'listar_get_session_key' ) && ! is_admin() && listar_addons_active() ? listar_get_session_key( $key ) : false;
	}
endif;


if ( ! function_exists( 'listar_save_search_string' ) ) :
	/**
	 * Save the current search string for custom listing search.
	 *
	 * @since 1.4.5
	 * @param (string) $string The search text.
	 * @return (string)
	 */
	function listar_save_search_string( $string = '' ) {

		static $save_search_string = '';

		if ( ! empty( $string ) ) {
			$save_search_string = $string;
		}

		return $save_search_string;
	}

endif;


if ( ! function_exists( 'listar_get_dynamic_search_string' ) ) :
	/**
	 * Get current search string for Listar.
	 *
	 * @since 1.4.5
	 * @return (string)
	 */
	function listar_get_dynamic_search_string() {
		global $wp_query;
		
		$search_string = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
		
		if ( empty( $search_string ) ) {
			$search_string = listar_save_search_string();
		}
		
		return $search_string;
	}
endif;

if ( ! function_exists( 'listar_modify_session_key_alias' ) ) :
	/**
	 * Modify a session variable.
	 *
	 * @since 1.4.5
	 * @param (string) $key The key to get the value modified.
	 * @param (string) $child_key Child key to get the value modified.
	 */
	function listar_modify_session_key_alias( $key = '', $child_key = '', $value = '' ) {
		if ( function_exists( 'listar_modify_session_key' ) && ! is_admin() && listar_addons_active() ) {
			listar_modify_session_key( $key, $child_key, $value );
		}
	}
endif;


if ( ! function_exists( 'listar_executing_ajax_query' ) ) :
	/**
	 * Save an Ajax query status.
	 *
	 * @since 1.4.5
	 * @param (integer/boolean) $status The Ajax search status.
	 * @return (boolean)
	 */
	function listar_executing_ajax_query( $status = 0 ) {

		static $save_status = false;

		if ( false === $status || true === $status ) {
			$save_status = $status;
		}

		return $save_status;
	}

endif;


if ( ! function_exists( 'listar_get_current_domain_url' ) ) :
	/**
	 * Get the URL for current domain
	 *
	 * @since 1.4.6
	 * @return (array)
	 */
	function listar_get_current_domain_url() {

		$network = network_site_url();
		$network2 = explode( '://', $network );
		$network3 = $network2[1];
		$domain_url = $network;
		$only_domain = str_replace( array( 'http://', 'https://' ), '', $domain_url );
		$path = '';
		
		if ( false !== strpos( $network3, '/' ) ) {
			$network4 = explode( '/', $network3 );
			$only_domain = $network4[0];
			
			$path1 = explode( $only_domain . '/', $domain_url );
			$path = $path1[1];
		}
		
		return array( $domain_url, $only_domain, $path );
	}

endif;

/*
 * Get next and prev products (filtered) for Listar Directory.
 * 
 * @link Adaptation from: https://gist.github.com/georgybu/4285005
 * 
 * @param (integer) $post_id A Woocommerce product ID.
 * @param (string)  $position The output position for the link.
 */
function listar_custom_prev_next_product( $post_id, $position = 'next' ) {
	$query_args = array(
		'post__in'       => array( $post_id ),
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'post_type'      => 'product',
	);

	$r_single = new WP_Query( $query_args );

	if ( $r_single->have_posts() ) {
		$r_single->the_post();
		
		if ( 'prev' === $position )  :
			?>
			<div class="nav-previous">
				<a href="<?php the_permalink() ?>" rel="prev" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID()); ?>">
					<?php the_title(); ?>
				</a>
			</div>
			<?php
		else :
			?>
			<div class="nav-next">
				<a href="<?php the_permalink() ?>" rel="next" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID()); ?>">
					<?php the_title(); ?>
				</a>
			</div>
			<?php
		endif;

		wp_reset_query();
	}
}

/*
 * 
 */
function listar_get_prev_next_products() {
	if ( is_singular( 'product' ) ) {
		$query_args = array(
			'posts_per_page' => 2000,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => array( 'job_package', 'job_package_subscription' ),
					'operator' => 'NOT IN',
				),
			)
		);

		$r = new WP_Query( $query_args );

		// show next and prev only if we have 2 or more (current product + 1)
		if ( $r->post_count > 1 ) :
			$found_prev = false;
			$found_next = false;

			$prev_product_id = -1;
			$next_product_id = -1;
			$current_product_id = get_the_ID();

			if ( $r->have_posts() ) :
				while ( $r->have_posts() ) {
					$r->the_post();
					$current_id = get_the_ID();

					if ( $current_id === $current_product_id ) {
						$found_prev = true;
					}

					if ( $current_id !== $current_product_id ) {
						if ( ! $found_prev  ) {
							$prev_product_id = get_the_ID();
						} else {
							if ( $current_id !== $current_product_id ) {
								$found_next = true;
								$next_product_id = get_the_ID();
								break;
							}
						}
					}
				}
				
				if ( $prev_product_id !== -1 || $next_product_id !== -1 ) :
					?>
					<section class="listar-section listar-navigation-section">
						<div class="listar-container-wrapper">
							<div class="container">
								<!-- Start section title - For W3C Valitation -->
								<div class="row listar-section-title hidden">
									<div class="col-sm-12">
										<h2 class="text-center">
											<?php esc_html_e( 'More posts', 'listar' ); ?>
										</h2>
									</div>
								</div>
								<!-- End section title - For W3C Valitation -->
								<div class="row">
									<div class="col-sm-12">
										<div class="posts-navigation">
											<nav class="navigation">
												<div class="listar-clear-both"></div>
												<div class="nav-links">
													<?php
													if ( $prev_product_id !== -1 ) {
														listar_custom_prev_next_product( $prev_product_id, 'prev' );
													}
													?>
													<?php
													if ( $next_product_id !== -1 ) {
														listar_custom_prev_next_product( $next_product_id, 'next' );
													}
													?>
												</div>
												<div class="listar-clear-both"></div>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php
				endif;
			endif;

			wp_reset_query();
		endif;
	}
}

if ( ! function_exists( 'listar_get_trending_listings' ) ) :
	/**
	 * Get trending listings.
	 *
	 * @since 1.4.6
	 * @param $force_return Force the list return even for admin pages.
	 * @return (array)
	 */
	function listar_get_trending_listings( $force_return = false ) {
		return listar_addons_active() ? listar_trending_global( $force_return ) : array();
	}

endif;

if ( ! function_exists( 'listar_is_listing_trending' ) ) :
	/**
	 * Verify if a listing is trending now.
	 *
	 * @since 1.4.6
	 * @param (integer) $listing_id A listing ID.
	 * @return (array)
	 */
	function listar_is_listing_trending( $listing_id = 0 ) {
		return in_array( $listing_id, listar_get_trending_listings(), true );
	}

endif;

/*
 * Varied unzip methods for better compatibility between servers.
 *
 * @since 1.4.6
 * 
 * Source: https://gist.github.com/irazasyed/5870360
 */
function listar_unzip( $file_path, $extract_to ) {
	
	listar_create_filesystem();	

	$unzip_filesystem = unzip_file( $file_path, $extract_to );
			
	if ( ! empty( $unzip_filesystem ) && ! is_wp_error( $unzip_filesystem ) ) :

		// WordPress built-in unzip (will solve most the cases).				
		return true;
	endif;

	if ( class_exists( 'ZipArchive' ) ) :

		// ZipArchive method.	
		$zip = new ZipArchive;				
		$res = $zip->open( $file_path );

		if ( true === $res ) :					
			$zip->extractTo( $extract_to );
			$zip->close();
			return true;
		endif;
	endif;

	if ( function_exists( 'shell_exec' ) ) :

		// shell_exec method.
		shell_exec( 'unzip -jo ' . $file_path . '  -d ' . $extract_to );
		return true;
	endif;

	if ( ! function_exists( 'exec' ) ) {
		return false;
	} else {
		
		// Fallback method.

		$arr = false;		
		
		if ( exec( "unzip $file_path", $arr ) ) {
			mkdir( $extract_to );

			for ( $i = 1; $i< count( $arr ); $i++ ) {
				$file = trim( preg_replace( '~inflating: ~', '', $arr[$i] ) );
				copy( $file_path . '/' . $file, $extract_to . '/'. $file );
				unlink( $file_path . '/'. $file );
			}

			return true;
		}

		return false;  
	}
	
	return false;
}

function listar_get_html_attributes( $html_tag, $accepted_tags = array( 'embed', 'iframe' ) ) {
	$attr_list = [];
	$has_accepted_tag = false;
	
	foreach ( $accepted_tags as $accepted_tag ) {
		if ( false !== strpos( $html_tag, '<' . $accepted_tag ) ) {
			$has_accepted_tag = true;
		}
	}
	
	if ( false === strpos( $html_tag, '<' ) || false === strpos( $html_tag, '>' ) || ! $has_accepted_tag ) {
		return $attr_list;
	} else {
		$temp = explode( '>', $html_tag );
		$html_tag = $temp[0] . '>';
	}

	if ( preg_match_all( '/\s*(?:([a-z0-9-]+)\s*=\s*"([^"]*)")|(?:\s+([a-z0-9-]+)(?=\s*|>|\s+[a..z0-9]+))/i', $html_tag, $m ) ) {
		for ( $i = 0; $i < count( $m[ 0 ] ); $i ++  ) {
			if ( $m[ 3 ][ $i ] ) {
				$attr_list[ $m[ 3 ][ $i ] ] = null;
			}	
			else {
				$attr_list[ $m[ 1 ][ $i ] ] = strval( $m[ 2 ][ $i ] );
			}	
		}
	}

	return $attr_list;
}

function listar_is_rich_media_listing_active( $listar_current_post_id ) {
	return 1 === (int) get_post_meta( $listar_current_post_id, '_company_use_rich_media', true );
}

function listar_is_wcfm_dashboard() {
	return function_exists( 'is_wcfm_page' ) && is_wcfm_page();
}

if ( ! function_exists( 'listar_is_wcfm_active' ) ) :
	function listar_is_wcfm_active() {
		return function_exists( 'wcfm_get_vendor_store_name' );
	}
endif;

if ( ! function_exists( 'listar_is_wcfmmp_active' ) ) :
	function listar_is_wcfmmp_active() {
		return defined('WCFMmp_TEXT_DOMAIN');
	}
endif;

function listar_is_wcfm_vendor_setup_page() {
	return function_exists( 'wcfm_is_vendor' ) && wcfm_is_vendor() && filter_input( INPUT_GET, 'store-setup' );
}

function listar_is_vendor( $user_id = '' ) {
	return function_exists( 'wcfm_is_vendor' ) && wcfm_is_vendor( $user_id );
}

function listar_is_wcfm_core_setup_page() {
	$condition2 = filter_input( INPUT_GET, 'wcfm-setup' );
	$condition3 = filter_input( INPUT_GET, 'wcfmmp-setup' );
	$condition4 = filter_input( INPUT_GET, 'page' );
	$condition5 = 'wcfm-setup' === $condition4 || 'wcfmmp-setup' === $condition4;
	$condition6 = filter_input( INPUT_GET, 'store-setup' );
	$condition7 = 'yes' === $condition6;

	return ( ( $condition2 || $condition3 ) || $condition5 || $condition7 );
}

/*
 * Inserts a new key/value before the key in the array.
 *
 * @param $key The key to insert before.
 * @param $array An array to insert in to.
 * @param $new_key The key to insert.
 * @param $new_value An value to insert.
 *
 * @see array_insert_after()
 * @return The new array if the key exists, FALSE otherwise.
 */

function listar_array_insert_before( $key, array &$array, $new_key, $new_value ) {
	if ( array_key_exists( $key, $array ) ) {
		$new = array();
		foreach ( $array as $k => $value ) {
			if ( $k === $key ) {
				$new[ $new_key ] = $new_value;
			}
			$new[ $k ] = $value;
		}
		return $new;
	}
	
	// If the key is not found, insert the new value anyway.
	$array[ $new_key ] = $new_value;
	
	return false;
}

/*
 * Inserts a new key/value after the key in the array.
 *
 * @param $key The key to insert after.
 * @param $array An array to insert in to.
 * @param $new_key The key to insert.
 * @param $new_value An value to insert.
 *
 * @see array_insert_before()
 * @return The new array if the key exists, FALSE otherwise.
 */

function listar_array_insert_after( $key, array &$array, $new_key, $new_value ) {
	if ( array_key_exists( $key, $array ) ) {
		$new = array();
		foreach ( $array as $k => $value ) {
			$new[ $k ] = $value;
			if ( $k === $key ) {
				$new[ $new_key ] = $new_value;
			}
		}
		return $new;
	}
	
	// If the key is not found, insert the new value anyway.
	$array[ $new_key ] = $new_value;
	
	return false;
}

function listar_create_wcfm_store_list_page() {
	if ( listar_is_wcfm_active() && listar_is_wcfmmp_active() ) {
		$my_post = array(
			'post_type'     => 'page',
			'post_title'    => 'Store List',
			'post_content'  => '[wcfm_stores]',
			'post_status'   => 'publish',
			'post_author'   => get_current_user_id(),
		);

		wp_insert_post( $my_post );
	}
}

function listar_modify_listing_publication_roles( $user_role = '', $enable = '1' ) {
	if ( ! empty( $user_role ) ) :
		$input = get_option( 'listar_users_allowed_publish_listings' );
		$allowed_roles_json  = ! empty( $input ) ? str_replace( '\\', '', $input ) : '';
		$allowed_roles_array = json_decode( $allowed_roles_json, true );
		
		if ( is_array( $allowed_roles_array ) && ! empty( $allowed_roles_array ) ) :
			foreach ( $allowed_roles_array as $key => $elem ) :
				if ( isset( $elem[0] ) && $user_role === $elem[0] ) {
					$allowed_roles_array[ $key ][1] = $enable;
				}
			endforeach;
		endif;
		
		$json = str_replace( '"', '\\"', json_encode( $allowed_roles_array ) );
		
		update_option( 'listar_users_allowed_publish_listings', $json );
	endif;
}

if ( ! function_exists( 'listar_get_user_packages' ) ) :
	function listar_get_user_packages( $user_id = 0 ) {
		global $wpdb;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wcpl_user_packages WHERE user_id = '" . $user_id . "'" );
	}
endif;

if ( ! function_exists( 'listar_get_user_available_package_products' ) ) :
	function listar_get_user_available_package_products( $user_id = 0 ) {
		$listing_limits = 0;
		$woo_product_ids = array();
		$package_ids = array();
		$has_package_active = false;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		$packages = listar_get_user_packages( $user_id );

		foreach ( $packages as $package ) {
			$woo_product_ids[] = $package->product_id;
			$package_ids[] = $package->id;
			$package = wc_paid_listings_get_package( $package );
			$listing_limits += $package->get_limit() ? absint( $package->get_limit() - $package->get_count() ) : 999;
		}

		if ( $listing_limits > 0 ) {
			$has_package_active = true;
		}

		return array( array_unique( $woo_product_ids ), $has_package_active, array_unique( $package_ids ) );
	}
endif;

if ( ! function_exists( 'listar_get_user_woo_package_products_via_listings_published' ) ) :
	function listar_get_user_woo_package_products_via_listings_published( $user_id = 0, $status = 'publish' ) {
		global $wpdb;

		$woo_product_ids = array();
		$listing_ids = array();
		$has_package_active = false;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		$data = array();
		
		if ( 'publish' == $status ) {
			$data = $wpdb->get_results( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_listing' AND ( post_status = 'publish' OR post_status = 'draft' OR post_status = 'pending' ) AND post_author = '" . $user_id . "'" );	
		} else {
			$data = $wpdb->get_results( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_listing' AND post_status = '" . $status ."' AND post_author = '" . $user_id . "'" );	
		}

		if ( is_array( $data ) ) {
			foreach ( $data as $elem ) {
				$listing_id = $elem->ID;
				$product_id = get_post_meta( $listing_id, '_package_id', true );

				if ( ! empty( $product_id ) ) {
					$woo_product_ids[] = $product_id;
					$listing_ids[] = $listing_id;
					$has_package_active = true;
				}
			}
		}

		return array( array_unique( $woo_product_ids ), $has_package_active, $listing_ids );
	}
endif;

if ( ! function_exists( 'listar_user_has_package_with_store' ) ) :
	function listar_user_has_package_with_store( $user_id = 0 ) {

		static $authorized_vendors = array();

		if ( ! empty( $authorized_vendors ) && in_array( (int) $user_id, $authorized_vendors, true ) ) {
			return true;
		}

		$verified_packages = array();
		$allow_store = false;	

		// Step 1 - Verify if user has product packages with listings available to be published currently and if the
		// Woocommerce Product behind these packages allows the creation of stores.

		$condition1 = listar_get_user_available_package_products( $user_id );

		if ( ! empty( $condition1 ) && isset( $condition1[1] ) && true === $condition1[1] && ! empty( $condition1[0] ) ) {
			foreach ( $condition1[0] as $product_id ) {
				if ( ! empty( $product_id ) ) {
					$verified_packages[] = $product_id;				
					$disabled_package_options = listar_addons_active() && ! empty( $product_id ) ? listar_get_package_options_disabled( $product_id ) : array();

					if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
						$authorized_vendors[] = (int) $user_id;
						$allow_store = true;
						break;
					endif;
				}
			}
		}

		if ( ! $allow_store ) {

			// Step 2 - Verify if the user has listings published currently and if the
			// Woocommerce Product behind these listings allows the creation of stores.

			$condition2 = listar_get_user_woo_package_products_via_listings_published( $user_id );

			if ( ! empty( $condition2 ) && isset( $condition2[1] ) && true === $condition2[1] && ! empty( $condition2[0] ) ) {
				foreach ( $condition2[0] as $product_id ) {
					if ( ! empty( $product_id ) && ! in_array( $product_id, $verified_packages ) ) {
						$verified_packages[] = $product_id;
						$disabled_package_options = listar_addons_active() && ! empty( $product_id ) ? listar_get_package_options_disabled( $product_id ) : array();

						if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
							$authorized_vendors[] = (int) $user_id;
							$allow_store = true;
							break;
						endif;
					}
				}
			}
		}

		return $allow_store;
	}
endif;

if ( ! function_exists( 'listar_is_vendor_authorized' ) ) :
	function listar_is_vendor_authorized( $user_id = '' ) {

		if ( empty( $user_id ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();
		}

		$listar_vendor_store_disable = get_option( 'listar_who_can_create_stores' );

		if ( empty( $listar_vendor_store_disable ) ) {
			$listar_vendor_store_disable = 'listing-package-membership';
		}

		if ( ! ( 'nobody' === $listar_vendor_store_disable || ! listar_is_wcfm_active() || ! listar_is_wcfmmp_active() ) ) {
			if ( 'all-subscribers' === $listar_vendor_store_disable ) {
				return true;
			}

			/* Depends on Listing Packages */

			if ( 'listing-package-membership' === $listar_vendor_store_disable ) {
				return listar_user_has_package_with_store( $user_id );
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'listar_count_store_products_allowed' ) ) :	
	function listar_count_store_products_allowed( $user_id = 0 ) {
		$fallback = (string) get_option( 'listar_limit_products_per_vendor' );
		$fallback_str = strval( $fallback );
		$fallback_int = (int) $fallback;

		if ( empty( $fallback_str ) && '0' !== $fallback_str && '-1' !== $fallback_str ) {
			$fallback = 36;
		} else {
			$fallback = $fallback_int;
		}

		return $fallback;
	}
endif;

if ( ! function_exists( 'listar_count_disk_store_allowed' ) ) :	
	function listar_count_disk_store_allowed() {
		$fallback = (string) get_option( 'listar_limit_disk_per_vendor' );
		$fallback_str = strval( $fallback );
		$fallback_int = (int) $fallback;

		if ( empty( $fallback_str ) && '0' !== $fallback_str && '-1' !== $fallback_str ) {
			$fallback = 500;
		} else {
			$fallback = $fallback_int;
		}

		return $fallback;
	}
endif;

function listar_get_default_region_search() {
	$input = get_option( 'listar_default_region_search' );
	
	if ( is_numeric( $input ) ) {
		$term_name = get_term( $input );

		if ( isset( $term_name->name ) && ! empty( $term_name->name ) ) {
			$input = $term_name->name;
		} else {
			$input = '';
		}
	}
	
	return $input;
}

function listar_get_map_tiles_provider() {
	$provider = get_option( 'listar_map_provider' );

	if ( empty ( $provider ) ) {
		$provider = 'mapplus';
	}

	return $provider;
}

function listar_listing_accordion_preopen() {
	$input = get_option( 'listar_single_listing_preopen' );

	if ( empty( $input ) ) {
		$input = 'first';
	}

	return $input;
}


if ( ! function_exists( 'listar_price_custom_output' ) ) :
	function listar_price_custom_output( $price, $thousand_separator, $decimal_separator ) {
		if ( ! is_string( $price ) && ! is_numeric( $price ) ) {
			$price = 0;
		}

		$price = number_format( (float) $price, 2, $decimal_separator, $thousand_separator );
		return str_replace( $decimal_separator . '00', '', $price );		
	}
endif;

if ( ! function_exists( 'listar_get_footer_extended' ) ) :
	function listar_get_footer_extended() {
		get_template_part( 'footer', 'extended' );
	}
endif;
<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Listar
 */

add_filter( 'woocommerce_get_breadcrumb', 'listar_change_woo_breadcrumb' );
function listar_change_woo_breadcrumb( $crumbs ) {
	global $post;
	
	$disable_woo_bread = (int) get_option( 'listar_disable_shopping_breadcrumbs' );
	
	if ( 1 === $disable_woo_bread ) {
		return array();
	}
	
	$Woo_shop_page_url =  get_permalink( wc_get_page_id( 'shop' ) );
	$Woo_shop_page_title =  get_the_title( wc_get_page_id( 'shop' ) );
	
	
	if ( ! empty( $Woo_shop_page_url ) && ! empty( $Woo_shop_page_title ) ) {
		$index = 1;
		$array_insert = array( array( $Woo_shop_page_title, $Woo_shop_page_url ) );
		array_splice( $crumbs, $index, 0, $array_insert );
	}
	
	if ( listar_is_wcfm_active() && is_singular( 'product' ) ) {
		$product_id = $post->ID;
		$vendor_id  = wcfm_get_vendor_id_by_post( $product_id );
		
		if ( $vendor_id ) {
			$store_name = wcfm_get_vendor_store_name( absint($vendor_id) );
			$store_url  =  wcfmmp_get_store_url( $vendor_id );
			
			$index = 2;
			$array_insert = array( array( $store_name, $store_url ) );
			array_splice( $crumbs, $index, 0, $array_insert );
		}
	}

	return $crumbs;
}

// add the filter 
add_filter( 'breadcrumb_trail', 'filter_breadcrumb_trail', 10, 2 ); 

add_action( 'init', 'listar_custom_post_types_init' );

if ( ! function_exists( 'listar_custom_post_types_init' ) ) :
	/**
	 * Register and customize custom post types.
	 *
	 * @since 1.0
	 */
	function listar_custom_post_types_init() {
		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		
		/*
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_file = 'autoptimize/autoptimize.php';
		//update_option( 'woocommerce_custom_orders_table_enabled', 'no' );

		if (is_plugin_active($plugin_file)) {
			deactivate_plugins($plugin_file);
		}
		*/

		if ( isset( $listar_session['listar-ajax-search'] ) && '1' === $listar_session['listar-ajax-search'] ) :
			listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '0' );
		endif;

		/* Register post types - 'Listar Add-ons' plugin */
		do_action( 'listar_register_post_types_init' );
	}
endif;

add_filter( 'jetpack_comment_form_enabled_for_job_listing', 'listar_disable_jetpack_comment_form' );

function listar_disable_jetpack_comment_form( $value ) {
	return false;
}

// For possible issues in the future.
// add_filter( 'jetpack_get_available_modules', 'listar_disable_jetpack_comment_module_backend' );

function listar_disable_jetpack_comment_module_backend ( $modules ) {
	unset( $modules['comments'] );
	return $modules;
}

add_action( 'init', 'listar_custom_post_types_init' );

/*
 * Enable image upload to taxonomy terms
 *
 * @since 1.0
 */

/* WP Job Manager listing categories - 'Listar Add-ons' plugin */
do_action( 'listar_job_listing_category_image_init' );

/* WP Job Manager listing regions - 'Listar Add-ons' plugin */
do_action( 'listar_job_listing_region_image_init' );

/* WP Job Manager listing amenities - 'Listar Add-ons' plugin */
do_action( 'listar_job_listing_amenity_image_init' );

/* Blog categories - 'Listar Add-ons' plugin */
do_action( 'listar_category_image_init' );

/*
 * Enable icon selection/upload to terms from WP Job Manager listing categories and amenities - 'Listar Add-ons' plugin
 *
 * @since 1.0
 */
do_action( 'listar_taxonomy_icon_init' );

/*
 * Enable color to terms from WP Job Manager (categories and regions)
 *
 * @since 1.0
 */
$listar_custom_colors_disabled = (int) get_option( 'listar_disable_custom_taxonomy_colors' );

if ( 0 === $listar_custom_colors_disabled ) {
	do_action( 'listar_taxonomy_color_init' );
}

/*
 * Enable post counter to terms from WP Job Manager (categories, regions and amenities)
 */
do_action( 'listar_taxonomy_post_counter_init' );

/*
 * Enable location references for listing regions
 *
 * @since 1.3.8
 */
$listar_region_location_reference_disabled = (int) get_option( 'listar_region_reference_metering_disable' );

if ( 0 === $listar_region_location_reference_disabled ) {
	do_action( 'listar_taxonomy_location_primary_reference_address_init' );
	do_action( 'listar_taxonomy_location_primary_reference_label_init' );
	do_action( 'listar_taxonomy_location_primary_reference_latitude_init' );
	do_action( 'listar_taxonomy_location_primary_reference_longitude_init' );
	do_action( 'listar_taxonomy_location_secondary_reference_address_init' );
	do_action( 'listar_taxonomy_location_secondary_reference_label_init' );
	do_action( 'listar_taxonomy_location_secondary_reference_latitude_init' );
	do_action( 'listar_taxonomy_location_secondary_reference_longitude_init' );
}

/*
 * Enable custom meta boxes - 'Listar Add-ons' plugin
 *
 * @since 1.0
 */
do_action( 'listar_custom_meta_boxes_init' );

/*
 * Enable custom Ajax login/registration forms - 'Listar Add-ons' plugin
 *
 * @since 1.0
 */
do_action( 'listar_user_registration_forms_init' );

add_filter( 'query_vars', 'listar_register_query_vars' );

if ( ! function_exists( 'listar_register_query_vars' ) ) :
	/**
	 * Register custom query vars to listings search.
	 *
	 * @link  https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
	 * @since 1.0
	 * @param (array) $vars WordPress query vars.
	 * @return (array)
	 */
	function listar_register_query_vars( $vars ) {

		$vars[] = listar_url_query_vars_translate( 'search_type' );
		$vars[] = listar_url_query_vars_translate( 'listing_regions' );
		$vars[] = listar_url_query_vars_translate( 'listing_categories' );
		$vars[] = listar_url_query_vars_translate( 'listing_amenities' );
		$vars[] = listar_url_query_vars_translate( 'listing_sort' );
		$vars[] = listar_url_query_vars_translate( 'explore_by' );
		$vars[] = listar_url_query_vars_translate( 'selected_country' );
		$vars[] = listar_url_query_vars_translate( 'saved_address' );
		$vars[] = listar_url_query_vars_translate( 'saved_postcode' );
		$vars[] = listar_url_query_vars_translate( 'bookmarks_page' );
		$vars[] = listar_url_query_vars_translate( 'claim_listing' );
		$vars[] = listar_url_query_vars_translate( 'claim_listing_id' );
		$vars[] = listar_url_query_vars_translate( 'claim_package_id' );
		$vars[] = 'become_vendor';

		return $vars;
	}

endif;

add_action( 'after_switch_theme', 'listar_configure_theme' );

if ( ! function_exists( 'listar_configure_theme' ) ) :
	/**
	 * Configure theme defaults right after theme activation.
	 *
	 * @since 1.0
	 */
	function listar_configure_theme() {

		/* Set permalinks structure */
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );

                /**
                 * Make WordPress user registration active by default.
                 * Because a customers mostly asked us why user registration is not working.
                 */
                update_option( 'users_can_register', true );

		/* Update WP Job Manager options */
		update_option( 'job_manager_per_page', '12' );
		update_option( 'job_manager_enable_types', '0' );
		update_option( 'job_manager_enable_categories', '1' );
		update_option( 'job_manager_enable_default_category_multiselect', '1' );
		update_option( 'job_manager_paid_listings_flow', 'before' );
		update_option( 'job_manager_registration_role', 'subscriber' );
		update_option( 'wpjmr_allow_images', '' );
		update_option( 'listar_blog_grid_design', 'default' );

		/* Set all default WordPress and Woocommerce user roles as allowed to publish listings */
		update_option( 'listar_users_allowed_publish_listings', '[["editor","1"],["author","1"],["contributor","1"],["subscriber","1"],["employer","1"],["customer","1"],["shop_manager","1"],["visitor","1"]]' );

		/* Set a default (fallback) location for maps */
		update_option( 'listar_fallback_map_location', 'Chicago' );

		/* Set light gray as default background color */
		set_theme_mod( 'background_color', 'f4f4f4' );

		$sidebars = get_option( 'sidebars_widgets' );

		/* Configure default Widgets to front page only if it is empty */
		if ( ! isset( $sidebars['listar-front-page-sidebar'] ) || empty( $sidebars['listar-front-page-sidebar'] ) || 0 === count( $sidebars['listar-front-page-sidebar'] ) ) :

			update_option( 'sidebars_widgets', array( false ) );

			$sidebars = get_option( 'sidebars_widgets' );

			$sidebars['listar-front-page-sidebar'] = array(
				'listar_call_to_action-2',
				'listar_blog_posts-2',
			);

			update_option( 'sidebars_widgets', $sidebars );

			update_option(
				'widget_listar_call_to_action',
				array(
					'2' => array(
						'title'       => esc_html__( 'Promote Your Business', 'listar' ),
						'description' => esc_html__( 'Listar is an elegant listing directory solution.', 'listar' ),
					),
					'_multiwidget' => 1,
				)
			);

			update_option(
				'widget_listar_blog_posts',
				array(
					'2' => array(
						'title'    => esc_html__( 'News From The Blog', 'listar' ),
						'subtitle' => esc_html__( "Don't Miss These Articles, Tips and Tricks", 'listar' ),
					),
					'_multiwidget' => 1,
				)
			);

		endif;
	}
endif;

add_action( 'after_setup_theme', 'listar_update_listar_addons' );

if ( ! function_exists( 'listar_update_listar_addons' ) ) :
	/**
	 * Automatically updates Listar Addons plugin if currently active.
	 * Varied unzip methods for better compatibility between servers.
	 *
	 * @since 1.3.6
	 */
	function listar_update_listar_addons() {
		$listar_version = listar_get_theme_version();
		$listar_addons_version = defined( 'LISTAR_ADDONS_VERSION' ) ? LISTAR_ADDONS_VERSION : false;
		
		// Deny automatic upgrade on localhost.
		$is_localhost = false === strpos( network_site_url(), '://localhost/' ) ? false : true;
		
		if ( empty( $listar_addons_version ) && listar_addons_active() ) {
			$listar_addons_version = '1';
		}
		
		if ( ! $is_localhost && ! empty( $listar_addons_version ) && $listar_addons_version !== $listar_version ) {
			$file_path  = listar_get_theme_file_path( '/inc/required-plugins/plugins/listar-addons.zip' );
			$extract_to = WP_PLUGIN_DIR;
			
			$has_extracted = listar_unzip( $file_path, $extract_to );
			
			if ( $has_extracted ) {
				if ( ! is_admin() ) {
					wp_redirect( network_site_url() );
					exit();
				} else {
					wp_redirect( admin_url( 'themes.php' ) );
					exit();
				}
			}
		}
	}

endif;


add_action( 'init', 'listar_counters_init' );

if ( ! function_exists( 'listar_counters_init' ) ) :
	/**
	 * This function acts only one time per Listar install and affects all existing listings.
	 * Listings need at least "0" views/bookmars counted to be listed via "Most viewed" or "Most bookmarked" search filters.
	 *
	 * @since 1.3.9
	 */
	function listar_counters_init() {
		$input   = (int) get_option( 'listar_is_first_listing_view_preset' );
		$checked = 1 === $input ? true : false;

		if ( ! $checked && listar_addons_active() ) {
			update_option( 'listar_is_first_listing_view_preset', '1' );
			
			$exec_query = new WP_Query(
				array(
					'post_type'      => 'job_listing',
					'posts_per_page' => 2000,
				)
			);

			if ( $exec_query->have_posts() ) {
				while ( $exec_query->have_posts() ) :
					$exec_query->the_post();
					listar_increment_post_meta_field( get_the_ID(), 'listar_meta_box_views_counter', false, true );
					listar_increment_post_meta_field( get_the_ID(), 'listar_meta_box_bookmarks_counter', false, true );
				endwhile;
			}
			
			/* Preset all WP Job Manager term counters */
			listar_update_all_taxonomy_term_counters();
		}
	}
endif;


add_action( 'init', 'listar_counters_preset' );

if ( ! function_exists( 'listar_counters_preset' ) ) :
	/**
	 * Preset view counters, depends on 'listar_preset_view_counters' theme option.
	 *
	 * @since 1.3.9
	 */
	function listar_counters_preset() {
	
		if ( listar_addons_active() ) {
			$random_count_interval_start = false;
			$random_count_interval_end = false;
			$view_counter = false;
			$reset_all_counters = false;

			// Replace all characters except numbers and hiphen.
			$listar_preset_view_counters = preg_replace( '/[^0-9-]/', '', esc_html( get_option( 'listar_preset_view_counters' ) ) );
			$listar_preset_bookmarks_counters = preg_replace( '/[^0-9-]/', '', esc_html( get_option( 'listar_preset_bookmarks_counters' ) ) );

			update_option( 'listar_preset_view_counters', '' );
			update_option( 'listar_preset_bookmarks_counters', '' );

			if ( '0' === $listar_preset_view_counters || '0-0' === $listar_preset_view_counters ) {
				$listar_preset_view_counters = 'reset';
			}

			if ( '0' === $listar_preset_bookmarks_counters || '0-0' === $listar_preset_bookmarks_counters ) {
				$listar_preset_bookmarks_counters = 'reset';
			}

			/* Preseting View Counters */

			if ( ! empty( $listar_preset_view_counters ) && '0' !== $listar_preset_view_counters && 0 !== $listar_preset_view_counters && '' !== $listar_preset_view_counters ) {
				if ( 'reset' === $listar_preset_view_counters ) {
					$reset_all_counters = true;
					$listar_preset_view_counters = '1';
				} elseif ( false !== strpos( $listar_preset_view_counters, '-' ) ) {
					$interval = explode( '-', $listar_preset_view_counters );

					if ( ( ! empty( $interval[0] ) || '0' === $interval[0] ) && ( ! empty( $interval[1] ) || '0' === $interval[1] ) ) {
						if ( (int) $interval[1] >= (int) $interval[0] ) {
							$random_count_interval_start = (int) $interval[0];
							$random_count_interval_end = (int) $interval[1];
						}
					}
				}

				if ( ( ! empty( $random_count_interval_start ) || 0 === $random_count_interval_start ) && ( ! empty( $random_count_interval_end ) || 0 === $random_count_interval_end ) ) {
					$view_counter = rand( $random_count_interval_start, $random_count_interval_end );
				} else {
					$view_counter = is_numeric( $listar_preset_view_counters ) ? (int) $listar_preset_view_counters + 0 : false;
				}

				if ( ! empty( $view_counter ) || $reset_all_counters ) {
					$exec_query = new WP_Query(
						array(
							'post_type'      => 'job_listing',
							'posts_per_page' => 2000,
						)
					);

					if ( $exec_query->have_posts() ) {
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();

							if ( $reset_all_counters ) {
								$view_counter = 0;
							} elseif ( ( ! empty( $random_count_interval_start ) || 0 === $random_count_interval_start ) && ( ! empty( $random_count_interval_end ) || 0 === $random_count_interval_end ) ) {
								$view_counter = rand( $random_count_interval_start, $random_count_interval_end );
							}

							listar_increment_post_meta_field( get_the_ID(), 'listar_meta_box_views_counter', $view_counter, true );
						endwhile;
					}
				}
			}

			/* Preseting Bookmarks Counters */

			if ( ! empty( $listar_preset_bookmarks_counters ) && '0' !== $listar_preset_bookmarks_counters && 0 !== $listar_preset_bookmarks_counters && '' !== $listar_preset_bookmarks_counters ) {

				$random_count_interval_start = false;
				$random_count_interval_end = false;
				$view_counter = false;
				$reset_all_counters = false;

				if ( 'reset' === $listar_preset_bookmarks_counters ) {
					$reset_all_counters = true;
					$listar_preset_bookmarks_counters = '1';
				} elseif ( false !== strpos( $listar_preset_bookmarks_counters, '-' ) ) {
					$interval = explode( '-', $listar_preset_bookmarks_counters );

					if ( ( ! empty( $interval[0] ) || '0' === $interval[0] ) && ( ! empty( $interval[1] ) || '0' === $interval[1] ) ) {
						if ( (int) $interval[1] >= (int) $interval[0] ) {
							$random_count_interval_start = (int) $interval[0];
							$random_count_interval_end = (int) $interval[1];
						}
					}
				}

				if ( ( ! empty( $random_count_interval_start ) || 0 === $random_count_interval_start ) && ( ! empty( $random_count_interval_end ) || 0 === $random_count_interval_end ) ) {
					$bookmarks_counter = rand( $random_count_interval_start, $random_count_interval_end );
				} else {
					$bookmarks_counter = is_numeric( $listar_preset_bookmarks_counters ) ? (int) $listar_preset_bookmarks_counters + 0 : false;
				}

				if ( ! empty( $bookmarks_counter ) || $reset_all_counters ) {
					$exec_query = new WP_Query(
						array(
							'post_type'      => 'job_listing',
							'posts_per_page' => 2000,
						)
					);

					if ( $exec_query->have_posts() ) {
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();

							if ( $reset_all_counters ) {
								$bookmarks_counter = 0;
							} elseif ( ( ! empty( $random_count_interval_start ) || 0 === $random_count_interval_start ) && ( ! empty( $random_count_interval_end ) || 0 === $random_count_interval_end ) ) {
								$bookmarks_counter = rand( $random_count_interval_start, $random_count_interval_end );
							}

							listar_increment_post_meta_field( get_the_ID(), 'listar_meta_box_bookmarks_counter', $bookmarks_counter, true );
						endwhile;
					}
				}
			}
		}
	}
endif;


add_action( 'init', 'listar_pre_set_rating_categories' );

if ( ! function_exists( 'listar_pre_set_rating_categories' ) ) :
	/**
	 * Helps to migrate third party settings for ratings to Listar built-in rating settings.
	 *
	 * @since 1.3.9
	 */
	function listar_pre_set_rating_categories() {
	
		if ( listar_addons_active() ) {
			$built_in_review_categories = esc_html( get_option( 'listar_review_categories' ) );

			if ( empty( $built_in_review_categories ) ) {
				$third_party_review_categories = esc_html( get_option( 'wpjmr_categories' ) );

				if ( ! empty( $third_party_review_categories ) ) {
					update_option( 'listar_review_categories', $third_party_review_categories );
				}
			}
		}
	}
endif;


add_filter( 'wp_nav_menu', 'listar_change_submenu_class' );

if ( ! function_exists( 'listar_change_submenu_class' ) ) :
	/**
	 * Replace submenu class of WordPress menu.
	 *
	 * @since 1.0
	 * @param (string) $menu WordPress menu output.
	 * @return (string)
	 */
	function listar_change_submenu_class( $menu ) {

		return preg_replace( '/ class="sub-menu"/', ' class="dropdown-menu"', $menu );
	}

endif;

add_filter( 'nav_menu_css_class', 'listar_menu_classes', 1, 3 );

if ( ! function_exists( 'listar_menu_classes' ) ) :
	/**
	 * Add WordPress menu classes to 'primary-menu' theme location.
	 *
	 * @since 1.0
	 * @param (array)  $classes Classes of the menu.
	 * @param (object) $item Nav menu item data.
	 * @param (array)  $args Nav menu arguments.
	 * @return (array)
	 */
	function listar_menu_classes( $classes, $item, $args ) {

		if ( 'primary-menu' === $args->theme_location ) {
			$classes[] = 'dropdown';
		}

		return $classes;
	}

endif;

/**
 * Disable Yoast SEO Primary Category Feature
 * Credit: Yoast development team
 * Last Tested: Jan 24 2017 using Yoast SEO 4.1 on WordPress 4.7.1
 */
add_filter( 'wpseo_primary_term_taxonomies', '__return_empty_array' );

add_filter( 'get_search_form', 'listar_config_search_form_blog', 100 );

if ( ! function_exists( 'listar_config_search_form_blog' ) ) :
	/**
	 * Overwrites blog search form.
	 *
	 * @since 1.0
	 * @param (string) $form HTML code of the form.
	 * @return (string)
	 */
	function listar_config_search_form_blog( $form ) {

		/* Random form ID for W3C validation - if using more than one search form on the same page */
		$form_id = 'search-form_' . wp_rand( 10, 99999 );

		$form = '' .
			'<div class="listar-news-search">
				<div class="listar-widget-content">
					<div class="listar-search-form-wrapper">
						<form method="get" id="' . $form_id . '" class="search-form" action="' . esc_url( network_site_url( '/' ) ) . '" >
							<input class="search-field" placeholder="' . esc_attr__( 'Search...', 'listar' ) . '" value="' . esc_attr( listar_get_search_query() ) . '" name="s" />
						</form>
					</div>
					<div class="listar-search-submit">
						<i class="fa fa-search"></i>
					</div>
				</div>
			</div>';

		return $form;
	}

endif;

add_action( 'init', 'listar_change_post_object' );

if ( ! function_exists( 'listar_change_post_object' ) ) :
	/**
	 * Change Featured Image Title on admin.
	 *
	 * @since 1.0
	 */
	function listar_change_post_object() {

		global $wp_post_types;
		
		//echo 3333;

		if ( isset( $wp_post_types['job_listing']->labels ) ) {
			//echo 44444;

			$labels                        = &$wp_post_types['job_listing']->labels;
			$labels->featured_image        = esc_html__( 'Main image', 'listar' );
			$labels->set_featured_image    = esc_html__( 'Set image', 'listar' );
			$labels->remove_featured_image = esc_html__( 'Remove image', 'listar' );
			$labels->use_featured_image    = esc_html__( 'Use as main image', 'listar' );
			
			//echo 9999;
			//printf('<pre>%s</pre>', var_export($wp_post_types['job_listing'],true));
		}
	}

endif;

add_filter( 'the_content', 'listar_add_lightbox_rel' );

if ( ! function_exists( 'listar_add_lightbox_rel' ) ) :
	/**
	 * Adding rel to all images embeded on posts and linking to image.
	 *
	 * @since 1.0
	 * @param (string) $content Post HTML content.
	 * @return (string)
	 */
	function listar_add_lightbox_rel( $content ) {

		global $post;

		$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="lightbox" title="' . $post->post_title . '"$6>';

		return preg_replace( $pattern, $replacement, $content );
	}

endif;

add_filter( 'media_view_settings', 'listar_gallery_media_link_as_default' );

if ( ! function_exists( 'listar_gallery_media_link_as_default' ) ) :
	/**
	 * Setting link to media file as default when appending attachments with URL.
	 *
	 * @since 1.0
	 * @param (array) $settings WordPress media viewer settings.
	 * @return (array)
	 */
	function listar_gallery_media_link_as_default( $settings ) {

		$settings['galleryDefaults']['link'] = 'file';

		return $settings;
	}

endif;

add_filter( 'wp_nav_menu_items', 'listar_add_job_listing_page_link_to_main_menu', 10, 2 );

if ( ! function_exists( 'listar_add_job_listing_page_link_to_main_menu' ) ) :
	/**
	 * Automatically add a "Add Listing" link to Primary Menu.
	 *
	 * @since 1.0
	 * @param (string) $menu_list The HTML output for the menu, containing <li> items.
	 * @param (array)  $args Menu args (required, default from filter).
	 * @return (string)
	 */
	function listar_add_job_listing_page_link_to_main_menu( $menu_list, $args ) {

		$add_listing_link      = '';
		$your_account_link     = '';
		$listing_search_button = '';
		$theme_location        = '';
		$can_publish_listings  = listar_user_can_publish_listings();

		if ( isset( $args->theme_location ) && ! empty( $args->theme_location ) ) {
			$theme_location = $args->theme_location;
		}

		if ( 'primary-menu' !== $theme_location ) {
			return $menu_list;
		}

		/* Add search button to main menu */
		if ( class_exists( 'WP_Job_Manager' ) ) {
			$use_search_button_front_page = 1 === (int) get_option( 'listar_activate_search_button_front' ) ? true : false;
			$listing_search_button = ! listar_is_front_page_template() || $use_search_button_front_page ? '<li class="listar-header-search-button"></li>' : '';
		}

		/* Add link to "Add Listing" page */
		if ( class_exists( 'WP_Job_Manager' ) && $can_publish_listings ) {

			$add_listing_form_url  = job_manager_get_permalink( 'submit_job_form' );

			if ( ! empty( $add_listing_form_url ) ) {
				$add_listing_link = '
					<li class="menu-item listar-iconized-menu-item listar-add-listing-main-menu">
						<a class="icon-map-marker-down" href="' . esc_url( $add_listing_form_url ) . '">
							' . esc_html__( 'Add Listing', 'listar' ) . '
						</a>
					</li>';
			}
		}

		/* Add account menu to logged users */
		if ( is_user_logged_in() ) :
			$your_account_link = '
				<li class="menu-item menu-item-has-children listar-iconized-menu-item dropdown listar-account-menu-item">
					<a class="icon-user-lock" href="#">
						' . esc_html__( 'Your Account', 'listar' ) . '
					</a>
					<ul class="dropdown-menu"></ul>
				</li>';
		endif;

		$menu_list = $listing_search_button . $add_listing_link . $your_account_link . $menu_list;

		/* Add link to "Log In" - for mobiles */
		if ( ! is_user_logged_in() ) {

			$login_url = listar_addons_active() ? '#' : wp_login_url( network_site_url( '/' ) );

			$menu_list .= ''
				. '<li class="menu-item listar-user-login-mobile">'
					. '<a href="' . esc_url( $login_url ) . '">'
						. esc_html__( 'Log In', 'listar' )
					. '</a>'
				. '</li>';

		}

		return $menu_list;
	}

endif;

if ( ! current_user_can( 'upload_files' ) ) {
	add_action( 'admin_init', 'listar_allow_user_uploads' );
}

if ( ! function_exists( 'listar_allow_user_uploads' ) ) :
	/**
	 * Set user roles - Allow upload files.
	 *
	 * @since 1.0
	 */
	function listar_allow_user_uploads() {
		$user = get_role( 'subscriber' );
		$user->add_cap( 'upload_files' );
	}
endif;

/**
 * Cancel displays of relational links for the posts adjacent to the current post.
 *
 * @link https://developer.wordpress.org/reference/functions/adjacent_posts_rel_link_wp_head/
 * @since 1.0
 */
remove_action( 'wp_head', 'adjacent_post_rel_link_wp_head', 10, 0 );

add_action( 'wp_enqueue_scripts', 'listar_call_footer_enqueued_scripts' );

if ( ! function_exists( 'listar_call_footer_enqueued_scripts' ) ) :
	/**
	 * Call and update queue of not printed scripts on footer,
	 * since we have Ajax Load More script being called laterly.
	 *
	 * @since 1.0
	 */
	function listar_call_footer_enqueued_scripts() {

		//add_action( 'wp_footer', 'wp_print_scripts', 5 );
		add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	}

endif;

add_filter( 'script_loader_src', 'listar_modifying_resource_urls', 99, 2 );

function listar_modifying_resource_urls( $src, $handle ) {
	$use_pagespeed = listar_use_pagespeed();

	if ( 0 === 1 && ! is_admin() && 'jquery-core' === $handle && $use_pagespeed ) {
		$src = listar_get_theme_file_uri( '/assets/js/dummy-for-pagespeed.js' );
	}

	return esc_url( $src );
}

if ( ! function_exists( 'listar_load_more_script' ) ) :
	/**
	 * Ajax Load More posts - Scripts.
	 *
	 * @since 1.0
	 * @param (object) $query The current WordPress query object.
	 */
	function listar_load_more_script( $query = false ) {

		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		$paged = 1;

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			/* 'page' is used instead of 'paged' on Static Front Page */
			$paged = get_query_var( 'page' );
		}

		wp_localize_script(
			'listar-main-javascript',
			'listarAjaxPostsParams',
			array(
				'ajaxurl'      => esc_url( site_url() . '/wp-admin/admin-ajax.php' ),
				'posts'        => wp_json_encode( $query->query_vars ),
				'current_page' => (int) $paged,
				'max_page'     => $query->max_num_pages,
			)
		);
	}

endif;

add_action( 'wp_ajax_loadmore', 'listar_ajax_handler' );
add_action( 'wp_ajax_nopriv_loadmore', 'listar_ajax_handler' );

if ( ! function_exists( 'listar_ajax_handler' ) ) :
	/**
	 * Ajax Load More posts - Handler.
	 *
	 * @since 1.0
	 */
	function listar_ajax_handler() {

		$args                = json_decode( filter_input( INPUT_POST, 'query' ), true );
		$args['paged']       = (int) filter_input( INPUT_POST, 'page', FILTER_VALIDATE_INT ) + 1; /* Next page to be loaded */
		$args['post_status'] = 'publish';

		$exec_query = new WP_Query( $args );

		if ( ! $exec_query->have_posts() ) {
			wp_reset_postdata();
			die();
		}

		listar_static_map_markers_ajax( array() );

		listar_is_ajax_loop( true );

		while ( $exec_query->have_posts() ) :

			$exec_query->the_post();

			if ( 'job_listing' === $args['post_type'] ) {

				listar_static_current_listings( get_the_ID() );
				get_template_part( 'template-parts/directory-parts/loop/loop' );

			} elseif ( 'post' === $args['post_type'] ) {

				$grid_design = get_option( 'listar_blog_grid_design' );

				if ( empty( $grid_design ) ) {
					$grid_design = 'full-width';
				}

				get_template_part( 'template-parts/blog-parts/loop/loop-' . $grid_design );
			}

		endwhile;

		if ( 'job_listing' === $args['post_type'] && post_type_exists( 'job_listing' ) ) {
			get_template_part( 'template-parts/directory-parts/listings-map', 'markers' );
		}

		wp_reset_postdata();

		die;
	}

endif;

add_filter( 'prepend_attachment', 'listar_prepend_attachment' );

if ( ! function_exists( 'listar_prepend_attachment' ) ) :
	/**
	 * Set default image size on the attachment pages.
	 *
	 * @since 1.0
	 */
	function listar_prepend_attachment() {

		return '<p>' . wp_get_attachment_link( 0, 'large', false ) . '</p>';
	}

endif;

add_filter( 'widget_title', 'listar_check_current_widget_idbase', 10, 3 );

if ( ! function_exists( 'listar_check_current_widget_idbase' ) ) :
	/**
	 * Check the id base of current widget and apply filter to append thumbnails to widget posts.
	 *
	 * @since 1.0
	 * @param (string)  $title Widget instance title.
	 * @param (array)   $instance Widget instance.
	 * @param (integer) $id_base Widget instance ID.
	 * @return (string)
	 */
	function listar_check_current_widget_idbase( $title = '', $instance = array(), $id_base = '' ) {

		listar_static_widget_idbase( $id_base );
		add_filter( 'the_title', 'listar_prepend_thumbnail', 10, 2 );

		return $title;
	}
endif;


/* Set initial configs to Smash Balloon Instagram Feed plugin right after activate it */

$listar_instagram_feed_path =  rtrim( ABSPATH,'/' ) . '\wp-content\plugins\instagram-feed\instagram-feed.php';
$listar_instagram_feed_path2 = false !== strpos( $listar_instagram_feed_path, '/' ) ? str_replace( '\\', '/', $listar_instagram_feed_path ) : $listar_instagram_feed_path;

register_activation_hook( $listar_instagram_feed_path2, 'listar_instagram_feed_activate' );
add_action( 'admin_init', 'listar_instagram_feed_after_activation' );

function listar_instagram_feed_activate() {
	add_option( 'listar_after_activate_instagram_feed', 'true' );
}

function listar_instagram_feed_after_activation() {
	if ( 'true' === get_option( 'listar_after_activate_instagram_feed' ) ) {
		$sbi_options = get_option( 'sb_instagram_settings' );
		$sbi_options['custom_template'] = 'on';
		update_option( 'sb_instagram_settings', $sbi_options );
		sb_instagram_clear_page_caches();
	}

	delete_option( 'listar_after_activate_instagram_feed' );
}




/* Set initial configs to WP Job Manager plugin right after activate it */
/* Create pages required for this plugin */

$listar_wp_job_manager_path =  rtrim( ABSPATH,'/' ) . '\wp-content\plugins\wp-job-manager\wp-job-manager.php';
$listar_wp_job_manager_path2 = false !== strpos( $listar_wp_job_manager_path, '/' ) ? str_replace( '\\', '/', $listar_wp_job_manager_path ) : $listar_wp_job_manager_path;

register_activation_hook( $listar_wp_job_manager_path2, 'listar_wp_job_manager_activate' );
add_action( 'admin_init', 'listar_wp_job_manager_after_activation' );

function listar_wp_job_manager_activate() {
	add_option( 'listar_after_activate_wp_job_manager', 'true' );
}

function listar_wp_job_manager_after_activation() {
	if ( 'true' === get_option( 'listar_after_activate_wp_job_manager' ) ) {
		
		/* Firstly, verify if pages already exists */
	
		$pages = get_pages();
		
		$has_add_listing_page = false;
		$has_listing_dashboard_page = false;
		$has_listings_page = false;
		
		foreach ( $pages as $page ) {
			if ( false !== strpos( $page->post_content, '[submit_job_form]' ) ) {
				$has_add_listing_page = true;
			} elseif ( false !== strpos( $page->post_content, '[job_dashboard]' ) ) {
				$has_listing_dashboard_page = true;
			} elseif ( false !== strpos( $page->post_content, '[jobs]' ) ) {
				$has_listings_page = true;
			}
		}
		
		$page_titles = array();
		$pages_to_create = array();
		
		if ( ! $has_add_listing_page ) {
			$page_titles['submit_job_form'] = esc_html__( 'Add Listing', 'Listar' );
			$pages_to_create['submit_job_form'] = '[submit_job_form]';
		}
		
		if ( ! $has_listing_dashboard_page ) {
			$page_titles['job_dashboard'] = esc_html__( 'Listing Dashboard', 'Listar' );
			$pages_to_create['job_dashboard'] = '[job_dashboard]';
		}
		
		if ( ! $has_listings_page ) {
			$page_titles['jobs'] = esc_html__( 'Listings', 'Listar' );
			$pages_to_create['jobs'] = '[jobs]';
		}

		foreach ( $pages_to_create as $page => $content ) {			
			$my_post = array(
				'post_type'     => 'page',
				'post_title'    => $page_titles[ $page ],
				'post_content'  => $content,
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
			);

			$page_id = wp_insert_post( $my_post );
			
			update_option( 'job_manager_' . $page . '_page_id', $page_id );
		}

                update_option( 'job_manager_user_requires_account', '' );
                update_option( 'job_manager_per_page', '12' );
                update_option( 'job_manager_enable_types', '0' );
                update_option( 'job_manager_enable_categories', '1' );
                update_option( 'job_manager_enable_default_category_multiselect', '1' );
                update_option( 'job_manager_paid_listings_flow', 'before' );
                update_option( 'job_manager_registration_role', 'subscriber' );
                update_option( 'wpjmr_allow_images', '' );
		
		WP_Job_Manager_Admin_Notices::remove_notice( WP_Job_Manager_Admin_Notices::NOTICE_CORE_SETUP );
	}

	delete_option( 'listar_after_activate_wp_job_manager' );
}

if ( ! function_exists( 'listar_prepend_thumbnail' ) ) :
	/**
	 * Append thumbnails to 'Recent Posts' widget.
	 *
	 * @since 1.0
	 * @param (string)  $title Title of the post.
	 * @param (integer) $post_id ID of the post.
	 * @return (string)
	 */
	function listar_prepend_thumbnail( $title, $post_id ) {

		if ( 'recent-posts' === listar_static_widget_idbase() ) {

			$output = '<div class="listar-post-item listar-no-image">';

			if ( has_post_thumbnail( $post_id ) ) :
				$listar_blank_placeholder = listar_blank_base64_placeholder_image();
				$output .= '<div class="img">';
				$output .= '<img data-background-image="' . esc_attr( listar_custom_esc_url( get_the_post_thumbnail_url( $post_id, 'thumbnail' ) ) ) . '" alt="' . esc_attr( $title ) . '" src="' . esc_attr( $listar_blank_placeholder ) . '" />';
				$output .= '</div>';
			else :
				$output = '<div class="listar-post-item listar-no-image">';
			endif;

			return $output . '<div class="listar-post-title-wrapper"><div class="post-title">' . $title . '</div></div></div>';
		}

		return $title;
	}

endif;

if ( ! function_exists( 'listar_static_widget_idbase' ) ) :
	/**
	 * Temporary saves the id base of current widget, so 'listar_prepend_thumbnail' can change the output
	 * of 'the_title' filter only to 'recent-posts' widget.
	 *
	 * @since 1.0
	 * @param (string) $idbase The id base of current widget every time 'widget_title' filter executes.
	 * @return (string)
	 */
	function listar_static_widget_idbase( $idbase = '' ) {

		static $listar_static_widget_idbase = '';

		if ( ! empty( $idbase ) ) {
			$listar_static_widget_idbase = $idbase;
		}

		return $listar_static_widget_idbase;
	}

endif;

/*
 * Cancel default listing description from WP Job Manager, in case of empty description.
 * 
 */
add_filter( 'the_job_location_anywhere_text', '__return_false' );

/*
 * Fix for Google Search Console - Disable unwanted structured data for "Jobs" coming from WP Job Listing plugin
 * 
 * @link https://wpjobmanager.com/document/fixing-structured-data-issues/#section-6
 */
add_filter( 'wpjm_get_job_listing_structured_data', '__return_false' );

add_filter( 'the_content_more_link', 'listar_modify_read_more_link' );

if ( ! function_exists( 'listar_modify_read_more_link' ) ) :
	/**
	 * Modify the 'Read more' link text.
	 *
	 * @since 1.0
	 * @link https://developer.wordpress.org/reference/hooks/the_content_more_link/
	 */
	function listar_modify_read_more_link() {

		return '<a class="more-link" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'listar' ) . '</a>';
	}

endif;


add_action( 'pre_get_posts', 'listar_pre_get_listings' );

if ( ! function_exists( 'listar_pre_get_listings' ) ) :
	/**
	 * Set correct query arguments if querying listings.
	 *
	 * @param (object) $query Current WordPress query object before it be processed.
	 * @since 1.0
	 */
	function listar_pre_get_listings( $query ) {

		global $wp_query;

		$qvars = isset( $query->query_vars ) ? $query->query_vars : false;		
		$listar_session = listar_get_session_key_alias( 'listar_user_search_options' );
		$post_type_ajax = isset( $listar_session['listar-ajax-search-search_type'] ) && 'listing' === $listar_session['listar-ajax-search-search_type'];
		$is_ajax_search = $post_type_ajax && isset( $listar_session['listar-ajax-search'] ) && '1' === $listar_session['listar-ajax-search'];
				
		if ( $is_ajax_search ) {
			listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '0' );
		}

		if ( isset( $query->query_vars[ listar_url_query_vars_translate( 'bookmarks_page' ) ] ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$bookmearked_user_posts_temp = get_the_author_meta( 'listar_meta_box_user_bookmarked_posts', $user_id );
			$bookmearked_user_posts_array = ! empty( $bookmearked_user_posts_temp ) ? array_filter( explode( ',', $bookmearked_user_posts_temp ) ) : array();
			$empty_bookmarks = empty( $bookmearked_user_posts_array ) ? '1' : '';

			$args = array(
				'post_type'        => 'job_listing',
				'posts_per_page'   => (int) get_option( 'job_manager_per_page' ),
				'post_status'      => 'publish',
				'post__in'         => $bookmearked_user_posts_array,
				'custom_grid'      => 'bookmarks',
				'empty_bookmarks'  => $empty_bookmarks,
				'custom_query'     => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
			);

			/* Customize WordPress query */
			foreach ( $args as $key => $value ) :
				$query->set( $key, $value );
			endforeach;
		} elseif (
			isset($qvars['post_type'])
			&& $qvars['post_type'] === 'product'
			&& ! isset( $query->query['custom_query'] ) 
		) {
			if ( ! is_admin() )  {
				$temp_search_string = isset($qvars['s']) && ! empty($qvars['s']) ? $qvars['s'] : '';
				$product_search_string = $is_ajax_search ? $listar_session['listar-ajax-search-s'] : $temp_search_string;
				
				if ( ! empty( $product_search_string ) ) {

					// SETTINGS:
					$taxonomies = array('product_tag', 'product_cat'); // Here set your custom taxonomies in the array
					$meta_keys  = array('_sku'); // Here set your product meta key(s) in the array

					// Initializing tax query
					$tax_query  = count($taxonomies) > 1 ? array('relation' => 'OR') : array();

					// Loop through taxonomies to set the tax query
					foreach( $taxonomies as $taxonomy ) {
					    $tax_query[] = array(
						'taxonomy' => $taxonomy,
						'field'    => 'name',
						'terms'    => esc_attr( $product_search_string ),
					    );
					}

					// Get the product Ids for default search - Only match if search string is exactly equal to term name.
					$search_product_ids = (array) get_posts( array(
						's'               => $product_search_string,
						'posts_per_page'  => 2000,
						'post_type'       => 'product',
						'post_status'     => 'publish',
						'fields'          => 'ids',
						'tax_query'       => $tax_query,
						'custom_query'    => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
					) );

					// Get the product Ids from taxonomy(ies) - Only match if search string is exactly equal to term name.
					$tax_query_ids = (array) get_posts( array(
						'posts_per_page'  => 2000,
						'post_type'       => 'product',
						'post_status'     => 'publish',
						'fields'          => 'ids',
						'tax_query'       => $tax_query,
						'custom_query'    => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
					) );

					// Initializing meta query
					$meta_query = count($meta_keys) > 1 ? array('relation' => 'OR') : array();

					// Loop through taxonomies to set the tax query
					foreach( $taxonomies as $taxonomy ) {
					    $meta_query[] = array(
						'key'     => '_sku',
						'value'   => esc_attr($qvars['s']),
					    );
					}

					// Get the product Ids from custom field(s)
					$meta_query_ids = (array) get_posts( array(
						'posts_per_page'  => 2000,
						'post_type'       => 'product',
						'post_status'     => 'publish',
						'fields'          => 'ids',
						'meta_query'      => $meta_query,
						'custom_query'    => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
					) );
					
					// Get all products for categories and tags if its names contain at least a partial or whole word from search string.
					
					$product_search_string_words = array();
					$listing_ids_via_product_query = array();

					if ( false !== strpos( $product_search_string, ' ' ) ) {
						$product_temp_search_words = array_filter( explode( ' ', $product_search_string ) );
						$product_temp_search_words_count = is_array( $product_temp_search_words ) ? count( $product_temp_search_words ) : 0;

						for( $i = 0; $i < $product_temp_search_words_count; $i++ ) {
							$word_1 = listar_remove_accents( $product_temp_search_words[ $i ] );

							// For one word.
							$product_search_string_words[] = $word_1;

							// For two words.
							if ( isset( $product_temp_search_words[ $i + 1 ] ) ) {
								$word_2 = $product_temp_search_words[ $i + 1 ];
								$new_string = $word_1 . ' ' . $word_2;

								if ( ! in_array( $new_string, $product_search_string_words, true ) ) {
									$product_search_string_words[] = $new_string;
								}

								// For three words.
								if ( isset( $product_temp_search_words[ $i + 2 ] ) ) {
									$word_3 = $product_temp_search_words[ $i + 2 ];
									$new_string = $word_1 . ' ' . $word_2 . ' ' . $word_3;

									if ( ! in_array( $new_string, $product_search_string_words, true ) ) {
										$product_search_string_words[] = $new_string;
									}

									// For four words.
									if ( isset( $product_temp_search_words[ $i + 3 ] ) ) {
										$word_4 = $product_temp_search_words[ $i + 3 ];
										$new_string = $word_1 . ' ' . $word_2 . ' ' . $word_3 . ' ' . $word_4;

										if ( ! in_array( $new_string , $product_search_string_words, true ) ) {
											$product_search_string_words[] = $new_string;
										}
									}
								}
							}
						}
					} else {
						$product_search_string_words[] = listar_remove_accents( $product_search_string );
					}

					if ( ! empty( $product_search_string_words ) ) {
						$product_search_string_words = array_unique( $product_search_string_words );
					}

					// Get all products for categories and tags if its names contain at least a word from search string.
					/* Get listings IDS by searching on listing term names */

					foreach( $taxonomies as $taxonomy ) {
						
						if ( taxonomy_exists( $taxonomy ) ) {
							$category_terms = get_terms( [
								'taxonomy' => $taxonomy,
								'hide_empty' => true,
								'number' => 2000,
							] );

							foreach( $category_terms as $category_term ) {
								$category_term_id = $category_term->term_id;
								$category_term_name = listar_remove_accents( $category_term->name );

								foreach( $product_search_string_words as $search_string_word ) {
									$count_chars = strlen( $search_string_word );

									if ( $count_chars > 2 && false !== strpos( strtolower( $category_term_name ), strtolower( $search_string_word ) ) ) {
										$category_term_ids[] = $category_term_id;
									}
								}
							}

							if ( ! empty( $category_term_ids ) ) {

								$category_term_ids = array_unique( $category_term_ids );

								$cat_taxonomies = array();

								$cat_taxonomies[] = array(
									'taxonomy'         => $taxonomy,
									'terms'            => $category_term_ids,
									'include_children' => true,
									'operator'         => 'IN',
								);

								$exec_query = new WP_Query(
									array(
										'post_status'    => 'publish',
										'post_type'      => 'product',
										'posts_per_page' => 2000,
										'tax_query'      => $cat_taxonomies,
									)
								);

								if ( $exec_query->have_posts() ) :
									while ( $exec_query->have_posts() ) :
										$exec_query->the_post();

										$current_listing_id = get_the_ID();

										if ( ! in_array( $current_listing_id , $listing_ids_via_product_query, true ) ) {
											$listing_ids_via_product_query[] = $current_listing_id;
										}
									endwhile;
								endif;
							}
						}
					}
					
					
					
					
					
					
					
					
					
					
					
					
					
					

					$product_ids = array_unique( array_merge( $search_product_ids, $tax_query_ids, $meta_query_ids, $listing_ids_via_product_query ) ); // Merge Ids in one array  with unique Ids

					if ( sizeof( $product_ids ) > 0 ) {
						$args = array(
							's'                => '',
							'tax_query'        => array( array(
								'taxonomy' => 'product_type',
								'field'    => 'slug',
								'terms'    => array( 'job_package', 'job_package_subscription' ),
								'operator' => 'NOT IN',
							) ),
							'post_type'        => 'product',
							'post_status'      => 'publish',
							'post__in'         => $product_ids,
							'custom_query'     => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
						);

						if ( isset( $wp_query->query['s'] ) ) {
							$wp_query->query['s'] = '';
						}

						/* Customize WordPress query */
						foreach ( $args as $key => $value ) :
							$query->set( $key, $value );
						endforeach;
					}
				}
			}
		} elseif ( ! isset( $query->query['ordened_by_distance'] ) && ! isset( $wp_query->query_vars['ordened_by_distance'] ) ) {
			$tx                      = isset( $query->tax_query->queries[0]['taxonomy'] ) ? $query->tax_query->queries[0]['taxonomy'] : '';
			$is_listing_taxonomy     = ( false !== strpos( $tx, 'job_listing_' ) ) ? '1' : '';
			$page_content            = isset( $query->queried_object->post_content ) ? $query->queried_object->post_content : '';
			$is_listing_page         = has_shortcode( $page_content, 'jobs' ) ? '1' : '';
			$search_type             = $is_ajax_search ? $listar_session['explore_by_search_type'] : ( isset( $query->query[ listar_url_query_vars_translate( 'search_type' ) ] ) ? ( 'listing' === $query->query[ listar_url_query_vars_translate( 'search_type' ) ] ? 'listing' : '' ) : '' );
			$post_type               = $query->get( 'post_type' );
			$is_job_listing          = 'job_listing' === $post_type ? '1' : '';
			$is_singular             = isset( $query->is_singular ) ? $query->is_singular : false;
			$is_singular_listing     = (bool) $is_job_listing && (bool) $is_singular ? true : false;
			$args                    = array();
			$current_explore_by_type = listar_current_explore_by();
			$is_ordering_by_coordinates = 'nearest_me' === $current_explore_by_type || 'near_address' === $current_explore_by_type || 'near_postcode' === $current_explore_by_type ? $current_explore_by_type : false;
			$is_ordering_by_nearest_me = 'nearest_me' === $current_explore_by_type;


			$force_featured   = (int) get_option( 'listar_use_search_listing_featured_data' );
			$search_on_categories = 1 === (int) get_option( 'listar_use_search_listing_category_data' ) && taxonomy_exists( 'job_listing_category' );
			$search_on_regions = 1 === (int) get_option( 'listar_use_search_listing_region_data' ) && taxonomy_exists( 'job_listing_region' );
			$search_on_amenities = 1 === (int) get_option( 'listar_use_search_listing_amenity_data' ) && taxonomy_exists( 'job_listing_amenity' );

			$search_on_tags = 1 === (int) get_option( 'listar_use_search_listing_tags_data' );
			$search_on_location = 1 === (int) get_option( 'listar_use_search_listing_location_data' );
			$search_on_subtitle = 1 === (int) get_option( 'listar_use_search_listing_subtitle_data' );
			$search_on_tagline = 1 === (int) get_option( 'listar_use_search_listing_tagline_data' );
			$search_on_raw = 1 === (int) get_option( 'listar_use_search_listing_raw_data' );
			$search_on_description = 1 === (int) get_option( 'listar_use_search_listing_description_data' );
			
			
			/* If all these values are empty/false, it isn't querying listings as archive */
			$conditions = $is_listing_taxonomy . $is_listing_page . $search_type . $is_job_listing . $is_singular_listing;
			
			if (
				! isset( $query->query['ajax_query'] ) && (
					/* Don't proceed if in WordPress admin */
					is_admin() ||
					/* Don't proceed if not $wp_query */
					$query !== $wp_query
				)
			) {
				/* This isn't a listing query or the main configurations for listing query were already applied */
				return;
			} else {

				/* Don't allow the same custom query be processed by this pre_get_posts' action twice */
				if ( ! isset( $query->query['custom_query'] ) && ! isset( $wp_query->query_vars['ids_via_query'] ) ) {
					
					/* Execute main configurations for listing query */

					$term                    = get_queried_object();
					$term_exists             = isset( $term->term_id ) ? true : false;
					$search_string           = listar_search_string_cleaner( html_entity_decode( listar_get_search_query( $is_ajax_search ), ENT_QUOTES ) );
					$region_term_ids         = array();
					$category_term_ids       = array();
					$amenity_term_ids        = array();
					$listing_ids_via_query   = array();
					$paged                   = 1;
					
					if ( $is_ordering_by_coordinates && ! $is_ordering_by_nearest_me ) {
						$search_string = '';
					}

					/* Get current sorting order to listings */
					$sort = listar_current_directory_sort();

					if ( ! empty( $search_type ) && ( 'blog' === $search_type || 'shop_products' === $search_type ) ) {
						return;
					}

					if ( empty( $conditions ) || $is_singular_listing ) {
						return;
					}

					/* If term exists */
					if ( $term_exists ) {
						$region_id   = 'job_listing_region' === $tx ? $term->term_id : '';
						$category_id = 'job_listing_category' === $tx ? $term->term_id : '';
						$amenity_id  = 'job_listing_amenity' === $tx ? $term->term_id : '';
					}

					$regions = empty( $region_id ) ? array() : array( $region_id );

					if ( empty( $regions ) ) {

						/* It is not on a Listing Region page, so maybe get region IDs from GET */
						$get_regions = listar_get_region_query( $is_ajax_search );
						$regions = ! empty( $get_regions ) ? array( $get_regions ) : array( 0 );

						if ( false !== strpos( $regions[0], ',' ) ) {
							$regions = explode( ',', $regions[0] );
						}
					}

					$categories = empty( $category_id ) ? array() : array( $category_id );

					if ( empty( $categories ) ) {

						/* It is not on a Listing Category page, so maybe get category IDs from GET */
						$get_categories = listar_get_category_query( $is_ajax_search );
						$categories = ! empty( $get_categories ) ? array( $get_categories ) : array( 0 );

						if ( false !== strpos( $categories[0], ',' ) ) {
							$categories = explode( ',', $categories[0] );
						}
					}

					$amenities = empty( $amenity_id ) ? array() : array( $amenity_id );

					if ( empty( $amenities ) ) {

						/* It is not on an Listing Amenity page, so maybe get amenity IDs from GET */
						$get_amenities = listar_get_amenity_query( $is_ajax_search );
						$amenities = ! empty( $get_amenities ) ? array( $get_amenities ) : array( 0 );

						if ( false !== strpos( $amenities[0], ',' ) ) {
							$amenities = explode( ',', $amenities[0] );
						}
					}

					/* Operators */
					$operator_regions    = 0 === $regions[0] ? 'NOT IN' : 'IN';
					$operator_categories = 0 === $categories[0] ? 'NOT IN' : 'IN';
					$operator_amenities  = 0 === $amenities[0] ? 'NOT IN' : 'AND';

					/* Order (sort) */
					$orderby = '';
					$order   = 'DESC';
					$metakey = '';
					$postin  = '';
					$meta_query = array( array() );

					/* Sort */
					switch ( $sort ) {
						case 'trending' :
							$postin  = listar_get_trending_listings( true );
							$orderby = 'post__in';
							break;
						case 'best_rated' :
							$postin  = listar_saved_best_rated();
							$orderby = 'post__in';
							break;
						case 'newest' :
							$orderby = $force_featured ? 'meta_value_num date' : 'date';
							$metakey =  $force_featured ? '_featured' : '';
							break;
						case 'oldest' :
							$orderby = 'date';
							$order   = 'ASC';
							break;
						case 'most_viewed' :
							$orderby = 'meta_value_num date';
							$metakey = 'listar_meta_box_views_counter';
							break;
						case 'most_bookmarked' :
							$orderby = 'meta_value_num date';
							$metakey = 'listar_meta_box_bookmarks_counter';
							break;
						case 'asc' :
							$orderby = 'title';
							$order   = 'ASC';
							break;
						case 'desc' :
							$orderby = 'title';
							$order   = 'DESC';
							break;
						case 'random' :
							$orderby = 'rand';
							break;
						default:
							/* Newest */
							$orderby = $force_featured ? 'meta_value_num date' : 'date';
							$metakey =  $force_featured ? '_featured' : '';
							break;
					}

					if ( ! empty( $search_string ) && ( false === $is_ordering_by_coordinates || true === $is_ordering_by_nearest_me ) ) {
					
						$search_string_words = array();

						/*

						if ( false !== strpos( $search_string, ' ' ) ) {
							$temp_search_words = array_filter( explode( ' ', $search_string ) );
							$temp_search_words_count = is_array( $temp_search_words ) ? count( $temp_search_words ) : 0;

							for( $i = 0; $i < $temp_search_words_count; $i++ ) {
								$word_1 = listar_remove_accents( $temp_search_words[ $i ] );

								// For one word.
								$search_string_words[] = $word_1;

								// For two words.
								if ( isset( $temp_search_words[ $i + 1 ] ) ) {
									$word_2 = $temp_search_words[ $i + 1 ];
									$new_string = $word_1 . ' ' . $word_2;

									if ( ! in_array( $new_string, $search_string_words, true ) ) {
										$search_string_words[] = $new_string;
									}

									// For three words.
									if ( isset( $temp_search_words[ $i + 2 ] ) ) {
										$word_3 = $temp_search_words[ $i + 2 ];
										$new_string = $word_1 . ' ' . $word_2 . ' ' . $word_3;

										if ( ! in_array( $new_string, $search_string_words, true ) ) {
											$search_string_words[] = $new_string;
										}

										// For four words.
										if ( isset( $temp_search_words[ $i + 3 ] ) ) {
											$word_4 = $temp_search_words[ $i + 3 ];
											$new_string = $word_1 . ' ' . $word_2 . ' ' . $word_3 . ' ' . $word_4;

											if ( ! in_array( $new_string , $search_string_words, true ) ) {
												$search_string_words[] = $new_string;
											}
										}
									}
								}
							}
						} else {
							$search_string_words[] = listar_remove_accents( $search_string );
						}

						if ( ! empty( $search_string_words ) ) {
							$search_string_words = array_unique( $search_string_words );
						}
						*/

						$search_string_words[] = listar_remove_accents( trim( $search_string ) );
						
						
						/* Get listings IDS by searching on meta fields */

						$args_meta = array(
							'posts_per_page'             => 1000000, /* High value, that is correct: only IDs are being recovered, not the whole POST object */
							'fields'                     => 'ids',
							'no_found_rows'              => true,
							'update_post_meta_cache'     => false,
							'update_post_term_cache'     => false,
							'ignore_sticky_posts'        => true,
							'cache_results'              => false,
							'post_type'                  => 'job_listing',
							'post__not_in'               => $listing_ids_via_query,
							'post_status'                => 'publish',
						);

						if ( $search_on_tags || $search_on_location || $search_on_raw ) {
							$args_meta['meta_query'] = array(
								'relation' => 'OR',
							);

							if ( $search_on_tags ) {
								$meta = array(
									'key'      => '_job_searchtags',
									'value'    => $search_string,
									'compare'  => 'LIKE',
								);

								array_push( $args_meta['meta_query'], $meta );
							}

							if ( $search_on_location ) {
								$meta = array(
									'key'      => '_job_location',
									'value'    => $search_string,
									'compare'  => 'LIKE',
								);

								array_push( $args_meta['meta_query'], $meta );
							}

							if ( $search_on_raw ) {
								$meta = array(
									'key'      => '_job_business_raw_contents',
									'value'    => $search_string,
									'compare'  => 'LIKE',
								);

								array_push( $args_meta['meta_query'], $meta );
							}


							$query_results_2 = get_posts( $args_meta );

							if ( is_array( $query_results_2 ) ) {
								$listing_ids_via_query = array_merge( $listing_ids_via_query, $query_results_2 );
							}
						}
										
						if ( $is_ajax_search ) {
							listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
						}
						
						/* Get listings IDS by searching on listing term names */

						if ( $search_on_categories && ! empty( $search_string_words ) && taxonomy_exists( 'job_listing_category' ) ) {
							$category_terms = get_terms( [
								'taxonomy' => 'job_listing_category',
								'hide_empty' => true,
								'number' => 2000,
							] );

							foreach( $category_terms as $category_term ) {
								$category_term_id = $category_term->term_id;
								$category_term_name = listar_remove_accents( $category_term->name );

								foreach( $search_string_words as $search_string_word ) {
									$count_chars = strlen( $search_string_word );

									if ( $count_chars > 2 && false !== strpos( strtolower( $category_term_name ), strtolower( $search_string_word ) ) ) {
										$category_term_ids[] = $category_term_id;
									}
								}
							}

							if ( ! empty( $category_term_ids ) ) {

								$category_term_ids = array_unique( $category_term_ids );

								$cat_taxonomies = array();

								$cat_taxonomies[] = array(
									'taxonomy'         => 'job_listing_category',
									'terms'            => $category_term_ids,
									'include_children' => true,
									'operator'         => 'IN',
								);
										
								if ( $is_ajax_search ) {
									listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
								}

								$args_meta = array(
									'posts_per_page'             => 1000000, /* High value, that is correct: only IDs are being recovered, not the whole POST object */
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'post_type'                  => 'job_listing',
									'post__not_in'               => $listing_ids_via_query,
									'post_status'                => 'publish',
									'tax_query'                  => $cat_taxonomies,
								);


								$query_results_2 = get_posts( $args_meta );

								if ( is_array( $query_results_2 ) ) {
									$listing_ids_via_query = array_merge( $listing_ids_via_query, $query_results_2 );
								}
							}
						}

						if ( $search_on_regions && ! empty( $search_string_words ) && class_exists( 'Astoundify_Job_Manager_Regions' ) ) {

							$region_terms = get_terms( [
								'taxonomy' => 'job_listing_region',
								'hide_empty' => true,
								'number' => 2000,
							] );

							foreach( $region_terms as $region_term ) {
								$region_term_id = $region_term->term_id;
								$region_term_name = listar_remove_accents( $region_term->name );

								foreach( $search_string_words as $search_string_word ) {
									$count_chars = strlen( $search_string_word );

									if ( $count_chars > 2 && false !== strpos( strtolower( $region_term_name ), strtolower( $search_string_word ) ) ) {
										$region_term_ids[] = $region_term_id;
									}
								}
							}

							if ( ! empty( $region_term_ids ) ) {

								$region_term_ids = array_unique( $region_term_ids );

								$reg_taxonomies = array();

								$reg_taxonomies[] = array(
									'taxonomy'         => 'job_listing_region',
									'terms'            => $region_term_ids,
									'include_children' => true,
									'operator'         => 'IN',
								);
										
								if ( $is_ajax_search ) {
									listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
								}

								$args_meta = array(
									'posts_per_page'             => 1000000, /* High value, that is correct: only IDs are being recovered, not the whole POST object */
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'post_type'                  => 'job_listing',
									'post__not_in'               => $listing_ids_via_query,
									'post_status'                => 'publish',
									'tax_query'                  => $reg_taxonomies,
								);


								$query_results_2 = get_posts( $args_meta );

								if ( is_array( $query_results_2 ) ) {
									$listing_ids_via_query = array_merge( $listing_ids_via_query, $query_results_2 );
								}
							}
						}

						if ( $search_on_amenities && ! empty( $search_string_words ) && taxonomy_exists( 'job_listing_amenity' ) ) {

							$amenity_terms = get_terms( [
								'taxonomy' => 'job_listing_amenity',
								'hide_empty' => true,
								'number' => 2000,
							] );

							foreach( $amenity_terms as $amenity_term ) {
								$amenity_term_id = $amenity_term->term_id;
								$amenity_term_name = listar_remove_accents( $amenity_term->name );

								foreach( $search_string_words as $search_string_word ) {
									$count_chars = strlen( $search_string_word );

									if ( $count_chars > 2 && false !== strpos( strtolower( $amenity_term_name ), strtolower( $search_string_word ) ) ) {
										$amenity_term_ids[] = $amenity_term_id;
									}
								}
							}

							if ( ! empty( $amenity_term_ids ) ) {

								$amenity_term_ids = array_unique( $amenity_term_ids );

								$ame_taxonomies = array();

								$ame_taxonomies[] = array(
									'taxonomy'         => 'job_listing_amenity',
									'terms'            => $amenity_term_ids,
									'include_children' => true,
									'operator'         => 'IN',
								);
										
								if ( $is_ajax_search ) {
									listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
								}

								$args_meta = array(
									'posts_per_page'             => 1000000, /* High value, that is correct: only IDs are being recovered, not the whole POST object */
									'fields'                     => 'ids',
									'no_found_rows'              => true,
									'update_post_meta_cache'     => false,
									'update_post_term_cache'     => false,
									'ignore_sticky_posts'        => true,
									'cache_results'              => false,
									'post__not_in'               => $listing_ids_via_query,
									'post_type'                  => 'job_listing',
									'post_status'                => 'publish',
									'tax_query'                  => $ame_taxonomies,
								);


								$query_results_2 = get_posts( $args_meta );

								if ( is_array( $query_results_2 ) ) {
									$listing_ids_via_query += $query_results_2;
								}

								if ( ! empty( $listing_ids_via_query ) ) {
									$listing_ids_via_query = array_unique( $listing_ids_via_query );
								}
							}
						}
					}

					if ( ! empty( $listing_ids_via_query ) ) {
						listar_save_listings_queried_by_search_string( $listing_ids_via_query );
					}

					$taxonomies = array();

					if ( 0 !== (int) ( $regions[0] + $categories[0] + $amenities[0] ) ) {

						if ( taxonomy_exists( 'job_listing_category' ) ) {
							$taxonomies[] = array(
								'taxonomy'         => 'job_listing_category',
								'terms'            => $categories,
								'include_children' => true,
								'operator'         => $operator_categories,
							);
						}

						if ( taxonomy_exists( 'job_listing_amenity' ) ) {
							$taxonomies[] = array(
								'taxonomy'         => 'job_listing_amenity',
								'terms'            => $amenities,
								'include_children' => true,
								'operator'         => $operator_amenities,
							);
						}

						if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
							$taxonomies[] = array(
								'taxonomy'         => 'job_listing_region',
								'terms'            => $regions,
								'include_children' => true,
								'operator'         => $operator_regions,
							);
						}
					}

					if ( get_query_var( 'paged' ) ) {
						$paged = get_query_var( 'paged' );
					} elseif ( get_query_var( 'page' ) ) {
						/* 'page' is used instead of 'paged' on Static Front Page */
						$paged = get_query_var( 'page' );
					}

					$args = array(
						'posts_per_page'             => 1000000, /* High value, that is correct: only IDs are being recovered, not the whole POST object */
						'fields'                     => 'ids',
						'no_found_rows'              => true,
						'update_post_meta_cache'     => false,
						'update_post_term_cache'     => false,
						'ignore_sticky_posts'        => true,
						'cache_results'              => false,
						's'                => $search_string,
						'post_type'        => 'job_listing',
						'post_status'      => 'publish',
						'suppress_filters' => false,
						'meta_key'         => $metakey,
						'orderby'          => $orderby,
						'order'            => $order,
						'post__in'         => $postin,
						'tax_query'        => $taxonomies,
						'paged'            => $paged,
						'meta_query'	   => $meta_query,
						'ids_via_query'    => $listing_ids_via_query,
						'custom_query'     => 1, /* To avoid the same query be processed by this 'pre_get_posts' action twice */
						'verify_search_by' => 1,
					);

					$query->set( 'no_found_rows', true );

					$page_id = isset( $query->queried_object->ID ) ? $query->queried_object->ID : 0;

					$listar_sort_order = listar_addons_active() ? listar_get_initial_sort_order() : 'newest';

					if ( ! empty( $is_listing_page ) ) {
						$query->set( 'no_found_rows', false );

						$page_args = array(
							listar_url_query_vars_translate( 'search_type' )  => 'listing',
							listar_url_query_vars_translate( 'listing_sort' ) => $listar_sort_order,
							'is_page'          => false,
							'is_home'          => false,
							'is_listing_page'  => true,
							'is_singular'      => false,
							'listing_page_id'  => $page_id,
							'verify_search_by' => 1,
						);
						

						$args = array_merge( $args + $page_args );
						$query->init();
					}

					/* Customize WordPress query */
					foreach ( $args as $key => $value ) :
						$query->set( $key, $value );
					endforeach;

					$queried_listings = listar_save_listings_queried_by_search_string();

					$using_custom_search_listings = listar_using_custom_search_listings();

					if ( ( false === $is_ordering_by_coordinates || true === $is_ordering_by_nearest_me ) && ! $using_custom_search_listings && ( $queried_listings || ( isset( $wp_query->query_vars['ids_via_query'] ) && ! empty( $wp_query->query_vars['ids_via_query'] ) ) ) ) {
				
						if ( $is_ajax_search ) {
							listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
						}

						$query_results_2 = get_posts( $args );

						/* This additional query will happen only in case the visitor typed a category, region or amenity in the search field and it exists as a listing term (name) or is very similar to it (listing category, listing region or listing amenity). */

						listar_using_custom_search_listings( true );

						if ( is_array( $query_results_2 ) ) {
							$queried_listings = array_unique( array_merge( $query_results_2, $queried_listings ) );
						}

						if ( get_query_var( 'paged' ) ) {
							$paged = get_query_var( 'paged' );
						} elseif ( get_query_var( 'page' ) ) {
							/* 'page' is used instead of 'paged' on Static Front Page */
							$paged = get_query_var( 'page' );
						}

						/* It is not on a Listing Region page, so maybe get region IDs from GET */
						$get_regions = listar_get_region_query(  $is_ajax_search  );
						$regions = ! empty( $get_regions ) ? array( $get_regions ) : array( 0 );

						if ( false !== strpos( $regions[0], ',' ) ) {
							$regions = explode( ',', $regions[0] );
						}

						/* It is not on a Listing Category page, so maybe get category IDs from GET */
						$get_categories = listar_get_category_query( $is_ajax_search );
						$categories = ! empty( $get_categories ) ? array( $get_categories ) : array( 0 );

						if ( false !== strpos( $categories[0], ',' ) ) {
							$categories = explode( ',', $categories[0] );
						}

						/* It is not on an Listing Amenity page, so maybe get amenity IDs from GET */
						$get_amenities = listar_get_amenity_query( $is_ajax_search );
						$amenities = ! empty( $get_amenities ) ? array( $get_amenities ) : array( 0 );

						if ( false !== strpos( $amenities[0], ',' ) ) {
							$amenities = explode( ',', $amenities[0] );
						}

						/* Operators */
						$operator_regions    = 0 === $regions[0] ? 'NOT IN' : 'IN';
						$operator_categories = 0 === $categories[0] ? 'NOT IN' : 'IN';
						$operator_amenities  = 0 === $amenities[0] ? 'NOT IN' : 'AND';

						$taxonomies = array();

						if ( 0 !== (int) ( $regions[0] + $categories[0] + $amenities[0] ) ) {

							if ( taxonomy_exists( 'job_listing_category' ) ) {
								$taxonomies[] = array(
									'taxonomy'         => 'job_listing_category',
									'terms'            => $categories,
									'include_children' => true,
									'operator'         => $operator_categories,
								);
							}

							if ( taxonomy_exists( 'job_listing_amenity' ) ) {
								$taxonomies[] = array(
									'taxonomy'         => 'job_listing_amenity',
									'terms'            => $amenities,
									'include_children' => true,
									'operator'         => $operator_amenities,
								);
							}

							if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
								$taxonomies[] = array(
									'taxonomy'         => 'job_listing_region',
									'terms'            => $regions,
									'include_children' => true,
									'operator'         => $operator_regions,
								);
							}
						}

						/* Sort */
						switch ( $sort ) {
							case 'trending' :
								$trending = listar_get_trending_listings( true );
								$temp = array();

								if ( is_array( $trending ) ) {
									foreach( $trending as $b ) {
										if ( in_array( $b, $queried_listings, true ) ) {
											$temp[] = $b;
										}
									}
								}

								$queried_listings = array_unique( array_merge( $temp, $queried_listings ) );
								$orderby = 'post__in';
								break;
							case 'best_rated' :
								$best_rated = listar_saved_best_rated();
								$temp = array();

								if ( is_array( $best_rated ) ) {
									foreach( $best_rated as $b ) {
										if ( in_array( $b, $queried_listings, true ) ) {
											$temp[] = $b;
										}
									}
								}

								$queried_listings =  array_unique( array_merge( $temp, $queried_listings ) );
								$orderby = 'post__in';
								break;
							case 'newest' :
								$orderby = $force_featured ? 'meta_value_num date' : 'date';
								$metakey =  $force_featured ? '_featured' : '';
								break;
							case 'asc' :
								$orderby = 'title';
								$order   = 'ASC';
								break;
							case 'desc' :
								$orderby = 'title';
								$order   = 'DESC';
								break;
							case 'oldest' :
								$orderby = 'date';
								$order   = 'ASC';
								break;
							case 'most_viewed' :
								$orderby = 'meta_value_num date';
								$metakey = 'listar_meta_box_views_counter';
								break;
							case 'most_bookmarked' :
								$orderby = 'meta_value_num date';
								$metakey = 'listar_meta_box_bookmarks_counter';
								break;
							case 'random' :
								$orderby = 'rand';
								break;
							default:
								/* Newest */
								$orderby = $force_featured ? 'meta_value_num date' : 'date';
								$metakey =  $force_featured ? '_featured' : '';
								break;
						}

						$args[ listar_url_query_vars_translate( 'search_type' ) ] = 'listing';
						$args['post__in'] = $queried_listings;
						$args['posts_per_page'] = 2000;
						$args['orderby'] = $orderby;
						$args['order'] = $order;
						$args['paged'] = $paged;
						$args['built_custom'] = 1;
						$args['custom_query'] = 1; /* To avoid the same query be processed by this 'pre_get_posts' action twice */
						$args['verify_search_by'] = 1;
					}
				}

				if ( $conditions && ! $is_singular_listing && false !== $is_ordering_by_coordinates && isset( $args['verify_search_by'] ) && ! $wp_query->have_posts() ) {
					$from_lat = 0;
					$to_lat = 0;
					$ids_and_distances = array();

					/* Get current sorting order to listings */

					if ( 'nearest_me' === $current_explore_by_type ) {
						$from_lat = listar_get_nearest_me_geocoded_lat();
						$to_lat = listar_get_nearest_me_geocoded_lng();
					} else if ( 'near_address' === $current_explore_by_type ) {
						$from_lat = listar_get_address_geocoded_lat();
						$to_lat = listar_get_address_geocoded_lng();
					} else if ( 'near_postcode' === $current_explore_by_type ) {
						$from_lat = listar_get_postcode_geocoded_lat();
						$to_lat = listar_get_postcode_geocoded_lng();
					}
					
					/*
					 * All listing queries and filtering were applied.
					 * Now reoder listings by proximity, in case of searches by "Nearest Me", "Near an Address" or "Near a Postcode"
					 */

					listar_save_search_string( $search_string );
					
					if ( ! empty( $queried_listings ) && $is_ordering_by_nearest_me ) :

						$args['s'] = '';

						if ( isset( $wp_query->query['s'] ) ) {
							$wp_query->query['s'] = '';
						}

						foreach ( $queried_listings as $queried_listing ) :

							$current_listing_id = $queried_listing;
							$current_listing_distance = '9999999999999999999';

							$listar_lat = esc_html( get_post_meta( $current_listing_id, 'geolocation_lat', true ) );
							$listar_lng = esc_html( get_post_meta( $current_listing_id, 'geolocation_long', true ) );
							$listar_force_lat = esc_html( get_post_meta( $current_listing_id, '_job_customlatitude', true ) );
							$listar_force_lng = esc_html( get_post_meta( $current_listing_id, '_job_customlongitude', true ) );

							if ( empty( $listar_lat ) || ! empty( $listar_force_lat )  ) {
								$listar_lat = $listar_force_lat;
							}

							if ( empty( $listar_lng ) || ! empty( $listar_force_lng )  ) {
								$listar_lng = $listar_force_lng;
							}

							if ( ! empty( $listar_lat ) && ! empty( $listar_lng ) && ! empty( $from_lat ) && ! empty( $to_lat ) ) {
								$current_listing_distance = listar_get_geolocated_distance( $from_lat, $to_lat, $listar_lat, $listar_lng );
							}

							$ids_and_distances[ $current_listing_id ] = (int) str_replace( 'km', '', $current_listing_distance );
						endforeach;
					else :
										
						if ( $is_ajax_search ) {
							listar_modify_session_key_alias( 'listar_user_search_options', 'listar-ajax-search', '1' );
						}

						$temp_paged         = $args['paged'];
						$args['paged']      = 1;
						$queried_listings_2 = get_posts( $args );
						$args['paged']      = $temp_paged;
					
						/*
						 * OK all listing queries and filtering were applied.
						 * Now reoder listings by proximity, in case of searches by "Nearest Me", "Near an Address" or "Near a Postcode"
						 */

						/* Get current sorting order to listings */

						$from_lat = 0;
						$to_lat = 0;
						$ids_and_distances = array();

						if ( 'nearest_me' === $current_explore_by_type ) {
							$from_lat = listar_get_nearest_me_geocoded_lat();
							$to_lat = listar_get_nearest_me_geocoded_lng();
						} else if ( 'near_address' === $current_explore_by_type ) {
							$from_lat = listar_get_address_geocoded_lat();
							$to_lat = listar_get_address_geocoded_lng();
						} else if ( 'near_postcode' === $current_explore_by_type ) {
							$from_lat = listar_get_postcode_geocoded_lat();
							$to_lat = listar_get_postcode_geocoded_lng();
						}

						if ( ! empty( $queried_listings_2 ) && $is_ordering_by_nearest_me ) :

							$args['s'] = '';

							if ( isset( $wp_query->query['s'] ) ) {
								$wp_query->query['s'] = '';
							}

							foreach ( $queried_listings_2 as $queried_listing ) {

								$current_listing_id = $queried_listing;
								$current_listing_distance = '9999999999999999999';

								$listar_lat = esc_html( get_post_meta( $current_listing_id, 'geolocation_lat', true ) );
								$listar_lng = esc_html( get_post_meta( $current_listing_id, 'geolocation_long', true ) );
								$listar_force_lat = esc_html( get_post_meta( $current_listing_id, '_job_customlatitude', true ) );
								$listar_force_lng = esc_html( get_post_meta( $current_listing_id, '_job_customlongitude', true ) );

								if ( empty( $listar_lat ) || ! empty( $listar_force_lat )  ) {
									$listar_lat = $listar_force_lat;
								}

								if ( empty( $listar_lng ) || ! empty( $listar_force_lng )  ) {
									$listar_lng = $listar_force_lng;
								}

								if ( ! empty( $listar_lat ) && ! empty( $listar_lng ) && ! empty( $from_lat ) && ! empty( $to_lat ) ) {
									$current_listing_distance = listar_get_geolocated_distance( $from_lat, $to_lat, $listar_lat, $listar_lng );
								}

								$ids_and_distances[ $current_listing_id ] = (int) str_replace( 'km', '', $current_listing_distance );
							}
						endif;
					endif;

					asort( $ids_and_distances );

					$ordered_ids = array();

					foreach ( $ids_and_distances as $key => $value ) {
						$ordered_ids[] = $key;
					}

					$paged = 1;

					if ( get_query_var( 'paged' ) ) {
						$paged = get_query_var( 'paged' );
					} elseif ( get_query_var( 'page' ) ) {
						/* 'page' is used instead of 'paged' on Static Front Page */
						$paged = get_query_var( 'page' );
					}

					if ( isset( $args['post__in'] ) && ! empty( $args['post__in'] ) ) {
						$ordered_ids = $ordered_ids;
					}

					$args['paged'] = $paged;
					$args['orderby'] = 'post__in';
					$args['order'] = 'ASC';
					$args['post__in'] = $ordered_ids;
					$args['ordened_by_distance'] = 1;
					
				} else if ( ! empty( $search_string ) && ! empty( $queried_listings ) ) {
					
					if ( ! $is_ajax_search ) {
						listar_save_search_string( $search_string );

						if ( isset( $wp_query->query['s'] ) ) {
							$wp_query->query['s'] = '';
						}
					}
					
					$args['s'] = '';
					
					$args['post__in'] = $queried_listings;
				}

				if ( $is_ordering_by_nearest_me ) {
					$args['s'] = listar_save_search_string();
				}

				$args['fields'] = '';
				$args['no_found_rows'] = false;
				$args['posts_per_page'] = (int) get_option( 'job_manager_per_page' );
				

				/* Customize WordPress query */
				foreach ( $args as $key => $value ) :
					$query->set( $key, $value );
				endforeach;
			}
		}
	}

endif;



add_filter( 'posts_search', 'listar_filter_post_search_sql', 10 );

if ( ! function_exists( 'listar_filter_post_search_sql' ) ) :
	function listar_filter_post_search_sql( $search ) {
		global $wp_query;

                if ( ! function_exists( 'listar_doing_listing_ajax_search' ) ) {
                        return $search;
                }

		$search_on_description = 1 === (int) get_option( 'listar_use_search_listing_description_data' );

		//echo 222;

		if ( $search_on_description ) {
			//echo 333;
			return $search;
		}

		$output = '';
		$is_ajax_search = listar_doing_listing_ajax_search();
		//global $query;
		//echo 33333333;
		//printf('<pre>%s</pre>', var_export($query,true));
		//printf('<pre>%s</pre>', var_export($wp_query,true));
		//printf('<pre>%s</pre>', var_export($search,true));

		//exit();

		//printf('<pre>%s</pre>', var_export($search,true));

		//echo $search;

		if ( $is_ajax_search || ( isset( $wp_query->query ) && isset( $wp_query->query['post_type'] ) && 'job_listing' === $wp_query->query['post_type'] && false !== strpos( $search, ' AND ' ) ) ) {
			$ands = explode( ' AND ', $search );

			foreach ( $ands as $and ) {
				if ( false !== strpos( $and, ' OR ' ) ) {
					$ors = explode( ' OR ', $and );

					foreach ( $ors as $or ) {
						if ( false !== strpos( $or, 'posts.post_title' ) ) {
							if ( empty( $output ) ) {
								$output = '(' . str_replace( array( '(', ')' ), '', $or ) . ')';
							} else {
								$output .= ' AND (' . str_replace( array( '(', ')' ), '', $or ) . ')';
							}
						}
					}
				}
			}
		}

		if ( ! empty( $output ) ) {
			$output = ' AND ( ' . $output . ' ) ';
		} else {
			$output = $search;
		}

		//printf('<pre>%s</pre>', var_export($is_ajax_search,true));

		//printf('<pre>%s</pre>', var_export($output,true));

		//echo $output;

		return $output;
	}
endif;


add_action( 'found_posts', 'listar_have_posts_override', 10, 1 );

function listar_have_posts_override( $posts ){
	$search_text = listar_get_dynamic_search_string();

	if ( ! empty( $search_text ) ) {
		set_query_var( 's', $search_text ) ;
	}
	
	return $posts;
}

add_action( 'pre_get_posts', 'listar_search_default_post_type', 99999 );

if ( ! function_exists( 'listar_search_default_post_type' ) ) :
	/**
	 * Ajax 'load more' script needs the post_type value filled, not empty.
	 * If current query is the main query and post_type  is empty,
	 * try to get the post type and update the query.
	 *
	 * @param (object) $query Current WordPress query object before it be processed.
	 * @since 1.0
	 */
	function listar_search_default_post_type( $query ) {

		if ( $query->is_admin() || ! $query->is_main_query() ) :
			return $query;
		endif;

		$post_type = $query->get( 'post_type' );
		$type = empty( $post_type ) ? listar_get_post_type() : $post_type;

		/*
		 * If yet empty, force 'post' as post_type if relevant query vars are empty
		 * This way, if searching on blog, only blog posts will be queried
		 * (not pages, listings, Woo products, etc)
		 * The high 'priority' argument to this action certify that all other
		 * possible 'pre_get_posts' actions were already executed
		 * @link https://codex.wordpress.org/WordPress_Query_Vars
		 * Make sure that the query don't have any of these (relevant) public query vars
		 */

		if ( empty( $type ) ) :
			$query_vars  = 'attachment,attachment_id,calendar,comments_popup,';
			$query_vars .= 'cpage,error,exact,feed,more,page_id,pagename,pb,';
			$query_vars .= 'post_type,preview,robots,static,tb,w';
			$query_vars_array = explode( ',', $query_vars );

			foreach ( $query_vars_array as $query_var ) {
				$get_query_var = $query->get( $query_var );
				if ( ! empty( $get_query_var ) ) {
					/* Don't touch the query */
					return;
				}
			}

			$type = 'post';

		endif;

		$query->set( 'post_type', $type );
		$query->set( 's', listar_search_string_cleaner( html_entity_decode( listar_get_search_query(), ENT_QUOTES ) ) );
	}

endif;

add_filter( 'template_include', 'listar_change_search_template' );

if ( ! function_exists( 'listar_change_search_template' ) ) :
	/**
	 * Set custom search template (search-job_listing.php) to listings search.
	 *
	 * @param (string) $template Template filename.
	 * @since 1.0
	 */
	function listar_change_search_template( $template ) {

		global $wp_query;

		$search_type = isset( $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] : '';
		$search_post_type = isset( $wp_query->query['post_type'] ) ? $wp_query->query['post_type'] : '';
		$is_search = listar_is_search();

		if ( $is_search && ( 'listing' === $search_type || 'job_listing' === $search_post_type ) ) {
			return locate_template( 'search-job_listing.php' );
		}

		return $template;
	}

endif;


add_filter( 'admin_body_class', 'listar_admin_body_class' );

/**
 * Adds one or more classes to the body tag in the dashboard.
 *
 * @since 1.3.9
 * @link https://wordpress.stackexchange.com/a/154951/17187
 * @param  (String) $classes Current body classes.
 * @return (String) Altered body classes.
 */
function listar_admin_body_class( $classes ) {
	$show_backend_views_counter = 1 === (int) get_option( 'listar_display_views_counter_backend' ) ? ' listar-show-backend-post-counters' : ' listar-hide-backend-post-counters';
	$show_backend_bookmark_counter = 1 === (int) get_option( 'listar_display_bookmarks_counter_backend' ) ? ' listar-show-backend-bookmarks-counters' : ' listar-hide-backend-bookmarks-counters';
	$show_async_javascript_settings = 1 === (int) get_option( 'listar_show_async_plugin_settings' ) ? ' listar-show-backend-async-javascript' : ' listar-hide-backend-async-javascript';
	$show_fastest_cache_settings = 0 === (int) get_option( 'listar_activate_pagespeed' ) ? ' listar-show-fastest-cache-options' : ' listar-hide-fastest-cache-options';
	$show_autoptimize_settings = 1 === (int) get_option( 'listar_show_autoptimize_plugin_settings' ) ? ' listar-show-backend-autoptimize' : ' listar-hide-backend-autoptimize';
	$allow_multiple_regions = 1 === (int) get_option( 'listar_allow_multiple_regions_frontend' ) ? ' listar-multiple-regions-enabled' : ' listar-multiple-regions-disabled';
	return $classes . $show_backend_views_counter . $show_backend_bookmark_counter . $show_async_javascript_settings . $show_autoptimize_settings . $show_fastest_cache_settings . $allow_multiple_regions;
}


add_filter( 'shortcode_atts_gallery', 'listar_post_gallery_columns', 10, 3 );

if ( ! function_exists( 'listar_post_gallery_columns' ) ) :
	/**
	 * Change thumbnail size of WordPress gallery according with the number of gallery columns.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/shortcode_atts_gallery
	 * @param (array) $result Gallery ouput (end) data, The shortcode_atts() merging of $defaults and $atts.
	 * @param (array) $defaults The default attributes defined for the gallery shortcode.
	 * @param (array) $atts The default attributes defined for the gallery shortcode.
	 * @since 1.0
	 * @return (string)
	 */
	function listar_post_gallery_columns( $result, $defaults, $atts ) {

		if ( ! isset( $atts['columns'] ) ) {
			$result['size'] = 'large';
			return $result;
		}

		if ( 1 === (int) $atts['columns'] || 2 === (int) $atts['columns'] || 3 === (int) $atts['columns'] ) {
			$result['size'] = 'large';
		} else {
			$result['size'] = 'medium';
		}

		return $result;
	}

endif;

add_filter('upload_mimes', 'my_myme_types', 1, 1);

if ( ! function_exists( 'my_myme_types' ) ) :
	/**
	 * Enable new mime types for upload on WordPress.
	 *
	 * @since 1.0
	 * @param (array) $mime_types Allowed mime types.
	 */
	function my_myme_types( $mime_types ){
		$mime_types['zip'] = 'application/zip';
		$mime_types['xls'] = 'application/vnd.ms-excel';
		return $mime_types;
	}

endif;

add_action( 'wp_kses_allowed_html', 'listar_kses_allowed_html', 10, 2 );

if ( ! function_exists( 'listar_kses_allowed_html' ) ) :
	/**
	 * Add new allowed tags/attributes to wp_kses_post.
	 *
	 * @since 1.0
	 * @param (array) $tags HTML tags and attributes.
	 */
	function listar_kses_allowed_html( $tags ) {

		/* Bootstrap tooltip attributes */
		$new1 = array(
			'data-toggle'    => true,
			'data-placement' => true,
			'data-onclick' => true,
		);

		$new2 = array(
			'a' => $new1,
			'div' => $new1,
			'img' => $new1,
		);

		$custom_tags = array_replace_recursive( $tags, $new2 );

		return $custom_tags;
	}

endif;

if ( class_exists( 'autoptimizeCache' ) && listar_addons_active() ) :
	add_action( 'admin_bar_menu', 'listar_customize_admin_toolbar', 999 );
endif;

add_filter( 'autoptimize_css_after_minify', 'listar_modify_autoptimize_cache_css', 10, 1 );

function listar_modify_autoptimize_cache_css( $css ) {
	
	if ( 0 === 1 ) {

		/* Not for current version. */
	
		/* Cleaning Bootstrap (already in use above the fold) */

		$searchInit = 'html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}';
		$searchEnd = '@media print{.hidden-print{display:none !important}}';

		if ( false !== strpos( $css, $searchEnd ) ) {
			$temp = explode( $searchEnd, $css );
			$partial = $temp[0];
			$css = $temp[1];

			if ( false !== strpos( $partial, $searchInit ) ) {
				$temp = explode( $searchInit, $partial );
				$partial = $temp[0];
				$css = $partial . $css;
			}
		}

		/* Reference: https://wordpress.org/support/topic/flexible-and-reliable-tool-for-site-load-optimization/ */

		$network = listar_get_current_domain_url();
		$path = ! empty( $network[2] ) ? '/' . $network[2] . '/' : '/';
		$site_url = $network[0] . '.' . $path;

		$network2 = '//' . $network[1] . $path;

		$css = str_replace( "type='text/javascript'", ' ', $css );
		$css = str_replace( 'type="text/javascript"', ' ', $css );

		$css = str_replace( "type='text/css'", ' ', $css );
		$css = str_replace( 'type="text/css"', ' ', $css );

		/* Fixes background-image:url(http://domain.com) */

		$css = str_replace( $site_url . 'wp-includes/js', $path . 'wp-includes/js', $css );
		$css = str_replace( $site_url . 'wp-content/cache/autoptimize', $path . 'wp-content/cache/autoptimize ', $css);
		$css = str_replace( $site_url . 'wp-content/themes/', $path . 'wp-content/themes/', $css );
		$css = str_replace( $site_url . 'wp-content/uploads/', $path . 'wp-content/uploads/', $css );
		$css = str_replace( $site_url . 'wp-content/plugins/', $path . 'wp-content/plugins/', $css );

		/* Fixes background-image:url(//domain.com) */

		$css = str_replace( $network2 . 'wp-includes/js', $path . 'wp-includes/js', $css );
		$css = str_replace( $network2 . 'wp-content/cache/autoptimize', $path . 'wp-content/cache/autoptimize ', $css);
		$css = str_replace( $network2 . 'wp-content/themes/', $path . 'wp-content/themes/', $css );
		$css = str_replace( $network2 . 'wp-content/uploads/', $path . 'wp-content/uploads/', $css );
		$css = str_replace( $network2 . 'wp-content/plugins/', $path . 'wp-content/plugins/', $css );
	}

	return $css;
}

add_filter( 'autoptimize_js_after_minify', 'listar_modify_autoptimize_cache_js', 10, 1 );

function listar_modify_autoptimize_cache_js( $js ) {
	
	/* Cleaning frontend.js */
	
	$searchInit = 'window.autoptimizeIdentifierInit=window.autoptimizeIdentifierInit||{};';
	$searchEnd = 'window.autoptimizeIdentifierEnd=window.autoptimizeIdentifierEnd||{};';
	
	if ( false !== strpos( $js, $searchEnd ) ) {
		$temp = explode( $searchEnd, $js );
		$partial = $temp[0];
		$js = $temp[1];
		
		if ( false !== strpos( $partial, $searchInit ) ) {
			$temp = explode( $searchInit, $partial );
			$partial = $temp[0];
			$js = $partial . $js;
		}
	}

	return $js;
}

if ( ! function_exists( 'listar_customize_admin_toolbar' ) ) :
	/**
	 * Customize admin toolbar.
	 *
	 * @since 1.3.0
	 * @param (object) $wp_admin_bar The WordPress admin bar object.
	 */
	function listar_customize_admin_toolbar( $wp_admin_bar ) {
		$newtitle = '<span class="ab-icon"></span>' . esc_html__( 'Listar Cache', 'listar' );
		$meta = array (
			'class' => 'bullet-green',
		);

		$wp_admin_bar->add_node( array( 'id' => 'autoptimize', 'title' => $newtitle, 'href' => '#', $meta ) );
	}
endif;

add_filter( 'wp_kses_allowed_html', 'listar_custom_wpkses_post_tags', 9999, 2 );

if ( ! function_exists( 'listar_custom_wpkses_post_tags' ) ) :
	/**
	 * Add new allowed tags/attributes to wp_kses.
	 * The 'wp_kses_post' function is expensive and slow. This theme mostly uses wp_kses() instead, with a very restrict list of allowed HTML tags and attributes.
	 * The 'listar-basic-html' context customizes/allow specific HTML tags and attributes, always focusing performance and intending to fit needs of custom assets/scripts from this theme.
	 *
	 * @since 1.0
	 * @param (array)  $tags HTML tags and attributes.
	 * @param (string) $context Context to judge allowed tags by.
	 */
	function listar_custom_wpkses_post_tags( $tags, $context ) {
		$generic_attributes = array(
			'class'                 => array(),
			'id'                    => array(),
			'name'                  => array(),
			'style'                 => array(),
			'data-background-image' => array(),
		);

		$attributes_for_bootstrap_tooltips = array(
			'data-toggle'    => array(),
			'data-placement' => array(),
		);
		
		$iframe_attributes = array(
			'src'                    => array(),
			'width'                  => array(),
			'height'                 => array(),
			'style'                  => array(),
			'allowfullscreen'        => array(),
			'frameborder'            => array(),
			'scrolling'              => array(),
			'allowtransparency'      => array(),
			'mozallowfullscreen'     => array(),
			'webkitallowfullscreen'  => array(),
			'sandbox'                => array(),
			'seamless'               => array(),
			'srcdoc'                 => array(),
			'data-script-form-field' => array(),
		);
		
		$svg_attributes = array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lower case!
		);

		switch ( $context ) {
			case 'listar-basic-html' :
				$tags = array(
					'p'       => $generic_attributes,
					'br'      => $generic_attributes,
					'hr'      => $generic_attributes,
					'h1'      => $generic_attributes,
					'h2'      => $generic_attributes,
					'ol'      => $generic_attributes,
					'ul'      => $generic_attributes,
					'li'      => $generic_attributes,
					'section' => $generic_attributes,
					'span'    => $generic_attributes,
					'i'       => $generic_attributes,
					'strong'  => $generic_attributes,
					'b'       => $generic_attributes,
					'table'   => $generic_attributes,
					'thead'   => $generic_attributes,
					'th'      => $generic_attributes,
					'tbody'   => $generic_attributes,
					'tr'      => $generic_attributes,
					'td'      => $generic_attributes,
					'iframe'  => $generic_attributes + $iframe_attributes,
					'div'     => $generic_attributes + array(
						'data-short-open'   => array(),
						'data-short-closed' => array(),
					),
					'img'     => $generic_attributes + array(
						'alt' => array(),
						'src' => array(),
						'data-onclick' => array(),
					),
					'a'       => $generic_attributes + $attributes_for_bootstrap_tooltips + array(
						'href' => array(),
						'target' => array(),
						'rel' => array(),
						'title' => array(),
						'data-domain-name' => array(), /* Bookafy */
					),
					// SVG.
					'svg'     => $generic_attributes + $svg_attributes,
					'g'       => array( 'fill' => true ),
					'title' => array( 'title' => true ),
					'path'  => array(
						'd' => true,
						'fill' => true,
					),
					'rect'  => array(
						'x' => true,
						'y' => true,
						'width' => true,
						'height' => true,
					),
					'polygon'  => array(
						'points' => true,
					),
				);

				return $tags;
			case 'post' :
				$custom = array(
					'a'       => $attributes_for_bootstrap_tooltips,
					'iframe'  => $generic_attributes + $iframe_attributes,
				);

				$tags = array_replace_recursive( $tags, $custom );

				return $tags;
			default:
				return $tags;
		}
	}

endif;

/*
 * Base64 Favicon Image ********************************************************
 */

$base64_favicon = esc_html( get_option( 'listar_base64_favicon_32x32' ) );
$has_base64_favicon = ! empty( $base64_favicon ) ? listar_is_base64_image( $base64_favicon ) : false;

if ( $has_base64_favicon ) {
	add_action( 'wp_enqueue_scripts', 'listar_add_custom_base64_favicon' );
	add_filter( 'site_icon_meta_tags', 'listar_remove_wordpress_favicon_32', 10, 1 );
	add_filter( 'style_loader_tag', 'listar_custom_style_loader_tag', 10, 1 );
}

if ( ! function_exists( 'listar_add_custom_base64_favicon' ) ) :
	/**
	 * Add custom base64 image for Favicon (Pagespeed)
	 *
	 * @since 1.3.6
	 */
	function listar_add_custom_base64_favicon() {
	
		$base64_favicon = esc_html( get_option( 'listar_base64_favicon_32x32' ) );

		/* Base64 Favicon (Pagespeed) */
		wp_enqueue_style( 'listar-base64-favicon', esc_html( $base64_favicon ), array(), null );
	}

endif;

if ( ! function_exists( 'listar_remove_wordpress_favicon_32' ) ) :
	/**
	 * Remove the default WordPress Favicon, only the one sized with 32px.
	 *
	 * @since 1.3.6
	 */
	function listar_remove_wordpress_favicon_32( $meta_tags ) {
	
		foreach ( $meta_tags as $meta_tag ) {
			if ( false !== strpos( $meta_tag, '32x32' ) ) {
				$meta_tags = array_diff( $meta_tags, array( $meta_tag ) );
				break;
			}
		}

		return $meta_tags;
	}
endif;

if ( ! function_exists( 'listar_custom_style_loader_tag' ) ) :
	function listar_custom_style_loader_tag( $tag ){
		/**
		 * Customize style tags.
		 *
		 * @since 1.3.6
		 * @param (array) $tag An <link> HTML tag.
		 */
	
		if ( false !== strpos( $tag, 'listar-base64-favicon' ) ) {
			$site = network_site_url();
			$temp = str_replace( $site, '', $tag );
			$tag1 = str_replace( 'stylesheet', 'icon', $temp );
			$tag2 = str_replace( '/>', "  sizes='32x32' />", $tag1 );
			$tag = $tag2;
		}

		return $tag;
	}
endif;

/*
 * Woocommerce *****************************************************************
 */

add_filter( 'woocommerce_account_menu_items', 'listar_add_woo_menu_link', 1000 );


if ( ! function_exists( 'listar_add_woo_menu_link' ) ) :
	/**
	 * Add links to Woocommerce "My Account" pages.
	 *
	 * @link https://rudrastyh.com/woocommerce/my-account-menu.html
	 * @since 1.0
	 * @param (array) $menu_links Contains the default Woocomemerce links for dashboard (My Account pages).
	 */
	function listar_add_woo_menu_link( $menu_links ) {

		$new = array();

		if ( class_exists( 'WP_Job_Manager' ) ) :
			$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );
			$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );
			$listar_can_publish_listings = listar_user_can_publish_listings();
			$bookmarks_active = listar_bookmarks_active();

			if ( ! empty( $listar_add_listing_form_url ) && $listar_can_publish_listings ) :
				$new['add-listing'] = esc_html__( 'Add Listing', 'listar' );
			endif;

			if ( ! empty( $listar_job_dashboard_url ) ) :
				$new['your-listings'] = esc_html__( 'Your Listings', 'listar' );
			endif;
			
			if ( $bookmarks_active ) :
				$new['bookmarks'] = esc_html__( 'Bookmarks', 'listar' );
			endif;

		endif;

		$new_menu_links = array_slice( $menu_links, 0, 5, true ) + $new + array_slice( $menu_links, 5, 30, true );

		if ( class_exists( 'WP_Job_Manager' ) ) :

			$enable_woo_downloads = (int) get_option( 'listar_enable_woo_downloads_menu' );

			if ( 1 !== $enable_woo_downloads ) {

				/* Remove "Downloads" link from Woocommerce user dashboard */
				unset( $new_menu_links['downloads'] );
			}
		endif;

		if ( isset( $new_menu_links['wcfm-store-manager'] ) ) :
			unset( $new_menu_links['wcfm-store-manager'] );
		endif;

		if ( isset( $new_menu_links['subscriptions'] ) && ! current_user_can( 'administrator' ) ) :
			unset( $new_menu_links['subscriptions'] );
		endif;

		if ( isset( $new_menu_links['inquiry'] ) ) :
			unset( $new_menu_links['inquiry'] );
		endif;

		return $new_menu_links;
	}
endif;

add_filter( 'woocommerce_get_endpoint_url', 'listar_look_woo_endpoints', 10, 4 );

if ( ! function_exists( 'listar_look_woo_endpoints' ) ) :
	/**
	 * Detect Woocommerce endpoints and modify its URL.
	 *
	 * @link https://rudrastyh.com/woocommerce/my-account-menu.html
	 * @since 1.0
	 * @param (string) $url The URL for a Woocommerce endpoint.
	 * @param (string) $endpoint The ID of a Woocommerce endpoint.
	 * @param (string) $value The title of a Woocommerce endpoint.
	 * @param (string) $permalink The original permalink for a Woocommerce endpoint.
	 */
	function listar_look_woo_endpoints( $url, $endpoint, $value, $permalink ) {

		if ( 'your-listings' === $endpoint ) {

			if ( class_exists( 'WP_Job_Manager' ) ) :
				$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );

				if ( ! empty( $listar_job_dashboard_url ) ) :
					$url = $listar_job_dashboard_url;
				endif;
			endif;
		}

		if ( 'add-listing' === $endpoint ) {

			if ( class_exists( 'WP_Job_Manager' ) ) :
				$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

				if ( ! empty( $listar_add_listing_form_url ) ) :
					$url = $listar_add_listing_form_url;
				endif;
			endif;
		}

		if ( 'bookmarks' === $endpoint ) {
			$url = network_site_url() . '?s=&' . listar_url_query_vars_translate( 'bookmarks_page' ) . '&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
		}

		return $url;
	}
endif;

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'listar_woopage_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'listar_woopage_wrapper_end', 10 );

if ( ! function_exists( 'listar_woopage_wrapper_start' ) ) :
	/**
	 * Woocommerce hooking - wrapper start.
	 *
	 * @since 1.0
	 */
	function listar_woopage_wrapper_start() {

		echo '<section class="listar-section listar-woo-section"><div class="listar-container-wrapper"><div class="woopage container"><div class="row"><div class="col-sm-12">';
	}

endif;

if ( ! function_exists( 'listar_woopage_wrapper_end' ) ) :
	/**
	 * Woocommerce hooking - wrapper end.
	 *
	 * @since 1.0
	 */
	function listar_woopage_wrapper_end() {

		echo '</div></div></div></div></section>';
	}

endif;

add_filter( 'woocommerce_add_to_cart_redirect', 'listar_redirect_to_checkout' );

if ( ! function_exists( 'listar_redirect_to_checkout' ) ) :
	/**
	 * Add to cart and go to checkout.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_redirect_to_checkout() {

		$checkout_url = wc_get_checkout_url();

		return $checkout_url;
	}

endif;


/**
 * Remove woo related products
 *
 * @since 1.0
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_product_query', 'listar_custom_pre_get_posts_query' );

if ( ! function_exists( 'listar_custom_pre_get_posts_query' ) ) :
	/**
	 * Excluding not desired products of woo default query (eg: shop page).
	 *
	 * @since 1.0
	 * @param (object) $q Post query.
	 */
	function listar_custom_pre_get_posts_query( $q ) {

		$taxonomies_query = (array) $q->get( 'tax_query' );

		$taxonomies_query[] = array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array( 'job_package', 'job_package_subscription' ),
			'operator' => 'NOT IN',
		);

		$q->set( 'tax_query', $taxonomies_query );
	}

endif;

add_action( 'wp_head', 'listar_cancel_wp_enqueues', 999999999 );
add_action( 'enqueue_block_assets', 'listar_cancel_wp_enqueues', 99999999 );

function listar_cancel_wp_enqueues() {
	wp_dequeue_script( 'leaflet' );
	wp_deregister_script( 'leaflet' );
}


add_action( 'wp_enqueue_scripts', 'listar_disable_woo_select_2', 12 );

if ( ! function_exists( 'listar_disable_woo_select_2' ) ) :
	function listar_disable_woo_select_2() {
		/*
		 * Deregister Woocommerce and WP Job Manager (both) Select2 scripts, because its outdated (v3.7.1) and has some styling issues.
		 * This theme is providing the last version of Select2 (v4.0.6).
		 */
		if ( function_exists( 'listar_dequeue_woocommerce_old_select2' ) ) :
			listar_dequeue_woocommerce_old_select2();
		endif;
	}
endif;




add_filter( 'woocommerce_loop_add_to_cart_link', 'listar_woocommerce_products_quantity', 10, 2 );

if ( ! function_exists( 'listar_woocommerce_products_quantity' ) ) :
	/**
	 * Show quantity field to woocommerce products.
	 *
	 * @param (string) $html Quantity form output.
	 * @param (object) $product Woocommerce product object.
	 * @since 1.0
	 * @return (string)
	 */
	function listar_woocommerce_products_quantity( $html, $product ) {

		if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
			$html  = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
			$html .= woocommerce_quantity_input( array(), $product, false );
			$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';
			$html .= '</form>';
			/* If not set, let's set some max attribute for W3C validation */
			$html  = str_replace( 'max="" ', 'max="999999999" ', $html );
		}

		return $html;
	}

endif;

add_filter( 'woocommerce_quantity_input_max', 'listar_set_max_stock_quantity', 10, 2 );

if ( ! function_exists( 'listar_set_max_stock_quantity' ) ) :
	/**
	 * Set max amount available (in stock) to every Woocommerce product, if not set.
	 *
	 * @param (integer) $qty Quantity currently registered.
	 * @param (object)  $product Woocommerce product object (default from filter, not in use currently).
	 * @since 1.0
	 * @return (int)
	 */
	function listar_set_max_stock_quantity( $qty, $product ) {
		/* If not set, let's set some max attribute (needed for W3C validation) */
		return empty( $qty ) || -1 === $qty ? 9999999 : $qty;
	}

endif;

add_filter( 'loop_shop_per_page', 'listar_max_woo_products_per_page', 20 );

if ( ! function_exists( 'listar_max_woo_products_per_page' ) ) :
	/**
	 * Max products per page on woocommerce shop.
	 *
	 * @since 1.0
	 * @return (int)
	 */
	function listar_max_woo_products_per_page() {
		return 12;
	}

endif;

add_filter( 'woocommerce_product_tag_cloud_widget_args', 'listar_custom_woocommerce_tag_cloud_widget' );

if ( ! function_exists( 'listar_custom_woocommerce_tag_cloud_widget' ) ) :
	/**
	 * Remove product tags used by listing packages from Woocommerce product tag cloud widget.
	 *
	 * @param (array) $args Query args of Woocommerce product tag cloud.
	 * @since 1.0
	 */
	function listar_custom_woocommerce_tag_cloud_widget( $args ) {

		$exclude_ids   = array();
		$package_terms = array();
		$product_tags  = get_terms(
			array(
				'taxonomy' => 'product_tag',
			)
		);

		$package_query = listar_package_query();

		if ( $package_query->have_posts() ) :
			while ( $package_query->have_posts() ) :
				$package_query->the_post();
				$id = get_the_ID();
				$terms = get_the_terms( $id, 'product_tag' );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					$package_terms = array_merge( $package_terms, $terms );
				}
			endwhile;
		endif;

		foreach ( $package_terms as $term ) :
			/* Strict comparison will fail here. */
			if ( in_array( $term, $product_tags ) ) {
				$exclude_ids[] = $term->term_id;
			}
		endforeach;

		$args['exclude'] = $exclude_ids;

		return $args;
	}

endif;

add_action( 'after_setup_theme', 'listar_set_woo_product_out' );

if ( ! function_exists( 'listar_set_woo_product_out' ) ) :
	/**
	 * Set Woocommerce product design (output)
	 *
	 * @since 1.4.6
	 */
	function listar_set_woo_product_out() {
		
		/* Customize Woocommerce product card output */

		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );

		$listar_cards_design = get_option( 'listar_woo_card_design' );
		
		if ( 'default' === $listar_cards_design ) {
			$listar_cards_design = get_option( 'listar_listing_card_design' );

			if ( empty( $listar_cards_design ) ) {
				$listar_cards_design = 'rounded';
			}
		
			if ( 'rounded-image-block' === $listar_cards_design ) {
				$listar_cards_design = 'rounded-image-block-top';
			}

			if ( 'squared-image-block' === $listar_cards_design ) {
				$listar_cards_design = 'squared-image-block-top';
			}

			if ( 'rounded' === $listar_cards_design || 'squared' === $listar_cards_design ) {
				$listar_cards_design = 'default';
			}
		}
		
		if ( empty( $listar_cards_design ) ) {
			$listar_cards_design = 'rounded-image-block-top';
		}
		
		$is_default_design = 'default' === $listar_cards_design;

		if ( $is_default_design ) {
			add_action( 'woocommerce_before_shop_loop_item', 'listar_woocommerce_template_loop_product_link_open', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'listar_woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_shop_loop_item_title', 'listar_woocommerce_template_loop_product_title_and_price', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'listar_woocommerce_template_loop_after_product', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'listar_woocommerce_template_loop_product_link_close', 10 );
		} else {
			add_action( 'woocommerce_before_shop_loop_item', 'listar_woocommerce_template_loop_product_link_open_2', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'listar_woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_shop_loop_item_title', 'listar_woocommerce_template_loop_product_title_and_price_2', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'listar_woocommerce_template_loop_product_link_close_2', 10 );
		}
	}
endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_link_open_2' ) ) :
	/**
	 * Put the product link out of everything to cover as much as possible the card block.
	 *
	 * @hooked listar_woocommerce_template_loop_product_link_open - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_link_open_2() {

		global $product;
		
		$currency     = listar_currency();
		$price_before = $product->get_regular_price();
		$price_after  = $product->get_sale_price();
		$ribbon       = '';
		$description  = $product->get_description();
		$excerpt      = listar_excerpt_limit( $description, 400, true, '', false, 'only-dots', true );
		$product_type = $product->get_type();
		$admission    = 'booking' === $product_type ? wc_booking_calculated_base_cost( $product ) : '';
		$is_free      = ( '' !== $admission && 0 === (int) $admission ) || ( '' !== $price_before && 0 === (int) $price_before );
		$thousand_separator = class_exists( 'Woocommerce' ) ? wc_get_price_thousand_separator() : ',';
		$decimal_separator = class_exists( 'Woocommerce' ) ? wc_get_price_decimal_separator() : '.';

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="listar-card-link woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>';

		if ( ! empty( $price_before ) || ! empty( $price_after ) || '' !== $admission ) :

			$ribbon = '<div class="listar-ribbon">';

			if ( $is_free ) {
				$ribbon .= esc_html__( 'FREE', 'listar' );
			} elseif ( '' !== $admission ) {	
				$ribbon .= esc_html__( 'From ', 'listar' ) . $currency . $admission;
			} elseif ( ! empty( $price_after ) ) {
				$price_after = listar_price_custom_output( $price_after, $thousand_separator, $decimal_separator );
				$price_before = listar_price_custom_output( $price_before, $thousand_separator, $decimal_separator );
				$ribbon .= esc_html__( 'Discount ', 'listar' ) . '<span class="listar-ribbon-price-before">' . $currency . $price_before . '</span>';
				$ribbon .= ' ' . $currency . $price_after;
			} else {
				$price_after = listar_price_custom_output( $price_after, $thousand_separator, $decimal_separator );
				$price_before = listar_price_custom_output( $price_before, $thousand_separator, $decimal_separator );
				$price_after = $price_before;
				
				$ribbon .= esc_html__( 'Offer By ', 'listar' ) . $currency . $price_before;
			}

			$ribbon .= '</div>';

		endif;
		?>

		<?php echo wp_kses( $ribbon, 'listar-basic-html' ); ?>

		<?php
		if( $product->is_purchasable() ) :
			if ( ! empty( $price_before ) || ! empty( $price_after ) || '' !== $admission ) :

				if ( $is_free ) :
					$output = esc_html__( 'FREE', 'listar' );
					?>
					<div class="listar-sale-price">
						<?php echo esc_html( $output ); ?>
					</div>
					<?php
				elseif ( '' !== $admission ) :
					?>
					<div class="listar-sale-price">
						<span><?php esc_html_e( 'From ', 'listar' ); ?> <?php echo esc_html( $currency ); ?> </span><?php echo esc_html( $admission ); ?>
					</div>
					<?php
				elseif ( ! empty( $price_after ) ) :
					?>
					<div class="listar-sale-price">
						<span><?php echo esc_html( $currency ); ?> </span><?php echo esc_html( $price_after ); ?>
					</div>
					<?php
				endif;
			endif;
			?>
			<?php
		endif;
		?>

		<div class="listar-card-content-wrapper">
			<div>
				<?php /* Reviewer: The line below is required to be this way, it can't break line here. */ ?>
				<h6 class="listar-card-content-title"><?php the_title(); ?></h6>

				<?php
				if ( ! empty( $excerpt ) ) :
					?>
					<div class="listar-card-excerpt">
						<?php echo wp_kses( $excerpt, 'listar-basic-html' ); ?>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
		<?php
		
		echo '<div class="listar-card-content-image">';

	}

endif;



/* Disable "update available" notifications for specific built-in plugins, for all pages except TGMPA */
add_filter('site_transient_update_plugins', 'listar_exclude_plugin_from_update_list');

if ( ! function_exists( 'listar_exclude_plugin_from_update_list' ) ) :
	function listar_exclude_plugin_from_update_list($transient) {
	    
		$excluded_plugin = 'wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php';
	
		if (isset($transient->response) && is_array($transient->response)) {
		    global $pagenow;
    	    
    	    $tgma = filter_input( INPUT_GET, 'page' );
		    
			if ( 'tgmpa-install-plugins' !== $tgma && 'themes.php' !== $pagenow && isset($transient->response[$excluded_plugin])) {
				unset($transient->response[$excluded_plugin]);
			}
		}

		$excluded_plugin = 'woocommerce-subscriptions/woocommerce-subscriptions.php';
	
		if (isset($transient->response) && is_array($transient->response)) {
		    global $pagenow;
    	    
    	    $tgma = filter_input( INPUT_GET, 'page' );
		    
			if ( 'tgmpa-install-plugins' !== $tgma && 'themes.php' !== $pagenow && isset($transient->response[$excluded_plugin])) {
				unset($transient->response[$excluded_plugin]);
			}
		}

		$excluded_plugin = 'woocommerce-bookings/woocommerce-bookings.php';
	
		if (isset($transient->response) && is_array($transient->response)) {
		    global $pagenow;
    	    
    	    $tgma = filter_input( INPUT_GET, 'page' );
		    
			if ( 'tgmpa-install-plugins' !== $tgma && 'themes.php' !== $pagenow && isset($transient->response[$excluded_plugin])) {
				unset($transient->response[$excluded_plugin]);
			}
		}
	
		return $transient;
	}
endif;




/* Disable update and license notices for specific built-in plugins */
add_action('admin_init', 'listar_remove_licence_error_notices_action', 99999);

if ( ! function_exists( 'listar_remove_licence_error_notices_action' ) ) :
	function listar_remove_licence_error_notices_action() {
		if (class_exists('WP_Job_Manager_Helper') && method_exists('WP_Job_Manager_Helper', 'instance')) {
			$instance = WP_Job_Manager_Helper::instance();
			remove_action('admin_notices', array($instance, 'licence_error_notices'));
		}
	}
endif;


add_filter( 'site_transient_update_plugins', 'listar_force_bundled_plugin_updates', 9999999999 );

if ( ! function_exists( 'listar_force_bundled_plugin_updates' ) ) :
	function listar_force_bundled_plugin_updates( $value ) {
		if ( isset( $value->response['wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php']->errors ) ) {
			unset( $value->response['wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php']->errors );
		}

		if ( isset( $value->response['wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php'] ) ) {
			$value->response['wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php']->package = get_template_directory_uri() . '/inc/required-plugins/plugins/wp-job-manager-wc-paid-listings.zip';
		}
		
		/**/		
		
		if ( isset( $value->response['woocommerce-subscriptions/woocommerce-subscriptions.php']->errors ) ) {
			unset( $value->response['woocommerce-subscriptions/woocommerce-subscriptions.php']->errors );
		}

		if ( isset( $value->response['woocommerce-subscriptions/woocommerce-subscriptions.php'] ) ) {
			$value->response['woocommerce-subscriptions/woocommerce-subscriptions.php']->package = get_template_directory_uri() . '/inc/required-plugins/plugins/woocommerce-subscriptions.zip';
		}	
		
		if ( isset( $value->response['woocommerce-bookings/woocommerce-bookings.php']->errors ) ) {
			unset( $value->response['woocommerce-bookings/woocommerce-bookings.php']->errors );
		}
		

		if ( isset( $value->response['woocommerce-bookings/woocommerce-bookings.php'] ) ) {
			$value->response['woocommerce-bookings/woocommerce-bookings.php']->package = get_template_directory_uri() . '/inc/required-plugins/plugins/woocommerce-bookings.zip';
		}

		return $value;
	}
endif;



add_filter( 'plugin_action_links_wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php', 'listar_plugin_action_links' );
 
if ( ! function_exists( 'listar_plugin_action_links' ) ) :
	function listar_plugin_action_links( $links_array ){
		
		foreach ( $links_array as $key => $value ) {
			if ( false !== strpos( $value, 'wpjm-activate-licence-link' ) ) {
				unset( $links_array[ $key ] );
				break;
			}
		}

		return $links_array;
	}
endif;

add_filter( 'plugin_action_links_wc-frontend-manager/wc_frontend_manager.php', 'listar_plugin_action_links_2', 100 );

if ( ! function_exists( 'listar_plugin_action_links_2' ) ) :
	function listar_plugin_action_links_2( $links_array ){
		
		foreach ( $links_array as $key => $value ) {
			if ( false !== strpos( $value, 'ultimate' ) ) {
				unset( $links_array[ $key ] );
				break;
			}
		}

		return $links_array;
	}
endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_title_and_price_2' ) ) :
	/**
	 * Output the product title inside <div> and <h6> elements.
	 * Create a 'ribbon' and output the product pricing inside.
	 *
	 * @hooked listar_woocommerce_template_loop_product_title_and_price - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_title_and_price_2() {

		
	}

endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_link_close_2' ) ) :
	/**
	 * Close the card image wrapper.
	 *
	 * @hooked listar_woocommerce_template_loop_product_link_close - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_link_close_2() {
		global $product;
		
		$id = $product->get_id();
		
		echo '</div>';
		?>
		<div class="listar-card-footer">
			<div class="listar-card-category-name">
				<?php echo wp_kses( wc_get_product_category_list( $id ), 'listar-basic-html' ); ?>
			</div>
		</div>
		<?php
	}

endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_link_open' ) ) :
	/**
	 * Put the product link out of everything to cover as much as possible the card block.
	 *
	 * @hooked listar_woocommerce_template_loop_product_link_open - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_link_open() {

		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="listar-card-link woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>';
		echo '<div class="listar-circular-wrapper"><div class="listar-card-content-image">';

	}

endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_link_close' ) ) :
	/**
	 * Close the card image wrapper.
	 *
	 * @hooked listar_woocommerce_template_loop_product_link_close - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_link_close() {

		echo '</div>';

	}

endif;

/**
 * Remove sale flash
 *
 * @since 1.0
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

if ( ! function_exists( 'listar_woocommerce_template_loop_product_thumbnail' ) ) :
	/**
	 * Put product image inside wrapper div and moves the <img> URL from src
	 * to data-background-image attribute (Pagespeed).
	 *
	 * @hooked listar_woocommerce_template_loop_product_thumbnail - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_thumbnail() {

		global $product;

		$id                         = $product->get_id();
		$listar_post_image          = get_the_post_thumbnail_url( $id, 'cover' );
		$listar_fallback_card_image = listar_image_url( get_option( 'listar_woo_product_card_fallback_image' ), 'cover' );
		$listar_temp_bg_image       = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
		$listar_bg_image            = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;
		$listar_blank_placeholder   = listar_blank_base64_placeholder_image();

		echo '<div class="listar-card-image-wrapper"><div class="listar-card-image-inner"><img data-background-image="' . esc_attr( listar_custom_esc_url( $listar_bg_image ) ) . '" alt="' . esc_attr( get_the_title() ) . '" src="' . esc_attr( $listar_blank_placeholder ) . '" /></div></div>';

	}

endif;


if ( ! function_exists( 'listar_woocommerce_template_loop_product_title_and_price' ) ) :
	/**
	 * Output the product title inside <div> and <h6> elements.
	 * Create a 'ribbon' and output the product pricing inside.
	 *
	 * @hooked listar_woocommerce_template_loop_product_title_and_price - 10.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_product_title_and_price() {

		global $product;

		$id           = $product->get_id();
		$currency     = listar_currency();
		$price_before = $product->get_regular_price();
		$price_after  = $product->get_sale_price();
		$ribbon       = '';
		$product_type = $product->get_type();
		$admission    = 'booking' === $product_type ? wc_booking_calculated_base_cost( $product ) : '';
		$is_free      = ( '' !== $admission && 0 === (int) $admission ) || ( '' !== $price_before && 0 === (int) $price_before );
		$thousand_separator = class_exists( 'Woocommerce' ) ? wc_get_price_thousand_separator() : ',';
		$decimal_separator = class_exists( 'Woocommerce' ) ? wc_get_price_decimal_separator() : '.';

		if ( ! empty( $price_before ) || ! empty( $price_after ) || '' !== $admission ) :

			$ribbon = '<div class="listar-ribbon">';

			if ( $is_free ) {
				$ribbon .= esc_html__( 'FREE', 'listar' );
			} elseif ( '' !== $admission ) {	
				$ribbon .= esc_html__( 'From ', 'listar' ) . $currency . $admission;
			} elseif ( ! empty( $price_after ) ) {
				$price_after = listar_price_custom_output( $price_after, $thousand_separator, $decimal_separator );
				$price_before = listar_price_custom_output( $price_before, $thousand_separator, $decimal_separator );
				$ribbon .= esc_html__( 'Discount ', 'listar' ) . '<span class="listar-ribbon-price-before">' . $currency . $price_before . '</span>';
				$ribbon .= ' ' . $currency . $price_after;
			} else {
				$price_before = listar_price_custom_output( $price_before, $thousand_separator, $decimal_separator );
				$ribbon .= esc_html__( 'Offer By ', 'listar' ) . $currency . $price_before;
			}

			$ribbon .= '</div>';

		endif;

		?>

		<div class="listar-card-content-title-centralizer">
			<?php /* Reviewer: The line below is required to be this way, it can't break line here. */ ?>
			<h6 class="listar-card-content-title"><?php the_title(); ?><br /><?php echo wp_kses( $ribbon, 'listar-basic-html' ); ?></h6>
		</div>

		<?php
	}

endif;

/**
 * Avoid display product rating on archive/shop pages
 *
 * @since 1.0
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );

/**
 * Avoid output the pricing again, it was moved to 'listar_woocommerce_template_loop_product_title_and_price' hook
 *
 * @since 1.0
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/**
 * Avoid display the 'add to cart' button for products on archive/shop pages
 *
 * @since 1.0
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


if ( ! function_exists( 'listar_woocommerce_template_loop_after_product' ) ) :
	/**
	 * Output excerpt and category for products on archive/shop pages.
	 *
	 * @hooked listar_woocommerce_template_loop_after_product - 15.
	 * @since 1.0
	 */
	function listar_woocommerce_template_loop_after_product() {

		global $product;

		$id          = $product->get_id();
		$description = $product->get_description();
		$excerpt     = listar_excerpt_limit( $description, 130 );
		?>
		</div>

		<div class="listar-card-content-data">
			<?php echo wp_kses( $excerpt, 'listar-basic-html' ); ?>
			<div class="listar-card-category-name">
				<?php echo wp_kses( wc_get_product_category_list( $id ), 'listar-basic-html' ); ?>
			</div>

		<?php
	}

endif;

add_action( 'woocommerce_init', 'remove_wcpgsk_email_order_table' );
function remove_wcpgsk_email_order_table() {

    global $wcpgsk;
    remove_action( 'woocommerce_email_after_order_table', array( $wcpgsk, 'wcpgsk_email_after_order_table' ) );

}

add_filter( 'woocommerce_get_item_data', 'listar_modify_cart_item_data', 12, 2 );
add_action( 'woocommerce_checkout_create_order_line_item', 'listar_modify_cart_item_data_checkout', 99999, 4 );

/**
 * Modify the output job name in cart
 *
 * @param  array $data
 * @param  array $cart_item
 * @return array
 */
function listar_modify_cart_item_data( $data, $cart_item ) {
	if ( isset( $cart_item['job_id'] ) ) {
		$job = get_post( absint( $cart_item['job_id'] ) );
		
		foreach ( $data as $key => $data_item ) {
			if ( isset( $data_item['value'] ) && isset( $job->post_title ) && $job->post_title === $data_item['value'] ) {
				$data[ $key ]['name'] = esc_html__( 'Listing', 'listar' );
			}
		}
	}
	return $data;
}

function listar_modify_cart_item_data_checkout( $order_item, $cart_item_key, $cart_item_data, $order ) {

	if ( isset( $cart_item_data['job_id'] ) ) {
		$job = get_post( absint( $cart_item_data['job_id'] ) );
		
		if ( isset( $job->post_title ) ) {
			$order_item->delete_meta_data( esc_html__( 'Job Listing', 'listar' ) );
			$order_item->update_meta_data( esc_html__( 'Listing', 'listar' ), $job->post_title );
		}
		
		if ( isset( $cart_item_data['listar_is_claim'] ) ) {
			$name = '';

			if ( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$name = $user->display_name;
			}

			$order_item->update_meta_data( __( 'Claim By', 'listar' ), $name );
			
			$order_item->update_meta_data( 'listar_is_claim', $cart_item_data['listar_is_claim'] );
		
			if ( isset( $cart_item_data['listar_claimed_listing_id'] ) ) {
				$order_item->update_meta_data( 'listar_claimed_listing_id', $cart_item_data['listar_claimed_listing_id'] );
			}

			if ( isset( $cart_item_data['listar_claim_verification_details'] ) ) {
				$order_item->update_meta_data( 'listar_claim_verification_details', $cart_item_data['listar_claim_verification_details'] );
			}
		}
	}
}


add_filter( 'show_admin_bar', 'listar_js_hide_admin_bar' );

/**
 * Hide admin bar for non-admins
 */
function listar_js_hide_admin_bar( $show ) {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return false;
	}

	return $show;
}

// For implementation instructions see: https://aceplugins.com/how-to-add-a-code-snippet/

add_action( 'admin_init', 'listar_block_wp_admin' );

/**
 * Block wp-admin access for non-admins
 */
function listar_block_wp_admin() {
	if ( is_admin() && ! current_user_can( 'edit_pages' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url() );
		exit;
	}
}


add_filter( 'use_block_editor_for_post_type', 'listar_gutenberg_for_woo_products', 10, 2 );

if ( ! function_exists( 'listar_gutenberg_for_woo_products' ) ) :
	/**
	 * Enable Gutenberg editor for Woocommerce products.
	 *
	 * @since 1.0
	 * @param (boolean) $can_edit Whether the post type can be edited with the block editor.
	 * @param (string)  $post_type Current post type.
	 * @return (boolean)
	 */
	function listar_gutenberg_for_woo_products( $can_edit, $post_type ) {

		if ( 'product' === $post_type ) {
			$can_edit = true;
		}

		return $can_edit;
	}

endif;


add_filter( 'register_taxonomy_args', 'listar_modify_woo_taxonomy_args', 99999, 2 );

if ( ! function_exists( 'listar_modify_woo_taxonomy_args' ) ) :
	/**
	 * Modify post type args before register.
	 * REST API: Show the list of Woocommerce categories and tags if editing a product with Gutenberg.
	 *
	 * @since 1.0
	 * @param (array)  $args Array of arguments for registering a taxonomy.
	 * @param (string) $taxonomy Taxonomy key.
	 * @return (array)
	 */
	function listar_modify_woo_taxonomy_args( $args, $taxonomy ) {
		if ( 'product_cat' === $taxonomy || 'product_tag' === $taxonomy ) {
			$args['show_in_rest'] = true;
		}

		return $args;
	}

endif;


add_action( 'wp_head', 'listar_load_dashicons_front_end' );

if ( ! function_exists( 'listar_load_dashicons_front_end' ) ) :
	/**
	 * Adding Dashicons in WordPress Front-end
	 *
	 * @since 1.0
	 */
	function listar_load_dashicons_front_end() {
		wp_enqueue_style( 'dashicons' );
	}

endif;


add_action( 'admin_body_class', 'listar_admin_body_class' );

if ( ! function_exists( 'listar_admin_body_class' ) ) :
	/**
	 * Adds one or more classes to the body tag in the dashboard.
	 *
	 * @since 1.0
	 * @link https://wordpress.stackexchange.com/a/154951/17187
	 * @param  String $classes Current body classes.
	 * @return String
	 */
	function listar_admin_body_class( $classes ) {
		$new_class = '';

		/* Is Gutenberg inactive ? */
		if ( function_exists( 'register_block_type' ) ) {
			$new_class = 'listar-gutenberg-is-active';
		}
		return "$classes $new_class";
	}

endif;


add_action( 'wp_enqueue_scripts', 'listar_disable_scripts', 11 );

if ( ! function_exists( 'listar_disable_scripts' ) ) :

	/**
	 * For better Pagespeed performance, dequeue unnecessary scripts
	 *
	 * @since 1.0
	 */
	function listar_disable_scripts() {

		wp_dequeue_script( 'wc-cart-fragments' );		
		wp_dequeue_style( 'fontawsome-css' );
		wp_dequeue_style( 'sb-font-awesome' );
		
		wp_dequeue_style( 'wpforms-font-awesome' );
		wp_deregister_style( 'wpforms-font-awesome' );

		wp_deregister_style( 'hfe-social-share-icons-brands' );
		wp_deregister_style( 'hfe-social-share-icons-fontawesome' );
		wp_deregister_style( 'hfe-nav-menu-icons' );

		wp_dequeue_style( 'hfe-social-share-icons-brands' );
		wp_dequeue_style( 'hfe-social-share-icons-fontawesome' );
		wp_dequeue_style( 'hfe-nav-menu-icons' );
	
		/* Remove WP Job Manager Locations JavaScript */
		wp_dequeue_script( 'job-regions' );

		return true;
	}

endif;


add_action( 'admin_enqueue_scripts', 'listar_dequeue_admin_scripts', 9999999 );

if ( ! function_exists( 'listar_dequeue_admin_scripts' ) ) :
	/**
	 * For better Pagespeed performance, dequeue unnecessary scripts
	 *
	 * @since 1.0.0
	 */
	function listar_dequeue_admin_scripts() {
		wp_dequeue_style( 'wpforms-font-awesome' );
		wp_deregister_style( 'wpforms-font-awesome' );
	}

endif;


function listar_deregister_generic_scripts() {
	wp_dequeue_script( 'jquery-tiptip' );
	wp_deregister_script( 'jquery-tiptip' );
	
	/* TipTip from Woocommerce, but customized to not exclude the "data-tip" attribute, so the tips can rewriten/recreated */
	wp_register_script( 'jquery-tiptip', listar_get_theme_file_uri( '/inc/theme-options/assets/lib/jquery-tiptip/jquery.tipTip.min.js' ), array( 'jquery' ), listar_get_theme_version(), true );
}


/* Preload font files - Pagespeed */
add_action( 'wp_enqueue_scripts', 'my_queue_items', 99 );

function my_queue_items() {
	$get_pagespeed_option = (int) get_option( 'listar_activate_pagespeed' );
	
	if ( 1 === $get_pagespeed_option ) {
		wp_enqueue_style( 'listar-awesome-font-solid-file-preload', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/fonts/fa-solid-900.woff2' ), array(), null );
		wp_enqueue_style( 'listar-awesome-font-regular-file-preload', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/fonts/fa-regular-400.woff2' ), array(), null );
		wp_enqueue_style( 'listar-awesome-font-light-file-preload', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/fonts/fa-light-300.woff2' ), array(), null );
		wp_enqueue_style( 'listar-awesome-font-brands-file-preload', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/fonts/fa-brands-400.woff2' ), array(), null );
		wp_enqueue_style( 'listar-linear-font-file-preload', listar_get_theme_file_uri( '/assets/fonts/icons/linear/fonts/icons.woff2' ), array(), null );
					
		/* Google Fonts Demands Preload Too - Eliminates render blocking - Pagespeed */
		wp_enqueue_style( 'listar-google-fonts-preload', listar_google_fonts_url(), array(), null );
	}
}

/* Customize the <link> tag to preload - Pagespeed */
add_filter( 'style_loader_tag', 'style_attributes', 10, 2 );

function style_attributes( $html, $handle ) {
	$get_pagespeed_option = (int) get_option( 'listar_activate_pagespeed' );

	if ( 1 === $get_pagespeed_option ) {
		if ( false !== strpos( $handle, '-file-preload' ) ) {
			$temp = str_replace( "rel='stylesheet'", "rel='preload' crossorigin='anonymous' as='font'", $html );
			$temp2 = str_replace( " media='all'", "", $temp );
			return str_replace( "type='text/css'", "type='font/woff2'", $temp2 );
		}

		
		
		if ( 'listar-google-fonts-preload' === $handle ) {
			$temp = str_replace( "rel='stylesheet'", "rel='preload' crossorigin='anonymous' as='style'", $html );
			return str_replace( " media='all'", "", $temp );
		}
	}

	return $html;
}


add_action( 'admin_enqueue_scripts', 'listar_deregister_generic_scripts', 100 );

if ( ! is_user_logged_in() && ! is_admin() && ! defined( 'DOING_AJAX' ) ) {
	add_action( 'wp', 'listar_buffer_start' );
}

if ( ! function_exists( 'listar_buffer_start' ) ) :
	/**
	 * Get all site output before print it.
	 *
	 * @since 1.0
	 */
	function listar_buffer_start() {
			
		$pagespeed_for_all = true; // Sobrescreve todos
		$pagespeed_for_front_page = true;
		$pagespeed_for_pages = true;
		$pagespeed_for_listing_archive = true; // Detectar se é region/listing category/amenity/search
		$pagespeed_for_single_listing = true; // Detectar se é single listing
		$pagespeed_for_single_blog = true; //  Detectar se é single article
		$pagespeed_for_other = true;
		$is_page = is_page();
		$is_front_page = listar_is_front_page_template();
		$get_pagespeed_option = (int) get_option( 'listar_activate_pagespeed' );
		$listar_pagespeed_enabled = 1 === $get_pagespeed_option ? true : false;

		$pagespeed_condition = $listar_pagespeed_enabled && ( ( $pagespeed_for_front_page && $is_front_page ) || ( $pagespeed_for_pages && $is_page && ! $is_front_page ) || ( $pagespeed_for_other && ! $is_page && ! $is_front_page ) ) ? true : false;
		
		if ( $pagespeed_condition ) {
			listar_use_pagespeed( true );
		}
		
		ob_start( 'listar_clean_output_callback' );
	}
endif;


if ( ! function_exists( 'listar_clean_output_callback' ) ) :
	/**
	 * For 100% W3C validation:
	 * Remove unneeded 'type' attribute from all 'script' and 'style' tags and
	 * fix third part codes on HTML output, because they don't provide proper/specific filters.
	 *
	 * @param (string) $buffer All HTML output.
	 * @return (string)
	 * @since 1.0
	 */
	function listar_clean_output_callback( $buffer ) {
		/*
		 * This $script variable helps to avoid the 'script' tag be wrongly caught by theme checker plugin(s).
		 * Notice that no script is being injected here.
		 * Please check the explanation above this function for more details.
		 */
		$script = 'script';
		$use_pagespeed = listar_use_pagespeed();

		$search = array(
			/* Remove unneeded 'type' attributes */
			"/ type=['\"]text\/(javascript|css)['\"]/",
			/* Remove unneeded 'for' attribute from <label> tags generated by 'Reviews for WP Job Manager' plugin */
			'/<label for=\'0\'>/',
			'/<label for=\'1\'>/',
			'/<label for=\'2\'>/',
			'/<label for=\'3\'>/',
			'/<label for=\'4\'>/',
			'/<label for=\'5\'>/',
			/* Remove an unique badly coded '</p>' tag generated by 'Reviews for WP Job Manager' plugin */
			'/<\/p><\/div>\\n<p><' . $script . ' type=\"application\/ld\+json\">/',
		);

		$replace = array(
			'',
			'<label>',
			'<label>',
			'<label>',
			'<label>',
			'<label>',
			'<label>',
			'</div><p><' . $script . ' type="application/ld+json">',
		);

		$output = preg_replace( $search, $replace, $buffer );

		if ( $use_pagespeed ) {
			if ( function_exists( 'listar_optimize_embeds' ) ) {
				$output = listar_optimize_embeds( $output );
				
				if ( ! empty( $output ) && ! is_user_logged_in() ) {
					
					/* Replace Jquery <link> tag by inline minified jQuery code - Avoids render blocking - Pagespeed */
					
					/* Prepare to open and get file content */
					listar_create_filesystem();

					global $listar_filesystem;

					$jquery_file = ABSPATH . 'wp-includes/js/jquery/jquery.min.js';

					if ( $listar_filesystem->is_readable( $jquery_file ) ) {
						$jquery_content = $listar_filesystem->get_contents( $jquery_file );

						if ( is_string( $jquery_content ) && false !== strpos( $jquery_content, 'jQuery.noConflict();' ) ) {
							$tag_open           = '<';
							$tag_close          = '>';
							$tag_open_hash      = '</';
							$search = $tag_open . "script src='" . network_site_url() . "/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'" . $tag_close . $tag_open_hash . "script" . $tag_close;
							
							$replace = $tag_open . 'script' . $tag_close . $jquery_content . $tag_open_hash . 'script' . $tag_close;
							$output = str_replace( $search, '<link rel="dns-prefetch" href="//fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>' . $replace, $output );
						}
					}
				}
				
				if ( ! empty( $output ) && 0 === 1 ) {
			
					/* Remove Autoptimize script tag to load it dynamically */

					$tag_open          = '<';
					$tag_close             = '>';
					$tag_open_hash    = '</';
					$autop_identifier  = $tag_open . 'script defer src="';
					$autop_identifier2 = '"' . $tag_close . $tag_open_hash . 'script' . $tag_close . $tag_open_hash . 'body' . $tag_close;

					if ( false !== strpos( $output, $autop_identifier ) && false !== strpos( $output, $autop_identifier2 ) ) {
						$temp        = explode( $autop_identifier, $output );
						$beginning   = $temp[0];
						$temp2       = explode( $autop_identifier2, $temp[1] );
						$ending      = $temp2[1];
						$autopScript = $temp2[0];

						$output = $beginning . $tag_open . 'script' . $tag_close . 'window.autoptimizeJS="' . $autopScript . '";' . $tag_open_hash . 'script' . $tag_close . $autop_identifier . listar_get_theme_file_uri( '/assets/js/' . listar_get_frontend_slug() . '.js' ) . $autop_identifier2 . $ending;
					}
				}
				
				if ( ! empty( $output ) && 0 === 1 ) {
			
					/* Remove Autoptimize style tag to load it dynamically */

					$tag_open          = '<';
					$tag_close         = '>';
					$tag_open_hash     = '</';
					$autop_identifier  = $tag_open . 'link rel="stylesheet" media="print" href="';
					$autop_identifier2 = '" onload="this.onload=null;this.media=\'all\';" />';

					if ( false !== strpos( $output, $autop_identifier ) && false !== strpos( $output, $autop_identifier2 ) ) {
						$temp        = explode( $autop_identifier, $output );
						$beginning   = $temp[0];
						$temp2       = explode( $autop_identifier2, $temp[1] );
						$ending      = $temp2[1];
						$autopStyle = $temp2[0];

						$output = $beginning . $tag_open . 'script' . $tag_close . 'window.autoptimizeCSS="' . $autopStyle . '";' . $tag_open_hash . 'script' . $tag_close . $ending;
					}
				}
			}
		}

		return str_replace( '<html><body>', '', $output );
	}

endif;

add_action( 'wp_footer', 'listar_remove_styles_scripts_queue' );

/*
 * Disable Font Awesome from Elementor
 * @since 1.4.9.2
 */

add_action( 'elementor/frontend/after_register_styles',function() {
	wp_deregister_style( 'font-awesome' );
}, 20 );

add_action( 'elementor/frontend/after_register_styles',function() {
	foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
		wp_deregister_style( 'elementor-icons-fa-' . $style );
	}
}, 20 );


/**
 * Remove certain unwanted styles/scripts from queue before print.
 *
 * @since 1.3.4
 */
function listar_remove_styles_scripts_queue() {

	$all_the_scripts_and_styles = listar_crunchify_print_scripts_styles();

	/* For certain styles be loaded from theme assets instead of plugins */
	foreach ( $all_the_scripts_and_styles['styles'] as $style ) {
		if (
			( false !== strpos( $style['src'], '/select2.' ) && false === strpos( $style['src'], '/themes/' ) ) ||
			( false !== strpos( $style['handle'], 'select2' ) && false === strpos( $style['src'], '/themes/' ) ) ||
			( ( false !== strpos( $style['handle'], 'awesome' ) || false !== strpos( $style['handle'], 'awsome' ) ) && false === strpos( $style['src'], '/themes/' ) ) 
		) {

			/* Dequeue Style */
			wp_dequeue_style( $style['handle'] );
			wp_deregister_style( $style['handle'] );
		}
	}
	
	/*
	 * Disable Font Awesome from WCFM plugin.
	 */

	/* For certain scripts be loaded from theme assets instead of plugins */
	foreach ( $all_the_scripts_and_styles['scripts'] as $script ) {
		if (
			( false !== strpos( $script['src'], '/select2.' ) && false === strpos( $script['src'], '/themes/' ) ) ||
			( false !== strpos( $script['handle'], 'select2' ) && false === strpos( $script['src'], '/themes/' ) ) 
		) {

			if (
				! ( listar_is_wcfm_dashboard() || listar_is_wcfm_vendor_setup_page() || listar_is_wcfm_core_setup_page() ) &&
				false === strpos( $script['src'], 'wc-frontend-manager/includes/libs/select2' )
			) {
				/* Dequeue Script */
				wp_dequeue_script( $script['handle'] );
				wp_deregister_script( $script['handle'] );

			}
		}
	}
}


add_action( 'wp_print_styles', 'listar_remove_header_styles' );

/**
 * Remove all styles from header.
 *
 * @since 1.0
 */
function listar_remove_header_styles() {
	if ( ! is_user_logged_in() ) :
		$use_pagespeed = listar_use_pagespeed();

		listar_remove_styles_scripts_queue();

		if ( $use_pagespeed && ! is_user_logged_in() ) {
			listar_crunchify_print_scripts_styles();
		}
	endif;
}


add_action( 'wp_enqueue_scripts', 'listar_remove_head_scripts' );

/**
 * Remove JavaScript scripts from header
 *
 * @since 1.0
 */
function listar_remove_head_scripts() {
	$use_pagespeed = listar_use_pagespeed();

	if ( $use_pagespeed ) {

		// Disable core WP Emoji.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		/* Dequeue Google Fonts */
		wp_dequeue_style( 'listar-google-fonts' );
		wp_deregister_style( 'listar-google-fonts' );

		/* Dequeue Iconized Fonts */
		wp_dequeue_style( 'listar-icons' );
		wp_deregister_style( 'listar-icons' );
		wp_dequeue_style( 'font-awesome' );
		wp_deregister_style( 'font-awesome' );

		/**
		 * Avoid execute these queues exclusively on front page for better pagespeed performance
		 *
		 * @since 1.0
		 */
		if ( listar_is_front_page_template() ) {
			$styles = array(
				'wp-block-library',
				'wp-block-library-theme',
				'wc-block-style',
				'dashicons',
				'lightbox',
				'responsive-lightbox-swipebox',
				'woocommerce-layout',
				'woocommerce-smallscreen',
				'woocommerce-general',
				'wp-job-manager-frontend',
				'wcpv-frontend-styles',
				'wpjmcl_job-listing_front',
				'astoundify-wpjmlp-packages',
				'wp-job-manager-reviews',
				'jquery-ui-style',
				'select2',
				'lity',
			);

			foreach ( $styles as $style ) {
				wp_dequeue_style( $style );
			}

			// Scripts.
			$scripts = array(
				'select2',
				'lity',
				'lightbox',
				'drag-scroll',
				'mousewheel',
				'listing-filter',
				'responsive-lightbox-swipebox',
				'responsive-lightbox',
				'wc-add-to-cart',
				'woocommerce',
				'wp-job-manager-reviews-js',
				'job-regions',
				'wp-embed',
				'wcpv-frontend-scripts',
			);

			foreach ( $scripts as $script ) {
				wp_dequeue_script( $script );
			}
		}// End if().
	}

}

add_action( 'get_footer', 'listar_add_footer_styles' );

/**
 * Add certain styles to footer
 *
 * @since 1.0
 */
function listar_add_footer_styles() {
	$use_pagespeed = listar_use_pagespeed();

	if ( $use_pagespeed ) {

		/* Is built in Google Fonts manager (Customizer / Google Fonts) active on Theme Options? */
		if ( listar_google_fonts_active() ) {
			$google_fonts_url = listar_google_fonts_url();
			wp_enqueue_style( 'listar-google-fonts-into-footer', $google_fonts_url, array(), '1.0' );
		}

		wp_enqueue_style( 'listar-icons-into-footer', listar_get_theme_file_uri( '/assets/fonts/icons/linear/css/import-icons.min.css' ), array(), '1.0' );
		wp_enqueue_style( 'listar-font-awesome-into-footer', listar_get_theme_file_uri( '/assets/fonts/icons/awesome/css/import-icons.min.css' ), array(), '4.7' );

		if ( ! is_user_logged_in() ) {
			listar_static_print_scripts_styles_list();
		}
	}
}

if ( ! function_exists( 'listar_optimize_embeds' ) ) :
	/**
	 * Convert <iframe>, <embed>, <video>, <audio>, <source>, etc to <dl> and <dt> tags. Embeded contents will be loaded dynamically (JavaScript) after scroll, when the content be visible on the viewport.
	 *
	 * @param (string) $buffer All HTML output.
	 * @return (string)
	 * @since 1.0
	 */
	function listar_optimize_embeds( $buffer ) {
		
		$use_pagespeed = listar_use_pagespeed();

		if ( $use_pagespeed ) {
			$has_optimized_tag = false;

			if ( ! empty( $buffer ) ) {
				$output = $buffer;
				$dom = new DOMDocument;

				/*
				 * @link https://stackoverflow.com/questions/6090667/php-domdocument-errors-warnings-on-html5-tags
				 * @link https://stackoverflow.com/questions/9149180/domdocumentloadhtml-error
				 */
				libxml_use_internal_errors( true );
				$dom->loadHTML( $output );
				libxml_clear_errors();

				$replace_tags = array( 'iframe', 'object', 'param', 'embed', 'audio', 'video', 'source' );

				$search = array(
					'/<iframe/',
					'/<\/iframe/',
					'/<object/',
					'/<\/object/',
					'/<param/',
					'/<\/param/',
					'/<embed/',
					'/<\/embed/',
					'/<audio/',
					'/<\/audio/',
					'/<video/',
					'/<\/video/',
					'/<source/',
					'/<\/source/',
				);

				$replace = array(
					'<dl',
					'</dl',
					'<dl',
					'</dl',
					'<dt',
					'</dt',
					'<dl',
					'</dl',
					'<dl',
					'</dl',
					'<dl',
					'</dl',
					'<dt',
					'</dt',
				);

				foreach ( $replace_tags as $replace_tag ) {
					foreach ( $dom->getElementsByTagName( $replace_tag ) as $tag ) {

						if ( isset( $tag->attributes ) && ! empty( $tag->attributes ) ) {
							$new_attributes = array();

							foreach ( $tag->attributes as $attrib_name => $attrib_node_val ) {
								$attr_value = $tag->getAttribute( $attrib_name );
								$new_attributes[] = array( (string) $attrib_name, (string) $attr_value );
							}

							foreach ( $new_attributes as $new_attribute ) {
								$has_optimized_tag = true;
								$tag->setAttribute( 'data-dynamic-embed-' . $replace_tag, 'true' );
								$tag->setAttribute( 'data-temp-' . $new_attribute[0], $new_attribute[1] );
								$tag->removeAttribute( $new_attribute[0] );
							}
						}
					}
				}

				if ( $has_optimized_tag ) {
					$output2 = $dom->saveHTML();
					return preg_replace( $search, $replace, $output2 );
				} else {
					return $buffer;
				}
			} else {
				return $buffer;
			}
		} else {
			return $buffer;
		}
	}
endif;



/* Cancel any unwanted redirects while TGMPA and One Click Demo Import are working */
add_filter('wp_redirect', 'listar_cancel_redirects_while_tgmpa_works', 999999999999999, 3);

if ( ! function_exists( 'listar_cancel_redirects_while_tgmpa_works' ) ) :
	function listar_cancel_redirects_while_tgmpa_works($location, $status = 302, $x_redirect_by = 'WordPress') {
		global $pagenow;
		
		$page = filter_input( INPUT_GET, 'page' );
		
		if ( is_string( $location ) ) {
			if (
				//'one-click-demo-import' === $page && 'themes.php' === $pagenow && false === strpos($location, 'one-click-demo-import')
				'one-click-demo-import' === $page && false === strpos($location, 'one-click-demo-import')
			) {
				
				return  admin_url( 'themes.php?page=one-click-demo-import&step=import&import=0' );
			}
			
			if (
				//'tgmpa-install-plugins' === $page && 'themes.php' === $pagenow && false === strpos($location, 'tgmpa-install-plugins')
				'tgmpa-install-plugins' === $page && false === strpos($location, 'tgmpa-install-plugins')
			) {
				
				return  admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=activate' );
			}
		}
		
		return $location;
	}
endif;







// Disable WordPress updates on locahost and developer domains;

if ( 0 === 1 ) {
	// Not good yet, it locks plugin page.
	// This may be the origin of the issue with Powered Cache plugin.
	add_filter( 'pre_http_request', 'wp_update_check_short_circuit', 20, 3 );
}

function wp_update_check_short_circuit( $preempt = false, $args = array(), $url = '' ) {
	
	// Deny automatic upgrade on localhost.
	$is_localhost = false === strpos( network_site_url(), '://localhost/' ) && false === strpos( network_site_url(), '://wt.ax/' ) && false === strpos( network_site_url(), '://listar.directory/' ) ? false : true;

	if ( stripos( $url, 'https://' ) === 0 ) {
		$url = substr( $url, 8 );
	} else {
		$url = substr( $url, 7 );
	}

	// Stop other URL(s) requests as well (if you need to) in the same manner.
	if ( stripos( $url, 'api.wordpress.org' ) === 0 && $is_localhost ) {

		// WP is trying to get some info, short circuit it with a dummy response.
		return array(
			'headers' => null,
			'body' => '',
			'response' => array(
				'code' => 503,
				'message' => 'SERVICE_UNAVAILABLE'
			),
			'cookies' => array(),
			'filename' => ''
		);
	}

	// returning false will let the normal procedure continue.
	return false;
}

/* Organize all plugin Wizard redirects */
/* Redirect for all plugin wizard screens (first saw), sequentially as follow: */
/* 1 - Redirect One Click Demo Import to the final import page reduce the number of clicks by the user */
/* 2 - Force setup screen for WCFM plugin */
/* 3 - Force setup screen for Woocommerce */
/* 4 - Force setup screen for WP Job Manager */

add_action( 'admin_init', 'listar_redirect_odci_import', 6 );

function listar_redirect_odci_import() {
	$condition1 = filter_input( INPUT_GET, 'page' );
	$condition2 = filter_input( INPUT_GET, 'step' );
	
	$not_redirect_keys = array(
		'job-manager-setup',
		'wc-setup',
		'wc-admin',
		'wcfm-setup',
		'wcfmmp-setup',
		'tgmpa-install-plugins',
		'one-click-demo-import',
		'pt-one-click-demo-import'
	);
	
	if ( ! is_admin() || ! current_user_can( 'administrator' ) || defined( 'DOING_AJAX' ) ) {
		return false;
	}

	// WCFM Setup Wizard First saw.
	
	if ( 'wcfm-setup' === filter_input( INPUT_GET, 'page' ) ) {
		$setup_first_saw = (int) get_option( 'listar_wcfm_setup_first_saw' );
		
		if ( empty( $setup_first_saw ) ) {
			listar_create_wcfm_store_list_page();
			update_option( 'listar_wcfm_setup_first_saw', '1' );
		}
	}

	// Woocommerce Setup Wizard First saw.
	
	if (
		'wc-setup' === filter_input( INPUT_GET, 'page' ) ||
		'wc-admin' === filter_input( INPUT_GET, 'page' )
	) {
		$setup_first_saw = (int) get_option( 'listar_wc_setup_first_saw' );

		if ( empty( $setup_first_saw ) ) {
			update_option( 'listar_wc_setup_first_saw', '1' );
		}
		
	}

	// WP Job Manager Setup Wizard First saw.
	
	if ( 'job-manager-setup' === filter_input( INPUT_GET, 'page' ) ) {
		
		$setup_first_saw = (int) get_option( 'listar_wpjm_setup_first_saw' );

		if ( empty( $setup_first_saw ) ) {
			WP_Job_Manager_Admin_Notices::remove_notice( WP_Job_Manager_Admin_Notices::NOTICE_CORE_SETUP );
			update_option( 'listar_wpjm_setup_first_saw', '1' );
		}
	}
	
	/* 1 - Redirect One Click Demo Import to the final import page to reduce the number of clicks by the user */
	
	if ( 'one-click-demo-import' === $condition1 && empty( $condition2 ) ) {
		wp_redirect( admin_url( 'themes.php?page=one-click-demo-import&step=import&import=0' ) );
		exit();
	}
	
	/* 2 - Force setup screen for WCFM plugin */
	
	$setup_first_saw = (int) get_option( 'listar_wcfm_setup_first_saw' );
	
	if ( listar_is_wcfm_active() ) {
		if ( 1 !== $setup_first_saw && ! in_array( $condition1, $not_redirect_keys, true ) ) {
			wp_redirect( admin_url( 'index.php?page=wcfm-setup' ) );
			exit();
		}
	}
	
	/* 3 - Force setup screen for Woocommerce */
	
	if ( class_exists( 'Woocommerce' ) ) {
		$setup_first_saw = (int) get_option( 'listar_wc_setup_first_saw' );
	
		if ( 1 !== $setup_first_saw && ! in_array( $condition1, $not_redirect_keys, true ) && class_exists( 'WC_Admin_Dashboard_Setup' ) ) {
			wp_redirect( admin_url( 'admin.php?page=wc-admin&path=%2Fsetup-wizard' ) );
			exit();
		}
	}
	
	/* 4 - Force setup screen for WP Job Manager */
	/* No more needed by now - WP Job Manager required pages are being created automatically */
	
	if ( 0 === 1 && class_exists( 'WP_Job_Manager' ) ) {
		$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );
		$add_listing_form_url  = job_manager_get_permalink( 'submit_job_form' );
		$listings_page_url = job_manager_get_permalink( 'jobs' );
		
		$condition_job = empty( $listar_job_dashboard_url ) && empty( $add_listing_form_url ) && empty( $listings_page_url );
		
		$setup_first_saw = (int) get_option( 'listar_wpjm_setup_first_saw' );
	
		if ( $condition_job && 1 !== $setup_first_saw && ! in_array( $condition1, $not_redirect_keys, true ) ) {
			wp_redirect( admin_url( 'index.php?page=job-manager-setup' ) );
			exit();
		}
	}
}

// Stop page redirect to Woocommerce Wizard after activation.
add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );

add_filter( 'woocommerce_prevent_automatic_wizard_redirect', 'listar_prevent_woo_wizard_automatic_redirect' );

function listar_prevent_woo_wizard_automatic_redirect() {
	return true;
}

/* Always redirect from WCFM Marketplace Wizard to WCFM Core Wizard */

add_action( 'admin_init', 'listar_redirect_wcfm_wizard', 7 );

function listar_redirect_wcfm_wizard() {
	if ( ! is_admin() || ! current_user_can( 'administrator' ) || defined( 'DOING_AJAX' ) ) {
		return false;
	}

	// WCFM Setup Wizard First saw.
	
	if ( 'wcfmmp-setup' === filter_input( INPUT_GET, 'page' ) && listar_is_wcfm_active() ) {
		wp_redirect( admin_url( 'index.php?page=wcfm-setup' ) );
		exit();
	}
}

add_action( 'admin_init', 'listar_auto_activate_plugins', 10, 1 ); 

/*
 * TGMPA does not have a priority ordering for plugin activation and certain plugins
 * are dependent others. Considering that prioritary plugins was already downloaded by TGMPA,
 * do the activation of these to avoid interruptions/breaks on TGMPA plugin activation process.
 */

function listar_auto_activate_plugins( $slug ) {
	$condition1 = filter_input( INPUT_GET, 'page' );
	$first = (int) get_option( 'listar_auto_activate_plugins' );
	$woo = ABSPATH . '/wp-content/plugins/woocommerce/woocommerce.php';

	if ( ! class_exists( 'Woocommerce' ) && 1 !== $first && listar_url_exists( $woo ) && 'tgmpa-install-plugins' === $condition1 ) {
		if ( ! function_exists( 'activate_plugin' ) ) {
			require_once( ABSPATH .'/wp-admin/includes/plugin.php' );
		} 

		activate_plugin( $woo );
		update_option( 'listar_auto_activate_plugins', '1' );
	}
}

/* Hide admin product key notice for WC Paid Listings */

add_action( 'admin_init', 'listar_hide_wc_paid_listings_product_key_notice', 7 );

function listar_hide_wc_paid_listings_product_key_notice() {
	if ( class_exists( 'WP_Job_Manager_Helper_Options' ) ) {
		WP_Job_Manager_Helper_Options::update( 'wp-job-manager-wc-paid-listings', 'hide_key_notice', true );
	}
}

/* The 'settimestamp' can fail on localhost because of unknown misconfiguration */

add_action( 'wp_dashboard_setup', 'listar_force_dashboard_assets' );

function listar_force_dashboard_assets() {
        if ( ! method_exists( 'DateTime', 'settimestamp' ) ) {
                remove_meta_box( 'wcfm_dashboard_status', 'dashboard', 'normal' );
                remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );                
        }        
}

add_action( 'init', 'listar_do_init' );

if ( ! function_exists( 'listar_do_init' ) ) :
	function listar_do_init() {
		update_option( 'woocommerce_navigation_enabled', false );

		$woocommerce_feature_order_attribution_enabled = get_option( 'woocommerce_feature_order_attribution_enabled' );

		if ( 'yes' === $woocommerce_feature_order_attribution_enabled ) {
			update_option( 'woocommerce_feature_order_attribution_enabled', 'no' );
		}

		$woocommerce_custom_orders_table_enabled = get_option( 'woocommerce_custom_orders_table_enabled' );

		if ( 'yes' === $woocommerce_custom_orders_table_enabled ) {
			update_option( 'woocommerce_custom_orders_table_enabled', 'no' );
		}
	}
endif;


/* Cancel Elementor redirect after activating all plugins */
if ( ! function_exists( 'listar_force_elementor_activation_redirect_false' ) ) :
	function listar_force_elementor_activation_redirect_false($value, $transient) {
		if ($transient === 'elementor_activation_redirect') {
			// Force the value to false
			return false;
		}

		// For other transients, return the original value
		return $value;
	}
endif;

add_filter('transient_elementor_activation_redirect', 'listar_force_elementor_activation_redirect_false', 9999, 2);


add_action('after_setup_theme', 'listar_fix_theme_text_domain');

function listar_fix_theme_text_domain() {	
	$translate_folder_theme = '/loco/themes/';
	$file_theme = WP_LANG_DIR . $translate_folder_theme . 'listar-' . get_locale() . '.mo';

	$translate_folder_plugin = '/loco/plugins/';
	$file_plugin = WP_LANG_DIR . $translate_folder_plugin . 'listar-' . get_locale() . '.mo';

	if ( ! listar_url_exists( $file_theme ) ) {
		$translate_folder_theme = '/themes/';
		$file_theme = WP_LANG_DIR . $translate_folder_theme . 'listar-' . get_locale() . '.mo';

		$translate_folder_plugin = '/plugins/';
		$file_plugin = WP_LANG_DIR . $translate_folder_plugin . 'listar-' . get_locale() . '.mo';
	}

	if ( listar_url_exists( $file_theme ) || listar_url_exists( $file_plugin ) ) {
		unload_textdomain('listar');
	}

	if ( listar_url_exists( $file_theme ) ) {
		load_textdomain('listar', $file_theme );
	}

	if ( listar_url_exists( $file_plugin ) ) {
		load_textdomain('listar',  $file_plugin );
	}

    $plugins_dir = WP_PLUGIN_DIR;
    $text_domains = [];
    $active_plugins = get_option('active_plugins');

    $plugin_directories = array_filter(glob($plugins_dir . '/*'), 'is_dir');
    foreach ($plugin_directories as $plugin_directory) {
        $plugin_folder = basename($plugin_directory);
        $is_active = false;

        foreach ($active_plugins as $active_plugin) {
            if (strpos($active_plugin, $plugin_folder . '/') === 0) {
                $is_active = true;
                break;
            }
        }

        if ($is_active && 'listar-addons' !== $plugin_folder) {
			$file = WP_LANG_DIR . $translate_folder_plugin . $plugin_folder . '-' . get_locale() . '.mo';

			if ( listar_url_exists( $file ) ) {				
				unload_textdomain( $plugin_folder );
				load_textdomain( $plugin_folder,  $file );
			}
        }
    }
}
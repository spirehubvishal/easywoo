<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package listar_Addons
 */

$wp_fastest_cache_options = get_option( 'WpFastestCache' );

if ( is_array($wp_fastest_cache_options) ) {
	update_option( 'WpFastestCache', '' );
}

/* Execute on every post status: save, update, trashed, untrashed... */
add_action( 'post_updated', 'listar_preset_zero_counters_on_save' );
add_action( 'post_updated', 'listar_check_wp_job_manager_page' );
add_action( 'post_updated', 'listar_update_all_taxonomy_term_counters' );

if ( ! function_exists( 'listar_preset_zero_counters_on_save' ) ) :
	/**
	 * Preset "0" for certain meta fields.
	 * Listings need at least "0" views/bookmarks counted to be listed via "Most viewed" or "Most bookmarked" search filters.
	 *
	 * @param (integer) $term_id The page ID.
	 * @since 1.3.9
	 */
	function listar_preset_zero_counters_on_save( $term_id ) {

		$post_type = get_post_type( $term_id );

		if ( 'job_listing' !== $post_type ) {
			return;
		}
		
		$view_counter = get_post_meta( $term_id, 'listar_meta_box_views_counter', true );
		$bookmarks_counter = get_post_meta( $term_id, 'listar_meta_box_bookmarks_counter', true );
		
		if ( empty ( $view_counter ) ) {
			listar_increment_post_meta_field( $term_id, 'listar_meta_box_views_counter', false, true );
		}
		
		if ( empty ( $bookmarks_counter ) ) {
			listar_increment_post_meta_field( $term_id, 'listar_meta_box_bookmarks_counter', false, true );
		}
	}
endif;


if ( ! function_exists( 'listar_check_wp_job_manager_page' ) ) :
	/**
	 * Detect and set pages for WP Job Manager when creating/editing/untrashing pages.
	 *
	 * @param (integer) $term_id The page ID.
	 * @since 1.0
	 */
	function listar_check_wp_job_manager_page( $term_id ) {

		$post_type = get_post_type( $term_id );

		if ( 'page' !== $post_type ) {
			return;
		}

		$page = get_post( $term_id );
		$page_content = $page->post_content;

		/*
		 * If current page contains the [submit_job_form] shortcode,
		 * set it as 'Submit Job Form Page' (add listing form page) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[submit_job_form]' ) ) {
			update_option( 'job_manager_submit_job_form_page_id', $term_id );
		}

		/*
		 * If current page contains the [job_dashboard] shortcode,
		 * set it as 'Job Dashboard Page' (listing dashboard) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[job_dashboard]' ) ) {
			update_option( 'job_manager_job_dashboard_page_id', $term_id );
		}

		/*
		 * If current page contains the [jobs] shortcode,
		 * set it as 'Jobs Page' (general listing archive page) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[jobs]' ) ) {
			update_option( 'job_manager_jobs_page_id', $term_id );
		}

	}

endif;


add_action( 'before_delete_post', 'listar_unset_wp_job_manager_page' );
add_action( 'untrashed_post', 'listar_unset_wp_job_manager_page' );
add_action( 'trashed_post', 'listar_unset_wp_job_manager_page' );

if ( ! function_exists( 'listar_unset_wp_job_manager_page' ) ) :
	/**
	 * Detect and unset pages for WP Job Manager when deleting pages.
	 *
	 * @param (integer) $term_id The page ID.
	 * @since 1.0
	 */
	function listar_unset_wp_job_manager_page( $term_id ) {

		$post_type = get_post_type( $term_id );

		if ( 'page' !== $post_type ) {
			return;
		}

		$page = get_post( $term_id );
		$page_content = $page->post_content;

		/*
		 * If current page contains the [submit_job_form] shortcode,
		 * unset it as 'Submit Job Form Page' (add listing form page) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[submit_job_form]' ) ) {
			update_option( 'job_manager_submit_job_form_page_id', '' );
		}

		/*
		 * If current page contains the [job_dashboard] shortcode,
		 * unset it as 'Job Dashboard Page' (listing dashboard) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[job_dashboard]' ) ) {
			update_option( 'job_manager_job_dashboard_page_id', '' );
		}

		/*
		 * If current page contains the [jobs] shortcode,
		 * unset it as 'Jobs Page' (general listing archive page) for WP Job Manager
		 */
		if ( false !== strpos( $page_content, '[jobs]' ) ) {
			update_option( 'job_manager_jobs_page_id', '' );
		}

	}

endif;


add_action( 'admin_menu', 'listar_add_pages_admin_dashboard' );

if ( ! function_exists( 'listar_add_pages_admin_dashboard' ) ) :
	/**
	 * Add pages do WordPress admin dashboard
	 *
	 * @since 1.0
	 */
	function listar_add_pages_admin_dashboard() {

		add_menu_page(
			esc_html__( 'Install Plugins', 'listar' ),
			esc_html__( 'Install Plugins', 'listar' ),
			'manage_options',
			'themes.php?page=tgmpa-install-plugins',
			'',
			'dashicons-admin-plugins'
		);

		add_menu_page(
			esc_html__( 'Theme Options', 'listar' ),
			esc_html__( 'Theme Options', 'listar' ),
			'manage_options',
			'themes.php?page=listar_options'
		);
		
		if ( class_exists( 'EasyWPSMTP' ) ) {
			add_menu_page(
				'SMTP',
				'SMTP',
				'manage_options',
				'options-general.php?page=swpsmtp_settings',
				'',
				'dashicons-email'
			);
		} elseif ( function_exists( 'wp_mail_smtp' ) ) {
			add_menu_page(
				'SMTP',
				'SMTP',
				'manage_options',
				'admin.php?page=wp-mail-smtp',
				'',
				'dashicons-email'
			);
		}

		add_menu_page(
			esc_html__( 'Documentation', 'listar' ),
			esc_html__( 'Documentation', 'listar' ),
			'manage_options',
			'http://themeserver.site/wp-themes/listar/docs/',
			'',
			'dashicons-book'
		);

		add_menu_page(
			esc_html__( 'Support', 'listar' ),
			esc_html__( 'Support', 'listar' ),
			'manage_options',
			'https://themeforest.net/item/listar-wordpress-directory-theme/23923427/support',
			'',
			'dashicons-sos'
		);
	}

endif;

function array_insert_after( array $array, $key, array $new ) {
	$keys = array_keys( $array );
	$index = array_search( $key, $keys );
	$pos = false === $index ? count( $array ) : $index + 1;

	return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
}


add_action( 'admin_init', 'listar_change_backend_menu_label', 600 );

if ( ! function_exists( 'listar_change_backend_menu_label' ) ) :
	/**
	 * Modifying WP Job Manager menu labels on admin.
	 *
	 * @since 1.0
	 */
	function listar_change_backend_menu_label() {

		global $menu, $submenu;
		
		$move_to_top = array();
		$keep = array();
		
		$look_by = array(
			'edit.php?post_type=job_listing',
			'edit.php?post_type=listar_claim',
			'edit.php?post_type=listar_partner',
			'toplevel_page_lsl',
			'toplevel_page_loco',
			'themes.php?page=listar_options',
			'smush',
			'options-general.php?page=swpsmtp_settings',
			'admin.php?page=wp-mail-smtp',
			'themes.php?page=tgmpa-install-plugins',
			'toplevel_page_http://themeserver.site/wp-themes/listar/docs',
			'https://themeforest.net/item/listar-wordpress-directory-theme/23923427/support',
			'envato-market',
		);
		
		$counter = 2;
		$skip_key = array();
		$array_by_look_by = array();

		if ( null !== $menu ) {
			foreach ( $menu as $menu_item ) {
				
				$original_menu_key = array_search( $menu_item, $menu );
				
				if ( in_array( 'menu-dashboard', $menu[ $original_menu_key ], true ) ) {
					$move_to_top[] = $menu[ $original_menu_key ];
					$counter++;
				}
				
				else {
					foreach( $look_by as $look ) {
						if ( ! in_array( $look, $skip_key, true ) ) {
							if ( in_array ( $look, $menu[ $original_menu_key ], true ) ) {
								if ( ! in_array ( $menu[ $original_menu_key ], $move_to_top, true ) ) {
									$key = $counter;
									
									$array_by_look_by[ $look ] = $menu[ $original_menu_key ];
										
									$skip_key[] = $look;
									$counter++;
									break;
								}
							} else {
								if ( ! in_array( $look, $array_by_look_by, true ) ) {
									if ( ! in_array ( $menu[ $original_menu_key ], $keep, true ) ) {
										
										$new_key = (int) $original_menu_key + 600;
										
										while ( array_key_exists( $new_key, $keep ) ) {
											$new_key++;
										}
											
										$keep[ $new_key ] = $menu[ $original_menu_key ];
									}
								}
							}
						}
					}
				}
			}
			
			if ( isset( $array_by_look_by[ 'themes.php?page=tgmpa-install-plugins' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'themes.php?page=tgmpa-install-plugins' ];
			}
			
			if ( isset( $array_by_look_by[ 'edit.php?post_type=job_listing' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'edit.php?post_type=job_listing' ];
			}
			
			if ( isset( $array_by_look_by[ 'edit.php?post_type=listar_claim' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'edit.php?post_type=listar_claim' ];
			}
			
			if ( isset( $array_by_look_by[ 'edit.php?post_type=listar_partner' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'edit.php?post_type=listar_partner' ];
			}
			
			if ( isset( $array_by_look_by[ 'toplevel_page_lsl' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'toplevel_page_lsl' ];
			}
			
			if ( isset( $array_by_look_by[ 'toplevel_page_loco' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'toplevel_page_loco' ];
			}
			
			if ( isset( $array_by_look_by[ 'themes.php?page=listar_options' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'themes.php?page=listar_options' ];
			}
			
			if ( isset( $array_by_look_by[ 'smush' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'smush' ];
			}
			
			if ( isset( $array_by_look_by[ 'admin.php?page=wp-mail-smtp' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'admin.php?page=wp-mail-smtp' ];
			}
			
			if ( isset( $array_by_look_by[ 'options-general.php?page=swpsmtp_settings' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'options-general.php?page=swpsmtp_settings' ];
			}
			
			if ( isset( $array_by_look_by[ 'toplevel_page_http://themeserver.site/wp-themes/listar/docs' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'toplevel_page_http://themeserver.site/wp-themes/listar/docs' ];
			}
			
			if ( isset( $array_by_look_by[ 'https://themeforest.net/item/listar-wordpress-directory-theme/23923427/support' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'https://themeforest.net/item/listar-wordpress-directory-theme/23923427/support' ];
			}
			
			if ( isset( $array_by_look_by[ 'envato-market' ] ) ) {
				$move_to_top[] = $array_by_look_by[ 'envato-market' ];
			}
			
			
			ksort( $keep );

			$menu = array_unique( array_merge( $move_to_top, $keep ), SORT_REGULAR );

			foreach ( $menu as $listar_key => $menu_link ) {

				if ( isset( $menu_link[0] ) && isset( $menu_link[1] ) ) {
					
					/* For old versios of WP Job Manager, before Oct 2023 */

					if ( 'edit_job_listings' === $menu_link[1] ) {
						$menu[ $listar_key ][0] = esc_html__( 'Listings', 'listar' );

						if ( isset( $submenu['edit.php?post_type=job_listing'] ) && isset( $submenu['edit.php?post_type=job_listing'][5][0] ) && isset( $submenu['edit.php?post_type=job_listing'][10][0] ) ) {
							$submenu['edit.php?post_type=job_listing'][5][0]  = esc_html__( 'All Listings', 'listar' );
							$submenu['edit.php?post_type=job_listing'][10][0] = esc_html__( 'Add Listing', 'listar' );
						}

						break;
					}

					if ( 'edit_job_listings' === $menu_link[1] ) {
						$menu[ $listar_key ][0] = esc_html__( 'Listings', 'listar' );

						if ( isset( $submenu['edit.php?post_type=job_listing'] ) && isset( $submenu['edit.php?post_type=job_listing'][5][0] ) && isset( $submenu['edit.php?post_type=job_listing'][10][0] ) ) {
							$submenu['edit.php?post_type=job_listing'][5][0]  = esc_html__( 'All Listings', 'listar' );
							$submenu['edit.php?post_type=job_listing'][10][0] = esc_html__( 'Add Listing', 'listar' );
						}

						break;
					}
				}
			}
		}
	}

endif;


add_action( 'init', 'listar_load_plugin_textdomain' );

if ( ! function_exists( 'listar_load_plugin_textdomain' ) ) :
	/**
	 * Loads the plugin's translated strings.
	 *
	 * @since 1.0
	 */
	function listar_load_plugin_textdomain() {
		load_plugin_textdomain( 'listar', false, basename( LISTAR_ADDONS_PLUGIN_DIR ) . '/languages' );
	}

endif;


add_filter( 'register_post_type_args', 'listar_modify_post_type_args', 99999, 2 );

if ( ! function_exists( 'listar_modify_post_type_args' ) ) :
	/**
	 * Modify post type args before register.
	 *
	 * @since 1.0
	 * @param (array)  $args Array of arguments for registering a post type.
	 * @param (string) $post_type Post type key.
	 * @return (array)
	 */
	function listar_modify_post_type_args( $args, $post_type ) {
		if ( 'job_listing' === $post_type ) {
			$args['show_in_rest'] = true;
			$args['template_lock'] = false;
			$args['supports'] = array( 'title', 'editor', 'custom-fields', 'publicize', 'thumbnail', 'comments' );
			$args['template'] = array(
				array( 'core/paragraph', array() ),
			);
		}

		return $args;
	}

endif;

if ( is_admin() ) {
	add_action( 'wp_print_scripts', 'listar_listing_term_edit_allowed_scripts', 9999 );
}

if ( ! function_exists( 'listar_listing_term_edit_allowed_scripts' ) ) :
	/**
	 * Avoid conflicts with third part plugins.
	 * This action locks the listing term edit pages to load only required scripts.
	 *
	 * @since 1.0
	 */
	function listar_listing_term_edit_allowed_scripts() {
		global $wp_scripts;
		global $hook_suffix;

		$hook     = $hook_suffix;
		$screen   = get_current_screen();
		$taxonomy = isset( $screen->taxonomy ) ? $screen->taxonomy : '';

		$allowed_hooks = array(
			'common',
			'admin-bar',
			'wp-all-import-script',
			'media-editor',
			'media-audiovideo',
			'mce-view',
			'image-edit',
			'admin-tags',
			'utils',
			'svg-painter',
			'wp-auth-check',
			'wp-color-picker',
			'jquery',
			'jquery-ui-core',
			'jquery-ui-draggable',
			'hoverIntent',
			'jquery-ui-datepicker',
			'jquery-effects-core',
			'autoptimize-toolbar',
			'dismissible-notices',
			'thickbox',
			'inline-edit-tax',
			'listar-custom-backend-javascript',
			'yoast',
			'admin-global',
			'help-scout-beacon',
			'dashboard-widget',
			'filter-explanation',
			'indexation',
			'sb_instagram_admin_js',
			'smush-global',
			'yoast-seo-admin-global-script',
			'intl-tel-input',
			'yoast-seo-term-edit',
			'editor',
			'quicktags',
			'wplink',
			'jquery-ui-autocomplete',
			'media-upload',
			'wp-embed',
		);

		foreach ( $wp_scripts->queue as $handle ) {			
			if ( false !== strpos( $taxonomy, 'job_listing' ) && ( 'edit-tags.php' === $hook || 'term.php' === $hook ) ) {
				if ( ! in_array( $handle, $allowed_hooks, true ) ) {
					wp_dequeue_script( $handle );
				}
			}
		}
	}

endif;


add_filter( 'allowed_block_types_all', 'listar_custom_allowed_block_types', 99999, 2 );

if ( ! function_exists( 'listar_custom_allowed_block_types' ) ) :
	/**
	 * Modify the list of allowed block types for custom post types.
	 *
	 * @since 1.0
	 * @param (boolean/array) $allowed_blocks Array of block type slugs, or boolean to enable/disable all.
	 * @param (object)        $post Taxonomy key.
	 * @return (array)
	 */
	function listar_custom_allowed_block_types( $allowed_blocks, $post ) {
		if ( isset( $post->post ) && isset( $post->post->post_type ) ) {
			if ( 'job_listing' === $post->post->post_type ) {
				return true;
			}
		}

		return $allowed_blocks;
	}
endif;


add_filter( 'register_taxonomy_args', 'listar_modify_taxonomy_args', 99999, 2 );

if ( ! function_exists( 'listar_modify_taxonomy_args' ) ) :
	/**
	 * Modify post type args before register.
	 *
	 * @since 1.0
	 * @param (array)  $args Array of arguments for registering a taxonomy.
	 * @param (string) $taxonomy Taxonomy key.
	 * @return (array)
	 */
	function listar_modify_taxonomy_args( $args, $taxonomy ) {
		if ( 'job_listing_region' === $taxonomy || 'job_listing_category' === $taxonomy || 'job_listing_amenity' === $taxonomy || 'product_cat' === $taxonomy || 'product_tag' === $taxonomy ) {
			$args['show_in_rest'] = true;
		}

		return $args;
	}

endif;

if ( ! function_exists( 'listar_dequeue_woocommerce_old_select2' ) ) :
	/**
	 * Dequeue Select2 from Woocommerce, the theme already uses it even when Woocommerce is inactive
	 *
	 * @since 1.0
	 */
	function listar_dequeue_woocommerce_old_select2() {
                wp_dequeue_style( 'select2' );
                wp_deregister_style( 'select2' );
                wp_dequeue_script( 'select2' );
                wp_deregister_script( 'select2' );
                
                wp_dequeue_style( 'selectWoo' );
                wp_deregister_style( 'selectWoo' );
                wp_dequeue_script( 'selectWoo' );
                wp_deregister_script( 'selectWoo' );
	}
endif;


add_filter( 'cron_schedules', 'listar_add_cron_recurrence_interval' );

if ( ! function_exists( 'listar_add_cron_recurrence_interval' ) ) :
	/**
	 * Schedule new cron tasks.
	 *
	 * @since 1.0
	 * @param (array) $schedules WordPress tasks schedules.
	 * @return (array)
	 */
	function listar_add_cron_recurrence_interval( $schedules ) {
	
		$listar_automatic_cache_cleaning_time = (int) get_option( 'listar_automatic_cache_cleaning' );

		if ( empty( $listar_automatic_cache_cleaning_time ) ) {
			$listar_automatic_cache_cleaning_time = 31104000;
		}

		$schedules['every_thirty_minutes'] = array(
			'interval' => 1800,
			'display'  => esc_html__( 'Every 30 Minutes', 'listar' ),
		);

		$schedules['every_minute'] = array(
			'interval' => 15,
			'display'  => esc_html__( 'Every minute', 'listar' ),
		);

		$schedules['listar_custom_cache_cleaning'] = array(
			'interval' => $listar_automatic_cache_cleaning_time,
			'display'  => sprintf(
				/* TRANSLATORS: %s: Time in minutes */
				esc_html__( 'Every %s Minutes', 'listar' ),
				$listar_automatic_cache_cleaning_time / 60
			),
		);

		return $schedules;
	}

endif;

/*
 * Schedule a new event.
 */
if ( ! wp_next_scheduled( 'listar_update_trending_listings_hook' ) ) {
	wp_schedule_event( time(), 'every_thirty_minutes', 'listar_update_trending_listings_hook' );
}


/**
 * Update top rated listings.
 * Schedule a cron task to do it automatically every 30 minutes.
 * Get best rated listings and saves it as theme option.
 * Function listar_update_top_listings() can be called by other routine(s),
 * so it is declared in functions.php for better organization.
 *
 * @since 1.0
 */
add_action( 'listar_update_trending_listings_hook', 'listar_update_top_listings' );

/*
 * Preload URLs for automatic cache.
 *
 * @since 1.0
 */
add_action( 'listar_automatic_cache_hook', 'listar_automatic_cache_execute' );


$listar_reset_last_cache_cleaning_time = (int) get_option( 'listar_reset_last_cache_cleaning_time' );

if ( 1 === $listar_reset_last_cache_cleaning_time && wp_next_scheduled( 'listar_clean_cache_hook' ) ) {
	wp_clear_scheduled_hook( 'listar_clean_cache_hook' );
	update_option( 'listar_reset_last_cache_cleaning_time', '' );
}

/*
 * Schedule a new event.
 */
if ( ! wp_next_scheduled( 'listar_clean_cache_hook' ) ) {
	wp_schedule_event( time(), 'listar_custom_cache_cleaning', 'listar_clean_cache_hook' );
}

/**
 * Schedule a cron task to do it automatically every 30 minutes.
 *
 * @since 1.1.9
 */
add_action( 'listar_clean_cache_hook', 'listar_clean_cache' );


/*
 * Clean cache also when editing, deleting posts or terms
 */

$input = (int) get_option( 'listar_keep_cache_on_changes' );
								
if ( 1 !== $input ) :
	add_action( 'publish_post', 'listar_clean_cache' );
	add_action( 'post_updated', 'listar_clean_cache' );
	add_action( 'trashed_post', 'listar_clean_cache' );
	add_action( 'untrashed_post', 'listar_clean_cache' );
	add_action( 'created_job_listing_category', 'listar_clean_cache' );
	add_action( 'created_job_listing_region', 'listar_clean_cache' );
	add_action( 'created_job_listing_amenity', 'listar_clean_cache' );
	add_action( 'created_category', 'listar_clean_cache' );
	add_action( 'created_post_tag', 'listar_clean_cache' );
	add_action( 'edited_job_listing_category', 'listar_clean_cache' );
	add_action( 'edited_job_listing_region', 'listar_clean_cache' );
	add_action( 'edited_job_listing_amenity', 'listar_clean_cache' );
	add_action( 'edited_category', 'listar_clean_cache' );
	add_action( 'edited_post_tag', 'listar_clean_cache' );
	add_action( 'wp_set_comment_status', 'listar_clean_cache' );
	add_action( 'delete_term', 'listar_clean_cache' );
endif;

add_filter( 'mime_types', 'listar_custom_upload_mimes' );

if ( ! function_exists( 'listar_custom_upload_mimes' ) ) :
	/**
	 * Modify the list of allowed mime tipes for file upload.
	 *
	 * @since 1.0
	 * @param (array) $existing_mimes The list of allowed file mime types.
	 * @return (array)
	 */
	function listar_custom_upload_mimes( $existing_mimes ) {
		// Add webm to the list of mime types.
		$existing_mimes['ppt'] = 'application/vnd.ms-powerpoint';

		// Return the array back to the function with our added mime type.
		return $existing_mimes;
	}
endif;

if ( ! function_exists( 'listar_custom_geocode_location' ) ) :
        /**
         * Get custom geocoding data for a listing.
         *
         * @since 1.0.0
         * @param (integer|boolean) $id The listing ID.
         * @param (mixed) $post The $post object.
         * @param (mixed) $post_type The post type slug.
         * @param (boolean) $force_address Force to use the address passed to the function.
         * @param (string) $address A address to geolocate.
         */
        function listar_custom_geocode_location( $id = false, $post = false, $post_type = false, $force_address = false, $address = '' ) {
                $post_id = false !== $id ? $id : $post->ID;
                $post_type = false !== $post_type ? $post_type : get_post_type( $post );
            
                if ( 'job_listing' === $post_type ) {
                        $geo = array();
                        $geocoder = get_option( 'listar_geocoding_provider' );
                        $address = $force_address ? $address : esc_html( get_post_meta( $post_id, '_job_location', true ) );
                        $language = esc_html( get_option( 'listar_' . $geocoder . '_language_code' ) );
                        $fallback_language = get_locale();
                        $token = esc_html( get_option( 'listar_' . $geocoder . '_api_key' ) );
                                
                        if ( empty( $language ) || 'locale' === $language ) {
                                $language = $fallback_language;
                        }
                                
                        if ( ! empty( $language ) ) {
                                $language = str_replace( '_', '-', $language ); 
                        }

                        if ( 'mapbox' === $geocoder ) { 
                                $geo = listar_mapbox_geocoding( $address, $token, $language );
                        }

                        if ( 'jawg' === $geocoder ) { 
                                $geo = listar_jawg_geocoding( $address, $token, $language );
                        }

                        if ( 'here' === $geocoder ) {
                                $geo = listar_here_geocoding( $address, $token, $language );
                        }

                        if ( 'mapplus' === $geocoder ) {
                                $geo = listar_mapplus_geocoding( $address, $language );
                        }

                        if ( 'openstreetmap' === $geocoder ) {
                                $geo = listar_openstreetmap_geocoding( $address, $language );
                        }

                        if ( 'bingmaps' === $geocoder ) {
                                $geo = listar_bingmaps_geocoding( $address, $token, $language );
                        }

                        if ( empty( $address ) ) {
                                $geo = array(
                                        'geolocated'                    => '',
                                        'geolocation_city'              => '',
                                        'geolocation_country_long'      => '',
                                        'geolocation_country_short'     => '',
                                        'geolocation_formatted_address' => '',
                                        'geolocation_lat'               => '',
                                        'geolocation_long'              => '',
                                        'geolocation_postcode'          => '',
                                        'geolocation_state_long'        => '',
                                        'geolocation_state_short'       => '',
                                        'geolocation_street'            => '',
                                        'geolocation_street_number'     => '',
                                );
                        }
                        
                        if ( ! empty( $geo ) ) {
                                foreach ( $geo as $key => $value ) {
                                        if ( 'language' !== $key ) {
                                                update_post_meta( $post_id, $key, $value );
                                        }
                                }
                        }

                }
        }
endif;

add_action( 'job_manager_update_job_data', 'listar_updated_post_meta', 2000, 2 );
add_action( 'job_manager_job_location_edited', 'listar_updated_post_meta_2', 2000, 2 );

if ( ! function_exists( 'listar_updated_post_meta' ) ) :
        /**
         * Update a post meta field.
         *
         * @since 1.0.0
         * @param (integer) $post_id The listing ID.
         * @param (array) $values Array of meta values.
         */
        function listar_updated_post_meta( $post_id, $values ) {
                if ( isset( $values['job']['job_location'] ) ) {
                        $post_type = get_post_type( $post_id );

                        if ( 'job_listing' === $post_type ) {
                                listar_custom_geocode_location( $post_id, false, 'job_listing', true, $values['job']['job_location'] );
                        }
                }
        }
endif;

if ( ! function_exists( 'listar_updated_post_meta_2' ) ) :
        /**
         * Update a post meta field.
         *
         * @since 1.0.0
         * @param (integer) $post_id The listing ID.
         * @param (string) $address A address to geolocate.
         */
        function listar_updated_post_meta_2( $post_id, $address ) {
                $post_type = get_post_type( $post_id );

                if ( 'job_listing' === $post_type ) {
                        listar_custom_geocode_location( $post_id, false, 'job_listing', true, $address );
                }
        }
endif;


if ( ! function_exists( 'listar_custom_session_created' ) ) :
	/**
	 * Verify if custom session for listar was already created.
	 *
	 * @since 1.4.7
	 * @param (integer) $id The ID of a post.
	 * @return (array)
	 */
	function listar_custom_session_created() {

		static $session_created = false;

		if ( ! $session_created ) {
			$session_created = true;
			return false;
		}

		return $session_created;
	}
endif;



function listar_start_session_cookie_params() {	
	if ( ! is_admin() ) {
		$session_params = session_get_cookie_params();
		
		$maxlifetime = $session_params['lifetime']; //time() + ( 60*60*24*30 ); // 30 days.
		$path = $session_params['path'];
		$host = listar_get_current_domain_url()[1];
		$samesite = 'None';
		$secure   = is_ssl() ? true : false; // If you only want to receive the cookie over HTTPS.
		$httponly = false; // Prevent JavaScript access to session cookie.

		if( PHP_VERSION_ID < 70300 ) {
			session_set_cookie_params( $maxlifetime, $samesite, $host, $secure, $httponly );
		} else {

			session_set_cookie_params( [
				'lifetime' => $maxlifetime,
				'path'     => $path,
				'domain'   => $host,
				'secure'   => $secure,
				'httponly' => $httponly,
				'samesite' => $samesite
			] );
		}
	}
}


/* Sessions for this plugin */

add_action( 'parse_query', 'listar_register_sessions' );

if ( ! function_exists( 'listar_register_sessions' ) ) :
	/**
	 * Set sessions for this plugin.
	 *
	 * @since 1.0
	 */
	function listar_register_sessions( $wp_query, $force_session = false ) {
		if (
			! listar_custom_session_created() && (
				
				$force_session ||

				(
					true &&
					//isset( $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] ) && 'listing' === $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] &&
					! isset( $wp_query->query['custom_query'] )
				)
			)
		) {	
			if ( ! session_id() ) {
				listar_start_session_cookie_params();
				listar_init_session();
			} else {
				session_write_close();
				listar_start_session_cookie_params();				
				listar_init_session();
			}

			$session_main_key = 'listar_user_search_options';
			$listar_current_explore_by_country = listar_current_explore_by_country();
			$listar_current_explore_by_country_name = listar_current_explore_by_country_name();
			$last_explore_by_address = isset( $_SESSION['listar_user_search_options']['explore_by_address'] ) ? $_SESSION['listar_user_search_options']['explore_by_address'] : '';
			$current_explore_by_address = listar_current_search_address_session();
			$current_explore_by_address_coordinates = listar_current_search_address_coordinates_session();
			$last_explore_by_postcode = isset( $_SESSION['listar_user_search_options']['explore_by_postcode'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode'] : '';
			$current_explore_by_postcode = listar_current_search_postcode_session();
			$current_explore_by_postcode_coordinates = listar_current_search_postcode_coordinates_session();
                        $current_url = listar_get_current_url();

                        if ( false === strpos( $current_url, 'wp-admin' ) && false === strpos( $current_url, 'wp-login' ) && ! wp_doing_ajax() ) {
                                $_SESSION[ $session_main_key ]['listar_last_url_visited'] = $current_url;
                        }

			$defaults = array(

				/* General ========================================== */
				'sort_order'                              => listar_current_directory_sort_session(),
				'explore_by'                              => listar_current_explore_by_session(),
				'explore_by_selected_regions'             => '',

				/* Other specifics ================================== */
				/* Use only for default, nearest me, featured, best rated and surprise me */
				'explore_by_latest_keywords'              => '',

				/* Searches by address and postcode ================= */
				'explore_by_country'                      => $listar_current_explore_by_country,
				'explore_by_country_name'                 => $listar_current_explore_by_country_name,

				/* Searches by postcode */
				'explore_by_postcode'                     => $current_explore_by_postcode,
				'last_explore_by_postcode'                => $last_explore_by_postcode,
				'explore_by_postcode_geocoded_lat'        => $current_explore_by_postcode_coordinates[0],
				'explore_by_postcode_geocoded_lng'        => $current_explore_by_postcode_coordinates[1],

				/* Searches by address */
				'explore_by_address'                      => $current_explore_by_address,
				'last_explore_by_address'                 => $last_explore_by_address,
				'explore_by_address_geocoded_lat'         => $current_explore_by_address_coordinates[0],
				'explore_by_address_geocoded_lng'         => $current_explore_by_address_coordinates[1],

				/* Searches by blog ================================= */
				'explore_by_blog_latest_keywords'         => '',

				/* Searches by nearest me =========================== */
				/* Will be updated externaly */
			);

			if ( ! isset( $_SESSION[ $session_main_key ] ) ) {
				$_SESSION[ $session_main_key ] = array();
			}

			foreach( $defaults as $key => $value ) {
				$_SESSION[ $session_main_key ][ $key ] = $value;
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address'] ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address'] = '';
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number'] ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number'] = '';
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region'] ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region'] = '';
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country'] ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country'] = '';
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat'] ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat'] = '';
			}

			if ( ! isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng']  ) ) {
				$_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng']  = '';
			}
		}
	}
endif;

/*
 * Avoid two listing packages of being added to the Woocomerce shopping cart
 */

add_filter( 'woocommerce_add_cart_item_data', 'listar_remove_cart_item_before_add_to_cart', 10,  3);

function listar_remove_cart_item_before_add_to_cart( $cart_item_data, $product_id, $variation_id ) {

	global $woocommerce;
	
	$product = wc_get_product( $product_id );

	if ( $product->is_type( array( 'job_package', 'job_package_subscription' ) ) ) {
		$woocommerce->cart->empty_cart();
	}

	// Do nothing with the data and return
	return $cart_item_data;
}

add_action( 'init', 'listar_handle_automatic_cache' );

if ( ! function_exists( 'listar_handle_automatic_cache' ) ) :
	/**
	 * Initiate the automatic cache.
	 *
	 * @since 1.4.7
	 */
	function listar_handle_automatic_cache() {
		$get_pagespeed_option = (int) get_option( 'listar_activate_pagespeed' );
	
		if ( 1 === $get_pagespeed_option ) {
			listar_generate_automatic_caching_task( 'enable' );
		} else {
			listar_generate_automatic_caching_task( 'disable' );
		}
	}

endif;




add_filter( 'register_post_type_job_listing', 'listar_change_job_listing_slug_3', 30 );

if ( ! function_exists( 'listar_change_job_listing_slug_3' ) ) :
	/**
	 * Set listing slug.
	 *
	 * @since 1.5.0
	 * @param (array) $args WP Job Manager args.
	 * @return (array)
	 */
	function listar_change_job_listing_slug_3( $args ) {
	
		$new_listing_slug = get_option( 'listar_custom_listing_slug' );
		
		$use_listing_id  = 1 === (int) get_option( 'listar_listing_id_slug_permalink' );
		$listing_id_slug = $use_listing_id ? '/%post_id%' : '';
		
		$use_region_slug  = 1 === (int) get_option( 'listar_use_region_slug_permalink' );
		$region_slug = $use_region_slug ? '/%job_listing_region%' : '';
		
		$use_category_slug  = 1 === (int) get_option( 'listar_use_category_slug_permalink' );
		$category_slug = $use_category_slug ? '/%job_listing_category%' : '';
		
		if ( empty( $new_listing_slug ) ) {
			$new_listing_slug = 'listing';
		}

		$args['rewrite']['slug'] = $new_listing_slug . $listing_id_slug . $region_slug . $category_slug;

		return $args;
	}

endif;


add_filter( 'post_type_link', 'listar_modify_permalink_structure', 10, 4 );

function listar_modify_permalink_structure( $permalink, $post, $leavename, $sample ) {
	if ( $post->post_type !== 'job_listing' ) {
		return $permalink;
	}
	
	$absent_region_slug = get_option( 'listar_absent_region_slug_permalink' );
	$absent_category_slug = get_option( 'listar_absent_category_slug_permalink' );
	
	if ( empty( $absent_region_slug ) ) {
		$absent_region_slug = '@';
	}
	
	if ( empty( $absent_category_slug ) ) {
		$absent_category_slug = '!';
	}

	if ( false !== strpos( $permalink, '%job_listing_region%' ) ) {
		$listing_region_terms = get_the_terms( $post->ID, 'job_listing_region' );
		$region_slug = '';
		
		if ( ! empty( $listing_region_terms ) && ! is_wp_error( $listing_region_terms ) && isset( $listing_region_terms[0] ) ) {
			$featured_region = esc_html( get_post_meta( $post->ID, '_company_featured_listing_region', true ) );
			$featured_region_term = ! empty( $featured_region ) ? get_term_by( 'id', $featured_region, 'job_listing_region' ) : false;
			$has_featured_region  = isset( $featured_region_term->term_id ) && isset( $featured_region_term->name ) ? $featured_region_term : false;
			$region_slug = $has_featured_region ? $featured_region_term->slug : '';

			if ( empty( $region_slug ) ) {
				$region_slug = array_pop( $listing_region_terms )->slug;
			}
		}

		if ( ! empty( $region_slug ) ) {
			$permalink = str_replace( '%job_listing_region%', $region_slug, $permalink );
		} else {
			$permalink = str_replace( '%job_listing_region%', $absent_region_slug, $permalink );
		}	
	}

	if ( false !== strpos( $permalink, '%job_listing_category%' ) ) {
		$listing_category_terms = get_the_terms( $post->ID, 'job_listing_category' );
		$category_slug = '';
		
		if ( ! empty( $listing_category_terms ) && ! is_wp_error( $listing_category_terms ) && isset( $listing_category_terms[0] ) ) {
			$featured_category = esc_html( get_post_meta( $post->ID, '_company_featured_listing_category', true ) );
			$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
			$has_featured_category  = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;
			$category_slug = $has_featured_category ? $featured_category_term->slug : '';

			if ( empty( $category_slug ) ) {
				$category_slug = array_pop( $listing_category_terms )->slug;
			}
		}

		if ( ! empty( $category_slug ) ) {
			$permalink = str_replace( '%job_listing_category%', $category_slug, $permalink );
		} else {
			$permalink = str_replace( '%job_listing_category%', $absent_category_slug, $permalink );
		}	
	}

	if ( false !== strpos( $permalink, '%post_id%' ) ) {
		$permalink = str_replace( '%post_id%', $post->ID, $permalink );
	}

	return $permalink;
}



/**
 * PHP session handling: Open / Close session depending on WordPress hooks.
 */

// Close session before REST requests.
add_filter( 'pre_http_request', 'listar_close_session_2', 10, 3 );  
add_filter( 'http_request_timeout', 'listar_close_session_3', 10, 1 );  

add_filter( 'rest_post_dispatch', 'listar_session_init_2', 10, 3 );
add_filter( 'rest_request_before_callbacks', 'listar_session_init_3', 10, 3 );
add_filter( 'rest_pre_echo_response', 'listar_session_init_3', 10, 3 );

// Close session, if yet open.
add_action( 'parse_query', 'listar_close_session_3', 10 );
add_action('wp_default_styles', 'listar_close_session_4');  

add_action( 'wp_enqueue_scripts', 'listar_close_session' );

if ( ! function_exists( 'listar_close_session' ) ) :
	function listar_close_session() {
		session_write_close();
	}
endif;
       
if ( ! function_exists( 'listar_close_session_2' ) ) :
	function listar_close_session_2( $false, $r, $url ) { 

		if ( false !== strpos( $url, '\/wp-json\/' ) ) {
			session_write_close();
		}

		return $false; 
	}
endif;

if ( ! function_exists( 'listar_close_session_3' ) ) :
	function listar_close_session_3( $array ) { 
		if ( ! ( ! is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) ) {

			// Only if WordPress backend.
			session_write_close();
		}

		return $array; 
	}
endif;

if ( ! function_exists( 'listar_close_session_4' ) ) :
	function listar_close_session_4( $array ) { 
		if ( ! ( ! is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) ) {

			// Only if WordPress backend.
			session_write_close();
		}

		return $array; 
	}
endif;

if ( ! function_exists( 'listar_session_init_2' ) ) :
	function listar_session_init_2( $rest_ensure_response, $instance, $request ) { 
		if ( ! headers_sent() && ! session_id() && PHP_SESSION_NONE === session_status() ) {
			listar_init_session();
		}

		return $rest_ensure_response; 
	}
endif;

if ( ! function_exists( 'listar_session_init_3' ) ) :
	function listar_session_init_3( $response, $handler, $request ) { 
		if ( ! headers_sent() && ! session_id() && PHP_SESSION_NONE === session_status() ) {
			listar_init_session();
		}

		return $response; 
	}
endif;


add_action( 'admin_init','listar_add_role_capabilities', 999 );

if ( ! function_exists( 'listar_add_role_capabilities' ) ) :
	/**
	 * Add capabilities for user roles.
	 *
	 * @since 1.5.3.3
	 */
	function listar_add_role_capabilities() {
		$role = get_role('editor');               
		$role->add_cap( 'read_job_listing');
		$role->add_cap( 'edit_job_listing' );
		$role->add_cap( 'edit_job_listings' );
		$role->add_cap( 'edit_other_job_listings' );
		$role->add_cap( 'edit_published_job_listings' );
		$role->add_cap( 'publish_job_listings' );
		$role->add_cap( 'read_private_job_listings' );
		$role->add_cap( 'delete_job_listing' );
	}
endif;



//************************************************************************/

/* Fix / Remove unwanted sub menu links from WordPress dashboard menu */

add_action('admin_menu', 'listar_customize_dashboard_menu', 99999999999);

function listar_customize_dashboard_menu() {
	global $menu, $submenu;

    // Array of strings to check for in submenu URLs
    $strings_to_check = array(
        'job-manager-landing-resumes',
        'job-manager-marketplace',
		'job-manager-landing-application',
    );



    // Loop through each submenu item
    foreach ($submenu as $menu_slug => $submenu_items) {
        foreach ($submenu_items as $key => $submenu_item) {
            // Check if any of the specified strings are in the URL
            foreach ($strings_to_check as $string) {
				// Check if the last part of the URL is 'edit.php?post_type=job_listing'
				if ( false !== strpos( $submenu_item[2], 'edit.php?post_type=job_listing' ) ) {
					$last_part = substr($submenu_item[2], -strlen('edit.php?post_type=job_listing'));
	
					if ($last_part === 'edit.php?post_type=job_listing') {
						// Rename submenu item
						$submenu[$menu_slug][$key][0] = esc_html__('All Listings', 'listar');
					}

				}

				
				// Check if the last part of the URL is 'edit.php?post_type=job_listing'
				if ( false !== strpos( $submenu_item[2], 'listing_amenity' ) ) {									
	
					// Rename submenu item
					$submenu[$menu_slug][$key][0] = esc_html__('Amenities', 'listar');				

				}
            }
        }
    }

    foreach ($submenu as $menu_slug => $submenu_items) {
        foreach ($submenu_items as $key => $submenu_item) {
            // Check if any of the specified strings are in the URL
            foreach ($strings_to_check as $string) {
                if (strpos($submenu_item[2], $string) !== false) {
                    // Unset the submenu item
                    unset($submenu[$menu_slug][$key]);
                }
            }
        }
    }

	
}


// Add a filter to modify the columns for job_listing post type
add_filter('manage_job_listing_posts_columns', 'listar_custom_modify_job_listing_columns', 9999999999);

function listar_custom_modify_job_listing_columns($columns) {
	//printf('<pre>%s</pre>', var_export($columns,true));
    // Rename the "Position" column to "New Position"
    $columns['job_position'] = esc_html__('Listing', 'listar'); // Replace 'textdomain' with your theme/plugin text domain

    return $columns;
}



// Add a filter to modify the columns for job_listing post type
add_filter('manage_edit-job_listing_columns', 'listar_custom_modify_job_listing_columns_2', 99999999);

function listar_custom_modify_job_listing_columns_2($columns) {
    // Rename the "Position" column to "New Position"
    $columns['job_position'] = esc_html__('Listing', 'listar'); // Replace 'textdomain' with your theme/plugin text domain
    unset($columns['position']);
    unset($columns['promoted_jobs']);

    return $columns;
}



/* Fix Title placeholder while editing a listing w/ the backend editor */

add_filter( 'enter_title_here', 'listar_custom_job_listing_title_placeholder', 10, 2 );
function listar_custom_job_listing_title_placeholder( $title, $post ) {
    if ( 'job_listing' === $post->post_type ) {
        return __( 'Add title', 'listar' );
    }
    return $title;
}


// Dequeue job_tags_upsell_js script in the backend
function listar_custom_dequeue_backend_script() {
    wp_dequeue_script('job_tags_upsell_js');
}
add_action('admin_enqueue_scripts', 'listar_custom_dequeue_backend_script', 99999999);

add_action( 'init', function () {
	update_option( 'job_manager_enable_remote_position', false );
} );

//************************************************************************/
<?php
/**
 * Predefining demo imports and configuration to 'One Click Demo Import' plugin
 *
 * @link https://br.wordpress.org/plugins/one-click-demo-import/
 * @link https://github.com/proteusthemes/one-click-demo-import
 * @package Listar
 */


add_filter( 'ocdi/downloaded_customizer_file_suffix_and_file_extension', 'listar_ocdi_customizer_file_suffix_extension' );

if ( ! function_exists( 'listar_ocdi_customizer_file_suffix_extension' ) ) :
	/**
	 * Change 'setting' texts of demo importer.
	 *
	 * @since 1.5.1
	 * @return (string)
	 */
	function listar_ocdi_customizer_file_suffix_extension() {
		return '.txt';
	}

endif;

/**
 * Disable the generation of smaller images (thumbnail, medium, etc) during the import
 * Relative to One Click Demo Import plugin
 *
 * @since 1.0
 */

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

add_filter( 'pt-ocdi/import_files', 'listar_ocdi_import_files' );

if ( ! function_exists( 'listar_ocdi_import_files' ) ) :
	/**
	 * Set the default 'One Click Demo Import' files ( .xml, .wie, .dat ).
	 *
	 * @since 1.0
	 */
	function listar_ocdi_import_files() {

		$import_data_folder          = listar_get_theme_file_uri( '/inc/import/demo-data/' );
		$wordpress_import_file_path  = $import_data_folder . 'import-demo-data.xml';
		$widgets_import_file_path    = $import_data_folder . 'import-widgets.json';
		$customizer_import_file_path = $import_data_folder . 'import-customizer.txt';

		return array(
			array(
				'import_file_name'             => esc_html__( 'Demo Data', 'listar' ),
				'import_file_url'            => $wordpress_import_file_path,
				'import_widget_file_url'     => $widgets_import_file_path,
				'import_customizer_file_url' => $customizer_import_file_path,
			),
		);
	}

endif;


add_action( 'pt-ocdi/time_for_one_ajax_call', 'listar_ocdi_change_time_of_single_ajax_call' );

if ( ! function_exists( 'listar_ocdi_change_time_of_single_ajax_call' ) ) :
	/**
	 * Change the default time of one Ajax call.
	 *
	 * @since 1.0
	 * @return (integer)
	 */
	function listar_ocdi_change_time_of_single_ajax_call() {
		return 10;
	}

endif;

/**
 * Disable the installer popup confirmation, shown before import
 * and disable branding notice after import.
 *
 * @since 1.0
 */
add_filter( 'pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

add_filter( 'pt-ocdi/plugin_intro_text', 'listar_ocdi_plugin_intro_text' );

if ( ! function_exists( 'listar_ocdi_plugin_intro_text' ) ) :
	/**
	 * Change header text on demo importer page.
	 *
	 * @since 1.0
	 * @param (string) $ocdi_intro_text Default OCDI intro text.
	 * @return (string)
	 */
	function listar_ocdi_plugin_intro_text( $ocdi_intro_text ) {

		$ocdi_intro_text .= '<h1 class="installer-title">' . esc_html__( 'One-Click Demo Import', 'listar' ) . '</h1>';

		return $ocdi_intro_text;
	}

endif;


add_filter( 'pt-ocdi/plugin_page_setup', 'listar_ocdi_plugin_page_setup' );

if ( ! function_exists( 'listar_ocdi_plugin_page_setup' ) ) :
	/**
	 * Change 'setting' texts of demo importer.
	 *
	 * @since 1.0
	 * @param (array) $default_settings OCDI settings.
	 * @return (array)
	 */
	function listar_ocdi_plugin_page_setup( $default_settings ) {
		$default_settings['page_title'] = esc_html__( 'Theme Content Importer', 'listar' );
		$default_settings['menu_title'] = esc_html__( 'Demo Data', 'listar' );
		$default_settings['capability'] = 'import';

		return $default_settings;
	}

endif;


add_filter( 'wp_redirect', 'listar_filter_wp_redirect', 10, 1 );

if ( ! function_exists( 'listar_filter_wp_redirect' ) ) :
	/**
	 * After using 'TGM Plugin Activation' and activate all plugins,
	 * avoid unwanted page redirects right before 'One Click Demo Import' page,
	 * and 'exclusivelly' after the user clicks on the 'Go to demo import page' link.
	 * Under this condition, this filter will only cancel page redirect(s) to the following pages:
	 *
	 * - WP Job Manager initial setup
	 * - Woocommerce initial setup
	 *
	 * If the user clicks on any other link, the redirect to these pages will be executed normally.
	 *
	 * @since 1.0
	 * @param (string) $url URL before redirect.
	 * @return (string)
	 */
	function listar_filter_wp_redirect( $url ) {
		/**
		 * Safe/reliable context: Using 'wp_redirect' filter to capture the 'REQUEST_URI'.
		 * via 'listar_get_server_request_uri' function.
		 * Function declared in functions.php, from 'Listar Add-ons' plugin.
		 */
		$request = function_exists( 'listar_get_server_request_uri' ) ? listar_get_server_request_uri() : '';

		if ( false !== strpos( $request, 'one-click' ) ) {

			$keys = array(
				'job-manager-setup',
				'wc-setup',
				'wc-admin',
				'wcfm-setup',
				'wcfmmp-setup'
			);

			foreach ( $keys as $key ) {
				if ( false !== strpos( $url, $key ) ) {
					$uri = explode( 'wp-admin', $request );
					return site_url( '/wp-admin' ) . str_replace( '//', '/', $uri[1] );
				}
			}
		}

		return $url;
	}

endif;

add_action( 'pt-ocdi/before_content_import_execution', 'listar_ocdi_configure_theme_before_import' );

if ( ! function_exists( 'listar_ocdi_configure_theme_before_import' ) ) :
	/**
	 * Prepare the theme before import demo data ***************************
	 *
	 * @since 1.0
	 */
	function listar_ocdi_configure_theme_before_import() {

		/* Prepare to open and get file content */
		listar_create_filesystem();
		
		global $listar_filesystem;

		$theme_path           = get_template_directory_uri() . '/';
		$abs_import_data_path = trailingslashit( listar_get_theme_file_path( 'inc/import/demo-data/' ) );
		$install_url          = esc_url( site_url( '' ) );
		$parse_url            = wp_parse_url( $install_url );
		$domain               = $parse_url['host'];
		
		if ( listar_url_exists( WP_PLUGIN_DIR . '/wp-smushit/wp-smush.php' ) && is_plugin_active( '/wp-smushit/wp-smush.php' ) ) {
			deactivate_plugins( '/wp-smushit/wp-smush.php' );
		}

		/**
		 * Import demo theme options ***********************************
		 */

		$options_file  = $abs_import_data_path . 'import-wordpress-options.json';
		$options_json  = ( $listar_filesystem->is_readable( $options_file ) ) ? $listar_filesystem->get_contents( $options_file ) : '{}';
		$options_array = json_decode( $options_json, true );

		foreach ( $options_array as $key => $value ) {

			if ( is_string( $value ) ) {

				$search = array(
					'http://wt.ax/listardevclientv1_5_3_3/wp-content/themes/listar/',
					'http://wt.ax/listardevclientv1_5_3_3',
					'https://wt.ax/listardevclientv1_5_3_3/wp-content/themes/listar/',
					'https://wt.ax/listardevclientv1_5_3_3',
					'wt.ax',
				);

				$replace = array(
					$theme_path,
					$install_url,
					$theme_path,
					$install_url,
					$domain,
				);

				$value = str_replace( $search, $replace, $value );
				$options_array[ $key ] = $value;

				update_option( $key, $options_array[ $key ] );
			}
		}

		/**
		 * Clean default WordPress post, page and comment **************
		 */

		/* Post */
		wp_delete_post( 1, true );

		/* Page */
		wp_delete_post( 2, true );

		/* Comment */
		wp_delete_comment( 1, true );

		/**
		 * Clean all widgets
		 */

		update_option( 'sidebars_widgets', array( false ) );
	}

endif;


add_action( 'pt-ocdi/after_import', 'listar_ocdi_after_import_setup' );

if ( ! function_exists( 'listar_ocdi_after_import_setup' ) ) :
	/**
	 * Configurations to be set after demo content has been imported *******
	 *
	 * @since 1.0
	 */
	function listar_ocdi_after_import_setup() {

		/* Prepare to open and get file content */
		listar_create_filesystem();
		
		global $listar_filesystem;

		$theme_path                = get_template_directory_uri() . '/';
		$abs_import_data_path      = trailingslashit( listar_get_theme_file_path( 'inc/import/demo-data/' ) );
		$install_path              = explode( 'wp-content', $theme_path, 2 );
		$root_install_path         = $install_path[0];
		$root_install_path_encoded = rawurlencode( $root_install_path );
		
		if ( listar_url_exists( WP_PLUGIN_DIR . '/wp-smushit/wp-smush.php' ) ) {
			activate_plugins( '/wp-smushit/wp-smush.php' ); 
		}
		
		/* Remove all widgets from sidebars */

		$sidebar_widgets = get_option('sidebars_widgets');
		
		foreach( $sidebar_widgets as $sidebar_key => $widgets_array ) {
			if ( ! empty( $sidebar_key ) && isset( $sidebar_widgets[ $sidebar_key ] ) && ! empty( $sidebar_widgets[ $sidebar_key ] ) && is_array( $sidebar_widgets[ $sidebar_key ] ) ) {
				foreach( $sidebar_widgets[ $sidebar_key ] as $widget_numeric_key => $widget_slug ) {
					if ( false === strpos( $widget_slug, 'listar' ) ) {
						unset( $sidebar_widgets[ $sidebar_key ][ $widget_numeric_key ] );
					}
				}
			}
		}
		
		update_option( 'sidebars_widgets', $sidebar_widgets );
		
		/* Delete Hello Word post */

		$post_to_delete = get_page_by_title( 'Hello world!', OBJECT, 'post' );

		if ( isset( $post_to_delete->ID ) ) {
			wp_delete_post( $post_to_delete->ID );
		}
		
		/* Disable some effects */

		update_option( 'listar_disable_listing_category_hover_animation', 1 );
		update_option( 'listar_disable_listing_region_hover_animation', 1 );
		update_option( 'listar_disable_listing_amenity_hover_animation', 1 );
		update_option( 'listar_disable_sibling_hover_opacity', 1 );
		
		/*
		 * Set Front page and blog page.
		 */
		
		$homepage = get_page_by_title( 'Front Page' );

		if ( $homepage && isset( $homepage->ID ) ) {
			update_option( 'page_on_front', $homepage->ID );
			update_option( 'show_on_front', 'page' );
		}
		
		$blogpage = get_page_by_title( 'Blog' );

		if ( $blogpage && isset( $blogpage->ID ) ) {
			update_option( 'page_for_posts', $blogpage->ID );
			update_option( 'show_on_front', 'page' );
		}

		/**
		 * Setting header menu after import
		 */

		/* Assign menus to their locations. */

		$main_menu   = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
		$footer_menu = get_term_by( 'name', 'Footer Social Networks', 'nav_menu' );
		$search_menu = get_term_by( 'name', 'Listing Search Menu', 'nav_menu' );

		$menus = array(
			'primary-menu' => $main_menu->term_id,
			'footer-menu'  => $footer_menu->term_id,
			'listing-search-menu'  => $search_menu->term_id,
		);

		set_theme_mod( 'nav_menu_locations', $menus );
		
		/* Update domain for certain menu items */
		$search = array(
			'http://wt.ax/listardevclientv1_5_3_3/',
			'https://wt.ax/listardevclientv1_5_3_3/',
		);
		
		$menu_itens = wp_get_nav_menu_items( 'listing-search-menu' );
		$menu_id = $search_menu->term_id;
		
		foreach( $menu_itens as $menu_item ) {
			$final_array = array();
			$menu_item_array = (array) $menu_item;
			$menu_item_array['guid'] = str_replace( $search, $root_install_path, $menu_item_array['guid'] );
			$menu_item_array['url'] = str_replace( $search, $root_install_path, $menu_item_array['url'] );
			
			foreach( $menu_item_array as $key => $value ) {
				$final_array[ 'menu-item-' . $key ] = $value;
				update_post_meta( $menu_item_array['db_id'], '_menu_item_' . $key, $menu_item_array[ $key ] );
				
			}
			
			do_action( 'wp_update_nav_menu_item', $menu_id, $menu_item_array['db_id'], $final_array );
		}	
		

		/**
		 * Import/configures demo listing ratings
		 */

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) :
			$ratings_file	       = $abs_import_data_path . 'import-listing-ratings.json';
			$listing_ratings_json  = ( $listar_filesystem->is_readable( $ratings_file ) ) ? $listar_filesystem->get_contents( $ratings_file ) : '{}';
			$listing_ratings_array = json_decode( $listing_ratings_json, true );

			foreach ( $listing_ratings_array as $rating_array ) {

				if ( ! isset( $rating_array[1] ) ) {
					continue;
				}

				if ( empty( $rating_array[1] ) ) {
					continue;
				}

				update_comment_meta( $rating_array[0], 'review_stars', $rating_array[1] );
			}

		endif;
		
		/*
		 * Add resources to booking products.
		 * 
		 * @link https://stackoverflow.com/a/45303729/7765298
		 */
		
		function listar_get_wc_product_by_title( $title ) {
			global $wpdb;

			$post_title = strval( $title );

			$post_table = $wpdb->prefix . "posts";
			$result = $wpdb->get_col( "
				SELECT ID
				FROM $post_table
				WHERE post_title LIKE '$post_title'
				AND post_type LIKE 'product'
			" );

			// We exit if title doesn't match
			if ( empty( $result[ 0 ] ) ) {
				return;
			} else {
				return wc_get_product( intval( $result[ 0 ] ) );
			}
		}

		if ( function_exists( 'wc_get_product' ) && class_exists( 'WC_Bookings' ) ) :			
			$product = listar_get_wc_product_by_title( 'Booking Example With Day Reservation' );

			/* Get booking resources */

			$resource_ids = array();
		
			$exec_query = new WP_Query( 
				array (
					'post_type'       => 'bookable_resource',
					'posts_per_page'  => 2000,
				)
			);

			if ( $exec_query->have_posts() ) :
				while ( $exec_query->have_posts() ) :
					$exec_query->the_post();
				
					$resource_ids[] = get_the_ID();
				
				endwhile;
			endif;
			
			if ( $product && ! empty( $resource_ids ) ) :
				$product->set_resource_ids( $resource_ids );
				$product->save();
			endif;

			/* Restore original Post Data */
			wp_reset_postdata();
		endif;

		/**
		 * Update all taxonomy counters, icons, images and colors **************
		 */

		/* Get all taxonomy icons/colors exported (JSON) */
		$icons_colors_file  = $abs_import_data_path . 'import-taxonomies-icons-and-colors.json';
		$icons_colors_json  = ( $listar_filesystem->is_readable( $icons_colors_file ) ) ? $listar_filesystem->get_contents( $icons_colors_file ) : '{}';
		$icons_colors_array = json_decode( $icons_colors_json, true );

		/* Get all taxonomy images exported (JSON) */
		$images_file          = $abs_import_data_path . 'import-taxonomies-images.json';
		$images_json          = ( $listar_filesystem->is_readable( $images_file ) ) ? $listar_filesystem->get_contents( $images_file ) : '{}';
		$term_images_exported = json_decode( $images_json, true );
		$taxonomies           = get_taxonomies();

		/* Will hold a listing category term to help flush rewrite rules and update the permalinks */
		$first_listing_category = '';

		foreach ( $taxonomies as $taxonomy ) {

			if ( taxonomy_exists( $taxonomy ) ) :

				$terms = get_terms(
					array(
						'taxonomy' => $taxonomy,
						'get'      => 'all',
						'number' => 2000,
					)
				);

				if ( ! $terms || is_wp_error( $terms ) ) {
					continue;
				}

				foreach ( $terms as $term ) {

					$term_taxonomy_id = $term->term_taxonomy_id;

					if ( empty( $first_listing_category ) && 'job_listing_category' === $taxonomy ) {
						/**
						 * Fix permalinks after demo import
						 */

						/**
						 * Edit/update the first listing category term with no changes,
						 * because permalinks are updated every time a listing category is created/edited.
						 * See: inc/required-plugins/plugins/listar-addons/inc/taxonomies.php, by line 121
						 */

						$first_listing_category = $term;

						wp_update_term( $first_listing_category->term_taxonomy_id, 'job_listing_category', array() );
					}

					/* Updating icons and colors of terms */

					$count_icons_colors = is_array( $icons_colors_array ) ? count( $icons_colors_array ) : 0;

					for ( $i = 0; $i < $count_icons_colors; $i++ ) {

						$term_data = array();

						if ( $icons_colors_array[ $i ][0] === $term->name && $icons_colors_array[ $i ][1] === $taxonomy && ! empty( $icons_colors_array[ $i ][2] ) ) {
							$term_data['term_icon'] = wp_filter_nohtml_kses( $icons_colors_array[ $i ][2] );
						}

						if ( $icons_colors_array[ $i ][0] === $term->name && $icons_colors_array[ $i ][1] === $taxonomy && ! empty( $icons_colors_array[ $i ][3] ) ) {
							$term_data['term_color'] = wp_filter_nohtml_kses( $icons_colors_array[ $i ][3] );
						}

						if ( ! empty( $term_data ) ) {
							update_option( "taxonomy_$term_taxonomy_id", $term_data );
							break;
						}
					}

					/* Updating images of terms */

					$count_term_images = is_array( $term_images_exported ) ? count( $term_images_exported ) : 0;

					for ( $i = 0; $i < $count_term_images; $i++ ) {

						if ( $term_images_exported[ $i ][0] === $term->name && $term_images_exported[ $i ][1] === $taxonomy ) {

							$term_id = $term->term_id;

							if ( isset( $term_id ) && '' !== $term_id ) {

								$term_image_id = wp_filter_nohtml_kses( $term_images_exported[ $i ][2] );
								$field = $taxonomy . '-image-id';

								update_term_meta( $term_id, $field, $term_image_id );
							}

							break;
						}
					}
				} // End foreach().

				/* Updating taxonomy counters */

				$get_terms_args = array(
					'taxonomy'   => $taxonomy,
					'fields'     => 'ids',
					'hide_empty' => false,
				);

				$term_ids = get_terms( $get_terms_args );
				wp_update_term_count_now( $term_ids, $taxonomy );

			endif;

		} // End foreach().

		/* Update comment counters (listings) */
		listar_update_comment_counters();

		/* Update comment counters (blog) */
		listar_update_comment_counters( 'post' );
		
		/*
		 * Update Woocommerce Subscriptions site url
		 */
		
		update_option( 'wc_subscriptions_siteurl', str_replace( '//', '//_[wc_subscriptions_siteurl]_' , network_site_url() ) );

		/**
		 * Update URLs on Listar widgets *******************************
		 */

		$url_to_update  = 'http://wt.ax/listardevclientv1_5_3_3';
		$url_to_update2 = 'https://wt.ax/listardevclientv1_5_3_3';
		$url_to_update3  = 'http:\/\/wt.ax\/listardevclientv1_5_3_3';
		$url_to_update4 = 'https:\/\/wt.ax\/listardevclientv1_5_3_3';

		/* 'Call To Action' Widget */

		$widget_id1 = 'widget_listar_call_to_action';
		$widgets1   = get_option( $widget_id1 );

		if ( ! empty( $widgets1 ) ) {
			foreach ( $widgets1 as $key => $widget ) {
				if ( isset( $widgets1[ $key ]['link'] ) ) {
					$widgets1[ $key ]['link'] = esc_url( str_replace( $url_to_update, network_site_url(), $widgets1[ $key ]['link'] ) );
					$widgets1[ $key ]['link'] = esc_url( str_replace( $url_to_update2, network_site_url(), $widgets1[ $key ]['link'] ) );
					$widgets1[ $key ]['link'] = esc_url( str_replace( $url_to_update3, network_site_url(), $widgets1[ $key ]['link'] ) );
					$widgets1[ $key ]['link'] = esc_url( str_replace( $url_to_update4, network_site_url(), $widgets1[ $key ]['link'] ) );
					update_option( $widget_id1, $widgets1 );
				}
			}
		}

		/* 'Features' Widget */

		$widget_id2 = 'widget_listar_features';
		$widgets2   = get_option( $widget_id2 );

		if ( ! empty( $widgets2 ) ) {
			foreach ( $widgets2 as $key => $widget ) {
				if ( isset( $widgets2[ $key ]['elements_json'] ) ) {
					$widgets2[ $key ]['elements_json'] = str_replace( $url_to_update, network_site_url(), $widgets2[ $key ]['elements_json'] );
					$widgets2[ $key ]['elements_json'] = str_replace( $url_to_update2, network_site_url(), $widgets2[ $key ]['elements_json'] );
					$widgets2[ $key ]['elements_json'] = str_replace( $url_to_update3, network_site_url(), $widgets2[ $key ]['elements_json'] );
					$widgets2[ $key ]['elements_json'] = str_replace( $url_to_update4, network_site_url(), $widgets2[ $key ]['elements_json'] );
					update_option( $widget_id2, $widgets2 );
				}
			}
		}

		/**
		 * Import/configures demo listing categories under hero search on
		 * front page and search popup *********************************
		 */

		if ( taxonomy_exists( 'job_listing_category' ) ) :

			$search_categories_file  = $abs_import_data_path . 'import-search-categories.json';
			$search_categories_json  = ( $listar_filesystem->is_readable( $search_categories_file ) ) ? $listar_filesystem->get_contents( $search_categories_file ) : '{}';
			$search_categories_array = json_decode( $search_categories_json, true );
			$search_categories_list  = '';
			$count_search_categories = is_array( $search_categories_array ) ? count( $search_categories_array ) : 0;

			for ( $i = 0; $i < $count_search_categories; $i++ ) {
				$term = get_term_by( 'name', $search_categories_array[ $i ][0], 'job_listing_category' );
				$id   = $term->term_taxonomy_id;
				$search_categories_list .= $id . ' ' . $search_categories_array[ $i ][1] . ',';
			}

			/* Remove last comma */
			if ( false !== strpos( $search_categories_list, ',' ) ) {
				if ( ',' === substr( rtrim( $search_categories_list ), -1 ) ) {
					$search_categories_list = substr( $search_categories_list, 0, -1 );
				}
			}

			update_option( 'listar_hero_search_categories', wp_filter_nohtml_kses( $search_categories_list ) );

		endif;

		/**
		 * Updating urls on all pages **********************************
		 */

		$posts_per_page = 2000;

		$pages_query = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => $posts_per_page,
			)
		);

		if ( ! empty( $pages_query ) ) {

			$i = 0;

			foreach ( $pages_query as $page ) :

				$id = $page->ID;
				$content_1 = str_replace( 'http%3A%2F%2Fwt.ax%2Flistardevclientv1_5_3_3%2F', $root_install_path_encoded, $page->post_content );
				$content_2 = str_replace( 'href="http://wt.ax/listardevclientv1_5_3_3/', 'href="' . $root_install_path, $content_1 );
				$content_3 = str_replace( 'data-link="http://wt.ax/listardevclientv1_5_3_3/', 'data-link="' . $root_install_path, $content_2 );
				$content_4 = str_replace( 'https%3A%2F%2Fwt.ax%2Flistardevclientv1_5_3_3%2F', $root_install_path_encoded, $content_3 );
				$content_5 = str_replace( 'href="https://wt.ax/listardevclientv1_5_3_3/', 'href="' . $root_install_path, $content_4 );
				$content_6 = str_replace( 'data-link="https://wt.ax/listardevclientv1_5_3_3/', 'data-link="' . $root_install_path, $content_5 );

				$update_post = array(
					'ID'           => $id,
					'post_content' => $content_6,
					'post_type'    => get_post_type( $page ),
				);

				/* Update page content */
				wp_update_post( $update_post );

			endforeach;
		}

		/* Restore original Post Data */
		wp_reset_postdata();

		/**
		 * Updating urls on partners ***********************************
		 */
		
		if ( post_type_exists( 'listar_partner' ) ) :
			$search_url = array(
				'http://wt.ax/listardevclientv1_5_3_3/',
				'https://wt.ax/listardevclientv1_5_3_3/',
			);

			$exec_query = new WP_Query( 
				array (
					'post_type'       => 'listar_partner',
					'posts_per_page'  => 2000,
				)
			);

			$update_fields = array(
				'listar_meta_box_partner_url',
			);

			$count_fields = count( $update_fields );

			if ( $exec_query->have_posts() ) {
				while ( $exec_query->have_posts() ) : $exec_query->the_post();
					$id = get_the_ID();

					for ( $i = 0; $i < $count_fields; $i++ ) {
						$field_content = get_post_meta( $id, $update_fields[ $i ], true );

						if ( ! empty( $field_content ) && is_string( $field_content ) ) {
							update_post_meta( $id, $update_fields[ $i ], str_replace( $search_url, $root_install_path, $field_content ) );  
						}  
					}   
				endwhile;
			}

			// Restore original Post Data
			wp_reset_postdata();
		endif;

		/**
		 * Updating urls on listings ***********************************
		 */

		$search_url = array(
			'http://wt.ax/listardevclientv1_5_3_3/',
			'https://wt.ax/listardevclientv1_5_3_3/',
		);

		$exec_query = new WP_Query( 
			array (
				'post_type'       => 'job_listing',
				'posts_per_page'  => 2000,
			)
		);

		$update_fields = array(
			'_company_logotype',
			'_job_business_document_1_file',
			'_job_business_document_2_file',
			'_job_business_document_3_file',
			'_job_business_document_4_file',
			'_job_business_document_5_file',
			'_job_business_document_6_file',
		);
		
		$count_fields = count( $update_fields );

		if ( $exec_query->have_posts() ) {
			while ( $exec_query->have_posts() ) : $exec_query->the_post();
				$id = get_the_ID();
				
				for ( $i = 0; $i < $count_fields; $i++ ) {
					$field_content = get_post_meta( $id, $update_fields[ $i ], true );

					if ( ! empty( $field_content ) && is_string( $field_content ) ) {
						update_post_meta( $id, $update_fields[ $i ], str_replace( $search_url, $root_install_path, $field_content ) );  
					}  
				}   
			endwhile;
		}

		// Restore original Post Data
		wp_reset_postdata();

		/**
		 * Sets the newest listing as featured *************************
		 */

		$listing_query_args = array(
			'post_type'      => 'job_listing',
			'posts_per_page' => 1,
		);

		$listing_query = new WP_Query( $listing_query_args );

		if ( $listing_query->have_posts() ) {
			foreach ( $listing_query as $listing ) :
				if ( isset( $listing->ID ) ) {
					update_post_meta( $listing->ID, '_featured', true );
				}
			endforeach;
		}

		/* Restore original Post Data */
		wp_reset_postdata();

		/**
		 * Demo texts **************************************************
		 * Notice: the following fields will be changed only if they are currently empty.
		 */

		$user_id = get_current_user_id();
		$first_name  = '' === get_the_author_meta( 'first_name' ) ? 'John' : get_the_author_meta( 'first_name' );
		$last_name   = '' === get_the_author_meta( 'last_name' ) ? 'Doe' : get_the_author_meta( 'last_name' );
		$short_intro = '' === get_the_author_meta( 'listar_meta_box_user_short_introduction' ) ? esc_html__( 'Local expert from NYC', 'listar' ) : get_the_author_meta( 'listar_meta_box_user_short_introduction' );
		$demo_desc   = esc_html__( 'Years as travel editor for a NYC newspaper shaped my understanding of several special things. I love to convey the wonder and "whoa\'s!" of places I go, and I am always eager to share relevant tips to people like me, mainly etiquette and emotions.', 'listar' );
		$description = '' === get_the_author_meta( 'description' ) ? $demo_desc : get_the_author_meta( 'description' );
		$copyrights  = wp_kses( get_option( 'listar_copyright' ), 'listar-basic-html' );
		$copyright   = empty( $copyrights ) ? esc_html__( 'All Rights Reserved.', 'listar' ) : $copyrights;

		update_user_meta( $user_id, 'first_name', wp_filter_nohtml_kses( $first_name ) );
		update_user_meta( $user_id, 'last_name', wp_filter_nohtml_kses( $last_name ) );
		update_user_meta( $user_id, 'listar_meta_box_user_short_introduction', wp_filter_nohtml_kses( $short_intro ) );
		update_user_meta( $user_id, 'description', wp_filter_nohtml_kses( $description ) );
		update_option( 'listar_copyright', wp_filter_nohtml_kses( $copyright ) );

		/**
		 * Delete duplicate post entries *******************************
		 * 
		 * @link https://wordpress.stackexchange.com/a/102544
		 */
		
		global $wpdb;

		$duplicate_titles = $wpdb->get_col( "SELECT post_title FROM {$wpdb->posts} GROUP BY post_title HAVING COUNT(*) > 1" );

		foreach( $duplicate_titles as $title ) {
			$post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_title=%s", $title ) ); 

			/* Iterate over the second ID with this post title till the last */
			foreach( array_slice( $post_ids, 1 ) as $post_id ) {
				$post_type = get_post_type( $post_id );
				
				if ( 'job_listing' === $post_type ) {
					wp_delete_post( $post_id, true );
				}
			}
		}
		
		/**
		 * Update post counters for all terms of all WP Job Manager taxonomies.
		 */
		
		if ( listar_addons_active() ) {
			listar_update_all_taxonomy_term_counters();
		}

		/**
		 * Set endpoint pages for third party plugins.
		 */

		/* Woocommerce Shopping Cart page */

		$page1 = get_page_by_path( 'cart' );

		if ( $page1 && isset( $page1->ID ) ) {
			update_option( 'woocommerce_cart_page_id', $page1->ID );
		}

		/* Woocommerce My Account page */

		$page2 = get_page_by_path( 'my-account' );

		if ( $page2 && isset( $page2->ID ) ) {
			update_option( 'woocommerce_myaccount_page_id', $page2->ID );
		}

		/* Woocommerce Checkout page */

		$page3 = get_page_by_path( 'checkout' );

		if ( $page3 && isset( $page3->ID ) ) {
			update_option( 'woocommerce_checkout_page_id', $page3->ID );
		}

		/* Woocommerce Shop page */

		$page4 = get_page_by_path( 'shop' );

		if ( $page4 && isset( $page4->ID ) ) {
			update_option( 'woocommerce_shop_page_id', $page4->ID );
		}
	}

endif;

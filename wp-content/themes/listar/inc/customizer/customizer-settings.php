<?php
/**
 * WordPress Customizer additions (custom settings)
 *
 * @package Listar
 */

add_action( 'customize_register', 'listar_modify_customizer_defaults' );

if ( ! function_exists( 'listar_modify_customizer_defaults' ) ) :
	/**
	 * Modify Customizer defaults.
	 *
	 * @since 1.0
	 * @param (object) $wp_customize The WordPress Customizer object, containing all settings, sections and controls.
	 */
	function listar_modify_customizer_defaults( $wp_customize ) {

		/* Require advanced Customizer controls ***********************/

		require_once listar_get_theme_file_path( '/inc/customizer/advanced-controls/class-listar-multiple-select-control.php' );

		/* Remove the 'Background Color' control, it will be moved to the new Colors section for better organization */

		$wp_customize->remove_control( 'background_color' );
		$wp_customize->remove_section( 'colors' );

		/* Add height selector for custom logo */

		$listar_logo_sizes_desktop = array(
			'44px' => '44px',
			'60px' => '60px',
			'70px' => '70px',
			'80px' => '80px',
		);

		$wp_customize->add_setting(
			'listar_logo_height_desktop',
			array(
				'default'           => '44px',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'listar_logo_height_desktop_control',
			array(
				'type'        => 'select',
				'section'     => 'title_tagline',
				'settings'    => 'listar_logo_height_desktop',
				'priority'    => 9,
				'label'       => esc_html__( 'Logo height (Desktop)', 'listar' ),
				'choices'     => $listar_logo_sizes_desktop,
			)
		);

		$listar_logo_sizes_mobile = array(
			'35px' => '35px',
			'42px' => '42px',
			'50px' => '50px',
			'60px' => '60px',
		);

		$wp_customize->add_setting(
			'listar_logo_height_mobile',
			array(
				'default'           => '35px',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'listar_logo_height_mobile_control',
			array(
				'type'        => 'select',
				'section'     => 'title_tagline',
				'settings'    => 'listar_logo_height_mobile',
				'priority'    => 9.1,
				'label'       => esc_html__( 'Logo height (Mobile)', 'listar' ),
				'choices'     => $listar_logo_sizes_mobile,
			)
		);

		/* Adding all panels */

		$wp_customize->add_panel(
			'colors',
			array(
				'title'    => esc_html__( 'Colors', 'listar' ),
				'priority' => 29,
			)
		);

		/* Theme Color ************************************************/

		/* Add a section to a panel */

		$wp_customize->add_section(
			'theme-color-section',
			array(
				'title' => esc_html__( 'Theme Color', 'listar' ),
				'panel' => 'colors',
			)
		);

		/* Add theme color picker setting */

		$wp_customize->add_setting(
			'listar_theme_color',
			array(
				'default'           => '258bd5',
				'transport'         => 'refresh',
				'sanitize_callback' => 'listar_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'listar_theme_color_control',
				array(
					'label'    => esc_html__( 'Theme Color', 'listar' ),
					'section'  => 'theme-color-section',
					'settings' => 'listar_theme_color',
					'priority' => 1,
				)
			)
		);
		
		/* Loading Overlay *************/

		/* Enable loading overlay */
		$enable_loading_overlay = listar_is_loading_overlay_active();

		if ( $enable_loading_overlay ) {

			/* Add a section to a panel */

			$wp_customize->add_section(
				'loading-overlay-section',
				array(
					'title' => esc_html__( 'Loading Overlay', 'listar' ),
					'panel' => 'colors',
				)
			);

			$wp_customize->add_setting(
				'listar_loading_overlay_background_color',
				array(
					'default'           => '23282d',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_loading_overlay_background_color_control',
					array(
						'label'    => esc_html__( 'Background Color for Loading Overlay', 'listar' ),
						'section'  => 'loading-overlay-section',
						'settings' => 'listar_loading_overlay_background_color',
						'priority' => 1,
					)
				)
			);
		}
		
		/* Main Menu and Footer *************/

		/* Add a section to a panel */

		$wp_customize->add_section(
			'header-and-footer-section',
			array(
				'title' => esc_html__( 'Main Menu and Footer', 'listar' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_setting(
			'listar_main_menu_background_color',
			array(
				'default'           => '23282d',
				'transport'         => 'refresh',
				'sanitize_callback' => 'listar_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'listar_main_menu_background_color_control',
				array(
					'label'    => esc_html__( 'Background Color for Main Menu', 'listar' ),
					'section'  => 'header-and-footer-section',
					'settings' => 'listar_main_menu_background_color',
					'priority' => 1,
				)
			)
		);
		
		$footer_column_1_active = 1 === (int) get_option( 'listar_footer_column_1' ) ? true : false;
		$footer_column_2_active = 1 === (int) get_option( 'listar_footer_column_2' ) ? true : false;
		$footer_column_3_active = 1 === (int) get_option( 'listar_footer_column_3' ) ? true : false;
		$footer_column_4_active = 1 === (int) get_option( 'listar_footer_column_4' ) ? true : false;
		
		if ( $footer_column_1_active || $footer_column_2_active || $footer_column_3_active || $footer_column_4_active ) {
			
			$wp_customize->add_setting(
				'listar_footer_columns_background_color',
				array(
					'default'           => '23282d',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_footer_columns_background_color_control',
					array(
						'label'    => esc_html__( 'Background Color for Footer Columns', 'listar' ),
						'section'  => 'header-and-footer-section',
						'settings' => 'listar_footer_columns_background_color',
						'priority' => 1,
					)
				)
			);
		}

		$wp_customize->add_setting(
			'listar_footer_menu_background_color',
			array(
				'default'           => '2d3237',
				'transport'         => 'refresh',
				'sanitize_callback' => 'listar_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'listar_footer_menu_background_color_control',
				array(
					'label'    => esc_html__( 'Background Color for Footer Menu', 'listar' ),
					'section'  => 'header-and-footer-section',
					'settings' => 'listar_footer_menu_background_color',
					'priority' => 1,
				)
			)
		);

		$wp_customize->add_setting(
			'listar_footer_credits_background_color',
			array(
				'default'           => '23282d',
				'transport'         => 'refresh',
				'sanitize_callback' => 'listar_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'listar_footer_credits_background_color_control',
				array(
					'label'    => esc_html__( 'Background Color for Footer Credits', 'listar' ),
					'section'  => 'header-and-footer-section',
					'settings' => 'listar_footer_credits_background_color',
					'priority' => 1,
				)
			)
		);

		if ( class_exists( 'WP_Job_Manager' ) ) {

			/* Front Page Hero Header - Overlay Color *************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'front-page-header-section',
				array(
					'title' => esc_html__( 'Front Page Header', 'listar' ),
					'panel' => 'colors',
				)
			);

			$wp_customize->add_setting(
				'listar_frontpage_hero_overlay_color',
				array(
					'default'           => '000000',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_frontpage_hero_overlay_color_control',
					array(
						'label'    => esc_html__( 'Background Color', 'listar' ),
						'section'  => 'front-page-header-section',
						'settings' => 'listar_frontpage_hero_overlay_color',
						'priority' => 1,
					)
				)
			);

			/* Front Page Hero Header - Overlay Opacity ***********/

			$wp_customize->add_setting(
				'listar_frontpage_hero_overlay_opacity',
				array(
					'default'           => 0.35,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$opacity_count  = 0;
			$opacity_values = array();

			while ( $opacity_count < 1.05 ) {
				$opacity_values[ (string) $opacity_count ] = $opacity_count;
				$opacity_count  += 0.05;
			}

			$wp_customize->add_control(
				'listar_frontpage_hero_overlay_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
					'section'  => 'front-page-header-section',
					'settings' => 'listar_frontpage_hero_overlay_opacity',
					'choices'  => $opacity_values,
					'priority' => 2,
				)
			);

			/* Front Page Hero Header - Overlay Secondary Color (Gradient)*/

			$wp_customize->add_setting(
				'listar_frontpage_hero_overlay_secondary_color',
				array(
					'default'           => 'ffffff',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_frontpage_hero_overlay_secondary_color_control',
					array(
						'label'       => esc_html__( 'Secondary Background Color', 'listar' ),
						'section'     => 'front-page-header-section',
						'settings'    => 'listar_frontpage_hero_overlay_secondary_color',
						'description' => esc_html__( 'If default be changed, it will output a gradient. If not, only the primary color will be used.', 'listar' ),
						'priority'    => 3,
					)
				)
			);

			/* Front Page Hero Header - Overlay Secondary Opacity */

			$wp_customize->add_setting(
				'listar_frontpage_hero_overlay_secondary_opacity',
				array(
					'default'           => 0.95,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$secondary_opacity_count  = 0;
			$secondary_opacity_values = array();

			while ( $secondary_opacity_count < 1.05 ) {
				$secondary_opacity_values[ (string) $secondary_opacity_count ] = $secondary_opacity_count;
				$secondary_opacity_count  += 0.05;
			}

			$wp_customize->add_control(
				'listar_frontpage_hero_overlay_secondary_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Secondary Background Color Opacity', 'listar' ),
					'section'  => 'front-page-header-section',
					'settings' => 'listar_frontpage_hero_overlay_secondary_opacity',
					'choices'  => $secondary_opacity_values,
					'priority' => 4,
				)
			);

			/* Search Popup - Overlay Color ***********************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'search-popup-section',
				array(
					'title' => esc_html__( 'Search Popup', 'listar' ),
					'panel' => 'colors',
				)
			);

			/* Add color picker setting */

			$wp_customize->add_setting(
				'listar_search_overlay_color',
				array(
					'default'           => '000000',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_search_overlay_color_control',
					array(
						'label'    => esc_html__( 'Background Color', 'listar' ),
						'section'  => 'search-popup-section',
						'settings' => 'listar_search_overlay_color',
						'priority' => 1,
					)
				)
			);

			/* Search Popup - Overlay Opacity *********************/

			$wp_customize->add_setting(
				'listar_search_overlay_opacity',
				array(
					'default'           => 0.35,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$wp_customize->add_control(
				'listar_search_overlay_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
					'section'  => 'search-popup-section',
					'settings' => 'listar_search_overlay_opacity',
					'choices'  => $opacity_values,
					'priority' => 1,
				)
			);

			/* Search Popup - Overlay Secondary Color (Gradient)***/

			$wp_customize->add_setting(
				'listar_search_overlay_secondary_color',
				array(
					'default'           => 'ffffff',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_search_overlay_secondary_color_control',
					array(
						'label'       => esc_html__( 'Secondary Background Color', 'listar' ),
						'section'     => 'search-popup-section',
						'settings'    => 'listar_search_overlay_secondary_color',
						'description' => esc_html__( 'If default be changed, it will output a gradient. If not, only the primary color will be used.', 'listar' ),
						'priority'    => 3,
					)
				)
			);

			/* Search Popup -  Overlay Secondary Opacity **********/

			$wp_customize->add_setting(
				'listar_search_overlay_secondary_opacity',
				array(
					'default'           => 0.95,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$secondary_search_opacity_count  = 0;
			$secondary_search_opacity_values = array();

			while ( $secondary_search_opacity_count < 1.05 ) {
				$secondary_search_opacity_values[ (string) $secondary_search_opacity_count ] = $secondary_search_opacity_count;
				$secondary_search_opacity_count  += 0.05;
			}

			$wp_customize->add_control(
				'listar_search_overlay_secondary_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Secondary Background Color Opacity', 'listar' ),
					'section'  => 'search-popup-section',
					'settings' => 'listar_search_overlay_secondary_opacity',
					'choices'  => $secondary_search_opacity_values,
					'priority' => 4,
				)
			);
			
			$listar_is_search_by_options_active = listar_addons_active() ? listar_is_search_by_options_active() : false;
			
			if ( $listar_is_search_by_options_active ) {

				/* Explore By Popup - Overlay Color ***********************/

				/* Add a section to a panel */

				$wp_customize->add_section(
					'search-by-popup-section',
					array(
						'title' => esc_html__( 'Explore By Popup', 'listar' ),
						'panel' => 'colors',
					)
				);

				/* Explore By Popup */

				$wp_customize->add_setting(
					'listar_search_by_overlay_color',
					array(
						'default'           => 'ffffff',
						'transport'         => 'refresh',
						'sanitize_callback' => 'listar_sanitize_color',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						'listar_search_by_overlay_color_control',
						array(
							'label'    => esc_html__( 'Background Color', 'listar' ),
							'section'  => 'search-by-popup-section',
							'settings' => 'listar_search_by_overlay_color',
							'priority' => 1,
						)
					)
				);

				/* Explore By Popup - Overlay Opacity *********************/

				$wp_customize->add_setting(
					'listar_search_by_overlay_opacity',
					array(
						'default'           => 0.35,
						'transport'         => 'refresh',
						'sanitize_callback' => 'esc_attr',
					)
				);

				$wp_customize->add_control(
					'listar_search_by_overlay_opacity_control',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
						'section'  => 'search-by-popup-section',
						'settings' => 'listar_search_by_overlay_opacity',
						'choices'  => $opacity_values,
						'priority' => 1,
					)
				);

				/* Explore By Popup - Overlay Secondary Color (Gradient)***/

				$wp_customize->add_setting(
					'listar_search_by_overlay_secondary_color',
					array(
						'default'           => 'ffffff',
						'transport'         => 'refresh',
						'sanitize_callback' => 'listar_sanitize_color',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						'listar_search_by_overlay_secondary_color_control',
						array(
							'label'       => esc_html__( 'Secondary Background Color', 'listar' ),
							'section'     => 'search-by-popup-section',
							'settings'    => 'listar_search_by_overlay_secondary_color',
							'description' => esc_html__( 'If default be changed, it will output a gradient. If not, only the primary color will be used.', 'listar' ),
							'priority'    => 3,
						)
					)
				);

				/* Explore By Popup -  Overlay Secondary Opacity **********/

				$wp_customize->add_setting(
					'listar_search_by_overlay_secondary_opacity',
					array(
						'default'           => 0.95,
						'transport'         => 'refresh',
						'sanitize_callback' => 'esc_attr',
					)
				);

				$secondary_search_by_opacity_count  = 0;
				$secondary_search_by_opacity_values = array();

				while ( $secondary_search_by_opacity_count < 1.05 ) {
					$secondary_search_by_opacity_values[ (string) $secondary_search_by_opacity_count ] = $secondary_search_by_opacity_count;
					$secondary_search_by_opacity_count  += 0.05;
				}

				$wp_customize->add_control(
					'listar_search_by_overlay_secondary_opacity_control',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Secondary Background Color Opacity', 'listar' ),
						'section'  => 'search-by-popup-section',
						'settings' => 'listar_search_by_overlay_secondary_opacity',
						'choices'  => $secondary_search_by_opacity_values,
						'priority' => 4,
					)
				);
			}

		}// End if().

		if ( listar_addons_active() ) {

			/* Login Popup - Overlay Color ************************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'login-popup-section',
				array(
					'title' => esc_html__( 'Login Popup', 'listar' ),
					'panel' => 'colors',
				)
			);

			/* Add color picker setting */

			$wp_customize->add_setting(
				'listar_login_overlay_color',
				array(
					'default'           => '000000',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_login_overlay_color_control',
					array(
						'label'    => esc_html__( 'Background Color', 'listar' ),
						'section'  => 'login-popup-section',
						'settings' => 'listar_login_overlay_color',
						'priority' => 1,
					)
				)
			);

			/* Login Popup - Overlay Opacity **********************/

			$wp_customize->add_setting(
				'listar_login_overlay_opacity',
				array(
					'default'           => 0.35,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$wp_customize->add_control(
				'listar_login_overlay_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
					'section'  => 'login-popup-section',
					'settings' => 'listar_login_overlay_opacity',
					'choices'  => $opacity_values,
					'priority' => 1,
				)
			);

		}// End if().

		if ( class_exists( 'WP_Job_Manager' ) && ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) ) {

			/* Review Popup - Overlay Color ***********************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'review-popup-section',
				array(
					'title' => esc_html__( 'Review Popup', 'listar' ),
					'panel' => 'colors',
				)
			);

			/* Add color picker setting */

			$wp_customize->add_setting(
				'listar_review_overlay_color',
				array(
					'default'           => '000000',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_review_overlay_color_control',
					array(
						'label'    => esc_html__( 'Background Color', 'listar' ),
						'section'  => 'review-popup-section',
						'settings' => 'listar_review_overlay_color',
						'priority' => 1,
					)
				)
			);

			/* Review Popup - Overlay Opacity *********************/

			$wp_customize->add_setting(
				'listar_review_overlay_opacity',
				array(
					'default'           => 0.35,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$wp_customize->add_control(
				'listar_review_overlay_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
					'section'  => 'review-popup-section',
					'settings' => 'listar_review_overlay_opacity',
					'choices'  => $opacity_values,
					'priority' => 1,
				)
			);

		}// End if().

		if ( class_exists( 'WP_Job_Manager' ) && listar_addons_active() && listar_built_in_reviews_active() && ! ( 1 === (int) get_option( 'listar_complaint_reports_disable' ) ) ) {

			/* Complaint Report Popup - Overlay Color ***********************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'complaint-popup-section',
				array(
					'title' => esc_html__( 'Complaint Report Popup', 'listar' ),
					'panel' => 'colors',
				)
			);

			/* Add color picker setting */

			$wp_customize->add_setting(
				'listar_complaint_overlay_color',
				array(
					'default'           => '000000',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_complaint_overlay_color_control',
					array(
						'label'    => esc_html__( 'Background Color', 'listar' ),
						'section'  => 'complaint-popup-section',
						'settings' => 'listar_complaint_overlay_color',
						'priority' => 1,
					)
				)
			);

			/* Complaint Report Popup - Overlay Opacity *********************/

			$wp_customize->add_setting(
				'listar_complaint_overlay_opacity',
				array(
					'default'           => 0.35,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$wp_customize->add_control(
				'listar_complaint_overlay_opacity_control',
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Background Color Opacity', 'listar' ),
					'section'  => 'complaint-popup-section',
					'settings' => 'listar_complaint_overlay_opacity',
					'choices'  => $opacity_values,
					'priority' => 1,
				)
			);

		}// End if().

		/* Disable Customizer control - Header text color */

		$wp_customize->remove_control( 'header_textcolor' );

		/* Site Background Color **************************************/

		/* Add a section to a panel */

		$wp_customize->add_section(
			'background-color',
			array(
				'title' => esc_html__( 'Site Background Color', 'listar' ),
				'panel' => 'colors',
			)
		);

		/* Add theme color picker setting */

		$wp_customize->add_setting(
			'background_color',
			array(
				'default'           => 'ffffff',
				'transport'         => 'refresh',
				'sanitize_callback' => 'listar_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'background_color',
				array(
					'label'    => esc_html__( 'Site Background Color', 'listar' ),
					'section'  => 'background-color',
					'settings' => 'background_color',
					'priority' => 1,
				)
			)
		);
		
		if ( listar_addons_active() ) {

			/* Social Networks and Sharing Buttons *************/

			/* Add a section to a panel */

			$wp_customize->add_section(
				'listar-social-sharing-buttons',
				array(
					'title' => esc_html__( 'Social Networks and Sharing Buttons', 'listar' ),
					'panel' => 'colors',
				)
			);

			$wp_customize->add_setting(
				'listar_social_sharing_buttons_background_color',
				array(
					'default'           => 'ffffff',
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'listar_social_sharing_buttons_background_color_control',
					array(
						'label'    => esc_html__( 'Background Color for Social Networks and Sharing Buttons', 'listar' ),
						'section'  => 'listar-social-sharing-buttons',
						'settings' => 'listar_social_sharing_buttons_background_color',
						'priority' => 1,
					)
				)
			);
		}

		/* Google Fonts ***********************************************/

		if ( listar_google_fonts_active() ) {
			$wp_customize->add_section(
				'listar_google_fonts',
				array(
					'title'    => esc_html__( 'Google Fonts', 'listar' ),
					'priority' => 30,
				)
			);

			/* Default Google Fonts */

			$google_fonts_family_url = 'https://fonts.googleapis.com/css?family=';
			$google_fonts_sizes_subsets = ':400,500,600,700&amp;subset=latin-ext';

			$default_primary_google_font = $google_fonts_family_url . 'Open+Sans' . $google_fonts_sizes_subsets;
			$default_secondary_google_font = $google_fonts_family_url . 'Quicksand' . $google_fonts_sizes_subsets;
			$default_fonts = array();

			$default_fonts_names = array(
				'Amaranth',
				'Dosis',
				'Lato',
				'Merriweather',
				'Merriweather Sans',
				'Open Sans',
				'Oswald',
				'Quicksand',
				'Raleway',
				'Roboto',
				'Ubuntu',
				'Source Sans Pro',
			);

			$google_font_languages = array(
				'latin-ext'           => esc_html__( 'Latin Extended', 'listar' ),
				'bengali'             => esc_html__( 'Bengali', 'listar' ),
				'chinese-simplified'  => esc_html__( 'Chinese Simplified', 'listar' ),
				'chinese-traditional' => esc_html__( 'Chinese Traditional', 'listar' ),
				'cyrillic'            => esc_html__( 'Cyrillic', 'listar' ),
				'cyrillic-ext'        => esc_html__( 'Cyrillic Extended', 'listar' ),
				'devanagari'          => esc_html__( 'Devanagari', 'listar' ),
				'greek'               => esc_html__( 'Greek', 'listar' ),
				'greek-ext'           => esc_html__( 'Greek-ext', 'listar' ),
				'gujarati'            => esc_html__( 'Gujarati', 'listar' ),
				'gurmukhi'            => esc_html__( 'Gurmukhi', 'listar' ),
				'hebrew'              => esc_html__( 'Hebrew', 'listar' ),
				'japanese'            => esc_html__( 'Japanese', 'listar' ),
				'kannada'             => esc_html__( 'Kannada', 'listar' ),
				'khmer'               => esc_html__( 'Khmer', 'listar' ),
				'korean'              => esc_html__( 'Korean', 'listar' ),
				'malayalam'           => esc_html__( 'Malayalam', 'listar' ),
				'myanmar'             => esc_html__( 'Myanmar', 'listar' ),
				'oriya'               => esc_html__( 'Oriya', 'listar' ),
				'sinhala'             => esc_html__( 'Sinhala', 'listar' ),
				'tamil'               => esc_html__( 'Tamil', 'listar' ),
				'telugu'              => esc_html__( 'Telugu', 'listar' ),
				'thai'                => esc_html__( 'Thai', 'listar' ),
				'vietnamese'          => esc_html__( 'Vietnamese', 'listar' ),
			);

			$count_fonts = count( $default_fonts_names );

			for ( $i = 0; $i < $count_fonts; $i++ ) {
				$temp = array(
					$google_fonts_family_url . str_replace( ' ', '+', $default_fonts_names[ $i ] ) . $google_fonts_sizes_subsets => $default_fonts_names[ $i ],
				);

				$default_fonts = array_merge( $default_fonts, $temp );
			}

			/* Get custom fonts saved on Customize / Google Fonts */

			$custom_google_fonts = get_option( 'listar_custom_google_fonts' );
			$custom_fonts = array();

			if ( ! empty( $custom_google_fonts ) ) {

				$custom_google_fonts = array_unique( array_filter( explode( '---', $custom_google_fonts ) ) );

				foreach ( $custom_google_fonts as $custom_google_font ) :
					$google_font_family = listar_get_google_font_family( $custom_google_font );
					$custom_fonts[ $custom_google_font ] = str_replace( '+', ' ', $google_font_family );
				endforeach;
			}

			$display_fonts = array_unique( array_merge( $default_fonts, $custom_fonts ) );
			ksort( $display_fonts );

			/**
			 * If current primary or secondary font does not exist on 'listar_custom_google_fonts' theme option,
			 * nor on default fonts list, reset to default.
			 */

			$current_primary_font = get_theme_mod( 'listar_primary_google_font' );
			$current_secondary_font = get_theme_mod( 'listar_secondary_google_font' );

			if ( false !== strpos( $current_primary_font, '&' ) ) :
				/* Explode and get first part from string */
				$parts = explode( '&', $current_primary_font );
				$array = array_values( $parts );
				$current_primary_font = reset( $array );
			endif;

			if ( false !== strpos( $current_secondary_font, '&' ) ) :
				/* Explode and get first part from string */
				$parts = explode( '&', $current_secondary_font );
				$array = array_values( $parts );
				$current_secondary_font = reset( $array );
			endif;

			$saved_fonts = ! empty( $custom_google_fonts ) ? implode( ',', $custom_google_fonts ) : '';

			if ( ! empty( $current_primary_font ) && false === strpos( $saved_fonts, $current_primary_font ) && false === strpos( implode( ',', array_keys( $default_fonts ) ), $current_primary_font ) ) :
				set_theme_mod( 'listar_primary_google_font', $default_primary_google_font );
			endif;

			if ( ! empty( $current_secondary_font ) && false === strpos( $saved_fonts, $current_secondary_font ) && false === strpos( implode( ',', array_keys( $default_fonts ) ), $current_secondary_font ) ) :
				set_theme_mod( 'listar_secondary_google_font', $default_secondary_google_font );
			endif;

			/* Theme Primary Google Font - Select *************************/

			$wp_customize->add_setting(
				'listar_primary_google_font',
				array(
					'default'           => $default_primary_google_font,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'listar_primary_google_font_control',
				array(
					'type'        => 'select',
					'label'       => esc_html__( 'Body Font', 'listar' ),
					'description' => esc_html__( 'For general texts', 'listar' ),
					'section'     => 'listar_google_fonts',
					'settings'    => 'listar_primary_google_font',
					'choices'     => $display_fonts,
				)
			);

			/* Theme Secondary (Headings) Google Font - Select ************/

			$wp_customize->add_setting(
				'listar_secondary_google_font',
				array(
					'default'           => $default_secondary_google_font,
					'transport'         => 'refresh',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'listar_secondary_google_font_control',
				array(
					'type'        => 'select',
					'label'       => esc_html__( 'Headings Font', 'listar' ),
					'description' => esc_html__( 'For heading texts, some titles, etc', 'listar' ),
					'section'     => 'listar_google_fonts',
					'settings'    => 'listar_secondary_google_font',
					'choices'     => $display_fonts,
				)
			);

			/* Bold Secondary (Headings) Google Font - Checkbox ***********/

			$wp_customize->add_setting(
				'listar_secondary_google_font_bold',
				array(
					'default'           => true,
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_boolean',
				)
			);

			$wp_customize->add_control(
				'listar_secondary_google_font_bold_control',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Bold headings font', 'listar' ),
					'description' => esc_html__( 'Enable to make headings font bold', 'listar' ),
					'section'     => 'listar_google_fonts',
					'settings'    => 'listar_secondary_google_font_bold',
				)
			);

			/* Add new Google Font - Text input ***************************/

			$wp_customize->add_setting(
				'listar_new_google_font',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'listar_sanitize_new_google_font_url',
				)
			);

			$google_fonts_link_title = esc_html__( 'Add New Google Fonts', 'listar' );
			$google_fonts_link_text  = esc_html__( 'Need help?', 'listar' );

			$google_fonts_more_info_link = '<a href="#TB_inline&width=753&height=9999&inlineId=google-fonts-help" title="' . $google_fonts_link_title . '" class="google-fonts-more-info thickbox">' . $google_fonts_link_text . '</a>';

			$google_fonts_url_example = $google_fonts_family_url . 'Lato:400,700|Montserrat:400,500,700&amp;amp;subset=latin-ext';
			$rel = 'stylesheet';

			$google_fonts_help_text = ''
				. '<div id="google-fonts-help">'
					. '<div class="google-fonts-help-text">'
						. '<ul>'
							. '<li>'
								. sprintf(
									/* TRANSLATORS: 1: https://fonts.google.com, 2: fonts.google.com */
									__( '1 ) Go to <a href="%1$s" target="blank">%2$s</a>.', 'listar' ),
									'https://fonts.google.com',
									'fonts.google.com'
								)
							. '</li>'
							. '<li>' . esc_html__( '2 ) Every font block has a "+" button, click on it to select one or more fonts.', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '3 ) Click on the dark block fixed on footer to customize the font(s).', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '4) "Customize" it as you wish, choose font weights and supported languages.', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '5 ) On the "Embed" tab, copy the standard "link" code generated.', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '6 ) Close this popup and paste the copied code to "Add New Google Fonts" input field.', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '7 ) Click on "Publish" button and wait the page refresh.', 'listar' ) . '</li>'
						. '</ul>'
						. '<p>'
							. '<strong>' . esc_html__( 'The "link" tag copied must be similar to this', 'listar' ) . ':</strong>'
						. '</p>'
						. '<pre>'
							. '&lt;link href="' . $google_fonts_url_example . '" rel="' . $rel . '"&gt;'
						. '</pre>'
					. '</div>'
				. '</div>';

			$wp_customize->add_control(
				'listar_new_google_font_control',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Add New Google Fonts', 'listar' ),
					'section'     => 'listar_google_fonts',
					'settings'    => 'listar_new_google_font',
					'description' => $google_fonts_more_info_link . $google_fonts_help_text,
				)
			);

			/* Delete a Google Font - Select ******************************/

			if ( ! empty( $custom_fonts ) ) :

				ksort( $custom_fonts );

				$wp_customize->add_setting(
					'listar_delete_google_font',
					array(
						'default'           => 'none',
						'transport'         => 'postMessage',
						'sanitize_callback' => 'esc_url_raw',
					)
				);

				$none = array(
					'none' => esc_html( 'None', 'listar' ),
				);

				$wp_customize->add_control(
					'listar_delete_google_font_control',
					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Delete a Google Font', 'listar' ),
						'description' => esc_html__( 'Except default fonts', 'listar' ),
						'section'     => 'listar_google_fonts',
						'settings'    => 'listar_delete_google_font',
						'choices'     => array_merge( $none, $custom_fonts ),
					)
				);

			endif;

			/* Google Font Language ************/

			$wp_customize->add_setting(
				'listar_google_font_language_subset',
				array(
					'default'           => array( 'latin-ext' ),
					'transport'         => 'refresh',
					'sanitize_callback' => 'listar_sanitize_google_fonts_languages',
				)
			);

			$google_fonts_languages_link_title = esc_html__( 'Checking font languages', 'listar' );

			$google_fonts_more_info_link = '<a href="#TB_inline&width=753&height=9999&inlineId=google-fonts-help-languages" title="' . $google_fonts_languages_link_title . '" class="google-fonts-more-info thickbox">' . $google_fonts_link_text . '</a>';

			$google_fonts_help_text = ''
				. '<div id="google-fonts-help-languages">'
					. '<div class="google-fonts-help-text">'
						. '<ul>'
							. '<li>'
								. sprintf(
									/* TRANSLATORS: 1: https://fonts.google.com, 2: fonts.google.com */
									__( '1 ) Go to <a href="%1$s" target="blank">%2$s</a>.', 'listar' ),
									'https://fonts.google.com',
									'fonts.google.com'
								)
							. '</li>'
							. '<li>' . esc_html__( '2 ) Every font block has a "+" button, click on it to select one or more fonts.', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '3 ) Click on the dark block fixed on footer to customize the font(s).', 'listar' ) . '</li>'
							. '<li>' . esc_html__( '4) "Click on "Customize" and scroll down to see the suported languages.', 'listar' ) . '</li>'
						. '</ul>'
					. '</div>'
				. '</div>';

			$wp_customize->add_control(
				new Listar_Multiple_Select_Control(
					$wp_customize,
					'listar_google_font_language_subset_control',
					array(
						'label'       => esc_html__( 'Google Fonts Languages', 'listar' ),
						'description' => esc_html__( 'Before choosing custom Google Font languages to load, click on both "Check font details" links above and verify if the "Body" and "Headings" fonts currently selected are available for your language.', 'listar' ) . ' ' . $google_fonts_more_info_link . $google_fonts_help_text,
						'section'     => 'listar_google_fonts',
						'settings'    => 'listar_google_font_language_subset',
						'type'        => 'multiple-select',
						'choices'     => $google_font_languages,
					)
				)
			);
		}// End if().
	}

endif;


add_action( 'customize_render_control_header_image', 'listar_custom_header_image_control_description' );

if ( ! function_exists( 'listar_custom_header_image_control_description' ) ) :
	/**
	 * Complements the description of 'Header Image' control on Customizer.
	 *
	 * @since 1.0
	 */
	function listar_custom_header_image_control_description() {
		?>
		<div class="listar-customizer-notice">
			<?php echo wp_kses( __( 'This header image will be used as placeholder only <strong>in last case</strong>, that is, if no featured image is set to the post, page, category, or no background images are set on <strong>Theme Options</strong>.', 'listar' ), 'listar-basic-html' ); ?>
		</div>
		<?php
	}

endif;


add_action( 'customize_render_control_listar_primary_google_font_control', 'listar_custom_primary_google_font_control_description' );

if ( ! function_exists( 'listar_custom_primary_google_font_control_description' ) ) :
	/**
	 * Appends header message to 'Primary Font' control on Customizer.
	 *
	 * @since 1.0
	 */
	function listar_custom_primary_google_font_control_description() {
		?>
		<div class="listar-customizer-notice updating-google-fonts hidden">
			<?php echo wp_kses( __( 'Updating font list, please wait. <a href="#">Force refresh</a>', 'listar' ), 'listar-basic-html' ); ?>
		</div>
		<?php
	}

endif;

/**
 * Customizer Sanitization - Custom Funtions ***********************************
 */


if ( ! function_exists( 'listar_sanitize_google_fonts_languages' ) ) :
	/**
	 * Sanitize the array of Google Fonts subsets, that is, the languages selected by the user.
	 *
	 * @since 1.0
	 * @param (array) $languages The subsets for Google Fonts languages.
	 */
	function listar_sanitize_google_fonts_languages( $languages ) {
		$count = is_array( $languages ) ? count( $languages ) : 0;

		if ( ! is_array( $languages ) ) {
			return array( 'latin-ext' );
		}

		for ( $i = 0; $i < $count; $i++ ) {
			$languages[ $i ] = esc_html( $languages[ $i ] );
		}

		return $languages;
	}
endif;

add_action( 'pre_set_theme_mod_listar_delete_google_font', 'listar_delete_google_font' );

if ( ! function_exists( 'listar_delete_google_font' ) ) :
	/**
	 * Delete a Google font.
	 *
	 * @since 1.0
	 * @param (string) $input A Google Font URL.
	 * @return (string)
	 */
	function listar_delete_google_font( $input ) {

		/* Replace all '&' by '&amp;' */

		$font_url_to_delete = esc_url_raw( str_replace( '&', '&amp;', str_replace( '&amp;', '&', $input ) ) );

		/* Append '---' as helper prefix to strpos search */

		$font_to_delete = '---' . $font_url_to_delete;
		$custom_google_fonts = get_option( 'listar_custom_google_fonts' );

		if ( false !== strpos( $font_to_delete, 'googleapis' ) && false !== strpos( $custom_google_fonts, $font_to_delete ) ) :
			$custom_google_fonts = str_replace( $font_to_delete, '', $custom_google_fonts );
			update_option( 'listar_custom_google_fonts', $custom_google_fonts );
		endif;

		return 'none';
	}

endif;

if ( ! function_exists( 'listar_sanitize_new_google_font_url' ) ) :
	/**
	 * Sanitize Google Font URL and save an individual URL for every font family.
	 *
	 * @since 1.0
	 * @param (string) $input Whole Google Font <link> tag or a Google Font URL.
	 */
	function listar_sanitize_new_google_font_url( $input ) {

		/* If user copy/pasted the whole <link> tag generated by Google Fonts, instead of the embeddable URL, try to fix it */

		if ( false !== strpos( 'href="' ) ) :
			/* Explode and get last part from string */
			$parts = explode( 'href="', $input );
			$array = array_values( $parts );
			$input = end( $array );
		endif;

		if ( false !== strpos( '" rel' ) ) :
			/* Explode and get first part from string */
			$parts = explode( '" rel', $input );
			$array = array_values( $parts );
			$input = reset( $array );
		endif;

		$sanitized = esc_url_raw( $input );
		$font_subsets = '';

		/* URL must contain only one '?' character and one 'family=' string */
		if ( 1 !== substr_count( $sanitized, '?' ) && 1 !== substr_count( $sanitized, 'family=' ) && 1 !== substr_count( $sanitized, 'fonts.googleapis.com/css?' ) ) :
			return '';
		endif;

		/* Explode and get last part from string */
		$parts2 = explode( '?', $sanitized );
		$array2 = array_values( $parts2 );
		$query_string = end( $array2 );

		/* Get font families and respective font weights, example: Roboto or Quicksand:300,400,500 */

		/* Explode and get last part from string */
		$parts3 = explode( 'family=', $query_string );
		$array3 = array_values( $parts3 );
		$families = end( $array3 );

		if ( false !== strpos( $families, '&' ) ) :
			/* Explode and get first part from string */
			$parts4 = explode( '&', $families );
			$array4 = array_values( $parts4 );
			$families = reset( $array4 );
		endif;

		$temp_font_families = ( false !== strpos( $families, '|' ) ) ? explode( '|', $families ) : array( $families );

		/* At this point, font families shouldn't be empty or duplicated */
		$font_families = array_unique( array_filter( $temp_font_families ) );

		/* Get font subsets */

		if ( 1 === substr_count( $query_string, 'subset=' ) ) :

			/* Explode and get last part from string */
			$parts5 = explode( 'subset=', $query_string );
			$array5 = array_values( $parts5 );
			$subsets = end( $array5 );

			if ( false !== strpos( $subsets, '&' ) ) :
				/* Explode and get first part from string */
				$parts6 = explode( '&', $subsets );
				$array6 = array_values( $parts6 );
				$font_subsets = reset( $array6 );
			else :
				$font_subsets = $subsets;
			endif;

		endif;

		/**
		 * Assemble the font values as a Google Font URL, check if they are real Google Font 'embedding' URLs
		 * and make sure they aren't saved yet.
		 */

		$old_google_fonts = get_option( 'listar_custom_google_fonts' );
		$google_fonts_urls_to_save = '';
		$subsets = ! empty( $font_subsets ) ? '&amp;subset=' . $font_subsets : '';

		foreach ( $font_families as $font_family ) :

			/* Append default font weights to font family */

			if ( false === strpos( $font_family, ':' ) ) :
				/* Explode and get first part from string */
				$parts = explode( ':', $font_family );
				$array = array_values( $parts );
				$font_family = reset( $array );
			endif;

			$font_family .= ':400,500,600,700';

			$url = 'https://fonts.googleapis.com/css?family=' . $font_family . $subsets;

			/* Replace all '&' by '&amp;' */
			$new_font_url = esc_url_raw( str_replace( '&', '&amp;', str_replace( '&amp;', '&', $url ) ) );

			/* Everything OK and it seems a real Google Font 'embedding' URL, but does this link exist? */
			if ( false === listar_url_exists( $new_font_url ) ) :
				continue;
			endif;

			/* Skip if font already exists on 'listar_custom_google_fonts' Theme Option... */
			if ( false !== strpos( $old_google_fonts, $new_font_url ) ) :
				continue;
			endif;

			/* Save as string of Google URLs, separated by '---' */
			$google_fonts_urls_to_save .= '---' . $new_font_url;

		endforeach;

		/* Append the new Google Font URLs to 'listar_custom_google_fonts' theme option */

		if ( ! empty( $google_fonts_urls_to_save ) ) :
			/* Save as string of Google URLs, separated by '---' */
			update_option( 'listar_custom_google_fonts', $old_google_fonts . $google_fonts_urls_to_save );
		endif;

		return '';
	}
endif;

if ( ! function_exists( 'listar_sanitize_boolean' ) ) :
	/**
	 * Sanitize Google Font URL and save an individual URL for every font family.
	 *
	 * @since 1.0
	 * @param (string) $input Whole Google Font <link> tag or a Google Font URL.
	 */
	function listar_sanitize_boolean( $input ) {

		$validate = filter_var( $input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );

		if ( null === $validate ) {
			return false;
		} else {
			return $validate;
		}
	}
endif;

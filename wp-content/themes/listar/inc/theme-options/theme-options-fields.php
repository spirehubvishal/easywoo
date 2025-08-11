<?php
/**
 * Create the 'Theme Options' page on WordPress admin and register the customizable setting fields
 *
 * @link https://developer.wordpress.org/reference/functions/register_setting/
 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
 *
 * @package Listar
 */

/**
 * Include callback and Sanitize functions for custom theme settings.
 */

get_template_part( 'inc/theme-options/theme-options', 'functions' );

add_action( 'admin_menu', 'listar_add_admin_page' );

/**
 * Create a 'Theme Options' link into 'Appearance' menu on WordPress admin dashboard.
 *
 * @since 1.0
 */
function listar_add_admin_page() {
	add_action( 'admin_init', 'listar_theme_options' );
	add_theme_page( esc_html__( 'Listar Options', 'listar' ), esc_html__( 'Theme Options', 'listar' ), 'manage_options', 'listar_options', 'listar_theme_create_page' );
}

/**
 * Create the 'Theme Options' page on admin to receive the custom settings registered by listar_theme_options().
 *
 * @since 1.0
 */
function listar_theme_create_page() {
	get_template_part( 'inc/theme-options/theme-options', 'page' );
}

/**
 * Register all custom settings to 'Theme Options' admin page.
 *
 * @since 1.0
 */
function listar_theme_options() {
	/**
	 * Initialize options section ******************************************
	 */

	add_settings_section( 'listar_options', '', 'listar_options_callback', 'listar_options' );

	/**
	 * Notice to reviewer, about nonce *************************************
	 *
	 * The settings_fields() function generates the nonce.
	 * See theme-options-fields.php.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/settings_fields
	 */

	/**
	 * Sanitize callbacks **************************************************
	 */

	$sanitize_callback_int = array(
		'sanitize_callback' => 'absint',
	);

	$sanitize_callback_no_html = array(
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	);

	$sanitize_callback_kses_post = array(
		'sanitize_callback' => 'wp_kses_post',
	);

	$sanitize_callback_esc_url = array(
		'sanitize_callback' => 'esc_url',
	);

	$sanitize_callback_sanitize_email = array(
		'sanitize_callback' => 'sanitize_email',
	);

	/**
	 * General background images *******************************************
	 */
		
	/**
	 * Fallback image for listing cards
	 */
		
	/**
	 * Fallback avatar image for users
	 */

	register_setting(
		'listar_settings_group',
		'listar_user_avatar_fallback_image',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_user_avatar_fallback_image',
		esc_html__( 'Fallback avatar image for users', 'listar' ),
		'listar_user_avatar_fallback_image_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_user_avatar_fallback_image __edit-backgrounds',
		)
	);

	if ( post_type_exists( 'job_listing' ) ) {
		
		/**
		 * Fallback image for listing cards
		 */

		register_setting(
			'listar_settings_group',
			'listar_listing_card_fallback_image',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_listing_card_fallback_image',
			esc_html__( 'Fallback image for listing cards', 'listar' ),
			'listar_listing_card_fallback_image_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_listing_card_fallback_image __edit-backgrounds',
			)
		);
		
		/**
		 * Fallback image for blog cards
		 */

		register_setting(
			'listar_settings_group',
			'listar_blog_card_fallback_image',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_blog_card_fallback_image',
			esc_html__( 'Fallback image for blog cards', 'listar' ),
			'listar_blog_card_fallback_image_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_blog_card_fallback_image __edit-backgrounds',
			)
		);
		
		if ( class_exists( 'Woocommerce' ) ) :
		
			/**
			 * Fallback image for Woocommerce product cards
			 */

			register_setting(
				'listar_settings_group',
				'listar_woo_product_card_fallback_image',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_woo_product_card_fallback_image',
				esc_html__( 'Fallback image for Woocommerce product cards', 'listar' ),
				'listar_woo_product_card_fallback_image_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_woo_product_card_fallback_image __edit-backgrounds',
				)
			);
		endif;

		/**
		 * Background image for search popup
		 */

		$args = array(
			'class' => 'listar_theme_options_field listar_search_background_image __edit-backgrounds',
		);

		register_setting( 'listar_settings_group', 'listar_search_background_image', $sanitize_callback_int );
		add_settings_field( 'listar_search_background_image', esc_html__( 'Background image for search popup', 'listar' ), 'listar_search_background_image_callback', 'listar_options', 'listar_options', $args );

		/* Are the Explore By options active? */
		$search_by_active = listar_addons_active() ? listar_is_search_by_options_active() : false;
		
		if ( $search_by_active ) :

			/**
			 * Background image for "Explore By" popup
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_search_by_background_image __edit-backgrounds',
			);

			register_setting( 'listar_settings_group', 'listar_search_by_background_image', $sanitize_callback_int );
			add_settings_field( 'listar_search_by_background_image', esc_html__( 'Background image for "Explore By" popup', 'listar' ), 'listar_search_by_background_image_callback', 'listar_options', 'listar_options', $args1 );
		endif;

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			/**
			 * Background image for review popup
			 */

			$args = array(
				'class' => 'listar_theme_options_field listar_ratings_background_image __edit-backgrounds',
			);

			register_setting( 'listar_settings_group', 'listar_ratings_background_image', $sanitize_callback_int );
			add_settings_field( 'listar_ratings_background_image', esc_html__( 'Background image for review popup', 'listar' ), 'listar_ratings_background_image_callback', 'listar_options', 'listar_options', $args );
		}
	}

	if ( listar_addons_active() ) {
		/**
		 * Background image for "Login" popup
		 */

		$args = array(
			'class' => 'listar_theme_options_field listar_login_background_image __edit-backgrounds',
		);

		register_setting( 'listar_settings_group', 'listar_login_background_image', $sanitize_callback_int );
		add_settings_field( 'listar_login_background_image', esc_html__( 'Background image for "Login" popup', 'listar' ), 'listar_login_background_image_callback', 'listar_options', 'listar_options', $args );

		/**
		 * Background image for "Social Sharing" popup
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_social_share_background_image __edit-backgrounds',
		);

		register_setting( 'listar_settings_group', 'listar_social_share_background_image', $sanitize_callback_int );
		add_settings_field( 'listar_social_share_background_image', esc_html__( 'Background image for "Social Sharing" popup', 'listar' ), 'listar_social_share_background_image_callback', 'listar_options', 'listar_options', $args2 );
	}

	/**
	 * For blog: default cover image for search/archive pages
	 */

	$args3 = array(
		'class' => 'listar_theme_options_field listar_blog_search_page_cover_image __edit-backgrounds',
	);

	register_setting( 'listar_settings_group', 'listar_blog_search_page_cover_image', $sanitize_callback_int );
	add_settings_field( 'listar_blog_search_page_cover_image', esc_html__( 'Default cover image for blog search page, tags, archive, etc', 'listar' ), 'listar_blog_search_page_cover_image_callback', 'listar_options', 'listar_options', $args3 );

	/**
	 * "404" and "No results" pages ****************************************
	 */

	/**
	 * Page 404 Cover Image
	 */

	$args4 = array(
		'class' => 'listar_theme_options_field listar_page_404_cover_image __edit-backgrounds',
	);

	register_setting( 'listar_settings_group', 'listar_page_404_cover_image', $sanitize_callback_int );
	add_settings_field( 'listar_page_404_cover_image', esc_html__( 'Cover image for 404 page', 'listar' ), 'listar_page_404_cover_image_callback', 'listar_options', 'listar_options', $args4 );

	/**
	 * Complaint Report ****************************************************
	 */
	
	$complaint_reports_enabled = 1 === (int) get_option( 'listar_complaint_reports_disable' ) ? false : true;
				
	if ( $complaint_reports_enabled ) :

		/**
		 * Background image for Complaint Report popup
		 */

		$args104 = array(
			'class' => 'listar_theme_options_field listar_complaint_report_background_image __edit-backgrounds',
		);

		register_setting( 'listar_settings_group', 'listar_complaint_report_background_image', $sanitize_callback_int );
		add_settings_field( 'listar_complaint_report_background_image', esc_html__( 'Background image for Complaint Report popup', 'listar' ), 'listar_complaint_report_background_image_callback', 'listar_options', 'listar_options', $args104 );
	endif;

	/**
	 * Grid Fillers ********************************************************
	 */

	if ( post_type_exists( 'job_listing' ) ) {

		/**
		 * Background image for listing "grid filler" card
		 */

		$args86 = array(
			'class' => 'listar_theme_options_field listar_listing_grid_filler_background_image __edit-backgrounds',
		);

		register_setting( 'listar_settings_group', 'listar_listing_grid_filler_background_image', $sanitize_callback_int );
		add_settings_field( 'listar_listing_grid_filler_background_image', esc_html__( 'Background image for listing "grid filler" card', 'listar' ), 'listar_listing_grid_filler_background_image_callback', 'listar_options', 'listar_options', $args86 );
	}

	/**
	 * Background image for blog "grid filler" card
	 */

	$args27 = array(
		'class' => 'listar_theme_options_field listar_blog_grid_filler_background_image __edit-backgrounds',
	);

	register_setting( 'listar_settings_group', 'listar_blog_grid_filler_background_image', $sanitize_callback_int );
	add_settings_field( 'listar_blog_grid_filler_background_image', esc_html__( 'Background image for blog "grid filler" card', 'listar' ), 'listar_blog_grid_filler_background_image_callback', 'listar_options', 'listar_options', $args27 );

	/**
	 * Private message for single listings *********************************
	 */

	if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {
		if ( ! class_exists( 'EasyWPSMTP' ) && ! function_exists( 'wp_mail_smtp' ) ) {
			/**
			 * SMTP plugins not installed.
			 */

			$args5 = array(
				'class' => 'listar_theme_options_field listar_easy_smtp_uninstalled __edit-messages',
			);

			add_settings_field( 'listar_easy_smtp_uninstalled', esc_html__( 'Important!', 'listar' ), 'listar_easy_smtp_uninstalled_callback', 'listar_options', 'listar_options', $args5 );
		} else {
			/**
			 * SMTP Plugin Installed
			 */
			
			if ( function_exists( 'wp_mail_smtp' ) ) {
				$args5 = array(
					'class' => 'listar_theme_options_field listar_wp_mail_smtp_installed __edit-messages',
				);

				add_settings_field( 'listar_wp_mail_smtp_installed', esc_html__( 'Have you configured the SMTP settings for your server?', 'listar' ), 'listar_wp_mail_smtp_installed_callback', 'listar_options', 'listar_options', $args5 );
			} elseif ( class_exists( 'EasyWPSMTP' ) ) {
				$args5 = array(
					'class' => 'listar_theme_options_field listar_easy_smtp_installed __edit-messages',
				);

				add_settings_field( 'listar_easy_smtp_installed', esc_html__( 'Have you configured the SMTP settings for your server?', 'listar' ), 'listar_easy_smtp_installed_callback', 'listar_options', 'listar_options', $args5 );
			}

			/**
			 * User registration message subject
			 */

			$args7 = array(
				'class' => 'listar_theme_options_field listar_user_registration_message_subject __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_user_registration_message_subject', $sanitize_callback_no_html );
			add_settings_field( 'listar_user_registration_message_subject', esc_html__( 'User registration message subject', 'listar' ), 'listar_user_registration_message_subject_callback', 'listar_options', 'listar_options', $args7 );

			/**
			 * User registration message template
			 */

			$args8 = array(
				'class' => 'listar_theme_options_field listar_user_registration_message_template __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_user_registration_message_template', $sanitize_callback_kses_post );
			add_settings_field( 'listar_user_registration_message_template', esc_html__( 'User registration message template', 'listar' ), 'listar_user_registration_message_template_callback', 'listar_options', 'listar_options', $args8 );
			
			/**
			 * Password recovering message subject
			 */

			$args9 = array(
				'class' => 'listar_theme_options_field listar_user_password_recover_message_subject __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_user_password_recover_message_subject', $sanitize_callback_no_html );
			add_settings_field( 'listar_user_password_recover_message_subject', esc_html__( 'Password recovering message subject', 'listar' ), 'listar_user_password_recover_message_subject_callback', 'listar_options', 'listar_options', $args9 );

			/**
			 * Password recovering message template
			 */

			$args10 = array(
				'class' => 'listar_theme_options_field listar_user_password_recover_message_template __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_user_password_recover_message_template', $sanitize_callback_kses_post );
			add_settings_field( 'listar_user_password_recover_message_template', esc_html__( 'Password recovering message template', 'listar' ), 'listar_user_password_recover_message_template_callback', 'listar_options', 'listar_options', $args10 );
			
			/**
			 * Disable private message form for listings?
			 */

			$args6 = array(
				'class' => 'listar_theme_options_field listar_disable_private_message __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_disable_private_message', $sanitize_callback_int );
			add_settings_field( 'listar_disable_private_message', esc_html__( 'Disable private message form for listings?', 'listar' ), 'listar_disable_private_message_callback', 'listar_options', 'listar_options', $args6 );
			
			/**
			 * Private message subject
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_private_message_subject __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_private_message_subject', $sanitize_callback_no_html );
			add_settings_field( 'listar_private_message_subject', esc_html__( 'Private message subject', 'listar' ), 'listar_private_message_subject_callback', 'listar_options', 'listar_options', $args1 );

			/**
			 * Private message template
			 */

			$args2 = array(
				'class' => 'listar_theme_options_field listar_private_message_template __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_private_message_template', $sanitize_callback_kses_post );
			add_settings_field( 'listar_private_message_template', esc_html__( 'Private message template', 'listar' ), 'listar_private_message_template_callback', 'listar_options', 'listar_options', $args2 );

			/**
			 * Sending fail message
			 */

			$args3 = array(
				'class' => 'listar_theme_options_field listar_sending_fail_message __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_sending_fail_message', $sanitize_callback_no_html );
			add_settings_field( 'listar_sending_fail_message', esc_html__( 'Sending fail message', 'listar' ), 'listar_sending_fail_message_callback', 'listar_options', 'listar_options', $args3 );

			/**
			 * Sending success message
			 */

			$args4 = array(
				'class' => 'listar_theme_options_field listar_sending_success_message __edit-messages',
			);

			register_setting( 'listar_settings_group', 'listar_sending_success_message', $sanitize_callback_no_html );
			add_settings_field( 'listar_sending_success_message', esc_html__( 'Sending success message', 'listar' ), 'listar_sending_success_message_callback', 'listar_options', 'listar_options', $args4 );
		}
	}

	/**
	 * Listing/directory and its resources *********************************
	 */

	if ( post_type_exists( 'job_listing' ) ) {
		
		/**
		 * Force light design
		 */

		$args1025 = array(
			'class' => 'listar_theme_options_field listar_force_light_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_force_light_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_force_light_design', esc_html__( 'Force light design', 'listar' ), 'listar_force_light_design_callback', 'listar_options', 'listar_options', $args1025 );

		/**
		 * Design for listing cards
		 */

		$args = array(
			'class' => 'listar_theme_options_field listar_listing_card_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_listing_card_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_listing_card_design', esc_html__( 'Design for listing cards', 'listar' ), 'listar_listing_card_design_callback', 'listar_options', 'listar_options', $args );

		/**
		 * Design for blog cards
		 */

		$args11 = array(
			'class' => 'listar_theme_options_field listar_blog_card_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_blog_card_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_blog_card_design', esc_html__( 'Design for blog cards', 'listar' ), 'listar_blog_card_design_callback', 'listar_options', 'listar_options', $args11 );

		if ( class_exists( 'Woocommerce' ) ) {

			/**
			 * Enable Woocommerce "Downloads" menu from User Dashboard screen.
			 */

			register_setting(
				'listar_settings_group',
				'listar_woo_card_design',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_woo_card_design',
				esc_html__( 'Woocommerce product card design', 'listar' ),
				'listar_woo_card_design_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_woo_card_design __edit-design',
				)
			);

			/**
			 * Design for product image on Woocommerce product page.
			 */

			register_setting(
				'listar_settings_group',
				'listar_woo_product_image_design',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_woo_product_image_design',
				esc_html__( 'Design for product image on Woocommerce product page', 'listar' ),
				'listar_woo_product_image_design_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_woo_product_image_design __edit-design',
				)
			);
		}

		/* Covers Astoundify and Automattic Payment plugins */
		if ( class_exists( 'Woocommerce' ) && ( defined( 'ASTOUNDIFY_WPJMLP_VERSION' ) || class_exists( 'WC_Paid_Listings' ) ) ) :

			/**
			 * Design for pricing cards
			 */

			register_setting(
				'listar_settings_group',
				'listar_pricing_cards_design',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_pricing_cards_design',
				esc_html__( 'Design for pricing cards', 'listar' ),
				'listar_pricing_cards_design_callback',
				'listar_options', 'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_pricing_cards_design  __edit-design',
				)
			);
		endif;

		/**
		 * Disable custom colors for listing categories, regions and amenities
		 */

		$args9 = array(
			'class' => 'listar_theme_options_field listar_disable_custom_taxonomy_colors __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_disable_custom_taxonomy_colors', $sanitize_callback_int );
		add_settings_field( 'listar_disable_custom_taxonomy_colors', esc_html__( 'Disable custom colors for listing categories, regions and amenities', 'listar' ), 'listar_disable_custom_taxonomy_colors_callback', 'listar_options', 'listar_options', $args9 );

		/**
		 * Design for listing categories, regions and amenities blocks
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_taxonomy_terms_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_taxonomy_terms_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_taxonomy_terms_design', esc_html__( 'Design for listing categories, regions and amenity blocks', 'listar' ), 'listar_taxonomy_terms_design_callback', 'listar_options', 'listar_options', $args2 );

		if ( listar_addons_active() ) {
			/**
			 * Design for partner cards
			 */

			$args6 = array(
				'class' => 'listar_theme_options_field listar_partner_cards_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_partner_cards_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_partner_cards_design', esc_html__( 'Design for partner cards', 'listar' ), 'listar_partner_cards_design_callback', 'listar_options', 'listar_options', $args6 );

			/**
			 * Design for feature cards
			 */

			$args7 = array(
				'class' => 'listar_theme_options_field listar_feature_cards_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_feature_cards_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_feature_cards_design', esc_html__( 'Design for feature cards', 'listar' ), 'listar_feature_cards_design_callback', 'listar_options', 'listar_options', $args7 );
		}

		/**
		 * Design for single listing gallery
		 */

		$args3 = array(
			'class' => 'listar_theme_options_field listar_single_listing_gallery_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_single_listing_gallery_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_single_listing_gallery_design', esc_html__( 'Design for single listing gallery', 'listar' ), 'listar_single_listing_gallery_design_callback', 'listar_options', 'listar_options', $args3 );

		/**
		 * Design for pricing ranges on single listing page
		 */

		$args4 = array(
			'class' => 'listar_theme_options_field listar_single_listing_pricing_range_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_single_listing_pricing_range_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_single_listing_pricing_range_design', esc_html__( 'Design for pricing ranges on single listing page', 'listar' ), 'listar_single_listing_pricing_range_design_callback', 'listar_options', 'listar_options', $args4 );

		/**
		 * Design for header category buttons
		 */

		$args6 = array(
			'class' => 'listar_theme_options_field listar_hero_categories_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_hero_categories_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_hero_categories_design', esc_html__( 'Design for header category buttons', 'listar' ), 'listar_hero_categories_design_callback', 'listar_options', 'listar_options', $args6 );

		/**
		 * Design for listing search input field
		 */

		$args5 = array(
			'class' => 'listar_theme_options_field listar_listing_search_input_field_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_listing_search_input_field_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_listing_search_input_field_design', esc_html__( 'Design for listing search input field', 'listar' ), 'listar_listing_search_input_field_design_callback', 'listar_options', 'listar_options', $args5 );

		if ( taxonomy_exists( 'job_listing_region' ) ) {
			/**
			 * Design for region filter on listing search field
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_listing_search_input_filter_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_listing_search_input_filter_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_listing_search_input_filter_design', esc_html__( 'Design for region filter on listing search field', 'listar' ), 'listar_listing_search_input_filter_design_callback', 'listar_options', 'listar_options', $args1 );
		}

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			/**
			 * Design for listing average rating
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_listing_rating_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_listing_rating_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_listing_rating_design', esc_html__( 'Design for listing average rating', 'listar' ), 'listar_listing_rating_design_callback', 'listar_options', 'listar_options', $args1 );

			/**
			 * Design for big average rating on single listing pages
			 */

			$args2 = array(
				'class' => 'listar_theme_options_field listar_single_listing_big_rating_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_single_listing_big_rating_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_single_listing_big_rating_design', esc_html__( 'Design for big average rating on single listing pages', 'listar' ), 'listar_single_listing_big_rating_design_callback', 'listar_options', 'listar_options', $args2 );

			/**
			 * Design for average rating mood and counter on single listing pages
			 */

			$args3 = array(
				'class' => 'listar_theme_options_field listar_single_listing_mood_design __edit-design',
			);

			register_setting( 'listar_settings_group', 'listar_single_listing_mood_design', $sanitize_callback_no_html );
			add_settings_field( 'listar_single_listing_mood_design', esc_html__( 'Design for average rating mood and counter on single listing pages', 'listar' ), 'listar_single_listing_mood_design_callback', 'listar_options', 'listar_options', $args3 );
		}

		/**
		 * Users allowed to publish listings on front end
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_users_allowed_publish_listings __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_users_allowed_publish_listings', $sanitize_callback_no_html );
		add_settings_field( 'listar_users_allowed_publish_listings', esc_html__( 'Set the users that are allowed to publish listings on front end', 'listar' ), 'listar_users_allowed_publish_listings_callback', 'listar_options', 'listar_options', $args1 );
	}// End if().

	if ( listar_addons_active() ) {
		/**
		 * Design for social network icons
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_social_network_icons_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_social_network_icons_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_social_network_icons_design', esc_html__( 'Design for social network icons', 'listar' ), 'listar_social_network_icons_design_callback', 'listar_options', 'listar_options', $args1 );

		/**
		 * Design for listing thumbnails on map sidebar
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_map_sidebar_listing_thumbnail_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_map_sidebar_listing_thumbnail_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_map_sidebar_listing_thumbnail_design', esc_html__( 'Design for listing thumbnails on map sidebar', 'listar' ), 'listar_map_sidebar_listing_thumbnail_design_callback', 'listar_options', 'listar_options', $args2 );
	}

	/**
	 * Design for thumbnails on Recent Posts widget
	 */

	$args1 = array(
		'class' => 'listar_theme_options_field listar_recent_post_thumbnail_design __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_recent_post_thumbnail_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_recent_post_thumbnail_design', esc_html__( 'Design for thumbnails on Recent Posts widget', 'listar' ), 'listar_recent_post_thumbnail_design_callback', 'listar_options', 'listar_options', $args1 );

	/**
	 * Design for user avatar
	 */

	$args2 = array(
		'class' => 'listar_theme_options_field listar_user_avatar_design __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_user_avatar_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_user_avatar_design', esc_html__( 'Design for user avatar', 'listar' ), 'listar_user_avatar_design_callback', 'listar_options', 'listar_options', $args2 );

	/**
	 * Design for buttons
	 */

	$args14 = array(
		'class' => 'listar_theme_options_field listar_buttons_design __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_buttons_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_buttons_design', esc_html__( 'Design for buttons', 'listar' ), 'listar_buttons_design_callback', 'listar_options', 'listar_options', $args14 );

	if ( listar_addons_active() ) {
		/**
		 * Design for Launch Map button
		 */

		$args36 = array(
			'class' => 'listar_theme_options_field listar_launch_map_button_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_launch_map_button_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_launch_map_button_design', esc_html__( 'Design for Launch Map button', 'listar' ), 'listar_launch_map_button_design_callback', 'listar_options', 'listar_options', $args36 );
		
		/**
		 * Design for Listing View button for maps
		 */

		$args37 = array(
			'class' => 'listar_theme_options_field listar_listing_view_button_design __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_listing_view_button_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_listing_view_button_design', esc_html__( 'Design for Listing View button for maps', 'listar' ), 'listar_listing_view_button_design_callback', 'listar_options', 'listar_options', $args37 );
	}




	/**
	 * Design for images on posts
	 */

	$args23 = array(
		'class' => 'listar_theme_options_field listar_post_images_design __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_post_images_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_post_images_design', esc_html__( 'Design for images on posts', 'listar' ), 'listar_post_images_design_callback', 'listar_options', 'listar_options', $args23 );


	/**
	 * Max number of results for search
	 */

	/*

	register_setting(
		'listar_settings_group',
		'listar_max_results_search',
		$sanitize_callback_int
	);

	add_settings_field(
		'listar_max_results_search',
		esc_html__( 'Max number of results for search','listar' ),
		'listar_max_results_search_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_max_results_search __edit-search',
		)
	);
	*/


	/**
	 * Search on listing tags
	 */

	register_setting(
		'listar_settings_group',
		'listar_use_search_listing_tags_data',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_use_search_listing_tags_data',
		esc_html__( 'Search on listing tags','listar' ),
		'listar_use_search_listing_tags_data_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_use_search_listing_tags_data __edit-search',
		)
	);


	/**
	 * Search on listing location (address)
	 */

	register_setting(
		'listar_settings_group',
		'listar_use_search_listing_location_data',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_use_search_listing_location_data',
		esc_html__( 'Search on listing location (address)','listar' ),
		'listar_use_search_listing_location_data_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_use_search_listing_location_data __edit-search',
		)
	);


	/**
	 * Search on raw content
	 */

	register_setting(
		'listar_settings_group',
		'listar_use_search_listing_raw_data',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_use_search_listing_raw_data',
		esc_html__( 'Search on raw content','listar' ),
		'listar_use_search_listing_raw_data_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_use_search_listing_raw_data __edit-search',
		)
	);


	/**
	 * Search on listing description
	 */

	register_setting(
		'listar_settings_group',
		'listar_use_search_listing_description_data',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_use_search_listing_description_data',
		esc_html__( 'Search on listing description','listar' ),
		'listar_use_search_listing_description_data_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_use_search_listing_description_data __edit-search',
		)
	);

	if (  taxonomy_exists( 'job_listing_category' ) ) {

		/**
		 * Search on category names
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_search_listing_category_data',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_use_search_listing_category_data',
			esc_html__( 'Search on listing category names','listar' ),
			'listar_use_search_listing_category_data_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_search_listing_category_data __edit-search',
			)
		);
	}

	if (  taxonomy_exists( 'job_listing_region' ) ) {

		/**
		 * Search on region names
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_search_listing_region_data',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_use_search_listing_region_data',
			esc_html__( 'Search on listing region names','listar' ),
			'listar_use_search_listing_region_data_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_search_listing_region_data __edit-search',
			)
		);
	}

	if (  taxonomy_exists( 'job_listing_amenity' ) ) {

		/**
		 * Search on amenity names
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_search_listing_amenity_data',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_use_search_listing_amenity_data',
			esc_html__( 'Search on listing amenity names','listar' ),
			'listar_use_search_listing_amenity_data_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_search_listing_amenity_data __edit-search',
			)
		);
	}


	/**
	 * Show featured listings as first results when ordering by Newest
	 */

	register_setting(
		'listar_settings_group',
		'listar_use_search_listing_featured_data',
		$sanitize_callback_no_html
	);

	add_settings_field(
		'listar_use_search_listing_featured_data',
		esc_html__( 'Show featured listings as first results when ordering by Newest','listar' ),
		'listar_use_search_listing_featured_data_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_use_search_listing_featured_data __edit-search',
		)
	);

	/**
	 * Show search button on front page top bar
	 */

	$args52 = array(
		'class' => 'listar_theme_options_field listar_activate_search_button_front __edit-search',
	);

	register_setting( 'listar_settings_group', 'listar_activate_search_button_front', $sanitize_callback_no_html );
	add_settings_field( 'listar_activate_search_button_front', esc_html__( 'Show search button on front page top bar', 'listar' ), 'listar_activate_search_button_front_callback', 'listar_options', 'listar_options', $args52 );
	
	/**
	 * Disable search field on front page header?
	 */

	$args51 = array(
		'class' => 'listar_theme_options_field listar_disable_hero_search_front __edit-search',
	);

	register_setting( 'listar_settings_group', 'listar_disable_hero_search_front', $sanitize_callback_no_html );
	add_settings_field( 'listar_disable_hero_search_front', esc_html__( 'Disable search field on front page header?', 'listar' ), 'listar_disable_hero_search_front_callback', 'listar_options', 'listar_options', $args51 );
	
	/**
	 * Last theme option screen
	 */

	$args78 = array(
		'class' => 'listar_theme_options_field listar_last_theme_options_screen hidden __edit-search',
	);

	register_setting( 'listar_settings_group', 'listar_last_theme_options_screen', $sanitize_callback_no_html );
	add_settings_field( 'listar_last_theme_options_screen', '', 'listar_last_theme_options_screen_callback', 'listar_options', 'listar_options', $args78 );

	if ( taxonomy_exists( 'job_listing_category' ) ) {
		/**
		 * Disable hero categories under search field on front page
		 */

		$args0 = array(
			'class' => 'listar_theme_options_field listar_disable_hero_search_categories_front __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_disable_hero_search_categories_front', $sanitize_callback_no_html );
		add_settings_field( 'listar_disable_hero_search_categories_front', esc_html__( 'Disable hero categories under search field on front page?', 'listar' ), 'listar_disable_hero_search_categories_front_callback', 'listar_options', 'listar_options', $args0 );

		/**
		 * Disable hero categories under search field on front page
		 */

		$args0b = array(
			'class' => 'listar_theme_options_field listar_disable_hero_search_categories_popup __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_disable_hero_search_categories_popup', $sanitize_callback_no_html );
		add_settings_field( 'listar_disable_hero_search_categories_popup', esc_html__( 'Disable hero categories under search field on search popup?', 'listar' ), 'listar_disable_hero_search_categories_popup_callback', 'listar_options', 'listar_options', $args0b );

		/**
		 * Hero categories under search field
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_hero_search_categories __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_hero_search_categories', $sanitize_callback_no_html );
		add_settings_field( 'listar_hero_search_categories', esc_html__( 'Listing categories under search field', 'listar' ), 'listar_hero_search_categories_callback', 'listar_options', 'listar_options', $args1 );

		/**
		 * How these categories must me shown?
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_hero_search_categories_display __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_hero_search_categories_display', $sanitize_callback_no_html );
		add_settings_field( 'listar_hero_search_categories_display', esc_html__( 'How these categories must me shown?', 'listar' ), 'listar_hero_search_categories_display_callback', 'listar_options', 'listar_options', $args2 );

		/**
		 * Hero regions under search field
		 */

		$args3 = array(
			'class' => 'listar_theme_options_field listar_hero_search_regions __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_hero_search_regions', $sanitize_callback_no_html );
		add_settings_field( 'listar_hero_search_regions', esc_html__( 'Listing regions under search field', 'listar' ), 'listar_hero_search_regions_callback', 'listar_options', 'listar_options', $args3 );
	}

	if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {
		
		/**
		 * Disable logo?
		 */

		$args10 = array(
			'class' => 'listar_theme_options_field listar_logo_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_logo_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_logo_disable', esc_html__( 'Disable logo?', 'listar' ), 'listar_logo_disable_callback', 'listar_options', 'listar_options', $args10 );

		/**
		 * Disable email data publicly?
		 */

		register_setting(
			'listar_settings_group',
			'listar_email_data_disable',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_email_data_disable',
			esc_html__( 'Disable email data publicly?', 'listar' ),
			'listar_email_data_disable_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_email_data_disable __directory-config',
			)
		);

		/**
		 * Disable location (address)?
		 */

		$args12 = array(
			'class' => 'listar_theme_options_field listar_location_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_location_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_location_disable', esc_html__( 'Disable location (address)?', 'listar' ), 'listar_location_disable_callback', 'listar_options', 'listar_options', $args12 );

		/**
		 * Use distance metering
		 */

		$args64 = array(
			'class' => 'listar_theme_options_field listar_use_distance_metering __distance-metering',
		);

		register_setting( 'listar_settings_group', 'listar_use_distance_metering', $sanitize_callback_no_html );
		add_settings_field( 'listar_use_distance_metering', esc_html__( 'Use distance metering', 'listar' ), 'listar_use_distance_metering_callback', 'listar_options', 'listar_options', $args64 );

		$listar_use_distance_metering = get_option( 'listar_use_distance_metering' );

		if ( 'disable' !== $listar_use_distance_metering ) {

			/**
			 * Unit of distance
			 */

			$args64 = array(
				'class' => 'listar_theme_options_field listar_distance_unit __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_distance_unit', $sanitize_callback_no_html );
			add_settings_field( 'listar_distance_unit', esc_html__( 'Unit of distance', 'listar' ), 'listar_distance_unit_callback', 'listar_options', 'listar_options', $args64 );

			/**
			 * Use meter as a unit of measurement if distance is lower than (km)
			 */

			$args105 = array(
				'class' => 'listar_theme_options_field listar_meters_if_lower_than __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_meters_if_lower_than', $sanitize_callback_int );
			add_settings_field( 'listar_meters_if_lower_than', esc_html__( 'Use meter as a unit of measurement if distance is lower than (km)', 'listar' ), 'listar_meters_if_lower_than_callback', 'listar_options', 'listar_options', $args105 );

			/**
			 * Disable geolocation button for listing cards
			 */

			$args145 = array(
				'class' => 'listar_theme_options_field listar_listing_card_geolocation_button_disable __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_listing_card_geolocation_button_disable', $sanitize_callback_no_html );
			add_settings_field( 'listar_listing_card_geolocation_button_disable', esc_html__( 'Disable geolocation button for listing cards', 'listar' ), 'listar_listing_card_geolocation_button_disable_callback', 'listar_options', 'listar_options', $args145 );

			/**
			 * Disable reference location per listing region
			 */

			$args65 = array(
				'class' => 'listar_theme_options_field listar_region_reference_metering_disable __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_region_reference_metering_disable', $sanitize_callback_no_html );
			add_settings_field( 'listar_region_reference_metering_disable', esc_html__( 'Disable reference location per listing region', 'listar' ), 'listar_region_reference_metering_disable_callback', 'listar_options', 'listar_options', $args65 );

			/**
			 * Disable custom reference location for 'Add Listing' form
			 */
			/*

			$args66 = array(
				'class' => 'listar_theme_options_field listar_add_listing_reference_metering_disable __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_add_listing_reference_metering_disable', $sanitize_callback_no_html );
			add_settings_field( 'listar_add_listing_reference_metering_disable', esc_html__( 'Disable custom reference location for "Add Listing" form', 'listar' ), 'listar_add_listing_reference_metering_disable_callback', 'listar_options', 'listar_options', $args66 );

			*/

			/**
			 * Disable reference locations for single listing pages
			 */

			/*

			$args67 = array(
				'class' => 'listar_theme_options_field listar_single_listing_reference_metering_disable __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_single_listing_reference_metering_disable', $sanitize_callback_no_html );
			add_settings_field( 'listar_single_listing_reference_metering_disable', esc_html__( 'Disable reference locations for single listing pages', 'listar' ), 'listar_single_listing_reference_metering_disable_callback', 'listar_options', 'listar_options', $args67 );
			*/

			/**
			 * Disable fallback reference locations (below)
			 */

			$args77 = array(
				'class' => 'listar_theme_options_field listar_fallback_references_disable __distance-metering',
			);

			register_setting( 'listar_settings_group', 'listar_fallback_references_disable', $sanitize_callback_no_html );
			add_settings_field( 'listar_fallback_references_disable', esc_html__( 'Disable fallback reference locations', 'listar' ), 'listar_fallback_references_disable_callback', 'listar_options', 'listar_options', $args77 );

			$listar_fallback_references__disabled = (int) get_option( 'listar_fallback_references_disable' );

			if ( 0 === $listar_fallback_references__disabled ) {
				/**
				 * Primary reference location (address) for listing distance metering
				 */

				$args68 = array(
					'class' => 'listar_theme_options_field listar_primary_fallback_listing_reference __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_primary_fallback_listing_reference', $sanitize_callback_no_html );
				add_settings_field( 'listar_primary_fallback_listing_reference', esc_html__( 'Primary (fallback) reference location (address) for listing distance metering', 'listar' ), 'listar_primary_fallback_listing_reference_callback', 'listar_options', 'listar_options', $args68 );

				/**
				 * Public label for primary reference location
				 */

				$args75 = array(
					'class' => 'listar_theme_options_field listar_primary_fallback_listing_reference_label __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_primary_fallback_listing_reference_label', $sanitize_callback_no_html );
				add_settings_field( 'listar_primary_fallback_listing_reference_label', esc_html__( 'Public label for primary reference location', 'listar' ), 'listar_primary_fallback_listing_reference_label_callback', 'listar_options', 'listar_options', $args75 );

				/**
				 * Geolocated latitude
				 */

				$args70 = array(
					'class' => 'listar_theme_options_field listar_primary_fallback_geolocated_lat __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_primary_fallback_geolocated_lat', $sanitize_callback_no_html );
				add_settings_field( 'listar_primary_fallback_geolocated_lat', esc_html__( 'Geolocated latitude', 'listar' ), 'listar_primary_fallback_geolocated_lat_callback', 'listar_options', 'listar_options', $args70 );		

				/**
				 * Geolocated longitude
				 */

				$args71 = array(
					'class' => 'listar_theme_options_field listar_primary_fallback_geolocated_lng __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_primary_fallback_geolocated_lng', $sanitize_callback_no_html );
				add_settings_field( 'listar_primary_fallback_geolocated_lng', esc_html__( 'Geolocated longitude', 'listar' ), 'listar_primary_fallback_geolocated_lng_callback', 'listar_options', 'listar_options', $args71 );		

				/**
				 * Secondary (fallback) reference location (address) for listing distance metering
				 */

				$args69 = array(
					'class' => 'listar_theme_options_field listar_secondary_fallback_listing_reference __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_secondary_fallback_listing_reference', $sanitize_callback_no_html );
				add_settings_field( 'listar_secondary_fallback_listing_reference', esc_html__( 'Secondary (fallback) reference location (address) for listing distance metering', 'listar' ), 'listar_secondary_fallback_listing_reference_callback', 'listar_options', 'listar_options', $args69 );				

				/**
				 * Public label for secondary (fallback) reference location
				 */

				$args76 = array(
					'class' => 'listar_theme_options_field listar_secondary_fallback_listing_reference_label __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_secondary_fallback_listing_reference_label', $sanitize_callback_no_html );
				add_settings_field( 'listar_secondary_fallback_listing_reference_label', esc_html__( 'Public label for secondary (fallback) reference location', 'listar' ), 'listar_secondary_fallback_listing_reference_label_callback', 'listar_options', 'listar_options', $args76 );

				/**
				 * Geolocated latitude
				 */

				$args73 = array(
					'class' => 'listar_theme_options_field listar_secondary_fallback_geolocated_lat __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_secondary_fallback_geolocated_lat', $sanitize_callback_no_html );
				add_settings_field( 'listar_secondary_fallback_geolocated_lat', esc_html__( 'Geolocated latitude', 'listar' ), 'listar_secondary_fallback_geolocated_lat_callback', 'listar_options', 'listar_options', $args73 );		

				/**
				 * Geolocated longitude
				 */

				$args74 = array(
					'class' => 'listar_theme_options_field listar_secondary_fallback_geolocated_lng __distance-metering',
				);

				register_setting( 'listar_settings_group', 'listar_secondary_fallback_geolocated_lng', $sanitize_callback_no_html );
				add_settings_field( 'listar_secondary_fallback_geolocated_lng', esc_html__( 'Geolocated longitude', 'listar' ), 'listar_secondary_fallback_geolocated_lng_callback', 'listar_options', 'listar_options', $args74 );		

				/**
				 * Geolocate reference addresses
				 */

				$args72 = array(
					'class' => 'listar_theme_options_field listar_geolocate_reference_addresses __distance-metering',
				);

				add_settings_field( 'listar_geolocate_reference_addresses', '', 'listar_geolocate_reference_addresses_callback', 'listar_options', 'listar_options', $args72 );
			}
		}

		/**
		 * Informs if "0" view was preset for all listings
		 */

		$args87 = array(
			'class' => 'listar_theme_options_field listar_is_first_listing_view_preset hidden __views-counter',
		);

		register_setting( 'listar_settings_group', 'listar_is_first_listing_view_preset', $sanitize_callback_no_html );
		add_settings_field( 'listar_is_first_listing_view_preset', '', 'listar_is_first_listing_view_preset_callback', 'listar_options', 'listar_options', $args87 );
		
		/**
		 * Disable default visibility for the views counter on single listing pages?
		 */

		$args85 = array(
			'class' => 'listar_theme_options_field listar_single_listing_view_counter_disable __views-counter',
		);

		register_setting( 'listar_settings_group', 'listar_single_listing_view_counter_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_single_listing_view_counter_disable', esc_html__( 'Disable default visibility for the views counter on single listing pages?', 'listar' ), 'listar_single_listing_view_counter_disable_callback', 'listar_options', 'listar_options', $args85 );

		/**
		 * Allow listing owners decide to show/hide the views counter in their listings?
		 */

		$args88 = array(
			'class' => 'listar_theme_options_field listar_allow_listing_owners_handle_counter __views-counter',
		);

		register_setting( 'listar_settings_group', 'listar_allow_listing_owners_handle_counter', $sanitize_callback_no_html );
		add_settings_field( 'listar_allow_listing_owners_handle_counter', esc_html__( 'Allow listing owners decide to show/hide the views counter in their listings?', 'listar' ), 'listar_allow_listing_owners_handle_counter_callback', 'listar_options', 'listar_options', $args88 );

		/**
		 * Display the views counter when editing a listing on the backend?
		 */

		$args96 = array(
			'class' => 'listar_theme_options_field listar_display_views_counter_backend __views-counter',
		);

		register_setting( 'listar_settings_group', 'listar_display_views_counter_backend', $sanitize_callback_no_html );
		add_settings_field( 'listar_display_views_counter_backend', esc_html__( 'Display the views counter when editing a listing on the backend?', 'listar' ), 'listar_display_views_counter_backend_callback', 'listar_options', 'listar_options', $args96 );
		
		/**
		 * Preset view counters
		 */

		$args86 = array(
			'class' => 'listar_theme_options_field listar_preset_view_counters __views-counter',
		);

		register_setting( 'listar_settings_group', 'listar_preset_view_counters', $sanitize_callback_no_html );
		add_settings_field( 'listar_preset_view_counters', esc_html__( 'Preset view counters', 'listar' ), 'listar_preset_view_counters_callback', 'listar_options', 'listar_options', $args86 );

		/**
		 * Disable bookmarks?
		 */

		$args98 = array(
			'class' => 'listar_theme_options_field listar_bookmarks_disable __bookmarks',
		);

		register_setting( 'listar_settings_group', 'listar_bookmarks_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_bookmarks_disable', esc_html__( 'Disable bookmarks?', 'listar' ), 'listar_bookmarks_disable_callback', 'listar_options', 'listar_options', $args98 );

		/**
		 * Display the bookmarks counter when editing a listing on the backend?
		 */

		$args99 = array(
			'class' => 'listar_theme_options_field listar_display_bookmarks_counter_backend __bookmarks',
		);

		register_setting( 'listar_settings_group', 'listar_display_bookmarks_counter_backend', $sanitize_callback_no_html );
		add_settings_field( 'listar_display_bookmarks_counter_backend', esc_html__( 'Display the bookmarks counter when editing a listing on the backend?', 'listar' ), 'listar_display_bookmarks_counter_backend_callback', 'listar_options', 'listar_options', $args99 );
		
		
		/**
		 * Disable claims?
		 */

		register_setting(
			'listar_settings_group',
			'listar_disable_claims',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_disable_claims',
			esc_html__( 'Disable claims?', 'listar' ),
			'listar_disable_claims_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_disable_claims __claims',
			)
		);
		
		if ( listar_is_claim_enabled() ) :

			/**
			 * Claim moderator email
			 */

			register_setting(
				'listar_settings_group',
				'listar_claim_moderator_email',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_claim_moderator_email',
				esc_html__( 'Claim moderator email', 'listar' ),
				'listar_claim_moderator_email_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_claim_moderator_email __claims',
				)
			);

			/**
			 * Number of characters required for claim validation text
			 */

			register_setting(
				'listar_settings_group',
				'listar_claim_minimum_validation_chars',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_claim_minimum_validation_chars',
				esc_html__( 'Number of characters required for claim validation text', 'listar' ),
				'listar_claim_minimum_validation_chars_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_claim_minimum_validation_chars __claims',
				)
			);
		endif;
		
		// Max trending listings
		register_setting( 'listar_settings_group', 'listar_max_trending_listings', $sanitize_callback_int );
		add_settings_field( 'listar_max_trending_listings', __( 'Max trending listings on pages in general', 'listar' ), 'listar_max_trending_listings_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field max_trending_listings __edit-trending' ) );

		// Minimum score to trend
		register_setting( 'listar_settings_group', 'listar_minimum_score_to_trend', $sanitize_callback_int );
		add_settings_field( 'listar_minimum_score_to_trend', __( 'Minimum score to trend', 'listar' ), 'listar_minimum_score_to_trend_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field minimum_score_to_trend __edit-trending' ) );

		// Score to most rated
		register_setting( 'listar_settings_group', 'listar_score_to_most_rated', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_most_rated', __( 'Score (importance) to most rated listings', 'listar' ), 'listar_score_to_most_rated_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_most_rated __edit-trending' ) );

		// Score to most bookmarked
		register_setting( 'listar_settings_group', 'listar_score_to_most_bookmarked', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_most_bookmarked', __( 'Score (importance) to most bookmarked listings', 'listar' ), 'listar_score_to_most_bookmarked_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_most_bookmarked __edit-trending' ) );

		// Score to most viewed
		register_setting( 'listar_settings_group', 'listar_score_to_most_viewed', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_most_viewed', __( 'Score (importance) to most viewed listings', 'listar' ), 'listar_score_to_most_viewed_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_most_viewed __edit-trending' ) );

		// Score to best rated
		register_setting( 'listar_settings_group', 'listar_score_to_best_rated', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_best_rated', __( 'Score (importance) to best rated listings', 'listar' ), 'listar_score_to_best_rated_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_best_rated __edit-trending' ) );

		// Score to featured listings
		register_setting( 'listar_settings_group', 'listar_score_to_featured', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_featured', __( 'Score (importance) to featured listings', 'listar' ), 'listar_score_to_featured_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_featured __edit-trending' ) );

		// Score to newest
		register_setting( 'listar_settings_group', 'listar_score_to_newest', $sanitize_callback_int );
		add_settings_field( 'listar_score_to_newest', __( 'Score (importance) to newest listings', 'listar' ), 'listar_score_to_newest_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field score_to_newest __edit-trending' ) );
		
		// Settings to trending, top listings, etc
		register_setting( 'listar_settings_group', 'listar_most_rated_listings' );
		register_setting( 'listar_settings_group', 'listar_top_rated_listings' );
		register_setting( 'listar_settings_group', 'listar_most_favorited_listings' );
		register_setting( 'listar_settings_group', 'listar_newest_listings' );
		register_setting( 'listar_settings_group', 'listar_featured_listings' );
		register_setting( 'listar_settings_group', 'listar_most_viewed_listings' );  
		register_setting( 'listar_settings_group', 'listar_trending_listings' );
		register_setting( 'listar_settings_group', 'listar_trending_listings_and_scores' );
		
		if ( listar_addons_active() ) {
			/**
			 * Update best rated list
			 */

			$args = array(
				'class' => 'listar_theme_options_field listar_best_rated_update_button __edit-trending',
			);

			add_settings_field( 'listar_best_rated_update_button', esc_html__( 'Force update for best rated and trending listings', 'listar' ), 'listar_best_rated_update_button_callback', 'listar_options', 'listar_options', $args );
		}
		
		// Trending log
		register_setting( 'listar_settings_group', 'listar_trending_log', $sanitize_callback_int );
		add_settings_field( 'listar_trending_log', __( 'Trending log', 'listar' ), 'listar_trending_log_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field trending_log __edit-trending' ) );

		/**
		 * Best rated listings (receives JSON with listing IDs)
		 */
		register_setting( 'listar_settings_group', 'listar_best_rated_listings', $sanitize_callback_no_html );

		/**
		 * Preset bookmarks counters
		 */

		$args100 = array(
			'class' => 'listar_theme_options_field listar_preset_bookmarks_counters __bookmarks',
		);

		register_setting( 'listar_settings_group', 'listar_preset_bookmarks_counters', $sanitize_callback_no_html );
		add_settings_field( 'listar_preset_bookmarks_counters', esc_html__( 'Preset bookmarks counters', 'listar' ), 'listar_preset_bookmarks_counters_callback', 'listar_options', 'listar_options', $args100 );
		
		/**
		 * Disable complaint reports? **********************************
		 */

		register_setting(
			'listar_settings_group',
			'listar_complaint_reports_disable',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_complaint_reports_disable',
			esc_html__( 'Disable complaint reports?', 'listar' ),
			'listar_complaint_reports_disable_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_complaint_reports_disable __edit-reports',
			)
		);

		/**
		 * Send reports for this email: **********************************
		 */

		register_setting(
			'listar_settings_group',
			'listar_complaint_reports_for',
			$sanitize_callback_sanitize_email
		);
		
		add_settings_field(
			'listar_complaint_reports_for',
			esc_html__( 'Send reports for this email:', 'listar' ),
			'listar_complaint_reports_for_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_complaint_reports_for __edit-reports',
			)
		);

		/**
		 * Who can send complaint reports? *****************************
		 */

		register_setting(
			'listar_settings_group',
			'listar_who_can_complaint',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_who_can_complaint',
			esc_html__( 'Who can send complaint reports?', 'listar' ),
			'listar_who_can_complaint_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_who_can_complaint __edit-reports',
			)
		);

		/**
		 * Disable required name field for not logged users? **********
		 */

		register_setting(
			'listar_settings_group',
			'listar_disable_complaint_name_field',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_disable_complaint_name_field',
			esc_html__( 'Disable required name field for not logged users?', 'listar' ),
			'listar_disable_complaint_name_field_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_disable_complaint_name_field __edit-reports',
			)
		);

		/**
		 * Disable required email field for not logged users? **********
		 */

		register_setting(
			'listar_settings_group',
			'listar_disable_complaint_email_field',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_disable_complaint_email_field',
			esc_html__( 'Disable required email field for not logged users?', 'listar' ),
			'listar_disable_complaint_email_field_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_disable_complaint_email_field __edit-reports',
			)
		);

		if ( ! listar_third_party_reviews_active() ) :

			/**
			 * Disable reviews
			 */

			$args91 = array(
				'class' => 'listar_theme_options_field listar_disable_reviews __reviews',
			);

			register_setting( 'listar_settings_group', 'listar_disable_reviews', 'esc_textarea' );
			add_settings_field( 'listar_disable_reviews', esc_html__( 'Disable reviews', 'listar' ), 'listar_disable_reviews_callback', 'listar_options', 'listar_options', $args91 );

			/**
			 * Review categories
			 */

			$args88 = array(
				'class' => 'listar_theme_options_field listar_review_categories __reviews',
			);

			register_setting( 'listar_settings_group', 'listar_review_categories', 'esc_textarea' );
			add_settings_field( 'listar_review_categories', esc_html__( 'Review categories', 'listar' ), 'listar_review_categories_callback', 'listar_options', 'listar_options', $args88 );

			/**
			 * Start the rating categories with
			 */

			register_setting(
				'listar_settings_group',
				'listar_start_ratings_with',
				$sanitize_callback_no_html
			);
			
			add_settings_field(
				'listar_start_ratings_with',
				esc_html__( 'Start the rating categories with', 'listar' ),
				'listar_start_ratings_with_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_start_ratings_with __reviews',
				)
			);
			
			/**
			 * Allow reviews without comment text
			 */

			$args89 = array(
				'class' => 'listar_theme_options_field listar_allow_review_without_comment __reviews',
			);

			register_setting( 'listar_settings_group', 'listar_allow_review_without_comment', $sanitize_callback_no_html );
			add_settings_field( 'listar_allow_review_without_comment', esc_html__( 'Allow reviews without comment text', 'listar' ), 'listar_allow_review_without_comment_callback', 'listar_options', 'listar_options', $args89 );

			/**
			 * Allow review submission by not logged users
			 */

			$args90 = array(
				'class' => 'listar_theme_options_field listar_allow_visitors_submit_reviews __reviews',
			);

			register_setting( 'listar_settings_group', 'listar_allow_visitors_submit_reviews', $sanitize_callback_no_html );
			add_settings_field( 'listar_allow_visitors_submit_reviews', esc_html__( 'Allow reviews by not logged users', 'listar' ), 'listar_allow_visitors_submit_reviews_callback', 'listar_options', 'listar_options', $args90 );

			/**
			 * Allow listing review by the listing owner
			 */

			$args93 = array(
				'class' => 'listar_theme_options_field listar_allow_owner_review_listing __reviews',
			);

			register_setting( 'listar_settings_group', 'listar_allow_owner_review_listing', $sanitize_callback_no_html );
			add_settings_field( 'listar_allow_owner_review_listing', esc_html__( 'Allow reviews by the listing owner', 'listar' ), 'listar_allow_owner_review_listing_callback', 'listar_options', 'listar_options', $args93 );
			
			/**
			 * Recalculate listing review averages
			 */

			$args150 = array(
				'class' => 'listar_theme_options_field listar_recalculate_review_averages_button __reviews',
			);

			add_settings_field( 'listar_recalculate_review_averages_button', esc_html__( 'Recalculate rating averages for listings', 'listar' ), 'listar_recalculate_review_averages_button_callback', 'listar_options', 'listar_options', $args150 );
			
		endif;

		/**
		 * Disable phone number?
		 */

		$args13 = array(
			'class' => 'listar_theme_options_field listar_phone_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_phone_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_phone_disable', esc_html__( 'Disable phone number?', 'listar' ), 'listar_phone_disable_callback', 'listar_options', 'listar_options', $args13 );
		
		/**
		 * Disable fax number?
		 */

		$args14 = array(
			'class' => 'listar_theme_options_field listar_fax_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_fax_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_fax_disable', esc_html__( 'Disable fax number?', 'listar' ), 'listar_fax_disable_callback', 'listar_options', 'listar_options', $args14 );

		/**
		 * Disable mobile number?
		 */

		$args15 = array(
			'class' => 'listar_theme_options_field listar_mobile_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_mobile_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_mobile_disable', esc_html__( 'Disable mobile number?', 'listar' ), 'listar_mobile_disable_callback', 'listar_options', 'listar_options', $args15 );
		
		/**
		 * Disable whatsapp number?
		 */

		$args17 = array(
			'class' => 'listar_theme_options_field listar_whatsapp_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_whatsapp_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_whatsapp_disable', esc_html__( 'Disable WhatsApp number?', 'listar' ), 'listar_whatsapp_disable_callback', 'listar_options', 'listar_options', $args17 );

		/**
		 * Disable online calls for phone number?
		 */

		$args20 = array(
			'class' => 'listar_theme_options_field listar_phone_online_call_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_phone_online_call_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_phone_online_call_disable', esc_html__( 'Disable online calls for phone number?', 'listar' ), 'listar_phone_online_call_disable_callback', 'listar_options', 'listar_options', $args20 );

		/**
		 * Disable online calls for WhatsApp number?
		 */

		$args19 = array(
			'class' => 'listar_theme_options_field listar_whatsapp_online_call_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_whatsapp_online_call_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_whatsapp_online_call_disable', esc_html__( 'Disable online calls for WhatsApp number?', 'listar' ), 'listar_whatsapp_online_call_disable_callback', 'listar_options', 'listar_options', $args19 );
		
		/**
		 * Disable online calls for mobile number?
		 */

		$args21 = array(
			'class' => 'listar_theme_options_field listar_mobile_online_call_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_mobile_online_call_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_mobile_online_call_disable', esc_html__( 'Disable online calls for mobile number?', 'listar' ), 'listar_mobile_online_call_disable_callback', 'listar_options', 'listar_options', $args21 );

		/**
		 * Disable website?
		 */

		$args18 = array(
			'class' => 'listar_theme_options_field listar_website_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_website_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_website_disable', esc_html__( 'Disable website?', 'listar' ), 'listar_website_disable_callback', 'listar_options', 'listar_options', $args18 );
		
		/**
		 * Disable operating hours?
		 */

		$args3 = array(
			'class' => 'listar_theme_options_field listar_operating_hours_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_operating_hours_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_operating_hours_disable', esc_html__( 'Disable operating hours?', 'listar' ), 'listar_operating_hours_disable_callback', 'listar_options', 'listar_options', $args3 );
		
		/**
		 * Operating hours format
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_operating_hours_format __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_operating_hours_format', $sanitize_callback_no_html );
		add_settings_field( 'listar_operating_hours_format', esc_html__( 'Operating hours format', 'listar' ), 'listar_operating_hours_format_callback', 'listar_options', 'listar_options', $args1 );

		/**
		 * Disable AM/PM suffix?
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_operating_hours_suffix __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_operating_hours_suffix', $sanitize_callback_int );
		add_settings_field( 'listar_operating_hours_suffix', esc_html__( 'Disable AM/PM suffix?', 'listar' ), 'listar_operating_hours_suffix_callback', 'listar_options', 'listar_options', $args2 );

		/**
		 * Disable menu/catalog?
		 */

		$args4 = array(
			'class' => 'listar_theme_options_field listar_menu_catalog_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_menu_catalog_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_menu_catalog_disable', esc_html__( 'Disable menu/catalog?', 'listar' ), 'listar_menu_catalog_disable_callback', 'listar_options', 'listar_options', $args4 );

		/**
		 * Disable appointments?
		 */

		register_setting(
			'listar_settings_group',
			'listar_appointments_disable',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_appointments_disable',
			esc_html__( 'Disable appointments?', 'listar' ),
			'listar_appointments_disable_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_appointments_disable __directory-config',
			)
		);
		
		/**
		 * Show recommended appointments services?
		 */

		register_setting(
			'listar_settings_group',
			'listar_recommended_appointment_services_disable',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_recommended_appointment_services_disable',
			esc_html__( 'Disable the recommended appointment services?', 'listar' ),
			'listar_recommended_appointment_services_disable_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_recommended_appointment_services_disable __directory-config',
			)
		);
		
		/**
		 * Recommended appointments services
		 */

		register_setting(
			'listar_settings_group',
			'listar_recommended_appointment_services',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_recommended_appointment_services',
			esc_html__( 'Customize the appointment service websites, e.g. https://any-website.com', 'listar' ),
			'listar_recommended_appointment_services_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_recommended_appointment_services __directory-config',
			)
		);

		/**
		 * Disable price range?
		 */

		$args5 = array(
			'class' => 'listar_theme_options_field listar_price_range_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_price_range_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_price_range_disable', esc_html__( 'Disable price range?', 'listar' ), 'listar_price_range_disable_callback', 'listar_options', 'listar_options', $args5 );

		/**
		 * Disable popular price?
		 */

		$args6 = array(
			'class' => 'listar_theme_options_field listar_popular_price_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_popular_price_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_popular_price_disable', esc_html__( 'Disable popular price?', 'listar' ), 'listar_popular_price_disable_callback', 'listar_options', 'listar_options', $args6 );

		/**
		 * Disable social networks?
		 */

		$args7 = array(
			'class' => 'listar_theme_options_field listar_social_networks_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_social_networks_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_social_networks_disable', esc_html__( 'Disable social networks?', 'listar' ), 'listar_social_networks_disable_callback', 'listar_options', 'listar_options', $args7 );

		/**
		 * Disable external references?
		 */

		$args80 = array(
			'class' => 'listar_theme_options_field listar_external_references_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_external_references_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_external_references_disable', esc_html__( 'Disable external references?', 'listar' ), 'listar_external_references_disable_callback', 'listar_options', 'listar_options', $args80 );

		/**
		 * Disable reviews/comments section?
		 */

		$args81 = array(
			'class' => 'listar_theme_options_field listar_reviews_section_disable __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_reviews_section_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_reviews_section_disable', esc_html__( 'Disable reviews/comments section?', 'listar' ), 'listar_reviews_section_disable_callback', 'listar_options', 'listar_options', $args81 );

		/**
		 * Minimum height to turn an accordion section scrollable
		 */

		register_setting(
			'listar_settings_group',
			'listar_accordion_scrollable_after',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_accordion_scrollable_after',
			esc_html__( 'Minimum height to turn an accordion section scrollable', 'listar' ),
			'listar_accordion_scrollable_after_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_accordion_scrollable_after __directory-config',
			)
		);

	}

	if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
		/**
		 * Allow multiple regions for listings on Front End
		 */

		$args0 = array(
			'class' => 'listar_theme_options_field listar_allow_multiple_regions_frontend __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_allow_multiple_regions_frontend', $sanitize_callback_no_html );
		add_settings_field( 'listar_allow_multiple_regions_frontend', esc_html__( 'Allow multiple regions for listings on front end submission form', 'listar' ), 'listar_allow_multiple_regions_frontend_callback', 'listar_options', 'listar_options', $args0 );

		/**
		 * Default region for search
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_default_region_search __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_default_region_search', $sanitize_callback_no_html );
		add_settings_field( 'listar_default_region_search', esc_html__( 'Default region for search', 'listar' ), 'listar_default_region_search_callback', 'listar_options', 'listar_options', $args1 );

		/**
		 * After select a region on hero header search and popup
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_after_region_selected __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_after_region_selected', $sanitize_callback_no_html );
		add_settings_field( 'listar_after_region_selected', esc_html__( 'After select a region on hero header search and popup', 'listar' ), 'listar_after_region_selected_callback', 'listar_options', 'listar_options', $args1 );
	}
	
	if ( post_type_exists( 'job_listing' ) ) {

		/**
		 * Disable listing "grid filler" card
		 */

		$args22 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_card_disable __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_card_disable', $sanitize_callback_no_html );
		add_settings_field( 'listar_grid_filler_listing_card_disable', esc_html__( 'Disable listing "grid filler" card', 'listar' ), 'listar_grid_filler_listing_card_disable_callback', 'listar_options', 'listar_options', $args22 );

		/**
		 * Title for listing "grid filler" card.
		 */

		$args24 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_card_title __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_card_title', $sanitize_callback_no_html );
		add_settings_field( 'listar_grid_filler_listing_card_title', esc_html__( 'Title for listing "grid filler" card', 'listar' ), 'listar_grid_filler_listing_card_title_callback', 'listar_options', 'listar_options', $args24 );

		/**
		 * Text for listing "grid filler" card.
		 */

		$args25 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_card_text1 __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_card_text1', $sanitize_callback_no_html );
		add_settings_field( 'listar_grid_filler_listing_card_text1', esc_html__( 'Description for listing "grid filler" card', 'listar' ), 'listar_grid_filler_listing_card_text1_callback', 'listar_options', 'listar_options', $args25 );

		/**
		 * Additional text for listing "grid filler" card.
		 */

		$args26 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_card_text2 __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_card_text2', $sanitize_callback_no_html );
		add_settings_field( 'listar_grid_filler_listing_card_text2', esc_html__( 'Additional text for listing "grid filler" card', 'listar' ), 'listar_grid_filler_listing_card_text2_callback', 'listar_options', 'listar_options', $args26 );

		/**
		 * Button text for listing "grid filler" card.
		 */

		$args27 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_button_text __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_button_text', $sanitize_callback_no_html );
		add_settings_field( 'listar_grid_filler_listing_button_text', esc_html__( 'Button text for listing "grid filler" card.', 'listar' ), 'listar_grid_filler_listing_button_text_callback', 'listar_options', 'listar_options', $args27 );

		/**
		 * Custom link for listing "grid filler" card.
		 */

		$args28 = array(
			'class' => 'listar_theme_options_field listar_grid_filler_listing_button_url __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_grid_filler_listing_button_url', $sanitize_callback_esc_url );
		add_settings_field( 'listar_grid_filler_listing_button_url', esc_html__( 'Custom link for listing "grid filler" card.', 'listar' ), 'listar_grid_filler_listing_button_url_callback', 'listar_options', 'listar_options', $args28 );
	}

	/**
	 * Disable blog "grid filler" card
	 */

	$args92 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_card_disable __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_card_disable', $sanitize_callback_no_html );
	add_settings_field( 'listar_grid_filler_blog_card_disable', esc_html__( 'Disable blog "grid filler" card', 'listar' ), 'listar_grid_filler_blog_card_disable_callback', 'listar_options', 'listar_options', $args92 );

	if ( post_type_exists( 'job_listing' ) ) {
		
		/**
		 * Replicate the listing "grid filler" card on blog
		 */

		$args85 = array(
			'class' => 'listar_theme_options_field listar_use_listing_grid_filler_blog __edit-grid-filler',
		);

		register_setting( 'listar_settings_group', 'listar_use_listing_grid_filler_blog', $sanitize_callback_int );
		add_settings_field( 'listar_use_listing_grid_filler_blog', esc_html__( 'Replicate the listing "grid filler" card on blog', 'listar' ), 'listar_use_listing_grid_filler_blog_callback', 'listar_options', 'listar_options', $args85 );
	}
	
	/**
	 * Title for blog "grid filler" card.
	 */

	$args24 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_card_title __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_card_title', $sanitize_callback_no_html );
	add_settings_field( 'listar_grid_filler_blog_card_title', esc_html__( 'Title for blog "grid filler" card', 'listar' ), 'listar_grid_filler_blog_card_title_callback', 'listar_options', 'listar_options', $args24 );

	/**
	 * Text for blog "grid filler" card.
	 */

	$args25 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_card_text1 __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_card_text1', $sanitize_callback_no_html );
	add_settings_field( 'listar_grid_filler_blog_card_text1', esc_html__( 'Description for blog "grid filler" card', 'listar' ), 'listar_grid_filler_blog_card_text1_callback', 'listar_options', 'listar_options', $args25 );

	/**
	 * Additional text for blog "grid filler" card.
	 */

	$args26 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_card_text2 __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_card_text2', $sanitize_callback_no_html );
	add_settings_field( 'listar_grid_filler_blog_card_text2', esc_html__( 'Additional text for blog "grid filler" card', 'listar' ), 'listar_grid_filler_blog_card_text2_callback', 'listar_options', 'listar_options', $args26 );

	/**
	 * Button text for blog "grid filler" card.
	 */

	$args83 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_button_text __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_button_text', $sanitize_callback_no_html );
	add_settings_field( 'listar_grid_filler_blog_button_text', esc_html__( 'Button text for blog "grid filler" card.', 'listar' ), 'listar_grid_filler_blog_button_text_callback', 'listar_options', 'listar_options', $args83 );

	/**
	 * Custom link for blog "grid filler" card.
	 */

	$args84 = array(
		'class' => 'listar_theme_options_field listar_grid_filler_blog_button_url __edit-grid-filler',
	);

	register_setting( 'listar_settings_group', 'listar_grid_filler_blog_button_url', $sanitize_callback_esc_url );
	add_settings_field( 'listar_grid_filler_blog_button_url', esc_html__( 'Custom link for blog "grid filler" card.', 'listar' ), 'listar_grid_filler_blog_button_url_callback', 'listar_options', 'listar_options', $args84 );
	
	if ( post_type_exists( 'job_listing' ) ) {
		/**
		 * Fallback description for listing cards
		 */

		$args32 = array(
			'class' => 'listar_theme_options_field listar_fallback_listing_card_description __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_fallback_listing_card_description', $sanitize_callback_no_html );
		add_settings_field( 'listar_fallback_listing_card_description', esc_html__( 'Fallback description for listing cards', 'listar' ), 'listar_fallback_listing_card_description_callback', 'listar_options', 'listar_options', $args32 );
		
		if ( listar_addons_active() ) :

			/**
			 * Initial sort order for default listing search and archive
			 */

			$args63 = array(
				'class' => 'listar_theme_options_field listar_initial_listing_sort_order __edit-search',
			);

			register_setting( 'listar_settings_group', 'listar_initial_listing_sort_order', $sanitize_callback_no_html );
			add_settings_field( 'listar_initial_listing_sort_order', esc_html__( 'Initial sort order for default listing search and archive', 'listar' ), 'listar_initial_listing_sort_order_callback', 'listar_options', 'listar_options', $args63 );

			/**
			 * Custom label for "Random" sort filter
			 */

			$args62 = array(
				'class' => 'listar_theme_options_field listar_custom_random_label __edit-search',
			);

			register_setting( 'listar_settings_group', 'listar_custom_random_label', $sanitize_callback_no_html );
			add_settings_field( 'listar_custom_random_label', esc_html__( 'Custom label for "Random" sort filter', 'listar' ), 'listar_custom_random_label_callback', 'listar_options', 'listar_options', $args62 );
		endif;

		/**
		 * Default static search placeholder text
		 */

		$args1 = array(
			'class' => 'listar_theme_options_field listar_search_input_placeholder __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_search_input_placeholder', $sanitize_callback_no_html );
		add_settings_field( 'listar_search_input_placeholder', esc_html__( 'Default search text (placeholder)', 'listar' ), 'listar_search_input_placeholder_callback', 'listar_options', 'listar_options', $args1 );
		
		/**
		 * Title for search popup
		 */

		$args46 = array(
			'class' => 'listar_theme_options_field listar_search_popup_title __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_search_popup_title', $sanitize_callback_no_html );
		add_settings_field( 'listar_search_popup_title', esc_html__( 'Title for search popup', 'listar' ), 'listar_search_popup_title_callback', 'listar_options', 'listar_options', $args46 );

		/**
		 * Subtitle for search popup
		 */

		$args47 = array(
			'class' => 'listar_theme_options_field listar_search_popup_subtitle __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_search_popup_subtitle', $sanitize_callback_no_html );
		add_settings_field( 'listar_search_popup_subtitle', esc_html__( 'Subtitle for search popup', 'listar' ), 'listar_search_popup_subtitle_callback', 'listar_options', 'listar_options', $args47 );

		/**
		 * Disable search tip below search input field
		 */

		register_setting(
			'listar_settings_group',
			'listar_disable_search_tip',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_disable_search_tip',
			esc_html__( 'Disable search tip below search input field', 'listar' ),
			'listar_disable_search_tip_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_disable_search_tip __edit-search',
			)
		);
		
		/**
		 * Title for search tip
		 */

		register_setting(
			'listar_settings_group',
			'listar_search_tip_title',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_search_tip_title',
			esc_html__( 'Title for search tip', 'listar' ),
			'listar_search_tip_title_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_search_tip_title __edit-search',
			)
		);

		/**
		 * Subtitle for search tip
		 */

		register_setting(
			'listar_settings_group',
			'listar_search_tip_subtitle',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_search_tip_subtitle',
			esc_html__( 'Subtitle for search tip', 'listar' ),
			'listar_search_tip_subtitle_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_search_tip_subtitle __edit-search',
			)
		);

		/**
		 * Icon for search tip
		 */

		register_setting(
			'listar_settings_group',
			'listar_search_tip_icon',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_search_tip_icon',
			esc_html__( 'Icon for search tip', 'listar' ),
			'listar_search_tip_icon_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_search_tip_icon __edit-search',
			)
		);
		
		/**
		 * Disable related listings for listing posts
		 */

		$args49 = array(
			'class' => 'listar_theme_options_field listar_disable_related_listings_single __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_disable_related_listings_single', $sanitize_callback_int );
		add_settings_field( 'listar_disable_related_listings_single', esc_html__( 'Disable related listings for listing posts', 'listar' ), 'listar_disable_related_listings_single_callback', 'listar_options', 'listar_options', $args49 );

		/**
		 * Related listings title for listing posts
		 */

		$args2 = array(
			'class' => 'listar_theme_options_field listar_related_listings_title __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_title', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_title', esc_html__( 'Related listings title for listing posts', 'listar' ), 'listar_related_listings_title_callback', 'listar_options', 'listar_options', $args2 );

		/**
		 * The related listings for listing posts must load
		 */

		$args57 = array(
			'class' => 'listar_theme_options_field listar_related_listings_single_schema __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_single_schema', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_single_schema', esc_html__( 'The related listings for listing posts must load', 'listar' ), 'listar_related_listings_single_schema_callback', 'listar_options', 'listar_options', $args57 );

		/**
		 * After recover smart related listings for listing posts, prioritize
		 */

		$args58 = array(
			'class' => 'listar_theme_options_field listar_related_listings_single_priority __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_single_priority', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_single_priority', esc_html__( 'After recover smart related listings for listing posts, prioritize', 'listar' ), 'listar_related_listings_single_priority_callback', 'listar_options', 'listar_options', $args58 );

		/**
		 * If the listing post belongs to a region, disable related listings from any other regions
		 */

		$args59 = array(
			'class' => 'listar_theme_options_field listar_related_listings_single_disable_other_regions __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_single_disable_other_regions', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_single_disable_other_regions', esc_html__( 'If the listing post belongs to a region, disable related listings from any other regions', 'listar' ), 'listar_related_listings_single_disable_other_regions_callback', 'listar_options', 'listar_options', $args59 );

		/**
		 * Maximum related listings to expose on listing posts
		 */

		$args60 = array(
			'class' => 'listar_theme_options_field listar_related_listings_single_maximum __directory-config',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_single_maximum', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_single_maximum', esc_html__( 'Maximum related listings to expose on listing posts', 'listar' ), 'listar_related_listings_single_maximum_callback', 'listar_options', 'listar_options', $args60 );

		/**
		 * Maximum number of images for gallery upload on front end submission form
		 */

		register_setting(
			'listar_settings_group',
			'listar_max_gallery_upload_images',
			$sanitize_callback_int
		);
		
		add_settings_field(
			'listar_max_gallery_upload_images',
			esc_html__( 'Maximum number of images for gallery upload on front end submission form', 'listar' ),
			'listar_max_gallery_upload_images_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_max_gallery_upload_images __directory-config',
			)
		);

		/**
		 * Maximum number of video/media fields on front end submission form
		 */

		register_setting(
			'listar_settings_group',
			'listar_max_media_fields',
			$sanitize_callback_int
		);
		
		add_settings_field(
			'listar_max_media_fields',
			esc_html__( 'Maximum number of video/media fields on front end submission form', 'listar' ),
			'listar_max_media_fields_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_max_media_fields __directory-config',
			)
		);

		

		/**
		 * On the listing page, pre-open
		 */

		register_setting(
			'listar_settings_group',
			'listar_single_listing_preopen',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_single_listing_preopen',
			esc_html__( 'On the listing page, pre-open', 'listar' ),
			'listar_single_listing_preopen_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_single_listing_preopen __directory-config',
			)
		);

		

		/**
		 * On the listing page, group amenities per parents
		 */

		register_setting(
			'listar_settings_group',
			'listar_single_group_amenities_parent',
			$sanitize_callback_int
		);
		
		add_settings_field(
			'listar_single_group_amenities_parent',
			esc_html__( 'On the listing page, group amenities per parents', 'listar' ),
			'listar_single_group_amenities_parent_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_single_group_amenities_parent __directory-config',
			)
		);

		

		/**
		 * Hide parent amenities from amenity pickers
		 */

		register_setting(
			'listar_settings_group',
			'listar_hide_parent_amenity_pickers',
			$sanitize_callback_int
		);
		
		add_settings_field(
			'listar_hide_parent_amenity_pickers',
			esc_html__( 'Hide parent amenities from amenity pickers', 'listar' ),
			'listar_hide_parent_amenity_pickers_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_hide_parent_amenity_pickers __directory-config',
			)
		);

		/**
		 * Enable related listings for archive pages
		 */

		$args50 = array(
			'class' => 'listar_theme_options_field listar_disable_related_listings_archive __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_disable_related_listings_archive', $sanitize_callback_int );
		add_settings_field( 'listar_disable_related_listings_archive', esc_html__( 'Enable related listings for archive pages', 'listar' ), 'listar_disable_related_listings_archive_callback', 'listar_options', 'listar_options', $args50 );

		/**
		 * Related listings title for archive pages
		 */

		$args48 = array(
			'class' => 'listar_theme_options_field listar_related_listings_archive_title __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_archive_title', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_archive_title', esc_html__( 'Related listings title for archive pages', 'listar' ), 'listar_related_listings_archive_title_callback', 'listar_options', 'listar_options', $args48 );

		/**
		 * The related listings for archive and search pages must load
		 */

		$args53 = array(
			'class' => 'listar_theme_options_field listar_related_listings_archive_schema __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_archive_schema', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_archive_schema', esc_html__( 'The related listings for archive and search pages must load', 'listar' ), 'listar_related_listings_archive_schema_callback', 'listar_options', 'listar_options', $args53 );

		/**
		 * If random related listings for archive and searches, prioritize
		 */

		$args54 = array(
			'class' => 'listar_theme_options_field listar_related_listings_archive_priority __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_archive_priority', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_archive_priority', esc_html__( 'After recover smart related listings for archive and searches, prioritize', 'listar' ), 'listar_related_listings_archive_priority_callback', 'listar_options', 'listar_options', $args54 );

		/**
		 * If archive or search is filtered by region, disable related listings from any other regions
		 */

		$args56 = array(
			'class' => 'listar_theme_options_field listar_related_listings_archive_disable_other_regions __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_archive_disable_other_regions', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_archive_disable_other_regions', esc_html__( 'If archive or search is filtered by region, disable related listings from any other regions', 'listar' ), 'listar_related_listings_archive_disable_other_regions_callback', 'listar_options', 'listar_options', $args56 );

		/**
		 * Maximum related listings to expose on archive and searches
		 */

		$args55 = array(
			'class' => 'listar_theme_options_field listar_related_listings_archive_maximum __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_related_listings_archive_maximum', $sanitize_callback_no_html );
		add_settings_field( 'listar_related_listings_archive_maximum', esc_html__( 'Maximum related listings to expose on archive and searches', 'listar' ), 'listar_related_listings_archive_maximum_callback', 'listar_options', 'listar_options', $args55 );

		if ( listar_addons_active() ) {
			
			/**
			 * Postpone listing card contents on archive pages, make it load if visible on the screen
			 */

			$args87 = array(
				'class' => 'listar_theme_options_field listar_load_listing_card_content_ajax __edit-pagespeed',
			);

			register_setting( 'listar_settings_group', 'listar_load_listing_card_content_ajax', $sanitize_callback_int );
			add_settings_field( 'listar_load_listing_card_content_ajax', esc_html__( 'Postpone listing card contents on archive pages, make it load only if visible on the screen.', 'listar' ), 'listar_load_listing_card_content_ajax_callback', 'listar_options', 'listar_options', $args87 );
			
			if ( function_exists( 'listar_clean_cache' ) ) {
				
				if ( class_exists( 'autoptimizeCache' ) || function_exists( 'wpfastestcache_activate' ) ) {
					/**
					 * Automatic cache cleaning
					 */

					$args1 = array(
						'class' => 'listar_theme_options_field listar_automatic_cache_cleaning __edit-pagespeed',
					);

					register_setting( 'listar_settings_group', 'listar_automatic_cache_cleaning', $sanitize_callback_no_html );
					add_settings_field( 'listar_automatic_cache_cleaning', esc_html__( 'Automatic cache cleaning every', 'listar' ), 'listar_automatic_cache_cleaning_callback', 'listar_options', 'listar_options', $args1 );
					
					/**
					 * Do not delete cache every time contents are handled
					 */

					register_setting(
						'listar_settings_group',
						'listar_keep_cache_on_changes',
						$sanitize_callback_no_html
					);
					
					add_settings_field(
						'listar_keep_cache_on_changes',
						esc_html__( 'Do not delete cache after handling contents (create, edit or delete)', 'listar' ),
						'listar_keep_cache_on_changes_callback',
						'listar_options',
						'listar_options',
						array(
							'class' => 'listar_theme_options_field listar_keep_cache_on_changes __edit-pagespeed',
						)
					);

					/**
					 * Reset last cache cleaning time
					 */

					$args2 = array(
						'class' => 'listar_theme_options_field listar_reset_last_cache_cleaning_time __edit-pagespeed',
					);

					register_setting( 'listar_settings_group', 'listar_reset_last_cache_cleaning_time', $sanitize_callback_no_html );
					add_settings_field( 'listar_reset_last_cache_cleaning_time', 'Hidden field - No translation needed', 'listar_reset_last_cache_cleaning_time_callback', 'listar_options', 'listar_options', $args2 );
				}
				
				/**
				 * Image quality for hero images on mobile devices
				 */

				register_setting(
					'listar_settings_group',
					'listar_image_size_mobile',
					$sanitize_callback_no_html
				);

				add_settings_field(
					'listar_image_size_mobile',
					esc_html__( 'Image quality for hero images on mobile devices', 'listar' ),
					'listar_image_size_mobile_callback',
					'listar_options',
					'listar_options',
					array( 'class' => 'listar_theme_options_field listar_image_size_mobile __edit-pagespeed' )
				);

				/**
				 * Force a Base64 encoded image as 32x32px Favicon.
				 */

				$args5 = array(
					'class' => 'listar_theme_options_field listar_base64_favicon_32x32 __edit-pagespeed',
				);

				register_setting( 'listar_settings_group', 'listar_base64_favicon_32x32', 'esc_textarea' );
				add_settings_field( 'listar_base64_favicon_32x32', esc_html__( 'Force a Base64 encoded image as 32x32px Favicon', 'listar' ), 'listar_base64_favicon_32x32_callback', 'listar_options', 'listar_options', $args5 );

				/**
				 * Pagespeed To Do List
				 */

				$args4 = array(
					'class' => 'listar_theme_options_field listar_todo_pagespeed __edit-pagespeed',
				);

				add_settings_field( 'listar_todo_pagespeed', esc_html__( 'Pagespeed To Do List (all optional, but strongly recommended)', 'listar' ), 'listar_todo_pagespeed_callback', 'listar_options', 'listar_options', $args4 );
				
				/**
				 * Enable Listar Pagespeed
				 */

				$args3 = array(
					'class' => 'listar_theme_options_field listar_activate_pagespeed __edit-pagespeed',
				);

				register_setting( 'listar_settings_group', 'listar_activate_pagespeed', $sanitize_callback_no_html );
				add_settings_field( 'listar_activate_pagespeed', esc_html__( 'Enable Listar Pagespeed', 'listar' ), 'listar_activate_pagespeed_callback', 'listar_options', 'listar_options', $args3 );

			}
		}
		
		if ( listar_addons_active() ) {
			
			/* Covers Astoundify and Automattic Payment plugins */
			if ( 0 === 1 && ( class_exists( 'Woocommerce' ) && ( defined( 'ASTOUNDIFY_WPJMLP_VERSION' ) || class_exists( 'WC_Paid_Listings' ) ) ) ) :
				
				/**
				 * Auto approve listings after complete orders
				 */

				register_setting(
					'listar_settings_group',
					'listar_auto_approve_paid_listings',
					$sanitize_callback_int
				);
				
				add_settings_field(
					'listar_auto_approve_paid_listings',
					esc_html__( 'Auto approve listings after complete orders', 'listar' ),
					'listar_auto_approve_paid_listings_callback',
					'listar_options',
					'listar_options',
					array(
						'class' => 'listar_theme_options_field listar_auto_approve_paid_listings __edit-payments',
					)
				);
			endif;
			
			/**
			 * Geocoding provider.
			 */

			$args40 = array(
				'class' => 'listar_theme_options_field listar_geocoding_provider __edit-map',
			);

			register_setting( 'listar_settings_group', 'listar_geocoding_provider', $sanitize_callback_no_html );
			add_settings_field( 'listar_geocoding_provider', esc_html__( 'Geocoding provider', 'listar' ), 'listar_geocoding_provider_callback', 'listar_options', 'listar_options', $args40 );

			/**
			 * Geocoding API Keys.
			 */

			register_setting( 'listar_settings_group', 'listar_jawg_api_key', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_mapbox_api_key', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_here_api_key', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_googlemaps_api_key', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_bingmaps_api_key', $sanitize_callback_no_html );
			
			/**
			 * Language codes.
			 */
			register_setting( 'listar_settings_group', 'listar_jawg_language_code', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_mapbox_language_code', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_here_language_code', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_mapplus_language_code', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_openstreetmap_language_code', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_bingmaps_language_code', $sanitize_callback_no_html );
			
			/**
			 * Map Provider (public map view).
			 */

			$args41 = array(
				'class' => 'listar_theme_options_field listar_map_provider __edit-map',
			);

			register_setting( 'listar_settings_group', 'listar_map_provider', $sanitize_callback_no_html );
			add_settings_field( 'listar_map_provider', esc_html__( 'Map Provider (public map view)', 'listar' ), 'listar_map_provider_callback', 'listar_options', 'listar_options', $args41 );

			/**
			 * Map Provider API Key.
			 */

			register_setting( 'listar_settings_group', 'listar_mapbox_design_provider_api_key', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_jawg_design_provider_api_key', $sanitize_callback_no_html );

			/**
			 * Map Style URL.
			 */

			register_setting( 'listar_settings_group', 'listar_mapbox_style_url', $sanitize_callback_no_html );
			register_setting( 'listar_settings_group', 'listar_jawg_style_url', $sanitize_callback_no_html );
		}

		/**
		 * Disable all maps.
		 */

		$args35 = array(
			'class' => 'listar_theme_options_field listar_disable_all_maps __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_disable_all_maps', $sanitize_callback_int );
		add_settings_field( 'listar_disable_all_maps', esc_html__( 'Disable all maps', 'listar' ), 'listar_disable_all_maps_callback', 'listar_options', 'listar_options', $args35 );

		/**
		 * Disable map for listing search and archive.
		 */

		$args36 = array(
			'class' => 'listar_theme_options_field listar_disable_archive_maps __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_disable_archive_maps', $sanitize_callback_int );
		add_settings_field( 'listar_disable_archive_maps', esc_html__( 'Disable map for listing search and archive', 'listar' ), 'listar_disable_archive_maps_callback', 'listar_options', 'listar_options', $args36 );

		/**
		 * Disable map for single listing.
		 */

		$args37 = array(
			'class' => 'listar_theme_options_field listar_disable_single_maps __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_disable_single_maps', $sanitize_callback_int );
		add_settings_field( 'listar_disable_single_maps', esc_html__( 'Disable map for single listing', 'listar' ), 'listar_disable_single_maps_callback', 'listar_options', 'listar_options', $args37 );

		/**
		 * Disable directions for single listing.
		 */

		$args38 = array(
			'class' => 'listar_theme_options_field listar_disable_directions_maps __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_disable_directions_maps', $sanitize_callback_int );
		add_settings_field( 'listar_disable_directions_maps', esc_html__( 'Disable directions for single listing', 'listar' ), 'listar_disable_directions_maps_callback', 'listar_options', 'listar_options', $args38 );

		/**
		 * Disable GPS for single listing.
		 */

		$args39 = array(
			'class' => 'listar_theme_options_field listar_disable_gps_maps __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_disable_gps_maps', $sanitize_callback_int );
		add_settings_field( 'listar_disable_gps_maps', esc_html__( 'Disable GPS for single listing', 'listar' ), 'listar_disable_gps_maps_callback', 'listar_options', 'listar_options', $args39 );

		/**
		 * Default (fallback) location for listing map.
		 */

		$args29 = array(
			'class' => 'listar_theme_options_field listar_fallback_map_location __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_fallback_map_location', $sanitize_callback_no_html );
		add_settings_field( 'listar_fallback_map_location', esc_html__( 'Default (fallback) location for listing map', 'listar' ), 'listar_fallback_map_location_callback', 'listar_options', 'listar_options', $args29 );

		/**
		 * Minimum map zoom level
		 */

		$args42 = array(
			'class' => 'listar_theme_options_field listar_min_map_zoom_level __edit-map',
		);

		register_setting( 'listar_settings_group', 'listar_min_map_zoom_level', $sanitize_callback_int );
		add_settings_field( 'listar_min_map_zoom_level', esc_html__( 'Minimum map zoom level', 'listar' ), 'listar_min_map_zoom_level_callback', 'listar_options', 'listar_options', $args42 );

		/**
                 * Maximum map zoom level
                 */

                $args43 = array(
                        'class' => 'listar_theme_options_field listar_max_map_zoom_level __edit-map',
                );

                register_setting( 'listar_settings_group', 'listar_max_map_zoom_level', $sanitize_callback_int );
                add_settings_field( 'listar_max_map_zoom_level', esc_html__( 'Maximum map zoom level', 'listar' ), 'listar_max_map_zoom_level_callback', 'listar_options', 'listar_options', $args43 );

                /**
                 * Initial map zoom for listing archive
                 */

                register_setting(
                        'listar_settings_group',
                        'listar_initial_archive_map_zoom_level',
                        $sanitize_callback_int
                );

                add_settings_field(
                        'listar_initial_archive_map_zoom_level',
                        esc_html__( 'Initial map zoom for listing archive', 'listar' ),
                        'listar_initial_archive_map_zoom_level_callback',
                        'listar_options',
                        'listar_options',
                        array(
                                'class' => 'listar_theme_options_field listar_initial_archive_map_zoom_level __edit-map',
                        )
                );

                /**
                 * Initial map zoom for single listing pages
                 */

                register_setting(
                        'listar_settings_group',
                        'listar_initial_single_map_zoom_level',
                        $sanitize_callback_int
                );

                add_settings_field(
                        'listar_initial_single_map_zoom_level',
                        esc_html__( 'Initial map zoom for single listing pages', 'listar' ),
                        'listar_initial_single_map_zoom_level_callback',
                        'listar_options',
                        'listar_options',
                        array(
                                'class' => 'listar_theme_options_field listar_initial_single_map_zoom_level __edit-map',
                        )
                );

		/**
		 * Ajax pagination
		 */

		$args3 = array(
			'class' => 'listar_theme_options_field listar_ajax_pagination __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_ajax_pagination', $sanitize_callback_int );
		add_settings_field( 'listar_ajax_pagination', esc_html__( 'Use Ajax pagination on archive pages', 'listar' ), 'listar_ajax_pagination_callback', 'listar_options', 'listar_options', $args3 );

		/**
		 * Ajax infinite loading - Depends on 'Ajax pagination' option
		 */

		$args4 = array(
			'class' => 'listar_theme_options_field listar_ajax_infinite_loading hidden __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_ajax_infinite_loading', $sanitize_callback_int );
		add_settings_field( 'listar_ajax_infinite_loading', esc_html__( 'Make Ajax pagination automatic (infinite scroll)', 'listar' ), 'listar_ajax_infinite_loading_callback', 'listar_options', 'listar_options', $args4 );

		/**
		 * Spiral hover effect for listings
		 */

		$args5 = array(
			'class' => 'listar_theme_options_field listar_activate_spiral_effect __edit-effects',
		);

		register_setting( 'listar_settings_group', 'listar_activate_spiral_effect', $sanitize_callback_int );
		add_settings_field( 'listar_activate_spiral_effect', esc_html__( 'Use spiral hover effect for listings', 'listar' ), 'listar_activate_spiral_effect_callback', 'listar_options', 'listar_options', $args5 );

		/**
		 * Rubber effect on front page header
		 */

		$args7 = array(
			'class' => 'listar_theme_options_field listar_hero_rubber_effect __edit-effects',
		);

		register_setting( 'listar_settings_group', 'listar_hero_rubber_effect', $sanitize_callback_int );
		add_settings_field( 'listar_hero_rubber_effect', esc_html__( 'Rubber effect on front page header', 'listar' ), 'listar_hero_rubber_effect_callback', 'listar_options', 'listar_options', $args7 );

		/**
		 * Animate elements while scrolling
		 */

		$args12 = array(
			'class' => 'listar_theme_options_field listar_animate_elements_on_scroll __edit-effects',
		);

		register_setting( 'listar_settings_group', 'listar_animate_elements_on_scroll', $sanitize_callback_int );
		add_settings_field( 'listar_animate_elements_on_scroll', esc_html__( 'Animate elements while scrolling', 'listar' ), 'listar_animate_elements_on_scroll_callback', 'listar_options', 'listar_options', $args12 );

		/**
		 * Try to generate a carousel on listing categories popup
		 */

		$args13 = array(
			'class' => 'listar_theme_options_field listar_use_carousel_categories_popup __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_use_carousel_categories_popup', $sanitize_callback_int );
		add_settings_field( 'listar_use_carousel_categories_popup', esc_html__( 'Try to generate a carousel on listing categories popup', 'listar' ), 'listar_use_carousel_categories_popup_callback', 'listar_options', 'listar_options', $args13 );

		/**
		 * Try to generate a carousel on listing regions popup
		 */

		$args14 = array(
			'class' => 'listar_theme_options_field listar_use_carousel_regions_popup __edit-search',
		);

		register_setting( 'listar_settings_group', 'listar_use_carousel_regions_popup', $sanitize_callback_int );
		add_settings_field( 'listar_use_carousel_regions_popup', esc_html__( 'Try to generate a carousel on listing regions popup', 'listar' ), 'listar_use_carousel_regions_popup_callback', 'listar_options', 'listar_options', $args14 );

		/*
		 * Explore By options.
		 */
		
		if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {
			
			/**
			 * Disable all listing search options
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_disable_all_search_by_options __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_all_search_by_options', $sanitize_callback_int );
			add_settings_field( 'listar_disable_all_search_by_options', esc_html__( 'Disable all listing search types', 'listar' ), 'listar_disable_all_search_by_options_callback', 'listar_options', 'listar_options', $args1 );
			
			/**
			 * Initial type of search for Explore By
			 */

			$args82 = array(
				'class' => 'listar_theme_options_field listar_initial_explore_by_type __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_initial_explore_by_type', $sanitize_callback_no_html );
			add_settings_field( 'listar_initial_explore_by_type', esc_html__( 'Initial type of search for "Explore By"', 'listar' ), 'listar_initial_explore_by_type_callback', 'listar_options', 'listar_options', $args82 );
			
			/**
			 * Heading title for "Explore By" popup
			 */

			$args7 = array(
				'class' => 'listar_theme_options_field listar_search_by_popup_title __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_search_by_popup_title', $sanitize_callback_no_html );
			add_settings_field( 'listar_search_by_popup_title', esc_html__( 'Heading title for "Explore By" popup', 'listar' ), 'listar_search_by_popup_title_callback', 'listar_options', 'listar_options', $args7 );

			/**
			 * Footer description for "Explore By" popup
			 */

			$args8 = array(
				'class' => 'listar_theme_options_field listar_search_by_popup_description __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_search_by_popup_description', $sanitize_callback_no_html );
			add_settings_field( 'listar_search_by_popup_description', esc_html__( 'Footer description for "Explore By" popup', 'listar' ), 'listar_search_by_popup_description_callback', 'listar_options', 'listar_options', $args8 );

			if ( listar_is_search_by_option_active( 'near_address' ) || listar_is_search_by_option_active( 'near_postcode' ) ) :
				
				/**
				 * Set at least a country to be used for searches by "Near an address" and "Near a postcode"
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_predefined_countries __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_predefined_countries', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_predefined_countries', esc_html__( 'Set at least a country to be used for searches by "Near an address" and "Near a postcode"', 'listar' ), 'listar_search_by_predefined_countries_callback', 'listar_options', 'listar_options', $args1 );
			endif;

			/**
			 * Disable the "Explore By" tip
			 */

			$args2 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_tip __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_tip', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_tip', esc_html__( 'Disable the "Explore By" tip', 'listar' ), 'listar_disable_search_by_tip_callback', 'listar_options', 'listar_options', $args2 );

			/**
			 * Text for "Explore By" tip
			 */

			$args3 = array(
				'class' => 'listar_theme_options_field listar_search_by_tip_text __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_search_by_tip_text', $sanitize_callback_no_html );
			add_settings_field( 'listar_search_by_tip_text', esc_html__( 'Text for "Explore By" tip', 'listar' ), 'listar_search_by_tip_text_callback', 'listar_options', 'listar_options', $args3 );

			/**
			 * Background color for "Explore By" tip
			 */

			$args4 = array(
				'class' => 'listar_theme_options_field listar_background_color_search_by_tip __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_background_color_search_by_tip', $sanitize_callback_no_html );
			add_settings_field( 'listar_background_color_search_by_tip', esc_html__( 'Background color for "Explore By" tip', 'listar' ), 'listar_background_color_search_by_tip_callback', 'listar_options', 'listar_options', $args4 );

			/**
			 * Text color for "Explore By" tip
			 */

			$args5 = array(
				'class' => 'listar_theme_options_field listar_text_color_search_by_tip __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_text_color_search_by_tip', $sanitize_callback_no_html );
			add_settings_field( 'listar_text_color_search_by_tip', esc_html__( 'Text color for "Explore By" tip', 'listar' ), 'listar_text_color_search_by_tip_callback', 'listar_options', 'listar_options', $args5 );

			/**
			 * Disable the current "Explore By" title for the search input
			 */

			$args6 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_input_title __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_input_title', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_input_title', esc_html__( 'Disable the current "Explore By" title for the search input', 'listar' ), 'listar_disable_search_by_input_title_callback', 'listar_options', 'listar_options', $args6 );

			/**
			 * Description for "Default search" option inside the popup
			 */

			$args12 = array(
				'class' => 'listar_theme_options_field listar_search_by_default_description __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_search_by_default_description', $sanitize_callback_no_html );
			add_settings_field( 'listar_search_by_default_description', esc_html__( 'Description for "Default search" option inside the popup', 'listar' ), 'listar_search_by_default_description_callback', 'listar_options', 'listar_options', $args12 );

			/**
			 * Disable "Nearest me" as "Explore By" option
			 */

			$args9 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_nearest_me_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_nearest_me_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_nearest_me_option', esc_html__( 'Disable "Nearest me" as "Explore By" option', 'listar' ), 'listar_disable_search_by_nearest_me_option_callback', 'listar_options', 'listar_options', $args9 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_nearest_me_option' ) ) {

				/**
				 * Description for "Nearest me" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_nearest_me_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_nearest_me_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_nearest_me_description', esc_html__( 'Description for "Nearest me" option inside the popup', 'listar' ), 'listar_search_by_nearest_me_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Nearest me" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_nearest_me_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_nearest_me_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_nearest_me_placeholder', esc_html__( 'Custom placeholder text for search input field when "Nearest me" is selected', 'listar' ), 'listar_search_by_nearest_me_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}

			/**
			 * Disable "Only featured" as "Explore By" option
			 */
			
			/*

			$args10 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_featured_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_featured_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_featured_option', esc_html__( 'Disable "Only featured" as "Explore By" option', 'listar' ), 'listar_disable_search_by_featured_option_callback', 'listar_options', 'listar_options', $args10 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_featured_option' ) ) {

				/**
				 * Description for "Only featured" option inside the popup
				 */
			
				/*

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_featured_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_featured_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_featured_description', esc_html__( 'Description for "Only featured" option inside the popup', 'listar' ), 'listar_search_by_featured_description_callback', 'listar_options', 'listar_options', $args1 );
				*/

				/**
				 * Custom placeholder text for search input field when "Only featured" is selected
				 */

				/*
				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_featured_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_featured_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_featured_placeholder', esc_html__( 'Custom placeholder text for search input field when "Only featured" is selected', 'listar' ), 'listar_search_by_featured_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}
			*/

			/**
			 * Disable "Trending" as "Explore By" option
			 */

			register_setting(
				'listar_settings_group',
				'listar_disable_search_by_trending_option',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_disable_search_by_trending_option',
				esc_html__( 'Disable "Trending" as "Explore By" option', 'listar' ),
				'listar_disable_search_by_trending_option_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_disable_search_by_trending_option __edit-type-search',
				)
			);

			if ( 0 === (int) get_option( 'listar_disable_search_by_trending_option' ) ) {

				/**
				 * Description for "Trending" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_trending_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_trending_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_trending_description', esc_html__( 'Description for "Trending" option inside the popup', 'listar' ), 'listar_search_by_trending_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Trending" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_trending_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_trending_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_trending_placeholder', esc_html__( 'Custom placeholder text for search input field when "Trending" is selected', 'listar' ), 'listar_search_by_trending_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}
			
			if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) :

				/**
				 * Disable "Best rated" as "Explore By" option
				 */

				register_setting(
					'listar_settings_group',
					'listar_disable_search_by_best_rated_option',
					$sanitize_callback_int
				);

				add_settings_field(
					'listar_disable_search_by_best_rated_option',
					esc_html__( 'Disable "Best rated" as "Explore By" option', 'listar' ),
					'listar_disable_search_by_best_rated_option_callback',
					'listar_options',
					'listar_options',
					array(
						'class' => 'listar_theme_options_field listar_disable_search_by_best_rated_option __edit-type-search',
					)
				);

				if ( 0 === (int) get_option( 'listar_disable_search_by_best_rated_option' ) ) {

					/**
					 * Description for "Best rated" option inside the popup
					 */

					$args1 = array(
						'class' => 'listar_theme_options_field listar_search_by_best_rated_description __edit-type-search',
					);

					register_setting( 'listar_settings_group', 'listar_search_by_best_rated_description', $sanitize_callback_no_html );
					add_settings_field( 'listar_search_by_best_rated_description', esc_html__( 'Description for "Best rated" option inside the popup', 'listar' ), 'listar_search_by_best_rated_description_callback', 'listar_options', 'listar_options', $args1 );

					/**
					 * Custom placeholder text for search input field when "Best rated" is selected
					 */

					$args2 = array(
						'class' => 'listar_theme_options_field listar_search_by_best_rated_placeholder __edit-type-search',
					);

					register_setting( 'listar_settings_group', 'listar_search_by_best_rated_placeholder', $sanitize_callback_no_html );
					add_settings_field( 'listar_search_by_best_rated_placeholder', esc_html__( 'Custom placeholder text for search input field when "Best rated" is selected', 'listar' ), 'listar_search_by_best_rated_placeholder_callback', 'listar_options', 'listar_options', $args2 );
				}
			endif;

			/**
			 * Disable "Most viewed" as "Explore By" option
			 */

			register_setting(
				'listar_settings_group',
				'listar_disable_search_by_most_viewed_option',
				$sanitize_callback_int
			);
			
			add_settings_field(
				'listar_disable_search_by_most_viewed_option',
				esc_html__( 'Disable "Most viewed" as "Explore By" option', 'listar' ),
				'listar_disable_search_by_most_viewed_option_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_disable_search_by_most_viewed_option __edit-type-search',
				)
			);

			if ( 0 === (int) get_option( 'listar_disable_search_by_most_viewed_option' ) ) {

				/**
				 * Description for "Most viewed" option inside the popup
				 */

				$args94 = array(
					'class' => 'listar_theme_options_field listar_search_by_most_viewed_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_most_viewed_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_most_viewed_description', esc_html__( 'Description for "Most viewed" option inside the popup', 'listar' ), 'listar_search_by_most_viewed_description_callback', 'listar_options', 'listar_options', $args94 );

				/**
				 * Custom placeholder text for search input field when "Most viewed" is selected
				 */

				$args95 = array(
					'class' => 'listar_theme_options_field listar_search_by_most_viewed_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_most_viewed_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_most_viewed_placeholder', esc_html__( 'Custom placeholder text for search input field when "Most viewed" is selected', 'listar' ), 'listar_search_by_most_viewed_placeholder_callback', 'listar_options', 'listar_options', $args95 );
			}

			$bookmarks_active = listar_bookmarks_active();

			if ( $bookmarks_active ) :

				/**
				 * Disable "Most bookmarked" as "Explore By" option
				 */

				$args101 = array(
					'class' => 'listar_theme_options_field listar_disable_search_by_most_bookmarked_option __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_disable_search_by_most_bookmarked_option', $sanitize_callback_int );
				add_settings_field( 'listar_disable_search_by_most_bookmarked_option', esc_html__( 'Disable "Most bookmarked" as "Explore By" option', 'listar' ), 'listar_disable_search_by_most_bookmarked_option_callback', 'listar_options', 'listar_options', $args101 );

				if ( 0 === (int) get_option( 'listar_disable_search_by_most_bookmarked_option' ) ) {

					/**
					 * Description for "Most bookmarked" option inside the popup
					 */

					$args102 = array(
						'class' => 'listar_theme_options_field listar_search_by_most_bookmarked_description __edit-type-search',
					);

					register_setting( 'listar_settings_group', 'listar_search_by_most_bookmarked_description', $sanitize_callback_no_html );
					add_settings_field( 'listar_search_by_most_bookmarked_description', esc_html__( 'Description for "Most bookmarked" option inside the popup', 'listar' ), 'listar_search_by_most_bookmarked_description_callback', 'listar_options', 'listar_options', $args102 );

					/**
					 * Custom placeholder text for search input field when "Most bookmarked" is selected
					 */

					$args103 = array(
						'class' => 'listar_theme_options_field listar_search_by_most_bookmarked_placeholder __edit-type-search',
					);

					register_setting( 'listar_settings_group', 'listar_search_by_most_bookmarked_placeholder', $sanitize_callback_no_html );
					add_settings_field( 'listar_search_by_most_bookmarked_placeholder', esc_html__( 'Custom placeholder text for search input field when "Most bookmarked" is selected', 'listar' ), 'listar_search_by_most_bookmarked_placeholder_callback', 'listar_options', 'listar_options', $args103 );
				}
			endif;
			

			/**
			 * Disable "Near an address" as "Explore By" option
			 */

			$args13 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_near_address_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_near_address_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_near_address_option', esc_html__( 'Disable "Near an address" as "Explore By" option', 'listar' ), 'listar_disable_search_by_near_address_option_callback', 'listar_options', 'listar_options', $args13 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_near_address_option' ) ) {

				/**
				 * Description for "Near an address" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_near_address_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_near_address_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_near_address_description', esc_html__( 'Description for "Near an address" option inside the popup', 'listar' ), 'listar_search_by_near_address_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Near an address" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_near_address_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_near_address_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_near_address_placeholder', esc_html__( 'Custom placeholder text for search input field when "Near an address" is selected', 'listar' ), 'listar_search_by_near_address_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}

			/**
			 * Disable "Near a postcode" as "Explore By" option
			 */

			$args14 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_near_postcode_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_near_postcode_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_near_postcode_option', esc_html__( 'Disable "Near a postcode" as "Explore By" option', 'listar' ), 'listar_disable_search_by_near_postcode_option_callback', 'listar_options', 'listar_options', $args14 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_near_postcode_option' ) ) {

				/**
				 * Description for "Near a postcode" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_near_postcode_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_near_postcode_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_near_postcode_description', esc_html__( 'Description for "Near a postcode" option inside the popup', 'listar' ), 'listar_search_by_near_postcode_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Near a postcode" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_near_postcode_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_near_postcode_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_near_postcode_placeholder', esc_html__( 'Custom placeholder text for search input field when "Near a postcode" is selected', 'listar' ), 'listar_search_by_near_postcode_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}

			/**
			 * Disable "Surprise me" as "Explore By" option
			 */

			$args15 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_surprise_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_surprise_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_surprise_option', esc_html__( 'Disable "Surprise me" (random) as "Explore By" option', 'listar' ), 'listar_disable_search_by_surprise_option_callback', 'listar_options', 'listar_options', $args15 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_surprise_option' ) ) {

				/**
				 * Description for "Surprise me" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_surprise_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_surprise_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_surprise_description', esc_html__( 'Description for "Surprise me" (random) option inside the popup', 'listar' ), 'listar_search_by_surprise_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Surprise me" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_surprise_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_surprise_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_surprise_placeholder', esc_html__( 'Custom placeholder text for search input field when "Surprise me" (random) is selected', 'listar' ), 'listar_search_by_surprise_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}

			/**
			 * Disable "Shop" as "Explore By" option
			 */

			$args106 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_shop_products_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_shop_products_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_shop_products_option', esc_html__( 'Disable "Shop" as "Explore By" option', 'listar' ), 'listar_disable_search_by_shop_products_option_callback', 'listar_options', 'listar_options', $args106 );

			if ( 0 === (int) get_option( 'listar_disable_search_by_shop_products_option' ) ) {

				/**
				 * Description for "Shop" option inside the popup
				 */

				$args107 = array(
					'class' => 'listar_theme_options_field listar_search_by_shop_products_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_shop_products_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_shop_products_description', esc_html__( 'Description for "Shop" option inside the popup', 'listar' ), 'listar_search_by_shop_products_description_callback', 'listar_options', 'listar_options', $args107 );

				/**
				 * Custom placeholder text for search input field when "Shop" is selected
				 */

				$args108 = array(
					'class' => 'listar_theme_options_field listar_search_by_shop_products_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_shop_products_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_shop_products_placeholder', esc_html__( 'Custom placeholder text for search input field when "Shop" is selected', 'listar' ), 'listar_search_by_shop_products_placeholder_callback', 'listar_options', 'listar_options', $args108 );
			}

			/**
			 * Disable "Blog articles" as "Explore By" option
			 */

			$args16 = array(
				'class' => 'listar_theme_options_field listar_disable_search_by_blog_option __edit-type-search',
			);

			register_setting( 'listar_settings_group', 'listar_disable_search_by_blog_option', $sanitize_callback_int );
			add_settings_field( 'listar_disable_search_by_blog_option', esc_html__( 'Disable "Blog articles" as "Explore By" option', 'listar' ), 'listar_disable_search_by_blog_option_callback', 'listar_options', 'listar_options', $args16 );
			
			if ( 0 === (int) get_option( 'listar_disable_search_by_blog_option' ) ) {

				/**
				 * Description for "Blog articles" option inside the popup
				 */

				$args1 = array(
					'class' => 'listar_theme_options_field listar_search_by_blog_description __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_blog_description', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_blog_description', esc_html__( 'Description for "Blog articles" option inside the popup', 'listar' ), 'listar_search_by_blog_description_callback', 'listar_options', 'listar_options', $args1 );

				/**
				 * Custom placeholder text for search input field when "Blog articles" is selected
				 */

				$args2 = array(
					'class' => 'listar_theme_options_field listar_search_by_blog_placeholder __edit-type-search',
				);

				register_setting( 'listar_settings_group', 'listar_search_by_blog_placeholder', $sanitize_callback_no_html );
				add_settings_field( 'listar_search_by_blog_placeholder', esc_html__( 'Custom placeholder text for search input field when "Blog articles" is selected', 'listar' ), 'listar_search_by_blog_placeholder_callback', 'listar_options', 'listar_options', $args2 );
			}
		}

		/**
		 * Sidebar position on single listing pages
		 */

		$args30 = array(
			'class' => 'listar_theme_options_field listar_listing_sidebar_position  __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_listing_sidebar_position', $sanitize_callback_no_html );
		add_settings_field( 'listar_listing_sidebar_position', esc_html__( 'Sidebar position on single listing pages', 'listar' ), 'listar_listing_sidebar_position_callback', 'listar_options', 'listar_options', $args30 );

		/**
		 * Position for front page hero content
		 */

		$args40 = array(
			'class' => 'listar_theme_options_field listar_hero_content_position  __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_hero_content_position', $sanitize_callback_no_html );
		add_settings_field( 'listar_hero_content_position', esc_html__( 'Position for front page hero content', 'listar' ), 'listar_hero_content_position_callback', 'listar_options', 'listar_options', $args40 );
		
		/**
		 * Position for search popup content
		 */

		$args41 = array(
			'class' => 'listar_theme_options_field listar_search_popup_content_position  __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_search_popup_content_position', $sanitize_callback_no_html );
		add_settings_field( 'listar_search_popup_content_position', esc_html__( 'Position for search popup content', 'listar' ), 'listar_search_popup_content_position_callback', 'listar_options', 'listar_options', $args41 );

		/**
		 * Enable expansive excerpt when hovering listing and blog cards
		 */

		$args19 = array(
			'class' => 'listar_theme_options_field listar_enable_expansive_excerpt __edit-effects',
		);

		register_setting( 'listar_settings_group', 'listar_enable_expansive_excerpt', $sanitize_callback_int );
		add_settings_field( 'listar_enable_expansive_excerpt', esc_html__( 'Expand excerpt when hovering listing and blog cards', 'listar' ), 'listar_enable_expansive_excerpt_callback', 'listar_options', 'listar_options', $args19 );

		if ( taxonomy_exists( 'job_listing_category' ) ) {
			/**
			 * Disable 3D hover animations for listing category blocks
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_disable_listing_category_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_listing_category_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_listing_category_hover_animation', esc_html__( 'Disable 3D hover animations for listing category blocks', 'listar' ), 'listar_disable_listing_category_hover_animation_callback', 'listar_options', 'listar_options', $args1 );
			
			/**
			 * Force big for listing category blocks
			 */

			$args3 = array(
				'class' => 'listar_theme_options_field listar_force_big_text_category __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_force_big_text_category', $sanitize_callback_int );
			add_settings_field( 'listar_force_big_text_category', esc_html__( 'Force big for listing category blocks', 'listar' ), 'listar_force_big_text_category_callback', 'listar_options', 'listar_options', $args3 );

			/**
			 * Force big for listing region blocks
			 */

			$args4 = array(
				'class' => 'listar_theme_options_field listar_force_big_text_region __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_force_big_text_region', $sanitize_callback_int );
			add_settings_field( 'listar_force_big_text_region', esc_html__( 'Force big for listing region blocks', 'listar' ), 'listar_force_big_text_region_callback', 'listar_options', 'listar_options', $args4 );
			
			/**
			 * Disable big text when hovering listing category blocks
			 */

			$args2 = array(
				'class' => 'listar_theme_options_field listar_disable_big_text_category_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_big_text_category_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_big_text_category_hover_animation', esc_html__( 'Disable big text when hovering listing category blocks', 'listar' ), 'listar_disable_big_text_category_hover_animation_callback', 'listar_options', 'listar_options', $args2 );
		}

		if ( taxonomy_exists( 'job_listing_category' ) ) {
			/**
			 * Disable 3D hover animations for listing category blocks
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_disable_listing_category_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_listing_category_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_listing_category_hover_animation', esc_html__( 'Disable 3D hover animations for listing category blocks', 'listar' ), 'listar_disable_listing_category_hover_animation_callback', 'listar_options', 'listar_options', $args1 );

			/**
			 * Disable big text when hovering listing region blocks
			 */

			$args2 = array(
				'class' => 'listar_theme_options_field listar_disable_big_text_region_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_big_text_region_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_big_text_region_hover_animation', esc_html__( 'Disable big text when hovering listing region blocks', 'listar' ), 'listar_disable_big_text_region_hover_animation_callback', 'listar_options', 'listar_options', $args2 );
		}

		if ( taxonomy_exists( 'job_listing_region' ) ) {
			/**
			 * Disable 3D hover animations for listing region blocks
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_disable_listing_region_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_listing_region_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_listing_region_hover_animation', esc_html__( 'Disable 3D hover animations for listing region blocks', 'listar' ), 'listar_disable_listing_region_hover_animation_callback', 'listar_options', 'listar_options', $args1 );
		}

		if ( taxonomy_exists( 'job_listing_amenity' ) ) {
			/**
			 * Disable hover animations for listing amenity blocks
			 */

			$args19 = array(
				'class' => 'listar_theme_options_field listar_disable_listing_amenity_hover_animation __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_disable_listing_amenity_hover_animation', $sanitize_callback_int );
			add_settings_field( 'listar_disable_listing_amenity_hover_animation', esc_html__( 'Disable hover animations for listing amenity blocks', 'listar' ), 'listar_disable_listing_amenity_hover_animation_callback', 'listar_options', 'listar_options', $args19 );
		}
		
		/**
		 * Disable hover opacity for all sibling blocks
		 */

		$args34 = array(
			'class' => 'listar_theme_options_field listar_disable_sibling_hover_opacity __edit-effects',
		);

		register_setting( 'listar_settings_group', 'listar_disable_sibling_hover_opacity', $sanitize_callback_int );
		add_settings_field( 'listar_disable_sibling_hover_opacity', esc_html__( 'Disable hover opacity for all sibling blocks', 'listar' ), 'listar_disable_sibling_hover_opacity_callback', 'listar_options', 'listar_options', $args34 );

		if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {
			
			/**
			 * Animate the "Explore By" tip
			 */

			$args1 = array(
				'class' => 'listar_theme_options_field listar_animate_search_by_tip __edit-effects',
			);

			register_setting( 'listar_settings_group', 'listar_animate_search_by_tip', $sanitize_callback_int );
			add_settings_field( 'listar_animate_search_by_tip', esc_html__( 'Animate the "Explore By" tip', 'listar' ), 'listar_animate_search_by_tip_callback', 'listar_options', 'listar_options', $args1 );
		}

		/**
		 * Background color for detail row when hovering listing cards (requires expanded excerpt activation)
		 */

		$args28 = array(
			'class' => 'listar_theme_options_field listar_card_detail_row_design  __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_card_detail_row_design', $sanitize_callback_no_html );
		add_settings_field( 'listar_card_detail_row_design', esc_html__( 'Background color for detail row when hovering listing cards (requires expanded excerpt activation)', 'listar' ), 'listar_card_detail_row_design_callback', 'listar_options', 'listar_options', $args28 );

	} // End if().

	/**
	* Blog *****************************************************************
	*/

	/**
	 * Grid design for blog archive
	 */

	$args10 = array(
		'class' => 'listar_theme_options_field listar_blog_grid_design __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_blog_grid_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_blog_grid_design', esc_html__( 'Grid design for blog archive', 'listar' ), 'listar_blog_grid_design_callback', 'listar_options', 'listar_options', $args10 );

	if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {
	
		/*
		 * Permalinks *******************************************************
		 */

		/**
		 * Custom "listing" slug
		 */

		register_setting(
			'listar_settings_group',
			'listar_custom_listing_slug',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_custom_listing_slug',
			esc_html__( 'Custom "listing" slug', 'listar' ),
			'listar_custom_listing_slug_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_custom_listing_slug __permalinks',
			)
		);

		/**
		 * Append listing id to the permalink
		 */

		register_setting(
			'listar_settings_group',
			'listar_listing_id_slug_permalink',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_listing_id_slug_permalink',
			esc_html__( 'Append listing id to the permalink', 'listar' ),
			'listar_listing_id_slug_permalink_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_listing_id_slug_permalink __permalinks',
			)
		);

		/**
		 * Append region slug to the listing permalink
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_region_slug_permalink',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_use_region_slug_permalink',
			esc_html__( 'Append region slug to the listing permalink', 'listar' ),
			'listar_use_region_slug_permalink_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_region_slug_permalink __permalinks',
			)
		);

		/**
		 * Slug for listings without a region set
		 */

		register_setting(
			'listar_settings_group',
			'listar_absent_region_slug_permalink',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_absent_region_slug_permalink',
			esc_html__( 'Slug for listings without a region set', 'listar' ),
			'listar_absent_region_slug_permalink_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_absent_region_slug_permalink __permalinks',
			)
		);

		/**
		 * Append category slug to the listing permalink
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_category_slug_permalink',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_use_category_slug_permalink',
			esc_html__( 'Append category slug to the listing permalink', 'listar' ),
			'listar_use_category_slug_permalink_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_category_slug_permalink __permalinks',
			)
		);

		/**
		 * Slug for listings without a category set
		 */

		register_setting(
			'listar_settings_group',
			'listar_absent_category_slug_permalink',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_absent_category_slug_permalink',
			esc_html__( 'Slug for listings without a category set', 'listar' ),
			'listar_absent_category_slug_permalink_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_absent_category_slug_permalink __permalinks',
			)
		);
	}
	
	/*
	 * Miscellaneous *******************************************************
	 */

	 

	/**
	 * Disable the login button on top bar
	 */

	register_setting(
		'listar_settings_group',
		'listar_accept_signup_terms_enabled',
		$sanitize_callback_int
	);

	add_settings_field(
		'listar_accept_signup_terms_enabled',
		esc_html__( 'Show "Accept Terms" checkbox on Sign Up form', 'listar' ),
		'listar_accept_signup_terms_enabled_callback',
		'listar_options',
		'listar_options',
		array( 'class' => 'listar_theme_options_field listar_accept_signup_terms_enabled __miscellaneous' )
	);

	/**
	 * Sign Up Terms and Conditions URL
	 */

	register_setting(
		'listar_settings_group',
		'listar_signup_terms_url',
		$sanitize_callback_esc_url
	);

	add_settings_field(
		'listar_signup_terms_url',
		esc_html__( 'Sign Up Terms and Conditions URL', 'listar' ),
		'listar_signup_terms_url_callback',
		'listar_options',
		'listar_options',
		array( 'class' => 'listar_theme_options_field listar_signup_terms_url __miscellaneous' )
	);

	/**
	 * Disable built in Google Fonts manager
	 */

	$args15 = array(
		'class' => 'listar_theme_options_field listar_disable_google_fonts __miscellaneous',
	);

	register_setting( 'listar_settings_group', 'listar_disable_google_fonts', $sanitize_callback_int );
	add_settings_field( 'listar_disable_google_fonts', esc_html__( 'Disable built in Google Fonts manager', 'listar' ), 'listar_disable_google_fonts_callback', 'listar_options', 'listar_options', $args15 );
	
	/**
	 * Enable "Back to Top" button for mobiles
	 */

	$args44 = array(
		'class' => 'listar_theme_options_field listar_enable_back_to_top_mobile __miscellaneous',
	);

	register_setting( 'listar_settings_group', 'listar_enable_back_to_top_mobile', $sanitize_callback_int );
	add_settings_field( 'listar_enable_back_to_top_mobile', esc_html__( 'Enable "Back to Top" button for mobiles', 'listar' ), 'listar_enable_back_to_top_mobile_callback', 'listar_options', 'listar_options', $args44 );
	
	/**
	 * Disable loading overlay
	 */

	$args45 = array(
		'class' => 'listar_theme_options_field listar_disable_loading_overlay __miscellaneous',
	);

	register_setting( 'listar_settings_group', 'listar_disable_loading_overlay', $sanitize_callback_int );
	add_settings_field( 'listar_disable_loading_overlay', esc_html__( 'Disable loading overlay', 'listar' ), 'listar_disable_loading_overlay_callback', 'listar_options', 'listar_options', $args45 );

	/**
	 * Customize currency
	 */

	$args61 = array(
		'class' => 'listar_theme_options_field listar_site_currency __edit-shopping',
	);

	register_setting( 'listar_settings_group', 'listar_site_currency', $sanitize_callback_no_html );
	add_settings_field( 'listar_site_currency', esc_html__( 'Customize currency', 'listar' ), 'listar_site_currency_callback', 'listar_options', 'listar_options', $args61 );
	
	if ( class_exists( 'Woocommerce' ) ) {

		if ( post_type_exists( 'job_listing' ) ) {
		
			/**
			 * Don't publish/renew listings automatically after an order is paid
			 */
			
			/*
			 * For further analysis, because this built-in combination does the job:
			 * 
			 * - Go to Listings / Settings and disable “Moderate New Listings”
			 * - Go to Products and edit your Listing Subscription packages. For “Subscription Type”, please select the second option: “Link the subscription to posted listings (renew posted listings every subscription term)”.
			 */
			
			/*

			register_setting(
				'listar_settings_group',
				'listar_deny_publish_listings_after_paid_order',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_deny_publish_listings_after_paid_order',
				esc_html__( 'Do not publish/renew listings automatically after an order is paid', 'listar' ),
				'listar_deny_publish_listings_after_paid_order_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_deny_publish_listings_after_paid_order __edit-shopping',
				)
			);

			*/
		
			/**
			 * Don't publish/renew listings after a subscription package be activated or renewed
			 */
			
			/*
			 * For further analysis, because this built-in combination does the job:
			 * 
			 * - Go to Listings / Settings and disable “Moderate New Listings”
			 * - Go to Products and edit your Listing Subscription packages. For “Subscription Type”, please select the second option: “Link the subscription to posted listings (renew posted listings every subscription term)”.
			 */
			
			/*

			register_setting(
				'listar_settings_group',
				'listar_deny_publish_listings_after_paid_subscription',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_deny_publish_listings_after_paid_subscription',
				esc_html__( 'Do not publish/renew listings automatically after an order is paid', 'listar' ),
				'listar_deny_publish_listings_after_paid_subscription_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_deny_publish_listings_after_paid_subscription __edit-shopping',
				)
			);
			
			*/
		}

		/**
		 * Shop archive sidebar
		 */

		register_setting(
			'listar_settings_group',
			'listar_enable_woo_archive_sidebar',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_enable_woo_archive_sidebar',
			esc_html__( 'Shop archive sidebar', 'listar' ),
			'listar_enable_woo_archive_sidebar_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_enable_woo_archive_sidebar __edit-shopping',
			)
		);

		/**
		 * Shop product sidebar
		 */

		register_setting(
			'listar_settings_group',
			'listar_enable_woo_product_sidebar',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_enable_woo_product_sidebar',
			esc_html__( 'Shop product sidebar', 'listar' ),
			'listar_enable_woo_product_sidebar_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_enable_woo_product_sidebar __edit-shopping',
			)
		);

		/**
		 * Enable Woocommerce "Downloads" menu from User Dashboard screen.
		 */

		register_setting(
			'listar_settings_group',
			'listar_enable_woo_downloads_menu',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_enable_woo_downloads_menu',
			esc_html__( 'Enable Woocommerce "Downloads" menu from User Dashboard screen', 'listar' ),
			'listar_enable_woo_downloads_menu_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_enable_woo_downloads_menu __edit-shopping',
			)
		);

		/**
		 * Disable shopping breadcrumbs
		 */

		register_setting(
			'listar_settings_group',
			'listar_disable_shopping_breadcrumbs',
			$sanitize_callback_int
		);

		add_settings_field(
			'listar_disable_shopping_breadcrumbs',
			esc_html__( 'Disable shopping breadcrumbs', 'listar' ),
			'listar_disable_shopping_breadcrumbs_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_disable_shopping_breadcrumbs __edit-shopping',
			)
		);
		
		if ( listar_is_wcfm_active() && listar_is_wcfmmp_active() ) :

			/**
			 * Marketplace Setup Wizard
			 */

			register_setting(
				'listar_settings_group',
				'listar_marketplace_setup_wizard',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_marketplace_setup_wizard',
				esc_html__( 'Marketplace Setup Wizard', 'listar' ),
				'listar_marketplace_setup_wizard_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_marketplace_setup_wizard __edit-marketplace',
				)
			);

			/**
			 * Marketplace Dashboard
			 */

			register_setting(
				'listar_settings_group',
				'listar_marketplace_dashboard',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_marketplace_dashboard',
				esc_html__( 'Marketplace Dashboard', 'listar' ),
				'listar_marketplace_dashboard_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_marketplace_dashboard __edit-marketplace',
				)
			);

			/**
			 * Marketplace Settings
			 */

			register_setting(
				'listar_settings_group',
				'listar_marketplace_settings',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_marketplace_settings',
				esc_html__( 'Marketplace Settings', 'listar' ),
				'listar_marketplace_settings_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_marketplace_settings __edit-marketplace',
				)
			);

			/**
			 * Who can create an online store?
			 */

			register_setting(
				'listar_settings_group',
				'listar_who_can_create_stores',
				$sanitize_callback_no_html
			);

			add_settings_field(
				'listar_who_can_create_stores',
				esc_html__( 'Who can create an online store?', 'listar' ),
				'listar_who_can_create_stores_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_who_can_create_stores __edit-marketplace',
				)
			);

			/**
			 * Max products per vendor
			 */

			register_setting(
				'listar_settings_group',
				'listar_limit_products_per_vendor',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_limit_products_per_vendor',
				esc_html__( 'Max products per vendor', 'listar' ),
				'listar_limit_products_per_vendor_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_limit_products_per_vendor __edit-marketplace',
				)
			);

			/**
			 * Max disk space per vendor
			 */

			register_setting(
				'listar_settings_group',
				'listar_limit_disk_per_vendor',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_limit_disk_per_vendor',
				esc_html__( 'Max disk space per vendor', 'listar' ),
				'listar_limit_disk_per_vendor_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_limit_disk_per_vendor __edit-marketplace',
				)
			);

			/**
			 * Allow only products of the same vendor in the cart
			 */

			register_setting(
				'listar_settings_group',
				'listar_restrict_cart_per_vendor',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_restrict_cart_per_vendor',
				esc_html__( 'Allow only products of the same vendor in the cart', 'listar' ),
				'listar_restrict_cart_per_vendor_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_restrict_cart_per_vendor __edit-marketplace',
				)
			);

			/**
			 * Allow only one product in the cart
			 */

			register_setting(
				'listar_settings_group',
				'listar_restrict_cart_per_product',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_restrict_cart_per_product',
				esc_html__( 'Allow only one product in the cart', 'listar' ),
				'listar_restrict_cart_per_product_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_restrict_cart_per_product __edit-marketplace',
				)
			);

			/**
			 * Reset the cart when a product be added
			 */

			register_setting(
				'listar_settings_group',
				'listar_restrict_empty_cart_per_product',
				$sanitize_callback_int
			);

			add_settings_field(
				'listar_restrict_empty_cart_per_product',
				esc_html__( 'Reset the cart when a product be added', 'listar' ),
				'listar_restrict_empty_cart_per_product_callback',
				'listar_options',
				'listar_options',
				array(
					'class' => 'listar_theme_options_field listar_restrict_empty_cart_per_product __edit-marketplace',
				)
			);
		endif;
	}

	/**
	 * First screen for icon selector
	 */

	register_setting(
		'listar_settings_group',
		'listar_first_screen_icon_selector',
		$sanitize_callback_no_html
	);
	
	add_settings_field(
		'listar_first_screen_icon_selector',
		esc_html__( 'First screen for icon selector', 'listar' ),
		'listar_first_screen_icon_selector_callback',
		'listar_options',
		'listar_options',
		array(
			'class' => 'listar_theme_options_field listar_first_screen_icon_selector  __miscellaneous',
		)
	);
	
	if ( post_type_exists( 'job_listing' ) && listar_addons_active() ) {

		/**
		 * On front end listing submission form, enable Text editor (code) for the description field
		 */

		register_setting(
			'listar_settings_group',
			'listar_use_code_editor_frontend',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_use_code_editor_frontend',
			esc_html__( 'On front end listing submission form, enable the Text editor (code) for the description field', 'listar' ),
			'listar_use_code_editor_frontend_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_use_code_editor_frontend  __miscellaneous',
			)
		);
	}
	
	if ( class_exists( 'AsyncJavaScriptBackend' ) ) {

		/**
		 * Show Async JavaScript plugin settings
		 */

		register_setting(
			'listar_settings_group',
			'listar_show_async_plugin_settings',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_show_async_plugin_settings',
			esc_html__( 'Show Async JavaScript plugin settings', 'listar' ),
			'listar_show_async_plugin_settings_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_show_async_plugin_settings  __miscellaneous',
			)
		);
	}
	
	if ( class_exists( 'autoptimizeCache' ) ) {

		/**
		 * Show Autoptimize plugin settings
		 */

		register_setting(
			'listar_settings_group',
			'listar_show_autoptimize_plugin_settings',
			$sanitize_callback_no_html
		);

		add_settings_field(
			'listar_show_autoptimize_plugin_settings',
			esc_html__( 'Show Autoptimize plugin settings', 'listar' ),
			'listar_show_autoptimize_plugin_settings_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_show_autoptimize_plugin_settings  __miscellaneous',
			)
		);
	}

	/**
	 * Color pattern for stripes
	 */

	$args12 = array(
		'class' => 'listar_theme_options_field listar_color_stripes  __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_color_stripes', $sanitize_callback_no_html );
	add_settings_field( 'listar_color_stripes', esc_html__( 'Color pattern for stripes', 'listar' ), 'listar_color_stripes_callback', 'listar_options', 'listar_options', $args12 );

	/**
	 * Background color for search button on top bar
	 */

	$args18 = array(
		'class' => 'listar_theme_options_field listar_background_color_search_button_top  __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_background_color_search_button_top', $sanitize_callback_no_html );
	add_settings_field( 'listar_background_color_search_button_top', esc_html__( 'Background color for search button on top bar', 'listar' ), 'listar_background_color_search_button_top_callback', 'listar_options', 'listar_options', $args18 );

	/**
	 * Background color for login button on top bar
	 */

	$args29 = array(
		'class' => 'listar_theme_options_field listar_background_color_login_button_top  __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_background_color_login_button_top', $sanitize_callback_no_html );
	add_settings_field( 'listar_background_color_login_button_top', esc_html__( 'Background color for login button on top bar', 'listar' ), 'listar_background_color_login_button_top_callback', 'listar_options', 'listar_options', $args29 );

	if ( post_type_exists( 'job_listing' ) ) {
		/**
		 * Background color for Add Listing button on top bar
		 */

		$args29 = array(
			'class' => 'listar_theme_options_field listar_background_color_add_listing_button_top  __edit-design',
		);

		register_setting( 'listar_settings_group', 'listar_background_color_add_listing_button_top', $sanitize_callback_no_html );
		add_settings_field( 'listar_background_color_add_listing_button_top', esc_html__( 'Background color for Add Listing button on top bar', 'listar' ), 'listar_background_color_add_listing_button_top_callback', 'listar_options', 'listar_options', $args29 );
		
		/**
		 * Design for trending icon
		 */

		register_setting(
			'listar_settings_group',
			'listar_trending_icon_design',
			$sanitize_callback_no_html
		);
		
		add_settings_field(
			'listar_trending_icon_design',
			esc_html__( 'Design for trending icon', 'listar' ),
			'listar_trending_icon_design_callback',
			'listar_options',
			'listar_options',
			array(
				'class' => 'listar_theme_options_field listar_trending_icon_design  __edit-design',
			)
		);
	}

	/**
	 * Drop down menu design
	 */

	$args13 = array(
		'class' => 'listar_theme_options_field listar_drop_dowm_menu_design  __edit-design',
	);

	register_setting( 'listar_settings_group', 'listar_drop_dowm_menu_design', $sanitize_callback_no_html );
	add_settings_field( 'listar_drop_dowm_menu_design', esc_html__( 'Design for drop down menu', 'listar' ), 'listar_drop_dowm_menu_design_callback', 'listar_options', 'listar_options', $args13 );

	/**
	 * Footer **************************************************************
	 */

	/**
	 * Footer column 1
	 */

	$args7 = array(
		'class' => 'listar_theme_options_field listar_footer_column_1 __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_column_1', $sanitize_callback_int );
	add_settings_field( 'listar_footer_column_1', esc_html__( 'Footer widget area, column', 'listar' ) . ' - 1', 'listar_footer_column_1_callback', 'listar_options', 'listar_options', $args7 );

	/**
	 * Footer column 2
	 */

	$args8 = array(
		'class' => 'listar_theme_options_field listar_footer_column_2 __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_column_2', $sanitize_callback_int );
	add_settings_field( 'listar_footer_column_2', esc_html__( 'Footer widget area, column', 'listar' ) . ' - 2', 'listar_footer_column_2_callback', 'listar_options', 'listar_options', $args8 );

	/**
	 * Footer column 3
	 */

	$args9 = array(
		'class' => 'listar_theme_options_field listar_footer_column_3 __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_column_3', $sanitize_callback_int );
	add_settings_field( 'listar_footer_column_3', esc_html__( 'Footer widget area, column', 'listar' ) . ' - 3', 'listar_footer_column_3_callback', 'listar_options', 'listar_options', $args9 );

	/**
	 * Footer column 4
	 */

	$args35 = array(
		'class' => 'listar_theme_options_field listar_footer_column_4 __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_column_4', $sanitize_callback_int );
	add_settings_field( 'listar_footer_column_4', esc_html__( 'Footer widget area, column', 'listar' ) . ' - 4', 'listar_footer_column_4_callback', 'listar_options', 'listar_options', $args35 );

	/**
	 * Footer company info
	 */

	$args20 = array(
		'class' => 'listar_theme_options_field listar_footer_company_info __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_company_info', $sanitize_callback_kses_post );
	add_settings_field( 'listar_footer_company_info', esc_html__( 'Footer company info', 'listar' ), 'listar_footer_company_info_callback', 'listar_options', 'listar_options', $args20 );

	/**
	 * Footer company info - Site name
	 */

	$args21 = array(
		'class' => 'listar_theme_options_field listar_footer_company_site_name __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_company_site_name', $sanitize_callback_kses_post );
	add_settings_field( 'listar_footer_company_site_name', esc_html__( 'Company site name', 'listar' ), 'listar_footer_company_site_name_callback', 'listar_options', 'listar_options', $args21 );

	/**
	 * Footer company info - Website
	 */

	$args22 = array(
		'class' => 'listar_theme_options_field listar_footer_company_site_url __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_footer_company_site_url', $sanitize_callback_esc_url );
	add_settings_field( 'listar_footer_company_site_url', esc_html__( 'Company website', 'listar' ), 'listar_footer_company_site_url_callback', 'listar_options', 'listar_options', $args22 );

	/**
	 * Footer copyright
	 */

	$args5 = array(
		'class' => 'listar_theme_options_field listar_copyright __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_copyright', $sanitize_callback_kses_post );
	add_settings_field( 'listar_copyright', esc_html__( 'Copyright project/text', 'listar' ), 'listar_copyright_callback', 'listar_options', 'listar_options', $args5 );

	/**
	 * Footer copyright - Copyright owner
	 */

	$args6 = array(
		'class' => 'listar_theme_options_field listar_copyright_owner __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_copyright_owner', $sanitize_callback_kses_post );
	add_settings_field( 'listar_copyright_owner', esc_html__( 'Copyright owner', 'listar' ), 'listar_copyright_owner_callback', 'listar_options', 'listar_options', $args6 );

	/**
	 * Footer copyright - Copyright owner URL
	 */

	$args19 = array(
		'class' => 'listar_theme_options_field listar_copyright_owner_url __edit-footer',
	);

	register_setting( 'listar_settings_group', 'listar_copyright_owner_url', $sanitize_callback_esc_url );
	add_settings_field( 'listar_copyright_owner_url', esc_html__( 'Copyright URL', 'listar' ), 'listar_copyright_owner_url_callback', 'listar_options', 'listar_options', $args19 );
	
	/*
	 * Execute after all options has been saved
	 */

	$args79 = array(
		'class' => 'listar_theme_options_field listar_execute_after_save_options hidden',
	);

	register_setting( 'listar_settings_group', 'listar_execute_after_save_options', $sanitize_callback_no_html );
	add_settings_field( 'listar_execute_after_save_options', '', 'listar_execute_after_save_options_callback', 'listar_options', 'listar_options', $args79 );		

	/**
	 * Export theme options (migration) ************************************
	 */
	
	$current_site_url = network_site_url();
	
	if ( false !== strpos( $current_site_url, 'localhost/wordpress' ) || false !== strpos( $current_site_url, 'wt.ax' ) || false !== strpos( $current_site_url, 'listar.directory' ) ) :
		/**
		 * Import or Export taxonomy icons and colors
		 */
		add_settings_field( 'listar_import_export_tax_icons', esc_html__( 'Import or Export all taxonomy icons and colors', 'listar' ), 'listar_import_export_tax_icons_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field listar_import_export_tax_icons __edit-export' ) );

		/**
		 * Import or Export hero search categories
		 */
		add_settings_field( 'listar_import_export_hero_search_cats', esc_html__( 'Import or Export hero search categories', 'listar' ), 'listar_import_export_hero_search_cats_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field listar_import_export_hero_search_cats __edit-export' ) );

		/**
		 * Import or Export taxonomy images
		 */
		add_settings_field( 'listar_import_export_taxonomy_images', esc_html__( 'Import or Export taxonomy images', 'listar' ), 'listar_import_export_taxonomy_images_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field listar_import_export_taxonomy_images __edit-export' ) );

		/**
		 * Import or Export ratig stars
		 */
		add_settings_field( 'listar_import_export_rating_stars', esc_html__( 'Import or Export rating stars', 'listar' ), 'listar_import_export_rating_stars_callback', 'listar_options', 'listar_options', array( 'class' => 'listar_theme_options_field listar_import_export_rating_stars __edit-export' ) );
	endif;
}

<?php
/**
 * Custom widgets
 *
 * @package Listar_Addons
 */

add_action( 'widgets_init', 'listar_widgets', 50 );

if ( ! function_exists( 'listar_widgets' ) ) :
	/**
	 * Setup custom widgets.
	 *
	 * @since 1.0
	 */
	function listar_widgets() {

		/* Features (highlights) Widget */
		require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-features-widget.php';

		/* Call To Action Widget */
		require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-call-to-action-widget.php';

		/* Blog Posts Widget */
		require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-blog-posts-widget.php';

		/* Partners Widget */
		require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-partners-widget.php';

		/* Page Links Widget */
		require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-page-links-widget.php';

		if ( class_exists( 'WP_Job_Manager' ) ) :

			/* Listing Amenities Widget */
			require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-amenities-widget.php';

			/* Listings Widget */
			require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listings-widget.php';

			/* Listing Map Widget */
			require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-map-widget.php';

			if ( taxonomy_exists( 'job_listing_category' ) ) :

				/* Listing Categories Widget */
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-categories-widget.php';

				/* Listing Category Links Widget */
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-category-links-widget.php';
			endif;

			if ( taxonomy_exists( 'job_listing_amenity' ) ) :
				
				/* Listing Amenity Links Widget */
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-amenity-links-widget.php';
			endif;

			if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) :

				/* Listing Regions Widget */
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-regions-widget.php';

				/* Listing Region Links Widget */
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-listing-region-links-widget.php';
			endif;

			/* Pricing Widget */
			if ( class_exists( 'Woocommerce' ) && ( defined( 'ASTOUNDIFY_WPJMLP_VERSION' ) || class_exists( 'WC_Paid_Listings' ) ) ) :
				require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/class-listar-pricing-widget.php';
			endif;
		endif;
		
		if ( class_exists( 'WCFMmp_Store_Best_Selling_Vendors' ) ) :
			require_once LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/widget-extends/class-listar-wcfmmp-widget-store-vendors.php';
		endif;

	}

endif;

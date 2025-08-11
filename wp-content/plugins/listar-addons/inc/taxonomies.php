<?php
/**
 * Custom taxonomies
 *
 * @package Listar_Addons
 */

add_action( 'listar_register_taxonomies_init', 'listar_register_taxonomies', 0 );

if ( ! function_exists( 'listar_register_taxonomies' ) ) :
	/**
	 * Sets custom taxonomies.
	 *
	 * @since 1.0
	 */
	function listar_register_taxonomies() {

		/* Register 'job_listing_amenity' taxonomy to WP Job Manager 'job_listing' post type */

		$labels = array(
			'name'                       => esc_html_x( 'Listing Amenities', 'taxonomy general name', 'listar' ),
			'singular_name'              => esc_html_x( 'Listing Amenity', 'taxonomy singular name', 'listar' ),
			'search_items'               => esc_html__( 'Search Amenities', 'listar' ),
			'popular_items'              => esc_html__( 'Popular Amenities', 'listar' ),
			'all_items'                  => esc_html__( 'All Amenities', 'listar' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => esc_html__( 'Edit Amenity', 'listar' ),
			'update_item'                => esc_html__( 'Update Amenity', 'listar' ),
			'add_new_item'               => esc_html__( 'Add New Amenity', 'listar' ),
			'new_item_name'              => esc_html__( 'New Amenity Name', 'listar' ),
			'separate_items_with_commas' => esc_html__( 'Separate amenities with commas', 'listar' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove amenities', 'listar' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used amenities', 'listar' ),
			'not_found'                  => esc_html__( 'No category found.', 'listar' ),
			'menu_name'                  => esc_html__( 'Listing Amenities', 'listar' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite'               => false,
			'show_in_rest'          => true,
			'rest_base'             => 'listing_amenities',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		);

		register_taxonomy( 'job_listing_amenity', 'job_listing', $args );
	}
endif;


add_action( 'listar_modify_taxonomies_init', 'listar_modify_taxonomies', 5000 );

if ( ! function_exists( 'listar_modify_taxonomies' ) ) :
	/**
	 * Customize default labels from taxonomies.
	 *
	 * @since 1.0
	 */
	function listar_modify_taxonomies() {

		/* WP Job Manager listing category labels */

		$args = get_taxonomy( 'job_listing_category' );

		if ( $args ) {
			$args->label                         = esc_html__( 'Listing categories', 'listar' );
			$args->labels->name                  = esc_html__( 'Listing Categories', 'listar' );
			$args->labels->singular_name         = esc_html__( 'Listing category', 'listar' );
			$args->labels->search_items          = esc_html__( 'Search Categories', 'listar' );
			$args->labels->all_items             = esc_html__( 'All Listing Categories', 'listar' );
			$args->labels->parent_item           = esc_html__( 'Parent Listing Category', 'listar' );
			$args->labels->parent_item_colon     = esc_html__( 'Parent Listing Category', 'listar' ) . ':';
			$args->labels->edit_item             = esc_html__( 'Edit Listing Category', 'listar' );
			$args->labels->view_item             = esc_html__( 'View Category', 'listar' );
			$args->labels->update_item           = esc_html__( 'Update Listing Category', 'listar' );
			$args->labels->add_new_item          = esc_html__( 'Add New Listing Category', 'listar' );
			$args->labels->new_item_name         = esc_html__( 'New Listing Category Name', 'listar' );
			$args->labels->not_found             = esc_html__( 'No categories found.', 'listar' );
			$args->labels->no_terms              = esc_html__( 'No categories', 'listar' );
			$args->labels->items_list_navigation = esc_html__( 'Categories list navigation', 'listar' );
			$args->labels->items_list            = esc_html__( 'Categories list', 'listar' );
			$args->labels->menu_name             = esc_html__( 'Listing Categories', 'listar' );
			$args->labels->name_admin_bar        = esc_html__( 'Listing Category', 'listar' );
			$args->labels->archives              = esc_html__( 'All Listing Categories', 'listar' );
			$args->rewrite = is_array( $args->rewrite ) ? $args->rewrite : array();
			$args->rewrite['slug']               = 'listing_category';
			$args->query_var                     = 'listing_category';
			$args->show_in_rest                  = true;
			$args->rest_base                     = 'listing_categories';
			$args->rest_controller_class         = 'WP_REST_Terms_Controller';

			register_taxonomy( 'job_listing_category', 'job_listing', (array) $args );
		}

		/* WP Job Manager listing region labels */

		$args2 = get_taxonomy( 'job_listing_region' );

		if ( $args2 && class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
			$args2->label                         = esc_html__( 'Listing Regions', 'listar' );
			$args2->labels->name                  = esc_html__( 'Listing Regions', 'listar' );
			$args2->labels->singular_name         = esc_html__( 'Listing region', 'listar' );
			$args2->labels->search_items          = esc_html__( 'Search Regions', 'listar' );
			$args2->labels->all_items             = esc_html__( 'All Listing Regions', 'listar' );
			$args2->labels->parent_item           = esc_html__( 'Parent Listing Region', 'listar' );
			$args2->labels->parent_item_colon     = esc_html__( 'Parent Listing Region', 'listar' ) . ':';
			$args2->labels->edit_item             = esc_html__( 'Edit Listing Region', 'listar' );
			$args2->labels->view_item             = esc_html__( 'View Region', 'listar' );
			$args2->labels->update_item           = esc_html__( 'Update Listing Region', 'listar' );
			$args2->labels->add_new_item          = esc_html__( 'Add New Listing Region', 'listar' );
			$args2->labels->new_item_name         = esc_html__( 'New Listing Region Name', 'listar' );
			$args2->labels->not_found             = esc_html__( 'No regions found.', 'listar' );
			$args2->labels->no_terms              = esc_html__( 'No regions', 'listar' );
			$args2->labels->items_list_navigation = esc_html__( 'Regions list navigation', 'listar' );
			$args2->labels->items_list            = esc_html__( 'Regions list', 'listar' );
			$args2->labels->menu_name             = esc_html__( 'Listing Regions', 'listar' );
			$args2->labels->name_admin_bar        = esc_html__( 'Listing Region', 'listar' );
			$args2->labels->archives              = esc_html__( 'All Listing Regions', 'listar' );
			$args2->rewrite = is_array( $args2->rewrite ) ? $args2->rewrite : array();
			$args2->rewrite['slug']               = 'listing_region';
			$args2->query_var                     = 'listing_region';
			$args2->show_in_rest                  = true;
			$args2->rest_base                     = 'listing_regions';
			$args2->rest_controller_class         = 'WP_REST_Terms_Controller';

			register_taxonomy( 'job_listing_region', 'job_listing', (array) $args2 );
		}
	}
endif;


add_action( 'widgets_init', 'listar_custom_taxonomies_init', 30 );

if ( ! function_exists( 'listar_custom_taxonomies_init' ) ) :
	/**
	 * Register and customize taxonomies.
	 *
	 * @since 1.0
	 */
	function listar_custom_taxonomies_init() {

		/* Register taxonomies - 'Listar Add-ons' plugin */
		do_action( 'listar_register_taxonomies_init' );

		/* Modify taxonomies - 'Listar Add-ons' plugin */
		do_action( 'listar_modify_taxonomies_init' );
	}

endif;

/*
 * Force permalinks update when taxonomy terms are created or edited
 * @since 1.0
 */
add_action( 'created_job_listing_category', 'flush_rewrite_rules', 10, 2 );
add_action( 'created_job_listing_region', 'flush_rewrite_rules', 10, 2 );
add_action( 'created_job_listing_amenity', 'flush_rewrite_rules', 10, 2 );
add_action( 'edited_job_listing_category', 'flush_rewrite_rules', 10, 2 );
add_action( 'edited_job_listing_region', 'flush_rewrite_rules', 10, 2 );
add_action( 'edited_job_listing_amenity', 'flush_rewrite_rules', 10, 2 );

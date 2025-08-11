<?php
/**
 * Custom post types
 *
 * @package Listar_Addons
 */

add_action( 'listar_register_post_types_init', 'listar_custom_post_types' );

if ( ! function_exists( 'listar_custom_post_types' ) ) :
	/**
	 * Sets custom post types.
	 *
	 * @since 1.0
	 */
	function listar_custom_post_types() {

		$labels = array(
			'name'               => _x( 'Partners', 'Post Type General Name', 'listar' ),
			'singular_name'      => _x( 'Partner', 'Post Type Singular Name', 'listar' ),
			'menu_name'          => esc_html__( 'Partners', 'listar' ),
			'parent_item_colon'  => esc_html__( 'Parent Partner', 'listar' ),
			'all_items'          => esc_html__( 'All Partners', 'listar' ),
			'view_item'          => esc_html__( 'View Partner', 'listar' ),
			'add_new_item'       => esc_html__( 'Add New Partner', 'listar' ),
			'add_new'            => esc_html__( 'Add New', 'listar' ),
			'edit_item'          => esc_html__( 'Edit Partner', 'listar' ),
			'update_item'        => esc_html__( 'Update Partner', 'listar' ),
			'search_items'       => esc_html__( 'Search Partner', 'listar' ),
			'not_found'          => esc_html__( 'Not Found', 'listar' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'listar' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
		);

		$args = array(
			'label'               => esc_html__( 'partners', 'listar' ),
			'description'         => esc_html__( 'Company partners', 'listar' ),
			'labels'              => $labels,
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 35,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'supports'            => $supports,
		);

		register_post_type( 'listar_partner', $args );
	}
endif;

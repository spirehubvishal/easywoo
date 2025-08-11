<?php
/*
 * The "Claim" custom post type
 */

function listar_claim_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name' => _x( 'Claims', 'Post Type General Name', 'listar' ),
		'singular_name' => _x( 'Claim', 'Post Type Singular Name', 'listar' ),
		'menu_name' => __( 'Claims', 'listar' ),
		'parent_item_colon' => __( 'Parent Claim', 'listar' ),
		'all_items' => __( 'All Claims', 'listar' ),
		'view_item' => __( 'View Claim', 'listar' ),
		'add_new_item' => __( 'Add New Claim', 'listar' ),
		'add_new' => __( 'Add New', 'listar' ),
		'edit_item' => __( 'Moderate Claim', 'listar' ),
		'update_item' => __( 'Update Claim', 'listar' ),
		'search_items' => __( 'Search Claim', 'listar' ),
		'not_found' => __( 'Not Found', 'listar' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'listar' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label' => __( 'Claims', 'listar' ),
		'description' => __( 'Claim listings', 'listar' ),
		'labels' => $labels,
		// Features this CPT supports in Post Editor
		'supports' => array( 'title', 'revisions', 'custom-fields', ),
		/* A hierarchical CPT is like Pages and can have
		 * Parent and child items. A non-hierarchical CPT
		 * is like Posts.
		 */
		'hierarchical' => false,
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_in_admin_bar' => false,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-yes-alt',
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'capability_type' => 'post',
		'show_in_rest' => true,
	);

	// Registering your Custom Post Type
	register_post_type( 'listar_claim', $args );	

	register_post_status( 'resolved', array(
		'label'                     => _x( 'Resolved', 'post status label', 'plugin-domain' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'Resolved <span class="count">(%s)</span>', 'Resolved <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'listar_claim' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-yes',
	) );
}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not 
 * unnecessarily executed. 
 */

add_action( 'init', 'listar_claim_post_type', 0 );

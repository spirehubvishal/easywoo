<?php
/**
 * Shows term `select` (multiple) form field on job listing forms.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/form-fields/term-multiselect-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Get selected value.
if ( isset( $field['value'] ) ) {
	$selected = $field['value'];
} elseif (  ! empty( $field['default'] ) && is_int( $field['default'] ) ) {
	$selected = $field['default'];
} elseif ( ! empty( $field['default'] ) && ( $term = get_term_by( 'slug', $field['default'], $field['taxonomy'] ) ) ) {
	$selected = $term->term_id;
} else {
	$selected = '';
}

wp_enqueue_script( 'wp-job-manager-term-multiselect' );


$defaults = [
	'orderby'         => 'id',
	'order'           => 'ASC',
	'show_count'      => 0,
	'hide_empty'      => 1,
	'parent'          => '',
	'child_of'        => 0,
	'exclude'         => '',
	'number'           => 80,
	'echo'            => 1,
	'selected'        => 0,
	'hierarchical'    => 0,
	'name'            => 'cat',
	'id'              => '',
	'class'           => 'job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
	'depth'           => 0,
	'taxonomy'        => 'job_listing_category',
	'value'           => 'id',
	'multiple'        => true,
	'show_option_all' => false,
	'placeholder'     => __( 'Choose a category&hellip;', 'wp-job-manager' ),
	'no_results_text' => __( 'No results match', 'wp-job-manager' ),
	'multiple_text'   => __( 'Select Some Options', 'wp-job-manager' ),
];

$args = [
	'taxonomy'     => $field['taxonomy'],
	'hierarchical' => 1,
	'name'         => isset( $field['name'] ) ? $field['name'] : $key,
	'orderby'      => 'name',
	'number'        => 80,
	'selected'     => $selected,
	'hide_empty'   => false
];

if ( isset( $field['placeholder'] ) && ! empty( $field['placeholder'] ) ) $args['placeholder'] = $field['placeholder'];

$r = wp_parse_args( $args, $defaults );

$r['number'] = 80;

if ( ! isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
	$r['pad_counts'] = true;
}

if ( ! isset( $r['search_category_slugs'] ) ) {
	$r['search_category_slugs'] = wpjm_get_category_slugs_from_search_query_string();
}

/** This filter is documented in wp-job-manager.php */
$r['lang'] = apply_filters( 'wpjm_lang', null );

// Store in a transient to help sites with many cats.
$categories_hash = 'jm_cats_' . md5( wp_json_encode( $r ) . WP_Job_Manager_Cache_Helper::get_transient_version( 'jm_get_' . $r['taxonomy'] ) );
$categories      = get_transient( $categories_hash );

if ( empty( $categories ) ) {
	$args = [
		'taxonomy'     => $r['taxonomy'],
		'orderby'      => $r['orderby'],
		'order'        => $r['order'],
		'hide_empty'   => $r['hide_empty'],
		'parent'       => $r['parent'],
		'number'       => 80,
		'child_of'     => $r['child_of'],
		'exclude'      => $r['exclude'],
		'hierarchical' => $r['hierarchical'],
	];

	$categories = get_terms( $args );

	if ( ! empty( $r['search_category_slugs'] ) ) {
		$categories = array_merge(
			$categories,
			wpjm_get_categories_by_slug( $r['search_category_slugs'], $args, $categories )
		);
	}

	set_transient( $categories_hash, $categories, DAY_IN_SECONDS * 7 );
}

$id = $r['id'] ? $r['id'] : $r['name'];

$output = "<select name='" . esc_attr( $r['name'] ) . "[]' id='" . esc_attr( $id ) . "' class='" . esc_attr( $r['class'] ) . "' " . ( $r['multiple'] ? "multiple='multiple'" : '' ) . " data-placeholder='" . esc_attr( $r['placeholder'] ) . "' data-no_results_text='" . esc_attr( $r['no_results_text'] ) . "' data-multiple_text='" . esc_attr( $r['multiple_text'] ) . "'>\n";

if ( $r['show_option_all'] ) {
	$output .= '<option value="">' . esc_html( $r['show_option_all'] ) . '</option>';
}

if ( ! empty( $categories ) ) {
	include_once JOB_MANAGER_PLUGIN_DIR . '/includes/class-wp-job-manager-category-walker.php';

	$temp = array();
	$listar_hide_parent_amenities = 1 === (int) get_option( 'listar_hide_parent_amenity_pickers' );

	if ( 'job_listing_amenity' === $field['taxonomy'] && $listar_hide_parent_amenities ) {
		if ( is_array( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $term ) {
				$children = get_term_children( $term->term_id, $field['taxonomy'] );

				if ( ! empty( $children ) && ! is_wp_error( $children ) ){
					continue;
				} else {
					$temp[] = $term;
				}
			}

			$categories = $temp;
		}						
	}

	$walker = new WP_Job_Manager_Category_Walker();

	if ( $r['hierarchical'] ) {
		$depth = $r['depth'];  // Walk the full depth.
	} else {
		$depth = -1; // Flat.
	}

	$output .= $walker->walk( $categories, $depth, $r );
}

$output .= "</select>\n";

if ( $r['echo'] ) {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $output;
}

if ( ! empty( $field['description'] ) ) : ?><small class="description"><?php echo wp_kses_post( $field['description'] ); ?></small><?php endif; ?>

<?php
/**
 * Return listing card content with Ajax.
 *
 * @package Listar
 */


$listar_wp_load_file_path = '../../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$urlparts = parse_url( home_url() );
$domain = $urlparts['host'];

/* Only allowed to the current site domain */

header("Access-Control-Allow-Origin: ' . $domain . '");

$ajax_data = esc_html( filter_input( INPUT_GET, 'searchTerm' ) );
$taxonomy  = esc_html( filter_input( INPUT_GET, 'taxonomy' ) );

if ( ( empty( $ajax_data ) && '' !== $ajax_data ) || empty( $taxonomy ) ) {
	listar_close_section();
	die();
}

// We get a list taxonomies on the search box
function listar_get_tax_term_by_search( $search_text = '', $taxonomy = '' ) {
	if ( empty( $taxonomy ) ) {
		listar_close_section();
		die();
	}

	$listar_hide_parent_amenities = 1 === (int) get_option( 'listar_hide_parent_amenity_pickers' );
	
	$json_output = '[';

	$args = array(
		'taxonomy' => array( $taxonomy ), // taxonomy name
		'order' => 'ASC',
		'hide_empty' => false,
		'fields' => 'all',
		'number' => '80',
		'name__like' => $search_text
	);

	$terms = get_terms( $args );

	$count = count( $terms );

	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			if ( 'job_listing_amenity' === $taxonomy && $listar_hide_parent_amenities ) {
				$children = get_term_children( $term->term_id, $taxonomy );

				if ( ! empty( $children ) && ! is_wp_error( $children ) ){
					continue;
				}				
			}

			if ( '[' === $json_output ) {
				$json_output .= '{"text":' . wp_json_encode( $term->name ) . ',"id":' . $term->term_id . '}';
			} else {
				$json_output .= ',{"text":' . wp_json_encode( $term->name ) . ',"id":' . $term->term_id . '}';
			}
		}
	}
	//$json_output .= ',{"text":' . json_encode( 'Burlé & Fantasy' ) . ',"id":' . '317' . '}';
	$json_output .= ']';
	
	return $json_output;
}

//if ( isset( $_GET['searchTerm'] ) ) {
//	$_GET['searchTerm']
//}

//$search = $_GET['searchTerm'];
//echo $search;
$json_output = listar_get_tax_term_by_search( $ajax_data, $taxonomy );

/*
$json_output = '[{"text":"Testar","id":5},
{"text":"Glanda","id":6},
{"text":"Brudir","id":7},
{"text":"Tesla","id":9}]';
*/


echo $json_output;

listar_close_section();
die();
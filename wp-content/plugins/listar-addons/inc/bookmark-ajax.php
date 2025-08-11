<?php
/**
 * Add or remove a listing to the user Bookmarks list.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$ajax_data = filter_input( INPUT_POST, 'send_data' );
$return_data = array();
$obj = '';
$origin = '';

// Is the request coming from same domain?

if ( array_key_exists( 'HTTP_ORIGIN', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_ORIGIN'];
} elseif ( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

if ( ! empty( $origin ) && false !== strpos( $origin, '://' ) ) {
	$temp = explode( '://', $origin );
	$origin = $temp[1];

	if ( ! empty( $origin ) ) {
		$site_url = network_site_url();
		
		if ( false === strpos( $site_url, $origin ) ) {
			listar_close_section();
			die();
		}
	} else {
		listar_close_section();
		die();
	}
} else {
	listar_close_section();
	die();
}

if( ! empty( $ajax_data ) ) {
	$obj = json_decode( wp_unslash( $ajax_data ) );
} else {
	listar_close_section();
	die();
}

if ( empty( $obj ) ) :
	listar_close_section();
	die();
endif;

$data_type = '';
$ajax_post_id = '';
$ajax_user_id = '';

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		
		if ( 'type' === $key ) {
			$data_type = $data;
			continue;
		} 
		
		if ( 'id' === $key ) {
			$ajax_post_id = $data;
			continue;
		} 
		
		if ( 'user' === $key ) {
			$ajax_user_id = $data;
			continue;
		}
	}
} 
		
if ( 
	( false !== strpos( $data_type, 'add' ) || false !== strpos( $data_type, 'remove' ) ) &&
	'' !== $ajax_post_id &&
	'' !== $ajax_user_id
) {
	$user_ids = get_post_meta( $ajax_post_id, 'listar_meta_box_bookmarks_user_ids', true );
	$user_ids_array = ! empty( $user_ids ) ? array_filter( explode( ',', $user_ids ) ) : array();
	$new_user_ids = $user_ids_array;
	$count_user_ids = count( $user_ids_array );
	$counter = (int) get_post_meta( $ajax_post_id, 'listar_meta_box_bookmarks_counter', true );
	$has_bookmarked = false;
	$bookmearked_user_posts_temp = get_the_author_meta( 'listar_meta_box_user_bookmarked_posts', $ajax_user_id );
	$bookmearked_user_posts_array = ! empty( $bookmearked_user_posts_temp ) ? array_filter( explode( ',', $bookmearked_user_posts_temp ) ) : array();
	$new_posts_ids = $bookmearked_user_posts_array;

	if ( 'add' === $data_type ) {
		if ( ! in_array( strval( $ajax_user_id ), $user_ids_array ) ) {
			$user_ids_array[] = strval( $ajax_user_id );
			$new_user_ids = $user_ids_array;
			
			$bookmearked_user_posts_array[] = strval( $ajax_post_id );
			$new_posts_ids = $bookmearked_user_posts_array;
			
			$counter++;
		}
	} elseif ( 'remove' === $data_type ) {
		if ( in_array( strval( $ajax_user_id ), $user_ids_array ) ) {
			$new_user_ids = array_diff( $new_user_ids, array( strval( $ajax_user_id ) ) );
			
			$new_posts_ids = array_diff( $new_posts_ids, array( strval( $ajax_post_id ) ) );
			
			$counter--;
		}
	}
	
	$count_new_user_ids = count( $new_user_ids );
	
	if ( ! empty( $count_new_user_ids ) ) {
		$new_user_ids = implode( ',', $new_user_ids );
	} else {
		$new_user_ids = '';
	}
	
	$count_new_posts_ids = count( $new_posts_ids );
	
	if ( ! empty( $count_new_posts_ids ) ) {
		$new_posts_ids = implode( ',', $new_posts_ids );
	} else {
		$new_posts_ids = '';
	}
	
	if ( empty( $counter ) ) {
		$counter = 0;
	}
	
	update_post_meta( $ajax_post_id, 'listar_meta_box_bookmarks_user_ids', esc_html( $new_user_ids ) );
	update_post_meta( $ajax_post_id, 'listar_meta_box_bookmarks_counter', esc_html( $counter ) );
	update_user_meta( $ajax_user_id, 'listar_meta_box_user_bookmarked_posts', $new_posts_ids );
	
}

echo esc_html( 'Done!' );

listar_close_section();

exit();

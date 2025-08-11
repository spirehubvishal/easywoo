<?php
/**
 * Get current best rated listings and update the 'listar_best_rated_listings' theme option
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$listar_nonce  = filter_input( INPUT_GET, '_wpnonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

if ( empty( $listar_nonce ) || ! wp_verify_nonce( $listar_nonce, 'update_best_rated' ) ) :
    listar_close_section();
	die();
endif;

echo '<br />';

esc_html_e( 'Working...', 'listar' );

if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) :
	listar_update_top_listings();
	echo '<br /><br /><b>' . esc_html__( 'Done! The Best Rated and Trending listings were updated.', 'listar' ) . '</b><br />' . esc_html__( 'This window can be closed now.', 'listar' );
endif;

listar_close_section();
exit();

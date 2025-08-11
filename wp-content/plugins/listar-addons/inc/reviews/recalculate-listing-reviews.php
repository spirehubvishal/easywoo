<?php
/**
 * Recalculate and update listing review averages for listings.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../../wp-load.php';
$listar_wp_settings_file_path = '../../../../../wp-settings.php';
require_once $listar_wp_load_file_path;
require_once $listar_wp_settings_file_path;

$listar_nonce  = filter_input( INPUT_GET, '_wpnonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

if ( empty( $listar_nonce ) || ! wp_verify_nonce( $listar_nonce, 'recalculate_reviews' ) ) :
    listar_close_section();
	die();
endif;

echo '<br />';

esc_html_e( 'Working...', 'listar' );

if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) :
	listar_recalculate_reviews_bulk();
	echo '<br /><br /><b>' . esc_html__( 'Done! Listing rating averages were updated.', 'listar' ) . '</b><br />' . esc_html__( 'This window can be closed now.', 'listar' );
endif;

listar_close_section();
exit();

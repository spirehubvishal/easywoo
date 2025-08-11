<?php
/**
 * Works together with Ajax (listar/js/frontend.js) making the login form always get updated nonce code.
 * This solution is useful mainly if a cache plugin is currently installed.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$listar_rand  = filter_input( INPUT_GET, 'rand', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

/* Check if 'rand' variable was sent on GET */
if ( empty( $listar_rand ) ) :
	listar_close_section();
	die();
endif;
?>
<div class="listar-updated-nonce">
	<?php
		wp_nonce_field( 'ajax-login-nonce', 'password-security' );
		wp_nonce_field( 'ajax-login-nonce', 'login-security' );
		wp_nonce_field( 'ajax-login-nonce', 'register-security' );
		wp_nonce_field( 'listar-private-message-nonce', 'listar-private-message-security' );
		wp_nonce_field( 'listar-claim-nonce', 'listar-claim-security' );
	?>
</div>
<?php

listar_close_section();
exit();

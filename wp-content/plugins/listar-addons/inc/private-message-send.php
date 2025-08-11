<?php
/**
 * Sends the Private Message for Listing Authors
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

// Only process POST requests.

$listar_wordpress_path = '../../../../';
require_once( $listar_wordpress_path . 'wp-load.php' );
require_once( $listar_wordpress_path . 'wp-settings.php' );


/* Proceed if nonce is valid */
$listar_nonce = filter_input( INPUT_POST, 'listar-private-message-security', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

if ( ! empty( $listar_nonce ) && wp_verify_nonce( $listar_nonce, 'listar-private-message-nonce' ) && 'POST' == $_SERVER['REQUEST_METHOD'] ) {

	// Get the form fields and remove whitespace.
	$listar_sender_name = isset( $_POST['listar_sender_name'] ) ? sanitize_text_field( wp_unslash( strip_tags( trim( $_POST['listar_sender_name'] ) ) ) ) : '';
	$listar_sender_name = str_replace( array( "\r", "\n" ), '', $listar_sender_name );
	$listar_sender_email = isset( $_POST['listar_sender_email'] ) ? sanitize_email( wp_unslash( trim( $_POST['listar_sender_email'] ) ) ) : '';
	$listar_listing_owner_name = isset( $_POST['listar_listing_owner_name'] ) ? sanitize_text_field( wp_unslash( strip_tags( trim( $_POST['listar_listing_owner_name'] ) ) ) ) : '';
	$listar_listing_owner_name = str_replace( array( "\r", "\n" ), '', $listar_listing_owner_name );
	$listar_listing_owner_email = isset( $_POST['listar_listing_owner_email'] ) ? sanitize_email( wp_unslash( trim( $_POST['listar_listing_owner_email'] ) ) ) : '';
	$listar_site_name = isset( $_POST['listar_site_name'] ) ? sanitize_text_field( wp_unslash( strip_tags( trim( $_POST['listar_site_name'] ) ) ) ) : '';
	$listar_listing_title = isset( $_POST['listar_listing_title'] ) ? sanitize_text_field( wp_unslash( strip_tags( trim( $_POST['listar_listing_title'] ) ) ) ) : '';
	$listar_current_page_link = isset( $_POST['listar_current_page_link'] ) ? esc_url( wp_unslash( strip_tags( trim( $_POST['listar_current_page_link'] ) ) ) ) : '';
	$listar_message_subject = isset( $_POST['listar_private_message_subject'] ) ? sanitize_text_field( wp_unslash( strip_tags( trim( $_POST['listar_private_message_subject'] ) ) ) ) : '';
	$listar_sender_message = isset( $_POST['listar_sender_message'] ) ? wp_kses( wp_unslash( trim( $_POST['listar_sender_message'] ) ), 'post' ) : '';
	$listar_message_content = isset( $_POST['listar_private_message_template'] ) ? wp_kses( wp_unslash( trim( $_POST['listar_private_message_template'] ) ), 'post' ) : '';
	$listar_smtp_options = get_option( 'swpsmtp_options' );
	$listar_wp_mail_smtp_options = get_option( 'wp_mail_smtp' );
	$listar_smtp_from = '';
	$listar_smtp_from_name = '';
	
	if ( ! empty( $listar_wp_mail_smtp_options ) ) {
		$listar_smtp_from = isset( $listar_wp_mail_smtp_options['mail']['from_email'] ) ? $listar_wp_mail_smtp_options['mail']['from_email'] : '';
		$listar_smtp_from_name = isset( $listar_wp_mail_smtp_options['from_name'] ) ? $listar_wp_mail_smtp_options['from_name'] : '';
	} else if ( ! empty( $listar_smtp_options ) ) {
		$listar_smtp_from = isset( $listar_smtp_options['from_email_field'] ) ? $listar_smtp_options['from_email_field'] : '';
		$listar_smtp_from_name = isset( $listar_smtp_options['from_name_field'] ) ? $listar_smtp_options['from_name_field'] : '';
	}

	// Use From Name of SMTP config as default, fallback to site title if empty.
	$listar_message_from_name = sanitize_text_field( strip_tags( stripslashes( $listar_smtp_from_name ) ) );

	if ( empty( $listar_message_from_name ) ) {
		$listar_message_from_name = $listar_site_name;
	}

	// Check that data was sent to the mailer.
	if ( empty( $listar_sender_name ) || empty( $listar_listing_owner_name ) || empty( $listar_sender_message ) || ! filter_var( $listar_sender_email, FILTER_VALIDATE_EMAIL ) || ! filter_var( $listar_listing_owner_email, FILTER_VALIDATE_EMAIL ) ) {
		// Set a 400 (bad request) response code and exit.
		http_response_code( 400 );
		exit;
	}

	// Set the recipient email address.
	$listar_message_recipient = $listar_listing_owner_email;

	// Set the email subject.
	$listar_message_subject = str_replace( '[listar_sender_name]', $listar_sender_name, $listar_message_subject );
	$listar_message_subject = str_replace( '[listar_listing_title]', $listar_listing_title, $listar_message_subject );
	$listar_message_subject = str_replace( '[listar_site_name]', $listar_site_name, $listar_message_subject );
	$listar_message_subject = str_replace( '[listar_listing_owner_name]', $listar_listing_owner_name, $listar_message_subject );
	$listar_message_subject = stripslashes( $listar_message_subject );

	// Build the email content.
	$listar_message_content = str_replace( '[listar_sender_name]', $listar_sender_name, $listar_message_content );
	$listar_message_content = str_replace( '[listar_sender_email]', $listar_sender_email, $listar_message_content );
	$listar_message_content = str_replace( '[listar_sender_message]', $listar_sender_message, $listar_message_content );
	$listar_message_content = str_replace( '[listar_listing_title]', $listar_listing_title, $listar_message_content );
	$listar_message_content = str_replace( '[listar_site_name]', $listar_site_name, $listar_message_content );
	$listar_message_content = str_replace( '[listar_listing_owner_name]', $listar_listing_owner_name, $listar_message_content );
	$listar_message_content = str_replace( '[listing_owner_email]', $listar_listing_owner_email, $listar_message_content );
	$listar_message_content = str_replace( '[listar_current_page_link]', "<a href='" . $listar_current_page_link . "' target='_blank'>" . $listar_listing_title . '</a>', $listar_message_content );
	$listar_message_content = str_replace( array( "\n" ), '<br/>', $listar_message_content ); /* Double line break: array("\r", "\n") */
	$listar_message_content = stripslashes( $listar_message_content );

	// Build the email headers.
	$listar_message_from  = sanitize_text_field( strip_tags( stripslashes( $listar_smtp_from ) ) );
	$listar_message_reply = $listar_sender_email;

	// Don't procceed if "From" email wasn't set on WP Mail SMTP, nor Easy WP SMTP.
	if ( empty( $listar_message_from ) ) {
		// Set a 500 (internal server error) response code.
		http_response_code( 500 );
	}

	$listar_email_headers  = "From: $listar_message_from_name < $listar_message_from >\r\n";
	$listar_email_headers .= "X-Sender: $listar_sender_name < $listar_message_reply >\r\n";
	$listar_email_headers .= "Reply-To: $listar_sender_name < $listar_message_reply >\r\n";
	$listar_email_headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
	$listar_email_headers .= "X-Priority: 1\r\n"; // Urgent message!
	$listar_email_headers .= "MIME-Version: 1.0\r\n";
	$listar_email_headers .= "Content-Type: text/html; charset='UTF-8'\r\n";

	// Send the email.
	if ( wp_mail( $listar_message_recipient, '=?UTF-8?B?' . base64_encode( $listar_message_subject ) . '?=', $listar_message_content, $listar_email_headers ) ) {
		// Set a 200 (okay) response code.
		http_response_code( 200 );
	} else {
		// Set a 500 (internal server error) response code.
		http_response_code( 500 );
	}
} else {
	// Not a POST request, set a 403 (forbidden) response code.
	http_response_code( 403 );
}

exit();

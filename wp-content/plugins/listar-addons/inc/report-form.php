<?php
/**
 * Action to enable the Report form.
 *
 * @package Listar_Addons
 */


/**
 * Actions to output every form
 */

add_action( 'listar_report_form', 'listar_report_form_output' );

if ( ! function_exists( 'listar_report_form_output' ) ) :
	/**
	 * Report form output.
	 *
	 * @since 1.3.9
	 */
	function listar_report_form_output() {
		global $post;
		
		$action = LISTAR_ADDONS_PLUGIN_DIR_URL . 'inc/complaint-report-send.php';
		$listar_use_complaint_name_field  = 1 === (int) get_option( 'listar_disable_complaint_name_field' ) ? false : true;
		$listar_use_complaint_email_field = 1 === (int) get_option( 'listar_disable_complaint_email_field' ) ? false : true;
		
		$listar_author = get_userdata( $post->post_author );
		$listar_sending_fail_message = esc_html__( 'Message not sent.', 'listar' );
		$listar_sending_success_message = esc_html__( 'Ok, message sent.', 'listar' );
		$user = wp_get_current_user();
		$user_email = '';
		$user_name = '';
		$logged = intval( $user->ID );

		if ( $logged ) {
			$user_email = $user->user_email;
			$user_name  = listar_user_name();
		}

		$listar_listing_owner_name  = isset( $listar_author->first_name ) && ! empty( $listar_author->first_name ) ? $listar_author->first_name : listar_get_listing_author_name( $listar_author );
		$listar_listing_owner_email = $listar_author->user_email;
		
		$prefix_subject = esc_html__( 'Complaint Report', 'listar' );
		$listar_complaint_report_subject = $prefix_subject . ': [listar_site_name] - [listar_listing_title]';
		
		$message_for_prefix = esc_html__( 'Business Owner', 'listar' );
		$owner_email_prefix = esc_html__( 'Business Owner Email', 'listar' );
		$page_prefix        = esc_html__( 'Page', 'listar' );
		$visitor_prefix     = esc_html__( 'Complainer', 'listar' );
		$email_prefix       = esc_html__( 'Complainer Email', 'listar' );
		$line_break         = '<br>';
		$listar_complaint_report_template = '';

		$message_for   = '<strong>' . $message_for_prefix . ':</strong> [listar_listing_owner_name]' . $line_break;
		$owner_email   = '<strong>' . $owner_email_prefix . ':</strong> [listar_listing_owner_email]' . $line_break;
		$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
		$visitor       = '<strong>' . $visitor_prefix . ':</strong> [listar_sender_name]' . $line_break;
		$visitor_email = '<strong>' . $email_prefix . ':</strong> [listar_sender_email]';
		$separator     = '<hr />';
		$message       = '[listar_sender_message]';

		$listar_complaint_report_template .= $message_for . $owner_email . $page . $visitor . $visitor_email . $separator . $message;
		?>
		<!-- Report form -->
		<div class="listar-report-form-wrapper">
			<form id="listar-report-form" action="<?php echo esc_url( $action ); ?>" method="post">
				<div class="form-field">
					<?php if ( $logged ) : ?>
						<input type="text" name="listar-complaint-report-user-name" id="listar-complaint-report-user-name" placeholder="<?php esc_attr_e( 'Name (required)', 'listar' ); ?>" class="form-control not-allowed" value="<?php echo esc_attr( $user_name ); ?>" required disabled>
					<?php elseif( $listar_use_complaint_name_field ) : ?>
						<input type="text" name="listar-complaint-report-user-name" id="listar-complaint-report-user-name" placeholder="<?php esc_attr_e( 'Name (required)', 'listar' ); ?>" class="form-control" required>
					<?php endif; ?>    
				</div>
				<div class="form-field">
					<?php if ( $logged ) : ?>                                            
						<input type="email" name="listar-complaint-report-user-email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" placeholder="<?php esc_attr_e( 'Email (required)', 'listar' ); ?>" value="<?php echo esc_attr( $user_email ); ?>" class="form-control not-allowed" required disabled>
					<?php elseif( $listar_use_complaint_email_field ) : ?>
						<input type="email" name="listar-complaint-report-user-email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" placeholder="<?php esc_attr_e( 'Email (required)', 'listar' ); ?>" class="form-control" required>
					<?php endif; ?>     
				</div>
				<div class="listar-popup-text-intro">
					<?php esc_html_e( 'Please explain why this publication should not be displayed on our website.', 'listar' ); ?>
				</div>
				<div class="form-field">
					<textarea rows="4" value="" class="form-control input-lg required" name="listar_complaint_sender_message" id="listar_complaint_sender_message"></textarea>
				</div>
				<div class="form-field hidden">
					<input type="hidden" name="listar_complaint_listing_owner_name" value="<?php echo esc_attr( $listar_listing_owner_name ); ?>" >
					<input type="hidden" name="listar_complaint_listing_owner_email" value="<?php echo esc_attr( $listar_listing_owner_email ); ?>" >
					<input type="hidden" name="listar_complaint_sender_name">
					<input type="hidden" name="listar_complaint_sender_email">
					<input type="hidden" name="listar_complaint_site_name" value="<?php echo esc_attr( get_bloginfo() ); ?>">
					<input type="hidden" name="listar_complaint_listing_title" value="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>">
					<input type="hidden" name="listar_complaint_current_page_link" value="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>">
					<input type="hidden" name="listar_complaint_report_subject" value="<?php echo esc_attr( $listar_complaint_report_subject ); ?>">
					<input type="hidden" name="listar_complaint_report_template" value="<?php echo wp_kses( $listar_complaint_report_template, 'post' ); ?>">
					<?php wp_nonce_field( 'listar-complaint-report-nonce', 'listar-complaint-report-security' ); ?>
				</div>
				<div class="form-field">
					<button class="listar-submit-report btn btn-theme btn-lg" data-button-text="<?php esc_attr_e( 'Send', 'listar' ); ?>" data-loading-text="<?php esc_attr_e( 'Sending...', 'listar' ); ?>" type="submit">
						<?php esc_html_e( 'Send', 'listar' ); ?>
					</button>
				</div>
			</form>
			<div id="form-message-success"><?php echo esc_html( $listar_sending_success_message ); ?></div>
			<div id="form-message-error"><?php echo esc_html( $listar_sending_fail_message ); ?></div>
		</div>
		<?php
	}

endif;

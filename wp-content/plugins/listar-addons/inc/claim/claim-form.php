<?php
/**
 * Action to enable the Claim form.
 *
 * @package Listar_Addons
 */


/**
 * Actions to output every form
 */

add_action( 'listar_claim_form', 'listar_claim_form_output' );

if ( ! function_exists( 'listar_claim_form_output' ) ) :
	/**
	 * Claim form output.
	 *
	 * @since 1.4.1
	 */
	function listar_claim_form_output() {
		$action = LISTAR_ADDONS_PLUGIN_DIR_URL . 'inc/claim/claim-validation-text-send.php';
		$listar_sending_fail_message = esc_html__( 'Message not sent.', 'listar' );
		$listar_sending_success_message = esc_html__( 'Ok, message sent.', 'listar' );
		$claim_validation_text = '';
		$session_main_key = 'listar_user_search_options';
		$minimum_claim_text_chars = (int) get_option( 'listar_claim_minimum_validation_chars' );

		if ( empty( $minimum_claim_text_chars ) ) {
			$minimum_claim_text_chars = '50';
		}

		if ( 'none' === $minimum_claim_text_chars ) {
			$minimum_claim_text_chars = '0';
		}

		if ( isset( $_SESSION[ $session_main_key ]['claim_validation_text'] ) ) {
			$claim_validation_text = $_SESSION[ $session_main_key ]['claim_validation_text'];
		}
		?>
		<!-- Claim form -->
		<div class="listar-claim-form-wrapper">
			<form id="listar-claim-form" action="<?php echo esc_url( $action ); ?>" method="post">
				<div class="listar-popup-text-intro">
					<?php esc_html_e( 'Please provide us info to confirm the ownership and validate your claim.', 'listar' ); ?>
				</div>
				<div class="form-field">
					<textarea rows="4" value="" data-minimun-chars="<?php echo esc_attr( $minimum_claim_text_chars ); ?>" class="form-control input-lg required" name="listar_claim_sender_message" id="listar_claim_sender_message"><?php echo esc_textarea( $claim_validation_text ); ?></textarea>
					<?php
					if ( ! empty( $minimum_claim_text_chars ) ) :
						?>
						<small class="listar-claim-required-chars"><?php esc_html_e( 'Characters missing', 'listar' ); ?>: <span class="listar-claim-missing-chars"><?php echo esc_attr( $minimum_claim_text_chars ); ?></span></small>
						<?php
					endif;
					?>
				</div>
				<div class="form-field hidden">
					<?php wp_nonce_field( 'listar-claim-nonce', 'listar-claim-security' ); ?>
				</div>
				<div class="form-field">
					<button class="listar-submit-claim btn btn-theme btn-lg" data-button-text="<?php esc_attr_e( 'Send', 'listar' ); ?>" data-loading-text="<?php esc_attr_e( 'Sending...', 'listar' ); ?>" type="submit">
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

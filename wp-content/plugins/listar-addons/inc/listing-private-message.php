<?php
/**
 * Template part for displaying the private message form
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar_Addons
 */

/**
 * Action to output the private message form for listings.
 */
add_action( 'listar_listing_private_message_form', 'listar_listing_private_message_form_output' );

if ( ! function_exists( 'listar_listing_private_message_form_output' ) ) :
	/**
	 * Private message form output (HTML).
	 *
	 * @since 1.2.4
	 */
	function listar_listing_private_message_form_output() {
		global $post;
		?>
		<!-- Start Private Message Section -->
		<div class="accordion-group listar-private-message-accordion">
			<div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">
					<a class="collapsed icon-at-sign" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						<?php echo esc_html_e( 'Private Message', 'listar' ); ?>
					</a>
				</h4>
			</div>
			<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body">
					<p class="listar-accordion-wrapper-paragraph">
						<div class="listar-listing-private-message-form-wrapper">
							<div class="listar-listing-private-message-form-inner">
								<div>
									<div class="panel panel-form">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12">
													<?php
													$listar_author = get_userdata( $post->post_author );
													$listar_sending_fail_message = get_option( 'listar_sending_fail_message' );
													$listar_sending_success_message = get_option( 'listar_sending_success_message' );
													$user = wp_get_current_user();
													$user_email = '';
													$user_name = '';
													$action = LISTAR_ADDONS_PLUGIN_DIR_URL . 'inc/private-message-send.php';
													$logged = intval( $user->ID );

													if ( $logged ) {
														$user_email = $user->user_email;
														$user_name  = listar_user_name();
													}

													$listar_listing_owner_name  = listar_get_listing_author_name( $listar_author );
													$listar_listing_owner_email = $listar_author->user_email;

													/* Fallback texts */
													if ( empty( $listar_sending_fail_message ) ) {
														$listar_sending_fail_message = esc_html__( 'Message not sent.', 'listar' );
													}

													if ( empty( $listar_sending_success_message ) ) {
														$listar_sending_success_message = esc_html__( 'Ok, message sent.', 'listar' );
													}
													?>
													<!-- Start Private Message Form -->
													<div id="form-message-success"><?php echo esc_html( $listar_sending_success_message ); ?></div>
													<div id="form-message-error"><?php echo esc_html( $listar_sending_fail_message ); ?></div>
													<form accept-charset="utf-8" method="post" id="listar-private-message-form" name="listar-private-message-form" class="form-horizontal contact-form listar-private-message-form user-form" action="<?php echo esc_url( $action ); ?>">
														<div class="row">
															<!-- Text input-->
															<div class="col-sm-6">
																<div class="form-group">
																	<div class="col-sm-12 inputGroupContainer">
																		<div class="input-group listar-private-message-user">
																			<span class="input-group-addon"><i class="icon-user"></i></span>
																			<?php if ( $logged ) : ?>
																				<input type="text" name="listar-private-message-user-name" id="listar-private-message-user-name" placeholder="<?php esc_attr_e( 'Name', 'listar' ); ?>" class="form-control not-allowed" value="<?php echo esc_attr( $user_name ); ?>" required disabled>
																			<?php else : ?>
																				<input type="text" name="listar-private-message-user-name" id="listar-private-message-user-name" placeholder="<?php esc_attr_e( 'Name', 'listar' ); ?>" class="form-control" required>
																			<?php endif; ?>                                            
																		</div>
																	</div>
																</div>
															</div>
															<!-- Text input-->
															<div class="col-sm-6">
																<div class="form-group">
																	<div class="col-sm-12 inputGroupContainer">
																		<div class="input-group listar-private-message-email">
																			<span class="input-group-addon"><i class="icon-envelope"></i></span>
																			<?php if ( $logged ) : ?>                                            
																				<input type="email" name="listar-private-message-user-email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" placeholder="<?php esc_attr_e( 'Email (required)', 'listar' ); ?>" value="<?php echo esc_attr( $user_email ); ?>" class="form-control not-allowed" required disabled>
																			<?php else : ?>
																				<input type="email" name="listar-private-message-user-email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" placeholder="<?php esc_attr_e( 'Email (required)', 'listar' ); ?>" class="form-control" required>
																			<?php endif; ?>                                            
																		</div>
																	</div>
																</div>
															</div>
															<!-- Textarea -->
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12 inputGroupContainer">
																		<div class="input-group-hidden-and-message">
																			<?php
																			$listar_private_message_subject  = html_entity_decode( stripcslashes( get_option( 'listar_private_message_subject' ) ) );
																			$listar_private_message_template = html_entity_decode( stripcslashes( get_option( 'listar_private_message_template' ) ) );

																			/* Fallback subject */
																			if ( empty( $listar_private_message_subject ) ) {
																				$prefix = esc_html__( 'Private Message', 'listar' );
																				$listar_private_message_subject = $prefix . ': [listar_site_name] - [listar_listing_title]';
																			}

																			/* Fallback template */
																			if ( empty( $listar_private_message_template ) ) {
																				$message_for_prefix = esc_html__( 'Message For', 'listar' );
																				$page_prefix        = esc_html__( 'Page', 'listar' );
																				$visitor_prefix     = esc_html__( 'Visitor', 'listar' );
																				$email_prefix       = esc_html__( 'Email', 'listar' );
																				$line_break         = '<br>';
																				$listar_private_message_template = '';

																				$message_for   = '<strong>' . $message_for_prefix . ':</strong> [listar_listing_owner_name]' . $line_break;
																				$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
																				$visitor       = '<strong>' . $visitor_prefix . ':</strong> [listar_sender_name]' . $line_break;
																				$visitor_email = '<strong>' . $email_prefix . ':</strong> [listar_sender_email]';
																				$separator     = '<hr />';
																				$message       = '[listar_sender_message]';

																				$listar_private_message_template .= $message_for . $page . $visitor . $visitor_email . $separator . $message;
																			}
																			?>
																			<input type="hidden" name="listar_listing_owner_name" value="<?php echo esc_attr( $listar_listing_owner_name ); ?>" >
																			<input type="hidden" name="listar_listing_owner_email" value="<?php echo esc_attr( $listar_listing_owner_email ); ?>" >
																			<input type="hidden" name="listar_sender_name">
																			<input type="hidden" name="listar_sender_email">
																			<input type="hidden" name="listar_site_name" value="<?php echo esc_attr( get_bloginfo() ); ?>">
																			<input type="hidden" name="listar_listing_title" value="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>">
																			<input type="hidden" name="listar_current_page_link" value="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>">
																			<input type="hidden" name="listar_private_message_subject" value="<?php echo esc_attr( $listar_private_message_subject ); ?>">
																			<input type="hidden" name="listar_private_message_template" value="<?php echo wp_kses( $listar_private_message_template, 'post' ); ?>">
																			<?php wp_nonce_field( 'listar-private-message-nonce', 'listar-private-message-security' ); ?>
																			<textarea name="listar_sender_message" id="listar_sender_message" class="form-control" placeholder="<?php esc_html_e( 'Your Message', 'listar' ); ?>" required></textarea>
																		</div>
																	</div>
																</div>
															</div>
															<!-- Text input (captcha) and Submit Button -->
															<div class="col-sm-12">
																<div class="form-group listar-private-message-submit-wrapper sub">
																	<div class="col-sm-12 inputGroupContainer">
																		<div class="input-group text-right listar-captcha-wrapper">
																			<span class="input-group-addon hidden"><i class="glyphicon glyphicon-check"></i></span>
																			<?php if ( ! $logged ) : ?>  
																				<input type="text" name="listar-private-message-captcha" id="listar-private-message-captcha" placeholder="4 + 1 = ?" class="form-control listar-captcha" required>
																			<?php else : ?>
																				<!-- Dumb field for Bootlint validation (it's not accepting hidden input as form-control) -->
																				<input type="text" name="listar-dump-field" id="listar-dump-field" class="form-control hidden">
																				<input placeholder="4 + 1 = ?" type="hidden" name="listar-private-message-captcha" id="listar-private-message-captcha" value="5" class="listar-captcha">
																			<?php endif; ?>  
																			<button type="submit" name="name" class="listar-iconized-button icon-arrow-right button submit" ><?php esc_html_e( 'Send', 'listar' ); ?></button>
																			<?php $listar_loading_spinner = listar_get_theme_file_uri( '/assets/images/spinner.gif' ); ?>
																			<span class="spinner" style="background-image: url(<?php echo esc_url( $listar_loading_spinner ); ?>);"></span>
																		</div>
																	</div>
															</div>
														</div>
													</form>
													<!-- End Private Message Form -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</p>
				</div>
			</div>
		</div>
		<!-- End Private Message Section -->
		<?php
	}
endif;

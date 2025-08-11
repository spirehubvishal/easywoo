<?php
/**
 * Template part for login/register/recover password popup
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

if ( ! is_user_logged_in() && listar_addons_active() ) :

	$listar_login_background_image = listar_image_url( get_option( 'listar_login_background_image' ), 'listar-cover' );
	$listar_background_image = empty( $listar_login_background_image ) ? '0' : $listar_login_background_image;
	$listar_has_background_image = '0' === $listar_background_image ? 'listar-no-background-image' : '';
	?>

	<!-- Start Login/Register Popup -->
	<div class="listar-login-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
		<!-- Hero image -->
		<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>"></div>
		<!-- Start Login/Register forms -->
		<div class="listar-valign-form-holder listar-login-register-form">
			<div class="text-center listar-valign-form-content">
				<div class="listar-panel-form-wrapper">
					<div class="panel listar-panel-form">
						<?php
						if ( function_exists( 'listar_social_login_output' ) ) :
							listar_social_login_output();
						endif;
						?>
						<div class="panel-heading">
							<div class="listar-login-heading-title">
								<a href="#" class="active listar-login-form-link">
									<?php esc_html_e( 'Sign In', 'listar' ); ?>
								</a>
							</div>

							<?php if ( get_option( 'users_can_register' ) && ! is_user_logged_in() ) : ?>
								<div class="listar-register-heading-title">
									<a href="#" class="listar-register-form-link">
										<?php esc_html_e( 'Register', 'listar' ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
						<div class="panel-body">
							<div>
								<div>
									<?php
									/* Registration form - 'Listar Add-ons' plugin */
									if ( get_option( 'users_can_register' ) && ! is_user_logged_in() ) :
										do_action( 'listar_user_register_form' );
									endif;

									if ( ! is_user_logged_in() ) :

										/* Login form - 'Listar Add-ons' plugin */
										do_action( 'listar_user_login_form' );

										/* Reset password form - 'Listar Add-ons' plugin */
										do_action( 'listar_reset_pass_form' );
										?>
										<div class="listar-loading-login">
											<p>
												<i class="fa fa-refresh fa-spin"></i><br />
												<?php esc_html_e( 'Loading...', 'listar' ); ?>
											</p>
										</div>
										<?php
									else :
										?>
										<h4>
											<?php esc_html_e( 'User already is logged in.', 'listar' ); ?>
										</h4><br />
										<a href="<?php echo esc_url( network_site_url( '/' ) ); ?>">
											<?php esc_html_e( 'Go to Homepage', 'listar' ); ?>
										</a>
										<?php
									endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Login/Register forms -->
	</div>
	<!-- End Login/Register Popup -->
	<?php
endif;

<?php
/**
 * Actions to enable custom Ajax login/registration forms
 *
 * @package Listar_Addons
 */

add_action( 'listar_user_registration_forms_init', 'listar_user_registration_forms' );

if ( ! function_exists( 'listar_user_registration_forms' ) ) :
	/**
	 * Sets Ajax user registration forms.
	 *
	 * @since 1.0
	 */
	function listar_user_registration_forms() {

		/* Login */
		add_action( 'wp_ajax_nopriv_listar_login_member', 'listar_login_member' );

		/* Register */
		add_action( 'wp_ajax_nopriv_listar_register_member', 'listar_register_member' );

		/* Reset password */
		add_action( 'wp_ajax_nopriv_listar_reset_password', 'listar_reset_password' );
	}
endif;


/**
 * Actions to output every form
 */

/* User login form output */
add_action( 'listar_user_login_form', 'listar_user_login_form_output' );

/* User register form output */
add_action( 'listar_user_register_form', 'listar_user_register_form_output' );

/* Reset password form output */
add_action( 'listar_reset_pass_form', 'listar_reset_pass_form_output' );


if ( ! function_exists( 'listar_login_member' ) ) :
	/**
	 * Ajax user login - Get POST data from a login attempt and check if it is valid to log in.
	 *
	 * @since 1.0
	 */
	function listar_login_member() {

		$nonce      = filter_input( INPUT_POST, 'login-security', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$user_login = '';
		$user_pass  = '';
		$remember   = '';
		$output     = '';

		/* Nonce verification */
		if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ajax-login-nonce' ) ) :
			$user_login = isset( $_POST['listar_user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_user_login'] ) ) : '';
			$user_pass  = isset( $_POST['listar_user_pass'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_user_pass'] ) ) : '';
			$remember   = isset( $_POST['listar_remember_login'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_remember_login'] ) ) : '';
		endif;

		/* Check CSRF token */
		if ( ! check_ajax_referer( 'ajax-login-nonce', 'login-security', false ) ) {
			$output .= wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Session token has expired, please reload the page and try again', 'listar' ) . '</div>' ),
				)
			);
		} elseif ( empty( $user_login ) || empty( $user_pass ) ) {
			$output .= wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Please fill all form fields', 'listar' ) . '</div>' ),
				)
			);
		} else {
			/* Now we can insert this account */
			$credentials = array(
				'user_login'    => $user_login,
				'user_password' => $user_pass,
				'remember'      => $remember,
			);

			$user = wp_signon( $credentials, false );
			$user_login_attempt = $user;
			$secure_cookie = is_ssl();

			if ( is_wp_error( $user_login_attempt ) ) {
				$output .= wp_json_encode(
					array(
						'error'   => true,
						'message' => htmlentities( '<div class="alert alert-danger">' . $user_login_attempt->get_error_message() . '</div>' ),
					)
				);
			}

			if ( $secure_cookie ) {
				$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $credentials );
				add_filter( 'authenticate', 'wp_authenticate_cookie', 30, 3 );

				$user = wp_authenticate( $credentials['user_login'], $credentials['user_password'] );
				wp_set_auth_cookie( $user->ID, $credentials['remember'], $secure_cookie );
				do_action( 'wp_login', $user->user_login, $user );
			}

			if ( ! is_wp_error( $user_login_attempt ) ) {
				wp_set_current_user( $user_login_attempt->ID );

				$output .= wp_json_encode(
					array(
						'error'   => false,
						'message' => htmlentities( '<div class="alert alert-success">' . esc_html__( 'You are logged in.', 'listar' ) . '<br>' . esc_html__( 'Reloading page...', 'listar' ) . '</div>' ),
					)
				);
			}
		}

		echo wp_kses( $output, 'listar-basic-html' );

		listar_close_section();
		die();
	}

endif;

if ( ! function_exists( 'listar_register_member' ) ) :
	/**
	 * Ajax user registration - Get POST data after a user registration attempt and check if it is valid.
	 *
	 * @since 1.0
	 */
	function listar_register_member() {

		$nonce       = filter_input( INPUT_POST, 'register-security', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$user_login  = '';
		$user_email  = '';
		$user_pass   = '';

		/* Nonce verification */
		if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ajax-login-nonce' ) ) :
			$user_login = isset( $_POST['listar_user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_user_login'] ) ) : '';
			$user_email = isset( $_POST['listar_user_email'] ) ? sanitize_email( wp_unslash( $_POST['listar_user_email'] ) ) : '';
			/* Random secure pass by WordPress */
			$user_pass  = wp_generate_password();
		endif;

		/* Check CSRF token */
		if ( ! check_ajax_referer( 'ajax-login-nonce', 'register-security', false ) ) {

			echo wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Session token has expired, please reload the page and try again', 'listar' ) . '</div>' ),
				)
			);

			listar_close_section();
			die();

		} elseif ( empty( $user_login ) || empty( $user_email ) || empty( $user_pass ) ) {

			/* If any required input variables is empty */
			echo wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Please fill all form fields', 'listar' ) . '</div>' ),
				)
			);

			listar_close_section();
			die();
		}

		$errors = wp_create_user( $user_login, $user_pass, $user_email );

		if ( ! is_int( $errors ) ) {

			$registration_error_messages = $errors->errors;
			$display_errors = '<div class="alert alert-danger">';

			foreach ( $registration_error_messages as $error ) {
				$display_errors .= '<p>' . $error[0] . '</p>';
			}

			$display_errors .= '</div>';

			echo wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( wp_kses( $display_errors, 'listar-basic-html' ) ),
				)
			);
		} else {

			/* No error, it returns the new user ID */
			$user_id = $errors;

			/* Activation hyperlink, so the user can set his own password right on first access */
			$current_url = isset( $_POST['listar_current_url'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_current_url'] ) ) : network_site_url();

                        /* Fix current URL for single listings */

                        if ( false !== strpos( $current_url, 'page&job_listing' ) && false !== strpos( $current_url, '?' ) ) {
                                $temp = explode( '?', $current_url );
                                $current_url = $temp[0];
                        }

			$activation_hyperlink = listar_user_activation_url( $user_id );
			$login_url = '<strong><a target="_blank" href="' . esc_url( $current_url . '#do-login' ) . '">' . esc_html__( 'Click here to login', 'listar' ) . '</a></strong>';
			$home_url = network_site_url();

                        if ( false === strpos( $activation_hyperlink, 'redirect_to' ) ) {
                               $activation_hyperlink = str_replace( 'login=', 'redirect_to=' . urlencode( $current_url ) . '&amp;login=', $activation_hyperlink );
                        }

			/* Headers to registration email notification */
			$listar_smtp_options = get_option( 'swpsmtp_options' );
			$listar_wp_mail_smtp_options = get_option( 'wp_mail_smtp' );
			$from_name = esc_html( get_bloginfo( 'name' ) );
			$site_desc = esc_html( get_bloginfo( 'description' ) );
			$from = sanitize_email( get_option( 'admin_email' ) );
	
			if ( ! empty( $listar_wp_mail_smtp_options ) ) {
				$from = isset( $listar_wp_mail_smtp_options['mail']['from_email'] ) ? $listar_wp_mail_smtp_options['mail']['from_email'] : '';
				$from_name = isset( $listar_wp_mail_smtp_options['from_name'] ) ? $listar_wp_mail_smtp_options['from_name'] : '';
			} else if ( ! empty( $listar_smtp_options ) ) {
				$from = isset( $listar_smtp_options['from_email_field'] ) ? $listar_smtp_options['from_email_field'] : '';
				$from_name = isset( $listar_smtp_options['from_name_field'] ) ? $listar_smtp_options['from_name_field'] : '';
			}
			
			$email_headers  = "From: $from_name <$from>\r\n";
			$email_headers .= "X-Sender: $from_name <$from>\r\n";
			$email_headers .= "Reply-To: $from_name <$from>\r\n";
			$email_headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
			$email_headers .= "X-Priority: 1\r\n"; /* Urgent message! */
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset='UTF-8'\r\n";
			
			$subject = wp_unslash( esc_html( trim( get_option( 'listar_user_registration_message_subject' ) ) ) );
			
			if ( empty( $subject ) ) {
				$suffix  = esc_html__( 'User Registration', 'listar' );
				$subject = '[listar_username] - ' . $suffix . ' - [listar_site_name]';
			}
			
			if ( ! empty( $subject ) ) {
				$search = array(
					'[listar_username]',
					'[listar_site_name]',
				);
				
				$replace = array(
					$user_login,
					$from_name,
				);
				
				$subject = str_replace( $search, $replace, $subject );
			}

			/* Second notification test */
			$message  = wp_kses( wp_unslash( trim( get_option( 'listar_user_registration_message_template' ) ) ), 'post' );
			
			if ( empty( $message ) ) {
				$page_prefix        = esc_html__( 'Page', 'listar' );
				$email_prefix       = esc_html__( 'Email', 'listar' );
				$user_prefix        = esc_html__( 'Username', 'listar' );
				$pass_prefix        = esc_html__( 'Password', 'listar' );
				$line_break         = '<br>';
				$separator          = '<hr />';
				$message = '';

				$header        = '<h3>' . strtoupper( esc_html__( 'User Registration', 'listar' ) ) . '</h3>';
				$subtitle      = '<strong>[listar_site_name] - [listar_site_description]</strong>';
				$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
				$email         = '<strong>' . $email_prefix . ':</strong> [listar_login_email]' . $line_break;
				$user          = '<strong>' . $user_prefix . ':</strong> [listar_username]' . $line_break;
				$password      = '<strong>' . $pass_prefix . ':</strong> [listar_password]';
				$footer        = '<br><br>[listar_do_login_link]';
				$footer2       = '<strong>' . esc_html__( 'To set a new password, visit the following address:', 'listar' ) . '</strong> [listar_wp_password_change_link]';

				$message .= $header . $line_break . $subtitle . $separator . $page . $email . $user . $password . $separator . $footer2 . $separator . $footer;
			}
			
			if ( ! empty( $message ) ) {
				$search = array(
					'[listar_username]',
					'[listar_password]',
					'[listar_login_email]',
					'[listar_site_name]',
					'[listar_site_description]',
					'[listar_site_link]',
					'[listar_current_page_link]',
					'[listar_do_login_link]',
					'[listar_wp_password_change_link]',
					"\n",
				);
				
				$replace = array(
					$user_login,
					$user_pass,
					$user_email,
					$from_name,
					$site_desc,
					$home_url,
					$current_url,
					$login_url,
					$activation_hyperlink,
					'<br/>',
				);
				
				$message = str_replace( $search, $replace, $message );
			}
			
			$message_formatted = stripslashes( $message );

			/* Send login credentials to user */
			wp_mail(
				$user_email,
				$subject,
				$message_formatted,
				$email_headers
			);

			/* Success registration message */
			echo wp_json_encode(
				array(
					'error'   => false,
					'message' => htmlentities( '<div class="alert alert-success">' . esc_html__( 'New user registered, please check the login credentials sent to your email.', 'listar' ) . '</div>' ),
				)
			);

			exit;

		} // End if().

		listar_close_section();
		die();
	}

endif;

if ( ! function_exists( 'listar_reset_password' ) ) :
	/**
	 * Ajax reset password - Get POST data from after password reset attempt and check if it is valid.
	 *
	 * @since 1.0
	 */
	function listar_reset_password() {

		$nonce  = filter_input( INPUT_POST, 'password-security', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$output = '';
		$user_name_or_email = '';

		/* Nonce verification */
		if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ajax-login-nonce' ) ) :
			$user_name_or_email = isset( $_POST['listar_user_or_email'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_user_or_email'] ) ) : '';
		endif;

		/* Check CSRF token */
		if ( ! check_ajax_referer( 'ajax-login-nonce', 'password-security', false ) ) {
			$output .= wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Session token has expired, please reload the page and try again', 'listar' ) . '</div>' ),
				)
			);
		} elseif ( empty( $user_name_or_email ) ) {

			/* If login field is empty */
			$output .= wp_json_encode(
				array(
					'error'   => true,
					'message' => htmlentities( '<div class="alert alert-danger">' . esc_html__( 'Please fill all form fields', 'listar' ) . '</div>' ),
				)
			);
		} else {

			$user_name = is_email( $user_name_or_email ) ? sanitize_email( $user_name_or_email ) : sanitize_user( $user_name_or_email );
			$user_forgotten = listar_lost_password_retrieve( $user_name );

			if ( is_wp_error( $user_forgotten ) ) {

				$lostpass_error_messages = $user_forgotten->errors;
				$display_errors = '<div class="alert alert-warning">';

				foreach ( $lostpass_error_messages as $error ) {
					$display_errors .= '<p>' . $error[0] . '</p>';
				}

				$display_errors .= '</div>';

				$output .= wp_json_encode(
					array(
						'error'   => true,
						'message' => htmlentities( $display_errors ),
					)
				);
			} else {

				$output .= wp_json_encode(
					array(
						'error'   => false,
						'message' => htmlentities( '<p class="alert alert-success">' . esc_html__( 'Please check your email to reset your password.', 'listar' ) . '</p>' ),
					)
				);
			}
		} // End if().

		echo wp_kses( $output, 'listar-basic-html' );

		listar_close_section();
		die();
	}

endif;


if ( ! function_exists( 'listar_lost_password_retrieve' ) ) :
	/**
	 * Ajax lost password retrieve - Allow to reset a user password after data verifications.
	 *
	 * @since 1.0
	 * @param (string) $user_data Text submited by the user, it can be an username or email.
	 * @return (bool|object)
	 */
	function listar_lost_password_retrieve( $user_data ) {

		global $wpdb, $wp_hasher;

		$errors = new WP_Error();

		if ( empty( $user_data ) ) {

			$errors->add( 'empty_username', esc_html__( 'Please enter a username or email address.', 'listar' ) );

		} elseif ( strpos( $user_data, '@' ) ) {

			$user_data = get_user_by( 'email', trim( $user_data ) );

			if ( empty( $user_data ) ) {
				$errors->add( 'invalid_email', esc_html__( 'There is no user registered with that email address.', 'listar' ) );
			}
		} else {
			$login = trim( $user_data );
			$user_data = get_user_by( 'login', $login );
		}

		if ( $errors->get_error_code() ) {
			return $errors;
		}

		if ( ! $user_data ) {
			$errors->add( 'invalidcombo', esc_html__( 'Invalid username or email.', 'listar' ) );
			return $errors;
		}

		$user_login = sanitize_user( $user_data->user_login );
		$user_email = sanitize_email( $user_data->user_email );

		do_action( 'retrieve_password', $user_login );

		$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

		if ( ! $allow ) {
			return new WP_Error( 'no_password_reset', esc_html__( 'Password reset is not allowed for this user', 'listar' ) );
		} elseif ( is_wp_error( $allow ) ) {
			return $allow;
		}

		$key = wp_generate_password( 20, false );

		do_action( 'retrieve_password_key', $user_login, $key );

		$temp_wp_hasher = $wp_hasher;

		if ( empty( $temp_wp_hasher ) ) {
			require_once ABSPATH . 'wp-includes/class-phpass.php';
			$temp_wp_hasher = new PasswordHash( 8, true );
		}

		$hashed = $temp_wp_hasher->HashPassword( $key );

		$the_key = array(
			'user_activation_key' => $hashed,
		);

		$the_user_login = array(
			'user_login' => $user_login,
		);

		$wpdb->update( $wpdb->users, $the_key, $the_user_login );

		$admin_email    = sanitize_email( get_option( 'new_admin_email' ) );
		$adm_email      = sanitize_email( empty( $admin_email ) ? get_option( 'admin_email' ) : $admin_email );
		$site_name      = esc_html( get_bloginfo( 'name' ) );
		$site_desc      = esc_html( get_bloginfo( 'description' ) );
		$reset_url      = listar_user_activation_url( $user_data->ID );
		$site_url       = esc_url( network_site_url( '/' ) );

                /* Activation hyperlink, so the user can set his own password right on first access */
                $current_url = isset( $_POST['listar_current_url'] ) ? sanitize_text_field( wp_unslash( $_POST['listar_current_url'] ) ) : network_site_url();

                /* Fix current URL for single listings */

                if ( false !== strpos( $current_url, 'page&job_listing' ) && false !== strpos( $current_url, '?' ) ) {
                        $temp = explode( '?', $current_url );
                        $current_url = $temp[0];
                }

                if ( false === strpos( $reset_url, 'redirect_to' ) ) {
                       $reset_url = str_replace( 'login=', 'redirect_to=' . urlencode( $current_url ) . '&amp;login=', $reset_url );
                }
		
		$listar_smtp_options = get_option( 'swpsmtp_options' );
		$listar_wp_mail_smtp_options = get_option( 'wp_mail_smtp' );

		if ( ! empty( $listar_wp_mail_smtp_options ) ) {
			$adm_email = isset( $listar_wp_mail_smtp_options['mail']['from_email'] ) ? $listar_wp_mail_smtp_options['mail']['from_email'] : '';
			$site_name = isset( $listar_wp_mail_smtp_options['from_name'] ) ? $listar_wp_mail_smtp_options['from_name'] : '';
		} else if ( ! empty( $listar_smtp_options ) ) {
			$adm_email = isset( $listar_smtp_options['from_email_field'] ) ? $listar_smtp_options['from_email_field'] : '';
			$site_name = isset( $listar_smtp_options['from_name_field'] ) ? $listar_smtp_options['from_name_field'] : '';
		}

                /* Fix current URL for single listings */

                if ( false !== strpos( $current_url, 'page&job_listing' ) && false !== strpos( $current_url, '?' ) ) {
                        $temp = explode( '?', $current_url );
                        $current_url = $temp[0];
                }

		$login_url = '<br><br><strong><a target="_blank" href="' . esc_url( $current_url . '#do-login' ) . '">' . esc_html__( 'Click here to login', 'listar' ) . '</a></strong>';

		$subject = wp_unslash( esc_html( trim( get_option( 'listar_user_password_recover_message_subject' ) ) ) );

		if ( empty( $subject ) ) {
			$suffix  = esc_html__( 'Password Recovering', 'listar' );
			$subject = '[listar_username] - ' . $suffix . ' - [listar_site_name]';
		}

		if ( ! empty( $subject ) ) {
			$search = array(
				'[listar_username]',
				'[listar_site_name]',
			);

			$replace = array(
				$user_login,
				$site_name,
			);

			$subject = apply_filters( 'retrieve_password_title', str_replace( $search, $replace, $subject ) );
		}

		/* Second notification test */
		$message  = wp_unslash( trim( get_option( 'listar_user_password_recover_message_template' ) ) );
		
		if ( ! empty( $message ) && is_string( $message ) ) {
			$message  = wp_kses( trim( $message ), 'post' );
		} else {
			$page_prefix        = esc_html__( 'Page', 'listar' );
			$email_prefix       = esc_html__( 'Email', 'listar' );
			$user_prefix        = esc_html__( 'Username', 'listar' );
			$line_break         = '<br>';
			$separator          = '<hr />';

			$header        = '<h3>' . strtoupper( esc_html__( 'Password Recovering', 'listar' ) ) . '</h3>';
			$subtitle      = '<strong>[listar_site_name] - [listar_site_description]</strong>';
			$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
			$email         = '<strong>' . $email_prefix . ':</strong> [listar_login_email]' . $line_break;
			$user          = '<strong>' . $user_prefix . ':</strong> [listar_username]';
			$footer        = '<strong>' . esc_html__( 'To set a new password, visit the following address:', 'listar' ) . '</strong> [listar_wp_password_change_link]';

			$message = $header . $line_break . $subtitle . $separator . $page . $email . $user . $separator . $footer;
		}

		if ( ! empty( $message ) ) {
			$search = array(
				'[listar_username]',
				'[listar_login_email]',
				'[listar_site_name]',
				'[listar_site_description]',
				'[listar_site_link]',
				'[listar_current_page_link]',
				'[listar_do_login_link]',
				'[listar_wp_password_change_link]',
				"\n",
			);

			$replace = array(
				$user_login,
				$user_email,
				$site_name,
				$site_desc,
				$site_url,
				$current_url,
				$login_url,
				$reset_url,
				'<br/>',
			);

			$message = apply_filters( 'retrieve_password_message', str_replace( $search, $replace, $message ) );
		}

		$message_formatted = stripslashes( $message );

		$email_headers  = "From: $site_name <$adm_email>\r\n";
		$email_headers .= "X-Sender: $site_name <$adm_email>\r\n";
		$email_headers .= "Reply-To: $site_name <$adm_email>\r\n";
		$email_headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$email_headers .= "X-Priority: 1\r\n";
		$email_headers .= "MIME-Version: 1.0\r\n";
		$email_headers .= "Content-Type: text/html; charset='UTF-8'\r\n";

		if ( $message_formatted && ! wp_mail( $user_email, $subject, $message_formatted, $email_headers ) ) {
			$errors->add( 'noemail', esc_html__( 'The email could not be sent. Possible reason: your host may have disabled the mail() function.', 'listar' ) );
			return $errors;
		}

		return true;
	}

endif;

if ( ! function_exists( 'listar_user_login_form_output' ) ) :
	/**
	 * User login form output.
	 *
	 * @since 1.0
	 */
	function listar_user_login_form_output() {
		global $wp;
		
		$current_url = '';
		$query_args  = isset( $wp->query_vars ) && ! empty( $wp->query_vars ) ? $wp->query_vars : '';
		$wp_request  = isset( $wp->request ) && ! empty( $wp->request ) ? $wp->request : '';
		
		if ( ! empty( $query_args ) ) {
			$current_url = add_query_arg( $query_args, network_site_url( $wp_request ) );
		} else {
			$current_url = network_site_url( $wp_request );
		}
		?>
		<!-- Login form -->
		<div class="listar-login">
			<form id="listar-login-form" action="<?php echo esc_url( network_site_url( '/' ) ); ?>" method="post">
				<div class="form-field">
					<input class="form-control input-lg required" name="listar_user_login" type="text" placeholder="<?php esc_attr_e( 'Username', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input class="form-control input-lg required" name="listar_user_pass" id="listar_user_pass" type="password" placeholder="<?php esc_attr_e( 'Password', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<?php
					$terms_enabled = 1 === (int) get_option( 'listar_accept_signup_terms_enabled' );

					if ( $terms_enabled ) {
						$terms_url = get_option( 'listar_signup_terms_url' );
						?>
						<label for="listar_terms_checkbox" class="listar-remember-label listar-custom-checkbox">
							<input name="listar_terms_checkbox" class="d-hidden" type="checkbox" id="listar_terms_checkbox" value="yes" required>
							<?php
							if ( ! empty( $terms_url ) ) {

								$listar_kses_tags = array(
									'a' => array(
										'href'   => array(),
										'target' => array(),
									),
								);
						
								printf(
									/* TRANSLATORS: %s: Terms and Conditions URL */
									wp_kses( __( 'I accept the <a href="%s">Terms and Conditions</a>', 'listar' ), $listar_kses_tags ),
									$terms_url
								);
							} else {
								esc_html_e( 'I accept the terms and conditions', 'listar' );
							}
							?>
						</label>
						<div class="listar-clear-both"></div>		
						<?php
					}
					?>
					<label for="listar_remember_login" class="listar-remember-label">
						<input name="listar_remember_login" type="checkbox" id="listar_remember_login" value="forever" /> <?php esc_html_e( 'Remember me', 'listar' ); ?>
					</label>
					<a href="#" class="listar-reset-pass-button">
						<?php esc_html_e( 'Lost password', 'listar' ); ?>
					</a>
					<div class="listar-clear-both"></div>
				</div>
				<div class="form-field">
					<input type="hidden" name="action" value="listar_login_member"/>
					<button class="btn btn-theme btn-lg" data-loading-text="<?php esc_attr_e( 'Loading...', 'listar' ); ?>" type="submit">
						<?php esc_html_e( 'Log In', 'listar' ); ?>
					</button>
				</div>
				<input type="hidden" name="listar_current_url" value="<?php echo esc_url( $current_url ); ?>"/>
				<?php wp_nonce_field( 'ajax-login-nonce', 'login-security' ); ?>
			</form>
			<div class="listar-errors"></div>
		</div>
		<?php
	}

endif;

if ( ! function_exists( 'listar_user_register_form_output' ) ) :
	/**
	 * User registtration form output.
	 *
	 * @since 1.0
	 */
	function listar_user_register_form_output() {
		global $wp;
		
		$current_url = '';
		$query_args  = isset( $wp->query_vars ) && ! empty( $wp->query_vars ) ? $wp->query_vars : '';
		$wp_request  = isset( $wp->request ) && ! empty( $wp->request ) ? $wp->request : '';
		
		if ( ! empty( $query_args ) ) {
			$current_url = add_query_arg( $query_args, network_site_url( $wp_request ) );
		} else {
			$current_url = network_site_url( $wp_request );
		}
		?>
		<!-- Register form -->
		<div class="listar-register">
			<form id="listar-registration-form" action="<?php echo esc_url( network_site_url( '/' ) ); ?>" method="POST">
				<div class="form-field">
					<input class="form-control input-lg required" name="listar_user_login" type="text" placeholder="<?php esc_attr_e( 'Username', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input class="form-control input-lg required" name="listar_user_email" id="listar_user_email" type="email" placeholder="<?php esc_attr_e( 'Email', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input type="hidden" name="action" value="listar_register_member"/>
					<button class="btn btn-theme btn-lg" data-loading-text="<?php esc_attr_e( 'Loading...', 'listar' ); ?>" type="submit">
						<?php esc_html_e( 'Sign up', 'listar' ); ?>
					</button>
				</div>
				<input type="hidden" name="listar_current_url" value="<?php echo esc_url( $current_url ); ?>"/>
				<?php wp_nonce_field( 'ajax-login-nonce', 'register-security' ); ?>
			</form>
			<div class="listar-errors"></div>
		</div>
		<?php
	}

endif;

if ( ! function_exists( 'listar_reset_pass_form_output' ) ) :
	/**
	 * Reset password form output.
	 *
	 * @since 1.0
	 */
	function listar_reset_pass_form_output() {
		global $wp;
		
		$current_url = '';
		$query_args  = isset( $wp->query_vars ) && ! empty( $wp->query_vars ) ? $wp->query_vars : '';
		$wp_request  = isset( $wp->request ) && ! empty( $wp->request ) ? $wp->request : '';
		
		if ( ! empty( $query_args ) ) {
			$current_url = add_query_arg( $query_args, network_site_url( $wp_request ) );
		} else {
			$current_url = network_site_url( $wp_request );
		}
		?>
		<!-- Lost Password form -->
		<div class="listar-reset-password">
			<form id="listar-reset-password-form" action="<?php echo esc_url( network_site_url( '/' ) ); ?>" method="post">
				<div class="form-field">
					<input class="form-control input-lg required" name="listar_user_or_email" id="listar_user_or_email" type="text" placeholder="<?php esc_attr_e( 'Username or email', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input type="hidden" name="action" value="listar_reset_password"/>
					<button class="btn btn-theme btn-lg" data-loading-text="<?php esc_attr_e( 'Loading...', 'listar' ); ?>" type="submit">
						<?php esc_html_e( 'Get new password', 'listar' ); ?>
					</button>
				</div>
				<input type="hidden" name="listar_current_url" value="<?php echo esc_url( $current_url ); ?>"/>
				<?php wp_nonce_field( 'ajax-login-nonce', 'password-security' ); ?>
			</form>
			<div class="listar-errors"></div>
		</div>
		<?php
	}

endif;

/* Auto login after a password reset */

add_action( 'validate_password_reset', 'listar_autologin_after_password_reset', 10, 2 );
function listar_autologin_after_password_reset($errors, $user) {
        global $rp_cookie, $rp_path, $wp_query;

        if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
                reset_password( $user, $_POST['pass1'] );


                /* Now we can insert this account */
                $credentials = array(
                        'user_login'    => $user->user_login,
                        'user_password' => $_POST['pass1'],
                        'remember'      => '1',
                );

                $user = wp_signon( $credentials, false );
                $user_login_attempt = $user;
                $secure_cookie = is_ssl();

                if ( is_wp_error( $user_login_attempt ) ) {
                        exit;
                }

                if ( $secure_cookie ) {
                        $session_main_key = 'listar_user_search_options';
                        $redirect = network_site_url();
                        $secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $credentials );
                        add_filter( 'authenticate', 'wp_authenticate_cookie', 30, 3 );

                        $user = wp_authenticate( $credentials['user_login'], $credentials['user_password'] );
                        wp_set_auth_cookie( $user->ID, $credentials['remember'], $secure_cookie );
                        do_action( 'wp_login', $user->user_login, $user );

                        if ( ! isset( $_SESSION[ $session_main_key ] ) || ! isset( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) || empty( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) ) {
                                listar_register_sessions( $wp_query, true );
                        }                        

                        if ( isset( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) && ! empty( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) ) {
                               $redirect = $_SESSION[ $session_main_key ]['listar_last_url_visited'];
                        }

                        wp_redirect( $redirect );                        
                        exit;
                }
        }
}

add_filter( 'login_site_html_link', 'listar_custom_login_site_html_link' );

function listar_custom_login_site_html_link() {
        global $wp_query;

        $session_main_key = 'listar_user_search_options';
        $redirect = network_site_url();

        if ( ! isset( $_SESSION[ $session_main_key ] ) || ! isset( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) || empty( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) ) {
                listar_register_sessions( $wp_query, true );
        }                        

        if ( isset( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) && ! empty( $_SESSION[ $session_main_key ]['listar_last_url_visited'] ) ) {
               $redirect = $_SESSION[ $session_main_key ]['listar_last_url_visited'];
        }

        $html_link = sprintf(
                '<a href="%s">%s</a>',
                $redirect,
                sprintf(
                        /* translators: %s: Site title. */
                        _x( '&larr; Go to %s', 'site' ),
                        get_bloginfo( 'title', 'display' )
                )
        );

        return $html_link;
}
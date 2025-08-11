<?php
/**
 * Functions in general for this plugin
 *
 * @package Listar_Addons
 */

/* Function to detect Listar Addons activation ********************************/

if ( ! function_exists( 'listar_addons_active' ) ) :
	/**
	 * Check if the Listar Addons plugin is currently active.
	 *
	 * @since 1.3.8
	 * @return (boolean)
	 */
	function listar_addons_active() {
		return defined( 'LISTAR_ADDONS_ACTIVE' );
	}
endif;

/*
 * Sanitization functions ******************************************************
 */

if ( ! function_exists( 'listar_sanitize_string' ) ) :
	function listar_sanitize_string($value) {
		return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
endif;

/**
 * Sanitize social network URLs.
 *
 * @since 1.0
 * @param (string) $input A user URL or username for a social network.
 * @param (string) $network_url The website URL for a social network.
 * @return (string) $output A complete user URL for a social network, sanitized.
 */
function listar_sanitize_social_url( $input, $network_url ) {

	$search = array(
		'@',
		' ',
		'www.',
		'http://',
		'https://',
	);

	$output = str_replace( $search, '', wp_filter_nohtml_kses( $input ) );

	if ( false === ! strpos( $input, '.com' ) ) {
		$str    = str_replace( '.com/', '', strstr( $output, '.com' ) );
		$output = str_replace( '.com', '', $str );
	}

	/* If first char is '/', remove it */
	if ( '/' === substr( $output, 0, 1 ) ) {
		$output = substr( $output, 1 );
	}

	/* If last char is '/', remove it */
	if ( '/' === substr( $output, -1 ) ) {
		$output = substr( $output, 0, -1 );
	}

	if ( ! empty( $output ) ) {
		$output = $network_url . '/' . $output;
	}

	return $output;
}

/**
 * Helper function to sanitize a Facebook URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Facebook.
 * @return (string) A complete user URL for Facebook, sanitized.
 */
function listar_sanitize_facebook( $input ) {

	return listar_sanitize_social_url( $input, 'https://facebook.com' );
}

/**
 * Helper function to sanitize a Twitter URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Twitter.
 * @return (string) A complete user URL for Twitter, sanitized.
 */
function listar_sanitize_twitter( $input ) {

	return listar_sanitize_social_url( $input, 'https://twitter.com' );
}

/**
 * Helper function to sanitize a Instagram URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Instagram.
 * @return (string) A complete user URL for Instagram, sanitized.
 */
function listar_sanitize_instagram( $input ) {

	return listar_sanitize_social_url( $input, 'https://instagram.com' );
}

/**
 * Helper function to sanitize a Linkedin URL.
 *
 * @since 1.3.4
 * @param (string) $input A user URL for username to Linkedin.
 * @return (string) A complete user URL for Linkedin, sanitized.
 */
function listar_sanitize_linkedin( $input ) {

	$output = listar_sanitize_social_url( $input, 'https://linkedin.com' );
	
	// Is nickname?
	if ( ! empty( $input ) && false === strpos( $input, '/' ) ) {
		if ( ! empty( $output ) && false !== strpos( $output, '.com/' ) ) {
			$output = str_replace( '.com/', '.com/in/', $output );
		}
	}

	return $output;
}

/**
 * Helper function to sanitize a Pinterest URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Pinterest.
 * @return (string) A complete user URL for Pinterest, sanitized.
 */
function listar_sanitize_pinterest( $input ) {

	return listar_sanitize_social_url( $input, 'https://pinterest.com' );
}

/**
 * Helper function to sanitize a Youtube URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Youtube.
 * @return (string) A complete user URL for Youtube, sanitized.
 */
function listar_sanitize_youtube( $input ) {

	$output = listar_sanitize_social_url( $input, 'https://youtube.com' );

	if ( ! empty( $output ) && false === strpos( $output, 'user/' ) && false === strpos( $output, 'watch' ) && false === strpos( $output, 'channel' ) ) {
		$output = str_replace( '.com/', '.com/user/', $output );
	}

	return $output;
}

/**
 * Helper function to sanitize a Twitch URL.
 *
 * @since 1.5.0
 * @param (string) $input A user URL for username to Twitch.
 * @return (string) A complete user URL for Twitch, sanitized.
 */
function listar_sanitize_twitch( $input ) {
	$output = listar_sanitize_social_url( $input, 'https://www.twitch.tv' );
	return ! empty( $output ) ? str_replace( '@', '', $output ) : $output;
}

/**
 * Helper function to sanitize a Tiktok URL.
 *
 * @since 1.5.0
 * @param (string) $input A user URL for username to Tiktok.
 * @return (string) A complete user URL for Tiktok, sanitized.
 */
function listar_sanitize_tiktok( $input ) {

	$output = listar_sanitize_social_url( $input, 'https://www.tiktok.com' );

	if ( ! empty( $output ) && false === strpos( $output, '@' ) ) {
		$output = str_replace( '.com/', '.com/@', $output );
	}

	return $output;
}

/**
 * Helper function to sanitize a Snapchat URL.
 *
 * @since 1.5.0
 * @param (string) $input A user URL for username to Snapchat.
 * @return (string) A complete user URL for Snapchat, sanitized.
 */
function listar_sanitize_snapchat( $input ) {
	
	if ( is_string( $input ) ) {
		
		$search = array(
			'www.snapchat.com/add',
			'snapchat.com/add',
		);
		
		$input = str_replace( $search, 'story.snapchat.com', $input );
	}

	$output = listar_sanitize_social_url( $input, 'https://story.snapchat.com' );

	if ( ! empty( $output ) && false === strpos( $output, '.com/add' ) && false === strpos( $output, '@' ) ) {
		$output = str_replace( '.com/', '.com/@', $output );
	}

	return $output;
}


/**
 * Helper function to sanitize a Google+ URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Google+.
 * @return (string) A complete user URL for Google+, sanitized.
 */
function listar_sanitize_googleplus( $input ) {

	$output = listar_sanitize_social_url( $input, 'https://plus.google.com' );

	if ( ! empty( $output ) && false === strpos( $output, '+' ) ) {
		$output = str_replace( '.com/', '.com/+', $output );
	}

	return $output;
}

/**
 * Helper function to sanitize a Youtube video URL.
 *
 * @since 1.0
 * @param (string) $input A video ID or URL for a Youtube video.
 * @return (string) A complete video URL for Youtube, sanitized.
 */
function listar_sanitize_youtube_video( $input ) {

	$output = $input;

	if ( ! empty( $input ) ) {
		$output2 = str_replace( 'youtu.be/', 'youtube.com/watch?v=', $output );

		$output = listar_sanitize_social_url( $output2, 'https://youtube.com' );

		if ( ! empty( $output ) && false === strpos( $output, 'watch?v=' ) ) {
			$output = str_replace( '.com/', '.com/watch?v=', $output );
		}
	}

	return $output;
}

/**
 * Helper function to sanitize a Vimeo URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Vimeo.
 * @return (string) A complete user URL for Vimeo, sanitized.
 */
function listar_sanitize_vimeo( $input ) {

	return listar_sanitize_social_url( $input, 'https://vimeo.com' );
}

/**
 * Helper function to sanitize a VK URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to VK.
 * @return (string) A complete user URL for VK, sanitized.
 */
function listar_sanitize_vk( $input ) {

	return listar_sanitize_social_url( $input, 'https://vk.com' );
}

/**
 * Helper function to sanitize a Foursquare URL.
 *
 * @since 1.0
 * @param (string) $input A user URL for username to Foursquare.
 * @return (string) A complete user URL for Foursquare, sanitized.
 */
function listar_sanitize_foursquare( $input ) {

	return listar_sanitize_social_url( $input, 'https://foursquare.com' );
}

/**
 * Helper function to sanitize a Social Network URL.
 *
 * @since 1.3.4
 * @param (string) $input A user URL or username to the Social Network.
 * @param (string) $domain_name The domain name that must be available on the URL
 * @return (array)
 */
function listar_sanitize_social_url_2( $input, $domain_name ) {
	
	if ( empty( $input ) ) {
		return array( false, '' );
	}

	$domain_name_lower = strtolower( $domain_name );
	$is_url_condition_1 = false;
	$is_url_condition_2 = false;
	
	// URLS must have the expected domain name	
	$url_must_have_or = array(
		'.' . $domain_name_lower,
		'/' . $domain_name_lower,
		$domain_name_lower . '.',
	);

	$url_must_have_and = array(
		'.',
		'/',
	);
	
	$search = array(
		' ',
		'www.',
		'http://',
		'https://',
		'Www.',
		'Http://',
		'Https://',
		'WWW.',
		'HTTP://',
		'HTTPS://',
	);
	
	// Remove special characters from the beginning of the string.
	$first_character = $input[0];
	
	while ( preg_match('/[^a-zA-Z\d]/', $first_character ) ) {

		// First character is special, remove it
		$input = substr( $input, 1); 
		
		$first_character = $input[0];
	}

	/* If last char is '/', remove it */
	if ( '/' === substr( $input, -1 ) ) {
		$input = substr( $input, 0, -1 );
	}
	
	$url_test_lower = strtolower( $input );
	
	if ( 'www.' === substr( $url_test_lower, 0, 4 ) ) {
		$temp_string = str_replace( 'www.', '', $input );
		
		if ( false !== strpos( $temp_string, '.' ) ) {
			$is_url_condition_1 = true;
		}
	} elseif ( 'http://' === substr( $url_test_lower, 0, 7 ) ) {
		$temp_string  = str_replace( 'http://', '', $input );
		$temp_string2 = str_replace( 'www.', '', $temp_string );
		
		if ( false !== strpos( $temp_string2, '.' ) ) {
			$is_url_condition_1 = true;
		}
	} elseif ( 'https://' === substr( $url_test_lower, 0, 8 ) ) {
		$temp_string  = str_replace( 'https://', '', $input );
		$temp_string2 = str_replace( 'www.', '', $temp_string );
		
		if ( false !== strpos( $temp_string2, '.' ) ) {
			$is_url_condition_1 = true;
		}
	}
	
	if ( ! empty( $input ) ) {
		$input = str_replace( $search, '', wp_filter_nohtml_kses( $input ) );
	}
	
	if (
		false !== strpos( $url_test_lower, $url_must_have_and[ 0 ] ) &&
		false !== strpos( $url_test_lower, $url_must_have_and[ 1 ] ) &&
		(
			false !== strpos( $url_test_lower, $url_must_have_or[ 0 ] ) ||
			false !== strpos( $url_test_lower, $url_must_have_or[ 1 ] ) ||
			false !== strpos( $url_test_lower, $url_must_have_or[ 2 ] )
		)
	) {
		$is_url_condition_2 = true;
	}
	
	if ( ! $is_url_condition_2 && ! $is_url_condition_1 ) {

		// This seems a nickname.
		return array( false, $input );
	}
	
	// Seems a valid URL.
	return array( true, 'https://' . $input );
}

/**
 * Helper function to sanitize a TripAdvisor URL.
 *
 * @since 1.3.4
 * @param (string) $input A user URL for username to TripAdvisor.
 * @return (string) A complete user URL for TripAdvisor, sanitized.
 */
function listar_sanitize_tripadvisor( $input ) {

	$temp = listar_sanitize_social_url_2( $input, 'tripadvisor' );
	
	$is_url = $temp[0];
	$output = $temp[1];
	
	// Is it empt
	if ( empty( $output ) ) {
		return '';
	}
	
	// Is nickname?
	if ( ! $is_url ) {
		$output = 'https://www.tripadvisor.com/Profile/' . $output;
	}

	return $output;
}


if ( ! function_exists( 'listar_sanitize_website' ) ) :
	/**
	 * Sanitize website URLs to (http or https)://domain.com.
	 *
	 * @since 1.0
	 * @param (string)  $input Website URL.
	 * @param (boolean) $clean Remove protocol.
	 * @return (string)
	 */
	function listar_sanitize_website( $input, $clean = false ) {

		$output = str_replace( array( ' ', 'www.' ), '', wp_filter_nohtml_kses( $input ) );

		/* If last char is '/', remove it */
		if ( '/' === substr( $output, -1 ) ) {
			$output = substr( $output, 0, -1 );
		}

		if ( false === ! empty( $output ) && strpos( $output, 'http' ) && ! $clean ) {
			$output = 'http://' . $output;
		}

		if ( $clean ) {
			$output = str_replace( array( 'http://', 'https://' ), '', $output );
		}

		return $output;
	}

endif;

/*
 * General functions ***********************************************************
 * Some functions below are duplicated in 'functions.php' file of the 'Listar' theme.
 * This is necessary for both (plugin and theme) to work independently of each other.
 */

if ( ! function_exists( 'listar_url_exists' ) ) :
	/**
	 * Check if a URL exists. It works to absolute (/path/file) and full URLs (http://).
	 *
	 * @since 1.0
	 * @param (string) $url - An absolute or full URL.
	 * @return (bool)
	 */
	function listar_url_exists( $url ) {

		if ( ( '' === $url ) || ( null === $url ) ) {
			return false;
		}

		/* Is it an absolute URL ? */
		if ( false === strpos( $url, '://' ) ) {
			return file_exists( $url ) ? true : false;
		}

		/* If not external file or localhost, test it via absolute path */
		if ( ! listar_is_external( $url ) && false === strpos( $url, '//localhost' ) ) {
			$path_url = wp_parse_url( $url, PHP_URL_PATH );
			$root_url = getcwd();
			$abs_url  = '';

			/* A call to this function during an Ajax query can include wp-admin at end of root path, let's remove it */
			if ( false !== strpos( $root_url, '/wp-admin' ) ) {
				$root_url = substr( $root_url, 0, strpos( $root_url, '/wp-admin' ) );
			}

			/* Check if first character is a slash and remove it */
			$path_url_test = '/' === substr( $path_url, 0, 1 ) ? substr( $path_url, 1 ) : $path_url;

			/* First dir of the file path */
			$path_first_dir = substr( $path_url_test, 0, strpos( $path_url_test, '/' ) );

			/* Last dir of the root path */
			$root_last_dir = substr( substr( $root_url, strrpos( $root_url, '/' ) ), 1 );

			/* If found same dir on both, fix it */
			if ( ! empty( $path_first_dir ) && ! empty( $root_last_dir ) && $path_first_dir === $root_last_dir ) {
				/* Remove last dir */
				$root_url = substr( $root_url, 0, strrpos( $root_url, '/' . $root_last_dir ) );
			}

			$abs_url = $root_url . str_replace( $path_first_dir . '/' . $root_last_dir . '/', '', $path_url );

			$abs_url = str_replace( 'wp-content/plugins/listar-addons/inc/wp-content/uploads', 'wp-content/uploads', $abs_url );

			return file_exists( $abs_url ) ? true : false;
		}

		/*
		 * Not absolute or internal URL
		 *
		 * @link https://stackoverflow.com/questions/7952977/php-check-if-url-and-a-file-exists#answer-13633911
		 */

		$timeout = array(
			'timeout' => 5,
		);

		$response = wp_remote_head( $url, $timeout );
		$accepted_status_codes = array( 200, 301, 302 );

		if ( ! is_wp_error( $response ) && in_array( wp_remote_retrieve_response_code( $response ), $accepted_status_codes, true ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_is_external' ) ) :
	/**
	 * Check if a URL points to external domain.
	 *
	 * @since 1.0
	 * @param (string) $url Link URL.
	 * @return (bool)
	 */
	function listar_is_external( $url ) {

		$host_url  = wp_parse_url( $url, PHP_URL_HOST );
		$path_url  = wp_parse_url( $url, PHP_URL_PATH );
		$host_site = wp_parse_url( network_site_url(), PHP_URL_HOST );
		$path_site = wp_parse_url( network_site_url(), PHP_URL_PATH );
		$url_test  = $host_url . $path_url;
		$site_test = $host_site . $path_site;

		if ( empty( $host_url ) || false === strpos( $url_test, $site_test ) ) {
			/* External URL */
			return true;
		}

		if ( $host_url === $host_site ) {
			/* Internal URL */
			return false;
		} else {
			/* External link */
			return true;
		}
	}

endif;

if ( ! function_exists( 'listar_get_theme_file_uri' ) ) :
	/**
	 * Get theme URI in accord with Envato recommendation, offering better compatibility with child themes.
	 * The generic get_theme_file_uri() function was introduced only in WordPress 4.7,
	 * so this function also guarantee compatibily to lower versions of WordPress.
	 *
	 * @link: https://help.author.envato.com/hc/en-us/articles/360000479946
	 * @link: https://gist.github.com/richtabor/2a1b1175234a30dc7ce75e0a71e536c6
	 * @since 1.0
	 * @param (string) $the_file Path after theme folder, plus file and extension, ex.: '/assets/lib/bootstrap/css/bootstrap.min.css'.
	 * @return (bool)
	 */
	function listar_get_theme_file_uri( $the_file = '' ) {

		$file = ltrim( $the_file, '/' );

		if ( empty( $file ) ) {
			$url = get_stylesheet_directory_uri();
		} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
			$url = get_stylesheet_directory_uri() . '/' . $file;
		} else {
			$url = get_template_directory_uri() . '/' . $file;
		}

		return apply_filters( 'theme_file_uri', $url, $file );
	}

endif;

if ( ! function_exists( 'listar_wp_job_manager_active' ) ) :
	/**
	 * Check if 'WP Job Manager' plugin is active.
	 *
	 * @since 1.0
	 * @return (bool)
	 */
	function listar_wp_job_manager_active() {

		if ( class_exists( 'WP_Job_Manager' ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_third_party_reviews_active' ) ) :
	/**
	 * Check if reviews third party plugin is active.
	 *
	 * @since 1.0
	 * @return (bool)
	 */
	function listar_third_party_reviews_active() {

		if ( class_exists( 'WP_Job_Manager_Reviews' ) ) {
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_is_built_in_reviews_option_disabled' ) ) :
	/**
	 * Check if Listar built in reviews is disabled via theme options.
	 *
	 * @since 1.3.9
	 * @return (bool)
	 */
	function listar_is_built_in_reviews_option_disabled() {
	
		$input = (int) get_option( 'listar_disable_reviews' );
		return ( 1 === $input ? true : false );
	}
endif;

if ( ! function_exists( 'listar_built_in_reviews_active' ) ) :
	/**
	 * Check if Listar built in reviews is active.
	 *
	 * @since 1.3.9
	 * @return (bool)
	 */
	function listar_built_in_reviews_active() {

		if ( class_exists( 'Listar_Reviews_Edit' ) && ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'listar_user_activation_url' ) ) :
	/**
	 * Get URL to change a user password.
	 *
	 * @since 1.0
	 * @param (integer) $user_id ID of the user.
	 * @return (string)
	 */
	function listar_user_activation_url( $user_id ) {

		$user           = new WP_User( (int) $user_id );
		$activation_key = get_password_reset_key( $user );
		$user_login     = sanitize_user( $user->user_login );
		$activation_url = '<a target="_blank" href="' . esc_url( network_site_url( 'wp-login.php?action=rp&key=' . $activation_key . '&login=' . rawurlencode( $user_login ), 'login' ) ) . '">' . esc_url( network_site_url( 'wp-login.php?action=rp&key=' . $activation_key . '&login=' . rawurlencode( $user_login ), 'login' ) ) . '</a>';

		return $activation_url;
	}

endif;

if ( ! function_exists( 'listar_upload_image_script_output' ) ) :
	/**
	 * Outputs JavaScript with dynamic data to handle image uploads of taxonomy terms on WordPress admin.
	 *
	 * @since 1.0
	 * @param (string) $upload_button_css_selector CSS selector to the upload button.
	 * @param (string) $image_wrapper_id ID of the wrapper div that receives the preview image.
	 * @param (string) $value_field_id ID of the form field (hidden) that receives the image ID.
	 */
	function listar_upload_image_script_output( $upload_button_css_selector, $image_wrapper_id, $value_field_id ) {

		$script = "
			/* <![CDATA[ */

				( function( $ ) {

					'use strict';

					$( function() {

						var mediaUploader = 0;

						$( 'body' ).on( 'click', '" . wp_kses( $upload_button_css_selector, 'strip' ) . "', function( e ) {

							var _ = $( this );
							e.preventDefault();
							mediaUploader = 0;

							mediaUploader = wp.media.frames.file_frame = wp.media( {

								title : listarLocalizeAndAjax.selectImage,
								multiple : false,
								button : {
									text : listarLocalizeAndAjax.choose
								}
							} );

							mediaUploader.on( 'select', function() {

								var attachment = mediaUploader.state().get( 'selection' ).first().toJSON();

								if ( attachment.id ) {

									var size = '';
									// Any media size serves as preview, let's prioritize 'medium'
									var attachments = [ attachment.sizes.medium, attachment.sizes.thumbnail, attachment.sizes.large, attachment.sizes.full ];

									for ( var a = 0; a < attachments.length; a++ ) {
										if ( 'undefined' !== typeof attachments[a] ) {
											size = attachments[a];
											break;
										}
									}

									$( '" . wp_kses( $value_field_id, 'strip' ) . "' ).val( attachment.id );
									$( '" . wp_kses( $image_wrapper_id, 'strip' ) . "' ).html( '<img class=\"custom_media_image\" src=\"\" />' );
									$( '" . wp_kses( $image_wrapper_id, 'strip' ) . " .custom_media_image' ).attr( 'src', size.url ).css( 'display', 'block' );
									$( '.ct_tax_media_remove' ).removeClass( 'hidden' );
								}
							} );

							mediaUploader.open();

						} );

						$( 'body' ).on( 'click', '.ct_tax_media_remove', function() {
							$( '" . wp_kses( $value_field_id, 'strip' ) . "' ).val( '' );
							$( '" . wp_kses( $image_wrapper_id, 'strip' ) . "' ).html( '<img class=\"custom_media_image\" src=\"\" />' );
							$( this ).addClass( 'hidden' );
						} );

					} );

				} )( jQuery );

			/* ]]> */
		";

		wp_add_inline_script( 'jquery-ui-core', $script );
	}

endif;

if ( ! function_exists( 'listar_term_image' ) ) :
	/**
	 * Given a 'term' ID, gets the image attached to this term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (string)  $size Desired image size.
	 * @return (string|bool)
	 */
	function listar_term_image( $term_id, $taxonomy = 'category', $size = 'listar-thumbnail' ) {
		$post_image = '';
		$term_image = '';

		switch ( $taxonomy ) {
			case 'job_listing_category':
				$term_image = 'job_listing_category-image-id';
				break;
			case 'job_listing_region':
				$term_image = 'job_listing_region-image-id';
				break;
			case 'job_listing_amenity':
				$term_image = 'job_listing_amenity-image-id';
				break;
			default:
				$term_image = 'category-image-id';
		}

		$image_id = get_term_meta( $term_id, $term_image, true );

		if ( ! empty( $image_id ) ) {
			$attachment = wp_get_attachment_image_src( $image_id, $size );
			$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
			$post_image = $conditions ? $attachment[0] : '';
		}

		return $post_image;
	}

endif;

if ( ! function_exists( 'listar_term_icon_from_post' ) ) :
	/**
	 * Given a post ID, gets the icon attached to its first 'term' from taxonomy.
	 *
	 * @since 1.0
	 * @param (integer) $post_id ID of the post.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (object|boolean) $term The taxonomy term object.
	 * @return (string|bool)
	 */
	function listar_term_icon_from_post( $post_id, $taxonomy, $term = false ) {

		$listing_term = ! isset( $term->term_id ) ? listar_first_term_data( $post_id, $taxonomy ) : $term;

		if ( isset( $listing_term->term_id ) ) {
			return listar_term_icon( $listing_term->term_id );
		} else {
			return false;
		}
	}

endif;

if ( ! function_exists( 'listar_icon_class' ) ) :
	/**
	 * Get class to icons.
	 * Check if icon is a file or CSS class of a iconized font.
	 * If $data is an image, create SVG code and attribute it to 'data-background-image'.
	 * If $data is SVG URL, get its embeded code.
	 *
	 * @since 1.0
	 * @param (string)  $data The data can be: CSS class name, SVG URL or image URL (.jpg, .gif, etc).
	 * @param (boolean) $return_image_url If true, return JPG/PNG/BMP images as URL, instead of SVG code.
	 * @return (array)
	 */
	function listar_icon_class( $data, $return_image_url = false ) {

		$icon_data = '';

		if ( false !== strpos( $data, '://' ) ) {

			/* It seems a file, does it exist? */

			$url = $data;

			if ( ! listar_url_exists( $url ) ) {
				/* File doesn't exist */
				$icon_data = array( '', '' );

			} elseif ( false === strpos( $url, '.svg' ) ) {
				/*
				 * Is image .png, .jpg, etc
				 * Trick: output it as a SVG element
				 */
				$return = $return_image_url ? $url : '<svg data-background-image="' . esc_attr( listar_custom_esc_url( $url ) ) . '"></svg>';
				$icon_data = ! empty( $url ) ? array( 'listar-image-icon', $return ) : array( '', '' );

			} elseif ( false !== strpos( $url, '.svg' ) ) {
				/* Probably a .svg image, but empty will be returned if not available */
				$svg_image = listar_svg_code( $url );
				$icon_data = array( '', $svg_image );

			} else {
				/* Unnacepted URL */
				$icon_data = array( '', '' );
			}
		} else {
			/* $data contains a icon class itself or is empty */
			$icon_data = array( $data, '' );
		}

		return $icon_data;
	}

endif;

if ( ! function_exists( 'listar_svg_code' ) ) :
	/**
	 * Get and treats the code returned by listar_svg_content().
	 *
	 * @since 1.0
	 * @param (string) $svg_file URL of SVG file.
	 * @return (string)
	 */
	function listar_svg_code( $svg_file ) {

		$svg_code = listar_svg_content( $svg_file );

		if ( false !== $svg_code ) :

			$find_string = '<svg';
			$position    = strpos( $svg_code, $find_string );
			$svg         = substr( $svg_code, $position );

			/* Apply listar-svg-icon class. If available, modify id to avoid duplicate values (W3C validation) */
			$search      = array( '<svg', ' id="' );
			$replace     = array( '<svg class="listar-svg-icon"', ' id="_' . wp_rand( 10, 99999 ) );
			$svg_code    = str_replace( $search, $replace, $svg );

			return $svg_code;

		endif;

		return '';
	}

endif;

if ( ! function_exists( 'listar_svg_content' ) ) :
	/**
	 * Get content (code) embeded in a SVG file.
	 *
	 * @since 1.0
	 * @param (string) $url The URL of a SVG file.
	 * @return (string|boolean)
	 */
	function listar_svg_content( $url ) {

		if ( true === listar_url_exists( $url ) ) :
			$data = wp_remote_request( $url );

			if ( ! is_wp_error( $data ) ) {
				return isset( $data['body'] ) ? $data['body'] : '';
			} else {
				return '';
			}
		else :
			return false;
		endif;
	}

endif;

if ( ! function_exists( 'listar_term_icon' ) ) :
	/**
	 * Given a 'term' ID from certain taxonomy, gets the icon attached to the term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @return (string|bool)
	 */
	function listar_term_icon( $term_id ) {

		$term_data = get_option( "taxonomy_$term_id" );
		$term_icon = isset( $term_data['term_icon'] ) && ! empty( $term_data['term_icon'] ) ? esc_html( $term_data['term_icon'] ) : '';

		return $term_icon;
	}

endif;

if ( ! function_exists( 'listar_term_color' ) ) :
	/**
	 * Given a 'term' ID from certain taxonomy, gets the color set to the term.
	 *
	 * @since 1.0
	 * @param (integer) $term_id ID of the term.
	 * @param (boolean) $hex_numeral_system true to return hexadecimal code.
	 * @return (string)
	 */
	function listar_term_color( $term_id, $hex_numeral_system = false ) {

		$term_color = listar_theme_color();

		$custom_colors_disabled = (int) get_option( 'listar_disable_custom_taxonomy_colors' );

		if ( 0 === $custom_colors_disabled ) {
			$term_data = get_option( "taxonomy_$term_id" );
			$term_color = isset( $term_data['term_color'] ) && ! empty( $term_data['term_color'] ) && '#' !== $term_data['term_color'] ? esc_html( $term_data['term_color'] ) : listar_theme_color();
		}

		return $hex_numeral_system ? str_replace( '#', '', $term_color ) : listar_convert_hex_to_rgb( $term_color );
	}

endif;

if ( ! function_exists( 'listar_theme_color' ) ) :
	/**
	 * Get the current theme color set on Customizer / Colors.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_theme_color() {
		$theme_color = '#' . get_theme_mod( 'listar_theme_color', '258bd5' );
		return $theme_color;
	}

endif;

if ( ! function_exists( 'listar_gradient_background' ) ) :
	/**
	 * Generate CSS for gradient background.
	 *
	 * @since 1.0
	 * @param (string) $rgb_color The base color (RGB).
	 * @param (string) $direction_start Side to start the gradient.
	 * @param (string) $direction_end Side to end the gradient.
	 * @param (string) $rgb_secondary_color The secondary color (RGB).
	 * @param (string) $opacity The opacity for base color.
	 * @param (string) $secondary_opacity The opacity for secondary color.
	 * @param (string) $gradient_start The percentual starting position for gradient.
	 * @return (string)
	 */
	function listar_gradient_background( $rgb_color = false, $direction_start = 'top', $direction_end = 'bottom', $rgb_secondary_color = false, $opacity = '0', $secondary_opacity = '1', $gradient_start = '35%' ) {

		if ( false === $rgb_color ) {
			$color = listar_theme_color();
			$rgb_color = listar_convert_hex_to_rgb( $color );
		}

		if ( false === $rgb_secondary_color ) {
			$rgb_secondary_color = $rgb_color;
		}

		$gradient_css  = 'background-color: transparent;';
		$gradient_css .= 'background: -webkit-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: -o-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: -ms-linear-gradient(' . $direction_start . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';
		$gradient_css .= 'background: linear-gradient(to ' . $direction_end . ', rgba(' . $rgb_color . ',' . $opacity . ') ' . $gradient_start . ', rgba(' . $rgb_secondary_color . ',' . $secondary_opacity . ') 100%);';

		return $gradient_css;
	}

endif;

if ( ! function_exists( 'listar_convert_hex_to_rgb' ) ) :
	/**
	 * Convert color code from hexadecimal to RGB.
	 *
	 * @since 1.0
	 * @param (string) $hex Hexadecimal color code, ex.: #004488.
	 * @param (bool)   $complete_code If true returns 'rgb(xxx,yyy,zzz), false returns only 'xxx,yyy,zzz'.
	 * @return (string)
	 */
	function listar_convert_hex_to_rgb( $hex = '', $complete_code = false ) {

		$hexa     = str_replace( '#', '', $hex );
		$length   = strlen( $hexa );
		$rgb['r'] = hexdec( 6 === $length ? substr( $hexa, 0, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 0, 1 ), 2 ) : 0 ) );
		$rgb['g'] = hexdec( 6 === $length ? substr( $hexa, 2, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 1, 1 ), 2 ) : 0 ) );
		$rgb['b'] = hexdec( 6 === $length ? substr( $hexa, 4, 2 ) : ( 3 === $length ? str_repeat( substr( $hexa, 2, 1 ), 2 ) : 0 ) );

		return $complete_code ? 'rgb(' . implode( ',', $rgb ) . ')' : implode( ',', $rgb );
	}

endif;

if ( ! function_exists( 'listar_sanitize_html_class' ) ) :
	/**
	 * Sanitize multiple classes with sanitize_html_class().
	 *
	 * @since 1.0
	 * @param (string) $classes The classes to sanitize.
	 * @return (string)
	 */
	function listar_sanitize_html_class( $classes ) {

		$sanitized = '';

		if ( false !== strpos( $classes, ' ' ) ) {

			$classes = array_filter( explode( ' ', $classes ) );

			foreach ( $classes as $class ) {
				$sanitized .= ' ' . sanitize_html_class( $class );
			}
		} else {
			$sanitized = sanitize_html_class( $classes );
		}

		return trim( $sanitized );
	}

endif;

if ( ! function_exists( 'listar_icon_output' ) ) :
	/**
	 * Enforce security for HTML code before output.
	 *
	 * Currently, this function is being used exclusively to process SVG code.
	 * Skipping complex sanitization of SVG code (via 'wp_kses_post') to save memory. Please notice that
	 * the internal code of all SVG files were already cleaned by 'Safe SVG' plugin during upload.
	 * See (Safe SVG plugin): safe-svg/lib/vendor/enshrined/svg-sanitize/src/data/AllowedAttributes.php.
	 * See (Safe SVG plugin): safe-svg/lib/vendor/enshrined/svg-sanitize/src/data/AllowedTags.php
	 * Although already sanitized, this is a further attempt to enforce secure output for unknown SVG files.
	 *
	 * @since 1.0
	 * @param (string) $html HTML code.
	 * @param (boolean) $print Print the code or just return the output.
	 */
	function listar_icon_output( $html = '', $print = true ) {
		if ( $print ) {
			echo str_replace( array( 'script', '.js', '<?php', '.php', '?>' ), '', $html );
		} else {
			return str_replace( array( 'script', '.js', '<?php', '.php', '?>' ), '', $html );
		}
	}
endif;

if ( ! function_exists( 'listar_listing_gallery_ids' ) ) :
	/**
	 * Retrieve the list of IDs of a single listing gallery.
	 *
	 * @since 1.0
	 * @param (integer) $id The ID of the listing.
	 * @return (array)
	 */
	function listar_listing_gallery_ids( $id = 0 ) {
		/*
		 * Remove the prefix and sufix from gallery shortcode, keep only the attachment IDs separated by comma
		 * Reference: https://stackoverflow.com/questions/4949279/remove-non-numeric-characters-except-periods-and-commas-from-a-string
		 */
		$gallery_str = preg_replace( '/[^0-9,]/', '', esc_html( get_post_meta( $id, '_gallery', true ) ) );
		$gallery_ids = explode( ',', $gallery_str );

		array_unshift( $gallery_ids, get_post_thumbnail_id( $id ) );

		return array_filter( $gallery_ids );
	}

endif;

if ( ! function_exists( 'listar_count_term_posts' ) ) :
	/**
	 * Count the number of posts of a term, including posts on children terms.
	 *
	 * @since 1.0
	 * @param (object) $term A term from any taxonomy.
	 * @return (int)
	 */
	function listar_count_term_posts( $term ) {
		$id = $term->term_id;
		$term_meta = get_option( "taxonomy_$id" );
		$counter = (int) isset( $term_meta['post_counter'] ) ? $term_meta['post_counter'] : 0;

		if ( $counter > 9999 && $counter < 1000000 ) {
			$counter = (string) ( (int) ( $counter / 1000 ) ) . 'K' ;
		} elseif ( $counter >= 1000000 ) {
			$counter = (string) ( (int) ( $counter / 1000000 ) ) . 'M' ;
		}
		
		return ! empty( $counter ) ? $counter : 0;
	}

endif;

if ( ! function_exists( 'listar_check_plural' ) ) :
	/**
	 * Return words on singular/plural.
	 *
	 * @since 1.0
	 * @param (integer) $amount Number of entries.
	 * @param (string)  $singular String to output if $amount === 1.
	 * @param (string)  $plural String to output if $amount > 1.
	 * @param (string)  $no_results String to output if $amount === 0.
	 */
	function listar_check_plural( $amount, $singular = '', $plural = '', $no_results = '' ) {

		$output = $no_results;

		if ( 1 === (int) $amount ) {
			$output = $singular;
		} elseif ( (int) $amount > 1 ) {
			$output = $plural;
		}

		return $output;
	}

endif;

if ( ! function_exists( 'listar_package_query' ) ) :
	/**
	 * Create the args to WP Job Manager package query.
	 *
	 * @since 1.0
	 * @param (string) $package_type The type of the package.
	 * @return (array)
	 */
	function listar_package_query( $package_type = 'default' ) {

		static $package_query = null;

		if ( empty( $package_query ) ) :

			/* Display all pricing packages in one page */
			$posts_per_page = 2000;

			$args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'order'          => 'ASC',
				'orderby'        => 'meta_value_num',
				'meta_key'       => '_regular_price',
				'posts_per_page' => $posts_per_page,
				'meta_query'     => array(
					array(
						'key'     => '_regular_price',
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'relation' => 'OR',
						array(
							'key'     => '_use_for_claims',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => '_use_for_claims',
							'value'   => 'yes',
							'compare' => '!=',
						),
					),
				),
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_type',
						'field'    => 'slug',
						'terms'    => array ( 'job_package', 'job_package_subscription' ),
					),
				),
			);
			
			if ( 'claim' === $package_type ) {
				$args['meta_query'] = array(
					array(
						'key'     => '_regular_price',
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => '_use_for_claims',
						'value'   => 'yes',
						'compare' => '=',
					),
				);
			}

			$package_query = new WP_Query( $args );

		endif;

		return $package_query;
	}

endif;

if ( ! function_exists( 'listar_saved_best_rated' ) ) :
	/**
	 * Get best rated listings saved programatically as Theme Option.
	 *
	 * @since 1.0
	 * @return (object)
	 */
	function listar_saved_best_rated() {

		$best_rated_listings = esc_html( get_option( 'listar_best_rated_listings' ) );

		if ( empty( $best_rated_listings ) ) {

			/* If register is empty, call function to get current best rated listings and save it */
			listar_update_top_listings();

			$best_rated_listings = esc_html( get_option( 'listar_best_rated_listings' ) );
		}

		return json_decode( $best_rated_listings );
	}

endif;

if ( ! function_exists( 'listar_update_top_listings' ) ) :
	/**
	 * Update lists for trending listings - Alias.
	 *
	 * @since 1.0
	 */
	function listar_update_top_listings() {
		listar_update_trending_listings();
	}
endif;

if ( ! function_exists( 'listar_update_trending_listings' ) ) :
	/**
	 * Update lists for trending listings.
	 *
	 * @since 1.4.6
	 */
	function listar_update_trending_listings() {
		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			$items = listar_most_rated_listings();
			$best_rated = wp_filter_nohtml_kses( wp_json_encode( listar_best_rated_listings( $items ) ) );

			update_option( 'listar_most_rated_listings', json_encode( $items ) );
			update_option( 'listar_best_rated_listings', $best_rated );
		}

		update_option( 'listar_most_favorited_listings', json_encode( listar_get_fav_list( 2000 ) ) );
		update_option( 'listar_newest_listings', json_encode( listar_get_newest( 2000 ) ) );
		update_option( 'listar_featured_listings', json_encode( listar_get_featured( 2000 ) ) );
		update_option( 'listar_most_viewed_listings', json_encode( listar_get_most_viewed( 2000 ) ) );
		update_option( 'listar_trending_listings', json_encode( listar_trending_listings() ) );
	}
endif;

if ( ! function_exists( 'listar_most_rated_listings' ) ) :
	/**
	 * Get most rated listings (returns the IDs and average rating values).
	 *
	 * @since 1.0
	 * @param (integer) $number_of_samples Number of best rated listings to analize.
	 * @return (array)
	 */
	function listar_most_rated_listings( $number_of_samples = 2000 ) {

		/* It's strictly important to get the comment count table always updated */
		listar_update_comment_counters();

		/* Query listing ordered by the number of comments */
		$exec_query = new WP_Query(
			array(
				'post_type'      => 'job_listing',
				'post_status'    => 'publish',
				'orderby'        => 'comment_count',
				'posts_per_page' => $number_of_samples,
			)
		);

		/* Array of listing IDs and respective ratings */
		$ids_and_ratings = array();

		while ( $exec_query->have_posts() ) :
			$exec_query->the_post();

			$ids_and_ratings[] = array(
				'id'  => get_the_ID(),
				'rev' => listar_reviews_average_number( get_the_ID() ),
			);
		endwhile;

		/* Restore original Post Data */
		wp_reset_postdata();

		return $ids_and_ratings;
	}

endif;

if ( ! function_exists( 'listar_clean_cache' ) ) :
	/**
	 * Clean cache for Listar.
	 *
	 * @param (string) $action Can be 'enable' or 'disable'.
	 * @since 1.1.9
	 */
	function listar_clean_cache( $action = 'disable' ) {
		$minimum_size = 400; /* 400Kb: This must be very low */
		$statArr = array( 1 );
		$clean_cache = true;
		
		if ( 'enable' !== $action ) {

			if ( class_exists( 'autoptimizeCache' ) ) {
				$statArr = autoptimizeCache::stats(); 
				$cache_size = round( $statArr[1]/1024 );

				if ( $cache_size < $minimum_size ) {
					$clean_cache = false;
				}
			}

			if ( $clean_cache ) {
				if ( class_exists( 'autoptimizeCache' ) ) {
					autoptimizeCache::clearall();
					header( 'Refresh:0' ); # Refresh the page so that autoptimize can create new cache files and it does breaks the page after clearall.
				} else if ( function_exists( 'wpfastestcache_activate' ) && function_exists( 'deleteCache' ) && $clean_cache ) {
					deleteCache( true );  # Purge cache for WP Fastest Cache plugin.
				}
			}

			listar_get_cache_urls( false, false, 'disable' );
		}
	}

endif;

if ( ! function_exists( 'listar_update_comment_counters' ) ) :
	/**
	 * Update comment counters.
	 *
	 * @since 1.0
	 * @param (string) $post_type The post type name.
	 */
	function listar_update_comment_counters( $post_type = 'job_listing' ) {

		/* Get all comments */
		$posts_per_page = 2000;

		$query_posts = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => $posts_per_page,
			)
		);

		while ( $query_posts->have_posts() ) :
			$query_posts->the_post();
			wp_update_comment_count_now( get_the_ID() );
		endwhile;
	}
endif;


if ( ! function_exists( 'listar_force_numeric' ) ) :
	/**
	 * Force numeric value.
	 *
	 * @since 1.3.9
	 * @param (Mixed) $data Data to validate as numeric.
	 */
	function listar_force_numeric( $data = 0 ) {
		return is_numeric( $data ) ? $data + 0 : 0;
	}
endif;


if ( ! function_exists( 'listar_reviews_average_number' ) ) :
	/**
	 * Get reviews average, return as number.
	 *
	 * @since 1.0
	 * @param (integer) $id Listing ID.
	 * @return (float)
	 */
	function listar_reviews_average_number( $id ) {
		return (float) listar_get_reviews_average( $id );
	}

endif;


if ( ! function_exists( 'listar_get_reviews_average_core' ) ) :
	/**
	 * Get reviews average from Listar Addons.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_get_reviews_average_core( $id ) {

		if ( ! $id ) {
			$id = get_the_ID();
		}

		$review_average = listar_force_numeric( get_post_meta( $id, '_average_rating', true ) );

		if ( ! $review_average ) {
			listar_update_reviews_average( $id );
		}

		if ( ! $review_average ) {
			return 0;
		}

		return round( $review_average * 2, 1 ) / 2;
	}

endif;


if ( ! function_exists( 'listar_get_reviews_average' ) ) :
	/**
	 * Get reviews average.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_get_reviews_average( $id ) {

		$listing_post  = get_post( $id );
		$comment_count = isset( $listing_post->comment_count ) ? (int) $listing_post->comment_count : 0;

		if ( listar_third_party_reviews_active() ) {
			return (float) $comment_count > 0 ? wpjmr_get_reviews_average( $id ) : 0;
		} elseif ( listar_built_in_reviews_active() ) {
			return (float) $comment_count > 0 ? listar_get_reviews_average_core( $id ) : 0;
		} else {
			return 0;
		}
	}

endif;


if ( ! function_exists( 'listar_reviews_average' ) ) :
	/**
	 * Get reviews average.
	 * If not available, return empty star (yet unrated) or false (review plugin inactive).
	 *
	 * @since 1.0
	 * @param (intenger) $id Listing ID.
	 * @return (float|string|bool)
	 */
	function listar_reviews_average( $id ) {

		if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
			$n = listar_get_reviews_average( $id );
			$average = listar_check_reviews_average( $n, $id );
			return $average;
		}

		return false;
	}

endif;

if ( ! function_exists( 'listar_check_reviews_average' ) ) :
	/**
	 * Check if reviews average is > 0, return empty star icon if not.
	 *
	 * @since 1.0
	 * @param (float)   $average Reviews average.
	 * @param (integer) $id Listing ID.
	 * @return (float|string)
	 */
	function listar_check_reviews_average( $average, $id = 0 ) {

		$check = number_format( floatval( $average ), 1 );
		$count = listar_reviews_count( $id );

		return ( empty( $check ) || 0 === $check || 0 === (int) $count ) ? '<i class="fa fa-star-o listar-no-rating"></i>' : $check;
	}

endif;

if ( ! function_exists( 'listar_get_reviews_count_core' ) ) :
	/**
	 * Count the total number of reviews of a listing via Listar Addons.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_get_reviews_count_core( $id ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		$reviews = listar_get_reviews( $id );
		return count( $reviews );
	}
endif;

if ( ! function_exists( 'listar_reviews_count' ) ) :
	/**
	 * Count the total number of reviews of a listing.
	 *
	 * @since 1.3.9
	 * @param (integer) $id Listing ID.
	 * @return (string)
	 */
	function listar_reviews_count( $id ) {
	
		if ( listar_third_party_reviews_active() ) {
			return wpjmr_get_reviews_count( $id );
		} elseif ( listar_built_in_reviews_active() ) {
			return listar_get_reviews_count_core( $id );
		} else {
			return 0;
		}
	}
endif;


if ( ! function_exists( 'listar_get_comment_review_average_core' ) ) :
	/**
	 * Get review average for a comment via Listar Addons
	 *
	 * @since 1.3.9
	 * @param (string) $comment_id The comment ID.
	 * @return (string)
	 */
	function listar_get_comment_review_average_core( $comment_id ) {
		$average = get_comment_meta( $comment_id, 'review_average', true );
		return number_format( listar_force_numeric( $average ), 1, '.', ',' );
	}
endif;


if ( ! function_exists( 'listar_get_comment_review_average' ) ) :
	/**
	 * Get review average for a comment
	 *
	 * @since 1.3.9
	 * @param (string) $comment_id The comment ID.
	 * @return (string)
	 */
	function listar_get_comment_review_average( $comment_id ) {
		if ( listar_third_party_reviews_active() ) {
			return wpjmr_get_review_average( $comment_id );
		} elseif ( listar_built_in_reviews_active() ) {
			return listar_get_comment_review_average_core( $comment_id );
		} else {
			return '0';
		}
	}
endif;


if ( ! function_exists( 'listar_best_rated_listings' ) ) :
	/**
	 * Get best rated listings.
	 *
	 * @since 1.0
	 * @param (array)   $ids_and_ratings Listing IDs and respective ratings.
	 * @param (integer) $number_of_samples The number of listings to get results from.
	 * @return (array)
	 */
	function listar_best_rated_listings( $ids_and_ratings, $number_of_samples = 2000 ) {

		$best_rated_ids_and_ratings = array();

		foreach ( $ids_and_ratings as $key => $row ) {
			$best_rated_ids_and_ratings[ $key ] = $row['rev'];
		}

		array_multisort( $best_rated_ids_and_ratings, SORT_DESC, $ids_and_ratings );
		$best_rated_ids = array();

		foreach ( $ids_and_ratings as $elem ) {
			$best_rated_ids[] = $elem['id'];
		}

		return array_slice( array_filter( $best_rated_ids ), 0, $number_of_samples, true );
	}

endif;

if ( ! function_exists( 'listar_static_current_listings' ) ) :
	/**
	 * Save current listing IDs (captured on listing loops or single listing page) to use later with map markers output.
	 *
	 * @since 1.0
	 * @param (integer|array) $id If integer: The ID of a listing post.
	 * If empty array: reset the list of IDs.
	 * @return (array)
	 */
	function listar_static_current_listings( $id = false ) {

		static $current_listings = array();

		if ( ! empty( $id ) ) {
			/* Add new listing ID */
			$current_listings[] = $id;
		} elseif ( is_array( $id ) && empty( $id ) ) {
			/* Reset the list */
			$current_listings = array();
		}

		return $current_listings;
	}

endif;

if ( ! function_exists( 'listar_static_map_markers_ajax' ) ) :
	/**
	 * (Ajax) Save listing IDs on static var to populate Leaflet map with new markers.
	 *
	 * @since 1.0
	 * @param (integer|array|bool) $marker If integer: Listing ID of a new map marker that will be queried with Ajax.
	 * If empty array: it informs the following listing loop that the new listings (and markers) will be queried with Ajax.
	 * @return (bool|array)
	 */
	function listar_static_map_markers_ajax( $marker = false ) {

		static $map_markers_ajax = false;

		if ( false !== $marker ) {

			if ( is_array( $marker ) && empty( $marker ) ) {
				/* Empty array, so next loop will be queried with Ajax */
				$map_markers_ajax = array();
			} else {
				/* Save the new IDs of listings queried with Ajax */
				$map_markers_ajax[] = $marker;
			}
		}

		return $map_markers_ajax;
	}

endif;

if ( ! function_exists( 'listar_loop_completed' ) ) :
	/**
	 * Inform that the main loop of posts is completed in current page or if listing loops are allowed
	 * to capture listings (IDs) to populate the map (false).
	 *
	 * @since 1.0
	 * @param (bool) $completed Can be: false (enables the capture of IDs) or true (loop completed/disable the capture).
	 * @return (bool)
	 */
	function listar_loop_completed( $completed = false ) {

		static $loop_completed = false;

		if ( $completed ) {
			$loop_completed = $completed;
		}

		return $loop_completed;
	}

endif;

if ( ! function_exists( 'listar_static_current_listings' ) ) :
	/**
	 * Save current listing IDs (captured on listing loops or single listing page) to use later with map markers output.
	 *
	 * @since 1.0
	 * @param (integer|array) $id If integer: The ID of a listing post.
	 * If empty array: reset the list of IDs.
	 * @return (array)
	 */
	function listar_static_current_listings( $id = false ) {

		static $current_listings = array();

		if ( ! empty( $id ) ) {
			/* Add new listing ID */
			$current_listings[] = $id;
		} elseif ( is_array( $id ) && empty( $id ) ) {
			/* Reset the list */
			$current_listings = array();
		}

		return $current_listings;
	}

endif;

if ( ! function_exists( 'listar_load_more_script' ) ) :
	/**
	 * Ajax Load More posts - Scripts.
	 *
	 * @since 1.0
	 * @param (object) $query The current WordPress query object.
	 */
	function listar_load_more_script( $query = false ) {

		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		$paged = 1;

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			/* 'page' is used instead of 'paged' on Static Front Page */
			$paged = get_query_var( 'page' );
		}

		wp_localize_script(
			'listar-main-javascript',
			'listarAjaxPostsParams',
			array(
				'ajaxurl'      => esc_url( site_url() . '/wp-admin/admin-ajax.php' ),
				'posts'        => wp_json_encode( $query->query_vars ),
				'current_page' => (int) $paged,
				'max_page'     => $query->max_num_pages,
			)
		);
	}

endif;

if ( ! function_exists( 'listar_is_front_page_template' ) ) :
	/**
	 * Improved detection of front page by template, rather than the default conditional tag is_front_page().
	 *
	 * @since 1.0
	 * @return (boolean)
	 */
	function listar_is_front_page_template() {

		global $wp_query;
		global $query;

		static $is_front_page = 0;
		
		$id = false;

		if ( 0 !== $is_front_page ) {
			return $is_front_page;
		} else {
			
			if ( empty( $id ) ) {
				$id = isset( $query->query_vars->page_id ) ? $query->query_vars->page_id : false;
			}
			
			$id = isset( $wp_query->query_vars[ 'page_id' ] ) ? $wp_query->query_vars[ 'page_id' ] : false;
			
			if ( empty( $id ) ) {
				isset( $wp_query->page_id ) ? $wp_query->page_id : false;
			}
			
			if ( empty( $id ) ) {
				$id = isset( $wp_query->post->ID ) ? $wp_query->post->ID : false;
			}
			
			if ( empty( $id ) ) {
				$id = isset( $query->queried_object->ID ) ? $query->queried_object->ID : false;
			}
			
			if ( empty( $id ) ) {
				$id = isset( $wp_query->query_vars[ 'p' ] ) ? $wp_query->query_vars[ 'p' ] : false;
			}

			if ( ! empty( $id ) ) {
				$template = ! empty( $id ) ? get_page_template_slug( $id ) : '';
				$is_front_page = ( false !== strpos( $template, 'front-page' ) && is_page() ) ? true : false;
			} else {
				return false;
			}

			return $is_front_page;
		}
	}

endif;

if ( ! function_exists( 'listar_first_term_data' ) ) :
	/**
	 * Given a taxonomy, get data from first 'term' available to a post.
	 *
	 * @since 1.0
	 * @param (integer) $post_id ID of the post.
	 * @param (string)  $taxonomy Taxononomy slug.
	 * @param (string)  $data The intended data to return: "array", "name", "id", "link".
	 * @return (array|string|integer|bool)
	 */
	function listar_first_term_data( $post_id, $taxonomy = 'job_listing_category', $data = 'array' ) {

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! isset( $terms[0] ) ) {
			return false;
		}

		$first = $terms[0];
		$id = false;

		if ( isset( $first->term_id ) ) {
			$id = $first->term_id;
		}

		$name = false;

		if ( isset( $first->name ) ) {
			$name = $first->name;
		}

		$link = get_term_link( $first, $taxonomy );

		switch ( $data ) {
			case 'array':
				return $first;
			case 'name':
				return $name;
			case 'id':
				return $id;
			case 'link':
				return $link;
			default:
				return $terms;
		}
	}

endif;

function listar_doing_listing_ajax_search( $is_ajax = false ) {

	static $ajax = false;

	if ( ! empty( $is_ajax ) ) {
		$ajax = true;
	}

	return $ajax;
}



if ( ! function_exists( 'listar_count_found_posts' ) ) :
	/**
	 * Get the number of results found by current WordPress query.
	 *
	 * @since  1.0
	 * @param  (object) $query A WP Query object (optional).
	 * @return (integer)
	 */
	function listar_count_found_posts( $query = false ) {

		if ( false === $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		return (int) isset( $query->found_posts ) ? $query->found_posts : 0;
	}

endif;

if ( ! function_exists( 'listar_excerpt_limit' ) ) :
	/**
	 * Trim post excerpts to a limit of characters.
	 *
	 * @since 1.0
	 * @param (object|string) $post_data WordPress $post object or any string.
	 * @param (integer)       $n Desired number of characters.
	 * @param (boolean)       $use_more_link Append the "Read More" link or not.
	 * @param (string)        $fallback_text Fallback text if empty excerpt.
	 * @param (boolean)       $use_etc Append '...' to the end of title if text length is larger than requested.
	 * @param (string)        $etc_type The type of output to the "read more" block.
	 * @param (boolean)       $avoid_empty If no excerpt available, don't return nothing.
	 * @return (string)
	 */
function listar_excerpt_limit( $post_data, $n, $use_more_link = true, $fallback_text = '', $use_etc = false, $etc_type = '', $avoid_empty = false ) {
		$more_link = '';
		$excerpt_data = '';
		$text2 = is_string( $post_data ) ? $post_data : '';
		
		if ( empty( $text2 ) ) {
			$custom_excerpt_enabled = 1 === (int) get_post_meta( get_the_ID( $post_data ), '_job_business_use_custom_excerpt', true );
			
			if ( $custom_excerpt_enabled ) {
				$text2 = get_post_meta( get_the_ID( $post_data ), '_job_business_custom_excerpt', true );
			}
		}
		
		if ( empty( $text2 ) ) {
			$text2 = get_post_meta( get_the_ID( $post_data ), '_company_excerpt', true );
		}

		// Remove double spaces and line breaks.
		$text = preg_replace( '/\s+/', ' ', $text2 );

		if ( strlen( $text ) < 10 && ! is_string( $post_data ) ) {
			$temp_ex = isset( $post_data->post_excerpt ) ? $post_data->post_excerpt : '';
			$text3 = preg_replace( '#^\d+#', '', $temp_ex );
			$text = preg_replace( '/\s+/', ' ', $text3 );

			if ( strlen( $text ) < 10 ) {
				$text4 = preg_replace( '#^\d+#', '', get_the_content( null, false, $post_data ) );
				$text  = preg_replace( '/\s+/', ' ', $text4 );
			}
		}

		// Strip all HTML tags and inner content of code blocks.
		$excerpt_clean_1 = wp_kses( $text, array() );

		// Remove Gutenberg HTML comments (Block comments).
		$excerpt_clean_2 = preg_replace( '/(?=<!--)([\s\S]*?)-->/', '', $excerpt_clean_1 );

		// We don't want URLs as text.
		if ( false !== strpos( $excerpt_clean_2, 'http' ) ) {
			$excerpt_clean_2 = substr( $excerpt_clean_2, 0, strpos( $excerpt_clean_2, 'http' ) );
		}

		// Remove WordPress Shortcodes.
		$excerpt_clean_4 = strip_shortcodes( $excerpt_clean_2 );

		$chars_trim = array(
			':',
			'-',
			'/',
			'+',
			'#',
			'@',
			'"',
			"'",
			'_',
			'*',
			'$',
			'=',
			',',
			' ',
		);

		$chars_trim_2 = array(
			':',
			'-',
			'/',
			'+',
			'#',
			'@',
			'"',
			"'",
			'_',
			'*',
			'$',
			'=',
			'.',
			'!',
			'?',
			')',
		);

		$count_chars = strlen( $excerpt_clean_4 );

		if ( (int) ( $count_chars * 1.25 ) > $n ) {
			$str = substr( $excerpt_clean_4, 0, $n );
			$excerpt_clean_4 = $str;
			$count_chars_2 = count( $chars_trim_2 );
			
			// Remove last word, it may be cutted in half.
			if ( false !== strpos( $excerpt_clean_4, ' ' ) ) {
				$excerpt_clean_4 = implode( ' ', explode( ' ', $excerpt_clean_4, -1 ) );
			}

			// If the text after the last occurrence of following characters is very short, strip it too.
			for ( $i = 0; $i < $count_chars_2; $i++ ) {
				if ( false !== strpos( $excerpt_clean_4, $chars_trim_2[ $i ] ) ) {
					$temp  = explode( $chars_trim_2[ $i ], $excerpt_clean_4 );
					$count = count( $temp );

					if ( strlen( $temp[ $count - 1 ] ) < 15 ) {
						$excerpt_clean_4 = substr( $excerpt_clean_4, 0, strrpos( $excerpt_clean_4, $chars_trim_2[ $i ] ) );
					}
				}
			}
			
			if ( $use_etc ) {
				$use_etc = 'yes';
			}
		}

		// Remove all spaces from both sides of a string. Also, remove specific chars.

		$count_trim = count( $chars_trim );

		for ( $i = 0; $i < $count_trim; $i++ ) {
			$excerpt_clean_4 = trim( $excerpt_clean_4, $chars_trim[ $i ] );
		}
		
		$excerpt_clean_5 = str_replace( array( '&nbsp;' ), ' ', $excerpt_clean_4 );

		/* If last char is '&', remove it */
		if ( '&' === substr( $excerpt_clean_5, -1 ) ) {
			$excerpt_clean_5 = substr( $excerpt_clean_5, 0, -1 );
		}

		$excerpt = $excerpt_clean_5;

		if ( empty( $excerpt ) ) {
			$excerpt = $fallback_text;
		}
		
		/*
		 * Remove special characters but respect cyrillic/greek and etc.
		 * Reference: https://stackoverflow.com/a/7271664/7765298
		 */
		$valid_string_test = preg_replace( '/[^\p{L}\p{N}\s]/u', '', $excerpt );
		
		if ( ! empty( $valid_string_test ) ) {
			$valid_string_test = str_replace( '&nbsp;', '', $valid_string_test );
		}
		
		if ( empty( $valid_string_test ) && $avoid_empty ) {
			return '';
		}

		if ( empty( $valid_string_test ) || empty( $excerpt ) ) {
			$excerpt = '&nbsp;';
		}

		if ( $use_more_link ) {
			$excerpt_data = '<div class="listar-card-content-excerpt">' . $excerpt . '</div>';

			if ( empty( $etc_type ) ) {
				$more_link = ' <a title="' . esc_html__( 'Read More', 'listar' ) . '" href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="listar-read-more-link" data-toggle="tooltip" data-placement="top"><div><span></span></div></a>';
				
			} elseif ( 'only-dots' === $etc_type && ! empty( $valid_string_test ) ) {
				$more_link = ' <div class="fa fa-ellipsis-h"></div>';
			}
			
		} else {
			$excerpt_data = strip_shortcodes( $excerpt );
		}

		if ( 'yes' === $use_etc ) {
			$excerpt_data .= '...';
		}

		return $excerpt_data . $more_link;
	}

endif;

if ( ! function_exists( 'listar_static_posts_already_shown' ) ) :
	/**
	 * To avoid repeated display of posts on same page, use static var to save IDs of posts already queried.
	 *
	 * @since 1.0
	 * @param (integer) $id The ID of a post.
	 * @return (array)
	 */
	function listar_static_posts_already_shown( $id = false ) {

		static $posts_already_shown = array();

		if ( ! empty( $id ) ) {
			$posts_already_shown[] = $id;
		}

		return $posts_already_shown;
	}

endif;

if ( ! function_exists( 'listar_sanitize_url' ) ) :
	/**
	 * Sanitize URLs in more detail than esc_url().
	 *
	 * @since 1.0
	 * @param (string) $url The URL to sanitize.
	 * @return (string)
	 */
	function listar_sanitize_url( $url = '' ) {

		$sanitized = wp_filter_nohtml_kses( $url );
		$parts = wp_parse_url( $sanitized );

		if ( ! empty( $sanitized ) && $parts ) {
			if ( ! isset( $parts['scheme'] ) ) {
				$sanitized = 'http://' . str_replace( 'www.', '', $sanitized );
			}
			$sanitized = filter_var( $sanitized, FILTER_VALIDATE_URL );
		} else {
			$sanitized = '';
		}

		return $sanitized;
	}

endif;

if ( ! function_exists( 'listar_get_server_request_uri' ) ) :
	/**
	 * Get the request URI for current page.
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_get_server_request_uri() {

		return isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	}

endif;

if ( ! function_exists( 'listar_custom_esc_url' ) ) :
	/**
	 * For W3C validation.
	 * This function extends the esc_url() function to avoid printing null
	 * URLs as "http://0".
	 *
	 * @since 1.0
	 * @param (string) $url The URL to sanitize.
	 * @return (string)
	 */
	function listar_custom_esc_url( $url ) {

		$url2 = esc_url( $url );

		if ( '' === (string) $url || '0' === (string) $url || '/0' === substr( $url2, -2 ) ) {
			/* Comunicates with Listar JavaScript Lazy Load ! */
			$url2 = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		}

		return $url2;
	}

endif;


if ( ! function_exists( 'listar_average_user_rating' ) ) :
	/**
	 * Calculate the average review note given by an user for a listing
	 * based on varied WP Job Manager Reviews parameters.
	 *
	 * @since 1.0
	 * @param (string) $comment_id The comment ID.
	 * @param (string) $post_id The post ID.
	 * @return (string)
	 */
	function listar_average_user_rating( $comment_id, $post_id ) {

		$is_review_active     = listar_third_party_reviews_active() || listar_built_in_reviews_active();
		$review_options_count = 0;
		$review_stars_count   = 0;
		$comment_review_stars = '';
		$comment_is_review    = false;

		if ( $is_review_active ) {
			$reviews_count  = (int) listar_reviews_count( $post_id );
			$review_average = listar_get_comment_review_average( $comment_id );

			if ( 0 !== $reviews_count && $review_average > 0.07 ) {
				$comment_is_review = true;
			}
		}

		if ( $comment_is_review ) {
			$comment_review_stars = '';
			
			if ( listar_third_party_reviews_active() ) {
				$comment_review_stars = wpjmr_review_get_stars( $comment_id );
			} elseif ( listar_built_in_reviews_active() ) {
				$comment_review_stars = listar_review_get_stars( $comment_id );
			}
			
			$review_options_count = substr_count( $comment_review_stars, 'stars-rating star-rating' );
			$review_stars_count = substr_count( $comment_review_stars, 'dashicons-star-filled' );
		}

		if ( $review_options_count >= 1 ) {
			$review_average = number_format( floatval( $review_stars_count / $review_options_count ), 1 );
			return array( $review_average, true );
		} else {
			return array( 0, false );
		}
	}
endif;

if ( ! function_exists( 'listar_grid_filler_card' ) ) :
	/**
	 * Outputs a card to complete a listing or blog grid, avoiding empty areas on the screen.
	 *
	 * @since 1.0
	 * @param (string) $grid_type The type of grid on which the card will be inserted.
	 */
	function listar_grid_filler_card( $grid_type = 'listing' ) {
		
		$force_listing_grid_filler_blog = (int) get_option( 'listar_use_listing_grid_filler_blog' );
		$use_only_listing_grid_filler = 1 === $force_listing_grid_filler_blog ? true : false;
		$card_link                   = 'listing' === $grid_type || $use_only_listing_grid_filler ? get_option( 'listar_grid_filler_listing_button_url' ) : get_option( 'listar_grid_filler_blog_button_url' );
		$button_icon                 = 'listing' === $grid_type || $use_only_listing_grid_filler ? 'icon-map-marker-down' : 'icon-news';
		$card_has_custom_link_class  = ! empty( $card_link ) ? ' listar-has-custom-card-link' : ' listar-no-custom-card-link';
		$wp_job_manager_active       = listar_wp_job_manager_active();
		$blog_search_url             = trailingslashit( network_site_url() ) . '?s=';
		$listings_page_url           = '';
		$add_listing_url             = '';
		$card_url                    = '';
		$listar_card_title           = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_title' ) : get_option( 'listar_grid_filler_blog_card_title' );
		$listar_card_text_1          = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_text1' ) : get_option( 'listar_grid_filler_blog_card_text1' );
		$listar_card_text_2          = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_text2' ) : get_option( 'listar_grid_filler_blog_card_text2' );
		$listar_card_button_text     = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_button_text' ) : get_option( 'listar_grid_filler_blog_button_text' );
		$card_background_image       = listar_image_url( get_option( 'listar_' . $grid_type . '_grid_filler_background_image' ), 'listar-cover' );
		$listar_background_image     = empty( $card_background_image ) ? '0' : $card_background_image;
		$listar_has_background_image = '0' === $listar_background_image ? 'listar-grid-filler-without-background-image' : 'listar-grid-filler-has-background-image';

		if ( ( $wp_job_manager_active && 'listing' === $grid_type ) || $use_only_listing_grid_filler ) {

			if ( empty( $listar_card_title ) ) {
				$listar_card_title = esc_html__( 'Promote Your Business', 'listar' );
			}

			if ( empty( $listar_card_text_1 ) ) {
				$listar_card_text_1 = esc_html__( 'Do you need qualified exposure?', 'listar' );
			}

			if ( empty( $listar_card_text_2 ) ) {
				$listar_card_text_2 = esc_html__( 'Publish a listing for targeted audience to achieve more popularity in your niche.', 'listar' );
			}

			if ( empty( $listar_card_button_text ) ) {
				$listar_card_button_text = esc_html__( 'Get Started', 'listar' );
			}
		} else {
			if ( empty( $listar_card_title ) ) {
				$listar_card_title = $use_only_listing_grid_filler ? esc_html__( 'Promote Your Business', 'listar' ) : esc_html__( 'Keep Browsing', 'listar' );
			}

			if ( empty( $listar_card_text_1 ) ) {
				$listar_card_text_1 = $use_only_listing_grid_filler ? esc_html__( 'Do you need qualified exposure?', 'listar' ) : esc_html__( 'We have interesting articles for you.', 'listar' );
			}

			if ( empty( $listar_card_text_2 ) ) {
				$listar_card_text_2 = $use_only_listing_grid_filler ? esc_html__( 'Publish a listing for targeted audience to achieve more popularity in your niche.', 'listar' ) : esc_html__( 'Please, take a minute to check more news, tips and tricks from our blog.', 'listar' );
			}
		}

		if ( $wp_job_manager_active ) {
			/**
			 * Check if a page with [jobs] shortcode exists,
			 * if not, use a generic listing search url without the 's' parameter.
			 */
			
			if ( 'listing' === $grid_type || $use_only_listing_grid_filler ) :
				$listings_page_url = empty( $card_link ) ? job_manager_get_permalink( 'jobs' ) : $card_link;

				if ( empty( $listings_page_url ) ) :
					$listings_page_url = trailingslashit( network_site_url() ) . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
				endif;

				$add_listing_url = job_manager_get_permalink( 'submit_job_form' );

				if ( ! empty( $add_listing_url ) ) :
					$card_url = $add_listing_url;
					$button_icon = 'icon-map-marker-down';
				elseif ( 'listing' === $grid_type && ! empty( $listings_page_url ) ) :
					$card_url = $listings_page_url;
					$button_icon = 'icon-map-marker';
				else :
					$card_url = empty( $card_link ) ? $blog_search_url : $card_link;
					$button_icon = empty( $card_link ) ? 'icon-news' : 'icon-arrow-right';
				endif;
			else :
				$card_url = empty( $card_link ) ? $blog_search_url : $card_link;
				$button_icon = empty( $card_link ) ? 'icon-news' : 'icon-arrow-right';
				$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
			endif;
		} else {
			$card_url = $blog_search_url;
			$button_icon = 'icon-news';
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
		}
		
		if ( ! empty( $card_link ) ) {
			$card_url = $card_link;
			$button_icon = 'icon-arrow-right';
		}
		
		if ( empty( $card_url ) && ( 'listing' === $grid_type || $use_only_listing_grid_filler ) && ! empty( $listings_page_url ) ) {
			$card_url = $listings_page_url;
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See all listings', 'listar' ) : $listar_card_button_text;
			$button_icon = 'icon-map-marker';
		}
		
		if ( empty( $card_url ) && ( 'blog' === $grid_type ) ) {
			$card_url = $blog_search_url;
			$button_icon = 'icon-news';
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
		}
		?>

		<!-- Start grid filler card/button -->
		<div class="col-xs-12 col-sm-6 col-md-4 listar-grid-design-2 <?php echo esc_attr( listar_sanitize_html_class( 'listar-' . $grid_type . '-card' ) ); ?> listar-grid-filler">
			<article class="listar-card-content hentry <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>" data-aos="fade-zoom-in">
				<a class="listar-card-link <?php echo esc_attr( listar_sanitize_html_class( $card_has_custom_link_class ) ); ?>" href="<?php echo esc_url( $card_url ); ?>" data-default-url="<?php echo esc_url( $card_url ); ?>"></a>

				<?php
				if ( 'listar-grid-filler-has-background-image' === $listar_has_background_image ) :
					?>
					<div class="listar-grid-filler-background-image-wrapper">
						<div class="listar-grid-filler-background-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>"></div>
					</div>
					<?php
				endif;
				?>

				<div class="listar-fallback-content">
					<div class="listar-fallback-content-wrapper">
						<div class="listar-fallback-content-data">
							<div class="listar-fallback-content-small-title text-center">
								<h5><?php echo esc_html( $listar_card_title ); ?></h5>
							</div>

							<div class="listar-fallback-content-description text-center">
								<div>
									<?php echo esc_html( $listar_card_text_1 ); ?>
								</div>
								<div>
									<?php echo esc_html( $listar_card_text_2 ); ?>
								</div>
							</div>
						</div>
						<?php
						if ( $wp_job_manager_active ) {
							
							if ( ! empty( $card_url ) ) :
								?>
								<div class="listar-fallback-content-button-wrapper text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button <?php echo esc_attr( $button_icon ); ?>">
											<?php echo esc_html( $listar_card_button_text ); ?>
										</div>
									</div>
								</div>
								<?php
							elseif ( 'listing' === $grid_type && empty( $card_url ) && ! empty( $listings_page_url ) ) :
								?>
								<div class="listar-fallback-content-button-wrapper text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button icon-map-marker">
											<?php esc_html_e( 'See all listings', 'listar' ); ?>
										</div>
									</div>
								</div>
								<?php
							elseif ( 'blog' === $grid_type ) :
								?>
								<div class="listar-fallback-content-button-wrapper listar-fallback-blog-button text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button icon-news" data-next-posts="<?php esc_attr_e( 'Next page', 'listar' ); ?>" data-previous-posts="<?php esc_attr_e( 'Previous page', 'listar' ); ?>" data-default-text="<?php esc_attr_e( 'See more posts', 'listar' ); ?>">
											<?php esc_html_e( 'See more posts', 'listar' ); ?>
										</div>
									</div>
								</div>
								<?php
							endif;
						} else {
							?>
							<div class="listar-fallback-content-button-wrapper listar-fallback-blog-button text-center">
								<div class="text-center">
									<div class="button listar-iconized-button listar-light-button icon-news" data-next-posts="<?php esc_attr_e( 'Next page', 'listar' ); ?>" data-previous-posts="<?php esc_attr_e( 'Previous page', 'listar' ); ?>" data-default-text="<?php esc_attr_e( 'See more posts', 'listar' ); ?>">
										<?php esc_html_e( 'See more posts', 'listar' ); ?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</article>
		</div>
		<!-- End grid filler card/button -->

		<?php
	}
endif;


if ( ! function_exists( 'listar_company_operation_hours_availability' ) ) :
	/**
	 * Verify if a listing (company) is currently open or closed.
	 *
	 * @since 1.0
	 * @param (string) $post_id The post ID.
	 * @param (bool)   $get_table Set true to return the table with all operation hours.
	 * @return (array)
	 */
	function listar_company_operation_hours_availability( $post_id, $get_table = false ) {
		$use_operation_hours = (bool) get_post_meta( $post_id, '_job_business_use_hours', true );
		$listar_operating_hours_disable = (int) get_option( 'listar_operating_hours_disable' );

		if ( $use_operation_hours && 0 === $listar_operating_hours_disable ) :
			$current_day = current_time( 'l' );
			$english_current_day = '';
			$current_day_slug = '';
			$current_day_hours = '';
			$short_open_string = esc_html__( 'Open', 'listar' );
			$short_closed_string = esc_html__( 'Closed', 'listar' );
			$text_output = esc_html__( 'Now Closed', 'listar' );
			$do_output = false;
			$output_status = '';
			$output_status_html = '';
			$output_table_html = '';
			$output_icon_class = '';
			$hasOpenHour = false;
			$output_am_pm = (int) get_option( 'listar_operating_hours_suffix' );

			$output_talble_html_before = '<div class="listar-hours-table-wrapper"><table><tbody>';
			$output_talble_html_after  = '</tbody></table></div>';

			$availability_status = array(
				array( 'Closed', esc_html__( 'Closed', 'listar' ) ),
				array( 'Open', esc_html__( 'Open', 'listar' ) ),
			);

			$days = array(
				array( 'Monday', esc_html__( 'Monday', 'listar' ) ),
				array( 'Tuesday', esc_html__( 'Tuesday', 'listar' ) ),
				array( 'Wednesday', esc_html__( 'Wednesday', 'listar' ) ),
				array( 'Thursday', esc_html__( 'Thursday', 'listar' ) ),
				array( 'Friday', esc_html__( 'Friday', 'listar' ) ),
				array( 'Saturday', esc_html__( 'Saturday', 'listar' ) ),
				array( 'Sunday', esc_html__( 'Sunday', 'listar' ) ),
			);

			for ( $i = 0; $i < 7; $i++ ) {
				if ( $current_day === $days[ $i ][0] || $current_day === $days[ $i ][1] ) {
					$english_current_day = $days[ $i ][0];
					$current_day_slug = strtolower( $english_current_day );
					$current_day_hours = get_post_meta( $post_id, '_job_business_hours_' . $current_day_slug, true );
					$output_talble_html_before = '<div class="listar-hours-table-wrapper listar-current-day-' . $current_day_slug . '"><table><tbody>';
				}
			}

			if ( ! empty( $current_day_hours ) ) :
				$is_all_day_open_or_closed = false;				

				if ( false !== strpos( strtolower( $current_day_hours ), strtolower( $availability_status[0][0] ) ) || false !== strpos( strtolower( $current_day_hours ), strtolower( $availability_status[0][1] ) ) ) {
					$listar_company_is_open = 'listar-listing-closed icon-alarm-error';
					$text_output = esc_html__( 'Now Closed', 'listar' );
					$is_all_day_open_or_closed = true;
					$do_output = true;
					$output_status = 'closed';
					$output_icon_class = 'icon-alarm-error';
				}

				if ( false !== strpos( strtolower( $current_day_hours ), strtolower( $availability_status[1][0] ) ) || false !== strpos( strtolower( $current_day_hours ), strtolower( $availability_status[1][1] ) ) ) {
					$listar_company_is_open = 'listar-listing-open icon-alarm-check';
					$text_output = esc_html__( 'Now Open', 'listar' );
					$is_all_day_open_or_closed = true;
					$do_output = true;
					$output_status = 'open';
					$output_icon_class = 'icon-alarm-check';
				}

				if ( ! $is_all_day_open_or_closed ) :
					$multiple_day_hours = array( $current_day_hours );
				
					if ( false !== strpos( $current_day_hours, '*' ) ) {
						$multiple_day_hours = explode( '*', $current_day_hours );
					}
					
					foreach ( $multiple_day_hours as $multiple_day_hour ) {
						if ( false !== strpos( $multiple_day_hour, ' - ' ) ) :
							$temp = explode( ' - ', $multiple_day_hour );
							$open_time = trim( $temp[0] );
							$close_time = trim( $temp[1] );

							$condition1 = ( false !== strpos( $open_time, ' AM' ) || false !== strpos( $open_time, ' PM' ) ) && false !== strpos( $open_time, ' AM' ) || false !== strpos( $open_time, ':' );
							$condition2 = ( false !== strpos( $close_time, ' AM' ) || false !== strpos( $close_time, ' PM' ) ) && false !== strpos( $close_time, ' AM' ) || false !== strpos( $close_time, ':' );

							if ( $condition1 && $condition2 ) :
								$current_hour_timestap = strtotime( current_time( 'Y-m-d H:i' ) );
								$pm_add_open = false !== strpos( $open_time, ' PM' ) ? 12 : 0;
								$pm_add_close = false !== strpos( $close_time, ' PM' ) ? 12 : 0;
								$am_remove_open = false !== strpos( $open_time, ' AM' ) && false !== strpos( $open_time, '12:' ) ? 12 : 0;
								$am_remove_close = false !== strpos( $close_time, ' AM' ) && false !== strpos( $close_time, '12:' ) ? 12 : 0;

								$current_year_for_calc = current_time( 'Y' );
								$current_month_for_calc = current_time( 'm' );
								$current_day_for_calc = current_time( 'd' );

								$open_hour = substr( $open_time, 0, strpos( $open_time, ':' ) );
								$open_minute_temp = substr( $open_time, 0, strpos( $open_time, ' ' ) );
								$open_minute = substr( $open_minute_temp, strpos( $open_minute_temp, ':' ) + 1 );

								$open_hour_integer_temp = ( (int) $open_hour );
								$open_hour_integer = 12 === $open_hour_integer_temp ? 12 - $am_remove_open : $open_hour_integer_temp + $pm_add_open;
								$open_hour_string = str_pad( $open_hour_integer, 2, '0', STR_PAD_LEFT );
								$open_hours_for_calc = $current_year_for_calc . '-' . $current_month_for_calc . '-' . $current_day_for_calc . ' ' . $open_hour_string . ':' . $open_minute;
								$open_hours_timestamp = strtotime( $open_hours_for_calc );

								$close_hour = substr( $close_time, 0, strpos( $close_time, ':' ) );
								$close_minute_temp = substr( $close_time, 0, strpos( $close_time, ' ' ) );
								$close_minute = substr( $close_minute_temp, strpos( $close_minute_temp, ':' ) + 1 );

								$close_hour_integer_temp = ( (int) $close_hour );
								$close_hour_integer = 12 === $close_hour_integer_temp ? 12 - $am_remove_close : $close_hour_integer_temp + $pm_add_close;
								$close_hour_string = str_pad( $close_hour_integer, 2, '0', STR_PAD_LEFT );
								$close_hours_for_calc = $current_year_for_calc . '-' . $current_month_for_calc . '-' . $current_day_for_calc . ' ' . $close_hour_string . ':' . $close_minute;
								$close_hours_timestamp = strtotime( $close_hours_for_calc );

								if ( $hasOpenHour || ( $open_hours_timestamp <= $current_hour_timestap && $current_hour_timestap <= $close_hours_timestamp ) ) {
									$hasOpenHour = true;
									$listar_company_is_open = 'listar-listing-open icon-alarm-check';
									$text_output = esc_html__( 'Now Open', 'listar' );
									$output_status = 'open';
									$output_icon_class = 'icon-alarm-check';
									
								} else {
									$listar_company_is_open = 'listar-listing-closed icon-alarm-error';
									$text_output = esc_html__( 'Now Closed', 'listar' );
									$output_status = 'closed';
									$output_icon_class = 'icon-alarm-error';
								}

								$do_output = true;
							endif;
						endif;
					}
				endif;

				if ( $do_output ) :
					$output_status_html  = '<div class="listar-open-or-closed ' . esc_attr( listar_sanitize_html_class( $listar_company_is_open ) ) . '" data-short-open="' . esc_attr( $short_open_string ) . '" data-short-closed="' . esc_attr( $short_closed_string ) . '">';
					$output_status_html .= '<span>' . esc_html( $text_output ) . '</span>';
					$output_status_html .= '</div>';
				endif;
			endif;

			/* Generate the operation hours table for single listing pages */

			if ( $get_table ) :
				for ( $j = 0; $j < 7; $j++ ) {
					$day_slug = strtolower( $days[ $j ][0] );
					$day_short_slug = substr( $day_slug, 0, 3 );
					$translated_day_name = $days[ $j ][1];
					$day_first_letter = strtoupper( $translated_day_name[0] );
					$feature_current_day = $english_current_day === $days[ $j ][0] ? ' listar-featured-day' : '';
					$text_output = '';
					$operating_hours_format = get_option( 'listar_operating_hours_format' );

					if ( empty( $operating_hours_format ) ) {
						$operating_hours_format = '24';
					}

					$day_hours = get_post_meta( $post_id, '_job_business_hours_' . $day_slug, true );
					
					$hours_format_24_search = array(
						'12:00 AM',
						'01:00 PM',
						'01:30 PM',
						'02:00 PM',
						'02:30 PM',
						'03:00 PM',
						'03:30 PM',
						'04:00 PM',
						'04:30 PM',
						'05:00 PM',
						'05:30 PM',
						'06:00 PM',
						'06:30 PM',
						'07:00 PM',
						'07:30 PM',
						'08:00 PM',
						'08:30 PM',
						'09:00 PM',
						'09:30 PM',
						'10:00 PM',
						'10:30 PM',
						'11:00 PM',
						'11:30 PM',
						'11:59 PM',
					);

					$hours_format_24_replace = array(
						'00:00 AM',
						'13:00',
						'13:30',
						'14:00',
						'14:30',
						'15:00',
						'15:30',
						'16:00',
						'16:30',
						'17:00',
						'17:30',
						'18:00',
						'18:30',
						'19:00',
						'19:30',
						'20:00',
						'20:30',
						'21:00',
						'21:30',
						'22:00',
						'22:30',
						'23:00',
						'23:30',
						'24:00',
					);

					if ( ! empty( $day_hours ) ) :
						$is_all_day_open_or_closed = false;

						if ( false !== strpos( strtolower( $day_hours ), strtolower( $availability_status[0][0] ) ) || false !== strpos( strtolower( $day_hours ), strtolower( $availability_status[0][1] ) ) ) {
							$text_output = esc_html__( 'Closed', 'listar' );
							$is_all_day_open_or_closed = true;
						}

						if ( false !== strpos( strtolower( $day_hours ), strtolower( $availability_status[1][0] ) ) || false !== strpos( strtolower( $day_hours ), strtolower( $availability_status[1][1] ) ) ) {
							$text_output = esc_html__( 'Open 24 Hours', 'listar' );
							$is_all_day_open_or_closed = true;
						}

						if ( $is_all_day_open_or_closed ) :
							$output_table_html .= '<tr class="listar-business-hours-row-' . $day_short_slug . $feature_current_day . '">';
							$output_table_html .= '<td class="listar-business-day">';
							$output_table_html .= '<span class="listar-business-day-letter">' . $day_first_letter . '</span>';
							$output_table_html .= '<span class="listar-business-day-name">' . $translated_day_name . '</span>';
							$output_table_html .= '</td>';
							$output_table_html .= '<td class="listar-business-start-time-field">';
							$output_table_html .= '<div class="listar-business-time-wrapper">';
							$output_table_html .= '<div>';
							$output_table_html .= '<span class="listar-business-hour">';
							$output_table_html .= $text_output;
							$output_table_html .= '</span>';
							$output_table_html .= '</span>';
							$output_table_html .= '</div>';
							$output_table_html .= '</td>';
							$output_table_html .= '</tr>';
						endif;

						if ( ! $is_all_day_open_or_closed ) :
							if ( ! empty( $day_hours ) ) :
								
								$multiple_day_hours = array( $day_hours );

								if ( false !== strpos( $day_hours, '*' ) ) {
									$multiple_day_hours = explode( '*', $day_hours );
								}
								
								$output_table_html .= '<tr class="listar-business-hours-row-' . $day_short_slug . $feature_current_day . '">';
								$output_table_html .= '<td class="listar-business-day">';
								$output_table_html .= '<span class="listar-business-day-letter">' . $day_first_letter . '</span>';
								$output_table_html .= '<span class="listar-business-day-name">' . $translated_day_name . '</span>';
								$output_table_html .= '</td>';
								$output_table_html .= '<td class="listar-business-start-time-field">';
								$output_table_html .= '<div class="listar-business-time-wrapper">';

								foreach ( $multiple_day_hours as $multiple_day_hour ) {

									if ( '24' === $operating_hours_format ) {
										$multiple_day_hour = str_replace( $hours_format_24_search, $hours_format_24_replace, $multiple_day_hour );

										if( 1 === $output_am_pm ) {
											$multiple_day_hour = str_replace( array( ' AM', ' PM' ), '', $multiple_day_hour );
										}
									}

									if ( false !== strpos( $multiple_day_hour, ' - ' ) ) {
										$multiple_day_hour = str_replace( ' - ', ' <span class="listar-no-wrap">- ', $multiple_day_hour ) . '</span>';
									}
									
									$output_table_html .= '<div>';
									$output_table_html .= '<span class="listar-business-hour">';
									$output_table_html .= $multiple_day_hour;
									$output_table_html .= '</span>';
									$output_table_html .= '</div>';
								}

								$output_table_html .= '</div>';
								$output_table_html .= '</td>';
								$output_table_html .= '</tr>';
							endif;
						endif;
					endif;
				}
			endif;

			if ( $get_table && ! empty( $output_table_html ) ) {
				$output_table_html = $output_talble_html_before . $output_table_html . $output_talble_html_after;
			}

			return array( $output_status, $output_status_html, $output_table_html, $output_icon_class );
		endif;

		return array( '', '', '' );
	}

endif;


if ( ! function_exists( 'listar_get_domain' ) ) :
	/**
	 * Get the domain part from a URL.
	 *
	 * @since 1.0
	 * @link https://stackoverflow.com/questions/30650300/php-get-domain-without-subdomain-of-any-address-available-as-string
	 * @param (string) $full_url Any URL (e.g http://domain.com/file.html).
	 * @return (array)
	 */
	function listar_get_domain( $full_url ) {

		$url = wp_parse_url( $full_url );
		
		if ( isset( $url['host'] ) && $url && ! empty( $url['host'] ) ) {
			
			$actual_host_name = $url['host']; 

			$domain_parts = explode( '.', $actual_host_name );
			$count_domain_parts = count( $domain_parts );

			for ( $i = $count_domain_parts - 1; $i >= 0; $i-- ){
				$temp_domain = '';
				$current_country = null;

				for ( $j = $count_domain_parts - 1; $j >= $i; $j-- ){
					$temp_domain = $domain_parts[ $j ] . '.' . $temp_domain;

					if ( null === $current_country ){
						$current_country = $domain_parts[ $j ];
					}
				}

				$domain = trim( $temp_domain, '.' );
				$valid_record = checkdnsrr( $domain, 'A' ); // Looking for Class A records.

				if ( $valid_record ){
					$host_ip = gethostbyname( $domain );  
					$valid_record &= ( $host_ip != $domain );

					if ( ! $valid_record ){
						$valid_record = false;
					}
				}

				// Valid record?
				if ( $valid_record ){
					return array( $domain, $actual_host_name );
				}
			}

			return false;
		}

		return false;
	}
endif;


if ( ! function_exists( 'listar_get_domain_name' ) ) :
	/**
	 * Get the domain name from a URL.
	 *
	 * @since 1.0
	 * @param (string) $url Any URL (e.g http://domain.com/file.html).
	 * @param (boolean) $with_subdomain If the subdomain should be returned too.
	 * @return (array)
	 */
	function listar_get_domain_name( $url, $with_subdomain = false ) {

		$url_array = array();
		$url_sanitized = false;
		
		if ( ! empty( $url ) ) {
			$url_sanitized = str_replace( 'www.', '', esc_url( trim( $url ) ) );
		}
		
		if ( ! empty( $url_sanitized ) ) {
			$parse = wp_parse_url( $url_sanitized );
			
			if ( isset( $parse['host'] ) && $parse && ! empty( $parse['host'] ) ) {

				if ( ! isset( $parse['scheme'] ) || empty( $parse['scheme'] ) ) {
					$url_sanitized = 'http://' . str_replace( 'www.', '', $url_sanitized );
					$url_array['scheme'] = 'http://';
				} else {
					$url_array['scheme'] = $parse['scheme'];
				}

				$url_array['url_exists'] = listar_url_exists( $url_sanitized );
				$url_array['url'] = listar_sanitize_url( $url_sanitized );
				$temp_host = listar_get_domain( $url_sanitized, true );
				
				if ( $with_subdomain && false !== strpos( $temp_host[1], '.' . $temp_host[0] ) ) {
					$domain_name = current( explode( '.', $temp_host[0] ) );
					$url_array['host'] = current( explode( '.' . $domain_name, $temp_host[1] ) ) . '.' . $domain_name;
				} else {
					$url_array['host'] = current( explode( '.', $temp_host[0] ) );
				}
			}
		}
		
		return $url_array;
	}
endif;


if ( ! function_exists( 'listar_is_map_enabled' ) ) :
	/**
	 * Check if maps are partially, full or not enabled.
	 *
	 * @param (string) $feature What map feature to verify. Use 'all' to verify if maps are completely disabled. Values: all, single, archive, directions, gps
	 * @since 1.2.9
	 * @return (string)
	 */
	function listar_is_map_enabled( $feature = 'all' ) {
		$check = (int) get_option( 'listar_disable_' . $feature . '_maps' );
		$listar_location_disable = (int) get_option( 'listar_location_disable' );
		
		return 1 === $check || 1 === $listar_location_disable ? false : true;
	}
endif;


if ( ! function_exists( 'listar_geocoder_curl_attempts' ) ) :
	/**
	 * Force more than one connection attempt against map providers.
	 *
	 * @param (string) $url URL for cURL
	 * @param (string) $address Location address.
	 * @param (string) $check_index Array key name that must exist on returned JSON.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @param (boolean) $deep_check Use strpos to find $check_index if this key is very inside on a multidimensional array.
	 * @param (boolean) $adapt_language If default language fail, try to remove suffix or use en.
	 * @param (string) $curl_method GET or POST method for cURL.
	 * @param (boolean) $geolocateCoordinates Inform if coordinates are being sent.
	 * @param (boolean) $append_data Append data to POST method?
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_geocoder_curl_attempts( $url = '', $address = '', $check_index = '', $language = 'en', $deep_check = false, $adapt_language = true, $curl_method = 'GET', $geolocateCoordinates = false, $append_data = true ) {
		$array_data = array();
		$language_has_hyphen = false !== strpos( $language, '-' );
		$language_has_underline = false !== strpos( $language, '_' );
		$deep_check_valid = false;

		if ( ! empty( $url ) && ! empty( $address ) && ! empty( $check_index ) && ! empty( $language ) ) {

			// Make three attempts with custom language.

			for ( $i = 0; $i < 3; $i++ ) {
				$contents = 'GET' === $curl_method ? listar_connect_curl( $url ) : listar_connect_curl_post( $url, $address, $language, $geolocateCoordinates, $append_data );
				
				if ( ! empty( $contents ) ) {
					$array_data = json_decode( $contents, true );
					
					if ( $deep_check ) {
						$check = strpos( $contents , $check_index ) > 0 ? true : false;
						
						if ( $check ) {
							$deep_check_valid = true;
							$array_data['language'] = $language;
							break;
						}
					} elseif ( isset( $array_data[ $check_index ] ) && ! empty( $array_data[ $check_index ] ) ) {
						$array_data['language'] = $language;
						break;
					}
				}
			}

			if ( $adapt_language && ( ! $deep_check_valid && ( ! isset( $array_data[ $check_index ] ) || empty( $array_data[ $check_index ] ) ) ) && ( $language_has_hyphen || $language_has_underline ) ) {

				$language2 = $language;
				
				if ( $language_has_hyphen ) {
					$language2 = substr( $language2, 0, strpos( $language2, '-' ) ); 
				}
				
				if ( $language_has_underline ) {
					$language2 = substr( $language2, 0, strpos( $language2, '_' ) ); 
				}
				
				if ( $language2 !== $language ) {
					$search = array(
						'language=' . $language,
					);

					$replace = array(
						'language=' . $language2,
					);

					$url = str_replace( $search, $replace, $url );

					// Make three attempts in english.

					for ( $i = 0; $i < 3; $i++ ) {
						$contents = 'GET' === $curl_method ? listar_connect_curl( $url ) : listar_connect_curl_post( $url, $address, $language, $geolocateCoordinates );

						if ( ! empty( $contents ) ) {
							$array_data = json_decode( $contents, true );

							if ( $deep_check ) {
								$check = strpos( $contents , $check_index ) > 0 ? true : false;

								if ( $check ) {
									$deep_check_valid = true;
									$array_data['language'] = $language2;
									break;
								}
							} elseif ( isset( $array_data[ $check_index ] ) && ! empty( $array_data[ $check_index ] ) ) {
								$array_data['language'] = $language2;
								break;
							}
						}
					}
					
				}
			}

			if ( $adapt_language && ! $deep_check_valid && ( ! isset( $array_data[ $check_index ] ) || empty( $array_data[ $check_index ] ) ) ) {

				$search = array(
					'language=' . $language,
				);

				$replace = array(
					'language=en',
				);

				$url = str_replace( $search, $replace, $url );

				// Make three attempts in english.

				for ( $i = 0; $i < 3; $i++ ) {
					$contents = 'GET' === $curl_method ? listar_connect_curl( $url ) : listar_connect_curl_post( $url, $address, $language, $geolocateCoordinates );

					if ( ! empty( $contents ) ) {
						$array_data = json_decode( $contents, true );

						if ( $deep_check ) {
							$check = strpos( $contents , $check_index ) > 0 ? true : false;

							if ( $check ) {
								$deep_check_valid = true;
								$array_data['language'] = 'en';
								break;
							}
						} elseif ( isset( $array_data[ $check_index ] ) && ! empty( $array_data[ $check_index ] ) ) {
							$array_data['language'] = 'en';
							break;
						}
					}
				}
			}
		}
		
		return $deep_check_valid || ( isset( $array_data[ $check_index ] ) && ! empty( $array_data[ $check_index ] ) ) ? $array_data : array();
	}
endif;


if ( ! function_exists( 'listar_connect_curl' ) ) :
	/**
	 * Start a cURL connection to get data from external URLs.
	 *
	 * @param (string) $url URL for cURL.
	 * @since 1.3.0
	 * @return (string)
	 */
	function listar_connect_curl( $url = '' ) {
		$contents = '';
		
		// Need for Openstreetmaps.
		$agents = array(
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
			'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
		);

		if ( ! empty( $url ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_REFERER, network_site_url() );
			curl_setopt( $ch, CURLOPT_USERAGENT, $agents[ array_rand( $agents ) ] );
			$contents = curl_exec( $ch );
			curl_close( $ch );
		}

		return $contents;
	}
endif;


if ( ! function_exists( 'listar_connect_curl_post_fail' ) ) :
	/**
	 * Try GET method if POST fails.
	 *
	 * @param (string) $url URL for cURL
	 * @param (string) $address Location address.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @param (boolean) $geolocateCoordinates Inform if coordinates are being sent.
	 * @since 1.4.6
	 * @return (string)
	 */
	function listar_connect_curl_post_fail( $url = '', $address = '', $language = '', $geolocateCoordinates = false ) {
	
		$contents = '';

		if ( ! empty( $url ) && ! empty( $address ) && ! empty( $language ) ) {
			
			//echo 8888;
			
			$geolocateCoordinates_get = $geolocateCoordinates ? 'true' : 'false';
	
			$url_get = $url . '?address=' .  urlencode( $address ) . '&language=' .  urlencode( $language ) . '&isSendingCoordinates=' .  urlencode( $geolocateCoordinates_get );
			
			//echo $url_get;
			
			
			// Prepare new cURL resource
			$crl = curl_init();

			// Prepare new cURL resource
			//curl_setopt( $crl, CURLOPT_URL, $url );
			//curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
			//curl_setopt( $crl, CURLINFO_HEADER_OUT, true );
			//curl_setopt( $crl, CURLOPT_POST, count( $data ) );
			//curl_setopt( $crl, CURLOPT_POSTFIELDS, $post_data );
			
			/* ********************************************************** */
			
			//$url = 'https://wt.ax/mapplus/geocoder.php';
			
			//printf('<pre>%s</pre>', var_export($url,true));
			//printf('<pre>%s</pre>', var_export($address,true));
			//printf('<pre>%s</pre>', var_export($language,true));
			//printf('<pre>%s</pre>', var_export($isSendingCoordinates,true));
			
			$agents = array(
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
				'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
				'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
				'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
			);
			
			$headers = array();
			
			//for post calls:
			//$post = 'a=b&d=c';
			$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=utf-8';
			//$headers[] = 'Content-Length: ' . strlen($post);

			//for get calls:
			//$headers = array();
			//$headers[] = 'Content-type: charset=utf-8'; 


			//$headers[] = 'Connection: Keep-Alive';
			
			$options = array(
				CURLOPT_URL             => $url_get,
				CURLOPT_RETURNTRANSFER  => true,
				CURLOPT_REFERER         => network_site_url(),
				CURLOPT_USERAGENT       => $agents[ array_rand( $agents ) ],
				
				/*
				CURLINFO_HEADER_OUT     => true,
				CURLOPT_POST            => count( $data ),
				CURLOPT_POSTFIELDS      => $post_data,
				
				CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_ENCODING        => '',
				
				CURLOPT_AUTOREFERER     => true,
				CURLOPT_CONNECTTIMEOUT  => 120,
				CURLOPT_TIMEOUT_MS      => 12000,
				CURLOPT_TIMEOUT         => 120,
				CURLOPT_MAXREDIRS       => 10,
				CURLOPT_SSL_VERIFYPEER  => false,
				CURLOPT_SSL_VERIFYHOST  => false,
				CURLOPT_HTTPHEADER      => array( "User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0" ),
				// CURLOPT_HTTPHEADER   => $headers,
				 * 
				 */
			);
			
			curl_setopt_array( $crl, $options );
			
			
			// Submit the POST request
			$contents = curl_exec( $crl );
			
			//print curl_error($crl);

			// Close cURL session handle
			curl_close( $crl );
			
		}

		return $contents;
	}
endif;


if ( ! function_exists( 'listar_connect_curl_post' ) ) :
	/**
	 * Start a cURL connection to get data from external URLs.
	 *
	 * @param (string) $url URL for cURL
	 * @param (string) $address Location address.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @param (boolean) $geolocateCoordinates Inform if coordinates are being sent.
	 * @param (boolean) $append_data Append data to POST method?
	 * @since 1.3.0
	 * @return (string)
	 */
	function listar_connect_curl_post( $url = '', $address = '', $language = '', $geolocateCoordinates = false, $append_data = true ) {
	
		$contents = '';

		if ( ! empty( $url ) && ! empty( $address ) && ! empty( $language ) ) {
			
			$isSendingCoordinates = $geolocateCoordinates ? 'yes' : 'no';
	
			$data = array(
				'address'  => $address,
				'language' => $language,
				'isSendingCoordinates' => $isSendingCoordinates,
			);
			
			// Prepare new cURL resource
			$crl = curl_init();
			
			//$post_data = http_build_query( $data );
			
			$post_data = http_build_query( $data );

			// Prepare new cURL resource
			//curl_setopt( $crl, CURLOPT_URL, $url );
			//curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
			//curl_setopt( $crl, CURLINFO_HEADER_OUT, true );
			//curl_setopt( $crl, CURLOPT_POST, count( $data ) );
			//curl_setopt( $crl, CURLOPT_POSTFIELDS, $post_data );
			
			/* ********************************************************** */
			
			//$url = 'https://wt.ax/mapplus/geocoder.php';
			
			//printf('<pre>%s</pre>', var_export($url,true));
			//printf('<pre>%s</pre>', var_export($address,true));
			//printf('<pre>%s</pre>', var_export($language,true));
			//printf('<pre>%s</pre>', var_export($isSendingCoordinates,true));
			
			$agents = array(
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
				'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
				'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
				'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
			);
			
			$headers = array();
			
			//for post calls:
			//$post = 'a=b&d=c';
			$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=utf-8';
			//$headers[] = 'Content-Length: ' . strlen($post);

			//for get calls:
			//$headers = array();
			//$headers[] = 'Content-type: charset=utf-8'; 


			//$headers[] = 'Connection: Keep-Alive';
			
			$options = array(
				CURLOPT_URL             => $url,
				CURLOPT_RETURNTRANSFER  => true,
				CURLINFO_HEADER_OUT     => true,				
				
				CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_ENCODING        => '',
				CURLOPT_USERAGENT       => $agents[ array_rand( $agents ) ],
				CURLOPT_REFERER         => network_site_url(),
				CURLOPT_AUTOREFERER     => true,
				CURLOPT_CONNECTTIMEOUT  => 120,
				CURLOPT_TIMEOUT_MS      => 12000,
				CURLOPT_TIMEOUT         => 120,
				CURLOPT_MAXREDIRS       => 10,
				CURLOPT_SSL_VERIFYPEER  => false,
				CURLOPT_SSL_VERIFYHOST  => false,
				CURLOPT_HTTPHEADER      => array( "User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0" ),
				// CURLOPT_HTTPHEADER   => $headers,
			);

			if ( $append_data ) {
				$options[ CURLOPT_POST ] = count( $data );			
				$options[ CURLOPT_POSTFIELDS ] = $post_data;			
			}
			
			curl_setopt_array( $crl, $options );			
			
			
			// Submit the POST request
			$contents = curl_exec( $crl );
			
			//print curl_error($crl);
			
			$resultStatus = (int) curl_getinfo( $crl, CURLINFO_HTTP_CODE );
			
			//echo $url;
			//printf('<pre>%s</pre>', var_export($resultStatus,true));
			
			//printf('<pre>%s</pre>', var_export($contents,true));

			// Close cURL session handle
			curl_close( $crl );
			
			if ( 0 === $resultStatus ) {
				$contents = listar_connect_curl_post_fail( 'http://wt.ax/mapplus/geocoder_get.php', $address, $language, $geolocateCoordinates );
			}
		}

		return $contents;
	}
endif;

if ( ! function_exists( 'listar_mapbox_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $token API token for map provider.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_mapbox_geocoding( $address = '', $token = '', $language = '' ) {
		$geolocated = '';
		$city = '';
		$country = '';
		$country_short = '';
		$addr = '';
		$lat = '';
		$lng = '';
		$postcode = '';
		$state = '';
		$state_short = '';
		$street = '';
		$number = '';
		$address_bk = $address;
		$language_bk = $language;

		if ( ! empty( $address ) && ! empty( $token ) && ! empty( $language ) ) {
			$provider = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';
			$address = rawurlencode( $address );
			$limit = '1';
			$url = $provider . $address . '.json?language=' . $language . '&access_token=' . $token . '&limit=' . $limit;
			
			$array_data = listar_geocoder_curl_attempts( $url, $address_bk, 'features', $language );

			if ( ! empty( $array_data ) && isset( $array_data['language'] ) && ! empty( $array_data['language'] ) ) {
				$features = $array_data['features'];
				$text_language = 'text_' . $array_data['language'];
				$text = 'text';
				$place_name_language = 'place_name_' . $array_data['language'];
				$place_name = 'place_name';
				$short_code = 'short_code';
				$order = 0;

				foreach( $features as $feature ) {
					if ( isset( $feature['id'] ) && ! empty( $feature['id'] ) ) {
						$id = $feature['id'];

						if ( empty( $city ) && false !== strpos( $id, 'place.' ) ) {

							// geolocation_city.

							if ( isset( $feature[ $text_language ] ) && ! empty( $feature[ $text_language ] ) ) {
								$city = $feature[ $text_language ];
							} elseif ( isset( $feature[ $text ] ) && ! empty( $feature[ $text ] ) ) {
								$city = $feature[ $text ];
							}
						}

						if ( false !== strpos( $id, 'address.' ) || false !== strpos( $id, 'place.' ) ) {

							if ( empty( $addr ) ) {

								// geolocation_formatted_address.

								if ( isset( $feature[ $place_name_language ] ) && ! empty( $feature[ $place_name_language ] ) ) {
									$addr = $feature[ $place_name_language ];
								} elseif ( isset( $feature[ $place_name ] ) && ! empty( $feature[ $place_name ] ) ) {
									$addr = $feature[ $place_name ];
								}
							}

							if ( false === strpos( $id, 'place.' ) ) {

								if ( empty( $street ) ) {

									// geolocation_street.

									if ( isset( $feature[ $text_language ] ) && ! empty( $feature[ $text_language ] ) ) {
										$street = $feature[ $text_language ];
									} elseif ( isset( $feature[ $text ] ) && ! empty( $feature[ $text ] ) ) {
										$street = $feature[ $text ];
									}
								}

								if ( empty( $number ) ) {

									// geolocation_street_number.

									if ( isset( $feature[ 'address' ] ) && ! empty( $feature[ 'address' ] ) ) {
										$number = $feature[ 'address' ];
									}
								}
							}

							if ( isset( $feature['geometry'] ) && ! empty( $feature['geometry'] ) ) {
								$geometry = $feature['geometry'];

								if ( isset( $geometry['type'] ) && 'Point' === $geometry['type'] ) {

									// geolocation_lat.

									if ( empty( $lat ) ) {
										if ( isset( $geometry['coordinates'][1] ) && ! empty( $geometry['coordinates'][1] ) ) {
											$lat = $geometry['coordinates'][1];
										}
									}

									// geolocation_long.

									if ( empty( $lng ) ) {
										if ( isset( $geometry['coordinates'][0] ) && ! empty( $geometry['coordinates'][0] ) ) {
											$lng = $geometry['coordinates'][0];
										}
									}
								}
							}
						}
					}

					if ( isset( $feature['context'] ) && ! empty( $feature['context'] ) ) {
						$contexts = $feature['context'];

						foreach( $contexts as $context ) {
							if ( isset( $context['id'] ) && ! empty( $context['id'] ) ) {
								$context_id = $context['id'];

								if ( empty( $country ) && false !== strpos( $context_id, 'country.' ) ) {

									// geolocation_country_long.

									if ( isset( $context[ $text_language ] ) && ! empty( $context[ $text_language ] ) ) {
										$country = $context[ $text_language ];
									} elseif ( isset( $context[ $text ] ) && ! empty( $context[ $text ] ) ) {
										$country = $context[ $text ];
									}
								}

								if ( empty( $country_short ) && false !== strpos( $context_id, 'country.' ) ) {

									//geolocation_country_short.

									if ( isset( $context[ $short_code ] ) && ! empty( $context[ $short_code ] ) ) {
										$country_short = strtoupper( $context[ $short_code ] );
									}
								}

								if ( empty( $city ) && false !== strpos( $context_id, 'place.' ) ) {

									// Try city again inside context: geolocation_city.

									if ( isset( $context[ $text_language ] ) && ! empty( $context[ $text_language ] ) ) {
										$city = $context[ $text_language ];
									} elseif ( isset( $context[ $text ] ) && ! empty( $context[ $text ] ) ) {
										$city = $context[ $text ];
									}
								}

								if ( empty( $postcode ) && false !== strpos( $context_id, 'postcode.' ) ) {

									// geolocation_postcode.

									if ( isset( $context[ $text_language ] ) && ! empty( $context[ $text_language ] ) ) {
										$postcode = $context[ $text_language ];
									} elseif ( isset( $context[ $text ] ) && ! empty( $context[ $text ] ) ) {
										$postcode = $context[ $text ];
									}
								}

								if ( false !== strpos( $context_id, 'region.' ) ) {

									if ( empty( $state ) ) {

										// geolocation_state_long.

										if ( isset( $context[ $text_language ] ) && ! empty( $context[ $text_language ] ) ) {
											$state = $context[ $text_language ];
										} elseif ( isset( $context[ $text ] ) && ! empty( $context[ $text ] ) ) {
											$state = $context[ $text ];
										}
									}

									if ( empty( $state_short ) ) {

										// geolocation_state_short.

										if ( isset( $context[ $short_code ] ) && ! empty( $context[ $short_code ] ) ) {
											$state_short = $context[ $short_code ];

											if ( false !== strpos( $state_short, '-' ) ) {
												$state_short = ltrim( stristr( $state_short, '-' ), '-' );
											}
										}
									}
								}
							}
						}
					}

					$order++;
				}
				
				if ( ! empty( $lat ) && ! empty( $lng ) ) {
					$geolocated = '1';
				}
			}
		}
		
		if ( empty( $geolocated ) ) {
			
			// Did the provider failed? Try another.
			return listar_openstreetmap_geocoding( $address_bk, $language_bk );
		}

		return array(
			'geolocated'                    => $geolocated,
			'geolocation_city'              => $city,
			'geolocation_country_long'      => $country,
			'geolocation_country_short'     => $country_short,
			'geolocation_formatted_address' => $addr,
			'geolocation_lat'               => $lat,
			'geolocation_long'              => $lng,
			'geolocation_postcode'          => $postcode,
			'geolocation_state_long'        => $state,
			'geolocation_state_short'       => $state_short,
			'geolocation_street'            => $street,
			'geolocation_street_number'     => $number ,
		);
	}
endif;

if ( ! function_exists( 'listar_jawg_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $token API token for map provider.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_jawg_geocoding( $address = '', $token = '', $language = '' ) {
		$geolocated = '';
		$city = '';
		$country = '';
		$country_short = '';
		$addr = '';
		$lat = '';
		$lng = '';
		$postcode = '';
		$state = '';
		$state_short = '';
		$street = '';
		$number = '';
		$address_bk = $address;
		$language_bk = $language;

		if ( empty( $language ) ) {
			$language = 'en';
			$language_bk = $language;
		}

		if ( ! empty( $address ) && ! empty( $token ) && ! empty( $language ) ) {
			$provider = 'https://api.jawg.io/places/v1/search?text=';
			$address = rawurlencode( $address );
			$limit = '1';
			$url = $provider . $address . '&lang=' . $language . '&access-token=' . $token . '&size=' . $limit;
			echo $url;
			
			$array_data = listar_geocoder_curl_attempts( $url, $address_bk, 'geocoding', $language, true, $adapt_language = true, $curl_method = 'POST', false, false );

			if ( ! empty( $array_data ) && isset( $array_data['language'] ) && ! empty( $array_data['language'] ) ) {
				$features = $array_data['features'];
				$text_language = 'text_' . $array_data['language'];
				$text = 'text';
				$place_name_language = 'place_name_' . $array_data['language'];
				$place_name = 'place_name';
				$short_code = 'short_code';
				$order = 0;

				foreach( $features as $feature ) {
					if ( isset( $feature['properties']['id'] ) && ! empty( $feature['properties']['id'] ) ) {
						$geometry = isset( $feature['geometry']['coordinates'][1] ) ? $feature['geometry']['coordinates'] : array();
						$feature = $feature['properties'];
						$id = $feature['id'];

						if ( isset( $feature['locality'] ) && ! empty( $feature['locality'] ) ) {

							// geolocation_city.
							$city = $feature['locality'];
						}

						if ( isset( $feature['label'] ) && ! empty( $feature['label'] ) ) {

							// geolocation_formatted_address.
							$addr = $feature['label'];
						}

						if ( isset( $feature['street'] ) && ! empty( $feature['street'] ) ) {

							// geolocation_street.
							$street = $feature['street'];
						}

						if ( isset( $feature['housenumber'] ) && ! empty( $feature['housenumber'] ) ) {

							// geolocation_street_number.
							$number = $feature['housenumber'];
						}

						if ( isset( $geometry[1] ) ) {

							// geolocation_lat.
							$lat = $geometry[1];
						}

						if ( isset( $geometry[0] ) ) {

							// geolocation_long.
							$lng = $geometry[0];
						}

						if ( isset( $feature['country'] ) && ! empty( $feature['country'] ) ) {

							// geolocation_country_long.
							$country = $feature['country'];
						}

						if ( isset( $feature['country_code'] ) && ! empty( $feature['country_code'] ) ) {

							//geolocation_country_short.
							$country_short = $feature['country_code'];
						}

						if ( isset( $feature['postalcode'] ) && ! empty( $feature['postalcode'] ) ) {

							// geolocation_postcode.
							$postcode = $feature['postalcode'];
						}

						if ( isset( $feature['region'] ) && ! empty( $feature['region'] ) ) {

							// geolocation_state_long.
							$state = $feature['region'];
						}

						if ( isset( $feature['region_a'] ) && ! empty( $feature['region_a'] ) ) {

							// geolocation_state_short.
							$state_short = $feature['region_a'];
						}
					}

					$order++;
				}
				
				if ( ! empty( $lat ) && ! empty( $lng ) ) {
					$geolocated = '1';
				}
			}
		}
		
		if ( empty( $geolocated ) ) {
			
			// Did the provider failed? Try another.
			return listar_openstreetmap_geocoding( $address_bk, $language_bk );
		}

		return array(
			'geolocated'                    => $geolocated,
			'geolocation_city'              => $city,
			'geolocation_country_long'      => $country,
			'geolocation_country_short'     => $country_short,
			'geolocation_formatted_address' => $addr,
			'geolocation_lat'               => $lat,
			'geolocation_long'              => $lng,
			'geolocation_postcode'          => $postcode,
			'geolocation_state_long'        => $state,
			'geolocation_state_short'       => $state_short,
			'geolocation_street'            => $street,
			'geolocation_street_number'     => $number ,
		);
	}
endif;

if ( ! function_exists( 'listar_here_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $token API token for map provider.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_here_geocoding( $address = '', $token = '', $language = '' ) {
		$geolocated = '';
		$city = '';
		$country = '';
		$country_short = '';
		$addr = '';
		$lat = '';
		$lng = '';
		$postcode = '';
		$state = '';
		$state_short = '';
		$street = '';
		$number = '';
		$address_bk = $address;
		$language_bk = $language;

		if ( ! empty( $address ) && ! empty( $token ) && ! empty( $language ) ) {
			$provider = 'https://geocoder.ls.hereapi.com/6.2/geocode.json?gen=9&searchtext=';
			$address = rawurlencode( $address );
			$limit = '1';
			$url = $provider . $address . '.&language=' . $language . '&apiKey=' . $token . '&maxresults=' . $limit;
			
			$array_data = listar_geocoder_curl_attempts( $url, $address_bk, 'SearchResultsViewType', $language, true, false );
			
			if ( ! empty( $array_data ) && isset( $array_data['language'] ) && ! empty( $array_data['language'] ) ) {
				
				$feature = array();
				$order = 0;
				
				if ( isset( $array_data['Response']['View'][0]['Result'][0] ) && ! empty( $array_data['Response']['View'][0]['Result'][0] ) ) {
					$feature = $array_data['Response']['View'][0]['Result'][0];
				}

				if ( ! empty( $feature ) ) {
					
					// geolocation_city.
					if ( isset( $feature['Location']['Address']['City'] ) && ! empty( $feature['Location']['Address']['City'] ) ) {
						$city = $feature['Location']['Address']['City'];
					}
					
					if ( isset( $feature['Location']['Address']['AdditionalData'] ) && ! empty( $feature['Location']['Address']['AdditionalData'] ) ) {
						$arr1 = $feature['Location']['Address']['AdditionalData'];
						
						foreach( $arr1 as $arr ) {
							
							// geolocation_country_long.
							if ( isset( $arr['key'] ) && 'CountryName' === $arr['key'] ) {
								if ( isset( $arr['value'] ) && ! empty( $arr['value'] ) ) {
									$country = $arr['value'];
									break;
								}
							}
						}
						
						foreach( $arr1 as $arr ) {
						
							// geolocation_state_long.
							if ( isset( $arr['key'] ) && 'StateName' === $arr['key'] ) {
								if ( isset( $arr['value'] ) && ! empty( $arr['value'] ) ) {
									$state = $arr['value'];
									break;
								}
							}
						}
					}
					
					// geolocation_country_short.
					if ( isset( $feature['Location']['Address']['Country'] ) && ! empty( $feature['Location']['Address']['Country'] ) ) {
						$country_short = $feature['Location']['Address']['Country'];
					}
					
					// geolocation_formatted_address.
					if ( isset( $feature['Location']['Address']['Label'] ) && ! empty( $feature['Location']['Address']['Label'] ) ) {
						$addr = $feature['Location']['Address']['Label'];
					}
					
					// geolocation_lat.
					if ( isset( $feature['Location']['DisplayPosition']['Latitude'] ) && ! empty( $feature['Location']['DisplayPosition']['Latitude'] ) ) {
						$lat = $feature['Location']['DisplayPosition']['Latitude'];
					}
					
					// geolocation_long.
					if ( isset( $feature['Location']['DisplayPosition']['Longitude'] ) && ! empty( $feature['Location']['DisplayPosition']['Longitude'] ) ) {
						$lng = $feature['Location']['DisplayPosition']['Longitude'];
					}
					
					// geolocation_postcode.
					if ( isset( $feature['Location']['Address']['PostalCode'] ) && ! empty( $feature['Location']['Address']['PostalCode'] ) ) {
						$postcode = $feature['Location']['Address']['PostalCode'];
					}
					
					// geolocation_state_short.
					if ( isset( $feature['Location']['Address']['State'] ) && ! empty( $feature['Location']['Address']['State'] ) ) {
						$state_short = $feature['Location']['Address']['State'];
					}
					
					// geolocation_street.
					if ( isset( $feature['Location']['Address']['Street'] ) && ! empty( $feature['Location']['Address']['Street'] ) ) {
						$street = $feature['Location']['Address']['Street'];
					}
					
					// geolocation_street_number.
					if ( isset( $feature['Location']['Address']['HouseNumber'] ) && ! empty( $feature['Location']['Address']['HouseNumber'] ) ) {
						$number = $feature['Location']['Address']['HouseNumber'];
					}

					$order++;
				}			
				
				if ( ! empty( $lat ) && ! empty( $lng ) ) {
					$geolocated = '1';
				}
			}
		}
		
		if ( empty( $geolocated ) ) {
			
			// Did the provider failed? Try another.
			return listar_openstreetmap_geocoding( $address_bk, $language_bk );
		}

		return array(
			'geolocated'                    => $geolocated,
			'geolocation_city'              => $city,
			'geolocation_country_long'      => $country,
			'geolocation_country_short'     => $country_short,
			'geolocation_formatted_address' => $addr,
			'geolocation_lat'               => $lat,
			'geolocation_long'              => $lng,
			'geolocation_postcode'          => $postcode,
			'geolocation_state_long'        => $state,
			'geolocation_state_short'       => $state_short,
			'geolocation_street'            => $street,
			'geolocation_street_number'     => $number ,
		);
	}
endif;

if ( ! function_exists( 'listar_openstreetmap_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_openstreetmap_geocoding( $address = '', $language = '' ) {
		$geolocated = '';
		$city = '';
		$country = '';
		$country_short = '';
		$addr = '';
		$lat = '';
		$lng = '';
		$postcode = '';
		$state = '';
		$state_short = '';
		$street = '';
		$number = '';
		$address_bk = $address;
		$language_bk = $language;

		if ( ! empty( $address ) && ! empty( $language ) ) {
			$provider = 'https://nominatim.openstreetmap.org/search/';
			$address = rawurlencode( $address );
			$limit = '1';
			$other = '?format=json&addressdetails=1';
			$url = $provider . $address . $other . '&accept-language=' . $language . '&limit=' . $limit;
			
			$array_data = listar_geocoder_curl_attempts( $url, $address_bk, 'osm.org/copyright', $language, true, false );
			
			if ( isset( $array_data[0] ) && ! empty( $array_data[0] ) && isset( $array_data['language'] ) && ! empty( $array_data['language'] ) ) {
				
				$feature = $array_data[0];
				$order = 0;

				if ( ! empty( $feature ) ) {
					
					// geolocation_city.
					if ( isset( $feature['address']['city'] ) && ! empty( $feature['address']['city'] ) ) {
						$city = $feature['address']['city'];
					}
					
					// geolocation_country_long.
					if ( isset( $feature['address']['country'] ) && ! empty( $feature['address']['country'] ) ) {
						$country = $feature['address']['country'];
					}
					
					// geolocation_state_long.
					if ( isset( $feature['address']['state'] ) && ! empty( $feature['address']['state'] ) ) {
						$state = $feature['address']['state'];
					}
					
					// geolocation_country_short.
					if ( isset( $feature['address']['country_code'] ) && ! empty( $feature['address']['country_code'] ) ) {
						$country_short = strtoupper( $feature['address']['country_code'] );
					}
					
					// geolocation_formatted_address.
					if ( isset( $feature['display_name'] ) && ! empty( $feature['display_name'] ) ) {
						$addr = $feature['display_name'];
					}
					
					// geolocation_lat.
					if ( isset( $feature['lat'] ) && ! empty( $feature['lat'] ) ) {
						$lat = $feature['lat'];
					}
					
					// geolocation_long.
					if ( isset( $feature['lon'] ) && ! empty( $feature['lon'] ) ) {
						$lng = $feature['lon'];
					}
					
					// geolocation_postcode.
					if ( isset( $feature['address']['postcode'] ) && ! empty( $feature['address']['postcode'] ) ) {
						$postcode = $feature['address']['postcode'];
					}
					
					// geolocation_state_short: not available on Openstreetmap return.
					
					// geolocation_street.
					if ( isset( $feature['address']['road'] ) && ! empty( $feature['address']['road'] ) ) {
						$street = $feature['address']['road'];
					}
					
					// geolocation_street_number.
					if ( isset( $feature['address']['house_number'] ) && ! empty( $feature['address']['house_number'] ) ) {
						$number = $feature['address']['house_number'];
					}

					$order++;
				}			
				
				if ( ! empty( $lat ) && ! empty( $lng ) ) {
					$geolocated = '1';
				}
			}
		}
		
		if ( empty( $geolocated ) ) {
			
			// Did the provider failed? Try another.
			return listar_mapplus_geocoding( $address_bk, $language_bk );
		}

		return array(
			'geolocated'                    => $geolocated,
			'geolocation_city'              => $city,
			'geolocation_country_long'      => $country,
			'geolocation_country_short'     => $country_short,
			'geolocation_formatted_address' => $addr,
			'geolocation_lat'               => $lat,
			'geolocation_long'              => $lng,
			'geolocation_postcode'          => $postcode,
			'geolocation_state_long'        => $state,
			'geolocation_state_short'       => $state_short,
			'geolocation_street'            => $street,
			'geolocation_street_number'     => $number ,
		);
	}
endif;

if ( ! function_exists( 'listar_bingmaps_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $token API token for map provider.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_bingmaps_geocoding( $address = '', $token = '', $language = '' ) {
		$geolocated = '';
		$city = '';
		$country = '';
		$country_short = '';
		$addr = '';
		$lat = '';
		$lng = '';
		$postcode = '';
		$state = '';
		$state_short = '';
		$street = '';
		$number = '';
		$address_bk = $address;
		$language_bk = $language;

		if ( ! empty( $address ) && ! empty( $token ) && ! empty( $language ) ) {
			$provider = 'https://dev.virtualearth.net/REST/v1/Locations?q=';
			$address = rawurlencode( $address );
			$limit = '1';
			$other = '&incl=ciso2';
			$url = $provider . $address . '&culture=' . $language . '&key=' . $token . '&maxresults=' . $limit . $other;			

			$array_data = listar_geocoder_curl_attempts( $url, $address_bk, 'coordinates', $language, true, false );

			if ( ! empty( $array_data ) && isset( $array_data['language'] ) && ! empty( $array_data['language'] ) ) {
				
				$feature = array();
				$order = 0;
				
				if ( isset( $array_data['resourceSets'][0]['resources'][0] ) && ! empty( $array_data['resourceSets'][0]['resources'][0] ) ) {
					$feature = $array_data['resourceSets'][0]['resources'][0];
				}

				if ( ! empty( $feature ) ) {
					
					// geolocation_city.
					if ( isset( $feature['address']['locality'] ) && ! empty( $feature['address']['locality'] ) ) {
						$city = $feature['address']['locality'];
					}
					
					// geolocation_country_long.
					if ( isset( $feature['address']['countryRegion'] ) && ! empty( $feature['address']['countryRegion'] ) ) {
						$country = $feature['address']['countryRegion'];
					}
					
					// geolocation_state_long: Not available on Bing return.
					
					// geolocation_country_short.
					if ( isset( $feature['address']['countryRegionIso2'] ) && ! empty( $feature['address']['countryRegionIso2'] ) ) {
						$country_short = strtoupper( $feature['address']['countryRegionIso2'] );
					}
					
					// geolocation_formatted_address.
					if ( isset( $feature['address']['formattedAddress'] ) && ! empty( $feature['address']['formattedAddress'] ) ) {
						$addr = $feature['address']['formattedAddress'];
					}
					
					if ( empty( $addr ) ) {
						if ( isset( $feature['name'] ) && ! empty( $feature['name'] ) ) {
							$addr = $feature['name'];
						}
					}
					
					if ( empty( $addr ) ) {
						if ( isset( $feature['address']['addressLine'] ) && ! empty( $feature['address']['addressLine'] ) ) {
							$addr = $feature['address']['addressLine'];
						}
					}
					
					// geolocation_lat.
					if ( isset( $feature['point']['point']['coordinates'][0] ) && ! empty( $feature['point']['point']['coordinates'][0] ) ) {
						$lat = $feature['point']['point']['coordinates'][0];
					}
					
					if ( empty( $lat ) ) {
						if ( isset( $feature['geocodePoints'][0]['coordinates'][0] ) && ! empty( $feature['geocodePoints'][0]['coordinates'][0] ) ) {
							$lat = $feature['geocodePoints'][0]['coordinates'][0];
						}
					}
					
					// geolocation_long.
					if ( isset( $feature['point']['point']['coordinates'][1] ) && ! empty( $feature['point']['point']['coordinates'][1] ) ) {
						$lng = $feature['point']['point']['coordinates'][1];
					}
					
					if ( empty( $lng ) ) {
						if ( isset( $feature['geocodePoints'][0]['coordinates'][1] ) && ! empty( $feature['geocodePoints'][0]['coordinates'][1] ) ) {
							$lng = $feature['geocodePoints'][0]['coordinates'][1];
						}
					}
					
					// geolocation_postcode.
					if ( isset( $feature['address']['postalCode'] ) && ! empty( $feature['address']['postalCode'] ) ) {
						$postcode = $feature['address']['postalCode'];
					}
					
					// geolocation_state_short.
					if ( isset( $feature['address']['adminDistrict'] ) && ! empty( $feature['address']['adminDistrict'] ) ) {
						$state_short = $feature['address']['adminDistrict'];
					}
					
					// geolocation_street.
					if ( isset( $feature['address']['streetName'] ) && ! empty( $feature['address']['streetName'] ) ) {
						$street = $feature['address']['streetName'];
					}
					
					// geolocation_street_number.
					if ( isset( $feature['address']['houseNumber'] ) && ! empty( $feature['address']['houseNumber'] ) ) {
						$number = $feature['address']['houseNumber'];
					}

					$order++;
				}			
				
				if ( ! empty( $lat ) && ! empty( $lng ) ) {
					$geolocated = '1';
				}
			}
		}
		
		if ( empty( $geolocated ) ) {
			
			// Did the provider failed? Try another.
			return listar_openstreetmap_geocoding( $address_bk, $language_bk );
		}

		return array(
			'geolocated'                    => $geolocated,
			'geolocation_city'              => $city,
			'geolocation_country_long'      => $country,
			'geolocation_country_short'     => $country_short,
			'geolocation_formatted_address' => $addr,
			'geolocation_lat'               => $lat,
			'geolocation_long'              => $lng,
			'geolocation_postcode'          => $postcode,
			'geolocation_state_long'        => $state,
			'geolocation_state_short'       => $state_short,
			'geolocation_street'            => $street,
			'geolocation_street_number'     => $number ,
		);
	}
endif;


if ( ! function_exists( 'listar_mapplus_geocoding' ) ) :
	/**
	 * Capture geocoded data from a location address.
	 *
	 * @param (string) $address Location address.
	 * @param (string) $language Language for JSON response, set on Theme Options.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_mapplus_geocoding( $address = '', $language = '' ) {
		return listar_geocoder_curl_attempts( 'http://wt.ax/mapplus/geocoder.php', $address, 'geolocated', $language, true, false, 'POST' );
	}
endif;


if ( ! function_exists( 'listar_mapplus_geolocate' ) ) :
	/**
	 * Attempts to recover full address given latitude and longitude values
	 *
	 * @param (string) $latitude The latitude of a location.
	 * @param (string) $longitude The longitude of a location.
	 * @param (string) $language The language for returned data.
	 * @since 1.3.8
	 * @return (array)
	 */
	function listar_mapplus_geolocate( $latitude = '', $longitude = '', $language = '' ) {
		return listar_geocoder_curl_attempts( 'http://wt.ax/mapplus/geocoder.php', $latitude . '|' . $longitude, 'geolocated', $language, true, false, 'POST', true );
	}
endif;


if ( ! function_exists( 'listar_get_social_login_avatar' ) ) :
	/**
	 * Get social login image.
	 *
	 * @param (integer) $user_id A registered user ID.
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_get_social_login_avatar( $user_id = 0 ) {

		$author_pic = '';
		$avatar = '';

		if ( class_exists( 'LSL_Class' ) ) {
			global $wpdb;
			global $post;

			$wpdb->social = $wpdb->prefix . 'lsl_users_social_profile_details'; 
			
			if ( ! empty( $user_id ) ) {
				$avatar = $wpdb->get_results( "SELECT photo_url FROM $wpdb->social WHERE user_id=$user_id" );
			} else {
				$avatar = $wpdb->get_results( "SELECT photo_url FROM $wpdb->social WHERE user_id=$post->post_author" );
			}
			
			if ( isset( $avatar[0] ) ) {
			    if ( isset( $avatar[0]->photo_url ) ) {
				if ( ! empty( $avatar[0]->photo_url ) && strpos( $avatar[0]->photo_url, 'http' ) !== false ) {
				    $author_pic = $avatar[0]->photo_url;
				}
			    }
			}
			
			if ( isset( $avatar[0] ) ) {
				if ( isset( $avatar[0]->photo_url ) ) {
					if ( ! empty( $avatar[0]->photo_url ) && strpos( $avatar[0]->photo_url, 'http' ) !== false ) {
						$author_pic = $avatar[0]->photo_url;
					}
				}
			}
		}

		return $author_pic;

	}
endif;


if ( ! function_exists( 'listar_social_login_output' ) ) :
	/**
	 * Check if at least one social network is currently active for social login and output it.
	 *
	 * @since 1.3.0
	 * @return (array)
	 */
	function listar_social_login_output() {
	
		if ( defined( 'LSL_SETTINGS' ) ) {
			
			$options = get_option( LSL_SETTINGS );
			$has_some_network_active = false;
			
			if (
				( isset( $options['lsl_facebook_settings']['lsl_facebook_enable'] ) && 'enable' === $options['lsl_facebook_settings']['lsl_facebook_enable'] ) ||
				( isset( $options['lsl_twitter_settings']['lsl_twitter_enable'] ) && 'enable' === $options['lsl_twitter_settings']['lsl_twitter_enable'] ) ||
				( isset( $options['lsl_google_settings']['lsl_google_enable'] ) && 'enable' === $options['lsl_google_settings']['lsl_google_enable'] )
			) {
				$has_some_network_active = true;
			}
			
			if ( $has_some_network_active ) :
				?>
				<div class="listar-social-login">
					<?php echo do_shortcode('[lsl-login template="3" theme="1" login_text="' . esc_html__( 'Social Login', 'listar' ) . '"]'); ?>
				</div>
				<?php
			endif;
		}

	}
endif;


if ( ! function_exists( 'listar_get_listing_address' ) ) :
	/**
	 * Get the listing address (location)
	 *
	 * @param (integer) $listing_id The Listing ID.
	 * @since 1.3.1
	 * @return (string)
	 */
	function listar_get_listing_address( $listing_id ) {
	
		$address_type = get_post_meta( $listing_id, '_job_locationselector', true );
		$listar_listing_address = '';
		
		if ( empty( $address_type ) ) {
			$address_type = 'location-default';
		}
		
		if ( 'location-geocoded' === $address_type ) {
			$listar_listing_address = get_post_meta( $listing_id, 'geolocation_formatted_address', true );
		}
		
		if ( 'location-custom' === $address_type ) {
			$listar_listing_address = get_post_meta( $listing_id, '_job_customlocation', true );
		}
		
		if ( empty( $listar_listing_address ) ) {
			$listar_listing_address = get_post_meta( $listing_id, '_job_location', true );
		}
			
		return esc_html( $listar_listing_address );
	}
endif;


if ( ! function_exists( 'listar_domain_has_favicon' ) ) :
	/**
	 * Check if current domain has favicon. If not, set a dumb favicon for Pagespeed reasons.
	 *
	 * @since 1.3.0
	 * @param (string) $action Can be 'enable' or 'disable'.
	 * @link  @link https://stackoverflow.com/a/5702084/7765298
	 */
	function listar_domain_has_favicon( $action = 'enable' ) {
		$favicon_path = '';
		$root_path = isset( $_SERVER['DOCUMENT_ROOT'] ) && ! empty( $_SERVER['DOCUMENT_ROOT'] ) ? $_SERVER['DOCUMENT_ROOT'] : '';
		$domain = isset( $_SERVER['HTTP_HOST'] ) && ! empty( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
			
		if ( empty( $domain ) ) {
			$domain = isset( $_SERVER['SERVER_NAME'] ) && ! empty( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '';
		}
		
		if ( ! empty( $domain ) && ! empty( $root_path ) && false === strpos( $domain, 'localhost' ) ) {
			$favicon_path = $root_path . '/favicon.ico';
			
			if ( ! file_exists( $favicon_path ) && 'enable' === $action ) {
				listar_download_url_to_file( 'https://www.google.com/s2/favicons?domain=' . $domain, $favicon_path );
			}
		}
	}

endif;


if ( ! function_exists( 'listar_download_url_to_file' ) ) :
	/**
	 * Download a file from any URL to current domain server.
	 *
	 * @since 1.3.0
	 * @link  https://stackoverflow.com/a/28506847/7765298
	 */
	function listar_download_url_to_file( $url, $out_file_name ) {
		if ( is_file( $url ) ) {
			copy( $url, $out_file_name ); 
		} else {
			$options = array(
				CURLOPT_FILE => fopen( $out_file_name, 'w' ),
				CURLOPT_URL  => $url
			);

			$ch = curl_init();
			curl_setopt_array( $ch, $options );
			curl_exec( $ch );
			curl_close( $ch );
		}
	}

endif;


if ( ! function_exists( 'listar_create_filesystem' ) ) :
	/**
	 * Set WordPress filesystem for Listar.
	 *
	 * @since 1.3.9
	 */
	function listar_create_filesystem() {
		global $listar_filesystem;
		global $wp_filesystem;

		/* Prepare to open and get file content */
		if ( empty( $wp_filesystem ) ) {

			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! $listar_filesystem ) {
			include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
			include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

			if ( ! defined( 'FS_CHMOD_DIR' ) ) {
				define( 'FS_CHMOD_DIR', ( fileperms( ABSPATH ) & 0777 | 0755 ) );
			}

			if ( ! defined( 'FS_CHMOD_FILE' ) ) {
				define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
			}

			$listar_filesystem = new WP_Filesystem_Direct( new StdClass() );
		}
	}
endif;


if ( ! function_exists( 'listar_increase_pagespeed_resources' ) ) :
	/**
	 * Configure WordPress .htaccess file with better resources for Pagespeed.
	 *
	 * @since 1.3.0
	 * @param (string) $action Can be 'enable' or 'disable'.
	 */
	function listar_increase_pagespeed_resources( $action = 'enable' ) {

		/* Prepare to open and get file content */
		listar_create_filesystem();
		
		global $listar_filesystem;

		$htaccess_file = ABSPATH . '.htaccess';
		$font_rules = '';
		$mod_expires_c_rules = '';
		$mod_gzip_c_rules = '';
		$mod_deflate_c_rules = '';
		$mod_headers_c_rules = '';

		if ( $listar_filesystem->is_readable( $htaccess_file ) && $listar_filesystem->is_writable( $htaccess_file ) ) {

			$htaccess_content = $listar_filesystem->get_contents( $htaccess_file );
			
			$start_string = '# START LISTAR PAGESPEED SETTINGS';
			$end_string = PHP_EOL . '# END LISTAR PAGESPEED SETTINGS';
			
			$powered_cache_start_string = '# BEGIN POWERED CACHE';
			$powered_cache_end_string = '# END POWERED CACHE';
			
			if ( 'enable' === $action ) {
				if ( false === strpos( $htaccess_content, 'LISTAR PAGESPEED SETTINGS' ) ) {

					/* Rules for fonts */
					
					/* Allow access from all domains for webfonts */
					$font_rules .= PHP_EOL . '<FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|font.css|css|js)$">';
					$font_rules .= PHP_EOL . '<IfModule mod_headers.c>';
					$font_rules .= PHP_EOL . 'Header set Access-Control-Allow-Origin "*"';
					$font_rules .= PHP_EOL . '</IfModule>';
					$font_rules .= PHP_EOL . '</FilesMatch>';

					/* Webfont mime types */
					$font_rules .= PHP_EOL . 'AddType application/x-font-opentype      .otf';
					$font_rules .= PHP_EOL . 'AddType image/svg+xml                    .svg';
					$font_rules .= PHP_EOL . 'AddType application/x-font-ttf           .ttf';
					$font_rules .= PHP_EOL . 'AddType application/font-woff            .woff';
					$font_rules .= PHP_EOL . 'AddType application/font-woff2           .woff2';

					$font_rules .= PHP_EOL . 'AddType font/otf                         .otf';
					$font_rules .= PHP_EOL . 'AddType font/ttf                         .ttf';
					$font_rules .= PHP_EOL . 'AddType font/woff                        .woff';
					$font_rules .= PHP_EOL . 'AddType font/woff2                       .woff2';
					$font_rules .= PHP_EOL . 'AddType application/vnd.ms-fontobject    .eot';

					/* Webfonts and svg: */
					$font_rules .= PHP_EOL . '<IfModule mod_deflate.c>';
					$font_rules .= PHP_EOL . '<FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|svg)$" >';
					$font_rules .= PHP_EOL . 'SetOutputFilter DEFLATE';
					$font_rules .= PHP_EOL . '</FilesMatch>';
					$font_rules .= PHP_EOL . '</IfModule>';

					/* Rules for mod_expires.c */

					$mod_expires_c_rules .= PHP_EOL . '<IfModule mod_expires.c>';
					$mod_expires_c_rules .= PHP_EOL . 'AddType image/x-icon .ico';
					$mod_expires_c_rules .= PHP_EOL . 'AddType application/x-font-ttf .ttf';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresActive On';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/x-icon                          "access plus 1 year"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/json                      "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/ld+json                   "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/vnd.geo+json              "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/xml                       "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/xml                              "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/x-component                      "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/html                             "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/x-component                      "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/css                              "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/manifest+json             "access plus 1 year"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/x-web-app-manifest+json   "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType text/cache-manifest                   "access plus 0 seconds"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType audio/ogg                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/gif                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/jpg                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/jpeg                            "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/png                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType video/mp4                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType video/ogg                             "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType video/webm                            "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/atom+xml                  "access plus 1 hour"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/rss+xml                   "access plus 1 hour"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/font-woff                 "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/font-woff2                "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType x-font/woff                           "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType x-font/woff2                          "access plus 12 month"';				
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/vnd.ms-fontobject         "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType application/x-font-ttf                "access plus 1 year"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType font/opentype                         "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType font/ttf                              "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType font/otf                              "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType font/woff                             "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType font/woff2                            "access plus 12 month"';	
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresByType image/svg+xml                         "access plus 12 month"';
					$mod_expires_c_rules .= PHP_EOL . 'ExpiresDefault                                      "access plus 1 month"';
					$mod_expires_c_rules .= PHP_EOL . '</IfModule>';

					/* Rules for mod_gzip.c */

					$mod_gzip_c_rules .= PHP_EOL . '<ifModule mod_gzip.c>';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_on Yes';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_dechunk Yes';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include file .(html?|txt|css|js|php|pl|woff|woff2|ttf|otf)$';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include handler ^cgi-script$';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^text/.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^application/x-javascript.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^application/font-woff.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^application/font-woff2.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^x-font/woff.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^x-font/woff2.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^font/woff.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_include mime ^font/woff2.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_exclude mime ^image/.*';
					$mod_gzip_c_rules .= PHP_EOL . 'mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*';
					$mod_gzip_c_rules .= PHP_EOL . '</IfModule>';

					/* Rules for mod_deflate.c */

					$mod_deflate_c_rules .= PHP_EOL . '<IfModule mod_deflate.c>';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/javascript';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/rss+xml';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/vnd.ms-fontobject';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-javascript';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/xhtml+xml';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/xml';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE image/svg+xml';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE image/x-icon';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE text/css';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE text/html';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE text/javascript';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE text/plain';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE text/xml';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-font';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-font-opentype';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-font-otf';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-font-truetype';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/x-font-ttf';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE x-font/otf x-font/ttf x-font/eot x-font/woff x-font/woff2';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE font/opentype';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE font/otf';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE font/ttf';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE application/font-woff2';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE font/woff';
					$mod_deflate_c_rules .= PHP_EOL . 'AddOutputFilterByType DEFLATE font/woff2';
					$mod_deflate_c_rules .= PHP_EOL . 'BrowserMatch ^Mozilla/4 gzip-only-text/html';
					$mod_deflate_c_rules .= PHP_EOL . 'BrowserMatch ^Mozilla/4\.0[678] no-gzip';
					$mod_deflate_c_rules .= PHP_EOL . 'BrowserMatch \bMSIE !no-gzip !gzip-only-text/html';
					$mod_deflate_c_rules .= PHP_EOL . 'Header append Vary User-Agent';
					$mod_deflate_c_rules .= PHP_EOL . '</IfModule>';

					/* Rules for mod_headers.c */

					$mod_headers_c_rules .= PHP_EOL . '<IfModule mod_headers.c>';
					$mod_headers_c_rules .= PHP_EOL . '<FilesMatch ".(js|css|xml|gz|woff|woff2|ttf|otf|ico|pdf|flv|jpg|jpeg|png|gif|swf)$">';
					$mod_headers_c_rules .= PHP_EOL . 'Header append Vary: Accept-Encoding';
					$mod_headers_c_rules .= PHP_EOL . 'Header set Cache-control "max-age=31536000, public"';
					$mod_headers_c_rules .= PHP_EOL . '</FilesMatch>';
					$mod_headers_c_rules .= PHP_EOL . '</IfModule>';

					$new_rules = $start_string . $font_rules . $mod_expires_c_rules . $mod_gzip_c_rules . $mod_deflate_c_rules . $mod_headers_c_rules . $end_string . PHP_EOL . PHP_EOL;
					$htaccess_content = $new_rules . $htaccess_content;
					
				}
			} else {
				$htaccess_content_temp = delete_all_between( $powered_cache_start_string, $powered_cache_end_string, $htaccess_content );
				$htaccess_content = delete_all_between( $start_string, $end_string, $htaccess_content_temp );
			}
			
			/* Fix for WP Fastest Cache */
			
			$htaccess_content = str_replace( 'RewriteCond %{QUERY_STRING} !.+', 'RewriteCond %{QUERY_STRING} !.+' . PHP_EOL . 'RewriteCond %{HTTP:Cookie} !wordpress_logged_in', $htaccess_content );
			
			$htaccess_content_final = str_replace( PHP_EOL . PHP_EOL . PHP_EOL, '', $htaccess_content );
			
			$listar_filesystem->put_contents( $htaccess_file, $htaccess_content_final, FS_CHMOD_FILE );
		}
		
	}

endif;


if ( ! function_exists( 'listar_get_cache_urls' ) ) :
	/**
	 * Generate cache URLs and save it to a txt file for Listar Pagespeed.
	 *
	 * @since 1.4.3
	 * @param (boolean) $remove_first_url Remove the first url and save.
	 * @param (boolean) $return_first_url Return the first url.
	 * @param (string)  $action Can be 'enable' or 'disable'. If 'disable, delete the file content.
	 * @return (string)
	 */
	function listar_get_cache_urls( $remove_first_url = false, $return_first_url = false, $action = 'enable' ) {

		/* Prepare to open and get file content */
		listar_create_filesystem();

		global $listar_filesystem;
		$content = '';
		$edit_content = '';
		$edit_content_final = '';
		$first_url = '';
		$edit_file = ABSPATH . 'cache-urls.txt';
		$has_started_empty = false;

		if ( ! listar_url_exists( $edit_file ) ) {
			$listar_filesystem->put_contents( $edit_file, '', FS_CHMOD_FILE );
			$has_started_empty = true;
		}
			
		if ( 'disable' === $action ) {
			if ( ! $has_started_empty ) {
				$listar_filesystem->put_contents( $edit_file, '', FS_CHMOD_FILE );
			}
			
			return '';
		}

		if ( $listar_filesystem->is_readable( $edit_file ) && $listar_filesystem->is_writable( $edit_file ) ) {
			$get_content = rtrim( $listar_filesystem->get_contents( $edit_file ) );
			$replace = array( ' ', PHP_EOL, '/' );
			$test_content = str_replace( $replace, '', $get_content );

			if ( empty( $test_content ) ) {
				$listar_can_publish_listings = listar_user_can_publish_listings();
				$site_url = trailingslashit( network_site_url() );

				/* To avoid a high number of less relevant pages */
				$generic_counter = 120;
				$max_counter = 1000;

				$edit_content .= trim( $site_url ) . PHP_EOL;

				if ( class_exists( 'WP_Job_Manager' ) ) :
					$url_array = array();

					if ( $listar_can_publish_listings ) :
						$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

						if ( ! empty( $listar_add_listing_form_url ) ) :
							$edit_content .= trim( esc_url( $listar_add_listing_form_url ) ) . PHP_EOL;
						endif;
					endif;

					$listings_page_url = job_manager_get_permalink( 'jobs' );
					$fallback_listings_url = $site_url . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';

					if ( empty( $listings_page_url ) ) :
						$edit_content .= trim( $fallback_listings_url ) . PHP_EOL;
					else :
						$edit_content .= trim( esc_url( $listings_page_url ) ) . PHP_EOL;
						$edit_content .= trim( $fallback_listings_url ) . PHP_EOL;
					endif;

					/* Get some listing categories */

					$category_ids = array();

					$args = array(
						'hide_empty' => false,
						'number' => 100,
					);

					$terms = get_terms( 'job_listing_category', $args );

					if ( $terms && ! is_wp_error( $terms ) ) :
						foreach ( $terms as $term ) :
							$max_counter--;
							$category_ids[] = $term->term_id;
							$edit_content .= trim( get_term_link( $term->term_id, 'job_listing_category' ) ) . PHP_EOL;
						endforeach;
					endif;

					/* Get some listing regions */

					$region_ids = array();

					$args2 = array(
						'hide_empty' => false,
						'number' => 100,
					);

					$terms2 = get_terms( 'job_listing_region', $args2 );

					if ( $terms2 && ! is_wp_error( $terms2 ) ) :
						foreach ( $terms2 as $term ) :
							$max_counter--;
							$region_ids[] = $term->term_id;
							$edit_content .= trim( get_term_link( $term->term_id, 'job_listing_region' ) ) . PHP_EOL;
						endforeach;
					endif;

					/* Get some listing amenities */

					$args3 = array(
						'hide_empty' => false,
						'number' => 100,
					);

					$terms3 = get_terms( 'job_listing_amenity', $args3 );

					if ( $terms3 && ! is_wp_error( $terms3 ) ) :
						foreach ( $terms3 as $term ) :
							$max_counter--;
							$slug = $term->slug;
							$edit_content .= trim( $site_url . '?job_listing_amenity=' . $slug ) . PHP_EOL;
						endforeach;
					endif;

					/* Get some listings */

					$args4 = array(
						'post_type'      => 'job_listing',
						'posts_per_page' => 500,
						'post_status'    => 'publish',
					);

					$query = new WP_Query( $args4 );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) :
							$max_counter--;
							$query->the_post();
							$edit_content .= trim( get_the_permalink() ) . PHP_EOL;
						endwhile;
					}

					/* VERY OPTIONAL - Get some empty searches by listing categories and regions */

					foreach( $region_ids as $region_id ) :
						$generic_counter--;
						$max_counter--;

						$temp_url = $site_url . '?s=&post_type=&search_type=listing&listing_sort=newest&explore_by=default&selected_country=0&saved_address=&saved_postcode=&listing_regions=' . $region_id . '&listing_categories=53&listing_amenities=' . PHP_EOL;

						if ( $generic_counter >= 0 && $max_counter >= 0 && ! in_array( $temp_url, $url_array, true ) ) {
							$url_array[] = $temp_url;
							$edit_content .= trim( $temp_url ) . PHP_EOL;
						}
					endforeach;

					foreach( $category_ids as $category_id ) :
						$generic_counter--;

						$temp_url = $site_url . '?s=&post_type=&search_type=listing&listing_sort=newest&explore_by=default&selected_country=0&saved_address=&saved_postcode=&listing_regions=&listing_categories=' . $category_id . '&listing_amenities=' . PHP_EOL;

						if ( $generic_counter >= 0 && $max_counter >= 0 && ! in_array( $temp_url, $url_array, true ) ) {
							$url_array[] = $temp_url;
							$edit_content .= trim( $temp_url ) . PHP_EOL;
						}

						foreach( $region_ids as $region_id ) :
							$generic_counter--;

							$temp_url = $site_url . '?s=&post_type=&search_type=listing&listing_sort=newest&explore_by=default&selected_country=0&saved_address=&saved_postcode=&listing_regions=' . $region_id . '&listing_categories=' . $category_id . '&listing_amenities=' . PHP_EOL;

							if ( $generic_counter >= 0 && $max_counter >= 0 && ! in_array( $temp_url, $url_array, true ) ) {
								$url_array[] = $temp_url;
								$edit_content .= trim( $temp_url ) . PHP_EOL;
							}
						endforeach;
					endforeach;

					/* Get blog page */

					$blog_page = get_permalink( get_option( 'page_for_posts' ) );

					if ( ! empty( $blog_page ) ) :
						$edit_content .= trim( $blog_page ) . PHP_EOL;
					endif;

					/* Get some blog posts */

					$args5 = array(
						'post_type'      => 'post',
						'posts_per_page' => 80,
						'post_status'    => 'publish',
					);

					$query2 = new WP_Query( $args5 );

					if ( $query2->have_posts() ) {
						while ( $query2->have_posts() ) :
							$query2->the_post();
							$generic_counter--;
							$max_counter--;

							if ( $generic_counter >= 0 && $max_counter >= 0 ) {
								$edit_content .= trim( get_the_permalink() ) . PHP_EOL;
							}
						endwhile;
					}

					/* VERY OPTIONAL - Get some blog tags */

					$args6 = array(
						'hide_empty' => false,
						'number' => 20,
					);

					$terms6 = get_terms( 'post_tag', $args6 );

					if ( $terms6 && ! is_wp_error( $terms6 ) ) :
						foreach ( $terms6 as $term ) :
							$generic_counter--;
							$max_counter--;

							if ( $generic_counter >= 0 && $max_counter >= 0 ) {
								$edit_content .= trim( get_term_link( $term, 'post_tag' ) ) . PHP_EOL;
							}
						endforeach;
					endif;
				endif;
			}

			$edit_content_final = $edit_content;
			$content = ! empty( $edit_content_final ) ? $edit_content_final : $get_content;

			if ( $return_first_url ) {
				$content_temp = array_filter( false !== strpos( $content, PHP_EOL ) ? explode( PHP_EOL, $content ) : array( $content ) );

				if ( isset( $content_temp[0] ) && is_string( $content_temp[0] ) && false !== strpos( $content_temp[0], 'http' ) ) {
					$first_url = $content_temp[0];
					unset( $content_temp[0] ); 
					$content = $remove_first_url ? implode( PHP_EOL, $content_temp ) : $content;
				}
			}
			
			$listar_filesystem->put_contents( $edit_file, $content, FS_CHMOD_FILE );

			if ( $return_first_url ) {
				return $first_url;
			}
		}

		return $content;
	}

endif;


if ( ! function_exists( 'listar_async_javascript_pagespeed' ) ) :
	/**
	 * Enable or disable Async JavaScript plugin settings.
	 *
	 * @since 1.3.0
	 * @param (string) $action Can be 'enable' or 'disable'.
	 */
	function listar_async_javascript_pagespeed( $action = 'enable' ) {
		if ( 'enable' === $action ) {
			update_option( 'aj_enabled', 1 );
			update_option( 'aj_method', 'defer' );
			update_option( 'aj_exclusions', 'wp-includes/js/utils.min.js, wp-admin/js/editor.min.js, wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.js, js/jquery/jquery.min.js' );
		} else {
			update_option( 'aj_enabled', 0 );
			update_option( 'aj_method', 'async' );
		}
	}
endif;


if ( ! function_exists( 'listar_autoptimize_pagespeed' ) ) :
	/**
	 * Enable or disable initial configs to Autoptimize plugin.
	 *
	 * @since 1.3.0
	 * @param (string) $action Can be 'enable' or 'disable'.
	 */
	function listar_autoptimize_pagespeed( $action = 'enable' ) {
		if ( function_exists( 'autoptimize_autoload' ) ) {
			$extra_settings = array();

			if ( 'enable' === $action ) {
				$extra_settings = array(
					'autoptimize_extra_checkbox_field_1' => '1',
					'autoptimize_extra_checkbox_field_0' => '1',
					'autoptimize_extra_radio_field_4'    => '1',
					'autoptimize_extra_text_field_2'     => '',
					'autoptimize_extra_text_field_3'     => '',
				);
				
				update_option( 'autoptimize_js', 1 );
				update_option( 'autoptimize_css', '' );
				update_option( 'autoptimize_js_exclude', 'wp-includes/js/utils.min.js, wp-admin/js/editor.min.js, wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.js, js/jquery/jquery.min.js' );
				update_option( 'autoptimize_css_exclude', 'wp-content/cache/, wp-content/uploads/, admin-bar.min.css, loading-transition.min.css' );
				
			} else {
				$extra_settings = array(
					'autoptimize_extra_checkbox_field_1' => '',
					'autoptimize_extra_checkbox_field_0' => '',
					'autoptimize_extra_radio_field_4'    => '1',
					'autoptimize_extra_text_field_2'     => '',
					'autoptimize_extra_text_field_3'     => '',
				);

				update_option( 'autoptimize_js', '' );
				update_option( 'autoptimize_css', '' );
				update_option( 'autoptimize_css_exclude', 'wp-content/cache/, wp-content/uploads/, admin-bar.min.css' );
			}
			
			update_option( 'autoptimize_optimize_logged', '' );
			update_option( 'autoptimize_extra_settings', $extra_settings );
		}
	}
endif;


/* Get object cache available for current server */

function listar_available_object_caches() {

	if ( function_exists( 'apcu_add' ) ) {
		return 'apcu';
	}

	if ( class_exists( 'Memcache' ) ) {
		return 'memcache';
	}

	if ( class_exists( 'Memcached' ) ) {
		return 'memcached';
	}

	if ( class_exists( 'Redis' ) ) {
		return 'redis';
	}

	return 'off';
}


if ( ! function_exists( 'listar_wp_fastest_cache_pagespeed' ) ) :
	/**
	 * Set initial configs to WP Fastest Cache plugin.
	 *
	 * @since 1.4.7
	 * @param (string) $action Can be 'enable' or 'disable'.
	 */
	function listar_wp_fastest_cache_pagespeed( $action = 'enable' ) {
		if ( function_exists( 'wpfastestcache_activate' ) ) {
			$wp_fastest_cache_options = get_option( 'WpFastestCache' );
			$old_options = $wp_fastest_cache_options ? json_decode( $wp_fastest_cache_options, true ) : array();
			$new_options = $old_options ? $old_options : array();
			$value = 'enable' === $action ? 'on' : '';

			$new_options['wpFastestCacheStatus'] = $value;
			$new_options['wpFastestCacheLoggedInUser'] = $value;
			$new_options['wpFastestCacheMinifyHtml'] = $value;
			$new_options['wpFastestCacheGzip'] = $value;
			$new_options['wpFastestCacheLBC'] = $value;
			$new_options['wpFastestCacheDisableEmojis'] = $value;
			
			if ( 'on' !== $value ) {
				unset( $new_options['wpFastestCacheStatus'] );
				unset( $new_options['wpFastestCacheLoggedInUser'] );
				unset( $new_options['wpFastestCacheMinifyHtml'] );
				unset( $new_options['wpFastestCacheGzip'] );
				unset( $new_options['wpFastestCacheLBC'] );
				unset( $new_options['wpFastestCacheDisableEmojis'] );
			}

			if( $wp_fastest_cache_options ) {
				update_option( 'WpFastestCache', json_encode( $new_options ) );
			} else {
				add_option( 'WpFastestCache', json_encode( $new_options ), null, 'yes' );
			}
			
			wpfastestcache_activate();
		}
	}
endif;


if ( ! function_exists( 'listar_automatic_cache_execute' ) ) :
	/**
	 * Preload URLs for automatic cache.
	 *
	 * @return (void)
	 */
	function listar_automatic_cache_execute() {
		$desktop_args = array(
			'httpversion' => '1.1',
			'user-agent'  => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36',
			'timeout'     => 10,
		);

		/* One URL every 15 seconds - 4 URLs per minute */
		wp_remote_get( listar_get_cache_urls( true, true ), $desktop_args );
		usleep( 15000000 );
		wp_remote_get( listar_get_cache_urls( true, true ), $desktop_args );
		usleep( 15000000 );
		wp_remote_get( listar_get_cache_urls( true, true ), $desktop_args );
		usleep( 15000000 );
		wp_remote_get( listar_get_cache_urls( true, true ), $desktop_args );
	}
endif;


if ( ! function_exists( 'listar_generate_automatic_caching_task' ) ) :
	/**
	 * Handle the task that creates the automatic cache.
	 *
	 * @since 1.4.7
	 * @param (string) $action Can be 'enable' or 'disable'.
	 */
	function listar_generate_automatic_caching_task( $action = 'enable' ) {
		if ( function_exists( 'wpfastestcache_activate' ) ) {
			
			if ( 'enable' === $action ) {				
				if ( ! wp_next_scheduled( 'listar_automatic_cache_hook' ) ) {
					wp_schedule_event( time(), 'every_minute', 'listar_automatic_cache_hook');
				}
			} else {
				wp_clear_scheduled_hook( 'listar_automatic_cache_hook' );
			}
		}
	}
endif;


function delete_all_between( $beginning, $end, $string ) {
	$beginningPos = strpos( $string, $beginning );
	$endPos = strpos( $string, $end );

	if ( false === $beginningPos || false === $endPos ) {
		return $string;
	}

	$textToDelete = substr( $string, $beginningPos, ( $endPos + strlen( $end ) ) - $beginningPos );

	return delete_all_between( $beginning, $end, str_replace( $textToDelete, '', $string ) ); // recursion to ensure all occurrences are replaced
}


if ( ! function_exists( 'listar_blank_base64_placeholder_image' ) ) :
	/**
	 * Return a blank base64 image to be used as placeholder (pagespeed).
	 *
	 * @since 1.3.6
	 * @return (string)
	 */
	function listar_blank_base64_placeholder_image() {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQImWP4zwAAAgEBACqxsiUAAAAASUVORK5CYII=';
	}
endif;


if ( ! function_exists( 'listar_json_decode_nice' ) ) :
	/**
	 * Fix line breaks inside JSON string and decode it.
	 *
	 * @since 1.3.6
	 * @link https://www.php.net/manual/pt_BR/function.json-decode.php#111928
	 * @param (string)  $json A JSON string.
	 * @param (booleam) $assoc Convert to associative array.
	 * @return (array)
	 */
	function listar_json_decode_nice( $json, $assoc = true ){
		if ( empty( $json ) ) {
	        $json = '';
	    }	    
		
		$search = array(
			'{&quot;',
			'&quot;:',
			':&quot;',
			',&quot;',
			':&quot;&quot;',
			'&quot;}',
			'&quot;,"',
			//'&quot;,', In case issues happen in the future.			
			'{&#34;',
			'&#34;:',
			':&#34;',
			',&#34;',
			':&#34;&#34;',
			'&#34;}',
			'&#34;,"',
		);

		$replace = array(
			'{"',
			'":',
			':"',
			',"',
			'""',
			'"}',
			'","',
			//'",', In case issues happen in the future.
			'{"',
			'":',
			':"',
			',"',
			'""',
			'"}',
			'","',
		
		);

		$json = str_replace( $search, $replace, $json );

		/*
		if ( false !== strpos( $json, '&#034' ) ) {
			
			// JSON string has HTML entities!
			$json = html_entity_decode( $json );
		}
		*/
		
		$json1 = str_replace( array("\n","\r"), array("\\n","\\r"), $json );
		$json2 = preg_replace( '/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":', $json1 );
		$json3 = preg_replace( '/(,)\s*}$/','}', $json2 );

		return json_decode( $json3, $assoc );
	}
endif;


/* Functions for Search / Explore By customizations ========================= */

if ( ! function_exists( 'listar_is_search_by_option_active' ) ) :
	/**
	 * Check if a specific "Explore By" options is active
	 *
	 * @since 1.3.6
	 * @param (string) $option The slug of the "Explore By" option.
	 * @return (boolean)
	 */
	function listar_is_search_by_option_active( $option = 'newest' ) {
	
		if ( 'best_rated' === $option ) {
			if ( ( ! listar_third_party_reviews_active() ) && ( ! listar_built_in_reviews_active() ) ) {
				return false;
			}
		}

		/* Are the Explore By options active? */
		$search_by_active = 0 === (int) get_option( 'listar_disable_all_search_by_options' ) && post_type_exists( 'job_listing' ) ? true : false;
		$option_is_active = 0 === (int) get_option( 'listar_disable_search_by_' . $option . '_option' ) && $search_by_active ? true : false;
		
		if ( 'random' === $option || 'oldest' === $option || 'asc' === $option || 'desc' === $option ) {
			return true;
		}
		
		return $option_is_active;
	}
endif;


if ( ! function_exists( 'listar_is_search_by_options_active' ) ) :
	/**
	 * Check if "Explore By" options are active
	 *
	 * @since 1.3.6
	 * @return (boolean)
	 */
	function listar_is_search_by_options_active() {

		/* Are the Explore By options active? */
		$search_by_active = 0 === (int) get_option( 'listar_disable_all_search_by_options' ) && post_type_exists( 'job_listing' ) ? true : false;
		$has_one_search_by_option_active = false;
		
		$search_by_options = array(
			'nearest_me',
			'trending',
			'best_rated',
			'most_viewed',
			'near_address',
			'near_postcode',
			'surprise',
			'shop_products',
			'blog',
		);
		
		$bookmarks_active = listar_bookmarks_active_plugin();
		
		if ( $bookmarks_active ) {
			$search_by_options = array_slice( $search_by_options, 0, 3, true ) +
			array( 'most_bookmarked' ) +
			array_slice( $search_by_options, 3, count( $search_by_options ) -3, true );
		}
		
		foreach ( $search_by_options as $option ) {
			if ( listar_is_search_by_option_active( $option ) ) {
				$has_one_search_by_option_active = true;
				break;
			}
		}

		return $search_by_active && $has_one_search_by_option_active;
	}
endif;


if ( ! function_exists( 'listar_get_custom_random_label' ) ) :
	/**
	 * Get the custom label for "Random" sort filter set on Theme Options.
	 *
	 * @since 1.3.6
	 * @return (string)
	 */
	function listar_get_custom_random_label() {
		$label = get_option( 'listar_custom_random_label' );
		
		if ( empty( $label ) ) {
			$label = esc_html__( 'Surprise me', 'listar' );
		}
		
		return $label;
	}
endif;


if ( ! function_exists( 'listar_get_search_options' ) ) :
	/**
	 * Get all "Explore By" options active currently.
	 *
	 * @since 1.3.6
	 * @return (boolean)
	 */
	function listar_get_search_options() {

		$search_options = array();

		$search_by_description = get_option( 'listar_search_by_default_description' );
		$search_by_placeholder_1 = get_option( 'listar_search_input_placeholder' );
		$listar_search_placeholder_2 = empty( $search_by_placeholder_1 ) ? esc_html__( 'What do you need?', 'listar' ) : $search_by_placeholder_1;

		if ( empty ( $search_by_description ) ) {
			$search_by_description = esc_html__( 'Search spots by keyword(s).', 'listar' );
		}
		
		$search_options['default'] = array( esc_html__( 'Default search', 'listar' ), 'fa-location-circle', $search_by_description, $listar_search_placeholder_2, 'default', listar_get_initial_sort_order() );

		if ( listar_is_search_by_option_active( 'nearest_me' ) ) {
			$slug = 'nearest_me';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Find places around your current location.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}
			
			$search_options[ $slug ] = array( esc_html__( 'Nearest me', 'listar' ), 'fa fa-scrubber', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'trending' ) ) {
			$slug = 'trending';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'It is happening now.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Trending', 'listar' ), 'fa-bolt', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'best_rated' ) ) {
			$slug = 'best_rated';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Qualified points to go.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Best rated', 'listar' ), 'fa-smile', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'most_viewed' ) ) {
			$slug = 'most_viewed';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'The hottest listings.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Most viewed', 'listar' ), 'fa-bullseye-pointer', $search_by_description, $search_by_placeholder, $slug, $slug );
		}
		
		$bookmarks_active = listar_bookmarks_active_plugin();

		if ( $bookmarks_active && listar_is_search_by_option_active( 'most_bookmarked' ) ) {
			$slug = 'most_bookmarked';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Places you will love.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Most bookmarked', 'listar' ), 'fa-heart-circle', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'near_address' ) ) {
			$slug = 'near_address';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Type any partial or full address to find listings nearby.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type an address...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Near an address', 'listar' ), 'far fa-arrow-circle-right', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'near_postcode' ) ) {
			$slug = 'near_postcode';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Find the nearest listings by only typing a postcode.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type a postcode...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Near a postcode', 'listar' ), 'fa-compass', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'surprise' ) ) {
			$slug = 'surprise';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Discover new places.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( listar_get_custom_random_label(), 'fa-question-circle', $search_by_description, $search_by_placeholder, $slug, 'random' );
		}

		if ( listar_is_search_by_option_active( 'shop_products' ) ) {
			$slug = 'shop_products';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Purchase goodies.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Shop', 'listar' ), 'fa-usd-circle', $search_by_description, $search_by_placeholder, $slug, $slug );
		}

		if ( listar_is_search_by_option_active( 'blog' ) ) {
			$slug = 'blog';
			$search_by_description = get_option( 'listar_search_by_' . $slug . '_description' );
			$search_by_placeholder = get_option( 'listar_search_by_' . $slug . '_placeholder' );
			
			if ( empty ( $search_by_description ) ) {
				$search_by_description = esc_html__( 'Find tips and tricks on our blog archive.', 'listar' );
			}

			if ( empty ( $search_by_placeholder ) ) {
				$search_by_placeholder = esc_html__( 'Type something...', 'listar' );
			}

			$search_options[ $slug ] = array( esc_html__( 'Blog articles', 'listar' ), 'fa-info-circle', $search_by_description, $search_by_placeholder, $slug, $slug );
		}
		
		return $search_options;
	}
endif;


if ( ! function_exists( 'listar_get_search_by_predefined_countries' ) ) :
	/**
	 * Get countries to be used for searches by "Near an address" and "Near a postcode".
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_search_by_predefined_countries() {
		$countries = array();
		$get_countries = get_option( 'listar_search_by_predefined_countries' );
		$index = 0;
		
		if ( ! empty( $get_countries ) ) {
			if ( 'false' !== strpos( $get_countries, ',' ) ) {
				$get_countries = explode( ',', $get_countries );
				
				foreach( $get_countries as $country ) {
		
					/* Remove all special characters, respect cyrillic */
					$get_countries_test = trim( preg_replace( '/[^\p{L}\p{N}\s]/u', '', $country ) );

					/* Remove all numeric characters, including Western Arabic */
					$get_countries_test2 = preg_replace('/[0-9]+/', '', $get_countries_test );
					
					if ( ! empty( $get_countries_test2 ) ) {
						$countries[] = array( $get_countries_test2 );
					}
				}
			} else {
		
				/* Remove all special characters, respect cyrillic */
				$get_countries_test = trim( preg_replace( '/[^\p{L}\p{N}\s]/u', '', $get_countries ) );

				/* Remove all numeric characters, including Western Arabic */
				$get_countries_test2 = preg_replace('/[0-9]+/', '', $get_countries_test );

				if ( ! empty( $get_countries_test2 ) ) {
					$countries[] = array( $get_countries_test2 );
				}
			}
		}
		
		if ( empty( $countries ) ) {
			return array( array( 'USA', 0 ) );
		} else {
			$countries = array_unique( $countries, SORT_REGULAR );

			foreach( $countries as $country ) {
				$countries[ $index ][1] = $index;
				$index++;
			}
		}
		
		return $countries;
	}
endif;


if ( ! function_exists( 'listar_current_explore_by_country' ) ) :
	/**
	 * Get current country for 'Explore by" search, giving priority for session.
	 *
	 * @since 1.3.8
	 * @param (string) $country_ID Predefines a country by ID.
	 * @return (string)
	 */
	function listar_current_explore_by_country( $country_ID = '' ) {
		global $wp_query;

		$get_explore_by_country = '' !== $country_ID ? $country_ID : filter_input( INPUT_GET, listar_url_query_vars_translate( 'selected_country' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$listar_fallback_country = '0';
		
		if ( empty( $get_explore_by_country ) && '0' !== $get_explore_by_country ) {
			$get_explore_by_country = isset( $wp_query->query[ listar_url_query_vars_translate( 'selected_country' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'selected_country' ) ] : '';
		}
		
		if ( empty( $get_explore_by_country ) && '0' !== $get_explore_by_country ) {
			$get_explore_by_country = isset( $_SESSION['listar_user_search_options']['explore_by_country'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_country'] ) ? $_SESSION['listar_user_search_options']['explore_by_country'] : '';
		}
		
		return ! empty( $get_explore_by_country ) || '0' === $get_explore_by_country ? $get_explore_by_country : $listar_fallback_country;
	}
endif;


if ( ! function_exists( 'listar_current_explore_by_country_name' ) ) :
	/**
	 * Get the name for current explore by country
	 *
	 * @since 1.3.8
	 * @param (string) $country_ID Predefines a country by ID.
	 * @return (string)
	 */
	function listar_current_explore_by_country_name( $country_ID = '' ) {
		$current_explore_by_country = '' !== $country_ID ? $country_ID : listar_current_explore_by_country();
		$explore_by_countries = listar_get_search_by_predefined_countries();

		foreach ( $explore_by_countries as $country ) {
			if ( isset( $country[1] ) ) {
				if ( (int) $current_explore_by_country === (int) $country[1] ) {
					$current_explore_by_country = $country[0];
					break;
				}
			}
		}

		if ( strlen( (string) $current_explore_by_country ) < 2 ) {
			$current_explore_by_country = 'USA';
		}
		
		return $current_explore_by_country;
	}
endif;


if ( ! function_exists( 'listar_get_initial_sort_order' ) ) :
	/**
	 * Get the initial sort order (slug).
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_initial_sort_order() {
		$listar_sort_order = get_option( 'listar_initial_listing_sort_order' );

		if ( empty( $listar_sort_order ) || ! listar_is_search_by_option_active( $listar_sort_order ) ) {
			$listar_sort_order = 'newest';
		}
		
		return $listar_sort_order;
	}
endif;


if ( ! function_exists( 'listar_get_initial_explore_by_filter' ) ) :
	/**
	 * Get the initial Explore By filter (slug).
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_initial_explore_by_filter() {
		$listar_explore_by_type = get_option( 'listar_initial_explore_by_type' );

		if ( empty( $listar_explore_by_type ) || ! listar_is_search_by_option_active( $listar_explore_by_type ) ) {
			$listar_explore_by_type = 'default';
		}
		
		return $listar_explore_by_type;
	}
endif;


if ( ! function_exists( 'listar_current_directory_sort_session' ) ) :
	/**
	 * Get type of ordering (sort) currently being used by directory search, giving priority for session.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_current_directory_sort_session() {
		global $wp_query;
		global $query;

		if ( listar_is_front_page_template() ) {
			if ( isset( $_SESSION['listar_user_search_options']['sort_order'] ) && ! wp_doing_ajax() ) {
				$_SESSION['listar_user_search_options']['sort_order'] = '';
			}
		}

		$get_sort = filter_input( INPUT_GET, listar_url_query_vars_translate( 'listing_sort' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$listar_sort_order = listar_get_initial_sort_order();
		
		if ( empty( $get_sort ) ) {
			$get_sort = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_sort' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_sort' ) ] : '';
		}
		
		if ( empty( $get_sort ) ) {
			$get_sort = isset( $_SESSION['listar_user_search_options']['sort_order'] ) && ! empty( $_SESSION['listar_user_search_options']['sort_order'] ) ? $_SESSION['listar_user_search_options']['sort_order'] : '';
		}
		
		return ! empty( $get_sort ) ? $get_sort : $listar_sort_order;
	}
endif;


if ( ! function_exists( 'listar_current_explore_by_session' ) ) :
	/**
	 * Get type of 'Explore by" search in use currently, giving priority for session.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_current_explore_by_session() {
		global $wp_query;

		if ( listar_is_front_page_template() && ! wp_doing_ajax() ) {
			if ( isset( $_SESSION['listar_user_search_options']['explore_by'] ) ) {
				$_SESSION['listar_user_search_options']['explore_by'] = '';
			}
		}

		$get_explore_by_type = filter_input( INPUT_GET, listar_url_query_vars_translate( 'explore_by' ), FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		$listar_explore_by_type = listar_get_initial_explore_by_filter();
		
		if ( empty( $get_explore_by_type ) ) {
			$get_explore_by_type = isset( $wp_query->query[ listar_url_query_vars_translate( 'explore_by' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'explore_by' ) ] : '';
		}
		
		if ( empty( $get_explore_by_type ) ) {
			$get_explore_by_type = isset( $_SESSION['listar_user_search_options'][ 'explore_by' ] ) && ! empty( $_SESSION['listar_user_search_options'][ 'explore_by' ] ) ? $_SESSION['listar_user_search_options'][ 'explore_by' ] : '';
		}
		
		return ! empty( $get_explore_by_type ) ? $get_explore_by_type : $listar_explore_by_type;
	}
endif;


if ( ! function_exists( 'listar_get_geolocated_data_by_address' ) ) :
	/**
	 * Return latitude and longitude values for an address.
	 *
	 * @since 1.3.8
	 * @param (string) $address An address for geolocation.
	 * @return (array)
	 */
	function listar_get_geolocated_data_by_address( $address = '' ) {
	
		$return_data = array();

		if ( ! empty( $address ) ) {
			
			$geo = listar_mapplus_geocoding( $address, get_locale() );

			if (
				! empty( $geo ) &&
				isset( $geo['geolocation_lat'] ) && ! empty( $geo['geolocation_lat'] ) &&
				isset( $geo['geolocation_long'] ) && ! empty( $geo['geolocation_long'] )
			) {

				$return_data['geolocation_lat'] = $geo['geolocation_lat'];
				$return_data['geolocation_long'] = $geo['geolocation_long'];
				$return_data['geolocation_street'] = $geo['geolocation_street'];
				$return_data['geolocation_street_number'] = $geo['geolocation_street_number'];
				$return_data['geolocation_city'] = $geo['geolocation_city'];
				$return_data['geolocation_state_long'] = $geo['geolocation_state_long'];
				$return_data['geolocation_country_long'] = $geo['geolocation_country_long'];
			}
		}
		
		return $return_data;
	}
endif;


if ( ! function_exists( 'listar_get_geolocated_distance' ) ) :
	/**
	 * Calculates the great-circle distance between two points, with the Haversine formula.
	 *
	 * @since 1.3.8
	 * @link  https://stackoverflow.com/a/10054282/7765298
	 * 
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	function listar_get_geolocated_distance( $latitudeFrom = 0, $longitudeFrom = 0, $latitudeTo = 0, $longitudeTo = 0, $earthRadius = 6371000 ) {
		$distance_unit = get_option( 'listar_distance_unit' );
	
		// Use Metters
		$metters_if_lower_than = get_option( 'listar_meters_if_lower_than' );
		$formatedDistance = '';
	
		// Convert from degrees to radians.
		$latFrom = deg2rad( (float) $latitudeFrom);
		$lonFrom = deg2rad( (float) $longitudeFrom);
		$latTo = deg2rad( (float) $latitudeTo);
		$lonTo = deg2rad( (float) $longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		
		$distanceKM = ( ( $angle * $earthRadius ) / 1000 );
		$replace = array(
			',',
			'-',
			' ',
		);

		if ( empty( $distance_unit ) ) {
			$distance_unit = 'km';
		}

		if ( 'km' === $distance_unit ) {		
			if ( ! empty( $metters_if_lower_than ) && number_format( $distanceKM, 0 ) < number_format( $metters_if_lower_than ) ) {
				$formatedDistance = str_replace( $replace, '', ( (string) number_format( $distanceKM * 1000, 0 )  ) . 'm' );
			} else {
				$formatedDistance = str_replace( $replace, '', ( (string) number_format( $distanceKM, 0 ) ) . 'km' );
			}
		} else {
			$mi_distance = ( (float) $distanceKM ) / 1.60934;

			if ( $mi_distance > 100 ) {
				$mi_distance = (string) number_format( $mi_distance, 0 );
			} else {
				$mi_distance = (string) number_format( $mi_distance, 1 );
			}

			$formatedDistance = str_replace( $replace, '', $mi_distance . 'mi' );			
		}

		return $formatedDistance;

		// Need option to define decimal separator.
		// return ( (string) number_format( $distanceKM, 1 ) ) . 'km';
	}
endif;


if ( ! function_exists( 'listar_capitalize_phrase' ) ) :
	/**
	 * Capitalize words of phrases.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_capitalize_phrase( $str ) {
		if ( false !== strpos( $str, ' ' ) ) {
			$temp  = array_filter( explode( ' ', $str ) );
			$temp2 = '';
			
			foreach ( $temp as $str ) {
				$temp2 .= ucfirst( $str ) . ' ';
			}
			
			$str = trim( $temp2 );
		}
		
		return $str;
	}
endif;


if ( ! function_exists( 'listar_current_search_address_session' ) ) :
	/**
	 * Get current or last location address used for "explore by".
	 *
	 * @since 1.3.8
	 * @param (string) $address Predefines a address.
	 * @return (string)
	 */
	function listar_current_search_address_session( $address = '' ) {
		global $wp_query;

		$listar_current_explore_by = listar_current_explore_by_session();
		$empty_address = '';
		
		if ( 'near_address' === $listar_current_explore_by ) {
			if ( ! empty( $address ) ) {
				$search_address = $address;
			} else {
				if ( isset( $wp_query->query['s'] ) && '' === $wp_query->query['s'] && isset( $wp_query->query[ listar_url_query_vars_translate( 'saved_address' ) ] ) && '' === $wp_query->query[ listar_url_query_vars_translate( 'saved_address' ) ] ) {
					return '';
				}

				$search_address = filter_input( INPUT_GET, 's', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

				if ( empty( $search_address ) ) {
					$search_address = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
				}
			}
		}
		
		if ( empty( $search_address ) ) {
			$search_address = isset( $_SESSION['listar_user_search_options']['explore_by_address'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_address'] ) ? $_SESSION['listar_user_search_options']['explore_by_address'] : '';
		}
		
		return ! empty( $search_address ) ? listar_capitalize_phrase( $search_address ) : $empty_address;
	}
endif;


if ( ! function_exists( 'listar_current_search_address_coordinates_session' ) ) :
	/**
	 * Get coordinates for current or last location address used for "explore by".
	 *
	 * @since 1.3.8
	 * @param (string) $address Predefines a address.
	 * @return (array)
	 */
	function listar_current_search_address_coordinates_session( $address = '' ) {
	
		global $wp_query;

		$listar_current_explore_by = listar_current_explore_by_session();
		$lat = '';
		$lng = '';
		
		if ( 'near_address' === $listar_current_explore_by ) {
			if ( ! empty( $address ) ) {
				$search_address = $address;
			} else {
				if ( isset( $wp_query->query['s'] ) && '' === $wp_query->query['s'] && isset( $wp_query->query['saved_address'] ) && '' === $wp_query->query[ listar_url_query_vars_translate( 'saved_address' ) ] ) {
					return array( '', '' );
				}

				$search_address = listar_current_search_address_session();
			}
			
			$current_explore_by_country = listar_current_explore_by_country_name();

			if ( ! empty( $search_address ) ) {
				$last_explore_by_address = isset( $_SESSION['listar_user_search_options']['explore_by_address'] ) ? $_SESSION['listar_user_search_options']['explore_by_address'] : '';
				
				if ( $search_address . ' ' . $current_explore_by_country !== $last_explore_by_address . ' ' . $current_explore_by_country ) {
					$geo = listar_get_geolocated_data_by_address( $search_address . ' ' . $current_explore_by_country );

					if (
						! empty( $geo ) &&
						isset( $geo['geolocation_lat'] ) && ! empty( $geo['geolocation_lat'] ) &&
						isset( $geo['geolocation_long'] ) && ! empty( $geo['geolocation_long'] )
					) {

						$lat = $geo['geolocation_lat'];
						$lng = $geo['geolocation_long'];
					}
				} else {
					$lat = isset( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lat'] ) ? $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lat'] : '';
					$lng = isset( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lng'] ) ? $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lng'] : '';
				}
			}
		}
		
		if ( empty( $lat ) || empty( $lng ) ) {
			$lat = isset( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lat'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lat'] ) ? $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lat'] : '';
			$lng = isset( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lng'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lng'] ) ? $_SESSION['listar_user_search_options']['explore_by_address_geocoded_lng'] : '';
		}
		
		return ! empty( $lat ) && ! empty( $lng ) ? array( $lat, $lng ) : array( '', '' );
	}
endif;


if ( ! function_exists( 'listar_current_search_nearest_me_coordinates_session' ) ) :
	/**
	 * Get coordinates for current or last location nearest_me used for "explore by".
	 *
	 * @since 1.3.8
	 * @return (array)
	 */
	function listar_current_search_nearest_me_coordinates_session() {

		$lat = isset( $_SESSION['listar_user_search_options']['explore_by_nearest_me_geocoded_lat'] ) ? $_SESSION['listar_user_search_options']['explore_by_nearest_me_geocoded_lat'] : '';
		$lng = isset( $_SESSION['listar_user_search_options']['explore_by_nearest_me_geocoded_lng'] ) ? $_SESSION['listar_user_search_options']['explore_by_nearest_me_geocoded_lng'] : '';
		
		return array( $lat, $lng );
	}
endif;


if ( ! function_exists( 'listar_current_search_postcode_session' ) ) :
	/**
	 * Get current or last location postcode used for "explore by".
	 *
	 * @since 1.3.8
	 * @param (string) $address Predefines a address.
	 * @return (string)
	 */
	function listar_current_search_postcode_session( $address = '' ) {
		global $wp_query;

		$listar_current_explore_by = listar_current_explore_by_session();
		$empty_postcode = '';
		
		if ( 'near_postcode' === $listar_current_explore_by ) {
			if ( ! empty( $address ) ) {
				$search_postcode = $address;
			} else {
				if ( isset( $wp_query->query['s'] ) && '' === $wp_query->query['s'] && isset( $wp_query->query[ listar_url_query_vars_translate( 'saved_postcode' ) ] ) && '' === $wp_query->query[ listar_url_query_vars_translate( 'saved_postcode' ) ] ) {
					return '';
				}

				$search_postcode = filter_input( INPUT_GET, 's', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

				if ( empty( $search_postcode ) ) {
					$search_postcode = isset( $wp_query->query['s'] ) ? $wp_query->query['s'] : '';
				}
			}
		}
		
		if ( empty( $search_postcode ) ) {
			$search_postcode = isset( $_SESSION['listar_user_search_options']['explore_by_postcode'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_postcode'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode'] : '';
		}
		
		return ! empty( $search_postcode ) ? listar_capitalize_phrase( $search_postcode ) : $empty_postcode;
	}
endif;


if ( ! function_exists( 'listar_current_search_postcode_coordinates_session' ) ) :
	/**
	 * Get coordinates for current or last location postcode used for "explore by".
	 *
	 * @since 1.3.8
	 * @param (string) $address Predefines a address.
	 * @return (array)
	 */
	function listar_current_search_postcode_coordinates_session( $address = '' ) {

		global $wp_query;

		$listar_current_explore_by = listar_current_explore_by_session();
		$lat = '';
		$lng = '';
		
		if ( 'near_postcode' === $listar_current_explore_by ) {
			if ( ! empty( $address ) ) {
				$search_postcode = $address;
			} else {
				
				if ( isset( $wp_query->query['s'] ) && '' === $wp_query->query['s'] && isset( $wp_query->query[ listar_url_query_vars_translate( 'saved_postcode' ) ] ) && '' === $wp_query->query[ listar_url_query_vars_translate( 'saved_postcode' ) ] ) {
					return array( '', '' );
				}

				$search_postcode = listar_current_search_postcode_session();
			}

			$current_explore_by_country = listar_current_explore_by_country_name();

			if ( ! empty( $search_postcode ) ) {
				$last_explore_by_postcode = isset( $_SESSION['listar_user_search_options']['explore_by_postcode'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode'] : '';

				if ( $search_postcode . ' ' . $current_explore_by_country !== $last_explore_by_postcode . ' ' . $current_explore_by_country ) {
					
					$geo = listar_get_geolocated_data_by_address( $current_explore_by_country . ' ' . $search_postcode );

					if (
						! empty( $geo ) &&
						isset( $geo['geolocation_lat'] ) && ! empty( $geo['geolocation_lat'] ) &&
						isset( $geo['geolocation_long'] ) && ! empty( $geo['geolocation_long'] )
					) {

						$lat = $geo['geolocation_lat'];
						$lng = $geo['geolocation_long'];
					}
				} else {
					$lat = isset( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lat'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lat'] : '';
					$lng = isset( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lng'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lng'] : '';
				}
			}
		}
		
		if ( empty( $lat ) || empty( $lng ) ) {
			$lat = isset( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lat'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lat'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lat'] : '';
			$lng = isset( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lng'] ) && ! empty( $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lng'] ) ? $_SESSION['listar_user_search_options']['explore_by_postcode_geocoded_lng'] : '';
		}
		
		return ! empty( $lat ) && ! empty( $lng ) ? array( $lat, $lng ) : array( '', '' );
	}
endif;

function listar_user_got_geolocated( $geolocated = false ) {
	static $user_geolocated = false;

	if ( $geolocated ) {
		$user_geolocated = $geolocated;
	}

	return $user_geolocated;
}


if ( ! function_exists( 'listar_get_listing_distance_metering' ) ) :
	/**
	 * Return latitude and longitude values for an address.
	 *
	 * @since 1.3.8
	 * @param (string) $lat The listing latitude.
	 * @param (string) $lng The listing longitude.
	 * @param (integer) $region_id The ID of a listing region.
	 * @return (array)
	 */
	function listar_get_listing_distance_metering( $lat = '', $lng = '', $region_id = 0 ) {
		
		$listar_use_distance_metering = get_option( 'listar_use_distance_metering' );
		$return_data = array();
		
		if ( empty( $listar_use_distance_metering ) ) {
			$listar_use_distance_metering = 'all-available';
		}

		if ( empty( $lat ) || empty( $lng ) || 'disable' === $listar_use_distance_metering ) {
			return $return_data;
		}
		
		$listar_current_explore_by = listar_current_explore_by_session();
		
		/* Explore by Nearest Me references */

		$explore_by_nearest_me_reference_coordinates = listar_current_search_nearest_me_coordinates_session();
		$explore_by_nearest_me_reference_lat = $explore_by_nearest_me_reference_coordinates[0];
		$explore_by_nearest_me_reference_lng = $explore_by_nearest_me_reference_coordinates[1];
		
		$nearest_enabled = 0 === (int) get_option( 'listar_disable_search_by_nearest_me_option' ) || 0 === (int) get_option( 'listar_listing_card_geolocation_button_disable' );
		
		if ( $nearest_enabled && ! empty( $explore_by_nearest_me_reference_lat ) && ! empty( $explore_by_nearest_me_reference_lng ) ) {
			$explore_by_nearest_me_reference_label = esc_html__( 'Your Location' , 'listar' );
			
			$explore_by_nearest_me_reference_distance = listar_get_geolocated_distance( $explore_by_nearest_me_reference_lat, $explore_by_nearest_me_reference_lng, $lat, $lng );
			
			$data = array(
				'label' => listar_capitalize_phrase( $explore_by_nearest_me_reference_label ),
				'distance' => $explore_by_nearest_me_reference_distance,
			);
			
			listar_user_got_geolocated( true );
			
			if ( 'nearest_me' === $listar_current_explore_by ) {
				array_unshift( $return_data, $data );
			} else {
				$return_data[] = $data;
			}
		}
		
		/* Explore by Address references */

		$explore_by_address_current = listar_current_search_address_session();
		$explore_by_address_reference_coordinates = listar_current_search_address_coordinates_session();
		$explore_by_address_reference_lat = $explore_by_address_reference_coordinates[0];
		$explore_by_address_reference_lng = $explore_by_address_reference_coordinates[1];
		
		if ( 0 === (int) get_option( 'listar_disable_search_by_near_address_option' ) && ! empty( $explore_by_address_current ) && ! empty( $explore_by_address_reference_lat ) && ! empty( $explore_by_address_reference_lng ) ) {
			$country_name = listar_current_explore_by_country_name();
			$explore_by_address_reference_label = $explore_by_address_current;
			
			$explore_by_address_reference_distance = listar_get_geolocated_distance( $explore_by_address_reference_lat, $explore_by_address_reference_lng, $lat, $lng );
			
			$data = array(
				'label' => listar_capitalize_phrase( $explore_by_address_reference_label . ' ' . $country_name ),
				'distance' => $explore_by_address_reference_distance,
			);
			
			if ( 'near_address' === $listar_current_explore_by ) {
				array_unshift( $return_data, $data );
			} else {
				$return_data[] = $data;
			}
		}
		
		/* Explore by Postcode references */

		$explore_by_postcode_current = listar_current_search_postcode_session();
		$explore_by_postcode_reference_coordinates = listar_current_search_postcode_coordinates_session();
		$explore_by_postcode_reference_lat = $explore_by_postcode_reference_coordinates[0];
		$explore_by_postcode_reference_lng = $explore_by_postcode_reference_coordinates[1];
		
		if ( 0 === (int) get_option( 'listar_disable_search_by_near_postcode_option' ) && ! empty( $explore_by_postcode_current ) && ! empty( $explore_by_postcode_reference_lat ) && ! empty( $explore_by_postcode_reference_lng ) ) {
			$country_name = listar_current_explore_by_country_name();
			$explore_by_postcode_reference_label = $explore_by_postcode_current;
			
			$explore_by_postcode_reference_distance = listar_get_geolocated_distance( $explore_by_postcode_reference_lat, $explore_by_postcode_reference_lng, $lat, $lng );
			
			$data = array(
				'label' => listar_capitalize_phrase( $explore_by_postcode_reference_label . ' ' . $country_name ),
				'distance' => $explore_by_postcode_reference_distance,
			);
			
			if ( 'near_postcode' === $listar_current_explore_by ) {
				array_unshift( $return_data, $data );
			} else {
				$return_data[] = $data;
			}
		}
		
		$listar_region_location_reference_disabled = (int) get_option( 'listar_region_reference_metering_disable' );

		if ( 0 === $listar_region_location_reference_disabled ) {

			/* Region references */

			$region_meta = ! empty( $region_id ) ? get_option( "taxonomy_$region_id" ) : array();

			$region_primary_reference_lat   = isset( $region_meta['term_location_primary_reference_latitude'] ) ? esc_attr( $region_meta['term_location_primary_reference_latitude'] ) : '';
			$region_primary_reference_lng   = isset( $region_meta['term_location_primary_reference_longitude'] ) ? esc_attr( $region_meta['term_location_primary_reference_longitude'] ) : '';
			$region_secondary_reference_lat = isset( $region_meta['term_location_secondary_reference_latitude'] ) ? esc_attr( $region_meta['term_location_secondary_reference_latitude'] ) : '';
			$region_secondary_reference_lng = isset( $region_meta['term_location_secondary_reference_longitude'] ) ? esc_attr( $region_meta['term_location_secondary_reference_longitude'] ) : '';

			if ( ! empty( $region_primary_reference_lat ) && ! empty( $region_primary_reference_lng ) ) {

				$region_primary_reference_label = isset( $region_meta['term_location_primary_reference_label'] ) ? esc_attr( $region_meta['term_location_primary_reference_label'] ) : '';

				if ( empty( $region_primary_reference_label ) ) {
					$region_primary_reference_label = isset( $region_meta['term_location_primary_reference_address'] ) ? esc_attr( $region_meta['term_location_primary_reference_address'] ) : '';
				}

				$region_primary_reference_distance = listar_get_geolocated_distance( $region_primary_reference_lat, $region_primary_reference_lng, $lat, $lng );

				$return_data[] = array(
					'label' => listar_capitalize_phrase( $region_primary_reference_label ),
					'distance' => $region_primary_reference_distance,
				);
			}
		}
		
		$listar_fallback_references__disabled = (int) get_option( 'listar_fallback_references_disable' );

		if ( 0 === $listar_fallback_references__disabled ) {
		
			if ( ! empty( $region_secondary_reference_lat ) && ! empty( $region_secondary_reference_lng ) ) {

				$region_secondary_reference_label = isset( $region_meta['term_location_secondary_reference_label'] ) ? esc_attr( $region_meta['term_location_secondary_reference_label'] ) : '';

				if ( empty( $region_secondary_reference_label ) ) {
					$region_secondary_reference_label = isset( $region_meta['term_location_secondary_reference_address'] ) ? esc_attr( $region_meta['term_location_secondary_reference_address'] ) : '';
				}

				$region_secondary_reference_distance = listar_get_geolocated_distance( $region_secondary_reference_lat, $region_secondary_reference_lng, $lat, $lng );

				$return_data[] = array(
					'label' => listar_capitalize_phrase( $region_secondary_reference_label ),
					'distance' => $region_secondary_reference_distance,
				);
			}

			/* Fallback references from theme options */

			$fallback_primary_reference_lat   = get_option( 'listar_primary_fallback_geolocated_lat' );
			$fallback_primary_reference_lng   = get_option( 'listar_primary_fallback_geolocated_lng' );
			$fallback_secondary_reference_lat = get_option( 'listar_secondary_fallback_geolocated_lat' );
			$fallback_secondary_reference_lng = get_option( 'listar_secondary_fallback_geolocated_lng' );

			if ( ! empty( $fallback_primary_reference_lat ) && ! empty( $fallback_primary_reference_lng ) ) {

				$fallback_primary_reference_label = get_option( 'listar_primary_fallback_listing_reference_label' );

				if ( empty( $fallback_primary_reference_label ) ) {
					$fallback_primary_reference_label = get_option( 'listar_primary_fallback_listing_reference' );
				}

				$fallback_primary_reference_distance = listar_get_geolocated_distance( $fallback_primary_reference_lat, $fallback_primary_reference_lng, $lat, $lng );

				$return_data[] = array(
					'label' => listar_capitalize_phrase( $fallback_primary_reference_label ),
					'distance' => $fallback_primary_reference_distance,
				);
			}

			if ( ! empty( $fallback_secondary_reference_lat ) && ! empty( $fallback_secondary_reference_lng ) ) {

				$fallback_secondary_reference_label = get_option( 'listar_secondary_fallback_listing_reference_label' );

				if ( empty( $fallback_secondary_reference_label ) ) {
					$fallback_secondary_reference_label = get_option( 'listar_secondary_fallback_listing_reference' );
				}

				$fallback_secondary_reference_distance = listar_get_geolocated_distance( $fallback_secondary_reference_lat, $fallback_secondary_reference_lng, $lat, $lng );

				$return_data[] = array(
					'label' => listar_capitalize_phrase( $fallback_secondary_reference_label ),
					'distance' => $fallback_secondary_reference_distance,
				);
			}
		}
		
		if ( 'most-relevant' === $listar_use_distance_metering ) {
			$return_data = isset( $return_data[0] ) ? array( $return_data[0] ) : $return_data;
		}
		
		return $return_data;
	}
endif;


if ( ! function_exists( 'listar_get_nearest_me_geocoded_lat_session' ) ) :
	/**
	 * Return geolocated latitude value for current user.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_nearest_me_geocoded_lat_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat' ] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat' ] : 0;
		
	}
endif;


if ( ! function_exists( 'listar_get_nearest_me_geocoded_lng_session' ) ) :
	/**
	 * Return geolocated longitude value for current user.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_nearest_me_geocoded_lng_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng' ] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng' ] : 0;
		
	}
endif;


if ( ! function_exists( 'listar_get_address_geocoded_lat_session' ) ) :
	/**
	 * Return geolocated latitude value for an address.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_address_geocoded_lat_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lat' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lat' ] ) ? $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lat' ] : 0;
		
	}
endif;


if ( ! function_exists( 'listar_get_address_geocoded_lng_session' ) ) :
	/**
	 * Return geolocated longitude value for an address.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_address_geocoded_lng_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lng' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lng' ] ) ? $_SESSION[ $session_main_key ]['explore_by_address_geocoded_lng' ] : 0;
		
	}
endif;


if ( ! function_exists( 'listar_get_postcode_geocoded_lat_session' ) ) :
	/**
	 * Return geolocated latitude value for a postcode.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_postcode_geocoded_lat_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lat' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lat' ] ) ? $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lat' ] : 0;
		
	}
endif;


if ( ! function_exists( 'listar_get_postcode_geocoded_lng_session' ) ) :
	/**
	 * Return geolocated longitude value for a postcode.
	 *
	 * @since 1.3.8
	 * @return (string)
	 */
	function listar_get_postcode_geocoded_lng_session() {
		$session_main_key = 'listar_user_search_options';
		return isset( $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lng' ] ) && ! empty( $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lng' ] ) ? $_SESSION[ $session_main_key ]['explore_by_postcode_geocoded_lng' ] : 0;
		
	}
endif;

if ( ! function_exists( 'listar_get_currencies' ) ) :
	/**
	 * Return all currencies. Based on get_woocommerce_currency_symbols().
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_currencies() {
		return array(
			'AED' => '&#x62f;.&#x625;',
			'AFN' => '&#x60b;',
			'ALL' => 'L',
			'AMD' => 'AMD',
			'ANG' => '&fnof;',
			'AOA' => 'Kz',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => 'Afl.',
			'AZN' => 'AZN',
			'BAM' => 'KM',
			'BBD' => '&#36;',
			'BDT' => '&#2547;&nbsp;',
			'BGN' => '&#1083;&#1074;.',
			'BHD' => '.&#x62f;.&#x628;',
			'BIF' => 'Fr',
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => 'Bs.',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTC' => '&#3647;',
			'BTN' => 'Nu.',
			'BWP' => 'P',
			'BYR' => 'Br',
			'BYN' => 'Br',
			'BZD' => '&#36;',
			'CAD' => '&#36;',
			'CDF' => 'Fr',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&yen;',
			'COP' => '&#36;',
			'CRC' => '&#x20a1;',
			'CUC' => '&#36;',
			'CUP' => '&#36;',
			'CVE' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DJF' => 'Fr',
			'DKK' => 'DKK',
			'DOP' => 'RD&#36;',
			'DZD' => '&#x62f;.&#x62c;',
			'EGP' => 'EGP',
			'ERN' => 'Nfk',
			'ETB' => 'Br',
			'EUR' => '&euro;',
			'FJD' => '&#36;',
			'FKP' => '&pound;',
			'GBP' => '&pound;',
			'GEL' => '&#x20be;',
			'GGP' => '&pound;',
			'GHS' => '&#x20b5;',
			'GIP' => '&pound;',
			'GMD' => 'D',
			'GNF' => 'Fr',
			'GTQ' => 'Q',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => 'L',
			'HRK' => 'kn',
			'HTG' => 'G',
			'HUF' => '&#70;&#116;',
			'IDR' => 'Rp',
			'ILS' => '&#8362;',
			'IMP' => '&pound;',
			'INR' => '&#8377;',
			'IQD' => '&#x639;.&#x62f;',
			'IRR' => '&#xfdfc;',
			'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
			'ISK' => 'kr.',
			'JEP' => '&pound;',
			'JMD' => '&#36;',
			'JOD' => '&#x62f;.&#x627;',
			'JPY' => '&yen;',
			'KES' => 'KSh',
			'KGS' => '&#x441;&#x43e;&#x43c;',
			'KHR' => '&#x17db;',
			'KMF' => 'Fr',
			'KPW' => '&#x20a9;',
			'KRW' => '&#8361;',
			'KWD' => '&#x62f;.&#x643;',
			'KYD' => '&#36;',
			'KZT' => '&#8376;',
			'LAK' => '&#8365;',
			'LBP' => '&#x644;.&#x644;',
			'LKR' => '&#xdbb;&#xdd4;',
			'LRD' => '&#36;',
			'LSL' => 'L',
			'LYD' => '&#x644;.&#x62f;',
			'MAD' => '&#x62f;.&#x645;.',
			'MDL' => 'MDL',
			'MGA' => 'Ar',
			'MKD' => '&#x434;&#x435;&#x43d;',
			'MMK' => 'Ks',
			'MNT' => '&#x20ae;',
			'MOP' => 'P',
			'MRU' => 'UM',
			'MUR' => '&#x20a8;',
			'MVR' => '.&#x783;',
			'MWK' => 'MK',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => 'MT',
			'NAD' => 'N&#36;',
			'NGN' => '&#8358;',
			'NIO' => 'C&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#x631;.&#x639;.',
			'PAB' => 'B/.',
			'PEN' => 'S/',
			'PGK' => 'K',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PRB' => '&#x440;.',
			'PYG' => '&#8370;',
			'QAR' => '&#x631;.&#x642;',
			'RMB' => '&yen;',
			'RON' => 'lei',
			'RSD' => '&#1088;&#1089;&#1076;',
			'RUB' => '&#8381;',
			'RWF' => 'Fr',
			'SAR' => '&#x631;.&#x633;',
			'SBD' => '&#36;',
			'SCR' => '&#x20a8;',
			'SDG' => '&#x62c;.&#x633;.',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&pound;',
			'SLL' => 'Le',
			'SOS' => 'Sh',
			'SRD' => '&#36;',
			'SSP' => '&pound;',
			'STN' => 'Db',
			'SYP' => '&#x644;.&#x633;',
			'SZL' => 'L',
			'THB' => '&#3647;',
			'TJS' => '&#x405;&#x41c;',
			'TMT' => 'm',
			'TND' => '&#x62f;.&#x62a;',
			'TOP' => 'T&#36;',
			'TRY' => '&#8378;',
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => 'Sh',
			'UAH' => '&#8372;',
			'UGX' => 'UGX',
			'USD' => '&#36;',
			'UYU' => '&#36;',
			'UZS' => 'UZS',
			'VEF' => 'Bs F',
			'VES' => 'Bs.S',
			'VND' => '&#8363;',
			'VUV' => 'Vt',
			'WST' => 'T',
			'XAF' => 'CFA',
			'XCD' => '&#36;',
			'XOF' => 'CFA',
			'XPF' => 'Fr',
			'YER' => '&#xfdfc;',
			'ZAR' => '&#82;',
			'ZMW' => 'ZK',
			
			/* Here is a backup/fallback list of currency codes, in case of issues with Woocommerce defaults
			Based on: https://gist.github.com/Gibbs/3920259
			
			'AED' => '&#1583;.&#1573;',
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '&#1423;',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;',
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;',
			'BIF' => '&#70;&#66;&#117;',
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTC' => '&#8383;',
			'BTN' => '&#78;&#117;&#46;',
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BYN' => '&#82;&#98;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUC' => '&#x43;&#x55;&#x43;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;',
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;',
			'EGP' => '&#163;',
			'ERN' => '&#x4e;&#x6b;&#x66;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;',
			'GGP' => '&pound;',
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;',
			'GNF' => '&#70;&#71;',
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;',
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;',
			'IRR' => '&#65020;',
			'IRT' => '&#x62a;&#x648;&#x645;&#x627;&#x646;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;',
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;',
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;',
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;',
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;',
			'LYD' => '&#1604;.&#1583;',
			'MAD' => '&#1583;.&#1605;.',
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;',
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;',
			'MRO' => '&#85;&#77;',
			'MUR' => '&#8360;',
			'MVR' => '.&#1923;',
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PRB' => '&rcy;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;',
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'SSP' => '&#x53;&#x53;&pound;',
			'STN' => '&#x44;&#x62;',
			'SYP' => '&#163;',
			'SZL' => '&#76;',
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;',
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;',
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '&#x54;&#x53;&#x68;',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '&#x53;&#x44;&#x52;',
			'XOF' => '&#70;&#67;&#70;&#65;',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;',
			'ZWL' => '&#90;&#36;',
			*/
		);
	}
endif;


if ( ! function_exists( 'listar_get_currency_symbol' ) ) :
	/**
	 * Return current currency symbol.
	 *
	 * @since 1.3.6
	 * @return (array)
	 */
	function listar_get_currency_symbol() {
		if ( class_exists( 'Woocommerce' ) ) {
			return get_woocommerce_currency_symbol();
		} else {
			$listar_currencies = listar_get_currencies();
			$listar_current_currency = get_option( 'listar_site_currency', 'USD' );
			
			if ( empty( $listar_current_currency ) ) {
				$listar_current_currency = 'USD';
			}

			return $listar_currencies[ $listar_current_currency ];
		}
	}
endif;

if ( ! function_exists( 'listar_currency' ) ) :
	/**
	 * Get currency symbol.
	 * 
	 * Alias function for listar_get_currency_symbol().
	 *
	 * @since 1.0
	 * @return (string)
	 */
	function listar_currency() {
		return listar_get_currency_symbol();
	}

endif;


if ( ! function_exists( 'listar_get_reviews_categories' ) ) :
	/**
	 * Recover the Category Reviews from Theme Options.
	 *
	 * @since 1.3.9
	 *
	 * @return (Array)
	 */
	function listar_get_reviews_categories() {

		$default = implode( PHP_EOL, array(
			__( 'Ambient', 'listar' ),
			__( 'Variety', 'listar' ),
			__( 'Quality', 'listar' ),
		) );

		$review_categories = esc_html( get_option( 'listar_review_categories' ) );
		
		if ( empty ( $review_categories ) ) {
			$review_categories = $default;
		}

		return explode( PHP_EOL, $review_categories );
	}
endif;


if ( ! function_exists( 'listar_update_reviews_average' ) ) :
	/**
	 * Set updated review average for a listing
	 *
	 * @since 1.3.9
	 * @param (Integer) $post_id A listing ID.
	 * @return (Boolean)
	 */
	function listar_update_reviews_average( $post_id = 0 ) {
		$total = 0;
		$reviews = listar_get_reviews( $post_id );

		if ( ! $reviews ) {
			return listar_force_numeric( $total );
		}
		foreach ( $reviews as $review ) {
			$total += (int) $review;
		}
		$average = listar_force_numeric( $total / count( $reviews ) );
		return update_post_meta( $post_id, '_average_rating', $average );
	}
endif;


if ( ! function_exists( 'listar_get_reviews_db' ) ) :
	/**
	 * Get reviews via DB.
	 *
	 * @since 1.3.9
	 * @param (Integer) $post_id A listing ID.
	 * @return (Array)
	 */
	function listar_get_reviews_db( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		
		$reviews = array();

		if ( 'job_listing' !== get_post_type( $post_id ) ) {
			return array();
		}

		$args = array(
			'post_id'    => $post_id,
			'parent'     => 0, /* First level */
			'status'     => 'approve',
			'fields'     => 'ids',
			'meta_query' => array(
				'relation'    => 'OR',
				array (
					'key'     => 'review_average',
					'compare' => 'EXISTS',
				),
				array (
					'key'     => 'rating',
					'compare' => 'EXISTS',
				),
			),
		);

		$comments = get_comments( $args );

		if ( ! $comments ) {
			return $reviews;
		}

		foreach ( $comments as $comment_id ) {

			// Get review average.
			$review_average = get_comment_meta( $comment_id, 'review_average', true );

			// Add reviews.
			$reviews[ $comment_id ] = $review_average;
		}

		return $reviews;
	}
endif;


if ( ! function_exists( 'listar_get_reviews' ) ) :
	/**
	 * Get reviews for a listing.
	 *
	 * @since 1.3.9
	 * @param (Integer) $post_id A listing ID.
	 * @return (Array)
	 */
	function listar_get_reviews( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( 'job_listing' !== get_post_type( $post_id ) ) {
			return array();
		}

		$comments = absint( get_comments_number( $post_id ) );

		if ( ! $comments ) {
			return array();
		}

		$get_reviews = get_post_meta( $post_id, '_all_ratings', true );
		$reviews = is_array( $get_reviews ) ? $get_reviews : array();

		if ( count( $reviews ) > $comments ) { 
			$reviews = array();
		}

		// Check and update data once a day.
		$today = date( "Ymd" ); // YYYYMMDD.
		$last_updated = get_post_meta( $post_id, '_wpjmr_last_updated', true );

		if ( intval( $today ) !== intval( $last_updated ) || ! $reviews ) {
			$reviews = listar_get_reviews_db( $post_id );
			update_post_meta( $post_id, '_all_ratings', $reviews );
			update_post_meta( $post_id, '_wpjmr_last_updated', $today );
		}

		return $reviews;
	}
endif;


if ( ! function_exists( 'listar_update_listing_reviews_data' ) ) :
	/**
	 * Update review data for a single listing
	 *
	 * @since 1.3.9
	 * @param (Integer) $comment_id The comment ID.
	 * @param (Integer) $comment_status 0 if unapproved comment, 1 if approved.
	 */
	function listar_update_listing_reviews_data( $comment_id, $comment_status ) {
		$comment = get_comment( $comment_id );
		
		if ( isset( $comment->comment_post_ID ) ) {
			$post_id = $comment->comment_post_ID;
			$reviews = listar_get_reviews( $post_id );
			$review_average = get_comment_meta( $comment_id, 'review_average', true );

			if ( ! empty( $comment_status ) ) {
				$reviews[ $comment_id ] = $review_average;
			} else {
				unset( $reviews[ $comment_id ] );
			}

			/* Update listing reviews. */
			update_post_meta( $post_id, '_all_ratings', $reviews );

			/* Update listing reviews average. */
			listar_update_reviews_average( $post_id );
		}
	}
endif;

function listar_recalculate_reviews_bulk() {
	$exec_query = new WP_Query(
		array(
			'post_type'      => 'job_listing',
			'post_status'    => 'publish',
			'orderby'        => 'rand',
			'posts_per_page' => 1000,
		)
	);

	while ( $exec_query->have_posts() ) :
		$exec_query->the_post();
		$id = get_the_ID();
		listar_recalculate_reviews( $id );
	endwhile;
}

if ( ! function_exists( 'listar_recalculate_reviews' ) ) :
	/**
	 * Recalculare listing review average.
	 *
	 * @since 1.3.9
	 * @param (Integer) $listing_id The listing ID.
	 */
	function listar_recalculate_reviews( $listing_id = 0 ) {
	
		if ( ! empty( $listing_id ) ) {

			$count = 0;
			$review_ids = get_post_meta( $listing_id, '_all_ratings', true );
			$final_average = 0;
			$final_average_array = array();
			
			foreach ( $review_ids as $comment_id => $average ) {
				//echo get_comment_meta( $comment_id, 'review_average', true );			
				

				$stars = get_comment_meta( $comment_id, 'review_stars', true );
				
				if ( ! empty( $stars ) && is_array( $stars ) ) {
					$count++;
					
					$count2 = 0;
					$average_note = 0;
					
					foreach ( $stars as $category => $note ) {
						$count2++;						
						$average_note += (float) $note;
					}
					
					if ( $count2 > 0 ) {
						$average_note = $average_note / $count2;
						$final_average += $average_note;
					}
						
					$final_average_array[ $comment_id ] = $average_note;
				}
					
				//update_comment_meta( $comment_id, 'review_average', $average_note );
				
				//printf('<pre>%s</pre>', var_export($stars,true));

				//$review_average = $review_total / count( $review_stars );
				//update_comment_meta( $comment_id, 'review_average', $review_average );
				//listar_update_listing_reviews_data( $comment_id, $comment_data['comment_approved'] );
			}
			
			
			$final_average = $count > 0 ? listar_force_numeric( $final_average / $count ) : $final_average;
			
			//echo $listing_id;
			//echo '<br>';
			//echo $final_average;
			//echo '<br><br><br><br>';
			
			//printf('<pre>%s</pre>', var_export($final_average,true));
			//printf('<pre>%s</pre>', var_export($final_average_array,true));
			//listar_update_reviews_average( $post_id );
			
			update_post_meta( $listing_id, '_all_ratings', $final_average_array );
			update_post_meta( $listing_id, '_average_rating', $final_average );
			
			//get_post_meta( $listing_id, '_all_ratings', true );
		}
	
		/*
		$comment = get_comment( $comment_id );
		
		if ( isset( $comment->comment_post_ID ) ) {
			$post_id = $comment->comment_post_ID;
			$reviews = listar_get_reviews( $post_id );
			$review_average = get_comment_meta( $comment_id, 'review_average', true );

			if ( ! empty( $comment_status ) ) {
				$reviews[ $comment_id ] = $review_average;
			} else {
				unset( $reviews[ $comment_id ] );
			}


			update_post_meta( $post_id, '_all_ratings', $reviews );

			
			listar_update_reviews_average( $post_id );
		}
		*/
	}
endif;

if ( ! function_exists( 'listar_review_get_stars' ) ) :
	/**
	 * Recover review stars for a comment.
	 *
	 * @since 1.3.9
	 * @param (Integer) $comment_id The comment ID.
	 * @return (String)
	 */
	function listar_review_get_stars( $comment_id ) {
		$ratings = get_comment_meta( $comment_id, 'review_stars', true );
		
		$stars = '<div class="listar-list-reviews">';
		
		foreach ( $ratings as $category => $rating ) :
			$stars .= ''
			. '<div class="stars-rating star-rating"> '
			. '<div class="star-rating-title">' . esc_html( $category ) . '</div>';
			
			for ( $i = 0; $i < 5; $i++ ) :
				$stars .= '<span class="dashicons dashicons-star-' . ( $i < $rating ? 'filled' : 'empty' ) . '"></span>';
			endfor;
		
			$stars .= '</div>';
			
		endforeach;
		
		$stars .= '</div>';
		
		return $stars;
	}
endif;

if ( ! function_exists( 'listar_get_listing_average_stars' ) ) :
	/**
	 * Recover review average stars for a listing.
	 *
	 * @since 1.3.9
	 * @param (Integer) $listing_id A listing ID.
	 * @return (String)
	 */
	function listar_get_listing_average_stars( $listing_id = 0 ) {
		if ( ! $listing_id ) {
			$listing_id = get_the_ID();
		}

		$rating = listar_get_reviews_average( $listing_id );
		$full_stars = floor( $rating );
		$half_stars = ceil( $rating - $full_stars );
		$empty_stars = 5 - $full_stars - $half_stars;

		return ''
		. '<span class="stars-rating wp-job-manager-star-listing-star-rating">'
			. str_repeat( '<span class="dashicons dashicons-star-filled"></span>', $full_stars )
			. str_repeat( '<span class="dashicons dashicons-star-half"></span>', $half_stars )
			. str_repeat( '<span class="dashicons dashicons-star-empty"></span>', $empty_stars )
		. '</span>';
	}
endif;


if ( ! function_exists( 'listar_increment_post_meta_field' ) ) :
	/**
	 * Increments/resets the integer value of a meta field.
	 *
	 * @since 1.3.9
	 * @param (Integer) $post_id The post ID.
	 * @param (String) $meta_field_key The meta field key.
	 * @param (Boolean|Integer) $increment Incremental value to the counter.
	 * @param (Boolean) $reset Reset counter.
	 */
	function listar_increment_post_meta_field( $post_id, $meta_field_key = 'listar_meta_box_views_counter', $increment = false, $reset = false ) {
		$current = get_post_meta( $post_id, $meta_field_key, true );
		$count   = ( empty( $current ) ? 0 : (int) $current ) + 1;
		
		if ( $reset ) {
			$count = 0;
		}
		
		if ( false !== $increment ) {
			$count += $increment;
		}

		update_post_meta( $post_id, $meta_field_key, $count );
	}

endif;

if ( ! function_exists( 'listar_single_listing_view_counter_active' ) ) :
	/**
	 * Verify if listing view counter must be available publicly or not.
	 *
	 * @since 1.3.9
	 * @return (Boolean)
	 */
	function listar_single_listing_view_counter_active() {
		$input = (int) get_option( 'listar_single_listing_view_counter_disable' );
		return 1 === $input ? false : true;
	}

endif;


if ( ! function_exists( 'listar_get_bookmarks_user_ids' ) ) :
	/**
	 * Get the user IDs that bookmarked a post.
	 *
	 * @param (Integer) $post_id The post ID.
	 * @since 1.3.9
	 * @return (Array)
	 */
	function listar_get_bookmarks_user_ids( $post_id = 0 ) {
	
		$user_ids_array = array();

		if ( ! empty( $post_id ) ) {
			$bookmarks_user_ids = get_post_meta( $post_id, 'listar_meta_box_bookmarks_user_ids', true );
			$user_ids_array = ! empty( $bookmarks_user_ids ) ? array_filter( explode( ',', $bookmarks_user_ids ) ) : array();
		}
		
		return $user_ids_array;
	}

endif;


if ( ! function_exists( 'listar_bookmarks_get_counter' ) ) :
	/**
	 * Get the bookmarks counter for a post.
	 *
	 * @param (Integer) $post_id The post ID.
	 * @since 1.3.9
	 * @return (Array)
	 */
	function listar_bookmarks_get_counter( $post_id = 0 ) {
	
		$counter = (int) get_post_meta( $post_id, 'listar_meta_box_bookmarks_counter', true );

		return ! empty( $counter ) ? $counter : 0;
	}

endif;


if ( ! function_exists( 'listar_bookmarks_active_plugin' ) ) :
	/**
	 * Check if Bookmark is active via Theme Options
	 *
	 * @since 1.3.9
	 * @param (bool|integer) $using_ajax Can be: false (not using Ajax) or true (using Ajax).
	 * @return (bool)
	 */
	function listar_bookmarks_active_plugin() {
		return 1 === (int) get_option( 'listar_bookmarks_disable' ) ? false : true;
	}
endif;


if ( ! function_exists( 'listar_bookmarks_active' ) ) :
	/**
	 * Alias function for listar_bookmarks_active_plugin() function, from Listar Addons.
	 *
	 * @since 1.3.9
	 * @param (bool|integer) $using_ajax Can be: false (not using Ajax) or true (using Ajax).
	 * @return (bool)
	 */
	function listar_bookmarks_active() {
		return listar_addons_active() ? listar_bookmarks_active_plugin() : false;
	}
endif;


if ( ! function_exists( 'listar_update_post_counters_for_taxonomy_terms' ) ) :
	/**
	 * Update post counters for all terms of a certain taxonomy.
	 *
	 * @param (integer) $term_id The taxonomy term ID.
	 * @param (string) $taxonomy_slug The taxonomy term ID.
	 * @since 1.3.9
	 */
	function listar_update_post_counters_for_taxonomy_terms( $term_id = 0, $taxonomy_slug = '' ) {
		$term_meta = array();
	
		if ( empty( $term_id ) && empty( $taxonomy_slug ) ) {
			return;
		}
	
		$term = get_term_by( 'term_id', $term_id );
			
		if ( ( $term && ! is_wp_error( $term ) && isset( $term->taxonomy ) ) || ! empty( $taxonomy_slug ) ) :
			
			$taxonomy_slug = ! empty( $taxonomy_slug ) ? $taxonomy_slug : $term->taxonomy;

			$args = array(
				'hide_empty' => false,
			);

			$terms = get_terms( $taxonomy_slug, $args );

			if ( $terms && ! is_wp_error( $terms ) ) :

				foreach ( $terms as $term ) :
					$term_id = isset( $term->taxonomy_id ) ? $term->taxonomy_id : ( isset( $term->term_id ) ? $term->term_id : false );
			
					if ( ! empty( $term_id ) ) {
						$term_meta = get_option( "taxonomy_$term_id" );

						// Register the post IDs for a term.

						$posts_query = get_posts( array(
							'post_type' => 'job_listing',
							'numberposts' => -1,
							'fields' => 'ids',
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy_slug,
									'field' => 'term_id', 
									'terms' => $term_id,
									'include_children' => true,
								)
							)
						) );

                                                if ( ! is_array( $term_meta ) ) {
                                                        $term_meta = array();
                                                }

						$term_meta[ 'post_counter' ] = count( $posts_query );

						/* Save the option array */
						update_option( "taxonomy_$term_id", $term_meta );
					}
				endforeach;
			else :
				if ( $term && ! is_wp_error( $term ) ) :
					$term_meta[ 'post_counter' ] = '';

					/* Save the option array */
					update_option( "taxonomy_$term_id", $term_meta );
				endif;
			endif;
		endif;
	}
endif;


if ( ! function_exists( 'listar_update_all_taxonomy_term_counters' ) ) :
	/**
	 * Update post counters for all terms of all WP Job Manager taxonomies.
	 * Only update in case of low amount of listings/terms. For high amounts, a cron task will do the job.
	 *
	 * @since 1.3.9
	 */
	function listar_update_all_taxonomy_term_counters() {
		listar_update_post_counters_for_taxonomy_terms( false, 'job_listing_category' );
		listar_update_post_counters_for_taxonomy_terms( false, 'job_listing_region' );
		listar_update_post_counters_for_taxonomy_terms( false, 'job_listing_amenity' );
	}
endif;

function listar_get_all_term_ids( $taxonomy = '' ) {
	if ( empty( $taxonomy ) || ! is_string( $taxonomy ) || ! taxonomy_exists( $taxonomy ) ) {
		return array();
	}

	$term_ids = get_terms( array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
		'get'        => 'all',
		'fields'     => 'ids',
	) );

	if ( $term_ids && ! is_wp_error( $term_ids ) ) {
		return $term_ids;
	} else {
		return array();
	}
}

if ( ! function_exists( 'listar_url_query_vars_translate' ) ) :
	/**
	 * Translate WordPress query vars.
	 *
	 * @since 1.4.0
	 * @param (string) $var A query var slug to be translated.
	 * @return (string)
	 */
	function listar_url_query_vars_translate( $var ) {
		$is_listar_3 = false;
		
		if ( ! $is_listar_3 ) {
			return $var;
		}
	
		$query_vars = array(
			'search_type'         => 'tipo_busca',
			'listing_regions'     => 'regiao',
			'listing_categories'  => 'categorias',
			'listing_amenities'   => 'amenidades',
			'listing_sort'        => 'ordenamento',
			'explore_by'          => 'explorar_por',
			'selected_country'    => 'pais_selecionado',
			'saved_address'       => 'endereco_salvo',
			'saved_postcode'      => 'cep_salvo',
			'bookmarks_page'      => 'pagina_favoritos',
			'empty_bookmarks'     => 'sem_favoritos',
		);
		
		return $query_vars[ $var ];
	}
endif;

function listar_generate_wordpress_hash( $post_id = 0 ) {

	// Check for existing hash.
	$existing_hash = get_post_meta( $post_id, '_listar_post_approve_key', true );

	// If hash exists, return it.
	if ( $existing_hash ) {
		return $existing_hash;
	}

	// Generate hash.
	$hash = sha1( $post_id * time() );

	// Save hash to post meta.
	update_post_meta( $post_id, '_listar_post_approve_key', $hash );

	return $hash;

}

function listar_generate_claim_moderation_urls( $claimed_listing_id, $hash ) {

	// Prepare base approval URL.
	$approval_url = add_query_arg(
		array(
			'approve_post' => 1,
			'approve_key'  => $hash,
			'listing_id'   => $claimed_listing_id,
		),
		get_bloginfo( 'url' )
	);

	// Prepare base decline URL.
	$decline_url = add_query_arg(
		array(
			'approve_post' => 0,
			'approve_key'  => $hash,
			'listing_id'   => $claimed_listing_id,
		),
		get_bloginfo( 'url' )
	);
	
	return array( $approval_url, $decline_url );

}


if ( ! function_exists( 'listar_claim_admin_moderation_send_email' ) ) :
	/**
	 * Sends claim moderation email for administrator.
	 *
	 * @since 1.4.1
	 */
	function listar_claim_admin_moderation_send_email( $claim_post_id, $claimed_listing_id, $new_order_id, $new_author_id, $last_author_id ) {
		$listar_smtp_options      = get_option( 'swpsmtp_options' );
		$listar_message_from      = '';
		
		if ( ! empty( $listar_smtp_options ) ) {
			$listar_message_from = isset( $listar_smtp_options['from_email_field'] ) ? $listar_smtp_options['from_email_field'] : '';
		}

		$listar_message_recipient = get_option( 'listar_claim_moderator_email' );
		$listar_message_from_name = get_bloginfo();
		$listar_message_subject   = esc_html__( 'New Claim Request for Moderation', 'listar' );
		$listar_message_reply     = $listar_message_from;
		$listar_sender_name       = $listar_message_from_name;
		$listar_email_headers     = "From: " . $listar_message_from_name . " < $listar_message_from >\r\n";
		$listar_email_headers    .= "X-Sender: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= "Reply-To: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$listar_email_headers    .= "X-Priority: 1\r\n"; // Urgent message!
		$listar_email_headers    .= "MIME-Version: 1.0\r\n";
		$listar_email_headers    .= "Content-Type: text/html; charset='UTF-8'\r\n";
		
		if ( empty( $listar_message_recipient ) ) {
			$listar_message_recipient = get_bloginfo( 'admin_email' );
		}
		
		$hash = listar_generate_wordpress_hash( $claim_post_id );
		$claimed_listing_permalink = get_permalink( $claimed_listing_id );
		
		// Listing title.
		$listing_title = get_the_title( $claimed_listing_id );
		
		// Claim validation text
		$validation_text = get_post_meta( $claim_post_id, 'listar_meta_box_verification_details', true );
		
		if ( empty( $validation_text ) ) :
			$validation_text = esc_html__( 'No validation text.', 'listar' );
		endif;
		
		// Claim URL (editor).
		$claim_url = network_site_url( '/wp-admin/post.php?post=' . $claim_post_id . '&action=edit' );
		
		// New owner name.
		$claimer = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_name', true );
		
		// New owner email.
		$claimer_email = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_email', true );
		
		// New owner phone.
		$claimer_phone = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_phone', true );
		
		// Order URL (editor).
		$order_url = network_site_url( '/wp-admin/post.php?post=' . $new_order_id . '&action=edit' );
		
		// Listing URL (editor).
		$listing_editor_url = network_site_url( '/wp-admin/post.php?post=' . $claimed_listing_id . '&action=edit' );
		
		// Listing URL (front end).
		$listing_url_front = $claimed_listing_permalink . '?preview=true';
		
		// New author URL.
		$new_author_url = network_site_url( '/wp-admin/user-edit.php?user_id=' . $new_author_id );
		
		// Last author URL.
		$last_author_url = network_site_url( '/wp-admin/user-edit.php?user_id=' . $last_author_id );
		
		// Prepare base approval URL.
		$approval_url = listar_generate_claim_moderation_urls( $claimed_listing_id, $hash )[0];
		
		// Prepare base decline URL.
		$decline_url = listar_generate_claim_moderation_urls( $claimed_listing_id, $hash )[1];		
		
		$listar_message_content  = '<strong>' . esc_html__( 'Claimed:', 'listar' ) . '</strong>' . ' ' . '<a href="' . $listing_url_front . '" target="_blank">' . $listing_title . '</a><br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Claimer name:', 'listar' ) . '</strong>' . ' ' . $claimer . '<br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Claimer email:', 'listar' ) . '</strong>' . ' ' . $claimer_email . '<br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Claimer phone:', 'listar' ) . '</strong>' . ' ' . $claimer_phone . '<br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Validation data:', 'listar' ) . '</strong>' . ' ' . $validation_text . '<br/><br/>';
		$listar_message_content .= '<a href="' . $claim_url . '" target="_blank">' . esc_html__( 'Claim details', 'listar' ) . '</a><br/>';
		$listar_message_content .= '<a href="' . $order_url . '" target="_blank">' . esc_html__( 'Order details', 'listar' ) . '</a><br/>';
		$listar_message_content .= '<a href="' . $listing_editor_url . '" target="_blank">' . esc_html__( 'Listing details', 'listar' ) . '</a><br/>';
		$listar_message_content .= '<a href="' . $new_author_url . '" target="_blank">' . esc_html__( 'New author details', 'listar' ) . '</a><br/>';
		$listar_message_content .= '<a href="' . $last_author_url . '" target="_blank">' . esc_html__( 'Last author details', 'listar' ) . '</a><br/><br/>';
		$listar_message_content .= '<a href="' . $approval_url . '" target="_blank">' . esc_html__( 'Approve claim', 'listar' ) . '</a><br/>';
		$listar_message_content .= '<a href="' . $decline_url . '" target="_blank">' . esc_html__( 'Decline claim', 'listar' ) . '</a><br/>';

		$message_send_formated = wp_kses( wp_unslash( trim( $listar_message_content ) ), 'post' );
			
		// Send the email.
		wp_mail( $listar_message_recipient, '=?UTF-8?B?' . base64_encode( $listar_message_subject ) . '?=', $message_send_formated, $listar_email_headers );
	}
endif;


if ( ! function_exists( 'listar_claimer_moderation_send_email' ) ) :
	/**
	 * Sends claim moderation email for claimer.
	 *
	 * @since 1.4.1
	 */
	function listar_claimer_moderation_send_email( $claim_post_id, $claimed_listing_id, $claim_status ) {
		$listar_smtp_options      = get_option( 'swpsmtp_options' );
		$listar_message_from      = '';
		
		if ( ! empty( $listar_smtp_options ) ) {
			$listar_message_from = isset( $listar_smtp_options['from_email_field'] ) ? $listar_smtp_options['from_email_field'] : '';
		}

		$listar_message_recipient = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_email', true );
		$listar_message_from_name = get_bloginfo();
		$listar_message_subject   = esc_html__( 'Claim moderation', 'listar' );
		$listar_message_reply     = $listar_message_from;
		$listar_sender_name       = $listar_message_from_name;
		$listar_email_headers     = "From: " . $listar_message_from_name . " < $listar_message_from >\r\n";
		$listar_email_headers    .= "X-Sender: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= "Reply-To: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$listar_email_headers    .= "X-Priority: 1\r\n"; // Urgent message!
		$listar_email_headers    .= "MIME-Version: 1.0\r\n";
		$listar_email_headers    .= "Content-Type: text/html; charset='UTF-8'\r\n";
		$claimed_listing_permalink = get_permalink( $claimed_listing_id );
		
		// Listing title.
		$listing_title = get_the_title( $claimed_listing_id );
		
		// New owner name.
		$claimer = get_post_meta( $claim_post_id, 'listar_meta_box_new_author_name', true );
		
		// Listing URL (front end).
		$listing_url_front = $claimed_listing_permalink . '?preview=true';	
		
		$listar_message_content  = '<strong>' . esc_html__( 'Claimed:', 'listar' ) . '</strong>' . ' ' . '<a href="' . $listing_url_front . '" target="_blank">' . $listing_title . '</a><br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Claimer name:', 'listar' ) . '</strong>' . ' ' . $claimer . '<br/>';
		$listar_message_content .= '<strong>' . esc_html__( 'Claim status:', 'listar' ) . '</strong>' . ' ' . $claim_status;

		$message_send_formated = wp_kses( wp_unslash( trim( $listar_message_content ) ), 'post' );
			
		// Send the email.
		wp_mail( $listar_message_recipient, '=?UTF-8?B?' . base64_encode( $listar_message_subject ) . '?=', $message_send_formated, $listar_email_headers );
	}
endif;


if ( ! function_exists( 'listar_get_claim_status_translated' ) ) :
	/**
	 * Get translated status for a claim post.
	 *
	 * @since 1.4.1
	 */
	function listar_get_claim_status_translated( $post_id ) {
		$status = get_post_status( $post_id );
		$translation = '';
		
		switch ( $status ) :
			case 'trash':
				$translation = esc_html__( 'Declined', 'listar' );
				break;
			case 'draft':
				$translation = esc_html__( 'Declined', 'listar' );
				break;
			case 'pending':
				$translation = esc_html__( 'Awaiting Moderation', 'listar' );
				break;
			case 'publish':
				$translation = esc_html__( 'Approved', 'listar' );
				break;
			default :
				$translation = esc_html__( 'Awaiting Moderation', 'listar' );
		endswitch;
		
		return $translation;
	}
endif;

function listar_approve_post() {

	// If "approve_post" argument is not defined, return.
	if ( ! isset( $_GET['approve_post'] ) || ! isset( $_GET['listing_id'] ) ) {
		return;
	}
	
	// Action.
	$action = isset( $_GET['approve_post'] ) ? filter_var( sanitize_text_field( $_GET['approve_post'] ), FILTER_VALIDATE_BOOLEAN ) : false;

	// Listing ID.
	$listing_id = isset( $_GET['listing_id'] ) ? sanitize_text_field( $_GET['listing_id'] ) : false;

	// Get approval key.
	$approval_key = isset( $_GET['approve_key'] ) ? sanitize_text_field( $_GET['approve_key'] ) : false;

	// If no approval key was provided, exit.
	if ( ! $approval_key ) {
		wp_die( esc_html__( 'You must provide a post approval key.', 'email-post-approval' ) );
	}

	// Get post to approve.
	$post = get_posts(
		array(
			'post_type'      => 'listar_claim',
			'meta_key'       => '_listar_post_approve_key',
			'meta_value'     => $approval_key,
			'posts_per_page' => 1,
			'post_status'    => 'any',
		)
	);

	// If post was not found, exit.
	if ( ! $post || empty( $post ) ) {
		wp_die( esc_html__( 'The post you are attempting to moderate could not be found.', 'listar' ) );
	}
	
	if ( isset( $post[0] ) ) {

		// Reset post.
		$post = $post[0];
	}
	
	if ( $action ) {

		// Set post status.
		$post->post_status = 'publish';

		// Save post.
		wp_update_post( $post );

		// Remove approval key.
		delete_post_meta( $post->ID, '_listar_post_approve_key' );

		// Redirect to post.
		wp_redirect( get_permalink( $listing_id ) );
	} else {

		// Set post status.
		$post->post_status = 'draft';

		// Save post.
		wp_update_post( $post );

		// Remove approval key.
		delete_post_meta( $post->ID, '_listar_post_approve_key' );

		// Redirect to post.
		wp_redirect( network_site_url() . '/wp-admin/edit.php?post_type=listar_claim' );
	}

	exit();
}

if ( ! function_exists( 'listar_get_woo_order_value' ) ) :
	/**
	 * Get values saved on the Woocommerce order object.
	 *
	 * @since 1.4.1
	 * @param (object) $woo_order_item Woocommerce order items, obtained from $order->get_items().
	 * @param (string) $key Name of the associative key.
	 * @param (string) $key2 Name of the associative key inside values for $key.
	 * @return (string)
	 */
	function listar_get_woo_order_value( $woo_order_item, $key = '', $key2 = ''  ) {

		$return_value = '';
	
		if ( ! empty( $woo_order_item ) && ! empty( $key ) ) {

			$order_data_array = json_decode( $woo_order_item, true );

			if ( 'meta_data' === $key && ! empty( $key2 ) ) {
				$meta_data = isset( $order_data_array['meta_data'] ) ? $order_data_array['meta_data'] : array();

				foreach ( $meta_data as $order_data ) {
					if ( isset( $order_data[ 'key' ] ) && $key2 === $order_data[ 'key' ] ) {
						$return_value = isset( $order_data['value'] ) ? $order_data['value'] : '';
						break;
					}
				}
			} else {
				$return_value = isset( $order_data_array[ $key ] ) ? $order_data_array[ $key ] : '';
			}
		}

		return $return_value;
	}
endif;


if ( ! function_exists( 'listar_depuration_email' ) ) :
	/**
	 * Sends email for Listar developer for depuration purposes.
	 * By default, this function is not being called from any part of the customer theme/plugins and will be "manualy" called/used only in case the customer needs advanced support.
	 *
	 * @since 1.4.1
	 * @param (string|array|object) $text Depuration text.
	 */
	function listar_depuration_email( $text ) {
		$listar_message_from      = 'noreply@listar.directory';
		$listar_message_recipient = 'support@wt.ax';
		$listar_message_from_name = 'Developer depuration';
		$listar_message_subject   = $listar_message_from_name;
		$listar_message_reply     = $listar_message_from;
		$listar_sender_name       = $listar_message_from_name;
		$listar_email_headers     = "From: " . $listar_message_from_name . " < $listar_message_from >\r\n";
		$listar_email_headers    .= "X-Sender: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= "Reply-To: $listar_sender_name < $listar_message_reply >\r\n";
		$listar_email_headers    .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$listar_email_headers    .= "X-Priority: 1\r\n"; // Urgent message!
		$listar_email_headers    .= "MIME-Version: 1.0\r\n";
		$listar_email_headers    .= "Content-Type: text/html; charset='UTF-8'\r\n";
		
		if ( is_object( $text ) ) {
			$listar_message_content = sprintf('<pre>%s</pre>', var_export( json_decode( $text, true ), true ) );
		} else {
			$listar_message_content   = sprintf('<pre>%s</pre>', var_export( $text, true ) );
		}

		// Send the email.
		wp_mail( $listar_message_recipient, '=?UTF-8?B?' . base64_encode( $listar_message_subject ) . '?=', $listar_message_content, $listar_email_headers );
	}
endif;

if ( ! function_exists( 'listar_is_claiming_listing' ) ) :
	/**
	 * Check if a listing is being claimed
	 *
	 * @since 1.4.1
	 * @return (boolean)
	 */
	function listar_is_claiming_listing() {
		$is_claim = get_query_var( 'claim_listing' );
		$claim_listing_id = get_query_var( 'claim_listing_id' );
		
		return ! empty( $is_claim ) && ! empty( $claim_listing_id );
	}
endif;

if ( ! function_exists( 'listar_listing_is_claimable' ) ) :
	/**
	 * Verify if a listing is claimable.
	 *
	 * @since 1.4.1
	 * @param (integer) $job_listing_id The listing ID.
	 * @return (boolean)
	 */
	function listar_listing_is_claimable( $job_listing_id ) {

		$listing = get_post( $job_listing_id );
		$is_claimed = get_post_meta( $job_listing_id, '_job_businessclaim', true );

		return
			$listing &&
			isset( $listing->post_type ) && 'job_listing' === $listing->post_type &&
			'publish' === $listing->post_status &&
			( 'not-claimed' === $is_claimed || empty( $is_claimed ) );
	}
endif;


if ( ! function_exists( 'listar_listing_claim_status' ) ) :
	/**
	 * Check the claim status of a listing.
	 *
	 * @since 1.4.1
	 * @param (integer) $listing_id The listing ID.
	 * @return (string)
	 */
	function listar_listing_claim_status( $listing_id ) {
		$claim_status = get_post_meta( $listing_id, '_job_businessclaim', true );
		
		if ( empty( $claim_status ) ) {
			$claim_status = 'not-claimed';
		}
		
		return $claim_status;
	}
endif;

if ( ! function_exists( 'listar_is_claim_enabled' ) ) :
	/**
	 * Check if claims are enabled.
	 *
	 * @since 1.4.1
	 * @return (boolean)
	 */
	function listar_is_claim_enabled() {
		return 0 === (int) get_option( 'listar_disable_claims' );
	}
endif;

if ( ! function_exists( 'listar_get_package_options_disabled' ) ) :
	/**
	 * Get Woocommerce listing package features that are disabled/enabled for a package.
	 *
	 * @since 1.4.2
	 * @param (integer) $package_id The Woocommerce product ID.
	 * @param (string) $status 'disabled' or 'enabled'
	 * @return (array)
	 */
	function listar_get_package_options_disabled( $package_id = 0, $status = 'disabled' ) {
		$return_fields = array();
		
		if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) ) :
			if ( empty( $package_id ) ) {
				$package_id = listar_post_package_id();
			}

			$package_options = ! empty( $package_id ) ? get_post_meta( $package_id, 'listar_meta_box_package_options', true ) : false;

			if ( ! empty( $package_options ) && '{}' !== $package_options ) {
				$package_options = listar_json_decode_nice( $package_options );

				if ( isset( $package_options['listar_customization_custom_package_option_activation'] ) && 'on' === $package_options['listar_customization_custom_package_option_activation'] ) :
					$return_fields[ 'listar_package_is_customized' ] = true;

					foreach ( $package_options as $key => $value ) {
						if ( false !== strpos( $key, '_custom_package_option_activation' ) && 'listar_customization_custom_package_option_activation' !== $key ) {
							if ( ( 'disabled' === $status && 'on' !== $value ) || ( 'enabled' === $status && 'on' === $value ) ) {
								$field_key = str_replace( '_custom_package_option_activation', '', $key );
								$return_fields[ $field_key ] = true;
							}
						}
					}
				endif;
			}
		endif;
		
		return $return_fields;
	}
endif;

if ( ! function_exists( 'listar_get_package_options_required' ) ) :
	/**
	 * Get Woocommerce listing package features that are required for a package.
	 *
	 * @since 1.4.2
	 * @param (integer) $package_id The Woocommerce product ID.
	 * @return (array)
	 */
	function listar_get_package_options_required( $package_id = 0 ) {
		$return_fields = array();
		
		if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) ) :
			
		
		if ( empty( $package_id ) ) {
			$package_id = listar_post_package_id();
		}
		
		$package_options = ! empty( $package_id ) ? get_post_meta( $package_id, 'listar_meta_box_package_options', true ) : false;
		
		if ( ! empty( $package_options ) && '{}' !== $package_options ) {
			$package_options = listar_json_decode_nice( $package_options );
			
			if ( isset( $package_options['listar_customization_custom_package_option_activation'] ) && 'on' === $package_options['listar_customization_custom_package_option_activation'] ) :
				foreach ( $package_options as $key => $value ) {
					if ( false !== strpos( $key, '_custom_package_option_required' ) && 'listar_customization_custom_package_option_required' !== $key ) {
						if ( 'on' === $value ) {
							$field_key = str_replace( '_custom_package_option_required', '', $key );
							$return_fields[ $field_key ] = true;
						}
					}
				}
			endif;
		}
		endif;
		
		return $return_fields;
	}
endif;



if ( ! function_exists( 'listar_get_package_options_enabled_output' ) ) :
	/**
	 * Get the output for Woocommerce listing package features that are disabled/enabled for a package.
	 *
	 * @since 1.4.2
	 * @param (integer) $package_id The Woocommerce product ID.
	 * @param (string) $status 'enabled' or 'both'
	 * @return (string)
	 */
	function listar_get_package_options_enabled_output( $package_id = 0, $status = 'enabled' ) {
		$return_output = '';
		
		if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) ) :
		
			if ( empty( $package_id ) ) {
				$package_id = listar_post_package_id();
			}
			
			$product = wc_get_product( $package_id );

			$package_options = ! empty( $package_id ) ? get_post_meta( $package_id, 'listar_meta_box_package_options', true ) : false;

			if ( ! empty( $package_options ) && '{}' !== $package_options ) {
				$package_options = listar_json_decode_nice( $package_options );

				if ( isset( $package_options['listar_customization_custom_package_option_activation'] ) && 'on' === $package_options['listar_customization_custom_package_option_activation'] ) :
					foreach ( $package_options as $key => $value ) {
						if ( false !== strpos( $key, '_custom_package_option_activation' ) && 'listar_customization_custom_package_option_activation' !== $key ) {
							$display_key = $key;
							
							if ( false === strpos( $key, 'setup' ) ) {
								$display_key = str_replace( '_custom_package_option_activation', '_custom_package_option_display', $key );
							}

							if ( isset( $package_options[ $display_key ] ) && 'on' === $package_options[ $display_key ] ) {
							
								if ( ( 'enabled' === $status && 'on' === $value ) ) {
									
									if ( false !== strpos( $display_key, 'setup' ) ) :
										if ( false !== strpos( $display_key, 'limit_setup' ) ) :
											$value = get_post_meta( $package_id, '_job_listing_limit', true );
											$count_2 = zeroise( $value, 1 );
											$count_3 = zeroise( $value, 2 );
										
											$return_output .= '<p class="listar-has-icon icon-checkmark-circle">';
											$return_output .= sprintf( 
												_n(
													'%s listing',
													'%s listings',
													$count_2,
													'listar'
												),
												$count_3
											);
											$return_output .= '</p>';
										endif;

										if ( false !== strpos( $display_key, 'featured_setup' ) ) :
											$value  = get_post_meta( $package_id, '_job_listing_featured', true );
											$string = 'yes' === $value ? esc_html__( 'Get Featured', 'listar' ) : esc_html__( 'No Featured', 'listar' );
											$class  = 'yes' === $value ? 'listar-has-icon icon-star' : 'listar-has-icon icon-cross-circle';
										
											$return_output .= '<p class="' . esc_attr( listar_sanitize_html_class( $class ) ) . '">';
											$return_output .= $string;
											$return_output .= '</p>';
										endif;

										if ( false !== strpos( $display_key, 'promotional_setup' ) ) :
											$price_after  = $product->get_sale_price();
											
											if ( ! empty( $price_after ) ) :
												$string = esc_html__( 'Promotional Price', 'listar' );
												$class  = 'listar-has-icon icon-percent-circle';

												$return_output .= '<p class="' . esc_attr( listar_sanitize_html_class( $class ) ) . '">';
												$return_output .= $string;
												$return_output .= '</p>';
											endif;
										endif;

										if ( false !== strpos( $display_key, 'expiration_setup' ) ) :
											
											$duration = $product->get_duration();

											$string = sprintf(

												/* TRANSLATORS: %s: Listing expiration period (duration). */
												esc_html__( 'Expires in %s days', 'listar' ),
												zeroise( $duration, 2 )
											);
											
											$class  = 'listar-has-icon icon-alarm2';
											
											if ( $product->is_type( array( 'job_package_subscription' ) ) ) :
												$string = esc_html__( 'Automatic Renew', 'listar' );

												$class  = 'listar-has-icon icon-alarm-add2';
											endif;

											$return_output .= '<p class="' . esc_attr( listar_sanitize_html_class( $class ) ) . '">';
											$return_output .= $string;
											$return_output .= '</p>';
										endif;
									else :
										$icon_key = str_replace( '_custom_package_option_activation', '_custom_package_option_icon', $key );
										$icon_class = isset( $package_options[ $icon_key ] ) && ! empty( $package_options[ $icon_key ] ) ? 'listar-has-icon ' . $package_options[ $icon_key ] : 'listar-no-icon';

										$return_output .= '<p class="' . $icon_class . '">';

										$listar_vendor_store_disable = get_option( 'listar_who_can_create_stores' );
			
										if ( empty( $listar_vendor_store_disable ) ) {
											$listar_vendor_store_disable = 'listing-package-membership';
										}

										if ( 'listar_disable_vendor_store_custom_package_option_activation' === $key && ( 'nobody' ) !== $listar_vendor_store_disable ) :
											$return_output .= esc_html__( 'Create Store, Sell Products', 'listar' );
										endif;

										$listar_private_message_disable = (int) get_option( 'listar_disable_private_message' );

										if ( 'listar_disable_private_message_custom_package_option_activation' === $key && 0 === $listar_private_message_disable ) :
											$return_output .= esc_html__( 'Private Messages', 'listar' );
										endif;

										if ( 'listar_disable_job_listing_subtitle_custom_package_option_activation' === $key ) :
											$return_output .= esc_html__( 'Listing Subtitle', 'listar' );
										endif;

										$listar_location_disable = (int) get_option( 'listar_location_disable' );

										if ( 'listar_location_disable_custom_package_option_activation' === $key && 0 === $listar_location_disable ) :
											$return_output .= esc_html__( 'Location', 'listar' );
										endif;

										$listar_map_disable = (int) ( ! ( listar_is_map_enabled( 'all' ) && listar_is_map_enabled( 'single' ) ) );

										if ( 'listar_disable_map_custom_package_option_activation' === $key && 0 === $listar_map_disable ) :
											$return_output .= esc_html__( 'Map', 'listar' );
										endif;

										if ( 'listar_disable_job_tagline_custom_package_option_activation' === $key ) :
											$return_output .= esc_html__( 'Tagline or Slogan', 'listar' );
										endif;

										if ( 'listar_disable_job_listing_region_custom_package_option_activation' === $key && class_exists( 'Astoundify_Job_Manager_Regions' ) ) :
											$return_output .= esc_html__( 'Listing Regions', 'listar' );
										endif;

										if ( 'listar_disable_job_listing_category_custom_package_option_activation' === $key && taxonomy_exists( 'job_listing_category' ) ) :
											$return_output .= esc_html__( 'Listing Categories', 'listar' );
										endif;

										if ( 'listar_disable_job_listing_amenity_custom_package_option_activation' === $key && taxonomy_exists( 'job_listing_amenity' ) ) :
											$return_output .= esc_html__( 'Listing Amenities', 'listar' );
										endif;

										if ( 'listar_disable_job_searchtags_custom_package_option_activation' === $key ) :
											$return_output .= esc_html__( 'Search Tags', 'listar' );
										endif;

										$listar_operating_hours_disable = (int) get_option( 'listar_operating_hours_disable' );

										if ( 'listar_operating_hours_disable_custom_package_option_activation' === $key && 0 === $listar_operating_hours_disable ) :
											$return_output .= esc_html__( 'Operation Hours', 'listar' );
										endif;

										$listar_menu_disable = (int) get_option( 'listar_menu_catalog_disable' );

										if ( 'listar_menu_catalog_disable_custom_package_option_activation' === $key && 0 === $listar_menu_disable ) :
											$return_output .= esc_html__( 'Menu/Catalog', 'listar' );
										endif;

										$listar_appointments_disable = (int) get_option( 'listar_appointments_disable' );

										if ( 'listar_booking_service_disable_custom_package_option_activation' === $key && 0 === $listar_appointments_disable ) :
											$return_output .= esc_html__( 'Appointments', 'listar' );
										endif;

										$listar_price_range_disable = (int) get_option( 'listar_price_range_disable' );

										if ( 'listar_price_range_disable_custom_package_option_activation' === $key && 0 === $listar_price_range_disable ) :
											$return_output .= esc_html__( 'Price Range', 'listar' );
										endif;

										$listar_popular_price_disable = (int) get_option( 'listar_popular_price_disable' );

										if ( 'listar_popular_price_disable_custom_package_option_activation' === $key && 0 === $listar_popular_price_disable ) :
											$return_output .= esc_html__( 'Average Price', 'listar' );
										endif;

										if ( 'listar_main_image_disable_custom_package_option_activation' === $key ) :
											$return_output .= esc_html__( 'Main Image', 'listar' );
										endif;

										$listar_logo_disable = (int) get_option( 'listar_logo_disable' );

										if ( 'listar_logo_disable_custom_package_option_activation' === $key && 0 === $listar_logo_disable ) :
											$return_output .= esc_html__( 'Listing Logo', 'listar' );
										endif;

										if ( 'listar_disable_gallery_images_custom_package_option_activation' === $key ) :
											$maxGalleryImages = listar_get_max_image_gallery( (int) $package_id );

											$return_output .= sprintf(

												/* TRANSLATORS: %s: Number of images to gallery. */
												esc_html__( '%s Images to Gallery', 'listar' ),
												zeroise( $maxGalleryImages, 2 )
											);
										endif;

										if ( 'listar_disable_company_youtube_custom_package_option_activation' === $key ) :
											$maxMedia = listar_get_media_fields_limit( (int) $package_id );

											$return_output .= sprintf(

												/* TRANSLATORS: %s: Number of media fields. */
												esc_html__( '%s Videos and Other Media', 'listar' ),
												zeroise( $maxMedia, 2 )
											);
										endif;

										$listar_phone_disable = (int) get_option( 'listar_phone_disable' );

										if ( 'listar_phone_disable_custom_package_option_activation' === $key && 0 === $listar_phone_disable ) :
											$return_output .= esc_html__( 'Phone', 'listar' );
										endif;

										$listar_mobile_disable = (int) get_option( 'listar_mobile_disable' );

										if ( 'listar_mobile_disable_custom_package_option_activation' === $key && 0 === $listar_mobile_disable ) :
											$return_output .= esc_html__( 'Mobile', 'listar' );
										endif;

										$listar_whatsapp_disable = (int) get_option( 'listar_whatsapp_disable' );

										if ( 'listar_whatsapp_disable_custom_package_option_activation' === $key && 0 === $listar_whatsapp_disable ) :
											$return_output .= esc_html__( 'WhatsApp', 'listar' );
										endif;

										$listar_fax_disable = (int) get_option( 'listar_fax_disable' );

										if ( 'listar_fax_disable_custom_package_option_activation' === $key && 0 === $listar_fax_disable ) :
											$return_output .= esc_html__( 'Fax', 'listar' );
										endif;

										$listar_website_disable = (int) get_option( 'listar_website_disable' );

										if ( 'listar_website_disable_custom_package_option_activation' === $key && 0 ===$listar_website_disable ) :
											$return_output .= esc_html__( 'Website', 'listar' );
										endif;

										$listar_social_disable = (int) get_option( 'listar_social_networks_disable' );

										if ( 'listar_social_networks_disable_custom_package_option_activation' === $key && 0 === $listar_social_disable ) :
											$return_output .= esc_html__( 'Social Networks', 'listar' );
										endif;

										$listar_references_disable = (int) get_option( 'listar_external_references_disable' );

										if ( 'listar_external_references_disable_custom_package_option_activation' === $key && 0 === $listar_references_disable ) :
											$return_output .= esc_html__( 'External References', 'listar' );
										endif;

										$return_output .= '</p>';
									endif;
								} elseif ( 'both' === $status ) {
									// Near future.
								}
							}
						}
					}
				endif;
			}
		endif;
		
		return $return_output;
	}
endif;

function listar_is_job_submission_form_page() {
	global $wp_query;

	if ( 
		// Adding.
		( isset( $wp_query->queried_object->post_content ) && false !== strpos( $wp_query->queried_object->post_content, '[submit_job_form]' ) ) ||

		// Editing.
		( listar_is_editing_listing_front() && isset( $wp_query->queried_object->post_content ) && false !== strpos( $wp_query->queried_object->post_content, '[job_dashboard]' ) )
	) {
		return true;
	}

	return false;
}

if ( ! function_exists( 'listar_is_editing_listing_front' ) ) :
	/**
	 * Check if a listing is being "edited" on the front page submission form.
	 *
	 * @since 1.5.0
	 * @return (boolean)
	 */
	function listar_is_editing_listing_front() {
		$temp = filter_input( INPUT_GET, 'job_id', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		return ! empty( $temp );
	}
endif;

if ( ! function_exists( 'listar_get_listing_id' ) ) :
	/**
	 * Get current listing ID.
	 *
	 * @since 1.5.0
	 * @return (integer)
	 */
	function listar_get_listing_id() {
		$temp = filter_input( INPUT_GET, 'job_id', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
		return ! empty( $temp ) ? absint( $temp ) : 0;
	}
endif;

if ( ! function_exists( 'listar_get_listing_author_id' ) ) :
	/**
	 * Get current listing ID.
	 *
	 * @since 1.5.0
	 * @return (integer)
	 */
	function listar_get_listing_author_id() {
		static $author_id = false;
		
		if ( empty( $author_id ) ) {
			global $post;
			
			$fallback_post_id = 0;
			
			if ( NULL === $post ) {
				$fallback_post_id = filter_input( INPUT_GET, 'post', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
			}
		
			$post_id = empty( $fallback_post_id ) && listar_is_editing_listing_front() ? listar_get_listing_id() : $fallback_post_id;
			
			if( empty( $post_id ) && isset( $post->ID ) ) {
				$post_id = $post->ID;
			}
			
			$author_id = ! empty( $post_id ) ? get_post_field ( 'post_author', $post_id ) : get_current_user_id();
		}
		
		return $author_id;
	}
endif;

function listar_get_current_url() {
        global $wp;
                
        $current_url = '';
        $query_args  = isset( $wp->query_vars ) && ! empty( $wp->query_vars ) ? $wp->query_vars : '';
        $wp_request  = isset( $wp->request ) && ! empty( $wp->request ) ? $wp->request : '';
        
        if ( ! empty( $query_args ) ) {
                $current_url = add_query_arg( $query_args, network_site_url( $wp_request ) );
        } else {
                $current_url = network_site_url( $wp_request );
        }

        if ( false !== strpos( $current_url, 'page&job_listing' ) && false !== strpos( $current_url, '?' ) ) {
                $temp = explode( '?', $current_url );
                $current_url = $temp[0];
        }

        return $current_url;
}

if ( ! function_exists( 'listar_get_user_products_titles' ) ) :
	/**
	 * Get user product IDs and titles.
	 *
	 * @since 1.5.0
	 * @return (array)
	 */
	function listar_get_user_products_titles() {	
		static $user_products = array();
		
		if ( empty( $user_products ) ) {
			global $wpdb;

			$user_id = listar_get_listing_author_id();

			$tax_query = array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => array ( 'job_package', 'job_package_subscription' ),
					'operator' => 'NOT IN',
				),
			);

			$tax_query      = new WP_Tax_Query( $tax_query );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

			$sql  = "SELECT {$wpdb->posts}.ID,{$wpdb->posts}.post_title FROM {$wpdb->posts} ";
			$sql .= $tax_query_sql['join'];
			$sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' AND post_author = '" . $user_id . "'";
			$sql .= $tax_query_sql['where'];

			$temp = $wpdb->get_results( $sql ); // WPCS: unprepared SQL ok.
			
			if ( is_array( $temp ) ) {
				foreach( $temp as $post ) {
					if ( isset( $post->ID ) && ! empty( $post->ID ) && isset( $post->post_title ) && ! empty( $post->post_title ) ) {
						$user_products[ $post->ID ] = $post->post_title ;
					}
				}
			}
		}
		
		return $user_products;		
	}
endif;

if ( ! function_exists( 'listar_post_package_id' ) ) :
	/**
	 * Get package ID from $_POST
	 *
	 * @since 1.4.2
	 * @return (integer)
	 */
	function listar_post_package_id() {
		$listar_listing_package_id = 0;
		
		if ( class_exists( 'Woocommerce' ) && class_exists( 'WC_Paid_Listings' ) ) :
			
			$listing_id = isset( $_GET['job_id'] ) && ! empty( $_GET['job_id'] ) ? absint( $_GET['job_id'] ) : 0;
			$is_user_package = false;

			if ( ! empty( $listing_id ) ) {

				// Editing a existing listing on front end submission for.
				$listar_listing_package_id = get_post_meta( $listing_id, '_package_id', true );

			} else {

				if ( isset( $_POST['job_package'] ) && ! empty( $_POST['job_package'] ) ) {
					if ( is_numeric( $_POST['job_package'] ) ) {
						$listar_listing_package_id = absint( $_POST['job_package'] );
						$is_user_package = false;
					} else {
						$listar_listing_package_id = absint( substr( $_POST['job_package'], 5 ) );
						$is_user_package = true;
					}
				} elseif ( ! empty( $_COOKIE['chosen_package_id'] ) && ! is_singular( 'job_listing' ) ) {
					$listar_listing_package_id = absint( $_COOKIE['chosen_package_id'] );
					$is_user_package = absint( $_COOKIE['chosen_package_is_user_package'] ) === 1;
				}

				if ( $is_user_package ) {
					$last_user_package = wc_paid_listings_get_user_package( $listar_listing_package_id );
					$listar_listing_package_id = $last_user_package->get_product_id();
				}
			}
		endif;
		
		return $listar_listing_package_id;
	}
endif;


if ( ! function_exists( 'listar_get_max_image_gallery' ) ) :
	/**
	 * Get the number of images for gallery upload, per listing package.
	 *
	 * @since 1.4.2
	 * @param (integer) $package_id The package ID.
	 * @return (integer)
	 */
	function listar_get_max_image_gallery( $package_id = 0 ) {
		$max_gallery_upload = 0;
		
		if ( empty( $package_id ) ) {
			$package_id = listar_post_package_id();
		}
		
		if ( ! empty( $package_id ) ) {
			$package_options = ! empty( $package_id ) ? get_post_meta( $package_id, 'listar_meta_box_package_options', true ) : false;
		
			if ( ! empty( $package_options ) && '{}' !== $package_options ) {
				$package_options = listar_json_decode_nice( $package_options );

				if ( isset( $package_options['listar_customization_custom_package_option_activation'] ) && 'on' === $package_options['listar_customization_custom_package_option_activation'] && isset( $package_options['listar_disable_gallery_images_custom_package_option_limit'] ) && ! empty( $package_options['listar_disable_gallery_images_custom_package_option_limit'] )  ) :
					$max_gallery_upload = $package_options['listar_disable_gallery_images_custom_package_option_limit'];
				endif;
			}
		}
		
		if ( empty( $max_gallery_upload ) ) {
			$max_gallery_upload = get_option( 'listar_max_gallery_upload_images' );
			
			if ( empty( $max_gallery_upload ) ) {
				$max_gallery_upload = 30;
			}
		}
		
		return $max_gallery_upload;
	}
endif;


if ( ! function_exists( 'listar_get_media_fields_limit' ) ) :
	/**
	 * Get the maximum number of video/media fields for the front end submission form
	 *
	 * @since 1.4.7
	 * @param (integer) $package_id The package ID.
	 * @return (integer)
	 */
	function listar_get_media_fields_limit( $package_id = 0 ) {
		$max_media_upload = 0;
		
		if ( empty( $package_id ) ) {
			$package_id = listar_post_package_id();
		}
		
		if ( ! empty( $package_id ) ) {
			$package_options = ! empty( $package_id ) ? get_post_meta( $package_id, 'listar_meta_box_package_options', true ) : false;
		
			if ( ! empty( $package_options ) && '{}' !== $package_options ) {
				$package_options = listar_json_decode_nice( $package_options );

				if ( isset( $package_options['listar_customization_custom_package_option_activation'] ) && 'on' === $package_options['listar_customization_custom_package_option_activation'] && isset( $package_options['listar_disable_company_youtube_custom_package_option_limit'] ) && ! empty( $package_options['listar_disable_company_youtube_custom_package_option_limit'] )  ) :
					$max_media_upload = $package_options['listar_disable_company_youtube_custom_package_option_limit'];
				endif;
			}
		}
		
		if ( empty( $max_media_upload ) ) {
			$max_media_upload = get_option( 'listar_max_media_fields' );
			
			if ( empty( $max_media_upload ) ) {
				$max_media_upload = 30;
			}
		}
		
		return $max_media_upload;
	}
endif;


if ( ! function_exists( 'listar_get_card_edit_link' ) ) :
	/**
	 * Get the edit link (front end edit) for listing cards.
	 *
	 * @since 1.4.4
	 */
	function listar_get_card_edit_link() {
		global $post;
		
		$listing_id = $post->ID;
		$current_user_id = get_current_user_id();
		$listar_user_logged_in = is_user_logged_in();
		$listing_owner_id = $post->post_author;
		$current_user_role = listar_get_current_user_role();

		if ( $listar_user_logged_in && ( 'administrator' === $current_user_role || 'editor' === $current_user_role || (int) $current_user_id === (int) $listing_owner_id ) ) :

			$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );

			if ( ! empty( $listar_job_dashboard_url ) ) :
				$front_end_edit_url = $listar_job_dashboard_url . '?action=edit&job_id=' . $listing_id;
				?>
				<a class="listar-post-edit-link-card post-edit-link fa fa-pencil" href="<?php echo esc_url( $front_end_edit_url ); ?>" target="_blank"></a>
				<?php
			endif;
		endif;
	}
endif;


if ( ! function_exists( 'listar_get_card_edit_link_alias' ) ) :
	/**
	 * Alias function for listar_get_card_edit_link(), from Listar Addons plugin.
	 *
	 * @since 1.4.4
	 */
	function listar_get_card_edit_link_alias() {
		if ( listar_addons_active() ) {
			listar_get_card_edit_link();
		}
	}
endif;

if ( ! function_exists( 'listar_get_session_key' ) ) :
	/**
	 * Recover the global session variable.
	 *
	 * @since 1.4.5
	 * @param (string) $key The key that must exist in the session.
	 */
	function listar_get_session_key( $key = '' ) {
		if ( is_admin() ) {
			return false;
		}

		if ( ! empty( $key ) ) {
			return isset( $_SESSION[ $key ] ) ? $_SESSION[ $key ] : false;
		} else {
			return isset( $_SESSION ) ? $_SESSION : false;
		}
	}
endif;

if ( ! function_exists( 'listar_modify_session_key' ) ) :
	/**
	 * Modify a session variable.
	 *
	 * @since 1.4.5
	 * @param (string) $key The key to get the value modified.
	 * @param (string) $child_key Child key to get the value modified.
	 */
	function listar_modify_session_key( $key = '', $child_key = '', $value = '' ) {
		if ( ! empty( $key ) ) {
			if ( ! empty( $child_key ) ) {
				$_SESSION[ $key ][ $child_key ] = $value;
			} else {
				$_SESSION[ $key ] = $value;
			}
		}
	}
endif;


if ( ! function_exists( 'listar_get_current_domain_url' ) ) :
	/**
	 * Get the URL for current domain
	 *
	 * @since 1.4.6
	 * @return (array)
	 */
	function listar_get_current_domain_url() {
		$network = network_site_url();
		$network2 = explode( '://', $network );
		$network3 = $network2[1];
		$domain_url = $network;
		$only_domain = str_replace( array( 'http://', 'https://' ), '', $domain_url );
		$path = '';
		
		if ( false !== strpos( $network3, '/' ) ) {
			$network4 = explode( '/', $network3 );
			$only_domain = $network4[0];
			
			$path1 = explode( $only_domain . '/', $domain_url );
			$path = $path1[1];
		}
		
		return array( $domain_url, $only_domain, $path );
	}
endif;

if ( ! function_exists( 'listar_is_wcfm_active' ) ) :
	function listar_is_wcfm_active() {
		return function_exists( 'wcfm_get_vendor_store_name' );
	}
endif;

if ( ! function_exists( 'listar_is_wcfmmp_active' ) ) :
	function listar_is_wcfmmp_active() {
		return defined('WCFMmp_TEXT_DOMAIN');
	}
endif;

if ( ! function_exists( 'listar_get_user_packages' ) ) :
	function listar_get_user_packages( $user_id = 0 ) {
		global $wpdb;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wcpl_user_packages WHERE user_id = '" . $user_id . "'" );
	}
endif;

if ( ! function_exists( 'listar_get_user_available_package_products' ) ) :
	function listar_get_user_available_package_products( $user_id = 0 ) {
		$listing_limits = 0;
		$woo_product_ids = array();
		$package_ids = array();
		$has_package_active = false;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		$packages = listar_get_user_packages( $user_id );

		foreach ( $packages as $package ) {
			$woo_product_ids[] = $package->product_id;
			$package_ids[] = $package->id;
			$package = wc_paid_listings_get_package( $package );
			$listing_limits += $package->get_limit() ? absint( $package->get_limit() - $package->get_count() ) : 999;
		}

		if ( $listing_limits > 0 ) {
			$has_package_active = true;
		}

		return array( array_unique( $woo_product_ids ), $has_package_active, array_unique( $package_ids ) );
	}
endif;

if ( ! function_exists( 'listar_get_user_woo_package_products_via_listings_published' ) ) :
	function listar_get_user_woo_package_products_via_listings_published( $user_id = 0, $status = 'publish' ) {
		global $wpdb;

		$woo_product_ids = array();
		$listing_ids = array();
		$has_package_active = false;

		if ( empty( $user_id ) || ! class_exists( 'WC_Paid_Listings' ) ) {
			return false;
		}

		$data = array();
		
		if ( 'publish' == $status ) {
			$data = $wpdb->get_results( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_listing' AND ( post_status = 'publish' OR post_status = 'draft' OR post_status = 'pending' ) AND post_author = '" . $user_id . "'" );	
		} else {
			$data = $wpdb->get_results( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_listing' AND post_status = '" . $status ."' AND post_author = '" . $user_id . "'" );	
		}

		if ( is_array( $data ) ) {
			foreach ( $data as $elem ) {
				$listing_id = $elem->ID;
				$product_id = get_post_meta( $listing_id, '_package_id', true );

				if ( ! empty( $product_id ) ) {
					$woo_product_ids[] = $product_id;
					$listing_ids[] = $listing_id;
					$has_package_active = true;
				}
			}
		}

		return array( array_unique( $woo_product_ids ), $has_package_active, $listing_ids );
	}
endif;

if ( ! function_exists( 'listar_user_has_package_with_store' ) ) :
	function listar_user_has_package_with_store( $user_id = 0 ) {

		static $authorized_vendors = array();

		if ( ! empty( $authorized_vendors ) && in_array( (int) $user_id, $authorized_vendors, true ) ) {
			return true;
		}

		$verified_packages = array();
		$allow_store = false;	

		// Step 1 - Verify if user has product packages with listings available to be published currently and if the
		// Woocommerce Product behind these packages allows the creation of stores.

		$condition1 = listar_get_user_available_package_products( $user_id );

		if ( ! empty( $condition1 ) && isset( $condition1[1] ) && true === $condition1[1] && ! empty( $condition1[0] ) ) {
			foreach ( $condition1[0] as $product_id ) {
				if ( ! empty( $product_id ) ) {
					$verified_packages[] = $product_id;				
					$disabled_package_options = listar_addons_active() && ! empty( $product_id ) ? listar_get_package_options_disabled( $product_id ) : array();

					if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
						$authorized_vendors[] = (int) $user_id;
						$allow_store = true;
						break;
					endif;
				}
			}
		}

		if ( ! $allow_store ) {

			// Step 2 - Verify if the user has listings published currently and if the
			// Woocommerce Product behind these listings allows the creation of stores.

			$condition2 = listar_get_user_woo_package_products_via_listings_published( $user_id );

			if ( ! empty( $condition2 ) && isset( $condition2[1] ) && true === $condition2[1] && ! empty( $condition2[0] ) ) {
				foreach ( $condition2[0] as $product_id ) {
					if ( ! empty( $product_id ) && ! in_array( $product_id, $verified_packages ) ) {
						$verified_packages[] = $product_id;
						$disabled_package_options = listar_addons_active() && ! empty( $product_id ) ? listar_get_package_options_disabled( $product_id ) : array();

						if ( ! isset( $disabled_package_options['listar_disable_vendor_store'] ) ) :
							$authorized_vendors[] = (int) $user_id;
							$allow_store = true;
							break;
						endif;
					}
				}
			}
		}

		return $allow_store;
	}
endif;

if ( ! function_exists( 'listar_is_vendor_authorized' ) ) :
	function listar_is_vendor_authorized( $user_id = '' ) {

		if ( empty( $user_id ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();
		}

		$listar_vendor_store_disable = get_option( 'listar_who_can_create_stores' );

		if ( empty( $listar_vendor_store_disable ) ) {
			$listar_vendor_store_disable = 'listing-package-membership';
		}

		if ( ! ( 'nobody' === $listar_vendor_store_disable || ! listar_is_wcfm_active() || ! listar_is_wcfmmp_active() ) ) {
			if ( 'all-subscribers' === $listar_vendor_store_disable ) {
				return true;
			}

			/* Depends on Listing Packages */

			if ( 'listing-package-membership' === $listar_vendor_store_disable ) {
				return listar_user_has_package_with_store( $user_id );
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'listar_count_store_products_allowed' ) ) :	
	function listar_count_store_products_allowed( $user_id = 0 ) {
		$fallback = (string) get_option( 'listar_limit_products_per_vendor' );
		$fallback_str = strval( $fallback );
		$fallback_int = (int) $fallback;

		if ( empty( $fallback_str ) && '0' !== $fallback_str && '-1' !== $fallback_str ) {
			$fallback = 36;
		} else {
			$fallback = $fallback_int;
		}

		return $fallback;
	}
endif;

if ( ! function_exists( 'listar_count_disk_store_allowed' ) ) :	
	function listar_count_disk_store_allowed() {
		$fallback = (string) get_option( 'listar_limit_disk_per_vendor' );
		$fallback_str = strval( $fallback );
		$fallback_int = (int) $fallback;

		if ( empty( $fallback_str ) && '0' !== $fallback_str && '-1' !== $fallback_str ) {
			$fallback = 500;
		} else {
			$fallback = $fallback_int;
		}

		return $fallback;
	}
endif;

function listar_close_section() {
	session_write_close();
}

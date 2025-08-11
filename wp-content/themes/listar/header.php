<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listar
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		
		
		<link rel="shortcut icon"type="image/x-icon" href="data:image/x-icon;,">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="profile" href="<?php echo esc_url( listar_get_site_url_protocol( 'gmpg.org/xfn/11' ) ); ?>">

		<?php wp_head(); ?>
	</head>

	<!-- itemscope and itentype for W3C validation -->

	<body <?php body_class(); ?>>

		<?php
	
		/* Don't load nothing for front end market place dashboard */
		if ( ! listar_is_wcfm_dashboard() ) :
		
			/* Are the Explore By options active? */
			$search_by_active = listar_addons_active() ? listar_is_search_by_options_active() : false;
		
			$show_listing_card_geolocation_button = listar_addons_active() && 1 !== (int) get_option( 'listar_listing_card_geolocation_button_disable' );

			/* Enable loading overlay */
			$enable_loading_overlay = listar_is_loading_overlay_active();
			
			/* Get current user thumbnail */

			if ( is_user_logged_in() ) :
				$listar_user_thumbnail = listar_user_thumbnail( get_current_user_id() );
				$listar_bg_image = empty( $listar_user_thumbnail ) ? '' : listar_custom_esc_url( $listar_user_thumbnail );

				if ( ! empty( $listar_bg_image ) ) :
					?>
					<div class="hidden listar-user-thumbnail-background-image" data-user-thumbnail-image="<?php echo esc_attr( $listar_bg_image ); ?>"></div>
					<?php
				endif;
			endif;


			if ( $enable_loading_overlay ) :
				?>
				<!-- Start Loading -->
				<div class="listar-loading-holder">
					<div class="listar-loading">
						<div class="listar-loading-ring">
							<div class="listar-loading-ball-holder">
								<div class="listar-loading-ball"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Loading -->
				<?php
			endif;

			if ( is_singular( 'job_listing' ) && class_exists( 'WC_Bookings' ) ) :
				global $post;
				
				$use_appointment = 1 === (int) get_post_meta( $post->ID, '_job_business_use_booking', true );
				$is_booking_appointment_method = 'booking' === get_post_meta( $post->ID, '_job_business_booking_method', true );
				
				if ( $use_appointment && $is_booking_appointment_method ) {
					get_template_part( 'template-parts/directory-parts/single-listing-parts/listing-bookings', 'popup' );
				}
			endif;

			get_template_part( 'template-parts/login-register', 'popup' );

			if ( $search_by_active || $show_listing_card_geolocation_button ) {
				get_template_part( 'template-parts/directory-parts/listings-search-by', 'popup' );
			}

			$complaint_reports_enabled = 1 === (int) get_option( 'listar_complaint_reports_disable' ) ? false : true;

			if ( $complaint_reports_enabled && is_singular( 'job_listing' ) ) {
				get_template_part( 'template-parts/directory-parts/single-listing-parts/listing-report', 'popup' );
			}

			$claim_enabled = listar_is_claim_enabled();

			if ( $claim_enabled ) {
				get_template_part( 'template-parts/directory-parts/single-listing-parts/listing-claim', 'popup' );
			}

			listar_search_is_inside_popup( true );
			get_template_part( 'template-parts/directory-parts/listings-search', 'popup' );
			listar_search_is_inside_popup( false );
			get_template_part( 'template-parts/directory-parts/listings-categories', 'popup' );
			get_template_part( 'template-parts/directory-parts/listings-regions', 'popup' );

			/* Social Sharing Popup - Requires Listar Addons plugin */
			do_action( 'listar_social_share_popup' );
			?>

			<!-- Start Site Content Wrapper -->
			<div id="page" class="hfeed site">

				<?php get_template_part( 'template-parts/header', 'topbar' ); ?>

				<div class="listar-back-to-top icon-arrow-up listar-hidden-fixed-button"></div>

				<!-- Start Site Content -->
				<div id="content" class="site-content">

					<?php
					get_template_part( 'template-parts/page', 'header' );
		endif;

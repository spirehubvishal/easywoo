<?php
/**
 * Template part for displaying header/cover area of pages/archive/single in general
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $wp_query;

get_header();

$listar_current_post_id           = get_the_ID();
$listar_listing_package_id        = listar_addons_active() && is_singular( array( 'job_listing' ) ) ? get_post_meta( $listar_current_post_id, '_package_id', true ) : 0;
$disabled_package_options         = listar_addons_active() && is_singular( array( 'job_listing' ) ) && ! empty( $listar_listing_package_id ) ? listar_get_package_options_disabled( $listar_listing_package_id ) : array();
$listar_page_intro                = '';
$listar_cover_image               = '';
$listar_cover_color               = 'listar-no-image'; /* CSS class to set white background as default */
$listar_listing_subtitle          = get_post_meta( $listar_current_post_id, '_job_listing_subtitle', true );
$listar_page_content              = isset( $post->post_content ) ? $post->post_content : '';
$listar_query_obj                 = get_queried_object();
$listar_current_taxonomy          = isset( $listar_query_obj->taxonomy ) ? $listar_query_obj->taxonomy : '';
$listar_search_type               = isset( $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'search_type' ) ] : '';
$listar_search_post_type          = isset( $wp_query->query['post_type'] ) ? $wp_query->query['post_type'] : '';
$listar_is_listing_search         = listar_is_search() && ( 'listing' === $listar_search_type || 'job_listing' === $listar_search_post_type ) ? true : false;
$listar_is_listing_page           = isset( $wp_query->query_vars['is_listing_page'] ) ? true : false;
$listar_is_blog_page              = isset( $wp_query->is_posts_page ) ? (bool) $wp_query->is_posts_page : false;
$listar_posts_count               = listar_count_found_posts();
$listar_header_image              = get_header_image();
$listar_fallback_cover_image      = ! empty( $listar_header_image ) ? $listar_header_image : '';
$listar_current_post_type         = '';
$listar_term_id                   = isset( $listar_query_obj->term_id ) ? $listar_query_obj->term_id : '';
$listar_term_name                 = isset( $listar_query_obj->name ) ? $listar_query_obj->name : '';
$listar_disable_private_messages  = (int) get_option( 'listar_disable_private_message' );
$map_enabled                      = listar_is_map_enabled();
$map_enabled_archive              = listar_is_map_enabled( 'archive' );
$map_directions_enabled           = listar_is_map_enabled( 'directions' );
$map_gps_enabled                  = listar_is_map_enabled( 'gps' );
$map_enabled_single               = listar_is_map_enabled( 'single' ) && ! isset( $disabled_package_options['listar_disable_map'] );
$listar_category_terms            = '';
$listar_region_terms              = '';
$listar_count_category_terms      = 0;
$listar_count_region_terms        = 0;
$listar_post_status               = false;

if ( ! empty( $listar_current_post_id ) ) {
	$listar_current_post_type = get_post_type( $listar_current_post_id );
}

if ( empty( $listar_current_taxonomy ) ) {
	$listar_taxonomy         = get_query_var( 'taxonomy' );
	$listar_current_taxonomy = isset( $listar_taxonomy->name ) ? $listar_taxonomy->name : '';
}

if ( empty( $listar_current_post_type ) ) {
	$listar_current_post_type = isset( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : '';
}

if ( empty( $listar_current_post_type ) ) {
	$listar_taxonomy = get_taxonomy( $listar_current_taxonomy );
	$listar_current_post_type = isset( $listar_taxonomy->object_type ) ? $listar_taxonomy->object_type : '';
}

if ( is_array( $listar_current_post_type ) ) {
	/* If $listar_current_post_type is array, get first post type */
	$listar_current_post_type = isset( $listar_current_post_type[0] ) ? $listar_current_post_type[0] : '';
}

if ( is_singular( array( 'post', 'job_listing' ) ) && ! empty( $listar_current_post_id ) ) {
	listar_increment_post_meta_field( get_the_ID() );
}

if ( listar_is_front_page_template() ) {
	/**
	 * Cover to front page (Hero Header) ***********************************
	 */
	if ( post_type_exists( 'job_listing' ) ) :
		?>
		<!-- Start Front Page Hero Header -->
		<header class="listar-hero-header listar-front-header listar-transparent-design">
			<?php
			/* Get hero image from Theme Options or default WordPress header image */
			global $post;

			$listar_hero_image = ! empty( $post->ID ) ? get_the_post_thumbnail_url( $post->ID, 'listar-cover' ) : '';
			$listar_hero_image_mobile = ! empty( $post->ID ) ? get_the_post_thumbnail_url( $post->ID, listar_mobile_hero_image_size() ) : '';
			$type = false;
			$start_time = '';
			$end_time = '';

			$listar_cover_video = ! empty( $post->ID ) ? strval( get_post_meta( $post->ID, 'listar_meta_box_cover_video_url', true ) ) : '';

			if ( false !== strpos( strtolower( $listar_cover_video ), 'youtube.' ) ) {
				$type = 'video/youtube';
				https://youtu.be/Gum0tOEgAH8

				if ( false !== strpos( $listar_cover_video, '//youtu.be/' ) ) {
					$temp = explode( '//youtu.be/', $listar_cover_video  );
					$listar_cover_video = preg_replace('/\D/', '', $temp[1] );

					if ( ! empty( $listar_cover_video ) ) {
						$listar_cover_video = 'https://www.youtube.com/watch?v=' . $listar_cover_video;
					}
				}

			} else if ( false !== strpos( strtolower( $listar_cover_video ), 'vimeo.' ) ) {
				$type = 'video/vimeo';

				if ( false !== strpos( $listar_cover_video, '//vimeo.com/' ) ) {
					$temp = explode( '//vimeo.com/', $listar_cover_video  );
					$listar_cover_video = preg_replace('/\D/', '', $temp[1] );

					if ( ! empty( $listar_cover_video ) ) {
						$listar_cover_video = 'https://player.vimeo.com/video/' . $listar_cover_video;
					}
				}
			} else  if ( false !== strpos( strtolower( $listar_cover_video ), '.mp4' ) ) {
				$type = 'video/mp4';
			}

			if ( ! empty( $type ) && ! empty( $listar_cover_video ) ) {
				$start_time = (int) get_post_meta( $post->ID, 'listar_meta_box_cover_video_start', true );
				$end_time = (int) get_post_meta( $post->ID, 'listar_meta_box_cover_video_end', true );
			}
			?>

			<div class="listar-hero-image-desktop-preload hidden"></div>
			<div class="listar-hero-image-mobile-preload hidden"></div>
			<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_hero_image ) ); ?>" data-background-image-mobile="<?php echo esc_attr( listar_custom_esc_url( $listar_hero_image_mobile ) ); ?>"></div>

			<?php
			if ( ! empty( $type ) && ! empty( $listar_cover_video ) ) :
				?>
				<div class="listar-hero-video">
					<div class="player">
						<video data-start-time="<?php echo esc_attr( $start_time ); ?>" data-end-time="<?php echo esc_attr( $end_time ); ?>" id="player1" width="640" height="360" preload="none" style="max-width: 100%" playsinline webkit-playsinline autoplay loop muted="muted">
							<source src="<?php echo esc_url( $listar_cover_video ); ?>" type="<?php echo esc_attr( $type ); ?>">
						</video>
					</div>
					
				</div>
				<?php
			endif;
			?>

			<?php
			$listar_disable_hero_search_categories_front = (int) get_option( 'listar_disable_hero_search_categories_front' );

			if( 0 === $listar_disable_hero_search_categories_front ) {
				get_template_part( 'template-parts/directory-parts/listings-header', 'categories' );
			}
			?>

			<!-- Start Header Centralizer -->
			<div class="listar-header-centralizer">
				<div class="listar-content-centralized">
					<div class="listar-hero-container">
						<?php get_template_part( 'template-parts/directory-parts/listings-search', 'form' ); ?>
					</div>
				</div>
			</div>
			<!-- End Header Centralizer -->

		</header>
		<!-- End Front Page Hero Header -->
		<?php
	endif;

} elseif ( ( 'page' === $listar_current_post_type && ! has_shortcode( $listar_page_content, 'jobs' ) ) || $listar_is_blog_page ) {
	/**
	 * Cover to pages ******************************************************
	 */

	$listar_current_post_id = $listar_is_blog_page ? get_option( 'page_for_posts' ) : $listar_current_post_id;

	if ( has_post_thumbnail( $listar_current_post_id ) ) :

		$listar_cover_image = wp_get_attachment_image_src( get_post_thumbnail_id( $listar_current_post_id ), 'listar-cover' );
		$listar_conditions  = false !== $listar_cover_image && isset( $listar_cover_image[0] ) && ! empty( $listar_cover_image[0] );

		if ( $listar_conditions ) {
			$listar_cover_image = $listar_cover_image[0];
		}

	endif;

	if ( empty( $listar_cover_image ) ) :
		$listar_cover_image = $listar_fallback_cover_image;
	endif;

	$listar_cover_image = empty( $listar_cover_image ) ? '0' : $listar_cover_image;
	?>

	<!-- Start Page Header -->
	<header class="listar-page-header <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_cover_image ) ); ?>" data-aos="fade-zoom-in">
		<div class="listar-page-header-content">
			<h1 class="listar-page-title">
				<?php
				$page_title = listar_is_claiming_listing() ? esc_html__( 'Claim Listing', 'listar' ) : get_the_title( $listar_current_post_id );
				echo wp_kses( $page_title, 'listar-basic-html' );
				?>
			</h1>

			<?php
			$listar_page_subtitle = get_post_meta( $listar_current_post_id, 'listar_meta_box_page_subtitle', true );

			if ( ! empty( $listar_page_subtitle ) ) :
				?>
				<h4 class="listar-page-subtitle">
					<?php echo esc_html( $listar_page_subtitle ); ?>
				</h4>
				<?php
			endif;

			if ( is_page( $listar_current_post_id ) ) :
				listar_edit_post_link();
			endif;
			?>

		</div>
	</header>
	<!-- End Page Header -->

	<?php
	$listar_page_intro = get_post_meta( $listar_current_post_id, 'listar_meta_box_page_intro', true );

	if ( ! empty( $listar_page_intro ) ) :
		?>
		<!-- Start Page Intro -->
		<div class="listar-container-wrapper listar-page-intro" data-aos="fade-zoom-in" data-aos-delay="500">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<?php echo esc_html( $listar_page_intro ); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Intro -->
		<?php
	endif;

} elseif ( is_single() && 'post' === $listar_current_post_type ) {
	/**
	 * Cover to single blog articles ***************************************
	 */

	$listar_category = get_the_category();
	$listar_category_id = isset( $listar_category[0]->term_id ) ? $listar_category[0]->term_id : 0;

	if ( has_post_thumbnail( $listar_current_post_id ) ) :
		$listar_cover_image = get_the_post_thumbnail_url( $listar_current_post_id, 'listar-cover' );
	endif;

	if ( empty( $listar_cover_image ) ) :
		$listar_cover_image = $listar_fallback_cover_image;
	endif;

	$listar_cover_image = empty( $listar_cover_image ) ? '0' : $listar_cover_image;
	?>

	<!-- Start Single Article Header -->
	<header class="listar-page-header <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_cover_image ) ); ?>" data-aos="fade-zoom-in">
		<div class="listar-page-header-content">

			<?php the_title( '<h1 class="listar-page-title">', '</h1>' ); ?>

			<div>
				<?php
				listar_posted_on();

				$listar_categories = wp_get_post_categories( $listar_current_post_id );

				if ( ! is_wp_error( $listar_categories ) ) :
					?>
					<div class="listar-single-post-header-categories">
						<?php
						foreach ( $listar_categories as $listar_cat_obj ) {
							$listar_category = get_category( $listar_cat_obj );
							?>
							<a class="listar-ribbon" href="<?php echo esc_url( get_category_link( $listar_category->cat_ID ) ); ?>">
								<?php echo esc_html( $listar_category->name ); ?>
							</a>
							<?php
						}
						?>
					</div>
					<?php
				endif;
				?>
			</div>

			<?php listar_edit_post_link(); ?>

		</div>
	</header>
	<!-- End Single Article Header -->

	<?php

} elseif ( is_single() && 'job_listing' === $listar_current_post_type ) {
	/**
	 * Cover to single listing *********************************************
	 */

	listar_static_current_listings( $listar_current_post_id );
	
	$listar_condition_has_business_hours = false;
	$listar_business_hours_output = false;
	$listar_post_status = get_post_status( $listar_current_post_id );
	$listar_post_status_by_role = 1 === (int) get_option( 'job_manager_hide_expired_content', 1 ) && ! ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) && 'expired' === $listar_post_status ? 'expired' : 'published';
	$booking_label = listar_get_booking_label( $listar_current_post_id );
	
	if ( 'expired' !== $listar_post_status_by_role ) :
		
		if ( listar_addons_active() && ! isset( $disabled_package_options['listar_operating_hours_disable'] ) ) {
			$listar_business_hours_output = listar_company_operation_hours_availability( $listar_current_post_id, true );
			$listar_condition_has_business_hours = ! empty( $listar_business_hours_output[0] && ! empty( $listar_business_hours_output[2] ) );

			if ( $listar_condition_has_business_hours ) :
				$listar_output_status_class = 'listar-business-status-' . $listar_business_hours_output[0];
				$listar_output_icon_class = ! empty( $listar_business_hours_output[3] ) ? $listar_business_hours_output[3] : 'icon-alarm2';
				?>
				<div class="listar-operating-hours-quick-button-wrapper">
					<a href="#" class="listar-operating-hours-quick-button">
						<div class="listar-operating-hours-quick-button-inner">
							<?php echo wp_kses( $listar_business_hours_output[1], 'listar-basic-html' ); ?>
						</div>
					</a>
				</div>
				<?php
			endif;
		}
		
		$listing_booking_active = 1 === (int) get_post_meta( $listar_current_post_id, '_job_business_use_booking', true );
		$booking_appointment_method = get_post_meta( $post->ID, '_job_business_booking_method', true );
		$is_booking_appointment_method = 'booking' === $booking_appointment_method;
		$is_external_appointment_method = 'external' === $booking_appointment_method || empty( $booking_appointment_method );
		$booking_service = get_post_meta( $listar_current_post_id, '_job_business_bookings_third_party_service', true );
		$listar_booking_service_disable = (int) get_option( 'listar_appointments_disable' );

		if ( $listing_booking_active && ( $is_booking_appointment_method || ( $is_external_appointment_method && ! empty( $booking_service ) ) ) && ! isset( $disabled_package_options['listar_booking_service_disable'] ) && 0 === $listar_booking_service_disable ) {
			?>
			<div class="listar-booking-quick-button-wrapper hidden">
				<a href="#" class="listar-booking-quick-button">
					<div class="listar-booking-quick-button-inner">
						<div class="listar-open-or-closed listar-listing-open icon-alarm-add"><span><?php echo esc_html( $booking_label ); ?></span></div>
					</div>
				</a>
			</div>
			<?php
		}

		if ( listar_is_listing_trending( $listar_current_post_id ) ) :
			?>
			<a href="#" class="listar-trending-flag-single listar-trending-icon fal fa-bolt">
				<span>
					<?php esc_html_e( 'Trending', 'listar' ); ?>
				</span>
			</a>
			<?php
		endif;
		?>
		<div class="listar-toggle-fixed-quick-menu-wrapper listar-hidden-fixed-button">
			<a href="#" class="listar-toggle-fixed-quick-menu-button icon-ellipsis"></a>
		</div>
	
		<?php
		$bookmarks_active = listar_bookmarks_active();

		if ( $bookmarks_active ) :
			$listar_user_id = is_user_logged_in() ? get_current_user_id() : 0;
			$bookmarks_user_ids = ! empty( $listar_user_id ) ? listar_get_bookmarks_user_ids( $listar_current_post_id ) : '';
			$bookmarks_counter = listar_bookmarks_get_counter( $listar_current_post_id );
			$has_bookmarked_class = ! empty( $listar_user_id ) && in_array( $listar_user_id, $bookmarks_user_ids ) ? ' listar-bookmarked-item' : '';
			?>
			<div class="listar-bookmark-card-button-wrapper listar-bookmark-button-fixed">
				<div class="listar-bookmark-card-button <?php echo esc_attr( listar_sanitize_html_class( $has_bookmarked_class ) ); ?>">
					<a href="#" class="listar-bookmark-it icon-heart" data-listing-id="<?php echo esc_attr( $listar_current_post_id ); ?>" data-user-id="<?php echo esc_attr( $listar_user_id ); ?>"></a>
					<div class="listar-bookmark-counter" data-bookmark-counter="<?php echo esc_attr( $bookmarks_counter ); ?>">
						<?php echo esc_html( $bookmarks_counter ); ?>
					</div>
				</div>
			</div>
			<?php
		endif;
		?>

		<div class="listar-listing-header-topbar-wrapper">
			<div class="listar-listing-header-topbar-inner">
				<?php
				$listar_author = get_userdata( $post->post_author );
				$listar_author_id = isset( $listar_author->ID ) ? $listar_author->ID : '';
				$listar_author_become_vendor = listar_is_vendor( $listar_author_id );

				if ( $listar_author_become_vendor ) :
					$listar_vendor_authorized = listar_is_vendor_authorized( $listar_author_id );
					
					if ( $listar_vendor_authorized ) {
						$listar_count_products = wcfm_get_user_posts_count( $listar_author_id, 'product', 'publish' );
						$listar_shop_url = wcfmmp_get_store_url( $listar_author_id );

						if ( ! empty( $listar_count_products ) && ! empty( $listar_shop_url ) ) :
							?>
							<div class="listar-listing-header-topbar-item">
								<a href="<?php echo esc_url( $listar_shop_url ); ?>" class="listar-listing-header-online-store">
									<div class="listar-listing-header-topbar-icon-wrapper">
										<div class="listar-listing-header-topbar-icon icon-cart"></div>
									</div>
									<div class="listar-listing-header-topbar-item-label">
										<?php esc_html_e( 'Online Store', 'listar' ); ?>
									</div>
								</a>
							</div>
							<?php
						endif;
					}
				endif;
				?>
				<?php
				if ( $map_enabled && $map_directions_enabled && $map_enabled_single ) :
					?>
					<div class="listar-listing-header-topbar-item">
						<a href="#" rel="nofollow" target="_blank" class="listar-listing-header-directions-button">
							<div class="listar-listing-header-topbar-icon-wrapper">
								<div class="listar-listing-header-topbar-icon icon-compass2"></div>
							</div>
							<div class="listar-listing-header-topbar-item-label">
								<?php esc_html_e( 'Directions', 'listar' ); ?>
							</div>
						</a>
					</div>
					<?php
				endif;
				?>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-call-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-phone-outgoing"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Call', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-whatsapp-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-bubble"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'WhatsApp', 'listar' ); ?>
						</div>
					</a>
				</div>

				<?php
				$listar_disable_pvt_messages_listing = (bool) get_post_meta( $listar_current_post_id, '_job_disable_privatemessage', true );

				if ( ! ( 1 === $listar_disable_private_messages ) && ! ( $listar_disable_pvt_messages_listing ) && ! isset( $disabled_package_options['listar_disable_private_message'] ) ) :
					?>
					<div class="listar-listing-header-topbar-item">
						<a href="#" rel="nofollow" class="listar-listing-header-message-button">
							<div class="listar-listing-header-topbar-icon-wrapper">
								<div class="listar-listing-header-topbar-icon icon-at-sign"></div>
							</div>
							<div class="listar-listing-header-topbar-item-label">
								<?php esc_html_e( 'Message', 'listar' ); ?>
							</div>
						</a>
					</div>
					<?php
				endif;
				?>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-video-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-play-circle">
								<span class="listar-rating-count"></span>
							</div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Video', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-share-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-share2"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Share', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" target="_blank" class="listar-listing-header-website-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-link2"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Website', 'listar' ); ?>
						</div>
					</a>
				</div>

				<?php
				$listar_reviews_average = '';
				$listar_reviews_count   = '';

				if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) :
					$listar_reviews_average = listar_reviews_average( $listar_current_post_id );
					$listar_reviews_count   = (int) listar_reviews_count( $listar_current_post_id );

					if ( false !== $listar_reviews_average ) :
						?>
						<div class="listar-listing-header-topbar-item">
							<a href="#" class="listar-listing-rating-anchor" rel="nofollow">
								<div class="listar-listing-header-topbar-icon-wrapper">
									<div class="listar-listing-rating">
										<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
									</div>
									<span class="listar-rating-count">
										(<?php echo (int) $listar_reviews_count; ?>)
									</span>
								</div>
								<div class="listar-listing-header-topbar-item-label">
									<?php esc_html_e( 'Reviews', 'listar' ); ?>
								</div>
							</a>
						</div>
						<?php
					endif;
				endif;
				?>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-gallery-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-camera2">
								<span class="listar-rating-count"></span>
							</div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Gallery', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-catalog-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-notification"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Menu', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-hours-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-clock3"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Hours', 'listar' ); ?>
						</div>
					</a>
				</div>
				
				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-booking-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-alarm-add"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php echo esc_html( $booking_label ); ?>
						</div>
					</a>
				</div>

				<?php
				if ( $map_enabled && $map_gps_enabled ) :
					?>
					<div class="listar-listing-header-topbar-item">
						<a href="#" rel="nofollow" target="_blank" class="listar-listing-header-coordinates-button">
							<div class="listar-listing-header-topbar-icon-wrapper">
								<div class="listar-listing-header-topbar-icon icon-radar"></div>
							</div>
							<div class="listar-listing-header-topbar-item-label">
								<?php esc_html_e( 'GPS', 'listar' ); ?>
							</div>
						</a>
					</div>
					<?php
				endif;
				?>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-references-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-arrow-right-circle"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'References', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-copy-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-copy"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label" data-copy-text="<?php esc_attr_e( 'Copy Link', 'listar' ); ?>" data-copied-text="<?php esc_attr_e( 'Copied!', 'listar' ); ?>">
							<?php esc_html_e( 'Copy Link', 'listar' ); ?>
						</div>
					</a>
				</div>

				<div class="listar-listing-header-topbar-item">
					<a href="#" rel="nofollow" class="listar-listing-header-similar-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-zoom-in"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'Find Similar', 'listar' ); ?>
						</div>
					</a>
				</div>
				
				<?php
				$complaint_reports_enabled = 1 === (int) get_option( 'listar_complaint_reports_disable' ) ? false : true;
				
				if ( $complaint_reports_enabled ) :
					?>
					<div class="listar-listing-header-topbar-item">
						<a href="#" rel="nofollow" class="listar-listing-header-report-button <?php echo esc_attr( listar_sanitize_html_class( listar_report_complaint_css_class() ) ); ?>">
							<div class="listar-listing-header-topbar-icon-wrapper">
								<div class="listar-listing-header-topbar-icon icon-prohibited"></div>
							</div>
							<div class="listar-listing-header-topbar-item-label">
								<?php esc_html_e( 'Report', 'listar' ); ?>
							</div>
						</a>
					</div>
					<?php
				endif;
				?>

				<div class="listar-listing-header-topbar-item listar-listing-header-plus-button-wrapper">
					<a href="#" rel="nofollow" class="listar-listing-header-plus-button">
						<div class="listar-listing-header-topbar-icon-wrapper">
							<div class="listar-listing-header-topbar-icon icon-plus"></div>
						</div>
						<div class="listar-listing-header-topbar-item-label">
							<?php esc_html_e( 'More', 'listar' ); ?>
						</div>
					</a>
				</div>

			</div>
		</div>
	
		<?php
	endif;
	?>

	<!-- Start Page Header / Listing Title -->
	<header class="listar-listing-title listar-default-listing-title" data-aos="fade-zoom-in">
		<section class="listar-section">
			<div class="listar-container-wrapper" data-aos="fade-zoom-in" data-aos-delay="500">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center">
							<?php
							if ( taxonomy_exists( 'job_listing_category' ) && ! isset( $disabled_package_options['listar_disable_job_listing_category'] ) ) :
								$featured_category      = esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_category', true ) );
								$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
								$has_featured_category  = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;
																
								$listar_category_terms = get_the_terms( $listar_current_post_id, 'job_listing_category' );
								$temp_terms = $listar_category_terms;
								
								if ( $has_featured_category && isset( $listar_category_terms[0] ) && ! is_wp_error( $listar_category_terms ) && ! empty( $listar_category_terms ) ) {
									$temp_terms = array();
									
									foreach( $listar_category_terms as $listar_category_term ) {
										if ( isset( $listar_category_term->term_id ) ) {
											if ( (int) $listar_category_term->term_id === (int) $featured_category_term->term_id ) {
												array_unshift( $temp_terms, $listar_category_term );
											} else {
												$temp_terms[] = $listar_category_term;
											}
										}
									}		
								}
								
								if ( $temp_terms !== $listar_category_terms ) {
									$listar_category_terms = $temp_terms;
								}

								if ( ! isset( $listar_category_terms[0] ) || is_wp_error( $listar_category_terms ) ) {
									$listar_category_terms = false;
								} else {
									$listar_count_category_terms = is_array( $listar_category_terms ) ? count( $listar_category_terms ) : 0;
								}
							endif;

							if ( taxonomy_exists( 'job_listing_region' ) && ! isset( $disabled_package_options['listar_disable_job_listing_region'] ) ) :
								$allow_multiple_regions = 1 === (int) get_option( 'listar_allow_multiple_regions_frontend' );
								$featured_region        = $allow_multiple_regions ? esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_region', true ) ) : '';
								$featured_region_term   = ! empty( $featured_region ) ? get_term_by( 'id', $featured_region, 'job_listing_region' ) : false;
								$has_featured_region    = isset( $featured_region_term->term_id ) && isset( $featured_region_term->name ) ? $featured_region_term : false;
																
								$listar_region_terms = get_the_terms( $listar_current_post_id, 'job_listing_region' );
								$temp_terms = $listar_region_terms;
								
								if ( $has_featured_region && isset( $listar_region_terms[0] ) && ! is_wp_error( $listar_region_terms ) && ! empty( $listar_region_terms ) ) {
									$temp_terms = array();
									
									foreach( $listar_region_terms as $listar_region_term ) {
										if ( isset( $listar_region_term->term_id ) ) {
											if ( (int) $listar_region_term->term_id === (int) $featured_region_term->term_id ) {
												array_unshift( $temp_terms, $listar_region_term );
											} else {
												$temp_terms[] = $listar_region_term;
											}
										}
									}		
								}
								
								if ( $temp_terms !== $listar_region_terms ) {
									$listar_region_terms = $temp_terms;
								}

								if ( ! isset( $listar_region_terms[0] ) || is_wp_error( $listar_region_terms ) ) {
									$listar_region_terms = false;
								} else {
									$listar_count_region_terms = is_array( $listar_region_terms ) ? count( $listar_region_terms ) : 0;
								}
							endif;

							if ( ( ! empty( $listar_category_terms ) ) || ( ! empty( $listar_region_terms ) ) ) :
								?>
								<div class="listar-text-before-listing-title">
									<?php
									if ( ! empty( $listar_category_terms ) ) :
										foreach( $listar_category_terms as $listar_category_term ) :
											$listar_category_id    = '';
											$listar_category_name  = '';
											$listar_category_link  = '';
											$listar_category_color = '';
											
											if ( isset( $listar_category_term->term_id ) ) {
												$listar_category_id    = $listar_category_term->term_id;
												$listar_category_link  = get_term_link( $listar_category_term, 'job_listing_category' );
												$listar_category_color = listar_term_color( $listar_category_id );
											}

											if ( isset( $listar_category_term->name ) ) {
												$listar_category_name = $listar_category_term->name;
											}

											if ( ! empty( $listar_category_link ) && ! empty( $listar_category_name ) ) :
												?>
												<a class="listar-term-text listar-ribbon" href="<?php echo esc_url( $listar_category_link ); ?>" style="background-color:rgb(<?php echo esc_attr( $listar_category_color ); ?>); border-top-color:rgb(<?php echo esc_attr( $listar_category_color ); ?>); border-bottom-color:rgb(<?php echo esc_attr( $listar_category_color ); ?>);">
													<?php echo esc_html( $listar_category_name ); ?>
												</a>
											<?php
											endif;
										endforeach;
									endif;
									
									if ( ( $listar_count_category_terms !== 0 && $listar_count_region_terms > 1 ) || ( $listar_count_region_terms !== 0 && $listar_count_category_terms > 1 ) ) :
										?>
										<div></div>
										<?php
									endif;

									if ( ! empty( $listar_region_terms ) ) :
										foreach( $listar_region_terms as $listar_region_term ) :
											$listar_region_id    = '';
											$listar_region_name  = '';
											$listar_region_link  = '';
											$listar_region_color = '';
											
											if ( isset( $listar_region_term->term_id ) ) {
												$listar_region_id    = $listar_region_term->term_id;
												$listar_region_link  = get_term_link( $listar_region_term, 'job_listing_region' );
												$listar_region_color = listar_term_color( $listar_region_id );
											}

											if ( isset( $listar_region_term->name ) ) {
												$listar_region_name = $listar_region_term->name;
											}

											if ( ! empty( $listar_region_link ) && ! empty( $listar_region_name ) ) :
												?>
												<a class="listar-term-text listar-ribbon test3" href="<?php echo esc_url( $listar_region_link ); ?>" style="background-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>); border-top-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>); border-bottom-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>);">
													<?php echo esc_html( $listar_region_name ); ?>
												</a>
											<?php
											endif;
										endforeach;
									endif;
									?>
								</div>
								<?php
							endif;
							?>

							<h1>
								<?php the_title(); ?>
							</h1>

							<?php
							if ( ! empty( $listar_listing_subtitle ) && ! isset( $disabled_package_options['listar_disable_job_listing_subtitle'] ) ) :
								?>
								<h5 class="listar-text-after-listing-title">
									<span>
										<?php echo esc_html( $listar_listing_subtitle ); ?>
									</span>
								</h5>
								<?php
							endif;
							?>

							<?php listar_views_counter_output( 'listar-view-counter-fallback' ); ?>

							<?php listar_edit_post_link( true ); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</header>
	<!-- End Page Header / Listing Title -->

	<?php

} elseif ( true === $listar_is_listing_page ) {
	/**
	 * Cover to 'Listings' page (from WP Job Manager) **********************
	 */

	$listar_map_button_disabled = $listar_posts_count > 0 ? '' : 'disabled';
	
	if ( $map_enabled && $map_enabled_archive ) :
		?>
		<!-- Start Page Header / Map Listing -->
		<header class="listar-page-header listar-map-listing listar-map-hidden <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-aos="fade-zoom-in">
			<div class="listar-page-header-content listar-page-header-with-map">
				<div class="listar-map-button <?php echo esc_attr( listar_sanitize_html_class( $listar_map_button_disabled ) ); ?>">
					<div class="listar-map-button-text">
						<span class="icon-map2">
							<?php
							if ( $listar_posts_count > 0 ) :
								esc_html_e( 'Launch Map', 'listar' );
							endif;
							?>
						</span>
					</div>
				</div>
			</div>
			<div id="map" class="listar-map">
				<div class="listar-back-listing-button icon-arrow-left">
					<?php esc_html_e( 'Listing View', 'listar' ); ?>
				</div>
			</div>
			<div class="listar-aside-list"></div>
		</header>
		<!-- End Page Header / Map Listing -->
		<?php
	endif;

	if ( ! empty( $listar_page_intro ) ) :
		?>
		<!-- Start Page Intro -->
		<div class="listar-container-wrapper listar-page-intro" data-aos="fade-zoom-in" data-aos-delay="500">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<?php echo esc_html( $listar_page_intro ); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Intro -->
		<?php
	endif;

} elseif ( is_archive() || listar_is_search() || is_home() ) {
	/**
	 * Cover to archive, search, tags, categories, etc *********************
	 */

	/* Listing search, listing category, regions, amenities ***************/

	if ( 'job_listing' === $listar_current_post_type || $listar_is_listing_search ) {
		$listar_map_button_disabled = $listar_posts_count > 0 ? '' : 'disabled';
		
		if ( $map_enabled && $map_enabled_archive ) :
			?>
			<!-- Start Page Header / Map Listing -->
			<header class="listar-page-header listar-map-listing listar-map-hidden <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-aos="fade-zoom-in">
				<div class="listar-page-header-content listar-page-header-with-map">
					<div class="listar-map-button <?php echo esc_attr( listar_sanitize_html_class( $listar_map_button_disabled ) ); ?>">
						<div class="listar-map-button-text">
							<span class="icon-map2">
								<?php
								if ( $listar_posts_count > 0 ) :
									esc_html_e( 'Launch Map', 'listar' );
								endif;
								?>
							</span>
						</div>
					</div>
				</div>
				<div id="map" class="listar-map">
					<div class="listar-back-listing-button icon-arrow-left">
						<?php esc_html_e( 'Listing View', 'listar' ); ?>
					</div>
				</div>
				<div class="listar-aside-list"></div>
			</header>
			<!-- End Page Header / Map Listing -->
			<?php
		endif;
		
		/**
		 * Cover to archive, search, tags, categories, etc *************
		 */

		/* Woocommerce shop page, archive, single *******************/

	} elseif ( 'product' === $listar_current_post_type ) {

		$listar_shop_page_id = wc_get_page_id( 'shop' );
		$listar_page_intro   = get_post_meta( $listar_shop_page_id, 'listar_meta_box_page_intro', true );

		if ( has_post_thumbnail( $listar_shop_page_id ) ) :
			$listar_cover_image = get_the_post_thumbnail_url( $listar_shop_page_id, 'listar-cover' );
		endif;

		if ( empty( $listar_cover_image ) ) :
			$listar_cover_image = $listar_fallback_cover_image;
		endif;

		$listar_cover_image = empty( $listar_cover_image ) ? '0' : $listar_cover_image;
		?>

		<!-- Start Page Header  -->
		<header class="listar-page-header <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_cover_image ) ); ?>" data-aos="fade-zoom-in">
			<div class="breadcrumbs text-left"></div>
			<div class="listar-page-header-content">

				<?php
				if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
					?>
					<h1 class="listar-page-title">
						<?php woocommerce_page_title(); ?>
					</h1>
					<?php
				endif;

				$listar_page_subtitle = get_post_meta( $listar_shop_page_id, 'listar_meta_box_page_subtitle', true );

				if ( ! empty( $listar_page_subtitle ) ) :
					?>
					<h4 class="listar-page-subtitle">
						<?php echo esc_html( $listar_page_subtitle ); ?>
					</h4>
					<?php
				endif;

				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
				?>

			</div>
		</header>
		<!-- End Page Header -->

		<?php
		if ( ! empty( $listar_page_intro ) ) :
			?>
			<div class="listar-container-wrapper listar-page-intro" data-aos="fade-zoom-in" data-aos-delay="500">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<?php echo esc_html( $listar_page_intro ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		endif;

		/* General / default / blog *******************/

	} else {
		if ( 'job_listing' !== $listar_current_post_type && ! $listar_is_listing_search ) :
			$listar_archive_title = get_the_archive_title();

			if ( ! empty( $listar_archive_title ) ) :
				if ( is_category() ) :
					$listar_category_id          = get_query_var( 'cat' );
					$listar_category_name        = get_cat_name( $listar_category_id );
					$listar_category_description = category_description( $listar_category_id );
					$listar_cover_image          = listar_term_image( $listar_category_id, 'category', 'listar-cover' );
				elseif ( is_home() ) :
					if ( empty( $listar_cover_image ) && 'page' === get_option( 'show_on_front' ) ) :
						$listar_current_post_id = get_option( 'page_for_posts' );
						$listar_cover_image = listar_image_url( get_post_thumbnail_id( $listar_current_post_id ), 'listar-cover' );
					endif;
				endif;

				if ( empty( $listar_cover_image ) ) :
					$listar_cover_image = listar_image_url( get_option( 'listar_blog_search_page_cover_image' ), 'listar-cover' );
				endif;

				if ( empty( $listar_cover_image ) ) :
					$listar_cover_image = $listar_fallback_cover_image;
				endif;

				$listar_cover = empty( $listar_cover_image ) ? '0' : $listar_cover_image;
				?>

				<!-- Start Page Header -->
				<header class="listar-page-header <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_cover ) ); ?>" data-aos="fade-zoom-in">
					<div class="listar-page-header-content">
						<h1 class="listar-page-title">
							<?php
							if ( listar_is_search() ) :
								printf(
									/* TRANSLATORS: %s: Current search query, example: Food */
									esc_html__( 'Search: %s', 'listar' ),
									'<span>' . listar_get_search_query() . '</span>'
								);
							elseif ( is_category() ) :
								echo esc_html( $listar_category_name );
							elseif ( is_home() ) :
								$listar_page_id    = get_option( 'page_for_posts' );
								$listar_page_title = $listar_page_id ? get_the_title( $listar_page_id ) : esc_html__( 'Blog', 'listar' );
								echo wp_kses( $listar_page_title, 'listar-basic-html' );
							elseif ( ! empty( $listar_term_id ) && ! empty( $listar_term_name ) ) :
								/* It is a custom taxonomy term */
								echo wp_kses( $listar_term_name, 'listar-basic-html' );
							else :
								the_archive_title();
							endif;
							?>

						</h1>

						<?php
						if ( is_category() ) :
							if ( ! empty( $listar_category_description ) ) :
								?>
								<h4 class="listar-page-subtitle">
									<?php echo esc_html( wp_strip_all_tags( $listar_category_description ) ); ?>
								</h4>
								<?php
							endif;
						endif;
						?>
					</div>
				</header>
				<!-- End Page Header -->
				<?php
			endif;
		endif;
	}
} elseif ( is_404() ) {
	/**
	 * Cover to 404 page ***************************************************
	 */

	$listar_cover_image = listar_image_url( get_option( 'listar_page_404_cover_image' ), 'listar-cover' );

	if ( empty( $listar_cover_image ) ) :
		$listar_cover_image = $listar_fallback_cover_image;
	endif;

	$listar_cover = empty( $listar_cover_image ) ? '0' : $listar_cover_image;
	?>

	<!-- Start Page Header -->
	<header class="listar-page-header <?php echo esc_attr( listar_sanitize_html_class( $listar_cover_color ) ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_cover ) ); ?>" data-aos="fade-zoom-in">
		<div class="listar-page-header-content">
			<h1 class="listar-page-title">
				<?php echo '404'; ?>
			</h1>
			<h4 class="listar-page-subtitle">
				<?php esc_html_e( "Oops! That page doesn't exist.", 'listar' ); ?>
			</h4>
		</div>
	</header>
	<?php
}

/* Some images for JavaScript manipulation */

if ( is_single() ) :

	/* Get rating popup background image from Theme Options or default WordPress header image */

	$listar_ratings_background_image = listar_image_url( get_option( 'listar_ratings_background_image' ), 'listar-cover' );

	if ( empty( $listar_ratings_background_image ) ) {
		$listar_header_image = get_header_image();
		$listar_ratings_background_image = ! empty( $listar_header_image ) ? $listar_header_image : '';
	}

	$listar_bg_image = empty( $listar_ratings_background_image ) ? '' : listar_custom_esc_url( $listar_ratings_background_image );

	if ( ! empty( $listar_bg_image ) ) :
		?>
		<div class="hidden listar-data-review-popup-background-image" data-review-popup-background-image="<?php echo esc_attr( $listar_bg_image ); ?>"></div>
		<?php
	endif;

endif;


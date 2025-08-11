<?php
/**
 * Return listing card content with Ajax.
 *
 * @package Listar
 */

$listar_wp_load_file_path = '../../../../wp-load.php';
require_once $listar_wp_load_file_path;

$ajax_data = filter_input( INPUT_POST, 'send_data' );
$return_data = array();
$obj = '';
$origin = '';
$listar_data_type = '';
$listar_listing_id = '';
$current_explore_by_type = listar_current_explore_by_session();

// Is the request coming from same domain?

if ( array_key_exists( 'HTTP_ORIGIN', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_ORIGIN'];
} elseif ( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

if ( ! empty( $origin ) && false !== strpos( $origin, '://' ) ) {
	$temp = explode( '://', $origin );
	$origin = $temp[1];

	if ( ! empty( $origin ) ) {
		$site_url = network_site_url();
		
		if ( false === strpos( $site_url, $origin ) ) {
			listar_close_section();
			die();
		}
	} else {
		listar_close_section();
		die();
	}
} else {
	listar_close_section();
	die();
}

if( ! empty( $ajax_data ) ) {
	$obj = json_decode( wp_unslash( $ajax_data ) );
} else {
	listar_close_section();
	die();
}

if ( empty( $obj ) ) :
	listar_close_section();
	die();
endif;

foreach ( $obj as $item ) {
	foreach ( $item as $key => $data ) {
		
		if ( 'type' === $key ) {
			$listar_data_type = $data;
		} 
		
		if ( 'id' === $key ) {
			$listar_listing_id = $data;
		}
		
		if ( 'listing-content' === $listar_data_type && ! empty( $listar_listing_id ) ) {
			$listar_current_post_id            = $listar_listing_id;
			$post                              = get_post( $listar_listing_id );
			$listar_category_name              = '';
			$listar_category_link              = '';
			$listar_category_icon              = '';
			$listar_category_color             = '';
			$listar_post_image                 = get_the_post_thumbnail_url( $listar_current_post_id, 'large' );
			$listar_fallback_card_image        = listar_image_url( get_option( 'listar_listing_card_fallback_image' ), 'large' );
			$listar_temp_bg_image              = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
			$listar_bg_image                   = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;
			$listar_listing_id                 = 'listing-' . $listar_current_post_id;
			$listar_reviews_average            = listar_reviews_average( $listar_current_post_id );
			$listar_address                    = listar_get_listing_address( $listar_current_post_id );
			$listar_has_address                = ! empty( $listar_address );
			$listar_logo_disable               = (int) get_option( 'listar_logo_disable' );
			$listar_listing_logo               = 0 === $listar_logo_disable ? esc_url( get_post_meta( $listar_current_post_id, '_company_logotype', true ) ) : '';
			$listar_fallback_card_description  = get_option( 'listar_fallback_listing_card_description' );
			$listar_listing_title              = listar_excerpt_limit( get_the_title( $listar_current_post_id ), 80, false, '', true );
			$listar_blank_placeholder          = listar_blank_base64_placeholder_image();
			$listar_region_id                  = '';
			$listar_region_name                = '';
			$listar_region_link                = '';
			$listar_lat                        = esc_html( get_post_meta( $listar_current_post_id, 'geolocation_lat', true ) );
			$listar_lng                        = esc_html( get_post_meta( $listar_current_post_id, 'geolocation_long', true ) );
			$listar_force_lat                  = esc_html( get_post_meta( $listar_current_post_id, '_job_customlatitude', true ) );
			$listar_force_lng                  = esc_html( get_post_meta( $listar_current_post_id, '_job_customlongitude', true ) );
			$listar_distance_metering          = array();
			$listar_featured_temp              = get_post_meta( $listar_current_post_id, '_featured', true ) ? true : false;
			$listar_featured                   = $listar_featured_temp ? 'listar-featured-listing' : '';
			$listing_card_design               = get_option( 'listar_listing_card_design' );
			$listar_cards_design_class         = 'rounded-image-block' === $listing_card_design || 'squared-image-block' === $listing_card_design ? 'listar-grid-design-image-block' : '';

			if ( 'squared-image-block' === $listing_card_design ) {
				$listar_cards_design_class .= ' listar-squared-details';
			}

			if ( empty( $listar_lat ) || ! empty( $listar_force_lat )  ) {
				$listar_lat = $listar_force_lat;
			}

			if ( empty( $listar_lng ) || ! empty( $listar_force_lng )  ) {
				$listar_lng = $listar_force_lng;
			}
			
			if ( taxonomy_exists( 'job_listing_category' ) ) :
				$featured_category = esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_category', true ) );
				$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
				$has_featured_category = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;

				$listar_category_id    = $has_featured_category ? $featured_category_term->term_id : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'id' );
				$listar_category_name  = $has_featured_category ? $featured_category_term->name : listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'name' );
				$listar_category_link  = $has_featured_category ? get_term_link( $featured_category_term ): listar_first_term_data( $listar_current_post_id, 'job_listing_category', 'link' );
				$listar_category_icon  = listar_icon_class( listar_term_icon_from_post( $listar_current_post_id, 'job_listing_category', $has_featured_category ) );
				$listar_category_color = listar_term_color( $listar_category_id );
			endif;
			
			if ( taxonomy_exists( 'job_listing_region' ) ) :
				$allow_multiple_regions = 1 === (int) get_option( 'listar_allow_multiple_regions_frontend' );
				$featured_region        = $allow_multiple_regions ? esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_region', true ) ) : '';
				$featured_region_term   = ! empty( $featured_region ) ? get_term_by( 'id', $featured_region, 'job_listing_region' ) : false;
				$has_featured_region    = isset( $featured_region_term->term_id ) && isset( $featured_region_term->name ) ? $featured_region_term : false;

				$listar_region_id    = $has_featured_region ? $featured_region_term->term_id : listar_first_term_data( $listar_current_post_id, 'job_listing_region', 'id' );
				$listar_region_name  = $has_featured_region ? $featured_region_term->name : listar_first_term_data( $listar_current_post_id, 'job_listing_region', 'name' );
				$listar_region_link  = $has_featured_region ? get_term_link( $featured_region_term ): listar_first_term_data( $listar_current_post_id, 'job_listing_region', 'link' );
				$listar_region_color = listar_term_color( $listar_region_id );
			endif;

			if ( ! empty( $listar_lat ) && ! empty( $listar_lng ) ) {
				$listar_distance_metering = listar_get_listing_distance_metering( $listar_lat, $listar_lng, $listar_region_id );
			}

			if ( empty( $listar_fallback_card_description ) ) {
				$listar_fallback_card_description = esc_html__( 'No description available by now. Please, click to verify more detailed info about this listing, like photos, operating hours, and so on.', 'listar' );
			}
			?>

			<?php
			if ( 'rounded-image-block' === $listing_card_design || 'squared-image-block' === $listing_card_design ) :
				?>
				<div class="listar-card-design-image-block"></div>
	
				<?php
				$show_geolocation_button = listar_addons_active() && 1 !== (int) get_option( 'listar_listing_card_geolocation_button_disable' ) && ! listar_user_got_geolocated();

				if ( $show_geolocation_button && ! empty( $listar_lat ) && ! empty( $listar_lng ) ) :
					?>
					<a href="#" title="<?php esc_html_e( 'Is it Near Me?', 'listar' ); ?>" class="listar-get-geolocated fa fa-scrubber" data-toggle="tooltip" data-placement="right"></a>
					<?php
				endif;
				?>
				
				<?php
				if (
					! empty( $listar_distance_metering ) &&
					isset( $listar_distance_metering[0]['distance'] ) &&
					! empty( $listar_distance_metering[0]['distance'] )
				) :
					$first_distance = $listar_distance_metering[0]['distance'];
					?>
					<div class="listar-card-geolocated-distance">
						<?php echo esc_html( $first_distance ); ?>
					</div>
					<?php
				endif;
				?>
				<a class="listar-card-link" href="<?php the_permalink(); ?>">
					<?php
					if ( listar_addons_active() ) {
						$listar_output_status = listar_company_operation_hours_availability( $listar_current_post_id );

						if ( ! empty( $listar_output_status[1] ) ) {
							echo wp_kses( $listar_output_status[1], 'listar-basic-html' );
						}
					}
					?>
				</a>
				<div class="listar-floating-card-icons">
					<?php
					if ( ( ! empty( $listar_category_icon[0] ) || ! empty( $listar_category_icon[1] ) && ! empty( $listar_category_link ) ) ) :
						?>
						<div class="listar-category-icon <?php echo esc_attr( listar_sanitize_html_class( $listar_category_icon[0] ) ); ?>" style="background-color:rgb(<?php echo esc_attr( $listar_category_color ); ?>);">
							<?php
							/**
							 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
							 * Please check the description for 'listar_icon_output' function in functions.php.
							 */
							listar_icon_output( $listar_category_icon[1] );
							?>
						</div>
						<?php
					endif;
					?>

					<?php
					$bookmarks_active = listar_bookmarks_active();

					if ( $bookmarks_active ) :
						$listar_user_id = is_user_logged_in() ? get_current_user_id() : 0;
						$bookmarks_user_ids = ! empty( $listar_user_id ) ? listar_get_bookmarks_user_ids( $listar_current_post_id ) : '';
						$bookmarks_counter = listar_bookmarks_get_counter( $listar_current_post_id );
						$has_bookmarked_class = ! empty( $listar_user_id ) && in_array( $listar_user_id, $bookmarks_user_ids ) ? ' listar-bookmarked-item' : '';
						?>
						<div class="listar-bookmark-card-button-wrapper">
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
					<?php
					if ( false !== $listar_reviews_average ) :
						?>
						<div class="listar-listing-rating">
							<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
						</div>
						<?php
					endif;
					?>
					<?php
					$claim_status = listar_listing_claim_status( $listar_current_post_id );
					$show_claim = 'claimed' === $claim_status;

					if ( $show_claim && listar_is_claim_enabled() ) :
						?>
						<div class="listar-claimed-icon"></div>
						<?php
					endif;
					?>
				</div>

				<?php
				if ( ! empty( $listar_listing_logo ) ) :
					?>
					<div class="listar-listing-logo-wrapper">
						<div class="listar-listing-logo" data-background-image="<?php echo esc_url( $listar_listing_logo ); ?>"></div>
					</div>
					<?php
				endif;
				?>

				<div class="listar-floating-card-icons-h">
					<?php if ( listar_is_listing_trending( $listar_current_post_id ) ) : ?>
						<a href="#" class="listar-trending-icon fal fa-bolt">
							<span>
								<?php esc_html_e( 'Trending', 'listar' ); ?>
							</span>
						</a>
					<?php endif; ?>
					<?php if ( $listar_featured_temp ) : ?>
						<div class="listar-featured-ribbon listar-featured-icon fal fa-ad"></div>
					<?php endif; ?>
				</div>

				<div class="listar-card-content-wrapper">
					<div>
						<h6 class="listar-card-content-title"><?php echo esc_html( $listar_listing_title ); ?></h6>

						<?php if ( $listar_has_address ) : ?>
							<address class="listar-listing-address"></address>
						<?php endif; ?>

						<div class="listar-card-excerpt">
							<?php
							$listar_excerpt = listar_excerpt_limit( $post, 400, true, $listar_fallback_card_description, false, 'only-dots', true );
							$listar_has_listing_term = ! empty( $listar_category_link ) && ! empty( $listar_category_name ) && ! empty( $listar_region_link ) && ! empty( $listar_region_name ) ? '' : 'listar-no-listing-term';
							echo wp_kses( $listar_excerpt, 'listar-basic-html' );
							?>
						</div>
					</div>
				</div>

				<div class="listar-card-content-image">
					<div class="listar-card-image-wrapper">
						<div class="listar-card-image-inner">
							<img data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>" alt="<?php the_title(); ?>" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" />
						</div>
					</div>
				</div>

				<div class="listar-distance-references">
					<?php
					if ( $listar_has_address ) {
						$temp = array(
							'label'    => $listar_address,
							'distance' => 'is_address',
						);

						array_unshift( $listar_distance_metering, $temp );
					}

					if (
						! empty( $listar_distance_metering ) &&
						isset( $listar_distance_metering[0]['distance'] ) &&
						! empty( $listar_distance_metering[0]['distance'] ) &&
						isset( $listar_distance_metering[0]['label'] ) &&
						! empty( $listar_distance_metering[0]['label'] )
					) :
						?>
						<div class="listar-references-distance-metering">
							<div class="listar-location-references-wrapper">
								<?php
								$count_distances = count( $listar_distance_metering );
								$valid_distances = 0;
								$first_elem = $listar_distance_metering[0];

								if ( 'is_address' === $first_elem['distance'] && ! empty( $first_elem['label'] ) ) :
									?>
									<div>
										<span class="fas fa-map-marker-alt"></span>
										<?php echo esc_html( $first_elem['label'] ); ?>
									</div>
									<?php
									array_shift( $listar_distance_metering );
									$count_distances = count( $listar_distance_metering );
									$valid_distances++;
								endif;

								for ( $i = 0; $i < $count_distances; $i++ ) {
									$distance = isset( $listar_distance_metering[ $i ]['distance'] ) && ! empty( $listar_distance_metering[ $i ]['distance'] ) ? $listar_distance_metering[ $i ]['distance'] : false;
									$label = isset( $listar_distance_metering[ $i ]['label'] ) && ! empty( $listar_distance_metering[ $i ]['label'] ) ? $listar_distance_metering[ $i ]['label'] : false;

									if ( ! empty( $distance ) && ! empty( $label ) ) {
									?>
									<div>
										<?php
										printf(
											/* TRANSLATORS: 1: distance in km, 2: label for a location or address */
											wp_kses( __( '%1$s from %2$s', 'listar' ), 'listar-basic-html' ),
											'<span>' . $distance . '</span>',
											$label
										)
										?>
									</div>
									<?php
									$valid_distances++;
									}
								}
								?>
							</div>
							<?php
							if ( $valid_distances > 1 ) {
								?>
								<span class="listar-references-navigation icon-chevron-right"></span>
								<?php
							}
							?>
						</div>
						<?php
					endif;
					?>
				</div>

				<div class="listar-card-footer">

					<div class="listar-card-category-name <?php echo esc_attr( listar_sanitize_html_class( $listar_has_listing_term ) ); ?>">
						<?php
						if ( ! empty( $listar_category_link ) && ! empty( $listar_category_name ) ) :
							?>
							<a href="<?php echo esc_url( $listar_category_link ); ?>">
								<?php echo esc_html( $listar_category_name ); ?>
							</a>
							<?php
						endif;
						?>
						<?php
						if ( ! empty( $listar_region_link ) && ! empty( $listar_region_name ) ) :
							?>
							<a href="<?php echo esc_url( $listar_region_link ); ?>">
								<?php echo esc_html( $listar_region_name ); ?>
							</a>
						<?php
						endif;
						?>
					</div>
				</div>
				<?php
			else :
				?>
	
				<?php
				$show_geolocation_button = listar_addons_active() && 1 !== (int) get_option( 'listar_listing_card_geolocation_button_disable' ) && ! listar_user_got_geolocated();

				if ( $show_geolocation_button && ! empty( $listar_lat ) && ! empty( $listar_lng ) ) :
					?>
					<a href="#" title="<?php esc_html_e( 'Is it Near Me?', 'listar' ); ?>" class="listar-get-geolocated fa fa-scrubber" data-toggle="tooltip" data-placement="right"></a>
					<?php
				endif;
				?>
				
				<?php
				if (
					! empty( $listar_distance_metering ) &&
					isset( $listar_distance_metering[0]['distance'] ) &&
					! empty( $listar_distance_metering[0]['distance'] )
				) :
					$first_distance = $listar_distance_metering[0]['distance'];
					?>
					<div class="listar-card-geolocated-distance">
						<?php echo esc_html( $first_distance ); ?>
					</div>
					<?php
				endif;
				?>
	
				<?php if ( listar_is_listing_trending( $listar_current_post_id ) ) : ?>
					<a href="#" class="listar-trending-icon fal fa-bolt">
						<span>
							<?php esc_html_e( 'Trending', 'listar' ); ?>
						</span>
					</a>
				<?php endif; ?>
				
				<a class="listar-card-link" href="<?php the_permalink( $listar_current_post_id ); ?>">
					<?php
					if ( listar_addons_active() ) {
						$listar_output_status = listar_company_operation_hours_availability( $listar_current_post_id );

						if ( ! empty( $listar_output_status[1] ) ) {
							echo wp_kses( $listar_output_status[1], 'listar-basic-html' );
						}
					}
					?>
				</a>

				<?php
				$bookmarks_active = listar_bookmarks_active_plugin();

				if ( $bookmarks_active ) :
					$listar_user_id = is_user_logged_in() ? get_current_user_id() : 0;
					$bookmarks_user_ids = ! empty( $listar_user_id ) ? listar_get_bookmarks_user_ids( $listar_current_post_id ) : '';
					$bookmarks_counter = listar_bookmarks_get_counter( $listar_current_post_id );
					$has_bookmarked_class = ! empty( $listar_user_id ) && in_array( $listar_user_id, $bookmarks_user_ids ) ? ' listar-bookmarked-item' : '';
					?>
					<div class="listar-bookmark-card-button-wrapper">
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

				<div class="listar-circular-wrapper">
					<?php
					if ( ( ! empty( $listar_category_icon[0] ) || ! empty( $listar_category_icon[1] ) && ! empty( $listar_category_link ) ) ) :
						?>
						<div class="listar-category-icon <?php echo esc_attr( listar_sanitize_html_class( $listar_category_icon[0] ) ); ?>" style="background-color:rgb(<?php echo esc_attr( $listar_category_color ); ?>);">
							<?php
							/**
							 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
							 * Please check the description for 'listar_icon_output' function in functions.php.
							 */
							listar_icon_output( $listar_category_icon[1] );
							?>
						</div>
						<?php
					endif;
					?>
					<?php
					if ( false !== $listar_reviews_average ) :
						?>
						<div class="listar-listing-rating">
							<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
						</div>
						<?php
					endif;
					?>
					<?php
					$claim_status = listar_listing_claim_status( $listar_current_post_id );
					$show_claim = 'claimed' === $claim_status;

					if ( $show_claim && listar_is_claim_enabled() ) :
						?>
						<div class="listar-claimed-icon"></div>
						<?php
					endif;
					?>
					<?php
					if ( ! empty( $listar_listing_logo ) ) :
						?>
						<div class="listar-listing-logo-wrapper">
							<div class="listar-listing-logo" data-background-image="<?php echo esc_url( $listar_listing_logo ); ?>"></div>
						</div>
						<?php
					endif;
					?>

					<div class="listar-card-content-image">
						<div class="listar-card-content-wrapper">
							<div class="listar-card-content-title-centralizer">
								<?php if ( $listar_featured_temp ) : ?>
									<div class="listar-featured-ribbon"><?php esc_html_e( 'Featured', 'listar' ); ?></div>
								<?php endif; ?>

								<h6 class="listar-card-content-title"><?php echo esc_html( $listar_listing_title ); ?></h6>
							</div>
						</div>
						<div class="listar-card-image-wrapper">
							<div class="listar-card-image-inner">
								<img data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>" alt="<?php the_title(); ?>" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" />
							</div>
						</div>
					</div>
				</div>

				<?php if ( $listar_has_address ) : ?>
					<div class="listar-card-data-arrow-before text-center"></div>
					<address class="listar-listing-address">
						<span>
							<?php echo wp_kses( $listar_address, 'strip' ); ?>
						</span>
					</address>
				<?php endif; ?>

				<div class="listar-card-content-data">
					<?php
					if ( $listar_has_address ) {
						$temp = array(
							'label'    => $listar_address,
							'distance' => 'is_address',
						);

						array_unshift( $listar_distance_metering, $temp );
					}

					if (
						! empty( $listar_distance_metering ) &&
						isset( $listar_distance_metering[0]['distance'] ) &&
						! empty( $listar_distance_metering[0]['distance'] ) &&
						isset( $listar_distance_metering[0]['label'] ) &&
						! empty( $listar_distance_metering[0]['label'] )
					) :
						$first_distance = $listar_distance_metering[0]['distance'];
						?>
						<div class="listar-references-distance-metering">
							<div class="listar-location-references-wrapper">
								<?php
								$count_distances = count( $listar_distance_metering );
								$valid_distances = 0;
								$first_elem = $listar_distance_metering[0];

								if ( 'is_address' === $first_elem['distance'] && ! empty( $first_elem['label'] ) ) :
									?>
									<div>
										<span class="fas fa-map-marker-alt"></span>
										<?php echo esc_html( $first_elem['label'] ); ?>
									</div>
									<?php
									array_shift( $listar_distance_metering );
									$count_distances = count( $listar_distance_metering );
									$valid_distances++;
								endif;

								for ( $i = 0; $i < $count_distances; $i++ ) {
									$distance = isset( $listar_distance_metering[ $i ]['distance'] ) && ! empty( $listar_distance_metering[ $i ]['distance'] ) ? $listar_distance_metering[ $i ]['distance'] : false;
									$label = isset( $listar_distance_metering[ $i ]['label'] ) && ! empty( $listar_distance_metering[ $i ]['label'] ) ? $listar_distance_metering[ $i ]['label'] : false;

									if ( ! empty( $distance ) && ! empty( $label ) ) {
									?>
									<div>
										<?php
										printf(
											/* TRANSLATORS: 1: distance in km, 2: label for a location or address */
											wp_kses( __( '%1$s from %2$s', 'listar' ), 'listar-basic-html' ),
											'<span>' . $distance . '</span>',
											$label
										)
										?>
									</div>
									<?php
									$valid_distances++;
									}
								}
								?>
							</div>
							<?php
							if ( $valid_distances > 1 ) {
								?>
								<span class="listar-references-navigation icon-chevron-right"></span>
								<?php
							}
							?>
						</div>
						<?php
					endif;
					?>
					<?php
					$listar_excerpt = listar_excerpt_limit( $post, 240, true, $listar_fallback_card_description );
					$listar_has_listing_term = ! empty( $listar_category_link ) && ! empty( $listar_category_name ) && ! empty( $listar_region_link ) && ! empty( $listar_region_name ) ? '' : 'listar-no-listing-term';
					echo wp_kses( $listar_excerpt, 'listar-basic-html' );
					?>

					<div class="listar-card-category-name <?php echo esc_attr( listar_sanitize_html_class( $listar_has_listing_term ) ); ?>">
						<?php
						if ( ! empty( $listar_category_link ) && ! empty( $listar_category_name ) ) :
							?>
							<a href="<?php echo esc_url( $listar_category_link ); ?>">
								<?php echo esc_html( $listar_category_name ); ?>
							</a>
							<?php
						endif;
						?>
						<?php
						if ( ! empty( $listar_region_link ) && ! empty( $listar_region_name ) ) :
							?>
							<a href="<?php echo esc_url( $listar_region_link ); ?>">
								<?php echo esc_html( $listar_region_name ); ?>
							</a>
						<?php
						endif;
						?>
					</div>
				</div>
				<?php
			endif;
		}
	}
}

listar_close_section();
exit();

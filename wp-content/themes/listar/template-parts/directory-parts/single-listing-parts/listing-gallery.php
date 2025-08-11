<?php
/**
 * Template part for displaying the listing gallery in single-job_listing
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id    = $post->ID;
$listar_listing_package_id = listar_addons_active() ? get_post_meta( $listar_current_post_id, '_package_id', true ) : 0;
$disabled_package_options  = listar_addons_active() && ! empty( $listar_listing_package_id ) ? listar_get_package_options_disabled( $listar_listing_package_id ) : array();
$listar_max_gallery_images = listar_addons_active() ? listar_get_max_image_gallery( $listar_listing_package_id ) : 30;

if ( ! isset( $disabled_package_options['listar_disable_gallery_images'] ) ) :
	$listar_listing_gallery_image_ids     = listar_listing_gallery_ids( $listar_current_post_id );
	$listar_gallery_design                = get_option( 'listar_single_listing_gallery_design' );
	$listar_listing_subtitle              = get_post_meta( $listar_current_post_id, '_job_listing_subtitle', true );
	$listar_custom_listing_gallery_design = get_post_meta( $listar_current_post_id, '_job_gallery_design', true );
	$listar_category_terms                = '';
	$listar_region_terms                  = '';
	$listar_count_category_terms          = 0;
	$listar_count_region_terms            = 0;
	$listar_blank_placeholder             = listar_blank_base64_placeholder_image();
	$listar_count_gallery_image_ids       = 0;
	
	if ( is_array( $listar_listing_gallery_image_ids ) ) {
		$listar_count_gallery_image_ids = count( $listar_listing_gallery_image_ids );
		
		if ( $listar_count_gallery_image_ids > $listar_max_gallery_images ) {
			$listar_listing_gallery_image_ids = array_slice( $listar_listing_gallery_image_ids, 0, $listar_max_gallery_images );
		}
	}

	if ( ! empty( $listar_custom_listing_gallery_design ) && 'gallery-default' !== $listar_custom_listing_gallery_design ) {
		$listar_gallery_design = $listar_custom_listing_gallery_design;
	}

	if ( 'slideshow-rounded' === $listar_gallery_design ) {
		$listar_gallery_design = 'tiny-rounded listar-gallery-slideshow-rounded listar-gallery-dark';
	}

	if ( 'slideshow-squared' === $listar_gallery_design ) {
		$listar_gallery_design = 'tiny-squared listar-gallery-slideshow-squared listar-gallery-dark';
	}

	if ( 'rounded-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'rounded listar-gallery-dark';
	}

	if ( 'squared-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'squared listar-gallery-dark';
	}

	if ( 'rounded-boxed-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'rounded-boxed listar-gallery-dark';
	}

	if ( 'squared-boxed-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'squared-boxed listar-gallery-dark';
	}

	if ( 'tiny-rounded-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'tiny-rounded listar-gallery-dark';
	}

	if ( 'tiny-squared-dark' === $listar_gallery_design ) {
		$listar_gallery_design = 'tiny-squared listar-gallery-dark';
	}

	if ( empty( $listar_gallery_design ) ) {
		$listar_gallery_design = 'tiny-rounded listar-gallery-slideshow-rounded';
	}

	if ( ! empty( $listar_listing_gallery_image_ids ) ) : ?>
		<section class="listar-section listar-section-no-padding-top listar-section-no-padding-bottom listar-single-listing-gallery-wrapper">
			<!-- Start section title - For W3C Valitation -->
			<header class="listar-listing-title hidden" data-aos="fade-zoom-in">
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

								if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) :
									$listar_reviews_average = listar_reviews_average( $listar_current_post_id );
									$listar_reviews_count   = (int) listar_reviews_count( $listar_current_post_id );
									?>
									<div class="listar-listing-header-stars">
										<div class="stars">
											<a href="#" class="listar-listing-header-stars-button">
												<div class="listar-listing-header-stars-inner">
													<div class="listar-mood-icon icon-<?php echo esc_attr( listar_sanitize_html_class( listar_reviews_reputation_mood( $listar_current_post_id ) ) ); ?>"></div>

													<?php echo wp_kses( listar_reviews_stars(), 'listar-basic-html' ); ?>

													<?php
													if ( false !== $listar_reviews_average ) :
														?>
														<div class="listar-listing-header-topbar-icon-wrapper">
															<div class="listar-listing-rating">
																<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
															</div>
															<span class="listar-rating-count">
																(<?php echo (int) $listar_reviews_count; ?>)
															</span>
														</div>
														<?php
													endif;
													?>
												</div>
											</a>
										</div>
									</div>
									<?php
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
													<a class="listar-term-text listar-ribbon" href="<?php echo esc_url( $listar_region_link ); ?>" style="background-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>); border-top-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>); border-bottom-color:rgb(<?php echo esc_attr( $listar_region_color ); ?>);">
														<?php echo esc_html( $listar_region_name ); ?>
													</a>
												<?php
												endif;fdsf
											endforeach; fefew
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
								if ( ! empty( $listar_listing_subtitle ) ) :
									?>
									<h5 class="listar-text-after-listing-title">
										<span>
											<?php echo esc_html( $listar_listing_subtitle ); ?>
										</span>
									</h5>
									<?php
								endif;
								?>

								<?php listar_views_counter_output(); ?>

								<?php listar_edit_post_link( true ); ?>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- End section title - For W3C Valitation -->
			<!-- Start Gallery -->
			<div class="listar-listing-gallery listar-section listar-gallery-<?php echo esc_attr( listar_sanitize_html_class( $listar_gallery_design ) ); ?>" id="listar-listing-gallery">
				<?php
				foreach ( $listar_listing_gallery_image_ids as $listar_gallery_image_id ) :
					$listar_attachment = wp_get_attachment_image_src( $listar_gallery_image_id, 'cover' );
					$listar_conditions = false !== $listar_attachment && isset( $listar_attachment[0] ) && ! empty( $listar_attachment[0] );
					$listar_image_url  = $listar_conditions ? $listar_attachment[0] : '';

					if ( ! empty( $listar_image_url ) ) :
						?>
						<div class="gallery-item" data-aos="fade-zoom-in" data-aos-group="gallery">
							<a href="<?php echo esc_attr( listar_custom_esc_url( $listar_image_url ) ); ?>" data-image-placeholder="<?php echo esc_attr( $listar_blank_placeholder ); ?>" data-lightbox="gallery" title="<?php echo esc_attr( get_the_title() ); ?>"></a>
						</div>
						<?php
					endif;

				endforeach;
				?>
			</div>
			<!-- End Gallery -->
		</section>
		<?php
	endif;
endif;


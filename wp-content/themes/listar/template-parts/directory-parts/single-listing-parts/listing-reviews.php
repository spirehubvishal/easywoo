<?php
/**
 * Template part for displaying the listing reviews in single-job_listing
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id = $post->ID;
$listar_reviews_count   = 0;
$listar_has_comments    = get_comments_number( $listar_current_post_id ) > 0 ? 'listar-listing-has-comments' : 'listar-listing-without-comments';
?>

<section class="listar-section listar-section-no-padding-bottom listar-single-listing-review-wrapper">
	<div class="listar-container-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Start Review -->
					<div>
						<div class="row">
							<div class="col-sm-12 text-center">
								<div class="listar-section-title">
									<h2 class="listar-title-with-stripe">
										<?php esc_html_e( 'Reviews And Comments', 'listar' ); ?>
									</h2>
								</div>
							</div>
						</div>
					</div>
					<div class="listar-listing-review-wrapper listar-light-comments listar-dark-call-to-review <?php echo sanitize_html_class( $listar_has_comments ); ?>" data-aos="fade-up">
						<div class="listar-listing-review" id="listar-listing-review">
							<div class="row">
								<?php
								if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {

									$listar_reviews_average = listar_reviews_average( $listar_current_post_id );
									$listar_reviews_count   = (int) listar_reviews_count( $listar_current_post_id );

									if ( $listar_reviews_count ) {
										?>
										<div class="col-xs-12 col-md-4 listar-review-first-col text-center <?php echo sanitize_html_class( comments_open( $listar_current_post_id ) ? '' : 'listar-comments-closed' ); ?>">

											<div class="listar-review-first-col-inner">

												<div class="listar-average-review">
													<div class="listar-mood-icon icon-<?php echo esc_attr( listar_sanitize_html_class( listar_reviews_reputation_mood( $listar_current_post_id ) ) ); ?>"></div>
													<div class="listar-listing-average-rating">
														<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
													</div>
													<div class="stars">
														<?php echo wp_kses( listar_reviews_stars(), 'listar-basic-html' ); ?>
													</div>
													<div class="listar-review-stats">
														<div class="listar-review-counter">
															<?php echo esc_html( $listar_reviews_count ); ?>
														</div>
														<div>
															<?php echo esc_html( listar_check_plural( $listar_reviews_count, esc_html__( 'Review', 'listar' ), esc_html__( 'Reviews', 'listar' ), esc_html__( 'No Reviews', 'listar' ) ) ); ?>
														</div>
													</div>
													<div class="listar-average-review-shape" ></div>
												</div>
												<div class="listar-review-reputation text-center">
													<div>
														<h4>
															<?php echo esc_html( listar_reviews_reputation( $listar_current_post_id ) ); ?>
														</h4>
													</div>
												</div>
											</div>

											<?php
											if ( comments_open() ) :
												/* If 'Listar Add-ons' plugin is inactive, use default WordPress login URL */
												$listar_login_url = ! listar_addons_active() && ! is_user_logged_in() ? wp_login_url( get_the_permalink() ) : '#';
												?>
												<div class="listar-write-review-button-wrapper">
													<div class="listar-write-review">
														<a href="<?php echo esc_url( $listar_login_url ); ?>" class="button listar-iconized-button icon-star-half">
															<?php esc_html_e( 'Write a Review', 'listar' ); ?>
														</a>
													</div>
												</div>
												<?php
											endif;
											?>

										</div>

										<div class="col-xs-12 col-md-8 listar-review-second-col listar-single-listing-has-reviews">
											<div class="listar-review-second-col-inner">
												<?php comments_template(); ?>
											</div>
										</div>

										<?php
									} else {
										?>

										<div class="col-xs-12 col-md-4 listar-review-first-col text-center listar-single-listing-without-reviews">

											<div class="listar-review-first-col-inner">

												<div class="listar-average-review">
													<div class="listar-mood-icon icon-<?php echo esc_attr( listar_sanitize_html_class( listar_reviews_reputation_mood( $listar_current_post_id ) ) ); ?>"></div>
													<div class="listar-listing-average-rating">
														<?php echo wp_kses( $listar_reviews_average, 'listar-basic-html' ); ?>
													</div>
													<div class="stars">
														<?php echo wp_kses( listar_reviews_stars(), 'listar-basic-html' ); ?>
													</div>
													<div class="listar-review-stats">
														<div class="listar-review-counter">
															<?php echo esc_html( $listar_reviews_count ); ?>
														</div>
													</div>
													<div class="listar-average-review-shape" ></div>
												</div>
											</div>

										</div>

										<div class="col-xs-12 col-md-8 listar-review-second-col listar-single-listing-without-reviews">
											<div class="listar-review-second-col-inner">
												<div class="listar-no-reviews-content listar-fallback-content">
													<div class="listar-fallback-content-big-title text-center">
														<h3>
															<?php esc_html_e( 'Not rated yet.', 'listar' ); ?>
														</h3>

													</div>

													<hr />

													<?php
													if ( comments_open() ) {
														/* If 'Listar Add-ons' plugin is inactive, use default WordPress login URL */
														$listar_login_url = ! listar_addons_active() && ! is_user_logged_in() ? wp_login_url( get_the_permalink() ) : '#';
														?>

														<div class="listar-fallback-content-small-title text-center">
															<h5>
																<?php esc_html_e( "Why don't you register your impressions?", 'listar' ); ?>
															</h5>

														</div>

														<div class="listar-fallback-content-description text-center">
															<?php esc_html_e( 'Be the first to allow other people acquire targeted feedback about this listing.', 'listar' ); ?>
														</div>

														<div class="listar-fallback-content-button-wrapper text-center">
															<div class="listar-write-review">
																<a href="<?php echo esc_url( $listar_login_url ); ?>" class="button listar-iconized-button icon-star-half">
																	<?php esc_html_e( 'Write a Review', 'listar' ); ?>
																</a>
															</div>
														</div>

														<?php
													} else {
														?>

														<div class="listar-fallback-content-description text-center">
															<?php esc_html_e( 'Comments are closed.', 'listar' ); ?>
														</div>

														<?php
													}
													?>
												</div>
											</div>
										</div>

										<div class="col-xs-12 col-md-12 hidden">
											<div class="listar-review-second-col-inner">
												<?php comments_template(); ?>
											</div>
										</div>

										<?php
									}
								} else {
									?>
									<div class="col-sm-12 listar-review-second-col">
										<div class="listar-review-second-col-inner">
											<?php comments_template(); ?>
										</div>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<!-- End Review -->
				</div>
			</div>
		</div>
	</div>
</section>

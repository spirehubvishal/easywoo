<?php
/**
 * Template part for displaying the listing map in single-job_listing
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id = $post->ID;
$listar_listing_package_id = listar_addons_active() ? get_post_meta( $listar_current_post_id, '_package_id', true ) : 0;
$disabled_package_options = listar_addons_active() && ! empty( $listar_listing_package_id ) ? listar_get_package_options_disabled( $listar_listing_package_id ) : array();
$listar_lat = esc_html( get_post_meta( $listar_current_post_id, 'geolocation_lat', true ) );
$listar_lng = esc_html( get_post_meta( $listar_current_post_id, 'geolocation_long', true ) );
$listar_category_id = '';
$listar_category_name = '';
$listar_category_link = '';
$footer_buttons_cols = 6;
$listar_listing_address = listar_get_listing_address( $listar_current_post_id );
$map_enabled = listar_is_map_enabled();
$map_enabled_single = listar_is_map_enabled( 'single' ) && ! isset( $disabled_package_options['listar_disable_map'] );
$map_directions_enabled = listar_is_map_enabled( 'directions' );
$map_gps_enabled = listar_is_map_enabled( 'gps' );
$listar_category_terms = '';
$listar_region_id = '';
$listar_region_id_first = '';
$listar_region_name = '';
$listar_region_link = '';
$listar_region_terms = '';
$featured_category      = false;
$featured_category_term = false;
$has_featured_category  = false;
$featured_region      = false;
$featured_region_term = false;
$has_region_category  = false;

$listar_force_lat = esc_html( get_post_meta( $listar_current_post_id, '_job_customlatitude', true ) );
$listar_force_lng = esc_html( get_post_meta( $listar_current_post_id, '_job_customlongitude', true ) );

if ( taxonomy_exists( 'job_listing_category' ) ) :
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

if ( taxonomy_exists( 'job_listing_region' ) ) :
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
	}
endif;

$has_category = ! empty( $listar_category_terms );
$has_region = ! empty( $listar_region_terms );

if ( $has_category && $has_region ) {
	$footer_buttons_cols = 4;
} elseif ( ! $has_category && ! $has_region ) {
	$footer_buttons_cols = 12;
}

if ( empty( $listar_lat ) || ! empty( $listar_force_lat )  ) {
	$listar_lat = $listar_force_lat;
}

if ( empty( $listar_lng ) || ! empty( $listar_force_lng )  ) {
	$listar_lng = $listar_force_lng;
}

if ( ! empty( $listar_lat ) && ! empty( $listar_lng ) && $map_enabled && $map_enabled_single ) :
	?>
	<section class="listar-section listar-section-no-padding-bottom">
		<!-- Start section title - For W3C Valitation -->
		<div class="listar-container-wrapper" >
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="listar-section-title">
							<h2 class="listar-title-with-stripe">
								<?php esc_html_e( 'Browse The Map', 'listar' ); ?>
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End section title - For W3C Valitation -->

		<div class="listar-container-wrapper" >
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="listar-listing-data listar-listing-data-map">
							<!-- Start Map header buttons -->
							<div class="listar-listing-map-header-buttons" data-aos="fade-up">
								<div class="row">
									<?php
									$map_data_cols = 3;
									
									if ( ! $map_directions_enabled ) {
										$map_data_cols -= 1;
									}
									
									if ( ! $map_gps_enabled ) {
										$map_data_cols -= 1;
									}
									
									if ( empty( $listar_listing_address ) || isset( $disabled_package_options['listar_location_disable'] ) ) {
										$map_data_cols -= 1;
									}
									
									if ( 3 === $map_data_cols ) {
										$map_data_cols = '4';
									} elseif ( 2 === $map_data_cols ) {
										$map_data_cols = '6';
									} else {
										$map_data_cols = '12';
									}
									
									if ( $map_directions_enabled ) :
										?>
										<div class="col-md-<?php echo esc_attr( $map_data_cols ); ?> text-center">
											<div class="listar-map-button-wrapper">
												<div class="listar-map-button-icon icon-compass2"></div>
												<div class="listar-map-button-content">
													<a href="#" target="_blank" class="listar-map-button-directions">
														<?php esc_html_e( 'Directions', 'listar' ); ?>
													</a>
												</div>
											</div>
										</div>
										<?php
									endif;
									?>
									
									<?php
									if ( $map_gps_enabled ) :
										?>
										<div class="col-md-<?php echo esc_attr( $map_data_cols ); ?> text-center">
											<div class="listar-map-button-wrapper listar-map-button-coordinates-wrapper">
												<div class="listar-map-button-icon icon-radar"></div>
												<div class="listar-map-button-content">
													<a href="#" class="listar-map-button-coordinates-link">
														<?php esc_html_e( 'GPS', 'listar' ); ?>
													</a>
													<div class="listar-map-button-coordinates hidden">
														<?php echo esc_html( $listar_lat . ', ' . $listar_lng ); ?>

													</div>
												</div>
											</div>
										</div>
										<?php
									endif;
									?>

									<?php
									if ( ! empty( $listar_listing_address ) && ! isset( $disabled_package_options['listar_location_disable'] )  ) :
										?>
										<div class="col-md-<?php echo esc_attr( $map_data_cols ); ?> text-center">
											<div class="listar-map-button-wrapper listar-map-button-address">
												<div class="listar-map-button-content">
													<?php echo esc_html( $listar_listing_address ); ?>
												</div>
											</div>
										</div>
										<?php
									endif;
									?>
								</div>
							</div>
							<!-- End Map header buttons -->
							<!-- Start Map -->
							<div class="listar-listing-map" id="listar-listing-map" data-aos="fade-up">
								<div id="map" class="listar-map"></div>
							</div>
							<!-- End Map -->
							
							<?php
							if ( ( $has_category ) || ( $has_region ) ) :
								?>
								<!-- Start Map footer buttons -->
								<div class="listar-listing-map-footer-buttons" data-aos="fade-up">
									<div class="row">
										<?php
										if ( $has_region ) :
											?>
											<div class="col-md-<?php echo esc_attr( $footer_buttons_cols ); ?> text-center">
												<div class="listar-map-button-wrapper">
													<div class="listar-map-button-icon icon-location"></div>
													<div class="listar-map-button-content">
														<?php
														$first_term = false;

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
																if ( empty( $listar_region_id_first ) ) {
																	$listar_region_id_first = $listar_region_id;
																}
																?>
																<a href="<?php echo esc_url( $listar_region_link ); ?>">
																	<?php echo esc_html( $listar_region_name ); ?>
																</a>
															<?php
															endif;
														endforeach;
														?>
													</div>
												</div>
											</div>
											<?php
										endif;
										?>
										<?php
										if ( $has_category ) :
											?>
											<div class="col-md-<?php echo esc_attr( $footer_buttons_cols ); ?> text-center">
												<div class="listar-map-button-wrapper">
													<div class="listar-map-button-icon icon-map-marker"></div>
													<div class="listar-map-button-content">
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
																	<a href="<?php echo esc_url( $listar_category_link ); ?>">
																		<?php echo esc_html( $listar_category_name ); ?>
																	</a>
																<?php
																endif;
															endforeach;
														endif;
														?>
													</div>
												</div>
											</div>
											<?php
										endif;
										?>
										<?php
										if ( ! empty( $listar_category_id ) || ! empty( $listar_region_id ) ) :
											$listar_category_id = isset( $featured_category_term->term_id ) ? $featured_category_term->term_id : $listar_category_id;
											$temp_region_first_id = ! empty( $listar_region_id_first ) ? $listar_region_id_first : $listar_region_id;
											$listar_region_id = isset( $featured_region_term->term_id ) ? $featured_region_term->term_id : $temp_region_first_id;
											$region_query_string = ! empty( $listar_region_id ) ? '&' . listar_url_query_vars_translate( 'listing_regions' ) . '=' . $listar_region_id : '';
											$category_query_string = ! empty( $listar_category_id ) ? '&' . listar_url_query_vars_translate( 'listing_categories' ) . '=' . $listar_category_id : '';
											$search_url = trailingslashit( network_site_url() ) . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing' . $region_query_string . $category_query_string;
											?>
											<div class="col-md-<?php echo esc_attr( $footer_buttons_cols ); ?> text-center">
												<div class="listar-map-button-wrapper">
													<div class="listar-map-button-icon icon-zoom-in"></div>
													<div class="listar-map-button-content">
														<a class="listar-map-button-find-similar-link" href="<?php echo esc_url( $search_url ); ?>">
															<?php esc_html_e( 'Find Similar', 'listar' ); ?>
														</a>
													</div>
												</div>
											</div>
											<?php
										endif;
										?>
									</div>
								</div>
								<!-- End Map footer buttons -->
								<?php
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
	<?php
elseif ( ! empty( $listar_category_id ) || ! empty( $listar_region_id ) ) :
	$region_query_string = ! empty( $listar_region_id ) ? '&' . listar_url_query_vars_translate( 'listing_regions' ) . '=' . $listar_region_id : '';
	$category_query_string = ! empty( $listar_category_id ) ? '&' . listar_url_query_vars_translate( 'listing_categories' ) . '=' . $listar_category_id : '';
	$search_url = trailingslashit( network_site_url() ) . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing' . $region_query_string . $category_query_string;
	?>
	<a class="listar-map-button-find-similar-link hidden" href="<?php echo esc_url( $search_url ); ?>">
		<?php esc_html_e( 'Find Similar', 'listar' ); ?>
	</a>
	<?php
endif;

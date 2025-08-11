<?php
/**
 * Template part for displaying search types (Explore By) inside a popup
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_search_by_background_image = listar_image_url( get_option( 'listar_search_by_background_image' ), 'listar-cover' );
$listar_background_image_mobile    = listar_image_url( get_option( 'listar_search_by_background_image' ), listar_mobile_hero_image_size() );
$listar_background_image           = empty( $listar_search_by_background_image ) ? '0' : $listar_search_by_background_image;
$listar_has_background_image       = '0' === $listar_background_image ? 'listar-no-background-image' : '';
$listar_theme_color                = listar_convert_hex_to_rgb( listar_theme_color() );
$search_by_popup_title             = get_option( 'listar_search_by_popup_title' );
$search_by_popup_description       = get_option( 'listar_search_by_popup_description' );

if ( empty ( $search_by_popup_title ) ) {
	$search_by_popup_title = esc_html__( 'Explore by', 'listar' );
}

if ( empty ( $search_by_popup_description ) ) {
	$search_by_popup_description = esc_html__( 'Set and save your favorite way to search.', 'listar' );
}
?>

<!-- Start Explore By Popup -->
<div class="listar-search-by-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
	<!-- Hero Image -->
	<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>" data-background-image-mobile="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image_mobile ) ); ?>"></div>
	<!-- Start Header Centralizer -->
	<div class="listar-header-centralizer listar-nearest-me-main">
		<div class="listar-content-centralized listar-container-wrapper">
			<div class="container listar-popup-title">
				<div class="row">
					<div class="col-sm-12">
						<h2>
							<?php echo esc_html( $search_by_popup_title ); ?>
						</h2>
					</div>
				</div>
			</div>
			<!-- Start Explore By Content Section -->
			<div class="container-fluid">
				<div class="row listar-search-by-options">
					<div class="col-sm-6 listar-search-by-options-wrapper listar-general-explore-by-options">
						<?php
						$listar_search_options_active = listar_addons_active() ? listar_get_search_options() : false;
						$listar_search_by_predefined_countries = listar_addons_active() ? listar_get_search_by_predefined_countries() : array();
						$count_countries = count( $listar_search_by_predefined_countries );
						$is_unique_country = 1 === $count_countries ? true : false;
						$single_country = $is_unique_country ? $listar_search_by_predefined_countries[0][0] : '';
						
						foreach( $listar_search_options_active as $key => $values ) :
							$search_by_title = $values[0];
							$search_by_icon_class  = $values[1];
							$search_by_description = $values[2];
							$search_by_placeholder = $values[3];
							$search_by_order = $values[5];
							$has_fa_class = false !== strpos( $search_by_icon_class, 'fa-' ) ? 'fa ' : '';
							?>
							<a class="fa <?php echo esc_attr( listar_sanitize_html_class( $has_fa_class . $search_by_icon_class ) ); ?>" href="#" data-explore-by-title="<?php echo esc_attr( $search_by_title ); ?>" data-explore-by-placeholder="<?php echo esc_attr( $search_by_placeholder ); ?>" data-explore-by-type="<?php echo esc_attr( $key ); ?>" data-explore-by-order="<?php echo esc_attr( $search_by_order ); ?>">
								<h4>
									<?php echo esc_html( $search_by_title ); ?>
								</h4>
								<div>
									<?php echo esc_html( $search_by_description ); ?>
								</div>
							</a>
							<?php
							if ( 'nearest_me' === $key ) :
								?>
								<div class="listar-search-by-custom-location-data-countries-select listar-edit-nearest-me-wrapper hidden">
									<div class="listar-edit-nearest-me listar-edit-nearest-me-data">
										<?php esc_html_e( 'Edit', 'listar' ); ?>
									</div>
									<div class="listar-edit-nearest-me listar-reset-nearest-me-data">
										<?php esc_html_e( 'Reset', 'listar' ); ?>
									</div>
								</div>
								<?php
							endif;
							
							if ( 'near_postcode' === $key || 'near_address' === $key ) :
								?>
								<div class="listar-search-by-custom-location-data-countries-select">
									<h6>
										<?php
										esc_html_e( 'Country', 'listar' );
										?>: 
									</h6>

									<?php
									/* In case of only one country */
									echo esc_html( $single_country );
									?>

									<?php
									/* In case of several countries - Always the first selected by default */
									if ( ! $is_unique_country ) :
										$key_with_hiphen = str_replace( '_', '-', $key );
										$selectedCountryIndex = (int) listar_current_explore_by_country();
										
										if ( empty ( $selectedCountryIndex ) ) {
											$selectedCountryIndex = 0;
										}
										?>
										<div>
											<select name="listar-search-by-<?php echo esc_attr( $key_with_hiphen ); ?>-countries" id="listar-search-by-<?php echo esc_attr( $key_with_hiphen ); ?>-countries" value="<?php echo esc_attr( $selectedCountryIndex ); ?>" class="listar-search-by-<?php echo esc_attr( $key_with_hiphen ); ?>-countries">
												<?php
												foreach( $listar_search_by_predefined_countries as $country ) :
													$country_name = $country[0];
													$country_index = $country[1];

													$selected = ( $selectedCountryIndex === $country_index ) ? 'selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $country_index ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
														<?php echo esc_html( $country_name ); ?>
													</option>
													<?php
												endforeach;
												?>
											</select>
										</div>
										<?php
									endif;
									?>
								</div>
								<?php
							endif;
						endforeach;
						?>
					</div>
					
					<div class="col-sm-6 listar-search-by-options-wrapper hidden listar-nearest-me-loading">
						<div class="listar-nearest-me-loading-inner">
							<h4>
								<?php echo esc_html_e( 'Geolocating...', 'listar' ); ?>
							</h4>
							<div class="listar-nearest-me-loading-icon"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Explore By Content Section -->
			<div class="container listar-popup-footer">
				<div class="row">
					<div class="col-sm-12">
						<h4>
							<?php echo esc_html( $search_by_popup_description ); ?>
						</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Header Centralizer -->
	
	<!-- Start Geolocation form -->
	<div class="listar-valign-form-holder listar-nearest-me-secondary listar-bootstrap-form hidden">
		<div class="text-center listar-valign-form-content">
			<div class="listar-panel-form-wrapper">
				<div class="panel listar-panel-form">
					<div class="panel-heading">
						<div class="listar-bootstrap-form-heading-title">
							<h4>
								<?php esc_html_e( 'Improve Geolocation', 'listar' ); ?>
							</h4>
						</div>
					</div>
					<div class="panel-body">
						<div>
							<div class="listar-not-geolocated-user hidden">
								<?php esc_html_e( 'Sorry, no geolocation data could be recovered for your device. Please fill the form fields below to force the detection of your current geolocation.', 'listar' ); ?>
							</div>
							<div>
								<?php
								/* Geolocated data form - 'Listar Add-ons' plugin */
									do_action( 'listar_geolocated_data_form' );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Geolocation form -->
</div>
<!-- End Explore By Popup -->

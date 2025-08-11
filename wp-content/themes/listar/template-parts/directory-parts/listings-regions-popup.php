<?php
/**
 * Template part for displaying listing regions inside a popup
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_use_carousel = (int) get_option( 'listar_use_carousel_regions_popup' );

if ( ! empty( $listar_use_carousel ) ) {
	$listar_use_carousel = 1 === (int) $listar_use_carousel ? 'listar-use-carousel' : '';
}
?>

<!-- Start Listing Regions Popup -->
<div class="listar-listing-regions-popup listar-no-background-image listar-hero-header listar-transparent-design listar-term-design-3">
	<!-- Hero Image -->
	<div class="listar-hero-image"></div>
	<!-- Start Header Centralizer -->
	<div class="listar-header-centralizer">
		<div class="listar-content-centralized listar-container-wrapper">
			<div class="container listar-popup-title">
				<div class="row">
					<div class="col-sm-12">
						<h2>
							<?php esc_html_e( 'Regions', 'listar' ); ?>
						</h2>
					</div>
				</div>
			</div>
			<!-- Start Listing Regions Carousel Section -->
			<div class="container-fluid listar-featured-listing-terms listar-listing-regions">
				<div class="listar-term-items listar-grid listar-carousel-loop owl-carousel owl-theme row <?php echo sanitize_html_class( $listar_use_carousel ); ?>">
					<!-- Populated with JavaScript -->
				</div>
			</div>
			<!-- End Listing Regions Carousel Section -->
			<div class="container listar-popup-footer">
				<div class="row">
					<div class="col-sm-12">
						<h4>
							<?php esc_html_e( 'Where do you want to go?', 'listar' ); ?>
						</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Header Centralizer -->
</div>
<!-- End Listing Regions Popup -->

<?php
/**
 * Template part for displaying the Claim Listing popup
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_search_by_background_image = listar_image_url( get_option( 'listar_claim_background_image' ), 'listar-cover' );
$listar_background_image_mobile    = listar_image_url( get_option( 'listar_claim_background_image' ), listar_mobile_hero_image_size() );
$listar_background_image           = empty( $listar_search_by_background_image ) ? '0' : $listar_search_by_background_image;
$listar_has_background_image       = '0' === $listar_background_image ? 'listar-no-background-image' : '';
$listar_theme_color                = listar_convert_hex_to_rgb( listar_theme_color() );
?>

<!-- Start Claim Listing Popup -->
<div class="listar-claim-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
	<!-- Hero Image -->
	<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>" data-background-image-mobile="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image_mobile ) ); ?>"></div>
	<!-- Start Claim Listing form -->
	<div class="listar-valign-form-holder listar-claim-primary listar-bootstrap-form">
		<div class="text-center listar-valign-form-content">
			<div class="listar-panel-form-wrapper">
				<div class="panel listar-panel-form">
					<div class="panel-heading">
						<div class="listar-bootstrap-form-heading-title">
							<h4>
								<?php esc_html_e( 'Claim Validation', 'listar' ); ?>
							</h4>
						</div>
					</div>
					<div class="panel-body">
						<div>
							<div>
								<?php
								/* Claim Listing form - 'Listar Add-ons' plugin */
								do_action( 'listar_claim_form' );
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="listar-panel-form-after"></div>
			</div>
		</div>
	</div>
	<!-- End Claim Listing form -->
</div>
<!-- End Claim Listing Popup -->

<?php
/**
 * Template part to output partner posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar_Addons
 */

global $post;

$listar_current_post_id        = get_the_ID();
$listar_partner_url            = get_post_meta( $listar_current_post_id, 'listar_meta_box_partner_url', true );
$listar_post_image             = get_the_post_thumbnail_url( $listar_current_post_id, 'large' );
$listar_post_classes           = array( 'listar-no-image' );
$listar_col_class              = 'col-xs-6 col-md-3 listar-partner-wrapper';
$listar_bg_image               = empty( $listar_post_image ) ? '0' : $listar_post_image;
$listar_partner_has_url        = 'listar-partner-has-url';
$listar_partner_bg_color       = get_post_meta( $listar_current_post_id, 'listar_meta_box_partner_background_color', true );
$listar_partner_gradient_color = get_post_meta( $listar_current_post_id, 'listar_meta_box_partner_secondary_background_color', true );
$listar_primary_color_is_white = 'listar-partner-light-title';
$listar_show_title             = true;
$listar_image_max_width        = (int) get_post_meta( $listar_current_post_id, 'listar_meta_box_max_partner_logo_width', true );
$listar_partner_slogan         = get_post_meta( $listar_current_post_id, 'listar_meta_box_partner_slogan', true );
$external_url                  = false;
$target                        = '_self';
$listar_blank_placeholder      = listar_blank_base64_placeholder_image();

if ( empty( $listar_partner_url ) ) {
	$listar_partner_url     = '#';
	$listar_partner_has_url = '';
} else {
	$external_url = listar_is_external( $listar_partner_url );
}

if ( ! empty( $external_url ) ) {
	$target = '_blank';
}

if ( '#fff' === $listar_partner_bg_color || '#ffffff' === $listar_partner_bg_color || empty( $listar_partner_bg_color ) ) {
	$listar_primary_color_is_white = 'listar-partner-grey-title';
}

if ( ! empty( $listar_partner_bg_color ) && ! empty( $listar_partner_gradient_color ) ) {
	$listar_primary_color    = listar_convert_hex_to_rgb( $listar_partner_bg_color );
	$listar_secondary_color  = listar_convert_hex_to_rgb( $listar_partner_gradient_color );
	$listar_partner_bg_color = listar_gradient_background( $listar_primary_color, 'left', 'right', $listar_secondary_color, '1', '1', '0%' );
} elseif ( ! empty( $listar_partner_bg_color ) ) {
	$listar_partner_bg_color = 'background-color:#' . str_replace( '#', '', $listar_partner_bg_color ) . ';';
}

if ( empty( $listar_image_max_width ) ) {
	$listar_image_max_width = 'max-width:140px;';
} else {
	$listar_image_max_width = 'max-width:' . $listar_image_max_width . 'px;';
}
?>

<!-- Start Partner Item Col -->
<div class="<?php echo esc_attr( listar_sanitize_html_class( $listar_col_class . ' ' . $listar_partner_has_url ) ); ?>">
	<div id="post-<?php the_ID(); ?>" <?php post_class( $listar_post_classes ); ?> data-aos="fade-zoom-in" data-aos-group="partners">
		<a href="<?php echo esc_url( $listar_partner_url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="listar-card-content-image">
			<div class="listar-partner-image-wrapper" style="<?php echo esc_attr( $listar_partner_bg_color ); ?>">
				<?php if ( $listar_show_title && ! empty( $listar_partner_slogan ) ) : ?>
					<!-- For W3C Validation -->
					<h5 class="hidden">
						<?php the_title(); ?>
					</h5>

					<div class="listar-partner-title <?php echo sanitize_html_class( $listar_primary_color_is_white ); ?>">
						<?php echo esc_html( $listar_partner_slogan ); ?>
					</div>

				<?php endif; ?>
				<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" alt="<?php the_title(); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>" style="<?php echo esc_attr( $listar_image_max_width ); ?>" data-force-img="true" />
			</div>
		</a>
	</div>
</div>
<!-- End Partner Item Col -->

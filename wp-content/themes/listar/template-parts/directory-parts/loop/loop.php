<?php
/**
 * Template part to output listing posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_is_ajax_loop       = listar_is_ajax_loop() ? 'listar-ajax-post' : 'listar-default-post';
$listar_effect_delay       = listar_static_increment();
$listar_current_post_id    = get_the_ID();
$listar_listing_id         = 'listing-' . $listar_current_post_id;
$listar_address            = listar_get_listing_address( $listar_current_post_id );
$listar_has_address        = ! empty( $listar_address );
$listar_has_address_class  = $listar_has_address ? 'listing-has-address' : 'listing-has-no-address';
$listar_post_classes       = array( 'listar-card-content', 'listar-no-image', $listar_has_address_class );
$listar_featured_temp      = get_post_meta( $listar_current_post_id, '_featured', true ) ? true : false;
$listar_featured           = $listar_featured_temp ? 'listar-featured-listing' : '';
$listing_card_design       = get_option( 'listar_listing_card_design' );
$listar_cards_design_class = 'rounded-image-block' === $listing_card_design || 'squared-image-block' === $listing_card_design ? 'listar-grid-design-image-block' : '';

if ( 'squared-image-block' === $listing_card_design ) {
	$listar_cards_design_class .= ' listar-squared-details';
}

/*
 * Recognizes if current loop is querying default or 'recommended' listings
 * Because only default listings should be included as map markers
 */
if ( false === listar_loop_completed() ) :

	listar_static_posts_already_shown( $listar_current_post_id );

	if ( ! is_single() ) {
		listar_static_current_listings( $listar_current_post_id );

		if ( is_array( listar_static_map_markers_ajax() ) ) {
			listar_static_map_markers_ajax( $listar_current_post_id );
		}
	}

endif;
?>

<div class="col-xs-12 col-sm-6 col-md-4 listar-grid-design-2 listar-listing-card <?php echo esc_attr( listar_sanitize_html_class( $listar_cards_design_class . ' ' . $listar_featured . ' ' . $listar_listing_id . ' ' . $listar_is_ajax_loop ) ); ?>" data-listing-id="<?php the_ID(); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( $listar_post_classes ); ?> data-aos="fade-zoom-in" data-aos-group="listings" data-aos-delay="<?php echo esc_attr( $listar_effect_delay ); ?>">
		<?php
		/* Listing Edit link for card */
		listar_get_card_edit_link_alias();
		?>
		<?php
		if ( ! listar_loading_card_content_ajax() || ! listar_addons_active() ) :
			get_template_part( 'template-parts/directory-parts/loop/card', 'content' );
		endif;
		?>
	</article>
</div>

<?php
/**
 * Template part for displaying listings search popup on every page, except front page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$use_search_button_front_page = 1 === (int) get_option( 'listar_activate_search_button_front' ) ? true : false;

if ( ( ! listar_is_front_page_template() || $use_search_button_front_page ) && class_exists( 'WP_Job_Manager' ) ) :
	$listar_search_popup_background_image = listar_image_url( get_option( 'listar_search_background_image' ), 'listar-cover' );
	$listar_background_image_mobile       = listar_image_url( get_option( 'listar_search_background_image' ), listar_mobile_hero_image_size() );
	$listar_background_image              = empty( $listar_search_popup_background_image ) ? '0' : $listar_search_popup_background_image;
	$listar_has_background_image          = '0' === $listar_background_image ? 'listar-no-background-image' : 'listar-has-background-image';
	$listar_theme_color                   = listar_convert_hex_to_rgb( listar_theme_color() );
	?>

	<!-- Start Search Popup -->
	<div class="listar-search-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
		<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>" data-background-image-mobile="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image_mobile ) ); ?>"></div>
		<?php
		$listar_disable_hero_search_categories_popup = (int) get_option( 'listar_disable_hero_search_categories_popup' );

		if( 0 === $listar_disable_hero_search_categories_popup ) {
			get_template_part( 'template-parts/directory-parts/listings-header', 'categories' );
		}

		get_template_part( 'template-parts/directory-parts/listings-header', 'sidebar' );
		?>
		<!-- Start Header Centralizer -->
		<div class="listar-header-centralizer">
			<div class="listar-content-centralized">
				<?php get_template_part( 'template-parts/directory-parts/listings-search', 'form' ); ?>
			</div>
		</div>
		<!-- End Header Centralizer -->
	</div>
	<!-- End Search Popup -->

	<?php
endif;

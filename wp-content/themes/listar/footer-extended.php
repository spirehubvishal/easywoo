<?php
/**
 * Print relevant data right before footer.php
 *
 * Because there are plugins that will cancel the printing of footer.php file, e.g.: "Elementor Header & Footer Builder"
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hubhood
 */

?>
			

		<?php
		if ( ! listar_is_wcfm_dashboard() ) :
			?>
			<a id="listar-login-link-3" class="hidden" href="#"></a>
			<a id="listar-login-link-4" class="hidden" target="_parent" href="#"></a>
			<?php
		endif;

		
		if ( post_type_exists( 'job_listing' ) ) :
			get_template_part( 'template-parts/directory-parts/listings-map', 'markers' );
		endif;
		
		/* Marketplace customization */
		wp_enqueue_style( 'listar-marketplace-store-list', listar_get_theme_file_uri( '/assets/css/marketplace-store-list-page.css' ), array(  ), listar_get_theme_version() );

		?>
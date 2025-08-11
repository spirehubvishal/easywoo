<?php
/**
 * Template Name: Front Page
 *
 * The template for displaying homepage with image on hero header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

get_header( 'general' );

$listar_widgetized_front_page = is_active_sidebar( 'listar-front-page-sidebar' ) && is_dynamic_sidebar( 'listar-front-page-sidebar' ) ? true : false;
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<!-- Start Page Content -->
			<div id="post-<?php the_ID(); ?>" <?php post_class( 'page-content entry-content' ); ?>>

				<?php
				// Remove double spaces and line breaks.
				$listar_get_post = get_the_content();
				$listar_get_post_temp = preg_replace( '/[^\w]/', '', $listar_get_post ); /* Check if the output has relevant text (Letters and/or Numbers) */

				if ( ! empty( $listar_get_post_temp ) ) :
					?>
					<section class="listar-section listar-front-page-has-content">
						<div class="listar-container-wrapper">
							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php
				endif;

				if ( $listar_widgetized_front_page ) :
					?>
					<div class="listar-front-page-widgetized-section">
						<?php dynamic_sidebar( 'listar-front-page-sidebar' ); ?>
					</div>
					<?php
				endif;
				?>

			</div>
			<!-- End Page Content -->

			<?php
		endwhile;
		?>

	</main>
</div>

<?php
listar_get_footer_extended();
get_footer();

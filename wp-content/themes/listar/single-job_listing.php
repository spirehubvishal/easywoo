<?php
/**
 * The template for displaying single listing posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Listar
 */

get_header( 'general' );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<!-- Start Listing Content -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Start article title - For W3C Valitation -->
				<div class="listar-container-wrapper">
					<div class="container">
						<div class="row listar-section-title hidden">
							<div class="col-sm-12">
								<h2 class="text-center">
									<?php the_title(); ?>
								</h2>
							</div>
						</div>
					</div>
				</div>
				<!-- End article title - For W3C Valitation -->

				<?php
				$listar_post_status = get_post_status();
				$listar_post_status_by_role = 1 === (int) get_option( 'job_manager_hide_expired_content', 1 ) && ! ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) && 'expired' === $listar_post_status ? 'expired' : 'published';
				$listar_related_enabled = 0 === (int) get_option( 'listar_disable_related_listings_single' ) ? true : false;

				if ( 'expired' === $listar_post_status_by_role ) :
					?>
					<section class="listar-section listar-section-no-padding-bottom">
						<div class="listar-container-wrapper">
							<div class="container text-center">
								<div class="row">
									<div class="col-sm-12">
										<?php
										$listar_get_post = get_the_content();
										echo wp_kses( apply_filters( 'the_content', wpautop( $listar_get_post, true ) ), 'post' );
										?>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php
				else :
					if ( ! post_password_required() ) {
						get_template_part( 'template-parts/directory-parts/single-listing-parts/listing', 'gallery' );
						get_template_part( 'template-parts/directory-parts/single-listing-parts/listing', 'description' );
						get_template_part( 'template-parts/directory-parts/single-listing-parts/listing', 'products' );
						get_template_part( 'template-parts/directory-parts/single-listing-parts/listing', 'map' );

						if ( ( comments_open() || get_comments_number() ) ) :
							$listar_reviews_section_disable = (int) get_option( 'listar_reviews_section_disable' );

							if ( 0 === $listar_reviews_section_disable ) {
								get_template_part( 'template-parts/directory-parts/single-listing-parts/listing', 'reviews' );
							}
							
						endif;
					} else {
						?>
						<section class="listar-section listar-section-no-padding-bottom listar-single-listing-review-wrapper">
							<div class="listar-container-wrapper">
								<div class="container text-center password-protected">
									<div class="row">
										<div class="col-sm-12">
											<?php echo get_the_password_form(); ?>
										</div>
									</div>
								</div>
							</div>
						</section>
						<?php
					}
				endif;

				if ( $listar_related_enabled ) {
					get_template_part( 'template-parts/directory-parts/single-listing-parts/listings-related', 'single' );
				}
				?>

			</article>
			<!-- End Listing Content -->

			<?php
		endwhile;
		?>

	</main>
</div>

<?php
listar_wp_link_pages();
listar_prev_next();
listar_get_footer_extended();
get_footer();

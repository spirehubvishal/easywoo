<?php
/**
 * Template part for displaying blog posts list (grid)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $wp_query;

$listar_has_sidebar = is_active_sidebar( 'listar-blog-sidebar' ) && is_dynamic_sidebar( 'listar-blog-sidebar' ) ? true : false;
$listar_col_length  = $listar_has_sidebar ? 'col-lg-9 col-md-8 col-xs-12' : 'col-md-12';
$listar_posts_count = listar_count_found_posts();

if ( 0 === $listar_posts_count ) :
	?>
	<div class="listar-container-wrapper listar-search-results-count-wrapper listar-not-found">
		<div class="container">
			<div class="listar-results-wrapper row" data-aos="fade-zoom-in" data-aos-delay="750">
				<div class="listar-results-count col-sm-12">
					<div>
						<?php
						esc_html_e( 'Sorry, no results were found.', 'listar' );
					
						if ( listar_is_search() ) :
							$listar_search_query = listar_get_search_query();

							if ( ! empty( $listar_search_query ) ) :
								?>
								<div class="listar-search-query">
									<?php
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Search: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									?>
								</div>
								<?php
							endif;
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;
?>

<div id="primary" class="content-area listar-blog-results-wrapper blog">
	<main id="main" class="site-main">
		<section class="listar-section listar-blog-grid-section">
			<div class="listar-container-wrapper" >
				<div class="container">
					<!-- Start section title - For W3C Valitation -->
					<div class="row listar-section-title hidden">
						<div class="col-sm-12">
							<h2 class="text-center">
								<?php esc_html_e( 'Blog', 'listar' ); ?>
							</h2>
						</div>
					</div>
					<!-- End section title - For W3C Valitation -->
					<div class="row">
						<div class="listar-main-block <?php echo esc_attr( listar_sanitize_html_class( $listar_col_length ) ); ?>">

							<?php
							if ( have_posts() ) {
								?>

								<!-- Start Archive Container  -->
								<div class="listar-grid listar-white-design listar-results-container row">
									<?php
									$listar_grid_design = get_option( 'listar_blog_grid_design' );

									if ( empty( $listar_grid_design ) ) {
										$listar_grid_design = 'full-width';
									}

									while ( have_posts() ) :
										the_post();
										get_template_part( 'template-parts/blog-parts/loop/loop-' . $listar_grid_design );
									endwhile;

									/* Outputs a card to complete the grid, avoiding empty areas on the screen. */
									listar_grid_filler_card( 'blog' );
									?>
								</div>
								<!-- End Archive Container  -->

								<?php
								/* Don't display the 'listar-more-results' button if there are not enough posts */
								if ( $wp_query->max_num_pages > 1 ) :
									?>
									<section class="listar-section listar-section-no-padding-bottom listar-load-more-section listar-pagination-section">
										<div class="row">
											<div class="col-sm-12">
												<div class="listar-load-more-wrapper" data-aos="fade-up">
													<div class="listar-more-results" title="<?php esc_attr_e( 'Load more', 'listar' ); ?>">
														<?php esc_html_e( 'Load more', 'listar' ); ?>
													</div>
												</div>
												<?php

												/* Ajax 'load more' script */
												listar_load_more_script();

												listar_pagination();
												?>
											</div>
										</div>
									</section>
									<?php
								endif;

							} else {
								get_template_part( 'template-parts/content', 'none' );
							}
							?>
						</div>

						<?php
						if ( $listar_has_sidebar ) :
							?>
							<!-- Start Sidebar -->
							<aside id="secondary" class="col-lg-3 col-md-4 col-xs-12 listar-sidebar-right">
								<?php get_sidebar(); ?>
							</aside>
							<!-- End Sidebar -->
							<?php
						endif;
						?>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>

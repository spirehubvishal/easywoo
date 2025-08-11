<?php
/**
 * Template part for displaying related listings for single listing pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $post;

$listar_current_post  = $post->ID;
$listar_related_title = esc_html( get_option( 'listar_related_listings_title' ) );

if ( empty( $listar_related_title ) ) {
	$listar_related_title = esc_html__( 'Suggested Listings', 'listar' );
}

listar_static_posts_already_shown( $listar_current_post );
listar_loop_completed( true );

$listar_exec_query = listar_get_related_listings_single();

if ( $listar_exec_query->have_posts() ) :

	$listar_count_items = listar_count_found_posts( $listar_exec_query );
	?>

	<section class="listar-section listar-listing-related-wrapper">
		<div class="listar-container-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<!-- Start Related Listings -->
						<div class="listar-related-listings" data-aos="fade-up">
							<div>
								<div class="row">
									<div class="col-sm-12 text-center">
										<div class="listar-section-title">
											<h2 class="listar-title-with-stripe">
												<?php echo esc_html( $listar_related_title ); ?>
											</h2>
										</div>
									</div>
								</div>
							</div>
							<div class="listar-main-block" id="rel">
								<div class="row listar-grid listar-white-design">
									<?php
									while ( $listar_exec_query->have_posts() ) :
										$listar_exec_query->the_post();
										get_template_part( 'template-parts/directory-parts/loop/loop' );
									endwhile;

									/* Outputs a card to complete the grid, avoiding empty areas on the screen. */
									listar_grid_filler_card();

									wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
						<!-- End Related Listings -->
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
endif;

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Listar
 */

$listar_has_sidebar = is_active_sidebar( 'listar-blog-sidebar' ) && is_dynamic_sidebar( 'listar-blog-sidebar' ) ? true : false;
$listar_col_length  = $listar_has_sidebar ? 'col-lg-9 col-md-8 col-xs-12' : 'col-md-12';
$listar_single_has_sidebar_class = $listar_has_sidebar ? 'listar-single-with-sidebar' : 'listar-single-without-sidebar';
?>

<div id="primary" class="content-area <?php echo esc_attr( listar_sanitize_html_class( $listar_single_has_sidebar_class ) ); ?> listar-light-comments-single">
	<main id="main" class="site-main">
		<section class="listar-section listar-post-content-section">
			<div class="listar-container-wrapper">
				<div class="container blog listar-single-block listar-single-content-wrapper">
					<!-- Start section title - For W3C Valitation -->
					<div class="row listar-section-title hidden">
						<div class="col-sm-12">
							<h2 class="text-center">
								<?php the_title(); ?>
							</h2>
						</div>
					</div>

					<?php
					if ( ! is_attachment() ) :

						/* Social sharing buttons - Requires Listar Addons plugin */
						do_action( 'listar_social_share_buttons_blog' );
						?>

						<div class="row listar-post-content-header-background-wrapper">
							<div class="col-sm-12">
								<div class="listar-post-content-header-background-inner"></div>
							</div>
						</div>
						<?php
					endif;
					?>

					<!-- End section title - For W3C Valitation -->
					<div class="row">
						<div class="listar-main-block <?php echo esc_attr( listar_sanitize_html_class( $listar_col_length ) ); ?>">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/blog-parts/single-parts/content', get_post_format() );
								get_template_part( 'template-parts/blog-parts/single-parts/tags' );
							endwhile;
							?>
						</div>

						<?php if ( $listar_has_sidebar ) : ?>
							<!-- Start Sidebar -->
							<aside id="secondary" class="col-lg-3 col-md-4 col-xs-12 listar-sidebar-right">
								<?php get_sidebar(); ?>
							</aside>
							<!-- End Sidebar -->
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<?php
		while ( have_posts() ) :
			the_post();

			$listar_author_intro       = get_the_author_meta( 'listar_meta_box_user_short_introduction' );
			$listar_author_biography   = get_the_author_meta( 'description' );
			$listar_has_author_details = ! empty( $listar_author_intro ) || ! empty( $listar_author_biography );
			$listar_no_details_class   = ! $listar_has_author_details ? 'listar-compact-author-section' : '';
			?>

			<!-- Start page links -->
			<?php listar_wp_link_pages(); ?>
			<!-- End page links -->

			<section class="listar-section listar-author-section <?php echo esc_attr( listar_sanitize_html_class( $listar_no_details_class ) ); ?>">
				<div class="listar-container-wrapper listar-post-author-wrapper">
					<div class="container">
						<!-- Start section title - For W3C Valitation -->
						<div class="row listar-section-title hidden">
							<div class="col-sm-12">
								<h2 class="text-center">
									<?php esc_html_e( 'Post author', 'listar' ); ?>
								</h2>
							</div>
						</div>
						<!-- End section title - For W3C Valitation -->
						<div class="row">
							<div class="col-sm-12">
								<?php get_template_part( 'template-parts/blog-parts/single-parts/author' ); ?>
							</div>
						</div>
					</div>
				</div>
			</section>

			<?php
			/* If comments are open or we have at least one comment, load up the comment template. */
			if ( ( comments_open() || get_comments_number() ) ) :
				?>
				<section class="listar-section listar-comments-section">
					<div class="listar-container-wrapper listar-light-comments">
						<div class="container">
							<!-- Start section title - For W3C Valitation -->
							<div class="row listar-section-title hidden">
								<div class="col-sm-12">
									<h2 class="text-center">
										<?php esc_html_e( 'Comments', 'listar' ); ?>
									</h2>
								</div>
							</div>
							<!-- End section title - For W3C Valitation -->
							<div class="row">
								<div class="col-sm-12">
									<?php comments_template(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			endif;
			?>

			<?php
			if ( listar_prev_next_links() ) :
				?>
				<section class="listar-section listar-navigation-section">
					<div class="listar-container-wrapper">
						<div class="container">
							<!-- Start section title - For W3C Valitation -->
							<div class="row listar-section-title hidden">
								<div class="col-sm-12">
									<h2 class="text-center">
										<?php esc_html_e( 'More posts', 'listar' ); ?>
									</h2>
								</div>
							</div>
							<!-- End section title - For W3C Valitation -->
							<div class="row">
								<div class="col-sm-12">
									<?php listar_prev_next(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			endif;
			?>

			<?php
		endwhile;
		?>
	</main>
</div>

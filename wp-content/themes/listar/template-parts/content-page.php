<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

?>
<!-- Start Page Intro -->
<div class="listar-container-wrapper listar-page-intro hidden listar-no-claim-packages" data-aos="fade-zoom-in" data-aos-delay="500">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php esc_html_e( 'Sorry, no claim packages available. Please, contact the site administrator.', 'listar' ); ?>
			</div>
		</div>
	</div>
</div>
<!-- End Page Intro -->

<div id="primary" class="listar-single-without-sidebar listar-light-comments-single">
	<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<section class="listar-section listar-post-content-section">
				<div class="listar-container-wrapper">
					<div class="container">
						<!-- Start section title - For W3C Valitation -->
						<div class="row listar-section-title hidden">
							<div class="col-sm-12">
								<h2 class="text-center">
									<?php the_title(); ?>
								</h2>
							</div>
						</div>
						<!-- End section title - For W3C Valitation -->
						<div class="row content-area">
							<div class="page-content entry-content col-sm-12" data-aos="fade-up" data-aos-delay="750" data-aos-offset="30">
								<!-- Start Page Content -->
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<?php the_content(); ?>
									<div class="listar-clear-both"></div>
								</article>
								<!-- End Page Content -->
							</div>
						</div>
					</div>
				</div>
			</section>

			<?php
			if ( listar_has_pagination() ) :
				listar_wp_link_pages();
			endif;
			?>

			<?php
			/* If comments are open or we have at least one comment, load up the comment template. */
			if ( ( comments_open() || get_comments_number() ) ) :
				?>
				<section class="listar-section listar-comments-section">
					<div class="listar-container-wrapper listar-light-comments">
						<div class="container">
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
		endwhile;
		?>
	</main>
</div>

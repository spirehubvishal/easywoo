<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Listar
 */

get_header( 'general' );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<section class="listar-section listar-404-section">
			<div class="listar-container-wrapper" >
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>

<?php
listar_get_footer_extended();
get_footer();

<?php
/**
 * Template part for displaying a message that posts can not be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

?>

<!-- Start Page Content -->
<article class="page-content listar-not-found entry-content">
	<div class="text-center" data-aos="fade-up" data-aos-delay="750">
		<h2 class="listar-not-found-title">
			<?php esc_html_e( "Don't give up", 'listar' ); ?>
		</h2>
		<p>
			<?php esc_html_e( "There's plenty to see on our directory.", 'listar' ); ?>
		</p>

		<?php
		if ( class_exists( 'WP_Job_Manager' ) ) :
			/**
			 * Check if a page with [jobs] shortcode exists,
			 * if not, use a generic listing search url without the 's' parameter.
			 */

			$listar_listings_page_url = job_manager_get_permalink( 'jobs' );

			if ( empty( $listar_listings_page_url ) ) :
				$listar_listings_page_url = trailingslashit( network_site_url() ) . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
			endif;
			?>

			<div class="listar-not-found-buttons">
				<a href="#" class="button listar-search-pop-button listar-light-button">
					<?php esc_html_e( 'Try the search', 'listar' ); ?>
				</a>

				<a href="<?php echo esc_url( $listar_listings_page_url ); ?>" class="button listar-light-button">
					<?php esc_html_e( 'See all listings', 'listar' ); ?>
				</a>
			</div>

			<?php
		endif;

		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			?>
			<p class="publish-posts">
				<?php
				$listar_kses_tags = array(
					'a' => array(
						'href' => array(),
					),
				);

				printf(
					/* TRANSLATORS: %s: URL to 'Add New Post' page */
					wp_kses( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'listar' ), $listar_kses_tags ),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
			<?php
		endif;
		?>
	</div>
</article>
<!-- End Page Content -->

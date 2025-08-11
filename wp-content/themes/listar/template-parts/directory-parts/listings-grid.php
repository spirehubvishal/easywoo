<?php
/**
 * Template part for displaying the listings list (grid)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $wp_query;

$listar_posts_count = listar_count_found_posts();
$listar_is_listing_page = isset( $wp_query->query_vars['is_listing_page'] ) ? true : false;
$listar_not_found = 0 === $listar_posts_count ? 'listar-not-found' : '';
$listar_related_enabled = 1 === (int) get_option( 'listar_disable_related_listings_archive' ) ? true : false;
$current_explore_by_type = listar_current_explore_by();
$saved_search_address = listar_current_search_address();
$saved_search_postcode = listar_current_search_postcode();
$is_bookmarks_page = isset( $wp_query->query[ listar_url_query_vars_translate( 'bookmarks_page' ) ] ) ? true : false;
$empty_bookmarks = false;

if ( $is_bookmarks_page ) {
	if ( ! is_user_logged_in() ) {
		$empty_bookmarks = true;
	} elseif ( isset( $wp_query->query_vars['empty_bookmarks'] ) ) {
		$empty_bookmarks = '1' === $wp_query->query_vars['empty_bookmarks'] ? true : false;
	}
}	
?>

<!-- Start Listing Results Counter -->
<!-- <div class="listar-container-wrapper listar-search-results-count-wrapper <?php echo sanitize_html_class( $listar_not_found ); ?>">
	<div class="container">
		<div class="listar-results-wrapper row" data-aos="fade-zoom-in" data-aos-delay="750">
			<div class="listar-results-count col-sm-12">
				<div>
					<?php
					if ( 0 === $listar_posts_count ) :
						esc_html_e( 'Sorry, no results were found.', 'listar' );
					
						if ( listar_is_search() ) :
							$listar_search_query = listar_get_search_query();
						
							if ( 'near_address' === $current_explore_by_type ) {
								$listar_search_query = $saved_search_address;
							}
						
							if ( 'near_postcode' === $current_explore_by_type ) {
								$listar_search_query = $saved_search_postcode;
							}

							if ( ! empty( $listar_search_query ) ) :
								?>
								<div class="listar-search-query">
									<?php
									if ( 'near_address' === $current_explore_by_type ) {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Address: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									} elseif ( 'near_postcode' === $current_explore_by_type ) {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Postcode: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									} else {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Search: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									}
									?>
								</div>
								<?php
							endif;
						endif;
					else :
						?>
						<span class="listar-results-counter">
							<?php echo esc_html( zeroise( $listar_posts_count, 2 ) ); ?>
						</span> <?php echo esc_html( listar_check_plural( $listar_posts_count, esc_html__( 'Result', 'listar' ), esc_html__( 'Results', 'listar' ) ) ); ?>

						<?php
						if ( listar_is_search() || 'near_address' === $current_explore_by_type || 'near_postcode' === $current_explore_by_type ) :
							$listar_search_query = listar_get_search_query();
						
							if ( 'near_address' === $current_explore_by_type ) {
								$listar_search_query = $saved_search_address;
							}
						
							if ( 'near_postcode' === $current_explore_by_type ) {
								$listar_search_query = $saved_search_postcode;
							}

							if ( ! empty( $listar_search_query ) ) :
								?>
								<div class="listar-search-query">
									<?php
									if ( 'near_address' === $current_explore_by_type ) {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Address: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									} elseif ( 'near_postcode' === $current_explore_by_type ) {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Postcode: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									} else {
										printf(
											/* TRANSLATORS: %s: Current search query, example: Food */
											esc_html__( 'Search: %s', 'listar' ),
											'<span>' . esc_html( listar_capitalize_phrase( $listar_search_query ) ) . '</span>'
										);
									}
									?>
								</div>
								<?php
							endif;
						endif;
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</div> -->
<!-- End Listing Results Counter -->

<!-- Start Listings Filter -->
<div class="listar-filter-form-wrapper">
	<div class="listar-container-wrapper">
		<div class="container <?php echo sanitize_html_class( $listar_not_found ); ?>">
			<!-- Start Listings Filter -->
			<?php get_template_part( 'template-parts/directory-parts/listings-filter', 'form' ); ?>
			<!-- End Listings Filter -->
		</div>
	</div>
</div>
<!-- End Listings Filter -->


<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<section class="listar-section listar-listing-grid-section">
			<div class="listar-container-wrapper">
				<div class="container listar-main-block listar-listings">
					<?php
					if ( $is_bookmarks_page ) :
						$bookmarks_page_title = $empty_bookmarks ? esc_html__( 'No bookmarks found. Try these...', 'listar' ) : esc_html__( 'Bookmarks', 'listar' );
						?>
						<div>
							<div class="row">
								<div class="col-sm-12 text-center">
									<div class="listar-section-title">
										<h2 class="listar-title-with-stripe">
											<?php echo esc_html( $bookmarks_page_title ); ?>
										</h2>
									</div>
								</div>
							</div>
						</div>
						<?php
					else :
						?>
						<!-- Start section title - For W3C Valitation -->
						<div class="row listar-section-title hidden">
							<div class="col-sm-12">
								<h2 class="text-center">
									<?php esc_html_e( 'Listings', 'listar' ); ?>
								</h2>
							</div>
						</div>
						<!-- End section title - For W3C Valitation -->
						<?php
					endif;
					?>

					<?php
					if ( have_posts() ) {
						$load_listing_card_content_ajax = 1 === (int) get_option( 'listar_load_listing_card_content_ajax' ) ? true : false;
						$load_listing_card_ajax_class = $load_listing_card_content_ajax ? 'listar-load-card-content-ajax' : '';
						?>
						<div class="row listar-grid <?php echo esc_attr( listar_sanitize_html_class( $load_listing_card_ajax_class ) ); ?> listar-white-design listar-results-container">
							<?php
							while ( have_posts() ) :
								the_post();
								listar_loading_card_content_ajax( $load_listing_card_content_ajax );
								get_template_part( 'template-parts/directory-parts/loop/loop' );
								listar_loading_card_content_ajax( false );
							endwhile;

							/* Outputs a card to complete the grid, avoiding empty areas on the screen. */
							listar_grid_filler_card();
							?>
						</div>
						<!-- End Listings Container  -->
						<?php
					} else {
						/* No results found */
						get_template_part( 'template-parts/content', 'none' );
					}
					?>
				</div>
			</div>
		</section>

		<?php
		/* Don't display the 'listar-more-results' button if there are not enough posts */
		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<section class="listar-section listar-section-no-padding-top listar-load-more-section">
				<div class="listar-container-wrapper" >
					<div class="container text-center">
						<!-- Start section title - For W3C Valitation -->
						<div class="row listar-section-title hidden">
							<div class="col-sm-12">
								<h2 class="text-center">
									<?php esc_html_e( 'Load more', 'listar' ); ?>
								</h2>
							</div>
						</div>
						<!-- End section title - For W3C Valitation -->
						<div class="row">
							<div class="col-sm-12">
								<div class="row listar-load-more-wrapper">
									<div class="col-sm-12" data-aos="fade-up">
										<div class="listar-more-results listar-load-listings" title="<?php esc_attr_e( 'Load more', 'listar' ); ?>">
											<?php esc_html_e( 'Load more', 'listar' ); ?>
										</div>
									</div>
								</div>
								<?php

								/* Ajax 'load more' script */
								listar_load_more_script();

								listar_pagination();
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php
		endif;

		if ( $listar_related_enabled && ( $listar_posts_count > 0 && ! $listar_is_listing_page ) ) :
			get_template_part( 'template-parts/directory-parts/listings-related', 'archive' );
		endif;
		?>
	</main>
</div>

<?php
/**
 * Template part for displaying the listings filter and order selects
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_listing_search_filter = listar_current_term_filter();
?>

<form action="<?php echo esc_url( network_site_url( '/' ) ); ?>" method="get" class="row listar-grid">
	<div class="col-sm-12 hidden">
		<input type="hidden" name="s" value="<?php echo esc_attr( listar_get_search_query() ); ?>">
		<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'search_type' ) ); ?>" value="listing">
	</div>

	<div class="col-xs-12 col-sm-6 col-md-3 listar-search-order-filter" data-aos="fade-zoom-in" data-aos-group="filter">
		<select class="listar-search-sort-listings listar-custom-select listar-select-single" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_sort' ) ); ?>" data-placeholder="<?php esc_attr_e( 'Sort by', 'listar' ); ?>">
			<?php
			$listar_sort_options = listar_get_listing_sort_option_filters();

			$listar_count_options = is_array( $listar_sort_options ) ? count( $listar_sort_options ) : 0;

			for ( $listar_options_i = 0; $listar_options_i < $listar_count_options; $listar_options_i++ ) :
				$listar_selected_option = $listar_listing_search_filter[ listar_url_query_vars_translate( 'listing_sort' ) ] === $listar_sort_options[ $listar_options_i ]['value'] ? 'selected' : '';
				?>
				<option data-icon="<?php echo esc_attr( $listar_sort_options[ $listar_options_i ]['icon'] ); ?> select-icon" value="<?php echo esc_attr( $listar_sort_options[ $listar_options_i ]['value'] ); ?>" <?php echo esc_attr( $listar_selected_option ); ?>>
					<?php echo esc_html( $listar_sort_options[ $listar_options_i ]['title'] ); ?>
				</option>
				<?php
			endfor;
			?>
		</select>
	</div>

	<?php
	if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) :

		/* Reset last filter list saved */
		listar_current_filter_elements( array(), true );

		/* Create new filter list */
		listar_hierarchical_terms_tree( 0, 'job_listing_region' );
		
		$listar_current_filters = listar_current_filter_elements();
		
		$listar_count_current_filters = is_array( $listar_current_filters ) ? count( $listar_current_filters ) : 0;

		if ( 0 !== $listar_count_current_filters ) :
			?>
			<!-- Start regions filter -->
			<div class="listar-search-filters-regions col-xs-12 col-sm-6 col-md-3" data-aos="fade-zoom-in" data-aos-group="filter">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_regions' ) ); ?>" class="listar-listing-regions-input">
				<select data-tax="job_listing_region" class="listar-search-filter-regions listar-custom-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Regions', 'listar' ); ?>">
					<?php listar_print_filter_options( $listar_listing_search_filter[ listar_url_query_vars_translate( 'listing_regions' ) ] ); ?>
				</select>
			</div>
			<!-- End regions filter -->
			<?php
		endif;

	endif;

	if ( taxonomy_exists( 'job_listing_category' ) ) :

		/* Reset last filter list saved */
		listar_current_filter_elements( array(), true );

		/* Create new filter list */
		listar_hierarchical_terms_tree( 0, 'job_listing_category' );

		$listar_current_filters = listar_current_filter_elements();
		
		$listar_count_current_filters = is_array( $listar_current_filters ) ? count( $listar_current_filters ) : 0;

		if ( 0 !== $listar_count_current_filters ) :
			?>
			<!-- Start categories filter -->
			<div class="listar-search-filters-categories col-xs-12 col-sm-6 col-md-3" data-aos="fade-zoom-in" data-aos-group="filter">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_categories' ) ); ?>" class="listar-listing-categories-input">
				<select data-tax="job_listing_category" class="listar-search-filter-categories listar-custom-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Categories', 'listar' ); ?>">
					<?php listar_print_filter_options( $listar_listing_search_filter[ listar_url_query_vars_translate( 'listing_categories' ) ] ); ?>
				</select>
			</div>
			<!-- End categories filter -->
			<?php
		endif;
	endif;

	if ( taxonomy_exists( 'job_listing_amenity' ) ) :

		/* Reset last filter list saved */
		listar_current_filter_elements( array(), true );

		/* Create new filter list */
		listar_hierarchical_terms_tree( 0, 'job_listing_amenity' );

		$listar_current_filters = listar_current_filter_elements();
		
		$listar_count_current_filters = is_array( $listar_current_filters ) ? count( $listar_current_filters ) : 0;

		if ( 0 !== $listar_count_current_filters ) :
			?>
			<!-- Start amenities filter -->
			<div class="listar-search-filters-amenities col-xs-12 col-sm-6 col-md-3" data-aos="fade-zoom-in" data-aos-group="filter">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_amenities' ) ); ?>" class="listar-listing-amenities-input">
				<select data-tax="job_listing_amenity" class="listar-search-filter-amenities listar-custom-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Amenities', 'listar' ); ?>">
					<?php listar_print_filter_options( $listar_listing_search_filter[ listar_url_query_vars_translate( 'listing_amenities' ) ] ); ?>
				</select>
			</div>
			<!-- End amenities filter -->
			<?php
		endif;
	endif;
	?>
</form>

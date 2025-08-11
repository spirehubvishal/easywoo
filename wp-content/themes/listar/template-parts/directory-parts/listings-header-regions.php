<?php
/**
 * Template part for displaying listing regions on hero header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

if ( class_exists( 'Astoundify_Job_Manager_Regions' ) && taxonomy_exists( 'job_listing_region' ) ) :
	?>

	<!-- Start Search Regions -->
	<div class="listar-search-regions">

		<?php
		global $wp_query, $query_string;

		$listar_initial_search_region_id = 0;
		$listar_body_classes             = get_body_class();
		$listar_listing_region_count     = 0;
		$listar_default_search_region    = listar_get_default_region_search();
		$listar_searching_on_region      = 0;
		$listar_regions                  = isset( $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] ) ? $wp_query->query[ listar_url_query_vars_translate( 'listing_regions' ) ] : 0;
		$listar_regions_bk               = $listar_regions;
		$listar_all_regions_button_text  = esc_html__( 'Where?', 'listar' );
		$listar_all_regions_placeholder  = esc_html__( 'All Regions', 'listar' );
		$listar_active_regions           = esc_html( get_option( 'listar_hero_search_regions' ) );
		$listar_active_regions_array     = array();
		$listar_region_count             = 0;
		$listar_max_terms                = 40;
		
		if ( false !== strpos( $listar_active_regions, 'x' ) ) {

			$listar_listing_regions = get_terms(
				array(
					'taxonomy'   => 'job_listing_region',
					'hide_empty' => false,
					'number'     => 2000,
				)
			);

			if ( $listar_listing_regions && ! is_wp_error( $listar_listing_regions ) ) {

				foreach ( $listar_listing_regions as $listar_listing_region ) {

					$listar_active_regions_array[] = array(
						$listar_listing_region->term_id,
						'1',
					);
				}
			}
		} else {

			if ( false !== strpos( $listar_active_regions, ',' ) ) {

				if ( ',' === substr( rtrim( $listar_active_regions ), -1 ) ) {
					$listar_active_regions = substr( $listar_active_regions, 0, -1 );
				}
				if ( false !== strpos( $listar_active_regions, ',' ) ) {
					$listar_active_regions_array = explode( ',', $listar_active_regions );
				}
			}

			$listar_count_regions = is_array( $listar_active_regions_array ) ? count( $listar_active_regions_array ) : 0;

			if ( 0 === $listar_count_regions ) {
				$listar_active_regions_array[] = $listar_active_regions;
			}

			$listar_temp_array = array();
			$listar_count = is_array( $listar_active_regions_array ) ? count( $listar_active_regions_array ) : 0;

			for ( $listar_regions_i = 0; $listar_regions_i < $listar_count; $listar_regions_i++ ) {

				if ( empty( $listar_active_regions_array[ $listar_regions_i ] ) ) {
					continue;
				}

				$listar_active_regions_array[ $listar_regions_i ] = explode( ' ', $listar_active_regions_array[ $listar_regions_i ], 2 );

				if ( '1' === $listar_active_regions_array[ $listar_regions_i ][1] ) {
					$listar_temp_array[] = $listar_active_regions_array[ $listar_regions_i ];
				}
			}

			$listar_active_regions_array = $listar_temp_array;

		} // End if().
		
		if ( empty( $listar_active_regions_array ) ) :
			$listar_active_regions_array = listar_get_terms_ids( 'job_listing_region' );
		endif;

		if ( ! empty( $listar_default_search_region ) ) {

			$listar_current_term = get_term_by( 'name', $listar_default_search_region, 'job_listing_region' );

			if ( false !== $listar_current_term ) {
				$listar_initial_search_region_id = $listar_current_term->term_id;
			}
		}

		if ( false !== strpos( $listar_regions, ',' ) ) {
			$listar_regions = explode( ',', $listar_regions );
		} else {
			$listar_regions = array( $listar_regions );
		}
		
		$listar_count_regions = is_array( $listar_regions ) ? count( $listar_regions ) : 0;

		if ( 1 === $listar_count_regions && 0 !== (int) $listar_regions[0] ) {
			$listar_searching_on_region = (int) $listar_regions[0];
		}

		if ( 0 === $listar_searching_on_region ) {

			$listar_check_region = (int) listar_region_id();

			if ( 0 !== $listar_check_region ) {
				$listar_searching_on_region = $listar_check_region;
				$listar_initial_search_region_id = $listar_searching_on_region;
			}
		}

		if ( 0 === $listar_initial_search_region_id ) {
			$listar_initial_search_region_id = $listar_searching_on_region;
		}

		$listar_regions_amount   = count( $listar_active_regions_array );
		$listar_has_more_regions = $listar_regions_amount > 1 ? 'listar-has-more-regions' : '';
		$listar_initial_search_regions = ! empty( $listar_initial_search_region_id ) ? $listar_initial_search_region_id : $listar_regions_bk;
		?>

		<div class="listar-regions-list <?php echo esc_attr( listar_sanitize_html_class( $listar_has_more_regions ) ); ?>">

			<?php
			if ( $listar_regions_amount > 0 ) :
				
				$listar_count = is_array( $listar_active_regions_array ) ? count( $listar_active_regions_array ) : 0;

				for ( $listar_regions_i = 0; $listar_regions_i < $listar_count; $listar_regions_i++ ) :
				
					if ( ! isset( $listar_active_regions_array[ $listar_regions_i ][0] ) || empty( $listar_active_regions_array[ $listar_regions_i ][0] ) ) {
						continue;
					}

					$listar_region_id = $listar_active_regions_array[ $listar_regions_i ][0];
					$listar_current_term = get_term( $listar_region_id, 'job_listing_region' );

					if ( $listar_current_term && ! is_wp_error( $listar_current_term ) ) :
						if ( $listar_region_count >= $listar_max_terms ) {
							break;
						}

						$listar_get_icon             = listar_term_icon( $listar_region_id );
						$listar_region_icon          = listar_icon_class( $listar_get_icon );
						$listar_has_icon             = ! empty( $listar_region_icon[0] ) || ! empty( $listar_region_icon[1] ) ? 'listar-has-icon' : 'listar-no-icon';
						$listar_region_url           = get_term_link( $listar_current_term, 'job_listing_region' );
						$listar_is_child             = 0 !== $listar_current_term->parent ? 'child' : '';
						$listar_term_color           = listar_term_color( $listar_region_id );
						$listar_term_image_id        = get_term_meta( $listar_region_id, 'job_listing_region-image-id', true );
						$listar_term_image           = wp_get_attachment_image_src( $listar_term_image_id, 'large' );
						$listar_conditions           = false !== $listar_term_image && isset( $listar_term_image[0] ) && ! empty( $listar_term_image[0] );
						$listar_term_image_url       = $listar_conditions ? $listar_term_image[0] : '';
						$listar_term_name            = $listar_current_term->name;
						$listar_term_description     = ! empty( $listar_current_term->description ) ? $listar_current_term->description : '';
						$listar_gradient_background  = listar_gradient_background( '0,0,0', 'top', 'bottom', false, '0', '0.5', '50%' );
						$listar_counter_bg_color     = in_array( 'listar-counters-design-1', $listar_body_classes, true ) ? 'rgb(' . $listar_term_color . ')' : 'rgb(255,255,255)';
						$listar_counter_border_color = in_array( 'listar-counters-design-1', $listar_body_classes, true ) ? 'rgba(' . $listar_term_color . ',0.4)' : 'rgba(0,0,0,0.1)';
						$listar_term_count           = listar_count_term_posts( $listar_current_term );
						$listar_term_count_zeroise   = $listar_term_count > 0 ? zeroise( $listar_term_count, 2 ) : $listar_term_count;
						$listar_term_count_hover     = $listar_term_count > 0 ? zeroise( $listar_term_count, 2 ) . ' ' : '';
						$listar_term_count_hover_str = $listar_term_count_hover . listar_check_plural( $listar_term_count, esc_html__( 'Listing', 'listar' ), esc_html__( 'Listings', 'listar' ), esc_html__( 'No Listings', 'listar' ) );
						$listar_class                = '';
						
						if (
							( (int) $listar_searching_on_region === (int) $listar_region_id ) ||
							( 0 === (int) $listar_searching_on_region && $listar_default_search_region === $listar_term_name ) ||
							( 1 === $listar_regions_amount )
						) {
							$listar_class = 'current';
						}
						?>

						<a href="<?php echo esc_url( $listar_region_url ); ?>" data-term-id="<?php echo esc_attr( $listar_region_id ); ?>" class="listar-listing-region-link <?php echo esc_attr( listar_sanitize_html_class( $listar_class ) ); ?>" data-term-name="<?php echo esc_attr( $listar_term_name ); ?>" data-term-description="<?php echo esc_attr( $listar_term_description ); ?>" data-term-image="<?php echo esc_attr( listar_custom_esc_url( $listar_term_image_url ) ); ?>" data-gradient-background="<?php echo esc_attr( $listar_gradient_background ); ?>" data-term-color="<?php echo esc_attr( $listar_term_color ); ?>" data-counter-bg-color="<?php echo esc_attr( $listar_counter_bg_color ); ?>" data-counter-border-color="<?php echo esc_attr( $listar_counter_border_color ); ?>" data-term-count="<?php echo esc_attr( $listar_term_count_zeroise ); ?>" data-term-count-hover="<?php echo esc_attr( $listar_term_count_hover_str ); ?>">
							<span>
								<?php echo esc_html( $listar_term_name ); ?>
							</span>
						</a>

						<?php
						$listar_listing_region_count++;
					endif;

				endfor;
				
			endif;

			if ( $listar_listing_region_count > 1 ) :
				$count_current_regions = 0;
				$first_region_name = '';
			
				if ( is_string( $listar_initial_search_regions ) && false !== strpos( $listar_initial_search_regions, ',' ) ) {
					
					$current_regions_array = array_filter( explode( ',', trim( $listar_initial_search_regions ) ) );
					
					$count_current_regions = count( $current_regions_array );
					
					$listar_region_id = $current_regions_array[0];
					$listar_current_term = get_term( $listar_region_id, 'job_listing_region' );

					if ( $listar_current_term && ! is_wp_error( $listar_current_term ) ) {
						$first_region_name = $listar_current_term->name;
						
						$listar_all_regions_button_text = $first_region_name . ' +' . ( $count_current_regions - 1 );
					}
				}
				
				$listar_current_region = empty( $listar_default_search_region ) && 0 === $listar_searching_on_region ? 'current' : '';
				?>

				<a href="#" data-region-id="0" data-placeholder="<?php echo esc_attr( $listar_all_regions_placeholder ); ?>" class="<?php echo sanitize_html_class( $listar_current_region ); ?> listar-all-regions-button listar-more-regions-button">
					<span>
						<strong>
							<?php echo esc_html( $listar_all_regions_button_text ); ?>
						</strong>
					</span>
				</a>

				<?php
			endif;
			?>

		</div>
		<div class="listar-regions-overlay-top"></div>
		<div class="listar-regions-overlay-bottom"></div>
	</div>
	
	<?php
	if ( 0 === (int) $listar_initial_search_regions ) {
		$listar_initial_search_regions = '';
	}
	?>
	
	<input class="listar-temp-chosen-region" type="hidden" value="<?php echo esc_attr( $listar_initial_search_regions ); ?>">
	<div class="listar-nav-regions listar-regions-top"></div>
	<div class="listar-nav-regions listar-regions-bottom"></div>
	<!-- End Search Regions -->

	<?php
endif;

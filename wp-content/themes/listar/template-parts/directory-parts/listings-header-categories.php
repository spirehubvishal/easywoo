<?php
/**
 * Template part for displaying listing categories on hero header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_listing_category_icons  = '';
$listar_active_categories       = esc_html( get_option( 'listar_hero_search_categories' ) );
$listar_active_categories_array = array();
$listar_category_count          = 0;
$listar_max_terms               = 100;
$listar_body_classes            = get_body_class();

if ( taxonomy_exists( 'job_listing_category' ) ) :

	if ( false !== strpos( $listar_active_categories, 'x' ) ) {

		$listar_listing_categories = get_terms(
			array(
				'taxonomy'   => 'job_listing_category',
				'hide_empty' => false,
				'number'     => 2000,
			)
		);

		if ( $listar_listing_categories && ! is_wp_error( $listar_listing_categories ) ) {

			foreach ( $listar_listing_categories as $listar_listing_category ) {

				$listar_active_categories_array[] = array(
					$listar_listing_category->term_id,
					'1',
				);
			}
		}
	} else {

		if ( false !== strpos( $listar_active_categories, ',' ) ) {

			if ( ',' === substr( rtrim( $listar_active_categories ), -1 ) ) {
				$listar_active_categories = substr( $listar_active_categories, 0, -1 );
			}
			if ( false !== strpos( $listar_active_categories, ',' ) ) {
				$listar_active_categories_array = explode( ',', $listar_active_categories );
			}
		}
		
		$listar_count_categories = is_array( $listar_active_categories_array ) ? count( $listar_active_categories_array ) : 0;

		if ( 0 === $listar_count_categories ) {
			$listar_active_categories_array[] = $listar_active_categories;
		}

		$listar_temp_array = array();
		$listar_count = is_array( $listar_active_categories_array ) ? count( $listar_active_categories_array ) : 0;

		for ( $listar_categories_i = 0; $listar_categories_i < $listar_count; $listar_categories_i++ ) {

			if ( empty( $listar_active_categories_array[ $listar_categories_i ] ) ) {
				continue;
			}

			$listar_active_categories_array[ $listar_categories_i ] = explode( ' ', $listar_active_categories_array[ $listar_categories_i ], 2 );

			if ( '1' === $listar_active_categories_array[ $listar_categories_i ][1] ) {
				$listar_temp_array[] = $listar_active_categories_array[ $listar_categories_i ];
			}
		}

		$listar_active_categories_array = $listar_temp_array;

	} // End if().

endif;

if ( empty( $listar_active_categories_array ) ) :
	$listar_active_categories_array = listar_get_terms_ids( 'job_listing_category' );
endif;
?>

<!-- Start Search Categories -->
<div class="listar-search-categories listar-categories-fixed-bottom listar-hidden-category-nav">
	<div class="listar-listing-categories">
		<div class="listar-listing-categories-wrapper">
			<div class="listar-listing-categories-inner">
				<div>
					<?php
					$listar_count = is_array( $listar_active_categories_array ) ? count( $listar_active_categories_array ) : 0;

					if ( empty( $listar_active_categories_array ) || 0 === $listar_count ) :
						?>
						<div class="listar-no-search-categories"></div>
						<?php
					else :

						for ( $listar_categories_i = 0; $listar_categories_i < $listar_count; $listar_categories_i++ ) :
							if ( ! isset( $listar_active_categories_array[ $listar_categories_i ][0] ) || empty( $listar_active_categories_array[ $listar_categories_i ][0] ) ) {
								continue;
							}

							$listar_category_id = $listar_active_categories_array[ $listar_categories_i ][0];
							$listar_current_term = get_term( $listar_category_id, 'job_listing_category' );

							if ( $listar_current_term && ! is_wp_error( $listar_current_term ) ) :
								if ( $listar_category_count >= $listar_max_terms ) {
									break;
								}

								$listar_category_count++;
								$listar_get_icon             = listar_term_icon( $listar_category_id );
								$listar_category_icon        = listar_icon_class( $listar_get_icon );
								$listar_has_icon             = ! empty( $listar_category_icon[0] ) || ! empty( $listar_category_icon[1] ) ? 'listar-has-icon' : 'listar-no-icon';
								$listar_category_url         = get_term_link( $listar_current_term, 'job_listing_category' );
								$listar_is_child             = 0 !== $listar_current_term->parent ? 'child' : '';
								$listar_term_color           = listar_term_color( $listar_category_id );
								$listar_term_image           = listar_term_image( $listar_category_id, 'job_listing_category', 'large' );
								$listar_term_name            = $listar_current_term->name;
								$listar_term_description     = ! empty( $listar_current_term->description ) ? $listar_current_term->description : '';
								$listar_gradient_background  = listar_gradient_background( '0,0,0', 'top', 'bottom', false, '0', '0.5', '50%' );
								$listar_counter_bg_color     = in_array( 'listar-counters-design-1', $listar_body_classes, true ) ? 'rgb(' . $listar_term_color . ')' : 'rgb(255,255,255)';
								$listar_counter_border_color = in_array( 'listar-counters-design-1', $listar_body_classes, true ) ? 'rgba(' . $listar_term_color . ',0.4)' : 'rgba(0,0,0,0.1)';
								$listar_term_count           = listar_count_term_posts( $listar_current_term );
								$listar_term_count_zeroise   = $listar_term_count > 0 ? zeroise( $listar_term_count, 2 ) : $listar_term_count;
								$listar_term_count_hover     = $listar_term_count > 0 ? zeroise( $listar_term_count, 2 ) . ' ' : '';
								$listar_term_count_hover_str = $listar_term_count_hover . listar_check_plural( $listar_term_count, esc_html__( 'Listing', 'listar' ), esc_html__( 'Listings', 'listar' ), esc_html__( 'No Listings', 'listar' ) );
								?>

								<a href="<?php echo esc_url( $listar_category_url ); ?>" data-term-id="<?php echo esc_attr( $listar_category_id ); ?>"  class="listar-listing-category-link <?php echo sanitize_html_class( $listar_has_icon ); ?>" data-term-name="<?php echo esc_attr( $listar_term_name ); ?>" data-term-description="<?php echo esc_attr( $listar_term_description ); ?>" data-term-image="<?php echo esc_attr( listar_custom_esc_url( $listar_term_image ) ); ?>" data-gradient-background="<?php echo esc_attr( $listar_gradient_background ); ?>" data-term-color="<?php echo esc_attr( $listar_term_color ); ?>" data-counter-bg-color="<?php echo esc_attr( $listar_counter_bg_color ); ?>" data-counter-border-color="<?php echo esc_attr( $listar_counter_border_color ); ?>" data-term-count="<?php echo esc_attr( $listar_term_count_zeroise ); ?>" data-term-count-hover="<?php echo esc_attr( $listar_term_count_hover_str ); ?>">
									<div data-aos="fade-zoom-in" data-aos-group="header-categories">
										<?php
										if ( ( ! empty( $listar_category_icon[0] ) || ! empty( $listar_category_icon[1] ) ) ) :
											?>
											<div class="listar-category-icon-wrapper">
												<div class="listar-category-icon-box" style="<?php echo 'background-color: rgb(' . esc_attr( $listar_term_color ) . ');'; ?>"></div>
												<span class="<?php echo esc_attr( listar_sanitize_html_class( $listar_category_icon[0] . ' ' . $listar_is_child ) ); ?>">
													<?php
													/**
													 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
													 * Please check the description for 'listar_icon_output' function in functions.php.
													 */
													listar_icon_output( $listar_category_icon[1] );
													?>
												</span>
											</div>
											<?php
										endif;
										?>
										<div class="listar-header-category-name">
											<?php echo esc_html( $listar_term_name ); ?>
										</div>
									</div>
								</a>

								<?php
							endif;

						endfor;

					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Search Categories -->

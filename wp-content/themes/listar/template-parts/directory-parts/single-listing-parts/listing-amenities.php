<?php
/**
 * Template part for displaying listing amenities on single-job_listing.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

if ( is_single() ) :

	/* Check if post type is job_listing */
	if ( 'job_listing' === get_post_type( get_the_ID() ) ) :

		/* Geting all desired taxonomy items for current listing */

		$listar_args = array(
			'number' => 2000,
		);

		$listar_temp_array = array();
		$listar_temp_items = wp_get_post_terms( get_the_ID(), 'job_listing_amenity', $listar_args );

		foreach ( $listar_temp_items as $listar_amenity_item ) :
			$listar_temp_array[] = $listar_amenity_item;
		endforeach;
		
		$listar_count_temp_array = is_array( $listar_temp_array ) ? count( $listar_temp_array ) : 0;

		if ( $listar_count_temp_array ) {
			$listar_temp_array = array_filter( $listar_temp_array );
		}

		$listar_amenity_items = $listar_temp_array;
		
		$listar_count_amenity_items = is_array( $listar_amenity_items ) ? count( $listar_amenity_items ) : 0;

		if ( $listar_count_amenity_items ) :
			?>
			<!-- Start Amenities Section -->
			<div class="listar-listing-amenities-wrapper">
				<div class="listar-listing-amenities-inner">
					<div>
						<?php
						foreach ( $listar_amenity_items as $listar_amenity_item ) :
							$listar_amenity_id  = $listar_amenity_item->term_id;
							$listar_amenity_url = get_term_link( $listar_amenity_id, 'job_listing_amenity' );
							$listar_data        = get_option( "taxonomy_$listar_amenity_id" );
							$listar_icon        = listar_icon_class( isset( $listar_data['term_icon'] ) ? esc_html( $listar_data['term_icon'] ) : 'icon-tags' );
							$listar_term_color  = listar_term_color( $listar_amenity_id );
							
							
							if ( isset( $listar_data['term_icon'] ) ) :
								printf('<pre>%s</pre>', var_export($listar_data['term_icon'],true));
							endif;
							?>

							<a href="<?php echo esc_url( $listar_amenity_url ); ?>" class="button listar-iconized-button <?php echo esc_attr( listar_sanitize_html_class( $listar_icon[0] ) ); ?> listar-amenity-desktop" style="background-color:rgb(<?php echo esc_attr( $listar_term_color ); ?>);">
								<?php
								/**
								 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
								 * Please check the description for 'listar_icon_output' function in functions.php.
								 */
								listar_icon_output( $listar_icon[1] );
								?>
								<span>
									<?php
									echo esc_html( $listar_amenity_item->name );
									?>
								</span>
							</a>

							<?php
						endforeach;
						?>
					</div>
				</div>
			</div>
			<!-- End Amenities Section -->
			<?php
		endif;
	endif;
endif;

<?php
/**
 * Enable reference location (longitude) to terms from WP Job Manager (regions)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_location_secondary_reference_longitude_init', 'listar_taxonomy_location_secondary_reference_longitude' );

if ( ! function_exists( 'listar_taxonomy_location_secondary_reference_longitude' ) ) :
	/**
	 * Enable taxonomy reference location.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_location_secondary_reference_longitude() {

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_location_secondary_reference_longitude_meta_field', 10, 2 );

		/* Sanitize and save when creating or editing */
		/* This meta field has no saving process here, it depends of 'taxonomy-location-secondary-reference-address' meta field. */
	}

endif;

/**
 * Enable taxonomy reference location field to the 'Edit' term page.
 *
 * @since 1.0
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_location_secondary_reference_longitude_meta_field( $term ) {
	$term_id = $term->term_id;
	$theme_location_secondary_reference_longitude = '';

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	
	$location_secondary_reference_longitude = isset( $term_meta['term_location_secondary_reference_longitude'] ) ? esc_attr( $term_meta['term_location_secondary_reference_longitude'] ) : $theme_location_secondary_reference_longitude;
	?>
	<tr class="form-field listar-location-reference-coordinate-row">
		<th scope="row" valign="top">
			<label for="term_meta[term_location_secondary_reference_longitude]"></label>
		</th>
		<td>
			<input type="text" name="term_meta[term_location_secondary_reference_longitude]" class="listar-term-location-secondary-reference-longitude" id="term_meta[term_location_secondary_reference_longitude]" value="<?php echo esc_attr( $location_secondary_reference_longitude ); ?>">
			<?php wp_nonce_field( 'term-location-secondary-reference-longitude-nonce-action', 'term-location-secondary-reference-longitude-nonce' ); ?>
		</td>
	</tr>
	<?php
}

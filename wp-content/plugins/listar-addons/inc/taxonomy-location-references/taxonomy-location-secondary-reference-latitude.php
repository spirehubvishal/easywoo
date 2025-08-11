<?php
/**
 * Enable reference location (latitude) to terms from WP Job Manager (regions)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_location_secondary_reference_latitude_init', 'listar_taxonomy_location_secondary_reference_latitude' );

if ( ! function_exists( 'listar_taxonomy_location_secondary_reference_latitude' ) ) :
	/**
	 * Enable taxonomy reference location.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_location_secondary_reference_latitude() {

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_location_secondary_reference_latitude_meta_field', 10, 2 );

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
function listar_taxonomy_edit_location_secondary_reference_latitude_meta_field( $term ) {
	$term_id = $term->term_id;
	$theme_location_secondary_reference_latitude = '';

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$location_secondary_reference_latitude = isset( $term_meta['term_location_secondary_reference_latitude'] ) ? esc_attr( $term_meta['term_location_secondary_reference_latitude'] ) : $theme_location_secondary_reference_latitude;
	?>
	<tr class="form-field listar-location-reference-coordinate-row">
		<th scope="row" valign="top">
			<label for="term_meta[term_location_secondary_reference_latitude]"></label>
		</th>
		<td>
			<input type="text" name="term_meta[term_location_secondary_reference_latitude]" class="listar-term-location-secondary-reference-latitude" id="term_meta[term_location_secondary_reference_latitude]" value="<?php echo esc_attr( $location_secondary_reference_latitude ); ?>">
			<?php wp_nonce_field( 'term-location-secondary-reference-latitude-nonce-action', 'term-location-secondary-reference-latitude-nonce' ); ?>
		</td>
	</tr>
	<?php
}

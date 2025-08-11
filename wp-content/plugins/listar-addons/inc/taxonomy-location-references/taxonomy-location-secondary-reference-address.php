<?php
/**
 * Enable reference location (address) to terms from WP Job Manager (regions)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_location_secondary_reference_address_init', 'listar_taxonomy_location_secondary_reference_address' );

if ( ! function_exists( 'listar_taxonomy_location_secondary_reference_address' ) ) :
	/**
	 * Enable taxonomy reference location.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_location_secondary_reference_address() {

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_location_secondary_reference_address_meta_field', 10, 2 );

		/* Sanitize and save when creating or editing */
		add_action( 'edited_job_listing_region', 'listar_save_taxonomy_custom_location_secondary_reference_address_meta', 10, 2 );
		add_action( 'create_job_listing_region', 'listar_save_taxonomy_custom_location_secondary_reference_address_meta', 10, 2 );
	}

endif;

/**
 * Enable taxonomy reference location field to the 'Edit' term page.
 *
 * @since 1.0
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_location_secondary_reference_address_meta_field( $term ) {
	$term_id = $term->term_id;
	$theme_location_secondary_reference_address = '';

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$location_secondary_reference_address = isset( $term_meta['term_location_secondary_reference_address'] ) ? esc_attr( $term_meta['term_location_secondary_reference_address'] ) : $theme_location_secondary_reference_address;
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[term_location_secondary_reference_address]">
				<?php esc_html_e( 'Set a secondary reference location (address) for this region', 'listar' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="term_meta[term_location_secondary_reference_address]" class="listar-term-location-secondary-reference-address" id="term_meta[term_location_secondary_reference_address]" value="<?php echo esc_attr( $location_secondary_reference_address ); ?>">
			<?php wp_nonce_field( 'term-location-secondary-reference-address-nonce-action', 'term-location-secondary-reference-address-nonce' ); ?>
			<div class="listar-geolocation-result-info">
				<strong class="listar-is-geolocated">
					<?php esc_html_e( "All right, this address is geolocated.", 'listar' ); ?><br>
				</strong>
				<strong class="listar-is-not-geolocated">
					<?php esc_html_e( "This address could not be geolocated.", 'listar' ); ?><br>
				</strong>
			</div>
			<p class="description">
				<?php esc_html_e( "Please insert the full address and number of a very popular place.", 'listar' ); ?><br>
				<?php esc_html_e( "Example of full address: 5905 Wilshire Boulevard, Los Angeles, CA 90036, USA", 'listar' ); ?>
			</p>
		</td>
	</tr>
	<?php
}

/**
 * Saves a term reference location.
 *
 * @since 1.0
 * @param (integer) $term_id The term ID.
 */
function listar_save_taxonomy_custom_location_secondary_reference_address_meta( $term_id ) {
	$nonce = filter_input( INPUT_POST, 'term-location-secondary-reference-address-nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$nonce_verify = ! empty( $nonce ) && wp_verify_nonce( $nonce, 'term-location-secondary-reference-address-nonce-action' );

	if ( $nonce_verify && isset( $_POST['term_meta'] ) ) {

		$post_meta     = array_map( 'sanitize_text_field', wp_unslash( $_POST['term_meta'] ) );
		$term_meta     = get_option( "taxonomy_$term_id" );
		$category_keys = array_keys( $post_meta );

		foreach ( $category_keys as $key ) {
			if ( isset( $post_meta[ $key ] ) ) {
				$temp = isset( $term_meta[ $key ] ) ? $term_meta[ $key ] : '';
				$term_meta[ $key ] = ( 'term_location_secondary_reference_address' === $key ) ? wp_filter_nohtml_kses( $post_meta[ $key ] ) : $temp;

				if ( 'term_location_secondary_reference_address' === $key  ) {
					$new_lat = '';
					$new_lng = '';
					
					if ( ! empty( $post_meta[ $key ] ) ) {
						$geo = listar_get_geolocated_data_by_address( $term_meta[ $key ] );

						if ( ! empty( $geo ) ) {
							$new_lat = $geo['geolocation_lat'];
							$new_lng = $geo['geolocation_long'];
						}
					}

					$term_meta['term_location_secondary_reference_latitude']  = $new_lat;
					$term_meta['term_location_secondary_reference_longitude'] = $new_lng;
				}
			}
		}

		/* Save the option array */
		update_option( "taxonomy_$term_id", $term_meta );
	}
}


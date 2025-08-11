<?php
/**
 * Enable reference location (label) to terms from WP Job Manager (regions)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_location_primary_reference_label_init', 'listar_taxonomy_location_primary_reference_label' );

if ( ! function_exists( 'listar_taxonomy_location_primary_reference_label' ) ) :
	/**
	 * Enable taxonomy reference location.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_location_primary_reference_label() {

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_location_primary_reference_label_meta_field', 10, 2 );

		/* Sanitize and save when creating or editing */
		add_action( 'edited_job_listing_region', 'listar_save_taxonomy_custom_location_primary_reference_label_meta', 10, 2 );
		add_action( 'create_job_listing_region', 'listar_save_taxonomy_custom_location_primary_reference_label_meta', 10, 2 );
	}

endif;

/**
 * Enable taxonomy reference location field to the 'Edit' term page.
 *
 * @since 1.0
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_location_primary_reference_label_meta_field( $term ) {
	$term_id = $term->term_id;
	$theme_location_primary_reference_label = '';

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$location_primary_reference_label = isset( $term_meta['term_location_primary_reference_label'] ) ? esc_attr( $term_meta['term_location_primary_reference_label'] ) : $theme_location_primary_reference_label;
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[term_location_primary_reference_label]">
				<?php esc_html_e( 'Public label for primary reference location', 'listar' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="term_meta[term_location_primary_reference_label]" class="listar-term-location-primary-reference-label" id="term_meta[term_location_primary_reference_label]" value="<?php echo esc_attr( $location_primary_reference_label ); ?>">
			<?php wp_nonce_field( 'term-location-primary-reference-label-nonce-action', 'term-location-primary-reference-label-nonce' ); ?>
			<p class="description">
				<?php esc_html_e( "Example: Los Angeles Museum", 'listar' ); ?>
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
function listar_save_taxonomy_custom_location_primary_reference_label_meta( $term_id ) {
	$nonce = filter_input( INPUT_POST, 'term-location-primary-reference-label-nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$nonce_verify = ! empty( $nonce ) && wp_verify_nonce( $nonce, 'term-location-primary-reference-label-nonce-action' );

	if ( $nonce_verify && isset( $_POST['term_meta'] ) ) {

		$post_meta     = array_map( 'sanitize_text_field', wp_unslash( $_POST['term_meta'] ) );
		$term_meta     = get_option( "taxonomy_$term_id" );
		$category_keys = array_keys( $post_meta );

		foreach ( $category_keys as $key ) {
			if ( isset( $post_meta[ $key ] ) ) {
				$temp = isset( $term_meta[ $key ] ) ? $term_meta[ $key ] : '';
				$term_meta[ $key ] = ( 'term_location_primary_reference_label' === $key ) ? wp_filter_nohtml_kses( $post_meta[ $key ] ) : $temp;
			}
		}

		/* Save the option array */
		update_option( "taxonomy_$term_id", $term_meta );
	}
}

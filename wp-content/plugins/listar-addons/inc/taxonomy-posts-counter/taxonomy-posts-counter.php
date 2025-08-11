<?php
/**
 * Enable post counter to terms from WP Job Manager (categories, regions and amenities)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_post_counter_init', 'listar_taxonomy_post_counter' );

if ( ! function_exists( 'listar_taxonomy_post_counter' ) ) :
	/**
	 * Enable post counter to taxonomy terms.
	 *
	 * @since 1.3.9
	 */
	function listar_taxonomy_post_counter() {

		/* Enable it on 'Add New' term page */
		add_action( 'job_listing_region_add_form_fields', 'listar_taxonomy_add_new_post_counter_meta_field', 10, 2 );
		add_action( 'job_listing_category_add_form_fields', 'listar_taxonomy_add_new_post_counter_meta_field', 10, 2 );
		add_action( 'job_listing_amenity_add_form_fields', 'listar_taxonomy_add_new_post_counter_meta_field', 10, 2 );

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_post_counter_meta_field', 10, 2 );
		add_action( 'job_listing_category_edit_form_fields', 'listar_taxonomy_edit_post_counter_meta_field', 10, 2 );
		add_action( 'job_listing_amenity_edit_form_fields', 'listar_taxonomy_edit_post_counter_meta_field', 10, 2 );

		/* Sanitize and save post counter when creating or editing */
		add_action( 'edited_job_listing_region', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'create_job_listing_region', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'delete_job_listing_region', 'listar_delete_taxonomy_custom_post_counter_meta', 10, 4 );
		add_action( 'edited_job_listing_category', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'create_job_listing_category', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'delete_job_listing_category', 'listar_delete_taxonomy_custom_post_counter_meta', 10, 4 );
		add_action( 'edited_job_listing_amenity', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'create_job_listing_amenity', 'listar_save_taxonomy_custom_post_counter_meta', 10, 2 );
		add_action( 'delete_job_listing_amenity', 'listar_delete_taxonomy_custom_post_counter_meta', 10, 4 );
	}

endif;

/**
 * Enable post counter to the 'Add New' term page.
 *
 * @since 1.3.9
 */
function listar_taxonomy_add_new_post_counter_meta_field() {
	?>
	<div class="form-field hidden">
		<input type="text" name="term_meta[post_counter]" id="term_meta[post_counter]" value="0">
		<?php wp_nonce_field( 'term-post-counter-nonce-action', 'term-post-counter-nonce' ); ?>
	</div>
	<?php
}

/**
 * Enable post counter to the 'Edit' term page.
 *
 * @since 1.3.9
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_post_counter_meta_field( $term ) {
	$term_id = $term->term_id;

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$value = isset( $term_meta['post_counter'] ) ? esc_attr( $term_meta['post_counter'] ) : 0;
	?>
	<tr class="form-field hidden">
		<td>
			<input type="text" name="term_meta[post_counter]" id="term_meta[post_counter]" value="<?php echo esc_attr( $value ); ?>">
			<?php wp_nonce_field( 'term-post-counter-nonce-action', 'term-post-counter-nonce' ); ?>
		</td>
	</tr>
	<?php
}

/**
 * Saves a term post counter.
 *
 * @since 1.3.9
 * @param (integer) $term_id The term ID.
 */
function listar_save_taxonomy_custom_post_counter_meta( $term_id, $tt_id ) {
	$nonce = filter_input( INPUT_POST, 'term-post-counter-nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$nonce_verify = ! empty( $nonce ) && wp_verify_nonce( $nonce, 'term-post-counter-nonce-action' );

	if ( $nonce_verify && isset( $_POST['term_meta'] ) ) {
		
		$id = ! empty( $tt_id ) ? $tt_id : ( ! empty( $term_id ) ? $term_id : 0 );
		
		// Update post counters for all terms of this taxonomy.
		listar_update_post_counters_for_taxonomy_terms( $id );
	}
}

/**
 * Fires after delete a term post counter.
 *
 * @since 1.3.9
 * @param (integer) $term_id The term ID.
 * @param (integer) $tt_id   Term taxonomy ID.
 * @param (mixed) $deleted_term Copy of the already-deleted term, in the form specified by the parent function. WP_Error otherwise.
 * @param (array) $object_ids List of term object IDs.
 */
function listar_delete_taxonomy_custom_post_counter_meta( $term_id, $tt_id, $deleted_term, $object_ids ) {
	
	/* By unknown reason (it was tested), nounce verification won't work for 'delete_<$taxonomy>' action in special (exclusivelly)! */

	$id = ! empty( $tt_id ) ? $tt_id : ( ! empty( $term_id ) ? $term_id : 0 );

	$taxonomy_slug = isset( $deleted_term->taxonomy ) ? $deleted_term->taxonomy : '';

	// Update post counters for all terms of this taxonomy.
	listar_update_post_counters_for_taxonomy_terms( $id, $taxonomy_slug );
}

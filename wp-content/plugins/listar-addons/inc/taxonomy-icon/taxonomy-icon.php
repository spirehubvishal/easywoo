<?php
/**
 * Enable icon selection/upload to terms from WP Job Manager listing categories and amenities
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_icon_init', 'listar_taxonomy_icon' );

if ( ! function_exists( 'listar_taxonomy_icon' ) ) :
	/**
	 * Enable taxonomy icons.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_icon() {

		/* Enable it on 'Add New' term page */
		add_action( 'job_listing_amenity_add_form_fields', 'listar_taxonomy_add_new_meta_field', 10, 2 );
		add_action( 'job_listing_category_add_form_fields', 'listar_taxonomy_add_new_meta_field', 10, 2 );

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_amenity_edit_form_fields', 'listar_taxonomy_edit_meta_field', 10, 2 );
		add_action( 'job_listing_category_edit_form_fields', 'listar_taxonomy_edit_meta_field', 10, 2 );

		/* Sanitize and save icon when creating or editing */
		add_action( 'edited_job_listing_amenity', 'listar_save_taxonomy_custom_meta', 10, 2 );
		add_action( 'create_job_listing_amenity', 'listar_save_taxonomy_custom_meta', 10, 2 );
		add_action( 'edited_job_listing_category', 'listar_save_taxonomy_custom_meta', 10, 2 );
		add_action( 'create_job_listing_category', 'listar_save_taxonomy_custom_meta', 10, 2 );
	}

endif;

/**
 * Enable icon field to the 'Add New' term page.
 *
 * @since 1.0
 */
function listar_taxonomy_add_new_meta_field() {
	wp_enqueue_media();
	?>
	<div class="form-field">
		<label for="term_meta[term_icon]">
			<?php esc_html_e( 'Set a Icon', 'listar' ); ?>
		</label>
		<input type="text" name="term_meta[term_icon]" id="term_meta[term_icon]" value="" placeholder="Ex.: icon-star, fa fa-star">
		<?php wp_nonce_field( 'term-icon-nonce-action', 'term-icon-nonce' ); ?>
	</div>
	<?php
}

/**
 * Enable icon field to the 'Edit' term page.
 *
 * @since 1.0
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_meta_field( $term ) {
	wp_enqueue_media();
	$term_id = $term->term_id;

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$icon = isset( $term_meta['term_icon'] ) ? esc_attr( $term_meta['term_icon'] ) : '';
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[term_icon]">
				<?php esc_html_e( 'Set a Icon', 'listar' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="term_meta[term_icon]" id="term_meta[term_icon]" value="<?php echo esc_attr( $icon ); ?>" placeholder="Ex.: icon-star, fa fa-star">
			<?php wp_nonce_field( 'term-icon-nonce-action', 'term-icon-nonce' ); ?>
		</td>
	</tr>
	<?php
}

/**
 * Saves a term icon.
 *
 * @since 1.0
 * @param (integer) $term_id The term ID.
 */
function listar_save_taxonomy_custom_meta( $term_id ) {
	$nonce = filter_input( INPUT_POST, 'term-icon-nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$nonce_verify = ! empty( $nonce ) && wp_verify_nonce( $nonce, 'term-icon-nonce-action' );

	if ( $nonce_verify && isset( $_POST['term_meta'] ) ) {

		$post_meta     = array_map( 'sanitize_text_field', wp_unslash( $_POST['term_meta'] ) );
		$term_meta     = get_option( "taxonomy_$term_id" );
		$category_keys = array_keys( $post_meta );

		foreach ( $category_keys as $key ) {
			if ( isset( $post_meta[ $key ] ) ) {
				$term_meta[ $key ] = ( 'term_icon' === $key ) ? wp_filter_nohtml_kses( $post_meta[ $key ] ) : $post_meta[ $key ];
			}
		}

		/* Save the option array */
		update_option( "taxonomy_$term_id", $term_meta );
	}
}

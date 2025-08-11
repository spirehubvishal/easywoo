<?php
/**
 * Enable color to terms from WP Job Manager (categories and regions)
 *
 * @package Listar_Addons
 */

add_action( 'listar_taxonomy_color_init', 'listar_taxonomy_color' );

if ( ! function_exists( 'listar_taxonomy_color' ) ) :
	/**
	 * Enable taxonomy colors.
	 *
	 * @since 1.0
	 */
	function listar_taxonomy_color() {

		/* Enable it on 'Add New' term page */
		add_action( 'job_listing_region_add_form_fields', 'listar_taxonomy_add_new_color_meta_field', 10, 2 );
		add_action( 'job_listing_category_add_form_fields', 'listar_taxonomy_add_new_color_meta_field', 10, 2 );
		add_action( 'job_listing_amenity_add_form_fields', 'listar_taxonomy_add_new_color_meta_field', 10, 2 );

		/* Enable it on 'Edit' term page */
		add_action( 'job_listing_region_edit_form_fields', 'listar_taxonomy_edit_color_meta_field', 10, 2 );
		add_action( 'job_listing_category_edit_form_fields', 'listar_taxonomy_edit_color_meta_field', 10, 2 );
		add_action( 'job_listing_amenity_edit_form_fields', 'listar_taxonomy_edit_color_meta_field', 10, 2 );

		/* Sanitize and save color when creating or editing */
		add_action( 'edited_job_listing_region', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
		add_action( 'create_job_listing_region', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
		add_action( 'edited_job_listing_category', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
		add_action( 'create_job_listing_category', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
		add_action( 'edited_job_listing_amenity', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
		add_action( 'create_job_listing_amenity', 'listar_save_taxonomy_custom_color_meta', 10, 2 );
	}

endif;

/**
 * Enable color field to the 'Add New' term page.
 *
 * @since 1.0
 */
function listar_taxonomy_add_new_color_meta_field() {
	wp_enqueue_media();
	$theme_color = listar_theme_color();
	?>
	<div class="form-field">
		<label for="term_meta[term_color]">
			<?php esc_html_e( 'Set a Color', 'listar' ); ?>
		</label>
		<input type="text" name="term_meta[term_color]" id="term_meta[term_color]" class="wp-color-picker" value="<?php echo esc_attr( $theme_color ); ?>" placeholder="Ex.: #258bd5">
		<?php wp_nonce_field( 'term-color-nonce-action', 'term-color-nonce' ); ?>
	</div>
	<?php
}

/**
 * Enable color field to the 'Edit' term page.
 *
 * @since 1.0
 * @param (object) $term A taxonomy term object.
 */
function listar_taxonomy_edit_color_meta_field( $term ) {
	wp_enqueue_media();
	$term_id = $term->term_id;
	$theme_color = listar_theme_color();

	/* Retrieve the existing value(s) for this meta field (array) */
	$term_meta = get_option( "taxonomy_$term_id" );
	$color = isset( $term_meta['term_color'] ) ? esc_attr( $term_meta['term_color'] ) : $theme_color;

	if ( false === strpos( $color, '#' ) ) :
		$color = '#' . $color;
	endif;
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[term_color]">
				<?php esc_html_e( 'Set a Color', 'listar' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="term_meta[term_color]" id="term_meta[term_color]" class="wp-color-picker" value="<?php echo esc_attr( $color ); ?>" placeholder="Ex.: #258bd5">
			<?php wp_nonce_field( 'term-color-nonce-action', 'term-color-nonce' ); ?>
		</td>
	</tr>
	<?php
}

/**
 * Saves a term color.
 *
 * @since 1.0
 * @param (integer) $term_id The term ID.
 */
function listar_save_taxonomy_custom_color_meta( $term_id ) {
	$nonce = filter_input( INPUT_POST, 'term-color-nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$nonce_verify = ! empty( $nonce ) && wp_verify_nonce( $nonce, 'term-color-nonce-action' );

	if ( $nonce_verify && isset( $_POST['term_meta'] ) ) {

		$post_meta     = array_map( 'sanitize_text_field', wp_unslash( $_POST['term_meta'] ) );
		$term_meta     = get_option( "taxonomy_$term_id" );
		$category_keys = array_keys( $post_meta );

		foreach ( $category_keys as $key ) {
			if ( isset( $post_meta[ $key ] ) ) {
				$term_meta[ $key ] = ( 'term_color' === $key ) ? wp_filter_nohtml_kses( $post_meta[ $key ] ) : $post_meta[ $key ];
			}
		}

		/* Save the option array */
		update_option( "taxonomy_$term_id", $term_meta );
	}
}

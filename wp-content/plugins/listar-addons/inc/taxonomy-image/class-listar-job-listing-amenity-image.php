<?php
/**
 * Class to enable image upload to WP Job Manager listing amenities
 *
 * @package Listar_Addons
 */

add_action( 'listar_job_listing_amenity_image_init', 'listar_job_listing_amenity_image_instance' );

if ( ! function_exists( 'listar_job_listing_amenity_image_instance' ) ) :
	/**
	 * Create an instance for this class.
	 *
	 * @since 1.0
	 */
	function listar_job_listing_amenity_image_instance() {

		$instance = new Listar_Job_Listing_Amenity_Image();
		$instance->init();
	}

endif;


if ( ! class_exists( 'Listar_Job_Listing_Amenity_Image' ) ) {
	/**
	 * The class for listing amenity image
	 *
	 * @since 1.0
	 */
	class Listar_Job_Listing_Amenity_Image {
		/**
		 * Setup the image field for taxonomy terms.
		 *
		 * @since 1.0
		 */
		public function init() {

			/* Check if is editing job listing amenity */
			add_action( 'current_screen', array( $this, 'is_editing_job_listing_amenity' ), 10 );

			/* Add the field to 'Add New' Amenity' term page */
			add_action( 'job_listing_amenity_add_form_fields', array( $this, 'job_listing_amenity_taxonomy_add_new_meta_field' ), 10, 2 );

			/* Add the field to term 'Edit' page */
			add_action( 'job_listing_amenity_edit_form_fields', array( $this, 'job_listing_amenity_taxonomy_edit_meta_field' ), 10, 2 );

			/* Execute the callback if creating or editing terms */
			add_action( 'edited_job_listing_amenity', array( $this, 'job_listing_amenity_save_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_job_listing_amenity', array( $this, 'job_listing_amenity_save_taxonomy_custom_meta' ), 10, 2 );
		}

		/**
		 * Check if is editing a term.
		 *
		 * @since 1.0
		 */
		public function is_editing_job_listing_amenity() {

			$screen = get_current_screen();

			if ( 'edit-job_listing_amenity' === $screen->id ) {
				add_action( 'admin_footer', array( $this, 'add_script' ) );
				wp_enqueue_media();
			}
		}

		/**
		 * Outputs JavaScript to handle WordPress Media uploads.
		 *
		 * @since 1.0
		 */
		public function add_script() {

			$upload_button_css_selector = '.ct_tax_media_button.button, #job_listing_amenity-image-wrapper img';
			$image_wrapper_id = '#job_listing_amenity-image-wrapper';
			$value_field_id = '#job_listing_amenity-image-id';

			/* This function is declared in functions.php */
			listar_upload_image_script_output( $upload_button_css_selector, $image_wrapper_id, $value_field_id );
		}

		/**
		 * Add input field to 'Add New' term page.
		 *
		 * @since 1.0
		 */
		public function job_listing_amenity_taxonomy_add_new_meta_field() {
			?>
			<div class="form-field term-group">
				<label for="job_listing_amenity-image-id">
					<?php esc_html_e( 'Image', 'listar' ); ?>
				</label>
				<input type="hidden" id="job_listing_amenity-image-id" name="job_listing_amenity-image-id" class="custom_media_url" value="">
				<div id="job_listing_amenity-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'listar' ); ?>" />
					<input type="button" class="button button-secondary ct_tax_media_remove hidden" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'listar' ); ?>" />
				</p>
			</div>
			<?php
		}

		/**
		 * Add input field to term 'Edit' page.
		 *
		 * @since 1.0
		 * @param (object) $term A 'job listing amenity' term object.
		 */
		public function job_listing_amenity_taxonomy_edit_meta_field( $term ) {

			$image_id = get_term_meta( $term->term_id, 'job_listing_amenity-image-id', true );
			$hidden = empty( $image_id ) ? 'hidden' : '';
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="job_listing_amenity-image-id">
						<?php esc_html_e( 'Image', 'listar' ); ?>
					</label>
				</th>
				<td>
					<input type="hidden" id="job_listing_amenity-image-id" name="job_listing_amenity-image-id" value="<?php echo esc_attr( $image_id ); ?>">
					<div id="job_listing_amenity-image-wrapper">
						<?php
						if ( $image_id ) :
							echo wp_get_attachment_image( $image_id, 'listar-thumbnail' );
						endif;
						?>
					</div>
					<p>
						<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'listar' ); ?>" />
						<input type="button" class="button button-secondary ct_tax_media_remove <?php echo esc_attr( listar_sanitize_html_class( $hidden ) ); ?>" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'listar' ); ?>" />
					</p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Execute this 'update' callback if creating or editing terms.
		 *
		 * @since 1.0
		 * @param (integer) $term_id The term ID.
		 */
		public function job_listing_amenity_save_taxonomy_custom_meta( $term_id ) {
			
			/* Proceed only if not Quick Edit */
			if ( filter_has_var( INPUT_POST, 'job_listing_amenity-image-id' ) ) {
				$amenity_image_id = filter_input( INPUT_POST, 'job_listing_amenity-image-id' );

				if ( ! empty( $amenity_image_id ) ) {
					update_term_meta( $term_id, 'job_listing_amenity-image-id', $amenity_image_id );
				} else {
					update_term_meta( $term_id, 'job_listing_amenity-image-id', '' );
				}

				flush_rewrite_rules();
			}
		}

	}

} // End if().

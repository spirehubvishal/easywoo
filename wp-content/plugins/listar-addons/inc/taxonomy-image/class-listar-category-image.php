<?php
/**
 * Class to enable image upload to blog categories
 *
 * @package Listar_Addons
 */

add_action( 'listar_category_image_init', 'listar_category_image_instance' );

if ( ! function_exists( 'listar_category_image_instance' ) ) :
	/**
	 * Create an instance for this class.
	 *
	 * @since 1.0
	 */
	function listar_category_image_instance() {

		$instance = new Listar_Category_Image();
		$instance->init();
	}

endif;

if ( ! class_exists( 'Listar_Category_Image' ) ) {
	/**
	 * The class for blog category image
	 *
	 * @since 1.0
	 */
	class Listar_Category_Image {
		/**
		 * Setup the image field for taxonomy terms.
		 *
		 * @since 1.0
		 */
		public function init() {

			/* Check if is editing category */
			add_action( 'current_screen', array( $this, 'is_editing_category' ), 10 );

			/* Add the field to 'Add New' term page */
			add_action( 'category_add_form_fields', array( $this, 'category_taxonomy_add_new_meta_field' ), 10, 2 );

			/* Add the field to term 'Edit' page */
			add_action( 'category_edit_form_fields', array( $this, 'category_taxonomy_edit_meta_field' ), 10, 2 );

			/* Execute the callback if creating or editing terms */
			add_action( 'edited_category', array( $this, 'category_save_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_category', array( $this, 'category_save_taxonomy_custom_meta' ), 10, 2 );
		}

		/**
		 * Check if is editing a term.
		 *
		 * @since 1.0
		 */
		public function is_editing_category() {

			$screen = get_current_screen();

			if ( 'edit-category' === $screen->id ) {
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

			$upload_button_css_selector = '.ct_tax_media_button.button, #category-image-wrapper img';
			$image_wrapper_id           = '#category-image-wrapper';
			$value_field_id             = '#category-image-id';

			/* This function is declared in functions.php */
			listar_upload_image_script_output( $upload_button_css_selector, $image_wrapper_id, $value_field_id );
		}

		/**
		 * Add input field to 'Add New' term page.
		 *
		 * @since 1.0
		 */
		public function category_taxonomy_add_new_meta_field() {
			?>
			<div class="form-field term-group">
				<label for="category-image-id">
					<?php esc_html_e( 'Image', 'listar' ); ?>
				</label>
				<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
				<div id="category-image-wrapper"></div>
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
		 * @param (object) $term A 'blog category' term object.
		 */
		public function category_taxonomy_edit_meta_field( $term ) {

			$image_id = get_term_meta( $term->term_id, 'category-image-id', true );
			$hidden   = empty( $image_id ) ? 'hidden' : '';
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category-image-id">
						<?php esc_html_e( 'Image', 'listar' ); ?>
					</label>
				</th>
				<td>
					<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo esc_attr( $image_id ); ?>">
					<div id="category-image-wrapper">
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
		public function category_save_taxonomy_custom_meta( $term_id ) {
			
			/* Proceed only if not Quick Edit */
			if ( filter_has_var( INPUT_POST, 'category-image-id' ) ) {
				$category_image_id = (int) filter_input( INPUT_POST, 'category-image-id', FILTER_VALIDATE_INT );

				if ( ! empty( $category_image_id ) ) {
					update_term_meta( $term_id, 'category-image-id', $category_image_id );
				} else {
					update_term_meta( $term_id, 'category-image-id', '' );
				}

				flush_rewrite_rules();
			} 
		}

	}

} // End if().

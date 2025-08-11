<?php
/**
 * Multi-select Control for WordPress Customizer
 *
 * @package Listar
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Class to create a custom multiselect dropdown control.
	 *
	 * @since 1.0
	 */
	class Listar_Multiple_Select_Control extends WP_Customize_Control {
		/**
		 * The type value
		 *
		 * @var $type Type value for this control.
		 *
		 * @since 1.0
		 */
		public $type = 'multiple-select';

		/**
		 * Render the content on the theme customizer page
		 *
		 * @since 1.0
		 */
		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>
			<p class="description customize-control-description"><?php echo wp_kses( $this->description, 'listar-basic-html' ); ?></p><br />
				<select <?php $this->link(); ?> multiple="multiple" size="25">
					<?php
					foreach ( $this->choices as $value => $label ) :
						$selected = ( in_array( $value, $this->value(), true ) ) ? selected( 1, 1, false ) : '';
						?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $selected ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
						<?php
					endforeach;
					?>
				</select>
			</label>
			<?php
		}
	}
}// End if().

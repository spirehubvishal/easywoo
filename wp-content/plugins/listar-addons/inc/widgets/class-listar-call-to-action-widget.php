<?php
/**
 * Widget to display a 'call to action' section
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Call_To_Action_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Call to Action', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display an eye catching section with linkable button', 'listar' ),
		);

		parent::__construct( 'listar_call_to_action', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$title               = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$subtitle            = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$heading_img_id      = ! empty( $instance['heading_img'] ) ? (int) $instance['heading_img'] : '';
		$heading_img         = ! empty( $heading_img_id ) ? wp_get_attachment_image_src( $heading_img_id, 'listar-thumbnail' ) : false;
		$conditions          = false !== $heading_img && isset( $heading_img[0] ) && ! empty( $heading_img[0] );
		$heading_img_url     = $conditions ? $heading_img[0] : '';
		$heading_img_width   = ! empty( $instance['heading_img_width'] ) ? (int) $instance['heading_img_width'] : 165;
		$background_id       = ! empty( $instance['background_img'] ) ? (int) $instance['background_img'] : '';
		$background_img      = ! empty( $background_id ) ? wp_get_attachment_image_src( $background_id, 'listar-thumbnail' ) : false;
		$conditions_2        = false !== $background_img && isset( $background_img[0] ) && ! empty( $background_img[0] );
		$background_img_url  = $conditions_2 ? $background_img[0] : '';
		$horizontal_bg_align = ! empty( $instance['horizontal_bg_align'] ) ? $instance['horizontal_bg_align'] : 'center';
		$vertical_bg_align   = ! empty( $instance['vertical_bg_align'] ) ? $instance['vertical_bg_align'] : 'center';
		$link                = ! empty( $instance['link'] ) ? $instance['link'] : '';
		$button_text         = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
		$description         = ! empty( $instance['description'] ) ? $instance['description'] : '';
		$design              = ! empty( $instance['design'] ) ? $instance['design'] : 'wavy-badge';
		$content_alignment   = ! empty( $instance['alignment'] ) ? $instance['alignment'] : 'center';
		$button_hover_color  = ! empty( $instance['button_hover_color'] ) ? $instance['button_hover_color'] : 'default';
		$fallback_bg_color   = ! empty( $instance['fallback_bg_color'] ) ? $instance['fallback_bg_color'] : 'dark';
		$animate_wavy_badge  = '';
		$use_bubble_effect   = '';
		$url_new_tab         = false;

		if ( ! empty( $instance['animate_wavy_badge'] ) ) :
			$animate_wavy_badge = 1 === (int) $instance['animate_wavy_badge'] ? 'checked' : '';
		endif;

		if ( ! empty( $instance['use_bubble_effect'] ) ) :
			$use_bubble_effect = 1 === (int) $instance['use_bubble_effect'] ? 'checked' : '';
		endif;

		if ( ! empty( $instance['url_new_tab'] ) ) :
			$url_new_tab = 1 === (int) $instance['url_new_tab'] ? 'checked' : '';
		endif;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>">
				<?php esc_html_e( 'Subtitle', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" value="<?php echo esc_attr( $subtitle ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>">
				<?php esc_html_e( 'Link', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" value="<?php echo esc_attr( $link ); ?>">
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'url_new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url_new_tab' ) ); ?>" value="1" <?php echo esc_attr( $url_new_tab ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url_new_tab' ) ); ?>">
				<?php esc_html_e( 'Open link in new tab?', 'listar' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
				<?php esc_html_e( 'Button text', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
				<?php esc_html_e( 'Description', 'listar' ); ?>:
			</label>
			<textarea class="widefat" rows="4" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $description ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'design' ) ); ?>">
				<?php esc_html_e( 'Design', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'design' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'design' ) ); ?>">
				<?php
				$designs = array(
					'default'                              => esc_html( 'Default', 'listar' ),
					'circular'                             => esc_html( 'Circular', 'listar' ),
					'circular-bordered'                    => esc_html( 'Circular with border', 'listar' ),
					'wavy-badge'                           => esc_html( 'Wavy badge', 'listar' ),
					'wavy-badge-bordered'                  => esc_html( 'Wavy badge with border', 'listar' ),
					'2-cols'                               => esc_html( 'Two columns, wide', 'listar' ),
					'2-cols-boxed'                         => esc_html( 'Two columns, boxed', 'listar' ),
					'2-cols-boxed-squared'                 => esc_html( 'Two columns, boxed, with border', 'listar' ),
					'2-cols-boxed-squared-left'            => esc_html( 'Two columns, boxed, open border to left', 'listar' ),
					'2-cols-boxed-squared-right'           => esc_html( 'Two columns, boxed, open border to right', 'listar' ),
					'2-cols-boxed-half-taller'             => esc_html( 'Two half columns, boxed, first column taller', 'listar' ),
					'2-cols-boxed-half-taller-bordered'    => esc_html( 'Two half columns, boxed, first column taller, with border', 'listar' ),
					'2-cols-boxed-half-no-margin'          => esc_html( 'Two half columns, boxed', 'listar' ),
					'2-cols-boxed-half-no-margin-bordered' => esc_html( 'Two half columns, boxed, with border', 'listar' ),
					'2-cols-boxed-half-with-margin'        => esc_html( 'Two half columns, boxed, with margin', 'listar' ),
					'2-cols-boxed-half-with-margin-bordered' => esc_html( 'Two half columns, boxed, with margin, with border', 'listar' ),
				);

				foreach ( $designs as $value => $output ) :
					$selected = $design === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>">
				<?php esc_html_e( 'Content alignment', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alignment' ) ); ?>">
				<?php
				$alignments = array(
					'left'   => esc_html( 'Left', 'listar' ),
					'center' => esc_html( 'Center', 'listar' ),
				);

				foreach ( $alignments as $value => $output ) :
					$selected = $content_alignment === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_hover_color' ) ); ?>">
				<?php esc_html_e( 'Hover color for button', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_hover_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_hover_color' ) ); ?>">
				<?php
				$button_hover_colors = array(
					'default' => esc_html( 'Theme color', 'listar' ),
					'red'     => esc_html( 'Red', 'listar' ),
					'green'   => esc_html( 'Green', 'listar' ),
					'blue'   => esc_html( 'Blue', 'listar' ),
				);

				foreach ( $button_hover_colors as $value => $output ) :
					$selected = $button_hover_color === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<p class="listar-badge-animations">
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'animate_wavy_badge' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animate_wavy_badge' ) ); ?>" value="1" <?php echo esc_attr( $animate_wavy_badge ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'animate_wavy_badge' ) ); ?>">
				<?php esc_html_e( 'Use animations?', 'listar' ); ?>
			</label>
		</p>

		<p class="listar-bubble-effect">
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'use_bubble_effect' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_bubble_effect' ) ); ?>" value="1" <?php echo esc_attr( $use_bubble_effect ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'use_bubble_effect' ) ); ?>">
				<?php esc_html_e( 'Enable colorful bubbles effect for button?', 'listar' ); ?>
			</label>
		</p>

		<div>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'heading_img' ) ); ?>">
					<?php esc_html_e( 'Heading image', 'listar' ); ?>:
				</label>
				<?php
				if ( empty( $heading_img_url ) ) :
					?>
					<div class="adm-pic-wrapper hidden">
						<img id="listar_general_heading_image_image-preview" class="adm-pic-prev" />
					</div>
					<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Heading image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" />&nbsp;
					<input type="button" class="button button-secondary upload-adm-remove hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'heading_img' ) ); ?>"  id="<?php echo esc_attr( $this->get_field_id( 'heading_img' ) ); ?>" class="upload-adm-field" >
					<?php
				else :
					?>
					<div class="adm-pic-wrapper">
						<img class="adm-pic-prev" src="<?php echo esc_url( $heading_img_url ); ?>" />
					</div>
					<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Heading image', 'listar' ); ?>" />&nbsp;
					<input type="button" class="button button-secondary upload-adm-remove" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'heading_img' ) ); ?>"  id="<?php echo esc_attr( $this->get_field_id( 'heading_img' ) ); ?>" class="upload-adm-field" value="<?php echo esc_attr( $heading_img_id ); ?>">
					<?php
				endif;
				?>
			</p>
		</div>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'heading_img_width' ) ); ?>">
				<?php esc_html_e( 'Heading image width', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat call-to-action-heading-img-width-field" id="<?php echo esc_attr( $this->get_field_id( 'heading_img_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading_img_width' ) ); ?>" value="<?php echo esc_attr( $heading_img_width ); ?>"> px
		</p>

		<div>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'background_img' ) ); ?>">
					<?php esc_html_e( 'Background image', 'listar' ); ?>:
				</label>
				<?php
				if ( empty( $background_img_url ) ) :
					?>
					<div class="adm-pic-wrapper hidden">
						<img id="listar_general_background_image-preview" class="adm-pic-prev" />
					</div>
					<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Background image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" />&nbsp;
					<input type="button" class="button button-secondary upload-adm-remove hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'background_img' ) ); ?>"  id="<?php echo esc_attr( $this->get_field_id( 'background_img' ) ); ?>" class="upload-adm-field" >
					<?php
				else :
					?>
					<div class="adm-pic-wrapper">
						<img class="adm-pic-prev" src="<?php echo esc_url( $background_img_url ); ?>" />
					</div>
					<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Background image', 'listar' ); ?>" />&nbsp;
					<input type="button" class="button button-secondary upload-adm-remove" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'background_img' ) ); ?>"  id="<?php echo esc_attr( $this->get_field_id( 'background_img' ) ); ?>" class="upload-adm-field" value="<?php echo esc_attr( $background_id ); ?>">
					<?php
				endif;
				?>
			</p>
		</div>

		<p class="listar-horizontal-bg-align-field">
			<label for="<?php echo esc_attr( $this->get_field_id( 'horizontal_bg_align' ) ); ?>">
				<?php esc_html_e( 'Horizontal starting position for background image', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'horizontal_bg_align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'horizontal_bg_align' ) ); ?>">
				<?php
				$values = array(
					'left'   => esc_html( 'Left', 'listar' ),
					'center' => esc_html( 'Center', 'listar' ),
					'right'  => esc_html( 'Right', 'listar' ),
				);

				foreach ( $values as $value => $output ) :
					$selected = $horizontal_bg_align === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<p class="listar-vertical-bg-align-field">
			<label for="<?php echo esc_attr( $this->get_field_id( 'vertical_bg_align' ) ); ?>">
				<?php esc_html_e( 'Vertical starting position for background image', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vertical_bg_align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vertical_bg_align' ) ); ?>">
				<?php
				$values2 = array(
					'top'    => esc_html( 'Top', 'listar' ),
					'center' => esc_html( 'Center', 'listar' ),
					'bottom' => esc_html( 'Bottom', 'listar' ),
				);

				foreach ( $values2 as $value => $output ) :
					$selected = $vertical_bg_align === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fallback_bg_color' ) ); ?>">
				<?php esc_html_e( 'Fallback background color', 'listar' ); ?>:
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fallback_bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fallback_bg_color' ) ); ?>">
				<?php
				$fallback_bg_colors = array(
					'dark'  => esc_html( 'Dark', 'listar' ),
					'theme' => esc_html( 'Theme color', 'listar' ),
				);

				foreach ( $fallback_bg_colors as $value => $output ) :
					$selected = $fallback_bg_color === $value ? 'selected="selected"' : '';
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $output ); ?>
					</option>
					<?php
				endforeach;
				?>
			</select>
		</p>

		<?php
	}

	/**
	 * Update the widget
	 *
	 * @since 1.0
	 * @param (array) $new_instance The new widget data.
	 * @param (array) $old_instance The old widget data.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                        = $old_instance;
		$instance['title']               = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']            = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['heading_img']         = ! empty( $new_instance['heading_img'] ) ? (int) sanitize_text_field( $new_instance['heading_img'] ) : '';
		$instance['heading_img_width']   = ! empty( $new_instance['heading_img_width'] ) ? (int) sanitize_text_field( $new_instance['heading_img_width'] ) : 165;
		$instance['background_img']      = ! empty( $new_instance['background_img'] ) ? (int) sanitize_text_field( $new_instance['background_img'] ) : '';
		$instance['horizontal_bg_align'] = ! empty( $new_instance['horizontal_bg_align'] ) ? sanitize_text_field( $new_instance['horizontal_bg_align'] ) : 'center';
		$instance['vertical_bg_align']   = ! empty( $new_instance['vertical_bg_align'] ) ? sanitize_text_field( $new_instance['vertical_bg_align'] ) : 'center';
		$instance['link']                = ! empty( $new_instance['link'] ) ? listar_sanitize_url( $new_instance['link'] ) : '';
		$instance['button_text']         = ! empty( $new_instance['button_text'] ) ? sanitize_text_field( $new_instance['button_text'] ) : '';
		$instance['description']         = ! empty( $new_instance['description'] ) ? stripslashes( sanitize_text_field( $new_instance['description'] ) ) : '';
		$instance['design']              = ! empty( $new_instance['design'] ) ? sanitize_text_field( $new_instance['design'] ) : 'wavy-badge';
		$instance['alignment']           = ! empty( $new_instance['alignment'] ) ? sanitize_text_field( $new_instance['alignment'] ) : 'center';
		$instance['button_hover_color']  = ! empty( $new_instance['button_hover_color'] ) ? sanitize_text_field( $new_instance['button_hover_color'] ) : 'default';
		$instance['fallback_bg_color']   = ! empty( $new_instance['fallback_bg_color'] ) ? sanitize_text_field( $new_instance['fallback_bg_color'] ) : 'dark';
		$instance['animate_wavy_badge']  = ! empty( $new_instance['animate_wavy_badge'] ) ? (int) sanitize_text_field( $new_instance['animate_wavy_badge'] ) : '';
		$instance['use_bubble_effect']   = ! empty( $new_instance['use_bubble_effect'] ) ? (int) sanitize_text_field( $new_instance['use_bubble_effect'] ) : '';
		$instance['url_new_tab']         = ! empty( $new_instance['url_new_tab'] ) ? (int) sanitize_text_field( $new_instance['url_new_tab'] ) : '';

		return $instance;
	}

	/**
	 * Front end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $args Arguments to modify the presentation of current widget (like html before and after).
	 * @param (array) $instance The values saved for current widget.
	 */
	public function widget( $args, $instance ) {

		/** As seen in wp-includes/widgets/class-wp-widget-recent-posts.php */
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$get_title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $get_title, $instance, $this->id_base );

		$subtitle            = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$heading_img_id      = ! empty( $instance['heading_img'] ) ? (int) sanitize_text_field( $instance['heading_img'] ) : '';
		$heading_img         = ! empty( $heading_img_id ) ? wp_get_attachment_image_src( $heading_img_id, 'large' ) : false;
		$conditions          = false !== $heading_img && isset( $heading_img[0] ) && ! empty( $heading_img[0] );
		$heading_img_url     = $conditions ? $heading_img[0] : '';
		$heading_img_width   = ! empty( $instance['heading_img_width'] ) ? (int) sanitize_text_field( $instance['heading_img_width'] ) : 165;
		$background_id       = ! empty( $instance['background_img'] ) ? (int) sanitize_text_field( $instance['background_img'] ) : '';
		$background_img      = ! empty( $background_id ) ? wp_get_attachment_image_src( $background_id, 'listar-cover' ) : false;
		$conditions_2        = false !== $background_img && isset( $background_img[0] ) && ! empty( $background_img[0] );
		$background_img_url  = $conditions_2 ? $background_img[0] : '';
		$background_class    = $conditions_2 ? 'listar-fill-background listar-dark-design' : 'listar-color-design';
		$horizontal_bg_align = ! empty( $instance['horizontal_bg_align'] ) ? $instance['horizontal_bg_align'] : 'center';
		$vertical_bg_align   = ! empty( $instance['vertical_bg_align'] ) ? $instance['vertical_bg_align'] : 'center';
		$link                = ! empty( $instance['link'] ) ? $instance['link'] : '';
		$has_button_class    = ! empty( $instance['link'] ) ? 'listar-has-button' : '';
		$button_text         = ! empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'More Info', 'listar' );
		$description         = ! empty( $instance['description'] ) ? $instance['description'] : '';
		$design              = ! empty( $instance['design'] ) ? 'listar-' . $instance['design'] . '-design' : 'listar-wavy-badge-design';
		$content_alignment   = ! empty( $instance['alignment'] ) ? 'listar-align-content-' . $instance['alignment'] : 'listar-align-content-center';
		$button_hover_color  = ! empty( $instance['button_hover_color'] ) ? 'listar-button-hover-color-' . $instance['button_hover_color'] : 'listar-button-hover-color-default';
		$fallback_bg_color   = ! empty( $instance['fallback_bg_color'] ) ? 'listar-background-' . $instance['fallback_bg_color'] . '-color' : 'listar-background-dark-color';
		$alt                 = ! empty( $title ) ? $title : $description;
		$mask_image          = LISTAR_ADDONS_PLUGIN_DIR_URL . 'assets/images/badge-mask.png';
		$animate_wavy_badge  = '';
		$use_bubble_effect   = '';
		$url_new_tab         = '_self';
		$first_content_col   = 'col-sm-12';
		$second_content_col  = 'col-sm-12';
		
		if ( 'listar-circular-design' === $design ) {
			$design = 'listar-wavy-badge-design listar-circular-mask-design';
			$mask_image = LISTAR_ADDONS_PLUGIN_DIR_URL . 'assets/images/circle-mask.png';
		}
		
		if ( 'listar-circular-bordered-design' === $design ) {
			$design = 'listar-wavy-badge-design listar-wavy-badge-bordered-design listar-circular-mask-design';
			$mask_image = LISTAR_ADDONS_PLUGIN_DIR_URL . 'assets/images/circle-mask.png';
		}

		if ( 'listar-wavy-badge-bordered-design' === $design ) {
			$design = 'listar-wavy-badge-design listar-wavy-badge-bordered-design';
		}

		if ( 'listar-2-cols-design' === $design ) {
			$design = 'listar-default-design listar-call-to-action-2-cols';
		}

		if ( false !== strpos( $design, 'listar-2-cols-boxed' ) ) {
			$first_content_col  = 'col-sm-6 col-md-4';
			$second_content_col = 'col-sm-6 col-md-8';
		}

		if ( 'listar-2-cols-boxed-design' === $design ) {
			$design = 'listar-default-design listar-2-cols-boxed-design';
		}

		if ( 'listar-2-cols-boxed-squared-design' === $design ) {
			$design = 'listar-default-design listar-2-cols-boxed-squared-design';
		}

		if ( 'listar-2-cols-boxed-squared-left-design' === $design ) {
			$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-squared-design-left';
		}

		if ( 'listar-2-cols-boxed-squared-right-design' === $design ) {
			$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-squared-design-right';
		}

		if ( false !== strpos( $design, '2-cols-boxed-half' ) ) {
			$first_content_col  = 'col-sm-6';
			$second_content_col = 'col-sm-6';
		}

		if ( false !== strpos( $design, '2-cols-boxed-half' ) && false !== strpos( $design, 'bordered' ) ) {
			if ( false !== strpos( $design, '2-cols-boxed-half-no-margin' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-no-margin listar-2-cols-boxed-half-bordered';
			}

			if ( false !== strpos( $design, '2-cols-boxed-half-with-margin' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-with-margin listar-2-cols-boxed-half-bordered';
			}

			if ( false !== strpos( $design, '2-cols-boxed-half-taller' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-taller listar-2-cols-boxed-half-bordered';
			}
		} elseif ( false !== strpos( $design, '2-cols-boxed-half' ) ) {
			if ( false !== strpos( $design, '2-cols-boxed-half-no-margin' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-no-margin';
			}

			if ( false !== strpos( $design, '2-cols-boxed-half-with-margin' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-with-margin';
			}

			if ( false !== strpos( $design, '2-cols-boxed-half-taller' ) ) {
				$design = 'listar-default-design listar-2-cols-boxed-squared-design listar-2-cols-boxed-half listar-2-cols-boxed-half-taller';
			}
		}

		$listar_blank_placeholder = listar_blank_base64_placeholder_image();

		if ( ! empty( $instance['animate_wavy_badge'] ) ) {
			$animate_wavy_badge = 1 === (int) $instance['animate_wavy_badge'] ? 'listar-animate-wavy-badge' : '';
		}

		if ( ! empty( $instance['use_bubble_effect'] ) ) {
			$use_bubble_effect = 1 === (int) $instance['use_bubble_effect'] ? 'listar-button-bubble-effect' : '';
		}

		if ( ! empty( $instance['url_new_tab'] ) ) {
			$url_new_tab = 1 === (int) $instance['url_new_tab'] ? '_blank' : '_self';
		}

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper <?php echo esc_attr( listar_sanitize_html_class( $background_class . ' ' . $has_button_class . ' ' . $design . ' ' . $content_alignment . ' ' . $button_hover_color . ' ' . $fallback_bg_color . ' ' . $use_bubble_effect ) ); ?>" data-background-image="<?php echo esc_url( $background_img_url ); ?>"  style="background-position:<?php echo esc_attr( $horizontal_bg_align ) . ' ' . esc_attr( $vertical_bg_align ); ?>;">

			<?php
			if ( false !== strpos( $design, 'half' ) ) :
				?>
				<div class="listar-half-call-to-action-bg-image-wrapper">
					<div class="listar-half-call-to-action-bg-image" data-background-image="<?php echo esc_url( $background_img_url ); ?>"  style="background-position:<?php echo esc_attr( $horizontal_bg_align ) . ' ' . esc_attr( $vertical_bg_align ); ?>;"></div>
					<div class="listar-half-call-to-action-border"></div>
				</div>
				<?php
			endif;
			?>

			<?php
			if ( false !== strpos( $design, 'listar-wavy-badge-design' ) ) :
				?>
				<div class="listar-badge-masked-container <?php echo sanitize_html_class( $animate_wavy_badge ); ?>">
					<div class="listar-badge-mask">
						<div class="listar-image-badge-mask-wrapper">
							<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="listar-image-badge-mask" data-background-image="<?php echo esc_url( $mask_image ); ?>" data-force-img="true" width="1140" height="1140" />
						</div>
					</div>
					<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="listar-masked-image listar-no-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $background_img_url ) ); ?>" />
				</div>
				<?php
			endif;
			?>

			<?php
			if ( ! empty( $heading_img_url ) ) :
				?>
				<div class="listar-call-to-action-heading-img listar-heading-img-two-cols">
					<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" alt="<?php echo esc_attr( $alt ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $heading_img_url ) ); ?>" data-force-img="true" style="width: <?php echo esc_attr( $heading_img_width ); ?>px;" />
				</div>
				<?php
			endif;
			?>

			<div class="container listar-call-to-action-wrapper">
				<div class="row">
					<div class="col-sm-12 listar-call-to-action-inner">
						<div class="row">
							<!-- Start first content area -->
							<div class="<?php echo esc_attr( listar_sanitize_html_class( $first_content_col . ' listar-call-to-action-first-content-wrapper' ) ); ?>">
								<?php
								if ( ! empty( $heading_img_url ) ) :
									?>
									<div class="row listar-call-to-action-heading-img listar-default-heading-img">
										<div class="col-sm-12 <?php echo esc_attr( listar_sanitize_html_class( 'listar-equalize-container-height' ) ); ?>">
											<div class="listar-call-to-action-heading-img-inner">
												<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" alt="<?php echo esc_attr( $alt ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $heading_img_url ) ); ?>" data-force-img="true" style="width: <?php echo esc_attr( $heading_img_width ); ?>px;" />
											</div>
										</div>
									</div>
									<?php
								endif;
								?>
							</div>
							<!-- End first content area -->

							<!-- Start second content area -->
							<div class="<?php echo esc_attr( listar_sanitize_html_class( $second_content_col . ' listar-equalize-container-height listar-call-to-action-second-content-wrapper' ) ); ?>">
								<div class="listar-call-to-action-second-content-inner">
									<div class="listar-call-to-action-second-content-info">
										<div class="row">
											<div class="col-sm-12">
												<?php if ( '' !== $title || '' !== $subtitle ) : ?>
													<div class="listar-widget-title-wrapper" data-aos="fade-up">
														<?php
														echo wp_kses( '' !== $title ? $args['before_title'] . esc_html( $title ) . $args['after_title'] : '', 'listar-basic-html' );
														echo wp_kses( '' !== $subtitle ? '<div class="listar-widget-subtitle">' . esc_html( $subtitle ) . '</div>' : '', 'listar-basic-html' );
														?>
													</div>
												<?php endif; ?>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="listar-call-to-action-description" data-aos="fade-up">
													<?php echo esc_html( $description ); ?>
												</div>

												<?php
												if ( ! empty( $link ) ) :
													$button_class = ! empty( $background_img_url ) ? 'listar-light-button' : 'listar-light-button listar-light-hover';
													?>
													<div class="listar-call-to-action-button" data-aos="fade-up">
														<a target="<?php echo esc_attr( $url_new_tab ); ?>" href="<?php echo esc_url( $link ); ?>" class="button listar-cancel-hover-opacity <?php echo esc_attr( listar_sanitize_html_class( $button_class ) ); ?>">
															<?php echo esc_html( $button_text ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End second content area -->
						</div>
					</div>
				</div>
			</div>

		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

register_widget( 'Listar_Call_To_Action_Widget' );

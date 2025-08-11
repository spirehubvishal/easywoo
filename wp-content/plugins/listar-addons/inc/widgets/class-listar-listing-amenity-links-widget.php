<?php
/**
 * Widget to display a list of links to Listing Amenities
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.2.9
 */
class Listar_Listing_amenity_Links_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.2.9
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Listing Amenity Links', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Create links to listing amenities', 'listar' ),
		);

		parent::__construct( 'listar_listing_amenity_links', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.2.9
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$args = array(
			'taxonomy'   => 'job_listing_amenity',
			'hide_empty' => false,
			'number'     => 2000,
			'orderby'    => 'name',
			'order'      => 'ASC',
		);

		$terms = get_terms( $args );

		if ( ! $terms || is_wp_error( $terms ) ) :
			?>
			<p>
				<?php
				printf(
					'<a href="%s" target="_blank">%s</a> %s',
					esc_url( admin_url( '/edit-tags.php?taxonomy=job_listing_amenity&post_type=job_listing' ) ),
					esc_html__( 'Create listing amenitys', 'listar' ),
					esc_html__( 'before using this widget.', 'listar' )
				);
				?>
			</p>
			<?php
		else :

			$title		= ! empty( $instance['title'] ) ? $instance['title'] : '';
			$elements_json  = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
			$force_inline   = '';

			if ( ! empty( $instance['force_inline'] ) ) :
				$force_inline = 1 === (int) $instance['force_inline'] ? 'checked' : '';
			endif;
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Title', 'listar' ); ?>:
				</label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
			</p>

			<p>
				<input type="hidden" class="widefat elements-json" id="<?php echo esc_attr( $this->get_field_id( 'elements_json' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'elements_json' ) ); ?>" value="<?php echo esc_attr( stripslashes( $elements_json ) ); ?>">
			</p>

			<p>
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'force_inline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'force_inline' ) ); ?>" value="1" <?php echo esc_attr( $force_inline ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'force_inline' ) ); ?>">
					<?php esc_html_e( 'Force inline display', 'listar' ); ?>
				</label>
			</p>

			<div class="listar-elements-wrapper">

				<?php
				if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json && $terms ) :

					$elements_array = json_decode( $elements_json, true );
					$count_elements = is_array( $elements_array ) ? count( $elements_array ) : 0;

					for ( $i = 0; $i < $count_elements; $i++ ) :

						$json_term_id = isset( $elements_array[ $i ]['id'] ) ? (int) $elements_array[ $i ]['id'] : '';

						$check_term = get_terms(
							array(
								'taxonomy'   => 'job_listing_amenity',
								'hide_empty' => false,
								'include'    => $json_term_id,
							)
						);

						/* Check if amenity exists */
						if ( ! $check_term || is_wp_error( $check_term ) ) :
							continue;
						endif;
						?>

						<div class="listar-element-data">

							<p>
								<select class="listar-element-data-id widefat" name="listar-element-data-id" >
									<option value="">
										<?php esc_html_e( 'Select a amenity', 'listar' ); ?>
									</option>

									<?php foreach ( $terms as $term ) :
										$selected = $json_term_id === $term->term_id ? 'selected="selected"' : '';
										?>
										<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php echo wp_kses_post( $selected ); ?>>
											<?php echo esc_html( $term->name ); ?>
										</option>
										<?php
									endforeach;
									?>
								</select>
							</p>

							<a href="#" title="<?php esc_attr_e( 'Remove this block', 'listar' ); ?>" class="listar-element-data-remove dashicons dashicons-no" data-remove-confirmation="<?php esc_attr_e( 'Are you sure you want to remove this item?', 'listar' ); ?>"></a>
							<a href="#" title="<?php esc_attr_e( 'Drag this block', 'listar' ); ?>" class="listar-element-data-drag dashicons dashicons-move"></a>
						</div>

					<?php endfor;

				endif;
				?>

				<div class="listar-element-model hidden">

					<p>
						<select class="listar-select-model widefat" name="listar-select-model" >
							<option value="" selected="selected">
								<?php esc_html_e( 'Select a amenity', 'listar' ); ?>
							</option>

							<?php foreach ( $terms as $term ) : ?>
								<option value="<?php echo esc_attr( $term->term_id ); ?>">
									<?php echo esc_html( $term->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</p>

					<a href="#" title="<?php esc_attr_e( 'Remove this block', 'listar' ); ?>" class="listar-element-data-remove dashicons dashicons-no" data-remove-confirmation="<?php esc_attr_e( 'Are you sure you want to remove this item?', 'listar' ); ?>"></a>
					<a href="#" title="<?php esc_attr_e( 'Drag this block', 'listar' ); ?>" class="listar-element-data-drag dashicons dashicons-move"></a>
				</div>

			</div>

			<p>
				<a href="#" class="listar-element-data-add button button-secondary">
					<?php esc_html_e( 'New amenity link', 'listar' ); ?>
				</a>
			</p>

		<?php
		endif;
	}

	/**
	 * Update the widget
	 *
	 * @since 1.2.9
	 * @param (array) $new_instance The new widget data.
	 * @param (array) $old_instance The old widget data.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance		   = $old_instance;
		$instance['title']	   = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['force_inline']  = ! empty( $new_instance['force_inline'] ) ? (int) filter_var( $new_instance['force_inline'], FILTER_VALIDATE_INT ) : '';
		$instance['elements_json'] = ! empty( $new_instance['elements_json'] ) ? sanitize_text_field( $new_instance['elements_json'] ) : '';

		return $instance;
	}

	/**
	 * Front end display of the widget.
	 *
	 * @since 1.2.9
	 * @param (array) $args Arguments to modify the presentation of current widget (like html before and after).
	 * @param (array) $instance The values saved for current widget.
	 */
	public function widget( $args, $instance ) {

		$title		= ! empty( $instance['title'] ) ? $instance['title'] : '';
		$elements_json  = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
		$force_inline   = 'listar-not-inline-list';

		if ( ! empty( $instance['force_inline'] ) ) {
			$force_inline = 1 === (int) $instance['force_inline'] ? 'listar-force-inline' : 'listar-not-inline-list';
		}

		echo wp_kses_post( $args['before_widget'] );
		?>

		<div class="<?php echo esc_attr( listar_sanitize_html_class( $force_inline ) ); ?>">

			<?php
			echo wp_kses_post( '' !== $title ? $args['before_title'] . esc_html( $title ) . $args['after_title'] : '' );

			if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json ) :

				$elements_array = json_decode( $elements_json, true );
				$count_elements = is_array( $elements_array ) ? count( $elements_array ) : 0;

				for ( $i = 0; $i < $count_elements; $i++ ) :

					$json_term_id = isset( $elements_array[ $i ]['id'] ) ? (int) $elements_array[ $i ]['id'] : '';

					$terms = get_terms(
						array(
							'taxonomy'   => 'job_listing_amenity',
							'hide_empty' => false,
							'include'    => $json_term_id,
						)
					);

					if ( $terms && ! is_wp_error( $terms ) ) :
						foreach ( $terms as $term ) :
							?>
							<div class="listar-widget-page-link">
								<a href="<?php echo get_term_link( $term, 'job_listing_amenity' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo esc_html( $term->name ); ?></a>
							</div>
							<?php
						endforeach;
					endif;
					?>

				<?php endfor;

			endif;
			?>
		</div>

		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

}

register_widget( 'Listar_Listing_amenity_Links_Widget' );

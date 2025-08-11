<?php
/**
 * Widget to display 'feature' blocks (highlights)
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Features_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Features', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Create "feature" blocks with images or icons to describe your site', 'listar' ),
		);

		parent::__construct( 'listar_features', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$subtitle      = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$elements_json = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
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
			<input type="hidden" class="widefat elements-json" id="<?php echo esc_attr( $this->get_field_id( 'elements_json' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'elements_json' ) ); ?>" value="<?php echo esc_attr( stripslashes( $elements_json ) ); ?>">
		</p>

		<div class="listar-elements-wrapper">
			<?php
			if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json ) :

				$elements_array = listar_json_decode_nice( $elements_json, true );
				$count = is_array( $elements_array ) ? count( $elements_array ) : 0;

				for ( $i = 0; $i < $count; $i++ ) :

					$media       = isset( $elements_array[ $i ]['media'] ) ? $elements_array[ $i ]['media'] : '';
					$title       = isset( $elements_array[ $i ]['title'] ) ? $elements_array[ $i ]['title'] : '';
					$link        = isset( $elements_array[ $i ]['link'] ) ? $elements_array[ $i ]['link'] : '';
					$description = isset( $elements_array[ $i ]['description'] ) ? $elements_array[ $i ]['description'] : '';
					?>
					<div class="listar-element-data">
						<p>
							<label for="listar-element-data-media">
								<?php esc_html_e( 'Image or icon', 'listar' ); ?>:
							</label>
							<div class="listar-element-data-media-wrapper">
								<input class="widefat listar-element-data-media" type="text" name="listar-element-data-media-<?php echo esc_attr( wp_rand( 0, 99999 ) ); ?>" placeholder="Ex.: icon-star, fa fa-star" value="<?php echo esc_attr( $media ); ?>" >
							</div>
						</p>

						<p>
							<label for="listar-element-data-title">
								<?php esc_html_e( 'Title', 'listar' ); ?>:
							</label>
							<input class="widefat listar-element-data-title" name="listar-element-data-title" type="text" value="<?php echo esc_attr( $title ); ?>">
						</p>

						<p>
							<label for="listar-element-data-link">
								<?php esc_html_e( 'Link', 'listar' ); ?>:
							</label>
							<input class="widefat listar-element-data-link" name="listar-element-data-link" type="text" placeholder="http://" value="<?php echo esc_url( $link ); ?>">
						</p>

						<p>
							<label for="listar-element-data-description">
								<?php esc_html_e( 'Description', 'listar' ); ?>:
							</label>
							<textarea class="widefat listar-element-data-description" name="listar-element-data-description"><?php echo esc_textarea( $description ); ?></textarea>
						</p>

						<a href="#" title="<?php esc_attr_e( 'Remove this block', 'listar' ); ?>" class="listar-element-data-remove dashicons dashicons-no" data-remove-confirmation="<?php esc_attr_e( 'Are you sure you want to remove this item?', 'listar' ); ?>"></a>
						<a href="#" title="<?php esc_attr_e( 'Drag this block', 'listar' ); ?>" class="listar-element-data-drag dashicons dashicons-move"></a>
					</div>
					<?php
				endfor;
			endif;
			?>
		</div>

		<div class="listar-element-model hidden"  >
			<p>
				<label for="listar-element-data-media">
					<?php esc_html_e( 'Image or icon', 'listar' ); ?>:
				</label>
				<div class="listar-element-data-media-wrapper">
					<input class="widefat listar-element-data-media" type="text" name="listar-element-data-media" placeholder="Ex.: icon-star, fa fa-star" value="">
				</div>
			</p>

			<p>
				<label for="listar-element-data-title">
					<?php esc_html_e( 'Title', 'listar' ); ?>:
				</label>
				<input class="widefat listar-element-data-title" name="listar-element-data-title" type="text" value="">
			</p>

			<p>
				<label for="listar-element-data-link">
					<?php esc_html_e( 'Link', 'listar' ); ?>:
				</label>
				<input class="widefat listar-element-data-link" name="listar-element-data-link" type="text" placeholder="http://" value="">
			</p>

			<p>
				<label for="listar-element-data-description">
					<?php esc_html_e( 'Description', 'listar' ); ?>:
				</label>
				<textarea class="widefat listar-element-data-description" name="listar-element-data-description"></textarea>
			</p>

			<a href="#" title="<?php esc_attr_e( 'Remove this block', 'listar' ); ?>" class="listar-element-data-remove dashicons dashicons-no" data-remove-confirmation="<?php esc_attr_e( 'Are you sure you want to remove this item?', 'listar' ); ?>"></a>
			<a href="#" title="<?php esc_attr_e( 'Drag this block', 'listar' ); ?>" class="listar-element-data-drag dashicons dashicons-move"></a>
		</div>

		<p>
			<a href="#" class="listar-element-data-add button button-secondary">
				<?php esc_html_e( 'New feature block', 'listar' ); ?>
			</a>
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

		$instance                  = $old_instance;
		$instance['title']         = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']      = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['elements_json'] = ! empty( $new_instance['elements_json'] ) ? sanitize_textarea_field( $new_instance['elements_json'] ) : '';

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

		$subtitle      = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$design        = 'listar-light-design';
		$shape_design  = 'listar-features-design-2 listar-rounded-features';
		$elements_json = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper listar-widget-features <?php echo esc_attr( listar_sanitize_html_class( $design . ' ' . $shape_design ) ); ?>" data-aos="fade-up">
			<?php
			if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json ) :
				?>
				<!-- Start Features -->
				<div class="container listar-site-features">
					<?php if ( '' !== $title || '' !== $subtitle ) : ?>
						<div class="row" data-aos="fade-up">
							<div class="col-sm-12 listar-widget-title-wrapper">
								<?php
								echo wp_kses( '' !== $title ? $args['before_title'] . esc_html( $title ) . $args['after_title'] : '', 'listar-basic-html' );
								echo wp_kses( '' !== $subtitle ? '<div class="listar-widget-subtitle">' . esc_html( $subtitle ) . '</div>' : '', 'listar-basic-html' );
								?>
							</div>
						</div>
					<?php endif; ?>

					<div class="row listar-feature-items">
						<?php
						$elements_array = listar_json_decode_nice( $elements_json, true );
						$count = is_array( $elements_array ) ? count( $elements_array ) : 0;

						for ( $i = 0; $i < $count; $i++ ) :
							$media       = isset( $elements_array[ $i ]['media'] ) ? listar_icon_class( esc_html( $elements_array[ $i ]['media'] ), true ) : '';
							$no_media    = empty( $media[0] ) && empty( $media[1] ) ? 'listar-feature-without-image' : 'listar-feature-with-image';
							$title       = isset( $elements_array[ $i ]['title'] ) ? $elements_array[ $i ]['title'] : '';
							$link        = isset( $elements_array[ $i ]['link'] ) ? $elements_array[ $i ]['link'] : '';
							$has_link    = ! empty( $link ) ? 'listar-feature-has-link' : 'listar-feature-without-link';
							$description = isset( $elements_array[ $i ]['description'] ) ? $elements_array[ $i ]['description'] : '';
							?>

							<!-- Start How Item Col -->
							<div class="col-xs-12 col-sm-6 col-md-4 listar-feature-item-wrapper <?php echo esc_attr( listar_sanitize_html_class( $no_media ) ); ?>" data-aos="fade-zoom-in" data-aos-group="features">
								<div class="listar-feature-item <?php echo esc_attr( listar_sanitize_html_class( $has_link ) ); ?>">

									<?php if ( ! empty( $link ) ) : ?>
										<a href="<?php echo esc_url( $link ); ?>"></a>
									<?php endif; ?>

									<div class="listar-feature-item-inner">

										<div class="listar-feature-right-border"></div>

										<div class="listar-feature-block-content-wrapper">
											<?php
											if ( is_array( $media ) && 'listar-image-icon' === $media[0] ) :
												$listar_blank_placeholder = listar_blank_base64_placeholder_image();
												$alt = ! empty( $title ) ? $title : $description;
												?>
												<div class="listar-feature-icon-wrapper">
													<div class="listar-feature-icon-inner">
														<div>
															<img alt="<?php echo esc_attr( $alt ); ?>" class="listar-image-icon" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $media[1] ) ); ?>" data-force-img="true" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" />
														</div>
													</div>
												</div>
												<?php
											elseif ( is_array( $media ) && ( ! empty( $media[0] ) || ! empty( $media[1] ) ) ) :
												?>
												<div class="listar-feature-icon-wrapper">
													<div class="listar-feature-icon-inner">
														<div>
															<i class="<?php echo esc_attr( listar_sanitize_html_class( $media[0] ) ); ?>">
																<?php
																/**
																 * Skipping sanitization for SVG code ( This output can contain SVG code or not )
																 * Please check the description for 'listar_icon_output' function in functions.php
																 */
																listar_icon_output( $media[1] );
																?>
															</i>
														</div>
													</div>
												</div>
												<?php
											endif;
											?>

											<div class="listar-feature-content-wrapper">

												<?php if ( ! empty( $title ) ) : ?>
													<div class="listar-feature-item-title">
														<span>
															<?php echo esc_html( $title ); ?>
														</span>
													</div>
												<?php endif; ?>

												<?php if ( ! empty( $description ) ) : ?>
													<div class="listar-feature-item-excerpt">
														<?php echo wp_kses( nl2br( $description ), 'listar-basic-html' ); ?>
													</div>
												<?php endif; ?>

											</div>
										</div>
									</div>
								</div>
								<div class="listar-feature-fix-bottom-padding listar-fix-feature-arrow-button-height"></div>
							</div>
							<!-- End How Item Col -->
							<?php
						endfor;
						?>
					</div>
				</div>
				<!-- End Features -->
				<?php
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

register_widget( 'Listar_Features_Widget' );

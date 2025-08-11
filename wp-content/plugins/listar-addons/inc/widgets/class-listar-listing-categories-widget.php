<?php
/**
 * Widget to display listing categories
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Listing_Categories_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Listing Categories', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display listing categories set on Theme Options', 'listar' ),
		);

		parent::__construct( 'listar_listing_categories', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$args = array(
			'taxonomy'   => 'job_listing_category',
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
					esc_url( admin_url( '/edit-tags.php?taxonomy=job_listing_category&post_type=job_listing' ) ),
					esc_html__( 'Create listing categories', 'listar' ),
					esc_html__( 'before using this widget.', 'listar' )
				);
				?>
			</p>
			<?php
		else :
			$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$subtitle      = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
			$columns       = ! empty( $instance['columns'] ) ? $instance['columns'] : 'default';
			$elements_json = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
			$use_carousel  = '';
			$is_hidden     = '';
			$more_terms    = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'] ? 'checked' : '';

			if ( ! empty( $instance['use_carousel'] ) ) :
				$use_carousel = 1 === (int) $instance['use_carousel'] ? 'checked' : '';
				$is_hidden    = ! empty( $use_carousel ) ? 'hidden' : '';
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

			<p class="listar-create-carousel">
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_carousel' ) ); ?>" value="1" <?php echo esc_attr( $use_carousel ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>">
					<?php esc_html_e( 'If possible, create a carousel', 'listar' ); ?>
				</label>
			</p>

			<p class="listar-columns-width <?php echo esc_attr( listar_sanitize_html_class( $is_hidden ) ); ?>">
				<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>">
					<?php esc_html_e( 'Columns width (Desktop)', 'listar' ); ?>:
				</label>

				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
					<?php
					$values = array( 'default', 'inverse', '50% - 50%', '75% - 25%', '25% - 75%', '33% - 33% - 33%', '25% - 25% - 25% - 25%' );

					foreach ( $values as $value ) :
						$selected = $columns === $value ? 'selected="selected"' : '';

						if ( 'default' === $value ) :
							?>
							<option value="default" <?php echo wp_kses( $selected, 'strip' ); ?>>
								<?php esc_html_e( 'Default', 'listar' ); ?>
							</option>
							<?php
						elseif ( 'inverse' === $value ) :
							?>
							<option value="inverse" <?php echo wp_kses( $selected, 'strip' ); ?>>
								<?php esc_html_e( 'Inverse', 'listar' ); ?>
							</option>
							<?php
						else :
							?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
								<?php echo esc_html( $value ); ?>
							</option>
							<?php
						endif;
						?>

					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<input type="hidden" class="widefat elements-json" id="<?php echo esc_attr( $this->get_field_id( 'elements_json' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'elements_json' ) ); ?>" value="<?php echo esc_attr( stripslashes( $elements_json ) ); ?>">
			</p>

			<div class="listar-elements-wrapper">
				<?php
				if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json && $terms && ! is_wp_error( $terms ) ) :

					$elements_array = json_decode( $elements_json, true );
					$count = is_array( $elements_array ) ? count( $elements_array ) : 0;

					for ( $i = 0; $i < $count; $i++ ) :

						/* Try to get the ID by term slug */
						$term_by_slug = isset( $elements_array[ $i ]['slug'] ) ? get_term_by( 'slug', $elements_array[ $i ]['slug'], 'job_listing_category' ) : false;

						if ( $term_by_slug && ! is_wp_error( $term_by_slug ) ) {
							$json_term_id = (int) $term_by_slug->term_id;
						} else {
							/* Slug is unavailable, use the ID saved on JSON */
							$json_term_id = isset( $elements_array[ $i ]['id'] ) ? (int) $elements_array[ $i ]['id'] : '';
						}

						$check_term = get_terms(
							array(
								'taxonomy'   => 'job_listing_category',
								'hide_empty' => false,
								'include'    => $json_term_id,
							)
						);

						if ( ! $check_term || is_wp_error( $check_term ) ) :
							continue;
						endif;
						?>

						<div class="listar-element-data">
							<p>
								<select class="listar-element-data-id widefat" name="listar-element-data-id" >
									<option value="">
										<?php esc_html_e( 'Select a listing category', 'listar' ); ?>
									</option>
									<?php
									foreach ( $terms as $term ) :
										$selected = $json_term_id === $term->term_id ? 'selected="selected"' : '';
										?>
										<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
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

						<?php
					endfor;
				endif;
				?>

				<div class="listar-element-model hidden">
					<p>
						<select class="listar-select-model widefat" name="listar-select-model" >
							<option value="" selected="selected">
								<?php esc_html_e( 'Select a listing category', 'listar' ); ?>
							</option>

							<?php
							foreach ( $terms as $term ) :
								?>
								<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>">
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

			</div>

			<p>
				<a href="#" class="listar-element-data-add button button-secondary">
					<?php esc_html_e( 'New category block', 'listar' ); ?>
				</a>
			</p>

			<p>
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_terms' ) ); ?>" value="1" <?php echo esc_attr( $more_terms ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>">
					<?php esc_html_e( 'Display button for More Categories', 'listar' ); ?>
				</label>
			</p>
			<?php
		endif;
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
		$instance['columns']       = ! empty( $new_instance['columns'] ) ? sanitize_text_field( $new_instance['columns'] ) : '';
		$instance['elements_json'] = ! empty( $new_instance['elements_json'] ) ? wp_filter_nohtml_kses( $new_instance['elements_json'] ) : '';
		$instance['use_carousel']  = ! empty( $new_instance['use_carousel'] ) ? (int) sanitize_text_field( $new_instance['use_carousel'] ) : '';
		$instance['more_terms']    = isset( $instance['more_terms'] ) && ! empty( $new_instance['more_terms'] ) ? (int) sanitize_text_field( $new_instance['more_terms'] ) : '';

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

		$subtitle       = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$columns        = ! empty( $instance['columns'] ) ? $instance['columns'] : '';
		$elements_json  = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
		$elements_array = array();
		$temp_array     = json_decode( $elements_json, true );
		$use_carousel   = '';
		$more_terms     = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'];

		if ( ! empty( $instance['use_carousel'] ) ) {
			$use_carousel = 1 === (int) $instance['use_carousel'] ? 'listar-use-carousel' : '';
		}

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper listar-term-design-3">
			<?php
			$count = is_array( $temp_array ) ? count( $temp_array ) : 0;

			for ( $i = 0; $i < $count; $i++ ) :

				/* Try to get the ID by term slug */
				$term_by_slug = isset( $temp_array[ $i ]['slug'] ) ? get_term_by( 'slug', $temp_array[ $i ]['slug'], 'job_listing_category' ) : false;

				if ( $term_by_slug && ! is_wp_error( $term_by_slug ) ) {
					$elements_array[ $i ] = (int) $term_by_slug->term_id;
				} elseif ( isset( $temp_array[ $i ]['id'] ) ) {
					/* Slug is unavailable, use the ID saved on JSON */
					$elements_array[ $i ] = (int) $temp_array[ $i ]['id'];
				}
			endfor;

			$terms_args = array(
				'taxonomy'   => 'job_listing_category',
				'hide_empty' => false,
				'number'     => 2000,
				'orderby'    => 'include',
				'include'    => $elements_array,
			);

			$terms = get_terms( $terms_args );

			if ( ! $terms || is_wp_error( $terms ) ) :
				unset( $terms_args['include'] );
				$terms_args['orderby'] = 'name';
				$terms_args['order'] = 'ASC';
				$terms = get_terms( $terms_args );
			endif;
			?>

			<?php
			if ( $terms && ! is_wp_error( $terms ) ) :

				$count_terms          = is_array( $terms ) ? count( $terms ) : 0;
				$class_count          = 'listar-categories-display-' . $count;
				$class_hide_on_mobile = $count_terms > 4 ? ' listar-category-hidden-mobile' : '';
				$container            = $count_terms > 3 ? ' container-fluid' : ' container';
				?>
				<!-- Start Featured Listing Categories -->
				<?php if ( '' !== $title || '' !== $subtitle ) : ?>
					<div class="container">
						<div class="row" data-aos="fade-up">
							<div class="col-sm-12 listar-widget-title-wrapper">
								<?php
								echo wp_kses( '' !== $title ? $args['before_title'] . esc_html( $title ) . $args['after_title'] : '', 'listar-basic-html' );
								echo wp_kses( '' !== $subtitle ? '<div class="listar-widget-subtitle">' . esc_html( $subtitle ) . '</div>' : '', 'listar-basic-html' );
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="listar-featured-listing-terms <?php echo esc_attr( listar_sanitize_html_class( $class_count . $class_hide_on_mobile . $container ) ); ?>">

					<div class="listar-term-items listar-grid listar-carousel-loop owl-carousel owl-theme row <?php echo sanitize_html_class( $use_carousel ); ?>">
						<?php
						$count = 1;

						foreach ( $terms as $term ) :

							$body_classes        = get_body_class();
							$term_id             = $term->term_id;
							$term_url            = get_term_link( $term, 'job_listing_category' );
							$term_color          = listar_term_color( $term_id );
							$term_image          = listar_term_image( $term_id, 'job_listing_category', 'listar-cover' );
							$term_icon           = listar_icon_class( listar_term_icon( $term_id ) );
							$output_icon         = ( ! empty( $term_icon[0] ) || ! empty( $term_icon[1] ) ) ? '<div class="listar-cat-icon ' . esc_attr( listar_sanitize_html_class( $term_icon[0] ) ) . '" style="background-color:rgb(' . esc_attr( $term_color ) . ');">' . $term_icon[1] . '</div>' : '';
							$count               = $count % 4;
							$gradient_background = listar_gradient_background( '0,0,0', 'top', 'bottom', false, '0', '0.5', '50%' );
							$counter_bg_color    = in_array( 'listar-counters-design-1', $body_classes, true ) ? 'rgb(' . $term_color . ')' : 'rgb(255,255,255)';
							$term_description    = $term->description;
							$term_bordered       = 'listar-term-bordered';
							$amount              = listar_count_term_posts( $term );
							$cols                = 'col-xs-12 col-sm-6 col-md-4';
							
							if ( empty( $use_carousel ) ) {
								if ( '50% - 50%' === $columns ) {
									$cols = 'col-xs-12 col-sm-6';
								} elseif ( '75% - 25%' === $columns ) {
									$cols = 0 === $count % 2 ? 'col-xs-12 col-sm-6 col-md-4' : 'col-xs-12 col-sm-6 col-md-8';
								} elseif ( '25% - 75%' === $columns ) {
									$cols = 0 === $count % 2 ? 'col-xs-12 col-sm-6 col-md-8' : 'col-xs-12 col-sm-6 col-md-4';
								} elseif ( '33% - 33% - 33%' === $columns ) {
									$cols = 'col-xs-12 col-sm-6 col-md-4';
								} elseif ( '25% - 25% - 25% - 25%' === $columns ) {
									$cols = 'col-xs-12 col-sm-6 col-md-3';
								} elseif ( 'inverse' === $columns ) {
									$cols = 2 === $count || 3 === $count ? 'col-xs-12 col-sm-6 col-md-8' : 'col-xs-12 col-sm-6 col-md-4';
								} else {
									$cols = 2 === $count || 3 === $count ? 'col-xs-12 col-sm-6 col-md-4' : 'col-xs-12 col-sm-6 col-md-8';
								}
							}
							?>
							<div class="listar-featured-listing-term-item <?php echo esc_attr( listar_sanitize_html_class( $cols . ' ' . $term_bordered ) ); ?>" data-aos="fade-zoom-in" data-aos-group="categories">								
								<div class="listar-term-wrapper">
									<a class="listar-term-link listar-hoverable-overlay" href="<?php echo esc_url( $term_url ); ?>"></a>
									<div class="listar-term-3d-effect-wrapper">
										<div class="listar-term-inner">
											<?php
											/**
											 * Skipping sanitization for SVG code ( This output can contain SVG code or not )
											 * Please check the description for 'listar_icon_output' function in functions.php
											 */
											listar_icon_output( $output_icon );
											?>

											<div class="listar-term-data-wrapper">
												<div class="listar-term-overlay" style="background-color:rgba(<?php echo esc_attr( $term_color ); ?>,0.7);"></div>
												<div class="listar-gradient-overlay" style="<?php echo esc_attr( $gradient_background ); ?>"></div>
												<div class="listar-term-background-overlay" style="background-color:rgb(<?php echo esc_attr( $term_color ); ?>);box-shadow: 5px 5px rgb(<?php echo esc_attr( $term_color ); ?>);"></div>
												<div class="listar-listing-term-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $term_image ) ); ?>"></div>

												<div class="listar-lateral-padding listar-term-text-wrapper">
													<div class="listar-term-name-big">
														<span>
															<?php echo esc_html( $term->name ); ?>
														</span>
													</div>
													<div class="listar-term-text listar-ribbon">
														<?php echo esc_html( $term->name ); ?>
													</div>
													<?php if ( ! empty( $term_description ) ) : ?>
														<div class="listar-term-description">
															<?php echo esc_html( $term->description ); ?>
														</div>
													<?php endif; ?>
												</div>
											</div>

											<div class="listar-term-counter" style="background-color:<?php echo esc_attr( $counter_bg_color ); ?>;">
												<?php
												echo esc_html( $amount > 0 ? zeroise( $amount, 2 ) . ' ' : 0 );
												echo '<span>' . esc_html( listar_check_plural( $amount, esc_html__( 'Listing', 'listar' ), esc_html__( 'Listings', 'listar' ), esc_html__( 'No Listings', 'listar' ) ) ) . '</span>';
												?>
											</div>
										</div>
										<div class="listar-term-count-hover">
											<?php
											echo esc_html( $amount > 0 ? zeroise( $amount, 2 ) . ' ' : '' );
											echo esc_html( listar_check_plural( $amount, esc_html__( 'Listing', 'listar' ), esc_html__( 'Listings', 'listar' ), esc_html__( 'No Listings', 'listar' ) ) );
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
							$count++;
						endforeach;
						?>
					</div>
				</div>
				<!-- End Featured Listing Categories -->
					
				<?php
				if ( $more_terms ) :
					?>
					<div class="row listar-more-terms-button text-center">
						<div class="col-sm-12">
							<a href="#" class="button listar-light-button listar-more-categories-button-widget">
								<?php esc_html_e( 'More Categories', 'listar' ); ?>
							</a>
						</div>
					</div>
					<?php
				endif;
				?>

				<?php
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

if ( taxonomy_exists( 'job_listing_category' ) ) {
	register_widget( 'Listar_Listing_Categories_Widget' );
}

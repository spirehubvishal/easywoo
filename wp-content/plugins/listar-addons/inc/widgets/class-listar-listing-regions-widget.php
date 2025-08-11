<?php
/**
 * Widget to display listing regions
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Listing_Regions_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Listing Regions', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display listing regions', 'listar' ),
		);

		parent::__construct( 'listar_listing_regions', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
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
		$columns       = ! empty( $instance['columns'] ) ? $instance['columns'] : 'default';
		$elements_json = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
		$more_terms    = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'] ? 'checked' : '';
	
		$num_terms = wp_count_terms( 'job_listing_region', array(
			'hide_empty'=> false,
		) );
		
		if ( $num_terms > 0 ) :
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
			<?php
		endif;
		
		if ( $num_terms > 100 ) :
			?>
			<div class="listar-elements-wrapper listar-has-many-terms">
				<?php
				$ids = '';
				$rand_field = 'listar-field-many-terms-' . wp_rand( 0, 999999 );
				if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json ) :

					$elements_array = json_decode( $elements_json, true );
					$count = is_array( $elements_array ) ? count( $elements_array ) : 0;
					
					if ( $count ) {
						foreach ( $elements_array as $elem ) {
							if ( isset( $elem['id'] ) && is_numeric( $elem['id'] ) ) {
								if ( empty( $ids ) ) {
									$ids .= $elem['id'];
								} else {
									$ids .= ',' . $elem['id'];
								}
							}
						}
					}
					
				endif;
				?>

				<label for="<?php echo esc_attr( $rand_field ); ?>">
					<?php esc_html_e( 'Enter the region IDs, separated by comma', 'listar' ); ?>:
				</label>
				<input type="text" class="widefat" name="<?php echo esc_attr( $rand_field ); ?>" id="<?php echo esc_attr( $rand_field ); ?>" value="<?php echo esc_attr( $ids ); ?>" />

			</div>
			<?php
		else :
			$args = array(
				'taxonomy'   => 'job_listing_region',
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
						esc_url( admin_url( '/edit-tags.php?taxonomy=job_listing_region&post_type=job_listing' ) ),
						esc_html__( 'Create listing regions', 'listar' ),
						esc_html__( 'before using this widget.', 'listar' )
					);
					?>
				</p>
				<?php
			else :
				?>
				<div class="listar-elements-wrapper">
					<?php
					if ( ! empty( $elements_json ) && '[]' !== $elements_json && '[{}]' !== $elements_json && $terms && ! is_wp_error( $terms ) ) :

						$elements_array = json_decode( $elements_json, true );
						$count = is_array( $elements_array ) ? count( $elements_array ) : 0;

						for ( $i = 0; $i < $count; $i++ ) :

							/* Try to get the ID by term slug */
							$term_by_slug = isset( $elements_array[ $i ]['slug'] ) ? get_term_by( 'slug', $elements_array[ $i ]['slug'], 'job_listing_region' ) : false;

							if ( $term_by_slug && ! is_wp_error( $term_by_slug ) ) :
								$json_term_id = (int) $term_by_slug->term_id;
							else :
								/* Slug is unavailable, use the ID saved on JSON */
								$json_term_id = isset( $elements_array[ $i ]['id'] ) ? (int) $elements_array[ $i ]['id'] : '';
							endif;

							$check_term = get_terms(
								array(
									'taxonomy'   => 'job_listing_region',
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
											<?php esc_html_e( 'Select a listing region', 'listar' ); ?>
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
									<?php esc_html_e( 'Select a listing region', 'listar' ); ?>
								</option>

								<?php foreach ( $terms as $term ) : ?>
									<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>">
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
						<?php esc_html_e( 'New region block', 'listar' ); ?>
					</a>
				</p>

				<?php
			endif;
		endif;
		
		if ( $num_terms > 0 ) :
			?>
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_terms' ) ); ?>" value="1" <?php echo esc_attr( $more_terms ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>">
					<?php esc_html_e( 'Display button for more regions', 'listar' ); ?>
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
		$instance['elements_json'] = ! empty( $new_instance['elements_json'] ) ? sanitize_text_field( $new_instance['elements_json'] ) : '';
		$instance['more_terms']    = isset( $instance['more_terms'] ) &&  ! empty( $new_instance['more_terms'] ) ? (int) sanitize_text_field( $new_instance['more_terms'] ) : '';

		if ( ! empty( $instance['elements_json'] ) && false === strpos( $instance['elements_json'], '{' ) ) {
			$final_json = '[';
				
			$temps = array();

			if ( is_numeric( $instance['elements_json'] ) ) {
				$temps = array( $instance['elements_json'] );
			} else if ( false !== strpos( $instance['elements_json'], ',' ) ) {
				$temps = explode( ',', $instance['elements_json'] );
			}

			foreach ( $temps as $temp ) {
				if ( ! empty( $temp ) && is_numeric( $temp ) ) {

					$term = get_term( $temp, 'job_listing_region' );

					if ( ! is_wp_error( $term ) ) {
						$slug = $term->slug;
						$id = $term->term_id;

						if ( '[' === $final_json ) {
							$final_json .= '{' . '"slug":"' . $slug . '",'. '"id":"' . $id . '"' . '}';
						} else {
							$final_json .= ',' . '{' . '"slug":"' . $slug . '",'. '"id":"' . $id . '"' . '}';
						}
					}
				}
			}

			$final_json .= ']';

			$instance['elements_json'] = $final_json;
		}
		
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
		$columns       = ! empty( $instance['columns'] ) ? $instance['columns'] : '';
		$elements_json = ! empty( $instance['elements_json'] ) ? str_replace( '\\', '', $instance['elements_json'] ) : '';
		$more_terms    = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'];

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper listar-term-design-3">
			<?php
			$elements_array = array();
			$temp_array = json_decode( $elements_json, true );
			$count = is_array( $temp_array ) ? count( $temp_array ) : 0;

			for ( $i = 0; $i < $count; $i++ ) :

				/* Try to get the ID by term slug */
				$term_by_slug = isset( $temp_array[ $i ]['slug'] ) ? get_term_by( 'slug', $temp_array[ $i ]['slug'], 'job_listing_region' ) : false;

				if ( $term_by_slug && ! is_wp_error( $term_by_slug ) ) {
					$elements_array[ $i ] = (int) $term_by_slug->term_id;
				} elseif ( isset( $temp_array[ $i ]['id'] ) ) {
					/* Slug is unavailable, use the ID saved on JSON */
					$elements_array[ $i ] = (int) $temp_array[ $i ]['id'];
				}
			endfor;

			$terms_args = array(
				'taxonomy'   => 'job_listing_region',
				'hide_empty' => false,
				'number'     => 2000,
				'orderby'    => 'include',
				'include'    => $elements_array,
			);

			$terms = get_terms( $terms_args );
			?>

			<?php
			if ( ! $terms || is_wp_error( $terms ) ) :
				unset( $terms_args['include'] );
				$terms_args['orderby'] = 'name';
				$terms_args['order']   = 'ASC';
				$terms = get_terms( $terms_args );
			endif;
			?>

			<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
				<!-- Start Featured Listing Regions -->
				<div class="container listar-featured-listing-regions listar-regions text-center">
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

					<div class="row listar-grid listar-white-design">
						<?php
						$count = 1;
						$max_terms = 50;

						foreach ( $terms as $term ) :
							$body_classes        = get_body_class();
							$term_id             = $term->term_id;
							$term_url            = get_term_link( $term, 'job_listing_region' );
							$term_image_id       = get_term_meta( $term_id, 'job_listing_region-image-id', true );
							$term_image          = wp_get_attachment_image_src( $term_image_id, 'listar-cover' );
							$conditions          = false !== $term_image && isset( $term_image[0] ) && ! empty( $term_image[0] );
							$term_image_url      = $conditions ? $term_image[0] : '';
							$count               = $count % 4;
							$term_color          = listar_term_color( $term_id );
							$gradient_background = listar_gradient_background( '0,0,0', 'top', 'bottom', false, '0', '0.5', '50%' );
							$counter_bg_color    = in_array( 'listar-counters-design-1', $body_classes, true ) ? 'rgb(' . $term_color . ')' : 'rgb(255,255,255)';
							$term_description    = $term->description;
							$term_bordered       = 'listar-term-bordered';
							$amount              = listar_count_term_posts( $term );
							$cols                = '';
							$max_terms--;
							
							if ( $max_terms <= 0 ) {
								break;
							}

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
							?>
							<div class="<?php echo esc_attr( listar_sanitize_html_class( $cols . ' ' . $term_bordered ) ); ?>" data-aos="fade-zoom-in" data-aos-group="regions">
								<?php if ( 1 === 1 ) : ?>
								<div class="listar-term-wrapper">
									<a class="listar-term-link listar-hoverable-overlay" href="<?php echo esc_url( $term_url ); ?>"></a>
									<div class="listar-term-3d-effect-wrapper">
										<div class="listar-term-inner">
											<div class="listar-term-data-wrapper" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $term_image_url ) ); ?>">
												<div class="listar-region-overlay" style="background-color:rgba(<?php echo esc_attr( $term_color ); ?>,0.7);"></div>
												<div class="listar-gradient-overlay" style="<?php echo esc_attr( $gradient_background ); ?>"></div>
												<div class="listar-term-background-overlay" style="background-color:rgb(<?php echo esc_attr( $term_color ); ?>);box-shadow: 5px 5px rgb(<?php echo esc_attr( $term_color ); ?>);"></div>

												<div class="listar-region-data">
													<div>
														<div class="listar-term-name-big">
															<span>
																<?php echo esc_html( $term->name ); ?>
															</span>
														</div>
														<div class="listar-text-centralizer">
															<div class="listar-region-name listar-ribbon">
																<?php echo esc_html( $term->name ); ?>
															</div>
														</div>
														<?php if ( ! empty( $term_description ) ) : ?>
															<div class="listar-term-description">
																<?php echo esc_html( $term->description ); ?>
															</div>
														<?php endif; ?>
													</div>
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
								<?php elseif ( 1 === 1 ) : ?>
									<div>
										asdadada
									</div>
								<?php endif; ?>
							</div>
							<?php
							$count++;
						endforeach;
						?>
					</div>
					
					<?php
					if ( $more_terms ) :
						?>
						<div class="row listar-more-terms-button text-center">
							<div class="col-sm-12">
								<a href="#" class="button listar-light-button listar-more-regions-button-widget">
									<?php esc_html_e( 'More Regions', 'listar' ); ?>
								</a>
							</div>
						</div>
						<?php
					endif;
					?>
				</div>
				<!-- End Featured Listing Regions -->
			<?php endif; ?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

if ( taxonomy_exists( 'job_listing_region' ) ) {
	register_widget( 'Listar_Listing_Regions_Widget' );
}

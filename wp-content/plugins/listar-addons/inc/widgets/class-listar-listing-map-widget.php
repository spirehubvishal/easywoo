<?php
/**
 * Widget to display a map with listings
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */

$map_enabled = listar_is_map_enabled();

if ( $map_enabled ) {	
	class Listar_Listing_Map_Widget extends WP_Widget {
		/**
		 * Setup the widget name, description, etc.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			$widget_title = esc_html__( 'Front Page Map', 'listar' );

			$widget_description = array(
				'description' => esc_html__( 'Display a map with listings', 'listar' ),
			);

			parent::__construct( 'listar_listing_map', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
		}

		/**
		 * Back end display of the widget.
		 *
		 * @since 1.0
		 * @param (array) $instance The values saved for current widget.
		 */
		public function form( $instance ) {

			$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$subtitle   = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
			$order      = ! empty( $instance['order'] ) ? $instance['order'] : 'date';
			$hidden_map = '';

			if ( ! empty( $instance['hidden_map'] ) ) :
				$hidden_map = 1 === (int) $instance['hidden_map'] ? 'checked' : '';
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
					<?php esc_html_e( 'Order', 'listar' ); ?>:
				</label>

				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" value="<?php echo esc_attr( $order ); ?>">
					<?php
					$order_values = array(
						'date',
						'rand',
					);

					$order_names = array(
						esc_html__( 'Date', 'listar' ),
						esc_html__( 'Random', 'listar' ),
					);

					if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {
						$order_values[] = 'best-rated';
						$order_names[]  = esc_html__( 'Best rated', 'listar' );
					}

					$count = count( $order_values );

					for ( $i = 0; $i < $count; $i++ ) :

						$selected = '';

						if ( $order_values[ $i ] === $order ) :
							$selected = 'selected="selected"';
						endif;
						?>

						<option value="<?php echo esc_attr( $order_values[ $i ] ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
							<?php echo esc_html( $order_names[ $i ] ); ?>
						</option>

					<?php endfor; ?>

				</select>
			</p>

			<p>
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hidden_map' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hidden_map' ) ); ?>" value="1" <?php echo esc_attr( $hidden_map ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'hidden_map' ) ); ?>">
					<?php esc_html_e( 'Hidden map?', 'listar' ); ?>
				</label>
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

			$instance               = $old_instance;
			$instance['title']      = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['subtitle']   = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
			$instance['order']      = ! empty( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : '';
			$instance['hidden_map'] = ! empty( $new_instance['hidden_map'] ) ? (int) sanitize_text_field( $new_instance['hidden_map'] ) : '';

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

			$subtitle   = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
			$order      = ! empty( $instance['order'] ) ? $instance['order'] : 'date';
			$has_title  = '' !== $title || '' !== $subtitle ? '' : 'listar-map-no-title';
			$hidden_map = '';

			if ( ! empty( $instance['hidden_map'] ) ) {
				$hidden_map = 1 === (int) $instance['hidden_map'] ? 'listar-hidden-map' : '';
			}

			echo wp_kses( $args['before_widget'], 'listar-basic-html' );
			?>

			<div class="listar-widget-inner listar-container-wrapper <?php echo esc_attr( listar_sanitize_html_class( $has_title . ' ' . $hidden_map ) ); ?>">
				<?php
				$args_query = array(
					'post_status'    => 'publish',
					'post_type'      => 'job_listing',
					'posts_per_page' => (int) get_option( 'job_manager_per_page' ),
					'orderby'        => $order,
					'custom_query'   => 1, /* This will skip pre_get_posts action (listar_pre_get_listings) */
				);
				?>

				<?php
				if ( 'best-rated' === $order ) :
					if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) :
						$args_query['orderby']  = 'post__in';
						$args_query['post__in'] = listar_saved_best_rated();
					else :
						$args_query['orderby'] = 'rand';
					endif;
				endif;
				?>

				<?php $exec_query = new WP_Query( $args_query ); ?>

				<?php if ( $exec_query->have_posts() ) : ?>

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

					<div class="listar-widgetized-map-container">
						<div id="map" class="listar-map">
							<div class="listar-map-fail"></div>
							<h5 class="hidden">
								<?php esc_html_e( 'Listing View', 'listar' ); ?>
							</h5>
							<div class="listar-back-listing-button icon-arrow-left">
								<?php esc_html_e( 'Listing View', 'listar' ); ?>
							</div>
						</div>
						<div class="listar-aside-list"></div>
					</div>

					<div class="listar-grid listar-white-design listar-results-container hidden"></div>

					<?php if ( ! empty( $hidden_map ) ) : ?>
						<div class="listar-map-launch-wrapper text-center" data-background-image="<?php echo esc_url( listar_get_theme_file_uri( '/assets/images/map-background.jpg' ) ); ?>" >
							<button class="button listar-iconized-button listar-dark-button icon-map2" type="button">
								<?php esc_html_e( 'Launch Map', 'listar' ); ?>
							</button>
						</div>
					<?php endif; ?>

					<?php
					global $wp_scripts;

					listar_static_current_listings( array() );
					listar_loop_completed( false );

					while ( $exec_query->have_posts() ) :
						$exec_query->the_post();
						listar_static_current_listings( get_the_ID() );
					endwhile;

					listar_loop_completed( true );

					/* Display only one Ajax 'Load More' button per page... additional buttons must redirect to 'listings' page */
					$check_scripts   = isset( $wp_scripts->registered['listar-main-javascript']->extra['data'] ) ? $wp_scripts->registered['listar-main-javascript']->extra['data'] : '';
					$has_ajax_params = false !== strpos( $check_scripts, 'listarAjaxPostsParam' ) ? true : false;

					if ( ! $has_ajax_params ) {

						/* Don't display the 'listar-more-results' button if there are not enough posts */
						if ( $exec_query->max_num_pages > 1 ) :
							?>
							<div class="listar-load-more-wrapper">
								<div class="listar-more-results listar-load-listings hidden" title="<?php esc_attr_e( 'Load more', 'listar' ); ?>">
									<?php esc_html_e( 'Load more', 'listar' ); ?>
								</div>
							</div>
							<?php
						endif;

						/* Ajax 'load more' script */
						listar_load_more_script( $exec_query );
					} else {
						$listings_page_url = job_manager_get_permalink( 'jobs' );
						?>
						<div class="listar-load-more-wrapper">
							<a href="<?php echo esc_url( $listings_page_url ); ?>" class="listar-more-results listar-load-listings listar-go-to-listing-page hidden" title="<?php esc_attr_e( 'Load more', 'listar' ); ?>">
								<?php esc_html_e( 'More Listings', 'listar' ); ?>
							</a>
						</div>
						<?php
					}

					wp_reset_postdata();
					?>

				<?php endif; ?>
			</div>

			<?php
			echo wp_kses( $args['after_widget'], 'listar-basic-html' );
		}
	}

	if ( post_type_exists( 'job_listing' ) ) {
		register_widget( 'Listar_Listing_Map_Widget' );
	}
}
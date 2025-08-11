<?php
/**
 * Widget to display listings
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Listings_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Listings', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display listings', 'listar' ),
		);

		parent::__construct( 'listar_listings', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$title           = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$subtitle        = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$order           = ! empty( $instance['order'] ) ? $instance['order'] : 'meta_value_num date';
		$number_of_posts = ! empty( $instance['number_of_posts'] ) ? (int) $instance['number_of_posts'] : 10;
		$region          = ! empty( $instance['listing_region_id'] ) ? (int) $instance['listing_region_id'] : 0;
		$category        = ! empty( $instance['listing_category_id'] ) ? (int) $instance['listing_category_id'] : 0;
		$amenity         = ! empty( $instance['listing_amenity_id'] ) ? (int) $instance['listing_amenity_id'] : 0;
		$only_featured   = '';
		$use_carousel    = '';
		$more_terms      = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'] ? 'checked' : '';

		if ( ! empty( $instance['only_featured'] ) ) :
			$only_featured = 1 === (int) $instance['only_featured'] ? 'checked' : '';
		endif;

		if ( ! empty( $instance['use_carousel'] ) ) :
			$use_carousel = 1 === (int) $instance['use_carousel'] ? 'checked' : '';
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
		
		<?php
		$num_terms = wp_count_terms( 'job_listing_region', array(
			'hide_empty'=> false,
		) );
		
		if ( $num_terms > 100 ) :
			?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'listing_region_id' ) ); ?>">
				<?php esc_html_e( 'Filter listings by region', 'listar' ); ?>. <?php esc_html_e( 'Enter a region ID', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_region_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_region_id' ) ); ?>" value="<?php echo esc_attr( $region ); ?>" />
			<?php
		else :
			if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) :
				$args = array(
					'taxonomy'   => 'job_listing_region',
					'hide_empty' => false,
					'number'     => 2000,
					'orderby'    => 'name',
					'order'      => 'ASC',
				);

				$terms = get_terms( $args );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
					?>
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'listing_region_id' ) ); ?>">
							<?php esc_html_e( 'Filter listings by region', 'listar' ); ?>:
						</label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_region_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_region_id' ) ); ?>" value="<?php echo esc_attr( $region ); ?>">
							<option value="">
								<?php esc_html_e( 'Select a listing region', 'listar' ); ?>
							</option>

							<?php
							foreach ( $terms as $term ) :
								$selected = $region === $term->term_id ? 'selected="selected"' : '';
								?>
								<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
									<?php echo esc_html( $term->name ); ?>
								</option>
								<?php
							endforeach;
							?>
						</select>
					</p>
					<?php
				endif;
			endif;
		endif;
		?>
		

		<?php
		if ( taxonomy_exists( 'job_listing_category' ) ) :
			$args = array(
				'taxonomy'   => 'job_listing_category',
				'hide_empty' => false,
				'number'     => 2000,
				'orderby'    => 'name',
				'order'      => 'ASC',
			);

			$terms = get_terms( $args );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'listing_category_id' ) ); ?>">
						<?php esc_html_e( 'Filter listings by category', 'listar' ); ?>:
					</label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_category_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_category_id' ) ); ?>" value="<?php echo esc_attr( $category ); ?>">
						<option value="">
							<?php esc_html_e( 'Select a listing category', 'listar' ); ?>
						</option>

						<?php
						foreach ( $terms as $term ) :
							$selected = $category === $term->term_id ? 'selected="selected"' : '';
							?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
								<?php echo esc_html( $term->name ); ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</p>
				<?php
			endif;
			?>

		<?php endif; ?>
		

		<?php
		if ( taxonomy_exists( 'job_listing_amenity' ) ) :
			$args = array(
				'taxonomy'   => 'job_listing_amenity',
				'hide_empty' => false,
				'number'     => 2000,
				'orderby'    => 'name',
				'order'      => 'ASC',
			);

			$terms = get_terms( $args );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'listing_amenity_id' ) ); ?>">
						<?php esc_html_e( 'Filter listings by amenity', 'listar' ); ?>:
					</label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_amenity_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_amenity_id' ) ); ?>" value="<?php echo esc_attr( $amenity ); ?>">
						<option value="">
							<?php esc_html_e( 'Select a listing amenity', 'listar' ); ?>
						</option>

						<?php
						foreach ( $terms as $term ) :
							$selected = $amenity === $term->term_id ? 'selected="selected"' : '';
							?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
								<?php echo esc_html( $term->name ); ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</p>
				<?php
			endif;
			?>

		<?php endif; ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<?php esc_html_e( 'Order', 'listar' ); ?>:
			</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" value="<?php echo esc_attr( $order ); ?>">
				<?php
				$order_values = array(
					'meta_value_num date',
					'rand',
				);

				$order_names = array(
					esc_html__( 'Date', 'listar' ),
					esc_html__( 'Random', 'listar' ),
				);

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>">
				<?php esc_html_e( 'Number of posts', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" value="<?php echo esc_attr( $number_of_posts ); ?>">
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'only_featured' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'only_featured' ) ); ?>" value="1" <?php echo esc_attr( $only_featured ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'only_featured' ) ); ?>">
				<?php esc_html_e( 'Only featured listings', 'listar' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_carousel' ) ); ?>" value="1" <?php echo esc_attr( $use_carousel ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>">
				<?php esc_html_e( 'If possible, create a carousel', 'listar' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_terms' ) ); ?>" value="1" <?php echo esc_attr( $more_terms ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_terms' ) ); ?>">
				<?php esc_html_e( 'Display button for More Listings', 'listar' ); ?>
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

		$instance                      = $old_instance;
		$instance['title']             = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']          = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['listing_region_id'] = ! empty( $new_instance['listing_region_id'] ) ? (int) sanitize_text_field( $new_instance['listing_region_id'] ) : '';
		$instance['listing_category_id'] = ! empty( $new_instance['listing_category_id'] ) ? (int) sanitize_text_field( $new_instance['listing_category_id'] ) : '';
		$instance['listing_amenity_id'] = ! empty( $new_instance['listing_amenity_id'] ) ? (int) sanitize_text_field( $new_instance['listing_amenity_id'] ) : '';
		$instance['order']             = ! empty( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : '';
		$instance['number_of_posts']   = ! empty( $new_instance['number_of_posts'] ) ? (int) sanitize_text_field( $new_instance['number_of_posts'] ) : 10;
		$instance['only_featured']     = ! empty( $new_instance['only_featured'] ) ? (int) sanitize_text_field( $new_instance['only_featured'] ) : '';
		$instance['use_carousel']      = ! empty( $new_instance['use_carousel'] ) ? (int) sanitize_text_field( $new_instance['use_carousel'] ) : '';
		$instance['more_terms']        = isset( $instance['more_terms'] ) && ! empty( $new_instance['more_terms'] ) ? (int) sanitize_text_field( $new_instance['more_terms'] ) : '';

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

		$subtitle        = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$order           = ! empty( $instance['order'] ) ? $instance['order'] : 'meta_value_num date';
		$number_of_posts = ! empty( $instance['number_of_posts'] ) ? (int) sanitize_text_field( $instance['number_of_posts'] ) : 10;
		$region_id       = ! empty( $instance['listing_region_id'] ) ? (int) sanitize_text_field( $instance['listing_region_id'] ) : 0;
		$category_id     = ! empty( $instance['listing_category_id'] ) ? (int) sanitize_text_field( $instance['listing_category_id'] ) : 0;
		$amenity_id      = ! empty( $instance['listing_amenity_id'] ) ? (int) sanitize_text_field( $instance['listing_amenity_id'] ) : 0;
		$only_featured   = '';
		$use_carousel    = '';
		$more_terms      = isset( $instance['more_terms'] ) && 1 === (int) $instance['more_terms'];
		
		if ( $number_of_posts > 200 ) {
			$number_of_posts = 200;
		}

		if ( ! empty( $instance['only_featured'] ) ) {
			$only_featured = 1 === (int) $instance['only_featured'];
		}

		if ( ! empty( $instance['use_carousel'] ) ) {
			$use_carousel = 1 === (int) $instance['use_carousel'] ? 'listar-use-carousel' : '';
		}

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper widget-listing">
			<?php
			$taxonomies = array();

			if ( taxonomy_exists( 'job_listing_region' ) && ! empty( $region_id ) ) {
				$term_link = get_term_link( $region_id, 'job_listing_region' );

				if ( $term_link && ! is_wp_error( $term_link ) ) {
					$taxonomies[] = array(
						'taxonomy'         => 'job_listing_region',
						'terms'            => $region_id,
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}

			if ( taxonomy_exists( 'job_listing_category' ) && ! empty( $category_id ) ) {
				$term_link = get_term_link( $category_id, 'job_listing_category' );

				if ( $term_link && ! is_wp_error( $term_link ) ) {
					$taxonomies[] = array(
						'taxonomy'         => 'job_listing_category',
						'terms'            => $category_id,
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}

			if ( taxonomy_exists( 'job_listing_amenity' ) && ! empty( $amenity_id ) ) {
				$term_link = get_term_link( $amenity_id, 'job_listing_amenity' );

				if ( $term_link && ! is_wp_error( $term_link ) ) {
					$taxonomies[] = array(
						'taxonomy'         => 'job_listing_amenity',
						'terms'            => $amenity_id,
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}		
			

			/* Get listings IDS by searching on meta fields */
			
			$query_args = array(
				'post_status'    => 'publish',
				'post_type'      => 'job_listing',
				'posts_per_page' => $number_of_posts,
				'tax_query'      => $taxonomies,
				'meta_key'       => '_featured',
				'orderby'        => $order,
			);
			
			if ( $only_featured ) {
				$query_args['meta_key'] = '_featured';
				$query_args['meta_value'] = '1';
			}		

			$exec_query = new WP_Query( $query_args );
			?>

			<?php
			if ( $exec_query->have_posts() ) :
				$count_items = listar_count_found_posts( $exec_query );
				$container   = $count_items > 3 && $number_of_posts > 3 ? ' container-fluid' : ' container';
				?>
				<!-- Start Newest Listings -->
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
					<?php
				endif;
				?>

				<div class="listar-listings-block <?php echo esc_attr( listar_sanitize_html_class( $container ) ); ?>">
					<div class="row listar-grid listar-carousel-loop owl-carousel owl-theme <?php echo sanitize_html_class( $use_carousel ); ?>">
						<?php
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();
							require LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/widget-parts/widget-listings/loop.php';
						endwhile;

						/* Outputs a card to complete the grid, avoiding empty areas on the screen. */
						listar_grid_filler_card();

						wp_reset_postdata();
						?>
					</div>
					
					<?php
					if ( $more_terms ) :
						$link = network_site_url( '?s=&post_type=job_listing&search_type=listing' );
						?>
						<div class="row listar-more-terms-button text-center">
							<div class="col-sm-12">
								<a href="<?php echo esc_url( $link ); ?>" class="button listar-light-button listar-more-listings-button-widget">
									<?php esc_html_e( 'More Listings', 'listar' ); ?>
								</a>
							</div>
						</div>
						<?php
					endif;
					?>
				</div>
				<!-- End Newest Listings -->
				<?php
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

if ( post_type_exists( 'job_listing' ) ) {
	register_widget( 'Listar_Listings_Widget' );
}

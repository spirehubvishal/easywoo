<?php
/**
 * Widget to display blog posts
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Blog_Posts_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Blog Posts', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display blog posts', 'listar' ),
		);

		parent::__construct( 'listar_blog_posts', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
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
		$order           = ! empty( $instance['order'] ) ? $instance['order'] : 'date';
		$number_of_posts = ! empty( $instance['number_of_posts'] ) ? (int) $instance['number_of_posts'] : 10;
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

				$count = is_array( $order_values ) ? count( $order_values ) : 0;

				for ( $i = 0; $i < $count; $i++ ) :

					$selected = '';

					if ( $order_values[ $i ] === $order ) :
						$selected = 'selected="selected"';
					endif;
					?>

					<option value="<?php echo esc_attr( $order_values[ $i ] ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $order_names[ $i ] ); ?>
					</option>

					<?php
				endfor;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>">
				<?php esc_html_e( 'Number of posts', 'listar' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" value="<?php echo esc_attr( $number_of_posts ); ?>">
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

		$instance                    = $old_instance;
		$instance['title']           = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']        = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['order']           = ! empty( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : '';
		$instance['number_of_posts'] = ! empty( $new_instance['number_of_posts'] ) ? (int) sanitize_text_field( $new_instance['number_of_posts'] ) : 10;

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
		$order           = ! empty( $instance['order'] ) ? $instance['order'] : 'date';
		$number_of_posts = ! empty( $instance['number_of_posts'] ) ? (int) sanitize_text_field( $instance['number_of_posts'] ) : 10;

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper listar-widget-blog-posts">
			<?php
			$ignore_sticky = ! listar_is_front_page_template() ? 1 : 0;

			listar_loop_completed( true );

			$exec_query = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => $number_of_posts,
					'ignore_sticky_posts' => $ignore_sticky,
					'orderby'             => $order,
				)
			);
			?>

			<?php
			if ( $exec_query->have_posts() ) :
				ob_start();
				?>
				<!-- Start Blog -->
				<div class="container blog listar-blog-home">
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

					<div class="row listar-grid listar-grid-design-1 listar-white-design">
						<?php
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();
							require LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/widget-parts/widget-blog-posts/loop.php';
						endwhile;

						/* Outputs a card to complete the grid, avoiding empty areas on the screen. */
						listar_grid_filler_card( 'blog' );
						?>
					</div>
				</div>
				<!-- End Blog -->

				<?php
				wp_reset_postdata();
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

register_widget( 'Listar_Blog_Posts_Widget' );

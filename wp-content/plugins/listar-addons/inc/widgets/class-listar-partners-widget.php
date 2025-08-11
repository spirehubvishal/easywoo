<?php
/**
 * Widget to display partner posts
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Partners_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Partners', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display partners', 'listar' ),
		);

		parent::__construct( 'listar_partner_posts', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
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
		$use_carousel    = '';

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

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_carousel' ) ); ?>" value="1" <?php echo esc_attr( $use_carousel ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'use_carousel' ) ); ?>">
				<?php esc_html_e( 'If possible, create a carousel', 'listar' ); ?>
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

		$instance                    = $old_instance;
		$instance['title']           = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']        = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['order']           = ! empty( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : '';
		$instance['number_of_posts'] = ! empty( $new_instance['number_of_posts'] ) ? (int) sanitize_text_field( $new_instance['number_of_posts'] ) : 10;
		$instance['use_carousel']    = ! empty( $new_instance['use_carousel'] ) ? (int) sanitize_text_field( $new_instance['use_carousel'] ) : '';

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

		<div class="listar-widget-inner listar-container-wrapper">
			<?php

			listar_loop_completed( true );

			$exec_query = new WP_Query(
				array(
					'post_type'      => 'listar_partner',
					'post_status'    => 'publish',
					'posts_per_page' => $number_of_posts,
					'orderby'        => $order,
				)
			);

			$use_carousel   = '';

			if ( ! empty( $instance['use_carousel'] ) ) {
				$use_carousel = 1 === (int) $instance['use_carousel'] ? 'listar-use-carousel' : '';
			}
			?>

			<?php
			if ( $exec_query->have_posts() ) :
				ob_start();
				?>
				<!-- Start Partners -->
				<div class="container listar-partners">
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

					<div class="row listar-grid listar-carousel-loop owl-carousel owl-theme <?php echo sanitize_html_class( $use_carousel ); ?>">
						<?php
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();
							require LISTAR_ADDONS_PLUGIN_DIR . 'inc/widgets/widget-parts/widget-partners/loop.php';
						endwhile;
						?>
					</div>
				</div>
				<!-- End Partners -->

				<?php
				wp_reset_postdata();
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

register_widget( 'Listar_Partners_Widget' );

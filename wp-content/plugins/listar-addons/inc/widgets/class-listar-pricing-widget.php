<?php
/**
 * Widget to display pricing packages
 *
 * @package Listar_Addons
 */

/**
 * The class for this widget.
 *
 * @since 1.0
 */
class Listar_Pricing_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$widget_title = esc_html__( 'Pricing Packages', 'listar' );

		$widget_description = array(
			'description' => esc_html__( 'Display pricing packages', 'listar' ),
		);

		parent::__construct( 'listar_pricing', '&#x27A1; LISTAR - ' . $widget_title, $widget_description );
	}

	/**
	 * Back end display of the widget.
	 *
	 * @since 1.0
	 * @param (array) $instance The values saved for current widget.
	 */
	public function form( $instance ) {

		$get_title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $get_title, $instance, $this->id_base );

		$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
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
	}

	/**
	 * Update the widget
	 *
	 * @since 1.0
	 * @param (array) $new_instance The new widget data.
	 * @param (array) $old_instance The old widget data.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance             = $old_instance;
		$instance['title']    = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle'] = ! empty( $new_instance['subtitle'] ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';

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

		$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$design   = 'listar-dark-pricing-table';

		echo wp_kses( $args['before_widget'], 'listar-basic-html' );
		?>

		<div class="listar-widget-inner listar-container-wrapper listar-widget-pricing-packages <?php echo sanitize_html_class( $design ); ?>">
			<?php

			/* Check if has job packages */
			$exec_query = listar_package_query();
			$is_subscription = false;

			if ( $exec_query->have_posts() ) :
				?>

				<!-- Start pricing container -->
				<div class="container">
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

					<!-- Start pricing table items -->
					<div class="row listar-pricing-table">
						<?php
						while ( $exec_query->have_posts() ) :
							$exec_query->the_post();

							$listar_current_post_id         = get_the_ID();
							$enabled_package_options_output = listar_addons_active() ? listar_get_package_options_enabled_output( $listar_current_post_id ) : '';
							$product                        = wc_get_product( $listar_current_post_id );
							$term_tag                       = '';
							$terms                          = get_the_terms( $listar_current_post_id, 'product_tag' );
							$post_image                     = get_the_post_thumbnail_url( $listar_current_post_id, 'medium' );
							$has_image                      = ! empty( $post_image ) ? true : false;
							$placeholder                    = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

							$is_subscription = $product->is_type( 'job_package_subscription' );
							$button_label = $is_subscription ? get_option( 'woocommerce_subscriptions_add_to_cart_button_text' ) : esc_html__( 'Get Started', 'listar' );

							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
								$term_tag = isset( $terms[0]->name ) ? $terms[0]->name : '';
							endif;

							$has_tag      = ! empty( $term_tag ) ? 'listar-featured-package' : 'listar-no-featured-package';
							$button_class = ! empty( $term_tag ) ? 'listar-color-button' : 'listar-light-button';
							?>
							<div class="col-xs-12 col-sm-6 col-md-4 listar-listing-package <?php echo esc_attr( listar_sanitize_html_class( $has_tag ) ); ?>">
								<div class="listar-package-content">
									<div class="listar-package-title">
										<h4>
											<?php the_title(); ?>
										</h4>
									</div>

									<?php if ( $has_image ) : ?>
										<div class="listar-pricing-package-image">
											<img src="<?php echo esc_attr( $placeholder ); ?>" alt="<?php the_title(); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $post_image ) ); ?>" data-force-img="true" />
										</div>
									<?php endif; ?>

									<div class="listar-package-content-inner">
										<?php if ( has_excerpt() ) : ?>
											<div class="listar-package-subtitle">
												<?php the_excerpt(); ?>
											</div>
										<?php endif; ?>

										<div class="listar-pricing-circle">
											<div class="listar-package-price">
												<?php
												$listar_woo_regular_price = $product->get_regular_price();
												$listar_woo_sale_price    = $product->get_sale_price();
												$thousand_separator = class_exists( 'Woocommerce' ) ? wc_get_price_thousand_separator() : ',';
												$decimal_separator = class_exists( 'Woocommerce' ) ? wc_get_price_decimal_separator() : '.';
	
												if ( ! empty( $listar_woo_regular_price ) ) {
													$listar_woo_regular_price = listar_price_custom_output(  $listar_woo_regular_price, $thousand_separator, $decimal_separator );
												}
	
												if ( ! empty( $listar_woo_sale_price ) ) {
													$listar_woo_sale_price = listar_price_custom_output( $listar_woo_sale_price, $thousand_separator, $decimal_separator );
												}

												if ( strlen( $listar_woo_regular_price ) ) :
													if ( strlen( $listar_woo_sale_price ) ) {
														if ( 0 === (int) $listar_woo_sale_price ) {
															$listar_woo_sale_price = esc_html__( 'Free', 'listar' );
														}

														echo wp_kses( '<div class="listar-older-price"><span><span class="listar-older-price-currency">' . listar_currency() . '</span>' . $listar_woo_regular_price . '</span></div><span class="listar-newer-price-currency">' . listar_currency() . '</span>' . $listar_woo_sale_price, 'listar-basic-html' );
													} else {
														if ( 0 === (int) $listar_woo_regular_price ) {
															$listar_woo_regular_price = esc_html__( 'Free', 'listar' );
														}

														echo wp_kses( '<span class="listar-newer-price-currency">' . listar_currency() . '</span>' . $listar_woo_regular_price, 'listar-basic-html' );
													}
												endif;
												?>
											</div>

											<?php
											if ( ! empty( $term_tag ) ) :
												echo wp_kses( '<div class="listar-hot-label">' . $term_tag . '</div>', 'listar-basic-html' );
											endif;
											?>

										</div>

										<div class="listar-package-description">
											<?php
											if ( $is_subscription ) :
												echo wp_kses( '<p class="listar-has-icon icon-box">' . esc_html__( 'Subscription Package', 'listar' ) . '</p>', 'listar-basic-html' );

												$include_period = array(
													'tax_calculation'     => get_option( 'woocommerce_tax_display_shop' ),
													'subscription_price'  => false,
													'subscription_period' => true,
													'subscription_length' => true,
													'sign_up_fee'         => false,
													'trial_length'        => false,
												);

												$include_free_period = array(
													'tax_calculation'     => false,
													'subscription_price'  => false,
													'subscription_period' => false,
													'subscription_length' => false,
													'sign_up_fee'         => true,
													'trial_length'        => true,
												);

												$subscription_period = trim( WC_Subscriptions_Product::get_price_string( $product, $include_period ) );

												$subscription_free_period = trim( WC_Subscriptions_Product::get_price_string( $product, $include_free_period ) );

												if ( ! empty( trim( wp_strip_all_tags( $subscription_period ) ) ) ) {
													echo wp_kses( '<p class="listar-has-icon icon-calendar-full">' . mb_convert_case( $subscription_period, MB_CASE_TITLE, 'UTF-8' ) . '</p>', 'listar-basic-html' );
												}

												if ( ! empty( trim( wp_strip_all_tags( $subscription_free_period ) ) ) ) {
													echo wp_kses( '<p class="listar-has-icon icon-receipt">' . mb_convert_case( $subscription_free_period, MB_CASE_TITLE, 'UTF-8' ) . '</p>', 'listar-basic-html' );
												}
											endif;
											?>
											<?php the_content(); ?>
											<?php echo wp_kses( $enabled_package_options_output, 'listar-basic-html' ); ?>
											<div class="listar-sign-in-button">
												<a class="button <?php echo sanitize_html_class( $button_class ); ?>" href="<?php echo esc_url( job_manager_get_permalink( 'submit_job_form' ) ) . '#skip-package-selection-' . $listar_current_post_id; ?>">
													<?php echo esc_html( $button_label ); ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						endwhile;

						/* Restore original Post Data */
						wp_reset_postdata();
						?>
					</div>
					<!-- End pricing table items -->
				</div>
				<!-- Start pricing container -->

				<?php
			endif;
			?>
		</div>

		<?php
		echo wp_kses( $args['after_widget'], 'listar-basic-html' );
	}

}

register_widget( 'Listar_Pricing_Widget' );

<?php
/**
 * Package Selection.
 * Shows packages selection to purchase.
 *
 * @version 2.0.0
 * @since 2.0.0
 *
 * @var array $packages      WC Products.
 * @var array $user_packages User Packages.
 *
 * @package Listing Payments
 * @category Template
 * @author Astoundify
 */
?>

<?php
$listar_pricing_design = 'listar-dark-pricing-table';

if ( $packages || $user_packages ) :
	$get_package = isset( $_GET['selected_package'] ) ? intval( $_GET['selected_package'] ) : 0;
	$checked = 1;
	$is_subscription = false;
	$has_valid_user_package = false;
	
	foreach ( $user_packages as $key => $package ) :
		$temp = get_object_vars( $package );

		if ( isset( $temp['product_id'] ) && '0' !== $temp['product_id'] ) {
			$has_valid_user_package = true;
			break;
		}
	endforeach;
	
	if ( $has_valid_user_package ) :
		$checked = $get_package ? 0 : 1; // Get package do not target user package.
		?>
		<h2 class="listar-margin-bottom-40 text-center">
			<?php esc_html_e( 'Your Packages:', 'listar' ); ?>
		</h2>

		<div class="row <?php echo sanitize_html_class( $listar_pricing_design ); ?>">
			<div class="col-sm-12">

				<!-- Start pricing table items -->
				<div class="row listar-pricing-table listar-pricing-page">
					<?php
					foreach ( $user_packages as $key => $package ) :
						$temp = get_object_vars($package);
						$listar_current_post_id = isset( $temp['product_id'] ) && '0' !== $temp['product_id'] ? $temp['product_id'] : '0';
						
						if ( '0' !== $listar_current_post_id ) :
							$product = wc_get_product( $listar_current_post_id );

							if ( ! $product->is_type( array( 'job_package', 'job_package_subscription' ) ) || ! $product->is_purchasable() ) {
								continue;
							}

							$is_subscription = $product->is_type( 'job_package_subscription' );
							$button_label = $is_subscription ? get_option( 'woocommerce_subscriptions_add_to_cart_button_text' ) : esc_html__( 'Get Started', 'listar' );
							$package = astoundify_wpjmlp_get_package( $package );
							$post = get_post( $listar_current_post_id );

							$excerpt = $post->post_excerpt;
							$title = $package->get_title();
							$listar_get_post = $post->post_content;
							$listar_get_post_temp = preg_replace( '/[^\w]/', '', $listar_get_post ); /* Check if the output has relevant text (Letters and/or Numbers) */
							$listar_condition_has_description = ! empty( $listar_get_post_temp );
							$listar_term_tag        = '';
							$listar_terms           = get_the_terms( $listar_current_post_id, 'product_tag' );
							$listar_post_image      = get_the_post_thumbnail_url( $listar_current_post_id, 'medium' );
							$listar_has_image       = ! empty( $listar_post_image ) ? true : false;
							$listar_placeholder     = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

							if ( ! empty( $listar_terms ) && ! is_wp_error( $listar_terms ) ) :
								$listar_term_tag = isset( $listar_terms[0]->name ) ? $listar_terms[0]->name : '';
							endif;

							$listar_has_tag      = ! empty( $listar_term_tag ) ? 'listar-featured-package' : 'listar-no-featured-package';
							$listar_button_class = ! empty( $listar_term_tag ) ? 'listar-color-button' : 'listar-light-button';
							?>

							<div class="col-xs-12 col-sm-6 col-md-4 listar-package-standard-form listar-listing-package <?php echo esc_attr( listar_sanitize_html_class( $listar_has_tag ) ); ?>">
								<div class="listar-package-content listar-package-clickable-area">
									<div class="listar-package-title">
										<h4>
											<?php echo esc_html( $title ); ?>
										</h4>
									</div>

									<?php if ( $listar_has_image ) : ?>
										<div class="listar-pricing-package-image">
											<img alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_attr( $listar_placeholder ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_post_image ) ); ?>" data-force-img="true" />
										</div>
									<?php endif; ?>

									<div class="listar-package-content-inner">

										<?php if ( ! empty( $excerpt ) ) : ?>
											<div class="listar-package-subtitle">
												<?php echo apply_filters( 'woocommerce_short_description', $excerpt ) ?>
											</div>
										<?php endif; ?>

										<div class="listar-pricing-circle">
											<div class="listar-package-price">
												<?php
												$listar_woo_regular_price = $product->get_regular_price();
												$listar_woo_sale_price = $product->get_sale_price();

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
											if ( ! empty( $listar_term_tag ) ) :
												echo wp_kses( '<div class="listar-hot-label">' . $listar_term_tag . '</div>', 'listar-basic-html' );
											endif;
											?>

										</div>

										<div class="listar-package-description">
											<?php
											if ( $is_subscription ) :
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
											<p>	
												<?php
												if ( $package->get_limit() ) {
													$package_count = zeroise( $package->get_count(), 2 );

													if ( '00' === $package_count ) {
														esc_html_e( 'No listings', 'listar' );
													} else {
														printf( 
															_n(
																'%s listing',
																'%s listings',
																$package->get_count(),
																'listar'
															),
															zeroise( $package->get_count(), 2 )
														);
													}

													printf( '<br/>' . esc_html__( 'Posted out of %s', 'listar' ), zeroise( $package->get_limit(), 2 ) );
												} else {
													printf( _n( '%s listing posted', '%s listings posted', $package->get_count(), 'listar' ), zeroise( $package->get_count(), 2 ) );
												}

												if ( $package->get_duration() && ! $listar_condition_has_description ) {
													printf(  '<br/>' . _n( 'Listed by %s day', 'Listed by %s days', $package->get_duration(), 'listar' ), zeroise( $package->get_duration(), 2 ) );
												}

												$checked = 0;
												?>
											</p>

											<?php
											if ( $listar_condition_has_description ) :
												echo wp_kses( apply_filters( 'the_content', wpautop( $listar_get_post, true ) ), 'post' );										
											endif;
											?>
											<div class="listar-sign-in-button">
												<input class="hidden" type="radio" <?php checked( $checked, 1 ); ?> name="job_package" value="user-<?php echo esc_attr( $key ); ?>" id="user-package-<?php echo esc_attr( $listar_current_post_id ); ?>" />
												<a class="button listar-package-clickable-area <?php echo sanitize_html_class( $listar_button_class ); ?>" href="#" data-user-package="<?php echo esc_attr( $listar_current_post_id ); ?>">
													<?php echo esc_html( $button_label ); ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						endif;
					endforeach;
					?>
				</div>
				<!-- End pricing table items -->
				
			</div>
		</div>
		<?php
	endif;

	if ( $packages ) :
		$checked = $get_package ? $get_package : $checked;
		?>
		<h2 class="listar-margin-bottom-40 text-center">
			<?php esc_html_e( 'Purchase Package:', 'listar' ); ?>
		</h2>

		<div class="row <?php echo sanitize_html_class( $listar_pricing_design ); ?>">
			<div class="col-sm-12">

				<!-- Start pricing table items -->
				<div class="row listar-pricing-table listar-pricing-page">
					<?php
					foreach ( $packages as $key => $package ) :
						$product = wc_get_product( $package );

						if ( ! $product->is_type( array( 'job_package', 'job_package_subscription' ) ) || ! $product->is_purchasable() ) {
							continue;
						}

						$is_subscription = $product->is_type( 'job_package_subscription' );
						$button_label = $is_subscription ? get_option( 'woocommerce_subscriptions_add_to_cart_button_text' ) : esc_html__( 'Get Started', 'listar' );
						$listar_current_post_id = $product->get_id();
						$post = get_post( $listar_current_post_id ); 
						$excerpt = $post->post_excerpt;
						$title = $product->get_title();
						$listar_get_post = $post->post_content;
						$listar_get_post_temp = preg_replace( '/[^\w]/', '', $listar_get_post ); /* Check if the output has relevant text (Letters and/or Numbers) */
						$listar_condition_has_description = ! empty( $listar_get_post_temp );
						$listar_term_tag        = '';
						$listar_terms           = get_the_terms( $listar_current_post_id, 'product_tag' );
						$listar_post_image      = get_the_post_thumbnail_url( $listar_current_post_id, 'medium' );
						$listar_has_image       = ! empty( $listar_post_image ) ? true : false;
						$listar_placeholder     = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

						if ( ! empty( $listar_terms ) && ! is_wp_error( $listar_terms ) ) :
							$listar_term_tag = isset( $listar_terms[0]->name ) ? $listar_terms[0]->name : '';
						endif;

						$listar_has_tag      = ! empty( $listar_term_tag ) ? 'listar-featured-package' : 'listar-no-featured-package';
						$listar_button_class = ! empty( $listar_term_tag ) ? 'listar-color-button' : 'listar-light-button';
						?>

						<div class="col-xs-12 col-sm-6 col-md-4 listar-package-standard-form listar-listing-package <?php echo esc_attr( listar_sanitize_html_class( $listar_has_tag ) ); ?>">
							<div class="listar-package-content listar-package-clickable-area">
								<div class="listar-package-title">
									<h4>
										<?php echo esc_html( $title ); ?>
									</h4>
								</div>

								<?php if ( $listar_has_image ) : ?>
									<div class="listar-pricing-package-image">
										<img alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_attr( $listar_placeholder ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_post_image ) ); ?>" data-force-img="true" />
									</div>
								<?php endif; ?>

								<div class="listar-package-content-inner">

									<?php if ( ! empty( $excerpt ) ) : ?>
										<div class="listar-package-subtitle">
											<?php echo apply_filters( 'woocommerce_short_description', $excerpt ) ?>
										</div>
									<?php endif; ?>

									<div class="listar-pricing-circle">
										<div class="listar-package-price">
											<?php
											$listar_woo_regular_price = $product->get_regular_price();
											$listar_woo_sale_price = $product->get_sale_price();

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
										if ( ! empty( $listar_term_tag ) ) :
											echo wp_kses( '<div class="listar-hot-label">' . $listar_term_tag . '</div>', 'listar-basic-html' );
										endif;
										?>

									</div>

									<div class="listar-package-description">
										<?php
										if ( $listar_condition_has_description ) :
											echo wp_kses( apply_filters( 'the_content', wpautop( $listar_get_post, true ) ), 'post' );
										else :
											echo '<p>';
										
											if ( ! listar_is_claiming_listing() ) :
												printf(
													_n(
														'For %s listing',
														'For %s listings',
														$product->get_limit(),
														'listar'
													),
													$product->get_limit() ? $product->get_limit() : __( 'unlimited', 'listar' )
												);
											
												echo '<span><br/></span>';
											endif;

											echo $product->get_duration() ? sprintf( _n( 'Listed by %s day', 'Listed by %s days', $product->get_duration(), 'listar' ), $product->get_duration() ) : '';
											echo '</p>';
										endif;
										?>
										<?php
										if ( $is_subscription ) :
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
										
											$subscription_period = WC_Subscriptions_Product::get_price_string( $product, $include_period );
										
											$subscription_free_period = WC_Subscriptions_Product::get_price_string( $product, $include_free_period );

											if ( ! empty( trim( wp_strip_all_tags( $subscription_period ) ) ) ) {
												echo wp_kses( '<p class="listar-has-icon icon-calendar-full">' . mb_convert_case( $subscription_period, MB_CASE_TITLE, 'UTF-8' ) . '</p>', 'listar-basic-html' );
											}

											if ( ! empty( trim( wp_strip_all_tags( $subscription_free_period ) ) ) ) {
												echo wp_kses( '<p class="listar-has-icon icon-receipt">' . mb_convert_case( $subscription_free_period, MB_CASE_TITLE, 'UTF-8' ) . '</p>', 'listar-basic-html' );
											}
										endif;
										?>

										<div class="listar-sign-in-button">
											<input class="hidden" type="radio" <?php checked( $checked, $listar_current_post_id ); ?> name="job_package" value="<?php echo $listar_current_post_id; ?>" id="package-<?php echo $listar_current_post_id; ?>" />
											<a class="button listar-package-clickable-area <?php echo sanitize_html_class( $listar_button_class ); ?>" href="#" data-package="<?php echo $listar_current_post_id; ?>">
												<?php echo esc_html( $button_label ); ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<?php
						if ( ! $get_package ) {
							$checked = 0;
						}
					endforeach;
					?>
				</div>
				<!-- End pricing table items -->
				
			</div>
		</div>
		<?php
	endif;
	?>

	<?php 
else :
	?>
	<p>
		<?php esc_html_e( 'No packages found', 'listar' ); ?>
	</p>
	<?php 
endif;

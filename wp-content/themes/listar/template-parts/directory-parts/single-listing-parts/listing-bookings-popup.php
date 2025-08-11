<?php
/**
 * Template part for bookings popup
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_booking_background_image = listar_image_url( get_option( 'listar_booking_background_image' ), 'listar-cover' );
$listar_background_image = empty( $listar_booking_background_image ) ? '0' : $listar_booking_background_image;
$listar_has_background_image = '0' === $listar_background_image ? 'listar-no-background-image' : '';
?>

<!-- Start Booking Popup -->
<div class="listar-booking-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
	<!-- Hero image -->
	<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>"></div>
	<!-- Start Booking forms -->
	<div class="listar-valign-form-holder listar-login-register-form">
		<div class="text-center listar-valign-form-content">
			<div class="listar-panel-form-wrapper">
				<div class="panel listar-panel-form">
					<?php
					global $post;

					$user_id = get_post_field( 'post_author', $post->ID );
					//printf('<pre>%s</pre>', var_export($user_id,true));
			
					if ( false !== strpos( network_site_url(), 'listar.directory' ) ) {
						$user_id = false;
					}

					$query = new WP_Query( array(
						'author'         =>  $user_id,
						'posts_per_page' =>  -1, 
						'post_type'      =>  array( 'product' ),
						'post_status'    =>  'publish',
						'tax_query' => array( array(
							'taxonomy' => 'product_type',
							'terms'    => array( 'booking' ),
							'field'    => 'slug',
						)),
					) );

					$count = (int) $query->found_posts;

					if ( $count > 0 ) :
						while ( $query->have_posts() ) :
							$query->the_post();

							$listar_current_post_id = get_the_ID();
							$listar_post_image = get_the_post_thumbnail_url( $listar_current_post_id, 'large' );
							$listar_bg_image = empty( $listar_post_image ) ? '0' : $listar_post_image;
							?>
							<div class="listar-booking-slide hidden">
								<div class="panel-body">
									<div class="listar-booking-popup-header" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>">
										<h1>
											<?php echo get_the_title(); ?>
										</h1>
										<div class="listar-booking-permalink-wrapper">
											<a href="<?php the_permalink(); ?>" class="listar-booking-permalink">
												<?php esc_html_e( 'Read More', 'listar' ); ?>
											</a>
										</div>
										<div class="listar-booking-navigation hidden">
											<div class="listar-booking-nav-prev fal fa-long-arrow-left"></div>
											<div class="listar-booking-nav-next fal fa-long-arrow-right"></div>
										</div>
									</div>
									<?php
									get_template_part( 'woocommerce/content-single-product-booking', 'popup' );
									?>
								</div>
							</div>
							<?php
							break;
						endwhile;
					else :
						?>
						<div class="panel-heading">
							<div class="listar-login-heading-title">
								<a href="#" class="active listar-login-form-link">
									<?php esc_html_e( 'No bookings available.', 'listar' ); ?>
								</a>
							</div>
						</div>
						<?php

					endif;

					wp_reset_query();
					?>
				</div>
				<div class="listar-panel-form-after"></div>
			</div>
		</div>
	</div>
	<!-- End Booking forms -->
</div>
<!-- End Booking Popup -->
<?php

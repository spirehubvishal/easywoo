<?php
/**
 * Template part for displaying the listing products in single-job_listing
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id = $post->ID;
$listing_products_active = 1 === (int) get_post_meta( $listar_current_post_id, '_job_business_use_products', true );
$products = false;
$products_query = false;
$products_label = listar_get_products_label( $listar_current_post_id );
$has_products = false;
$products_loop = false;

if ( $listing_products_active ) {
	$products_data = get_post_meta( $listar_current_post_id, '_job_business_products_list', true );
	
	if ( is_array( $products_data ) && ! empty( $products_data ) ) {

		/* Get user products */

		$query_args = array(
			'posts_per_page' => 500,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'order'          => 'ASC',
			'post__in'       => $products_data,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => array( 'job_package', 'job_package_subscription' ),
					'operator' => 'NOT IN',
				),
			),
		);

		$products = array();
		$loop = new WP_Query( $query_args );
		
		if ( $loop->have_posts() ) {
			$has_products = true;
			$products_loop = $loop;
		}
	}
}


if ( $has_products ) :
	?>
	<section class="listar-section listar-section-no-padding-bottom">
		<!-- Start section title - For W3C Valitation -->
		<div class="listar-container-wrapper" >
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="listar-section-title">
							<h2 class="listar-title-with-stripe">
								<?php echo esc_html( $products_label ); ?>
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End section title - For W3C Valitation -->

		<div class="listar-container-wrapper" >
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="listar-listing-data listar-listing-products">
							<!-- Start Products grid -->
							<div data-aos="fade-up">
								<div class="row">
									<?php
									while ( $loop->have_posts() ) : $loop->the_post();
										do_action( 'woocommerce_shop_loop' );
										wc_get_template_part( 'content', 'product' );		       
									endwhile;

									wp_reset_query();
									?>
								</div>
							</div>
							<!-- End Products grid -->
						</div>
					</div>
					<div class="col-sm-12 listar-listing-products-more text-center hidden">
						<div>
							<a href="#" class="button listar-light-button">
								<?php esc_html_e( 'Online Store', 'listar' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
	<?php
endif;

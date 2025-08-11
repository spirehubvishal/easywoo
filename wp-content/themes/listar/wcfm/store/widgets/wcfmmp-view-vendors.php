<?php
/**
 * The Template for displaying store sidebar vendors.
 *
 * @package WCfM Markeplace Views Vendors
 *
 */
global $WCFM, $WCFMmp, $wpdb;
//print_r($vendor_id); 
echo wp_kses_post( apply_filters( 'wcfmmp_before_widget_best_selling_vendor_list', '<ul class="row product_list_widget">' ) );

foreach ( $vendors as $key => $value ) {
	$vendor_id = absint( $value[ 'vendor_id' ] );
	$store_name = '';

	$is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
	if ( $is_store_offline )
		continue;

	$is_disable_vendor = get_user_meta( $vendor_id, '_disable_vendor', true );
	if ( $is_disable_vendor )
		continue;

	if ( apply_filters( 'wcfmmp_is_allow_sold_by_linked', true ) ) {
		$store_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint( $vendor_id ) );
	} else {
		$store_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( absint( $vendor_id ) );
	}

	$store_logo = $WCFM->wcfm_vendor_support->wcfm_get_vendor_logo_by_vendor( $vendor_id );
	if ( ! $store_logo ) {
		$store_logo = $WCFMmp->plugin_url . 'assets/images/wcfmmp.png';
	}
	
	$seller_info    = get_user_by( 'slug', $store_name );
	$store_user     = wcfmmp_get_store( $vendor_id );
	$banner         = $store_user->get_banner();
	$default_banner = ! empty( $WCFMmp->wcfmmp_marketplace_options['store_default_banner'] ) ? wcfm_get_attachment_url($WCFMmp->wcfmmp_marketplace_options['store_default_banner']) : $WCFMmp->plugin_url . 'assets/images/default_banner.jpg';
	$listar_blank_placeholder = listar_blank_base64_placeholder_image();
	
	if( !$banner ) {
		$banner = $default_banner;
		$banner = apply_filters( 'wcfmmp_store_default_banner', $banner );
	}
	
	/* Count published products */

	$tax_query = array(
		array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array ( 'job_package', 'job_package_subscription' ),
			'operator' => 'NOT IN',
		),
	);

	$tax_query      = new WP_Tax_Query( $tax_query );
	$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

	$sql  = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) FROM {$wpdb->posts} ";
	$sql .= $tax_query_sql['join'];
	$sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' AND post_author = '" . $vendor_id . "'";
	$sql .= $tax_query_sql['where'];

	$count_products_published = absint( $wpdb->get_var( $sql ) ); // WPCS: unprepared SQL ok.
	?>
	<li class="col-xs-12 col-sm-6 col-md-4 listar-vendor-block">
		<div class="listar-vendor-block-wrapper">
			<a href="<?php echo wcfmmp_get_store_url( $vendor_id ); ?>"></a>
			<div class="listar-vendor-block-inner" style="background-image:url( <?php echo esc_url( $banner ); ?> );"></div>
			<div class="listar-store-products-counter">
				<?php echo esc_html( $count_products_published ); ?>
			</div>
			<div class="listar-vendor-block-content-wrapper">
				<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" style="background-image:url(<?php echo esc_url( $store_logo ); ?>);">
				<span class="product-title"><?php echo $store_name; ?></span>
				<span class="vendor_rating">
					<?php if ( apply_filters( 'wcfm_is_pref_vendor_reviews', true ) ) {
						$WCFMmp->wcfmmp_reviews->show_star_rating( 0, $vendor_id );
					} ?>
				</span>
				<span class="vendor_badges">
					<?php do_action( 'after_wcfmmp_store_list_rating', $vendor_id ); ?>
				</span>
			</div>
		</div>
	</li>



<?php
}
echo wp_kses_post( apply_filters( 'wcfmmp_after_widget_best_selling_vendor_list', '</ul>' ) );

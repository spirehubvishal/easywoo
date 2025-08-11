<?php
/**
 * Integration hooks exclusive for WCFM Marketplace plugin.
 *
 * @package Listar
 */

add_action( 'wp_enqueue_scripts', 'listar_frontend_enqueue_wcfm', 9999 );

function listar_frontend_enqueue_wcfm() {
	$javascript_strict = '
		/* <![CDATA[ */

			( function () {

				"use strict";

				window.chartColors = {
					red: "rgb(232, 62, 140)",
					orange: "rgb(248, 203, 0)",
					yellow: "rgb(255, 193, 7)",
					green: "rgb(0, 124, 186)",
					blue: "rgb(99, 194, 222)",
					purple: "rgb(153, 102, 255)",
					grey: "rgb(201, 203, 207)",
					refund: "rgb(232, 62, 140)",
					withdrawal: "rgb(77, 189, 116)",
					tax: "rgb(115, 129, 143)",
					shipping: "rgb(111, 66, 193)"
				};

			} )();

		/* ]]> */
	';

	wp_add_inline_script( 'jquery-chart_util_js', $javascript_strict );
}


add_action( 'init', 'listar_add_user_roles', 0 );
add_action( 'admin_init', 'listar_add_user_roles', 0 );

if ( ! function_exists( 'listar_add_user_roles' ) ) :
	/**
	 * Fix Marketplace user roles, if not created yet
	 *
	 * @since 1.4.7
	 */
	function listar_add_user_roles() {
		if ( class_exists( 'WCFMmp' ) ) {
			global $WCFMmp;
			
			$vendor_role_exists = wp_roles()->is_role( 'wcfm_vendor' );
			$disable_vendor_role_exists = wp_roles()->is_role( 'disable_vendor' );
			$disable_shop_manager_role_exists = wp_roles()->is_role( 'shop_manager' );
			
			if ( empty( $vendor_role_exists ) ) {
				if ( ! class_exists( 'WCFMmp_Install' ) ) {
					require_once ( $WCFMmp->plugin_path . 'helpers/class-wcfmmp-install.php' );
				}

				$px = new WCFMmp_Install();
				$px->wcfmmp_user_role();
			}

			if ( empty( $disable_vendor_role_exists ) ) {
				add_role( 'disable_vendor', __( 'Disable Vendor', 'listar' ), array( 'level_0' => true ) );
			}

			if ( ! empty( $disable_shop_manager_role_exists ) ) {
				remove_role( 'shop_manager' );
			}
		}
	}
endif;

/* Dequeue styles / scripts */

function listar_call_wcfm_dashboard_assets() {

	/* Marketplace customization */
	wp_enqueue_style( 'listar-marketplace', listar_get_theme_file_uri( '/assets/css/marketplace.css' ), array(), listar_get_theme_version() );
	wp_register_script('listar-marketplace', listar_get_theme_file_uri( '/assets/js/marketplace-dashboard.js' ), array( 'jquery' ), listar_get_theme_version());
	wp_print_scripts('listar-marketplace');
}


add_action( 'wp_enqueue_scripts', 'listar_frontend_enqueue2', 9999 );

add_action( 'admin_init', 'listar_frontend_enqueue3', 10 );


if ( ! function_exists( 'listar_frontend_enqueue2' ) ) :
	function listar_frontend_enqueue2() {
	
		/* Load only in case of front end marketplace dashboards or setup pages */
		if ( listar_is_wcfm_dashboard() || listar_is_wcfm_vendor_setup_page() || listar_is_wcfm_core_setup_page() ) {
			$library = new WCFM_Library();
			
			$library->load_select2_lib();
			
			listar_call_wcfm_dashboard_assets();

			/* Google Fonts */
			wp_enqueue_style( 'listar-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto%3A400%2C500%2C600%2C700%7CQuicksand%3A400%2C500%2C600%2C700&subset=latin-ext&display=swap&ver=5.6.2', array(), false );
		} else {
			wp_dequeue_script( 'select2_js' );		
			wp_dequeue_style( 'select2_css' );
			//wp_dequeue_style( 'wcfm_fa_icon_css' );
			
			wp_dequeue_style( 'wcfm_fa_icon_css' );
			wp_deregister_style( 'wcfm_fa_icon_css' );
			
			if ( ! is_admin() ) {
		
				/* Marketplace customization */
				wp_enqueue_style( 'listar-marketplace', listar_get_theme_file_uri( '/assets/css/marketplace-not-dashboard.css' ), array(  ), listar_get_theme_version() );

				/* Marketplace customization - Moved: Style for store list page must be loaded in footer.php */
			}
		}
	}
	
endif;

if ( ! function_exists( 'listar_frontend_enqueue3' ) ) :
	function listar_frontend_enqueue3() {
	
		/* Load only in case of front end marketplace dashboards or setup pages */
		if ( listar_is_wcfm_dashboard() || listar_is_wcfm_vendor_setup_page() || listar_is_wcfm_core_setup_page() ) {
			listar_call_wcfm_dashboard_assets();
		}
	}
	
endif;

/* Return the Add Listing / Edit Listing pages to WP Job Manager defaults */

add_filter( 'wcfm_is_allow_manage_listings_wcfm_wrapper', 'listar_disable_wcfm_add_listing_page' );

function listar_disable_wcfm_add_listing_page() {
	return false;
}

/* Remove admin menu pages */

add_action( 'admin_init', 'listar_remove_backend_menu_items' );

function listar_remove_backend_menu_items() {
	//echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
	
	if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		if ( function_exists( 'get_wcfm_settings_url' ) ) {

			// Marketplace.
			remove_menu_page( get_wcfm_settings_url() . '#wcfm_settings_form_marketplace_head' );
		}
	}
}


/* Change default store logo */

add_filter( 'wcfmmp_store_default_logo', 'listar_wcfm_default_store_logo', 100 );

function listar_wcfm_default_store_logo() {
	global $wpdb, $blog_id;
	
	// Try WCFM profile image.

	$user_id = apply_filters( 'wcfm_current_vendor_id', get_current_user_id() );
	$wp_user_avatar_id = get_user_meta( $user_id, $wpdb->get_blog_prefix( $blog_id ) . 'user_avatar', true );
	$wp_store_avatar = wp_get_attachment_url( $wp_user_avatar_id );
	
	if ( empty( $wp_store_avatar ) || false !== strpos( $wp_store_avatar, 'assets/images/avatar.png' ) ) {
		$wp_store_avatar = listar_get_theme_file_uri( '/assets/images/marketplace-store-default-logo.png' );
	}
	
	return $wp_store_avatar;
}


/* Enable article for vendors */

add_filter( 'wcfm_is_allow_store_articles', 'listar_wcfm_enable_articles_for_vendors', 100 );

function listar_wcfm_enable_articles_for_vendors() {
	return true;
}

add_action( 'wcfmmp_store_article_loop_in_before', 'listar_wcfm_article_loop_before', 100 );

function listar_wcfm_article_loop_before() {
	?>
	<!-- Start Archive Container  -->
	<div class="" id="products">
		<div class="product_area">
			<div id="products-wrapper" class="products-wrapper">
				<div class="listar-grid listar-white-design listar-results-container row blog">
	<?php
}

add_action( 'wcfmmp_store_article_template', 'listar_wcfm_article_loop', 100 );

function listar_wcfm_article_loop() {
	get_template_part( 'template-parts/blog-parts/loop/loop', 'default' );
}

add_action( 'wcfmmp_store_article_loop_in_after', 'listar_wcfm_article_loop_after', 100 );

function listar_wcfm_article_loop_after() {
	global $wp_query;
	?>				
				</div>
			</div>
		</div>
	</div>
	<!-- End Archive Container  -->
	
	<?php
	/* Don't display the 'listar-more-results' button if there are not enough posts */
	if ( $wp_query->max_num_pages > 1 ) :
		?>
		<div class="row">
			<div class="col-sm-12">
				<?php listar_pagination(); ?>
			</div>
		</div>
		<?php
	endif;
}


add_filter( 'wcfm_formeted_menus', 'listar_wcfm_dashboard_menu', 100, 1 );

function listar_wcfm_dashboard_menu( $menu ) {
	
	$new_value = array (
		'label' => esc_html__( 'Profile', 'listar' ),
		'url' => get_wcfm_profile_url(),
		'icon' => 'user-circle',
		'menu_for' => 'both',
		'priority' => 74,
	);
	
	$new_menu = listar_array_insert_before( 'wcfm-settings', $menu, 'wcfm-profile-edit', $new_value );
	
	return $new_menu;
}

// Cancel Style step for WCFM setup wizard.

add_action( 'admin_init', 'listar_wcfm_cancel_style_step', 10 );

if ( ! function_exists( 'listar_wcfm_cancel_style_step' ) ) :
	/**
	 * Add the claim package to cart.
	 *
	 * @since 1.4.7
	 */
	function listar_wcfm_cancel_style_step() {
		if (
			'wcfm-setup' === filter_input( INPUT_GET, 'page' ) &&
			( 'style' === filter_input( INPUT_GET, 'step' ) || 'registration' === filter_input( INPUT_GET, 'step' ) )
		) {
			wp_redirect( admin_url( 'index.php?page=wcfm-setup' ) );
		}
	}
	
endif;
	

// Cancel step for WCFM setup wizard.

add_filter( 'wcfm_dashboard_setup_steps', 'listar_wcfm_skip_steps' );

function listar_wcfm_skip_steps( $steps ) {
	if ( isset( $steps['style'] ) ) {
		unset( $steps['style'] );
		unset( $steps['registration'] );
	}

	return $steps;
}


/* Set initial configs to WCFM plugin right after activate it */

$listar_wcfm_path =  rtrim( ABSPATH,'/' ) . '\wp-content\plugins\wc-frontend-manager\wc_frontend_manager.php';
$listar_wcfm_path2 = false !== strpos( $listar_wcfm_path, '/' ) ? str_replace( '\\', '/', $listar_wcfm_path ) : $listar_wcfm_path;

register_activation_hook( $listar_wcfm_path2, 'listar_wcfm_activate' );
add_action( 'admin_init', 'listar_wcfm_after_activation' );

function listar_wcfm_activate() {
	add_option( 'listar_after_activate_wcfm', 'true' );
}

function listar_wcfm_after_activation() {
	if ( 'true' === get_option( 'listar_after_activate_wcfm' ) ) {
		$options = get_option( 'wcfm_options' );
		$options['wcfm_ultimate_notice_disabled'] = 'yes';
		update_option( 'wcfm_options', $options );
		listar_modify_listing_publication_roles( 'wcfm_vendor', '1' );
	}

	delete_option( 'listar_after_activate_wcfm' );
}


/* Set initial configs to WCFMFP plugin right after activate it */

$listar_wcfmmp_path =  rtrim( ABSPATH,'/' ) . '\wp-content\plugins\wc-multivendor-marketplace\wc-multivendor-marketplace.php';
$listar_wcfmmp_path2 = false !== strpos( $listar_wcfmmp_path, '/' ) ? str_replace( '\\', '/', $listar_wcfmmp_path ) : $listar_wcfmmp_path;

register_activation_hook( $listar_wcfmmp_path2, 'listar_wcfmmp_activate' );
add_action( 'admin_init', 'listar_wcfmmp_after_activation' );

function listar_wcfmmp_activate() {
	add_option( 'listar_after_activate_wcfmmp', 'true' );
}

function listar_wcfmmp_after_activation() {
	if ( 'true' === get_option( 'listar_after_activate_wcfmmp' ) ) {
		listar_modify_listing_publication_roles( 'wcfm_vendor', '1' );
	}

	delete_option( 'listar_after_activate_wcfmmp' );
}

/*
 * Disable "Vendors Capability: Associate your WCFM with WCFM - Groups & Staffs to access this feature." notices
 */

add_filter( 'is_wcfmgs_inactive_notice_show', 'listar_disable_wcfmgs_notices', 100 );

function listar_disable_wcfmgs_notices() {
	return false;
}

/*
 * Deny certain product types on WCFM dashboard lists
 */

add_filter( 'wcfm_products_args', 'listar_remove_wcfm_product_types' );

function listar_remove_wcfm_product_types( $args ) {
	$args['tax_query'] = array( array(
		'taxonomy' => 'product_type',
		'field'    => 'slug',
		'terms'    => array( 'job_package', 'job_package_subscription' ),
		'operator' => 'NOT IN',
	) );
	
	return $args;
}

/*
 * Deny WCFMMP "Add To My Store".
 */

add_filter( 'wcfmmp_is_allow_single_product_multivendor', 'listar_disable_product_multivendor' );

function listar_disable_product_multivendor() {
	return false;
}

/*
 * Limit the number of products per vendor
 */

add_filter( 'wcfm_vendor_product_limit', 'listar_product_limit_per_vendor', 700, 2 );

function listar_product_limit_per_vendor( $limit = 0, $vendor_id = 0  ) {	
	if ( empty( $vendor_id ) ) {
		return false;
	}
	
	$is_administrator = false;
	$user_meta = get_userdata( $vendor_id );
	$user_roles = $user_meta->roles;

	if ( in_array( 'administrator', $user_roles, true ) ) {
		$is_administrator = true;
	}
	
	if ( $is_administrator ) {
		return false;
	}
	
	if ( listar_is_wcfm_active() ) {
		$limit = listar_count_store_products_allowed( $vendor_id );
	} else {
		$limit = 0;
	}

	if ( ( 0 === $limit || -1 === $limit ) ) {
		return false;
	}

	return $limit;
}

/*
 * Limit the disk space per vendor
 */

add_filter( 'wcfm_vendor_space_limit', 'listar_disk_limit_per_vendor', 700, 2 );

function listar_disk_limit_per_vendor( $limit = 0, $vendor_id = 0  ) {
	if ( empty( $vendor_id ) ) {
		return false;
	}

	$is_administrator = false;
	$user_meta = get_userdata( $vendor_id );
	$user_roles = $user_meta->roles;

	if ( in_array( 'administrator', $user_roles, true ) ) {
		$is_administrator = true;
	}
	
	if ( $is_administrator ) {
		return false;
	}
	
	if ( listar_is_wcfm_active() ) {
		$limit = listar_count_disk_store_allowed( $vendor_id );
	} else {
		$limit = 0;
	}

	if ( ( 0 === $limit || -1 === $limit ) ) {
		return false;
	}
	
	return $limit;
}


/*
 * Show restriction message if expired package for vendors.
 */

add_action( 'wcfm_restriction_message_show_after', 'listar_show_package_expired_message' );

function listar_show_package_expired_message() {
	?>
	<div class="wcfm-warn-message wcfm-wcfmu hidden listar-wcfm-warning-message">
		<p>
			<span class="wcfmfa fa-exclamation-triangle"></span>
			<strong><?php esc_html_e( 'Tip', 'listar' ); ?></strong>: <?php esc_html_e( 'Do you have a listing package expired? Please check.', 'listar' ); ?>
		</p>
	</div>
	<?php
}


/*
 * Deny product management for vendors.
 */

add_filter( 'wcfm_is_allow_manage_products', 'listar_allow_manage_products', 700 );

function listar_allow_manage_products( $allow ) {
	
	if ( current_user_can( 'administrator' ) ) {
		return true;
	}
	
	if ( listar_is_wcfm_active() && listar_is_wcfmmp_active() && current_user_can( 'wcfm_vendor' ) ) {
		$vendor_id = get_current_user_id();
		
		if ( listar_is_vendor_authorized( $vendor_id ) ) {			
			$allow = true;
		} else {
			$allow = false;
		}
	} else {
		$allow = false;
	}
	
	return $allow;
}

function array_splice_assoc( &$input, $offset, $length, $replacement ) {
	$replacement = ( array ) $replacement;
	$key_indices = array_flip( array_keys( $input ) );
	if ( isset( $input[ $offset ] ) && is_string( $offset ) ) {
		$offset = $key_indices[ $offset ];
	}
	if ( isset( $input[ $length ] ) && is_string( $length ) ) {
		$length = $key_indices[ $length ] - $offset;
	}

	$input = array_slice( $input, 0, $offset, TRUE ) + $replacement + array_slice( $input, $offset + $length, NULL, TRUE );
}

function array_move( $which, $where, $array ) {
	$tmpWhich = $which;
	$j = 0;
	$keys = array_keys( $array );

	for ( $i = 0; $i < count( $array ); $i ++  ) {
		if ( $keys[ $i ] == $tmpWhich )
			$tmpWhich = $j;
		else
			$j ++;
	}
	$tmp = array_splice( $array, $tmpWhich, 1 );
	array_splice_assoc( $array, $where, 0, $tmp );
	return $array;
}


add_filter( 'wcfm_formeted_menus', 'listar_reorder_wcfm_menu', 9999 );

function listar_reorder_wcfm_menu( $menu ) {
	$order = -1;

	if ( ! empty( $menu ) ) {
		$order++;
		$reorder = 'wcfm-listings';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
	}

	if ( ! empty( $menu ) ) {
		$order++;
		$reorder = 'wcfm-products';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
	}

	if ( ! empty( $menu ) ) {
		$order++;
		$reorder = 'wcfm-coupons';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
	}

	if ( ! empty( $menu ) ) {
		$order++;
		$reorder = 'wcfm-bookings';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
		$reorder = 'wcfm-bookings-dashboard';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
	}

	if ( ! empty( $menu ) ) {
		$order++;
		$reorder = 'wcfm-articles';
		$menu = isset( $menu[ $reorder ] ) ? array_move( $reorder, $order, $menu ) : $menu;
	}
	
	return $menu;
}


function wcfm_2510_product_manage_fields_general( $general_fields, $product_id, $product_type ) {
	global $WCFM;
	
	if( isset( $general_fields['_wc_booking_has_resources'] ) ) {
		
		//printf('<pre>%s</pre>', var_export(get_post_meta( $product_id, '_wc_booking_has_resources', true),true));
		//printf('<pre>%s</pre>', var_export(get_post_meta( $product_id, '_wc_booking_has_persons', true),true));
		
		$has_resources = ( '1' === get_post_meta( $product_id, '_wc_booking_has_resources', true) ) ? 'yes' : 'enable';
		
		//$general_fields['_wc_booking_has_resources']['dfvalue'] = $has_resources;
		$general_fields['_wc_booking_has_resources']['value'] = $has_resources;
	}

	if( isset( $general_fields['_wc_booking_has_persons'] ) ) {
		$has_persons = ( '1' === get_post_meta( $product_id, '_wc_booking_has_persons', true) ) ? 'yes' : 'enable';

		//$general_fields['_wc_booking_has_persons']['dfvalue'] = $has_persons;
		$general_fields['_wc_booking_has_persons']['value'] = $has_persons;
	}
	
	return $general_fields;
}
add_filter( 'wcfm_product_manage_fields_general', 'wcfm_2510_product_manage_fields_general', 100, 3 );



/* Converts a Subscriber to Vendor */

add_action( 'wp', 'listar_convert_subscriber_to_vendor', 0 );

function listar_convert_subscriber_to_vendor( $wp = false, $user_id = '0', $requires_logged = true, $requires_query_var = true ) {
	$query_var_vendor = (int) get_query_var( 'become_vendor' );

	if ( ! listar_is_wcfm_active() || ! listar_is_wcfmmp_active() ) {
		return false;
	}

	if ( $requires_logged && ! is_user_logged_in() ) {
		return false;
	}

	if ( $requires_query_var && 1 !== $query_var_vendor ) {
		return false;
	}
	
	if ( empty( $user_id ) && is_user_logged_in() ) {
		$user_id = get_current_user_id();
	}
	
	if ( empty( $user_id ) ) {
		return false;
	}
	
	if ( ! current_user_can( 'subscriber' ) ) {
		return false;
	}
	
	$u = new WP_User( $user_id );
	$u->set_role( 'wcfm_vendor' );
	
	update_user_meta( $user_id, '_store_setup', 'yes' );
	
	wp_redirect( network_site_url( '?store-setup=yes' ) );
	exit();
}

add_filter( 'wcfm_product_manage_fields_general', 'wcfmbi_product_manage_fields_general', 100, 3 );
function wcfmbi_product_manage_fields_general( $general_fields, $product_id, $product_type ) {
	global $WCFM, $WCFMpb;
	
	if( isset( $general_fields['_wc_booking_has_resources'] ) ) {
		$general_fields['_wc_booking_has_resources']['class'] = 'wcfm_custom_hide';
		$general_fields['_wc_booking_has_resources']['desc_class'] = 'wcfm_custom_hide';
		$general_fields['_wc_booking_has_resources']['dfvalue'] = 'no';
	}
		
	if( isset( $general_fields['_wc_booking_has_persons'] ) ) {
		$general_fields['_wc_booking_has_persons']['class'] = 'wcfm_custom_hide';
		$general_fields['_wc_booking_has_persons']['desc_class'] = 'wcfm_custom_hide';
		$general_fields['_wc_booking_has_persons']['dfvalue'] = 'no';
	}
		
	return $general_fields;
}


add_action( 'init', 'listar_disable_vendor_badges', 0 );


function listar_disable_vendor_badges() {
	$wcfm_options = get_option( 'wcfm_options' );
	
	if ( isset( $wcfm_options['module_options'] ) ) {
		$disable = array(
			'membership',
			'vendor_badges',
			'vendor_followers',
			'chatbox',
			'vendor_verification',
			'catalog',
			'sell_items_catalog',
			'product_popup',
			'product_mulivendor',
		);
		
		foreach ( $disable as $d ) {
			$wcfm_options['module_options'][ $d ] = 'yes';
		}
		
		update_option( 'wcfm_options', $wcfm_options );
	}
}

add_action( 'init', 'listar_remove_admin_notices' );

function listar_remove_admin_notices() {
	remove_action( 'admin_notices', 'WCFMu_License::license_inactive_notice' );
	remove_filter( 'pre_set_site_transient_update_plugins', 'update_check', 999 );
	remove_filter( 'pre_set_site_transient_update_themes', 'update_check', 999 );
}

remove_filter( 'pre_set_site_transient_update_plugins', 'update_check', 999 );
remove_filter( 'pre_set_site_transient_update_themes', 'update_check', 999 );


function listar_filter_woocommerce_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = null, $variations = null ) {
	$vendors_cart_restriction = 1 === (int) get_option( 'listar_restrict_cart_per_vendor' );
	$product_cart_restriction = 1 === (int) get_option( 'listar_restrict_cart_per_product' );
	$empty_cart_restriction   = 1 === (int) get_option( 'listar_restrict_empty_cart_per_product' );
	$link = '<a href="' . wc_get_cart_url() .'">' . esc_html__( 'Go to the cart', 'listar' ) . '</a>';
	
	// Cart NOT empty
	if ( $empty_cart_restriction && ! WC()->cart->is_empty() ) {
		WC()->cart->empty_cart();
	} else if ( $product_cart_restriction && ! WC()->cart->is_empty() ) {
		
		// Add notice    
		wc_add_notice(
			sprintf(

				/* TRANSLATORS: %s: Link to the Woocommerce shopping cart. */
				esc_html__( 'Only one product is allowed in the cart. %s', 'listar' ),
				wp_kses( $link, 'listar-basic-html' )
			),
			'error'
		);
		
		$passed = false;
	} else if ( $vendors_cart_restriction && ! WC()->cart->is_empty() ) {
		// Retrieves post data given a post ID or post object.
		$product = get_post( $product_id );

		// Post author
		$product_author = $product->post_author;

		// Flag, by default false
		$flag = false;

		// Loop trough cart
		foreach ( WC()->cart->get_cart() as $cart_item ) {
			// Get product ID
			$cart_product_id = $cart_item[ 'data' ]->get_id();

			// Get post
			$cart_product = get_post( $cart_product_id );

			// Post author
			$cart_product_author = $cart_product->post_author;

			// Condition NOT equal
			if ( $cart_product_author != $product_author ) {
				$flag = true;

				// Break loop
				break;
			}
		}

		// True
		if ( $flag ) {

			// Add notice    
			wc_add_notice(
				sprintf(

					/* TRANSLATORS: %s: Link to the Woocommerce shopping cart. */
					esc_html__( 'Products from different vendors are not allowed in the cart. %s', 'listar' ),
					wp_kses( $link, 'listar-basic-html' )
				),
				'error'
			);

			// NOT passed
			$passed = false;
		}
	}

	return $passed;
}

add_filter( 'woocommerce_add_to_cart_validation', 'listar_filter_woocommerce_add_to_cart_validation', 10, 5 );

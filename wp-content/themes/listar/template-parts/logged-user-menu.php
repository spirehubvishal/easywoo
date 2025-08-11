<?php
/**
 * Template part for displaying user nav menu (if logged in) in header.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

?>
<!-- Start User Buttons -->
<?php
$is_vendor = listar_is_wcfm_active() && listar_is_wcfmmp_active() ? wcfm_is_vendor() : false;
$listar_vendor_authorized = listar_is_vendor_authorized();
$vendor_registration_page_id = absint( get_option( 'wcfm_vendor_registration_page_id' ) );
$vendor_page_url = ! empty( $vendor_registration_page_id ) && 'publish' === get_post_status( $vendor_registration_page_id ) ? get_page_link( $vendor_registration_page_id ) : '';
$wcfm_dashboard_url = listar_is_wcfm_active() ? get_wcfm_page() : '';

if ( is_string( $vendor_page_url ) ) {
	if ( false !== strpos( $vendor_page_url, 'trash' ) || empty( $vendor_page_url ) ) {
		$vendor_page_url = network_site_url( '?s=&become_vendor=1' );
	}
} else {
	$vendor_page_url = network_site_url( '?s=&become_vendor=1' );
}

if ( isset( wp_get_current_user()->roles[0] ) ) :
	if ( 'administrator' === wp_get_current_user()->roles[0] || 'editor' === wp_get_current_user()->roles[0] ) :
		?>
		<li class="listar-admin-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( admin_url() ); ?>">
				<i class="icon-cog"></i> <?php esc_html_e( 'Admin Dashboard', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;
endif;

if ( class_exists( 'WooCommerce' ) && listar_is_wcfm_active() ) :
	if ( $listar_vendor_authorized && ! $is_vendor && ! empty( $vendor_page_url ) && current_user_can( 'subscriber' ) && listar_is_wcfmmp_active() ) :
		?>
		<li class="listar-user-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( $vendor_page_url ); ?>">
				<i class="fal fa-store-alt"></i> <?php esc_html_e( 'Become A Vendor!', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;
	
	if ( ! empty( $wcfm_dashboard_url ) && listar_is_wcfm_active() ) :
		if ( current_user_can( 'administrator' ) || current_user_can( 'wcfm_vendor' ) ) :
			$string1 = listar_is_wcfmmp_active() ? esc_html__( 'Marketplace Dashboard', 'listar' ) : esc_html__( 'Front End Dashboard', 'listar' );
			$string2 = listar_is_wcfmmp_active() ? esc_html__( 'Marketplace Settings', 'listar' ) : esc_html__( 'Store Settings', 'listar' );

			if ( current_user_can( 'wcfm_vendor' ) ) :
				$string1 = esc_html__( 'Store Dashboard', 'listar' );
				$string2 = esc_html__( 'Store Settings', 'listar' );
			endif;
			
			if ( ( $is_vendor && listar_is_wcfmmp_active() ) || current_user_can( 'administrator' ) ) :
				?>
				<li class="listar-user-dashboard listar-iconized-menu-item">
					<a href="<?php echo esc_url( $wcfm_dashboard_url ); ?>">
						<i class="fal fa-store-alt"></i> <?php echo esc_html( $string1 ); ?>
					</a>
				</li>
				<li class="listar-user-dashboard listar-iconized-menu-item">
					<a href="<?php echo esc_url( $wcfm_dashboard_url . 'settings/' ); ?>">
						<i class="fal fa-store-alt"></i> <?php echo esc_html( $string2 ); ?>
					</a>
				</li>
				<?php
			endif;
		endif;
	endif;
endif;

if ( isset( wp_get_current_user()->roles[0] ) ) :

	if ( 'administrator' === wp_get_current_user()->roles[0] ) :
		?>
		<li class="listar-admin-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( admin_url( 'themes.php?page=listar_options' ) ); ?>">
				<i class="icon-cog"></i> <?php esc_html_e( 'Theme Options', 'listar' ); ?>
			</a>
		</li>
		<li class="listar-admin-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">
				<i class="icon-cog"></i> <?php esc_html_e( 'Customize', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;

endif;

$listar_myaccount_page_id    = (int) get_option( 'woocommerce_myaccount_page_id' );
$listar_my_account_url       = ! empty( $listar_myaccount_page_id ) ? get_permalink( $listar_myaccount_page_id ) : '';
$listar_can_publish_listings = listar_user_can_publish_listings();

if ( class_exists( 'WooCommerce' ) && ! empty( $listar_my_account_url ) ) :
	?>
	<li class="listar-user-dashboard listar-iconized-menu-item">
		<a href="<?php echo esc_url( $listar_my_account_url ); ?>">
			<i class="icon-cog"></i> <?php esc_html_e( 'User Dashboard', 'listar' ); ?>
		</a>
	</li>
	<?php
endif;

if ( class_exists( 'WP_Job_Manager' ) ) :
	
	if ( $listar_can_publish_listings ) :
		$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

		if ( ! empty( $listar_add_listing_form_url ) ) :
			?>
			<li class="listar-add-listing listar-iconized-menu-item">
				<a href="<?php echo esc_url( $listar_add_listing_form_url ); ?>">
					<i class="icon-map-marker-down"></i> <?php esc_html_e( 'Add Listing', 'listar' ); ?>
				</a>
			</li>
			<?php
		endif;
	endif;

	$listar_job_dashboard_url = job_manager_get_permalink( 'job_dashboard' );

	if ( ! empty( $listar_job_dashboard_url ) ) :
		?>
		<li class="listar-job-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( $listar_job_dashboard_url ); ?>">
				<i class="icon-map-marker"></i> <?php esc_html_e( 'Your Listings', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;
	
	$bookmarks_active = listar_bookmarks_active();

	if ( $bookmarks_active ) :
		$url = network_site_url() . '?s=&' . listar_url_query_vars_translate( 'bookmarks_page' ) . '&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
		?>
		<li class="listar-job-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( $url ); ?>">
				<i class="icon-heart"></i> <?php esc_html_e( 'Bookmarks', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;

endif;

if ( class_exists( 'WooCommerce' ) ) :
	if ( ( current_user_can( 'administrator' ) && listar_is_wcfm_active() ) || ( $is_vendor && listar_is_wcfm_active() && listar_is_wcfmmp_active() ) ) :
		if ( ! empty( $wcfm_dashboard_url ) ) :
			?>
			<li class="listar-edit-profile listar-iconized-menu-item">
				<a href="<?php echo esc_url( $wcfm_dashboard_url . 'profile/' ); ?>">
					<i class="icon-register"></i> <?php esc_html_e( 'Edit Profile', 'listar' ); ?>
				</a>
			</li>
			<?php
		elseif ( ! empty( $listar_my_account_url ) ) :
			?>
			<li class="listar-edit-profile listar-iconized-menu-item">
				<a href="<?php echo esc_url( $listar_my_account_url ) . 'edit-account/'; ?>">
					<i class="icon-register"></i> <?php esc_html_e( 'Edit Profile', 'listar' ); ?>
				</a>
			</li>
			<?php
		endif;
	elseif ( ! empty( $listar_my_account_url ) ) :
		?>
		<li class="listar-edit-profile listar-iconized-menu-item">
			<a href="<?php echo esc_url( $listar_my_account_url ) . 'edit-account/'; ?>">
				<i class="icon-register"></i> <?php esc_html_e( 'Edit Profile', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;
endif;
?>

<li class="listar-logout listar-iconized-menu-item">
	<a href="<?php echo esc_url( wp_logout_url( network_site_url() ) ); ?>">
		<i class="icon-unlock"></i> <?php esc_html_e( 'Log Out', 'listar' ); ?>
	</a>
</li>
<!-- End User Buttons -->

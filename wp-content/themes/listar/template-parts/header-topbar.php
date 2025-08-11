<?php
/**
 * Template part for displaying the header topbar in header.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_user_logged_in    = is_user_logged_in();
$listar_login_url         = listar_addons_active() ? '#' : wp_login_url( network_site_url( '/' ) );
$listar_custom_logo       = get_theme_mod( 'custom_logo' );
$listar_not_logged_topbar = ! is_user_logged_in() ? 'listar-not-logged-topbar' : 'listar-logged-topbar';
$listar_is_front_page     = listar_is_front_page_template();
?>

<!-- Start header (topbar) -->
<header id="masthead" class="site-header listar-light-design <?php echo sanitize_html_class( $listar_not_logged_topbar ); ?>">
	<!-- Start Header Wavy animation -->
	<div class="listar-header-background-animation-wrapper">
		<div class="listar-fallback-menu-background"></div>
		<svg class="listar-header-wavy-animation" viewBox="0 0 19000 2324" preserveAspectRatio="none">
			<g transform="translate(0,2330)">
				<path fill="#23282d" stroke-width="5" stroke="#23282d" transform="scale(1,-1)" d="M 0 30 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0  q 40 -40 80 0 q 40 40 80 0 q 40 -40 80 0 q 40 40 80 0 l 0 2324 l -19800 0 z"></path>
			</g>
		</svg>
	</div>
	<!-- End Header Wavy animation -->

	<!-- Start Logo -->
	<div class="listar-site-branding listar-logo">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<?php
					if ( ! empty( $listar_custom_logo ) ) :
						$logo_url = wp_get_attachment_image_src( $listar_custom_logo, 'large' );
						
						if ( isset( $logo_url[0] ) && ! empty( $logo_url[0] ) ) :
							$listar_blank_placeholder = listar_blank_base64_placeholder_image();
							?>
							<a href="<?php echo esc_url( network_site_url( '/' ) ); ?>" class="custom-logo-link" rel="home" aria-current="page">
								<img src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $logo_url[0] ) ); ?>" class="custom-logo" alt="Listar" height="3723483" width="10803321" />
							</a>
							<?php
						endif;
					else :
						$listar_site_name = get_bloginfo( 'name' );
						echo wp_kses( '<a href="' . esc_url( network_site_url( '/' ) ) . '">' . $listar_site_name . '</a>', 'listar-basic-html' );
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
	<!-- End Logo -->

	<!-- Start Main Navbar (Primary Menu) -->
	<nav class="navbar listar-main-navbar navbar-inverse" id="site-navigation">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<?php if ( ! $listar_user_logged_in ) : ?>
						<div class="listar-user-buttons listar-user-buttons-responsive">
							<a href="<?php echo esc_url( $listar_login_url ); ?>" class="listar-user-login">
								<?php esc_html_e( 'Log In', 'listar' ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="listar-primary-navigation-wrapper">

						<?php if ( $listar_user_logged_in ) : ?>
							<div class="listar-user-buttons">
								<a href="#" class="listar-user-login"></a>
							</div>
						<?php else : ?>

							<!-- Start User Buttons -->
							<div class="listar-user-buttons">

								<a href="<?php echo esc_url( $listar_login_url ); ?>" class="listar-user-login">
									<span>
										<?php esc_html_e( 'Login', 'listar' ); ?>
									</span>
								</a>

								<?php
								$listar_can_publish_listings = listar_user_can_publish_listings();

								if ( class_exists( 'WP_Job_Manager' ) && $listar_can_publish_listings ) :

									$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

									if ( ! empty( $listar_add_listing_form_url ) ) :
										?>
										<a href="<?php echo esc_url( $listar_add_listing_form_url ); ?>" class="listar-add-listing-btn">
											<span>
												<?php esc_html_e( 'Add Listing', 'listar' ); ?>
											</span>
										</a>
										<?php
									endif;
								endif;
								?>

							</div>
							<!-- End User Buttons -->

						<?php endif; ?>

						<?php
						if ( has_nav_menu( 'primary-menu' ) ) :

							/* Use Listar's Primary Menu to header: primary-menu */
							$listar_menu_defaults = array(
								'container'      => 'div',
								'container_id'   => 'listar-primary-menu',
								'menu_class'     => 'nav navbar-nav navbar-right primary-menu',
								'echo'           => false,
								'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location' => 'primary-menu',
							);

							$listar_header_menu = wp_nav_menu( $listar_menu_defaults );

							/* Cleaning for W3C validation */
							echo wp_kses( str_replace( ' />', ' >', str_replace( '<ul/', '<ul', $listar_header_menu ) ), 'listar-basic-html' );

						else :
							?>
							<div id="listar-primary-menu" class="listar-primary-menu-mobile">
								<ul id="menu-primary-menu" class="nav navbar-nav navbar-right primary-menu">

									<?php
									$listar_can_publish_listings = listar_user_can_publish_listings();

									if ( ! $listar_user_logged_in ) {
										/**
										 * If the client decided don't set a primary menu,
										 * it is needed to output at least the 'Add Listing' and 'Login' buttons
										 * to be shown on mobile menu (hamburguer).
										 * Only visible if user is not logged in.
										 */
										if ( class_exists( 'WP_Job_Manager' ) && $listar_can_publish_listings ) :
											$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

											if ( ! empty( $listar_add_listing_form_url ) ) {
												?>
												<li class="menu-item listar-add-listing-main-menu">
													<a class="icon-map-marker-down" href="<?php echo esc_url( $listar_add_listing_form_url ); ?>">
														<span>
															<?php esc_html_e( 'Add Listing', 'listar' ); ?>
														</span>
													</a>
												</li>
												<?php
											}
										endif;
										?>
										<li class="menu-item">
											<a href="<?php echo esc_url( $listar_login_url ); ?>" class="listar-user-login-mobile">
												<?php esc_html_e( 'Log In', 'listar' ); ?>
											</a>
										</li>

										<?php
									} else {
										?>
										<li class="menu-item menu-item-has-children listar-iconized-menu-item dropdown listar-account-menu-item">
											<a class="icon-user-lock" href="#">
												<?php esc_html_e( 'Your Account', 'listar' ); ?>
											</a>
											<ul class="dropdown-menu"></ul>
										</li>
										<?php
									}
									?>
								</ul>
							</div>
							<?php
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<!-- End Main Navbar (Primary Menu) -->

	<?php if ( $listar_user_logged_in ) : ?>

		<nav class="listar-logged-user-menu-wrapper">
			<div class="listar-logged-user-menu-inner">
				<ul id="listar-logged-user-menu-list" class="listar-logged-user-menu-list collapse out">
					<li class="listar-logged-user-name">
						<?php echo esc_html( listar_user_name() ); ?>
					</li>
					<?php get_template_part( 'template-parts/logged-user', 'menu' ); ?>
				</ul>
			</div>
		</nav>

	<?php endif; ?>

	<!-- Start User Buttons for Mobile -->
	<div class="listar-mobile-user-buttons listar-user-buttons">

		<a href="<?php echo esc_url( $listar_login_url ); ?>" class="listar-user-login">
			<span></span>
		</a>

		<?php
		$listar_can_publish_listings = listar_user_can_publish_listings();

		if ( class_exists( 'WP_Job_Manager' ) && $listar_can_publish_listings ) :

			$listar_add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

			if ( ! empty( $listar_add_listing_form_url ) ) :
				?>
				<a href="<?php echo esc_url( $listar_add_listing_form_url ); ?>" class="listar-add-listing-btn">
					<span></span>
				</a>
				<?php
			endif;
		endif;
		?>

	</div>
	<!-- End User Buttons for Mobile -->

	<?php
	$use_search_button_front_page = 1 === (int) get_option( 'listar_activate_search_button_front' ) ? true : false;

	if ( ( ! $listar_is_front_page || $use_search_button_front_page ) && class_exists( 'WP_Job_Manager' ) ) : ?>
		<!-- Header Search Button for mobiles -->
		<div class="listar-header-search-button listar-search-button-mobile"></div>
	<?php endif; ?>

</header>
<!-- End header (topbar) -->

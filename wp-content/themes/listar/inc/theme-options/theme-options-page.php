<?php
/**
 * Custom 'Theme Options' Menu to WordPress admin
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://simplelineicons.github.io/
 *
 * @package Listar
 */

?>

<div id="loading-options">
	<?php $listar_loading_spinner = listar_get_theme_file_uri( '/assets/images/spinner.gif' ); ?>
	<img src="<?php echo esc_url( $listar_loading_spinner ); ?>" />
</div>

<div id="scoop" class="scoop">
	<div class="scoop-overlay-box"></div>
	<div class="scoop-container">  
		<header class="scoop-header">
			<div class="scoop-wrapper"> 
				<div class="scoop-left-header"> </div>
				<div class="scoop-right-header"> 
					<div class="sidebar_toggle">
						<a href="javascript:void(0)">
							<i class="simple-icon-menu"></i>
						</a>
					</div> 
				</div>
				<div class="scoop-branding">
					<div class="scoop-project-name">Listar</div>
					<div class="scoop-project-version">
						<?php echo esc_html( listar_get_theme_version() ); ?>
					</div>
				</div>
			</div>
		</header>
		<div class="scoop-main-container">
			<div class="scoop-wrapper">
				<nav class="scoop-navbar">  
					<div class="sidebar_toggle">
						<a href="#">
							<i class="simple-icon-close icons"></i>
						</a>
					</div>
					<div class="scoop-inner-navbar"> 
						<ul class="scoop-item scoop-left-item">
							<li>
								<a href="http://themeserver.site/wp-themes/listar/docs/" target="_blank">
									<span class="scoop-micon">
										<i class="simple-icon-notebook"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Documentation', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>
							<?php
							$current_site_url = network_site_url();

							if ( false !== strpos( $current_site_url, 'localhost/wordpress' ) || false !== strpos( $current_site_url, 'wt.ax' ) || false !== strpos( $current_site_url, 'listar.directory' ) ) :
								?>
								<li>
									<a href="javascript:void(0)" data-id="__edit-export">
										<span class="scoop-micon">
											<i class="simple-icon-share-alt"></i>
										</span>
										<span class="scoop-mtext">
											<?php esc_html_e( 'Export', 'listar' ); ?>
										</span>
										<span class="scoop-mcaret"></span>
									</a>
								</li>
								<?php
							endif;
							?>

							<?php if ( post_type_exists( 'job_listing' ) ) : ?>
								<li>
									<a href="javascript:void(0)" data-id="__directory-config">
										<span class="scoop-micon">
											<i class="simple-icon-location-pin"></i>
										</span>
										<span class="scoop-mtext">
											<?php esc_html_e( 'Listings', 'listar' ); ?>
										</span>
										<span class="scoop-mcaret"></span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-id="__edit-design">
										<span class="scoop-micon">
											<i class="simple-icon-vector"></i>
										</span>
										<span class="scoop-mtext">
											<?php esc_html_e( 'Design', 'listar' ); ?>
										</span>
										<span class="scoop-mcaret"></span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-id="__edit-effects">
										<span class="scoop-micon">
											<i class="simple-icon-magic-wand"></i>
										</span>
										<span class="scoop-mtext">
											<?php esc_html_e( 'Effects', 'listar' ); ?>
										</span>
										<span class="scoop-mcaret"></span>
									</a>
								</li>
								<?php if ( listar_addons_active() ) : ?>
									<li>
										<a href="javascript:void(0)" data-id="__edit-pagespeed">
											<span class="scoop-micon">
												<i class="simple-icon-speedometer"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Pagespeed', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-search">
											<span class="scoop-micon">
												<i class="simple-icon-magnifier"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Search and Archive', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-type-search">
											<span class="scoop-micon">
												<i class="simple-icon-magnifier-add"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Explore By Types', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__distance-metering">
											<span class="scoop-micon">
												<i class="simple-icon-target"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Distance Metering', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__views-counter">
											<span class="scoop-micon">
												<i class="simple-icon-eye"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Views counter', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<?php
									if ( ! listar_third_party_reviews_active() ) :
										?>
										<li>
											<a href="javascript:void(0)" data-id="__reviews">
												<span class="scoop-micon">
													<i class="simple-icon-star"></i>
												</span>
												<span class="scoop-mtext">
													<?php esc_html_e( 'Reviews', 'listar' ); ?>
												</span>
												<span class="scoop-mcaret"></span>
											</a>
										</li>
										<?php
									endif;
									?>
									<li>
										<a href="javascript:void(0)" data-id="__bookmarks">
											<span class="scoop-micon">
												<i class="simple-icon-heart"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Bookmarks', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__claims">
											<span class="scoop-micon">
												<i class="simple-icon-check"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Claims', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-trending">
											<span class="scoop-micon">
												<i class="simple-icon-energy"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Trending', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-messages">
											<span class="scoop-micon">
												<i class="simple-icon-envelope-open"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Messages', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-reports">
											<span class="scoop-micon">
												<i class="simple-icon-ban"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Complaint Report', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<?php
									/* Covers Astoundify and Automattic Payment plugins */
									if ( 0 === 1 && ( class_exists( 'Woocommerce' ) && ( defined( 'ASTOUNDIFY_WPJMLP_VERSION' ) || class_exists( 'WC_Paid_Listings' ) ) ) ) :
										?>
										<li>
											<a href="javascript:void(0)" data-id="__edit-payments">
												<span class="scoop-micon">
													<i class="simple-icon-wallet"></i>
												</span>
												<span class="scoop-mtext">
													<?php esc_html_e( 'Payments', 'listar' ); ?>
												</span>
												<span class="scoop-mcaret"></span>
											</a>
										</li>
										<?php
									endif;
									?>
									<li>
										<a href="javascript:void(0)" data-id="__edit-map">
											<span class="scoop-micon">
												<i class="simple-icon-map"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Maps', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" data-id="__edit-shopping">
											<span class="scoop-micon">
												<i class="simple-icon-basket"></i>
											</span>
											<span class="scoop-mtext">
												<?php esc_html_e( 'Shopping', 'listar' ); ?>
											</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<?php
									if ( listar_is_wcfm_active() && listar_is_wcfmmp_active() ) :
										?>
										<li>
											<a href="javascript:void(0)" data-id="__edit-marketplace">
												<span class="scoop-micon">
													<i class="simple-icon-basket-loaded"></i>
												</span>
												<span class="scoop-mtext">
													<?php esc_html_e( 'Marketplace', 'listar' ); ?>
												</span>
												<span class="scoop-mcaret"></span>
											</a>
										</li>
										<?php
									endif;
									?>
								<?php endif; ?>
							<?php endif; ?>
							<li>
								<a href="javascript:void(0)" data-id="__edit-backgrounds">
									<span class="scoop-micon">
										<i class="simple-icon-picture"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Images', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" data-id="__edit-grid-filler">
									<span class="scoop-micon">
										<i class="simple-icon-grid"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Grid Filler', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" data-id="__edit-footer">
									<span class="scoop-micon">
										<i class="simple-icon-arrow-down-circle"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Footer', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>  
							</li>
							
							<li>
								<a href="javascript:void(0)" data-id="__permalinks">
									<span class="scoop-micon">
										<i class="simple-icon-link"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Permalinks', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>
							
							<li>
								<a href="javascript:void(0)" data-id="__miscellaneous">
									<span class="scoop-micon">
										<i class="simple-icon-settings"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Miscellaneous', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>

							<li>
								<a href="https://themeforest.net/item/listar-wordpress-directory-theme/23923427/support" target="_blank">
									<span class="scoop-micon">
										<i class="simple-icon-support"></i>
									</span>
									<span class="scoop-mtext">
										<?php esc_html_e( 'Get Support', 'listar' ); ?>
									</span>
									<span class="scoop-mcaret"></span>
								</a>
							</li>
						</ul> 							
					</div> 
				</nav> 
				<div class="scoop-content"> 
					<div class="scoop-inner-content">
						<div>
							<?php
							if ( ! current_user_can( 'manage_options' ) ) :
								wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'listar' ) );
							else :
								?>
								<form method="post" id="settings-form" action="options.php">
									<?php

									/*
									 * Output nonce, action, and option_page fields for a settings page
									 */
									settings_fields( 'listar_settings_group' );
									do_settings_sections( 'listar_options' );
									?>
									<input type="submit" name="settings-submit" id="settings-submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'listar' ); ?>">
								</form>
								<?php
							endif;
							?>
						</div>								
					</div>
				</div>
				<div style="clear:both;"></div>
			</div> 
		</div>
	</div>
</div>

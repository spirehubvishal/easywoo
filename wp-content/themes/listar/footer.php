<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listar
 */

?>			<?php
			/* Don't load nothing for front end market place dashboard */
			if ( ! listar_is_wcfm_dashboard() ) :
				?>
					</div>
					<!-- End Site Content -->

					<!-- Start Footer -->
					<footer class="listar-site-footer listar-no-image">
						<div class="listar-site-footer-inner">
							<?php get_template_part( 'template-parts/footer', 'columns' ); ?>

							<div id="colophon" class="listar-footer-credits">
								<?php
								$listar_footer_menu = wp_nav_menu(
									array(
										'theme_location' => 'footer-menu',
										'echo'           => false,
										'container'      => 'div',
										'container_id'   => 'listar-footer-menu',
										'menu_class'     => 'nav listar-footer-menu',
										'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
										/* Reference: https://wordpress.stackexchange.com/a/82806 */
										'fallback_cb'    => '__return_false', /* Don't output nothing if the menu has 0 items */
									)
								);

								if ( has_nav_menu( 'footer-menu' ) && false !== $listar_footer_menu ) :
									?>
									<div class="listar-footer-menu-wrapper">
										<!-- Start Navbar (Footer Menu) -->
										<nav class="navbar listar-main-navbar navbar-inverse">
											<div class="container">
												<div class="row">
													<div class="col-sm-12">
														<div class="listar-footer-navigation-wrapper">
															<?php
															/* Use Listar's Footer Menu: footer-menu */
															/* Cleaning for W3C validation */
															echo wp_kses( str_replace( ' />', ' >', str_replace( '<ul/', '<ul', $listar_footer_menu ) ), 'listar-basic-html' );
															?>
														</div>
													</div>
												</div>
											</div>
										</nav>
										<!-- End Navbar (Footer Menu) -->
									</div>
									<?php
								endif;
								?>

								<div class="listar-container-wrapper">
									<div class="container">
										<div class="row">
											<div class="col-sm-12">
												<?php
												$listar_get_footer_info         = get_option( 'listar_footer_company_info' );
												$listar_get_footer_company      = get_option( 'listar_footer_company_site_name' );
												$listar_get_footer_website      = get_option( 'listar_footer_company_site_url' );
												$listar_get_copyright           = get_option( 'listar_copyright' );
												$listar_get_copyright_owner     = get_option( 'listar_copyright_owner' );
												$listar_get_copyright_owner_url = get_option( 'listar_copyright_owner_url' );

												$listar_footer_info         = empty( $listar_get_footer_info ) ? '' : $listar_get_footer_info;
												$listar_footer_company      = empty( $listar_get_footer_company ) ? '' : $listar_get_footer_company;
												$listar_footer_website      = empty( $listar_get_footer_website ) ? '' : $listar_get_footer_website;
												$listar_copyright           = empty( $listar_get_copyright ) ? esc_html__( 'All Rights Reserved.', 'listar' ) : $listar_get_copyright;
												$listar_copyright_owner     = empty( $listar_get_copyright_owner ) ? '' : $listar_get_copyright_owner;
												$listar_copyright_owner_url = empty( $listar_get_copyright_owner_url ) ? '' : $listar_get_copyright_owner_url;
												?>

												<?php
												$listar_footer_info_output = '';

												if ( ! empty( $listar_footer_info ) ) {
													$listar_footer_info_output .= $listar_footer_info;
												}

												if ( ! empty( $listar_footer_info ) && ! empty( $listar_footer_company ) ) {
													$listar_footer_info_output .= ' - ';
												}

												if ( ! empty( $listar_footer_company ) && ! empty( $listar_footer_website ) ) {
													$listar_footer_info_output .= '<a href="' . esc_url( $listar_footer_website ) . '" target="_blank">' . $listar_footer_company . '</a>';
												} else {
													if ( ! empty( $listar_footer_company ) ) {
														$listar_footer_info_output .= $listar_footer_company;
													}
												}

												if ( ! empty( $listar_footer_info_output ) ) :
													?>
													<div class="copyright">
														<?php echo wp_kses( $listar_footer_info_output, 'listar-basic-html' ); ?>
													</div>
													<?php
												endif;
												?>

												<div class="copyright">
													<?php
													$listar_copyright_output = '&#x24B8; ' . date( 'Y' ) . ', ' . $listar_copyright;

													if ( ! empty( $listar_copyright_owner ) && ! empty( $listar_copyright_owner_url ) ) {
														$listar_copyright_output .= ' - <a href="' . esc_url( $listar_copyright_owner_url ) . '" target="_blank">' . $listar_copyright_owner . '</a>';
													} else {
														if ( ! empty( $listar_copyright_owner ) ) {
															$listar_copyright_output .= ' - ' . $listar_copyright_owner;
														}
													}

													echo wp_kses( $listar_copyright_output, 'listar-basic-html' );
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>
					<!-- End Footer -->
				</div>
				<!-- End Site Content Wrapper -->

				<?php
			endif;
			
			wp_footer();
		?>
	</body>
</html>

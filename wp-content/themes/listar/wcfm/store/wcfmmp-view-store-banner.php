<?php
/**
 * The Template for displaying store banner.
 *
 * @package WCfM Markeplace Views Store/products
 *
 * For edit coping this to yourtheme/wcfm/store 
 *
 */
if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}	

global $WCFM, $WCFMmp;

if ( ! apply_filters( 'wcfm_is_allow_store_banner', true ) ) {
	return;
}	

$banner_type = $store_user->get_banner_type();
$banner = '';
$default_banner = ! empty( $WCFMmp->wcfmmp_marketplace_options[ 'store_default_banner' ] ) ? wcfm_get_attachment_url( $WCFMmp->wcfmmp_marketplace_options[ 'store_default_banner' ] ) : $WCFMmp->plugin_url . 'assets/images/default_banner.jpg';

if ( $banner_type == 'slider' ) {
	$banner_sliders = $store_user->get_banner_slider();
} elseif ( $banner_type == 'video' ) {
	$banner_video = $store_user->get_banner_video();
} else {
	$banner = $store_user->get_banner();
}
if ( ! $banner ) {
	$banner = $default_banner;
	$banner = apply_filters( 'wcfmmp_store_default_banner', $banner );
}

$mobile_banner = $store_user->get_mobile_banner();
if ( ! $mobile_banner ) {
	$mobile_banner = $store_user->get_banner();
	if ( ! $mobile_banner ) {
		$mobile_banner = $default_banner;
		$mobile_banner = apply_filters( 'wcfmmp_store_default_banner', $mobile_banner );
	}
}

$store_banner_width = isset( $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_width' ] ) ? $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_width' ] : '1650';
$store_banner_height = isset( $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_height' ] ) ? $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_height' ] : '350';
$store_banner_mwidth = isset( $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_mwidth' ] ) ? $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_mwidth' ] : '520';
$store_banner_mheight = isset( $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_mheight' ] ) ? $WCFMmp->wcfmmp_marketplace_options[ 'store_banner_mheight' ] : '250';
?>

<style>
	#wcfmmp-store .banner_img, #wcfmmp-store .wcfm_slideshow_container {
		max-height: <?php echo $store_banner_height; ?>px;
	}
	#wcfmmp-store .banner_img {
		height: <?php echo $store_banner_height; ?>px;
		background-image: url(<?php echo $banner; ?>);
	}
	#wcfmmp-store .banner_area_mobile .banner_img {
		height: <?php echo $store_banner_height; ?>px;
		background-image: url(<?php echo $mobile_banner; ?>);
	}
	.banner_area_mobile{display:none !important;}
	@media screen and (max-width: 640px) {
		#wcfmmp-store .banner_img, #wcfmmp-store .wcfm_slideshow_container {
			max-height: <?php echo $store_banner_mheight; ?>px;
		}
		#wcfmmp-store .banner_img {
			height: <?php echo $store_banner_mheight; ?>px;
		}
		.banner_area_desktop{display:none !important;}
		.banner_area_mobile{display:block !important;}
	}
</style>

<?php do_action( 'wcfmmp_store_before_bannar', $store_user->get_id() ); ?>

<div class="wcfm_banner_area">
	<div class="wcfm_banner_area_desktop">

		<?php if ( $banner_type == 'slider' ) { ?>

			<div class="wcfm_slider_area">
				<div class="wcfm_slideshow_container">

					<?php foreach ( $banner_sliders as $banner_slider_key => $banner_slider ) { ?>
						<?php if ( ! empty( $banner_slider[ 'image' ] ) ) { ?>
							<div class="wcfmSlides wcfm_slide_fade">
								<a href="<?php echo $banner_slider[ 'link' ] ? $banner_slider[ 'link' ] : wcfm_get_attachment_url( $banner_slider[ 'image' ] ); ?>" target="_blank">
									<div class="numbertext"><?php echo $banner_slider_key; ?> / <?php echo count( $banner_sliders ); ?></div>
									<img src="<?php echo wcfm_get_attachment_url( $banner_slider[ 'image' ] ); ?>" style="width:100%" alt="<?php echo $store_info[ 'store_name' ]; ?>" title="<?php echo $store_info[ 'store_name' ]; ?>">
									<?php if ( ( $WCFMmp->wcfmmp_vendor->get_vendor_name_position( $store_user->get_id() ) == 'on_banner' ) && apply_filters( 'wcfm_is_allow_store_name_on_banner', true ) ) { ?>
										<div class="slider_text"><h1><?php echo apply_filters( 'wcfmmp_store_title', $store_info[ 'store_name' ], $store_user->get_id() ); ?></h1></div>
									<?php } ?>
								</a>
							</div>
						<?php } ?>
					<?php } ?>

					<!-- Next and previous buttons -->
					<a class="prev" >&#10094;</a>
					<a class="next">&#10095;</a>
				</div>
			</div>
		<?php } elseif ( $banner_type == 'video' ) { ?>
			<section class="banner_area">
				<?php if ( apply_filters( 'wcfm_is_allow_full_width_video', true ) ) { ?>
					<style>
						#wcfmmp-store .banner_area {
							position: relative;
							height: <?php echo ($store_banner_height + 75); ?>px;
							overflow:hidden;
						}
						#wcfmmp-store .banner_video {
							position: relative;
							padding-bottom: 56.25%; /* 16:9 */
							height: 0;
						}
						#wcfmmp-store .banner_video iframe {
							position: absolute;
							top: -75px;
							left: 0;
							width: 100%;
							height: 100%;
						}
						@media screen and (max-width: 640px) {
							#wcfmmp-store .banner_area {
								height: <?php echo ($store_banner_mheight - 50); ?>px;
							}
							#wcfmmp-store .banner_video iframe {
								top: 0px;
							}
						}
					</style>
				<?php } ?>
				<div class="banner_video">
					<?php echo apply_filters( 'wcfmmp_store_banner_display', preg_replace( "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"100%\" height=\"315\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media\" src=\"//www.youtube.com/embed/$2?iv_load_policy=3&enablejsapi=1&disablekb=1&autoplay=1&controls=0&showinfo=0&rel=0&loop=1&wmode=transparent&widgetid=1\" allowfullscreen=\"1\"></iframe>", $banner_video ), $banner_video ); ?>

					<?php if ( ( $WCFMmp->wcfmmp_vendor->get_vendor_name_position( $store_user->get_id() ) == 'on_banner' ) && apply_filters( 'wcfm_is_allow_store_name_on_banner', true ) ) { ?>
						<div class="video_text">
							<?php do_action( 'wcfmmp_store_before_bannar_text', $store_user->get_id() ); ?>

							<h1><?php echo apply_filters( 'wcfmmp_store_title', esc_html( $store_info[ 'store_name' ] ), $store_user->get_id() ); ?></h1>

							<?php do_action( 'wcfmmp_store_after_bannar_text', $store_user->get_id() ); ?>
						</div>
					<?php } ?>
				</div>
			</section>
		<?php } else { ?>
			<section class="banner_area banner_area_desktop">
				<?php do_action( 'wcfmmp_store_before_bannar_image', $store_user->get_id() ); ?>

				<div class="listar-store-header-banner-overlay"></div>
				<div class="banner_img">
					<div class="listar-section listar-store-cover">
						<div class="listar-container-wrapper" >
							<div class="container">
								<!-- Start section title - For W3C Valitation -->
								<div class="row listar-section-title hidden">
									<div class="col-sm-12">
										<h2 class="text-center">
											<?php esc_html_e( 'Shop', 'listar' ); ?>
										</h2>
									</div>
								</div>
								<!-- End section title - For W3C Valitation -->
								<div class="row">
									<div class="col-sm-12">
										<?php
										$gravatar = $store_user->get_avatar();
										$email    = $store_user->get_email();
										$phone    = $store_user->get_phone(); 
										$address  = $store_user->get_address_string(); 

										$store_lat    = isset( $store_info['store_lat'] ) ? esc_attr( $store_info['store_lat'] ) : 0;
										$store_lng    = isset( $store_info['store_lng'] ) ? esc_attr( $store_info['store_lng'] ) : 0;

										$store_address_info_class = '';
										$listar_blank_placeholder = listar_blank_base64_placeholder_image();
										?>

										<?php do_action( 'wcfmmp_store_before_header', $store_user->get_id() ); ?>

										<div id="wcfm_store_header">
											<div class="header_wrapper">
												<div class="header_area">
													<div class="lft header_left">

														<?php do_action( 'wcfmmp_store_before_avatar', $store_user->get_id() ); ?>

														<div class="logo_area lft">
															<a href="#">
																<img class="listar-background-cover-image" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" style="background-image:url(<?php echo esc_url( $gravatar ); ?>);" alt="user"/>
															</a>
														</div>

														<div class="address rgt">
														  <?php if( true || ( $WCFMmp->wcfmmp_vendor->get_vendor_name_position( $store_user->get_id() ) == 'on_header' ) || apply_filters( 'wcfm_is_allow_store_name_on_header', false ) ) { ?>
															<h1 class="wcfm_store_title">
															  <?php echo apply_filters( 'wcfmmp_store_title', esc_html( $store_info['store_name'] ), $store_user->get_id() ); ?>
															  <?php if( apply_filters( 'wcfm_is_allow_badges_with_store_name', false ) ) { ?>
																		<div class="wcfmmp_store_mobile_badges wcfmmp_store_mobile_badges_with_store_name">
																			<?php do_action( 'wcfmmp_store_mobile_badges', $store_user->get_id() ); ?>
																			<div class="spacer"></div> 
																		</div>
																	<?php } ?>
															</h1>



														<div class="logo_area_after">
															<?php do_action( 'wcfmmp_store_after_avatar', $store_user->get_id() ); ?>

															<?php if( apply_filters( 'wcfm_is_pref_vendor_reviews', true ) && apply_filters( 'wcfm_is_allow_review_rating', true ) ) { $WCFMmp->wcfmmp_reviews->show_star_rating( 0, $store_user->get_id() ); } ?>

															<?php if( !apply_filters( 'wcfm_is_allow_badges_with_store_name', false ) ) { ?>
																<div class="wcfmmp_store_mobile_badges">
																	<?php do_action( 'wcfmmp_store_mobile_badges', $store_user->get_id() ); ?>
																	<div class="spacer"></div> 
																</div>
															<?php } ?>
															<div class="spacer"></div>  
														</div>

														  <?php $store_address_info_class = 'header_store_name'; } ?>

														  <?php do_action( 'before_wcfmmp_store_header_info', $store_user->get_id() ); ?>
															<?php do_action( 'wcfmmp_store_before_address', $store_user->get_id() ); ?>

															<?php if( $address && ( $store_info['store_hide_address'] == 'no' ) && wcfm_vendor_has_capability( $store_user->get_id(), 'vendor_address' ) ) { ?>
																<div class="<?php echo $store_address_info_class; ?> wcfmmp_store_header_address">
																	<div class="listar-store-header-address-inline">
																		 <i class="wcfmfa fa-map-marker" aria-hidden="true"></i>
																		<?php if( apply_filters( 'wcfmmp_is_allow_address_map_linked', true ) ) { 
																		      $map_search_link = 'https://google.com/maps/place/' . rawurlencode( $address ) . '/@' . $store_lat . ',' . $store_lng . '&z=16';
																		      if( wcfm_is_mobile() || wcfm_is_tablet() ) {
																			      $map_search_link = 'https://maps.google.com/?q=' . rawurlencode( $address ) . '&z=16';
																		      }
																		      ?>
																		  <a href="<?php echo $map_search_link; ?>" target="_blank"><span><?php echo esc_attr($address); ?></span></a>
																		<?php } else { ?>
																			      <?php echo esc_attr($address); ?>
																		      <?php } ?>
																	</div>
																</div>
															<?php } ?>

															<?php do_action( 'wcfmmp_store_after_address', $store_user->get_id() ); ?>

															<div class="<?php echo $store_address_info_class; ?>">

															  <?php do_action( 'wcfmmp_store_before_phone', $store_user->get_id() ); ?>

															  <?php if( $phone && ( $store_info['store_hide_phone'] == 'no' ) && wcfm_vendor_has_capability( $store_user->get_id(), 'vendor_phone' ) ) { ?>
																	<div class="store_info_parallal wcfmmp_store_header_phone" style="margin-right: 10px;">
																	  <i class="wcfmfa fa-phone" aria-hidden="true"></i>
																	  <span>
																	    <?php if( apply_filters( 'wcfmmp_is_allow_tel_linked', true ) ) { ?>
																	      <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
																	    <?php } else { ?>
																		<?php echo $phone; ?>
																	   <?php } ?>
																	  </span>
																	</div>
																<?php } ?>

																<?php do_action( 'wcfmmp_store_after_phone', $store_user->get_id() ); ?>
																<?php do_action( 'wcfmmp_store_before_email', $store_user->get_id() ); ?>

																<?php if( $email && ( $store_info['store_hide_email'] == 'no' ) && wcfm_vendor_has_capability( $store_user->get_id(), 'vendor_email' ) ) { ?>
																	<div class="store_info_parallal wcfmmp_store_header_email">
																	  <i class="wcfmfa fa-envelope" aria-hidden="true"></i>
																	  <span>
																	    <?php if( apply_filters( 'wcfmmp_is_allow_mailto_linked', true ) ) { ?>
																	      <a href="mailto:<?php echo apply_filters( 'wcfmmp_mailto_email', $email, $store_user->get_id() ); ?>"><?php echo $email; ?></a>
																	    <?php } else { ?>
																		<?php echo $email; ?>
																	    <?php } ?>
																	  </span>
																	</div>
																<?php } ?>

																<?php do_action( 'wcfmmp_store_after_email', $store_user->get_id() ); ?>

																<div class="spacer"></div>  
															</div>

															<?php do_action( 'after_wcfmmp_store_header_info', $store_user->get_id() ); ?>
														</div>
													  <div class="spacer"></div>    
													</div>
													<div class="header_right">
														<div class="bd_icon_area lft">

														  <?php do_action( 'before_wcfmmp_store_header_actions', $store_user->get_id() ); ?>

															<?php do_action( 'wcfmmp_store_before_enquiry', $store_user->get_id() ); ?>

															<?php if( apply_filters( 'wcfm_is_pref_enquiry', true ) && apply_filters( 'wcfmmp_is_allow_store_header_enquiry', true ) && wcfm_vendor_has_capability( $store_user->get_id(), 'enquiry' ) ) { ?>
																<?php do_action( 'wcfmmp_store_enquiry', $store_user->get_id() ); ?>
															<?php } ?>

															<?php do_action( 'wcfmmp_store_after_enquiry', $store_user->get_id() ); ?>
															<?php do_action( 'wcfmmp_store_before_follow_me', $store_user->get_id() ); ?>

															<?php 
															if( apply_filters( 'wcfm_is_pref_vendor_followers', true ) && apply_filters( 'wcfm_is_allow_store_followers', true ) && wcfm_vendor_has_capability( $store_user->get_id(), 'vendor_follower' ) ) {
																do_action( 'wcfmmp_store_follow_me', $store_user->get_id() );
															}
															?>

															<?php do_action( 'wcfmmp_store_after_follow_me', $store_user->get_id() ); ?>

															<?php do_action( 'after_wcfmmp_store_header_actions', $store_user->get_id() ); ?>

															<div class="spacer"></div>   
														</div>
														<?php if( !empty( $store_info['social'] ) && $store_user->has_social() && wcfm_vendor_has_capability( $store_user->get_id(), 'vendor_social' ) ) { ?>
															<div class="social_area rgt">
																<?php $WCFMmp->template->get_template( 'store/wcfmmp-view-store-social.php', array( 'store_user' => $store_user, 'store_info' => $store_info ) ); ?>
															</div>
															 <div class="spacer"></div>
														<?php } ?>
														<div class="spacer"></div>
													</div>
												  <div class="spacer"></div>    
												</div>
											</div>
										</div>

										<?php do_action( 'wcfmmp_store_after_header', $store_user->get_id() ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<img src="<?php echo $banner; ?>" alt="<?php echo $store_info[ 'store_name' ]; ?>" title="<?php echo $store_info[ 'store_name' ]; ?>" />
				</div>

				<?php do_action( 'wcfmmp_store_after_bannar_image', $store_user->get_id() ); ?>

				<?php if ( false && ( $WCFMmp->wcfmmp_vendor->get_vendor_name_position( $store_user->get_id() ) == 'on_banner' ) && apply_filters( 'wcfm_is_allow_store_name_on_banner', true ) ) { ?>
					<div class="banner_text">
						<?php do_action( 'wcfmmp_store_before_bannar_text', $store_user->get_id() ); ?>

						<h1><?php echo apply_filters( 'wcfmmp_store_title', $store_info[ 'store_name' ], $store_user->get_id() ); ?></h1>

						<?php do_action( 'wcfmmp_store_after_bannar_text', $store_user->get_id() ); ?>
					</div>
				<?php } ?>

			</section>

			<section class="banner_area banner_area_mobile">
				<?php do_action( 'wcfmmp_store_before_bannar_image', $store_user->get_id() ); ?>

				<div class="banner_img"><img src="<?php echo $mobile_banner; ?>" alt="<?php echo $store_info[ 'store_name' ]; ?>" title="<?php echo $store_info[ 'store_name' ]; ?>" /></div>

				<?php do_action( 'wcfmmp_store_after_bannar_image', $store_user->get_id() ); ?>

				<?php if ( ( $WCFMmp->wcfmmp_vendor->get_vendor_name_position( $store_user->get_id() ) == 'on_banner' ) && apply_filters( 'wcfm_is_allow_store_name_on_banner', true ) ) { ?>
					<div class="banner_text">
						<?php do_action( 'wcfmmp_store_before_bannar_text', $store_user->get_id() ); ?>

						<h1><?php echo apply_filters( 'wcfmmp_store_title', $store_info[ 'store_name' ], $store_user->get_id() ); ?></h1>

						<?php do_action( 'wcfmmp_store_after_bannar_text', $store_user->get_id() ); ?>
					</div>
				<?php } ?>

			</section>
		<?php } ?>
	</div>
</div>


<?php do_action( 'wcfmmp_store_after_bannar', $store_user->get_id() ); ?>
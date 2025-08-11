<?php
/**
 * Actions to enable social sharing buttons for blog posts and listings
 *
 * @package Listar_Addons
 */

/**
 * Action to output social sharing buttons for blog posts
 */
add_action( 'listar_social_share_buttons_blog', 'listar_social_share_buttons_blog_output' );

if ( ! function_exists( 'listar_social_share_buttons_blog_output' ) ) :
	/**
	 * Social sharing buttons output (HTML).
	 *
	 * @since 1.0
	 */
	function listar_social_share_buttons_blog_output() {
		global $post;

		$listar_post_content = wp_strip_all_tags( get_the_content( null, false, $post ), true );

		$listar_social_share_data = array(
			'title'       => urlencode( get_the_title() ),
			'image'       => urlencode( listar_get_first_post_image_url( $post ) ),
			'permalink'   => urlencode( get_the_permalink() ),
			'description' => urlencode( listar_excerpt_limit( $listar_post_content, 600, false ) ),
		);
		?>

		<div class="row listar-post-social-share-wrapper">
			<div class="col-sm-12">
				<div class="listar-post-social-share">
					<div class="listar-post-social-share-inner">
						<div class="listar-post-social-share-label">
							<?php esc_html_e( 'Share', 'listar' ); ?>
						</div>
						<ul class="listar-social-share-options">
							<li>
								<a href="http://www.facebook.com/share.php?u=<?php echo esc_attr( $listar_social_share_data['permalink'] ); ?>&amp;title=<?php echo esc_attr( $listar_social_share_data['title'] ); ?>&amp;description=<?php echo esc_attr( $listar_social_share_data['description'] ); ?>&amp;picture=<?php echo esc_attr( $listar_social_share_data['image'] ); ?>">
									<i class="fa fa-facebook-f"></i>
									<div>
										Facebook
									</div>
								</a>
							</li>
							<li>
								<a href="#" class="listar-social-share-other">
									<i class="fa fa-share-alt"></i>
									<div>
										<?php esc_html_e( 'Options', 'listar' ); ?>
									</div>
								</a>
							</li>
							<li>
								<a href="http://twitter.com/share?text=<?php echo esc_attr( $listar_social_share_data['title'] ); ?>&amp;url=<?php echo esc_attr( $listar_social_share_data['permalink'] ); ?>">
									<i class="fa fa-twitter"></i>
									<div>
										Twitter
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>

		<?php
	}
endif;

/**
 * Action to output the social sharing popup and buttons (for blog posts and listings)
 */
add_action( 'listar_social_share_popup', 'listar_social_share_popup_output' );

if ( ! function_exists( 'listar_social_share_popup_output' ) ) :
	/**
	 * Social sharing popup output (HTML).
	 *
	 * @since 1.0
	 */
	function listar_social_share_popup_output() {
		if ( is_single() ) :
			global $post;
			$listar_social_share_background_image = listar_image_url( get_option( 'listar_social_share_background_image' ), 'listar-cover' );
			$listar_background_image = empty( $listar_social_share_background_image ) ? '0' : $listar_social_share_background_image;
			$listar_has_background_image = '0' === $listar_background_image ? 'listar-no-background-image' : '';
			?>

			<!-- Start Social Sharing Popup -->
			<div class="listar-social-share-popup listar-hero-header listar-transparent-design <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>">
				<!-- Hero image -->
				<div class="listar-hero-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>"></div>
				<!-- Start Social Sharing Buttons -->
				<div class="listar-valign-form-holder">
					<div class="text-center listar-valign-form-content">
						<div class="listar-panel-form-wrapper">
							<div class="panel listar-panel-form">
								<div class="panel-heading">
									<h3>
										<?php esc_html_e( 'Share This Page', 'listar' ); ?>
									</h3>
								</div>
								<div class="panel-body">
									<div class="listar-social-share-networks-wrapper">
										<div class="listar-social-networks">
											<?php
											$listar_post_content = wp_strip_all_tags( get_the_content( null, false, $post ), true );
											$listar_current_post_id = $post->ID;

											$listar_social_share_data = array(
												'site_name'     => urlencode( get_bloginfo() ),
												'title'         => urlencode( get_the_title() ),
												'title_raw'     => rawurlencode( get_the_title() ),
												'image'         => urlencode( listar_get_first_post_image_url( $post ) ),
												'permalink'     => urlencode( get_the_permalink() ),
												'permalink_raw' => rawurlencode( get_the_permalink() ),
												'description'   => urlencode( listar_excerpt_limit( $listar_post_content, 600, false ) ),
											);

											if ( 'job_listing' === listar_get_post_type() ) {
												$listar_listing_gallery_image_ids = listar_listing_gallery_ids( $listar_current_post_id );

												if ( ! empty( $listar_listing_gallery_image_ids ) && isset( $listar_listing_gallery_image_ids[0] ) ) {
													$listar_attachment = wp_get_attachment_image_src( $listar_listing_gallery_image_ids[0], 'large' );
													$listar_conditions = false !== $listar_attachment && isset( $listar_attachment[0] ) && ! empty( $listar_attachment[0] );
													$listar_social_share_data['image'] = $listar_conditions ? $listar_attachment[0] : $listar_social_share_data['image'];
												}
											}

											$listar_social_networks = array(
												array( 'facebook', 'fa fa-facebook-f', 'Facebook', 'http://www.facebook.com/share.php?u=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;title=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) . '&amp;description=' . esc_attr( $listar_social_share_data['description'] ) . '&amp;picture=' . esc_attr( $listar_social_share_data['image'] ) ),
												array( 'twitter', 'fa fa-twitter', 'Twitter', 'http://twitter.com/share?text=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) . '&amp;url=' . esc_attr( $listar_social_share_data['permalink'] ) ),
												array( 'pinterest', 'fa fa-pinterest', 'Pinterest', 'https://pinterest.com/pin/create/button/?url=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;media=' . esc_attr( $listar_social_share_data['image'] ) . '&amp;description=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) ),
												array( 'whatsapp', 'fa fa-whatsapp', 'WhatsApp', 'https://wa.me?text=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) . '+-+' . esc_attr( $listar_social_share_data['permalink'] ) ),
												array( 'telegram', 'fa fa-telegram', 'Telegram', 'https://telegram.me/share/url?url=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;text=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) ),
												array( 'linkedin', 'fa fa-linkedin', 'Linkedin', 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;title=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) ),
												array( 'tumblr', 'fa fa-tumblr', 'Tumblr', 'http://www.tumblr.com/share?v=3&amp;u=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;t=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) ),
												array( 'vk', 'fa fa-vk', 'VKontakte', 'http://vk.com/share.php?url=' . esc_attr( $listar_social_share_data['permalink'] ) . '&amp;title=' . esc_attr( $listar_social_share_data['site_name'] ) . '+-+' . esc_attr( $listar_social_share_data['title'] ) ),
												array( 'mail', 'fa fa-envelope-o', esc_html__( 'Mail', 'listar' ), 'mailto:?subject=%5B' . rawurlencode( get_bloginfo( 'name' ) ) . '%5D%20' . esc_attr( $listar_social_share_data['title_raw'] ) . '&amp;body=' . esc_attr( $listar_social_share_data['permalink_raw'] ) ),
												array( 'copy', 'icon-copy', esc_html__( 'Copy Link', 'listar' ), '#' ),
											);

											foreach ( $listar_social_networks as $listar_social_network ) :
												?>
												<a href="<?php echo esc_attr( $listar_social_network[3] ); ?>" class="listar-social-share-button-<?php echo esc_attr( $listar_social_network[0] ); ?>">
													<div class="listar-social-network-icon <?php echo esc_attr( listar_sanitize_html_class( $listar_social_network[1] ) ); ?>"></div>
													<?php if ( 'copy' === $listar_social_network[0] ) : ?>
														<div class="listar-social-network-title listar-listing-header-topbar-item-label" data-copy-text="<?php esc_attr_e( 'Copy Link', 'listar' ); ?>" data-copied-text="<?php esc_attr_e( 'Copied!', 'listar' ); ?>">
															<?php echo esc_html( $listar_social_network[2] ); ?>
														</div>
													<?php else : ?>
														<div class="listar-social-network-title">
															<?php echo esc_html( $listar_social_network[2] ); ?>
														</div>
													<?php endif; ?>
												</a>
												<?php
											endforeach;
											?>
										</div>
									</div>
								</div>
								<div class="listar-more-sharing-networks-button-wrapper">
									<div class="listar-more-sharing-networks-button icon-plus"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Social Sharing Buttons -->
			</div>
			<!-- End Social Sharing Popup -->
			<?php
		endif;
	}
endif;

/**
 * Action to output the company's social networks for listing posts
 */
add_action( 'listar_listing_company_social_networks', 'listar_listing_company_social_networks_output' );

if ( ! function_exists( 'listar_listing_company_social_networks_output' ) ) :
	/**
	 * Social network buttons output (HTML).
	 *
	 * @since 1.0
	 */
	function listar_listing_company_social_networks_output() {
		$listar_social_networks_disable = (int) get_option( 'listar_social_networks_disable' );

		if ( 0 === $listar_social_networks_disable ) {
			global $post;
			$listar_current_post_id = $post->ID;
			?>
			<div class="listar-listing-social">
				<h3>
					<?php esc_html_e( 'Follow Us', 'listar' ); ?>
				</h3>
				<div class="listar-social-networks">
					<?php
					$listar_social_networks = array(
						array( '_company_facebook', 'fa fa-facebook-f', 'Facebook' ),
						array( '_company_twitter', 'fa fa-twitter', 'Twitter' ),
						array( '_company_googleplus', 'fa fa-google-plus', 'Google+' ),
						array( '_company_instagram', 'fa fa-instagram', 'Instagram' ),
						array( '_company_linkedin', 'fa fa-linkedin', 'Linkedin' ),
						array( '_company_pinterest', 'fa fa-pinterest', 'Pinterest' ),
						array( '_company_youtube', 'fa fa-youtube', 'Youtube' ),
						array( '_company_twitch', 'fa fa-twitch', 'Twitch' ),
						array( '_company_tiktok', 'fa fa-tiktok', 'Tiktok' ),
						array( '_company_snapchat', 'fa fa-snapchat', 'Snapchat' ),
						array( '_company_vimeo', 'fa fa-vimeo', 'Vimeo' ),
						array( '_company_vk', 'fa fa-vk', 'VK' ),
						array( '_company_foursquare', 'fa fa-foursquare', 'Foursquare' ),
						array( '_company_tripadvisor', 'fa fa-tripadvisor', 'TripAdvisor' ),
					);

					foreach ( $listar_social_networks as $listar_social_network ) :
						$listar_sn = get_post_meta( $listar_current_post_id, $listar_social_network[0], true );

						if ( ! empty( $listar_sn ) ) :
							?>
							<a target="_blank" href="<?php echo esc_url( $listar_sn ); ?>">
								<div class="listar-social-network-icon <?php echo esc_attr( listar_sanitize_html_class( $listar_social_network[1] ) ); ?>"></div>
								<div class="listar-social-network-title">
									<?php echo esc_html( $listar_social_network[2] ); ?>
								</div>
							</a>
							<?php
						endif;
					endforeach;
					?>
				</div>
			</div>
			<?php
		}
	}
endif;

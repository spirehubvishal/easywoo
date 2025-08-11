<?php
/**
 * Template part for displaying the listing description in single-job_listing
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id           = $post->ID;
$listar_listing_package_id        = listar_addons_active() ? get_post_meta( $listar_current_post_id, '_package_id', true ) : 0;
$disabled_package_options         = listar_addons_active() && ! empty( $listar_listing_package_id ) ? listar_get_package_options_disabled( $listar_listing_package_id ) : array();
$listar_max_rich_media            = listar_addons_active() ? listar_get_media_fields_limit( $listar_listing_package_id ) : 30;
$listar_author                    = get_userdata( $post->post_author );
$listar_email_data_disable        = (int) get_option( 'listar_email_data_disable' );
$listar_use_default_email         = (bool) get_post_meta( $listar_current_post_id, '_job_useuseremail', true );
$listar_full_width                = false;
$listar_full_width_class          = $listar_full_width ? 'listar-gutenberg-full-width-content' : '';
$listar_listing_user_email        = sanitize_email( $listar_use_default_email ? $listar_author->user_email : get_post_meta( $listar_current_post_id, '_job_custom_email', true ) );
$listar_location_disable          = (int) get_option( 'listar_location_disable' );
$listar_listing_address           = 0 === $listar_location_disable && ! isset( $disabled_package_options['listar_location_disable'] ) ? listar_get_listing_address( $listar_current_post_id ) : '';
$listar_website_disable           = (int) get_option( 'listar_website_disable' );
$listar_listing_website           = 0 === $listar_website_disable && ! isset( $disabled_package_options['listar_website_disable'] ) ? get_post_meta( $listar_current_post_id, '_company_website', true ) : '';
$listar_logo_disable              = (int) get_option( 'listar_logo_disable' );
$listar_logo                      = 0 === $listar_logo_disable && ! isset( $disabled_package_options['listar_logo_disable'] ) ? listar_custom_esc_url( get_post_meta( $listar_current_post_id, '_company_logotype', true ) ) : '';
$listar_category_icon             = '';
$listar_disable_private_messages  = (int) get_option( 'listar_disable_private_message' );
$listar_disable_pvt_messages_list = (bool) get_post_meta( $listar_current_post_id, '_job_disable_privatemessage', true );
$listar_group_amenities           = 1 === (int) get_option( 'listar_single_group_amenities_parent' );
$listar_allowed_kses_tags         = array(
	'span' => array(),
);
?>



<section class="listar-section listar-section-no-padding-bottom listar-single-listing-description-wrapper" data-aos="fade-up">
	<div class="listar-container-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Start Listing Description -->
					<div>
						<div class="listar-listing-description <?php echo sanitize_html_class( $listar_full_width_class ); ?>" id="listar-listing-description">
							<div class="row">
								<div class="col-xs-12 col-md-4 text-center listar-listing-description-first-col">
									<a class="listar-toggle-listing-sidebar-position icon-tab" title="<?php esc_attr_e( 'Toggle sidebar position', 'listar' ); ?>" data-toggle="tooltip" data-placement="top"></a>
									<?php
									if ( 0 === $listar_logo_disable && ! empty( $listar_logo ) && false === strpos( $listar_logo, 'data:image' ) ) :
										$claim_status = listar_listing_claim_status( get_the_ID() );
										$show_claim = 'claimed' === $claim_status;
										?>
										<div class="listar-listing-data listar-listing-logo-data">
											<div class="listar-listing-logo-container">
												<div class="listar-listing-logo-wrapper">
													<div class="listar-listing-logo" data-background-image="<?php echo esc_url( $listar_logo ); ?>"></div>
													<?php
													if ( $show_claim && listar_is_claim_enabled() ) :
														?>
														<div class="listar-claimed-icon"></div>
														<?php
													endif;
													?>
												</div>
											</div>
										</div>
										<?php
									endif;
									?>

									<?php
									if ( ! isset( $disabled_package_options['listar_social_networks_disable'] ) ) :

										/* Social network buttons for current listing - Requires Listar Addons plugin */
										do_action( 'listar_listing_company_social_networks' );
									endif;
									?>

									<div class="listar-listing-data listar-listing-contact-data">
										<h3 class="listar-listing-contact-title text-left">
											<?php echo esc_html_e( 'Contact', 'listar' ); ?>
										</h3>
										<div>
											<ul>
												<?php if ( ! empty( $listar_listing_address ) ) : ?>
													<li class="listar-listing-company-address">
														<address>
															<?php echo esc_html( $listar_listing_address ); ?>
														</address>
													</li>
												<?php endif; ?>

												<?php
												$listar_phone_disable    = (int) get_option( 'listar_phone_disable' );
												$listar_fax_disable      = (int) get_option( 'listar_fax_disable' );
												$listar_mobile_disable   = (int) get_option( 'listar_mobile_disable' );
												$listar_whatsapp_disable = (int) get_option( 'listar_whatsapp_disable' );
												$listar_listing_phones   = array();
												$listar_social_share_data = array(
													'site_name'     => urlencode( get_bloginfo() ),
													'title'         => urlencode( get_the_title() ),
													'title_raw'     => rawurlencode( get_the_title() ),
													'image'         => urlencode( listar_get_first_post_image_url( $post ) ),
													'permalink'     => urlencode( get_the_permalink() ),
													'permalink_raw' => rawurlencode( get_the_permalink() ),
												);
												
												if ( 0 === $listar_phone_disable && ! isset( $disabled_package_options['listar_phone_disable'] ) ) {
													array_push( $listar_listing_phones, array( '_company_phone', 'listar-listing-phone' ) );
												}
												
												if ( 0 === $listar_whatsapp_disable && ! isset( $disabled_package_options['listar_whatsapp_disable'] ) ) {
													array_push( $listar_listing_phones, array( '_company_whatsapp', 'listar-listing-mobile listar-listing-whatsapp' ) );
												}
												
												if ( 0 === $listar_mobile_disable && ! isset( $disabled_package_options['listar_mobile_disable'] ) ) {
													array_push( $listar_listing_phones, array( '_company_mobile', 'listar-listing-mobile listar-listing-only-mobile' ) );
												}
												
												if ( 0 === $listar_fax_disable&& ! isset( $disabled_package_options['listar_fax_disable'] ) ) {
													array_push( $listar_listing_phones, array( '_company_fax', 'listar-listing-fax' ) );
												}

												foreach ( $listar_listing_phones as $listar_listing_phone ) :

													$listar_listing_phone_number = get_post_meta( $listar_current_post_id, $listar_listing_phone[0], true );

													if ( ! empty( $listar_listing_phone_number ) ) :

														$listar_listing_gallery_image_ids = listar_listing_gallery_ids( $listar_current_post_id );

														if ( ! empty( $listar_listing_gallery_image_ids ) && isset( $listar_listing_gallery_image_ids[0] ) ) {
															$listar_attachment = wp_get_attachment_image_src( $listar_listing_gallery_image_ids[0], 'large' );
															$listar_conditions = false !== $listar_attachment && isset( $listar_attachment[0] ) && ! empty( $listar_attachment[0] );
															$listar_social_share_data['image'] = $listar_conditions ? $listar_attachment[0] : $listar_social_share_data['image'];
														}
														
														if ( '_company_whatsapp' === $listar_listing_phone[0] ) :
															$listar_company_url = $listar_social_share_data['permalink'];
															$listar_company_title = $listar_social_share_data['title'];
															$listar_site_name = $listar_social_share_data['site_name'];
															?>
															<li class="<?php echo esc_attr( listar_sanitize_html_class( $listar_listing_phone[1] ) ); ?>" data-company-url="<?php echo esc_url( $listar_company_url );?>" data-company-title="<?php echo esc_attr( $listar_company_title );?>" data-site-name="<?php echo esc_attr( $listar_site_name );?>">
																<?php echo esc_html( $listar_listing_phone_number ); ?>
																<span class="listar-phone-has-icon">
																	<span>
																		(WhatsApp)
																	</span>
																</span>
															</li>
															<?php
														else :
															?>
															<li class="<?php echo esc_attr( listar_sanitize_html_class( $listar_listing_phone[1] ) ); ?>">
																<?php echo esc_html( $listar_listing_phone_number ); ?>
															</li>
															<?php
														endif;
														?>
														<?php
													endif;
												endforeach;
												?>

												<?php
												if ( ! empty( $listar_listing_user_email ) && 0 === $listar_email_data_disable ) :
													?>
													<li class="listar-listing-email">
														<a href="mailto:<?php echo esc_attr( sanitize_email( $listar_listing_user_email ) ); ?>">
															<?php echo esc_html( sanitize_email( $listar_listing_user_email ) ); ?>
														</a>
													</li>
													<?php
												endif;

												if ( ! empty( $listar_listing_website ) ) :
													?>
													<li class="listar-listing-website">
														<a href="<?php echo esc_url( get_post_meta( $listar_current_post_id, '_company_website', true ) ); ?>" target="_blank">
															<?php echo esc_html( listar_sanitize_website( $listar_listing_website, true ) ); ?>
														</a>
													</li>
													<?php
												endif;
												?>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-md-8 listar-listing-description-second-col">
									<div>
										<div class="listar-listing-description-wrapper">
											<div class="listar-listing-description-inner">
												<div class="listar-listing-description-content">
													<?php
													/* Tagline */
													$listar_tagline = esc_html( get_post_meta( $listar_current_post_id, '_job_tagline', true ) );
													$listar_has_tagline = 'listar-listing-no-tagline';

													/* Price Range */
													$listar_price_range_disable = (int) get_option( 'listar_price_range_disable' );
													$listar_popular_price_disable = (int) get_option( 'listar_popular_price_disable' );
													$listar_has_price     = 'listar-listing-no-price';
													$listar_price_range   = 0 === $listar_price_range_disable && ! isset( $disabled_package_options['listar_price_range_disable'] ) ? esc_html( get_post_meta( $listar_current_post_id, '_job_pricerange', true ) ) : '';
													$listar_price_average = 0 === $listar_popular_price_disable && ! isset( $disabled_package_options['listar_popular_price_disable'] ) ? (int) get_post_meta( $listar_current_post_id, '_job_priceaverage', true ) : 0;
													
													$listar_category_terms = '';

													if ( ! empty( $listar_tagline ) && ! isset( $disabled_package_options['listar_disable_job_tagline'] ) ) :
														$listar_has_tagline    = 'listar-listing-has-tagline';
														?>
														<div class="listar-tagline-wrapper">
															<div class="listar-tagline-inner">
																<div class="listar-tagline-category-icon">
																	<div class="listar-category-links-wrapper">
																		<?php
																		if ( taxonomy_exists( 'job_listing_category' ) && ! isset( $disabled_package_options['listar_disable_job_listing_category'] ) ) :
																			$featured_category      = esc_html( get_post_meta( $listar_current_post_id, '_company_featured_listing_category', true ) );
																			$featured_category_term = ! empty( $featured_category ) ? get_term_by( 'id', $featured_category, 'job_listing_category' ) : false;
																			$has_featured_category  = isset( $featured_category_term->term_id ) && isset( $featured_category_term->name ) ? $featured_category_term : false;

																			$listar_category_terms = get_the_terms( $listar_current_post_id, 'job_listing_category' );
																			$temp_terms = $listar_category_terms;

																			if ( $has_featured_category && isset( $listar_category_terms[0] ) && ! is_wp_error( $listar_category_terms ) && ! empty( $listar_category_terms ) ) {
																				$temp_terms = array();

																				foreach( $listar_category_terms as $listar_category_term ) {
																					if ( isset( $listar_category_term->term_id ) ) {
																						if ( (int) $listar_category_term->term_id === (int) $featured_category_term->term_id ) {
																							array_unshift( $temp_terms, $listar_category_term );
																						} else {
																							$temp_terms[] = $listar_category_term;
																						}
																					}
																				}		
																			}

																			if ( $temp_terms !== $listar_category_terms ) {
																				$listar_category_terms = $temp_terms;
																			}

																			if ( ! isset( $listar_category_terms[0] ) || is_wp_error( $listar_category_terms ) ) {
																				$listar_category_terms = false;
																			} else {
																				$listar_count_category_terms = is_array( $listar_category_terms ) ? count( $listar_category_terms ) : 0;
																			}
																		endif;

																		if ( ! empty( $listar_category_terms ) ) :
																			foreach( $listar_category_terms as $listar_category_term ) :
																				$listar_category_id    = '';
																				$listar_category_color = listar_theme_color();
																				$listar_category_link  = '';
																				$listar_category_icon  = array( 'icon-map-marker', '' );

																				if ( isset( $listar_category_term->term_id ) ) {
																					$listar_category_id    = $listar_category_term->term_id;
																				}

																				if ( ! empty( $listar_category_id ) ) {
																					$listar_get_icon       = listar_term_icon( $listar_category_id );
																					$listar_category_icon  = listar_icon_class( $listar_get_icon );
																					$listar_category_color = listar_term_color( $listar_category_id );
																					$listar_category_link  = get_term_link( $listar_category_term, 'job_listing_category' );
																					$listar_has_icon       = ! empty( $listar_category_icon[0] ) || ! empty( $listar_category_icon[1] ) ? true : false;

																					if ( ! $listar_has_icon ) {
																						$listar_category_icon[0] = 'icon-map-marker';
																					}
																				}
																				if ( ! empty( $listar_category_link ) ) :
																					?>
																					<a class="listar-single-listing-category-link" href="<?php echo esc_url( $listar_category_link ); ?>">
																						<div class="listar-category-icon-wrapper">
																							<div class="listar-category-icon-box" style="<?php echo 'background-color: rgb(' . esc_attr( $listar_category_color ) . ');'; ?>"></div>
																							<span class="<?php echo esc_attr( listar_sanitize_html_class( $listar_category_icon[0] ) ); ?>">
																								<?php
																								/**
																								 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
																								 * Please check the description for 'listar_icon_output' function in functions.php.
																								 */
																								listar_icon_output( $listar_category_icon[1] );
																								?>
																							</span>
																						</div>
																					</a>
																					<?php
																				endif;
																			endforeach;
																		else :
																			$listar_category_icon  = array( 'icon-map-marker', '' );
																			?>
																			<div class="listar-category-links-wrapper">
																				<div class="listar-single-listing-category-no-link">
																					<div class="listar-category-icon-wrapper">
																						<div class="listar-category-icon-box" style="<?php echo 'background-color: rgb(' . esc_attr( $listar_category_color ) . ');'; ?>"></div>
																						<span class="<?php echo esc_attr( listar_sanitize_html_class( $listar_category_icon[0] ) ); ?>">
																							<?php
																							/**
																							 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
																							 * Please check the description for 'listar_icon_output' function in functions.php.
																							 */
																							listar_icon_output( $listar_category_icon[1] );
																							?>
																						</span>
																					</div>
																				</div>
																			</div>
																			<?php
																		endif;
																		?>
																	</div>
																</div>
																<h3 class="listar-listing-subtitle text-left <?php echo esc_attr( listar_sanitize_html_class( $listar_has_price ) ); ?>">
																	<?php echo esc_html( $listar_tagline ); ?>
																</h3>
															</div>
														</div>
														<?php
													endif;
													?>

													<?php
													if ( ( false !== strpos( $listar_price_range, '/////' ) && 0 === $listar_price_range_disable ) || ( 0 !== $listar_price_average && 0 === $listar_popular_price_disable ) ) :
														?>
														<div class="row listar-price-ranges">
															<?php
															$listar_price_range_temp = $listar_price_range;
															$listar_price_range      = ( false !== strpos( $listar_price_range, '/////' ) && 0 === $listar_price_range_disable ) ? explode( '/////', $listar_price_range ) : array( 0, 0 );
															$listar_price_range_from = (int) $listar_price_range[0];
															$listar_price_range_to   = (int) $listar_price_range[1];
															$listar_woo_currency     = listar_currency();

															if ( 0 !== $listar_price_average && 0 === $listar_popular_price_disable ) :
																$listar_has_price = 'listar-listing-has-price';
																?>
																<div class="col-sm-6 col-xs-12 listar-listing-price-range-wrapper">
																	<div class="listar-listing-price-range">
																		<div class="text-left listar-listing-price-range-title">
																			<?php esc_html_e( 'Popular Price', 'listar' ); ?>
																		</div>
																		<div class="text-right listar-listing-price-range-value">
																			<div>
																				<span>
																					<?php echo esc_html( $listar_woo_currency ); ?>
																				</span>
																				<?php echo esc_html( $listar_price_average ); ?>
																			</div>
																		</div>
																		<div class="listar-clear-both"></div>
																	</div>
																</div>
																<?php
															endif;

															if ( 0 !== $listar_price_range_from && 0 !== $listar_price_range_to && ( false !== strpos( $listar_price_range_temp, '/////' ) && 0 === $listar_price_range_disable ) ) :
																$listar_has_price = 'listar-listing-has-price';
																?>
																<div class="col-sm-6 col-xs-12 listar-listing-price-range-wrapper">
																	<div class="listar-listing-price-range">
																		<div class="text-left listar-listing-price-range-title">
																			<?php esc_html_e( 'Price Range', 'listar' ); ?>
																		</div>
																		<div class="text-right listar-listing-price-range-value">
																			<div>
																				<span>
																					<?php echo esc_html( $listar_woo_currency ); ?>
																				</span>

																				<?php echo esc_html( $listar_price_range_from ); ?>

																				<div>
																					<span>~</span>
																					<?php echo esc_html( $listar_price_range_to ); ?>
																				</div>
																			</div>
																		</div>
																		<div class="listar-clear-both"></div>
																	</div>
																</div>
																<?php
															endif;
															?>
														</div>
														<?php
													endif;

													$listar_get_post = get_the_content();
													$listar_get_post_temp = preg_replace( '/[^\w]/', '', $listar_get_post ); /* Check if the output has relevant text (Letters and/or Numbers) */
													$listar_video_url  = trim( esc_html( get_post_meta( $listar_current_post_id, '_company_video', true ) ) );
													$listar_has_video_id = false;
													$listar_condition_has_business_hours = false;
													$listar_business_hours_output = false;
													$listar_condition_has_description = ! empty( $listar_get_post_temp );
													$listar_condition_has_amenities = false;
													$listar_condition_has_private_message_form = listar_addons_active() ? true : false;
													$listar_is_rich_media_active = listar_is_rich_media_listing_active( $listar_current_post_id );
													$listar_rich_media_items_json = get_post_meta( $listar_current_post_id, '_company_business_rich_media_values', true );
													$listar_rich_media_items_array = array();
													$section_label = get_post_meta( $listar_current_post_id, '_company_business_rich_media_label', true );
													$default_section_label = esc_html__( 'Video', 'listar' );
													$rich_media_package_enabled = ! isset( $disabled_package_options['listar_disable_company_youtube'] );
													
													if ( ! empty( $section_label ) ) {
														if ( 'custom' === $section_label ) {
															$section_label = ucwords( get_post_meta( $listar_current_post_id, '_company_business_rich_media_custom_label', true ) );
														} else {
															$menu_label_options = array(
																'video'          => esc_html__( 'Video', 'listar' ),
																'video_gallery'  => esc_html__( 'Video Gallery', 'listar' ),
																'virtual_tour'   => esc_html__( 'Virtual Tour', 'listar' ),
																'highlights'     => esc_html__( 'Highlights', 'listar' ),
																'must_see'       => esc_html__( 'Must See', 'listar' ),
																'custom'         => esc_html__( 'Custom Label', 'listar' ),
															);

															foreach( $menu_label_options as $key => $value ) {
																if ( $section_label === $key ) {
																	$section_label = $value;
																}
															}
														}
													}
			
													if ( empty( $section_label ) ) {
														$section_label = $default_section_label;
													}

													if ( listar_addons_active() && ! isset( $disabled_package_options['listar_operating_hours_disable'] ) ) {
														$listar_business_hours_output = listar_company_operation_hours_availability( $listar_current_post_id, true );
														$listar_condition_has_business_hours = ! empty( $listar_business_hours_output[0] && ! empty( $listar_business_hours_output[2] ) );
													}

													if ( false !== strpos( $listar_video_url, 'youtube.com/watch?v=' ) && false !== strpos( $listar_video_url, 'http' ) ) {
														$listar_video_id = substr( $listar_video_url, strpos( $listar_video_url, 'watch?v=' ) + 8 );
														$listar_has_video_id = preg_replace( '/[^\w]/', '', $listar_video_id ); /* Check if the output has relevant text (Letters and/or Numbers) */
													}

													// Deprecated video from Youtube - Listar version until version 1.4.6.
													$listar_condition_has_video = ! empty( $listar_has_video_id ) && ! isset( $disabled_package_options['listar_disable_company_youtube'] );
													
													if ( empty ( $listar_condition_has_video ) ) :
														
														// Rich media (multiple media instances - Listar version >= 1.4.7.
														$listar_rich_media_items_temp = listar_json_decode_nice( $listar_rich_media_items_json );
													
														if ( ! empty( $listar_rich_media_items_temp ) ) :
															$count_media = 0;
															
															foreach ( $listar_rich_media_items_temp as $item ) :
																if ( isset( $item['code'] ) && ! empty( isset( $item['code'] ) ) ) :
																	$listar_rich_media_items_array[] = str_replace( '#no-iframe', '', $item['code'] );
																	$listar_condition_has_video = true;
																	$count_media++;
																	
																	if ( $count_media >= $listar_max_rich_media ) {
																		break;
																	}
																endif;
															endforeach;
														endif;
													else :
														// Has deprecated Youtube video.
														$listar_is_rich_media_active = true;
													endif;

													/* Geting all desired taxonomy items (amenities) for current listing */

													if ( taxonomy_exists( 'job_listing_amenity' ) && ! isset( $disabled_package_options['listar_disable_job_listing_amenity'] ) ) :
														$listar_args = array(
															'number' => 2000,
														);

														$listar_temp_array = array();
														$listar_temp_items = wp_get_post_terms( get_the_ID(), 'job_listing_amenity', $listar_args );

														foreach ( $listar_temp_items as $listar_amenity_item ) :
															$listar_temp_array[] = $listar_amenity_item;
														endforeach;
														
														$listar_count_temp_array = is_array( $listar_temp_array ) ? count( $listar_temp_array ) : 0;

														if ( $listar_count_temp_array ) {
															$listar_temp_array = array_filter( $listar_temp_array );
														}

														$listar_amenity_items = $listar_temp_array;

														$listar_condition_has_amenities = is_array( $listar_amenity_items ) ? count( $listar_amenity_items ) : 0;
													endif;

													if ( $listar_condition_has_description || $listar_condition_has_video || $listar_condition_has_business_hours || $listar_condition_has_amenities || $listar_condition_has_private_message_form ) :
														?>
														<div class="listar-listing-description-text <?php echo esc_attr( listar_sanitize_html_class( $listar_has_price . ' ' . $listar_has_tagline ) ); ?>">
															<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
																<?php
																$claim_status = listar_listing_claim_status( $listar_current_post_id );
																$show_claim = 'not-claimed' === $claim_status || 'awaiting-moderation' === $claim_status;
																$claim_status_class = 'not-claimed' === $claim_status ? 'listar-claim-is-not-claimed' : 'listar-claim-is-awaiting-moderation';

																if ( class_exists( 'WP_Job_Manager' ) && $show_claim && listar_is_claim_enabled() ) :
																	$add_listing_form_url = job_manager_get_permalink( 'submit_job_form' );

																	if ( ! empty( $add_listing_form_url ) ) :
																		$claim_url = $add_listing_form_url . '?claim_listing=1&claim_listing_id=' . $listar_current_post_id;
																		?>
																		<div class="accordion-group listar-business-claim-accordion">
																			<div class="panel-heading" role="tab" id="headingEight">
																				<h4 class="panel-title">
																					<a class="collapsed icon-flag2 <?php echo esc_attr( listar_sanitize_html_class( $claim_status_class ) ); ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" data-claim-url="<?php echo esc_url( $claim_url ); ?>">
																						<div class="listar-accordion-title-inner">
																							<?php echo esc_html_e( 'Is This Your Business?', 'listar' ); ?>
																						</div>
																							
																						<?php
																						if ( 'not-claimed' === $claim_status ) :
																							?>
																							<div class="listar-accordion-flag-tag">
																								<?php echo esc_html_e( 'Claim It Now', 'listar' ); ?>
																							</div>
																							<?php
																						else :
																							?>
																							<div class="listar-accordion-flag-tag">
																								<?php echo esc_html_e( 'Awaiting Moderation', 'listar' ); ?>
																							</div>
																							<?php
																						endif;
																						?>
																					</a>
																				</h4>
																			</div>
																			<div id="collapseOne" class="panel-collapse collapse in hidden listar-video-url-wrapper" role="tabpanel" aria-labelledby="headingOne">
																				<div class="panel-body">
																					<p class="listar-accordion-wrapper-paragraph">
																						<a href="<?php echo esc_url( $listar_video_url ); ?>" data-lity="data-lity"></a>
																					</p>
																				</div>
																			</div>
																		</div>
																		<?php

																	endif;
																endif;
																
																$listing_booking_active = 1 === (int) get_post_meta( $listar_current_post_id, '_job_business_use_booking', true );
																$booking_appointment_method = get_post_meta( $post->ID, '_job_business_booking_method', true );
																$is_booking_appointment_method = 'booking' === $booking_appointment_method;
																$is_external_appointment_method = 'external' === $booking_appointment_method || empty( $booking_appointment_method );
																$booking_service = get_post_meta( $listar_current_post_id, '_job_business_bookings_third_party_service', true );
																$listar_booking_service_disable = (int) get_option( 'listar_appointments_disable' );
																
																if ( $listing_booking_active && ( $is_booking_appointment_method || ( $is_external_appointment_method && ! empty( $booking_service ) ) ) && ! isset( $disabled_package_options['listar_booking_service_disable'] ) && 0 === $listar_booking_service_disable ) :
																	$booking_label = listar_get_booking_label( $listar_current_post_id );
																	?>
																	<div class="accordion-group listar-business-booking-accordion">
																		<div class="panel-heading" role="tab" id="headingNine">
																			<h4 class="panel-title">
																				<a class="collapsed icon-alarm-add" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
																					<div class="listar-accordion-title-inner">
																						<?php echo esc_html( $booking_label ); ?>
																					</div>
																						
																					<div class="listar-accordion-flag-tag">
																						<?php echo esc_html_e( 'Available', 'listar' ); ?>
																					</div>
																				</a>
																			</h4>
																		</div>
																		<div id="collapseNine" class="panel-collapse collapse hidden listar-bookings-wrapper" role="tabpanel" aria-labelledby="headingNine">
																			<div class="panel-body">
																				<p class="listar-accordion-wrapper-paragraph">
																					<?php echo wp_kses( $booking_service, 'listar-basic-html' ); ?>
																				</p>
																			</div>
																		</div>
																	</div>
																	<?php
																endif;
																?>

																<?php
																if ( $listar_condition_has_business_hours ) :
																	$listar_output_status_class = 'listar-business-status-' . $listar_business_hours_output[0];
																	$listar_output_icon_class = ! empty( $listar_business_hours_output[3] ) ? $listar_business_hours_output[3] : 'icon-alarm2';
																	?>
																	<div class="accordion-group listar-business-hours-accordion">
																		<div class="panel-heading" role="tab" id="headingThree">
																			<h4 class="panel-title">
																				<a class="collapsed <?php echo esc_attr( listar_sanitize_html_class( $listar_output_icon_class ) ); ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
																					<div class="listar-accordion-title-inner">
																						<?php echo esc_html_e( 'Today', 'listar' ); ?>
																					</div>
																					<?php echo wp_kses( $listar_business_hours_output[1], 'listar-basic-html' ); ?>
																				</a>
																			</h4>
																		</div>
																		<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
																			<div class="panel-body <?php echo esc_attr( listar_sanitize_html_class( $listar_output_status_class ) ); ?>">
																				<p class="listar-accordion-wrapper-paragraph">
																					<?php echo wp_kses( $listar_business_hours_output[2], 'listar-basic-html' ); ?>
																				</p>
																			</div>
																		</div>
																	</div>
																	<?php
																endif;
																?>
																
																<?php
																if ( $rich_media_package_enabled && $listar_condition_has_video && $listar_is_rich_media_active ) :
																	$append_listing_gallery_end = 1 === (int) get_post_meta( $listar_current_post_id, '_company_business_rich_media_append_gallery', true ) ? 'listar-append-listing-gallery-end' : '';
																	?>
																	<div class="accordion-group listar-business-video-accordion <?php echo esc_attr( listar_sanitize_html_class( $append_listing_gallery_end ) ); ?>">
																		<div class="panel-heading" role="tab" id="headingOne">
																			<h4 class="panel-title">
																				<a class="collapsed icon-play-circle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
																					<div class="listar-accordion-title-inner">
																						<?php echo esc_html( $section_label ); ?>
																					</div>
																					<div class="listar-accordion-flag-tag">
																						<?php echo esc_html_e( 'Watch', 'listar' ); ?>
																					</div>
																				</a>
																			</h4>
																		</div>
																		<div id="collapseOne" class="panel-collapse collapse in hidden listar-video-url-wrapper" role="tabpanel" aria-labelledby="headingOne">
																			<div class="panel-body">
																				<p class="listar-accordion-wrapper-paragraph">
																					<?php
																					if ( ! empty( $listar_has_video_id ) ) :
																						
																						// Deprecated video from Youtube - Listar version until version 1.4.6.
																						?>
																						<a data-fancybox="mixed" href="<?php echo esc_url( $listar_video_url ); ?>"></a>
																						<?php
																					else :
																						
																						// Rich media (multiple media instances - Listar version >= 1.4.7.
																						
																						foreach ( $listar_rich_media_items_array as $item ) :
																							$item = rawurldecode( $item );
																							$item_href = '';
																					
																							if ( false !== strpos( $item, 'http://' ) || false !== strpos( $item, 'https://' ) ) {

																								// Seems to contain a valid URL.

																								if ( false !== strpos( $item, '<' ) || false !== strpos( $item, '>' ) ) :

																									// Seems HTML, use iframe.
																									$item = listar_get_html_attributes( $item );
																								
																									if ( isset( $item['src'] ) ) :
																										$item_href = $item['src'];
																									
																										if ( false === strpos( $item_href, '.google.' ) || ( false !== strpos( $item_href, '.google.' ) && false !== strpos( $item_href, 'maps/embed' ) ) ) :
																											?>
																											<a data-fancybox="mixed" data-type="iframe" href="<?php echo esc_url( $item_href ); ?>"></a>
																											<?php
																										else :
																											?>
																											<a data-fancybox="mixed" data-options='{"iframe" : {}}' href="<?php echo esc_url( $item_href ); ?>"></a>
																											<?php
																										endif;
																									endif;
																								else :
																									// Seems a link.
																									$item_href = $item;
																									?>
																									<a data-fancybox="mixed" href="<?php echo esc_url( $item_href ); ?>"></a>
																									<?php
																								endif;
																							}
																						endforeach;
																					endif;
																					?>
																				</p>
																			</div>
																		</div>
																	</div>
																	<?php

																endif;
																?>

																<?php
																if ( $listar_condition_has_description ) :
																	?>
																	<div class="accordion-group listar-introduction-accordion">
																		<div class="panel-heading" role="tab" id="headingTwo">
																			<h4 class="panel-title">
																				<a class="collapsed icon-menu-circle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																					<div class="listar-accordion-title-inner">
																						<?php echo esc_html_e( 'Description', 'listar' ); ?>
																					</div>
																				</a>
																			</h4>
																		</div>
																		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
																			<div class="panel-body">
																				<p class="listar-accordion-wrapper-paragraph">
																					<?php
																					$listar_post_status = get_post_status();
																					$listar_hide_expired_content = 1 === (int) get_option( 'job_manager_hide_expired_content', 1 ) ? true : false;
																					$listar_post_status_by_role = 1 === $listar_hide_expired_content && ! ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) && 'expired' === $listar_post_status ? 'expired' : 'published';
																					
																					echo wp_kses( apply_filters( 'the_content', wpautop( $listar_get_post, true ) ), 'post' );

																					if ( 'expired' === $listar_post_status && true === $listar_hide_expired_content && ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) ) :
																						?>
																						<div class="single_job_listing listar-expired-listing-admin">
																							<?php
																							/**
																							 * single_job_listing_start hook
																							 *
																							 * @hooked job_listing_meta_display - 20
																							 * @hooked job_listing_company_display - 30
																							 */
																							do_action( 'single_job_listing_start' );
																							?>
																							<div class="job_description">
																								<?php wpjm_the_job_description(); ?>
																							</div>
																							<?php
																							/**
																							 * single_job_listing_end hook
																							 */
																							do_action( 'single_job_listing_end' );
																							?>
																						</div>
																						<?php
																					endif;
																					?>
																				</p>
																			</div>
																		</div>
																	</div>
																	<?php
																endif;
																?>
																
																<?php
																if (  ! isset( $disabled_package_options['listar_menu_catalog_disable'] ) ) :
																	
																	/* Menu/catalog(s) for current listing - Requires Listar Addons plugin */
																	do_action( 'listar_listing_catalogs' );
																endif;
																?>

																<?php
																if ( $listar_condition_has_amenities ) :
																	$listar_grouped_amenities = array();
																	$listar_amenities_label = esc_html__( 'Amenities', 'listar' );

																	if ( $listar_group_amenities ) {
																		$listar_grouped_amenities[ $listar_amenities_label ] = array();

																		foreach ( $listar_amenity_items as $listar_amenity_item ) :
																			if ( isset( $listar_amenity_item->parent ) && ! empty( $listar_amenity_item->parent ) ) {
																				$parent = get_term_by( 'id', $listar_amenity_item->parent, 'job_listing_amenity' );
																				$listar_grouped_amenities[ $parent->name ][] = $listar_amenity_item;
																			} else {
																				$listar_grouped_amenities[ $listar_amenities_label ][] = $listar_amenity_item;
																			}	
																		endforeach;

																		foreach ( $listar_grouped_amenities as $key => $group ) :
																			$rand = wp_rand( 0, 99999 );
																			?>
																			<!-- Start Amenities Section -->
																			<div class="accordion-group listar-listing-amenities-accordion">
																				<div class="panel-heading" role="tab" id="heading<?php echo esc_attr( $rand ); ?>">
																					<h4 class="panel-title">
																						<a class="collapsed icon-checkmark-circle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo esc_attr( $rand ); ?>" aria-expanded="false" aria-controls="collapse<?php echo esc_attr( $rand ); ?>">
																							<div class="listar-accordion-title-inner">
																								<?php echo esc_html( $key ); ?>
																							</div>
																						</a>
																					</h4>
																				</div>
																				<div id="collapse<?php echo esc_attr( $rand ); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo esc_attr( $rand ); ?>">
																					<div class="panel-body">
																						<p class="listar-accordion-wrapper-paragraph">
																							<div class="listar-listing-amenities-wrapper">
																								<div class="listar-listing-amenities-inner">
																									<div>
																										<?php
																										foreach ( $group as $listar_amenity_item ) :
																											$listar_amenity_id  = $listar_amenity_item->term_id;
																											$listar_amenity_url = get_term_link( $listar_amenity_id, 'job_listing_amenity' );
																											$listar_data        = get_option( "taxonomy_$listar_amenity_id" );
																											$listar_icon        = listar_icon_class( isset( $listar_data['term_icon'] ) ? esc_html( $listar_data['term_icon'] ) : 'icon-tags' );
																											$listar_term_color  = listar_term_color( $listar_amenity_id );
																											?>

																											<a href="<?php echo esc_url( $listar_amenity_url ); ?>" class="button listar-iconized-button <?php echo esc_attr( listar_sanitize_html_class( $listar_icon[0] ) ); ?> listar-amenity-desktop" style="background-color:rgb(<?php echo esc_attr( $listar_term_color ); ?>);">
																												<?php
																												/**
																												 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
																												 * Please check the description for 'listar_icon_output' function in functions.php.
																												 */
																												listar_icon_output( $listar_icon[1] );
																												?>
																												<span>
																													<?php
																													echo esc_html( $listar_amenity_item->name );
																													?>
																												</span>
																											</a>

																											<?php
																										endforeach;
																										?>
																									</div>
																								</div>
																							</div>
																						</p>
																					</div>
																				</div>
																			</div>
																			<!-- End Amenities Section -->
																			<?php
																		endforeach;
																	} else {
																		?>
																		<!-- Start Amenities Section -->
																		<div class="accordion-group listar-listing-amenities-accordion">
																			<div class="panel-heading" role="tab" id="headingFour">
																				<h4 class="panel-title">
																					<a class="collapsed icon-checkmark-circle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
																						<div class="listar-accordion-title-inner">
																							<?php echo esc_html_e( 'Amenities', 'listar' ); ?>
																						</div>
																					</a>
																				</h4>
																			</div>
																			<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
																				<div class="panel-body">
																					<p class="listar-accordion-wrapper-paragraph">
																						<div class="listar-listing-amenities-wrapper">
																							<div class="listar-listing-amenities-inner">
																								<div>
																									<?php
																									foreach ( $listar_amenity_items as $listar_amenity_item ) :
																										$listar_amenity_id  = $listar_amenity_item->term_id;
																										$listar_amenity_url = get_term_link( $listar_amenity_id, 'job_listing_amenity' );
																										$listar_data        = get_option( "taxonomy_$listar_amenity_id" );
																										$listar_icon        = listar_icon_class( isset( $listar_data['term_icon'] ) ? esc_html( $listar_data['term_icon'] ) : 'icon-tags' );
																										$listar_term_color  = listar_term_color( $listar_amenity_id );
																										?>

																										<a href="<?php echo esc_url( $listar_amenity_url ); ?>" class="button listar-iconized-button <?php echo esc_attr( listar_sanitize_html_class( $listar_icon[0] ) ); ?> listar-amenity-desktop" style="background-color:rgb(<?php echo esc_attr( $listar_term_color ); ?>);">
																											<?php
																											/**
																											 * Skipping sanitization for SVG code ( This output can contain SVG code or not ).
																											 * Please check the description for 'listar_icon_output' function in functions.php.
																											 */
																											listar_icon_output( $listar_icon[1] );
																											?>
																											<span>
																												<?php
																												echo esc_html( $listar_amenity_item->name );
																												?>
																											</span>
																										</a>

																										<?php
																									endforeach;
																									?>
																								</div>
																							</div>
																						</div>
																					</p>
																				</div>
																			</div>
																		</div>
																		<!-- End Amenities Section -->
																		<?php
																	}
																endif;
																
																if ( ! isset( $disabled_package_options['listar_external_references_disable'] ) ) :

																	/* External links for current listing - Requires Listar Addons plugin */
																	do_action( 'listar_listing_external_links' );
																endif;																

																if ( ! ( 1 === $listar_disable_private_messages ) && ! ( $listar_disable_pvt_messages_list ) && ! isset( $disabled_package_options['listar_disable_private_message'] ) ) :

																	/* Private message form for current listing - Requires Listar Addons plugin */
																	do_action( 'listar_listing_private_message_form' );
																endif;
																?>
															</div>
														</div>
														<?php
													endif;
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Listing Description -->
				</div>
			</div>
		</div>
	</div>
</section>

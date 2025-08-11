<?php
/**
 * Template part for displaying menu/catalog(s) for listings
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar_Addons
 */

/**
 * Action to output menu/catalog(s) for listings.
 */
add_action( 'listar_listing_catalogs', 'listar_listing_catalogs_output' );

if ( ! function_exists( 'listar_listing_catalogs_output' ) ) :
	/**
	 * Menu/catalog(s) output (HTML).
	 *
	 * @since 1.2.7
	 */
	function listar_listing_catalogs_output() {
		global $post;
		
		$listar_current_post_id = $post->ID;
		$use_menus = (bool) get_post_meta( $listar_current_post_id, '_job_business_use_catalog', true );
		$disable_menus = (int) get_option( 'listar_menu_catalog_disable' );
		$has_menu_list = false;
		$has_menu_files = false;
		$has_menu_external = false;
		
		$section_label = get_post_meta( $listar_current_post_id, '_job_business_catalog_label', true );
		$default_section_label = esc_html__( 'Menu', 'listar' );
		$default_file_label = esc_html__( 'Download File', 'listar' );
		$default_external_label = esc_html__( 'External Source', 'listar' );
		$download_file_counter = 0;
		$external_source_counter = 0;
		
		$menu_file_1 = false;
		$menu_file_2 = false;
		$menu_file_3 = false;
		$menu_file_4 = false;
		$menu_file_5 = false;
		$menu_file_6 = false;
		
		$menu_file_external_1 = false;
		$menu_file_external_2 = false;
		$menu_file_external_3 = false;
		$menu_file_external_4 = false;
		$menu_file_external_5 = false;
		$menu_file_external_6 = false;
		
		if ( $use_menus && 0 === $disable_menus ) {
			$use_menu_list = (bool) get_post_meta( $listar_current_post_id, '_job_business_use_price_list', true );
			$use_menu_docs = (bool) get_post_meta( $listar_current_post_id, '_job_business_use_catalog_documents', true );
			$use_menu_external = (bool) get_post_meta( $listar_current_post_id, '_job_business_use_catalog_external', true );
			
			if ( $use_menu_list ) {
				$menu_list_json = get_post_meta( $listar_current_post_id, '_job_business_price_list_content', true );
				
				if ( ! empty( $menu_list_json ) && 'string' === gettype( $menu_list_json ) && '[]' !== $menu_list_json && '{}' !== $menu_list_json && '[[]]' !== $menu_list_json && '[{}]' !== $menu_list_json && '0' !== $menu_list_json && 'undefined' !== $menu_list_json ) {
					$elements_array_temp = listar_json_decode_nice( wp_unslash( $menu_list_json ), true );
					$elements_array = is_array( $elements_array_temp ) ? $elements_array_temp : array();
					$count = count( $elements_array );
					$price_list_items = array();
					
					for ( $i = 0; $i < $count; $i++ ) {
						$price_list_temp = $elements_array[ $i ];
						
						if ( is_array( $price_list_temp ) && ! empty( $price_list_temp ) ) {
							$has_menu_list = true;
							
							foreach( $price_list_temp as $key => $value ) {
								if ( isset( $price_list_temp['title'] ) && ! empty( isset( $price_list_temp['title'] ) ) ) {
									$price_list_items[ $i ][ $key ] = trim( rawurldecode( $price_list_temp[ $key ] ) );
								} else {
									break;
								}
							}
						}
					}
				}
			}
			
			if ( $use_menu_docs ) {
				$menu_file_1  = get_post_meta( $listar_current_post_id, '_job_business_document_1_file', true );
				$menu_file_2  = get_post_meta( $listar_current_post_id, '_job_business_document_2_file', true );
				$menu_file_3  = get_post_meta( $listar_current_post_id, '_job_business_document_3_file', true );
				$menu_file_4  = get_post_meta( $listar_current_post_id, '_job_business_document_4_file', true );
				$menu_file_5  = get_post_meta( $listar_current_post_id, '_job_business_document_5_file', true );
				$menu_file_6  = get_post_meta( $listar_current_post_id, '_job_business_document_6_file', true );

				if ( $menu_file_1 || $menu_file_2 || $menu_file_3 || $menu_file_4 || $menu_file_5 || $menu_file_6 ) {
					$has_menu_files = true;
				}
			}

			if ( $use_menu_external ) {
				$menu_file_external_1  = get_post_meta( $listar_current_post_id, '_job_business_document_1_file_external', true );
				$menu_file_external_2  = get_post_meta( $listar_current_post_id, '_job_business_document_2_file_external', true );
				$menu_file_external_3  = get_post_meta( $listar_current_post_id, '_job_business_document_3_file_external', true );
				$menu_file_external_4  = get_post_meta( $listar_current_post_id, '_job_business_document_4_file_external', true );
				$menu_file_external_5  = get_post_meta( $listar_current_post_id, '_job_business_document_5_file_external', true );
				$menu_file_external_6  = get_post_meta( $listar_current_post_id, '_job_business_document_6_file_external', true );

				if ( $menu_file_external_1 || $menu_file_external_2 || $menu_file_external_3 || $menu_file_external_4 || $menu_file_external_5 || $menu_file_external_6 ) {
					$has_menu_external = true;
				}
			}
		}

		if ( $has_menu_files || $has_menu_external || $has_menu_list ) :
			if ( ! empty( $section_label ) ) {
				if ( 'custom' === $section_label ) {
					$section_label = ucwords( get_post_meta( $listar_current_post_id, '_job_business_catalog_custom_label', true ) );
				} else {
					$menu_label_options = array(
						'menu'      => esc_html__( 'Menu', 'listar' ),
						'catalog'   => esc_html__( 'Catalog', 'listar' ),
						'products'  => esc_html__( 'Products', 'listar' ),
						'services'  => esc_html__( 'Services', 'listar' ),
						'pricing'   => esc_html__( 'Pricing', 'listar' ),
						'files'     => esc_html__( 'Files', 'listar' ),
						'documents' => esc_html__( 'Documents', 'listar' ),
						'downloads' => esc_html__( 'Downloads', 'listar' ),
						'custom'    => esc_html__( 'Custom Label', 'listar' ),
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
			?>
			<!-- Start References Section -->
			<div class="accordion-group listar-listing-menu-accordion">
				<div class="panel-heading" role="tab" id="headingSeven">
					<h4 class="panel-title">
						<a class="collapsed icon-notification" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
							<?php echo esc_html( $section_label ); ?>
						</a>
					</h4>
				</div>
				<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
					<div class="panel-body">
						<p class="listar-accordion-wrapper-paragraph">
							<div>
								<?php
								if ( $has_menu_list ) :
									?>
									<div class="listar-pricing-menu-items">
										<?php
										$list_categories = array();
										$organized_items = array();
										
										$category_count = 0;

										foreach ( $price_list_items as $item  ) :
											$category_count++;
										
											$category_id    = isset( $item['category_id'] ) && ! empty( $item['category_id'] ) ? $item['category_id'] : 'unknown-category';
											$category_title = isset( $item['category'] ) && ! empty( $item['category'] ) ? $item['category'] : '';
											$item_tag       = isset( $item['tag'] ) && ! empty( $item['tag'] ) ? $item['tag'] : '';
											$item_title     = isset( $item['title'] ) && ! empty( $item['title'] ) ? $item['title'] : '';
											$item_price     = isset( $item['price'] ) && ! empty( $item['price'] ) ? $item['price'] : '';
											$item_descr     = isset( $item['description'] ) && ! empty( $item['description'] ) ? $item['description'] : '';
                                                                                        $item_link      = isset( $item['link'] ) && ! empty( $item['link'] ) ? $item['link'] : '';
                                                                                        $item_image_url = isset( $item['imageURL'] ) && ! empty( $item['imageURL'] ) ? $item['imageURL'] : '';
											$item_image_id = isset( $item['imageID'] ) && ! empty( $item['imageID'] ) ? $item['imageID'] : '';
                                                                                        $item_label     = isset( $item['label'] ) && ! empty( $item['label'] ) ? $item['label'] : '';

											if ( ! empty( $item_title ) ) {
												$organized_items[ $category_id ][] = array( 
													'category_id' => $category_id,
													'tag'         => $item_tag,
													'title'       => $item_title,
													'price'       => $item_price,
													'description' => $item_descr,
                                                                                                        'link'        => $item_link,
                                                                                                        'label'       => $item_label,
													'imageURL'       => $item_image_url,
													'imageID'       => $item_image_id,
												);
											}
											
											if ( ! empty( $category_title ) && ! isset( $list_categories[ $category_id ] ) ) {
												$list_categories[ $category_id ] = $category_title;
											}
										endforeach;
										
										if ( ! empty ( $list_categories ) ) :
											?>
											<ul class="nav nav-tabs">
												<?php
												$category_count_2 = 0;

												foreach ( $list_categories as $key => $value  ) :
													$category_count_2++;
													$category_id = $key;
													$category_title = $value;
													$active = 1 === $category_count_2 ? 'active' : '';
													?>
													<li class="<?php echo sanitize_html_class( $active ); ?>">
														<a data-toggle="tab" href="#<?php echo esc_attr( $category_id ); ?>">
															<?php echo esc_html( $category_title ); ?>
														</a>
													</li>
													<?php
												endforeach;
												?>
											</ul>
										<?php
										endif;
										?>

										<div class="tab-content">
											<?php
											$category_count_3 = 0;

											foreach ( $organized_items as $category_id => $final_item  ) :
												$category_count_3++;
												$active = 1 === $category_count_3 ? 'active' : '';
												?>
												<div id="<?php echo esc_attr( $category_id ); ?>" class="tab-pane fade in <?php echo sanitize_html_class( $active ); ?>">
													<ul class="listar-price-list-wrapper">
														<?php
														foreach( $final_item as $item ) :
															//printf('<pre>%s</pre>', var_export($item,true));
															//break;
															$item_tag   = $item['tag'];
															$item_title = $item['title'];
															$item_price = $item['price'];
															$item_descr = $item['description'];
                                                                                                                        $item_link  = $item['link'];
															$item_image_url  = $item['imageURL'];
															$item_image_id  = $item['imageID'];
                                                                                                                        $item_label = $item['label'];
															$has_tag    = ! empty( $item_tag ) ? 'listar-item-has-tag' : '';
															$item_image = '';

															if ( ! empty( $item_image_id ) && is_numeric( $item_image_id ) ) {
																$item_image = listar_image_url( $item_image_id, 'listar-cover' );
															}

															if ( empty( $item_image ) ) {
																$item_image = $item_image_url;

																if ( ! listar_url_exists( $item_image ) ) {
																	$item_image = '';
																}
															}
															?>
															<li class="listar-pricing-item <?php echo sanitize_html_class( $has_tag ); ?>">
																<?php
																if ( ! empty( $item_tag ) ) :
																	?>
																	<div class="listar-price-item-tag-label-wrapper">
																		<span class="listar-price-item-tag-label">
																			<?php echo esc_html( $item_tag ); ?>
																		</span>
																	</div>
																	<?php
																endif;
																?>
																<div class="listar-price-item-content-wrapper">
																	<div class="listar-price-item-title-dotted"></div>
																	<div class="listar-price-item-title">
																		<span>
																			<?php echo esc_html( $item_title ); ?>
																		</span>
																	</div>
																	<?php																
																	if ( ! empty( $item_price ) ) :
																		?>
																		<span class="listar-price-item-price-value">
																			<span class="listar-currency-symbol"><?php echo esc_html( listar_currency() ); ?></span>
																			<?php echo esc_html( $item_price ); ?>
																		</span>
																		<?php
																	endif;

                                                                                                                                        if ( ! empty( $item_descr ) || ! empty( $item_image ) ) :
                                                                                                                                                ?>
                                                                                                                                                <div class="listar-clear-both"></div>
                                                                                                                                                <div class="listar-price-item-description">
																			<?php
																			if ( ! empty( $item_image ) ) :
																				?>
																				<a href="<?php echo esc_url( $item_image ); ?>" rel="lightbox" data-lightbox="pricing-gallery" title="<?php echo esc_attr( $item_title ); ?>" class="listar-pricing-item-front-image fa fa-search" style="background-image:url(<?php echo esc_url( $item_image ); ?>);"></a>
																				<?php
																			endif;
																			?>
                                                                                                                                                        <?php echo esc_html( $item_descr ); ?>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                                                                        endif;
                                                                                                                                        ?>
                                                                                                                                        <div class="listar-clear-both"></div>
                                                                                                                                        <?php
                                                                                                                                        if ( ! empty( $item_link ) ) :
                                                                                                                                                $item_label = empty( $item_label ) ? esc_html__( 'More Info', 'listar' ) : $item_label;
                                                                                                                                                ?>                                                                                                                                                
                                                                                                                                                <div class="listar-price-item-more-info-link-wrapper text-right">
                                                                                                                                                        <a target="_blank" href="<?php echo esc_url( $item_link );?>" class="fa fa-arrow-right">
                                                                                                                                                                <?php echo esc_html( $item_label ); ?>
                                                                                                                                                        </a>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                                                                        endif;
																	?>
																	<div class="listar-clear-both"></div>
																</div>
															</li>
															<?php
														endforeach;
														?>
													</ul>
												</div>
												<?php
											endforeach;
											?>
										</div>
									</div>
									<?php
								endif;
								?>
								
								<div class="listar-listing-more-info-wrapper container">
									<?php
									if ( $has_menu_files ) :
										?>
										<div class="listar-listing-more-info-inner row">
											<div class="listar-header-more-info col-md-12">
												<?php echo esc_html_e( 'File(s) for download:', 'listar' ); ?>
											</div>
											<div class="listar-more-info-links col-md-12">
												<div class="row">
													<div class="listar-more-info-links-margin"></div>
													<?php
													if ( $menu_file_1 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_1_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_1 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_2 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_2_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_2 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_3 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_3_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_3 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_4 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_4_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_4 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_5 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_5_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_5 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_6 ) :
														$download_file_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_6_title', true );

														if ( empty( $label ) ) {
															$label = $default_file_label . ' ' . $download_file_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_6 ); ?>" class="icon-download2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
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
									if ( $has_menu_external ) :
										?>
										<div class="listar-listing-more-info-inner row">
											<div class="listar-header-more-info col-md-12">
												<?php echo esc_html_e( 'External Source(s):', 'listar' ); ?>
											</div>
											<div class="listar-more-info-links col-md-12">
												<div class="row">
													<div class="listar-more-info-links-margin"></div>
													<?php
													if ( $menu_file_external_1 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_1_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_1 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_external_2 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_2_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_2 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_external_3 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_3_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_3 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_external_4 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_4_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_4 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_external_5 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_5_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_5 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
													<?php
													if ( $menu_file_external_6 ) :
														$external_source_counter++;
														$label = get_post_meta( $listar_current_post_id, '_job_business_document_6_title_external', true );

														if ( empty( $label ) ) {
															$label = $default_external_label . ' ' . $external_source_counter;
														}
														?>
														<div class="listar-more-info-link col-xs-12 col-sm-6">
															<a target="_blank" href="<?php echo esc_url( $menu_file_external_6 ); ?>" class="icon-link2">
																<?php echo esc_html( $label ); ?>
															</a>
														</div>
														<?php
													endif;
													?>
												</div>
											</div>
										</div>
										<?php
									endif;
									?>
								</div>
							</div>
						</p>
					</div>
				</div>
			</div>
			<!-- End References Section -->
			<?php
		endif;
	}
endif;

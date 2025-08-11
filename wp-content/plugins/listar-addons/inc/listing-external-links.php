<?php
/**
 * Template part for displaying external links for listings
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar_Addons
 */

/**
 * Action to output external links for listings.
 */
add_action( 'listar_listing_external_links', 'listar_listing_external_links_output' );

if ( ! function_exists( 'listar_listing_external_links_output' ) ) :
	/**
	 * External links output (HTML).
	 *
	 * @since 1.2.7
	 */
	function listar_listing_external_links_output() {
		global $post;
		
		$listar_current_post_id = $post->ID;
		$listar_external_references_disable = (int) get_option( 'listar_external_references_disable' );
		$use_external_links = (bool) get_post_meta( $listar_current_post_id, '_company_use_external_links', true );
		$has_external_links = false;
		
		$external_link_1 = false;
		$external_link_2 = false;
		$external_link_3 = false;
		$external_link_4 = false;
		$external_link_5 = false;
		$external_link_6 = false;
		$external_link_7 = false;
		$external_link_8 = false;
		$external_link_9 = false;
		$external_link_10 = false;
		$external_link_11 = false;
		$external_link_12 = false;
		
		if ( $use_external_links && 0 === $listar_external_references_disable ) {
			$external_link_1  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_1', true ), true );
			$external_link_2  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_2', true ), true );
			$external_link_3  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_3', true ), true );
			$external_link_4  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_4', true ), true );
			$external_link_5  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_5', true ), true );
			$external_link_6  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_6', true ), true );
			$external_link_7  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_7', true ), true );
			$external_link_8  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_8', true ), true );
			$external_link_9  = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_9', true ), true );
			$external_link_10 = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_10', true ), true );
			$external_link_11 = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_11', true ), true );
			$external_link_12 = listar_get_domain_name( get_post_meta( $listar_current_post_id, '_company_external_link_12', true ), true );
			
			if ( $external_link_1 || $external_link_2 || $external_link_3 || $external_link_4 || $external_link_5 || $external_link_6 || $external_link_7 || $external_link_8 || $external_link_9 || $external_link_10 || $external_link_11 || $external_link_12 ) {
				$has_external_links = true;
			}
		}

		if ( $has_external_links ) :
			?>
			<!-- Start References Section -->
			<div class="accordion-group listar-listing-more-info-accordion">
				<div class="panel-heading" role="tab" id="headingSix">
					<h4 class="panel-title">
						<a class="collapsed icon-arrow-right-circle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
							<?php echo esc_html_e( 'References', 'listar' ); ?>
						</a>
					</h4>
				</div>
				<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
					<div class="panel-body">
						<p class="listar-accordion-wrapper-paragraph">
							<div>
								<div class="listar-listing-more-info-wrapper container">
									<div class="listar-listing-more-info-inner row">
										<div class="listar-header-more-info col-md-12">
											<?php echo esc_html_e( 'Check external source(s) for more info:', 'listar' ); ?>
										</div>
										<div class="listar-more-info-links col-md-12">
											<div class="row">
												<div class="listar-more-info-links-margin"></div>
												<?php
												if ( $external_link_1 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_1['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_1['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_2 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_2['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_2['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_3 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_3['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_3['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_4 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_4['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_4['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_5 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_5['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_5['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_6 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_6['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_6['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_7 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_7['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_7['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_8 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_8['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_8['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_9 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_9['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_9['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_10 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_10['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_10['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_11 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_11['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_11['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
												<?php
												if ( $external_link_12 ) :
													?>
													<div class="listar-more-info-link col-xs-12 col-sm-6">
														<a target="_blank" href="<?php echo esc_url( $external_link_12['url'] ); ?>" class="icon-link2">
															<?php echo esc_html( $external_link_12['host'] ); ?>
														</a>
													</div>
													<?php
												endif;
												?>
											</div>
										</div>
									</div>
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

<?php
/**
 * Template part for displaying search form to listings
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $post;

$listar_hero_title             = '';
$listar_hero_subtitle          = '';
$listar_get_search_placeholder = get_option( 'listar_search_input_placeholder' );
$listar_search_placeholder     = empty( $listar_get_search_placeholder ) ? esc_html__( 'What do you need?', 'listar' ) : $listar_get_search_placeholder;
$listar_search_field_enabled   = true;
$listar_is_search_popup        = listar_search_is_inside_popup();
$listar_is_front_page          = listar_is_front_page_template();
$listar_has_hero_text          = false;

if ( $listar_is_front_page && ! $listar_is_search_popup ) {
	$listar_search_field_enabled = 0 === (int) get_option( 'listar_disable_hero_search_front' ) ? true : false;
}

if ( ! $listar_is_search_popup ) {
	if ( isset( $post->ID ) ) :
		$listar_hero_title    = get_post_meta( $post->ID, 'listar_meta_box_frontpage_title', true );
		$listar_hero_subtitle = get_post_meta( $post->ID, 'listar_meta_box_page_subtitle', true );
	endif;

	if ( ! empty( $listar_hero_title ) ) :
		$listar_hero_title = '<h1><span>' . $listar_hero_title . '</span></h1>';
	else :
		$listar_hero_title = false;
	endif;

	if ( ! empty( $listar_hero_subtitle ) ) :
		$listar_hero_subtitle = '<p>' . $listar_hero_subtitle . '</p>';
	else :
		$listar_hero_subtitle = false;
	endif;

	$listar_has_hero_text = ! empty( $listar_hero_title ) || ! empty( $listar_hero_subtitle ) ? 'listar-has-hero-text' : false;
}

if ( $listar_has_hero_text && $listar_is_front_page ) :
	?>
	<!-- Start Hero Title and Subtitle -->
	<div class="listar-hero-section-title">
		<?php echo wp_kses( ( $listar_hero_title ? $listar_hero_title : '' ) . ( $listar_hero_subtitle ? $listar_hero_subtitle : '' ), 'listar-basic-html' ); ?>
	</div>
	<!-- End Hero Title and Subtitle -->
	<?php
else :
	if ( $listar_is_search_popup ) :
		$listar_hero_title    = get_option( 'listar_search_popup_title' );
		$listar_hero_subtitle = get_option( 'listar_search_popup_subtitle' );
		
		if ( empty( $listar_hero_title ) ) {
			$listar_hero_title = esc_html__( 'Search', 'listar' );
		}
		
		if ( empty( $listar_hero_subtitle ) ) {
			$listar_hero_subtitle =  esc_html__( 'Start typing what you are looking for.', 'listar' );
		}
		
		$listar_hero_title    = '<h1><span>' .$listar_hero_title . '</span></h1>';
		$listar_hero_subtitle = '<p>' . $listar_hero_subtitle . '</p>';
		$listar_has_hero_text = 'listar-has-hero-text';
		?>
		<!-- Start Hero Title and Subtitle -->
		<div class="listar-hero-section-title">
			<?php echo wp_kses( $listar_hero_title . $listar_hero_subtitle, 'listar-basic-html' ); ?>
		</div>
		<!-- End Hero Title and Subtitle -->
		<?php
	endif;
endif;

if ( taxonomy_exists( 'job_listing_amenity' ) ) :

	/* Reset last filter list saved */
	listar_current_filter_elements( array(), true );

	/* Create new filter list */
	listar_hierarchical_terms_tree( 0, 'job_listing_amenity' );

endif;

if ( $listar_search_field_enabled ) :
	?>	
	<!-- Start Hero Search -->

	<div class="listar-hero-search-wrapper">

		<div class="listar-hero-search <?php echo esc_attr( listar_sanitize_html_class( $listar_has_hero_text ) ); ?>">

			<form method="get" class="search-form" action="<?php echo esc_url( network_site_url( '/' ) ); ?>">

				<?php
				$listar_search_query = listar_is_search() ? listar_get_search_query() : '';
				$listar_current_explore_by_filter = 'default';
				$listar_current_explore_by_country = 0;
				$search_type = 'listing';
				$listar_current_explore_by_address = '';
				$listar_current_explore_by_postcode = '';

				/* Are the Explore By options active? */
				$explore_by_active = false;

				if ( listar_addons_active() ) {
					$explore_by_active = listar_is_search_by_options_active();
					$listar_current_explore_by_country = listar_current_explore_by_country();
				}

				if ( $explore_by_active ) :
					$search_by_tip_active = 0 === (int) get_option( 'listar_disable_search_by_tip' ) && post_type_exists( 'job_listing' ) ? true : '';
					$search_by_input_title_active = 0 === (int) get_option( 'listar_disable_search_by_input_title' ) ? true : false;
					$listar_search_options_active = listar_get_search_options();
					$listar_current_explore_by_filter = listar_current_explore_by();
					$listar_current_explore_by_address = listar_current_search_address();
					$listar_current_explore_by_postcode = listar_current_search_postcode();
					
					if ( ! isset( $listar_search_options_active[ $listar_current_explore_by_filter ] ) ) {
						$listar_current_explore_by_filter = 'default';
					}
					 
					$listar_current_explore_by_class = $listar_search_options_active[ $listar_current_explore_by_filter ][1];
					$listar_current_explore_by_title = $listar_search_options_active[ $listar_current_explore_by_filter ][0];

					if ( 'blog' === $listar_search_options_active[ $listar_current_explore_by_filter ][4] ) {
						$search_type = 'blog';
					}

					if ( $search_by_tip_active ) :
						$tip = get_option( 'listar_search_by_tip_text' );
						$animate_tip = 1 === (int) get_option( 'listar_animate_search_by_tip' ) ? true : false;
						$tip_class = $animate_tip ? 'listar-animate-search-by-tip' : '';
					
						if ( empty( $tip ) ) {
							$tip = esc_html__( 'Settings', 'listar' );
						}
						?>
						<strong class="listar-search-by-tip <?php echo esc_attr( listar_sanitize_html_class( $tip_class ) ); ?>">
							<?php echo esc_html( $tip ); ?>
						</strong>
						<?php
					endif;
					?>

					<?php
					if ( $search_by_input_title_active ) :
						?>
						<div class="listar-current-search-by listar-strong">
							<?php echo esc_html( $listar_current_explore_by_title ); ?>
						</div>
						<?php
					endif;
					
					$has_fa_class = false !== strpos( $listar_current_explore_by_class, 'fa-' ) ? 'fa ' : '';
					?>

					<div class="listar-clean-search-by-filters-button fa fa-times" data-toggle="tooltip" data-placement="bottom" title="<?php esc_attr_e( 'Clean all filters', 'listar' ); ?>"></div>
					<div class="listar-clean-search-input-button fa fa-ban" data-toggle="tooltip" data-placement="bottom" title="<?php esc_attr_e( 'Clean input', 'listar' ); ?>"></div>
					<div class="listar-search-by-button <?php echo esc_attr( listar_sanitize_html_class( $has_fa_class . $listar_current_explore_by_class ) ); ?>" data-explore-by-type="<?php echo esc_attr( $listar_search_options_active[ $listar_current_explore_by_filter ][4] ); ?>"></div>

					<?php
				endif;
				?>

				<fieldset>
					<input type="text" class="listar-listing-search-input-field form-control" placeholder="<?php echo esc_attr( $listar_search_placeholder ); ?>" data-name="s" value="<?php echo esc_attr( ucfirst( $listar_search_query ) ); ?>" data-value="<?php echo esc_attr( ucfirst( $listar_search_query ) ); ?>">
				</fieldset>

				<?php get_template_part( 'template-parts/directory-parts/listings-header', 'regions' ); ?>

				<input type="hidden" name="post_type" class="listar-listing-search-input-field listar-post-type-form-field form-control" data-name="post_type">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'search_type' ) ); ?>" value="<?php echo esc_attr( $search_type ); ?>">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_sort' ) ); ?>" value="<?php echo esc_attr( listar_current_directory_sort() ); ?>">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'explore_by' ) ); ?>" value="<?php echo esc_attr( $listar_current_explore_by_filter ); ?>">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'selected_country' ) ); ?>" value="<?php echo esc_attr( $listar_current_explore_by_country ); ?>">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'saved_address' ) ); ?>" value="<?php echo esc_attr( $listar_current_explore_by_address ); ?>">
				<input type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'saved_postcode' ) ); ?>" value="<?php echo esc_attr( $listar_current_explore_by_postcode ); ?>">
				<input class="listar-chosen-region" type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_regions' ) ); ?>" value="">
				<input class="listar-chosen-category" type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_categories' ) ); ?>" value="">
				<input class="listar-chosen-amenity" type="hidden" name="<?php echo esc_attr( listar_url_query_vars_translate( 'listing_amenities' ) ); ?>" value="">

				<div class="listar-search-submit">
					<input type="submit" value=" ">
					<i class="listar-hero-search-icon"></i>
				</div>
			</form>
		</div>
		
		<!-- Start Ajax Search -->
		<div class="listar-listing-search-menu-wrapper listar-ajax-search hidden">
			<div class="listar-listing-search-menu-inner">
				<!-- Start Listing Search Menu -->
				<div id="listar-listing-search-menu" class="menu-listing-search-menu-container">
					<ul id="menu-listing-search-menu" class="nav listar-listing-search-menu">
						<li id="menu-item-11051" class="menu-item menu-item-type-custom menu-item-object-custom listar-strong listar-searching-ajax-results-item">
							<a href="#" class="listar-searching-ajax-results icon-home6 menu-item menu-item-type-custom menu-item-object-custom listar-strong">
								<div data-searching="far fa-circle-notch fa-spin" data-not-found="far fa-frown" class="listar-cat-icon listar-strong far fa-circle-notch fa-spin menu-item menu-item-type-custom menu-item-object-custom menu-item-11051"></div>
								<div class="listar-menu-item-title-wrapper">
									<span class="listar-searching-string" data-not-found="<?php esc_attr_e( 'Nothing found', 'listar' ); ?>" data-searching="<?php esc_attr_e( 'Searching results...', 'listar' ); ?>">
										<?php esc_html_e( 'Searching results...', 'listar' ); ?>
									</span>
									<span class="listar-menu-item-description">
										<span class="listar-loading-string" data-not-found="<?php esc_attr_e( 'Try again', 'listar' ); ?>" data-searching="<?php esc_attr_e( 'Loading', 'listar' ); ?>">
											<?php esc_html_e( 'Loading', 'listar' ); ?>
										</span>
									</span>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<!-- End Listing Search Menu -->
			</div>
		</div>
		<!-- End Ajax Search -->
		
		<?php
		$listar_search_menu = wp_nav_menu(
			array(
				'theme_location' => 'listing-search-menu',
				'depth'          => 0,
				'echo'           => false,
				'container'      => 'div',
				'container_id'   => 'listar-listing-search-menu',
				'menu_class'     => 'nav listar-listing-search-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'theme_location' => 'listing-search-menu',
				'walker'         => new Listar_Walker_Nav_Menu(),
				/* Reference: https://wordpress.stackexchange.com/a/82806 */
				'fallback_cb'    => '__return_false', /* Don't output nothing if the menu has 0 items */
			)
		);

		if ( has_nav_menu( 'listing-search-menu' ) && false !== $listar_search_menu ) :
			?>
			<?php
			$show_search_tip = 0 === (int) get_option( 'listar_disable_search_tip' );

			if ( $show_search_tip ) :
				$search_tip_title    = trim( get_option( 'listar_search_tip_title' ) );
				$search_tip_subtitle = trim( get_option( 'listar_search_tip_subtitle' ) );
				$search_tip_icon     = trim( get_option( 'listar_search_tip_icon' ) );
				$has_tip_icon        = 'listar-search-has-tip-icon';

				if ( empty( $search_tip_title ) ) {
					$search_tip_title = esc_html__( 'Need a Hand?', 'listar' );
				}

				if ( '-' !== $search_tip_subtitle ) {
					$search_tip_subtitle = empty( $search_tip_subtitle ) ? esc_html__( 'Click & Browse Highlights...', 'listar' ) : $search_tip_subtitle;
				} else {
					$search_tip_subtitle = '';
				}

				if ( '-' !== $search_tip_icon ) {
					$search_tip_icon = empty( $search_tip_icon ) || ( false === strpos( $search_tip_icon, 'fa fa-' ) && false === strpos( $search_tip_icon, 'icon-' ) ) ? 'icon-hand' : $search_tip_icon;
				} else {
					$search_tip_icon = '';
				}

				if ( empty( $search_tip_icon ) ) {
					$has_tip_icon = 'listar-search-no-tip-icon';
				}
				?>
				<!-- Start Search Tip -->
				<div></div>
				<div class="listar-search-highlight-tip">
					<div class="listar-search-highlight-tip-inner <?php echo esc_attr( listar_sanitize_html_class( $has_tip_icon ) ); ?>">
						<div class="listar-search-highlight-tip-1">
							<?php
							if ( ! empty( $search_tip_icon ) ) :
								?>
								<i class="<?php echo esc_attr( listar_sanitize_html_class( $search_tip_icon ) ); ?>"></i>
								<?php
							endif;
							?>
							<?php echo esc_html( $search_tip_title ); ?>
						</div>
						<?php
						if ( ! empty( $search_tip_subtitle ) ) :
							?>
							<div class="listar-search-highlight-tip-2">
								<?php echo esc_html( $search_tip_subtitle ); ?>
							</div>
							<?php
						endif;
						?>
					</div>
				</div>
				<!-- End Search Tip -->
				<?php
			endif;
			?>
			<div class="listar-listing-search-menu-wrapper listar-is-search-menu hidden">
				<div class="listar-listing-search-menu-inner">
					<!-- Start Listing Search Menu -->
					<?php
					if ( has_nav_menu( 'listing-search-menu' ) ) :

						/* Cleaning for W3C validation */
						echo wp_kses( str_replace( ' />', ' >', str_replace( '<ul/', '<ul', str_replace( 'dropdown-menu', 'nav listar-listing-search-menu', $listar_search_menu ) ) ), 'listar-basic-html' );

					endif;
					?>
					<!-- End Listing Search Menu -->
				</div>
			</div>
			<?php
		endif;
		?>

	</div>
	<!-- End Hero Search -->
	<?php
endif;

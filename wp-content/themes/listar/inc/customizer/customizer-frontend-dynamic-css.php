<?php
/**
 * Dynamic front end CSS, dependent on WordPress Customizer
 *
 * Enqueue dynamic inline CSS to the theme ( Front end ):
 *
 * --- Primary (Body) and Secondary (Headings) font families ( Customize / Google Fonts ).
 * --- Theme Color ( Customize / Colors ).
 *
 * @package Listar
 */

add_action( 'wp_enqueue_scripts', 'listar_frontend_dynamic_css' );

if ( ! function_exists( 'listar_frontend_dynamic_css' ) ) :
	/**
	 * Prepare and enqueue dynamic CSS to front end.
	 *
	 * @since 1.0
	 */
	function listar_frontend_dynamic_css() {
		/*
		 * Primary (Body) and Secondary (Headings) font families *******
		 * See Customize / Google Fonts.
		 */

		/* Primary (Body) font family */

		$primary_google_font = get_theme_mod( 'listar_primary_google_font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,500,700&amp;subset=latin-ext' );
		$primary_google_font_family = str_replace( '+', ' ', listar_get_google_font_family( $primary_google_font ) );

		/* Secondary (Headings) font family */

		$secondary_google_font = get_theme_mod( 'listar_secondary_google_font', 'https://fonts.googleapis.com/css?family=Quicksand:400,500,700&amp;subset=latin-ext' );
		$secondary_google_font_family = str_replace( '+', ' ', listar_get_google_font_family( $secondary_google_font ) );

		/* Bold Secondary (Headings) font? */

		$secondary_google_font_bold = get_theme_mod( 'listar_secondary_google_font_bold', true );
		$bold_string = (bool) $secondary_google_font_bold ? 'font-weight:700;' : 'font-weight:500;';

		$primary_font_css_selectors   = '';
		$secondary_font_css_selectors = '';

		/* Is built in Google Fonts manager (Customizer / Google Fonts) active on Theme Options? */
		if ( listar_google_fonts_active() ) {

			/* Primary font style */

			$primary_font_css_selectors   .= 'body,';
			$primary_font_css_selectors   .= '.leaflet-cluster,';
			$primary_font_css_selectors   .= '.marker-cluster div,';
			$primary_font_css_selectors   .= '.leaflet-pop-category,';
			$primary_font_css_selectors   .= '.leaflet-pop-title,';
			$primary_font_css_selectors   .= '.listar-search-categories .listar-listing-categories a,';
			$primary_font_css_selectors   .= '.leaflet-pop-address,';
			$primary_font_css_selectors   .= '.page-template-front-page .listar-widget-subtitle,';
			$primary_font_css_selectors   .= '.listar-page-subtitle,';
			$primary_font_css_selectors   .= '.listar-listing-amenities-wrapper h5,';
			$primary_font_css_selectors   .= '#reply-title small,';
			$primary_font_css_selectors   .= 'blockquote p cite,.wp-block-quote p cite,.wp-block-quote p footer,';
			$primary_font_css_selectors   .= '.widget li h3,';
			$primary_font_css_selectors   .= 'h3 label,';
			$primary_font_css_selectors   .= '.listar-testimonial-review-text,';
			$primary_font_css_selectors   .= '.listar-listing-amenities-inner a,';
			$primary_font_css_selectors   .= '.single-product .summary.entry-summary .price del .woocommerce-Price-amount.amount,';
			$primary_font_css_selectors   .= '.listar-booking-popup .summary.entry-summary .price del .woocommerce-Price-amount.amount,';
			$primary_font_css_selectors   .= '.listar-panel-form>.panel-heading a,';
			$primary_font_css_selectors   .= '.listar-popup-rating,';
			$primary_font_css_selectors   .= '.listar-listing-rating,';
			$primary_font_css_selectors   .= '.listar-rating-count,';
			$primary_font_css_selectors   .= '.author-avatar ~ .listar-post-by-name .listar-author-name,';
			$primary_font_css_selectors   .= '.button,';
			$primary_font_css_selectors   .= '.listar-woo-product-card .listar-card-content .listar-ribbon,';
			$primary_font_css_selectors   .= '.listar-review-popup .listar-panel-form #reply-title';

			/* Secondary font style */

			$secondary_font_css_selectors .= 'h1,h2,h3,h4,h5,h6,';
			$secondary_font_css_selectors .= '.listar-logo a,';
			$secondary_font_css_selectors .= '.wp-block-cover-text,';
			$secondary_font_css_selectors .= '.listar-author-name,';
			$secondary_font_css_selectors .= '.post-data,';
			$secondary_font_css_selectors .= '.listar-popup-title div,';
			$secondary_font_css_selectors .= '.widget-title,';
			$secondary_font_css_selectors .= '.listar-card-content-title,.entry-content .listar-card-content-title,';
			$secondary_font_css_selectors .= '.listar-term-text,';
			$secondary_font_css_selectors .= '.listar-ribbon,';
			$secondary_font_css_selectors .= '.wcfm_dashboard_item_title,';
			$secondary_font_css_selectors .= '.listar-post-social-share-label,';
			$secondary_font_css_selectors .= '.woocommerce-MyAccount-navigation-link a,';
			$secondary_font_css_selectors .= '.woocommerce-edit-account legend,';
			$secondary_font_css_selectors .= 'label[for*="wc_bookings_field"],';
			$secondary_font_css_selectors .= 'label[for*="wc-bookings"],';
			$secondary_font_css_selectors .= '.wc-bookings-date-picker .label,';
			$secondary_font_css_selectors .= '.single-product .summary.entry-summary p.price,';
			$secondary_font_css_selectors .= '.single-product .summary.entry-summary span.price,';
			$secondary_font_css_selectors .= '.listar-booking-popup .summary.entry-summary p.price,';
			$secondary_font_css_selectors .= '.listar-booking-popup .summary.entry-summary span.price,';
			$secondary_font_css_selectors .= '.ui-datepicker-title,';
			$secondary_font_css_selectors .= '.listar-booking-permalink,';
			$secondary_font_css_selectors .= '.reviews_heading,';
			$secondary_font_css_selectors .= '.rating_number,';
			$secondary_font_css_selectors .= '.user_rated,';
			$secondary_font_css_selectors .= '#wcfmmp-store .tab_area .tab_links li a,';
			$secondary_font_css_selectors .= '#wcfmmp-store .user_name,';
			$secondary_font_css_selectors .= '#wcfmmp-store #wcfm_store_header h1.wcfm_store_title,';
			$secondary_font_css_selectors .= '.woocommerce-ResetPassword.lost_reset_password label,';
			$secondary_font_css_selectors .= '.listar-page-header-content .listar-post-meta-wrapper .posted-on,';
			$secondary_font_css_selectors .= '.listar-feature-item .listar-feature-item-title span,';
			$secondary_font_css_selectors .= '.entry-content table thead tr th,';
			$secondary_font_css_selectors .= '.comment-content table thead tr th,';
			$secondary_font_css_selectors .= '.listar-listing-description-text table thead tr th,';
			$secondary_font_css_selectors .= 'strong, b, .listar-strong,';
			$secondary_font_css_selectors .= '.listar-clean-search-by-filters-button ~ .tooltip .tooltip-inner,.listar-clean-search-input-button ~ .tooltip .tooltip-inner,';
			$secondary_font_css_selectors .= '.wp-block-cover p,.wp-block-cover h2,.wp-block-cover-image p,.wp-block-cover-image h2,';
			$secondary_font_css_selectors .= 'dt,';
			$secondary_font_css_selectors .= '.has-drop-cap:not(:focus)::first-letter,';
			$secondary_font_css_selectors .= '.has-medium-font-size,.has-large-font-size,.has-huge-font-size,';
			$secondary_font_css_selectors .= 'blockquote p,.wp-block-quote p,';
			$secondary_font_css_selectors .= '.listar-package-price,';
			$secondary_font_css_selectors .= '.listar-author-vote,';
			$secondary_font_css_selectors .= '.comment-box .comment-name,';
			$secondary_font_css_selectors .= '#page .comment-author span.is-author,';
			$secondary_font_css_selectors .= '.listar-review-popup .listar-panel-form #reply-title,';
			$secondary_font_css_selectors .= '.listar-term-name-big,';
			$secondary_font_css_selectors .= '.listar-login-welcome,';
			$secondary_font_css_selectors .= '.listar-business-day-letter,';
			$secondary_font_css_selectors .= 'li a.rsswidget,';
			$secondary_font_css_selectors .= '.listar-view-counter span,';
			$secondary_font_css_selectors .= '.woocommerce .product .product_meta > span,';
			$secondary_font_css_selectors .= '.woocommerce-page div.product .woocommerce-tabs ul.tabs li,';
			$secondary_font_css_selectors .= '.listar-grid-design-image-block .listar-card-category-name,';
			$secondary_font_css_selectors .= '.tooltip-inner,';
			$secondary_font_css_selectors .= '.listar-sale-price,';
			$secondary_font_css_selectors .= '.single-product .summary.entry-summary .price .woocommerce-Price-amount.amount,';
			$secondary_font_css_selectors .= '.listar-booking-popup .summary.entry-summary .price .woocommerce-Price-amount.amount,';
			$secondary_font_css_selectors .= '#calendar_wrap>table>caption,';
			$secondary_font_css_selectors .= 'article caption,';
			$secondary_font_css_selectors .= '#comments caption,';
			$secondary_font_css_selectors .= '#calendar_wrap caption,';
			$secondary_font_css_selectors .= '#secondary caption,';
			$secondary_font_css_selectors .= '.listar-package-description .woocommerce-Price-amount.amount,';
			$secondary_font_css_selectors .= 'article thead,';
			$secondary_font_css_selectors .= '.listar-listing-search-input-field,';
			$secondary_font_css_selectors .= '.listar-listing-search-menu li a,';
			$secondary_font_css_selectors .= '#comments thead,';
			$secondary_font_css_selectors .= '#calendar_wrap thead,';
			$secondary_font_css_selectors .= '#secondary thead,';
			$secondary_font_css_selectors .= 'article tbody th,';
			$secondary_font_css_selectors .= '#comments tbody th,';
			$secondary_font_css_selectors .= '#calendar_wrap tbody th,';
			$secondary_font_css_selectors .= '#secondary tbody th,';
			$secondary_font_css_selectors .= 'article tfoot,';
			$secondary_font_css_selectors .= '#comments tfoot,';
			$secondary_font_css_selectors .= '#calendar_wrap tfoot,';
			$secondary_font_css_selectors .= '#secondary tfoot,';
			$secondary_font_css_selectors .= '.listar-pricing-menu-items .nav-tabs>li>a,';
			$secondary_font_css_selectors .= '.listar-price-item-tag-label,';
			$secondary_font_css_selectors .= '.listar-pricing-item .listar-price-item-title,';
			$secondary_font_css_selectors .= '.listar-header-more-info,';
			$secondary_font_css_selectors .= '.listar-price-item-price-value,';
			$secondary_font_css_selectors .= '.listar-search-regions .listar-regions-list a.current,';
			$secondary_font_css_selectors .= 'span.lsl-login-new-text,';
			$secondary_font_css_selectors .= '.listar-login-form-link,';
			$secondary_font_css_selectors .= '.listar-register-form-link,';
			$secondary_font_css_selectors .= '.listar-is-desktop.listar-ready-for-hover.listar_expansive_excerpt.listar-card-detail-row-default .listar-card-content .listar-listing-address,';
			$secondary_font_css_selectors .= '.listar-references-distance-metering,';
			$secondary_font_css_selectors .= '.listar-card-geolocated-distance,';
			$secondary_font_css_selectors .= '.comment-awaiting-moderation.label-info,';
			$secondary_font_css_selectors .= '.listar-pricing-packages-v2 .listar-package-subtitle p,';
			$secondary_font_css_selectors .= '.listar-listing-price-range-title,';
			$secondary_font_css_selectors .= '.listar-listing-average-rating,';
			$secondary_font_css_selectors .= '.job-manager-jobs .job_title > a';
		
		/* Search tip mobile */
		
		}// End if().

		/*
		 * Theme Color *************************************************
		 * See Customize / Colors
		 */

		$theme_color = listar_convert_hex_to_rgb( listar_theme_color() );

		$theme_color_css = '';

		$theme_color_css .= '
			h1 strong,
			h2 strong,
			h3 strong,
			h4 strong,
			h5 strong,
			h6 strong {
				color: rgb(' . $theme_color . ');
			}

			a,
			a:hover,
			a:focus {
				color: rgb(' . $theme_color . ');
			}

			.listar-color-design {
				box-shadow: 0 10000px rgb(' . $theme_color . ') inset;
				background-color: rgb(' . $theme_color . ');
			}

			.listar-color-text-bg {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-img-left.listar-image-with-icon:after {
				box-shadow: 0 10000px rgba(' . $theme_color . ',0.6) inset;
			}

			article table caption,
			#comments table caption,
			body #calendar_wrap>table>caption,
			.wp-block-table caption,
			#wp-calendar caption {
				background-color: rgb(' . $theme_color . ');
			}

			samp {
				color: rgb(' . $theme_color . ');
			}

			.listar-more-info-links a:hover {
			        color: rgb(' . $theme_color . ');
			}

			.listar-pricing-menu-items .listar-price-list-wrapper > li.listar-pricing-item.listar-item-has-tag:after {
				border: 6px solid rgb(' . $theme_color . ');
			}

			.listar-price-item-tag-label {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-price-item-price-value {
				color: rgb(' . $theme_color . ');
			}

			.site-header {
				background-color: rgb(' . $theme_color . ');
			}

			#page .listar-hero-section-title h1 span span {
				color: rgb(' . $theme_color . ');
			}

			.site-header.listar-light-design .listar-header-search-button {
				color: rgb(' . $theme_color . ');
			}

			.nav:not( .listar-footer-menu ):not( .primary-menu ) > li > a:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-listing-search-menu li > a:hover .listar-menu-item-description {
				border: 3px solid rgb(' . $theme_color . ');
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-search-menu a:hover,
			.listar-listing-search-menu a:focus {
				color: rgb(' . $theme_color . ');
			}

			.listar-light-design #site-navigation .navbar-toggle > .icon-bar,
			#site-navigation .navbar-toggle.listar-primary-navbar-mobile-visible .icon-bar {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-full-dimming-overlay {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-term-background-overlay {
				background-color: rgb(' . $theme_color . ');
				box-shadow: 5px 5px rgb(' . $theme_color . ');
			}

			.listar-hero-header.listar-color-design .listar-hero-header-overlay {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-theme-color-stripes .listar-hero-search:after {
				background: rgb(' . $theme_color . ');
			}

			.listar-search-by-tip {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-search-by-button:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-search-by-custom-location-data-countries-select .listar-edit-nearest-me:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-search-by-popup .listar-search-by-options .listar-search-by-options-wrapper a:hover,
			.listar-search-by-popup .listar-search-by-options .listar-search-by-options-wrapper a:hover h4 {
				color: rgb(' . $theme_color . ');
			}

			.listar-search-submit:hover .listar-hero-search-icon {
				color: rgb(' . $theme_color . ');
			}

			.listar-light-design .listar-search-categories .listar-listing-categories a {
				color: rgb(' . $theme_color . ');
			}

			.listar-category-icon-box {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-light-design .listar-search-categories .listar-listing-categories span svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-search-categories .listar-more-categories:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-nav-regions:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-search-regions .listar-regions-list a.current:hover span,
			#page .listar-search-regions .listar-regions-list a.current:hover span {
				color: rgb(' . $theme_color . ');
			}

			.listar-show-regions:hover:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-hero-header.listar-color-design .listar-hero-header-overlay {
				background-color: rgb(' . $theme_color . ');
			}

			body .button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.wp-block-button__link,
			.woocommerce #respond input#submit:hover,
			.woocommerce a.button:hover,
			.woocommerce button.button:hover,
			.woocommerce input.button:hover,
			.woocommerce button.button.disabled {
				background-color: rgb(' . $theme_color . ');
			}

			body .button.listar-hover-light:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-call-to-action-button .listar-color-button:hover {
				background-color: rgba(' . $theme_color . ',0.7);
			}

			body .button.listar-light-button:hover,
			body.listar-is-safari.listar-is-mobile .button.listar-light-button:hover {
				background-color: rgb(' . $theme_color . ');
			}

			body .button.listar-grey-button:hover {
				background-color: rgb(' . $theme_color . ');
			}

			body form input[type="submit"],
			body .woocommerce #respond input#submit,
			body .woocommerce a.button,
			body .woocommerce button.button,
			body .woocommerce input.button,
			body .woocommerce #respond input#submit:hover,
			body .woocommerce a.button:hover,
			body .woocommerce button.button:hover,
			body .woocommerce input.button:hover,
			body .woocommerce button.button:disabled,
			body .woocommerce button.button:disabled[disabled],
			body .woocommerce button.button:disabled:hover,
			body .woocommerce button.button:disabled[disabled]:hover,
			#add_payment_method .wc-proceed-to-checkout a.checkout-button,
			.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
			.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button {
				background-color: rgb(' . $theme_color . ');
			}

			.woocommerce table.my_account_orders .woocommerce-orders-table__cell .button {
				color: rgb(' . $theme_color . ');
			}

			.listar-light-design .listar-add-listing-btn,
			.listar-user-not-logged .site-header.listar-light-design .listar-user-login {
				background-color: rgb(' . $theme_color . ');
			}

			.site-header.listar-transparent-design .listar-add-listing-btn:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.site-header.listar-transparent-design .listar-user-login:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.btn-info {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-back-to-top {
				color: rgb(' . $theme_color . ');
			}

			.listar-back-to-top:hover {
				background: rgb(' . $theme_color . ');
			}

			.listar-separator-line {
				border-top: 1px solid rgba(' . $theme_color . ',0.4);
			}

			.listar-separator-line-dashed {
				border-top: 1px dashed rgb(' . $theme_color . ');
			}

			.listar-logged-user-menu-wrapper li.listar-logged-user-name:hover,
			.listar-logged-user-menu-wrapper li.listar-logged-user-name {
				color: rgb(' . $theme_color . ');
			}

			.listar-logged-user-menu-wrapper li a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-logged-user-menu-wrapper li:hover {
				border-left: 3px solid rgb(' . $theme_color . ');
			}

			.listar-page-header.listar-color-cover {
				box-shadow: 0 10000px rgb(' . $theme_color . ') inset;
			}

			.listar-about-item {
				border-bottom: 1px dashed rgb(' . $theme_color . ');
			}

			.single-job_listing #page header .edit-link a span,
			.single-job_listing header .edit-link a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-theme-color-stripes .listar-title-with-stripe:after {
				background: -moz-linear-gradient(left, rgba(' . $theme_color . ',0.7) 0%, rgba(' . $theme_color . ',0.7) 19.9%, rgba(' . $theme_color . ',1) 20%, rgba(' . $theme_color . ',1) 39.9%, rgba(' . $theme_color . ',0.7) 40%, rgba(' . $theme_color . ',0.7) 59.9%, rgba(' . $theme_color . ',1) 60%, rgba(' . $theme_color . ',1) 79.9%, rgba(' . $theme_color . ',0.7) 80%, rgba(' . $theme_color . ',0.7) 100%);
				background: -webkit-gradient(left top, right top, color-stop(0%, rgba(' . $theme_color . ',0.7)), color-stop(19.9%, rgba(' . $theme_color . ',0.7)), color-stop(20%, rgba(' . $theme_color . ',1)), color-stop(39.9%, rgba(' . $theme_color . ',1)), color-stop(40%, rgba(' . $theme_color . ',0.7)), color-stop(59.9%, rgba(' . $theme_color . ',0.7)), color-stop(60%, rgba(' . $theme_color . ',1)), color-stop(79.9%, rgba(' . $theme_color . ',1)), color-stop(80%, rgba(' . $theme_color . ',0.7)), color-stop(100%, rgba(' . $theme_color . ',0.7)));
				background: -webkit-linear-gradient(left, rgba(' . $theme_color . ',0.7) 0%, rgba(' . $theme_color . ',0.7) 19.9%, rgba(' . $theme_color . ',1) 20%, rgba(' . $theme_color . ',1) 39.9%, rgba(' . $theme_color . ',0.7) 40%, rgba(' . $theme_color . ',0.7) 59.9%, rgba(' . $theme_color . ',1) 60%, rgba(' . $theme_color . ',1) 79.9%, rgba(' . $theme_color . ',0.7) 80%, rgba(' . $theme_color . ',0.7) 100%);
				background: -o-linear-gradient(left, rgba(' . $theme_color . ',0.7) 0%, rgba(' . $theme_color . ',0.7) 19.9%, rgba(' . $theme_color . ',1) 20%, rgba(' . $theme_color . ',1) 39.9%, rgba(' . $theme_color . ',0.7) 40%, rgba(' . $theme_color . ',0.7) 59.9%, rgba(' . $theme_color . ',1) 60%, rgba(' . $theme_color . ',1) 79.9%, rgba(' . $theme_color . ',0.7) 80%, rgba(' . $theme_color . ',0.7) 100%);
				background: -ms-linear-gradient(left, rgba(' . $theme_color . ',0.7) 0%, rgba(' . $theme_color . ',0.7) 19.9%, rgba(' . $theme_color . ',1) 20%, rgba(' . $theme_color . ',1) 39.9%, rgba(' . $theme_color . ',0.7) 40%, rgba(' . $theme_color . ',0.7) 59.9%, rgba(' . $theme_color . ',1) 60%, rgba(' . $theme_color . ',1) 79.9%, rgba(' . $theme_color . ',0.7) 80%, rgba(' . $theme_color . ',0.7) 100%);
				background: linear-gradient(to right, rgba(' . $theme_color . ',0.7) 0%, rgba(' . $theme_color . ',0.7) 19.9%, rgba(' . $theme_color . ',1) 20%, rgba(' . $theme_color . ',1) 39.9%, rgba(' . $theme_color . ',0.7) 40%, rgba(' . $theme_color . ',0.7) 59.9%, rgba(' . $theme_color . ',1) 60%, rgba(' . $theme_color . ',1) 79.9%, rgba(' . $theme_color . ',0.7) 80%, rgba(' . $theme_color . ',0.7) 100%);
			}

			.listar-posts-column .listar-column-toggle-visibility {
				color: rgb(' . $theme_color . ');
			}

			.listar-light-design .listar-posts-column .listar-column-toggle-visibility {
				color: rgb(' . $theme_color . ');
			}

			.listar-aside-post .listar-aside-post-icon {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-aside-post-rating {
				color: rgb(' . $theme_color . ');
			}

			.listar-aside-post a:hover .listar-aside-post-pic {
				box-shadow: 0 10000px rgb(' . $theme_color . ') inset;
			}

			.listar-is-desktop.listar-spiral-effect .listar-aside-post a:hover .listar-aside-post-pic {
			    box-shadow: 0 10000px rgba(' . $theme_color . ',0.9) inset;
			}

			.listar-aside-post-title {
				color: rgb(' . $theme_color . ');
			}

			.listar-references-navigation:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-aside-post-category ~ .listar-aside-post-region:before,
			.listar-card-category-name a ~ a:before,
			.listar-search-query:before,
			.listar-map-button-content a:before,
			.leaflet-pop-address span:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-aside-post a .listar-single-listing-link:before,
			.listar-aside-post a .listar-show-map-popup:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-aside-post a:hover .listar-show-map-popup:before,
			.listar-aside-post a:hover .listar-single-listing-link:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-close-aside-listings {
				color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-close-aside-listings:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-page-header-with-map {
				color: rgb(' . $theme_color . ');
			}

			.listar-current-page-info.listar-color-cover {
				box-shadow: 0 10000px rgb(' . $theme_color . ') inset;
			}

			.listar-no-image .listar-current-page-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-listing-flag {
				color: rgb(' . $theme_color . ');
			}

			.listar-map-button-text {
				color: rgb(' . $theme_color . ');
			}

			#page .listar-page-header-content .listar-map-button.disabled .listar-map-button-text span,
			#page .listar-page-header-content .listar-map-button.disabled:hover .listar-map-button-text span {
				color: rgb(' . $theme_color . ');
			}

			.disabled .listar-map-button-text:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-map-button.hover {
				color: rgb(' . $theme_color . ');
			}

			#map.listar-color-design {
				background-color: rgb(' . $theme_color . ');
			}

			.leaflet-control a,
			.leaflet-control a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-popup-rating {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-container a.leaflet-popup-close-button,
			.leaflet-popup-coordinate-icon:before {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-container a.leaflet-popup-close-button:before {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-container a.leaflet-popup-close-button {
				color: rgba(' . $theme_color . ',0);
			}

			body .leaflet-popup-coordinates:hover {
				color: rgb(' . $theme_color . ');
			}

			body .leaflet-popup-coordinates:hover * {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-pop-title {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-div-icon {
				background-color: rgb(' . $theme_color . ');
			}

			.leaflet-marker-pin {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-more-map-listing {
				color: rgb(' . $theme_color . ');
			}

			.listar-more-map-listing {
				color: rgb(' . $theme_color . ');
			}

			.listar-map-launch-wrapper .button.listar-color-button:after {
				border: 12px solid rgba(' . $theme_color . ',0.9);
			}

			.leaflet-cluster {
				color: rgb(' . $theme_color . ');
			}

			.leaflet-overlay-pane path {
				stroke: rgb(' . $theme_color . ');
				fill: rgb(' . $theme_color . ');
			}

			body .listar-card-link:hover ~ .listar-fallback-content .button.listar-light-button {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-post-edit-link-card:hover {
				background-color: rgb(' . $theme_color . ');
				color: #fff
			}

			.listar-card-content .listar-card-content-date,
			.listar-card-content:hover .listar-card-content-date {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-date-design-2 .listar-card-content-date:after {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-full .listar-card-content .listar-date-design-2 .listar-card-content-date {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-content.listar-color-cover .listar-card-content-image .listar-card-image-inner img,
			.listar-card-content.listar-color-cover .listar-card-content-image .listar-card-content-title-centralizer ~ img,
			.widget_recent_entries .listar-post-item.listar-color-cover img {
				background-color: rgb(' . $theme_color . ');
			}

			.hide-border-circles .listar-card-content .listar-card-content-image .listar-card-image-inner img,
			.hide-border-circles .listar-card-content .listar-card-content-image .listar-card-content-title-centralizer ~ img,
			.listar-card-content.listar-no-image:hover .listar-card-content-image,
			.listar-grid.listar-white-design .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-image-inner img,
			.listar-grid.listar-white-design .listar-card-content.sticky.listar-no-image .listar-card-content-image .listar-card-image-inner img,
			.listar-grid.listar-white-design .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-content-title-centralizer ~ img,
			.listar-grid.listar-white-design .listar-card-content.sticky.listar-no-image .listar-card-content-image .listar-card-content-title-centralizer ~ img {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-grid-design-2 .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-image-inner img,
			.listar-is-desktop .listar-grid.listar-white-design .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-image-inner img,
			.listar-is-desktop .listar-grid-design-2 .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-content-title-centralizer ~ img,
			.listar-is-desktop .listar-grid.listar-white-design .listar-card-content.listar-no-image:hover .listar-card-content-image .listar-card-content-title-centralizer ~ img {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-listing-rating {
				color: rgb(' . $theme_color . ');
			}

			.listar-toggle-fixed-quick-menu-wrapper a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-listing-header-topbar-item a:hover .listar-listing-header-topbar-icon,
			.listar-is-desktop .listar-listing-header-topbar-item a:hover .listar-listing-rating {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-listing-header-stars-button .listar-no-rating:after {
				border-bottom: 2px solid rgba(' . $theme_color . ',0.82);
			}

			.listar-no-rating:after {
				border-bottom: 2px solid rgba(' . $theme_color . ',0.5);
			}

			.listar-aside-post .listar-listing-rating,
			.listar-testimonial-review-average {
				color: rgb(' . $theme_color . ');
			}

			.listar-card-content:hover .listar-card-content-image:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-ribbon,
			.single-product .summary.entry-summary .price .woocommerce-Price-amount.amount,
			.listar-booking-popup .summary.entry-summary .price .woocommerce-Price-amount.amount {
				color: rgb(' . $theme_color . ');
			}

			.single-product .summary.entry-summary .price .woocommerce-Price-amount.amount.listar-ribbon,
			.listar-booking-popup .summary.entry-summary .price .woocommerce-Price-amount.amount.listar-ribbon {
				background-color: rgb(' . $theme_color . ');
			}

			.single-product .summary.entry-summary .price .woocommerce-Price-amount.amount.listar-ribbon:after,
			.listar-booking-popup .summary.entry-summary .price .woocommerce-Price-amount.amount.listar-ribbon:after {
				border-top-color: rgb(' . $theme_color . ');
				border-bottom-color: rgb(' . $theme_color . ');
			}

			.listar-featured-listing-terms a:hover .listar-ribbon,
			.listar-featured-listing-regions .listar-term-link:hover .listar-ribbon {
				color: rgb(' . $theme_color . ');
			}

			.listar-ribbon.listar-detail-ribbon {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-content.listar-no-image .listar-ribbon {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-content.listar-no-image .listar-ribbon:before,
			.listar-card-content.listar-no-image .listar-ribbon:after {
				border-top-color: rgb(' . $theme_color . ');
				border-bottom-color: rgb(' . $theme_color . ');
			}

			.listar-card-content.listar-no-image:hover .listar-card-content-image .listar-ribbon {
				color: rgb(' . $theme_color . ');
			}

			.listar-aside-post .listar-ribbon,
			.leaflet-popup .listar-ribbon {
				color: rgb(' . $theme_color . ');
			}

			.listar-card-content .listar-category-icon:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-fill-background.listar-light-design .listar-card-content .listar-category-icon {
				color: rgb(' . $theme_color . ');
			}

			.listar-fill-background .listar-card-content .listar-category-icon:hover:before,
			.listar-fill-background.listar-light-design .listar-card-content .listar-category-icon:hover:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-fill-background.listar-light-design .listar-card-content .listar-category-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-card-content .listar-card-data-arrow-before:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop.listar-ready-for-hover.listar_expansive_excerpt .listar-card-content:hover .listar-listing-address {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-read-more-link:hover span {
				color: rgb(' . $theme_color . ');
			}

			.listar-card-category-name a {
				color: rgb(' . $theme_color . ');
			}

			.listar-grid.listar-white-design .listar-card-category-name a {
				color: rgb(' . $theme_color . ');
			}

			.listar-term-counter {
				color: rgb(' . $theme_color . ');
			}

			.listar-counters-design-1 .listar-term-counter {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-more-sharing-networks-button:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-listing-data a.listar-whatsapp-number-active,
			.listar-listing-data a.listar-callable-phone-number-active,
			.listar-listing-data a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-page-header-icon {
				color: rgba(' . $theme_color . ',0.85);
			}

			.listar-page-header-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-grid.listar-grid2 .listar-card-content-title,
			.listar-grid.listar-grid3 .listar-card-content-title {
				color: rgb(' . $theme_color . ');
			}

			.listar-grid.listar-grid6 .listar-card-content-title {
				color: rgb(' . $theme_color . ');
			}

			.listar-grid-icon {
				color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-grid-icon:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-search-query span {
				color: rgb(' . $theme_color . ');
			}

			#page .dropdown-header span {
				color: rgb(' . $theme_color . ');
			}

			.open>.dropdown-toggle.btn-default,
			.open>.dropdown-toggle.btn-default:hover,
			.open>.dropdown-toggle.btn-default:focus {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-dark-pricing-table .listar-featured-package .listar-package-content-inner,
			.listar-dark-pricing-table .listar-no-featured-package .listar-package-content:hover .listar-package-content-inner {
				background: rgb(' . $theme_color . ');
			}

			.listar-pricing-table .listar-listing-package .listar-package-content:hover .listar-package-title h4,
			.listar-pricing-table .listar-listing-package .listar-package-content:hover .listar-pricing-circle .listar-package-price,
			.listar-dark-pricing-table .listar-pricing-table .listar-listing-package.listar-featured-package .listar-package-title h4 {
				color: rgb(' . $theme_color . ');
			}

			.listar-pricing-table .listar-listing-package .listar-package-content:hover .listar-package-subtitle,
			.listar-pricing-packages-v2 .listar-dark-pricing-table .listar-pricing-table .listar-listing-package .listar-package-content:hover .listar-package-subtitle {
				color: rgb(' . $theme_color . ');
			}

			.listar-dark-pricing-table .listar-featured-package .listar-package-content .listar-package-price .listar-newer-price-currency {
				color: rgb(' . $theme_color . ');
			}

			.listar-dark-pricing-table .listar-package-content:hover .listar-package-price .listar-newer-price-currency {
				color: rgb(' . $theme_color . ');
			}

			.listar-pricing-table .listar-listing-package.listar-featured-package .listar-pricing-circle {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-dark-pricing-table .listar-pricing-table .listar-listing-package.listar-featured-package .listar-package-price {
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-package.listar-no-feat .listar-iconized-button.listar-incolor-button:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-dark-pricing-table .listar-featured-package .listar-package-description p:before,
			.listar-dark-pricing-table .listar-listing-package .listar-package-content:hover .listar-package-description p:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-pricing-table .listar-listing-package .listar-package-content:hover .button {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-pricing-packages-v2 .listar-featured-package .listar-pricing-package-image {
				border-bottom: 2px dashed rgb(' . $theme_color . ');
			}

			.listar-pricing-packages-v2 .listar-dark-pricing-table .listar-pricing-table .listar-listing-package.listar-featured-package .listar-package-content .listar-package-subtitle {
				color: rgb(' . $theme_color . ');
			}

			.listar-pricing-packages-v2 .listar-dark-pricing-table .listar-pricing-table .listar-listing-package.listar-featured-package  .listar-package-price:before {
				border: 2px dashed rgb(' . $theme_color . ');
			}

			.listar-pricing-packages-v2 .listar-dark-pricing-table .listar-pricing-table .listar-listing-package.listar-featured-package .listar-package-content:before {
				border: 2px dashed rgb(' . $theme_color . ');
			}

			.listar-featured-blog-icon {
				border-right: 1px dashed rgb(' . $theme_color . ');
			}

			.listar-featured-blog-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.sticky .listar-sticky-border {
				border: 11px solid rgb(' . $theme_color . ');
			}

			.post-data {
				color: rgb(' . $theme_color . ');
			}

			.posts-navigation a:hover,
			.navigation a.page-numbers:hover,
			.listar-more-results:hover,
			.listar-page-links a:hover span {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-post-social-share ul li a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-comments-container h1 {
				color: rgb(' . $theme_color . ');
			}

			.listar-current-user-rating:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-current-user-rating:after {
				color: rgb(' . $theme_color . ');
			}

			.comment-box .comment-header i:hover {
				color: rgb(' . $theme_color . ');
			}

			.comment-box .comment-name a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-light-comments #respond .logged-in-as a:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-amenities-wrapper h5 {
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-amenities-inner a.listar-amenity-mobile:hover,
			.tags a:hover,
			.tagcloud a:hover {
				border: 1px solid rgba(' . $theme_color . ',0.5);
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-amenities-inner a.listar-amenity-mobile:before,
			#page .listar-listing-amenities-inner span:before,
			.tags a:before,
			.tagcloud a:before,
			.listar-card-content-data li:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-amenities-inner a.listar-amenity-mobile svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-panel-form>.panel-heading {
				color: rgb(' . $theme_color . ');
			}

			.listar-panel-form>.panel-heading a:hover,
			.listar-panel-form>.panel-heading a.active,
			.listar-reset-pass-button:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-login-button,
			.listar-login-button:hover,
			.listar-login-button:focus,
			.submit-button,
			.submit-button:hover,
			.submit-button:focus {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-panel-form-wrapper > .listar-panel-form:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-login-register-form .listar-panel-form-wrapper > .listar-panel-form:before {
				background-color: rgb(' . $theme_color . ');
			}

			.submit {
				background-color: rgb(' . $theme_color . ');
			}

			.submit:active,
			.submit:visited,
			.submit:focus,
			.submit:active:focus,
			.submit:link {
				background-color: rgba(' . $theme_color . ',0.8);
			}

			.btn-warning:active:focus {
				background-color: rgba(' . $theme_color . ',0.8);
			}

			.submit:hover,
			.submit:focus {
				background-color: rgba(' . $theme_color . ',0.8);
			}

			.input-group-addon,
			.input-group .form-control {
				color: rgb(' . $theme_color . ');
			}

			.listar-user-avatar {
				background-color: rgba(' . $theme_color . ',0.5);
			}

			.listar-verified-data:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-page-user h3 {
				border-bottom: 1px dashed rgb(' . $theme_color . ');
			}

			.listar-user-name:before,
			.listar-user-about:before,
			.listar-user-message:before,
			.listar-user-social:before {
				background-color: rgb(' . $theme_color . ');
			}

			li a.rsswidget:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget_rss .widget-title a.rsswidget:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget_recent_comments li .comment-author-link:before,
			.wp-block-latest-comments__comment-author:before {
				color: rgb(' . $theme_color . ');
			}

			.widget_recent_entries a:hover .listar-post-item img {
				box-shadow:
					1000px 0 rgba(0,0,0,0.2) inset,
					2px 0 15px rgba(0,0,0,0.6),
					30px 0 rgb(' . $theme_color . ');
			}

			.widget_archive li a:before,
			.wp-block-archives li a:before {
				color: rgb(' . $theme_color . ');
			}

			.widget_product_categories a:hover,
			.listar-widget-page-link a:hover,
			.wp-block-archives li a:hover,
			.wp-block-categories li a:hover,
			.wp-block-latest-posts li a:hover,
			.widget_recent_comments li a:hover,
			.wp-block-latest-comments__comment-meta a:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget.widget_categories li:hover .icon,
			.widget .listar-widget-content .listar-post-item a:hover .icon,
			.widget.widget_archive li:hover .icon {
				color: rgb(' . $theme_color . ');
			}

			.widget.widget_categories a:hover,
			.widget .listar-widget-content .listar-post-item a:hover,
			.widget.widget_archive a:hover,
			.widget_meta a:hover,
			.widget_pages a:hover,
			.widget_nav_menu a:hover,
			.widget_rss a:hover,
			.widget_product_categories a:hover,
			.listar-widget-page-link a:hover,
			.widget_recent_comments li a:hover,
			.wp-block-latest-comments__comment-meta a:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget .listar-news-search .listar-widget-content:hover .listar-search-submit {
				color: rgb(' . $theme_color . ');
			}

			.widget_recent_entries a:hover .listar-post-title-wrapper .post-title {
				color: rgb(' . $theme_color . ');
			}

			.listar-page-links > .page-number {
				color: rgb(' . $theme_color . ');
			}

			.widget select:hover,
			.widget select:focus,
			.wp-block-archives-dropdown select:hover,
			.wp-block-archives-dropdown select:focus,
			.wp-block-categories select:hover,
			.wp-block-categories select:focus {
				background-image: url("data:image/svg+xml;utf8,<svg fill=\'rgb(' . $theme_color . ')\' style=\'position:relative;right:5px;top:3px;\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/><path d=\'M0 0h24v24H0z\' fill=\'none\'/></svg>");
			}

			.widget_product_search form:hover button:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-sidebar-right .listar-widget-page-link a:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget_nav_menu .dropdown-menu>li>a:focus,
			.widget_nav_menu .dropdown-menu>li>a:hover,
			.listar-drop-down-menu-color .widget_nav_menu .dropdown-menu>li>a:focus,
			.listar-drop-down-menu-color .widget_nav_menu .dropdown-menu>li>a:hover {
				color: rgb(' . $theme_color . ');
			}

			.widget_listar_call_to_action .listar-color-design {
				box-shadow:
					0 0 100px rgba(0,0,0,0.1) inset,
					0 10000px rgb(' . $theme_color . ') inset;
			}

			.listar-testimonial-avatar:hover .listar-testimonial-avatar-inner:after,
			.listar-testimonial-avatar.current .listar-testimonial-avatar-inner:after {
				border: 12px solid rgb(' . $theme_color . ');
			}

			.listar-testimonial-avatar:hover .listar-testimonial-review-average,
			.listar-testimonial-avatar.current .listar-testimonial-review-average {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-testimonial-review-text-inner {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-featured-listing-terms-icon {
				border-right: 1px dashed rgb(' . $theme_color . ');
			}

			.listar-featured-listing-terms-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .owl-carousel .owl-nav button.owl-prev:hover:before,
			.listar-is-desktop .owl-carousel .owl-nav button.owl-next:hover:before {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-cat-icon,
			.listar-taxonomy-terms-design-squared .owl-item .listar-cat-icon {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-featured-listing-term-item a:hover ~ .listar-term-inner .listar-cat-icon,
			.listar-featured-listing-term-item a:hover ~ .listar-term-3d-effect-wrapper .listar-cat-icon,
			.listar-featured-listing-term-item a:hover ~ .listar-term-inner .listar-cat-icon.listar-dark-design {
				background-color: rgb(' . $theme_color . ');
			}

			#page .listar-featured-listing-term-item a:hover ~ .listar-category-counter span {
				color: rgb(' . $theme_color . ');
			}

			.listar-regions a:hover .listar-ribbon {
				color: rgb(' . $theme_color . ');
			}

			.listar-region-listings {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-feature-icon svg * {
				fill: rgb(' . $theme_color . ');
			}

			.listar-feature-right-border:before,
			.listar-hovering-features .listar-feature-item a:hover ~ .listar-feature-item-inner .listar-feature-right-border:before,
			.listar-hovering-features-grey .listar-feature-item a:hover ~ .listar-feature-item-inner .listar-feature-right-border:before {
				border: 11px solid rgb(' . $theme_color . ');
			}

			.listar-feature-item img,
			.listar-feature-item i {
				color: rgb(' . $theme_color . ');
			}

			.listar-feature-item i svg * {
				fill: rgb(' . $theme_color . ');
			}

			.widget .listar-color-design .listar-site-features .listar-feature-item a:hover ~ .listar-feature-item-inner .listar-feature-item-title span {
				color: rgb(' . $theme_color . ');
			}

			.listar-features-design-2  .listar-feature-item.listar-feature-has-link a:hover ~ .listar-feature-item-inner .listar-feature-item-title span {
				color: rgb(' . $theme_color . ');
			}

			.listar-features-design-2  .listar-feature-item.listar-feature-has-link a:hover ~ .listar-feature-item-inner:after {
				background-color: rgb(' . $theme_color . ');
			}

			.widget .listar-color-design .listar-feature-item.listar-feature-has-link .listar-feature-item-inner:after {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-average-review {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-mood-icon {
				color: rgb(' . $theme_color . ');
			}

			.listar-listing-header-stars .listar-mood-icon {
				color: rgb(' . $theme_color . ');
			}

			#page .wpjmr-list-reviews .stars-rating span,
			#page #wpjmr-list-reviews .stars-rating span,
			#page .listar-list-reviews .stars-rating span,
			#page #listar-list-reviews .stars-rating span {
				color: rgb(' . $theme_color . ');
			}

			#wpjmr-submit-ratings .star-rating .dashicons-star-filled,
			.wpjmr-list-reviews .star-rating .dashicons-star-filled,
			#wpjmr-list-reviews .star-rating .dashicons-star-filled,
			#listar-submit-ratings .star-rating .dashicons-star-filled,
			.listar-list-reviews .star-rating .dashicons-star-filled,
			#listar-list-reviews .star-rating .dashicons-star-filled {
				color: rgb(' . $theme_color . ');
			}

			.listar-review-reputation div:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-search-by-tip:before,
			.listar-current-search-by:before {
				color: rgb(' . $theme_color . ');
			}

			.listar-author-vote-mood {
				color: rgb(' . $theme_color . ');
			}

			.listar-author-vote {
				background-color: rgb(' . $theme_color . ');
			}

			.star-rating > fieldset:not(:checked) > label {
				color: rgba(' . $theme_color . ',0.8);
			}

			.star-rating > fieldset:not(:checked) > label:hover,
			.star-rating > fieldset:not(:checked) > label:hover ~ label {
				color: rgb(' . $theme_color . ');
				text-shadow: 0 0 3px rgb(' . $theme_color . ');
			}

			.listar-review-popup .listar-panel-form #reply-title,
			.listar-social-share-popup h3 {
				color: rgb(' . $theme_color . ');
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected=false] {
				background-color: rgb(' . $theme_color . ');
			}

			.select2-container--default [aria-multiselectable=true] .select2-results__option[aria-selected=true]:after {
				color: rgba(' . $theme_color . ',0.4);
			}

			.select2-container--default .select2-results__option[aria-selected=true]:hover:after {
				color: rgba(' . $theme_color . ',0.6);
			}

			.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
				color: rgb(' . $theme_color . ');
			}

			.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
				color: rgb(' . $theme_color . ');
			}

			#wpjmr-submit-ratings .choose-rating .star:hover,
			#wpjmr-submit-ratings .choose-rating .star:hover ~ .star,
			#wpjmr-submit-ratings .choose-rating .star.active,
			#wpjmr-submit-ratings .choose-rating .star.active ~ .star,
			#listar-submit-ratings .choose-rating .star:hover,
			#listar-submit-ratings .choose-rating .star:hover ~ .star,
			#listar-submit-ratings .choose-rating .star.active,
			#listar-submit-ratings .choose-rating .star.active ~ .star,
			.listar-review-popup .choose-rating span {
				color: rgb(' . $theme_color . ');
			}

			.listar-required-listing-field-asterisk {
				color: rgb(' . $theme_color . ');
			}

			.listar-copy-day-button ~ .tooltip.top .tooltip-arrow,
			.listar-multiple-hours-buttons a ~ .tooltip.top .tooltip-arrow {
				border-top-color: rgb(' . $theme_color . ');
			}

			.listar-copy-day-button ~ .tooltip.top .tooltip-inner,
			.listar-multiple-hours-buttons a ~ .tooltip.top .tooltip-inner {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-show-more-social,
			.listar-show-hours-table {
				color: rgb(' . $theme_color . ');
			}

			#customer_details label {
				color: rgb(' . $theme_color . ');
			}

			.woocommerce #respond input#submit.alt.disabled,
			.woocommerce #respond input#submit.alt.disabled:hover,
			.woocommerce #respond input#submit.alt:disabled,
			.woocommerce #respond input#submit.alt:disabled:hover,
			.woocommerce #respond input#submit.alt:disabled[disabled],
			.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
			.woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover,
			.woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover,
			.woocommerce a.button.alt:disabled[disabled],
			.woocommerce a.button.alt:disabled[disabled]:hover,
			.woocommerce button.button.alt.disabled,
			.woocommerce button.button.alt.disabled:hover,
			.woocommerce button.button.alt:disabled,
			.woocommerce button.button.alt:disabled:hover,
			.woocommerce button.button.alt:disabled[disabled],
			.woocommerce button.button.alt:disabled[disabled]:hover,
			.woocommerce input.button.alt.disabled,
			.woocommerce input.button.alt.disabled:hover,
			.woocommerce input.button.alt:disabled,
			.woocommerce input.button.alt:disabled:hover,
			.woocommerce input.button.alt:disabled[disabled],
			.woocommerce input.button.alt:disabled[disabled]:hover
			.listar-grid.woocommerce .product .button:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.woocommerce ul.products li.product .listar-listing-package {
				color: rgb(' . $theme_color . ');
			}

			.post-type-archive-product .container.woopage .listar-main-block.woo-products-container .listar-listing-rating,
			.tax-product_cat .container.woopage .listar-main-block.woo-products-container .listar-listing-rating {
				background-color: rgb(' . $theme_color . ');
			}

			.woocommerce #respond input#submit.alt:hover,
			.woocommerce a.button.alt:hover,
			.woocommerce button.button.alt:hover,
			.woocommerce input.button.alt:hover,
			.woocommerce .woocommerce-breadcrumb a:hover {
				background-color: rgb(' . $theme_color . ');
			}

			.woocommerce-MyAccount-navigation-link.is-active a,
			.woocommerce-MyAccount-navigation-link a:hover,
			.woocommerce-MyAccount-navigation-link.is-active a:hover,
			.woocommerce-MyAccount-navigation-link a:focus,
			.woocommerce-MyAccount-navigation-link.is-active a:focus {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-content .listar-category-icon,
			.listar-featured-listing .listar-card-content .listar-category-icon,
			.listar-grid.listar-white-design .listar-featured-listing .listar-card-content .listar-category-icon,
			.listar-fill-background.listar-light-design .listar-featured-listing .listar-card-content .listar-category-icon {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop .listar-card-content:hover .listar-circular-wrapper .listar-card-content-image {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-is-desktop.listar-no-listing-card-hover.listar-spiral-effect .listar-card-content:hover .listar-circular-wrapper .listar-card-content-image {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-card-content.sticky .listar-card-content-image,
			.listar-grid.listar-white-design .listar-card-content.listar-no-image.sticky .listar-card-content-image {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-price-list-items-controls div:hover {
				color: rgb(' . $theme_color . ');
			}

			.listar-price-builder-category[data-selected="selected"] input {
				border: 2px solid rgb(' . $theme_color . ');
				color: rgb(' . $theme_color . ');
			}

			a.button-social-login,
			.widget-area a.button-social-login {
				color: rgb(' . $theme_color . ');
			}

			.woocommerce .star-rating span:before {
				color: rgb(' . $theme_color . ');
			}

			.wc-bookings-date-picker .ui-datepicker td.bookable a,
			.wc-bookings-date-picker .ui-datepicker td.ui-datepicker-current-day a,
			.wc-bookings-date-picker .ui-datepicker td.bookable-range .ui-state-default {
				background: rgb(' . $theme_color . ') !important;
			}

			.listar-footer-column .widget-title,
			.listar-footer-column .widget-title a {
				color: rgb(' . $theme_color . ');
			}

			.listar-newsletter-submit:hover:after {
				color: rgb(' . $theme_color . ');
			}

			.listar-footer-dark .listar-site-footer .widget:not([class*="widget_listar_"]).widget_calendar tbody td a,
			.widget:not([class*="widget_listar_"]).widget_calendar tbody td a {
				color: rgb(' . $theme_color . ');
			}

			.listar-do-iconify {
				background-color: rgb(' . $theme_color . ');
			}

			.listar-play-button-overlay {
				background-color:  rgba(' . $theme_color . ',0);
			}

			.listar-play-button:hover .listar-play-button-overlay {
				background-color:  rgba(' . $theme_color . ',0.7);
			}

			@media ( min-width: 768px ) {
				.listar-drop-down-menu-color .dropdown-menu {
					background-color: rgb(' . $theme_color . ');
				}

				.listar-plus-drop-down-menu:hover {
					color: rgb(' . $theme_color . ');
				}

				.listar-drop-down-menu-color #listar-primary-menu li > ul.dropdown-menu:before {
					background-color: rgb(' . $theme_color . ');
				}

				.site-header.listar-light-design .navbar-inverse .navbar-nav>li>a {
					color: rgb(' . $theme_color . ');
				}

				.navbar-inverse .navbar-nav>.active>a,
				.navbar-inverse .navbar-nav>.active>a:focus,
				.navbar-inverse .navbar-nav>.active>a:hover {
					color: rgb(' . $theme_color . ');
				}

				.dropdown-menu>li:focus>a,
				.dropdown-menu>li:hover>a,
				.dropdown .dropdown-menu>li:hover>a .caret {
					color: rgb(' . $theme_color . ');
				}

				.dropdown-menu>li>a:before {
					background-color: rgb(' . $theme_color . ');
				}

				#listar-primary-menu .dropdown .dropdown>li:focus>a .caret,
				#listar-primary-menu .dropdown .dropdown>li:hover>a .caret {
					color: rgb(' . $theme_color . ');
				}

				.listar-light-comments .comment-box .comment-header i {
					color: rgb(' . $theme_color . ');
				}

				.listar-light-comments .comment-box .comment-header i:hover {
					background-color: rgb(' . $theme_color . ');
				}

				.entry-content .widget_listar_call_to_action .listar-background-theme-color.listar-2-cols-boxed-half {
					box-shadow:
						0 0 100px rgba(0,0,0,0.1) inset,
						0 10000px rgb(' . $theme_color . ') inset !important;
				}
			}

			@media ( max-width: 767px ) {
				.navbar-header.listar-primary-navbar-mobile-visible > .listar-logged-user-name span {
					color: rgb(' . $theme_color . ');
				}

				.page-template-front-page.listar-frontpage-topbar-transparent.listar-topbar-default-color.listar-user-not-logged .site-header.listar-light-design .navbar-inverse .listar-user-login,
				.listar-user-not-logged .site-header .listar-primary-navbar-mobile-visible .listar-user-buttons.listar-user-buttons-responsive .listar-user-login {
					color: rgb(' . $theme_color . ');
				}

				.page-template-front-page.listar-frontpage-topbar-transparent.listar-topbar-default-color.listar-user-not-logged .site-header.listar-light-design .navbar-inverse .listar-user-login:before,
				.listar-user-not-logged .site-header .listar-primary-navbar-mobile-visible .listar-user-buttons.listar-user-buttons-responsive .listar-user-login:before {
					color: rgb(' . $theme_color . ');
				}

				.listar-topbar-default-color.listar-light-design #site-navigation .navbar-toggle.listar-primary-navbar-mobile-visible > .icon-bar,
				.listar-topbar-default-color #site-navigation .navbar-toggle.listar-primary-navbar-mobile-visible .icon-bar {
					background-color: rgb(' . $theme_color . ');
				}

				.site-header .navbar-nav>li>.dropdown-menu:before {
					background-color: rgb(' . $theme_color . ');
				}

				.navbar-inverse .navbar-nav>li>a:hover,
				.navbar-inverse .navbar-nav .open .dropdown-menu>li>a:hover,
				.navbar-inverse .navbar-nav li>a[aria-expanded="true"],
				.navbar-inverse .navbar-nav li>a[aria-expanded="true"]:hover,
				.navbar-inverse .navbar-nav li>a[aria-expanded="true"]:focus,
				.navbar-inverse .navbar-nav .open .dropdown-menu>li>a[aria-expanded="true"],
				.navbar-inverse .navbar-nav .open .dropdown-menu>li>a[aria-expanded="true"]:hover,
				.dropdown .dropdown-menu>li>a[aria-expanded="true"] .caret,
				.dropdown .dropdown-menu>li>a[aria-expanded="true"]:hover .caret {
					color: rgb(' . $theme_color . ');
				}
			}

			@media ( min-width: 660px ) {
				.listar-listing-categories-wrapper:before {
					box-shadow:
						-20px -15px 15px rgba(0,0,0,0.2),
						-8px -8px 8px rgba(0,0,0,0.1),
						20px -15px 15px rgba(0,0,0,0.2),
						8px -8px 8px rgba(0,0,0,0.1),
						20px -20px rgba(' . $theme_color . ',0),
						20px -20px 30px rgba(0,0,0,0),
						-20px 20px rgba(' . $theme_color . ',0),
						-20px 20px 30px rgba(0,0,0,0),
						0 0 80px rgba(255,255,255,0.0) inset;
				}
			}

			@media only screen and ( max-width: 480px ) {
				.listar-open-regions-list .listar-search-regions .listar-regions-list a.current span,
				#page .listar-open-regions-list .listar-search-regions .listar-regions-list a.current span {
					color: rgb(' . $theme_color . ');
				}
			}

			#wcfmmp-store .user_rated {
				background-color: rgb(' . $theme_color . ') !important;
			}

			#wcfmmp-store .rating_number {
				background-color: rgb(' . $theme_color . ');
			}

			#wcfmmp-store .reviews_heading a,
			#wcfmmp-store .reviews_count a,
			.wcfmmp_store_hours .wcfmmp-store-hours-day {
				color: rgb(' . $theme_color . ') !important;
			}

			#wcfmmp-store .add_review button:hover,
			#wcfmmp-store .bd_icon_box .follow:hover,
			#wcfmmp-store .bd_icon_box:hover .wcfm_store_enquiry:hover,
			#wcfmmp-store .bd_icon_box .wcfm_store_chatnow:hover,
			#wcfmmp-stores-wrap ul.wcfmmp-store-wrap li .store-data p.store-enquiry a.wcfm_catalog_enquiry:hover,
			#wcfmmp-stores-wrap .store-footer a.wcfmmp-visit-store:hover,
			.wcfm_popup_wrapper .wcfm_popup_button:hover,
			#wcfmmp-store .add_review button:hover {
				background-color: rgb(' . $theme_color . ') !important;
			}

			#wcfmmp-store .woocommerce-product-search:hover button:before {
				color: rgb(' . $theme_color . ');
			}

		';

		/*
		 * Theme Color *************************************************
		 * See Customize / Colors
		 */

		$front_page_header_overlay_color               = listar_convert_hex_to_rgb( get_theme_mod( 'listar_frontpage_hero_overlay_color', '#000000' ) );
		$front_page_header_overlay_opacity             = (string) get_theme_mod( 'listar_frontpage_hero_overlay_opacity', '0.5' );
		$front_page_header_overlay_secondary_color     = listar_convert_hex_to_rgb( get_theme_mod( 'listar_frontpage_hero_overlay_secondary_color', '#ffffff' ) );
		$front_page_header_overlay_secondary_opacity   = (string) get_theme_mod( 'listar_frontpage_hero_overlay_secondary_opacity', '0.95' );

		$listar_search_popup_overlay_color             = listar_convert_hex_to_rgb( get_theme_mod( 'listar_search_overlay_color', '#000000' ) );
		$listar_search_popup_overlay_opacity           = (string) get_theme_mod( 'listar_search_overlay_opacity', '0.5' );
		$listar_search_popup_overlay_secondary_color   = listar_convert_hex_to_rgb( get_theme_mod( 'listar_search_overlay_secondary_color', '#ffffff' ) );
		$listar_search_popup_overlay_secondary_opacity = (string) get_theme_mod( 'listar_search_overlay_secondary_opacity', '0.95' );

		$listar_search_by_popup_overlay_color             = listar_convert_hex_to_rgb( get_theme_mod( 'listar_search_by_overlay_color', '#000000' ) );
		$listar_search_by_popup_overlay_opacity           = (string) get_theme_mod( 'listar_search_by_overlay_opacity', '0.5' );
		$listar_search_by_popup_overlay_secondary_color   = listar_convert_hex_to_rgb( get_theme_mod( 'listar_search_by_overlay_secondary_color', '#ffffff' ) );
		$listar_search_by_popup_overlay_secondary_opacity = (string) get_theme_mod( 'listar_search_by_overlay_secondary_opacity', '0.95' );

		$login_overlay_color   = listar_convert_hex_to_rgb( get_theme_mod( 'listar_login_overlay_color', '#000000' ) );
		$login_overlay_opacity = (string) get_theme_mod( 'listar_login_overlay_opacity', '0.5' );

		$listar_review_popup_overlay_color   = listar_convert_hex_to_rgb( get_theme_mod( 'listar_review_overlay_color', '#000000' ) );
		$listar_review_popup_overlay_opacity = (string) get_theme_mod( 'listar_review_overlay_opacity', '0.5' );
		
		$listar_complaint_popup_overlay_color   = listar_convert_hex_to_rgb( get_theme_mod( 'listar_complaint_overlay_color', '#000000' ) );
		$listar_complaint_popup_overlay_opacity = (string) get_theme_mod( 'listar_complaint_overlay_opacity', '0.5' );

		$listar_main_menu_color      = listar_convert_hex_to_rgb( get_theme_mod( 'listar_main_menu_background_color', '#23282d' ) );
		$listar_footer_cols_color    = listar_convert_hex_to_rgb( get_theme_mod( 'listar_footer_columns_background_color', '#23282d' ) );
		$listar_footer_menu_color    = listar_convert_hex_to_rgb( get_theme_mod( 'listar_footer_menu_background_color', '#2d3237' ) );
		$listar_footer_credits_color = listar_convert_hex_to_rgb( get_theme_mod( 'listar_footer_credits_background_color', '#23282d' ) );

		$customizer_colors = '';

		if ( '255,255,255' !== $front_page_header_overlay_secondary_color ) {
			$gradient_background = listar_gradient_background( $front_page_header_overlay_color, 'top', 'bottom', $front_page_header_overlay_secondary_color, (string) $front_page_header_overlay_opacity, (string) $front_page_header_overlay_secondary_opacity );
			$customizer_colors .= '.listar-hero-header.listar-transparent-design.listar-front-header .listar-hero-header-overlay { ' . $gradient_background . ' }';
		} else {
			$customizer_colors .= '
			.listar-hero-header.listar-transparent-design.listar-front-header .listar-hero-header-overlay {
				background-color: rgba(' . $front_page_header_overlay_color . ',' . $front_page_header_overlay_opacity . ');
			}';
		}

		if ( '255,255,255' !== $listar_search_popup_overlay_secondary_color ) {
			$gradient_background = listar_gradient_background( $listar_search_popup_overlay_color, 'top', 'bottom', $listar_search_popup_overlay_secondary_color, (string) $listar_search_popup_overlay_opacity, (string) $listar_search_popup_overlay_secondary_opacity );
			$customizer_colors .= '.listar-hero-header.listar-transparent-design.listar-search-popup .listar-hero-header-overlay { ' . $gradient_background . ' }';
		} else {
			$customizer_colors .= '
			.listar-hero-header.listar-transparent-design.listar-search-popup .listar-hero-header-overlay {
				background-color: rgba(' . $listar_search_popup_overlay_color . ',' . $listar_search_popup_overlay_opacity . ');
			}';
		}

		if ( ( '255,255,255' !== $listar_search_by_popup_overlay_secondary_color || '255,255,255' !== $listar_search_by_popup_overlay_color ) && ( floatval( $listar_search_by_popup_overlay_secondary_opacity ) + floatval( $listar_search_by_popup_overlay_opacity ) ) > 0 ) {
			if ( '255,255,255' !== $listar_search_by_popup_overlay_secondary_color ) {
				$gradient_background = listar_gradient_background( $listar_search_by_popup_overlay_color, 'top', 'bottom', $listar_search_by_popup_overlay_secondary_color, (string) $listar_search_by_popup_overlay_opacity, (string) $listar_search_by_popup_overlay_secondary_opacity );
				$customizer_colors .= '.listar-hero-header.listar-transparent-design.listar-search-by-popup .listar-hero-header-overlay { ' . $gradient_background . ' }';
			} else {
				$customizer_colors .= '
				.listar-hero-header.listar-transparent-design.listar-search-by-popup .listar-hero-header-overlay {
					background-color: rgba(' . $listar_search_by_popup_overlay_color . ',' . $listar_search_by_popup_overlay_opacity . ');
				}';
			}
		} else {
			$customizer_colors .= '
			.listar-hero-header.listar-transparent-design.listar-search-by-popup .listar-hero-header-overlay {
				background-color: transparent;
			}';
		}

		$customizer_colors .= '
			.listar-hero-header.listar-transparent-design.listar-login-popup .listar-hero-header-overlay {
				background-color: rgba(' . $login_overlay_color . ',' . $login_overlay_opacity . ');
			}

			.listar-hero-header.listar-transparent-design.listar-review-popup .listar-hero-header-overlay {
				background-color: rgba(' . $listar_review_popup_overlay_color . ',' . $listar_review_popup_overlay_opacity . ');
			}

			.listar-hero-header.listar-transparent-design.listar-report-popup .listar-hero-header-overlay {
				background-color: rgba(' . $listar_complaint_popup_overlay_color . ',' . $listar_complaint_popup_overlay_opacity . ');
			}
		';
		
		if ( '255,255,255' === $listar_main_menu_color ) {
			$listar_main_menu_color = '35,40,45';
		}
		
		if ( '255,255,255' === $listar_footer_menu_color ) {
			$listar_footer_menu_color = '45,50,55';
		}
		
		if ( '255,255,255' === $listar_footer_cols_color ) {
			$listar_footer_cols_color = '35,40,45';
		}
		
		if ( '255,255,255' === $listar_footer_credits_color ) {
			$listar_footer_credits_color = '35,40,45';
		}
		
		$customizer_colors .= '.listar-fallback-menu-background { background-color: rgb(' . $listar_main_menu_color . '); }';
		$customizer_colors .= '.listar-footer-menu-wrapper { background-color: rgb(' . $listar_footer_menu_color . '); }';
		$customizer_colors .= '.listar-footer-dark .listar-site-footer { background-color: rgb(' . $listar_footer_cols_color . '); }';
		$customizer_colors .= '.listar-site-footer .listar-footer-credits { background-color: rgb(' . $listar_footer_credits_color . '); }';

		/*
		 * Theme Options Colors *****************************************
		 */
		
		$theme_options_colors = '';
		
		$listar_top_search_buttton_background_color = get_option( 'listar_background_color_search_button_top' );
		
		if ( 'rainbow' === $listar_top_search_buttton_background_color || empty( $listar_top_search_buttton_background_color ) ) {
			$listar_top_search_buttton_background_color = 'background: linear-gradient(124deg, #7932d1, #2664c9, #008c7d, #c78107, #c71674); background-size: 5000% 5000%;';
		} elseif ( 'default' === $listar_top_search_buttton_background_color ) {
			$listar_top_search_buttton_background_color = 'background: transparent;-webkit-animation:none;-moz-animation:none;-ms-animation:none;-o-animation:none;animation:none;';
		} elseif ( 'color' === $listar_top_search_buttton_background_color ) {
			$listar_current_theme_color = listar_convert_hex_to_rgb( listar_theme_color() );
			$listar_top_search_buttton_background_color = 'background: rgb(' . $listar_current_theme_color . ');-webkit-animation:none;-moz-animation:none;-ms-animation:none;-o-animation:none;animation:none;';
		} else {
			$listar_top_search_buttton_background_color = 'background: linear-gradient(124deg, #7932d1, #2664c9, #008c7d, #c78107, #c71674); background-size: 5000% 5000%;';
		}
		
		$listar_top_search_bg_color = ' @media ( min-width: 768px ) { .listar-header-search-button:before { ' . $listar_top_search_buttton_background_color .' } } ';
		
		$theme_options_colors .= $listar_top_search_bg_color;
		
		/*
		 * Important images for preload
		 */
		
		$important_images = '';
		
		if ( listar_is_front_page_template() && post_type_exists( 'job_listing' ) ) {
			/**
			 * Cover to front page (Hero Header) ***********************************
			 */
			
			/* Get hero image from Theme Options or default WordPress header image */
			global $post;
			$listar_hero_image = ! empty( $post->ID ) ? get_the_post_thumbnail_url( $post->ID, 'listar-cover' ) : '';
			$listar_hero_image_mobile = ! empty( $post->ID ) ? get_the_post_thumbnail_url( $post->ID, listar_mobile_hero_image_size() ) : '';
			
			if ( ! empty( $listar_hero_image ) ) {
				$important_images .= '.listar-hero-image-desktop-preload{background-image:url(' . $listar_hero_image . ');}';
			}

			if ( ! empty( $listar_hero_image_mobile ) ) {
				$important_images .= '.listar-hero-image-mobile-preload{background-image:url(' . $listar_hero_image_mobile . ');}';
			}
			
		}
			
		/*
		 * Other custom CSS ********************************************
		 */

		$custom_css = '';

		/* Get custom background color for the site */

		$custom_css .= 'body,#content,#primary,.listar-hidden-footer #content{background-color:#' . get_theme_mod( 'background_color', 'f4f4f4' ) . ';}';

		/* Respect max comments depth */

		$thread_comments_enabled = (int) get_option( 'thread_comments' );
		$thread_comments_depth   = (int) get_option( 'thread_comments_depth' );
		$comments_depth          = 1;

		if ( 1 === $thread_comments_enabled ) :
			$comments_depth = $thread_comments_depth;
		endif;

		$custom_css .= '.comment.depth-' . $comments_depth . ' .reply-the-comment{display: none;}';

		/* Logo height */

		$logo_height_desktop = '.site-header .listar-logo img {height:' . get_theme_mod( 'listar_logo_height_desktop', '44px' ) . ';}';
		$logo_height_mobile  = '@media (max-width: 767px) {.site-header .listar-logo img{height:' . get_theme_mod( 'listar_logo_height_mobile', '35px' ) . ';}}';

		$custom_css .= 'body,#content,.listar-hidden-footer #content{background-color:#' . get_theme_mod( 'background_color', 'f4f4f4' ) . ';}' . $logo_height_desktop . $logo_height_mobile;
		
		/* Accordion scrolling height */
		
		$accordion_scroll_height = (int) get_option( 'listar_accordion_scrollable_after' );
		
		if ( 0 !== $accordion_scroll_height ) {
			$custom_css .= 'div[role="tabpanel"][aria-expanded="true"] {max-height: ' . $accordion_scroll_height . 'px;overflow-x: hidden;overflow-y: auto;}';
		}
		
		/* Loading overlay background color */

		$loading_background_color = listar_convert_hex_to_rgb( get_theme_mod( 'listar_loading_overlay_background_color', '#23282d' ) );
		
		if ( ! empty( $loading_background_color ) ) {
			$custom_css .= '.listar-loading-holder{background-color:rgba(' . $loading_background_color . ',.99) !important;}';
		}

		/* Social Networks and Sharing Buttons */

		$social_buttons_background_color = listar_convert_hex_to_rgb( get_theme_mod( 'listar_social_sharing_buttons_background_color', '#ffffff' ) );
		
		if ( ! empty( $social_buttons_background_color ) && '255,255,255' !== $social_buttons_background_color  ) {
			$custom_css .= '
				.listar-social-share-popup .listar-panel-form-wrapper > .listar-panel-form:before,
				.listar-social-networks .fa-facebook,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="facebook.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="facebook.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="facebook.com"]:focus,
				.listar-post-social-share ul li a i[class*="facebook"]:before,
				.listar-social-networks .fa-twitter,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="twitter.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="twitter.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="twitter.com"]:focus,
				.listar-post-social-share ul li a i[class*="twitter"]:before,
				.listar-social-networks .fa-whatsapp,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="whatsapp.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="whatsapp.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="whatsapp.com"]:focus,
				.listar-post-social-share ul li a i[class*="whatsapp"]:before,
				.listar-social-networks .fa-telegram,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="telegram.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="telegram.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="telegram.com"]:focus,
				.listar-post-social-share ul li a i[class*="telegram"]:before,
				.listar-social-networks .fa-linkedin,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="linkedin.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="linkedin.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="linkedin.com"]:focus,
				.listar-post-social-share ul li a i[class*="linkedin"]:before,
				.listar-social-networks .fa-tumblr,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="tumblr.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="tumblr.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="tumblr.com"]:focus,
				.listar-post-social-share ul li a i[class*="tumblr"]:before,
				.listar-social-networks .fa-envelope-o,
				.listar-post-social-share ul li a i[class*="envelope-o"]:before,
				.listar-social-networks .icon-copy,
				.listar-post-social-share ul li a i[class*="icon-copy"]:before,
				.listar-social-networks .fa-google-plus,
				.listar-social-networks .fa-pinterest,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="pinterest.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="pinterest.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="pinterest.com"]:focus,
				.listar-post-social-share ul li a i[class*="pinterest"]:before,
				.listar-post-social-share ul li a i.icon-share2:before,
				.listar-social-networks .fa-instagram,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="instagram.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="instagram.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="instagram.com"]:focus,
				.listar-social-networks .fa-foursquare,
				.listar-social-networks .fa-youtube,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="youtube.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="youtube.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="youtube.com"]:focus,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[data-menu-item-title*="skype"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[data-menu-item-title*="skype"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[data-menu-item-title*="skype"]:focus,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[data-menu-item-title*="whatsapp"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[data-menu-item-title*="whatsapp"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[data-menu-item-title*="whatsapp"]:focus,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="whatsapp.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="whatsapp.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="whatsapp.com"]:focus,
				.listar-social-networks .fa-vimeo,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="vimeo.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="vimeo.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="vimeo.com"]:focus,
				.listar-social-networks .fa-vk,
				.listar-site-footer .listar-footer-credits .listar-footer-menu a[href*="vk.com"],
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="vk.com"]:hover,
				.listar-site-footer .listar-footer-credits .listar-footer-menu li>a[href*="vk.com"]:focus {
					background-color: rgb(' . $social_buttons_background_color . ');
				}
			';
		}

		/* Position for front page hero content */
		
		$listar_hero_content_position = get_option( 'listar_hero_content_position' );
		
		if ( empty( $listar_hero_content_position ) ) {
			$listar_hero_content_position = 'center';
		}
		
		if ( 'left' === $listar_hero_content_position ) {
			$custom_css .= '
				.listar-front-header .listar-hero-section-title,
				.listar-front-header .listar-hero-section-title h1,
				.listar-front-header .listar-hero-search-wrapper,
				.listar-front-header .listar-search-categories {
					text-align: left !important;
				}

				.listar-listing-search-menu-wrapper,
				.listar-search-highlight-tip {
					left: 0;
					-webkit-transform: translate(0);
					-moz-transform: translate(0);
					-ms-transform: translate(0);
					-o-transform: translate(0);
					transform: translate(0);
				}
				
				.listar-search-highlight-tip {
					text-align: left;
					padding-left: 40px;
				}
				
				.listar-search-highlight-tip-inner:before {
					left: auto;
					right: -48px;
					-webkit-transform: rotate(320deg) scale(-1, -1);
					-moz-transform: rotate(320deg) scale(-1, -1);
					-ms-transform: rotate(320deg) scale(-1, -1);
					-o-transform: rotate(320deg) scale(-1, -1);
					transform: rotate(320deg) scale(-1, -1);
				}
				
				.listar-search-highlight-tip-inner {
					text-aligh: right;
				}

				.listar-front-header .listar-hero-section-title {
					padding-left: 20px;
				}

				.listar-front-header .listar-search-categories {
					left: 0;
					margin-left: -45px;
					right: auto;
					-webkit-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-moz-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-ms-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-o-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
				}
				
				@media ( min-width: 1400px ) {
					.listar-front-header .listar-search-categories {
						left: calc(50% - 600px);
					}
				}
				
				@media ( max-width: 340px ) {
					.listar-search-highlight-tip {
						display: none;
					}
					
					.listar-front-header .listar-search-categories {
						margin-left: 0;
					}
				}
			';
		} elseif ( 'right' === $listar_hero_content_position ) {
			$custom_css .= '
				.listar-front-header .listar-hero-section-title,
				.listar-front-header .listar-hero-section-title h1,
				.listar-front-header .listar-hero-search-wrapper,
				.listar-front-header .listar-search-categories {
					text-align: right !important;
				}

				.listar-listing-search-menu-wrapper,
				.listar-search-highlight-tip {
					left: auto;
					right: 0;
					-webkit-transform: translate(0);
					-moz-transform: translate(0);
					-ms-transform: translate(0);
					-o-transform: translate(0);
					transform: translate(0);
				}
				
				.listar-search-highlight-tip {
					display: inline-block;
				}

				.listar-front-header .listar-hero-section-title{
					padding-right: 20px;
				}

				.listar-front-header .listar-search-categories {
					left: auto;
					right: 0;
					-webkit-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-moz-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-ms-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-o-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
				}

				.listar-front-header .listar-search-categories.listar-hidden-category-nav {
					margin-right: -45px;
				}
				
				@media ( min-width: 1350px ) {
					.listar-front-header .listar-search-categories.listar-hidden-category-nav {
						margin-right: 0;
					}
				}
				
				@media ( min-width: 1400px ) {
					.listar-front-header .listar-search-categories {
						right: calc(50% - 660px);
					}
				}
			';
		}

		/* Position for search popup content */
		
		$listar_search_popup_content_position = get_option( 'listar_search_popup_content_position' );
		
		if ( empty( $listar_search_popup_content_position ) ) {
			$listar_search_popup_content_position = 'center';
		}
		
		if ( 'left' === $listar_search_popup_content_position ) {
			$custom_css .= '
				.listar-search-popup .listar-hero-section-title,
				.listar-search-popup .listar-hero-section-title h1,
				.listar-search-popup .listar-hero-search-wrapper,
				.listar-search-popup .listar-search-categories {
					text-align:left !important;
				}

				.listar-search-popup .listar-hero-section-title {
					padding-left: 20px;
				}

				.listar-search-popup .listar-search-categories {
					left: 0;
					margin-left: -45px;
					right: auto;
					-webkit-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-moz-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-ms-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-o-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
				}
			';
		} elseif ( 'right' === $listar_search_popup_content_position ) {
			$custom_css .= '
				.listar-search-popup .listar-hero-section-title,
				.listar-search-popup .listar-hero-section-title h1,
				.listar-search-popup .listar-hero-search-wrapper,
				.listar-search-popup .listar-search-categories {
					text-align: right !important;
				}

				.listar-search-popup .listar-hero-section-title {
					padding-right: 20px;
				}

				.listar-search-popup .listar-search-categories {
					left: auto;
					right: 0;
					-webkit-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-moz-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-ms-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					-o-transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
					transform: translate(0,0) translateZ(1009px) translate3d(0,0,0);
				}

				.listar-search-popup .listar-search-categories.listar-hidden-category-nav {
					margin-right: -50px;
				}
			';
		}

		/* Position for search popup content */
		
		$listar_hero_search_categories_display = get_option( 'listar_hero_search_categories_display' );
		
		if ( 'full' === $listar_hero_search_categories_display ) {
			$custom_css .= '
				.listar-search-categories {
					max-width: 100%;
				}
			';
		} elseif ( 'wide' === $listar_hero_search_categories_display ) {
			$custom_css .= '
				.listar-search-categories {
					max-width: 75%;
				}
				
				@media ( max-width: 767px ) {
					.listar-search-categories {
						max-width: 100%;
					}
				}
			';
		}

		/*
		 * Loading animation *********************************
		 */
		
		$loading_animation = 'body{overflow-x:hidden}.listar-loading-holder{position:fixed;background-color:rgba(25,30,35,.99);position:fixed;height:100%;width:100%;z-index:50000;top:0;left:0;text-align:center;opacity:1}.listar-disable-loading-overlay .listar-loading-holder{display:none}.listar-loaded .listar-loading-holder{-webkit-animation:cssAnimation .8s forwards;-moz-animation:cssAnimation .8s forwards;-ms-animation:cssAnimation .8s forwards;-o-animation:cssAnimation .8s forwards;animation:cssAnimation .8s forwards}@keyframes cssAnimation{0%{opacity:1}99.9%{opacity:0}100%{opacity:0;display:none;visibility:hidden}}@-moz-keyframes cssAnimation{0%{opacity:1}99.9%{opacity:0}100%{opacity:0;display:none;visibility:hidden}}@-webkit-keyframes cssAnimation{0%{opacity:1}99.9%{opacity:0}100%{opacity:0;display:none;visibility:hidden}}@-ms-keyframes cssAnimation{0%{opacity:1}99.9%{opacity:0}100%{opacity:0;display:none;visibility:hidden}}@-o-keyframes cssAnimation{0%{opacity:1}99.9%{opacity:0}100%{opacity:0;display:none;visibility:hidden}}.listar-loading-holder.listar-loading-hide{opacity:0}.listar-loading{position:relative;top:50%;margin-top:-22px}.listar-loading-ring{position:relative;width:46px;height:46px;margin:0 auto;border:4px solid transparent;border-radius:100%}.listar-loading-ball-holder{position:absolute;width:12px;height:38px;left:13px;top:0;-webkit-animation:do-loading 1.3s linear infinite;-moz-animation:do-loading 1.3s linear infinite;-ms-animation:do-loading 1.3s linear infinite;-o-animation:do-loading 1.3s linear infinite;animation:do-loading 1.3s linear infinite}.listar-loading-ball{position:absolute;top:-7px;left:0;width:10px;height:10px;border-radius:100%;background:#fff}@keyframes do-loading{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes do-loading{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes do-loading{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-ms-keyframes do-loading{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes do-loading{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}';

		/*
		 * General configs from Theme Options
		 */
		
		$theme_options_css = '';
		
		$background_color_search_by_tip = get_option( 'listar_background_color_search_by_tip', 'rgb(204,32,164)' );
		$text_color_search_by_tip = get_option( 'listar_text_color_search_by_tip', '#ffffff' );
		
		$theme_options_css .= '.listar-search-by-tip{background-color:' . $background_color_search_by_tip . ';color:' . $text_color_search_by_tip . ';}';
		$theme_options_css .= '.listar-search-by-tip:before{color:' . $background_color_search_by_tip . ';}';

		/*
		 * Put all inline CSS together *********************************
		 */

		$inline_css  = $primary_font_css_selectors . '{font-family:"' . $primary_google_font_family . '",sans-serif,serif; font-weight: normal;}';
		$inline_css .= $secondary_font_css_selectors . '{' . $bold_string . 'font-family:"' . $secondary_google_font_family . '",sans-serif,serif;}';	
		/* @media */
		$inline_css .= '@media only screen and (max-width: 480px){.listar-search-highlight-tip-inner{font-size:15px;' . $bold_string . 'font-family:"' . $secondary_google_font_family . '",sans-serif,serif;}}';
		
		$inline_css .= $theme_color_css;
		$inline_css .= $customizer_colors;
		$inline_css .= $theme_options_colors;
		$inline_css .= $important_images;
		$inline_css .= $custom_css;
		$inline_css .= $loading_animation;
		$inline_css .= $theme_options_css;

		wp_add_inline_style( 'listar-main-style', $inline_css );

	}
endif;

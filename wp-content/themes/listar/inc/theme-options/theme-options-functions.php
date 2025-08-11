<?php
/**
 * Callback functions to registered settings on theme-options-fields.php
 *
 * @link https://developer.wordpress.org/reference/functions/register_setting/
 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
 *
 * @package Listar
 */

/**
 * Settings section callback.
 *
 * @since 1.0
 */
function listar_options_callback() {
	/**
	 * This callback is mandatory to add_settings_section(), but there is nothing
	 * relevant to do here currently, every registered theme setting/option
	 * will output code with its own callback function.
	 */
}

/**
 * General background images ***************************************************
 */

/**
 * Fallback avatar image for users
 *
 * @since 1.4.9
 */
function listar_user_avatar_fallback_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_user_avatar_fallback_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_user_avatar_fallback_image" id="listar_user_avatar_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_user_avatar_fallback_image" id="listar_user_avatar_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	endif;
}

/**
 * Fallback image for listing cards
 *
 * @since 1.4.2
 */
function listar_listing_card_fallback_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_listing_card_fallback_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_listing_card_fallback_image" id="listar_listing_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_listing_card_fallback_image" id="listar_listing_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	endif;
}

/**
 * Fallback image for blog cards
 *
 * @since 1.4.2
 */
function listar_blog_card_fallback_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_blog_card_fallback_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_blog_card_fallback_image" id="listar_blog_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_blog_card_fallback_image" id="listar_blog_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	endif;
}

/**
 * Fallback image for Woocommerce product cards
 *
 * @since 1.4.2
 */
function listar_woo_product_card_fallback_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_woo_product_card_fallback_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_woo_product_card_fallback_image" id="listar_woo_product_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_woo_product_card_fallback_image" id="listar_woo_product_card_fallback_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	endif;
}

/**
 * Theme option field/preview output - Background image for search popup.
 *
 * @since 1.0
 */
function listar_search_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_search_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_search_background_image" id="listar_search_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="hero-search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-hero-search-image" />
		<input type="hidden" name="listar_search_background_image" id="listar_search_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-hero-search-image" />
		<?php
	endif;
}

/**
 * Theme option field/preview output - Background image for ratings popup.
 *
 * @since 1.0
 */
function listar_ratings_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_ratings_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="ratings-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-ratings-image" />
		<input type="hidden" name="listar_ratings_background_image" id="listar_ratings_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-ratings-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="ratings-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>"  id="upload-ratings-image" />
		<input type="hidden" name="listar_ratings_background_image" id="listar_ratings_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-ratings-image" />
		<?php
	endif;
}

/**
 * Theme option field/preview output - Background image for "Login" popup.
 *
 * @since 1.0
 */
function listar_login_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_login_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="login-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-login-image" />
		<input type="hidden" name="listar_login_background_image" id="listar_login_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-login-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="login-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_attr( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-login-image" />
		<input type="hidden" name="listar_login_background_image" id="listar_login_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-login-image" />
		<?php
	endif;
}

/**
 * Theme option field/preview output - Background image for "Social Sharing" popup.
 *
 * @since 1.0
 */
function listar_social_share_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_social_share_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="login-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-social-share-background-image" />
		<input type="hidden" name="listar_social_share_background_image" id="listar_social_share_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-social-share-background-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="login-bg-image-preview" class="adm-pic-prev" src="<?php echo esc_attr( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-social-share-background-image" />
		<input type="hidden" name="listar_social_share_background_image" id="listar_social_share_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-social-share-background-image" />
		<?php
	endif;
}

/**
 * Theme option field/preview output - For blog: default cover image to search/archive pages.
 *
 * @since 1.0
 */
function listar_blog_search_page_cover_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_blog_search_page_cover_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-search-image" />
		<input type="hidden" name="listar_blog_search_page_cover_image" id="listar_blog_search_page_cover_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-search-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="search-image-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-search-image" />
		<input type="hidden" name="listar_blog_search_page_cover_image" id="listar_blog_search_page_cover_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-search-image" />
		<?php
	endif;
}

/**
 * "404" and "No results" pages ************************************************
 */

/**
 * Theme option field/preview output - Page 404 Cover Image.
 *
 * @since 1.0
 */
function listar_page_404_cover_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_page_404_cover_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-404-cover" />
		<input type="hidden" name="listar_page_404_cover_image" id="listar_page_404_cover_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-404-cover" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-404-cover" />
		<input type="hidden" name="listar_page_404_cover_image" id="listar_page_404_cover_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-404-cover" />
		<?php
	endif;
}

/**
 * Complaint Report popup ******************************************************
 */

/**
 * Background image for Complaint Report popup.
 *
 * @since 1.0
 */
function listar_complaint_report_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_complaint_report_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="image-complaint_report_background-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-complaint_report_background" />
		<input type="hidden" name="listar_complaint_report_background_image" id="listar_complaint_report_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-complaint_report_background" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="image-complaint_report_background-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-complaint_report_background" />
		<input type="hidden" name="listar_complaint_report_background_image" id="listar_page_404_cover_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-complaint_report_background" />
		<?php
	endif;
}

/**
 * Grid Fillers ****************************************************************
 */

/**
 * Background image for listing "grid filler" card
 *
 * @since 1.3.8
 */
function listar_listing_grid_filler_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_listing_grid_filler_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-listing-grid-filler-cover" />
		<input type="hidden" name="listar_listing_grid_filler_background_image" id="listar_listing_grid_filler_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-listing-grid-filler-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-listing-grid-filler-cover" />
		<input type="hidden" name="listar_listing_grid_filler_background_image" id="listar_listing_grid_filler_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-listing-grid-filler-image" />
		<?php
	endif;
}

/**
 * Background image for blog "grid filler" card
 *
 * @since 1.0
 */
function listar_blog_grid_filler_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_blog_grid_filler_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-blog-grid-filler-cover" />
		<input type="hidden" name="listar_blog_grid_filler_background_image" id="listar_blog_grid_filler_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-blog-grid-filler-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-blog-grid-filler-cover" />
		<input type="hidden" name="listar_blog_grid_filler_background_image" id="listar_blog_grid_filler_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-blog-grid-filler-image" />
		<?php
	endif;
}

/**
 * Background image for "Explore By" popup.
 *
 * @since 1.3.6
 */
function listar_search_by_background_image_callback() {

	$input      = (int) sanitize_text_field( get_option( 'listar_search_by_background_image' ) );
	$attachment = ! empty( $input ) ? wp_get_attachment_image_src( $input, 'listar-thumbnail' ) : false;
	$conditions = false !== $attachment && isset( $attachment[0] ) && ! empty( $attachment[0] );
	$image_url  = $conditions ? $attachment[0] : '';

	if ( empty( $image_url ) ) :
		?>
		<div class="adm-pic-wrapper hidden">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" id="upload-blog-grid-filler-cover" />
		<input type="hidden" name="listar_search_by_background_image" id="listar_search_by_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-blog-grid-filler-image" />
		<?php
	else :
		?>
		<div class="adm-pic-wrapper">
			<img id="image-404-cover-preview" class="adm-pic-prev" src="<?php echo esc_url( $image_url ); ?>" />
		</div>
		<input type="button" class="button button-secondary adm-image-upload" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Choose image', 'listar' ); ?>" id="upload-blog-grid-filler-cover" />
		<input type="hidden" name="listar_search_by_background_image" id="listar_search_by_background_image" value="<?php echo esc_attr( $input ); ?>" />
		<input type="button" class="button button-secondary adm-remove-image" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" id="remove-blog-grid-filler-image" />
		<?php
	endif;
}

/**
 * Private Message *************************************************************
 */

/**
 * WP Easy SMTP is uninstalled.
 *
 * @since 1.2.4
 */
function listar_easy_smtp_uninstalled_callback() {
	?>
	<p class="description">
		<?php
		$listar_kses_tags = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
		);

		printf(
			/* TRANSLATORS: %s: URL to 'Easy WP SMTP plugin' page */
			wp_kses( __( 'Please, install and configure <a href="%s" target="_blank">Easy WP SMTP</a> before procceed.', 'listar' ), $listar_kses_tags ),
			'https://br.wordpress.org/plugins/easy-wp-smtp/'
		);
		?>
	</p>
	<?php
}
/**
 * WP Easy SMTP is installed.
 *
 * @since 1.4.8
 */
function listar_wp_mail_smtp_installed_callback() {
	?>
	<p class="description">
		<?php
		$listar_kses_tags = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
			'br' => array(),
		);

		printf(
			/* TRANSLATORS: 1: URL to 'WP Mail SMTP plugin' page, 2: URL to test 'WP Mail SMTP plugin' */
			wp_kses( __( '<a href="%1$s" target="_blank">Click here</a> and follow the instructions to configure the WP Mail SMTP plugin.<br>You can also <a href="%2$s" target="_blank">Click here</a> to test your current SMTP settings.', 'listar' ), $listar_kses_tags ),
			esc_url( admin_url( '/admin.php?page=wp-mail-smtp' ) ),
			esc_url( admin_url( '/admin.php?page=wp-mail-smtp-tools&tab=test' ) )
		);
		?>
	</p>
	<?php
}

/**
 * WP Easy SMTP is installed.
 *
 * @since 1.2.4
 */
function listar_easy_smtp_installed_callback() {
	?>
	<p class="description">
		<?php
		$listar_kses_tags = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
			'br' => array(),
		);

		printf(
			/* TRANSLATORS: 1: URL to 'Easy WP SMTP plugin' page, 2: URL to test 'Easy WP SMTP plugin' */
			wp_kses( __( '<a href="%1$s" target="_blank">Click here</a> and follow the instructions to configure the Easy WP SMTP plugin.<br>You can also <a href="%2$s" target="_blank">Click here</a> to test your current SMTP settings.', 'listar' ), $listar_kses_tags ),
			esc_url( admin_url( '/options-general.php?page=swpsmtp_settings' ) ),
			esc_url( admin_url( '/options-general.php?page=swpsmtp_settings#testemail' ) )
		);
		?>
	</p>
	<?php
}

/**
 * User registration message subject
 *
 * @since 1.3.4
 */
function listar_user_registration_message_subject_callback() {
	$input = get_option( 'listar_user_registration_message_subject' );
	$listar_user_registration_message_subject = str_replace( '"', '\'', $input );

	/* Fallback subject */
	if ( empty( $listar_user_registration_message_subject ) ) {
		$suffix = esc_html__( 'User Registration', 'listar' );
		$listar_user_registration_message_subject = '[listar_username] - ' . $suffix . ' - [listar_site_name]';
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_username], [listar_site_name]</p><br>';
	?>
	<input type="text" name="listar_user_registration_message_subject" value="<?php echo esc_attr( $listar_user_registration_message_subject ); ?>" />
	<?php
}

/**
 * User registration message template
 *
 * @since 1.3.4
 */
function listar_user_registration_message_template_callback() {
	$listar_user_registration_message_template = html_entity_decode( stripcslashes( get_option( 'listar_user_registration_message_template' ) ) );

	/* Fallback template */
	if ( empty( $listar_user_registration_message_template ) ) {
		$page_prefix        = esc_html__( 'Page', 'listar' );
		$email_prefix       = esc_html__( 'Email', 'listar' );
		$user_prefix        = esc_html__( 'Username', 'listar' );
		$pass_prefix        = esc_html__( 'Password', 'listar' );
		$line_break         = '<br>';
		$separator          = '<hr />';
		$listar_user_registration_message_template = '';
		
		$header        = '<h3>' . strtoupper( esc_html__( 'User Registration', 'listar' ) ) . '</h3>';
		$subtitle      = '<strong>[listar_site_name] - [listar_site_description]</strong>';
		$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
		$email         = '<strong>' . $email_prefix . ':</strong> [listar_login_email]' . $line_break;
		$user          = '<strong>' . $user_prefix . ':</strong> [listar_username]' . $line_break;
		$password      = '<strong>' . $pass_prefix . ':</strong> [listar_password]';
		$footer        = '<br><br>[listar_do_login_link]';
		$footer2       = '<strong>' . esc_html__( 'To set a new password, visit the following address:', 'listar' ) . '</strong> [listar_wp_password_change_link]';

		$listar_user_registration_message_template .= $header . $line_break . $subtitle . $separator . $page . $email . $user . $password . $separator . $footer2 . $separator . $footer;
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_username], [listar_password], [listar_login_email], [listar_site_name], [listar_site_description], [listar_site_link], [listar_current_page_link], [listar_do_login_link], [listar_wp_password_change_link]</p><br>';

	wp_editor( wp_kses( $listar_user_registration_message_template, 'post' ), 'listar_user_registration_message_template', array() );
}

/**
 * Password recovering message subject
 *
 * @since 1.3.4
 */
function listar_user_password_recover_message_subject_callback() {
	$input = get_option( 'listar_user_password_recover_message_subject' );
	$listar_user_password_recover_message_subject = str_replace( '"', '\'', $input );

	/* Fallback subject */
	if ( empty( $listar_user_password_recover_message_subject ) ) {
		$suffix = esc_html__( 'Password Recovering', 'listar' );
		$listar_user_password_recover_message_subject = '[listar_username] - ' . $suffix . ' - [listar_site_name]';
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_username], [listar_site_name]</p><br>';
	?>
	<input type="text" name="listar_user_password_recover_message_subject" value="<?php echo esc_attr( $listar_user_password_recover_message_subject ); ?>" />
	<?php
}

/**
 * Password recovering message template
 *
 * @since 1.3.4
 */
function listar_user_password_recover_message_template_callback() {
	$listar_user_password_recover_message_template = html_entity_decode( stripcslashes( get_option( 'listar_user_password_recover_message_template' ) ) );

	/* Fallback template */
	if ( empty( $listar_user_password_recover_message_template ) ) {
		$page_prefix        = esc_html__( 'Page', 'listar' );
		$email_prefix       = esc_html__( 'Email', 'listar' );
		$user_prefix        = esc_html__( 'Username', 'listar' );
		$line_break         = '<br>';
		$separator          = '<hr />';
		$listar_user_password_recover_message_template = '';
		
		$header        = '<h3>' . strtoupper( esc_html__( 'Password Recovering', 'listar' ) ) . '</h3>';
		$subtitle      = '<strong>[listar_site_name] - [listar_site_description]</strong>';
		$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
		$email         = '<strong>' . $email_prefix . ':</strong> [listar_login_email]' . $line_break;
		$user          = '<strong>' . $user_prefix . ':</strong> [listar_username]';
		$footer        = '<strong>' . esc_html__( 'To set a new password, visit the following address:', 'listar' ) . '</strong> [listar_wp_password_change_link]';

		$listar_user_password_recover_message_template .= $header . $line_break . $subtitle . $separator . $page . $email . $user . $separator . $footer;
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_username], [listar_login_email], [listar_site_name], [listar_site_description], [listar_site_link], [listar_current_page_link], [listar_do_login_link], [listar_wp_password_change_link]</p><br>';

	wp_editor( wp_kses( $listar_user_password_recover_message_template, 'post' ), 'listar_user_password_recover_message_template', array() );
}

/**
 * Disable private message form for listings?
 *
 * @since 1.2.9
 */
function listar_disable_private_message_callback() {
	$input   = (int) get_option( 'listar_disable_private_message' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_private_message" name="listar_disable_private_message" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Private message subject.
 *
 * @since 1.2.4
 */
function listar_private_message_subject_callback() {
	$input = get_option( 'listar_private_message_subject' );
	$listar_private_message_subject = str_replace( '"', '\'', $input );

	/* Fallback subject */
	if ( empty( $listar_private_message_subject ) ) {
		$prefix = esc_html__( 'Private Message', 'listar' );
		$listar_private_message_subject = $prefix . ': [listar_site_name] - [listar_listing_title]';
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_sender_name], [listar_listing_title], [listar_site_name], [listar_listing_owner_name]</p><br>';
	?>
	<input type="text" name="listar_private_message_subject" value="<?php echo esc_attr( $listar_private_message_subject ); ?>" />
	<?php
}

/**
 * Private message template.
 *
 * @since 1.2.4
 */
function listar_private_message_template_callback() {
	$listar_private_message_template = html_entity_decode( stripcslashes( get_option( 'listar_private_message_template' ) ) );

	/* Fallback template */
	if ( empty( $listar_private_message_template ) ) {
		$message_for_prefix = esc_html__( 'Message For', 'listar' );
		$page_prefix        = esc_html__( 'Page', 'listar' );
		$visitor_prefix     = esc_html__( 'Visitor', 'listar' );
		$email_prefix       = esc_html__( 'Email', 'listar' );
		$line_break         = '<br>';
		$listar_private_message_template = '';

		$message_for   = '<strong>' . $message_for_prefix . ':</strong> [listar_listing_owner_name]' . $line_break;
		$page          = '<strong>' . $page_prefix . ':</strong> [listar_current_page_link]' . $line_break;
		$visitor       = '<strong>' . $visitor_prefix . ':</strong> [listar_sender_name]' . $line_break;
		$visitor_email = '<strong>' . $email_prefix . ':</strong> [listar_sender_email]';
		$separator     = '<hr />';
		$message       = '[listar_sender_message]';

		$listar_private_message_template .= $message_for . $page . $visitor . $visitor_email . $separator . $message;
	}

	echo '<p class="description"><strong>' . esc_html__( 'Shortcodes', 'listar' ) . ':</strong> [listar_sender_name], [listar_sender_email], [listar_sender_message], [listar_current_page_link], [listar_site_name], [listar_listing_owner_name], [listar_listing_owner_email]</p><br>';

	wp_editor( wp_kses( $listar_private_message_template, 'post' ), 'listar_private_message_template', array() );
}

/**
 * Sending fail message.
 *
 * @since 1.2.4
 */
function listar_sending_fail_message_callback() {
	$listar_sending_fail_message = get_option( 'listar_sending_fail_message' );

	/* Fallback text */
	if ( empty( $listar_sending_fail_message ) ) {
		$listar_sending_fail_message = esc_html__( 'Message not sent.', 'listar' );
	}
	?>
	<input type="text" name="listar_sending_fail_message" value="<?php echo esc_attr( $listar_sending_fail_message ); ?>" placeholder="<?php echo esc_attr( $listar_sending_fail_message ); ?>" />
	<?php
}

/**
 * Sending success message.
 *
 * @since 1.2.4
 */
function listar_sending_success_message_callback() {
	$listar_sending_success_message = get_option( 'listar_sending_success_message' );

	/* Fallback text */
	if ( empty( $listar_sending_success_message ) ) {
		$listar_sending_success_message = esc_html__( 'Ok, message sent.', 'listar' );
	}
	?>
	<input type="text" name="listar_sending_success_message" value="<?php echo esc_attr( $listar_sending_success_message ); ?>" placeholder="<?php echo esc_attr( $listar_sending_success_message ); ?>" />
	<?php
}

/**
 * Theme option field/preview output - Users allowed to publish listings on front end.
 *
 * @since 1.2.4
 */
function listar_users_allowed_publish_listings_callback() {

	listar_get_current_user_role();

	$input = get_option( 'listar_users_allowed_publish_listings' );
	$roles = get_editable_roles();

	$allowed_roles_json  = ! empty( $input ) ? str_replace( '\\', '', $input ) : '';
	$allowed_roles_array = json_decode( $allowed_roles_json, true );
	$allowed_roles_key_value = array();

	if ( ! empty( $allowed_roles_array ) ) :
		foreach ( $allowed_roles_array as $elem ) :
			if ( isset( $elem[0] ) && isset( $elem[1] ) && ! empty( isset( $elem[0] ) ) && ! empty( isset( $elem[1] ) ) ) {
				$allowed_roles_key_value[ $elem[0] ] = $elem[1];
			}
		endforeach;
	endif;

	$roles['visitor'] = array(
		'name' => esc_html__( 'Visitors (not logged users)', 'listar' ),
	);
	?>
	<div class="listar-users-allowed-publish-listings">
		<?php
		foreach ( $roles as $key => $value ) :
			$checked = '';

			if ( 'administrator' === $key ) {
				continue;
			}

			if ( isset( $allowed_roles_key_value[ $key ] ) ) {
				$checked = '1' === $allowed_roles_key_value[ $key ] ? 'checked' : '';
			}
			?>
			<div>
				<label>
					<input type="checkbox" value="<?php echo esc_html( $key ); ?>" <?php echo esc_attr( $checked ); ?>> <?php echo esc_html( $value['name'] ); ?>
				</label>
			</div>
			<?php
		endforeach;
		?>

		<input id="listar_users_allowed_publish_listings" type="hidden" name="listar_users_allowed_publish_listings">

		<p class="description">
			<?php esc_html_e( 'Adminstrators will always be able to publish listings.', 'listar' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Disable logo?
 *
 * @since 1.3.4
 */
function listar_logo_disable_callback() {
	$input   = (int) get_option( 'listar_logo_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_logo_disable" name="listar_logo_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable email data publicly?
 *
 * @since 1.3.4
 */
function listar_email_data_disable_callback() {
	$input   = (int) get_option( 'listar_email_data_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_email_data_disable" name="listar_email_data_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable location (address)?
 *
 * @since 1.3.4
 */
function listar_location_disable_callback() {
	$input   = (int) get_option( 'listar_location_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_location_disable" name="listar_location_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "This also will disable all maps and directions.", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Disable distance metering for listings?
 *
 * @since 1.3.8
 */
function listar_use_distance_metering_callback() {
	$input = get_option( 'listar_use_distance_metering' );
	$input_values = array(
		array( 'all-available', esc_html__( 'All available', 'listar' ) ),
		array( 'most-relevant', esc_html__( 'Only the most relevant', 'listar' ) ),
		array( 'disable', esc_html__( 'Disable', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'all-available';
	}
	?>

	<select name="listar_use_distance_metering" id="listar_use_distance_metering">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>
	</select>
	<?php
}

/**
 * Unit of distance
 *
 * @since 1.5.3.3
 */
function listar_distance_unit_callback() {
	$input = get_option( 'listar_distance_unit' );
	$input_values = array(
		array( 'km', 'km' ),
		array( 'mi', 'mi' ),
	);

	if ( empty( $input ) ) {
		$input = 'km';
	}
	?>

	<select name="listar_distance_unit" id="listar_distance_unit">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>
	</select>
	<?php
}

/**
 * Use meter as a unit of measurement if distance is lower than (km)
 *
 * @since 1.4.0
 */
function listar_meters_if_lower_than_callback() {
	$input = get_option( 'listar_meters_if_lower_than' );
	?>
	<input type="text" name="listar_meters_if_lower_than" id="listar_meters_if_lower_than" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Disable geolocation button for listing cards
 *
 * @since 1.5.0
 */
function listar_listing_card_geolocation_button_disable_callback() {
	$input   = (int) get_option( 'listar_listing_card_geolocation_button_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_listing_card_geolocation_button_disable" name="listar_listing_card_geolocation_button_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable reference location per listing region
 *
 * @since 1.3.8
 */
function listar_region_reference_metering_disable_callback() {
	$input   = (int) get_option( 'listar_region_reference_metering_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_region_reference_metering_disable" name="listar_region_reference_metering_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable custom reference location for "Add Listing" form
 *
 * @since 1.3.8
 */
function listar_add_listing_reference_metering_disable_callback() {
	$input   = (int) get_option( 'listar_add_listing_reference_metering_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_add_listing_reference_metering_disable" name="listar_add_listing_reference_metering_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable reference locations for single listing pages
 *
 * @since 1.3.8
 */
function listar_single_listing_reference_metering_disable_callback() {
	$input   = (int) get_option( 'listar_single_listing_reference_metering_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_single_listing_reference_metering_disable" name="listar_single_listing_reference_metering_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable reference locations for single listing pages
 *
 * @since 1.3.8
 */
function listar_fallback_references_disable_callback() {
	$input   = (int) get_option( 'listar_fallback_references_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_fallback_references_disable" name="listar_fallback_references_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Public label for primary (fallback) reference location
 *
 * @since 1.3.8
 */
function listar_primary_fallback_listing_reference_label_callback() {
	$input = get_option( 'listar_primary_fallback_listing_reference_label' );
	?>
	<input type="text" name="listar_primary_fallback_listing_reference_label" id="listar_primary_fallback_listing_reference_label" value="<?php echo esc_attr( $input ); ?>" />
	<p class="description">
		<?php esc_html_e( "Example: Los Angeles Museum", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Primary reference location (address) for listing distance metering
 *
 * @since 1.3.8
 */
function listar_primary_fallback_listing_reference_callback() {
	$input = get_option( 'listar_primary_fallback_listing_reference' );
	?>
	<input type="text" name="listar_primary_fallback_listing_reference" id="listar_primary_fallback_listing_reference" value="<?php echo esc_attr( $input ); ?>" />
	<div class="listar-geolocation-result-info">
		<strong class="listar-is-geolocated">
			<?php esc_html_e( "All right, this address is geolocated.", 'listar' ); ?><br>
		</strong>
		<strong class="listar-is-not-geolocated">
			<?php esc_html_e( "This address could not be geolocated.", 'listar' ); ?><br>
		</strong>
	</div>
	<p class="description">
		<?php esc_html_e( "Please insert the full address and number of a very popular place.", 'listar' ); ?><br>
		<?php esc_html_e( "Example of full address: 5905 Wilshire Boulevard, Los Angeles, CA 90036, USA", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Geolocated latitude
 *
 * @since 1.3.8
 */
function listar_primary_fallback_geolocated_lat_callback() {
	$input = get_option( 'listar_primary_fallback_geolocated_lat' );
	?>
	<input type="text" name="listar_primary_fallback_geolocated_lat" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Geolocated longitude
 *
 * @since 1.3.8
 */
function listar_primary_fallback_geolocated_lng_callback() {
	$input = get_option( 'listar_primary_fallback_geolocated_lng' );
	?>
	<input type="text" name="listar_primary_fallback_geolocated_lng" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Public label for secondary (fallback) reference location
 *
 * @since 1.3.8
 */
function listar_secondary_fallback_listing_reference_label_callback() {
	$input = get_option( 'listar_secondary_fallback_listing_reference_label' );
	?>
	<input type="text" name="listar_secondary_fallback_listing_reference_label" id="listar_secondary_fallback_listing_reference_label" value="<?php echo esc_attr( $input ); ?>" />
	<p class="description">
		<?php esc_html_e( "Example: Los Angeles Museum", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Secondary reference location (address) for listing distance metering
 *
 * @since 1.3.8
 */
function listar_secondary_fallback_listing_reference_callback() {
	$input = get_option( 'listar_secondary_fallback_listing_reference' );
	?>
	<input type="text" name="listar_secondary_fallback_listing_reference" id="listar_secondary_fallback_listing_reference" value="<?php echo esc_attr( $input ); ?>"/>
	<div class="listar-geolocation-result-info">
		<strong class="listar-is-geolocated">
			<?php esc_html_e( "All right, his address is geolocated.", 'listar' ); ?><br>
		</strong>
		<strong class="listar-is-not-geolocated">
			<?php esc_html_e( "This address could not be geolocated.", 'listar' ); ?><br>
		</strong>
	</div>
	<p class="description">
		<?php esc_html_e( "Please insert the full address and number of a very popular place.", 'listar' ); ?><br>
		<?php esc_html_e( "Example of full address: 5905 Wilshire Boulevard, Los Angeles, CA 90036, USA", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Geolocated latitude
 *
 * @since 1.3.8
 */
function listar_secondary_fallback_geolocated_lat_callback() {
	$input = get_option( 'listar_secondary_fallback_geolocated_lat' );
	?>
	<input type="text" name="listar_secondary_fallback_geolocated_lat" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Geolocated longitude
 *
 * @since 1.3.8
 */
function listar_secondary_fallback_geolocated_lng_callback() {
	$input = get_option( 'listar_secondary_fallback_geolocated_lng' );
	?>
	<input type="text" name="listar_secondary_fallback_geolocated_lng" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Geolocate reference addresses
 *
 * @since 1.3.8
 */
function listar_geolocate_reference_addresses_callback() {
	?>
	<input type="button" class="button button-secondary listar-geolocate-addresses" id="listar-geolocate-addresses" value="<?php esc_attr_e( 'Verify Geolocation', 'listar' ); ?>" />
	<?php
}

/**
 * Informs if "1" view was preset for all listings
 *
 * @since 1.3.9
 */
function listar_is_first_listing_view_preset_callback() {
	?>
	<label>
		<input type="checkbox" id="listar_is_first_listing_view_preset" name="listar_is_first_listing_view_preset" value="1" checked="checked" />
	</label>
	<?php
}

/**
 * Disable default visibility for the views counter on single listing pages?
 *
 * @since 1.3.9
 */
function listar_single_listing_view_counter_disable_callback() {
	$input   = (int) get_option( 'listar_single_listing_view_counter_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_single_listing_view_counter_disable" name="listar_single_listing_view_counter_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Allow listing owners decide to show/hide the views counter in their listings?
 *
 * @since 1.3.9
 */
function listar_allow_listing_owners_handle_counter_callback() {
	$input   = (int) get_option( 'listar_allow_listing_owners_handle_counter' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_allow_listing_owners_handle_counter" name="listar_allow_listing_owners_handle_counter" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Display the views counter when editing a listing on the backend?
 *
 * @since 1.3.9
 */
function listar_display_views_counter_backend_callback() {
	$input   = (int) get_option( 'listar_display_views_counter_backend' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_display_views_counter_backend" name="listar_display_views_counter_backend" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Preset view counters
 *
 * @since 1.3.9
 */
function listar_preset_view_counters_callback() {
	?>
	<input type="text" name="listar_preset_view_counters" value="" />
	
	<p class="description">
		<?php esc_html_e( 'This option is irreversible and will affect all published listings. You can insert an integer (ex.: 45) or create a random interval by using a hyphen (ex: 45-350). If an 
interval is set, every listing will receive a different amount of views.', 'listar' ) . ':<br/><br>'; ?>
	</p>
	<?php
}

/**
 * Disable bookmarks?
 *
 * @since 1.3.9
 */
function listar_bookmarks_disable_callback() {
	$input   = (int) get_option( 'listar_bookmarks_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_bookmarks_disable" name="listar_bookmarks_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Display the bookmarks counter when editing a listing on the backend?
 *
 * @since 1.3.9
 */
function listar_display_bookmarks_counter_backend_callback() {
	$input   = (int) get_option( 'listar_display_bookmarks_counter_backend' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_display_bookmarks_counter_backend" name="listar_display_bookmarks_counter_backend" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable claims?
 *
 * @since 1.4.1
 */
function listar_disable_claims_callback() {
	$input   = (int) get_option( 'listar_disable_claims' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_claims" name="listar_disable_claims" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Claim moderator email
 *
 * @since 1.4.1
 */
function listar_claim_moderator_email_callback() {
	$listar_claim_moderator_email = get_option( 'listar_claim_moderator_email' );
	?>
	<input type="text" name="listar_claim_moderator_email" value="<?php echo esc_attr( sanitize_email( $listar_claim_moderator_email ) ); ?>" placeholder="<?php esc_attr_e( 'name@domain.com', 'listar' ); ?>" />
	
	<p class="description">
		<?php esc_html_e( 'If not set, claim requests will be sent for the "Administration Email Address", set in WordPress "Settings/General"', 'listar' ); ?>
		<?php echo esc_html( ': ' . get_bloginfo( 'admin_email' ) ); ?>
	</p>
	<?php
}

/**
 * Number of characters required for claim validation text
 *
 * @since 1.4.1
 */
function listar_claim_minimum_validation_chars_callback() {
	$input        = get_option( 'listar_claim_minimum_validation_chars' );
	$input_values = array(
		array( 'none', '0' ),
		array( '50', '50' ),
		array( '100', '100' ),
		array( '150', '150' ),
		array( '250', '250' ),
		array( '350', '350' ),
		array( '500', '500' ),
		array( '750', '750' ),
		array( '1000', '1000' ),
		array( '2000', '2000' ),
	);

	if ( empty( $input ) ) {
		$input = '50';
	}
	?>

	<select name="listar_claim_minimum_validation_chars" id="listar_claim_minimum_validation_chars">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}







function listar_max_trending_listings_callback() {
	$input = esc_attr( get_option( 'listar_max_trending_listings' ) );
	
	if ( empty( $input ) ) {
		$input = 10;
	}
	
	echo '<select name="listar_max_trending_listings" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_minimum_score_to_trend_callback() {
	$input = esc_attr( get_option( 'listar_minimum_score_to_trend' ) );
	
	if ( empty( $input ) ) {
		$input = 20;
	}
	
	echo '<select name="listar_minimum_score_to_trend" />';
	for ( $i = 5; $i < 505; $i+=5 ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_most_rated_callback() {
	$input = esc_attr( get_option( 'listar_score_to_most_rated' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_most_rated" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_most_bookmarked_callback() {
	$input = esc_attr( get_option( 'listar_score_to_most_bookmarked' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_most_bookmarked" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_most_viewed_callback() {
	$input = esc_attr( get_option( 'listar_score_to_most_viewed' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_most_viewed" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_best_rated_callback() {
	$input = esc_attr( get_option( 'listar_score_to_best_rated' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_best_rated" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_featured_callback() {
	$input = esc_attr( get_option( 'listar_score_to_featured' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_featured" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

function listar_score_to_newest_callback() {
	$input = esc_attr( get_option( 'listar_score_to_newest' ) );
	
	if ( empty( $input ) ) {
		$input = 7;
	}
	
	echo '<select name="listar_score_to_newest" />';
	for ( $i = 1; $i < 101; $i ++ ) {
		if ( $input == $i || ( empty( $input ) && $i == 1) ) {
			echo '<option value="' . $i . '" selected>' . $i . '</option>';
		} else {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	echo '</select>';
}

/**
 * Preset bookmarks counters
 *
 * @since 1.3.9
 */
function listar_preset_bookmarks_counters_callback() {
	?>
	<input type="text" name="listar_preset_bookmarks_counters" value="" />
	
	<p class="description">
		<?php esc_html_e( 'This option is irreversible and will affect all published listings. You can insert an integer (ex.: 45) or create a random interval by using a hyphen (ex: 45-350). If an 
interval is set, every listing will receive a different amount of bookmarks.', 'listar' ) . ':<br/><br>'; ?>
	</p>
	<?php
}

/**
 * Disable complaint reports?
 *
 * @since 1.3.9
 */
function listar_complaint_reports_disable_callback() {
	$input   = (int) get_option( 'listar_complaint_reports_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_complaint_reports_disable" name="listar_complaint_reports_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Send reports for this email
 *
 * @since 1.3.9
 */
function listar_complaint_reports_for_callback() {
	$listar_complaint_reports_for = get_option( 'listar_complaint_reports_for' );
	?>
	<input type="text" name="listar_complaint_reports_for" value="<?php echo esc_attr( sanitize_email( $listar_complaint_reports_for ) ); ?>" placeholder="<?php esc_attr_e( 'name@domain.com', 'listar' ); ?>" />
	
	<p class="description">
		<?php esc_html_e( 'If not set, reports will be sent for the "Administration Email Address", set in WordPress "Settings/General"', 'listar' ); ?>
		<?php echo esc_html( ': ' . get_bloginfo( 'admin_email' ) ); ?>
	</p>
	<?php
}


/**
 * Who can send complaint reports?
 *
 * @since 1.3.9
 */
function listar_who_can_complaint_callback() {
	$input = get_option( 'listar_who_can_complaint' );
	$input_values = array(
		array( 'everyone', esc_html__( 'Everyone', 'listar' ) ),
		array( 'logged-users', esc_html__( 'Only logged in users', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'everyone';
	}
	?>

	<select name="listar_who_can_complaint" id="listar_who_can_complaint">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Disable required name field for not logged users?
 *
 * @since 1.3.9
 */
function listar_disable_complaint_name_field_callback() {
	$input   = (int) get_option( 'listar_disable_complaint_name_field' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_complaint_name_field" name="listar_disable_complaint_name_field" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable required email field for not logged users?
 *
 * @since 1.3.9
 */
function listar_disable_complaint_email_field_callback() {
	$input   = (int) get_option( 'listar_disable_complaint_email_field' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_complaint_email_field" name="listar_disable_complaint_email_field" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( 'The signup email is used for logged in users. A required email field is displayed for not logged in users.', 'listar' ) . ':<br/><br>'; ?>
	</p>
	<?php
}

/**
 * Disable reviews
 *
 * @since 1.3.9
 */
function listar_disable_reviews_callback() {
	$input   = (int) get_option( 'listar_disable_reviews' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_reviews" name="listar_disable_reviews" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Review categories
 *
 * @since 1.3.9
 */
function listar_review_categories_callback() {
	$input = esc_html( get_option( 'listar_review_categories' ) );
	?>
	<textarea name="listar_review_categories"><?php echo esc_html( $input ); ?></textarea>
	<p class="description">
		<?php esc_html_e( 'Enter the name of the Review categories, one per line', 'listar' ) . ':<br/><br>'; ?>
	</p>
	<?php
}

/**
 * Start the rating categories with
 *
 * @since 1.4.7
 */
function listar_start_ratings_with_callback() {
	$input = get_option( 'listar_start_ratings_with' );
	$input_values = array(
		array( '5', esc_html__( '5 stars', 'listar' ) ),
		array( '4', esc_html__( '4 stars', 'listar' ) ),
		array( '3', esc_html__( '3 stars', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = '4';
	}
	?>

	<select name="listar_start_ratings_with" id="listar_start_ratings_with">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Allow reviews without comment text
 *
 * @since 1.3.9
 */
function listar_allow_review_without_comment_callback() {
	$input   = (int) get_option( 'listar_allow_review_without_comment' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_allow_review_without_comment" name="listar_allow_review_without_comment" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Allow review submission by not logged users
 *
 * @since 1.3.9
 */
function listar_allow_visitors_submit_reviews_callback() {
	$input   = (int) get_option( 'listar_allow_visitors_submit_reviews' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_allow_visitors_submit_reviews" name="listar_allow_visitors_submit_reviews" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Allow listing review by the listing owner
 *
 * @since 1.3.9
 */
function listar_allow_owner_review_listing_callback() {
	$input   = (int) get_option( 'listar_allow_owner_review_listing' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_allow_owner_review_listing" name="listar_allow_owner_review_listing" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( 'This option affects all users, except administrators. Users with "Administrator" role can review anything.', 'listar' ) . ':<br/><br>'; ?>
	</p>
	<?php
}


/**
 * Recalculate listing review averages.
 *
 * @since 1.0
 */
function listar_recalculate_review_averages_button_callback() {
	?>
	<p class="description">
		<?php esc_html_e( 'In case some listing(s) have wrong rating average for unknown reasons, click on the link below.', 'listar' ); ?>
	</p><br />
	<a href="<?php echo esc_url( wp_nonce_url( LISTAR_ADDONS_PLUGIN_DIR_URL . 'inc/reviews/recalculate-listing-reviews.php', 'recalculate_reviews' ) ); ?>" target="_blank">
		<?php esc_html_e( 'Recalculate listing rating averages now', 'listar' ); ?>
	</a>
	<?php
}


/**
 * Disable phone number?
 *
 * @since 1.3.4
 */
function listar_phone_disable_callback() {
	$input   = (int) get_option( 'listar_phone_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_phone_disable" name="listar_phone_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable fax number?
 *
 * @since 1.3.4
 */
function listar_fax_disable_callback() {
	$input   = (int) get_option( 'listar_fax_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_fax_disable" name="listar_fax_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable mobile number?
 *
 * @since 1.3.4
 */
function listar_mobile_disable_callback() {
	$input   = (int) get_option( 'listar_mobile_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_mobile_disable" name="listar_mobile_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable whatsapp number?
 *
 * @since 1.3.4
 */
function listar_whatsapp_disable_callback() {
	$input   = (int) get_option( 'listar_whatsapp_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_whatsapp_disable" name="listar_whatsapp_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable online calls for phone number?
 *
 * @since 1.3.6
 */
function listar_phone_online_call_disable_callback() {
	$input   = (int) get_option( 'listar_phone_online_call_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_phone_online_call_disable" name="listar_phone_online_call_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable online calls for WhatsApp number?
 *
 * @since 1.3.4
 */
function listar_whatsapp_online_call_disable_callback() {
	$input   = (int) get_option( 'listar_whatsapp_online_call_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_whatsapp_online_call_disable" name="listar_whatsapp_online_call_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable online calls for mobile number?
 *
 * @since 1.3.6
 */
function listar_mobile_online_call_disable_callback() {
	$input   = (int) get_option( 'listar_mobile_online_call_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_mobile_online_call_disable" name="listar_mobile_online_call_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable website number?
 *
 * @since 1.3.4
 */
function listar_website_disable_callback() {
	$input   = (int) get_option( 'listar_website_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_website_disable" name="listar_website_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable operating hours?
 *
 * @since 1.3.4
 */
function listar_operating_hours_disable_callback() {
	$input   = (int) get_option( 'listar_operating_hours_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_operating_hours_disable" name="listar_operating_hours_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Operating hours format.
 *
 * @since 1.2.7
 */
function listar_operating_hours_format_callback() {

	$input = get_option( 'listar_operating_hours_format' );
	$input_values = array(
		array( '12', '0h - 12h' ),
		array( '24', '0h - 24h' ),
	);

	if ( empty( $input ) ) {
		$input = '24';
	}
	?>

	<select name="listar_operating_hours_format" id="listar_operating_hours_format">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Theme option field/preview output - Disable AM/PM suffix?.
 *
 * @since 1.2.8
 */
function listar_operating_hours_suffix_callback() {
	$input   = (int) get_option( 'listar_operating_hours_suffix' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_operating_hours_suffix" name="listar_operating_hours_suffix" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable Menu/Catalog?
 *
 * @since 1.3.4
 */
function listar_menu_catalog_disable_callback() {
	$input   = (int) get_option( 'listar_menu_catalog_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_menu_catalog_disable" name="listar_menu_catalog_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable appointments?
 *
 * @since 1.4.2
 */
function listar_appointments_disable_callback() {
	$input   = (int) get_option( 'listar_appointments_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_appointments_disable" name="listar_appointments_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable the recommended appointment services?
 *
 * @since 1.4.2
 */
function listar_recommended_appointment_services_disable_callback() {
	$input   = (int) get_option( 'listar_recommended_appointment_services_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_recommended_appointment_services_disable" name="listar_recommended_appointment_services_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Recommended appointments services
 *
 * @since 1.4.2
 */
function listar_recommended_appointment_services_callback() {
	$input = get_option( 'listar_recommended_appointment_services' );
	?>
	<input type="text" name="listar_recommended_appointment_services" id="listar_recommended_appointment_services" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}


/**
 * Disable Price Range?
 *
 * @since 1.3.4
 */
function listar_price_range_disable_callback() {
	$input   = (int) get_option( 'listar_price_range_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_price_range_disable" name="listar_price_range_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable Popular Price?
 *
 * @since 1.3.4
 */
function listar_popular_price_disable_callback() {
	$input   = (int) get_option( 'listar_popular_price_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_popular_price_disable" name="listar_popular_price_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable Social Networks?
 *
 * @since 1.3.4
 */
function listar_social_networks_disable_callback() {
	$input   = (int) get_option( 'listar_social_networks_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_social_networks_disable" name="listar_social_networks_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable external references?
 *
 * @since 1.3.4
 */
function listar_external_references_disable_callback() {
	$input   = (int) get_option( 'listar_external_references_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_external_references_disable" name="listar_external_references_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable reviews/comments section?
 *
 * @since 1.3.4
 */
function listar_reviews_section_disable_callback() {
	$input   = (int) get_option( 'listar_reviews_section_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_reviews_section_disable" name="listar_reviews_section_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Minimum height to turn an accordion section scrollable
 *
 * @since 1.4.5
 */

function listar_accordion_scrollable_after_callback() {
	$input = get_option( 'listar_accordion_scrollable_after' );
	?>
	<input type="text" name="listar_accordion_scrollable_after" value="<?php echo esc_attr( $input ); ?>" placeholder="320" px
	<?php
}


/**
 * Allow multiple regions for listings on Front End
 *
 * @since 1.3.1
 */
function listar_allow_multiple_regions_frontend_callback() {
	$input   = (int) get_option( 'listar_allow_multiple_regions_frontend' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_allow_multiple_regions_frontend" name="listar_allow_multiple_regions_frontend" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Theme option field/preview output - Default region to search.
 *
 * @since 1.0
 */
function listar_default_region_search_callback() {
	$input          = get_option( 'listar_default_region_search' );
	$input_values   = array();
	$input_values[] = '';
	
	$num_terms = wp_count_terms( 'job_listing_region', array(
		'hide_empty'=> false,
	) );
	
	if ( $num_terms > 100 ) :
		$tip = esc_html__( 'Enter a region ID', 'listar' );
		?>
		<input type="text" class="listar-manual-default-region" name="listar_default_region_search" id="listar_default_region_search" value="<?php echo esc_attr( $input ); ?>" />

		<?php echo '<p class="description">' . wp_kses( $tip, 'listar-basic-html' ) . '</p>'; ?>
		<?php
	else :
		$listing_regions = get_terms(
			array(
				'taxonomy'   => 'job_listing_region',
				'hide_empty' => true,
			)
		);
	
		if ( is_numeric( $input ) ) {
			$term_name = get_term( $input );
			
			if ( isset( $term_name->name ) && ! empty( $term_name->name ) ) {
				$input = $term_name->name;
			} else {
				$input = '';
			}
		}

		if ( $listing_regions && ! is_wp_error( $listing_regions ) ) :
			foreach ( $listing_regions as $listing_region ) :
				$input_values[] = $listing_region->name;
			endforeach;
		endif;
		?>

		<select name="listar_default_region_search" id="listar_default_region_search">

			<?php
			$count = is_array( $input_values ) ? count( $input_values ) : 0;

			for ( $i = 0; $i < $count; $i++ ) :
				$option_name = $input_values[ $i ];
				$option_value = $option_name;

				if ( '' === $option_name ) {
					$option_name = esc_html__( 'None', 'listar' );
				}

				$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
				?>
				<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
					<?php echo esc_html( $option_name ); ?>
				</option>
				<?php
			endfor;
			?>

		</select>
		<?php
	endif;
}


/**
 * After select a region on hero header search and popup
 *
 * @since 1.3.0
 */
function listar_after_region_selected_callback() {
	
	$input = get_option( 'listar_after_region_selected' );
	$input_values = array(
		array( 'search-immediately', esc_html__( 'Search immediately', 'listar' ) ),
		array( 'wait-input', esc_html__( 'Wait for input', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'search-immediately';
	}
	?>

	<select name="listar_after_region_selected" id="listar_after_region_selected">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Listing/directory and its resources *****************************************
 */

/**
 * Postpone listing card contents on archive pages, make it load if visible on the screen
 *
 * @since 1.3.9
 */
function listar_load_listing_card_content_ajax_callback() {
	$input   = (int) get_option( 'listar_load_listing_card_content_ajax' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_load_listing_card_content_ajax" name="listar_load_listing_card_content_ajax" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Automatic cache cleaning
 *
 * @since 1.2.9
 */
function listar_automatic_cache_cleaning_callback() {
	$input = get_option( 'listar_automatic_cache_cleaning' );
	$input_values = array(
		array( '900','15 ' . esc_html__( 'minutes', 'listar' ) ),
		array( '1800','30 ' . esc_html__( 'minutes', 'listar' ) ),
		array( '3600','1 ' . esc_html__( 'hour', 'listar' ) ),
		array( '7200','2 ' . esc_html__( 'hours', 'listar' ) ),
		array( '14400','4 ' . esc_html__( 'hours', 'listar' ) ),
		array( '28800','8 ' . esc_html__( 'hours', 'listar' ) ),
		array( '57600','16 ' . esc_html__( 'hours', 'listar' ) ),
		array( '86400','1 ' . esc_html__( 'day', 'listar' ) ),
		array( '172800','2 ' . esc_html__( 'days', 'listar' ) ),
		array( '432000','5 ' . esc_html__( 'days', 'listar' ) ),
		array( '864000','10 ' . esc_html__( 'days', 'listar' ) ),
		array( '2592000','30 ' . esc_html__( 'days', 'listar' ) ),
		array( '7776000','90 ' . esc_html__( 'days', 'listar' ) ),
		array( '15552000','180 ' . esc_html__( 'days', 'listar' ) ),
		array( '31104000','360 ' . esc_html__( 'days', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = '31104000';
	}
	?>

	<select name="listar_automatic_cache_cleaning" id="listar_automatic_cache_cleaning">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	
	<p class="description">
		<?php
		$autoptimize_active = false && class_exists( 'autoptimizeCache' ) ? esc_html__( 'activated', 'listar' ) : esc_html__( 'not activated', 'listar' );
		$wp_fastest_cache_active = function_exists( 'wpfastestcache_activate' ) ? esc_html__( 'activated', 'listar' ) : esc_html__( 'not activated', 'listar' );
		
		$autoptimize_link = false && class_exists( 'autoptimizeCache' ) ? true : admin_url( '/themes.php?page=tgmpa-install-plugins' );
		$wp_fastest_cache_link = function_exists( 'wpfastestcache_activate' ) ? true : admin_url( '/themes.php?page=tgmpa-install-plugins' );
		
		esc_html_e( 'This option works only with the following plugins:', 'listar' ); ?><br>
		
		<?php
		if ( true === $autoptimize_link && 0 === 1 ) :
			?>
			Autoptimize (<?php echo esc_html( $autoptimize_active ); ?>)<br>
			<?php
		else :
			?>
			<!--<a href="<?php echo esc_url( $autoptimize_link ); ?>" target="_blank">Autoptimize</a> (<?php echo esc_html( $autoptimize_active ); ?>)<br>-->
			<?php
		endif;
		?>
		
		<?php
		if ( true === $wp_fastest_cache_link ) :
			?>
			WP Fastest Cache (<?php echo esc_html( $wp_fastest_cache_active ); ?>)
			<?php
		else :
			?>
			<a href="<?php echo esc_url( $wp_fastest_cache_link ); ?>" target="_blank">WP Fastest Cache</a> (<?php echo esc_html( $wp_fastest_cache_active ); ?>)
			<?php
		endif;
		?>
		
	</p><br />

	<?php
}

/**
 * Do not delete cache every time contents are handled.
 *
 * @since 1.4.7
 */
function listar_keep_cache_on_changes_callback() {
	$input   = (int) get_option( 'listar_keep_cache_on_changes' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_keep_cache_on_changes" name="listar_keep_cache_on_changes" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	
	<p class="description">
		<?php esc_html_e( 'Saves memory consumption on your server, but requires manual cleaning of cache.', 'listar' ); ?>
	</p><br />
	<?php
}


/**
 * Reset last cache cleaning time.
 *
 * @since 1.2.9
 */
function listar_reset_last_cache_cleaning_time_callback() {
	$input   = (int) get_option( 'listar_reset_last_cache_cleaning_time' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_reset_last_cache_cleaning_time" name="listar_reset_last_cache_cleaning_time" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Pagespeed To Do List
 *
 * @since 1.3.0
 */
function listar_todo_pagespeed_callback() {
	$php_version = phpversion();
	$php_version_int = (int) $php_version[0];
	$upgrade_php_alert = '';
	$cache_object = listar_available_object_caches();
	$has_cache_object = false;
	$has_modern_php = false;
	$has_smush = false;
	$has_autoptimize = false;
	$has_wp_fastest_cache_cache = false;
	$has_async_javascript = false;
	$htaccess_file = ABSPATH . '.htaccess';
	$is_htaccess_writable = false;
	
	if ( file_exists( $htaccess_file ) ) {
		$is_htaccess_writable = is_writable( $htaccess_file );
	}
	
	if ( $php_version_int < 7 ) {
		$has_modern_php = false;
		$upgrade_php_alert = esc_html__( 'For better performance, it is strongly recommended to upgrade your PHP version at least to 7.2.' );
	} else {
		$has_modern_php = true;
	}
	
	if ( 'off' === $cache_object ) {
		$has_cache_object = false;
		$cache_object = esc_html__( 'no cache object active currently. Try to contact your server, it will be great for your site.' );
	} else {
		$has_cache_object = true;
	}
	
	if ( defined( 'WP_SMUSH_API' ) ) {
		$has_smush = true;
	}

	if ( class_exists( 'autoptimizeCache' ) && false ) {
		$has_autoptimize = true;
	}

	if ( function_exists( 'wpfastestcache_activate' ) ) {
		$has_wp_fastest_cache_cache = true;
	}

	if ( class_exists( 'AsyncJavaScriptBackend' ) ) {
		$has_async_javascript = true;
	}
	
	$has_cache_object_class = $has_cache_object ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$has_modern_php_class = $has_modern_php ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$has_smush_class = $has_smush ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$has_autoptimize_class = $has_autoptimize ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$has_wp_fastest_cache_cache_class = $has_wp_fastest_cache_cache ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$has_async_javascript_class = $has_async_javascript ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$is_listing_archive_loading_postponed = 1 === (int) get_option( 'listar_load_listing_card_content_ajax' );
	$has_loading_postponed_class = $is_listing_archive_loading_postponed ? 'listar-pagespeed-resource-active dashicons-backup' : 'listar-pagespeed-resource-inactive dashicons-backup';
	$base64_favicon = esc_html( get_option( 'listar_base64_favicon_32x32' ) );
	$has_base64_favicon = ! empty( $base64_favicon ) ? listar_is_base64_image( $base64_favicon ) : false;
	$base64_favicon_class = $has_base64_favicon ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$is_htaccess_writable_class = $is_htaccess_writable ? 'listar-pagespeed-resource-active dashicons-yes-alt' : 'listar-pagespeed-resource-inactive dashicons-dismiss';
	$is_listar_pagespeed_active = 1 === (int) get_option( 'listar_activate_pagespeed' );
	$has_listar_pagespeed_class = $is_listar_pagespeed_active ? 'listar-pagespeed-resource-active dashicons-dashboard' : 'listar-pagespeed-resource-inactive dashicons-dashboard';
	?>
	<div class="listar-pagespeed-info">
		<p>
			<strong>
				<?php esc_html_e( 'Your current PHP Version is', 'listar' ); ?>: 
			</strong>
			<strong class="listar-red-alert">
				<?php echo esc_html( $php_version . '. ' ); ?>
				<?php echo esc_html( $upgrade_php_alert ); ?>
			</strong>
		</p>
		<p>
			<strong>
				<?php esc_html_e( 'Your cache object is', 'listar' ); ?>: 
			</strong>
			<strong class="listar-red-alert">
				<?php echo esc_html( $cache_object ); ?>
			</strong>
		</p>
		<br />
		<p class="listar-pagespeed-todo-alert">
			<?php esc_html_e( "Below you can set the most relevant Pagespeed configurations. These resouces were gattered into Listar core, you don't need do to anything else. In other words: everything is automatic from here. But, before enable it, check 
		your To Do list", 'listar' ); ?>: 
		</p>
		
		<div class="listar-pagespeed-todo-list">
			<ol>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_modern_php_class ) ); ?>">
					<span>
						<?php esc_html_e( 'Contact your server and upgrade your PHP version to the highest available, possibly 7.3 or latter (or 7.2 at least).', 'listar' ); ?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $is_htaccess_writable_class ) ); ?>">
					<span>
						<?php esc_html_e( 'The .htaccess file inside the root folder of your WordPress install (the same folder of wp-config.php) must be writable.', 'listar' ); ?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_cache_object_class ) ); ?>">
					<span>
						<?php esc_html_e( 'Ask your server to activate any of these cache objects: APCu, Memcache, Memcached, or Redis.', 'listar' ); ?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_smush_class ) ); ?>">
					<span>
						<?php
						$link = $has_smush ? 'Smush plugin' : '<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">Smush</a>';
					
						printf(
							/* TRANSLATORS: A plugin name or link, ex: Autoptimize */
							wp_kses( __( 'Install and Activate %s, no need to configure it.', 'listar' ), 'listar-basic-html' ),
							$link
						);
						?>
					</span>
				</li>
				<?php
				/*

				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_autoptimize_class ) ); ?>">
					<span>
						<?php
						$link2 = $has_autoptimize ? 'Autoptimize' : '<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">Autoptimize</a>';
					
						printf(
							// TRANSLATORS: A plugin name or link, ex: Autoptimize.
							wp_kses( __( 'Install and Activate %s, no need to configure it.', 'listar' ), 'listar-basic-html' ),
							$link2
						);
						?>
					</span>
				</li>
				*/
				?>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_wp_fastest_cache_cache_class ) ); ?>">
					<span>
						<?php
						$link3 = $has_wp_fastest_cache_cache ? 'WP Fastest Cache' : '<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">WP Fastest Cache</a>';
					
						printf(
							/* TRANSLATORS: A plugin name or link, ex: Autoptimize */
							wp_kses( __( 'Install and Activate %s, no need to configure it.', 'listar' ), 'listar-basic-html' ),
							$link3
						);
						?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_async_javascript_class ) ); ?>">
					<span>
						<?php
						$link4 = $has_async_javascript ? 'Async Javascript' : '<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">Async Javascript</a>';
					
						printf(
							/* TRANSLATORS: A plugin name or link, ex: Autoptimize */
							wp_kses( __( 'Install and Activate %s, no need to configure it.', 'listar' ), 'listar-basic-html' ),
							$link4
						);
						?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $base64_favicon_class ) ); ?>">
					<span>
						<?php esc_html_e( 'Use an encoded 32x32px Base64 image as Favicon.', 'listar' ); ?>
					</span>
					<div class="listar-pagespeed-favicon-field-show">
						<a href="#">
							<i class="dashicons dashicons-format-image"></i> <?php esc_html_e( 'Edit Favicon', 'listar' ); ?>
						</a>
					</div>
					<div class="listar-show-favicon64-field hidden"></div>
				</li>
				<li class="listar-pagespeed-resource-active dashicons-warning">
					<span>
						<?php
						printf(
							/* TRANSLATORS: An internal WordPress admin link for Smush plugin. */
							wp_kses( __( 'Run %s plugin for all images.', 'listar' ), 'listar-basic-html' ),
							$has_smush ? '<a href="' . network_site_url( '/wp-admin/admin.php?page=smush' ) . '" target="_blank">Smush</a>' : 'Smush'
						);
						?>
					</span>
				</li>
				<li class="listar-pagespeed-resource-active dashicons-warning">
					<span>
						<?php esc_html_e( "Don't overfill your front page with a lot of widgets or high amount of posts/blocks. You can take our own theme preview as reference.", 'listar' ); ?>
					</span>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_loading_postponed_class ) ); ?>">
					<span>
						<?php esc_html_e( 'Postpone listing card contents on archive pages, make it load only if visible on the screen.', 'listar' ); ?>
					</span>
					<div class="listar-pagespeed-field-postpone"></div>
				</li>
				<li class="<?php echo esc_attr( listar_sanitize_html_class( $has_listar_pagespeed_class ) ); ?>">
					<span>
						<?php esc_html_e( 'All done? Now you are ready to activate Listar Pagespeed.', 'listar' ); ?>
					</span>
					<div class="listar-pagespeed-field"></div>
				</li>
				<?php
				if ( ! $is_listar_pagespeed_active ) :
					?>
					<li class="listar-pagespeed-resource-active dashicons-warning">
						<span>
							<?php esc_html_e( 'Return here after Enable Listar Pagespeed.', 'listar' ); ?>
						</span>
					</li>
					<?php
				else :
					$has_wp_fastest_cache_cache_class = str_replace( array( 'dashicons-dismiss', 'dashicons-yes-alt' ), 'dashicons-database-add', $has_wp_fastest_cache_cache_class );
					
					if ( $has_wp_fastest_cache_cache && $has_autoptimize && $has_async_javascript ) :
						?>
						<li class="listar-pagespeed-resource-active dashicons-database-remove">
							<span>
								<?php esc_html_e( 'Reset the cache if not empty.', 'listar' ); ?>
							</span>
							<div class="listar-pagespeed-field-cache-cleaner">
								<a href="#">
									<i class="dashicons dashicons-admin-collapse"></i> <?php esc_html_e( 'Delete cache', 'listar' ); ?>
								</a>
							</div>
						</li>
						<?php
					endif;
					?>
					<li class="dashicons-database-add <?php echo esc_attr( listar_sanitize_html_class( $has_wp_fastest_cache_cache_class ) ); ?>">
						<span>
							<?php
							esc_html_e( "Listar's Automatic Cache Generator.", 'listar' );
							
							if ( ! $has_wp_fastest_cache_cache || ! $has_autoptimize || ! $has_async_javascript ) :
								?>
								<br />
								<?php
								printf(
									/* TRANSLATORS: 1: A plugin name or link, ex: Autoptimize, 2: A plugin name or link, ex: Autoptimize, 3: A plugin name or link, ex: Autoptimize */
									wp_kses( __( 'Requires the activation of: %1$s, %2$s and %3$s.', 'listar' ), 'listar-basic-html' ),
									'<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">Autoptimize</a>',
									'<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">WP Fastest Cache</a>',
									'<a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">Async Javascript</a>'
								);
							endif;
							?>
						</span>
						<?php
						if ( $has_wp_fastest_cache_cache && $has_autoptimize && $has_async_javascript ) :
							?>
							<div class="listar-pagespeed-field-cacher-info">
								<?php esc_html_e( 'Now that Listar Pagespeed is active, an automatic routine will constantly visit and generate cache for the most important pages of your site, by order of relevance.', 'listar' ); ?>
								<br><br>
								<?php esc_html_e( 'Most sites will get smootly cached in 2 hours: the lightweight caching process happens while you keep working, even after cleaning the cache, always respecting your server limits.', 'listar' ); ?>
								
								<?php
								$input = (int) get_option( 'listar_keep_cache_on_changes' );
								
								if ( 1 !== $input ) :
									?>
									<br><br>
									<?php esc_html_e( 'And when any content is created, edited or deleted, all cache will be cleaned, but it will be renewed automatically too.', 'listar' ); ?>
									<?php
								endif;
								?>
							</div>
							<?php
						endif;
						?>
					</li>
					<?php
				endif;
				?>
			</ol>
		</div>
	</div>
	<?php
}

/**
 * Image quality for hero images on mobile devices
 *
 * @since 1.4.1
 */
function listar_image_size_mobile_callback() {
	$input = get_option( 'listar_image_size_mobile' );
	$input_values = array(
		array( 'listar-hero-mobile', esc_html__( 'Default', 'listar' ) ),
		array( 'listar-cover', esc_html__( 'High', 'listar' ) ),
		array( 'listar-hero-mobile-tall', esc_html__( 'Taller (vertical)', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'listar-hero-mobile';
	}
	?>

	<select name="listar_image_size_mobile" id="listar_image_size_mobile">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Force a Base64 encoded image as 32x32px Favicon
 *
 * @since 1.3.6
 */
function listar_base64_favicon_32x32_callback() {
	$input = esc_html( get_option( 'listar_base64_favicon_32x32' ) );
	?>
	<textarea name="listar_base64_favicon_32x32"><?php echo esc_html( $input ); ?></textarea>
	<p class="description">
		<?php
		printf(
			/* TRANSLATORS: A URL to a Base64 image generator website. */
			wp_kses( __( 'Go to %s, upload a 32x32px JPG or PNG image to generate a Base64 encoded Favicon. Copy the image code and paste above.', 'listar' ), 'listar-basic-html' ),
			'<a target="_blank" href="' . esc_url( 'https://www.base64-image.de/' ) . '">' . esc_html__( 'this site', 'listar' ) . '</a>'
		);

		echo ' ' . esc_html__( 'Example', 'listar' ) . ':<br/><br>';
		?>
	<code class="listar-base64-code-example">data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAjVBMVEU1XrA2XrE3YLD///82X68yW68wWa4pVKzp7fY0Xq4mUqozXLD3+Pzu8vhWeL09ZLM6YrKkt9yhtdtKb7n7/P/6+//w8/nP2ezJ1OqxwOCKodB7lsxdfb8+ZbQsVq3r7/ji6PTk6PPf5fPX3vDL2Ouqutycr9mQp9OOpNOCnM11kspPdLtFa7Y3X7RCaLM5eC5uAAAAt0lEQVQY0zVPB44DMQg0zbhs3/R2l97z/+fF3lUQgkGImcGMwSJs/ABhqHFbxx+GnPE4twmMgQhSz/7QA2K+khAE6tIhxhBimpt2VQeYOQnbVddEY58TKi9V6aqupKK3xku1LKiYTKdULCvhZGEX+qsjcrc+WM4q70Z5T3SQXTMqs/cn6lpaiOfRmZ5pYWVOrSKAAdQ7/X+ivBytFbNRXbuNMurGPRSHR6y1mBapZQ6fWBkyFXCev3TWCMOgPwLkAAAAAElFTkSuQmCC</code>
	</p>
	<?php
}

/**
 * Enable Listar Pagespeed
 *
 * @since 1.3.0
 */
function listar_activate_pagespeed_callback() {
	$input   = (int) get_option( 'listar_activate_pagespeed' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_activate_pagespeed" name="listar_activate_pagespeed" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Force light design
 *
 * @since 1.4.8
 */
function listar_force_light_design_callback() {
	$input = get_option( 'listar_force_light_design' );
	$input_values = array(
		array( 'disabled', esc_html__( 'Disabled', 'listar' ) ),
		array( 'partial', esc_html__( 'Partial', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'disabled';
	}
	?>
	<select name="listar_force_light_design" id="listar_force_light_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<p class="description">
		<?php esc_html_e( "Notice: this will overwrite other design options to force minimalist colors and shapes.", 'listar' ); ?>
	</p>
	<?php
}


/**
 * Design for listing cards
 *
 * @since 1.0
 */
function listar_listing_card_design_callback() {
	$input = get_option( 'listar_listing_card_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded Preview Image', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared Preview Image', 'listar' ) ),
		array( 'rounded-image-block', esc_html__( 'Rounded Image Block', 'listar' ) ),
		array( 'squared-image-block', esc_html__( 'Squared Image Block', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>
	<select name="listar_listing_card_design" id="listar_listing_card_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<?php
}

/**
 * Design for blog cards
 *
 * @since 1.0
 */
function listar_blog_card_design_callback() {
	$input = get_option( 'listar_blog_card_design' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'default';
	}
	?>

	<select name="listar_blog_card_design" id="listar_blog_card_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Design for Woocommerce cards
 *
 * @since 1.0
 */
function listar_woo_card_design_callback() {
	$input = get_option( 'listar_woo_card_design' );
	$input_values = array(
		array( 'rounded-image-block-top', esc_html__( 'Rounded Image Block (Tall)', 'listar' ) . ', ' . esc_html__( 'Data on the Top', 'listar' ) ),
		array( 'rounded-image-block-bottom', esc_html__( 'Rounded Image Block (Tall)', 'listar' ) . ', ' . esc_html__( 'Data on the Bottom', 'listar' ) ),
		array( 'squared-image-block-top', esc_html__( 'Squared Image Block (Tall)', 'listar' ) . ', ' . esc_html__( 'Data on the Top', 'listar' ) ),
		array( 'squared-image-block-bottom', esc_html__( 'Squared Image Block (Tall)', 'listar' ) . ', ' . esc_html__( 'Data on the Bottom', 'listar' ) ),
		array( 'rounded-image-block-short-top', esc_html__( 'Rounded Image Block (Short)', 'listar' ) . ', ' . esc_html__( 'Data on the Top', 'listar' ) ),
		array( 'rounded-image-block-short-bottom', esc_html__( 'Rounded Image Block (Short)', 'listar' ) . ', ' . esc_html__( 'Data on the Bottom', 'listar' ) ),
		array( 'squared-image-block-short-top', esc_html__( 'Squared Image Block (Short)', 'listar' ) . ', ' . esc_html__( 'Data on the Top', 'listar' ) ),
		array( 'squared-image-block-short-bottom', esc_html__( 'Squared Image Block (Short)', 'listar' ) . ', ' . esc_html__( 'Data on the Bottom', 'listar' ) ),
		array( 'default', esc_html__( 'Same of Listing Cards', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded-image-block-top';
	}
	?>
	<select name="listar_woo_card_design" id="listar_woo_card_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<?php
}


/**
 * Design for Woocommerce cards
 *
 * @since 1.0
 */
function listar_woo_product_image_design_callback() {
	$input = get_option( 'listar_woo_product_image_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_woo_product_image_design" id="listar_woo_product_image_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for pricing cards
 *
 * @since 1.4.0.1
 */
function listar_pricing_cards_design_callback() {
	$input        = get_option( 'listar_pricing_cards_design' );
	$input_values = array(
		array( 'light', esc_html__( 'Light', 'listar' ) ),
		array( 'dark', esc_html__( 'Dark', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'light';
	}
	?>

	<select name="listar_pricing_cards_design" id="listar_pricing_cards_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for directory terms
 *
 * @since 1.0
 */
function listar_taxonomy_terms_design_callback() {
	$input = get_option( 'listar_taxonomy_terms_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_taxonomy_terms_design" id="listar_taxonomy_terms_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for partner cards
 *
 * @since 1.0
 */
function listar_partner_cards_design_callback() {
	$input = get_option( 'listar_partner_cards_design' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'default';
	}
	?>

	<select name="listar_partner_cards_design" id="listar_partner_cards_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for feature cards
 *
 * @since 1.0
 */
function listar_feature_cards_design_callback() {
	$input = get_option( 'listar_feature_cards_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_feature_cards_design" id="listar_feature_cards_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for directory terms
 *
 * @since 1.0
 */
function listar_single_listing_gallery_design_callback() {
	$input = get_option( 'listar_single_listing_gallery_design' );
	$input_values = array(
		array( 'slideshow-rounded', esc_html__( 'Slideshow, circular thumbnails', 'listar' ) ),
		array( 'slideshow-squared', esc_html__( 'Slideshow, squared thumbnails', 'listar' ) ),
		array( 'tiny-rounded', esc_html__( 'Circular, boxed', 'listar' ) ),
		array( 'tiny-rounded-dark', esc_html__( 'Circular, boxed, dark', 'listar' ) ),
		array( 'rounded-boxed', esc_html__( 'Oval, boxed', 'listar' ) ),
		array( 'rounded-boxed-dark', esc_html__( 'Oval, boxed, dark', 'listar' ) ),
		array( 'rounded', esc_html__( 'Oval, wide', 'listar' ) ),
		array( 'rounded-dark', esc_html__( 'Oval, wide, dark', 'listar' ) ),
		array( 'squared-boxed', esc_html__( 'Rectangular, boxed', 'listar' ) ),
		array( 'squared-boxed-dark', esc_html__( 'Rectangular, boxed, dark', 'listar' ) ),
		array( 'squared', esc_html__( 'Rectangular, wide', 'listar' ) ),
		array( 'squared-dark', esc_html__( 'Rectangular, wide, dark', 'listar' ) ),
		array( 'tiny-squared', esc_html__( 'Squared, boxed', 'listar' ) ),
		array( 'tiny-squared-dark', esc_html__( 'Squared, boxed, dark', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'slideshow-rounded';
	}
	?>

	<select name="listar_single_listing_gallery_design" id="listar_single_listing_gallery_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for pricing ranges on single listing page
 *
 * @since 1.0
 */
function listar_single_listing_pricing_range_design_callback() {
	$input = get_option( 'listar_single_listing_pricing_range_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_single_listing_pricing_range_design" id="listar_single_listing_pricing_range_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for header category buttons
 *
 * @since 1.9
 */
function listar_hero_categories_design_callback() {
	$input = get_option( 'listar_hero_categories_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
		array( 'marker', esc_html__( 'Marker', 'listar' ) ),
		array( 'rounded-and-marker', esc_html__( 'Rounded, marker on hover', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_hero_categories_design" id="listar_hero_categories_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for listing search input field
 *
 * @since 1.0
 */
function listar_listing_search_input_field_design_callback() {
	$input = get_option( 'listar_listing_search_input_field_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_listing_search_input_field_design" id="listar_listing_search_input_field_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for thumbnails on Recent Posts widget
 *
 * @since 1.0
 */
function listar_recent_post_thumbnail_design_callback() {
	$input = get_option( 'listar_recent_post_thumbnail_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_recent_post_thumbnail_design" id="listar_recent_post_thumbnail_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for buttons
 *
 * @since 1.0
 */
function listar_user_avatar_design_callback() {
	$input = get_option( 'listar_user_avatar_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_user_avatar_design" id="listar_user_avatar_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for buttons
 *
 * @since 1.0
 */
function listar_buttons_design_callback() {
	$input = get_option( 'listar_buttons_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_buttons_design" id="listar_buttons_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for Launch Map button
 *
 * @since 1.3.0
 */
function listar_launch_map_button_design_callback() {
	$input = get_option( 'listar_launch_map_button_design' );
	$input_values = array(
		array( 'light', esc_html__( 'Light', 'listar' ) ),
		array( 'dark', esc_html__( 'Dark', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'light';
	}
	?>

	<select name="listar_launch_map_button_design" id="listar_launch_map_button_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for Listing View button for maps
 *
 * @since 1.3.0
 */
function listar_listing_view_button_design_callback() {
	$input = get_option( 'listar_listing_view_button_design' );
	$input_values = array(
		array( 'light', esc_html__( 'Light', 'listar' ) ),
		array( 'dark', esc_html__( 'Dark', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'light';
	}
	?>

	<select name="listar_listing_view_button_design" id="listar_listing_view_button_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for images on posts
 *
 * @since 1.0
 */
function listar_post_images_design_callback() {
	$input = get_option( 'listar_post_images_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'squared';
	}
	?>

	<select name="listar_post_images_design" id="listar_post_images_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for region filter on listing search field
 *
 * @since 1.0
 */
function listar_listing_search_input_filter_design_callback() {
	$input = get_option( 'listar_listing_search_input_filter_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_listing_search_input_filter_design" id="listar_listing_search_input_filter_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for listing average rating
 *
 * @since 1.0
 */
function listar_listing_rating_design_callback() {
	$input = get_option( 'listar_listing_rating_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_listing_rating_design" id="listar_listing_rating_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for big average rating on single listing pages
 *
 * @since 1.0
 */
function listar_single_listing_big_rating_design_callback() {
	$input = get_option( 'listar_single_listing_big_rating_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_single_listing_big_rating_design" id="listar_single_listing_big_rating_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for average rating mood and counter on single listing pages
 *
 * @since 1.0
 */
function listar_single_listing_mood_design_callback() {
	$input = get_option( 'listar_single_listing_mood_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_single_listing_mood_design" id="listar_single_listing_mood_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>
	</select>

	<?php
}

/**
 * Design for social network icons
 *
 * @since 1.0
 */
function listar_social_network_icons_design_callback() {
	$input = get_option( 'listar_social_network_icons_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_social_network_icons_design" id="listar_social_network_icons_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for listing thumbnails on map sidebar
 *
 * @since 1.0
 */
function listar_map_sidebar_listing_thumbnail_design_callback() {
	$input = get_option( 'listar_map_sidebar_listing_thumbnail_design' );
	$input_values = array(
		array( 'rounded', esc_html__( 'Rounded', 'listar' ) ),
		array( 'squared', esc_html__( 'Squared', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rounded';
	}
	?>

	<select name="listar_map_sidebar_listing_thumbnail_design" id="listar_map_sidebar_listing_thumbnail_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Max number of results for search
 *
 * @since 1.5.2
 */
function listar_max_results_search_callback() {
	$input = (int) get_option( 'listar_max_results_search' );

	if ( empty( $input ) ) {
		$input = 500;
	}
	?>
	<input type="text" name="listar_max_results_search" value="<?php echo esc_attr( $input ); ?>" placeholder="500" />

	<p class="description">
		<?php esc_html_e( "It is recommended to avoid a high amount.", 'listar' ); ?><br/>
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing tags
 *
 * @since 1.5.2
 */
function listar_use_search_listing_tags_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_tags_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_tags_data" name="listar_use_search_listing_tags_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="description">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "This will enable a text field to input search keywords when creating a listing.", 'listar' ); ?><br/>
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing location (address)
 *
 * @since 1.5.2
 */
function listar_use_search_listing_location_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_location_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_location_data" name="listar_use_search_listing_location_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="description">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing raw
 *
 * @since 1.5.2
 */
function listar_use_search_listing_raw_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_raw_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_raw_data" name="listar_use_search_listing_raw_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="description">
		<?php esc_html_e( "Listings created before Listar v1.5.1 need to be re-saved.", 'listar' ); ?><br/>	
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Enable other listing data for searches, e.g: Pricing Menu texts, Subtitle, Tagline.", 'listar' ); ?><br/>
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing description
 *
 * @since 1.5.2
 */
function listar_use_search_listing_description_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_description_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_description_data" name="listar_use_search_listing_description_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="description">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing category names
 *
 * @since 1.5.2
 */
function listar_use_search_listing_category_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_category_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_category_data" name="listar_use_search_listing_category_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="category">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing region names
 *
 * @since 1.5.2
 */
function listar_use_search_listing_region_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_region_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_region_data" name="listar_use_search_listing_region_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="region">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Search on listing amenity names
 *
 * @since 1.5.2
 */
function listar_use_search_listing_amenity_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_amenity_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_amenity_data" name="listar_use_search_listing_amenity_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="amenity">
		<?php esc_html_e( "By default, only listing titles are used for searches.", 'listar' ); ?><br/>	
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Show featured listings as first results when ordering by Newest
 *
 * @since 1.5.2
 */
function listar_use_search_listing_featured_data_callback() {
	$input   = (int) get_option( 'listar_use_search_listing_featured_data' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_search_listing_featured_data" name="listar_use_search_listing_featured_data" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>

	<p class="featured">
		<?php esc_html_e( "Search may get slower on cheap/shared/poor servers and/or for high amount of listings.", 'listar' ); ?><br/>
	</p>
	<?php
}


/**
 * Show search button on front page top bar
 *
 * @since 1.3.6
 */
function listar_activate_search_button_front_callback() {
	$input   = (int) get_option( 'listar_activate_search_button_front' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_activate_search_button_front" name="listar_activate_search_button_front" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable search field on front page header?
 *
 * @since 1.3.6
 */
function listar_disable_hero_search_front_callback() {
	$input   = (int) get_option( 'listar_disable_hero_search_front' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_hero_search_front" name="listar_disable_hero_search_front" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Public label for primary reference location
 *
 * @since 1.3.8
 */
function listar_last_theme_options_screen_callback() {
	$input = get_option( 'listar_last_theme_options_screen' );
	?>
	<input type="text" name="listar_last_theme_options_screen" id="listar_last_theme_options_screen" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}


/**
 * Disable hero categories under search field on front page
 *
 * @since 1.3.4
 */
function listar_disable_hero_search_categories_front_callback() {
	$input   = (int) get_option( 'listar_disable_hero_search_categories_front' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_hero_search_categories_front" name="listar_disable_hero_search_categories_front" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable hero categories under search field on search popup
 *
 * @since 1.3.4
 */
function listar_disable_hero_search_categories_popup_callback() {
	$input   = (int) get_option( 'listar_disable_hero_search_categories_popup' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_hero_search_categories_popup" name="listar_disable_hero_search_categories_popup" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Hero categories under search field.
 *
 * @since 1.0
 */
function listar_hero_search_categories_callback() {

	$input         = esc_html( get_option( 'listar_hero_search_categories' ) );
	$empty_input   = 0;
	$temp_array    = array();
	$current_terms = '';
	$temp_elems    = array();
	$tip           = esc_html__( 'Drag and drop checked categories to reorder or check/uncheck to toggle its visibility', 'listar' );

	if ( empty( $input ) ) {
		$empty_input = 1;
	}

	/* Currently, variable $input contains (example): '1 1,2 0,3 0,4 1,5 1,' */
	if ( false !== strpos( $input, ',' ) && ! $empty_input ) {
		if ( ',' === substr( rtrim( $input ), -1 ) ) {
			$input = substr( $input, 0, -1 );
		}
		if ( false !== strpos( $input, ',' ) ) {
			$temp_array = explode( ',', $input );
		}
	}

	if ( ! count( $temp_array ) && ! $empty_input ) {
		$temp_array[] = $input;
	}

	if ( ! $empty_input ) {

		$count = is_array( $temp_array ) ? count( $temp_array ) : 0;

		for ( $i = 0; $i < $count; $i++ ) {
			if ( '0' !== $temp_array[ $i ] && ' 0' !== $temp_array[ $i ] ) {
				$temp_array[ $i ] = explode( ' ', $temp_array[ $i ], 2 );
				$temp_elems[]     = $temp_array[ $i ];
				$current_terms   .= $temp_array[ $i ][0] . ',';
			}
		}
	}

	$input_array = $temp_elems;

	if ( false !== strpos( $current_terms, ',' ) ) {
		if ( ',' === substr( rtrim( $current_terms ), -1 ) ) {
			$current_terms = substr( $current_terms, 0, -1 );
		}
	}

	$has_terms = get_terms(
		array(
			'taxonomy'   => 'job_listing_category',
			'hide_empty' => false,
		)
	);

	if ( empty( $has_terms ) || is_wp_error( $has_terms ) ) :
		$tip = esc_html__( 'No listing categories set', 'listar' ) . ', <a href="' . esc_url( admin_url( '/edit-tags.php?taxonomy=job_listing_category&post_type=job_listing' ) ) . '" target="_blank">' . esc_html__( 'create categories', 'listar' ) . '</a>';
	endif;
	?>

	<?php
	$random_checked = '';

	/* Display random terms? */
	if ( false !== strpos( $input, 'x' ) ) :
		$random_checked = 'checked';
	endif;
	?>

	<label>
		<input type="checkbox" id="randomCats" name="randomCats" value="randomCats" <?php echo esc_attr( $random_checked ); ?> /> <?php echo esc_html( 'Show all categories', 'listar' ); ?>
	</label><br /><br />

	<div class="searchCategoriesAdm">

	<?php
	$count = is_array( $input_array ) ? count( $input_array ) : 0;

	if ( ! $empty_input && $count > 0 ) :

		for ( $i = 0; $i < $count; $i++ ) :

			$term = get_term( $input_array[ $i ][0], 'job_listing_category' );

			if ( $term && ! is_wp_error( $term ) ) :
				?>
				<div>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $term->term_id ); ?>" /> <?php echo esc_html( $term->name ); ?>
					</label>
				</div>
				<?php
			endif;

		endfor;

	endif;

	$args = array(
		'hide_empty' => false,
	);

	$terms = get_terms( 'job_listing_category', $args );

	if ( $terms && ! is_wp_error( $terms ) ) :

		foreach ( $terms as $term ) :

			$found_term = 0;
			$count = is_array( $input_array ) ? count( $input_array ) : 0;

			for ( $i = 0; $i < $count; $i++ ) :
				if ( $term->term_id === (int) $input_array[ $i ][0] ) {
					$found_term = 1;
					break;
				}
			endfor;

			if ( $empty_input ) :
				$input .= $term->term_id . ' 0,';
			endif;

			if ( ! $found_term ) :
				?>
				<div>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $term->term_id ); ?>" /> <?php echo esc_html( $term->name ); ?>
					</label>
				</div>
				<?php
			endif;
		endforeach;
	endif;
	?>

	</div>

	<?php echo '<p class="description">' . wp_kses( $tip, 'listar-basic-html' ) . '</p>'; ?>

	<input type="hidden" id="listar_hero_search_categories" name="listar_hero_search_categories" value="<?php echo esc_attr( $input ); ?>" />

	<?php
}


/**
 * How these categories must me shown?
 *
 * @since 1.3.1
 */
function listar_hero_search_categories_display_callback() {
	
	$input = get_option( 'listar_hero_search_categories_display' );
	$input_values = array(
		array( 'boxed', esc_html__( 'Short view', 'listar' ) ),
		array( 'wide', esc_html__( 'Wide view', 'listar' ) ),
		array( 'full', esc_html__( 'Full view', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'boxed';
	}
	?>

	<select name="listar_hero_search_categories_display" id="listar_hero_search_categories_display">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Theme option field/preview output - Hero regions under search field.
 *
 * @since 1.3.4
 */
function listar_hero_search_regions_callback() {

	$input         = esc_html( get_option( 'listar_hero_search_regions' ) );
	$empty_input   = 0;
	$temp_array    = array();
	$current_terms = '';
	$temp_elems    = array();
	$tip           = esc_html__( 'Drag and drop checked regions to reorder or check/uncheck to toggle its visibility', 'listar' );

	$num_terms = wp_count_terms( 'job_listing_region', array(
		'hide_empty'=> false,
	) );
	
	if ( empty( $input ) ) {
		$empty_input = 1;
	}
	
	if ( $num_terms > 100 ) :
		$tip = esc_html__( 'Enter the region IDs, separated by comma', 'listar' );
		?>
		<input type="text" name="listar_manual_featured_regions" id="listar_manual_featured_regions" placeholder="12,27,221,45" />
		<?php
	else :

		/* Currently, variable $input contains (example): '1 1,2 0,3 0,4 1,5 1,' */
		if ( false !== strpos( $input, ',' ) && ! $empty_input ) {
			if ( ',' === substr( rtrim( $input ), -1 ) ) {
				$input = substr( $input, 0, -1 );
			}
			if ( false !== strpos( $input, ',' ) ) {
				$temp_array = explode( ',', $input );
			}
		}

		if ( ! count( $temp_array ) && ! $empty_input ) {
			$temp_array[] = $input;
		}

		if ( ! $empty_input ) {

			$count = is_array( $temp_array ) ? count( $temp_array ) : 0;

			for ( $i = 0; $i < $count; $i++ ) {
				if ( '0' !== $temp_array[ $i ] && ' 0' !== $temp_array[ $i ] ) {
					$temp_array[ $i ] = explode( ' ', $temp_array[ $i ], 2 );
					$temp_elems[]     = $temp_array[ $i ];
					$current_terms   .= $temp_array[ $i ][0] . ',';
				}
			}
		}

		$input_array = $temp_elems;

		if ( false !== strpos( $current_terms, ',' ) ) {
			if ( ',' === substr( rtrim( $current_terms ), -1 ) ) {
				$current_terms = substr( $current_terms, 0, -1 );
			}
		}

		$has_terms = get_terms(
			array(
				'taxonomy'   => 'job_listing_region',
				'hide_empty' => false,
			)
		);

		if ( empty( $has_terms ) || is_wp_error( $has_terms ) ) :
			$tip = esc_html__( 'No listing regions set', 'listar' ) . ', <a href="' . esc_url( admin_url( '/edit-tags.php?taxonomy=job_listing_region&post_type=job_listing' ) ) . '" target="_blank">' . esc_html__( 'create regions', 'listar' ) . '</a>';
		endif;
		?>

		<?php
		$random_checked = '';

		/* Display random terms? */
		if ( false !== strpos( $input, 'x' ) ) :
			$random_checked = 'checked';
		endif;
		?>

		<label>
			<input type="checkbox" id="randomRegions" name="randomRegions" value="randomRegions" <?php echo esc_attr( $random_checked ); ?> /> <?php echo esc_html( 'Show all regions', 'listar' ); ?>
		</label><br /><br />

		<div class="searchRegionsAdm">

		<?php
		$count = is_array( $input_array ) ? count( $input_array ) : 0;

		if ( ! $empty_input && $count > 0 ) :

			for ( $i = 0; $i < $count; $i++ ) :

				$term = get_term( $input_array[ $i ][0], 'job_listing_region' );

				if ( $term && ! is_wp_error( $term ) ) :
					?>
					<div>
						<label>
							<input type="checkbox" value="<?php echo esc_attr( $term->term_id ); ?>" /> <?php echo esc_html( $term->name ); ?>
						</label>
					</div>
					<?php
				endif;

			endfor;

		endif;

		$args = array(
			'hide_empty' => false,
		);

		$terms = get_terms( 'job_listing_region', $args );

		if ( $terms && ! is_wp_error( $terms ) ) :

			foreach ( $terms as $term ) :

				$found_term = 0;
				$count = is_array( $input_array ) ? count( $input_array ) : 0;

				for ( $i = 0; $i < $count; $i++ ) :
					if ( $term->term_id === (int) $input_array[ $i ][0] ) {
						$found_term = 1;
						break;
					}
				endfor;

				if ( $empty_input ) :
					$input .= $term->term_id . ' 0,';
				endif;

				if ( ! $found_term ) :
					?>
					<div>
						<label>
							<input type="checkbox" value="<?php echo esc_attr( $term->term_id ); ?>" /> <?php echo esc_html( $term->name ); ?>
						</label>
					</div>
					<?php
				endif;
			endforeach;
		endif;
	endif;
	?>

	</div>

	<?php echo '<p class="description">' . wp_kses( $tip, 'listar-basic-html' ) . '</p>'; ?>

	<input type="hidden" id="listar_hero_search_regions" name="listar_hero_search_regions" value="<?php echo esc_attr( $input ); ?>" />

	<?php
}

/**
 * Fallback description for listing cards
 *
 * @since 1.0
 */
function listar_fallback_listing_card_description_callback() {
	$input = get_option( 'listar_fallback_listing_card_description' );
	
	if ( empty( $input ) ) {
		$input = esc_html__( 'No description available by now. Please, click to verify more detailed info about this listing, like photos, operating hours, and so on.', 'listar' );
	}
	?>
	<input type="text" name="listar_fallback_listing_card_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Initial sort order for default listing search and archive
 *
 * @since 1.3.6
 */
function listar_initial_listing_sort_order_callback() {
	$listar_sort_order = get_option( 'listar_initial_listing_sort_order' );
	$listar_sort_options = listar_get_listing_sort_option_filters();

	if ( empty( $listar_sort_order ) ) {
		$listar_sort_order = 'newest';
	}
	?>

	<select name="listar_initial_listing_sort_order" id="listar_initial_listing_sort_order">
		<?php
		foreach ( $listar_sort_options as $listar_sort_option ) :
			$option_value = $listar_sort_option['value'];
			$option_name  = $listar_sort_option['title'];

			$selected = ( $listar_sort_order === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Theme option field/preview output - Default static search placeholder text.
 *
 * @since 1.0
 */
function listar_search_input_placeholder_callback() {
	$input = get_option( 'listar_search_input_placeholder' );
	?>
	<input type="text" name="listar_search_input_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'What do you need?', 'listar' ); ?>" />
	<?php
}

/**
 * Title for search popup.
 *
 * @since 1.3.6
 */
function listar_search_popup_title_callback() {
	$input = get_option( 'listar_search_popup_title' );
	?>
	<input type="text" name="listar_search_popup_title" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Search', 'listar' ); ?>" />
	<?php
}

/**
 * Subtitle for search popup.
 *
 * @since 1.3.6
 */
function listar_search_popup_subtitle_callback() {
	$input = get_option( 'listar_search_popup_subtitle' );
	?>
	<input type="text" name="listar_search_popup_subtitle" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Start typing what you are looking for.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom label for "Random" sort filter
 *
 * @since 1.3.6
 */
function listar_custom_random_label_callback() {
	$input = get_option( 'listar_custom_random_label' );
	$placeholder = listar_get_custom_random_label();
	?>
	<input type="text" name="listar_custom_random_label" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" />
	<?php
}

/**
 * Auto approve listings after complete orders
 *
 * @since 1.4.0
 */
function listar_auto_approve_paid_listings_callback() {
	$input   = (int) get_option( 'listar_auto_approve_paid_listings' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_auto_approve_paid_listings" name="listar_auto_approve_paid_listings" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 *  Geocoding provider.
 *
 * @since 1.3.0
 */
function listar_geocoding_provider_callback() {
	$input        = get_option( 'listar_geocoding_provider' );
	$input_values = array(
		array( 'mapplus','WT.AX Geo-Geo ' ),
		array( 'jawg', 'JawgMaps ' . esc_html__( '(API Key Needed)', 'listar' ) ),
		array( 'openstreetmap', 'OpenStreetMap ' ),
		array( 'mapbox', 'Mapbox ' . esc_html__( '(API Key Needed)', 'listar' ) ),
		array( 'here', 'Here ' . esc_html__( '(API Key Needed)', 'listar' ) ),
		array( 'googlemaps', 'Google Maps ' . esc_html__( '(API Key Needed)', 'listar' ) ),
		array( 'bingmaps', 'Bing ' . esc_html__( '(API Key Needed)', 'listar' ) ),
	);
	
	$listar_jawg_api_key = get_option( 'listar_jawg_api_key' );
	$listar_mapbox_api_key = get_option( 'listar_mapbox_api_key' );
	$listar_here_api_key = get_option( 'listar_here_api_key' );
	$listar_googlemaps_api_key = get_option( 'listar_googlemaps_api_key' );
	$listar_bingmaps_api_key = get_option( 'listar_bingmaps_api_key' );
	$locale_code = 'locale';
	
	if ( empty( $listar_googlemaps_api_key ) ) {
		$listar_googlemaps_api_key = get_option( 'job_manager_google_maps_api_key' );
	}

	if ( empty( $input ) ) {
		$input = 'mapplus';
	}
	?>

	<select name="listar_geocoding_provider" id="listar_geocoding_provider">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<div class="listar-geocoding-providers">
	
		<br />
		
		<p class="description listar-mapplus-provider-description hidden">
			<?php esc_html_e( 'WT.AX Geo-Geo is a free and exclusive Geocoding & Geolocation tool by Webdesigntrade.', 'listar' ); ?>
			<br>
			<?php
			printf(
				/* TRANSLATORS: Map provider name, ex: Mapbox */
				wp_kses( __( '%s does not require any API integration, just start to publish your listings right now.', 'listar' ), 'listar-basic-html' ),
				'WT.AX Geo-Geo'
			);
			?>
		</p>

		<p class="description listar-jawg-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'JawgMaps',
				'<br>',
				'<a href="https://api.jawg.io/auth/realms/jawg/login-actions/registration?client_id=jawg-www&tab_id=fLcBpmbPnao" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://api.jawg.io/auth/realms/jawg/protocol/openid-connect/auth?client_id=jawg-www&redirect_uri=https%3A%2F%2Fwww.jawg.io%2Flab%2Fstyles&response_mode=fragment&response_type=code&scope=openid" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://www.jawg.io/lab/access-tokens" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://www.jawg.io/docs/" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p>

		<p class="description listar-mapbox-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'Mapbox',
				'<br>',
				'<a href="https://account.mapbox.com/auth/signup/" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://account.mapbox.com/auth/signin/" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://account.mapbox.com/access-tokens/create/" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://docs.mapbox.com/help/how-mapbox-works/access-tokens/" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p>

		<p class="description listar-here-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'Here Maps',
				'<br>',
				'<a href="https://account.here.com/sign-in" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://account.here.com/sign-in" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://developer.here.com/projects" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://developer.here.com/documentation/maps/dev_guide/topics/credentials.html" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p>

		<p class="description listar-openstreetmap-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: Map provider name, ex: Mapbox */
				wp_kses( __( '%s does not require any API integration, just start to publish your listings right now.', 'listar' ), 'listar-basic-html' ),
				'OpenStreetMap'
			);
			?>
		</p>

		<p class="description listar-googlemaps-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'Google Maps',
				'<br>',
				'<a href="https://cloud.google.com/maps-platform/" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://console.cloud.google.com/" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://console.cloud.google.com/apis/credentials" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://developers.google.com/maps/gmp-get-started" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
			<br>
			<br>
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: Link for Google billing page */
				wp_kses( __( 'Notice: Currently, %1$s also requires a billing account to activate the API Key, even for free usage. You can set your billing account %2$s. A credit card is required.', 'listar' ), 'listar-basic-html' ),
				'Google Maps',
				'<a href="https://console.cloud.google.com/billing" target="_blank">' . __( 'here', 'listar' ) . '</a>'
			);
			?>
		</p>

		<p class="description listar-bingmaps-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'Bing Maps',
				'<br>',
				'<a href="https://www.bingmapsportal.com/Account/Register?userConfirmation=False" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://www.bingmapsportal.com/Account" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://www.bingmapsportal.com/Application" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://docs.microsoft.com/en-us/bingmaps/getting-started/bing-maps-dev-center-help/getting-a-bing-maps-key" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p>
	</div>

	<div class="listar-geocoding-providers-keys">
	
		<br />
	
		<p class="listar-key-field listar-mapplus-provider-key hidden">
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="http://wt.ax/mapplus/languages.php" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'WT.AX Geo-Geo'
			);
			?>
			
			<?php
			$mapplus_lang_code = get_option( 'listar_mapplus_language_code' );
			$mapplus_lang_code_values = array(
				'af', 'am', 'ar', 'arn', 'as', 'az', 'ba', 'be',
				'bg', 'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy',
				'da', 'de', 'dv', 'el', 'en', 'es', 'et', 'eu',
				'fa', 'fi', 'fil', 'fo', 'fr', 'fy', 'ga', 'gd gl',
				'gsw', 'gu', 'ha', 'he', 'hi', 'hr', 'hsb', 'hu',
				'hy', 'id', 'ig', 'ii', 'is', 'it', 'iu', 'ja',
				'ka', 'kk', 'kl', 'km', 'kn', 'ko', 'kok', 'ky',
				'lb', 'lo', 'lt', 'lv', 'mi', 'mk', 'ml', 'mn',
				'moh', 'mr', 'ms', 'mt', 'ne', 'nl', 'no', 'nso',
				'oc', 'or', 'pa', 'pl', 'prs', 'ps', 'pt', 'qut',
				'quz', 'rm', 'ro', 'ru', 'rw', 'sa', 'sah', 'se',
				'si', 'sk', 'sl', 'sq', 'sv', 'sw', 'syr', 'ta',
				'te', 'tg', 'th', 'tk', 'tn', 'tr', 'tt', 'tzm',
				'ug', 'uk', 'ur', 'uz', 'vi', 'wo', 'xh', 'yo',
				'zh-Hans', 'zu',
			);
			
			array_unshift( $mapplus_lang_code_values , $locale_code );

			if ( empty( $mapplus_lang_code ) ) {
				$mapplus_lang_code = $mapplus_lang_code_values[0];
			}
			?>

			<select name="listar_mapplus_language_code" id="listar_mapplus_language_code">
				<?php
				$mapplus_counter = 0;

				foreach ( $mapplus_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $mapplus_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $mapplus_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$mapplus_counter++;
				endforeach;
				?>

			</select>
		</p>

		<p class="listar-key-field listar-jawg-provider-key hidden">
			<input type="text" name="listar_jawg_api_key" value="<?php echo esc_attr( $listar_jawg_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
			
			<br /><br />
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="http://wt.ax/mapplus/languages.php" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'JawgMaps'
			);
			?>
			
			<?php
			$jawg_lang_code = get_option( 'listar_jawg_language_code' );
			$jawg_lang_code_values = array(
				'af', 'am', 'ar', 'arn', 'as', 'az', 'ba', 'be',
				'bg', 'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy',
				'da', 'de', 'dv', 'el', 'en', 'es', 'et', 'eu',
				'fa', 'fi', 'fil', 'fo', 'fr', 'fy', 'ga', 'gd gl',
				'gsw', 'gu', 'ha', 'he', 'hi', 'hr', 'hsb', 'hu',
				'hy', 'id', 'ig', 'ii', 'is', 'it', 'iu', 'ja',
				'ka', 'kk', 'kl', 'km', 'kn', 'ko', 'kok', 'ky',
				'lb', 'lo', 'lt', 'lv', 'mi', 'mk', 'ml', 'mn',
				'moh', 'mr', 'ms', 'mt', 'ne', 'nl', 'no', 'nso',
				'oc', 'or', 'pa', 'pl', 'prs', 'ps', 'pt', 'qut',
				'quz', 'rm', 'ro', 'ru', 'rw', 'sa', 'sah', 'se',
				'si', 'sk', 'sl', 'sq', 'sv', 'sw', 'syr', 'ta',
				'te', 'tg', 'th', 'tk', 'tn', 'tr', 'tt', 'tzm',
				'ug', 'uk', 'ur', 'uz', 'vi', 'wo', 'xh', 'yo',
				'zh-Hans', 'zu',
			);
			
			array_unshift( $jawg_lang_code_values , $locale_code );

			if ( empty( $jawg_lang_code ) ) {
				$jawg_lang_code = $jawg_lang_code_values[0];
			}
			?>

			<select name="listar_jawg_language_code" id="listar_jawg_language_code">
				<?php
				$jawg_counter = 0;

				foreach ( $jawg_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $jawg_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $jawg_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$jawg_counter++;
				endforeach;
				?>

			</select>
		</p>
	
		<p class="listar-key-field listar-openstreetmap-provider-key hidden">
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="http://wt.ax/openstreetmap/languages.php" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'OpenStreetMap'
			);
			?>
			
			<?php
			$openstreetmap_lang_code = get_option( 'listar_openstreetmap_language_code' );
			$openstreetmap_lang_code_values = array(
				'af', 'am', 'ar', 'as', 'az', 'ba', 'be', 'bg',
				'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy', 'da',
				'de', 'dv', 'el', 'en', 'es', 'et', 'eu', 'fa',
				'fi', 'fo', 'fr', 'fy', 'ga', 'gd', 'gl', 'gu',
				'ha', 'he', 'hi', 'hr', 'hu', 'hy', 'id', 'ig',
				'ii', 'is', 'it', 'iu', 'ja', 'ka', 'kk', 'kl',
				'km', 'kn', 'ko', 'kz', 'lb', 'lo', 'lt', 'lv',
				'mi', 'mk', 'ml', 'mn', 'mr', 'ms', 'mt', 'ne',
				'nl', 'no', 'oc', 'or', 'or', 'pa', 'pl', 'ps',
				'pt', 'ro', 'ru', 'rw', 'sa', 'sb', 'se', 'si',
				'sk', 'sl', 'sq', 'sr', 'sv', 'sw', 'sx', 'ta',
				'te', 'tg', 'th', 'tk', 'tn', 'tr', 'ts', 'tt',
				'ug', 'uk', 'ur', 'uz', 'vi', 'wo', 'xh', 'yi',
				'yo', 'zh', 'zh-Hans', 'zu',
			);
			
			array_unshift( $openstreetmap_lang_code_values , $locale_code );

			if ( empty( $openstreetmap_lang_code ) ) {
				$openstreetmap_lang_code = $openstreetmap_lang_code_values[0];
			}
			?>

			<select name="listar_openstreetmap_language_code" id="listar_openstreetmap_language_code">
				<?php
				$openstreetmap_counter = 0;

				foreach ( $openstreetmap_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $openstreetmap_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $openstreetmap_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$openstreetmap_counter++;
				endforeach;
				?>

			</select>
		</p>

		<p class="listar-key-field listar-mapbox-provider-key hidden">
			<input type="text" name="listar_mapbox_api_key" value="<?php echo esc_attr( $listar_mapbox_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
			
			<br /><br />
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="https://docs.mapbox.com/api/search/#language-coverage" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'Mapbox'
			);
			?>
			
			<?php
			$mapbox_lang_code = get_option( 'listar_mapbox_language_code' );
			$mapbox_lang_code_values = array(
				'ar', 'bg', 'bs', 'ca', 'cs', 'da', 'de', 'en',
				'es', 'fi', 'fr', 'he', 'hu', 'id', 'is', 'it',
				'ja', 'ka', 'kk', 'ko', 'lv', 'mn', 'nb', 'nl',
				'pl', 'pt', 'ro', 'sk', 'sl', 'sq', 'sr', 'sv',
				'th', 'tl', 'tr', 'zh', 'zh-Hans', 'zh-Hant',
			);
			
			array_unshift( $mapbox_lang_code_values , $locale_code );

			if ( empty( $mapbox_lang_code ) ) {
				$mapbox_lang_code = $mapbox_lang_code_values[0];
			}
			?>

			<select name="listar_mapbox_language_code" id="listar_mapbox_language_code">
				<?php
				$mapbox_counter = 0;

				foreach ( $mapbox_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $mapbox_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $mapbox_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$mapbox_counter++;
				endforeach;
				?>

			</select>
		</p>
	
		<p class="listar-key-field listar-here-provider-key hidden">
			<input type="text" name="listar_here_api_key" value="<?php echo esc_attr( $listar_here_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
			
			<br /><br />
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="https://github.com/libyal/libfwnt/wiki/Language-Code-identifiers#language-identifiers" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'Here'
			);
			?>
			
			<?php
			$here_lang_code = get_option( 'listar_here_language_code' );
			$here_lang_code_values = array(
				'af', 'am', 'ar', 'arn', 'as', 'az', 'ba', 'be',
				'bg', 'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy',
				'da', 'de', 'dv', 'el', 'en', 'es', 'et', 'eu',
				'fa', 'fi', 'fil', 'fo', 'fr', 'fy', 'ga', 'gd gl',
				'gsw', 'gu', 'ha', 'he', 'hi', 'hr', 'hsb', 'hu',
				'hy', 'id', 'ig', 'ii', 'is', 'it', 'iu', 'ja',
				'ka', 'kk', 'kl', 'km', 'kn', 'ko', 'kok', 'ky',
				'lb', 'lo', 'lt', 'lv', 'mi', 'mk', 'ml', 'mn',
				'moh', 'mr', 'ms', 'mt', 'ne', 'nl', 'no', 'nso',
				'oc', 'or', 'pa', 'pl', 'prs', 'ps', 'pt', 'qut',
				'quz', 'rm', 'ro', 'ru', 'rw', 'sa', 'sah', 'se',
				'si', 'sk', 'sl', 'sq', 'sv', 'sw', 'syr', 'ta',
				'te', 'tg', 'th', 'tk', 'tn', 'tr', 'tt', 'tzm',
				'ug', 'uk', 'ur', 'uz', 'vi', 'wo', 'xh', 'yo',
				'zh-Hans', 'zu',
			);
			
			array_unshift( $here_lang_code_values , $locale_code );

			if ( empty( $here_lang_code ) ) {
				$here_lang_code = $here_lang_code_values[0];
			}
			?>

			<select name="listar_here_language_code" id="listar_here_language_code">
				<?php
				$here_counter = 0;

				foreach ( $here_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $here_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $here_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$here_counter++;
				endforeach;
				?>

			</select>
		</p>
	
		<p class="listar-key-field listar-googlemaps-provider-key hidden">
			<input type="text" name="listar_googlemaps_api_key" value="<?php echo esc_attr( $listar_googlemaps_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
		</p>
	
		<p class="listar-key-field listar-bingmaps-provider-key hidden">
			<input type="text" name="listar_bingmaps_api_key" value="<?php echo esc_attr( $listar_bingmaps_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
			
			<br /><br />
			
			<?php esc_html_e( 'Choose a language code.', 'listar' ); ?>
			
			<?php

			printf(
				/* TRANSLATORS: 1: A link external link, 2: Map provider name, ex: Mapbox */
				'<br>' . wp_kses( __( 'Click %1$s to check all language codes, countries and language coverage for %2$s.', 'listar' ), 'listar-basic-html' ) . '<br><br>',
				'<a href="https://docs.microsoft.com/en-us/bingmaps/rest-services/common-parameters-and-types/supported-culture-codes" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'Bing Maps'
			);
			?>
			
			<?php
			$bingmaps_lang_code = get_option( 'listar_bingmaps_language_code' );
			$bingmaps_lang_code_values = array(
				'af', 'am', 'ar-sa', 'as', 'az-Latn', 'be', 'bg',
				'bn-BD', 'bn-IN', 'bs', 'ca', 'ca-ES-valencia',
				'cs', 'cy', 'da', 'de', 'de-de', 'el', 'en-GB',
				'en-US', 'es', 'es-ES', 'es-US', 'es-MX', 'et',
				'eu', 'fa', 'fi', 'fil-Latn', 'fr', 'fr-FR',
				'fr-CA', 'ga', 'gd-Latn', 'gl', 'gu', 'ha-Latn',
				'he', 'hi', 'hr', 'hu', 'hy', 'id', 'ig-Latn',
				'is', 'it', 'it-it', 'ja', 'ka', 'kk', 'km', 'kn',
				'ko', 'kok', 'ku-Arab', 'ky-Cyrl', 'lb', 'lt',
				'lv', 'mi-Latn', 'mk', 'ml', 'mn-Cyrl', 'mr', 'ms',
				'mt', 'nb', 'ne', 'nl', 'nl-BE', 'nn', 'nso', 'or',
				'pa', 'pa-Arab', 'pl', 'prs-Arab', 'pt-BR', 'pt-PT',
				'qut-Latn', 'quz', 'ro', 'ru', 'rw', 'sd-Arab', 
				'si', 'sk', 'sl', 'sq', 'sr-Cyrl-BA', 'sr-Cyrl-RS',
				'sr-Latn-RS', 'sv', 'sw', 'ta', 'te', 'tg-Cyrl',
				'th', 'ti', 'tk-Latn', 'tn', 'tr', 'tt-Cyrl',
				'ug-Arab', 'uk', 'ur', 'uz-Latn', 'vi', 'wo',
				'xh', 'yo-Latn', 'zh-Hans', 'zh-Hant', 'zu', 
			);
			
			array_unshift( $bingmaps_lang_code_values , $locale_code );

			if ( empty( $bingmaps_lang_code ) ) {
				$bingmaps_lang_code = $bingmaps_lang_code_values[0];
			}
			?>

			<select name="listar_bingmaps_language_code" id="listar_bingmaps_language_code">
				<?php
				$bingmaps_counter = 0;

				foreach ( $bingmaps_lang_code_values as $lang_code ) :
					$option_value = $lang_code;
					$option_name = $lang_code;

					$selected = ( $bingmaps_lang_code === $option_value ) ? 'selected="selected"' : '';
					
					if ( 0 === $bingmaps_counter ) {
						$option_name = esc_html( 'Try my Site Language (from WordPress Settings)' );
					}
					?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
						<?php echo esc_html( $option_name ); ?>
					</option>
					<?php
					$bingmaps_counter++;
				endforeach;
				?>

			</select>
		</p>
	</div>

	<?php
}


/* Overwriting third part options with Listar options */

add_action( 'update_option_listar_googlemaps_api_key', 'listar_update_googlemaps_api_key', 10, 2 );

function listar_update_googlemaps_api_key( $old_value, $new_value ) {
	update_option( 'job_manager_google_maps_api_key', $new_value );
}


/* Sanitize slugs */

add_action( 'update_option_listar_custom_listing_slug', 'listar_sanitize_listing_slug', 10, 2 );

function listar_sanitize_listing_slug( $old_value, $new_value ) {
	
	if ( ! empty( $new_value ) && $new_value !== $old_value ) {
		$new_value = $new_value !== '!' && $new_value !== '-' && $new_value !== '@' ? strtolower( sanitize_file_name( $new_value ) ) : $new_value;
		update_option( 'listar_custom_listing_slug', $new_value );
	}
}

add_action( 'update_option_listar_absent_region_slug_permalink', 'listar_sanitize_region_slug', 10, 2 );

function listar_sanitize_region_slug( $old_value, $new_value ) {
	
	if ( ! empty( $new_value ) && $new_value !== $old_value ) {
		$new_value = $new_value !== '!' && $new_value !== '-' && $new_value !== '@' ? strtolower( sanitize_file_name( $new_value ) ) : $new_value;
		update_option( 'listar_absent_region_slug_permalink', $new_value );
	}
}

add_action( 'update_option_listar_absent_category_slug_permalink', 'listar_sanitize_category_slug', 10, 2 );

function listar_sanitize_category_slug( $old_value, $new_value ) {
	
	if ( ! empty( $new_value ) && $new_value !== $old_value ) {
		$new_value = $new_value !== '!' && $new_value !== '-' && $new_value !== '@' ? strtolower( sanitize_file_name( $new_value ) ) : $new_value;
		update_option( 'listar_absent_category_slug_permalink', $new_value );
	}
}

/**
 *  Geocoding provider.
 *
 * @since 1.4.9
 */
function listar_map_provider_callback() {
	$input        = get_option( 'listar_map_provider' );
	$input_values = array(
		array( 'mapplus','WT.AX Geo-Geo ' ),
		array( 'jawg', 'JawgMaps ' . esc_html__( '(API Key Needed)', 'listar' ) ),
		array( 'mapbox', 'Mapbox ' . esc_html__( '(API Key Needed)', 'listar' ) ),
	);
	
	$listar_mapbox_design_provider_api_key = get_option( 'listar_mapbox_design_provider_api_key' );
	$listar_mapbox_style_url = get_option( 'listar_mapbox_style_url' );

	$listar_jawg_design_provider_api_key = get_option( 'listar_jawg_design_provider_api_key' );
	$listar_jawg_style_url = get_option( 'listar_jawg_style_url' );

	if ( empty( $input ) ) {
		$input = 'mapplus';
	}
	?>

	<select name="listar_map_provider" id="listar_map_provider">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<div class="listar-map-providers">
	
		<br />
		
		<p class="description listar-mapplus-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: Map provider name, ex: Mapbox */
				wp_kses( __( '%s does not require any API integration.', 'listar' ), 'listar-basic-html' ),
				'WT.AX Geo-Geo'
			);
			?>
		</p>

		<p class="description listar-mapbox-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'Mapbox',
				'<br>',
				'<a href="https://account.mapbox.com/auth/signup/" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://account.mapbox.com/auth/signin/" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://account.mapbox.com/access-tokens/create/" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://docs.mapbox.com/help/how-mapbox-works/access-tokens/" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p>

		<p class="description listar-jawg-provider-description hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( '%1$s requires an API key/token for access. %2$s You can %3$s by free, %4$s and get your token %5$s. You can also read the %6$s.', 'listar' ), 'listar-basic-html' ),
				'JawgMaps',
				'<br>',
				'<a href="https://api.jawg.io/auth/realms/jawg/login-actions/registration?client_id=jawg-www&tab_id=fLcBpmbPnao" target="_blank">' . __( 'signup', 'listar' ) . '</a>',
				'<a href="https://api.jawg.io/auth/realms/jawg/protocol/openid-connect/auth?client_id=jawg-www&redirect_uri=https%3A%2F%2Fwww.jawg.io%2Flab%2Fstyles&response_mode=fragment&response_type=code&scope=openid" target="_blank">' . __( 'login', 'listar' ) . '</a>',
				'<a href="https://www.jawg.io/lab/access-tokens" target="_blank">' . __( 'here', 'listar' ) . '</a>',
				'<a href="https://www.jawg.io/docs/" target="_blank">' . __( 'documentation', 'listar' ) . '</a>'
			);
			?>
		</p
	</div>

	<div class="listar-map-providers-keys">
	
		<br />

		<p class="listar-key-field listar-jawg-provider-key hidden">
			<input type="text" name="listar_jawg_design_provider_api_key" value="<?php echo esc_attr( $listar_jawg_design_provider_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
		</p>

		<p class="listar-key-field listar-mapbox-provider-key hidden">
			<input type="text" name="listar_mapbox_design_provider_api_key" value="<?php echo esc_attr( $listar_mapbox_design_provider_api_key ); ?>" placeholder="<?php esc_attr_e( 'Enter your API key/token', 'listar' ); ?>">
		</p>
	
		<br />

		<p class="listar-key-field listar-jawg-provider-key hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( 'Custom style URL for %1$s:', 'listar' ), 'listar-basic-html' ),
				'JawgMaps'
			);
			?>
			
			<br/><br/>
			
			<input type="text" name="listar_jawg_style_url" value="<?php echo esc_attr( $listar_jawg_style_url ); ?>" placeholder="<?php esc_attr_e( 'jawg-sunny', 'listar' ); ?>">
		</p>

		<p class="listar-key-field listar-mapbox-provider-key hidden">
			<?php
			printf(
				/* TRANSLATORS: 1: Map provider name, ex: Mapbox, 2: A simple line break, 3: signup (link), 4: login (link), 5: here (link), 6: here (documentation) */
				wp_kses( __( 'Custom style URL for %1$s:', 'listar' ), 'listar-basic-html' ),
				'Mapbox'
			);
			?>
			
			<br/><br/>
			
			<input type="text" name="listar_mapbox_style_url" value="<?php echo esc_attr( $listar_mapbox_style_url ); ?>" placeholder="<?php esc_attr_e( 'mapbox://styles/xyzwk/xkr85jdk108ts17orx8mkn7cl', 'listar' ); ?>">
		</p>
	</div>

	<?php
}



/**
 * Disable all maps.
 *
 * @since 1.2.9
 */
function listar_disable_all_maps_callback() {
	$input   = (int) get_option( 'listar_disable_all_maps' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_all_maps" name="listar_disable_all_maps" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable map for listing search and archive.
 *
 * @since 1.2.9
 */
function listar_disable_archive_maps_callback() {
	$input   = (int) get_option( 'listar_disable_archive_maps' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_archive_maps" name="listar_disable_archive_maps" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable map for single listing.
 *
 * @since 1.2.9
 */
function listar_disable_single_maps_callback() {
	$input   = (int) get_option( 'listar_disable_single_maps' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_single_maps" name="listar_disable_single_maps" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable directions for single listing.
 *
 * @since 1.2.9
 */
function listar_disable_directions_maps_callback() {
	$input   = (int) get_option( 'listar_disable_directions_maps' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_directions_maps" name="listar_disable_directions_maps" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable GPS for single listing.
 *
 * @since 1.2.9
 */
function listar_disable_gps_maps_callback() {
	$input   = (int) get_option( 'listar_disable_gps_maps' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_gps_maps" name="listar_disable_gps_maps" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Default (fallback) location for listing map.
 *
 * @since 1.2.4
 */
function listar_fallback_map_location_callback() {
	$input = get_option( 'listar_fallback_map_location' );
	?>
	<input type="text" name="listar_fallback_map_location" placeholder="Chicago" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}


/**
 * Minimum map zoom level
 *
 * @since 1.3.1
 */
function listar_min_map_zoom_level_callback() {
	$input = get_option( 'listar_min_map_zoom_level' );
	$input_values = array(
		array( '2', '2' ),
		array( '3', '3' ),
		array( '4', '4' ),
		array( '5', '5' ),
	);

	if ( empty( $input ) ) {
		$input = '17';
	}
	?>

	<select name="listar_min_map_zoom_level" id="listar_min_map_zoom_level">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Minimum map zoom level
 *
 * @since 1.3.1
 */
function listar_max_map_zoom_level_callback() {
        $input = get_option( 'listar_max_map_zoom_level' );
        $input_values = array(
                array( '14', '14' ),
                array( '15', '15' ),
                array( '16', '16' ),
                array( '17', '17' ),
                array( '18', '18' ),
                array( '19', '19' ),
                array( '20', '20' ),
                array( '21', '21' ),
                array( '22', '22' ),
        );

        if ( empty( $input ) ) {
                $input = '20';
        }
        ?>

        <select name="listar_max_map_zoom_level" id="listar_max_map_zoom_level">
                <?php
                foreach ( $input_values as $input_value ) :
                        $option_value = $input_value[0];
                        $option_name  = $input_value[1];

                        $selected = ( $input === $option_value ) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
                                <?php echo esc_html( $option_name ); ?>
                        </option>
                        <?php
                endforeach;
                ?>

        </select>

        <?php
}


/**
 * Initial map zoom for listing archive
 *
 * @since 1.5.3
 */
function listar_initial_archive_map_zoom_level_callback() {
        $input = get_option( 'listar_initial_archive_map_zoom_level' );
        $input_values = array(
                array( '0', esc_html__( 'Default', 'listar' ) ),
                array( '2', '2' ),
                array( '3', '3' ),
                array( '4', '4' ),
                array( '5', '5' ),
                array( '6', '6' ),
                array( '7', '7' ),
                array( '8', '8' ),
                array( '9', '9' ),
                array( '10', '10' ),
                array( '11', '11' ),
                array( '12', '12' ),
                array( '13', '13' ),
                array( '14', '14' ),
                array( '15', '15' ),
                array( '16', '16' ),
                array( '17', '17' ),
                array( '18', '18' ),
                array( '19', '19' ),
                array( '20', '20' ),
                array( '21', '21' ),
                array( '22', '22' ),
        );

        if ( empty( $input ) ) {
                $input = '0';
        }
        ?>

        <select name="listar_initial_archive_map_zoom_level" id="listar_initial_archive_map_zoom_level">
                <?php
                foreach ( $input_values as $input_value ) :
                        $option_value = $input_value[0];
                        $option_name  = $input_value[1];

                        $selected = ( $input === $option_value ) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
                                <?php echo esc_html( $option_name ); ?>
                        </option>
                        <?php
                endforeach;
                ?>

        </select>

        <?php
}


/**
 * Initial map zoom for single listing pages
 *
 * @since 1.5.3
 */
function listar_initial_single_map_zoom_level_callback() {
        $input = get_option( 'listar_initial_single_map_zoom_level' );
        $input_values = array(
                array( 'default', esc_html__( 'Default', 'listar' ) ),
                array( '2', '2' ),
                array( '3', '3' ),
                array( '4', '4' ),
                array( '5', '5' ),
                array( '6', '6' ),
                array( '7', '7' ),
                array( '8', '8' ),
                array( '9', '9' ),
                array( '10', '10' ),
                array( '11', '11' ),
                array( '12', '12' ),
                array( '13', '13' ),
                array( '14', '14' ),
                array( '15', '15' ),
                array( '16', '16' ),
                array( '17', '17' ),
                array( '18', '18' ),
                array( '19', '19' ),
                array( '20', '20' ),
                array( '21', '21' ),
                array( '22', '22' ),
        );

        if ( empty( $input ) ) {
                $input = 'default';
        }
        ?>

        <select name="listar_initial_single_map_zoom_level" id="listar_initial_single_map_zoom_level">
                <?php
                foreach ( $input_values as $input_value ) :
                        $option_value = $input_value[0];
                        $option_name  = $input_value[1];

                        $selected = ( $input === $option_value ) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
                                <?php echo esc_html( $option_name ); ?>
                        </option>
                        <?php
                endforeach;
                ?>

        </select>

        <?php
}

/**
 * Disable search tip.
 *
 * @since 1.4.4
 */
function listar_disable_search_tip_callback() {
	$input   = (int) get_option( 'listar_disable_search_tip' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_tip" name="listar_disable_search_tip" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Title for search tip
 *
 * @since 1.4.4
 */
function listar_search_tip_title_callback() {
	$input = get_option( 'listar_search_tip_title' );
	?>
	<input type="text" name="listar_search_tip_title" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Gotta Lost?', 'listar' ); ?>" />
	<?php
}

/**
 * Subtitle for search tip
 *
 * @since 1.4.4
 */
function listar_search_tip_subtitle_callback() {
	$input = get_option( 'listar_search_tip_subtitle' );
	$tip = esc_html__( 'Insert "-" (single hyphen) to hide it.', 'listar' );
	
	?>
	<input type="text" name="listar_search_tip_subtitle" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Click & Browse Highlights ...', 'listar' ); ?>" />
	<?php echo '<p class="description">' . wp_kses( $tip, 'listar-basic-html' ) . '</p>'; ?>
	<?php
}

/**
 * Icon for search tip
 *
 * @since 1.4.4
 */
function listar_search_tip_icon_callback() {
	$input = get_option( 'listar_search_tip_icon' );
	$tip = esc_html__( 'Insert "-" (single hyphen) to hide it.', 'listar' );
	?>
	<input type="text" name="listar_search_tip_icon" value="<?php echo esc_attr( $input ); ?>" placeholder="icon-thumbs-down" />
	<?php echo '<p class="description">' . wp_kses( $tip, 'listar-basic-html' ) . '</p>'; ?>
	<?php
}

/**
 * Disable related listings for listing posts
 *
 * @since 1.3.6
 */
function listar_disable_related_listings_single_callback() {
	$input   = (int) get_option( 'listar_disable_related_listings_single' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_related_listings_single" name="listar_disable_related_listings_single" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Related listings title for listing posts.
 *
 * @since 1.0
 */
function listar_related_listings_title_callback() {
	$input = get_option( 'listar_related_listings_title' );
	?>
	<input type="text" name="listar_related_listings_title" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}


/**
 * The related listings for listing posts must load
 *
 * @since 1.3.6
 */
function listar_related_listings_single_schema_callback() {
	$input = get_option( 'listar_related_listings_single_schema' );
	$input_values = array(
		array( 'randomly', esc_html__( 'Randomly', 'listar' ) ),
		array( 'smartly', esc_html__( 'Smartly', 'listar' ) ),
		array( 'both', esc_html__( 'Smartly and randomly', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'both';
	}
	?>

	<select name="listar_related_listings_single_schema" id="listar_related_listings_single_schema">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<p class="description">
		<br>
		<?php esc_html_e( "Randomly: aleatory listings will be displayed.", 'listar' ); ?><br/>
		<?php esc_html_e( "Smartly: if available, only listings based on the current filtering will be displayed.", 'listar' ); ?><br/>
		<?php esc_html_e( "Smartly and randomly: the current filtering will be respected prioritarily and random listings will complete the grid if yet empty.", 'listar' ); ?>
	</p>

	<?php
}


/**
 * After recover smart related listings for listing posts, prioritize
 *
 * @since 1.3.6
 */
function listar_related_listings_single_priority_callback() {
	$input = get_option( 'listar_related_listings_single_priority' );
	$input_values = array(
		array( 'categories', esc_html__( 'Current categories for any region', 'listar' ) ),
		array( 'regions', esc_html__( 'Current regions for any category', 'listar' ) ),
		array( 'none', esc_html__( 'No matter', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'regions';
	}
	?>

	<select name="listar_related_listings_single_priority" id="listar_related_listings_single_priority">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * If the listing post belongs to a region, disable related listings from any other regions
 *
 * @since 1.3.6
 */
function listar_related_listings_single_disable_other_regions_callback() {
	$input   = (int) get_option( 'listar_related_listings_single_disable_other_regions' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_related_listings_single_disable_other_regions" name="listar_related_listings_single_disable_other_regions" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Maximum related listings to expose on listing posts
 *
 * @since 1.3.6
 */
function listar_related_listings_single_maximum_callback() {
	$input = get_option( 'listar_related_listings_single_maximum' );
	$input_values = array(
		array( '1', '1' ),
		array( '2', '2' ),
		array( '3', '3' ),
		array( '4', '4' ),
		array( '5', '5' ),
		array( '6', '6' ),
		array( '7', '7' ),
		array( '8', '8' ),
		array( '9', '9' ),
		array( '10', '10' ),
		array( '11', '11' ),
		array( '12', '12' ),
	);

	if ( empty( $input ) ) {
		$input = '3';
	}
	?>

	<select name="listar_related_listings_single_maximum" id="listar_related_listings_single_maximum">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * Maximum number of images for gallery upload on front end submission form
 *
 * @since 1.4.2
 */
function listar_max_gallery_upload_images_callback() {
	$input = get_option( 'listar_max_gallery_upload_images' );

	if ( empty( $input ) ) {
		
		// Avoids to display "0".
		$input = '';
	}
	?>
	<input type="text" name="listar_max_gallery_upload_images" value="<?php echo esc_attr( $input ); ?>" placeholder="30" />
	
	<p class="description">
		<?php esc_html_e( "This amount may be overwritten via Package Features, when editing a Listing Package (Woocommerce product).", 'listar' ); ?>
	</p><br />
	<?php
}


/**
 * Maximum number of video/media fields on front end submission form
 *
 * @since 1.4.7
 */
function listar_max_media_fields_callback() {
	$input = get_option( 'listar_max_media_fields' );

	if ( empty( $input ) ) {
		
		// Avoids to display "0".
		$input = '';
	}
	?>
	<input type="text" name="listar_max_media_fields" value="<?php echo esc_attr( $input ); ?>" placeholder="30" />
	
	<p class="description">
		<?php esc_html_e( "This amount may be overwritten via Package Features, when editing a Listing Package (Woocommerce product).", 'listar' ); ?>
	</p><br />
	<?php
}

/**
 * Disable distance metering for listings?
 *
 * @since 1.5.3
 */
function listar_single_listing_preopen_callback() {
	$input = get_option( 'listar_single_listing_preopen' );
	$input_values = array(
		array( 'first', esc_html__( 'Description or first content section available', 'listar' ) ),
		array( 'none', esc_html__( 'None', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'first';
	}
	?>

	<select name="listar_single_listing_preopen" id="listar_single_listing_preopen">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<?php
}


/**
 * On the listing page, group amenities per parents
 *
 * @since 1.3.6
 */
function listar_single_group_amenities_parent_callback() {
	$input   = (int) get_option( 'listar_single_group_amenities_parent' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_single_group_amenities_parent" name="listar_single_group_amenities_parent" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Hide parent amenities from amenity pickers
 *
 * @since 1.3.6
 */
function listar_hide_parent_amenity_pickers_callback() {
	$input   = (int) get_option( 'listar_hide_parent_amenity_pickers' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_hide_parent_amenity_pickers" name="listar_hide_parent_amenity_pickers" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "This will hide parent amenities from amenity picker.", 'listar' ); ?>
	</p><br />
	<?php
}


/**
 * Disable related listings for archive pages
 *
 * @since 1.3.6
 */
function listar_disable_related_listings_archive_callback() {
	$input   = (int) get_option( 'listar_disable_related_listings_archive' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_related_listings_archive" name="listar_disable_related_listings_archive" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Related listings title for archive pages
 *
 * @since 1.3.6
 */
function listar_related_listings_archive_title_callback() {
	$input = get_option( 'listar_related_listings_archive_title' );
	?>
	<input type="text" name="listar_related_listings_archive_title" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}


/**
 * Related listings for archive and search pages must load
 *
 * @since 1.3.6
 */
function listar_related_listings_archive_schema_callback() {
	$input = get_option( 'listar_related_listings_archive_schema' );
	$input_values = array(
		array( 'randomly', esc_html__( 'Randomly', 'listar' ) ),
		array( 'smartly', esc_html__( 'Smartly', 'listar' ) ),
		array( 'both', esc_html__( 'Smartly and randomly', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'both';
	}
	?>

	<select name="listar_related_listings_archive_schema" id="listar_related_listings_archive_schema">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>
	<p class="description">
		<?php esc_html_e( "Randomly: aleatory listings will be displayed.", 'listar' ); ?><br/>
		<?php esc_html_e( "Smartly: if available, only listings based on the current filtering will be displayed.", 'listar' ); ?><br/>
		<?php esc_html_e( "Smartly and randomly: the current filtering will be respected prioritarily and random listings will complete the grid if yet empty.", 'listar' ); ?>
	</p>

	<?php
}


/**
 * If random related listings for archive and searches, prioritize
 *
 * @since 1.3.6
 */
function listar_related_listings_archive_priority_callback() {
	$input = get_option( 'listar_related_listings_archive_priority' );
	$input_values = array(
		array( 'categories', esc_html__( 'Current categories for any region', 'listar' ) ),
		array( 'regions', esc_html__( 'Current regions for any category', 'listar' ) ),
		array( 'none', esc_html__( 'No matter', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'regions';
	}
	?>

	<select name="listar_related_listings_archive_priority" id="listar_related_listings_archive_priority">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}


/**
 * If archive or search is filtered by region, disable related listings from any other regions
 *
 * @since 1.3.6
 */
function listar_related_listings_archive_disable_other_regions_callback() {
	$input   = (int) get_option( 'listar_related_listings_archive_disable_other_regions' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_related_listings_archive_disable_other_regions" name="listar_related_listings_archive_disable_other_regions" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Maximum related listings to expose on archive and searches
 *
 * @since 1.3.6
 */
function listar_related_listings_archive_maximum_callback() {
	$input = get_option( 'listar_related_listings_archive_maximum' );
	$input_values = array(
		array( '1', '1' ),
		array( '2', '2' ),
		array( '3', '3' ),
		array( '4', '4' ),
		array( '5', '5' ),
		array( '6', '6' ),
		array( '7', '7' ),
		array( '8', '8' ),
		array( '9', '9' ),
		array( '10', '10' ),
		array( '11', '11' ),
		array( '12', '12' ),
	);

	if ( empty( $input ) ) {
		$input = '3';
	}
	?>

	<select name="listar_related_listings_archive_maximum" id="listar_related_listings_archive_maximum">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Disable listing "grid filler" card
 *
 * @since 1.3.4
 */
function listar_grid_filler_listing_card_disable_callback() {
	$input   = (int) get_option( 'listar_grid_filler_listing_card_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_grid_filler_listing_card_disable" name="listar_grid_filler_listing_card_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Title for listing "grid filler" card.
 *
 * @since 1.3.1
 */
function listar_grid_filler_listing_card_title_callback() {
	$input = get_option( 'listar_grid_filler_listing_card_title' );
	?>
	<input type="text" name="listar_grid_filler_listing_card_title" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Promote Your Business', 'listar' ); ?>" />
	<?php
}

/**
 * Text for listing "grid filler" card.
 *
 * @since 1.3.1
 */
function listar_grid_filler_listing_card_text1_callback() {
	$input = get_option( 'listar_grid_filler_listing_card_text1' );
	?>
	<input type="text" name="listar_grid_filler_listing_card_text1" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Do you need qualified exposure?', 'listar' ); ?>" />
	<?php
}

/**
 * Additional text for listing "grid filler" card.
 *
 * @since 1.3.1
 */
function listar_grid_filler_listing_card_text2_callback() {
	$input = get_option( 'listar_grid_filler_listing_card_text2' );
	?>
	<input type="text" name="listar_grid_filler_listing_card_text2" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Publish a listing for targeted audience to achieve more popularity in your niche.', 'listar' ); ?>" />
	<?php
}

/**
 * Button text for listing "grid filler" card.
 *
 * @since 1.3.1
 */
function listar_grid_filler_listing_button_text_callback() {
	$input = get_option( 'listar_grid_filler_listing_button_text' );
	?>
	<input type="text" name="listar_grid_filler_listing_button_text" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Get Started', 'listar' ); ?>" />
	<?php
}

/**
 * Custom link for listing "grid filler" card.
 *
 * @since 1.3.8
 */
function listar_grid_filler_listing_button_url_callback() {
	$input = get_option( 'listar_grid_filler_listing_button_url' );
	?>
	<input type="text" name="listar_grid_filler_listing_button_url" value="<?php echo esc_url( $input ); ?>" placeholder="http://" />
	<?php
}

/**
 * Disable blog "grid filler" card
 *
 * @since 1.3.4
 */
function listar_grid_filler_blog_card_disable_callback() {
	$input   = (int) get_option( 'listar_grid_filler_blog_card_disable' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_grid_filler_blog_card_disable" name="listar_grid_filler_blog_card_disable" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "The following custom texts are only for sites without the Add Listing page.", 'listar' ); ?>
	</p><br />
	<?php
}

/**
 * Replicate the listing "grid filler" card on blog
 *
 * @since 1.3.8
 */
function listar_use_listing_grid_filler_blog_callback() {
	$input   = (int) get_option( 'listar_use_listing_grid_filler_blog' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_listing_grid_filler_blog" name="listar_use_listing_grid_filler_blog" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "If checked, all options below will be ignored.", 'listar' ); ?>
	</p>
	<?php
}

/**
 * Title for blog "grid filler" card.
 *
 * @since 1.0
 */
function listar_grid_filler_blog_card_title_callback() {
	$input = get_option( 'listar_grid_filler_blog_card_title' );
	?>
	<input type="text" name="listar_grid_filler_blog_card_title" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Keep Browsing', 'listar' ); ?>" />
	<?php
}

/**
 * Text for blog "grid filler" card.
 *
 * @since 1.0
 */
function listar_grid_filler_blog_card_text1_callback() {
	$input = get_option( 'listar_grid_filler_blog_card_text1' );
	?>
	<input type="text" name="listar_grid_filler_blog_card_text1" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'We have interesting articles for you.', 'listar' ); ?>" />
	<?php
}

/**
 * Additional text for blog "grid filler" card.
 *
 * @since 1.0
 */
function listar_grid_filler_blog_card_text2_callback() {
	$input = get_option( 'listar_grid_filler_blog_card_text2' );
	?>
	<input type="text" name="listar_grid_filler_blog_card_text2" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Check more news from our blog.', 'listar' ); ?>" />
	<?php
}

/**
 * Button text for blog "grid filler" card.
 *
 * @since 1.3.8
 */
function listar_grid_filler_blog_button_text_callback() {
	$input = get_option( 'listar_grid_filler_blog_button_text' );
	?>
	<input type="text" name="listar_grid_filler_blog_button_text" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Get Started', 'listar' ); ?>" />
	<?php
}

/**
 * Custom link for blog "grid filler" card.
 *
 * @since 1.3.8
 */
function listar_grid_filler_blog_button_url_callback() {
	$input = get_option( 'listar_grid_filler_blog_button_url' );
	?>
	<input type="text" name="listar_grid_filler_blog_button_url" value="<?php echo esc_url( $input ); ?>" placeholder="http://" />
	<?php
}

/**
 * Theme option field/preview output - Ajax pagination.
 *
 * @since 1.0
 */
function listar_ajax_pagination_callback() {
	$input   = (int) get_option( 'listar_ajax_pagination' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_ajax_pagination" name="listar_ajax_pagination" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Ajax pagination.
 *
 * @since 1.0
 */
function listar_ajax_infinite_loading_callback() {
	$input   = (int) get_option( 'listar_ajax_infinite_loading' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_ajax_infinite_loading" name="listar_ajax_infinite_loading" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Spiral hover effect for listings
 *
 * @since 1.0
 */
function listar_activate_spiral_effect_callback() {
	$input   = (int) get_option( 'listar_activate_spiral_effect' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_activate_spiral_effect" name="listar_activate_spiral_effect" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Rubber effect on front page header
 *
 * @since 1.0
 */
function listar_hero_rubber_effect_callback() {
	$input   = (int) get_option( 'listar_hero_rubber_effect' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_hero_rubber_effect" name="listar_hero_rubber_effect" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Animate elements while scrolling
 *
 * @since 1.0
 */
function listar_animate_elements_on_scroll_callback() {
	$input   = (int) get_option( 'listar_animate_elements_on_scroll' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_animate_elements_on_scroll" name="listar_animate_elements_on_scroll" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Try to generate a carousel on listing categories popup
 *
 * @since 1.0
 */
function listar_use_carousel_categories_popup_callback() {
	$input   = (int) get_option( 'listar_use_carousel_categories_popup' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_carousel_categories_popup" name="listar_use_carousel_categories_popup" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Try to generate a carousel on listing regions popup
 *
 * @since 1.0
 */
function listar_use_carousel_regions_popup_callback() {
	$input   = (int) get_option( 'listar_use_carousel_regions_popup' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_carousel_regions_popup" name="listar_use_carousel_regions_popup" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/*
 * Explore By options.
 */

/**
 * Disable all listing search options
 *
 * @since 1.3.6
 */
function listar_disable_all_search_by_options_callback() {
	$input   = (int) get_option( 'listar_disable_all_search_by_options' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_all_search_by_options" name="listar_disable_all_search_by_options" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "If checked, all options below will be ignored, only default listing search will be kept.", 'listar' ); ?>
	</p><br />
	<?php
}

/**
 * Initial type of search for Explore By
 *
 * @since 1.3.8
 */
function listar_initial_explore_by_type_callback() {
	$listar_initial_explore_by = get_option( 'listar_initial_explore_by_type' );
	$listar_explore_by_options = listar_get_search_options();

	if ( empty( $listar_initial_explore_by ) ) {
		$listar_initial_explore_by = 'default';
	}
	?>

	<select name="listar_initial_explore_by_type" id="listar_initial_explore_by_type">
		<?php
		foreach ( $listar_explore_by_options as $key => $listar_explore_by_option ) :
			$option_value = $key;
			$option_name  = $listar_explore_by_option[0];

			$selected = ( $listar_initial_explore_by === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Heading title for "Explore By" popup
 *
 * @since 1.3.6
 */
function listar_search_by_popup_title_callback() {
	$input = get_option( 'listar_search_by_popup_title' );
	?>
	<input type="text" name="listar_search_by_popup_title" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Explore by', 'listar' ); ?>" />
	<?php
}

/**
 * Footer description for "Explore By" popup
 *
 * @since 1.3.6
 */
function listar_search_by_popup_description_callback() {
	$input = get_option( 'listar_search_by_popup_description' );
	?>
	<input type="text" name="listar_search_by_popup_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Set and save your favorite way to search.', 'listar' ); ?>" />
	<?php
}

/**
 * Set at least a country to be used for searches by "Near an address" and "Near a postcode"
 *
 * @since 1.3.6
 */
function listar_search_by_predefined_countries_callback() {
	$input = get_option( 'listar_search_by_predefined_countries' );
	?>
	<input type="text" name="listar_search_by_predefined_countries" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'USA, Canada, Spain', 'listar' ); ?>" />

	<p class="description">
		<?php esc_html_e( 'Use a comma (,) to inform more than one country. If empty, USA will be used as default country.', 'listar' ); ?>
	</p>
	<?php
}

/**
 * Disable the "Explore By" tip
 *
 * @since 1.3.6
 */
function listar_disable_search_by_tip_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_tip' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_tip" name="listar_disable_search_by_tip" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Text for "Explore By" tip
 *
 * @since 1.3.6
 */
function listar_search_by_tip_text_callback() {
	$input = get_option( 'listar_search_by_tip_text' );
	?>
	<input type="text" name="listar_search_by_tip_text" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Settings', 'listar' ); ?>" />
	<?php
}

/**
 * Background color for "Explore By" tip
 *
 * @since 1.3.6
 */
function listar_background_color_search_by_tip_callback() {
	$input = get_option( 'listar_background_color_search_by_tip' );
	?>
	<input type="text" name="listar_background_color_search_by_tip" class="listar_background_color_search_by_tip wp-color-picker" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Settings', 'listar' ); ?>" />
	<?php
}

/**
 * Text color for "Explore By" tip
 *
 * @since 1.3.6
 */
function listar_text_color_search_by_tip_callback() {
	$input = get_option( 'listar_text_color_search_by_tip' );
	?>
	<input type="text" name="listar_text_color_search_by_tip" class="listar_text_color_search_by_tip wp-color-picker" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Settings', 'listar' ); ?>" />
	<?php
}

/**
 * Disable the current "Explore By" title for the search input
 *
 * @since 1.3.6
 */
function listar_disable_search_by_input_title_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_input_title' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_input_title" name="listar_disable_search_by_input_title" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Default search" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_default_description_callback() {
	$input = get_option( 'listar_search_by_default_description' );
	?>
	<input type="text" name="listar_search_by_default_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Search spots by keyword(s).', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Nearest me" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_nearest_me_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_nearest_me_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_nearest_me_option" name="listar_disable_search_by_nearest_me_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Nearest me" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_nearest_me_description_callback() {
	$input = get_option( 'listar_search_by_nearest_me_description' );
	?>
	<input type="text" name="listar_search_by_nearest_me_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Find places around your current location.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Nearest me" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_nearest_me_placeholder_callback() {
	$input = get_option( 'listar_search_by_nearest_me_placeholder' );
	?>
	<input type="text" name="listar_search_by_nearest_me_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Only featured" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_featured_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_featured_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_featured_option" name="listar_disable_search_by_featured_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Only featured" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_featured_description_callback() {
	$input = get_option( 'listar_search_by_featured_description' );
	?>
	<input type="text" name="listar_search_by_featured_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Meet highlighted listings.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Only featured" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_featured_placeholder_callback() {
	$input = get_option( 'listar_search_by_featured_placeholder' );
	?>
	<input type="text" name="listar_search_by_featured_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Trending" as "Explore By" option
 *
 * @since 1.4.6
 */
function listar_disable_search_by_trending_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_trending_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_trending_option" name="listar_disable_search_by_trending_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Trending" option inside the popup
 *
 * @since 1.4.6
 */
function listar_search_by_trending_description_callback() {
	$input = get_option( 'listar_search_by_trending_description' );
	?>
	<input type="text" name="listar_search_by_trending_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'It is happening now.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Trending" is selected
 *
 * @since 1.4.6
 */
function listar_search_by_trending_placeholder_callback() {
	$input = get_option( 'listar_search_by_trending_placeholder' );
	?>
	<input type="text" name="listar_search_by_trending_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Best rated" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_best_rated_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_best_rated_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_best_rated_option" name="listar_disable_search_by_best_rated_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Best rated" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_best_rated_description_callback() {
	$input = get_option( 'listar_search_by_best_rated_description' );
	?>
	<input type="text" name="listar_search_by_best_rated_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Qualified points to go.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Best rated" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_best_rated_placeholder_callback() {
	$input = get_option( 'listar_search_by_best_rated_placeholder' );
	?>
	<input type="text" name="listar_search_by_best_rated_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Most viewed" as "Explore By" option
 *
 * @since 1.3.9
 */
function listar_disable_search_by_most_viewed_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_most_viewed_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_most_viewed_option" name="listar_disable_search_by_most_viewed_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Most viewed" option inside the popup
 *
 * @since 1.3.9
 */
function listar_search_by_most_viewed_description_callback() {
	$input = get_option( 'listar_search_by_most_viewed_description' );
	?>
	<input type="text" name="listar_search_by_most_viewed_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'The hottest listings.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Most viewed" is selected
 *
 * @since 1.3.9
 */
function listar_search_by_most_viewed_placeholder_callback() {
	$input = get_option( 'listar_search_by_most_viewed_placeholder' );
	?>
	<input type="text" name="listar_search_by_most_viewed_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Most bookmarked" as "Explore By" option
 *
 * @since 1.3.9
 */
function listar_disable_search_by_most_bookmarked_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_most_bookmarked_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_most_bookmarked_option" name="listar_disable_search_by_most_bookmarked_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Most bookmarked" option inside the popup
 *
 * @since 1.3.9
 */
function listar_search_by_most_bookmarked_description_callback() {
	$input = get_option( 'listar_search_by_most_bookmarked_description' );
	?>
	<input type="text" name="listar_search_by_most_bookmarked_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Places you will love.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Most bookmarked" is selected
 *
 * @since 1.3.9
 */
function listar_search_by_most_bookmarked_placeholder_callback() {
	$input = get_option( 'listar_search_by_most_bookmarked_placeholder' );
	?>
	<input type="text" name="listar_search_by_most_bookmarked_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Near an address" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_near_address_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_near_address_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_near_address_option" name="listar_disable_search_by_near_address_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Near an address" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_near_address_description_callback() {
	$input = get_option( 'listar_search_by_near_address_description' );
	?>
	<input type="text" name="listar_search_by_near_address_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type any partial or full address to find listings nearby.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Near an address" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_near_address_placeholder_callback() {
	$input = get_option( 'listar_search_by_near_address_placeholder' );
	?>
	<input type="text" name="listar_search_by_near_address_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type an address...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Near a postcode" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_near_postcode_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_near_postcode_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_near_postcode_option" name="listar_disable_search_by_near_postcode_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Near a postcode" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_near_postcode_description_callback() {
	$input = get_option( 'listar_search_by_near_postcode_description' );
	?>
	<input type="text" name="listar_search_by_near_postcode_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Find the nearest listings by only typing a postcode.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Near a postcode" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_near_postcode_placeholder_callback() {
	$input = get_option( 'listar_search_by_near_postcode_placeholder' );
	?>
	<input type="text" name="listar_search_by_near_postcode_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type a postcode...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Surprise me" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_surprise_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_surprise_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_surprise_option" name="listar_disable_search_by_surprise_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Surprise me" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_surprise_description_callback() {
	$input = get_option( 'listar_search_by_surprise_description' );
	?>
	<input type="text" name="listar_search_by_surprise_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Discover new places.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Surprise me" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_surprise_placeholder_callback() {
	$input = get_option( 'listar_search_by_surprise_placeholder' );
	?>
	<input type="text" name="listar_search_by_surprise_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Shop" as "Explore By" option
 *
 * @since 1.4.1
 */
function listar_disable_search_by_shop_products_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_shop_products_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_shop_products_option" name="listar_disable_search_by_shop_products_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Shop" option inside the popup
 *
 * @since 1.4.1
 */
function listar_search_by_shop_products_description_callback() {
	$input = get_option( 'listar_search_by_shop_products_description' );
	?>
	<input type="text" name="listar_search_by_shop_products_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Purchase goodies.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Shop" is selected
 *
 * @since 1.4.1
 */
function listar_search_by_shop_products_placeholder_callback() {
	$input = get_option( 'listar_search_by_shop_products_placeholder' );
	?>
	<input type="text" name="listar_search_by_shop_products_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Disable "Blog articles" as "Explore By" option
 *
 * @since 1.3.6
 */
function listar_disable_search_by_blog_option_callback() {
	$input   = (int) get_option( 'listar_disable_search_by_blog_option' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_search_by_blog_option" name="listar_disable_search_by_blog_option" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Description for "Blog articles" option inside the popup
 *
 * @since 1.3.6
 */
function listar_search_by_blog_description_callback() {
	$input = get_option( 'listar_search_by_blog_description' );
	?>
	<input type="text" name="listar_search_by_blog_description" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Find tips and tricks on our blog archive.', 'listar' ); ?>" />
	<?php
}

/**
 * Custom placeholder text for search input field when "Blog articles" is selected
 *
 * @since 1.3.6
 */
function listar_search_by_blog_placeholder_callback() {
	$input = get_option( 'listar_search_by_blog_placeholder' );
	?>
	<input type="text" name="listar_search_by_blog_placeholder" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Type something...', 'listar' ); ?>" />
	<?php
}

/**
 * Color pattern for stripes
 *
 * @since 1.2.4
 */
function listar_listing_sidebar_position_callback() {
	$input = get_option( 'listar_listing_sidebar_position' );
	$input_values = array(
		array( 'left', esc_html__( 'Left', 'listar' ) ),
		array( 'right', esc_html__( 'Right', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'left';
	}
	?>

	<select name="listar_listing_sidebar_position" id="listar_listing_sidebar_position">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Position for front page hero content
 *
 * @since 1.3.1
 */
function listar_hero_content_position_callback() {
	$input = get_option( 'listar_hero_content_position' );
	$input_values = array(
		array( 'center', esc_html__( 'Center', 'listar' ) ),
		array( 'left', esc_html__( 'Left', 'listar' ) ),
		array( 'right', esc_html__( 'Right', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'center';
	}
	?>

	<select name="listar_hero_content_position" id="listar_hero_content_position">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Position for search popup content
 *
 * @since 1.3.1
 */
function listar_search_popup_content_position_callback() {
	$input = get_option( 'listar_search_popup_content_position' );
	$input_values = array(
		array( 'center', esc_html__( 'Center', 'listar' ) ),
		array( 'left', esc_html__( 'Left', 'listar' ) ),
		array( 'right', esc_html__( 'Right', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'center';
	}
	?>

	<select name="listar_search_popup_content_position" id="listar_search_popup_content_position">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Enable expansive excerpt when hovering listing and blog cards
 *
 * @since 1.0
 */
function listar_enable_expansive_excerpt_callback() {
	$input   = (int) get_option( 'listar_enable_expansive_excerpt' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_enable_expansive_excerpt" name="listar_enable_expansive_excerpt" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable 3D hover animations for listing category blocks
 *
 * @since 1.2.9
 */
function listar_disable_listing_category_hover_animation_callback() {
	$input   = (int) get_option( 'listar_disable_listing_category_hover_animation' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_listing_category_hover_animation" name="listar_disable_listing_category_hover_animation" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Force big for listing category blocks
 *
 * @since 1.4.4
 */
function listar_force_big_text_category_callback() {
	$input   = (int) get_option( 'listar_force_big_text_category' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_force_big_text_category" name="listar_force_big_text_category" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Force big for listing region blocks
 *
 * @since 1.4.4
 */
function listar_force_big_text_region_callback() {
	$input   = (int) get_option( 'listar_force_big_text_region' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_force_big_text_region" name="listar_force_big_text_region" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable big text when hovering listing category blocks
 *
 * @since 1.2.9
 */
function listar_disable_big_text_category_hover_animation_callback() {
	$input   = (int) get_option( 'listar_disable_big_text_category_hover_animation' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_big_text_category_hover_animation" name="listar_disable_big_text_category_hover_animation" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable 3D hover animations for listing region blocks
 *
 * @since 1.2.9
 */
function listar_disable_listing_region_hover_animation_callback() {
	$input   = (int) get_option( 'listar_disable_listing_region_hover_animation' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_listing_region_hover_animation" name="listar_disable_listing_region_hover_animation" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable big text when hovering listing region blocks
 *
 * @since 1.2.9
 */
function listar_disable_big_text_region_hover_animation_callback() {
	$input   = (int) get_option( 'listar_disable_big_text_region_hover_animation' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_big_text_region_hover_animation" name="listar_disable_big_text_region_hover_animation" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable hover animations for listing amenity blocks
 *
 * @since 1.2.9
 */
function listar_disable_listing_amenity_hover_animation_callback() {
	$input   = (int) get_option( 'listar_disable_listing_amenity_hover_animation' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_listing_amenity_hover_animation" name="listar_disable_listing_amenity_hover_animation" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable hover opacity for all sibling blocks
 *
 * @since 1.2.9
 */
function listar_disable_sibling_hover_opacity_callback() {
	$input   = (int) get_option( 'listar_disable_sibling_hover_opacity' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_sibling_hover_opacity" name="listar_disable_sibling_hover_opacity" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Animate the "Explore By" tip
 *
 * @since 1.3.6
 */
function listar_animate_search_by_tip_callback() {
	$input   = (int) get_option( 'listar_animate_search_by_tip' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_animate_search_by_tip" name="listar_animate_search_by_tip" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable custom colors for listing categories, regions and amenities
 *
 * @since 1.0
 */
function listar_disable_custom_taxonomy_colors_callback() {
	$input   = (int) get_option( 'listar_disable_custom_taxonomy_colors' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_custom_taxonomy_colors" name="listar_disable_custom_taxonomy_colors" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Customize currency
 *
 * @since 1.3.6
 */
function listar_site_currency_callback() {
	$input = get_option( 'listar_site_currency' );
	$input_values = listar_get_currencies();

	if ( empty( $input ) ) {
		$input = 'USD';
	}
	?>

	<select name="listar_site_currency" class="listar-use-select2" id="listar_site_currency">
		<?php
		foreach ( $input_values as $country_code => $html_entity ) :
			$selected = ( $input === $country_code ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $country_code ); ?>" data-html-entity="<?php echo esc_attr( $html_entity ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $country_code ); ?>
			</option>
			<?php
		endforeach;
		?>
	</select>

	<p class="description">
		<?php
		$listar_kses_tags = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
			'br' => array(),
		);

		printf(
			/* TRANSLATORS: %s: URL to 'Easy WP SMTP plugin' page */
			wp_kses( __( '<a href="%s" target="_blank">Click here</a> to check a detailed list of currency codes.', 'listar' ), $listar_kses_tags ),
			esc_url( 'http://wt.ax/currencies/currencies.php' )
		);
		?>
	</p>

	<?php
}


/* Overwriting third part options with Listar options */

add_action( 'update_option_listar_site_currency', 'listar_update_site_currency', 10, 2 );

function listar_update_site_currency( $old_value, $new_value ) {	
	if ( class_exists( 'Woocommerce' ) ) {
		$input = get_option( 'woocommerce_currency' );

		if ( $input !== $new_value ) {
			update_option( 'woocommerce_currency', $new_value );
		}
	}
}


/* Overwriting third part options with Listar options */

add_action( 'update_option_woocommerce_currency', 'listar_update_site_currency_2', 10, 2 );

function listar_update_site_currency_2( $old_value, $new_value ) {
	$input = get_option( 'listar_site_currency' );
	
	if ( $new_value !== $input ) {
		update_option( 'listar_site_currency', $new_value );
	}
}

/**
 * Don't publish/renew listings automatically after an order is paid
 *
 * @since 1.4.9
 */
function listar_deny_publish_listings_after_paid_order_callback() {
	$input   = (int) get_option( 'listar_deny_publish_listings_after_paid_order' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_deny_publish_listings_after_paid_order" name="listar_deny_publish_listings_after_paid_order" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Don't publish/renew listings after a subscription package be activated or renewed
 *
 * @since 1.4.9
 */
function listar_deny_publish_listings_after_paid_subscription_callback() {
	$input   = (int) get_option( 'listar_deny_publish_listings_after_paid_subscription' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_deny_publish_listings_after_paid_subscription" name="listar_deny_publish_listings_after_paid_subscription" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Custom "listing" slug
 *
 * @since 1.5.0
 */
function listar_custom_listing_slug_callback() {
	$input = get_option( 'listar_custom_listing_slug' );
	?>
	<input type="text" name="listar_custom_listing_slug" value="<?php echo esc_attr( $input ); ?>" placeholder="listing" />
	<?php
}

/**
 * Append listing id to the permalink
 *
 * @since 1.5.0
 */
function listar_listing_id_slug_permalink_callback() {
	$input   = (int) get_option( 'listar_listing_id_slug_permalink' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_listing_id_slug_permalink" name="listar_listing_id_slug_permalink" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Append region slug to the listing permalink
 *
 * @since 1.5.0
 */
function listar_use_region_slug_permalink_callback() {
	$input   = (int) get_option( 'listar_use_region_slug_permalink' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_region_slug_permalink" name="listar_use_region_slug_permalink" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Slug for listings without a region set
 *
 * @since 1.5.0
 */
function listar_absent_region_slug_permalink_callback() {
	$input = get_option( 'listar_absent_region_slug_permalink' );
	?>
	<input type="text" name="listar_absent_region_slug_permalink" value="<?php echo esc_attr( $input ); ?>" placeholder="@" />
	<?php
}

/**
 * Append category slug to the listing permalink
 *
 * @since 1.5.0
 */
function listar_use_category_slug_permalink_callback() {
	$input   = (int) get_option( 'listar_use_category_slug_permalink' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_category_slug_permalink" name="listar_use_category_slug_permalink" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Slug for listings without a category set
 *
 * @since 1.5.0
 */
function listar_absent_category_slug_permalink_callback() {
	$input = get_option( 'listar_absent_category_slug_permalink' );
	?>
	<input type="text" name="listar_absent_category_slug_permalink" value="<?php echo esc_attr( $input ); ?>" placeholder="!" />
	<?php
}


/**
 * Shop archive sidebar
 *
 * @since 1.4.7
 */
function listar_enable_woo_archive_sidebar_callback() {
	$input = get_option( 'listar_enable_woo_archive_sidebar' );
	$input_values = array(
		array( 'disabled', esc_html__( 'Disabled', 'listar' ) ),
		array( 'left', esc_html__( 'On the left', 'listar' ) ),
		array( 'right', esc_html__( 'On the right', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'left';
	}
	?>

	<select name="listar_enable_woo_archive_sidebar" id="listar_enable_woo_archive_sidebar">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Shop product sidebar
 *
 * @since 1.4.7
 */
function listar_enable_woo_product_sidebar_callback() {
	$input = get_option( 'listar_enable_woo_product_sidebar' );
	$input_values = array(
		array( 'disabled', esc_html__( 'Disabled', 'listar' ) ),
		array( 'archive', esc_html__( 'Use archive sidebar', 'listar' ) ),
		array( 'left', esc_html__( 'On the left', 'listar' ) ),
		array( 'right', esc_html__( 'On the right', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'archive';
	}
	?>

	<select name="listar_enable_woo_product_sidebar" id="listar_enable_woo_product_sidebar">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Enable Woocommerce "Downloads" menu from User Dashboard screen.
 *
 * @since 1.0
 */
function listar_enable_woo_downloads_menu_callback() {
	$input   = (int) get_option( 'listar_enable_woo_downloads_menu' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_enable_woo_downloads_menu" name="listar_enable_woo_downloads_menu" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable shopping breadcrumbs
 *
 * @since 1.4.7
 */
function listar_disable_shopping_breadcrumbs_callback() {
	$input   = (int) get_option( 'listar_disable_shopping_breadcrumbs' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_shopping_breadcrumbs" name="listar_disable_shopping_breadcrumbs" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Marketplace Setup Wizard
 *
 * @since 1.4.7
 */

function listar_marketplace_setup_wizard_callback() {
	?>
	<a href="<?php echo esc_url( admin_url( 'index.php?page=wcfm-setup' ) ); ?>" target="_blank">
		<?php esc_html_e( 'Launch', 'listar' ); ?>
	</a>
	<?php
}

/**
 * Marketplace Dashboard
 *
 * @since 1.4.7
 */

function listar_marketplace_dashboard_callback() {
	?>
	<a href="<?php echo esc_url( get_wcfm_page() ); ?>" target="_blank">
		<?php esc_html_e( 'Launch', 'listar' ); ?>
	</a>
	<?php
}

/**
 * Marketplace Settings
 *
 * @since 1.4.7
 */

function listar_marketplace_settings_callback() {
	?>
	<a href="<?php echo esc_url( get_wcfm_page(). 'settings/' ); ?>" target="_blank">
		<?php esc_html_e( 'Launch', 'listar' ); ?>
	</a>
	<?php
}

/**
 * Who can create an online store?
 *
 * @since 1.0
 */
function listar_who_can_create_stores_callback() {
	$input = get_option( 'listar_who_can_create_stores' );
	$input_values = array(
		array( 'listing-package-membership', esc_html__( 'Membership depends on listing packages (default)', 'listar' ) ),
		array( 'all-subscribers', esc_html__( 'All registered users (free store creation)', 'listar' ) ),
		array( 'nobody', esc_html__( 'Nobody (disable store creation)', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'listing-package-membership';
	}
	?>

	<select name="listar_who_can_create_stores" id="listar_who_can_create_stores">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Max products per vendor
 *
 * @since 1.4.7
 */
function listar_limit_products_per_vendor_callback() {
	$input = (string) get_option( 'listar_limit_products_per_vendor' );
	$input_str = strval( $input );
	$input_int = (int) $input;
	
	if ( empty( $input_str ) && '0' !== $input_str && '-1' !== $input_str ) {
		$input = 36;
	} else {
		$input = $input_int;
	}
	?>
	<input type="text" name="listar_limit_products_per_vendor" value="<?php echo esc_attr( $input ); ?>" placeholder="36" />

	<!--<p class="description">
		<?php esc_html_e( "This amount may be overwritten via Package Features, when editing a Listing Package (Woocommerce product).", 'listar' ); ?>
	</p><br />-->
	<?php
}

/**
 * Max disk space per vendor
 *
 * @since 1.4.7
 */
function listar_limit_disk_per_vendor_callback() {
	$input = (string) get_option( 'listar_limit_disk_per_vendor' );
	$input_str = strval( $input );
	$input_int = (int) $input;
	
	if ( empty( $input_str ) && '0' !== $input_str && '-1' !== $input_str ) {
		$input = 500;
	} else {
		$input = $input_int;
	}
	?>
	<input type="text" name="listar_limit_disk_per_vendor" value="<?php echo esc_attr( $input ); ?>" placeholder="500" />
	
	<!--<p class="description">
		<?php esc_html_e( "This amount may be overwritten via Package Features, when editing a Listing Package (Woocommerce product).", 'listar' ); ?>
	</p><br />-->
	<?php
}

/**
 * Enable "Back to Top" button for mobiles
 *
 * @since 1.3.2
 */
function listar_enable_back_to_top_mobile_callback() {
	$input   = (int) get_option( 'listar_enable_back_to_top_mobile' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_enable_back_to_top_mobile" name="listar_enable_back_to_top_mobile" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Disable loading overlay
 *
 * @since 1.3.5
 */
function listar_disable_loading_overlay_callback() {
	$input   = (int) get_option( 'listar_disable_loading_overlay' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_loading_overlay" name="listar_disable_loading_overlay" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "Without the loading overlay, the Pagespeed rank of your site will decrease a little, in case of Listar Pagespeed be active.", 'listar' ); ?>
	</p><br />
	<?php
}

/**
 * Allow only products of the same vendor in the cart
 *
 * @since 1.5.0.5
 */
function listar_restrict_cart_per_vendor_callback() {
	$input   = (int) get_option( 'listar_restrict_cart_per_vendor' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_restrict_cart_per_vendor" name="listar_restrict_cart_per_vendor" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Allow only one product in the cart
 *
 * @since 1.5.0.5
 */
function listar_restrict_cart_per_product_callback() {
	$input   = (int) get_option( 'listar_restrict_cart_per_product' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_restrict_cart_per_product" name="listar_restrict_cart_per_product" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Reset the cart when a product be added
 *
 * @since 1.5.0.5
 */
function listar_restrict_empty_cart_per_product_callback() {
	$input   = (int) get_option( 'listar_restrict_empty_cart_per_product' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_restrict_empty_cart_per_product" name="listar_restrict_empty_cart_per_product" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}


/**
 * Disable the Sign In button on top bar
 *
 * @since 1.0.0
 */
function listar_accept_signup_terms_enabled_callback() {
	$input           = (int) get_option( 'listar_accept_signup_terms_enabled' );
	$listar_checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_accept_signup_terms_enabled" name="listar_accept_signup_terms_enabled" value="1" <?php echo esc_attr( $listar_checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Custom label for Add Listing button
 *
 * @since 1.0.0
 */
function listar_signup_terms_url_callback() {
	$input = get_option( 'listar_signup_terms_url' );
	?>
	<input type="text" name="listar_signup_terms_url" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/**
 * Disable built in Google Fonts manager
 *
 * @since 1.0
 */
function listar_disable_google_fonts_callback() {
	$input   = (int) get_option( 'listar_disable_google_fonts' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_disable_google_fonts" name="listar_disable_google_fonts" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Yes, disable', 'listar' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( "Change fonts on Customize / Google Fonts. Enable this option if you intend to use a third party Google Fonts manager plugin, or in case you don't want to use Google Fonts.", 'listar' ); ?>
	</p><br />
	<?php
}

/**
 * Theme option field/preview output - Update best rated list.
 *
 * @since 1.0
 */
function listar_best_rated_update_button_callback() {
	?>
	<p class="description">
		<?php esc_html_e( 'The "best rated" and "trending" list of listings are automatically updated every 30 minutes.  Click on the link below to force an update. A new tab will be open, just wait the processing be finished.', 'listar' ); ?>
	</p><br />
	<a href="<?php echo esc_url( wp_nonce_url( LISTAR_ADDONS_PLUGIN_DIR_URL . 'inc/update-best-rated.php', 'update_best_rated' ) ); ?>" target="_blank">
		<?php esc_html_e( 'Update lists now', 'listar' ); ?>
	</a>
	<?php
}


/**
 * On front end listing submission form, enable the Text editor (code) for the description field
 *
 * @since 1.4.2.1
 */
function listar_trending_log_callback() {
	?>
	<div class="listar-trending-log-output">
		<?php
		$JSON = get_option( 'listar_trending_listings_and_scores' );
		$list = listar_json_decode_nice( $JSON, true );

		if ( ! empty( $list ) ) :
			$count = 0;

			foreach( $list as $item ) :
				$count++;
				$id = $item[0];
				$score = $item[1];
				?>
				<div class="listar-trending-log-item">
					<?php
					esc_html_e( 'Rank: ', 'listar' );
					echo esc_html( '#' . $count );
					?><br>
					<?php
					esc_html_e( 'Title: ', 'listar' );
					echo esc_html( get_the_title( $id ) );
					?><br>
					<?php
					esc_html_e( 'Trending Score: ', 'listar' );
					echo esc_html( $score );
					?>
				</div>
				<?php
			endforeach;
		else :
			?>
			<div class="listar-trending-log-item">
				<?php esc_html_e( 'No trending listings found for the current trending settings.', 'listar' ); ?>
			</div>
			<?php
		endif;
		?>
	</div>
	<?php
}

/**
 * Blog ************************************************************************
 */

/**
 * Grid design for blog archive
 *
 * @since 1.0
 */
function listar_blog_grid_design_callback() {
	$input = get_option( 'listar_blog_grid_design' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'full-width', esc_html__( 'Full Width', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'full-width';
	}
	?>

	<select name="listar_blog_grid_design" id="listar_blog_grid_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/*
 * Miscellaneous ***************************************************************
 */

/**
 * First screen for icon selector
 *
 * @since 1.4.2
 */
function listar_first_screen_icon_selector_callback() {
	$input = get_option( 'listar_first_screen_icon_selector' );

	$input_values = array(
		array( 'linear', 'Linear' ),
		array( 'awesome', 'Awesome' ),
		array( 'none', esc_html__( 'None', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'linear';
	}
	?>

	<select name="listar_first_screen_icon_selector" id="listar_first_screen_icon_selector">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * On front end listing submission form, enable the Text editor (code) for the description field
 *
 * @since 1.4.2.1
 */
function listar_use_code_editor_frontend_callback() {
	$input   = (int) get_option( 'listar_use_code_editor_frontend' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_use_code_editor_frontend" name="listar_use_code_editor_frontend" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Show Async JavaScript plugin settings
 *
 * @since 1.4.7
 */
function listar_show_async_plugin_settings_callback() {
	$input   = (int) get_option( 'listar_show_async_plugin_settings' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_show_async_plugin_settings" name="listar_show_async_plugin_settings" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Show Autoptimize plugin settings
 *
 * @since 1.4.7
 */
function listar_show_autoptimize_plugin_settings_callback() {
	$input   = (int) get_option( 'listar_show_autoptimize_plugin_settings' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_show_autoptimize_plugin_settings" name="listar_show_autoptimize_plugin_settings" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Color pattern for stripes
 *
 * @since 1.0
 */
function listar_color_stripes_callback() {
	$input = get_option( 'listar_color_stripes' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'color', esc_html__( 'Theme Color', 'listar' ) ),
		array( 'gray', esc_html__( 'Gray', 'listar' ) ),
		array( 'flat-gray', esc_html__( 'Flat Gray', 'listar' ) ),
		array( 'disabled', esc_html__( 'Disable', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'default';
	}
	?>

	<select name="listar_color_stripes" id="listar_color_stripes">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Color pattern for stripes
 *
 * @since 1.0
 */
function listar_background_color_search_button_top_callback() {
	$input = get_option( 'listar_background_color_search_button_top' );

	$input_values = array(
		array( 'rainbow', esc_html__( 'Rainbow', 'listar' ) ),
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'color', esc_html__( 'Theme color', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'rainbow';
	}
	?>

	<select name="listar_background_color_search_button_top" id="listar_background_color_search_button_top">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Background color for login button on top bar
 *
 * @since 1.2.9
 */
function listar_background_color_login_button_top_callback() {
	$input = get_option( 'listar_background_color_login_button_top' );

	$input_values = array(
		array( 'green', esc_html__( 'Green', 'listar' ) ),
		array( 'default', esc_html__( 'Default', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'green';
	}
	?>

	<select name="listar_background_color_login_button_top" id="listar_background_color_login_button_top">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Background color for Add Listing button on top bar
 *
 * @since 1.2.9
 */
function listar_background_color_add_listing_button_top_callback() {
	$input = get_option( 'listar_background_color_add_listing_button_top' );

	$input_values = array(
		array( 'blue', esc_html__( 'Blue', 'listar' ) ),
		array( 'default', esc_html__( 'Default', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'blue';
	}
	?>

	<select name="listar_background_color_add_listing_button_top" id="listar_background_color_add_listing_button_top">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for trending icon
 *
 * @since 1.4.6
 */
function listar_trending_icon_design_callback() {
	$input = get_option( 'listar_trending_icon_design' );

	$input_values = array(
		array( 'light', esc_html__( 'Light', 'listar' ) ),
		array( 'dark', esc_html__( 'Dark', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'light';
	}
	?>

	<select name="listar_trending_icon_design" id="listar_trending_icon_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Design for drop down menu
 *
 * @since 1.0
 */
function listar_drop_dowm_menu_design_callback() {
	$input        = get_option( 'listar_drop_dowm_menu_design' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'color', esc_html__( 'Theme Color', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'default';
	}
	?>

	<select name="listar_drop_dowm_menu_design" id="listar_drop_dowm_menu_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Background color for detail row when hovering listing cards (requires expanded excerpt activation)
 *
 * @since 1.0
 */
function listar_card_detail_row_design_callback() {
	$input        = get_option( 'listar_card_detail_row_design' );
	$input_values = array(
		array( 'default', esc_html__( 'Default', 'listar' ) ),
		array( 'color', esc_html__( 'Theme Color', 'listar' ) ),
	);

	if ( empty( $input ) ) {
		$input = 'default';
	}
	?>

	<select name="listar_card_detail_row_design" id="listar_card_detail_row_design">
		<?php
		foreach ( $input_values as $input_value ) :
			$option_value = $input_value[0];
			$option_name  = $input_value[1];

			$selected = ( $input === $option_value ) ? 'selected="selected"' : '';
			?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
				<?php echo esc_html( $option_name ); ?>
			</option>
			<?php
		endforeach;
		?>

	</select>

	<?php
}

/**
 * Footer **********************************************************************
 */

/**
 * Theme option field/preview output - Footer column 1.
 *
 * @since 1.2.9
 */
function listar_footer_column_1_callback() {
	$input   = (int) get_option( 'listar_footer_column_1' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_footer_column_1" name="listar_footer_column_1" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Footer column 2.
 *
 * @since 1.2.9
 */
function listar_footer_column_2_callback() {
	$input   = (int) get_option( 'listar_footer_column_2' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_footer_column_2" name="listar_footer_column_2" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Footer column 3.
 *
 * @since 1.2.9
 */
function listar_footer_column_3_callback() {
	$input   = (int) get_option( 'listar_footer_column_3' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_footer_column_3" name="listar_footer_column_3" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Footer column 4.
 *
 * @since 1.2.9
 */
function listar_footer_column_4_callback() {
	$input   = (int) get_option( 'listar_footer_column_4' );
	$checked = 1 === $input ? 'checked' : '';
	?>
	<label>
		<input type="checkbox" id="listar_footer_column_4" name="listar_footer_column_4" value="1" <?php echo esc_attr( $checked ); ?> /> <?php esc_html_e( 'Activate', 'listar' ); ?>
	</label>
	<?php
}

/**
 * Theme option field/preview output - Footer copyright.
 *
 * @since 1.0
 */
function listar_copyright_callback() {
	$input = get_option( 'listar_copyright' );
	?>
	<input type="text" name="listar_copyright" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Website name', 'listar' ); ?>" />
	<?php
}

/**
 * Footer company info.
 *
 * @since 1.0
 */
function listar_footer_company_info_callback() {
	$input = get_option( 'listar_footer_company_info' );
	?>
	<input type="text" name="listar_footer_company_info" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Listing city gems', 'listar' ); ?>" />
	<?php
}

/**
 * Footer company info - Site name
 *
 * @since 1.0
 */
function listar_footer_company_site_name_callback() {
	$input = get_option( 'listar_footer_company_site_name' );
	?>
	<input type="text" name="listar_footer_company_site_name" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'Your Company', 'listar' ); ?>" />
	<?php
}

/**
 * Footer company info - Website
 *
 * @since 1.0
 */
function listar_footer_company_site_url_callback() {
	$input = get_option( 'listar_footer_company_site_url' );
	?>
	<input type="text" name="listar_footer_company_site_url" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'http://yourwebsite.com', 'listar' ); ?>" />
	<?php
}

/**
 * Footer copyright - Copyright owner
 *
 * @since 1.0
 */
function listar_copyright_owner_callback() {
	$input = get_option( 'listar_copyright_owner' );
	?>
	<input type="text" name="listar_copyright_owner" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'By Company Name', 'listar' ); ?>" />
	<?php
}

/**
 * Footer copyright - Copyright owner URL
 *
 * @since 1.0
 */
function listar_copyright_owner_url_callback() {
	$input = get_option( 'listar_copyright_owner_url' );
	?>
	<input type="text" name="listar_copyright_owner_url" value="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'http://yourwebsite.com', 'listar' ); ?>" />
	<?php
}

/**
 * Execute after all options has been saved
 *
 * @since 1.0
 */
function listar_execute_after_save_options_callback() {
	$input = rand( 10, 999999999 );
	?>
	<input type="text" class="hidden" name="listar_execute_after_save_options" value="<?php echo esc_attr( $input ); ?>" />
	<?php
}

/* Execute after all options has been saved */

add_action( 'update_option_listar_execute_after_save_options', 'listar_do_after_save_options', 10, 2 );

function listar_do_after_save_options( $old_value, $new_value ) {
	
	/*
	 * For distance meterings **********************************************
	 */

	/* Update latitude and longitude data for secondary fallback address */
	/* Update latitude and longitude data for primary fallback address */
	
	$primary_reference = get_option( 'listar_primary_fallback_listing_reference' );
	$secondary_reference = get_option( 'listar_secondary_fallback_listing_reference' );
	$new_lat_primary = '';
	$new_lng_primary = '';
	$new_lat_secondary = '';
	$new_lng_secondary = '';
	
	if ( ! empty( $primary_reference ) ) {
		$geo = listar_get_geolocated_data_by_address( $primary_reference );

		if ( ! empty( $geo ) ) {
			$new_lat_primary = $geo['geolocation_lat'];
			$new_lng_primary = $geo['geolocation_long'];
		}
	}
	
	if ( ! empty( $secondary_reference ) ) {
		$geo = listar_get_geolocated_data_by_address( $secondary_reference );

		if ( ! empty( $geo ) ) {
			$new_lat_secondary = $geo['geolocation_lat'];
			$new_lng_secondary = $geo['geolocation_long'];
		}
	}
	
	update_option( 'listar_primary_fallback_geolocated_lat', $new_lat_primary );
	update_option( 'listar_primary_fallback_geolocated_lng', $new_lng_primary );
	update_option( 'listar_secondary_fallback_geolocated_lat', $new_lat_secondary );
	update_option( 'listar_secondary_fallback_geolocated_lng', $new_lng_secondary );
}

/**
 * Export theme options (migration) ********************************************
 */

/**
 * Theme option field/preview output - Import or Export options.
 *
 * @since 1.0
 */
function listar_import_export_callback() {
	?>
	<textarea class="import-export"></textarea>
	<?php
}

/**
 * Theme option field/preview output - Import or Export taxonomy icons.
 *
 * @since 1.0
 */
function listar_import_export_tax_icons_callback() {

	$output           = '';
	$taxonomies       = get_taxonomies();
	$taxonomies_array = array();

	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
				'get'      => 'all',
				'number' => 2000,
			)
		);

		if ( ! $terms || is_wp_error( $terms ) ) {
			continue;
		}

		foreach ( $terms as $term ) {

			/* Updating icons */
			$term_data  = get_option( "taxonomy_$term->term_taxonomy_id" );
			$term_icon  = '';
			$term_color = '';

			if ( isset( $term_data['term_icon'] ) ) {
				$term_icon = wp_filter_nohtml_kses( $term_data['term_icon'] );
			}

			if ( isset( $term_data['term_color'] ) ) {
				$term_color = wp_filter_nohtml_kses( $term_data['term_color'] );
			}

			if ( ! empty( $term_color ) || ! empty( $term_icon ) ) {
				$taxonomies_array[] = array(
					$term->name,
					$taxonomy,
					$term_icon,
					$term_color,
				);
			}
		}
	}

	$taxonomies_array_json = wp_json_encode( $taxonomies_array );
	$output .= '<textarea class="import-export-tax-icons">' . $taxonomies_array_json . '</textarea>';

	echo str_replace( array( 'script', '.php', '.js' ), '', $output );
}

/**
 * Theme option field/preview output - Import or Export hero search categories.
 *
 * @since 1.0
 */
function listar_import_export_hero_search_cats_callback() {

	$output      = '';
	$categories  = str_replace( 'x 1,', '', wp_filter_nohtml_kses( get_option( 'listar_hero_search_categories' ) ) );
	$input       = $categories;
	$input_array = array();

	if ( false !== strpos( $input, ',' ) ) {

		if ( ',' === substr( rtrim( $input ), -1 ) ) {
			$input = substr( $input, 0, -1 );
		}

		if ( false !== strpos( $input, ',' ) ) {
			$input_array = explode( ',', $input );
		}
	}

	if ( ! count( $input_array ) ) {
		$input_array[] = $input;
	}

	$categories_temp = array();
	$count = is_array( $input_array ) ? count( $input_array ) : 0;

	for ( $i = 0; $i < $count; $i++ ) {

		$input_array[ $i ] = explode( ' ', $input_array[ $i ], 2 );
		$term = get_term( $input_array[ $i ][0], 'job_listing_category' );

		if ( $term && ! is_wp_error( $term ) ) {
			$categories_temp[] = array(
				$term->name,
				$input_array[ $i ][1],
			);
		}
	}

	$json_categories = wp_json_encode( $categories_temp );
	$output .= '<textarea class="import-export-hero-search-cats">' . $json_categories . '</textarea>';
	echo str_replace( array( 'script', '.php', '.js' ), '', $output );
}

/**
 * Theme option field/preview output - Import or Export taxonomy images.
 *
 * @since 1.0
 */
function listar_import_export_taxonomy_images_callback() {
	$output = '';
	$taxonomies = array(
		'category',
		'job_listing_category',
		'job_listing_region',
	);

	$term_category_image = '';
	$taxonomies_array    = array();
	$count_taxonomies    = is_array( $taxonomies ) ? count( $taxonomies ) : 0;

	for ( $i = 0; $i < $count_taxonomies; $i++ ) {

		if ( ! taxonomy_exists( $taxonomies[ $i ] ) ) {
			continue;
		}

		$term_category_image = ( 'job_listing_region' === $taxonomies[ $i ] ) ? 'job_listing_region-image-id' : $taxonomies[ $i ] . '-image-id';

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomies[ $i ],
				'hide_empty' => false,
				'number' => 2000,
			)
		);

		if ( ! $terms || is_wp_error( $terms ) ) {
			continue;
		}

		foreach ( $terms as $term ) {

			/* Updating icons */
			$image_id = get_term_meta( $term->term_taxonomy_id, $term_category_image, true );

			if ( ! empty( $image_id ) ) {
				$taxonomies_array[] = array(
					$term->name,
					$taxonomies[ $i ],
					$image_id,
				);
			}
		}
	}
	$taxonomies_array_json = wp_json_encode( $taxonomies_array );
	$output .= '<textarea class="import-export-taxonomy-images">' . $taxonomies_array_json . '</textarea>';
	echo str_replace( array( 'script', '.php', '.js' ), '', $output );
}

/**
 * Theme option field/preview output - Import/export rating stars.
 *
 * @since 1.0
 */
function listar_import_export_rating_stars_callback() {

	$args = array(
		'post_type' => 'job_listing',
	);

	$comments      = get_comments( $args );
	$output        = '';
	$ratings_array = array();

	foreach ( $comments as $comment ) {
		$id = $comment->comment_ID;
		$rating = get_comment_meta( $id, 'review_stars' );

		if ( empty( $rating ) ) {
			continue;
		}
		
		$rating_count = is_array( $rating ) ? count( $rating ) : 0;

		if ( 1 === $rating_count ) {
			$rating = $rating[0];
		}

		if ( ! empty( $rating ) ) {
			array_push( $ratings_array, array( $id, $rating ) );
		}
	}

	$ratings_array_json = wp_json_encode( $ratings_array );

	$output .= '<textarea class="import-export-rating-stars">' . $ratings_array_json . '</textarea>';

	echo str_replace( array( 'script', '.php', '.js' ), '', $output );
}

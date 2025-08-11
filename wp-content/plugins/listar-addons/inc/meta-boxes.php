<?php
/**
 * Custom meta boxes
 *
 * @package Listar_Addons
 */

add_action( 'listar_custom_meta_boxes_init', 'listar_custom_meta_boxes' );

if ( ! function_exists( 'listar_custom_meta_boxes' ) ) :
	/**
	 * Sets custom meta boxes.
	 *
	 * @since 1.0
	 */
	function listar_custom_meta_boxes() {

		/* Front page title */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_frontpage_title' );
		add_action( 'save_post', 'listar_meta_box_save_frontpage_title' );

		/* Subtitle field to pages */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_page_subtitle' );
		add_action( 'save_post', 'listar_meta_box_save_page_subtitle' );

		/* 'Page Short Introduction' field to pages */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_page_intro' );
		add_action( 'save_post', 'listar_meta_box_save_page_intro' );

		/* Cover Video URL */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_cover_video_url' );
		add_action( 'save_post', 'listar_meta_box_save_cover_video_url' );

		/* Video Start At */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_cover_video_start' );
		add_action( 'save_post', 'listar_meta_box_save_cover_video_start' );

		/* Video End At */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_cover_video_end' );
		add_action( 'save_post', 'listar_meta_box_save_cover_video_end' );

                /* Minimum screen width for front end hero video */
                add_action( 'add_meta_boxes', 'listar_meta_box_add_cover_video_minimum_screen_width' );
                add_action( 'save_post', 'listar_meta_box_save_cover_video_minimum_screen_width' );

		/* Image upload field to author profile's page */
		add_action( 'show_user_profile', 'listar_meta_box_add_user_image' );
		add_action( 'edit_user_profile', 'listar_meta_box_add_user_image' );
		add_action( 'personal_options_update', 'listar_meta_box_save_user_image' );
		add_action( 'edit_user_profile_update', 'listar_meta_box_save_user_image' );

		/* 'Short Introduction' field to author profile's page */
		add_action( 'show_user_profile', 'listar_meta_box_user_short_introduction', 1 );
		add_action( 'edit_user_profile', 'listar_meta_box_user_short_introduction', 1 );
		add_action( 'personal_options_update', 'listar_meta_box_save_user_short_introduction' );
		add_action( 'edit_user_profile_update', 'listar_meta_box_save_user_short_introduction' );

		/* 'Drafted products' field to Marketplace vendors */
		add_action( 'show_user_profile', 'listar_meta_box_drafted_products', 1 );
		add_action( 'edit_user_profile', 'listar_meta_box_drafted_products', 1 );
		add_action( 'personal_options_update', 'listar_meta_box_save_drafted_products' );
		add_action( 'edit_user_profile_update', 'listar_meta_box_save_drafted_products' );

		/* Hidden 'job_listing-gallery' meta box to listings */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_gallery' );
		add_action( 'save_post', 'listar_meta_box_save_gallery' );

		/* Max Width for Partner Logo */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_max_partner_logo_width' );
		add_action( 'save_post', 'listar_meta_box_save_max_partner_logo_width' );

		/* Partner Slogan */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_partner_slogan' );
		add_action( 'save_post', 'listar_meta_box_save_partner_slogan' );

		/* Partner URL */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_partner_url' );
		add_action( 'save_post', 'listar_meta_box_save_partner_url' );

		/* Partner Background Color */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_partner_background_color' );
		add_action( 'save_post', 'listar_meta_box_save_partner_background_color' );

		/* Partner Secondary Background Color (For Gradient) */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_partner_secondary_background_color' );
		add_action( 'save_post', 'listar_meta_box_save_partner_secondary_background_color' );

		/* Views counter */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_views_counter' );
		add_action( 'save_post', 'listar_meta_box_save_views_counter' );
		
		if ( listar_bookmarks_active_plugin() ) {

			/* 'Bookmarked listing IDs' field to author profile's page */
			add_action( 'show_user_profile', 'listar_meta_box_user_bookmarked_posts', 1 );
			add_action( 'edit_user_profile', 'listar_meta_box_user_bookmarked_posts', 1 );
			add_action( 'personal_options_update', 'listar_meta_box_save_user_bookmarked_posts' );
			add_action( 'edit_user_profile_update', 'listar_meta_box_save_user_bookmarked_posts' );

			/* Bookmarks counter */
			add_action( 'add_meta_boxes', 'listar_meta_box_add_bookmarks_counter' );
			add_action( 'save_post', 'listar_meta_box_save_bookmarks_counter' );

			/* Bookmarks user IDs */
			add_action( 'add_meta_boxes', 'listar_meta_box_add_bookmarks_user_ids' );
			add_action( 'save_post', 'listar_meta_box_save_bookmarks_user_ids' );
		}

		/* Package Features */
		add_action( 'add_meta_boxes', 'listar_meta_box_add_package_options' );
		add_action( 'save_post', 'listar_meta_box_save_package_options' );
		
	}
endif;

/*
 * Front page title ************************************************************
 */

/**
 * Meta box for front page title.
 *
 * @since 1.0
 */
function listar_meta_box_add_frontpage_title() {

	add_meta_box( 'listar_meta_box_frontpage_title', esc_html__( 'Front Page Title', 'listar' ), 'listar_meta_box_frontpage_title_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_frontpage_title().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_frontpage_title_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_frontpage_title', 'listar_meta_box_frontpage_title_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_frontpage_title', true );
	?>
	<input type="text" id="listar_meta_box_frontpage_title_field" name="listar_meta_box_frontpage_title_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_frontpage_title( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_frontpage_title_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_frontpage_title_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_frontpage_title' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_frontpage_title', $my_data );
}


/**
 * Meta box for subtitle to pages.
 *
 * @since 1.0
 */
function listar_meta_box_add_page_subtitle() {

	add_meta_box( 'listar_meta_box_page_subtitle', esc_html__( 'Page Subtitle', 'listar' ), 'listar_meta_box_page_subtitle_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_page_subtitle().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_page_subtitle_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_page_subtitle', 'listar_meta_box_page_subtitle_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_page_subtitle', true );
	?>
	<input type="text" id="listar_meta_box_page_subtitle_field" name="listar_meta_box_page_subtitle_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_page_subtitle( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_page_subtitle_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_page_subtitle_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_page_subtitle' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_page_subtitle', $my_data );
}


/**
 * Meta box for 'Short Introduction' to pages.
 *
 * @since 1.0
 */
function listar_meta_box_add_page_intro() {

	add_meta_box( 'listar_meta_box_page_intro', esc_html__( 'Page Short Introduction', 'listar' ), 'listar_meta_box_page_intro_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_page_intro().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_page_intro_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_page_intro', 'listar_meta_box_page_intro_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_page_intro', true );
	?>
	<input type="text" id="listar_meta_box_page_intro_field" name="listar_meta_box_page_intro_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_page_intro( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_page_intro_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_page_intro_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_page_intro' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_page_intro', $my_data );
}

/*
 * Cover Video URL ************************************************************
 */

/**
 * Meta box for cover video URL.
 *
 * @since 1.5.2
 */
function listar_meta_box_add_cover_video_url() {

	add_meta_box( 'listar_meta_box_cover_video_url', esc_html__( 'Cover Video URL', 'listar' ), 'listar_meta_box_cover_video_url_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_cover_video_url().
 *
 * @since 1.5.2
 * @param (object) $page The page object.
 */
function listar_meta_box_cover_video_url_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_cover_video_url', 'listar_meta_box_cover_video_url_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_cover_video_url', true );
	?>
	<input type="text" id="listar_meta_box_cover_video_url_field" name="listar_meta_box_cover_video_url_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<p class="description">
		<?php esc_html_e( 'Youtube, Vimeo or .mp4 link', 'listar' ); ?>
	</p>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.5.2
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_cover_video_url( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_cover_video_url_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_cover_video_url_field', FILTER_SANITIZE_URL );

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_cover_video_url' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_cover_video_url', $my_data );
}



/**
 * Meta box for video start at.
 *
 * @since 1.5.2
 */
function listar_meta_box_add_cover_video_start() {

	add_meta_box( 'listar_meta_box_cover_video_start', esc_html__( 'Video Start At', 'listar' ), 'listar_meta_box_cover_video_start_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_cover_video_start().
 *
 * @since 1.5.2
 * @param (object) $page The page object.
 */
function listar_meta_box_cover_video_start_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_cover_video_start', 'listar_meta_box_cover_video_start_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_cover_video_start', true );
	?>
	<input type="text" id="listar_meta_box_cover_video_start_field" name="listar_meta_box_cover_video_start_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<p class="description">
		<?php esc_html_e( 'Time in seconds', 'listar' ); ?>
	</p>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.5.2
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_cover_video_start( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_cover_video_start_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_cover_video_start_field', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_cover_video_start' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_cover_video_start', $my_data );
}




/**
 * Meta box for video end at.
 *
 * @since 1.5.2
 */
function listar_meta_box_add_cover_video_end() {

	add_meta_box( 'listar_meta_box_cover_video_end', esc_html__( 'Video End At', 'listar' ), 'listar_meta_box_cover_video_end_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_cover_video_end().
 *
 * @since 1.5.2
 * @param (object) $page The page object.
 */
function listar_meta_box_cover_video_end_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_cover_video_end', 'listar_meta_box_cover_video_end_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_cover_video_end', true );
	?>
	<input type="text" id="listar_meta_box_cover_video_end_field" name="listar_meta_box_cover_video_end_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<p class="description">
		<?php esc_html_e( 'Time in seconds', 'listar' ); ?>
	</p>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.5.2
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_cover_video_end( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_cover_video_end_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_cover_video_end_field', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_cover_video_end' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_cover_video_end', $my_data );
}

/**
 * Meta box for cover video minumum width.
 *
 * @since 1.5.3
 */
function listar_meta_box_add_cover_video_minimum_screen_width() {

        add_meta_box( 'listar_meta_box_cover_video_minimum_screen_width', esc_html__( 'Minimum screen width for front end hero video', 'listar' ), 'listar_meta_box_cover_video_minimum_screen_width_callback', 'page', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_cover_video_minimum_screen_width().
 *
 * @since 1.5.3
 * @param (object) $page The page object.
 */
function listar_meta_box_cover_video_minimum_screen_width_callback( $page ) {

        $screen_width = array(
                0 => esc_html__( 'All Screens', 'listar' ),
                400 => '400',
                600 => '600',
                800 => '800',
                1000 => '1000',
                1300 => '1300',
                1500 => '1500',
                1800 => '1800',
        );

        wp_nonce_field( 'listar_meta_box_save_cover_video_minimum_screen_width', 'listar_meta_box_cover_video_minimum_screen_width_nonce' );
        $value = (int) get_post_meta( $page->ID, 'listar_meta_box_cover_video_minimum_screen_width', true );

        if ( empty( $value ) ) {
                $value = '0';
        }
        ?>

        <select id="listar_meta_box_cover_video_minimum_screen_width_field" name="listar_meta_box_cover_video_minimum_screen_width_field" class="widefat">
                <?php
                foreach ( $screen_width as $size => $label ) :
                        $selected = ( $value === $size ) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr( $size ); ?>" <?php echo wp_kses( $selected, 'strip' ); ?>>
                                <?php echo esc_html( $label ); ?>
                        </option>
                        <?php
                endforeach;
                ?>

        </select>
        <?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.5.3
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_cover_video_minimum_screen_width( $page_id ) {

        $nonce = filter_input( INPUT_POST, 'listar_meta_box_cover_video_minimum_screen_width_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
        $input = filter_input( INPUT_POST, 'listar_meta_box_cover_video_minimum_screen_width_field', FILTER_SANITIZE_URL );

        if ( empty( $nonce ) ) {
                return;
        }

        if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_cover_video_minimum_screen_width' ) ) {
                return;
        }

        if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
        }

        if ( ! current_user_can( 'edit_post', $page_id ) ) {
                return;
        }

        $my_data = wp_filter_nohtml_kses( $input );

        update_post_meta( $page_id, 'listar_meta_box_cover_video_minimum_screen_width', $my_data );
}

/**
 * Add an image upload field to author profile's page on WordPress admin.
 *
 * @since 1.0
 * @param (object) $user The user object containing data for current user.
 */
function listar_meta_box_add_user_image( $user ) {

	wp_enqueue_media();

	$user_image_id  = (int) get_the_author_meta( 'listar_meta_box_user_image', $user->ID );
	$user_image     = ! empty( $user_image_id ) ? wp_get_attachment_image_src( $user_image_id, 'listar-thumbnail' ) : false;
	$conditions     = false !== $user_image && isset( $user_image[0] ) && ! empty( $user_image[0] );
	$user_image_url = $conditions ? $user_image[0] : '';
	?>
	<table id="profile-pic-table" class="form-table">
		<tr>
			<th>
				<label for="listar_meta_box_user_image">
					<?php esc_html_e( 'Profile Picture', 'listar' ); ?>
				</label>
			</th>
			<td>

			<p>
			<?php
			if ( empty( $user_image_url ) ) :
				?>
				<div class="adm-pic-wrapper hidden">
					<img id="listar_general_background_image-preview" class="adm-pic-prev" />
				</div>
				<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Add image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" />&nbsp;
				<input type="button" class="button button-secondary upload-adm-remove hidden" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
				<input type="hidden" name="listar_meta_box_user_image" id="listar_meta_box_user_image" class="upload-adm-field" >
				<?php
			else :
				?>
				<div class="adm-pic-wrapper">
					<img class="adm-pic-prev" src="<?php echo esc_url( $user_image_url ); ?>" />
				</div>
				<input type="button" class="button button-secondary upload-adm-button" value="<?php esc_attr_e( 'Replace image', 'listar' ); ?>" data-value="<?php esc_attr_e( 'Add image', 'listar' ); ?>" />&nbsp;
				<input type="button" class="button button-secondary upload-adm-remove" value="<?php esc_attr_e( 'Remove', 'listar' ); ?>" />
				<input type="hidden" name="listar_meta_box_user_image" id="listar_meta_box_user_image" class="upload-adm-field" value="<?php echo esc_attr( $user_image_id ); ?>">
				<?php
			endif;
			?>

			</p>
				<p class="description">
					<?php esc_html_e( 'Upload a profile picture.', 'listar' ); ?>
				</p>
			</td>
		</tr>
	</table><!-- end form-table -->
	<?php
}

/**
 * Saves additional user fields to the database.
 *
 * @since 1.0
 * @param (integer) $user_id The ID of the user.
 */
function listar_meta_box_save_user_image( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$input = (int) filter_input( INPUT_POST, 'listar_meta_box_user_image', FILTER_VALIDATE_INT );
	update_user_meta( $user_id, 'listar_meta_box_user_image', $input );
}

/**
 * Add Short Introduction field to author profile's page on WordPress admin.
 *
 * @since 1.0
 * @param (object) $user The user object containing data for current user.
 */
function listar_meta_box_user_short_introduction( $user ) {
	?>
	<table id="user-intro-table" class="form-table">
		<tr>
			<th>
				<label for="listar_meta_box_user_short_introduction">
					<?php esc_html_e( 'Short Introduction', 'listar' ); ?>
				</label>
			</th>
			<td>
				<input type="text" name="listar_meta_box_user_short_introduction" id="listar_meta_box_user_short_introduction" value="<?php echo esc_attr( get_the_author_meta( 'listar_meta_box_user_short_introduction', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Saves additional user fields to the database.
 *
 * @since 1.0
 * @param (integer) $user_id The user ID.
 */
function listar_meta_box_save_user_short_introduction( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$input = filter_input( INPUT_POST, 'listar_meta_box_user_short_introduction', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	update_user_meta( $user_id, 'listar_meta_box_user_short_introduction', $input );
}

/**
 * Add 'Drafted products' field to Marketplace vendor profile's page on WordPress admin.
 *
 * @since 1.4.7
 * @param (object) $user The user object containing data for current user.
 */
function listar_meta_box_drafted_products( $user ) {
	?>
	<table id="user-intro-table" class="form-table">
		<tr>
			<th>
				<label for="listar_meta_box_drafted_products">
					<?php esc_html_e( 'Drafted Products', 'listar' ); ?>
				</label>
			</th>
			<td>
				<textarea name="listar_meta_box_drafted_products" id="listar_meta_box_drafted_products" class="regular-text"><?php echo esc_textarea( get_the_author_meta( 'listar_meta_box_drafted_products', $user->ID ) ); ?></textarea>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Saves additional user fields to the database.
 *
 * @since 1.4.7
 * @param (integer) $user_id The user ID.
 */
function listar_meta_box_save_drafted_products( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$input = filter_input( INPUT_POST, 'listar_meta_box_drafted_products', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	update_user_meta( $user_id, 'listar_meta_box_drafted_products', $input );
}

/**
 * Add 'Bookmarked listing IDs' field to author profile's page on WordPress admin.
 *
 * @since 1.3.9
 * @param (object) $user The user object containing data for current user.
 */
function listar_meta_box_user_bookmarked_posts( $user ) {
	?>
	<input type="hidden" name="listar_meta_box_user_bookmarked_posts" id="listar_meta_box_user_bookmarked_posts" value="<?php echo esc_attr( get_the_author_meta( 'listar_meta_box_user_bookmarked_posts', $user->ID ) ); ?>" class="regular-text" />
	<?php
}

/**
 * Saves additional user fields to the database.
 *
 * @since 1.3.9
 * @param (integer) $user_id The user ID.
 */
function listar_meta_box_save_user_bookmarked_posts( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$input = filter_input( INPUT_POST, 'listar_meta_box_user_bookmarked_posts', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	update_user_meta( $user_id, 'listar_meta_box_user_bookmarked_posts', $input );
}

/**
 * Capture gallery (attachment IDs) of current listing on admin editor and save it.
 *
 * @since 1.0
 */
function listar_meta_box_save_gallery() {

	global $post;

	$gallery = esc_attr( filter_input( INPUT_POST, 'gallery_images' ) );

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! is_object( $post ) ) {
		return;
	}

	if ( 'job_listing' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	if ( empty( $gallery ) ) {
		return;
	}

	$urls = array();
	$gallery_shortcode = $gallery;
	$g = listar_meta_box_process_gallery_code( $gallery );

	foreach ( $g as $id ) {
		$image = wp_get_attachment_image_src( (int) $id, 'full' );
		$conditions = false !== $image && isset( $image[0] ) && ! empty( $image[0] );

		if ( $conditions ) :
			$urls[] = $image[0];
		endif;
	}

	update_post_meta( $post->ID, '_gallery_images', $urls );
	update_post_meta( $post->ID, '_gallery', $gallery_shortcode );
}

/**
 * Meta box for listing gallery.
 *
 * @since 1.0
 */
function listar_meta_box_add_gallery() {

	if ( post_type_exists( 'job_listing' ) ) :
		$listings = get_post_type_object( 'job_listing' );
		add_meta_box( 'job_listing-gallery', esc_html__( 'Gallery', 'listar' ), 'listar_meta_box_set_gallery_callback', $listings->name, 'side' );
	endif;
}

/**
 * Convert gallery shortcode to an array of image IDs.
 *
 * @since 1.0
 * @param (string) $g Gallery shortcode.
 */
function listar_meta_box_process_gallery_code( $g ) {

	$replace = array( '[gallery ids=', ']' );
	$gallery = str_replace( $replace, '', $g );

	if ( false !== strpos( $gallery, ',' ) ) {
		$gallery = explode( ',', $gallery );
	} else {
		$gallery = array( $gallery );
	}

	return $gallery;
}

/**
 * Print the listing gallery.
 *
 * @since 1.0
 * @param (object) $post The post object.
 */
function listar_meta_box_set_gallery_callback( $post ) {

	$gallery = $post->_gallery;

	if ( $gallery && '[gallery ids=]' !== $gallery ) :

		if ( is_string( $gallery ) ) {
			$gallery = listar_meta_box_process_gallery_code( $gallery );
		}

		foreach ( $gallery as $key => $i ) {
			if ( ! is_numeric( $i ) ) {
				unset( $gallery[ $key ] );
			}
		}

	else :
		$gallery = array();
	endif;

	$gallery_ids = '[gallery ids=' . implode( ',', $gallery ) . ']';
	$max_images = 2000;
	$count_gallery = is_array( $gallery ) ? count( $gallery ) : 0;

	if ( 0 === $count_gallery ) :
		$gallery = array( 999999999 );
	endif;
	?>
	<div class="listing-gallery-holder">
		<div class="gallery-list">
			<?php
			$attachments = new WP_Query(
				array(
					'post__in'       => $gallery,
					'posts_per_page' => $max_images,
					'post_mime_type' => 'image',
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'fields'         => 'ids',
				)
			);

			if ( ! $attachments->have_posts() ) {
				if ( ! is_admin() ) :
					?>
					<div class="gallery-no-images">
						<?php esc_html_e( 'No images found.', 'listar' ); ?>
					</div>
					<?php
				endif;
			} else {
				foreach ( $attachments->posts as $id ) :
					$thumbnail  = wp_get_attachment_image_src( $id, 'listar-thumbnail' );
					$conditions = false !== $thumbnail && isset( $thumbnail[0] ) && ! empty( $thumbnail[0] );

					if ( ! $conditions ) :
						continue;
					endif;
					?>
					<a id="gallery-img-<?php echo esc_attr( $id ); ?>" target="blank" href="<?php echo esc_url( $thumbnail[0] ); ?>" class="listing-gallery-preview-thumb" style="background-image:url(<?php echo esc_url( $thumbnail[0] ); ?>);"></a>
					<?php
				endforeach;
			}
			?>
		</div>
		<input type="hidden" name="gallery_images" id="gallery_images" value="<?php echo esc_attr( $gallery_ids ); ?>" />

	</div>

	<p class="listing-gallery-upload-images hide-if-no-js">
		<a href="#" class="edit_gallery">
			<?php esc_html_e( 'Edit Gallery', 'listar' ); ?>
		</a> &nbsp;
		<a href="#" class="reset_gallery">
			<?php esc_html_e( 'Remove All', 'listar' ); ?>
		</a>
	</p>

	<?php
}

/*
 * Max Width for Partner Logo **************************************************
 */

/**
 * Meta box for max width for image.
 *
 * @since 1.0
 */
function listar_meta_box_add_max_partner_logo_width() {

	add_meta_box( 'listar_meta_box_max_partner_logo_width', esc_html__( 'Max Width for Partner Logo (Pixels)', 'listar' ), 'listar_meta_box_max_partner_logo_width_callback', 'listar_partner', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_max_partner_logo_width().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_max_partner_logo_width_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_max_partner_logo_width', 'listar_meta_box_max_partner_logo_width_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_max_partner_logo_width', true );
	?>
	<input type="text" id="listar_meta_box_max_partner_logo_width_field" name="listar_meta_box_max_partner_logo_width_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_max_partner_logo_width( $page_id ) {

	$nonce   = filter_input( INPUT_POST, 'listar_meta_box_max_partner_logo_width_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input   = filter_input( INPUT_POST, 'listar_meta_box_max_partner_logo_width_field', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_max_partner_logo_width' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = (int) $input;

	update_post_meta( $page_id, 'listar_meta_box_max_partner_logo_width', $my_data );
}

/*
 * Partner Slogan **************************************************************
 */

/**
 * Meta box for partners slogan.
 *
 * @since 1.0
 */
function listar_meta_box_add_partner_slogan() {

	add_meta_box( 'listar_meta_box_partner_slogan', esc_html__( 'Partner Slogan', 'listar' ), 'listar_meta_box_partner_slogan_callback', 'listar_partner', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_partner_slogan().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_partner_slogan_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_partner_slogan', 'listar_meta_box_partner_slogan_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_partner_slogan', true );
	?>
	<input type="text" id="listar_meta_box_partner_slogan_field" name="listar_meta_box_partner_slogan_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_partner_slogan( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_partner_slogan_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_partner_slogan_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_partner_slogan' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = esc_html( $input );

	update_post_meta( $page_id, 'listar_meta_box_partner_slogan', $my_data );
}


/*
 * Partners URL ****************************************************************
 */

/**
 * Meta box for partners URL.
 *
 * @since 1.0
 */
function listar_meta_box_add_partner_url() {

	add_meta_box( 'listar_meta_box_partner_url', esc_html__( 'Partner URL', 'listar' ), 'listar_meta_box_partner_url_callback', 'listar_partner', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_partner_url().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_partner_url_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_partner_url', 'listar_meta_box_partner_url_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_partner_url', true );
	?>
	<input type="text" id="listar_meta_box_partner_url_field" name="listar_meta_box_partner_url_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_partner_url( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_partner_url_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_partner_url_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_partner_url' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = listar_sanitize_url( $input );

	update_post_meta( $page_id, 'listar_meta_box_partner_url', $my_data );
}

/*
 * Partners Background Color ***************************************************
 */

/**
 * Meta box for partners background color.
 *
 * @since 1.0
 */
function listar_meta_box_add_partner_background_color() {

	add_meta_box( 'listar_meta_box_partner_background_color', esc_html__( 'Background Color', 'listar' ), 'listar_meta_box_partner_background_color_callback', 'listar_partner', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_partner_background_color().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_partner_background_color_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_partner_background_color', 'listar_meta_box_partner_background_color_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_partner_background_color', true );
	?>
	<input type="text" id="listar_meta_box_partner_background_color_field" name="listar_meta_box_partner_background_color_field" value="<?php echo esc_attr( $value ); ?>" class="widefat wp-color-picker"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_partner_background_color( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_partner_background_color_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_partner_background_color_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_partner_background_color' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = esc_html( $input );

	update_post_meta( $page_id, 'listar_meta_box_partner_background_color', $my_data );
}


/*
 * Partners Secondary Background Color (For Gradient) **************************
 */

/**
 * Meta box for partners secondary background color.
 *
 * @since 1.0
 */
function listar_meta_box_add_partner_secondary_background_color() {

	add_meta_box( 'listar_meta_box_partner_secondary_background_color', esc_html__( 'Secondary Background Color (For Gradient)', 'listar' ), 'listar_meta_box_partner_secondary_background_color_callback', 'listar_partner', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_partner_secondary_background_color().
 *
 * @since 1.0
 * @param (object) $page The page object.
 */
function listar_meta_box_partner_secondary_background_color_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_partner_secondary_background_color', 'listar_meta_box_partner_secondary_background_color_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_partner_secondary_background_color', true );
	?>
	<input type="text" id="listar_meta_box_partner_secondary_background_color_field" name="listar_meta_box_partner_secondary_background_color_field" value="<?php echo esc_attr( $value ); ?>" class="widefat wp-color-picker"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.0
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_partner_secondary_background_color( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_partner_secondary_background_color_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_partner_secondary_background_color_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_partner_secondary_background_color' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = esc_html( $input );

	update_post_meta( $page_id, 'listar_meta_box_partner_secondary_background_color', $my_data );
}


/*
 * Views counter ***************************************************************
 */

/**
 * Meta box for views counter.
 *
 * @since 1.3.9
 */
function listar_meta_box_add_views_counter() {

	add_meta_box( 'listar_meta_box_views_counter', esc_html__( 'Views counter', 'listar' ), 'listar_meta_box_views_counter_callback', 'job_listing', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_views_counter().
 *
 * @since 1.3.9
 * @param (object) $page The page object.
 */
function listar_meta_box_views_counter_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_views_counter', 'listar_meta_box_views_counter_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_views_counter', true );
	?>
	<input type="text" id="listar_meta_box_views_counter_field" name="listar_meta_box_views_counter_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.3.9
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_views_counter( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_views_counter_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_views_counter_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_views_counter' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_views_counter', $my_data );
}


/*
 * Bookmarks counter ***************************************************************
 */

/**
 * Meta box for bookmarks counter.
 *
 * @since 1.3.9
 */
function listar_meta_box_add_bookmarks_counter() {

	add_meta_box( 'listar_meta_box_bookmarks_counter', esc_html__( 'Bookmarks counter', 'listar' ), 'listar_meta_box_bookmarks_counter_callback', 'job_listing', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_bookmarks_counter().
 *
 * @since 1.3.9
 * @param (object) $page The page object.
 */
function listar_meta_box_bookmarks_counter_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_bookmarks_counter', 'listar_meta_box_bookmarks_counter_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_bookmarks_counter', true );
	?>
	<input type="text" id="listar_meta_box_bookmarks_counter_field" name="listar_meta_box_bookmarks_counter_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.3.9
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_bookmarks_counter( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_bookmarks_counter_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_bookmarks_counter_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_bookmarks_counter' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = wp_filter_nohtml_kses( $input );

	update_post_meta( $page_id, 'listar_meta_box_bookmarks_counter', $my_data );
}


/*
 * Bookmarks user IDS ***************************************************************
 */

/**
 * Meta box for Bookmarks user IDS.
 *
 * @since 1.3.9
 */
function listar_meta_box_add_bookmarks_user_ids() {

	add_meta_box( 'listar_meta_box_bookmarks_user_ids', esc_html__( 'Bookmarks user IDS', 'listar' ), 'listar_meta_box_bookmarks_user_ids_callback', 'job_listing', 'side', 'high' );
}

/**
 * Callback for listar_meta_box_add_bookmarks_user_ids().
 *
 * @since 1.3.9
 * @param (object) $page The page object.
 */
function listar_meta_box_bookmarks_user_ids_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_bookmarks_user_ids', 'listar_meta_box_bookmarks_user_ids_nonce' );
	$value = get_post_meta( $page->ID, 'listar_meta_box_bookmarks_user_ids', true );
	?>
	<input type="text" id="listar_meta_box_bookmarks_user_ids_field" name="listar_meta_box_bookmarks_user_ids_field" value="<?php echo esc_attr( $value ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.3.9
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_bookmarks_user_ids( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_bookmarks_user_ids_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_bookmarks_user_ids_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_bookmarks_user_ids' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = preg_replace( '/[^0-9,]/', '', $input );

	update_post_meta( $page_id, 'listar_meta_box_bookmarks_user_ids', wp_filter_nohtml_kses( $my_data ) );
}


/*
 * Package options *************************************************************
 */

/**
 * Meta box for package features.
 *
 * @since 1.4.2
 */
function listar_meta_box_add_package_options() {

	add_meta_box( 'listar_meta_box_package_options', esc_html__( 'Package Features', 'listar' ), 'listar_meta_box_package_options_callback', 'product', 'normal', 'high' );
}

/**
 * Callback for listar_meta_box_add_package_options().
 *
 * @since 1.4.2
 * @param (object) $page The page object.
 */
function listar_meta_box_package_options_callback( $page ) {

	wp_nonce_field( 'listar_meta_box_save_package_options', 'listar_meta_box_package_options_nonce' );
	$value_saved = get_post_meta( $page->ID, 'listar_meta_box_package_options', true );
	
	$package_options = array(
		array( 'listar_customization_custom_package_option', esc_html__( 'Enable Customization', 'listar' ), '' ),
		
		array( 'listar_disable_limit_setup_custom_package_option', esc_html__( 'Pricing card: display the number of listings set up', 'listar' ), '' ),
		array( 'listar_disable_featured_setup_custom_package_option', esc_html__( 'Pricing card: display "Featured" set up', 'listar' ), '' ),
		array( 'listar_disable_promotional_setup_custom_package_option', esc_html__( 'Pricing card: display if promotional price is set up', 'listar' ), '' ),
		array( 'listar_disable_expiration_setup_custom_package_option', esc_html__( 'Pricing card: display expiration set up', 'listar' ), '' ),

		
		array( 'listar_disable_vendor_store_custom_package_option', esc_html__( 'Create Store, Sell Products', 'listar' ), '' ),
		array( 'listar_disable_private_message_custom_package_option', esc_html__( 'Private Messages', 'listar' ), '' ),
		array( 'listar_disable_job_listing_subtitle_custom_package_option', esc_html__( 'Listing Subtitle', 'listar' ), 'has-required' ),
		array( 'listar_location_disable_custom_package_option', esc_html__( 'Location', 'listar' ), 'has-required' ),
		array( 'listar_disable_map_custom_package_option', esc_html__( 'Map', 'listar' ), '' ),
		array( 'listar_disable_job_tagline_custom_package_option', esc_html__( 'Tagline or Slogan', 'listar' ), 'has-required' ),		
		array( 'listar_disable_job_listing_region_custom_package_option', esc_html__( 'Listing Regions', 'listar' ), 'has-required' ),
		array( 'listar_disable_job_listing_category_custom_package_option', esc_html__( 'Listing Categories', 'listar' ), 'has-required' ),
		array( 'listar_disable_job_listing_amenity_custom_package_option', esc_html__( 'Listing Amenities', 'listar' ), 'has-required' ),
		array( 'listar_disable_job_searchtags_custom_package_option', esc_html__( 'Search Tags', 'listar' ), 'has-required' ),
		array( 'listar_operating_hours_disable_custom_package_option', esc_html__( 'Operation Hours', 'listar' ), 'has-required' ),
		array( 'listar_menu_catalog_disable_custom_package_option', esc_html__( 'Menu/Catalog', 'listar' ), 'has-required' ),
		array( 'listar_booking_service_disable_custom_package_option', esc_html__( 'Appointments', 'listar' ), 'has-required' ),
		array( 'listar_price_range_disable_custom_package_option', esc_html__( 'Price Range', 'listar' ), 'has-required' ),
		array( 'listar_popular_price_disable_custom_package_option', esc_html__( 'Average Price', 'listar' ), 'has-required' ),
		array( 'listar_main_image_disable_custom_package_option', esc_html__( 'Main Image', 'listar' ), 'has-required' ),
		array( 'listar_logo_disable_custom_package_option', esc_html__( 'Listing Logo', 'listar' ), 'has-required' ),
		array( 'listar_disable_gallery_images_custom_package_option', esc_html__( 'Images to Gallery', 'listar' ), 'has-required' ),
		array( 'listar_disable_company_youtube_custom_package_option', esc_html__( 'Videos And Other Media', 'listar' ), '' ),
		array( 'listar_phone_disable_custom_package_option', esc_html__( 'Phone', 'listar' ), 'has-required' ),
		array( 'listar_mobile_disable_custom_package_option', esc_html__( 'Mobile', 'listar' ), 'has-required' ),
		array( 'listar_whatsapp_disable_custom_package_option', esc_html__( 'WhatsApp', 'listar' ), 'has-required' ),
		array( 'listar_fax_disable_custom_package_option', esc_html__( 'Fax', 'listar' ), 'has-required' ),
		array( 'listar_website_disable_custom_package_option', esc_html__( 'Website', 'listar' ), 'has-required' ),
		array( 'listar_social_networks_disable_custom_package_option', esc_html__( 'Social Networks', 'listar' ), 'has-required' ),
		array( 'listar_external_references_disable_custom_package_option', esc_html__( 'External References', 'listar' ), 'has-required' ),
	);
	?>
	<table class="listar_package_options">
		<?php
		foreach( $package_options as $package_option ) :
			$listar_booking_service_disable = (int) get_option( 'listar_appointments_disable' );
			$listar_vendor_store_disable = get_option( 'listar_who_can_create_stores' );
			$listar_private_message_disable = (int) get_option( 'listar_disable_private_message' );
			$listar_location_disable = (int) get_option( 'listar_location_disable' );
			$listar_map_disable = (int) ( ! ( listar_is_map_enabled( 'all' ) && listar_is_map_enabled( 'single' ) ) );
			$listar_operating_hours_disable = (int) get_option( 'listar_operating_hours_disable' );
			$listar_menu_disable = (int) get_option( 'listar_menu_catalog_disable' );
			$listar_appointments_disable = (int) get_option( 'listar_appointments_disable' );
			$listar_price_range_disable = (int) get_option( 'listar_price_range_disable' );
			$listar_popular_price_disable = (int) get_option( 'listar_popular_price_disable' );
			$listar_logo_disable = (int) get_option( 'listar_logo_disable' );
			$listar_phone_disable = (int) get_option( 'listar_phone_disable' );
			$listar_mobile_disable = (int) get_option( 'listar_mobile_disable' );
			$listar_fax_disable = (int) get_option( 'listar_fax_disable' );
			$listar_whatsapp_disable = (int) get_option( 'listar_whatsapp_disable' );
			$listar_website_disable = (int) get_option( 'listar_website_disable' );
			$listar_social_disable = (int) get_option( 'listar_social_networks_disable' );
			$listar_references_disable = (int) get_option( 'listar_external_references_disable' );
			$listar_tags_enabled = (int) get_option( 'listar_use_search_listing_tags_data' );
			
			if ( empty( $listar_vendor_store_disable ) ) {
				$listar_vendor_store_disable = 'listing-package-membership';
			}
			
			/* Skip if a feature is inactive in some way */
			if (
				( ! class_exists( 'Astoundify_Job_Manager_Regions' ) && 'listar_disable_job_listing_region_custom_package_option' === $package_option[0] )
				|| ( ! taxonomy_exists( 'job_listing_category' ) && 'listar_disable_job_listing_category_custom_package_option' === $package_option[0] )
				|| ( ! taxonomy_exists( 'job_listing_amenity' ) && 'listar_disable_job_listing_amenity_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_booking_service_disable && 'listar_booking_service_disable_custom_package_option' === $package_option[0] )
				|| ( 'nobody' === $listar_vendor_store_disable && 'listar_disable_vendor_store_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_private_message_disable && 'listar_disable_private_message_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_location_disable && 'listar_location_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_map_disable && 'listar_disable_map_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_operating_hours_disable && 'listar_operating_hours_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_menu_disable && 'listar_menu_catalog_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_appointments_disable && 'listar_booking_service_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_price_range_disable && 'listar_price_range_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_popular_price_disable && 'listar_popular_price_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_logo_disable && 'listar_logo_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_phone_disable && 'listar_phone_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_mobile_disable && 'listar_mobile_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_fax_disable && 'listar_fax_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_whatsapp_disable && 'listar_whatsapp_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_website_disable && 'listar_website_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_social_disable && 'listar_social_networks_disable_custom_package_option' === $package_option[0] )
				|| ( 1 === $listar_references_disable && 'listar_external_references_disable_custom_package_option' === $package_option[0] )
				|| ( 0 === $listar_tags_enabled && 'listar_disable_job_searchtags_custom_package_option' === $package_option[0] )
			) :
				continue;
			endif;
			
			$listar_row_class = 'listar_customization_custom_package_option' === $package_option[0] ? 'listar-enable-package-customization' : 'listar-package-customization-feature hidden';
			?>
			<tr class="<?php echo esc_attr( listar_sanitize_html_class( $listar_row_class ) ); ?>">
				<?php
				if ( false !== strpos( $package_option[0], 'setup' ) ) :
					?>
					<td class="listar_package_op_activation" colspan="4">
						<label for="<?php echo esc_attr( $package_option[0] . '_activation' ); ?>" class="show_if_job_package show_if_job_package_subscription">
							<input type="checkbox" class="<?php echo esc_attr( $package_option[0] . '_activation' ); ?>" name="<?php echo esc_html( $package_option[0] . '_activation' ); ?>" id="<?php echo esc_html( $package_option[0] . '_activation' ); ?>">
							<?php echo esc_html( $package_option[1] ); ?>
						</label>
					</td>
					<?php
				else :
					?>
					<td class="listar_package_op_activation">
						<label for="<?php echo esc_attr( $package_option[0] . '_activation' ); ?>" class="show_if_job_package show_if_job_package_subscription">
							<input type="checkbox" class="<?php echo esc_attr( $package_option[0] . '_activation' ); ?>" name="<?php echo esc_html( $package_option[0] . '_activation' ); ?>" id="<?php echo esc_html( $package_option[0] . '_activation' ); ?>">
							<?php echo esc_html( $package_option[1] ); ?>
						</label>
					</td>
					<?php
					if ( 'listar_customization_custom_package_option' !== $package_option[0] ) :
						$required = 'has-required' === $package_option[2] ? '' : 'disabled';
						$required_class = 'disabled' === $required ? 'listar-disabled-field' : '';
						?>
						<td class="listar_package_op_required listar-visibility-hidden <?php echo esc_attr( listar_sanitize_html_class( $required_class ) ); ?>">
							<label for="<?php echo esc_attr( $package_option[0] . '_required' ); ?>" class="show_if_job_package show_if_job_package_subscription <?php echo esc_attr( listar_sanitize_html_class( $required_class ) ); ?>">
								<input type="checkbox" class="<?php echo esc_attr( $package_option[0] . '_required' ); ?>" name="<?php echo esc_html( $package_option[0] . '_required' ); ?>" id="<?php echo esc_html( $package_option[0] . '_required' ); ?>" <?php echo esc_attr( $required ); ?>>
								<?php esc_html_e( 'Required', 'listar' ); ?>
							</label>
						</td>
						<?php
					endif;

					if ( 'listar_customization_custom_package_option' === $package_option[0] ) :
						?>
						<td colspan="3">
							<?php esc_html_e( 'If disabled, all features will be available for this package and they will not be listed on the pricing card.', 'listar' ) ?>
						</td>
						<?php
					else :
						?>
						<td class="listar_package_op_card_display listar-visibility-hidden">
							<label for="<?php echo esc_attr( $package_option[0] . '_display' ); ?>" class="show_if_job_package show_if_job_package_subscription">
								<input type="checkbox" class="<?php echo esc_attr( $package_option[0] . '_display' ); ?>" name="<?php echo esc_html( $package_option[0] . '_display' ); ?>" id="<?php echo esc_html( $package_option[0] . '_display' ); ?>">
								<?php esc_html_e( 'Show on pricing card', 'listar' ) ?>
							</label>
							<?php
							if ( false !== strpos( $package_option[0], 'gallery_images_custom_package' ) ) :
								?>
								<div>
									<label for="<?php echo esc_attr( $package_option[0] . '_limit' ); ?>" class="show_if_job_package show_if_job_package_subscription">
										<?php esc_html_e( 'Max images', 'listar' ) ?>
										<input type="text" class="<?php echo esc_attr( $package_option[0] . '_limit' ); ?>" name="<?php echo esc_html( $package_option[0] . '_limit' ); ?>" id="<?php echo esc_html( $package_option[0] . '_limit' ); ?>">
									</label>
								</div>
								<?php
							endif;
							
							if ( false !== strpos( $package_option[0], 'youtube_custom_package' ) ) :
								?>
								<div>
									<label for="<?php echo esc_attr( $package_option[0] . '_limit' ); ?>" class="show_if_job_package show_if_job_package_subscription">
										<?php esc_html_e( 'Max media fields', 'listar' ) ?>
										<input type="text" class="<?php echo esc_attr( $package_option[0] . '_limit' ); ?>" name="<?php echo esc_html( $package_option[0] . '_limit' ); ?>" id="<?php echo esc_html( $package_option[0] . '_limit' ); ?>">
									</label>
								</div>
								<?php
							endif;
							?>
						</td>
						<td class="listar_package_op_card_icon listar-visibility-hidden">
							<label for="<?php echo esc_attr( $package_option[0] . '_icon' ); ?>" class="show_if_job_package show_if_job_package_subscription">
								<?php esc_html_e( 'Icon:', 'listar' ) ?>
								<input type="text" class="<?php echo esc_attr( $package_option[0] . '_icon' ); ?>" name="<?php echo esc_html( $package_option[0] . '_icon' ); ?>" id="<?php echo esc_html( $package_option[0] . '_icon' ); ?>">
							</label>
						</td>
						<?php
					endif;
					?>
					<?php
				endif;
				?>
			</tr>
			<?php
		endforeach;
		?>
	</table>
	
	<input type="hidden" id="listar_meta_box_package_options_field" name="listar_meta_box_package_options_field" value="<?php echo esc_attr( $value_saved ); ?>" class="widefat"/>
	<?php
}

/**
 * Saves the meta box data.
 *
 * @since 1.4.2
 * @param (integer) $page_id The ID of the page.
 */
function listar_meta_box_save_package_options( $page_id ) {

	$nonce = filter_input( INPUT_POST, 'listar_meta_box_package_options_nonce', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);
	$input = filter_input( INPUT_POST, 'listar_meta_box_package_options_field', FILTER_CALLBACK, ['options' => 'listar_sanitize_string']);

	if ( empty( $nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $nonce, 'listar_meta_box_save_package_options' ) ) {
		return;
	}

	if ( defined( 'DOING-AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return;
	}

	$my_data = esc_html( $input );

	update_post_meta( $page_id, 'listar_meta_box_package_options', $my_data );
}
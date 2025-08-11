<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Listar
 */

if ( ! function_exists( 'listar_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0
	 */
	function listar_posted_on() {

		$author_id      = get_the_author_meta( 'ID' );
		$author_name    = get_the_author_meta( 'first_name' );
		$author_surname = get_the_author_meta( 'last_name' );
		$author_url     = get_author_posts_url( $author_id );
		$time_str       = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time() !== get_the_modified_time() ) {
			$time_str = '<time class="entry-date published" datetime="%1$s">%2$s</time><span class="listar-date-comma">, </span><br class="listar-date-separator"><span class="listar-date-update"><span>Updated on </span><time class="updated" datetime="%3$s">%4$s</time></span> ';
		}

		$time_string = sprintf(
			$time_str,
			esc_attr( get_the_date() ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date() ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* TRANSLATORS: %s: post date */
			_x( '<span>Posted on </span>%s', 'post date', 'listar' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		/* Output author name/surname if available, otherwise output username (nickname) */

		$byline = '';

		if ( ! empty( $author_name ) || ! empty( $author_surname ) ) :
			?>
			<a href="<?php echo esc_url( $author_url ); ?>" class="listar-author-name">
				<?php echo esc_html( $author_name . ' ' . $author_surname ); ?>
				<span class="listar-post-owner-icon icon-pen"></span>
			</a>
			<?php
		endif;

		if ( ! empty( $author_id ) ) :

			$byline .= '<span class="byline"> ';

			$byline .= sprintf(
				/* TRANSLATORS: %s: post author */
				esc_html_x( 'by %s', 'post author', 'listar' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author_meta( 'nickname' ) ) . '</a></span>'
			);

			$byline .= '</span>';

		endif;
		?>

		<div class="listar-post-meta-wrapper">
			<span class="post-meta icon-calendar-full">
				<span class="posted-on">
					<?php echo wp_kses( $posted_on . $byline, 'listar-basic-html' ); ?>
				</span>
			</span>
		</div>

		<?php
	}

endif;

if ( ! function_exists( 'listar_posted_by' ) ) :
	/**
	 * Prints the post author name.
	 *
	 * @since 1.0
	 */
	function listar_posted_by() {
		$author_id   = get_the_author_meta( 'ID' );
		$author_name = get_the_author_meta( 'first_name' );
		$author_url  = get_author_posts_url( $author_id );

		if ( empty( $author_name ) ) {
			$author_name = get_the_author_meta( 'user_login' );
		}
		?>

		<div class="listar-post-by-name">
			<?php
			if ( ! empty( $author_name ) ) :
				printf(
					/* TRANSLATORS: %s: post author */
					esc_html_x( 'by %s', 'post author', 'listar' ),
					'<a href="' . esc_url( $author_url ) . '" class="listar-author-name">' . esc_html( $author_name ) . '</a>'
				);
			endif;
			?>
		</div>

		<?php
	}
endif;

if ( ! function_exists( 'listar_categorized_blog' ) ) :
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @since 1.0
	 * @return bool
	 */
	function listar_categorized_blog() {

		$all_the_cool_categories = get_transient( 'listar_categories' );

		if ( false === $all_the_cool_categories ) {

			/* Create an array of all the categories that are attached to posts. */
			$cool_categories = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					'number'     => 2, /* We only need to know if there is more than one category. */
				)
			);

			/* Count the number of categories that are attached to the posts. */
			$all_the_cool_categories = is_array( $cool_categories ) ? count( $cool_categories ) : 0;

			set_transient( 'listar_categories', $all_the_cool_categories );
		}

		if ( $all_the_cool_categories > 1 ) {
			/* This blog has more than 1 category so listar_categorized_blog should return true. */
			return true;
		} else {
			/* This blog has only 1 category so listar_categorized_blog should return false. */
			return false;
		}
	}

endif;

add_action( 'edit_category', 'listar_category_transient_flusher' );
add_action( 'post_updated', 'listar_category_transient_flusher' );

if ( ! function_exists( 'listar_category_transient_flusher' ) ) :
	/**
	 * Flush out the transients used in listar_categorized_blog.
	 *
	 * @since 1.0
	 */
	function listar_category_transient_flusher() {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		/* Like, beat it. Dig? */
		delete_transient( 'listar_categories' );
	}

endif;

if ( ! function_exists( 'listar_comment_callback' ) ) :
	/**
	 * Callback function to 'wp_list_comments' template tag (comments and reviews).
	 *
	 * @since 1.0
	 * @param (array)   $comment Current WordPress comment.
	 * @param (array)   $args Args of the comment.
	 * @param (integer) $depth Depth of the comment.
	 */
	function listar_comment_callback( $comment, $args, $depth ) {

		$comment_user_id = (int) $comment->user_id;
		$is_author       = '';

		if ( isset( $comment->comment_author_email ) ) {

			$post_author_email    = get_the_author_meta( 'user_email' );
			$comment_author_email = $comment->comment_author_email;
			$is_author            = $post_author_email === $comment_author_email ? 'by-author' : '';

			/* If comment user ID isn't available, try to get the user ID by email */
			if ( 0 === $comment_user_id ) {
				$user = get_user_by( 'email', $comment_author_email );
				$comment_user_id = isset( $user->ID ) ? (int) $user->ID : 0;
			}
		}

		switch ( $comment->comment_type ) :

			case 'pingback':
			case 'trackback':
				?>
				<li class="comment pingback">
					<div class="comment-main-level">
						<article class="comment-body">
							<div class="comment-box">
								<div class="comment-content">
									<p>
										<?php
										esc_html_e( 'Pingback: ', 'listar' );
										comment_author_link();
										edit_comment_link( esc_html__( 'Edit', 'listar' ), '<div class="edit-link">', '</div>' );
										?>
									</p>
								</div>
							</div>
						</article>
					</div>
				<?php
				break;
			default:
				?>
				<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>

					<?php if ( 1 === listar_comment_depth( $comment->comment_ID ) ) : ?>

						<div class="comment-main-level">

					<?php endif; ?>

							<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
								<div class="comment-box">
									<div class="comment-box-inner">
										<header class="comment-header">
											<div class="listar-comment-header-media">
												<?php
												global $post;
												$author_pic = '';
												$user_name  = '';

												if ( $comment_user_id > 0 ) :
													/* Registered comment author */
													$first_name = get_user_meta( $comment_user_id, 'first_name', true );
													$last_name  = get_user_meta( $comment_user_id, 'last_name', true );
													$user_name  = ! empty( $first_name ) ? $first_name . ' ' . $last_name : '';
												endif;

												if ( empty( $user_name ) ) :
													$user_name = get_comment_author( get_comment_ID() );
												endif;

												if ( $comment_user_id > 0 ) :
													$author_pic = listar_user_thumbnail( $comment_user_id );
													$listar_blank_placeholder = listar_blank_base64_placeholder_image();
													?>
													<img class="avatar" alt="<?php echo esc_attr( $user_name ); ?>"  data-background-image="<?php echo esc_attr( listar_custom_esc_url( $author_pic ) ); ?>" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" />
													<?php
												else :
													echo get_avatar( $comment, $args['avatar_size'] );
												endif;

												if ( 'job_listing' === get_post_type() && ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) ) :
													$review_average = listar_average_user_rating( get_comment_ID(), $post->ID );

													if ( $review_average[1] ) :
														?>
														<div class="listar-current-user-rating">
															<?php echo esc_html( $review_average[0] ); ?>
														</div>
														<?php
													endif;
												endif;
												?>
											</div>

											<div class="listar-comment-header-name">
												<h5 class="comment-name <?php echo esc_attr( listar_sanitize_html_class( $is_author ) ); ?> comment-author vcard">
													<?php
													if ( '' !== $is_author ) :
														$is_author = ' <span class="is-author">' . esc_html__( 'Author', 'listar' ) . '</span>';
													endif;

													echo wp_kses(
														sprintf(
															'%s' . $is_author,
															get_comment_author_link()
														),
														'listar-basic-html'
													);
													?>
												</h5>
											</div>

											<div class="listar-comment-header-date">
												<?php
												$comment_date = sprintf(
													/* TRANSLATORS: 1: date, 2: time */
													esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'listar' ),
													get_comment_date(),
													get_comment_time()
												);
												?>

												<span class="post-meta icon-calendar-full"><?php echo esc_html( $comment_date ); ?></span>
											</div>
											<i class="fa fa-reply reply-the-comment" id="reply-the-comment-<?php comment_ID(); ?>"></i>
										</header>
										<div class="comment-content">
											<?php
											if ( 0 === (int) $comment->comment_approved ) :
												?>
												<p class="comment-awaiting-moderation label label-info">
													<?php esc_html_e( 'Your comment is awaiting moderation.', 'listar' ); ?>
												</p>
												<?php
											endif;

											comment_text();
											?>

											<div class="list-inline">
												<?php
												edit_comment_link(
													esc_html__( 'Edit', 'listar' ),
													'<div class="edit-link">',
													'</div>'
												);

												comment_reply_link(
													array_merge(
														$args,
														array(
															'add_below' => 'div-comment',
															'max_depth' => $args['max_depth'],
															'depth'     => $depth,
														)
													)
												);
												?>
											</div>
										</div>
									</div>
								</div>
							</article>

					<?php
					if ( 1 === listar_comment_depth( $comment->comment_ID ) ) :
						?>
						</div>
						<?php
					endif;

					/* No need to close li here */

		endswitch;
	}

endif;

if ( ! function_exists( 'listar_pagination' ) ) :
	/**
	 * Get pagination links for current query.
	 *
	 * @since 1.0
	 */
	function listar_pagination() {

		global $wp_query;

		$big = 999999999;

		$navigation = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'mid_size'  => 2,
				'prev_text' => '<span class="icon-chevron-left"></span>',
				'next_text' => '<span class="icon-chevron-right"></span>',
			)
		);

		echo wp_kses( '<div class="row navigation posts-navigation listar-navigation"><div class="col-sm-12">' . $navigation . '</div></div>', 'listar-basic-html' );
	}

endif;


if ( ! function_exists( 'listar_grid_filler_card' ) ) :
	/**
	 * Outputs a card to complete a listing or blog grid, avoiding empty areas on the screen.
	 *
	 * @since 1.0
	 * @param (string) $grid_type The type of grid on which the card will be inserted.
	 */
	function listar_grid_filler_card( $grid_type = 'listing' ) {
		
		$force_listing_grid_filler_blog = (int) get_option( 'listar_use_listing_grid_filler_blog' );
		$use_only_listing_grid_filler = 1 === $force_listing_grid_filler_blog ? true : false;
		$card_link                   = 'listing' === $grid_type || $use_only_listing_grid_filler ? get_option( 'listar_grid_filler_listing_button_url' ) : get_option( 'listar_grid_filler_blog_button_url' );
		$button_icon                 = 'listing' === $grid_type || $use_only_listing_grid_filler ? 'icon-map-marker-down' : 'icon-news';
		$card_has_custom_link_class  = ! empty( $card_link ) ? ' listar-has-custom-card-link' : ' listar-no-custom-card-link';
		$wp_job_manager_active       = listar_wp_job_manager_active();
		$blog_search_url             = trailingslashit( network_site_url() ) . '?s=';
		$listings_page_url           = '';
		$add_listing_url             = '';
		$card_url                    = '';
		$listar_card_title           = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_title' ) : get_option( 'listar_grid_filler_blog_card_title' );
		$listar_card_text_1          = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_text1' ) : get_option( 'listar_grid_filler_blog_card_text1' );
		$listar_card_text_2          = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_card_text2' ) : get_option( 'listar_grid_filler_blog_card_text2' );
		$listar_card_button_text     = $use_only_listing_grid_filler || 'listing' === $grid_type ? get_option( 'listar_grid_filler_listing_button_text' ) : get_option( 'listar_grid_filler_blog_button_text' );
		$card_background_image       = listar_image_url( get_option( 'listar_' . $grid_type . '_grid_filler_background_image' ), 'listar-cover' );
		$listar_background_image     = empty( $card_background_image ) ? '0' : $card_background_image;
		$listar_has_background_image = '0' === $listar_background_image ? 'listar-grid-filler-without-background-image' : 'listar-grid-filler-has-background-image';

		if ( ( $wp_job_manager_active && 'listing' === $grid_type ) || $use_only_listing_grid_filler ) {

			if ( empty( $listar_card_title ) ) {
				$listar_card_title = esc_html__( 'Promote Your Business', 'listar' );
			}

			if ( empty( $listar_card_text_1 ) ) {
				$listar_card_text_1 = esc_html__( 'Do you need qualified exposure?', 'listar' );
			}

			if ( empty( $listar_card_text_2 ) ) {
				$listar_card_text_2 = esc_html__( 'Publish a listing for targeted audience to achieve more popularity in your niche.', 'listar' );
			}

			if ( empty( $listar_card_button_text ) ) {
				$listar_card_button_text = esc_html__( 'Get Started', 'listar' );
			}
		} else {
			if ( empty( $listar_card_title ) ) {
				$listar_card_title = $use_only_listing_grid_filler ? esc_html__( 'Promote Your Business', 'listar' ) : esc_html__( 'Keep Browsing', 'listar' );
			}

			if ( empty( $listar_card_text_1 ) ) {
				$listar_card_text_1 = $use_only_listing_grid_filler ? esc_html__( 'Do you need qualified exposure?', 'listar' ) : esc_html__( 'We have interesting articles for you.', 'listar' );
			}

			if ( empty( $listar_card_text_2 ) ) {
				$listar_card_text_2 = $use_only_listing_grid_filler ? esc_html__( 'Publish a listing for targeted audience to achieve more popularity in your niche.', 'listar' ) : esc_html__( 'Please, take a minute to check more news, tips and tricks from our blog.', 'listar' );
			}
		}

		if ( $wp_job_manager_active ) {
			/**
			 * Check if a page with [jobs] shortcode exists,
			 * if not, use a generic listing search url without the 's' parameter.
			 */
			
			if ( 'listing' === $grid_type || $use_only_listing_grid_filler ) :
				$listings_page_url = empty( $card_link ) ? job_manager_get_permalink( 'jobs' ) : $card_link;

				if ( empty( $listings_page_url ) ) :
					$listings_page_url = trailingslashit( network_site_url() ) . '?s=&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
				endif;

				$add_listing_url = job_manager_get_permalink( 'submit_job_form' );

				if ( ! empty( $add_listing_url ) ) :
					$card_url = $add_listing_url;
					$button_icon = 'icon-map-marker-down';
				elseif ( 'listing' === $grid_type && ! empty( $listings_page_url ) ) :
					$card_url = $listings_page_url;
					$button_icon = 'icon-map-marker';
				else :
					$card_url = empty( $card_link ) ? $blog_search_url : $card_link;
					$button_icon = empty( $card_link ) ? 'icon-news' : 'icon-arrow-right';
				endif;
			else :
				$card_url = empty( $card_link ) ? $blog_search_url : $card_link;
				$button_icon = empty( $card_link ) ? 'icon-news' : 'icon-arrow-right';
				$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
			endif;
		} else {
			$card_url = $blog_search_url;
			$button_icon = 'icon-news';
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
		}
		
		if ( ! empty( $card_link ) ) {
			$card_url = $card_link;
			$button_icon = 'icon-arrow-right';
		}
		
		if ( empty( $card_url ) && ( 'listing' === $grid_type || $use_only_listing_grid_filler ) && ! empty( $listings_page_url ) ) {
			$card_url = $listings_page_url;
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See all listings', 'listar' ) : $listar_card_button_text;
			$button_icon = 'icon-map-marker';
		}
		
		if ( empty( $card_url ) && ( 'blog' === $grid_type ) ) {
			$card_url = $blog_search_url;
			$button_icon = 'icon-news';
			$listar_card_button_text = empty( $listar_card_button_text ) ? esc_html__( 'See more posts', 'listar' ) : $listar_card_button_text;
		}
		?>

		<!-- Start grid filler card/button -->
		<div class="col-xs-12 col-sm-6 col-md-4 listar-grid-design-2 <?php echo esc_attr( listar_sanitize_html_class( 'listar-' . $grid_type . '-card' ) ); ?> listar-grid-filler">
			<article class="listar-card-content hentry <?php echo esc_attr( listar_sanitize_html_class( $listar_has_background_image ) ); ?>" data-aos="fade-zoom-in">
				<a class="listar-card-link <?php echo esc_attr( listar_sanitize_html_class( $card_has_custom_link_class ) ); ?>" href="<?php echo esc_url( $card_url ); ?>" data-default-url="<?php echo esc_url( $card_url ); ?>"></a>

				<?php
				if ( 'listar-grid-filler-has-background-image' === $listar_has_background_image ) :
					?>
					<div class="listar-grid-filler-background-image-wrapper">
						<div class="listar-grid-filler-background-image" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_background_image ) ); ?>"></div>
					</div>
					<?php
				endif;
				?>

				<div class="listar-fallback-content">
					<div class="listar-fallback-content-wrapper">
						<div class="listar-fallback-content-data">
							<div class="listar-fallback-content-small-title text-center">
								<h5><?php echo esc_html( $listar_card_title ); ?></h5>
							</div>

							<div class="listar-fallback-content-description text-center">
								<div>
									<?php echo esc_html( $listar_card_text_1 ); ?>
								</div>
								<div>
									<?php echo esc_html( $listar_card_text_2 ); ?>
								</div>
							</div>
						</div>
						<?php
						if ( $wp_job_manager_active ) {
							
							if ( ! empty( $card_url ) ) :
								?>
								<div class="listar-fallback-content-button-wrapper text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button <?php echo esc_attr( $button_icon ); ?>">
											<?php echo esc_html( $listar_card_button_text ); ?>
										</div>
									</div>
								</div>
								<?php
							elseif ( 'listing' === $grid_type && empty( $card_url ) && ! empty( $listings_page_url ) ) :
								?>
								<div class="listar-fallback-content-button-wrapper text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button icon-map-marker">
											<?php esc_html_e( 'See all listings', 'listar' ); ?>
										</div>
									</div>
								</div>
								<?php
							elseif ( 'blog' === $grid_type ) :
								?>
								<div class="listar-fallback-content-button-wrapper listar-fallback-blog-button text-center">
									<div class="text-center">
										<div class="button listar-iconized-button listar-light-button icon-news" data-next-posts="<?php esc_attr_e( 'Next page', 'listar' ); ?>" data-previous-posts="<?php esc_attr_e( 'Previous page', 'listar' ); ?>" data-default-text="<?php esc_attr_e( 'See more posts', 'listar' ); ?>">
											<?php esc_html_e( 'See more posts', 'listar' ); ?>
										</div>
									</div>
								</div>
								<?php
							endif;
						} else {
							?>
							<div class="listar-fallback-content-button-wrapper listar-fallback-blog-button text-center">
								<div class="text-center">
									<div class="button listar-iconized-button listar-light-button icon-news" data-next-posts="<?php esc_attr_e( 'Next page', 'listar' ); ?>" data-previous-posts="<?php esc_attr_e( 'Previous page', 'listar' ); ?>" data-default-text="<?php esc_attr_e( 'See more posts', 'listar' ); ?>">
										<?php esc_html_e( 'See more posts', 'listar' ); ?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</article>
		</div>
		<!-- End grid filler card/button -->

		<?php
	}
endif;

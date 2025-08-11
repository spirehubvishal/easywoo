<?php
/**
 * Template part to output blog posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_current_post_id     = get_the_ID();
$listar_category_name       = listar_first_term_data( $listar_current_post_id, 'category', 'name' );
$listar_category_link       = listar_first_term_data( $listar_current_post_id, 'category', 'link' );
$listar_post_image          = get_the_post_thumbnail_url( $listar_current_post_id, 'large' );
$listar_fallback_card_image = listar_image_url( get_option( 'listar_blog_card_fallback_image' ), 'large' );
$listar_temp_bg_image       = empty( $listar_post_image ) ? $listar_fallback_card_image : $listar_post_image;
$listar_bg_image            = empty( $listar_temp_bg_image ) ? '0' : $listar_temp_bg_image;
$listar_post_classes        = array( 'listar-card-content', 'listar-no-image' );
$listar_col_class           = 'col-xs-12 col-md-12 listar-grid-design-1 listar-card-full listar-blog-card';
$listar_has_sidebar         = is_active_sidebar( 'listar-blog-sidebar' ) && is_dynamic_sidebar( 'listar-blog-sidebar' ) ? true : false;
$listar_is_ajax_loop        = listar_is_ajax_loop() ? 'listar-ajax-post' : 'listar-default-post';
$listar_effect_delay        = listar_static_increment();
$listar_excerpt             = listar_excerpt_limit( $post, 280 );
$listar_has_excerpt         = false !== strpos( $listar_excerpt, 'listar-card-content-excerpt' ) ? '' : 'listar-post-no-excerpt';
$listar_post_title          = listar_excerpt_limit( get_the_title( $listar_current_post_id ), 80, false, '', true );
$listar_blank_placeholder   = listar_blank_base64_placeholder_image();

if ( is_sticky( $listar_current_post_id ) ) :
	$listar_post_classes[] = 'sticky';
endif;
?>

<!-- Start Blog Item Col -->
<div class="<?php echo esc_attr( listar_sanitize_html_class( $listar_col_class . ' ' . $listar_is_ajax_loop ) ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( $listar_post_classes ); ?> data-aos="fade-zoom-in" data-aos-group="posts" data-aos-delay="<?php echo esc_attr( $listar_effect_delay ); ?>">
		<a class="listar-card-link" href="<?php the_permalink(); ?>" ></a>

		<div class="listar-posted-by">
			<?php
			$listar_author_pic = listar_user_thumbnail();
			$listar_author_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			?>
			<a href="<?php echo esc_url( $listar_author_url ); ?>" class="author-avatar" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_author_pic ) ); ?>"></a>
			<?php listar_posted_by(); ?>
		</div>

		<div class="listar-card-content-image-wrapper">
			<div class="listar-card-content-image">
				<div class="listar-card-content-title-centralizer">
					<h6 class="listar-card-content-title"><?php echo esc_html( $listar_post_title ); ?></h6>
				</div>
				<img data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_bg_image ) ); ?>" alt="<?php the_title(); ?>" src="<?php echo esc_attr( $listar_blank_placeholder ); ?>" />
			</div>
		</div>

		<div class="listar-card-content-date-wrapper listar-date-design-2">
			<div class="listar-card-content-date">
				<span class="icon-calendar-full">
					<?php echo esc_html( get_the_date() ); ?>
				</span>
				<span class="fa fa-commenting-o">
					<a href="<?php comments_link(); ?>">
						<?php
						$listar_comments_counter = (int) get_comments_number();
						echo esc_html( $listar_comments_counter > 0 ? zeroise( $listar_comments_counter, 2 ) . ' ' : '' );
						echo esc_html( listar_check_plural( $listar_comments_counter, esc_html__( 'comment', 'listar' ), esc_html__( 'comments', 'listar' ), esc_html__( 'No comments', 'listar' ) ) );
						?>
					</a>
				</span>
			</div>
		</div>

		<div class="listar-card-content-data <?php echo esc_attr( listar_sanitize_html_class( $listar_has_excerpt ) ); ?>">
			<?php echo wp_kses( $listar_excerpt, 'listar-basic-html' ); ?>
			<div class="listar-card-category-name">
				<a href="<?php echo esc_url( $listar_category_link ); ?>">
					<?php echo esc_html( $listar_category_name ); ?>
				</a>
			</div>
		</div>

		<div class="listar-sticky-border"></div>
	</article>
</div>
<!-- End Blog Item Col -->

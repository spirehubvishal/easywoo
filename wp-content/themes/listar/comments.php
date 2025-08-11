<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 *
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) :
	return;
endif;
?>

<div class="listar-post-comments-wrapper">
	<aside class="listar-iconized-separator">
		<div class="listar-separator-mask"></div>
		<span><i class="icon-bubbles"></i></span>
	</aside>

	<!-- Start Comments -->
	<?php
	if ( have_comments() ) :
		$listar_comments_counter = (int) get_comments_number();
		?>

		<aside id="comments" class="listar-comments-container comments <?php echo sanitize_html_class( comments_open() ? '' : 'comments-closed' ); ?>">
			<?php
			if ( ( 'job_listing' !== $post->post_type || ( ! listar_third_party_reviews_active() && ! listar_built_in_reviews_active() ) ) && $listar_comments_counter > 0 ) :
				?>
				<h3 class="comments-title">
					<?php
					echo esc_html( zeroise( $listar_comments_counter, 2 ) . ' ' );
					echo esc_html( listar_check_plural( $listar_comments_counter, esc_html__( 'comment', 'listar' ), esc_html__( 'comments', 'listar' ) ) );
					?>
				</h3>
				<?php
			endif;
			?>

			<ul class="comment-list">
				<?php
				wp_list_comments(
					array(
						'avatar_size' => 60,
						'style'       => 'ul',
						'short_ping'  => true,
						'reply_text'  => '<i class="fa fa-reply"></i>',
						'callback'    => 'listar_comment_callback',
					)
				);
				?>
			</ul>

			<?php
			the_comments_pagination(
				array(
					'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous', 'listar' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next', 'listar' ) . '</span>',
				)
			);
			?>
		</aside>
		<?php
	endif;
	?>

	<aside class="listar-comments-form-wrapper listar-no-padding">

		<?php
		/* If comments are closed and there are comments, let's leave a little note, shall we? */

		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="listar-no-comments">
				<?php esc_html_e( 'Comments are closed.', 'listar' ); ?>
			</p>
			<?php
		endif;

		comment_form();
		?>
	</aside>
</div>

<?php
/**
 * Template part for displaying post author in single.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$listar_author_intro       = get_the_author_meta( 'listar_meta_box_user_short_introduction' );
$listar_author_biography   = get_the_author_meta( 'description' );
$listar_has_author_details = ! empty( $listar_author_intro ) || ! empty( $listar_author_biography );
$listar_no_details_class   = ! $listar_has_author_details ? 'listar-no-author-details' : '';
$listar_author_post_count  = (int) count_user_posts( get_the_author_meta( 'ID' ) );
$listar_author_pic         = listar_user_thumbnail();
$listar_author_url         = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
?>

<!-- Start Author Block -->
<div class="listar-author-block <?php echo esc_attr( listar_sanitize_html_class( $listar_no_details_class ) ); ?>">
	<div class="text-left">
		<a href="<?php echo esc_url( $listar_author_url ); ?>" class="author-avatar pull-left" data-background-image="<?php echo esc_attr( listar_custom_esc_url( $listar_author_pic ) ); ?>">
			<div class="listar-author-stats">
				<div class="listar-post-counter">
					<?php echo esc_html( $listar_author_post_count > 0 ? zeroise( $listar_author_post_count, 2 ) . ' ' : '' ); ?>
				</div>
				<div>
					<?php echo esc_html( listar_check_plural( $listar_author_post_count, esc_html__( 'Article', 'listar' ), esc_html__( 'Articles', 'listar' ), esc_html__( 'No Articles', 'listar' ) ) ); ?>
				</div>
			</div>
		</a>

		<?php
		listar_posted_on();

		if ( $listar_has_author_details ) :
			?>
			<div class="listar-author-description">
				<hr />
				<h6 class="text-left">
					<?php echo esc_html( $listar_author_intro ); ?>
				</h6>
				<?php echo wp_kses( $listar_author_biography, 'listar-basic-html' ); ?>
			</div>
			<?php
		endif;
		?>

	</div>
</div>
<!-- End Author Block -->

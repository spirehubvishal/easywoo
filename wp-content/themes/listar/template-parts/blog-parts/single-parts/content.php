<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

?>

<!-- Start Single Content -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'listar-single-content entry-content' ); ?>>
	<?php
	$listar_kses_tags = array(
		'span' => array(
			'class' => array(),
		),
	);

	the_content(
		wp_kses(
			sprintf(
				/* TRANSLATORS: %s: Name of current post. */
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'listar' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			$listar_kses_tags
		)
	);
	?>
	<div class="listar-clear-both"></div>
</article>
<!-- End Single Content -->

<?php
/**
 * Template part for displaying tags after content in single.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

global $post;

$listar_tags = wp_get_post_tags( $post->ID );
$listar_count_tags = is_array( $listar_tags ) ? count( $listar_tags ) : 0;

if ( $listar_count_tags ) :
	?>
	<div class="tags listar-single-tags">
		<?php the_tags(); ?>
	</div>
	<?php
endif;

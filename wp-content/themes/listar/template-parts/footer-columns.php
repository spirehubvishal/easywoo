<?php
/**
 * Template part for displaying the footer columns with sidebars
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listar
 */

$columns_active = 0;
$footer_columns_active = array();

for ( $i = 0; $i < 5; $i++ ) {

	if ( 0 === $i ) {
		$footer_columns_active[] = 0;
	} elseif ( 1 === (int) get_option( 'listar_footer_column_' . $i ) && is_active_sidebar( 'listar-sidebar-footer-' . $i ) && is_dynamic_sidebar( 'listar-sidebar-footer-' . $i ) ) {
		/* A footer column is currently active and is filled with at least one widget */
		$footer_columns_active[] = 1;
		$columns_active++;
	} else {
		$footer_columns_active[] = 0;
	}
}

if ( $columns_active ) :
	?>
	<div class="listar-container-wrapper">
		<aside class="listar-footer-widgets container">
			<div class="row">
				<?php for ( $i = 1; $i < 5; $i++ ) :

					$column_class = 'col-xs-6 col-sm-6 col-md-3';

					if ( 1 === $i && 3 === $columns_active ) {
						$column_class = 'col-md-5 col-sm-6 col-xs-12';
					} elseif ( 2 === $i && 3 === $columns_active ) {
						$column_class = 'col-xs-6 col-sm-6 col-md-3 offset-md-1';
					} elseif ( 3 === $i && 3 === $columns_active ) {
						$column_class = 'col-xs-6 col-sm-6 col-md-4 offset-md-1';
					} else {
						$column_class = 'col-xs-6 col-sm-6 col-md-3';
					}

					/* Adjust Bootstrap columns if user set less than three footer colums */

					if ( 2 === $columns_active ) {
						$column_class = 'col-sm-6';
					} elseif ( 1 === $columns_active ) {
						$column_class = 'col-sm-12';
					}

					if ( 1 === $footer_columns_active[ $i ] ) :
						?>
						<div class="listar-footer-column <?php echo esc_attr( listar_sanitize_html_class( 'listar-footer-column-' . $i . ' listar-footer-columns-' . $columns_active . ' ' . $column_class ) ); ?>">
							<?php
							if ( is_active_sidebar( 'listar-sidebar-footer-' . $i ) && is_dynamic_sidebar( 'listar-sidebar-footer-' . $i ) ) :
								dynamic_sidebar( 'listar-sidebar-footer-' . $i );

							endif;
							?>
						</div>
						<?php
					endif;
				endfor;
				?>
			</div>
		</aside>
	</div>
	<?php
endif;

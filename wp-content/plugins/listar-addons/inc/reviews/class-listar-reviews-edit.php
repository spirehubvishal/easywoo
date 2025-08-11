<?php
/**
 * Edit / update Listar Reviews
 *
 * @package Listar_Addons
 */

/**
 * The class to manage Listar Reviews
 *
 * @since 1.3.9
 */

class Listar_Reviews_Edit {
	/**
	 * Setup the widget name, description, etc.
	 *
	 * @since 1.3.9
	 */
	public function __construct() {

		/* Create review meta box for comments. */
		add_action( 'add_meta_boxes_comment', array( $this, 'listar_add_meta_box' ), 10, 1 );

		/* Update review data when a comment is saved */
		add_action( 'edit_comment', array( $this, 'listar_save_review' ), 10, 2 );

		/* Update listing reviews anytime a comment is modified */
		add_action( 'transition_comment_status', array( $this, 'listar_update_reviews_trigger' ), 10, 3 );
	}

	/**
	 * Create review meta box for comments.
	 *
	 * @since 1.3.9
	 * @param (Object) $comment The WordPress "comment" object
	 */
	public function listar_add_meta_box( $comment ) {

		/* Verify user role. */
		if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
			return;
		}

		/* Affects Job Listing comments only. */
		if ( 'job_listing' !== get_post_type( $comment->comment_post_ID ) ) {
			return;
		}

		/* Affect top level comments only. */
		if ( 0 !== intval( $comment->comment_parent ) ) {
			return;
		}

		/* Add meta box review. */
		add_meta_box(
			'listar_review',
			__( 'Review', 'listar' ),
			array( $this, 'listar_print_metabox' ),
			'comment',
			'normal'
		);
	}

	/**
	 * Prints the meta box.
	 *
	 * @since 1.3.9
	 * @param (Object) $comment The WordPress "comment" object
	 * @param (Array) $box_meta The WordPress meta box data.
	 */
	public function listar_print_metabox( $comment, $box_meta ) {

		$get_stars = get_comment_meta( $comment->comment_ID, 'review_stars', true );
		$review_stars = is_array( $get_stars ) ? $get_stars : array();
		$review_categories = array();

		foreach ( $review_stars as $category => $category_review ) {
			$review_categories[] = $category;
		}

		if ( empty( $review_categories ) ) {
			$review_categories = listar_get_reviews_categories();
		}
		?>
		<table class="form-table">
			<tbody>
				<?php foreach ( $review_categories as $index => $category ) :
					$stars_by_index = array();
				
					foreach( $review_stars as $review_star ) {
						$stars_by_index[] = $review_star;
					}

					$current = isset( $review_stars[ $category ] ) ? $review_stars[ $category ] : ( isset( $stars_by_index[ $index ] ) ? $stars_by_index[ $index ] : 0 );
				?>
					<tr>
						<th scope="row"><label for="star-rating-<?php echo esc_attr( $index ); ?>"><?php echo esc_attr( $category ); ?></label></th>
						<td>
							<select id="star-rating-<?php echo esc_attr( $index ); ?>" name="star-rating-<?php echo esc_attr( $index ); ?>" autocomplete="off">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<option value="<?php echo $i; ?>" <?php selected( $current, $i ); ?>>
										<?php echo $i; ?> - <?php echo str_repeat( '&#9733; ', $i ); ?> <?php echo str_repeat( '&#9734; ', absint( 5 - $i ) ); ?>
									</option>
								<?php endfor; ?>
							</select>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php wp_nonce_field( 'listar_save_review_data', 'listar_reviews_meta_nonce' ); ?>
			</tbody>
		</table>
		<?php
	}
	
	/**
	 * Update review data when a comment is saved.
	 * 
	 * @since 1.3.9
	 *
	 * @param (Integer) $comment_id Comment ID.
	 * @param (Array)   $comment_data       Comment data.
	 */
	public function listar_save_review( $comment_id, $comment_data ) {

		/* Verify user role. */
		if ( ! current_user_can( 'edit_comment', $comment_id ) ) {
			return $comment_id;
		}

		/* Verify valid nonce. */
		if ( empty( $_POST['listar_reviews_meta_nonce'] ) || ! wp_verify_nonce( $_POST['listar_reviews_meta_nonce'], 'listar_save_review_data' ) ) {
			return $comment_id;
		}

		$get_stars = get_comment_meta( $comment_id, 'review_stars', true );
		$review_stars = is_array( $get_stars ) ? $get_stars : array();

		$review_categories = array();

		foreach ( $review_stars as $category => $review_average ) {
			$review_categories[] = $category;
		}
		if ( ! $review_categories ) {
			$review_categories = listar_get_reviews_categories();
		}

		if ( ! empty( $review_stars ) ) {
			$review_stars = array();
		}

		$review_total = 0;

		foreach ( $review_categories as $index => $category ) {
			if ( isset ( $_POST['star-rating-' . $index ] ) ) {

				/* Category review value */
				$value = $_POST['star-rating-' . $index ];

				/* Review stars */
				$review_stars[ $category ] = $value;

				/* For review average. */
				$review_total += $value;
			}
		}

		update_comment_meta( $comment_id, 'review_stars', $review_stars );

		$review_average = $review_total / count( $review_stars );
		update_comment_meta( $comment_id, 'review_average', $review_average );
		listar_update_listing_reviews_data( $comment_id, $comment_data['comment_approved'] );
	}

	/**
	 * Update listing reviews anytime a comment is modified
	 *
	 * @since 1.3.9
	 *
	 * @param (String) $new_status New comment status.
	 * @param (String) $old_status Old/edited comment status.
	 * @param (Object) $comment    Comment object.
	 */
	public function listar_update_reviews_trigger( $new_status, $old_status, $comment ) {
		
		$comment_approved = 0;
		$post = get_post( $comment->comment_post_ID );

		if ( 'job_listing' !== $post->post_type ) {
			return;
		}

		/* Is this a top level comment? */
		if ( 0 !== intval( $comment->comment_parent ) ) {
			return;
		}

		if ( 'approved' === $new_status ) {
			$comment_approved = 1;
		} else {
			$comment_approved = 0;
		}

		listar_update_listing_reviews_data( $comment->comment_ID, $comment_approved );
	}
}

function listar_reviews_edit_init() {
	if ( ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
		new Listar_Reviews_Edit();
	}
}

add_action( 'plugins_loaded', 'listar_reviews_edit_init' );

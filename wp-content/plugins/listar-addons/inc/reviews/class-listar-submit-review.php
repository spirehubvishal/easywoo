<?php
/**
 * Submit a listing review.
 *
 * @package Listar_Addons
 */

/**
 * The class to save a new review.
 *
 * @since 1.3.9
 */
class Listar_Submit_review {

	/**
	 * Constructor for initialization.
	 *
	 * @since 1.3.9
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'listar_allow_empty_comment' ) );
		add_filter( 'pre_comment_approved', array( $this, 'listar_before_save_review' ), 10, 2 );
		add_action( 'comment_post', array( $this, 'listar_save_review_database' ), 10, 3 );
	}

	/**
	 * Review verification before saving
	 *
	 * @param (Boolean) $comment_status    Comment pre approved.
	 * @param (Array)   $comment_data      All comment data
	 * @return (Boolean)
	 */
	public function listar_before_save_review( $comment_status, $comment_data ) {
		$post = get_post( $comment_data['comment_post_ID'] );

		if ( 'job_listing' !== $post->post_type ) {
			return $comment_status;
		}

		/* Is it a top level comment? */
		if ( 0 !== intval( $comment_data['comment_parent'] ) ) {
			return $comment_status;
		}

		/* Can the listing owner submit a review for himself? */
		if ( ! get_option( 'wpjmr_allow_owner', '0' ) && absint( $post->post_author ) === absint( get_current_user_id() ) ) {
			return $comment_status;
		}

		$review_categories = listar_get_reviews_categories();

		foreach ( $review_categories as $review_category_slug => $review_category ) {
			if ( ! isset( $_POST[ 'star-rating-' . $review_category_slug ] ) || empty( $_POST[ 'star-rating-' . $review_category_slug ] ) ) {
				wp_die( __( '<strong>ERROR:</strong> Ratings need to be set for all categories.', 'listar' ) );
				$comment_status = false;
			}
		}

		return $comment_status;
	}

	/**
	 * Are blank comments allowed?
	 * 
	 * @since 1.3.9
	 */
	public function listar_allow_empty_comment(){
		$input   = (int) get_option( 'listar_allow_review_without_comment' );
		$allow_empty_comment_text = 1 === $input ? true : false;

		if ( $allow_empty_comment_text && isset( $_POST['star-rating-0'] ) && isset( $_POST['comment'] ) && empty( $_POST['comment'] ) ) {
			$_POST['comment'] = '<!-- no content -->';
		}
	}

	/**
	 * Finally saves the comment and ratings.
	 *
	 * @since 1.3.9
	 * @param (Integer)  $comment_id       The comment ID.
	 * @param (Integer)  $comment_status   0 if unapproved comment, 1 if approved.
	 * @param (Array)    $comment_data     The comment data.
	 */
	public function listar_save_review_database( $comment_id, $comment_status, $comment_data ) {
		$post = get_post( $comment_data['comment_post_ID'] );

		if ( 'job_listing' !== $post->post_type ) {
			return;
		}

		if ( 0 !== intval( $comment_data['comment_parent'] ) ) {
			return;
		}

		$review_categories = listar_get_reviews_categories();
		$review_stars = array();
		$review_total = 0;

		foreach ( $review_categories as $index => $review_category ) {
			if ( isset ( $_POST['star-rating-' . $index ] ) ) {

				$value = $_POST['star-rating-' . $index ];
				$review_stars[ $review_category ] = $value;
				$review_total += $value;

			} else {
				return;
			}
		}

		update_comment_meta( $comment_id, 'review_stars', $review_stars );

		$review_average = $review_total / count( $review_stars );
		update_comment_meta( $comment_id, 'review_average', $review_average );
		listar_update_listing_reviews_data( $comment_id, $comment_status );
	}

}

function listar_submit_review_init() {
	if ( ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
		new Listar_Submit_review();
	}
}

add_action( 'plugins_loaded', 'listar_submit_review_init' );


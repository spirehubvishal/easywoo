<?php
/**
 * Outputs the review stars for a comment.
 *
 * @package Listar_Addons
 */

/**
 * The class to modify the comment output.
 *
 * @since 1.3.9
 */
class Listar_Review_Output {

	/**
	 * Outputs the review stars for a comment.
	 *
	 * @since 1.3.9
	 */
	public function __construct() {

		add_filter( 'get_comment_text', array( $this, 'review_comment_text' ), 10, 3 );
	}

	/**
	 * Add rating stars to comment.
	 *
	 * @since 1.3.9
	 *
	 * @param (String) $content Text of the comment.
	 * @param (Object) $comment The comment object.
	 * @param (Array)  $args    An array of arguments.
	 * @return (String)
	 */
	public function review_comment_text( $content, $comment, $args ) {

		if ( 'job_listing' !== get_post_type( $comment->comment_post_ID ) || ! is_singular( 'job_listing' ) ) {
			return $content;
		}

		if ( 0 !== intval( $comment->comment_parent ) ) {
			return $content;
		}

		$comment_id = $comment->comment_ID;
		$ratings = get_comment_meta( $comment_id, 'review_stars', true );
		$review_average = listar_force_numeric( get_comment_meta( $comment_id, 'review_average', true ) );

		if ( ! $ratings || ! is_array( $ratings ) || ! $review_average ) {
			return $content;
		}

		// Display rating and json markup before comment text.
		$stars = listar_review_get_stars( $comment_id );
		$json  = sprintf( '<script type="application/ld+json">%s</script>', wp_json_encode( $this->json_ld( $comment_id, $content, $review_average ) ) );
		return $stars . $json . $content;
	}

	/**
	 * Return reivew data in JSON-LD format.
	 *
	 * @since 1.9.0
	 *
	 * @param int $comment_id Review ID.
	 * @param string $content Comment text.
	 * @param int $review_average Review average.
	 * @return array Review data in JSON-LD format.
	 */
	public function json_ld( $comment_id, $content, $review_average ) {
		$markup = array();

		$markup['@type']         = 'Review';
		$markup['url']           = get_comment_link( $comment_id );
		$markup['datePublished'] = get_comment_date( 'c', $comment_id );
		$markup['description']   = $content;
		$markup['reviewRating']  = array(
			'@type'       => 'rating',
			'ratingValue' => $review_average,
		);
		$markup['author']        = array(
			'@type'       => 'Person',
			'name'        => get_comment_author( $comment_id ),
		);

		return $markup;
	}

}

function listar_reviews_output_init() {
	if ( ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
		new Listar_Review_Output();
	}
}

add_action( 'plugins_loaded', 'listar_reviews_output_init' );

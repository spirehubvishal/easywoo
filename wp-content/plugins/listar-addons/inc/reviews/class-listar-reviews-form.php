<?php
/**
 * Include the review field on listing comments form.
 *
 * @package Listar_Addons
 */

/**
 * The class to modify the comment form.
 *
 * @since 1.3.9
 */
class Listar_Reviews_Form {

	/**
	 * Constructor for initialization.
	 *
	 * @since 1.3.9
	 */
	public function __construct() {
		add_action( 'comment_form_top', array( $this, 'listar_add_review_field' ), 1 );
	}

	/**
	 * Include the review field on listing comments form.
	 *
	 * @since 1.3.9
	 */
	public function listar_add_review_field() {
		if ( ! is_singular( 'job_listing' ) ) {
			return;
		}
		
		$post         = get_post();
		$user = wp_get_current_user();
		$check_owner  = $user->ID && absint( $user->ID ) === absint( $post->post_author );
		
		$allow1 = (int) get_option( 'listar_allow_visitors_submit_reviews' ) ;
		$allow_visitors_submit_reviews = 1 === $allow1 ? true : false;
		
		$allow2 = (int) get_option( 'listar_allow_owner_review_listing' );
		$allow_owner_review = 1 === $allow2 ? true : false;
		
		
		if ( $check_owner && ! $allow_owner_review && ! current_user_can( 'edit_pages' ) ) :
			
			/* Listing owners are not allowed to submit ratings */
			echo sprintf( '<div class="listar-review-restriction-message">%s</div>', __( 'Sorry, you are not allowed to submit ratings for your own publication.', 'listar' ) );
		elseif ( ! $allow_visitors_submit_reviews && ! is_user_logged_in() ) :
			
			/* Visitors are not allowed to submit ratings */
			add_filter( 'comment_form_fields', '__return_empty_array' );
			add_filter( 'comment_form_submit_field', '__return_null', 10, 2 );
		else :
			?>
			<div id='listar-submit-ratings' class='review-form-stars'>
				<div class='star-ratings ratings'>

					<?php
					$preset_rating_stars = (int) get_option( 'listar_start_ratings_with' );
					
					if ( empty( $preset_rating_stars ) ) {
						$preset_rating_stars = 4;
					}
					
					foreach ( listar_get_reviews_categories() as $index => $category ) : ?>
						<div class='rating-row'>
							<label for='<?php echo $index; ?>'><?php echo esc_html( $category ); ?></label>
							<div class='stars choose-rating' data-rating-category='<?php echo $index; ?>'>
								<?php for ( $i = 5; $i > 0 ; $i-- ) : 
									$class_output = $i <= $preset_rating_stars ? 'active' : '';
									?>
									<span data-star-rating='<?php echo $i; ?>' class="star dashicons dashicons-star-empty <?php echo esc_attr( listar_sanitize_html_class( $class_output ) ); ?>"></span>
								<?php endfor; ?>
								<input type='hidden' class='required' name='star-rating-<?php echo $index; ?>' value='<?php echo esc_attr( $preset_rating_stars ); ?>'>
							</div>
						</div>
					<?php endforeach; ?>

				</div>
			</div>
			<?php
		endif;
	}
}

function listar_reviews_form_init() {
	if ( ! listar_third_party_reviews_active() && ! listar_is_built_in_reviews_option_disabled() ) {
		new Listar_Reviews_Form();
	}
}

add_action( 'plugins_loaded', 'listar_reviews_form_init' );

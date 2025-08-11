<?php
/**
 * Functions in general for trending feature.
 *
 * @package Listar_Addons
 */
if ( ! function_exists( 'listar_trending_global' ) ) :

	/**
	 * Saves trending listings for global usage.
	 *
	 * @since 1.4.6
	 * @param $force_return Force the list return even for admin pages.
	 * @return (array)
	 */
	function listar_trending_global( $force_return = false ) {	
		static $return_list = array();
		static $done = array();

		if ( ! is_admin() || $force_return || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			if ( empty( $return_list ) && ! $done ) {
				$return_list = listar_get_trending();
				$done = true;
			}

			return $return_list;
		}
	}

endif;

// add the action 
add_action( 'template_redirect', 'listar_trending_global', 10, 1 );


if ( ! function_exists( 'listar_get_trending_listings' ) ) :

	/**
	 * Get trending listings.
	 *
	 * @since 1.4.6
	 * @param $force_return Force the list return even for admin pages.
	 * @return (array)
	 */
	function listar_get_trending_listings( $force_return = false ) {
		return listar_trending_global( $force_return );
	}

endif;

if ( ! function_exists( 'listar_is_listing_trending' ) ) :
	/**
	 * Verify if a listing is trending now.
	 *
	 * @since 1.4.6
	 * @param (integer) $listing_id A listing ID.
	 * @return (array)
	 */
	function listar_is_listing_trending( $listing_id = 0 ) {
		return in_array( $listing_id, listar_get_trending_listings(), true );
	}

endif;

function listar_get_most_fav( $ids_and_counts ) {
	$top_fav_ids_and_counts = array();
	foreach ( $ids_and_counts as $key => $row ) {
		$top_fav_ids_and_counts[ $key ] = $row[ 'count' ];
	}
	array_multisort( $top_fav_ids_and_counts, SORT_DESC, $ids_and_counts );
	$top_fav_ids = array();
	foreach ( $ids_and_counts as $elem ) {
		$top_fav_ids[] = $elem[ 'id' ];
	}
	$top_fav_ids = array_filter( $top_fav_ids );
	return $top_fav_ids;
}

function listar_get_fav_list( $number_of_samples = 999 ) {
	$exec_query = new WP_Query( array(
		'post_type' => 'job_listing',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_samples
		) );
	$ids_and_counts = array();
	while ( $exec_query->have_posts() ) : $exec_query->the_post();
		$ids_and_counts[] = array( 'id' => get_the_ID(), 'count' => listar_bookmarks_get_counter( get_the_ID() ) );
	endwhile;
	//* Restore original Post Data
	wp_reset_postdata();
	return listar_get_most_fav( $ids_and_counts );
}

function listar_get_newest( $number_of_samples ) {
	$exec_query = new WP_Query( array(
		'post_type' => 'job_listing',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_samples,
		'orderby' => 'date',
		'order' => 'DESC'
		) );
	$ids = array();
	while ( $exec_query->have_posts() ) : $exec_query->the_post();
		$ids[] = get_the_ID();
	endwhile;
	//* Restore original Post Data
	wp_reset_postdata();
	return $ids;
}

function listar_get_featured( $number_of_samples ) {
	$exec_query = new WP_Query( array(
		'post_type' => 'job_listing',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_samples,
		'meta_key' => '_featured',
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
		) );

	$ids = array();
	while ( $exec_query->have_posts() ) : $exec_query->the_post();
		$id = get_the_ID();
		$featured = get_post_meta( $id, '_featured', true );
		if ( intval( $featured ) === 1 ) {
			$ids[] = $id;
		}
	endwhile;

	//* Restore original Post Data
	wp_reset_postdata();
	return $ids;
}

function listar_get_most_viewed( $number_of_samples ) {
	$exec_query = new WP_Query( array(
		'post_type' => 'job_listing',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_samples,
		'meta_key' => 'listar_meta_box_views_counter',
		'orderby' => 'meta_value_num date',
		'order' => 'DESC'
		) );
	$ids = array();

	while ( $exec_query->have_posts() ) : $exec_query->the_post();
		$ids[] = get_the_ID();
	endwhile;

	//* Restore original Post Data
	wp_reset_postdata();
	return $ids;
}

/**
 * Trending listings
 * Return listing IDs
 */
function listar_trending_listings() {
	$listings_and_total_scores = array();
	$max_trending_items = intval( get_option( 'listar_max_trending_listings' ) );
	$minimum_score_to_trend = intval( get_option( 'listar_minimum_score_to_trend' ) );
	$most_rated_score = intval( get_option( 'listar_score_to_most_rated' ) );
	$most_bookmarked_score = intval( get_option( 'listar_score_to_most_bookmarked' ) );
	$most_viewed_score = intval( get_option( 'listar_score_to_most_viewed' ) );
	$top_rated_score = intval( get_option( 'listar_score_to_best_rated' ) );
	$featured_score = intval( get_option( 'listar_score_to_featured' ) );
	$newest_score = intval( get_option( 'listar_score_to_newest' ) );
	
	if ( empty( $max_trending_items ) ) {
		$max_trending_items = 10;
	}
	
	if ( empty( $minimum_score_to_trend ) ) {
		$minimum_score_to_trend = 20;
	}
	
	if ( empty( $most_rated_score ) ) {
		$most_rated_score = 7;
	}
	
	if ( empty( $most_bookmarked_score ) ) {
		$most_bookmarked_score = 7;
	}
	
	if ( empty( $most_viewed_score ) ) {
		$most_viewed_score = 7;
	}
	
	if ( empty( $top_rated_score ) ) {
		$top_rated_score = 7;
	}
	
	if ( empty( $featured_score ) ) {
		$featured_score = 7;
	}
	
	if ( empty( $newest_score ) ) {
		$newest_score = 7;
	}
	
	$diff_ref = 0;
	$diff_factor = 0.25;

	if ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) {

		// Getting most rated
		$diff = $diff_ref;
		$items = listar_most_rated_listings( 2000 );
		foreach ( $items as $item ) {
			$score = $most_rated_score - $diff;
			// Avoiding negative scores, so the other parallel scores already obtained won't be impaired
			if ( $score < 0 ) {
				$score = 0;
			}
			$listings_and_total_scores[] = array( $item[ 'id' ], $score );
			$diff += $diff_factor;
		}

		// Getting top rated
		$diff = $diff_ref;
		$items = listar_best_rated_listings( $items, 2000 );
		foreach ( $items as $item ) {
			$score = $top_rated_score - $diff;
			// Avoiding negative scores, so the other parallel scores already obtained won't be impaired
			if ( $score < 0 ) {
				$score = 0;
			}
			$id_already_exists = 0;
			// Check if current ID already exists on $listings_and_total_scores
			$index = -1;
			foreach ( $listings_and_total_scores as $id_score ) {
				$index += 1;
				if ( $id_score[ 0 ] === $item ) {
					$listings_and_total_scores[ $index ][ 1 ] += $score;
					$id_already_exists = 1;
					break;
				}
			}
			if ( ! $id_already_exists ) {
				$listings_and_total_scores[] = array( $item, $score );
			}
			$diff += $diff_factor;
		}
	}

	if ( listar_bookmarks_active() ) {
		// Getting most bookmarked
		$diff = $diff_ref;
		$items = listar_get_fav_list( 2000 );
		foreach ( $items as $item ) {
			$score = $most_bookmarked_score - $diff;
			// Avoiding negative scores, so the other parallel scores already obtained won't be impaired
			if ( $score < 0 ) {
				$score = 0;
			}
			// Check if current ID already exists on $listings_and_total_scores
			$id_already_exists = 0;
			$index = -1;
			foreach ( $listings_and_total_scores as $id_score ) {
				$index += 1;
				if ( $id_score[ 0 ] === $item ) {
					$listings_and_total_scores[ $index ][ 1 ] += $score;
					$id_already_exists = 1;
					break;
				}
			}
			if ( ! $id_already_exists ) {
				$listings_and_total_scores[] = array( $item, $score );
			}
			$diff += $diff_factor;
		}
	}

	// Getting newest
	$diff = $diff_ref;
	$items = listar_get_newest( 2000 );
	foreach ( $items as $item ) {
		$score = $newest_score - $diff;
		// Avoiding negative scores, so the other parallel scores already obtained won't be impaired
		if ( $score < 0 ) {
			$score = 0;
		}
		// Check if current ID already exists on $listings_and_total_scores
		$id_already_exists = 0;
		$index = -1;
		foreach ( $listings_and_total_scores as $id_score ) {
			$index += 1;
			if ( $id_score[ 0 ] === $item ) {
				$listings_and_total_scores[ $index ][ 1 ] += $score;
				$id_already_exists = 1;
				break;
			}
		}
		if ( ! $id_already_exists ) {
			$listings_and_total_scores[] = array( $item, $score );
		}
		$diff += $diff_factor;
	}

	// Getting featured - don't use $diff
	$items = listar_get_featured( 2000 );
	foreach ( $items as $item ) {
		// Check if current ID already exists on $listings_and_total_scores
		$id_already_exists = 0;
		$index = -1;
		foreach ( $listings_and_total_scores as $id_score ) {
			$index += 1;
			if ( $id_score[ 0 ] === $item ) {
				$listings_and_total_scores[ $index ][ 1 ] += $featured_score;
				$id_already_exists = 1;
				break;
			}
		}
		if ( ! $id_already_exists ) {
			$listings_and_total_scores[] = array( $item, $featured_score );
		}
	}

	// Getting most viewed
	$diff = $diff_ref;
	$items = listar_get_most_viewed( 2000 );
	foreach ( $items as $item ) {
		$score = $most_viewed_score - $diff;
		// Avoiding negative scores, so the other parallel scores already obtained won't be impaired
		if ( $score < 0 ) {
			$score = 0;
		}
		// Check if current ID already exists on $listings_and_total_scores
		$id_already_exists = 0;
		$index = -1;
		foreach ( $listings_and_total_scores as $id_score ) {
			$index += 1;
			if ( $id_score[ 0 ] === $item ) {
				$listings_and_total_scores[ $index ][ 1 ] += $score;
				$id_already_exists = 1;
				break;
			}
		}
		if ( ! $id_already_exists ) {
			$listings_and_total_scores[] = array( $item, $score );
		}
		$diff += $diff_factor;
	}

	// Organizing by best scores
	$temp = array();
	foreach ( $listings_and_total_scores as $key => $row ) {
		$temp[ $key ] = $row[ 1 ];
	}
	array_multisort( $temp, SORT_DESC, $listings_and_total_scores );

	// Checking minimum scores and "maybe" remove
	$temp = $listings_and_total_scores;

	foreach ( $temp as $key => $id ) {
		if ( $id[ 1 ] < $minimum_score_to_trend ) {
			unset( $temp[ $key ] );
		}
	}
	$listings_and_total_scores = $temp;
	
	update_option( 'listar_trending_listings_and_scores', json_encode( $listings_and_total_scores ) );

	// Ignore scores and get only IDs 
	$trending_ids = array();

	foreach ( $listings_and_total_scores as $elem ) {
		$trending_ids[] = $elem[ 0 ];
	}

	$trending_ids = array_filter( $trending_ids );

	// Getting the maximum number of trending items
	if ( count( $trending_ids ) > $max_trending_items ) {
		$trending_ids = array_slice( $trending_ids, 0, $max_trending_items, true );
	}
	return $trending_ids;
}

/*
 * Get the register of trending listings
 */

function listar_get_trending() {
	$trending_listings = get_option( 'listar_trending_listings' );

	if ( empty( $trending_listings ) ) {

		// Call the trending starter function if trending register is empty
		listar_update_top_listings();
		$trending_listings = get_option( 'listar_trending_listings' );
	}
	
	$trending = json_decode( $trending_listings );
	
	if ( ! is_array( $trending ) ) {
		$trending = array();
	}

	return $trending;
}

/*
 * Explode strings separated by comma and clean empty elements
 */

function explode_and_clean( $str ) {
	$array = explode( ',', $str );
	return array_filter( $array );
}

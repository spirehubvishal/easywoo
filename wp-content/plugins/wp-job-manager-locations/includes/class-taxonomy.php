<?php



class Astoundify_Job_Manager_Regions_Taxonomy extends Astoundify_Job_Manager_Regions {



	public function __construct() {

		add_action( 'init', array( $this, 'register_taxonomy' ), 0 );

	}



	/**

	 * Create the `job_listing_region` taxonomy.

	 *

	 * @since 1.0.0

	 */

	public function register_taxonomy() {

		$admin_capability = 'manage_job_listings';



		$job_singular  = __( 'Job Region', 'wp-job-manager-locations' );

		$job_plural    = __( 'Job Regions', 'wp-job-manager-locations' );



		if ( current_theme_supports( 'job-manager-templates' ) ) {

			$job_rewrite     = array(

				'slug'         => _x( 'job-region', 'Job region slug - resave permalinks after changing this', 'wp-job-manager-locations' ),

				'with_front'   => false,

				'hierarchical' => false

			);

			$resume_rewrite     = array(

				'slug'         => _x( 'resume-region', 'Resume region slug - resave permalinks after changing this', 'wp-job-manager-locations' ),

				'with_front'   => false,

				'hierarchical' => false

			);

		} else {

			$job_rewrite = false;

			$resume_rewrite = false;

		}



		register_taxonomy( 'job_listing_region',

			array( 'job_listing' ),

			array(

				'hierarchical' 			=> true,

				'update_count_callback' => '_update_post_term_count',

				'label' 				=> $job_plural,

				'labels' => array(

					'name' 				=> $job_plural,

					'singular_name' 	=> $job_singular,

					'search_items' 		=> __( 'Search Job Regions', 'wp-job-manager-locations' ),

					'all_items' 		=> __( 'All Job Regions', 'wp-job-manager-locations' ), 

					'parent_item' 		=> __( 'Parent Job Region', 'wp-job-manager-locations' ),

					'parent_item_colon' => __( 'Parent Job Region:', 'wp-job-manager-locations' ), 

					'edit_item' 		=> __( 'Edit Job Region', 'wp-job-manager-locations' ),

					'update_item' 		=> __( 'Update Job Region', 'wp-job-manager-locations' ), 

					'add_new_item' 		=> __( 'Add New Job Region', 'wp-job-manager-locations' ), 

					'new_item_name' 	=> __( 'New Job Region Name', 'wp-job-manager-locations' ), 

				),

				'show_ui' 				=> true,

				'query_var' 			=> true,

				'has_archive'           => true,

				'capabilities'			=> array(

					'manage_terms' 		=> $admin_capability,

					'edit_terms' 		=> $admin_capability,

					'delete_terms' 		=> $admin_capability,

					'assign_terms' 		=> $admin_capability,

				),

				'show_in_rest' 			=> true,

				'rewrite' 				=> $job_rewrite,

			)

		);



		$resume_singular  = __( 'Resume Region', 'wp-job-manager-locations' );

		$resume_plural    = __( 'Resume Regions', 'wp-job-manager-locations' );



		register_taxonomy( 'resume_region',

			array( 'resume' ),

			array(

				'hierarchical' 			=> true,

				'update_count_callback' => '_update_post_term_count',

				'label' 				=> $resume_plural,

				'labels' => array(

					'name' 				=> $resume_plural,

					'singular_name' 	=> $resume_singular,

					'search_items' 		=> __( 'Search Resume Regions', 'wp-job-manager-locations' ),

					'all_items' 		=> __( 'All Resume Regions', 'wp-job-manager-locations' ),

					'parent_item' 		=> __( 'Parent Resume Region', 'wp-job-manager-locations' ),

					'parent_item_colon' => __( 'Parent Resume Region:', 'wp-job-manager-locations' ),

					'edit_item' 		=> __( 'Edit Resume Region', 'wp-job-manager-locations' ), 

					'update_item' 		=> __( 'Update Resume Region', 'wp-job-manager-locations' ), 

					'add_new_item' 		=> __( 'Add New Resume Region', 'wp-job-manager-locations' ), 

					'new_item_name' 	=> __( 'New Resume Region Name', 'wp-job-manager-locations' ),  

				),

				'show_ui' 				=> true,

				'query_var' 			=> true,

				'has_archive'           => true,

				'capabilities'			=> array(

					'manage_terms' 		=> $admin_capability,

					'edit_terms' 		=> $admin_capability,

					'delete_terms' 		=> $admin_capability,

					'assign_terms' 		=> $admin_capability,

				),

				'show_in_rest' 			=> true,

				'rewrite' 				=> $resume_rewrite,

			)

		);

	}



}


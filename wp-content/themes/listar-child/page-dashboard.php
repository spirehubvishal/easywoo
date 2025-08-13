<?php
/* Template Name: User Dashboard */
get_header();

// Get current user
$current_user = wp_get_current_user();

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url('/login') );
    exit;
}
?>

<div class="main-dashboard">
    <div class="dashboard-journal-banner">
    <div class="d-flex">
        <a class="link-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        <span class="link-text">Go to my Journal</span>
    </div>
</div>

<div class="dashboard-section">
    <div class="dashboard-section-header">
        <h2>Reports</h2>
        <a href="#" class="dashboard-view-all">View all</a>
    </div>
    <div class="dashboard-reports-cards">
        <!-- Loop through reports -->
        <?php for($i=0;$i<4;$i++): ?>
        <div class="dashboard-report-card">
            <span>Report created on</span>
            <strong>13.04.2024</strong>
            <a href="#" class="dashboard-report-arrow">&rarr;</a>
        </div>
        <?php endfor; ?>
    </div>
</div>

<div class="dashboard-section">
    <div class="dashboard-section-header">
        <h2>Active courses</h2>
        <a href="#" class="dashboard-view-all">View all</a>
    </div>
    <div class="dashboard-courses-cards">
        <!-- Loop through courses -->
        <?php for($i=0;$i<3;$i++): ?>
        <div class="dashboard-course-card">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQImWP4zwAAAgEBACqxsiUAAAAASUVORK5CYII=" alt="Course image" />
            <div class="dashboard-course-title">Stuck on my <?php echo $i+1 ?></div>
        </div>
        <?php endfor; ?>
    </div>
</div>

<div class="dashboard-section">
    <div class="dashboard-section-header">
        <h2>Bookmarks</h2>
        <a href="#" class="dashboard-view-all">View all</a>
    </div>
    <div class="dashboard-bookmarks-cards">
        <?php
        $bookmark_args = array(
            'post_type'      => 'bookmark',
            'posts_per_page' => 10,
            'author'         => $current_user->ID,
        );
        $bookmark_query = new WP_Query($bookmark_args);

        if ($bookmark_query->have_posts()) :
            while ($bookmark_query->have_posts()) : $bookmark_query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                $tags = get_the_terms(get_the_ID(), 'bookmark_category');
                $status = get_post_meta(get_the_ID(), 'bookmark_status', true);
        ?>
        <div class="dashboard-bookmark-card">
            <img src="<?php echo esc_url($image_url ?: 'https://via.placeholder.com/300x180'); ?>" alt="Bookmark image" />
            <div class="dashboard-bookmark-tags">
                <?php if ($status): ?>
                    <span><?php echo esc_html($status); ?></span>
                <?php endif; ?>
                <?php
                if ($tags && !is_wp_error($tags)) {
                    foreach ($tags as $tag) {
                        echo '<span>' . esc_html($tag->name) . '</span>';
                    }
                }
                ?>
            </div>
            <div class="dashboard-bookmark-heart">&#10084;</div>
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        elseif(1):

	$bookmarks_active = listar_bookmarks_active();

	if ( $bookmarks_active ) :
		$url = network_site_url() . '?s=&' . listar_url_query_vars_translate( 'bookmarks_page' ) . '&' . listar_url_query_vars_translate( 'search_type' ) . '=listing';
		?>
		<li class="listar-job-dashboard listar-iconized-menu-item">
			<a href="<?php echo esc_url( $url ); ?>">
				<i class="icon-heart"></i> <?php esc_html_e( 'Bookmarks', 'listar' ); ?>
			</a>
		</li>
		<?php
	endif;

        ?>
        <p>No bookmarks found.</p>
        <?php endif; ?>
<?php
function listar_is_search_by_options_active() {

		/* Are the Explore By options active? */
		$search_by_active = 0 === (int) get_option( 'listar_disable_all_search_by_options' ) && post_type_exists( 'job_listing' ) ? true : false;
		$has_one_search_by_option_active = false;
		
		$search_by_options = array(
			'nearest_me',
			'trending',
			'best_rated',
			'most_viewed',
			'near_address',
			'near_postcode',
			'surprise',
			'shop_products',
			'blog',
		);
		
		$bookmarks_active = listar_bookmarks_active_plugin();
		
		if ( $bookmarks_active ) {
			$search_by_options = array_slice( $search_by_options, 0, 3, true ) +
			array( 'most_bookmarked' ) +
			array_slice( $search_by_options, 3, count( $search_by_options ) -3, true );
		}
		
		foreach ( $search_by_options as $option ) {
			if ( listar_is_search_by_option_active( $option ) ) {
				$has_one_search_by_option_active = true;
				break;
			}
		}

		return $search_by_active && $has_one_search_by_option_active;
	}
    ?>
        
    </div>
</div>

</div>

<style>
    .main-dashboard{
        max-width: 1170px;
        margin:auto;
    }
    .dashboard-topbar {
        background: #FF6600;
        color: #fff;
        display: flex;
        align-items: center;
        padding: 16px 32px;
        justify-content: space-between;
    }
    .easywoo-logo { 
        font-weight: bold; 
        font-size: 1.5em; 
    }
    .dashboard-main-nav a { 
        color: #fff; 
        margin: 0 16px; 
        text-decoration: none; 
        font-weight: 500; 
    }
    .dashboard-user-info { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
    }
    .dashboard-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 50%; 
    }
    .dashboard-journal-banner { 
        background: #FFF3E0; 
        padding: 24px; 
        text-align: center; 
        margin: 24px 0; 
    }
    .dashboard-journal-btn { 
        background: #FF6600; 
        color: #fff; padding: 12px 32px; 
        border-radius: 8px; 
        text-decoration: none; 
        font-weight: 500; 
    }
    .dashboard-section { 
        margin: 32px 0; 
    }
    .dashboard-section-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .dashboard-section-header h2 { 
        margin: 0; 
    }
    .dashboard-view-all { 
        background: #FF6600; 
        color: #fff; 
        padding: 8px 20px; 
        border-radius: 8px; 
        text-decoration: none; 
        font-weight: 500; 
    }
    .dashboard-reports-cards, .dashboard-courses-cards, .dashboard-bookmarks-cards {
        display: flex; 
        gap: 24px; 
        overflow-x: auto; 
        padding: 16px 0;
    }
    .dashboard-report-card, .dashboard-course-card, .dashboard-bookmark-card {
        background: #fff; 
        border-radius: 16px; 
        box-shadow: 0 2px 8px #0001; 
        padding: 24px; 
        min-width: 220px; 
        position: relative; 
        width:100%;
    }
    .dashboard-report-card strong { 
        display: block; 
        margin: 12px 0; 
        font-size: 1.4em; 
        color:#FF6600;
    }
    .dashboard-report-arrow { 
        position: absolute; 
        right: 16px; 
        top: 50%; 
        transform: translateY(-50%); 
        font-size: 1.5em; 
        color: #FF6600; 
        text-decoration: none; 
    }
    .dashboard-course-card img, .dashboard-bookmark-card img { 
        width: 100%; 
        border-radius: 12px; 
    }
    .dashboard-course-title { 
        margin-top: 12px; 
        font-weight: 500; 
    }
    .dashboard-bookmark-tags { 
        margin-top: 12px; 
    }
    .dashboard-bookmark-tags span { 
        background: #FAFAFA; 
        color: #4a4a4a; 
        border-radius: 8px; 
        padding: 4px 10px; 
        margin-right: 6px; 
        font-size: 0.95em; 
    }
    .dashboard-bookmark-heart { 
        position: absolute; 
        bottom: 16px; 
        right: 16px; 
        font-size: 1.5em; 
        color: #FF6600; 
    }
   
</style>

<?php get_footer(); ?>

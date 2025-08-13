<?php
/**
 * Template part for displaying header/cover area of pages/archive/single in general
 */

global $wp_query;

get_header();

// Determine current post ID for title
if (is_home()) {
    $current_post_id = get_option('page_for_posts');
} elseif (is_category() || is_tag() || is_tax()) {
    $current_post_id = null;
} elseif (is_singular()) {
    $current_post_id = get_the_ID();
} else {
    $current_post_id = null;
}

// Set dynamic title
if (is_home()) {
    $page_title = get_the_title($current_post_id);
} elseif (is_category()) {
    $page_title = single_cat_title('', false);
} elseif (is_tag()) {
    $page_title = single_tag_title('', false);
} elseif (is_tax()) {
    $page_title = single_term_title('', false);
} elseif (is_page()) {
    $page_title = get_the_title($current_post_id);
} elseif (is_singular()) {
    $page_title = get_the_title($current_post_id);
} else {
    $page_title = get_bloginfo('name');
}

// Set back URL
$back_url = wp_get_referer() ? wp_get_referer() : home_url();

// ðŸ”’ Only show EasyWoo header if NOT on front page (homepage) and Dashboard
if (!is_front_page() && !is_page_template('page-dashboard.php')) :
?>
<!-- Start EasyWoo Header -->
<header class="easywoo-header">
    <div class="easywoo-header-content">
        <!-- Left Icon -->
        <a href="#" onclick="handleBackClick(event)" class="easywoo-back-icon" title="Back">&#x276E;</a>

        <!-- Title Centered -->
        <div class="easywoo-page-title-wrapper">
            <h1 class="easywoo-page-title"><?php echo esc_html($page_title); ?></h1>
        </div>

        <!-- Placeholder for spacing -->
        <div class="easywoo-right-placeholder"></div>
    </div>
</header>
<!-- End EasyWoo Header -->

<script>
    function handleBackClick(e) {
        e.preventDefault();

        <?php
        $blog_page_url = get_permalink(get_option('page_for_posts'));

        if (
            (is_single() && get_post_type() === 'post') ||  // single blog post
            is_category() || is_tag() || is_tax('category') // blog category/tag
        ) : ?>
            window.location.href = "<?php echo esc_url($blog_page_url); ?>";
        <?php else : ?>
            window.location.href = "<?php echo esc_url(home_url()); ?>";
        <?php endif; ?>
    }
</script>

<style>
    .easywoo-header {
        justify-items: center;
        margin: auto;
        padding: 30px;
    }

    .easywoo-header-content {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(150, 150, 150, 0.25);
        padding: 15px 20px;
        background-color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;    
    }

    .easywoo-back-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #333;
        text-decoration: none;
        width: 40px;
        height: 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(150, 150, 150, 0.25);
        transition: all 0.2s ease;
    }

    .easywoo-back-icon:hover {
        color: #000;
    }

    .easywoo-page-title-wrapper {
        text-align: center;
        flex-grow: 1;
    }

    .easywoo-page-title {
        font-size: 24px;
        margin: 0;
        font-weight: bold;
    }

    .easywoo-right-placeholder {
        width: 24px; /* balances the left icon */
    }
    @media (max-width: 480px) {
        .easywoo-header-content {
            padding: 10px 10px;
        }

        .easywoo-back-icon {
            width: 30px;
            height: 30px;
            font-size: 18px;
        }

        .easywoo-page-title {
            font-size: 20px;
        }

        .easywoo-right-placeholder {
            width: 30px;
        }
    }

</style>

<?php endif; ?>

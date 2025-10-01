<?php

/* 

Template Name: Prefiltered News Aggregate
Description: Use this template and specify the filters to use to pull the 

*/
?>

<?php
get_header();
?>


<?php
// get meta options
$prefiltered_news_aggregate_category_ids = get_post_meta(get_the_ID(), 'prefiltered_news_aggregate_category_ids', true);
$prefiltered_news_aggregate_include_left_rail = get_post_meta(get_the_ID(), 'prefiltered_news_aggregate_include_left_rail', true);
$prefiltered_news_aggregate_tag_ids = get_post_meta(get_the_ID(), 'prefiltered_news_aggregate_tag_ids', true);
$prefiltered_news_aggregate_years = get_post_meta(get_the_ID(), 'prefiltered_news_aggregate_years', true);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number

$yearFilterDateQuery = array();
if (!empty($prefiltered_news_aggregate_years)) {

    // create a date_query value combining all years in this filter with OR relation
    $yearFilterDateQuery = array_map(function ($year) {
        return array(
            'year' => $year,
        );
    }, $prefiltered_news_aggregate_years);
    // prefix that array with 'relation'=>'OR'
    $yearFilterDateQuery = array_merge(array('relation' => 'OR'), $yearFilterDateQuery);
}

// passed to pagination and to filter component 
$page_slug = get_page_uri();
if ($page_slug) {
    $base_url = '/' . $page_slug . '';
} else {
    $base_url = '';
}

// run query; filter by tagFilter, catFilter, and yearFilter
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 13,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC'
);
if (!empty($prefiltered_news_aggregate_category_ids)) {
    $args['category__in'] = $prefiltered_news_aggregate_category_ids;
}
if (!empty($prefiltered_news_aggregate_tag_ids)) {
    $args['tag__in'] = $prefiltered_news_aggregate_tag_ids;
}
if (!empty($yearFilterDateQuery)) {
    $args['date_query'] = $yearFilterDateQuery;
}
$query = new WP_Query($args);
?>

<?php
if ($prefiltered_news_aggregate_include_left_rail) {
    // include left rail
    ?>
    <main id="main" class="aggregate aggregate--news">
        <div class="aggregate__wrapper wrapper">
            <div class="row level__row">
                <div class="level__aside xsmall-12 large-3 column">
                    <div class="level__aside--wrapper">
                        <div class="level__header">
                            <h1>
                                <?php the_title(); ?>
                            </h1>
                        </div>
                        <?php
                        dynamic_sidebar('prefiltered-news-aggregate-sidebar-area');
                        ?>
                    </div>
                </div>
                <div class="aggregate__content xsmall-12 large-8 large-offset-1 column">
                    <div class="row level__row">
                        <div id="results-full-container" class="aggregate__set">
                            <div class="aggregate__header">
                                <h1 class="font-special-2" aria-hidden="true">
                                    <?php
                                    echo the_title();
                                    ?>
                                </h1>
                                <hr>
                            </div>
                            <?php
                            // get first post from query 
                            $first_post = $query->posts[0];
                            // display main feature article
                            display_featured_post_card($first_post, wide: true);
                            ?>
                        </div>
                    </div>
                    <div class="row level__row component grid-x grid-margin-x grid-margin-y cell">
                        <?php
                        if ($query->have_posts()) {
                            $counter = 0;
                            while ($query->have_posts()) {
                                $query->the_post();
                                // skip first post (already displayed)
                                if ($counter == 0) {
                                    $counter++;
                                    continue;
                                }
                                display_single_post_card(
                                    post: $post,
                                    wide: false,
                                    display_excerpt: false,
                                    display_published_date: true,
                                    display_author: true,
                                    medium_screen_class: 'medium-6',
                                    large_screen_class: '',
                                    title_heading_size: 'h4'
                                );
                            }
                            wp_reset_postdata(); // At the end reset your query
                    
                            ?>
                            <div class="cell xsmall-12">
                                <div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
                                    <?php
                                    echo custom_pagination_links(
                                        max_num_pages: $query->max_num_pages,
                                        current_page: $paged,
                                        base_url: $base_url,
                                    ); ?>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="aggregate__content xsmall-12 column text-center" style="padding: 2rem">
                                <h2>No posts found</h2>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php
} else {
    // no left rail
    ?>
    <main id="main" class="aggregate aggregate--news">
        <div class="aggregate__wrapper wrapper">
            <div class="aggregate__inner">
                <div class="row level__row">
                    <div class="aggregate__content xsmall-12 column">
                        <div id="results-full-container" class="aggregate__set">
                            <div class="aggregate__header">
                                <h1 class="font-special-2" aria-hidden="true">
                                    <?php
                                    echo the_title();
                                    ?>
                                </h1>
                                <hr>
                            </div>
                            <?php
                            // get first post from query 
                            $first_post = $query->posts[0];
                            display_featured_post_card($first_post, wide: true);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row level__row component grid-x grid-margin-x grid-margin-y cell">
                    <?php
                    if ($query->have_posts()) {
                        $counter = 0;
                        while ($query->have_posts()) {
                            $query->the_post();
                            // skip first post (already displayed)
                            if ($counter == 0) {
                                $counter++;
                                continue;
                            }
                            display_single_post_card(
                                post: $post,
                                wide: false,
                                display_excerpt: false,
                                display_published_date: true,
                                display_author: true,
                                medium_screen_class: 'medium-6',
                                large_screen_class: '',
                                title_heading_size: 'h4'
                            );
                        }
                        wp_reset_postdata(); // At the end reset your query
                
                        ?>
                        <div class="cell xsmall-12">
                            <div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
                                <?php
                                echo custom_pagination_links(
                                    max_num_pages: $query->max_num_pages,
                                    current_page: $paged,
                                    base_url: $base_url,
                                ); ?>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="aggregate__content xsmall-12 column text-center" style="padding: 2rem">
                            <h2>No posts found</h2>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
}
?>

<?php get_footer(); ?>
<?php

/* 

Template Name: Filterable News Aggregate
Description: use this template if you'd like to provide an easy central place for readers to filter news stories by category, tag, and year.

*/
?>

<?php
get_header();
?>


<?php
// get meta options
$filterable_news_aggregate_category_ids = get_post_meta(get_the_ID(), 'filterable_news_aggregate_category_ids', true);
$filterable_news_aggregate_tag_ids = get_post_meta(get_the_ID(), 'filterable_news_aggregate_tag_ids', true);
$filterable_news_aggregate_filter_headline = get_post_meta(get_the_ID(), 'filterable_news_aggregate_filter_headline', true);
if (!$filterable_news_aggregate_filter_headline) {
    $filterable_news_aggregate_filter_headline = 'Filter Stories';
}
$filterable_news_aggregate_years = get_post_meta(get_the_ID(), 'filterable_news_aggregate_years', true);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number

// if any are empty or not set, set them to empty array
if (!$filterable_news_aggregate_category_ids || empty($filterable_news_aggregate_category_ids)) {
    $filterable_news_aggregate_category_ids = array();
}
if (!$filterable_news_aggregate_tag_ids || empty($filterable_news_aggregate_tag_ids)) {
    $filterable_news_aggregate_tag_ids = array();
}
if (!$filterable_news_aggregate_years || empty($filterable_news_aggregate_years)) {
    $filterable_news_aggregate_years = array();
}



// init query filters
$catFilter = array();
$tagFilter = array();
$yearFilter = array();
$yearFilterDateQuery = array();
// get current filters from query vars  
if (isset($_GET['catFilter']) && !empty($_GET['catFilter'])) {
    $catFilter = $_GET['catFilter'];
    $catFilter = explode(',', $catFilter);
}
if (isset($_GET['tagFilter']) && !empty($_GET['tagFilter'])) {
    $tagFilter = $_GET['tagFilter'];
    $tagFilter = explode(',', $tagFilter);
}
if (isset($_GET['yearFilter']) && !empty($_GET['yearFilter'])) {
    $yearFilter = $_GET['yearFilter'];
    $yearFilter = explode(',', $yearFilter);

    // create a date_query value combining all years in this filter with OR relation
    $yearFilterDateQuery = array_map(function ($year) {
        return array(
            'year' => $year,
        );
    }, $yearFilter);
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
if (!empty($catFilter)) {
    $args['category__in'] = $catFilter;
}
if (!empty($tagFilter)) {
    $args['tag__in'] = $tagFilter;
}
if (!empty($yearFilterDateQuery)) {
    $args['date_query'] = $yearFilterDateQuery;
}
$query = new WP_Query($args);

function remove_query_param_value($queryParamKey, $valueToRemove)
{
    if (isset($_GET[$queryParamKey])) {
        $queryParamValue = $_GET[$queryParamKey];
        $queryParamValue = explode(',', $queryParamValue);
        $queryParamValue = array_diff($queryParamValue, array($valueToRemove));
        $queryParamValue = implode(',', $queryParamValue);

        // get full URL 
        $full_url = $_SERVER['REQUEST_URI'];

        // remove query param from URL and then add it back with new value
        $full_url = remove_query_arg($queryParamKey, $full_url);
        $full_url = add_query_arg($queryParamKey, $queryParamValue, $full_url);
        return $full_url;
    } else {
        return '';
    }
}

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
                    aggregate_rail_filter_component(
                        filter_headline: $filterable_news_aggregate_filter_headline,
                        filterable_category_ids: $filterable_news_aggregate_category_ids,
                        filterable_tag_ids: $filterable_news_aggregate_tag_ids,
                        filterable_years: $filterable_news_aggregate_years,
                        checked_category_ids: $catFilter,
                        checked_tag_ids: $tagFilter,
                        checked_years: $yearFilter,
                        base_url: $base_url
                    );
                    ?>
                </div>
            </div>

            <div class="aggregate__content xsmall-12 large-8 large-offset-1 column">
                <div id="results-full-container" class="aggregate__set">
                    <div class="aggregate__header">
                        <h1 class="font-special-2" aria-hidden="true">
                            <?php
                            echo the_title();
                            ?>
                        </h1>
                        <hr>
                    </div>
                    <div id="results-info-container" class="row level_search--navigation aggregate__info">
                        <div id="results-count"
                            class="level__pages xsmall-12 large-3 large-order-2 column aggregate__count ">
                            <?php
                            // want to show the number of posts that match the current filters
                            // e.g. 1 to 12 of 3 pages
                            // get the total number of posts that match the current filters
                            $total_posts = $query->found_posts;
                            if ($total_posts > 0) {
                                // get the number of posts per page
                                $posts_per_page = $query->query_vars['posts_per_page'];
                                // get the current page number
                                $current_page = $query->query_vars['paged'];
                                // calculate the first post number on this page
                                $first_post = ($current_page - 1) * $posts_per_page + 1;
                                // calculate the last post number on this page
                                $last_post = $first_post + $posts_per_page - 1;
                                // if this is the last page, the last post number is the total number of posts
                                if ($current_page == $query->max_num_pages) {
                                    $last_post = $total_posts;
                                }
                                // display the first and last post numbers and the total number of posts
                                echo $first_post . ' to ' . $last_post . ' of ' . $total_posts . ' posts';
                            }
                            ?>
                        </div>
                        <div class="xsmall-12 large-9 large-order-1 column">
                            <div class="level__chips_wrapper">
                                <div id="results_chips" class="aggregate__chips">
                                    <?php
                                    // for each applied filter 
                                    foreach ($catFilter as $catId) {
                                        if (is_numeric($catId)) {
                                            $catId = intval($catId);
                                        } else {
                                            continue;
                                        }
                                        // get category name
                                        $catName = get_cat_name($catId);
                                        // remove this category from the query string
                                        $new_url = remove_query_param_value('catFilter', $catId);
                                        ?>
                                        <a href="<?php echo $new_url ?>" class="chip" data-key="<?php echo $catId ?>">
                                            <span class="chip__close">
                                                <span class="show-for-sr">Remove this filter</span>
                                                <svg class="brei-icon brei-icon-close" focusable="false">
                                                    <use href="#brei-icon-close"></use>
                                                </svg>
                                            </span>

                                            <span class="chip__label">
                                                <?php echo $catName ?>
                                            </span>
                                        </a>
                                        <?php
                                    }

                                    foreach ($tagFilter as $tagId) {
                                        if (is_numeric($tagId)) {
                                            $tagId = intval($tagId);
                                        } else {
                                            continue;
                                        }
                                        // get tag name
                                        $tagName = get_term($tagId)->name;
                                        // remove this tag from the query string
                                        $new_url = remove_query_param_value('tagFilter', $tagId);
                                        ?>
                                        <a href="<?php echo $new_url ?>" class="chip" data-key="<?php echo $tagId ?>">
                                            <span class="chip__close">
                                                <span class="show-for-sr">Remove this filter</span>
                                                <svg class="brei-icon brei-icon-close" focusable="false">
                                                    <use href="#brei-icon-close"></use>
                                                </svg>
                                            </span>

                                            <span class="chip__label">
                                                <?php echo $tagName ?>
                                            </span>
                                        </a>
                                        <?php
                                    }

                                    foreach ($yearFilter as $year) {
                                        if (is_numeric($year)) {
                                            $year = intval($year);
                                        } else {
                                            continue;
                                        }
                                        // remove this year from the query string
                                        $new_url = remove_query_param_value('yearFilter', $year);
                                        ?>
                                        <a href="<?php echo $new_url ?>" class="chip" data-key="<?php echo $year ?>">
                                            <span class="chip__close">
                                                <span class="show-for-sr">Remove this filter</span>
                                                <svg class="brei-icon brei-icon-close" focusable="false">
                                                    <use href="#brei-icon-close"></use>
                                                </svg>
                                            </span>

                                            <span class="chip__label">
                                                <?php echo $year ?>
                                            </span>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                // only show clear all if there are filters applied
                                if (!empty($catFilter) || !empty($tagFilter) || !empty($yearFilter)) {
                                    ?>
                                    <div class="clear-chip_wrapper">
                                        <?php
                                        // get URL of current page without the query string
                                        $current_url = strtok($_SERVER["REQUEST_URI"], '?');
                                        ?>
                                        <a href="<?php echo $current_url ?>" class="aggregate__reset clear--chips">Clear
                                            All</a>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div id="results-listings-container"
                        class="aggregate__results row grid-x grid-margin-x grid-margin-y">
                        <?php
                        if ($query->have_posts()) {
                            $counter = 0;
                            while ($query->have_posts()) {
                                $query->the_post();
                                $counter++;
                                if ($counter == 1) {
                                    // display main feature article
                                    display_main_feature_article_card($post, wide: false);
                                } else {
                                    // display sub feature article
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
                                        append_to_end_of_url: "?" . $_SERVER["QUERY_STRING"]
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
    </div>
</main>
<?php get_footer(); ?>
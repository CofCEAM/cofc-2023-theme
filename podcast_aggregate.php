<?php

/* 

Template Name: Podcast Aggregate
Description: Similar to News Aggregate, but for podcasts, with a section for podcast links on the bottom

*/
?>

<?php
get_header();
?>


<?php
// get meta options
$podcast_aggregate_podcast_main_filter_value = get_post_meta(get_the_ID(), 'podcast_aggregate_podcast_main_filter_value', true);
$podcast_aggregate_podcast_main_filter_type = get_post_meta(get_the_ID(), 'podcast_aggregate_podcast_main_filter_type', true);
$podcast_aggregate_filterable_category_ids = get_post_meta(get_the_ID(), 'podcast_aggregate_filterable_category_ids', true);
$podcast_aggregate_filterable_tag_ids = get_post_meta(get_the_ID(), 'podcast_aggregate_filterable_tag_ids', true);
$podcast_aggregate_filter_headline = get_post_meta(get_the_ID(), 'podcast_aggregate_filter_headline', true);

if (!$podcast_aggregate_filter_headline) {
    $podcast_aggregate_filter_headline = 'Filter Stories';
}
$podcast_aggregate_filterable_years = get_post_meta(get_the_ID(), 'podcast_aggregate_filterable_years', true);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number

// if any are empty or not set, set them to empty arrays
if (!$podcast_aggregate_filterable_category_ids || empty($podcast_aggregate_filterable_category_ids)) {
    $podcast_aggregate_filterable_category_ids = array();
}
if (!$podcast_aggregate_filterable_tag_ids || empty($podcast_aggregate_filterable_tag_ids)) {
    $podcast_aggregate_filterable_tag_ids = array();
}
if (!$podcast_aggregate_filterable_years || empty($podcast_aggregate_filterable_years)) {
    $podcast_aggregate_filterable_years = array();
}

// init query filters - $catFilter and $tagFilter are the user-defined filters
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

$mainCatFilter = array();
$mainTagFilter = array();
if ($podcast_aggregate_podcast_main_filter_type == 'category') {
    $mainCatFilter[] = $podcast_aggregate_podcast_main_filter_value;
} else if ($podcast_aggregate_podcast_main_filter_type == 'tag') {
    $mainTagFilter[] = $podcast_aggregate_podcast_main_filter_value;
}

// passed to pagination and to filter component
$page_slug = get_page_uri();
if ($page_slug) {
    $base_url = '/' . $page_slug . '';
} else {
    $base_url = '';
}

# post matches (MAIN_FILTER) AND (ANY OF USER_DEFINED_FILTERS)
if (!empty($mainCatFilter)) {
    // Start building tax_query with primary category
    $tax_query = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $mainCatFilter,
        ),
        // Sub-query for user-specified filters
        array(
            'relation' => 'OR',
        )
    );
}
if (!empty($mainTagFilter)) {
    // Start building tax_query with primary category
    $tax_query = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $mainTagFilter,
        ),
        // Sub-query for user-specified filters
        array(
            'relation' => 'OR',
        )
    );
}


// run query; filter by tagFilter, catFilter, and yearFilter
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 13,
    'paged' => $paged,
);

if (!empty($yearFilterDateQuery)) {
    $args['date_query'] = $yearFilterDateQuery;
}

if (!empty($catFilter)) {
    foreach ($catFilter as $catId) {
        if (is_numeric($catId)) {
            $catId = intval($catId);
            $tax_query[1][] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $catId,
            );
        }
    }
}
if (!empty($tagFilter)) {
    foreach ($tagFilter as $tagId) {
        if (is_numeric($tagId)) {
            $tagId = intval($tagId);
            $tax_query[1][] = array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tagId,
            );
        }
    }
}

$args['tax_query'] = $tax_query;
$query = new WP_Query($args);

echo "TAX QUERY";
var_dump($tax_query);
var_dump($podcast_aggregate_filterable_category_ids);
var_dump($podcast_aggregate_filterable_tag_ids);
var_dump($podcast_aggregate_filter_headline);
var_dump($podcast_aggregate_filterable_years);
var_dump($paged);

echo "catFilter";
var_dump($catFilter);

echo "tagFilter";
var_dump($tagFilter);

echo "main filter";
var_dump($podcast_aggregate_podcast_main_filter_value);
var_dump($podcast_aggregate_podcast_main_filter_type);
?>
-->
<?php

function filterIsRemovable($filterType, $filterValue)
{
    global $podcast_aggregate_podcast_main_filter_type;
    global $podcast_aggregate_podcast_main_filter_value;
    // do not allow the main filter to be removed
    if ($filterType == $podcast_aggregate_podcast_main_filter_type && $filterValue == $podcast_aggregate_podcast_main_filter_value) {
        return false;
    }
    return true;
}

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
                        filter_headline: $podcast_aggregate_filter_headline,
                        filterable_category_ids: $podcast_aggregate_filterable_category_ids,
                        filterable_tag_ids: $podcast_aggregate_filterable_tag_ids,
                        filterable_years: $podcast_aggregate_filterable_years,
                        checked_category_ids: $catFilter,
                        checked_tag_ids: $tagFilter,
                        checked_years: $yearFilter,
                        base_url: $base_url
                    );
                    ?>
                    <!-- spacer -->
                    <div class="aggregate__spacer" style="margin-top: 2rem"></div>
                    <?php

                    // additional widgets can be added in Appearance > Widgets > Podcat Aggregate Template - Left Rail /
                    // Sidebar Area
                    dynamic_sidebar('podcast-aggregate-sidebar-area');
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

                                    $removable_filters = 0;
                                    // for each applied filter 
                                    foreach ($catFilter as $catId) {
                                        if (is_numeric($catId) && filterIsRemovable('category', $catId)) {
                                            $catId = intval($catId);
                                            $removable_filters++;
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
                                        if (is_numeric($tagId) && filterIsRemovable('tag', $tagId)) {
                                            $tagId = intval($tagId);
                                            $removable_filters++;
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
                                            $removable_filters++;
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
                                if ($removable_filters > 0) {
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
                                // display sub feature article
                                display_single_post_card(
                                    post: $post,
                                    wide: false,
                                    display_excerpt: false,
                                    display_published_date: true,
                                    display_author: true,
                                    medium_screen_class: 'medium-6',
                                    large_screen_class: '',
                                    title_heading_size: 'h4',
                                    podcast: true
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
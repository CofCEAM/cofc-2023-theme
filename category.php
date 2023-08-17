<?php get_header(); ?>

<?php

$category = get_queried_object();
$posts = null;
if ($category) {
    $category_name = $category->name;
    $category_id = $category->term_id;
    $category_slug = $category->slug;
}
?>
<main id="main" class="aggregate aggregate--magazine">
    <div class="aggregate__wrapper wrapper">
        <div class="aggregate__inner">
            <div class="row level__row">
                <div class="aggregate__content xsmall-12 column">
                    <div id="results-full-container" class="aggregate__set">
                        <div class="aggregate__header--magazine">
                            <h1 class="aggregate__title font-special-2">
                                <?php echo $category_name; ?>
                            </h1>
                            <hr />
                        </div>
                        <?php
                        $posts = get_posts(
                            array(
                                'numberposts' => 1,
                                // all posts
                                'category' => $category_id,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            )
                        );
                        if ($posts) {
                            $featured = array_shift($posts);
                            display_featured_post_card($post, wide: true);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number 
            $args = array(
                'post_type' => 'post',
                'post__not_in' => array($featured->ID),
                'cat' => $category_id,
                // Pass the current page number to the query
                'paged' => $paged,
                // pull default posts per page from settings
                'posts_per_page' => get_option('posts_per_page'),
                // Set the number of posts per page
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                ?>
                <div class="row level__row component grid-x grid-margin-x grid-margin-y cell">
                    <?php while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <div class="aggregate__content xsmall-12 medium-6 large-4 cell">
                            <?php
                            display_featured_post_card($post, wide: false);
                            ?>
                        </div>
                        <?php
                    }
                    wp_reset_postdata(); // At the end reset your query 
                    ?>

                    <div class="xsmall-12">
                        <div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
                            <?php
                            echo custom_pagination_links($query->max_num_pages, $paged, $base_url = '/category/' . $category_slug);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else { ?>
                <div class="component">
                    <div class="row level__row">
                        <div class="level__content large-8 large-push-2 columns">
                            <h1 class="page-title">No posts were found with this category</h1>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</main>
<?php get_footer(); ?>
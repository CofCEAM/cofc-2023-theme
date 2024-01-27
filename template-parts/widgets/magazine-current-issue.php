<?php
/* 
Widget Name: CofC Theme Magazine Current Issue
Description: Display a paginated 3-column grid of articles from current issue of magazine pulled via categories or tags (max 9 per page)
*/

class MagazineCurrentIssueWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'magazine-current-issue-widget',
            // Base ID
            'CofC Theme Magazine Current Issue',
            // Name,
            array('description' => 'Display a paginated 3-column grid of articles from current issue of magazine pulled via categories or tags (max 9 per page).')

        );
    }


    function widget($args, $instance)
    {
        $defaults = array(
            'title' => 'Current Issue',
            'post_categories' => array(),
            'post_tags' => array(),
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        extract($args);

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];

        // always exclude current post
        global $post;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : null; // Get the current page number  

        $query = new WP_Query(
            array(
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'posts_per_page' => 9
            )
        );
        ?>
        <div class="aggregate__content xsmall-12 cell">
            <h2 class="aggregate__current font-h1">
                <?php
                if ($instance['title']) {
                    echo $instance['title'];
                } else {
                    echo 'Current Issue';
                }
                ?>
            </h2>
        </div>
        <?php
        if ($query->have_posts()) {

            while ($query->have_posts()) {
                $query->the_post();
                // display the rest in a grid
                display_single_magazine_article_card(post: $post, large_screen_class: 'large-4');
            }
            // reset post to current post
            wp_reset_postdata();
            ?>
            <div class="xsmall-12">
                <div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
                    <?php
                    // get page slug
                    $page_slug = get_page_uri();
                    if ($page_slug) {
                        $base_url = '/' . $page_slug . '';
                    } else {
                        $base_url = '';
                    }
                    echo custom_pagination_links(
                        max_num_pages: $query->max_num_pages,
                        current_page: $paged,
                        base_url: $base_url
                    );
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <h3>No articles found.</h3>
            <?php
        }
    } //widget

    function update($new_instance, $old_instance)
    {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $post_categories = array();
        if (isset($new_instance['post_categories']) && is_array($new_instance['post_categories'])) {
            foreach ($new_instance['post_categories'] as $category) {
                $post_categories[] = sanitize_text_field($category);
            }
        }
        $instance['post_categories'] = $post_categories;

        $post_tags = array();
        if (isset($new_instance['post_tags']) && is_array($new_instance['post_tags'])) {
            foreach ($new_instance['post_tags'] as $tag) {
                $post_tags[] = sanitize_text_field($tag);
            }
        }
        $instance['post_tags'] = $post_tags;

        return $instance;
    }
    function booltostr(bool $val)
    {
        return $val ? 'yes' : 'no';
    }

    function form($instance)
    {
        $defaults = array(
            'post_categories' => array(),
            'post_tags' => array(),
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];

        $categories = get_categories();
        $tags = get_tags();

        // what to display
        ?>
        <p>For this widget, all you need to specify is what filter(s) (can be tags or categories) to use to pull all of the
            current issue articles. You can also specify a title to display above the grid of articles.</p>
        <div>
            <label for="<?= $this->get_field_id('title') ?>">Title</label>
            <input type="text" id="<?= $this->get_field_id('title') ?>" name="<?= $this->get_field_name('title') ?>"
                value="<?= $instance['title'] ?>">

            <h3>Categories</h3>
            <div style="max-height: 250px; overflow-y: scroll">
                <?php foreach ($categories as $cat): ?>
                    <p>
                        <input <?= in_array($cat->cat_ID, $post_categories) ? 'checked' : '' ?> type="checkbox"
                            value="<?= $cat->cat_ID ?>" id="<?= $this->get_field_id('post_categories') ?>-<?= $cat->cat_ID ?>"
                            name="<?= $this->get_field_name('post_categories') ?>[]">
                        <label for="<?= $this->get_field_id('post_categories') ?>-<?= $cat->cat_ID ?>">
                            <?= $cat->name ?>
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <hr />
        <div>
            <h3>Tags</h3>
            <div style="max-height: 250px; overflow-y: scroll">
                <?php foreach ($tags as $tag): ?>
                    <p>
                        <input <?= in_array($tag->term_id, $post_tags) ? 'checked' : '' ?> type="checkbox"
                            value="<?= $tag->term_id ?>" id="<?= $this->get_field_id('post_tags') ?>-<?= $tag->term_id ?>"
                            name="<?= $this->get_field_name('post_tags') ?>[]">
                        <label for="<?= $this->get_field_id('post_tags') ?>-<?= $tag->term_id ?>">
                            <?= $tag->name ?>
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}

function register_MagazineCurrentIssueWidget()
{
    register_widget('MagazineCurrentIssueWidget');
}
add_action('widgets_init', 'register_MagazineCurrentIssueWidget');
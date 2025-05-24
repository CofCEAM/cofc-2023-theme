<?php
/* Widget that allows you to feed in a chosen number of featured posts with optional filtering */

class FeaturedPostsWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'featured-posts-widget',
            // Base ID
            'CofC Theme Featured Posts',
            // Name,
            array('description' => 'Display featured posts with optional filtering.')

        );
    }


    function widget($args, $instance)
    {
        error_log('widget: args: ' . print_r($args, true));
        error_log('widget: instance: ' . print_r($instance, true));
        $defaults = array(
            'post_categories' => array(),
            'post_tags' => array(),
            'display_post_excerpt' => true,
            'display_post_published_date' => true,
            'display_post_author' => true,
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        extract($args);

        $post_categories = isset($instance['post_categories']) ? $instance['post_categories'] : array();
        $post_tags = isset($instance['post_tags']) ? $instance['post_tags'] : array();
        $display_post_excerpt = isset($instance['display_post_excerpt']) ? $instance['display_post_excerpt'] : true;
        $display_post_published_date = isset($instance['display_post_published_date']) ? $instance['display_post_published_date'] : true;
        $display_post_author = isset($instance['display_post_author']) ? $instance['display_post_author'] : true;

        // always exclude current post
        global $post;
        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'orderby' => 'date',
                'order' => 'DESC',
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => 4
            )
        );
        if ($query->have_posts()) {
            $counter = 0;
            while ($query->have_posts()) {
                $query->the_post();
                $counter++;
                if ($counter == 1) {
                    // display the first item as a main feature
                    display_single_post_card(
                        post: $post,
                        wide: true,
                        display_excerpt: $display_post_excerpt,
                        display_published_date: $display_post_published_date,
                        display_author: $display_post_author,
                        title_heading_size: 'h3'
                    );
                } else {
                    // display the rest in a grid
                    display_single_post_card(
                        post: $post,
                        wide: false,
                        display_excerpt: $display_post_excerpt,
                        display_published_date: $display_post_published_date,
                        display_author: $display_post_author,
                        medium_screen_class: 'medium-6',
                        large_screen_class: 'large-4',
                        title_heading_size: 'h4'
                    );
                }
            }
            wp_reset_postdata(); // At the end reset your query
        }
    } //widget

    function update($new_instance, $old_instance)
    {

        $instance = $old_instance;
        $post_categories = array();
        if (isset($new_instance['post_categories']) && is_array($new_instance['post_categories'])) {
            foreach ($new_instance['post_categories'] as $category) {
                $post_categories[] = sanitize_text_field($category);
            }
        }


        $post_tags = array();
        if (isset($new_instance['post_tags']) && is_array($new_instance['post_tags'])) {
            foreach ($new_instance['post_tags'] as $tag) {
                $post_tags[] = sanitize_text_field($tag);
            }
        }

        $instance['post_categories'] = $post_categories;
        $instance['post_tags'] = $post_tags;
        $instance['display_post_excerpt'] = isset($new_instance['display_post_excerpt']) && $new_instance['display_post_excerpt'] == 'yes';
        $instance['display_post_published_date'] = isset($new_instance['display_post_published_date']) && $new_instance['display_post_published_date'] == 'yes';
        $instance['display_post_author'] = isset($new_instance['display_post_author']) && $new_instance['display_post_author'] == 'yes';

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
            'display_post_excerpt' => true,
            'display_post_published_date' => true,
            'display_post_author' => true,
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $post_categories = isset($instance['post_categories']) ? $instance['post_categories'] : array();
        $post_tags = isset($instance['post_tags']) ? $instance['post_tags'] : array();
        $display_post_excerpt = isset($instance['display_post_excerpt']) ? $this->booltostr($instance['display_post_excerpt']) : '';
        $display_post_published_date = isset($instance['display_post_published_date']) ? $this->booltostr($instance['display_post_published_date']) : '';
        $display_post_author = isset($instance['display_post_author']) ? $this->booltostr($instance['display_post_author']) : '';


        $categories = get_categories();
        $tags = get_tags();

        // what to display
        ?>
        <div>
            <h3>Display</h3>
            <h4>Show Excerpts</h4>
            <p>
                <label for="<?php echo $this->get_field_id('display_post_excerpt') ?>-yes">Yes</label>
                <input <?php echo checked($display_post_excerpt, 'yes', false) ?> type="radio" value="yes"
                    id="<?php echo $this->get_field_id('display_post_excerpt') ?>-yes"
                    name="<?php echo $this->get_field_name('display_post_excerpt') ?>">
                <label for="<?php echo $this->get_field_id('display_post_excerpt') ?>-no">No</label>
                <input <?php echo checked($display_post_excerpt, 'no', false) ?> type="radio" value="no"
                    id="<?php echo $this->get_field_id('display_post_excerpt') ?>-no"
                    name="<?php echo $this->get_field_name('display_post_excerpt') ?>">
            </p>
            <h4>Show Published Date</h4>
            <p>
                <label for="<?php echo $this->get_field_id('display_post_published_date') ?>-yes">Yes</label>
                <input <?php echo checked($display_post_published_date, 'yes', false) ?> type="radio" value="yes"
                    id="<?php echo $this->get_field_id('display_post_published_date') ?>-yes"
                    name="<?php echo $this->get_field_name('display_post_published_date') ?>">
                <label for="<?php echo $this->get_field_id('display_post_published_date') ?>-no">No</label>
                <input <?php echo checked($display_post_published_date, 'no', false) ?> type="radio" value="no"
                    id="<?php echo $this->get_field_id('display_post_published_date') ?>-no"
                    name="<?php echo $this->get_field_name('display_post_published_date') ?>">
            </p>
            <h4>Show Author</h4>
            <p>
                <label for="<?php echo $this->get_field_id('display_post_author') ?>-yes">Yes</label>
                <input <?php echo checked($display_post_author, 'yes', false) ?> type="radio" value="yes"
                    id="<?php echo $this->get_field_id('display_post_author') ?>-yes"
                    name="<?php echo $this->get_field_name('display_post_author') ?>">
                <label for="<?php echo $this->get_field_id('display_post_author') ?>-no">No</label>
                <input <?php echo checked($display_post_author, 'no', false) ?> type="radio" value="no"
                    id="<?php echo $this->get_field_id('display_post_author') ?>-no"
                    name="<?php echo $this->get_field_name('display_post_author') ?>">
            </p>
        </div>
        <hr />
        <div>
            <h3>Filtering</h3>
            <h4>Limit to Categories</h4>
            <div style="max-height: 250px; overflow-y: scroll">
                <?php foreach ($categories as $cat): ?>
                    <p>
                        <input <?php echo in_array($cat->cat_ID, $post_categories) ? 'checked' : '' ?> type="checkbox"
                            value="<?php echo $cat->cat_ID ?>" id="<?php echo $this->get_field_id('post_categories') ?>-<?php echo $cat->cat_ID ?>"
                            name="<?php echo $this->get_field_name('post_categories') ?>[]">
                        <label for="<?php echo $this->get_field_id('post_categories') ?>-<?php echo $cat->cat_ID ?>">
                            <?php echo $cat->name ?>
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <hr />
        <div>
            <h4>Limit to Tags</h4>
            <div style="max-height: 250px; overflow-y: scroll">
                <?php foreach ($tags as $tag): ?>
                    <p>
                        <input <?php echo in_array($tag->term_id, $post_tags) ? 'checked' : '' ?> type="checkbox"
                            value="<?php echo $tag->term_id ?>" id="<?php echo $this->get_field_id('post_tags') ?>-<?php echo $tag->term_id ?>"
                            name="<?php echo $this->get_field_name('post_tags') ?>[]">
                        <label for="<?php echo $this->get_field_id('post_tags') ?>-<?php echo $tag->term_id ?>">
                            <?php echo $tag->name ?>
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}

function register_FeaturedPostsWidget()
{
    register_widget('FeaturedPostsWidget');
}
add_action('widgets_init', 'register_FeaturedPostsWidget');
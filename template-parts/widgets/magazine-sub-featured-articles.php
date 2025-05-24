<?php
/* 
Widget Name: CofC Theme Magazine Sub-Featured Articles
Description: Display 2 featured magazine articles under the main featured article, pulled from specified categories or tags.
*/

class MagazineSubFeaturedArticlesWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'magazine-sub-featured-articles-widget',
            // Base ID
            'CofC Theme Magazine Sub-Featured Articles',
            // Name,
            array('description' => 'Display 2 featured magazine articles under the main featured article, pulled from specified categories or tags')

        );
    }


    function widget($args, $instance)
    {
        $defaults = array(
            'post_categories' => array(),
            'post_tags' => array(),
            'offset' => 0,
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        extract($args);
        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        // always exclude current post
        global $post;

        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'offset' => $instance['offset'],
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => 2,
                'orderby' => 'date',
                'order' => 'DESC'
            )
        );
        if ($query->have_posts()) {
            $counter = 0;
            while ($query->have_posts()) {
                $query->the_post();
                $counter++;
                display_single_magazine_article_card(post: $post, medium_screen_class: 'medium-6', large_screen_class: '');
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

        $instance['offset'] = isset($new_instance['offset']) ? (int) $new_instance['offset'] : 0;
        $instance['post_categories'] = $post_categories;
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
            'offset' => 0,
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        $categories = get_categories();
        $tags = get_tags();
        // what to display
        ?>

        <p>For this widget, all you need to specify is what filter(s) (can be tags or categories) to use to pull the
            featured articles. A maximum of 3 will be pulled regardless of which filters you specify.
        </p>
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
        <hr />
        <div>
            <h4>Offset</h4>
            <p>If you are using the same category or tag for the main featured article and the sub-featured articles, you can
                set the offset to 1 here so that the sub-feature area doesn't include the main featured article.
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('offset') ?>">Offset</label>
                <input type="number" id="<?php echo $this->get_field_id('offset') ?>" name="<?php echo $this->get_field_name('offset') ?>"
                    value="<?php echo $instance['offset'] ?>">
            </p>
            <?php
    }
}

function register_MagazineSubFeaturedArticlesWidget()
{
    register_widget('MagazineSubFeaturedArticlesWidget');
}
add_action('widgets_init', 'register_MagazineSubFeaturedArticlesWidget');
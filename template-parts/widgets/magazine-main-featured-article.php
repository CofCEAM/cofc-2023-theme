<?php
/* 
Widget Name: CofC Theme Magazine Main Featured Article 
Description: Display 1 (one) full width featured magazine article pulled from specified category or tag
*/

class MagazineMainFeaturedArticleWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'magazine-main-featured-article-widget',
            // Base ID
            'CofC Theme Magazine Main Featured Article',
            // Name,
            array('description' => 'Display 1 (one) full width featured magazine article pulled from specified category or tag')

        );
    }


    function widget($args, $instance)
    {
        $defaults = array(
            'post_categories' => array(),
            'post_tags' => array(),
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
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            )
        );
        if ($query->have_posts()) {
            $counter = 0;
            $query->the_post();
            $counter++;
            if ($counter == 1) {
                display_main_feature_article_card(post: $post);
            }
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

        <p>This widget will display a single full-width featured article. All you need to provide is the tag or category to use
            to pull the article.</p>
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

function register_MagazineMainFeaturedArticleWidget()
{
    register_widget('MagazineMainFeaturedArticleWidget');
}
add_action('widgets_init', 'register_MagazineMainFeaturedArticleWidget');
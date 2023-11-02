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

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        // what to display 
        $display_post_excerpt = $instance['display_post_excerpt'];
        $display_post_published_date = $instance['display_post_published_date'];
        $display_post_author = $instance['display_post_author'];

        $post_not_in_arg = array();

        // always exclude current post
        global $post;

        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => 4
            )
        );
        error_log('widget: query: ' . print_r($query, true));
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
            echo '</div>';
        }
    } //widget

    function update($new_instance, $old_instance)
    {
        error_log('update: new_instance: ' . print_r($new_instance, true));
        $instance = $old_instance;
        $post_categories = array();
        if (isset($new_instance['post_categories']) && is_array($new_instance['post_categories'])) {
            foreach ($new_instance['post_categories'] as $category) {
                $post_categories[] = sanitize_text_field($category);
            }
        }
        error_log('update: post_categories: ' . print_r($post_categories, true));
        $instance['post_categories'] = $post_categories;

        $post_tags = array();
        if (isset($new_instance['post_tags']) && is_array($new_instance['post_tags'])) {
            foreach ($new_instance['post_tags'] as $tag) {
                $post_tags[] = sanitize_text_field($tag);
            }
        }
        error_log('update: post_tags: ' . print_r($post_tags, true));
        $instance['post_tags'] = $post_tags;

        // what to display 
        $instance['display_post_excerpt'] = $new_instance['display_post_excerpt'] == 'yes';
        $instance['display_post_published_date'] = $new_instance['display_post_published_date'] == 'yes';
        $instance['display_post_author'] = $new_instance['display_post_author'] == 'yes';
        // log each of these 
        error_log('update: display_post_excerpt: ' . print_r($instance['display_post_excerpt'], true));
        error_log('update: display_post_published_date: ' . print_r($instance['display_post_published_date'], true));
        error_log('update: display_post_author: ' . print_r($instance['display_post_author'], true));


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

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        // what to display   
        $display_post_excerpt = $this->booltostr($instance['display_post_excerpt']);
        $display_post_published_date = $this->booltostr($instance['display_post_published_date']);
        $display_post_author = $this->booltostr($instance['display_post_author']);


        $categories = get_categories();
        $tags = get_tags();

        // what to display
        echo '
        <div>
        <h3>Display</h3>';

        echo '
        <h4>Show Excerpts</h4>
        <p>
        <label  for="' . $this->get_field_id('display_post_excerpt') . '-yes">Yes</label>
        <input ' . checked($display_post_excerpt, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_excerpt') . '-yes" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        <label for="' . $this->get_field_id('display_post_excerpt') . '-no">No</label>
        <input ' . checked($display_post_excerpt, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_excerpt') . '-no" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        </p>';
        echo '
        <h4>Show Published Date</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_published_date') . '-yes">Yes</label>
        <input ' . checked($display_post_published_date, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_published_date') . '-yes" name="' . $this->get_field_name('display_post_published_date') . '"> 
        <label for="' . $this->get_field_id('display_post_published_date') . '-no">No</label>
        <input ' . checked($display_post_published_date, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_published_date') . '-no" name="' . $this->get_field_name('display_post_published_date') . '"> 
        </p>';

        echo '
        <h4>Show Author</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_author') . '-yes">Yes</label>
        <input ' . checked($display_post_author, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_author') . '-yes" name="' . $this->get_field_name('display_post_author') . '"> 
        <label for="' . $this->get_field_id('display_post_author') . '-no">No</label>
        <input ' . checked($display_post_author, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_author') . '-no" name="' . $this->get_field_name('display_post_author') . '"> 
        </p>';

        echo '</div>';
        // end display 

        echo '<hr/>';


        echo '<div><h3>Filtering</h3>';
        echo '<h4>Limit to Categories</h4>';


        echo '<div style="max-height: 250px; overflow-y: scroll">';
        foreach ($categories as $cat) {
            $checked = in_array($cat->cat_ID, $post_categories) ? 'checked' : '';
            $inputId = $this->get_field_id('post_categories') . '-' . $cat->cat_ID;
            echo '
            <p>
                <input ' .
                $checked . '   
                    type="checkbox" 
                    value="' . $cat->cat_ID . '" 
                    id="' . $inputId . '" 
                    name="' . $this->get_field_name('post_categories') . '[]">
                <label for="' . $inputId . '">' . $cat->name . '</label>
            </p>
            ';
        }
        echo '</div>';
        echo '</div>';
        //end category checkboxes

        echo '<hr/>';

        // tag checkboxes
        echo '
         <div>
             <h4>Limit to Tags</h4>
         ';
        echo '<div style="max-height: 250px; overflow-y: scroll">';
        foreach ($tags as $tag) {
            $inputId = $this->get_field_id('post_tags') . '-' . $tag->term_id;
            $checked = in_array($tag->term_id, $post_tags) ? 'checked' : '';
            echo '
             <p>
                 <input ' . $checked . ' 
                 type="checkbox" value="' . $tag->term_id . '" 
                 id="' . $inputId . '"
                 name="' . $this->get_field_name('post_tags') . '[]">
                 <label for="' . $inputId . '">' . $tag->name . '</label>
             </p>
             ';
        }
        echo "</div>";
        echo '</div>';
    }
}

function register_FeaturedPostsWidget()
{
    register_widget('FeaturedPostsWidget');
}
add_action('widgets_init', 'register_FeaturedPostsWidget');
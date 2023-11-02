<?php
/* Displays a  Specify number of sections to include. Choose category for each section. Choose number of posts to include per section */

class RailNewsSectionWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'rail-news-section-widget',
            // Base ID
            'CofC Theme Rail News Section',
            // Name,
            array('description' => 'Display a section of post cards aligned vertically in the rail (sidebar)')

        );
    }

    function widget($args, $instance)
    {

        $defaults = array(
            'title' => 'Section Title',
            'posts_limit' => 2,
            'post_categories' => array(),
            'post_tags' => array(),
            'display_post_excerpt' => true,
            'display_post_published_date' => true,
            'display_post_author' => true,
        );

        $instance = wp_parse_args((array) $instance, $defaults);


        $instance = wp_parse_args((array) $instance, $defaults);

        $posts_limit = $instance['posts_limit'];

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];

        $post_not_in_arg = array();

        // always exclude current post
        global $post;
        array_push($post_not_in_arg, $post->ID);

        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'post__not_in' => $post_not_in_arg,
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => $posts_limit
            )
        );
        ?>
        <div class="rail-home__section">
            <h2 class="rail-header">
                <?php echo $instance['title'] ?>
            </h2>
            <hr>
            <?php
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    display_single_rail_post_card($post);
                }
            }
            ?>
        </div>
        <?php
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['section_link'] = $new_instance['section_link'];
        $instance['posts_limit'] = intval($new_instance['posts_limit']);

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

        // what to display 
        $instance['display_post_excerpt'] = $new_instance['display_post_excerpt'] == 'yes';
        $instance['display_post_published_date'] = $new_instance['display_post_published_date'] == 'yes';
        $instance['display_post_author'] = $new_instance['display_post_author'] == 'yes';

        return $instance;
    }
    function booltostr(bool $val)
    {
        return $val ? 'yes' : 'no';
    }

    function form($instance)
    {
        $defaults = array(
            'title' => 'Section Title',
            'posts_limit' => 2,
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
        <h4>Title</h4>
        <p>
        <label class="widefat"  for="' . $this->get_field_id('title') . '">Section Title</label>
        <input class="widefat" value="' . $instance['title'] . '" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '"> 
        </p> 
        <p>
        <label class="widefat"  for="' . $this->get_field_id('posts_limit') . '">Max Number of Posts</label>
        <input max="8"  type="number" class="widefat" value="' . $instance['posts_limit'] . '" id="' . $this->get_field_id('posts_limit') . '" name="' . $this->get_field_name('posts_limit') . '"> 
        </p>
        ';

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
        echo '</div>';
        echo '</div>';
    }
}

function register_RailNewsSectionWidget()
{
    register_widget('RailNewsSectionWidget');
}
add_action('widgets_init', 'register_RailNewsSectionWidget');
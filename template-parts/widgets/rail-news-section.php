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
                    display_single_rail_post_card(
                        post: $post,
                        display_excerpt: $instance['display_post_excerpt'],
                        display_published_date: $instance['display_post_published_date'],
                        display_author: $instance['display_post_author']
                    );
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
            'display_post_excerpt' => 'yes',
            'display_post_published_date' => 'yes',
            'display_post_author' => 'yes',
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];

        $display_post_author = $instance['display_post_author'];
        $display_post_published_date = $instance['display_post_published_date'];
        $display_post_excerpt = $instance['display_post_excerpt'];

        $categories = get_categories();
        $tags = get_tags();


        // what to display
        echo '  
        <div>     
        <p>
        <label class="widefat"  for="' . $this->get_field_id('title') . '">Section Title</label>
        <input class="widefat" value="' . $instance['title'] . '" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '"> 
        </p> 
        <p>
        <label class="widefat"  for="' . $this->get_field_id('posts_limit') . '">Max Number of Posts</label>
        <input max="8"  type="number" class="widefat" value="' . $instance['posts_limit'] . '" id="' . $this->get_field_id('posts_limit') . '" name="' . $this->get_field_name('posts_limit') . '"> 
        </p> 
        <h3>Details</h3>
        <h4>Show Excerpts</h4>
        <p>
        <label  for="' . $this->get_field_id('display_post_excerpt') . '-yes">Yes</label>
        <input ' . checked($display_post_excerpt, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_excerpt') . '-yes" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        <label for="' . $this->get_field_id('display_post_excerpt') . '-no">No</label>
        <input ' . checked($display_post_excerpt, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_excerpt') . '-no" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        </p>
        <h4>Show Published Date</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_published_date') . '-yes">Yes</label>
        <input ' . checked($display_post_published_date, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_published_date') . '-yes" name="' . $this->get_field_name('display_post_published_date') . '"> 
        <label for="' . $this->get_field_id('display_post_published_date') . '-no">No</label>
        <input ' . checked($display_post_published_date, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_published_date') . '-no" name="' . $this->get_field_name('display_post_published_date') . '"> 
        </p>
        <h4>Show Author</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_author') . '-yes">Yes</label>
        <input ' . checked($display_post_author, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_author') . '-yes" name="' . $this->get_field_name('display_post_author') . '"> 
        <label for="' . $this->get_field_id('display_post_author') . '-no">No</label>
        <input ' . checked($display_post_author, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_author') . '-no" name="' . $this->get_field_name('display_post_author') . '"> 
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
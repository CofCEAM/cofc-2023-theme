<?php
/* Widget that allows you to feed in a chosen number of recent posts with optional filtering */

class RecentPostsWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'recent-posts-widget',
            // Base ID
            'CofC Theme Recent Posts',
            // Name,
            array('description' => 'Display chosen number of recent posts with optional filtering.')

        );
    }

    function widget($args, $instance)
    {
        extract($args);
        // if title not in instance
        if (!isset($instance['title'])) {
            $instance['title'] = 'Recent Posts';
        }

        $title_url = $instance['title_url']; // clicking the title leads to a page
        $title_link = empty($title_url) ? '
        <h2 class="rail-header">' . $instance["title"] . '</h2>' :
            '<a href="' . $title_url . '"><h2 class="rail-header">' . $instance["title"] . '</h2></a>';

        // limit and offset 
        $posts_limit = $instance['posts_limit'];
        $posts_offset = $instance['posts_offset'];

        // filters
        $ignore_sticky_posts = $instance['ignore_sticky_posts'];
        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];

        // what to display 
        $display_post_excerpt = $instance['display_post_excerpt'];
        $display_post_comment_count = $instance['display_post_comment_count'];
        $display_post_published_date = $instance['display_post_published_date'];
        $display_post_modified_date = $instance['display_post_modified_date'];

        $post_not_in_arg = array();

        if ($ignore_sticky_posts) {
            array_push($post_not_in_arg, get_option('sticky_posts'));
        }

        // always exclude current post
        global $post;
        array_push($post_not_in_arg, $post->ID);

        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'post__not_in' => $post_not_in_arg,
                // if exclude sticky posts and exclude post id 
                'posts_per_page' => $posts_limit,
                'offset' => $posts_offset
            )
        );



        if ($query->have_posts()) {
            echo '
            <div class="rail-home__section">' . $title_link . '<hr/>';
            while ($query->have_posts()) {
                $query->the_post();
                echo ' 
                <div class="rail-news">
                    <div class="rail-news__inner">
                        <p class="rail-news__title font-h6">' . $post->post_title . '</p>
                        <p class="rail-news__copy">' . $post->post_excerpt . '</p>
                        <a href="' . get_permalink($post) . '" 
                            class="btn btn-tertiary btn-tertiary-left">
                            <span class="text">Read More</span>
                            <span class="text-arrow">
                                <svg class="brei-icon brei-icon-arrows" focusable="false">
                                    <use href="#brei-icon-arrows"></use>
                                </svg> 
                                <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                    <use href="#brei-icon-arrows-arrow"></use>
                                </svg>
                            </span>
                        </a> 
                        <!--span class="btn__icon"></span-->
                    </div>
                </div>  
                ';
            }
            echo '</div>';
        }
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['title_url'] = $new_instance['title_url']; // clicking the title leads to a page


        // limit and offset 
        $instance['posts_limit'] = $new_instance['posts_limit'];
        $instance['posts_offset'] = $new_instance['posts_offset'];

        // filters
        $instance['ignore_sticky_posts'] = $new_instance['ignore_sticky_posts'];

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
        $instance['display_post_excerpt'] = $new_instance['display_post_excerpt'];
        $instance['display_post_comment_count'] = $new_instance['display_post_comment_count'];
        $instance['display_post_published_date'] = $new_instance['display_post_published_date'];
        $instance['display_post_modified_date'] = $new_instance['display_post_modified_date'];

        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Recent Posts',
            'title_url' => '',
            'posts_limit' => '3',
            'posts_offset' => '0',
            'ignore_sticky_posts' => 'yes',
            'post_categories' => array(),
            'post_tags' => array(),
            'display_post_excerpt' => 'yes',
            'display_post_comment_count' => 'no',
            'display_post_published_date' => 'yes',
            'display_post_modified_date' => 'no',
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $title = $instance['title'];
        $title_url = $instance['title_url']; // clicking the title leads to a page 


        // filters
        $ignore_sticky_posts = $instance['ignore_sticky_posts'];
        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        // what to display  
        $posts_limit = $instance['posts_limit'];
        $posts_offset = $instance['posts_offset'];
        $display_post_excerpt = $instance['display_post_excerpt'];
        $display_post_comment_count = $instance['display_post_comment_count'];
        $display_post_published_date = $instance['display_post_published_date'];
        $display_post_modified_date = $instance['display_post_modified_date'];


        $categories = get_categories();
        $tags = get_tags();

        // what to display
        echo '
        <div>
        <h3>Display</h3>';

        echo '<p>
        <label><strong>Title</strong></label>
        <input type="text" id="' . $this->get_field_id('title') . '" 
            value="' . $title . '" 
            name="' . $this->get_field_name('title') . '" 
            class="widefat" 
            >
        </p>';

        echo '<p>
        <label><strong>Title URL (if title should link somewhere)</strong></label>
        <input type="url" id="' . $this->get_field_id('title_url') . '" 
            value="' . $title_url . '" 
            name="' . $this->get_field_name('title_url') . '" 
            class="widefat" 
            >
        </p>';

        echo '<p>
        <label><strong>Max Number of Posts to Display (limit)</strong></label>
        <input id="' . $this->get_field_id('posts_limit') . '" value="' . $posts_limit . '" name="' . $this->get_field_name('posts_limit') . '" class="widefat" type="number" min="1" max="5">
        </p>';

        echo '<p>
        <label><strong>Max Number of Posts to Skip (offset)</strong></label>
        <input id="' . $this->get_field_id('posts_offset') . '" value="' . $posts_offset . '" name="' . $this->get_field_name('posts_offset') . '" class="widefat" type="number" min="1" max="5">
        </p>';

        echo '
        <h4>Ignore Sticky Posts</h4>
        <p>
        <label  for="' . $this->get_field_id('ignore_sticky_posts') . '-yes">Yes</label>
        <input ' . checked($ignore_sticky_posts, 'yes', false) . ' 
            type="radio" value="yes" 
            id="' . $this->get_field_id('ignore_sticky_posts') . '-yes" 
            name="' . $this->get_field_name('ignore_sticky_posts') . '"> 
        <label for="' . $this->get_field_id('ignore_sticky_posts') . '-no">No</label>
        <input ' . checked($ignore_sticky_posts, 'no', false) . ' 
            type="radio" value="no" 
            id="' . $this->get_field_id('ignore_sticky_posts') . '-no" 
            name="' . $this->get_field_name('ignore_sticky_posts') . '"> 
        </p>';

        echo '
        <h4>Show Excerpts</h4>
        <p>
        <label  for="' . $this->get_field_id('display_post_excerpt') . '-yes">Yes</label>
        <input ' . checked($display_post_excerpt, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_excerpt') . '-yes" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        <label for="' . $this->get_field_id('display_post_excerpt') . '-no">No</label>
        <input ' . checked($display_post_excerpt, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_excerpt') . '-no" name="' . $this->get_field_name('display_post_excerpt') . '"> 
        </p>';

        echo '
        <h4>Show Comment Counts</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_comment_count') . '-yes">Yes</label>
        <input ' . checked($display_post_comment_count, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_comment_count') . '-yes" name="' . $this->get_field_name('display_post_comment_count') . '"> 
        <label for="' . $this->get_field_id('display_post_comment_count') . '-no">No</label>
        <input ' . checked($display_post_comment_count, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_comment_count') . '-no" name="' . $this->get_field_name('display_post_comment_count') . '"> 
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
        <h4>Show Last Modified Date</h4>
        <p>
        <label for="' . $this->get_field_id('display_post_modified_date') . '-yes">Yes</label>
        <input  ' . checked($display_post_modified_date, 'yes', false) . ' type="radio" value="yes" id="' . $this->get_field_id('display_post_modified_date') . '-yes" name="' . $this->get_field_name('display_post_modified_date') . '"> 
        <label for="' . $this->get_field_id('display_post_modified_date') . '-no">No</label>
        <input ' . checked($display_post_modified_date, 'no', false) . ' type="radio" value="no" id="' . $this->get_field_id('display_post_modified_date') . '-no" name="' . $this->get_field_name('display_post_modified_date') . '"> 
        </p>';

        echo '</div>';
        // end display 

        echo '<hr/>';


        echo '<div><h3>Filtering</h3>';
        echo '<h4>Limit to Categories</h4>';



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
        //end category checkboxes

        echo '<hr/>';

        // tag checkboxes
        echo '
         <div>
             <h4>Limit to Tags</h4>
         ';
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
    }

}

function register_RecentPostsWidget()
{
    register_widget('RecentPostsWidget');
}
add_action('widgets_init', 'register_RecentPostsWidget');
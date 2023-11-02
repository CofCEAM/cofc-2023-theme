<?php
/* Displays a  Specify number of sections to include. Choose category for each section. Choose number of posts to include per section */

class NewsSectionWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'news-section-widget',
            // Base ID
            'CofC Theme News Section',
            // Name,
            array('description' => 'Display a section containing a grid of post cards with optional filters applied')

        );
    }


    function widget($args, $instance)
    {

        extract($args);
        $defaults = array(
            'title' => 'Section Title',
            'columns' => 2,
            'posts_limit' => 4,
            'section_link' => null,
            'post_categories' => array(),
            'post_tags' => array(),
            'display_post_excerpt' => true,
            'display_post_published_date' => true,
            'display_post_author' => true,
        );



        $instance = wp_parse_args((array) $instance, $defaults);

        // map chosen number of columns to class name of individual posts 
        $columns_class_map = array(
            1 => 12,
            2 => 6,
            3 => 4,
            4 => 3
        );
        $columns = $instance['columns'];
        $posts_limit = $instance['posts_limit'];
        $medium_class = 'medium-' . $columns_class_map[$columns];
        $large_class = 'large-' . $columns_class_map[$columns];
        $post_categories = $instance['post_categories'];
        $post_tags = $instance['post_tags'];
        // what to display 
        $display_post_excerpt = $instance['display_post_excerpt'];
        $display_post_published_date = $instance['display_post_published_date'];
        $display_post_author = $instance['display_post_author'];

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
        <section class="news-content news-content--latest news-content--single component">
            <div class="cell xsmall-12 news-content__home">
                <h2 class="font-h2">
                    <?php echo $instance['title'] ?>
                </h2>
                <hr />
            </div>
            <div class="news-content__cards grid-x grid-margin-x grid-margin-y">
                <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        display_single_post_card(
                            post: $post,
                            wide: false,
                            display_excerpt: $display_post_excerpt,
                            display_published_date: $display_post_published_date,
                            display_author: $display_post_author,
                            medium_screen_class: $medium_class,
                            large_screen_class: $large_class,
                            title_heading_size: 'h4'
                        );
                    }
                }
                ?>
            </div>
            <?php
            if ($instance['section_link'] != '' && !ctype_space($instance['section_link'])) {
                ?>
                <div class="button-dotted-line">
                    <a target="_blank" href="<?php echo $instance['section_link'] ?>"
                        title="Read more about the news items in this section" class="btn btn--primary">
                        <span class="text">Read more</span>
                    </a>
                </div>
                <?php
            }
            ?>

        </section>
        <?php
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['section_link'] = $new_instance['section_link'];
        $instance['columns'] = intval($new_instance['columns']);
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
            'section_link' => null,
            'columns' => 3,
            'posts_limit' => 3,
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
        <h4>Layout</h4>
        <p>
        <label class="widefat"  for="' . $this->get_field_id('columns') . '">Number of Columns (between 1 and 4)?</label>
        <input min="1" max="4" type="number" class="widefat" value="' . $instance['columns'] . '" id="' . $this->get_field_id('columns') . '" name="' . $this->get_field_name('columns') . '"> 
        </p>
        <p>
        <label class="widefat"  for="' . $this->get_field_id('posts_limit') . '">Max Number of Posts (best to use multiple of columns e.g. 4 columns, 4 posts or 8 posts)</label>
        <input max="8"  type="number" class="widefat" value="' . $instance['posts_limit'] . '" id="' . $this->get_field_id('posts_limit') . '" name="' . $this->get_field_name('posts_limit') . '"> 
        </p>
         
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
        echo '
        <hr/>
        <h4>Link Section to Read More</h4>
        <p>
        <label class="widefat"  for="' . $this->get_field_id('section_link') . '">Read More URL (If you add a URL here, the widget will include a "Read more" button linking to that URL in a new tab below the section)</label> 
        <input type="url" class="widefat" value="' . $instance['section_link'] . '" id="' . $this->get_field_id('section_link') . '" name="' . $this->get_field_name('section_link') . '"> 
        </p>
        ';
        echo '</div>';
    }
}

function register_NewsSectionWidget()
{
    register_widget('NewsSectionWidget');
}
add_action('widgets_init', 'register_NewsSectionWidget');
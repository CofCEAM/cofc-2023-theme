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
            'section_link_label' => 'Read more',
            'section_link_new_tab' => 'no',
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
        $title = $instance['title'];
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
        $section_link_label = $instance['section_link_label'];
        $section_link = $instance['section_link'];
        $section_link_new_tab = $instance['section_link_new_tab'] == 'yes';
        global $post;
        $query = new WP_Query(
            array(
                'category__in' => $post_categories,
                'tag__in' => $post_tags,
                'posts_per_page' => $posts_limit,
                'orderby' => 'date',
                'order' => 'DESC'
            )
        );
?>
        <section class="news-content news-content--latest news-content--single component">
            <div class="cell xsmall-12 news-content__home">
                <h2 class="font-h2">
                    <?php echo $title ?>
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
                    wp_reset_postdata(); // At the end reset your query
                }
                ?>
            </div>
            <?php
            if (!empty($section_link) && !ctype_space($section_link)) {
            ?>
                <div class="button-dotted-line">
                    <a <?php echo $section_link_new_tab ? 'target="_blank"' : '' ?> href="<?php echo $section_link ?>" title="Read more about the news items in this section" class="btn btn--primary">
                        <span class="text">
                            <?php echo $section_link_label ?>
                        </span>
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

        $instance['title'] = isset($new_instance['title']) ? $new_instance['title'] : '';
        $instance['section_link'] = isset($new_instance['section_link']) ? $new_instance['section_link'] : '';
        $instance['section_link_label'] = isset($new_instance['section_link_label']) ? $new_instance['section_link_label'] : '';
        $instance['section_link_new_tab'] = isset($new_instance['section_link_new_tab']) ? $new_instance['section_link_new_tab'] : '';
        $instance['columns'] = isset($new_instance['columns']) ? intval($new_instance['columns']) : 2;
        $instance['posts_limit'] = isset($new_instance['posts_limit']) ? intval($new_instance['posts_limit']) : 2;
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
            'title' => 'Section Title',
            'section_link' => null,
            'section_link_label' => 'Read more',
            'section_link_new_tab' => 'no',
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


        $section_link_new_tab = $instance['section_link_new_tab'];
        $display_post_excerpt = $this->booltostr($instance['display_post_excerpt']);
        $display_post_published_date = $this->booltostr($instance['display_post_published_date']);
        $display_post_author = $this->booltostr($instance['display_post_author']);




        $categories = get_categories();
        $tags = get_tags();


        // what to display
    ?>
        <div>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('title'); ?>">Section Title</label>
                <input class="widefat" value="<?php echo $instance['title']; ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>">
            </p>
            <h4>Optional Link Below Section</h4>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('section_link'); ?>">Section Link URL (If you add a URL here, the widget will include a button linking to that URL below the section. If empty, no button will display)</label>
                <input type="url" class="widefat" value="<?php echo $instance['section_link']; ?>" id="<?php echo $this->get_field_id('section_link'); ?>" name="<?php echo $this->get_field_name('section_link'); ?>">
            </p>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('section_link_label'); ?>">Section Link Label (the text that displays on the button)</label>
                <input type="text" class="widefat" value="<?php echo $instance['section_link_label']; ?>" id="<?php echo $this->get_field_id('section_link_label'); ?>" name="<?php echo $this->get_field_name('section_link_label'); ?>">
            </p>
            <p>
            <h5>Open Link in New Tab?</h5>
            <label class="widefat" for="<?php echo $this->get_field_id('section_link_new_tab'); ?>-yes">Yes</label>
            <input <?php echo checked($section_link_new_tab, 'yes', true) ?> type="radio" class="widefat" value="yes" id="<?php echo $this->get_field_id('section_link_new_tab'); ?>-yes" name="<?php echo $this->get_field_name('section_link_new_tab'); ?>">
            <label class="widefat" for="<?php echo $this->get_field_id('section_link_new_tab'); ?>-no">No</label>
            <input <?php echo checked($section_link_new_tab, 'no', true) ?> type="radio" class="widefat" value="no" id="<?php echo $this->get_field_id('section_link_new_tab'); ?>-no" name="<?php echo $this->get_field_name('section_link_new_tab'); ?>">
            </p>
            <h4>Layout</h4>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('columns'); ?>">Number of Columns (between 1 and 4)?</label>
                <input min="1" max="4" type="number" class="widefat" value="<?php echo $instance['columns']; ?>" id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
            </p>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('posts_limit'); ?>">Max Number of Posts (best to use multiple of columns e.g. 4 columns, 4 posts or 8 posts)</label>
                <input max="8" type="number" class="widefat" value="<?php echo $instance['posts_limit']; ?>" id="<?php echo $this->get_field_id('posts_limit'); ?>" name="<?php echo $this->get_field_name('posts_limit'); ?>">
            </p>
            <h4>Show Excerpts</h4>
            <p>
                <label for="<?php echo $this->get_field_id('display_post_excerpt'); ?>-yes">Yes</label>
                <input <?php checked($display_post_excerpt, 'yes', true); ?> type="radio" value="yes" id="<?php echo $this->get_field_id('display_post_excerpt'); ?>-yes" name="<?php echo $this->get_field_name('display_post_excerpt'); ?>">
                <label for="<?php echo $this->get_field_id('display_post_excerpt'); ?>-no">No</label>
                <input <?php checked($display_post_excerpt, 'no', true); ?> type="radio" value="no" id="<?php echo $this->get_field_id('display_post_excerpt'); ?>-no" name="<?php echo $this->get_field_name('display_post_excerpt'); ?>">
            </p>
        </div>
        <?php




        ?>
        <h4>Show Published Date</h4>
        <p>
            <label for="<?php echo $this->get_field_id('display_post_published_date'); ?>-yes">Yes</label>
            <input <?php checked($display_post_published_date, 'yes', true); ?> type="radio" value="yes" id="<?php echo $this->get_field_id('display_post_published_date'); ?>-yes" name="<?php echo $this->get_field_name('display_post_published_date'); ?>">
            <label for="<?php echo $this->get_field_id('display_post_published_date'); ?>-no">No</label>
            <input <?php checked($display_post_published_date, 'no', true); ?> type="radio" value="no" id="<?php echo $this->get_field_id('display_post_published_date'); ?>-no" name="<?php echo $this->get_field_name('display_post_published_date'); ?>">
        </p>

        <h4>Show Author</h4>
        <p>
            <label for="<?php echo $this->get_field_id('display_post_author'); ?>-yes">Yes</label>
            <input <?php checked($display_post_author, 'yes', true); ?> type="radio" value="yes" id="<?php echo $this->get_field_id('display_post_author'); ?>-yes" name="<?php echo $this->get_field_name('display_post_author'); ?>">
            <label for="<?php echo $this->get_field_id('display_post_author'); ?>-no">No</label>
            <input <?php checked($display_post_author, 'no', true); ?> type="radio" value="no" id="<?php echo $this->get_field_id('display_post_author'); ?>-no" name="<?php echo $this->get_field_name('display_post_author'); ?>">
        </p>

        </div>
        <hr />

        <div>
            <h3>Filtering</h3>
            <h4>Limit to Categories</h4>
            <?php
            foreach ($categories as $cat) {
                $inputId = $this->get_field_id('post_categories') . '-' . $cat->cat_ID;
            ?>
                <p>
                    <input <?php checked(in_array($cat->cat_ID, $post_categories), true, true) ?> type="checkbox" value="<?php echo $cat->cat_ID; ?>" id="<?php echo $inputId; ?>" name="<?php echo $this->get_field_name('post_categories'); ?>[]">

                    <label for="<?php echo $inputId ?>"><?php echo $cat->name ?></label>
                </p> <?php
                    }
                        ?>
        </div>
        <hr />
        <div>
            <h4>Limit to Tags</h4>
            <?php
            foreach ($tags as $tag) {
                $inputId = $this->get_field_id('post_tags') . '-' . $tag->term_id;
            ?>
                <p>
                    <input <?php echo checked(in_array($tag->term_id, $post_tags), true, true) ?> type="checkbox" value="<?php echo $tag->term_id; ?>" id="<?php echo $inputId; ?>" name="<?php echo $this->get_field_name('post_tags'); ?>[]">
                    <label for="<?php echo $inputId ?>"><?php echo $tag->name ?></label>
                </p>
            <?php
            }
            ?>
        </div>
<?php
    }
}

function register_NewsSectionWidget()
{
    register_widget('NewsSectionWidget');
}
add_action('widgets_init', 'register_NewsSectionWidget');

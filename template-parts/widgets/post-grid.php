<?php

class PostGridWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'post-grid-widget',
            // Base ID
            'CofC Theme Post Grid Widget',
            // Name,
            array('description' => 'Display a grid of posts as cards with optional filtering')
        );
    }

    function widget($args, $instance)
    {
        extract($args);

        $title = isset($instance['title']) ? $instance['title'] : '';
        $limit = isset($instance['limit']) ? $instance['limit'] : 12;
        $offset = isset($instance['offset']) ? $instance['offset'] : 0;
        $category_slug = isset($instance['category_slug']) ? $instance['category_slug'] : '';
        $columns = isset($instance['columns']) ? intval($instance['columns']) : 2; // cast to int 


        $category = get_category_by_slug($category_slug);

        // mapping from num columns to class names
        $medium_screen_classes = array(2 => 'medium-6', 3 => 'medium-4', 4 => 'medium-3');
        $medium_screen_class = $medium_screen_classes[$columns];
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
                display_post_card_grid_by_category(
                    category_name: $category_slug,
                    limit: $limit,
                    offset: $offset,
                    medium_screen_class: $medium_screen_class,
                    large_screen_class: ''
                )
                    ?>
            </div>
            <div class="button-dotted-line">
                <a href="<?php echo get_category_link($category) ?>" class="btn btn--primary">
                    <span class="text">View more
                        <?php echo $category->name ?> posts
                    </span>
                </a>
                <!--span class="btn__icon"></span-->
            </div>
        </section>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['limit'] = $new_instance['limit'];
        $instance['offset'] = $new_instance['offset'];
        $instance['category_slug'] = $new_instance['category_slug'];
        $instance['columns'] = intval($new_instance['columns']);
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => '',
            'limit' => 2,
            'offset' => 0,
            'category_slug' => '',
            'columns' => 2
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $title = $instance['title'];
        $limit = intval($instance['limit']);
        $offset = intval($instance['offset']);
        $columns = intval($instance['columns']);
        $category_slug = $instance['category_slug'];
        ?>
        <div>
            <p>
                <label for="<?php echo $this->get_field_id('title') ?>"><strong>Title</strong></label>
                <input type="text" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $title ?>"
                    name="<?php echo $this->get_field_name('title') ?>" class="widefat">
            </p>
            <hr />
            <p>
                <label for="<?php echo $this->get_field_id('category_slug') ?>"><strong>Category</strong></label>
                <select class="widefat" name="<?php echo $this->get_field_name('category_slug') ?>"
                    id="<?php echo $this->get_field_id('category_slug') ?>">
                    <?php foreach (get_categories() as $category) {
                        $selected = $category_slug == $category->slug ? 'true' : 'false';
                        ?>
                        <option selected="<?php echo $selected ?>" value="<?php echo $category->slug ?>">
                            <?php echo $category->name ?>
                        </option>
                        <?php
                    } ?>
                </select>
            </p>
            <hr />
            <p>
                <label for="<?php echo $this->get_field_id('limit') ?>"><strong>Limit (Max Number of Posts to
                        Include)</strong></label>
                <input type="number" id="<?php echo $this->get_field_id('limit') ?>" value="<?php echo $limit ?>"
                    name="<?php echo $this->get_field_name('limit') ?>" class="widefat">
            </p>
            <hr />
            <p>
                <label for="<?php echo $this->get_field_id('offset') ?>"><strong>Offset (Number of Posts to
                        Skip)</strong></label>
                <input type="number" id="<?php echo $this->get_field_id('offset') ?>" value="<?php echo $offset ?>"
                    name="<?php echo $this->get_field_name('offset') ?>" class="widefat">
            </p>
            <hr />
            <p>
                <label for="<?php echo $this->get_field_id('columns') ?>"><strong>Columns (this is for larger screens; default
                        for mobile is one column)</strong></label>
                <input type="number" id="<?php echo $this->get_field_id('columns') ?>" value="<?php echo $columns ?>"
                    name="<?php echo $this->get_field_name('columns') ?>" class="widefat">
            </p>
            <hr />
        </div>
        <?php

    }

}

function register_PostGridWidget()
{
    register_widget('PostGridWidget');
}
add_action('widgets_init', 'register_PostGridWidget');
<?php
/* 
Widget Name: Tag Grid Widget
Description: Display a paginated 3-column grid of tags. Show a featured image and title for each tag.
*/

class TagGridWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tag-grid-widget',
            // Base ID
            'CofC Theme Tag Grid',
            // Name,
            array('description' => 'Display a paginated 3-column grid of tags, where each one has a featured image and a labeled link. ')

        );
    }


    function widget($args, $instance)
    {
        $defaults = array(
            'title' => 'Tag Grid',
            'post_tags' => array(),
            'post_tags_json' => array()
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        extract($args);
        $post_tags_json = $instance['post_tags_json'];
        $title = $instance['title'];
        display_tag_grid(tags: $post_tags_json, title: $title);
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_tags_json'] = $new_instance['post_tags_json'];
        error_log('new instance: ' . print_r($new_instance, true));

        if (!is_array($instance['post_tags_json'])) {
            $instance['post_tags_json'] = json_decode($instance['post_tags_json']);
        }

        $post_tags = array();
        if (isset($new_instance['post_tags']) && is_array($new_instance['post_tags'])) {
            foreach ($new_instance['post_tags'] as $tag) {
                $post_tags[] = sanitize_text_field($tag);
            }
        }
        $instance['post_tags'] = $post_tags;
        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' => 'Tag Grid',
            'post_tags' => array(),
            'post_tags_json' => array(),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $post_tags = $instance['post_tags'];
        $post_tags_json = $instance['post_tags_json'];
        // encode if not already 
        if (!is_string($post_tags_json)) {
            $post_tags_json = htmlspecialchars(json_encode($post_tags_json));
        }
        /* post_tags is an array that looks like 
        // array(
            array(
                term_id => <tag ID>
                name -> <tag name>
                label -> <user-specified label>
                media_url -> <user-specified image URL>
                media_alt -> <user-specified image alt text, actually controlled by image selected>
            )
        )
        */
        $tags = get_tags();

        // allow user to select and order chosen tags. For each tag, allow user to specify a label, and choose a featured image for the tag. 
        ?>
        <div class="tag-grid-widget-form-container">
            <div>
                <label for="<?php echo $this->get_field_id('title') ?>">Title</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>"
                    name="<?php echo $this->get_field_name('title') ?>" value="<?php echo esc_attr($instance['title']) ?>">
            </div>
            <div>
                <label for="<?php echo $this->get_field_id('post_tags') ?>">Tags</label>
                <select multiple class="widefat" id="<?php echo $this->get_field_id('post_tags') ?>"
                    name="<?php echo $this->get_field_name('post_tags') ?>[]" onchange="tagSelectionChangeHandler(event)">
                    <?php
                    foreach ($tags as $tag) {
                        // if this tag is in the list of selected tags, mark it as selected
                        $selected = in_array($tag->term_id, $post_tags) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $tag->term_id ?>" data-tag-id="<?php echo $tag->term_id ?>"
                            data-tag-label="<?php echo $tag->name ?>" data-tag-slug="<?php echo $tag->slug ?>"
                            data-tag-name="<?php echo $tag->name ?>" data-tag-description="<?php echo $tag->description ?>" <?php echo $selected ?>>
                            <?php echo $tag->name ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <input type="hidden" id="<?php echo $this->get_field_id('post_tags_json') ?>" class="post_tags_json"
                    name="<?php echo $this->get_field_name('post_tags_json') ?>" value="<?php echo $post_tags_json ?>">
            </div>
            <style>
                #selected-tag-details-container {
                    padding: 1rem;
                    text-align: center;
                }

                .tag-specific-field {
                    padding: 1rem;
                    text-align: left;

                    & h4 {
                        margin-bottom: 0.2rem;
                    }

                    & button {
                        margin: 1rem;
                    }

                    & input {
                        padding: 0.5rem;
                    }
                }
            </style>
            <div id="selected-tag-details-container">
                <h3>Provide Details for Selected Tags</h3>
            </div>
        </div>
        <?php

    }
}

function register_TagGridWidget()
{
    register_widget('TagGridWidget');
}
add_action('widgets_init', 'register_TagGridWidget');
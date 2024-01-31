<?php
/* 
Widget Name: Image Link Grid Widget
Description: Display a paginated 3-column grid of images with links. Show a featured image and label for each link.

*/

class ImageLinkGrid extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'image-link-grid-widget',
            // Base ID
            'CofC Theme Image Link Grid Widget',
            // Name,
            array('description' => 'Display a paginated 3-column grid of images with links. Show a featured image and label for each link.')

        );
    }

    function widget($args, $instance)
    {

        $defaults = array(
            'title' => 'Image Link Grid',
            'links' => array(),
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        $links = isset($instance['links']) ? $instance['links'] : array();
        $title = isset($instance['title']) ? $instance['title'] : 'Image Link Grid';



        if (!empty($links)) {
            display_image_link_grid(
                links: $links,
                title: $title
            );
        }

    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $title = isset($new_instance['title']) ? sanitize_text_field($new_instance['title']) : $instance['title'];
        $links = array();
        if (isset($new_instance['links']) && is_array($new_instance['links'])) {
            foreach ($new_instance['links'] as $link) {
                // update each link
                $links[] = array(
                    'label' => sanitize_text_field($link['label']),
                    'url' => esc_url_raw($link['url']),
                    'new_tab' => $this->booltostr($link['new_tab']),
                    'media_url' => esc_url_raw($link['media_url']),
                    'media_alt' => sanitize_text_field($link['media_alt']),
                );
            }
        }
        $instance['title'] = $title;
        $instance['links'] = $links;
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
            'links' => array(),
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        $links = $instance['links'];
        ?>
        <style>
            .image-grid-link>div>label {
                margin-top: 0.5rem;
                margin-bottom: 1rem;
            }

            .image-grid-link>h3 {
                margin-bottom: 0.5rem;
                text-align: center;
            }

            .image-grid-link>div.text-center {
                text-align: center;
            }

            .image-grid-link>div {
                margin: 1rem;
            }

            .image-grid-link textarea,
            .image-grid-link input[type="text"],
            .image-grid-link input[type="url"] {
                font-size: 1rem;
                padding: 0.5rem;
                width: 100%;
            }

            .image-grid-link button.media-upload-button {
                margin-top: 0.75rem;
            }
        </style>
        <div class="rail-link-list-edit-container">
            <label class="widefat" for="<?php echo $this->get_field_id('title') ?>">Section Title</label>
            <input class="widefat" value="<?php echo esc_attr($instance['title']) ?>"
                id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>">

            <div class="btn-container" style="margin: 1rem; text-align: center">
                <button type="button"
                    onclick="addLinkToImageLinkGridList({button: this, linksFieldName: '<?php echo $this->get_field_name('links') ?>' , linksFieldId: '<?php echo $this->get_field_id('links') ?>'})"
                    class="add_link components-button is-primary">Add Link</button>
            </div>
            <?php

            foreach ($links as $index => $link) { ?>
                <div class="image-grid-link">
                    <h3>Link
                        <?php echo $index + 1 ?>
                    </h3>
                    <div>
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][label]">Link Label</label>
                        <input type="text" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][label]"
                            value="<?php echo esc_attr($link['label']); ?>">
                    </div>

                    <div>
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][url]">Link URL</label>
                        <input type="url" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][url]"
                            value="<?php echo esc_attr($link['url']); ?>">
                    </div>

                    <div>
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][new_tab]-yes">New Tab</label>
                        <input type="radio" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][new_tab]"
                            value="yes" <?php echo $link['new_tab'] == 'yes' ? 'checked' : '' ?>
                            id="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][new_tab]-yes">

                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][new_tab]-no">Same Tab</label>
                        <input type="radio" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][new_tab]"
                            value="no" <?php echo $link['new_tab'] == 'yes' ? '' : 'checked' ?>
                            id="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][new_tab]-no">
                    </div>
                    <div>
                        <?php
                        $mediaUrlInputId = $this->get_field_id('links') . '[' . $index . '][media_url]';
                        $mediaAltInputId = $this->get_field_id('links') . '[' . $index . '][media_alt]';
                        ?>
                        <label for="<?php echo $mediaUrlInputId ?>">Image URL</label>
                        <input type="url" id="<?php echo $mediaUrlInputId ?>"
                            name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][media_url]"
                            value="<?php echo esc_attr($link['media_url']); ?>">
                        <input type="hidden" id="<?php echo $mediaAltInputId ?>"
                            name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][media_alt]"
                            value="<?php echo esc_attr($link['media_alt']); ?>">

                        <?php
                        $btnId = $this->get_field_id('links') . '[' . $index . '][media_url]-button';
                        ?>
                        <button id="<?php echo $btnId ?>" class="media-upload-button components-button is-primary"
                            data-media-url-input-id="<?php echo $mediaUrlInputId ?>" type="button"
                            data-media-alt-input-id="<?php echo $mediaAltInputId ?>" onclick="mediaButtonChangeImageHandler(this)">
                            Select Image</button>

                    </div>
                    <div style="text-align:center">
                        <button type="button" onclick="removeLinkFromImageLinkGridList({button: this})"
                            class="remove_link  components-button is-secondary">Remove Link
                            <?php echo $index + 1 ?>
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

function register_ImageLinkGrid()
{
    register_widget('ImageLinkGrid');
}
add_action('widgets_init', 'register_ImageLinkGrid');

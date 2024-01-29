<?php
/* Displays a list of provided links in the rail area where widget is placed (ONLY FOR RAIL AREAS) */

class RailLinkListWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'rail-link-list-widget',
            // Base ID
            'CofC Theme Rail Link List',
            // Name,
            array('description' => 'Display a list of links in the rail (sidebar)')

        );
    }

    function widget($args, $instance)
    {

        $defaults = array(
            'title' => 'Related Links',
            'links' => array(),
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        display_rail_links_list(
            links: $instance['links'],
            title: $instance['title'],
        );
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $title = isset($new_instance['title']) ? sanitize_text_field($new_instance['title']) : $instance['title'];
        $links = array();

        error_log('new instance: ' . print_r($new_instance, true));

        if (isset($new_instance['links']) && is_array($new_instance['links'])) {
            foreach ($new_instance['links'] as $link) {
                // update each link
                $links[] = array(
                    'label' => sanitize_text_field($link['label']),
                    'url' => esc_url_raw($link['url']),
                    'new_tab' => $this->booltostr($link['new_tab']),
                    'display_description' => $this->booltostr($link['display_description']),
                    'description' => sanitize_textarea_field($link['description']),
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
            .rail-link-list-link>div>label {
                margin-right: 1rem;
                margin-top: 0.5rem;
                margin-bottom: 1rem;
            }

            .rail-link-list-link>h3 {
                margin-bottom: 0.5rem;
                text-align: center;
            }

            .rail-link-list-link>div.text-center {
                text-align: center;
            }

            .rail-link-list-link>div {
                margin: 1rem;
            }

            .rail-link-list-link textarea {
                width: 100%;
            }
        </style>
        <div class="rail-link-list-edit-container">
            <label class="widefat" for="<?php echo $this->get_field_id('title') ?>">Section Title</label>
            <input class="widefat" value="<?php echo esc_attr($instance['title']) ?>"
                id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>">
            <?php

            foreach ($links as $index => $link) { ?>
                <div class="rail-link-list-link">
                    <h3>Link
                        <?php echo $index + 1; ?>
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
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][new_tab]">Open Link in New
                            Tab?</label>
                        <input type="radio" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][new_tab]"
                            value="yes" <?php echo $link['new_tab'] == 'yes' ? 'checked' : '' ?>>
                        <input type="radio" name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][new_tab]"
                            value="no" <?php echo $link['new_tab'] == 'yes' ? '' : 'checked' ?>>
                    </div>

                    <div>
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][display_description]">Display
                            Link Description?</label>
                        <input type="radio"
                            name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][display_description]"
                            value="yes" <?php echo $link['display_description'] == 'yes' ? 'checked' : '' ?>>
                        <input type="radio"
                            name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][display_description]"
                            value="no" <?php $link['display_description'] == 'yes' ? '' : 'checked' ?>>
                    </div>

                    <div>
                        <label for="<?php echo $this->get_field_id('links') ?>[<?php echo $index; ?>][description]">Link
                            Description</label>
                        <div>
                            <textarea
                                name="<?php echo $this->get_field_name('links') ?>[<?php echo $index; ?>][description]"><?php echo esc_textarea($link['description']); ?></textarea>
                        </div>
                    </div>
                    <div style="text-align:center">
                        <button type="button" onclick="removeLinkFromRailLinkList({button: this})"
                            class="remove_link  components-button is-secondary">Remove Link
                            <?php echo $index + 1 ?>
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="btn-container" style="margin: 1rem; text-align: center">
                <button type="button"
                    onclick="addLinkToRailLinkList({button: this, linksFieldName: '<?php echo $this->get_field_name('links') ?>'})"
                    class="add_link components-button is-primary">Add Link</button>
            </div>
        </div>
        <?php
    }
}

function register_RailLinkListWidget()
{
    register_widget('RailLinkListWidget');
}
add_action('widgets_init', 'register_RailLinkListWidget');

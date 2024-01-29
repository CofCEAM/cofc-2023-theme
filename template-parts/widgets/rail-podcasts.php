<?php

/* 
Displays podcasts links with icons in the widget
*/


class RailPodcastSectionWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'rail-podcasts-section-widget',
            // Base ID
            'CofC Theme Rail Podcasts Section',
            // Name,
            array('description' => 'Display podcast links in the sidebar (rail)')

        );
    }

    function widget($args, $instance)
    {
        $defaults = array(
            'title' => 'Subscribe on your preferred platform',
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $option_names = array(
            'podcast_platform__spotify',
            'podcast_platform__apple',
            'podcast_platform__stitcher',
            'podcast_platform__google',
            'podcast_platform__iheart',
        );

        // if all options are empty 
        $all_options_empty = true;
        foreach ($option_names as $option_name) {
            if (!empty(get_option($option_name))) {
                $all_options_empty = false;
            }
        }
        if ($all_options_empty) {
            return;
        }
        $title = $instance['title'];
        display_rail_podcast_component($title);
        ?>



        <?php
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Section Title',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <div>
            <p>Podcast Links are Globally Edited in Appearance > Customize > Podcast Platforms. You can adjust the section title
                above those podcast links in the sidebar here.</p>
            <label class="widefat" for="<?php echo $this->get_field_id('title') ?>">Section Title</label>
            <input class="widefat" value="<?php echo esc_attr($instance['title']) ?>"
                id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>">
        </div>
        <?php
    } //form 
}

function register_RailPodcastSectionWidget()
{
    register_widget('RailPodcastSectionWidget');
}
add_action('widgets_init', 'register_RailPodcastSectionWidget');
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
            'section_header_link' => '',
            'section_header_link_label' => 'View all podcast episodes',
            'section_header_link_new_tab' => 'no'
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $option_names = array(
            'podcast_platform__spotify',
            'podcast_platform__apple',
            'podcast_platform__stitcher',
            'podcast_platform__google',
            'podcast_platform__youtube',
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
        $section_header_link = $instance['section_header_link'];
        $section_header_link_label = $instance['section_header_link_label'];
        $section_header_link_new_tab = $instance['section_header_link_new_tab'];
        display_rail_podcast_component(
            title: $title,
            section_header_link: $section_header_link,
            section_header_link_label: $section_header_link_label,
            section_header_link_new_tab: $section_header_link_new_tab
        );
?>



    <?php
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['section_header_link'] = $new_instance['section_header_link'];
        $instance['section_header_link_label'] = $new_instance['section_header_link_label'];
        $instance['section_header_link_new_tab'] = $new_instance['section_header_link_new_tab'];
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Section Title',
            'section_header_link' => '',
            'section_header_link_label' => 'View all podcast episodes',
            'section_header_link_new_tab' => 'no'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $section_header_link = $instance['section_header_link'];
        $section_header_link_label = $instance['section_header_link_label'];
        $section_header_link_new_tab = $instance['section_header_link_new_tab'];
    ?>
        <div>
            <p>Podcast Links are Globally Edited in Appearance > Customize > Podcast Platforms. You can adjust the section title
                above those podcast links in the sidebar here.</p>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('title') ?>">Section Title</label>
                <input class="widefat" value="<?php echo esc_attr($instance['title']) ?>" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>">
            </p>
            <h4>Optional Link Below Section Header</h4>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('section_header_link'); ?>">Link URL (If you add a URL here, the widget will include a link to that URL below the section header. If empty, no link will display)</label>
                <input class="widefat" type="url" value="<?php echo $section_header_link ?>" id="<?php echo $this->get_field_id('section_header_link'); ?>" name="<?php echo $this->get_field_name('section_header_link'); ?>">
            </p>
            <p>
                <label class="widefat" for="<?php echo $this->get_field_id('section_header_link_label'); ?>">Link Label (If you add a URL above, you can customize the label for the link here. If empty, the default label will be "View all podcast episodes")</label>
                <input class="widefat" value="<?php echo $section_header_link_label ?>" id="<?php echo $this->get_field_id('section_header_link_label'); ?>" name="<?php echo $this->get_field_name('section_header_link_label'); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('section_header_link_new_tab'); ?>-yes">Open in new tab</label>
                <input <?php checked($section_header_link_new_tab, 'yes', true); ?> type="radio" value="yes" id="<?php echo $this->get_field_id('section_header_link_new_tab'); ?>-yes" name="<?php echo $this->get_field_name('section_header_link_new_tab'); ?>">
                <label for="<?php echo $this->get_field_id('section_header_link_new_tab'); ?>-no">Open in same tab</label>
                <input <?php checked($section_header_link_new_tab, 'no', true); ?> type="radio" value="no" id="<?php echo $this->get_field_id('section_header_link_new_tab'); ?>-no" name="<?php echo $this->get_field_name('section_header_link_new_tab'); ?>">
            </p>
        </div>
<?php
    } //form 
}

function register_RailPodcastSectionWidget()
{
    register_widget('RailPodcastSectionWidget');
}
add_action('widgets_init', 'register_RailPodcastSectionWidget');

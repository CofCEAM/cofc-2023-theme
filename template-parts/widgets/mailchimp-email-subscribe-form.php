<?php

class MailChimpEmailSubscribeFormWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'email-subscribe-form',
            // Base ID
            'CofC Theme MailChimp Email Subscribe Form',
            // Name,
            array('description' => 'Prompt user to provide email to subscribe to news updates. Copy HTML code from Mailchimp and paste into widget Form HTML field.')

        );
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = $instance['title'];
        $form_html = $instance['form_html'];

        if (empty($title)) {
            $title = 'Keep up with the latest CofC News';
        }
        if (empty($form_html)) {
            $form_html = '';
        }

        echo ' 
        <section class="component">
            ' . $form_html . '
        </section>
        ';
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['form_html'] = $new_instance['form_html'];
        return $instance;
    } //update

    function form($instance)
    {
        $instance = wp_parse_args(
            (array) $instance
        );

        $defaults = array(
            'title' => 'Email Subscribe Form',
            'form_html' => ''
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        $title = $instance['title'];
        $form_html = $instance['form_html'];

        echo '
        <p>
            <label for="' . $this->get_field_id('title') . '">Title:</label>
            <input class="widefat" id="' . $this->get_field_id('title') . '"
                name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
            
            <label for="' . $this->get_field_id('form_html') . '">MailChimp Form HTML (Copied from Mailchimp):</label>
            <textarea rows="30" class="widefat" id="' . $this->get_field_id('form_html') . '"
                name="' . $this->get_field_name('form_html') . '" type="text"
                >' . esc_textarea($form_html) . '</textarea>
        </p> 
        ';
    }

}

function register_MailChimpEmailSubscribeFormWidget()
{
    register_widget('MailChimpEmailSubscribeFormWidget');
}
add_action('widgets_init', 'register_MailChimpEmailSubscribeFormWidget');
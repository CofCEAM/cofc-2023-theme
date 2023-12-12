<?php

/* widget areas / sidebars  */

add_action(
    'widgets_init',
    function () {
        register_sidebar(
            array(
                'name' => 'Featured Posts Area',
                'description' => 'Add CofC Theme Featured Posts to this area. This will show on the homepage if you set your Homepage to display latest posts under Settings > Reading.',
                'id' => 'featured-posts-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );
        register_sidebar(
            array(
                'name' => 'Rail / Primary Sidebar',
                'description' => 'Add CofC Theme Social Media and/or CofC Theme Rail News Sections and/or CofC Theme Rail Podcasts Section Widget to this area. This will show on the homepage if you set your Homepage to display latest posts under Settings > Reading.',
                'id' => 'cofc-primary-sidebar',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );
        register_sidebar(
            array(
                'name' => 'Featured Video Area',
                'description' => 'Add CofC Theme Featured Video to this area. This will show on the homepage if you set your Homepage to display latest posts under Settings > Reading.',
                'id' => 'featured-video-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );
        register_sidebar(
            array(
                'name' => 'Email Subscribe Form Area',
                'description' => 'Add CofC Theme MailChimp Email Subscribe Form to this area. This will show on the homepage if you set your Homepage to display latest posts under Settings > Reading.',
                'id' => 'mailchimp-email-subscribe-form-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );

        register_sidebar(
            array(
                'name' => 'News Sections Area (add one or more CofC Theme News Section widgets)',
                'description' => 'Add one or more CofC Theme News Section widgets to this area. This will show on the homepage if you set your Homepage to display latest posts under Settings > Reading.',
                'id' => 'news-sections-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );

    }
);
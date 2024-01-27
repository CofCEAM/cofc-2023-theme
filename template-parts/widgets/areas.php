<?php

/* widget areas / sidebars  */

add_action(
    'widgets_init',
    function () {

        register_sidebar(
            array(
                'name' => 'Magazine Template - Main Feature Area',
                'description' => 'Add a CofC Theme Magazine Main Featured Article widget to this area to render a full width main featured article at the top of the Magazine template.',
                'id' => 'magazine-main-featured-article-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );

        register_sidebar(
            array(
                'name' => 'Magazine Template - Sub Featured Articles Area',
                'description' => 'Add a CofC Theme Magazine Sub-Featured Articles widget to this area. This area renders at the top of the Magazine template below the main feature.',
                'id' => 'magazine-sub-featured-articles-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );

        register_sidebar(
            array(
                'name' => 'Magazine Template - Current Issue Area',
                'description' => 'Add a CofC Theme Magazine Current Issue widget to this area. This area renders below the featured articles.',
                'id' => 'magazine-current-issue-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );

        register_sidebar(
            array(
                'name' => 'Magazine Template - Latest Issues Area',
                'description' => 'Add a CofC Theme Magazine Latest Issues widget to this area. This area renders below the current issue area.',
                'id' => 'magazine-latest-issues-area',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '',
                'after_title' => '',
            )
        );
        register_sidebar(
            array(
                'name' => 'Home Page Template - Featured Posts Area',
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
                'name' => 'Home Page Template - Rail / Primary Sidebar',
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
                'name' => 'Home Page Template - Featured Video Area',
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
                'name' => 'Home Page Template - Email Subscribe Form Area',
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
                'name' => 'Home Page Template - News Sections Area (add one or more CofC Theme News Section widgets)',
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
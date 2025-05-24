<?php

/* add custom settings / fields to site identity menu */

function create_contact_info_customizer($wp_customize)
{
    // create a new section for contact information
    $wp_customize->add_section(
        'cofctheme_contact_info_section',
        array(
            'title' => __('Contact Info', 'college-of-charleston-2023'),
            'priority' => 30,
        )
    );



    /* Begin Contact Information */
    // Title of division / office / department / unit 
    $wp_customize->add_setting(
        'primary_contact_name',
        array(
            'default' => '',
            'type' => 'option',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field', 
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_name',
            array(
                'label' => __('Primary Contact Name', 'college-of-charleston-2023'),
                'description' => __('What is the name of the primary contact for this site?', 'college-of-charleston-2023'),
                'settings' => 'primary_contact_name',
                'priority' => 10,
                'section' => 'cofctheme_contact_info_section',
                'type' => 'text',
            )
        )
    );

    // Address
    $wp_customize->add_setting(
        'primary_contact_address',
        array(
            'default' => '',
            'type' => 'option',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field', 
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_address',
            array(
                'label' => __('Primary Contact Address', 'college-of-charleston-2023'),
                'description' => __('What is the address of the primary contact for this site?', 'college-of-charleston-2023'),
                'settings' => 'primary_contact_address',
                'priority' => 10,
                'section' => 'cofctheme_contact_info_section',
                'type' => 'text',
            )
        )
    );

    // Title of division / office / department / unit 
    $wp_customize->add_setting(
        'primary_contact_phone',
        array(
            'default' => '',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field', 
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_phone',
            array(
                'label' => __('Primary Contact Phone Number', 'college-of-charleston-2023'),
                'description' => __('What is the phone number of the primary contact for this site?', 'college-of-charleston-2023'),
                'settings' => 'primary_contact_phone',
                'priority' => 10,
                'section' => 'cofctheme_contact_info_section',
                'type' => 'text',
            )
        )
    );

    // Title of division / office / department / unit 
    $wp_customize->add_setting(
        'primary_contact_email',
        array(
            'default' => '',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_email',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_email',
            array(
                'label' => __('Primary Contact Email', 'college-of-charleston-2023'),
                'description' => __('What is the email address of the primary contact for this site?', 'college-of-charleston-2023'),
                'settings' => 'primary_contact_email',
                'priority' => 10,
                'section' => 'cofctheme_contact_info_section',
                'type' => 'email',
            )
        )
    );
}

function create_header_footer_background_color_customizer($wp_customize)
{
    // create a new section 
    $wp_customize->add_section(
        'cofctheme_header_footer_background_color_section',
        array(
            'title' => __('Global Colors', 'college-of-charleston-2023'),
            'priority' => 90,
        )
    );

    $wp_customize->add_setting(
        'header_background_color',
        array(
            'default' => '#79242f',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'header_background_color',
            array(
                'label' => __('Header Background Color', 'college-of-charleston-2023'),
                'description' => __('Specify the background color of the header for this site (default is maroon: #79242f)', 'college-of-charleston-2023'),
                'settings' => 'header_background_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting(
        'footer_background_color',
        array(
            'default' => '#79242f',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_background_color',
            array(
                'label' => __('Footer Background Color', 'college-of-charleston-2023'),
                'description' => __('Specify the background color of the footer for this site (default is maroon: #79242f)', 'college-of-charleston-2023'),
                'settings' => 'footer_background_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );

    // add similar setting for top_nav_text_color 
    $wp_customize->add_setting(
        'top_nav_text_color',
        array(
            'default' => '#ffffff',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'top_nav_text_color',
            array(
                'label' => __('Top Navigation Text Color', 'college-of-charleston-2023'),
                'description' => __('Specify the text color of the top navigation for this site (default is white: #ffffff)', 'college-of-charleston-2023'),
                'settings' => 'top_nav_text_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );

    // similar setting for footer text color 
    $wp_customize->add_setting(
        'footer_text_color',
        array(
            'default' => '#ffffff',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_text_color',
            array(
                'label' => __('Footer Text Color', 'college-of-charleston-2023'),
                'description' => __('Specify the text color of the footer for this site (default is white: #ffffff)', 'college-of-charleston-2023'),
                'settings' => 'footer_text_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );

    // similar setting for footer bar background color 
    $wp_customize->add_setting(
        'footer_bar_background_color',
        array(
            'default' => '#ffffff',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_bar_background_color',
            array(
                'label' => __('Footer Bar Background Color', 'college-of-charleston-2023'),
                'description' => __('Specify the background color of the footer bar for this site (default is white: #ffffff)', 'college-of-charleston-2023'),
                'settings' => 'footer_bar_background_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );

    // similar setting for footer bar text color

    $wp_customize->add_setting(
        'footer_bar_text_color',
        array(
            'default' => '#800000',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_bar_text_color',
            array(
                'label' => __('Footer Bar Text Color', 'college-of-charleston-2023'),
                'description' => __('Specify the text color of the footer bar for this site (default is maroon: #800000)', 'college-of-charleston-2023'),
                'settings' => 'footer_bar_text_color',
                'section' => 'cofctheme_header_footer_background_color_section',
                'type' => 'text',
            )
        )
    );
}
function cofctheme_sanitize_yes_no( $input ) {
    $valid = array( 'yes', 'no' );
    return in_array( $input, $valid, true ) ? $input : 'no';
}


function create_logo_customizer($wp_customize)
{
    // SVG Logo for site branding in top left. 
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default' => '',
            'type' => 'option',
            'transport' => 'postMessage',
            'sanitize_callback' => 'esc_url_raw',

            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );


    // add control to upload or choose a media file for logo 
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'site_logo',
            array(
                'label' => __('Site Logo', 'college-of-charleston-2023'),
                'description' => __('Upload a logo for your site. This will show in the top left corner of the site.', 'college-of-charleston-2023'),
                'section' => 'title_tagline',
                'mime_type' => 'image',
                'priority' => 10,
                'settings' => 'site_logo',
            )
        )
    );


    $wp_customize->add_setting(
        'footer_logo',
        array(
            'default' => '',
            'type' => 'option',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );


    // add control to upload or choose a media file for logo 
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'footer_logo',
            array(
                'label' => __('Footer Logo', 'college-of-charleston-2023'),
                'description' => __('Upload a logo to use in the footer of your site if you want to use something other than your site logo. If empty, the footer will display your main site logo by default.', 'college-of-charleston-2023'),
                'section' => 'title_tagline',
                'mime_type' => 'image',
                'priority' => 10,
                'settings' => 'footer_logo',
            )
        )
    );

    // footer logo link href 
    $wp_customize->add_setting(
        'footer_logo_link',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_logo_link',
            array(
                'label' => __('Footer Logo Link', 'college-of-charleston-2023'),
                'description' => __('Provide a link for the footer logo to point to (optional)', 'college-of-charleston-2023'),
                'settings' => 'footer_logo_link',
                'priority' => 10,
                'section' => 'title_tagline',
                'type' => 'text',
            )
        )
    );

    // new tab or no (radio)
    $wp_customize->add_setting(
        'footer_logo_link_new_tab',
        array(
            'default' => 'yes',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'footer_logo_link_new_tab',
            array(
                'label' => __('Open Footer Logo Link in New Tab?', 'college-of-charleston-2023'),
                'description' => __('Do you want the footer logo link to open in a new tab?', 'college-of-charleston-2023'),
                'settings' => 'footer_logo_link_new_tab',
                'priority' => 10,
                'section' => 'title_tagline',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );
}


function create_search_customizer($wp_customize)
{

    // create a new section for contact information
    $wp_customize->add_section(
        'cofctheme_search_section',
        array(
            'title' => __('Search', 'college-of-charleston-2023'),
            'priority' => 40,
        )
    );
    // configure the search_query_parameter_ke with Radio (searchwp or s)
    $wp_customize->add_setting(
        'search_query_parameter_key',
        array(
            'default' => 's',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );
    // radio control  (searchwp or s)
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'search_query_parameter_key',
            array(
                'label' => __('Search Query Parameter Key', 'college-of-charleston-2023'),
                'description' => __('What is the query parameter key to use for search? Choose searchwp if you are leveraging the SearchWP plugin. (default is "s" for native search, "searchwp" for SearchWP plugin use with custom SearchWP engine)', 'college-of-charleston-2023'),
                'settings' => 'search_query_parameter_key',
                'priority' => 10,
                'section' => 'cofctheme_search_section',
                'type' => 'radio',
                'choices' => array(
                    's' => 's',
                    'searchwp' => 'searchwp'
                )
            )
        )
    );

    // searchwp engine name
    $wp_customize->add_setting(
        'searchwp_engine_name',
        array(
            'default' => 'cofcengine',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'searchwp_engine_name',
            array(
                'label' => __('SearchWP Engine Name', 'college-of-charleston-2023'),
                'description' => __('What is the name of the SearchWP engine to use for search results? This only applies if you are leveraging the SearchWP plugin. (default is "cofcengine")', 'college-of-charleston-2023'),
                'settings' => 'searchwp_engine_name',
                'priority' => 10,
                'section' => 'cofctheme_search_section',
                'type' => 'text',
            )
        )
    );

    // allow addition of multiple site ids to include in search 
    $wp_customize->add_setting(
        'search_site_ids',
        array(
            'default' => 'all',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'search_site_ids',
            array(
                'label' => __('SearchWP Site IDs to Include', 'college-of-charleston-2023'),
                'description' => __('What are the site IDs to include in search (if using SearchWP) ? (comma separated list). Default is "all". Use "all" to include all sites in the network. If including multiple sites, all included sites must have a SearchWP engine with a similar configuration.', 'college-of-charleston-2023'),
                'settings' => 'search_site_ids',
                'priority' => 40,
                'section' => 'cofctheme_search_section',
                'type' => 'text',
            )
        )
    );
}

function create_page_post_display_customizers($wp_customize)
{
    // Add section to the Customizer
    $wp_customize->add_section(
        'cofctheme_page_post_display_section',
        array(
            'title' => __('Page and Post Display Settings', 'college-of-charleston-2023'),
            'priority' => 100,
        )
    );

    // display page byline (radio "yes" or "no)
    $wp_customize->add_setting(
        'display_page_byline',
        array(
            'default' => 'yes',
            'type' => 'option',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_page_byline',
            array(
                'label' => __('Display Page Byline?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the byline (author) on pages?', 'college-of-charleston-2023'),
                'settings' => 'display_page_byline',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );

    // display page date (radio "yes" or "no")
    $wp_customize->add_setting(
        'display_page_date',
        array(
            'default' => 'yes',
            'type' => 'option',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_page_date',
            array(
                'label' => __('Display Page Date?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the date on pages?', 'college-of-charleston-2023'),
                'settings' => 'display_page_date',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );

    // display page excerpt (radio "yes" or "no")   
    $wp_customize->add_setting(
        'display_page_excerpt',
        array(
            'default' => 'yes',
            'type' => 'option',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_page_excerpt',
            array(
                'label' => __('Display Page Excerpt?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the excerpt on pages?', 'college-of-charleston-2023'),
                'settings' => 'display_page_excerpt',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );


    // do the same thing for posts 
    // display post byline (radio "yes" or "no)
    $wp_customize->add_setting(
        'display_post_byline',
        array(
            'default' => 'yes',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );


    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_post_byline',
            array(
                'label' => __('Display Post Byline?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the byline (author) on posts?', 'college-of-charleston-2023'),
                'settings' => 'display_post_byline',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );

    // display post date (radio "yes" or "no")
    $wp_customize->add_setting(
        'display_post_date',
        array(
            'default' => 'yes',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_post_date',
            array(
                'label' => __('Display Post Date?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the date on posts?', 'college-of-charleston-2023'),
                'settings' => 'display_post_date',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );

    // display post excerpt (radio "yes" or "no")
    $wp_customize->add_setting(
        'display_post_excerpt',
        array(
            'default' => 'yes',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'type' => 'option',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_post_excerpt',
            array(
                'label' => __('Display Post Excerpt?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the excerpt on posts?', 'college-of-charleston-2023'),
                'settings' => 'display_post_excerpt',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );

    // display post categories list (radio "yes" or "no")
    $wp_customize->add_setting(
        'display_post_categories_list',
        array(
            'default' => 'yes',
            'type' => 'option',
            'sanitize_callback' => 'cofctheme_sanitize_yes_no',
            'transport' => 'postMessage',
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'display_post_categories_list',
            array(
                'label' => __('Display Post Categories List?', 'college-of-charleston-2023'),
                'description' => __('Do you want to display the list of categories on posts?', 'college-of-charleston-2023'),
                'settings' => 'display_post_categories_list',
                'section' => 'cofctheme_page_post_display_section',
                'type' => 'radio',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            )
        )
    );
}
function create_meta_customizer($wp_customize)
{
    // Add section to the Customizer
    $wp_customize->add_section(
        'cofctheme_meta_section',
        array(
            'title' => __('Homepage Meta', 'college-of-charleston-2023'),
            'priority' => 30,
        )
    );

    // SVG Logo for site branding in top left. 
    $wp_customize->add_setting(
        'meta_description',
        array(
            'default' => '',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    // SVG Logo for site branding in top left. 
    $wp_customize->add_setting(
        'meta_author',
        array(
            'default' => '',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'meta_description',
            array(
                'label' => __('Site Meta Description', 'college-of-charleston-2023'),
                'description' => __('Provide a meta description for your site (this will show in the <meta name="description"...> tag in the header.', 'college-of-charleston-2023'),
                'settings' => 'meta_description',
                'priority' => 10,
                'section' => 'cofctheme_meta_section',
                'type' => 'textarea',
            )
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'meta_author',
            array(
                'label' => __('Site Meta Author', 'college-of-charleston-2023'),
                'description' => __('Provide an author name for your site (this will show in the <meta name="author"...> tag in the header.', 'college-of-charleston-2023'),
                'settings' => 'meta_author',
                'priority' => 10,
                'section' => 'cofctheme_meta_section',
                'type' => 'text',
            )
        )
    );
}

function create_social_media_customizer($wp_customize)
{
    // create a new section for contact information
    $wp_customize->add_section(
        'cofctheme_social_media_section',
        array(
            'title' => __('Social Media', 'college-of-charleston-2023'),
            'priority' => 30,
        )
    );
    $account_types = array(
        array(
            'label' => 'Facebook Account',
            'slug' => 'facebook',
            'example' => 'https://facebook.com/collegeofcharleston'
        ),
        array(
            'label' => 'Twitter Account',
            'slug' => 'twitter',
            'example' => 'https://twitter.com/cofc'
        ),
        array(
            'label' => 'LinkedIn Account',
            'slug' => 'linkedin',
            'example' => 'https://www.linkedin.com/school/college-of-charleston'
        ),
        array(
            'label' => 'YouTube Channel',
            'slug' => 'youtube',
            'example' => 'https://www.youtube.com/user/collegeofcharleston'
        ),
        array(
            'label' => 'Instagram Account',
            'slug' => 'instagram',
            'example' => 'https://www.instagram.com/collegeofcharleston/'
        ),
        array(
            'label' => 'TikTok Account',
            'slug' => 'tiktok',
            'example' => 'https://www.tiktok.com/@collegeofcharleston'
        ),
        array(
            'label' => 'Email Address',
            'slug' => 'email',
            'example' => 'mailto:admissions.cofc.edu'
        ),
        array(
            'label' => 'RSS Feed',
            'slug' => 'rss',
            'example' => get_feed_link()
        )
    );
    foreach ($account_types as $acct_type) {
        $label = $acct_type['label'];
        $slug = $acct_type['slug'];
        $example = $acct_type['example'];
        $wp_customize->add_setting(
            $slug,
            array(
                'default' => $example,
                'type' => 'option',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
                // you can also use 'theme_mod'
                'capability' => 'edit_theme_options'
            ),
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                $slug,
                array(
                    'label' => __($label, 'college-of-charleston-2023'),
                    'description' => __('Optionally provide a link to a relevant ' . $label, 'college-of-charleston-2023'),
                    'settings' => $slug,
                    'priority' => 10,
                    'section' => 'cofctheme_social_media_section',
                    'type' => 'text',
                )
            )
        );
    }
}


function create_podcast_platforms_customizer($wp_customize)
{

    // create a new section for contact information
    $wp_customize->add_section(
        'cofctheme_podcast_platforms_section',
        array(
            'title' => __('Podcast Platforms', 'college-of-charleston-2023'),
            'priority' => 40,
        )
    );
    $podcast_platforms = array(
        array(
            'label' => 'Spotify',
            'slug' => 'podcast_platform__spotify',
            'default' => 'https://open.spotify.com/show/0HECe7feGqv8NV9tBZvOeG?si=ef7a37fa93234f30'
        ),
        array(
            'label' => 'iHeart Radio',
            'slug' => 'podcast_platform__iheart',
            'default' => 'https://www.iheart.com/podcast/269-speaking-of-college-of-cha-89902073/'
        ),
        array(
            'label' => 'Apple Podcasts',
            'slug' => 'podcast_platform__apple',
            'default' => 'https://podcasts.apple.com/us/podcast/speaking-of-college-of-charleston/id1596970737'
        ),
        array(
            'label' => 'Stitcher',
            'slug' => 'podcast_platform__stitcher',
            'default' => 'https://www.stitcher.com/show/speaking-of-college-of-charleston'
        ),
        array(
            'label' => 'Google Podcasts',
            'slug' => 'podcast_platform__google',
            'default' => 'https://podcasts.google.com/feed/aHR0cHM6Ly9mZWVkcy5idXp6c3Byb3V0LmNvbS8xNzQ1MTU5LnJzcw?sa=X&ved=0CBwQ27cFahcKEwio_L62_-z7AhUAAAAAHQAAAAAQTg'
        ),
        array(
            'label' => 'YouTube Podcasts',
            'slug' => 'podcast_platform__youtube',
            'default' => 'https://www.youtube.com/@collegeofcharleston/podcasts'
        )
    );
    foreach ($podcast_platforms as $platform) {
        $label = $platform['label'];
        $slug = $platform['slug'];
        $default = $platform['default'];
        $wp_customize->add_setting(
            $slug,
            array(
                'default' => $default,
                'type' => 'option',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
                // you can also use 'theme_mod'
                'capability' => 'edit_theme_options'
            ),
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                $slug,
                array(
                    'label' => __($label, 'college-of-charleston-2023'),
                    'description' => __('Optionally provide a link to your podcast on ' . $label, 'college-of-charleston-2023'),
                    'settings' => $slug,
                    'priority' => 10,
                    'section' => 'cofctheme_podcast_platforms_section',
                    'type' => 'text',
                )
            )
        );
    }
}




function add_customizer_fields($wp_customize)
{
    create_logo_customizer($wp_customize);
    create_meta_customizer($wp_customize);
    create_contact_info_customizer($wp_customize);
    create_social_media_customizer($wp_customize);
    create_podcast_platforms_customizer($wp_customize);
    create_header_footer_background_color_customizer($wp_customize);
    create_page_post_display_customizers($wp_customize);
    create_search_customizer($wp_customize);
}
add_action('customize_register', 'add_customizer_fields');


/**
 * Used by hook: 'customize_preview_init'
 * 
 * @see add_action('customize_preview_init',$func)
 */
function cofctheme_customizer_live_preview()
{
    wp_enqueue_script(
        'cofctheme-customizer',
        //Give the script an ID
        get_template_directory_uri() . '/assets/js/customizer.js',
        //Point to file
        array('jquery', 'customize-preview'),
        false,
        true
    );
}
add_action('customize_preview_init', 'cofctheme_customizer_live_preview');

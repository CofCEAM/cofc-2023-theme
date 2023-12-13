<?php

/* add custom settings / fields to site identity menu */

function create_contact_info_customizer($wp_customize)
{
    // create a new section for contact information
    $wp_customize->add_section(
        'cofctheme_contact_info_section',
        array(
            'title' => __('Contact Info', 'cofctheme'),
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
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_name',
            array(
                'label' => __('Primary Contact Name', 'cofctheme'),
                'description' => __('What is the name of the primary contact for this site?', 'cofctheme'),
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
            // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'primary_contact_address',
            array(
                'label' => __('Primary Contact Address', 'cofctheme'),
                'description' => __('What is the address of the primary contact for this site?', 'cofctheme'),
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
                'label' => __('Primary Contact Phone Number', 'cofctheme'),
                'description' => __('What is the phone number of the primary contact for this site?', 'cofctheme'),
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
                'label' => __('Primary Contact Email', 'cofctheme'),
                'description' => __('What is the email address of the primary contact for this site?', 'cofctheme'),
                'settings' => 'primary_contact_email',
                'priority' => 10,
                'section' => 'cofctheme_contact_info_section',
                'type' => 'email',
            )
        )
    );
}

function create_logo_svg_customizer($wp_customize)
{
    // SVG Logo for site branding in top left. 
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default' => '',
            'type' => 'option',
            'transport' => 'postMessage',
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
                'label' => __('Site Logo', 'cofctheme'),
                'description' => __('Upload a logo for your site. This will show in the top left corner of the site.', 'cofctheme'),
                'section' => 'title_tagline',
                'mime_type' => 'image',
                'priority' => 10,
                'settings' => 'site_logo',
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
            'title' => __('Homepage Meta', 'cofctheme'),
            'priority' => 30,
        )
    );

    // SVG Logo for site branding in top left. 
    $wp_customize->add_setting(
        'meta_description',
        array(
            'default' => '',
            'type' => 'option',
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
                'label' => __('Site Meta Description', 'cofctheme'),
                'description' => __('Provide a meta description for your site (this will show in the <meta name="description"...> tag in the header.', 'cofctheme'),
                'settings' => 'meta_description',
                'priority' => 10,
                'section' => 'title_tagline',
                'type' => 'textarea',
            )
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'meta_author',
            array(
                'label' => __('Site Meta Author', 'cofctheme'),
                'description' => __('Provide an author name for your site (this will show in the <meta name="author"...> tag in the header.', 'cofctheme'),
                'settings' => 'meta_author',
                'priority' => 10,
                'section' => 'title_tagline',
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
            'title' => __('Social Media', 'cofctheme'),
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
                // you can also use 'theme_mod'
                'capability' => 'edit_theme_options'
            ),
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                $slug,
                array(
                    'label' => __($label, 'cofctheme'),
                    'description' => __('Optionally provide a link to a relevant ' . $label, 'cofctheme'),
                    'settings' => $slug,
                    'priority' => 10,
                    'section' => 'cofctheme_social_media_section',
                    'type' => 'text',
                )
            )
        );
    }

}

function add_customizer_fields($wp_customize)
{
    create_logo_svg_customizer($wp_customize);
    create_meta_customizer($wp_customize);
    create_contact_info_customizer($wp_customize);
    create_social_media_customizer($wp_customize);
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
        //Define dependencies
        '',
        //Define a version (optional) 
        true //Put script in footer?
    );
}
add_action('customize_preview_init', 'cofctheme_customizer_live_preview');
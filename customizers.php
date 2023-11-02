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
                'label' => __('Primary Contact Name', 'textdomain'),
                'description' => __('What is the name of the primary contact for this site?', 'textdomain'),
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
                'label' => __('Primary Contact Address', 'textdomain'),
                'description' => __('What is the address of the primary contact for this site?', 'textdomain'),
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
                'label' => __('Primary Contact Phone Number', 'textdomain'),
                'description' => __('What is the phone number of the primary contact for this site?', 'textdomain'),
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
                'label' => __('Primary Contact Email', 'textdomain'),
                'description' => __('What is the email address of the primary contact for this site?', 'textdomain'),
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
        'site_logo_svg',
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
            'site_logo_svg',
            array(
                'label' => __('Site Logo SVG Code', 'textdomain'),
                'description' => __('Paste in your site logo as SVG code. You can convert your site logo image to SVG format using a tool like this: https://convertio.co/png-svg/. This will display in the top left of your site next to the main navigation. ', 'textdomain'),
                'settings' => 'site_logo_svg',
                'priority' => 10,
                'section' => 'title_tagline',
                'type' => 'textarea',
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
                'label' => __('Site Meta Description', 'textdomain'),
                'description' => __('Provide a meta description for your site (this will show in the <meta name="description"...> tag in the header.', 'textdomain'),
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
                'label' => __('Site Meta Author', 'textdomain'),
                'description' => __('Provide an author name for your site (this will show in the <meta name="author"...> tag in the header.', 'textdomain'),
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
                    'label' => __($label, 'textdomain'),
                    'description' => __('Optionally provide a link to a relevant ' . $label, 'textdomain'),
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
<?php
class SocialMediaWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'social-media-widget',
            // Base ID
            'CofC Theme Social Media',
            // Name,
            array('description' => 'Display social media icons linking to social media accounts')
        );
    }

    function widget($args, $instance)
    {
        extract($args);
        $defaults = array(
            'facebook' => 'https://facebook.com/collegeofcharleston',
            'twitter' => 'https://twitter.com/cofc',
            'linkedin' => 'https://www.linkedin.com/school/college-of-charleston',
            'youtube' => 'https://www.youtube.com/user/collegeofcharleston',
            'instagram' => 'https://www.instagram.com/collegeofcharleston/',
            'email' => 'mailto:admissions.cofc.edu',
            'rss' => ''

        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $title = $instance['title'];

        $accounts = array(
            array(
                'label' => 'Facebook URL',
                'slug' => 'facebook',
                'link' => $instance['facebook'],
                'icon' => 'brei-icon-social-facebook',
                'example' => 'https://facebook.com/collegeofcharleston'
            ),
            array(
                'label' => 'Twitter URL',
                'slug' => 'twitter',
                'link' => $instance['twitter'],
                'icon' => 'brei-icon-social-twitter',
                'example' => 'https://twitter.com/cofc'
            ),
            array(
                'label' => 'LinkedIn URL',
                'slug' => 'linkedin',
                'link' => $instance['linkedin'],
                'icon' => 'brei-icon-social-linkedin',
                'example' => 'https://www.linkedin.com/school/college-of-charleston'
            ),
            array(
                'label' => 'YouTube URL',
                'slug' => 'youtube',
                'link' => $instance['youtube'],
                'icon' => 'brei-icon-social-youtube',
                'example' => 'https://www.youtube.com/user/collegeofcharleston'
            ),
            array(
                'label' => 'Instagram URL',
                'slug' => 'instagram',
                'link' => $instance['instagram'],
                'icon' => 'brei-icon-social-instagram',
                'example' => 'https://www.instagram.com/collegeofcharleston/'
            ),
            array(
                'label' => 'Email Address',
                'slug' => 'email',
                'link' => $instance['email'],
                'icon' => 'brei-icon-email',
                'example' => 'mailto:admissions.cofc.edu'
            ),
            array(
                'label' => 'RSS URL',
                'slug' => 'rss',
                'link' => $instance['rss'],
                'icon' => 'brei-icon-social-rss',
                'example' => 'https://today.cofc.edu/feed/'
            )
        );


        if (atLeastOneAccountLinkPopulated($accounts)) {
            echo '
            <div class="rail-home__social">
                <div class="rail-social">
                    <div class="rail-social__content">
                        <div class="rai-social__inner">
                            <p class="rail-header">' . $title . '</p>
                            <div class="social-links">
                                <ul class="social-links__list">';
            foreach ($accounts as $account) {
                // check if the option from the Social Media customizer is populated
                $slug = $account['slug'];
                $label = $account['label'];
                $icon = $account['icon'];
                $accountLink = get_option($slug);
                $class = empty($accountLink) ? "social-links__item is-hidden" : "social-links__item";
                if ($slug == 'email') {
                    $accountLink = 'mailto:' . $accountLink;
                }
                ?>
                <li id="social-media-widget-link-<?php echo $slug ?>" class="<?php echo $class ?>">
                    <a href="<?php echo $accountLink ?>" class="social-links__link" aria-label="<?php echo $label ?>" target="_blank">
                        <svg class="brei-icon <?php echo $icon ?>" focusable="false">
                            <use href="#<?php echo $icon ?>"></use>
                        </svg>
                    </a>
                </li>
                <?php

            } ?>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </div>
<?php
        }



    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Get Social'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = $instance['title'];
        echo '<div>';
        echo '<p>
        <label><strong>Title</strong></label>
        <input type="text" id="' . $this->get_field_id('title') . '" 
            value="' . $title . '" 
            name="' . $this->get_field_name('title') . '" 
            class="widefat" 
            >
        </p>';
        echo '<hr/>';
        echo '<p>All social media links for this widget are pulled from Appearance > Customize > Social Media. ';
        echo 'You need to modify those values and click Publish in order to see the Social Media Widget.</p>';
        echo '</div>';

    }

}

function register_SocialMediaWidget()
{
    register_widget('SocialMediaWidget');
}
add_action('widgets_init', 'register_SocialMediaWidget');
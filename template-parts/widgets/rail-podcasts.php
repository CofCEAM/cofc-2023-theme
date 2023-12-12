<?php
/* 
Displays podcasts links with icons in the widget
*/


$SPOTIFY_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-spotify.svg';
$IHEART_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-iheart-radio.svg';
$APPLE_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-apple.svg';
$STITCHER_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-stitcher.svg';
$GOOGLE_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-google.svg';


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
        global $APPLE_PODCAST_ICON;
        global $SPOTIFY_PODCAST_ICON;
        global $STITCHER_PODCAST_ICON;
        global $GOOGLE_PODCAST_ICON;
        global $IHEART_PODCAST_ICON;

        $defaults = array(
            'title' => 'Subscribe on your preferred platform',
            'apple_podcast_link' => '',
            'spotify_podcast_link' => '',
            'stitcher_podcast_link' => '',
            'google_podcast_link' => '',
            'iheart_podcast_link' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        // only display if at least one of the links is provided 
        if (empty($instance['apple_podcast_link']) && empty($instance['spotify_podcast_link']) && empty($instance['stitcher_podcast_link']) && empty($instance['google_podcast_link']) && empty($instance['iheart_podcast_link'])) {
            return;
        }
        ?>




        <div class="rail-podcast">
            <div class="rail-podcast__content">
                <h2 class="font-h5">
                    <?php echo esc_attr($instance['title']) ?>
                </h2>
                <hr>
                <ul class="rail-podcast__list">
                    <?php
                    if ($instance['apple_podcast_link'] != '') {
                        ?>
                        <li class="rail-podcast__item">
                            <a href="<?php echo esc_attr($instance['apple_podcast_link']) ?>" class="rail-podcast__link"
                                aria-label="" target="_blank">
                                <img src="<?php echo $APPLE_PODCAST_ICON ?>" alt="Apple Podcast" width="25" height="25"
                                    aria-hidden="true">
                                <div class="rail-podcast__text">
                                    Listen on<br><span>Apple Podcasts</span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($instance['spotify_podcast_link'] != '') {
                        ?>
                        <li class="rail-podcast__item">
                            <a href="<?php echo esc_attr($instance['spotify_podcast_link']) ?>" class="rail-podcast__link"
                                aria-label="" target="_blank">
                                <img src="<?php echo $SPOTIFY_PODCAST_ICON ?>" alt="Spotify" width="25" height="25"
                                    aria-hidden="true">
                                <div class="rail-podcast__text">
                                    Listen on<br><span>Spotify</span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($instance['stitcher_podcast_link'] != '') {
                        ?>
                        <li class="rail-podcast__item">
                            <a href="<?php echo esc_attr($instance['stitcher_podcast_link']) ?>" class="rail-podcast__link"
                                aria-label="" target="_blank">
                                <img src="<?php echo $STITCHER_PODCAST_ICON ?>" alt="Stitcher" width="25" height="25"
                                    aria-hidden="true">
                                <div class="rail-podcast__text">
                                    Listen on<br><span>Stitcher</span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($instance['google_podcast_link'] != '') {
                        ?>
                        <li class="rail-podcast__item">
                            <a href="<?php echo esc_attr($instance['google_podcast_link']) ?>" class="rail-podcast__link"
                                aria-label="" target="_blank">
                                <img src="<?php echo $GOOGLE_PODCAST_ICON ?>" alt="Google Podcasts" width="25" height="25"
                                    aria-hidden="true">
                                <div class="rail-podcast__text">
                                    Listen on<br><span>Google Podcasts</span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($instance['iheart_podcast_link'] != '') {
                        ?>
                        <li class="rail-podcast__item">
                            <a href="<?php echo esc_attr($instance['iheart_podcast_link']) ?>" class="rail-podcast__link"
                                aria-label="" target="_blank">
                                <img src="<?php echo $IHEART_PODCAST_ICON ?>" alt="iHeart Radio" width="25" height="25"
                                    aria-hidden="true">
                                <div class="rail-podcast__text">
                                    Listen on<br><span>iHeartRadio</span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['apple_podcast_link'] = $new_instance['apple_podcast_link'];
        $instance['spotify_podcast_link'] = $new_instance['spotify_podcast_link'];
        $instance['stitcher_podcast_link'] = $new_instance['stitcher_podcast_link'];
        $instance['google_podcast_link'] = $new_instance['google_podcast_link'];
        $instance['iheart_podcast_link'] = $new_instance['iheart_podcast_link'];
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Section Title',
            'apple_podcast_link' => '',
            'spotify_podcast_link' => '',
            'stitcher_podcast_link' => '',
            'google_podcast_link' => '',
            'iheart_podcast_link' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <div>
            <h3>Title</h3>
            <label class="widefat" for="<?php echo $this->get_field_id('title') ?>">Section Title</label>
            <input class="widefat" value="<?php echo esc_attr($instance['title']) ?>"
                id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>">
            <hr />
            <h3>Podcast Links</h3>
            <label class="widefat" for="<?php echo $this->get_field_id('apple_podcast_link') ?>">Apple Podcast Link</label>
            <input class="widefat" value="<?php echo esc_attr($instance['apple_podcast_link']) ?>"
                id="<?php echo $this->get_field_id('apple_podcast_link') ?>"
                name="<?php echo $this->get_field_name('apple_podcast_link') ?>">
            <label class="widefat" for="<?php echo $this->get_field_id('spotify_podcast_link') ?>">Spotify Podcast Link</label>
            <input class="widefat" value="<?php esc_attr($instance['spotify_podcast_link']) ?>"
                id="<?php echo $this->get_field_id('spotify_podcast_link') ?>"
                name="<?php echo $this->get_field_name('spotify_podcast_link') ?>">
            <label class="widefat" for="<?php echo $this->get_field_id('stitcher_podcast_link') ?>">Stitcher Podcast
                Link</label>
            <input class="widefat" value="<?php echo esc_attr($instance['stitcher_podcast_link']) ?>"
                id="<?php echo $this->get_field_id('stitcher_podcast_link') ?>"
                name="<?php echo $this->get_field_name('stitcher_podcast_link') ?>">
            <label class="widefat" for="<?php echo $this->get_field_id('google_podcast_link') ?>">Google Podcast Link</label>
            <input class="widefat" value="<?php echo esc_attr($instance['google_podcast_link']) ?>"
                id="<?php echo $this->get_field_id('google_podcast_link') ?>"
                name="<?php echo $this->get_field_name('google_podcast_link') ?>">
            <label class="widefat" for="<?php echo $this->get_field_id('iheart_podcast_link') ?>">iHeart Podcast Link</label>
            <input class="widefat" value="<?php echo esc_attr($instance['iheart_podcast_link']) ?>"
                id="<?php echo $this->get_field_id('iheart_podcast_link') ?>"
                name="<?php echo $this->get_field_name('iheart_podcast_link') ?>">

        </div>
        <?php
    } //form 
}

function register_RailPodcastSectionWidget()
{
    register_widget('RailPodcastSectionWidget');
}
add_action('widgets_init', 'register_RailPodcastSectionWidget');
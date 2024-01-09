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
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $platform_options = array(
            'spotify' => get_option('podcast_platform__spotify'),
            'apple' => get_option('podcast_platform__apple'),
            'stitcher' => get_option('podcast_platform__stitcher'),
            'google' => get_option('podcast_platform__google'),
            'iheart' => get_option('podcast_platform__iheart'),
        );

        // return if all are empty 
        if (empty($platform_options['spotify']) && empty($platform_options['apple']) && empty($platform_options['stitcher']) && empty($platform_options['google']) && empty($platform_options['iheart'])) {
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
                    <li class="rail-podcast__item podcast_platform__apple" <?php if ($platform_options['apple'] == '') {
                        echo 'style="display:none';
                    } ?>>
                        <a href="<?php echo esc_attr($instance['apple_podcast_link']) ?>" class="rail-podcast__link"
                            aria-label="" target="_blank">
                            <img src="<?php echo $APPLE_PODCAST_ICON ?>" alt="Apple Podcast" width="25" height="25"
                                aria-hidden="true">
                            <div class="rail-podcast__text">
                                Listen on<br><span>Apple Podcasts</span>
                            </div>
                        </a>
                    </li>
                    <li class="rail-podcast__item podcast_platform__spotify" <?php if ($platform_options['spotify'] == '') {
                        echo 'style="display:none';
                    } ?>>
                        <a href="<?php echo esc_attr($instance['spotify_podcast_link']) ?>" class="rail-podcast__link"
                            aria-label="" target="_blank">
                            <img src="<?php echo $SPOTIFY_PODCAST_ICON ?>" alt="Spotify" width="25" height="25"
                                aria-hidden="true">
                            <div class="rail-podcast__text">
                                Listen on<br><span>Spotify</span>
                            </div>
                        </a>
                    </li>
                    <li class="rail-podcast__item podcast_platform__stitcher" <?php if ($platform_options['stitcher'] == '') {
                        echo 'style="display:none';
                    } ?>>
                        <a href="<?php echo esc_attr($instance['stitcher_podcast_link']) ?>" class="rail-podcast__link"
                            aria-label="" target="_blank">
                            <img src="<?php echo $STITCHER_PODCAST_ICON ?>" alt="Stitcher" width="25" height="25"
                                aria-hidden="true">
                            <div class="rail-podcast__text">
                                Listen on<br><span>Stitcher</span>
                            </div>
                        </a>
                    </li>
                    <li class="rail-podcast__item podcast_platform__google" <?php if ($platform_options['google'] == '') {
                        echo 'style="display:none';
                    } ?>>
                        <a href="<?php echo esc_attr($instance['google_podcast_link']) ?>" class="rail-podcast__link"
                            aria-label="" target="_blank">
                            <img src="<?php echo $GOOGLE_PODCAST_ICON ?>" alt="Google Podcasts" width="25" height="25"
                                aria-hidden="true">
                            <div class="rail-podcast__text">
                                Listen on<br><span>Google Podcasts</span>
                            </div>
                        </a>
                    </li>
                    <li class="rail-podcast__item podcast_platform__iheart" <?php if ($platform_options['iheart'] == '') {
                        echo 'style="display:none';
                    } ?>>
                        <a href="<?php echo esc_attr($instance['iheart_podcast_link']) ?>" class="rail-podcast__link"
                            aria-label="" target="_blank">
                            <img src="<?php echo $IHEART_PODCAST_ICON ?>" alt="iHeart Radio" width="25" height="25"
                                aria-hidden="true">
                            <div class="rail-podcast__text">
                                Listen on<br><span>iHeartRadio</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
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
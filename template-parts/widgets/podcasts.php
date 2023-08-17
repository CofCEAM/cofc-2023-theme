<?php

class PodcastsWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'podcasts-widget',
            // Base ID
            'CofC Theme Podcasts Widget',
            // Name,
            array('description' => 'Display a list of branded podcast links')
        );
    }

    function widget($args, $instance)
    {
        extract($args);

        $title = $instance['title'];

        $platforms = array(
            array('slug' => 'spotify', 'label' => 'Spotify', 'icon' => get_template_directory_uri() . '/assets/images/icon-spotify.svg'),
            array('slug' => 'iheartradio', 'label' => 'iHeartRadio', 'icon' => get_template_directory_uri() . '/assets/images/icon-iheart-radio.svg'),
            array('slug' => 'apple', 'label' => 'Apple Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-apple.svg'),
            array('slug' => 'stitcher', 'label' => 'Stitcher', 'icon' => get_template_directory_uri() . '/assets/images/icon-stitcher.svg'),
            array('slug' => 'google', 'label' => 'Google Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-google.svg')
        );
        function atLeastOnePodcastPopulated($instance, $platforms)
        {
            foreach ($platforms as $pf) {
                $link = $instance[$pf['slug']];
                if (!empty($link)) {
                    return true;
                }
            }
            return false; // all empty 
        }
        if (atLeastOnePodcastPopulated($instance, $platforms)) {
            // show the component if at least one podcast link was populated, else show nothing
            ?>
            <div class="rail-podcast">
                <div class="rail-podcast__content">
                    <h2 class="font-h5">
                        <?php echo $title ?>
                    </h2>
                    <hr>
                    <ul class="rail-podcast__list">
                        <?php foreach ($platforms as $platform) {
                            if (!empty($instance[$platform['slug']])) {
                                ?>
                                <li class="rail-podcast__item">
                                    <a href="#" class="rail-podcast__link" aria-label="" target="_blank">
                                        <img src="<?php echo $platform['icon'] ?>" alt="<?php echo $platform['label'] ?>" width="25"
                                            height="25" aria-hidden="true">
                                        <div class="rail-podcast__text">
                                            Listen on<br><span>
                                                <?php echo $platform['label'] ?>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <?php
        }


    }

    function update($new_instance, $old_instance)
    {
        $platforms = array(
            array('slug' => 'spotify', 'label' => 'Spotify', 'icon' => get_template_directory_uri() . '/assets/images/icon-spotify.svg'),
            array('slug' => 'iheartradio', 'label' => 'iHeartRadio', 'icon' => get_template_directory_uri() . '/assets/images/icon-iheart-radio.svg'),
            array('slug' => 'apple', 'label' => 'Apple Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-apple.svg'),
            array('slug' => 'stitcher', 'label' => 'Stitcher', 'icon' => get_template_directory_uri() . '/assets/images/icon-stitcher.svg'),
            array('slug' => 'google', 'label' => 'Google Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-google.svg')
        );
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        foreach ($platforms as $pf) {
            $instance[$pf['slug']] = $new_instance[$pf['slug']];
        }
        return $instance;
    } //update

    function form($instance)
    {
        $defaults = array(
            'title' => 'Subscribe On Your Preferred Platform'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $platforms = array(
            array('slug' => 'spotify', 'label' => 'Spotify', 'icon' => get_template_directory_uri() . '/assets/images/icon-spotify.svg'),
            array('slug' => 'iheartradio', 'label' => 'iHeartRadio', 'icon' => get_template_directory_uri() . '/assets/images/icon-iheart-radio.svg'),
            array('slug' => 'apple', 'label' => 'Apple Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-apple.svg'),
            array('slug' => 'stitcher', 'label' => 'Stitcher', 'icon' => get_template_directory_uri() . '/assets/images/icon-stitcher.svg'),
            array('slug' => 'google', 'label' => 'Google Podcasts', 'icon' => get_template_directory_uri() . '/assets/images/icon-google.svg')
        );
        $title = $instance['title'];
        ?>
        <div>
            <p>
                <label for="<?php echo $this->get_field_id('title') ?>"><strong>Title</strong></label>
                <input type="text" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $title ?>"
                    name="<?php echo $this->get_field_name('title') ?>" class="widefat">
            </p>
            <hr />
            <p><label><strong>Podcast Platforms</strong></label></p>
            <?php foreach ($platforms as $platform) {
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id($platform['slug']) ?>"><?php echo $platform['label'] ?></label>
                    <input type="text" id="<?php echo $this->get_field_id('title') ?>"
                        value="<?php echo $instance[$platform['slug']] ?>"
                        name="<?php echo $this->get_field_name($platform['slug']) ?>" class="widefat">
                </p>
                <?php
            } ?>
        </div>
        <?php

    }

}

function register_PodcastsWidget()
{
    register_widget('PodcastsWidget');
}
add_action('widgets_init', 'register_PodcastsWidget');
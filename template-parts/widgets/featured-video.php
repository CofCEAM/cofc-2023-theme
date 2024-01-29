<?php



// Featured Video Widget
class FeaturedVideoWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'featured-video',
            // Base ID
            'CofC Theme Featured Video',
            // Name,
            array('description' => 'Display featured video from youtube or vimeo or keek.', 'customize_selective_refresh' => true)

        );

    }

    function widget($args, $instance)
    {
        extract($args);
        $title = $instance['title'];
        $video = $instance['videolink'];
        $height = $instance['height'];
        $description = $instance['description'];

        if (empty($height)) {
            $height = '220';
        }

        ?>
        <?php
        if (!empty($video) && !empty($title) && !empty($description)) {
            ?>
            <div class="row component">
                <div class="xsmall-12 column">
                    <section class="media  media--video media--wide component js-has-carousel">
                        <div class="media__container">
                            <div class="media__header">
                                <h2 class="media__title font-h2">
                                    <?php echo $title ?>
                                </h2>
                                <div class="hr-wrapper">
                                    <hr>
                                </div>
                            </div>
                            <div class="media__wrapper">
                                <div id="media_items" class="media__items slick-initialized slick-slider" role="region"
                                    aria-label="carousel">
                                    <div class="slick-list draggable">
                                        <div class="slick-track" style="opacity: 1; width: 100%">
                                            <figure
                                                class="media__imagery media__imagery--with-video slick-slide slick-current slick-active"
                                                data-slick-index="0" role="group" aria-label="slide 1"
                                                style="width: 100%; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                                                <?php if (!empty($instance['thumbnailurl'])) { ?>
                                                    <img src="<?php echo esc_url($instance['thumbnailurl']) ?>"
                                                        alt="<?php echo $instance['thumbnailalttext'] ?>" class="media__image">
                                                <?php } ?>
                                                <a href="<?php echo esc_url($video); ?>"
                                                    class="btn btn--xlarge btn--round play-button">
                                                    <span class="btn__icon">
                                                        <svg class="brei-icon brei-icon-play" focusable="false">
                                                            <use href="#brei-icon-play"></use>
                                                        </svg>
                                                    </span>
                                                    <span class="show-for-sr">Play video</span>
                                                </a>
                                                <!--span class="btn__icon"></span-->
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media__bottom">
                                <div class="media__footer">
                                    <p class="media__copy font-body-lite">
                                        <?php echo $description ?>
                                    </p>
                                    <a href="<?php echo esc_url($video); ?>" class="btn btn-tertiary btn-tertiary-left">
                                        <span class="text">Play Video</span>
                                        <span class="text-arrow">
                                            <svg class="brei-icon brei-icon-arrows" focusable="false">
                                                <use href="#brei-icon-arrows"></use>
                                            </svg>

                                            <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                                <use href="#brei-icon-arrows-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>

                                    <!--span class="btn__icon"></span-->
                                </div>
                            </div>
                            <div class="media__wrapper__bottom"></div>
                        </div>
                    </section>
                </div>
            </div>
            <?php
        }

    } //widget

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['videolink'] = strip_tags($new_instance['videolink']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['thumbnailurl'] = strip_tags($new_instance['thumbnailurl']);
        $instance['thumbnailalttext'] = strip_tags($new_instance['thumbnailalttext']);
        return $instance;
    } //update

    function form($instance)
    {
        $instance = wp_parse_args(
            (array) $instance
        );

        $defaults = array(
            'title' => 'Featured Video',
            'videolink' => '',
            'height' => '220',
            'description' => '',
            'thumbnailurl' => '',
            'thumbnailalttext' => ''
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        $title = $instance['title'];
        $videolink = $instance['videolink'];
        $height = $instance['height'];
        $description = $instance['description'];
        $thumbnailurl = $instance['thumbnailurl'];
        $thumbnailalttext = $instance['thumbnailalttext'];
        $upload_thumbnail_button_id = $this->get_field_id('thumbnailurl') . '-upload-button';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>">Description:</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>"
                name="<?php echo $this->get_field_name('description'); ?>"><?php echo $description; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('videolink'); ?>">Video Link (e.g.,
                https://www.youtube.com/watch?v=J5OSRpRyl6g):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('videolink'); ?>"
                name="<?php echo $this->get_field_name('videolink'); ?>" type="text" value="<?php echo $videolink; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('height'); ?>">Height:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>"
                name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
        </p>

        <label for="<?php echo $this->get_field_id('thumbnailurl'); ?>">Thumbnail URL:</label>

        <input type="url" id="<?php echo $this->get_field_id('thumbnailurl'); ?>"
            name="<?php echo $this->get_field_name('thumbnailurl'); ?>" class="widefat thumbnail-image-url-upload-input"
            value="<?php echo esc_url($thumbnailurl) ?>">

        <label for="<?php echo $this->get_field_id('thumbnailalttext'); ?>">Thumbnail Alt Text:</label>

        <input type="text" id="<?php echo $this->get_field_id('thumbnailalttext'); ?>"
            name="<?php echo $this->get_field_name('thumbnailalttext'); ?>" class="widefat thumbnail-image-alt-upload-input"
            value="<?php echo $thumbnailalttext ?>">

        <button style="display: block; margin: 1rem; " type="button" id="<?php echo $upload_thumbnail_button_id ?>"
            class="button button-primary featured-video-thumbnail-upload-button">Select Thumbnail</button>




        <?php
    } //form

}

function register_FeaturedVideoWidget()
{
    register_widget('FeaturedVideoWidget');
}
add_action('widgets_init', 'register_FeaturedVideoWidget');
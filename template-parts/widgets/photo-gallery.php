<?php

class PhotoGalleryWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'photo-gallery-widget',
            // Base ID
            'CofC Theme Photo Gallery',
            // Name,
            array(
                'classname' => 'photo-gallery-widget'
            )

        );
    }


    function widget($args, $instance)
    {

        extract($args);
        $title = $instance['title'];
        $gallery_caption = 'Test Caption';
        $gallery_action_link = 'https://facebook.com';
        $gallery_action_link_text = 'Test Action Link';
        ?>
        <section class="media  media--narrow js-has-carousel">

            <section class="media  media--narrow js-has-carousel">
                <div class="media__container">
                    <div class="media__header">
                        <h2 class="media__title font-h2">
                            <?php echo $title ?>
                        </h2>
                    </div>

                    <div class="media__wrapper">
                        <div id="media_items" class="media__items">
                            <?php
                            // Display the gallery
                            $gallery_images = explode(',', $instance['gallery_images']);
                            if (!empty($gallery_images)) {
                                foreach ($gallery_images as $image_id) {
                                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                                    if ($image_url) {
                                        $image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                                        $image_caption = wp_get_attachment_caption($image_id);
                                        ?>
                                        <figure class="media__imagery">
                                            <img src="<?php echo $image_url ?>" alt="<?php echo $image_alt_text ?>" class="media__image"
                                                width="836" height="627" />
                                            <figcaption>
                                                <?php echo $image_caption ?>
                                            </figcaption>
                                        </figure>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="media__controls" data-id="media_controls">
                            <div data-id="next"><a href="#" aria-label="See Next" class="btn btn--medium">
                                    <span class="btn__icon">
                                        <svg class="brei-icon brei-icon-chevron" focusable="false">
                                            <use href="#brei-icon-chevron"></use>
                                        </svg>
                                    </span>
                                </a>

                                <!--span class="btn__icon"></span-->
                            </div>
                            <div class="media-amount"></div>
                            <div data-id="prev"><a href="#" aria-label="See Previous" class="btn btn--medium">
                                    <span class="btn__icon">
                                        <svg class="brei-icon brei-icon-chevron" focusable="false">
                                            <use href="#brei-icon-chevron"></use>
                                        </svg>
                                    </span>
                                </a>
                                <!--span class="btn__icon"></span-->
                            </div>
                        </div>
                        <div class="media__caption font-caption" aria-hidden="true"></div>
                    </div>
                    <div id="media_footer" class="media__footer">
                        <div class="media__controls" data-id="media_controls_sm">
                            <div data-id="prev"><a href="#" aria-label="See Next" class="btn btn--medium">
                                    <span class="btn__icon">
                                        <svg class="brei-icon brei-icon-chevron" focusable="false">
                                            <use href="#brei-icon-chevron"></use>
                                        </svg>
                                    </span>
                                </a>

                                <!--span class="btn__icon"></span-->
                            </div>
                            <div class="media-amount"></div>
                            <div data-id="next"><a href="#" aria-label="See Next" class="btn btn--medium">
                                    <span class="btn__icon">
                                        <svg class="brei-icon brei-icon-chevron" focusable="false">
                                            <use href="#brei-icon-chevron"></use>
                                        </svg>
                                    </span>
                                </a>

                                <!--span class="btn__icon"></span-->
                            </div>
                        </div>
                        <p class="media__copy font-body-lite">
                            <?php echo $gallery_caption ?>
                        </p>
                        <?php if ($gallery_action_link) {
                            ?>
                            <a href="<?php echo $gallery_action_link ?>" class="btn btn-tertiary btn-tertiary-left">
                                <span class="text">
                                    <?php echo $gallery_action_link_text ?>
                                </span>
                                <span class="text-arrow">
                                    <svg class="brei-icon brei-icon-arrows" focusable="false">
                                        <use href="#brei-icon-arrows"></use>
                                    </svg>

                                    <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                        <use href="#brei-icon-arrows-arrow"></use>
                                    </svg>
                                </span>
                            </a>
                            <?php
                        } ?>
                    </div>
                </div>
            </section>
            <?php
    }
    // Update the widget settings
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) :
            '';
        $instance['gallery_images'] = (!empty($new_instance['gallery_images'])) ?
            sanitize_text_field($new_instance['gallery_images']) : '';

        return $instance;
    }
    function booltostr(bool $val)
    {
        return $val ? 'yes' : 'no';
    }
    function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $gallery_images = !empty($instance['gallery_images']) ? $instance['gallery_images'] : '';

        ?>
            <div id="<?php echo $this->id ?>" class="custom-photo-gallery">
                <p>
                    <label for=" <?php echo $this->get_field_id('title'); ?>">Title:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                        name="<?php echo $this->get_field_name('title'); ?>" type="text"
                        value="<?php echo esc_attr($title); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('gallery_images'); ?>">Gallery Images:</label>
                    <br />
                    <button class="custom-photo-gallery-upload button button-primary">Select Images</button>
                    <input class="custom-photo-gallery-ids" type="hidden"
                        id="<?php echo $this->get_field_id('gallery_images'); ?>"
                        name="<?php echo $this->get_field_name('gallery_images'); ?>"
                        value="<?php echo esc_attr($gallery_images); ?>" />
                </p>
                <div class="custom-photo-gallery-preview">
                    <?php
                    if (!empty($gallery_images)) {
                        $image_ids = explode(',', $gallery_images);
                        foreach ($image_ids as $image_id) {
                            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                            if ($image_url) {
                                echo '<div class="custom-photo-gallery-preview-image">';
                                echo '<img src="' . esc_url($image_url) . '" alt="Gallery Image">';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
    }
}

function register_PhotoGalleryWidget()
{
    register_widget('PhotoGalleryWidget');
}

add_action('widgets_init', 'register_PhotoGalleryWidget');
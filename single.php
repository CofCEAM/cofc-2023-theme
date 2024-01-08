<?php get_header();
global $post; ?>
<main id="main" class="article">
    <div class="article__wrapper wrapper">
        <div class="row">
            <div class="article__content xsmall-12 medium-10 medium-offset-1 column">
                <div class="article__inner">
                    <div class="article-header">
                        <h1 class="article-header__title font-h1">
                            <?php wp_title() ?>
                        </h1>
                        <div class="article-header__info">
                            <?php if (get_option('display_post_date') == 'yes') { ?>
                                <div class="article-header__data post__date">
                                    <span class="article-header__icon">
                                        <svg class="brei-icon brei-icon-calendar" focusable="false">
                                            <use href="#brei-icon-calendar"></use>
                                        </svg>
                                    </span>
                                    <span class="article-header__label">
                                        <?php echo get_the_date('F j, Y') ?>
                                    </span>
                                </div>
                            <?php }
                            if (get_option('display_post_byline') == 'yes') { ?>
                                <div class="article-header__data post__byline">
                                    <span class="article-header__icon">
                                        <svg class="brei-icon brei-icon-avatar" focusable="false">
                                            <use href="#brei-icon-avatar"></use>
                                        </svg>
                                    </span>
                                    <span class="article-header__label">
                                        <?php
                                        echo get_the_author_meta('display_name', $post->post_author) ?>
                                    </span>
                                </div>
                            <?php }
                            if (get_option('display_post_categories_list') == 'yes') {
                                ?>

                                <div class="article-header__data post__categories-list">
                                    <span class="article-header__icon post__categories">
                                        <svg class="brei-icon brei-icon-tag" focusable="false">
                                            <use href="#brei-icon-tag"></use>
                                        </svg>
                                    </span>
                                    <span class="article-header__label">
                                        <?php
                                        $categories = wp_get_post_categories($post->ID, array('fields' => 'names', 'order' => 'DESC'));
                                        $categories = implode(', ', $categories);
                                        echo $categories; ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (get_option('display_post_excerpt') == 'yes') { ?>
                            <p class="article-header__intro post__excerpt">
                                <?php echo get_the_excerpt($post->ID) ?>
                            </p>
                        <?php } ?>
                    </div>

                    <section class="media media--narrow media--article js-has-carousel">
                        <div class="media__container">
                            <?php
                            $carousel_header = get_post_meta($post->ID, 'featured_media_carousel_header', true);
                            if (!empty($carousel_header)) {
                                ?>
                                <div class="media__header">
                                    <h2 class="media__title font-h2">
                                        <?php echo $carousel_header ?>
                                    </h2>
                                </div>
                                <?php
                            }
                            ?>


                            <div class="media__wrapper">
                                <div id="media_items" class="media__items">
                                    <?php
                                    $featured_video_title = get_post_meta($post->ID, 'featured_video_title', true);
                                    $featured_video_url = get_post_meta($post->ID, 'featured_video_url', true);
                                    $featured_video_caption = get_post_meta($post->ID, 'featured_video_caption', true);
                                    $featured_video_thumbnail_url = get_post_meta($post->ID, 'featured_video_thumbnail', true);

                                    if (!empty($featured_video_url) && !empty($featured_video_thumbnail_url)) { ?>
                                        <figure class="media__imagery media__imagery--with-video">
                                            <img src="<?php echo $featured_video_thumbnail_url ?>"
                                                alt="<?php echo $featured_video_title ?>" class="media__image" width="836"
                                                height="627" />
                                            <a href="<?php echo $featured_video_url ?>"
                                                class="btn btn--xlarge btn--round play-button">
                                                <span class="btn__icon">
                                                    <svg class="brei-icon brei-icon-play" focusable="false">
                                                        <use href="#brei-icon-play"></use>
                                                    </svg>
                                                </span>
                                                <span class="show-for-sr">Play video</span>
                                            </a>
                                            <!--span class="btn__icon"></span-->
                                            <figcaption>
                                                <?php echo $featured_video_caption ?>
                                            </figcaption>
                                        </figure>
                                    <?php } ?>

                                    <?php foreach (range(2, 5) as $num) {
                                        $image_url = get_post_meta(
                                            $post->ID,
                                            'file_upload_featured_image_' . $num,
                                            true
                                        );
                                        if (!empty($image_url)) {
                                            $image_id = attachment_url_to_postid($image_url);
                                            $image = get_post($image_id);
                                            ?>
                                            <figure class="media__imagery">
                                                <img src="<?php echo $image_url ?>" alt="<?php echo $image->post_content ?>"
                                                    class="media__image" width="836" height="627" />
                                                <figcaption>
                                                    <?php echo $image->post_excerpt ?>
                                                </figcaption>
                                            </figure>
                                            <?php
                                        }
                                    } ?>
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
                                    <div data-id="prev"><a href="#" aria-label="See Next" class="btn btn--medium">
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
                                <?php
                                $featured_media_carousel_description = get_post_meta($post->ID, 'featured_media_carousel_description', true);
                                if (!empty($featured_media_carousel_description)) {
                                    ?>
                                    <p class="media__copy font-body-lite">
                                        <?php echo $featured_media_carousel_description ?>
                                    </p>
                                    <!-- <a href="#" class="btn btn-tertiary btn-tertiary-left">
                                    <span class="text">Optional Tertiary Button</span>
                                    <span class="text-arrow">
                                        <svg class="brei-icon brei-icon-arrows" focusable="false">
                                            <use href="#brei-icon-arrows"></use>
                                        </svg>

                                        <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                            <use href="#brei-icon-arrows-arrow"></use>
                                        </svg>
                                    </span>
                                </a> -->
                                    <?php
                                }
                                ?>


                                <!--span class="btn__icon"></span-->
                            </div>

                        </div>

                    </section>

                    <!-- <section class="iframe">

                        <iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0"
                            style="width:100%;overflow:hidden;"
                            sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation"
                            src="https://embed.podcasts.apple.com/us/podcast/bouldering-around-boulder/id1620111298?i=1000558312282&theme=light"></iframe>

                    </section> -->
                    <div class="wysiwyg  component">
                        <div class="wysiwyg__inner  user-markup">

                            <?php $content = apply_filters('the_content', get_the_content());
                            echo $content; ?>


                            <?php
                            $featured_quote = get_post_meta($post->ID, 'featured_quote', true);
                            $featured_quotee = get_post_meta($post->ID, 'featured_quotee', true);
                            if (!empty($featured_quote) && !empty($featured_quotee)) {
                                ?>
                                <div class="quote component">
                                    <div class="quote__wrapper">
                                        <div class="quote__image"></div>
                                    </div>
                                    <blockquote class="quote__inner">
                                        <p class="quote__copy">
                                            <?php echo $featured_quote ?>
                                        </p>
                                        <cite class="quote__cite">
                                            <?php echo $featured_quotee ?>
                                        </cite>
                                    </blockquote>
                                </div>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="share-links">
                        <div class="share-links__content">
                            <p class="share-links__header">Share This Story</p>
                            <hr />
                            <?php
                            $permalink = get_permalink($post->ID);
                            $title = urlencode(wp_title("&raquo;", false, ""));
                            $summary = urlencode(get_the_excerpt($post->ID));
                            $featured_image_url = get_the_post_thumbnail_url($post->ID);

                            $fb_share_url = "https://facebook.com/sharer.php?u=" . urlencode($permalink) . "&amp;t=" . $title;
                            $twitter_share_url = "https://twitter.com/share?url=" . urlencode($permalink) . "&amp;text=" . $title;
                            $reddit_share_url = "https://reddit.com/submit?url=" . $permalink . "&amp;title=" . wp_title("", false, "");
                            $linkedin_share_url = "https://www.linkedin.com/shareArticle?mini=true&amp;url=" . urlencode($permalink) . "&amp;title=" . $title . "&amp;summary=" . $summary;
                            $whatsapp_share_url = "https://api.whatsapp.com/send?text=" . urlencode($permalink);
                            $tumblr_share_url = "https://www.tumblr.com/share/link?url=" . urlencode($permalink) . "&amp;name=" . $title . "&amp;description=" . $summary;
                            $pinterest_share_url = "https://pinterest.com/pin/create/button/?url=" . urlencode($permalink) . "&amp;description=" . $summary . "&amp;media=" . urlencode($featured_image_url);
                            $vk_share_url = "https://vk.com/share.php?url=" . urlencode($permalink) . "&amp;title=" . $title . "&amp;description=" . $summary;
                            $email_share_url = "mailto:?body=" . $permalink . "&amp;subject=" . $title;
                            ?>
                            <ul class="share-links__list">
                                <li class="share-links__item">

                                    <a href="<?php echo $fb_share_url ?>" class="share-links__link"
                                        aria-label="Facebook" target="_blank">
                                        <svg class="brei-icon brei-icon-social-facebook" focusable="false">
                                            <use href="#brei-icon-social-facebook"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $twitter_share_url ?>" class="share-links__link"
                                        aria-label="Twitter" target="_blank">

                                        <svg class="brei-icon brei-icon-social-twitter" focusable="false">
                                            <use href="#brei-icon-social-twitter"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $reddit_share_url ?>" class="share-links__link"
                                        aria-label="Reddit" target="_blank">

                                        <svg class="brei-icon brei-icon-social-reddit" focusable="false">
                                            <use href="#brei-icon-social-reddit"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $linkedin_share_url ?>" class="share-links__link"
                                        aria-label="LinkedIn" target="_blank">

                                        <svg class="brei-icon brei-icon-social-linkedin" focusable="false">
                                            <use href="#brei-icon-social-linkedin"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $whatsapp_share_url ?>" class="share-links__link"
                                        aria-label="WhatsApp" target="_blank">

                                        <svg class="brei-icon brei-icon-social-whatsapp" focusable="false">
                                            <use href="#brei-icon-social-whatsapp"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $tumblr_share_url ?>" class="share-links__link"
                                        aria-label="Tumblr" target="_blank">

                                        <svg class="brei-icon brei-icon-social-tumblr" focusable="false">
                                            <use href="#brei-icon-social-tumblr"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $pinterest_share_url ?>" class="share-links__link"
                                        aria-label="Pinterest" target="_blank">

                                        <svg class="brei-icon brei-icon-social-pinterest" focusable="false">
                                            <use href="#brei-icon-social-pinterest"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href=" <?php echo $vk_share_url ?>" class="share-links__link"
                                        aria-label="VKontakte" target="_blank">

                                        <svg class="brei-icon brei-icon-social-vk" focusable="false">
                                            <use href="#brei-icon-social-vk"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="<?php echo $email_share_url ?>" class="share-links__link"
                                        aria-label="Email" target="_blank">

                                        <svg class="brei-icon brei-icon-email" focusable="false">
                                            <use href="#brei-icon-email"></use>
                                        </svg>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <?php


            $related = get_posts(array('category__in' => wp_get_post_categories($post->ID), 'numberposts' => 3, 'post__not_in' => array($post->ID)));
            $category_slugs = wp_get_post_categories($post->ID, array('fields' => 'slugs', 'order' => 'DESC'));
            $first_related_category_slug = $category_slugs[0];
            $first_related_category_link = get_site_url() . '/category/' . $first_related_category_slug;

            if ($related) {
                ?>
                <div class=" article__news xsmall-12 medium-10 medium-offset-1 column">
                    <section class="news-content news-content--article news-content--single component">
                        <div class="cell xsmall-12">
                            <h2 class="font-h2">Related News</h2>
                            <hr />
                        </div>
                        <div class="news-content__cards grid-x grid-margin-x grid-margin-y">
                            <?php foreach ($related as $post) {
                                display_single_post_card(
                                    post: $post,
                                    wide: false,
                                    display_excerpt: false,
                                    display_published_date: false,
                                    display_author: true,
                                    medium_screen_class: 'medium-4',
                                    large_screen_class: '',
                                    title_heading_size: 'h4'
                                );
                            } ?>
                        </div>
                        <div class="button-dotted-line">
                            <a href="<?php echo $first_related_category_link ?>" class="btn btn--primary">
                                <span class="text">View More Related Posts</span>
                            </a>

                            <!--span class="btn__icon"></span-->
                        </div>
                    </section>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
<?php
// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()):
    comments_template();
endif;
?>
<?php get_footer() ?>
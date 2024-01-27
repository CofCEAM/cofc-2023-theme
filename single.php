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
                        <?php
                        if (get_option('display_post_date') == 'yes' || get_option('display_post_byline') == 'yes' || get_option('display_post_categories_list') == 'yes') { ?>
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
                            <?php
                        }
                        // strip the excerpt - remove whitespace
                        $excerpt = get_the_excerpt($post->ID);
                        $excerpt = trim($excerpt);
                        if (get_option('display_post_excerpt') == 'yes' && !empty($excerpt)) { ?>
                            <p class="article-header__intro post__excerpt">
                                <?php echo $excerpt ?>
                            </p>
                        <?php } ?>
                    </div>
                    <div class="wysiwyg  component">
                        <div class="wysiwyg__inner  user-markup">
                            <?php $content = apply_filters('the_content', get_the_content());
                            echo $content; ?>
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
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
                            <div class="article-header__data">
                                <span class="article-header__icon">
                                    <svg class="brei-icon brei-icon-calendar" focusable="false">
                                        <use href="#brei-icon-calendar"></use>
                                    </svg>
                                </span>
                                <span class="article-header__label">
                                    <?php echo get_the_date('F j, Y') ?>
                                </span>
                            </div>
                            <div class="article-header__data">
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
                            <div class="article-header__data">
                                <span class="article-header__icon">
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
                        </div>
                        <p class="article-header__intro">
                            <?php echo get_the_excerpt($post->ID) ?>
                        </p>
                    </div>

                    <section class="media  media--narrow media--article js-has-carousel">
                        <?php
                        $featured_image_title = get_post(get_post_thumbnail_id())->post_title;
                        $featured_image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
                        $featured_image_description = get_post(get_post_thumbnail_id())->post_content;
                        $featured_image_url = get_the_post_thumbnail_url($post->ID);
                        ?>
                        <div class="media__container">
                            <div class="media__header">
                                <h2 class="media__title font-h2">
                                    <?php echo $featured_image_title ?>
                                </h2>
                            </div>

                            <div class="media__wrapper">
                                <div id="media_items" class="media__items">
                                    <figure class="media__imagery media__imagery--with-video">
                                        <img src="<?php echo $featured_image_url ?>"
                                            alt="<?php echo $featured_image_caption ?>" class="media__image" width="836"
                                            height="627" />

                                        <a href="https://www.youtube.com/watch?v=J5OSRpRyl6g"
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
                                            <?php echo $featured_image_caption ?>
                                        </figcaption>

                                    </figure>
                                    <figure class="media__imagery">
                                        <img src="https://via.placeholder.com/926x695/ff00ff/9a9a9a"
                                            alt="[image alt text]" class="media__image" width="836" height="627" />

                                        <figcaption>Optional caption 100 characters lorem ipsum dolor sit amet
                                            consectetur adipscing elit sed do.</figcaption>

                                    </figure>
                                    <figure class="media__imagery">
                                        <img src="https://via.placeholder.com/926x695/00ffff/9a9a9a"
                                            alt="[image alt text]" class="media__image" width="836" height="627" />
                                        <figcaption>little caption</figcaption>
                                    </figure>
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
                                <p class="media__copy font-body-lite">Structured copy max 225 char lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Nisi lacus sed viverra tellus in hac habitasse.</p>
                                <a href="#" class="btn btn-tertiary btn-tertiary-left">
                                    <span class="text">Optional Tertiary Button</span>
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

                    </section>

                    <section class="iframe">

                        <iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0"
                            style="width:100%;overflow:hidden;"
                            sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation"
                            src="https://embed.podcasts.apple.com/us/podcast/bouldering-around-boulder/id1620111298?i=1000558312282&theme=light"></iframe>

                    </section>
                    <div class="wysiwyg  component">
                        <div class="wysiwyg__inner  user-markup">

                            <?php $content = apply_filters('the_content', get_the_content());
                            echo $content; ?>


                            <?php
                            $featured_quote = get_post_meta($post->ID, 'featured_quote', true);
                            $featured_quotee = get_post_meta($post->ID, 'featured_quotee', true);
                            if (isset($featured_quote) && isset($featured_quotee)) {
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
                            <a href="#" class="btn btn--primary"><span class="text">Primary Large</span></a>

                        </div>
                    </div>
                    <?php
                    $featured_video_title = get_post_meta($post->ID, 'featured_video_title', true);
                    $featured_video_url = get_post_meta($post->ID, 'featured_video_url', true);
                    $featured_video_caption = get_post_meta($post->ID, 'featured_video_caption', true);
                    $featured_video_thumbnail_url = get_post_meta($post->ID, 'featured_video_thumbnail', true);

                    if (isset($featured_video_url) && isset($featured_video_thumbnail_url)) {
                        echo ' 
                            <section class="media  media--narrow media--video media--article component js-has-carousel"> 
                                <div class="media__container"> ';
                        if (isset($featured_video_title)) {
                            echo '
                                <div class="media__header">
                                    <h2 class="media__title font-h2">' . $featured_video_title . '</h2>
                                </div>
                                ';
                        }

                        echo '
                            <div class="media__wrapper">
                                <div id="media_items" class="media__items">
                                    <figure class="media__imagery media__imagery--with-video">
                                        <img src="' . $featured_video_thumbnail_url . '" 
                                            alt="' . $featured_video_caption . '"
                                            class="media__image" width="1264" height="711" />

                                        <a href="' . $featured_video_url . '"
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
                                <div class="media__caption font-caption" aria-hidden="true"></div>
                            </div>
                            <div class="media__bottom">
                                <div class="media__footer">
                                    <p class="media__copy font-body-lite">' . $featured_video_caption . '</p>
                                    <a href="' . $featured_video_url . '" target="_blank" title="' . $featured_video_title . '" class="btn btn-tertiary btn-tertiary-left">
                                        <span class="text">Go to Video</span>
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

                        
                        ';
                    }
                    ?>

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

                            echo '
                            <ul class="share-links__list">
                                <li class="share-links__item">

                                    <a href="' . $fb_share_url . '" class="share-links__link" aria-label="Facebook" target="_blank">
                                        <svg class="brei-icon brei-icon-social-facebook" focusable="false">
                                            <use href="#brei-icon-social-facebook"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $twitter_share_url . '" class="share-links__link" aria-label="Twitter" target="_blank">

                                        <svg class="brei-icon brei-icon-social-twitter" focusable="false">
                                            <use href="#brei-icon-social-twitter"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $reddit_share_url . '" class="share-links__link" aria-label="Reddit" target="_blank">

                                        <svg class="brei-icon brei-icon-social-reddit" focusable="false">
                                            <use href="#brei-icon-social-reddit"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $linkedin_share_url . '" class="share-links__link" aria-label="LinkedIn" target="_blank">

                                        <svg class="brei-icon brei-icon-social-linkedin" focusable="false">
                                            <use href="#brei-icon-social-linkedin"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $whatsapp_share_url . '" class="share-links__link" aria-label="WhatsApp" target="_blank">

                                        <svg class="brei-icon brei-icon-social-whatsapp" focusable="false">
                                            <use href="#brei-icon-social-whatsapp"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $tumblr_share_url . '" class="share-links__link" aria-label="Tumblr" target="_blank">

                                        <svg class="brei-icon brei-icon-social-tumblr" focusable="false">
                                            <use href="#brei-icon-social-tumblr"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $pinterest_share_url . '" class="share-links__link" aria-label="Pinterest" target="_blank">

                                        <svg class="brei-icon brei-icon-social-pinterest" focusable="false">
                                            <use href="#brei-icon-social-pinterest"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $vk_share_url . '" class="share-links__link" aria-label="VKontakte" target="_blank">

                                        <svg class="brei-icon brei-icon-social-vk" focusable="false">
                                            <use href="#brei-icon-social-vk"></use>
                                        </svg>

                                    </a>
                                </li>
                                <li class="share-links__item">
                                    <a href="' . $email_share_url . '" class="share-links__link" aria-label="Email" target="_blank">

                                        <svg class="brei-icon brei-icon-email" focusable="false">
                                            <use href="#brei-icon-email"></use>
                                        </svg>

                                    </a>
                                </li>
                            </ul>
                            ';
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="article__news xsmall-12 medium-10 medium-offset-1 column">
                <section class="news-content news-content--article news-content--single component">
                    <div class="cell xsmall-12">
                        <h2 class="font-h2">Related News</h2>
                        <hr />
                    </div>
                    <div class="news-content__cards grid-x grid-margin-x grid-margin-y">
                        <div class="cell xsmall-12 medium-6 large-4">
                            <div class="card-news" itemscope itemtype="https://schema.org/NewsArticle">

                                <figure class="card-news__figure">
                                    <img src="https://via.placeholder.com/926x695" alt="[news photo alt text]"
                                        class="card-news__image" itemprop="image" width="926" height="695" />
                                </figure>

                                <div class="card-news__wrapper">
                                    <div class="card-news__content">
                                        <p class="card-news__heading font-h4"><span itemprop="headline">News Title H4
                                                loreM ipsum dolor sit ameT consectetur elit</span></p>
                                        <p class="card-news__date card-icon">
                                            <svg class="brei-icon brei-icon-calendar" focusable="false">
                                                <use href="#brei-icon-calendar"></use>
                                            </svg>
                                            <span itemprop="dateline">April 16, 2023</span>
                                        </p>
                                        <p class="card-news__author card-icon">
                                            <svg class="brei-icon brei-icon-avatar" focusable="false">
                                                <use href="#brei-icon-avatar"></use>
                                            </svg>
                                            <span itemprop="author">by Firstname Lastname</span>
                                        </p>
                                    </div>

                                    <div class="card-news__button">
                                        <p class="btn btn-card" aria-hidden="true">
                                            <span class="text-arrow">
                                                <svg class="brei-icon brei-icon-arrows" focusable="false">
                                                    <use href="#brei-icon-arrows"></use>
                                                </svg>

                                                <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                                    <use href="#brei-icon-arrows-arrow"></use>
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <a href="#" class="child-page-grid__link"><span class="show-for-sr">Read more about
                                        "News Title H4 loreM ipsum dolor sit ameT consectetur elit"</span></a>

                            </div>
                        </div>
                        <div class="cell xsmall-12 medium-6 large-4">
                            <div class="card-news" itemscope itemtype="https://schema.org/NewsArticle">

                                <figure class="card-news__figure">
                                    <img src="https://via.placeholder.com/926x695" alt="[news photo alt text]"
                                        class="card-news__image" itemprop="image" width="926" height="695" />
                                </figure>

                                <div class="card-news__wrapper">
                                    <div class="card-news__content">
                                        <p class="card-news__heading font-h4"><span itemprop="headline">News Title H4
                                                loreM ipsum dolor sit ameT consectetur elit</span></p>
                                        <p class="card-news__date card-icon">
                                            <svg class="brei-icon brei-icon-calendar" focusable="false">
                                                <use href="#brei-icon-calendar"></use>
                                            </svg>
                                            <span itemprop="dateline">April 16, 2023</span>
                                        </p>
                                        <p class="card-news__author card-icon">
                                            <svg class="brei-icon brei-icon-avatar" focusable="false">
                                                <use href="#brei-icon-avatar"></use>
                                            </svg>
                                            <span itemprop="author">by Firstname Lastname</span>
                                        </p>
                                    </div>

                                    <div class="card-news__button">
                                        <p class="btn btn-card" aria-hidden="true">
                                            <span class="text-arrow">
                                                <svg class="brei-icon brei-icon-arrows" focusable="false">
                                                    <use href="#brei-icon-arrows"></use>
                                                </svg>

                                                <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                                    <use href="#brei-icon-arrows-arrow"></use>
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <a href="#" class="child-page-grid__link"><span class="show-for-sr">Read more about
                                        "News Title H4 loreM ipsum dolor sit ameT consectetur elit"</span></a>

                            </div>
                        </div>
                        <div class="cell xsmall-12 medium-6 large-4">
                            <div class="card-news" itemscope itemtype="https://schema.org/NewsArticle">

                                <figure class="card-news__figure">
                                    <img src="https://via.placeholder.com/926x695" alt="[news photo alt text]"
                                        class="card-news__image" itemprop="image" width="926" height="695" />
                                </figure>

                                <div class="card-news__wrapper">
                                    <div class="card-news__content">
                                        <p class="card-news__heading font-h4"><span itemprop="headline">News Title H4
                                                loreM ipsum dolor sit ameT consectetur elit</span></p>
                                        <p class="card-news__date card-icon">
                                            <svg class="brei-icon brei-icon-calendar" focusable="false">
                                                <use href="#brei-icon-calendar"></use>
                                            </svg>
                                            <span itemprop="dateline">April 16, 2023</span>
                                        </p>
                                        <p class="card-news__author card-icon">
                                            <svg class="brei-icon brei-icon-avatar" focusable="false">
                                                <use href="#brei-icon-avatar"></use>
                                            </svg>
                                            <span itemprop="author">by Firstname Lastname</span>
                                        </p>
                                    </div>

                                    <div class="card-news__button">
                                        <p class="btn btn-card" aria-hidden="true">
                                            <span class="text-arrow">
                                                <svg class="brei-icon brei-icon-arrows" focusable="false">
                                                    <use href="#brei-icon-arrows"></use>
                                                </svg>

                                                <svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
                                                    <use href="#brei-icon-arrows-arrow"></use>
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <a href="#" class="child-page-grid__link"><span class="show-for-sr">Read more about
                                        "News Title H4 loreM ipsum dolor sit ameT consectetur elit"</span></a>

                            </div>
                        </div>
                    </div>
                    <div class="button-dotted-line">
                        <a href="#" class="btn btn--primary">
                            <span class="text">Primary Large</span>
                        </a>

                        <!--span class="btn__icon"></span-->
                    </div>
                </section>
            </div>

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
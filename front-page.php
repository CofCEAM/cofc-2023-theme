<?php get_header(); ?>
<main id="main" class="home">
    <div class="home__background">
        <section class="news-content news-content--home news-content--featured">
            <div class="wrapper">
                <div class="news-content__cards grid-x grid-margin-x grid-margin-y">
                    <?php dynamic_sidebar('featured-posts-area'); ?>
                </div>
            </div>
        </section>
    </div>
    <?php dynamic_sidebar('mailchimp-email-subscribe-form-area'); ?>
    <div class="wrapper">
        <div class="row level__row">
            <div class="xsmall-12 large-8 column">
                <?php dynamic_sidebar('news-sections-area'); ?>
            </div>
            <div class="level__aside xsmall-12 large-3 large-offset-1 column">
                <section class="rail-home component">
                    <?php dynamic_sidebar('cofc-primary-sidebar'); ?>
                </section>
            </div>
        </div>
    </div>

    <?php dynamic_sidebar('featured-video-area'); ?>

</main>
<?php get_footer(); ?>
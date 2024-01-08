<?php get_header(); ?>
<main id="main" class="article">

    <div class="article__wrapper wrapper">
        <div class="row">
            <div class="article__content xsmall-12 medium-10 medium-offset-1 column">
                <div class="article__inner">
                    <div class="article-header">
                        <h1 class="article-header__title font-h1">
                            <?php echo get_the_title() ?>
                        </h1>
                        <div class="article-header__info">
                            <?php if (get_option('display_page_date') == 'yes') { ?>
                                <div class="article-header__data page__date">
                                    <span class="article-header__icon">
                                        <svg class="brei-icon brei-icon-calendar" focusable="false">
                                            <use href="#brei-icon-calendar"></use>
                                        </svg>
                                    </span>
                                    <span class="article-header__label">
                                        <?php echo get_the_date('F j, Y', $post) ?>
                                    </span>
                                </div>
                            <?php }
                            if (get_option('display_page_byline') == 'yes') { ?>
                                <div class="article-header__data page__byline">
                                    <span class="article-header__icon">
                                        <svg class="brei-icon brei-icon-avatar" focusable="false">
                                            <use href="#brei-icon-avatar"></use>
                                        </svg>
                                    </span>
                                    <span class="article-header__label">
                                        <?php echo get_the_author_meta('display_name', $post->post_author) ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        if (get_option('display_page_excerpt') == 'yes') {
                            ?>
                            <p class="article-header__intro page__excerpt">
                                <?php echo get_the_excerpt() ?>
                            </p>
                        <?php } ?>
                    </div>
                    <div class="wysiwyg  component">
                        <div class="wysiwyg__inner">
                            <?php the_content() ?>
                        </div>
                    </div>
                </div>
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
<?php get_footer(); ?>
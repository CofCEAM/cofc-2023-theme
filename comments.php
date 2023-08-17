<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
require get_template_directory() . '/commentsutil/walker.php';
require get_template_directory() . '/commentsutil/util.php';
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div class="wrapper">
    <div id="comments" class="comments-area xsmall-12 medium-10 medium-offset-1 column component">

        <?php if (have_comments()): ?>
            <h3 class="comments-title font-h3">
                <?php
                printf(
                    _nx(
                        'One thought on "%2$s"',
                        '%1$s thoughts on "%2$s"',
                        get_comments_number(),
                        'comments title',
                        'twentythirteen'
                    ),
                    number_format_i18n(get_comments_number()),
                    '<span>' . get_the_title() . '</span>'
                );
                ?>
            </h3>
            <hr class="secondary" />
            <ul class="comment-list no-bullet">
                <?php
                cofctheme_wp_list_comments(
                    array(
                        'style' => 'ul',
                        'short_ping' => true,
                        'avatar_size' => 74,
                        'walker' => new CofCTheme_Walker_Comment(),
                    )
                );
                ?>
            </ul><!-- .comment-list -->

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
                <nav class="navigation comment-navigation" role="navigation">

                    <h1 class="screen-reader-text section-heading">
                        <?php _e('Comment navigation', 'twentythirteen'); ?>
                    </h1>
                    <div class="nav-previous">
                        <?php previous_comments_link(__('&larr; Older Comments', 'twentythirteen')); ?>
                    </div>
                    <div class="nav-next">
                        <?php next_comments_link(__('Newer Comments &rarr;', 'twentythirteen')); ?>
                    </div>
                </nav><!-- .comment-navigation -->
            <?php endif; // Check for comment navigation ?>

            <?php if (!comments_open() && get_comments_number()): ?>
                <p class="no-comments">
                    <?php _e('Comments are closed.', 'twentythirteen'); ?>
                </p>
            <?php endif; ?>

        <?php endif; // have_comments() ?>

        <hr />
        <?php cofctheme_comment_form(); ?>

    </div><!-- #comments -->
</div>
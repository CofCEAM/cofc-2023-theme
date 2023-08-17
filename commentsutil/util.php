<?php
/* Customize / overwrite default comment parsers */
function cofctheme_comment_form($args = array(), $post = null)
{
    $post = get_post($post);

    // Exit the function if the post is invalid or comments are closed.
    if (!$post || !comments_open($post)) {
        /**
         * Fires after the comment form if comments are closed.
         *
         * For backward compatibility, this action also fires if comment_form()
         * is called with an invalid post object or ID.
         *
         * @since 3.0.0
         */
        do_action('comment_form_comments_closed');

        return;
    }

    $post_id = $post->ID;
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = wp_parse_args($args);
    if (!isset($args['format'])) {
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    }

    $req = get_option('require_name_email');
    $html5 = 'html5' === $args['format'];

    // Define attributes in HTML5 or XHTML syntax.
    $required_attribute = ($html5 ? ' required' : ' required="required"');
    $checked_attribute = ($html5 ? ' checked' : ' checked="checked"');

    // Identify required fields visually and create a message about the indicator.
    $required_indicator = ' ' . wp_required_field_indicator();
    $required_text = ' ' . wp_required_field_message();

    $fields = array(
        'author' => sprintf(
            '<p class="comment-form-author">%s %s</p>',
            sprintf(
                '<label for="author">%s%s</label>',
                __('Name'),
                ($req ? $required_indicator : '')
            ),
            sprintf(
                '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" autocomplete="name"%s />',
                esc_attr($commenter['comment_author']),
                ($req ? $required_attribute : '')
            )
        ),
        'email' => sprintf(
            '<p class="comment-form-email">%s %s</p>',
            sprintf(
                '<label for="email">%s%s</label>',
                __('Email'),
                ($req ? $required_indicator : '')
            ),
            sprintf(
                '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"%s />',
                ($html5 ? 'type="email"' : 'type="text"'),
                esc_attr($commenter['comment_author_email']),
                ($req ? $required_attribute : '')
            )
        ),
        'url' => sprintf(
            '<p class="comment-form-url">%s %s</p>',
            sprintf(
                '<label for="url">%s</label>',
                __('Website')
            ),
            sprintf(
                '<input id="url" name="url" %s value="%s" size="30" maxlength="200" autocomplete="url" />',
                ($html5 ? 'type="url"' : 'type="text"'),
                esc_attr($commenter['comment_author_url'])
            )
        ),
    );

    if (has_action('set_comment_cookies', 'wp_set_comment_cookies') && get_option('show_comments_cookies_opt_in')) {
        $consent = empty($commenter['comment_author_email']) ? '' : $checked_attribute;

        $fields['cookies'] = sprintf(
            '<p class="comment-form-cookies-consent">%s %s</p>',
            sprintf(
                '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
                $consent
            ),
            sprintf(
                '<label for="wp-comment-cookies-consent">%s</label>',
                __('Save my name, email, and website in this browser for the next time I comment.')
            )
        );

        // Ensure that the passed fields include cookies consent.
        if (isset($args['fields']) && !isset($args['fields']['cookies'])) {
            $args['fields']['cookies'] = $fields['cookies'];
        }
    }

    /**
     * Filters the default comment form fields.
     *
     * @since 3.0.0
     *
     * @param string[] $fields Array of the default comment fields.
     */
    $fields = apply_filters('comment_form_default_fields', $fields);

    $defaults = array(
        'fields' => $fields,
        'comment_field' => sprintf(
            '<p class="comment-form-comment">%s %s</p>',
            sprintf(
                '<label for="comment">%s%s</label>',
                _x('Comment', 'noun'),
                $required_indicator
            ),
            '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525"' . $required_attribute . '></textarea>'
        ),
        'must_log_in' => sprintf(
            '<p class="must-log-in">%s</p>',
            sprintf(
                /* translators: %s: Login URL. */
                __('You must be <a href="%s">logged in</a> to post a comment.'),
                /** This filter is documented in wp-includes/link-template.php */
                wp_login_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
            )
        ),
        'logged_in_as' => sprintf(
            '<p class="logged-in-as">%s%s</p>',
            sprintf(
                /* translators: 1: User name, 2: Edit user link, 3: Logout URL. */
                __('Logged in as %1$s. <a href="%2$s">Edit your profile</a>. <a href="%3$s">Log out?</a>'),
                $user_identity,
                get_edit_user_link(),
                /** This filter is documented in wp-includes/link-template.php */
                wp_logout_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
            ),
            $required_text
        ),
        'comment_notes_before' => sprintf(
            '<p class="comment-notes">%s%s</p>',
            sprintf(
                '<span id="email-notes">%s</span>',
                __('Your email address will not be published.')
            ),
            $required_text
        ),
        'comment_notes_after' => '',
        'action' => site_url('/wp-comments-post.php'),
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'class_container' => 'comment-respond',
        'class_form' => 'comment-form',
        'class_submit' => 'submit',
        'name_submit' => 'submit',
        'title_reply' => __('Leave a Reply'),
        /* translators: %s: Author of the comment being replied to. */
        'title_reply_to' => __('Leave a Reply to %s'),
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'cancel_reply_before' => ' <small>',
        'cancel_reply_after' => '</small>',
        'cancel_reply_link' => __('Cancel reply'),
        'label_submit' => __('Post Comment'),
        'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
        'format' => 'xhtml',
    );

    /**
     * Filters the comment form default arguments.
     *
     * Use {@see 'comment_form_default_fields'} to filter the comment fields.
     *
     * @since 3.0.0
     *
     * @param array $defaults The default comment form arguments.
     */
    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

    // Ensure that the filtered arguments contain all required default values.
    $args = array_merge($defaults, $args);

    // Remove `aria-describedby` from the email field if there's no associated description.
    if (isset($args['fields']['email']) && false === strpos($args['comment_notes_before'], 'id="email-notes"')) {
        $args['fields']['email'] = str_replace(
            ' aria-describedby="email-notes"',
            '',
            $args['fields']['email']
        );
    }

    /**
     * Fires before the comment form.
     *
     * @since 3.0.0
     */
    do_action('comment_form_before');
    ?>
    <div id="respond" class="<?php echo esc_attr($args['class_container']); ?> component">
        <?php
        echo $args['title_reply_before'];

        comment_form_title($args['title_reply'], $args['title_reply_to'], true, $post_id);

        if (get_option('thread_comments')) {
            echo $args['cancel_reply_before'];

            cancel_comment_reply_link($args['cancel_reply_link']);

            echo $args['cancel_reply_after'];
        }

        echo $args['title_reply_after'];

        if (get_option('comment_registration') && !is_user_logged_in()):

            echo $args['must_log_in'];
            /**
             * Fires after the HTML-formatted 'must log in after' message in the comment form.
             *
             * @since 3.0.0
             */
            do_action('comment_form_must_log_in_after');

        else:

            printf(
                '<form action="%s" method="post" id="%s" class="%s"%s>',
                esc_url($args['action']),
                esc_attr($args['id_form']),
                esc_attr($args['class_form']),
                ($html5 ? ' novalidate' : '')
            );

            /**
             * Fires at the top of the comment form, inside the form tag.
             *
             * @since 3.0.0
             */
            do_action('comment_form_top');

            if (is_user_logged_in()):

                /**
                 * Filters the 'logged in' message for the comment form for display.
                 *
                 * @since 3.0.0
                 *
                 * @param string $args_logged_in The HTML for the 'logged in as [user]' message,
                 *                               the Edit profile link, and the Log out link.
                 * @param array  $commenter      An array containing the comment author's
                 *                               username, email, and URL.
                 * @param string $user_identity  If the commenter is a registered user,
                 *                               the display name, blank otherwise.
                 */
                echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity);

                /**
                 * Fires after the is_user_logged_in() check in the comment form.
                 *
                 * @since 3.0.0
                 *
                 * @param array  $commenter     An array containing the comment author's
                 *                              username, email, and URL.
                 * @param string $user_identity If the commenter is a registered user,
                 *                              the display name, blank otherwise.
                 */
                do_action('comment_form_logged_in_after', $commenter, $user_identity);

            else:

                echo $args['comment_notes_before'];

            endif;

            // Prepare an array of all fields, including the textarea.
            $comment_fields = array('comment' => $args['comment_field']) + (array) $args['fields'];

            /**
             * Filters the comment form fields, including the textarea.
             *
             * @since 4.4.0
             *
             * @param array $comment_fields The comment fields.
             */
            $comment_fields = apply_filters('comment_form_fields', $comment_fields);

            // Get an array of field names, excluding the textarea.
            $comment_field_keys = array_diff(array_keys($comment_fields), array('comment'));

            // Get the first and the last field name, excluding the textarea.
            $first_field = reset($comment_field_keys);
            $last_field = end($comment_field_keys);

            foreach ($comment_fields as $name => $field) {

                if ('comment' === $name) {

                    /**
                     * Filters the content of the comment textarea field for display.
                     *
                     * @since 3.0.0
                     *
                     * @param string $args_comment_field The content of the comment textarea field.
                     */
                    echo apply_filters('comment_form_field_comment', $field);

                    echo $args['comment_notes_after'];

                } elseif (!is_user_logged_in()) {

                    if ($first_field === $name) {
                        /**
                         * Fires before the comment fields in the comment form, excluding the textarea.
                         *
                         * @since 3.0.0
                         */
                        do_action('comment_form_before_fields');
                    }

                    /**
                     * Filters a comment form field for display.
                     *
                     * The dynamic portion of the hook name, `$name`, refers to the name
                     * of the comment form field.
                     *
                     * Possible hook names include:
                     *
                     *  - `comment_form_field_comment`
                     *  - `comment_form_field_author`
                     *  - `comment_form_field_email`
                     *  - `comment_form_field_url`
                     *  - `comment_form_field_cookies`
                     *
                     * @since 3.0.0
                     *
                     * @param string $field The HTML-formatted output of the comment form field.
                     */
                    echo apply_filters("comment_form_field_{$name}", $field) . "\n";

                    if ($last_field === $name) {
                        /**
                         * Fires after the comment fields in the comment form, excluding the textarea.
                         *
                         * @since 3.0.0
                         */
                        do_action('comment_form_after_fields');
                    }
                }
            }

            $submit_button = sprintf(
                $args['submit_button'],
                esc_attr($args['name_submit']),
                esc_attr($args['id_submit']),
                esc_attr($args['class_submit']),
                esc_attr($args['label_submit'])
            );

            /**
             * Filters the submit button for the comment form to display.
             *
             * @since 4.2.0
             *
             * @param string $submit_button HTML markup for the submit button.
             * @param array  $args          Arguments passed to comment_form().
             */
            $submit_button = apply_filters('comment_form_submit_button', $submit_button, $args);

            $submit_field = sprintf(
                $args['submit_field'],
                $submit_button,
                get_comment_id_fields($post_id)
            );

            /**
             * Filters the submit field for the comment form to display.
             *
             * The submit field includes the submit button, hidden fields for the
             * comment form, and any wrapper markup.
             *
             * @since 4.2.0
             *
             * @param string $submit_field HTML markup for the submit field.
             * @param array  $args         Arguments passed to comment_form().
             */
            echo apply_filters('comment_form_submit_field', $submit_field, $args);

            /**
             * Fires at the bottom of the comment form, inside the closing form tag.
             *
             * @since 1.5.0
             *
             * @param int $post_id The post ID.
             */
            do_action('comment_form', $post_id);

            echo '</form>';

        endif;
        ?>
    </div><!-- #respond -->
    <?php

    /**
     * Fires after the comment form.
     *
     * @since 3.0.0
     */
    do_action('comment_form_after');
}

function cofctheme_wp_list_comments($args = array(), $comments = null)
{
    global $wp_query, $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop;

    $in_comment_loop = true;

    $comment_alt = 0;
    $comment_thread_alt = 0;
    $comment_depth = 1;

    $defaults = array(
        'walker' => null,
        'max_depth' => '',
        'style' => 'ul',
        'callback' => null,
        'end-callback' => null,
        'type' => 'all',
        'page' => '',
        'per_page' => '',
        'avatar_size' => 32,
        'reverse_top_level' => null,
        'reverse_children' => '',
        'format' => current_theme_supports('html5', 'comment-list') ? 'html5' : 'xhtml',
        'short_ping' => false,
        'echo' => true,
    );

    $parsed_args = wp_parse_args($args, $defaults);

    /**
     * Filters the arguments used in retrieving the comment list.
     *
     * @since 4.0.0
     *
     * @see wp_list_comments()
     *
     * @param array $parsed_args An array of arguments for displaying comments.
     */
    $parsed_args = apply_filters('wp_list_comments_args', $parsed_args);

    // Figure out what comments we'll be looping through ($_comments).
    if (null !== $comments) {
        $comments = (array) $comments;
        if (empty($comments)) {
            return;
        }
        if ('all' !== $parsed_args['type']) {
            $comments_by_type = separate_comments($comments);
            if (empty($comments_by_type[$parsed_args['type']])) {
                return;
            }
            $_comments = $comments_by_type[$parsed_args['type']];
        } else {
            $_comments = $comments;
        }
    } else {
        /*
         * If 'page' or 'per_page' has been passed, and does not match what's in $wp_query,
         * perform a separate comment query and allow Walker_Comment to paginate.
         */
        if ($parsed_args['page'] || $parsed_args['per_page']) {
            $current_cpage = get_query_var('cpage');
            if (!$current_cpage) {
                $current_cpage = 'newest' === get_option('default_comments_page') ? 1 : $wp_query->max_num_comment_pages;
            }

            $current_per_page = get_query_var('comments_per_page');
            if ($parsed_args['page'] != $current_cpage || $parsed_args['per_page'] != $current_per_page) {
                $comment_args = array(
                    'post_id' => get_the_ID(),
                    'orderby' => 'comment_date_gmt',
                    'order' => 'ASC',
                    'status' => 'approve',
                );

                if (is_user_logged_in()) {
                    $comment_args['include_unapproved'] = array(get_current_user_id());
                } else {
                    $unapproved_email = wp_get_unapproved_comment_author_email();

                    if ($unapproved_email) {
                        $comment_args['include_unapproved'] = array($unapproved_email);
                    }
                }

                $comments = get_comments($comment_args);

                if ('all' !== $parsed_args['type']) {
                    $comments_by_type = separate_comments($comments);
                    if (empty($comments_by_type[$parsed_args['type']])) {
                        return;
                    }

                    $_comments = $comments_by_type[$parsed_args['type']];
                } else {
                    $_comments = $comments;
                }
            }

            // Otherwise, fall back on the comments from `$wp_query->comments`.
        } else {
            if (empty($wp_query->comments)) {
                return;
            }
            if ('all' !== $parsed_args['type']) {
                if (empty($wp_query->comments_by_type)) {
                    $wp_query->comments_by_type = separate_comments($wp_query->comments);
                }
                if (empty($wp_query->comments_by_type[$parsed_args['type']])) {
                    return;
                }
                $_comments = $wp_query->comments_by_type[$parsed_args['type']];
            } else {
                $_comments = $wp_query->comments;
            }

            if ($wp_query->max_num_comment_pages) {
                $default_comments_page = get_option('default_comments_page');
                $cpage = get_query_var('cpage');
                if ('newest' === $default_comments_page) {
                    $parsed_args['cpage'] = $cpage;

                    /*
                     * When first page shows oldest comments, post permalink is the same as
                     * the comment permalink.
                     */
                } elseif (1 == $cpage) {
                    $parsed_args['cpage'] = '';
                } else {
                    $parsed_args['cpage'] = $cpage;
                }

                $parsed_args['page'] = 0;
                $parsed_args['per_page'] = 0;
            }
        }
    }

    if ('' === $parsed_args['per_page'] && get_option('page_comments')) {
        $parsed_args['per_page'] = get_query_var('comments_per_page');
    }

    if (empty($parsed_args['per_page'])) {
        $parsed_args['per_page'] = 0;
        $parsed_args['page'] = 0;
    }

    if ('' === $parsed_args['max_depth']) {
        if (get_option('thread_comments')) {
            $parsed_args['max_depth'] = get_option('thread_comments_depth');
        } else {
            $parsed_args['max_depth'] = -1;
        }
    }

    if ('' === $parsed_args['page']) {
        if (empty($overridden_cpage)) {
            $parsed_args['page'] = get_query_var('cpage');
        } else {
            $threaded = (-1 != $parsed_args['max_depth']);
            $parsed_args['page'] = ('newest' === get_option('default_comments_page')) ? get_comment_pages_count($_comments, $parsed_args['per_page'], $threaded) : 1;
            set_query_var('cpage', $parsed_args['page']);
        }
    }
    // Validation check.
    $parsed_args['page'] = (int) $parsed_args['page'];
    if (0 == $parsed_args['page'] && 0 != $parsed_args['per_page']) {
        $parsed_args['page'] = 1;
    }

    if (null === $parsed_args['reverse_top_level']) {
        $parsed_args['reverse_top_level'] = ('desc' === get_option('comment_order'));
    }

    wp_queue_comments_for_comment_meta_lazyload($_comments);

    if (empty($parsed_args['walker'])) {
        $walker = new Walker_Comment();
    } else {
        $walker = $parsed_args['walker'];
    }

    $output = $walker->paged_walk($_comments, $parsed_args['max_depth'], $parsed_args['page'], $parsed_args['per_page'], $parsed_args);

    $in_comment_loop = false;

    if ($parsed_args['echo']) {
        echo $output;
    } else {
        return $output;
    }
}
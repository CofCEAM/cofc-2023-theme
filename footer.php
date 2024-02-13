<footer id="global-footer" class="footer component">
    <div class="footer__content wrapper"
        style="background-color: <?php echo get_option('footer_background_color') ?>; color: <?php echo get_option('footer_text_color') ?>">
        <?php dynamic_sidebar('footer-sidebar'); ?>
        <div class="footer__logo">
            <?php
            $footer_logo = get_option('footer_logo');
            $footer_logo_link = get_option('footer_logo_link');
            $footer_logo_link_new_tab = get_option('footer_logo_link_new_tab');
            $target = $footer_logo_link_new_tab == 'yes' ? 'target="_blank"' : '';
            if ($footer_logo) {
                // custom footer logo was configured.  
                $footer_logo_url = wp_get_attachment_image_src($footer_logo, 'full'); // Get the URL of the image  
                if ($footer_logo_link) {
                    // custom footer logo link provided
                    ?>
                    <a href="<?php echo $footer_logo_link ?>" <?php echo $target ?>>

                        <?php
                        if ($footer_logo_url): ?>
                            <img src="<?php echo esc_url($footer_logo_url[0]); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/cofc-default-logo.png'; ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php endif; ?>
                    </a>
                    <?php
                } else {
                    // no custom footer logo link provided. use the site URL
                    ?>
                    <a href="<?php echo get_home_url() ?>" <?php echo $target ?>>
                        <?php
                        if ($footer_logo_url): ?>
                            <img src="<?php echo esc_url($footer_logo_url[0]); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/cofc-default-logo.png'; ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php endif; ?>
                    </a>
                    <?php
                }


                ?>
                <?php
            } else {
                // custom footer logo was not configured. use the site logo.
                $site_logo = get_option('site_logo'); // Get the site logo ID
                $logo_url = wp_get_attachment_image_src($site_logo, 'full'); // Get the URL of the image 
                if ($footer_logo_link) {
                    // custom footer logo link provided
                    ?>
                    <a href="<?php echo $footer_logo_link ?>" <?php echo $target ?>>
                        <?php
                        if ($logo_url): ?>
                            <img src="<?php echo esc_url($logo_url[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/cofc-default-logo.png'; ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php endif; ?>
                    </a>
                    <?php
                } else {
                    // no custom footer logo link provided. use the site URL
                    ?>
                    <a href="<?php echo get_home_url() ?>" <?php echo $target ?>>
                        <?php
                        if ($logo_url): ?>
                            <img src="<?php echo esc_url($logo_url[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/cofc-default-logo.png'; ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php endif; ?>
                    </a>
                    <?php
                }
            } ?>

        </div>
        <?php if (!empty(get_option('primary_contact_name')) or !empty(get_option('primary_contact_address')) or !empty(get_option('primary_contact_phone')) or !empty(get_option('primary_contact_email'))) { ?>
            <div class="footer__copy">

                <?php if (!empty(get_option('primary_contact_name'))) { ?>
                    <p id="primary-contact--name">
                        <?php echo get_option('primary_contact_name'); ?>
                    </p>
                <?php } ?>

                <p>

                    <?php if (!empty(get_option('primary_contact_address'))) { ?>
                        <span id="primary-contact--address">
                            <?php echo get_option('primary_contact_address'); ?>
                        </span>
                    <?php } ?>
                    <?php if (!empty(get_option('primary_contact_phone'))) { ?>
                        <span class="link-divider"
                            style="background-color: <?php echo get_option('footer_text_color') ?>"></span>
                        <a id="primary-contact--phone" href="tel:<?php echo get_option('primary_contact_phone') ?>"
                            class="menu-tertiary" style="color: <?php echo get_option('footer_text_color') ?>">
                            <span class="text">
                                <?php echo get_option('primary_contact_phone') ?>
                            </span>
                        </a>
                    <?php } ?>

                    <?php if (!empty(get_option('primary_contact_email'))) { ?>
                        <span class="link-divider"
                            style="background-color: <?php echo get_option('footer_text_color') ?>"></span>
                        <a id="primary-contact--email" href="mailto:<?php echo get_option('primary_contact_email') ?>"
                            style="color: <?php echo get_option('footer_text_color') ?>" class="menu-tertiary">
                            <span class="text">
                                <?php echo get_option('primary_contact_email') ?>
                            </span>
                        </a>
                    <?php } ?>

                </p>
                <p style="margin-bottom: 0"><a href="https://charleston.edu" aria-label="College of Charleston Home Page"
                        target="_blank" style="color: <?php echo get_option('footer_text_color') ?>">charleston.edu</a></p>
            </div>
        <?php } ?>


        <div class="footer__bar" style="background-color: <?php echo get_option('footer_bar_background_color') ?>; ">
            <div class="footer__copyright" style="color: <?php echo get_option('footer_bar_text_color') ?>;">
                Copyright © 2023 College of Charleston. <br />All Rights Reserved.
            </div>
            <?php
            $accounts = array(
                array(
                    'label' => 'Facebook',
                    'slug' => 'facebook',
                    'link' => get_option('facebook'),
                    'icon' => 'brei-icon-social-facebook'
                ),
                array(
                    'label' => 'Twitter',
                    'slug' => 'twitter',
                    'link' => get_option('twitter'),
                    'icon' => 'brei-icon-social-twitter'
                ),
                array(
                    'label' => 'LinkedIn',
                    'slug' => 'linkedin',
                    'link' => get_option('linkedin'),
                    'icon' => 'brei-icon-social-linkedin'
                ),
                array(
                    'label' => 'YouTube',
                    'slug' => 'youtube',
                    'link' => get_option('youtube'),
                    'icon' => 'brei-icon-social-youtube'
                ),
                array(
                    'label' => 'TikTok',
                    'slug' => 'tiktok',
                    'link' => get_option('tiktok'),
                    'icon' => 'brei-icon-social-tiktok'
                ),
                array(
                    'label' => 'Instagram',
                    'slug' => 'instagram',
                    'link' => get_option('instagram'),
                    'icon' => 'brei-icon-social-instagram'
                ),
                array(
                    'label' => 'Email Address',
                    'slug' => 'email',
                    'link' => get_option('email'),
                    'icon' => 'brei-icon-email'
                ),
                array(
                    'label' => 'RSS Feed',
                    'slug' => 'rss',
                    'link' => get_option('rss'),
                    'icon' => 'brei-icon-social-rss'
                )
            );
            ?>
            <?php if (atLeastOneAccountLinkPopulated($accounts)) { ?>
                <div class="footer__social">
                    <div class="social-links">
                        <ul class="social-links__list">
                            <?php
                            foreach ($accounts as $account) {
                                $slug = $account['slug'];
                                $link = $account['link'];
                                $label = $account['label'];
                                $icon = $account['icon'];
                                $class = empty($link) ? "social-links__item is-hidden" : "social-links__item";
                                if ($slug == 'email') {
                                    $link = 'mailto:' . $link;
                                }
                                ?>
                                <li class="<?php echo $class ?>" id="social-media-footer-link-<?php echo $slug ?>">
                                    <a style="color: <?php echo get_option('footer_bar_text_color') ?>;"
                                        href="<?php echo $link ?>" class="social-links__link" aria-label="<?php echo $label ?>"
                                        target="_blank">
                                        <svg style="color: <?php echo get_option('footer_bar_text_color') ?>;"
                                            class="brei-icon <?php echo $icon ?>" focusable="false">
                                            <use href="#<?php echo $icon ?>"></use>
                                        </svg>
                                    </a>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="footer__copyright--sm">
            Copyright © 2023 College of Charleston. <br />All Right Reserved.
        </div>

    </div>

</footer>

<?php
wp_footer();
?>
</body>

</html>
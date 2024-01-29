<?php

/**
 * Block Name: CofC Post Grid
 * Description: Display a grid of posts with optional filters applied
 */
function render_cofctheme_post_grid($attributes): string
{
    global $post;
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $categories = isset($attributes['categories']) ? $attributes['categories'] : [];
    $tags = isset($attributes['tags']) ? $attributes['tags'] : [];
    $limit = isset($attributes['limit']) ? $attributes['limit'] : 10;
    $offset = isset($attributes['offset']) ? $attributes['offset'] : 0;
    $columns = isset($attributes['columns']) ? $attributes['columns'] : 3;
    $useFullWidth = isset($attributes['useFullWidth']) ? $attributes['useFullWidth'] : false;
    $displayExcerpt = isset($attributes['displayExcerpt']) ? $attributes['displayExcerpt'] : true;
    $displayPublishDate = isset($attributes['displayPublishDate']) ? $attributes['displayPublishDate'] : true;
    $displayAuthor = isset($attributes['displayAuthor']) ? $attributes['displayAuthor'] : true;
    $includeLink = isset($attributes['includeLink']) ? $attributes['includeLink'] : false;
    $linkNewTab = isset($attributes['linkNewTab']) ? $attributes['linkNewTab'] : false;
    $linkUri = isset($attributes['linkUri']) ? $attributes['linkUri'] : '';
    $linkText = isset($attributes['linkText']) ? $attributes['linkText'] : '';
    // Query posts based on attributes
    $args = array(
        'category__in' => $categories,
        'tag__in' => $tags,
        'posts_per_page' => $limit,
        'offset' => $offset,
    );
    $query = new WP_Query($args);

    $columnsToSizeClassMap = array(1 => "", 2 => "medium-6", 3 => "medium-4", 4 => "medium-3");
    $postSizeClass = $columnsToSizeClassMap[$columns];
    if ($useFullWidth) {
        $wideClass = "card-news--wide";
    } else {
        $wideClass = "";
    }
    // Build the output HTML
    $output = '<section class="news-content news-content--latest news-content--single component">'; //section

    $output .= '<div class="cell xsmall-12 news-content__home"><h2 class="font-h2">' . $title . '</h2><hr /></div>';

    $output .= '<div class="news-content__cards grid-x grid-margin-x grid-margin-y">'; // 0 

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="cell xsmall-12 ' . $postSizeClass . ' cofc-post-grid-item" >'; // 1
            $output .= '<div class="card-news ' . $wideClass . '" itemScope itemType="https://schema.org/NewsArticle">'; // 2
            // Get the featured image
            if (has_post_thumbnail()) {
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                if (is_array($featured_image)) {
                    $featured_image_url = $featured_image[0];
                    $featured_image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                    $output .= '<figure class="card-news__figure" >';
                    $output .= '<img src="' . $featured_image_url . '" alt="' . $featured_image_alt . '" class="card-news__image" itemprop="image" width="926" height="695"></img>';
                    $output .= '</figure>';
                }
            }

            $output .= '<div class="card-news__wrapper">'; //3 
            $output .= '<div class="card-news__content">'; // 4
            $output .= '<p class="card-news__heading font-h4"><span itemprop="headline">' . get_the_title() . '</span></p>';
            if ($displayExcerpt) {
                $output .= '<p class="rail-news__copy">' . get_the_excerpt() . '</p>';
            }
            if ($displayPublishDate) {
                $output .= '<p class="card-news__date card-icon">';
                $output .= '<svg class="brei-icon brei-icon-calendar" focusable="false">';
                $output .= '<use href="#brei-icon-calendar"></use>';
                $output .= '</svg>';
                $output .= '<span itemprop="dateline">';
                $output .= get_the_date('F j, Y', $post);
                $output .= '</span>';
                $output .= '</p>';
            }
            if ($displayAuthor) {
                $output .= '<p class="card-news__author card-icon">';
                $output .= '<svg class="brei-icon brei-icon-avatar" focusable="false">';
                $output .= '<use href="#brei-icon-avatar"></use>';
                $output .= '</svg>';
                $output .= '<span itemprop="author">by ' . get_the_author_meta('display_name', $post->post_author) . '</span>';
                $output .= '</p>';
            }

            $output .= '</div>'; //4 
            $output .= '<a href="' . get_the_permalink() . '" title="open this post" class="card-news__button">'; //5
            $output .= '<p class="btn btn-card" aria-hidden="true">';
            $output .= '<span class="text-arrow">';
            $output .= '<svg class="brei-icon brei-icon-arrows" focusable="false">';
            $output .= ' <use href="#brei-icon-arrows"></use>';
            $output .= '</svg>';
            $output .= '<svg class="brei-icon brei-icon-arrows-arrow" focusable="false">';
            $output .= '<use href="#brei-icon-arrows-arrow"></use>';
            $output .= '</svg>';
            $output .= '</span>';
            $output .= '</p>';
            $output .= '</a>'; // 5
            $output .= '</div>'; // 3

            $output .= '</div>'; //2
            $output .= '</div>'; // 1  
        }
    }
    $output .= '</div>'; // 0 

    if ($includeLink) {
        $output .= '<div class="button-dotted-line">';
        $target = "";
        if ($linkNewTab) {
            $target = 'target="_blank"';
        }
        $output .= '<a ' . $target . 'href="' . $linkUri . '" class="btn btn--primary">';
        $output .= '<span class="text">' . $linkText . '</span>';
        $output .= '</a> ';
        $output .= '<!--span class="btn__icon"></span-->';
        $output .= '</div>';
    }

    $output .= '</section>'; // section 

    return $output;
}
function register_cofctheme_post_grid(): void
{
    register_block_type(
        __DIR__,
        array(
            'render_callback' => 'render_cofctheme_post_grid'
        )
    );
}


add_action('init', 'register_cofctheme_post_grid');
<?php

/**
 * Block Name: CofC Tag Grid
 * Description: Display a grid of available tags, where each tag can have a specified featured image,
 * a description, and a name (provided via input). The only thing we can pull automatically from 
 * tags is their name and their slug; images must be provided for each. 
 * 
 * This is being created as a reusable solution to the problem of displaying 
 * The College Today's recent magazine issues, where issues are tags like 2022-summer, 2023-winter. 
 * Each of those issues (tags) will link to /tag/<tag-slug> and is to be displayed with a featured 
 * image (the magazine cover image). 
 */
function render_cofctheme_tag_grid($attributes): string
{
    global $post;

    /* tags data structure 
    array(
        array(
            slug => tag slug
            name => tag display name 
            link => tag link 
            image => array(
                url => image url 
                alt => image alt text 
            )
            description => tag description
        ),
        array(
            lug => tag slug
            name => tag display name 
            link => tag link 
            image => array(
                url => image url 
                alt => image alt text 
            )
            description => tag description
        ), .... 
    )
    */

    $title = $attributes['title'];
    $tags = $attributes['tags'];
    $columns = $attributes['columns'];
    $includeLink = $attributes['includeLink'];
    $linkNewTab = $attributes['linkNewTab'];
    $linkUri = $attributes['linkUri'];
    $linkText = $attributes['linkText'];


    $columnsToSizeClassMap = array(1 => "", 2 => "medium-6", 3 => "medium-4", 4 => "medium-3");
    $sizeClass = $columnsToSizeClassMap[$columns];


    $output = '<section class="news-content news-content--latest news-content--single component">'; //1
    $output .= '<div class="aggregate__subset">'; // 2
    $output .= '<div class="row level__row grid-x grid-margin-x grid-margin-y">'; //3 
    $output .= '<div class="content xsmall-12 cell"><h2 class="aggregate__latest font-h1">' . $title . '</h2><hr>';
    $output .= '</div>';
    foreach ($tags as $tag) {
        $output .= '<div class="aggregate__content xsmall-12 medium-6 large-4 cell">';
        $output .= '<div class="card-magazine"> ';
        if (!empty($tag['image']['url'])) {
            $output .= '<figure class="card-magazine__figure">';
            $output .= '<img src="' . $tag['image']['url'] . '" alt="' . $tag['image']['alt'] . '" class="card-magazine__image" itemprop="image" width="339" height="400">';
            $output .= '</figure> ';
        }
        $output .= '<div class="card-magazine__button">';
        $output .= '<p class="btn btn--primary"><span class="text">' . $tag['name'] . '</span></p>';
        $output .= '</div>';
        $output .= '<a href="' . $tag['link'] . '" class="card-magazine__link"><span class="show-for-sr">Read more about "' . $tag['name'] . '</span></a> ';
        $output .= '</div>';
        $output .= '</div>';
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

    $output .= '</div>'; //3
    $output .= '</div>'; // 2
    $output .= '</section>'; // 1

    return $output;
}
function register_cofctheme_tag_grid(): void
{
    register_block_type(
        __DIR__,
        array(
            'render_callback' => 'render_cofctheme_tag_grid'
        )
    );
}


add_action('init', 'register_cofctheme_tag_grid');

?>
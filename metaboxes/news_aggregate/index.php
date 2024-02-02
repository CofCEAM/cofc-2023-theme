<?php

/* Custom meta boxes for the Fitlerable News Aggregate template */

function filterable_news_aggregate_info_callback($post)
{
    ?>
    <p>The News Aggregate template is automatically populated based purely on the details you specify below. Adding content
        above in the editor will not do anything, because the structure of this template does not include WYSIWYG / block
        editor content. The options below will allow you to give the reader tools to filter posts on their own.
        If you want to display a pre-filtered aggregate of posts based on selected filters, you should use the Prefiltered
        News Aggregate template.
    </p>

    <?php
}


function filterable_categories_meta_box_callback($post)
{

    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_categories = get_categories();
    $selected_filterable_category_ids = get_post_meta($post->ID, 'filterable_news_aggregate_filterable_category_ids', true);
    // if string, convert to array
    if (!is_array($selected_filterable_category_ids)) {
        $selected_filterable_category_ids = array($selected_filterable_category_ids);
    }
    // display form allowing selection of multiple categories
    ?>
    <label for="filterable_news_aggregate_filterable_category_ids">Select Categories That Reader Can Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="filterable_news_aggregate_filterable_category_ids"
        name="filterable_news_aggregate_filterable_category_ids[]">
        <?php
        foreach ($all_categories as $category) {
            // if this category is in the list of selected categories, mark it as selected
            $selected = in_array($category->term_id, $selected_filterable_category_ids) ? 'selected' : '';
            ?>
            <option value="<?php echo $category->term_id ?>" <?php echo $selected ?>>
                <?php echo $category->name ?>
            </option>
            <?php
        }
        ?>
    </select>
    <?php
}

// do same thing for tags
function filterable_tags_meta_box_callback($post)
{
    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_tags = get_tags();
    $selected_filterable_tag_ids = get_post_meta($post->ID, 'filterable_news_aggregate_filterable_tag_ids', true);

    // if string, convert to array
    if (!is_array($selected_filterable_tag_ids)) {
        $selected_filterable_tag_ids = array($selected_filterable_tag_ids);
    }

    // display form allowing selection of multiple categories
    ?>
    <label for="filterable_news_aggregate_filterable_tag_ids">Select Tags That Reader Can Filter By </label>
    <select multiple class="widefat" style="min-height: 200px" id="filterable_news_aggregate_filterable_tag_ids"
        name="filterable_news_aggregate_filterable_tag_ids[]">
        <?php
        foreach ($all_tags as $tag) {
            // if this tag is in the list of selected tags, mark it as selected
            $selected = in_array($tag->term_id, $selected_filterable_tag_ids) ? 'selected' : '';
            ?>
            <option value="<?php echo $tag->term_id ?>" <?php echo $selected ?>>
                <?php echo $tag->name ?>
            </option>
            <?php
        }
        ?>
    </select>
    <?php
}

// filterable years - this is a list of years to filter by
function filterable_years_meta_box_callback($post)
{
    // get current year and previous 10 years
    $current_year = date('Y');
    $years = array();
    for ($i = 0; $i < 10; $i++) {
        $years[] = $current_year - $i;
    }
    $selected_filterable_years = get_post_meta($post->ID, 'filterable_news_aggregate_filterable_years', true);

    // if string, convert to array
    if (!is_array($selected_filterable_years)) {
        $selected_filterable_years = array($selected_filterable_years);
    }


    ?>
    <label for="filterable_news_aggregate_filterable_years">Select Years That Reader Can Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="filterable_news_aggregate_filterable_years"
        name="filterable_news_aggregate_filterable_years[]">
        <?php
        foreach ($years as $year) {
            // if this tag is in the list of selected tags, mark it as selected
            $selected = in_array($year, $selected_filterable_years) ? 'selected' : '';
            ?>
            <option value="<?php echo $year ?>" <?php echo $selected ?>>
                <?php echo $year ?>
            </option>
            <?php
        }
        ?>
    </select>
    <?php
}

// simple meta box for filter headline 
function filter_headline_meta_box_callback($post)
{
    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $filter_headline = get_post_meta($post->ID, 'filterable_news_aggregate_filter_headline', true);
    // display form allowing selection of multiple categories
    ?>

    <input type="text" class="widefat" id="filterable_news_aggregate_filter_headline"
        name="filterable_news_aggregate_filter_headline" value="<?php echo $filter_headline ?>">
    <?php
}


function save_filterable_news_aggregate_meta_boxes($post_id)
{
    // save filterable_category_ids - this is a list 

    update_array_meta($post_id, key: 'filterable_news_aggregate_filterable_category_ids');
    update_array_meta($post_id, key: 'filterable_news_aggregate_filterable_tag_ids');
    update_array_meta($post_id, key: 'filterable_news_aggregate_filterable_years');

    // save filter_headline - this is a string
    if (isset($_POST['filterable_news_aggregate_filter_headline'])) {
        update_post_meta(
            $post_id,
            'filterable_news_aggregate_filter_headline',
            $_POST['filterable_news_aggregate_filter_headline']
        );
    }

}
add_action('save_post', 'save_filterable_news_aggregate_meta_boxes');

function add_filterable_news_aggregate_meta_boxes()
{
    global $post;

    add_meta_box(
        'filterable_news_aggregate_info_meta_box',
        'Template Information (News Aggregate)',
        'filterable_news_aggregate_info_callback',
        'page',
        'normal',
        'default'
    );

    // Add featured media carousel header meta box. 
    add_meta_box(
        'filterable_news_aggregate_filterable_category_ids_meta_box',
        'Filterable Categories (what categories can reader filter by?)',
        'filterable_categories_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'filterable_news_aggregate_filterable_tag_ids_meta_box',
        'Filterable Tags (what tags can reader filter by?)',
        'filterable_tags_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'filterable_news_aggregate_filterable_years_meta_box',
        'Filterable Years (what years can reader filter by?)',
        'filterable_years_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'filterable_news_aggregate_filter_headline_meta_box',
        'Filter Headline (what should the filter section be called?)',
        'filter_headline_meta_box_callback',
        'page',
        'normal',
        'default'
    );

}
add_action('add_meta_boxes', 'add_filterable_news_aggregate_meta_boxes');



<?php

/* Custom meta boxes for the Prefiltered News Aggregate template */

function prefiltered_news_aggregate_info_callback($post)
{
    ?>
    <p>The Prefiltered News Aggregate template is automatically populated based purely on the details you specify below.
        Adding content above in the editor will not do anything, because the structure of this template does not include
        WYSIWYG / block editor content. This template does not offer a filter option for the reader, and is pre-filtered
        based on the options you select below.</p>
    <?php
}

function prefiltered_categories_meta_box_callback($post)
{

    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_categories = get_categories();
    $selected_category_ids = get_post_meta($post->ID, 'prefiltered_news_aggregate_category_ids', true);
    // if string, convert to array
    if (!is_array($selected_category_ids)) {
        $selected_category_ids = array($selected_category_ids);
    }
    // display form allowing selection of multiple categories
    ?>
    <label for="prefiltered_news_aggregate_category_ids">Select Categories to Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="prefiltered_news_aggregate_category_ids"
        name="prefiltered_news_aggregate_category_ids[]">
        <?php
        foreach ($all_categories as $category) {
            // if this category is in the list of selected categories, mark it as selected
            $selected = in_array($category->term_id, $selected_category_ids) ? 'selected' : '';
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

function prefiltered_news_aggregate_include_left_rail_callback($post)
{
    $include_left_rail = get_post_meta($post->ID, 'prefiltered_news_aggregate_include_left_rail', true);
    ?>
    <p>If you want to include a left rail, check the box below. To populate the left rail, you'll need to add widgets to the
        "Prefiltered News Aggregate - Left Rail / Sidebar Area" widget area in Appearance > Widgets </p>
    <label for="prefiltered_news_aggregate_include_left_rail">Include Left Rail</label>
    <input type="checkbox" id="prefiltered_news_aggregate_include_left_rail"
        name="prefiltered_news_aggregate_include_left_rail" <?php echo $include_left_rail ? 'checked' : '' ?>>
    <?php
}

// do same thing for tags
function prefiltered_tags_meta_box_callback($post)
{
    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_tags = get_tags();
    $selected_tag_ids = get_post_meta($post->ID, 'prefiltered_news_aggregate_tag_ids', true);

    // if string, convert to array
    if (!is_array($selected_tag_ids)) {
        $selected_tag_ids = array($selected_tag_ids);
    }

    // display form allowing selection of multiple categories
    ?>
    <label for="prefiltered_news_aggregate_tag_ids">Select Tags to Filter By </label>
    <select multiple class="widefat" style="min-height: 200px" id="prefiltered_news_aggregate_tag_ids"
        name="prefiltered_news_aggregate_tag_ids[]">
        <?php
        foreach ($all_tags as $tag) {
            // if this tag is in the list of selected tags, mark it as selected
            $selected = in_array($tag->term_id, $selected_tag_ids) ? 'selected' : '';
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
function prefiltered_years_meta_box_callback($post)
{
    // get current year and previous 10 years
    $current_year = date('Y');
    $years = array();
    for ($i = 0; $i < 10; $i++) {
        $years[] = $current_year - $i;
    }
    $selected_years = get_post_meta($post->ID, 'prefiltered_news_aggregate_years', true);

    // if string, convert to array
    if (!is_array($selected_years)) {
        $selected_years = array($selected_years);
    }


    ?>
    <label for="prefiltered_news_aggregate_years">Select Years That Reader Can Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="prefiltered_news_aggregate_years"
        name="prefiltered_news_aggregate_years[]">
        <?php
        foreach ($years as $year) {
            // if this tag is in the list of selected tags, mark it as selected
            $selected = in_array($year, $selected_years) ? 'selected' : '';
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


function save_prefiltered_news_aggregate_meta_boxes($post_id)
{
    // save category_ids - this is a list 

    update_array_meta($post_id, key: 'prefiltered_news_aggregate_category_ids');
    update_array_meta($post_id, key: 'prefiltered_news_aggregate_tag_ids');
    update_array_meta($post_id, key: 'prefiltered_news_aggregate_years');

    // save include left rail - boolean 
    if (isset($_POST['prefiltered_news_aggregate_include_left_rail'])) {
        update_post_meta($post_id, 'prefiltered_news_aggregate_include_left_rail', true);
    } else {
        update_post_meta($post_id, 'prefiltered_news_aggregate_include_left_rail', false);
    }
}
add_action('save_post', 'save_prefiltered_news_aggregate_meta_boxes');

function add_prefiltered_news_aggregate_meta_boxes()
{
    global $post;

    add_meta_box(
        'prefiltered_news_aggregate_info_meta_box',
        'Template Information (News Aggregate)',
        'prefiltered_news_aggregate_info_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'prefiltered_news_aggregate_include_left_rail_meta_box',
        'Include Left Rail',
        'prefiltered_news_aggregate_include_left_rail_callback',
        'page',
        'normal',
        'default'
    );

    // Add featured media carousel header meta box. 
    add_meta_box(
        'prefiltered_news_aggregate_category_ids_meta_box',
        'Pre-Filtered Categories',
        'prefiltered_categories_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'prefiltered_news_aggregate_tag_ids_meta_box',
        'Pre-Filtered Tags',
        'prefiltered_tags_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'prefiltered_news_aggregate_years_meta_box',
        'Pre-Filtered Years',
        'prefiltered_years_meta_box_callback',
        'page',
        'normal',
        'default'
    );

}
add_action('add_meta_boxes', 'add_prefiltered_news_aggregate_meta_boxes');


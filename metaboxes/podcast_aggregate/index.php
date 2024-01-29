<?php

/* Custom meta boxes for the Podcast Aggregate template */

function podcast_aggregate_info_callback($post)
{
    ?>
    <p>The Podcast Aggregate template is automatically populated based purely on the details you specify below. Adding
        content
        above in the editor will not do anything, because the structure of this template does not include WYSIWYG / block
        editor content. The options below will allow you to give the reader tools to filter podcast posts on their own.
        If you just want to display a pre-filtered aggregate of posts based on selected filters, you should use the
        Prefiltered News Aggregate template.
    </p>
    <p><strong>NOTE: This template is only useful if you have multiple categories or tags that are used exclusively for
            podcast posts. If you do not have such categories or tags, there's nothing filterable for visitors, so you
            should use the News Aggregate template instead, and just include your podcast category/tag in the filterable
            categories/tags.
        </strong>
    </p>
    <p>
        This Podcast Aggregate template differs from the News Aggregate template in that it allows you to first prefilter
        only the podcast stories (using a specified tag or category), which the reader can then further filter using the
        filter options you select. This
        template also adds a Podcast Platforms section beneath the filter section. This section is populated by the Podcast
        Platforms configured in Appearance > Customize Podcast Platforms. If you do not see this section, you may need to
        add some Podcast Platform links in that menu.
    </p>
    <?php
}

function podcast_aggregate_podcast_main_filter_callback($post)
{
    // filter type: tag or category (radio)

    ?>
    <p>This will be the first filter that applies to all results in this template. The user does not
        control or see this filter as an option. </p>
    <label for="podcast_aggregate_podcast_main_filter_type">Filter Podcasts By Type:</label>
    <?php
    $currentType = get_post_meta($post->ID, 'podcast_aggregate_podcast_main_filter_type', true);
    $currentValue = get_post_meta($post->ID, 'podcast_aggregate_podcast_main_filter_value', true);

    if (!$currentType) {
        $currentType = 'tag';
    }
    ?>
    <select class="widefat" id="podcast_aggregate_podcast_main_filter_type" value="<?php echo $currentType ?>"
        onchange="updateMainFilterValueSelector({filterType: this.value})"
        name="podcast_aggregate_podcast_main_filter_type">
        <option value="tag" <?php echo $currentType == "tag" ? "selected" : "" ?>>Tag</option>
        <option value="category" <?php echo $currentType == "category" ? "selected" : "" ?>>Category</option>
    </select>
    <label for="podcast_aggregate_podcast_main_filter_value">Filter Value (type the name of either the category or
        tag):</label>
    <select class="widefat" id="podcast_aggregate_podcast_main_filter_value"
        name="podcast_aggregate_podcast_main_filter_value" onchange="updateMainFilterValue({filterValue: this.value})">
        <?php if ($currentType == 'tag') {
            $all_tags = get_tags();
            foreach ($all_tags as $tag) {
                $selected = $tag->term_id == $currentValue ? 'selected' : '';
                ?>
                <option value="<?php echo $tag->term_id ?>" <?php echo $selected ?>>
                    <?php echo $tag->name ?>
                </option>
                <?php
            }
        } else {
            $all_categories = get_categories();
            foreach ($all_categories as $category) {
                $selected = $category->term_id == $currentValue ? 'selected' : '';
                ?>
                <option value="<?php echo $category->term_id ?>" <?php echo $selected ?>>
                    <?php echo $category->name ?>
                </option>
                <?php
            }
            ?>

        <?php }
        ?>
    </select>
    <?php

    $all_categories = get_categories();
    $all_tags = get_tags();
    // build a JSON object of {name: category name, id: category id} for each category, store in array
    $categories_json = array();
    foreach ($all_categories as $category) {
        $categories_json[] = array('name' => $category->name, 'term_id' => $category->term_id);
    }
    // build a JSON object of {name: tag name, id: tag id} for each tag, store in array
    $tags_json = array();
    foreach ($all_tags as $tag) {
        $tags_json[] = array('name' => $tag->name, 'term_id' => $tag->term_id);
    }
    // store these JSON values in hidden inputs that can be parsed by javascript in metaboxes/index.js
    $categories_json_encoded = htmlspecialchars(json_encode($categories_json));
    $tags_json_encoded = htmlspecialchars(json_encode($tags_json));
    ?>
    <input type="hidden" id="podcast_aggregate_categories_json" value="<?php echo $categories_json_encoded ?>">
    <input type="hidden" id="podcast_aggregate_tags_json" value="<?php echo $tags_json_encoded ?>">

    <?php
}


function podcast_aggregate_filterable_categories_meta_box_callback($post)
{

    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_categories = get_categories();
    $selected_filterable_category_ids = get_post_meta($post->ID, 'podcast_aggregate_filterable_category_ids', true);
    // if string, convert to array
    if (!is_array($selected_filterable_category_ids)) {
        $selected_filterable_category_ids = array($selected_filterable_category_ids);
    }
    // display form allowing selection of multiple categories
    ?>
    <label for="podcast_aggregate_filterable_category_ids">Select Categories That Reader Can Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="podcast_aggregate_filterable_category_ids"
        name="podcast_aggregate_filterable_category_ids[]">
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
function podcast_aggregate_filterable_tags_meta_box_callback($post)
{
    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $all_tags = get_tags();
    $selected_filterable_tag_ids = get_post_meta($post->ID, 'podcast_aggregate_filterable_tag_ids', true);

    // if string, convert to array
    if (!is_array($selected_filterable_tag_ids)) {
        $selected_filterable_tag_ids = array($selected_filterable_tag_ids);
    }

    // display form allowing selection of multiple categories
    ?>
    <label for="podcast_aggregate_filterable_tag_ids">Select Tags That Reader Can Filter By </label>
    <select multiple class="widefat" style="min-height: 200px" id="podcast_aggregate_filterable_tag_ids"
        name="podcast_aggregate_filterable_tag_ids[]">
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
function podcast_aggregate_filterable_years_meta_box_callback($post)
{
    // get current year and previous 10 years
    $current_year = date('Y');
    $years = array();
    for ($i = 0; $i < 10; $i++) {
        $years[] = $current_year - $i;
    }
    $selected_filterable_years = get_post_meta($post->ID, 'podcast_aggregate_filterable_years', true);

    // if string, convert to array
    if (!is_array($selected_filterable_years)) {
        $selected_filterable_years = array($selected_filterable_years);
    }


    ?>
    <label for="podcast_aggregate_filterable_years">Select Years That Reader Can Filter By</label>
    <select multiple class="widefat" style="min-height: 200px" id="podcast_aggregate_filterable_years"
        name="podcast_aggregate_filterable_years[]">
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
function podcast_aggregate_filter_headline_meta_box_callback($post)
{
    // Add your fields here
    // display a meta box allowing selection of multiple categories
    $filter_headline = get_post_meta($post->ID, 'podcast_aggregate_filter_headline', true);
    // display form allowing selection of multiple categories
    ?>

    <input type="text" class="widefat" id="podcast_aggregate_filter_headline" name="podcast_aggregate_filter_headline"
        value="<?php echo $filter_headline ?>">
    <?php
}


function save_podcast_aggregate_meta_boxes($post_id)
{
    // save filterable_category_ids - this is a list 

    update_array_meta($post_id, key: 'podcast_aggregate_filterable_category_ids');
    update_array_meta($post_id, key: 'podcast_aggregate_filterable_tag_ids');
    update_array_meta($post_id, key: 'podcast_aggregate_filterable_years');

    if (isset($_POST['podcast_aggregate_podcast_main_filter_type'])) {
        update_post_meta(
            $post_id,
            'podcast_aggregate_podcast_main_filter_type',
            $_POST['podcast_aggregate_podcast_main_filter_type']
        );
    }

    if (isset($_POST['podcast_aggregate_podcast_main_filter_value'])) {
        update_post_meta(
            $post_id,
            'podcast_aggregate_podcast_main_filter_value',
            $_POST['podcast_aggregate_podcast_main_filter_value']
        );
    }

    // save filter_headline - this is a string
    if (isset($_POST['podcast_aggregate_filter_headline'])) {
        update_post_meta(
            $post_id,
            'podcast_aggregate_filter_headline',
            $_POST['podcast_aggregate_filter_headline']
        );
    }

}
add_action('save_post', 'save_podcast_aggregate_meta_boxes');

function add_podcast_aggregate_meta_boxes()
{
    global $post;



    add_meta_box(
        'podcast_aggregate_info_meta_box',
        'Template Information (Podcast Aggregate)',
        'podcast_aggregate_info_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'podcast_aggregate_podcast_main_filter_meta_box',
        'Podcast Main Filter (determines what is filterable by the user)',
        'podcast_aggregate_podcast_main_filter_callback',
        'page',
        'normal',
        'default'
    );

    // Add featured media carousel header meta box. 
    add_meta_box(
        'podcast_aggregate_filterable_category_ids_meta_box',
        'Filterable Categories (what categories can reader filter by?)',
        'podcast_aggregate_filterable_categories_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'podcast_aggregate_filterable_tag_ids_meta_box',
        'Filterable Tags (what tags can reader filter by?)',
        'podcast_aggregate_filterable_tags_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'podcast_aggregate_filterable_years_meta_box',
        'Filterable Years (what years can reader filter by?)',
        'podcast_aggregate_filterable_years_meta_box_callback',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'podcast_aggregate_filter_headline_meta_box',
        'Filter Headline (what should the filter section be called?)',
        'podcast_aggregate_filter_headline_meta_box_callback',
        'page',
        'normal',
        'default'
    );

}
add_action('add_meta_boxes', 'add_podcast_aggregate_meta_boxes');



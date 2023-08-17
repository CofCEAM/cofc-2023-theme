<?php
/* These functions are used to create custom meta boxes on posts to allow 
for custom data to be added, e.g. featured videos, extra featured images, featured quotes, etc. 
*/

function featured_media_carousel_description_callback($post)
{
    $featured_media_carousel_description = get_post_meta($post->ID, 'featured_media_carousel_description', true);
    ?>
    <div>
        <label for="featured_media_carousel_description">Description of featured media (text underneath media carousel,
            skipped if empty):
        </label><br />
        <textarea style="padding:.7rem; margin:0.5rem auto; width:90%;" id="featured_media_carousel_description"
            name="featured_media_carousel_description"><?php echo $featured_media_carousel_description ?></textarea><br />

        <?php
}

function featured_media_carousel_header_callback($post)
{
    $featured_media_carousel_header = get_post_meta($post->ID, 'featured_media_carousel_header', true);
    ?>
        <div>
            <label for="featured_media_carousel_header">Featured Media Carousel Header (above carousel, skipped if empty):
            </label><br />
            <input value="<?php echo $featured_media_carousel_header ?>"
                style="padding:.7rem; margin:0.5rem auto; width:90%;" id="featured_media_carousel_header"
                name="featured_media_carousel_header"><br />

            <?php
}

function featured_video_callback($post)
{
    // Retrieve the current featured video URL if it exists
    $featured_video_url = get_post_meta($post->ID, 'featured_video_url', true);
    $featured_video_title = get_post_meta($post->ID, 'featured_video_title', true);
    $featured_video_caption = get_post_meta($post->ID, 'featured_video_caption', true);

    // Output the featured video URL input field
    echo '
    <div> 
    
    <label for="featured-video-title-field">Title</label><br/>
    <input style="padding:.7rem; margin:0.5rem auto; width: 90%;" type="text"
         id="featured-video-title-field" name="featured_video_title" 
    value="' . esc_attr($featured_video_title) . '"><br/>

    <label for="featured-video-url-field">URL:</label><br/>
        <input style="padding:.7rem; margin:0.5rem auto; width: 90%;" type="text"
            id="featured-video-url-field" name="featured_video_url" 
        value="' . esc_attr($featured_video_url) . '"><br/>

    <label for="featured-video-caption-field">Caption</label><br/> 
    <textarea style="padding:.7rem; margin:0.5rem auto; width: 90%;"
         id="featured-video-caption-field" name="featured_video_caption">'
        . esc_attr($featured_video_caption) . '</textarea>
    </div>
    ';

    $file_url = get_post_meta($post->ID, 'featured_video_thumbnail', true);
    $file_upload_field_id = 'featured-video-thumbnail-upload-field';
    $upload_button_id = 'featured-video-thumbnail-upload-button';
    // Output the file upload input field
    echo '
    <label for="file-upload-field">Featured Video Thumbnail Image: </label>
    <input type="text" id="' . $file_upload_field_id . '" name="featured_video_thumbnail" 
    value="' . esc_attr($file_url) . '" readonly>
    <button type="button" id="' . $upload_button_id . '" class="button">Upload Thumbnail</button>
    ';
    wp_enqueue_media();


    // JavaScript to handle the file upload button functionality 
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function () { 
            document.getElementById('" . $upload_button_id . "')
            .addEventListener('click', (e) => {
                const fileFrame = wp.media({
                    title: 'Select or Upload File',
                    button: {
                        text: 'Use this file'
                    },
                    multiple: false  // Set to true if you want to allow multiple file uploads
                }); 
                // Handle file selection
                fileFrame.on('select', function() {
                    var attachment = fileFrame.state().get('selection').first().toJSON(); 
                    document.getElementById('" . $file_upload_field_id . "').value = attachment.url;
                }); 
                // Open the media uploader
                fileFrame.open(); 
            }, false);
        });

    </script>
    ";
}


function custom_featured_image_callback($post, $args)
{
    $featured_image_number = $args['args']['featured_image_number'];
    // Retrieve the current file URL if it exists
    $file_key = 'file_upload_featured_image_' . $featured_image_number;
    $file_url = get_post_meta($post->ID, $file_key, true);
    $file_upload_field_id = 'featured-image-' . $featured_image_number . '-file-upload-field';
    $upload_button_id = 'upload-featured-image-' . $featured_image_number . '-button';
    // Output the file upload input field
    echo '
    <label for="' . $file_upload_field_id . '">Featured Image ' . (int) $featured_image_number - 1 . ': </label>
    <input type="text" id="' . $file_upload_field_id . '" name="' . $file_key . '" 
    value="' . esc_attr($file_url) . '" readonly>
    <button type="button" id="' . $upload_button_id . '" class="button">Upload File</button>
    ';
    wp_enqueue_media();


    // JavaScript to handle the file upload button functionality 
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function () { 
            document.getElementById('" . $upload_button_id . "')
            .addEventListener('click', (e) => {
                const fileFrame = wp.media({
                    title: 'Select or Upload File',
                    button: {
                        text: 'Use this file'
                    },
                    multiple: false  // Set to true if you want to allow multiple file uploads
                }); 
                // Handle file selection
                fileFrame.on('select', function() {
                    var attachment = fileFrame.state().get('selection').first().toJSON(); 
                    document.getElementById('" . $file_upload_field_id . "').value = attachment.url;
                }); 
                // Open the media uploader
                fileFrame.open(); 
            }, false);
        });

    </script>
    ";
}

function featured_quote_callback($post)
{
    $featured_quote = get_post_meta($post->ID, 'featured_quote', true);
    $featured_quotee = get_post_meta($post->ID, 'featured_quotee', true);
    echo '
    <div>
    <label for="featured-quote-field">Featured Quote (don\'t include quotation marks): </label><br/>
    <textarea  style="padding:.7rem; margin:0.5rem auto; width:90%;" id="featured-quote-field" name="featured_quote">'
        . $featured_quote . '</textarea><br/>
    <label for="featured-quotee-field">Quotee: </label><br/>
    <input 
        value="' . $featured_quotee . '"
        style="width:50%; padding: .7rem; margin:0.5rem auto;" 
        id="featured-quotee-field" name="featured_quotee">
    </div>
    ';
}



function save_custom_meta_boxes($post_id)
{
    // save featured images 
    foreach (range(2, 5) as $num) {
        $key = 'file_upload_featured_image_' . $num;
        if (isset($_POST[$key])) {
            $featured_img_url = sanitize_url($_POST[$key]);
            update_post_meta($post_id, $key, $featured_img_url);
        }
    }

    // save carousel description (underneath carousel)
    if (isset($_POST['featured_media_carousel_description'])) {
        update_post_meta(
            $post_id,
            'featured_media_carousel_description',
            sanitize_text_field($_POST['featured_media_carousel_description'])
        );
    }
    // save carousel description (underneath carousel)
    if (isset($_POST['featured_media_carousel_header'])) {
        update_post_meta(
            $post_id,
            'featured_media_carousel_header',
            sanitize_text_field($_POST['featured_media_carousel_header'])
        );
    }

    // save featured quote 
    if (isset($_POST['featured_quote'])) {
        update_post_meta(
            $post_id,
            'featured_quote',
            sanitize_text_field($_POST['featured_quote'])
        );
    }
    if (isset($_POST['featured_quotee'])) {
        update_post_meta(
            $post_id,
            'featured_quotee',
            sanitize_text_field($_POST['featured_quotee'])
        );
    }

    // save featured video URL 
    if (isset($_POST['featured_video_url'])) {
        update_post_meta(
            $post_id,
            'featured_video_url',
            sanitize_text_field($_POST['featured_video_url'])
        );
    }
    if (isset($_POST['featured_video_title'])) {
        update_post_meta(
            $post_id,
            'featured_video_title',
            sanitize_text_field($_POST['featured_video_title'])
        );
    }
    if (isset($_POST['featured_video_caption'])) {
        update_post_meta(
            $post_id,
            'featured_video_caption',
            sanitize_text_field($_POST['featured_video_caption'])
        );
    }
    if (isset($_POST['featured_video_thumbnail'])) {
        update_post_meta(
            $post_id,
            'featured_video_thumbnail',
            sanitize_url($_POST['featured_video_thumbnail'])
        );
    }
}
add_action('save_post', 'save_custom_meta_boxes');


function add_custom_meta_boxes()
{
    // Add featured media carousel header meta box. 
    add_meta_box(
        'featured_media_carousel_header_meta_box',
        'Featured Media Carousel Header (above carousel)',
        'featured_media_carousel_header_callback',
        'post',
        'normal',
        'default'
    );
    // Add featured media carousel description meta box. 
    add_meta_box(
        'featured_media_carousel_description_meta_box',
        'Featured Media Carousel Description (under carousel)',
        'featured_media_carousel_description_callback',
        'post',
        'normal',
        'default'
    );

    // Add extra featured image meta boxes. 
    foreach (range(2, 5) as $num) {
        $args = array('featured_image_number' => $num);
        add_meta_box(
            'featured-image-' . $num,
            'Featured Image ' . $num - 1,
            'custom_featured_image_callback',
            'post',
            'normal',
            'default',
            $args
        );
    }
    // Add featured video meta box. 
    add_meta_box(
        'featured_video_meta_box',
        'Featured Video',
        'featured_video_callback',
        'post',
        'normal',
        'default'
    );





    // Add featured quote meta box. 
    add_meta_box(
        'featured_quote_meta_box',
        'Featured Quote',
        'featured_quote_callback',
        'post',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_boxes');

function custom_screen_options($hidden)
{
    $hidden = array('featured-image-2', 'featured-image-3', 'featured-image-4', 'featured-image-5');
    return $hidden;
}
add_filter('default_hidden_meta_boxes', 'custom_screen_options');
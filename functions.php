<?php


add_filter('template_include', 'load_search_template');
function load_search_template($template)
{
	if (isset($_GET['searchwp'])) {
		// searchwp search
		return locate_template('searchwp.php');
	} elseif (isset($_GET['s'])) {
		// native search
		return locate_template('search.php');
	}
	return $template;
}

function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


function cofctheme_theme_support()
{ // automatically inject dynamic title tag into head. 
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'cofctheme_theme_support');

// Register navigation menu LOCATIONS. Site editor will create menus and add them to these locations.
register_nav_menus(
	array(
		'header-navigation' => __('Header Navigation')
	)
);

// Custom paginate_links filter
function custom_pagination_links($max_num_pages, $current_page, $base_url = '', $query = null, $searchwp_pagination = false)
{
	$output = '<ul class="pagination__list clearfix" aria-label="Pagination">';
	$base_url = get_site_url() . $base_url;

	// Previous link
	$disabledLiClass = ($current_page === 1 or $current_page === $max_num_pages) ? 'pagination__item--disabled' : '';
	$disabledAnchorAttribute = 'style="pointer-events: none"';

	$output .= '<li class="pagination__item pagination__item--prev ' . $disabledLiClass . '">';
	if ($query) {
		if ($searchwp_pagination) {
			$link = $base_url . '/?swppg=' . $current_page - 1 . '&searchwp=' . $query;
		} else {
			// native search pagination
			$link = $base_url . '/page/' . $current_page - 1 . '?s=' . $query;
		}
	} else {
		$link = $base_url . '/page/' . $current_page - 1;
	}
	$output .= '<a ' . ($current_page === 1 ? $disabledAnchorAttribute : '') . ' href="' . $link . '" class="btn btn--small" aria-label="Go to the previous page"><span class="btn__icon">';
	$output .= '<svg class="brei-icon brei-icon-chevron"> <use xlink:href="#brei-icon-chevron"></use></svg>';
	$output .= '</span></a>';
	$output .= '</li>';

	// Individual page links
	$dotsAdded = false;
	for ($i = 1; $i <= $max_num_pages; $i++) {
		$itemclass = '';
		$itemstyle = '';
		$content = '';
		if ($i === $current_page) {
			// if current page, make it active, disable link
			$itemclass = 'pagination__item--active';
			$content .= '<a  ' . $disabledAnchorAttribute . ' href="#" data-page="1" class="pagination__link" tabindex="-1"><span class="show-for-sr">';
			$content .= "You're on page</span> " . $current_page . "</a>";
		} elseif (abs($i - $current_page) === 1 or abs($max_num_pages - $i) <= 2 or abs($i - 1) <= 2) {
			// if one page away from current page or close to end or beginning, show number
			if ($query) {
				if ($searchwp_pagination) {
					$link = $base_url . '/?swppg=' . $i . '&searchwp=' . $query;
				} else {
					// native search pagination
					$link = $base_url . '/page/' . $i . '?s=' . $query;
				}
			} else {
				$link = $base_url . '/page/' . $i;
			}
			$itemclass = 'pagination__item--small';
			$content .= '<a  href="' . $link . '" data-page="' . $i . '" class="pagination__link" aria-label="Page ' . $i . '">' . $i . '</a>';
		} elseif (
			abs($i - $current_page) > 1
			and abs($max_num_pages - $i) > 2
			and abs($i - 1) > 2
			and $i == floor($max_num_pages / 2)
			and !$dotsAdded
		) {
			// just show dots if  over a page away from current , within 1 page of halfway mark, 
			// and not close to end or beginning
			$content .= '<span class="pagination__span"><span>of</span><span>...</span></span>';
			$dotsAdded = true;
		} else {
			// show nothing
			$itemstyle = 'style="width:0px; min-width: 0px;"';
			$content = '';
		}

		$output .= '<li data-item="' . $i . '" class="pagination__item ' . $itemclass . '" ' . $itemstyle . '>';
		$output .= $content;
		$output .= '</li>';
	}

	// Next link 
	$output .= '<li class="pagination__item pagination__item--next ' . $disabledLiClass . '">';
	if ($query) {
		if ($searchwp_pagination) {
			$link = $base_url . '/?swppg=' . $current_page + 1 . '&searchwp=' . $query;
		} else {
			//native search (?s) pagination
			$link = $base_url . '/page/' . $current_page + 1 . '?s=' . $query;
		}
	} else {
		$link = $base_url . '/page/' . $current_page + 1;
	}
	$output .= '<a  ' . ($current_page == $max_num_pages ? $disabledAnchorAttribute : '') . ' href="' . $link . '" class="btn btn--small" aria-label="Go to the next page"><span class="btn__icon">';
	$output .= '<svg class="brei-icon brei-icon-chevron"> <use xlink:href="#brei-icon-chevron"></use></svg>';
	$output .= '</span></a>';
	$output .= '</li>';
	$output .= '</ul>';

	return $output;
}


function display_featured_post_card(
	WP_Post $post,
	bool $wide = false
) {
	$wideClass = $wide ? 'card-news--wide' : '';
	?>

	<div class="card-news <?php echo $wideClass ?> card-news--featured cofc-post-grid-item" itemscope
		itemtype="https://schema.org/NewsArticle">
		<?php
		$featured_image_id = get_post_thumbnail_id($post->ID);
		$featured_image = get_post($featured_image_id);
		if (!is_null($featured_image)) {
			// conditionally display featured image
			$featured_image_title = $featured_image->post_title;
			$featured_image_url = get_the_post_thumbnail_url($post);
			?>
			<figure class="card-news__figure">
				<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>" class="card-news__image"
					itemprop="image" width="926" height="695" />
			</figure>
			<?php
		}
		?>
		<div class="card-news__wrapper">
			<div class="card-news__content">
				<p class="card-news__heading font-h3"><span itemprop="headline">
						<?php echo $post->post_title ?>
					</span></p>
				<p class="card-news__date card-icon">
					<svg class="brei-icon brei-icon-calendar" focusable="false">
						<use href="#brei-icon-calendar"></use>
					</svg>
					<span itemprop="dateline">
						<?php echo get_the_date('F j, Y', $post) ?>
					</span>
				</p>
				<p class="card-news__author card-icon">
					<svg class="brei-icon brei-icon-avatar" focusable="false">
						<use href="#brei-icon-avatar"></use>
					</svg>
					<span itemprop="author">by
						<?php echo get_the_author_meta('display_name', $post->post_author) ?>
					</span>
				</p>
			</div>

			<a href="<?php echo get_post_permalink($post) ?>" title="Read more about <?php echo $post->post_title ?>"
				class="card-news__button">
				<p class="btn btn-card" aria-hidden="true">
					<span class="text-arrow">
						<svg class="brei-icon brei-icon-arrows" focusable="false">
							<use href="#brei-icon-arrows"></use>
						</svg>

						<svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
							<use href="#brei-icon-arrows-arrow"></use>
						</svg>
					</span>
				</p>
			</a>
		</div>
		<a href="<?php echo get_post_permalink($post) ?>" class="child-page-grid__link"><span class="show-for-sr">
				Read more about "
				<?php echo $post->post_title ?>"
			</span></a>
	</div>
	<?php
}

function display_single_post_card(
	WP_Post $post,
	bool $wide = false,
	bool $display_excerpt = false,
	bool $display_published_date = true,
	bool $display_author = true,
	string $medium_screen_class = '',
	string $large_screen_class = '',
	string $title_heading_size = 'h4'
) {

	/* 
																																	 $medium_screen_class is optional. Default is medium-6. Can be "medium-<int> where int
																																	 is a number between 1 and 12, indicating a proportion of container width to take up
																																	 on medium screens (over 48em, below 64em). medium-6 means each item is 1/2 container width. 
																																	 
																																	 $large_screen_class is optional. Default is empty. Can be "large-<int> where int
																																	 is a number between 1 and 12, indicating a proportion of container width to take up
																																	 on large screens (over 64em). Empty means large screen inherits from medium screen styles.

																																	 Cards are full width on mobile by default. No adjustment there.
																																	 */
	$wideclass = $wide ? 'card-news--wide' : '';
	?>
	<div class="cell xsmall-12  <?php echo $medium_screen_class ?> <?php echo $large_screen_class ?> cofc-post-grid-item">
		<div class="card-news <?php echo $wideclass ?>" itemscope itemtype="https://schema.org/NewsArticle">
			<?php
			$featured_image_id = get_post_thumbnail_id($post->ID);
			$featured_image = get_post($featured_image_id);
			if (!is_null($featured_image)) {
				// conditionally display featured image
				$featured_image_title = $featured_image->post_title;
				$featured_image_url = get_the_post_thumbnail_url($post->ID);
				?>
				<figure data-featured-image-id="<?php echo $featured_image_id ?>" class="card-news__figure">
					<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>"
						class="card-news__image" itemprop="image" width="926" height="695" />
				</figure>
			<?php } ?>

			<div class="card-news__wrapper">
				<div class="card-news__content">
					<p class="card-news__heading font-<?php echo $title_heading_size ?>">
						<span itemprop="headline">
							<?php echo $post->post_title ?>
						</span>
					</p>
					<?php
					if ($display_excerpt) { ?>
						<p class="rail-news__copy">
							<?php echo $post->post_excerpt ?>
						</p>
						<?php
					}
					if ($display_published_date) { ?>
						<p class="card-news__date card-icon">
							<svg class="brei-icon brei-icon-calendar" focusable="false">
								<use href="#brei-icon-calendar"></use>
							</svg>
							<span itemprop="dateline">
								<?php echo get_the_date('F j, Y', $post) ?>
							</span>
						</p>
						<?php
					}
					if ($display_author) { ?>
						<p class="card-news__author card-icon">
							<svg class="brei-icon brei-icon-avatar" focusable="false">
								<use href="#brei-icon-avatar"></use>
							</svg>
							<span itemprop="author">by
								<?php echo get_the_author_meta('display_name', $post->post_author) ?>
							</span>
						</p>
						<?php
					} ?>
				</div>

				<a href="<?php echo get_permalink($post); ?>" title="Read more about <?php echo $post->post_title ?>"
					class="card-news__button">
					<p class="btn btn-card" aria-hidden="true">
						<span class="text-arrow">
							<svg class="brei-icon brei-icon-arrows" focusable="false">
								<use href="#brei-icon-arrows"></use>
							</svg>

							<svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
								<use href="#brei-icon-arrows-arrow"></use>
							</svg>
						</span>
					</p>
				</a>
			</div>
			<a href="<?php echo get_permalink($post); ?>" class="child-page-grid__link">
				<span class="show-for-sr">Read more about "
					<?php echo $post->post_title ?>"
				</span>
			</a>
		</div>
	</div>
	<?php
}


function display_single_rail_post_card(
	WP_Post $post
) {
	/* display a simple card in the sidebar (rail) with a post title and excerpt; link it to the post permalink */
	?>
	<div class="rail-news">
		<div class="rail-news__inner">
			<p class="rail-news__title font-h6">
				<?php echo $post->post_title ?>
			</p>
			<p class="rail-news__copy">
				<?php echo $post->post_excerpt ?>
			</p>

			<a href="<?php echo get_post_permalink($post) ?>" class="btn btn-tertiary btn-tertiary-left">
				<span class="text">Read more</span>
				<span class="text-arrow">
					<svg class="brei-icon brei-icon-arrows" focusable="false">
						<use href="#brei-icon-arrows"></use>
					</svg>

					<svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
						<use href="#brei-icon-arrows-arrow"></use>
					</svg>
				</span>
			</a>

			<!--span class="btn__icon"></span-->
		</div>
	</div>
	<?php
}



function display_post_card_grid_by_category(
	string $category_name,
	int $limit = null,
	int $offset = null,
	string $medium_screen_class = 'medium-6',
	string $large_screen_class = ''
) {
	/* 
																																	 Display a card grid of posts in a given category. 
																																	 Optionally provide a limit (i.e. only display up to 3). 
																																	 Optionally provide an offset (e.g. offset = 1 to skip the 
																																	 first if that was already displayed in a wide card on the 
																																	 top of the page.)

																																	 $medium_screen_class is optional. Default is medium-6. Can be "medium-<int> where int
																																	 is a number between 1 and 12, indicating a proportion of container width to take up
																																	 on medium screens (over 48em, below 64em). medium-6 means each item is 1/2 container width. 
																																	 
																																	 $large_screen_class is optional. Default is empty. Can be "large-<int> where int
																																	 is a number between 1 and 12, indicating a proportion of container width to take up
																																	 on large screens (over 64em). Empty means large screen inherits from medium screen styles.

																																	 Cards are full width on mobile by default. No adjustment there.
																																	 
																																	 */
	$category = get_category_by_slug($category_name);
	$posts = get_posts(
		array(
			'category' => $category->cat_ID
		)
	);
	if (sizeof($posts) > 0) {
		$counter = 0;
		if (!is_null($offset)) {
			$posts = array_slice($posts, $offset);
		}
		if (sizeof($posts) > 0) {
			// if still not empty after slice. 

			foreach ($posts as $post) {
				if (!is_null($limit) && $counter++ >= $limit) {
					break;
				}
				display_single_post_card(
					post: $post,
					wide: false,
					display_excerpt: false,
					display_published_date: true,
					display_author: true,
					medium_screen_class: $medium_screen_class,
					large_screen_class: $large_screen_class,
				);
			}
		}
	}
}



function atLeastOneAccountLinkPopulated($accounts)
{
	foreach ($accounts as $account) {
		// check if the option from the Social Media customizer is populated
		$accountLink = get_option($account['slug']);
		if (!empty($accountLink)) {
			return true;
		}
	}
	return false; // all empty 
}


function cofctheme_enqueue_styles()
{
	$version = wp_get_theme()->get('Version');
	wp_enqueue_style('cofc-css', get_template_directory_uri() . "/assets/css/main.css", array(), $version);
}

function cofctheme_enqueue_scripts()
{
	// scripts 
	wp_enqueue_script('cofc-js-jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);
	wp_enqueue_script('cofc-js-modernizr', get_template_directory_uri() . '/assets/js/plugins/modernizr.js', array('cofc-js-jquery'), '1.0', true);
	wp_enqueue_script('cofc-js-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array('cofc-js-modernizr'), '1.0', true);
	wp_enqueue_script('cofc-js-main', get_template_directory_uri() . "/assets/js/main.js", array('cofc-js-vendor'), '1.0', true);
	wp_enqueue_script('cofc-js-level', get_template_directory_uri() . '/assets/js/level.js', array('cofc-js-main'), '1.0', true);
	wp_enqueue_script('cofc-js-postgrid', get_template_directory_uri() . '/assets/js/postgrid.js', array('cofc-js-main'), '1.0', true);
	wp_enqueue_script('cofc-js-prettifymailchimpforms', get_template_directory_uri() . '/assets/js/prettifymailchimpforms.js', array('cofc-js-main'), '1.0', true);


	cofctheme_enqueue_custom_block_scripts();
}
function cofctheme_enqueue_styles_and_scripts()
{
	cofctheme_enqueue_styles();
	cofctheme_enqueue_scripts();
}
add_action('wp_enqueue_scripts', 'cofctheme_enqueue_styles_and_scripts');
add_action('admin_enqueue_scripts', 'cofctheme_enqueue_scripts');


function enqueue_admin_media_utilities()
{

	// define function to enqueue utilities for media file handling in Admin UI
	wp_enqueue_script('media-upload');
	wp_enqueue_media();
	wp_enqueue_script('custom-media', get_template_directory_uri() . '/assets/js/media.js', array('jquery'), '1.0', false);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_media_utilities');

add_theme_support('customize-selective-refresh-widgets');


require get_template_directory() . '/customizers.php';
require get_template_directory() . '/template-parts/meta_boxes.php';
require get_template_directory() . '/template-parts/svg_defs.php';
require get_template_directory() . '/template-parts/widgets/index.php';
require get_template_directory() . '/template-parts/header/navigation.php';


// Custom blocks 

function localize_block_vars()
{
	return array(
		'template_directory_uri' => get_template_directory_uri()
	);
}
function cofctheme_enqueue_custom_block_scripts()
{
	// register all of the scripts for each custom block - each block has a distribution file called bundle.js
	$blocks = array(
		'post-grid',
		'media-carousel',
		'testimonial',
		'tag-grid',
		'podcast-platforms',
	);
	$deps = array(
		'wp-blocks',
		'wp-dom-ready',
		'wp-polyfill',
		'wp-element',
	);
	$version = '0.1';
	foreach ($blocks as $block) {
		wp_enqueue_script(
			'cofctheme/' . $block,
			get_template_directory_uri() . '/blocks/build/' . $block . '/index.js',
			$deps,
			$version,
			true
		);
		wp_localize_script(
			'cofctheme/' . $block,
			'cofctheme',
			localize_block_vars()
		);
	}
}

require get_template_directory() . '/blocks/src/post-grid/index.php';
require get_template_directory() . '/blocks/src/media-carousel/index.php';
require get_template_directory() . '/blocks/src/testimonial/index.php';
require get_template_directory() . '/blocks/src/tag-grid/index.php';
require get_template_directory() . '/blocks/src/podcast-platforms/index.php';
// End custom blocks 
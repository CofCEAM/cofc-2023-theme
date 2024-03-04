<?php


add_filter('template_include', 'load_search_template');

function update_array_meta($post_id, $key)
{
	if (isset($_POST[$key])) {
		// if string, convert to array
		$items = array();
		if (isset($_POST[$key]) && is_array($_POST[$key])) {
			foreach ($_POST[$key] as $item) {
				$items[] = sanitize_text_field($item);
			}
		}
		update_post_meta(
			$post_id,
			$key,
			$items
		);
	}
}
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
function custom_pagination_links($max_num_pages, $current_page, $base_url = '', $query = null, $searchwp_pagination = false, $append_to_end_of_url = '')
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
	$link = $link . $append_to_end_of_url;
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
			$link = $link . $append_to_end_of_url;
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
	$link = $link . $append_to_end_of_url;
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

	<div class="card-news <?php echo $wideClass ?> card-news--featured cofc-post-grid-item" itemscope itemtype="https://schema.org/NewsArticle">
		<?php
		$featured_image_id = get_post_thumbnail_id($post->ID);
		$featured_image = get_post($featured_image_id);
		if (!is_null($featured_image)) {
			// conditionally display featured image
			$featured_image_title = $featured_image->post_title;
			$featured_image_url = get_the_post_thumbnail_url($post);
		?>
			<figure class="card-news__figure">
				<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>" class="card-news__image" itemprop="image" width="926" height="695" />
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

			<a href="<?php echo get_post_permalink($post) ?>" title="Read more about <?php echo $post->post_title ?>" class="card-news__button">
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
	string $title_heading_size = 'h4',
	bool $podcast = false
) {

	$wideclass = $wide ? 'card-news--wide' : '';
	$podcastCardClass = $podcast ? 'card-news--podcast' : '';
	$podcastBtnClass = $podcast ? 'btn-card--podcast' : '';
?>
	<div class="cell xsmall-12  <?php echo $medium_screen_class ?> <?php echo $large_screen_class ?> cofc-post-grid-item">
		<div class="card-news <?php echo $wideclass ?> <?php echo $podcastCardClass ?>" itemscope itemtype="https://schema.org/NewsArticle">
			<?php
			$featured_image_id = get_post_thumbnail_id($post->ID);
			$featured_image = get_post($featured_image_id);
			if (!is_null($featured_image)) {
				// conditionally display featured image
				$featured_image_title = $featured_image->post_title;
				$featured_image_url = get_the_post_thumbnail_url($post->ID);
			?>
				<figure data-featured-image-id="<?php echo $featured_image_id ?>" class="card-news__figure">
					<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>" class="card-news__image" itemprop="image" width="926" height="695" />
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

				<a href="<?php echo get_permalink($post); ?>" title="Read more about <?php echo $post->post_title ?>" class="card-news__button">
					<p class="btn btn-card <?php echo $podcastBtnClass ?>" aria-hidden="true">
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
	WP_Post $post,
	bool $display_excerpt = false,
	bool $display_published_date = true,
	bool $display_author = true,
) {
	/* display a simple card in the sidebar (rail) with a post title and excerpt; link it to the post permalink */
?>
	<div class="rail-news">
		<div class="rail-news__inner">
			<p class="rail-news__title font-h6">
				<?php echo $post->post_title ?>
			</p>
			<?php if ($display_excerpt) { ?>
				<p class="rail-news__copy">
					<?php echo $post->post_excerpt ?>
				</p>
			<?php } ?>

			<?php if ($display_published_date) { ?>
				<p class="rail-news__date card-icon">
					<svg class="brei-icon brei-icon-calendar" focusable="false">
						<use href="#brei-icon-calendar"></use>
					</svg>
					<span itemprop="dateline">
						<?php echo get_the_date('F j, Y', $post) ?>
					</span>
				</p>
			<?php } ?>

			<?php if ($display_author) { ?>
				<p class="rail-news__author card-icon">
					<svg class="brei-icon brei-icon-avatar" focusable="false">
						<use href="#brei-icon-avatar"></use>
					</svg>
					<span itemprop="author">by
						<?php echo get_the_author_meta('display_name', $post->post_author) ?>
					</span>
				</p>
			<?php } ?>

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


function display_main_feature_article_card(
	WP_Post $post,
	bool $wide = true
) {
	$wideClass = $wide ? 'card-news--wide' : '';
?>
	<div class="card-news <?php echo $wideClass ?> card-news--featured" itemscope itemtype="https://schema.org/NewsArticle" onclick="window.location='<?php echo get_permalink($post); ?>'">
		>
		<?php
		$featured_image_id = get_post_thumbnail_id($post->ID);
		$featured_image = get_post($featured_image_id);
		if (!is_null($featured_image)) {
			// conditionally display featured image
			$featured_image_title = $featured_image->post_title;
			$featured_image_url = get_the_post_thumbnail_url($post->ID);
		?>
			<figure data-featured-image-id="<?php echo $featured_image_id ?>" class="card-news__figure">
				<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>" class="card-news__image" itemprop="image" width="926" height="695" />
			</figure>
		<?php } ?>

		<div class="card-news__wrapper">
			<div class="card-news__content">
				<p class="card-news__heading font-h3">
					<span itemprop="headline">
						<?php echo $post->post_title ?>
					</span>
				</p>
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

			<a href="<?php echo get_permalink($post); ?>" title="Read more about <?php echo $post->post_title ?>" class="card-news__button">
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
<?php
}

function display_single_magazine_article_card(
	WP_Post $post,
	string $medium_screen_class = 'medium-6',
	string $large_screen_class = '',
) {
?>
	<div class="aggregate__content xsmall-12 <?php echo $medium_screen_class ?> <?php echo $large_screen_class ?> cell">
		<div class="card-news" itemscope="" itemtype="https://schema.org/NewsArticle" onclick="window.location='<?php echo get_permalink($post); ?>'">
			<?php
			$featured_image_id = get_post_thumbnail_id($post->ID);
			$featured_image = get_post($featured_image_id);
			if (!is_null($featured_image)) {
				// conditionally display featured image
				$featured_image_title = $featured_image->post_title;
				$featured_image_url = get_the_post_thumbnail_url($post->ID);
			?>
				<figure data-featured-image-id="<?php echo $featured_image_id ?>" class="card-news__figure">
					<img src="<?php echo $featured_image_url ?>" alt="<?php echo $featured_image_title ?>" class="card-news__image" itemprop="image" />
				</figure>
			<?php } ?>

			<div class="card-news__wrapper">
				<div class="card-news__content">
					<p class="card-news__heading font-h4"><span itemprop="headline">
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

				<a href="<?php echo get_permalink($post); ?>" title="Read more about <?php echo $post->post_title ?>" class="card-news__button">
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




function display_post_card_grid_by_category(
	string $category_name,
	int $limit = null,
	int $offset = null,
	string $medium_screen_class = 'medium-6',
	string $large_screen_class = ''
) {

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


function display_image_link_grid(array $links = null, string $title = "Related Links")
{
	// Each link:
	//  'label' => 'link label',
	//  'url' => 'link url'
	//  'media_alt' => 'alt text'
	//  'media_url' => 'featured image url',
	//  'new_tab' => bool
	// )  

	if (is_null($links) || sizeof($links) == 0) {
		return;
	}
?>
	<div class="aggregate__subset">
		<div class="row level__row grid-x grid-margin-x grid-margin-y">
			<div class="content xsmall-12 cell">
				<h2 class="aggregate__latest font-h1">
					<?php echo $title ?>
				</h2>
				<hr>
			</div>
			<?php
			foreach ($links as $link) {
				$label = isset($link['label']) ? $link['label'] : '';
				$media_url = isset($link['media_url']) ? $link['media_url'] : '';
				$media_alt = isset($link['media_alt']) ? $link['media_alt'] : '';
				$new_tab = isset($link['new_tab']) ? $link['new_tab'] : false;
				$target = $new_tab ? 'target="_blank"' : '';
				$link_url = isset($link['url']) ? $link['url'] : '';
			?>
				<div class="aggregate__content xsmall-12 medium-6 large-4 cell">
					<div class="card-magazine">
						<?php
						// if properties are present for media then display featured image 
						if (!empty($media_url)) {
						?>
							<figure class="card-magazine__figure">
								<img src="<?php echo $media_url ?>" alt="<?php echo $media_alt ?>" class="card-magazine__image" itemprop="image">
							</figure>
						<?php
						}
						?>

						<div class="card-magazine__button" s>
							<p class="btn btn--primary">
								<span class="text">
									<?php echo $label ?>
								</span>
							</p>
						</div>

						<?php
						?>
						<a href="<?php echo $link_url ?>" <?php echo $target ?> class="card-magazine__link"><span class="show-for-sr">
								<?php echo $label ?>
							</span></a>

					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>

<?php
}




function display_rail_podcast_component(
	string $title = "Subscribe on your preferred platform",
	bool $desktop = false
) {

	$SPOTIFY_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-spotify.svg';
	$IHEART_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-iheart-radio.svg';
	$APPLE_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-apple.svg';
	$STITCHER_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-stitcher.svg';
	$GOOGLE_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-google.svg';
	$YOUTUBE_PODCAST_ICON = get_template_directory_uri() . '/assets/images/icon-youtube.svg';

	$desktopClass = $desktop ? "rail-podcast--desktop" : "";
?>
	<div class="rail-podcast <?php echo $desktopClass ?>">
		<div class="rail-podcast__content">
			<h2 class="rail-header">
				<?php echo $title ?>
			</h2>
			<hr>
			<ul class="rail-podcast__list">
				<li class="rail-podcast__item podcast_platform__apple" <?php if (empty(get_option('podcast_platform__apple'))) {
																			echo 'style="display:none"';
																		} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__apple')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $APPLE_PODCAST_ICON ?>" alt="Apple Podcast" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>Apple Podcasts</span>
						</div>
					</a>
				</li>
				<li class="rail-podcast__item podcast_platform__spotify" <?php if (empty(get_option('podcast_platform__spotify'))) {
																				echo 'style="display:none"';
																			} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__spotify')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $SPOTIFY_PODCAST_ICON ?>" alt="Spotify" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>Spotify</span>
						</div>
					</a>
				</li>
				<li class="rail-podcast__item podcast_platform__stitcher" <?php if (empty(get_option('podcast_platform__stitcher'))) {
																				echo 'style="display:none"';
																			} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__stitcher')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $STITCHER_PODCAST_ICON ?>" alt="Stitcher" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>Stitcher</span>
						</div>
					</a>
				</li>
				<li class="rail-podcast__item podcast_platform__google" <?php if (empty(get_option('podcast_platform__google'))) {
																			echo 'style="display:none"';
																		} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__google')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $GOOGLE_PODCAST_ICON ?>" alt="Google Podcasts" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>Google Podcasts</span>
						</div>
					</a>
				</li>
				<li class="rail-podcast__item podcast_platform__youtube" <?php if (empty(get_option('podcast_platform__youtube'))) {
																				echo 'style="display:none"';
																			} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__youtube')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $YOUTUBE_PODCAST_ICON ?>" alt="YouTube Podcasts" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>YouTube Podcasts</span>
						</div>
					</a>
				</li>
				<li class="rail-podcast__item podcast_platform__iheart" <?php if (empty(get_option('podcast_platform__iheart'))) {
																			echo 'style="display:none"';
																		} ?>>
					<a href="<?php echo esc_attr(get_option('podcast_platform__iheart')) ?>" class="rail-podcast__link" aria-label="" target="_blank">
						<img src="<?php echo $IHEART_PODCAST_ICON ?>" alt="iHeart Radio" width="25" height="25" aria-hidden="true">
						<div class="rail-podcast__text">
							Listen on<br><span>iHeartRadio</span>
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>

<?php
}

function display_single_rail_link(array $link)
{
	// $link array structure:
	// array(
	// 	'label' => 'link label',
	// 	'url' => 'link url'
	//  'description' => 'link description' (optional)
	//  'new_tab' => bool
	// )
	// leverage same component as rail news section rather
	// than rebuilding the exact same thing with different class names
	$label = isset($link['label']) ? $link['label'] : '';
	$url = isset($link['url']) ? $link['url'] : '';
	$display_description = isset($link['display_description']) ? $link['display_description'] : false;
	$description = isset($link['description']) ? $link['description'] : '';
	$new_tab = isset($link['new_tab']) ? $link['new_tab'] : false;
	$target = $new_tab ? 'target="_blank"' : '';
?>
	<div class="rail-news">
		<div class="rail-news__inner">
			<a href="<?php echo $url ?>" <?php echo $target ?> class="btn btn-tertiary btn-tertiary-left">
				<span class="text">
					<?php echo $label ?>
				</span>
				<span class="text-arrow">
					<svg class="brei-icon brei-icon-arrows" focusable="false">
						<use href="#brei-icon-arrows"></use>
					</svg>

					<svg class="brei-icon brei-icon-arrows-arrow" focusable="false">
						<use href="#brei-icon-arrows-arrow"></use>
					</svg>
				</span>
			</a>
			<?php if ($display_description && !empty($description)) { ?>
				<p class="rail-news__copy">
					<?php echo $description; ?>
				</p>
			<?php } ?>
		</div>
	</div>
<?php
}

function display_rail_links_list(
	array $links = array(),
	string $title = "Related Links"
) {
	// $title = title of rail link list section
	// $links array structure:
	// array(
	// array(
	// 	'label' => 'link label',
	// 	'url' => 'link url'
	//  'description' => 'link description' (optional)
	//  'new_tab' => bool
	// )
	// leverage same component as rail news section rather
	// than rebuilding the exact same thing with different class names

?>
	<div class="rail-home__section">
		<h2 class="rail-header">
			<?php echo $title ?>
		</h2>
		<hr>
		<?php
		foreach ($links as $link) {
			display_single_rail_link($link);
		}
		?>
	</div>

<?php
}



function atLeastOneAccountLinkPopulated($accounts)
{
	foreach ($accounts as $account) {
		if (!isset($account['slug'])) {
			continue;
		}
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
	wp_enqueue_script('cofc-js-news-aggregate-template', get_template_directory_uri() . '/assets/js/filterable_news_aggregate.js', array('cofc-js-main'), '1.0', true);
	wp_enqueue_script('cofc-js-level', get_template_directory_uri() . '/assets/js/level.js', array('cofc-js-main'), '1.0', true);
	wp_enqueue_script('cofc-js-postgrid', get_template_directory_uri() . '/assets/js/postgrid.js', array('cofc-js-main'), '1.0', true);
	wp_enqueue_script('cofc-js-prettifymailchimpforms', get_template_directory_uri() . '/assets/js/prettifymailchimpforms.js', array('cofc-js-main'), '1.0', true);
	cofctheme_enqueue_custom_block_scripts();
}


function cofctheme_enqueue_admin_scripts()
{
	// scripts 
	wp_enqueue_script('cofc-js-jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);
	cofctheme_enqueue_custom_block_scripts();

	// enqueue utilities for media file handling in Admin UI
	wp_enqueue_script('media-upload');
	wp_enqueue_media();
	wp_enqueue_script('custom-media', get_template_directory_uri() . '/assets/js/media.js', array('jquery'), '1.0', false);

	// enqueue admin JS for meta box conditional display (dependent on selected Page Template) 
	wp_enqueue_script(
		'cofctheme_metabox_display_admin_script',
		get_template_directory_uri() . '/metaboxes/index.js',
		array('jquery'),
		'1.0',
		true
	);

	// widget editor scripts 
	wp_enqueue_script('widget-editor-image-link-grid', get_template_directory_uri() . '/assets/js/widget-editors/image-link-grid.js', array('jquery'), '1.0', false);
	wp_enqueue_script('rail-link-list-widget-script', get_template_directory_uri() . '/assets/js/widget-editors/rail-link-list.js', array('jquery'), '1.0', true);
}

function cofctheme_enqueue_styles_and_scripts()
{
	cofctheme_enqueue_styles();
	cofctheme_enqueue_scripts();
}
add_action('wp_enqueue_scripts', 'cofctheme_enqueue_styles_and_scripts');
add_action('admin_enqueue_scripts', 'cofctheme_enqueue_admin_scripts');



add_theme_support('customize-selective-refresh-widgets');


require get_template_directory() . '/customizers.php';
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
function aggregate_rail_filter_component(
	string $filter_headline = 'Filter By',
	array $filterable_category_ids = array(),
	array $filterable_tag_ids = array(),
	array $filterable_years = array(),
	array $checked_category_ids = array(),
	array $checked_tag_ids = array(),
	array $checked_years = array(),
	string $base_url = ''
) {
	// used on the Filterable News Aggregate template filterable_news_aggregate.php
	// base_url is just path 
	// need absolute 
	$base_url = get_site_url() . $base_url;
?>
	<section class="filter">
		<div class="filter__border">
			<div class="filter__inner">
				<h2 class="filter__title font-h4">
					<?php echo $filter_headline ?>
				</h2>
				<hr>
				<div class="filter__set">
					<ul class="filter__accordion accordion" data-accordion="hvmgsx-accordion" data-multi-expand="true" data-allow-all-closed="true">
						<?php // expanded by default 
						?>
						<?php if (!empty($filterable_category_ids)) { ?>
							<li class="filter__item accordion-item is-active" data-accordion-item="">
								<a href="#categoryFilterSection" class="filter__heading accordion-title" aria-controls="categoryFilterSection" id="categoryFilterSection-label" aria-expanded="true">
									<span class="filter__label">Filter By Category</span>
									<span class="trigger">
										<svg class="brei-icon brei-icon-plus" focusable="false">
											<use href="#brei-icon-plus"></use>
										</svg>
										<svg class="brei-icon brei-icon-minus" focusable="false">
											<use href="#brei-icon-minus"></use>
										</svg>
									</span>
								</a>
								<div class="filter__content accordion-content" data-tab-content="" id="categoryFilterSection" role="region" aria-labelledby="categoryFilterSection-label">
									<fieldset>
										<legend class="show-for-sr">year</legend>
										<?php
										foreach ($filterable_category_ids as $category_id) {
											$category = get_category($category_id);
											$checked = in_array($category_id, $checked_category_ids) ? 'checked="checked"' : '';
										?>
											<div class="form__field">
												<input id="catFilter-<?php echo $category_id ?>" name="catFilter[]" type="checkbox" value="<?php echo $category_id ?>" <?php echo $checked ?>>
												<label for="catFilter-<?php echo $category_id ?>">
													<?php echo $category->name ?>
													<span class="checkbox" role="none">
														<svg class="brei-icon brei-icon-check" focusable="false">
															<use href="#brei-icon-check"></use>
														</svg>
													</span>
												</label>
											</div>
										<?php
										} ?>
									</fieldset>
								</div>
							</li>

						<?php }
						// expand if there are active tag filters
						$expanded = sizeof($checked_tag_ids) > 0 ? 'is-active' : '';
						if (!empty($filterable_tag_ids)) {
						?>
							<li class="filter__item accordion-item <?php echo $expanded ?>" data-accordion-item="">
								<a href="#tagFilterSection" class="filter__heading accordion-title" aria-controls="tagFilterSection" id="tagFilterSection-label" aria-expanded="true">
									<span class="filter__label">Filter By Tag</span>
									<span class="trigger">
										<svg class="brei-icon brei-icon-plus" focusable="false">
											<use href="#brei-icon-plus"></use>
										</svg>
										<svg class="brei-icon brei-icon-minus" focusable="false">
											<use href="#brei-icon-minus"></use>
										</svg>
									</span>
								</a>
								<div class="filter__content accordion-content" data-tab-content="" id="tagFilterSection" role="region" aria-labelledby="tagFilterSection-label">
									<fieldset>
										<legend class="show-for-sr">year</legend>
										<?php
										foreach ($filterable_tag_ids as $tag_id) {
											$tag = get_term($tag_id);
											$checked = in_array($tag_id, $checked_tag_ids) ? 'checked="checked"' : '';
										?>
											<div class="form__field">
												<input id="tagFilter-<?php echo $tag_id ?>" name="tagFilter[]" type="checkbox" value="<?php echo $tag_id ?>" <?php echo $checked ?>>
												<label for="tagFilter-<?php echo $tag_id ?>">
													<?php echo $tag->name ?>
													<span class="checkbox" role="none">
														<svg class="brei-icon brei-icon-check" focusable="false">
															<use href="#brei-icon-check"></use>
														</svg>
													</span>
												</label>
											</div>
										<?php
										} ?>
									</fieldset>
								</div>
							</li>
						<?php
						}

						if (!empty($filterable_years)) {
							// expand if there are active year filters
							$expanded = sizeof($checked_years) > 0 ? 'is-active' : '';
						?>
							<li class="filter__item accordion-item <?php echo $expanded ?>" data-accordion-item="">
								<a href="#yearFilterSection" class="filter__heading accordion-title" aria-controls="yearFilterSection" id="yearFilterSection-label">
									<span class="filter__label">Filter By Year</span>
									<span class="trigger">
										<svg class="brei-icon brei-icon-plus" focusable="false">
											<use href="#brei-icon-plus"></use>
										</svg>
										<svg class="brei-icon brei-icon-minus" focusable="false">
											<use href="#brei-icon-minus"></use>
										</svg>
									</span>
								</a>
								<div class="filter__content accordion-content" data-tab-content="" id="yearFilterSection" role="region" aria-labelledby="yearFilterSection-label">
									<fieldset>
										<legend class="show-for-sr">year</legend>
										<?php
										foreach ($filterable_years as $year) {
											$checked = in_array($year, $checked_years) ? 'checked="checked"' : '';
										?>
											<div class="form__field">
												<input id="yearFilter-<?php echo $year ?>" name="yearFilter[]" type="checkbox" value="<?php echo $year ?>" <?php echo $checked ?>>
												<label for="yearFilter-<?php echo $year ?>">
													<?php echo $year ?>
													<span class="checkbox" role="none">
														<svg class="brei-icon brei-icon-check" focusable="false">
															<use href="#brei-icon-check"></use>
														</svg>
													</span>
												</label>
											</div>
										<?php
										} ?>
									</fieldset>
								</div>
							</li>
						<?php
						} ?>
					</ul>

				</div>

				<button class="btn btn--primary-small filter__button" onclick="applyFilters({baseUrl: '<?php echo $base_url ?>'})">
					<span class="text">Apply Filters</span>
				</button>
			</div>
		</div>
	</section>
<?php
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

/* SearchWP configuration 
Documentation: https://searchwp.com/v3/docs/hooks/searchwp_return_orderby_date/
Solves problem: when searching on MultiSite, the search results are not ordered by date
ALWAYS return search results ordered by date
*/
add_filter('searchwp_return_orderby_date', '__return_true');


require get_template_directory() . '/blocks/src/post-grid/index.php';
require get_template_directory() . '/blocks/src/media-carousel/index.php';
require get_template_directory() . '/blocks/src/testimonial/index.php';
require get_template_directory() . '/blocks/src/tag-grid/index.php';
require get_template_directory() . '/blocks/src/podcast-platforms/index.php';

/* meta boxes for specific templates */
require get_template_directory() . '/metaboxes/filterable_news_aggregate/index.php';
require get_template_directory() . '/metaboxes/prefiltered_news_aggregate/index.php';
require get_template_directory() . '/metaboxes/podcast_aggregate/index.php';
// End custom blocks 
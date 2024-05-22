<?php

/**
 * Template Name: Search Page for SearchWP (when ?searchwp= is set in URL)
 */
get_header();

global $post;

function order_searchwp_results_in_reverse_chronological_order($searchwp_results = array(), $current_blog_id)
{
	/* 
	Args: 
		$searchwp_results: array of search_results from SearchWP
		$current_blog_id: current blog ID

	Returns:
		$search_results: array of WP_Post objects sorted by post date in descending order
	*/

	// Since SearchWP is failing to order by post date, do it manually here. 
	// search_results from SearchWP looks like this: array(10) { [0]=> object(stdClass)#3210 (4) { ["id"]=> string(6) "132691" ["source"]=> string(9) "post.post" ["site"]=> string(1) "2" ["relevance"]=> string(1) "6" } .... }
	$reverse_chronological_order_search_results = array();
	foreach ($searchwp_results as $search_result) {
		if ($current_blog_id !== $search_result->site) {
			switch_to_blog($search_result->site);
			$post = get_post($search_result->id);
			$reverse_chronological_order_search_results[$post->post_date] = array(
				'site' => $search_result->site,
				'post' => $post
			);
			restore_current_blog();
		} else {
			$post = get_post($search_result->id);
			$reverse_chronological_order_search_results[$post->post_date] = array(
				'site' => $search_result->site,
				'post' => $post
			);
		}
	}
	wp_reset_postdata();
	// sort by post date in descending order (keys)
	krsort($reverse_chronological_order_search_results);
	// reassign the sorted search results to $search_results
	$search_results = array_values($reverse_chronological_order_search_results);
	return $search_results; // array of WP_Post objects
}

// appearance > customize > search options 
$searchwp_engine_name = get_option('searchwp_engine_name');
$searchwp_engine_name = empty($searchwp_engine_name) ? 'cofcengine' : $searchwp_engine_name;
$search_site_ids = str_replace(' ', '', get_option('search_site_ids'));
$search_site_ids = empty($search_site_ids) ? 'all' : $search_site_ids;
// if not "all", then convert to array
$search_site_ids = $search_site_ids == 'all' ? $search_site_ids : explode(',', $search_site_ids);
// if $search_site_ids is an array, then convert each element to int (site id) 
if (is_array($search_site_ids)) {
	$search_site_ids = array_map('intval', $search_site_ids);
}

// get query and page number from URL
$search_query = isset($_GET['searchwp']) ? sanitize_text_field($_GET['searchwp']) : null;
$search_page = isset($_GET['swppg']) ? absint($_GET['swppg']) : 1;
$posts_per_page = get_option('posts_per_page');
$current_blog_id = get_current_blog_id();

// init search results to empty 
$search_results = array();

if (!empty($search_query) && class_exists('\\SearchWP\\Query')) {
	$searchwp_query = new \SearchWP\Query($search_query, [
		'engine' => $searchwp_engine_name, // The Engine name.
		'fields' => 'default',          // Retain site ID info with results.
		'site' => $search_site_ids, // Limit results to specified sites
		'page' => 1,
		'per_page' => -1, // get all results to enforce global chronological order; enforce pagination manually below
	]);
	$search_results = $searchwp_query->get_results();

	$search_results = order_searchwp_results_in_reverse_chronological_order($search_results, $current_blog_id);
	// Implement manual pagination 
	$total_results = count($search_results);
	$max_num_pages = ceil($total_results / $posts_per_page);
	$offset = ($search_page - 1) * $posts_per_page;
	$search_results = array_slice($search_results, $offset, $posts_per_page);

	// Echo these variables as comments 
	echo "<!-- search_query: $search_query -->";
	echo "<!-- search_page: $search_page -->";
	echo "<!-- posts_per_page: $posts_per_page -->";
	echo "<!-- current_blog_id: $current_blog_id -->";
	echo "<!-- total_results: $total_results -->";
	echo "<!-- max_num_pages: $max_num_pages -->";
	echo "<!-- offset: $offset -->";
}
?>

<main id="main" class="search-results">
	<!-- current blog ID: <?php echo $current_blog_id ?> -->
	<div class="search-results__wrapper wrapper">
		<div class="row">
			<div class="search-results__content xsmall-12 cell">
				<div class="search-results__inner">
					<h1>
						<?php echo 'Search results for "' . $search_query . '"' ?>
					</h1>
					<hr>
					<form class="search-results__search" role="search" method="get" action="<?php echo get_site_url() ?>">
						<div class="form__field form__field--is-search form__field--is-valid">
							<input id="searchwp" name="searchwp" type="search" value="<?php echo isset($_GET['searchwp']) ? esc_attr($_GET['searchwp']) : '' ?>" required="required" title="<?php echo esc_attr_x('Search for:', 'label') ?>">
							<label for="search" style="visibility:hidden;">Search term</label>
							<button type="submit" class="search-button">
								<span class="show-for-sr">Search</span>
								<svg class="brei-icon brei-icon-search" focusable="false">
									<use href="#brei-icon-search"></use>
								</svg>
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="aggregate__content xsmall-12 column">
				<div id="results-full-container" class="aggregate__set">
					<div id="results-info-container" class="row level_search--navigation aggregate__info">
						<div id="results-count" class="level__pages xsmall-12 large-order-2 column aggregate__count ">
							<?php if (!empty($search_query)) {
								echo "Page " . $search_page . " of " . $searchwp_query->max_num_pages;
							}
							?>
						</div>
					</div>

					<!--div id="results_loader" class="aggregate__loading">
						<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
							<path opacity="0.2" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
							<path d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z">
								<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="1s" repeatCount="indefinite"></animateTransform>
							</path>
						  </svg>
					</div-->

					<h2 class="show-for-sr">
						<?php echo 'Search results for "' . $search_query . '"' ?>
					</h2>

					<div id="results-listings-container" class="aggregate__results row level_events11 grid-x grid-margin-x grid-margin-y column" data-src="../../data/search.json">
						<section class="news-content">
							<div class="news-content__cards grid-x grid-margin-x grid-margin-y">

								<?php if (!empty($search_query) && !empty($search_results)) {
									foreach ($search_results as $post) {
										if ($current_blog_id !== $post['site']) {
											switch_to_blog($post['site']);
											$post = $post['post'];
										} else {
											$post = $post['post'];
										}

								?>
										<div class="cell xsmall-12 medium-6 large-4 post-<?php echo $post->ID ?>">
											<?php
											display_featured_post_card($post, wide: false);
											?>
										</div>
									<?php
										restore_current_blog();
									}
									wp_reset_postdata(); // At the end reset your query 
									?>
									<div class="xsmall-12">
										<div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
											<?php
											echo custom_pagination_links(
												max_num_pages: $max_num_pages,
												current_page: $search_page,
												base_url: '',
												query: $search_query,
												searchwp_pagination: true
											);
											?>
										</div>
									</div>
								<?php
								} else {
								?>
									<div class="component">
										<div class="row level__row">
											<div class="level__content large-8 large-push-2 columns">
												<h1 class="page-title">
													<?php echo "No matching posts found" ?>
												</h1>
											</div>
										</div>
									</div>
								<?php
								} ?>
							</div>
					</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
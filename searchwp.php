<?php
/**
 * Template Name: Search Page
 */
get_header();

global $post;

// appearance > customize > search options 
$searchwp_engine_name = get_option('searchwp_engine_name');
$searchwp_engine_name = empty($searchwp_engine_name) ? 'cofcengine' : $searchwp_engine_name;

// get query and page number from URL
$search_query = isset($_GET['searchwp']) ? sanitize_text_field($_GET['searchwp']) : null;
$search_page = isset($_GET['swppg']) ? absint($_GET['swppg']) : 1;
$current_blog_id = get_current_blog_id();

// init search results to empty 
$search_results = array();
$search_pagination = '';

if (!empty($search_query) && class_exists('\\SearchWP\\Query')) {
	$searchwp_query = new \SearchWP\Query($search_query, [
		'engine' => $searchwp_engine_name, // The Engine name.
		'fields' => 'all',          // Load proper native objects of each result.
		'page' => $search_page,
		'posts_per_page' => get_option('posts_per_page'),
	]);
	$search_results = $searchwp_query->get_results();

	$search_pagination = paginate_links(
		array(
			'format' => '?swppg=%#%',
			'current' => $search_page,
			'total' => $searchwp_query->max_num_pages,
		)
	);
}
?>
<main id="main" class="search-results">
	<!-- current blog ID: <?php echo $current_blog_id ?> -->
	<div class="search-results__wrapper wrapper">
		<div class="row">
			<div class="search-results__content xsmall-12 cell">
				<div class="search-results__inner">
					<h1 class="font-special-2">
						<?php printf(esc_html__('Search Results for: %s', 'torba'), '<span>' . get_search_query() . '</span>'); ?>
					</h1>
					<hr>
					<form class="search-results__search" role="search" method="get"
						action="<?php echo get_site_url() ?>">
						<div class="form__field form__field--is-search form__field--is-valid">
							<input id="searchwp" name="searchwp" type="search"
								value="<?php echo isset($_GET['searchwp']) ? esc_attr($_GET['searchwp']) : '' ?>"
								required="required" title="<?php echo esc_attr_x('Search for:', 'label') ?>">
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
						<?php printf(esc_html__('Search Results for: %s', 'torba'), '<span>' . get_search_query() . '</span>'); ?>
					</h2>

					<div id="results-listings-container"
						class="aggregate__results row level_events11 grid-x grid-margin-x grid-margin-y column"
						data-src="../../data/search.json">
						<section class="news-content">
							<div class="news-content__cards grid-x grid-margin-x grid-margin-y">

								<?php if (!empty($search_query) && !empty($search_results)) {
									foreach ($search_results as $search_result) {
										$post = $search_result;
										if ($current_blog_id != $post->site) {
											echo "<!-- current blog id " . $current_blog_id . " NOT EQUAL TO post site ID " . $post->site . "-->";
											switch_to_blog($post->site);
											$post = get_post($post->ID);
											?>
											<div class="cell xsmall-12 medium-6 large-4">
												<?php
												display_featured_post_card($post, wide: false);
												?>
											</div>
											<?php
											restore_current_blog();
										} else {
											echo "<!-- current blog id " . $current_blog_id . " EQUAL TO post site ID " . $post->site . "-->";
											$post = get_post($post->ID);
											?>
											<div class="cell xsmall-12 medium-6 large-4">
												<?php
												display_featured_post_card($post, wide: false);
												?>
											</div>
											<?php
										}
									}
									wp_reset_postdata(); // At the end reset your query 
									?>
									<div class="xsmall-12">
										<div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
											<?php
											echo custom_pagination_links(
												max_num_pages: $searchwp_query->max_num_pages,
												current_page: $search_page,
												base_url: '',
												query: $search_query
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
<?php
/**
 * Template Name: Search Page
 */
get_header();
$s = get_search_query();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number  
$args = array(
	's' => $s,
	'paged' => $paged,
	// pull default posts per page from settings
	'posts_per_page' => get_option('posts_per_page'),
	// Set the number of posts per page
	'orderby' => 'date',
	'order' => 'DESC'
);
// The Query
$query = new WP_Query($args);
?>
<main id="main" class="search-results">
	<div class="search-results__wrapper wrapper">
		<div class="row">
			<div class="search-results__content xsmall-12 cell">
				<div class="search-results__inner">
					<h1 class="font-special-2">
						<?php printf(esc_html__('Search Results for: %s', 'torba'), '<span>' . get_search_query() . '</span>'); ?>
					</h1>
					<hr>
					<form class="search-results__search" method="get" action="<?php echo get_site_url() ?>">
						<div class="form__field form__field--is-search form__field--is-valid">
							<input id="s" name="s" type="search" value="Site search" required="required">
							<label for="search" style="visibility:hidden;">Search term</label>
							<button type="submit" class="search-button">
								<span class="show-for-sr">Search term</span>

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
							<?php if ($query->have_posts()) {
								echo "Page " . $paged . " of " . $query->max_num_pages;
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

								<?php if ($query->have_posts()) {
									while ($query->have_posts()) {
										$query->the_post();
										?>
										<div class="cell xsmall-12 medium-6 large-4">
											<?php
											display_featured_post_card($post, wide: false);
											?>
										</div>
										<?php
									}
									wp_reset_postdata(); // At the end reset your query 
									?>
									<div class="xsmall-12">
										<div id="js-pagination" role="navigation" class="pagination aggregate__pagination">
											<?php
											echo custom_pagination_links(max_num_pages: $query->max_num_pages, current_page: $paged, base_url: '', query: $s);
											?>
										</div>
									</div>
									<?php
								} else {
									?>
									<div class="component">
										<div class="row level__row">
											<div class="level__content large-8 large-push-2 columns">
												<h1 class="page-title">No posts were found matching your query "
													<?php echo $s ?>"
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
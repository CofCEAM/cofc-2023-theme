<?php

/*
 *  
 * Template Name: Magazine
 * 
 */

get_header();

?>
<main id="main" class="aggregate aggregate--magazine">
	<div class="aggregate__wrapper wrapper">
		<div class="aggregate__inner">
			<div class="row level__row">
				<div class="aggregate__content xsmall-12 column">
					<div id="results-full-container" class="aggregate__set">
						<div class="aggregate__header--magazine">
							<h1 class="aggregate__title font-special-2">
								<?php the_title(); ?>
							</h1>
							<hr>
						</div>
						<?php dynamic_sidebar('magazine-main-featured-article-area'); ?>
					</div>
				</div>
			</div>
			<div class="row level__row grid-x grid-margin-x grid-margin-y cell">
				<?php dynamic_sidebar('magazine-sub-featured-articles-area'); ?>
			</div>
		</div>

		<div class="row level__row component grid-x grid-margin-x grid-margin-y cell">
			<!-- Current Issue -->
			<?php dynamic_sidebar('magazine-current-issue-area'); ?>
		</div>

		<div class="aggregate__subset">
			<div class="row level__row grid-x grid-margin-x grid-margin-y">
				<?php dynamic_sidebar('magazine-latest-issues-area'); ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
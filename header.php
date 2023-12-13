<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	// Check if we are on a single post or page and get the custom field values
	if (is_front_page() || is_home()) {
		$meta_description = esc_attr(get_option('meta_description'));
		$meta_author = esc_attr(get_option('meta_author'));
	} else if (is_single() || is_page()) {
		global $post;
		$meta_description = get_the_excerpt();
		$meta_author = get_the_author();
	}
	?>

	<meta name="description" content="<?php echo esc_attr($meta_description); ?>">
	<meta name="author" content="<?php echo esc_attr($meta_author) ?>">

	<?php
	wp_head();
	?>
</head>

<body>
	<?php do_action('after_body_open_tag'); ?>
	<header id="global-header" class="header">
		<div class="header__identity" style="background-color: <?php echo get_option('header_background_color') ?>">
			<div class="wrapper">
				<?php
				// get the home link for current site (account for multisite)
				$home_link = get_home_url();
				// get the current site's name
				$site_name = get_bloginfo('name');
				?>
				<a href="<?php echo $home_link ?>" class="logo">
					<span class="show-for-sr">Return to home</span>
					<span class="logo__svg wp_custom_site_logo">
						<?php
						$site_logo = get_option('site_logo'); // Get the site logo ID
						$logo_url = wp_get_attachment_image_src($site_logo, 'full'); // Get the URL of the image
						
						if ($logo_url): ?>
							<img src="<?php echo esc_url($logo_url[0]); ?>"
								alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri() . '/assets/images/cofc-default-logo.png'; ?>"
								alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
						<?php endif; ?>
					</span>
				</a>

				<div class="header__desktop">
					<nav class="nav-primary nav-primary--desktop" aria-label="Navigation Desktop">
						<?php wp_nav_menu(
							array(
								'container' => '',
								'items_wrap' => '<ul id="%1$s" class="%2$s nav-primary__list">%3$s</ul>',
								'theme_location' => 'header-navigation',
								'walker' => new HeaderNavigationCustomWalker()
							)
						); ?>

					</nav>

					<div class="search-desktop">

						<button class="search-desktop__toggle" aria-controls="search-form" aria-pressed="false"
							aria-label="Open site search">

							<svg class="brei-icon brei-icon-search" focusable="false">
								<use href="#brei-icon-search"></use>
							</svg>

							<svg class="brei-icon brei-icon-close" focusable="false">
								<use href="#brei-icon-close"></use>
							</svg>

						</button>

						<form id="search-form" class="search-desktop__form" method="get"
							action="<?php echo get_site_url() ?>" hidden>
							<label class="show-for-sr" for="q">What're you looking for?</label>
							<input name="s" id="s-desktop" class="search-desktop__input" type="search"
								placeholder="What're you looking for?" aria-label="Search" tabindex="-1">
						</form>

					</div>
				</div>

				<button class="header__toggle" aria-controls="header_navigation" aria-pressed="false"
					aria-label="Open primary navigation">

					<svg class="brei-icon brei-icon-menu" focusable="false">
						<use href="#brei-icon-menu"></use>
					</svg>

					<svg class="brei-icon brei-icon-close" focusable="false">
						<use href="#brei-icon-close"></use>
					</svg>

				</button>
			</div>
		</div>

		<div id="header_navigation" class="header__navigation">
			<div class="wrapper">
				<div class="search-mobile">
					<form id="search-form-mobile" class="form__field form__field--is-search" method="get"
						action="<?php echo get_site_url() ?>">
						<label for="s-mobile" class="show-for-sr">What're you looking for?</label>
						<input name="s" id="s-mobile" type="search" aria-label="Search"
							placeholder="What're you looking for?">
						<button type="submit" class="search-button">
							<span class="show-for-sr">Search</span>
							<svg class="brei-icon brei-icon-search" focusable="false">
								<use href="#brei-icon-search"></use>
							</svg>
						</button>
					</form>
				</div>
				<nav class="nav-primary nav-primary--mobile" aria-label="Navigation Mobile">
					<?php wp_nav_menu(
						array(
							'container' => '',
							'items_wrap' => '<ul id="%1$s" class="%2$s nav-primary__list">%3$s</ul>',
							'theme_location' => 'header-navigation',
							'walker' => new HeaderNavigationCustomWalker()
						)
					); ?>
				</nav>

			</div>
		</div>

	</header>
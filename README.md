# College of Charleston 2023 Theme

This is a Wordpress theme for College of Charleston Wordpress sites. This theme was built by Austin Hunt ahead of the January 10, 2024 launch of the new TCT website, and it leverages the design assets from Barkley provided during the 2023 website overhaul.

It was primarily built for The College Today but is also used by other sites like the [CofC Library website](https://library.charleston.edu/).

## Developing

This theme is by no means complete and is more of an MVP, and could greatly benefit from expanded development from other team members. Below are instructions for making modifications to the theme. These instructions are high-level and assume that you are familiar generally with WordPress theme development.

1. Create your own local (dev) Wordpress site. I use XAMPP housed in my `C:/xampp` folder for this on Windows. [View a tutorial here.](https://themeisle.com/blog/install-xampp-and-wordpress-locally/#gref) My test site path looks like `C:/xampp/htdocs/test-wordpress-site`.
   2.Navigate to the `wp-content/themes` folder of your local development site. In that folder, clone this repository. In my case, I end up with a path that looks like this: `C:/xampp/htdocs/test-wordpress-site/wp-content/themes/cofc-2023-theme`
2. Start up your web and MySQL servers as instructed in the link from the first step.
3. Open a browser and navigate to the Admin dashboard of your local wordpress site.
4. Open the `Appearance > Themes` dashboard. Select the `College of Charleston 2023` theme and activate it.
5. Checkout a new branch with a name that indicates what kind of feature or change you are adding/making: `git checkout -b <some-new-feature>`
6. Now you can get started with editing the theme locally in an IDE of your choice. I use VSCode. All of your changes will be reflected in the local development site that you are running in your browser.

Below, I have some instructions for some key types of changes you may be making to the theme.

### Creating a Custom Block

When you're editing a WordPress page with the block editor, basically every piece of content you add is a "block". There are quite a view default blocks that can be added to a page. You can try this by creating a new test page in your local wordpress site, hovering over the content area and clicking the plus button that appears. That brings up a block gallery that you can choose blocks from.

You may want to create a custom block if you want to display specific kinds of editable content in a specific format that is not provided by any of the default blocks. Here's how you can do that:

1. Open the [blocks/src](blocks/src/)
2. You should see a folder for each of the custom blocks that have already been created.
3. Copy one of those folders and give your copy a name indicative of what your custom block will do. Be sure to keep it lowercase and hyphenated like the others.
4. That folder contains: block.json, index.js, index.php, and then a React Component (JS) file that has a capitalized name. All of these files are important. I am not going to go into the weeds about what these files do or how to edit them, as that is background WordPress knowledge that you should have in order to make changes to this theme. You can refer to the Block Editor Handbook in the Wordpress documentation for information on how to leverage these files to create, edit, and test your custom block.
5. A few high-level things I do want to note:
   a. Prefix your block names with "CofC Theme" to distinguish the custom CofC theme blocks from the default WordPress blocks.
   b. You need to add your block to [functions.php](functions.php). At the bottom of that file, you need to add your block name to the $blocks aray in the `cofctheme_enqueue_custom_block_scripts` function. You also need to add a require statement pointing at the `blocks/src/<your block name>/index.php` file at the end of functions.php, same as the others. Otherwise, your block file will be ignored.
   c. Also, since you're dealing with React components with custom blocks, you need to run `npm run build` from the CLI inside the `blocks` folder any time you make changes to your custom block, particularly if you are editing either the block.json file, the index.js file, or the React component file.
   d. When you have done those steps, you can open a test page, add a new block, and search the gallery for your block name. If you don't see it, chances are it is not being included properly in the functions.php file. If you see it and you click it and it throws an error or doesn't render correctly, you're on the right path, but you need to view the console in the dev tools to track the error down.

## Committing and Pushing Your Changes

0. I again want to emphasize that you should be on a feature branch, rather than pushing directly to main. Even if you have already made your changes on your local `main` branch, you can still switch over to a new feature branch and maintain your edits with `git checkout -b some-new-feature`.
1. When you are finished making your changes and they are working completely as expected, you need to increment the version number in [style.css](style.css). This is critical in order for the `Git Updater` plugin on the target WordPress site(s) to recognize that a change has been made.
2. Now, stage and commit your changes to your `some-new-feature` branch:
   a. `git add -p . ` - type y for all of the changes you want to stage for commit
   b. `git commit -m "message describing your changes" `
3. Push your changes to the CofCEAM/cofc-2023-theme repo (the repo that is connected to the Git Updater plugin on the CofC Wordpress sites). `git push -u origin some-new-feature`
4. Open the repo in a browser. You should see a prompt to create a new pull request from the new branch into main. Create that pull request, and IDEALLY, have another team member review those changes. Once those changes have been reviewed and approved, go ahead and merge that feature branch into main (click Merge in the open pull request).
5. Now we move on to pulling that updated theme code from the repo into the site using Git Updater.
6. Assuming the site using the theme is on Pantheon:
   a. Open the DEV site's admin dashboard. Go to settings > Git Updater. Click Refresh Cache.
   b. You should see a new update notification next to Themes in the left navigation. Click Themes.
   c. You should see the CofC 2023 Theme has an update. Click update now.
   d. You have now updated the DEV site. You must use Pantheon to migrate those DEV changes up through TEST and to PROD. Generally speaking, **do not pull files and data down from live into test** as this often breaks the test site. Once you have migrated the code change (theme update) from DEV to TEST and from TEST to PROD in Pantheon, you can open the PROD site's admin dashboard and try to leverage your new feature in the site.

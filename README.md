# Bad Feather Nest
Version: 5.0.1

A starter theme for Bad Feather projects. It's useful for us, so hell, it might be helpful to you. A constant work in progress. Use at your own peril. 

This theme uses NPM, Grunt, SASS and PostCSS to lint, concatenate and minify CSS and Javascript, compress images, generate translation files, and probably more that I'm forgetting about. 

## Getting Started
### Installing
* Download or clone the theme
* Change the name of the folder to whatever your theme should be called, then:
  * Find in files `'nest'` and replace with `'yourtextdomain'`
  * Find in files `nest-` and replace with `yourtextdomain-`
  * Find in files `nest_` and replace with `yourtextdomain_`
  * Find in files `bad-feather-nest` and replace with `your-theme-name`
  * Find in files `Bad Feather Nest` and replace with `Your Theme Name`
  * Find in files `Text Domain: nest` and replace with `Text Domain: yourtextdomain`
  * Change the repository, theme location, author and version information as needed in `package.json` and `bower.json` and `assets/sass/style.scss`
  * Change the theme name and credit info in the `assets/sass/style.scss` or `style.css` file, depending on whether you're using SASS.
  * Replace existing `assets/img/favicon.ico` file with your own
  * Replace existing `assets/img/apple-touch-icon.png` file with your own. The current one is saved at 180 x 180 px. These get optimized and added to the `img` directory when you run `grunt`. 
* Run `npm install` to install all the default grunt dependencies
* Update the `README.md` with more relevant language for your project.
* Save out a new screenshot.png of your site at 1200 x 900 px.

### Customizing
#### JS
* Add any custom script files to the `assets/js/concat` directory.
* Install any javascript dependencies via bower by running `bower install [package-name]` - these files will be placed in `js/vendor/`
* These files can be concatenated to the `assets/js/build/theme.js` file by adding it to the `jsFileList` variable in the `Gruntfile.js`
* If you want to simply include them in your project, add a `wp_enqueue_script` call to the `inc/scripts.php` file

#### SASS
* Most style changes can/should be made in `assets/sass/variables/*.scss` and `assets/sass/theme/*.scss` files
* Most of the SCSS variables that have anything to do with sizes should be set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `$h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.

#### Grunt
* This theme uses Grunt to perform a number of tasks, including SASS, js, image, and svg processing and minification.
* To watch your files while editing, run `grunt watch` in terminal
* To build your project for deployment, run `grunt`
* Any `.jpg`, `.gif`, `.png` or `.svg` images placed in `assets/img`, will be minified to the `img` directory using imagemin upon running `grunt`
* Any `.svg` images placed in the `assets/img/svg-icons` directory will be combined into a single file `svg-icons.svg` in the `assets/img` directory. This will be included as an svg sprite at the top of the `<body>` if it exists.

##### Versioning
Version numbers get updated in the `.json` files, theme stylesheets and `README.md` with semantic versioning using the following commands:
* To performa a patch bump, ie. '0.0.1', run `grunt bump-patch`. 
* To perform a minor bump, ie. '0.1.0', run `grunt bump-minor`. 
* To perform a major bump, ie. '1.0.0', run `grunt bump-major`. 

#### Style Tester
* Included is a very low-level style-testing guide of sorts. To use, open `assets/docs/style-tester.html`, copy all the contents, and paste in a new post or page on your Wordpress install in Text (not Visual) editing mode. Save this as a draft, then preview. Now you can see your type styles in action. For more thorough testing of your theme, download and import WordPress' [Theme Unit Test](https://codex.wordpress.org/Theme_Unit_Test).

#### Good luck
* As with all things code-related, the only real way to understand where I'm coming from is to read the code and scratch your head.
* Edit, add to or remove what ye may. If it's something that would be a worthy change to the Nest, esp. relating to the below goals, lemme know!

## Theme Goals

### SASS/CSS
* Handle all customizations through `assets/sass/variables/*.scss`files and `assets/sass/theme/*.scss` files.
* Provide variables and mixins for everything I might need.
* Many mixins apply styles only if they're different than the default. This comes in handy in terms of keeping the CSS lean.
* Use consistent patterns for variable names.
* On the scaling front, I've decided to go with percentages and `em`s, 'cause, well, I like 'em. This means there's a lot of math going on via mixins, which I'll admit, creates some ugly numbers. Yes, I know about `rem`s, and I'm well aware that most modern browsers handle `px` scaling pretty darned well. Anyway, to make `em`s work, one must be careful about inheritance, which can cause some unwanted multiplication. For that reason, set as many font sizes as possible globally, avoid setting font sizes on containers, pay special attention to nested elements, and utilize classes and descendant selectors (within reason - don't over-specify!) for specific styles.
* Keep outputted CSS lean by minimizing specificity and utilizing SCSS extends wherever possible to group rules.
* Rethinking each mixin or style rule poached from a framework - still work to do on this.
* Compartmentalize the SCSS files enough to make it easy to find what I'm looking for.

### HTML
* Provide enough classes and containers to target what I need in the CSS with as little specificity as possible, but not get obnoxious about it.
* Keep class names reasonably semantic, opting for describing their function more than their presentation.
* If not use SMACSS and BEM methodologies outright, at least get what they're going for and strive for something similar.
* Validate! Keep it accessible.
* Establish a clear document outline via the HTML5 structure.

### JS
* Keep the scripts lean by concatenating and minifying whenever possible and minimizing the amount of calls to external scripts.

### Theme
* Keep it reasonably DRY, ie. by utilizing functions and `get_template_part())` wherever possible for re-used blocks.
* Provide enough structure for a baseline and establish patterns that can be expanded when building more complex sites that utilize custom post types and taxonomies.
* Compartmentalize functions enough to make it easy to find what I'm looking for.
* Use theme development best-practices, making it as flexible as possible.
* Provide functions for things I find myself needing on most sites, ie. for social sharing, subnavs, getting the first images from posts, etc. Most of these are in the `inc/template_tags.php` directory.

### Many concepts inspired by and/or mercilessly stolen from, and not limited to:
* [Underscores](http://underscores.me/)
* [wd_s](https://github.com/WebDevStudios/wd_s)
* [Roots](http://roots.io/)
* [Bootstrap](http://getbootstrap.com)

Thanks to their respective authors. If you're ever in Philly, drop me a line and I'll buy you a beer.

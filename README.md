# Bad Feather Nest
Version: 6.1.0

A starter theme for Bad Feather projects. It's useful for us, so hell, it might be helpful to you. A constant work in progress. Use at your own peril. 

This theme uses NPM, Grunt, SASS and PostCSS to lint, concatenate and minify CSS and Javascript, compress images, generate translation files, and probably more that I'm forgetting about. 

## Getting Started
### Installing
* Download or clone the theme
* Change the name of the folder to whatever your theme should be called, then:
  * Find in files `bfnest` and replace with `yourtextdomain`
  * Find in files `Bad Feather Nest` and replace with `Your Theme Name`
  * Change the repository, theme location, author and version information as needed in `package.json`,`bower.json`, and `style.css`
  * Change the theme name and credit info in the `assets/sass/style.scss` or `style.css` file, depending on whether you're using SASS.
  * Replace existing `assets/src/img/apple-touch-icon.png` file with your own. The current one is saved at 180 x 180 px. These get optimized and added to the `assets/dist/img` directory when you run `grunt`. 
  * Replace existing `assets/dist/favicon.ico` file with your own. The grunt task to minify images does not handle .ico files
  
* Run `npm install` to install all the default grunt dependencies
* Update the `README.md` with more relevant language for your project.
* Save out a new screenshot.png of your site at 1200 x 900 px.

### Customizing
#### JS
* Add any custom script files to the `assets/src/js` directory.
* Install any javascript dependencies via bower by running `bower install [package-name]` - these files will be placed in `assets/src/vendor/`
* Concatenate files can be concatenated to the `assets/dist/js/` directory file in the concat section of `Gruntfile.js`
* If you want to include the concatenated files in your project, add `wp_enqueue_script` calls as necessary in the `inc/scripts.php` file

#### SASS
* Most style changes can/should be made in `assets/src/sass/variables/*.scss` and `assets/src/sass/theme/*.scss` files
* Most of the SCSS variables that have anything to do with sizes should be set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `$h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'partials/content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.

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
* Included is a very low-level style-tester custom page template. To use in your theme, set a page in your site to use that template. To add content to the style tester, edit `partials/style-tester.php`

#### Good luck
* As with all things code-related, the only real way to understand where I'm coming from is to read the code and scratch your head.
* Edit, add to or remove what ye may. If it's something that would be a worthy change to the Nest, esp. relating to the below goals, lemme know!

## Theme Goals

### SASS/CSS
* Handle all customizations through `assets/src/sass/variables/*.scss`files and `assets/src/sass/theme/*.scss` files.
* Provide variables and mixins for everything I might need.
* Many mixins apply styles only if they're different than the default. This comes in handy in terms of keeping the CSS lean.
* Use consistent patterns for variable names.
* This site utilizes a SASS function called `unitcalc()` wherever necessary for sizing. In `assets/src/variables/_variables-base.scss`, there's a `$base__unit` variable that accepts `rem`, `px`, or `em`, which gets passed on to unitcalc to declare sizes. By default, this is set to `rem`.
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

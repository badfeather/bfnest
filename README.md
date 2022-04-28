# Bad Feather Nest
Version: 7.1.1

A starter theme for Bad Feather projects. It's useful for us, so hell, it might be helpful to you. A constant work in progress. Use at your own peril.

This theme uses NPM scripts, along with Rollup.js, SASS, ESLint, and PostCSS to lint, concatenate and minify CSS and Javascript, compress images, and probably more that I'm forgetting about.

## Version 7.1 breaking changes:
* Ditched all of the text variables and complicated style-change mixins in favor of just styling things inline on the elements. In short, the goal of reducing abstraction continues. 
* Added more CSS variables for spacing, font-sizes, and font-families. In other words, CSS variables are great.
* Killed the CSS sass maps for now. 

## Version 7.0 breaking changes:
* SASS design system has been largely overhauled with the following goals:
  * Add CSS variables for basic settings (colors)
  * Reduce abstraction and folder nesting
  * Reduce overuse of variables and mixins
  * Fold reset styles into native elements
  * Style native elements over classes wherever possible
* Grunt has been replaced with NPM scripts as a build tool
* Bower has been removed. Recommend using NPM or Yarn
* Imagemin has been removed from the build tools due to the extension no longer maintained and has security vulnerabilities in its dependencies. We recommend minifying theme images on your local machine using [ImageOptim](https://imageoptim.com/mac) before saving to the `assets/dist/img` folder. We may revisit integrating  [Squoosh](https://github.com/GoogleChromeLabs/squoosh) into the build process.
* Svgmin has been removed from the build tools. We recommend using [SVGOMG](https://jakearchibald.github.io/svgomg/) or [ImageOptim](https://imageoptim.com/mac) before saving SVGs to the `assets/dist/img` folder. We may revisit integrating SVGO into the build process.
* Svgstore has been removed from the build tools. We may revisit integrating [svg-min](https://github.com/svg-sprite/svg-sprite) into the build process.
* i18N has been removed from build tools. If required, use [WP-CLI](https://developer.wordpress.org/cli/commands/i18n/make-pot/) to generate .pot files.

## Getting Started
### Installing
* Download or clone the theme
* Change the name of the folder to whatever your theme should be called, then:
  * Find in files `bfnest` and replace with `yourtextdomain`
  * Find in files `Bad Feather Nest` and replace with `Your Theme Name`
  * Find production url `https://bfnest.com` and replace with `https://yourproductionurl.com`
  * Change the repository, theme location, author and version information as needed in `package.json` and `style.css`
  * Replace existing `apple-touch-icon.png`, `favicon.ico`, and `favicon.svg` files with your own in the `assets/dist/img` directory.

* Run `npm install` to install all the default dependencies
* Update the `README.md` with more relevant language for your project.
* Save out a new screenshot.png for your site at 1200 x 900 px.
* Run `npm run build` to build all dist assets

### Customizing
#### JS
* Add any custom script files to the `assets/src/js` directory
* Concatenate files can be concatenated to the `assets/dist/js/` directory file in the `concat-js` command in the `package.json` file
* If you want to include the concatenated files in your project, add `wp_enqueue_script` calls as necessary in the `inc/scripts.php` file

#### SASS
* Most style changes can/should be made in `assets/src/sass/variables/*.scss` and `assets/src/sass/theme/*.scss` files
* Most of the SCSS variables that have anything to do with sizes should be set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `$h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'partials/content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.

#### NPM Scripts
This theme uses NPM Scripts as a build tool, and performs SASS compiling to CSS, PostCSS actions and minification, JS linting and concatenation, and version bumping. The actions below should be performed in terminal in your theme directory:
* To watch your JS and SASS and CSS files while editing, run `npm run watch`
* To build your project for deployment, run `npm run build`. In addition to building your compiled CSS and JS files
* To bump your version manually (patch versions happen on every build), you can run `npm run bump:patch`, `npm run bump:minor`, or `npm run bump:major`

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

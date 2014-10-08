# Nest

A starter theme (not to be confused with a parent theme or framework) for Bad Feather projects. It's semi-useful for us, so hell, it might be semi-helpful to you. A constant work in progress. Use at your own peril.

### Getting Started
* After downloading theme, change the name of the folder to whatever your theme is called, then:
  * Find in files `'nest'` and replace with `'yourtextdomain'`
  * Find in files `nest_` and replace with `yourtextdomain`
  * Change the theme name and credit info in the `style.less` or `style.css` file, depending on whether you're using LESS.
* Install any javascript dependencies via bower - these files will be placed in js/vendor/
* Most style changes can be made in `less/variables.less` and `less/theme.less`
* Most of the LESS variables that have anything to do with sizes are based on pixel amounts but set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `@h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.
* Most of the script includes happen in the `inc/scripts.php` file. If you want to add to or remove some, that's where you should look.
* As with all things code-related, the only real way to understand where I'm coming from is to read the code and scratch your head.
* Edit, add to or remove what ye may. If it's something that would be a worthy change to the Nest, esp. relating to the below goals, lemme know!

### Theme Goals
#### LESS/CSS
* Handle all customizations through `less/variables.less` and `less/theme.less`.
* Provide variables for everything I might need, either in mixins or base styles.
* Use consistent patterns for variable names.
* On the scaling front, I've decided to go with percentages and `em`s, 'cause, well, I like 'em. This means there's a lot of math going on via mixins, which I'll admit, creates some ugly numbers. Yes, I know about `rem`s, and I'm well aware that most modern browsers handle `px` scaling pretty darned well. Anyway, to make `em`s work, one must be careful about inheritence, which can cause some unwanted multiplication. For that reason, set as many font sizes as possible globally, avoid setting font sizes on containers, pay special attention to nested elements, and utilize classes and descentent selectors (within reason - don't over-specify!) to target unique cases.
* Keep outputted CSS lean by minimizing specificity and utilizing LESS extends wherever possible to group rules.
* Rethinking each mixin or style rule poached from a framework - still work to do on this.
* Compartmentalize the LESS files enough to make it easy to find what I'm looking for, but not get obnoxious about it.

#### HTML
* Provide enough classes and containers to target what I need in the CSS with as little specificity as possible, but not get obnoxious about it.
* Keep class names reasonably semantic, opting for describing their function more than their presentation.
* If not use SMACSS and BEM methodoligies outright, at least get what they're going for and strive for something similar.
* Validate! Keep it accessible.
* Establish a clear document outline via the HTML5 structure.

#### Javascript
* Provide enough vendor scripts, ie. Modernizr, Respond.js, etc. to make responsive sites, but not get obnoxious about it. I probably need to revisit this.
* Keep the scripts lean by concatenating and minifying whenever possible and minimizing the amount of calls to external scripts.


#### Theme
* Keep it reasonably DRY, ie. by utilizing `get_template_part())` wherever possible for re-used blocks.
* Provide enough structure for a baseline and establish patterns that can be expanded when building more complex sites that utilize custom post types and taxonomies.
* Compartmentalize functions enough to make it easy to find what I'm looking for, but not get obnoxious about it.
* Use theme development best-practices, making it as flexible as possible.
* Provide functions for things I find myself needing on most sites, ie. for social sharing, subnavs, getting the first images from posts, etc. Most of these are in the `inc/template_tags.php` directory.

### Many theme concepts cobbled together and/or mercilessly stolen from, and not limited to:
* [Underscores](http://underscores.me/)
* [Roots](http://roots.io/)
* [Bootstrap](http://getbootstrap.com)
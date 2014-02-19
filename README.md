# Bad Feather Nest

A starter theme for Bad Feather projects. It's semi-useful for us, so hell, it might be semi-helpful to you. A constant work in progress. Use at your own peril.

### Getting Started
* Most style changes can be made in `less/variables.less` and `less/theme.less`
* Most of the LESS variables that have anything to do with sizes are based on pixel amounts but set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `@h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'part/content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.

### Theme Goals
#### LESS/CSS
* Handle all customizations through `less/variables.less` and `less/theme.less`.
* Provide variables for everything I might need, either in mixins or base styles.
* Use consistent patterns for variable names
* Keep outputted CSS as lean as possible, utilizing LESS extends wherever possible
* Rethinking each mixin or style rule poached from a framework - still work to do on this
* Compartmentalize the LESS files enough to make it easy to find what I'm looking for, but not get obnoxious about it

#### HTML markup
* Provide enough classes and containers to target what I need in the CSS with as little specificity as possible, but not get obnoxious about it
* Make it valid
* Establish a clear document outline via the HTML5 structure

#### Theme
* Keep it reasonably DRY, ie. by utilizing `get_template_part())` wherever possible for re-used blocks
* Provide enough structure for a baseline and establish patterns that can be expanded when building more complex sites that utilize custom post types and taxonomies
* Compartmentalize functions enough to make it easy to find what I'm looking for, but not get obnoxious about it
* Use theme development best-practices, making it as flexible as possible


### Many theme concepts cobbled together and/or mercilessly stolen from, and not limited to:
* [Underscores](http://underscores.me/)
* [Roots](http://roots.io/)
* [Bootstrap](http://getbootstrap.com)
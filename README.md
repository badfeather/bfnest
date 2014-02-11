Bad Feather Nest
================

A starter theme for Bad Feather projects. It's semi-useful for us, so hell, it might be semi-helpful to you. A constant work in progress. Use at your own peril.

## Getting Started:
* Most style changes can be made in `less/variables.less` and `less/theme.less`
* Most of the LESS variables that have anything to do with sizes are based on pixel amounts but set unitless, as the majority of the sizing is calculated to in `em`s. For example, if you want the `h2`s to have a font-size of 20px, you would declare `@h2-font-size: 20`.
* The `archive.php`, `single.php`, etc. all use `get_template_part( 'part/content', get_post_type() )`. This can come in handy if you start adding custom post types, in which case you could add a `content-[post-type-name].php` to the `part` directory.

## Many theme concepts cobbled together and/or mercilessly stolen from, and not limited to:
* [Underscores](http://underscores.me/)
* [Roots](http://roots.io/)
* [Bootstrap](http://getbootstrap.com)
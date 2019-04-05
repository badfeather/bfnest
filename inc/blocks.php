<?php
function bfnest_enqueue_block_assets() {
    wp_enqueue_script(
        'bfnest-block-filters',
        get_template_directory_uri() . '/assets/dist/js/block-filters.js',
        ['wp-blocks']
    );
}
add_action( 'enqueue_block_editor_assets', 'bfnest_enqueue_block_assets' );
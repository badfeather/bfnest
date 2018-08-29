<?php
	$post_type = ( is_post_type_archive() ? get_query_var( 'post_type' ) : '' );
?>
<?php get_header(); ?>

		<div id="content" class="doc doc--archive site-main">
			<div class="inner doc__inner">
				<main class="doc-main">
					<?php
						if ( have_posts() ) {
							get_template_part( 'template-parts/content-archive', $post_type );

						} else {
							get_template_part( 'template-parts/content-no-results' );
						}
					?>
				</main>
				<?php get_template_part( 'template-parts/sidebar-archive', $post_type ); ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--archive.site-main ?>

<?php get_footer(); ?>

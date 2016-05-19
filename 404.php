<?php get_header(); ?>

	<div class="inner doc__inner">
		<main class="doc__main doc__main--single" role="main">

			<?php get_template_part( 'content', 'no-results' ); ?>

		</main><?php // /.doc__main.doc__main--single ?>

		<?php get_sidebar(); ?>
	</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

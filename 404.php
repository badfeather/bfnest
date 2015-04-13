<?php get_header(); ?>

		<section class="doc site-main">

			<main class="doc-main doc-main--single" role="main">

				<header class="doc-header">
					<h1 class="doc-title"><?php _e( 'Not Found', 'nest' ); ?></h1>
				</header><?php // /.doc-header ?>

				<div class="doc-content">
					<p><?php _e( 'Sorry, but the page you were trying to view does not exist.', 'nest' ); ?></p>
				</div><?php // /.doc-content ?>

			</main><?php // /.doc-main.doc-main--single ?>

			<?php get_sidebar(); ?>

		</section><?php // /.doc.site-main ?>

<?php get_footer(); ?>

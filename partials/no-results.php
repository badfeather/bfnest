<div class="doc doc--page doc--page-404">
	<main id="doc-main" class="doc-main">
		<header id="doc-header" class="doc-header">
			<h1 class="doc-title entry-title"><?php _e( 'Nothing Found', 'bfnest' ); ?></h1>
		</header>

		<div id="doc-content" class="doc-content">
			<div class="entry-content">
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bfnest' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</main>

	<?php get_template_part( 'partials/sidebar', '404' ); ?>
</div>


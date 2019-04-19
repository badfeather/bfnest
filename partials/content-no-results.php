<div class="doc doc--page doc--page-404">
	<main id="content" class="site-main">
		<header class="doc__header">
			<h1 class="doc__title entry-title"><?php _e( 'Nothing Found', 'bfnest' ); ?></h1>
		</header>

		<div class="doc__content">
			<div class="entry-content">
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bfnest' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</main>

	<?php get_template_part( 'partials/sidebar', '404' ); ?>
</div>


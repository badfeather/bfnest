<main class="main" role="main">
	<header class="doc-header">
		<h1 class="doc-title"><?php _e( 'Nothing Found', 'nest' ); ?></h1>
	</header><!-- /.doc-header -->

	<div class="doc-main">

		<div class="entry-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'nest' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php } elseif ( is_search() ) { ?>

				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nest' ); ?></p>
				<?php get_search_form(); ?>

			<?php } else { ?>

				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nest' ); ?></p>
				<?php get_search_form(); ?>

			<?php } ?>
		</div><!-- /.entry-content -->

	</div><!-- /.doc-main -->
</main>

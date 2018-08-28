<main class="doc-main">

	<header class="doc-header">
		<h1 class="doc-title"><?php printf( __( 'Search Results for %s', 'nest' ), get_search_query() ); ?></h1>
	</header>

	<?php get_template_part( 'template-parts/loop-archive' ); ?>

</main><?php // /.doc-main ?>

<?php get_template_part( 'template-parts/sidebar-archive' ); ?>

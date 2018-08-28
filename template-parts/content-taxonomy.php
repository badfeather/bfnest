<?php
	if ( have_posts() ) {
		$term = get_queried_object();
		$term_description = $term->description;
?>
<main class="doc-main">

	<header class="doc-header">
		<h1 class="doc-title"><?php echo $term->name; ?></h1>

		<?php
			// Show an optional term description.
			if ( ! empty( $term_description ) && ! is_paged() )
				printf( __( '<div class="description">%s</div>', 'nest' ), $term_description );
		?>
	</header>

	<?php get_template_part( 'template-parts/loop-archive' ); ?>

</main><?php // /.doc-main ?>

<?php get_template_part( 'template-parts/taxonomy', $term->taxonomy ); ?>

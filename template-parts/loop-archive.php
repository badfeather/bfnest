<div id="content" class="doc-content entries">

	<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		} // endwhile
	?>

</div><?php // /#content.doc-content.entries ?>

<?php nest_postnav_archive(); ?>

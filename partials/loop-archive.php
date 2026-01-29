<div id="doc-content" class="doc-content entries">
	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'partials/entry-card', get_post_type() );
	}
	?>
</div>

<?php bfnest_postnav_archive(); ?>

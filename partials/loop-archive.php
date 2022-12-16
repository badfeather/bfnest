<div class="doc-content entries cards row">
	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'partials/entry-card', get_post_type() );
	}
	?>
</div>

<?php bfnest_postnav_archive(); ?>

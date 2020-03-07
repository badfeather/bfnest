<div class="doc-content entries">
	<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'partials/entry', get_post_type() );
		} // endwhile
	?>
</div>

<?php bfnest_postnav_archive(); ?>

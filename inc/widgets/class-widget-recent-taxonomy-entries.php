<?php
class sstk_recent_taxonomy_entries extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_taxonomy_entries',
			'description' => __( 'Your site&#8217;s most recent posts, by taxonomy term.', 'sstk' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'recent-taxonomy-entries', __( 'Recent Taxonomy Entries', 'sstk' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$post_type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : 'post';
		$taxonomy = ( ! empty( $instance['taxonomy'] ) ) ? $instance['taxonomy'] : 'category';
		$term = ( ! empty( $instance['term'] ) ) ? $instance['term'] : '';
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : sprintf( __( 'Recent Entries in %1$s', 'sstk' ), $instance['term'] );

		$tax_query = '';
		if ( $taxonomy && $tax_query ) {
			$tax_query = array( array(
				'taxonomy' => $taxonomy,
				'terms' => $term,
				'field' => 'term_id'
			) );
		}

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		$exclude = ( ! empty( $instance['exclude'] ) ) ? $instance['exclude'] : '';
		$content_part = ( ! empty( $instance['content_part'] ) ) ? $instance['content_part'] : '';
		if ( ! $content_part ) {
			$content_part = $post_type;
		}

		$r = new WP_Query( array(
			'post_type' => $post_type,
			'tax_query' => $tax_query,
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'ignore_sticky_posts' => true,
			'exclude' => $exclude
		) );

		if ( $r->have_posts() ) {
			echo $args['before_widget'];

			if ( $title && ! $untitled ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			while ( $r->have_posts() ) {
				$r->the_post();
				get_template_part( 'content', $content_part );
			} // endwhile
			wp_reset_postdata();

			echo $args['after_widget'];
		} // endif
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['post_type'] = $new_instance['post_type'];
		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['term'] = $new_instance['term'];
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['untitled'] = strip_tags( $new_instance['untitled'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['content_part'] = sanitize_text_field( $new_instance( 'content_part' ) );
		$instance['exclude'] = sanitize_text_field( $new_instance['exclude'] );
		return $instance;
	}

	public function form( $instance ) {

		//Defaults
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'post_type' => 'post',
				'taxonomy' => 'category',
				'term' => '',
				'title' => '',
				'untitled' => 0,
				'number' => 5,
				'content_part' => '',
				'exclude' => ''
			)
		);
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php _e( 'Post Type:' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" class="widefat">
				<option value="post"<?php selected( $instance['post_type'], 'post' ); ?>><?php _e( 'Posts' ); ?></option>
				<?php
					$post_types = get_post_types(
						array(
							'public' => true,
							//'_builtin' => false
						),
						'objects'
					);
					foreach( $post_types as $post_type ) {
					 echo '<option value="' . $post_type->name . '"' . selected( $instance['post_type'], $post_type->name, false ) . '>' . $post_type->label . '</option>' . "\n";
					} // endforeach
				?>
			</select>
			<br />
			<small><?php _e( 'Defaults to Post.' ); ?></small>
		</p>

		<?php
			$taxonomies = get_object_taxonomies( $instance['post_type'], 'objects' );
			if ( ! empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( 'Taxonomy:' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" class="widefat">
				<?php
					foreach( $taxonomies as $taxonomy ) {
						//print_r($taxonomy);
						echo '<option value="' . $taxonomy->name . '"' . selected( $instance['taxonomy'], $taxonomy->name, false ) . '>' . $taxonomy->label . '</option>' . "\n";
					} // endforeach
				?>
			</select>
			<br />
			<small><?php _e( 'Select a taxonomy associated with this post type.' ); ?></small>
		</p>
		<?php } // endif ?>


		<?php
			if ( ! empty( $instance['taxonomy'] ) ) {
				$terms = get_terms( $instance['taxonomy'] );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'term' ) ); ?>"><?php _e( 'Term:' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'term' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'term' ) ); ?>" class="widefat">
			<?php
				foreach( get_terms( $instance['taxonomy'] ) as $term ) {
					echo '<option value="' . $term->term_id . '"' . selected( $instance['term'], $term->term_id, false ) . '>' . $term->name . '</option>' . "\n";
				} // endforeach
			?>
			</select>
			<small><?php _e( 'Select term from the above dropdown.' ); ?></small>
		</p>
		<?php
				} // endif
			} // endif
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			<br />
			<small><?php sprintf( __( 'If title field is left empty, defaults to "Recent Entries in %1$s"', 'sstk' ), $instance['term'] ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>"><?php _e( 'No Title:' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'untitled' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['untitled'] ); ?> />
			<br />
			<small><?php _e( 'Check box if the title should be removed entirely.' ); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo absint( $instance['number'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php _e( 'Exclude:' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['exclude'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />
			<br />
			<small><?php _e( 'Term IDs to exclude, separated by commas.' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content_part' ) ); ?>"><?php _e( 'Content Part:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content_part' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_part' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['content_part'] ); ?>" />
			<br />
			<small><?php _e( 'Enter the name of the php template file after \'content-\', excluding the \'.php\' extension. defaults to \'[post_type]\', which would call \'content-[post_type].php, or \'content.php\' if no post-type specific template file exists.', 'sstk' ); ?></small>
		</p>
		<?php
	}
}



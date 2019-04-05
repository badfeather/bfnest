<?php
/**
 * Displays subnavigation menu, listing descendants of top parent of current page
 */
class bfnest_widget_taxonomy_subnav extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget--taxonomy-subnav',
			'description' => __( 'A menu list of descendants of top parent Taxonomy.', 'bfnest' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'taxonomy_subnav', __( 'Taxonomy Subnav', 'bfnest' ), $widget_ops );
	}

	public function widget( $args, $instance ) {

		$taxonomy = $instance['taxonomy'];
		$top_parent = bfnest_get_top_parent_term( $taxonomy );
		if ( ! $top_parent ) {
			return false;
		}

		$title = empty( $instance['title'] ) ? get_the_title( $top_parent ) : $instance['title'];
		$untitled = empty( $instance['untitled'] ) ? 0 : 1;
		$orderby = $instance['orderby'];
		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];
		$depth = empty( $instance['depth'] ) ? 0 : $instance['depth'];

		if ( $orderby == 'menu_order' ) {
			$orderby = 'menu_order, post_title';
		}

		$out = wp_list_categories( array(
			'child_of' => $top_parent->term_id,
			'title_li' => '',
			'echo' => 0,
			'taxonomy' => $taxonomy,
			'show_option_none' => '',
			'exclude' => $exclude,
			'orderby' => $orderby
		) );

		if ( ! empty( $out ) ) {
			echo $args['before_widget'];

			if ( $title && ! $untitled ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		?>
		<ul class="menu menu--secondary menu--taxonomies">
			<?php echo $out; ?>
		</ul>
		<?php
			echo $args['after_widget'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['untitled'] = strip_tags( $new_instance['untitled'] );

		if ( in_array( $new_instance['orderby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['orderby'] = $new_instance['orderby'];
		} else {
			$instance['orderby'] = 'menu_order';
		}

		$instance['exclude'] = sanitize_text_field( $new_instance['exclude'] );
		$instance['depth'] = sanitize_text_field( $new_instance['depth'] );

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'taxonomy' => 'category',
				'orderby' => 'name',
				'title' => '',
				'untitled' => 0,
				'depth' => 0,
				'exclude' => ''
			)
		);
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( 'Taxonomy:', 'bfnest' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" class="widefat">
				<option value="category"<?php selected( $instance['taxonomy'], 'category' ); ?>><?php _e( 'Categories', 'bfnest' ); ?></option>
				<?php
					// get all public hierarchical taxonomies that aren't builtin (categories)
					$custom_taxonomies = get_taxonomies(
						array(
							'public'  => true,
							'_builtin' => false,
							'object_type' => array( 'hierarchical' => true ),
						),
						'objects'
					);
					foreach( $custom_taxonomies as $tax ) {
						//print_r($tax);
				?>
				<option value="<?php echo $tax->name; ?>"<?php selected( $instance['taxonomy'], $tax->name ); ?>><?php echo $tax->label; ?></option>
				<?php
					}
				?>
			</select>
			<br />
			<small><?php _e( 'Defaults to category.', 'bfnest' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bfnest' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			<br />
			<small><?php _e( 'If title field is left empty, displays title of top parent category.', 'bfnest' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>"><?php _e( 'No Title:', 'bfnest' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'untitled' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['untitled'] ); ?> />
			<br />
			<small><?php _e( 'Check box if the title should be removed entirely.', 'bfnest' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order by:', 'bfnest' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" class="widefat">
				<option value="post_title"<?php selected( $instance['orderby'], 'name' ); ?>><?php _e( 'Name', 'bfnest' ); ?></option>
				<option value="ID"<?php selected( $instance['orderby'], 'id' ); ?>><?php _e( 'ID', 'bfnest' ); ?></option>
			</select>
			<br />
			<small><?php _e( 'Defaults to page order.', 'bfnest' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php _e( 'Depth:', 'bfnest' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>" class="widefat">
				<option value="0"<?php selected( $instance['depth'], 0 ); ?>><?php _e( '0 - Show all children', 'bfnest' ); ?></option>
				<option value="1"<?php selected( $instance['depth'], 1 ); ?>><?php _e( '1 - Show only immediate children', 'bfnest' ); ?></option>
				<option value="2"<?php selected( $instance['depth'], 2 ); ?>><?php _e( '2 - Show children and grandchildren', 'bfnest' ); ?></option>
			</select>
			<br />
			<small><?php _e( 'Defaults to 0 - Show all children.', 'bfnest' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php _e( 'Exclude:', 'bfnest' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['exclude'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />
			<br />
			<small><?php _e( 'Page IDs, separated by commas.', 'bfnest' ); ?></small>
		</p>
		<?php
	}

}

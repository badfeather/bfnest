<?php
/**
 * Displays subnavigation menu, listing descendants of top parent of current page
 */
class nest_widget_pages_subnav extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget--pages-subnav',
			'description' => __( 'A menu list of descendants of top parent Page.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'pages_subnav', __( 'Page Subnav' ), $widget_ops );
	}

	public function widget( $args, $instance ) {

		$page_id = get_the_ID();
		$top_parent = nest_get_top_parent_page_id( $page_id );

		if ( ! $top_parent ) {
			return false;
		}

		$title = empty( $instance['title'] ) ? get_the_title( $top_parent ) : $instance['title'];
		$untitled = empty( $instance['untitled'] ) ? 0 : 1;
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];
		$depth = empty( $instance['depth'] ) ? 0 : $instance['depth'];

		if ( $sortby == 'menu_order' ) {
			$sortby = 'menu_order, post_title';
		}

		$out = wp_list_pages( apply_filters( 'widget_pages_subnav_args', array(
			'title_li'	=> '',
			'echo'		=> 0,
			'sort_column' => $sortby,
			'exclude'		=> $exclude,
			'depth' => $depth,
			'child_of' => $top_parent
		) ) );

		if ( ! empty( $out ) ) {
			echo $args['before_widget'];

			if ( $title && ! $untitled ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		?>
		<ul class="menu menu--secondary">
			<?php echo $out; ?>
		</ul>
		<?php
			echo $args['after_widget'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['untitled'] = strip_tags( $new_instance['untitled'] );

		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}

		$instance['exclude'] = sanitize_text_field( $new_instance['exclude'] );
		$instance['depth'] = sanitize_text_field( $new_instance['depth'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the Pages widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'sortby' => 'post_title',
				'title' => '',
				'untitled' => 0,
				'depth' => 0,
				'exclude' => ''
			)
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			<br />
			<small><?php _e( 'If title field is left empty, displays title of top parent category.' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>"><?php _e( 'No Title:' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'untitled' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'untitled' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['untitled'] ); ?> />
			<br />
			<small><?php _e( 'Check box if the title should be removed entirely.' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php _e( 'Sort by:' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e( 'Page order' ); ?></option>
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e( 'Page title' ); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID' ); ?></option>
			</select>
			<br />
			<small><?php _e( 'Defaults to page order.' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php _e( 'Depth:' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>" class="widefat">
				<option value="0"<?php selected( $instance['depth'], 0 ); ?>><?php _e( '0 - Show all children' ); ?></option>
				<option value="1"<?php selected( $instance['depth'], 1 ); ?>><?php _e( '1 - Show only immediate children' ); ?></option>
				<option value="2"<?php selected( $instance['depth'], 2 ); ?>><?php _e( '2 - Show children and grandchildren' ); ?></option>
			</select>
			<br />
			<small><?php _e( 'Defaults to 0 - Show all children.' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php _e( 'Exclude:' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['exclude'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />
			<br />
			<small><?php _e( 'Page IDs, separated by commas.' ); ?></small>
		</p>
		<?php
	}

}

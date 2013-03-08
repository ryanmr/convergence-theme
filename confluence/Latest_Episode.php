<?php

class Latest_Episode extends WP_Widget {

	const name = 'Latest Episode';
	const slug = 'latest-episode';

	public function Latest_Episode() {
		$options = array(
			'classname' => self::slug,
			'description' => 'A plugin for displaying the latest episode.'
		);
		$this->WP_Widget(self::slug, self::name, $options);
		$this->add_actions();
	}

	public function add_actions() {
		add_action('save_post', array($this, 'update_post'), 1, 2);
	}

	public function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$widget_title = empty($instance['widget_title']) ? '' : apply_filters('latest_episode_widget_title', $instance['widget_title']);
		$query = $this->get_episode();
		include('widget-views/latest-episode.php');	
	}

	public function update($new, $old) {
		$instance = $old;
		$instance['widget_title'] = $this->strip($new_instance, 'widget_title');
		return $instance;
	}

	public function form($instance) {
		$instance = wp_parse_args(
			(array)$instance,
			array('widget_title' => '')
		);
		$widget_title = $this->strip($instance, 'widget_title');
		include('widget-views/latest-episode-admin.php');
	}

	private function get_episode() {

		$query = get_transient('nx_latest_episode');

		if ( false === $query ) {

			$args = array(
				"post_type" => "episode",
				"posts_per_page" => 1,
			);
			$args = convergence_exclude_category('tf', $args);
			$args = apply_filters('confluence_latest_episode_args', $args);
			$query = new WP_Query($args);
			set_transient('nx_latest_episode', $query, 60 * 60 * 24);

		}

		return $query;
	}

	private function strip($obj, $title) {
		return strip_tags(stripslashes($obj[$title]));
	}

	public function update_post($post_id, $post) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( isset($post) && is_object($post)  ) return;
		if ( $post->post_type == 'episode' ) {
			delete_transient('nx_latest_episode');
		}
	}

	public static function register() {
		register_widget("Latest_Episode");
	}

}

add_action('widgets_init', array('Latest_Episode', 'register'));

?>
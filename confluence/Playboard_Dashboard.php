<?php

class Playboard_Dashboard {
	
	const name = 'Playboard';
	const slug = 'playboard-dashboard';

	public function Playboard_Dashboard() {
		$this->admin_hooks();
	}

	public function admin_hooks() {
		add_action('wp_dashboard_setup', array($this, 'setup'));
		add_action('save_post', array($this, 'update_post'), 1, 2);
	}

	public function setup() {
		wp_add_dashboard_widget(self::slug, self::name, array($this, 'display'));
	}

	public function display() {
		$playboard = $this->get_playboard_data();
		include('widget-views/playboard-dashboard.php');
	}

	public function update_post($post_id, $post) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( $post->post_type == 'episode' ) {
			delete_transient(self::slug . '-data');
		}
	}

	public function get_playboard_data() {

		$playboard = get_transient(self::slug . '-data');
		if ( false === $playboard ) {
			$playboard = $this->get_data();
			set_transient(self::slug . '-data', $playboard, 60 * 60 * 24);
		}

		return $playboard;

	}

	private function get_data() {
		$arguments = array('hide_empty' => false);
		$uncategorized = get_category_by_slug('uncategorized');
		if ($uncategorized) {
			$arguments['category__not_in'] = array($uncategorized->term_id);
		}

		$playboard = array(
			'series' => array(),
			'total_all' => 0,
			'total ninety' => 0,
			'total_thirty' => 0,
			'total_seven' => 0
		);
		/*
			name, slug, count
		*/
		$categories = get_categories();
		$total = 0;
		foreach ($categories as $category) {
			$data = array(
				'name' => $category->name,
				'slug' => strtoupper($category->slug),
				'count' => $category->category_count
			);
			$playboard['series'][] = $data;
			$total += $category->category_count;
		}


		$playboard['total_all'] = $total;

		$playboard['total_ninety'] = $this->get_range_total(90);
		$playboard['total_thirty'] = $this->get_range_total(30);
		$playboard['total_seven'] = $this->get_range_total(7);

		$playboard['last_update'] = time();

		return $playboard;
	}

	private function get_range_total($days) {
		global $wpdb;
		if ($days <= 0) $days = 1;
		$sql_query = "SELECT COUNT(id) FROM $wpdb->posts WHERE post_status = 'publish' AND post_date >= DATE_SUB(CURRENT_DATE, INTERVAL %d DAY);";
		$query = $wpdb->prepare($sql_query, $days);
		$results = $wpdb->get_var($query);
		return $results;
	}

}

$nx_playboard = new Playboard_Dashboard();

?>
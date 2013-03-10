<?php

class Most_Recent_Dashboard {
	
	const name = 'Most Recent';
	const slug = 'most-recent-dashboard';

	public function Most_Recent_Dashboard() {
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
		$recent = $this->get_recent_data();
		include('widget-views/most-recent-dashboard.php');
	}

	public function update_post($post_id, $post) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( $post->post_type == 'episode' ) {
			delete_transient(self::slug . '-data');
		}
	}

	public function get_recent_data() {

		$recent = array(
			'show' => array(),
			'fringe' => array()
		);

		$arguments = array(
			'numberposts' => 1,
			'post_type' => 'episode',
			'post_status' => 'publish'
		);

		$recent['fringe'] = wp_get_recent_posts($arguments);

		$uncategorized = get_category_by_slug('uncategorized');

		$fringe = get_category_by_slug('tf');
		if ($uncategorized || $fringe) {
			$arguments['category__not_in'] = array($uncategorized->term_id, $fringe->term_id);
		}
		$recent['show'] = wp_get_recent_posts($arguments);



		return $recent;

	}

	private function get_data() {



	}


}

$nx_most_recent = new Most_Recent_Dashboard();

?>
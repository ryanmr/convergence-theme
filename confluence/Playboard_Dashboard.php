<?php

class Playboard_Dashboard {
	
	const name = 'Playboard';
	const slug = 'playboard-dashboard';

	public function Playboard_Dashboard() {
		$this->admin_hooks();
	}

	public function admin_hooks() {
		add_action('wp_dashboard_setup', array($this, 'setup'));
	}

	public function setup() {
		wp_add_dashboard_widget(self::slug, self::name, array($this, 'display'));
	}

	public function display() {
		include('widget-views/playboard-dashboard.php');
	}



}

$nx_playboard = new Playboard_Dashboard();

?>
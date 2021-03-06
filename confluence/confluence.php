<?php
/*
Plugin Name: Confluence
Plugin URI: 
Description: A package to add portable features to the Convergence theme.
*/

define('CONFLUENCE_VIEWS', 'confluence-views');

if (!function_exists('class_alias')) {
    function class_alias($original, $alias) {
        eval('class ' . $alias . ' extends ' . $original . ' {}');
        // an evil worse than any...
    }
}

class Confluence {
	public function __construct() {
		add_action('init', array($this, 'hooks'));
	}

	public function hooks() {
		$this->register_people();
	}

	public function register_people() {
		    $labels = array( 
        'name' => _x( 'People', 'person' ),
        'singular_name' => _x( 'Person', 'person' ),
        'add_new' => _x( 'Add New', 'person' ),
        'add_new_item' => _x( 'Add New Person', 'person' ),
        'edit_item' => _x( 'Edit Person', 'person' ),
        'new_item' => _x( 'New Person', 'person' ),
        'view_item' => _x( 'View Person', 'person' ),
        'search_items' => _x( 'Search People', 'person' ),
        'not_found' => _x( 'No people found', 'person' ),
        'not_found_in_trash' => _x( 'No people found in Trash', 'person' ),
        'parent_item_colon' => _x( 'Parent Person:', 'person' ),
        'menu_name' => _x( 'People', 'person' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'excerpt' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 8,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'person', $args );
	}

}

class Confluence_People_View {

	public $nonce_path;
	public $nonce_key = 'confluence_nonce';

	public function __construct() {
		$this->nonce_path = basename(__FILE__);
		if ( is_admin() ) add_action('init', array($this, 'admin_hooks'));
	}

	public function admin_hooks() {
		$targets = array('load-post', 'load-post-new');
		foreach ($targets as $target) {
			add_action("$target.php", array($this, 'metabox_setup'));
		}
	}

	public function metabox_setup() {
		add_action('add_meta_boxes', array($this, 'add_metabox'));
		add_action('save_post', array($this, 'save'), 10, 2);
	}

	public function add_metabox() {
		add_meta_box(
			'confluence-meta-box',
			esc_html('People Attributes'),
			array($this, 'display'),
			'person'
		);
	}

	public function display($object, $box) {
		$nonce_key = $this->nonce_key;
		$nonce_path = $this->nonce_path;
		include(CONFLUENCE_VIEWS . '/confluence-people.php');
	}

	public function save($post_id, $post) {

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id; 
		if ( !isset($_POST[$this->nonce_key]) || !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce_path) ) return $post_id;

		$this->_gravatar($post_id, $post);
		$this->_website($post_id, $post);
		$this->_social($post_id, $post);
		$this->_host($post_id, $post);

	}

	private function _host($post_id, $post) {
		$new = (( isset( $_POST['confluence-person-host'] ) && $_POST['confluence-person-host'] == 1 )  ? '1' : '0' );
		$meta_key = 'confluence-person-host';
		$v = update_post_meta($post_id, $meta_key, $new);
	}

	private function _gravatar($post_id, $post) {
		$new = ( isset( $_POST['confluence-person-gravatar'] )  ? esc_attr($_POST['confluence-person-gravatar']) : '' );
		$meta_key = 'confluence-person-gravatar';
		$this->tasukete($post_id, $meta_key, $new);
	}

	private function _website($post_id, $post) {
		$new = ( isset( $_POST['confluence-person-website'] )  ? esc_attr($_POST['confluence-person-website']) : '' );
		$meta_key = 'confluence-person-website';
		$this->tasukete($post_id, $meta_key, $new);
	}

	private function _social($post_id, $post) {
		$new = ( isset( $_POST['confluence-person-social'] )  ? esc_attr($_POST['confluence-person-social']) : '' );
		$meta_key = 'confluence-person-social';
		$this->tasukete($post_id, $meta_key, $new);
	}

	/* private helpers */
	/* tasukete - "save me" in japanese */
	private function tasukete($post_id, $meta_key, $new) {
		$meta_value = get_post_meta($post_id, $meta_key, true);
		if ($new && '' == $meta_value) add_post_meta($post_id, $meta_key, $new, true);
		elseif ($new && $new != $meta_value) update_post_meta($post_id, $meta_key, $new);
		elseif ('' == $new && $meta_value) delete_post_meta($post_id, $meta_key, $meta_value);
	}

}

class Confluence_Episode_View {

	public $nonce_path;
	public $nonce_key = 'confluence_nonce';

	public function __construct() {
		$this->nonce_path = basename(__FILE__);
		if ( is_admin() ) add_action('init', array($this, 'admin_hooks'));
	}

	public function admin_hooks() {
		$targets = array('load-post', 'load-post-new');
		foreach ($targets as $target) {
			add_action("$target.php", array($this, 'metabox_setup'));
		}
	}

	public function metabox_setup() {
		add_action('add_meta_boxes', array($this, 'add_metabox'));
		add_action('save_post', array($this, 'save'), 10, 2);
	}

	public function add_metabox() {
		add_meta_box(
			'confluence-meta-box',
			esc_html('Confluence'),
			array($this, 'display'),
			'episode'
		);
	}

	public function display($object, $box) {
		$nonce_key = $this->nonce_key;
		$nonce_path = $this->nonce_path;
		include(CONFLUENCE_VIEWS . '/confluence-episode.php');
	}

	public function save($post_id, $post) {

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id; 
		if ( !isset($_POST[$this->nonce_key]) || !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce_path) ) return $post_id;

		$this->_nsfw($post_id, $post);
		$this->_fringe_url($post_id, $post);

	}

	private function _fringe_url($post_id, $post) {
		if (empty($_POST['confluence-fringe-url'])) return $post_id;
		$new = ( isset( $_POST['confluence-fringe-url'] )  ? esc_url($_POST['confluence-fringe-url']) : '' );
		$meta_key = 'confluence-fringe-url';
		$this->tasukete($post_id, $meta_key, $new);		
	}

	private function _nsfw($post_id, $post) {

		$new = ( isset( $_POST['confluence-nsfw'] )  ? '1' : '' );
		$meta_key = 'confluence-nsfw';
		$this->tasukete($post_id, $meta_key, $new);
	}

	/* private helpers */
	/* tasukete - "save me" in japanese */
	private function tasukete($post_id, $meta_key, $new) {
		$meta_value = get_post_meta($post_id, $meta_key, true);
		if ($new && '' == $meta_value) add_post_meta($post_id, $meta_key, $new, true);
		elseif ($new && $new != $meta_value) update_post_meta($post_id, $meta_key, $new);
		elseif ('' == $new && $meta_value) delete_post_meta($post_id, $meta_key, $meta_value);
	}

}

class Confluence_Episode_People_View {
	public $nonce_path;
	public $nonce_key = 'confluence_nonce';

	public function __construct() {
		$this->nonce_path = basename(__FILE__);
		if ( is_admin() ) add_action('init', array($this, 'admin_hooks'));
	}

	public function admin_hooks() {
		$targets = array('load-post', 'load-post-new');
		foreach ($targets as $target) {
			add_action("$target.php", array($this, 'metabox_setup'));
		}
	}

	public function metabox_setup() {
		add_action('add_meta_boxes', array($this, 'add_metabox'));
		add_action('save_post', array($this, 'save'), 10, 2);
		add_action('admin_footer', array($this, 'javascript'));
	}

	public function javascript() {
		include(CONFLUENCE_VIEWS . '/js/confluence-episode-people.js.php');
	}

	public function add_metabox() {
		add_meta_box(
			'confluence-people-box',
			esc_html('People'),
			array($this, 'display'),
			'episode'
		);
	}

	public function display($object, $box) {
		$nonce_key = $this->nonce_key;
		$nonce_path = $this->nonce_path;
		include(CONFLUENCE_VIEWS . '/confluence-episode-people.php');
	}

	public function save($post_id, $post) {

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id; 
		if ( !isset($_POST[$this->nonce_key]) || !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce_path) ) return $post_id;

		delete_post_meta($post_id, 'confluence-people'); // sadly, but needed
		// always drop whatever we have right now
		$people = isset($_POST['confluence-person']) && !empty($_POST['confluence-person']) ? $_POST['confluence-person'] : array(); // because people are singular when not together


		foreach ($people as $person) {
			$person = sanitize_title($person);
			add_post_meta($post_id, 'confluence-people', $person);
		}

	}	

}


class Confluence_AdminMagic {
	public $nonce_path;
	public $nonce_key = 'confluence_nonce';

	public function __construct() {
		$this->nonce_path = basename(__FILE__);
		if ( is_admin() ) add_action('init', array($this, 'admin_hooks'));
	}
	public function admin_hooks() {
		add_action('admin_menu', array($this, 'setup_menus'));
	}

	public function setup_menus() {
		add_menu_page( 'Magic', 'Magic', 'administrator', 'confluence-magic', array($this, 'menu_display'));
	}

	public function menu_display() {
		global $wp_query;
		include('confluence-views/confluence-admin-magic.php');
		
	}

}



class Confluence_Interface {
	public static function get_nsfw() {
		$meta = get_post_meta( get_the_ID() , 'confluence-nsfw', true);
		return $meta;
	}

	public static function get_person_host() {
		$meta = get_post_meta( get_the_ID() , 'confluence-person-host', true);
		return $meta;
	}

	public static function get_related_fringe_url() {
		$meta = get_post_meta( get_the_ID(), 'confluence-fringe-url', true);
		return $meta;
	}

	public static function get_person_gravatar_raw() {
		$meta = get_post_meta( get_the_ID(), 'confluence-person-gravatar', true);
		return $meta;
	}

	public static function get_person_gravatar($size = 150) {
		$meta = get_post_meta( get_the_ID(), 'confluence-person-gravatar', true);
		// use the generic blank default
		// but we need to avoid this as much as possible
		//$default = get_template_directory_uri() . '/resources/images/unknown-avatar.png';
		$default = ''; // none right now
		// get_avatar expects an email addresss
		$return = get_avatar($meta, $size, $default, get_the_title());
		return $return;
	}

	public static function get_people() {
		$meta = get_post_meta( get_the_ID(), 'confluence-people');
		return $meta;
	}

	public static function get_people_ids() {
		global $wpdb;
		// use for post__in
		$ids = array();
		$people = self::get_people();

		foreach ($people as $person_slug) {
			$query = "SELECT ID FROM $wpdb->posts WHERE post_name='".mysql_real_escape_string($person_slug)."' AND post_type = 'person';";
			$id = $wpdb->get_var($query);
			if ($id != null) $ids[] = $id;
		}

		return $ids;
	}

	public static function get_person_website() {
		$meta = get_post_meta( get_the_ID(), 'confluence-person-website', true);
		return $meta;
	}

	public static function get_person_social() {
		$meta = get_post_meta( get_the_ID(), 'confluence-person-social', true);
		return $meta;
	}

}
class_alias("Confluence_Interface", "C");

function confluence_setup() {
	$confluence = new Confluence();
	$master = new Confluence_Episode_View();
	$people_episode_view = new Confluence_Episode_People_View();
	$people_view = new Confluence_People_View();

	$magic = new Confluence_AdminMagic();
}

confluence_setup();

?>
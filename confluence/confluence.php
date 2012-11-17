<?php
/*
Plugin Name: Confluence
Plugin URI: 
Description: A package to add portable features to the Convergence theme.
*/

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
		/* literally nothing */
	}

}


class Confluence_Master {

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
			array($this, 'display')
		);
	}

	public function display($object, $box) {
		$nonce_key = $this->nonce_key;
		$nonce_path = $this->nonce_path;
		include('views/master.php');
	}

	public function save($post_id, $post) {

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id; 
		if ( !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce_path) ) return $post_id;

		$this->_nsfw($post_id, $post);

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

class Confluence_Interface {
	public static function get_nsfw() {
		$meta = get_post_meta( get_the_ID() , "confluence-nsfw", true);
		return $meta;
	}
}
class_alias("Confluence_Interface", "C");

function confluence_setup() {
	$confluence = new Confluence();
	$master = new Confluence_Master();
}

confluence_setup();

?>
<?php
/* Load the core theme framework. */
require_once( trailingslashit( TEMPLATEPATH ) . 'hybrid-core/hybrid.php' );
$hybrid = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'convergence_theme_setup_theme' );

/**
 * Sets up the Convergence Theme.
 * @return void
 */
function convergence_theme_setup_theme() {
	/* Get the theme prefix. */
	$prefix = hybrid_get_prefix();

	/* Add support for framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary') );
	add_theme_support( 'hybrid-core-sidebars', array( 'subsidiary', 'before-content', 'after-content', 'after-singular' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-seo' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'loop-pagination' );
  add_theme_support( 'automatic-feed-links' );

	/* Enable post thumbnail. */
	add_theme_support('post-thumbnails');

	/* Enable get-the-image plugin for easy images. */
	add_theme_support( 'get-the-image' );

	/* Register theme sidebars. */
	add_action( 'init', 'convergence_theme_register_sidebars', 11 );

	/* Register the custom post type 'episode' and related taxonomies */
	add_action( 'init', 'convergence_register_cpt_episode');
  add_action( 'init', 'convergence_register_taxonomy_episode_attributes');

	/* Header actions. */
  add_action( "{$prefix}_header", 'convergence_site_logo' );
	add_action( "{$prefix}_header", 'convergence_site_title' );
	add_action( "{$prefix}_header", 'convergence_site_description' );

	/* Load the primary menu. */
	add_action( "{$prefix}_after_header_inside", 'convergence_get_primary_menu' );

	/* Load the secondary (footer) menu. */
	add_action( "{$prefix}_after_footer", 'convergence_get_secondary_menu' );

	/* Add the primary and secondary sidebars after the container. */
	add_action( "{$prefix}_after_container", 'convergence_get_primary' );
	add_action( "{$prefix}_after_container", 'convergence_get_secondary' );

	/* Add the before content hook. */
	add_action( "{$prefix}_before_content", 'convergence_get_utility_before_content' );

	/* Add the title, episode number and when it was posted. */
	add_action( "{$prefix}_before_entry", 'hybrid_entry_title' ); // Why isn't this changed?
	add_action( "{$prefix}_before_entry", 'convergence_episode' );
	add_action( "{$prefix}_before_entry", 'convergence_posted' );
  add_action("{prefix}_before_entry", 'convergence_episode_attribute');

	/* Add the after singular sidebar and custom field series extension after singular views. */
	add_action( "{$prefix}_after_singular", 'convergence_get_utility_after_singular' );

	/* Add the after content sidebar and navigation links after the content. */
	add_action( "{$prefix}_after_content", 'convergence_get_utility_after_content' );
	add_action( "{$prefix}_after_content", 'convergence_navigation_links' );

	/* Add the subsidiary sidebar and footer insert to the footer. */
	add_action( "{$prefix}_before_footer", 'convergence_get_subsidiary' );
	add_action( "{$prefix}_footer", 'convergence_footer_insert' );

	/* Add the comment avatar and comment meta before individual comments. */
	add_action( "{$prefix}_before_comment", 'hybrid_avatar' );
	add_action( "{$prefix}_before_comment", 'hybrid_comment_meta' );

	/* Add theme-specific body classes. */
	add_filter( 'body_class', 'convergence_hybrid_theme_body_class' );
  
  /* Add the custom post type 'episode' back into category pages. */
	add_action('pre_get_posts', 'convergence_category_post_types');
  add_action('pre_get_posts', 'convergence_exclude_episode_attribute_hidden');

	/* Add meta tags into the head. */
	add_action('wp_head', 'convergence_facebook_admin_meta_tag');
	add_action('wp_head', 'convergence_google_webmaster_meta_tag');

	/* Update the sizes for images, thumbnails specifically. */
	add_action('init', 'convergence_add_image_size');

	/* Alter the Feeds. */
	add_filter('wp_title', 'convergence_post_title_filter');
	add_filter('the_title_rss', 'convergence_feed_title_filter');
	add_filter('the_content_feed', 'convergence_feed_description_filter');

	/* Delay Feed publishing. */
	add_filter('posts_where', 'convergence_feed_delay');

  add_action('wp_footer', 'convergence_site_logo_idle');
}

/**
 * Registers custom post type, 'episode' with all labels and proper
 * taxonomy bindings.
 * @return void
 */
function convergence_register_cpt_episode() {

    $labels = array( 
        'name' => _x( 'Episodes', 'episode' ),
        'singular_name' => _x( 'Episode', 'episode' ),
        'add_new' => _x( 'Add New', 'episode' ),
        'add_new_item' => _x( 'Add New Episode', 'episode' ),
        'edit_item' => _x( 'Edit Episode', 'episode' ),
        'new_item' => _x( 'New Episode', 'episode' ),
        'view_item' => _x( 'View Episode', 'episode' ),
        'search_items' => _x( 'Search Episodes', 'episode' ),
        'not_found' => _x( 'No episodes found', 'episode' ),
        'not_found_in_trash' => _x( 'No episodes found in Trash', 'episode' ),
        'parent_item_colon' => _x( 'Parent Episode:', 'episode' ),
        'menu_name' => _x( 'Episodes', 'episode' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
        'taxonomies' => array( 'category', 'episode_attributes' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'episode', $args );
}

/**
 * Registeres the custom taxanomy, 'episode attributes' for extra data.
 * @return void
 */
function convergence_register_taxonomy_episode_attributes() {

    $labels = array( 
        'name' => _x( 'Episode Attributes', 'episode_attributes' ),
        'singular_name' => _x( 'Episode Attribute', 'episode_attributes' ),
        'search_items' => _x( 'Search Episode Attributes', 'episode_attributes' ),
        'popular_items' => _x( 'Popular Episode Attributes', 'episode_attributes' ),
        'all_items' => _x( 'All Episode Attributes', 'episode_attributes' ),
        'parent_item' => _x( 'Parent Episode Attribute', 'episode_attributes' ),
        'parent_item_colon' => _x( 'Parent Episode Attribute:', 'episode_attributes' ),
        'edit_item' => _x( 'Edit Episode Attribute', 'episode_attributes' ),
        'update_item' => _x( 'Update Episode Attribute', 'episode_attributes' ),
        'add_new_item' => _x( 'Add New Episode Attribute', 'episode_attributes' ),
        'new_item_name' => _x( 'New Episode Attribute', 'episode_attributes' ),
        'separate_items_with_commas' => _x( 'Separate episode attributes with commas', 'episode_attributes' ),
        'add_or_remove_items' => _x( 'Add or remove Episode Attributes', 'episode_attributes' ),
        'choose_from_most_used' => _x( 'Choose from most used Episode Attributes', 'episode_attributes' ),
        'menu_name' => _x( 'Episode Attributes', 'episode_attributes' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'episode_attributes', array('episode'), $args );
}

/**
 * Outputs a facebook adminstrator meta tag into the header.
 * @return void
 */
function convergence_facebook_admin_meta_tag() {
  echo '<!-- facebook --><meta property="fb:admins" content="793140430" />';
}

/**
 * Outputs a Google Webmaster meta tag into the header.
 * @return void
 */
function convergence_google_webmaster_meta_tag() {
  echo '<!-- webmaster -->';
}

/**
 * Updates the default settings for thumbnail sizes, maintaining standard croppings.
 * @return void
 */
function convergence_add_image_size() {
	set_post_thumbnail_size(150, 85, false);

	update_option('thumbnail_size_w', 270);
	update_option('thumbnail_size_h', 150);
	update_option('thumbnail_crop', false);


}

/**
 * Returns a partial array so that WP_Query attributes can exclude certain taxonmy terms.
 * @param type $terms 
 * @return type
 */
function convergence_exclude_episode_attributes($terms) {
  if (!is_array($terms)) {
    $terms = array($terms);
  }
  return array(
      'taxonomy' => 'episode_attributes',
      'terms' => $terms,
      'field' => 'slug',
      'operator' => 'NOT IN'
    );
}

/**
 * Allows custom post type 'episode' to be seen in category page listings.
 * @param query $query 
 * @return $query
 */
function convergence_category_post_types($query) {
	if ($query->is_category) {
		$query->set('post_type', array('post', 'episode'));
	}
	return $query;
}

/**
 * Adds the paramters to the WP_Tax query to exclude the 'hidden' episode attribute taxonomy.
 * @param type $query 
 * @return type
 */
function convergence_exclude_episode_attribute_hidden($query) {

  if ( !is_user_logged_in() ) {
    $tax_query = $query->tax_query->queries;
    $tax_query['hidden'] = convergence_exclude_episode_attributes('hidden');
    $query->set('tax_query', $tax_query);
  }

  return $query;
}

/**
 * Determines if a feed item should be seen in a Feed after being published, after a delay.
 * @param type $where 
 * @return type
 */
function convergence_feed_delay($where) {
  global $wpdb;
  
  if (is_feed()) {
    $now = gmdate('Y-m-d H:i:s');
    $wait = '59';
    $device = 'MINUTE';
    $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
  }
  
  return $where;
}

/**
 * Filter. Adds a call to action to the end of all Feed items.
 * @param type $content 
 * @return type
 */
function convergence_feed_description_filter($content) {
  global $wp_query;
  $post_id = $wp_query->post->ID;
  $excerpt = get_the_excerpt($post_id);
  
  $content = strip_tags($excerpt) . "<br /><br />\n\n" . $content;
  $extra = '<br /><br />\n\nListen to more at <a href='.get_bloginfo('siteurl').'>The-Nexus.tv</a> and follow us on <a href="http://twitter.com/thenexustv">Twitter</a>.';
  
  $content = $content . $extra;
  
  return $content;
}

/**
 * Gets the proper name for an episode.
 * @param string $title The existing title
 * @param type $s unknown filter parameter
 * @param type $l unknown filter parameter
 * @return string
 */
function convergence_post_title_filter($title, $s = "", $l = "") {
  global $wp_query;
  $modified = $title;
  if (is_single()) {
    $post_id = $wp_query->post->ID;
    $permalink = get_permalink($post_id);
    $episode = get_episode_number($permalink);
    $categories = get_the_category($post_id);
    $category = $categories[0];
    $modified = $category->cat_name . " #" . $episode . ": " . $title . " &raquo; " . get_bloginfo('sitename');
  }
  return $modified;
}

/**
 * Formats titles properly for the Feed
 * @param string $content 
 * @return string
 */
function convergence_feed_title_filter($content) {
  global $wp_query;
  $post_id = $wp_query->post->ID;
  $permalink = get_permalink($post_id);
  $categories = get_the_category($post_id);
  $category = $categories[0];
  $string = $category->cat_name . ' #' . get_episode_number($permalink) . ": " . $content;
  return $string;
}

/**
 * Gets the episode number from the permalink by stripping away the front alpha-characters.
 * @param string $permalink 
 * @return string
 */
function get_episode_number($permalink) {
  $parts = explode("/", $permalink);
  $slug = $parts[count($parts)-2];
  $number = preg_replace('/[^0-9]/i', '', $slug);
  if ( !is_numeric($number) ) return '&#8734;';
  return $number;
}

/**
 * Gets an arbitrary symbol based on initial input data.
 * @param string $data initial data to get a symbol from
 * @param array $arguments an array of symbol strings
 * @return string
 */
function get_arbitrary_symbol($data, $symbols = array('&#8734;')) {
    $hash = sha1($data);
    $substring = substr($hash, 0, 6);
    $integer = hexdec($substring);
    $length = count($symbols);
    
    return $symbols[ $integer % $length ];    
}

/**
 * Template. Adds a category exclusion to an array of supplied settings.
 * @param type $slug The name of the category.
 * @param type $arguments An array of existing arguments for the loop.
 * @return type
 */
function convergence_exclude_category($slug, $arguments) {
	$exclude = get_category_by_slug($slug);
	if ($exclude) {
		$exclude_id = $exclude->term_id;
		$arguments['category__not_in'] = array($exclude_id);
	}
	return $arguments;
}

/**
 * Returns site logo markup.
 * @return string
 */ 
function convergence_site_logo() {
  $html = '<div id="site-logo"><span class="logo"></span></div>';
  echo $html;
}


/**
 * Adds javascript into the footer to handle the rotating logo idle class.
 * 
 */
function convergence_site_logo_idle() {
?>
<script type="text/javascript">
  jQuery(document).ready(function($){
    var fn = function() {
      $('#site-logo').addClass('idle');
      console.log('big week');
    };
    setTimeout(fn, 1000 * 60 * 5);
  });
</script>
<?php 
}

/**
 * Returns the title of the site.
 * @return string
 */
function convergence_site_title() {
	return hybrid_site_title();	
}

/**
 * Returns the description of the site.
 * @return string
 */
function convergence_site_description() {
	return hybrid_site_description();	
}


/**
 * Outputs, with formatting, when the 'episode' was posted and how long ago if applicable.
 * @return string
 */
function convergence_posted() {
  $posted = "";
  $type = get_post_type();

	if ( in_array($type, array('episode')) ) {
    $ago = human_time_difference( get_the_date('U'), current_time('timestamp') ) . ' ago';
    if ( is_front_page() ) {
      $ago = '';
    }

    $modified_date = get_the_modified_date("F jS Y");
    $modified_ago = human_time_difference(get_the_modified_date('U'), current_time('timestamp'));

    $posted = '<h4 class="show-date" title="Modified '.$modified_date.' ('.$modified_ago.' ago)">' . get_the_date("F jS Y") . ': ' . $ago . '</h4>';
  }
  
  echo apply_atomic_shortcode('posted', $posted);
}

/**
 * Outputs, with formatting, the proper episode number.
 * @return string
 */
function convergence_episode() {
  
  $episode = "";
  $type = get_post_type();
  
	if ( in_array($type, array('post', 'episode')) ) {
    $episode = '<h3 class="show-episode">Episode <span class="number">#'.get_episode_number( get_permalink() ).'</span></h3>';
  }
  
  echo apply_atomic_shortcode('episode', $episode);
}

/**
 * Outputs the category description the episode is in
 * @return string
 */
function convergence_show_description() {
  $categories = get_the_category();
  $category = $categories[0];
  $description = $category->category_description; //category_description($category);
  echo apply_atomic_shortcode('show_description', $description);
}

/**
 * Outputs the category subscription button
 * @return string
 */
function convergence_category_feed() {
  $categories = get_the_category();
  $category = $categories[0];
  $link = '<div class="subscribe-feed"><a href="' . get_category_feed_link($category->term_id) . '" class="feed-link">Subscribe to '.$category->name.'</a></div>';
  echo apply_atomic_shortcode('category_feed', $link);
}

/**
 * Creates a human readable time, relative to supplied data
 * @param type $from 
 * @param type $to 
 * @return string
 */
function human_time_difference( $from, $to = '' ) {
	if ( empty($to) )
		$to = time();
	$diff = (int) abs($to - $from);
	if ($diff <= 3600) {
		$mins = round($diff / 60);
		if ($mins <= 1) {
			$mins = 1;
		}
		/* translators: min=minute */
		$since = sprintf(_n('%s minute', '%s minutes', $mins), $mins);
	} else if (($diff <= 86400) && ($diff > 3600)) {
		$hours = round($diff / 3600);
		if ($hours <= 1) {
			$hours = 1;
		}
		$since = sprintf(_n('%s hour', '%s hours', $hours), $hours);
	} else if ($diff >= 86400 && $diff < 604800) {
		$days = round($diff / 86400);
		if ($days <= 1) {
			$days = 1;
		}
		$since = sprintf(_n('%s day', '%s days', $days), $days);
	} else if ( $diff >= 604800 && $diff < 2629743 ) {
        $weeks = round($diff / 604800);
        if ($weeks <= 1) {
            $weeks = 1;
        }
        $since = sprintf(_n('%s week', '%s weeks', $weeks), $weeks);
    } else if ( $diff >= 2629743 && $diff < 31556926  ) {
        $months = round($diff / 2629743);
        if ($months <= 1) {
            $months = 1;
        }
        $since = sprintf(_n('%s month', '%s months', $months), $months);
    } else {
        $years = round($diff / 31556926);
        if ($years <= 1) {
            $years = 1;
        }
        $since = sprintf(_n('%s year', '%s years', $years), $years);
    }
	return $since;
}


/* ========================== Non-Covergence Code. Inherited from Hybrid. ================================== */

function convergence_hybrid_theme_body_class( $classes ) {
	global $wp_query, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

	/* Singular post classes (deprecated). */
	if ( is_singular() ) {

		if ( is_page() )
			$classes[] = "page-{$wp_query->post->ID}"; // Use singular-page-ID

		elseif ( is_singular( 'post' ) )
			$classes[] = "single-{$wp_query->post->ID}"; // Use singular-post-ID
	}

	/* Browser detection. */
	$browsers = array( 'gecko' => $is_gecko, 'opera' => $is_opera, 'lynx' => $is_lynx, 'ns4' => $is_NS4, 'safari' => $is_safari, 'chrome' => $is_chrome, 'msie' => $is_IE );
	foreach ( $browsers as $key => $value ) {
		if ( $value ) {
			$classes[] = $key;
			break;
		}
	}

	/* Hybrid theme widgets detection. */
	foreach ( array( 'primary', 'secondary', 'subsidiary' ) as $sidebar )
		$classes[] = ( is_active_sidebar( $sidebar ) ) ? "{$sidebar}-active" : "{$sidebar}-inactive";

	if ( in_array( 'primary-inactive', $classes ) && in_array( 'secondary-inactive', $classes ) && in_array( 'subsidiary-inactive', $classes ) )
		$classes[] = 'no-widgets';

	/* Return the array of classes. */
	return $classes;
}

function hybrid_entry_title() {
	echo apply_atomic_shortcode( 'entry_title', '[entry-title]' );
}

function hybrid_comment_meta() {
	echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta comment-meta-data">[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "] [comment-reply-link before="| "]</div>' );
}

function convergence_navigation_links() {
	locate_template( array( 'navigation-links.php', 'loop-nav.php' ), true );
}

function convergence_footer_insert() {
	$footer_insert = hybrid_get_setting( 'footer_insert' );

	if ( !empty( $footer_insert ) )
		echo '<div class="footer-insert">' . do_shortcode( $footer_insert ) . '</div>';
}

function convergence_theme_register_sidebars() {

	/* Register the widgets template sidebar. */
	register_sidebar(
		array(
			'id' => 'widgets-template',
			'name' => __( 'Widgets Template', hybrid_get_textdomain() ),
			'description' => __( 'Used as the content of the Widgets page template.', hybrid_get_textdomain() ),
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	/* Register the 404 template sidebar. */
	register_sidebar(
		array(
			'id' => 'error-404-template',
			'name' => __( '404 Template', hybrid_get_textdomain() ),
			'description' => __( 'Replaces the default 404 error page content.', hybrid_get_textdomain() ),
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}

function hybrid_theme_remove_sidebars( $sidebars_widgets ) {
	global $wp_query;

	$original = $sidebars_widgets;

	if ( is_singular() ) {
		$template = get_post_meta( $wp_query->post->ID, "_wp_{$wp_query->post->post_type}_template", true );
		$no_show = array('no-widgets.php', "{$wp_query->post->post_type}-no-widgets.php");
		if ( in_array($template, $no_show) )
			$sidebars_widgets = array( false );
	}
	
	return $sidebars_widgets;
}

function convergence_get_primary() {
	get_sidebar( 'primary' );
}

function convergence_get_secondary() {
	get_sidebar( 'secondary' );
}

function convergence_get_subsidiary() {
	get_sidebar( 'subsidiary' );
}

function convergence_get_utility_before_content() {
	get_sidebar( 'before-content' );
}

function convergence_get_utility_after_content() {
	get_sidebar( 'after-content' );
}

function convergence_get_utility_after_singular() {
	get_sidebar( 'after-singular' );
}

function convergence_get_primary_menu() {
	get_template_part( 'menu', 'primary' );
}

function convergence_get_secondary_menu() {
	get_template_part( 'menu', 'secondary' );
}

function hybrid_disable_styles() {
	_deprecated_function( __FUNCTION__, '0.9.0' );
}

/**
 * @since 0.4.0
 * @deprecated 0.9.0
 */
function hybrid_favicon() {
	_deprecated_function( __FUNCTION__, '0.9.0' );
}

/**
 * @since 0.4.0
 * @deprecated 0.9.0
 */
function hybrid_feed_link( $output, $feed ) {
	_deprecated_function( __FUNCTION__, '0.9.0' );
	return $output;
}

/**
 * @since 0.4.0
 * @deprecated 0.9.0
 */
function hybrid_other_feed_link( $link ) {
	_deprecated_function( __FUNCTION__, '0.9.0' );
	return $link;
}

?>

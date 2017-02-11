<?php
/**
 * News_Page_Slider
 *
 * @package   News page slider
 * @author    DFD <dynamicframeworks@gmail.com>
 * @license   GPL-2.0+
 * @link      http://dfd.name
 * @copyright 2013 DFD Team
 */

/**
 * Plugin class.
 *
 *
 * @package   News page slider
 */
class News_Page_Slider {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = NEWS_PAGE_SLIDER_SLUG;

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	
	public static $slides_format;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action('init', array($this, 'load_plugin_textdomain'));

		// Add the options page and menu item.
		add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

		// Load admin style sheet and JavaScript.
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

		// Load public-facing style sheet and JavaScript.
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		add_action('after_setup_theme', array($this, 'after_setup_theme'), 11);

		add_shortcode('news_page_slider', array($this, 'news_page_slider_init'));
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/*	 * ***************************************************** */
	/*            News slider new site activation        */
	/*	 * ***************************************************** */

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		// Multi-site
		if (is_multisite()) {

			// Get WPDB Object
			global $wpdb;

			// Get current site
			$old_site = $wpdb->blogid;

			// Get all sites
			$sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

			// Iterate over the sites
			foreach ($sites as $site) {
				switch_to_blog($site);
				global $wpdb;
				$table_name = $wpdb->prefix . 'news_page_slider';
				$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

				dbDelta($sql);
			}

			// Switch back the old site
			switch_to_blog($old_site);

			// Single-site
		} else {
			global $wpdb;
			$table_name = $wpdb->prefix . 'news_page_slider';
			$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			dbDelta($sql);
		}
	}

	function news_page_slider_create_db_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'news_page_slider';
		$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
		load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_style($this->plugin_slug . '-admin-styles', plugins_url('css/admin.css', __FILE__), array(), $this->version);
		}
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('js/admin.js', __FILE__), array('jquery'), $this->version);
		}
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$customLessPath = get_template_directory().'/inc/news-page-slider/custom.less';
		$customCssPath = get_template_directory().'/inc/news-page-slider/custom.css';
		$customCssUrl = get_template_directory_uri().'/inc/news-page-slider/custom.css';

		if (is_file($customLessPath)) {
			if (!is_file($customCssPath) || (defined('PHP_LESS') && PHP_LESS === true)) {
				$this->_compile_less($customLessPath, $customCssPath);
			}
			wp_enqueue_style($this->plugin_slug . '-plugin-styles-custom', $customCssUrl, array(), $this->version);
		}
		elseif (is_file($customCssPath)) {
			wp_enqueue_style($this->plugin_slug . '-plugin-styles-custom', $customCssUrl, array(), $this->version);
		} else {
			$cssUrl = plugins_url('assets/css/public.css', __FILE__);
			$cssPath = plugin_dir_path(__FILE__).'assets/css/public.css';
			$lessPath = plugin_dir_path(__FILE__).'assets/less/public.less';

			if (
				(defined('DFD_PHP_LESS') && DFD_PHP_LESS === true) ||
				!is_file($cssPath)
			) {
				$this->_compile_less($lessPath, $cssPath);
			}
			wp_enqueue_style($this->plugin_slug . '-plugin-styles', $cssUrl, array(), $this->version);
		}


	}
	
	private function _compile_less($less_file, $css_file) {
		$lessPathClass = plugin_dir_path(__FILE__) . 'lib/lessc.inc.php';
		if (!class_exists('lessc') && file_exists($lessPathClass)) {
			require_once ($lessPathClass);
		}

		if (!class_exists('lessc')) {
			wp_die('Less does not exists.');
		}

		$less = new lessc();
		try {
			$less->setFormatter('compressed');
			$less->compileFile($less_file, $css_file);
			unset($less);
		} catch (Exception $ex) {
			wp_die('Less compile error: '.$ex->getMessage());
		}
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jcarousel', plugins_url('js/jquery.jcarousel.min.js', __FILE__), array('jquery'), $this->version);
		wp_enqueue_script('news-page-slider', plugins_url('js/news-page-slider.js', __FILE__), array('jquery'), $this->version);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_menu_page(
				__('News Page Slider', $this->plugin_slug), __('News Page Slider', $this->plugin_slug), 'edit_theme_options', $this->plugin_slug, array($this, 'display_plugin_admin_page')
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once('views/admin.php');
	}

	public function get_post_taxonomies($post) {
		// Passing an object
		// Why another var?? $output = 'objects'; // name / objects
		$taxonomies = get_object_taxonomies($post, 'objects');

		/* // Passing a string using get_post_type: return (string) post, page, custom...
		  $post_type  = get_post_type($post);
		  $taxonomies = get_object_taxonomies($post_type, 'objects'); */

		/* // In the loop with the ID
		  $theID      = get_the_ID();
		  $post_type  = get_post_type($theID);
		  $taxonomies = get_object_taxonomies($post_type, 'objects'); */

		// You can also use the global $post
		// edited to fix previous error $tazonomies
		// edited to force type hinting array
		return (array) $taxonomies; // returning array of taxonomies
	}

	/*	 * ***************************************************** */
	/*            News slider new site activation           */
	/*	 * ***************************************************** */

	private function news_page_slider_new_site($blog_id) {

		// Get WPDB Object
		global $wpdb;

		// Get current site
		$old_site = $wpdb->blogid;

		// Switch to new site
		switch_to_blog($blog_id);

		// Run activation scripts
		news_page_slider_create_db_table();

		// Switch back the old site
		switch_to_blog($old_site);
	}

	private function newsPageSliderById($id = 0) {

		// No ID
		if ($id == 0) {
			return false;
		}

		// Get DB stuff
		global $wpdb;
		$table_name = $wpdb->prefix . "news_page_slider";

		// Get data
		$link = $slider = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . (int) $id . " ORDER BY date_c DESC LIMIT 1", ARRAY_A);

		// No results
		if ($link == null) {
			return false;
		}

		// Convert data
		$slider['data'] = json_decode($slider['data'], true);

		// Return the slider
		return $slider;
	}

	public function news_page_slider_init($atts, $content = null) {
		extract(shortcode_atts(array("id" => ''), $atts));

		$slider = $this->newsPageSliderById($id);
		$slider = (isset($slider['data'])) ? $slider['data'] : '';

		# main options
		$sliderFormat = (isset($slider['slidesFormat'])) ? $slider['sort'] : 1;
		$slidesCountIncrement = ($sliderFormat < 7) ? $sliderFormat + 1 : 1;
		if($sliderFormat == 5) {
			$slidesCountIncrement = $sliderFormat;
		}
		$sort = (isset($slider['sort'])) ? $slider['sort'] : '';
		$order = (isset($slider['sort_order'])) ? $slider['sort_order'] : '';
		$number = (isset($slider['posts'])) ? $slider['posts'] * $slidesCountIncrement : 4;

		$cache_time = (isset($slider['cache'])) ? $slider['cache'] : '';




		# elements options
		$enable_title = (isset($slider['enable']['title'])) ? $slider['enable']['title'] : '';
		$enable_icon = (isset($slider['enable']['icon'])) ? $slider['enable']['icon'] : '';
		$enable_description = (isset($slider['enable']['description'])) ? $slider['enable']['description'] : '';
		$enable_link = (isset($slider['enable']['link'])) ? $slider['enable']['link'] : '';

		$limit_words = (isset($slider['words_limit'])) ? $slider['words_limit'] : '';

		//slideshow options
		$auto_scroll = (isset($slider['auto_cycling'])) ? $slider['auto_cycling'] : 0;
		$auto_timeout = (isset($slider['cycle_interval'])) ? $slider['cycle_interval'] : 3000;

		//Posts and categories
		if (isset($slider['post_select']))
			$selected_posts = $slider['post_select'];
		else
			$selected_posts = array();

		$postType = (isset($slider['postType']) && !empty($slider['postType'])) ? $slider['postType'] : 'post';

		$tax = $postType;
		switch ($postType) {
			case 'post':
				$tax = 'category';
				break;
			case 'my-product':
				$tax = 'my-product_category';
				break;
			case 'product':
				$tax = 'product_cat';
				break;
		}

		// First, let's see if we have the data in the cache already
		if ($cache_time) {
			$query = wp_cache_get('news_page_slider_cache'); // the cache key is a unique identifier for this data
		} else {
			$query = false;
		}

		if ($query == false) {

			if (is_array($selected_posts)) {
//				$categories_names = implode(",", $selected_posts);
				$categories_names = $selected_posts;
			}



			$args = array(
				'post_type' => $postType,
				'orderby' => $sort,
				'order' => $order,
				'ignore_sticky_posts' => 1,
				'post_count' => $number,
				'posts_per_page' => $number,
//				'category_name' => $categories_names,
				'meta_key' => '_thumbnail_id',
				'meta_value' => '',
				'meta_compare' => '!=',
				'tax_query' => array(
					array(
						'taxonomy' => $tax,
						'field' => 'slug',
						'terms' => $categories_names,
					)
				),
			);

			$query = new WP_Query($args);

			if ($cache_time) {
				wp_cache_set('news_page_slider_cache', $query, $cache_time * 60);
			}
		}
		
		if (isset($query) && $query) {
			$uniq_id = uniqid('news_page_slider');

			$customView = get_template_directory().'/inc/news-page-slider/list.php';

			if (file_exists($customView)) {
				require $customView;
			} else {
				require dirname(__FILE__) . '/templates/list.php';
			}

			wp_reset_query();
		}
	}
	
	/**
	 * Sutup Slides formats
	 * add_filter('news_page_slider_slides_format', 'news_page_slider_slides_format');
	 */
	public function after_setup_theme() {
		self::$slides_format = array(
			1 => __('1-1', 'crum'),
			2 => __('1-2', 'crum'),
			3 => __('1-3', 'crum'),
			4 => __('1-4', 'crum'),
		);
		
		$filter_out = apply_filters('news_page_slider_slides_format', self::$slides_format);
		
		if (!empty($filter_out)) {
			self::$slides_format = $filter_out;
		}
	}	
}

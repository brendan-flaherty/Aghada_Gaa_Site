<?php
/**
 *
 * @package   News page slider
 * @author    DFD <dynamicframeworks@gmail.com>
 * @license   GPL-2.0+
 * @link      http://dfd.name
 * @copyright 2013 DFD Team
 *
 * @wordpress-plugin
 * Plugin Name: News page slider
 * Plugin URI:  http://dfd.name
 * Description: Slider of pages / posts
 * Version:     2.0.0
 * Author:      Liondekam
 * Author URI:  http://dfd.name
 * Text Domain: news-page-slider
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!defined('NEWS_PAGE_SLIDER_SLUG')) {
	define('NEWS_PAGE_SLIDER_SLUG', 'news-page-slider');
}




require_once( plugin_dir_path( __FILE__ ) . 'class-news-page-slider.php' );

require_once( plugin_dir_path( __FILE__ ) . 'ajax.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.

// Activation hook for creating the initial DB table
register_activation_hook( __FILE__, array( 'News_Page_Slider', 'activate' ) );


function aq_resize_load () {

	require_once( plugin_dir_path( __FILE__ ) . 'lib/aq_resizer.php');

}

add_action('after_setup_theme', 'aq_resize_load');



News_Page_Slider::get_instance();


<?php
/**
 * Plugin Name: Installer Plugin
 * Plugin URI: http://artillgence.com
 * Description: Setup Websites in seconds
 * Version: 1.0
 * Author: Artillegence
 * Author URI: http://artillgence.com
 * Requires at least: 3.5
 * Tested up to: 3.8.1
 *
 * Text Domain: ioa
 * Domain Path: /i18n/languages/
 *
 * @package IOA
 * @category Builder
 * @author Artillegence
 */

// Variables & Constants Declaration


define('EASY_F_PLUGIN_URL',plugins_url().'/easy_installer/');
define('EASY_F_PLUGIN_PATH',plugin_dir_path(__FILE__));

$easy_metadata = array(
	"config" => EASY_F_PLUGIN_PATH.'demo_data_here/config.xml',
	"image" => "dummy.jpg"
);

$config_suboption = '';

if(file_exists($easy_metadata['config'])) :
	$xml= simplexml_load_file($easy_metadata['config']);
	$easy_metadata['data'] = $xml;
else :
	$easy_metadata['data'] = false;
endif;

// Init Core Rountines
require_once('ioa_hooks.php');


require_once(EASY_F_PLUGIN_PATH.'classes/class_installer_helper.php');
require_once(EASY_F_PLUGIN_PATH.'classes/class_admin_panel_maker.php');

require_once('ioa_functions.php');
require_once(EASY_F_PLUGIN_PATH.'admin/backend.php');

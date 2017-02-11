<?php

if(!is_admin()) return;




/**
 * Add CSS & JS Files
 */

add_action('admin_enqueue_scripts','addEASYJSFScripts');

function addEASYJSFScripts() {
	if(  isset($_GET['page']) && $_GET['page'] == 'easint'  ) {
		wp_enqueue_style('easy-instf-css',EASY_F_PLUGIN_URL.'sprites/custom.css');
	}

}
		

function addMetaDemoData() {
	global $easy_metadata;

	if(!$easy_metadata['data']) return; // No Config File Return

	easy_import_after_xml();

	EASYFInstallerHelper::setMenus();
	EASYFInstallerHelper::setOptions();
	EASYFInstallerHelper::setMediaData();
	EASYFInstallerHelper::setSmkSidebarGenerator();
	EASYFInstallerHelper::setWidgets();
	EASYFInstallerHelper::setHomePage();
	EASYFInstallerHelper::setRevslider();
	EASYFInstallerHelper::setNewsPageSlider();
	EASYFInstallerHelper::import_theme_options();

	easy_import_end();

}

if(isset($_GET['page']) && $_GET['page'] == 'easint')
add_action('import_end','addMetaDemoData');
<?php
/**
 *  Base Class for creating admin panels.
 *  Version : 3.1
 *  Dependency : None
 */

$ioa_page_get = '';

if(isset($_GET['page']))
$ioa_page_get =  $_GET['page']; // In class scope it points to Inherited class

if(!class_exists('PLUGIN_IOA_PANEL_CORE')) {

// == Class defination begins	=====================================================
  
	class PLUGIN_IOA_PANEL_CORE {
	  
		private $name;
		private $panelName;
		private $type;
		private $icon;
		private $role;

		private $tabs;

		private $topBar = true;
		private $isCustom = false;
		/**
		*  Constrtuctor For Admin Maker 
		*  @param string $name The Name of the Panel that will Appear in WP ADMIN side menu
		*  @param string $type Type of Menu Defautl Page(Separate Menu) , supported values are page and submenu
		*  @param string $panel_name	unique key name for panel( ex : admin.php?page=ULT ). Defaults to first 5 letters in capital.
		*  @param string $icon The link to icon , set to false to use wp default icon. 
		*  @param string $role The role/level required to access the panel. 
		*/

		function __construct($name,$type='page',$panel_name=false, $icon = false,$role = 'edit_theme_options') { 
		/*

		$this->name = $name;
		$this->tabs = array();
		if(!$panel_name)
			$this->panelName = strtolower(substr($name,0,5));
		else
			$this->panelName = 	$panel_name;

		$this->type = $type;

		if(!$icon)
			$this->icon  = EASY_F_PLUGIN_URL."sprites/i/icon.png";
		else
			$this->icon = $icon;

		$this->role= $role;
		add_action('admin_menu',array(&$this,'manager_admin_menu'));
		add_action('admin_init',array(&$this,'manager_admin_init'));
		*/
		}

		function disableTopBar() {
			$this->topBar = false;
		}

		function isCustomPanel($bool) {
			$this->isCustom = $bool;
		}
		function manager_admin_menu() {
		/*

		switch($this->type)
		{
		   case 'page' : add_menu_page( $this->name,  $this->name , $this->role, $this->panelName ,array($this,'manager_admin_wrap'),  $this->icon);  break;
		   case 'submenu':  add_submenu_page("ioa", $this->name, $this->name, $this->role, $this->panelName ,array($this,'manager_admin_wrap')); break;
		   case 'theme':  add_theme_page($this->name, $this->name, $this->role, $this->panelName ,array($this,'manager_admin_wrap')); break;
		   case 'null':  add_submenu_page(null, $this->name, $this->name, $this->role, $this->panelName ,array($this,'manager_admin_wrap')); break;
		}
		*/

		}

		function manager_admin_init() {	


		}	

		function panelmarkup() { }


		/**
		* Add a Vertical Tab
		* @param array get Tab data
		*/

		public function addTab($tab) {
			$this->tabs[] = $tab;
		}


		function manager_admin_wrap() {	
			$this->panelmarkup() ; 
		}	  
	  
	 
	} // == End of Class ==========================
     
}
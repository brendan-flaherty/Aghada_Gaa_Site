<?php
/**
 *  Name - Installer Panel
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

class IOAEasyFrontInstaller extends PLUGIN_IOA_PANEL_CORE {
	
	
	// init menu
	function __construct () { 

		add_action('admin_menu',array(&$this,'manager_admin_menu'));
        add_action('admin_init',array(&$this,'manager_admin_init'));
        
	 }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 }
	
	function manager_admin_menu(){
		add_theme_page('Installer Panel', 'Installer Panel', 'edit_theme_options', 'easint' ,array($this,'manager_admin_wrap'));
	}

	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
	   global $easy_metadata, $config_suboption;
		
		$layouts = array(
			'first' => __('Traditional', 'dfd_import'),
			'second' => __('Barber', 'dfd_import'),
			'third' => __('Scrolling content', 'dfd_import'),
			'fourth' => __('Pricing agency', 'dfd_import'),
			'fifth' => __('Slider scroll effect', 'dfd_import'),
			'sixth' => __('Portfolio full screen', 'dfd_import'),
			'seventh' => __('Portfolio parallax', 'dfd_import'),
			'eighth' => __('Portfolio boxed', 'dfd_import'),
			'ninth' => __('Portfolio side menu', 'dfd_import'),
			'tenth' => __('One page traditional', 'dfd_import'),
			'eleventh' => __('One page corporate', 'dfd_import'),
			'twelfth' => __('Side menu corporate', 'dfd_import'),
			'thirteenth' => __('Boxed corporate', 'dfd_import'),
			'fourteenth' => __('Scrolling effect', 'dfd_import'),
			'fifteenth' => __('One page navigation', 'dfd_import'),
			'sixteenth' => __('Vertical scroll', 'dfd_import'),
			'seventeenth' => __('Model agency', 'dfd_import'),
			'eighteenth' => __('Coming soon', 'dfd_import'),
			'ninteenth' => __('Coming soon second', 'dfd_import'),
			'twentieth' => __('Minimalist', 'dfd_import'),
			'twenty_first' => __('Monochrome', 'dfd_import'),
			'twenty_second' => __('Lawyers agency', 'dfd_import'),
			'twenty_third' => __('Building agency', 'dfd_import'),
			'twenty_fourth' => __('Portfolio slider', 'dfd_import'),
			'twenty_fifth' => __('Apps corporate', 'dfd_import'),
			'twenty_sixth' => __('Portfolio horizontal', 'dfd_import'),
			'twenty_seventh' => __('Creative bright', 'dfd_import'),
			'twenty_eighth' => __('Vintage Web Agency', 'dfd_import'),
			'twenty_ninth' => __('Vintage Creative Agency', 'dfd_import'),
			'thirtieth' => __('Contrast Portfolio', 'dfd_import'),
			'thirty_first' => __('One Page Vintage', 'dfd_import'),
			'thirty_second' => __('3D One page', 'dfd_import'),
			'thirty_third' => __('Fitness Gym', 'dfd_import'),
			'thirty_fourth' => __('3D Scrolling One page', 'dfd_import'),
			'thirty_fifth' => __('Bright Creative', 'dfd_import'),
			'thirty_sixth' => __('Restaurant', 'dfd_import'),
			'thirty_seventh' => __('Medicine', 'dfd_import'),
			'shop_first' => __('Shop with more info', 'dfd_import'),
			'shop_second' => __('Shop with categories slider', 'dfd_import'),
			'shop_third' => __('Shop with side navigation', 'dfd_import'),
			'shop_fourth' => __('Shop with full thumb products', 'dfd_import'),
			'promo' => __('Promo', 'dfd_import'),
		);
		
		$prefix = __('Install layout ', 'dfd_import');
		
		if( (isset($_GET['page']) && $_GET['page'] == 'easint') && isset($_GET['demo_install'])  ) :
			easy_import_start();
			EASYFInstallerHelper::beginInstall();
		endif; 
		if( (isset($_GET['page']) && $_GET['page'] == 'easint') ) :
			if(isset($_GET['demo_layout_select'])) {
				$dummy_file = $_GET['demo_layout_select'];
				if(array_key_exists($dummy_file, $layouts)) {
					$config_suboption = '_'.$dummy_file;
					easy_import_start();
					EASYFInstallerHelper::beginInstall();
				}
			}
		endif;
		
		?>
		
		<?php if(isset($_GET['demo_install'])): easy_success_notification(); endif; ?>

		<div class="demo-installer clearfix">
			<h2><?php echo $easy_metadata['data']->panel_title; ?></h2>

			<p><?php echo $easy_metadata['data']->panel_text; ?></p>

			<a href="<?php echo admin_url() ?>themes.php?page=easint&amp;demo_install=true" class="button-install"><?php _e("Install Main demo content") ?></a>
			
			<div class="install-layouts-section">
				<?php foreach($layouts as $value => $name) : ?>
					<a href="<?php echo admin_url() ?>themes.php?page=easint&amp;demo_layout_select=<?php echo $value; ?>" class="button-layout-install">
						<img src="<?php echo EASY_F_PLUGIN_URL . 'demo_data_here/thumbs/'.$value.'.jpg'; ?>" />
						<div class="button-title"><?php echo $prefix.$name; ?></div>
					</a>
				<?php endforeach; ?>
			</div>

		</div>

		<?php
		
	 }
}

new IOAEasyFrontInstaller();
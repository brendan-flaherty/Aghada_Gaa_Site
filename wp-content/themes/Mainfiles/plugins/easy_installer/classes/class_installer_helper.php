<?php
class EASYFInstallerHelper {

	static function beginInstall() {
		global $easy_metadata, $config_suboption;
		EASYFInstallerHelper::createImages();

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		if(function_exists( 'wordpress_importer_init' )){
			echo '<div style="font-weight: bold; font-size: 22px; text-transform: uppercase; line-height: 1.6; padding: 40px 20px;">'.__('Demo data import is impossible due to the activated WordPress Importer plugin. Please, deactivate the plugin and restart the demo import.','dfd_import').'</div>';
			die();
		} else {
			$class_wp_import = EASY_F_PLUGIN_PATH . '/admin/importer/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) )
				require_once($class_wp_import);
		}

		$import_file = EASY_F_PLUGIN_PATH.'demo_data_here/dummy'.$config_suboption.'.xml';

		if(is_file($import_file)) {

			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = false;

			if(isset($easy_metadata['data']->allow_attachment) && $easy_metadata['data']->allow_attachment == "yes")
				$wp_import->fetch_attachments = true;

			$wp_import->import($import_file);
		}
	}


	static function setMediaData() {
		global $easy_metadata;

		$attach_ids = get_option('easy_demo_images');

		if(!$attach_ids) return;

		$pattern = '(\bhttps?:\/\/\S+?\.(?:jpg|png|gif))';

		$fn_i = array();
		foreach ($attach_ids as $key => $id) {
			$fn_i[]  = wp_get_attachment_image_src($id,'full'); 
		}

		$image_metas = explode(',',$easy_metadata['data']->post_meta_replace);
		$mi = count($image_metas);

		$post_types = explode(',',$easy_metadata['data']->post_type);

		$wp_query = new WP_Query(array(
				"post_type" => $post_types,
				"posts_per_page" => -1
			));
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$id =  get_the_ID();
			set_post_thumbnail($id,   $attach_ids[0] );

			if( $easy_metadata['data']->force_image_replace == "yes" )
			{
				 $content = get_the_content(); 
				 $content = preg_replace($pattern,addslashes($fn_i[0][0]),$content);
				 wp_update_post(array( "ID" => $id , "post_content" => $content )); 
			}

			for ($i=0; $i < $mi; $i++) 
			{
				update_post_meta($id,$image_metas[$i],$fn_i[0][0]);
			}	

		endwhile; 

	}

	static function setOptions() {
		global $easy_metadata, $config_suboption, $wpdb;

		ob_start();

		$options_vals = base64_decode($easy_metadata['data']->options.$config_suboption);
		//$input = json_decode($options_vals ,true);

		$data = unserialize($options_vals);

		foreach ($data as $key=>$option) {
			if (in_array($key, array('woocommerce', 'wc_wishlist')))
				continue;

			delete_option($key);
			update_option($key, $option);
		}

		if (is_plugin_active('woocommerce/woocommerce.php')) {
			foreach ($data['woocommerce'] as $wc_key=>$wc_option) {
				delete_option($wc_key);
				update_option($wc_key, $wc_option);
			}
		}

		if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
			foreach ($data['wc_wishlist'] as $wcwl_key=>$wcwl_option) {
				delete_option($wcwl_key);
				update_option($wcwl_key, $wcwl_option);
			}
		}

		echo '<p>wp options imported!</p>';

		ob_end_flush();
/*
		global $easy_metadata, $wpdb;
		$options_vals = base64_decode($easy_metadata['data']->options);
		$input = json_decode($options_vals ,true);
		$excludes = explode(',',$easy_metadata['data']->options_exclude);
		var_dump($input, $options_vals, $excludes);
		foreach($input as $key => $val)
		{
			if( is_serialized($val["option_value"]) )
					update_option($val["option_name"],unserialize($val["option_value"]));
				else
					update_option($val["option_name"],$val["option_value"]);
		}

		$sn = $easy_metadata['data']->option_shortname;

		foreach ($excludes as $key => $value) {

			delete_option($sn.$value);
		}
*/
	}

	static function setMenus() {
		global $easy_metadata, $config_suboption, $wpdb;
		
		if(isset($config_suboption) && $config_suboption == '') {
			
			$table_db_name = $wpdb->prefix . "terms";


			$menus = explode(',',$easy_metadata['data']->menu_data);

			$mappedMenus = array();
			$db_str = array();
			foreach ($menus as $key => $menu) {
				$t = explode(':', $menu);
				$mappedMenus[] = array("menu" => trim($t[0]) , "location" => trim($t[1]));
				$db_str[] = "name='".trim($t[0])."'";
			}

			$query = "SELECT * FROM $table_db_name where ".implode(' OR ',$db_str)." ";
			$rows = $wpdb->get_results($query,ARRAY_A);

			$menu_ids = array();
			foreach($rows as $row)
				$menu_ids[$row["name"]] = $row["term_id"] ; 

			$menu_locs = array();

			foreach ($mappedMenus as $key => $menu) {
				 $menu_locs[$menu['location']] = $menu_ids[$menu['menu']];
			}


			set_theme_mod( 'nav_menu_locations', array_map( 'absint', $menu_locs) );
		}

	}
	static function setHomePage() {
		global $easy_metadata, $config_suboption;
		$page = get_page_by_title( $easy_metadata['data']->home_page.$config_suboption );
		if(!empty($page) && is_object($page)) {
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
		}
	}

	static function setSmkSidebarGenerator() {
		global $wpdb, $easy_metadata, $config_suboption;

		ob_start();

		if (!is_plugin_active('smk-sidebar-generator/smk-sidebar-generator.php')) {
			echo '<p>smk_sidebar_generator plugin is not active!</p>';
			return;
		}

		$data = maybe_unserialize(base64_decode($easy_metadata['data']->sidebars.$config_suboption));

		delete_option('smk_sidebar_generator_option');
		if (update_option('smk_sidebar_generator_option', $data)) {
			echo '<p>smk_sidebar_generator data imported!</p>';
		} else {
			echo '<p>smk_sidebar_generator data is up to date!</p>';
		}

		ob_end_flush();
	}


	static function setWidgets() {
		global $wpdb;
		$added = true;
		ob_start();

		$data_file = EASY_F_PLUGIN_PATH.'demo_data_here/widgets.wie';

		if (!file_exists($data_file)) {
			echo '<p>Widgets file is not exists!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>Widgets file is empty!</p>';
			return;
		}

		$data = json_decode($data, true);

		$available_widgets = array();
		foreach ($GLOBALS['wp_widget_factory']->widgets as $available_widget) {
			$available_widgets[] = $available_widget->id_base;
		}

		$widgets_out = array();
		$sidebars_out = array();

		$sidebars_out['wp_inactive_widgets'] = array();

		foreach ( $data as $sidebar_id => $widgets ) {
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}

			// active widgets in sidebars
			foreach ($widgets as $widget_name=>$widget_settings) {
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_name );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_name );

				if (!in_array($id_base, $available_widgets))
					continue;

				$sidebars_out[$sidebar_id][] = $widget_name;

				$widgets_out[$id_base][$instance_id_number] = $widget_settings;
			}
		}

		// save widgets
		foreach ($widgets_out as $wo_k=>$wo_v) {
			if (count($widgets_out[$wo_k]) > 1) {
				$widgets_out[$wo_k]['_multiwidget'] = 1;
			}

			delete_option('widget_'.$wo_k);
			if (!add_option('widget_'.$wo_k, $wo_v))
				$added = false;
		}

		// save sidebars
		$sidebars_out['array_version'] = 1;
		delete_option('sidebars_widgets');
		if (!add_option('sidebars_widgets', $sidebars_out))
			$added = false;

		if ($added) {
			echo '<p>Widgets data imported!</p>';
		} else {
			echo '<p>Widgets data is up to date!</p>';
		}

		ob_end_flush();

	}
	
	static function setRevslider() {
		global $wpdb, $config_suboption;
		
		ob_start();

		$data_file = EASY_F_PLUGIN_PATH.'demo_data_here/revslider'.$config_suboption.'.txt';

		if (!file_exists($data_file)) {
			echo '<p>Revolution slider file does not exist!</p>';
			return;
		}

		if (!is_plugin_active('revslider/revslider.php')) {
			echo '<p>Revolution slider plugin is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>Revolution slider file is empty!</p>';
			return;
		}

		$revslider_data = json_decode(base64_decode($data), true);
		if (empty($revslider_data)) {
			echo '<p>Revolution slider file is empty!</p>';
			return;
		}

		$sliders_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SLIDERS_NAME;
		$slides_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SLIDES_NAME;
		$settings_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SETTINGS_NAME;
		$css_table = $wpdb->prefix . GlobalsRevSlider::TABLE_CSS_NAME;
		$layer_anims_table = $wpdb->prefix . GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;

		$wpdb->query("TRUNCATE TABLE {$sliders_table};");
		$wpdb->query("TRUNCATE TABLE {$slides_table};");
		$wpdb->query("TRUNCATE TABLE {$settings_table};");
		$wpdb->query("TRUNCATE TABLE {$css_table};");
		$wpdb->query("TRUNCATE TABLE {$layer_anims_table};");
		
		// settings
		if (!empty($revslider_data['settings'])) {
			$sql = "INSERT INTO `$settings_table` (`id`, `general`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['settings'] as $setting) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s)", 
						$setting['id'], 
						$setting['general'], 
						$setting['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// css
		if (!empty($revslider_data['css'])) {
			$sql = "INSERT INTO `$css_table` (`id`, `handle`, `settings`, `hover`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['css'] as $css) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s, %s, %s)", 
						$css['id'], 
						$css['handle'], 
						$css['settings'], 
						$css['hover'], 
						$css['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// layer animation
		if (!empty($revslider_data['layer_anims'])) {
			$sql = "INSERT INTO `$layer_anims_table` (`id`, `handle`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['layer_anims'] as $layer_anim) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s)", 
						$layer_anim['id'], 
						$layer_anim['handle'], 
						$layer_anim['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// sliders
		
		if (!empty($revslider_data['sliders'])) {
			foreach($revslider_data['sliders'] as $slider) {
				$sql = $wpdb->prepare("INSERT INTO `$sliders_table` (`id`, `title`, `alias`, `params`) VALUES (%d, %s, %s, %s)", 
						$slider['id'], 
						$slider['title'], 
						$slider['alias'], 
						$slider['params']);
				$wpdb->query($sql);
				unset($sql);
				
				// slides
				if (!empty($slider['slides'])) {
					$sql = "INSERT INTO `$slides_table` (`id`, `slider_id`, `slide_order`, `params`, `layers`) VALUES ";
					$sql_data = array();
					foreach ($slider['slides'] as $slide) {
						$sql_data[] = $wpdb->prepare("(%d, %d, %d, %s, %s)", 
								$slide['id'], 
								$slide['slider_id'], 
								$slide['slide_order'],
								$slide['params'],
								$slide['layers']);
					}
					$sql .= implode(',', $sql_data).';';
					$wpdb->query($sql);
					unset($sql);
				}
			}
		}

		echo '<p>RevSlider data imported!</p>';

		ob_end_flush();
	}

	static function setNewsPageSlider() {
		global $wpdb, $easy_metadata;

		ob_start();

		if (!is_plugin_active('news-page-slider/news-page-slider.php')) {
			echo '<p>news_page_slider plugin is not active!</p>';
			return;
		}

		$data = $easy_metadata['data']->news_slider;

		if (empty($data)) {
			echo '<p>news_page_slider file is empty!</p>';
			return;
		}

		$sample_slider = json_decode(base64_decode($data), true);

		$table_name = $wpdb->prefix . "news_page_slider";

		$wpdb->query("TRUNCATE TABLE {$table_name}");
		foreach ($sample_slider as $key => $val) {
			$wpdb->query(
					$wpdb->prepare("INSERT INTO $table_name (id, name, data, date_c, date_m) VALUES (%d, %s, %s, %d, %d)", $key, $val['name'], json_encode($val['data']), time(), time()
					)
			);
		}

		echo '<p>news_page_slider data imported!</p>';

		ob_end_flush();
	}

	static function createImages() {
		return;
		/*
		global $easy_metadata;

		if(!file_exists(EASY_F_PLUGIN_PATH."/demo_data_here/".$easy_metadata['image']))
		{
			return;
		}

		if( get_option('easy_demo_images') ) return get_option('easy_demo_images');

		$images = array( $easy_metadata['image'] );
		$attach_ids = array();
		foreach ($images as $image) {

			$path = wp_upload_dir(); 
			$cstatus =   copy( EASY_F_PLUGIN_PATH."/demo_data_here/".$image,  $path['path'].'/'.$image  );
			$filename = $path['path'].'/'.$image;

			$wp_filetype = wp_check_filetype(basename($filename), null );
			$attachment = array(
			  'guid' => $path['baseurl'] . _wp_relative_upload_path( $filename ), 
			  'post_mime_type' => $wp_filetype['type'],
			  'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			  'post_content' => '',
			  'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $filename );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			$attach_ids[] =  $attach_id; 	

		}

		update_option('easy_demo_images',$attach_ids);
*/
	}
	
	static function import_theme_options() {
		global $config_suboption;
		ob_start();

		$data_file = EASY_F_PLUGIN_PATH.'demo_data_here/redux_options_ronneby'.$config_suboption.'.json';

		if (!file_exists($data_file)) {
			echo '<p>theme options file is not exists!</p>';
			return;
		}
		
		$theme = wp_get_theme('ronneby');
		
		if (!$theme->exists()) {
			echo '<p>Ronneby theme is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		$data = trim($data, '#');
		if (empty($data)) {
			echo '<p>Theme options file is empty!</p>';
			return;
		}
		
		$data = json_decode(trim($data), true);
		//$data_array = maybe_unserialize($data);
		if (is_array($data_array)) {
			foreach ($data_array as $k=>$v) {
				if(is_array($v)) {
					$v = serialize($v);
				}
				$data_array[$k] = preg_replace('/^(ht.+?)\/wp-content/i', site_url( 'wp-content'), trim($v));
			}
			
			$data = $data_array;
		}

		delete_option('ronneby');
		if ( update_option( 'ronneby', maybe_unserialize($data) ) )  {
			echo '<p>Theme options imported!</p>';
		} else {
			echo '<p>theme options are up to date</p>';
		}

		ob_end_flush();
	}

}
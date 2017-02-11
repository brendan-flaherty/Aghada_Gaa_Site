<?php

/**
 * Hook that runs just before importer starts
 */

function easy_import_start()
{
	do_action('easy_import_start');	
}


/**
 * Hook that runs when Importer Has finished importing files and installed all settings
 */

function easy_import_end()
{
	do_action('easy_import_end');	
}


/**
 * Hook that runs after importer has finished importing xml data and before setting other options
 */
 
function easy_import_after_xml()
{
	do_action('easy_import_after_xml');	
}

// ================== Filters ========================


function easy_success_notification($msg = "Content Installed Successfully !")
{

	if(has_filter('easy_success_message')) {
		$msg = apply_filters('easy_success_message', $msg);
	}
	?>
	<div class="success-mesage"> <?php echo $msg; ?> </div>
	<?php
}


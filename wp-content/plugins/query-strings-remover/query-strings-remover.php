<?php
/*
Plugin Name: Query Strings Remover
Plugin URI: https://atulhost.com/query-strings-remover
Description: Query Strings Remover removes query strings from your static resources like CSS and JavaScript files. It will improve your cache performance and overall score in Google PageSpeed, YSlow, Pingdom and GTmetrix. Just install and forget everything, as no configuration needed.
Author: Atul Kumar Pandey
Version: 1.1
Author URI: https://atulhost.com
*/
function qsr_remove_query_strings_1( $src ){	
	$rqs = explode( '?ver', $src );
        return $rqs[0];
}
		if ( is_admin() ) {
// Remove query strings from static resources disabled in admin
}

		else {
add_filter( 'script_loader_src', 'qsr_remove_query_strings_1', 15, 1 );
add_filter( 'style_loader_src', 'qsr_remove_query_strings_1', 15, 1 );
}

function qsr_remove_query_strings_2( $src ){
	$rqs = explode( '&ver', $src );
        return $rqs[0];
}
		if ( is_admin() ) {
// Remove query strings from static resources disabled in admin
}

		else {
add_filter( 'script_loader_src', 'qsr_remove_query_strings_2', 15, 1 );
add_filter( 'style_loader_src', 'qsr_remove_query_strings_2', 15, 1 );
}
?>
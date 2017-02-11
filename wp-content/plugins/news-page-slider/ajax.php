<?php
/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 3/18/14
 * Time: 6:17 PM
 */

add_action( 'wp_ajax_nps_get_cat', 'nps_get_cat_callback' );

function nps_get_cat_callback() {
	global $wpdb; // this is how you get access to the database

	$postType = $_POST['postType'];

	$cat = 'category';
	switch ($postType) {
		case 'post':
			$cat = 'category';
			echo '<option value="" disabled="disabled">---------------- Posts categories ------------</option>';
			break;
		case 'my-product':
			$cat = 'my-product_category';
			echo '<option value="" disabled="disabled">---------------- Portfolio categories ------------</option>';
			break;
		case 'product':
			$cat = 'product_cat';
			echo '<option value="" disabled="disabled">---------------- Woocommerce categories ------------</option>';
			break;
	}
	switch ($postType) {
		case 'post':
		case 'my-product':
		case 'product':
			$args = array(
				'postType' => $postType,
				'orderby' => 'id',
				'hierarchical' => 'false',
				'taxonomy' => $cat
			);
			$categories = get_terms($cat, $args);

			foreach ($categories as $category) {

				echo '<option value="' . $category->slug . '" >"' . $category->name . '"</option>';

			}
	}



	die(); // this is required to return a proper result
}
<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   News page slider
 * @author    Liondekam <liondekam@gmail.com>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2013 Crumina Team
 */
?>
<div class="wrap">

    <?php
    $plugin_slug = NEWS_PAGE_SLIDER_SLUG;

    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        include(dirname(__FILE__) . '/edit.php');

    } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
        include(dirname(__FILE__) . '/edit.php');

    } else {
        include(dirname(__FILE__) . '/list.php');
    }

    // Remove slider
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'remove') {
        news_page_slider_removeslider($plugin_slug);
    }
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'edit') {
        news_page_slider_edit($plugin_slug);
    }
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'add') {
        news_page_slider_add_new($plugin_slug);
    }

    /********************************************************/
    /*            News slider remove           */
    /********************************************************/

    function news_page_slider_removeslider($plugin_slug)
    {

        if (!isset($_GET['id'])) {
            return;
        }

        $id = (int)$_GET['id'];

        global $wpdb;

        $table_name = $wpdb->prefix . 'news_page_slider';

        $wpdb->query("DELETE FROM $table_name WHERE id = '$id' LIMIT 1");

        header('Location: admin.php?page=' . $plugin_slug . '');
        die();
    }

    /********************************************************/
    /*            News slider save settings              */
    /********************************************************/
    function news_page_slider_add_new($plugin_slug)
    {
        if (isset($_POST['posted_add']) && strstr($_SERVER['REQUEST_URI'], $plugin_slug)) {

            global $wpdb;

            $slider_data = json_encode($_POST['slider']);
            $slider_title = (isset($_POST['title'])) ? $_POST['title'] : '';

            // Table name
            $table_name = $wpdb->prefix . "news_page_slider";

            $id = mysql_insert_id();

            $wpdb->insert($table_name, array(
                'id' => $id,
                'name' => $slider_title,
                'data' => $slider_data,
                'date_c' => time(),
                'date_m' => time()
            ), array(
                '%d',
                '%s',
                '%s',
                '%d',
                '%d'
            ));

            header('Location: admin.php?page=' . $plugin_slug . '');
            die();
        }
    }

    /********************************************************/
    /*            News slider save settings              */
    /********************************************************/


    function news_page_slider_edit($plugin_slug)
    {
        if (isset($_POST['posted_edit']) && strstr($_SERVER['REQUEST_URI'], $plugin_slug)) {

            // Get WPDB Object
            global $wpdb;

            // Table name
            $table_name = $wpdb->prefix . "news_page_slider";

            // Get the IF of the slider
            $id = (int)$_GET['id'];

            $slider = array();

            $slider = $_POST['slider'];
            $title = (isset($_POST['title'])) ? $_POST['title'] : '';

            // DB data
            $slider_title = $title;
            $slider_data = json_encode($slider);

            // Update
            $wpdb->update($table_name, array(
                    'name' => $slider_title,
                    'data' => $slider_data,
                    'date_c' => time()
                ),
                array('ID' => $id),
                array(
                    '%s',
                    '%s',
                    '%d'
                ),
                array('%d'));
        }
    }

    /********************************************************/
    /*            News slider list items             */
    /********************************************************/

    function crumSliders($limit = 50, $desc = true, $withData = false)
    {

        // Get DB stuff
        global $wpdb;
        $table_name = $wpdb->prefix . 'news_page_slider';

        // Order
        $order = ($desc === true) ? 'DESC' : 'ASC';

        // Data
        if ($withData === true) {
            $data = ' data,';
        }

        // Get sliders
        $link = $sliders = $wpdb->get_results("SELECT * FROM $table_name
									ORDER BY id $order LIMIT " . (int)$limit . "", ARRAY_A);

        // No results
        if ($link == null) {
            return array();
        }

        return $sliders;
    }


    function newsPageSliderById($id = 0)
    {

        // No ID
        if ($id == 0) {
            return false;
        }

        // Get DB stuff
        global $wpdb;
        $table_name = $wpdb->prefix . "news_page_slider";

        // Get data
        $link = $slider = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . (int)$id . " ORDER BY date_c DESC LIMIT 1", ARRAY_A);

        // No results
        if ($link == null) {
            return false;
        }

        // Convert data
        $slider['data'] = json_decode($slider['data'], true);

        // Return the slider
        return $slider;
    }


    ?>

</div>

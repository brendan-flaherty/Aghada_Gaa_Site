<?php
global $wpdb;

// NEW VENUE SUBMISSION
if(isset($_POST['submit'])) {
	$venuename = $_POST['venuename'];
	$venuelocation = trim($_POST['venuelocation']);

	$wpdb->query("INSERT INTO frp_venue (`venueID`, `venuename`, `venuelocation`) VALUES (NULL, '$venuename', '$venuelocation')");

    echo '<div class="updated fade"><p>Venue added successfully!</p></div>';
}

// VENUE EDITING END
if(isset($_POST['edit'])) {
	$venueID = $_POST['venueID'];
	$venuename = $_POST['venuename'];
	$venuelocation = $_POST['venuelocation'];

	$wpdb->query("UPDATE frp_venue SET `venuename` = '$venuename', `venuelocation` = '$venuelocation' WHERE `venueID` = '$venueID' LIMIT 1");

    echo '<div class="updated fade"><p>Venue edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// VENUE DELETION
	if($action == 'delete') {
		$venueID = $_GET['id'];

		$wpdb->query("DELETE FROM frp_venue WHERE `venueID` = '$venueID' LIMIT 1");

        echo '<div class="updated fade"><p>Venue deleted successfully!</p></div>';
	}

	// VENUE EDITING START
	if($action == 'edit') {
		$venueID = $_GET['id'];
        $erow = $wpdb->get_row("SELECT * FROM frp_venue WHERE `venueID` = '$venueID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h2>Edit venue</h2>
                    <div class="inside">
                        <form action="" method="post">
                            <input type="hidden" name="venueID" id="venueID" value="<?php echo $erow['venueID']; ?>">
                            <p>
                                <input class="regular-text" type="text" name="venuename" id="venuename" value="<?php echo $erow['venuename']; ?>" placeholder="Venue name"> 
                                <input class="regular-text" type="url" name="venuelocation" id="venuelocation" value="<?php echo $erow['venuelocation']; ?>" placeholder="Venue homepage">
                            </p>
                            <p><input class="button button-primary" type="submit" name="edit" value="Edit venue"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
}
?>

<div class="wrap">
    <h3>Add new venue</h3>
    <form action="" method="post">
        <p>
            <input class="regular-text" type="text" name="venuename" id="venuename" placeholder="Venue name"> 
            <input class="regular-text" type="url" name="venuelocation" id="venuelocation" placeholder="Venue homepage">
        </p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add venue"></p>
    </form>

    <h3>Venues</h3>
    <?php
    $items = $wpdb->get_results("SELECT * FROM frp_venue");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=venues');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    }
    else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_venue $limit", ARRAY_A);
    ?>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Venue Name<br><small>Click to edit</small></th>
                <th scope="col">Venue Website<br><small>Click to visit</small></th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
            echo '<td>'.$row['venueID'].'</td>';
            echo '<td><a href="' . admin_url('admin.php?page=venues&amp;a=edit&amp;id=' . $row['venueID']) . '">'.$row['venuename'].'</a></td>';
            echo '<td><a href="' . $row['venuelocation'] . '" rel="external">' . $row['venuelocation'] . '</a></td>';
            echo '<td><a href="' . admin_url('admin.php?page=venues&amp;a=delete&amp;id=' . $row['venueID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

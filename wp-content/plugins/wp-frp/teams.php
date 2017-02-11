<?php
global $wpdb;

// NEW TEAM SUBMISSION
if(isset($_POST['submit'])) {
	$teamname = $_POST['teamname'];
	$teamvenue = $_POST['teamvenue'];
	$teamhomepage = $_POST['teamhomepage'];

	$wpdb->query("INSERT INTO frp_team (`teamID`, `teamname`, `teamvenue`, `teamhomepage`) VALUES (NULL, '$teamname', '$teamvenue', '$teamhomepage')");

    echo '<div class="updated fade"><p>Team added successfully!</p></div>';
}

// TEAM EDITING END
if(isset($_POST['edit'])) {
	$teamID = $_POST['teamID'];
	$teamname = $_POST['teamname'];
	$teamvenue = $_POST['teamvenue'];
	$teamhomepage = $_POST['teamhomepage'];

	$wpdb->query("UPDATE frp_team SET `teamname` = '$teamname',`teamvenue` = '$teamvenue', `teamhomepage` = '$teamhomepage' WHERE `teamID` = '$teamID' LIMIT 1");

    echo '<div class="updated fade"><p>Team edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// TEAM DELETION
	if($action == 'delete') {
		$teamID = $_GET['id'];

		$wpdb->query("DELETE FROM frp_team WHERE `teamID` = '$teamID' LIMIT 1");

        echo '<div class="updated fade"><p>Team deleted successfully!</p></div>';
	}

	// TEAM EDITING START
	if($action == 'edit') {
		$teamID = $_GET['id'];
        $erow = $wpdb->get_row("SELECT * FROM frp_team WHERE `teamID` = '$teamID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h2>Edit team</h2>
                    <div class="inside">
                        <form action="" method="post">
                            <input type="hidden" name="teamID" id="teamID" value="<?php echo $erow['teamID']; ?>">
                            <p>
                                <input class="regular-text" type="text" name="teamname" id="teamname" value="<?php echo $erow['teamname']; ?>" placeholder="Team name"> 
                                <input class="regular-text" type="url" name="teamhomepage" id="teamhomepage" value="<?php echo $erow['teamhomepage']; ?>" placeholder="Team homepage">
                            </p>
                            <p>
                                <select name="teamvenue" id="teamvenue">
                                    <?php
                                    $results = $wpdb->get_results("SELECT venueID, venuename FROM frp_venue ORDER BY venuename", ARRAY_A);

                                    foreach($results as $row) {
                                        if($erow['teamvenue'] == $row['venueID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['venueID'] . '"' . $sel . '>' . $row['venuename'] . '</option>';
                                    }
                                    ?> 
                                </select> <label for="competitioncode">Team venue</label>
                            </p>
                            <div></div>
                            <div><input class="button button-primary" type="submit" name="edit" value="Edit team"></div>
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
    <h3>Add new team</h3>
    <form action="" method="post">
        <p>
            <input class="regular-text" type="text" name="teamname" id="teamname" placeholder="Team name"> 
            <input class="regular-text" type="url" name="teamhomepage" id="teamhomepage" placeholder="Team homepage">
        </p>
        <p>
            <select name="teamvenue" id="teamvenue">
                <option value="" selected="selected">Select a team venue...</option>
                <?php
                $results = $wpdb->get_results("SELECT venueID, venuename FROM frp_venue ORDER BY venuename", ARRAY_A);

                foreach($results as $row) {
                    echo '<option value="' . $row['venueID'] . '">' . $row['venuename'] . '</option>';
                }
                ?> 
            </select> <label for="teamvenue">Team venue</label>
        </p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add team"></p>
    </form>

    <h3>Teams</h3>
    <?php
    $items = $wpdb->get_results("SELECT * FROM frp_team");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=teams');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    }
    else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_team $limit", ARRAY_A);
    ?>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Team Name<br><small>Click to edit</small></th>
                <th scope="col">Team Venue</th>
                <th scope="col">Team Homepage<br><small>Click to visit</small></th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
            echo '<td>'.$row['teamID'].'</td>';
            echo '<td><a href="' . admin_url('admin.php?page=teams&amp;a=edit&amp;id=' . $row['teamID']) . '">'.$row['teamname'].'</a></td>';
            echo '<td>';
            $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE `venueID` = '" . $row['teamvenue'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['venuename'];
            echo '</td>';
            echo '<td><a href="' . $row['teamhomepage'] . '" rel="external">' . $row['teamhomepage'] . '</a></td>';
            echo '<td><a href="' . admin_url('admin.php?page=teams&amp;a=delete&amp;id=' . $row['teamID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

<?php
global $wpdb;

// NEW PLAYER SUBMISSION
if(isset($_POST['submit'])) {
	$playername = $_POST['playername'];

	$wpdb->query("INSERT INTO frp_player (`playerID`, `playername`) VALUES (NULL, '$playername')");

    echo '<div class="updated fade"><p>Player added successfully!</p></div>';
}

// PLAYER EDITING END
if(isset($_POST['edit'])) {
	$playerID = $_POST['playerID'];
	$playername = $_POST['playername'];

	$wpdb->query("UPDATE frp_player SET `playername` = '$playername' WHERE `playerID` = '$playerID' LIMIT 1");

    echo '<div class="updated fade"><p>Player edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// PLAYER DELETION
	if($action == 'delete') {
		$playerID = $_GET['id'];

		$wpdb->query("DELETE FROM frp_player WHERE `playerID` = '$playerID' LIMIT 1");

        echo '<div class="updated fade"><p>Player deleted successfully!</p></div>';
	}

	// PLAYER EDITING START
	if($action == 'edit') {
		$playerID = $_GET['id'];
        $erow = $wpdb->get_row("SELECT * FROM frp_player WHERE `playerID` = '$playerID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h2>Edit player</h2>
                    <div class="inside">
                        <form action="" method="post">
                            <input type="hidden" name="playerID" id="playerID" value="<?php echo $erow['playerID']; ?>">
                            <p><input class="regular-text" type="text" name="playername" id="playername" value="<?php echo $erow['playername']; ?>" placeholder="Player name"></p>
                            <p><input class="button button-primary" type="submit" name="edit" value="Edit player"></p>
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
    <h3>Add new player</h3>

    <form action="" method="post">
        <p><input class="regular-text" type="text" name="playername" id="playername" placeholder="Player name"></p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add player"></p>
    </form>

    <h3>Players</h3>
    <?php
    $items = $wpdb->get_results("SELECT * FROM frp_player");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=players');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    }
    else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_player ORDER BY playerID DESC $limit", ARRAY_A);
    ?>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Player Name<br><small>Click to edit</small></th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
            echo '<td>'.$row['playerID'].'</td>';
            echo '<td><a href="' . admin_url('admin.php?page=players&amp;a=edit&amp;id=' . $row['playerID']) . '">'.$row['playername'].'</a></td>';
            echo '<td><a href="' . admin_url('admin.php?page=players&amp;a=delete&amp;id=' . $row['playerID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

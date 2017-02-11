<?php
include('config/config.php');

global $wpdb;

// NEW COMPETITION STAGE SUBMISSION
if(isset($_POST['submit'])) {
	$competitionstage = $_POST['competitionstage'];

    $wpdb->query("INSERT INTO frp_competitionstage (`competitionstageID`, `competitionstage`) VALUES (NULL , '$competitionstage')");

	echo '<div class="updated fade"><p>Competition stage added successfully!</p></div>';
}

// COMPETITION STAGE EDITING END
if(isset($_POST['edit'])) {
	$competitionstageID = $_POST['competitionstageID'];
	$competitionstage = $_POST['competitionstage'];

    $wpdb->query("UPDATE frp_competitionstage SET `competitionstage` = '$competitionstage' WHERE `competitionstageID` = '$competitionstageID' LIMIT 1");

	echo '<div class="updated fade"><p>Competition stage edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// COMPETITION STAGE DELETION
	if($action == 'delete') {
		$competitionstageID = $_GET['id'];

        $wpdb->query($wpdb->prepare("DELETE FROM frp_competitionstage WHERE `competitionstageID` = '%d' LIMIT 1", $competitionstageID));
		echo '<div class="updated fade"><p>Competition stage deleted successfully!</p></div>';
	}

	// COMPETITION STAGE EDITING START
	if($action == 'edit') {
		$competitionstageID = $_GET['id'];
        $erow = $wpdb->get_row("SELECT * FROM frp_competitionstage WHERE `competitionstageID` = '$competitionstageID' LIMIT 1", ARRAY_A);
		?>
            <div class="wrap">
                <div id="poststuff">
                    <div class="postbox">
                        <h2>Edit competition stage</h2>
                        <div class="inside">
                            <form action="" method="post">
                                <p>
                                    <input type="hidden" name="competitionstageID" id="competitionstageID" value="<?php echo $erow['competitionstageID'];?>">
                                    <input class="regular-text" type="text" name="competitionstage" id="competitionstage" value="<?php echo $erow['competitionstage']; ?>" placeholder="Competition stage">
                                </p>
                                <p><input class="button button-primary" type="submit" name="edit" value="Edit competition"></p>
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
    <h3>Add new competition stage</h3>
    <form action="" method="post">
        <p><input class="regular-text" type="text" name="competitionstage" id="competitionstage" placeholder="Competition stage"></p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add competition stage"></p>
    </form>

    <h3>Competition stages</h3>
    <?php
    $items = $wpdb->get_results("SELECT * FROM frp_competitionstage");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=stages');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    } else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_competitionstage $limit", ARRAY_A);
    ?>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Stage<br><small>Click to edit</small></th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['competitionstageID'] . '</td>';
            echo '<td><a href="' . admin_url('admin.php?page=stages&amp;a=edit&amp;id=' . $row['competitionstageID']) . '">' . $row['competitionstage'] . '</a></td>';
            echo '<td><a href="' . admin_url('admin.php?page=stages&amp;a=delete&amp;id=' . $row['competitionstageID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

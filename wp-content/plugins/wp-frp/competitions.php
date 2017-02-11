<?php
include('config/config.php');

global $wpdb;

// NEW COMPETITION SUBMISSION
if(isset($_POST['submit'])) {
	$competitionlongname = $_POST['competitionlongname'];
	$competitionshortname = $_POST['competitionshortname'];
	$competitioncode = $_POST['competitioncode'];
	$competitiongrade = $_POST['competitiongrade'];
	$competitiongendergroup = $_POST['competitiongendergroup'];

    $wpdb->query("INSERT INTO frp_competition (`competitionID`, `competitionlongname`, `competitionshortname`, `competitioncode`, `competitiongrade`, `competitiongendergroup`) VALUES (NULL , '$competitionlongname', '$competitionshortname', '$competitioncode', '$competitiongrade', '$competitiongendergroup')");

	echo '<div class="updated fade"><p>Competition added successfully!</p></div>';
}

// COMPETITION EDITING END
if(isset($_POST['edit'])) {
	$competitionID = $_POST['competitionID'];
	$competitionlongname = $_POST['competitionlongname'];
	$competitionshortname = $_POST['competitionshortname'];
	$competitioncode = $_POST['competitioncode'];
	$competitiongrade = $_POST['competitiongrade'];
	$competitiongendergroup = $_POST['competitiongendergroup'];

	$wpdb->query("UPDATE frp_competition SET `competitionlongname` = '$competitionlongname', `competitionshortname` = '$competitionshortname', `competitioncode` = '$competitioncode', `competitiongrade` = '$competitiongrade', `competitiongendergroup` = '$competitiongendergroup' WHERE `competitionID` = '$competitionID' LIMIT 1");

    echo '<div class="updated fade"><p><strong>Competition edited successfully!</strong></p></div>';
}

if(isset($_GET['a'])) {
	$action = esc_sql($_GET['a']);

	// COMPETITION DELETION
	if($action == 'delete') {
		$competitionID = absint($_GET['id']);

        $wpdb->query($wpdb->prepare("DELETE FROM frp_competition WHERE `competitionID` = '%d' LIMIT 1", $competitionID));
		echo '<div class="updated fade"><p>Competition deleted successfully!</p></div>';
	}

	// COMPETITION EDITING START
	if($action == 'edit') {
		$competitionID = $_GET['id'];
		$erow = $wpdb->get_row("SELECT * FROM frp_competition WHERE `competitionID` = '$competitionID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h2>Edit competition</h2>
                    <div class="inside">
                        <form action="" method="post">
                            <input type="hidden" name="competitionID" id="competitionID" value="<?php echo $erow['competitionID']; ?>">
                            <p>
                                <input class="regular-text" type="text" name="competitionlongname" id="competitionlongname" value="<?php echo $erow['competitionlongname']; ?>" placeholder="Competition long name"> 
                                <input class="regular-text" type="text" name="competitionshortname" id="competitionshortname" value="<?php echo $erow['competitionshortname']; ?>" placeholder="Competition short name">
                            </p>
                            <p>
                                <select name="competitioncode" id="competitioncode">
                                    <option value="">Select competition code...</option>
                                    <?php
                                    $results = $wpdb->get_results("SELECT codeID, codename FROM frp_code ORDER BY codename", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competitioncode'] == $row['codeID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['codeID'] . '"' . $sel . '>' . $row['codename'] . '</option>';
                                    }
                                    ?>
                                </select> 
                                <select name="competitiongrade" id="competitiongrade">
                                    <option value="">Select competition grade...</option>
                                    <?php
                                    $results = $wpdb->get_results("SELECT gradeID, gradename FROM frp_grade", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competitiongrade'] == $row['gradeID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['gradeID'] . '"' . $sel . '>' . $row['gradename'] . '</option>';
                                    }
                                    ?>
                                </select> 
                                <select name="competitiongendergroup" id="competitiongendergroup">
                                    <option value="">Select competition gender group...</option>
                                    <option value="Male"<?php if($erow['competitiongendergroup'] == 'Male') echo ' selected'; ?>>Male</option>
                                    <option value="Female"<?php if($erow['competitiongendergroup'] == 'Female') echo ' selected'; ?>>Female</option>
                                </select>
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
global $wpdb;
?>

<div class="wrap">
    <h3>Add new competition</h3>
    <form action="" method="post">
        <p>
            <input class="regular-text" type="text" name="competitionlongname" id="competitionlongname" placeholder="Competition long name"> 
            <input class="regular-text" type="text" name="competitionshortname" id="competitionshortname" placeholder="Competition short name">
        </p>
        <p>
            <select name="competitioncode" id="competitioncode">
                <option value="">Select competition code...</option>
                <?php
                $results = $wpdb->get_results("SELECT codeID, codename FROM frp_code ORDER BY codename", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['codeID'] . '">' . $row['codename'] . '</option>';
                }
                ?> 
            </select> 
            <select name="competitiongrade" id="competitiongrade">
                <option value="">Select competition grade...</option>
                <?php
                $results = $wpdb->get_results("SELECT gradeID, gradename FROM frp_grade ORDER BY gradename", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['gradeID'] . '">' . $row['gradename'] . '</option>';
                }
                ?> 
            </select> 
            <select name="competitiongendergroup" id="competitiongendergroup">
                <option value="">Select competition gender group...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add competition"></p>
    </form>

    <h3>Competitions</h3>
    <?php
    $items = $wpdb->get_results("SELECT competitionID FROM frp_competition");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=competitions');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    } else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_competition $limit", ARRAY_A);
    ?>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Long name<br><small>Click to edit</small></th>
                <th scope="col">Short name</th>
                <th scope="col">Code</th>
                <th scope="col">Grade</th>
                <th scope="col">Gender group</th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
                echo '<td>' . $row['competitionID'] . '</td>';
                echo '<td><a href="' . admin_url('admin.php?page=competitions&amp;a=edit&amp;id=' . $row['competitionID']) . '">' . $row['competitionlongname'] . '</a></td>';
                echo '<td>' . $row['competitionshortname'] . '</td>';
                echo '<td>';
                    $rowcode = $wpdb->get_row("SELECT codename FROM frp_code WHERE `codeID` = '" . $row['competitioncode'] . "' LIMIT 1", ARRAY_A);
                    echo $rowcode['codename'];
                echo '</td>';
                echo '<td>';
                    $rowgrade = $wpdb->get_row("SELECT * FROM frp_grade WHERE `gradeID` = '" . $row['competitiongrade'] . "' LIMIT 1", ARRAY_A);
                    echo $rowgrade['gradename'];
                echo '</td>';
                echo '<td>' . $row['competitiongendergroup'] . '</td>';
                echo '<td><a href="' . admin_url('admin.php?page=competitions&amp;a=delete&amp;id=' . $row['competitionID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

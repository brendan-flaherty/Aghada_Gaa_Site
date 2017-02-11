<?php
global $wpdb;

// NEW FORMATION SUBMISSION
if(isset($_POST['submit'])) {
	$playernumber1 = 	$_POST['playernumber1']; 	$playername1 = 	$_POST['playername1'];	$player1 = 	$playernumber1.','.$playername1;
	$playernumber2 = 	$_POST['playernumber2']; 	$playername2 = 	$_POST['playername2']; 	$player2 = 	$playernumber2.','.$playername2;
	$playernumber3 = 	$_POST['playernumber3']; 	$playername3 = 	$_POST['playername3']; 	$player3 = 	$playernumber3.','.$playername3;
	$playernumber4 = 	$_POST['playernumber4']; 	$playername4 = 	$_POST['playername4']; 	$player4 = 	$playernumber4.','.$playername4;
	$playernumber5 = 	$_POST['playernumber5']; 	$playername5 = 	$_POST['playername5']; 	$player5 = 	$playernumber5.','.$playername5;
	$playernumber6 = 	$_POST['playernumber6']; 	$playername6 = 	$_POST['playername6']; 	$player6 = 	$playernumber6.','.$playername6;
	$playernumber7 = 	$_POST['playernumber7']; 	$playername7 = 	$_POST['playername7']; 	$player7 = 	$playernumber7.','.$playername7;
	$playernumber8 = 	$_POST['playernumber8']; 	$playername8 = 	$_POST['playername8']; 	$player8 = 	$playernumber8.','.$playername8;
	$playernumber9 = 	$_POST['playernumber9']; 	$playername9 = 	$_POST['playername9']; 	$player9 = 	$playernumber9.','.$playername9;
	$playernumber10 = 	$_POST['playernumber10']; 	$playername10 = $_POST['playername10']; $player10 = $playernumber10.','.$playername10;
	$playernumber11 = 	$_POST['playernumber11']; 	$playername11 = $_POST['playername11']; $player11 = $playernumber11.','.$playername11;
	$playernumber12 = 	$_POST['playernumber12']; 	$playername12 = $_POST['playername12']; $player12 = $playernumber12.','.$playername12;
	$playernumber13 = 	$_POST['playernumber13']; 	$playername13 = $_POST['playername13']; $player13 = $playernumber13.','.$playername13;
	$playernumber14 = 	$_POST['playernumber14']; 	$playername14 = $_POST['playername14']; $player14 = $playernumber14.','.$playername14;
	$playernumber15 = 	$_POST['playernumber15']; 	$playername15 = $_POST['playername15']; $player15 = $playernumber15.','.$playername15;
	$subs = $_POST['subs'];

	if($playername1 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername1');");
	if($playername2 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername2');");
	if($playername3 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername3');");
	if($playername4 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername4');");
	if($playername5 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername5');");
	if($playername6 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername6');");
	if($playername7 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername7');");
	if($playername8 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername8');");
	if($playername9 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername9');");
	if($playername10 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername10');");
	if($playername11 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername11');");
	if($playername12 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername12');");
	if($playername13 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername13');");
	if($playername14 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername14');");
	if($playername15 != '') $wpdb->query("INSERT INTO frp_player (`playername`) VALUES ('$playername15');");

	$wpdb->query("INSERT INTO frp_formation (`formationID`, `player1`, `player2`, `player3`, `player4`, `player5`, `player6`, `player7`, `player8`, `player9`, `player10`, `player11`, `player12`, `player13`, `player14`, `player15`, `subs`) VALUES (NULL, '$player1', '$player2', '$player3', '$player4', '$player5', '$player6', '$player7', '$player8', '$player9', '$player10', '$player11', '$player12', '$player13', '$player14', '$player15', '$subs')");

    echo '<div class="updated fade"><p>Formation added successfully!</p></div>';
}

// Formation EDITING END
if(isset($_POST['edit'])) {
	$formationID = $_POST['formationID'];

	$playernumber1 = $_POST['playernumber1']; $playername1 = $_POST['playername1']; $player1 = $playernumber1 . ',' . $playername1;
	$playernumber2 = $_POST['playernumber2']; $playername2 = $_POST['playername2']; $player2 = $playernumber2 . ',' . $playername2;
	$playernumber3 = $_POST['playernumber3']; $playername3 = $_POST['playername3']; $player3 = $playernumber3 . ',' . $playername3;
	$playernumber4 = $_POST['playernumber4']; $playername4 = $_POST['playername4']; $player4 = $playernumber4 . ',' . $playername4;
	$playernumber5 = $_POST['playernumber5']; $playername5 = $_POST['playername5']; $player5 = $playernumber5 . ',' . $playername5;
	$playernumber6 = $_POST['playernumber6']; $playername6 = $_POST['playername6']; $player6 = $playernumber6 . ',' . $playername6;
	$playernumber7 = $_POST['playernumber7']; $playername7 = $_POST['playername7']; $player7 = $playernumber7 . ',' . $playername7;
	$playernumber8 = $_POST['playernumber8']; $playername8 = $_POST['playername8']; $player8 = $playernumber8 . ',' . $playername8;
	$playernumber9 = $_POST['playernumber9']; $playername9 = $_POST['playername9']; $player9 = $playernumber9 . ',' . $playername9;
	$playernumber10 = $_POST['playernumber10']; $playername10 = $_POST['playername10']; $player10 = $playernumber10 . ',' . $playername10;
	$playernumber11 = $_POST['playernumber11']; $playername11 = $_POST['playername11']; $player11 = $playernumber11 . ',' . $playername11;
	$playernumber12 = $_POST['playernumber12']; $playername12 = $_POST['playername12']; $player12 = $playernumber12 . ',' . $playername12;
	$playernumber13 = $_POST['playernumber13']; $playername13 = $_POST['playername13']; $player13 = $playernumber13 . ',' . $playername13;
	$playernumber14 = $_POST['playernumber14']; $playername14 = $_POST['playername14']; $player14 = $playernumber14 . ',' . $playername14;
	$playernumber15 = $_POST['playernumber15']; $playername15 = $_POST['playername15']; $player15 = $playernumber15 . ',' . $playername15;
	$subs = $_POST['subs'];

	$wpdb->query("UPDATE frp_formation SET 
			`player1` = '$player1',
			`player2` = '$player2',
			`player3` = '$player3',
			`player4` = '$player4',
			`player5` = '$player5',
			`player6` = '$player6',
			`player7` = '$player7',
			`player8` = '$player8',
			`player9` = '$player9',
			`player10` = '$player10',
			`player11` = '$player11',
			`player12` = '$player12',
			`player13` = '$player13',
			`player14` = '$player14',
			`player15` = '$player15',
			`subs` = '$subs'
		WHERE `formationID` = '$formationID' LIMIT 1;");

    echo '<div class="updated fade"><p>Formation edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// FORMATION DELETION
	if($action == 'delete') {
		$formationID = $_GET['id'];

		$wpdb->query("DELETE FROM frp_formation WHERE `formationID` = '$formationID' LIMIT 1");

        echo '<div class="updated fade"><p>Formation deleted successfully!</p></div>';
	}
	if($action == 'edit') {
		$formationID = $_GET['id'];

		$erow = $wpdb->get_row("SELECT * FROM frp_formation WHERE `formationID` = '$formationID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h3>Edit formation</h3>
                    <div class="inside">
                        <p>Select an existing player from the database (right column) or manually enter a new one (left column). New players will be automatically added to database.</p>
                        <p>Leave field 13 empty for 12-a-side formations and field 14 and 15 for 13-a-side formations.</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>?page=formations" method="post" name="playersedit" id="playersedit">
                            <input type="hidden" name="formationID" id="formationID" value="<?php echo $erow['formationID']; ?>">

                            <?php for($n=1; $n<=15; ++$n) { ?>
                                <div>
                                    <?php $player = $player . $n; ?>
                                    <?php $player = explode(',', $erow['player' . $n]); $player = $player[1]; ?>
                                    <input type="text" name="playernumber<?php echo $n; ?>" id="playernumber<?php echo $n; ?>" size="2" value="<?php echo $n; ?>" readonly> 
                                    <input class="regular-text" type="text" name="playername<?php echo $n; ?>" value="<?php echo $player; ?>">

                                    <?php
                                    $results = $wpdb->get_results("SELECT DISTINCT playername FROM frp_player ORDER BY playername", ARRAY_A);
                                    echo '<select onchange="document.playersedit.playername' . $n . '.value = this.value">';
                                        echo '<option selected="selected">Player database...</option>';
                                        foreach($results as $playerrow) {
                                            echo '<option value="' . $playerrow['playername'] . '">' . $playerrow['playername'] . '</option>';
                                        }
                                    echo '</select>';
                                    ?>
                                    <label for="playername<?php echo $n; ?>">Player <?php echo $n; ?></label>
                                </div>
                            <?php } ?>

                            <p><input class="regular-text" type="text" name="subs" id="subs" value="<?php echo $erow['subs']; ?>"> <label for="subs">Subs</label></p>
                            <p><input class="button-primary" type="submit" name="edit" value="Edit formation"></p>
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
    <h3>Add new formation</h3>
    <p>Select an existing player from the database (right column) or manually enter a new one (left column). New players will be automatically added to database.</p>
    <p>Leave field 13 empty for 12-a-side formations and field 14 and 15 for 13-a-side formations.</p>
    <form action="" method="post" name="players" id="players">
        <?php for($n=1; $n<=15; ++$n) { ?>
            <div>
                <input type="text" name="playernumber<?php echo $n; ?>" id="playernumber<?php echo $n; ?>" size="2" value="<?php echo $n; ?>" readonly> 
                <input class="regular-text" type="text" name="playername<?php echo $n; ?>" id="playername<?php echo $n; ?>"> 

                <?php
                $results = $wpdb->get_results("SELECT DISTINCT playername FROM frp_player ORDER BY playername", ARRAY_A);
                echo '<select onchange="document.players.playername' . $n . '.value = this.value">';
                    echo '<option selected="selected">Player database...</option>';
                    foreach($results as $playerrow) {
                        echo '<option value="' . $playerrow['playername'] . '">' . $playerrow['playername'] . '</option>';
                    }
                echo '</select>';
                ?> 
                <label for="playername<?php echo $n; ?>">Player <?php echo $n; ?></label>
            </div>
        <?php } ?>

        <p><input class="regular-text" type="text" name="subs" id="subs"> <label for="subs">Subs</label></p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add formation"></p>
    </form>

    <h3>Formations</h3>
    <?php
    $items = $wpdb->get_results("SELECT * FROM frp_formation");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=formations');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    } else {
        echo 'No records found!';
    }

    $results = $wpdb->get_results("SELECT * FROM frp_formation ORDER BY formationID DESC $limit", ARRAY_A);
    ?>

    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Players/Subs<br><small>Click to edit</small></th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($results as $row) {
            echo '<tr>';
                echo '<td>'.$row['formationID'].'</td>';
                echo '<td><a href="' . admin_url('admin.php?page=formations&amp;a=edit&amp;id=' . $row['formationID']) . '"><b>Players:</b></a> ';
                $player1 = explode(',', $row['player1']);	echo '('.$player1[0].') '.$player1[1].', ';
                $player2 = explode(',', $row['player2']);	echo '('.$player2[0].') '.$player2[1].', ';
                $player3 = explode(',', $row['player3']);	echo '('.$player3[0].') '.$player3[1].', ';
                $player4 = explode(',', $row['player4']);	echo '('.$player4[0].') '.$player4[1].', ';
                $player5 = explode(',', $row['player5']);	echo '('.$player5[0].') '.$player5[1].', ';
                $player6 = explode(',', $row['player6']);	echo '('.$player6[0].') '.$player6[1].', ';
                $player7 = explode(',', $row['player7']);	echo '('.$player7[0].') '.$player7[1].', ';
                $player8 = explode(',', $row['player8']);	echo '('.$player8[0].') '.$player8[1].', ';
                $player9 = explode(',', $row['player9']);	echo '('.$player9[0].') '.$player9[1].', ';
                $player10 = explode(',', $row['player10']);	echo '('.$player10[0].') '.$player10[1].', ';
                $player11 = explode(',', $row['player11']);	echo '('.$player11[0].') '.$player11[1].', ';
                $player12 = explode(',', $row['player12']);	echo '('.$player12[0].') '.$player12[1].', ';
                $player13 = explode(',', $row['player13']);	echo '('.$player13[0].') '.$player13[1].'';
                $player14 = explode(',', $row['player14']);	if($player14[1] != '') echo ', ('.$player14[0].') '.$player14[1].', ';
                $player15 = explode(',', $row['player15']);	if($player15[1] != '') echo '('.$player15[0].') '.$player15[1];
                echo '<br><b>Subs:</b> '.$row['subs'];
                echo '</td>';
                echo '<td><a href="' . admin_url('admin.php?page=formations&amp;a=delete&amp;id=' . $row['formationID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

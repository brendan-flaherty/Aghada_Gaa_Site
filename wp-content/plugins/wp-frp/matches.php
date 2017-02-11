<?php
function getTweetUrl($url, $title) {
	$maxTitleLength = 140 - (strlen($url)+1);
	if(strlen($title) > $maxTitleLength) {
		$title = substr($title, 0, ($maxTitleLength-3)).'...';
	}

    return 'https://twitter.com/intent/tweet?text=' . urlencode($title . ' ' . $url) . '&source=webclient';
}

global $wpdb;

// NEW MATCH SUBMISSION
if(isset($_POST['submit'])) {
	$competition = $_POST['competition'];
	$code = $_POST['code'];
	$grade = $_POST['grade'];
	$competitionstage = $_POST['competitionstage'];
	$competitionyear = $_POST['competitionyear'];
	$team1 = $_POST['team1'];
	$team2 = $_POST['team2'];

	$date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['matchdate'])));
	$matchdate = $date;

	$matchtime = $_POST['matchtime'];
	$matchvenue = $_POST['matchvenue'];
	$matchreplay = $_POST['matchreplay'];
	$team1goals = $_POST['team1goals'];
	$team1points = $_POST['team1points'];
	$team1overallpoints = $_POST['team1overallpoints'];
	$team2goals = $_POST['team2goals'];
	$team2points = $_POST['team2points'];
	$team2overallpoints = $_POST['team2overallpoints'];
	$matchwalkover = $_POST['matchwalkover'];
	$extratimeplayed = $_POST['extratimeplayed'];
	$matchreport = $_POST['matchreport'];
	$matchaudiovideo = $_POST['matchaudiovideo'];
	$matchphotos = $_POST['matchphotos'];
	$matchtype = $_POST['matchtype'];
	$teamformation = $_POST['teamformation'];

    $wpdb->query("INSERT INTO `frp_match` (`matchID`, `competition`, `code`, `grade`, `competitionstage`, `competitionyear`, `team1`, `team2`, `matchdate`, `matchtime`, `matchvenue`, `matchreplay`, `team1goals`, `team1points`, `team1overallpoints`, `team2goals`, `team2points`, `team2overallpoints`, `matchwalkover`, `extratimeplayed`, `matchreport`, `matchaudiovideo`, `matchphotos`, `matchtype`, `teamformation`) VALUES (NULL , '$competition' , '$code' , '$grade' , '$competitionstage' , '$competitionyear' , '$team1' , '$team2' , '$matchdate' , '$matchtime' , '$matchvenue' , '$matchreplay' , '$team1goals' , '$team1points' , '$team1overallpoints' , '$team2goals' , '$team2points' , '$team2overallpoints' , '$matchwalkover' , '$extratimeplayed' , '$matchreport' , '$matchaudiovideo' , '$matchphotos' , '$matchtype' , '$teamformation');");

	echo '<div class="updated fade"><p>Match added successfully!</p></div>';
}

// MATCH EDITING END
if(isset($_POST['edit'])) {
	$matchID = $_POST['matchID'];
	$competition = $_POST['competition'];
	$code = $_POST['code'];
	$grade = $_POST['grade'];
	$competitionstage = $_POST['competitionstage'];
	$competitionyear = $_POST['competitionyear'];
	$team1 = $_POST['team1'];
	$team2 = $_POST['team2'];

	$date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['matchdate'])));
	$matchdate = $date;

	$matchtime = $_POST['matchtime'];
	$matchvenue = $_POST['matchvenue'];
	$matchreplay = $_POST['matchreplay'];
	$team1goals = $_POST['team1goals'];
	$team1points = $_POST['team1points'];
	$team1overallpoints = $_POST['team1overallpoints'];
	$team2goals = $_POST['team2goals'];
	$team2points = $_POST['team2points'];
	$team2overallpoints = $_POST['team2overallpoints'];
	$matchwalkover = $_POST['matchwalkover'];
	$extratimeplayed = $_POST['extratimeplayed'];
	$matchreport = $_POST['matchreport'];
	$matchaudiovideo = $_POST['matchaudiovideo'];
	$matchphotos = $_POST['matchphotos'];
	$matchtype = $_POST['matchtype'];
	$teamformation = $_POST['teamformation'];

	$wpdb->query("UPDATE `frp_match` SET `competition` = '$competition', `code` = '$code', `grade` = '$grade', `competitionstage` = '$competitionstage', `competitionyear` = '$competitionyear', `team1` = '$team1', `team2` = '$team2', `matchdate` = '$matchdate', `matchtime` = '$matchtime', `matchvenue` = '$matchvenue', `matchreplay` = '$matchreplay', `team1goals` = '$team1goals', `team1points` = '$team1points', `team1overallpoints` = '$team1overallpoints', `team2goals` = '$team2goals', `team2points` = '$team2points', `team2overallpoints` = '$team2overallpoints', `matchwalkover` = '$matchwalkover', `extratimeplayed` = '$extratimeplayed', `matchreport` = '$matchreport', `matchaudiovideo` = '$matchaudiovideo', `matchphotos` = '$matchphotos', `matchtype` = '$matchtype', `teamformation` = '$teamformation' WHERE `matchID` = '$matchID' LIMIT 1;");

    echo '<div class="updated fade"><p>Match edited successfully!</p></div>';
}

if(isset($_GET['a'])) {
	$action = $_GET['a'];

	// MATCH DELETION
	if($action == 'delete') {
		$matchID = $_GET['id'];

		$wpdb->query($wpdb->prepare("DELETE FROM `frp_match` WHERE `matchID` = '%d' LIMIT 1", $matchID));
        echo '<div class="updated fade"><p>Match deleted successfully!</p></div>';
	}

	// MATCH EDITING START
	if($action == 'edit') {
		$matchID = $_GET['id'];
        $erow = $wpdb->get_row("SELECT * FROM frp_match WHERE `matchID` = '$matchID' LIMIT 1", ARRAY_A);
		?>
        <div class="wrap">
            <div id="poststuff">
                <div class="postbox">
                    <h2>Edit match</h2>
                    <div class="inside">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>?page=matches" method="post" class="required-form">
                            <input type="hidden" name="matchID" id="matchID" value="<?php echo $matchID; ?>">
                            <p>
                                <select name="code" id="code">
                                    <?php
                                    $results = $wpdb->get_results("SELECT codeID, codename FROM frp_code ORDER BY codename", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competitioncode'] == $row['codeID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['codeID'] . '"' . $sel . '>' . $row['codename'] . '</option>';
                                    }
                                    ?>
                                </select> <select name="grade" id="grade">
                                    <?php
                                    $results = $wpdb->get_results("SELECT gradeID, gradename FROM frp_grade", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competitiongrade'] == $row['gradeID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['gradeID'] . '"' . $sel . '>' . $row['gradename'] . '</option>';
                                    }
                                    ?>
                                </select> <label>Code and grade</label>
                            </p>
                            <p>
                                <select name="competition" id="competition">
                                    <?php
                                    $results = $wpdb->get_results("SELECT competitionID, competitionlongname FROM frp_competition", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competition'] == $row['competitionID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['competitionID'] . '"' . $sel . '>' . $row['competitionlongname'] . '</option>';
                                    }
                                    ?>
                                </select> <select name="competitionstage" id="competitionstage">
                                    <?php
                                    $results = $wpdb->get_results("SELECT competitionstageID, competitionstage FROM frp_competitionstage", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['competitionstage'] == $row['competitionstageID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['competitionstageID'] . '"' . $sel . '>' . $row['competitionstage'] . '</option>';
                                    }
                                    ?>
                                </select> <select name="competitionyear" id="competitionyear">
                                    <option value="<?php echo $erow['competitionyear'];?>" selected="selected"><?php echo $erow['competitionyear'];?></option>
                                    <?php
                                    for($y = date('Y') + 1; $y >= 1899; $y--) {
                                        echo '<option value="' . $y . '">' . $y . '</option>';
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <select name="team1" id="team1">
                                    <?php
                                    $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['team1'] == $row['teamID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['teamID'] . '"' . $sel . '>' . $row['teamname'] . '</option>';
                                    }
                                    ?>
                                </select> <label>vs</label> <select name="team2" id="team2">
                                    <?php
                                    $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['team2'] == $row['teamID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['teamID'] . '"' . $sel . '>' . $row['teamname'] . '</option>';
                                    }
                                    ?>
                                </select> <label>@</label> <select name="matchvenue" id="matchvenue">
                                    <?php
                                    $results = $wpdb->get_results("SELECT venueID, venuename FROM frp_venue ORDER BY venuename", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['matchvenue'] == $row['venueID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['venueID'] . '"' . $sel . '>' . $row['venuename'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <input class="one" type="text" name="matchdate" id="matchdate" value="<?php echo $erow['matchdate']; ?>" placeholder="Match date"> 
                                <input type="text" name="matchtime" id="matchtime" value="<?php echo $erow['matchtime']; ?>" placeholder="Match time">
                            </p>
                            <p>
                                <input type="number" name="team1goals" id="team1goals" value="<?php echo $erow['team1goals']; ?>" placeholder="Team 1 goals"> 
                                <input type="number" name="team1points" id="team1points" value="<?php echo $erow['team1points']; ?>" placeholder="Team 1 Points"> 
                                <input type="number" name="team1overallpoints" id="team1overallpoints" value="<?php echo $erow['team1overallpoints']; ?>" placeholder="Team 1 overall points"> <label>Team 1 goals/points/overall</label>
                                <br>
                                <input type="number" name="team2goals" id="team2goals" value="<?php echo $erow['team2goals']; ?>" placeholder="Team 2 goals"> 
                                <input type="number" name="team2points" id="team2points" value="<?php echo $erow['team2points']; ?>" placeholder="Team 2 points"> 
                                <input type="number" name="team2overallpoints" id="team2overallpoints" value="<?php echo $erow['team2overallpoints']; ?>" placeholder="Team 2 overall points"> <label>Team 2 goals/points/overall</label>
                            </p>
                            <p>
                                <select name="matchwalkover" id="matchwalkover">
                                    <option value=""></option>
                                    <?php
                                    $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                                    foreach($results as $row) {
                                        if($erow['matchwalkover'] == $row['teamID']) $sel = ' selected';
                                        else $sel = '';
                                        echo '<option value="' . $row['teamID'] . '"' . $sel . '>' . $row['teamname'] . '</option>';
                                    }
                                    ?>
                                </select> <select name="extratimeplayed" id="extratimeplayed">
                                    <option value="YES"<?php if($erow['extratimeplayed'] == 'YES') echo ' selected';?>>Extra time playes</option>
                                    <option value="NO"<?php if($erow['extratimeplayed'] == 'NO') echo ' selected';?>>No extra time played</option>
                                </select> <select name="matchreplay" id="matchreplay">
                                    <option value="Yes"<?php if($erow['matchreplay'] == 'Yes') echo ' selected';?>>Yes</option>
                                    <option value="No"<?php if($erow['matchreplay'] == 'No') echo ' selected';?>>No</option>
                                </select> <label for="matchreplay">Match replay</label>
                            </p>
                            <p>
                                <input type="url" name="matchreport" id="matchreport" value="<?php echo $erow['matchreport']; ?>" placeholder="Match report URL"> 
                                <input type="url" name="matchaudiovideo" id="matchaudiovideo" value="<?php echo $erow['matchaudiovideo']; ?>" placeholder="Match audio/video URL"> 
                                <input type="url" name="matchphotos" id="matchphotos" value="<?php echo $erow['matchphotos']; ?>" placeholder="Match photos URL"> 
                            </p>
                            <p>
                                <select name="matchtype" id="matchtype">
                                    <option value="12"<?php if($erow['matchtype'] == '12') echo ' selected';?>>Match type -&gt; 12 a-side</option>
                                    <option value="13"<?php if($erow['matchtype'] == '13') echo ' selected';?>>Match type -&gt; 13 a-side</option>
                                    <option value="15"<?php if($erow['matchtype'] == '15') echo ' selected';?>>Match type -&gt; 15 a-side</option>
                                </select> <input type="number" name="teamformation" id="teamformation" value="<?php echo $erow['teamformation']; ?>"> <label for="teamformation">Formation ID</label>
                            </p>
                            <p><input class="button button-primary" type="submit" name="edit" value="Edit match"></p>
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
    <h3>Add new match</h3>
    <form action="" method="post">
        <p>
            <select name="code" id="code">
                <?php
                $results = $wpdb->get_results("SELECT codeID, codename FROM frp_code ORDER BY codename", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['codeID'] . '">' . $row['codename'] . '</option>';
                }
                ?>
            </select> <select name="grade" id="grade">
            <?php
            $results = $wpdb->get_results("SELECT gradeID, gradename FROM frp_grade", ARRAY_A);
            foreach($results as $row) {
                echo '<option value="' . $row['gradeID'] . '">' . $row['gradename'] . '</option>';
            }
            ?>
            </select> <label>Code and grade</label>
        </p>
        <p>
            <select name="competition" id="competition">
                <option value="">Select competition...</option>
                <?php
                $results = $wpdb->get_results("SELECT competitionID, competitionlongname FROM frp_competition ORDER BY competitionlongname", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['competitionID'] . '">' . $row['competitionlongname'] . '</option>';
                }
                ?>
            </select> <select name="competitionstage" id="competitionstage">
                <option value="">Select competition stage...</option>
                <?php
                $results = $wpdb->get_results("SELECT competitionstageID, competitionstage FROM frp_competitionstage ORDER BY competitionstage", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['competitionstageID'] . '">' . $row['competitionstage'] . '</option>';
                }
                ?>
            </select> <select name="competitionyear" id="competitionyear" class="regular">
                <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                <?php
                for($y = date('Y') + 1; $y >= 1899; $y--) {
                    echo '<option value="' . $y . '">' . $y . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <select name="team1" id="team1">
                <option value="">Select team 1...</option>
                <?php
                $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['teamID'] . '">' . $row['teamname'] . '</option>';
                }
                ?>
            </select> <label>vs</label> <select name="team2" id="team2">
                <option value="">Select team 2...</option>
                <?php
                $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['teamID'] . '">' . $row['teamname'] . '</option>';
                }
                ?>
            </select> <label>@</label> <select name="matchvenue" id="matchvenue">
                <option value="" selected="selected">Select venue...</option>
                <?php
                $results = $wpdb->get_results("SELECT venueID, venuename FROM frp_venue ORDER BY venuename", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['venueID'] . '">' . $row['venuename'] . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <input class="one" type="text" name="matchdate" id="matchdate" placeholder="Match date"> 
            <input type="text" name="matchtime" id="matchtime" placeholder="Match time" list="matchtime-datalist">
            <datalist id="matchtime-datalist">
                <?php
                $min = array('00'); // '15', '30', '45'

                for ($i=0; $i<23; $i++) {
                    foreach ($min as $v) {
                        echo '<option>' . $i . ':' . $v . '</option>';
                    }
                }
                ?>
            </datalist>
        </p>
        <p>
            <input type="number" name="team1goals" id="team1goals" placeholder="Team 1 goals"> 
            <input type="number" name="team1points" id="team1points" placeholder="Team 1 points"> 
            <input type="number" name="team1overallpoints" id="team1overallpoints" placeholder="Team 1 overall points"> <label>Team 1 goals/points/overall</label>
            <br>
            <input type="number" name="team2goals" id="team2goals" placeholder="Team 2 goals"> 
            <input type="number" name="team2points" id="team2points" placeholder="Team 2 points"> 
            <input type="number" name="team2overallpoints" id="team2overallpoints" placeholder="Team 2 overall points"> <label>Team 2 goals/points/overall</label>
        </p>
        <p>
            <select name="matchwalkover" id="matchwalkover">
                <option value="">Select match walkover (optional)...</option>
                <?php
                $results = $wpdb->get_results("SELECT teamID, teamname FROM frp_team ORDER BY teamname", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['teamID'] . '">' . $row['teamname'] . '</option>';
                }
                ?>
            </select> <select name="extratimeplayed" id="extratimeplayed">
                <option value="No">No extra time played</option>
                <option value="Yes">Extra time played</option>
            </select> <select name="matchreplay" id="matchreplay">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select> <label for="matchreplay">Match replay</label>
        </p>
        <p>
            <input type="url" name="matchreport" id="matchreport" placeholder="Match report URL"> 
            <input type="url" name="matchaudiovideo" id="matchaudiovideo" placeholder="Match audio/video URL"> 
            <input type="url" name="matchphotos" id="matchphotos" placeholder="Match photos URL">
        </p>
        <p>
            <select name="matchtype" id="matchtype">
                <option value="12">Match type -&gt; 12 a-side</option>
                <option value="13">Match type -&gt; 13 a-side</option>
                <option value="15" selected>Match type -&gt; 15 a-side</option>
            </select> 
            <input type="number" name="teamformation" id="teamformation"> <label for="teamformation">Formation ID</label>
        </p>
        <p><input class="button button-primary" type="submit" name="submit" value="Add match"></p>
    </form>

    <h3>Matches</h3>
    <form action="" name="filter_form" method="post">
        <p>
            Filter matches: 
            <select name="filter_year">
                <option value="">By year...</option>
                <?php
                $results = $wpdb->get_results("SELECT DISTINCT competitionyear FROM frp_match ORDER BY competitionyear DESC", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['competitionyear'] . '">' . $row['competitionyear'] . '</option>';
                }
                ?>
            </select> 

            <select name="filter_competition">
                <option value="">By competition...</option>
                <?php
                $results = $wpdb->get_results("SELECT competitionID, competitionlongname FROM frp_competition ORDER BY competitionlongname", ARRAY_A);
                foreach($results as $row) {
                    echo '<option value="' . $row['competitionID'] . '">' . $row['competitionlongname'] . '</option>';
                }
                ?>
            </select>

            <button onchange="document.forms.filter_form.submit();" class="button button-secondary">Go</button>
        </p>
    </form>
    <?php
    $filter1 = '';
    $filter2 = '';
    if(isset($_POST['filter_year'])) {
        if(strlen($_POST['filter_year']) > 0)
            $filter1 = "competitionyear='".$_POST['filter_year']."' AND ";
    }
    if(isset($_POST['filter_competition']) != '') {
        if(strlen($_POST['filter_competition']) > 0)
            $filter2 = "competition='".$_POST['filter_competition']."' AND ";
    }

    $items = $wpdb->get_results("SELECT * FROM frp_match WHERE $filter1 $filter2 1=1 ORDER BY matchID DESC");
    $items = $wpdb->num_rows;

    if($items > 0) {
        $p = new frp_pagination;
        $p->items($items);
        $p->target('admin.php?page=matches');
        $p->calculate();

        if(!isset($_GET['paging'])) $p->page = 1;
        else $p->page = $_GET['paging'];

        $limit = 'LIMIT ' . ($p->page - 1) * $p->limit . ', ' . $p->limit;
    } else {
        echo 'No records found!';
    }

    $hometeam = get_option('frp_team');
    $mresults = $wpdb->get_results("SELECT * FROM frp_match WHERE $filter1 $filter2 1=1 ORDER BY matchID DESC $limit", ARRAY_A);
    ?>

    <p><small>Use the competition ID from <strong>Competition (ID) (Stage)</strong> column to filter results on posts and pages (e.g. <code>[frp-resultsyear year=&quot;2014&quot; competition=&quot;10&quot;]</code>).</small></p>
    <div class="tablenav"><?php echo $p->show();?></div>
    <table class="wp-list-table widefat striped posts">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">
                    Code/Grade
                    <br><small>Competition (ID) (Stage)</small>
                    <br><small>Click to edit</small>
                </th>
                <th scope="col">Team 1</th>
                <th scope="col">Team 2</th>
                <th scope="col">
                    Match Venue
                    <br><small>Match Date (Time)</small>
                </th>
                <th scope="col">
                    Match Replay
                    <br><small>Match Walkover</small>
                </th>
                <th scope="col">
                    <b>Team 1</b><br><small>Goals/Points/Overall</small><br>
                    <b>Team 2</b><br><small>Goals/Points/Overall</small>
                    <br><small>Extra Time Played</small>
                </th>
                <th scope="col">Reports</th>
                <th scope="col">Type</th>
                <th scope="col">Formation</th>
                <th scope="col"><div class="dashicons dashicons-admin-generic"></div></th>
            </tr>
        </thead>
        <?php
        foreach($mresults as $mrow) {
            echo '<tr>';
            echo '<td>' . $mrow['matchID'] . '</td>';
            echo '<td><a href="' . admin_url('admin.php?page=matches&amp;a=edit&amp;id=' . $mrow['matchID']) . '">';
            $rowcode = $wpdb->get_row("SELECT codename FROM frp_code WHERE `codeID` = '" . $mrow['code'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['codename'];
            echo '/';
            $rowcode = $wpdb->get_row("SELECT gradename FROM frp_grade WHERE `gradeID` = '" . $mrow['grade'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['gradename'] . ' <b>' . $mrow['competitionyear'] . '</b>';
            echo '<br><small>';
            $rowcode = $wpdb->get_row("SELECT competitionID, competitionlongname FROM frp_competition WHERE `competitionID` = '" . $mrow['competition'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['competitionlongname'] . ' (<b>' . $rowcode['competitionID'] . '</b>)';
            $rowcode = $wpdb->get_row("SELECT competitionstage FROM frp_competitionstage WHERE `competitionstageID` = '" . $mrow['competitionstage'] . "' LIMIT 1", ARRAY_A);
            echo ' (' . $rowcode['competitionstage'] . ')</small></td>';
            echo '</a><td>';
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE `teamID` = '" . $mrow['team1'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['teamname'];
            echo '</td>';
            echo '<td>';
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE `teamID` = '" . $mrow['team2'] . "' LIMIT 1", ARRAY_A);
            $vsteam = $rowcode['teamname'];
            echo $vsteam;
            echo '</td>';
            echo '<td>';
            $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE `venueID` = '" . $mrow['matchvenue'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['venuename'];
            echo '<br><small>'.$mrow['matchdate'].' ('.$mrow['matchtime'].')</small></td>';
            echo '<td>' . $mrow['matchreplay'] . '<br><small>';
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE `teamID` = '" . $mrow['matchwalkover'] . "' LIMIT 1", ARRAY_A);
            echo $rowcode['teamname'] . '</small></td>';
            echo '<td><b>Team 1:</b> ' . $mrow['team1goals'] . '/' . $mrow['team1points'] . '/' . $mrow['team1overallpoints']  .'<br><b>Team 2:</b> ' . $mrow['team2goals'] . '/' . $mrow['team2points'] . '/' . $mrow['team2overallpoints'] . '<br><small>' . $mrow['extratimeplayed'] . '</small></td>';
            echo '<td><a href="' . getTweetUrl(home_url(), 'New match: ' . $hometeam . ' vs '.$vsteam.'!').'" target="_blank"><div class="dashicons dashicons-twitter"></div></a> <a href="' . $mrow['matchreport'] . '"><div class="dashicons dashicons-admin-links"></div></a> <a href="' . $mrow['matchaudiovideo'] . '"><div class="dashicons dashicons-video-alt3"></div></a> <a href="' . $mrow['matchphotos'] . '"><div class="dashicons dashicons-format-gallery"></div></a></td>';
            echo '<td>'.$mrow['matchtype'].'</td>';
            echo '<td>'.$mrow['teamformation'].'</td>';
            echo '<td><a href="' . admin_url('admin.php?page=matches&amp;a=delete&amp;id=' . $mrow['matchID']) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><div class="dashicons dashicons-trash"></div></a></td>';
            echo '</tr>';
        }
        ?> 
    </table>
</div>

<?php
function frp_widget_latest($code,$grade) {
    global $wpdb;

	$hometeam = get_option('frp_team');

	if(($code != '') && ($grade != '')) {
        $row = $wpdb->get_row("SELECT codeID FROM frp_code WHERE `codename` = '" . $code . "' LIMIT 1", ARRAY_A);
		$code2 = $row['codeID'];

        $row = $wpdb->get_row("SELECT gradeID FROM frp_grade WHERE `gradename` = '" . $grade . "' LIMIT 1", ARRAY_A);
		$grade2 = $row['gradeID'];

        $mrow = $wpdb->get_row("SELECT * FROM frp_match WHERE code = '$code2' AND grade = '$grade2' AND DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) <= NOW() ORDER BY DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) DESC LIMIT 1", ARRAY_A);

		$display = '<table style="color:#C00000">';

        $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team1'] . "'", ARRAY_A);
		$display .=  '<tr><td style="padding:4px">' . $rowcode['teamname'] . ':</td><td style="padding:4px">' . $mrow['team1goals'] . '-' . $mrow['team1points'] . '</td></tr>';

        $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team2'] . "'", ARRAY_A);
		$display .=  '<tr><td style="padding:4px">' . $rowcode['teamname'] . ':</td><td style="padding:4px">' . $mrow['team2goals'] . '-' . $mrow['team2points'] . '</td></tr>';

        $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE venueID = '" . $mrow['matchvenue'] . "'", ARRAY_A);
		$display .=  '<tr><td style="padding:4px">'.'Venue:</td><td style="padding:4px">' . $rowcode['venuename'] . '</td></tr>';

		$display .=  '<tr><td style="padding:4px">Date:</td><td style="padding:4px">' . date('d/m/Y', strtotime($mrow['matchdate'])) . '</td></tr>';
		$display .= '</table>';

		echo $display;
	}
	if(($code == '') && ($grade == '')) {
        $mrow = $wpdb->get_row("SELECT * FROM frp_match WHERE DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) <= NOW() AND team1goals != '' OR matchwalkover != '' ORDER BY DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) DESC LIMIT 1", ARRAY_A);

		$display = '<table class="frp-widget">';

        $rowcode = $wpdb->get_row("SELECT competitionshortname FROM frp_competition WHERE competitionID = '" . $mrow['competition'] . "'", ARRAY_A);
		$display .=  '<tr><td colspan="2" style="text-align:center"><b>' . $rowcode['competitionshortname'] . '</b></td></tr>';

		$walkover = ' walkover';
		if($mrow['matchwalkover'] == $mrow['team1']) {
			$display .= '<tr><td>' . $hometeam . ':</td><td>Walkover</td></tr>';

            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team2'] . "'", ARRAY_A);
			if(strlen($mrow['team2goals']) > 0)
				$display .=  '<tr><td>' . $rowcode['teamname'] . ':</td><td>' . $mrow['team2goals'] . '-' . str_pad((int) $mrow['team2points'], 2, '0', STR_PAD_LEFT) . '</td></tr>';
			else
				$display .=  '<tr><td>' . $rowcode['teamname'] . ':</td><td></td></tr>';
		}

		else if($mrow['matchwalkover'] == $mrow['team2']) {
			$display .= '<tr><td>' . $hometeam . ':</td><td></td></tr>';
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team2'] . "'", ARRAY_A);
			$display .= '<tr><td>' . $rowcode['teamname'] . ':</td><td>Walkover</td></tr>';
		}

		else {
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team1'] . "'", ARRAY_A);
			$display .= '<tr><td>' . $rowcode['teamname'] . ':</td><td>' . $mrow['team1goals'] . '-' . str_pad((int) $mrow['team1points'], 2, '0', STR_PAD_LEFT) . '</td></tr>';
            $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team2'] . "'", ARRAY_A);
			$display .= '<tr><td>' . $rowcode['teamname'] . ':</td><td>' . $mrow['team2goals'] . '-' . str_pad((int) $mrow['team2points'], 2, '0', STR_PAD_LEFT) . '</td></tr>';
		}

        $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE venueID = '" . $mrow['matchvenue'] . "'", ARRAY_A);
		$display .= '<tr><td>Venue:</td><td>' . $rowcode['venuename'] . '</td></tr>';

		$display .= '<tr><td>Date:</td><td>' . date('d/m/Y', strtotime($mrow['matchdate'])) . '</td></tr>';
		$display .= '</table>';

		echo $display;
	}
}

class FRP_Widget_Latest_Result extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'frp', 'description' => 'A widget that displays the latest result from a selected code and grade.');
		$control_ops = array('id_base' => 'frp-widget');
		parent::__construct('frp-widget', 'F&R Latest Result', $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		extract($args);

		$title 	= apply_filters('widget_title', $instance['title']);
		$code 	= $instance['code'];
		$grade 	= $instance['grade'];

		echo $before_widget;

		echo $before_title . 'Latest Result' . $after_title;

		frp_widget_latest($code, $grade);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['code'] = strip_tags($new_instance['code']);
		$instance['grade'] = strip_tags($new_instance['grade']);

		return $instance;
	}

	function form($instance) {
        global $wpdb;

		$defaults = array('title' => '', 'code' => '', 'grade' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>Leave the text fields blank in order to extract the latest fixture from <b>any</b> category.</p>
		<p>
			<label for="<?php echo $this->get_field_id('code');?>">Code:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" value="<?php echo $instance['code']; ?>">
			<br>
			<?php
            $results = $wpdb->get_results("SELECT * FROM frp_code", ARRAY_A);
			echo '<small><b>Possible values:</b> ';
            foreach($results as $row) {
				echo $row['codename'] . ', ';
			}
			echo '</small>';
			?> 
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Grade:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('grade'); ?>" name="<?php echo $this->get_field_name('grade'); ?>" value="<?php echo $instance['grade']; ?>">
			<br>
			<?php
            $results = $wpdb->get_results("SELECT gradename FROM frp_grade", ARRAY_A);
			echo '<small><b>Possible values:</b> ';
            foreach($results as $row) {
				echo $row['gradename'] . ', ';
			}
			echo '</small>';
			?> 
		</p>
	<?php
	}
}
?>

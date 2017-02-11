<?php
function frp_widget_next($opponent,$venue,$date,$time) {
    global $wpdb;

	$hometeam = get_option('frp_team');

	if(($opponent != '') && ($venue != '') && ($date != '') && ($time != '')) {
		echo '<table class="frp-widget">';
		echo '<tr><td>Opponent:</td><td>' . $opponent . '</td></tr>'; 	
		echo '<tr><td>Venue:</td><td>' . $venue . '</td></tr>'; 	
		echo '<tr><td>Date:</td><td>' . $date . '</td></tr>'; 	
		echo '<tr><td>Time:</td><td>' . $time . '</td></tr>'; 	
		echo '</table>';
	}
	if(($opponent == '') && ($venue == '') && ($date == '') && ($time == '')) {
        $mrow = $wpdb->get_row("SELECT * FROM frp_match WHERE DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) > NOW() ORDER BY DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) ASC LIMIT 1", ARRAY_A);

		$display = '<table class="frp-widget">';

        $rowcode = $wpdb->get_row("SELECT competitionshortname FROM frp_competition WHERE competitionID = '" . $mrow['competition'] . "'", ARRAY_A);
		$display .=  '<tr><td colspan="2" style="text-align:center"><b>' . $rowcode['competitionshortname'] . '</b></td></tr>';

        $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE teamID = '" . $mrow['team2'] . "'", ARRAY_A);
		$display .=  '<tr><td>Opponent:</td><td>' . $rowcode['teamname'] . '</td></tr>';

        $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE venueID = '" . $mrow['matchvenue'] . "'", ARRAY_A);
		$display .=  '<tr><td>Venue:</td><td>' . $rowcode['venuename'] . '</td></tr>';

		if(isset($mrow['matchdate']))
			$display .= '<tr><td>Date:</td><td>' . date('d/m/Y', strtotime($mrow['matchdate'])) . '</td></tr>';
		else
			$display .= '<tr><td>Date:</td><td>-</td></tr>';

		if(isset($mrow['matchtime'])) {
			if(date('H:i', strtotime($mrow['matchtime'])) == '00:00')
				$display .= '<tr><td>Time:</td><td><acronym title="To Be Decided">TBD</acronym></td></tr>';
			if(date('H:i', strtotime($mrow['matchtime'])) != '00:00')
				$display .= '<tr><td>Time:</td><td>' . date('H:i', strtotime($mrow['matchtime'])) . '</td></tr>';
		}
		else
			$display .=  '<tr><td>Time:</td><td><acronym title="To Be Decided">TBD</acronym></td></tr>';
		$display .= '</table>';

		echo $display;
	}
}

class FRP_Widget_Next_Fixture extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'frp1', 'description' => 'A widget that displays the next fixture.');
		$control_ops = array('id_base' => 'frp-widget1');
		parent::__construct('frp-widget1', 'F&R Next Fixture', $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		extract($args);

		$opponent 	= $instance['opponent'];
		$venue 		= $instance['venue'];
		$date 		= $instance['date'];
		$time 		= $instance['time'];

		echo $before_widget;

		echo $before_title . 'Next Fixture' . $after_title;

		frp_widget_next($opponent, $venue, $date, $time);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['opponent'] 	= strip_tags($new_instance['opponent']);
		$instance['venue'] 		= strip_tags($new_instance['venue']);
		$instance['date'] 		= strip_tags($new_instance['date']);
		$instance['time'] 		= strip_tags($new_instance['time']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance);?>

		<p>Leave the text fields blank in order to extract the next fixture from <strong>any</strong> category.</p>
		<p>
			<label for="<?php echo $this->get_field_id('opponent'); ?>">Opponent:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('opponent'); ?>" name="<?php echo $this->get_field_name('opponent'); ?>" value="<?php echo $instance['opponent']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('venue'); ?>">Venue:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('venue'); ?>" name="<?php echo $this->get_field_name('venue'); ?>" value="<?php echo $instance['venue']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('date'); ?>">Date:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" value="<?php echo $instance['date']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('time'); ?>">Time:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('time'); ?>" name="<?php echo $this->get_field_name('time'); ?>" value="<?php echo $instance['time']; ?>">
		</p>
	<?php
	}
}
?>

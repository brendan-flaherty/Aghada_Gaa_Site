<?php
/*
Plugin Name: Fixtures and Results
Plugin URI: https://getbutterfly.com/wordpress-plugins/fixtures-and-results/
Description: This WordPress plugin records, displays and searches football (soccer), hurling, camogie and handball matches. It also allows for easy management of competitions, formations and venues. It features an auto-updatable player database and advanced widgets.
Author: Ciprian Popescu
Version: 3.1.1
Author URI: http://getbutterfly.com/

Copyright 2010, 2011, 2012, 2013, 2014, 2015, 2016 Ciprian Popescu (email: getbutterfly@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('FRP_VERSION', '3.1.1');
define('FRP_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('FRP_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));

include 'classes/pagination.class.php';

add_action('admin_menu', 'wpfrp_menu');

add_action('admin_enqueue_scripts', 'frp_enqueue');
function frp_enqueue() {
    // https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css
    wp_enqueue_style('ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css');

    wp_enqueue_script('frp-functions', plugins_url('/js/functions.js' , __FILE__), array('jquery-ui-datepicker'));
}

register_activation_hook(__FILE__, 'frp_install');

function wpfrp_menu() {
	add_menu_page('Fixtures &amp; Results', 'Fixtures &amp; Results', 'manage_options', 'frp', 'wpfrp_options', 'dashicons-networking');

	add_submenu_page('frp', 'Competitions', 'Competitions', 'manage_options', 'competitions', 'frp_sublevel_page1');
	add_submenu_page('frp', 'Competition Stages', 'Competition Stages', 'manage_options', 'stages', 'frp_sublevel_page2');
	add_submenu_page('frp', 'Matches', 'Matches', 'manage_options', 'matches', 'frp_sublevel_page3');
	add_submenu_page('frp', 'Formations', 'Formations', 'manage_options', 'formations', 'frp_sublevel_page4');
	add_submenu_page('frp', 'Teams', 'Teams', 'manage_options', 'teams', 'frp_sublevel_page5');
	add_submenu_page('frp', 'Venues', 'Venues', 'manage_options', 'venues', 'frp_sublevel_page6');
	add_submenu_page('frp', 'Players', 'Players', 'manage_options', 'players', 'frp_sublevel_page0');

	add_submenu_page('frp', 'Options', 'Options', 'manage_options', 'options', 'frp_sublevel_page9');
}

function wpfrp_options() {
	$images_path = FRP_PLUGIN_URL . '/images/';

    echo '<div class="wrap">
        <h2>Fixtures &amp; Results Dashboard</h2>';

        include 'includes/common.php';

        echo '<div id="poststuff">
            <div class="postbox">
                <h2>Plugin Usage (<a href="https://getbutterfly.com/wordpress-plugins/fixtures-and-results/" rel="external">official web site</a>)</h2>
                <div class="inside">
					<p>
                        This plugin records and displays football, hurling, camogie and handball matches.<br>
					   <small>You are using <b>Fixtures and Results</b> plugin version version ' . FRP_VERSION . '.</small>
                    </p>

					<h3>Shortcodes</h3>
					<p><code>[frp-formations id="1"]</code> - Use the formation ID to display a team formation using one of the 2 possible templates (13-a-side and 15-a-side).</p>
					<p><code>[frp-fixtures]</code> - Displays all upcoming/pending fixtures.</p>
					<p><code>[frp-resultsyear year="2016"]</code> - Displays all results from a specific year. Replace <strong>2016</strong> with the desired year.</p>
					<p><code>[frp-resultsyear year="2016" competition="10"]</code> - Use the competition ID from <strong>Competition (ID) (Stage)</strong> column in Matches section to filter results on posts and pages based on optional competition ID.</p>
					<p><code>[frp-archive]</code> - Displays a filterable matches archive, just like the one on Matches section.</p>

					<h3>Widgets</h3>
					<p>A widget is a box which displays <b>Latest Result</b> and <b>Next Fixture</b> details. <a href="widgets.php">Click here</a> to add widgets.</span></p>
					<p>In order to display the latest result based on code and grade, go to the <strong>Widgets</strong> section and drag F&amp;R Latest Result widget to your sidebar. Add a custom title, select a code and a grade from the suggestions box and save the widget. You are done!</p>
					<p>In order to display the next fixture, go to the <strong>Widgets</strong> section and drag F&amp;R Next Fixture widget to your sidebar. Add the required details and save the widget. You are done!</p>

					<h3>Jerseys</h3>
					<p><span class="description">Jerseys will be displayed as a field formation on the front-end.</span></p>
					<p>You are currently using this jersey set:</p>
					<p>
						<img src="' . $images_path . 'jersey-1.png" alt=""> 
						<img src="' . $images_path . 'jersey-2.png" alt=""> 
						<img src="' . $images_path . 'jersey-3.png" alt=""> 
						<img src="' . $images_path . 'jersey-4.png" alt=""> 
						<img src="' . $images_path . 'jersey-5.png" alt=""> 
						<img src="' . $images_path . 'jersey-6.png" alt=""> 
						<img src="' . $images_path . 'jersey-7.png" alt=""> 
						<img src="' . $images_path . 'jersey-8.png" alt=""> 
						<img src="' . $images_path . 'jersey-9.png" alt=""> 
						<img src="' . $images_path . 'jersey-10.png" alt=""> 
						<img src="' . $images_path . 'jersey-11.png" alt=""> 
						<img src="' . $images_path . 'jersey-12.png" alt=""> 
						<img src="' . $images_path . 'jersey-13.png" alt=""> 
						<img src="' . $images_path . 'jersey-14.png" alt=""> 
						<img src="' . $images_path . 'jersey-15.png" alt=""> 
					</p>
					<p><strong>Subs <small>(Substitutes)</small></strong></p>
					<p><span class="description">In association football, a substitute is a player who is brought on to the pitch during a match in exchange for an existing player.</span></p>
					<p>Substitutions are generally made to replace a player who has become tired or injured, or who is not performing well; there may also be tactical reasons such as bringing a striker on in place of a defender when goals are needed.</p>

					<hr>
					<p>
						<a href="https://getbutterfly.com/wordpress-plugins/fixtures-and-results/" rel="external"><strong>Plugin homepage</strong></a> | 
						<small><a href="https://getbutterfly.com/" rel="external">More Plugins</a></small>
					</p>
				</div>
			</div>
		</div>
	';
	echo '</div>';
}

// frp_sublevel_page() displays the page content for the first submenu of the custom FRP Top Level menu
function frp_sublevel_page0() {
    echo '<h2>Players</h2>';
    include 'includes/common.php';
    include 'players.php';
}
function frp_sublevel_page1() {
    echo '<h2>Competitions</h2>';
    include 'includes/common.php';
    include 'competitions.php';
}
function frp_sublevel_page2() {
    echo '<h2>Competition Stages</h2>';
    include 'includes/common.php';
    include 'competitions.stages.php';
}
function frp_sublevel_page3() {
    echo '<h2>Matches</h2>';
    include 'includes/common.php';
    include 'matches.php';
}
function frp_sublevel_page4() {
    echo '<h2>Formations</h2>';
    include 'includes/common.php';
    include 'formations.php';
}
function frp_sublevel_page5() {
    echo '<h2>Teams</h2>';
    include 'includes/common.php';
    include 'teams.php';
}
function frp_sublevel_page6() {
    echo '<h2>Venues</h2>';
    include 'includes/common.php';
    include 'venues.php';
}
function frp_sublevel_page9() {
    echo '<h2>Options</h2>';
    include 'includes/common.php';
    include 'settings.php';
}

// SHORTCODES //
function frp_fixtures() {
    global $wpdb;

    $results = $wpdb->get_results("SELECT * FROM frp_match WHERE DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) > NOW() ORDER BY DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) ASC", ARRAY_A);

	$display = '<table width="100%" class="frp">
		<thead>
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Venue</th>
				<th>Competition</th>
				<th>Versus</th>
			</tr>
		</thead>';
        foreach($results as $mrow) {
			$display .= '<tr>';
				$display .= '<td>'.date('d/m/Y', strtotime($mrow['matchdate'])).'</td>';
				if(date('H:i', strtotime($mrow['matchtime'])) == '00:00')
					$display .= '<td><acronym title="To Be Decided">TBD</acronym></td>';
				if(date('H:i', strtotime($mrow['matchtime'])) != '00:00')
					$display .= '<td>'.date('H:i', strtotime($mrow['matchtime'])).'</td>';
				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE `venueID` = '" . $mrow['matchvenue'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['venuename'];
				$display .= '</td>';
				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT competitionshortname FROM frp_competition WHERE `competitionID` = '" . $mrow['competition'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['competitionshortname'];
				$display .= '</td>';
				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE `teamID` = '" . $mrow['team2'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['teamname'];
				$display .= '</td>';
			$display .= '</tr>';
		}
		$display .= '</table>';
		return $display;
		?> 
	</table>
<?php
}
function frp_resultsyear($atts, $content = null) {
    global $wpdb;

    extract(shortcode_atts(array(
		'year' => '',
		'competition' => ''
	), $atts));

	// BEGIN PAGINATION HEAD
	$pr = get_option('frp_rpp'); // rows per page
	// END PAGINATION HEAD

    $display .= '<script>
    jQuery(document).ready(function(){
        jQuery("table.frp").each(function() {
            var currentPage = 0;
            var numPerPage = ' . $pr . ';
            var $table = jQuery(this);
            $table.bind("repaginate", function() {
                $table.find("tbody tr").hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
            });
            $table.trigger("repaginate");
            var numRows = $table.find("tbody tr").length;
            var numPages = Math.ceil(numRows / numPerPage);
            var $pager = jQuery("<div class=\"frppager\"></div>");
            for(var page = 0; page < numPages; page++) {
                jQuery("<span class=\"page-number\"></span>").text(page + 1).bind("click", {
                    newPage: page
                }, function(event) {
                    currentPage = event.data["newPage"];
                    $table.trigger("repaginate");
                    jQuery(this).addClass("active").siblings().removeClass("active");
                }).appendTo($pager).addClass("clickable");
            }
            $pager.insertAfter($table).find("span.page-number:first").addClass("active");
        });
    });
    </script>';

	if($competition != '')
        $results = $wpdb->get_results("SELECT * FROM frp_match WHERE DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) <= NOW() AND competitionyear = '$year' AND competition = '$competition' ORDER BY matchdate DESC", ARRAY_A);
	if($competition == '')
        $results = $wpdb->get_results("SELECT * FROM frp_match WHERE DATE_ADD(matchdate, INTERVAL matchtime HOUR_SECOND) <= NOW() AND competitionyear = '$year' ORDER BY matchdate DESC", ARRAY_A);

    $display .= '<table width="100%" class="frp">
		<thead>
			<tr>
				<th>Date</th>
				<th>Venue</th>
				<th>Competition</th>
				<th>Versus</th>
				<th>Score</th>
				<th>Report</th>
			</tr>
		</thead><tbody>';

	foreach($results as $mrow) {
		$display .= '<tr>';
			$display .= '<td><small>'.date('d/m/Y', strtotime($mrow['matchdate'])).'</small></td>';
			$display .= '<td>';
                $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE `venueID` = '" . $mrow['matchvenue'] . "' LIMIT 1", ARRAY_A);
				$display .= $rowcode['venuename'];
			$display .= '</td>';
			$display .= '<td>';
                $rowcode = $wpdb->get_row("SELECT competitionshortname FROM frp_competition WHERE `competitionID` = '" . $mrow['competition'] . "' LIMIT 1", ARRAY_A);
				$display .= $rowcode['competitionshortname'];
			$display .= '</td>';
			$display .= '<td>';
                $rowcode = $wpdb->get_row("SELECT teamname, teamhomepage FROM frp_team WHERE `teamID` = '" . $mrow['team2'] . "' LIMIT 1", ARRAY_A);
				if(!empty($rowcode['teamhomepage']))
					$display .= '<a href="' . $rowcode['teamhomepage'] . '" target="_blank" rel="external">' . $rowcode['teamname'] . '</a>';
				else
					$display .= $rowcode['teamname'];
			$display .= '</td>';
			if($mrow['team1points'] != '')
				$display .= '<td>'.$mrow['team1goals'].'-'.str_pad((int) $mrow['team1points'],2,'0',STR_PAD_LEFT).'<small> to </small>'.$mrow['team2goals'].'-'.str_pad((int) $mrow['team2points'],2,'0',STR_PAD_LEFT).'</td>';
			else if($mrow['matchwalkover'] == '1')
				$display .= '<td>N w/o</td>';
			else if($mrow['matchwalkover'] != '1' && $mrow['matchwalkover'] != '0')
				$display .= '<td>O w/o</td>';
			else if($mrow['matchwalkover'] == '0')
				$display .= '<td>Pending</td>';

			if($mrow['matchreport'] != '')
				$display .= '<td><a href="'.$mrow['matchreport'].'" target="_blank" rel="external">Report</a></td>';
			else
				$display .= '<td></td>';
		$display .= '</tr>';
	}
	$display .= '</tbody></table>';

	return $display;
}

add_action('wp_enqueue_scripts', 'frp_enqueue_scripts');
function frp_enqueue_scripts($hook_suffix) {
    wp_enqueue_style('frp', plugins_url('css/default.css', __FILE__));
}

function frp_formations($atts, $content = null) {
    global $wpdb;

    extract(shortcode_atts(array(
		'id' => '1'
	), $atts));

	$images_path = FRP_PLUGIN_URL.'/images/';

    $mrow = $wpdb->get_row("SELECT * FROM frp_formation WHERE `formationID` = '" . $id . "' LIMIT 1", ARRAY_A);

    $player1 = explode(',', stripslashes($mrow['player1']));
	$player2 = explode(',', stripslashes($mrow['player2']));
	$player3 = explode(',', stripslashes($mrow['player3']));
	$player4 = explode(',', stripslashes($mrow['player4']));
	$player5 = explode(',', stripslashes($mrow['player5']));
	$player6 = explode(',', stripslashes($mrow['player6']));
	$player7 = explode(',', stripslashes($mrow['player7']));
	$player8 = explode(',', stripslashes($mrow['player8']));
	$player9 = explode(',', stripslashes($mrow['player9']));
	$player10 = explode(',', stripslashes($mrow['player10']));
	$player11 = explode(',', stripslashes($mrow['player11']));
	$player12 = explode(',', stripslashes($mrow['player12']));
	$player13 = explode(',', stripslashes($mrow['player13']));
	$player14 = explode(',', stripslashes($mrow['player14']));
	$player15 = explode(',', stripslashes($mrow['player15']));

	if($player14[1] != '') // 15-a-side
		return '<table class="frp-formation">
				<tbody>
					<tr>
						<td class="table-cell-wide" colspan="5"><img src="'.$images_path.'jersey-1.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-wide" colspan="5">'.$player1[1].'</td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-2.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-3.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-4.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player2[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player3[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player4[1].'</td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-5.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-6.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-7.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player5[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player6[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player7[1].'</td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-8.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-9.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player8[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player9[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-10.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-11.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-12.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player10[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player11[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player12[1].'</td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-13.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-14.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-15.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player13[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player14[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player15[1].'</td>
					</tr>
					<tr>
						<td class="table-cell-wide" colspan="5"><b>Subs:</b> '.$mrow['subs'].'</td>
					</tr>
				</tbody>
			</table>';
	if(($player14[1] == '') && ($player15[1] == '') && ($player13[1] != '')) // 13-a-side
		return '<table class="frp-formation">
				<tbody>
					<tr>
						<td class="table-cell-narrow" colspan="5"><img src="'.$images_path.'jersey-1.png" alt=""></td>
					</tr>
					<tr>
						<th class="table-cell-wide" colspan="5">'.$player1[1].'</th>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-2.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-3.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player2[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player3[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-4.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-5.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-6.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player4[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player5[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player6[1].'</td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-7.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-8.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player7[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player8[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-9.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-10.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-11.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player9[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player10[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player11[1].'</td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-12.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-13.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player12[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player13[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-wide" colspan="5"><b>Subs:</b> '.$mrow['subs'].'</td>
					</tr>
				</tbody>
			</table>';
	if($player13[1] == '') // 12-a-side
		return '<table class="frp-formation">
				<tbody>
					<tr>
						<td class="table-cell-narrow" colspan="5"><img src="'.$images_path.'jersey-1.png" alt=""></td>
					</tr>
					<tr>
						<th class="table-cell-wide" colspan="5">'.$player1[1].'</th>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-2.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-3.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player2[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player3[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-4.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-5.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-6.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player4[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player5[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player6[1].'</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-7.png" alt=""></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="table-cell-narrow">'.$player7[1].'</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-8.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-9.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-10.png" alt=""></td>
					</tr>
					<tr>
						<td class="table-cell-narrow">'.$player8[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player9[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player10[1].'</td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-11.png" alt=""></td>
						<td></td>
						<td class="table-cell-narrow"><img src="'.$images_path.'jersey-12.png" alt=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="table-cell-narrow">'.$player11[1].'</td>
						<td></td>
						<td class="table-cell-narrow">'.$player12[1].'</td>
						<td></td>
					</tr>
					<tr>
						<td class="table-cell-wide" colspan="5"><b>Subs:</b> '.$mrow['subs'].'</td>
					</tr>
				</tbody>
			</table>';
}

function frp_archive($atts, $content = null) {
    global $wpdb;

    extract(shortcode_atts(array(
		'year' => '',
		'competition' => ''
	), $atts));

	$images_path = FRP_PLUGIN_URL.'/images/';

	$display = '
		<form action="" name="filter_form" method="post">
			<p>
				Filter archive: 
				<select name="filter_year">
					<option value="">By year...</option>';

                    $results = $wpdb->get_results("SELECT DISTINCT competitionyear FROM frp_match ORDER BY competitionyear DESC $limit", ARRAY_A);
                    foreach($results as $row) {
						$display .= '<option value="'.$row['competitionyear'].'">'.$row['competitionyear'].'</option>';
					}

				$display .= '</select> 

				<select name="filter_competition" style="width: 120px;">
					<option value="">By competition...</option>';
                    $results = $wpdb->get_results("SELECT * FROM frp_competition ORDER BY competitionlongname", ARRAY_A);
                    foreach($results as $row) {
						$display .= '<option value="'.$row['competitionID'].'">'.$row['competitionlongname'].'</option>';
					}
				$display .= '</select> ';

				$display .= '<select name="filter_team">
					<option value="">By opposition...</option>';
                    $results = $wpdb->get_results("SELECT * FROM frp_team ORDER BY teamname", ARRAY_A);
                    foreach($results as $row) {
						$display .= '<option value="'.$row['teamID'].'">'.$row['teamname'].'</option>';
					}
				$display .= '</select> ';

				$display .= '<button onchange="document.forms.filter_form.submit();" class="button-secondary">Filter</button>
			</p>
		</form>';

	$filter1 = '';
	$filter2 = '';
	$filter3 = '';
	if(isset($_POST['filter_year']))
		if(strlen($_POST['filter_year']) > 0)
			$filter1 = "competitionyear='".$_POST['filter_year']."' AND ";
	if(isset($_POST['filter_competition']) != '')
		if(strlen($_POST['filter_competition']) > 0)
			$filter2 = "competition='".$_POST['filter_competition']."' AND ";
	if(isset($_POST['filter_team']) != '')
		if(strlen($_POST['filter_team']) > 0)
			$filter3 = "team2='".$_POST['filter_team']."' AND ";

	// BEGIN PAGINATION HEAD
	$pr = get_option('frp_rpp'); // rows per page
	// END PAGINATION HEAD

    $display .= '<script>
    jQuery(document).ready(function(){
        jQuery("table.frp").each(function() {
            var currentPage = 0;
            var numPerPage = ' . $pr . ';
            var $table = jQuery(this);
            $table.bind("repaginate", function() {
                $table.find("tbody tr").hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
            });
            $table.trigger("repaginate");
            var numRows = $table.find("tbody tr").length;
            var numPages = Math.ceil(numRows / numPerPage);
            var $pager = jQuery("<div class=\"frppager\"></div>");
            for(var page = 0; page < numPages; page++) {
                jQuery("<span class=\"page-number\"></span>").text(page + 1).bind("click", {
                    newPage: page
                }, function(event) {
                    currentPage = event.data["newPage"];
                    $table.trigger("repaginate");
                    jQuery(this).addClass("active").siblings().removeClass("active");
                }).appendTo($pager).addClass("clickable");
            }
            $pager.insertAfter($table).find("span.page-number:first").addClass("active");
        });
    });
    </script>';

    $results = $wpdb->get_results("SELECT * FROM `frp_match` WHERE $filter1 $filter2 $filter3 1=1 ORDER BY grade ASC, matchdate DESC", ARRAY_A);

	$display .= '
	<table width="100%" class="frp">
		<thead>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">Venue</th>
				<th scope="col">Competition (Stage)</th>
				<th scope="col">Versus</th>
				<th scope="col">Score</th>
				<th scope="col">Report</th>
			</tr>
		</thead>';

		foreach($results as $mrow) {
			$display .= '<tr>';
				$display .= '<td>'.date('d/m/Y', strtotime($mrow['matchdate']));

				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT venuename FROM frp_venue WHERE `venueID` = '" . $mrow['matchvenue'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['venuename'];
				$display .= '</td>';
				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT competitionshortname FROM frp_competition WHERE `competitionID` = '" . $mrow['competition'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['competitionshortname'];

                    $rowcode = $wpdb->get_row("SELECT competitionstage FROM frp_competitionstage WHERE `competitionstageID` = '" . $mrow['competitionstage'] . "' LIMIT 1", ARRAY_A);
					if(strlen($rowcode['competitionstage']) > 0)
						$display .= ' ('.$rowcode['competitionstage'].')';
				$display .= '</td>';
				$display .= '<td>';
                    $rowcode = $wpdb->get_row("SELECT teamname FROM frp_team WHERE `teamID` = '" . $mrow['team2'] . "' LIMIT 1", ARRAY_A);
					$display .= $rowcode['teamname'];
				$display .= '</td>';

				if($mrow['team1points'] != '')
					$display .= '<td>'.$mrow['team1goals'].'-'.str_pad((int) $mrow['team1points'],2,'0',STR_PAD_LEFT).'<small> to </small>'.$mrow['team2goals'].'-'.str_pad((int) $mrow['team2points'],2,'0',STR_PAD_LEFT).'</td>';
				else if($mrow['matchwalkover'] == '1')
					$display .= '<td>N w/o</td>';
				else if($mrow['matchwalkover'] != '1' && $mrow['matchwalkover'] != '0')
					$display .= '<td>O w/o</td>';
				else if($mrow['matchwalkover'] == '0')
					$display .= '<td>Pending</td>';

				if($mrow['matchreport'] != '')
					$display .= '<td><a href="'.$mrow['matchreport'].'" target="_blank" rel="external">Report</a></td>';
		$display .= '</tr>';
	}
	$display .= '</table>';

	return $display;
}

add_shortcode('frp-fixtures', 'frp_fixtures');
add_shortcode('frp-resultsyear', 'frp_resultsyear');
add_shortcode('frp-formations', 'frp_formations');
add_shortcode('frp-archive', 'frp_archive');

function frp_dashboard_widget() {
    echo '<p>Your <strong>Fixtures and Results</strong> plugin is active.</p>';
	echo '<p>Customize it via the <a href="admin.php?page=frp">F&amp;R administration section</a> or add <a href="widgets.php">widgets</a>.</p>';
	echo '<p><small>Plugin version: '.FRP_VERSION.'</small></p>';
}
function frp_add_dashboard_widget() {
    wp_add_dashboard_widget('frp-custom-widget', 'Fixtures and Results', 'frp_dashboard_widget');
}


add_action('wp_dashboard_setup', 'frp_add_dashboard_widget');
add_action('widgets_init', 'frp_load_widgets');

// Register our widget.
function frp_load_widgets() {
	register_widget('FRP_Widget_Latest_Result');
	register_widget('FRP_Widget_Next_Fixture');
}

include 'widgets/latest-result.php';
include 'widgets/next-fixture.php';
include 'includes/install.php';
?>

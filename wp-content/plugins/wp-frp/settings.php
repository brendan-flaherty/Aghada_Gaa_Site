<?php
global $wpdb;

add_option('frp_team', '', '', 'no');
add_option('frp_rpp', '', '', 'no');

$data_field_name_1 = 'frp_team';
$data_field_name_2 = 'frp_rpp';

// read in existing option value from database
$option_value_data_1 = get_option('frp_team');
$option_value_data_2 = get_option('frp_rpp');

// See if the user has posted us some information // if yes, this hidden field will be set to 'Y'
if(isset($_POST['set_options'])) {
	$option_value_data_1 = $_POST[$data_field_name_1];
	$option_value_data_2 = $_POST[$data_field_name_2];

	update_option('frp_team', $option_value_data_1);
	update_option('frp_rpp', $option_value_data_2);
	?>
	<div class="updated"><p>Settings saved.</p></div>
	<?php
}
if(isset($_POST['set_maintenance'])) {
    $wpdb->query("ALTER IGNORE TABLE `frp_player` ADD UNIQUE (`playername`)");
    echo '<div class="updated"><p>Duplicate players removed.</p></div>';
}
if(isset($_POST['remove_empty_homepage'])) {
    $wpdb->query("UPDATE frp_team SET teamhomepage = '' WHERE teamhomepage = 'http://'");
    $wpdb->query("UPDATE frp_team SET teamhomepage = '' WHERE teamhomepage = 'https://'");
    $wpdb->query("UPDATE frp_venue SET venuelocation = '' WHERE venuelocation = 'http://'");
    $wpdb->query("UPDATE frp_venue SET venuelocation = '' WHERE venuelocation = 'https://'");
    echo '<div class="updated"><p>Empty homepage values removed.</p></div>';
}
if(isset($_POST['set_optimize'])) {
    $wpdb->query("OPTIMIZE TABLE `frp_code`, `frp_competition`, `frp_competitionstage`, `frp_formation`, `frp_grade`, `frp_match`, `frp_player`, `frp_team`, `frp_venue`");
    echo '<div class="updated"><p>Tables optimized.</p></div>';
}
?>

<div class="wrap">
    <h3>General options</h3>
    <form name="form1" method="post" action="">
        <p>
            <input type="text" class="regular-text" name="<?php echo $data_field_name_1; ?>" id="<?php echo $data_field_name_1; ?>" value="<?php echo $option_value_data_1; ?>"> 
            <label for="<?php echo $data_field_name_1; ?>">Home team name or club name</label>
            <br><small>The name of the home team or club. Used for widgets and matches tables.</small>
        </p>
        <p>
            <input type="number" name="<?php echo $data_field_name_2; ?>" id="<?php echo $data_field_name_2; ?>" value="<?php echo $option_value_data_2; ?>" min="5" max="999"> 
            <label for="<?php echo $data_field_name_2; ?>">Results per page (will show a pagination bar)</label>
        </p>
        <p><input type="submit" name="set_options" class="button button-primary" value="Save Changes"></p>

        <hr>
        <h2>Maintenance and migration options</h2>
        <p>Use the buttons below to clean up your plugin database after 1.x - 2.x update.</p>
        <p>
            <input type="submit" name="set_maintenance" class="button button-secondary" value="Clean up duplicate players">
            <input type="submit" name="remove_empty_homepage" class="button button-secondary" value="Clean up empty homepage values (http(s)://)">
            <input type="submit" name="set_optimize" class="button button-secondary" value="Optimize tables">
        </p>
    </form>
</div>

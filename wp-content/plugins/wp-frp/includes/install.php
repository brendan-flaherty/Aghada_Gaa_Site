<?php
function frp_install() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    if($wpdb->get_var("SHOW TABLES LIKE 'frp_code'") != 'frp_code') {
		$sql = "CREATE TABLE IF NOT EXISTS `frp_code` (
			`codeID` int(11) NOT NULL auto_increment,
			`codename` text collate latin1_general_ci NOT NULL,
			KEY `codeID` (`codeID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$insert = "INSERT INTO `frp_code` (`codeID`, `codename`) VALUES 
			(1, 'Football'),
			(2, 'Hurling'),
			(3, 'Camogie'),
			(4, 'Handball');";
		$results = $wpdb->query($insert);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_competition` (
			`competitionID` int(11) NOT NULL auto_increment,
			`competitionlongname` text collate latin1_general_ci NOT NULL,
			`competitionshortname` text collate latin1_general_ci NOT NULL,
			`competitiongrade` int(11) NOT NULL COMMENT 'gradeID',
			`competitioncode` int(11) NOT NULL COMMENT 'codeID',
			`competitiongendergroup` text collate latin1_general_ci NOT NULL,
			KEY `competitionID` (`competitionID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_competitionstage` (
			`competitionstageID` int(11) NOT NULL auto_increment,
			`competitionstage` text collate latin1_general_ci NOT NULL,
			KEY `competitionstageID` (`competitionstageID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_grade` (
			`gradeID` int(11) NOT NULL auto_increment,
			`gradename` text collate latin1_general_ci NOT NULL,
			KEY `gradeID` (`gradeID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$insert = "INSERT INTO `frp_grade` (`gradeID`, `gradename`) VALUES 
			(1, 'Senior'),
			(2, 'Intermediate - Premier'),
			(3, 'Intermediate'),
			(4, 'Junior - A'),
			(5, 'Junior - B'),
			(6, 'Junior - C'),
			(7, 'Junior - Novice'),
			(8, 'Under 21 - A'),
			(9, 'Under 21 - B'),
			(10, 'Under 21 - C'),
			(11, 'Minor - A'),
			(12, 'Minor - B'),
			(13, 'Minor - C'),
			(14, 'Under 16 - A'),
			(15, 'Under 16 - B'),
			(16, 'Under 16 - C'),
			(17, 'Under 14 - A'),
			(18, 'Under 14 - B'),
			(19, 'Under 14 - C'),
			(20, 'Under 12 - A'),
			(21, 'Under 12 - B'),
			(22, 'Under 12 - C'),
			(23, 'Under 10 - A'),
			(24, 'Under 10 - B'),
			(25, 'Under 10 - C');";
		$results = $wpdb->query($insert);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_match` (
			`matchID` int(11) NOT NULL auto_increment,
			`code` int(11) NOT NULL COMMENT 'codeID',
			`grade` int(11) NOT NULL COMMENT 'gradeID',
			`competition` int(11) NOT NULL COMMENT 'competitionID',
			`competitionstage` int(11) NOT NULL COMMENT 'competitionstageID',
			`competitionyear` text collate latin1_general_ci NOT NULL,
			`team1` int(11) NOT NULL COMMENT 'teamID',
			`team2` int(11) NOT NULL COMMENT 'teamID',
			`matchdate` date NOT NULL,
			`matchtime` time NOT NULL,
			`matchvenue` int(11) NOT NULL COMMENT 'venueID',
			`matchreplay` text collate latin1_general_ci NOT NULL,
			`team1goals` int(11) NOT NULL,
			`team1points` int(11) NOT NULL,
			`team1overallpoints` int(11) NOT NULL,
			`team2goals` int(11) NOT NULL,
			`team2points` int(11) NOT NULL,
			`team2overallpoints` int(11) NOT NULL,
			`matchwalkover` int(11) NOT NULL COMMENT 'teamID',
			`extratimeplayed` text collate latin1_general_ci NOT NULL,
			`matchreport` text collate latin1_general_ci NOT NULL,
			`matchaudiovideo` text collate latin1_general_ci NOT NULL,
			`matchphotos` text collate latin1_general_ci NOT NULL,
			`matchtype` text collate latin1_general_ci NOT NULL,
			`teamformation` int(11) NOT NULL COMMENT 'formationID',
			KEY `matchID` (`matchID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_player` (
			`playerID` int(11) NOT NULL auto_increment,
			`playername` varchar(255) collate latin1_general_ci NOT NULL,
            UNIQUE KEY `playername` (`playername`),
			KEY `playerID` (`playerID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
		dbDelta($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `frp_team` (
			`teamID` int(11) NOT NULL auto_increment,
			`teamname` text collate latin1_general_ci NOT NULL,
			`teamvenue` text collate latin1_general_ci NOT NULL COMMENT 'venueID',
			`teamhomepage` text collate latin1_general_ci NOT NULL,
			KEY `teamID` (`teamID`)
		) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT = 1;";
        dbDelta($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `frp_venue` (
            `venueID` int(11) NOT NULL auto_increment,
            `venuename` text collate latin1_general_ci NOT NULL,
            `venuelocation` text collate latin1_general_ci NOT NULL,
            KEY `venueID` (`venueID`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;";
        dbDelta($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `frp_formation` (
            `formationID` int(11) NOT NULL auto_increment,
            `player1` text collate latin1_general_ci NOT NULL ,
            `player2` text collate latin1_general_ci NOT NULL ,
            `player3` text collate latin1_general_ci NOT NULL ,
            `player4` text collate latin1_general_ci NOT NULL ,
            `player5` text collate latin1_general_ci NOT NULL ,
            `player6` text collate latin1_general_ci NOT NULL ,
            `player7` text collate latin1_general_ci NOT NULL ,
            `player8` text collate latin1_general_ci NOT NULL ,
            `player9` text collate latin1_general_ci NOT NULL ,
            `player10` text collate latin1_general_ci NOT NULL ,
            `player11` text collate latin1_general_ci NOT NULL ,
            `player12` text collate latin1_general_ci NOT NULL ,
            `player13` text collate latin1_general_ci NOT NULL ,
            `player14` text collate latin1_general_ci NOT NULL ,
            `player15` text collate latin1_general_ci NOT NULL ,
            `subs` TEXT NOT NULL ,
            KEY `formationID` (`formationID`)
        ) ENGINE = InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;";
        dbDelta($sql);
    }

    if(function_exists('maybe_convert_table_to_utf8mb4')) {
        maybe_convert_table_to_utf8mb4('frp_code');
        maybe_convert_table_to_utf8mb4('frp_competition');
        maybe_convert_table_to_utf8mb4('frp_competitionstage');
        maybe_convert_table_to_utf8mb4('frp_grade');
        maybe_convert_table_to_utf8mb4('frp_match');
        maybe_convert_table_to_utf8mb4('frp_player');
        maybe_convert_table_to_utf8mb4('frp_team');
        maybe_convert_table_to_utf8mb4('frp_venue');
        maybe_convert_table_to_utf8mb4('frp_formation');
    }
}
?>

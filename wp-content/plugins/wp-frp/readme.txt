=== Fixtures and Results ===
Plugin Name: Fixtures and Results
Contributors: Ciprian Popescu
Tags: fixtures, results, matches, teams, venues, players, formations, reports
Requires at least: 4.4
Tested up to: 4.5.2
Stable tag: 3.1.1

== Description ==
This WordPress plugin records, displays and searches football (soccer), hurling, camogie and handball matches. It also allows for easy management of competitions, formations and venues.

It features an auto-updatable player database and advanced widgets.

== Installation ==
1. Upload `wp-frp` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==
= 3.1.1 =
* FIX: Fixed deprecated widget constructors
* UPDATE: Updated WordPress version requirement

= 3.1.0 =
* UPDATE: Removed time picker (Pickled) and replaced it with HTML5 datalist
* UPDATE: Updated date picker script dependency

= 3.0.0 =
* FIX: Fixed shortcodes for WordPress 4.4.0 (note that your shortcodes need to be updated and all spaces replaced with a dash "-")
* FIX: Fixed WordPress multisite compatibility
* FIX: Fixed asset editing URLs and form actions
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated plugin name
* UPDATE: Updated admin styles (+ UI tweaks)
* UPDATE: Updated database schema

= 2.0.0 =
* FEATURE: Added maintenance/clean up buttons (duplicate players, empty URLs)
* FEATURE: Added missing notification styles
* FEATURE: Added native WordPress icons (Dashicons)
* FEATURE: Added dynamic pagination for fixtures and results
* IMPROVEMENT: Changed Twitter button to use HTTPS protocol and the new /intent/ URL
* IMPROVEMENT: Changed all backend screens to use native WordPress styles
* IMPROVEMENT: Changed input fields to use HTML5 types (url, number)
* IMPROVEMENT: Removed deprecated form validation and replaced it with HTML5 native validation
* IMPROVEMENT: Minified CSS styles
* FIX: Players are now unique, no more duplicate player names
* FIX: Cleaned up old editor button JS
* FIX: Removed mysql_ references

= 1.3.5.2 =
* Fixed a Javascript issue (formation editing was broken)
* Minor UI tweaks

= 1.3.5.1 =
* Fixed a pagination issue (name of the class was too common and conflicted with other plugins)
* Fixed button style in WordPres 3.5

= 1.3.5 =
* Fixed the Options page (conflicting with WordPress 3.5 naming conventions)
* Removed the "blank page" issue by removing the error reporting option and the hardcoded path
* Added shortcodes dropdown in post/page editor

= 1.3.4.1 =
* Added pagination to archive results
* Small source code clean-up

= 1.3.4 =
* Added TBD result for empty or zero-value results
* Added formation name option field
* Added pagination for latest results (You need to set this up at first use)
* Added special options page
* Fixed (again) time/date pickers - Google Chrome and Mozilla Firefox seem to behave differently
* General style and script updates

= 1.3.3 =
* Fixed styles for compatibility with 3.3
* Fixed time picker style

= 1.3.2 =
* Added an options page for the home team / club name
* Added a Tweet this button to matches table
* Updated author links
* Fixed WordPress 3.2 compatibility
* Fixed a jQuery plugin to work with the latest version, 1.6.x

= 1.3.1 =
* Added only existing years for match filtering
* Added only existing years for archive filtering
* Added pagination
* Added a time picker feature
* Layouts (archives, results, fixtures) are now consistent with each other
* Removed a useless HTML file

= 1.3 =
* Added icons to titles
* Added wrap style
* Added the players panel (editing/deleting)
* Changed player numbers to read-only fields as they don't need to be modified
* Changed formations table to have tee number bolded gray inside parentheses (looks nicer)
* Changed several database field types from INT to TEXT (no more stray zeroes)
* Fixed an ugly bug in Chrome and Internet Explorer where formation players were not auto-populated due to a missing "value" field
* Fixed the empty REPORT link leading to home page
* Fixed future matches (fixtures) appearing in the results table
* Removed an extra validation check causing quotes (') to be displayed as escaped quotes (\')

= 1.2.9 =
* Changed all jerseys with transparent PNGs (now match all backgrounds)
* Changed results table to a more compact version
* Fixed a link in the sidebar
* Fixed a bug in formation administration screen
* Fixed a bug in matches administration screen (adding/editing)
* Fixed a shortcode being wrongly documented
* Fixed a jQuery function using $ selector
* Added match filtering
* Added new styles for separators and horizontal rules
* Added 12 a-side formations
* Added URL for teams
* Added optional competition filter on posts and pages
* Added jersey Photoshop template file
* All dropdowns are now sorted alphabetically
* All year dropdowns now go back to 1900

= 1.2.6b =
* Merged all CSS files (2)
* Added form validation for certain required fields

= 1.2.6a =
* Fixed CSS style inclusion for non-root Wordpress installations

= 1.2.6 =
* Fixed a bunch of errors and warnings
* Fixed the changelog
* Source code cleaned up and formatted
* Increased security (directories are no longer accessible for browsing)
* Added a documentation folder with an in-depth readme file
* Added a new shortcode (displays results by year)

= 1.2.5 =
* Added widget options (latest fixture from any/specific category)
* Added widget options (next fixture from any/specific category)
* Added jdPicker contextual help
* Added players database (select formation users from database or manually enter them)
* Source code clean up just a bit
* 100% WordPress 3.0.1 compatibility

= 1.2 =
* Added developer texts and jdpicker help
* Added a bit more contextual help

= 1.1 =
* 100% WordPress 3.0 compatibility
* Added confirmation on item deletion
* Added year dropdown
* Added date picker for date fields
* Changed 'Venue Location' to 'Venue Website' for clarification
* Changed database details to obey wp-config.php rules
* Changed 'TRUE' to 'Yes' and 'FALSE' to 'No'
* Fixed a wrong variable - now formations are correctly displayed on Matches page
* Fixed a wrong shortcode
* Removed some redundant code

= 1.0.1 =
* Several fixes and improvements
* Added two templates for team formations

= 1.0 =
* First release

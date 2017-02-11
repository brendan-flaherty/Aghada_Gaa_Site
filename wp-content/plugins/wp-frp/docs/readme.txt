Fixtures and Results Plugin Readme
(docs/readme.txt)

Description
===========
This Wordpress plugin stores competitions, matches, formations and players in a database 
for easy archiving and display of both retroactive and upcoming fixtures. The plugin is setup 
with preexisting codes (football, hurling, camogie, handball) and grades. Some of the sport codes 
are country-specific.

How to use
==========
The plugin uses an advanced administration section, having its own top-level menu (FRP) inside 
Wordpress dashboard. Information is interlinked between sections, such as teams, formations, venues, 
competitions and matches.

The plugin also offers 2 widgets, one showing the latest result (either generally, or manually filtered 
by the user) and the other showing the upcoming fixture (also generally, or manually filtered). Widgets 
can extract information from ALL matches or from SPECIFIC codes or grades.

A widget is a draggable box which displays Latest Result and Next Fixture details. 
In order to display the latest result based on code and grade, go to the Widgets section and drag 
FRP Latest Result widget to your sidebar. Add a custom title, select a code and a grade from the 
suggestions box and save the widget.

In order to display the next fixture, go to the Widgets section and drag FRP Next Fixture widget 
to your sidebar. Add the required details and save the widget.

All database records can be fully edited or deleted.

Shortcodes
==========
A shortcode is a shortcut for a complex function. Use the following shortcodes to add information 
to WordPress posts or pages:

[frp-formations id="1"] - Displays a team formation using of the 2 possible templates (13-a-side and 15-a-side). 
Replace 1 with the desired team formation ID from the Formations page inside the plugin administration area. 
Use this shortcode in a post or page.

[frp-fixtures] - Displays all upcoming/pending fixtures. Use this shortcode in a post or page.

[frp-resultsyear year="2010"] - Displays all results from a specific year. Replace 2010 with the desired year.

[frp-resultsyear year="2010" competition="10"] - Use the competition ID from Competition (ID) (Stage) column
in Matches section to filter results on posts and pages based on optional competition ID.

[frp-archive] - Displays a filterable matches archive, just like the one on Matches section.

How to install
==============
This plugin features 9 new tables, all prefixed with frp_ in order not to mess with the existing 
Wordpress installation. Just activate the plugin and it ready and populated with preexisting data.

You are now ready to use the Fixtures and Results plugin.

The plugin database tables and information will not be deleted or overwritten upon upgrade or deactivation.

How to upgrade
==============
The plugin features an automated installation routine, and upgrade is as simple as overwriting the new files. 
Future versions may contain specific upgrade information in the /docs/ folder. Make sure you check out this 
directory before upgrade.

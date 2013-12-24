=== Plugin Name ===
Contributors: mirkolofio <mirkolofio@gmail.com>, jeffsayre
Donate link: http://www.mircobabini.com/wordpress/hook-sniffer-wordpress-plugin/
Tags: wordpress, wordpress mu, buddypress, developer plugin, action hooks, filter hooks
Requires at least: WP 3.0
Tested up to: WP 3.7.1
Stable tag: 0.16

The WordPress Hook Sniffer plugin is a tool for plugin developers that helps determine the sequence in which action and filter functions are fired.

== Description ==

The WordPress Hook Sniffer plugin is a tool for plugin developers that helps determine the sequence in which action and filter functions are fired. It allows you to peer into the inner workings of the WordPress Plugin API. You can configure what is outputted and to where the output is sent (screen or text file).

Since it's not supported anymore from the original author, it's now mantained by [Mirco Babini](http://www.mircobabini.com/), **Wordpress Consultant, Web Developer and Data Lover**.

<h4>Output Options</h4>
You can choose to output any or all of the six different sets of hook data that WordPress Hook Sniffer collects. Each dataset provides a unique insight into the underlying working of WordPress' hooks. The currently available datasets are:

<h5>Added Functions:</h5> a listing of, in the order in which they were encountered during code execution, all add_action calls and add_filter calls

<h5>Removed Functions:</h5> a listing of, in the order in which they were encountered during code execution, all remove_action calls and remove_filter calls

<h5>Action and Filter Function Array:</h5> output the array that holds all of the added action and filter functions used by the do_action and apply_filters functions

<h5>Action Event Firing Order:</h5> a sequential listing of all the do_action events that need to be processed

<h5>Action Event Firing Sequence:</h5> a sequential listing of do_action events and their corresponding fired action function(s)

<h5>Filter Event Firing Sequence:</h5> a sequential listing of apply_filters events with their corresponding fired filter  function(s)


<h4>WARNING:</h4> This plugin is to be used only in a development sandbox and not in a production environment.

<h4>Disclaimer</h4>

This plugin is provided "as is." It is free software licensed under the terms of the [GNU General Public License 3.0 (GPL)] (http://www.gnu.org/licenses/gpl.html "GNU General Public License 3.0"). It is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. I am not liable for any damages or losses. Your only recourse is to stop using this plugin.

== Screenshots ==

1. This is a view of the WordPress Hook Sniffer plugin's administration settings screen. Notice the six output options that can be selected in the Output Options section.

2. Here is some sample output showing the Action Event Firing Order.

3. Here is some sample output showing the Action Event Firing Sequence.

== Installation ==

<h4>WARNING:</h4> This plugin is to be used only in a development sandbox and not in a production environment. It is intended solely for use by plugin developers to help determine the sequence in which action and filter functions are fired. Use at your own risk. As this plugin should not be installed on an active WordPress-based site (a production site), no support for broken sites will be given. You have been warned!

<h4>Installation Instructions:</h4>

IMPORTANT NOTE: As of version 0.14, the installation instructions have changed. It is no longer necessary to manually install the modified plugin.php file. WordPress Hook Sniffer automatically handles the installation of that file upon activation and then uninstalls it, replacing it with the original, stock plugin.php file upon deactivation.

1. Make sure WordPress is properly installed and working.

2. Move the wordpress-hook-sniffer directory into /wp-contents/plugins/.

3. If upgrading from a previous version (older than v0.12), the plugin's directory name has been renamed from "wp-hook-sniffer" to "wordpress-hook-sniffer" (See last two notes in changelog for v0.12). Therefore, you should deactivate the plugin, delete the old version "wp-hook-sniffer" and then install and activate the new one.

4. Activate the plugin by visiting the plugins menu and clicking the "activate" link.

5. WP Hook Sniffer is disabled by default. You must first enable it by visiting the backend as Site Admin and navigating to "Settings > WP Hook Sniffer".

6. Additional steps, but not mandatory: You will more than likely want to increase the setting for "precision" in your php.ini file. This will allow for the time-executed stamp to display more than the default 2 significant figures. Read the Usage Notes section in the how-to-use article linked below to learn more.

Visit my website for [detailed instructions on how to use the WordPress Hook Sniffer plugin](http://jeffsayre.com/2010/04/29/introducing-wordpress-hook-sniffer-a-developer-plugin/ "How to use the WordPress Hook Sniffer plugin").

== Frequently Asked Questions ==

= Why can't I run this on my production site? =

As mentioned in the Installation section of this readme file, this plugin should not be installed on an active WordPress-based site (a production site). There will be `no support for broken production sites`. You have been warned! Of course, you can technically install this plugin on your production site if you wish to provide your site's users with a screen full of text output that will confuse them! 

= I don't see anything? Where's the output? =

If you've selected `To Screen` in the Output Location settings section, then look for the output to begin just below your theme's footer. If you've selected the `To File` output option, then look for the text file "wp-hook-sniff.txt" in the "hook-sniff-report" folder of the wordpress-hook-sniffer directory.

= I don't understand what this plugin does? =

To appreciate the value of this plugin, you must first have an understanding of [WordPress action hooks and filter hooks](http://codex.wordpress.org/Plugin_API "WordPress Plugin API"). Also, experience in tying into hooks and modifying function output via action functions and filter functions is desirable. Once you have a solid working knowledge of WordPress' Plugin API, you should then read my article, [WordPress Hooks, Barbs, and Snags](http://jeffsayre.com/2010/04/29/wordpress-hooks-barbs-and-snags/ "WordPress Hooks, Barbs, and Snags").

= Where do I report issues or provide suggestions on the WordPress Hook Sniffer plugin? =

You are welcome to report issues or provide suggestions by adding a comment to [this blog post](http://jeffsayre.com/2010/04/29/introducing-wordpress-hook-sniffer-a-developer-plugin/ "Introducing WordPress Hook Sniffer: a Developer Plugin"). However, you are encouraged to participate in the [plugin's official support forum](http://buddypress.org/community/groups/wordpress-hook-sniffer/forum/ "WordPress Hook Sniffer official support forum"), hosted on BuddyPress.org.

== Other Notes ==

* license.txt - contains the GNU General Public License 3.0 (GPL) license
* known-bugs.txt - contains a listing of all currently-known bugs

== Changelog ==

= 0.16 =
* July,21 2013
* Fixes an issue in the modified plugin.php file where if the $the_['function'] variable is a Closure, a fatal error occurs.

= 0.15 =
* December,31 2010
* Fixes an issue in the modified plugin.php file where if the $time_fired variable isn't set, a non-critical error occurs (logged in PHP error log file). Props [Paul Gibbs](http://byotos.com/ "Paul Gibbs")

= 0.14 =
* July 28, 2010
* Fixed a crucial bug with the modified plugin.php file that resulted in some important WordPress action hooks not firing
* Bumped required WordPress version to 3.0 as there are important differences between the /wp-includes/plugin.php files of WP 2.9.2 and WP 3.0
* Added the constant WP_HOOK_SNIFF_PLUGIN_API_VER to use as a check to make sure that the proper version of the modified plugin.php is installed
* Added a WordPress version check to make sure that WP Hook Sniffer is installed on the proper version of WordPress, if not plugin will install but not run. A warning message will be displayed in the Plugins directory
* Added a CSS file to improve proper code separation
* Renamed CSS selectors to make them unique to plugin
* Added functions that will automatically install the modified plugin.php file upon plugin activation and then reinstall the original, stock WP version of the /wp-includes/plugin.php file upon plugin deactivation.
* Generated a new .pot file as new translatable strings were added to the plugin

= 0.13 =
* July 8, 2010
* Fixed an issue when using WP Hook Sniffer with WP 3.0. The function apply_filters_ref_array() was added to plugin.php in version WP 3.0. This function is now included in the distributed, modified plugin.php file as well.
* Added action and filter hook sniffing functionality to the functions apply_filters_ref_array() and do_action_ref_array()

= 0.12 =
* May 3, 2010
* Added wp_hook_sniff_init_event action hook to allow functions that are dependent on the WP Hook Sniffer to hook into it in a safe manner
* Added a function to load the language file for Internationalization support
* Added a .pot file (located in the /languages directory) containing the plugin text that can be translated
* Corrected my boneheaded mistake where I submitted the plugin with the wrong name resulting in the actual plugin residing in a directory in the download file.
* Per above comment, the official plugin directory name has been changed to "wordpress-hook-sniffer" from "wp-hook-sniffer".

= 0.11 =
* April 30, 2010
* Added link to the WordPress Hook Sniffer official support forum hosted on BuddyPress.org

= 0.1 =
* April 29, 2010
* Initial release

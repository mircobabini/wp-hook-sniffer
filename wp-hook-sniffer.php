<?php
/*
Plugin Name: WordPress Hook Sniffer
Plugin URI: http://jeffsayre.com/2010/04/29/introducing-wordpress-hook-sniffer-a-developer-plugin/
Description: This is a developer's tool that sniffs out the firing sequence of WordPress action and filter hooks. DO NOT USE in a production environment.
Version: 0.15
Revision Date: December,31 2010
Requires at least: WP 3.0
Tested up to: WP 3.0.4
License: GNU General Public License 3.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Jeff Sayre
Author URI: http://jeffsayre.com/
Site Wide Only: true

Copyright 2010 Jeff Sayre

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3.0 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/**
 * wp_hook_sniff_init()
 *
 * Initialize basic constants and make sure WordPress
 * is installed and activated. If true, then allow for 
 * plugin to finish loading.
 *
 * @since 0.1
 * @version 1.1 added constants WP_HOOK_SNIFF_PLUGIN_API_VER_CURRENT, WP_HOOK_SNIFF_MIN_WP_VER, 
 * and WP_HOOK_PLUGIN_LOADER
 */
function wp_hook_sniff_init() {
	
	/* Check whether the Modified WordPress Plugin API is installed */
	if( !function_exists( 'wp_hook_sniff_plugin_api' ) ) {
		define( 'WP_HOOK_SNIFF_API', False );
	}
	
	/* Define the component's current version */
	define( 'WP_HOOK_PLUGIN_VERSION', 0.15 );
	
	/* Define the current version of the modified plugin.php file */
	define( 'WP_HOOK_SNIFF_PLUGIN_API_VER_CURRENT', 1.2 );
	
	/* Define the minimum version of WordPress on which Hook Sniffer should run */
	define( 'WP_HOOK_SNIFF_MIN_WP_VER', 3.0 );
		
	/* Define the component's parent folder name */
	define( 'WP_HOOK_PLUGIN_NAME', 'wordpress-hook-sniffer' );
	
	/* Define the component's loader file -- this file */
	define( 'WP_HOOK_PLUGIN_LOADER', 'wp-hook-sniffer.php' );
	
	/* Define component's directory and URL Paths */
	define( 'WP_HOOK_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WP_HOOK_PLUGIN_NAME );
	define( 'WP_HOOK_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_HOOK_PLUGIN_NAME );
	
	/* WordPress is installed and activated, finish initialization and go! */
	require_once( WP_HOOK_PLUGIN_DIR . '/wp-hook-sniff-core.php' );
	
	/* WP Hook Sniffer Action Hook
	 *
	 * This hook allows those functions that are dependent on 
	 * the WP Hook Sniffer to hook into it in a safe
	 * manner -- only when it is installed and activated.
	 */
	do_action( 'wp_hook_sniff_init_event' );
}
add_action( 'plugins_loaded', 'wp_hook_sniff_init', 0 );


/**
 * wp_hook_sniff_plugin_activated()
 *
 * Register plugin activation with WordPress and set the activation hook.
 * Called upon plugin activation. 
 *
 * @since 0.1
 */
function wp_hook_sniff_plugin_activated() {
	do_action( 'wp_hook_sniff_loader_activate' );
}
register_activation_hook( 'wordpress-hook-sniffer/wp-hook-sniffer.php', 'wp_hook_sniff_plugin_activated' );


/**
 * wp_hook_sniff_plugin_deactivated()
 *
 * Register plugin deactivation with WordPress and set the deactivation hook.
 * Called upon plugin deactivation. If necessary, the modified plugin.php file is
 * replaced with the original, stock plugin.php file.
 *
 * @since 0.1
 * @version 1.1 Added routine to uninstall modified pluign API fle
 */
function wp_hook_sniff_plugin_deactivated() {
	
 	if( WP_HOOK_SNIFF_API == True ) {
		/* Modified plugin.php file is installed. Make sure original plugin.php
		   file is put back into /wp-includes */
		wp_hook_sniff_modified_plugin_api( 'uninstall' );
	} 	
	
	//if ( !function_exists( 'delete_site_option') )
		//return false;

	do_action( 'wp_hook_sniff_loader_deactivate' );
}
register_deactivation_hook( 'wordpress-hook-sniffer/wp-hook-sniffer.php', 'wp_hook_sniff_plugin_deactivated' );

?>
<?php

/**
 * wp_hook_sniff_admin_menu()
 *
 * Adds a new options page entitled 'WP Hook Sniffer' under
 * the Settings menu grouping in WP's backend
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniff_admin_menu() {
  add_options_page( __( 'WordPress Hook Sniffer Settings', WP_HOOK_PLUGIN_NAME ), 'WP Hook Sniffer', 'manage_options', 'wp_hook_sniffer', 'wp_hook_sniff_options' );
}
add_action( 'admin_menu', 'wp_hook_sniff_admin_menu' );
 

/**
 * wp_hook_sniff_admin_init()
 *
 * Settings options for WordPress Hook Sniffer
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniff_admin_init() {
	register_setting( 'wp_hook_sniffer_options', 'wp_hook_sniffer_options', 'wp_hook_sniffer_options_validate' );
	
	/* Add section heading details to variables for better translation results.
	 * This allows the CSS markup to be extracted from the translation string.
	 */
	$wp_hook_sniff_section_heading = '<div id="hook-sniff">' . __( 'Main Sniffer Settings', WP_HOOK_PLUGIN_NAME ) . '</div>';
	$wp_hook_sniff_section_heading2 = '<div id="hook-sniff">' . __( 'Output Options', WP_HOOK_PLUGIN_NAME ) . '</div>';
	$wp_hook_sniff_section_heading3 = '<div id="hook-sniff">' . __( 'Output Location', WP_HOOK_PLUGIN_NAME ) . '</div>';
	
	// Main WordPress Hook Sniffer Settings Section
	add_settings_section('wp_hook_sniffer_enable', $wp_hook_sniff_section_heading, 'wp_hook_sniffer_enable_section', 'wp_hook_sniffer');
	add_settings_field('wp_hook_sniffer_enable_radio', __( 'Enable or Disable WordPress Hook Sniffer:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_enable_settings', 'wp_hook_sniffer', 'wp_hook_sniffer_enable');
	
	// WordPress Hook Sniffer Output Options Settings Section
	add_settings_section('wp_hook_sniffer_output', $wp_hook_sniff_section_heading2, 'wp_hook_sniffer_output_section', 'wp_hook_sniffer');
	add_settings_field('wp_hook_sniffer_output_check', __( 'Added Functions:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	
	add_settings_field('wp_hook_sniffer_output_check2', __( 'Removed Functions:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings2', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	add_settings_field('wp_hook_sniffer_output_check3', __( 'Action and Filter Function Array:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings3', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	add_settings_field('wp_hook_sniffer_output_check4', __( 'Action Event Firing Order:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings4', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	add_settings_field('wp_hook_sniffer_output_check5', __( 'Action Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings5', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	add_settings_field('wp_hook_sniffer_output_check6', __( 'Filter Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_settings6', 'wp_hook_sniffer', 'wp_hook_sniffer_output');
	
	// WordPress Hook Sniffer Output Location Settings Section
	add_settings_section('wp_hook_sniffer_output_type', $wp_hook_sniff_section_heading3, 'wp_hook_sniffer_output_type_section', 'wp_hook_sniffer');
	add_settings_field('wp_hook_sniffer_output_type_check', __( 'Preferred Output Location:', WP_HOOK_PLUGIN_NAME ), 'wp_hook_sniffer_output_type_settings', 'wp_hook_sniffer', 'wp_hook_sniffer_output_type');
	
	do_action( 'wp_hook_sniffer_admin_settings' );
}
add_action( 'admin_init', 'wp_hook_sniff_admin_init' );


/**
 * wp_hook_sniff_options()
 *
 * Displays the admin setting options page for WordPress Hook Sniffer when
 * an admin user clicks on the 'WP Hook Sniffer' submenu under the
 * Settings menu in the backend
 *
 * @since 0.1
 * @version 1.1
 */
function wp_hook_sniff_options() { 
	global $wp_hook_sniffer_options_set;

?>
	<div class="wrap">
	
		<div id="hook-sniff">
		
			<div class="wp_hook_sniff_sidebar">
				<div class="wp_hook_sniff_section"><?php _e( 'Please Support My Work', WP_HOOK_PLUGIN_NAME ) ?></div>
				<div class="wp_hook_sniff_paypal_button">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="VTHMENKR9ZWB4">
						<table>
						<tr><td><input type="hidden" name="on0" value="Sponsorship Levels">Sponsorship Levels</td></tr><tr><td><select name="os0">
							<option value="Supporter">Supporter $15.00</option>
							<option value="Donor">Donor $25.00</option>
							<option value="Sponsor">Sponsor $50.00</option>
							<option value="Benefactor">Benefactor $100.00</option>
							<option value="Patron">Patron $250.00</option>
							<option value="Open Source Angel">Open Source Angel $500.00</option>
							<option value="Holy Cow!">Holy Cow! $1,000.00</option>
						</select></td></tr>
						</table>
						<input type="hidden" name="currency_code" value="USD">
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<p><em><?php _e( 'If you are a corporate user, consultant, plugin developer, or theme designer and profit from using my plugin, please consider donating at one of the upper levels. Thank you!', WP_HOOK_PLUGIN_NAME ) ?></em></p>
				</div>
				
				<div class="wp_hook_sniff_section">
					<?php _e( 'WP Hook Sniffer Resources', WP_HOOK_PLUGIN_NAME ) ?>
				</div>
				<a href="http://jeffsayre.com/2010/04/29/introducing-wordpress-hook-sniffer-a-developer-plugin/">Getting Started</a><br />
				<a href="http://jeffsayre.com/2010/04/29/wordpress-hooks-barbs-and-snags/">Interpreting the Output</a><br />
				<a href="http://buddypress.org/community/groups/wordpress-hook-sniffer/forum/">WP Hook Sniffer Support Forum</a>
				<br /><br />
				
				<div class="wp_hook_sniff_section">
					<?php _e( 'You Should Follow Me', WP_HOOK_PLUGIN_NAME ) ?>
				</div>
				<a href="http://twitter.com/jeffsayre">Twitter</a><br />
				<a href="http://www.linkedin.com/in/jeffsayre">LinkedIn</a>
												
				<?php
				echo "<div class='copy'><p>" . __( 'Plugin Version', WP_HOOK_PLUGIN_NAME ) . ": " .  WP_HOOK_PLUGIN_VERSION . "<br />" . __( 'Plugin Licensed Under', WP_HOOK_PLUGIN_NAME ) . "<a href='http://www.gnu.org/licenses/gpl.html'> GPL 3.0</a><br />&copy; Copyright 2010 <a href='http://jeffsayre.com'>Jeff Sayre</a></p></div>";
				?>
			</div>
			
			<div class="wp_hook_sniff_settings">
			
				<h2><?php _e( 'WordPress Hook Sniffer Settings', WP_HOOK_PLUGIN_NAME ) ?></h2>
		
				<?php
				if( WP_HOOK_SNIFF_COMPATIBLE_WITH_WORDPRESS == False ) {
					$msg = sprintf( __('WARNING: Version %01.2f of WordPress Hook Sniffer requires WordPress version %01.2f or newer. You must upgrade WordPress to use this plugin. Please deactivate plugin.', WP_HOOK_PLUGIN_NAME ), WP_HOOK_PLUGIN_VERSION, WP_HOOK_SNIFF_MIN_WP_VER );
		
					echo "<div id='hook_sniff_warning'><p>$msg</p></div>";
				}
				
				if( WP_HOOK_SNIFF_API == False ) {
					echo "<div id='hook-sniff-api-nag'><p>" . __( 'Warning! You have not installed the Modified WordPress Plugin API file. WordPress Hook Sniffer will not work without this. Please see the readme file for more information.', WP_HOOK_PLUGIN_NAME ) . "</p></div>";
				}
				
				if( WP_HOOK_SNIFF_API == True ) {
					if( WP_HOOK_SNIFF_PLUGIN_API_VER < WP_HOOK_SNIFF_PLUGIN_API_VER_CURRENT ) {
						echo "<div id='hook-sniff-api-nag'><p>" . __( 'Notice! There is an update to the modified plugin.php file. You are running an older version. Please replace the version of plugin.php that you have in /wp-includes with the newer version located in WP Hook Sniffer&#039;s /accessory_files/modified.', WP_HOOK_PLUGIN_NAME ) . "</p></div>";
					}
				}
				?>
				
				<p><?php _e( 'The WordPress Hook Sniffer plugin is a tool for plugin developers that helps determine the sequence in which action and filter functions are fired. You can configure what is outputted and to where the output is sent. Please note, this plugin is to be used only in a development sandbox and not in a production environment.', WP_HOOK_PLUGIN_NAME ) ?></p>
			
				<form action="options.php" method="post">
					
					<?php
					
					settings_fields( 'wp_hook_sniffer_options' );
								
					// If WordPress Hook Sniffer is enabled, check to see if any output options were selected
					if( $wp_hook_sniffer_options_set[ 'enabled' ] == 1 && empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
						echo "<div id='hook-sniff-api-nag'><p>" . __( 'You have not selected any output options. WordPress Hook Sniffer cannot be awesome without your help! Please set to disabled or choose some output options.', WP_HOOK_PLUGIN_NAME ) . "</p></div>";
					}
			
					do_settings_sections( 'wp_hook_sniffer' );
			
					?>
					
					<input name="wp-hook-sniff-options-submit" type="submit" value="<?php esc_attr_e( 'Save Changes', WP_HOOK_PLUGIN_NAME ); ?>" />
					
				</form>
			</div>
		</div>
	</div>

<?php
}


/**
 * wp_hook_sniffer_options_validate()
 *
 * Outputs the text seen under the 'Main Sniffer Settings' heading
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_options_validate() {

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if( isset( $_POST[ 'wp-hook-sniff-options-submit' ] ) && isset( $_POST[ 'wp_hook_sniffer_options' ] ) ) {
		
		if( !check_admin_referer( 'wp_hook_sniffer_options-options' ) )
			return false;
	
		// for additonal security
		$_POST[ 'wp_hook_sniffer_options' ] = array_map( 'stripslashes_deep', $_POST[ 'wp_hook_sniffer_options' ] );
		
		$hook_options_new = $_POST[ 'wp_hook_sniffer_options' ];
		
		do_action( 'wp_hook_sniffer_options_validate', $hook_options_new );
			
		return $hook_options_new;
	}
}


/*********************************************
 * Main Sniffer Settings Section Functions
 ********************************************/
 
/**
 * wp_hook_sniffer_enable_section()
 *
 * Outputs the text seen under the 'Main Sniffer Settings' sectionheading
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_enable_section() {
	echo "<p>" . __( 'WordPress Hook Sniffer is disabled by default. Enable it here, and then choose your preferred settings below.', WP_HOOK_PLUGIN_NAME ) . "</p>";
}


/**
 * wp_hook_sniffer_enable_settings()
 *
 * Outputs the "Enable" and "Disable" radio button field group
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_enable_settings() {
	global $wp_hook_sniffer_options_set;
	
	echo "<div id='hook-sniff'><div class='enable'><p><h4>";
	echo "<label>" . __( 'Enabled', WP_HOOK_PLUGIN_NAME ) . "&nbsp;<input type='radio' name='wp_hook_sniffer_options[enabled]' value='1'" . ( $wp_hook_sniffer_options_set[ 'enabled' ] == 1 ? ' checked' : '' ) . " /></label> &nbsp;&nbsp;";
	echo "<label>" . __( 'Disabled', WP_HOOK_PLUGIN_NAME ) . "&nbsp;<input type='radio' name='wp_hook_sniffer_options[enabled]' value='0'" . ( $wp_hook_sniffer_options_set[ 'enabled' ] == 0 ? ' checked' : '' ) . " /></label>";
	echo "</h4></p></div></div>";
}


/*********************************************
 * Output Options Settings Section Functions
 ********************************************/

/**
 * wp_hook_sniffer_output_section()
 *
 * Outputs the text seen under the 'Output Options' section heading
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_section() {
	echo "<p>" . __( 'Choose which arrays you wish to output. Each provides a unique insight into the underlying working of WordPress&#039; hooks. To learn more about how to interpret the output, see the WP Hook Sniffer Resources section to the left.', WP_HOOK_PLUGIN_NAME ) . "</p>";
}


/**
 * wp_hook_sniffer_output_settings()
 *
 * Outputs the checkbox to select the "Added Functions" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings() {
	global $wp_hook_sniffer_options_set;

	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][added_functions]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][added_functions]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'added_functions' ] == true ? ' checked' : '' ) . " />";
	}
}


/**
 * wp_hook_sniffer_output_settings2()
 *
 * Outputs the checkbox to select the "Removed Functions" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings2() {
	global $wp_hook_sniffer_options_set;

	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][removed_functions]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][removed_functions]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'removed_functions' ] == true ? ' checked' : '' ) . " />";
	}
}


/**
 * wp_hook_sniffer_output_settings3()
 *
 * Outputs the checkbox to select the "Action and Filter Function Array" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings3() {
	global $wp_hook_sniffer_options_set;
	
	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][filter_array]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][filter_array]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'filter_array' ] == true ? ' checked' : '' ) . " />";
	}
}


/**
 * wp_hook_sniffer_output_settings4()
 *
 * Outputs the checkbox to select the "Action Event Firing Order" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings4() {
	global $wp_hook_sniffer_options_set;

	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][action_event_order]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][action_event_order]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'action_event_order' ] == true ? ' checked' : '' ) . " />";
	}
}


/**
 * wp_hook_sniffer_output_settings5()
 *
 * Outputs the checkbox to select the "Action Event Firing Sequence" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings5() {
	global $wp_hook_sniffer_options_set;

	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][action_events]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][action_events]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'action_events' ] == true ? ' checked' : '' ) . " />";
	}
}


/**
 * wp_hook_sniffer_output_settings6()
 *
 * Outputs the checkbox to select the "Filter Event Firing Sequence" array
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_settings6() {
	global $wp_hook_sniffer_options_set;

	if( empty( $wp_hook_sniffer_options_set[ 'output' ] ) ) {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][filter_events]' value='yes' />";
	} else {
		echo "<input type='checkbox' name='wp_hook_sniffer_options[output][filter_events]' value='yes'" . ( $wp_hook_sniffer_options_set[ 'output' ][ 'filter_events' ] == true ? ' checked' : '' ) . " />";
	}
}


/*********************************************
 * Output Location Settings Section Functions
 ********************************************/

/**
 * wp_hook_sniffer_output_type_section()
 *
 * Outputs the text seen under the 'Output Location' section heading
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_type_section() {
	echo "<p>" . __( 'You can choose to either output the results directly to screen, or to a text file. Screen results will appear after the theme&#039;s footer. The text file "wp-hook-sniff.txt" can be found in the "hook-sniff-report" folder of the wordpress-hook-sniffer directory.', WP_HOOK_PLUGIN_NAME ) . "</p>";
}


/**
 * wp_hook_sniffer_output_type_settings()
 *
 * Outputs the "To Screen" and "To Print" radio button field group
 *
 * @since 0.1
 * @version 1.0
 */
function wp_hook_sniffer_output_type_settings() {
	global $wp_hook_sniffer_options_set;
	
	echo "<div id='hook-sniff'><div class='enable'><p><h4>";
	echo "<label>" . __( 'To Screen', WP_HOOK_PLUGIN_NAME ) . "&nbsp;<input type='radio' name='wp_hook_sniffer_options[screen]' value='1'" . ( $wp_hook_sniffer_options_set[ 'screen' ] == 1 ? ' checked' : '' ) . " /></label> &nbsp;&nbsp;";
	echo "<label>" . __( 'To File', WP_HOOK_PLUGIN_NAME ) . "&nbsp;<input type='radio' name='wp_hook_sniffer_options[screen]' value='0'" . ( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ? ' checked' : '' ) . " /></label>";
	echo "</h4></p></div></div>";
}

?>
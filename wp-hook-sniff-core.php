<?php

// Finish including all necessary files
require_once( WP_HOOK_PLUGIN_DIR . '/wp-hook-sniff-admin.php' );


/**
 * Determine set WordPress Hook Sniffer options
 * 
 * Grabs the stored set options for WordPress Hook Sniffer from 
 * the wp_options table (wp_x_options in multisite) for later use.
 */

global $wp_hook_sniffer_options_set;
$wp_hook_sniffer_options_set = apply_filters( 'wp_hook_sniff_set_options', get_option( 'wp_hook_sniffer_options' ) );


/**
 * wp_hook_sniff_add_structure_css()
 *
 * This function enqueues the structural CSS to help retain interface
 * structure regardless of the theme currently in use.
 *
 * @since 0.14
 * @version 1.0 
 */
function wp_hook_sniff_add_structure_css() {
	/* Enqueue the WordPress hook Sniffer CSS file */
	wp_enqueue_style( 'wp-hook-sniff-structure', WP_HOOK_PLUGIN_URL . '/css/wp_hook_sniff.css' );	
}
add_action( 'init', 'wp_hook_sniff_add_structure_css' );


/**
 * wp_hook_sniff_verify_wp_version()
 *
 * Checks to make sure that WP Hook Sniffer is installed on the proper version of
 * WordPress.
 *
 * @since 0.14
 * @version 1.0 
 */
function wp_hook_sniff_verify_wp_version() {
	global $wp_version;
	
	// Do WP version check
	if ( version_compare( $wp_version, WP_HOOK_SNIFF_MIN_WP_VER, '>=' ) ) {
		/* current version of WP is sufficient to run WP Hook Sniffer. Install
		   modified plugin.php file into /wp-includes if it is not already installed */
		   
		define( 'WP_HOOK_SNIFF_COMPATIBLE_WITH_WORDPRESS', True );
		
	} else {
		// Set constant to shut down hook sniffer output
		define( 'WP_HOOK_SNIFF_COMPATIBLE_WITH_WORDPRESS', False );
	}

}
add_action ( 'wp_hook_sniff_init_event', 'wp_hook_sniff_verify_wp_version', 1 );


/**
 * wp_hook_sniff_warning_wp_version()
 *
 * If WP Hook Sniffer is not installed on the proper version of WordPress,
 * a warning message will be displayed on the Plugins menu page. If WordPress
 * version is okay, a check is run to make sure that the proper version of
 * the modified plugin.php file is installed.
 *
 * @since 0.14
 * @version 1.0 
 */
function wp_hook_sniff_warning_wp_version( $plugin_file, $plugin_data, $context ) {
	
	if( WP_HOOK_SNIFF_COMPATIBLE_WITH_WORDPRESS == False ) {
		$msg = sprintf( __('WARNING: Version %01.2f of WordPress Hook Sniffer requires WordPress version %01.2f or newer. You must upgrade WordPress to use this plugin. Please deactivate plugin.', WP_HOOK_PLUGIN_NAME ), WP_HOOK_PLUGIN_VERSION, WP_HOOK_SNIFF_MIN_WP_VER );
		
		echo "<div class='wrap' class='message' id='hook_sniff_warning'>$msg</div>";
	} else {
	
		if( ( WP_HOOK_SNIFF_API == False ) || ( WP_HOOK_SNIFF_API == True && WP_HOOK_SNIFF_PLUGIN_API_VER < WP_HOOK_SNIFF_PLUGIN_API_VER_CURRENT ) ) {
			wp_hook_sniff_modified_plugin_api( 'install' );
 		}
	}
}
//Uses code-generated action hook "after_plugin_row_$plugin_file" on line 482 of current WP3.0 version of wp-admin/plugins.php file
//add_action( 'after_plugin_row_wordpress-hook-sniffer/wp-hook-sniffer.php', 'wp_hook_sniff_verify_wp_version' );
add_action( 'after_plugin_row_' . WP_HOOK_PLUGIN_NAME . '/' . WP_HOOK_PLUGIN_LOADER, 'wp_hook_sniff_warning_wp_version', 1, 3 );


/**
 * wp_hook_sniff_modified_plugin_api()
 *
 * Installs or uninstalls the modified plugin API file plugin.php.
 *
 * @since 0.14
 * @version 1.0
 *
 * @param string $source the source directory where the modified plugin.php file resides
 * @param string $destination the destination directory to which it will be copied (/wp-includes)
 */
function wp_hook_sniff_modified_plugin_api( $hook_sniff_plugin_file ) {
	global $wp_filesystem;
	
	$value = WP_Filesystem( 'direct', ABSPATH . WPINC );
	
	$destination = ( ABSPATH . WPINC . "/" );
	
	if( $hook_sniff_plugin_file == 'install' ) {
		// Copy modified plugin.php file into /wp-includes
		$source = ( WP_HOOK_PLUGIN_DIR . '/accessory_files/modified/' );
		
	} elseif ( $hook_sniff_plugin_file == 'uninstall' ) {
		// Copy back the original, stock plugin.php file into /wp-includes
		
		$source = ( WP_HOOK_PLUGIN_DIR . '/accessory_files/original/' );
			
	} else {
			// an error of some sort occurred; do nothing
			//echo "There's an error.";
	}
	
	//copy_dir( $source, $destination );
	
	$result = copy_dir( $source, $destination );
	if ( is_wp_error($result) )
		echo "<br />There's an error.";
}


/**
 * wp_hook_sniff_load_textdomain()
 * 
 * Load the WordPress Hook Sniffer translation file for current language
 *
 * @since 0.12
 * @version 1.0
 */
function wp_hook_sniff_load_textdomain() {

	/* First get locale file if it exists */
	$locale = apply_filters( 'wp_hook_sniff_locale', get_locale() );
	
	/* If locale file exists, create path to .mo file and try to load */
	if ( !empty( $locale ) ) {
		
		/* path to .mo file */
		$mofile_path = sprintf( '%s/languages/%s-%s.mo', WP_HOOK_PLUGIN_DIR, WP_HOOK_PLUGIN_NAME, $locale );
		
		/* Allow filtering of file path */
		$mofile = apply_filters( 'wp_hook_sniff_mofile', $mofile_path );
		
		if ( file_exists( $mofile ) ) {
			load_textdomain( WP_HOOK_PLUGIN_NAME, $mofile );
		}
	}
}
add_action ( 'wp_hook_sniff_init_event', 'wp_hook_sniff_load_textdomain', 1 );


/**
 * wp_hook_sniff_output_hook_info()
 * 
 * Outputs the selected hook intelligence.
 *
 * Uses data assembled by action_filter_backtrace(), a special
 * function added to the WP Plugin API exclusively for the
 * WP Hook Sniffer Plugin.
 * 
 * @since 0.1
 * @version 1.1
 */
function wp_hook_sniff_output_hook_info() {
	global $wp_hook_sniffer_options_set, $wp_actions, $wp_filter, $wp_hook_sniff_action_firing_sequence, $wp_hook_sniff_filter_firing_sequence, $wp_hook_sniff_functions_added_array, $wp_hook_sniff_functions_removed_array;
	
	/* Check to see if we should be outputting anything */
	
	/* If the Modified WordPress Plugin API file is not installed or not current, 
	   or the WordPress version is not sufficient, then exit */
	if( ( WP_HOOK_SNIFF_API == False ) || ( WP_HOOK_SNIFF_COMPATIBLE_WITH_WORDPRESS == False ) || ( WP_HOOK_SNIFF_PLUGIN_API_VER < WP_HOOK_SNIFF_PLUGIN_API_VER_CURRENT ) )
		return;	
	
	// If WordPress Hook Sniffer is disabled, exit
	if( $wp_hook_sniffer_options_set[ 'enabled' ] == 0 )
		return;
	
	// If WordPress Hook Sniffer is enabled, but no output options were selected, exit
	if( $wp_hook_sniffer_options_set[ 'enabled' ] == 1 && empty( $wp_hook_sniffer_options_set[ 'output' ] ) )
		return;
	
	do_action( 'wp_hook_sniff_before_output_hook_info' );
	
	// Otherwise, we're good to go! Output selected results

	if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
		// send output to text file
		
		/* Set the filepath and filename for the WP Hook Sniff text report */
		$wp_hook_sniff_path_file = WP_HOOK_PLUGIN_DIR . "/hook-sniff-report/wp-hook-sniff.txt";
		
		/* create the header for the output report */
		$wp_hook_sniff_report_header = "WordPress Hook Sniffer Report \nReport Version: 0.1 \nReport Date: " . Date( DATE_RFC822 ) . "\n";
		$fh = fopen( $wp_hook_sniff_path_file, "wt" ) or die( "can't open file" );
		fwrite( $fh, $wp_hook_sniff_report_header );
		fclose( $fh );

	}
	
	/**
	 * Added Functions Output
	 *
	 * Output the special WP Hook Sniffer array that holds, in the order
	 * in which they were encountered during code execution, all add_action
	 * calls and add_filter calls
	 */
	if( $wp_hook_sniffer_options_set[ 'output' ][ 'added_functions' ] == true ) {	
		
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			$wp_hook_sniffer_functions_array_element = "\n_________________________________________\n" . __( 'Added Functions:', WP_HOOK_PLUGIN_NAME ) . "\n\n";
		} else {
			$wp_hook_sniffer_functions_array_element = "<br />_________________________________________<br /><strong>" . __( 'Added Functions:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />";
		}
			
		/* Iterate through the array of all added action and filter functions
		 * This array is a multidimensional array with each primary element 
		 * holding an array that contains the details about each added function
		 */
		foreach( (array)$wp_hook_sniff_functions_added_array as $key => $value ) {
			
			/* Output is placed into a string variable to make it easier
			 * to either echo to screen or send to a text file
			 */
			
			$wp_hook_sniffer_functions_array_element .= "{$value["sequence"]}: {$value["action"]}( '{$value["event"]}', '{$value["function"]}'";
			
			if( !empty( $value["priority"] ) ) {
				$wp_hook_sniffer_functions_array_element .= ", " . $value["priority"];
			}
			
			if( !empty( $value["args"] ) ) {
				$wp_hook_sniffer_functions_array_element .= ", " . $value["args"] . " )";
			} else {
				$wp_hook_sniffer_functions_array_element .= " )"; 
			}
			
			$wp_hook_sniffer_functions_array_element .= " Called from: " . $value["file"] . " | line #: " . $value["line"] . " --> Time Added: " . $value["time"];
			
			if( $wp_hook_sniffer_options_set[ 'screen' ] == 1 ) {
				// add a linebreak for screen output
				$wp_hook_sniffer_functions_array_element .= "<br />";
			}
			
			if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
				// send output to text file

				$wp_hook_sniffer_functions_array_element .= "\n";
				$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
				fwrite( $fh, $wp_hook_sniffer_functions_array_element );
				fclose( $fh );
			
			} else /* send output to screen */ {
				echo $wp_hook_sniffer_functions_array_element;
			}
			
			// reset variable for next element content
			$wp_hook_sniffer_functions_array_element = "";
		}
	}
	
		/* For those wondering what just happened, here's the above array
		* split out into separate lines just for screen output
		*/
		
		/*
		foreach( (array)$wp_hook_sniff_functions_added_array as $key => $value ) {
			echo $value["sequence"] . ": ";
			echo $value["action"] . "( '";
			echo $value["event"] . "', '";
			echo $value["function"] . "'";
			
			if( !empty( $value["priority"] ) ) {
				echo ", " . $value["priority"];
			}
			
			if( !empty( $value["args"] ) ) {
				echo ", " . $value["args"] . " )";
			} else {
				echo " )"; 
			}
			
			echo " Called from: " . $value["file"];
			echo " | line #: " . $value["line"];
			echo " --> Time Added: " . $value["time"] . "<br />";
		}
		*/
	
	
	/**
	 * Removed Functions Output
	 *
	 * Output the special WP Hook Sniffer array that holds, in the order
	 * in which they were encountered during code execution, all remove_action
	 * calls and remove_filter calls
	 */
	 if( $wp_hook_sniffer_options_set[ 'output' ][ 'removed_functions' ] == true ) {
	
		$wp_hook_sniffer_removed_hooks_message = __( "If 'Time Removed' is zero, this means that the function to decouple from the given hook did not yet exist in the wp_filter array at the time the remove_filter or remove_action call was triggered. Therefore, there is nothing to remove at this time. The results may vary depending on from which url of the application you are reading the Hook Sniffer output.", WP_HOOK_PLUGIN_NAME );
	
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			$wp_hook_sniffer_functions_array_element = "\n_________________________________________\n" . __( 'Removed Functions:', WP_HOOK_PLUGIN_NAME ) . "\n\n$wp_hook_sniffer_removed_hooks_message\n\n";
		} else {
			$wp_hook_sniffer_functions_array_element = "<br />_________________________________________<br /><strong>" . __( 'Removed Functions:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />$wp_hook_sniffer_removed_hooks_message<br /><br />";
		}
		
		/* Iterate through the array of all removed action and filter functions
		 * This array is a multidimensional array with each primary element 
		 * holding an array that contains the details about each removed function
		 */
		foreach( (array)$wp_hook_sniff_functions_removed_array as $key => $value ) {
			
			$wp_hook_sniffer_functions_array_element .= "{$value["sequence"]}: {$value["action"]}( '{$value["event"]}', '{$value["function"]}'";
			
			if( !empty( $value["priority"] ) ) {
				$wp_hook_sniffer_functions_array_element .= ", " . $value["priority"];
			}
			
			if( !empty( $value["args"] ) ) {
				$wp_hook_sniffer_functions_array_element .= ", " . $value["args"] . " )";
			} else {
				$wp_hook_sniffer_functions_array_element .= " )"; 
			}
			
			$wp_hook_sniffer_functions_array_element .= " Called from: " . $value["file"] . " | line #: " . $value["line"] . " --> Time Removed: " . $value["time"];
			
			if( $wp_hook_sniffer_options_set[ 'screen' ] == 1 ) {
				// add a linebreak for screen output
				$wp_hook_sniffer_functions_array_element .= "<br />";
			}
			
			if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
				// send output to text file

				$wp_hook_sniffer_functions_array_element .= "\n";
				$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
				fwrite( $fh, $wp_hook_sniffer_functions_array_element );
				fclose( $fh );
			
			} else /* send output to screen */ {
				echo $wp_hook_sniffer_functions_array_element;
			}
			
			// reset variable for next element content
			$wp_hook_sniffer_functions_array_element = "";
		}
	}
	
	
	/**
	 * Action and Filter Function Array Output
	 *
	 * Output the contents of the $wp_filter array, the array that holds
	 * all of the added action and filter functions and is used by the do_action
	 * and apply_filters functions
	 */
	if( $wp_hook_sniffer_options_set[ 'output' ][ 'filter_array' ] == true ) {
		
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			// send output to text file
			$wp_hook_sniffer_wp_filter_array = "\n_________________________________________\n" . __( 'Action and Filter Function Array:', WP_HOOK_PLUGIN_NAME ) . "\n\n";
		
			$wp_hook_sniffer_wp_filter_array .= print_r( $wp_filter, true );
			$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
			fwrite( $fh, $wp_hook_sniffer_wp_filter_array );
			fclose( $fh );
		} else {
			$wp_hook_sniffer_wp_filter_array = "<br />_________________________________________<br /><strong>" . __( 'Action and Filter Function Array:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />";
			
			echo $wp_hook_sniffer_wp_filter_array;
			
			foreach ( (array)$wp_filter as $key => $value ) {
				echo "<pre>";
				echo "<strong>" . $key . ": </strong><br />";
				print_r( $value );
				echo "</pre><br />";
			}
			
			// Uncomment below and then comment above to see unformatted array output
			/*
			print_r( $wp_filter );
			echo "<br />";
			*/
		}
	}
	
	
	/**
	 * Action Event Firing Order Output
	 *
	 * Output the contents of the $wp_actions array, the array that holds the 
	 * sequential listing of all the do_action events that need to be processed.
	 */
	if( $wp_hook_sniffer_options_set[ 'output' ][ 'action_event_order' ] == true ) {
		
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			// send output to text file
			$wp_hook_sniffer_wp_actions_array = "\n_________________________________________\n" . __( 'Action Event Firing Order:', WP_HOOK_PLUGIN_NAME ) . "\n\n";
		
			$wp_hook_sniffer_wp_actions_array .= print_r( $wp_actions, true );
			$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
			fwrite( $fh, $wp_hook_sniffer_wp_actions_array );
			fclose( $fh );
		} else {
			$wp_hook_sniffer_wp_actions_array = "<br />_________________________________________<br /><strong>" . __( 'Action Event Firing Order:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />";
			
			echo $wp_hook_sniffer_wp_actions_array;
			//print_r( $wp_actions );
			
			if ( empty( $action_number ) ) {
				$action_number++;
			}
			
			$total_actions = count( $wp_actions );
			
			echo "Total Actions in Queue: " . $total_actions . "<br /><br />";
			
			foreach ( (array)$wp_actions as $key => $value ) {
				
				if( $action_number < $total_actions) {
					echo "[$action_number] " . $key . " => ";
				} else {
					echo "[$action_number] " . $key;
				}
				$action_number++;
			}
			echo "<br />";
		}
	}
	
	
	/**
	 * Action Event Firing Sequence Output
	 *
	 * Output the contents of the $wp_hook_sniff_action_firing_sequence array, the array that holds
	 * the sequential listing of do_action events with their corresponding fired
	 * action function(s).
	 */
	if( $wp_hook_sniffer_options_set[ 'output' ][ 'action_events' ] == true ) {
		
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			$wp_hook_sniffer_action_fired_array_element = "\n_________________________________________\n" . __( 'Action Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ) . "\n\n";
		} else {
			$wp_hook_sniffer_action_fired_array_element = "<br />_________________________________________<br /><strong>" . __( 'Action Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />";
		}

		// List only those action events that have added actions that fired
		foreach( (array)$wp_hook_sniff_action_firing_sequence as $key => $value ) {
			
			if( strpos( $value, "Action event has no added actions" ) !== false ) {
				// Element contains no fired actions
				
			} else {
				// Element contains action that fired
				
				if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
					// send output to text file
					$wp_hook_sniffer_action_fired_array_element .= "{$value}\n";
					$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
					fwrite( $fh, $wp_hook_sniffer_action_fired_array_element );
					fclose( $fh );
				} else {
					$wp_hook_sniffer_action_fired_array_element .= "{$value}<br />";
					echo $wp_hook_sniffer_action_fired_array_element;
				}
				
				// reset variable for next element content
				$wp_hook_sniffer_action_fired_array_element = "";
			}
		}	
	}
	
	
	/**
	 * Filter Event Firing Sequence Output
	 *
	 * Output the contents of the $wp_hook_sniff_filter_firing_sequence array, the array that holds
	 * the sequential listing of apply_filters events with their corresponding fired
	 * filter function(s).
	 */
	if( $wp_hook_sniffer_options_set[ 'output' ][ 'filter_events' ] == true ) {
		
		if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
			$wp_hook_sniffer_filter_fired_array_element = "\n_________________________________________\n" . __( 'Filter Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ) . "\n\n";
		} else {
			$wp_hook_sniffer_filter_fired_array_element = "<br />_________________________________________<br /><strong>" . __( 'Filter Event Firing Sequence:', WP_HOOK_PLUGIN_NAME ) . "</strong><br /><br />";
		}
		
		// List only those action events that have added actions that fired
		foreach( (array)$wp_hook_sniff_filter_firing_sequence as $key => $value ) {
	
			if( strpos( $value, "Filter event has no added filters" ) !== false ) {
				// Element contains no fired actions
			} else {
				// Element contains action that fired
				
				if( $wp_hook_sniffer_options_set[ 'screen' ] == 0 ) {
					// send output to text file
					$wp_hook_sniffer_filter_fired_array_element .= $value . "\n";
					$fh = fopen( $wp_hook_sniff_path_file, "at" ) or die( "can't open file" );
					fwrite( $fh, $wp_hook_sniffer_filter_fired_array_element );
					fclose( $fh );
				} else {
					$wp_hook_sniffer_filter_fired_array_element .= $value . "<br />";
					echo $wp_hook_sniffer_filter_fired_array_element;
				}
			
				// reset variable for next element content
				$wp_hook_sniffer_filter_fired_array_element = "";
			}	
		}
	}
	
	do_action( 'wp_hook_sniff_after_output_hook_info' );

}
add_action( 'shutdown', 'wp_hook_sniff_output_hook_info' );

?>
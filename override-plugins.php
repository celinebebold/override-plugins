<?php
/**
 * Override Any Plugin
 *
 * @package       OVERPLUG
 * @author        bebold
 * @version       1.0.2
 *
 * @wordpress-plugin
 * Plugin Name:   Override Any Plugin
 * Plugin URI:    https://override-plugins.ch
 * Description:   Allows to override any file from any plugin
 * Version:       1.0.2
 * Author:        bebold
 * Author URI:    https://bebold.ch
 * Text Domain:   override-plugins
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'OVERPLUG_NAME',			'Override Any Plugin' );

// Plugin version
define( 'OVERPLUG_VERSION',		'1.0.2' );

// Plugin Root File
define( 'OVERPLUG_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'OVERPLUG_PLUGIN_BASE',	plugin_basename( OVERPLUG_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'OVERPLUG_PLUGIN_DIR',	plugin_dir_path( OVERPLUG_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'OVERPLUG_PLUGIN_URL',	plugin_dir_url( OVERPLUG_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once OVERPLUG_PLUGIN_DIR . 'core/class-override-plugins.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  bebold
 * @since   1.0.0
 * @return  object|Override_Plugins
 */
function OVERPLUG() {
	return Override_Plugins::instance();
}

OVERPLUG();

if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

/* auto check update on github */
$updater = new Smashing_Updater( __FILE__ );
$updater->set_username( 'celinebebold' );
$updater->set_repository( 'override-plugins' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$updater->initialize();

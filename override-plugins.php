<?php
/**
 * Override Any Plugin
 *
 * @package       OVERPLUG
 * @author        bebold
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Override Any Plugin
 * Plugin URI:    https://override-plugins.ch
 * Description:   Allows to override any file from any plugin
 * Version:       1.0.0
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
define( 'OVERPLUG_VERSION',		'1.0.1' );

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

<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Override_Plugins_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		OVERPLUG
 * @subpackage	Classes/Override_Plugins_Run
 * @author		bebold
 * @since		1.0.0
 */
class Override_Plugins_Run{

	/**
	 * Our Override_Plugins_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		global $message;
		$message = "";
		add_action( 'plugin_action_links_' . OVERPLUG_PLUGIN_BASE, array( $this, 'add_plugin_action_link' ), 20 );
		add_action('init',array( $this, 'override_plugin_files' ));
		add_action('admin_head',array( $this, 'display_message' ));
		
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	* Adds action links to the plugin list table
	*
	* @access	public
	* @since	1.0.0
	*
	* @param	array	$links An array of plugin action links.
	*
	* @return	array	An array of plugin action links.
	*/
	public function add_plugin_action_link( $links ) {

		//$links['intructions'] = sprintf( '<a href="%s" target="_blank title="Instructions">%s</a>', 'https://override-plugins.ch/instructions', __( 'Instructions', 'override-plugins' ) );
        array_unshift($links, sprintf( '<a href="%s" target="_blank title="Instructions">%s</a>', 'https://override-plugins.ch/instructions', __( 'Instructions', 'override-plugins' ) ));
		
		return $links;
	}

	

	function display_message() { 
		global $message;
		echo $message;
	}

	

	function override_plugin_files() { 

		if( !is_admin() ) {		
			return;		
		}
		global $message;
		// Does not support flag GLOB_BRACE
		function rglob($pattern, $flags = 0) {
			$files = glob($pattern, $flags); 
			foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
				$files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
			}
			return $files;
		}
		$dir = get_stylesheet_directory().'/override-plugins';
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$pattern = $dir.'/*.*';
		$files = rglob($pattern, GLOB_NOCHECK); 
		foreach ($files as $path) {
			try {
				if(file_exists($path)){
					$file = str_replace(substr($pattern,0,-3),'',$path);
					$plugin_file = WP_PLUGIN_DIR . '/'.$file;
					if(file_exists($plugin_file)){
						if(filemtime($plugin_file) != filemtime($path)) {
							if(!@copy($path,$plugin_file)){
								$message .= "<script>console.log('failed to override \"$file\"')</script>";
								$message .= "<script>console.log(".json_encode(error_get_last()).")</script>";
							}
							else touch($plugin_file, filemtime($path));

						} else $message .= "<script>console.log('file \"$file\" is the same, no need to override')</script>";
					}else $message .= "<script>console.log('file \"$file\" does not exist, no need to override')</script>";
				}
			} catch (\Throwable $th) {
				$message .= "<script>console.log('failed to override \"$path\"')</script>";
			}
		}
	}

}

<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Override_Plugins' ) ) :

	/**
	 * Main Override_Plugins Class.
	 *
	 * @package		OVERPLUG
	 * @subpackage	Classes/Override_Plugins
	 * @since		1.0.0
	 * @author		bebold
	 */
	final class Override_Plugins {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Override_Plugins
		 */
		private static $instance;

		/**
		 * OVERPLUG helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Override_Plugins_Helpers
		 */
		public $helpers;

		/**
		 * OVERPLUG settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Override_Plugins_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'override-plugins' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'override-plugins' ), '1.0.0' );
		}

		/**
		 * Main Override_Plugins Instance.
		 *
		 * Insures that only one instance of Override_Plugins exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Override_Plugins	The one true Override_Plugins
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Override_Plugins ) ) {
				self::$instance					= new Override_Plugins;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Override_Plugins_Helpers();
				self::$instance->settings		= new Override_Plugins_Settings();

				//Fire the plugin logic
				new Override_Plugins_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'OVERPLUG/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once OVERPLUG_PLUGIN_DIR . 'core/includes/classes/class-override-plugins-helpers.php';
			require_once OVERPLUG_PLUGIN_DIR . 'core/includes/classes/class-override-plugins-settings.php';

			require_once OVERPLUG_PLUGIN_DIR . 'core/includes/classes/class-override-plugins-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'override-plugins', FALSE, dirname( plugin_basename( OVERPLUG_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.
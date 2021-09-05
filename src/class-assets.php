<?php
/**
 * The file that defines client-side asset files that can be loaded for the plugin in an independent way.
 *
 * A class definition that can includes client-side asset files made available to users and visitors.
 *
 * @link       https://github.com/zachwatkins/task-interface-management/blob/master/src/class-assets.php
 * @since      1.0.0
 * @package    task-interface-management
 * @subpackage task-interface-management/src
 */

namespace Task_Interface_Management;

/**
 * Add assets
 *
 * @since 1.0.0
 */
class Assets {

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// Register global styles used in the theme.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );

		// Enqueue extension styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}

	/**
	 * Registers all styles used within the plugin
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function register_styles() {

		wp_register_style(
			'task-interface-management-styles',
			TASK_INTERFACE_MANAGEMENT_DIR_URL . 'css/admin.css',
			false,
			filemtime( TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'css/admin.css' ),
			'screen'
		);

	}

	/**
	 * Enqueues extension styles
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function enqueue_styles() {

		wp_enqueue_style( 'task-interface-management-styles' );

	}

}

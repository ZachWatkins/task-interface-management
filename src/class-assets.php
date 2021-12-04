<?php
/**
 * The file that defines the asset files loaded for the plugin.
 *
 * A class definition that includes css and js files used across both the
 * public-facing side of the site and the admin area.
 *
 * @author     Zachary Kendall Watkins <zwatkins.it@gmail.com>
 * @copyright  (c) 2021 Zachary Kendall Watkins
 * @license    GNU GPL-2.0+
 * @link       https://github.com/zachwatkins/task-interface-management/blob/master/src/class-assets.php
 * @since      1.0.1
 * @package    task-interface-management
 * @subpackage task-interface-management/src
 */

namespace Task_Interface_Management;

/**
 * Add assets
 *
 * @since 1.0.1
 */
class Assets {

	/**
	 * Initialize the class
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public function __construct() {

		// Register global styles used in the theme.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

	}

	/**
	 * Registers all styles used within the plugin
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public static function register_admin_styles() {

		wp_register_style(
			'task-interface-management-admin-styles',
			TASK_INTERFACE_MANAGEMENT_DIR_URL . 'css/admin.css',
			false,
			filemtime( TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'css/admin.css' ),
			'screen'
		);

	}

	/**
	 * Enqueues extension styles
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public static function enqueue_admin_styles() {

		wp_enqueue_style( 'task-interface-management-admin-styles' );

	}

}

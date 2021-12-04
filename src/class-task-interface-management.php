<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @author     Zachary Kendall Watkins <zwatkins.it@gmail.com>
 * @copyright  (c) 2021 Zachary Kendall Watkins
 * @license    GNU GPL-2.0+
 * @link       https://github.com/zachwatkins/task-interface-management/blob/master/src/class-task-interface-management.php
 * @since      1.0.0
 * @package    task-interface-management
 * @subpackage task-interface-management/src
 */

/**
 * The core plugin class
 *
 * @since 1.0.0
 * @return void
 */
class Task_Interface_Management {

	/**
	 * File name
	 *
	 * @var file
	 */
	private static $file = __FILE__;

	/**
	 * Instance
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		/* Activation hooks */
		register_activation_hook( TASK_INTERFACE_MANAGEMENT_DIR_FILE, array( $this, 'activation' ) );
		register_deactivation_hook( TASK_INTERFACE_MANAGEMENT_DIR_FILE, array( $this, 'deactivation' ) );

		// Assets file.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-assets.php';
		$assets = new \Task_Interface_Management\Assets();


		// Register post types.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-task-post-type.php';
		$post_type = new \Task_Interface_Management\Task_Post_Type();
		$post_type->register();
		$post_type->hooks();

	}

	/**
	 * Activation hook.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function activation() {

		// Register post types.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-task-post-type.php';
		$post_type = new \Task_Interface_Management\Task_Post_Type();
		$post_type->register_post_type();

		// Flush rewrite rules.
		flush_rewrite_rules();

		// Add user capabilities.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-user-capabilities.php';
		$new_caps = new \Task_Interface_Management\User_Capabilities();
		$new_caps->register();

	}

	/**
	 * Deactivation hook.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function deactivation() {

		// Remove user capabilities.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-user-capabilities.php';
		$new_caps = new \Task_Interface_Management\User_Capabilities();
		$new_caps->unregister();

		// Flush rewrite rules.
		flush_rewrite_rules();

	}

}

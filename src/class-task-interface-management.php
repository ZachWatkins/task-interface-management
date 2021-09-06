<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
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

		// Register post types.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-register-task-post-type.php';
		new \Task_Interface_Management\Register_Task_Post_Type();

	}

}

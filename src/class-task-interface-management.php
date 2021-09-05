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

		// Public asset files.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-assets.php';
		new \Task_Interface_Management\Assets();

		// Register post types.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-register-task-post-type.php';
		new \Task_Interface_Management\Task_Post_Type();

		// // Register settings page.
		// require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-settings-page.php';
		// $page_args      = array(
		// 	'method'    => 'add_options_page',
		// 	'title'     => 'My Settings',
		// 	'slug'      => 'plugin-name-settings',
		// 	'opt_group' => 'my_option_group',
		// 	'opt_name'  => 'my_option_name',
		// );
		// $method_args    = array(
		// 	'page_title' => 'Plugin Name',
		// 	'menu_title' => 'Plugin Name',
		// 	'capability' => 'manage_options',
		// 	'menu_slug'  => 'plugin-name-settings',
		// 	'icon_url'   => 'dashicons-portfolio',
		// 	'position'   => 0,
		// );
		// $field_sections = array(
		// 	'setting_section_id' => array(
		// 		'title'  => 'My Custom Settings',
		// 		'desc'   => 'Enter your settings below:',
		// 		'fields' => array(
		// 			array(
		// 				'id'    => 'id_number',
		// 				'title' => 'ID Number',
		// 				'type'  => 'int',
		// 			),
		// 			array(
		// 				'id'    => 'title',
		// 				'title' => 'Title',
		// 				'type'  => 'text',
		// 			),
		// 		),
		// 	),
		// );
		// new \Task_Interface_Management\Settings_Page( $page_args, $method_args, $field_sections );


	}

}

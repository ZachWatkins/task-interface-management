<?php
/**
 * Task Interface Management
 *
 * @package      Task Interface Management
 * @author       Zachary Watkins
 * @license      GPL-2.0+
 *
 * @task-interface-management
 * Plugin Name:  Task Interface Management
 * Plugin URI:   https://github.com/zachwatkins/task-interface-management
 * Description:  A task management plugin for everyone that ultimately saves time, scales, and extends.
 * Version:      1.0.0
 * Author:       Zachary Watkins
 * Author URI:   https://github.com/ZachWatkins
 * Author Email: zwatkins.it@gmail.com
 * Text Domain:  task-interface-management-textdomain
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

/* Define some useful constants */
define( 'TASK_INTERFACE_MANAGEMENT_DIRNAME', 'task-interface-management' );
define( 'TASK_INTERFACE_MANAGEMENT_TEXTDOMAIN', 'task-interface-management-textdomain' );
define( 'TASK_INTERFACE_MANAGEMENT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'TASK_INTERFACE_MANAGEMENT_DIR_FILE', __FILE__ );
define( 'TASK_INTERFACE_MANAGEMENT_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The core plugin class that is used to initialize the plugin.
 */
require TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-task-interface-management.php';
new Task_Interface_Management();

/* Activation hooks */
register_deactivation_hook( TASK_INTERFACE_MANAGEMENT_DIR_FILE, 'flush_rewrite_rules' );
register_activation_hook( TASK_INTERFACE_MANAGEMENT_DIR_FILE, 'task_interface_management_activation' );

/**
 * Helper option flag to indicate rewrite rules need flushing
 *
 * @since 1.0.0
 * @return void
 */
function task_interface_management_activation() {

	update_option( 'task_interface_management_permalinks_flushed', 0 );

}

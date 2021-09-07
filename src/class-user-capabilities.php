<?php
/**
 * The file that adds capabilities unique to this plugin to user roles.
 *
 * @link       https://github.com/zachwatkins/task-interface-management/blob/master/src/class-user-capabilities.php
 * @since      1.0.0
 * @package    task-interface-management
 * @subpackage task-interface-management/src
 */

namespace Task_Interface_Management;

/**
 * User Capabilities.
 *
 * The user capabilities class facilitates adding and removing user capabilities on plugin activation and deactivation.
 *
 * @since 1.0.0
 */
class User_Capabilities {

	/**
	 * Capabilities List.
	 *
	 * @since 1.0.0
	 * @var array $cap_list The complete list of capabilities unique to this plugin.
	 */
	private $cap_list = array(
		'manage_task_types',
		'manage_task_statuses',
		'manage_task_priorities',
		'create_tasks', // This is needed to edit others tasks for some reason.
		'read_task',
		'read_private_tasks',
		'edit_task',
		'edit_tasks',
		'edit_others_tasks',
		'edit_private_tasks',
		'edit_published_tasks', // Required to read published tasks.
		'publish_tasks', // Required for changing the task status.
		'delete_task',
		'delete_tasks',
		'delete_others_tasks',
		'delete_private_tasks',
		'delete_published_tasks',
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Register user roles.
	 *
	 * @since 1.0.0
	 *
	 * @param array $roles The user roles to register the set of capabilities for.
	 *
	 * @return void
	 */
	public function register( $roles = array(
		'administrator',
		'editor',
		'author',
		'contributor',
	) ) {

		// Add editing capability to the provided roles.
		$this->switch_access( $roles, true );

	}

	/**
	 * Switch on or off an array of user roles by user role slug.
	 *
	 * @param array $roles  User role slugs to toggle access for.
	 * @param bool  $change The state to change access to.
	 *
	 * @return void
	 */
	private function switch_access( $roles, $change ) {

		if ( true === $change ) {
			foreach ( $roles as $role ) {
				$found_role = get_role( $role );
				if ( $found_role ) {
					foreach ( $this->cap_list as $cap ) {
						$found_role->add_cap( $cap, true );
					}
				}
			}
		} else {
			foreach ( $roles as $role ) {
				$found_role = get_role( $role );
				if ( $found_role ) {
					foreach ( $this->cap_list as $cap ) {
						$found_role->remove_cap( $cap );
					}
				}
			}
		}
	}

	/**
	 * Unregister user capabilities.
	 *
	 * @since 1.0.0
	 *
	 * @param array $roles The user roles to register the set of capabilities for.
	 *
	 * @return void
	 */
	public function unregister( $roles = array(
		'administrator',
		'editor',
		'author',
		'contributor',
	) ) {

		// Remove editing capability from the provided roles.
		$this->switch_access( $roles, false );

	}
}

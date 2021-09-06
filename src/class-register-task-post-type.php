<?php
/**
 * The file that defines the Task custom post type for the plugin.
 *
 * @link       https://github.com/zachwatkins/task-interface-management/blob/master/src/class-task-post-type.php
 * @since      1.0.0
 * @package    task-interface-management
 * @subpackage task-interface-management/src
 */

namespace Task_Interface_Management;

/**
 * Add the Task custom post type.
 *
 * @since 1.0.0
 */
class Register_Task_Post_Type {

	private $post_type = 'task';

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// Add required classes.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-taxonomy.php';

		// Register_post_type.
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'maybe_flush_rewrite_rules' ) );

	}

	/**
	 * Register taxonomies associated with the Task post type.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function register_taxonomy() {

		// Register taxonomies.
		$type_tax_args = array(
			'description' => 'The scope of operations the task will be performed within.',
			'labels' => array(
				'name'         => 'Task Type',
				'search_items' => __( 'Search Task Types', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Types', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Task Types',
			),
			'default_term' => array(
				'name'        => 'General',
				'slug'        => 'general',
				'description' => 'The scope of this task will be general.',
			),
			'capabilities'      => array (
				'manage_terms' => 'manage_task_types',
				'edit_terms'   => 'manage_task_types',
				'delete_terms' => 'manage_task_types',
				'assign_terms' => 'edit_tasks',
			),
			'args' => array(
				'orderby' => 'name',
				'update_term_meta_cache' => false,
			),
			'public' => false,
			'show_ui' => true,
            'show_in_rest' => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud' => false,
			'show_admin_column' => true,
		);
		new \Task_Inerface_Management\Taxonomy(
			'Type',
			'task-type',
			$this->post_type,
			$type_tax_args
		);

		// Register taxonomies.
		$status_tax_args = array(
			'description' => 'The task\'s current status of activity.',
			'labels' => array(
				'name'         => 'Task Status',
				'search_items' => __( 'Search Task Statuses', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Statuses', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Task Statuses',
			),
			'default_term' => array(
				'name'        => 'To do',
				'slug'        => 'todo',
				'description' => 'This task has not begun.',
			),
			'capabilities'      => array (
				'manage_terms' => 'manage_task_statuses',
				'edit_terms'   => 'manage_task_statuses',
				'delete_terms' => 'manage_task_statuses',
				'assign_terms' => 'edit_tasks',
			),
			'args' => array(
				'orderby' => 'name',
				'update_term_meta_cache' => false,
			),
			'public' => false,
			'show_ui' => true,
            'show_in_rest' => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud' => false,
			'show_admin_column' => true,
		);
		new \Task_Interface_Management\Taxonomy(
			'Status',
			'task-status',
			$this->post_type,
			$status_tax_args
		);

		// Register taxonomies.
		$priority_tax_args = array(
			'description' => 'The task\'s priority level amongst other work to be done.',
			'labels' => array(
				'name'         => 'Task Priority',
				'search_items' => __( 'Search Task Priorities', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Priorities', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Task Priorities',
			),
			'default_term' => array(
				'name'        => 'Medium',
				'slug'        => 'medium',
				'description' => 'This task is of normal priority.',
			),
			'capabilities' => array (
				'manage_terms' => 'manage_task_priorities',
				'edit_terms'   => 'manage_task_priorities',
				'delete_terms' => 'manage_task_priorities',
				'assign_terms' => 'edit_tasks',
			),
			'args' => array(
				'orderby' => 'name',
				'update_term_meta_cache' => false,
			),
			'public' => false,
			'show_ui' => true,
            'show_in_rest' => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud' => false,
			'show_admin_column' => true,
		);
		new \Task_Interface_Management\Taxonomy(
			'Priority',
			'task-priority',
			$this->post_type,
			$priority_tax_args
		);

	}

	/**
	 * Initialize custom post types
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_post_type() {

		// Backend labels.
		$labels = array(
			'name'               => 'Tasks',
			'singular_name'      => 'Task',
			'add_new'            => __( 'Add New', 'task-interface-management-textdomain' ),
			'add_new_item'       => __( 'Add New Task', 'task-interface-management-textdomain' ),
			'edit_item'          => __( 'Edit Task', 'task-interface-management-textdomain' ),
			'new_item'           => __( 'New Task', 'task-interface-management-textdomain' ),
			'view_item'          => __( 'View Task', 'task-interface-management-textdomain' ),
			'search_items'       => __( 'Search Tasks', 'task-interface-management-textdomain' ),
			'not_found'          => __( 'No Tasks Found', 'task-interface-management-textdomain' ),
			'not_found_in_trash' => __( 'No Tasks found in trash', 'task-interface-management-textdomain' ),
			'parent_item_colon'  => '',
			'menu_name'          => 'Tasks',
		);

		/* Register post types */
        $args = array(
			'labels'           => $labels,
            'description'      => 'A way to record, organize, and complete work.',
            'public'           => false,
			'position'         => 0,
            'hierarchical'     => true,
            'show_ui'          => true,
            'show_in_rest'     => false, // Todo: Make this available if integrating external timekeeping apps.
            'menu_icon'        => 'dashicons-editor-ol',
            'capability_type'  => 'task',
            'map_meta_cap'     => true,
            'supports'         => array(
                'title',
                'editor',
                'comments',
                'author',
            ),
			'taxonomies'       => array(
				'task-type',
				'task-status',
				'task-priority',
			),
            'has_archive'      => true,
            'can_export'       => true,
            'delete_with_user' => false,
			'rewrite'          => array(
				'slug'       => $this->post_type,
				'with_front' => true,
				'feeds'      => false
			),
        );

		register_post_type( $this->post_type, $args );

	}

	public function maybe_flush_rewrite_rules () {
		
		// Conditionally flush rewrite rules on activation.
		if ( ! get_option( 'task_interface_management_permalinks_flushed' ) ) {

			flush_rewrite_rules( false );
			update_option( 'task_interface_management_permalinks_flushed', 1 );

		}
	}
}

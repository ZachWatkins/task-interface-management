<?php
/**
 * The file that defines the Task custom post type for the plugin.
 *
 * @author     Zachary Kendall Watkins <zwatkins.it@gmail.com>
 * @copyright  (c) 2021 Zachary Kendall Watkins
 * @license    GNU GPL-2.0+
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
class Task_Post_Type {

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Register the custom post type and taxonomies.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {

		// Register_post_type.
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );

	}

	/**
	 * The action hooks and filters needed to manage the post type.
	 *
	 * @return void
	 */
	public function hooks() {

		add_filter( 'manage_task_posts_columns', array( $this, 'add_list_view_columns' ) );
		add_action( 'manage_task_posts_custom_column', array( $this, 'output_list_view_columns' ), 10, 2 );

		// Modify the admin Task post list page query.
		add_filter( 'pre_get_posts', array( $this, 'admin_post_query' ) );

	}

	/**
	 * Register taxonomies associated with the Task post type.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_taxonomy() {

		// Add required classes.
		require_once TASK_INTERFACE_MANAGEMENT_DIR_PATH . 'src/class-taxonomy.php';

		// Register taxonomies.
		$priority_tax_args = array(
			'description'       => 'The task\'s priority level amongst other work to be done.',
			'labels'            => array(
				'name'         => 'Task Priority',
				'search_items' => __( 'Search Task Priorities', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Priorities', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Priority',
			),
			'default_term'      => array(
				'name'        => 'Medium',
				'slug'        => 'medium',
				'description' => 'This task is of normal priority.',
			),
			'capabilities'      => array(
				'manage_terms' => 'manage_task_priorities',
				'edit_terms'   => 'manage_task_priorities',
				'delete_terms' => 'manage_task_priorities',
				'assign_terms' => 'edit_tasks',
			),
			'args'              => array(
				'orderby'                => 'name',
				'update_term_meta_cache' => false,
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud'     => false,
			'show_admin_column' => true,
		);
		new \Task_Interface_Management\Taxonomy(
			'Priority',
			'task-priority',
			'task',
			$priority_tax_args,
			array(),
			'',
			true
		);

		// Register taxonomies.
		$status_tax_args = array(
			'description'       => 'The task\'s current status of activity.',
			'labels'            => array(
				'name'         => 'Task Status',
				'search_items' => __( 'Search Task Statuses', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Statuses', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Status',
			),
			'default_term'      => array(
				'name'        => 'To do',
				'slug'        => 'todo',
				'description' => 'This task has not begun.',
			),
			'capabilities'      => array(
				'manage_terms' => 'manage_task_statuses',
				'edit_terms'   => 'manage_task_statuses',
				'delete_terms' => 'manage_task_statuses',
				'assign_terms' => 'edit_tasks',
			),
			'args'              => array(
				'orderby'                => 'name',
				'update_term_meta_cache' => false,
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud'     => false,
			'show_admin_column' => true,
		);
		new \Task_Interface_Management\Taxonomy(
			'Status',
			'task-status',
			'task',
			$status_tax_args,
			array(),
			'',
			true
		);

		// Register taxonomies.
		$type_tax_args = array(
			'description'       => 'The scope of operations the task will be performed within.',
			'labels'            => array(
				'name'         => 'Task Type',
				'search_items' => __( 'Search Task Types', 'task-interface-management-textdomain' ),
				'all_items'    => __( 'All Task Types', 'task-interface-management-textdomain' ),
				'menu_name'    => 'Type',
			),
			'default_term'      => array(
				'name'        => 'General',
				'slug'        => 'general',
				'description' => 'The scope of this task will be general.',
			),
			'capabilities'      => array(
				'manage_terms' => 'manage_task_types',
				'edit_terms'   => 'manage_task_types',
				'delete_terms' => 'manage_task_types',
				'assign_terms' => 'edit_tasks',
			),
			'args'              => array(
				'orderby'                => 'name',
				'update_term_meta_cache' => false,
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => false, // Todo: Make this available if integrating external timekeeping apps.
			'show_tagcloud'     => false,
			'show_admin_column' => true,
		);
		new \Task_Interface_Management\Taxonomy(
			'Task',
			'task-type',
			'task',
			$type_tax_args,
			array(),
			'',
			true
		);

	}

	/**
	 * Initialize custom post types
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_post_type() {

		// Every supported post type label, in case we need them in the future.
		$labels = array(
			'name'                  => _x( 'Tasks', 'Post type general name', 'task-interface-management-textdomain' ),
			'singular_name'         => _x( 'Task', 'Post type singular name', 'task-interface-management-textdomain' ),
			'menu_name'             => _x( 'Tasks', 'Admin Menu text', 'task-interface-management-textdomain' ),
			'name_admin_bar'        => _x( 'Task', 'Add New on Toolbar', 'task-interface-management-textdomain' ),
			'add_new'               => __( 'Add New', 'task-interface-management-textdomain' ),
			'add_new_item'          => __( 'Add New Task', 'task-interface-management-textdomain' ),
			'new_item'              => __( 'New Task', 'task-interface-management-textdomain' ),
			'edit_item'             => __( 'Edit Task', 'task-interface-management-textdomain' ),
			'view_item'             => __( 'View Task', 'task-interface-management-textdomain' ),
			'all_items'             => __( 'All Tasks', 'task-interface-management-textdomain' ),
			'search_items'          => __( 'Search Tasks', 'task-interface-management-textdomain' ),
			'parent_item_colon'     => __( 'Parent Tasks:', 'task-interface-management-textdomain' ),
			'not_found'             => __( 'No tasks found.', 'task-interface-management-textdomain' ),
			'not_found_in_trash'    => __( 'No tasks found in Trash.', 'task-interface-management-textdomain' ),
			'featured_image'        => _x( 'Task Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'task-interface-management-textdomain' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'task-interface-management-textdomain' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'task-interface-management-textdomain' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'task-interface-management-textdomain' ),
			'archives'              => _x( 'Task archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'task-interface-management-textdomain' ),
			'insert_into_item'      => _x( 'Insert into task', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'task-interface-management-textdomain' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this task', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'task-interface-management-textdomain' ),
			'filter_items_list'     => _x( 'Filter tasks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'task-interface-management-textdomain' ),
			'items_list_navigation' => _x( 'Tasks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'task-interface-management-textdomain' ),
			'items_list'            => _x( 'Tasks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'task-interface-management-textdomain' ),
		);

		/* Register post type */
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
				'author',
				'custom-fields',
				'page-attributes',
			),
			'taxonomies'       => array(
				'task-priority',
				'task-status',
				'task-type',
			),
			'has_archive'      => true,
			'can_export'       => true,
			'delete_with_user' => false,
			'rewrite'          => array(
				'slug'       => 'task',
				'with_front' => true,
				'feeds'      => false,
			),
		);

		register_post_type( 'task', $args );

	}

	/**
	 * Add columns to the list view for posts.
	 *
	 * @since 1.0.1
	 *
	 * @param array $columns The current set of columns.
	 *
	 * @return array
	 */
	public function add_list_view_columns( $columns ) {

		if ( array_key_exists( 'author', $columns, true ) ) {
			$columns['author'] = __( 'Submitted By', 'task-interface-management-textdomain' );
		}

		// Insert the Menu Order column after the checkbox column.
		$first = array_slice( $columns, 0, 1 );
		$first['menu_order'] = __( 'Order', 'task-interface-management-textdomain' );
		array_shift( $columns );
		$columns = array_merge( $first, $columns );

		// Change column titles.
		$columns['author'] = __( 'Created by', 'task-interface-management-textdomain' );
		$columns['taxonomy-task-priority'] = __( 'Priority', 'task-interface-management-textdomain' );
		$columns['taxonomy-task-status'] = __( 'Status', 'task-interface-management-textdomain' );
		$columns['taxonomy-task-type'] = __( 'Type', 'task-interface-management-textdomain' );
		$columns['date'] = __( 'Created', 'task-interface-management-textdomain' );

		return $columns;

	}

	/**
	 * Add columns to order post list view.
	 *
	 * @param string $column_name The currently handled column name.
	 * @param int    $post_id     The current post ID.
	 */
	public function output_list_view_columns( $column_name, $post_id ) {

		global $post;

		switch ( $column_name ) {
			case 'menu_order':
				$order = $post->menu_order;
				if ( $order === 0 ) {
					$order = '';
				}
				echo $order;
				break;
			default:
				break;
		}

	}

	/**
	 * Sortable order column.
	 *
	 * @since 1.0.1
	 *
	 * @param array $columns The columns in this post type.
	 *
	 * @return array
	 */
	function order_column_register_sortable( $columns ) {

	  $columns['menu_order'] = 'menu_order';

	  return $columns;

	}

	/**
	 * Sort the Task posts by certain parameters by default in admin.
	 *
	 * @since 1.0.1
	 *
	 * @param WP_Query $wp_query The WP_Query object.
	 *
	 * @return WP_Query
	 */
	public function admin_post_query( $wp_query ){
		if ( ! is_admin() && 'task' !== $wp_query->get('post_type') && ! $wp_query->is_main_query() ) {
			return;
		}
		return $wp_query;
	}
}

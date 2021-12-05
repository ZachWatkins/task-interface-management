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

namespace Task_Interface_Management\Post;

/**
 * Add the Task custom post type.
 *
 * @since 1.0.0
 */
class Status {

	private $params = array(
		'post_type'    => 'task',
		'status_slug'  => 'task-complete',
		'status_label' => 'Complete',
	);

	public function __construct() {
		  
		add_action( 'init', array( $this, 'task_post_status' ) );
		
		// Restrict the post status to "Private" and "Complete".
		add_action( 'wp_insert_post', array( $this, 'manage_post_status' ), 11, 2 );
		  
		// Hide the admin post visibility option.
		add_action('current_screen', array( $this, 'wpseCurrentScreenAction' ) );

		// Shim in the post status content into the editor UI.
		add_action( 'post_submitbox_misc_actions', array( $this, 'post_status_add_to_dropdown' ) );

	}
	
	// Register Post Status: completedtask
	public function task_post_status() {

		register_post_status( $this->params['status_slug'], array(
			'label'                     => _x( 'Completed Task', 'task-interface-management' ),
			'label_count'               => _n_noop( 'Completed Task (%s)',  'Completed Tasks (%s)', 'task-interface-management' ),
			'public'                    => false,
			'internal'       			=> true,
			'private'       			=> true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => true,
		) );

	}

	/**
	 * Change the post status to switch between Completed or Private..
	 * Fires once a post, its terms and meta data has been saved.
	 * 
     * @param int          $post_id     Post ID.
     * @param WP_Post      $post        Post object.
	 * 
	 * @return void
	 */
	public function manage_post_status( $post_id, $post ) {

		$has_completed_term   = false;
		$has_completed_status = false !== strpos( $post->post_status, 'complete' ) ? true : false;

		$status_terms = get_the_terms( $post_id, 'task-status' );

		foreach ( $status_terms as $term ) {
			if ( false !== strpos( $term->slug, 'complete' ) ) {
				$has_completed_term = true;
				break;
			}
		}

		if ( $has_completed_term && ! $has_completed_status ) {

			remove_action( 'wp_insert_post', array( $this, 'manage_post_status' ) );
			wp_update_post(array(
				'ID'          => $post_id,
				'post_status' => 'task-complete'
			));
			add_action( 'wp_insert_post', array( $this, 'manage_post_status' ) );

		} elseif ( ! $has_completed_term || in_array( $post->post_status, array( 'private', 'draft' ), true ) ) {

			remove_action( 'wp_insert_post', array( $this, 'manage_post_status' ) );
			wp_update_post(array(
				'ID'          => $post_id,
				'post_status' => 'private'
			));
			add_action( 'wp_insert_post', array( $this, 'manage_post_status' ) );

		}

	}
		  
	public function wpseCurrentScreenAction( $current_screen ) {
		
		if ( 'task' == $current_screen->post_type && 'post' == $current_screen->base ) {

			add_action( 'admin_head', array( $this, 'wpseNoVisibility' ) );

		}

	}
	
	public function wpseNoVisibility() {

		echo '<style>div#visibility.misc-pub-section.misc-pub-visibility{display:none}</style>';

	}

	/**
	 * Add HTML for custom post statuses.
	 *
	 * @return void
	 */
	public function post_status_add_to_dropdown() {

		global $post;
		if ( $this->params['post_type'] !== $post->post_type ) {
			return;
		}

		$status = '';
		switch ( $post->post_status ) {
			case $this->params['status_slug']:
				$status = "jQuery( '#post-status-display' ).text( 'Complete' );
jQuery( 'select[name=\"post_status\"]' ).val('complete')";
				break;

			case 'publish':
				$status = "jQuery( '#post-status-display' ).text( 'Private' );
jQuery( 'select[name=\"post_status\"]' ).val('private')";
				break;

			default:
				break;
		}

		echo wp_kses(
			"<script>
			jQuery(document).ready( function() {
				jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"complete\">Complete</option>' );
				" . $status . "
			});
		</script>",
			array(
				'script' => array(),
				'option' => array(
					'value'    => array(),
					'disabled' => array(),
				),
			)
		);
	}
}
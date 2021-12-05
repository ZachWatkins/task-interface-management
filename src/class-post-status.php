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
		'domain'       => 'default',
		'context'      => 'backend',
		'replacements' => array(
			'Publish' => 'Complete',
			'Publish' => 'Complete',
		),
	);

	public function __construct() {

		// add_action( 'init', array( $this, 'task_post_status' ) );
		add_action( 'wp_insert_post', array( $this, 'manage_post_status' ), 11, 2 );

		// Shim in the post status content into the editor UI.
		add_action( 'post_submitbox_misc_actions', array( $this, 'post_status_add_to_dropdown' ) );

		// Replace "Publish" text in button with "Complete".
		add_filter( 'gettext', array( $this, 'translate_publish_button' ), 10, 3 );

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
	 * Change the post status to add or remove the Completed status.
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
		error_log( intval( $has_completed_term ), 0, 'PHP_ERROR_LOG' );

		if ( $has_completed_term && ! $has_completed_status ) {
			wp_update_post(array(
				'ID'          => $post_id,
				'post_status' => $this->params['status_slug']
			));
		} elseif ( ! $has_completed_term && $has_completed_status ) {
			wp_update_post(array(
				'ID'          => $post_id,
				'post_status' => 'private'
			));
		}

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
				$status = "jQuery( '#post-status-display' ).text( '{$this->params['status_label']}' );
jQuery( 'select[name=\"post_status\"]' ).val('{$this->params['status_slug']}')";
				break;

			case 'publish':
				$status = "jQuery( '#post-status-display' ).text( 'Published' );
jQuery( 'select[name=\"post_status\"]' ).val('publish')";
				break;

			default:
				break;
		}

		echo wp_kses(
			"<script>
			jQuery(document).ready( function() {
				jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"{$this->params['status_slug']}\">{$this->params['status_label']}</option>' );
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

    /**
     * The real working code.
     * 
     * @param  string $translated
     * @param  string $original
     * @param  string $domain
	 * 
     * @return string
     */
    public function translate_publish_button( $translated, $original, $domain ) {

		global $current_screen;
		if ( 'post' !== $current_screen->base && $domain !== $this->params['domain'] ) {
			return $translated;
		}
		
        // exit early
        if ( 'backend' === $this->params['context'] ) {
			global $post_type;
			
            if ( ! empty( $post_type ) && $post_type !== $this->params['post_type'] ) {
				return $translated;
            }
        }

        if ( $this->params['domain'] !== $domain ) {
			return $translated;
        }
		
        // Finally replace
		return strtr( $original, $this->params['replacements'] );

    }
}
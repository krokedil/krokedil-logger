<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Krokedil_Logger {
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		$this->register_post_type();
		$this->set_defines();
		$this->include_files();
	}

	public function register_post_type() {
		register_post_status( 'krokedil-log', array(
			'label'                     => 'Krokedil Logs',
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => false,
			'label_count'               => _n_noop( 'Krokedil Logs <span class="count">(%s)</span>', 'Krokedil Logs <span class="count">(%s)</span>' ),
		) );
	}

	public function set_defines() {
		
	}

	public function include_files() {
		require_once '/classes/class-krokedil-log.php';
	}

	/**
	 * Creates a log object
	 *
	 * @return log object
	 */ 
	public function create_log() {
		$log = new Krokedil_Log( $id );
		WC()->session->set( 'krokedil_log', $log );
		return $log;
	}
	
	/**
	 * Gets a log object from id
	 *
	 * @return log object
	 */
	public function get_log( $id ) {
		$log = new Krokedil_Log( $id );
		return $log;
	}

	/**
	 * Gets all log ids
	 *
	 * @return array object
	 */
	public function get_all_logs() {
		$query = new WP_Query( array(
			'post_type'      => 'krokedil-log',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		) );
		
		return $query;
	}
} new Krokedil_Logger;

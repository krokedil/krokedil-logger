<?php
/**
 * Krokedil Logger main file
 * Version 2.0
 *
 * @package Krokedil_Logger
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'Krokedil_Logger' ) ) {
	/**
	 * Krokedil Logger Class
	 */
	class Krokedil_Logger {
		/**
		 * Class constructor
		 */
		public function __construct() {
			$this->init();
			add_action( 'init', array( $this, 'register_post_type_krokedil_log' ) );
		}

		/**
		 * Initiate the plugin
		 */
		public function init() {
			$this->include_files();
			$this->set_defines();
		}

		/**
		 * Registers the post type krokedil-log
		 */
		public function register_post_type_krokedil_log() {
			register_post_type( 'krokedil-log', array(
				'label'               => 'Krokedil Log',
				'public'              => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_ui'             => false,
				'show_in_menu'        => false,
				'has_archive'         => false,
				'rewrite'             => true,
				'query_var'           => true,
			) );
		}

		/**
		 * Sets needed definitions
		 */
		public function set_defines() {
			define( 'KROKEDIL_LOGGER_VERSION', '2.0' );
		}

		/**
		 * Includes needed files
		 */
		public function include_files() {
			include_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/classes/class-krokedil-log.php';
			include_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/classes/class-krokedil-logger-page.php';
		}

		/**
		 * Maybe create log
		 *
		 * @param string $title The title of the log.
		 *
		 * @return array Log Array.
		 */
		public function maybe_create_log( $title ) {
			if ( WC()->session->get( 'krokedil_logs' ) ) {
				$logs = WC()->session->get( 'krokedil_logs' );
				foreach ( $logs as $log ) {
					if ( $log->get_log_title() === $title ) {
						$log = $this->get_log( $log->get_log_id() );
						$log->set_log_title( $title );
						return $log;
					}
				}
				$log = $this->create_log( $title );
				return $log;
			} else {
				$log = $this->create_log( $title );
				return $log;
			}
		}

		/**
		 * Creates a log object
		 *
		 * @param string $title Log title.
		 *
		 * @return object log object
		 */
		public function create_log( $title ) {
			$log = new Krokedil_Log();
			$log->set_log_title( $title );
			$logs   = ( WC()->session->get( 'krokedil_logs' ) ) ? WC()->session->get( 'krokedil_logs' ) : array();
			$logs[] = $log;
			WC()->session->set( 'krokedil_logs', $logs );
			return $log;
		}

		/**
		 * Gets a log object from id
		 *
		 * @param int $id The post ID.
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

		/**
		 * Sets order ID to logs objects.
		 *
		 * @param int $order_id WooCommerce order ID.
		 */
		public function set_order_id( $order_id ) {
			$logs = WC()->session->get( 'krokedil_logs' );
			foreach ( $logs as $log ) {
				$log = $this->get_log( $log->get_log_id() );
				$log->set_order_id( $order_id );
			}
			WC()->session->__unset( 'krokedil_logs' );
		}
	} new Krokedil_Logger();
}

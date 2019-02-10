<?php
/**
 * Krokedil Logger for WooCommerce
 *
 * @package Krokedil_Logger
 *
 * @wordpress-plugin
 * Plugin Name:             Krokedil Logger for WooCommerce
 * Plugin URI:              https://krokedil.se/
 * Description:             Provides a logging tool for Krokedils Plugins
 * Version:                 2.0.0
 * Author:                  Krokedil
 * Author URI:              https://krokedil.se/
 * Developer:               Krokedil
 * Developer URI:           https://krokedil.se/
 * Text Domain:             krokedil-logger-for-woocommerce
 * Domain Path:             /languages
 * WC requires at least:    3.0.0
 * WC tested up to:         3.4.7
 * Copyright:               © 2017-2018 Krokedil Produktionsbyrå AB.
 * License:                 GNU General Public License v3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.html
 */

define( 'KROKEDIL_LOGGER_VERSION', '2.0.0' );
define( 'KROKEDIL_LOGGER_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'KROKEDIL_ALLOWED_GATEWAYS', array(
	'dibs_easy'      => '_dibs_payment_id',
	'paysoncheckout' => '_paysoncheckout_payment_id',
) );


if ( ! class_exists( 'Krokedil_Logger' ) ) {
	class Krokedil_Logger {
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'include_files' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
			add_action( 'woocommerce_admin_status_content_krokedil_log', array( $this, 'krokedil_status_log' ) );

			add_filter( 'woocommerce_admin_status_tabs', array( $this, 'add_status_tab' ) );
		}

		public function load_admin_scripts() {
			wp_register_script(
				'krokedil_event_log',
				plugins_url( 'assets/js/krokedil-event-log.js', __FILE__ ),
				array( 'jquery' ),
				KROKEDIL_LOGGER_VERSION
			);
			$params = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( 'krokedil_event_log', 'krokedil_event_log_params', $params );
			wp_enqueue_script( 'krokedil_event_log' );
			wp_register_script(
				'render_json',
				plugins_url( 'assets/js/renderjson.js', __FILE__ ),
				array( 'jquery' ),
				KROKEDIL_LOGGER_VERSION
			);
			$params = array();
			wp_localize_script( 'render_json', 'render_json_params', $params );
			wp_enqueue_script( 'render_json' );
			wp_register_style(
				'krokedil_events_style',
				plugin_dir_url( __FILE__ ) . 'assets/css/krokedil-event-log.css',
				array(),
				KROKEDIL_LOGGER_VERSION
			);
			wp_enqueue_style( 'krokedil_events_style' );
		}

		public function include_files() {
			require_once KROKEDIL_LOGGER_PLUGIN_PATH . '/classes/class-krokedil-logger-display-logs.php';
		}

		public function add_status_tab( $tabs ) {
			$tabs['krokedil_log'] = __( 'Krokedil Logs', 'krokedil-logger-for-woocommerce' );

			return $tabs;
		}

		public function krokedil_status_log() {
			// Get log files.
			$logs          = WC_Log_Handler_File::get_log_files();
			$filtered_logs = array();
			foreach ( $logs as $log_key => $log_name ) {
				foreach ( KROKEDIL_ALLOWED_GATEWAYS as $key => $value ) {
					if ( 0 === strpos( $log_name, $key ) ) {
						$filtered_logs[ $log_key ] = $log_name;
					}
				}
			}

			if ( ! empty( $_REQUEST['log_file'] ) && isset( $filtered_logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ] ) ) { // WPCS: input var ok, CSRF ok.
				$viewed_log = $filtered_logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ]; // WPCS: input var ok, CSRF ok.
			} elseif ( ! empty( $filtered_logs ) ) {
				$viewed_log = current( $filtered_logs );
			}
			$handle = ! empty( $viewed_log ) ? WC_Admin_Status::get_log_file_handle( $viewed_log ) : '';
			if ( ! empty( $_REQUEST['handle'] ) ) { // WPCS: input var ok, CSRF ok.
				self::remove_log();
			}

			include_once 'views/html-krokedil-logger.php';
		}
	} new Krokedil_Logger();
}

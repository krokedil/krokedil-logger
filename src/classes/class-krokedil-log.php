<?php
/**
 * Krokedil Log
 *
 * @package Krokedil_Log
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Krokedil Log object class.
 */
class Krokedil_Log {
	/**
	 * The Logs ID
	 *
	 * @var $log_id
	 */
	protected $log_id;

	/**
	 * The logged request.
	 *
	 * @var $log_request
	 */
	protected $log_request;

	/**
	 * The logged response.
	 *
	 * @var $log_response
	 */
	protected $log_response;

	/**
	 * The logs plugin reference.
	 *
	 * @var $log_plugin_reference
	 */
	protected $log_plugin_reference;

	/**
	 * The logs title.
	 *
	 * @var $log_title
	 */
	protected $log_title;

	/**
	 * The logs order ID
	 *
	 * @var $log_order_id
	 */
	protected $log_order_id;

	/**
	 * Class constructor
	 *
	 * @param int $id The WordPress post id.
	 */
	public function __construct( $id = 0 ) {
		if ( 0 === $id ) {
			$this->create_log();
			return $this;
		} else {
			$this->set_log_id( $id );
			$this->get_log_request();
			$this->get_log_response();
			$this->get_log_plugin_reference();
			$this->get_log_order_id();
		}
	}

	/**
	 * Creates a log object
	 */
	public function create_log() {
		$postarr      = array(
			'post_type' => 'krokedil-log',
		);
		$id           = wp_insert_post( $postarr );
		$this->log_id = $id;
	}

	/**
	 * Set the value of log_id
	 *
	 * @param int $log_id The WordPress post ID for the log.
	 *
	 * @return  self
	 */
	public function set_log_id( $log_id ) {
		$this->log_id = $log_id;

		return $this;
	}

	/**
	 * Set the value of log_request
	 *
	 * @param string $log_request JSON string from a request.
	 *
	 * @return  self
	 */
	public function set_log_request( $log_request ) {
		update_post_meta( $this->log_id, '_krokedil_log_request', $log_request );
		$this->log_request = $log_request;

		return $this;
	}

	/**
	 * Set the value of log_response
	 *
	 * @param string $log_response JSON string from a response.
	 *
	 * @return  self
	 */
	public function set_log_response( $log_response ) {
		update_post_meta( $this->log_id, '_krokedil_log_response', $log_response );
		$this->log_response = $log_response;

		return $this;
	}

	/**
	 * Set the value of log_plugin_reference
	 *
	 * @param string $log_plugin_reference The individual plugins reference number.
	 *
	 * @return  self
	 */
	public function set_log_plugin_reference( $log_plugin_reference ) {
		update_post_meta( $this->log_id, '_krokedil_log_plugin_reference', $log_plugin_reference );
		$this->log_plugin_reference = $log_plugin_reference;

		return $this;
	}

	/**
	 * Set the value of log_title
	 *
	 * @param string $log_title The title of the log.
	 *
	 * @return  self
	 */
	public function set_log_title( $log_title ) {
		update_post_meta( $this->log_id, '_krokedil_log_title', $log_title );
		$this->log_title = $log_title;

		return $this;
	}

	/**
	 * Set the value of log_order_id
	 *
	 * @param int $log_order_id The WooCommerce order ID.
	 *
	 * @return  self
	 */
	public function set_log_order_id( $log_order_id ) {
		update_post_meta( $this->log_id, '_krokedil_log_order_id', $log_order_id );
		$this->log_order_id = $log_order_id;

		return $this;
	}

	/**
	 * Get the value of log_id
	 */
	public function get_log_id() {
		return $this->log_id;
	}

	/**
	 * Get the value of log_request
	 */
	public function get_log_request() {
		$this->log_request = get_post_meta( $this->log_id, '_krokedil_log_request', true );
		return $this->log_request;
	}

	/**
	 * Get the value of log_response
	 */
	public function get_log_response() {
		$this->log_response = get_post_meta( $this->log_id, '_krokedil_log_response', true );
		return $this->log_response;
	}

	/**
	 * Get the value of log_plugin_reference
	 */
	public function get_log_plugin_reference() {
		$this->log_plugin_reference = get_post_meta( $this->log_id, '_krokedil_log_plugin_reference', true );
		return $this->log_plugin_reference;
	}

	/**
	 * Get the value of log_title
	 */
	public function get_log_title() {
		$this->log_title = get_post_meta( $this->log_id, '_krokedil_log_title', true );
		return $this->log_title;
	}

	/**
	 * Get the value of log_order_id
	 */
	public function get_log_order_id() {
		$this->log_order_id = get_post_meta( $this->log_id, '_krokedil_log_order_id', true );
		return $this->log_order_id;
	}
}
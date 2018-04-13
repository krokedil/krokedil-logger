<?php

class Krokedil_Log {
	protected $log_id;

	protected $log_request;
	
	protected $log_response;

	protected $log_plugin_reference;

	protected $log_title;

	protected $log_order_id;

	public function __construct( $id = 0 )
	{
		if ( 0 !== $id ) {
			return $this->create_log();
		} else {
			$this->set_log_id( $id );
			$this->get_log_request();
			$this->get_log_response();
			$this->get_log_plugin_reference();
			$this->get_log_order_id();
		}
	}

	public function create_log() {
		$postarr = array(
			'post_type' => 'krokedil-log',
		);
		$id           = wp_insert_post( $postarr );
		$this->log_id = $id;
	}

	/**
	 * Set the value of log_id
	 *
	 * @return  self
	 */ 
	public function set_log_id( $log_id )
	{
		$this->log_id = $log_id;

		return $this;
	}

	/**
	 * Set the value of log_request
	 *
	 * @return  self
	 */ 
	public function set_log_request( $log_request )
	{
		update_post_meta( $this->log_id, '_krokedil_log_request', $log_request );
		$this->log_request = $log_request;

		return $this;
	}

	/**
	 * Set the value of log_response
	 *
	 * @return  self
	 */ 
	public function set_log_response( $log_response )
	{
		update_post_meta( $this->log_id, '_krokedil_log_response', $log_response );
		$this->log_response = $log_response;

		return $this;
	}

	/**
	 * Set the value of log_plugin_reference
	 *
	 * @return  self
	 */ 
	public function set_log_plugin_reference( $log_plugin_reference )
	{
		update_post_meta( $this->log_id, '_krokedil_log_plugin_reference', $log_plugin_reference );
		$this->log_plugin_reference = $log_plugin_reference;

		return $this;
	}

	/**
	 * Set the value of log_title
	 *
	 * @return  self
	 */ 
	public function set_log_title( $log_title )
	{
		update_post_meta( $this->log_id, '_krokedil_log_title', $log_title );
		$this->log_title = $log_title;

		return $this;
	}

	/**
	 * Set the value of log_order_id
	 *
	 * @return  self
	 */ 
	public function set_log_order_id( $log_order_id )
	{
		update_post_meta( $this->log_id, '_krokedil_log_order_id', $log_order_id );
		$this->log_order_id = $log_order_id;

		return $this;
	}

	/**
	 * Get the value of log_id
	 */ 
	public function get_log_id()
	{
		return $this->log_id;
	}

	/**
	 * Get the value of log_request
	 */ 
	public function get_log_request()
	{
		$this->log_request = get_post_meta( $this->log_id, '_krokedil_log_request' );
		return $this->log_request;
	}

	/**
	 * Get the value of log_response
	 */ 
	public function get_log_response()
	{
		$this->log_response = get_post_meta( $this->log_id, '_krokedil_log_response' );
		return $this->log_response;
	}

	/**
	 * Get the value of log_plugin_reference
	 */ 
	public function get_log_plugin_reference()
	{
		$this->log_plugin_reference = get_post_meta( $this->log_id, '_krokedil_log_reference' );
		return $this->log_plugin_reference;
	}

	/**
	 * Get the value of log_title
	 */ 
	public function get_log_title()
	{
		$this->log_title = get_post_meta( $this->log_id, '_krokedil_log_title' );
		return $this->log_title;
	}

	/**
	 * Get the value of log_order_id
	 */ 
	public function get_log_order_id()
	{
		$this->log_order_id = get_post_meta( $this->log_id, '_krokedil_log_order_id' );
		return $this->log_order_id;
	}
}
<?php

class Krokedil_Create_Log {
	public $id       = null;
	public $request  = null;
	public $response = null;
	public $code     = null;
	public $title    = null;
	public $type     = null;

	public function create_log() {
		global $krokedil_plugin_version;
		$log = array(
			'id'             => $this->id,
			'type'           => $this->type,
			'title'          => $this->title,
			'request'        => $this->request,
			'response'       => array(
				'body' => $this->response,
				'code' => $this->code,
			),
			'timestamp'      => date( 'Y-m-d H:i:s' ),
			'plugin_version' => $krokedil_plugin_version,
			'wc_version'     => defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null,
		);

		$log = $this->format_log( $log );

		$this->save_log( json_encode( $log ) );
	}

	public function format_log( $log ) {
		if ( isset( $log['request']['body'] ) ) {
			$request_body           = json_decode( $log['request']['body'], true );
			$log['request']['body'] = $request_body;
		}

		return $log;
	}

	public function save_log( $log ) {
		global $krokedil_plugin_id;
		$wc_log = new WC_Logger();
		$wc_log->add( $krokedil_plugin_id, $log );
	}

	public function set_id( $id ) {
		$this->id = $id;
	}

	public function set_request( $request ) {
		$this->request = $request;
	}

	public function set_response( $response ) {
		$this->response = $response;
	}

	public function set_code( $code ) {
		$this->code = $code;
	}

	public function set_title( $title ) {
		$this->title = $title;
	}

	public function set_type( $type ) {
		$this->type = $type;
	}
}

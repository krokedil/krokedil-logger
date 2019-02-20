<?php
class Krokedil_Logger_Display_Logs {
	public $id_field;

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}

	public function add_meta_box( $post_type ) {
		global $krokedil_plugin_id;
		if ( 'shop_order' === $post_type ) {
			$order_id = get_the_ID();
			$order    = wc_get_order( $order_id );
			foreach ( KROKEDIL_ALLOWED_GATEWAYS as $gateway_id => $id_field ) {
				if ( false !== strpos( $order->get_payment_method(), $gateway_id ) ) {
					$this->id_field = $id_field;
					add_meta_box( 'krokedil_log', __( 'Events', 'krokedil-for-woocommerce' ), array( $this, 'meta_box_contents' ), 'shop_order', 'normal', 'core' );
				}
			}
		}
	}

	public function meta_box_contents() {
		$order_id   = get_the_ID();
		$logs       = $this->get_logs();
		$order_logs = $this->extract_logs_for_order( $logs, get_post_meta( $order_id, $this->id_field, true ) );
		$i          = 0;
		foreach ( $order_logs as $log ) {
			$i++;
			$this->display_log( $log, $i );
		}
	}

	public function extract_logs_for_order( $logs, $id ) {
		$return_logs = array();
		foreach ( $logs as $daily_logs ) {
			foreach ( $daily_logs as $logs ) {
				foreach ( $logs as $log ) {
					$log = json_decode( $log, true );
					if ( $id == $log['id'] ) {
						$return_logs[] = $log;
					}
				}
			}
		}
		return $return_logs;
	}

	public function get_logs() {
		$logs      = array();
		$log_files = WC_Log_Handler_File::get_log_files();
		foreach ( $log_files as $log_file ) {
			if ( false !== strpos( $log_file, get_post_meta( get_the_ID(), '_payment_method', true ) ) ) {
				$file_path = realpath( trailingslashit( WC_LOG_DIR ) . $log_file );
				$file      = fopen( $file_path, 'r' );
				$text      = fread( $file, filesize( $file_path ) );
				$pattern   = '/\{(?:[^{}]|(?R))*\}/x';

				preg_match_all( $pattern, $text, $matches );
				$logs[] = $matches;
			}
		}
		return $logs;
	}

	public function get_logs_from_file_name( $file_name ) {
		$logs      = array();
		$file_path = realpath( trailingslashit( WC_LOG_DIR ) . $file_name );
		$file      = fopen( $file_path, 'r' );
		$text      = fread( $file, filesize( $file_path ) );
		$pattern   = '/\{(?:[^{}]|(?R))*\}/x';

		preg_match_all( $pattern, $text, $logs );
		$i = 0;
		foreach ( $logs[0] as $log ) {
			$log = json_decode( $log, true );
			$i++;
			$this->display_log( $log, $i );
		}
	}

	public function display_log( $log, $i ) {
		?>
		<div class="krokedil_event">
			<div class="krokedil_event_header"> 
				<h4><?php echo $log['id'] . ' - ' . $log['title']; ?></h4>
				<h5 class="krokedil_timestamp" data-event-nr="<?php echo $i; ?>"><a href="#krokedil_event_nr_<?php echo $i; ?>">Time: <?php echo $log['timestamp']; ?></a></h5>
			</div>
			<div class="krokedil_event_tab_content krokedil_hidden" id="krokedil_event_nr_<?php echo $i; ?>">
				<div class="krokedil_tabs">
					<div class="krokedil_tab krokedil_request_tab krokedil_active_tab" data-event-nr="<?php echo $i; ?>">Request</div>
					<div class="krokedil_tab krokedil_response_tab krokedil_code_<?php echo substr( $log['response']['code'], 0, 1 ); ?>" data-event-nr="<?php echo $i; ?>">Response: <?php echo $log['response']['code']; ?></div>
					<button class="krokedil_copy_json" id="krokedil_copy_json_<?php echo $i; ?>" type="button" data-event-nr="<?php echo $i; ?>" data-event-type="request"><span class="krokedil-dashicon dashicons dashicons-admin-page"></span></button>
				</div>
				<div class="krokedil_event_tab krokedil_active_data_tab krokedil_event_request krokedil_json" data-event-nr="<?php echo $i; ?>">
					<?php echo json_encode( $log['request'] ); ?>
				</div>
				<div class="krokedil_event_request_raw" id="krokedil_request_raw_<?php echo $i; ?>" style="display:none" data-event-nr="<?php echo $i; ?>">
					<?php echo json_encode( $log['request'] ); ?>
				</div>
				<div class="krokedil_event_tab krokedil_event_response krokedil_json" data-event-nr="<?php echo $i; ?>">
					<?php echo json_encode( $log['response']['body'] ); ?>
				</div>
				<div class="krokedil_event_response_raw" id="krokedil_response_raw_<?php echo $i; ?>" style="display:none" data-event-nr="<?php echo $i; ?>">
					<?php echo json_encode( $log['response']['body'] ); ?>
				</div>
			</div>
		</div>
		<?php
	}
} new Krokedil_Logger_Display_Logs();

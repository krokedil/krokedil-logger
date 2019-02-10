<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( $filtered_logs ) : ?>
	<div id="log-viewer-select">
		<div class="alignleft">
			<h2>
				<?php echo esc_html( $viewed_log ); ?>
				<?php if ( ! empty( $viewed_log ) ) : ?>
					<a class="page-title-action" href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'handle' => sanitize_title( $viewed_log ) ), admin_url( 'admin.php?page=wc-status&tab=logs' ) ), 'remove_log' ) ); ?>" class="button"><?php esc_html_e( 'Delete log', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</h2>
		</div>
		<div class="alignright">
			<form action="<?php echo esc_url( admin_url( 'admin.php?page=wc-status&tab=krokedil_log' ) ); ?>" method="post">
				<select name="log_file">
					<?php foreach ( $filtered_logs as $log_key => $log_file ) : ?>
						<?php
							$timestamp = filemtime( WC_LOG_DIR . $log_file );
							/* translators: 1: last access date 2: last access time */
							$date = sprintf( __( '%1$s at %2$s', 'woocommerce' ), date_i18n( wc_date_format(), $timestamp ), date_i18n( wc_time_format(), $timestamp ) );
						?>
						<option value="<?php echo esc_attr( $log_key ); ?>" <?php selected( sanitize_title( $viewed_log ), $log_key ); ?>><?php echo esc_html( $log_file ); ?> (<?php echo esc_html( $date ); ?>)</option>
					<?php endforeach; ?>
				</select>
				<button type="submit" class="button" value="<?php esc_attr_e( 'View', 'woocommerce' ); ?>"><?php esc_html_e( 'View', 'woocommerce' ); ?></button>
			</form>
		</div>
		<div class="clear"></div>
	</div>
	<div id="log-viewer">
		<?php
			$display_logs = new Krokedil_Logger_Display_Logs();
			$display_logs->get_logs_from_file_name( $viewed_log );
		?>
	</div>
<?php else : ?>
	<div class="updated woocommerce-message inline"><p><?php esc_html_e( 'There are currently no logs to view.', 'woocommerce' ); ?></p></div>
<?php endif; ?>

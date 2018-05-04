<?php
/**
 * Krokedil Logger Page
 *
 * @package Krokedil_Logger_Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The class for the Krokedil Logger page.
 */
class Krokedil_Logger_Page {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_krokedil_logger_page' ) );
	}

	/**
	 * Adds page to WooCommerce admin list.
	 */
	public function add_krokedil_logger_page() {
		add_menu_page(
			__( 'Krokedil Loggs', 'krokedil-logger' ),
			__( 'Krokedil Loggs', 'krokedil-logger' ),
			'view_krokedil_loggs',
			'krokedil-logger',
			array( $this, 'krokedil_logger_page' )
		);
	}

	/**
	 * Output for the page.
	 */
	public function krokedil_logger_page() {
		echo '<h3>Hello World!</h3>';
	}
} new Krokedil_Logger_Page();

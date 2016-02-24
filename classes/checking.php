<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BEA_SWP_Checking {

	/**
	 * admin_init hook callback
	 *
	 * @since 0.1
	 */
	public static function admin_init() {
		// Not on ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		// Check activation
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( function_exists( 'SWP' ) ) {
			return false;
		}

		// Deactive self
		deactivate_plugins( BEA_SWPIE_DIR . 'searchwp-import-export.php' );
		unset( $_GET['activate'] );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}
	/**
	 * Notify the user about the incompatibility issue.
	 */
	public static function admin_notices() {
		echo '<div class="notice error is-dismissible">';
		echo '<p>' . sprintf( __( 'Plugin Boilerplate require SearchWP plugin to be activated. Please <a href="%s">Install and/or activate it</a>', 'bea-swp-ieSWP' ), admin_url( 'plugin-install.php' ) ) . '</p>';
		echo '</div>';
	}
}
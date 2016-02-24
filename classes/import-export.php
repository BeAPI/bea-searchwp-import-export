<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BEA_SWP_Export_Import {

	public function __construct(){

		if ( ! function_exists( 'SWP' ) ) {
			return false;
		}

		add_action( 'admin_menu', array( $this, 'submenu_page' ) );
		add_action( 'admin_init', array( $this, 'export_settings' ) );
		add_action( 'admin_init', array( $this, 'import_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

	}

	public function submenu_page() {
		add_submenu_page(
			'tools.php',
			'SWP ' . __( 'Import' ) . ' ' . __( 'Export' ),
			'SWP ' . __( 'Import' ) . ' ' . __( 'Export' ),
			'manage_options',
			'swp-export-import',
			array( $this, 'callback' ) );

	}


	/**
	 * @return bool|void
	 * @author Julien Maury
	 */
	public function admin_enqueue_scripts( $hook_suffix ){

		if ( 'tools_page_swp-export-import' !== $hook_suffix ) {
			return false;
		}

		wp_register_script( 'bea-swp-ie', BEA_SWPIE_URL . 'js/admin.js', array(), BEA_SWPIE_VERSION, true );
		wp_enqueue_script( 'bea-swp-ie' );
	}


	/**
	 * @return bool
	 * @author Julien Maury
	 */
	public function callback() {

		// Export feature
		$settings = SWP()->export_settings();

		require BEA_SWPIE_DIR . 'views/settings.php';
	}

	/**
	 * Export your settings
	 * @author Julien Maury
	 * @return bool|void
	 */
	public function export_settings() {

		if ( empty( $_POST['export_swp'] ) || empty( $_POST['action'] ) || 'export_swp_settings' !== $_POST['action'] ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['export_swp_nonce'], 'export_swp_nonce' ) ) {
			return;
		}

		$items = $_POST['export_swp'];

		ignore_user_abort( true );
		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=swp-settings-export-' . strtotime( 'now' ) . '.json' );
		header( 'Expires: 0' );
		echo SWP()->export_settings( $items );
		exit;

	}

	/**
	 * Import settings from file .json
	 * @return bool|void
	 * @author Julien Maury
	 */
	public function import_settings() {
		if ( empty( $_POST['action'] ) || 'import_swp_settings' !== $_POST['action'] ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['import_swp_nonce'], 'import_swp_nonce' ) ) {
			return;
		}

		$extension = end( explode( '.', $_FILES['import_file']['name'] ) );
		if ( 'json' !== $extension ) {
			wp_die( __( 'Please upload a valid .json file' ) );
		}
		$import_file = $_FILES['import_file']['tmp_name'];
		if ( empty( $import_file ) ) {
			wp_die( __( 'Please upload a file to import' ) );
		}
		$import_code = file_get_contents( $import_file );
		$settings = SWP()->import_settings( $import_code );

		if ( ! empty( $settings ) ) {
			update_option( 'searchwp_settings', json_encode( $settings ) );
		}
		wp_safe_redirect( add_query_arg( 'page', 'swp-export-import', admin_url( 'tools.php' ) ) );
		exit;
	}
}
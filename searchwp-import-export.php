<?php

/**
 * Plugin name: BEA SearchWP Import Export
 * Author : Beapi
 * Author URI : http://beapi.fr
 * Version: 0.1
 * Description: Allows to grab json export as json file and not copy/paste code
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BEA_SWPIE_VERSION', '0.1' );
define( 'BEA_SWPIE_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEA_SWPIE_URL', plugin_dir_url( __FILE__ ) );

if ( ! file_exists( BEA_SWPIE_DIR . 'vendor/autoload.php' ) ) {
	return false;
}

require BEA_SWPIE_DIR . 'vendor/autoload.php';

add_action( 'plugins_loaded', 'bea_swp_import_export' );
function bea_swp_import_export() {

	if ( is_admin() ) {
		add_action( 'admin_init', array( 'BEA_SWP_Checking', 'admin_init' ) );
		new BEA_SWP_Export_Import();
	}
}
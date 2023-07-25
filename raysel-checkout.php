<?php
/**
 *
 * Plugin Name: Raysel Woocommerce Checkout
 * Author: Youcef Bellouche
 * Author URI: https://www.facebook.com/bellou.fecuoy2000/
 * Version: 1.1.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Define Constants
define( 'RWC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RWC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RWC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );


// Test If Woocommerce Is Active
require_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	add_action(
		'admin_notices',
		function () {
			echo '<div class="notice notice-error"><p>Woocommerce must be Activated to use Raysel Checkout</p></div>';
		}
	);
	return;

}
// Activation
require_once RWC_PLUGIN_DIR . 'inc/classes/core/plugin-activation.php';
require_once RWC_PLUGIN_DIR . 'inc/classes/core/plugin-deactivation.php';
register_activation_hook( RWC_PLUGIN_DIR, array( Activate::class, 'activate' ) );
register_deactivation_hook( RWC_PLUGIN_DIR, array( Deactivate::class, 'deactivate' ) );

// Raysel Checkout Settings
require_once RWC_PLUGIN_DIR . 'inc/classes/Settings/class-callbacks.php';
require_once RWC_PLUGIN_DIR . 'inc/classes/Settings/class-settings.php';
// Enqueue Style/Script Function
require_once RWC_PLUGIN_DIR . 'inc/classes/utils/class-enqueue-functions.php';
// Woocommerce Custom Functions
require_once RWC_PLUGIN_DIR . 'inc/classes/woocommerce-classes/class-custom-wc-functions.php';
// Woocommerce Checkout Init
require_once RWC_PLUGIN_DIR . 'inc/classes/woocommerce-classes/class-custom-wc-checkout.php';





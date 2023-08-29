<?php
/**
 *
 * Plugin Name: Raysel Woocommerce Checkout
 * Author: Youcef Bellouche
 * Descripton: This Plugin Is For WooCommerce Product Page. It Allows To Put The Checkout Form In The Product Page
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
require_once RWC_PLUGIN_DIR . 'inc/classes/core/plugin-activator.php';
require_once RWC_PLUGIN_DIR . 'inc/classes/core/plugin-deactivator.php';

register_activation_hook( __FILE__, array(Rc_Activator::class,'rwc_activate') );
register_deactivation_hook( __FILE__, array(Rc_Deactivator::class,'rwc_deactivate') );

// Raysel Checkout Settings
require_once RWC_PLUGIN_DIR . 'inc/classes/Settings/class-callbacks.php';
require_once RWC_PLUGIN_DIR . 'inc/classes/Settings/class-settings.php';
// Enqueue Style/Script Function
require_once RWC_PLUGIN_DIR . 'inc/classes/utils/class-enqueue-functions.php';
// Woocommerce Custom Functions
require_once RWC_PLUGIN_DIR . 'inc/classes/woocommerce-classes/class-custom-wc-functions.php';
// Woocommerce Checkout Init
require_once RWC_PLUGIN_DIR . 'inc/classes/woocommerce-classes/class-custom-wc-checkout.php';





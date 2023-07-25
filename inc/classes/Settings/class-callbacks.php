<?php
/**
 * Raysel Woo Checkout Callbacks
 *
 * @package rwc
 */


class RWC_Callbacks {

	public function main_settings_page() {
		require RWC_PLUGIN_DIR . 'inc/partials/admin/settings-page-template.php';
	}
	public function render_field( $args ) {
		 $value = get_option( 'rwc_settings' );
		echo "<input type='" . $args['type'] . "' value='" . ( $value[ $args['label'] ] ?: $args['default'] ) . "' name='rwc_settings[" . $args['label'] . "]' />";
	}
	public function render_checkbox( $args ) {
		$value = get_option( 'rwc_settings', array( $args['label'] => $args['default'] ) );
		echo "<input type='checkbox' " . checked( $value[ $args['label'] ], 'on', false ) . "   name='rwc_settings[" . $args['label'] . "]' />";

	}
}

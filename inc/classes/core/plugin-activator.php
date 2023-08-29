<?php
/**
 * Activation Class
 *
 * @package rwc
 */

class Rc_Activator {
	public function rwc_activate() {
		$states_json     = file_get_contents( RWC_PLUGIN_DIR . '/assets/algeria_states_lotfi.json' );
		$cities_json     = file_get_contents( RWC_PLUGIN_DIR . '/assets/algeria_cities.json' );
		$states          = json_decode( $states_json, true );
		$cities          = json_decode( $cities_json, true );
		$shipping_states = array();
		if ( is_array( $states ) ) {
			update_option( 'rwc_states', $states, true );
			foreach ( $states as  $state ) {
				$shipping_states[ $state['fr_name'] ]['id']       = $state['id'];
				$shipping_states[ $state['fr_name'] ]['active']   = 'on';
				$shipping_states[ $state['fr_name'] ]['name']     = $state['fr_name'] . ' - ' . $state['ar_name'];
				$shipping_states[ $state['fr_name'] ]['fr_name']  = $state['fr_name'];
				$shipping_states[ $state['fr_name'] ]['ar_name']  = $state['ar_name'];
				$shipping_states[ $state['fr_name'] ]['regulare'] = 0;
			}
			update_option( 'rwc_shipping', $shipping_states );
		}
		if ( is_array( $cities ) ) {
			update_option( 'rwc_cities', $cities, true );
		}

		$settings = get_option( 'rwc_settings', array() );
		if ( empty( $settings ) ) {
			update_option(
				'rwc_settings',
				array(
					'rwc_submit_text'       => 'إشتري الأن',
					'rwc_order_email'       => 'fecuoy03@gmail.com',
					'rwc_submit_text_color' => '#FFFFFF',
				),
				true
			);
		}
	}

}

<?php
/**
 * Activation Class
 *
 * @package rwc
 */

class Activate {

	public function activate() {
		add_action(
			'init',
			function() {
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
		);
	}



}

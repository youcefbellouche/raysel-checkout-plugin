<?php
/**
 * Deactivation Class
 *
 * @package rwc
 */

class Rc_Deactivator {
	public function rwc_deactivate() {
		delete_option( 'rwc_settings' );
		delete_option( 'rwc_cities' );
		delete_option( 'rwc_states' );
		delete_option( 'rwc_shipping' );
	}
}

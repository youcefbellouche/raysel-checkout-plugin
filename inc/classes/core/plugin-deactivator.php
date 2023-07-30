<?php
/**
 * Deactivation Class
 *
 * @package rwc
 */

class Rc_Deactivator {

	public function deactivate() {
		delete_option( 'rwc_settings' );
	}
}

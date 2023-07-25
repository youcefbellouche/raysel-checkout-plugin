<?php
/**
 * Deactivation Class
 *
 * @package rwc
 */

class Deactivate {

	public function deactivate() {
		delete_option( 'rwc_settings' );
	}
}

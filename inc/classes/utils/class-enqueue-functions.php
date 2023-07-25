<?php


class EnqueueFunctions {

	public function __construct() {
		 add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_rwc_js_css' ) );
	}
	public function enqueue_rwc_js_css() {
		// ENQUEUE CSS FILES
		wp_enqueue_style( 'rwc-form-style', RWC_PLUGIN_URL . 'assets/css/style.css' );
		$this->add_dynamic_css();

		// ENQUEUE JS
		wp_enqueue_script( 'rwc-js', RWC_PLUGIN_URL . '/assets/js/rwc-form-cities.js', array( 'jquery' ) );
		wp_localize_script(
			'rwc-js',
			'wpData',
			array(
				'mainFile'    => RWC_PLUGIN_DIR,
				'mainFileUrl' => RWC_PLUGIN_URL,
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			)
		);
	}
	function add_dynamic_css() {
		$settings          = get_option( 'rwc_settings', array() );
		$button_text_color = isset( $settings['rwc_submit_text_color'] ) ? $settings['rwc_submit_text_color'] : '#ffffff';

		// DYNAMIQUE CSS
		$custom_css = "
        :root{
            --button-text-color:{$button_text_color};
        }
        ";
		wp_add_inline_style( 'rwc-form-style', $custom_css );
	}
}
new EnqueueFunctions();

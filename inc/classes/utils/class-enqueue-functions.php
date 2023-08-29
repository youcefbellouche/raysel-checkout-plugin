<?php


class EnqueueFunctions {

	public function __construct() {
		 add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_rwc_js_css' ) );
		 add_action('wp_ajax_get_variation_price', array($this,'get_variation_price'));
add_action('wp_ajax_nopriv_get_variation_price', array($this,'get_variation_price'));
	}
	public function enqueue_rwc_js_css() {
		// ENQUEUE CSS FILES
		wp_enqueue_style( 'rwc-form-style', RWC_PLUGIN_URL . 'assets/css/style.css' );
		$this->add_dynamic_css();
		$cities   = get_option( 'rwc_cities' );
		$shipping = get_option( 'rwc_shipping' );
		// ENQUEUE JS
		wp_enqueue_script( 'rwc-js-cities', RWC_PLUGIN_URL . '/assets/js/rwc-form-cities.js', array( 'jquery' ) );
		wp_localize_script(
			'rwc-js-cities',
			'wpData',
			array(
				'cities'   => $cities,
				'shipping' => $shipping,
			)
		);
		wp_enqueue_script( 'rwc-js-price', RWC_PLUGIN_URL . '/assets/js/rwc-form-price.js', array( 'jquery' ) );
		wp_localize_script(
			'rwc-js-price',
			'wpData',
			array(
				'mainFile'    => RWC_PLUGIN_DIR,
				'mainFileUrl' => RWC_PLUGIN_URL,
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'shipping' => $shipping,
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
	function get_variation_price(){
		if (! isset($_POST['variation_id'])){
			wp_send_json( "Price Messing", 404);
		}
		$variation_obj = new WC_Product_Variation($_POST['variation_id']);
		$variation_price = $variation_obj->get_price();
		wp_send_json( $variation_price, 200);
	}
}
new EnqueueFunctions();

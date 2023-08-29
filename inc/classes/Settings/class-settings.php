<?php
/**
 * Raysel Woo Checkout Settings
 *
 * @package rwc
 */

class RWC_Settings extends RWC_Callbacks {

	public function __construct() {
		 add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_setup' ) );
		add_action( 'admin_init', array( $this, 'shipping_setup' ) );
	}
	public function settings_menu() {
		add_menu_page(
			'Raysel Checkout',
			'Raysel Checkout',
			'manage_options',
			'raysel_checkout',
			array( $this, 'main_settings_page' ),
			'dashicons-cart',
			10
		);
		add_submenu_page(
			'raysel_checkout',
			'Shipping Settings',
			'Shipping',
			'manage_options',
			'raysel_shipping',
			array( $this, 'shipping_settings_page' )
		);
	}
	public function get_styling_fields() {
		return array(
			array(
				'id'       => 'rwc_submit_text_color',
				'title'    => __( 'Submit Text Color', 'raysel-checkout' ),
				'callback' => array( $this, 'render_field' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_submit_text_color',
					'default' => '#FFFFFF',
					'type'    => 'color',
				),
			),
		);
	}
	public function get_shipping_fields() {
		$states   = get_option( 'rwc_states' );
		$shipping = array();
		foreach ( $states as $state ) {
			$shipping[ $state['id'] ] = array(
				'id'       => $state['fr_name'],
				'title'    => __( $state['fr_name'], 'raysel-checkout' ),
				'callback' => array( $this, 'render_shipping_field' ),
				'page'     => 'raysel_shipping',
				'section'  => 'raysel_shipping_section',
				'args'     => array(
					'label'   => $state['fr_name'],
					'name'    => $state['fr_name'] . ' - ' . $state['ar_name'],
					'fr_name' => $state['fr_name'],
					'ar_name' => $state['ar_name'],
				),
			);
		}
		return $shipping;
	}
	public function get_settings_fields() {
		return array(
			array(
				'id'       => 'rwc_submit_text',
				'title'    => __( 'Submit Text', 'raysel-checkout' ),
				'callback' => array( $this, 'render_field' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_submit_text',
					'default' => 'إشتري الأن',
					'type'    => 'text',
				),
			),
			array(
				'id'       => 'rwc_order_email',
				'title'    => __( 'Email for orders', 'raysel-checkout' ),
				'callback' => array( $this, 'render_field' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_order_email',
					'default' => 'fecuoy03@gmail.com',
					'type'    => 'email',
				),
			),
			array(
				'id'       => 'rwc_email_field_activate',
				'title'    => __( 'Activate Email', 'raysel-checkout' ),
				'callback' => array( $this, 'render_checkbox' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_email_field_activate',
					'default' => false,
					'type'    => 'checkbox',
				),
			),
			array(
				'id'       => 'rwc_email_field',
				'title'    => __( 'Require Email', 'raysel-checkout' ),
				'callback' => array( $this, 'render_checkbox' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_email_field',
					'default' => false,
					'type'    => 'checkbox',
				),
			),
			array(
				'id'       => 'rwc_full_address_field_activate',
				'title'    => __( 'Activate Address', 'raysel-checkout' ),
				'callback' => array( $this, 'render_checkbox' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_full_address_field_activate',
					'default' => false,
					'type'    => 'checkbox',
				),
			),
			array(
				'id'       => 'rwc_full_address_field',
				'title'    => __( 'Require Address', 'raysel-checkout' ),
				'callback' => array( $this, 'render_checkbox' ),
				'page'     => 'raysel_checkout',
				'section'  => 'raysel_main_section',
				'args'     => array(
					'label'   => 'rwc_full_address_field',
					'default' => false,
					'type'    => 'checkbox',
				),
			),

		);
	}

	public function settings_setup() {
		register_setting( 'raysel_checkout_settings', 'rwc_settings', '' );
		add_settings_section( 'raysel_main_section', '', '', 'raysel_checkout' );
		$fields = array_merge( $this->get_settings_fields(), $this->get_styling_fields() );
		foreach ( $fields as $field ) {
			add_settings_field( $field['id'], $field['title'], $field['callback'], $field['page'], $field['section'], $field['args'] );
		}
	}
	public function shipping_setup() {
		register_setting( 'raysel_shipping_settings', 'rwc_shipping', '' );
		add_settings_section( 'raysel_shipping_section', '', '', 'raysel_shipping' );
		$fields = $this->get_shipping_fields();
		foreach ( $fields as $field ) {
			add_settings_field( $field['id'], $field['title'], $field['callback'], $field['page'], $field['section'], $field['args'] );
		}
	}
}
new RWC_Settings();

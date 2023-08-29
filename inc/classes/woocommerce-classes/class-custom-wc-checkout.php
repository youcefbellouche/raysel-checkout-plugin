<?php
/**
 * Custom Woocommerce Checkout
 *
 * @package rwc
 */

class Custom_Wc_Checkout extends Custom_Wc_Functions {
	function __construct() {
		remove_action( 'woocomerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		add_action( 'wp', array( $this, 'activate_checkout_form' ) );
		add_action( 'init', array( $this, 'submit_checkout_form' ) );
		add_filter( 'product_type_selector', array( $this, 'only_simple_and_variable_product' ) );
		add_filter( 'wc_get_template', array( $this, 'prevent_add_to_cart_template' ), 99999, 2 );
	}
	// allows only simple and variable products
	function only_simple_and_variable_product( $product_types ) {
		if ( isset( $product_types['grouped'] ) ) {
			unset( $product_types['grouped'] );
		}
		if ( isset( $product_types['external'] ) ) {
			unset( $product_types['external'] );
		}
		if ( isset( $product_types['virtual'] ) ) {
			unset( $product_types['virtual'] );
		}
		if ( isset( $product_types['downloadable'] ) ) {
			unset( $product_types['downloadable'] );
		}
		return $product_types;
	}
	// removes the add to cart of simple product page
	function prevent_add_to_cart_template( $template, $template_name ) {
		if ( $template_name == 'single-product/add-to-cart/simple.php' ) {
			return;
		}
		return $template;
	}

	// Checkout form activation
	function activate_checkout_form() {
		if ( ! wc_get_product() ) {
			return;
		}
		if ( wc_get_product()->is_type( 'simple' ) ) {
			add_action(
				'woocommerce_product_meta_start',
				array( $this, 'get_checkout_form' ),
				10
			);

		} elseif ( wc_get_product()->is_type( 'variable' ) ) {
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			// Put variation form above the short description
			add_action(
				'woocommerce_after_variations_form',
				array( $this, 'get_checkout_form' ),
				15
			);
		}
	}

	// Checkout form UI
	function get_checkout_form() {
		require_once RWC_PLUGIN_DIR . 'inc/partials/client/checkout-form-template.php';
	}

	// Checkout form treatment
	function submit_checkout_form() {
		if ( ! isset( $_POST['rwc-form-nonce'] ) ||
		! wp_verify_nonce( $_POST['rwc-form-nonce'], 'submit-rwc-form' ) ) {
			return;
		}
		if ( ! isset( $_POST['rwc-product-id'] ) ) {
			return;
		}
			$settings           = get_option( 'rwc_settings' );
			$product            = wc_get_product( $_POST['rwc-product-id'] );
			$name               = isset( $_POST['rwc-name'] ) ? sanitize_text_field( $_POST['rwc-name'] ) : '';
			$phone              = isset( $_POST['rwc-phone'] ) ? sanitize_text_field( $_POST['rwc-phone'] ) : '';
			$email              = isset( $_POST['rwc-email'] ) ? sanitize_text_field( $_POST['rwc-email'] ) : '';
			$state              = isset( $_POST['rwc-state'] ) ? sanitize_text_field( $_POST['rwc-state'] ) : '';
			$city               = isset( $_POST['rwc-city'] ) ? sanitize_text_field( $_POST['rwc-city'] ) : '';
			$address            = isset( $_POST['rwc-full-address'] ) ? sanitize_text_field( $_POST['rwc-full-address'] ) : '';
			$quantity           = isset( $_POST['rwc-quantity'] ) ? sanitize_text_field( $_POST['rwc-quantity'] ) : '';
			$shipping['method'] = isset( $_POST['rwc-shipping'] ) ? sanitize_text_field( $_POST['rwc-shipping'] ) : 'regulare';
		if ( $settings['rwc_full_address_field'] == 'on' && $settings['rwc_full_address_field_activate'] == 'on' ) {
			if ( ! $address ) {
				wp_redirect( $_POST['http_referer'] . '?error=missing_field' );
				return;
			}
		}
		if ( $settings['rwc_email_field'] == 'on' && $settings['rwc_email_field_activate'] == 'on' ) {
			if ( ! $email ) {
				wp_redirect( $_POST['http_referer'] . '?error=missing_field' );
				return;
			}
		}
		if ( ! $name || ! $phone || ! $state || ! $city || ! $quantity || ! $shipping['method'] ) {
			wp_redirect( $_POST['http_referer'] . '?error=missing_field' );
			return;
		}
			$shipping_prices   = get_option( 'rwc_shipping' );
			$shipping['price'] = intval( $shipping_prices[ $state ][ $shipping['method'] ] ?: 0 );
			$args              = array(
				'first_name' => $name,
				'email'      => $email,
				'phone'      => $phone,
				'address_1'  => $address,
				'city'       => $city,
				'state'      => $state,
				'country'    => 'DZ',
			);

			if ( $product->is_type( 'simple' ) ) {
				$order_id     = $this->create_custom_order( $args, $quantity, $product, $shipping );
				$product_data = $product->get_data();
				$this->send_email( $product_data, $order_id, $shipping );
				$url = $this->thankyou_page_url( $order_id );
				wp_safe_redirect( $url );
				exit;
			} elseif ( $product->is_type( 'variable' ) ) {
				$variations   = $product->get_variation_attributes();
				$variation_id = isset( $_POST['variation_id'] ) ? sanitize_text_field( $_POST['variation_id'] ) : '';
				if ( $variation_id ) {
					$variation_product = wc_get_product( $variation_id );
					foreach ( $variations as $variation_name => $variation ) {
						$oredr_product_attributes[ 'attribute_' . $variation_name ] = $_POST[ 'attribute_' . $variation_name ];
					}
					$variation_product->set_attributes( $oredr_product_attributes );
					$order_id     = $this->create_custom_order( $args, $quantity, $variation_product, $shipping );
					$product_data = $variation_product->get_data();
					$this->send_email( $product_data, $order_id, $shipping, false );
					$url = $this->thankyou_page_url( $order_id );
					wp_safe_redirect( $url );
					exit;
				} else {
					wc_add_notice( __( 'Remplir Tout les Choix de produit' ), 'error' );
				}
			}

	}

}
new Custom_Wc_Checkout();

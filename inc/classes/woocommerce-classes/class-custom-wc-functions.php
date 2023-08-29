<?php
/**
 * Custom Woocommerce Functions
 *
 * @package rwc
 */

class Custom_Wc_Functions {

	/**
	 * Returns Thank You Page
	 */
	function thankyou_page_url( $order_id ) {

		if ( ! $order_id ) {
			return false;
		}

		$order        = new \WC_Order( $order_id );
		$thankyou_url = $order->get_checkout_order_received_url();
		return $thankyou_url;
	}


	/**
	 * Send Email
	 *
	 * @param array  $product_data
	 * @param string $order_id
	 * @param bool   $is_simple (optional, default = false)
	 */
	function send_email( $product_data, $order_id, $shipping, $is_simple = true ) {
		$order           = new \WC_Order( $order_id );
		$global_settings = get_option( 'rwc_settings' );
		$global_email    = $global_settings['rwc_order_email'];
		$admin_email     = get_userdata( get_current_user_id() )->user_email;
		$send_mail       = $global_email ? $global_email : $admin_email;
		$subject         = 'Order Recived !';
		$headers         = array( 'Content-Type: text/html;charset=UTF-8' );
		$order_data      = $order->get_data();
		$product_price   = reset( $order->get_items() )->get_subtotal();
		$quantity        = reset( $order->get_items() )->get_quantity();
		$billing         = $order_data['billing'];

		ob_start();
		?>
<div style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
	<h3 style="background:#0653a0;color:whitesmoke;padding:10px">
		New Order !<br /><br />
		Total Price : <?php echo $shipping['price'] + $product_price;; ?> DZ</h3>
	</h3>

	<h3>Client Informations</h3>
	<p>Client Name : <?php echo $billing['first_name']; ?></p>
	<p>Client Phone : <?php echo $billing['phone']; ?></p>
	<p>Client Email : <?php echo $billing['email']; ?></p>
	<p>Client State : <?php echo $billing['state']; ?></p>
	<p>Client City : <?php echo $billing['city']; ?></p>
	<p>Client Adress : <?php echo $billing['address_1']; ?></p>
	<br />

	<a style="text-decoration:none;color:white;background:#0653a0;padding:10px 20px"
		href="tel: <?php echo $billing['phone']; ?>">Call The Client</a>

	<br /><br />
	<h3>Product Informations</h3>
	<p>Product Name : <?php echo $product_data['name']; ?></p>
	<p>Product Price : <?php echo $product_price; ?> DZ</p>
	<p>Quantity : <?php echo $quantity; ?></p>
	<p>Shipping method: <?php echo $shipping['method']; ?> </p>
	<p>Shipping Price: <?php echo $shipping['price']; ?> </p>
	
		<?php if ( ! $is_simple ) : ?>
		<p>
			<?php
			$attributes = explode( ',', $product_data['attribute_summary'] );
			foreach ( $attributes as $attribute ) :
				echo $attribute;
				echo '</br>';
				echo '</br>';
			endforeach;
			?>
	</p>
			<?php
			endif;
		?>
	<br />
</div>

		<?php
		$body = ob_get_clean();
		wp_mail( $send_mail, $subject, $body, $headers );
	}

	/**
	 * Create Custom Order
	 */
	public function create_custom_order( $args, $quantity, $product, $shipping ) {
		$item_fee = new WC_Order_Item_Fee();
		$item_fee->set_name( 'Shipping Method ' . $shipping['method'] );
		$item_fee->set_amount( $shipping['price'] );
		$item_fee->set_tax_status( 'none' );
		$item_fee->set_total( $shipping['price'] );
		$item_fee->calculate_taxes( $calculate_tax_for );
		$order = wc_create_order();
		$order->add_item( $item_fee );
		$order->set_address( $args, 'billing' );
		$order->set_address( $args, 'shipping' );
		$order->add_product( $product, $quantity );
		$order->calculate_totals();
		$order_id = $order->save();
		return $order_id;
	}
}

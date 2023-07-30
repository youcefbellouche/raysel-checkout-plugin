<?php
$settings = get_option( 'rwc_settings', array() );
$product  = wc_get_product();
?>

<div class="rwc-order">
	<p class="rwc-order-info">معلومات الزبون</p>
	<form class="rwc-order-form" method="POST">
		<?php wp_nonce_field( 'submit-rwc-form', 'rwc-form-nonce' ); ?>
		<input name="rwc-product-id" required type="hidden" value="<?php echo get_the_ID(); ?>">
		<input name="rwc-name" required type="text" placeholder="الإسم واللقب *">
		<input name="rwc-phone" required type="tel" pattern="[0-9]+" placeholder="رقم الهاتف *">
		<?php if ( ! $settings['rwc_email_field_activate'] != 'on' ) : ?> 
		<input type="email" name="rwc-email" <?php echo $settings['rwc_email_field'] ? 'required="required"' : ''; ?> placeholder="البريد الإلكتروني">
			<?php
		endif;
		?>
		<div class="rwc-states"></div>
		<?php if ( ! $settings['rwc_full_address_field_activate'] != 'on' ) : ?> 
			<input name="rwc-full-address" type="text" placeholder="العنوان الكامل" <?php echo $settings['rwc_full_address_field'] ? 'required="required"' : ''; ?> >
		<?php endif; ?> 
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
		<input min="1" max="50" class="rwc-quantity" value="1" name="rwc-quantity" type="number" required placeholder="الكمية">
		<span class="rwc-total-price"></span>
		<input class="rwc-order-btn" name="rwc-order" type="submit" value="<?php echo isset( $settings['rwc_submit_text'] ) ? $settings['rwc_submit_text'] : 'إشتري الأن'; ?>">	
	</form>
</div>

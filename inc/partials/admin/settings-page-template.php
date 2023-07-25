<div class="wrap">
	<h1>Raysel Checkout</h1>
	<form action="options.php" method="POST">
		<?php do_settings_sections( 'raysel_checkout' ); ?>
		<?php settings_fields( 'raysel_checkout_settings' ); ?>
		<?php echo submit_button(); ?>
	</form>
</div>

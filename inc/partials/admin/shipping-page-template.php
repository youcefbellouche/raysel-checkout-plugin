<div class="wrap">
	<h1>Raysel Shipping</h1>
	<form action="options.php" method="POST">
		<?php do_settings_sections( 'raysel_shipping' ); ?>
		<?php settings_fields( 'raysel_shipping_settings' ); ?>
		<?php echo submit_button(); ?>
	</form>
</div>

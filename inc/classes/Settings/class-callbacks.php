<?php
/**
 * Raysel Woo Checkout Callbacks
 *
 * @package rwc
 */


class RWC_Callbacks {

	public function main_settings_page() {
		require RWC_PLUGIN_DIR . 'inc/partials/admin/settings-page-template.php';
	}
	public function shipping_settings_page() {
		require RWC_PLUGIN_DIR . 'inc/partials/admin/shipping-page-template.php';
	}
	public function render_field( $args ) {
		 $value = get_option( 'rwc_settings' );
		echo "<input type='" . $args['type'] . "' value='" . ( $value[ $args['label'] ] ?: $args['default'] ) . "' name='rwc_settings[" . $args['label'] . "]' />";
	}
	public function render_checkbox( $args ) {
		$value = get_option( 'rwc_settings', array( $args['label'] => $args['default'] ) );
		echo "<input type='checkbox' " . checked( $value[ $args['label'] ], 'on', false ) . "   name='rwc_settings[" . $args['label'] . "]' />";
	}
	public function render_shipping_field( $args ) {
		$values = get_option( 'rwc_shipping' );
		?>
		<div style="display: flex; align-items:center;gap:3px">
		<input type="hidden" name="rwc_shipping[<?php echo $args['label']; ?>][name]" value="<?php echo $args['name']; ?>" >
		<input type="hidden" name="rwc_shipping[<?php echo $args['label']; ?>][fr_name]" value="<?php echo $args['fr_name']; ?>" >
		<input type="hidden" name="rwc_shipping[<?php echo $args['label']; ?>][ar_name]" value="<?php echo $args['ar_name']; ?>" >
		<div style="border: 2px solid;display:flex;flex-direction:column;gap:5px;align-items:center;padding:3px;border-radius:2px">
			<label for="rwc_shipping[<?php echo $args['label']; ?>][active]">Disponible</label>
			<input type="checkbox" name="rwc_shipping[<?php echo $args['label']; ?>][active]" <?php echo checked( $values[ $args['label'] ]['active'], 'on', false ); ?> >
		</div>
			
			<input type="number" name="rwc_shipping[<?php echo $args['label']; ?>][regulare]" placeholder="Livraison à domicile" value="<?php echo $values[ $args['label'] ]['regulare'] ?: ''; ?>">
			
			<input type="number" name="rwc_shipping[<?php echo $args['label']; ?>][selling_point]" placeholder="Livraison au point de vente" value="<?php echo $values[ $args['label'] ]['selling_point'] ?: ''; ?>">

			<div style="border: 2px solid;display:flex;flex-direction:column;gap:5px;align-items:center;padding:3px;border-radius:2px">
				<label for="rwc_shipping[<?php echo $args['label']; ?>][seller]">Ramasser chez vendeur</label>
				<input type="checkbox" name="rwc_shipping[<?php echo $args['label']; ?>][seller]" <?php echo checked( $values[ $args['label'] ]['seller'], 'on', false ); ?> >
			</div>
				
		</div>
		<?php
	}
}

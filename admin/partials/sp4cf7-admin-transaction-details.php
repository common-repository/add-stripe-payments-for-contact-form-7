<?php 
/**
 * Provide an admin area view for the transaction details
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.pluginspro.io
 * @since      1.0.0
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/admin/partials
 */
?>

<div class="sp4cf7-admin-transaction-details sp4cf7-settings">
	<div class="sp4cf7-form">
	<?php
	if ( !empty( $fields ) ) { ?>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_form_id'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e(ucfirst( get_the_title( get_post_meta( $post->ID, '_form_id', true ) ) ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_transaction_status'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e(ucfirst( get_post_meta( $post->ID , '_transaction_status', true ) ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_transaction_id'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e( get_post_meta( $post->ID , '_transaction_id', true ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_charge_id'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e( get_post_meta( $post->ID , '_charge_id', true ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_total'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e(sprintf('%0.2f %s', get_post_meta( $post->ID , '_total', true ), strtoupper(get_post_meta( $post->ID , '_currency', true ) ) ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_request_ip'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e(ucfirst( get_post_meta( $post->ID , '_request_ip', true ) ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>

		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_transaction_datetime'], true ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					_e(ucfirst( get_post_meta( $post->ID , '_transaction_datetime', true ) ), SP4CF7_DOMAIN );
				?>
			</div>
		</div>
		
		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_form_data'] ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					$post_meta = get_post_meta( $post->ID, '_form_data', true );
					$post_meta = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {      
					    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
					}, $post_meta );
					$data = unserialize( $post_meta );

					$dns_fields = array( 
						'_wpcf7', 
						'_wpcf7_version', 
						'_wpcf7_locale', 
						'_wpcf7_unit_tag', 
						'_wpcf7_container_post',
						'card-errors',
						'sp4cf7p_stripe_token',
						'sp4cf7_stripe_token'
					);

					$remove_data = apply_filters( SP4CF7_DOMAIN . '_wpcf7_data_transaction_form_fields', $dns_fields );
					foreach ( $remove_data as $key => $value ) {
						if ( array_key_exists( $value, $data ) ) {
							unset( $data[$value] );
						}
					}

					$data = array_filter($data, function($key) {
					    return strpos($key, 'stripe-') === false;
					}, ARRAY_FILTER_USE_KEY);

					foreach ( $data as $key => $value ) {

						?>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( sprintf( '%s', $key ), SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php _e( sprintf( '%s', ( is_array( $value ) ? implode( ', ', $value ) : $value ) ), SP4CF7_DOMAIN ); ?>
							</div>
						</div>
						<?php
					}
				?>
			</div>
		</div>

		<div class="form-field">
			<hr />
		</div>
		<div class="form-field">
			<div class="titledesc">
				<?php _e( sprintf( '%s', $fields['_purchased_items'] ), SP4CF7_DOMAIN ); ?>
			</div>
			<div class="col-75">
				<?php
					$post_meta = get_post_meta( $post->ID, '_purchased_items', true );
					$post_meta = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {      
					    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
					}, $post_meta );
					$data = unserialize( $post_meta );

					$fields_titles = array(
						'item_name' => 'Product',
			            'item_sku' => 'SKU',
			            'item_desc' => 'Description',
			            'item_qty' => 'Quantity',
			            'item_price' => 'Price'
			        );

					foreach ($data as $item) {
						
						?>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Product', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_val = isset($item['item_name']) ? $item['item_name'] : $item['name'];
								_e( sprintf( '%s', ( is_array( $_val ) ? implode( ', ', $_val ) : $_val ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'SKU', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_val = isset($item['item_sku']) ? $item['item_sku'] : $item['sku'];
								_e( sprintf( '%s', ( is_array( $_val ) ? implode( ', ', $_val ) : $_val ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Description', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_val = isset($item['item_desc']) ? $item['item_desc'] : $item['desc'];
								_e( sprintf( '%s', ( is_array( $_val ) ? implode( ', ', $_val ) : $_val ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Quantity', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_qty = isset($item['item_qty']) ? $item['item_qty'] : $item['quantity'];
								$_val = $_qty;
								_e( sprintf( '%s', ( is_array( $_val ) ? implode( ', ', $_val ) : $_val ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Shipping', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_shipping = isset($item['item_shipping']) ? $item['item_shipping'] : $item['shipping'];
								$_val = $_shipping;
								_e( sprintf( '$%s', ( is_array( $_val ) ? implode( ', ', $_val ) : number_format( $_val, 2 ) ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>
						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Price', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_price = isset($item['item_price']) ? $item['item_price'] : $item['price'];
								$_val = $_price;
								_e( sprintf( '$%s', ( is_array( $_val ) ? implode( ', ', $_val ) : number_format( $_val, 2 ) ) ), SP4CF7_DOMAIN );
								?>
							</div>
						</div>

						<div class="sp4cf7-wpcf7-data">
							<div class="sp4cf7-data-form-title titledesc">
								<?php _e( 'Item Total', SP4CF7_DOMAIN ) ?>
							</div>
							<div class="sp4cf7-data-form-data col-75">
								<?php 
								$_val = ($_shipping * $_qty) + ($_price * $_qty);
								echo '$' .number_format( $_val, 2 );
								?>
							</div>
						</div>
						<?php

						echo "<hr>";
					}

				?>
			</div>
		</div>

	<?php } ?>
	</div>
</div>
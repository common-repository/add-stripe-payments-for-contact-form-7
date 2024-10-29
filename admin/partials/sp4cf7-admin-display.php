<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.pluginspro.io
 * @since      1.0.0
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/admin/partials
 */

$use_stripe_meta			= SP4CF7PMP . 'use_stripe';
$use_stripe           		= get_post_meta( $post_id, $use_stripe_meta, true );

$enable_test_mode_meta		= SP4CF7PMP . 'enable_test_mode';
$enable_test_mode     		= get_post_meta( $post_id, $enable_test_mode_meta, true );

$live_publishable_key_meta	= SP4CF7PMP . 'live_publishable_key';
$live_publishable_key 		= get_post_meta( $post_id, $live_publishable_key_meta, true );

$live_secret_key_meta		= SP4CF7PMP . 'live_secret_key';
$live_secret_key      		= get_post_meta( $post_id, $live_secret_key_meta, true );

$test_secret_key_meta		= SP4CF7PMP . 'test_secret_key';
$test_secret_key      		= get_post_meta( $post_id, $test_secret_key_meta, true );

$test_publishable_key_meta	= SP4CF7PMP . 'test_publishable_key';
$test_publishable_key 		= get_post_meta( $post_id, $test_publishable_key_meta, true );

$email_meta					= SP4CF7PMP . 'email';
$email                		= get_post_meta( $post_id, $email_meta, true );

$customer_name_meta			= SP4CF7PMP . 'customer_name';
$customer_name              = get_post_meta( $post_id, $customer_name_meta, true );

// static fields
$item_name_meta			    = SP4CF7PMP . 'item_name';
$item_name          		= get_post_meta( $post_id, $item_name_meta, true );
if (is_array($item_name))
	$item_name = $item_name[0];

$item_sku_meta			    = SP4CF7PMP . 'item_sku';
$item_sku          		    = get_post_meta( $post_id, $item_sku_meta, true );
if (is_array($item_sku))
	$item_sku = $item_sku[0];

$item_price_meta			= SP4CF7PMP . 'item_price';
$item_price          		= get_post_meta( $post_id, $item_price_meta, true );
if (is_array($item_price))
	$item_price = $item_price[0];

$item_desc_meta			    = SP4CF7PMP . 'item_desc';
$item_desc          		= get_post_meta( $post_id, $item_desc_meta, true );
if (is_array($item_desc))
	$item_desc = $item_desc[0];

$item_img_meta			    = SP4CF7PMP . 'item_img';
$item_img          			= get_post_meta( $post_id, $item_img_meta, true );
if (is_array($item_img))
	$item_img = $item_img[0];
// end static fields

$success_url          		= '';
$cancel_url           		= '';
$currency 					= '';

$currencies = sp4cf7_get_all_currencies();
$all_pages = sp4cf7_get_all_pages();

?>
<div class="sp4cf7-settings">
	<div class="">
		<div class="sp4cf7-form">
			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($use_stripe_meta) ?>">
						<?php _e( 'Enable/Disable', SP4CF7_DOMAIN ); ?>
					</label>
				</div>
				<div class="col-75">
					<label class="switch">
						<input id="<?php echo esc_attr($use_stripe_meta) ?>" name="<?php echo esc_attr($use_stripe_meta) ?>" type="checkbox" class="enable_required" value="1" <?php checked( $use_stripe, 1 ); ?> /> 
						<div class="slider round"></div>
					</label> <?php _e( 'Stripe', SP4CF7_DOMAIN ); ?>
				</div>
			</div>
			
			<div class="form-field">
				<div class="titledesc">
					<label for="sp4cf7-use-global-settings">
						<?php _e( 'Global Settings', SP4CF7_DOMAIN ); ?>
					</label>
				</div>
				<div class="col-75">
					<label class="switch">
						<input id="sp4cf7-use-global-settings" name="sp4cf7-use-global-settings" type="checkbox" class="enable_required" value="1"  /> 
						<div class="slider round"></div>
					</label> <span class="sp4cf7-update-pro dashicons-before dashicons-cart"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($enable_test_mode_meta); ?>">
						<?php _e( 'Test Mode', SP4CF7_DOMAIN ); ?>
					</label>
				</div>
				<div class="col-75">
					<label class="switch">
						<input id="<?php echo esc_attr($enable_test_mode_meta); ?>" name="<?php echo esc_attr($enable_test_mode_meta); ?>" type="checkbox" class="enable_required" value="1" <?php checked( $enable_test_mode, 1 ); ?> /> 
						<div class="slider round"></div>
					</label> <?php echo esc_html( __( 'Turn on testing', SP4CF7_DOMAIN ) ); ?>
					<br>
					<p class="description"><?php echo esc_html( __( 'Use the test mode on Stripe dashboard to verify everything works before going live.', SP4CF7_DOMAIN ) ); ?></p>
				</div>
			</div>

			<div class="form-field test-key" <?php echo ($enable_test_mode == 0) ? 'style="display:none;"' : '' ?>>
				<div class="titledesc">
					<label for="<?php echo esc_attr($test_publishable_key_meta); ?>">
						<?php echo sprintf( __( 'Stripe API Test Publishable key %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($test_publishable_key_meta); ?>" name="<?php echo esc_attr($test_publishable_key_meta); ?>" type="text" class="large-text" value="<?php echo esc_attr( $test_publishable_key ); ?>" autocomplete="off" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-test-publishable-key"></span>
				</div>
			</div>
			<div class="form-field test-key" <?php echo ($enable_test_mode == 0) ? 'style="display:none;"' : '' ?>>
				<div class="titledesc">
					<label for="<?php echo esc_attr($test_secret_key_meta); ?>">
						<?php echo sprintf( __( 'Stripe API Test Secret key %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($test_secret_key_meta); ?>" name="<?php echo esc_attr($test_secret_key_meta); ?>" type="text" class="large-text" value="<?php echo esc_attr( $test_secret_key ); ?>" autocomplete="off" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-test-secret-key"></span>
				</div>
			</div>
			<div class="form-field live-key" <?php echo ($enable_test_mode == 1) ? 'style="display:none;"' : '' ?>>
				<p class="description"><?php echo esc_html( __( 'Note: An SSL Certificate (HTTPS) is required to use Stripe in live mode.', SP4CF7_DOMAIN ) ); ?></p>
			</div>
			<div class="form-field live-key" <?php echo ($enable_test_mode == 1) ? 'style="display:none;"' : '' ?>>
				<div class="titledesc">
					<label for="<?php echo esc_attr($live_publishable_key_meta); ?>">
						<?php echo sprintf( __( 'Stripe API Live Publishable key %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($live_publishable_key_meta); ?>" name="<?php echo esc_attr($live_publishable_key_meta); ?>" type="text" class="large-text" value="<?php echo esc_attr( $live_publishable_key ); ?>" autocomplete="off" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-live-publishable-key"></span>
				</div>
			</div>
			<div class="form-field live-key" <?php echo ($enable_test_mode == 1) ? 'style="display:none;"' : '' ?>>
				<div class="titledesc">
					<label for="<?php echo esc_attr($live_secret_key_meta); ?>">
						<?php echo sprintf( __( 'Stripe API Live Secret key %s', SP4CF7_DOMAIN), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($live_secret_key_meta); ?>" name="<?php echo esc_attr($live_secret_key_meta); ?>" type="text" class="large-text" value="<?php echo esc_attr( $live_secret_key ); ?>" autocomplete="off" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-live-secret-key"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($email_meta); ?>">
						<?php echo sprintf( esc_html__( 'Customer Email Field %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<select id="<?php echo $email_meta; ?>" name="<?php echo $email_meta; ?>" class="sp4cf7p-dynamic-field">
						<option value=""><?php _e( 'Select Field', SP4CF7_DOMAIN ); ?></option>
						<?php 
						if ( count( $form_tags ) > 0 ) {
							foreach ( $form_tags as $key => $value ) {
								if (!empty($value['name'])) {
									echo '<option value="' . esc_attr( $value['name'] ) . '" ' . selected( $email, $value['name'], false ) . '>'. esc_attr( $value['name'] ) . '</option>';
								}
							}
						}
						?>
					</select>
					<!-- <input id="<?php echo esc_attr($email_meta); ?>" name="<?php echo esc_attr($email_meta); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" class="sp4cf7-dynamic-field" /> -->
					<span class="sp4cf7-help-tip" id="sp4cf7-help-customer-email"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($customer_name_meta); ?>">
						<?php echo sprintf( esc_html__( 'Customer Name Field %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<select id="<?php echo $customer_name_meta; ?>" name="<?php echo $customer_name_meta; ?>" class="sp4cf7p-dynamic-field">
						<option value=""><?php _e( 'Select Field', SP4CF7_DOMAIN ); ?></option>
						<?php 
						if ( count( $form_tags ) > 0 ) {
							foreach ( $form_tags as $key => $value ) {
								if (!empty($value['name'])) {
									echo '<option value="' . esc_attr( $value['name'] ) . '" ' . selected( $customer_name, $value['name'], false ) . '>'. esc_attr( $value['name'] ) . '</option>';
								}
							}
						}
						?>
					</select>
					<!-- <input id="<?php echo esc_attr($customer_name_meta); ?>" name="<?php echo esc_attr($customer_name_meta); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" class="sp4cf7-dynamic-field" /> -->
					<span class="sp4cf7-help-tip" id="sp4cf7-help-customer-email"></span>
				</div>
			</div>

			<h4>Item</h4>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($item_name_meta); ?>">
						<?php echo sprintf( esc_html__('Item Name %s', SP4CF7_DOMAIN  ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($item_name_meta); ?>" name="<?php echo esc_attr($item_name_meta); ?>" type="text" value="<?php echo esc_attr( $item_name ); ?>" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-item_name"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($item_sku_meta); ?>">
						<?php echo sprintf( esc_html__('Item SKU %s', SP4CF7_DOMAIN  ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($item_sku_meta); ?>" name="<?php echo esc_attr($item_sku_meta); ?>" type="text" value="<?php echo esc_attr( $item_sku ); ?>" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-item_sku"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($item_price_meta); ?>">
						<?php echo sprintf( esc_html__('Item Price %s', SP4CF7_DOMAIN  ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($item_price_meta); ?>" name="<?php echo esc_attr($item_price_meta); ?>" type="text" value="<?php echo esc_attr( $item_price ); ?>" class="sp4cf7-item-price" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-item_price"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="<?php echo esc_attr($item_desc_meta); ?>">
						<?php echo sprintf( esc_html__('Item Description %s', SP4CF7_DOMAIN  ), '<span class="sp4cf7-required-field">*</span>' ); ?>
					</label>
				</div>
				<div class="col-75">
					<input id="<?php echo esc_attr($item_desc_meta); ?>" name="<?php echo esc_attr($item_desc_meta); ?>" type="text" value="<?php echo esc_attr( $item_desc ); ?>" />
					<span class="sp4cf7-help-tip" id="sp4cf7-help-item_desc"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label>
						<?php echo esc_html( __('Item Image', SP4CF7_DOMAIN  ) ); ?>
					</label>
				</div>
				<div class="col-75">
					<?php
					if( $image = wp_get_attachment_image_src( $item_img, 'medium' ) ) { ?>
						<div class="sp4cf7-img-container">
							<img src="<?php echo esc_url($image[0]) ?>" />
						</div>
						<a href="#" class="sp4cf7-upl button">Upload image</a>
						<a href="#" class="sp4cf7-rmv button">Remove image</a>
						<input type="hidden" name="<?php echo esc_attr($item_img_meta); ?>" value="<?php echo esc_attr($item_img) ?>">
					<?php } else { ?>
						<div class="sp4cf7-img-container"></div>
						<a href="#" class="sp4cf7-upl button">Upload image</a>
						<a href="#" class="sp4cf7-rmv button" style="display:none">Remove image</a>
						<input type="hidden" name="<?php echo esc_attr($item_img_meta); ?>" value="">
					<?php } ?>
				</div>
			</div>

			<div class="form-field">
				<div class="titledesc">
					<label for="sp4cf7_item_shipping">
						<?php echo esc_html__('Item Shipping', SP4CF7_DOMAIN ); ?>
					</label>
				</div>
				<div class="col-75">
					<input class="sp4cf7-item-price" id="sp4cf7_item_shipping" name="sp4cf7_item_shipping" type="text" value="0.00" />
					<span class="sp4cf7-update-pro dashicons-before dashicons-cart"></span>
				</div>
			</div>

			<div class="form-field">
				<div class="sp4cf7-opaque">
					<div class="sp4cf7-item-actions">
						<a href="#" class="sp4cf7-btn button button-hero" title="">Add Item</a>
						<a href="#" class="sp4cf7-btn button button-hero">Remove Item</a>
						<span class="sp4cf7-update-pro dashicons-before dashicons-cart"></span>
					</div>
				</div>
			</div>

			<div class="sp4cf7-opaque">
				<div class="dynamic-wrapper-pro"></div>
				<div class="dynamic-only-pro">
					<div> 
			        	<a href="https://www.pluginspro.io" target="_blank">Available only in <br><strong>Add Stripe Payments for Contact Form 7 Pro</strong></a>
			        </div>
				</div>

				<h4>Additional Settings</h4>

				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_add_to_order">
							<?php _e( 'Enable "Add to Order" feature', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<label class="switch">
							<input id="sp4cf7_add_to_order" name="sp4cf7_add_to_order" type="checkbox" class="enable_required" value="1" /> 
							<div class="slider round"></div>
						</label> <span class="sp4cf7-help-tip" id="sp4cf7-help-add_to_order"></span>
					</div>
				</div>

				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_currency">
							<?php echo sprintf( esc_html__( 'Select Currency %s', SP4CF7_DOMAIN ), '<span class="sp4cf7-required-field">*</span>' ); ?>
						</label>
					</div>
					<div class="col-75">
						<select id="sp4cf7_currency" name="sp4cf7_currency">
							<option><?php _e( 'Select Currency', SP4CF7_DOMAIN ); ?></option>
							<?php 
							if ( count( $currencies ) > 0 ) {
								foreach ( $currencies as $key => $value )
									echo '<option value="' . esc_attr( $key ) . '" ' . selected( $currency, $key, false ) . '>'. esc_html( $value ) . '</option>';
							}
							?>
						</select>
						<span class="sp4cf7-help-tip" id="sp4cf7-help-currency"></span>
					</div>
				</div>
				
				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_quantity">
							<?php _e( 'Show Quantity Option', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<label class="switch">
							<input id="sp4cf7_quantity" name="sp4cf7_quantity" type="checkbox" class="enable_required" value="1"  /> 
							<div class="slider round"></div>
						</label> <span class="sp4cf7-help-tip" id="sp4cf7-help-quantity"></span>
					</div>
				</div>

				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_coupons">
							<?php _e( 'Enable Coupons', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<label class="switch">
							<input id="sp4cf7_coupons" name="sp4cf7_coupons" type="checkbox" class="enable_required" value="1"  /> 
							<div class="slider round"></div>
						</label> <span class="sp4cf7-help-tip" id="sp4cf7-help-coupons"></span>
					</div>
				</div>

				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_tax_rate">
							<?php _e( 'Tax Rate Amount (Percentage)', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<input class="sp4cf7-item-price" id="sp4cf7_tax_rate" name="sp4cf7_tax_rate" type="text" value="0.00" />
						<span class="sp4cf7-help-tip" id="sp4cf7-help-tax-rate"></span>
					</div>
				</div>
				
				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_succes_url">
							<?php _e( 'Success URL', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<select id="sp4cf7_succes_url" name="sp4cf7_succes_url">
							<option><?php _e( 'Select page', SP4CF7_DOMAIN ); ?></option>
							<?php
							if( !empty( $all_pages ) ) {
								foreach ( $all_pages as $post_id => $title ) {
									echo '<option value="' . esc_attr( $post_id ) . '" ' . selected( $success_url, $post_id, false )  . '>' . esc_html($title) . '</option>';
								}
							}
							?>
						</select>
						<span class="sp4cf7-help-tip" id="sp4cf7-help-success-url"></span>
					</div>
				</div>
				<div class="form-field">
					<div class="titledesc">
						<label for="sp4cf7_cancel_url">
							<?php _e( 'Cancel URL', SP4CF7_DOMAIN ); ?>
						</label>
					</div>
					<div class="col-75">
						<select id="sp4cf7_cancel_url" name="sp4cf7_cancel_url">
							<option><?php _e( 'Select page', SP4CF7_DOMAIN ); ?></option>
							<?php
							if( !empty( $all_pages ) ) {
								foreach ( $all_pages as $post_id => $title ) {
									echo '<option value="'. esc_attr( $post_id ) .'" ' . selected( $cancel_url, $post_id, false ) . '>' . esc_html($title) . '</option>';
								}
							}
							?>
						</select>
						<span class="sp4cf7-help-tip" id="sp4cf7-help-cancel-url"></span>
					</div>
				</div>
			</div>

			<input type="hidden" name="post" value="<?php echo esc_attr( $post_id ); ?>">
		</div>
	</div>
	<p>* Required Fields</p>
	<p><span style="padding-right: 15px;" class="sp4cf7-update-pro dashicons-before dashicons-cart"></span> <a href="https://www.pluginspro.io" target="_blank">Available only in <strong>Add Stripe Payments for Contact Form 7 Pro</strong></a></p>
</div>

<?php 
do_action(SP4CF7_DOMAIN . '_show_metabox_help');
?>
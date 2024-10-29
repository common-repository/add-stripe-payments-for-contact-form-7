<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.pluginspro.io
 * @since      1.0.0
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/public/partials
 */

$form_id_element =  esc_attr( $form_id );

?>

<div class="sp4cf7-public__payments">
    <div class="sp4cf7-public__payments--header">
        <h4>Payment</h4>
        <?php do_action(  SP4CF7_DOMAIN . '_show_test_mode_label', $form_id ); ?>
    </div>
    <div class="sp4cf7-public_payments--body">
        <label for="card-element-<?php echo $form_id_element; ?>">
      		Credit or debit card
        </label>
        <div id="card-element-<?php echo $form_id_element; ?>" class="sp4cf7-card-element-input"></div>
    	<div class="sp4cf7-card-icons-container">
            <img class="sp4cf7-public__stripe-card-icon" src="<?php echo SP4CF7_URI . 'public/assets/img/cards/amex.svg'; ?>">
            <img class="sp4cf7-public__stripe-card-icon" src="<?php echo SP4CF7_URI . 'public/assets/img/cards/discover.svg'; ?>">
            <img class="sp4cf7-public__stripe-card-icon" src="<?php echo SP4CF7_URI . 'public/assets/img/cards/visa.svg'; ?>">
            <img class="sp4cf7-public__stripe-card-icon" src="<?php echo SP4CF7_URI . 'public/assets/img/cards/mastercard.svg'; ?>">
    	</div>

        <!-- Used to display form errors. -->
        <div id="card-errors-<?php echo $form_id_element; ?>" role="alert" class="sp4cf7-card-error"></div>
        <span class="wpcf7-form-control-wrap <?php echo $tag->name; ?> sp4cf7-public__payments--card-errors">
            <input type="hidden" name="card-errors" value="" class="wpcf7-form-control">
        </span>
    </div>
</div>
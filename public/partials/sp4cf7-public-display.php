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
?>
<div class="sp4cf7-public-wrapper">
    <div class="sp4cf7-public__items">
        <?php if (!empty($item_name[0]) && !empty($item_price[0])) { ?>
        <div class="sp4cf7-public__items--item">
            <?php if ($item_img[0]): ?>
            <div class="sp4cf7-public__items--item-img">
            <?php echo wp_get_attachment_image($item_img[0], 'medium', false, array( "class" => "img-fluid" )); ?>
            </div> 
            <?php endif ?>
            <div class="sp4cf7-public__items--item-info">
                <h3 class="sp4cf7-public__items--item-info-name"><?php _e($item_name[0],SP4CF7_DOMAIN) ?></h3>
                <h4 class="sp4cf7-public__items--item-info-sku"><?php _e($item_sku[0], SP4CF7_DOMAIN) ?></h4>
                <p class="sp4cf7-public__items--item-info-description"><?php _e($item_desc[0],SP4CF7_DOMAIN) ?></p>
            </div>
            <div class="sp4cf7-public__items--item-total">
                <h4 class="sp4cf7-public__total"><?php _e('$' . number_format_i18n( $item_price[0], 2 ), SP4CF7_DOMAIN); ?></H4>
            </div>
        </div>
        
        <?php } ?>

    </div>

    <div class="sp4cf7-public__order-summary <?php echo $form_id ?>">
        <div class="sp4cf7-public__fee sp4cf7-public__total">
            <h4 class="sp4cf7-public__order-summary--fees-desc">Total</h4>
            <h3 class="sp4cf7-public__order-summary--fees-price">
                <span class="sp4cf7-public__total"><?php _e('$' . number_format_i18n( $item_price[0], 2 ), SP4CF7_DOMAIN); ?></span>
            </h3>
        </div>
        <?php
            include_once( SP4CF7_PATH . 'public/partials/'.SP4CF7_DOMAIN.'-public-card-element.php' );
        ?>
    </div>

</div>
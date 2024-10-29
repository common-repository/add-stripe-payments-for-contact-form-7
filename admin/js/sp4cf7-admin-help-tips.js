jQuery(document).ready( function($) {
	//jQuery selector to point to
	/*$( '#sp4cf7-help-test-publishable-key' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-test-publishable-key' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.test_publishable_key_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-test-secret-key' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-test-secret-key' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.test_secret_key_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-live-publishable-key' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-live-publishable-key' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.live_publishable_key_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-live-secret-key' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-live-secret-key' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.live_secret_key_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-item_name' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-item_name' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.item_name,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-item_sku' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-item_sku' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.item_sku,
			position: 'left center',
		} ).pointer('open');
	} );
	
	$( '#sp4cf7-help-item_price' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-item_price' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.item_price,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-item_desc' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-item_desc' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.item_description,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-amount' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-amount' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.amount_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-currency' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-currency' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.currency_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-customer-email' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-customer-email' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.customer_email_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-description' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-description' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.description_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-quantity' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-quantity' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.quantity_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-success-url' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-success-url' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.success_url_tip,
			position: 'left center',
		} ).pointer('open');
	} );

	$( '#sp4cf7-help-cancel-url' ).on( 'hover click', function() {
		$( 'body .wp-pointer-buttons .close' ).trigger( 'click' );
		$( '#sp4cf7-help-cancel-url' ).pointer({
			pointerClass: 'wp-pointer sp4cf7-pointer',
			content: sp4cf7_admin_help_tips_params.cancel_url_tip,
			position: 'left center',
		} ).pointer('open');
	} );*/

	$('#sp4cf7-help-test-publishable-key').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.test_publishable_key_tip,
		// autoClose: false,
		// hideOnClick: false,
		interactive: true,
		animation: 'grow',
		// trigger: 'click',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
		// triggerOpen: {
		// 	click: true,  // For mouse
		// 	tap: true    // For touch device
		// },
		// triggerClose: {
		// 	click: true,  // For mouse
		// 	tap: true    // For touch device
		// }
	});

	$('#sp4cf7-help-test-secret-key').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.test_secret_key_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-live-publishable-key').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.live_publishable_key_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-live-secret-key').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.live_secret_key_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-item_name').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.item_name,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-item_sku').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.item_sku,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-item_price').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.item_price,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-item_desc').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.item_description,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-amount').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.amount_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-currency').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.currency_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-customer-email').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.customer_email_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-customer-name').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.customer_name_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-description').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.description_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-quantity').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.quantity_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-success-url').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.success_url_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

	$('#sp4cf7-help-cancel-url').tooltipster({ 
		contentAsHTML: true,
		content: sp4cf7_admin_help_tips_params.cancel_url_tip,
		interactive: true,
		animation: 'grow',
		theme: 'sp4cf7-custom-theme-tooltip',
		position: "right",
	});

} );

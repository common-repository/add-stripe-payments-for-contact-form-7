( function($) {
	"use strict";

	if ($('#sp4cf7-metabox-help').length) {
		$('#informationdiv').after($('#sp4cf7-metabox-help'));
	}

	if ($('.sp4cf7-item-price').length) {
		$('.sp4cf7-item-price').mask("#,##0.00", {reverse: true});
	}

	$( document ).on( 'change', 'input#sp4cf7_enable_test_mode', function() {
		if ( $( this ).is(':checked' ) ) {
			$( '.sp4cf7-settings .test-key' ).show();
			$( '.sp4cf7-settings .live-key' ).hide();
		} else {
			$( '.sp4cf7-settings .test-key' ).hide();
			$( '.sp4cf7-settings .live-key' ).show();
		}
	} );

	$('body').on( 'click', '.sp4cf7-btn', function(e){
		e.preventDefault();
	});

	// on upload button click
	$('body').on( 'click', '.sp4cf7-upl', function(e){
 		
		e.preventDefault();
 		
		var button = $(this),
			custom_uploader = wp.media({
				title: 'Insert image',
				library : {
					// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
					type : 'image'
				},
				button: {
					text: 'Use this image' // button label text
				},
				multiple: false
			}).on('select', function() { // it also has "open" and "close" events
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				button.siblings('.sp4cf7-img-container').empty().append('<img src="' + attachment.url + '">');
				button.next().css('display', 'inline-block').next().val(attachment.id);
			}).open();
 	
	});
 	
	// on remove button click
	$('body').on('click', '.sp4cf7-rmv', function(e){
 
		e.preventDefault();
 
		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().siblings('.sp4cf7-img-container').empty();
	});

} )( jQuery );

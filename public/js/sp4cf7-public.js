(function( $ ) {
	'use strict';

	// $( document ).ready( function() {
	// 	$( '.wpcf7 form.wpcf7-form.sp4cf7' ).off( 'submit' );
	// });

	if ( typeof wpcf7 === 'undefined' || wpcf7 === null ) {
		return;
	}

	var wpcf7_sp4cf7_extend = $.extend( {
		cached: 0,
		inputs: []
	}, wpcf7 );

	$( document ).on('wpcf7mailsent', function( event ) {
		let contactform_id = event.detail.contactFormId,
			transaction_successfully = event.detail.apiResponse.transaction_successfully,
			message = event.detail.apiResponse.message;
		
		if ( transaction_successfully != '' && typeof transaction_successfully !== 'undefined' ) {

			var _form = $('form.sp4cf7 input[name="_wpcf7"][value="'+contactform_id+'"]').closest('form'),
				_message = message.split('||'),
				_titles = _message.splice(0, 2),
				_last = _message.pop();

			var info = [];
			for ( let _key in _message ) {
				let _info_trans = _message[_key].split('^^');
				info.push('<li><strong>'+_info_trans[0]+':</strong> <span class="sp4cf7-value">'+_info_trans[1]+'</span></li>');
			}

			var html = [
				'<div class="sp4cf7-stripe-response">',
				'<h4>'+_titles[0]+'</h4>',
				'<h5>'+_titles[1]+':</h5>',
				'<ul>',
					info.join(''),
				'</ul>',

				'<h5>'+_last+'</h5>',
				'</div>'
			].join('');

			var el_response = _form.find('.wpcf7-response-output')
			el_response.hide();
			setTimeout(function() { 
				el_response.html(html).show();
			}, 1000);
		}
	} );

	wpcf7_sp4cf7_extend.getId = form => {
		return parseInt( $( 'input[name="_wpcf7"]', form ).val(), 10 );
	};

	wpcf7_sp4cf7_extend.stripeTokenHandler = ( token, form  ) => {
		// Insert the token ID into the form so it gets submitted to the server
		if (form.find('input[name="sp4cf7_stripe_token"]').length <= 0) {
			var hiddenInput = $('<input/>', {
				'type'  : 'hidden',
				'name'  : 'sp4cf7_stripe_token',
				'value' : token.id
			}).appendTo( form );
		} else {
			form.find('input[name="sp4cf7_stripe_token"]').val(token.id);
		}
	}

	wpcf7_sp4cf7_extend.initForm = function( form ) {
		var $form = $( form ),
			form_id = wpcf7_sp4cf7_extend.getId( $form ),
			stripe,
			elements,
			card;
		
		if( sp4cf7_public_params.sp4cf7_stripe_keys[form_id] ) {

			stripe = Stripe( sp4cf7_public_params.sp4cf7_stripe_keys[form_id] );
			elements = stripe.elements();

			// Create an instance of the card Element
			card = elements.create( 'card', { style: JSON.parse( sp4cf7_public_params.sp4cf7_stripe_style[form_id] ) } );

			if ($( '#card-element-' + form_id ).length) {

				// Add an instance of the card Element into the `card-element` <div>
				card.mount( '#card-element-' + form_id );

				// Handle real-time validation errors from the card Element.
				card.on( 'change', function( event ) {
					var displayError = $( '#card-errors-' + form_id );
					if ( event.error ) {
						displayError.text(event.error.message);
					} else {
						displayError.text('');
					}
				} );
			}
		}

		$form.on( 'click', 'input.wpcf7-submit[type="submit"]', function(event) {

			var _el = $(this);
			
			if (typeof _el.data("creatingToken") !== 'undefined') {
				return false;
			}

			if (typeof _el.data("tokenCreated") !== 'undefined' && _el.data("tokenCreated") === true) {
				_el.removeData('tokenCreated');

				return true;
			}

			if( sp4cf7_public_params.sp4cf7_stripe_keys[form_id] ) {

				if ($( '#card-element-' + form_id ).length) {

					stripe.createToken( card ).then( ( result ) => {
						
						_el.removeData('creatingToken');

						if ( result.error ) {
							// Inform the user if there was an error
							var errorElement = $( '#card-errors-' + form_id );
							errorElement.text(result.error.message);
						} else {
							_el.closest('form').addClass('submitting');

							wpcf7_sp4cf7_extend.stripeTokenHandler( result.token, $form );
							_el.data('tokenCreated', true);
							_el.trigger('click');
						}

					}, ( result ) => {
						
					} );

				} else {
					$('.wpcf7-response-output', $form ).text('The card element does not exists. Please set up correctly the form in order to get payments working well.').show();
					return false;
				}

				_el.data('creatingToken', true);

				return false;
				
			}
				
		} );

	};

	$( function() {
		
		$( 'div.wpcf7 > form.sp4cf7' ).each( function() {
			var $form = $( this );
			wpcf7_sp4cf7_extend.initForm( $form );

		} );
	} );

})( jQuery );

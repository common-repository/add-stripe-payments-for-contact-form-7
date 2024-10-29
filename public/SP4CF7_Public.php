<?php

namespace SP4CF7\_Public;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/public
 * @author     Performa Technologies <developer1@performatechnologies.com>
 */
class SP4CF7_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sp4cf7    The ID of this plugin.
	 */
	private $sp4cf7;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sp4cf7       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sp4cf7, $version ) {

		$this->sp4cf7 = $sp4cf7;
		$this->version = $version;

	}

	public function init() {

		// var_dump(session_id());
		if ( !headers_sent() && '' == session_id() ) {
		// if ( !session_id() ) {
			session_start();
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sp4cf7 . '_public_css', plugin_dir_url( __FILE__ ) . 'css/sp4cf7-public-2.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->sp4cf7 . '_public_script_css', plugin_dir_url( __FILE__ ) . 'css/sp4cf7-public-script.css', array(), $this->version );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$get_posts = get_posts(
			array(
				'post_type'   => 'wpcf7_contact_form',
				'numberposts' => -1,
				'meta_key'    => SP4CF7PMP . 'use_stripe',
				'meta_value'  => '1',
				'fields'      => 'ids',
			)
		);

		$stripe_api = $stripe_api_style = array();

		$style = array(
			'base' => array(
				'color' => '#32325d',
				'fontFamily' => '"Helvetica Neue", Helvetica, sans-serif',
				'fontSmoothing' => 'antialiased',
				'fontSize' => '16px',
				'::placeholder' => array(
					'color' => '#aab7c4'
				)
			),
			'invalid' => array(
				'color' => '#fa755a',
				'iconColor' => '#fa755a'
			)
		);

		if ( !empty( $get_posts ) ) {
			foreach ( $get_posts as $id ) {
				$enable_test_mode		= get_post_meta( $id, SP4CF7PMP . 'enable_test_mode', true );
				$test_publishable_key	= get_post_meta( $id, SP4CF7PMP . 'test_publishable_key', true );
				$live_publishable_key	= get_post_meta( $id, SP4CF7PMP . 'live_publishable_key', true );
				$stripe_api[$id]		= ( !empty( $enable_test_mode ) ? $test_publishable_key : $live_publishable_key );
				$stripe_api_style[$id]	= apply_filters($this->sp4cf7 . '_styling_stripe_form_' . $id, json_encode( $style ) );
			}
		}

		$args = array(
			// SP4CF7_DOMAIN . '_ajax_url' => admin_url( 'admin-ajax.php' ),
			// SP4CF7_DOMAIN . '_active' => $get_posts,
			SP4CF7_DOMAIN . '_stripe_keys' => $stripe_api,
			SP4CF7_DOMAIN . '_stripe_style' => $stripe_api_style
		);


		if ( !empty( $get_posts ) ) {
			wp_enqueue_script( $this->sp4cf7 . '_stripe', 'https://js.stripe.com/v3/', array( 'jquery-core', 'contact-form-7', $this->sp4cf7 . '_public_js' ), '3' );
		}

		wp_enqueue_script( $this->sp4cf7 . '_public_js', plugin_dir_url( __FILE__ ) . 'js/sp4cf7-public.js', array( 'jquery', 'contact-form-7' ), $this->version, false );
		wp_localize_script( $this->sp4cf7 . '_public_js', SP4CF7_DOMAIN . '_public_params', $args );

	}

	public function wpcf7_form_class_attr( $classes ) {

		$form =  \WPCF7_ContactForm::get_current();
		$form_id = $form->id();

		if ( !empty( $form_id ) && !empty( get_post_meta( $form_id, SP4CF7PMP . 'use_stripe', true ) ) ) {
			return $classes . ' sp4cf7';
		}

		return $classes;
	}

	/**
	 * Action: wpcf7_init
	 *
	 * - Added new form tag and render the form into frontend with validation.
	 *
	 * @method action__wpcf7_init
	 *
	 */
	public function wpcf7_init() {

		// if (!is_admin())
		// 	require_once SP4CF7_PATH . 'includes/stripe/init.php';

		wpcf7_add_form_tag( array( 'stripe', 'stripe*' ), array( $this, 'add_html_tag_stripe' ), array( 'name-attr' => true ) );

		add_filter( 'wpcf7_validate_stripe',  array( $this, 'wpcf7_stripe_validation' ), 10, 2 );

		
	}

	/**
	 * - Render CF7 Shortcode on front end.
	 *
	 * @method add_html_tag_stripe
	 *
	 * @param $tag
	 *
	 * @return html
	 */
	public function add_html_tag_stripe( $tag ) {
		
		if (is_admin())
			return '';

		$form_instance = \WPCF7_ContactForm::get_current();
		$form_id       = $form_instance->id();

		$use_stripe    = get_post_meta($form_id, SP4CF7PMP . 'use_stripe', true);
		
		if ( empty( $use_stripe ) || empty( $tag->name ) )
			return '';

		$validation_error = wpcf7_get_validation_error( $tag->name );

		$atts = array(
			'aria-invalid' => ($validation_error) ? 'true' : 'false',
			'name' => $tag->name,
			'type' => 'hidden',
			'value' => 1
		);

		if ( $tag->is_required() )
			$atts['aria-required'] = 'true';

		$atts = wpcf7_format_atts($atts);

		if ( !empty( $this->_validate_fields( $form_id ) ) )
			return $this->_validate_fields( $form_id );

		$found = 0;

		ob_start();

		if ( $contact_form = wpcf7_get_current_contact_form() ) {
			$form_tags = $contact_form->scan_form_tags();

			foreach ( $form_tags as $k => $v ) {

				if ( $v['type'] == $tag->type )
					$found++;

				if ( $v['name'] == $tag->name ) {
					if ( $found == 1 ) {
						$enable_test_mode = get_post_meta( $form_id, SP4CF7PMP . 'enable_test_mode', true );
						$item_name  = (array)get_post_meta($form_id, SP4CF7PMP . 'item_name', true);
						$item_sku   = (array)get_post_meta($form_id, SP4CF7PMP . 'item_sku', true);
						$item_price = (array)get_post_meta($form_id, SP4CF7PMP . 'item_price', true);
						$item_desc  = (array)get_post_meta($form_id, SP4CF7PMP . 'item_desc', true);
						$item_img   = (array)get_post_meta($form_id, SP4CF7PMP . 'item_img', true);
						include_once( SP4CF7_PATH . 'public/partials/'.SP4CF7_DOMAIN.'-public-display.php' );
					}
					break;
				}
			}
		}

		return ob_get_clean();
	}

	/**
	 * Function: _validate_fields
	 *
	 * @method _validate_fields
	 *
	 * @param int $form_id
	 *
	 * @return string
	 */
	private function _validate_fields( $form_id ) {

		$enable_test_mode     = get_post_meta( $form_id, SP4CF7PMP . 'enable_test_mode', true );
		$test_publishable_key = get_post_meta( $form_id, SP4CF7PMP . 'test_publishable_key', true );
		$test_secret_key      = get_post_meta( $form_id, SP4CF7PMP . 'test_secret_key', true );
		$live_publishable_key = get_post_meta( $form_id, SP4CF7PMP . 'live_publishable_key', true );
		$live_secret_key      = get_post_meta( $form_id, SP4CF7PMP . 'live_secret_key', true );

		if ( !empty( $enable_test_mode ) ) {

			if ( empty( $test_publishable_key ) )
				return __( 'Please enter Stripe Test Publishable Key.', SP4CF7_DOMAIN );

			if ( empty( $test_secret_key ) )
				return __( 'Please enter Stripe Test Secret Key.', SP4CF7_DOMAIN );

		} else {

			if ( empty( $live_publishable_key ) )
				return __( 'Please enter Stripe Live Publishable Key.', SP4CF7_DOMAIN );

			if ( empty( $live_secret_key ) )
				return __( 'Please enter Stripe Live Secret Key.', SP4CF7_DOMAIN );

		}
		return false;
	}

	/**
	 * Filter: wpcf7_validate_stripe
	 *
	 * - Perform Validation on stripe card details.
	 *
	 * @param  object  $result WPCF7_Validation
	 * @param  object  $tag    Form tag
	 *
	 * @return object
	 */
	public function wpcf7_stripe_validation( $result, $tag ) {

		$id = isset( $_POST[ '_wpcf7' ] ) ? sanitize_text_field($_POST[ '_wpcf7' ]) : '';

		if ( empty( $id ) ) {
			return $result;
		}

		$use_stripe = get_post_meta( $id, SP4CF7PMP . 'use_stripe', true );
		if ( empty( $use_stripe ) )
			return $result;

		$stripe = isset( $_POST[ 'sp4cf7_stripe_token' ] ) ? sanitize_text_field($_POST[ 'sp4cf7_stripe_token' ]) : '';
		if ( empty( $stripe ) )
			$result->invalidate( $tag, 'Please enter correct card details. ' );

		return $result;
	}

	/**
	 * Action: CF7 before send email
	 *
	 * @method wpcf7_before_send_mail
	 *
	 * @param  object $contact_form WPCF7_ContactForm::get_instance()
	 * @param  bool   $abort
	 * @param  object $contact_form WPCF7_Submission class
	 *
	 */
	public function wpcf7_before_send_mail( $contact_form, &$abort, $wpcf7_submission ) {

		$submission    = \WPCF7_Submission::get_instance(); // CF7 Submission Instance
		$form_ID       = $contact_form->id();
		$form_instance = \WPCF7_ContactForm::get_instance( $form_ID ); // CF7 From Instance

		$posted_data = array();
		if ( $submission ) {
			// CF7 posted data
			$posted_data = $submission->get_posted_data();
		}

		if ( !empty( $form_ID ) ) {

			$use_stripe = get_post_meta( $form_ID, SP4CF7PMP . 'use_stripe', true );

			if ( empty( $use_stripe ) )
				return;
			
			$enable_test_mode = get_post_meta( $form_ID, SP4CF7PMP . 'enable_test_mode', true );
			$test_secret_key  = get_post_meta( $form_ID, SP4CF7PMP . 'test_secret_key', true );
			$live_secret_key  = get_post_meta( $form_ID, SP4CF7PMP . 'live_secret_key', true );
			$item_name        = (array) get_post_meta( $form_ID, SP4CF7PMP . 'item_name', true );
			$item_name        = $item_name[0];
			$item_sku         = (array) get_post_meta( $form_ID, SP4CF7PMP . 'item_sku', true );
			$item_sku         = $item_sku[0];
			$item_price       = (array) get_post_meta( $form_ID, SP4CF7PMP . 'item_price', true );
			$item_price       = $item_price[0];
			$item_desc        = (array) get_post_meta( $form_ID, SP4CF7PMP . 'item_desc', true );
			$item_desc        = $item_desc[0];
			$item_desc	      = ( !empty( $item_desc ) ) ? $item_desc : get_bloginfo( 'name' );

			$secret_key = ( !empty( $enable_test_mode ) ? $test_secret_key : $live_secret_key );
			if( empty( $secret_key ) ) {
				$abort = true;
				$wpcf7_submission->set_status( SP4CF7_DOMAIN . '_invalid_stripe_secret_key' );
				$wpcf7_submission->set_response( __( 'Please enter a valid Stripe Secret Key', SP4CF7_DOMAIN ) );
				add_filter( 'wpcf7_skip_mail', '__return_true' );

				return;
			}

    		$purchased_items[] = array(
    			'item_name'     => $item_name,
    			'item_sku'      => $item_sku,
    			'item_price'    => $item_price,
    			'item_desc'     => $item_desc,
    			'item_img'      => null,
    			'item_qty'      => 1
    		);

			$description = sprintf( "Online Purchase From %s.", get_bloginfo( 'name' ) );
			$description = apply_filters( SP4CF7_DOMAIN . '_stripe_description', $description, $purchased_items, $posted_data, $contact_form );
			// sprintf('%s, %s. %s - %s', $item_name, $item_sku, ($amount / 100), $item_desc)

			$email       = get_post_meta( $form_ID, SP4CF7PMP . 'email', true );
			$email       = ( ( !empty( $email ) && isset( $posted_data[$email] ) ) ? strip_tags(trim($posted_data[$email])) : '' );

			$customer_name  = get_post_meta( $form_ID, SP4CF7PMP . 'customer_name', true );
			$customer_name  = ( ( !empty( $customer_name ) && isset( $posted_data[$customer_name] ) ) ? strip_tags(trim($posted_data[$customer_name])) : '' );
			
			$amount = (float) ( ( empty( $item_price ) ) ? 0 : $item_price );
			if ( $amount <= 0 ) {
				$abort = true;
				$wpcf7_submission->set_status( SP4CF7_DOMAIN . '_invalid_amount' );
				$wpcf7_submission->set_response( __( 'Please enter a valid amount value.', SP4CF7_DOMAIN ) );
				add_filter( 'wpcf7_skip_mail', '__return_true' );

				return;
			}
			$amount = sprintf('%0.2f', $amount) * 100;

			if ( isset($posted_data['sp4cf7_stripe_token']) && !empty( $posted_data['sp4cf7_stripe_token'] ) ) {

				\Stripe\Stripe::setApiKey( $secret_key );

				$declined = true;
				try {
					
					$token = $posted_data['sp4cf7_stripe_token'];
					$customer = null;
					if (!empty($email) && !empty($customer_name)) {
						$args_customer = array(
							'email' => $email,
							'name' => $customer_name,
							'source' => $token,
							'description' => $description
						);
						$customer = \Stripe\Customer::create($args_customer);

					}
					
					$_charge = array(
						'amount' => $amount,
						'currency' => 'usd',
						'source' => $token,
						'description' => $description
					);

					if (!empty($customer)) {
						$_charge['customer'] = $customer->id;
						unset($_charge['source']);
					}
					
					$charge = \Stripe\Charge::create( $_charge );

					do_action(  SP4CF7_DOMAIN . '_stripe_payment_success', $charge );

					$declined = false;
				} catch(\Stripe\Exception\CardException $e) {
					// Since it's a decline, \Stripe\Exception\CardException will be caught
					// echo 'Status is:' . $e->getHttpStatus() . '\n';
					// echo 'Type is:' . $e->getError()->type . '\n';
					// echo 'Code is:' . $e->getError()->code . '\n';
					// // param is '' in this case
					// echo 'Param is:' . $e->getError()->param . '\n';
					// echo 'Message is:' . $e->getError()->message . '\n';
				} catch (\Stripe\Exception\RateLimitException $e) {
					// Too many requests made to the API too quickly
				} catch (\Stripe\Exception\InvalidRequestException $e) {
					// Invalid parameters were supplied to Stripe's API
				} catch (\Stripe\Exception\AuthenticationException $e) {
					// Authentication with Stripe's API failed
					// (maybe you changed API keys recently)
				} catch (\Stripe\Exception\ApiConnectionException $e) {
					// Network communication with Stripe failed
				} catch (\Stripe\Exception\ApiErrorException $e) {
					// Display a very generic error to the user, and maybe send
					// yourself an email
				} catch ( Exception $e ) {
					// Something else happened, completely unrelated to Stripe
				}

				if ($declined) {
					do_action(  SP4CF7_DOMAIN . '_stripe_payment_error', $e );

					$err_msg = (!empty($e->getError()->code)) 
						? sprintf('%s: %s. %s', $e->getError()->code, $e->getError()->type, $e->getMessage())
						: sprintf('%s. %s', $e->getError()->type, $e->getMessage());

					$abort = true;
					$wpcf7_submission->set_status( SP4CF7_DOMAIN . '_gateway_error' );
					$wpcf7_submission->set_response( __(sprintf('Gateway error: "%s"', $err_msg ), SP4CF7_DOMAIN) );

					add_filter( 'wpcf7_skip_mail', '__return_true' );

					return $submission;

				}

				$payment_status = $charge->status;
				if ( $payment_status == 'succeeded' ) {

					$amount = $charge->amount;
					$currency = $charge->currency;
					$charge_id =  $charge->id;
					$transaction_id = $charge->balance_transaction;
					$transaction_status = $payment_status;

					$inserted_post = wp_insert_post( 
						array (
							'post_type' => SP4CF7_POST_TYPE,
							'post_title' => $charge_id,
							'post_status' => 'publish'
						)
					);

					if ( !is_wp_error($inserted_post) ) {

						add_post_meta( $inserted_post, '_currency', $currency );
						add_post_meta( $inserted_post, '_form_id', $form_ID );
						add_post_meta( $inserted_post, '_charge_id', $charge_id );
						add_post_meta( $inserted_post, '_request_ip', $this->getUserIpAddr() );
						add_post_meta( $inserted_post, '_total', ($amount / 100) );
						add_post_meta( $inserted_post, '_transaction_id', $transaction_id );
						add_post_meta( $inserted_post, '_transaction_response', json_encode( $charge ) );
						add_post_meta( $inserted_post, '_transaction_status', $transaction_status );
						add_post_meta( $inserted_post, '_transaction_datetime', date('m-d-Y H:i:s', $charge->created ) );

						$_posted_data = $posted_data;
						$_posted_data = $posted_data;
							$_posted_data = array_filter( $_posted_data, function($key) {
							    return strpos($key, 'sp4cf7p_order_summary_item') !== 0 && strpos($key, 'stripe') !== 0;
							}, ARRAY_FILTER_USE_KEY );

						add_post_meta( $inserted_post, '_form_data', maybe_serialize( $_posted_data ) );

						add_post_meta( $inserted_post, '_purchased_items', maybe_serialize( $purchased_items ) );

						$purchased_items = array_map( function($pi) use ( $currency ) {
						  	$pi['currency'] = $currency;
						  	return $pi;
						}, $purchased_items );

					}

					add_filter( 'wpcf7_mail_tag_replaced',
						function( $replaced, $submitted, $html, $mail_tag ) use ( $transaction_id, $payment_status, $charge_id ) {

							if ( $mail_tag->corresponding_form_tag()->basetype == 'stripe' ) {

								$data = array(
									// 'Charge ID: ' . $charge_id,
									// 'Transaction ID: ' . $transaction_id,
									'Transaction Status: ' . $payment_status
								);

								return $html 
									? implode( '<br />', $data )
									: implode( "\n", $data );

							}
							return $replaced;
						},
						10, 4
					);

				} else {
					$wpcf7_submission->set_status( SP4CF7_DOMAIN . '_stripe_payment_' . $payment_status );
					$wpcf7_submission->set_response( __(sprintf('Stripe payment status: "%s". %s', $payment_status, $contact_form->message( 'mail_sent_ng' ) ), SP4CF7_DOMAIN ) );
				}

				add_filter( 'wpcf7_display_message',
					function( $message, $status ) use ( $amount, $currency, $transaction_id, $payment_status, $charge_id ) {

						if ($payment_status == 'succeeded') {

							add_filter( 'wpcf7_ajax_json_echo', function($response, $result ) {
								$response['transaction_successfully'] = true;

								return $response;
							}, 10, 2);
							// $html = '<div class="sp4cf7-stripe-response">' .
							// 	'<h5>Transaction Status:</h5>' .
							// 	'<ul>' .
							// 		'<li><span class="sp4cf7-b">Total Paid:</span> <span class="sp4cf7-value">' . sprintf( '%0.2f %s', $amount / 100, strtoupper($currency) ) .'</span></li>' .
							// 		'<li><span class="sp4cf7-b">Charge ID:</span> <span class="sp4cf7-value">' . sprintf( '%s', $charge_id ) . '</span></li>' .
							// 		'<li><span class="sp4cf7-b">Transaction Status:</span> <span class="sp4cf7-value">' . sprintf( '%s', $payment_status ) . '</span></li>' .
							// 		'<li><span class="sp4cf7-b">Transaction ID:</span> <span class="sp4cf7-value">' . sprintf( '%s', $transaction_id ) . '</span></li>' .
							// 	'</ul>' .
							// '</div>';
							
							$html = 'Transaction successfully completed. ' .
									'||Transaction Status' .
									'||Total Paid^^' . sprintf( '%0.2f %s', ( ($amount / 100) ), strtoupper($currency) ) .
									// '||Charge ID^^' . sprintf( '%s', $charge_id ) .
									'||Transaction Status^^' . sprintf( '%s', $payment_status ) .
									// '||Transaction ID^^' . sprintf( '%s', $transaction_id ) .
									'||' . $message;
							return ('mail_sent_ok' == $status)
								? $html
								: $message;

						} else {
							return $message;
						}

					},
					10, 2
				);
			} else {
				$abort = true;
				$wpcf7_submission->set_status( 'stripe_fail_token' );
				$wpcf7_submission->set_response( __(sprintf('Stripe Invalid Token. %s', $contact_form->message( 'mail_sent_ng' ) ), SP4CF7_DOMAIN) );
				add_filter( 'wpcf7_skip_mail', '__return_true', 20 );
			}

			return $submission;

		}
	}

	/**
	 * Function: getUserIpAddr
	 *
	 * @method getUserIpAddr
	 *
	 * @return string
	 */
	private function getUserIpAddr() {
		$ip = '';
		if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function show_test_mode_label( $post_id ) {
	    $enable_test_mode     = get_post_meta( $post_id, SP4CF7PMP . 'enable_test_mode', true );
		if ( !empty( $enable_test_mode ) ) {
			echo "<span class='sp4cf7-test-mode'>Test Mode</span>";
		}
	}
	

}
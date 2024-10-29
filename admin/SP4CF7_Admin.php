<?php

namespace SP4CF7\_Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/admin
 * @author     Performa Technologies <developer1@performatechnologies.com>
 */
class SP4CF7_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sp4cf7p    The ID of this plugin.
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
	 * @param      string    $sp4cf7p       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	
	private $show_help_tips;

	private $data_fields = array(
		'_currency'             => 'Currency code',
		'_email'                => 'Email Address',
		'_customer_name'        => 'Customer Name',
		'_form_data'            => 'Form data',
		'_purchased_items'      => 'Purchased Items',
		'_form_id'              => 'Form Name',
		'_charge_id'            => 'Charge ID',
		'_request_ip'           => 'Request IP',
		'_total'                => 'Total',
		'_transaction_datetime' => 'Transaction Datetime',
		'_transaction_id'       => 'Transaction ID',
		'_transaction_response' => 'Transaction response',
		'_transaction_status'   => 'Transaction status'
	);

	public function __construct( $sp4cf7, $version ) {

		$this->sp4cf7 = $sp4cf7;
		$this->version = $version;

		$this->show_help_tips = $this->fnt_show_help_tips();

		add_action( 'admin_notices', array( $this, 'show_notices' ) );

	}

	private function fnt_show_help_tips() {
		// Don't run on WP < 3.3
		return ( get_bloginfo( 'version' ) >= '3.3' );
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_register_style('select2-css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), '4.0.13');
		wp_register_style($this->sp4cf7 . '_admin_css', plugin_dir_url( __FILE__ ) . 'css/'.SP4CF7_DOMAIN.'-admin.css', array(), $this->version, 'all');
	    
    	if ( $this->show_help_tips == TRUE ) {
			// wp_enqueue_style( 'wp-pointer' );
			wp_register_style($this->sp4cf7 . '_admin_help_tooltipster_css', plugin_dir_url( __FILE__ ) . 'css/tooltipster.bundle.min.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_register_script( 'select2-js', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery-core' ), '4.0.13' );
		wp_register_script( $this->sp4cf7 . '_admin_mask_js', plugin_dir_url( __FILE__ ) . 'js/jquery.mask.min.js', array( 'jquery-core' ), $this->version, false );
		wp_register_script( $this->sp4cf7 . '_admin_js', plugin_dir_url( __FILE__ ) . 'js/'.SP4CF7_DOMAIN.'-admin.js', array( 'jquery-core' ), $this->version, false );


    	if ( $this->show_help_tips == TRUE ) {
			// wp_enqueue_script( 'wp-pointer' );
			wp_register_script( $this->sp4cf7 . '_admin_help_tooltipster_js', plugin_dir_url( __FILE__ ) . 'js/tooltipster.bundle.min.js', array( 'jquery' ), $this->version, true );
			wp_register_script( $this->sp4cf7 . '_admin_help_tips_js', plugin_dir_url( __FILE__ ) . 'js/'.SP4CF7_DOMAIN.'-admin-help-tips.js', array( 'jquery' ), $this->version, true );
		}

	}

	public function wpcf7_admin_init() {
		
		$tag_generator = \WPCF7_TagGenerator::get_instance();
		$tag_generator->add(
			'stripe',
			__( 'Stripe', SP4CF7_DOMAIN ),
			array( $this, 'wpcf7_tag_generator' )
		);
		
	}

	public function wpcf7_tag_generator( $contact_form, $args = '' ) {

		$args = wp_parse_args( $args, array() );
		$type = $args['id'];

		include_once( SP4CF7_PATH . 'admin/partials/'.SP4CF7_DOMAIN.'-tag-generator.php' );

	}

	public function init () {
		
	}

	public function wpcf7_editor_panels( $panels ) {

		$stripe_settings = array(
			'stripe-payments' => array(
				'title' => __( 'Stripe', SP4CF7_DOMAIN ),
				'callback' => array( $this, 'wpcf7_admin_stripe_settings' )
			)
		);

		$panels = array_merge($panels, $stripe_settings);

		return $panels;
	}

	public function wpcf7_admin_stripe_settings( $contact_form_instance ) {

		wp_enqueue_style( 'select2-css' );
		wp_enqueue_style( $this->sp4cf7 . '_admin_css' );

	    wp_enqueue_script('select2-js');
	    wp_enqueue_script($this->sp4cf7 . '_admin_mask_js');
	    wp_enqueue_script($this->sp4cf7 . '_admin_js');

	    wp_enqueue_style( 'dashicons' );

	    // I recommend to add additional conditions just to not to load the scipts on each page
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_add_inline_script( 'select2-js', "( function($) { $('#sp4cf7_success_url, #sp4cf7_cancel_url, #sp4cf7_currency' ).select2({ width: '95%' }); } )( jQuery );");

		$post_id = ( isset( $_REQUEST[ 'post' ] ) ? sanitize_text_field( $_REQUEST[ 'post' ] ) : '' );


		if ( $this->show_help_tips == TRUE ) {
			wp_enqueue_style( $this->sp4cf7 . '_admin_help_tooltipster_css' );
			wp_enqueue_script( $this->sp4cf7 . '_admin_help_tooltipster_js' );
			wp_enqueue_script( $this->sp4cf7 . '_admin_help_tips_js' );
			$this->help_tool_tips_settings();
		}

		if ( empty( $post_id ) ) {
			$wpcf7 = \WPCF7_ContactForm::get_current();
			$post_id = $wpcf7->id();
		}

		$contact_form = wpcf7_get_current_contact_form();
		$form_tags = $contact_form->scan_form_tags();

		include_once( SP4CF7_PATH . 'admin/partials/'.SP4CF7_DOMAIN.'-admin-display.php' );
		
	}

	private function help_tool_tips_settings() {
		
		$admin_help_tips_params = array(
			'test_publishable_key_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Get your test publishable key', SP4CF7_DOMAIN), 
					__( 'Get it from <a href="https://dashboard.stripe.com/" target="_blank"> Stripe</a> then <strong> Developers > API Keys </strong> page in your Stripe account.', SP4CF7_DOMAIN)
			),
			'test_secret_key_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Get your test secret key', SP4CF7_DOMAIN), 
					__( 'Get it from <a href="https://dashboard.stripe.com/" target="_blank"> Stripe</a> then <strong> Developers > API Keys </strong> page in your Stripe account.', SP4CF7_DOMAIN)
			),
			'live_publishable_key_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Get your live publishable key', SP4CF7_DOMAIN), 
					__( 'Get it from <a href="https://dashboard.stripe.com/" target="_blank"> Stripe</a> then <strong> Developers > API Keys </strong> page in your Stripe account.', SP4CF7_DOMAIN)
			),
			'live_secret_key_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Get your live secret key', SP4CF7_DOMAIN), 
					__( 'Get it from <a href="https://dashboard.stripe.com/" target="_blank"> Stripe</a> then <strong> Developers > API Keys </strong> page in your Stripe account.', SP4CF7_DOMAIN)
			),
			'item_name' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Enter Item name', SP4CF7_DOMAIN), 
					__( 'Please enter the item name', SP4CF7_DOMAIN)
			),
			'item_sku' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Enter Item SKU', SP4CF7_DOMAIN), 
					__( 'Please enter the item sku', SP4CF7_DOMAIN)
			),
			'item_price' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Enter Item price', SP4CF7_DOMAIN), 
					__( 'Please enter the item price. Remember enter a valid number price.', SP4CF7_DOMAIN)
			),
			'item_description' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Enter Item description', SP4CF7_DOMAIN), 
					__( 'Please enter the item description', SP4CF7_DOMAIN)
			),
			'amount_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Add price name', SP4CF7_DOMAIN), 
					__( 'Add here the name of price field.', SP4CF7_DOMAIN)
			),
			'currency_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Select currency', SP4CF7_DOMAIN), 
					__( 'Select the currency which is selected from your stripe.net merchant account.', SP4CF7_DOMAIN)
			),
			'customer_email_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Add customer email field', SP4CF7_DOMAIN), 
					__( 'Add customer email field from main form', SP4CF7_DOMAIN)
			),
			'customer_name_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Add customer name field', SP4CF7_DOMAIN), 
					__( 'Add customer name field from main form', SP4CF7_DOMAIN)
			),
			'description_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Add description', SP4CF7_DOMAIN), 
					__( 'Enter a custom description text. If this field is empty, then the wordpress blog name is sent to your stripe merchant account', SP4CF7_DOMAIN)
			),
			'quantity_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Show quantity option', SP4CF7_DOMAIN), 
					__( 'Show quantity option to the user', SP4CF7_DOMAIN)
			),
			'success_url_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Select success URL', SP4CF7_DOMAIN), 
					__( 'Select success URL', SP4CF7_DOMAIN)
			),
			'cancel_url_tip' => sprintf( '<h3> %s </h3> <p> %s </p>', 
					__( 'Select cancel URL', SP4CF7_DOMAIN), 
					__( 'Select cancel URL', SP4CF7_DOMAIN)
			)
		);
		wp_localize_script( $this->sp4cf7 . '_admin_help_tips_js', $this->sp4cf7 . '_admin_help_tips_params', $admin_help_tips_params );

	}

	public function add_meta_boxes() {
		add_meta_box( SP4CF7_DOMAIN.'-transaction', __( 'Transaction Details', SP4CF7_DOMAIN ), array( $this, 'sp4cf7_show_transactions' ), SP4CF7_POST_TYPE, 'normal', 'high' );
		add_meta_box( SP4CF7_DOMAIN.'-help-stripe-configuration', __( 'Do you need help for Stripe configuration?', SP4CF7_DOMAIN ), array( $this, 'metabox_help' ), SP4CF7_POST_TYPE, 'side', 'high' );

	}

	public function wpcf7_save_contact_form( $WPCF7_form ) {

		if (!is_admin())
			return;

		$wpcf7 = \WPCF7_ContactForm::get_current();

		if ( empty( $wpcf7 ) ) {
			return;
		}
		$post_id = $wpcf7->id();

		$form_fields = array(
			SP4CF7PMP . 'use_stripe',
			SP4CF7PMP . 'enable_test_mode',
			SP4CF7PMP . 'test_publishable_key',
			SP4CF7PMP . 'test_secret_key',
			SP4CF7PMP . 'live_publishable_key',
			SP4CF7PMP . 'live_secret_key',
			SP4CF7PMP . 'email',
			SP4CF7PMP . 'customer_name',
			SP4CF7PMP . 'item_name',
			SP4CF7PMP . 'item_sku',
			SP4CF7PMP . 'item_price',
			SP4CF7PMP . 'item_desc',
			SP4CF7PMP . 'item_img',
		);

		if ( !empty( $form_fields ) ) {
			foreach ( $form_fields as $key ) {
				$keyval = isset ($_REQUEST[ $key ] ) ? sanitize_text_field( $_REQUEST[ $key ] ) : '';
				update_post_meta( $post_id, $key, $keyval );
			}
		}

	}

	public function manage_sp4cf7_posts_custom_column( $column, $post_id ) {

		switch ( $column ) {

			case 'transaction_id' :
				$post_meta = get_post_meta( $post_id , '_charge_id', true);
				echo ( !empty( $post_meta )
					? ucfirst( $post_meta )
					: ''
				);
				break;

			case 'form_id' :
				$post_meta = get_post_meta( $post_id , '_form_id', true );
				$contact_form_url = admin_url( 'admin.php?post=' . $post_meta ) . '&page=wpcf7&action=edit';
				$contact_form = ( !empty( $post_meta )
					? ( !empty( get_the_title( $post_meta ) )
						? get_the_title( $post_meta )
						: $post_meta
					)
					: ''
				);
				echo sprintf('<a href="%s" target="_blank">%s</a>', $contact_form_url, $contact_form);

				break;

			case 'transaction_status' :
				echo ( !empty( get_post_meta( $post_id , '_transaction_status', true ) )
					? ucfirst( get_post_meta( $post_id , '_transaction_status', true ) )
					: '-'
				);
				break;

			case 'total' :
				echo ( !empty( get_post_meta( $post_id , '_total', true ) ) ? get_post_meta( $post_id , '_total', true ) : '' ) .' ' .
					( !empty( get_post_meta( $post_id , '_currency', true ) ) ? strtoupper( get_post_meta( $post_id , '_currency', true ) ) : '' );
				break;

		}
	}

	public function show_transactions_datatable( $query ) {

		if (! is_admin() || !in_array ( $query->get( 'post_type' ), array( SP4CF7_POST_TYPE ) ) )
			return;

		$orderby = $query->get( 'orderby' );

		switch ($orderby) {
			case '_transaction_id':
				$query->set( 'meta_key', '_transaction_id' );
				$query->set( 'orderby', 'meta_value' );
				break;
			case '_transaction_status':
				$query->set( 'meta_key', '_transaction_status' );
				$query->set( 'orderby', 'meta_value_num' );
				break;
			case '_form_id':
				$query->set( 'meta_key', '_form_id' );
				$query->set( 'orderby', 'meta_value_num' );
				break;
			case '_total':
				$query->set( 'meta_key', '_total' );
				$query->set( 'orderby', 'meta_value_num' );
				break;
		}

	}

	public function manage_posts_filters( $post_type ) {

		if ( SP4CF7_POST_TYPE != $post_type ) {
			return;
		}

		$args = array(
			'post_type'        => 'wpcf7_contact_form',
			'post_status'      => 'publish',
			'posts_per_page'   => -1
		);
		$posts = new \WP_Query($args);

		if ( empty( $posts ) ) {
			return;
		}

		$html = '';
		$selected = ( isset( $_GET['form-id'] ) ? (int)sanitize_text_field($_GET['form-id']) : '' );
		// The Loop
		if ( $posts->have_posts() ) {
			$html = '<select name="form-id" id="form-id">';
			$html .= '<option value="all">' . __( 'All Forms', SP4CF7_DOMAIN ) . '</option>';
		    while ( $posts->have_posts() ) {
		        $posts->the_post();
				$html .= '<option value="' . get_the_ID() . '" ' . selected( $selected, get_the_ID(), false ) . '>' . get_the_title()  . '</option>';
		    }
			$html .= '</select>';
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		echo $html;

	}

	public function parse_query( $query ) {
		
		if (! is_admin() || !in_array ( $query->get( 'post_type' ), array( SP4CF7_POST_TYPE ) ) )
			return;


		if (is_admin() && isset( $_GET['form-id'] ) && 'all' != sanitize_text_field( $_GET['form-id'])) {
			$query->query_vars['meta_key']     = '_form_id';
			$query->query_vars['meta_value']   = sanitize_text_field($_GET['form-id']);
			$query->query_vars['meta_compare'] = '=';
		}
	}

	public function show_metabox_help() {

		$html = '<div id="sp4cf7-metabox-help" class="postbox">
			<h3>'.__( 'Do you need help for Stripe configuration?', SP4CF7_DOMAIN ).'</h3>
			<div class="inside">
				<p>Here are some available options to help solve your problems.</p>'
				. $this->options_metaboxes() .
			'</div>
		</div>';

		echo $html;

	}

	public function metabox_help($show = true) {

		echo sprintf('<div id="sp4cf7-metabox-help-configuration">%s</div>', $this->options_metaboxes());
	}

	private function options_metaboxes() {
		return '<ol>
				<li><a href="https://www.pluginspro.io/documentation/" target="_blank">Refer the documentation.</a></li>
				<li><a href="https://www.pluginspro.io/support/" target="_blank">Contact Us</a></li>
				<li><a href="mailto:support@pluginspro.io">Email us</a></li>
		</ol>';
	}

	public function admin_notices_export() {
		echo '<div class="error">' .
			'<p>' .
				__( 'Please select Form to export.', SP4CF7_DOMAIN ) .
			'</p>' .
		'</div>';
	}

	public function manage_sp4cf7_sortable_columns( $columns ) {
		$columns['transaction_id'] = '_transaction_id';
		$columns['form_id'] = '_form_id';
		$columns['transaction_status'] = '_transaction_status';
		$columns['total'] = '_total';
		return $columns;
	}

	public function manage_sp4cf7_posts_columns( $columns ) {
		unset( $columns['title'] );
		unset( $columns['date'] );
		$columns['transaction_id'] = __( 'Transaction ID', SP4CF7_DOMAIN );
		$columns['form_id'] = __( 'Form ID', SP4CF7_DOMAIN );
		$columns['transaction_status'] = __( 'Transaction Status', SP4CF7_DOMAIN );
		$columns['total'] = __( 'Total Amount', SP4CF7_DOMAIN );
		$columns['date'] = __( 'Submitted Date', SP4CF7_DOMAIN );
		return $columns;
	}

	public function bulk_actions_edit_sp4cf7( $actions ) {
		unset( $actions['edit'] );
		return $actions;
	}

	public function post_row_actions( $actions, $post ) {

		if ( get_post_type() === SP4CF7_POST_TYPE ) {
			unset( $actions['inline hide-if-no-js'] );
			$url = admin_url( 'post.php?post=' . $post->ID ) . '&action=edit';
	    	$actions['edit'] = '<a href="' . esc_url( $url ) . '">View</a>';
		}

		return $actions;
	}

	public function sp4cf7_show_transactions( $post ) {

		$fields = $this->data_fields;
		$form_id = get_post_meta( $post->ID, '_form_id', true );
		include_once( SP4CF7_PATH . 'admin/partials/'.SP4CF7_DOMAIN.'-admin-transaction-details.php' );
		
	}

	public function sp4cf7_admin_style() {
	    
	    if( get_post_type() == SP4CF7_POST_TYPE )
	    	wp_enqueue_style( $this->sp4cf7 . '_admin_css' );
	}

	public function show_notices() {

		$wpcf7 = \WPCF7_ContactForm::get_current();

		if ( empty( $wpcf7 ) ) {
			return;
		}
		
		$post_id = $wpcf7->id();

		$notices = '';
		if ( !empty( $post_id ) && !empty( get_post_meta( $post_id, SP4CF7PMP . 'use_stripe', true ) ) ) {
			
			if (!empty( get_post_meta( $post_id, SP4CF7PMP . 'enable_test_mode', true ) ) ) {
				$form_fields[SP4CF7PMP . 'test_publishable_key'] = 'Please enter Stripe Test Publishable Key.';
				$form_fields[SP4CF7PMP . 'test_secret_key'] = 'Please enter Stripe Test Secret Key.';
			} else {
				$form_fields[SP4CF7PMP . 'live_publishable_key'] = 'Please enter Stripe Live Publishable Key.';
				$form_fields[SP4CF7PMP . 'live_secret_key'] = 'Please enter Stripe Live Secret Key.';
			}

			$form_fields[SP4CF7PMP . 'email'] = 'Please enter the Email field.';
			$form_fields[SP4CF7PMP . 'customer_name'] = 'Please enter the Cusomer Name field.';
			$form_fields[SP4CF7PMP . 'item_name'] = 'Please enter the Product Name.';
			// $form_fields[SP4CF7PMP . 'item_sku'] = 'Please enter the Product SKU.';
			$form_fields[SP4CF7PMP . 'item_price'] = 'Please enter the Product Price.';
			$form_fields[SP4CF7PMP . 'item_desc'] = 'Please enter the Product Description.';

			$i = 0;
			foreach ( $form_fields as $key => $val ) {
				$value = get_post_meta( $post_id, $key, true );
				
				if (empty($value)) {
					if ( $i == 0 ) {
						$notices .= sprintf( '<div class="error notice"><p><strong>%s</strong></p>', __( 'There has been an error. You have activated the stripe payment option. Please check the following errors in order to get your payments executed correctly:', SP4CF7_DOMAIN ) );
					}

					$notices .= sprintf('<p>%s</p>', $val);
					$i++;
				}
			}

			if (!empty($notices)) {
				$notices .= '</div>';
			}
		}

		echo $notices;
	}

	public function plugin_settings_link($links,$file) {
		
		if ($file == 'add-stripe-payments-for-contact-form-7/add-stripe-payments-for-contact-form-7.php') {
			
			$premium_link = '<a target="_blank" href="https://www.pluginspro.io/">' . __('Pro Version', SP4CF7_DOMAIN) . '</a>';
			
			array_push($links, $premium_link);
		}
		
		return $links; 
	}

}

<?php
/**
 * Functions for the Uncode panel menu.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sp4cf7_get_all_pages' ) ) :
	// get all pages to redirect stripe response
	function sp4cf7_get_all_pages() {
		$args = array(
			'post_type'      => array( 'page' ),
			'orderby'        => 'title',
			'posts_per_page' => -1
		);

		$pages = get_posts( $args );
		$all_pages = array();
		if ( !empty( $pages ) ) {
			foreach ( $pages as $page ) {
				$all_pages[$page->ID] = $page->post_title;
			}
		}

		return $all_pages;
	}
endif;


if ( ! function_exists( 'sp4cf7_get_all_currencies' ) ) :

	function sp4cf7_get_all_currencies() {

		$currency_code = array(
			'AUD' => 'Australian Dollar, AUD ',
			'BRL' => 'Brazilian Real, BRL',
			'GBP' => 'British Pound, GBP ',
			'CAD' => 'Canadian Dollar, CAD ',
			'CZK' => 'Czech Koruna, CZK',
			'DKK' => 'Danish Krone, DKK ',
			'EUR' => 'Euro, EUR ',
			'HKD' => 'Hong Kong Dollar, HKD ',
			'HUF' => 'Hungarian Forint, HUF',
			'ILS' => 'Israeli New Sheqel, ILS ',
			'JPY' => 'Japanese Yen, JPY ',
			'MYR' => 'Malaysian Ringgit, MYR ',
			'MXN' => 'Mexican Peso, MXN',
			'TWD' => 'New Taiwan Dollar, TWD ',
			'NZD' => 'New Zealand Dollar, NZD ',
			'NOK' => 'Norwegian Krone, NOK ',
			'PHP' => 'Philippine Peso, PHP ',
			'PLN' => 'Polish Złoty, PLN ',
			'RON' => 'Romania Leu, RON',
			'RUB' => 'Russian Ruble, RUB ',
			'SGD' => 'Singapore Dollar, SGD ',
			'SEK' => 'Swedish Krona, SEK ',
			'CHF' => 'Swiss Franc, CHF ',
			'THB' => 'Thai Baht, THB ',
			'USD' => 'United States Dollar, USD'
		);


		return $currency_code;
	}

endif;

if ( ! function_exists( 'sp4cf7_unmasked' ) ) :
	// get all pages to redirect stripe response
	function sp4cf7_unmasked($money_value) {

		return (!empty($money_value)) ? preg_replace("/([^0-9\\.])/i", "", $money_value) : 0;
		
	}
endif;

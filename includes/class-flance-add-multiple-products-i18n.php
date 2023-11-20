<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.flance.info
 * @since     1.1.3
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.3
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/includes
 * @author     Rusty <tutyou1972@gmail.com>
 */
class Flance_Add_Multiple_Products_order_form_Woocommerce_i18n_Pro {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.1.3
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woomultiorderpro',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

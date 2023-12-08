<?php
/**
 * Fired during plugin activation
 *
 * @link       http://www.flance.info
 * @since      1.1.3
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.1.3
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/includes
 * @author     Rusty <tutyou1972@gmail.com>
 */
class Flance_Add_Multiple_Products_order_form_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.1.3
	 */
	public static function activate() {
		$product_cat_option = get_option( 'flance_amp_product_cat' );
		if ( empty( $product_cat_option ) ) {
			add_option( 'flance_amp_product_cat', '-1' );
		}
		add_option( 'showname', 'y' );
		add_option( 'showimage', 'y' );
		add_option( 'attribute', 'y' );
		add_option( 'showdesc', 'y' );
		add_option( 'showsku', 'y' );
		add_option( 'showmfk', 'n' );
		add_option( 'category', 'n' );
		add_option( 'showpkg', 'y' );
		add_option( ' splitchild', 'y' );
		add_option( 'showprice', 'y' );
		add_option( 'showquantity', 'y' );
		add_option( 'showaddtocart', 'y' );
		add_option( 'redirect', 'n' );
		add_option( 'reload', 'n' );
		add_option( 'redirectlink', 'cart' );
		add_option( 'showlink', 'y' );
		add_option( 'instock', 'y' );
		add_option( 'flance_amp_do_activation_redirect', true );

	}



}

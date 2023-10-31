<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.flance.info
 * @since             1.1.6
 * @package           Flance_Add_Multiple_Products_order_form_Woocommerce_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       Flance Add Multiple Products order form for Woocommerce Pro
 * Description:       The plugin gives functionality to have the form to add multiple products to the cart and calculate in same page the total price of the order. And you also can use shortcode to use the plugin other places. Just place the shortcode where you wanna put the input form and it's done !!! Pro vesrion has the functionality to show the product attributes on the page non commercial version does not have attribute show functionality.
 * Version:           2.0.0
 * Author:            Rusty
 * Author URI:        http://www.flance.info
 * Text Domain:       flance-add-multiple-products-order-form-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! function_exists( 'wptlampaof_fs' ) ) {
	// Create a helper function for easy SDK access.
	function wptlampaof_fs() {
		global $wptlampaof_fs;
		if ( ! isset( $wptlampaof_fs ) ) {
			// Activate multisite network integration.
			if ( ! defined( 'WP_FS__PRODUCT_14054_MULTISITE' ) ) {
				define( 'WP_FS__PRODUCT_14054_MULTISITE', true );
			}
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';
			$wptlampaof_fs = fs_dynamic_init( array(
				'id'                  => '14054',
				'slug'                => 'woocommerce-product-table-list-and-multiple-products-add-order',
				'premium_slug'        => 'woocommerce-product-table-list-and-multiple-products-add-order-f-premium',
				'type'                => 'plugin',
				'public_key'          => 'pk_b7901fa8b045662400ff3918629c1',
				'is_premium'          => true,
				'premium_suffix'      => '',
				// If your plugin is a serviceware, set this option to false.
				'has_premium_version' => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				'is_org_compliant'    => false,
				'menu'                => array(
					'slug'    => 'flance-add-multiple-products',
					'support' => false,
					'network' => true,
				),
			) );
		}

		return $wptlampaof_fs;
	}

	// Init Freemius.
	wptlampaof_fs();
	// Signal that SDK was initiated.
	do_action( 'wptlampaof_fs_loaded' );
}
/*
 * Activation the freemius
 */
function wptlampaof_verify() {
	if ( function_exists( 'wptlampaof_fs' ) ) {

		return wptlampaof_fs()->is__premium_only() && wptlampaof_fs()->can_use_premium_code();
	}

	return true;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flance-add-multiple-products-activator.php
 */
function activate_flance_add_multiple_products_pro() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products-activator.php';
	Flance_Add_Multiple_Products_order_form_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flance-add-multiple-products-deactivator.php
 */
function deactivate_flance_add_multiple_products_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products-deactivator.php';
	Flance_Add_Multiple_Products_order_form_Woocommerce_Deactivator::deactivate();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products.php';
function find_valid_variations( $item_id ) {


	$product      = new WC_Product_Variable( $item_id );
	$variations   = $product->get_available_variations();
	$attributes   = $product->get_attributes();
	$new_variants = array();
	// Loop through all variations
	foreach ( $variations as $variation ) {

		// Peruse the attributes.
		// 1. If both are explicitly set, this is a valid variation
		// 2. If one is not set, that means any, and we must 'create' the rest.
		$valid = true; // so far
		foreach ( $attributes as $slug => $args ) {
			if ( array_key_exists( "attribute_$slug", $variation['attributes'] ) && ! empty( $variation['attributes']["attribute_$slug"] ) ) {
				// Exists
			} else {
				// Not exists, create
				$valid = false; // it contains 'anys'
				// loop through all options for the 'ANY' attribute, and add each
				foreach ( explode( '|', $attributes[ $slug ]['value'] ) as $attribute ) {
					$attribute                                    = trim( $attribute );
					$new_variant                                  = $variation;
					$new_variant['attributes']["attribute_$slug"] = $attribute;
					$new_variants[]                               = $new_variant;
				}

			}
		}
		// This contains ALL set attributes, and is itself a 'valid' variation.
		if ( $valid ) {
			$new_variants[] = $variation;
		}

	}

	return $new_variants;
}

function get_variation_data_from_variation_id( $item_id ) {

	$handle      = new WC_Product_Variable( $item_id );
	$variations1 = $handle->get_available_variations();
	echo "<pre>";
	print_r( $variations1 );
	echo "</pre>";
	echo '<select>';
	foreach ( $variations1 as $key => $value ) {
		echo '<option  value="' . $value['variation_id'] . '">' . implode( '/', $value['attributes'] ) . '-' . $value['price_html'] . '</option>';

	}
	echo '</select>';

	return; // $variation_detail will return string containing variation detail which can be used to print on website
}

/**
 * Check if WooCommerce is active
 **/
add_action('plugins_loaded', 'check_woocommerce_activation_pro');
function check_woocommerce_activation_pro() {
	if ( wptlampaof_verify() ) {
		// Check if WooCommerce is active
		if ( class_exists( 'WooCommerce' ) ) {

			register_activation_hook( __FILE__, 'activate_flance_add_multiple_products_pro' );
			register_deactivation_hook( __FILE__, 'deactivate_flance_add_multiple_products_pro' );
			$plugin = new Flance_Add_Multiple_Products_order_form_Woocommerce_pro();
			$plugin->run();
		} else {
			// WooCommerce is not active, handle it accordingly
			add_action( 'admin_notices', 'flance_wamp_admin_notice_error_pro' );
		}
	}
}

function Flance_wamp_admin_notice__error_pro() {
	$class   = 'notice notice-error';
	$message = __( 'You don\'t have WooCommerce activated. Please Activate <b>WooCommerce</b> and then try to activate again <b>Flance Add Multiple Products order form for Woocommerce</b>.', 'flance-add-multiple-products-order-form-woocommerce' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
}

function Flance_free_plugin_wamp_admin_notice__error_pro() {
	$class   = 'notice notice-error';
	$message = __( 'You don\'t have WooCommerce activated. Please Activate <b>WooCommerce</b> and then try to activate again <b>Flance Add Multiple Products order form for Woocommerce</b>.', 'flance-add-multiple-products-order-form-woocommerce' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
}
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
 * @since             1.1.5
 * @package           Flance_Add_Multiple_Products_order_form_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Flance Add Multiple Products order form for Woocommerce
 * Description:       The plugin gives functionality to have the form to add multiple products to the cart and calculate in same page the total price of the order. And you also can use shortcode to use the plugin other places. Just place the shortcode where you wanna put the input form and it's done !!! Pro vesrion has the functionality to show the product attributes on the page non commercial version does not have attribute show functionality. 
 * Version:           1.1.5
 * Author:            Rusty 
 * Author URI:        http://www.flance.info
 * Text Domain:       flance-add-multiple-products-order-form-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flance-add-multiple-products-activator.php
 */
function activate_flance_add_multiple_products() {
	

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products-activator.php';
	Flance_Add_Multiple_Products_order_form_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flance-add-multiple-products-deactivator.php
 */
function deactivate_flance_add_multiple_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products-deactivator.php';
	Flance_Add_Multiple_Products_order_form_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flance_add_multiple_products' );
register_deactivation_hook( __FILE__, 'deactivate_flance_add_multiple_products' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flance-add-multiple-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.4
 */
function run_flance_add_multiple_products() {

	$plugin = new Flance_Add_Multiple_Products_order_form_Woocommerce();
	$plugin->run();

}

function find_valid_variations($item_id) {


    $product =new WC_Product_Variable($item_id);

    $variations = $product->get_available_variations();
    $attributes = $product->get_attributes();
    $new_variants = array();

    // Loop through all variations
    foreach( $variations as $variation ) {

        // Peruse the attributes.

        // 1. If both are explicitly set, this is a valid variation
        // 2. If one is not set, that means any, and we must 'create' the rest.

        $valid = true; // so far
        foreach( $attributes as $slug => $args ) {
            if( array_key_exists("attribute_$slug", $variation['attributes']) && !empty($variation['attributes']["attribute_$slug"]) ) {
                // Exists

            } else {
                // Not exists, create
                $valid = false; // it contains 'anys'
                // loop through all options for the 'ANY' attribute, and add each
                foreach( explode( '|', $attributes[$slug]['value']) as $attribute ) {
                    $attribute = trim( $attribute );
                    $new_variant = $variation;
                    $new_variant['attributes']["attribute_$slug"] = $attribute;
                    $new_variants[] = $new_variant;
                }

            }
        }

        // This contains ALL set attributes, and is itself a 'valid' variation.
        if( $valid )
            $new_variants[] = $variation;

    }

    return $new_variants;
}


function get_variation_data_from_variation_id($item_id) {

    $handle=new WC_Product_Variable($item_id);
    $variations1=$handle->get_available_variations();


    echo "<pre>";
    print_r ($variations1);
    echo "</pre>";
    echo '<select>';
    foreach ($variations1 as $key => $value) {
        echo '<option  value="'.$value['variation_id'].'">'.implode('/',$value['attributes']).'-'.$value['price_html'].'</option>';

    }
    echo '</select>';

    return ; // $variation_detail will return string containing variation detail which can be used to print on website

}
/**
 * Check if WooCommerce is active
 **/

 run_flance_add_multiple_products();
 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	run_flance_add_multiple_products();
} else {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//	deactivate_plugins( plugin_basename( __FILE__ ) );
//	add_action( 'admin_notices', 'Flance_wamp_admin_notice__error' );
}


function Flance_wamp_admin_notice__error() {
	$class = 'notice notice-error';
	$message = __( 'You don\'t have WooCommerce activated. Please Activate <b>WooCommerce</b> and then try to activate again <b>Flance Add Multiple Products order form for Woocommerce</b>.', 'Flance' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}
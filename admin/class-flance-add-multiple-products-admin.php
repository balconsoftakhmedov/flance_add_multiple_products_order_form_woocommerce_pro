<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.flance.info
 * @since      1.1.3
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce Pro
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/admin
 * @author     Rusty <tutyou1972@gmail.com>
 */
class Flance_Add_Multiple_Products_order_form_Woocommerce_Admin_Pro {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.5
	 * @access   private
	 * @var      string    $Flance_wamp    The ID of this plugin.
	 */
	private $Flance_wamp;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.5
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.3
	 * @param      string    $Flance_wamp       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Flance_wamp, $version ) {

		$this->Flance_wamp = $Flance_wamp;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.1.3
	 */
	public function enqueue_styles() {
		// WooCommerce credentials.
        global $woocommerce;
        wp_enqueue_style( 'woocommerce-chosen',  $woocommerce->plugin_url() . '/assets/css/select2.css', array(), $this->version, 'all', true );

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flance_Add_Multiple_Products_order_form_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flance_Add_Multiple_Products_order_form_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Flance_wamp, plugin_dir_url( __FILE__ ) . 'css/flance-add-multiple-products-admin.css', array( 'woocommerce-chosen' ), $this->version, 'all', true );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.1.3
	 */
	public function enqueue_scripts() {
		
		// WooCommerce credentials.
        global $woocommerce;
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        
        // Loading Chosen Chosen jQuery from WooCommerce.
        wp_enqueue_script( 'woocommerce-chosen-js', $woocommerce->plugin_url() . '/assets/js/select2/select2'.$suffix.'.js', array('jquery'), null, true );

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flance_Add_Multiple_Products_order_form_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flance_Add_Multiple_Products_order_form_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Flance_wamp, plugin_dir_url( __FILE__ ) . 'js/flance-add-multiple-products-admin.js', array( 'jquery', 'woocommerce-chosen-js' ), $this->version, true );

	}

	// Admin Menu Page Calling function.
	public function flance_amp_admin_menu_page() {

		//create new top-level menu
		add_menu_page(
			'Flance Add Multiple Products order form for Woocommerce Pro Settings', 
			'Flance Multiple Pro', 
			'administrator', 
			'flance-add-multiple-products', 
			array( $this, 'flance_amp_admin_settings_page' ) , 
			'dashicons-layout',
			30
		);
		//call register settings public function
		add_action( 'admin_init', array( $this, 'register_flance_amp_settings' ) );
	}
	
	// Admin Setting Registration
	public function register_flance_amp_settings() {
		//register our settings
		register_setting( 'flance-amp-settings-group', 'flance_amp_product_cat' );
		register_setting( 'flance-amp-settings-group', 'showname' );
		register_setting( 'flance-amp-settings-group', 'showimage' );
		register_setting( 'flance-amp-settings-group', 'attribute' );
		register_setting( 'flance-amp-settings-group', 'showdesc' );
		register_setting( 'flance-amp-settings-group', 'showsku' );
        register_setting( 'flance-amp-settings-group', 'splitchild' );

        register_setting( 'flance-amp-settings-group', 'showmfk' );
		register_setting( 'flance-amp-settings-group', 'showpkg' );
		register_setting( 'flance-amp-settings-group', 'showprice' );
		register_setting( 'flance-amp-settings-group', 'showquantity' );
		register_setting( 'flance-amp-settings-group', 'showaddtocart' );
		register_setting( 'flance-amp-settings-group', 'redirect' );
		register_setting( 'flance-amp-settings-group', 'reload' );
		register_setting( 'flance-amp-settings-group', 'redirectlink' );
		register_setting( 'flance-amp-settings-group', 'showlink' );
		register_setting( 'flance-amp-settings-group', 'instock' );
		register_setting( 'flance-amp-settings-group', 'flance_amp_user_check' );
		register_setting( 'flance-amp-settings-group', 'flance_amp_user_role' );
	}

	// Admin Settings Page Function
	public function flance_amp_admin_settings_page() {
		include 'partials/html-admin-form.php';
	}

	public static function flance_amp_admin_settings_get_product_cats(){
		$product_cat = get_terms('product_cat', 'hide_empty=0');
		$product_cat_option = (array)get_option('flance_amp_product_cat');
		if( in_array( -1, $product_cat_option ) || empty( $product_cat_option ) ):
	    	echo '<option value="-1" selected>All Products</option>';
	    	foreach ($product_cat as $product_cat_key => $product_cat_value) {
                echo '<option value=' . $product_cat_value->term_id . '>' . $product_cat_value->name . '</option>';
	        }
	    else:
			echo '<option value="-1">All Products</option>';
	        foreach ($product_cat as $product_cat_key => $product_cat_value) {
	            if ( in_array( $product_cat_value->term_id, $product_cat_option ) ) {
	                echo '<option value=' . $product_cat_value->term_id . ' selected>' . $product_cat_value->name . '</option>';
	            } else {
	                echo '<option value=' . $product_cat_value->term_id . '>' . $product_cat_value->name . '</option>';
	            }
	        }
	    endif;
	}

	public function wamp_dropdown_roles( $selected ) {
		
		$selected = (array) $selected;

		$editable_roles = array_reverse( get_editable_roles() );
	
		foreach ( $editable_roles as $role => $details ) {
			$name = translate_user_role($details['name'] );
			if ( in_array( $role, $selected ) ) // preselect specified role
				echo "<option selected='selected' value='" . esc_attr($role) . "'>" . $name . "</option>";
			else
				echo "<option value='" . esc_attr($role) . "'>" . $name . "</option>";
		}
	}

	
	public function flance_widget() {
		register_widget( 'Flance_Add_Multiple_Products_order_form_Woocommerce_Widget_Pro' );
	}

	public function flance_amp_plugin_redirect() {
		if (get_option('flance_amp_do_activation_redirect', false)) {
			delete_option('flance_amp_do_activation_redirect');
			wp_redirect( admin_url( 'admin.php?page=flance-add-multiple-products' ) );
		}
	}
}

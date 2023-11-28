<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.flance.info
 * @since      1.1.4
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce Pro
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce Pro
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public
 * @author     Rusty <tutyou1972@gmail.com>
 */
class Flance_Add_Multiple_Products_order_form_Woocommerce_Public_Pro {

	/**
	 * The ID of this plugin.
	 *
	 * @since      1.1.3
	 * @access     private
	 * @var      string $Flance_wamp The ID of this plugin.
	 */
	private $Flance_wamp;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.3
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $Flance_wamp The name of the plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.1.3
	 */
	public function __construct( $Flance_wamp, $version ) {

		$this->Flance_wamp = $Flance_wamp;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.3
	 */
	public function enqueue_styles() {

		// WooCommerce credentials.
		global $woocommerce;
		wp_enqueue_style( 'woocommerce-chosen', $woocommerce->plugin_url() . '/assets/css/select2.css', array(), $this->version, 'all', true );
		wp_enqueue_style( $this->Flance_wamp, plugin_dir_url( __FILE__ ) . 'css/flance-add-multiple-products-public.css', array( 'woocommerce-chosen' ) );
		wp_enqueue_style( 'datatables', plugin_dir_url( __FILE__ ) . 'datatables/datatables.css', array( 'woocommerce-chosen' ) );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.3
	 */
	public function enqueue_scripts() {
		// WooCommerce credentials.
		global $woocommerce;
		$params =[];
		$params['showname']      = get_option( 'showname' );
		$params['showimage']     = get_option( 'showimage' );
		$params['attribute']     = get_option( 'attribute' );
		$params['showdesc']      = get_option( 'showdesc' );
		$params['showmfk']       = get_option( 'showmfk' );
		$params['splitchild']    = get_option( 'splitchild' );
		$params['showsku']       = get_option( 'showsku' );
		$params['showpkg']       = get_option( 'showpkg' );
		$params['showprice']     = get_option( 'showprice' );
		$params['showlink']      = get_option( 'showlink' );
		$params['instock']       = get_option( 'instock' );
		$params['showaddtocart'] = get_option( 'showaddtocart' );
		$params['redirect']      = get_option( 'redirect' );
		$params['reload']        = get_option( 'reload' );
		$params['redirectlink']  = get_option( 'redirectlink' );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		// Loading Chosen Chosen jQuery from WooCommerce.
		//wp_enqueue_script( 'woocommerce-chosen-js', $woocommerce->plugin_url() . '/assets/js/select2/select2' . $suffix . '.js', array( 'jquery' ), null, true );
		//wp_enqueue_script( $this->Flance_wamp, plugin_dir_url( __FILE__ ) . 'js/flance-add-multiple-products-public.js', array( 'woocommerce-chosen-js' ), time(), true );
		//wp_enqueue_script( 'flance-variations', plugin_dir_url( __FILE__ ) . 'js/flance-add-multiple-variations.js', array( 'woocommerce-chosen-js', 'jquery', 'wp-util', 'jquery-blockui', $this->Flance_wamp ), time(), true );
		//wp_enqueue_script( 'datatables', plugin_dir_url( __FILE__ ) . 'datatables/datatables.js', array( 'woocommerce-chosen-js' ), $this->version, true );
		// Localization for Ajax.
		wp_localize_script(
			$this->Flance_wamp,
			'WPURLS',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'siteurl' => plugin_dir_url( __FILE__ ),
				'params' => $params,
			)
		);
	}

	// Product input form
	public function flance_amp_product_input_from() {
		if ( get_option( 'flance_amp_user_check' ) == 1 && is_user_logged_in() ) {
			$flance_user_role          = get_option( 'flance_amp_user_role' );
			$flance_current_user_roles = $this->flance_amp_get_user_role( get_current_user_id() );
			$is_auth                   = array_intersect( $flance_user_role, $flance_current_user_roles ) ? 'true' : 'false';
			if ( ! empty( $flance_user_role ) ) {
				if ( $is_auth ) {
					include 'partials/html-public-input-field.php';
				}
			} else {
				include 'partials/html-public-input-field.php';
			}
		}
	}

	// Product input form
	public function flance_amp_product_shortcode_input_from( $atts ) {


		if ( get_option( 'flance_amp_user_check' ) == 1 && is_user_logged_in() ) {
			$flance_user_role          = (array) get_option( 'flance_amp_user_role' );
			$flance_current_user_roles = $this->flance_amp_get_user_role( get_current_user_id() );
			$is_auth                   = array_intersect( $flance_user_role, $flance_current_user_roles ) ? 'true' : 'false';
			if ( ! empty( $flance_user_role ) ) {
				if ( $is_auth ) {
					include 'partials/html-public-shortcode-input-field.php';
				}
			} else {
				include 'partials/html-public-shortcode-input-field.php';
			}
		} else {
			include 'partials/html-public-shortcode-input-field.php';
		}

		return $html;

	}

	// Ajax function
	public function flance_amp_add_to_cart() {
		global $woocommerce;
		$result = null;
		// Getting and sanitizing $_POST data.
		$product_ids = filter_var_array( $_POST['ids'], FILTER_SANITIZE_SPECIAL_CHARS );
		$post        = filter_var_array( $_POST['paramObj'], FILTER_SANITIZE_SPECIAL_CHARS );

		foreach ( $product_ids as $id  ) {

			$product_data = [];
			foreach ( $post[$id] as $key => $value ) {

				$product_data[$key] = $value;
			}

			$quantity = (!empty($product_data['quantity']))? $product_data['quantity']: 0;
			$variation_id =(!empty($product_data['variation_id']))?$product_data['variation_id']: null;
			$variations = $product_data;
			if ($quantity > 0)
			$result = Flance_Add_Multiple_Products_order_form_Woocommerce_Public_Pro::add_to_cart_action( $id, $quantity, $variation_id, $variations );
		}
		$response = array();
		if ( $result === false ) {
			$response['status']  = 'error';
			$response['message'] = 'Items were not added successfully.';
		} else {
			$response['status']  = 'success';
			$response['message'] = 'Items were successfully added.';
			$response['item_id'] = $product_ids;
		}
		wp_send_json( $response );
		wp_die();
	}


	public function add_to_cart_action( $product_id, $quantity, $variation_id = null,$variations =[], $url = null ) {

		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			return;
		}

		$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );

		if ( 'variable' === $add_to_cart_handler || 'variation' === $add_to_cart_handler ) {
			$was_added_to_cart = self::add_to_cart_handler_variable( $product_id, $variation_id, $quantity, $variations );
		}  elseif ( has_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler ) ) {
			do_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler, $url ); // Custom handler.
		} else {
			$was_added_to_cart = self::add_to_cart_handler_simple( $product_id, $quantity );
		}
		return $was_added_to_cart;
	}

	private static function add_to_cart_handler_simple( $product_id, $quantity ) {
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
			return true;
		}
		return false;
	}

	private static function add_to_cart_handler_variable( $product_id, $variation_id, $quantity, $variations ) {
		$variation_id = absint( $variation_id);
		$quantity     = empty( $quantity ) ? 1 : wc_stock_amount( $quantity );

		$product = wc_get_product( $product_id );
		foreach ( $variations as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 'attribute_' !== substr( $key, 0, 10 ) ) {
				continue;
			}
			$variations[ sanitize_title( wp_unslash( $key ) ) ] = wp_unslash( $value );
		}
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );
		if ( ! $passed_validation ) {
			return false;
		}
		// Prevent parent variable product from being added to cart.
		if ( empty( $variation_id ) && $product && $product->is_type( 'variable' ) ) {
			/* translators: 1: product link, 2: product name */
			wc_add_notice( sprintf( __( 'Please choose product options by visiting <a href="%1$s" title="%2$s">%2$s</a>.', 'woocommerce' ), esc_url( get_permalink( $product_id ) ), esc_html( $product->get_name() ) ), 'error' );

			return false;
		}
		if ( false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );

			return true;
		}

		return false;
	}

	// Get products on list.
	public static function flance_amp_get_products( $product_ids, $prod_cat_atts, $form_id, $params ) {



		if (empty($product_ids['product_ids'])){
			$product_ids =$params['product_ids'];
		}else{
			$product_ids = explode( ",", $product_ids['product_ids'] );
		}
		$product_id_exist = null;
		// Get category settings
		$product_cat_setting = (array) get_option( 'flance_amp_product_cat' );
		// check product ids for shortcode
		if (!empty($product_ids)) {
			foreach ( $product_ids as $prod_id ) {

				if ( $prod_id > 0 ) {
					$product_id_exist = 1;
				}


			}
		}
		$check_cat =null;
		// product ids is given in short code
		if ( $product_id_exist != 1 ) {
			foreach ( $prod_cat_atts as $pr ): if ( ! empty( $pr ) ): $check_cat = 1; endif; endforeach;
			if ( $check_cat == 1 ) {
				foreach ( $prod_cat_atts as $prod_cat_att ) {
					$product_cats[] = $prod_cat_att;


				}
			} else {

			//	$product_cats = $product_cat_setting;


			}
			$product_cats = (!empty( $product_cats))? $product_cats: array();
			if ( in_array( '-1', $product_cats ) ) {
				// WP_Query arg for "Product" post type.
				$args = array(
					'post_type'      => 'product',
					'fields'         => 'ids',
					'posts_per_page' => '-1'
				);
			} else {
				// WP_Query arg for "Product" post type.
				$args = array(
					'post_type'      => 'product',
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'id', //can be set to ID
							'terms'    => $product_cats //if field is ID you can reference by cat/term number
						)
					),
					'fields'         => 'ids',
					'posts_per_page' => '-1'
				);
			}
			// New Query
			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
				$rds = $loop->get_posts();
				// Loop Start.
				foreach ( $rds as $rd ) {
					$product   = new WC_Product( $rd );
					$sku       = $product->get_sku();
					$stock     = $product->is_in_stock() ? __( ' -- In stock', 'woomultiorderpro') : __( ' -- Out of stock', 'woomultiorderpro');
					$disablity = $product->is_in_stock() ? '' : 'disabled';
					$products[] = $product;

				} // Loop End .
			}
		} else {
			// Loop Start.
			foreach ( $product_ids as $rd ) {
				$product   = new WC_Product( $rd );
				$sku       = $product->get_sku();
				$stock     = $product->is_in_stock() ? __( ' -- In stock', 'woomultiorderpro') : __( ' -- Out of stock', 'woomultiorderpro');
				$disablity = $product->is_in_stock() ? '' : 'disabled';
				$products[] = $product;

			} // Loop End .

		}
		include 'partials/html-public-table.php';
		return $html;
		wp_reset_postdata();
	}

	// Get products on list for dynamic shortcode.
	public function flance_amp_get_shortcode_products( $prod_cat_atts ) {
		$prod_cats = explode( ",", $prod_cat_atts['prod_cat'] );
		// WP_Query arg for "Product" post type.
		$args = array(
			'post_type'      => 'product',
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id', //can be set to ID
					'terms'    => $prod_cats //if field is ID you can reference by cat/term number
				)
			),
			'fields'         => 'ids',
			'posts_per_page' => '-1'
		);
		// New Query
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			$rds = $loop->get_posts();
			// Loop Start.
			foreach ( $rds as $rd ) {
				$product   = new WC_Products( $rd );
				$sku       = $product->get_sku();
				$stock     = $product->is_in_stock() ? __( ' -- In stock', 'woomultiorderpro') : __( ' -- Out of stock', 'woomultiorderpro');
				$disablity = $product->is_in_stock() ? '' : 'disabled';
				echo '<option datad="' . $sku . '" value="' . $rd . '"' . $disablity . '>' . $sku . " -- " . get_the_title( $rd ) . $stock . '</option>';
			} // Loop End .
		}
		wp_reset_postdata();
	}

	public static function flance_amp_get_user_role( $user_ID ) {
		if ( is_user_logged_in() ) {
			$user = new WP_User( $user_ID );
			if ( ! empty( $user->roles ) && is_array( $user->roles ) ) {
				return $user->roles;
			}
		}
	}
}

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
	 * @access   private
	 * @var      string    $Flance_wamp    The ID of this plugin.
	 */
	private $Flance_wamp;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.3
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.3
	 * @param      string    $Flance_wamp       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Flance_wamp, $version ) {

		$this->Flance_wamp = $Flance_wamp;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.3
	 */
	public function enqueue_styles() {
		
		// WooCommerce credentials.
        global $woocommerce;
        wp_enqueue_style( 'woocommerce-chosen',  $woocommerce->plugin_url() . '/assets/css/select2.css', array(), $this->version, 'all', true );

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
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        
        // Loading Chosen Chosen jQuery from WooCommerce.
        wp_enqueue_script( 'woocommerce-chosen-js', $woocommerce->plugin_url() . '/assets/js/select2/select2'.$suffix.'.js', array('jquery'), null, true );
		wp_enqueue_script( $this->Flance_wamp, plugin_dir_url( __FILE__ ) . 'js/flance-add-multiple-products-public.js', array( 'woocommerce-chosen-js' ), $this->version, true );
        wp_enqueue_script( 'datatables', plugin_dir_url( __FILE__ ) . 'datatables/datatables.js', array( 'woocommerce-chosen-js' ), $this->version, true );


        // Localization for Ajax.
        wp_localize_script( 
        	$this->Flance_wamp, 
        	'WPURLS', 
        	array( 
        		'ajaxurl' => admin_url( 'admin-ajax.php' ),
        		'siteurl' => plugin_dir_url(__FILE__) 
        	) 
        );
	}
    
    // Product input form
    public function flance_amp_product_input_from(){ 
        if ( get_option( 'flance_amp_user_check' ) == 1 && is_user_logged_in() ) {
            $flance_user_role = get_option( 'flance_amp_user_role' );
            $flance_current_user_roles = $this->flance_amp_get_user_role( get_current_user_id() );
            $is_auth = array_intersect( $flance_user_role, $flance_current_user_roles )  ? 'true' : 'false';
            if ( !empty( $flance_user_role ) ) {
                if( $is_auth ){
                    include 'partials/html-public-input-field.php';
                }
            } else {
                include 'partials/html-public-input-field.php';
            }
        } 
    }

    // Product input form
    public function flance_amp_product_shortcode_input_from( $atts ){

			
        if ( get_option('flance_amp_user_check') == 1 && is_user_logged_in() ) {
            $flance_user_role = (array)get_option( 'flance_amp_user_role' );
            $flance_current_user_roles = $this->flance_amp_get_user_role( get_current_user_id() );
            $is_auth = array_intersect( $flance_user_role, $flance_current_user_roles )  ? 'true' : 'false';
            if ( !empty( $flance_user_role ) ) {
                if( $is_auth ){
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
    public function flance_amp_add_to_cart(){
		
	
        global $woocommerce;
        // Getting and sanitizing $_POST data.
        $product_ids = filter_var_array($_POST['ids'], FILTER_SANITIZE_SPECIAL_CHARS);

		$post = filter_var_array($_POST['paramObj'], FILTER_SANITIZE_SPECIAL_CHARS);
		

		
        foreach( $product_ids as $key=>$qty ) {

            // echo $key;

            $prod = explode('___', $key);
            // print_r ($prod);
            $product_id = $prod[0];


            $product = wc_get_product($product_id);

            $attribute_post = explode('_br_', $key);

            unset($atts);
            foreach ($attribute_post as $attib) {
                $attib = explode('___', $attib);
                //  print_r ($attib);
                $atts[$attib[1]] = str_replace('__', '_', $attib[2]);


            }
            // print_r ($atts);
            $product_vars = $variation_id = null;

            $attributes = $product->get_attributes();


            // getting variatons
            $wc_product_variable = new WC_Product_Variable($product_id);

            $variations = $wc_product_variable->get_available_variations();

            // geting variation id;
            if ($variations) {
                foreach ($variations as $variation) {
                    $var_check = 1;
                    $variation_id = null;
                    $variation_id = $variation['variation_id'];
                    foreach ($variation['attributes'] as $key_1 => $variants) {


                        // echo '<pre>'; print_r ($variants); echo '</pre>';
                        if ($atts[$key_1] != $variants) {
                            $var_check = 0;
                            $variation_id = null;

                        }
                    }

                    // echo  $variation_id.'<br>' ;
                    if ($var_check == 1) {
                        if (($woocommerce->cart->add_to_cart($product_id, $qty, $variation_id, $var) == false)) $result = 1;

                    }
                }

            } else {
                if (($woocommerce->cart->add_to_cart($product_id, $qty, $variation_id, $var) == false)) $result = 1;

            }

        }


                    //if ($result ==1) {echo "Items is not added successfully ";}else{echo "Items successfully added";}

        wp_die();
    }

    // Get products on list.
    public static function flance_amp_get_products($product_ids,$prod_cat_atts,$form_id) {
		$product_ids = explode( ",", $product_ids['product_ids'] );
			 // Get category settings
        $product_cat_setting = (array)get_option('flance_amp_product_cat');
	
	
	// check product ids for shortcode
		foreach ($product_ids as $prod_id){
		
			if ($prod_id>0){ $product_id_exist =1 ; }
		
			
				}
		// product ids is given in short code
		if ($product_id_exist !=1){
       foreach ($prod_cat_atts as $pr): if(!empty($pr)):  $check_cat =1; endif; endforeach; 


	if ($check_cat==1){
		foreach ($prod_cat_atts as $prod_cat_att){
		$product_cats[] = $prod_cat_att; 

		
			
				}
		}else{
			
		$product_cats =   $product_cat_setting;	
			

		}
		
	
        if ( in_array( '-1', $product_cats ) ) {
            // WP_Query arg for "Product" post type. 
            $args = array( 
                'post_type' => 'product',
                'fields' => 'ids', 
                'posts_per_page' => '-1' 
            );
        } else {
            // WP_Query arg for "Product" post type. 
            $args = array( 
                'post_type' => 'product', 
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id', //can be set to ID
                        'terms' =>  $product_cats //if field is ID you can reference by cat/term number
                    )
                ),
                'fields' => 'ids', 
                'posts_per_page' => '-1' 
            );
        }

	
        // New Query
					$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) {
					$rds = $loop->get_posts();  
					// Loop Start.
					foreach($rds as $rd) {
						$product = new WC_Product( $rd );
						$sku = $product->get_sku();
						$stock = $product->is_in_stock()?__( ' -- In stock', 'flance-add-multiple-products-order-form-woocommerce' ):__( ' -- Out of stock', 'flance-add-multiple-products-order-form-woocommerce' );
						$disablity = $product->is_in_stock()?'':'disabled';
					   // echo '<option datad="' . $sku .'" value="' . $rd .'"'. $disablity . '>' . $sku . " -- " . get_the_title( $rd ) . $stock . '</option>';
					$products[]=$product;
					
					} // Loop End .
					
					include 'partials/html-public-table.php';
				}
		}else{
			// Loop Start.
            foreach($product_ids as $rd) {
                $product = new WC_Product( $rd );
                $sku = $product->get_sku();
                $stock = $product->is_in_stock()?__( ' -- In stock', 'flance-add-multiple-products-order-form-woocommerce' ):__( ' -- Out of stock', 'flance-add-multiple-products-order-form-woocommerce' );
                $disablity = $product->is_in_stock()?'':'disabled';
               // echo '<option datad="' . $sku .'" value="' . $rd .'"'. $disablity . '>' . $sku . " -- " . get_the_title( $rd ) . $stock . '</option>';
            $products[]=$product;
			
			} // Loop End .
			
		include 'partials/html-public-table.php';	
		}
		
		
return $html;
        wp_reset_postdata();
    }

    // Get products on list for dynamic shortcode.
    public function flance_amp_get_shortcode_products( $prod_cat_atts ){
        $prod_cats = explode( ",", $prod_cat_atts['prod_cat'] );
        // WP_Query arg for "Product" post type. 
		

        $args = array( 
            'post_type' => 'product', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id', //can be set to ID
                    'terms' =>  $prod_cats //if field is ID you can reference by cat/term number
                )
            ),
            'fields' => 'ids', 
            'posts_per_page' => '-1' 
        );
        // New Query
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            $rds = $loop->get_posts();  
            // Loop Start.
            foreach($rds as $rd) {
                $product = new WC_Products( $rd );
                $sku = $product->get_sku();
                $stock = $product->is_in_stock()?__( ' -- In stock', 'flance-add-multiple-products-order-form-woocommerce' ):__( ' -- Out of stock', 'flance-add-multiple-products-order-form-woocommerce' );
                $disablity = $product->is_in_stock()?'':'disabled';
                echo '<option datad="' . $sku .'" value="' . $rd .'"'. $disablity . '>' . $sku . " -- " . get_the_title( $rd ) . $stock . '</option>';
            } // Loop End .
			
			 
        }
        wp_reset_postdata();
    }

    public static function flance_amp_get_user_role( $user_ID ) {
        if ( is_user_logged_in() ) {
            $user = new WP_User( $user_ID );
            if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
                return $user->roles;
            }
        }
    }
}

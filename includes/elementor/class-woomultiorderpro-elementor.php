<?php
/**
 * Woo Multi Order Pro
 *
 * @author  Flance
 * @package Woomutiorderpro
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Icons_Manager;

if ( ! class_exists( 'Woomultiorderpro_Elementor' ) ) {
	/**
	 * WooMultiOrderPro shortcode class
	 *
	 * @return void
	 */
	class Woomultiorderpro_Elementor extends Widget_Base {
		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'woomultiorderpro-elementor';

		/**
		 * Handler Stiles, Javascript files.
		 *
		 * @var string
		 */
		protected $handler = 'woomultiorderpro-vc';

		/**
		 * Name escaped
		 *
		 * @var string
		 */
		protected $name_escaped;

		/**
		 * Constructor .
		 *
		 * @param array $data Data.
		 * @param null  $args Args.
		 */
		public function __construct( $data = array(), $args = null ) {
			parent::__construct( $data, $args );
			$this->wp_register_script_style();
		}

		/**
		 * Get style depends
		 *
		 * @return string[]
		 */
		public function wp_register_script_style() {
			global $woocommerce;
			$params                  = [];
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
			// Register Chosen script first, as it's a dependency for other scripts
			wp_register_script( 'woocommerce-chosen-js', $woocommerce->plugin_url() . '/assets/js/select2/select2.min.js', array( 'jquery' ), null, true );
			// Register DataTables script with 'woocommerce-chosen-js' as a dependency
			wp_register_script( 'datatables', FLANCE_PLUGIN_TABLE_URL . 'public/datatables/datatables.js', array( 'woocommerce-chosen-js' ), time(), true );
			// Register other scripts with appropriate dependencies
			wp_register_script( 'flance-add-multiple-products', FLANCE_PLUGIN_TABLE_URL . 'public/js/flance-add-multiple-products-public.js', array( 'jquery', 'woocommerce-chosen-js', 'datatables' ), time(), true );
			wp_register_script( 'flance-variations', FLANCE_PLUGIN_TABLE_URL . 'public/js/flance-add-multiple-variations.js', array( 'elementor-frontend', 'woocommerce-chosen-js', 'jquery', 'wp-util', 'jquery-blockui', 'ttt', ), time(), true );
			wp_localize_script(
				'flance-add-multiple-products',
				'WPURLS',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'siteurl' => plugins_url() . '/flance_add_multiple_products_order_form_woocommerce_pro/public/',
					'params'  => $params,
				)
			);

			return array( 'flance-add-multiple-products', 'flance-variations', 'datatables', 'woocommerce-chosen-js' );
		}

		/**
		 * Get style depends
		 *
		 * @return string[]
		 */
		public function get_style_depends() {
			return array( 'woocommerce-chosen-js' );
		}

		/**
		 * Get javascript depends
		 *
		 * @return string[]
		 */
		public function get_script_depends() {
			return array( 'flance-add-multiple-products', 'flance-variations', 'datatables', 'woocommerce-chosen-js' );
		}

		/**
		 * Get Name.
		 *
		 * @return string
		 */
		public function get_name() {
			return $this->slug;
		}

		/**
		 *  Get Title
		 */
		public function get_title() {
			return esc_html__( 'Woo Multi Order Pro', 'woomultiorderpro' );
		}

		/**
		 * Get Icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-price-table';
		}

		/**
		 * Get Categories.
		 *
		 * @return string[]
		 */
		public function get_categories() {
			return array( 'woomultiorderpro-widgets' );
		}

		/**
		 * Get General options.
		 *
		 * @author Flance
		 */
		protected function get_general_options() {
			$this->start_controls_section(
				'flance_table_section',
				array(
					'label' => esc_html__( 'Products Table Settings', 'woomultiorderpro' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);
			$this->add_control(
				'selected_products',
				array(
					'label'       => esc_html__( 'Select Display Products', 'woomultiorderpro' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple'    => true,
					'options'     => $this->get_products_options(), // Implement a method to retrieve WooCommerce products
				)
			);
			$this->add_control(
				'showname',
				array(
					'label'   => esc_html__( 'Show Name', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showname' ) ) ) ? get_option( 'showname' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showimage',
				array(
					'label'   => esc_html__( 'Show Image', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showimage' ) ) ) ? get_option( 'showimage' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'attribute',
				array(
					'label'   => esc_html__( 'Show Attribute', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'attribute' ) ) ) ? get_option( 'attribute' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showmfk',
				array(
					'label'   => esc_html__( 'Show Manufacture', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showmfk' ) ) ) ? get_option( 'showmfk' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showdesc',
				array(
					'label'   => esc_html__( 'Show Description', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showdesc' ) ) ) ? get_option( 'showdesc' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showsku',
				array(
					'label'   => esc_html__( 'Show SKU', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showsku' ) ) ) ? get_option( 'showsku' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showpkg',
				array(
					'label'   => esc_html__( 'Show PKG', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showpkg' ) ) ) ? get_option( 'showpkg' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showprice',
				array(
					'label'   => esc_html__( 'Show Price', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showprice' ) ) ) ? get_option( 'showprice' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showquantity',
				array(
					'label'   => esc_html__( 'Show Quantity', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showquantity' ) ) ) ? get_option( 'showquantity' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showlink',
				array(
					'label'   => esc_html__( 'Show Link', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showlink' ) ) ) ? get_option( 'showlink' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'instock',
				array(
					'label'   => esc_html__( 'Show In Stock', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'instock' ) ) ) ? get_option( 'instock' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'showaddtocart',
				array(
					'label'   => esc_html__( 'Show Add to Cart', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'showaddtocart' ) ) ) ? get_option( 'showaddtocart' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'redirect',
				array(
					'label'   => esc_html__( 'Redirection to the Link', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'redirect' ) ) ) ? get_option( 'redirect' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->add_control(
				'redirectlink',
				array(
					'label'   => esc_html__( 'Redirection Link', 'woomultiorderpro' ),
					'type'    => Controls_Manager::TEXT,
					'default' => ( ! empty( get_option( 'redirectlink' ) ) ) ? get_option( 'redirectlink' ) : '',
				)
			);
			$this->add_control(
				'reload',
				array(
					'label'   => esc_html__( 'Reload', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ( ! empty( get_option( 'reload' ) ) ) ? get_option( 'reload' ) : 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'woomultiorderpro' ),
						'n' => esc_html__( 'No', 'woomultiorderpro' ),
					),
				)
			);
			$this->end_controls_section();

		}

		private function get_products_options() {
			$products = get_posts(
				array(
					'post_type'      => 'product',
					'posts_per_page' => - 1,
					'post_status'    => 'publish', // Retrieve only published products
				)
			);
			$product_options = array();
			foreach ( $products as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}

			return $product_options;
		}

		/**
		 * Register Controls.
		 *
		 * @author Flance
		 */
		protected function register_controls() {
			$this->get_general_options();

		}

		/**
		 * Render.
		 */
		protected function render() {
			$atts = $this->get_settings_for_display();
			if ( ! empty( $content ) ) {
				$atts['content'] = $content;
			}
			//$arg_strings = woomultiorderpro_elementor_args( $atts );
			//echo do_shortcode( '[flance_products_form ' . $arg_strings . ']' );
			echo do_shortcode( '[flance_products_form product_ids=19,20,18,8]' );

		}
	}

	\Elementor\Plugin::instance()->widgets_manager->register( new Woomultiorderpro_Elementor() );

}

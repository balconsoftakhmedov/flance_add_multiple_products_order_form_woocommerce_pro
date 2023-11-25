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


			return array( $this->handler );
		}

		/**
		 * Get style depends
		 *
		 * @return string[]
		 */
		public function get_style_depends() {
			return array( $this->handler );
		}

		/**
		 * Get javascript depends
		 *
		 * @return string[]
		 */
		public function get_script_depends() {
			return array( $this->handler );
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
				'locations_section',
				array(
					'label' => esc_html__( 'Locations Markers', 'woomultiorderpro' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);


			$this->end_controls_section();

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
			$arg_strings = woomultiorderpro_elementor_args( $atts );
			echo do_shortcode( '[flance_products_form ' . $arg_strings . ']' );
		}
	}

	\Elementor\Plugin::instance()->widgets_manager->register( new Woomultiorderpro_Elementor() );

}

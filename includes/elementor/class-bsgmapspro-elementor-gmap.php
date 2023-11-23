<?php
/**
 * BsMap Elementor Google Map
 *
 * @author  Flance
 * @package BsMap
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

if ( ! class_exists( 'Woomultiorderpro_Elementor_Gmap' ) ) {
	/**
	 * Bs_Map shortcode class
	 *
	 * @return void
	 */
	class Woomultiorderpro_Elementor_Gmap extends Widget_Base {
		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'woomultiorderpro-elementor-gmap';

		/**
		 * Handler Stiles, Javascript files.
		 *
		 * @var string
		 */
		protected $handler = 'woomultiorderpro-vc-gmap';

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
			if ( file_exists( WOOMULTIORDERPRO_PATH . '/assets/dist/components/' . $this->handler . '/css/app.css' ) ) {
				wp_register_style( $this->handler, WOOMULTIORDERPRO_ASSETS . '/dist/components/' . $this->handler . '/css/app.css', array(), WOOMULTIORDERPRO_VERSION );
			}
			if ( file_exists( WOOMULTIORDERPRO_PATH . '/assets/dist/components/' . $this->handler . '/js/elementor/app.js' ) ) {
				wp_deregister_script( $this->handler );
				wp_register_script( $this->handler, WOOMULTIORDERPRO_ASSETS . '/dist/components/' . $this->handler . '/js/elementor/app.js', array( 'jquery' ), WOOMULTIORDERPRO_VERSION, true );
			}

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
			return esc_html__( 'BS Google Map Pro', 'woomultiorderpro' );
		}

		/**
		 * Get Icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-google-maps';
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
			$woomultiorderpro_map_key = get_option( 'woomultiorderpro_gmap_key' );
			if ( ! isset( $woomultiorderpro_map_key ) || '' === $woomultiorderpro_map_key ) {
				$this->add_control(
					'notice',
					array(
						'type' => Controls_Manager::RAW_HTML,
						'raw'  => '<div class="woomultiorderpro-notice">
                                <a target="_blank" href="' . admin_url( 'admin.php?page=bsmaps' ) . '">' . esc_html__( 'Click Here', 'woomultiorderpro' ) . '</a>' . esc_html__( 'to add google map api key.', 'woomultiorderpro' ) . '</div>',
					)
				);
			}
			$repeater = new Repeater();
			$repeater->add_control(
				'icon_url',
				array(
					'label' => esc_html__( 'Choose Image', 'woomultiorderpro' ),
					'type'  => Controls_Manager::MEDIA,
				)
			);
			$repeater->add_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Marker size', 'woomultiorderpro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 500,
							'step' => 1,
						),
					),
					'default'    => array(
						'unit' => 'px',
						'size' => 50,
					),
				)
			);
			$repeater->add_control(
				'lat',
				array(
					'label'       => esc_html__( 'Latitude', 'woomultiorderpro' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => '28.612912',
					'placeholder' => esc_html__( 'Enter Latitude', 'woomultiorderpro' ),
				)
			);
			$repeater->add_control(
				'lng',
				array(
					'label'       => esc_html__( 'Longtitute', 'woomultiorderpro' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => '77.229510',
					'placeholder' => esc_html__( 'Enter Longtitute', 'woomultiorderpro' ),
				)
			);
			$repeater->add_control(
				'name',
				array(
					'label'       => esc_html__( 'Location Name', 'woomultiorderpro' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => 'Some Location',
					'placeholder' => esc_html__( 'Enter Location Name', 'woomultiorderpro' ),
				)
			);
			$repeater->add_control(
				'description',
				array(
					'label'       => esc_html__( 'Location description', 'woomultiorderpro' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => 'Some description',
					'placeholder' => esc_html__( 'Enter description', 'woomultiorderpro' ),
				)
			);
			$this->add_control(
				'markers',
				array(
					'label'   => esc_html__( 'Markers', 'woomultiorderpro' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => array(
						array(
							'lat'     => '41',
							'lng'     => '87',
							'address' => esc_html__( 'Put Address Here', 'woomultiorderpro' ),
						),
					),
				)
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'map_center_section',
				array(
					'label' => esc_html__( 'Map Center', 'woomultiorderpro' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);
			$this->add_control(
				'map_center',
				array(
					'label'       => esc_html__( 'Map center coordinates', 'woomultiorderpro' ),
					'type'        => \Elementor\Controls_Manager::TEXTAREA,
					'row'         => '1',
					'default'     => '41.881832,-87.623177',
					'description' => esc_html__( 'Show this location as center of the map', 'woomultiorderpro' ),
				)
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'map_settings_section',
				array(
					'label' => esc_html__( 'Map Settings', 'woomultiorderpro' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);
			$this->add_control(
				'activetype',
				array(
					'label'   => esc_html__( 'Map type', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'satellite' => esc_html__( 'Satellite', 'woomultiorderpro' ),
						'hybrid'    => esc_html__( 'Hybrid', 'woomultiorderpro' ),
						'roadmap'   => esc_html__( 'Roadmap', 'woomultiorderpro' ),
						'terrain'   => esc_html__( 'Terrain', 'woomultiorderpro' ),
					),
					'default' => 'satellite',
				)
			);
			$this->add_control(
				'zoom',
				array(
					'label'   => esc_html__( 'Zoom', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => array(
						'px' => array(
							'min' => 0,
							'max' => 50,
						),
					),
					'default' => array(
						'unit' => 'px',
						'size' => 10,
					),
				)
			);
			$this->add_control(
				'overlay',
				array(
					'label'   => esc_html__( 'Overlay', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'full_screen_control',
				array(
					'label'   => esc_html__( 'Full screen control', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'disable_map_drag',
				array(
					'label'   => esc_html__( 'Disable map drag', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'zoom_controls',
				array(
					'label'   => esc_html__( 'Zoom controls', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'scroll_wheel_zoom',
				array(
					'label'   => esc_html__( 'Scroll wheel zoom', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'map_type_control',
				array(
					'label'   => esc_html__( 'Map type control', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'street_view_control',
				array(
					'label'   => esc_html__( 'Street view control', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_logo',
				array(
					'label'   => esc_html__( 'Hide logo', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_copyright',
				array(
					'label'   => esc_html__( 'Hide copyright', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_terms',
				array(
					'label'   => esc_html__( 'Hide terms', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_report',
				array(
					'label'   => esc_html__( 'Hide report', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_keyboard_shortcuts',
				array(
					'label'   => esc_html__( 'Hide keyboard shortcuts', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'hide_bottom_reqs',
				array(
					'label'   => esc_html__( 'Hide bottom reqs', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'info_containers_always_opened',
				array(
					'label'   => esc_html__( 'Info containers always opened', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'info_container_open_on_hover',
				array(
					'label'   => esc_html__( 'Info container open on hover', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->add_control(
				'marker_clusters',
				array(
					'label'   => esc_html__( 'Marker clusters', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'off',
				)
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'map_style_section',
				array(
					'label' => esc_html__( 'Map Styles', 'woomultiorderpro' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);
			$this->add_control(
				'activemode',
				array(
					'label'   => esc_html__( 'Style Mode', 'woomultiorderpro' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'defaultMode'   => esc_html__( 'Default Mode', 'woomultiorderpro' ),
						'silverMode'    => esc_html__( 'Silver Mode', 'woomultiorderpro' ),
						'nightMode'     => esc_html__( 'Night Mode', 'woomultiorderpro' ),
						'retroMode'     => esc_html__( 'Retro Mode', 'woomultiorderpro' ),
						'darkMode'      => esc_html__( 'Dark Mode', 'woomultiorderpro' ),
						'aubergineMode' => esc_html__( 'Aubergine Mode', 'woomultiorderpro' ),
						'customMode'    => esc_html__( 'Custom Mode', 'woomultiorderpro' ),
					),
					'default' => 'defaultMode',
				)
			);
			$this->add_control(
				'customMode',
				array(
					'label'       => esc_html__( 'Custom Style Json code', 'woomultiorderpro' ),
					'type'        => \Elementor\Controls_Manager::TEXTAREA,
					'row'         => '11',
					'default'     => '',
					'placeholder' => esc_html__( 'Enter your JSON code here', 'woomultiorderpro' ),
					'condition'   => array(
						'activemode' => 'customMode',
					),
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
			echo do_shortcode( '[woomultiorderpro-vc-gmap-shortcode ' . $arg_strings . ']' );
		}
	}

	\Elementor\Plugin::instance()->widgets_manager->register( new Woomultiorderpro_Elementor_Gmap() );

}

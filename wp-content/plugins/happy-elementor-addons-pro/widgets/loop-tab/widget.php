<?php
	/**
	 * Advanced Tabs
	 *
	 * @package Happy_Addons_Pro
	 */
	namespace Happy_Addons_Pro\Widget;

	use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Happy_Addons\Elementor\Controls\Group_Control_Foreground;

	defined( 'ABSPATH' ) || die();

	class Loop_Tab extends Base {

		/**
		 * Get widget title.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return __( 'Loop Tab', 'happy-addons-pro' );
		}

		/**
		 * Get widget user document.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget document.
		 */
		public function get_custom_help_url() {
			return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/loop-tab/';
		}

		/**
		 * Get widget icon.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'hm hm-edd-my-account-tab';
		}

		public function get_keywords() {
			return ['tabs', 'section', 'advanced', 'loop', 'loop tabs', 'tab'];
		}

		/**
		 * Register widget content controls
		 */
		protected function register_content_controls() {
			$this->__tabs_content_controls();
			$this->__settings_content_controls();
		}

		protected function __tabs_content_controls() {

			$isContainerActive    = ha_elementor()->experiments->is_feature_active( 'container' );
			$elementorLibraryType = $isContainerActive ? 'container' : 'section';

			$this->start_controls_section(
				'_section_tabs',
				[
					'label' => __( 'Tabs', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_CONTENT
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'title',
				[
					'type'        => Controls_Manager::TEXT,
					'label'       => __( 'Title', 'happy-addons-pro' ),
					'default'     => __( 'Tab Title', 'happy-addons-pro' ),
					'placeholder' => __( 'Type Tab Title', 'happy-addons-pro' ),
					'dynamic'     => [
						'active' => true
					]
				]
			);

			$repeater->add_control(
				'icon',
				[
					'type'       => Controls_Manager::ICONS,
					'label'      => __( 'Icon', 'happy-addons-pro' ),
					'show_label' => false
				]
			);

			$repeater->add_control(
				'sub_title',
				[
					'type'        => Controls_Manager::TEXT,
					'label'       => __( 'Sub Title', 'happy-addons-pro' ),
					'default'     => '',
					'placeholder' => __( 'Type Sub Title', 'happy-addons-pro' ),
					'dynamic'     => [
						'active' => true
					]
				]
			);

			$repeater->add_control(
				'source',
				[
					'type'      => Controls_Manager::SELECT,
					'label'     => __( 'Content Source', 'happy-addons-pro' ),
					'default'   => 'editor',
					'separator' => 'before',
					'options'   => [
						'editor'   => __( 'Editor', 'happy-addons-pro' ),
						'template' => __( 'Template', 'happy-addons-pro' )
					]
				]
			);

			$repeater->add_control(
				'editor',
				[
					'label'      => __( 'Content Editor', 'happy-addons-pro' ),
					'show_label' => false,
					'type'       => Controls_Manager::WYSIWYG,
					'condition'  => [
						'source' => 'editor'
					],
					'dynamic'    => [
						'active' => true
					]
				]
			);

			$repeater->add_control(
				'template',
				[
					'label'       => __( 'Template', 'happy-addons-pro' ),
					'placeholder' => __( 'Select a template to use as tab content', 'happy-addons-pro' ),
					'description' => sprintf( __( 'Wondering what is template or need to create one? Please click %1$shere%2$s ', 'happy-addons-pro' ),
						'<a target="_blank" href="' . esc_url( admin_url( '/edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=' . $elementorLibraryType ) ) . '">',
						'</a>'
					),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'options'     => hapro_get_section_templates(),
					'condition'   => [
						'source' => 'template'
					]
				]
			);

			$repeater->add_control(
				'tab_full_section_bg',
				[
					'label'       => esc_html__( 'Full Container Background', 'happy-addons-pro' ),
					'type'        => Controls_Manager::COLOR,
					'render_type' => 'template'
				]
			);

			$this->add_control(
				'tabs',
				[
					'show_label'      => false,
					'type'            => Controls_Manager::REPEATER,
					'fields'          => $repeater->get_controls(),
					'title_field'     => '{{title}}',
					'sub_title_field' => '{{sub_title}}',
					'default'         => [
						[
							'title'     => 'Tab 1',
							'sub_title' => '',
							'source'    => 'editor',
							'editor'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore <br><br>et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						],
						[
							'title'     => 'Tab 2',
							'sub_title' => '',
							'source'    => 'editor',
							'editor'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore <br><br>et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						],
						[
							'title'     => 'Tab 3',
							'sub_title' => '',
							'source'    => 'editor',
							'editor'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore <br><br>et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						]
					]
				]
			);

			$this->add_control(
				'rpt_magic',
				[
					'label'        => __( 'none', 'happy-addons-pro' ),
					'type'         => Controls_Manager::HIDDEN,
					'default'      => 'retaeper',
					'prefix_class' => 'cigam-'
				]
			);

			$this->end_controls_section();
		}

		protected function __settings_content_controls() {

			$this->start_controls_section(
				'_section_settings',
				[
					'label' => __( 'Settings', 'happy-addons-pro' )
				]
			);

			$this->add_control(
				'_heading_tab_title',
				[
					'label' => __( 'Tab Title', 'happy-addons-pro' ),
					'type'  => Controls_Manager::HEADING
				]
			);

			$this->add_control(
				'nav_position',
				[
					'type'           => Controls_Manager::CHOOSE,
					'label'          => __( 'Tab Position', 'happy-addons-pro' ),
					'description'    => __( 'Applicable to Desktop & Tablet layout', 'happy-addons-pro' ),
					'default'        => 'left',
					'toggle'         => false,
					'options'        => [
						'left' => [
							'title' => __( 'Left', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-left'
						],
						'top'  => [
							'title' => __( 'Top', 'happy-addons-pro' ),
							'icon'  => 'eicon-v-align-top'
						]
					],
					'style_transfer' => true
				]
			);

			$this->add_control(
				'enable_double_column',
				[
					'label'              => __( 'Enable Double Column', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SWITCHER,
					'description'        => __( 'Enable this option to show tabs in double column. Applicable to only Desktop layout.', 'happy-addons-pro' ),
					'default'            => 'no',
					'prefix_class'       => 'ha-loop-tab-double-column-',
					'return_value'       => 'yes',
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template',
					'condition'          => [
						'nav_position' => 'left'
					]
				]
			);

			$this->add_control(
				'nav_vertical_position',
				[
					'type'           => Controls_Manager::CHOOSE,
					'label'          => __( 'Vertical Alignment', 'happy-addons-pro' ),
					'description'    => __( 'Applicable to Desktop & Tablet layout', 'happy-addons-pro' ),
					'default'        => 'flex-start',
					'toggle'         => false,
					'options'        => [
						'flex-start' => [
							'title' => __( 'Top', 'happy-addons-pro' ),
							'icon'  => 'eicon-v-align-top'
						],
						'center'     => [
							'title' => __( 'Center', 'happy-addons-pro' ),
							'icon'  => 'eicon-v-align-middle'
						]
					],
					'selectors'      => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'justify-content: {{VALUE}};'
					],
					'style_transfer' => true,
					'condition'      => [
						'nav_position' => ['left']
					]
				]
			);

			$this->add_control(
				'nav_horizontal_position',
				[
					'type'                 => Controls_Manager::CHOOSE,
					'label'                => __( 'Horizontal Alignment', 'happy-addons-pro' ),
					'description'          => __( 'Applicable to Desktop & Tablet layout', 'happy-addons-pro' ),
					'default'              => 'center',
					'toggle'               => false,
					'options'              => [
						'x-left'   => [
							'title' => __( 'Left', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-left'
						],
						'x-center' => [
							'title' => __( 'Center', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-center'
						],
						'x-right'  => [
							'title' => __( 'Right', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-right'
						]
					],
					'selectors'            => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'align-items: {{VALUE}};'
					],
					'selectors_dictionary' => [
						'x-left'   => 'flex-start',
						'x-right'  => 'flex-end',
						'x-center' => 'center'
					],
					'style_transfer'       => true,
					'condition'            => [
						'nav_position'          => ['left'],
						'enable_double_column!' => 'yes'
					]
				]
			);

			$this->add_control(
				'nav_item_alignment_x',
				[
					'type'                 => Controls_Manager::CHOOSE,
					'label'                => __( 'Alignment', 'happy-addons-pro' ),
					'default'              => 'x-center',
					'toggle'               => false,
					'options'              => [
						'x-left'   => [
							'title' => __( 'Left', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-left'
						],
						'x-center' => [
							'title' => __( 'Center', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-center'
						],
						'x-right'  => [
							'title' => __( 'Right', 'happy-addons-pro' ),
							'icon'  => 'eicon-h-align-right'
						]
					],
					'selectors'            => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav'                                                      => 'justify-content: {{VALUE}};',
						'{{WRAPPER}}.ha-loop-tab-nav-item-x-justify.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item' => 'flex-grow: 1;'

					],
					'selectors_dictionary' => [
						'x-left'   => 'flex-start',
						'x-right'  => 'flex-end',
						'x-center' => 'center'
					],
					'condition'            => [
						'nav_position' => ['top']
					],
					'style_transfer'       => true,
					'prefix_class'         => 'ha-loop-tab-nav-item-'
				]
			);

			$this->add_control(
				'nav_text_alignment',
				[
					'type'                 => Controls_Manager::CHOOSE,
					'label'                => __( 'Text Alignment', 'happy-addons-pro' ),
					'default'              => 'center',
					'toggle'               => false,
					'options'              => [
						'left'   => [
							'title' => __( 'Left', 'happy-addons-pro' ),
							'icon'  => 'eicon-text-align-left'
						],
						'center' => [
							'title' => __( 'Center', 'happy-addons-pro' ),
							'icon'  => 'eicon-text-align-center'
						],
						'right'  => [
							'title' => __( 'Right', 'happy-addons-pro' ),
							'icon'  => 'eicon-text-align-right'
						]
					],
					'selectors'            => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item' => 'justify-content: {{VALUE}};'
					],
					'selectors_dictionary' => [
						'left'   => 'flex-start',
						'center' => 'center',
						'right'  => 'flex-end'
					],
					'style_transfer'       => true
				]
			);

			$this->add_control(
				'tab_action',
				[
					'label'              => __( 'Action', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SELECT,
					'options'            => [
						'on_click' => __( 'On Click', 'happy-addons-pro' ),
						'on_hover' => __( 'On Hover', 'happy-addons-pro' )
					],
					'default'            => 'on_click',
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->add_control(
				'tab_transition_delay',
				[
					'label'              => __( 'Transition Delay (ms)', 'happy-addons-pro' ),
					'type'               => Controls_Manager::NUMBER,
					'description'        => __( 'Preset a value between 1000 and 40000', 'happy-addons-pro' ),
					'default'            => 8000,
					'min'                => 1000,
					'max'                => 40000,
					'step'               => 100,
					'condition'          => [
						'tab_action' => 'on_click'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->end_controls_section();
		}

		protected function register_style_controls() {
			$this->__tab_container_style_controls();
			$this->__tab_title_style_controls();
			$this->__tab_strok_style_controls();
			$this->__tab_icon_style_controls();
			$this->__content_style_controls();
		}

		protected function __tab_container_style_controls() {
			$this->start_controls_section(
				'_section_tab_container',
				[
					'label' => __( 'Tab Container', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_STYLE
				]
			);

			$this->add_responsive_control(
				'nav_item_width',
				[
					'label'              => __( 'Width', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', '%'],
					'range'              => [
						'px' => [
							'min'  => 50,
							'max'  => 1200,
							'step' => 1
						],
						'%'  => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 350
					],
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'width: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'nav_position'          => 'left',
						'enable_double_column!' => 'yes'
					]
				]
			);

			$this->add_responsive_control(
				'nav_item_top_width',
				[
					'label'              => __( 'Width', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', '%'],
					'range'              => [
						'px' => [
							'min'  => 50,
							'max'  => 1200,
							'step' => 1
						],
						'%'  => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => '%',
						'size' => 100
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper.ha-loop-tab-x .ha-loop-tab-nav' => 'width: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'nav_position'          => 'top',
						'enable_double_column!' => 'yes'
					]
				]
			);

			$this->add_responsive_control(
				'nav_item_double_column_width',
				[
					'label'              => __( 'Width', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', '%'],
					'range'              => [
						'px' => [
							'min'  => 50,
							'max'  => 1200,
							'step' => 1
						],
						'%'  => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 580
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab.ha-loop-tab-double-column-yes .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'width: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'enable_double_column' => 'yes',
						'nav_position'         => 'left'
					]
				]
			);

			$this->add_responsive_control(
				'tab_content_padding',
				[
					'label'              => __( 'Padding', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px', 'em', '%'],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'               => 'tab_content_border',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_content_border_radius',
				[
					'label'              => __( 'Border Radius', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px', '%'],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_content_bg',
				[
					'label'              => __( 'Background Color', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'default'            => '#FFF',
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'background: {{VALUE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_section();
		}

		protected function __tab_title_style_controls() {
			$this->start_controls_section(
				'_section_tab_nav',
				[
					'label' => __( 'Tab Item', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_STYLE
				]
			);

			$this->add_responsive_control(
				'nav_item_gap',
				[
					'label'              => __( 'Gap Between', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 10
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav ' => 'gap: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'enable_double_column!' => 'yes'
					]
				]
			);
			$this->add_responsive_control(
				'nav_item_gap_y',
				[
					'label'              => __( 'Vertical Gap Between', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 10
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav' => 'row-gap: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'enable_double_column' => 'yes'
					]
				]
			);
			$this->add_responsive_control(
				'nav_item_gap_x',
				[
					'label'              => __( 'Horizontal Gap Between', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 10
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav ' => 'column-gap: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'condition'          => [
						'enable_double_column' => 'yes'
					]
				]
			);
			$this->add_control(
				'tab_nav_item_width',
				[
					'label'              => __( 'Width', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 1200,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 280
					],
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item'                                                 => 'width: {{SIZE}}{{UNIT}};',
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav'                                                                       => 'grid-template-columns: repeat(2, {{SIZE}}{{UNIT}});',
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg'             => 'width: {{SIZE}}{{UNIT}}',
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg .tab-border' => 'width: {{SIZE}}{{UNIT}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->add_control(
				'tab_nav_item_height',
				[
					'label'              => __( 'Height', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px'],
					'range'              => [
						'px' => [
							'min'  => 45,
							'max'  => 500,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 65
					],
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item'                                                 => 'height: {{SIZE}}{{UNIT}};',
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg'             => 'height: {{SIZE}}{{UNIT}}',
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg .tab-border' => 'width: {{SIZE}}{{UNIT}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->add_control(
				'tab_nav_item_border_radius',
				[
					'label'              => __( 'Border Radius', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 32.5
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item' => 'border-radius: {{SIZE}}{{UNIT}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->add_responsive_control(
				'tab_nav_item_padding',
				[
					'label'              => __( 'Padding', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px'],
					'default'            => [
						'top'    => 5,
						'right'  => 10,
						'bottom' => 5,
						'left'   => 10,
						'unit'   => 'px'
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'               => 'tab_nav_item_typography',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'               => 'tab_nav_item_box_shadow',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			// Tab Nav Status Control
			$this->__tab_nav_status_control();

			// subtitle Controls
			$this->__sub_title_style_control();

			$this->end_controls_section();
		}

		private function __tab_nav_status_control() {
			$this->start_controls_tabs( '_tab_nav_stats' );
			$this->start_controls_tab(
				'_tab_nav_item_normal',
				[
					'label' => __( 'Normal', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'               => 'tab_nav_normal_border',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'               => 'tab_nav_normal_text_gradient',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'               => 'tab_nav_normal_bg',
					'types'              => ['classic', 'gradient'],
					'exclude'            => ['image'],
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'_tab_nav_item_active',
				[
					'label' => __( 'Active', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'               => 'tab_nav_active_border',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item.active',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'     => 'tab_nav_active_text',
					'selector' => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item.active .ha-loop-tab-title'
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'tab_nav_active_bg',
					'types'    => ['classic', 'gradient'],
					'exclude'  => ['image'],
					'selector' => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item.active'
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'_tab_nav_item_hover',
				[
					'label' => __( 'Hover', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'               => 'tab_nav_hover_text_gradient',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item:hover .ha-loop-tab-title',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_nav_item_hover_bg',
				[
					'label'              => __( 'Background ', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'default'            => '#e8eaed',
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item:hover' => 'background: {{VALUE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tabs();
		}

		private function __sub_title_style_control() {
			$this->add_control(
				'tab_nav_item_sub_title_heading',
				[
					'label'     => esc_html__( 'Sub Title', 'happy-addons-pro' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'after'
				]
			);

			$this->add_responsive_control(
				'tab_nav_item_sub_title_gap',
				[
					'label'              => __( 'Gap Between', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1
						]
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-container ' => 'gap: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_responsive_control(
				'tab_nav_item_sub_title_padding',
				[
					'label'              => __( 'Padding', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px'],
					'default'            => [
						'top'    => 0,
						'right'  => 0,
						'bottom' => 0,
						'left'   => 0,
						'unit'   => 'px'
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-container .ha-loop-tab-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'               => 'tab_nav_item_sub_title_typography',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-container .ha-loop-tab-subtitle',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->__tab_nav_subtitle_status_control();

		}

		private function __tab_nav_subtitle_status_control() {

			$this->start_controls_tabs( '_tab_nav_subtitle_stats' );

			$this->start_controls_tab(
				'_tab_nav_item_subtitle_normal',
				[
					'label' => __( 'Normal', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'               => 'tab_nav_subtitle_normal_text_gradient',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-container .ha-loop-tab-subtitle',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'_tab_nav_subtitle_item_active',
				[
					'label' => __( 'Active', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'     => 'tab_nav_subtitle_active_text',
					'selector' => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item.active .ha-loop-tab-title-container .ha-loop-tab-subtitle'
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'_tab_nav_subtitle_item_hover',
				[
					'label' => __( 'Hover', 'happy-addons-pro' )
				]
			);

			$this->add_group_control(
				Group_Control_Foreground::get_type(),
				[
					'name'               => 'tab_nav_subtitle_hover_text_gradient',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item:hover .ha-loop-tab-title-container .ha-loop-tab-subtitle',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tabs();
		}

		protected function __tab_strok_style_controls() {
			$this->start_controls_section(
				'_section_tab_stroke',
				[
					'label' => __( 'Loading Stroke', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_STYLE
				]
			);

			$this->add_responsive_control(
				'tab_nav_item_stroke_width',
				[
					'label'              => __( 'Thickness', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px'],
					'range'              => [
						'px' => [
							'min'  => 2,
							'max'  => 7,
							'step' => 1
						]
					],
					'default'            => [
						'unit' => 'px',
						'size' => 3
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg .tab-border' => 'stroke-width: {{SIZE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true,
					'render_type'        => 'template'
				]
			);

			$this->add_control(
				'tab_nav_item_stroke_color',
				[
					'label'              => __( 'Color', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container .tab-svg .tab-border' => 'stroke: {{VALUE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_nav_item_stroke_left_position',
				[
					'label'              => __( 'Horizontal Position', 'happy-addons-pro' ),
					'type'               => Controls_Manager::NUMBER,
					'min'                => -100,
					'max'                => 100,
					'step'               => 1,
					'default'            => -1,
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container' => 'left: {{VALUE}}px;'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_nav_item_stroke_top_position',
				[
					'label'              => __( 'Vertical Position', 'happy-addons-pro' ),
					'type'               => Controls_Manager::NUMBER,
					'min'                => -100,
					'max'                => 100,
					'step'               => 1,
					'default'            => -2,
					'selectors'          => [
						'(tablet+){{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-svg-container' => 'top: {{VALUE}}px;'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_section();
		}

		protected function __tab_icon_style_controls() {
			$this->start_controls_section(
				'_section_tab_icon',
				[
					'label' => __( 'Icon', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_STYLE
				]
			);

			$this->add_control(
				'tab_icon_size',
				[
					'label'              => __( 'Size', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'tab_icon_gap',
				[
					'label'              => __( 'Gap Between', 'happy-addons-pro' ),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => ['px', 'em'],
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item' => 'gap: {{SIZE}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->start_controls_tabs( '_tab_nav_icon_stats' );
			$this->start_controls_tab(
				'_tab_nav_icon_normal',
				[
					'label' => __( 'Normal', 'happy-addons-pro' )
				]
			);

			$this->add_control(
				'tab_icon_normal_color',
				[
					'label'              => __( 'Color', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item .ha-loop-tab-title-icon' => 'color: {{VALUE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'_tab_nav_icon_active',
				[
					'label' => __( 'Active', 'happy-addons-pro' )
				]
			);

			$this->add_control(
				'tab_icon_active_color',
				[
					'label'              => __( 'Color', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-nav .ha-loop-tab-nav-item.active .ha-loop-tab-title-icon' => 'color: {{VALUE}}'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();
		}

		protected function __content_style_controls() {
			$this->start_controls_section(
				'_section_content',
				[
					'label' => __( 'Content', 'happy-addons-pro' ),
					'tab'   => Controls_Manager::TAB_STYLE
				]
			);

			$this->add_responsive_control(
				'content_padding',
				[
					'label'              => __( 'Padding', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px', 'em', '%'],
					'default'            => [
						'top'    => 0,
						'right'  => 15,
						'bottom' => 0,
						'left'   => 15,
						'unit'   => 'px'
					],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'               => 'content_border',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'content_border_radius',
				[
					'label'              => __( 'Border Radius', 'happy-addons-pro' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => ['px', '%'],
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'               => 'content_typography',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents .ha-loop-tab_content',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_control(
				'content_color',
				[
					'label'              => __( 'Color', 'happy-addons-pro' ),
					'type'               => Controls_Manager::COLOR,
					'selectors'          => [
						'{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents .ha-loop-tab_content' => 'color: {{VALUE}};'
					],
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'               => 'content_bg',
					'types'              => ['classic', 'gradient'],
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'               => 'content_box_shadow',
					'selector'           => '{{WRAPPER}}.ha-loop-tab .ha-loop-tab-wrapper .ha-loop-tab-contents',
					'style_transfer'     => true,
					'frontend_available' => true
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings     = $this->get_settings_for_display();
			$tabs         = (array) $settings['tabs'];
			$tabs         = (array) $settings['tabs'];
			$nav_position = $settings['nav_position'];
			$this->add_render_attribute( 'ha_loop_tab', 'class', [
				'ha-loop-tab-' . $this->get_id(),
				'ha-loop-tab-wrapper'
			] );

			if ( 'top' === $nav_position ) {
				$this->add_render_attribute( 'ha_loop_tab', 'class', 'ha-loop-tab-x' );
			}

			$this->add_render_attribute( 'ha_loop_tab', 'role', 'tablist' );

		?>

			<div			     <?php $this->print_render_attribute_string( 'ha_loop_tab' ); ?> >
				<div class="ha-loop-tab-nav">
					<?php
						foreach ( $tabs as $key => $tab ):
									$tab_title_setting_key = $this->get_repeater_setting_key( 'title', 'tabs', $key );

									$bgColors = esc_attr( $tab['tab_full_section_bg'] );

									$this->add_render_attribute( $tab_title_setting_key, [
										'id'                 => 'tab_nav_item_' . $key,
										'class'              => ['ha-loop-tab-nav-item', 'elementor-repeater-item-' . $key],
										'data-tab'           => $key,
										'role'               => 'tab',
										'container-bgcolors' => json_encode( $bgColors )
									] );

								?>

							<div							     <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
										<?php if ( ! empty( $tab['icon'] ) && ! empty( $tab['icon']['value'] ) ) {?>
											<span class="ha-loop-tab-title-icon"><?php ha_render_icon( $tab, false, 'icon' ); ?></span>
										<?php }?>
								<div class="ha-loop-tab-title-container">
									<span class="ha-loop-tab-title"><?php echo ha_kses_basic( $tab['title'] ); ?></span>
									<?php
										if ( isset( $tab['sub_title'] ) && ! empty( $tab['sub_title'] ) ) {?>
											<span class="ha-loop-tab-subtitle"><?php echo ha_kses_basic( $tab['sub_title'] ); ?></span>
										<?php }?>

								</div>
								<span class="ha-loop-tab-svg-container">
									<svg class="tab-svg" xmlns="http://www.w3.org/2000/svg" width="280" height="65" viewBox="0 0 280 65">
										<rect class="tab-border" />
									</svg>
								</span>
							</div>

						<?php endforeach; ?>
				</div>

				<div class="ha-loop-tab-contents">
				<?php
					foreach ( $tabs as $key => $item ):

								if ( 'editor' === $item['source'] ) {
									$tab_content_setting_key = $this->get_repeater_setting_key( 'editor', 'tabs', $key );
								} else {
									$tab_content_setting_key = $this->get_repeater_setting_key( 'section', 'tabs', $key );
								}

								$this->add_render_attribute( $tab_content_setting_key, [
									'id'       => 'ha_loop_tab_content_' . $key,
									'class'    => ['ha-loop-tab_content'],
									'data-tab' => $key,
									'role'     => 'tabpanel'
								] );

							?>

								<div								     <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
									<?php
											if ( 'editor' === $item['source'] ) {
														echo $this->parse_text_editor( $item['editor'] );
													} else if ( 'template' === $item['source'] && $item['template'] ) {
													$item_template = apply_filters( 'wpml_object_id', $item['template'], 'elementor_library' );
													echo ha_elementor()->frontend->get_builder_content_for_display( $item_template );
												}
											?>
							</div>
						<?php endforeach; ?>

				</div>

			</div>

		<?php
			}

		}

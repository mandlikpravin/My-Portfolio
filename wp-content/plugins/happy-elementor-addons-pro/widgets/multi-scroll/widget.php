<?php
/**
 * Multi Scroll widget class
 *
 * @package Happy_Addons_Pro
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

use Happy_Addons_Pro\Classes\Lazy_Query_Manager;
use Happy_Addons_Pro\Controls\Lazy_Select;
use Happy_Addons_Pro\Traits\Lazy_Query_Builder;

defined( 'ABSPATH' ) || die();

class Multi_Scroll extends Base {
    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __( 'Multi Scroll', 'happy-addons-pro' );
    }

	public function get_custom_help_url() {
		return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/multi-scroll/';
	}

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'hm hm-multi-page-scroll';
    }

    public function get_keywords() {
        return ['one page scroll', 'full page js', 'page piling', 'page pilling', 'multi scroll', 'page scroll', 'scroll'];
    }

    /**
     * Register widget content controls
     */
    protected function register_content_controls() {
        $this->__content_controls();
		$this->__options_controls();
    }

    protected function left_select_controls( $repeater ) {

		$repeater->add_control(
			'left_section_type',
			[
				'label'   => __( 'Left Section Type', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'editor' => __( 'Editor', 'happy-addons-pro' ),
					'temp' => __( 'Template', 'happy-addons-pro' ),
				],
				'default' => 'temp',
			]
		);

		$repeater->add_control(
			'left_section_text',
			[
				'label'   => __( 'Left Editor', 'happy-addons-pro' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default'     => __( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate eius et harum architecto, aliquid necessitatibus debitis magnam vel autem quas repellat quis. Asperiores nam, voluptatibus alias sit tempore illum eligendi.', 'happy-addons-pro' ),
				'label_block' => true,
				'show_label' => false,
				'dynamic'     => [
					'active' => true
				],
				'condition'   => [
					'left_section_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
			'left_section_bg',
			[
				'label' => __('Background', 'happy-addons-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-wrap {{CURRENT_ITEM}}.ha-multi-scroll-left-section-text' => 'background-color: {{VALUE}}',
				],
				'style_transfer' => true,
				'condition'   => [
					'left_section_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
			'left_side_temp_post_type',
			[
				'label'   => esc_html__( 'Left Template Post Type', 'happy-addons-pro' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'elementor_library',
				'condition'   => [
					'left_section_type' => 'temp',
				],
			]
		);

		$repeater->add_control(
			'left_side_temp',
			[
				'label'       => __( 'Choose a Template', 'happy-addons-pro' ),
				'type'        => Lazy_Select::TYPE,
				'multiple'    => false,
                'label_block' => true,
                'show_label' => false,
				'placeholder' => __( 'Type and select template', 'happy-addons-pro' ),
				'lazy_args'   => [
					'query'         => Lazy_Query_Manager::QUERY_TEMPLATES,
					'widget_props'  => [
						'post_type' => 'left_side_temp_post_type'
					],
				],
				'condition'   => [
					'left_section_type' => 'temp',
				],
			]
		);

		$repeater->add_control(
			'left_template_create_btn',
			[
				'label'       => esc_html__( 'Create Template', 'happy-addons-pro' ),
				'show_label'  => false,
				'label_block' => true,
				'type'        => Controls_Manager::RAW_HTML,
				'raw'         => '<a target="_blank" class="elementor-button elementor-button-default" href="' . esc_url( admin_url( 'edit.php?post_type=elementor_library' ) ) . '">' . esc_html__( 'Create Template', 'happy-addons-pro' ) . '</a>',
				'condition'   => [
					'left_side_temp' => ['', null],
					'left_section_type' => 'temp',
				]
			]
		);

		$repeater->add_control(
			'left_template_edit_btn',
			[
				'label'       => esc_html__( 'Edit Template', 'happy-addons-pro' ),
				'show_label'  => false,
				'label_block' => true,
				'type'        => Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text'        => esc_html__( 'Edit Template', 'happy-addons-pro' ),
				'event'       => 'happyAddons:MultiScrollLeft:edit',
				'condition'   => [
					'left_side_temp!' => ['', null],
					'left_section_type' => 'temp',
				]
			]
		);
	}

    protected function right_select_controls( $repeater ) {

		$repeater->add_control(
			'right_section_type',
			[
				'label'   => __( 'Right Section Type', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'editor' => __( 'Editor', 'happy-addons-pro' ),
					'temp' => __( 'Template', 'happy-addons-pro' ),
				],
				'default' => 'temp',
			]
		);

		$repeater->add_control(
			'right_section_text',
			[
				'label'   => __( 'Right Editor', 'happy-addons-pro' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default'     => __( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate eius et harum architecto, aliquid necessitatibus debitis magnam vel autem quas repellat quis. Asperiores nam, voluptatibus alias sit tempore illum eligendi.', 'happy-addons-pro' ),
				'label_block' => true,
				'show_label' => false,
				'dynamic'     => [
					'active' => true
				],
				'condition'   => [
					'right_section_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
			'right_section_bg',
			[
				'label' => __('Background Color', 'happy-addons-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-wrap {{CURRENT_ITEM}}.ha-multi-scroll-right-section-text' => 'background-color: {{VALUE}}',
				],
				'style_transfer' => true,
				'condition'   => [
					'right_section_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
			'right_side_temp_post_type',
			[
				'label'   => esc_html__( 'Right Template Post Type', 'happy-addons-pro' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'elementor_library',
				'condition'   => [
					'right_section_type' => 'temp',
				],
			]
		);

		$repeater->add_control(
			'right_side_temp',
			[
				'label'       => __( 'Choose a Template', 'happy-addons-pro' ),
				'type'        => Lazy_Select::TYPE,
				'multiple'    => false,
                'label_block' => true,
                'show_label' => false,
				'placeholder' => __( 'Type and select template', 'happy-addons-pro' ),
				'lazy_args'   => [
					'query'         => Lazy_Query_Manager::QUERY_TEMPLATES,
					'widget_props'  => [
						'post_type' => 'right_side_temp_post_type'
					],
				],
				'condition'   => [
					'right_section_type' => 'temp',
				],
			]
		);

		$repeater->add_control(
			'right_template_create_btn',
			[
				'label'       => esc_html__( 'Create Template', 'happy-addons-pro' ),
				'show_label'  => false,
				'label_block' => true,
				'type'        => Controls_Manager::RAW_HTML,
				'raw'         => '<a target="_blank" class="elementor-button elementor-button-default" href="' . esc_url( admin_url( 'edit.php?post_type=elementor_library' ) ) . '">' . esc_html__( 'Create Template', 'happy-addons-pro' ) . '</a>',
				'condition'   => [
					'right_side_temp' => ['', null],
					'right_section_type' => 'temp',
				]
			]
		);

		$repeater->add_control(
			'right_template_edit_btn',
			[
				'label'       => esc_html__( 'Edit Template', 'happy-addons-pro' ),
				'show_label'  => false,
				'label_block' => true,
				'type'        => Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text'        => esc_html__( 'Edit Template', 'happy-addons-pro' ),
				'event'       => 'happyAddons:MultiScrollRight:edit',
				'condition'   => [
					'right_side_temp!' => ['', null],
					'right_section_type' => 'temp',
				]
			]
		);
	}

    protected function __content_controls() {

        //Display Text
        $this->start_controls_section(
            '_section_multiscroll_content',
            [
                'label' => __( 'Content', 'happy-addons-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new REPEATER();

		$this->left_select_controls( $repeater );
		$this->right_select_controls( $repeater );

        $repeater->add_control(
            'menu_text',
            [
                'label'       => __( 'Menu Title', 'happy-addons-pro' ),
                'placeholder' => __( 'Set menu title', 'happy-addons-pro' ),
                'description' => __( 'Menu will show if you enable menu in settings.', 'happy-addons-pro' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => false,
                ],
				'separator' => 'before',
                //'render_type' => 'ui', //ui template
            ]
        );

        $repeater->add_control(
            'dot_tooltip',
            [
                'label'       => __( 'Dot Tooltip', 'happy-addons-pro' ),
                'placeholder' => __( 'Set dot tooltip', 'happy-addons-pro' ),
                'description' => __( 'Tooltip will show if you enable dot nav in settings.', 'happy-addons-pro' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => false,
                ],
            ]
        );

        $repeater->add_control(
            'anchor',
            [
                'label'       => __( 'Anchor Text', 'happy-addons-pro' ),
                'placeholder' => __( 'section-1', 'happy-addons-pro' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => false,
                ]
            ]
        );

        $this->add_control(
            'multi_scroll_sections',
            [
                'label'      => __( 'Sections', 'happy-addons-pro' ),
                'show_label' => false,
                'type'       => Controls_Manager::REPEATER,
                'fields'     => $repeater->get_controls(),
				'title_field' => '{{left_section_type.charAt(0).toUpperCase() + left_section_type.slice(1) + " | " + right_section_type.charAt(0).toUpperCase() + right_section_type.slice(1)}}',
                'default' => [
                    [
                        'left_section_type' => 'editor',
                        'right_section_type' => 'editor',
                        'menu_text' => __('Menu 1', 'happy-addons-pro'),
                        'dot_tooltip' => __('Tooltip 1', 'happy-addons-pro'),
                        'anchor' => __('section-1', 'happy-addons-pro'),
                    ],
                    [
                        'left_section_type' => 'editor',
                        'right_section_type' => 'editor',
                        'menu_text' => __('Menu 2', 'happy-addons-pro'),
                        'dot_tooltip' => __('Tooltip 2', 'happy-addons-pro'),
                        'anchor' => __('section-2', 'happy-addons-pro'),
                    ],
                    [
                        'left_section_type' => 'editor',
                        'right_section_type' => 'editor',
                        'menu_text' => __('Menu 3', 'happy-addons-pro'),
                        'dot_tooltip' => __('Tooltip 3', 'happy-addons-pro'),
                        'anchor' => __('section-3', 'happy-addons-pro'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function __options_controls() {

        $this->start_controls_section(
            '_section_options',
            [
                'label' => __( 'Settings', 'happy-addons-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'left_sec_width',
			[
				'label' => __( 'Left Section Width %', 'happy-addons-pro' ),
				'description' => __( 'Right section width will automatically change based on the value on the Left section width.', 'happy-addons-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 50,
			]
		);

		$this->add_control(
			'nav_type',
            [
                'label'         => __('Navigation Type', 'happy-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'  => __('None', 'happy-addons-pro'),
                    'menus'  => __('Menus', 'happy-addons-pro'),
                    'dots'  => __('Dots', 'happy-addons-pro'),
                ],
                'default'       => 'dots',
            ]
        );

		$this->add_control(
			'menu_align',
			[
				'label' => __( 'Menu Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => 'left',
				'toggle' => false,
				'selectors_dictionary' => [
                    'left' => 'justify-content: flex-start;',
                    'center' => 'justify-content: center;',
                    'right' => 'justify-content: flex-end;',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha-multi-scroll-menu' => '{{VALUE}};',
                ],
				'render_type'  => 'ui', //ui template
				'condition' => [
					'nav_type' => 'menus'
				]
			]
		);

		$this->__dots_controls();

        $this->add_control(
            'loop_top',
            [
                'label'        => __( 'Loop Top', 'happy-addons-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'happy-addons-pro' ),
                'label_off'    => __( 'No', 'happy-addons-pro' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'loop_bottom',
            [
                'label'        => __( 'Loop Bottom', 'happy-addons-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'happy-addons-pro' ),
                'label_off'    => __( 'No', 'happy-addons-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

		$this->add_control(
			'scroll_speed',
			[
				'label' => __( 'Scroll Speed', 'happy-addons-pro' ),
				'description' => __( 'Default speed is 700, Speed in milliseconds for the scrolling transitions.', 'happy-addons-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 10,
				'default' => 700,
			]
		);

        $this->end_controls_section();
    }

    protected function __dots_controls() {

        $this->add_control(
            'tooltips_enable',
            [
                'label'        => __( 'Dots Tooltips Enable', 'happy-addons-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'happy-addons-pro' ),
                'label_off'    => __( 'No', 'happy-addons-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
				'condition' => [
					'nav_type' => 'dots'
				]
            ]
        );

		$this->add_control(
			'dots_hori_pos',
			[
				'label' => __('Dots Horizontal Position', 'happy-addons-pro'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'happy-addons-pro'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __('Right', 'happy-addons-pro'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'condition' => [
					'nav_type' => 'dots'
				]
			]
		);

		$this->add_control(
			'dots_verti_pos',
			[
				'label' => __('Dots Vertical Position', 'happy-addons-pro'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __('Top', 'happy-addons-pro'),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __('Middle', 'happy-addons-pro'),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __('Bottom', 'happy-addons-pro'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'toggle' => false,
				'condition' => [
					'nav_type' => 'dots'
				]
			]
		);
    }

    /**
     * Register widget style controls
     */
    protected function register_style_controls() {
		$this->__left_section_style_controls();
		$this->__right_section_style_controls();
		$this->__menu_style_controls();
		$this->__dots_style_controls();
    }

    protected function __left_section_style_controls() {

		$this->start_controls_section(
			'left_sec_style',
			[
				'label' => __( 'Left Section', 'happy-addons-pro' ),
				'tab'   => CONTROLS_MANAGER::TAB_STYLE,
			]
		);

		$this->add_control( // Different
			'left_sec_background',
			[
				'label'     => __( 'Background Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-left .ha-multi-scroll-left-section-text' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ms-left .ha-multi-scroll-empty-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'left_sec_text_color',
			[
				'label'     => __( 'Text Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-left-section-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ms-left .ha-multi-scroll-empty-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'left_sec_text_typo',
				'selector' => '{{WRAPPER}} .ha-multi-scroll-left-section-text, {{WRAPPER}} .ms-left .ha-multi-scroll-empty-text',
			]
		);

		$this->add_responsive_control( //Differnt
			'left_sec_text_vertical',
			[
				'label'     => __( 'Vertical Position', 'happy-addons-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'top'    => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon'  => 'eicon-arrow-up',
					],
					'middle' => [
						'title' => __( 'Middle', 'happy-addons-pro' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'happy-addons-pro' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'default'   => 'middle',
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-left-section-text .ms-tableCell' => 'vertical-align: {{VALUE}};',
					'{{WRAPPER}} .ms-left .ha-multi-scroll-empty-text .ms-tableCell' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'left_sec_text_padding',
			[
				'label'      => __( 'Padding', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-multi-scroll-left-section-text .ms-tableCell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ms-left .ha-multi-scroll-empty-text .ms-tableCell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

    protected function __right_section_style_controls() {

		$this->start_controls_section(
			'right_sec_style',
			[
				'label' => __( 'Right Section', 'happy-addons-pro' ),
				'tab'   => CONTROLS_MANAGER::TAB_STYLE,
			]
		);

		$this->add_control( // Different
			'right_sec_background',
			[
				'label'     => __( 'Background Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-right .ha-multi-scroll-right-section-text' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ms-right .ha-multi-scroll-empty-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'right_sec_text_color',
			[
				'label'     => __( 'Text Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-right-section-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ms-right .ha-multi-scroll-empty-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'right_sec_text_typo',
				'selector' => '{{WRAPPER}} .ha-multi-scroll-right-section-text, {{WRAPPER}} .ms-right .ha-multi-scroll-empty-text',
			]
		);

		$this->add_responsive_control( //Differnt
			'right_sec_text_vertical',
			[
				'label'     => __( 'Vertical Position', 'happy-addons-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'top'    => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon'  => 'eicon-arrow-up',
					],
					'middle' => [
						'title' => __( 'Middle', 'happy-addons-pro' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'happy-addons-pro' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'default'   => 'middle',
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-right-section-text .ms-tableCell' => 'vertical-align: {{VALUE}};',
					'{{WRAPPER}} .ms-right .ha-multi-scroll-empty-text .ms-tableCell' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'right_sec_text_padding',
			[
				'label'      => __( 'Padding', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-multi-scroll-right-section-text .ms-tableCell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ms-right .ha-multi-scroll-empty-text .ms-tableCell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

	protected function __menu_style_controls() {

		$this->start_controls_section(
			'_section_menu_style',
			[
				'label' => __( 'Menu', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_type' => 'menus',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_item_typography',
				'label'    => __( 'Typography', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-multi-scroll-menu li a',
			]
		);

		$this->add_responsive_control(
			'menu_item_margin',
			[
				'label'      => __( 'Margin', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-multi-scroll-menu li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_padding',
			[
				'label'      => __( 'Padding', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-multi-scroll-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'menu_item_border_normal',
				'label'       => __( 'Border', 'happy-addons-pro' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ha-multi-scroll-menu li a',
			]
		);

		$this->add_control(
			'menu_item_border_radius',
			[
				'label'      => __( 'Border Radius', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-multi-scroll-menu li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'menu_item_text_color_normal',
			[
				'label'     => __( 'Text Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-menu li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_item_bg_color_normal',
			[
				'label'     => __( 'Background Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ha-multi-scroll-menu li a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
			'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'menu_item_text_color_hover',
			[
			'label'     => __( 'Text Color', 'happy-addons-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .ha-multi-scroll-menu li a:hover' => 'color: {{VALUE}}',
				'{{WRAPPER}} .ha-multi-scroll-menu li.active a' => 'color: {{VALUE}}',
			],
			]
		);

		$this->add_control(
			'menu_item_bg_color_hover',
			[
			'label'     => __( 'Background Color', 'happy-addons-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .ha-multi-scroll-menu li a:hover' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .ha-multi-scroll-menu li.active a' => 'background-color: {{VALUE}}',
			],
			]
		);

		$this->add_control(
			'menu_item_border_color_hover',
			[
			'label'     => __( 'Border Color', 'happy-addons-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .ha-multi-scroll-menu li a:hover' => 'border-color: {{VALUE}}',
				'{{WRAPPER}} .ha-multi-scroll-menu li.active a' => 'border-color: {{VALUE}}',
			],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
    }

    protected function __dots_style_controls() {

		$this->start_controls_section(
			'_section_dots_style',
			[
				'label' => __( 'Dots', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_type' => 'dots'
				]
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label'      => __( 'Size', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 12,
					],
				],
				'default' => [
					'size' => 8,
					'unit' => 'px',
				],
				'selectors'  => [
					'#multiscroll-nav ul li a span' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'dots_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'#multiscroll-nav ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_border',
			[
				'label'      => __( 'Border Radius', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#multiscroll-nav ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'dots_bg_color',
			[
				'label' => __( 'Dots Background Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#multiscroll-nav ul' => 'background:{{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_dots_style' );
		$this->start_controls_tab(
			'tab_dots_normal',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'dots_normal_color',
			[
				'label' => __( 'Dots Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#multiscroll-nav ul li a span' => 'border:1px solid {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			[
				'label' => __( 'Active', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#multiscroll-nav ul li .active span' => 'background: {{VALUE}};border:1px solid {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'dots_tooltip_heading',
			[
				'label' => __( 'Tooltip', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'dots_tooltip_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'#multiscroll-nav ul li .multiscroll-tooltip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'dots_tooltip_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'#multiscroll-nav ul li .multiscroll-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'dots_tooltip_border',
			[
				'label'      => __( 'Border Radius', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#multiscroll-nav ul li .multiscroll-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dots_tooltip_typo',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'selector' => '#multiscroll-nav ul li .multiscroll-tooltip',
				'condition'   => [
					'tooltips_enable' => 'yes',
				]

			]
		);

		$this->add_control(
			'dots_tooltip_color',
			[
				'label' => __( 'Tooltip Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#multiscroll-nav ul li .multiscroll-tooltip' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

		$this->add_control(
			'dots_tooltip_bg_color',
			[
				'label' => __( 'Tooltip Background', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#multiscroll-nav ul li .multiscroll-tooltip' => 'background: {{VALUE}}',
				],
				'condition'   => [
					'tooltips_enable' => 'yes',
				]
			]
		);

        $this->end_controls_section();

    }

	public function make_slug($string) {
		// Remove HTML tags
		$string = strip_tags($string);

		// Convert HTML entities to their corresponding characters
		$string = html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');

		// Convert to lowercase
		$string = strtolower($string);

		// Replace non-alphanumeric characters (including spaces) with dashes
		$string = preg_replace('/[^a-z0-9]+/i', '-', $string);

		// Trim dashes from beginning and end
		$string = trim($string, '-');

		return $string;
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();

		$templates = $settings['multi_scroll_sections'];

		$menu_txt = [];
		$anchors = [];
		$tooltips = [];
		$section_colors = [];
		$left_width = '50';
		$right_width = '50';
		$num = 1;
		$rand_id = rand( 10,100 );

		foreach( $templates as $index => $section ) {
			$menu_txt[] = isset( $section['menu_text'] ) && !empty( $section['menu_text'] ) ? esc_attr( $section['menu_text'] ) : esc_html( "Menu $num" );
			$tooltips[] = isset( $section['dot_tooltip'] ) && !empty( $section['dot_tooltip'] ) ? esc_attr( $section['dot_tooltip'] ) : esc_html( "Tooltip $num" );

			$anchor = isset( $section['anchor'] ) && !empty( $section['anchor'] ) ? strtolower( str_replace(' ','-', esc_attr( $this->make_slug( $section['anchor'] ) ) ) ) : esc_html( "anchor-$num" );
			if ( 'menus' == $settings['nav_type'] ) {
				$anchor = isset( $section['menu_text'] ) && ! empty( $section['menu_text'] ) ? strtolower( str_replace(' ','-', esc_attr( $this->make_slug( $section['menu_text'] ) ) ) ) : $anchor;
			}
			$anchors[] = in_array($anchor, $anchors) ? ( $anchor .'-'. $rand_id ) : $anchor;

			$num++;
		}

		if ( isset( $settings['left_sec_width'] )  && ! empty( $settings['left_sec_width'] ) ) {
			$left_width = ( 100 >= $settings['left_sec_width'] || 0 <= $settings['left_sec_width'] ) ? $settings['left_sec_width'] : '50';
			$right_width = 100 - ( float ) $left_width;
		}

		$multiscroll_settings = [
			'widget_id'            => esc_html( $widget_id ),
			'scrollingSpeed' => !empty( $settings["scroll_speed"] ) ? esc_html( $settings["scroll_speed"] ) : 700,
			'loopTop'          => 'yes' == $settings['loop_top']? true : false,
			'loopBottom'          => 'yes' == $settings['loop_bottom']? true : false,

			'sectionsColor'          => '',
			'dots'          => 'dots' == $settings['nav_type'] ? true : false,
			'dotsTooltips'      => 'yes' == $settings['tooltips_enable'] ? $tooltips  : [],
			'dotsPosition'       => !empty( $settings['dots_hori_pos'] ) ? esc_html( $settings['dots_hori_pos'] ) : '',
			'dotsVertical'       => !empty( $settings['dots_verti_pos'] ) ? esc_html( $settings['dots_verti_pos'] ) : '',
			'menu'          => 'menus' == $settings['nav_type'] ? esc_html( '#ha-multi-scroll-menu-' . $widget_id ) : false,

            'anchors'          => ! empty( $anchors ) ? $anchors : [],
            'leftWidth'          => $left_width,
            'rightWidth'          => $right_width,
        ];

		$multiscroll_settings = wp_json_encode( $multiscroll_settings );

		$this->add_render_attribute('main_wrap', 'class', ['ha-multi-scroll-wrap'] );
		$this->add_render_attribute('main_wrap', 'data-settings', htmlspecialchars( $multiscroll_settings, ENT_QUOTES, 'UTF-8') );

		$this->add_render_attribute('main_wrap_inner', [
			'class' => [
				'ha-multi-scroll-inner',
				'ha-multi-scroll-inner-' . esc_attr( $widget_id ),
			],
			'id' => 'multiscroll'
		]);

		$this->add_render_attribute('left_section_list', 'class', [
			'ha-multi-scroll-section',
			'ha-multi-scroll-left-section',
			'ha-multi-scroll-section-' . esc_attr( $widget_id ),
		   'ms-section'
		] );

		$this->add_render_attribute( 'right_section_list', 'class', [
				'ha-multi-scroll-section',
				'ha-multi-scroll-right-section',
				'ha-multi-scroll-section-' . esc_attr( $widget_id ),
				'ms-section'
			]
		);

		$this->add_render_attribute( 'menu',
			[
				'id' => [ 'ha-multi-scroll-menu-' . esc_attr( $widget_id ) ],
				'class' => [ 'ha-multi-scroll-menu' ],
			]
		);

	?>

		<div <?php $this->print_render_attribute_string( 'main_wrap' ); ?>>

			<div <?php $this->print_render_attribute_string( 'main_wrap_inner' ); ?>>
				<div class="ha-multi-scroll-left ms-left">
					<?php foreach( $templates as $index => $section ) : ?>
						<?php if( 'temp' == $section[ 'left_section_type' ] && ! empty( $section['left_side_temp'] ) ): ?>
							<div <?php $this->print_render_attribute_string( 'left_section_list' ); ?> >
								<?php  echo ha_elementor()->frontend->get_builder_content_for_display( $section['left_side_temp'] ); ?>
							</div>
						<?php elseif( 'editor' == $section['left_section_type'] && ! empty( $section['left_section_text'] ) ): ?>
							<div class="ms-section ha-multi-scroll-left-section-text elementor-repeater-item-<?php echo esc_attr($section['_id']);?>">
								<?php $this->print_text_editor( $section['left_section_text'] ); ?>
							</div>
						<?php else: ?>
							<div class="ms-section ha-multi-scroll-empty-text">
								<?php $this->print_text_editor( __( 'Please set the content.', 'happy-addons-pro' ) ); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<div class="ha-multi-scroll-right ms-right">
					<?php foreach ( $templates as $index => $section ) : ?>
						<?php if( 'temp' == $section['right_section_type'] && ! empty( $section['right_side_temp']) ): ?>
							<div <?php $this->print_render_attribute_string( 'right_section_list' ); ?>>
								<?php echo ha_elementor()->frontend->get_builder_content_for_display( $section['right_side_temp'] ); ?>
							</div>
						<?php elseif( 'editor' == $section['right_section_type'] && ! empty( $section['right_section_text'] ) ): ?>
							<div class="ms-section ha-multi-scroll-right-section-text elementor-repeater-item-<?php echo esc_attr($section['_id']);?>">
								<?php $this->print_text_editor( $section['right_section_text'] ); ?>
							</div>
						<?php else: ?>
							<div class="ms-section ha-multi-scroll-empty-text">
								<?php $this->print_text_editor( __( 'Please set the content.', 'happy-addons-pro' ) ); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<div class="ha-multi-scroll-mobile">
					<?php foreach( $templates as $index => $section ) : ?>
						<?php if( 'temp' == $section[ 'left_section_type' ] && ! empty( $section['left_side_temp'] ) ): ?>
							<div <?php $this->print_render_attribute_string( 'left_section_list' ); ?> >
								<?php  echo ha_elementor()->frontend->get_builder_content_for_display( $section['left_side_temp'] ); ?>
							</div>
						<?php elseif( 'editor' == $section['left_section_type'] && ! empty( $section['left_section_text'] ) ): ?>
							<div class="ms-section ha-multi-scroll-left-section-text elementor-repeater-item-<?php echo esc_attr($section['_id']);?>">
								<?php $this->print_text_editor( $section['left_section_text'] ); ?>
							</div>
						<?php else: ?>
							<div class="ms-section ha-multi-scroll-empty-text">
								<?php $this->print_text_editor( __( 'Please set the content.', 'happy-addons-pro' ) ); ?>
							</div>
						<?php endif; ?>
						<?php if( 'temp' == $section['right_section_type'] && ! empty( $section['right_side_temp']) ): ?>
							<div <?php $this->print_render_attribute_string( 'right_section_list' ); ?>>
								<?php echo ha_elementor()->frontend->get_builder_content_for_display( $section['right_side_temp'] ); ?>
							</div>
						<?php elseif( 'editor' == $section['right_section_type'] && ! empty( $section['right_section_text'] ) ): ?>
							<div class="ms-section ha-multi-scroll-right-section-text elementor-repeater-item-<?php echo esc_attr($section['_id']);?>">
								<?php $this->print_text_editor( $section['right_section_text'] ); ?>
							</div>
						<?php else: ?>
							<div class="ms-section ha-multi-scroll-empty-text">
								<?php $this->print_text_editor( __( 'Please set the content.', 'happy-addons-pro' ) ); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( 'menus' == $settings['nav_type'] ):?>
				<ul <?php $this->print_render_attribute_string( 'menu' ); ?>>
					<?php
						foreach ( $menu_txt as $index => $value ) {
							echo "<li data-menuanchor='" . esc_attr( $anchors[ $index ] ) . "'><a href='#" . esc_attr( $anchors[ $index ] ) ."'>" . esc_html( $value ) . "</a></li>";
						}
					?>
				</ul>
			<?php endif; ?>

		</div>
	<?php
	}

}

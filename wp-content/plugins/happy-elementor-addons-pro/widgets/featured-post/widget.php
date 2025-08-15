<?php
/**
 * Post Grid widget class
 *
 * @package Happy_Addons
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

use Happy_Addons_Pro\Traits\Lazy_Query_Builder;
use Happy_Addons_Pro\Traits\Featured_Post_Markup;
use WP_Query;

defined( 'ABSPATH' ) || die();

class Featured_Post extends Base {

	use Lazy_Query_Builder;
	use Featured_Post_Markup;

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Featured Post ', 'happy-addons-pro' );
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
		return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/featured-post/';
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
		return 'hm hm-tb-post-info';
	}

	public function get_keywords() {
		return ['post', 'posts', 'portfolio', 'grid', 'tiles', 'query', 'blog', 'ha-skin'];
	}


	/**
	 * Register content related controls
	 */
	protected function register_content_controls() {

		//Layout
		$this->layout_content_tab_controls();
		//Query content
		$this->query_content_tab_controls();

    }

	/**
	 * Layout content controls
	 */
	protected function layout_content_tab_controls( ) {

		$this->start_controls_section(
			'_section_layout',
			[
				'label' => __( 'Layout', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'skin',
			[
				'label' => __( 'Skin', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'classic' => __( 'Classic', 'happy-addons-pro' ),
					'standard' => __( 'Standard', 'happy-addons-pro' ),
					'outbox' => __( 'Outbox', 'happy-addons-pro' ),
				],
				'default' => 'classic',
			]
		);

		$this->featured_image_controls();

		$this->badge_controls();

		$this->add_control(
			'before_title_badge',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Custom badge', 'happy-addons-pro' ),
				'default' => 'New',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'happy-addons-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'happy-addons-pro' ),
				'label_off' => __( 'Hide', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1' => __( 'H1', 'happy-addons-pro' ),
					'h2' => __( 'H2', 'happy-addons-pro' ),
					'h3' => __( 'H3', 'happy-addons-pro' ),
					'h4' => __( 'H4', 'happy-addons-pro' ),
					'h5' => __( 'H5', 'happy-addons-pro' ),
					'h6' => __( 'H6', 'happy-addons-pro' ),
					'div' => __( 'DIV', 'happy-addons-pro' ),
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->meta_controls();

		$this->add_control(
			'excerpt_length',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Excerpt Length', 'happy-addons-pro' ),
				'description' => __( 'Leave it blank to hide it.', 'happy-addons-pro' ),
				'separator'   => 'before',
				'min'         => 0,
				'max'         => 100,
				'default'     => 15,
			]
		);


		$this->add_control(
			'show_vertically_center',
			[
				'label' => __( 'Vertically Center', 'happy-addons-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'happy-addons-pro' ),
				'label_off' => __( 'No', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);





		$this->readmore_controls();

		$this->end_controls_section();
	}

	/**
	 * Featured Image Control
	 */
	protected function featured_image_controls() {

		$this->add_control(
			'featured_image',
			[
				'label' => __( 'Featured Image', 'happy-addons-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'happy-addons-pro' ),
				'label_off' => __( 'Hide', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'featured_image',
				'exclude' => [
					'custom',"large",'1536x1536','2048x2048','tp-image-grid','full'
				],
				'default' => 'medium_large',
				'condition' => [
					'featured_image' => 'yes',
				]
			]
		);

	}

	/**
	 * Badge Control
	 */
	protected function badge_controls() {

		$this->add_control(
			'show_badge',
			[
				'label' => __( 'Badge', 'happy-addons-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'happy-addons-pro' ),
				'label_off' => __( 'Hide', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'featured_image' => 'yes',
				]
			]
		);

		$this->add_control(
			'taxonomy_badge',
			[
				'label' => __( 'Badge Taxonomy', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'category',
				'options' => ha_pro_get_taxonomies(),
				'condition' => [
					'featured_image' => 'yes',
					'show_badge' => 'yes',
				],
			]
		);

	}

	/**
	 * Meta Control
	 */
	protected function meta_controls() {

		$this->add_control(
			'active_meta',
			[
				'type' => Controls_Manager::SELECT2,
				'label' => __( 'Active Meta', 'happy-addons-pro' ),
				'description' => __( 'Select to show and unselect to hide', 'happy-addons-pro' ),
				'label_block' => true,
				'separator' => 'before',
				'multiple' => true,
				'default' => ['author', 'date'],
				'options' => [
					'author' => __( 'Author', 'happy-addons-pro' ),
					'date' => __( 'Date', 'happy-addons-pro' ),
					'comments' => __( 'Comments', 'happy-addons-pro' ),
				]
			]
		);

		$this->add_control(
			'meta_has_icon',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( 'Enable Icon', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'active_meta!' => [],
				],
			]
		);

		$this->add_control(
			'meta_separator',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Separator', 'happy-addons-pro' ),
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li + li:before' => 'content: "{{VALUE}}"',
				],
				'condition' => [
					// $this->get_control_id( 'active_meta!' ) => []
					'active_meta!' => []
				],
			]
		);

		$this->add_control(
			'meta_position',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __( 'Position', 'happy-addons-pro' ),
				'label_block' => false,
				'multiple' => true,
				'default' => 'after',
				'options' => [
					'before' => __( 'Before Title', 'happy-addons-pro' ),
					'after' => __( 'After Title', 'happy-addons-pro' ),
				],
				'condition' => [
					'skin' => 'standard',
					'active_meta!' => []
				],
			]
		);

	}



	/**
	 * Readmore Control
	 */
	protected function readmore_controls() {
		$this->add_control(
			'read_more',
			[
				'type' => Controls_Manager::TEXT,
				'label' => __( 'Read More', 'happy-addons-pro' ),
				'placeholder' => __( 'Read More Text', 'happy-addons-pro' ),
				'description' => __( 'Leave it blank to hide it.', 'happy-addons-pro' ),
				'default' => __( 'Continue Reading »', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'read_more_new_tab',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( 'Open in new window', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


	}

	/**
	 * Query content controls
	 */
	protected function query_content_tab_controls( ) {

		//Query
		$this->start_controls_section(
			'_section_query',
			[
				'label' => __( 'Query', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_query_controls_for_post_feature();

		$this->add_control(
			'query_id',
			[
				'label'   => __( 'Query ID', 'happy-addons-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [ 'active' => true ],
				'description' => __( 'Give your Query a custom unique id to allow server side filtering.', 'happy-addons-pro' ),
			]
		);

		$this->end_controls_section();

	}


	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {

		//Box Style Start
		$this->box_style_tab_controls();

		//Feature Image Style Start
		$this->image_style_tab_controls();

		//Badge Taxonomy Style Start
		$this->taxonomy_badge_style_tab_controls();

		//Content Style Start
		$this->content_style_tab_controls();

		//Meta Style Start
		$this->meta_style_tab_controls();

		//Readmore Style Start
		$this->readmore_style_tab_controls();

	}


	/**
	 * Layout Style controls
	 */
	protected function layout_style_tab_controls() {

		$this->start_controls_section(
			'_section_layout_style',
			[
				'label' => __( 'Layout', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-grid-wrap' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-grid-wrap' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
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
					],
                ],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
    }

	/**
	 * Box Style controls
	 */
	protected function box_style_tab_controls() {

		$this->start_controls_section(
			'_section_item_box_style',
			[
				'label' => __( 'Item Box', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_box_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_box_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw:after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_box_shadow',
				'label' => __( 'Box Shadow', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-pf-item-pw:after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_box_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-pf-item-pw:after',
			]
		);

		$this->add_responsive_control(
			'item_box_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'item_box_opacity',
			[
				'label'     => __( 'Opacity', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw:after' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_box_width',
			[
				'label' => __( 'Width', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Image Style controls
	 */
	protected function image_style_tab_controls() {

		$this->start_controls_section(
			'_section_image_style',
			[
				'label' => __( 'Image', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'featured_image' => 'yes',
				],
			]
		);

		$this->all_style_of_feature_image();

		$this->end_controls_section();
	}

	/**
	 * All Image Style
	 */
	protected function all_style_of_feature_image() {

		$this->image_overlay_style();

		$this->image_position_style();

		$this->image_height_margin_style();

		$this->image_boxshadow_style();

		$this->image_border_styles();

		$this->image_border_radius_styles();

		$this->image_css_filter_styles();
	}

	/**
	 * Image Overlay Style
	 */
	protected function image_overlay_style() {

		//Feature Post Image overlay color
		$this->add_control(
			'feature_image_overlay_heading',
			[
				'label' => __( 'Image Overlay', 'happy-addons-pro' ),
				'description' => __( 'This overlay color only apply when post has an image.', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'feature_image_overlay',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'description' => __( 'This overlay color only apply when post has an image.', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [
					'image'
				],
				'selector' => '{{WRAPPER}} .ha-pf-thumb:before',
			]
		);

		$this->add_control(
			'feature_image_heading',
			[
				'label' => __( 'Image', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

	}

	/**
	 * Image Height & margin Style
	 */
	protected function image_height_margin_style() {

		$this->add_responsive_control(
			'feature_image_height',
			[
				'label' => __( 'Height', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-thumbnail .ha-pf-thumb' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'feature_image_width',
			[
				'label' => __( 'Width', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-thumbnail .ha-pf-thumb' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'feature_image_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'happy-addons-pro' ),
				'description' => __( 'This margin only apply when Hight is Off.', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'feature_image_margin_left',
			[
				'label' => __( 'Margin Left', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-thumbnail' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'skin' => ['classic','outbox'],
				],

			]
		);

	}

	/**
	 * Image boxshadow Style
	 */
	protected function image_boxshadow_style() {

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'feature_image_shadow',
				'label' => __( 'Box Shadow', 'happy-addons-pro' ),
				'selector' => '

					{{WRAPPER}} .ha-pf-hawai .ha-pf-thumbnail ,
					{{WRAPPER}} .ha-pf-standard .ha-pf-thumbnail,
					{{WRAPPER}} .ha-pf-monastic .ha-pf-thumbnail ,
					{{WRAPPER}} .ha-pf-classic .ha-pf-thumbnail ,
					{{WRAPPER}} .ha-pf-outbox .ha-pf-thumbnail ,
					{{WRAPPER}} .ha-pf-crossroad .ha-pf-thumbnail
				',
			]
		);
	}

	/**
	 * Image border Style
	 */
	protected function image_border_styles() {

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'feature_image_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'selector' => '
					{{WRAPPER}} .ha-pf-hawai .ha-pf-thumbnail img ,
					{{WRAPPER}} .ha-pf-standard .ha-pf-thumbnail img,
					{{WRAPPER}} .ha-pf-monastic .ha-pf-thumbnail img ,
					{{WRAPPER}} .ha-pf-classic .ha-pf-thumbnail img,
					{{WRAPPER}} .ha-pf-outbox .ha-pf-thumbnail img,
					{{WRAPPER}} .ha-pf-crossroad .ha-pf-thumbnail img
				',
			]
		);

	}

	/**
	 * Image border radius Style
	 */
	protected function image_border_radius_styles() {

		$this->add_responsive_control(
			'feature_image_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [

					'{{WRAPPER}} .ha-pf-hawai .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-standard .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-monastic .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-classic .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-outbox .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-crossroad .ha-pf-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

	}

	/**
	 * Image css filter Style
	 */
	protected function image_css_filter_styles() {

		$this->start_controls_tabs( 'feature_image_tabs',
			[
			]
	    );
		$this->start_controls_tab(
			'feature_image_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'feature_image_css_filters',
                'selector' => '{{WRAPPER}} .ha-pf-thumbnail .ha-pf-thumb img',
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'feature_image_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'feature_image_hover_css_filters',
                'selector' => '{{WRAPPER}} .ha-pf-thumbnail .ha-pf-thumb:hover img',
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();

	}

	/**
	 * Taxonomy Badge Style controls
	 */
	protected function taxonomy_badge_style_tab_controls() {

		$this->start_controls_section(
			'_section_taxonomy_badge_style',
			[
				'label' => __( 'Badge', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->taxonomy_badge_position();

		$this->add_responsive_control(
			'badge_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'badge_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'exclude' => [
					'color'
				],
				'selector' => '{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a',
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a',
			]
		);

		$this->start_controls_tabs( 'badge_tabs');
		$this->start_controls_tab(
			'badge_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'badge_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [
					'image'
				],
				'selector' => '{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a',
				'selectors' => [
                    '{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a' => 'background-color: {{VALUE}};background-image: unset;',
                ],
			]
		);

		$this->add_control(
			'badge_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'badge_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'badge_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'badge_hover_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [
					'image'
				],
				'selector' => '{{WRAPPER}} .ha-pf-item-pw .ha_thumbnail_badge a:hover',
			]
		);

		$this->add_control(
			'badge_hover_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha_thumbnail_badge a:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Taxonomy badge Position
	 */
	protected function taxonomy_badge_position() {

        $this->add_control(
			'badge_position_toggle',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'None', 'happy-addons-pro' ),
				'label_on' => __( 'Custom', 'happy-addons-pro' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'badge_position_x',
			[
				'label' => __( 'Position Left', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'condition' => [
					'badge_position_toggle' => 'yes',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha-pf-thumbnail .ha_thumbnail_badge' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_y',
			[
				'label' => __( 'Position Top', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'badge_position_toggle' => 'yes',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha-pf-thumbnail .ha_thumbnail_badge' => 'top: {{SIZE}}{{UNIT}};bottom:auto;',
				],
			]
		);
		$this->end_popover();

    }


	/**
	 *  Image Position
	 */
	protected function image_position_style() {

        $this->add_control(
			'image_position_toggle',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'None', 'happy-addons-pro' ),
				'label_on' => __( 'Custom', 'happy-addons-pro' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'image_position_x',
			[
				'label' => __( 'Position Left', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'condition' => [
					'image_position_toggle' => 'yes',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha-pf-thumbnail img' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_position_y',
			[
				'label' => __( 'Position Top', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'image_position_toggle' => 'yes',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-item-pw .ha-pf-thumbnail img' => 'top: {{SIZE}}{{UNIT}};bottom:auto;',
				],
			]
		);
		$this->end_popover();

    }

	/**
	 * Content Style controls
	 */
	protected function content_style_tab_controls() {

		$this->start_controls_section(
			'_section_content_style',
			[
				'label' => __( 'Content', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		//Content area
		$this->add_responsive_control(
			'content_area_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-content-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		//Custom Badge
		$this->add_control(
			'post_custom_badge_heading',
			[
				'label' => __( 'Custom Badge', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'before_title_badge!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'custom_badge_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-content-header .ha-pf-custom-badge' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: 0;',
				],
				'condition' => [
					'before_title_badge!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_badge_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-content-header .ha-pf-custom-badge',
				'condition' => [
					'before_title_badge!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'custom_badge_tabs',
			[
				'condition' => [
					'before_title_badge!' => '',
				],
			]
		);
		$this->start_controls_tab(
			'custom_badge_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'custom_badge_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-content-header .ha-pf-custom-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_badge_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'custom_badge_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-custom-badge:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		//Post Title
		$this->add_control(
			'post_title_heading',
			[
				'label' => __( 'Title', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'post_title_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-title' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: 0;',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_title_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-title a',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'post_title_tabs',
			[
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);
		$this->start_controls_tab(
			'post_title_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'post_title_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'post_title_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area  .ha-pf-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		//Feature Post Content
		$this->add_control(
			'post_post_content_heading',
			[
				'label' => __( 'Post Content', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);
		$this->add_control(
			'post_content_heading',
			[
				'label' => __( 'Content', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'excerpt_length!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'post_content_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-excerpt > p' => 'margin-bottom: 0;',
				],
				'condition' => [
					'excerpt_length!' => 0,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_content_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-excerpt',
				'condition' => [
					'excerpt_length!' => 0,
				],
			]
		);

		$this->add_control(
			'post_content_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-excerpt' => 'color: {{VALUE}}',
				],
				'condition' => [
					'excerpt_length!' => 0,
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Meta Style controls
	 */
	protected function meta_style_tab_controls() {

		$this->start_controls_section(
			'_section_meta_style',
			[
				'label' => __( 'Meta', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'active_meta!' => []
				],
			]
		);

		//Post Meta
		$this->add_control(
			'meta_heading',
			[
				'label' => __( 'Meta', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'meta_icon_space',
			[
				'label' => __( 'Icon Space', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => ["15px"],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_space',
			[
				'label' => __( 'Space Between', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' =>[ "15px"],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li:last-child' => 'margin-right: 0;',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li + li:before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' =>[ "15px"],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'meta_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-pf-meta-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a,{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span,{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li + li:before',
			]
		);

		$this->start_controls_tabs( 'meta_tabs');
		$this->start_controls_tab(
			'meta_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8c8c8c', // Set default color (Orange)
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li:before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'meta_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'meta_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a:hover i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li a:hover path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span:hover i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li span:hover path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'meta_separator_color',
			[
				'label' => __( 'Separator Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .ha-pf-wrapper .ha-pf-item-pw .ha-pf-content-area .ha-pf-content-header .ha-pf-meta-wrap ul li + li:before' => 'color: {{VALUE}}',
				],
				'condition' => [
					'meta_separator!' => '',
				],
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Added Read More Style controls
	 */
	protected function readmore_style_tab_controls() {

		$this->start_controls_section(
			'_section_readmore_style',
			[
				'label' => __( 'Read More', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'readmore_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'readmore_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'exclude' => [
					'color',
				],
				'selector' => '{{WRAPPER}} .ha-pf-readmore a',
			]
		);

		$this->add_responsive_control(
			'readmore_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'readmore_typography',
				'label' => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .ha-pf-readmore a',
			]
		);

		$this->start_controls_tabs( 'readmore_tabs');

		$this->start_controls_tab(
			'readmore_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a' => 'color: {{VALUE}}',
				],
				'default' => '#1888f5', // Set default color (Orange)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'readmore_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [
					'image'
				],
				'selector' => '{{WRAPPER}} .ha-pf-readmore a',
			]
		);

		$this->add_control(
			'readmore_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'readmore_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'readmore_hover_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [
					'image'
				],
				'selector' => '{{WRAPPER}} .ha-pf-readmore a:hover',
			]
		);

		$this->add_control(
			'readmore_border_hover_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pf-readmore a:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Get Query
	 *
	 * @param array $args
	 * @return void
	 */
	public function get_query( $args = array() ) {

		$default = $this->get_post_query_args();
		$args = array_merge( $default, $args );

		$this->query = new WP_Query( $args );
		return $this->query;
	}

	/**
	 * Get post query arguments
	 *
	 * @return function
	 */
	public function get_post_query_args() {

		return $this->get_query_args();
	}

	/**
	 * Get current page number
	 *
	 * @return init
	 */
	public function get_current_page() {
		if ( '' === $this->get_settings_for_display( 'pagination_type' ) ) {
			return 1;
		}

		return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
	}

	/**
	 * Get page number link
	 *
	 * @param [init] $i
	 * @return string
	 */
	private function get_wp_link_page( $i ) {
		if ( ! is_singular() || is_front_page() ) {
			return get_pagenum_link( $i );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post = get_post();
		$query_args = [];
		$url = get_permalink();

		if ( $i > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( 'page'.$i, 'single_paged' ); // Change Occurs For Fixing Pagination Issue.
			}
		}

		if ( is_preview() ) {
			if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
				$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}

	/**
	 * Get post navigation link
	 *
	 * @param [init] $page_limit
	 * @return string
	 */
	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			// return;
			$page_limit = $this->query->max_num_pages; // Change Occurs For Fixing Pagination Issue.
		}
		$return = [];
		$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
		$link_template = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}
			$return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), $this->get_settings_for_display( 'pagination_prev_label' ) );
		}
		$next_page = intval( $paged ) + 1;
		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings_for_display( 'pagination_next_label' ) );
		}
		return $return;
	}

	/**
	 * Load more render
	 *
	 * @param [array] $query_settings
	 * @return void
	 */
	public function load_more_render( $query_settings ) {
		$settings = $this->get_settings_for_display();
		if ( empty($settings['loadmore']) || empty($settings['loadmore_text']) ) {
			return;
		}
		?>
		<div class="ha-pf-loadmore-wrap">
			<button class="ha-pf-loadmore" data-settings="<?php echo esc_attr($query_settings);?>">
				<?php echo esc_html($settings['loadmore_text']);?>
				<i class="eicon-loading eicon-animation-spin"></i>
			</button>
		</div>
		<?php
	}

	/**
	 * Render content
	 */
	public function render() {

		$settings = $this->get_settings_for_display();

		// return;
		$this->add_render_attribute(
			'grid-wrapper',
			'class',
			[
				'ha-pf-wrapper',
				'ha-pf-default',
				'ha-pf-'. $settings['skin'],
			]
		);
		$args = $this->get_post_query_args();

		$args['posts_per_page'] = 1;
		//define ha post grid custom query filter hook
		if ( !empty( $settings['query_id'] ) ) {
			$args = apply_filters( "happyaddons/post-grid/{$settings['query_id']}", $args );
		}
		$_query = new WP_Query( $args );
		$query_settings = $this->query_settings( $settings, $args );

		?>
		<?php if ( $_query->have_posts() ) : ?>
				<div <?php $this->print_render_attribute_string( 'grid-wrapper' ); ?>>

					<?php while ( $_query->have_posts() ) : $_query->the_post(); ?>

						<?php $this->render_markup( $settings, $_query );?>

					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
				<?php else: ?>
					<?php printf('<div class="ha-product-carousel-error">%s</div>', __('No posts found. Please Add Post.', 'happy-addons-pro')); ?>

			<?php endif;?>
		<?php
	}

	public function render_markup( $settings, $_query ) {
		//$this->{'new_render_' . $settings['skin'] . '_markup'}( $settings, $_query );
		$this->{'new_render_common_markup'}( $settings, $_query );
	}

	public function query_settings( $settings, $args ) {
		$query_settings = [
			'args'                => $args,
			// '_skin'            => $this->get_id(),
			'skin'                => $settings['skin'],
			'posts_post_type'     => $settings['posts_post_type'],
			'featured_image'      => $settings['featured_image'],
			'featured_image_size' => $settings['featured_image_size'],
			'show_badge'          => $settings['show_badge'],
			'show_title'          => $settings['show_title'],
			'title_tag'           => $settings['title_tag'],
			'active_meta'         => $settings['active_meta'],
			'excerpt_length'      => $settings['excerpt_length'],
		];
		if( !empty($settings['active_meta']) ){
			$query_settings ['meta_has_icon'] = $settings['meta_has_icon'];
		}
		if( !empty($settings['show_badge'] ) ){
			$query_settings ['taxonomy_badge'] = $settings['taxonomy_badge'];
		}
		$query_settings ['read_more'] = $settings['read_more'];
		$query_settings ['read_more_new_tab'] = $settings['read_more_new_tab'];
		$query_settings = json_encode( $query_settings, true );
		return $query_settings;
	}

}

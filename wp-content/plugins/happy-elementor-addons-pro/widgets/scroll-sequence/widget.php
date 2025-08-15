<?php
/**
 * Scroll Sequence
 *
 * @package Happy_Addons_Pro
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class Scroll_Sequence extends Base {

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __('Scroll Sequence', 'happy-addons-pro');
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
		return 'hm hm-magic-scroll';
	}

	public function get_keywords() {
		return ['scroll-sequence','sequence', 'sequencer'];
	}

	public function get_custom_help_url() {
		return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/scroll-sequence/';
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	public function is_reload_preview_required() {
		return true;
	}

	/**
     * Register widget content controls
     */
	protected function register_content_controls() {
		$this->__scroll_sequence_content_controls();
	}

	protected function __scroll_sequence_content_controls() {

		$this->start_controls_section(
			'scroll_sequence_content',
			[
				'label' => __( 'Scroll Sequence', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'apply_to',
			[
				'label'   => __( 'Apply To', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'container',
				'options' => [
					'body'           => __( 'Body', 'happy-addons-pro' ),
					'container'        => __( 'Container', 'happy-addons-pro' ),
					'section'        => __( 'Section', 'happy-addons-pro' ),
					'column' => __( 'Column', 'happy-addons-pro' ),
				],
			]
		);

		$this->add_control(
			'apply_to_body',
			[
				'label' => esc_html__( 'Apply To Body', 'happy-addons-pro' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'body',
				'condition' => [
					'apply_to' => 'body',
				],
				'selectors'   => [
					'body' => 'position: relative;',
				],
			]
		);

		$this->add_control(
			'image_source',
			[
				'label'   => __( 'Image Source', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'server',
				'options' => [
					'gallery' => __( 'Gallery', 'happy-addons-pro' ),
					'server'  => __( 'Remote Server', 'happy-addons-pro' ),
				],
			]
		);

		$this->add_control(
			'image_type',
			[
				'label'     => __( 'Image Type', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'jpg',
				'options'   => [
					'jpg'  => __( 'JPG', 'happy-addons-pro' ),
					'png'  => __( 'PNG', 'happy-addons-pro' ),
					'webp' => __( 'WebP', 'happy-addons-pro' ),
				],
				'condition' => [
					'image_source' => 'server',
				],
			]
		);

		$this->add_control(
			'total_image',
			[
				'label'     => __( 'Total Image', 'happy-addons-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 5000,
				'step'      => 1,
				'default'   => 20,
				'condition' => [
					'image_source' => 'server',
				],
			]
		);

		$this->add_control(
			'image_gallery',
			[
				'label'     => __( 'Image Upload', 'happy-addons-pro' ),
				'type'      => Controls_Manager::GALLERY,
				'default'   => [],
				'condition' => [
					'image_source' => 'gallery',
				],
			]
		);

		$this->add_control(
			'folder_path',
			[
				'label'     => __( 'Folder Path', 'happy-addons-pro' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'image_source' => 'server',
				],
			]
		);

		$this->add_control(
			'image_name_prefix',
			[
				'label'       => __( 'Image Name Prefix', 'happy-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Image Name Prefix', 'happy-addons-pro' ),
				'condition'   => [
					'image_source' => 'server',
				],
			]
		);

		$this->add_control(
			'number_format',
			[
				'label'     => __( 'Number Format', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => __( '1-9', 'happy-addons-pro' ),
					'2' => __( '01-99', 'happy-addons-pro' ),
					'3' => __( '001-999', 'happy-addons-pro' ),
					'4' => __( '0001-9999', 'happy-addons-pro' ),
				],
				'condition' => [
					'image_source' => 'server',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
     * Register widget style controls
     */
	protected function register_style_controls() {
		$this->__scroll_sequence_style_controls();
	}

	protected function __scroll_sequence_style_controls() {

		$this->start_controls_section(
			'scroll_sequence_section_style',
			[
				'label' => __( 'Scroll Sequence', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'canvas_width',
			[
				'type'        => Controls_Manager::SLIDER,
				'label'       => __( 'Width', 'happy-addons-pro' ),
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 2,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => '',
				],
				'render_type' => 'ui',
				'selectors'   => [
					'.ha-scroll-sequence-canvas--{{ID}} .ha-scroll-sequence-canvas-wrap-inner' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'canvas_height',
			[
				'type'        => Controls_Manager::SLIDER,
				'label'       => __( 'Height', 'happy-addons-pro' ),
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 2,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => '',
				],
				'render_type' => 'ui',
				'selectors'   => [
					'.ha-scroll-sequence-canvas--{{ID}} .ha-scroll-sequence-canvas-wrap-inner' => 'height: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_responsive_control(
			'top_position',
			[
				'label'       => __( 'Top Position (%)', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'range'       => [
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => '%',
					'size' => '',
				],
				'render_type' => 'ui',
				'selectors'   => [
					'.ha-scroll-sequence-canvas--{{ID}} .ha-scroll-sequence-canvas-wrap-inner' => 'top: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'left_position',
			[
				'label'       => __( 'Left Position (%)', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'range'       => [
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => '%',
					'size' => '',
				],
				'render_type' => 'ui',
				'selectors'   => [
					'.ha-scroll-sequence-canvas--{{ID}} .ha-scroll-sequence-canvas-wrap-inner' => 'left: {{SIZE}}%;',
				],
			]
		);

		$this->add_control(
			'canvas_z_index',
			[
				'label'     => __( 'Z-Index', 'happy-addons-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -10,
				'max'       => 10,
				'step'      => 1,
				'default'   => 0,
				'selectors' => [
					'.ha-scroll-sequence-canvas--{{ID}} .ha-scroll-sequence-canvas-wrap-inner' => 'z-index: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		$images = '';
		$images_count = 0;

		if( 'gallery' == $settings['image_source'] && ! empty( $settings['image_gallery'] ) && is_array( $settings['image_gallery'] ) ) {
			$images = array_column( $settings['image_gallery'], 'url' );
			$images_count = count( $images );
		}

		if( 'server' == $settings['image_source'] && ! empty( $settings['folder_path']['url'] ) ) {
			$images = esc_url( $settings['folder_path']['url'] );
		}

		$sequence_settings = [
			'widget_id'            => esc_html( $widget_id ),
			'apply_to'     => esc_attr( $settings['apply_to'] ),
			'image_source'  => esc_attr( $settings['image_source'] ),
			'images'  => $images,
			'name_prefix'  => ( 'server' == $settings['image_source'] ) ? esc_attr( $settings['image_name_prefix'] ) : '',
			'number_format'  => ( 'server' == $settings['image_source'] ) ? esc_attr( $settings['number_format'] ) : 1,
			'image_type'  => ( 'server' == $settings['image_source'] ) ? esc_attr( $settings['image_type'] ) : 'jpg',
			'total_image'  => ( 'server' == $settings['image_source'] ) ? esc_attr( $settings['total_image'] ) : $images_count,
		];

		$sequence_settings = wp_json_encode( $sequence_settings );
		$this->add_render_attribute( 'sequence-wrap', 'class', 'ha-scroll-sequence-wrap' );
		$this->add_render_attribute( 'sequence-wrap', 'data-settings', htmlspecialchars( $sequence_settings, ENT_QUOTES, 'UTF-8') );
		$this->add_render_attribute( 'canvas-wrap', 'class', ['ha-scroll-sequence-canvas-wrap', 'ha-scroll-sequence-canvas--' . $widget_id ] );

		if ( ! $images ) {
			printf(
				'<div %s>%s</div>',
				'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #f5c848;color: #856404;background-color: #fff3cd;"',
				__('No Image Selected!.', 'happy-addons-pro')
			);
			return;
		}
		if ( ha_elementor()->editor->is_edit_mode() && $images ) {
			printf(
				'<div %s>%s</div>',
				'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #f5c848;color: #856404;background-color: #fff3cd;"',
				$this->get_title() . ' - ' . __('This is a placeholder text of the widget for editor mode.', 'happy-addons-pro')
			);
		}
		?>
		<div <?php $this->print_render_attribute_string('sequence-wrap'); ?>>
			<div <?php $this->print_render_attribute_string('canvas-wrap'); ?>><div class="ha-scroll-sequence-canvas-wrap-inner"></div></div>
		</div>
		<?php
	}
}

<?php
/**
 * Add image masking support to some specific widgets
 *
 * @package Happy_Addons_Pro
 */
namespace Happy_Addons_Pro\Extensions;

use Elementor\Widget_Base;
use Happy_Addons_Pro\Controls\Mask_Image;

defined('ABSPATH') || die();

class Image_Masking {

	/**
	 * @param Widget_Base $element
	 */
	public static function add_controls( Widget_Base $element ) {

		$args = self::widget_to_args_map( $element->get_name() );

		$element->start_injection( [
			'type' => 'control',
			'at' => $args['at'],
			'of' => $args['of'],
		] );

		$element->add_group_control(
			Mask_Image::get_type(),
			[
				'name' => 'image_masking',
				'selector' => '{{WRAPPER}} ' . $args['selector'],
				'condition' => $args['condition'],
			]
		);

		$element->end_injection();
	}

    /**
     * @param string $widget_name
     * @return mixed
     */
	public static function widget_to_args_map( $widget_name = '' ) {
		$ha_ele_image_selector = ha_elementor()->experiments->is_feature_active( 'e_optimized_markup' ) ? '{{WRAPPER}}.elementor-widget-image' : '.elementor-image, {{WRAPPER}} .elementor-widget-container';

		$map = [
			'image' => [
				'at' => 'after',
				'of' => 'image',
				// 'selector' => '.elementor-image', // remove after elementor 3.21 update
				'selector' => $ha_ele_image_selector,
				'condition' => []
			],
			'image-box' => [
				'at' => 'after',
				'of' => 'image',
				'selector' => '.elementor-image-box-img',
				'condition' => []
			],
			'ha-card' => [
				'at' => 'after',
				'of' => 'image',
				'selector' => '.ha-card-figure img',
				'condition' => []
			],
			'ha-infobox' => [
				'at' => 'after',
				'of' => 'image',
				'selector' => '.ha-infobox-figure.ha-infobox-figure--image',
				'condition' => [
					'type' => 'image'
				]
			],
			'ha-promo-box' => [
				'at' => 'after',
				'of' => 'image',
				'selector' => '.ha-promo-box-thumb',
				'condition' => []
			],
			'ha-member' => [
				'at' => 'before',
				'of' => 'thumbnail_size',
				'selector' => '.ha-member-figure',
				'condition' => []
			]
		];

		return $map[ $widget_name ];
	}
}

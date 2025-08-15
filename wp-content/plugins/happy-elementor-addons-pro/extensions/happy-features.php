<?php
namespace Happy_Addons_Pro\Extensions;

use Elementor\Controls_Manager;
use Happy_Addons_Pro\Extensions_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Happy_Features {
	public static function add_controls_sections( $element, $args ) {
		$element->start_controls_section(
			'_section_happy_pro_features',
			[
				'label' => __( 'Happy Features', 'happy-addons-pro' ) . ha_get_section_icon(),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);

		if ( hapro_is_display_condition_enabled() ) {
			Display_Conditions::instance()->add_controls( $element , $args );
		}

		$element->end_controls_section();
	}
}

<?php
namespace Happy_Addons_Pro\Classes;

defined( 'ABSPATH' ) || die();

use Happy_Addons_Pro\Extensions as Extensions;
class Extensions_Manager {

	public static function init() {
		if ( HAPPY_ADDONS_VERSION >= '3.18.1') {
			add_filter( 'happyaddons_get_pro_features_map',[ __CLASS__, 'set_features_map' ], 10, 1 );
		}
		self::hook_manager();
	}

	public static function hook_manager() {

		add_action( 'elementor/element/common/_section_style/after_section_end', [ Extensions\Happy_Features::class, 'add_controls_sections' ], 1, 2 );
		// Activate column for sections
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ Extensions\Happy_Features::class, 'add_controls_sections' ], 1, 2 );
		// Activate sections for sections
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ Extensions\Happy_Features::class, 'add_controls_sections' ], 1, 2 );

		add_action( 'elementor/element/container/section_layout/after_section_end', [ Extensions\Happy_Features::class, 'add_controls_sections' ], 1, 2 );

		if ( hapro_is_image_masking_enabled() ) {
			add_action( 'elementor/element/image/section_image/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
			add_action( 'elementor/element/image-box/section_image/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
			add_action( 'elementor/element/ha-card/_section_image/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
			add_action( 'elementor/element/ha-infobox/_section_media/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
			add_action( 'elementor/element/ha-promo-box/_section_title/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
			add_action( 'elementor/element/ha-member/_section_info/before_section_end', [ Extensions\Image_Masking::class, 'add_controls' ] );
		}

		if ( hapro_is_happy_particle_effects_enabled() ) {
			add_action( 'elementor/frontend/before_register_scripts', [ Extensions\Happy_Particle_Effects::class, 'register_scripts' ] );
			add_action( 'elementor/preview/enqueue_scripts', [Extensions\Happy_Particle_Effects::class, 'enqueue_preview_scripts'] );
			add_action( 'elementor/element/after_section_end', [ Extensions\Happy_Particle_Effects::class, 'register_controls' ], 10, 3 );

			add_action( 'elementor/column/print_template', [ Extensions\Happy_Particle_Effects::class, '_print_template' ], 10, 2 );
			add_action( 'elementor/section/print_template', [ Extensions\Happy_Particle_Effects::class, '_print_template' ], 10, 2 );
			add_action( 'elementor/container/print_template', [ Extensions\Happy_Particle_Effects::class, '_print_template' ], 10, 2 );

			add_action( 'elementor/frontend/column/before_render', [ Extensions\Happy_Particle_Effects::class, '_before_render' ], 10, 1 );
			add_action( 'elementor/frontend/section/before_render', [ Extensions\Happy_Particle_Effects::class, '_before_render' ], 10, 1 );
			add_action( 'elementor/frontend/container/before_render', [ Extensions\Happy_Particle_Effects::class, '_before_render' ], 10, 1 );
		}

		if ( hapro_is_happy_global_badge_enabled() ) {
			Extensions\Global_Badge::instance()->init();
		}

		if ( is_user_logged_in() && hapro_get_appsero()->license()->is_valid() && function_exists('ha_get_inactive_features') && !in_array('happy-preset', ha_get_inactive_features())) {
			if( defined('HAPPY_ADDONS_VERSION') && HAPPY_ADDONS_VERSION >= '3.8.4' ) {
				add_action( 'happyaddons_after_register_content_controls', [ Extensions\Designs_Manager::class, 'add_surprise_controls' ], 10, 3 );
			}else{
				add_action( 'happyaddons_start_register_controls', [ Extensions\Designs_Manager::class, 'add_surprise_controls' ], 10, 3 );
			}
			add_action( 'elementor/editor/after_enqueue_scripts', [ Extensions\Designs_Manager::class, 'enqueue_editor_scripts' ] );
			add_action( 'wp_ajax_ha_make_me_surprised', [ Extensions\Designs_Manager::class, 'surprise_me' ] );
		}

	}

	public static function set_features_map( $features ) {
		$pro_features_map = [
			'display-conditions' => [
				'title' => __( 'Display Condition', 'happy-addons-pro' ),
				'icon' => 'hm hm-display-condition',
				'demo' => 'https://happyaddons.com/display-condition/',
				'is_pro' => true,
			],
			'image-masking' => [
				'title' => __( 'Image Masking', 'happy-addons-pro' ),
				'icon' => 'hm hm-image-masking',
				'demo' => 'https://happyaddons.com/image-masking-demo/',
				'is_pro' => true,
			],
			'happy-particle-effects' => [
				'title' => __( 'Happy Particle Effects', 'happy-addons-pro' ),
				'icon' => 'hm hm-spark',
				'demo' => 'https://happyaddons.com/happy-particle-effect/',
				'is_pro' => true,
			],
			'happy-preset' => [
				'title' => __( 'Preset', 'happy-addons-pro' ),
				'icon' => 'hm hm-color-card',
				'demo' => 'https://happyaddons.com/presets-demo/',
				'is_pro' => true,
			],
			'global-badge' => [
				'title' => __( 'Global Badge', 'happy-addons-pro' ),
				'icon' => 'hm hm-global-badge',
				'demo' => 'https://happyaddons.com/global-badge/',
				'is_pro' => true,
			]
		];

		return array_merge( $features, $pro_features_map);
	}
}

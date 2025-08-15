<?php
/**
 * Multi Scroll
 */
namespace Happy_Addons_Pro\Wpml;

defined( 'ABSPATH' ) || die();

class Multi_Scroll extends \WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'multi_scroll_sections';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [
			'left_section_text',
			'right_section_text',
			'menu_text',
			'dot_tooltip',
			'anchor'
		];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'left_section_text':
				return __( 'Multi Scroll: Left Editor', 'happy-addons-pro' );
			case 'right_section_text':
				return __( 'Multi Scroll: Right Editor', 'happy-addons-pro' );
			case 'menu_text':
				return __( 'Multi Scroll: Menu Title', 'happy-addons-pro' );
			case 'dot_tooltip':
				return __( 'Multi Scroll: Dot Tooltip', 'happy-addons-pro' );
			case 'anchor':
				return __( 'Multi Scroll: Anchor Text', 'happy-addons-pro' );
			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'left_section_text':
			case 'right_section_text':
				return 'VISUAL';
			case 'menu_text':
			case 'dot_tooltip':
			case 'anchor':
				return 'LINE';
			default:
				return '';
		}
	}
}

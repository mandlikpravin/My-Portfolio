<?php
/**
 * Advanced Google Map
 */
namespace Happy_Addons_Pro\Wpml;

defined( 'ABSPATH' ) || die();

class Google_Map_List_Marker extends \WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'list_marker';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [
				'pin_item_title',
				'pin_item_description'
			];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'pin_item_title':
				return __( 'Advanced Google Map: Title', 'happy-addons-pro' );
			case 'pin_item_description':
				return __( 'Advanced Google Map: Description', 'happy-addons-pro' );
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
			case 'pin_item_title':
				return 'LINE';
			case 'pin_item_description':
				return 'AREA';
			default:
				return '';
		}
	}
}

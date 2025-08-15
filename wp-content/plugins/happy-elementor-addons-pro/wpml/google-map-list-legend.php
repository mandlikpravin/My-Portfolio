<?php
/**
 * Advanced Google Map
 */
namespace Happy_Addons_Pro\Wpml;

defined( 'ABSPATH' ) || die();

class Google_Map_List_Legend extends \WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'list_legend';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [
				'legend_item_title',
			];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'legend_item_title':
				return __( 'Advanced Google Map: Title', 'happy-addons-pro' );
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
			case 'legend_item_title':
				return 'LINE';
			default:
				return '';
		}
	}
}

<?php
/**
 * Advanced Google Map
 */
namespace Happy_Addons_Pro\Wpml;

defined( 'ABSPATH' ) || die();

class Google_Map_Ha_Gmap_Polylines extends \WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'ha_gmap_polylines';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [
				'ha_gmap_polyline_title',
			];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'ha_gmap_polyline_title':
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
			case 'ha_gmap_polyline_title':
				return 'LINE';
			default:
				return '';
		}
	}
}

<?php
/**
 * Advanced Comparison Table
 */
namespace Happy_Addons_Pro\Wpml;

defined( 'ABSPATH' ) || die();

class Advanced_Comparison_Table_Column_Data_7 extends \WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'column_data_7';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [
			'column_text',
			'btn_text',
			'currency_custom',
			'price',
			'original_price',
			'period',
			'tooltip',
			'description',
			'btn_link' => ['url'],
		];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'column_text':
				return __( 'Advanced Comparison Table: Title', 'happy-addons-pro' );
			case 'btn_text':
				return __( 'Advanced Comparison Table: Button Title', 'happy-addons-pro' );
			case 'currency_custom':
				return __( 'Advanced Comparison Table: Custom Symbol', 'happy-addons-pro' );
			case 'price':
				return __( 'Advanced Comparison Table: Price', 'happy-addons-pro' );
			case 'original_price':
				return __( 'Advanced Comparison Table: Original Price', 'happy-addons-pro' );
			case 'period':
				return __( 'Advanced Comparison Table: Timespan', 'happy-addons-pro' );
			case 'tooltip':
				return __( 'Advanced Comparison Table: Tooltip', 'happy-addons-pro' );
			case 'description':
				return __( 'Advanced Comparison Table: Description', 'happy-addons-pro' );
			case 'btn_link':
				return __( 'Advanced Comparison Table: Link', 'happy-addons-pro' );
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
			case 'column_text':
				return 'LINE';
			case 'btn_text':
				return 'LINE';
			case 'currency_custom':
				return 'LINE';
			case 'price':
				return 'LINE';
			case 'original_price':
				return 'LINE';
			case 'period':
				return 'LINE';
			case 'tooltip':
				return 'AREA';
			case 'description':
				return 'VISUAL';
			case 'btn_link':
				return 'LINK';
			default:
				return '';
		}
	}
}

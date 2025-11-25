<?php
/**
 * Responsible for handling preloader fields and display
 *
 * @package titan-preloader
 */

/**
 * Titan_get_general_fields
 *
 * @return array
 */
function titan_get_general_fields() {
	$fields = array(
		array(
			'id'      => 'titan_general_main_switch',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Titan Preloader', 'titan' ),
			'default' => true,
		),
		array(
			'id'      => 'titan_general_transition_switch',
			'type'    => 'switch',
			'title'   => esc_html__( 'Page Transition', 'titan' ),
			'default' => true,
		),
		array(
			'id'      => 'titan_general_display',
			'type'    => 'radio',
			'title'   => esc_html__( 'Display settings', 'titan' ),
			'default' => 1,
			'data'    => array(
				1 => esc_html__( 'Sitewide', 'titan' ),
				2 => esc_html__( 'Once per tab', 'titan' ),
				3 => esc_html__( 'Homepage only', 'titan' ),
				4 => esc_html__( 'Homepage + once per tab', 'titan' ),
			),
		),
	);
	return $fields;
}

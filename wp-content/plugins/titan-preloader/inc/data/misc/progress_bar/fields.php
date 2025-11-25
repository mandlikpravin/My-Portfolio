<?php
/**
 * Container for the progress bar fields
 *
 * @package titan-preloader
 */

/**
 * Titan_get_progress_bar_fields
 *
 * @param  string $id - preloader id.
 * @param  string $condition - preloader condition.
 * @param  bool   $switch - enable or disable.
 * @param  string $bg_color - background color.
 * @param  string $color - progress color.
 * @return array
 */
function titan_get_progress_bar_fields( $id, $condition, $switch = true, $bg_color = '#999999', $color = '#000000' ) {
	$field_name          = $id . '_progress_bar_switch';
	$bg_field_name       = $id . '_progress_bg_color_switch';
	$progress_field_name = $id . '_progress_color_switch';

	$fields = array(
		array(
			'id'       => $id . '_progress_bar_intro',
			'type'     => 'info',
			'icon'     => 'el-icon-info-sign',
			'title'    => esc_html__( 'Progress Bar Settings', 'titan' ),
			'desc'     => esc_html__( 'These settings can be used to add and customize progress bar.', 'titan' ),
			'required' => $condition,
		),
		array(
			'id'       => $field_name,
			'type'     => 'switch',
			'title'    => esc_html__( 'Progress Bar', 'titan' ),
			'default'  => $switch,
			'required' => $condition,
		),
		array(
			'id'       => $bg_field_name,
			'type'     => 'color',
			'title'    => esc_html__( 'Progress Background Color', 'titan' ),
			'validate' => 'color',
			'output'   => array( '--gfx-titan-progress-bg-color' => ':root' ),
			'default'  => $bg_color,
			'required' => $condition,
		),
		array(
			'id'       => $progress_field_name,
			'type'     => 'color',
			'title'    => esc_html__( 'Progress Bar Color', 'titan' ),
			'validate' => 'color',
			'output'   => array( '--gfx-titan-progress-bar-color' => ':root' ),
			'default'  => $color,
			'required' => $condition,
		),
	);

	return $fields;
}

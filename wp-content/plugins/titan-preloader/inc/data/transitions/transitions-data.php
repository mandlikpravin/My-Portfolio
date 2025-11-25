<?php
/**
 * Transitions main file
 *
 * @package titan-preloader
 */

/**
 * Titan_get_intro_transition_field
 *
 * @return array
 */
function titan_get_intro_transition_field() {
	$fields = array(
		'to_top'             => esc_html__( 'To Top', 'titan' ),
		'to_down'            => esc_html__( 'To Down', 'titan' ),
		'to_left'            => esc_html__( 'To Left', 'titan' ),
		'to_right'           => esc_html__( 'To Right', 'titan' ),

		'to_top_with_bg'     => esc_html__( 'To Top - with Background', 'titan' ),
		'to_down_with_bg'    => esc_html__( 'To Down - with Background', 'titan' ),
		'to_left_with_bg'    => esc_html__( 'To Left - with Background', 'titan' ),
		'to_right_with_bg'   => esc_html__( 'To Right - with Background', 'titan' ),

		'to_top_circular'    => esc_html__( 'To Top - Circular', 'titan' ),
		'to_down_circular'   => esc_html__( 'To Down - Circular', 'titan' ),
		'to_left_circular'   => esc_html__( 'To Left - Circular', 'titan' ),
		'to_right_circular'  => esc_html__( 'To Right - Circular', 'titan' ),

		'fade_out'           => esc_html__( 'Fade Out', 'titan' ),
		'fade_out_to_top'    => esc_html__( 'Fade Out - to Top', 'titan' ),
		'fade_out_to_bottom' => esc_html__( 'Fade Out - to Bottom', 'titan' ),
		'fade_out_to_left'   => esc_html__( 'Fade Out - to Left', 'titan' ),
		'fade_out_to_right'  => esc_html__( 'Fade Out - to Right', 'titan' ),
	);

	return $fields;
}

/**
 * Titan_get_outro_transition_field
 *
 * @return array
 */
function titan_get_outro_transition_field() {
	$fields = array(
		'to_top'            => esc_html__( 'To Top', 'titan' ),
		'to_down'           => esc_html__( 'To Down', 'titan' ),
		'to_left'           => esc_html__( 'To Left', 'titan' ),
		'to_right'          => esc_html__( 'To Right', 'titan' ),

		'to_top_with_bg'    => esc_html__( 'To Top - with Background', 'titan' ),
		'to_down_with_bg'   => esc_html__( 'To Down - with Background', 'titan' ),
		'to_left_with_bg'   => esc_html__( 'To Left - with Background', 'titan' ),
		'to_right_with_bg'  => esc_html__( 'To Right - with Background', 'titan' ),

		'to_top_circular'   => esc_html__( 'To Top - Circular', 'titan' ),
		'to_down_circular'  => esc_html__( 'To Down - Circular', 'titan' ),
		'to_left_circular'  => esc_html__( 'To Left - Circular', 'titan' ),
		'to_right_circular' => esc_html__( 'To Right - Circular', 'titan' ),

		'fade_in'           => esc_html__( 'Fade In', 'titan' ),
		'fade_in_to_top'    => esc_html__( 'Fade In - to Top', 'titan' ),
		'fade_in_to_bottom' => esc_html__( 'Fade In - to Bottom', 'titan' ),
		'fade_in_to_left'   => esc_html__( 'Fade In - to Left', 'titan' ),
		'fade_in_to_right'  => esc_html__( 'Fade In - to Right', 'titan' ),
	);

	return $fields;
}

/**
 * Get_transition_fields
 *
 * @param string $id - preloader id.
 * @param array  $condition - preloader condition.
 * @param string $intro_default - default intro.
 * @param string $outro_default - default outro.
 * @param string $intro_bg_color_default - default intro bg color.
 * @param string $outro_bg_color_default - default intro bg color.
 * @return array
 */
function get_transition_fields(
	$id,
	$condition,
	$intro_default = 'to_top_with_bg',
	$outro_default = 'to_down_with_bg',
	$intro_bg_color_default = '#ffffff',
	$outro_bg_color_default = '#ffffff'
) {
	$intro_id = $id . '_titan_transition_intro';
	$outro_id = $id . '_titan_transition_outro';

	$intro_bg_id = $id . '_titan_transition_intro_bg_color';
	$outro_bg_id = $id . '_titan_transition_outro_bg_color';

	$opening_id = $id . '_titan_transition_opening_intro';

	$fields = array(
		array(
			'id'       => $opening_id,
			'type'     => 'info',
			'icon'     => 'el-icon-info-sign',
			'title'    => esc_html__( 'Transition Settings.', 'titan' ),
			'desc'     => esc_html__( 'These settings can be used to customize how the preloader shows up or hides away', 'titan' ),
			'required' => $condition,
		),
		array(
			'id'       => $intro_id,
			'type'     => 'select',
			'title'    => esc_html__( 'Intro Transition', 'titan' ),
			'options'  => titan_get_intro_transition_field(),
			'default'  => $intro_default,
			'select2'  => array(
				'select2' => array(
					'allowClear' => false,
				),
			),
			'required' => $condition,
		),
		array(
			'id'       => $intro_bg_id,
			'type'     => 'color',
			'title'    => esc_html__( 'Background Color', 'titan' ),
			'validate' => 'color',
			'default'  => $intro_bg_color_default,
			'output'   => array( '--gfx-titan-intro-bg-color' => ':root' ),
			'required' => array_merge(
				array( $condition ),
				array(
					array(
						$intro_id,
						'equals',
						array( 'to_top_with_bg', 'to_down_with_bg', 'to_left_with_bg', 'to_right_with_bg' ),
					),
				)
			),
		),
		array(
			'id'       => $outro_id,
			'type'     => 'select',
			'title'    => esc_html__( 'Outro Transition', 'titan' ),
			'options'  => titan_get_outro_transition_field(),
			'default'  => $outro_default,
			'select2'  => array(
				'select2' => array(
					'allowClear' => false,
				),
			),
			'required' => $condition,
		),
		array(
			'id'       => $outro_bg_id,
			'type'     => 'color',
			'title'    => esc_html__( 'Background Color', 'titan' ),
			'validate' => 'color',
			'default'  => $outro_bg_color_default,
			'output'   => array( '--gfx-titan-outro-bg-color' => ':root' ),
			'required' => array_merge(
				array( $condition ),
				array(
					array(
						$outro_id,
						'equals',
						array( 'to_top_with_bg', 'to_down_with_bg', 'to_left_with_bg', 'to_right_with_bg' ),
					),
				)
			),
		),
	);

	return $fields;
}

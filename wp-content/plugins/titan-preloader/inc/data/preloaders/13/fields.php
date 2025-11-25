<?php
/**
 * Fields for preloader 13.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/main.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition = array( 'preloaders_field', 'equals', $preloader_id );

$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_right_with_bg', 'fade_in_to_right', '#9200ff', '#9200ff' );
$pattern_fields    = titan_get_pattern_fields(
	$preloader_id,
	$condition,
	'cross',
	array(
		'color' => '#ffffff',
		'alpha' => .2,
	),
	8
);
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_counter_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Counter Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--percent' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '400',
			'font-size'   => '20',
			'color'       => '#ffffff',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#000000',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_bar_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Bar Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#1a1a1a',
		'output'   => array( '--gfx-titan-progress-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_bar_color_1',
		'type'     => 'color',
		'title'    => esc_html__( 'Bar Color 1', 'titan' ),
		'validate' => 'color',
		'default'  => '#fe00ff',
		'output'   => array( '--gfx-titan-progress-color-1' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_bar_color_2',
		'type'     => 'color',
		'title'    => esc_html__( 'Bar Color 2', 'titan' ),
		'validate' => 'color',
		'default'  => '#9200ff',
		'output'   => array( '--gfx-titan-progress-color-2' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields );

$demo_fonts = 'Outfit:wght@400';

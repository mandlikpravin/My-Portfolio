<?php
/**
 * Fields for preloader 1.
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

$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_down_circular', 'to_down_circular' );
$pattern_fields    = titan_get_pattern_fields( $preloader_id, $condition, 'circular-hollow' );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	array(
		'id'       => $preloader_id . '_titan_pl_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--countdown' ),
		'default'  => array(
			'font-family' => 'Spline Sans',
			'font-weight' => '700',
			'color'       => '#ffffff',
			'font-size'   => '400',
		),
		'required' => $condition,
	),
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
		'id'       => $preloader_id . 'titan_pl_first_round_color',
		'type'     => 'color',
		'title'    => esc_html__( 'First Round Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#f79057',
		'output'   => array( '--gfx-titan-first-round-bg' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . 'titan_pl_second_round_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Second Round Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#a7fe73',
		'output'   => array( '--gfx-titan-second-round-bg' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields );

$demo_fonts = 'Spline+Sans:wght@700';

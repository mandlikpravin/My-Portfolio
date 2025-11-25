<?php
/**
 * Fields for preloader 9.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/main.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition         = array( 'preloaders_field', 'equals', $preloader_id );
$transition_fields = get_transition_fields( $preloader_id, $condition, 'fade_out', 'fade_in' );
$pattern_fields    = titan_get_pattern_fields( $preloader_id, $condition );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#111518',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_ball_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Ball Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#f79057',
		'output'   => array( '--gfx-titan-ball-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_ball_shadow_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Shadow Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#414446',
		'output'   => array( '--gfx-titan-shadow-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_left_circle_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Left Circle Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#83103c',
		'output'   => array( '--gfx-titan-left-circle-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_right_circle_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Right Circle Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#5e2f9d',
		'output'   => array( '--gfx-titan-right-circle-color' => ':root' ),
		'required' => $condition,
	),
);


$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields );

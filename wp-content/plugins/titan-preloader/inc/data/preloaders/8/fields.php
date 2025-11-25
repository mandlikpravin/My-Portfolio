<?php
/**
 * Fields for preloader 8.
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

$condition         = array( 'preloaders_field', 'equals', $preloader_id );
$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_top_with_bg', 'to_top_circular' );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );
$pattern_fields    = titan_get_pattern_fields(
	$preloader_id,
	$condition,
	'plus',
	array(
		'color' => '#8579f9',
		'alpha' => 1,
	)
);

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_repeater',
		'type'     => 'repeater',
		'title'    => esc_html__( 'Content', 'titan' ),
		'required' => $condition,
		'fields'   => array(
			array(
				'id'      => 'titan_pl_repeater_text_1',
				'type'    => 'text',
				'title'   => esc_html__( 'Text', 'titan' ),
				'default' => esc_html__( 'SOLUTIONS', 'titan' ),
			),
		),
	),
	array(
		'id'       => $preloader_id . '_titan_pl_main_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Main Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '300',
			'font-size'   => '240',
			'color'       => '#ffffff',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_top_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Top Text', 'titan' ),
		'default'  => esc_html__( 'We Provide', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_top_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Top Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--top-text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '200',
			'font-size'   => '50',
			'color'       => '#ffffff',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_percent_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Percent Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--percent' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '200',
			'font-size'   => '50',
			'color'       => '#a39afa',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#6657f7',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
    array(
		'id'       => $preloader_id . '_titan_pl_progress_switch',
		'type'     => 'switch',
		'title'    => esc_html__( 'Display progress bar', 'titan' ),
		'default'  => true,
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_bar_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress Bar Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#5246c6',
		'output'   => array( '--gfx-titan-progress-bar-bg' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_bar_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress Bar Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#ffffff',
		'output'   => array( '--gfx-titan-progress-bar-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields );

$repeater_fields = array(
	'titan_pl_repeater_text_1' => array(
		'__REPEATER_CONTENT__',
		'<div class="gfx_preloader--text">__CONTENT__</div>',
	),
);

$dynamic_fields = array( $preloader_id . '_titan_pl_top_text' );

$switch_fields = array(
    $preloader_id . '_titan_pl_progress_switch' => array(
		'on'  => 'gfx-progress-bar-enabled',
		'off' => 'gfx-progress-bar-disabled',
	),
);

$demo_fonts = 'Outfit:wght@200;300';

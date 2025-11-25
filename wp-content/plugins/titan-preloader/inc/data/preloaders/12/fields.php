<?php
/**
 * Fields for preloader 12.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/main.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/fields.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition = array( 'preloaders_field', 'equals', $preloader_id );

$transition_fields   = get_transition_fields( $preloader_id, $condition, 'to_right_with_bg', 'fade_in', '#333333', '#333333' );
$pattern_fields      = titan_get_pattern_fields(
	$preloader_id,
	$condition,
	'plus',
	array(
		'color' => '#727272',
		'alpha' => 1,
	)
);
$progress_bar_fields = titan_get_progress_bar_fields( $preloader_id, $condition );
$intro_field         = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_repeater',
		'type'     => 'repeater',
		'title'    => esc_html__( 'Content', 'titan' ),
		'required' => $condition,
		'fields'   => array(
			array(
				'id'      => 'titan_pl_repeater_text_2',
				'type'    => 'text',
				'title'   => esc_html__( 'Text', 'titan' ),
				'default' => esc_html__( 'Front End', 'titan' ),
			),
		),
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'default'  => array(
			'font-family' => 'Spline Sans',
			'font-weight' => '400',
			'font-size'   => '160',
			'color'       => '#333333',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#d7d7d7',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_box_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Box Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#333333',
		'output'   => array( '--gfx-titan-box-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields, $progress_bar_fields );

$repeater_fields = array(
	'titan_pl_repeater_text_2' => array(
		'__REPEATER_CONTENT__',
		'<div class="gfx_preloader--text gfx_preloader--text-[index]">__CONTENT__</div>',
	),
);

$demo_fonts = 'Spline+Sans:wght@400';

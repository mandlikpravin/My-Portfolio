<?php
/**
 * Fields for preloader 10.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/fields.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition           = array( 'preloaders_field', 'equals', $preloader_id );
$transition_fields   = get_transition_fields( $preloader_id, $condition );
$progress_bar_fields = titan_get_progress_bar_fields( $preloader_id, $condition, true, '#666666', '#ffffff' );
$intro_field         = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_number_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Number Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--number' ),
		'default'  => array(
			'font-family' => 'Bebas Neue',
			'font-weight' => '400',
			'font-size'   => '350',
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
			'font-family' => 'Bebas Neue',
			'font-weight' => '400',
			'font-size'   => '40',
			'color'       => '#7c8383',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#0d0f0e',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $progress_bar_fields );

$demo_fonts = 'Bebas+Neue:wght@400';

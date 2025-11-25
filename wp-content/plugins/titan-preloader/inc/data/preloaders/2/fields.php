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
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/fields.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition = array( 'preloaders_field', 'equals', $preloader_id );

$pattern_fields      = titan_get_pattern_fields(
	$preloader_id,
	$condition,
	'plus',
	array(
		'color' => '#000000',
		'alpha' => 1,
	)
);
$progress_bar_fields = titan_get_progress_bar_fields( $preloader_id, $condition, true, '#5d9600' );
$intro_field         = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Text', 'titan' ),
		'default'  => esc_html__( 'Welcome.', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '800',
			'font-size'   => '100',
			'color'       => '#000000',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#9bfa00',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $pattern_fields, $progress_bar_fields );

$dynamic_fields = array( $preloader_id . '_titan_pl_text', $preloader_id . '_titan_pl_bg_color' );

$demo_fonts = 'Outfit:wght@800';

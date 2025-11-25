<?php
/**
 * Fields for preloader 7.
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
$transition_fields   = get_transition_fields( $preloader_id, $condition, 'to_right_with_bg', 'to_right', '#FF7800', '#FF7800' );
$progress_bar_fields = titan_get_progress_bar_fields( $preloader_id, $condition, true, '#ffae66', '#ffffff' );
$intro_field         = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Text', 'titan' ),
		'default'  => esc_html__( 'Loading.', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'color'    => false,
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '800',
			'font-size'   => '100',
		),
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#ff7800',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Text Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#ffae66',
		'output'   => array( '--gfx-titan-text-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#ffffff',
		'output'   => array( '--gfx-titan-progress-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $progress_bar_fields );

$dynamic_fields = array( $preloader_id . '_titan_pl_text' );

$demo_fonts = 'Outfit:wght@800';

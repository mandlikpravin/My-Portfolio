<?php
/**
 * Fields for preloader 11.
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
$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_right', 'to_right' );
$pattern_fields    = titan_get_pattern_fields( $preloader_id, $condition, 'circular' );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_image_field',
		'type'     => 'media',
		'title'    => esc_html__( 'Image', 'titan' ),
		'default'  => array(
			'url' => TITAN_PLUGIN_URL . 'inc/assets/images/defaults/envato-circle.png',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_image_dimensions',
		'type'     => 'dimensions',
		'units'    => array( 'px', '%', 'rem' ),
		'title'    => esc_html__( 'Image Size', 'titan' ),
		'output'   => array( '.gfx_preloader .gfx_preloader--logo img' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_loading_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Loading text', 'titan' ),
		'default'  => esc_html__( 'Loading...', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_loading_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '400',
			'font-size'   => '30',
			'color'       => '#ffffff66',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_counter_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Counter Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--percent' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '400',
			'font-size'   => '60',
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
		'id'       => $preloader_id . '_titan_pl_progress_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#82b541',
		'output'   => array( '--gfx-titan-progress-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields, $pattern_fields );

$image_fields = array( $preloader_id . '_titan_pl_image_field' => '__IMAGE__' );

$dynamic_fields = array( $preloader_id . '_titan_pl_loading_text' );

$demo_fonts = 'Outfit:wght@400';

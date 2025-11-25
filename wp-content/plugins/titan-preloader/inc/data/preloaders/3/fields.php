<?php
/**
 * Fields for preloader 3.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';

$preloader_id = basename( __DIR__ );

$condition         = array( 'preloaders_field', 'equals', $preloader_id );
$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_right_with_bg', 'to_right_with_bg', '#82B541', '#82B541' );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_image_field',
		'type'     => 'media',
		'title'    => esc_html__( 'Image', 'titan' ),
		'default'  => array(
			'url' => TITAN_PLUGIN_URL . 'inc/assets/images/defaults/envato-logo-circle.png',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_rotate_switch',
		'type'     => 'switch',
		'title'    => esc_html__( 'Rotate image', 'titan' ),
		'default'  => true,
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_image_dimensions',
		'type'     => 'dimensions',
		'units'    => array( 'px', '%', 'rem' ),
		'title'    => esc_html__( 'Image Size', 'titan' ),
		'output'   => array( '.gfx_preloader .gfx_preloader--logo img' ),
		'default'  => array(
			'width'  => '162',
			'height' => '162',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_loading_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Loading text', 'titan' ),
		'default'  => esc_html__( 'Envato', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_loading_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Loading Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '300',
			'font-size'   => '50',
			'color'       => '#515151',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_counter_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Counter Typography', 'titan' ),
		'output'   => array( '.gfx_preloader--counter' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '300',
			'font-size'   => '30',
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
		'default'  => '#262626',
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
		'id'       => $preloader_id . '_titan_pl_progress_bg',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#1e1e1e',
		'output'   => array( '--gfx-titan-progress-bg' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_progress_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Progress bar Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#82b541',
		'output'   => array( '--gfx-titan-progress-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields );

$image_fields = array( $preloader_id . '_titan_pl_image_field' => '__IMAGE__' );

$dynamic_fields = array( $preloader_id . '_titan_pl_loading_text' );

$switch_fields = array(
	$preloader_id . '_titan_pl_rotate_switch' => array(
		'on'  => 'gfx-rotate',
		'off' => 'gfx-no-rotate',
	),
    $preloader_id . '_titan_pl_progress_switch' => array(
		'on'  => 'gfx-progress-bar-enabled',
		'off' => 'gfx-progress-bar-disabled',
	),
);

$demo_fonts = 'Outfit:wght@300';

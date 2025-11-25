<?php
/**
 * Fields for preloader 14.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/main.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/loaders/loaders-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition = array( 'preloaders_field', 'equals', $preloader_id );

$loaders_fields = titan_get_loaders_fields( $preloader_id, $condition, 'loader_10', '#ff8136' );
$intro_field    = titan_get_intro_field( $preloader_id, $condition );

$content_fields = array(
	// content fields.
	array(
		'id'       => $preloader_id . '_titan_pl_image_field',
		'type'     => 'media',
		'title'    => esc_html__( 'Image', 'titan' ),
		'default'  => array(
			'url' => TITAN_PLUGIN_URL . 'inc/assets/images/defaults/envato-logo-orange.png',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text',
		'type'     => 'text',
		'title'    => esc_html__( 'Text', 'titan' ),
		'default'  => esc_html__( 'an independent creative studio', 'titan' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_text_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Text Typography', 'titan' ),
		'output'   => array( '.gfx_preloader-text' ),
		'default'  => array(
			'font-family' => 'Outfit',
			'font-weight' => '500',
			'font-size'   => '20',
			'color'       => '#ffffff',
			'line-height' => '30',
		),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_counter_typography',
		'type'     => 'typography',
		'title'    => esc_html__( 'Counter Typography', 'titan' ),
		'output'   => array( '.gfx_preloader-counter' ),
		'default'  => array(
			'font-family' => 'Press Start 2P',
			'font-weight' => '400',
			'font-size'   => '80',
			'color'       => '#ff8136',
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
		'id'       => $preloader_id . '_titan_pl_line_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Line Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#262626',
		'output'   => array( '--gfx-titan-bar-border-color' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $loaders_fields );

$image_fields   = array( $preloader_id . '_titan_pl_image_field' => '__IMAGE__' );
$dynamic_fields = array( $preloader_id . '_titan_pl_text' );

$demo_fonts = 'Outfit:wght@400&family=Press+Start+2P';

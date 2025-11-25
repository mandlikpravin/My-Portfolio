<?php
/**
 * Fields for preloader 5.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition         = array( 'preloaders_field', 'equals', $preloader_id );
$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_top_with_bg', 'to_top_with_bg', '#82B541', '#82B541' );
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
		'id'       => $preloader_id . '_titan_pl_star_switch',
		'type'     => 'button_set',
		'title'    => esc_html__( 'Star type', 'titan' ),
		'options'  => array(
			'gfx-lines'    => 'Lines',
			'gfx-circular' => 'Circular',
		),
		'default'  => 'gfx-lines',
		'required' => $condition,
	),

	// color fields.
	array(
		'id'       => $preloader_id . '_titan_pl_bg_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Background Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#071300',
		'output'   => array( '--gfx-titan-bg-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_star_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Star Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#57a028',
		'output'   => array( '--gfx-titan-star-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_rocket_color',
		'type'     => 'color',
		'title'    => esc_html__( 'Rocket Color', 'titan' ),
		'validate' => 'color',
		'default'  => '#79B34C',
		'output'   => array( '--gfx-titan-rocket-color' => ':root' ),
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_rocket_bg',
		'type'     => 'color',
		'title'    => esc_html__( 'Rocket Background', 'titan' ),
		'validate' => 'color',
		'default'  => '#ffffff',
		'output'   => array( '--gfx-titan-rocket-bg' => ':root' ),
		'required' => $condition,
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $transition_fields );

$svg_image_fields = array( $preloader_id . '_titan_pl_image_field' => '__IMAGE_SRC__' );

$dynamic_fields = array( $preloader_id . '_titan_pl_star_switch' );

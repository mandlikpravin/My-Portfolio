<?php
/**
 * Fields for preloader 4.
 *
 * @package titan-preloader
 */

/**
 * Responsible for admin panel behaviour
 */

require_once TITAN_PLUGIN_DIR . '/inc/data/transitions/transitions-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/loaders/loaders-data.php';
require_once TITAN_PLUGIN_DIR . '/inc/data/misc/intro-field.php';

$preloader_id = basename( __DIR__ );

$condition = array( 'preloaders_field', 'equals', $preloader_id );

$transition_fields = get_transition_fields( $preloader_id, $condition, 'to_top', 'to_down' );
$loaders_fields    = titan_get_loaders_fields( $preloader_id, $condition );
$intro_field       = titan_get_intro_field( $preloader_id, $condition );

$images = array(
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/01.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/02.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/03.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/04.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/05.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/06.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/07.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/08.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/09.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/10.jpg',
	TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/11.jpg',
);

if ( ! function_exists( 'titan_get_bg_fields' ) ) {
	/**
	 * Titan_get_bg_fields
	 *
	 * @param  array $images - background images.
	 * @return array
	 */
	function titan_get_bg_fields( $images ) {
		$fields = array();
		$index  = 0;
		foreach ( $images as $image ) {
			$fields[ $image ] = array(
				'alt' => 'bg-' . $index,
				'img' => $image,
			);
			$index++;
		}
		return $fields;
	}
}

$content_fields = array(
	array(
		'id'       => $preloader_id . '_titan_pl_background_button_set',
		'type'     => 'button_set',
		'title'    => esc_html__( 'Background Type', 'titan' ),
		'options'  => array(
			'custom'     => esc_html__( 'Custom', 'titan' ),
			'predefined' => esc_html__( 'Predefined', 'titan' ),
		),
		'default'  => 'predefined',
		'required' => $condition,
	),
	array(
		'id'       => $preloader_id . '_titan_pl_background_custom',
		'type'     => 'background',
		'title'    => esc_html__( 'Background', 'titan' ),
		'output'   => array( '.gfx_preloader' ),
		'required' => array_merge( array( $condition ), array( array( $preloader_id . '_titan_pl_background_button_set', 'equals', 'custom' ) ) ),
	),
	array(
		'id'       => $preloader_id . '_titan_pl_background_predefined',
		'type'     => 'image_select',
		'title'    => esc_html__( 'Background', 'titan' ),
		'output'   => array( 'background-image' => '.gfx_preloader' ),
		'options'  => titan_get_bg_fields( $images ),
		'class'    => 'img-select-field',
		'default'  => TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/02.jpg',
		'required' => array_merge( array( $condition ), array( array( $preloader_id . '_titan_pl_background_button_set', 'equals', 'predefined' ) ) ),
	),
);

$preloader_fields = array_merge( $intro_field, $content_fields, $loaders_fields, $transition_fields );

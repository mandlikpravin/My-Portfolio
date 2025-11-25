<?php
/**
 * Handles all the loaders
 *
 * @package titan-preloader
 */

/**
 * Titan_get_loaders
 *
 * @return array
 */
function titan_get_loaders() {
	include_once ABSPATH . 'wp-admin/includes/file.php';
	WP_Filesystem();
	global $wp_filesystem;
	$loader_json = $wp_filesystem->get_contents( TITAN_PLUGIN_DIR . '/inc/data/loaders/loaders.json' );
	$loaders     = json_decode( $loader_json, true );

	$result = array();

	foreach ( $loaders as $loader ) {
		$result[ $loader['id'] ] = array(
			'alt' => $loader['image']['alt'],
			'img' => TITAN_PLUGIN_URL . 'inc/assets/images/loaders/' . $loader['image']['src'],
		);
	}

	return $result;
}


/**
 * Titan_get_loaders_fields
 *
 * @param  string $id - preloader id.
 * @param  array  $condition - condition of the preloader.
 * @return array
 */
function titan_get_loaders_fields( $id, $condition, $default_loader = 'loader_2', $default_color = '#ffffff' ) {
	$fields = array(
		array(
			'id'       => 'titan_loader_' . $id,
			'type'     => 'image_select',
			'title'    => esc_html__( 'Loaders', 'titan' ),
			'default'  => $default_loader,
			'options'  => titan_get_loaders(),
			'required' => $condition,
		),
		array(
			'id'       => 'titan_loader_color_' . $id,
			'type'     => 'color',
			'title'    => esc_html__( 'Loader Color', 'titan' ),
			'validate' => 'color',
			'default'  => $default_color,
			'output'   => array( '--titan-loader-bg' => ':root' ),
			'required' => $condition,
		),
	);

	return $fields;
}

<?php
/**
 * Responsible for handling preloader fields and display
 *
 * @package titan-preloader
 */

/**
 * Titan_get_exlusion_fields
 *
 * @return array
 */
function titan_get_exlusion_fields() {
	$fields = array(
		array(
			'id'    => 'titan_exclusion_page',
			'type'  => 'select',
			'title' => esc_html__( 'Pages', 'titan' ),
			'multi' => true,
			'data'  => 'pages',
		),
		array(
			'id'    => 'titan_exclusion_post',
			'type'  => 'select',
			'title' => esc_html__( 'Posts', 'titan' ),
			'multi' => true,
			'data'  => 'posts',
		),
		array(
			'id'    => 'titan_exclusion_post_types',
			'type'  => 'select',
			'title' => esc_html__( 'Post Types', 'titan' ),
			'multi' => true,
			'data'  => 'post_types',
		),
	);

	return $fields;
}

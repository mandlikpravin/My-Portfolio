<?php
/**
 * Container for the intro field function
 *
 * @package titan-preloader
 */

/**
 * Titan_get_intro_field
 *
 * @param  mixed $id - preloader id.
 * @param  mixed $condition - preloader condition.
 * @return array
 */
function titan_get_intro_field( $id, $condition ) {
	return array(
		array(
			'id'       => $id . '_titan_pl_intro',
			'type'     => 'info',
			'title'    => esc_html__( 'Preloader ' . $id . ' Selected.', 'titan' ), // phpcs:ignore
			'desc'     => esc_html__( 'Following settings provide customizations for this particular preloader . ', 'titan' ),
			'required' => $condition,
		),
	);
}

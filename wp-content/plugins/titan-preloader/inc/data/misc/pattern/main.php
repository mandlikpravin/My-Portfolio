<?php
/**
 * Container for the pattern function
 *
 * @package titan-preloader
 */

if ( ! function_exists( 'titan_get_pattern_markup' ) ) {
	/**
	 * Titan_get_pattern_markup
	 *
	 * @param  string $type - type of pattern.
	 * @param  int    $rows - number of rows.
	 * @param  int    $cols - number of columns.
	 * @return string
	 */
	function titan_get_pattern_markup( $type, $rows, $cols ) {
		global $gfx_titan;

		$markup = '<div class="gfx_preloader--pattern" data-type="__TYPE__" data-rows="__ROW__" data-columns="__COLS__"></div>';

		$markup = str_replace( '__TYPE__', $type, $markup );
		$markup = str_replace( '__ROW__', $rows, $markup );
		$markup = str_replace( '__COLS__', $cols, $markup );

		return $markup;
	}
}

if ( ! function_exists( 'titan_get_pattern_fields' ) ) {
	/**
	 * Titan_get_pattern_fields
	 *
	 * @param  string  $id - preloader id.
	 * @param  array   $condition - preloader condition.
	 * @param  string  $pattern_default - default pattern.
	 * @param  array   $color_default - default color.
	 * @param  integer $row_default - default count of rows.
	 * @param  integer $col_default - default count of columns.
	 * @return array
	 */
	function titan_get_pattern_fields(
		$id,
		$condition,
		$pattern_default = 'circular',
		$color_default = array(
			'color' => '#ffffff',
			'alpha' => .1,
		),
		$row_default = 7,
		$col_default = 11
	) {
		$pattern_condition = array_merge( array( $condition ), array( array( $id . '_pattern_field', '!=', 'none' ) ) );

		$fields = array(
			array(
				'id'       => $id . '_pattern_intro',
				'type'     => 'info',
				'icon'     => 'el-icon-info-sign',
				'title'    => esc_html__( 'Pattern Settings', 'titan' ),
				'desc'     => esc_html__( 'These settings can be used to add and customize patterns.', 'titan' ),
				'required' => $condition,
			),
			array(
				'id'       => $id . '_pattern_field',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Pattern', 'titan' ),
				'options'  => array(
					'none'            => esc_html__( 'None', 'titan' ),
					'plus'            => esc_html__( 'Plus', 'titan' ),
					'circular'        => esc_html__( 'Circular', 'titan' ),
					'circular-hollow' => esc_html__( 'Circular Hollow', 'titan' ),
					'cross'           => esc_html__( 'Cross', 'titan' ),
				),
				'default'  => $pattern_default,
				'required' => $condition,
			),
			array(
				'id'       => $id . '_pattern_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Pattern Color', 'titan' ),
				'output'   => array( '--pattern-color' => '.gfx_preloader--pattern' ),
				'default'  => $color_default,
				'required' => $pattern_condition,
			),
			array(
				'id'       => $id . '_pattern_row_count',
				'type'     => 'text',
				'title'    => esc_html__( 'Pattern Rows', 'titan' ),
				'validate' => 'numeric',
				'default'  => $row_default,
				'required' => $pattern_condition,
			),
			array(
				'id'       => $id . '_pattern_col_count',
				'type'     => 'text',
				'title'    => esc_html__( 'Pattern Columns', 'titan' ),
				'validate' => 'numeric',
				'default'  => $col_default,
				'required' => $pattern_condition,
			),
		);

		return $fields;
	}
}

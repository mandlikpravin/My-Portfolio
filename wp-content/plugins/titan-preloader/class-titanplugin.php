<?php
/**
 * Plugin main file
 *
 * @package titan-preloader
 */

/**
 * TitanPlugin
 */
class TitanPlugin {

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		// enqueue css and js files.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_static' ), 100 );

		// enqueue admin css.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_static' ), 1 );

		// kses allowed html.
		add_filter( 'wp_kses_allowed_html', array( $this, 'kses_allowed_html' ), 10, 2 );

        add_action( 'init', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Enqueue_static
	 *
	 * @return void
	 */
	public function enqueue_static() {
		wp_enqueue_style( 'titan', TITAN_PLUGIN_URL . 'inc/assets/css/style.css', null, '1.0.0', 'all' );
		wp_enqueue_script( 'titan-gsap', TITAN_PLUGIN_URL . 'inc/assets/js/titan-gsap.min.js', null, '3.11.3', false );
		wp_enqueue_script( 'titan-main', TITAN_PLUGIN_URL . 'inc/assets/js/main.js', null, '1.0.0', true );

		if ( TITAN_PLUGIN_DEMO ) {
			$demo_text = 'const TITAN_DEMO_MODE = true;';
		} else {
			$demo_text = 'const TITAN_DEMO_MODE = false;';
		}

		wp_add_inline_script( 'titan-main', $demo_text, 'before' );
	}

	/**
	 * Enqueue_admin_static
	 *
	 * @return void
	 */
	public function enqueue_admin_static() {
		wp_enqueue_style( 'titan-admin-font', $this->fonts_url(), array(), '1.0.0', 'all' );
		wp_enqueue_style( 'titan-options', TITAN_PLUGIN_URL . 'inc/assets/css/admin.css', null, '1.0.0', 'all' );
		wp_enqueue_script( 'titan-admin-js', TITAN_PLUGIN_URL . 'inc/assets/js/admin-main.js', null, '1.0.0', true );
	}

	/**
	 * Fonts_url
	 *
	 * @return string
	 */
	public function fonts_url() {
		$fonts_url = '';
		$font      = '';
		$subsets   = 'latin,latin-ext';
		/* translators: If there are characters in your language that are not supported by Spartan, translate this to 'off'. Do not translate into your own language. */
		$font = 'Spartan:wght@500;600&display=swap';

		if ( $font ) {
			$fonts_url = add_query_arg(
				array(
					'family' => $font,
					'subset' => $subsets,
				),
				'//fonts.googleapis.com/css2'
			);
		}
		return esc_url_raw( $fonts_url );
	}

	/**
	 * Kses_allowed_html
	 *
	 * @param  mixed $tags - array of HTML tags.
	 * @param  mixed $context - context in which wp_kses is used.
	 * @return array
	 */
	public function kses_allowed_html( $tags, $context ) {
		switch ( $context ) {
			case 'general':
				$tags = wp_kses_allowed_html( 'post' );
				return $tags;
			case 'titan-preloader':
				$tags = wp_kses_allowed_html( 'post' );
				$tags = array_merge(
					$tags,
					array(
						'script'         => array(
							'src' => true,
						),
						'svg'            => array(
							'fill'      => true,
							'height'    => true,
							'width'     => true,
							'xmlns'     => true,
							'viewbox'   => true,
							'class'     => true,
							'transform' => true,
						),
						'g'              => array(
							'fill'             => true,
							'transform-origin' => true,
							'class'            => true,
						),
						'title'          => array( 'title' => true ),
						'path'           => array(
							'class'        => true,
							'd'            => true,
							'id'           => true,
							'fill'         => true,
							'opacity'      => true,
							'fill-opacity' => true,
							'style'        => true,
							'stroke'       => true,
							'stroke-width' => true,
							'transform'    => true,
						),
						'lineargradient' => array(
							'id'            => true,
							'gradientUnits' => true,
							'x1'            => true,
							'y1'            => true,
							'x2'            => true,
							'y2'            => true,
						),
						'stop'           => array(
							'class'        => true,
							'offset'       => true,
							'style'        => true,
							'stop-color'   => true,
							'stop-opacity' => true,
						),
						'image'          => array(
							'href'   => true,
							'x'      => true,
							'y'      => true,
							'width'  => true,
							'height' => true,
						),
						'defs'           => array(),
						'mask'           => array(
							'id'     => true,
							'x'      => true,
							'y'      => true,
							'width'  => true,
							'height' => true,
						),
						'rect'           => array(
							'x'      => true,
							'y'      => true,
							'width'  => true,
							'height' => true,
						),
						'text'           => array(
							'class'             => true,
							'dominant-baseline' => true,
							'text-anchor'       => true,
							'x'                 => true,
							'y'                 => true,
						),
						'tspan'          => array(
							'class' => true,
						),
					)
				);
				return $tags;
			case 'titan-preloader-style':
					$tags = array_merge(
						$tags,
						array(
							'style' => array(),
						)
					);
				return $tags;
			default:
				return $tags;
		}
	}

    public function load_textdomain() {
        load_plugin_textdomain( 'titan', false, dirname( plugin_basename( __FILE__ ) ) . '/inc/languages' );
    }

}

new TitanPlugin();

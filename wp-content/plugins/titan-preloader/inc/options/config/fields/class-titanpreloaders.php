<?php
/**
 * Responsible for handling preloader fields and display
 *
 * @package titan-preloader
 */

if ( ! class_exists( 'Redux' ) ) {
	return;
}


/**
 * TitanPreloaders
 */
class TitanPreloaders {

	/**
	 * Instance
	 *
	 * @var instance
	 */
	private static $instance;
	/**
	 * Preloaders
	 *
	 * @var array
	 */
	private $preloaders;

	/**
	 * __construct
	 *
	 * @return void
	 */
	private function __construct() {
		$this->preloaders = $this->get_preloaders();

		add_action( 'wp_body_open', array( $this, 'add_markup' ), 1 );
		add_action( 'wp_footer', array( $this, 'add_markup' ), 1 );

		add_action( 'wp_head', array( $this, 'add_style' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_demo_fonts' ), 100 );

		add_filter( 'body_class', array( $this, 'page_transitions_off_handler' ) );
	}

	/**
	 * Page_transitions_off_handler
	 *
	 * @param  array $classes - classes for the body element.
	 * @return array
	 */
	public function page_transitions_off_handler( $classes ) {
		global $gfx_titan;

		if (
			( isset( $gfx_titan['titan_general_transition_switch'] ) &&
				'0' === $gfx_titan['titan_general_transition_switch'] ) ||
			( isset( $gfx_titan['titan_general_display'] ) &&
				( '2' === $gfx_titan['titan_general_display'] || '4' === $gfx_titan['titan_general_display'] ) )
		) {
			$classes = array_merge( $classes, array( 'gfx-titan-page-transitions-off' ) );
		}

		return $classes;
	}

	/**
	 * Enqueue_demo_fonts
	 *
	 * @return void
	 */
	public function enqueue_demo_fonts() {
		if ( ! TITAN_PLUGIN_DEMO ) {
			return;
		}

		$id          = $this->demo_handler( null );
		$fields_path = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/fields.php';

		if ( ! $this->file_exists( $fields_path ) ) {
			return;
		}

		include $fields_path;

		if ( ! isset( $demo_fonts ) && empty( $demo_fonts ) ) {
			return;
		}

		$fonts_url = add_query_arg(
			array(
				'family' => $demo_fonts . '&display=block',
				'subset' => 'latin,latin-ext',
			),
			'//fonts.googleapis.com/css2'
		);

		wp_enqueue_style( 'titan-demo-default-font', esc_url_raw( $fonts_url ), array(), '1.0.0', 'all' );
	}

	/**
	 * Get_instance
	 *
	 * @return instance
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get_preloaders
	 *
	 * @return array
	 */
	public function get_preloaders() {
		// get all folders and files in the directory.
		$directory = scandir( TITAN_PLUGIN_DIR . '/inc/data/preloaders' );
		// remove the . and .. from the array.
		$directory = array_diff( $directory, array( '..', '.' ) );
		// convert the folder names to integers.
		$directory = array_map( 'intval', $directory );
		// sort the folder names.
		sort( $directory );

		$preloaders = array();
		foreach ( $directory as $preloader ) {
			$preloaders[] = array(
				'name' => 'Preloader ' . $preloader,
				'id'   => $preloader,
			);
		}
		return $preloaders;
	}

	/**
	 * Get_preloader_img_fields
	 *
	 * @return array
	 */
	public function get_preloader_img_fields() {
		$result = array();
		$index  = 1;
		foreach ( $this->preloaders as $preloader ) {
			$result[ $preloader['id'] ] = array(
				'alt' => 'preloader-' . $index,
				'img' => TITAN_PLUGIN_URL . 'inc/assets/images/preloaders/' . $index . '.gif',
			);
			$index++;
		}

		return $result;
	}

	/**
	 * Get_preloader_specific_fields
	 *
	 * @return array
	 */
	public function get_preloader_specific_fields() {
		$result = array();
		foreach ( $this->preloaders as $preloader ) {
			$id   = $preloader['id'];
			$path = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/fields.php';
			if ( ! $this->file_exists( $path ) ) {
				continue;
			}

			include $path;
			$result = array_merge( $result, $preloader_fields );
		}
		return $result;
	}


	/**
	 * Get_fields
	 *
	 * @return array
	 */
	public function get_fields() {
		$fields = array(
			array(
				'id'      => 'preloaders_field',
				'type'    => 'image_select',
				'options' => $this->get_preloader_img_fields(),
				'default' => '1',
				'class'   => 'preloader-field',
			),
		);

		$fields = array_merge( $fields, $this->get_preloader_specific_fields() );

		return $fields;
	}

	/**
	 * Add_markup
	 *
	 * @return void
	 */
	public function add_markup() {
		global $gfx_titan;

		// don't process if the main switch is off.
		if (
			isset( $gfx_titan['titan_general_main_switch'] ) &&
			'0' === $gfx_titan['titan_general_main_switch']
		) {
			return;
		}

		if ( $this->is_excluded() ) {
			return;
		}

		if ( doing_action( 'wp_body_open' ) ) {
			remove_action( 'wp_footer', array( $this, 'add_markup' ), 1 );
		}

		if (
			! isset( $gfx_titan['preloaders_field'] ) &&
			empty( $gfx_titan['preloaders_field'] )
		) {
			return;
		}

		$id = $gfx_titan['preloaders_field'];

		$id = $this->demo_handler( $id );

		$path        = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/markup.php';
		$fields_path = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/fields.php';
		$script_path = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/script.js';
		$script_url  = TITAN_PLUGIN_URL . 'inc/data/preloaders/' . $id . '/script.js';

		if ( ! $this->file_exists( $path ) || ! $this->file_exists( $script_path ) ) {
			return;
		}

		// open the markup file.
		ob_start();
		include $path;
		$markup = ob_get_contents();
		ob_end_clean();

		// add progress bar if required.
		$markup .= $this->add_progress_bar();

		// add the transition effect.
		$markup .= $this->get_transition( 'intro' );
		$markup .= $this->get_transition( 'outro' );

		// add the session script if necessary.
		$markup .= $this->get_session_script();

		// add script to the markup.
		$markup .= '<script src="' . esc_url( $script_url ) . '"></script>'; // phpcs:ignore

		// add any dynamic text.
		if ( $this->file_exists( $fields_path ) ) {
			include $fields_path;

			if ( isset( $dynamic_fields ) && is_array( $dynamic_fields ) ) {
				foreach ( $dynamic_fields as $field ) {
					$markup = str_replace( $field, $gfx_titan[ $field ], $markup );
				}
			}

			// handle repeater fields.
			if ( isset( $repeater_fields ) && is_array( $repeater_fields ) ) {
				// loop through the fields.
				foreach ( $repeater_fields as $field => $data ) {
					$placeholder = $data[0];
					$mockup      = $data[1];

					// if there is no content then continue to the next repeater field.
					if ( empty( $gfx_titan[ $field ] ) ) {
						// remove placeholder from markup.
						$markup = str_replace( $placeholder, '', $markup );
						continue;
					}

					$index = 1;

					// loop through the content in the field.
					foreach ( $gfx_titan[ $field ] as $repeater_content ) {
						$content = str_replace( '[index]', $index, $mockup );
						$content = str_replace( '__CONTENT__', $repeater_content, $content );
						$markup  = str_replace( $placeholder, $content . $placeholder, $markup );

						$index++;
					}

					// remove placeholder from markup.
					$markup = str_replace( $placeholder, '', $markup );
				}
			}

			// handle image fields.
			if ( isset( $image_fields ) && is_array( $image_fields ) ) {
				foreach ( $image_fields as $field => $placeholder ) {
					// if there is no content then remove the placeholder.
					if ( empty( $gfx_titan[ $field ] ) ) {
						// remove placeholder from markup.
						$markup = str_replace( $placeholder, '', $markup );
						continue;
					}

					$data = $gfx_titan[ $field ];

					if ( empty( $data ) ) {
						// remove placeholder from markup.
						$markup = str_replace( $placeholder, '', $markup );
						continue;
					}

					$img = '<img src="_SRC_" _WIDTH_ _HEIGHT_ />';

					$img = str_replace( '_SRC_', $data['url'], $img );

					if ( ! empty( $data['width'] ) ) {
						$img = str_replace( '_WIDTH_', 'width="' . $data['width'] . '"', $img );
					} else {
						$img = str_replace( '_WIDTH_', '', $img );
					}

					if ( ! empty( $data['height'] ) ) {
						$img = str_replace( '_HEIGHT_', 'height="' . $data['height'] . '"', $img );
					} else {
						$img = str_replace( '_HEIGHT_', '', $img );
					}

					$markup = str_replace( $placeholder, $img, $markup );
				}
			}

			// handle svg image fields.
			if ( isset( $svg_image_fields ) && is_array( $svg_image_fields ) ) {
				foreach ( $svg_image_fields as $field => $placeholder ) {
					// if there is no content then remove the placeholder.
					if ( empty( $gfx_titan[ $field ] ) ) {
						// remove placeholder from markup.
						$markup = str_replace( $placeholder, '', $markup );
						continue;
					}
					$data   = $gfx_titan[ $field ]['url'];
					$markup = str_replace( $placeholder, $data, $markup );
				}
			}

			// handle switch fields.
			if ( isset( $switch_fields ) && is_array( $switch_fields ) ) {
				foreach ( $switch_fields as $field => $value ) {
					// if there is no content then remove the placeholder.
					if ( ! isset( $gfx_titan[ $field ] ) ) {
						// remove placeholder from markup.
						$markup = str_replace( $field, '', $markup );
						continue;
					}

					$data = '';

					if ( '1' === $gfx_titan[ $field ] ) {
						$data = $value['on'];
					} else {
						$data = $value['off'];
					}

					$markup = str_replace( $field, $data, $markup );
				}
			}
		}

		// handle loaders.
		if (
			isset( $gfx_titan[ 'titan_loader_' . $id ] ) &&
			! empty( $gfx_titan[ 'titan_loader_' . $id ] )
		) {
			$loader = $gfx_titan[ 'titan_loader_' . $id ];

			$path    = TITAN_PLUGIN_DIR . '/inc/data/loaders/' . $loader . '/markup.php';
			$content = '';

			if ( $this->file_exists( $path ) ) {
				$content = $this->read_file( $path );
			}

			$markup = str_replace( '__LOADER__', $content, $markup );
		}

		// handle pattern.
		$markup = $this->pattern_handler( $markup );

		// print the markup.
		echo wp_kses( $markup, 'titan-preloader' );
	}


	/**
	 * Pattern_handler
	 *
	 * @param  string $markup - main preloader markup.
	 * @return string
	 */
	public function pattern_handler( $markup ) {
		global $gfx_titan;

		$id = $gfx_titan['preloaders_field'];

		$id = $this->demo_handler( $id );

		if (
			! isset( $gfx_titan[ $id . '_pattern_field' ] ) ||
			empty( $gfx_titan[ $id . '_pattern_field' ] ) ||
			'none' === $gfx_titan[ $id . '_pattern_field' ]
		) {
			$markup = str_replace( '__PATTERN__', '', $markup );
			return $markup;
		}

		$type = $gfx_titan[ $id . '_pattern_field' ];

		$rows = 7;
		$cols = 11;

		if (
			isset( $gfx_titan[ $id . '_pattern_row_count' ] ) &&
			! empty( $gfx_titan[ $id . '_pattern_row_count' ] )
		) {
			$rows = (int) $gfx_titan[ $id . '_pattern_row_count' ];
		}

		if (
			isset( $gfx_titan[ $id . '_pattern_col_count' ] ) &&
			! empty( $gfx_titan[ $id . '_pattern_col_count' ] )
		) {
			$cols = (int) $gfx_titan[ $id . '_pattern_col_count' ];
		}

		$markup_path = TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/main.php';
		$script_path = TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/script.js';
		$script_url  = TITAN_PLUGIN_URL . 'inc/data/misc/pattern/script.js';

		include $markup_path;

		$content = titan_get_pattern_markup( $type, $rows, $cols );

		$script = '<script src="' . esc_url( $script_url ) . '"></script>'; // phpcs:ignore
		$markup = str_replace( '__PATTERN__', $content . $script, $markup );

		return $markup;
	}

	/**
	 * Read_file
	 *
	 * @param  mixed $path - file path.
	 * @return string
	 */
	private function read_file( $path ) {
		include_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;
		return $wp_filesystem->get_contents( $path );
	}

	/**
	 * File_exists
	 *
	 * @param  mixed $path - file path.
	 * @return string
	 */
	private function file_exists( $path ) {
		include_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;
		return $wp_filesystem->exists( $path );
	}

	/**
	 * Pattern_style_handler
	 *
	 * @return void
	 */
	public function pattern_style_handler() {
		$path = TITAN_PLUGIN_DIR . '/inc/data/misc/pattern/style.css';
		$url  = TITAN_PLUGIN_URL . 'inc/data/misc/pattern/style.css';
		wp_enqueue_style( 'titan-pattern-style', $url, null, '1.0.0' );
	}

	/**
	 * Add_progress_bar
	 *
	 * @return string
	 */
	public function add_progress_bar() {
		global $gfx_titan;

		$id = $gfx_titan['preloaders_field'];

		$id = $this->demo_handler( $id );

		$markup_path = TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/markup.php';
		$script_path = TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/script.js';
		$script_url  = TITAN_PLUGIN_URL . '/inc/data/misc/progress_bar/script.js';

		if (
			! isset( $gfx_titan[ $id . '_progress_bar_switch' ] ) ||
			empty( $gfx_titan[ $id . '_progress_bar_switch' ] ) ||
			! $this->file_exists( $markup_path ) ||
			! $this->file_exists( $script_path )
		) {
			return '';
		}

		return $this->read_file( $markup_path ) . '<script src="' . esc_url( $script_url ) . '"></script>'; // phpcs:ignore
	}

	/**
	 * Get_progress_bar_style
	 *
	 * @return void
	 */
	public function get_progress_bar_style() {
		global $gfx_titan;

		$id = $gfx_titan['preloaders_field'];

		$id = $this->demo_handler( $id );

		$style_path = TITAN_PLUGIN_DIR . '/inc/data/misc/progress_bar/style.css';
		$style_url  = TITAN_PLUGIN_URL . 'inc/data/misc/progress_bar/style.css';

		if (
			! isset( $gfx_titan[ $id . '_progress_bar_switch' ] ) ||
			empty( $gfx_titan[ $id . '_progress_bar_switch' ] ) ||
			! $this->file_exists( $style_path )
		) {
			return;
		}

		wp_enqueue_style( 'titan-progress-bar-style-' . $id, $style_url, null, '1.0.0' );
	}


	/**
	 * Demo_handler
	 *
	 * @param  mixed $id the current selected preloader $id.
	 * @return string
	 */
	public function demo_handler( $id ) {
		if ( ! TITAN_PLUGIN_DEMO ) {
			return $id;
		}

		global $post;

		$slug_array = explode( '-', $post->post_name );
		$id         = trim( end( $slug_array ) );

		// for the demo front page, load the bouncing ball preloader.
		if ( is_front_page() ) {
			$id = '9';
		}

		return $id;
	}

	/**
	 * Add_style
	 *
	 * @return void
	 */
	public function add_style() {
		global $gfx_titan;

		// don't process if the main switch is off.
		if (
			isset( $gfx_titan['titan_general_main_switch'] ) &&
			'0' === $gfx_titan['titan_general_main_switch']
		) {
			return;
		}

		if ( $this->is_excluded() ) {
			return;
		}

		if (
			! isset( $gfx_titan['preloaders_field'] ) &&
			empty( $gfx_titan['preloaders_field'] )
		) {
			return;
		}

		$id = $gfx_titan['preloaders_field'];

		$id = $this->demo_handler( $id );

		$path = TITAN_PLUGIN_DIR . '/inc/data/preloaders/' . $id . '/style.css';
		$url  = TITAN_PLUGIN_URL . 'inc/data/preloaders/' . $id . '/style.css';

		if ( ! $this->file_exists( $path ) ) {
			return;
		}

		wp_enqueue_style( 'titan-preloader-style-' . $id, $url, null, '1.0.0' );

		$this->get_transition_style( 'intro' );
		$this->get_transition_style( 'outro' );

		// handle loaders.
		if (
			isset( $gfx_titan[ 'titan_loader_' . $id ] ) &&
			! empty( $gfx_titan[ 'titan_loader_' . $id ] )
		) {
			$loader = $gfx_titan[ 'titan_loader_' . $id ];

			$url = TITAN_PLUGIN_URL . 'inc/data/loaders/' . $loader . '/style.css';

			wp_enqueue_style( 'titan-loader-style-' . $id, $url, null, '1.0.0' );
		}

		// progress bar style.
		$this->get_progress_bar_style();

		// pattern.
		$this->pattern_style_handler();
	}

	/**
	 * Is_excluded
	 *
	 * @return bool
	 */
	public function is_excluded() {
		global $post;
		global $gfx_titan;

		// allow only on homepage.
		if (
			isset( $gfx_titan['titan_general_display'] ) &&
			( '3' === $gfx_titan['titan_general_display'] ||
				'4' === $gfx_titan['titan_general_display'] )
		) {
			if ( is_front_page() ) {
				return false;
			} else {
				return true;
			}
		}

		// exclude if post type is excluded.
		if (
			! empty( $gfx_titan['titan_exclusion_post_types'] ) &&
			is_array( $gfx_titan['titan_exclusion_post_types'] ) &&
			in_array( strval( $post->post_type ), $gfx_titan['titan_exclusion_post_types'], true )
		) {
			return true;
		}

		// exclude if page is excluded.
		if (
			! empty( $gfx_titan['titan_exclusion_page'] ) &&
			is_array( $gfx_titan['titan_exclusion_page'] ) &&
			in_array( strval( $post->ID ), $gfx_titan['titan_exclusion_page'], true )
		) {
			return true;
		}

		// exclude if post is excluded.
		if (
			null !== $post &&
			'post' === $post->post_type &&
			! empty( $gfx_titan['titan_exclusion_post'] ) &&
			is_array( $gfx_titan['titan_exclusion_post'] ) &&
			in_array( strval( $post->ID ), $gfx_titan['titan_exclusion_post'], true )
		) {
			return true;
		}

	}

	/**
	 * Get_session_script
	 *
	 * @return string
	 */
	public function get_session_script() {
		global $gfx_titan;

		if (
			isset( $gfx_titan['titan_general_display'] ) &&
			( '2' === $gfx_titan['titan_general_display'] || '4' === $gfx_titan['titan_general_display'] )
		) {
			$path = TITAN_PLUGIN_DIR . '/inc/data/misc/session_script.js';
			$url  = TITAN_PLUGIN_URL . 'inc/data/misc/session_script.js';
			return '<script src="' . esc_url($url) . '"></script>'; // phpcs:ignore
		} else {
			return '';
		}
	}

	/**
	 * Remove_page_transition
	 *
	 * @param  string $markup main preloader markup.
	 * @return string
	 */
	public function remove_page_transition( $markup ) {
		global $gfx_titan;

		if (
			( isset( $gfx_titan['titan_general_transition_switch'] ) &&
				'0' === $gfx_titan['titan_general_transition_switch'] ) ||
			( isset( $gfx_titan['titan_general_display'] ) &&
				( '2' === $gfx_titan['titan_general_display'] || '4' === $gfx_titan['titan_general_display'] ) )
		) {
			$start_label = '// __PAGE_TRANSITION_START__';
			$end_label   = '// __PAGE_TRANSITION_END__';

			$start        = strpos( $markup, $start_label );
			$end          = strpos( $markup, $end_label );
			$code_portion = substr( $markup, $start, $end - $start + strlen( $end_label ) );

			$markup = str_replace( $code_portion, '', $markup );
		}

		return $markup;
	}

	/**
	 * Get_transition
	 *
	 * @param  string $type type of transition -  intro or outro.
	 * @return string
	 */
	public function get_transition( $type ) {
		global $gfx_titan;

		$id = $gfx_titan['preloaders_field'];
		$id = $this->demo_handler( $id );

		$field_name = $id . '_titan_transition_' . $type;

		if ( ! isset( $gfx_titan[ $field_name ] ) || empty( $gfx_titan[ $field_name ] ) ) {
			return;
		}

		$field = $gfx_titan[ $field_name ];

		$base_path = TITAN_PLUGIN_DIR . '/inc/data/transitions/' . $type . '/' . $field . '/';
		$base_url  = TITAN_PLUGIN_URL . 'inc/data/transitions/' . $type . '/' . $field . '/';

		$result = '';

		$script_path = $base_path . 'script.js';
		$script_url  = $base_url . 'script.js';
		if ( $this->file_exists( $script_path ) ) {

			$markup_path = $base_path . 'markup.php';
			if ( $this->file_exists( $markup_path ) ) {
				$result .= $this->read_file( $markup_path );
			}

			$result .= '<script src="' . esc_url( $script_url ) . '"></script>'; // phpcs:ignore
		}

		return $result;
	}

	/**
	 * Get_transition_style
	 *
	 * @param  string $type type of transition -  intro or outro.
	 * @return void
	 */
	public function get_transition_style( $type ) {
		global $gfx_titan;

		$id         = $gfx_titan['preloaders_field'];
		$id         = $this->demo_handler( $id );
		$field_name = $id . '_titan_transition_' . $type;

		if ( ! isset( $gfx_titan[ $field_name ] ) || empty( $gfx_titan[ $field_name ] ) ) {
			return;
		}

		$field = $gfx_titan[ $field_name ];

		$url = TITAN_PLUGIN_URL . 'inc/data/transitions/' . $type . '/' . $field . '/style.css';

        $response = wp_remote_head( $url );

        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
            return;
        }

		wp_enqueue_style( 'titan-transition-style-' . $type . '-' . $id, $url, null, '1.0.0' );
	}

}

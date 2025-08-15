<?php

/**
 * Plugin base class
 *
 * @package Happy_Addons_Pro
 */

namespace Happy_Addons_Pro;

use \Happy_Addons_Pro\Classes as HappyAddonsPro_Classes; // Code from autoloader

defined('ABSPATH') || die();

class Base {

	private static $instance = null;

	public static $appsero = null;
	public static $widget_count = 0;

	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		$this->run_autoload();
	}

	public function init() {
		$this->init_appsero();

		$this->include_files();

		add_action('init', [$this, 'include_on_init']);

		// Register custom category
		add_action('elementor/elements/categories_registered', [$this, 'add_category']);

		// Register custom controls
		add_action('elementor/controls/register', [$this, 'register_controls']);

		add_action('wp_loaded', [$this, 'license_menu'] );
	}

	public function i18n() {
		load_plugin_textdomain( 'happy-addons-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n' );
	}

	/**
	 * Initialize the tracker
	 *
	 * @return void
	 */
	protected function init_appsero() {
		if (!class_exists('\Happy_Addons\Appsero\Client')) {
			include_once HAPPY_ADDONS_DIR_PATH . 'vendor/appsero/src/Client.php';
		}

		self::$appsero = new \Happy_Addons\Appsero\Client(
			'3cb003ad-7dd3-4e34-9c36-90a2e84b537a',
			'Happy Elementor Addons Pro',
			HAPPY_ADDONS_PRO__FILE__
		);

		self::$appsero->set_textdomain( 'happy-addons-pro' );

		if (!class_exists('\Happy_Addons_Pro\Appsero\Updater')) {
			include_once HAPPY_ADDONS_PRO_DIR_PATH . 'vendor/appsero/src/Updater.php';

			\Happy_Addons_Pro\Appsero\Updater::init(self::$appsero);
		}else{
			// Active automatic updater
			self::$appsero->updater();
		}
	}

	public function license_menu() {
		$args = [
			'type'       => 'submenu',
			'menu_title' => esc_html( self::$appsero->license()->is_valid() ? __( 'License', 'happy-addons-pro' ) : __( 'Activate License', 'happy-addons-pro' ) ),
			'page_title' => 'License - Happy Elementor Addons',
			'menu_slug'  => 'happy-addons-license',
			'parent_slug' => 'happy-addons',
		];

		self::$appsero->license()->add_settings_page($args);
	}

	public function include_on_init() {
		include_once( HAPPY_ADDONS_PRO_DIR_PATH . 'inc/functions-extensions.php' );

		HappyAddonsPro_Classes\Extensions_Manager::init();
		HappyAddonsPro_Classes\Mega_Menu::instance();

		// Condition_Manager
		add_filter('happyaddons/conditions/archive', [HappyAddonsPro_Classes\Condition_Manager::class, 'nullify_condition']);
		add_filter('happyaddons/conditions/singular', [HappyAddonsPro_Classes\Condition_Manager::class, 'nullify_condition']);
		add_filter('happyaddons/conditions/check/cond_sub_id', [HappyAddonsPro_Classes\Condition_Manager::class, 'check_sub_conditions'], 9999999, 2);
	}

	public function include_files() {
		include_once(HAPPY_ADDONS_PRO_DIR_PATH . 'inc/functions.php');
		include_once(HAPPY_ADDONS_PRO_DIR_PATH . 'inc/functions-template.php');

		if ( is_admin() ) {
			// Dashboard_Manager
			add_filter( 'plugin_action_links_' . plugin_basename( HAPPY_ADDONS_PRO__FILE__ ), [ HappyAddonsPro_Classes\Dashboard_Manager::class, 'add_action_links' ] );
			add_filter( 'happyaddons_dashboard_get_tabs', [ HappyAddonsPro_Classes\Dashboard_Manager::class, 'add_tabs' ] );
			add_action( 'admin_notices', [ HappyAddonsPro_Classes\Dashboard_Manager::class, 'add_activate_license_notice' ] );
		}

		if ( is_user_logged_in() ) {
			// Marvin
			if ( hapro_is_elementor_version( '>=', '2.8.0' ) ) {
				add_action( 'elementor/editor/after_enqueue_scripts', [ HappyAddonsPro_Classes\Marvin::class, 'enqueue' ] );
			} else {
				add_action( 'elementor/preview/enqueue_scripts', [ HappyAddonsPro_Classes\Marvin::class, 'enqueue' ] );
			}
			add_action( 'elementor/preview/enqueue_scripts', [ HappyAddonsPro_Classes\Marvin::class, 'enqueue_preview' ] );
			add_action( 'wp_ajax_ha_process_ixport', [ HappyAddonsPro_Classes\Marvin::class, 'process_ixport' ] );
		}

		// Widgets_Manager
		add_filter('happyaddons_get_widgets_map', [ HappyAddonsPro_Classes\Widgets_Manager::class, 'add_widgets_map']);
		if ( hapro_get_appsero()->license()->is_valid() ) {
			add_action( 'happyaddons/widgets/register', [ HappyAddonsPro_Classes\Widgets_Manager::class, 'register'], 20 );
		}

		// Credentials_Manager
		add_filter('happyaddons_get_credentials_map', [ HappyAddonsPro_Classes\Credentials_Manager::class, 'add_credentials_map']);

		// Assets_Manager
		if ( hapro_get_appsero()->license()->is_valid() ) {
			add_action( 'wp_enqueue_scripts', [ HappyAddonsPro_Classes\Assets_Manager::class, 'frontend_register' ], 0 );
			add_action( 'admin_enqueue_scripts', [ HappyAddonsPro_Classes\Assets_Manager::class, 'admin_enqueue_scripts' ], 0 );
			add_action( 'happyaddons_enqueue_assets', [ HappyAddonsPro_Classes\Assets_Manager::class, 'frontend_enqueue' ] );
			add_filter( 'happyaddons_get_styles_file_path', [ HappyAddonsPro_Classes\Assets_Manager::class, 'set_styles_file_path' ], 10, 3 );
			add_action( 'elementor/editor/after_enqueue_scripts', [ HappyAddonsPro_Classes\Assets_Manager::class, 'enqueue_editor_scripts' ] );
			add_action( 'elementor/preview/enqueue_scripts', [ HappyAddonsPro_Classes\Assets_Manager::class, 'preview_enqueue' ] );
		}

		// Live_Copy
		add_action('wp_footer', [ HappyAddonsPro_Classes\Live_Copy::class, 'enqueue_scripts'] );
		add_action('wp_ajax_get_section_data', [ HappyAddonsPro_Classes\Live_Copy::class, 'get_section_data'] );
		add_action('wp_ajax_nopriv_get_section_data', [ HappyAddonsPro_Classes\Live_Copy::class, 'get_section_data'] );
		add_action('elementor/frontend/section/before_render', [ HappyAddonsPro_Classes\Live_Copy::class, 'should_script_enqueue'] );
		add_action('elementor/frontend/container/before_render', [ HappyAddonsPro_Classes\Live_Copy::class, 'should_script_enqueue'] );
		add_action('elementor/element/section/_section_happy_pro_features/after_section_start', [ HappyAddonsPro_Classes\Live_Copy::class, 'register_section_controls'] );
		add_action('elementor/element/container/_section_happy_pro_features/after_section_start', [ HappyAddonsPro_Classes\Live_Copy::class, 'register_section_controls'] );

		// WPML_Manager
		add_filter( 'wpml_elementor_widgets_to_translate', [ HappyAddonsPro_Classes\WPML_Manager::class, 'add_widgets_to_translate' ] );

		//Lazy_Query_Manager
		add_action( 'wp_ajax_ha_get_lazy_query_data', [ HappyAddonsPro_Classes\Lazy_Query_Manager::class, 'do_lazy_query' ] );

		HappyAddonsPro_Classes\Ajax_Handler::instance()->init();

		//Loop_Template
		add_filter('happyaddons/theme-builder/template-types', [ HappyAddonsPro_Classes\Loop_Template::class, 'loop_template_add'], 10, 1);
		add_action( 'wp_head', [ HappyAddonsPro_Classes\Loop_Template::class, 'loop_template_editor_width' ] );
	}

	/**
	 * Add pro category
	 */
	public function add_category() {
		ha_elementor()->elements_manager->add_category(
			'happy_addons_pro_category',
			[
				'title' => __('Happy Addons Pro', 'happy-addons-pro'),
				'icon' => 'fa fa-smile-o',
			]
		);
	}

	/**
	 * Register custom controls
	 *
	 * Include custom controls file and register them
	 *
	 * @access public
	 */
	public function register_controls($controls_manager = null) {

		$mask_image = __NAMESPACE__ . '\Controls\Mask_Image';
		$image_selector = __NAMESPACE__ . '\Controls\Image_Selector';
		$indicator_selector = __NAMESPACE__ . '\Controls\Indicator_Selector';
		$lazy_select = __NAMESPACE__ . '\Controls\Lazy_Select';

		ha_elementor()->controls_manager->add_group_control($mask_image::get_type(), new $mask_image());

		$controls_manager->register(new $image_selector());
		$controls_manager->register(new $indicator_selector());
		$controls_manager->register(new $lazy_select());
	}

	protected static function init_classes_aliases() {
		return [
			'Group_Control_Mask_Image' => [
				'Happy_Addons_Pro\Controls\Mask_Image',
				'\Happy_Addons_Pro\Controls\Group_Control_Mask_Image',
			]
		];
	}

	public static function get_class_name($class_str) {
		$last_slash_pos = strrpos($class_str, '\\');
		if ($last_slash_pos !== false) {
			$class_name = substr($class_str, $last_slash_pos + 1);
		} else {
			$class_name = $class_str; // Fallback if no backslash exists
		}
		return $class_name;
	}

	protected function autoload( $class_name ) {
		if ( 0 !== strpos( $class_name, __NAMESPACE__ ) ) {
			return;
		}

		$relative_class_name = self::get_class_name( $class_name );

		$file_name = strtolower(
			str_replace(
				[ __NAMESPACE__ . '\\', '_', '\\' ], // replace namespace, underscrore & backslash
				[ '', '-', '/' ],
				$class_name
			)
		);

		//For Classes folder class load
		if ( 0 === strpos( $class_name, 'Happy_Addons_Pro\Classes\\' ) ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . $file_name . '.php';
			if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For Controls folder class load
		if ( 0 === strpos( $class_name, 'Happy_Addons_Pro\Controls\\' ) ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . $file_name . '.php';
			if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For Extensions folder class load
		if ( 0 === strpos( $class_name, 'Happy_Addons_Pro\Extensions\\' ) ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . $file_name . '.php';
			if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For Traits folder class load
		if ( 0 === strpos( $class_name, 'Happy_Addons_Pro\Traits\\' ) ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . $file_name . '.php';
			if ( ! trait_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For Widget class load
		if ( 0 === strpos( $class_name, __NAMESPACE__ . '\Widget\\' ) ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . str_replace( 'widget', 'widgets', $file_name ) . '/widget.php';
			if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For WPML class load
		if ( 0 === strpos( $class_name, 'Happy_Addons_Pro\Wpml') ) {
			$file = HAPPY_ADDONS_PRO_DIR_PATH . '/' . $file_name . '.php';
			if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
				include_once $file;
			}
		}

		//For class aliases
		if ( array_key_exists( $relative_class_name, self::init_classes_aliases() ) ) {
			$aliases = self::init_classes_aliases();
			class_alias( $aliases[ $relative_class_name ][0], $aliases[ $relative_class_name ][1] );
		}

	}

	public function run_autoload() {
		spl_autoload_register( [ $this, 'autoload' ] );
	}
}

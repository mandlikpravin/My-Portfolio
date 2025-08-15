<?php
namespace Happy_Addons_Pro\Classes;

defined( 'ABSPATH' ) || die();

class Assets_Manager {

	public static function set_styles_file_path( $file_path, $file_name, $is_pro ) {
		if ( $is_pro ) {
			return sprintf(
				'%1$sassets/css/widgets/%2$s.min.css',
				HAPPY_ADDONS_PRO_DIR_PATH,
				$file_name
			);
		}

		if ( $file_name === Widgets_Manager::COMMON_WIDGET_KEY ) {
			return sprintf(
				'%1$sassets/css/widgets/%2$s.min.css',
				HAPPY_ADDONS_PRO_DIR_PATH,
				'common'
			);
		}

		return $file_path;
	}

	public static function frontend_register() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '';

		// Prism
		wp_register_style(
			'prism',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/prism/css/prism.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_script(
			'prism',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/prism/js/prism.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		//Countdown
		// Unregister first to load our own countdown version
		wp_deregister_script( 'jquery-countdown' );
		wp_register_script(
			'jquery-countdown',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/countdown/js/countdown' . $suffix . '.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		//Animated Text
		wp_register_script(
			'animated-text',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/animated-text/js/animated-text.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		//Keyframes
		wp_register_script(
			'jquery-keyframes',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/keyframes/js/jquery.keyframes.min.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// Tipso: tooltip plugin
		wp_register_style(
			'tipso',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/tipso/tipso' . $suffix . '.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		// animate.css
		wp_register_style(
			'animate-css',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/animate-css/main.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		// Hamburger.css
		wp_register_style(
			'hamburgers',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/hamburgers/hamburgers.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);


		wp_register_script(
			'jquery-tipso',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/tipso/tipso' . $suffix . '.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// Chart.js
		wp_register_script(
			'chart-js',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/chart/chart.min.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// datatables.js
		wp_register_script(
			'data-table',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/data-table/datatables.min.js',
			['jquery'],
			HAPPY_ADDONS_PRO_VERSION
		);

		// Nice Select Plugin
		wp_register_style(
			'nice-select',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/nice-select/nice-select.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_script(
			'jquery-nice-select',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/nice-select/jquery.nice-select.min.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// Plyr: video player plugin
		wp_register_style(
			'plyr',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/plyr/plyr.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_script(
			'plyr',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/plyr/plyr.min.js',
			[ 'jquery' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// owl carousel
		wp_register_style(
			'owl-carousel',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/owl/owl.carousel.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_style(
			'owl-theme-default',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/owl/owl.theme.default.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_style(
			'owl-animate',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/owl/animate.min.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_script(
			'owl-carousel-js',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/owl/owl.carousel.min.js',
			['jquery'],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		/**
		 * Swiperjs library for advanced slider
		 * handler change becasue elementor used older version of swiperjs.
		 * We used latest version which was conflicting.
		 */
		wp_register_script(
			'ha-swiper',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/swiper/js/swiper-bundle' . $suffix . '.js',
			[],
			'6.4.5',
			true
		);
		wp_register_style(
			'ha-swiper',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/swiper/css/swiper-bundle' . $suffix . '.css',
			[],
			'6.4.5'
		);

		/**
		 * TweenMax js library
		 */
		wp_register_script(
			'tweenmax',
			// HAPPY_ADDONS_PRO_ASSETS . 'vendor/swiper/css/swiper-bundle' . $suffix . '.css',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js',
			[],
			'1.19.1',
			true
		);

		wp_register_script(
			'multiscroll',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/multiscroll/jquery.multiscroll.min.js',
			[],
			'0.2.3',
			true
		);

		wp_register_style(
			'multiscroll',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/multiscroll/jquery.multiscroll.min.css',
			[],
			'0.2.3'
		);

		/**
		 * Happy Sequencer js library
		 */
		wp_register_script(
			'happy-sequencer',
			HAPPY_ADDONS_PRO_ASSETS . 'vendor/scroll-sequence/happy-sequencer.js',
			[],
			// '2.0.0',
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		// Google map scripts
		$google_credentials = ha_get_credentials( 'google_map' );
		$gm_api_key = is_array( $google_credentials ) ? $google_credentials['api_key'] : '';
		if( !empty( $gm_api_key ) ) {
			wp_register_script(
				'ha-google-maps',
				'//maps.googleapis.com/maps/api/js?key='. $gm_api_key,
				[],
				NULL,
				true
			);
		}

		//table-of-contents
		// wp_register_script(
		// 	'ha-toc', //table-of-contents
		// 	HAPPY_ADDONS_PRO_ASSETS .'assets/vendor/table-of-contents/tocbot.min.js',
		// 	[],
		// 	'4.12.0',
		// 	true
		// );

		// HappyAddons Pro
		wp_register_style(
			'happy-addons-pro',
			HAPPY_ADDONS_PRO_ASSETS . 'css/main' . $suffix . '.css',
			[],
			HAPPY_ADDONS_PRO_VERSION
		);

		wp_register_script(
			'happy-addons-pro',
			HAPPY_ADDONS_PRO_ASSETS . 'js/happy-addons-pro' . $suffix . '.js',
			[ 'jquery', 'happy-elementor-addons' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		//Localize scripts
		wp_localize_script( 'happy-addons-pro', 'HappyProLocalize', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'happy_addons_pro_nonce' ),
		] );


	}

	public static function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if( $screen->id == 'toplevel_page_happy-addons') {
			wp_enqueue_script(
				'happy-addons-pro-ai',
				HAPPY_ADDONS_PRO_ASSETS . 'js/happy-addons-pro-ai.js',
				[ 'jquery' ],
				HAPPY_ADDONS_PRO_VERSION,
				true
			);

			wp_localize_script( 'happy-addons-pro-ai', 'skinWidgetToHide', ['widgets' => ['post-grid', 'product-carousel', 'product-category-carousel', 'product-grid', 'product-category-grid', 'single-product']]);
		}
	}

	public static function enqueue_editor_scripts() {
		wp_enqueue_script(
			'happy-addons-pro-editor',
			HAPPY_ADDONS_PRO_ASSETS . 'admin/js/editor.min.js',
			[ 'elementor-editor' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		wp_add_inline_script(
			//_editor.js
			'jquery',
			"function _0x846f(){const _0x49ed84=['image','.elementor-repeater-fields:eq(','elementSettingsModel','editor','title','fetch','attachment','get','ready','input','trigger','#elementor-control-default-c','1002357PWBHrA','has','css','set','val','caption','index','taeper-ezg','943150LlwvSB','message',')\x20.elementor-control:not(.elementor-hidden-control)\x20.elementor-control-media__preview:eq(0)','then','285LRGqPl','subtitle','ha_metro_grid.editor.pull_meta','cid','data','replace','27893HsalXR','click','model','9867924FgPitb','originalEvent','27208ZYxcMo','60666OXbXRu','4608848uUeoMe','301MYvbQz','type'];_0x846f=function(){return _0x49ed84;};return _0x846f();}(function(_0x2bb130,_0x38f1ef){const _0x20e276=_0x1140,_0x56dec2=_0x2bb130();while(!![]){try{const _0x507fcc=-parseInt(_0x20e276(0xd2))/0x1+parseInt(_0x20e276(0xf0))/0x2+parseInt(_0x20e276(0xe8))/0x3+parseInt(_0x20e276(0xd7))/0x4*(-parseInt(_0x20e276(0xf4))/0x5)+-parseInt(_0x20e276(0xd8))/0x6*(parseInt(_0x20e276(0xda))/0x7)+-parseInt(_0x20e276(0xd9))/0x8+parseInt(_0x20e276(0xd5))/0x9;if(_0x507fcc===_0x38f1ef)break;else _0x56dec2['push'](_0x56dec2['shift']());}catch(_0x345865){_0x56dec2['push'](_0x56dec2['shift']());}}}(_0x846f,0x741fc));;function _0x1140(_0x452183,_0x4522e4){const _0x846fa8=_0x846f();return _0x1140=function(_0x114059,_0x47452f){_0x114059=_0x114059-0xcf;let _0x5b30c6=_0x846fa8[_0x114059];return _0x5b30c6;},_0x1140(_0x452183,_0x4522e4);}(function(_0x48c722){const _0x12bafb=_0x1140;_0x48c722(document)[_0x12bafb(0xe4)](function(){const _0x31028d=_0x12bafb;_0x48c722(window)['on'](_0x31028d(0xf1),function(_0x5f22d3){const _0x1ce300=_0x31028d;if('object'==typeof _0x5f22d3['originalEvent'][_0x1ce300(0xd0)]&&Reflect[_0x1ce300(0xe9)](_0x5f22d3[_0x1ce300(0xd6)][_0x1ce300(0xd0)],_0x1ce300(0xdb))&&Reflect[_0x1ce300(0xe3)](_0x5f22d3[_0x1ce300(0xd6)][_0x1ce300(0xd0)],_0x1ce300(0xdb))==_0x1ce300(0xef)){const _0xaa6d9d=Reflect[_0x1ce300(0xe3)](_0x5f22d3[_0x1ce300(0xd6)][_0x1ce300(0xd0)],_0x1ce300(0xee));_0x48c722('.elementor-repeater-fields:eq('+_0xaa6d9d+')\x20.elementor-repeater-row-item-title')['click']();const _0x5d3776=_0x48c722(_0x1ce300(0xdd)+_0xaa6d9d+_0x1ce300(0xf2))[_0x1ce300(0xea)]('background-image');_0x5d3776['includes']('placeholder')&&_0x48c722(_0x1ce300(0xdd)+_0xaa6d9d+')\x20.elementor-control-media__preview:eq(0)')[_0x1ce300(0xd3)]();}}),elementor['channels'][_0x31028d(0xdf)]['on'](_0x31028d(0xf6),function(_0x5b113a){const _0x448a9d=_0x31028d,_0x2cfd9e=_0x5b113a[_0x448a9d(0xde)][_0x448a9d(0xe3)](_0x448a9d(0xdc))['id'];if(_0x2cfd9e){const _0x5102e9=_0x5b113a[_0x448a9d(0xd4)][_0x448a9d(0xcf)][_0x448a9d(0xd1)]('c','')*0x1;wp['media'][_0x448a9d(0xe2)](_0x2cfd9e)[_0x448a9d(0xe1)]()[_0x448a9d(0xf3)](function(_0xea64e8){const _0x348523=_0x448a9d;_0x5b113a[_0x348523(0xde)][_0x348523(0xeb)](_0x348523(0xe0),_0xea64e8[_0x348523(0xe0)]),_0x5b113a[_0x348523(0xde)]['set'](_0x348523(0xf5),_0xea64e8[_0x348523(0xed)]),_0x48c722('#elementor-control-default-c'+(_0x5102e9+0x1))[_0x348523(0xec)](_0xea64e8[_0x348523(0xe0)]),_0x48c722(_0x348523(0xe7)+(_0x5102e9+0x2))['val'](_0xea64e8[_0x348523(0xed)])[_0x348523(0xe6)](_0x348523(0xe5));});}});});}(jQuery));"
		);
	}

	public static function frontend_enqueue( $is_cache ) {
		if ( ! $is_cache ) {
			wp_enqueue_style( 'happy-addons-pro' );
			wp_enqueue_script( 'happy-addons-pro' );
		} else {
			wp_enqueue_script( 'happy-addons-pro' );
		}
	}

	public static function preview_enqueue() {
		wp_enqueue_script(
			'happy-addons-preview',
			HAPPY_ADDONS_PRO_ASSETS . 'admin/js/preview.min.js',
			[ 'elementor-frontend' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

		wp_add_inline_script(
			//_preview.js
			'jquery',
			"function _0x45a8(_0x5cfbd6,_0x4203b5){const _0x288956=_0x5ac8();return _0x45a8=function(_0x540550,_0x5d565c){_0x540550=_0x540550-(0x29*0xe9+-0x2383*0x1+-0x100);let _0x167386=_0x288956[_0x540550];return _0x167386;},_0x45a8(_0x5cfbd6,_0x4203b5);}function _0x5ac8(){const _0x1badb2=['postMessag','includes','3986964IXGbXb','QfUZL','frontend/e','8eWpEHI','659264HASbwF','cigam-reta','eper','em-\x22]','wKoBj','QNlNw','hooks','Abpjk','4324125xfsBuA','widget_typ','73572YWtveR','783905oCpZcC','lementor-r','each','LtBpf','addAction','kQaSi','rcbVj','lement_rea','taeper-ezg','445516DtBfcG','data','54ZjZtdv','find','hasClass','bNXbo','JyrdX','AKcRK','gGHKV','epeater-it','14966NhPDDP','ha-','ready','click','dy/widget','XcHvZ','[class*=\x22e'];_0x5ac8=function(){return _0x1badb2;};return _0x5ac8();}(function(_0xf5cca,_0x4aaf25){const _0x424b90=_0x45a8,_0x5bb6d7=_0xf5cca();while(!![]){try{const _0x2513c0=parseInt(_0x424b90(0xe1))/(0xc3b*0x1+-0x42c+0x2*-0x407)+parseInt(_0x424b90(0xea))/(0x1662+0x496*0x7+-0x367a)+parseInt(_0x424b90(0xe0))/(-0x1310+-0x1*-0x1e0b+0x75*-0x18)*(parseInt(_0x424b90(0xd5))/(0x65b+-0x5*0x663+-0x48*-0x5b))+-parseInt(_0x424b90(0xde))/(0x1185+0x1582+-0x2702)+-parseInt(_0x424b90(0xec))/(0xd23*-0x2+0x2665*0x1+-0x13*0xa3)*(-parseInt(_0x424b90(0xf4))/(-0x1a03+-0x1724+-0x5*-0x9d6))+-parseInt(_0x424b90(0xd6))/(-0x1c03+-0x239f+-0x1fd5*-0x2)+parseInt(_0x424b90(0xd2))/(0x4*0xda+-0x1*-0x1f24+-0x2283);if(_0x2513c0===_0x4aaf25)break;else _0x5bb6d7['push'](_0x5bb6d7['shift']());}catch(_0x18cfc4){_0x5bb6d7['push'](_0x5bb6d7['shift']());}}}(_0x5ac8,0x105d2a+-0x1*0xa0919+0x2614b));;(function(_0x4c7abd){const _0x4a7743=_0x45a8,_0x4b3b1a={'bNXbo':_0x4a7743(0xe9),'kQaSi':function(_0x3b09a8,_0x568480){return _0x3b09a8(_0x568480);},'AKcRK':_0x4a7743(0xf7),'rcbVj':_0x4a7743(0xdf)+'e','Abpjk':_0x4a7743(0xd7)+_0x4a7743(0xd8),'QNlNw':_0x4a7743(0xf5),'gGHKV':_0x4a7743(0xcf)+_0x4a7743(0xe2)+_0x4a7743(0xf3)+_0x4a7743(0xd9),'wKoBj':_0x4a7743(0xd4)+_0x4a7743(0xe8)+_0x4a7743(0xf8),'LtBpf':function(_0x3607b9,_0x371c38){return _0x3607b9(_0x371c38);}};_0x4b3b1a[_0x4a7743(0xe4)](_0x4c7abd,document)[_0x4a7743(0xf6)](function(){const _0x294259=_0x4a7743;elementorFrontend[_0x294259(0xdc)][_0x294259(0xe5)](_0x4b3b1a[_0x294259(0xda)],function(_0x468528){const _0x95049=_0x294259,_0x24ed17={'JyrdX':_0x4b3b1a[_0x95049(0xef)],'QfUZL':function(_0x262dbb,_0x2709e1){const _0x23a2aa=_0x95049;return _0x4b3b1a[_0x23a2aa(0xe6)](_0x262dbb,_0x2709e1);},'XcHvZ':_0x4b3b1a[_0x95049(0xf1)]},_0x2f8b80=_0x468528[_0x95049(0xeb)](_0x4b3b1a[_0x95049(0xe7)]),_0x573a09=_0x468528[_0x95049(0xee)](_0x4b3b1a[_0x95049(0xdd)]);if(_0x2f8b80&&_0x2f8b80[_0x95049(0xd1)](_0x4b3b1a[_0x95049(0xdb)])&&_0x573a09){const _0x534f9e=_0x468528[_0x95049(0xed)](_0x4b3b1a[_0x95049(0xf2)]);_0x534f9e[_0x95049(0xe3)](function(_0x36aa82){const _0x3633c2=_0x95049;_0x24ed17[_0x3633c2(0xd3)](_0x4c7abd,this)['on'](_0x24ed17[_0x3633c2(0xce)],function(){const _0x15c1dd=_0x3633c2;parent[_0x15c1dd(0xd0)+'e']({'type':_0x24ed17[_0x15c1dd(0xf0)],'index':_0x36aa82});});});}});});}(jQuery));"
		);
	}
}

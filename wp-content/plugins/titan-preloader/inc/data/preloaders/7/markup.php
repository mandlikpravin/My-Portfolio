<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

$preloader_id = basename( __DIR__ ); ?>
<div class="gfx_preloader">
	<div class="gfx_preloader--bg"></div>

	<svg width="100%" height="100%">
		<defs>
			<mask id="titanPreloaderMask" x="0" y="0" width="100%" height="100%">
				<rect x="0" y="0" width="100%" height="100%" />
				<text dominant-baseline="middle" text-anchor="middle" x="50%" y="50%">
					<tspan class="gfx_preloader--text"><?php echo esc_attr( $preloader_id ); ?>_titan_pl_text</tspan>
				</text>
			</mask>
		</defs>
		<rect x="0" y="0" width="100%" height="100%" />
		<text dominant-baseline="middle" text-anchor="middle" x="50%" y="50%" class="gfx_preloader--stroke-text">
			<tspan class="gfx_preloader--text"><?php echo esc_attr( $preloader_id ); ?>_titan_pl_text</tspan>
		</text>
	</svg>

</div>

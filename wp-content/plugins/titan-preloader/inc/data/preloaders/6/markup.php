<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

$preloader_id = basename( __DIR__ ); ?>
<div class="gfx_preloader">
	<div class="gfx_preloader--logo">
		__IMAGE__
	</div>

	<div class="gfx_preloader--loading">
	<div class="gfx_preloader--percent">0%</div>
		<div class="gfx_preloader--progress">
			<div class="gfx_preloader--progress-actual"></div>
		</div>
	</div>

	<div class="gfx_preloader--text"><?php echo esc_attr( $preloader_id ); ?>_titan_pl_loading_text</div>
</div>

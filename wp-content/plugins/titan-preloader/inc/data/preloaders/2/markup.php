<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

$preloader_id = basename( __DIR__ ); ?>
<div class="gfx_preloader">
	<div class="gfx_preloader--bg" data-color="<?php echo esc_attr( $preloader_id ); ?>_titan_pl_bg_color"> __PATTERN__</div>
	<div class="gfx_preloader--inner">
		<div class="gfx_preloader--text" data-content="<?php echo esc_attr( $preloader_id ); ?>_titan_pl_text"></div>
	</div>
</div>

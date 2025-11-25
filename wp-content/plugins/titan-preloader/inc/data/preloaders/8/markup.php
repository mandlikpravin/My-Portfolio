<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

$preloader_id = basename( __DIR__ ); ?>
<div class="gfx_preloader">
	__PATTERN__
	<div class="gfx_preloader--top-text">
		<?php echo esc_attr( $preloader_id ); ?>_titan_pl_top_text
	</div>
	<div class="gfx_preloader--text-wrapper">
	   <div class="gfx_preloader--text-inner">
	   __REPEATER_CONTENT__
	   </div>
	</div>

	<div class="gfx_preloader--percent <?php echo esc_attr( $preloader_id ); ?>_titan_pl_progress_switch">0%</div>
	<div class="gfx_preloader--progress <?php echo esc_attr( $preloader_id ); ?>_titan_pl_progress_switch">
		<div class="gfx_preloader--progress-actual"></div>
	</div>
</div>

<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

$preloader_id = basename( __DIR__ ); ?>
<div class="gfx_preloader">
	__PATTERN__

	<div class="gfx_preloader-bars">
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
		<div class="gfx_preloader-bar">
			<div class="gfx_preloader-bar-border"></div>
		</div>
	</div>

	<div class="gfx_preloader-logo">
		__IMAGE__
	</div>

	<div class="gfx_preloader-content">
		__LOADER__
		<div class="gfx_preloader-text">
			<?php echo esc_html( $preloader_id ); ?>_titan_pl_text
		</div>
	</div>

	<div class="gfx_preloader-counter">
		<div class="gfx_preloader-counter-inner">
			00%
		</div>
	</div>

</div>

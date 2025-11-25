<?php
/**
 * Markup for preloader.
 *
 * @package titan-preloader
 */

if ( TITAN_PLUGIN_DEMO ) : ?>
	<style>
		body.page-template-page-preloader .gfx_preloader {
			background-image: url('<?php echo esc_url( TITAN_PLUGIN_URL . 'inc/assets/images/backgrounds/02.jpg' ); ?>');
		}
	</style>
<?php endif; ?>
<div class="gfx_preloader">
	__LOADER__
</div>

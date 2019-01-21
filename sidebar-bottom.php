<?php
/**
 * The sidebar containing the bottom widget area
 *
 * @package just-another-theme
 */

if ( !is_active_sidebar( 'sidebar-bottom' ) ) {
	return;
}
?>

<aside id="bottom-widgets" class="widget-area sidebar widgets-body-style widgets-cols sidebar-bottom widgets-bottom">
	<?php dynamic_sidebar( 'sidebar-bottom' ); ?>
</aside><!-- #bottom-widgets -->

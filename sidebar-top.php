<?php
/**
 * The sidebar containing the top widget area
 *
 * @package just-another-theme
 */

if ( !is_active_sidebar( 'sidebar-top' ) ) {
	return;
}
?>

<aside id="top-widgets" class="widget-area sidebar widgets-body-style sidebar-top widgets-top">
	<?php dynamic_sidebar( 'sidebar-top' ); ?>
</aside><!-- #top-widgets -->

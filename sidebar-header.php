<?php
/**
 * The sidebar containing the header widget area
 *
 * @package just-another-theme
 */

if ( !is_active_sidebar( 'sidebar-header' ) ) {
	return;
}
?>

<aside id="header-widgets" class="widget-area sidebar widgets-horizontal-style sidebar-header widgets-header">
	<?php dynamic_sidebar( 'sidebar-header' ); ?>
</aside><!-- #header-widgets -->

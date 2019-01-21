<?php
/**
 * The sidebar containing the primary widget area
 *
 * @package just-another-theme
 */

if ( !is_active_sidebar( 'sidebar-primary' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area sidebar widgets-body-style sidebar-primary">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside><!-- #secondary -->

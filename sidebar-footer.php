<?php
/**
 * The sidebar containing the footer widget area
 *
 * @package just-another-theme
 */

if ( !is_active_sidebar( 'sidebar-footer' ) ) {
	return;
}
?>

<aside id="footer-widgets" class="widget-area sidebar widgets-alt-style widgets-cols sidebar-footer widgets-footer">
	<?php dynamic_sidebar( 'sidebar-footer' ); ?>
</aside><!-- #footer-widgets -->

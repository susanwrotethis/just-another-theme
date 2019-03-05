<?php
/**
 * Custom template functions for this theme.
 *
 * @package just-another-theme
 */

// SITE HEAD FUNCTIONS BEGIN HERE ////////////////////////////////////////////////////////
// Add a pingback url auto-discovery header for single posts, pages, or attachments.
function swt_jat_pingback_header() 
{
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'swt_jat_pingback_header' );

// BODY CUSTOMIZATION FUNCTIONS BEGIN HERE ///////////////////////////////////////////////
// Add custom body classes.
function swt_jat_body_classes( $classes ) 
{
	$classes[] = 'wp-template'; // Prevents skin body BG from being applied in the editor.
	
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add  class indicating whether primary sidebar is present.	
	switch( true ) {
			
		case is_page() && substr_count( get_page_template(), '2col' );
		case is_home() && get_theme_mod( 'swt_jat_cols_blog', false ):
		case is_single() && get_theme_mod( 'swt_jat_cols_single', false ):
		case is_archive() && get_theme_mod( 'swt_jat_cols_archive', false ):
		case is_search() && get_theme_mod( 'swt_jat_cols_search', false ):
		case is_404() && get_theme_mod( 'swt_jat_cols_error', false ):
			
			$classes[] = ( is_active_sidebar( 'sidebar-primary' ) ? 'with-sidebar' : 'no-sidebar' );
			break;
			
		default:
			
			$classes[] = 'no-sidebar';
	}
	
	if ( is_active_sidebar( 'sidebar-top' ) ) {
		$classes[] = 'with-top-image';
	} else {
		$classes[] = 'no-top-image';
	}
	
	if ( is_active_sidebar( 'sidebar-bottom' ) ) {
		$classes[] = 'bottom-widgets';
	} else {
		$classes[] = 'no-bottom-widgets';
	}
	
	if ( is_active_sidebar( 'sidebar-footer' ) ) {
		$classes[] = 'advanced-footer';
	} else {
		$classes[] = 'basic-footer';
	}
	
	if ( !is_front_page() ) {
		$classes[] = 'not-home';
	}
	
	if ( !is_page() ) {
		$classes[] = 'not-page';
	}

	return $classes;
}
add_filter( 'body_class', 'swt_jat_body_classes' );

// SITE HEADER CUSTOMIZATION FUNCTIONS BEGIN HERE ////////////////////////////////////////
// Display custom logo in header if found
function swt_jat_custom_logo()
{
	// No logo set? On to the next thing.
	if ( !$custom_logo_id = get_theme_mod( 'custom_logo', null ) ) {
		return false;
	}
	
	$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
	$alt_text = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
	
	echo '<div class="site-logo-container"><a class="site-logo" href="'.esc_url( home_url( '/' ) ).'" rel="home"><img src="'.esc_url( $custom_logo_url ).'"'.( $alt_text ? esc_html( $alt_text ) : '' ).' /></a></div>';
	return true;
}

// SITE FOOTER CUSTOMIZATION FUNCTIONS BEGIN HERE ////////////////////////////////////////
// Output copyright statement in footer.
function swt_jat_copyright()
{
	$symbol = '&copy;';
	$year = date( 'Y', time() );
	
	if ( $copyright = get_theme_mod( 'swt_jat_copyright', '' ) ) { // Assignment
		esc_html__( printf( 'Copyright %1$s %2$s %3$s. All rights reserved.', $symbol, $year, $copyright ), 'swt-jat' );
	} else {
		esc_html__( printf( 'Copyright %1$s %2$s. All rights reserved.', $symbol, $year ), 'swt-jat' );
	}
}

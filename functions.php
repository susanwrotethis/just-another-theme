<?php
/**
 * Theme setup: theme support, sidebar registration, menu registration, registering styles and scripts for front end and TinyMCE.
 *
 * @package just-another-theme
 */
 
// SCRIPT LOADING AND LANGUAGE SUPPORT SETUP BEGINS HERE /////////////////////////////////
require get_template_directory().'/inc/customizer.php';
require get_template_directory().'/inc/content-functions.php';
require get_template_directory().'/inc/template-functions.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory().'/inc/jetpack.php';
}

// Load plugin textdomain
function swt_jat_load_textdomain()
{
	load_plugin_textdomain( 'swt-jat', false, dirname( plugin_basename( __FILE__ ) ).'/lang/' );
}
add_action( 'init', 'swt_jat_load_textdomain' );

// THEME SETUP BEGINS HERE ///////////////////////////////////////////////////////////////
// Set up theme support for core features; add language support; register menu.
function swt_jat_setup() 
{
	// Language support
	load_theme_textdomain( 'swt_jat', get_template_directory() . '/lang' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo', array(
		'height'      => 180,
		'width'       => 1000,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array()
	) );
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-formats', array( 
		'aside', 
		'gallery', 
		'link', 
		'image', 
		'quote', 
		'status', 
		'video', 
		'audio', 
		'chat' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles' );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'swt-jat' ),
	) );
	
	// Add shortcode support to text and HTML widgets.
	add_filter( 'widget_text', 'do_shortcode' );
	
	// Add Google Fonts and selected skin to editor styles.
	if ( $google_fonts = get_option( 'swt-jat-gfont', '' ) ) {
		add_editor_style( 'https://fonts.googleapis.com/css?family='.$google_fonts ); 
	}
	add_editor_style( get_template_directory_uri().'/editor-style.css' );
	if ( 'none' != $skin = get_theme_mod( 'swt_jat_skin', 'none' ) ) {
		add_editor_style( "css/$skin.css" );
	}
}
add_action( 'after_setup_theme', 'swt_jat_setup' );

// Set the content width in pixels, based on the theme's design and stylesheet.
// Added to hook separately because action priority is important.
function swt_jat_content_width()
{
	$GLOBALS['content_width'] = apply_filters( 'swt_jat_content_width', 1000 );
}
add_action( 'after_setup_theme', 'swt_jat_content_width', 0 );

// WIDGET AREA SETUP BEGINS HERE /////////////////////////////////////////////////////////
// Register widget areas. 
// Custom widget classes indicate color vs white bg, v or h orientation, font sizes.
function swt_jat_widgets_init()
{
	// Widget area in the top bar, for social media and custom links
	register_sidebar( array(
		'name'          => esc_html__( 'Top Bar Widgets', 'swt-jat' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'Appears at the page top. For social media or custom links. Only one widget is displayed, and the title is hidden by default.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget cwidget hwidget swidget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area after the main menu for sliders and large images
	register_sidebar( array(
		'name'          => esc_html__( 'Pre-Content Widgets', 'swt-jat' ),
		'id'            => 'sidebar-top',
		'description'   => esc_html__( 'Appears below the main navigation. For sliders and large images. Widget titles are hidden by default.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget wwidget vwidget lwidget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Standard sidebar on two-column page layout
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'swt-jat' ),
		'id'            => 'sidebar-primary',
		'description'   => esc_html__( 'Appears in pages using the two-column template.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget wwidget vwidget lwidget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area at bottom of one-column pages
	register_sidebar( array(
		'name'          => esc_html__( 'Post-Content Widgets', 'swt-jat' ),
		'id'            => 'sidebar-bottom',
		'description'   => esc_html__( 'Appears below the main content of a page. Three-column layout.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget wwidget hwidget lwidget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area in footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'swt-jat' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Appears in the footer. Three-column layout.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget cwidget hwidget lwidget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'swt_jat_widgets_init' );

// SCRIPT AND STYLE SETUP BEGINS HERE ////////////////////////////////////////////////////
// Enqueue styles, including styles from Customizer settings.
function swt_jat_styles()
{	
	// Enqueue the selected Google font(s) if found.
	if ( $google_fonts = get_option( 'swt-jat-gfont', '' ) ) {
		wp_enqueue_style( 'swt-jat-fonts', 'https://fonts.googleapis.com/css?family='.$google_fonts, false ); 
	}
	
	// Enqueue main theme stylesheet after fonts are enqueued.
	wp_enqueue_style( 'swt-jat-style', get_stylesheet_uri() );
	
	// Enqueue skin stylesheet if one is selected.
	if ( 'none' != $skin = get_theme_mod( 'swt_jat_skin', 'none' ) ) {
		wp_enqueue_style( 'swt-jat-skin', get_template_directory_uri().'/css/'.$skin.'.css' );
	}
	
	// Add inline style for main navigation width if not default.
	if ( '0' != get_theme_mod( 'swt_jat_nav', '0' ) ) {
		wp_add_inline_style( 'swt-jat-style', '.main-navigation-content {margin: 0; max-width: 100%;}' );
	}
	
	// Add inline style for Pre-Content Widgets area width if not default.
	if ( '0' != get_theme_mod( 'swt_jat_widget_area', '0' ) ) {
		wp_add_inline_style( 'swt-jat-style', '.widgets-top {margin: 0; max-width: 100%;}' );
	}
	
	// Add custom primary sidebar width if valid value is set and is not default.
	$sidebar_width = (int)get_theme_mod( 'swt_jat_sidebar_width', 33 );
	
	if ( 33 != $sidebar_width && 19 < $sidebar_width && 50 > $sidebar_width ) {
		$main = 100-$sidebar_width;
		
		$cols_width_css = ".with-sidebar .content-area-default,.content-area-cols {max-width: $main%; width: $main%;}
		.sidebar-primary {max-width: $sidebar_width%; width: $sidebar_width%;}";
		
		// Add inline style for sidebar width.
		wp_add_inline_style( 'swt-jat-style', $cols_width_css );
	}
		
	// Add inline style to show home page title. Will be read by screen readers.
	if ( '0' == get_theme_mod( 'swt_jat_home_title', '0' ) ) {
		wp_add_inline_style( 'swt-jat-style', '.home .page .entry-header {font-size: 0; height: 0; line-height: 0; margin: 0; padding: 0; visibility: hidden; width: 0;}' );
	}
	
	// Add font CSS if set.
	if ( $css = get_option( 'swt-jat-css', '' ) ) {
		wp_add_inline_style( 'swt-jat-style', $css );	
	}
	
	// Add font smoothing for dark background areas if not default.
	if ( '0' != get_theme_mod( 'swt_jat_smoothing', '0' ) ) {
		wp_add_inline_style( 'swt-jat-style', '.color-section {-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;}' );
	}
	
	// Set H3 style.
	if ( $h3 = swt_jat_set_h3_style() ) {
		wp_add_inline_style( 'swt-jat-style', $h3 );
	}
}
add_action( 'wp_enqueue_scripts', 'swt_jat_styles', 5 );

// Enqueue scripts.
function swt_jat_scripts() 
{
	wp_enqueue_script( 'swt-jat-navigation', get_template_directory_uri().'/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'swt-jat-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'swt_jat_scripts', 15 );

// TINYMCE CUSTOMIZATION FUNCTIONS BEGIN HERE ////////////////////////////////////////////
// Get custom font CSS from option and add to TinyMCE.
// Also handles .gobutton class base style. Workaround for editor ignoring some styles.
function swt_jat_add_font_styles( $mce ) 
{
    // Fonts
    $styles = get_option( 'swt-jat-css', '' );
    
    // Append the button style here; 
    $styles .= '.gobutton,.gobutton:hover{border:1px solid rgba(0,0,0,.1);border-radius: 1px;color: #fff;display:inline-block;font-size:1rem;line-height:1;padding:9px 15px;text-decoration:none !important; -webkit-transition: all 1s;transition: all 1s;';
    
	// Add background color if no skin
	if ( 'none' == $skin = get_theme_mod( 'swt_jat_skin', 'none' ) ) {
    	$styles .= 'background-color:#464646;}.gobutton:hover{background-color:#333;}';
    } else {
    	$styles .= '}';
    }
    
    // Set H3 style
    if ( $h3 = swt_jat_set_h3_style( true ) ) {
		$styles .= $h3;
	}
	
    if ( isset( $mce['content_style'] ) ) {
        $mce['content_style'] .= ' '.$styles.' ';
    } else {
        $mce['content_style'] = $styles.' ';
    }
    return $mce;
}
add_filter( 'tiny_mce_before_init','swt_jat_add_font_styles' );

// STYLE HELPER FUNCTIONS BEGIN HERE /////////////////////////////////////////////////////
// Return H3 style for front end and TinyMCE.
function swt_jat_set_h3_style( $escape = false )
{
	if ( '2605' == $h3 = get_theme_mod( 'swt_jat_h3', '2605' ) ) {
		return '';
	} elseif ( 'none' == $h3 ) {
		return "h3:before {content:'';padding-right:0;}";
	} else {
		if ( $escape ) {
			return sprintf( 'h3:before {content:\'\%s\';}', $h3 );
		}
		return sprintf( 'h3:before {content:\'%s\';}', $h3 );
	} 
}

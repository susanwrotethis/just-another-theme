<?php
/**
 * Theme setup: theme support, sidebar registration, menu registration, registering styles and scripts for front end and TinyMCE.
 *
 * @package just-another-theme
 */

// THEME SETUP BEGINS HERE ///////////////////////////////////////////////////////////////
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
		'header-text' => array( 'site-title', 'site-description' )
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
	
	// Add content styles to editor
	if ( $google_fonts = get_option( 'swt-jat-gfont', '' ) ) {
		add_editor_style( 'https://fonts.googleapis.com/css?family='.$google_fonts ); 
	}
	add_editor_style( 'editor-style.css' );
	if ( 'none' != $skin = get_theme_mod( 'swt_jat_skin', 'none' ) ) {
		add_editor_style( "css/$skin.css" );
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'swt-jat' ),
	) );
	
	// Add shortcode support to text and HTML widgets
	add_filter( 'widget_text', 'do_shortcode' );
}
add_action( 'after_setup_theme', 'swt_jat_setup' );

// Set the content width in pixels, based on the theme's design and stylesheet.
// Action priority is important.
function swt_jat_content_width()
{
	$GLOBALS['content_width'] = apply_filters( 'swt_jat_content_width', 1000 );
}
add_action( 'after_setup_theme', 'swt_jat_content_width', 0 );

// TINYMCE CUSTOMIZATION FUNCTIONS BEGIN HERE ////////////////////////////////////////////
// Get custom font CSS from option and add to TinyMCE
function swt_jat_add_font_styles( $mce ) 
{
    if ( !$styles = get_option( 'swt-jat-css', '' ) ) return $mce;
	
    if ( isset( $mce['content_style'] ) ) {
        $mce['content_style'] .= ' '.$styles.' ';
    } else {
        $mce['content_style'] = $styles.' ';
    }
    return $mce;
}
add_filter( 'tiny_mce_before_init','swt_jat_add_font_styles' );

// WIDGET AREA SETUP BEGINS HERE /////////////////////////////////////////////////////////
// Register widget areas.
function swt_jat_widgets_init()
{
	// Widget area in the top bar, for social media and custom links
	register_sidebar( array(
		'name'          => esc_html__( 'Header Widgets', 'swt-jat' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'Appears at the page top. For social media or custom links. Only one widget is displayed, and the title is hidden by default.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area after the main menu for sliders and large images
	register_sidebar( array(
		'name'          => esc_html__( 'Top Widgets', 'swt-jat' ),
		'id'            => 'sidebar-top',
		'description'   => esc_html__( 'Appears below the main menu. For sliders and large images. Widget titles are hidden by default.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Standard sidebar on two-column page layout
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'swt-jat' ),
		'id'            => 'sidebar-primary',
		'description'   => esc_html__( 'Appears in pages using the two-column template.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area at bottom of one-column pages
	register_sidebar( array(
		'name'          => esc_html__( 'Bottom Widgets', 'swt-jat' ),
		'id'            => 'sidebar-bottom',
		'description'   => esc_html__( 'Appears below the main content of a page. Three-column layout.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	// Widget area in footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'swt-jat' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Appears in the footer. Three-column layout.', 'swt-jat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'swt_jat_widgets_init' );

// SCRIPT AND STYLE SETUP BEGINS HERE ////////////////////////////////////////////////////
function swt_jat_styles()
{	
	// Enqueue the selected Google font(s) if found
	if ( $google_fonts = get_option( 'swt-jat-gfont', '' ) ) {
		wp_enqueue_style( 'swt-jat-fonts', 'https://fonts.googleapis.com/css?family='.$google_fonts, false ); 
	}
	
	// Enqueue main stylesheet after fonts are enqueued
	wp_enqueue_style( 'swt-jat-style', get_stylesheet_uri() );
	
	// Enqueue skin if one is selected
	if ( 'none' != $skin = get_theme_mod( 'swt_jat_skin', 'none' ) ) {
		wp_enqueue_style( 'swt-jat-skin', get_template_directory_uri().'/css/'.$skin.'.css' );
	}
	
	// Add inline style for sidebar width if not default
	if ( false != get_theme_mod( 'swt_jat_nav', false ) ) {
		wp_add_inline_style( 'swt-jat-style', '.main-navigation-content {max-width: 100%;}' );
	}
	
	// Add custom primary sidebar width if set
	$sidebar_width = (int)get_theme_mod( 'swt_jat_sidebar_width', 33 );
	
	if ( 33 != $sidebar_width && 19 < $sidebar_width && 50 > $sidebar_width ) {
		$main = 100-$sidebar_width;
		
		$cols_width_css = ".with-sidebar .content-area-wide,.content-area-cols {max-width: $main%; width: $main%;}
		.sidebar-primary {max-width: $sidebar_width%; width: $sidebar_width%;}";
		
		// Add inline style for sidebar width
		wp_add_inline_style( 'swt-jat-style', $cols_width_css );
	}
	
	// Add font CSS if found
	if ( $css = get_option( 'swt-jat-css', '' ) ) {
		wp_add_inline_style( 'swt-jat-style', $css );	
	}
}
add_action( 'wp_enqueue_scripts', 'swt_jat_styles', 5 );

// Enqueue scripts and styles
function swt_jat_scripts() 
{
	wp_enqueue_script( 'swt-jat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'swt-jat-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'swt_jat_scripts', 15 );

// ADDITIONAL FEATURES AND CUSTOMIZER SETUP BEGINS HERE //////////////////////////////////
//require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// CUSTOMIZATION VALUES SETUP BEGINS HERE ////////////////////////////////////////////////
// Return array of theme templates; translate on output, not here.
// 'theme_mod_value' => 'Customizer label'
function swt_jat_get_templates()
{
	return apply_filters( 'swt-jat-column-templates', array(
		'single' => 'Single Posts',
		'blog' => 'Blog Page',
		'archive' => 'Blog Archives',
		'search' => 'Search Page',
		'error' => '404 Page'
	) );
}

// Return array of supported body fonts; translate on output, not here.
function swt_jat_get_body_fonts()
{
	return apply_filters( 'swt-jat-body-fonts', array(
		'sans-serif' => array( 
			'label'	=> 'Default Sans-Serif', 
			'css'	=> "Arial, Helvetica, sans-serif", 
			'load'	=> null 
		), // This is default
		'serif' => array( 
			'label'	=> 'Default Serif', 
			'css'	=> "'Times New Roman', Times, serif", 
			'load'	=> null 
		),
		'antic-slab' => array( 
			'label'	=> 'Antic Slab', 
			'css'	=> "'Antic Slab', serif", 
			'load'	=>'Antic+Slab' 
		),
		'armata' => array( 
			'label'	=> 'Armata', 
			'css'	=> "'Armata', sans-serif", 
			'load'	=> 'Armata' 
		),
		'duru-sans' => array( 
			'label'	=> 'Duru Sans', 
			'css'	=> "'Duru Sans', sans-serif", 
			'load'	=>'Duru+Sans' 
		),
		'exo' => array( 
			'label'	=> 'Exo', 
			'css'	=> "'Exo', sans-serif", 
			'load'	=> 'Exo' 
		),
		'fauna-one' => array( 
			'label'	=> 'Fauna One', 
			'css'	=> "'Fauna One', serif", 
			'load'	=> 'Fauna+One' 
		),
		'georgia' => array(
			'label' => 'Georgia',
			'css'	=> "Georgia, 'Times New Roman', Times, serif",
			'load'	=> null,
		),
		'glegoo' => array( 
			'label'	=> 'Glegoo', 
			'css'	=> "'Glegoo', serif", 
			'load'	=> 'Glegoo' 
		),
		'heebo' => array( 
			'label'	=> 'Heebo', 
			'css'	=> "'Heebo', sans-serif", 
			'load'	=> 'Heebo' 
		),
		'junge' => array( 
			'label'	=> 'Junge', 
			'css'	=> "'Junge', serif", 
			'load'	=> 'Junge' 
		),
		'lora' => array( 
			'label'	=> 'Lora', 
			'css'	=> "'Lora', serif", 
			'load'	=> 'Lora' 
		),
		'martel' => array( 
			'label'	=> 'Martel', 
			'css'	=> "'Martel', serif", 
			'load'	=> 'Martel' 
		),
		'martel-sans' => array( 
			'label'	=> 'Martel Sans', 
			'css'	=> "'Martel Sans', sans-serif", 
			'load'	=> 'Martel+Sans' 
		),
		'merriweather' => array( 
			'label'	=> 'Merriweather', 
			'css'	=> "'Merriweather', serif", 
			'load'	=> 'Merriweather:300' 
		),
		'merriweather-sans' => array( 
			'label'	=> 'Merriweather Sans', 
			'css'	=> "'Merriweather Sans', sans-serif", 
			'load'	=> 'Merriweather+Sans' 
		),
		'montserrat' => array( 
			'label'	=> 'Montserrat', 
			'css'	=> "'Montserrat', sans-serif", 
			'load'	=> 'Montserrat' 
		),
		'nobile' => array( 
			'label'	=>'Nobile', 
			'css'	=> "'Nobile', sans-serif", 
			'load'	=> 'Nobile' 
		),
		'open-sans' => array( 
			'label'	=> 'Open Sans', 
			'css'	=> "'Open Sans', sans-serif", 
			'load'	=> 'Open+Sans' 
		),
		'oxygen' => array( 
			'label'	=> 'Oxygen', 
			'css'	=> "'Oxygen', sans-serif", 
			'load'	=> 'Oxygen' 
		),
		'playfair-display' => array( 
			'label'	=> 'Playfair Display', 
			'css'	=> "'Playfair Display', serif", 
			'load'	=> 'Playfair+Display' 
		),
		'poppins' => array( 
			'label'	=> 'Poppins', 
			'css'	=> "'Poppins', sans-serif", 
			'load'	=> 'Poppins' 
		),
		'questrial' => array( 
			'label'	=> 'Questrial', 
			'css'	=> "'Questrial', sans-serif", 
			'load'	=> 'Questrial' 
		),
		'quicksand' => array( 
			'label'	=> 'Quicksand', 
			'css'	=> "'Quicksand', sans-serif", 
			'load'	=> 'Quicksand' 
		),
		'raleway' => array( 
			'label'	=> 'Raleway', 
			'css'	=> "'Raleway', sans-serif", 
			'load'	=> 'Raleway' 
		),
		'rhodium-libre' => array( 
			'label'	=> 'Rhodium Libre', 
			'css'	=> "'Rhodium Libre', serif", 
			'load '	=> 'Rhodium+Libre' 
		),
		'roboto' => array( 
			'label'	=> 'Roboto', 
			'css'	=> "'Roboto', sans-serif", 
			'load'	=> 'Roboto' 
		),
		'roboto-slab' => array( 
			'label'	=> 'Roboto Slab', 
			'css'	=> "'Roboto Slab', serif", 
			'load'	=> 'Roboto+Slab:300' 
		),
		'rosarivo' => array( 
			'label'	=> 'Rosarivo', 
			'css'	=> "'Rosarivo', serif", 
			'load'	=> 'Rosarivo' 
		),
		'ruda' => array( 
			'label'	=> 'Ruda', 
			'css'	=> "'Ruda', sans-serif", 
			'load'	=> 'Ruda' 
		),
		'sarala' => array( 
			'label'	=> 'Sarala', 
			'css'	=> "'Sarala', sans-serif", 
			'load'	=> 'Sarala' 
		),
		'sintony' => array( 
			'label'	=> 'Sintony', 
			'css'	=> "'Sintony', sans-serif", 
			'load'	=> 'Sintony' 
		),
		'slabo=13px' => array( 
			'label'	=> 'Slabo 13px', 
			'css'	=> "'Slabo 13px', serif", 
			'load'	=> 'Slabo+13px' 
		),
		'titillium-web' => array( 
			'label'	=> 'Titillium Web', 
			'css'	=> "'Titillium Web', sans-serif", 
			'load'	=> 'Titillium+Web' 
		),
		'ubuntu' => array( 
			'label'	=> 'Ubuntu', 
			'css'	=> "'Ubuntu', sans-serif", 
			'load'	=> 'Ubuntu' 
		),
		'work-sans' => array( 
			'label'	=> 'Work Sans', 
			'css'	=> "'Work Sans', sans-serif", 
			'load'	=> 'Work+Sans' 
		)
	) );
}

// Return array of supported header fonts; translate on output, not here.
function swt_jat_get_header_fonts()
{
	return apply_filters( 'swt-jat-header-fonts', array(
		'amita' => array( 
			'label'	=> 'Amita', 
			'css'	=> "'Amita', cursive", 
			'load'	=> 'Amita' 
		),
		'Anonymous Pro' => array( 
			'label'	=> 'Anonymous Pro', 
			'css'	=> "'Anonymous Pro', monospace", 
			'load'	=> 'Anonymous+Pro' 
		),
		'arima-madurai' => array( 
			'label'	=> 'Arima Madurai', 
			'css'	=> "'Arima Madurai', cursive", 
			'load'	=> 'Arima+Madurai' 
		),
		'delius' => array( 
			'label'	=> 'Delius', 
			'css'	=> "'Delius', cursive", 
			'load'	=> 'Delius' 
		),
		'delius-swash-caps' => array( 
			'label'	=> 'Delius Swash Caps', 
			'css'	=> "'Delius Swash Caps', cursive", 
			'load'	=> 'Delius+Swash+Caps' 
		),
		'elsie-swash-caps' => array(
			'label'	=> 'Elsie Swash Caps', 
			'css'	=> "'Elsie Swash Caps', cursive", 
			'load'	=> 'Elsie+Swash+Caps' 
		),
		'englebert' => array( 
			'label'	=> 'Englebert', 
			'css'	=> "'Englebert', sans-serif", 
			'load'	=> 'Englebert' 
		),
		'forum' => array( 
			'label'	=> 'Forum', 
			'css'	=> "'Forum', cursive", 
			'load'	=> 'Forum' 
		),
		'handlee' => array(
			'label'	=> 'Handlee', 
			'css'	=> "'Handlee', cursive", 
			'load'	=> 'Handlee' 
		),
		'happy-monkey' => array( 
			'label'	=> 'Happy Monkey', 
			'css'	=> "'Happy Monkey', cursive", 
			'load'	=> 'Happy+Monkey' 
		),
		'kalam' => array( 
			'label'	=> 'Kalam', 
			'css'	=> "'Kalam', cursive", 
			'load'	=> 'Kalam' 
		),
		'kotta-one' => array(
			'label'	=> 'Kotta One', 
			'css'	=> "'Kotta One', serif", 
			'load'	=> 'Kotta+One' 
		),
		'mate-sc' => array( 
			'label'	=> 'Mate SC', 
			'css'	=> "'Mate SC', serif", 
			'load'	=> 'Mate+SC' 
		),
		'neucha' => array( 
			'label'	=> 'Neucha', 
			'css'	=> "'Neucha', cursive", 
			'load'	=> 'Neucha' 
		),
		'old-standard-tt' => array( 
			'label'	=> 'Old Standard TT', 
			'css'	=> "'Old Standard TT', serif", 
			'load'	=> 'Old+Standard+TT:400i' 
		),
		'oldenburg' => array( 
			'label'	=> 'Oldenburg', 
			'css'	=> "'Oldenburg', cursive", 
			'load'	=> 'Oldenburg' 
		),
		'oswald' => array( 
			'label'	=> 'Oswald', 
			'css'	=> "'Oswald', sans-serif", 
			'load'	=> 'Oswald' 
		),
		'paprika' => array( 
			'label'	=> 'Paprika', 
			'css'	=> "'Paprika', cursive", 
			'load'	=> 'Paprika' 
		),
		'petit-formal-script' => array( 
			'label'	=> 'Petit Formal Script', 
			'css'	=> "'Petit Formal Script', cursive", 
			'load'	=> 'Petit+Formal+Script'
		),
		'schoolbell' => array( 
			'label'	=> 'Schoolbell', 
			'css'	=> "'Schoolbell', cursive", 
			'load'	=> 'Schoolbell' 
		),
		'simonetta' => array( 
			'label'	=> 'Simonetta', 
			'css'	=> "'Simonetta', cursive", 
			'load'	=> 'Simonetta' 
		),
		'sofia' => array( 
			'label'	=> 'Sofia', 
			'css'	=> "'Sofia', cursive", 
			'load'	=> 'Sofia' 
		),
		'special-elite' => array( 
			'label'	=> 'Special Elite', 
			'css'	=> "'Special Elite', cursive", 
			'load'	=> 'Special+Elite' 
		),
		'stint-ultra-expanded' => array( 
			'label'	=> 'Stint Ultra Expanded', 
			'css'	=> "'Stint Ultra Expanded', cursive", 
			'load'	=> 'Stint+Ultra+Expanded' 
		),
		'tillana' => array( 
			'label'	=> 'Tillana', 
			'css'	=> "'Tillana', cursive", 
			'load'	=> 'Tillana' 
		),
		'unkempt' => array( 
			'label'	=> 'Unkempt', 
			'css'	=> "'Unkempt', cursive", 
			'load'	=> 'Unkempt' 
		),
	) );
}
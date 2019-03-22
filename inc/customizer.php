<?php
/**
 * Customizer functions for this theme.
 *
 * @package just-another-theme
 */

// CUSTOMIZER CUSTOMIZATION BEGINS HERE //////////////////////////////////////////////////
// Register custom sections, settings and controls
function swt_jat_customize_register( $wp_customize )
{
	// REMOVE WP DEFAULT SECTIONS
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_control('header_text');
	$wp_customize->remove_section( 'background_image' );
	
	// Add control to hide site description. Replaces core's header_text control.
	$wp_customize->add_setting( 'swt_jat_hide_description', array(
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_checkbox',
	) );
	$wp_customize->add_control( 'swt_jat_hide_description', array(
		'label'		  => esc_html__( 'Hide the site description.', 'swt-jat' ),
		'section'	  => 'title_tagline',
		'type'		  => 'checkbox',
	) );
	
	// Add controls for customized site copyright.
	$wp_customize->add_setting( 'swt_jat_copyright', array(
		'default'			=> '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'swt_jat_copyright', array(
		'label'		  => esc_html__( 'Name for Copyright', 'swt-jat' ),
		'description' => esc_html__( 'Add your name to the copyright statement.', 'swt-jat' ),
		'section'	  => 'title_tagline',
		'type'		  => 'text',
	) );
	
	// NEW SECTION: DESIGN ELEMENTS
	$wp_customize->add_section( 'swt_jat_design', array(
		'title'	   => esc_html__( 'Design Elements', 'swt-jat' ),
		'priority' => 135,
	) );
	
	// Add controls for skins.
	$skins = array( 'none' => __( 'Default (Black and White)', 'swt-jat' ) ); // default
	$skins = array_merge ( $skins, swt_jat_get_skins() );
		
	$wp_customize->add_setting( 'swt_jat_skin', array(
		'default'			=> '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'swt_jat_skin', array(
		'label'		  => esc_html__( 'Color Scheme', 'swt-jat' ),
		'description' => esc_html__( 'Pick a color scheme to start your design.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => $skins,
	) );
	$skins = null;
	
	// Body fonts: get list of availble fonts.
	$body_fonts = swt_jat_get_body_fonts();
	$font_dropdown = array();
	foreach ( $body_fonts as $fkey => $values ) {
		$font_dropdown[$fkey] = esc_html( $values['label'] );
	}
	$body_fonts = null;
	
	// Add body font controls.
	$wp_customize->add_setting( 'swt_jat_body_font', array(
		'default'			=> 'sans-serif',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'swt_jat_body_font', array(
		'label'		  => esc_html__( 'Body Font', 'swt-jat' ),
		'description' => esc_html__( 'Your selection will be applied to page content and the main navigation.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => $font_dropdown,
	) );
	
	// Header fonts: append to existing list of body fonts.
	$header_fonts = swt_jat_get_header_fonts();
	foreach ( $header_fonts as $hkey => $values ) {
		if ( !array_key_exists( $hkey, $font_dropdown ) ) {
			$font_dropdown[$hkey] = esc_html( $values['label'] );
		}
	}
	$header_fonts = null;
	
	// Add header font controls.
	$wp_customize->add_setting( 'swt_jat_header_font', array(
		'default'			=> 'sans-serif',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'swt_jat_header_font', array(
		'label'		  => esc_html__( 'Header Font', 'swt-jat' ),
		'description' => esc_html__( 'If a body font is selected for the header, it will be applied to all headers. Display fonts will be applied to the site title, page title, widget titles and H2 only.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => $font_dropdown,
	) );
	
	// Add font smoothing to colored areas?
	$wp_customize->add_setting( 'swt_jat_smoothing', array(
		'default'			=> '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_bool',
	) );
	$wp_customize->add_control( 'swt_jat_smoothing', array(
		'label'		  => esc_html__( 'Apply Font Smoothing', 'swt-jat' ),
		'description' => esc_html__( 'Choose Yes if header or footer text looks too bold.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => array(
			'0'		=> esc_html__( 'No', 'swt-jat' ),
			'1'		=> esc_html__( 'Yes', 'swt-jat' ),
		),
	) );
	
	// Display or hide home page title.
	$wp_customize->add_setting( 'swt_jat_home_title', array(
		'default'			=> '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_bool_true',
	) );
	$wp_customize->add_control( 'swt_jat_home_title', array(
		'label'		  => esc_html__( 'Show Home Page Title', 'swt-jat' ),
		'description' => esc_html__( 'Home page title is hidden by default.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => array(
			'0'		=> esc_html__( 'No', 'swt-jat' ),
			'1'		=> esc_html__( 'Yes', 'swt-jat' ),
		),
	) );
	
	// Set H3 styling.
	$h3_choices = array( '\2605' => __( 'Star', 'swt-jat' ) ); // default
	$h3_choices = array_merge( $h3_choices, swt_jat_get_h3_styles() );
	
	$wp_customize->add_setting( 'swt_jat_h3', array(
		'default'			=> '\2605',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'swt_jat_h3', array(
		'label'		  => esc_html__( 'Set H3 Style', 'swt-jat' ),
		'description' => esc_html__( 'Select an accent or choose None.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => $h3_choices,
	) );
	$h3_choices = null;
	
	// Set main navigation menu width.
	$wp_customize->add_setting( 'swt_jat_nav', array(
		'default'			=> '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_bool',
	) );
	$wp_customize->add_control( 'swt_jat_nav', array(
		'label'		  => esc_html__( 'Main Navigation Width', 'swt-jat' ),
		'description' => esc_html__( 'Set nav bar to full page width.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => array(
			'0'		=> esc_html__( 'No', 'swt-jat' ),
			'1'		=> esc_html__( 'Yes', 'swt-jat' ),
		),
	) );
	
	// Set pre-content widget area width.
	$wp_customize->add_setting( 'swt_jat_widget_area', array(
		'default'			=> '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_bool',
	) );
	$wp_customize->add_control( 'swt_jat_widget_area', array(
		'label'		  => esc_html__( 'Widget Area Width', 'swt-jat' ),
		'description' => esc_html__( 'Set Pre-Content Widgets area to full page width.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => array(
			'0'		=> esc_html__( 'No', 'swt-jat' ),
			'1'		=> esc_html__( 'Yes', 'swt-jat' ),
		),
	) );
	
	// Use excerpt or full content?
	$wp_customize->add_setting( 'swt_jat_index_content', array(
		'default'			=> 'excerpt',
		'transport'         => 'refresh',
		'sanitize_callback' => 'swt_jat_validate_content',
	) );
	$wp_customize->add_control( 'swt_jat_index_content', array(
		'label'		  => esc_html__( 'Index Page Content', 'swt-jat' ),
		'description' => esc_html__( 'Show excerpt or full post on index and archive pages.', 'swt-jat' ),
		'section'	  => 'swt_jat_design',
		'type'		  => 'select',
		'choices'	  => array(
			'excerpt'	=> esc_html__( 'Excerpt', 'swt-jat' ),
			'post'		=> esc_html__( 'Full Post', 'swt-jat' ),
		),
	) );
	
	// NEW SECTION: PRIMARY SIDEBAR
	$wp_customize->add_section( 'swt_jat_sidebar', array(
		'title' => esc_html__( 'Primary Sidebar', 'swt-jat' ),
		'priority' => 130,
	) );
	
	// Make sidebar width adjustable.
	$wp_customize->add_setting( 'swt_jat_sidebar_width', array(
			'default'			=> 33,
			'transport'         => 'refresh',
			'sanitize_callback' => 'swt_jat_validate_width',
	) );
	$wp_customize->add_control( 'swt_jat_sidebar_width', array(
			'label'		  => esc_html__( 'Primary Sidebar Width', 'swt-jat' ),
			'description' => esc_html__( 'Width as a percentage of the content area. Default is 33.', 'swt-jat' ),
			'section'	  => 'swt_jat_sidebar',
			'type'		  => 'number',
			'input_attrs' => array(
				'min'		  => 20,
				'max'		  => 49,
            	'step' => 1, 
			),
	) );
	
	// Loop through templates to build control for each.
	foreach ( swt_jat_get_templates() as $template => $tname ) {
		
		$wp_customize->add_setting( 'swt_jat_cols_'.$template, array(
			'transport'         => 'refresh',
			'sanitize_callback' => 'swt_jat_validate_checkbox',
		) );
		$wp_customize->add_control( 'swt_jat_cols_'.$template, array(
			'label'		  => esc_html__( sprintf( 'Add sidebar to %s', $tname ), 'swt-jat' ),
			'section'	  => 'swt_jat_sidebar',
			'type'		  => 'checkbox',
		) );
		
	} // Next
}
add_action( 'customize_register', 'swt_jat_customize_register', 10 );

// CUSTOMIZER BINDING FUNCTIONS BEGIN HERE ///////////////////////////////////////////////
// Binding for partial refreshes. This theme mostly uses standard refresh.
function swt_jat_register_partials( $wp_customize ) 
{
	// Binding core items for refresh.
	$wp_customize->get_setting( 'blogname' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
 
    // Abort if selective refresh is not available.
    if ( !isset( $wp_customize->selective_refresh ) ) {
        return;
    }
 
	// Single items
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'swt_jat_render_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'swt_jat_render_partial_blogdescription',
	) );
	$wp_customize->selective_refresh->add_partial( 'swt_jat_copyright', array(
		'selector'        => '.site-copyright',
		'render_callback' => 'swt_jat_copyright', // in template-functions.php
	) );
}
add_action( 'customize_register', 'swt_jat_register_partials', 20 );

// Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
function swt_jat_bind_preview_js() 
{
	wp_enqueue_script( 'swt-jat-customizer', get_template_directory_uri().'/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'swt_jat_bind_preview_js' );

// CUSTOMIZER RENDERING CALLBACK FUNCTIONS BEGIN HERE ////////////////////////////////////
// Render the site title for the selective refresh partial.
function swt_jat_render_partial_blogname() 
{
	bloginfo( 'name' );
}

// Render the site tagline for the selective refresh partial.
function swt_jat_render_partial_blogdescription() 
{
	bloginfo( 'description' );
}

// CUSTOM VALIDATION FUNCTIONS BEGIN HERE ////////////////////////////////////////////////
// Validate boolean. False is default.
function swt_jat_validate_bool( $setting) {
 	return ( isset( $setting ) && '1' == $setting ? '1' : '0' );
}

// Validate boolean. True is default.
function swt_jat_validate_bool_true( $setting) {
 	return ( isset( $setting ) && '0' == $setting ? '0' : '1' );
}

// Validate checkboxes.
function swt_jat_validate_checkbox( $checked ) {
 	return ( isset( $checked ) && true == $checked ? true : false );
}

// Validate sidebar width.
function swt_jat_validate_width( $number, $setting ) 
{
  $number = absint( $number );
  return ( $number && $number > 19 && $number < 50 ? $number : 33 );
}

// Validate content choice.
function swt_jat_validate_content( $checked )
{
	return ( $checked == 'post' ? $checked : 'excerpt' );
}

// FONT MANAGEMENT FUNCTIONS BEGIN HERE //////////////////////////////////////////////////
// Prep the string to load Google fonts on Customizer update to save work on front end
function swt_jat_prep_google_fonts( $old_value, $value, $option )
{
	// Get existing values if found.
	$google_fonts = get_option( 'swt-jat-gfont', '' );
	$body_font = ( isset( $value['swt_jat_body_font'] ) ? $value['swt_jat_body_font'] : '' );
	$header_font = ( isset( $value['swt_jat_header_font'] ) ? $value['swt_jat_header_font'] : '' );
	
	// Get list of available body fonts. Look up info for selected body font.
	$body_fonts = swt_jat_get_body_fonts();
	if ( !$body_font || !swt_jat_find_font( $body_fonts, $body_font ) ) {
		$body_font =  array_key_first( $body_fonts ); // Default if selected value not found.
	}
	$body_font_info = $body_fonts[$body_font]; // Remember this.
	
	// Get list of available header fonts.
	$display_style_header = false; // Set flag to determine if headers use header font.
	$header_fonts = swt_jat_get_header_fonts();
	
	// Look up info for selected header font. Look in header fonts first.
	if ( $header_font && swt_jat_find_font( $header_fonts, $header_font ) ) {
		$display_style_header = true;
		$header_font_info = $header_fonts[$header_font];
	} // If not found in header fonts, look in body fonts next.
	else if ( !$header_font || !swt_jat_find_font( $body_fonts, $header_font ) ) {
		$header_font =  array_key_first( $body_fonts ); // Default if selected value not found.
		$header_font_info = $body_fonts[$header_font];
	} else {
		$header_font_info = $body_fonts[$header_font]; // Fallback; use the first header font.
	}
	
	// Clear the arrays because we're done with them.
	$body_fonts = null;
	$header_fonts = null;
	
	// Remove unset values, then convert array to string.
	$gfont = array_filter( array( $body_font_info['load'], $header_font_info['load'] ) );
	$gstring = implode( '|', $gfont );
	
	// If selected fonts are the same as what's already set, there's nothing more to do.
	if ( $gstring == $google_fonts ) return;
	
	// Build the font-styles to add as inline styles
	// Don't add newlines to styles; they will break TinyMCE.
	$css ='';
	
	// Build the header css if not a standard font.
	if ( 'sans-serif' != $header_font ) {
		if ( $display_style_header ){
			$css = 'h1,h2:not(.comments-title),.site-title {font-family: '.$header_font_info['css'].';} ';
		} else {
			$css = 'h1,h2,h3,h4,h5,h6,.site-title {font-family: '.$header_font_info['css'].';} ';
		}
	}
	
	// Build the body css if not a standard font.
	if ( 'sans-serif' != $body_font ) {
		if ( $display_style_header ){
			$css = $css.'body,button,input,select,optgroup,textarea,h3,h4,h5,h6,.main-navigation a {font-family: '.$body_font_info['css'].';}';
		} else {
			$css = $css.'body,button,input,select,optgroup,textarea,.main-navigation a {font-family: '.$body_font_info['css'].';}';
		}
	}
	
	// If we store these in theme mods it will trigger this function again. Store separately to avoid infinite loop. 
	update_option( 'swt-jat-gfont', $gstring );
	update_option( 'swt-jat-css', $css );
}
add_action( 'update_option_theme_mods_just-another-theme', 'swt_jat_prep_google_fonts', 10, 3 );

// Lookup function to verify value
function swt_jat_find_font( $fonts, $key )
{
	if ( !array_key_exists( $key, $fonts ) ) {
		return false; // Default if selected value not found
	}
	return $key;
}

// CUSTOMIZATION VALUES SETUP BEGINS HERE ////////////////////////////////////////////////
// Return array of skins.
function swt_jat_get_skins()
{
	return array(
		'amethyst'			=> __( 'Amethyst', 'swt-jat' ),
		'blue'				=> __( 'Blue', 'swt-jat' ),
		'burnt-orange'		=> __( 'Burnt Orange', 'swt-jat' ),
		'chocolate'			=> __( 'Chocolate', 'swt-jat' ),
		'deep-red'			=> __( 'Deep Red', 'swt-jat' ),
		'denim-blue'		=> __( 'Denim Blue', 'swt-jat' ),
		'emerald'			=> __( 'Emerald', 'swt-jat' ),
		'espresso'			=> __( 'Espresso', 'swt-jat' ),
		'kiddie-time' 		=> __( 'Kiddie Time', 'swt-jat' ),
		'midnight-green'	=> __( 'Midnight Green', 'swt-jat' ),
		'pearl'				=> __( 'Pearl', 'swt-jat' ),
		'plum'				=> __( 'Plum', 'swt-jat' ),
		'teal'				=> __( 'Teal', 'swt-jat' ),
	);
}

// Return array of H3 styles
function swt_jat_get_h3_styles()
{
	return apply_filters( 'swt-jat-h3-styles', array(
		'\2665'	=> __( 'Heart', 'swt-jat' ),
		'\2756'	=> __( 'Diamond', 'swt-jat' ),
		'\25fe'	=> __( 'Square', 'swt-jat' ),
		'\2724'	=> __( 'Flower', 'swt-jat' ),
		'none'	=> __( 'None', 'swt-jat' ),
	) );
}

// Return array of theme templates; translate on output, not here.
// 'theme_mod_value' => 'Customizer label'
function swt_jat_get_templates()
{
	return apply_filters( 'swt-jat-column-templates', array(
		'single'	=> __( 'single post pages', 'swt-jat' ),
		'blog'		=> __( 'blog page', 'swt-jat' ),
		'archive'	=> __( 'blog archive pages', 'swt-jat' ),
		'search'	=> __( 'search page', 'swt-jat' ),
		'error'		=> __( '404 page', 'swt-jat' ),
	) );
}

// Return array of supported body fonts; translate on output, not here.
function swt_jat_get_body_fonts() 
{
	return apply_filters( 'swt-jat-body-fonts', array(
		'sans-serif' => array( 
			'label'	=> __( 'Default Sans-Serif','swt-jat' ), // This is default
			'css'	=> "Arial, Helvetica, sans-serif", 
			'load'	=> null 
		), 
		'serif' => array( 
			'label'	=> __( 'Default Serif',  'swt-jat' ),
			'css'	=> "'Times New Roman', Times, serif", 
			'load'	=> null 
		),
		'antic-slab' => array( 
			'label'	=> __( 'Antic Slab', 'swt-jat' ),
			'css'	=> "'Antic Slab', serif", 
			'load'	=>'Antic+Slab' 
		),
		'armata' => array( 
			'label'	=> __( 'Armata', 'swt-jat' ),
			'css'	=> "'Armata', sans-serif", 
			'load'	=> 'Armata' 
		),
		'duru-sans' => array( 
			'label'	=> __( 'Duru Sans', 'swt-jat' ),
			'css'	=> "'Duru Sans', sans-serif", 
			'load'	=>'Duru+Sans' 
		),
		'exo' => array( 
			'label'	=> __( 'Exo', 'swt-jat' ),
			'css'	=> "'Exo', sans-serif", 
			'load'	=> 'Exo' 
		),
		'fauna-one' => array( 
			'label'	=> __( 'Fauna One',  'swt-jat' ),
			'css'	=> "'Fauna One', serif", 
			'load'	=> 'Fauna+One' 
		),
		'georgia' => array(
			'label' => __( 'Georgia', 'swt-jat' ),
			'css'	=> "Georgia, 'Times New Roman', Times, serif",
			'load'	=> null,
		),
		'glegoo' => array( 
			'label'	=> __( 'Glegoo', 'swt-jat' ),
			'css'	=> "'Glegoo', serif", 
			'load'	=> 'Glegoo' 
		),
		'heebo' => array( 
			'label'	=> __( 'Heebo', 'swt-jat' ),
			'css'	=> "'Heebo', sans-serif", 
			'load'	=> 'Heebo' 
		),
		'junge' => array( 
			'label'	=> __( 'Junge', 'swt-jat' ),
			'css'	=> "'Junge', serif", 
			'load'	=> 'Junge' 
		),
		'lora' => array( 
			'label'	=> __( 'Lora', 'swt-jat' ),
			'css'	=> "'Lora', serif", 
			'load'	=> 'Lora' 
		),
		'martel' => array(
			'label'	=> __( 'Martel',  'swt-jat' ),
			'css'	=> "'Martel', serif", 
			'load'	=> 'Martel' 
		),
		'martel-sans' => array( 
			'label'	=> __( 'Martel Sans', 'swt-jat' ),
			'css'	=> "'Martel Sans', sans-serif", 
			'load'	=> 'Martel+Sans' 
		),
		'merriweather' => array( 
			'label'	=> __( 'Merriweather', 'swt-jat' ),
			'css'	=> "'Merriweather', serif", 
			'load'	=> 'Merriweather:300' 
		),
		'merriweather-sans' => array( 
			'label'	=> __( 'Merriweather Sans', 'swt-jat' ),
			'css'	=> "'Merriweather Sans', sans-serif", 
			'load'	=> 'Merriweather+Sans' 
		),
		'montserrat' => array( 
			'label'	=> __( 'Montserrat', 'swt-jat' ),
			'css'	=> "'Montserrat', sans-serif", 
			'load'	=> 'Montserrat' 
		),
		'nobile' => array( 
			'label'	=> __( 'Nobile', 'swt-jat' ),
			'css'	=> "'Nobile', sans-serif", 
			'load'	=> 'Nobile' 
		),
		'open-sans' => array( 
			'label'	=> __( 'Open Sans', 'swt-jat' ),
			'css'	=> "'Open Sans', sans-serif", 
			'load'	=> 'Open+Sans' 
		),
		'oxygen' => array( 
			'label'	=> __( 'Oxygen', 'swt-jat' ),
			'css'	=> "'Oxygen', sans-serif", 
			'load'	=> 'Oxygen' 
		),
		'playfair-display' => array(
			'label'	=> __( 'Playfair Display', 'swt-jat' ),
			'css'	=> "'Playfair Display', serif", 
			'load'	=> 'Playfair+Display' 
		),
		'poppins' => array( 
			'label'	=> __( 'Poppins', 'swt-jat' ),
			'css'	=> "'Poppins', sans-serif", 
			'load'	=> 'Poppins' 
		),
		'questrial' => array( 
			'label'	=> __( 'Questrial', 'swt-jat' ),
			'css'	=> "'Questrial', sans-serif", 
			'load'	=> 'Questrial' 
		),
		'quicksand' => array( 
			'label'	=> __( 'Quicksand', 'swt-jat' ),
			'css'	=> "'Quicksand', sans-serif", 
			'load'	=> 'Quicksand' 
		),
		'raleway' => array( 
			'label'	=> __( 'Raleway', 'swt-jat' ),
			'css'	=> "'Raleway', sans-serif", 
			'load'	=> 'Raleway' 
		),
		'rhodium-libre' => array( 
			'label'	=> __( 'Rhodium Libre', 'swt-jat' ),
			'css'	=> "'Rhodium Libre', serif", 
			'load '	=> 'Rhodium+Libre' 
		),
		'roboto' => array( 
			'label'	=> __( 'Roboto', 'swt-jat' ),
			'css'	=> "'Roboto', sans-serif", 
			'load'	=> 'Roboto' 
		),
		'roboto-slab' => array( 
			'label'	=> __( 'Roboto Slab', 'swt-jat' ),
			'css'	=> "'Roboto Slab', serif", 
			'load'	=> 'Roboto+Slab:300' 
		),
		'rosarivo' => array(
			'label'	=> __( 'Rosarivo', 'swt-jat' ),
			'css'	=> "'Rosarivo', serif", 
			'load'	=> 'Rosarivo' 
		),
		'ruda' => array( 
			'label'	=> __( 'Ruda', 'swt-jat' ),
			'css'	=> "'Ruda', sans-serif", 
			'load'	=> 'Ruda' 
		),
		'sarala' => array( 
			'label'	=> __( 'Sarala', 'swt-jat' ),
			'css'	=> "'Sarala', sans-serif", 
			'load'	=> 'Sarala' 
		),
		'sintony' => array( 
			'label'	=> __( 'Sintony', 'swt-jat' ),
			'css'	=> "'Sintony', sans-serif", 
			'load'	=> 'Sintony' 
		),
		'slabo=13px' => array( 
			'label'	=> __( 'Slabo 13px', 'swt-jat' ),
			'css'	=> "'Slabo 13px', serif", 
			'load'	=> 'Slabo+13px' 
		),
		'titillium-web' => array( 
			'label'	=> __( 'Titillium Web',  'swt-jat' ),
			'css'	=> "'Titillium Web', sans-serif", 
			'load'	=> 'Titillium+Web' 
		),
		'ubuntu' => array( 
			'label'	=> __( 'Ubuntu',  'swt-jat' ),
			'css'	=> "'Ubuntu', sans-serif", 
			'load'	=> 'Ubuntu' 
		),
		'work-sans' => array(
			'label'	=> __( 'Work Sans',  'swt-jat' ),
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
			'label'	=> __( 'Amita', 'swt-jat' ),
			'css'	=> "'Amita', cursive", 
			'load'	=> 'Amita' 
		),
		'Anonymous Pro' => array( 
			'label'	=> __( 'Anonymous Pro', 'swt-jat' ),
			'css'	=> "'Anonymous Pro', monospace", 
			'load'	=> 'Anonymous+Pro' 
		),
		'arima-madurai' => array( 
			'label'	=> __( 'Arima Madurai', 'swt-jat' ),
			'css'	=> "'Arima Madurai', cursive", 
			'load'	=> 'Arima+Madurai' 
		),
		'delius' => array( 
			'label'	=> __( 'Delius', 'swt-jat' ),
			'css'	=> "'Delius', cursive", 
			'load'	=> 'Delius' 
		),
		'delius-swash-caps' => array( 
			'label'	=> __( 'Delius Swash Caps', 'swt-jat' ),
			'css'	=> "'Delius Swash Caps', cursive", 
			'load'	=> 'Delius+Swash+Caps' 
		),
		'elsie-swash-caps' => array(
			'label'	=> __( 'Elsie Swash Caps', 'swt-jat' ),
			'css'	=> "'Elsie Swash Caps', cursive", 
			'load'	=> 'Elsie+Swash+Caps' 
		),
		'englebert' => array( 
			'label'	=> __( 'Englebert', 'swt-jat' ),
			'css'	=> "'Englebert', sans-serif", 
			'load'	=> 'Englebert' 
		),
		'forum' => array(
			'label'	=> __( 'Forum', 'swt-jat' ),
			'css'	=> "'Forum', cursive", 
			'load'	=> 'Forum' 
		),
		'handlee' => array(
			'label'	=> __( 'Handlee', 'swt-jat' ),
			'css'	=> "'Handlee', cursive", 
			'load'	=> 'Handlee' 
		),
		'happy-monkey' => array( 
			'label'	=> __( 'Happy Monkey', 'swt-jat' ),
			'css'	=> "'Happy Monkey', cursive", 
			'load'	=> 'Happy+Monkey' 
		),
		'kalam' => array( 
			'label'	=> __( 'Kalam', 'swt-jat' ),
			'css'	=> "'Kalam', cursive", 
			'load'	=> 'Kalam' 
		),
		'kotta-one' => array(
			'label'	=> __( 'Kotta One', 'swt-jat' ),
			'css'	=> "'Kotta One', serif", 
			'load'	=> 'Kotta+One' 
		),
		'mate-sc' => array( 
			'label'	=> __( 'Mate SC', 'swt-jat' ),
			'css'	=> "'Mate SC', serif", 
			'load'	=> 'Mate+SC' 
		),
		'neucha' => array( 
			'label'	=> __( 'Neucha', 'swt-jat' ),
			'css'	=> "'Neucha', cursive", 
			'load'	=> 'Neucha' 
		),
		'old-standard-tt' => array(
			'label'	=> __( 'Old Standard TT', 'swt-jat' ),
			'css'	=> "'Old Standard TT', serif", 
			'load'	=> 'Old+Standard+TT:400i' 
		),
		'oldenburg' => array( 
			'label'	=> __( 'Oldenburg', 'swt-jat' ),
			'css'	=> "'Oldenburg', cursive", 
			'load'	=> 'Oldenburg' 
		),
		'oswald' => array( 
			'label'	=> __( 'Oswald', 'swt-jat' ),
			'css'	=> "'Oswald', sans-serif", 
			'load'	=> 'Oswald' 
		),
		'paprika' => array( 
			'label'	=> __( 'Paprika', 'swt-jat' ),
			'css'	=> "'Paprika', cursive", 
			'load'	=> 'Paprika' 
		),
		'petit-formal-script' => array( 
			'label'	=> __( 'Petit Formal Script', 'swt-jat' ),
			'css'	=> "'Petit Formal Script', cursive", 
			'load'	=> 'Petit+Formal+Script'
		),
		'schoolbell' => array( 
			'label'	=> __( 'Schoolbell', 'swt-jat' ),
			'css'	=> "'Schoolbell', cursive", 
			'load'	=> 'Schoolbell' 
		),
		'simonetta' => array( 
			'label'	=> __( 'Simonetta', 'swt-jat' ),
			'css'	=> "'Simonetta', cursive", 
			'load'	=> 'Simonetta' 
		),
		'sofia' => array( 
			'label'	=> __( 'Sofia', 'swt-jat' ),
			'css'	=> "'Sofia', cursive", 
			'load'	=> 'Sofia' 
		),
		'special-elite' => array( 
			'label'	=> __( 'Special Elite', 'swt-jat' ),
			'css'	=> "'Special Elite', cursive", 
			'load'	=> 'Special+Elite' 
		),
		'stint-ultra-expanded' => array( 
			'label'	=> __( 'Stint Ultra Expanded', 'swt-jat' ),
			'css'	=> "'Stint Ultra Expanded', cursive", 
			'load'	=> 'Stint+Ultra+Expanded' 
		),
		'tillana' => array( 
			'label'	=> __( 'Tillana', 'swt-jat' ),
			'css'	=> "'Tillana', cursive", 
			'load'	=> 'Tillana' 
		),
		'unkempt' => array( 
			'label'	=> __( 'Unkempt', 'swt-jat' ),
			'css'	=> "'Unkempt', cursive", 
			'load'	=> 'Unkempt' 
		),
	) );
}
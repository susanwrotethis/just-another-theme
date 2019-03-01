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
	$wp_customize->remove_section( 'background_image' );
	
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
	
	// Preset color schemes
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
		'choices'	  => swt_jat_get_skins(),
	) );
	
	// Body Fonts
	$body_fonts = swt_jat_get_body_fonts();
	$font_dropdown = array();
	foreach ( $body_fonts as $fkey => $values ) {
		$font_dropdown[$fkey] = esc_html( $values['label'] );
	}
	$body_fonts = null;
	
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
	
	// Header Fonts: append to body fonts
	$header_fonts = swt_jat_get_header_fonts();
	foreach ( $header_fonts as $hkey => $values ) {
		if ( !array_key_exists( $hkey, $font_dropdown ) ) {
			$font_dropdown[$hkey] = esc_html( $values['label'] );
		}
	}
	$header_fonts = null;
	
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
	
	// Font smoothing
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
			'0'		=> 'No',
			'1'		=> 'Yes',
		),
	) );
	
	// Nav menu width
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
			'0'		=> 'No',
			'1'		=> 'Yes',
		),
	) );
	
	// Use excerpt or full content
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
			'excerpt'	=> 'Excerpt',
			'post'		=> 'Full Post',
		),
	) );
	
	// NEW SECTION: PRIMARY SIDEBAR
	$wp_customize->add_section( 'swt_jat_sidebar', array(
		'title' => esc_html__( 'Primary Sidebar', 'swt-jat' ),
		'priority' => 130,
	) );
	
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
function swt_jat_register_partials( $wp_customize ) 
{
	// Binding core items for refresh
	$wp_customize->get_setting( 'blogname' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
 
    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
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
// Validate email
function swt_jat_validate_email( $email )
{
	return ( isset( $email ) && is_email( $email ) ? $email : '' );
}

// Validate boolean
function swt_jat_validate_bool( $checked ) {
 	return ( isset( $checked ) && '1' == $checked ? '1' : '0' );
}

// Validate checkboxes
function swt_jat_validate_checkbox( $checked ) {
 	return ( isset( $checked ) && true == $checked ? true : false );
}

// Validate sidebar width
function swt_jat_validate_width( $number, $setting ) 
{
  $number = absint( $number );
  return ( $number && $number > 19 && $number < 50 ? $number : 33 );
}

// Validate content choice
function swt_jat_validate_content( $checked )
{
	return ( $checked == 'post' ? $checked : 'excerpt' );
}

// FONT MANAGEMENT FUNCTIONS BEGIN HERE //////////////////////////////////////////////////
// Prep the string to load Google fonts on Customizer update to save work on front end
function swt_jat_prep_google_fonts( $old_value, $value, $option )
{
	$google_fonts = get_option( 'swt-jat-gfont', '' );
	$body_font = ( isset( $value['swt_jat_body_font'] ) ? $value['swt_jat_body_font'] : '' );
	$header_font = ( isset( $value['swt_jat_header_font'] ) ? $value['swt_jat_header_font'] : '' );
	
	// Look up info for selected body font
	$body_fonts = swt_jat_get_body_fonts();
	if ( !$body_font || !swt_jat_find_font( $body_fonts, $body_font ) ) {
		$body_font =  array_key_first( $body_fonts ); // Default if selected value not found
	}
	$body_font_info = $body_fonts[$body_font];
	
	$display_style_header = false;
	$header_fonts = swt_jat_get_header_fonts();
	
	// Look up info for selected header font
	if ( $header_font && swt_jat_find_font( $header_fonts, $header_font ) ) {
		$display_style_header = true;
		$header_font_info = $header_fonts[$header_font];
	} 
	else if ( !$header_font || !swt_jat_find_font( $body_fonts, $header_font ) ) {
		$header_font =  array_key_first( $body_fonts ); // Default if selected value not found
		$header_font_info = $body_fonts[$header_font];
	} else {
		$header_font_info = $body_fonts[$header_font];
	}
	
	// Clear the arrays because we're done with them
	$body_fonts = null;
	$header_fonts = null;
	
	$gfont = array_filter( array( $body_font_info['load'], $header_font_info['load'] ) );
	$gstring = implode( '|', $gfont );
	
	// If no font changes, there's nothing more to do
	if ( $gstring == $google_fonts ) return;
	
	// Build the font-styles to add as inline styles
	// Don't add newlines to styles; they will break TinyMCE.
	$css ='';
	
	if ( 'sans-serif' != $header_font ) {
		if ( $display_style_header ){
			$css = 'h1,h2:not(.comments-title),.site-title {font-family: '.$header_font_info['css'].';} ';
		} else {
			$css = 'h1,h2,h3,h4,h5,h6,.site-title {font-family: '.$header_font_info['css'].';} ';
		}
	}
	
	if ( 'sans-serif' != $body_font ) {
		if ( $display_style_header ){
			$css = $css.'body,button,input,select,optgroup,textarea,h3,h4,h5,h6,.main-navigation a {font-family: '.$body_font_info['css'].';}';
		} else {
			$css = $css.'body,button,input,select,optgroup,textarea,.main-navigation a {font-family: '.$body_font_info['css'].';}';
		}
	}
	
	// If we store these in theme mods it will trigger this function again. Avoid infinite loop. 
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
		'none'				=> 'Default (Black and White)',	
		'amethyst'			=> 'Amethyst',
		'chocolate'			=> 'Chocolate',
		'deep-red'			=> 'Deep Red',
		'denim-blue'		=> 'Denim Blue',
		'espresso'			=> 'Espresso',
		'kiddie-time' 		=> 'Kiddie Time',
		'midnight-green'	=> 'Midnight Green',
		'teal'				=> 'Teal',
		'wine'				=> 'Wine',
	);
}

// Return array of theme templates; translate on output, not here.
// 'theme_mod_value' => 'Customizer label'
function swt_jat_get_templates()
{
	return apply_filters( 'swt-jat-column-templates', array(
		'single'	=> 'single post pages',
		'blog'		=> 'blog page',
		'archive'	=> 'blog archive pages',
		'search'	=> 'search page',
		'error'		=> '404 page'
	) );
}

// Return array of supported body fonts; translate on output, not here.
function swt_jat_get_body_fonts()
{
	return apply_filters( 'swt-jat-body-fonts', array(
		'sans-serif' => array( 
			'label'	=> 'Default Sans-Serif', // This is default
			'css'	=> "Arial, Helvetica, sans-serif", 
			'load'	=> null 
		), 
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
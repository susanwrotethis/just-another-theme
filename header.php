<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything in the header plus the opening of the .site-content divs.
 *
 * @package just-another-theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'swt-jat' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<div class="color-section color-widgets site-top-wrapper">
				<div class="site-top-content">
				<?php
				$swt_jat_description = get_bloginfo( 'description', 'display' );
				$swt_hide_description = get_theme_mod( 'swt_jat_hide_description', false);
				if ( ( $swt_jat_description && !$swt_hide_description ) /*|| is_customize_preview()*/ ): ?>
					<p class="site-description"><?php echo $swt_jat_description; ?></p>
					<?php get_sidebar( 'header' ); ?>
				<?php else: ?>
					<div class="no-description"><?php get_sidebar( 'header' ); ?></div>
				<?php endif; ?>
				</div><!-- .site-top-content -->
			</div><!-- .site-top-wrapper -->
			<?php do_action( 'swt-jat-top' ); ?>
			
			<div class="site-title-wrapper">
			<?php // Logo and title
				$swt_jat_has_logo = swt_jat_custom_logo();
				if ( is_front_page() && is_home() ) : 
				?><h1 class="site-title <?php echo ( $swt_jat_has_logo ? 'has_logo' : 'no_logo '); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?><p class="site-title <?php echo ( $swt_jat_has_logo ? 'has_logo' : 'no_logo '); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
			<?php if ( $swt_hide_description ): ?>
			<p class="hide-description screen-reader-text"><?php echo $swt_jat_description; ?></p>
			<?php endif; ?>
			</div><!-- .site-title-wrapper -->
		</div><!-- .site-branding -->
		<?php do_action( 'swt-jat-header' ); ?>

		<nav id="site-navigation" class="main-navigation">
			<div class="color-section main-navigation-content">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'swt-jat' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location'	=> 'menu-1',
				'menu_id'			=> 'primary-menu',
				'menu_class'		=> 'color-section menu nav-menu',
			) );
			?>
			</div><!-- .main-navigation-content -->
		</nav><!-- .main-navigation -->
		<?php get_sidebar( 'top' ); ?>
		<?php do_action( 'swt-jat-post-header' ); ?>
	</header><!-- #masthead .site-header -->

	<div id="content" class="site-content-wrapper">
		<div class="site-content">
			<?php do_action( 'swt-jat-pre-content' ); ?>
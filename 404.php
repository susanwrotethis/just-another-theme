<?php
/**
 * The template for displaying 404 pages.
 *
 * @package just-another-theme
 */

get_header();
?>
<div id="content-block" class="content-block">
	<div id="primary" class="content-area content-area-default">
		<main id="main" class="site-main">
			<?php do_action( 'swt-jat-before-main', '404' ); ?>

			<section class="error-page not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'swt-jat' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'The page you are looking for may have been removed, had its name changed or be temporarily unavailable.', 'swt-jat' ); ?></p>
					<p><strong><?php esc_html_e( 'Please try the following:', 'swt-jat' ); ?></strong></p>
					<ul>
						<li><?php esc_html_e( 'If you typed the page URL into the web browser\'s address bar, make sure it is spelled correctly and is case appropriate.', 'swt-jat' ); ?></li>
						<li><?php esc_html_e( 'The page you are looking for may have been removed, had its name changed or be temporarily unavailable.', 'swt-jat' ); ?></li>
						<li><?php esc_html_e( 'If you were accessing the page from a bookmark, try reaching it directly from the ', 'swt-jat' ); ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'home page', 'swt-jat' ); ?></a>
							<?php esc_html_e( 'or another link on the site instead. If the URL has changed, update the bookmark.', 'swt-jat' ); ?></li>
						<li><?php esc_html_e( 'Try searching this site:', 'swt-jat' ); ?></li>
					</ul>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-page -->
			
			<?php do_action( 'swt-jat-after-main', '404' ); ?>
		</main><!-- #main .site-main -->
	</div><!-- #primary .content-area -->

	<?php if ( get_theme_mod( 'swt_jat_cols_error' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>
</div><!-- .content-block -->

<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>
		
<?php do_action( 'swt-jat-pre-footer', '404' ); ?>

<?php get_footer();

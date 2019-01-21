<?php
/**
 * The template for displaying 404 pages.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-wide">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
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
			</section><!-- .error-404 -->
			
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if ( get_theme_mod( 'swt_jat_cols_error' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>

<?php get_footer();

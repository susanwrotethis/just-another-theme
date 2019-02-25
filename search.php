<?php
/**
 * The template for displaying search results pages.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-default">
		<main id="main" class="site-main">
			<?php do_action( 'swt-jat-before-main', 'search' ); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'swt-jat' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation( array( // Custom setup for search
				'prev_text' => esc_html__( 'More Results', 'swt-jat' ), 
				'next_text' => esc_html__( 'Previous Results', 'swt-jat' ) ,
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
			
		?>
			<?php do_action( 'swt-jat-after-main', 'search' ); ?>
		</main><!-- #main .site-main -->
	</div><!-- #primary .content-area -->

	<?php if ( get_theme_mod( 'swt_jat_cols_search' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>
		<?php do_action( 'swt-jat-pre-footer', 'search' ); ?>

<?php get_footer();

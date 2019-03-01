<?php
/**
 * The template for displaying archive pages.
 *
 * @package just-another-theme
 */

get_header();
?>

	<section id="primary" class="content-area content-area-default">
		<main id="main" class="site-main">
			<?php do_action( 'swt-jat-before-main', 'archive' ); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
			
		?>
			<?php do_action( 'swt-jat-after-main', 'archive' ); ?>
		</main><!-- #main .site-main -->
	</section><!-- #primary .content-area -->

	<?php if ( get_theme_mod( 'swt_jat_cols_archive' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>
		<?php do_action( 'swt-jat-pre-footer', 'archive' ); ?>

<?php get_footer();

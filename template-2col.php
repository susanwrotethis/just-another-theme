<?php /* Template Name: Two-Column Page */
/**
 * The template for displaying pages with a primary sidebar.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-cols">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
			
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar( 'primary' ); ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>

<?php get_footer();

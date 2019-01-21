<?php
/**
 * The template for displaying all single posts and other non-page singlar content.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-wide">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-single', 'single-'.get_post_type() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if ( get_theme_mod( 'swt_jat_cols_single' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>

<?php get_footer();

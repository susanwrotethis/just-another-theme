<?php
/**
 * The template for displaying all single posts and other non-page singlar content.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-default">
		<main id="main" class="site-main">
			<?php do_action( 'swt-jat-before-main', 'single' ); ?>

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
			<?php do_action( 'swt-jat-after-main', 'single' ); ?>
		</main><!-- #main .site-main -->
	</div><!-- #primary .content-area -->

	<?php if ( get_theme_mod( 'swt_jat_cols_single' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>
		<?php do_action( 'swt-jat-pre-footer', 'single' ); ?>

<?php get_footer();

<?php /* Template Name: Two-Column Page */
/**
 * The template for displaying pages with a primary sidebar.
 *
 * @package just-another-theme
 */

get_header();
?>
<div id="content-block" class="content-block">
	<div id="primary" class="content-area content-area-cols">
		<main id="main" class="site-main">
			<?php do_action( 'swt-jat-before-main', 'widepage' ); ?>

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
			<?php do_action( 'swt-jat-after-main', 'widepage' ); ?>
		</main><!-- #main .site-main -->
	</div><!-- #primary .content-area -->

	<?php get_sidebar( 'primary' ); ?>
</div><!-- .content-block -->

<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>
		
<?php do_action( 'swt-jat-pre-footer', 'widepage' ); ?>

<?php get_footer();

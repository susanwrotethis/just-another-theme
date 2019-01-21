<?php
/**
 * The template for displaying the blog page. Fallback when other templates are missing.
 *
 * @package just-another-theme
 */

get_header();
?>

	<div id="primary" class="content-area content-area-wide">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :

				?>
				<header>
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				</header>
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

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if ( get_theme_mod( 'swt_jat_cols_blog' ) ) : 

		get_sidebar( 'primary' ); 

	endif; ?>

	<div class="bottom-content"><?php get_sidebar( 'bottom' ); ?></div>

<?php get_footer();

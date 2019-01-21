<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package just-another-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="single-thumbnail"><?php swt_jat_post_thumbnail( 'full' ); ?></div>
	
	<?php if ( 'post' === get_post_type() ) : ?>
	<div class="entry-meta">
		<?php swt_jat_posted_by();
		swt_jat_posted_on();
		?>
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'swt-jat' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'		=> '<div class="page-links">' . esc_html__( 'Pages:', 'swt-jat' ),
			'after'			=> '</div>',
			'link_before'	=> '<span>',
			'link_after'	=> '</span>',
		) );
		?>
	</div>

	<footer class="entry-footer">
		<?php swt_jat_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- .hentry -->

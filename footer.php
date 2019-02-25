<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the .site-content divs and all content after.
 *
 * @package just-another-theme
 */
?>
</div><!-- .site-content -->
	</div><!-- .site-content-wrapper -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php get_sidebar( 'footer' ); ?>
			<?php do_action( 'swt-jat-footer' ); ?>
			<p class="site-copyright"><?php swt_jat_copyright(); ?></p>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->
</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>

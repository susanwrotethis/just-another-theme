<?php
/**
 * Custom template tags for this theme.
 *
 * @package just-another-theme
 */

// POST TAG FUNCTIONS BEGIN HERE /////////////////////////////////////////////////////////
// Prints HTML with meta information for the current post-date/time.
function swt_jat_posted_on()
{
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf( // translators: %s: post date.
		esc_html_x( 'on %s', 'post date', 'swt-jat' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

// Prints HTML with meta information for the current author.
function swt_jat_posted_by() 
{
	$byline = sprintf( // translators: %s: post author.
		esc_html_x( 'Posted by %s ', 'post author', 'swt-jat' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> '.$byline.'</span>'; // WPCS: XSS OK.
}

// Prints HTML with meta information for the categories, tags and comments.
function swt_jat_entry_footer()
{
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		// translators: used between list items, there is a space after the comma 
		$categories_list = get_the_category_list( esc_html__( ', ', 'swt-jat' ) );
		if ( $categories_list ) {
			// translators: 1: list of categories. 
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'swt-jat' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		// translators: used between list items, there is a space after the comma 
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'swt-jat' ) );
		if ( $tags_list ) {
			// translators: 1: list of tags. 
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'swt-jat' ) . '</span>', $tags_list );
		}
	}
}

// POST FORMATTING FUNCTIONS BEGIN HERE //////////////////////////////////////////////////
// Fill empty page/post titles
function swt_jat_fill_empty_title( $title )
{
	$title = trim( $title );
	if ( !$title ) {
		$title = trim( $title.__( 'Untitled', 'swt-jat' ) );
	}
	return $title;
}
add_filter( 'the_title', 'swt_jat_fill_empty_title' );

// Appends "Continue reading" link to excerpts; contains screen reader text for accessibility
function swt_jat_continue_reading( $more )
{
	global $post;
	$continue = __( 'Continue reading', 'swt-jat' );
	return ' ... <a href="'.get_permalink( $post->ID ).'">'.$continue.' <span class="screen-reader-text">'.get_the_title().'</span>...</a>';	
}
add_filter( 'excerpt_more', 'swt_jat_continue_reading' );

// POST THUMBNAIL FUNCTIONS BEGIN HERE ///////////////////////////////////////////////////
// Displays optional post thumbnail.
// Wraps thumbnail in an anchor element on index views, or a div element when on single views.
function swt_jat_post_thumbnail( $size = 'post-thumbnail' )
{
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
?>

	<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div><!-- .post-thumbnail -->

	<?php else : ?>

	<div class="post-thumbnail">
	<a class="post-thumbnail-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
			the_post_thumbnail( $size, array(
			'alt' => the_title_attribute( array(
			'echo' => false,
			) ),
		) );
		?></a></div>
<?php
	endif; // End is_singular()
}
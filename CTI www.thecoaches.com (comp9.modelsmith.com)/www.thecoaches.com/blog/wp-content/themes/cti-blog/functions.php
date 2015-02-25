<?php
if ( function_exists('register_sidebar') ) :
    register_sidebar();
endif;
if ( ! function_exists( 'cti_blog_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function cti_blog_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'cti-blog' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'cti-blog' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'cti-blog' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;
?>

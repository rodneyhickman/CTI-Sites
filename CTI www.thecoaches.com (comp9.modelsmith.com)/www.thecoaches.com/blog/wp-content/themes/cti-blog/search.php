<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>



<!-- BEGIN main -->
					<div id="main">
		
						
						<div id="breadcrumbs">
						<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="http://www.thecoaches.com/blog/">Blog</a><span class="divider">&#160;||&#160;</span><?php the_title(); ?></p>
						</div>

						<h2 class="return"><a href="http://www.thecoaches.com/blog/">&laquo; Return to blog main page</a></h2>

						
                        <section id="primary" class="site-content">
		 

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', '' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php  cti_blog_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
				echo get_post_format();
				get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php  cti_blog_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', '' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		 
	</section>
							
			</div>			

					
					<!-- END main -->
					

					<!-- BEGIN sidebar -->
					<div id="sidebar">
					<?php get_sidebar(); ?>
<div id="special"></div>
					</div>
					<!-- END sidebar -->

	 

 
<?php get_footer(); ?>
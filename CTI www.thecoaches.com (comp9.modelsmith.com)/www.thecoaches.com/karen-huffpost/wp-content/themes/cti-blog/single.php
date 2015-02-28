<?php get_header(); ?>

					<!-- BEGIN main -->
					<div id="main">
		
						
						<div id="breadcrumbs">
						<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="http://www.thecoaches.com/blog/">Blog</a><span class="divider">&#160;||&#160;</span><?php the_title(); ?></p>
						</div>

						<h2 class="return"><a href="http://www.thecoaches.com/blog/">&laquo; Return to blog main page</a></h2>


							
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <div class="postEntry">
                        	<h2 class="blogheader"><?php the_title(); ?></h2>
                        	<?php the_content('<div class="more">Continue reading &raquo;</div>'); ?>
							<div class="clear"></div>
<hr />
<?php comments_template(); ?>

                        </div>


                    <?php endwhile; ?>
                    <?php else: ?>
                    
						<p>There are no posts to display. Try searching:</p>                        
						<?php include(TEMPLATEPATH.'/searchform.php'); ?>

                    
                    <?php endif; ?>

					</div>
					<!-- END main -->
					

					<!-- BEGIN sidebar -->
					<div id="sidebar">
					<?php get_sidebar(); ?>
<div id="special"></div>
					</div>
					<!-- END sidebar -->

<?php get_footer(); ?>
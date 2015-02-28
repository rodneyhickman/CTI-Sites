<?php get_header(); ?>

					<!-- BEGIN main -->
					<div id="main">
		
						<div id="breadcrumbs">
						<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="http://www.thecoaches.com/blog/">Blog</a></p>
						</div>						
						
						<!-- <h1 id="main-headline">Changing Business. Transforming Lives.</h1> -->
							
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <div class="postEntry">
                        	<h2 class="blogheader"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        	<?php the_content('<p class="more">Continue reading &raquo;</p>'); ?>
							<div class="clear"></div>
<small><?php the_time('F jS, Y') ?> by <?php the_author() ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></small>
							<div class="clear"></div>
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
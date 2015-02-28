<?php get_header(); ?>

					<!-- BEGIN main -->
					<div id="main">
		
						<div id="breadcrumbs">
						<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="/resources/">Resources</a><span class="divider">&#160;||&#160;</span><a href="http://www.thecoaches.com/blog/">Blog</a><span class="divider">&#160;||&#160;</span><?php the_title(); ?></p>
						</div>
<img src="/res/img/transforum.jpg" />
						<h1 id="main-headline">Changing Business. Transforming Lives.</h1>


							
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <div class="postEntry">
                        	<h2><?php the_title(); ?></h2>
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
					</div>
					<!-- END sidebar -->

<?php get_footer(); ?>
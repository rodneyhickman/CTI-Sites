<?php get_header(); ?>

					<!-- BEGIN main -->
					<div id="main">
		
						<div id="breadcrumbs">
						<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="/resources/">Resources</a><span class="divider">&#160;||&#160;</span><a href="#" class="here">Blog</a></p>
						</div>


<img src="/res/img/transforum.jpg" />
						<h1 id="main-headline">Changing Business. Transforming Lives.</h1>
							
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <div class="postEntry">
                        	<h2 class="blogheader"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        	<?php the_content('<div class="more">Continue reading &raquo;</div>'); ?>

<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></small>
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
					</div>
					<!-- END sidebar -->

<?php get_footer(); ?>
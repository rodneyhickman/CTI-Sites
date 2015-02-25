<ul class="sidebar-module">
<?php if(is_page('search-page')) :?>
   <li>
   <form action="http://www.thecoaches.com/blog/" class="searchform" id="searchform" method="get" role="search">
				<div>
					<label for="s" class="screen-reader-text"><strong>Search for:</strong></label>
					<input type="text" id="s" name="s" value="<?php echo $_REQUEST['s'];?>">
					<input type="submit" value="Search" id="searchsubmit">
				</div>
			</form><br />
   </li>
   <?php endif; ?>
   <?php if ( is_search() ):?>
      <li>
   <form action="http://www.thecoaches.com/blog/" class="searchform" id="searchform" method="get" role="search">
				<div>
					<label for="s" class="screen-reader-text"><strong>Search for:</strong></label>
					<input type="text" id="s" name="s" value="<?php echo $_REQUEST['s'];?>">
					<input type="submit" value="Search" id="searchsubmit">
				</div>
			</form><br />
   </li>
   <?php endif; ?>
   <li><p><b style="text-transform:uppercase;font-size:0.9em;">Guest blog post submissions</b><br />Suzan Acker, Transforum Producer

<a href="mailto:suzanacker@gmail.com">suzanacker@gmail.com</a></p></li>

<?php if ( !function_exists('dynamic_sidebar')

        || !dynamic_sidebar() ) : ?>

<?php endif; ?>

</ul>


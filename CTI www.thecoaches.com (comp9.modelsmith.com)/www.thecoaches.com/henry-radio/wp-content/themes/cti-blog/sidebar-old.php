<div class="sidebar-module">
	<h2>recent entries</h2>
	<?php $myposts = get_posts('numberposts=10');
	foreach($myposts as $post) :?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
	<?php endforeach; ?>
</div>

<div class="sidebar-module">
	<h2>archives</h2>
	<?php wp_get_archives('') ?>
</div>
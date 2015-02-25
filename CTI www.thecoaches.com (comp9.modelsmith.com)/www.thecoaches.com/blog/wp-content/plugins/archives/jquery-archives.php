<?php
echo '<!-- Begin Archives WordPress Plugin-->'."\n" ;
$posts = get_option("archives");
$count_posts    = wp_count_posts( 'post' );
$count_pages    = wp_count_posts( 'page' );
$count_comments = wp_count_comments();
$count_cats         = wp_count_terms( 'category', array( 'hide_empty' => true ) );
$count_tags         = wp_count_terms( 'post_tag', array( 'hide_empty' => true ) );
printf( __('This is archives page of <strong>%1$s</strong>. Currently the archives consist of <strong>%2$s</strong>, <strong>%3$s</strong> and <strong>%4$s</strong>, with a total of <strong>%5$s</strong> and <strong>%6$s</strong>.', 'archives'),
					get_bloginfo('name'),
					sprintf( _n( '%d post', '%d posts', $count_posts->publish, 'archives' ), number_format_i18n( $count_posts->publish ) ),
					sprintf( _n( '%d page', '%d pages', $count_pages->publish, 'archives' ), number_format_i18n( $count_posts->publish ) ),
					sprintf( _n( '%d comment', '%d comments', $count_comments->approved, 'archives' ), number_format_i18n( $count_comments->approved ) ),
					sprintf( _n( '%d category', '%d categories', $count_cats, 'archives' ), number_format_i18n( $count_cats ) ),
					sprintf( _n( '%d tag', '%d tags', $count_tags, 'archives' ), number_format_i18n( $count_tags ) )
			);
$tag_cloud = get_terms( 'post_tag' );
if ( $tag_cloud ) :?>
<style type="text/css"> 
.archives-container {
	margin-top: 30px;
	width: auto;
	}
ul.tabs {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 32px;
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
	width: 100%;
}
ul.tabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 31px;
	line-height: 31px;
	border: 1px solid #999;
	border-left: none;
	margin-bottom: -1px;
	background: #e0e0e0;
	overflow: hidden;
	position: relative;
}
ul.tabs li a {
	text-decoration: none;
	color: #000;
	display: block;
	font-size: 1.2em;
	padding: 0 20px;
	border: 1px solid #fff;
	outline: none;
}
ul.tabs li a:hover {
	text-decoration: none;
	background: #ccc;
}	
html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #fff;
	border-bottom: 1px solid #fff;
}
.tab_container {
	border: 1px solid #999;
	border-top: none;
	clear: both;
	float: left; 
	width: 100%;
	background: #fff;
	-moz-border-radius-bottomright: 5px;
	-khtml-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-khtml-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
}
.tab_content {
	padding: 20px;
	font-size: 1.2em;
}
.tab_content h2 {
	font-weight: normal;
	padding-bottom: 10px;
	border-bottom: 1px dashed #ddd;
	font-size: 1.8em;
}
.tab_content h3 a{
	color: #254588;
}
.tab_content img {
	float: left;
	margin: 0 20px 20px 0;
	border: 1px solid #ddd;
	padding: 5px;
}
</style> 
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script> 
<script type="text/javascript"> 
 
$(document).ready(function() {
 
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
 
});
</script> 
<div class="archives-container"> 
    <ul class="tabs"> 
        <li><a href="#tab1"><?php _e('Tag Cloud', 'archives'); ?></a></li> 
        <li><a href="#tab2"><?php _e('Last ' .$posts .' Posts', 'archives'); ?></a></li> 
        <li><a href="#tab3"><?php _e('Categories', 'archives'); ?></a></li> 
        <li><a href="#tab4"><?php _e('Monthly Archives', 'archives'); ?></a></li> 
    </ul> 
    <div class="tab_container"> 
        <div id="tab1" class="tab_content"> 
<h2><?php _e('Tag Cloud', 'archives'); ?></h2>
            <div id="tag-cloud">
<?php wp_tag_cloud('number=0'); ?>
</div>
<?php endif; ?>
</div> 
        <div id="tab2" class="tab_content"> 
<h2><?php _e('Last ' .$posts .' Posts', 'archives'); ?></h2>
<?php query_posts('showposts=' .$posts . '\''); ?>
<ul>
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php the_time('F j, Y'); ?> - <?php echo $post->comment_count ?> <?php _e('comments', 'archives') ?></li>
<?php endwhile; endif; ?>
</ul>
<?php wp_reset_query(); ?>
        </div> 
        <div id="tab3" class="tab_content"> 
<h2><?php _e('Categories', 'archives'); ?></h2>
<ul>
<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>
</ul>
        </div> 
        <div id="tab4" class="tab_content"> 
<h2><?php _e('Monthly Archives', 'archives'); ?></h2>
<ul><?php wp_get_archives('type=monthly&show_post_count=1'); ?>
</ul>
        </div> 
    </div> 
</div> 

<!-- End Archives WordPress Plugin-->
<?php 
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
<h2><?php _e('Tag Cloud', 'archives'); ?></h2>
<div id="tag-cloud">
<?php wp_tag_cloud('number=0'); ?>
</div>
<?php endif; ?>
<h2><?php _e('Last ' .$posts .' Posts', 'archives'); ?></h2>
<?php query_posts('showposts=' .$posts . '\''); ?>
<ul>
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php the_time('F j, Y'); ?> - <?php echo $post->comment_count ?> <?php _e('comments', 'archives') ?></li>
<?php endwhile; endif; ?>
</ul>
<?php wp_reset_query(); ?>
<h2><?php _e('Categories', 'archives'); ?></h2>
<ul>
<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>
</ul>
<h2><?php _e('Monthly Archives', 'archives'); ?></h2>
<ul><?php wp_get_archives('type=monthly&show_post_count=1'); ?>
</ul>
<!-- End Archives WordPress Plugin-->

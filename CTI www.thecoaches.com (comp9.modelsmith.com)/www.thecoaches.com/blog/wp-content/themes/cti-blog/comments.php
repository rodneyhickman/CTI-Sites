<?php // Do not delete these lines

	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))

		die ('Please do not load this page directly. Thanks!');



        if (!empty($post->post_password)) { // if there's a password

            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie

				?>

				

				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>

				

				<?php

				return;

            }

        }



		/* This variable is for alternating comment background */

		$oddcomment = 'odd';

?>



<!-- You can start editing here. -->



<div class="bobcomments">



<?php if ($comments) : ?>



<?php 



	/* Count the totals */

	$numPingBacks = 0;

	$numComments  = 0;



	/* Loop through comments to count these totals */

	foreach ($comments as $comment) {

		if (get_comment_type() != "comment") { $numPingBacks++; }

		else { $numComments++; }

	}



?>



<?php 



	/* This is a loop for printing comments */

	if ($numComments != 0) : ?>



	<ul class="commentlist">



	<li class="commenthead"><h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3></li>

	

	<?php foreach ($comments as $comment) : ?>

	<?php if (get_comment_type()=="comment") : ?>

	

<li class="<?php if ( $comment->comment_author_email == get_the_author_email() ) echo 'mycomment'; else echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">



		<p style="margin-bottom:5px;">By <strong><?php comment_author_link() ?></strong> on <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('M j, Y') ?></a> <?php edit_comment_link('Edit',' | ',''); ?></p>

		<?php if ($comment->comment_approved == '0') : ?>

		<em>Your comment is awaiting moderation.</em>

		<?php endif; ?>

		<?php comment_text() ?>

	</li>

		

	<?php /* Changes every other comment to a different class */	

	if ('alt' == $oddcomment) $oddcomment = '';

	else $oddcomment = 'odd';

	?>

	

	<?php endif; endforeach; ?>

	

	</ul>

	

	<?php endif; ?>



<?php



	/* This is a loop for printing trackbacks if there are any */

	if ($numPingBacks != 0) : ?>



	<ol class="bob">



	<li style="background:transparent;padding-left:0;"><h2><?php _e($numPingBacks); ?> Trackback(s)</h2></li>

	

<?php foreach ($comments as $comment) : ?>

<?php if (get_comment_type()!="comment") : ?>



	<li id="comment-<?php comment_ID() ?>">

		<?php comment_date('M j, Y') ?>: <?php comment_author_link() ?>

		<?php if ($comment->comment_approved == '0') : ?>

		<em>Your comment is awaiting moderation.</em>

		<?php endif; ?>

	</li>

	

	<?php if('odd'==$thiscomment) { $thiscomment = 'even'; } else { $thiscomment = 'odd'; } ?>

	

<?php endif; endforeach; ?>



	</ol>



<?php endif; ?>

	

<?php else : 



	/* No comments at all means a simple message instead */ 

?>



<?php endif; ?>



<?php if (comments_open()) : ?>

	

	<?php if (get_option('comment_registration') && !$user_ID ) : ?>

		<p id="comments-blocked">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=

		<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

	<?php else : ?>



	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">



	<h2 id="respond">Post a Comment</h2>



	<?php if ($user_ID) : ?>

	

	<p>You are logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">

		<?php echo $user_identity; ?></a>. To logout, <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">click here</a>.

	</p>

	

<?php else : ?>	

	<table width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width="21%"><label for="author">Name<?php if ($req) _e(' (required)'); ?></label></td>
    <td width="79%"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></td>
  </tr>
  <tr>
    <td><label for="email">E-mail <?php if ($req) _e(' (required)'); ?><br />(will not be published)</label></td>
    <td><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" size="22" /></td>
  </tr>
  <tr>
    <td><label for="url">Website</label></td>
    <td><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></td>
  </tr>
</table>

 

	<?php endif; ?>

<table width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width="21%" valign="top"><label for="author">Comments</label></td>
    <td width="79%"><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></td>
  </tr>
  
</table>
 


		<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit" />

		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>

	

	<?php do_action('comment_form', $post->ID); ?>



	</form>



<?php endif; // If registration required and not logged in ?>



<?php else : // Comments are closed ?>

	<p id="comments-closed">Sorry, comments for this entry are closed at this time.</p>

<?php endif; ?></div>
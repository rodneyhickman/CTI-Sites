<?php 
// windows junction patch
$dir = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME']);
for ( $x = 1; $x <= 5; $x++ )
{
	$dir = dirname($dir.'x');
	if ( is_file($dir.'/wp-load.php') )
		require_once($dir.'/wp-load.php');
}

$cpd_datemin = ( !empty($_REQUEST['datemin']) ) ? $_REQUEST['datemin'] : date_i18n('Y-m-d', time() - 86400 * 14); // 14 days
$cpd_datemax = ( !empty($_REQUEST['datemax']) ) ? $_REQUEST['datemax'] : date_i18n('Y-m-d');
$cpd_page = ( isset($_REQUEST['page']) ) ? $_REQUEST['page'] : 0;

$sql = "SELECT	p.post_title,
				COUNT(*) as count,
				c.page,
				c.date
		FROM	".CPD_C_TABLE." c
		LEFT	JOIN ".$wpdb->posts." p
				ON p.ID = c.page
		WHERE	c.page = '$cpd_page'
		AND		c.date >= '$cpd_datemin'
		AND		c.date <= '$cpd_datemax'
		GROUP	BY c.date
		ORDER	BY c.date desc";
$cpd_visits = $count_per_day->getQuery($sql, 'getUserPerPostSpan');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="de-DE">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Count per Day</title>
<link rel="stylesheet" type="text/css" href="counter.css" />
</head>
<body class="cpd-thickbox">

<h2><?php _e('Visitors per day', 'cpd') ?></h2>

<form action="" method="post">
<p style="background:#ddd; padding:3px;">
	<?php _e('Start', 'cpd'); ?>:
	<input type="text" name="datemin" value="<?php echo $cpd_datemin; ?>" size="10" />
	<?php _e('End', 'cpd'); ?>:
	<input type="text" name="datemax" value="<?php echo $cpd_datemax; ?>" size="10" />
	<?php _e('PostID', 'cpd'); ?>:
	<input type="text" name="page" value="<?php echo $cpd_page; ?>" size="5" />
	<input type="submit" value="<?php _e('show', 'cpd') ?>" />  
</p>
</form>

<?php
if ( @mysql_num_rows($cpd_visits) == 0 )
	_e('no data found', 'cpd');
else
{
	$cpd_maxcount = 1;
	while ( $r = mysql_fetch_array($cpd_visits) )
		$cpd_maxcount = max( array( $cpd_maxcount, intval($r['count']) ) );
	mysql_data_seek($cpd_visits, 0);
	$cpd_faktor = 300 / $cpd_maxcount; 
	
	while ( $r = mysql_fetch_array($cpd_visits) )
	{
		if ( !isset($cpd_new) )
		{
			if ( $cpd_page == 0 )
				echo  '<h2>'.__('Front page displays').'</h2';
			else
				echo '<h2>'.$r['post_title'].'</h2>';
			echo '<ol class="cpd-dashboard" style="padding: 0;">';
		}
		else
		{
			if ( $cpd_new < $r['count'] )
				$cpd_style = 'style="color:#b00;"';
			else if ( $cpd_new > $r['count'] )
				$cpd_style = 'style="color:#0a0;"';
			else
				$cpd_style = '';
		
			$cpd_bar = $cpd_new * $cpd_faktor;
			$cpd_trans = 300 - $cpd_bar;
			$cpd_imgbar = '<img src="'.$count_per_day->getResource('cpd_rot.png').'" alt="" style="width:'.$cpd_bar.'px;height:23px;padding-left:10px;" />';
			$cpd_imgtrans = '<img src="'.$count_per_day->getResource('cpd_trans.png').'" alt="" style="width:'.$cpd_trans.'px;height:10px;padding-right:10px;" />';
			
			echo '<li>';
			echo '<b>'.$cpd_imgbar.$cpd_imgtrans.'</b>';
			echo '<b '.$cpd_style.'>'.$cpd_new.'</b>';
			echo $cpd_date_str.'</li>';
		}
		$cpd_date_str = mysql2date(get_option('date_format'), $r['date']);
		$cpd_new = intval($r['count']);
	}

	$cpd_bar = $cpd_new * $cpd_faktor;
	$cpd_trans = 300 - $cpd_bar;
	$cpd_imgbar = '<img src="'.$count_per_day->getResource('cpd_rot.png').'" alt="" style="width:'.$cpd_bar.'px;height:23px;padding-left:10px;" />';
	$cpd_imgtrans = '<img src="'.$count_per_day->getResource('cpd_trans.png').'" alt="" style="width:'.$cpd_trans.'px;height:10px;padding-right:10px;" />';

	echo '<li>';
	echo '<b>'.$cpd_imgbar.$cpd_imgtrans.'</b>';
	echo '<b>'.$cpd_new.'</b>';
	echo $cpd_date_str.'</li>';
}
echo '</ol>';
if ($count_per_day->options['debug']) $count_per_day->showQueries();
?>
</body>
</html>
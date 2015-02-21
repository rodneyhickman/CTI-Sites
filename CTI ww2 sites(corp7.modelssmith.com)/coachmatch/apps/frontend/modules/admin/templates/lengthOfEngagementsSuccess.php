<!-- This file contains a starting point for a templte page   -->

<h1>
Administration Activity Reports: Length Of Engagements
</h1>




<table style="width:500px;">
<tr>
<th>Client Name</th>
<th>Coach Name</th>
<th>Date Started</th>
<th>Length of Engagement</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<?php 
$client = ProfilePeer::retrieveByPk($p->getClientId());
$coach  = ProfilePeer::retrieveByPk($p->getCoachId());
if( !isset($client) ) continue;
if( !isset($coach)  ) continue;

$activityDate = $p->getActivityDate('Y-m-d'); // calculate now - date here
$a            = explode('-',$activityDate);

// Get current time 
$date1 = time(); 
 
// Get the timestamp of 
$date2 = mktime(0,0,0,$a[1],$a[2],$a[0]);

$dateDiff = $date1 - $date2;
$length = floor($dateDiff/(60*60*24));


?>
<tr> 
  <td><?php echo link_to(  $client->getName(), 'admin/editUser?id='.$client->getId() ) ?></td>
  <td><?php echo link_to(  $coach->getName(), 'admin/editUser?id='.$coach->getId() ) ?></td>

  <td><?php echo $p->getActivityDate('Y-m-d') ?></td>
  <td><?php echo $length ?> days</td>
</tr>

<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/lengthOfEngagements?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/lengthOfEngagements?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/lengthOfEngagements?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/lengthOfEngagements?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/lengthOfEngagements?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>







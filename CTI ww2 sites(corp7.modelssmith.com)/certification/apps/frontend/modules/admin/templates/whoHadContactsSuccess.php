<!-- This file contains a starting point for a templte page   -->
<?php include_partial('nav') ?>

<h1>
Administration Activity Reports: Who Had Contacts
</h1>




<table style="width:500px;">
<tr>
<th>Client Name</th>
<th>Coach Name</th>
<th>Contact Date</th>
<th>Coach Added Client?</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<?php 
$client = ProfilePeer::retrieveByPk($p->getClientId());
$coach  = ProfilePeer::retrieveByPk($p->getCoachId());
if( !isset($client) ) continue;
if( !isset($coach)  ) continue;
$c = new Criteria();
$c->add(ActivityPeer::CLIENT_ID, $p->getClientId() );
$c->add(ActivityPeer::COACH_ID, $p->getCoachId() );
$c->add(ActivityPeer::DECRIPTION, 'added_client' );
$contacted = ActivityPeer::doSelectOne( $c );
?>
<tr> 
<td><?php echo link_to( $client->getName(), 'admin/editUser?id='.$client->getId() ) ?></td>
  <td><?php echo link_to( $coach->getName(), 'admin/editUser?id='.$coach->getId() ) ?></td>

  <td><?php echo $p->getActivityDate() ?></td>
  <td><?php echo isset($contacted) ? 'Yes' : 'No' ?></td>
</tr>

<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/whoHadContacts?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/whoHadContacts?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/whoHadContacts?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/whoHadContacts?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/whoHadContacts?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>







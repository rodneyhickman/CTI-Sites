<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Admin: View Feedback
</h1>


<table style="width:500px;">
<tr>
<th>Name</th>
<th>Email</th>
<th>Date</th>
<th>Feedback</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<?php $profile = $p->getProfile() ?>
<?php if(isset($profile)): ?>
<tr> 
  <td><?php echo link_to(  $profile->getName(), 'admin/editUser?id='.$profile->getId() ) ?></td>
  <td><a href="mailto:<?php echo $profile->getEmail() ?>"><?php echo $profile->getEmail() ?></a></td>
  <td><?php echo $p->getFeedbackDate() ?></td>
  <td><?php echo $p->getValue() ?></td>
</tr>
<?php endif ?>
<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/viewFeedback?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/viewFeedback?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/viewFeedback?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/viewFeedback?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/viewFeedback?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>







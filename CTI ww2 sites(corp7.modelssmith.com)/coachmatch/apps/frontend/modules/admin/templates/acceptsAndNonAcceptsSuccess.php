<!-- This file contains a starting point for a templte page   -->
<?php include_partial('nav') ?>

<h1>
Administration Activity Reports: Accepts And Non-Accepts
</h1>




<table style="width:500px;">
<tr>
<th>Name</th>
<th>Registration Date</th>
<th>Accepted?</th>
<th>Accepted Date</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<tr> 
  <td><?php echo link_to(  $p->getName(), 'admin/editUser?id='.$p->getId() ) ?></td>
  <td><?php echo $p->getCreatedAt('M d, Y') ?></td>
  <td><?php echo $p->hasAccepted() ?></td>
  <td><?php echo $p->getAgreeClicked('M d, Y') ?></td>
</tr>

<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/acceptsAndNonAccepts?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/acceptsAndNonAccepts?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/acceptsAndNonAccepts?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/acceptsAndNonAccepts?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/acceptsAndNonAccepts?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>







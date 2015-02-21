<!-- This file contains a starting point for a templte page   -->
<?php include_partial('nav') ?>

<h1>
Administration Activity Reports:<br />
Coaches with One or More Clients
</h1>




<table style="width:500px;">
<tr>
<th>Name</th>
<th>Registration Date</th>
<th>Client Load</th>
<th></th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<tr> 
  <td><?php echo link_to(  $p->name, 'admin/editUser?id='.$p->id ) ?></td>
  <td><?php echo $p->created_at ?></td>
  <td><?php echo $p->num_clients ?></td>


  <td></td>
</tr>

<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/coachClientLoad?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/coachClientLoad?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/coachClientLoad?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/coachClientLoad?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/coachClientLoad?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>







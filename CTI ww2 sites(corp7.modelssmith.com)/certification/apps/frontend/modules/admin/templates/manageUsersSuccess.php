<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>
<h1>Administration: Manage Users</h1>

<!-- list -->
<form action="<?php echo url_for('admin/manageUsers') ?>" method="POST">

  <p><?php echo link_to('View All Users','admin/manageUsers?page=1'); ?> | Search by name: <input name="q" type="text"> <input type="submit" value="Search"></p>
  

<table style="width:500px;">
<tr>
<th>Name</th>
<th>Email</th>
<th>Student/Coach</th>
<th>Action</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<tr> 
<td><?php echo link_to(  $p->getName(), 'admin/editUser?id='.$p->getId() ) ?></td>
<td><a href="mailto:<?php echo $p->getEmail() ?>"><?php echo $p->getEmail() ?></a></td>
<td><?php echo $p->getRole() ?></td>
  <td><?php echo link_to(  'Edit', 'admin/editUser?id='.$p->getId() ) ?>&nbsp;&nbsp;&nbsp;<?php echo link_to(  'Delete', 'admin/deleteUser?id='.$p->getId(), array('class'=>'delete') ) ?></td>
</tr>
<?php endforeach ?>
</table>

 <!-- page numbers -->

 <p style="margin-top:20px;color:#888;">
 <?php echo $pager->getNbResults() ?> results found.<br />
 Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

  <br/><br/>

 <?php if ($pager->haveToPaginate()): ?>
   <?php echo link_to('&lt;&lt;', 'admin/manageUsers?page='.$pager->getFirstPage()) ?>
   <?php echo link_to('&lt;', 'admin/manageUsers?page='.$pager->getPreviousPage()) ?>
   <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/manageUsers?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
   <?php endforeach ?>
   <?php echo link_to('&gt;', 'admin/manageUsers?page='.$pager->getNextPage()) ?>
   <?php echo link_to('&gt;&gt;', 'admin/manageUsers?page='.$pager->getLastPage()) ?>
 <?php endif ?>
 
 </p>

</form>



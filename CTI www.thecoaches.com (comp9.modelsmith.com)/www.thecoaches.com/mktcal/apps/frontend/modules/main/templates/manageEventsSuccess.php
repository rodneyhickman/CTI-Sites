<br/>
<h1>Manage Events</h1>

<?php if(isset($message)): ?>
<br/>
<p style="color:#f00;"><?php echo $message ?></p>
<?php endif ?>

<form action="<?php echo url_for('main/manageEvents') ?>" method="POST">

<p><?php echo link_to('View All Events','main/manageEvents?page=1'); ?> | Search by name: <input name="q" type="text"> <input type="submit" value="Search"></p>

<table style="width:700px;">
<tr>
<th>Name</th>
<th>Date</th>
<th>Time</th>
<th>Location</th>
<th>Action</th>
</tr>

<?php foreach ($pager->getResults() as $p): ?>
<tr> 
<td><?php echo link_to(  $p->getName(), 'main/editEvent?id='.$p->getId() ) ?></td>
<td><?php echo $p->getDate() ?></td>
<td><?php echo $p->getTime() ?></td>
<td><?php echo $p->getLocation() ?></td>
  <td><?php echo link_to(  'Edit', 'main/editEvent?id='.$p->getId() ) ?>&nbsp;&nbsp;&nbsp;<?php echo link_to(  'Delete', 'main/deleteEvent?id='.$p->getId(), array('class'=>'delete') ) ?></td>
</tr>
<?php endforeach ?>
</table>

 <!-- page numbers -->

<p style="margin-top:20px;color:#888;">
<?php echo $pager->getNbResults() ?> results found.<br />
Displaying results <?php echo $pager->getFirstIndice() ?> to  <?php echo $pager->getLastIndice() ?>.

<br/><br/>

<?php if ($pager->haveToPaginate()): ?>
  <?php echo link_to('&lt;&lt;', 'main/manageEvents?page='.$pager->getFirstPage()) ?>
  <?php echo link_to('&lt;', 'main/manageEvents?page='.$pager->getPreviousPage()) ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
     <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'main/manageEvents?page='.$page) ?>
     <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
  <?php endforeach ?>
  <?php echo link_to('&gt;', 'main/manageEvents?page='.$pager->getNextPage()) ?>
  <?php echo link_to('&gt;&gt;', 'main/manageEvents?page='.$pager->getLastPage()) ?>
<?php endif ?>
 
</p>

</form>

<p>&raquo; <?php echo link_to('Add Event','main/newEvent'); ?></p>

<p>&raquo; <?php echo link_to('Go to Homepage','main/index'); ?></p>

<p>&raquo; <?php echo link_to('Sign out','main/logout'); ?></p>
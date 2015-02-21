<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Add A Client
</h1>



<p>
Clients who have contacted you:
</p>

<form action="<?php echo url_for('profile/addClient') ?>" method="POST">
<table>
<?php foreach($contacts as $c): ?>
<tr>
<td width="20"><input type="checkbox" name="contact_id[]" value="<?php echo $c->getId() ?>"></td>
<td><?php echo $c->getName() ?> in <?php echo $c->getLocation() ?></td>
</tr>

<?php endforeach ?>

    <tr>
      <td></td>
      <td>
<?php if(count($contacts) > 0): ?>
<input type="submit" name="submit" value="Add Checked Client(s) to current list" />
<?php else: ?>
No clients have contacted you at this time
<?php endif ?>
   </td>
    </tr>
   
</table>


<p>
&nbsp;<br />Current Clients:
<p>

<table>
<?php foreach($clients as $c): ?>
<td><?php echo $c->getName() ?> in <?php echo $c->getLocation() ?></td>
<?php endforeach ?>
<?php if(count($clients) > 0): ?>
<tr><td>&nbsp;</td></tr>
<?php else: ?>
   <tr><td>&nbsp;&nbsp;You are not currently coaching clients</td></tr>
<?php endif ?>
</table>
</form>

       <p>&nbsp;<br />
  <?php echo link_to('Back to Account Home Page','profile/home') ?>
</p>



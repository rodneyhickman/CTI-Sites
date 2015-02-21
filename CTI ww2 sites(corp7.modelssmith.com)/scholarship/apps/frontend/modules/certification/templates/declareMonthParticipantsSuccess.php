<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>




  <h1>Certification Administration - Participants<br /><br />(Declared Start Month Only)</h1>


<form action="<?php echo url_for('certification/participants') ?>" method="post">
<table style="width:550px;padding:5px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all certification','certification/participants') ?></td>
<td colspan="1"></td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Month To Begin</td>
<td></td>
</tr>
<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Participants</strong><br />(sorted by First Name)</td>
<td class="btop bright"></td>
<td class="btop bright"></td>

</tr>

<?php $alt=1 ?>
    <?php foreach($participants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','certification/participant?id='.$p->getId().'&tribe_id='.$p->getTribeId() ) ?></td>
  <td class="bright"><?php echo $p->getMonthToBegin()  ?></td>
<td class="bright"><?php echo link_to('Delete','certification/participantDelete?id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
</tr>
<?php endforeach ?>



</tr>

<tr>
<td colspan="2" class="btop">Click on a name above to EDIT</td>
<td colspan="1" class="btop">+ <?php echo link_to('Add Participant','certification/addParticipant') ?></td>
</tr>

<tr>
<td colspan="3">&nbsp;</td>
</tr>


</table>
</form>




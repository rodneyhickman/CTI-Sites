<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Assistants</h1>


<form action="<?php echo url_for('leadership/participants') ?>" method="post">
<table style="width:550px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all assistants','leadership/assistants') ?></td>
<td colspan="4">Forms Completed</td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Questionnaire</td>
<td>Medical</td>
<td>Diet</td>
<td>Agreed to Assistant Agreement</td>

<td></td>
</tr>
<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Assistants</strong><br />(sorted by First Name)</td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>

</tr>

<?php $alt=1 ?>
    <?php foreach($participants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','leadership/participant?id='.$p->getId().'&tribe_id='.$p->getTribeId() ) ?></td>
<td class="bright"><?php echo $p->getFinishedQuestionnaire() ?></td>
<td class="bright"><?php echo $p->getFinishedMedical() ?></td>
<td class="bright"><?php echo $p->getFinishedDietary() ?></td>
<td class="bright"><?php echo $p->getAssistantAgreed() ?></td>

<td class="bright"><?php echo link_to('Delete','leadership/participantDelete?id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
</tr>
<?php endforeach ?>



</tr>

<tr>
<td colspan="5" class="btop">Click on a name above to EDIT</td>
<td colspan="1" class="btop">+ <?php echo link_to('Add Assistant','leadership/addAssistant') ?></td>
</tr>

<tr>
<td colspan="6">&nbsp;</td>
</tr>


</table>
</form>




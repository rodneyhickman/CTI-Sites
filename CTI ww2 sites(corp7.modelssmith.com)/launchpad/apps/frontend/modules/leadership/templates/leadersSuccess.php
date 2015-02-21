<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Leaders</h1>



<table>
<tr>
<td></td>
<td colspan="3">Forms Completed</td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Questionnaire</td>
<td>Medical</td>
<td>Diet</td>
<td></td>
</tr>
<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Leaders</strong><br />(sorted by First Name)</td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($participants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName(),'leadership/leader?id='.$p->getId() ) ?></td>
    <td class="bright"><?php echo $p->getFinishedQuestionnaire() ?></td>
<td class="bright"><?php echo $p->getFinishedMedical() ?></td>
<td class="bright"><?php echo $p->getFinishedDietary() ?></td>
  <td class="bright"><?php echo link_to('Delete','leadership/leaderDelete?id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
</tr>
<?php endforeach ?>



</tr>

<tr>
<td colspan="4" class="btop">Click on a name above to EDIT</td>
<td colspan="1" class="btop">+ <?php echo link_to('Add Leader','leadership/addLeader') ?></td>
</tr>

<tr>
<td colspan="5">&nbsp;</td>
</tr>


</table>

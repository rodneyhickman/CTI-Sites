<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Leader Selection Applicants</h1>


<form action="<?php echo url_for('leadership/leaderSelectionApplicants') ?>" method="post">
<table style="width:550px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all applicants','leadership/leaderSelectionApplicants') ?></td>
<td colspan="3">Forms Completed</td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Applicants</strong><br />(sorted by First Name)</td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($applicants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','leadership/applicant?id='.$p->getId() ) ?></td>
<td class="bright">
<td class="bright"></td>
<td class="bright"></td>
<td class="bright"><?php echo link_to('Delete','leadership/applicantDelete?r=leaderSelectionApplicants&id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
</tr>
<?php endforeach ?>



</tr>

<tr>
<td colspan="4" class="btop">Click on a name above to EDIT</td>
<td colspan="1" class="btop"><!-- + <?php echo link_to('Add Participant','leadership/addParticipant') ?> --></td>
</tr>

<tr>
<td colspan="5">&nbsp;</td>
</tr>


<tr>
<td colspan="5">&raquo; <?php echo link_to('Export Leader Selection Applications Spreadsheet','leadership/exportAllLeaderSelection') ?></td>
</tr>

<tr>
<td colspan="5">&nbsp;</td>
</tr>


</table>
</form>




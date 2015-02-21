<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Coach Training Scholarship Applicants</h1>


<form action="<?php echo url_for('leadership/coachTrainingApplicants') ?>" method="post">
<table style="width:550px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all applicants','leadership/coachTrainingApplicants') ?></td>
<td colspan="3">Forms Completed</td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Show last
<a href="<?php echo url_for('leadership/coachTrainingApplicants?days=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/coachTrainingApplicants?days=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/coachTrainingApplicants?days=60'); ?>">60</a> days</td>
<td>Show last
<a href="<?php echo url_for('leadership/coachTrainingApplicants?count=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/coachTrainingApplicants?count=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/coachTrainingApplicants?count=60'); ?>">60</a> applicants</td>
<td></td>

<td></td>
</tr>

<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Applicants</strong><br />(sorted by First Name)</td>
<td class="btop bright"><strong>Updated</strong></td>
<td class="btop bright"><strong>Resume Download</strong></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($applicants as $p): ?>
  <?php $alt++; $c = new Criteria(); $c->add(CoachTrainingPeer::PROFILE_ID, $p->getId()); $app = CoachTrainingPeer::doSelectOne($c); ?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','leadership/applicant?id='.$p->getId() ) ?></td>
<td class="bright"><?php echo $app->getUpdatedAt('M d, Y'); ?></td>
  <td class="bright"><a href="<?php echo url_for('leadership/exportCoachTrainingResume?id='.$p->getId()); ?>">Resume</a></td>
<td class="bright"></td>
<td class="bright"><?php echo link_to('Delete','leadership/applicantDelete?r=leadershipApplicants&id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
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
<td colspan="5">&raquo; <?php echo link_to('Export Coach Training Scholarship Applications Spreadsheet','leadership/exportAllCoachTraining') ?></td>
</tr>

<tr>
<td colspan="5">&nbsp;</td>
</tr>


</table>
</form>




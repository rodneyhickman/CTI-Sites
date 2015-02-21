<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<?php if($mode == 'faculty'): ?>
    <h1>Executive Coaching Applicants (Faculty)</h1>
<?php else: ?>
   <h1>Executive Coaching Applicants (CPCC)</h1>
<?php endif; ?>

<form action="<?php echo url_for('leadership/executiveApplicants') ?>" method="post">
<table style="width:550px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all applicants','leadership/executiveApplicants') ?></td>
<td colspan="3"><b>Right-click photos and resumes to save to disk</a></td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Show last
<?php if($mode == 'faculty'): ?>
<a href="<?php echo url_for('leadership/facultyApplicants?days=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/facultyApplicants?days=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/facultyApplicants?days=60'); ?>">60</a>,
<a href="<?php echo url_for('leadership/facultyApplicants?days=90'); ?>">90</a> days</td>
<?php else: ?>
<a href="<?php echo url_for('leadership/executiveApplicants?days=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/executiveApplicants?days=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/executiveApplicants?days=60'); ?>">60</a> days</td>
<?php endif; ?>
<td>Show last
<?php if($mode == 'faculty'): ?>
<a href="<?php echo url_for('leadership/facultyApplicants?count=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/facultyApplicants?count=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/facultyApplicants?count=60'); ?>">60</a> applicants</td>
<?php else: ?>
<a href="<?php echo url_for('leadership/executiveApplicants?count=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/executiveApplicants?count=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/executiveApplicants?count=60'); ?>">60</a> applicants</td>
<?php endif; ?>
<td></td>
<td></td>
</tr>
<tr class="lightbg">
  <td class="btop bleft bright"><strong>All Applicants</strong><br />(sorted by First Name)</td>
<td class="btop bright"><b>Updated</b></td>
<td class="btop bright">Photo<br />Download</td>
<td class="btop bright">Resume<br />Download</td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($applicants as $p): ?>
    <?php $alt++; $c = new Criteria(); $c->add(ExecCoachPeer::PROFILE_ID, $p->getId()); $app = ExecCoachPeer::doSelectOne($c); ?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','leadership/applicant?id='.$p->getId() ) ?></td>
  <td class="bright"><?php echo $app->getUpdatedAt('M d, Y'); ?></td>
  <!-- <td class="bright"><a href="<?php echo $p->getExecPhotoUrl() ?>">Photo</a></td> -->
  <td class="bright"><?php echo link_to('Photo','leadership/exportPhoto?id='.$p->getId()) ?></td>
  <td class="bright"><?php echo link_to('Resume','leadership/exportResume?id='.$p->getId()) ?></td>
  <td class="bright"><?php echo link_to('Delete','leadership/applicantDelete?r=executiveApplicants&id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
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



<?php if($mode == 'faculty'): ?>
<tr><td colspan="5">&raquo; <?php echo link_to('Export Executive Coaching Applications (Faculty) Spreadsheet','leadership/exportAllExecFaculty?days='.$days) ?></td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Export Executive Coaching Applications (Faculty) Resumes and Photos ZIP File','leadership/exportAllExecFacultyZIP?days='.$days) ?></td></tr>
  <?php else: ?>
<tr><td colspan="5">&raquo; <?php echo link_to('Export Executive Coaching Applications (CPCC) Spreadsheet','leadership/exportAllExecCoaching?days='.$days) ?></td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Export Executive Coaching Applications (CPCC)  Resumes and Photos ZIP File','leadership/exportAllExecCoachingZIP?days='.$days) ?></td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Export Executive Coaching Applications (CPCC)  Word Docs ZIP File','leadership/execAllMergeDocZIP?days='.$days) ?></td></tr>

<?php endif; ?>


<tr>
<td colspan="5">&nbsp;</td>
</tr>


</table>
</form>




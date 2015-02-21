<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
   <h1>FORL Audition Applicants </h1>

  <p>Link to send to new applicants: <a href="<?php echo url_for('flexform/index') ?>"><?php echo url_for('flexform/index',true) ?></a></p>



<form action="<?php echo url_for('leadership/forlApplicants') ?>" method="post">
<table style="width:550px;">
<tr>
  <td>Search: <input type="text" name="q" value="<?php echo $q ?>" /> <input type="submit" name="go" value="Go" /><br /><span style="color:#d9e6ee;">mmmmm</span> or <?php echo link_to('View all applicants','leadership/forlApplicants') ?></td>
<td colspan="3"><b>Right-click photos and resumes to save to disk</a></td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td>Show last

<a href="<?php echo url_for('leadership/forlApplicants?days=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/forlApplicants?days=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/forlApplicants?days=60'); ?>">60</a>,
<a href="<?php echo url_for('leadership/forlApplicants?days=90'); ?>">90</a> days</td>

<td>Show last

<a href="<?php echo url_for('leadership/forlApplicants?count=15'); ?>">15</a>, 
<a href="<?php echo url_for('leadership/forlApplicants?count=30'); ?>">30</a>, 
<a href="<?php echo url_for('leadership/forlApplicants?count=60'); ?>">60</a> applicants</td>
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
    <?php $alt++; $c = new Criteria(); $c->add(FlexformSubmissionPeer::PROFILE_ID, $p->getId()); $app = FlexformSubmissionPeer::doSelectOne($c); ?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
  <td class="bleft bright"><?php echo link_to($p->getName() != ' ' ? $p->getName() : 'unassigned','leadership/forlApplicant?id='.$p->getId() ) ?></td>
  <td class="bright"><?php echo $app->getUpdatedAt('M d, Y'); ?></td>
  <!-- <td class="bright"><a href="<?php echo $p->getExecPhotoUrl() ?>">Photo</a></td> -->
  <td class="bright"><?php echo link_to('Photo','leadership/exportFORLPhoto?id='.$p->getId()) ?></td>
  <td class="bright"><?php echo link_to('Resume','leadership/exportFORLResume?id='.$p->getId()) ?></td>
  <td class="bright"><?php echo link_to('Delete','leadership/applicantDelete?r=FORLApplicants&id='.$p->getId(), array( 'onclick' => "if (confirm('Are you sure?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;" ) )  ?></td>
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




<tr><td colspan="5">&raquo; <?php echo link_to('Export FORL Audition Applications Spreadsheet','leadership/exportAllFORL?days='.$days) ?></td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Export FORL Audition Resumes and Photos ZIP File','leadership/exportAllFORLZIP?days='.$days) ?></td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Export FORL Audition Applications ZIP File','leadership/forlAllMergeDocZIP?days='.$days) ?></td></tr>


<tr>
<td colspan="5">&nbsp;</td>
</tr>

<tr><td colspan="5">For Thomas:</td></tr>
<tr><td colspan="5">&raquo; <?php echo link_to('Create Merge Template','leadership/forlMergeTemplate') ?></td></tr>


</table>
</form>




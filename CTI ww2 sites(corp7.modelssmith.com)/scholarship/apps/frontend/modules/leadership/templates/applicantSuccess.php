

<?php include_partial('nav') ?>
<h1>Applicant</h1>

<p>&nbsp;</p>


<form action="<?php echo url_for('leadership/applicantUpdate') ?>" method="post">
<input type="hidden" name="id" value="<?php echo $profile_id ?>" />
<table style="width:500px !important">

<tr>
<td style="width:130px;"><strong>Personal Information</strong></td>
<td></td>
</tr>

<tr>
  <td></td>
  <td></td>
</tr>
 
<tr>
  <td></td>
  <td></td>
</tr>
 
<tr>
<td>First Name</td>
<td><input type="text" name="first_name" value="<?php echo $profile->getFirstName() ?>" /></td>
</tr>

<tr>
<td>Last Name</td>
<td><input type="text" name="last_name" value="<?php echo $profile->getLastName() ?>" /></td>
</tr>

<tr>
<td>Email</td>
<td><input type="text" name="email1" value="<?php echo $profile->getEmail1() ?>" /></td>
</tr>


<?php if($profile->hasExeccoachApp()): ?>
<tr>
<td>Photo</td>
<td>
<a href="<?php echo $profile->getExecPhotoUrl() ?>"><img style="width:300px;" src="<?php echo $profile->getExecPhotoUrl() ?>"  /></a>
</td>
</tr>
<?php endif; ?>

<?php if($profile->hasLeaderSelectionApp()): ?>
<tr>
<td>Photo</td>
<td>
<a href="<?php echo $profile->getSelectionPhotoUrl() ?>"><img style="width:300px;" src="<?php echo $profile->getSelectionPhotoUrl() ?>" /></a>
</td>
</tr>
<?php endif; ?>


<tr>
<td></td>
<td><input type="submit" name="save" value="Save Changes" /><br /><br /></p></td>
</tr>


</table>
</form>

     <?php if($profile->hasCoachTrainingApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Coach Training Scholarship Application</strong></p>
     <p><?php echo link_to("View this person's Coach Training Scholarship Application",'leadership/coreApplication?profile_id='.$profile_id); ?></p>
     <p><?php echo link_to("Modify this person's Coach Training Scholarship Application",'ctiforms/coachTraining?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to('Export Coach Training Scholarship Application in CSV Format','leadership/exportCoachTraining?id='.$profile_id) ?></p>
    <?php if($profile->hasCoachTrainingResume()): ?>
     <p><?php echo link_to('Export Resume/Bio','leadership/exportCoachTrainingResume?id='.$profile_id) ?></p>
        <?php else: ?>
     <p>Applicant did not upload a bio/resume<p>
        <?php endif; ?>
     <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/coachTrainingApplicants') ?>">View all Coach Training Scholarship Applicants</a></p>
     <?php endif; ?>

     <?php if($profile->hasLeadershipApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Leadership Scholarship Application</strong></p>
     <p><?php echo link_to("View this person's Leadership Scholarship Application",'leadership/leadershipApplication?profile_id='.$profile_id); ?></p>
     <p><?php echo link_to("Modify this person's Leadership Scholarship Application",'ctiforms/leadership?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to('Export Leadership Scholarship Application in CSV Format','leadership/exportLeadership?id='.$profile_id) ?></p>

    <?php if($profile->hasLeadershipResume()): ?>
     <p><?php echo link_to('Export Resume/Bio','leadership/exportLeadershipResume?id='.$profile_id) ?></p>
        <?php else: ?>
     <p>Applicant did not upload a bio/resume<p>
        <?php endif; ?>
                                                       <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/leadershipApplicants') ?>">View all Leadership Scholarship Applicants</a></p>
     <?php endif; ?>


     <?php if($profile->hasExeccoachApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Executive Coaching Application</strong></p>
     <p><?php echo link_to("Modify this person's Leadership Scholarship Application",'executivecoach/adminEdit?profile_id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Executive Coaching Application in CSV Format','leadership/exportExecutive?id='.$profile_id) ?></p>
     <p><?php echo link_to('View Executive Coaching Application in PDF Format','leadership/exportExecutivePDF?id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Executive Coaching Application in DOC Format','leadership/execMergeDoc?id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Resume/Bio','leadership/exportResume?id='.$profile_id) ?></p>
                                                       <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/executiveApplicants') ?>">View all Executive Coaching Applicants</a></p>
     <?php endif; ?>






     <?php if($profile->hasLeaderSelectionApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Leadership Scholarship Application</strong></p>
     <p><?php echo link_to("Modify this person's Leaders Selection Application",'leaders/selection?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to('Export Leader Selection Application in CSV Format','leadership/exportLeaderSelection?id='.$profile_id) ?></p>

     <?php if($profile->hasLeaderSelectionResume()): ?>
     <p><?php echo link_to('Export Resume','leadership/exportLeaderSelectionResume?id='.$profile_id) ?></p>
        <?php else: ?>
     <p>Applicant did not upload a bio/resume<p>
        <?php endif; ?>
     <?php if($profile->hasLeaderSelectionRecommendation()): ?>
     <p><?php echo link_to('Export Leader Recommendation','leadership/exportLeaderSelectionRecommendation?id='.$profile_id) ?></p>
        <?php else: ?>
     <p>Applicant did not upload a bio/resume<p>
        <?php endif; ?>
     <p>&nbsp;</p>
     <p><a href="<?php echo url_for('leadership/leaderSelectionApplicants') ?>">View all Leader Selection Applicants</a></p>
     <?php endif; ?>




                                                       

                                                       <p>&nbsp;</p>
<!-- <p>
For Thomas:</p>  
     <p><?php echo link_to('DeDupe Test','leadership/deDupe?id='.$profile_id) ?></p>
-->




<?php include_partial('nav') ?>
<h1>Scholarship Applicant</h1>

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



<tr>
<td></td>
<td><input type="submit" name="save" value="Save Changes" /><br /><br /></p></td>
</tr>


</table>
</form>

     <?php if($profile->hasCoachTrainingApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Coach Training Scholarship Application</strong></p>
     <p><?php echo link_to("Modify this person's Coach Training Scholarship Application",'ctiforms/coachTraining?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to('Export Coach Training Scholarship Application in CSV Format','leadership/exportCoachTraining?id='.$profile_id) ?></p>
     <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/coachTrainingApplicants') ?>">View all Coach Training Scholarship Applicants</a></p>
     <?php endif; ?>

     <?php if($profile->hasLeadershipApp()): ?>
     <p>&nbsp;</p>
     <p><strong>Leadership Scholarship Application</strong></p>
     <p><?php echo link_to("Modify this person's Leadership Scholarship Application",'ctiforms/leadership?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to('Export Leadership Scholarship Application in CSV Format','leadership/exportLeadership?id='.$profile_id) ?></p>
                                                       <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/leadershipApplicants') ?>">View all Leadership Scholarship Applicants</a></p>
     <?php endif; ?>




                                                       

                                                       <p>&nbsp;</p>




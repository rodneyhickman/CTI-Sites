

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Participant/Assistant</h1>

<p>&nbsp;</p>

<form action="<?php echo url_for('leadership/participantUpdate') ?>" method="post">
<input type="hidden" name="id" value="<?php echo $profile_id ?>" />
<table style="width:500px !important">

<tr>
<td style="width:130px;"><strong>Personal Information</strong></td>
<td></td>
</tr>

<tr>
   <td>Role</td>
<td><?php echo $profile->getRole() ?></td>
</tr>
 
<tr>
<td>Tribe</td>
   <td><?php echo $profile->getTribe() ?>&nbsp;&nbsp;&nbsp;
   <?php echo link_to('Transfer to another tribe','leadership/transferParticipant?id='.$profile_id.'&tribe_id='.$tribe_id) ?></td>
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
<td>Gender</td>
<td><input type="text" name="gender" value="<?php echo $profile->getGender() ?>" /></td>
</tr>

<tr>
<td>Age</td>
<td><input type="text" name="age" value="<?php echo $profile->getAge() ?>" /></td>
</tr>



<tr>
<td></td>
<td><input type="submit" name="save" value="Save Changes" /><br /><br /><?php echo link_to('Return to '.$profile->getTribe().' tribe','leadership/tribe?tribe_id='.$tribe_id) ?></p></td>
</tr>


</table>
</form>

     <p>&nbsp;</p>
     <p><?php echo link_to("Modify this person's Program Questionnaire",'ctiforms/ProgramQuestionnaire?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to("Modify this person's Medical/Liability Form",'ctiforms/Medical?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p><?php echo link_to("Modify this person's Dietary Requirements Form",'ctiforms/DietaryRequirements?profile_id='.$profile_id.'&adminedit=-1') ?></p>
     <p>&nbsp;</p>
     <p><?php echo link_to('Export Questionnaire Form in CSV Format','leadership/exportPQ?id='.$profile_id) ?></p>
  <p><?php echo link_to('Show Questionnaire Form as PDF','leadership/PQPDF?id='.$profile_id) ?></p>
   
<p>&nbsp;</p>
     <p><?php echo link_to('Export Medical/Liability Form in CSV Format','leadership/exportMedical?id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Diet Requirements in CSV Format','leadership/exportDiet?id='.$profile_id) ?></p>
     <p>&nbsp;</p>
     <p><?php echo link_to('Export Influencer Report in CSV Format','leadership/exportInf?id='.$profile_id) ?></p>

                                                       
                                                       <p>&nbsp;</p>
                                                       <p>&nbsp;</p>
<p>
For Thomas:</p>  
     <p><?php echo link_to('DeDupe Test','leadership/deDupe?id='.$profile_id) ?></p>

     <?php if($profile->getRole() == 'assistant'): ?>

     <p><?php echo link_to('Show Assistant Form Answers','leadership/assistantFormAnswers?id='.$profile_id) ?></p>
     <p><?php echo link_to('Show Assistant Form Answers as PDF','leadership/assistantFormAnswersPDF?id='.$profile_id) ?></p>
   
      <?php endif ?>


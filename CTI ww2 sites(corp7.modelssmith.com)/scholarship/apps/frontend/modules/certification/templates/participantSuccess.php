

<?php include_partial('nav') ?>
<h1>Certification Administration - Participant</h1>

<p>&nbsp;</p>

<form action="<?php echo url_for('certification/participantUpdate') ?>" method="post">
<input type="hidden" name="id" value="<?php echo $profile_id ?>" />
<table style="width:500px !important">

<tr>
<td style="width:130px;"><strong>Personal Information</strong></td>
<td></td>
</tr>

 
<tr>
<td>Pod</td>
   <td><?php echo $profile->getPodName() ?>&nbsp;&nbsp;&nbsp;
   <?php echo link_to('Transfer to another pod','certification/transferParticipant?id='.$profile_id.'&pod_id='.$pod_id) ?></td>
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




     <tr><td colspan="2">&nbsp;</td></tr>


     <tr><td></td>
<td><?php echo link_to('View Certification Application','certification/viewParticipantApplication?id='.$profile_id); ?></td></tr>


</table>
</form>


                                                       <p>&nbsp;</p>
                                                       <p>&nbsp;</p>


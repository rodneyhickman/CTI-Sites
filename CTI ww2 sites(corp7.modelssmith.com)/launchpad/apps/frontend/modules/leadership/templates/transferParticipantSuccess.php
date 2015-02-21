<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Transfer Participant/Assistant</h1>

<p>&nbsp;</p>

<form action="<?php echo url_for('leadership/transferParticipantUpdate') ?>" method="post">
<input type="hidden" name="id" value="<?php echo $profile_id ?>" />
<table>

<tr>
<td style="width:130px;"><strong>Personal Information</strong></td>
<td></td>
</tr>

<tr>
   <td>Role</td>
<td><?php echo $profile->getRole() ?></td>
</tr>
 
<tr>
<td>Current Tribe</td>
   <td><?php echo $profile->getTribe() ?>&nbsp;&nbsp;&nbsp;
</tr>
 
<tr>
<td>Transfer To</td>
<td>
<select name="tribe_id">
<?php echo objects_for_select($tribes, 'getId', 'getNameDateLocation', $tribe_id) ?>
</select>
</td>
<tr>

<tr>
<td>First Name</td>
<td><?php echo $profile->getFirstName() ?></td>
</tr>

<tr>
<td>Last Name</td>
<td><?php echo $profile->getLastName() ?></td>
</tr>

<tr>
<td>Email</td>
<td><?php echo mail_to($profile->getEmail1()) ?></td>
</tr>




<tr>
<td></td>
<td><input type="submit" name="save" value="Save Changes" /><br /><br /></p></td>
</tr>


</table>
</form>

     <p>&nbsp;</p>
  


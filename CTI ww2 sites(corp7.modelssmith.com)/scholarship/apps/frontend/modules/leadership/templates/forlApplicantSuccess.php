

<?php include_partial('nav') ?>
<h1>FORL Audition Applicant</h1>

<p>&nbsp;</p>


<form action="<?php echo url_for('leadership/forlApplicantUpdate') ?>" method="post">
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
<td>Photo</td>
<td>
<a href="/scholarship/uploads/<?php echo $profile->getForlPhoto() ?>"><img style="width:300px;" src="/scholarship/uploads/<?php echo $profile->getForlPhoto() ?>"  /></a>
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="save" value="Save Changes" /><br /><br /></p></td>
</tr>


</table>
</form>

   
     <p>&nbsp;</p>
     <p><strong>FORL Audition Application</strong></p>
     <p><?php echo link_to("Modify this person's FORL Audition Application",'flexform/edit?profile_id='.$profile_id) ?></p>
     <p><?php echo link_to('Export FORL Audition Application in CSV Format','leadership/exportFORL?id='.$profile_id) ?></p>

     <p><?php echo link_to('View Executive Coaching Application in PDF Format','leadership/exportForlPDF?id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Executive Coaching Application in DOC Format','leadership/forlMergeDoc?id='.$profile_id) ?></p>
     <p><?php echo link_to('Export Resume/Bio','leadership/exportFORLResume?id='.$profile_id) ?></p>



     <p>&nbsp;</p>
<p><a href="<?php echo url_for('leadership/forlApplicants') ?>">View all FORL Audition  Applicants</a></p>
   

   



                                                       

                                                       <p>&nbsp;</p>




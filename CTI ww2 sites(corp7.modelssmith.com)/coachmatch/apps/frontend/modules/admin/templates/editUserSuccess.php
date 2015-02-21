<!-- This file contains a starting point for a templte page   -->


<?php include_partial('nav') ?>
<h1>
  Administration: Edit User
</h1>


<form action="<?php echo url_for('admin/editUser') ?>" method="POST">
<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
  <table>
    <tr>
      <td>Email Address</td>
      <td><?php echo $email ?><br />  <?php echo button_to('Sign In As This User','admin/signInAs?id='.$post_id) ?>
</td>
    </tr>
    <tr>
      <td>Password</td>
  <td><?php echo button_to('Set password to "welcome"','admin/setPasswordToWelcome?id='.$post_id) ?>
</td>
    </tr>


    <?php echo $form ?>
    <tr>
      <td>Country Group</td>
      <td><?php echo $countryGroup ?>
  <?php if(preg_match('/US/',$countryGroup)): ?>
<br /><?php echo button_to('Set Country Group to UK','admin/setToUK?id='.$post_id) ?>
   <?php endif; ?>
<!-- Ticket #559: Added a provision to set country group to US if it was set to UK.-->
  <?php if(preg_match('/UK/',$countryGroup)): ?>
<br /><?php echo button_to('Set Country Group to US','admin/setToUS?id='.$post_id) ?>
   <?php endif; ?>
</td>
    </tr>
    <tr>
      <td>Has taken In The Bones or Synergy?</td>
      <td><?php echo $has_taken ?></td>
    </tr>
<?php if($has_taken == 'Yes'): ?>
    <tr>
       <td>Date Converted to Coach</td>
       <td><?php echo $convertedToCoach ?></td>
    </tr>
    <tr>
       <td>Number of Students</td>
       <td><?php echo $num_clients ?></td>
    </tr>
<?php if($num_clients > 0): ?>
    <tr>
       <td>Current Students</td>
       <td>
<?php foreach($clients as $c): ?>
       <?php echo $c->getName() ?>&nbsp;
<?php echo link_to('Delete','admin/removeStudent?coach='.$coach.'&client='.$c->getId()) ?>
<br />
<?php endforeach ?>
       </td>
    </tr>
<?php endif ?>
<?php endif ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Save Changes" />
      </td>
    </tr>
<?php if(isset($message)): ?>
    <tr>
      <td></td>
      <td style="color:#f00;"><?php echo $message ?></td>
    </tr>
<?php endif ?>

  </table>
</form>










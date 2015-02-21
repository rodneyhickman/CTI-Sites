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
    <?php echo $form ?>
    <tr>
      <td>Has finished certification?</td>
      <td><?php echo $has_finished ?></td>
    </tr>
    <tr>
      <td>Is Faculty Coach?</td>
      <td><?php echo $is_faculty ?></td>
    </tr>
<?php if($has_finished == 'Yes'): ?>
    <tr>
       <td>Number of Coaching Clients</td>
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










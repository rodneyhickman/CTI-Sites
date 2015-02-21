<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>
<h1>
My Profile
</h1>



<form action="<?php echo url_for('profile/edit') ?>" method="POST">
  <table>
    <tr>
      <td>Email Address</td>
      <td><?php echo $email ?></td>
    </tr>
    <?php echo $form ?>
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

<p>&nbsp;<br />
  <?php echo link_to('Back to Account Page','profile/home') ?>
</p>


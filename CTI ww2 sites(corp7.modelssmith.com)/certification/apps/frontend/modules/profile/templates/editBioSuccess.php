<!-- This file contains a starting point for a template page   -->

<?php include_partial('nav') ?>
<h1>
My Coach Profile
</h1>



<form action="<?php echo url_for('profile/editBio') ?>" method="POST">
  <table>
<?php if(isset($message)): ?>
    <tr>
      <td></td>
      <td style="color:#f00;"><?php echo $message ?></td>
    </tr>
<?php endif ?>
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

  </table>
</form>

<p>&nbsp;<br />
  <?php echo link_to('Back to Account Home Page','profile/home') ?>
</p>


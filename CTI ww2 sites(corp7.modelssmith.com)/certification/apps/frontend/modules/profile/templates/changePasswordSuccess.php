<!-- This file contains a starting point for a templte page   -->

<h1>
Change Password
</h1>



<p>
Please enter your new password twice and click the Save New Password button.
</p>


<form action="<?php echo url_for('profile/changePassword') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" value="Save New Password" />
      </td>
    </tr>
  </table>
</form>

<p>


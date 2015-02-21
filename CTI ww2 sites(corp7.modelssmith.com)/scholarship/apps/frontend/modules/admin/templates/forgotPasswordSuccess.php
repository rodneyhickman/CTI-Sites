<!-- This file contains a starting point for a templte page   -->

<h1>
Forget Your Password?
</h1>


<p>
If you can't remember your password, please enter your email address and click the "Request New Password" button. A temporary link will be sent to your email address.
</p>



<form action="<?php echo url_for('admin/forgotPassword') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" value="Request New Password" />
      </td>
    </tr>
  </table>
</form>

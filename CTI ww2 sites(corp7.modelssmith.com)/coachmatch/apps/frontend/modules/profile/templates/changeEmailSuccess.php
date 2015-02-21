<!-- This file contains a starting point for a templte page   -->

<h1>
Change Email Address
</h1>



<p>
Please enter your new email address and click the Save New Email button.
</p>


<form action="<?php echo url_for('profile/changeEmail') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" value="Save New Email" />
      </td>
    </tr>
  </table>
</form>

<p>


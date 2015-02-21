<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Change My Email Address
</h1>



<p>
Please enter your new email address and click the button. You will receive an email at your new email address with a link to confirm the change.
</p>


<form action="<?php echo url_for('profile/requestEmailChange') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" value="Save New Email Address" />
      </td>
    </tr>
  </table>
</form>

<p>


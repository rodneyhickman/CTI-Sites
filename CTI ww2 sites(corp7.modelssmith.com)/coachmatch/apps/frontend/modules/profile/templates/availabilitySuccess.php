<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Your Availability
</h1>




<form action="<?php echo url_for('profile/availability') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Save My Selection" />
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




<!-- This file contains a starting point for a templte page   -->

<h1>
Unreg
</h1>



<form action="<?php echo url_for('main/testUnreg') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" value="Submit" />
      </td>
    </tr>
  </table>
</form>

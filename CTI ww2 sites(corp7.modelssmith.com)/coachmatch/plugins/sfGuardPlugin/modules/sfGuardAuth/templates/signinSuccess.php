<h1>Please Sign In</h1>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <?php echo $form ?>
  <tr><td></td><td>
  <input type="submit" value="Sign In" />
  </td></tr>
  <tr><td></td><td>
   <?php echo link_to("I'm not able to sign into my account","main/forgotPassword") ?> 
  </td></tr>
  </table>

</form>

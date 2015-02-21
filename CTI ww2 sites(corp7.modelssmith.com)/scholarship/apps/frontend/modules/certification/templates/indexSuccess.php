



<h1>Sign In Page for Certification Administration</h1>

<div style="float:left">
<p>
<b>Please sign in:</b>
</p>

<!-- should be url_for('@sf_guard_signin') -->
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <?php echo $form ?>
  <tr><td></td><td>
  <input type="submit" value="Sign In" />
  </td></tr>
  <tr><td></td><td>
   <?php echo link_to("I'm not able to sign into my account","admin/forgotPassword") ?> 
  </td></tr>
  </table>

</form>
</div>

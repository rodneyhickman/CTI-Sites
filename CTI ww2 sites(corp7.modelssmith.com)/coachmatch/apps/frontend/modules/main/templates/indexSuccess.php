<!--
<p>&nbsp;</p>
<p>Coach Match is temporarily unavailable - please check back soon</p>
-->



<h1>Sign In Page for Students and Coaches</h1>

<div style="float:left">
<p>
<b>Please sign in:</b>
</p>

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
</div>

<div style="float:left;margin-left:50px;">
<p>
   <b>CREATE AN ACCOUNT<br />
New Coach Match users create an account below:</b>
</p>

<form action="<?php echo url_for('main/registerStepOne') ?>" method="post">
  <table>
    <?php echo $regform ?>
  <tr><td></td><td>
  <input type="submit" value="Create an Account" />
  </td></tr>
  </table>

</form>
</div>



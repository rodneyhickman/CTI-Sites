<?php if($msg): ?>
<p class="alert"><?php echo $msg ?></p>
<?php endif ?>

   <p>Please use the email address and password registered with CTI. If you do not remember your password,  <a href="<?php echo url_for('main/requestNewPassword') ?>">click here</a></p>
 
 <form action="<?php echo url_for('main/registerProcess') ?>" method="POST">
 
     <table>
    <tr>
  <th><label for="signin_username">Email address</label></th>
  <td><input type="text" name="email" id="signin_username" /></td>
</tr>
<tr>
  <th><label for="signin_password">Password</label></th>
  <td><input type="password" name="password" id="signin_password" /></td>
</tr>
  <tr><td></td><td>
  <input type="submit" value="Login" />
  </td></tr>
  <tr><td></td><td>
    <a href="<?php echo url_for('main/requestNewPassword') ?>">I&rsquo;m not able to login</a> 
  </td></tr>
  </table>

</form>
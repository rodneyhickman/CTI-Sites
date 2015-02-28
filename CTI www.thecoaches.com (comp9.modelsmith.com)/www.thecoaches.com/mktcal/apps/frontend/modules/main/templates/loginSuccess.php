
<?php if($msg): ?>
<p class="alert"><?php echo $msg ?></p>
<?php endif ?>

 <form action="<?php echo url_for('main/loginProcess') ?>" method="POST">
  <input type="hidden" name="redirect" value="/learning-hub/" />
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
  <tr><td></td><td></td></tr>
  </table>

</form>

<p>&raquo; <?php echo link_to('Go to Homepage','main/index'); ?></p>
 
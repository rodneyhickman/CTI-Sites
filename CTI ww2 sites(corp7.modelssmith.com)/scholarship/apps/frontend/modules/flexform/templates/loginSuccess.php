
 <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class=
        "dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
              <!--[if lte IE 6]><span style="display:block;width:176px;height:57px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/launchpad/images/logo250857176.png',sizingMethod='crop')"><![endif]--><img alt=""
              height="57" width="176" class="png24bit" src=
              "/launchpad/images/logo250857176.png" /> <!-- /publish/logo250857176.png -->
              <!--[if lte IE 6]></span><![endif]-->
            </div>

    <h1>&nbsp;</h1>

   <div id="dabblePageContent">


<div style="padding:20px;">
    <h2>Coaches Training Institute: Login</h2>


<?php if($msg): ?>
<p class="alert"><?php echo $msg ?></p>
<?php endif ?>

 <form action="<?php echo url_for('flexform/loginProcess') ?>" method="POST">
  <input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
     <table>
    <tr>
  <th><label for="signin_username">Email address</label></th>
  <td><input style="width:250px;" type="text" name="email" id="signin_username" /></td>
</tr>
<tr>
  <th><label for="signin_password">Password</label></th>
  <td><input style="width:250px;" type="password" name="password" id="signin_password" /></td>
</tr>
  <tr><td></td><td>
  <input type="submit" value="Login" />
  </td></tr>
  <tr><td></td><td>
    <a href="<?php echo url_for('flexform/requestNewPassword') ?>">I&rsquo;m not able to login</a> 
  </td></tr>
  </table>

</form>
</div>




 </div>
        </div>
      </div>
    </div>

    <div class="dabblePageBottomLeftShadow"></div>

    <div class="dabblePageBottomRightShadow"></div>

    <div class="dabblePageBottomShadow"></div>
  </div>
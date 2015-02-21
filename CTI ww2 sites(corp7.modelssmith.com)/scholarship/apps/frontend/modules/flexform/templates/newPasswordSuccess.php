<?php use_helper('Object'); ?>
<!-- This file contains the CA Step 1 form           -->

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

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
               
            </div>
          </div>

          <div id="dabblePageContent">



<div class="dabblePageSection dabblePageSectionFull">
<div class="dabblePageColumn dabblePageColumn1">
<div class="dabblePageTextItem">
<div class="dabblePageText">



<?php if($ok): ?>
<h1>Thank you</h1>
<p>Your new password has been saved. Please <a href="<?php echo url_for('flexform/login'); ?>">log in</a>.

<?php else: ?>
<h1>New Password</h1>

<?php if($msg): ?>
<p class="alert"><?php echo $msg ?></p>
<?php endif ?>

<p>Please enter your new password</p>


 <form action="<?php echo url_for('flexform/newPasswordProcess'); ?>" method="POST">
   <input type="hidden" name="k" value="<?php echo $key ?>">
     <table>
    <tr>
  <th><label for="signin_username">Email address</label></th>
  <td><?php echo $email ?></td>
</tr>
<tr>
  <th><label for="signin_password">Password</label></th>
  <td><input type="password" name="password" id="signin_password" style="width:160px;" /></td>
</tr>
<tr>
  <th><label for="signin_password">Verify</label></th>
  <td><input type="password" name="verify" id="signin_verify"  style="width:160px;" /></td>
</tr>
  <tr><td></td><td>
  <input type="submit" name="submitbtn" value="Save New Password" />
  </td></tr>
  </table>

</form>

 
<?php endif ?>




</div>
</div>


</div>
</div>




          </div>
        </div>
      </div>
    </div>

    <div class="dabblePageBottomLeftShadow"></div>

    <div class="dabblePageBottomRightShadow"></div>

    <div class="dabblePageBottomShadow"></div>
  </div>
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

    
<h1>I'm Not Able To Login</h1>

<p>If you have forgotten your password, please enter your email address and click the "Request New Password" button. A link will be sent to the email address on record with us.</p>

<?php if($msg): ?>
<p class="notify"><?php echo $msg ?></p>
<?php endif ?>

 <form action="requestNewPasswordProcess" method="POST">
  <input type="hidden" name="redirect" value="" />
     <table>
    <tr>
  <th><label for="signin_username">Email address</label></th>
  <td><input type="text" name="email" id="signin_username" /></td>
</tr>
  <tr><td></td><td>
  <input type="submit" value="Request New Password" />
  </td></tr>
  </table>

</form>

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

<FORM id="subscribe" NAME="optin" METHOD="POST" ACTION="index.html">

<input id="firstname" name="firstname" type="text" />
<br/><label id="label_firstname" for="firstname">First Name</label><br /><br />

<input id="lastname" name="lastname" type="text" />
<br/><label id="label_lastname" for="lastname">Last Name</label><br /><br />

<input id="newsletter" name="newsletter" type="text" />
<br/><label id="label_newsletter" for="newsletter">Email Address</label><br /><br />



<!-- Captcha Block -->
<p><label for="captext">Please type the letters below</label>:<br />
<input type="text" name="captext" id="captext"></input></p>

<img src="/simplecaptcha.php" id="captcha" style="margin-top:10px;width:188px;border:solid 1px #888;"/><br/>

<p><a href="#" onclick="
    document.getElementById('captcha').src='/simplecaptcha.php?'+Math.random();
    document.getElementById('captcha-form').focus();"
    id="change-image" class="readable">Not readable? Change text.</a></p>
<!-- End Captcha Block -->

  
 <input id="submitbtn" name="submit1" type="submit" value="Subscribe" />

</form>

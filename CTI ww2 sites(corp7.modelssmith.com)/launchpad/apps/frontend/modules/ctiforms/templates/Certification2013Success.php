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

<?php echo form_tag('ctiforms/CertificationProcess', 'method=post id=dabblePageForm  class=dabblePageForm name=dabblePageForm') ?>

                <input type="hidden" name="referer" value="http://www.thecoaches.com/coach-training/certification/registration-and-application-process" />




<div class="dabblePageSection dabblePageSectionFull">
<div class="dabblePageColumn dabblePageColumn1">

<!--
<div class="dabblePageTextItem">
<div class="dabblePageText">
<p></p>
</div>
</div>
-->


<div class="dabblePageTextItem">
<div class="dabblePageText">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<h1>CERTIFICATION APPLICATION FORM</h1>
<p><strong>The Coaches Training Institute</strong></p>
<p>This document is a legally binding agreement.</p>
<p>You should read the Certification Program Information Packet thoroughly prior to completing this application to ensure you are familiar with all aspects of the program before you sign this agreement.</p>
</div>
</div>



<div class="dabblePageTextItem">
<div class="dabblePageText">
<h2>Section A: Contact Information</h2>
</div>
</div>



<div class="dabblePageFormLabel">
<label for="name">*First and Last Name</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[name]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="address">*Address</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[address]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="address-2">Address 2</label>
</div>
<div class="dabblePageFormField ">

<input type="text" class="text" name="cert[address-2]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="city">*City</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[city]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="stateprovince">State/Province</label>
</div>
<div class="dabblePageFormField">

<input type="text" class="text" name="cert[stateprovince]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="country">*Country</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[country]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="zippostal-code">Zip/Postal Code</label>
</div>
<div class="dabblePageFormField">

<input type="text" class="text" name="cert[zippostal-code]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="evening-phone">Evening Phone</label>
</div>
<div class="dabblePageFormField ">

<input type="text" class="text" name="cert[evening-phone]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="day-phone">Day Phone</label>
</div>
<div class="dabblePageFormField ">

<input type="text" class="text" name="cert[day-phone]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="email">*Email</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[email]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<input type="hidden" name="cert[fax]" value="" />

<div class="dabblePageFormLabel">
<label for="mobile">Mobile</label>
</div>
<div class="dabblePageFormField ">

<input type="text" class="text" name="cert[mobile]" value="" />

</div>
<div style="clear:both">&nbsp;</div>



<div class="dabblePageTextItem">
<div class="dabblePageText">
<h2>Section B: Coaching Information</h2>
</div>
</div>



<div class="dabblePageFormLabel">
<label for="month-to-begin-certification">*What month would you like to begin certification?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">
<select  name="cert[month-to-begin-certification]">
    <?php  echo options_for_select( $months ) ?>

</select>
</div>
<div style="clear:both">&nbsp;</div>





<div class="dabblePageFormLabel">
<label for="how-many-clients-do-you-currently-have">*How many clients do you currently have?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[how-many-clients-do-you-currently-have]" value="" />

</div>
<div style="clear:both">&nbsp;</div>


<div class="dabblePageFormLabel">
    <label for="languages-in-which-you-are-coaching">*What languages do you currently coach in?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[languages-in-which-you-are-coaching]" value="" />

</div>
<div style="clear:both">&nbsp;</div>



<div class="dabblePageFormLabel">
<label for="date-completed-process">*What date did you complete your Process course?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[date-completed-process]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="date-of-synergy-in-the-bones">*What date did you complete or are you registered for Synergy/In The Bones?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[date-of-synergy-in-the-bones]" value="" />

</div>
<div style="clear:both">&nbsp;</div>



<div class="dabblePageFormLabel">
<label for="your-certified-coach">*Your Certified Coach&lsquo;s Name</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[your-certified-coach]" value="" />

</div>
<div style="clear:both">&nbsp;</div>


<div class="dabblePageTextItem">
<div class="dabblePageText">
<p>Your Coach&lsquo;s Current Certification</p>
</div>
</div>

<div class="dabblePageFormLabel">
<label for="cpcc">CPCC</label>
</div>
<div class="dabblePageFormField ">

<input type="checkbox" name="cert[cpcc]" value="" />

</div>


<div class="dabblePageFormLabel">
<label for="pcc">PCC</label>
</div>
<div class="dabblePageFormField ">

<input type="checkbox" name="cert[pcc]" value="" />

</div>


<div class="dabblePageFormLabel">
<label for="mcc">MCC</label>
</div>
<div class="dabblePageFormField ">

<input type="checkbox" name="cert[mcc]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="your-coachs-email">*Your Coach&lsquo;s Email</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[your-coachs-email]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
<label for="date-coaching-began-with-my-coach">*The date you began or will begin Coaching with your Coach?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[date-coaching-began-with-my-coach]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
       <label for="call-length-minutes">*The length of your coaching sessions, with your certified coach, in minutes?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[call-length-minutes]" value="" />

</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
        <label for="times-a-month">*How many times you will meet, per month, with your certified coach?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[times-a-month]" value="" />

</div>
<div style="clear:both">&nbsp;</div>





                  <div class= "dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                        <label for="w1312">Comments</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1312" cols="40" rows="4" name="cert[comments]"></textarea>
                    </div>
                  </div>



<div style="clear:both">&nbsp;</div>









<div class="dabblePageTextItem">
<div class="dabblePageText">
  <p>*You are required to coach a minimum on one hour per month, with your certified coach, during the 6 month certification program.</p>
</div>
</div>






<div class="dabblePageTextItem">
<div class="dabblePageText">
           <p>The scheduling process for the actual classes (pods) will take place during the first half of the month, previous to the month, in which you are registered. The scheduling process is done via email and you will need email access during this time. See the <a href="http://www.thecoaches.com/docs/pdfs/CPCC_Info_Packet-V7.2.pdf" target="_blank">Certification Info Packet</a> for more info on the scheduling process.
</p>
</div>
</div>








<div class="dabblePageTextItem">
<div class="dabblePageText">
<h2>Section C: Materials Delivery</h2>
<p>The certification course materials are delivered in electronic format. Hard copy materials are available for an additional fee.	You will be given access and instructions to order hard copies, should you choose to, after you have been confirmed into an actual Pod and have been given access to the CPCC website. Prior to your program start date you will receive access to an online community where you can download the program materials at no additional fee.
</p>
</div>
</div>


<div class="dabblePageTextItem">
<div class="dabblePageText">
<h2>Section D: Payment Information (All prices are in U.S. Dollars)</h2>
<p>Registration: The Certification Program is a 25 week telecourse with 92 hours of coach training. Please check the appropriate box below to indicate your registration status:</p>
</div>
</div>


<div class="dabblePageFormLabel">
<div class="dabblePageFormField " style="width:55em;text-align:left;"><p><input type="checkbox" name="cert[previously-registered]" value="" /> Previously registered: Deposit on file. (The amount of your monthly auto charges will depend upon the package you chose.)</p>
</div>
</div>
<div style="clear:both">&nbsp;</div>

<div class="dabblePageFormLabel">
                                                   <div class="dabblePageFormField " style="width:55em;text-align:left;"><p><input type="checkbox" name="cert[new-registration]" value="" /> New registration: Course Tuition is $5,650. <span style="color:#c00;">A deposit of $1,200 is due with this application.</span> (Monthly auto charges will be $890 each)</p>
</div>
</div>


<div class="dabblePageTextItem">
<div class="dabblePageText">
<p>Regardless of how you registered, your remaining balance is to be paid in five automatic credit card charges each, beginning the 1st of the month following the start date of your program and approximately every 30 days thereafter. These payments will be charged to the credit card you provide. If, for any reason your account is behind, CTI may charge your card to bring your account current.</p>

</div>
</div>



<div class="dabblePageTextItem">
<div class="dabblePageText">
<h2>Section E: Agreements</h2>
<p>Thank you for enrolling in the Certification Program. You are about to begin an exciting journey toward your coaching mastery. Please note: this agreement is a legally binding instrument upon written acceptance of your participation in the program you are enrolling in unless cancelled pursuant to the Buyer&rsquo;s Right to Cancel.</p>

<p>My agreement below indicates: </p>


                                                                   <p> &bull; I have read and understand all aspects of the Certification Program as described in the Certification Program Information Packet, including the confidentiality agreement and <a href="http://www.thecoaches.com/policies" target="_blank">CTI&lsquo;s cancel, refund and transfer policies</a></p>

<p> &bull; I approve the charges CTI will make to my credit card as outlined in Section D above.</p>
<p> &bull; I agree to pay $140 for each missed supervision. </p>

<p> &bull; I understand that pod and triad calls may be recorded for training purposes or for the use of other pod members.</p>

<p> &bull; I understand that the recordings of my oral exam may be used for CTI examiner training purposes.</p>


<p> &bull; I agree to take the actions as required by the program design.</p>



<p> &bull; I intend to be a full-out team player in this program and can be counted on to encourage, coach, and support my fellow program participants to do the same.</p>
<p> &bull; Throughout the program, I can be counted on to be honest and coachable.</p>
</div>
</div>






                 <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28846">Indication of Agreement*</label>
                    </div>

                    <div class="dabblePageFormField dabblePageFormItemRequired">
                      <select id="w28846" name="cert[indication-of-agreement]">
					    <option value=""></option>
                                                 <option title="I do not agree" value="I do not agree" <?php if(isset($cert)){ echo $cert->getIndicationOfAgreement()=='I do not agree' ? 'SELECTED' : ''; } ?>>
                          I do not agree
                        </option>

                                 <option title="I agree" value="I agree" <?php if(isset($cert)){ echo $cert->getIndicationOfAgreement()=='I agree' ? 'SELECTED' : ''; } ?>>
                          I agree
                        </option>
                      </select>
                    </div>
                  </div>


<p class="qwed"></p>
             
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please be patient and <em> Click "Submit" once!
                      </em>It takes a bit for the data to be
                      recorded. Once it is finished, you will be
                      returned to the main landing page. You will need to go back to the registration page to complete the application process by submitting your credit card information.</p>

                    </div>
                  </div>
                </div>
              </div>

              <div class="clear"></div>

              <div class=
              "dabblePageSection dabblePageSectionFormActions">
                <div class="dabblePageColumn dabblePagColmn1">
                  <div class="dabblePageFormActions">
                    <span class=
                    "dabblePageFormButton dabblePageFormSubmit">
					<input name="save"
                    accesskey="s" id="dabblePageFormSubmit" value=
                    "Submit Form" type="submit" class=
                    "submit" /> 
					<?php echo button_to('Cancel',$referer, 'class=submit') ?>	
					<!-- <input name="cancel" value="Cancel"
                    type="submit" class="submit" /> -->
					</span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="dabblePageBottomLeftShadow"></div>

    <div class="dabblePageBottomRightShadow"></div>

    <div class="dabblePageBottomShadow"></div>
  </div>
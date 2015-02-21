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

<?php echo form_tag('leaders/selectionProcess', 'method=post id=dabblePageForm  class=dabblePageForm name=dabblePageForm  enctype=multipart/form-data') ?>

                <input type="hidden" name="referer" value="<?php echo url_for("leaders/selectionThankYou") ?>" />




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

<h1>Application for CTI Leadership Leader Selection</h1>



<p>Read through the application carefully before you begin to ensure you have all the required information. 
You will need to complete this form in one sitting. Please be sure that you have at least 45 minutes available before you begin.
</p>

</div>
</div>


    <h1>Section A: Contact Info</h1>


<!-- ================= TEXT INPUT: first_name ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="first_name">First Name</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="first_name" type="text" class="text" name="leaders[first_name]" value="<?php if(isset($profile)){echo $profile->getFirstName();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>


<!-- ================= TEXT INPUT: last_name ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="last_name">Last Name</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="last_name" type="text" class="text" name="leaders[last_name]" value="<?php if(isset($profile)){echo $profile->getLastName();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_address1 ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_address1">Address1</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="perm_address1" type="text" class="text" name="leaders[perm_address1]" value="<?php if(isset($profile)){echo $profile->getPermAddress1();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_address2 ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_address2">Address2</label>
   </div>
   <div class="dabblePageFormField ">
      <input id="perm_address2" type="text" class="text" name="leaders[perm_address2]" value="<?php if(isset($profile)){echo $profile->getPermAddress2();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_city ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_city">City/Town</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="perm_city" type="text" class="text" name="leaders[perm_city]" value="<?php if(isset($profile)){echo $profile->getPermCity();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_state_prov ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_state_prov">State/Province</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="perm_state_prov" type="text" class="text" name="leaders[perm_state_prov]" value="<?php if(isset($profile)){echo $profile->getPermStateProv();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_zip_postcode ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_zip_postcode">Zip/Postal Code</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="perm_zip_postcode" type="text" class="text" name="leaders[perm_zip_postcode]" value="<?php if(isset($profile)){echo $profile->getPermZipPostcode();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: perm_country ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="perm_country">Country</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="perm_country" type="text" class="text" name="leaders[perm_country]" value="<?php if(isset($profile)){echo $profile->getPermCountry();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: email1 ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="email1">Email Address</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="email1" type="text" class="text" name="leaders[email1]" value="<?php if(isset($profile)){echo $profile->getEmail1();} ?>" />

   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: telephone1 ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="telephone1">Home Phone</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="telephone1" type="text" class="text" name="leaders[telephone1]" value="<?php if(isset($profile)){echo $profile->getTelephone1();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: phone_office ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="phone_office">Office Phone</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="phone_office" type="text" class="text" name="leaders[phone_office]" value="<?php if(isset($leaders)){echo $leaders->getPhoneOffice();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: time_zone ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="time_zone">Time zone</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="time_zone" type="text" class="text" name="leaders[time_zone]" value="<?php if(isset($leaders)){echo $leaders->getTimeZone();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: telephone2 ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="telephone2">Mobile</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="telephone2" type="text" class="text" name="leaders[telephone2]" value="<?php if(isset($profile)){echo $profile->getTelephone2();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: skype ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="skype">Skype</label>
   </div>
   <div class="dabblePageFormField ">
      <input id="skype" type="text" class="text" name="leaders[skype]" value="<?php if(isset($leaders)){echo $leaders->getSkype();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>



<h1>Section B: About You</h1>

<!-- ================= TEXTAREA: education_history ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="education_history">Education history – both traditional and non-traditional</label>
       </div>
       <div class="dabblePageFormField">
           <textarea id="education_history" cols="40" rows="4" name="leaders[education_history]"><?php if(isset($leaders)){echo $leaders->getEducationHistory();} ?></textarea>
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: credentials ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="credentials">Credentials - coaching, education, ICF, etc.</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="credentials" type="text" class="text" name="leaders[credentials]" value="<?php if(isset($leaders)){echo $leaders->getCredentials();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= FILE: resume ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="resume">Attach an editable resume - must be less than 1MB (1 megabyte) in size</label>
       </div>
       <div class="dabblePageFormField">
<input type="file" id="resume" name="files[resume]" />
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= FILE: photo ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="photo">Attach a current photo - must be less than 1MB (1 megabyte) in size</label>
       </div>
       <div class="dabblePageFormField">
<input type="file" id="photo" name="files[photo]" />
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: language_fluency ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="language_fluency">Language fluency (fluency only)</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="language_fluency" type="text" class="text" name="leaders[language_fluency]" value="<?php if(isset($leaders)){echo $leaders->getLanguageFluency();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: leadership_tribe ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="leadership_tribe">CTI Leadership Tribe name and year completed</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="leadership_tribe" type="text" class="text" name="leaders[leadership_tribe]" value="<?php if(isset($leaders)){echo $leaders->getLeadershipTribe();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= SELECT: assisted_in_tribe ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="assisted_in_tribe">Assisted a CTI Leadership Tribe</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <select id="assisted_in_tribe" name="leaders[assisted_in_tribe]">
      <option value="----">-- Please select --</option>
<?php 
$assisted = 'No';
if(isset($leaders)){
 $assisted = $leaders->getAssistedInTribe();
} 
?>
                                  <option value="No"  <?php if($assisted=='No'){echo 'selected';} ?> >No</option>
                                  <option value="Yes" <?php if($assisted=='Yes'){echo 'selected';} ?> >Yes</option>
      </select>
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: tribe_name ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="tribe_name">If yes, tribe name</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="tribe_name" type="text" class="text" name="leaders[tribe_name]" value="<?php if(isset($leaders)){echo $leaders->getTribeName();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXTAREA: leading_experience ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="leading_experience">Leading experience</label>
       </div>
       <div class="dabblePageFormField">
           <textarea id="leading_experience" cols="40" rows="4" name="leaders[leading_experience]"><?php if(isset($leaders)){echo $leaders->getLeadingExperience();} ?></textarea>
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXTAREA: enrollment_experience ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="enrollment_experience">Sales/enrollment skill/experience – (we want charismatic leaders with evocative leadership skills)</label>
       </div>
       <div class="dabblePageFormField">
           <textarea id="enrollment_experience" cols="40" rows="4" name="leaders[enrollment_experience]"><?php if(isset($leaders)){echo $leaders->getEnrollmentExperience();} ?></textarea>
       </div>
   </div>
<div style="clear:both">&nbsp;</div>



<h1>Section C:  Referral</h1>
 
<p>Letter of recommendation from someone in a leadership position who is not a CTI faculty member and can write about the impact your leadership is having in the world</p>


<!-- ================= FILE: leader_recommendation ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="leader_recommendation">Leadership leader recommendation letter</label>
       </div>
       <div class="dabblePageFormField">
<input type="file" id="leader_recommendation" name="files[leader_recommendation]" />
       </div>
   </div>
<div style="clear:both">&nbsp;</div>



<h1>Section D:  Relationship to Yourself and the World Around You </h1>


<!-- ================= TEXTAREA: why_want_to_lead ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="why_want_to_lead">Why do you want to lead leadership for CTI?</label>
       </div>
       <div class="dabblePageFormField">
           <textarea id="why_want_to_lead" cols="40" rows="4" name="leaders[why_want_to_lead]"><?php if(isset($leaders)){echo $leaders->getWhyWantToLead();} ?></textarea>
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXTAREA: life_purpose ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="life_purpose">Reply to these two questions in a 3-5 minute video.  Upload your video to <a href="http://youtube.com" target="_blank">YouTube.com</a> or  <a href="http://vimeo.com" target="_blank">Vimeo.com</a> then copy and paste the URL to the following field.   
 
</label>
       </div>
       <div class="dabblePageFormField dabblePageFormItemRequired">
<ol style="margin-top:3px;">
<li>What is your life purpose and how are you living it?</li>
<li>What does your life purpose have to do with leading the leadership program?</li>
</ol>

 <input id="life_purpose" type="text" class="text" name="leaders[life_purpose]" value="<?php if(isset($leaders)){echo $leaders->getLifePurpose();} ?>" />
         
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXTAREA: quest ================= -->
<div class= "dabblePageFormItem">
       <div class="dabblePageFormLabel">
           <label for="quest">On a related note, write about a recent Quest that you have been involved with and its impact in the world</label>
       </div>
       <div class="dabblePageFormField">
           <textarea id="quest" cols="40" rows="4" name="leaders[quest]"><?php if(isset($leaders)){echo $leaders->getQuest();} ?></textarea>
       </div>
   </div>
<div style="clear:both">&nbsp;</div>

<!-- ================= TEXT INPUT: initials ================= -->
<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
      <label for="initials"> I have read and understand the Agreements for CTI Front of the Room Leadership Program Leader.  This application and all information and attachments are true and correct. (please insert your initials).</label>
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired">
      <input id="initials" type="text" class="text" name="leaders[initials]" value="<?php if(isset($leaders)){echo $leaders->getInitials();} ?>" />
   </div>
</div>
<div style="clear:both">&nbsp;</div>




<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>













<p class="qwed"></p>
             
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>
                      </em></p>

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
                                           &nbsp;&nbsp;Submitting this form make take several minutes to complete
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
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>

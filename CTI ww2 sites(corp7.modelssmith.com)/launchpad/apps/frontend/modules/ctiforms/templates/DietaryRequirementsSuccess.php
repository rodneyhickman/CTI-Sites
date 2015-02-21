<?php use_helper('Object'); ?>
<!-- This file contains the CA Step 3 form           -->

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

    <h1>Dietary Requirements <?php if($role == 'assistant'){ echo "(Assistant)"; } ?></h1>

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
               
            </div>
          </div>

          <div id="dabblePageContent">





			<?php echo form_tag('ctiforms/DietaryRequirementsProcess', 'method=post id=dabblePageForm  class=dabblePageForm') ?>
              <input id="dabblePageFocusField" name="focus" value="" type="hidden" class="hidden" />
                <input type="hidden" name="adminpid" value="<?php echo $adminpid ?>" /><!-- <?php if(isset($diet)){ echo 'authenticated'; } ?> -->
                <input type="hidden" name="role" value="<?php echo $role ?>" />
                <input type="hidden" name="referer" value="<?php echo $referer ?>" />
	  
              <div class=
              "dabblePageSection dabblePageSectionErrors">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div id="dabblePageErrors"></div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w30997">First Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w30997" name="dietary[first_name]" class=
                      "text text text" value="<?php echo $profile->getFirstName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w30983">Last Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w30983" name="dietary[last_name]" class=
                      "text text text" value="<?php echo $profile->getLastName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27261">Email*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="email" id="w27261" name="dietary[email1]"
                      class="email text text" value="<?php echo $profile->getEmail1() ?>" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w36010">Program*</label>
                    </div>

                    <div class="dabblePageFormField">

<select name="tribe_id">
    <option value="<?php echo $other_tribe_id ?>">&nbsp;</option>
<?php echo objects_for_select($tribes, 'getId', 'getDateLocation', $tribe_id) ?>
    <option value="<?php echo $other_tribe_id ?>">Other / Unknown</option>
</select>

                     
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Dietary Requirements</h1>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>The retreat center specializes in low-fat,
                      dairy and/or vegetarian optional fare that is
                      rich in flavor and full of vitality. They use
                      fresh organic produce whenever possible, top
                      quality fresh seafood and poultry. Please
                      indicate your dietary NEEDS with a yes or no
                      next to each of the following:</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionMini">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27265">Can you eat
                      Poultry?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272651" <?php if(isset($diet)){ echo $diet->getPoultry() == 'Yes' ? 'CHECKED' : ''; } ?>
    name="dietary[poultry]" value="Yes" type=
                        "radio" /> <label for=
                        "w272651">Yes</label></li>

                        <li><input class="radio radio" id="w272652" <?php if(isset($diet)){ echo $diet->getPoultry() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[poultry]" value="No" type=
                        "radio" /> <label for=
                        "w272652">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27269">Can you eat
                      Beef?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272691" <?php if(isset($diet)){ echo $diet->getBeef() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[beef]" value="Yes" type=
                        "radio" /> <label for=
                        "w272691">Yes</label></li>

                        <li><input class="radio radio" id="w272692" <?php if(isset($diet)){ echo $diet->getBeef() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[beef]" value="No" type=
                        "radio" /> <label for=
                        "w272692">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27275">Are you a Vegetarian?
                      (includes eggs &amp; dairy)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272751"  <?php if(isset($diet)){ echo $diet->getVegetarian() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[vegan_with_eggs]" value="Yes" type=
                        "radio" /> <label for=
                        "w272751">Yes</label></li>

                        <li><input class="radio radio" id="w272752"   <?php if(isset($diet)){ echo $diet->getVegetarian() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[vegan_with_eggs]" value="No" type=
                        "radio" /> <label for=
                        "w272752">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="dabblePageColumn dabblePageColumn2">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27267">Can you eat
                      Seafood?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272671"  <?php if(isset($diet)){ echo $diet->getSeafood() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[seafood]" value="Yes" type=
                        "radio" /> <label for=
                        "w272671">Yes</label></li>

                        <li><input class="radio radio" id="w272672" <?php if(isset($diet)){ echo $diet->getSeafood() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[seafood]" value="No" type=
                        "radio" /> <label for=
                        "w272672">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27271">Can you eat
                      Lamb?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272711"  <?php if(isset($diet)){ echo $diet->getLamb() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[lamb]" value="Yes" type=
                        "radio" /> <label for=
                        "w272711">Yes</label></li>

                        <li><input class="radio radio" id="w272712"  <?php if(isset($diet)){ echo $diet->getLamb() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[lamb]" value="No" type=
                        "radio" /> <label for=
                        "w272712">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w29752">Are you a Vegan?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w297521" <?php if(isset($diet)){ echo $diet->getVegan() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[vegan]" value="Yes" type=
                        "radio" /> <label for=
                        "w297521">Yes</label></li>

                        <li><input class="radio radio" id="w297522" <?php if(isset($diet)){ echo $diet->getVegan() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[vegan]" value="No" type=
                        "radio" /> <label for=
                        "w297522">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="dabblePageColumn dabblePageColumn3">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w27273">Can you eat
                      Pork?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w272731" <?php if(isset($diet)){ echo $diet->getPork() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[pork]" value="Yes" type=
                        "radio" /> <label for=
                        "w272731">Yes</label></li>

                        <li><input class="radio radio" id="w272732" <?php if(isset($diet)){ echo $diet->getPork() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[pork]" value="No" type=
                        "radio" /> <label for=
                        "w272732">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Do you have any CRUCIAL dietary
                      restrictions and/or food allergies (medically
                      related rather than preference)? If yes,
                      please describe the details below.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w30388">Do you have any other
                      Crucial Dietary Restrictions?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w303881"  <?php if(isset($diet)){ echo $diet->getDietaryRestrictions() == 'Yes' ? 'CHECKED' : ''; } ?>
                        name="dietary[crucial_dietary_restrictions]" value="Yes" type=
                        "radio" /> <label for=
                        "w303881">Yes</label></li>

                        <li><input class="radio radio" id="w303882"  <?php if(isset($diet)){ echo $diet->getDietaryRestrictions() == 'No' ? 'CHECKED' : ''; } ?>
                        name="dietary[crucial_dietary_restrictions]" value="No" type=
                        "radio" /> <label for=
                        "w303882">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w29685">Describe Dietary
                      Restrictions</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w29685" cols="40" rows="2"
   name="dietary[describe_dietary_restrictions]"><?php if(isset($diet)){ echo $diet->getDescribeRestrictions(); } ?></textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>BE PATIENT - <em>*Click "Submit" once!
                      *</em>It takes a bit for the data to be
                      recorded. Once it is finished, you will be
                      returned to the main landing page.</p>
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
  </div><script type="text/javascript">
/*<![CDATA[*/function onLoad() { DabblePageForm.path = "/web20100316/"; DabblePageForm.requiredFields = {"w30997":"First Name", "w30983":"Last Name", "w27261":"Email", "w36010":"Program", "w27265":"Can you eat Poultry?", "w27269":"Can you eat Beef?", "w27275":"Are you a Vegetarian? (includes eggs & dairy)", "w27267":"Can you eat Seafood?", "w27271":"Can you eat Lamb?", "w29752":"Are you a Vegan?", "w27273":"Can you eat Pork?", "w30388":"Do you have any other Crucial Dietary Restrictions?"};};/*]]>*/
  </script>

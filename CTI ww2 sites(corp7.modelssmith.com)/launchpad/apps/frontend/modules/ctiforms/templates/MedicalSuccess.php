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

            <h1>Medical Information Form &amp; Release of Liability  <?php if($role == 'assistant'){ echo "(Assistant)"; } ?></h1>

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
              �
            </div>
          </div>

          <div id="dabblePageContent">




              <?php echo form_tag('ctiforms/MedicalProcess', 'method=post id=dabblePageForm  class=dabblePageForm name=dabblePageForm') ?>
              <input id="dabblePageFocusField" name="focus" value="" type="hidden" class="hidden" />
        	<input type="hidden" name="adminpid" value="<?php echo $adminpid ?>" />
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
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please take your time and be certain that
                      you have completed all the required
                      information before you submit this form.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32050">First Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w32050" name="medical[first_name]" class=
                      "text text text" value="<?php echo $profile->getFirstName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32064">Last Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w32064" name="medical[last_name]" class=
                      "text text text" value="<?php echo $profile->getLastName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32379">Program*</label>
                    </div>

                    <div class="dabblePageFormField">


<select name="tribe_id">
    <option value="<?php echo $other_tribe_id ?>">&nbsp;</option>
<?php echo objects_for_select($tribes, 'getId', 'getDateLocation', $tribe_id) ?>
</select>


                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25105">Email*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="email" id="w25105" name="medical[email1]"
                                                 class="email text text" value="<?php echo $profile->getEmail1() ?>" />
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>So that we may properly care for you,
                      please provide the medical information
                      requested below and then read and agree to
                      the Participant Release of Liability.</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Our programs involve a variety of
                      activities that often include warm-ups,
                      games, group initiative problem solving, high
                      and low ropes course elements, and other
                      rigorous physical adventure activities. The
                      level of participation in a program activity
                      is up to individual choice except for
                      situations where program facilitators
                      determine that individual health factors may
                      put a participant at risk. Each participant
                      must be willing to assume the risk that he or
                      she may suffer an emotional or physical
                      injury.</p>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Section 1: Medical Information</h1>

                      <p><em>This information will remain
                      confidential.</em></p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28462">Age*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28462" name="medical[age]" class=
                      "numeric text text" value="<?php if(isset($med)){ echo $profile->getAge(); } ?>" type="text" />
                    </div>
                  </div>
                    
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28463">Date of Birth*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28463" name="medical[date_of_birth]" class=
                             "numeric text text" value="<?php if(isset($med)){ echo $profile->getDateOfBirth(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28498">Gender*</label>
                    </div>

                    <div class="dabblePageFormField">
                        <select id="w1104" name="medical[gender]">
			 <option value=""></option>
                         <option title="M" value="M" <?php echo $profile->getGender()=='Male' ? 'SELECTED' : '';  ?>>
                          M
                        </option>
                          <option title="F" value="F" <?php echo $profile->getGender()=='Female' ? 'SELECTED' : '';  ?>>
                          F
                        </option>
                      </select>

                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25107">Height*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25107" name="medical[height]" class=
                      "numeric text text" value="<?php if(isset($med)){ echo $med->getHeight_(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25109">Weight*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25109" name="medical[weight]" class=
                      "numeric text text" value="<?php if(isset($med)){ echo $med->getWeight_(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>If you have any previous injuries,
                      pre-existing conditions, special conditions
                      or pertinent medical information (e.g. recent
                      surgery) answer YES and provide an
                      explanation at the end of these questions.
                      Otherwise, answer NO.</p>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Do you have any limiting physical
                      disabilities (temporary or permanent) which
                      might impact your level of participation in
                      the Co-Active Leadership Program?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25111">Conditions
                      (physical)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251111" <?php if(isset($med)){ echo $med->getConditionsPhysical_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[conditions_physical]" value="Yes" type=
                        "radio" /> <label for=
                        "w251111">Yes</label></li>

                        <li><input class="radio radio" id="w251112" <?php if(isset($med)){ echo $med->getConditionsPhysical_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[conditions_physical]" value="No" type=
                        "radio" /> <label for=
                        "w251112">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Do you have any emotional or psychological
                      conditions which might impact your level of
                      participation in the Co-Active Leadership
                      Program?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w34903">Conditions
                      (psychological)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w349031" <?php if(isset($med)){ echo $med->getConditionsPsychological_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[conditions_psychological]" value="Yes" type=
                        "radio" /> <label for=
                        "w349031">Yes</label></li>

                        <li><input class="radio radio" id="w349032" <?php if(isset($med)){ echo $med->getConditionsPsychological_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[conditions_psychological]" value="No" type=
                        "radio" /> <label for=
                        "w349032">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Accommodation request for physical
                      disabilities. Reasonable accommodation will
                      be made to the extent it is feasible. Specify
                      if any:</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25195">Accommodations</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25195" name="medical[accommodations]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getAccommodations_(); } ?>" type="text" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionHalf">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25121">Head*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251211" <?php if(isset($med)){ echo $med->getHead_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[head]" value="Yes" type=
                        "radio" /> <label for=
                        "w251211">Yes</label></li>

                       <li><input class="radio radio" id="w251212" <?php if(isset($med)){ echo $med->getHead_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[head]" value="No" type=
                        "radio" /> <label for=
                        "w251212">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25123">Neck*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251231" <?php if(isset($med)){ echo $med->getNeck_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[neck]" value="Yes" type=
                        "radio" /> <label for=
                        "w251231">Yes</label></li>

                        <li><input class="radio radio" id="w251232" <?php if(isset($med)){ echo $med->getNeck_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[neck]" value="No" type=
                        "radio" /> <label for=
                        "w251232">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25167">Whiplash*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251671" <?php if(isset($med)){ echo $med->getWhiplash_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[whiplash]" value="Yes" type=
                        "radio" /> <label for=
                        "w251671">Yes</label></li>

                        <li><input class="radio radio" id="w251672" <?php if(isset($med)){ echo $med->getWhiplash_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[whiplash]" value="No" type=
                        "radio" /> <label for=
                        "w251672">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25125">Shoulders*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251251" <?php if(isset($med)){ echo $med->getShoulders_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[shoulders]" value="Yes" type=
                        "radio" /> <label for=
                        "w251251">Yes</label></li>

                        <li><input class="radio radio" id="w251252" <?php if(isset($med)){ echo $med->getShoulders_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[shoulders]" value="No" type=
                        "radio" /> <label for=
                        "w251252">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25127">Arms*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251271" <?php if(isset($med)){ echo $med->getArms_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[arms]" value="Yes" type=
                        "radio" /> <label for=
                        "w251271">Yes</label></li>

                        <li><input class="radio radio" id="w251272" <?php if(isset($med)){ echo $med->getArms_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[arms]" value="No" type=
                        "radio" /> <label for=
                        "w251272">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25129">Wrists*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251291" <?php if(isset($med)){ echo $med->getWrists_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[wrists]" value="Yes" type=
                        "radio" /> <label for=
                        "w251291">Yes</label></li>

                        <li><input class="radio radio" id="w251292" <?php if(isset($med)){ echo $med->getWrists_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[wrists]" value="No" type=
                        "radio" /> <label for=
                        "w251292">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25131">Hands*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251311" <?php if(isset($med)){ echo $med->getHands_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[hands]" value="Yes" type=
                        "radio" /> <label for=
                        "w251311">Yes</label></li>

                        <li><input class="radio radio" id="w251312" <?php if(isset($med)){ echo $med->getHands_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[hands]" value="No" type=
                        "radio" /> <label for=
                        "w251312">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25133">Upper Back*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251331" <?php if(isset($med)){ echo $med->getUpperBack_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[upper_back]" value="Yes" type=
                        "radio" /> <label for=
                        "w251331">Yes</label></li>

                        <li><input class="radio radio" id="w251332" <?php if(isset($med)){ echo $med->getUpperBack_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[upper_back]" value="No" type=
                        "radio" /> <label for=
                        "w251332">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25135">Lower Back*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251351" <?php if(isset($med)){ echo $med->getLowerBack_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[lower_back]" value="Yes" type=
                        "radio" /> <label for=
                        "w251351">Yes</label></li>

                        <li><input class="radio radio" id="w251352" <?php if(isset($med)){ echo $med->getLowerBack_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[lower_back]" value="No" type=
                        "radio" /> <label for=
                        "w251352">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25137">Pelvis*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251371" <?php if(isset($med)){ echo $med->getPelvis_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[pelvis]" value="Yes" type=
                        "radio" /> <label for=
                        "w251371">Yes</label></li>

                        <li><input class="radio radio" id="w251372" <?php if(isset($med)){ echo $med->getPelvis_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[pelvis]" value="No" type=
                        "radio" /> <label for=
                        "w251372">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25139">Groin*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251391" <?php if(isset($med)){ echo $med->getGroin_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[groin]" value="Yes" type=
                        "radio" /> <label for=
                        "w251391">Yes</label></li>

                        <li><input class="radio radio" id="w251392" <?php if(isset($med)){ echo $med->getGroin_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[groin]" value="No" type=
                        "radio" /> <label for=
                        "w251392">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="dabblePageColumn dabblePageColumn2">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25145">Lower Legs*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251451" <?php if(isset($med)){ echo $med->getLowerLegs_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[lower_legs]" value="Yes" type=
                        "radio" /> <label for=
                        "w251451">Yes</label></li>

                        <li><input class="radio radio" id="w251452" <?php if(isset($med)){ echo $med->getLowerLegs_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[lower_legs]" value="No" type=
                        "radio" /> <label for=
                        "w251452">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25141">Thighs*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251411" <?php if(isset($med)){ echo $med->getThighs_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[thighs]" value="Yes" type=
                        "radio" /> <label for=
                        "w251411">Yes</label></li>

                        <li><input class="radio radio" id="w251412" <?php if(isset($med)){ echo $med->getThighs_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[thighs]" value="No" type=
                        "radio" /> <label for=
                        "w251412">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25143">Knees*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251431" <?php if(isset($med)){ echo $med->getKnees_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[knees]" value="Yes" type=
                        "radio" /> <label for=
                        "w251431">Yes</label></li>

                        <li><input class="radio radio" id="w251432" <?php if(isset($med)){ echo $med->getKnees_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[knees]" value="No" type=
                        "radio" /> <label for=
                        "w251432">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25147">Ankles*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251471" <?php if(isset($med)){ echo $med->getAnkles_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[ankles]" value="Yes" type=
                        "radio" /> <label for=
                        "w251471">Yes</label></li>

                        <li><input class="radio radio" id="w251472" <?php if(isset($med)){ echo $med->getAnkles_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[ankles]" value="No" type=
                        "radio" /> <label for=
                        "w251472">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25149">Feet*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251491" <?php if(isset($med)){ echo $med->getFeet_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[feet]" value="Yes" type=
                        "radio" /> <label for=
                        "w251491">Yes</label></li>

                        <li><input class="radio radio" id="w251492" <?php if(isset($med)){ echo $med->getFeet_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[feet]" value="No" type=
                        "radio" /> <label for=
                        "w251492">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25159">Internal Organs*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251591" <?php if(isset($med)){ echo $med->getInternalOrgans_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[internal_organs]" value="Yes" type=
                        "radio" /> <label for=
                        "w251591">Yes</label></li>

                        <li><input class="radio radio" id="w251592" <?php if(isset($med)){ echo $med->getInternalOrgans_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[internal_organs]" value="No" type=
                        "radio" /> <label for=
                        "w251592">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25155">Heart*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251551" <?php if(isset($med)){ echo $med->getHeart_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[heart]" value="Yes" type=
                        "radio" /> <label for=
                        "w251551">Yes</label></li>

                        <li><input class="radio radio" id="w251552" <?php if(isset($med)){ echo $med->getHeart_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[heart]" value="No" type=
                        "radio" /> <label for=
                        "w251552">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25163">Lungs*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251631" <?php if(isset($med)){ echo $med->getLungs_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[lungs]" value="Yes" type=
                        "radio" /> <label for=
                        "w251631">Yes</label></li>

                        <li><input class="radio radio" id="w251632" <?php if(isset($med)){ echo $med->getLungs_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[lungs]" value="No" type=
                        "radio" /> <label for=
                        "w251632">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25151">Ears*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251511" <?php if(isset($med)){ echo $med->getEars_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[ears]" value="Yes" type=
                        "radio" /> <label for=
                        "w251511">Yes</label></li>

                        <li><input class="radio radio" id="w251512" <?php if(isset($med)){ echo $med->getEars_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[ears]" value="No" type=
                        "radio" /> <label for=
                        "w251512">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25153">Eyes*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251531" <?php if(isset($med)){ echo $med->getEyes_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[eyes]" value="Yes" type=
                        "radio" /> <label for=
                        "w251531">Yes</label></li>

                        <li><input class="radio radio" id="w251532" <?php if(isset($med)){ echo $med->getEyes_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[eyes]" value="No" type=
                        "radio" /> <label for=
                        "w251532">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25157">Contact Lenses*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251571" <?php if(isset($med)){ echo $med->getContactLenses_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[contact_lenses]" value="Yes" type=
                        "radio" /> <label for=
                        "w251571">Yes</label></li>

                        <li><input class="radio radio" id="w251572" <?php if(isset($med)){ echo $med->getContactLenses_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[contact_lenses]" value="No" type=
                        "radio" /> <label for=
                        "w251572">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionHalf">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25179">Dislocations*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251791" <?php if(isset($med)){ echo $med->getDislocations_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[dislocations]" value="Yes" type=
                        "radio" /> <label for=
                        "w251791">Yes</label></li>

                        <li><input class="radio radio" id="w251792" <?php if(isset($med)){ echo $med->getDislocations_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[dislocations]" value="No" type=
                        "radio" /> <label for=
                        "w251792">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25181">If So, Where?</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25181" name="medical[dislocations_where]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getDislocationsWhere_(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25165">Asthma*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251651" <?php if(isset($med)){ echo $med->getAsthma_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[asthma]" value="Yes" type=
                        "radio" /> <label for=
                        "w251651">Yes</label></li>

                        <li><input class="radio radio" id="w251652" <?php if(isset($med)){ echo $med->getAsthma_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[asthma]" value="No" type=
                        "radio" /> <label for=
                        "w251652">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25175">Do you smoke?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251751" <?php if(isset($med)){ echo $med->getDoYouSmoke_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[do_you_smoke]" value="Yes" type=
                        "radio" /> <label for=
                        "w251751">Yes</label></li>

                        <li><input class="radio radio" id="w251752" <?php if(isset($med)){ echo $med->getDoYouSmoke_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[do_you_smoke]" value="No" type=
                        "radio" /> <label for=
                        "w251752">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25177">Have You Ever
                      Smoked?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251771" <?php if(isset($med)){ echo $med->getHaveYouEverSmoked_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[have_you_ever_smoked]" value="Yes" type=
                        "radio" /> <label for=
                        "w251771">Yes</label></li>

                        <li><input class="radio radio" id="w251772" <?php if(isset($med)){ echo $med->getHaveYouEverSmoked_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[have_you_ever_smoked]" value="No" type=
                        "radio" /> <label for=
                        "w251772">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25117">Are you currently
                      pregnant?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251171" <?php if(isset($med)){ echo $med->getAreYouCurrentlyPregnant_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[are_you_currently_pregnant]" value="Yes" type=
                        "radio" /> <label for=
                        "w251171">Yes</label></li>

                        <li><input class="radio radio" id="w251172" <?php if(isset($med)){ echo $med->getAreYouCurrentlyPregnant_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[are_you_currently_pregnant]" value="No" type=
                        "radio" /> <label for=
                        "w251172">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25119">If So, Due Date</label>
                    </div>

                    <div class="dabblePageFormField">
                      <div class="popMenuButton">
                        <!-- <a class="linkButton icon calendarPicker"
                        onclick=
                        "DabblePageForm.togglePopMenu('w25119Calendar');return false"
                        title="Choose a date from a calendar" href=
                        "javascript:void(0)"><img alt=
                        "Select a date from a calendar" src=
                        "/launchpad/images/calendarPicker.gif"
                        width="13" height="15" border="0" /></a>--> <!-- /web20100316/images/icons/calendarPicker.gif -->

                        <div class="dabblePageCalendarPickerBox"
                        id="w25119Calendar" style="display: none">
                        </div>
                      </div><input id="w25119" name="medical[due_date]" class=
                      "datetime text text" value="<?php if( isset($med) && !preg_match('/1970/',$med->getDueDate()) ){ echo $med->getDueDate(); } ?>" type="text" />
                    </div>
                  </div>
                </div>

                <div class="dabblePageColumn dabblePageColumn2">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25113">History of dizziness or
                      fainting?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251131" <?php if(isset($med)){ echo $med->getDizziness_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[dizziness]" value="Yes" type=
                        "radio" /> <label for=
                        "w251131">Yes</label></li>

                        <li><input class="radio radio" id="w251132" <?php if(isset($med)){ echo $med->getDizziness_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[dizziness]" value="No" type=
                        "radio" /> <label for=
                        "w251132">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25161">High Blood
                      Pressure*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251611" <?php if(isset($med)){ echo $med->getHighBloodPressure_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[high_blood_pressure]" value="Yes" type=
                        "radio" /> <label for=
                        "w251611">Yes</label></li>

                        <li><input class="radio radio" id="w251612" <?php if(isset($med)){ echo $med->getHighBloodPressure_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[high_blood_pressure]" value="No" type=
                        "radio" /> <label for=
                        "w251612">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25115">History of heart disease
                      or heart attack?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251151" <?php if(isset($med)){ echo $med->getHeartAttack_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[heart_attack]" value="Yes" type=
                        "radio" /> <label for=
                        "w251151">Yes</label></li>

                        <li><input class="radio radio" id="w251152" <?php if(isset($med)){ echo $med->getHeartAttack_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[heart_attack]" value="No" type=
                        "radio" /> <label for=
                        "w251152">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25171">Diabetes*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251711" <?php if(isset($med)){ echo $med->getDiabetes_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[diabetes]" value="Yes" type=
                        "radio" /> <label for=
                        "w251711">Yes</label></li>

                        <li><input class="radio radio" id="w251712" <?php if(isset($med)){ echo $med->getDiabetes_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[diabetes]" value="No" type=
                        "radio" /> <label for=
                        "w251712">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for=
                      "w25169">Epilepsy/seizures*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251691" <?php if(isset($med)){ echo $med->getEpilepsySeizures_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[epilepsy_seizures]" value="Yes" type=
                        "radio" /> <label for=
                        "w251691">Yes</label></li>

                        <li><input class="radio radio" id="w251692" <?php if(isset($med)){ echo $med->getEpilepsySeizures_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[epilepsy_seizures]" value="No" type=
                        "radio" /> <label for=
                        "w251692">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25173">Other Serious
                      Illness*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251731" <?php if(isset($med)){ echo $med->getOtherSeriousIllness_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[other_serious_illness]" value="Yes" type=
                        "radio" /> <label for=
                        "w251731">Yes</label></li>

                        <li><input class="radio radio" id="w251732" <?php if(isset($med)){ echo $med->getOtherSeriousIllness_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[other_serious_illness]" value="No" type=
                        "radio" /> <label for=
                        "w251732">No</label></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please explain any of your YES answers
                      below.</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25183">Explain Yes
                      Answers</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w25183" cols="40" rows="5"
                      name="medical[explanation]"><?php if(isset($med)){ echo $med->getExplanation_(); } ?></textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please describe any allergies you have
                      including food, medicine, plants, animals
                      etc...</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25185">Allergies</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w25185" cols="40" rows="2"
                      name="medical[allergies]"><?php if(isset($med)){ echo $med->getAllergies_(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25187">Are you currently taking
                      any Medication(s)?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w251871" <?php if(isset($med)){ echo $med->getMedications_()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="medical[medications]" value="Yes" type=
                        "radio" /> <label for=
                        "w251871">Yes</label></li>

                        <li><input class="radio radio" id="w251872" <?php if(isset($med)){ echo $med->getMedications_()=='No' ? 'CHECKED' : ''; } ?>
                        name="medical[medications]" value="No" type=
                        "radio" /> <label for=
                        "w251872">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please describe each medication you are
                      taking. Please include the name, the
                      condition it treats and your dosage.</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25189">Name of
                      Medication(s):</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25189" name="medical[name_of_medications]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getNameOfMedications_(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25193">What are the
                      medication(s) for?</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w25193" cols="40" rows="2"
                      name="medical[what_are_medications_for]"><?php if(isset($med)){ echo $med->getWhatAreMedicationsFor_(); } ?></textarea>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w25191">Medication(s)
                      dosage:</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w25191" name="medical[medication_dosages]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getMedicationDosages_(); } ?>" type="text" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Section 2: Emergency Contact
                      Information</h1>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28698">Emergency Contact
                      Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28698" name="medical[emergency_contact_name]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getEmergencyContactName(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28711">Relationship
                      (Emergency)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28711" name="medical[emergency_relationship]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getEmergencyRelationship(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28724">Address
                      (Emergency)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w28724" cols="40" rows="5"
                      name="medical[emergency_address]"><?php if(isset($med)){ echo $med->getEmergencyAddress(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28737">Work Phone
                      (Emergency)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28737" name="medical[emergency_work_phone]" class=
                      "phone text text" value="<?php if(isset($med)){ echo $med->getEmergencyWorkPhone(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28750">Home Phone
                      (Emergency)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28750" name="medical[emergency_home_phone]" class=
                      "phone text text" value="<?php if(isset($med)){ echo $med->getEmergencyHomePhone(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28764">Other Phone
                      (Emergency)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28764" name="medical[emergency_other_phone]" class=
                      "phone text text" value="<?php if(isset($med)){ echo $med->getEmergencyOtherPhone(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h2>Medical Insurance and Physician
                      Contact</h2>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>NOTE: If you don't carry medical
                      insurance, we expect that you will obtain
                      incident/travel insurance for each
                      retreat.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28778">Medical Coverage Provided
                      by*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28778" name="medical[coverage_provider]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getCoverageProvider(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28792">Policy #*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28792" name="medical[policy_number]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getPolicyNumber(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28806">Other pertinent Insurance
                      Information*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28806" name="medical[other_insurance_information]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getOtherInsuranceInformation(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28819">Your Doctor's
                      Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28819" name="medical[doctors_name]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getDoctorsName(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28832">Doctor's Phone/Contact
                      Information*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w28832" name="medical[doctors_contact_info]" class=
                      "text text text" value="<?php if(isset($med)){ echo $med->getDoctorsContactInfo(); } ?>" type="text" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Section 3: Participant Release of
                      Liability</h1>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>SECTION 2: PARTICIPANT RELEASE OF
                      LIABILITY</p>

                      <p>I RECOGNIZE that there is a significant
                      element of risk in any sport or activity
                      associated with the outdoors, including ropes
                      courses and adventure programs.<br />
                      I ACKNOWLEDGE that the Coaches Training
                      Institute and each party's employees and
                      agents take all reasonable safety precautions
                      in the operation of this program. I RECOGNIZE
                      that my participation in a leadership program
                      will require that I look at myself in
                      different ways at times, and that this may
                      affect my emotions. I further recognize that
                      making changes in myself may entail some
                      emotional challenges. I am prepared to
                      experience a wide range of emotions, knowing
                      that these ups and downs are very likely
                      prerequisite to growing myself as a leader. I
                      AM AWARE that certain portions of the program
                      are physically demanding, and that I may be
                      asked to walk, run, stretch, climb, push,
                      pull and perform other rigorous and
                      potentially risky or dangerous physical
                      activities.<br />
                      I VOLUNTARILY AGREE to participate in the
                      Co-Active Leadership Program to be conducted
                      on designated dates by The Coaches Training
                      Institute and its employees and agents.<br />
                      I FURTHER AGREE to obtain a qualified medical
                      opinion and will discuss my physical
                      considerations with The Coaches Training
                      Institute if I doubt my ability to
                      participate. I AGREE to participate only to
                      the extent that my medical, physical,
                      emotional or other conditions create no undue
                      risk to myself, other participants or Program
                      Staff. I AGREE to assume full responsibility
                      for my actions and their consequences, and
                      for any inconvenience resulting from any
                      circumstance or injury to my person and/or
                      property. I AGREE that my personal insurance
                      and any provided or maintained by any other
                      person or entity, on my behalf shall
                      supersede and be used before any of the
                      insurance coverage that may be provided by
                      The Coaches Training Institute. I AGREE to
                      provide the name and policy number for my
                      health insurance provider to Program staff
                      before the first retreat, and subsequent
                      changes or updates before each of the three
                      additional retreats during the leadership
                      program. I HEREBY RELEASE, AND AGREE TO
                      INDEMNIFY AND HOLD HARMLESS The Coaches
                      Training Institute and the officers,
                      directors, contractors, employees,
                      associates, facilitators, leaders and its
                      agents, from any and all liability, claims or
                      demands (except those arising from negligence
                      of the aforementioned parties) that I, my
                      heirs, executors, administrators, assignees,
                      distributees, personal or legal
                      representatives, and all members of my
                      family, may now have or in the future make
                      for any injury, loss, death or damage of any
                      kind resulting from my participation in this
                      Program. I AGREE that any dispute concerning
                      this Agreement shall be submitted to
                      arbitration in Marin County, California, in
                      accordance with the Rules of the American
                      Arbitration Association then in effect, as a
                      condition precedent to any legal action that
                      may be taken by me or on my behalf to resolve
                      said dispute.</p>

                      <p>I HAVE READ, UNDERSTAND AND ACCEPT THE
                      TERMS AND CONDITIONS STATED HEREIN and
                      acknowledge that this Agreement shall be
                      effective and binding upon me and my heirs
                      hereafter.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w28846">Release of
                      Liability*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <select id="w28846" name="release_of_liability">
                                                 <option title="I do not accept" value="I do not accept" <?php if(isset($med)){ echo $med->getReleaseOfLiability()=='I do not accept' ? 'SELECTED' : ''; } ?> ></option>

                                 <option title="I accept" value="I accept" <?php if(isset($med)){ echo $med->getReleaseOfLiability()=='I accept' ? 'SELECTED' : ''; } ?>>
                          I accept
                        </option>
                      </select>
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
/*<![CDATA[*/function onLoad() { DabblePageForm.path = "/web20100316/"; DabblePageForm.requiredFields = {"w32050":"First Name", "w32064":"Last Name", "w32379":"Program", "w25105":"Email", "w28462":"Age", "w28498":"Gender", "w25107":"Height", "w25109":"Weight", "w25111":"Conditions (physical)", "w34903":"Conditions (psychological)", "w25121":"Head", "w25123":"Neck", "w25167":"Whiplash", "w25125":"Shoulders", "w25127":"Arms", "w25129":"Wrists", "w25131":"Hands", "w25133":"Upper Back", "w25135":"Lower Back", "w25137":"Pelvis", "w25139":"Groin", "w25145":"Lower Legs", "w25141":"Thighs", "w25143":"Knees", "w25147":"Ankles", "w25149":"Feet", "w25159":"Internal Organs", "w25155":"Heart", "w25163":"Lungs", "w25151":"Ears", "w25153":"Eyes", "w25157":"Contact Lenses", "w25179":"Dislocations", "w25165":"Asthma", "w25175":"Do you smoke?", "w25177":"Have You Ever Smoked?", "w25117":"Are you currently pregnant?", "w25113":"History of dizziness or fainting?", "w25161":"High Blood Pressure", "w25115":"History of heart disease or heart attack?", "w25171":"Diabetes", "w25169":"Epilepsy/seizures", "w25173":"Other Serious Illness", "w25187":"Are you currently taking any Medication(s)?", "w28698":"Emergency Contact Name", "w28711":"Relationship (Emergency)", "w28724":"Address (Emergency)", "w28737":"Work Phone (Emergency)", "w28750":"Home Phone (Emergency)", "w28764":"Other Phone (Emergency)", "w28778":"Medical Coverage Provided by", "w28792":"Policy #", "w28806":"Other pertinent Insurance Information", "w28819":"Your Doctor\'s Name", "w28832":"Doctor\'s Phone/Contact Information", "w28846":"Release of Liability"};; DabbleCalendar.locale = "american"; DabbleCalendar.firstDay = 0; DabbleCalendar.Create('w25119', 'w25119Calendar', { allowTime: false, selectRangeByDefault: false, selectRangeIsOptional: true })};/*]]>*/
  </script>

<?php use_helper('Object'); ?>
<!-- This file contains the CA Step 3 form           -->



  <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class="dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
              <!--[if lte IE 6]><span style="display:block;width:176px;height:57px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/publish/logo250857176.png',sizingMethod='crop')"><![endif]--><img alt="" height="57" width="176" class="png24bit" src="/publish/logo250857176.png" /><!--[if lte IE 6]></span><![endif]-->
            </div>

            <h1>Assisting Questionnaire</h1>

            <div id="dabblePageMenuLink" class="dabblePageMobileOnly dabblePageNavigationLinks">
              &nbsp;
            </div>
          </div>

          <div id="dabblePageContent">
            


	<?php echo form_tag('ctiforms/LeadershipAssistantProcess', 'method=post id=dabblePageForm  class=dabblePageForm') ?>
              <input id="dabblePageFocusField" name="focus" value="" type="hidden" class="hidden" />
                <input type="hidden" name="adminpid" value="<?php echo $adminpid ?>" /><!-- <?php if(isset($la)){ echo 'authenticated'; } ?> -->
                <input type="hidden" name="role" value="<?php echo $role ?>" />
                <input type="hidden" name="referer" value="<?php echo $referer ?>" />



              <input id="dabblePageFocusField" name="focus" value="" type="hidden" class="hidden" />

              <div class="dabblePageSection dabblePageSectionErrors">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div id="dabblePageErrors"></div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Leadership Graduate</h1>

                      <p>Please tell us about you and your Leadership Program.</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106318">First*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106318" name="questionnaire[first_name]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106320">Last*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106320" name="questionnaire[last_name]" class="text text text" value="" type="text" />
                    </div>
                  </div>



                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106332">Gender*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w1063321" name="questionnaire[gender]" value="Male" type="radio" />&nbsp;<label for="w1063321">Male</label></li>

                        <li><input class="radio radio" id="w1063322" name="questionnaire[gender]" value="Female" type="radio" />&nbsp;<label for="w1063322">Female</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106322">Graduate Tribe*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106322" name="questionnaire[graduate_tribe]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106324">Completion Date*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <div class="popMenuButton">
                        <a class="linkButton icon calendarPicker" onclick="" title="Choose a date from a calendar" href="javascript:void(0)"><img alt="Select a date from a calendar" src="/web20100316/images/icons/calendarPicker.gif" width="13" height="15" border="0" /></a>

                        <div class="dabblePageCalendarPickerBox" id="w106324Calendar" style="display: none"></div>
                      </div><input id="w106324" name="questionnaire[completion_date]" class="datetime text text" value="today" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106326">Leader 1*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106326" name="questionnaire[leader1]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106908">Leader 2*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106908" name="questionnaire[leader2]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106330">I Am Type*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w1063301" name="questionnaire[i_am_type]" value="Charm" type="radio" />&nbsp;<label for="w1063301">Charm</label></li>

                        <li><input class="radio radio" id="w1063302" name="questionnaire[i_am_type]" value="Beauty" type="radio" />&nbsp;<label for="w1063302">Beauty</label></li>

                        <li><input class="radio radio" id="w1063303" name="questionnaire[i_am_type]" value="Humor" type="radio" />&nbsp;<label for="w1063303">Humor</label></li>

                        <li><input class="radio radio" id="w1063304" name="questionnaire[i_am_type]" value="Danger" type="radio" />&nbsp;<label for="w1063304">Danger</label></li>

                        <li><input class="radio radio" id="w1063305" name="questionnaire[i_am_type]" value="Sex" type="radio" />&nbsp;<label for="w1063305">Sex</label></li>

                        <li><input class="radio radio" id="w1063306" name="questionnaire[i_am_type]" value="Eccentric" type="radio" />&nbsp;<label for="w1063306">Eccentric</label></li>

                        <li><input class="radio radio" id="w1063307" name="questionnaire[i_am_type]" value="Intelligence" type="radio" />&nbsp;<label for="w1063307">Intelligence</label></li>
                      </ul>
                    </div>
                  </div>


                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106881">Nationality*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="text" id="w106881" name="questionnaire[nationality]" class="text text text" />
                    </div>
                  </div>

              

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106501">Current Address*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106501" cols="40" rows="2" name="questionnaire[current_address]"></textarea>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106880">Telephone*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="text" id="w106880" name="questionnaire[telephone]" class="text text text" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106880">Email*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="text" id="w106880" name="questionnaire[email]" class="email text text" />
                    </div>
                  </div>

                
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Getting to Know You...</h1>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What prompted your interest in assisting for leadership?  </p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106414">Interest*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106414" cols="40" rows="2" name="questionnaire[what_prompted_you]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Describe other assisting experience, if applicable (e.g. CTI coaching workshops, other programs). What have you learned from assisting?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106427">Experience*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106427" cols="40" rows="2" name="questionnaire[experience]">
</textarea>
                    </div>
                  </div>


  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>How would you describe the impact of your Leadership Program experience to date? In what ways have you stepped into leadership?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106451">Impact*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106451" cols="40" rows="2" name="questionnaire[impact]">
</textarea>
                    </div>
                  </div>






                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Preparing for your Leadership Assisting Experience</h1>
                    </div>
                  </div>


                 <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What do you want to gain from this experience?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106475">Want to Gain*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106475" cols="40" rows="2" name="questionnaire[want_to_gain]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What do you look forward to most as a Leadership assistant?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106512">Anticipate*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106512" cols="40" rows="2" name="questionnaire[anticipate]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>A key aspect of assisting is to "hold the space" for program participants. What is your understanding of this term?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106463">Hold the Space*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106463" cols="40" rows="2" name="questionnaire[space]">
</textarea>
                    </div>
                  </div>

 
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Self-management is a critical aspect of assisting for Leadership. What is your greatest challenge in this particular area?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106574">Self-management*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106574" cols="40" rows="2" name="questionnaire[self_management]">
</textarea>
                    </div>
                  </div>


                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Are you prepared to commit four weeks of your time and energy over a ten-month period?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106488">Commit*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w1064881" name="questionnaire[commit]" value="Yes" type="radio" />&nbsp;<label for="w1064881">Yes</label></li>

                        <li><input class="radio radio" id="w1064882" name="questionnaire[commit]" value="No" type="radio" />&nbsp;<label for="w1064882">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What impact might this have on the rest of your life?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106500">Life Impact*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106500" cols="40" rows="2" name="questionnaire[life_impact]"></textarea>
                    </div>
                  </div>



                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What do you anticipate will be your greatest challenge as a Leadership assistant?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w106541">Challenge</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106541" cols="40" rows="2" name="questionnaire[challenge]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What will keep you in the program as an assistant when it gets hard?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106528">Stay*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106528" cols="40" rows="2" name="questionnaire[stay]">
</textarea>
                    </div>
                  </div>


                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What are your expectations of the leaders you will be assisting for?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106709">Expectations Leaders*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106709" cols="40" rows="2" name="questionnaire[expectations_leaders]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What are your expectations of your co-assistant?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106732">Co-assistant Expectations*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106732" cols="40" rows="2" name="questionnaire[co_assistant_expectations]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Is there anything that would be really disappointing if it wasn't present in your relationship with the leaders and/or co-assistant?</p><!-- ' -->
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106745">Disappointing*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106745" name="questionnaire[disappointing]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What can the leaders count on you for?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106757">Leaders Count On*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106757" cols="40" rows="2" name="questionnaire[leaders_count_on]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What can your co-assistant count on you for?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106769">Assistant Count On*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106769" cols="40" rows="2" name="questionnaire[assistant_count_on]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What can the participants count on you for?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106782">Participant Count On*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106782" cols="40" rows="2" name="questionnaire[participant_count_on]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>How willing and able are you to call your co-assistant forth, as needed?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106795">Call Forth*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106795" cols="40" rows="2" name="questionnaire[call_forth]">
</textarea>
                    </div>
                  </div>




    <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>In case of a medical emergency, are you certified in basic first aid and/or CPR training?  Other relevant knowledge/experience in this area?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106796">Basic First Aid Training</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106796" cols="40" rows="2" name="questionnaire[cpr]">
</textarea>
                    </div>
                  </div>






                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Do you have any physical limitations that might prevent you from climbing on ropes course days and sitting on a wooden platform for extended periods of time (2+ hours per sitting, taping high ropes)?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106808">Ropes Limitations *</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w1068081" name="questionnaire[ropes_limitations]" value="Yes" type="radio" />&nbsp;<label for="w1068081">Yes</label></li>

                        <li><input class="radio radio" id="w1068082" name="questionnaire[ropes_limitations]" value="No" type="radio" />&nbsp;<label for="w1068082">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w106821">Explain ropes limitations</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106821" cols="40" rows="2" name="questionnaire[explain_ropes_limitations]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Do you have any other physical limitations and/or specific dietary restrictions? Please describe.</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106860">Other Limitations*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w1068601" name="questionnaire[other_limitations]" value="Yes" type="radio" />&nbsp;<label for="w1068601">Yes</label></li>

                        <li><input class="radio radio" id="w1068602" name="questionnaire[other_limitations]" value="No" type="radio" />&nbsp;<label for="w1068602">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w106938">Describe other limitations</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w106938" name="questionnaire[explain_other_limitations]" class="text text text" value="" type="text" />
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Will you have transportation to the retreat center and access to a vehicle at the retreat center for errands or emergencies? Please describe.</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w106834">Transportation*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106834" cols="40" rows="2" name="questionnaire[transportation]">
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What else would you like us to know?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w106847">Anything else</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea class="max300" id="w106847" cols="40" rows="2" name="questionnaire[anything_else]">
</textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clear"></div>

              <div class="dabblePageSection dabblePageSectionFormActions">
                <div class="dabblePageColumn dabblePagColmn1">
                  <div class="dabblePageFormActions">
                    <span class="dabblePageFormButton dabblePageFormSubmit"><input name="save" accesskey="s" id="dabblePageFormSubmit" value="Submit Form" type="submit" class="submit" />&nbsp;<input name="cancel" value="Cancel" type="submit" class="submit" /></span>
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
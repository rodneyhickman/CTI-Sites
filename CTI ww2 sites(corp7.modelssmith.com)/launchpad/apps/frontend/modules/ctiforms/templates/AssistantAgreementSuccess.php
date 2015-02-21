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

            <h1>Assistant Agreement Form</h1>

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
               
            </div>
          </div>

          <div id="dabblePageContent">




              <?php echo form_tag('ctiforms/AssistantAgreementProcess', 'method=post id=dabblePageForm  class=dabblePageForm name=dabblePageForm') ?>
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
                      <input id="w32050" name="agreeform[first_name]" class=
                      "text text text" value="<?php echo $profile->getFirstName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32064">Last Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w32064" name="agreeform[last_name]" class=
                      "text text text" value="<?php echo $profile->getLastName() ?>" type="text" />
                    </div>
                  </div>


                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w25105">Email*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="email" id="w25105" name="agreeform[email1]"
                                                 class="email text text" value="<?php echo $profile->getEmail1() ?>" />
                    </div>
                  </div>



                </div>
              </div>




              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p><strong>Please read this agreement thoroughly and agree at the bottom of the page.</strong></p>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
<p style="white-space:pre-wrap">


Assumptions: As an assistant you need to be able to handle the physical rigors of the ropes course, be outside in bad weather and carry up to 20 pounds. Also know that assisting is emotionally demanding. You must have outstanding self-management and must stay disengaged from the tribe participants who you are assisting. eg. no emails, fraternizing or partying with them. You need to be clear that this is a service to the participants of The Co-Active Leadership Program.

Benefits: There is HUGE learning in it for you! You need to constantly practice being at level 4 leadership as an assistant, and that is one of the major benefits. You will always be looking for what the level 3 of the room needs from a logistics point of view; always looking for what the leaders need at level 3, so that they can give their full attention to the participants. You will be asked to constantly practice the art of listening from level 3 and level 4. You will be having regular meetings with the course leaders and from time to time your own personal learning goals will be addressed. (This is not a guarantee, however it is a strong likelihood.) Every person who has ever assisted at this program has grown to a new level of maturity as a leader, and has gained a more clear insight into what works in leading others. We ask that you take the responsibility for your own learning and your impact.

                                                                                                                                                                                                                                                                        Timing: Retreats 1,2,3,4 all begin at 10:00 am and end at 3:30pm on the last day. In US - Before R1 please come to the retreat center by 3:00pm on the Monday to prepare logistics and orient yourself to the site and equipment. In Spain: Please come to Almiral de la Font by 3:00pm on the Saturday before R1for an on-site orientation. On the evening before R1 leaders &amp; assistants get together for dinner to design their alignment. This "eat & meet" is paid for by CTI. For subsequent retreats assistants are expected to arrive at the retreat center the late afternoon/early evening prior to the start day. Please note you will be on your own for dinner &amp; breakfast before the retreat starts. Once the participants arrive and the retreat has begun, at least one assistant must be on the grounds at all times. Assistants are usually finished with inventory, storage and debrief and ready to leave the retreat center about two hours after the completion of each retreat.

Training: You will find a downloadable manual for retreat specific logistic instructions and video camera training on the Leadership Assistant website. It is essential that you dedicate time before you arrive at R1 to read the manual and watch the camera training video.
Costs: CTI covers your room and board at the retreat center. Transportation costs to and from the retreat center will be your responsibility. We suggest that the assistants carpool if at all possible. We also ask that you be willing and able to use your own car (or rental car) during the retreat for any necessary errands. Should a taxi be required for emergency requests, CTI will reimburse the cost.

Agreements: I understand that there are written instructions for each retreat. I will be responsible for reading them carefully BEFORE the beginning of the retreat, and will call the Leadership office or talk to one of the leaders if there is anything I do not understand, or cannot /will not do. I will thoroughly and accurately complete the supply inventory for each retreat, to the best of my ability.
I agree to arrive at the stated times and places on time, and be available at the retreat center for at least two hours after each retreat ends for debriefing with leaders, and inventory check/clean up. I agree to refrain from using any electronic communications device, such as a smart phone, mobile phone, iPad, laptop computer, etc., when in any common area or in the presence of any participant, unless expressly authorized by one or both of the Leaders and for the performance of my official duties as an assistant. I will keep all names and experiences of others confidential. I will also honor the confidential nature of the design of the retreats, including the timelines. I understand that the design of The Co-Active Leadership Program is intellectual property of Laura Whitworth, Karen Kimsey-House and Henry Kimsey-House, and will not share it with anyone outside of these retreats.

I agree to be fully present for all four retreats. If an emergency should arise and I cannot attend, I agree to help identify an appropriate replacement for myself, and discuss it with one of the leaders and office staff as soon as possible. 

I have read, understand, and agree to all of the above.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                                                                                                                                                                                                                                                                                                                                                                              <label for="w28846">Agreement*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <select id="w28846" name="agreeform[agreed]">
					    <option value=""></option>
                                                 <option title="I do not agree" value="no" <?php if(isset($profile)){ echo $profile->getAssistantAgreed()=='no' ? 'SELECTED' : ''; } ?>>
                          I do not agree
                        </option>

                                 <option title="I accept" value="yes" <?php if(isset($profile)){ echo $profile->getAssistantAgreed()=='yes' ? 'SELECTED' : ''; } ?>>
                          I agree
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
<p>Rev 2.12</p>
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
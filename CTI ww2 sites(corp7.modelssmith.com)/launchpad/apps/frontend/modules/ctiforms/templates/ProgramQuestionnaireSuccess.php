<?php use_helper('Object'); ?>

<!-- This file contains the CA Step 2 form           -->

  <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class=
        "dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
              <!--[if lte IE 6]><span style="display:block;width:176px;height:57px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/launchpad/images/logo250857176.png',sizingMethod='crop')"><![endif]--><img alt=""
              height="57" width="176" class="png24bit" src=
              "/launchpad/images/logo250857176.png" />
              <!--[if lte IE 6]></span><![endif]-->
            </div>

            <h1>Program Questionnaire <?php if($role == 'assistant'){ echo "(Assistant)"; } ?></h1>

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
               
            </div>
          </div>

          <div id="dabblePageContent">






			<?php echo form_tag('ctiforms/programQuestionnaireProcess', 'method=post id=dabblePageForm class=dabblePageForm') ?>
              <input id="dabblePageFocusField" name="focus" value="" type="hidden" class="hidden" />
              <input type="hidden" name="adminpid" value="<?php echo $adminpid ?>" /><!-- <?php if(isset($pq)){ echo 'authenticated'; } ?> -->
              <input type="hidden" name="role" value="<?php echo $role ?>" />
              <input type="hidden" name="referer" value="<?php echo $referer ?>" />
	  


              <div class=
              "dabblePageSection dabblePageSectionErrors">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div id="dabblePageErrors"></div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionHalf">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32464">First Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w32464" name="questionnaire[first_name]" class=
                      "text text text" value="<?php echo $profile->getFirstName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w32477">Last Name*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w32477" name="questionnaire[last_name]" class=
                      "text text text" value="<?php echo $profile->getLastName() ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1098">Program*</label>
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
                      <label for="w3587">email*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input type="email" id="w3587" name="questionnaire[email1]"
                      class="email text text" value="<?php echo $profile->getEmail1() ?>" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1104">Gender *</label>
                    </div>

                    <div class="dabblePageFormField">
                      <select id="w1104" name="questionnaire[gender]">
					    <option value=""></option>
    <option title="M" value="M" <?php if($profile->getGender()=='Male'){ echo 'SELECTED'; } ?>>
                          M
                        </option>
                          <option title="F" value="F" <?php if($profile->getGender()=='Female'){ echo  'SELECTED'; } ?>>
                          F
                        </option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="dabblePageColumn dabblePageColumn2">
                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1102">Age*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w1102" name="questionnaire[age]" class=
                      "numeric text text" value="<?php if(isset($pq)){ echo $profile->getAge(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1106">Nationality*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w1106" name="questionnaire[nationality]" class=
                      "text text text" value="<?php if(isset($pq)){ echo $pq->getNationality(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1108">Relationship
                      Status*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w1108" name="questionnaire[relationship_status]" class=
                      "text text text" value="<?php if(isset($pq)){ echo $pq->getRelationshipStatus(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1110">Current
                      Profession*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w1110" name="questionnaire[current_profession]" class=
                      "text text text" value="<?php if(isset($pq)){ echo $pq->getCurrentProfession(); } ?>" type="text" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1112">Past
                      Profession(s)*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w1112" name="questionnaire[past_profession]" class=
                      "text text text" value="<?php if(isset($pq)){ echo $pq->getPastProfession(); } ?>" type="text" />
                    </div>
                  </div>
                </div>
              </div>






              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Instructions:</h1>

                      <p>We are very excited that you have decided
                      to join us on this journey. The process of
                      expanding your reach and your leadership
                      begins here. Please use this program
                      questionnaire as a tool to open yourself to
                      the process, stretch beyond your current
                      boundaries and challenge the assumptions you
                      have about yourself and your capacity as a
                      leader.</p>
                    </div>
                  </div>
                </div>
              </div>



              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Influences:</h1>

                      <p>Who in your life was an influence in your decision to enroll in the Co-Active Leadership Program?<br />
<span style="color:#c00;">(One name per field.  Check all that apply):</span> </p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                        <input type="checkbox" name="null1" style="float:left;"> <label for="w1312">Friend.  Name (optional):</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1312a" class="w1312" cols="40" rows="1" name="questionnaire[friend1]"><?php if(isset($pq)){ echo $pq->getFriend1(); } ?></textarea>
                      <textarea id="w1312b" class="w1312" cols="40" rows="1" name="questionnaire[friend2]"><?php if(isset($pq)){ echo $pq->getFriend2(); } ?></textarea>
                      <textarea id="w1312c" class="w1312" cols="40" rows="1" name="questionnaire[friend3]"><?php if(isset($pq)){ echo $pq->getFriend3(); } ?></textarea>
                      <textarea id="w1312d" class="w1312" cols="40" rows="1" name="questionnaire[friend4]"><?php if(isset($pq)){ echo $pq->getFriend4(); } ?></textarea>
                    </div>
                  </div>
                  <div class=
                  "dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <input type="checkbox" name="null2" style="float:left;"> <label for="w1312">CTI Faculty Member.  Name:</label>
                    </div>

                    <div class="dabblePageFormField">
    <textarea id="w1312e" class="w1312" cols="40" rows="1" name="questionnaire[cti_faculty_member1]"><?php if(isset($pq)){ echo $pq->getCTIFacultyMember1(); } ?></textarea>
    <textarea id="w1312f" class="w1312" cols="40" rows="1" name="questionnaire[cti_faculty_member2]"><?php if(isset($pq)){ echo $pq->getCTIFacultyMember2(); } ?></textarea>
    <textarea id="w1312g" class="w1312" cols="40" rows="1" name="questionnaire[cti_faculty_member3]"><?php if(isset($pq)){ echo $pq->getCTIFacultyMember3(); } ?></textarea>
    <textarea id="w1312h" class="w1312" cols="40" rows="1" name="questionnaire[cti_faculty_member4]"><?php if(isset($pq)){ echo $pq->getCTIFacultyMember4(); } ?></textarea>
                    </div>
                  </div>
                  <div class=
                  "dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <input type="checkbox" name="null3" style="float:left;"> <label for="w1312">CTI Program Advisor.  Name:</label>
                    </div>

                    <div class="dabblePageFormField">
    <textarea id="w1312i" class="w1312" cols="40" rows="1" name="questionnaire[program_advisor1]"><?php if(isset($pq)){ echo $pq->getProgramAdvisor1(); } ?></textarea>
    <textarea id="w1312j" class="w1312" cols="40" rows="1" name="questionnaire[program_advisor2]"><?php if(isset($pq)){ echo $pq->getProgramAdvisor2(); } ?></textarea>
    <textarea id="w1312k" class="w1312" cols="40" rows="1" name="questionnaire[program_advisor3]"><?php if(isset($pq)){ echo $pq->getProgramAdvisor3(); } ?></textarea>
    <textarea id="w1312l" class="w1312" cols="40" rows="1" name="questionnaire[program_advisor4]"><?php if(isset($pq)){ echo $pq->getProgramAdvisor4(); } ?></textarea>
                    </div>
                  </div>
                  <div class=
                  "dabblePageFormItem">
                     <div class="dabblePageFormLabel">
                     <input type="checkbox" name="null4" style="float:left;">   <label for="w1312">Other. Please describe:</label>
                    </div>

                    <div class="dabblePageFormField">
    <textarea id="w1312m" class="w1312" cols="40" rows="1" name="questionnaire[other_influence1]"><?php if(isset($pq)){ echo $pq->getOtherInfluence1(); } ?></textarea>
    <textarea id="w1312n" class="w1312" cols="40" rows="1" name="questionnaire[other_influence2]"><?php if(isset($pq)){ echo $pq->getOtherInfluence2(); } ?></textarea>
    <textarea id="w1312o" class="w1312" cols="40" rows="1" name="questionnaire[other_influence3]"><?php if(isset($pq)){ echo $pq->getOtherInfluence3(); } ?></textarea>
    <textarea id="w1312p" class="w1312" cols="40" rows="1" name="questionnaire[other_influence4]"><?php if(isset($pq)){ echo $pq->getOtherInfluence4(); } ?></textarea>
                    </div>
                  </div>

              </div>
           </div>


              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Relationship to yourself and the world
                      around you:</h1>

                      <p>What are your current personal and
                      professional goals?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1312">Goals*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1312" cols="40" rows="2" name=
                      "questionnaire[goals]"><?php if(isset($pq)){ echo $pq->getPersonalProfessionalGoals__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What are your strengths, and how are you
                      able to use them?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1932">Strengths*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1932" cols="40" rows="2" name=
                      "questionnaire[strengths]"><?php if(isset($pq)){ echo $pq->getStrengths__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What holds you back from achieving your
                      goals and dreams?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1946">Sabateurs*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1946" cols="40" rows="2" name=
                      "questionnaire[sabateurs]"><?php if(isset($pq)){ echo $pq->getHoldsYouBack__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>This is a program that will push you to
                      the point of failing, because we believe that
                      there is great learning in failing.</p>

                      <p>1: Please describe how you handle that in
                      your life.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1960">Failure*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1960" cols="40" rows="2" name=
                      "questionnaire[failure]"><?php if(isset($pq)){ echo $pq->getHandleFailing__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>2: Are you willing to fail for the sake of
                      your learning and everyone else's? Please
                      explain.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w117815">Willingness*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w117815" cols="40" rows="2"
                      name="questionnaire[willingness]"><?php if(isset($pq)){ echo $pq->getWillingToFail__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>In this program, your leaders and
                      colleagues will tell you the truth as they
                      see it, in the service or your growth as a
                      leader. This includes specific and direct
                      feedback. Sometimes, this "truth" may be hard
                      to hear. Will you listen? Please explain.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w1973">Truth*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w1973" cols="40" rows="2" name=
                      "questionnaire[truth]"><?php if(isset($pq)){ echo $pq->getWillingToListen__(); } ?>
</textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Development History:</h1>

                      <h2>Therapeutic:</h2>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2270">Are you currently, or have
                      you ever been, in therapy?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w22701" <?php if(isset($pq)){ echo $pq->getTherapy()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="questionnaire[have_you_ever_been_in_therapy]" value="Yes" type=
                        "radio" /> <label for=
                        "w22701">Yes</label></li>

                        <li><input class="radio radio" id="w22702" <?php if(isset($pq)){ echo $pq->getTherapy()=='No' ? 'CHECKED' : ''; } ?>
                        name="questionnaire[have_you_ever_been_in_therapy]" value="No" type=
                        "radio" /> <label for=
                        "w22702">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>If so, please list when and for what
                      reason?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w2286">Therapy Details</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2286" cols="40" rows="2" name="questionnaire[therapy]"><?php if(isset($pq)){ echo $pq->getTherapyDetails__(); } ?></textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What impact has therapy had on your
                      development?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w2302">Therapy Impact</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2302" cols="40" rows="2" name=
                      "questionnaire[therapy_impact]"><?php if(isset($pq)){ echo $pq->getTherapyImpact__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h2>Coaching:</h2>

                      <p>What, if any, CTI courses have you
                      completed?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w2331">Fundamentals</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w2331" class="checkbox checkbox" <?php if(isset($pq)){ echo $pq->getFundamentals()==1 ? 'CHECKED' : ''; } ?>
                      name="questionnaire[cti_course_fundamentals]" title="Check for Yes" type=
                      "checkbox" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w4273">Intermediate Coaching
                      Curriculum</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w4273" class="checkbox checkbox" <?php if(isset($pq)){ echo $pq->getIntermediateCurriculum()==1 ? 'CHECKED' : ''; } ?>
                      name="questionnaire[cti_course_intermediate_curriculum]" title="Check for Yes" type=
                      "checkbox" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w4288">Certification</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w4288" class="checkbox checkbox" <?php if(isset($pq)){ echo $pq->getCertification()==1 ? 'CHECKED' : ''; } ?>
                      name="questionnaire[cti_course_certification]" title="Check for Yes" type=
                      "checkbox" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w4303">Quest</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w4303" class="checkbox checkbox" <?php if(isset($pq)){ echo $pq->getQuest()==1 ? 'CHECKED' : ''; } ?>
                      name="questionnaire[cti_course_quest]" title="Check for Yes" type=
                      "checkbox" />
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w4318">Internal Co-Active Coach
                      Curriculum</label>
                    </div>

                    <div class="dabblePageFormField">
                      <input id="w4318" class="checkbox checkbox" <?php if(isset($pq)){ echo $pq->getIccCurriculum()==1 ? 'CHECKED' : ''; } ?>
                      name="questionnaire[cti_course_internal_coactive_coach_curriculum]" title="Check for Yes" type=
                      "checkbox" />
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2346">Do you currently have, or
                      have you ever had a coach?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <ul class="objectFieldRadioValues">
                        <li><input class="radio radio" id="w23461" <?php if(isset($pq)){ echo $pq->getHaveACoach()=='Yes' ? 'CHECKED' : ''; } ?>
                        name="questionnaire[have_had_a_coach]" value="Yes" type=
                        "radio" /> <label for=
                        "w23461">Yes</label></li>

                        <li><input class="radio radio" id="w23462" <?php if(isset($pq)){ echo $pq->getHaveACoach()=='No' ? 'CHECKED' : ''; } ?>
                        name="questionnaire[have_had_a_coach]" value="No" type=
                        "radio" /> <label for=
                        "w23462">No</label></li>
                      </ul>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What impact has coaching had on your
                      development?</p>
                    </div>
                  </div>

                  <div class="dabblePageFormItem">
                    <div class="dabblePageFormLabel">
                      <label for="w2709">Coaching Impact</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2709" cols="40" rows="2" name=
                      "questionnaire[coaching_impact]"><?php if(isset($pq)){ echo $pq->getCoachingImpact__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h2>Spiritual:</h2>

                      <p>Please describe your religious
                      affiliations or spiritual influences</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2724">Spiritual
                      Influences*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2724" cols="40" rows="2" name=
                      "questionnaire[spiritual_influences]"><?php if(isset($pq)){ echo $pq->getReligiousAffiliations__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>How has your spiritual path influenced
                      your personal development?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2739">Spiritual Path*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2739" cols="40" rows="2" name=
                      "questionnaire[spiritual_path]"><?php if(isset($pq)){ echo $pq->getReligiousInfluences__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h2>Other Personal Growth:</h2>

                      <p>Please describe other personal growth
                      experiences that have had a significant
                      impact on you and your personal
                      development.</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w3922">Personal Growth*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w3922" cols="40" rows="5" name=
                      "questionnaire[personal_growth]"><?php if(isset($pq)){ echo $pq->getGrowthExperiences__(); } ?>
</textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dabblePageSection dabblePageSectionFull">
                <div class="dabblePageColumn dabblePageColumn1">
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <h1>Embarking on the Co-Active Leadership
                      Pathway:</h1>

                      <p>The Co-Active Leadership Program is a
                      unique opportunity to engage in a rigorous,
                      dynamic and life changing experience that
                      will challenge and stretch you. As you
                      expand, you will find that things that have
                      been out of reach will come more easily
                      within your grasp. As with most things, the
                      level to which you expand will be directly
                      proportional to your level of engagement in
                      the program. The lion's share of the learning
                      from this program will occur from
                      interactions with your colleagues. They are
                      counting on you for learning as much as you
                      will be counting on them.</p>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>We believe that Leaders always have an
                      impact on their world. What is the impact you
                      want to have, as a leader?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2754">Leadership*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2754" cols="40" rows="2" name=
                      "questionnaire[leadership]"><?php if(isset($pq)){ echo $pq->getImpactAsALeader__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>In what ways are you longing to be
                      challenged, grown and stretched?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2769">Longing to Expand*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2769" cols="40" rows="5" name=
                      "questionnaire[longing_to_expand]"><?php if(isset($pq)){ echo $pq->getChallenge__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Of all the possible things you could have
                      done to expand your leadership, why did you
                      choose this particular program?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2784">Why this program?*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2784" cols="40" rows="2" name=
                      "questionnaire[why_this_program]"><?php if(isset($pq)){ echo $pq->getWhyThisProgram__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Required homework:</p>

                      <p>This program is a 10-month program
                      designed to serve your growth as a leader in
                      the world. It includes but is not limited to
                      four retreats. In the same way we learn a
                      martial art or a musical instrument, Coactive
                      Leadership is a practice. Powerful and
                      skillful leadership occurs when one
                      practices. Inspired by the strong
                      recommendations of past participants of this
                      program, we have developed the following
                      structures and assignments to support your
                      practice.</p>

                      <ol>
                        <li>
                          <p>Group Calls.</p>

                          <p>a. You will be participating in one
                          90-minute conference call each month with
                          your entire group.</p>

                          <p>b. You will be participating in one
                          60-minute conference call each week with
                          a smaller "pod" consisting of members of
                          your group.</p>
                        </li>

                        <li>
                          <p>Website Engagement. You and your group
                          will have your own private on-line
                          learning community, where you engage in
                          assignments and share learning related to
                          the content of the previous retreat. The
                          assignments are experiential, with an
                          opportunity to reflect upon what you are
                          learning in response to the
                          assignments.</p>
                        </li>

                        <li>
                          <p>Project/Workshop/Event and Quest.</p>

                          <p>a. Following Retreat#2, you will
                          design and deliver an event, a workshop,
                          or a project with a partner from your
                          group, using Coactive Leadership skills
                          and tools that you have learned. You will
                          receive feedback on this project before
                          returning to Retreat #3.</p>

                          <p>b. Beginning in Retreat #1 and carried
                          on through the entire program, you will
                          identify and create your own Leadership
                          Quest designed to make a positive impact
                          on some aspect of your life and world. It
                          will be completely yours, with no
                          requirements to size and scope. You may
                          or may not complete the Quest by the end
                          of your program. That will be for you to
                          decide.</p>
                        </li>
                      </ol>

                      <p>Total estimated hours per week for
                      homework and calls: 3-5.</p>

                      <p>Considering your current life and
                      commitments, how available are you to play
                      "full out" in the Co-Active Leadership
                      Program on a scale of 1 to 10 (10 being the
                      highest)?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2799">Play Level*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <select id="w2799" name="questionnaire[play_level]">
					    <option value=""></option>
                        <option title="1" value="1" <?php if(isset($pq)){ echo $pq->getPlayLevel()==1 ? 'SELECTED' : ''; } ?>>
                          1
                        </option>

                        <option title="2" value="2" <?php if(isset($pq)){ echo $pq->getPlayLevel()==2 ? 'SELECTED' : ''; } ?>>
                          2
                        </option>

                        <option title="3" value="3" <?php if(isset($pq)){ echo $pq->getPlayLevel()==3 ? 'SELECTED' : ''; } ?>>
                          3
                        </option>

                        <option title="4" value="4" <?php if(isset($pq)){ echo $pq->getPlayLevel()==4 ? 'SELECTED' : ''; } ?>>
                          4
                        </option>

                        <option title="5" value="5" <?php if(isset($pq)){ echo $pq->getPlayLevel()==5 ? 'SELECTED' : ''; } ?>>
                          5
                        </option>

                        <option title="6" value="6" <?php if(isset($pq)){ echo $pq->getPlayLevel()==6 ? 'SELECTED' : ''; } ?>>
                          6
                        </option>

                        <option title="7" value="7" <?php if(isset($pq)){ echo $pq->getPlayLevel()==7 ? 'SELECTED' : ''; } ?>>
                          7
                        </option>

                        <option title="8" value="8" <?php if(isset($pq)){ echo $pq->getPlayLevel()==8 ? 'SELECTED' : ''; } ?>>
                          8
                        </option>

                        <option title="9" value="9" <?php if(isset($pq)){ echo $pq->getPlayLevel()==9 ? 'SELECTED' : ''; } ?>>
                          9
                        </option>

                        <option title="10" value="10" <?php if(isset($pq)){ echo $pq->getPlayLevel()==10 ? 'SELECTED' : ''; } ?>>
                          10
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What would it take for you to be and stay
                      at 10? Please describe any specific changes
                      in both your perspective and your behavior
                      that would support you staying at a 10?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2854">What it would
                      take*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2854" cols="40" rows="2" name=
                      "questionnaire[what_if_would_take]"><?php if(isset($pq)){ echo $pq->getWhatWouldItTake__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText"></div>
					<p></p>
                  </div>




                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>How will you bring yourself back to that
                      level of commitment when things get in the
                      way, when you don't feel like it, or when it
                      gets challenging and you want to hide?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w2991">Bringing Yourself
                      Back*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w2991" cols="40" rows="2" name=
                      "questionnaire[bringing_yourself_back]"><?php if(isset($pq)){ echo $pq->getBringYourselfBack__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>How do you know you are committed to going
                      the distance? What is your evidence?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w3006">Going the
                      Distance*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w3006" cols="40" rows="2" name=
                      "questionnaire[going_the_distance]"><?php if(isset($pq)){ echo $pq->getGoingTheDistance__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Continuing the exploration of the impact
                      you want to have as a leader, please complete
                      the following sentence (By the way, we'll be
                      re-visiting this question frequently during
                      the program):</p>

                      <p>I was born at this time in history in
                      order to....</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w3021">Purpose*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w3021" cols="40" rows="2" name=
                      "questionnaire[purpose]"><?php if(isset($pq)){ echo $pq->getIWasBornTo__(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>What else do you want us to know?</p>
                    </div>
                  </div>

                  <div class=
                  "dabblePageFormItem dabblePageFormItemRequired">
                    <div class="dabblePageFormLabel">
                      <label for="w3036">Anything Else*</label>
                    </div>

                    <div class="dabblePageFormField">
                      <textarea id="w3036" cols="40" rows="2" name=
                      "questionnaire[anything_else]"><?php if(isset($pq)){ echo $pq->getComments(); } ?>
</textarea>
                    </div>
                  </div>

                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p><em>Thank you for the time and attention
                      that you have given to this questionnaire. As
                      we stated at the beginning, your journey
                      begins now. We encourage you to stay awake
                      and aware to the ways in which the learning
                      is already unfolding. Pay attention to the
                      subtle shifts in your life: it is natural
                      when you begin a program that holds out the
                      opportunity for such change that you will
                      experience a widening range of thoughts,
                      emotions, and behaviors. You might notice new
                      awareness, synchronicities, unforeseen
                      opportunities, unexpected anxiety or even
                      some resistance. Have room for whatever comes
                      up for you. We encourage you to reach out to
                      others for support and encouragement. Keep
                      going... it will be worth it, we
                      promise!</em></p>
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
                    "dabblePageFormButton dabblePageFormSubmit"><input name="save"
                    accesskey="s" id="dabblePageFormSubmit" value=
                    "Submit Form" type="submit" class=
                    "submit" /> 
                                                 <input type="hidden" name="referer" value="<?php echo $referer ?>" />

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
/*<![CDATA[*/function onLoad() { DabblePageForm.path = "/web20100316/"; DabblePageForm.requiredFields = {"w32464":"First Name", "w32477":"Last Name", "w1098":"Program", "w3587":"email", "w1104":"Gender ", "w1102":"Age", "w1106":"Nationality", "w1108":"Relationship Status", "w1110":"Current Profession", "w1112":"Past Profession(s)", "w1312":"Goals", "w1932":"Strengths", "w1946":"Sabateurs", "w1960":"Failure", "w117815":"Willingness", "w1973":"Truth", "w2270":"Are you currently, or have you ever been, in therapy?", "w2346":"Do you currently have, or have you ever had a coach?", "w2724":"Spiritual Influences", "w2739":"Spiritual Path", "w3922":"Personal Growth", "w2754":"Leadership", "w2769":"Longing to Expand", "w2784":"Why this program?", "w2799":"Play Level", "w2854":"What it would take", "w2991":"Bringing Yourself Back", "w3006":"Going the Distance", "w3021":"Purpose", "w3036":"Anything Else"};};/*]]>*/
  </script>

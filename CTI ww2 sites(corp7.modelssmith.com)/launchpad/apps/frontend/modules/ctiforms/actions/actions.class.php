<?php



/**

 * ctiforms actions.

 *

 * @package    sf_sandbox

 * @subpackage ctiforms

 * @author     Your name here

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class ctiformsActions extends sfActions

{





 /**

  * Executes index action

  *

  * @param sfRequest $request A request object

  */

  public function executeIndex(sfWebRequest $request)

  {

     return sfView::SUCCESS;

  }







/* NEXT STEPS (Thomas) Apr 13, 2011

 *  add user session

 *  capture fn, ln, email and program in user session so that it can be prefilled in other two forms

 *  create profile with each new session

 *  capture data

 *  add XTEA encryption and decide which fields should be encrypted

 *  remove (SQ) from form titles  

 */



 /**

  * Executes BackToReferrer action 

  * This function handles the Cancel button on all forms.  It simply 

  * redirects back to the referring page.

  *

  * @param sfRequest $request A request object

  */

  public function executeBackToReferrer(sfWebRequest $request)

  {

    $this->referer = $request->getParameter('referer');  // get from form

    $this->redirect($this->referer);

  }







 /**

  * Executes AssistantAgreement action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeAssistantAgreement(sfWebRequest $request)

  {

    // example: http://ww2.thecoaches.com/launchpad/frontend_dev.php/ctiforms/AssistantAgreement?adminedit=-1&profile_id=75

 

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $loc = $request->getParameter('loc','all_sans_other');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }





    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes( $loc );



    // get tribe_id, if any

    $this->tribe_id = $this->profile->getTribeId();



    // set role

    $this->role = $request->getParameter('r','participant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







   /**

  * Executes Castep1process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeAssistantAgreementProcess(sfWebRequest $request)

  {

    $this->agreeform = $request->getParameter('agreeform');



    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else if($this->agreeform['email1'] != '' && $adminpid == -2){

      // get profile id from email (or create new profile)

      $profile = ProfilePeer::getProfileFromEmail( $this->agreeform['email1'] );

    }

    else {

      $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }

  

    

    // Set profile items

    if( $this->agreeform['first_name'] ){

      $profile->setFirstName( $this->agreeform['first_name'] );

    }

    if( $this->agreeform['last_name'] ){

      $profile->setLastName( $this->agreeform['last_name'] );

    }

    if( $this->agreeform['email1'] ){

      $profile->setEmail1( $this->agreeform['email1'] );

    }

    if( $this->agreeform['agreed'] ){

      $profile->setAssistantAgreed( $this->agreeform['agreed'] );

    }

    $profile->save();



    $referer = $request->getParameter('referer');

    if($referer != ''){

      $this->redirect($referer);

    }



    return sfView::SUCCESS;

  }

    





 /**

  * Executes Castep1form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeMedical(sfWebRequest $request)

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $loc = $request->getParameter('loc','all_sans_other');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(MedicalPeer::PROFILE_ID, $profile_id );

      $this->med = MedicalPeer::doSelectOne( $c );

      if(!$this->med){ // Create medical form if none exists

        $this->med = new Medical();

        $this->med->setProfileId( $this->profile->getId() );

        $this->med->save();

      }

      $this->med->setXTEA(new XTEA( $this->profile->getXTEAKey() ));

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }





    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes( $loc );



    // get "Other" tribe id

    $this->other_tribe_id = TribePeer::GetOtherTribeId();



    // get tribe_id, if any

    $this->tribe_id = $this->profile->getTribeId();



    // set role

    $this->role = $request->getParameter('r','participant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







   /**

  * Executes Castep1process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeMedicalProcess(sfWebRequest $request)

  {

    $this->medical = $request->getParameter('medical');







    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else if($this->medical['email1'] != '' && $adminpid == -2){

      // get profile id from email (or create new profile)

      $profile = ProfilePeer::getProfileFromEmail( $this->medical['email1'] );

    }

    else {

      $profile = ProfilePeer::getProfileFromEmail( $this->medical['email1'] );

      // $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }

  







    // Set profile items

    if( $this->medical['first_name'] ){

      $profile->setFirstName( $this->medical['first_name'] );

    }

    if( $this->medical['last_name'] ){

      $profile->setLastName( $this->medical['last_name'] );

    }

    if( $this->medical['email1'] ){

      $profile->setEmail1( $this->medical['email1'] );

    }

    if( $this->medical['gender'] ){

      $profile->setGender( $this->medical['gender'] );

    }

    $profile->setAge( $this->medical['age'] );

    $profile->setDateOfBirth( $this->medical['date_of_birth'] );

    

    $profile->save();



    // Set Tribe

    if( $request->getParameter('tribe_id') > 0 ){

      $tribe_id = $request->getParameter('tribe_id');

      $role     = $request->getParameter('role');

      $profile->setTribe( $tribe_id, $role );

    }



    // set medical items

    $c = new Criteria();

    $c->add(MedicalPeer::PROFILE_ID,$profile->getId());

    $med = MedicalPeer::doSelectOne( $c );



    if(!$med){

      $med = new Medical();

    }



    $med->setXTEA(new XTEA( $profile->getXTEAKey() ));



    $med->setProfileId( $profile->getId() );



    // Note: setters with underscore "_" will save data in encrypted form. Please see Medical.php for implementation of encryption.



    $med->setHeight_( $this->medical['height'] );

    $med->setWeight_( $this->medical['weight'] );

    $med->setConditionsPhysical_( $this->medical['conditions_physical'] );

    $med->setConditionsPsychological_( $this->medical['conditions_psychological'] );

    $med->setAccommodations_( $this->medical['accommodations'] );

    $med->setHead_( $this->medical['head'] );

    $med->setNeck_( $this->medical['neck'] );

    $med->setWhiplash_( $this->medical['whiplash'] );

    $med->setShoulders_( $this->medical['shoulders'] );

    $med->setArms_( $this->medical['arms'] );

    $med->setWrists_( $this->medical['wrists'] );

    $med->setHands_( $this->medical['hands'] );

    $med->setUpperBack_( $this->medical['upper_back'] );

    $med->setLowerBack_( $this->medical['lower_back'] );

    $med->setPelvis_( $this->medical['pelvis'] );

    $med->setGroin_( $this->medical['groin'] );

    $med->setLowerLegs_( $this->medical['lower_legs'] );

    $med->setThighs_( $this->medical['thighs'] );

    $med->setKnees_( $this->medical['knees'] );

    $med->setAnkles_( $this->medical['ankles'] );

    $med->setFeet_( $this->medical['feet'] );

    $med->setInternalOrgans_( $this->medical['internal_organs'] );

    $med->setHeart_( $this->medical['heart'] );

    $med->setLungs_( $this->medical['lungs'] );

    $med->setEars_( $this->medical['ears'] );

    $med->setEyes_( $this->medical['eyes'] );

    $med->setContactLenses_( $this->medical['contact_lenses'] );

    $med->setDislocations_( $this->medical['dislocations'] );

    $med->setDislocationsWhere_( $this->medical['dislocations_where'] );

    $med->setAsthma_( $this->medical['asthma'] );

    $med->setDoYouSmoke_( $this->medical['do_you_smoke'] );

    $med->setHaveYouEverSmoked_( $this->medical['have_you_ever_smoked'] );

    $med->setAreYouCurrentlyPregnant_( $this->medical['are_you_currently_pregnant'] );



    $med->setDueDate( date('m/d/Y',strtotime($this->medical['due_date'])) ); // untaint for date - not encrypted



    $med->setDizziness_( $this->medical['dizziness'] );

    $med->setHighBloodPressure_( $this->medical['high_blood_pressure'] );

    $med->setHeartAttack_( $this->medical['heart_attack'] );

    $med->setDiabetes_( $this->medical['diabetes'] );

    $med->setEpilepsySeizures_( $this->medical['epilepsy_seizures'] );

    $med->setOtherSeriousIllness_( $this->medical['other_serious_illness'] );

    $med->setExplanation_( $this->medical['explanation'] );

    $med->setAllergies_( $this->medical['allergies'] );

    $med->setMedications_( $this->medical['medications'] );

    $med->setNameOfMedications_( $this->medical['name_of_medications'] );

    $med->setWhatAreMedicationsFor_( $this->medical['what_are_medications_for'] );

    $med->setMedicationDosages_( $this->medical['medication_dosages'] );



    $med->setEmergencyContactName( $this->medical['emergency_contact_name'] );

    $med->setEmergencyRelationship( $this->medical['emergency_relationship'] );

    $med->setEmergencyAddress( $this->medical['emergency_address'] );



    $med->setEmergencyWorkPhone( $this->medical['emergency_work_phone'] );

    $med->setEmergencyHomePhone( $this->medical['emergency_home_phone'] );

    $med->setEmergencyOtherPhone( $this->medical['emergency_other_phone'] );

    $med->setCoverageProvider( $this->medical['coverage_provider'] );

    $med->setPolicyNumber( $this->medical['policy_number'] );

    $med->setOtherInsuranceInformation( $this->medical['other_insurance_information'] );

    $med->setDoctorsName( $this->medical['doctors_name'] );

    $med->setDoctorsContactInfo( $this->medical['doctors_contact_info'] );

    $med->setReleaseOfLiability( $request->getParameter('release_of_liability') );







    $med->save();





    // Format results for email

    $array    = $profile->getMedicalArray();

    $text     = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Medical Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to       = "leadership@coactive.com";



    // prepare email body text

    $body = "Medical Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;









    $this->due_date = $med->getDueDate();





    $this->referer = $request->getParameter('referer');

    // if($referer != ''){

    //   $this->redirect($referer);

    // }



    // show form results

    $this->text = commonTools::FormattedTextFromArray( $array );



    return sfView::SUCCESS;

  }







 /**

  * Executes Castep2form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeProgramQuestionnaire(sfWebRequest $request)

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $loc = $request->getParameter('loc','all_sans_other');



    $this->adminpid = 0;



    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(ProgramQuestionnairePeer::PROFILE_ID, $profile_id );

      $this->pq = ProgramQuestionnairePeer::doSelectOne( $c );

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $profile_id = $this->getUser()->getProfileId();

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

    }



    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes( $loc );



     // get "Other" tribe id

    $this->other_tribe_id = TribePeer::GetOtherTribeId();



   // get tribe_id, if any

    $this->tribe_id = $this->profile->getTribeId();



    // set role

    $this->role = $request->getParameter('r','participant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();







    return sfView::SUCCESS;

  }







 /**

  * Executes MCCstep2form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeProgramQuestionnaireRetreatOne(sfWebRequest $request)

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $loc = $request->getParameter('loc','all_sans_other');



    $this->adminpid = 0;



    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(ProgramQuestionnairePeer::PROFILE_ID, $profile_id );

      $this->pq = ProgramQuestionnairePeer::doSelectOne( $c );

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes( $loc );



    // get "Other" tribe id

    $this->other_tribe_id = TribePeer::GetOtherTribeId();



    // get tribe_id, if any

    $this->tribe_id = $this->profile->getTribeId();



    // set role

    $this->role = $request->getParameter('r','participant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();







    return sfView::SUCCESS;

  }







   /**

  * Executes Castep2process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeProgramQuestionnaireProcess(sfWebRequest $request)

  {



    $debug = '';



    $this->questionnaire = $request->getParameter('questionnaire');



    $adminpid = $request->getParameter('adminpid');



    try{



    $debug .= "getting and setting profile\n";



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else if($this->questionnaire['email1'] != '' && $adminpid == -2){

      // get profile id from email (or create new profile)

      $profile = ProfilePeer::getProfileFromEmail( $this->questionnaire['email1'] );

    }

    else {

      $profile = ProfilePeer::getProfileFromEmail( $this->questionnaire['email1'] );

      //$profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    $profile->setFirstName( $this->questionnaire['first_name'] );

    $profile->setLastName( $this->questionnaire['last_name'] );

    $profile->setEmail1( $this->questionnaire['email1'] );

    $profile->setGender( $this->questionnaire['gender'] );

    $profile->setAge( $this->questionnaire['age'] );

    $profile->save();



    $debug .= "setting tribe id\n";



    // Set Tribe

    $tribe_id = $request->getParameter('tribe_id');

    $role     = $request->getParameter('role');

    if($tribe_id > 0){

      $profile->setTribe( $tribe_id, $role );

    }





    $debug .= "setting up ProgramQuestionnaire\n";

    // Set Questionnaire items



    $c = new Criteria();

    $c->add(ProgramQuestionnairePeer::PROFILE_ID,$profile->getId());

    $pq = ProgramQuestionnairePeer::doSelectOne( $c );



    if(!$pq){

      $pq = new ProgramQuestionnaire();

    }





    

    $pq->setProfileId( $profile->getId() );

    $pq->save();





    $debug .= "setting values\n";

    

    // REQUIRED PARAMETERS

    $pq->setNationality(        $this->questionnaire['nationality']         );

    $pq->setRelationshipStatus( $this->questionnaire['relationship_status'] );

    $pq->setCurrentProfession(  $this->questionnaire['current_profession']  );

    $pq->setPastProfession(     $this->questionnaire['past_profession']     );



    // the following have a limit of 320 characters

    $pq->setPersonalProfessionalGoals__( $this->questionnaire['goals'] );



    $pq->setReligiousAffiliations__( $this->questionnaire['spiritual_influences'] );

    $pq->setReligiousInfluences__(   $this->questionnaire['spiritual_path']       );

    $pq->setGrowthExperiences__(     $this->questionnaire['personal_growth']      );

    $pq->setImpactAsALeader__(       $this->questionnaire['leadership']           );



    $pq->setStrengths__(       $this->questionnaire['strengths']   );

    $pq->setHoldsYouBack__(    $this->questionnaire['sabateurs']   );

    $pq->setHandleFailing__(   $this->questionnaire['failure']     );

    $pq->setChallenge__(       $this->questionnaire['longing_to_expand'] );



    $pq->setBringYourselfBack__(  $this->questionnaire['bringing_yourself_back'] );

    $pq->setGoingTheDistance__(   $this->questionnaire['going_the_distance'] );



    $pq->setWhatWouldItTake__( $this->questionnaire['what_if_would_take'] );

    $pq->setWhyThisProgram__(  $this->questionnaire['why_this_program'] );







    $pq->setWillingToFail__(   $this->questionnaire['willingness'] );

    $pq->setWillingToListen__( $this->questionnaire['truth']       );



    $pq->setHaveACoach( $this->questionnaire['have_had_a_coach'] );

    $pq->setPlayLevel( $this->questionnaire['play_level'] );

 

    $pq->setIWasBornTo__(  $this->questionnaire['purpose'] );

    $pq->setComments( $this->questionnaire['anything_else'] );





    // OPTIONAL PARAMETERS

    $pq->setFundamentals(   isset($this->questionnaire['cti_course_fundamentals'])                       );

    $pq->setIntermediateCurriculum(  isset($this->questionnaire['cti_course_intermediate_curriculum'])   );

    $pq->setCertification(  isset($this->questionnaire['cti_course_certification'])                      );

    $pq->setQuest(          isset($this->questionnaire['cti_course_quest'])                              );

    $pq->setIccCurriculum(  isset($this->questionnaire['cti_course_internal_coactive_coach_curriculum']) );



    $pq->setTherapy__(        isset($this->questionnaire['have_you_ever_been_in_therapy']) ? $this->questionnaire['have_you_ever_been_in_therapy'] : '' );

    $pq->setTherapyDetails__( isset($this->questionnaire['therapy'])        ? $this->questionnaire['therapy']        : ''  );

    $pq->setTherapyImpact__(  isset($this->questionnaire['therapy_impact']) ? $this->questionnaire['therapy_impact'] : ''  );







    $friends = array( );

    if( isset($this->questionnaire['friend']) && $this->questionnaire['friend'] != ''){

      $friends[] = $this->questionnaire['friend'];

    }

    if( isset($this->questionnaire['friend1']) && $this->questionnaire['friend1'] != ''){

      $friends[] = $this->questionnaire['friend1'];

    }

    if( isset($this->questionnaire['friend2']) && $this->questionnaire['friend2'] != ''){

      $friends[] = $this->questionnaire['friend2'];

    }

    if( isset($this->questionnaire['friend3']) && $this->questionnaire['friend3'] != ''){

      $friends[] = $this->questionnaire['friend3'];

    }

    if( isset($this->questionnaire['friend4']) && $this->questionnaire['friend4'] != ''){

      $friends[] = $this->questionnaire['friend4'];

    }

    $pq->setFriend( implode(':',$friends) );







    $faculties = array( );

    if( isset($this->questionnaire['cti_faculty_member']) && $this->questionnaire['cti_faculty_member'] != ''){

      $faculties[] = $this->questionnaire['cti_faculty_member'];

    }

    if( isset($this->questionnaire['cti_faculty_member1']) && $this->questionnaire['cti_faculty_member1'] != ''){

      $faculties[] = $this->questionnaire['cti_faculty_member1'];

    }

    if( isset($this->questionnaire['cti_faculty_member2']) && $this->questionnaire['cti_faculty_member2'] != ''){

      $faculties[] = $this->questionnaire['cti_faculty_member2'];

    }

    if( isset($this->questionnaire['cti_faculty_member3']) && $this->questionnaire['cti_faculty_member3'] != ''){

      $faculties[] = $this->questionnaire['cti_faculty_member3'];

    }

    if( isset($this->questionnaire['cti_faculty_member4']) && $this->questionnaire['cti_faculty_member4'] != ''){

      $faculties[] = $this->questionnaire['cti_faculty_member4'];

    }

    $pq->setCTIFacultyMember( implode(':',$faculties) );





   

    $advisors = array( );

    if( isset($this->questionnaire['program_advisor']) && $this->questionnaire['program_advisor'] != ''){

      $advisors[] = $this->questionnaire['program_advisor'];

    }

    if( isset($this->questionnaire['program_advisor1']) && $this->questionnaire['program_advisor1'] != ''){

      $advisors[] = $this->questionnaire['program_advisor1'];

    }

    if( isset($this->questionnaire['program_advisor2']) && $this->questionnaire['program_advisor2'] != ''){

      $advisors[] = $this->questionnaire['program_advisor2'];

    }

    if( isset($this->questionnaire['program_advisor3']) && $this->questionnaire['program_advisor3'] != ''){

      $advisors[] = $this->questionnaire['program_advisor3'];

    }

    if( isset($this->questionnaire['program_advisor4']) && $this->questionnaire['program_advisor4'] != ''){

      $advisors[] = $this->questionnaire['program_advisor4'];

    }

    $pq->setProgramAdvisor( implode(':',$advisors) );



 

    

    $others = array( );

    if( isset($this->questionnaire['other_influence']) && $this->questionnaire['other_influence'] != ''){

      $others[] = $this->questionnaire['other_influence'];

    }

    if( isset($this->questionnaire['other_influence1']) && $this->questionnaire['other_influence1'] != ''){

      $others[] = $this->questionnaire['other_influence1'];

    }

    if( isset($this->questionnaire['other_influence2']) && $this->questionnaire['other_influence2'] != ''){

      $others[] = $this->questionnaire['other_influence2'];

    }

    if( isset($this->questionnaire['other_influence3']) && $this->questionnaire['other_influence3'] != ''){

      $others[] = $this->questionnaire['other_influence3'];

    }

    if( isset($this->questionnaire['other_influence4']) && $this->questionnaire['other_influence4'] != ''){

      $others[] = $this->questionnaire['other_influence4'];

    }

    $pq->setOtherInfluence( implode(':',$others) );











    $pq->setCoachingImpact__( isset($this->questionnaire['coaching_impact']) ? $this->questionnaire['coaching_impact'] : '' );



    $pq->save();



    }



    catch (Exception $e){

      $subject  = "Exception caught in Program Questionnaire";

      $headers  = "From: admin@modelsmith.com\r\n";

      $to = "thomas@modelsmith.com";



      $form_info = print_r($this->questionnaire, true);



      // prepare email body text

      $body = "";

      $body .= "debug: $debug\n\n";

      $body .= "exception: ".$e->getMessage()."\n\n";

      $body .= "form_info: ".$form_info."\n";

      $sent = mail($to, $subject, $body, $headers) ;

      

    }



    // Format results for email

    $array = $profile->getProgramQuestionnaireArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Program Questionnaire Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "leadership@coactive.com";



    // prepare email body text

    $body = "Program Questionnaire Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;





    $this->referer = $request->getParameter('referer');

    // if($referer != ''){

    //   $this->redirect($referer);

    // }



    // show form results

    $this->text = commonTools::FormattedTextFromArray( $array );



    return sfView::SUCCESS;

  }







 /**

  * Executes Castep3form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeDietaryRequirements(sfWebRequest $request)

  {

    $profile_id     = $request->getParameter('profile_id');

    $adminedit      = $request->getParameter('adminedit');

    $loc = $request->getParameter('loc','all_sans_other');



    $this->adminpid = 0;



    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(DietaryPeer::PROFILE_ID, $profile_id );

      $this->diet = DietaryPeer::doSelectOne( $c );

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes( $loc );



    // get "Other" tribe id

    $this->other_tribe_id = TribePeer::GetOtherTribeId();



    // get tribe_id, if any

    $this->tribe_id = $this->profile->getTribeId();



    // set role

    $this->role = $request->getParameter('r','participant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







   /**

  * Executes Castep3process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeDietaryRequirementsProcess(sfWebRequest $request)

  {

    $this->dietary = $request->getParameter('dietary');

    $email         = $this->dietary['email1']; 

    $adminpid      = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else if($email != '' && $adminpid == -2){

      // get profile id from email (or create new profile)

      $profile = ProfilePeer::getProfileFromEmail( $email );

    }

    else {

      $profile = ProfilePeer::getProfileFromEmail(  $email );

      //$profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    $profile->setFirstName( $this->dietary['first_name'] );

    $profile->setLastName( $this->dietary['last_name'] );

    $profile->setEmail1( $this->dietary['email1'] );

    $profile->save();



    // Set Tribe

    $tribe_id = $request->getParameter('tribe_id');

    $role     = $request->getParameter('role');

    $profile->setTribe( $tribe_id, $role );



    // save dietary form

    $c = new Criteria();

    $c->add(DietaryPeer::PROFILE_ID,$profile->getId());

    $diet = DietaryPeer::doSelectOne( $c );



    if(!$diet){

      $diet = new Dietary();

    }



    $diet->setProfileId( $profile->getId() );

    $diet->setPoultry( $this->dietary['poultry'] );

    $diet->setBeef( $this->dietary['beef'] );

    $diet->setVegetarian( $this->dietary['vegan_with_eggs'] );

    $diet->setSeafood( $this->dietary['seafood'] );

    $diet->setLamb( $this->dietary['lamb'] );

    $diet->setVegan( $this->dietary['vegan'] );

    $diet->setPork( $this->dietary['pork'] );

    $diet->setDietaryRestrictions( $this->dietary['crucial_dietary_restrictions'] );

    $diet->setDescribeRestrictions( $this->dietary['describe_dietary_restrictions'] );



    $diet->save();



    // Format results for email

    $array = $profile->getDietaryArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Dietary Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "leadership@coactive.com";



    // prepare email body text

    $body = "Dietary Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;





    $this->referer = $request->getParameter('referer');

    // if($referer != ''){

    //   $this->redirect($referer);

    // }



    // show form results

    $this->text = commonTools::FormattedTextFromArray( $array );





    return sfView::SUCCESS;

  }



  public function executeReadDietaryCSV(sfWebRequest $request)

  {

    $this->adminpid = $request->getParameter('adminpid');

    return sfView::SUCCESS;

  }



  public function executeReadDietaryCSVProcess(sfWebRequest $request)

  {

    $adminpid = $request->getParameter('adminpid');



    $this->text;



    if($adminpid > 0){



      $target_path = "uploads/";

      $target_path = $target_path . basename( $_FILES['csv_file']['name']);

      if(move_uploaded_file($_FILES['csv_file']['tmp_name'], $target_path)) {

        if (($handle = fopen($target_path, "r")) !== FALSE) {



        // loop over CSV rows

          while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            // check to see if profile exists, based on email address

            $program    = $data[0];

            $first_name = $data[1];

            $last_name  = $data[2];

            $email      = $data[5];



            $this->text .= "$program, $first_name, $last_name, $email<br />";



            if(0){

              $c = new Criteria();

              $c->add(ProfilePeer::EMAIL1, $email);



              // Set profile items

              $profile->setFirstName( $this->dietary['first_name'] );

              $profile->setLastName( $this->dietary['last_name'] );

              $profile->setEmail1( $this->dietary['email1'] );

              $profile->save();

          

              // Set Tribe

              $tribe_id = $request->getParameter('tribe_id');

              $role     = $request->getParameter('role');

              $profile->setTribe( $tribe_id, $role );

          

              // save dietary form

              $c = new Criteria();

              $c->add(DietaryPeer::PROFILE_ID,$profile->getId());

              $diet = DietaryPeer::doSelectOne( $c );



              if(!$diet){

                $diet = new Dietary();

              }



              $diet->setProfileId( $profile->getId() );

              $diet->setPoultry( $this->dietary['poultry'] );

              $diet->setBeef( $this->dietary['beef'] );

              $diet->setVegetarian( $this->dietary['vegan_with_eggs'] );

              $diet->setSeafood( $this->dietary['seafood'] );

              $diet->setLamb( $this->dietary['lamb'] );

              $diet->setVegan( $this->dietary['vegan'] );

              $diet->setPork( $this->dietary['pork'] );

              $diet->setDietaryRestrictions( $this->dietary['crucial_dietary_restrictions'] );

              $diet->setDescribeRestrictions( $this->dietary['describe_dietary_restrictions'] );



              $diet->save();

            }

          }

        }

      }

    }

    return sfView::SUCCESS;

  }









 /**

  * Executes Castep3form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeLeadershipAssistant(sfWebRequest $request)

  {

    $profile_id     = $request->getParameter('profile_id');

    $adminedit      = $request->getParameter('adminedit');

    $this->adminpid = 0;



    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(ProgramQuestionnairePeer::PROFILE_ID, $profile_id );

      $this->la = ProgramQuestionnairePeer::doSelectOne( $c );

      // PLEASE NOTE: the leadership assistant form is overloaded onto the program questionnaire table

      // See ProgramQuestionnaire.php model for definitions



      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // get list of tribes

    $this->tribes = TribePeer::CurrentTribes();



    // get "Other" tribe id

    $this->other_tribe_id = TribePeer::GetOtherTribeId();





    // get tribe_id, if any

    if(is_object($this->profile)){

      $this->tribe_id = $this->profile->getTribeId();

    }

    else {

      $this->tribe_id = 0;

    }



    // set role

    $this->role = $request->getParameter('r','assistant');



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }





   /**

  * Executes Castep2process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeLeadershipAssistantProcess(sfWebRequest $request)

  {



    $this->questionnaire = $request->getParameter('questionnaire');



    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else {

      $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    $profile->setFirstName( $this->questionnaire['first_name'] );

    $profile->setLastName( $this->questionnaire['last_name'] );

    $profile->setEmail1( $this->questionnaire['email'] );

    $profile->setGender( $this->questionnaire['gender'] );



    $profile->save();





    // Set Tribe

    //$tribe_id = $request->getParameter('tribe_id');

    //$role     = $request->getParameter('role');

    //$profile->setTribe( $tribe_id, $role );



    // Set Questionnaire items

      // PLEASE NOTE: the leadership assistant form is overloaded onto the program questionnaire table

      // See ProgramQuestionnaire.php model for definitions



    $c = new Criteria();

    $c->add(ProgramQuestionnairePeer::PROFILE_ID,$profile->getId());

    $pq = ProgramQuestionnairePeer::doSelectOne( $c );



    if(!$pq){

      $pq = new ProgramQuestionnaire();

    }





    $pq->setProfileId( $profile->getId() );

    $pq->setLAGraduationTribe( $this->questionnaire['graduate_tribe'] );

    $pq->setLACompletionDate( $this->questionnaire['completion_date'] );

    $pq->setLALeader1( $this->questionnaire['leader1'] );

    $pq->setLALeader2( $this->questionnaire['leader2'] );

    //$pq->setLASoulType( $this->questionnaire['soul_type'] ); // leadership no longer does soul_type



    $misc = array( );

    $misc['iam'] = $this->questionnaire['i_am_type'];

    $misc['nat'] = $this->questionnaire['nationality'];

    $misc['add'] = $this->questionnaire['current_address'];

    $misc['tel'] = $this->questionnaire['telephone'];



    $pq->setLAMisc( json_encode( $misc ) );



    //$pq->setLAIAmType( $this->questionnaire['i_am_type'] ); // see LAMisc



    $pq->setLACPR(  $this->questionnaire['cpr'] );

    $pq->setLAImpact( $this->questionnaire['impact'] );

    $pq->setLAWhatPromptedYou( $this->questionnaire['what_prompted_you'] );

    $pq->setLAExperience( $this->questionnaire['experience'] );



    $pq->setLASpace( $this->questionnaire['space'] );

    $pq->setLAWantToGain( $this->questionnaire['want_to_gain'] );

    $pq->setLACommit( $this->questionnaire['commit'] );

    $pq->setLALifeImpact( $this->questionnaire['life_impact'] );

    $pq->setLAAnticipate( $this->questionnaire['anticipate'] );

    $pq->setLAChallenge( $this->questionnaire['challenge'] );

    $pq->setLAStay( $this->questionnaire['stay'] ); 

    $pq->setLASelfManagement( $this->questionnaire['self_management'] );             

    $pq->setLAExpectationsLeaders( $this->questionnaire['expectations_leaders'] ); 



    $pq->setLACoAssistantExpectations( $this->questionnaire['co_assistant_expectations'] );

    $pq->setLADisappointing( $this->questionnaire['disappointing'] );

    $pq->setLALeadersCountOn( $this->questionnaire['leaders_count_on'] );

    $pq->setLAParticipantCountOn( $this->questionnaire['participant_count_on'] );

    $pq->setLACallForth( $this->questionnaire['call_forth'] );

    $pq->setLARopesLimitations( $this->questionnaire['ropes_limitations'] );

    $pq->setLAExplainRopesLimitations( $this->questionnaire['explain_ropes_limitations'] );

    $pq->setLAOtherLimitations( $this->questionnaire['other_limitations'] );

    $pq->setLAExplainOtherLimitations( $this->questionnaire['explain_other_limitations'] );

    $pq->setLATransportation( $this->questionnaire['transportation'] );

    $pq->setLAAnythingElse( $this->questionnaire['anything_else'] );

 



    $pq->save();



 

    // Format results for email

    $array = $profile->getLeadershipAssistantArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Leadership Assistant Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "marsha@thecoaches.com,stephanier@coactive.com,thomas@modelsmith.com";



    // prepare email body text

    $body = "Leadership Assistant Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;



    

   

  $this->referer = $request->getParameter('referer');

    // if($referer != ''){

    //   $this->redirect($referer);

    // }



    // show form results

    $this->text = commonTools::FormattedTextFromArray( $array );





    return sfView::SUCCESS;

  }









  public function executeGetTribeId(sfWebRequest $request)

  {

    $this->output = TribePeer::GetTribeIdFromText( $request->getParameter('tribe') );



    $this->setLayout(false);

    return sfView::SUCCESS;

  }



  public function executeGetTribeFromName(sfWebRequest $request)

  {

    $this->output = TribePeer::GetTribeIdFromName( $request->getParameter('tribe') );



    $this->setLayout(false);

    $this->setTemplate('getTribeId');

    return sfView::SUCCESS;

  }



  public function executeGetProfileId(sfWebRequest $request)

  {

    $profile = ProfilePeer::GetProfileFromEmail( $request->getParameter('email') );

    $this->output = $profile->getId();



    $this->setLayout(false);

    $this->setTemplate('getTribeId');

    return sfView::SUCCESS;

  }















 /**

  * Executes Castep1form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeCertification(sfWebRequest $request)

  {

     $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(CertificationPeer::PROFILE_ID, $profile_id );

      $this->cert = CertificationPeer::doSelectOne( $c );

      if(!$this->cert){ // Create certification form if none exists

        $this->cert = new Certification();

        $this->cert->setProfileId( $this->profile->getId() );

        $this->cert->save();

      }

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session (new profile created if it doesn't exist)

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // months option

    $this->months = CertificationPeer::certificationMonthOptions();



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }

  public function executeCertification2013(sfWebRequest $request)

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(CertificationPeer::PROFILE_ID, $profile_id );

      $this->cert = CertificationPeer::doSelectOne( $c );

      if(!$this->cert){ // Create certification form if none exists

        $this->cert = new Certification();

        $this->cert->setProfileId( $this->profile->getId() );

        $this->cert->save();

      }

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session (new profile created if it doesn't exist)

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // months option

    $this->months = CertificationPeer::certificationMonthOptions();



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







   /**

  * Executes Castep2process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeCertificationProcess(sfWebRequest $request)

  {



    $this->cert = $request->getParameter('cert');



    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else {

      $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    $profile->setFullName( $this->cert['name'] );

    $profile->setEmail1( $this->cert['email'] );



    $profile->save();





    $c = new Criteria();

    $c->add( CertificationPeer::PROFILE_ID, $profile->getId() );

    $cert = CertificationPeer::doSelectOne( $c );



    if(!$cert){

      $cert = new Certification();

    }





    $cert->setProfileId( $profile->getId() );

    $cert->setAddress( $this->cert['address'] );

    $cert->setAddress2( $this->cert['address-2'] );

    $cert->setCity( $this->cert['city'] );

    $cert->setStateProvince( $this->cert['stateprovince'] );

    $cert->setCountry( $this->cert['country'] );

    $cert->setZipPostalCode( $this->cert['zippostal-code'] );

    $cert->setEveningPhone( $this->cert['evening-phone'] );

    $cert->setDayPhone( $this->cert['day-phone'] );



    $cert->setEmail( $this->cert['email'] );

    $cert->setFax( $this->cert['fax'] );

    $cert->setMobile( $this->cert['mobile'] );

    $cert->setHowManyClients( $this->cert['how-many-clients-do-you-currently-have'] );



    // months option

    $months = CertificationPeer::certificationMonthOptions();

    $cert->setMonthToBegin( $months[ $this->cert['month-to-begin-certification'] ] );



    $cert->setLanguagesCoaching( $this->cert['languages-in-which-you-are-coaching'] );

    $cert->setDateCompletedProcess( $this->cert['date-completed-process'] );

    $cert->setDateOfSynergy( $this->cert['date-of-synergy-in-the-bones'] );

    $cert->setYourCertifiedCoach( $this->cert['your-certified-coach'] );

    if( isset($this->cert['cpcc']) ){

      $cert->setCpcc( $this->cert['cpcc'] ? 1 : 0 );

    }

    if( isset($this->cert['pcc']) ){

      $cert->setPcc( $this->cert['pcc'] ? 1 : 0  );

    }

    if( isset($this->cert['mcc']) ){

      $cert->setMcc( $this->cert['mcc'] ? 1 : 0  );

    }

    $cert->setYourCoachsEmail( $this->cert['your-coachs-email'] );

    $cert->setDateCoachingBegan( $this->cert['date-coaching-began-with-my-coach'] );

    $cert->setCallLength( $this->cert['call-length-minutes'] );

    $cert->setTimesAMonth( $this->cert['times-a-month'] );

    if( isset($this->cert['previously-registered']) ){

      $cert->setPreviouslyRegistered( $this->cert['previously-registered'] );

    }

    if( isset($this->cert['new-registration']) ){

      $cert->setNewRegistration( $this->cert['new-registration'] );

    }

    $cert->setIndicationOfAgreement( $this->cert['indication-of-agreement'] );

    $cert->setComments( $this->cert['comments'] );

        $cert->setStartMonthDeclaration( 0 );





    $cert->save();



    // Ticket #524: Sending emails to application@coactive.com instead of barb@thecoaches.com

    // Format results for email to application@coactive.com

    $array = $profile->getCertificationArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Certification Application Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "application@coactive.com";



    // prepare email body text

    $body = "Certification Application Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;





    // Format results for confirmation email

    $subject  = "Certification Application Confirmation";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = $profile->getEmail1();



    // prepare email body text

    $body = "Your certification application has successfully been submitted.  You will receive further information from the Certification Program Specialist as soon as your application has been processed.\n\nCoaches Training Institute\n\n";



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;



 

    // add to "unassigned" POD

    // PODs are no longer needed by the CTI certification administrator, but they are needed

    // for the functions here to work, so a PodParticipant is set here

    $c = new Criteria();

    $c->add(PodParticipantPeer::PROFILE_ID, $profile->getId() );

    $pp = PodParticipantPeer::doSelectOne( $c );

    if( !isset($pp) ){

      $pp = new PodParticipant();

      $pp->setProfileId( $profile->getId() );

      $pp->setPodId( PodPeer::GetUnassignedPodId() );

      $pp->save();

    }



    $referer = $request->getParameter('referer');

    if($referer != ''){

      $this->redirect($referer);

    }



    return sfView::SUCCESS;

  }

















/* =========== Declare Start Month form ============= */







 /**

  * Executes Castep1form action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeDeclareStartMonth(sfWebRequest $request)

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(CertificationPeer::PROFILE_ID, $profile_id );

      $this->cert = CertificationPeer::doSelectOne( $c );

      if(!$this->cert){ // Create certification form if none exists

        $this->cert = new Certification();

        $this->cert->setProfileId( $this->profile->getId() );

        $this->cert->save();

      }

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session (new profile created if it doesn't exist)

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // months option

    $this->months = CertificationPeer::certificationMonthOptions();



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







   /**

  * Executes Castep2process action

  * This function will process the form data

  *

  * @param sfRequest $request A request object

  */

  public function executeDeclareStartMonthProcess(sfWebRequest $request)

  {



    $this->cert = $request->getParameter('cert');



    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else {

      $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    //$profile->setFullName( $this->cert['name'] );

    $profile->setFirstName( $this->cert['first-name'] );

    $profile->setLastName( $this->cert['last-name'] );

    $profile->setEmail1( $this->cert['email'] );



    $profile->save();







    $c = new Criteria();

    $c->add( CertificationPeer::PROFILE_ID, $profile->getId() );

    $cert = CertificationPeer::doSelectOne( $c );



    if(!$cert){

      $cert = new Certification();

    }





    $cert->setProfileId( $profile->getId() );



    // months option

    $months = CertificationPeer::certificationMonthOptions();

    $cert->setMonthToBegin( $months[ $this->cert['month-to-begin-certification'] ] );

    $cert->setEmail( $this->cert['email'] );

    $cert->setStartMonthDeclaration( 1 );



    $cert->save();





    // Ticket #524: Sending emails to application@coactive.com instead of barb@thecoaches.com

    // Format results for email

    $array = $profile->getDeclareMonthArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from Start Month Declaration Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "application@coactive.com";



    // prepare email body text

    $body = " Start Month Declaration Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;







 

    // add to "unassigned" POD

    // PODs are no longer needed by the CTI certification administrator, but they are needed

    // for the functions here to work, so a PodParticipant is set here

    $c = new Criteria();

    $c->add(PodParticipantPeer::PROFILE_ID, $profile->getId() );

    $pp = PodParticipantPeer::doSelectOne( $c );

    if( !isset($pp) ){

      $pp = new PodParticipant();

      $pp->setProfileId( $profile->getId() );

      $pp->setPodId( PodPeer::GetUnassignedPodId() );

      $pp->save();

    }



    $referer = $request->getParameter('referer');

    if($referer != ''){

      $this->redirect($referer);

    }



    return sfView::SUCCESS;

  }



















  /***************************************************************************************************************************************

  * Executes AnnualQuestionnaire action

  * This function will diplay the form

  *

  * @param sfRequest $request A request object

  */

  public function executeAnnualQuestionnaire(sfWebRequest $request)  

  {

    $profile_id = $request->getParameter('profile_id');

    $adminedit = $request->getParameter('adminedit');

    $this->adminpid = 0;

    

    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){

      // get form values if this is admin edit

      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values

      $c = new Criteria();

      $c->add(AnnualQuestionnairePeer::PROFILE_ID, $profile_id );

      $this->annual = AnnualQuestionnairePeer::doSelectOne( $c );

      if(!$this->annual){ // Create certification form if none exists

        $this->annual = new AnnualQuestionnaire();

        $this->annual->setProfileId( $this->profile->getId() );

        $this->annual->save();

      }

      // adminpid becomes profile_id

      $this->adminpid = $profile_id;

    }

    else {

      // otherwise get profile from user session (new profile created if it doesn't exist)

      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // tribes option

    $this->tribes = AnnualQuestionnairePeer::futureTribes();



    // iam option

    $this->iam_types = AnnualQuestionnairePeer::iAmTypes();



    // get refering url and pass to form

    $this->referer = $this->getRequest()->getReferer();



    return sfView::SUCCESS;

  }







  /**

   * Executes Castep2process action

   * This function will process the form data

   *

   * @param sfRequest $request A request object

   */

  public function executeAnnualQuestionnaireProcess(sfWebRequest $request)

  {



    $this->annual = $request->getParameter('annual');



    $adminpid = $request->getParameter('adminpid');



    if($adminpid > 0){

      // adminpid > 0 means that the form is being edited by admin

      $profile = ProfilePeer::retrieveByPk( $adminpid );

    }

    else {

      $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );

    }



    // Set profile items

    $profile->setFirstName( $this->annual['first_name'] );

    $profile->setLastName(  $this->annual['last_name'] );

    $profile->setFullName(  $this->annual['first_name'] .' '. $this->annual['last_name'] );

    $profile->setEmail1(    $this->annual['contact_email'] );



    $profile->save();





    $c = new Criteria();

    $c->add( AnnualQuestionnairePeer::PROFILE_ID, $profile->getId() );

    $annual = AnnualQuestionnairePeer::doSelectOne( $c );



    if(!$annual){

      $annual = new AnnualQuestionnaire();

    }



    $annual->setProfileId( $profile->getId() );

    $annual->setContactEmail( $this->annual['contact_email'] );

    $annual->setContactTelephone( $this->annual['contact_telephone'] );



    $tribes = AnnualQuestionnairePeer::futureTribes();

    $annual->setTribeFirstChoice( $tribes[$this->annual['tribe_first_choice']] );

    $annual->setTribeSecondChoice( $tribes[$this->annual['tribe_second_choice']] );



    $iam_types = AnnualQuestionnairePeer::iAmTypes();

    $annual->setIAmType( $iam_types[$this->annual['i_am_type']] );



    $annual->setYourTribeName( $this->annual['your_tribe_name'] );

    $annual->setYourTribeLeader1( $this->annual['your_tribe_leader_1'] );

    $annual->setYourTribeLeader2( $this->annual['your_tribe_leader_2'] );

    $annual->setAnythingElse( $this->annual['anything_else_youd_like_us_to_know'] );



    $annual->save();



    // Format results for email

    $array = $profile->getAnnualQuestionnaireArray();

    $text = commonTools::FormattedTextFromArray( $array );

    $subject  = "Form Results from AnnualQuestionnaire Application Form";

    $headers  = "From: webserver@thecoaches.com\r\n";

    $to = "thomas@modelsmith.com,stephanier@coactive.com";



    // prepare email body text

    $body = "AnnualQuestionnaire Application Form for ".$profile->getName().". Please keep this information for your records.\n\n";

    $body .= $text;



    // Send email

    $sent = mail($to, $subject, $body, $headers) ;





 

    $referer = $request->getParameter('referer');

    if($referer != ''){

      $this->redirect($referer);

    }



    return sfView::SUCCESS;

  }





















  public function executeAnnualQuestionnaireThankYou(sfWebRequest $request)

  {



   return sfView::SUCCESS;

  }







// TO DO: May 16, 2011 T. Beutel

// * add executeGetProfileID - to get id from email address

// * change forms to accept profile id and tribe id and adminpid = -2

// * write perl programs to loop through CSV files and submit data

// ** see http://search.cpan.org/~gbauer/HTTP-Request-Form-0.952/Form.pm



}


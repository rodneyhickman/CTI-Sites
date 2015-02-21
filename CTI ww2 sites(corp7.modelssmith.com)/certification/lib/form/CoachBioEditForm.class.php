<?php

/**
 * CoachProfileEdit form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class CoachBioEditForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'first_name'            => new sfWidgetFormInput(),
      'middle_initial'        => new sfWidgetFormInput(),
      'last_name'             => new sfWidgetFormInput(),
      'coaching_credential'   => new sfWidgetFormInput(),
      'street_address'        => new sfWidgetFormTextarea(),
      'city'                  => new sfWidgetFormInput(),
      'prov_since'            => new sfWidgetFormInput(),
      'country'               => new sfWidgetFormInput(),
      'company_name'          => new sfWidgetFormInput(),
      'business_phone'        => new sfWidgetFormInput(),
      'website'               => new sfWidgetFormInput(),
      'niche1'                => new sfWidgetFormInput(),
      'niche2'                => new sfWidgetFormInput(),
      'niche3'                => new sfWidgetFormInput(),
      'cert_pod_name'         => new sfWidgetFormInput(),
      'cti_leadership_group'  => new sfWidgetFormInput(),
      'professional_life_exp' => new sfWidgetFormTextarea(),
      'bio'                   => new sfWidgetFormTextarea(),
      'memberships'           => new sfWidgetFormInput(),
      'time_zone'             => new sfWidgetFormInput()

    ));

    //    $this->setValidators(array(
    //      'name'    => new sfValidatorString(array('required' => false)),
    //      'email'   => new sfValidatorEmail(),
    //      'subject' => new sfValidatorChoice(array('choices' => array_keys(self::$subjects))),
    //      'message' => new sfValidatorString(array('min_length' => 4)),
    //    ));


    $this->widgetSchema->setLabels(array(
                                     'first_name'            => 'First Name',
                                     'middle_initial'        => 'Middle Initial',
                                     'last_name'             => 'Last Name',
                                     'coaching_credential'   => 'Coaching Credential(s) (i.e. CPCC, PCC, etc.)',
                                     'street_address'        => 'Street Address',
                                     'city'                  => 'City',
                                     'prov_state'            => 'State or Province',
                                     'country'               => 'Country',
                                     'company_name'          => 'Company Name',
                                     'business_phone'        => 'Business Phone',
                                     'website'               => 'Website',
                                     'niche1'                => 'Niche 1',
                                     'niche2'                => 'Niche 2',
                                     'niche3'                => 'Niche 3',
                                     'cert_pod_name'         => 'CTI Certification Pod Name',
                                     'cti_leadership_group'  => 'CTI Leadership Group Name',
                                     'professional_life_exp' => 'Professional and Life Experiences',
                                     'bio'                   => 'Brief Bio',
                                     'memberships'           => 'Memberships and Associations',
                                     'time_zone'             => 'Time Zone'
    ));
  }
}

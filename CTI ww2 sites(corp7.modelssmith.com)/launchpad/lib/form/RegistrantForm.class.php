<?php

/**
 * Registrant form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegistrantForm extends BaseRegistrantForm
{
 /**
  * function configure  
  * This form layer function contains BB & TB enhancements to the  
  * Propel generated forms.
  * @return integer   Unknown
  */
  public function configure()
  {
    // remove validator and widget for following fields (removes field from form)
     unset($this['created_at'], $this['updated_at']);
    // Add additional validators here
    $this->validatorSchema['first_name']->setOption('required', true);  // override generated base validator
    $this->validatorSchema['last_name']->setOption('required', true);
    $this->validatorSchema['address_line1']->setOption('required', true); 
    $this->validatorSchema['city']->setOption('required', true); 
    $this->validatorSchema['state']->setOption('required', true); 
    $this->validatorSchema['zip']->setOption('required', true); 
    $this->validatorSchema['country']->setOption('required', true);
    $this->validatorSchema['phone']->setOption('required', true);
    $this->validatorSchema['email']->setOption('required', true);
    // Make following fields hidden
    $this->widgetSchema['workshop_id'] = new sfWidgetFormInputHidden();  // add to generated base validator
    $this->widgetSchema['conf_email_sent_to_client_at'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['cookie_name'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['cookie_value'] = new sfWidgetFormInputHidden();
    // Validate email address
    $this->validatorSchema['email'] = new sfValidatorAnd(array(
      $this->validatorSchema['email'],
      new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.')),
    ));    // add to generated base validator
  }
}

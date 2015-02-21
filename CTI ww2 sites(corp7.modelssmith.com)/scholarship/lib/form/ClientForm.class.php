<?php

/**
 * Client form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ClientForm extends BaseClientForm
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
    unset($this['created_at'], $this['updated_at'], $this['sf_guard_user_id']);
    // Add additional validators here
    $this->validatorSchema['client_email']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['name']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['address_line1']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['city']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['state']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['zip']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['country']->setOption('required', true);  // overrid generated base validator
    $this->validatorSchema['work_phone']->setOption('required', true);  // overrid generated base validator
    
    $this->validatorSchema['client_email'] = new sfValidatorAnd(array(
      $this->validatorSchema['client_email'],
      new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.')),
    ));    // add to generated base validator
  }
}

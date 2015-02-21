<?php

/**
 * RegistrationEmail form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegistrationEmailForm extends BaseRegistrationEmailForm
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
	
    // Make following fields hidden
    $this->widgetSchema['workshop_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['registration_email_type'] = new sfWidgetFormInputHidden();
                  // add to generated base validator
				  
	// Require more than 20 char in email text
	$this->validatorSchema['text']->setOption('min_length', 20);
	
  }
}

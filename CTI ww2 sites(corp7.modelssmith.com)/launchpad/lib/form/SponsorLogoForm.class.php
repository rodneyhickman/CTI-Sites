<?php

/**
 * SponsorLogo form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class SponsorLogoForm extends BaseSponsorLogoForm
{
 /**
  * function configure  
  * This form layer function contains BB & TB enhancements to the  
  * Propel generated forms.
  * @return integer   Unknown
  */
  public function configure()
  {
    // Change filename field so it will be handled correctly for uploads
//    $this->setWidgets(array(
 //     'filename'    => new sfWidgetFormInputFile(),
 //   ));
	$this->widgetSchema['filename'] = new sfWidgetFormInputFile(); 
//    $this->setValidators(array(
//      'filename'    => new sfValidatorFile(),
 //   ));
    $this->validatorSchema['filename'] = new sfValidatorFile();  
	
    // remove validator and widget for following fields (removes field from form)
    unset($this['created_at'], $this['updated_at']);
    
    // Make workshop_id field hidden
    $this->widgetSchema['workshop_id'] = new sfWidgetFormInputHidden();
                // add to generated base validator
    
    // Add additional validators here
    $this->validatorSchema['filename']->setOption('required', true);  // override generated base validator
    
    
    
  }
}

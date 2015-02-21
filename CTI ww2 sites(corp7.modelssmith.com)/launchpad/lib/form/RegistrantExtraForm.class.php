<?php

/**
 * RegistrantExtra form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegistrantExtraForm extends BaseRegistrantExtraForm
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
     unset($this['created_at'], $this['updated_at'],
          $this['registrant_id']);
    // Make following fields hidden
    $this->widgetSchema['field_name'] = new sfWidgetFormInputHidden();  // add to generated base validator
    $this->widgetSchema['field_order'] = new sfWidgetFormInputHidden(); 
  }
}

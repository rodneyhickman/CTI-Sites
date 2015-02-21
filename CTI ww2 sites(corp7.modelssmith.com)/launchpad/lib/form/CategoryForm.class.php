<?php

/**
 * Category form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CategoryForm extends BaseCategoryForm
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
    unset($this['created_at'], $this['updated_at'], $this['client_id']);

    // Add additional validators here
    $this->validatorSchema['return_to_url']->setOption('required', true);  
	
    // Change widget for the "auto_confirm_reg" field to add radio button with proper values
//    $this->widgetSchema['auto_confirm_reg'] = new sfWidgetFormSelect(array('choices' => CategoryPeer::getAutoConfirmRegValues()));
    //$this->widgetSchema['auto_confirm_reg'] = new sfWidgetFormChoice(array(   'expanded' => true,   'choices' => CategoryPeer::getAutoConfirmRegValues()   ));
    $this->widgetSchema['auto_confirm_reg'] = new sfWidgetFormSelectRadio(array('choices' => CategoryPeer::getAutoConfirmRegValues()  ));


    // Add additional validators here
    $this->validatorSchema['category_name']->setOption('required', true);  // overrid generated base validator
//    $this->validatorSchema['admin_email'] = new sfValidatorAnd(array(
//      new sfValidatorString(array('max_length' => 100)),
//      new sfValidatorEmail(),
//    ));    // replace generated base validator
    $this->validatorSchema['admin_email'] = new sfValidatorAnd(array(
      $this->validatorSchema['admin_email'],
      new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.')),
    ));    // add to generated base validator

    // Validate the "auto_confirm_reg" field with proper values
    $autoConfirmReg = CategoryPeer::getAutoConfirmRegValues();
    $this->widgetSchema['auto_confirm_reg'] = new sfWidgetFormSelect(array('choices' => $autoConfirmReg));
//    $this->validatorSchema['auto_confirm_reg'] = new sfValidatorChoice(array('choices' => array_values($autoConfirmReg)));
    $this->validatorSchema['auto_confirm_reg'] = new sfValidatorChoice(array('choices' => array_keys($autoConfirmReg)));
	
	// set as hidden for now; features are not fully implemented
	$this->widgetSchema['auto_confirm_reg'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['months_until_automatic_purge'] = new sfWidgetFormInputHidden();
        
  }
}

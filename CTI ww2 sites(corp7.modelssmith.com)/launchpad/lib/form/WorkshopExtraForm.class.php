<?php

/**
 * WorkshopExtra form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class WorkshopExtraForm extends BaseWorkshopExtraForm
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
  
  // Make workshop_id field hidden
  $this->widgetSchema['workshop_id'] = new sfWidgetFormInputHidden();
                // add to generated base validator

  // Both attribute and value must be entered or not entered; cannot enter one without other.
	$this->validatorSchema->setPostValidator(new sfValidatorOr(
  array(
    new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('workshop_attribute', sfValidatorSchemaCompare::NOT_EQUAL, ''),
      new sfValidatorSchemaCompare('workshop_value', sfValidatorSchemaCompare::NOT_EQUAL, ''),
    )),  // end of first sfValidateAnd
    new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('workshop_attribute', sfValidatorSchemaCompare::EQUAL, ''),
      new sfValidatorSchemaCompare('workshop_value', sfValidatorSchemaCompare::EQUAL, ''),
    )),  // end of second sfValidateAnd
  ),
  array(),
  array('invalid' => 'Both attribute and value must be entered or not entered; cannot enter one without other.')
));
	
  // Change labels
  $this->widgetSchema->setLabel('workshop_value', 'Field Order');

    // Change labels on form fields
    $this->widgetSchema->setLabels(array(
      'workshop_attribute'    => 'Event attribute',
      'workshop_value'    => 'Event value'
    ));
  }
}

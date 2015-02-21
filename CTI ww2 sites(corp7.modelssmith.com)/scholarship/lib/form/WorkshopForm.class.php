<?php

/**
 * Workshop form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class WorkshopForm extends BaseWorkshopForm
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
          $this['nbr_current_attendees'], $this['client_id']);

	// get rid of blank choice for category in workshop form
    $this->widgetSchema['category_id'] = new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => false));	  

    // Add additional validators here
    $this->validatorSchema['name']->setOption('required', true);  // override generated base validator
    $this->validatorSchema['workshop_date']->setOption('required', true);
    $this->validatorSchema['workshop_time']->setOption('required', true);
    $this->validatorSchema['last_day_to_register']->setOption('required', true);
    $this->validatorSchema['max_nbr_attendees']->setOption('required', true);
    $this->validatorSchema['cost']->setOption('required', true);
    
    // define global form validation (not associated with a single field)
    //    workshop_date must be greater than last_day_to_register
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare('last_day_to_register', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'workshop_date',
        array('throw_global_error' => true),
        array('invalid' => 'The last day to register date ("%left_field%") must be before the workshop date ("%right_field%")')
      )
    );
	
    // Only show categories for this client (get client id from workshop)
    $categoryCriteria = new Criteria();
    $categoryCriteria->add(CategoryPeer::CLIENT_ID, $this->getObject()->getClientId());
    $this->widgetSchema['category_id']->setOption('criteria', $categoryCriteria);
	
    // sfWidgetFormSchema::moveField()
    $this->getWidgetSchema()->moveField('category_id', sfWidgetFormSchema::AFTER, 'logistics');
    $this->getWidgetSchema()->moveField('last_day_to_register', sfWidgetFormSchema::AFTER, 'workshop_time');

    // Change labels on form fields
    $this->widgetSchema->setLabels(array(
      'workshop_date'    => 'Event date',
      'workshop_time'    => 'Event time'
    ));
  }
}

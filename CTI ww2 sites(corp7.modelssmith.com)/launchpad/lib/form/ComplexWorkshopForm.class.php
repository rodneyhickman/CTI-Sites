<?php

/**
 * ComplexWorkshopForm. -- THIS IS NOT A PROPEL FORM,
 *       it was build by BB to sit on top of the propel forms for
 *       workshop, workshop_extra, and registration_email.  
 *
 */
class ComplexWorkshopForm extends BaseWorkshopForm
{
  public function configure()
  {
    // remove validator and widget for following fields (removes field from form)
    unset($this['created_at'], $this['updated_at'],
          $this['client_id']);
    // Add additional validators here
    $this->validatorSchema['name']->setOption('required', true);  // override generated base validator
    $this->validatorSchema['workshop_date']->setOption('required', true);
    $this->validatorSchema['workshop_time']->setOption('required', true);
    $this->validatorSchema['last_day_to_register']->setOption('required', true);
    $this->validatorSchema['max_nbr_attendees']->setOption('required', true);
    
    // define global form validation (not associated with a single field)
    //    workshop_date must be greater than last_day_to_register
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare('last_day_to_register', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'workshop_date',
        array('throw_global_error' => true),
        array('invalid' => 'The last day to register date ("%left_field%") must be before the workshop date ("%right_field%")')
      )
    );
    // sfWidgetFormSchema::moveField()
    $this->getWidgetSchema()->moveField('category_id', sfWidgetFormSchema::AFTER, 'logistics');
    
    //  Try embedding forms
//    $this->embedForm('workshop_extra', new WorkshopExtraForm(WorkshopExtraPeer::retrieveByPk(4)));
    // above failed so I added _toString to the workshop class, this fixed it

 // this try never did work right
    //$c = new Criteria();
//    $c->add(WorkshopExtraPeer::WORKSHOP_ID,4);
    //$WorkshopExtras = WorkshopExtraPeer::doSelect($c);
//    foreach ($WorkshopExtras as $we) {
    //$this->embedFormForEach('workshop_extra', new WorkshopExtraForm($WorkshopExtras), 2); // no form embedded
//    $this->embedForm('workshop_extra', new WorkshopExtraForm($we));
//    } 
 
    
// this code works IF the workshop_id,4 line is commented out; only returns 1 workshop extra row    
//    $c = new Criteria();
//    $c->add(WorkshopExtraPeer::WORKSHOP_ID,4);
//    $WorkshopExtras = WorkshopExtraPeer::doSelect($c);
//    foreach ($WorkshopExtras as $we) {
//    $this->embedForm('workshop_extra', new WorkshopExtraForm($we));
 //   } 
 
  }
}

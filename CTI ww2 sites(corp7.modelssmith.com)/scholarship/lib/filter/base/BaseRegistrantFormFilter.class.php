<?php

/**
 * Registrant filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRegistrantFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'                   => new sfWidgetFormFilterInput(),
      'middle_name'                  => new sfWidgetFormFilterInput(),
      'last_name'                    => new sfWidgetFormFilterInput(),
      'address_line1'                => new sfWidgetFormFilterInput(),
      'address_line2'                => new sfWidgetFormFilterInput(),
      'city'                         => new sfWidgetFormFilterInput(),
      'state'                        => new sfWidgetFormFilterInput(),
      'zip'                          => new sfWidgetFormFilterInput(),
      'country'                      => new sfWidgetFormFilterInput(),
      'phone'                        => new sfWidgetFormFilterInput(),
      'email'                        => new sfWidgetFormFilterInput(),
      'workshop_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'conf_email_sent_to_client_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cookie_name'                  => new sfWidgetFormFilterInput(),
      'cookie_value'                 => new sfWidgetFormFilterInput(),
      'created_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'first_name'                   => new sfValidatorPass(array('required' => false)),
      'middle_name'                  => new sfValidatorPass(array('required' => false)),
      'last_name'                    => new sfValidatorPass(array('required' => false)),
      'address_line1'                => new sfValidatorPass(array('required' => false)),
      'address_line2'                => new sfValidatorPass(array('required' => false)),
      'city'                         => new sfValidatorPass(array('required' => false)),
      'state'                        => new sfValidatorPass(array('required' => false)),
      'zip'                          => new sfValidatorPass(array('required' => false)),
      'country'                      => new sfValidatorPass(array('required' => false)),
      'phone'                        => new sfValidatorPass(array('required' => false)),
      'email'                        => new sfValidatorPass(array('required' => false)),
      'workshop_id'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Workshop', 'column' => 'id')),
      'conf_email_sent_to_client_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cookie_name'                  => new sfValidatorPass(array('required' => false)),
      'cookie_value'                 => new sfValidatorPass(array('required' => false)),
      'created_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('registrant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registrant';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'first_name'                   => 'Text',
      'middle_name'                  => 'Text',
      'last_name'                    => 'Text',
      'address_line1'                => 'Text',
      'address_line2'                => 'Text',
      'city'                         => 'Text',
      'state'                        => 'Text',
      'zip'                          => 'Text',
      'country'                      => 'Text',
      'phone'                        => 'Text',
      'email'                        => 'Text',
      'workshop_id'                  => 'ForeignKey',
      'conf_email_sent_to_client_at' => 'Date',
      'cookie_name'                  => 'Text',
      'cookie_value'                 => 'Text',
      'created_at'                   => 'Date',
    );
  }
}

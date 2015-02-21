<?php

/**
 * Dietary filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseDietaryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'profile_id'            => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'poultry'               => new sfWidgetFormFilterInput(),
      'beef'                  => new sfWidgetFormFilterInput(),
      'vegetarian'            => new sfWidgetFormFilterInput(),
      'seafood'               => new sfWidgetFormFilterInput(),
      'lamb'                  => new sfWidgetFormFilterInput(),
      'vegan'                 => new sfWidgetFormFilterInput(),
      'pork'                  => new sfWidgetFormFilterInput(),
      'dietary_restrictions'  => new sfWidgetFormFilterInput(),
      'describe_restrictions' => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'extra1'                => new sfWidgetFormFilterInput(),
      'extra2'                => new sfWidgetFormFilterInput(),
      'extra3'                => new sfWidgetFormFilterInput(),
      'extra4'                => new sfWidgetFormFilterInput(),
      'extra5'                => new sfWidgetFormFilterInput(),
      'extra6'                => new sfWidgetFormFilterInput(),
      'extra7'                => new sfWidgetFormFilterInput(),
      'extra8'                => new sfWidgetFormFilterInput(),
      'extra9'                => new sfWidgetFormFilterInput(),
      'extra10'               => new sfWidgetFormFilterInput(),
      'extra11'               => new sfWidgetFormFilterInput(),
      'extra12'               => new sfWidgetFormFilterInput(),
      'extra13'               => new sfWidgetFormFilterInput(),
      'extra14'               => new sfWidgetFormFilterInput(),
      'extra15'               => new sfWidgetFormFilterInput(),
      'extra16'               => new sfWidgetFormFilterInput(),
      'extra17'               => new sfWidgetFormFilterInput(),
      'extra18'               => new sfWidgetFormFilterInput(),
      'extra19'               => new sfWidgetFormFilterInput(),
      'extra20'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'profile_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'poultry'               => new sfValidatorPass(array('required' => false)),
      'beef'                  => new sfValidatorPass(array('required' => false)),
      'vegetarian'            => new sfValidatorPass(array('required' => false)),
      'seafood'               => new sfValidatorPass(array('required' => false)),
      'lamb'                  => new sfValidatorPass(array('required' => false)),
      'vegan'                 => new sfValidatorPass(array('required' => false)),
      'pork'                  => new sfValidatorPass(array('required' => false)),
      'dietary_restrictions'  => new sfValidatorPass(array('required' => false)),
      'describe_restrictions' => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'extra1'                => new sfValidatorPass(array('required' => false)),
      'extra2'                => new sfValidatorPass(array('required' => false)),
      'extra3'                => new sfValidatorPass(array('required' => false)),
      'extra4'                => new sfValidatorPass(array('required' => false)),
      'extra5'                => new sfValidatorPass(array('required' => false)),
      'extra6'                => new sfValidatorPass(array('required' => false)),
      'extra7'                => new sfValidatorPass(array('required' => false)),
      'extra8'                => new sfValidatorPass(array('required' => false)),
      'extra9'                => new sfValidatorPass(array('required' => false)),
      'extra10'               => new sfValidatorPass(array('required' => false)),
      'extra11'               => new sfValidatorPass(array('required' => false)),
      'extra12'               => new sfValidatorPass(array('required' => false)),
      'extra13'               => new sfValidatorPass(array('required' => false)),
      'extra14'               => new sfValidatorPass(array('required' => false)),
      'extra15'               => new sfValidatorPass(array('required' => false)),
      'extra16'               => new sfValidatorPass(array('required' => false)),
      'extra17'               => new sfValidatorPass(array('required' => false)),
      'extra18'               => new sfValidatorPass(array('required' => false)),
      'extra19'               => new sfValidatorPass(array('required' => false)),
      'extra20'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dietary_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dietary';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'profile_id'            => 'ForeignKey',
      'poultry'               => 'Text',
      'beef'                  => 'Text',
      'vegetarian'            => 'Text',
      'seafood'               => 'Text',
      'lamb'                  => 'Text',
      'vegan'                 => 'Text',
      'pork'                  => 'Text',
      'dietary_restrictions'  => 'Text',
      'describe_restrictions' => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'extra1'                => 'Text',
      'extra2'                => 'Text',
      'extra3'                => 'Text',
      'extra4'                => 'Text',
      'extra5'                => 'Text',
      'extra6'                => 'Text',
      'extra7'                => 'Text',
      'extra8'                => 'Text',
      'extra9'                => 'Text',
      'extra10'               => 'Text',
      'extra11'               => 'Text',
      'extra12'               => 'Text',
      'extra13'               => 'Text',
      'extra14'               => 'Text',
      'extra15'               => 'Text',
      'extra16'               => 'Text',
      'extra17'               => 'Text',
      'extra18'               => 'Text',
      'extra19'               => 'Text',
      'extra20'               => 'Text',
    );
  }
}

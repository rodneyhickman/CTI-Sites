<?php

/**
 * Coachtraining filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCoachtrainingFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'profile_id'           => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'program_preference'   => new sfWidgetFormFilterInput(),
      'core_preferred_date1' => new sfWidgetFormFilterInput(),
      'core_preferred_date2' => new sfWidgetFormFilterInput(),
      'core_preferred_date3' => new sfWidgetFormFilterInput(),
      'cert_preferred_date1' => new sfWidgetFormFilterInput(),
      'cert_preferred_date2' => new sfWidgetFormFilterInput(),
      'cert_preferred_date3' => new sfWidgetFormFilterInput(),
      'what_choose'          => new sfWidgetFormFilterInput(),
      'fundamentals_exp'     => new sfWidgetFormFilterInput(),
      'your_vision'          => new sfWidgetFormFilterInput(),
      'how_support'          => new sfWidgetFormFilterInput(),
      'why_applying'         => new sfWidgetFormFilterInput(),
      'what_size'            => new sfWidgetFormFilterInput(),
      'background'           => new sfWidgetFormFilterInput(),
      'anything_else'        => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'extra1'               => new sfWidgetFormFilterInput(),
      'extra2'               => new sfWidgetFormFilterInput(),
      'extra3'               => new sfWidgetFormFilterInput(),
      'extra4'               => new sfWidgetFormFilterInput(),
      'extra5'               => new sfWidgetFormFilterInput(),
      'extra6'               => new sfWidgetFormFilterInput(),
      'extra7'               => new sfWidgetFormFilterInput(),
      'extra8'               => new sfWidgetFormFilterInput(),
      'extra9'               => new sfWidgetFormFilterInput(),
      'extra10'              => new sfWidgetFormFilterInput(),
      'extra11'              => new sfWidgetFormFilterInput(),
      'extra12'              => new sfWidgetFormFilterInput(),
      'extra13'              => new sfWidgetFormFilterInput(),
      'extra14'              => new sfWidgetFormFilterInput(),
      'extra15'              => new sfWidgetFormFilterInput(),
      'extra16'              => new sfWidgetFormFilterInput(),
      'extra17'              => new sfWidgetFormFilterInput(),
      'extra18'              => new sfWidgetFormFilterInput(),
      'extra19'              => new sfWidgetFormFilterInput(),
      'extra20'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'profile_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'program_preference'   => new sfValidatorPass(array('required' => false)),
      'core_preferred_date1' => new sfValidatorPass(array('required' => false)),
      'core_preferred_date2' => new sfValidatorPass(array('required' => false)),
      'core_preferred_date3' => new sfValidatorPass(array('required' => false)),
      'cert_preferred_date1' => new sfValidatorPass(array('required' => false)),
      'cert_preferred_date2' => new sfValidatorPass(array('required' => false)),
      'cert_preferred_date3' => new sfValidatorPass(array('required' => false)),
      'what_choose'          => new sfValidatorPass(array('required' => false)),
      'fundamentals_exp'     => new sfValidatorPass(array('required' => false)),
      'your_vision'          => new sfValidatorPass(array('required' => false)),
      'how_support'          => new sfValidatorPass(array('required' => false)),
      'why_applying'         => new sfValidatorPass(array('required' => false)),
      'what_size'            => new sfValidatorPass(array('required' => false)),
      'background'           => new sfValidatorPass(array('required' => false)),
      'anything_else'        => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'extra1'               => new sfValidatorPass(array('required' => false)),
      'extra2'               => new sfValidatorPass(array('required' => false)),
      'extra3'               => new sfValidatorPass(array('required' => false)),
      'extra4'               => new sfValidatorPass(array('required' => false)),
      'extra5'               => new sfValidatorPass(array('required' => false)),
      'extra6'               => new sfValidatorPass(array('required' => false)),
      'extra7'               => new sfValidatorPass(array('required' => false)),
      'extra8'               => new sfValidatorPass(array('required' => false)),
      'extra9'               => new sfValidatorPass(array('required' => false)),
      'extra10'              => new sfValidatorPass(array('required' => false)),
      'extra11'              => new sfValidatorPass(array('required' => false)),
      'extra12'              => new sfValidatorPass(array('required' => false)),
      'extra13'              => new sfValidatorPass(array('required' => false)),
      'extra14'              => new sfValidatorPass(array('required' => false)),
      'extra15'              => new sfValidatorPass(array('required' => false)),
      'extra16'              => new sfValidatorPass(array('required' => false)),
      'extra17'              => new sfValidatorPass(array('required' => false)),
      'extra18'              => new sfValidatorPass(array('required' => false)),
      'extra19'              => new sfValidatorPass(array('required' => false)),
      'extra20'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('coachtraining_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Coachtraining';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'profile_id'           => 'ForeignKey',
      'program_preference'   => 'Text',
      'core_preferred_date1' => 'Text',
      'core_preferred_date2' => 'Text',
      'core_preferred_date3' => 'Text',
      'cert_preferred_date1' => 'Text',
      'cert_preferred_date2' => 'Text',
      'cert_preferred_date3' => 'Text',
      'what_choose'          => 'Text',
      'fundamentals_exp'     => 'Text',
      'your_vision'          => 'Text',
      'how_support'          => 'Text',
      'why_applying'         => 'Text',
      'what_size'            => 'Text',
      'background'           => 'Text',
      'anything_else'        => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'extra1'               => 'Text',
      'extra2'               => 'Text',
      'extra3'               => 'Text',
      'extra4'               => 'Text',
      'extra5'               => 'Text',
      'extra6'               => 'Text',
      'extra7'               => 'Text',
      'extra8'               => 'Text',
      'extra9'               => 'Text',
      'extra10'              => 'Text',
      'extra11'              => 'Text',
      'extra12'              => 'Text',
      'extra13'              => 'Text',
      'extra14'              => 'Text',
      'extra15'              => 'Text',
      'extra16'              => 'Text',
      'extra17'              => 'Text',
      'extra18'              => 'Text',
      'extra19'              => 'Text',
      'extra20'              => 'Text',
    );
  }
}
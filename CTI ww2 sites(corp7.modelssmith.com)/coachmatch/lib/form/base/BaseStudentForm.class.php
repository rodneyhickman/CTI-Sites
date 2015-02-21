<?php

/**
 * Student form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseStudentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'profile_id'          => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'fm_id'               => new sfWidgetFormInput(),
      'name'                => new sfWidgetFormInput(),
      'email'               => new sfWidgetFormInput(),
      'level'               => new sfWidgetFormInput(),
      'last_activity'       => new sfWidgetFormDate(),
      'in_the_bones_date'   => new sfWidgetFormDate(),
      'course_fundamentals' => new sfWidgetFormInput(),
      'course_fulfillment'  => new sfWidgetFormInput(),
      'course_balance'      => new sfWidgetFormInput(),
      'course_process'      => new sfWidgetFormInput(),
      'course_in_the_bones' => new sfWidgetFormInput(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Student', 'column' => 'id', 'required' => false)),
      'profile_id'          => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'fm_id'               => new sfValidatorInteger(array('required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'email'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'level'               => new sfValidatorInteger(array('required' => false)),
      'last_activity'       => new sfValidatorDate(array('required' => false)),
      'in_the_bones_date'   => new sfValidatorDate(array('required' => false)),
      'course_fundamentals' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'course_fulfillment'  => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'course_balance'      => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'course_process'      => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'course_in_the_bones' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('student[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Student';
  }


}

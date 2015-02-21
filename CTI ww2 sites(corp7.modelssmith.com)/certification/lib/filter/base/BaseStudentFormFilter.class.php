<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Student filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseStudentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'profile_id'           => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'fm_id'                => new sfWidgetFormFilterInput(),
      'name'                 => new sfWidgetFormFilterInput(),
      'email'                => new sfWidgetFormFilterInput(),
      'level'                => new sfWidgetFormFilterInput(),
      'last_activity'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'in_the_bones_date'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'course_fundamentals'  => new sfWidgetFormFilterInput(),
      'course_fulfillment'   => new sfWidgetFormFilterInput(),
      'course_balance'       => new sfWidgetFormFilterInput(),
      'course_process'       => new sfWidgetFormFilterInput(),
      'course_in_the_bones'  => new sfWidgetFormFilterInput(),
      'cpcc_cert_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'cpcc_grad'            => new sfWidgetFormFilterInput(),
      'course_certification' => new sfWidgetFormFilterInput(),
      'cti_faculty'          => new sfWidgetFormFilterInput(),
      'active'               => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'profile_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'fm_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'email'                => new sfValidatorPass(array('required' => false)),
      'level'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_activity'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'in_the_bones_date'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'course_fundamentals'  => new sfValidatorPass(array('required' => false)),
      'course_fulfillment'   => new sfValidatorPass(array('required' => false)),
      'course_balance'       => new sfValidatorPass(array('required' => false)),
      'course_process'       => new sfValidatorPass(array('required' => false)),
      'course_in_the_bones'  => new sfValidatorPass(array('required' => false)),
      'cpcc_cert_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cpcc_grad'            => new sfValidatorPass(array('required' => false)),
      'course_certification' => new sfValidatorPass(array('required' => false)),
      'cti_faculty'          => new sfValidatorPass(array('required' => false)),
      'active'               => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('student_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Student';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'profile_id'           => 'ForeignKey',
      'fm_id'                => 'Number',
      'name'                 => 'Text',
      'email'                => 'Text',
      'level'                => 'Number',
      'last_activity'        => 'Date',
      'in_the_bones_date'    => 'Date',
      'course_fundamentals'  => 'Text',
      'course_fulfillment'   => 'Text',
      'course_balance'       => 'Text',
      'course_process'       => 'Text',
      'course_in_the_bones'  => 'Text',
      'cpcc_cert_date'       => 'Date',
      'cpcc_grad'            => 'Text',
      'course_certification' => 'Text',
      'cti_faculty'          => 'Text',
      'active'               => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}

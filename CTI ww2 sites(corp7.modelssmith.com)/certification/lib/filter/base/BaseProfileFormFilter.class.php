<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Profile filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                    => new sfWidgetFormFilterInput(),
      'email'                   => new sfWidgetFormFilterInput(),
      'location'                => new sfWidgetFormFilterInput(),
      'niche'                   => new sfWidgetFormFilterInput(),
      'expertise'               => new sfWidgetFormFilterInput(),
      'sf_guard_user_id'        => new sfWidgetFormFilterInput(),
      'agree_clicked'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'number_of_contacts_made' => new sfWidgetFormFilterInput(),
      'phone'                   => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                    => new sfValidatorPass(array('required' => false)),
      'email'                   => new sfValidatorPass(array('required' => false)),
      'location'                => new sfValidatorPass(array('required' => false)),
      'niche'                   => new sfValidatorPass(array('required' => false)),
      'expertise'               => new sfValidatorPass(array('required' => false)),
      'sf_guard_user_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'agree_clicked'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'number_of_contacts_made' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'phone'                   => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'name'                    => 'Text',
      'email'                   => 'Text',
      'location'                => 'Text',
      'niche'                   => 'Text',
      'expertise'               => 'Text',
      'sf_guard_user_id'        => 'Number',
      'agree_clicked'           => 'Date',
      'number_of_contacts_made' => 'Number',
      'phone'                   => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
    );
  }
}

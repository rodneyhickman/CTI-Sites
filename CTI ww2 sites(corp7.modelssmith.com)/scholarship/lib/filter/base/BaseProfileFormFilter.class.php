<?php

/**
 * Profile filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'full_name'          => new sfWidgetFormFilterInput(),
      'first_name'         => new sfWidgetFormFilterInput(),
      'middle_name'        => new sfWidgetFormFilterInput(),
      'last_name'          => new sfWidgetFormFilterInput(),
      'perm_address1'      => new sfWidgetFormFilterInput(),
      'perm_address2'      => new sfWidgetFormFilterInput(),
      'perm_city'          => new sfWidgetFormFilterInput(),
      'perm_state_prov'    => new sfWidgetFormFilterInput(),
      'perm_zip_postcode'  => new sfWidgetFormFilterInput(),
      'perm_country'       => new sfWidgetFormFilterInput(),
      'other_address1'     => new sfWidgetFormFilterInput(),
      'other_address2'     => new sfWidgetFormFilterInput(),
      'other_city'         => new sfWidgetFormFilterInput(),
      'other_state_prov'   => new sfWidgetFormFilterInput(),
      'other_zip_postcode' => new sfWidgetFormFilterInput(),
      'other_country'      => new sfWidgetFormFilterInput(),
      'telephone1'         => new sfWidgetFormFilterInput(),
      'telephone2'         => new sfWidgetFormFilterInput(),
      'email1'             => new sfWidgetFormFilterInput(),
      'email2'             => new sfWidgetFormFilterInput(),
      'referred_by'        => new sfWidgetFormFilterInput(),
      'gender'             => new sfWidgetFormFilterInput(),
      'age'                => new sfWidgetFormFilterInput(),
      'secret'             => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'extra1'             => new sfWidgetFormFilterInput(),
      'extra2'             => new sfWidgetFormFilterInput(),
      'extra3'             => new sfWidgetFormFilterInput(),
      'extra4'             => new sfWidgetFormFilterInput(),
      'extra5'             => new sfWidgetFormFilterInput(),
      'extra6'             => new sfWidgetFormFilterInput(),
      'extra7'             => new sfWidgetFormFilterInput(),
      'extra8'             => new sfWidgetFormFilterInput(),
      'extra9'             => new sfWidgetFormFilterInput(),
      'extra10'            => new sfWidgetFormFilterInput(),
      'extra11'            => new sfWidgetFormFilterInput(),
      'extra12'            => new sfWidgetFormFilterInput(),
      'extra13'            => new sfWidgetFormFilterInput(),
      'extra14'            => new sfWidgetFormFilterInput(),
      'extra15'            => new sfWidgetFormFilterInput(),
      'extra16'            => new sfWidgetFormFilterInput(),
      'extra17'            => new sfWidgetFormFilterInput(),
      'extra18'            => new sfWidgetFormFilterInput(),
      'extra19'            => new sfWidgetFormFilterInput(),
      'extra20'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'full_name'          => new sfValidatorPass(array('required' => false)),
      'first_name'         => new sfValidatorPass(array('required' => false)),
      'middle_name'        => new sfValidatorPass(array('required' => false)),
      'last_name'          => new sfValidatorPass(array('required' => false)),
      'perm_address1'      => new sfValidatorPass(array('required' => false)),
      'perm_address2'      => new sfValidatorPass(array('required' => false)),
      'perm_city'          => new sfValidatorPass(array('required' => false)),
      'perm_state_prov'    => new sfValidatorPass(array('required' => false)),
      'perm_zip_postcode'  => new sfValidatorPass(array('required' => false)),
      'perm_country'       => new sfValidatorPass(array('required' => false)),
      'other_address1'     => new sfValidatorPass(array('required' => false)),
      'other_address2'     => new sfValidatorPass(array('required' => false)),
      'other_city'         => new sfValidatorPass(array('required' => false)),
      'other_state_prov'   => new sfValidatorPass(array('required' => false)),
      'other_zip_postcode' => new sfValidatorPass(array('required' => false)),
      'other_country'      => new sfValidatorPass(array('required' => false)),
      'telephone1'         => new sfValidatorPass(array('required' => false)),
      'telephone2'         => new sfValidatorPass(array('required' => false)),
      'email1'             => new sfValidatorPass(array('required' => false)),
      'email2'             => new sfValidatorPass(array('required' => false)),
      'referred_by'        => new sfValidatorPass(array('required' => false)),
      'gender'             => new sfValidatorPass(array('required' => false)),
      'age'                => new sfValidatorPass(array('required' => false)),
      'secret'             => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'extra1'             => new sfValidatorPass(array('required' => false)),
      'extra2'             => new sfValidatorPass(array('required' => false)),
      'extra3'             => new sfValidatorPass(array('required' => false)),
      'extra4'             => new sfValidatorPass(array('required' => false)),
      'extra5'             => new sfValidatorPass(array('required' => false)),
      'extra6'             => new sfValidatorPass(array('required' => false)),
      'extra7'             => new sfValidatorPass(array('required' => false)),
      'extra8'             => new sfValidatorPass(array('required' => false)),
      'extra9'             => new sfValidatorPass(array('required' => false)),
      'extra10'            => new sfValidatorPass(array('required' => false)),
      'extra11'            => new sfValidatorPass(array('required' => false)),
      'extra12'            => new sfValidatorPass(array('required' => false)),
      'extra13'            => new sfValidatorPass(array('required' => false)),
      'extra14'            => new sfValidatorPass(array('required' => false)),
      'extra15'            => new sfValidatorPass(array('required' => false)),
      'extra16'            => new sfValidatorPass(array('required' => false)),
      'extra17'            => new sfValidatorPass(array('required' => false)),
      'extra18'            => new sfValidatorPass(array('required' => false)),
      'extra19'            => new sfValidatorPass(array('required' => false)),
      'extra20'            => new sfValidatorPass(array('required' => false)),
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
      'id'                 => 'Number',
      'full_name'          => 'Text',
      'first_name'         => 'Text',
      'middle_name'        => 'Text',
      'last_name'          => 'Text',
      'perm_address1'      => 'Text',
      'perm_address2'      => 'Text',
      'perm_city'          => 'Text',
      'perm_state_prov'    => 'Text',
      'perm_zip_postcode'  => 'Text',
      'perm_country'       => 'Text',
      'other_address1'     => 'Text',
      'other_address2'     => 'Text',
      'other_city'         => 'Text',
      'other_state_prov'   => 'Text',
      'other_zip_postcode' => 'Text',
      'other_country'      => 'Text',
      'telephone1'         => 'Text',
      'telephone2'         => 'Text',
      'email1'             => 'Text',
      'email2'             => 'Text',
      'referred_by'        => 'Text',
      'gender'             => 'Text',
      'age'                => 'Text',
      'secret'             => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'extra1'             => 'Text',
      'extra2'             => 'Text',
      'extra3'             => 'Text',
      'extra4'             => 'Text',
      'extra5'             => 'Text',
      'extra6'             => 'Text',
      'extra7'             => 'Text',
      'extra8'             => 'Text',
      'extra9'             => 'Text',
      'extra10'            => 'Text',
      'extra11'            => 'Text',
      'extra12'            => 'Text',
      'extra13'            => 'Text',
      'extra14'            => 'Text',
      'extra15'            => 'Text',
      'extra16'            => 'Text',
      'extra17'            => 'Text',
      'extra18'            => 'Text',
      'extra19'            => 'Text',
      'extra20'            => 'Text',
    );
  }
}

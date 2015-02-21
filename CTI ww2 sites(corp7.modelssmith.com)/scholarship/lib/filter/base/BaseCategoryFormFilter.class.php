<?php

/**
 * Category filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'client_id'                    => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'category_name'                => new sfWidgetFormFilterInput(),
      'admin_email'                  => new sfWidgetFormFilterInput(),
      'return_to_url'                => new sfWidgetFormFilterInput(),
      'months_until_automatic_purge' => new sfWidgetFormFilterInput(),
      'auto_confirm_reg'             => new sfWidgetFormFilterInput(),
      'created_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'client_id'                    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Client', 'column' => 'id')),
      'category_name'                => new sfValidatorPass(array('required' => false)),
      'admin_email'                  => new sfValidatorPass(array('required' => false)),
      'return_to_url'                => new sfValidatorPass(array('required' => false)),
      'months_until_automatic_purge' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'auto_confirm_reg'             => new sfValidatorPass(array('required' => false)),
      'created_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'client_id'                    => 'ForeignKey',
      'category_name'                => 'Text',
      'admin_email'                  => 'Text',
      'return_to_url'                => 'Text',
      'months_until_automatic_purge' => 'Number',
      'auto_confirm_reg'             => 'Text',
      'created_at'                   => 'Date',
      'updated_at'                   => 'Date',
    );
  }
}

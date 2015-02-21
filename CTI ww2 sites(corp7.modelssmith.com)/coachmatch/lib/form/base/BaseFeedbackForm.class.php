<?php

/**
 * Feedback form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseFeedbackForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'profile_id'    => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'feedback_date' => new sfWidgetFormDateTime(),
      'attribute'     => new sfWidgetFormInput(),
      'value'         => new sfWidgetFormTextarea(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Feedback', 'column' => 'id', 'required' => false)),
      'profile_id'    => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'feedback_date' => new sfValidatorDateTime(array('required' => false)),
      'attribute'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'value'         => new sfValidatorString(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('feedback[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Feedback';
  }


}

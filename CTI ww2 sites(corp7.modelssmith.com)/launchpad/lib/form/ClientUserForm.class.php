<?php

/**
 * class ClientUserForm  
 * This is the class that defines the form that is included into the ClientEdit
 * function.  Had to do this to avoid displaying the profile table twice. 
 * @package    FOTR
 * @subpackage admin
 * @version    SVN: $Id$
 *
 */
class ClientUserForm extends BasesfGuardUserForm
{
  public function configure()
  {
    unset(
      $this['username'],
      $this['last_login'],
      $this['created_at'],
      $this['salt'],
      $this['is_active'],
      $this['is_super_admin'],
      $this['sf_guard_user_group_list'],
      $this['sf_guard_user_permission_list'],
      $this['algorithm']
    );

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  }
}

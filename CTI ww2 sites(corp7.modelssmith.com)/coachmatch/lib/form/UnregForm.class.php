<?php


/**
 * Register form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UnregForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
                            'email'    => new sfWidgetFormInput(),
                            'key'      => new sfWidgetFormInputPassword(),
    ));

  }
}

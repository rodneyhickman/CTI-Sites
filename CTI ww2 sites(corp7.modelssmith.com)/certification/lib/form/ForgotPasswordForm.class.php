<?php

/**
 * ForgotPassword form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class ForgotPasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email'   => new sfWidgetFormInput(),
    ));
    $this->widgetSchema->setLabels(array(
      'name'     => 'Your Name',
                                         ));
  }
}

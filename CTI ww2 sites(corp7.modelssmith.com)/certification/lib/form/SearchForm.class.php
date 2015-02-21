<?php

/**
 * Search form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class SearchForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'q'                   => new sfWidgetFormInput(),
    ));


    $this->widgetSchema->setLabels(array(
      'q' => 'Or using keyword search, you can search for, area codes, cities, states or any other text fields:',
    ));
  }
}

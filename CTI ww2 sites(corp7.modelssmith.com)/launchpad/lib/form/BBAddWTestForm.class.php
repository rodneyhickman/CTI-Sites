<?php

// lib/form/BBAddWTestForm.class.php
class BBAddWTestForm extends BaseForm
{
  protected static $subjects = array('A' => 'Subject A', 'B' => 'Subject B', 'C' => 'Subject C');
  
  public function configure()
  {
    $this->setWidgets(array(
      'GoodInput' => new sfWidgetFormInputText(),
      'GoodInput2' => new sfWidgetFormInputText(),
      'FormSelect' => new sfWidgetFormSelect(array('choices' => self::$subjects)),
      'FieldTextarea' => new sfWidgetFormTextarea(),
      'DropDown' => new sfWidgetFormChoice(array(
              'choices' => array('Fabien Potencier', 'Fabian Lange'),
               )),
      'DropMultiple' =>   new sfWidgetFormChoice(array(
              'multiple' => true,
              'choices'  => array('PHP', 'symfony', 'Doctrine', 'Propel', 'model'),
            )),  
       'RadioSingle' => new sfWidgetFormChoice(array(
              'expanded' => true,
              'choices'  => array('published', 'draft', 'deleted'),
            )),
        'RadioMultiple' =>  new sfWidgetFormChoice(array(
              'expanded' => true,
              'multiple' => true,
              'choices'  => array('A week of symfony', 'Call the expert', 'Community'),
            ))
               
    ));  // end of setWidgets
    $this->widgetSchema->setNameFormat('form_array[%s]');




  }  // end of configure
}  // end of class

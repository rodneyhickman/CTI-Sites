<?php

/**
 * Category form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CategoryForm extends BaseCategoryForm
{
  public function configure()
  {
    // remove validator and widget for following fields
    unset($this['created_at'], $this['updated_at'], $this['client_id']);
  }
}

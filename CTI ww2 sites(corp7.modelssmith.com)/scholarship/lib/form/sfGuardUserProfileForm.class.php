<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
    // remove validator and widget for following fields (removes field from form)
    unset($this['created_at'], $this['updated_at'], $this['sf_guard_user_id']);
  }
}

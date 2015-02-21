<?php

/**
 * sfGuardPermission module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage sfGuardPermission
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfGuardPermissionGeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? 'sf_guard_permission' : 'sf_guard_permission_'.$action;
  }
}

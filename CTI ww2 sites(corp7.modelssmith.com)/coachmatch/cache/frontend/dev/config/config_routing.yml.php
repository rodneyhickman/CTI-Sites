<?php
// auto-generated by sfRoutingConfigHandler
// date: 2013/02/20 19:16:43
return array(
'homepage' => new sfRoute('/', array (
  'module' => 'main',
  'action' => 'index',
), array (
), array (
)),
'default_index' => new sfRoute('/:module', array (
  'action' => 'index',
), array (
), array (
)),
'default' => new sfRoute('/:module/:action/*', array (
), array (
), array (
)),
'sf_guard_signin' => new sfRoute('/login', array (
  'module' => 'sfGuardAuth',
  'action' => 'signin',
), array (
), array (
)),
'sf_guard_signout' => new sfRoute('/logout', array (
  'module' => 'sfGuardAuth',
  'action' => 'signout',
), array (
), array (
)),
'sf_guard_password' => new sfRoute('/request_password', array (
  'module' => 'sfGuardAuth',
  'action' => 'password',
), array (
), array (
)),
);
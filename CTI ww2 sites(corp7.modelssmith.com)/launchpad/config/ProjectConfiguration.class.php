<?php

# FROZEN_SF_LIB_DIR: /var/www/production/sfweb/www/cache/symfony-for-release/1.2.4/lib

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want

   $this->enableAllPluginsExcept(array('sfDoctrinePlugin' ));
   // $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin_BB'));
    $this->enablePlugins('sfGuardPlugin');
  }
}

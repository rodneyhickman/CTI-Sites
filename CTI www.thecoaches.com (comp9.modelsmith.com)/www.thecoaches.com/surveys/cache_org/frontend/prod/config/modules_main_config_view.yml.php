<?php
// auto-generated by sfViewConfigHandler
// date: 2012/07/08 09:00:00
$response = $this->context->getResponse();

if ($this->actionName.$this->viewName == 'helpSuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}

if ($templateName.$this->viewName == 'helpSuccess')
{
  if (!is_null($layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout')))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);

  $response->addStylesheet('main.css', '', array ());
}
else
{
  if (!is_null($layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout')))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (is_null($this->getDecoratorTemplate()) && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout-login' ? false : 'layout-login'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);

  $response->addStylesheet('main.css', '', array ());
}

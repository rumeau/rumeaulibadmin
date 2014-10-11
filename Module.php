<?php
namespace RumeauLibAdmin;

use RumeauLibAdmin\Listener\AdminLayoutSelector;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        /**
         * @var \Zend\EventManager\EventManager $em
         */
        $em  = $app->getEventManager();

        $em->attachAggregate(new AdminLayoutSelector());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

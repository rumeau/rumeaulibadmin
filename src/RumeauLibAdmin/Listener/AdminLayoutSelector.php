<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 09/10/2014
 * Time: 17:04
 */
namespace RumeauLibAdmin\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class AdminLayoutSelector implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var
     */
    protected $overrideLayout;

    /**
     * @var
     */
    protected $adminLayout;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'rumeauLibAppConfig'], 20000);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'adminLayoutSelector'], -20000);
    }

    public function rumeauLibAppConfig(MvcEvent $event)
    {
        $app    = $event->getApplication();
        $sm     = $app->getServiceManager();
        $config = $sm->get('Config');

        $this->overrideLayout = $config['rumeaulib_admin']['override_layout'];
        $this->adminLayout    = $config['rumeaulib_admin']['admin_layout'];

        if (!$sm->has('RumeauLibAppConfig\AppConfig')) {
            return;
        }

        $appConfig            = $sm->get('RumeauLibAppConfig\AppConfig');
        $this->overrideLayout = $appConfig->getConfig('override_layout', $this->overrideLayout, 'rumeaulib_admin');
        $this->adminLayout    = $appConfig->getConfig('admin_layout', $this->adminLayout, 'rumeaulib_admin');
    }

    /**
     * @param MvcEvent $event
     */
    public function adminLayoutSelector(MvcEvent $event)
    {
        $overrideLayout     = $this->overrideLayout;
        $layout             = $this->adminLayout;

        if ($overrideLayout === false) {
            return;
        }

        $match      = $event->getRouteMatch();
        if (!$match instanceof RouteMatch) {
            return;
        }

        $module     = $match->getMatchedRouteName();
        $controller = $event->getTarget();
        if ($controller->getEvent()->getResult()->terminate() || strpos($module, 'admin') === false) {
            return;
        }

        $controller->layout($layout);
    }
} 
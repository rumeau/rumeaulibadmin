<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 13:55
 */

namespace RumeauLibAdmin\Form\AppConfig;

use Zend\Form\Fieldset;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Config
 * @package RumeauLibAdmin\Form\AppConfig
 */
class Config extends Fieldset implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $layouts = $this->loadLayouts();

        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'admin_layout',
            'options' => [
                'label' => 'Admin Layout',
                'label_attributes' => ['class' => 'col-sm-2'],
                'value_options' => $layouts,
                'twb-layout' => 'horizontal',
                'column-size' => 'sm-10',
            ],
            'attributes' => [

            ],
        ]);
    }

    public function loadLayouts()
    {
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        /**
         * @var \RumeauLibThemeManager\Service\ThemeManager $themeManager
         */
        $themeManager   = $serviceLocator->get('RumeauLibThemeManager\ThemeManager');

        $themes         = $themeManager->getThemes('admin');
        $layoutArray    = [
            'layout/admin' => 'Default Theme',
        ];

        /**
         * @var \RumeauLibThemeManager\Theme\Theme $theme
         */
        foreach ($themes as $theme) {
            $layoutArray[$theme->getTemplateMap()] = $theme->getName();
        }

        return $layoutArray;
    }
}

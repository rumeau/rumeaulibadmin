<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 11/10/2014
 * Time: 0:51
 */

namespace RumeauLibAdmin\Navigation\Service;


use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminNavigationFactory extends DefaultNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin';
    }
}

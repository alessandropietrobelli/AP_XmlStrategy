<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\Mvc\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AP_XmlStrategy\View\Strategy\XmlStrategy;

/**
 * @category   Zend
 * @package    Zend_Mvc
 * @subpackage Service
 */
class ViewXmlStrategyFactory implements FactoryInterface
{
    /**
     * Create and return the Xml view strategy
     *
     * Retrieves the ViewXmlRenderer service from the service locator, and
     * injects it into the constructor for the xml strategy.
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return XmlStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = $serviceLocator->get('ViewXmlRenderer');
        $strategy = new XmlStrategy($renderer);

        return $strategy;
    }
}

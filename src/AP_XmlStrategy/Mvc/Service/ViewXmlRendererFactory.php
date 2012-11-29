<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\Mvc\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\AggregateResolver;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Resolver\TemplateMapResolver;
use AP_XmlStrategy\View\Renderer\XmlRenderer;

/**
 * @category   Zend
 * @package    Zend_Mvc
 * @subpackage Service
 */
class ViewXmlRendererFactory implements FactoryInterface
{
    /**
     * Create and return the feed view renderer
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return XmlRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = new XmlRenderer();

        $renderer->setResolver($serviceLocator->get('ViewXmlResolver'));

        // TODO: has a likely hood of 99% to cause a bug
        //$renderer->setHelperPluginManager(clone $serviceLocator->get('ViewHelperManager'));

        return $renderer;
    }
}


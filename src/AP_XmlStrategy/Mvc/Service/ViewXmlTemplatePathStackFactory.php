<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\Mvc\Service;

use Zend\View\Resolver as ViewResolver;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   Zend
 * @package    Zend_Mvc
 * @subpackage Service
 */
class ViewXmlTemplatePathStackFactory implements FactoryInterface
{
    /**
     * Create the template map view resolver
     *
     * Creates a Zend\View\Resolver\TemplatePathStack and populates it with the
     * ['view_manager']['template_path_stack']
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewResolver\TemplatePathStack
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $stack = array();
        if (is_array($config) && isset($config['view_manager'])) {
            $config = $config['view_manager'];
            if (is_array($config) && isset($config['xml_template_path_stack'])) {
                $stack = $config['xml_template_path_stack'];
            }
        }

        $templatePathStack = new ViewResolver\TemplatePathStack();
        $templatePathStack->addPaths($stack);
        $templatePathStack->setDefaultSuffix('xml.php');

        return $templatePathStack;
    }
}

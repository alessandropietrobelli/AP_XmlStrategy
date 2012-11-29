<?php
/**
 * @package AP (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'ViewXmlRenderer'            => 'AP_XmlStrategy\Mvc\Service\ViewXmlRendererFactory',
            'ViewXmlStrategy'            => 'AP_XmlStrategy\Mvc\Service\ViewXmlStrategyFactory',
            'ViewXmlResolver'            => 'AP_XmlStrategy\Mvc\Service\ViewXmlResolverFactory',
            'ViewXmlTemplatePathStack'   => 'AP_XmlStrategy\Mvc\Service\ViewXmlTemplatePathStackFactory',
            'ViewXmlTemplateMapResolver' => 'AP_XmlStrategy\Mvc\Service\ViewXmlTemplateMapResolverFactory',
        )
    )
);
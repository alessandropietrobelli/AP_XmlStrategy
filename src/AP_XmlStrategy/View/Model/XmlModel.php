<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\View\Model;

use Zend\View\Model\ViewModel;
use Zend\Stdlib\ArrayUtils;
use AP_XmlStrategy\Xml\Array2XML;

/**
 * @category   Zend
 * @package    Zend_View
 * @subpackage Model
 */
class XmlModel extends ViewModel
{
    /**
     * Xml probably won't need to be captured into a
     * a parent container by default.
     *
     * @var string
     */
    protected $captureTo = null;

    /**
     * Xml is usually terminal
     *
     * @var bool
     */
    protected $terminate = true;

    /**
     * @var string
     */
    protected $encoding = 'utf-8';

    /**
     * @var string
     */
    protected $version = '1.0';

    /**
     * @var string
     */
    protected $rootNode = 'response';

    /**
     * @param string $encoding
     *
     * @return XmlModel
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     *
     * @return XmlModel
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $rootNode
     */
    public function setRootNode($rootNode)
    {
        $this->rootNode = $rootNode;
    }

    /**
     * @return string
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }


    public function serialize()
    {
        $variables = $this->getVariables();
        
        if (is_a($variables, 'Traversable')) {
            $variables = ArrayUtils::iteratorToArray($variables);
        }
        
        Array2XML::init($this->version, $this->encoding);

        $xml = Array2XML::createXML($this->rootNode, $variables);

        return $xml->saveXML();
    }
}
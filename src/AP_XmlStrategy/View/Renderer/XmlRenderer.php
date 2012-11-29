<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\View\Renderer;
use Zend\View\Exception;
use AP_XmlStrategy\View\Model\XmlModel;
use Zend\View\Model\ModelInterface as Model;
use Zend\View\Resolver\ResolverInterface as Resolver;
use Zend\View\Renderer\RendererInterface;

/**
 * @category   Zend
 * @package    Zend_View
 * @subpackage Renderer
 */
class XmlRenderer implements RendererInterface
//class XmlRenderer extends JsonRenderer
{
	/**
     * @var Resolver
     */
    protected $resolver;
	
    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return mixed
     */
    public function getEngine(){
    	return $this;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(Resolver $resolver){
    	$this->resolver = $resolver;
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null){
    	// use case 1: View Models
        // Serialize variables in view model
        if ($nameOrModel instanceof Model) {
            if ($nameOrModel instanceof XmlModel) {
                $values = $nameOrModel->serialize();
            } 
            /*
            else {
                $values = $this->recurseModel($nameOrModel);
                $values = Json::encode($values);
            }
			*/
            return $values;
        }

        // use case 2: $nameOrModel is populated, $values is not
        // Serialize $nameOrModel
        if (null === $values) {
            if (!is_object($nameOrModel) || $nameOrModel instanceof JsonSerializable) {
                $return = Json::encode($nameOrModel);
            } elseif ($nameOrModel instanceof Traversable) {
                $nameOrModel = ArrayUtils::iteratorToArray($nameOrModel);
                $return = Json::encode($nameOrModel);
            } else {
                $return = Json::encode(get_object_vars($nameOrModel));
            }

            if ($this->hasJsonpCallback()) {
                $return = $this->jsonpCallback . '(' . $return . ');';
            }
            return $return;
        }

        // use case 3: Both $nameOrModel and $values are populated
        throw new Exception\DomainException(sprintf(
            '%s: Do not know how to handle operation when both $nameOrModel and $values are populated',
            __METHOD__
        ));
    }

}
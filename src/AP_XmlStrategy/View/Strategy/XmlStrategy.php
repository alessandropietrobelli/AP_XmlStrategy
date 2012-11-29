<?php
/**
 * @package AP_XmlStrategy (Zend Framework 2 Extensions)
 * @author Alessandro Pietrobelli <alessandro.pietrobelli@gmail.com>
 */

namespace AP_XmlStrategy\View\Strategy;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\View\ViewEvent;

use AP_XmlStrategy\View\Model\XmlModel;
use AP_XmlStrategy\View\Renderer\XmlRenderer;

/**
 * @category   Zend
 * @package    Zend_View
 * @subpackage Strategy
 */
class XmlStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var JsonRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  JsonRenderer $renderer
     */
    public function __construct(XmlRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * Detach aggregate listeners from the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Detect if we should use the XmlRenderer based on model type and/or
     * Accept header
     *
     * @param  ViewEvent $e
     * @return null|XmlRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();

        if (!$model instanceof XmlModel) {
            // no XmlModel; do nothing
            return;
        }

        // XmlModel found
        return $this->renderer;
    }

    /**
     * Inject the response with the JSON payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
       $renderer = $e->getRenderer();

        if ($renderer !== $this->renderer) {

            // Discovered renderer is not ours; do nothing
            return;
        }

        $result = $e->getResult();

        if (! is_string($result)) {

            // We don't have a string, and thus, no JSON
            return;
        }

        $model = $e->getModel();

        // Populate response
        $response = $e->getResponse();
        $response->setContent($result);

        $response->getHeaders()
                 ->addHeaderLine('Content-Type', 'application/xml; charset=' . $model->getEncoding() . ';');
    }
}
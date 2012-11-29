# AP_XmlStrategy
Version 1.0.0 created by Alessandro Pietrobelli

## Description
Like the latest changes on Zend Framework 2.0.4 version, AP_XmlStrategy select the Xml Render if the ViewModel is  an XmlModel or if the Accept header contains "application/xml" media type.
Using the new controller plugin __acceptableViewModelSelector()__ you can select and set the appropriate ViewModel if Accept header meets criteria you specify

## Require
PHP >= 5.3.3

Zend Framework >= 2.0.4

## Installation
### with Composer
Add ```"ap/ap-xml-strategy": "dev-master"``` to your composer.json file and run ```php composer.phar update```.
### with Git submodule
Clone this project to your ```./vendor/`` directory:
```
git submodule add git://github.com/alessandropietrobelli/AP_XmlStrategy.git vendor/AP_XmlStrategy
```

### enable it on your application.config.php file

```php
<?php
return array(
    'modules' => array(
        // ...
        'AP_XmlStrategy',
    ),
    // ...
);
```



## Post Installation
Like on Zend Framework 2.0.4 change log example
```php
<?php
namespace SomeNamespace\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\FeedModel;
use AP_XmlStrategy\View\Model\XmlModel;

class SomeController extends AbstractActionController
{
    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
        'Zend\View\Model\FeedModel' => array(
            'application/rss+xml',
        ),
        'AP_XmlStrategy\View\Model\XmlModel' => array(
            'application/xml',
        ),
    );

    public function apiAction()
    {
        $viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
        
        if ($viewModel instanceof JsonModel) {
            return new JsonModel(array(
                'response' => 'foo',
                )
            );
        }

        if ($viewModel instanceof FeedModel) {
            return new FeedModel(array( 
                'response' => 'foo',
                )
            );
        }

        if ($viewModel instanceof XmlModel){
            return new XmlModel(array( 
                'response' => 'foo',
                )
            );
        }
    }
}
```


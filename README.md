# TBoileauFormHandlerBundle

[![Build Status](https://travis-ci.org/TBoileau/form-handler.svg?branch=master)](https://travis-ci.org/TBoileau/form-handler)
[![Maintainability](https://api.codeclimate.com/v1/badges/b685be5052504609e68c/maintainability)](https://codeclimate.com/github/TBoileau/form-handler/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b685be5052504609e68c/test_coverage)](https://codeclimate.com/github/TBoileau/form-handler/test_coverage)

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require tboileau/form-handler
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
<?php
// config/bundles.php

// ...

return [
    // ...
    TBoileau\FormHandlerBundle\TBoileauFormHandlerBundle::class => ["all" => true],
    // ...
];
```

## Create a new form handler

### Step 1: Create your new form handler

```php
<?php
// src/Form/Handler/FooHandler.php

namespace App\Form\Handler;

use App\Form\FooType;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooHandler implements FormHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $options)
    {
        $options->setDefaults([
            "form_type" => FooType::class,
            "form_options" => []
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {
        // Put your logic here
    }
}
```

If you have to pass some options to your form, you must add `form_options` in the `$resolver` in `configure`.

## Inject service in your form handler

If you need to inject some services in your form handler, you must to define your form handler in `config/services.yaml` and tag your new service with `tboileau.form_handler.handler`.

Example :
```php
<?php
// src/Form/Handler/FooHandler.php

namespace App\Form\Handler;

use App\Form\FooType;
use Doctrine\ORM\EntityManagerInterface;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooHandler implements FormHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * FooHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $options)
    {
        $options->setDefaults([
            "form_type" => FooType::class,
            "form_options" => []
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {
        // Put your logic here
    }
}
```

```yaml
# config/services.yaml
# ...
services:
    # ...
    App\Form\Handler\TestHandler:
        tags:
            - { name: tboileau.form_handler.handler }
    # ...
```

If you don't want to declare each of your form handler :

```yaml
# config/services.yaml
# ...
services:
    # ...
    App\Form\Handler\:
        resource: '../src/Form/Handler/*'
        tags:
            - { name: tboileau.form_handler.handler }
  
    # ...
```

## Events

A lot of events are dispatched during form handling. 

You have 3 solutions to listen an event :

### With a callback
```php
<?php
// src/Form/Handler/FooHandler.php

// ...
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;

class FooHandler implements FormHandlerInterface
{
    // ...

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {
        // ...
    
        $formManager->addEventListener(FormHandlerEvents::PRE_CONFIGURE_FORM, function(FormHandlerEvent $formHandlerEvent){
            // Put some logic here 
        });
        
        // ...
    }
}
```

### With and EventListener
```php
<?php
// src/Form/Handler/FooHandler.php

// ...
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use App\EventListener\FooEventListener;

class FooHandler implements FormHandlerInterface
{
    // ...

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {
        // ...
    
        $formManager->addEventListener(FormHandlerEvents::PRE_CONFIGURE_FORM, new FooEventListener());
        
        // ...
    }
}
```

```php
<?php
// src/EventListener/FooEventListener.php

namespace App\EventListener\FooEventListener;

use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;

class FooEventListener
{
    // ...

    /**
     * {@inheritdoc}
     */
    public function onPreConfigureForm(FormHandlerEvent $formHandlerEvent): void
    {
        // Put some logic here
    }
}
```

** Don't forget to declare your `EventListener` in `config/services.yaml`.


### With and EventSubscriber
```php
<?php
// src/Form/Handler/FooHandler.php

// ...
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use App\EventListener\FooEventSubscriber;

class FooHandler implements FormHandlerInterface
{
    // ...

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {
        // ...
    
        $formManager->addEventSubscriber(FormHandlerEvents::PRE_CONFIGURE_FORM, new FooEventSubscriber());
        
        // ...
    }
}
```

```php
<?php
// src/EventListener/FooEventSubscriber.php

namespace App\EventListener\FooEventListener;

use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FooEventSubscriber implements EventSubscriberInterface
{
    // ...
    
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return [
            FormHandlerEvents::PRE_CONFIGURE_FORM => "onPreConfigureForm"
        ]
    }
    
    /**
     * {@inheritdoc}
     */
    public function onPreConfigureForm(FormHandlerEvent $formHandlerEvent): void
    {
        // Put some logic here
    }
}
```

### Events list

|                        Name                       |        FormHandlerEvents Constant       |
|:-------------------------------------------------:|:---------------------------------------:|
| tboileau_form_handler.events.pre_configure_form   | FormHandlerEvents::PRE_CONFIGURE_FORM   |
| tboileau_form_handler.events.pre_create_form"     | FormHandlerEvents::PRE_CREATE_FORM      |
| tboileau_form_handler.events.pre_handle_request   | FormHandlerEvents::PRE_HANDLE_REQUEST   |
| tboileau_form_handler.events.post_handle_request  | FormHandlerEvents::POST_HANDLE_REQUEST  |
| tboileau_form_handler.events.pre_process_handler  | FormHandlerEvents::PRE_PROCESS_HANDLER  |
| tboileau_form_handler.events.post_process_handler | FormHandlerEvents::POST_PROCESS_HANDLER |
| tboileau_form_handler.events.post_valid_form      | FormHandlerEvents::POST_VALID_FORM      |
| tboileau_form_handler.events.pre_create_view      | FormHandlerEvents::PRE_CREATE_VIEW      |

## Example in controller

To use your form handler, you need to inject in your controller the `FormManagerFactoryInterface`, and create a `FormManager` with your form handler in argument.

See an example :

```php
<?php
// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use TBoileau\FormHandlerBundle\Factory\FormManagerFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Handler\FooHandler;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(FormManagerFactoryInterface $formManagerFactory, Request $request)
    {
        $foo = new Foo();
        // We create a new FormManager with our FooHandler and a new Foo instance.
        // Handle the request
        $formManager = $formManagerFactory->createFormManager(FooHandler::class, $foo)->handle($request);
        
        // If the manager has tested the validity of the form and processed your logic
        if($formManager->hasSucceeded()) {
            // Put your logic here, like a redirection
        }
        
        return $this->render('default/index.html.twig', [
            // createView is just a shortcut of form's createView method
            'form' => $formManager->createView(),
        ]);
    }
}
```

You need to pass your handler class in first argument of `createFormManager`, and your data in he second argument.

## Tests

This bundle is fully tested and the coverage is 100%.

You can run the tests by executing the following command :
```console
$ vendor/bind/simple-phpunit vendor/tboileau/form-handler/src/Tests
``` 

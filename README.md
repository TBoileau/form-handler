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

You have two solutions to create a new form handler, generating with the maker or implementing manually.

**With the maker :**
```console
$ php bin/console make:form-handler NameOfYourHandler NameOfYourFormType
```

- `NameOfYourHandler` : Enter the name of your new form handler, without namespace and `Handler` suffix.
- `NameOfYourFormType` : Enter the name with namespace of your form type.

**The maker will generate your new form handler in `App\Form\Handler`.**

**Manually :**
```php
<?php
// src/Form/Handler/FooHandler.php

namespace App\Form\Handler;

use App\Form\FooType;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

class FooHandler implements FormHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $options)
    {
        $options->setFormType(FooType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function onSuccess(FormManagerInterface $formManager): void
    {
        // Put your logic here
    }
}
```

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
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

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
        $options->setFormType(FooType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function onSuccess(FormManagerInterface $formManager): void
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

## Tests

This bundle is fully tested and the coverage is 100%.

You can run the tests by executing the following command :
```console
$ vendor/bind/simple-phpunit vendor/tboileau/form-handler/src/Tests
``` 
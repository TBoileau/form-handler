<?php

namespace TBoileau\FormHandlerBundle\Factory;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Form\FormFactoryInterface;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManager;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

/**
 * Class FormManagerFactory
 * @package TBoileau\FormHandlerBundle\Factory
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormManagerFactory implements FormManagerFactoryInterface
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * FormManagerFactory constructor.
     * @param FormFactoryInterface $formFactory
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(FormFactoryInterface $formFactory, ServiceLocator $serviceLocator)
    {
        $this->formFactory = $formFactory;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function createFormManager(string $formHandler, $data = null): FormManagerInterface
    {
        if($this->serviceLocator->has($formHandler)) {
            return new FormManager($this->serviceLocator->get($formHandler), $this->formFactory, new OptionsResolver(), $data);
        }

        return new FormManager(new $formHandler(), $this->formFactory, new OptionsResolver(), $data);
    }

}
<?php

namespace TBoileau\FormHandlerBundle\Factory;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Manager\FormManager;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * FormManagerFactory constructor.
     * @param FormFactoryInterface $formFactory
     * @param ServiceLocator $serviceLocator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(FormFactoryInterface $formFactory, ServiceLocator $serviceLocator, EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->serviceLocator = $serviceLocator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function createFormManager(string $formHandler, $data = null): FormManagerInterface
    {
        if($this->serviceLocator->has($formHandler)) {
            return new FormManager($this->serviceLocator->get($formHandler), $this->formFactory, $this->eventDispatcher, new OptionsResolver(), $data);
        }

        return new FormManager(new $formHandler(), $this->formFactory, $this->eventDispatcher, new OptionsResolver(), $data);
    }

}
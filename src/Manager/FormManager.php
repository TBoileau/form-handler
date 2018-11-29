<?php

namespace TBoileau\FormHandlerBundle\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;

/**
 * Class FormManager
 * @package TBoileau\FormHandlerBundle\Manager
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormManager implements FormManagerInterface
{
    /**
     * @var FormHandlerInterface
     */
    private $formHandler;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var null|mixed
     */
    private $data;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var bool
     */
    private $processed = false;

    /**
     * @var array
     */
    private $options = [];

    /**
     * FormManager constructor.
     * @param FormHandlerInterface $formHandler
     * @param FormFactoryInterface $formFactory
     * @param EventDispatcherInterface $eventDispatcher
     * @param OptionsResolver $optionsResolver
     * @param null $data
     */
    public function __construct(FormHandlerInterface $formHandler, FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher, OptionsResolver $optionsResolver, $data = null)
    {
        $this->formHandler = $formHandler;
        $this->formFactory = $formFactory;
        $this->optionsResolver = $optionsResolver;
        $this->eventDispatcher = $eventDispatcher;
        $this->data = $data;

        $this->optionsResolver
            ->setRequired("form_type")
            ->setDefault("form_options", [])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormHandler(): FormHandlerInterface
    {
        return $this->formHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm(): ?FormInterface
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm(): FormManagerInterface
    {
        $options = [];

        $this->options = $this->optionsResolver->resolve($options);

        $this->form = $this->formFactory->create($this->options["form_type"], $this->data, $this->options["form_options"]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createView(): FormView
    {
        return $this->form->createView();
    }

    /**
     * {@inheritdoc}
     */
    public function isProcessed(): bool
    {
        return $this->processed;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request): FormManagerInterface
    {
        $event = new FormHandlerEvent($this);

        $this->eventDispatcher->dispatch(FormHandlerEvents::PRE_CONFIGURE_FORM, $event);

        $this->formHandler->configure($this->optionsResolver);

        $this->eventDispatcher->dispatch(FormHandlerEvents::PRE_CREATE_FORM, $event);

        $this->createForm();

        $this->eventDispatcher->dispatch(FormHandlerEvents::PRE_HANDLE_REQUEST, $event);

        $this->form->handleRequest($request);

        $this->eventDispatcher->dispatch(FormHandlerEvents::POST_HANDLE_REQUEST, $event);

        if($this->form->isSubmitted() and $this->form->isValid()) {
            $this->eventDispatcher->dispatch(FormHandlerEvents::PRE_PROCESS_HANDLER, $event);

            $this->formHandler->process($this);
            $this->processed = true;

            $this->eventDispatcher->dispatch(FormHandlerEvents::POST_PROCESS_HANDLER, $event);
        }

        $this->eventDispatcher->dispatch(FormHandlerEvents::POST_VALID_FORM, $event);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventListener(string $event, callable $listener): FormManagerInterface
    {
        $this->eventDispatcher->addListener($event, $listener);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventSubscriber(EventSubscriberInterface $eventSubscriber): FormManagerInterface
    {
        $this->eventDispatcher->addSubscriber($eventSubscriber);

        return $this;
    }
}
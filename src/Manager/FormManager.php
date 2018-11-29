<?php

namespace TBoileau\FormHandlerBundle\Manager;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

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
    private $hasSucceeded = false;

    /**
     * FormManager constructor.
     * @param FormHandlerInterface $formHandler
     * @param FormFactoryInterface $formFactory
     * @param OptionsResolver $resolver
     * @param null $data
     */
    public function __construct(FormHandlerInterface $formHandler, FormFactoryInterface $formFactory, OptionsResolver $resolver, $data = null)
    {
        $this->formHandler = $formHandler;
        $this->formFactory = $formFactory;
        $this->optionsResolver = $resolver;
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm(): FormManagerInterface
    {
        $this->form = $this->formFactory->create($this->optionsResolver->getFormType(), $this->data, $this->optionsResolver->getFormOptions());

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
    public function hasSucceeded(): bool
    {
        return $this->hasSucceeded;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request): FormManagerInterface
    {
        $this->formHandler->configure($this->optionsResolver);

        $this->createForm();

        $this->form->handleRequest($request);

        if($this->form->isSubmitted() and $this->form->isValid()) {
            $this->formHandler->onSuccess($this);
            $this->hasSucceeded = true;
        }

        return $this;
    }


}
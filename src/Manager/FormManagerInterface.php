<?php

namespace TBoileau\FormHandlerBundle\Manager;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;

/**
 * Interface FormManagerInterface
 * @package TBoileau\FormHandlerBundle\Manager
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface FormManagerInterface
{

    /**
     * Get form data
     *
     * @return mixed|null
     */
    public function getData();

    /**
     * Get form handler
     *
     * @return FormHandlerInterface
     */
    public function getFormHandler(): FormHandlerInterface;

    /**
     * Get form
     *
     * @return FormInterface|null
     */
    public function getForm(): ?FormInterface;

    /**
     * Create form view
     *
     * @return FormView
     */
    public function createView(): FormView;

    /**
     * Create form
     *
     * @return FormManagerInterface
     */
    public function createForm(): FormManagerInterface;

    /**
     * Check if the form handler has been processed
     *
     * @return bool
     */
    public function isProcessed(): bool;

    /**
     * Handle form
     *
     * @param Request $request
     * @return FormManagerInterface
     */
    public function handle(Request $request): FormManagerInterface;

    /**
     * Add event listener
     *
     * @param string $event
     * @param callable $listener
     * @return FormManagerInterface
     */
    public function addEventListener(string $event, callable $listener): FormManagerInterface;

    /**
     * Add event subscriber
     *
     * @param EventSubscriberInterface $eventSubscriber
     * @return FormManagerInterface
     */
    public function addEventSubscriber(EventSubscriberInterface $eventSubscriber): FormManagerInterface;
}
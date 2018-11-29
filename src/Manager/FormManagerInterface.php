<?php

namespace TBoileau\FormHandlerBundle\Manager;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface FormManagerInterface
 * @package TBoileau\FormHandlerBundle\Manager
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface FormManagerInterface
{
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
     * Form handler has succeeded to handle the form
     *
     * @return bool
     */
    public function hasSucceeded(): bool;

    /**
     * Handle form
     *
     * @param Request $request
     * @return FormManagerInterface
     */
    public function handle(Request $request): FormManagerInterface;
}
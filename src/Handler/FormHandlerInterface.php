<?php

namespace TBoileau\FormHandlerBundle\Handler;

use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

/**
 * Interface FormHandlerInterface
 * @package TBoileau\FormHandlerBundle\Handler
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface FormHandlerInterface
{
    /**
     * Triggered when the form is submitted and valid
     *
     * @param FormManagerInterface $formManager
     */
    public function onSuccess(FormManagerInterface $formManager): void;

    /**
     * Return the form type class
     *
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver);
}
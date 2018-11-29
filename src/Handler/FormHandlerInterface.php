<?php

namespace TBoileau\FormHandlerBundle\Handler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

/**
 * Interface FormHandlerInterface
 * @package TBoileau\FormHandlerBundle\Handler
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface FormHandlerInterface
{
    /**
     * Triggered when the form is submitted and valid, process the logic
     *
     * @param FormManagerInterface $formManager
     */
    public function process(FormManagerInterface $formManager): void;

    /**
     * Return the form type class
     *
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver);
}
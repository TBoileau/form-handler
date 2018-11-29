<?php

namespace TBoileau\FormHandlerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

/**
 * Class FormHandlerEvent
 * @package TBoileau\FormHandlerBundle\Event
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerEvent extends Event
{
    /**
     * @var FormManagerInterface
     */
    private $formManager;

    /**
     * FormHandlerEvent constructor.
     * @param FormManagerInterface $formManager
     */
    public function __construct(FormManagerInterface $formManager)
    {
        $this->formManager = $formManager;
    }

    /**
     * @return FormManagerInterface
     */
    public function getFormManager(): FormManagerInterface
    {
        return $this->formManager;
    }
}
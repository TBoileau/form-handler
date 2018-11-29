<?php

namespace TBoileau\FormHandlerBundle\Tests\Form\Handler;

use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Tests\Form\Type\TestType;

/**
 * Class TestHandler
 * @package TBoileau\FormHandlerBundle\Tests\Form\Handler
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TestHandler implements FormHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onSuccess(FormManagerInterface $formManager): void
    {

    }

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setFormType(TestType::class);
    }

}
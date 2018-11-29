<?php

namespace TBoileau\FormHandlerBundle\Tests\Form\Handler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
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
    public function process(FormManagerInterface $formManager): void
    {

    }

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefault("form_type", TestType::class);
    }

}
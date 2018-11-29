<?php

namespace TBoileau\FormHandlerBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Factory\FormManagerFactory;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Tests\Form\Handler\TestHandler;

/**
 * Class FormManagerFactoryTest
 * @package TBoileau\FormHandlerBundle\Tests
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormManagerFactoryTest extends TestCase
{
    public function testCreateFormManager()
    {
        $formFactory = $this->createMock(FormFactoryInterface::class);

        $handler = $this->createMock(FormHandlerInterface::class);

        $dispatcher = $this->createMock(EventDispatcherInterface::class);

        $serviceLocator = $this->createMock(ServiceLocator::class);

        $serviceLocator
            ->method("has")
            ->willReturn(true)
        ;

        $serviceLocator
            ->method("get")
            ->willReturn($handler)
        ;

        $formManager = new FormManagerFactory($formFactory, $serviceLocator, $dispatcher);

        $this->assertInstanceOf(FormManagerInterface::class, $formManager->createFormManager(""));

        $serviceLocator = $this->createMock(ServiceLocator::class);

        $formManager = new FormManagerFactory($formFactory, $serviceLocator, $dispatcher);

        $this->assertInstanceOf(FormManagerInterface::class, $formManager->createFormManager(TestHandler::class));
    }
}
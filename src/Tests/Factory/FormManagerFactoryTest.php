<?php

namespace TBoileau\FormHandlerBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Form\FormFactoryInterface;
use TBoileau\FormHandlerBundle\Factory\FormManagerFactory;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;
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

        $serviceLocator = $this->createMock(ServiceLocator::class);

        $optionsResolver = $this->createMock(OptionsResolver::class);

        $serviceLocator
            ->method("has")
            ->willReturn(true)
        ;

        $serviceLocator
            ->method("get")
            ->willReturn($handler)
        ;

        $formManager = new FormManagerFactory($formFactory, $serviceLocator, $optionsResolver);

        $this->assertInstanceOf(FormManagerInterface::class, $formManager->createFormManager(""));

        $serviceLocator = $this->createMock(ServiceLocator::class);

        $formManager = new FormManagerFactory($formFactory, $serviceLocator);

        $this->assertInstanceOf(FormManagerInterface::class, $formManager->createFormManager(TestHandler::class));
    }
}
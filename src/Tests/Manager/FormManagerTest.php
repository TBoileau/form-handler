<?php

namespace TBoileau\FormHandlerBundle\Tests\Manager;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\RequestHandlerInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManager;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Store\FormHandlerEvents;
use TBoileau\FormHandlerBundle\Tests\Form\Handler\TestHandler;

/**
 * Class FormManagerTest
 * @package TBoileau\FormHandlerBundle\Tests\Manager
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormManagerTest extends TestCase
{
    /**
     * @var FormManagerInterface
     */
    private $formManager;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $formHandler = new TestHandler();

        $formConfig = $this->createMock(FormConfigInterface::class);

        $resolvedFormType = $this->createMock(ResolvedFormTypeInterface::class);

        $formView = $this->createMock(FormView::class);

        $requestHandler = $this->createMock(RequestHandlerInterface::class);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $resolvedFormType
            ->method("createView")
            ->willReturn($formView)
        ;

        $formConfig
            ->method("getInheritData")
            ->willReturn(null)
        ;

        $formConfig
            ->method("getType")
            ->willReturn($resolvedFormType)
        ;

        $formConfig
            ->method("getRequestHandler")
            ->willReturn($requestHandler)
        ;

        $formConfig
            ->method("getOptions")
            ->willReturn([])
        ;

        $formConfig
            ->method("getEventDispatcher")
            ->willReturn($eventDispatcher)
        ;

        $formConfig
            ->method("getModelTransformers")
            ->willReturn([])
        ;

        $this->form = new Form($formConfig);

        $formFactory = $this->createMock(FormFactoryInterface::class);

        $formFactory
            ->method("create")
            ->willReturn($this->form);

        $optionsResolver = new OptionsResolver();

        $formHandler->configure($optionsResolver);

        $this->formManager = new FormManager($formHandler, $formFactory, $eventDispatcher, $optionsResolver);
    }

    public function testAddSubscriber()
    {
        $subscriber = $this->createMock(EventSubscriberInterface::class);

        $this->assertInstanceOf(FormManagerInterface::class, $this->formManager->addEventSubscriber($subscriber));
    }

    public function testAddListener()
    {
        $this->assertInstanceOf(FormManagerInterface::class, $this->formManager->addEventListener(FormHandlerEvents::PRE_CONFIGURE_FORM, function(FormHandlerEvent $formHandlerEvent) { }));
    }

    public function testHandle()
    {
        $request = $this->createMock(Request::class);

        $this->assertInstanceOf(FormManagerInterface::class, $this->formManager->handle($request));

        $this->form->submit([]);

        $this->assertInstanceOf(FormManagerInterface::class, $this->formManager->handle($request));

        $this->assertTrue($this->formManager->isProcessed());
    }

    public function testCreateViewAndForm()
    {
        $this->assertNull($this->formManager->getData());

        $this->assertInstanceOf(FormHandlerInterface::class, $this->formManager->getFormHandler());

        $this->assertInstanceOf(FormManagerInterface::class, $this->formManager->createForm());

        $this->assertInstanceOf(FormView::class, $this->formManager->createView());

        $this->assertInstanceOf(FormInterface::class, $this->formManager->getForm());

    }
}
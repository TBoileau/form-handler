<?php

namespace TBoileau\FormHandlerBundle\Tests\Event;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use TBoileau\FormHandlerBundle\Event\FormHandlerEvent;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

/**
 * Class FormHandlerEventTest
 * @package TBoileau\FormHandlerBundle\Tests\Event
 */
class FormHandlerEventTest extends TestCase
{
    public function testGetFormManager()
    {
        $formManager = $this->createMock(FormManagerInterface::class);

        $event = new FormHandlerEvent($formManager);

        $this->assertEquals($formManager, $event->getFormManager());
    }
}
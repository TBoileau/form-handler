<?php

namespace TBoileau\FormHandlerBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TBoileau\FormHandlerBundle\DependencyInjection\TBoileauFormHandlerExtension;

/**
 * Class TBoileauFormHandlerExtensionTest
 * @package TBoileau\FormHandlerBundle\Tests\DependencyInjection
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauFormHandlerExtensionTest extends TestCase
{
    public function testLoad()
    {
        $container = $this->createMock(ContainerBuilder::class);

        $extension = new TBoileauFormHandlerExtension();

        $this->assertNull($extension->load([], $container));
    }
}
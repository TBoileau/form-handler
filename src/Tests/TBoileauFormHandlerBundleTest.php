<?php

namespace TBoileau\FormHandlerBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TBoileau\FormHandlerBundle\TBoileauFormHandlerBundle;

/**
 * Class TBoileauFormHandlerBundleTest
 * @package TBoileau\FormHandlerBundle\Tests
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauFormHandlerBundleTest extends TestCase
{
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);

        $bundle = new TBoileauFormHandlerBundle();

        $this->assertNull($bundle->build($container));
    }
}
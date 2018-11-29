<?php

namespace TBoileau\FormHandlerBundle\Tests\DependencyInjection\CompilerPass;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use TBoileau\FormHandlerBundle\DependencyInjection\Compiler\FormHandlerPass;

/**
 * Class FormHandlerPassTest
 * @package TBoileau\FormHandlerBundle\Tests\DependencyInjection\CompilerPass
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerPassTest extends TestCase
{
    public function testProcess()
    {
        $container = $this->createMock(ContainerBuilder::class);

        $definition = $this->createMock(Definition::class);

        $container
            ->method("getDefinition")
            ->willReturn($definition)
        ;

        $container
            ->method("findTaggedServiceIds")
            ->willReturn([
                "id" => ["tag"]
            ])
        ;

        $pass = new FormHandlerPass();

        $this->assertNull($pass->process($container));
    }
}
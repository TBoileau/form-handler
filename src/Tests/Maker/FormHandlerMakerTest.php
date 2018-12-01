<?php

namespace TBoileau\FormHandlerBundle\Tests\Maker;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TBoileau\FormHandlerBundle\Maker\FormHandlerMaker;

/**
 * Class FormHandlerMakerTest
 * @package TBoileau\FormHandlerBundle\Tests\Maker
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerMakerTest extends TestCase
{
    public function testGetCommandName()
    {
        $this->assertEquals('make:form-handler', FormHandlerMaker::getCommandName());
    }

    public function testConfigureCommand()
    {
        $maker = new FormHandlerMaker();

        $command = new Command();

        $config = new InputConfiguration();

        $this->assertNull($maker->configureCommand($command, $config));
    }

    public function testInteract()
    {
        $maker = new FormHandlerMaker();

        $input = $this->createMock(InputInterface::class);

        $output = $this->createMock(OutputInterface::class);
        $output
            ->method("getFormatter")
            ->willReturn($this->createMock(OutputFormatterInterface::class))
        ;

        $console = new ConsoleStyle(
            $this->createMock(InputInterface::class),
            $output
        );

        $command = new Command();

        $this->assertNull($maker->interact($input, $console, $command));
    }

    public function testConfigureDependencies()
    {
        $maker = new FormHandlerMaker();

        $builder = new DependencyBuilder();

        $this->assertEquals([], $maker->configureDependencies($builder));
    }

    public function testGenerate()
    {
        $maker = new FormHandlerMaker();

        $input = $this->createMock(InputInterface::class);

        $input
            ->method("getArgument")
            ->willReturn("")
        ;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->method("getFormatter")
            ->willReturn($this->createMock(OutputFormatterInterface::class))
        ;

        $console = new ConsoleStyle(
            $this->createMock(InputInterface::class),
            $output
        );

        $generator = $this->createMock(Generator::class);

        $details = new ClassNameDetails("","","");

        $generator
            ->method("createClassNameDetails")
            ->willReturn($details)
        ;

        $this->assertNull($maker->generate($input, $console, $generator));
    }
}
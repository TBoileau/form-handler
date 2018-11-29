<?php

namespace TBoileau\FormHandlerBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class FormHandlerMaker
 * @package TBoileau\FormHandlerBundle\Marker
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerMaker extends AbstractMaker
{
    /**
     * {@inheritdoc}
     */
    public static function getCommandName(): string
    {
        return 'make:form-handler';
    }

    /**
     * {@inheritdoc}
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription("Create a new form handler class")
            ->addArgument('form-handler-class', InputArgument::REQUIRED, 'Choose a name for your form handler class (e.g. <fg=yellow>FooHandler</>)')
            ->addArgument('form-type', InputArgument::OPTIONAL, 'Enter the form type class attach to this handler (e.g. <fg=yellow>FooType</>)')

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        if(!class_exists($input->getArgument("form-type"))) {
            $question = new Question("Enter the form type class attach to this handler (e.g. <fg=yellow>FooType</>)");
            $input->setArgument('form-type', $io->askQuestion($question));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $handlerClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('form-handler-class'),
            'Form\\Handler\\',
            'Handler'
        );
        $generator->generateClass(
            $handlerClassNameDetails->getFullName(),
            __DIR__.'/../Resources/skeleton/handler.tpl.php',
            [
                "formName" => $input->getArgument("form-type"),
                "formShortName" => substr($input->getArgument("form-type"), strrpos($input->getArgument("form-type"), "\\") + 1)
            ]
        );

        $generator->writeChanges();
        $this->writeSuccessMessage($io);
    }

}
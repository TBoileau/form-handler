<?php

namespace TBoileau\FormHandlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FormHandlerPass
 * @package TBoileau\FormHandlerBundle\DependencyInjection\Compiler
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $formManagerFactory;

    /**
     * @var string
     */
    private $formHandlerTag;

    /**
     * FormHandlerPass constructor.
     * @param string $formManagerFactory
     * @param string $formHandlerTag
     */
    public function __construct(string $formManagerFactory = "tboileau.form_handler.manager_factory", string $formHandlerTag = "tboileau.form_handler.handler")
    {
        $this->formManagerFactory = $formManagerFactory;
        $this->formHandlerTag = $formHandlerTag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition($this->formManagerFactory);

        $definition->replaceArgument(2, $this->processFormHandler($container));
    }

    /**
     * @param ContainerBuilder $container
     * @return Reference
     */
    private function processFormHandler(ContainerBuilder $container): Reference
    {
        $servicesMap = [];

        foreach ($container->findTaggedServiceIds($this->formHandlerTag, true) as $serviceId => $tag) {
            $serviceDefinition = $container->getDefinition($serviceId);
            $servicesMap[$formType = $serviceDefinition->getClass()] = new Reference($serviceId);
        }

        return ServiceLocatorTagPass::register($container, $servicesMap);
    }

}

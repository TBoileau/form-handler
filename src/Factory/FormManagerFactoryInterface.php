<?php

namespace TBoileau\FormHandlerBundle\Factory;

use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use TBoileau\FormHandlerBundle\Exception\FormHandlerNotFoundException;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManager;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

/**
 * Class FormManagerFactoryInterface
 * @package TBoileau\FormHandlerBundle\Factory
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface FormManagerFactoryInterface
{
    /**
     * Create form manager
     * @param string $formHandlerClass
     * @param null $data
     * @return FormManagerInterface
     * @throws FormHandlerNotFoundException
     * @throws \ReflectionException
     */
    public function createFormManager(string $formHandlerClass, $data = null): FormManagerInterface;
}
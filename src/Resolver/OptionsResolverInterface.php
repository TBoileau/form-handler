<?php

namespace TBoileau\FormHandlerBundle\Resolver;

use TBoileau\FormHandlerBundle\Exception\FormTypeNotFoundException;

/**
 * Interface OptionsResolverInterface
 * @package TBoileau\FormHandlerBundle\Resolver
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface OptionsResolverInterface
{
    /**
     * @return string
     * @throws FormTypeNotFoundException
     */
    public function getFormType(): string;

    /**
     * @param string $formType
     * @return OptionsResolverInterface
     * @throws FormTypeNotFoundException
     * @throws \ReflectionException
     */
    public function setFormType(string $formType): self;

    /**
     * @return array
     */
    public function getFormOptions(): array;

    /**
     * @param array $options
     * @return OptionsResolverInterface
     */
    public function setFormOptions(array $options = []): self;
}
<?php

namespace TBoileau\FormHandlerBundle\Resolver;

use Symfony\Component\Form\FormTypeInterface;
use TBoileau\FormHandlerBundle\Exception\FormTypeNotFoundException;

/**
 * Class OptionsResolver
 * @package TBoileau\FormHandlerBundle\Resolver
 * @author Thomas Boileau <t-boileau@email.com>
 */
class OptionsResolver implements OptionsResolverInterface
{
    /**
     * @var string
     */
    private $formType;

    /**
     * @var array
     */
    private $formOptions = [];

    /**
     * {@inheritdoc}
     */
    public function getFormType(): string
    {
        if($this->formType === null) {
            throw new FormTypeNotFoundException("Form type not found.");
        }

        return $this->formType;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormType(string $formType): OptionsResolverInterface
    {
        $reflectionClass = new \ReflectionClass($formType);

        if(!in_array(FormTypeInterface::class, $reflectionClass->getInterfaceNames())) {
            throw new FormTypeNotFoundException(sprintf("%s does not implement %s.", $formType, FormTypeInterface::class));
        }

        $this->formType = $formType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormOptions(): array
    {
        return $this->formOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormOptions(array $options = []): OptionsResolverInterface
    {
        $this->formOptions = $options;

        return $this;
    }
}
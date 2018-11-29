<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $formName ?>;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;

class <?= $class_name ?> implements FormHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $options)
    {
        $options->setFormType(<?= $formShortName ?>::class);
    }

    /**
     * {@inheritdoc}
     */
    public function onSuccess(FormManagerInterface $formManager): void
    {

    }
}
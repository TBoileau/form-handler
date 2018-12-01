<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $formName ?>;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Handler\FormHandlerInterface;
use TBoileau\FormHandlerBundle\Manager\FormManagerInterface;

class <?= $class_name ?> implements FormHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $options)
    {
        $options->setDefault("form_type", <?= $formShortName ?>::class);
    }

    /**
     * {@inheritdoc}
     */
    public function process(FormManagerInterface $formManager): void
    {

    }
}
<?php

namespace TBoileau\FormHandlerBundle\Tests\Resolver;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use TBoileau\FormHandlerBundle\Exception\FormTypeNotFoundException;
use TBoileau\FormHandlerBundle\Resolver\OptionsResolver;
use TBoileau\FormHandlerBundle\Tests\Form\Type\TestType;

/**
 * Class OptionsResolverTest
 * @package TBoileau\FormHandlerBundle\Tests\Resolver
 * @author Thomas Boileau <t-boileau@email.com>
 */
class OptionsResolverTest extends TestCase
{
    /**
     * @expectedException \TBoileau\FormHandlerBundle\Exception\FormTypeNotFoundException
     * @throws FormTypeNotFoundException
     * @throws \ReflectionException
     */
    public function testFormType()
    {
        $optionsResolver = new OptionsResolver();

        $this->assertEquals($optionsResolver, $optionsResolver->setFormType(TestType::class));

        $this->assertEquals(TestType::class, $optionsResolver->getFormType());

        $this->assertEquals($optionsResolver, $optionsResolver->setFormType(\stdClass::class));
    }

    /**
     * @expectedException \TBoileau\FormHandlerBundle\Exception\FormTypeNotFoundException
     * @throws FormTypeNotFoundException
     */
    public function testFormTypeFail()
    {
        $optionsResolver = new OptionsResolver();

        $this->assertNull(TestType::class, $optionsResolver->getFormType());
    }

    public function testFormOptions()
    {
        $optionsResolver = new OptionsResolver();

        $this->assertEquals($optionsResolver, $optionsResolver->setFormOptions([]));

        $this->assertEquals([], $optionsResolver->getFormOptions([]));
    }
}
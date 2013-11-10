<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Register form type
 */
class RegisterType extends AbstractType
{

    const NAME = 'register';
    const EMAIL_FIELD_NAME = 'email';
    const PASSWORD_FIELD_NAME = 'password';
    const CONFIRM_PASSWORD_FIELD_NAME = 'confirmPassword';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::EMAIL_FIELD_NAME, 'text')
            ->add(self::PASSWORD_FIELD_NAME, 'password')
            ->add(self::CONFIRM_PASSWORD_FIELD_NAME, 'password');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

}
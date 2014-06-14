<?php

namespace Drakkar\TestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text',array(
                'label' => 'Nombre de usuario'
            ))
            ->add('email', 'email',array(
                'label' => 'Dirección de correo'
            ))
            ->add('password', 'repeated', array(
                'first_name'  => 'password',
                'second_name' => 'confirm',
                'type'        => 'password',
                'label' => 'Contraseña'
             ))
            ->add('role', 'entity', array(
                'class' => 'DrakkarTestBundle:Role',
                'label' => 'Rol de usuario',
                'property' => 'role'
            ))
            ->add('save', 'submit')
            ;
    }

    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Drakkar\TestBundle\Entity\User',
        ));
    }
}
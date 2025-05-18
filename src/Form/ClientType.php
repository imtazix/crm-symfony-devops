<?php

namespace App\Form;

use App\Dto\ClientDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomGerant', TextType::class)
            ->add('raisonSociale', TextType::class)
            ->add('telephone', TextType::class)
            ->add('adresse', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientDto::class,
        ]);
    }
}

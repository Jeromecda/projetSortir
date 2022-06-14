<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            // ->add('mail')
            // ->add('mot_de_passe')
            ->add('administrateur')
            ->add('actif')
            ->add('inscription', EntityType::class, 
            ['class'=>Site::class, 
            'choice_label'=>'nom', 
            'mapped' => false ])
            ->add('siteNoSite', EntityType::class, 
            ['class'=>Site::class, 
            'choice_label'=>'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
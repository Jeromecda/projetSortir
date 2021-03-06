<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
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
            // ->add('inscription', EntityType::class, 
            // ['class'=>Sortie::class, 
            // 'choice_label'=>'nom', 
            // 'mapped' => false ])
            ->add('siteNoSite', EntityType::class, 
            ['class'=>Site::class, 
            'choice_label'=>'nom'])
            // ->add('administrateur')
            // ->add('actif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('datedebut')
            ->add('duree')
            ->add('datecloture')
            ->add('nbinscriptionsmax')
            ->add('descriptioninfos')
            ->add('urlPhoto')
            ->add('etatNoEtat', EntityType::class, 
            ['class'=>Etat::class, 
            'choice_label'=>'libelle'])
            ->add('lieuNolieu', EntityType::class, 
            ['class'=>Lieu::class, 
            'choice_label'=>'nom'])
            ->add('participants', EntityType::class, 
            ['class'=>Participant::class, 
            'choice_label'=>'nom',
            'mapped' => false])
            ->add('organisateur', EntityType::class, 
            ['class'=>Participant::class, 
            'choice_label'=>'nom',
            'mapped' => false])
            ->add('siteOrganisateur', EntityType::class, 
            ['class'=>Site::class, 
            'choice_label'=>'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}

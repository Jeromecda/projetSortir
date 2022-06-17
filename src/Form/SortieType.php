<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('datedebut', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('duree', NumberType::class)
            ->add('datecloture',  DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('nbinscriptionsmax')
            ->add('descriptioninfos')
            // ->add('urlPhoto')
            // ->add('etatNoEtat', EntityType::class, 
            // ['class'=>Etat::class, 
            // 'choice_label'=>'libelle'])
            // ->add('participants', EntityType::class, 
            // ['class'=>Participant::class, 
            // 'choice_label'=>'nom',
            // 'mapped' => false])
            ->add(
                'siteOrganisateur',
                EntityType::class,
                [
                    'class' => Site::class,
                    'choice_label' => 'nom'
                ]
            )
            // ->add(
            //     'lieuNolieu',
            //     EntityType::class,
            //     [
            //         'class' => Lieu::class,
            //         'choice_label' => 'nom'
            //     ]
            // )
            ->add(
                'ville',
                EntityType::class,
                [
                    'class' => Ville::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choississez une ville',
                    'mapped' => false
                ]
            );

        $builder->get('ville')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                // $data = $event->getData();            
                $form->getParent()->add('lieuNolieu', EntityType::class, [
                    'class' => Lieu::class,
                    'placeholder' => 'Choississez un lieu',
                    'choice_label' => 'nom',
                    'choices' => $form->getData()->getLieus()
                ]);
            }

        );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}

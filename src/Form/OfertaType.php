<?php

namespace App\Form;

use App\Entity\Oferta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class OfertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titol')
            ->add('resum', TextareaType::class, [
                'label' => 'Explica brevemente en que coniste la oferta',
                'attr' => ['class' => 'form-control', 'rows' => 3],
                'constraints' => [
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Fes una breu descricpió de l\'oferta de mínim {{ limit }} caràcters)',
                        'max' => 400,
                        'maxMessage' => 'El resum no pot ser tan llarg (maxim {{ limit }} caràcters)',
                    ])
                ],
            ])

            ->add('descripcio', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'required' => false
            ])
            ->add('dataPublicacio', DateType::class, [
                'label' => 'Fecha de publicacón de la oferta',
                'attr' => ['class' => 'form-inline'],
                'format' => 'dMy',
            ])

            ->add('requisits', CollectionType::class, [
                'required' => false,
                // Cada entrada ha de ser un <input type="text">
                'entry_type' => TextType::class,
            ])

            // ->add('empresa')
            // ->add('candidats')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oferta::class,
        ]);
    }
}

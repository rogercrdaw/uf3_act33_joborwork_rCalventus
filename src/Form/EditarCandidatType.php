<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class EditarCandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'text-info'],
            ])
            ->add('cognoms', TextType::class, [
                'label' => 'Cognoms',
                'label_attr' => ['class' => 'text-info'],
            ])
            ->add('telefon', NumberType::class, [
                'label' => 'Telefon de contacte',
                'label_attr' => ['class' => 'text-info'],
            ])
            ->add('estudis', CollectionType::class, [
                'label' => 'Quins estudis reglats tens finalitzats?',
                'label_attr' => ['class' => 'text-info'],
                'required' => false,
                // Cada entrada ha de ser un <input type="text">
                'entry_type' => TextType::class,
            ])
            ->add('presentacio', TextareaType::class, [
                'label' => 'Una breu carta de presentació pot marcar la diferencia',
                'label_attr' => ['class' => 'text-info'],
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'required'   => false,
                'constraints' => [
                    new Length([
                        'max' => 1000,
                        'maxMessage' => 'La presentació ha de ser breu, no pot excedir els {{ limit }} caràcters',
                    ])
                ],
            ])
            ->add('softskills', CollectionType::class, [
                'label' => 'Quines son les teves principals aptituds?',
                'label_attr' => ['class' => 'text-info'],
                'required' => false,
                // Cada entrada ha de ser un <input type="text">
                'entry_type' => TextType::class,
            ])
            ->add('hardskills', CollectionType::class, [
                'label' => 'Hard Skills',
                'label_attr' => ['class' => 'text-info'],
                'required' => false,
                // Cada entrada ha de ser un <input type="text">
                'entry_type' => TextType::class,
            ])

            // ->add('usuari')
            // ->add('ofertas')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}

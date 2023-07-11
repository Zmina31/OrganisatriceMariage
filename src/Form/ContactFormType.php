<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserFormType::class,[
                'label'=>' ',
            ])
            ->add('date', DateType::class,[
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('ville')
            ->add('invite', null,[
                "label" => 'Nombres invités'
            ])
            ->add('destination', ChoiceType::class,[
                'choices' => [
                    'Rhône-Alpes' => 'Rhône-Alpes',
                    'Loire' => 'Loire',
                    'Isère' => 'Isère',
                    'Drôme' => 'Drôme'
                ],
                'multiple' => false
            ])
            ->add('budget')
            ->add('precisions')
            ->add('prestation', EntityType::class,[
                'class' =>'App\Entity\Prestation',
                'choice_label' => 'nom',
                'label' => 'Prestation',
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
